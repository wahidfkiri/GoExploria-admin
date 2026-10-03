<?php

namespace Vendor\Cms\Support;

use App\Models\Etablissement;
use App\Models\Region;
use App\Models\Ville;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Grille « Où aller » d'un gabarit : les DESTINATIONS où la catégorie se
 * pratique réellement.
 *
 * Même mécanique que [[TemplateActivities]] et [[TemplateEtablissements]] : le
 * gabarit porte une grille marquée `data-gx-destinations` et une carte modèle
 * `data-gx-destination`, dont les éléments sont annotés `data-gx-field`
 * (image | name | desc | category | link). Sans destination trouvée, la
 * grille garde sa démonstration — [[TemplateGrid]] s'en charge.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * D'OÙ VIENNENT LES DESTINATIONS
 * ─────────────────────────────────────────────────────────────────────────
 * Une catégorie n'est rattachée à aucun lieu : ce sont les ÉTABLISSEMENTS qui
 * situent ses activités. Le chemin est donc :
 *
 *     catégorie → ses activités actives
 *               → les établissements qui les proposent (pivot)
 *               → la ville (à défaut la région) de chaque établissement
 *
 * On compte les établissements par destination : « Québec — 7 établissements »
 * dit quelque chose, une liste de villes sans volume ne dit rien. Les
 * destinations sont classées par ce nombre, puis par nom.
 *
 * ⚠ `etablissements` porte SES PROPRES colonnes de rattachement (ville_id,
 * region_id…), distinctes de la table `etablissement_destinations` qu'utilise
 * [[TemplateEtablissements]] pour la descente d'une destination vers ses
 * établissements. Ici on remonte dans l'autre sens, et les colonnes directes
 * suffisent — elles sont renseignées par le formulaire de l'établissement.
 *
 * ⚠ Le site public nomme les villes « city » dans ses URL
 * (/travel-destination/city/{code}) alors que la table s'appelle `villes` :
 * même écart que TYPES_SITE côté TemplateEtablissements.
 */
class TemplateDestinations extends TemplateGrid
{
    /** Contexte CATÉGORIE : identifiant de la catégorie d'activités. */
    protected ?int $categorieId = null;

    /**
     * Contexte ACTIVITÉ : identifiant de l'activité.
     *
     * Renseigné par hydrateActivite(). La grille liste alors les destinations
     * où CETTE activité est proposée, et non celles de toute une catégorie.
     */
    protected ?int $activiteId = null;

    /** Nombre d'établissements retenus avant regroupement. */
    protected const PLAFOND_ETABLISSEMENTS = 2000;

    /**
     * Hydrate la rubrique « Où aller » de la page d'une CATÉGORIE.
     */
    public static function hydrateCategorie(string $html, ?int $categorieId): string
    {
        $instance = new static(0);

        // Sortie immédiate : la plupart des pages n'ont pas la grille.
        if ($categorieId === null || strpos($html, $instance->marqueur()) === false) {
            return $html;
        }

        try {
            $instance = new static(0);
            $instance->categorieId = (int) $categorieId;

            return $instance->parcourir($html);
        } catch (\Throwable $e) {
            // Une page affichée avec sa démonstration vaut mieux qu'une page
            // cassée.
            Log::warning(static::class . ' : hydratation abandonnée — ' . $e->getMessage(), [
                'categorie_id' => $categorieId,
            ]);

            return $html;
        }
    }

    /**
     * Hydrate la rubrique « Où aller » de la page d'une ACTIVITÉ.
     */
    public static function hydrateActivite(string $html, ?int $activiteId): string
    {
        $instance = new static(0);

        if ($activiteId === null || strpos($html, $instance->marqueur()) === false) {
            return $html;
        }

        try {
            $instance = new static(0);
            $instance->activiteId = (int) $activiteId;

            return $instance->parcourir($html);
        } catch (\Throwable $e) {
            Log::warning(static::class . ' : hydratation abandonnée — ' . $e->getMessage(), [
                'activity_id' => $activiteId,
            ]);

            return $html;
        }
    }

