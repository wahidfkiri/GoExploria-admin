<?php

namespace Vendor\Cms\Support;

use App\Models\ProductCategory;

/**
 * Remplit la section « Nos rayons » d'un template avec les catégories de
 * produits de l'établissement (espace entreprise → E-commerce → Nos rayons).
 *
 * Même contrat que [[TemplateProducts]], dont elle partage le socle
 * [[TemplateGrid]] : la grille porte `data-gx-categories`, la première carte
 * `data-gx-category` sert de modèle, les champs portent `data-gx-field`.
 *
 * Ne sont affichés que les rayons ACTIFS **et non vides** : un rayon annoncé
 * sur la page d'accueil qui mène à une liste vide est pire que pas de rayon du
 * tout. Un établissement sans rayon garde la démonstration du gabarit.
 *
 * Attributs reconnus sur le conteneur :
 *   data-gx-categories          active la section (valeur ignorée)
 *   data-gx-categories-limit    nombre max de rayons (déf. : nb de cartes)
 *   data-gx-categories-sort     order (déf.) | name | products
 *
 * Champs reconnus (`data-gx-field`) :
 *   image, name, desc, count, link
 */
class TemplateCategories extends TemplateGrid
{
    protected function marqueur(): string
    {
        return 'data-gx-categories';
    }

    protected function marqueurCarte(): string
    {
        return 'data-gx-category';
    }

    /** @return \Illuminate\Support\Collection<int,ProductCategory> */
    protected function elements(int $limite, array $options)
    {
        // Produits de CET établissement, publiés et en vente. Le filtre est
        // partagé par le comptage et par la condition d'existence : un rayon de
        // plateforme ne doit pas compter les produits d'un confrère.
        $siens = fn ($q) => $q
            ->where('etablissement_id', $this->etablissementId)
            ->where('is_public', true)
            ->where('is_available_for_sale', true);

        $query = ProductCategory::query()
            ->pourEtablissement($this->etablissementId)
            ->where('is_active', true)
            ->withCount(['products' => $siens])
            ->where(function ($q) use ($siens) {
                // Un rayon créé par le commerçant s'affiche dès sa création,
                // même sans produit : il vient de le créer dans son espace, ne
                // pas le voir apparaître sur le site serait incompréhensible.
                $q->where('etablissement_id', $this->etablissementId)
                    // Une catégorie de plateforme, en revanche, n'a d'intérêt
                    // que si elle contient des produits de CET établissement.
                    //
                    // whereHas et non having() : `products_count` est une
                    // sous-requête, pas un agrégat, et SQLite refuse un HAVING
                    // sans GROUP BY (MySQL le tolère — la faute ne serait
                    // apparue qu'en production).
                    ->orWhereHas('products', $siens);
            });

        match ($options['sort']) {
            'name' => $query->orderBy('name'),
            'products' => $query->orderByDesc('products_count'),
            default => $query->orderBy('order')->orderBy('name'),
        };

        return $query->limit(max(1, $limite))->get();
    }

    protected function remplirCarte(
        \DOMDocument $doc,
        \DOMXPath $xpath,
        \DOMElement $carte,
        $rayon,
        array $options
    ): void {
        $nombre = (int) $rayon->products_count;
        $lien = $this->lien($rayon);

        $carte->setAttribute('data-gx-category-id', (string) $rayon->id);

        // Une carte de rayon est souvent une simple tuile : si tout son contenu
        // est décoratif, on rend au moins la tuile entière cliquable.
        if (strtolower($carte->nodeName) === 'a') {
            $carte->setAttribute('href', $lien);
        }

        foreach ($this->champs($xpath, $carte) as $noeud) {
            switch ($noeud->getAttribute('data-gx-field')) {
                case 'image':
                    $this->poserImage($noeud, ProductPresenter::url($rayon->image), (string) $rayon->name);
                    break;

                case 'name':
                    $this->poserTexte($doc, $noeud, (string) $rayon->name);
                    break;

                case 'desc':
                    $description = trim((string) $rayon->description);
                    $description === ''
                        ? $this->poserTexte($doc, $noeud, $nombre . ' produit' . ($nombre > 1 ? 's' : ''))
                        : $this->poserTexte($doc, $noeud, $description);
                    break;

                case 'count':
                    $this->poserTexte($doc, $noeud, $nombre . ' produit' . ($nombre > 1 ? 's' : ''));
                    break;

                case 'link':
                    $noeud->setAttribute('href', $lien);
                    break;
            }
        }
    }

    /**
     * Vers la boutique filtrée sur ce rayon. La boutique accepte `?rayon=`,
     * ce qui évite d'inventer une URL par catégorie.
     */
    private function lien(ProductCategory $rayon): string
    {
        $base = url('/company/' . $this->etablissementId . '/produits');

        try {
            if (\Illuminate\Support\Facades\Route::has('cms.company.products')) {
                $base = route('cms.company.products', ['etablissementId' => $this->etablissementId]);
            }
        } catch (\Throwable $e) {
            // on garde l'URL construite à la main
        }

        return $base . '?rayon=' . $rayon->id;
    }
}
