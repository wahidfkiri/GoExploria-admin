<?php

namespace Vendor\Cms\Support;

use App\Models\Activity;
use Illuminate\Support\Str;

/**
 * Grille « Activités » d'un template CMS, remplie avec les activités que
 * l'établissement propose réellement.
 *
 * Même mécanique que [[TemplateProducts]] et [[TemplateCategories]] : le
 * template porte une grille marquée `data-gx-activities` et une carte modèle
 * `data-gx-activity`, dont les éléments sont annotés `data-gx-field`. Sans
 * activité rattachée, la grille garde sa démonstration — [[TemplateGrid]] s'en
 * charge — plutôt que d'afficher une section vide sur un site en ligne.
 *
 * Le lien d'une carte pointe vers la fiche publique de l'activité
 * (`/activity/{slug}`), qui existe déjà côté front : on ne crée pas une
 * seconde page détail par établissement.
 */
class TemplateActivities extends TemplateGrid
{
    protected function marqueur(): string
    {
        return 'data-gx-activities';
    }

    protected function marqueurCarte(): string
    {
        return 'data-gx-activity';
    }

    /**
     * Activités actives rattachées à cet établissement.
     *
     * Le rattachement passe par le pivot `activity_etablissement`, alimenté
     * depuis l'espace entreprise : une activité n'appartient pas à un
     * établissement, elle y est proposée.
     *
     * @return \Illuminate\Support\Collection<int, Activity>
     */
    protected function elements(int $limite, array $options)
    {
        $query = Activity::query()
            ->where('activities.is_active', true)
            ->with('categoryRelation:id,name')
            ->whereHas('etablissements', fn ($q) => $q->where('etablissements.id', $this->etablissementId));

        // Section restreinte à une catégorie : `data-gx-activities-category`
        // porte son nom, ce qui permet plusieurs grilles thématiques sur la
        // même page sans code supplémentaire.
        $categorie = trim((string) ($options['category'] ?? ''));

        if ($categorie !== '') {
            $query->whereHas('categoryRelation', fn ($q) => $q->where('name', $categorie));
        }

        return $query->orderBy('activities.name')->limit($limite)->get();
    }

    protected function remplirCarte(
        \DOMDocument $doc,
        \DOMXPath $xpath,
        \DOMElement $carte,
        $activite,
        array $options
    ): void {
        $carte->setAttribute('data-gx-activity-id', (string) $activite->id);

        $categorie = $activite->categoryRelation->name ?? null;
        $lien = $this->lien($activite);

        foreach ($this->champs($xpath, $carte) as $noeud) {
            switch ($noeud->getAttribute('data-gx-field')) {
                case 'image':
                    $this->poserImage($noeud, $this->image($activite), (string) $activite->name);
                    break;

                case 'name':
                    $this->poserTexte($doc, $noeud, (string) $activite->name);
                    break;

                case 'desc':
                    $this->poserTexte($doc, $noeud, $this->description($activite));
                    break;

                case 'category':
                    // Une activité sans catégorie ne doit pas laisser la
                    // pastille de démonstration : on la retire.
                    $categorie === null
                        ? $this->retirer($noeud)
                        : $this->poserTexte($doc, $noeud, $categorie);
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

        // La carte entière peut être cliquable.
        if ($lien !== null && $carte->tagName === 'a') {
            $carte->setAttribute('href', $lien);
        }
    }

    /**
     * Adresse publique de l'activité, si son slug le permet.
     */
    private function lien(Activity $activite): ?string
    {
        $slug = trim((string) $activite->slug);

        if ($slug === '') {
            return null;
        }

        try {
            return route('landing.activity.show', $slug);
        } catch (\Throwable $e) {
            // Route absente d'une installation partielle : mieux vaut une carte
            // sans lien qu'une page en erreur.
            return null;
        }
    }

    /**
     * Visuel de l'activité, ou null pour laisser celui de la démonstration.
     */
    private function image(Activity $activite): ?string
    {
        $chemin = trim((string) $activite->image);

        if ($chemin === '') {
            return null;
        }

        return Str::startsWith($chemin, ['http://', 'https://', '//'])
            ? $chemin
            : asset('storage/' . ltrim($chemin, '/'));
    }

    /**
     * Description courte, débarrassée de son balisage.
     */
    private function description(Activity $activite): string
    {
        $texte = trim(strip_tags((string) $activite->description));

        return $texte === ''
            ? 'Découvrez cette activité.'
            : Str::limit($texte, 130);
    }
}