    protected function marqueur(): string
    {
        return 'data-gx-destinations';
    }

    protected function marqueurCarte(): string
    {
        return 'data-gx-destination';
    }

    /**
     * Options propres à cette grille, en plus de celles du socle.
     *
     * `data-gx-destinations-niveau="city"` restreint la grille à un niveau,
     * ce qui permet deux grilles sur la même page (les villes d'un côté, les
     * régions de l'autre) sans code supplémentaire.
     */
    protected function options(string $balise): array
    {
        $options = parent::options($balise);
        $options['niveau'] = '';

        if (preg_match('/\s' . preg_quote($this->marqueur() . '-niveau', '/')
            . '\s*=\s*("([^"]*)"|\'([^\']*)\')/i', $balise, $m)) {
            $options['niveau'] = strtolower(trim($m[2] ?? $m[3] ?? ''));
        }

        return $options;
    }

    /**
     * Destinations où les activités de la catégorie sont proposées.
     *
     * @return Collection<int, array{type:string, entite:object, nombre:int}>
     */
    protected function elements(int $limite, array $options)
    {
        if ($this->categorieId === null && $this->activiteId === null) {
            return collect();
        }

        $etablissements = $this->etablissementsPorteurs();

        if ($etablissements->isEmpty()) {
            return collect();
        }

        $niveau = $options['niveau'] ?? '';

        $lignes = collect()
            ->merge($niveau === 'region' ? [] : $this->parNiveau($etablissements, 'ville_id', 'city'))
            ->merge($niveau === 'city' ? [] : $this->parNiveau($etablissements, 'region_id', 'region'));

        // Une ville l'emporte sur sa région : afficher les deux ferait
        // compter deux fois les mêmes établissements. Les régions ne sont
        // donc proposées que si aucune ville n'a été trouvée, sauf si la
        // grille demande explicitement un niveau.
        if ($niveau === '' && $lignes->contains(fn (array $l) => $l['type'] === 'city')) {
            $lignes = $lignes->filter(fn (array $l) => $l['type'] === 'city')->values();
        }

        // Le plus fourni d'abord, puis par nom. ⚠ `sort()` avec un
        // comparateur explicite, et non `sortBy([...])` : la forme à
        // plusieurs critères de sortBy() attend des colonnes, pas des
        // comparateurs, et rendrait un classement arbitraire.
        return $lignes
            ->sort(function (array $a, array $b) {
                return ($b['nombre'] <=> $a['nombre'])
                    ?: strcasecmp((string) $a['entite']->name, (string) $b['entite']->name);
            })
            ->take($limite)
            ->values();
    }

    /**
     * Établissements actifs qui portent ce qu'on affiche : une activité ACTIVE
     * de la catégorie, ou l'activité elle-même.
     *
     * @return Collection<int, Etablissement>
     */
    protected function etablissementsPorteurs(): Collection
    {
        $requete = DB::table('activity_etablissement')
            ->join('activities', 'activities.id', '=', 'activity_etablissement.activity_id')
            ->where('activities.is_active', true);

        if ($this->activiteId !== null) {
            $requete->where('activities.id', $this->activiteId);
        } else {
            $requete->where('activities.categorie_id', $this->categorieId);
        }

        $ids = $requete
            ->distinct()
            ->limit(self::PLAFOND_ETABLISSEMENTS)
            ->pluck('activity_etablissement.etablissement_id');

        if ($ids->isEmpty()) {
            return collect();
        }

        return Etablissement::query()
            ->whereIn('id', $ids)
            ->where('is_active', true)
            ->get(['id', 'name', 'ville_id', 'region_id']);
    }

