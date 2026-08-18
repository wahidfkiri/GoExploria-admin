<?php

namespace Vendor\Cms\Support;

use App\Models\Product;

/**
 * Remplit les sections « produits » d'un template CMS avec les vrais produits
 * de l'établissement (espace entreprise → E-commerce).
 *
 * ─────────────────────────────────────────────────────────────────────────
 * LE PRINCIPE
 * ─────────────────────────────────────────────────────────────────────────
 *
 * Le gabarit reste la source du design. Dans le template, la grille porte
 * `data-gx-products` et la PREMIÈRE carte `data-gx-product` sert de modèle :
 * elle est clonée autant de fois qu'il y a de produits, puis remplie via les
 * `data-gx-field`. Le graphiste continue donc de dessiner la carte dans
 * l'éditeur sans toucher une ligne de code ; les cartes suivantes ne servent
 * qu'à l'aperçu et disparaissent au rendu.
 *
 * Le remplissage a lieu au RENDU, jamais en base : ajouter un produit dans
 * l'espace entreprise suffit à mettre le site à jour, il n'y a rien à
 * réinstaller. Même contrat que [[TemplateDataBinder]].
 *
 * La mécanique de repérage et de clonage vit dans [[TemplateGrid]].
 *
 * Attributs reconnus sur le conteneur :
 *   data-gx-products            active la section (valeur ignorée)
 *   data-gx-products-limit      nombre max de produits (déf. : nb de cartes)
 *   data-gx-products-category   filtre sur le nom de catégorie ou de famille
 *   data-gx-products-sort       recent | sales | price | price-desc
 *   data-gx-products-currency   symbole monétaire (déf. : $)
 *   data-gx-products-pick       clé de section à sélection manuelle : seuls les
 *                               produits cochés pour cette clé dans l'espace
 *                               entreprise y figurent (déf. : automatique)
 *   data-gx-products-label      libellé lisible de la section, repris tel quel
 *                               dans les cases à cocher de l'espace entreprise
 *
 * Champs reconnus sur les descendants de la carte (`data-gx-field`) :
 *   image, name, desc, category, tag, price, unit, add, link
 */
class TemplateProducts extends TemplateGrid
{
    /** Fiche produit vers laquelle pointent les cartes hydratées. */
    private const ROUTE_FICHE = 'cms.company.products.show';

    protected function marqueur(): string
    {
        return 'data-gx-products';
    }

    protected function marqueurCarte(): string
    {
        return 'data-gx-product';
    }

    /** @return \Illuminate\Support\Collection<int,Product> */
    protected function elements(int $limite, array $options)
    {
        $query = Product::query()
            ->with(['etablissement:id,name', 'category:id,name', 'family:id,name'])
            ->where('etablissement_id', $this->etablissementId)
            ->where('is_public', true)
            ->where('is_available_for_sale', true);

        // Section à sélection manuelle : n'y figurent que les produits cochés
        // pour cette section dans l'espace entreprise. Aucun produit coché ?
        // La requête ne renvoie rien et [[TemplateGrid]] garde la démonstration
        // — préférable à une section vide sur un site en ligne.
        if (($options['pick'] ?? '') !== '') {
            $query->whereJsonContains('metadata->template_sections', $options['pick']);
        }

        if ($options['category'] !== '') {
            $categorie = $options['category'];
            $query->where(function ($q) use ($categorie) {
                $q->whereHas('category', fn ($c) => $c->where('name', 'like', '%' . $categorie . '%'))
                    ->orWhereHas('family', fn ($f) => $f->where('name', 'like', '%' . $categorie . '%'));
            });
        }

        match ($options['sort']) {
            'sales' => $query->orderByDesc('sales_count'),
            'price' => $query->orderBy('price_ttc'),
            'price-desc' => $query->orderByDesc('price_ttc'),
            default => $query->orderByDesc('created_at'),
        };

        return $query->limit(max(1, $limite))->get();
    }

    protected function remplirCarte(
        \DOMDocument $doc,
        \DOMXPath $xpath,
        \DOMElement $carte,
        $produit,
        array $options
    ): void {
        $devise = $options['currency'];

        $image = ProductPresenter::image($produit);
        $prix = ProductPresenter::prix($produit);
        $categorie = $this->categorie($produit);
        $pastille = ProductPresenter::pastille($produit);
        $lien = $this->lien($produit);

        $carte->setAttribute('data-gx-product-id', (string) $produit->id);
        $this->poserDonneesModale($carte, $produit, $prix, $devise, $categorie, $lien);

        foreach ($this->champs($xpath, $carte) as $noeud) {
            switch ($noeud->getAttribute('data-gx-field')) {
                case 'image':
                    $this->poserImage($noeud, $image, (string) $produit->name);
                    break;

                case 'name':
                    $this->poserTexte($doc, $noeud, (string) $produit->name);
                    break;

                case 'desc':
                    $this->poserTexte($doc, $noeud, ProductPresenter::description($produit));
                    break;

                case 'category':
                    $categorie === null
                        ? $this->retirer($noeud)
                        : $this->poserTexte($doc, $noeud, $categorie);
                    break;

                case 'tag':
                    $pastille === null
                        ? $this->retirer($noeud)
                        : $this->poserTexte($doc, $noeud, $pastille);
                    break;

                case 'price':
                    $this->poserTexte(
                        $doc,
                        $noeud,
                        $prix === null ? 'Sur demande' : ProductPresenter::montant($prix, $devise)
                    );
                    break;

                case 'unit':
                    $unite = trim((string) $produit->billing_unit);
                    $unite === ''
                        ? $this->retirer($noeud)
                        : $this->poserTexte($doc, $noeud, '/ ' . $unite);
                    break;

                case 'link':
                    $noeud->setAttribute('href', $lien);
                    break;

                case 'add':
                    $this->poserPanier($noeud, $produit, $prix, $image, $lien);
                    break;
            }
        }
    }

