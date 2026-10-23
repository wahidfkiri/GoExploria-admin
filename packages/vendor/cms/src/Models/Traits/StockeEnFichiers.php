<?php

namespace Vendor\Cms\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Vendor\Cms\Contenus\StockageContenus;
use Vendor\Cms\Contenus\Proprietaires;

/**
 * Rend le stockage des contenus transparent pour le reste du code.
 *
 * Établissement en mode « base » : rien ne change, la colonne est lue et
 * écrite comme avant.
 *
 * Établissement en mode « fichiers » :
 *  - lire `$page->content` rend la révision courante, relue du dépôt ;
 *  - enregistrer dépose le contenu dans le dépôt (AVANT l'écriture en base)
 *    et crée une révision ; la colonne, elle, n'est PAS réécrite : elle
 *    garde la copie d'avant la bascule (ou NULL une fois la base libérée).
 *
 * Seuls les champs réellement POSÉS (affectation, fill, update) partent au
 * dépôt : un modèle chargé puis enregistré pour un autre champ ne réécrit
 * jamais son contenu avec la vieille valeur de la colonne.
 *
 * ⚠ Les écritures par le constructeur de requêtes (DB::table()->update(),
 * Model::where()->update()) contournent les modèles et donc ce trait : en
 * mode « fichiers », elles modifieraient la colonne sans effet sur le site.
 * Les champs concernés sont listés dans StockageContenus::RESSOURCES.
 */
trait StockeEnFichiers
{
    /** @var array<string, true> champs posés depuis le chargement */
    protected array $contenusTouches = [];

    /** @var array<string, array> objets déjà déposés, en attente de leur révision */
    protected array $contenusPrepares = [];

    public static function bootStockeEnFichiers(): void
    {
        static::saving(function (Model $modele) {
            $modele->preparerContenusStockes();
        });

        static::saved(function (Model $modele) {
            $modele->enregistrerContenusStockes();
        });
    }

    /** @return list<string> */
    public function champsStockes(): array
    {
        return StockageContenus::RESSOURCES[static::class] ?? [];
    }

    /**
     * À qui appartient ce contenu : [classe, id], ou null (aucun propriétaire
     * = toujours en base). Par défaut l'établissement ; les modèles rangés
     * par `pageable_type` / `activity_id` redéfinissent cette méthode ET
     * filtrerParProprietaireContenus().
     *
     * @return array{0: string, 1: int}|null
     */
    public function proprietaireContenus(): ?array
    {
        $id = (int) $this->getAttribute('etablissement_id');

        return $id > 0 ? [Proprietaires::ETABLISSEMENT, $id] : null;
    }

    /** Lignes d'un propriétaire, ou null si ce modèle ne le concerne pas. */
    public static function filtrerParProprietaireContenus($requete, string $type, int $id)
    {
        return $type === Proprietaires::ETABLISSEMENT ? $requete->where('etablissement_id', $id) : null;
    }

    public function getContentAttribute($valeur)
    {
        return $this->contenuStocke('content', $valeur);
    }

    public function setContentAttribute($valeur): void
    {
        $this->poserContenu('content', $valeur);
    }

    public function getHtmlContentAttribute($valeur)
    {
        return $this->contenuStocke('html_content', $valeur);
    }

    public function setHtmlContentAttribute($valeur): void
    {
        $this->poserContenu('html_content', $valeur);
    }

    public function getCssContentAttribute($valeur)
    {
        return $this->contenuStocke('css_content', $valeur);
    }

    public function setCssContentAttribute($valeur): void
    {
        $this->poserContenu('css_content', $valeur);
    }

    public function getPageContentsAttribute($valeur)
    {
        return $this->contenuStocke('page_contents', $valeur);
    }

    public function setPageContentsAttribute($valeur): void
    {
        $this->poserContenu('page_contents', $valeur);
    }

    protected function contenuStocke(string $champ, $brut)
    {
        // Valeur tout juste posée : c'est elle que le code appelant attend.
        if (isset($this->contenusTouches[$champ]) || ! in_array($champ, $this->champsStockes(), true)) {
            return $brut;
        }

        [$trouve, $valeur] = StockageContenus::instance()->lireChamp($this, $champ);

        return $trouve ? $valeur : $brut;
    }

    protected function poserContenu(string $champ, $valeur): void
    {
        $this->attributes[$champ] = $valeur;

        if (in_array($champ, $this->champsStockes(), true)) {
            $this->contenusTouches[$champ] = true;
        }
    }

    /**
     * replicate() d'Eloquent recopie les COLONNES brutes : en mode « fichiers »,
     * la copie (bouton « Dupliquer » des pages) aurait reçu l'ancienne version
     * de la colonne, ou rien une fois la base libérée. On lui pose le contenu
     * réellement affiché, comme une édition : il part au dépôt à son save().
     */
    public function replicate(?array $except = null)
    {
        $copie = parent::replicate($except);

        foreach ($this->champsStockes() as $champ) {
            if (array_key_exists($champ, $copie->getAttributes())) {
                $copie->poserContenu($champ, $this->getAttribute($champ));
            }
        }

        return $copie;
    }

    public function preparerContenusStockes(): void
    {
        $this->contenusPrepares = [];

        if ($this->contenusTouches === []) {
            return;
        }

        $stockage = StockageContenus::instance();

        if (! $stockage->enFichiers(...($this->proprietaireContenus() ?? [null, null]))) {
            return; // mode « base » : la colonne est écrite comme avant
        }

        foreach (array_keys($this->contenusTouches) as $champ) {
            $valeur = $this->attributes[$champ] ?? null;
            $this->contenusPrepares[$champ] = $stockage->preparer($valeur === null ? null : (string) $valeur);

            // La colonne ne bouge pas.
            $this->attributes[$champ] = $this->getRawOriginal($champ);
        }

        // Le contenu a changé même si plus aucune colonne ne l'est : la date
        // de modification sert au tri (dernière région, pages récentes…).
        if ($this->usesTimestamps()) {
            $this->updateTimestamps();
        }
    }

    public function enregistrerContenusStockes(): void
    {
        $prepares = $this->contenusPrepares;
        $this->contenusPrepares = [];
        $this->contenusTouches = [];

        if ($prepares === []) {
            return;
        }

        $stockage = StockageContenus::instance();
        $auteurId = auth()->id();

        foreach ($prepares as $champ => $prepare) {
            $stockage->enregistrer($this, $champ, $prepare, 'editeur', $auteurId);
        }
    }
}