    /**
     * Regroupe les établissements par destination d'un niveau donné.
     *
     * @return array<int, array{type:string, entite:object, nombre:int}>
     */
    protected function parNiveau(Collection $etablissements, string $colonne, string $type): array
    {
        $comptes = $etablissements
            ->filter(fn (Etablissement $e) => (int) ($e->{$colonne} ?? 0) > 0)
            ->countBy(fn (Etablissement $e) => (int) $e->{$colonne});

        if ($comptes->isEmpty()) {
            return [];
        }

        $modele = $type === 'city' ? Ville::class : Region::class;

        try {
            $entites = $modele::query()
                ->whereIn('id', $comptes->keys()->all())
                ->where('is_active', true)
                ->get();
        } catch (\Throwable $e) {
            // Colonne `is_active` absente sur une installation partielle : on
            // réessaie sans elle plutôt que de perdre toute la rubrique.
            $entites = $modele::query()->whereIn('id', $comptes->keys()->all())->get();
        }

        return $entites
            ->map(fn ($entite) => [
                'type' => $type,
                'entite' => $entite,
                'nombre' => (int) $comptes->get($entite->id, 0),
            ])
            ->all();
    }

    protected function remplirCarte(
        \DOMDocument $doc,
        \DOMXPath $xpath,
        \DOMElement $carte,
        $ligne,
        array $options
    ): void {
        $entite = $ligne['entite'];
        $lien = $this->lien($ligne['type'], $entite);
        $niveau = $ligne['type'] === 'city' ? 'Ville' : 'Région';

        $carte->setAttribute('data-gx-destination-id', (string) $entite->id);
        $carte->setAttribute('data-gx-destination-type', $ligne['type']);
        // Même convention que la grille des établissements : le filtre du
        // gabarit compare cet attribut à data-plx-filtre.
        $carte->setAttribute('data-categorie', Str::slug($niveau));

        foreach ($this->champs($xpath, $carte) as $noeud) {
            switch ($noeud->getAttribute('data-gx-field')) {
                case 'image':
                    // Les tables de destination ne portent pas toutes un
                    // visuel : sans image, la photo de démonstration reste,
                    // ce qui vaut mieux qu'une carte trouée.
                    $this->poserImage($noeud, $this->image($entite), (string) $entite->name);
                    break;

                case 'name':
                    $this->poserTexte($doc, $noeud, (string) $entite->name);
                    break;

                case 'desc':
                    $this->poserTexte($doc, $noeud, $this->resume($ligne));
                    break;

                case 'category':
                    $this->poserTexte($doc, $noeud, $niveau);
                    break;

                case 'link':
                    if ($lien === null) {
                        $this->retirer($noeud);
                        break;
                    }

                    $noeud->setAttribute('href', $lien);
                    break;
            }
        }

        if ($lien !== null && $carte->tagName === 'a') {
            $carte->setAttribute('href', $lien);
        }
    }

    /**
     * Page publique de la destination.
     *
     * ⚠ Le segment de type est celui du SITE (« city » pour une ville), et
     * l'identifiant est le `code` quand il existe — c'est ce que résout
     * DestinationService::getVille(), qui retombe sur l'id pour une valeur
     * numérique.
     */
    protected function lien(string $type, $entite): ?string
    {
        $identifiant = trim((string) ($entite->code ?? '')) ?: (string) $entite->id;

        if ($identifiant === '') {
            return null;
        }

        return '/travel-destination/' . $type . '/' . rawurlencode($identifiant);
    }

    /**
     * « 7 établissements proposent… » : le volume dit plus que le nom seul.
     *
     * Le libellé suit le contexte : sur la page d'une activité on parle d'ELLE,
     * sur celle d'une catégorie on parle de ses activités.
     */
    protected function resume(array $ligne): string
    {
        $nombre = (int) $ligne['nombre'];
        $quoi = $this->activiteId !== null ? 'cette activité' : 'ces activités';

        return $nombre > 1
            ? $nombre . ' établissements proposent ' . $quoi . '.'
            : 'Un établissement propose ' . $quoi . '.';
    }

    /** Visuel de la destination, ou null pour garder celui de la démonstration. */
    protected function image($entite): ?string
    {
        foreach (['image', 'photo', 'cover_image'] as $champ) {
            $chemin = trim((string) ($entite->{$champ} ?? ''));

            if ($chemin === '') {
                continue;
            }

            return Str::startsWith($chemin, ['http://', 'https://', '//'])
                ? $chemin
                : asset('storage/' . ltrim($chemin, '/'));
        }

        return null;
    }
}