    /**
     * Dépose sur la carte de quoi ouvrir la modale de détail sans requête
     * réseau : galerie, description longue, disponibilité.
     *
     * Les données sont embarquées plutôt que chargées à la demande — une
     * poignée d'URL par carte pèse moins qu'un aller-retour serveur à chaque
     * clic, et la modale reste fonctionnelle sur une page mise en cache.
     */
    private function poserDonneesModale(
        \DOMElement $carte,
        $produit,
        ?float $prix,
        string $devise,
        ?string $categorie,
        string $lien
    ): void {
        $galerie = ProductPresenter::galerie($produit);

        $carte->setAttribute('data-gx-modal', '');
        $carte->setAttribute('data-gx-name', (string) $produit->name);
        $carte->setAttribute('data-gx-price', $prix === null
            ? 'Sur demande'
            : ProductPresenter::montant($prix, $devise));
        $carte->setAttribute('data-gx-url', $lien);

        if ($prix !== null) {
            $carte->setAttribute('data-gx-price-raw', (string) $prix);
        }
        if ($categorie !== null) {
            $carte->setAttribute('data-gx-category', $categorie);
        }
        if ($produit->billing_unit) {
            $carte->setAttribute('data-gx-unit', (string) $produit->billing_unit);
        }
        if ($galerie !== []) {
            $carte->setAttribute('data-gx-gallery', json_encode($galerie, JSON_UNESCAPED_SLASHES));
        }

        $texte = trim((string) ($produit->long_description ?: $produit->short_description ?: ''));
        if ($texte !== '') {
            $carte->setAttribute(
                'data-gx-description',
                \Illuminate\Support\Str::limit(trim((string) preg_replace('/\s+/', ' ', strip_tags($texte))), 600)
            );
        }

        $carte->setAttribute('data-gx-stock', ProductPresenter::estEpuise($produit)
            ? 'Épuisé'
            : ($produit->stock_management === 'sur_commande' ? 'Sur commande' : 'En stock'));

        if ($produit->reference) {
            $carte->setAttribute('data-gx-reference', (string) $produit->reference);
        }
    }

    /**
     * Pose le contrat attendu par le tiroir panier
     * (partials/landing-cart-drawer.blade.php).
     */
    private function poserPanier(
        \DOMElement $noeud,
        $produit,
        ?float $prix,
        ?string $image,
        string $lien
    ): void {
        // Sans prix, rien à mettre au panier : le bouton redevient un lien vers
        // la fiche produit (affichée « Sur demande »).
        if ($prix === null) {
            $noeud->setAttribute('href', $lien);

            return;
        }

        $noeud->setAttribute('data-cms-cart-add', '');
        $noeud->setAttribute('data-product-id', (string) $produit->id);
        $noeud->setAttribute('data-product-name', (string) $produit->name);
        $noeud->setAttribute('data-product-price', (string) $prix);
        $noeud->setAttribute('data-product-url', $lien);
        $noeud->setAttribute('data-etablissement-id', (string) $produit->etablissement_id);

        if ($image !== null) {
            $noeud->setAttribute('data-product-image', $image);
        }

        $nom = optional($produit->etablissement)->name;
        if ($nom) {
            $noeud->setAttribute('data-etablissement-name', (string) $nom);
        }

        // Un <a href="#"> ferait remonter la page en haut à chaque ajout.
        if (strtolower($noeud->nodeName) === 'a') {
            $noeud->setAttribute('href', 'javascript:void(0)');
            $noeud->setAttribute('role', 'button');
        }

        if ($noeud->getAttribute('aria-label') === '') {
            $noeud->setAttribute('aria-label', 'Ajouter ' . $produit->name . ' au panier');
        }
    }

    private function categorie($produit): ?string
    {
        $libelle = optional($produit->category)->name ?: optional($produit->family)->name;

        return $libelle ? (string) $libelle : null;
    }

    private function lien($produit): string
    {
        // Route nommée quand elle est disponible : c'est elle qui fait foi.
        // Le try/catch couvre les appels hors application complète (bancs
        // d'essai) où la façade Route n'est pas chargée — s'y fier sans filet
        // ferait échouer toute l'hydratation pour une simple URL.
        try {
            if (\Illuminate\Support\Facades\Route::has(self::ROUTE_FICHE)) {
                return route(self::ROUTE_FICHE, [
                    'etablissementId' => $produit->etablissement_id,
                    'productId' => $produit->id,
                ]);
            }
        } catch (\Throwable $e) {
            // on retombe sur l'URL construite à la main
        }

        return url('/company/' . $produit->etablissement_id . '/produits/' . $produit->id);
    }
}
