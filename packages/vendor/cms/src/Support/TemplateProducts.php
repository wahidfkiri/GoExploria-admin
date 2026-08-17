<?php

namespace Vendor\Cms\Support;

use App\Models\Product;
use Illuminate\Support\Facades\Log;

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
 * ─────────────────────────────────────────────────────────────────────────
 * POURQUOI UN DOM *LOCAL* ET NON SUR TOUTE LA PAGE
 * ─────────────────────────────────────────────────────────────────────────
 *
 * DOMDocument ne connaît que HTML 4 : sur ces templates — 150 Ko, SVG en
 * ligne, attributs booléens — il réécrit le document à la sérialisation et
 * casse le balisage (c'est la raison pour laquelle TemplateDataBinder s'en
 * tient aux expressions régulières).
 *
 * Cloner une carte et la remplir champ par champ demande pourtant un vrai
 * arbre. Le compromis retenu : un scanner de balises repère la grille dans la
 * chaîne, et SEUL son contenu — quelques kilo-octets de cartes produit, sans
 * script ni SVG — passe par DOMDocument. Le reste du template n'est jamais
 * re-sérialisé, donc jamais abîmé.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * REPLI
 * ─────────────────────────────────────────────────────────────────────────
 *
 * Si l'établissement n'a aucun produit publié, la section est laissée telle
 * quelle : un template installé sur un catalogue vide garde une page de
 * démonstration présentable plutôt qu'un trou.
 *
 * Attributs reconnus sur le conteneur :
 *   data-gx-products            active la section (valeur ignorée)
 *   data-gx-products-limit      nombre max de produits (déf. : nb de cartes)
 *   data-gx-products-category   filtre sur le nom de catégorie ou de famille
 *   data-gx-products-sort       recent | sales | price | price-desc
 *   data-gx-products-currency   symbole monétaire (déf. : $)
 *
 * Champs reconnus sur les descendants de la carte (`data-gx-field`) :
 *   image, name, desc, category, tag, price, unit, add, link
 */
class TemplateProducts
{
    /** Attribut déclencheur ; sert aussi de test rapide sur la chaîne. */
    private const MARKER = 'data-gx-products';

    /** Fiche produit vers laquelle pointent les cartes hydratées. */
    private const ROUTE_FICHE = 'cms.company.products.show';

    public static function hydrate(string $html, ?int $etablissementId): string
    {
        // Sortie immédiate : l'immense majorité des pages n'a pas de section
        // produits, inutile de payer un scan pour elles.
        if ($etablissementId === null || strpos($html, self::MARKER) === false) {
            return $html;
        }

        try {
            return (new self((int) $etablissementId))->parcourir($html);
        } catch (\Throwable $e) {
            // Une page affichée avec ses produits de démonstration vaut mieux
            // qu'une page cassée.
            Log::warning('TemplateProducts : hydratation abandonnée — ' . $e->getMessage(), [
                'etablissement_id' => $etablissementId,
            ]);

            return $html;
        }
    }

    private function __construct(private readonly int $etablissementId)
    {
    }

    /**
     * Parcourt la chaîne, repère chaque grille marquée et remplace son contenu.
     * Aucune autre partie du template n'est touchée.
     */
    private function parcourir(string $html): string
    {
        // Balise ouvrante portant l'attribut, quel que soit l'ordre des autres.
        $ouvrante = '/<(?<tag>[a-zA-Z][\w:-]*)(?<attrs>\s[^>]*?)?\s'
            . preg_quote(self::MARKER, '/')
            . '(?:\s|=|>)/i';

        $sortie = '';
        $reste = $html;

        while (preg_match($ouvrante, $reste, $m, PREG_OFFSET_CAPTURE)) {
            $debutBalise = $m[0][1];
            $tag = $m['tag'][0];

            $finOuvrante = strpos($reste, '>', $debutBalise);
            if ($finOuvrante === false) {
                break;                      // balise tronquée : on s'arrête là
            }
            $finOuvrante++;

            $fermeture = $this->trouverFermeture($reste, $tag, $finOuvrante);
            if ($fermeture === null) {
                // Pas de balise fermante : on avance pour ne pas boucler.
                $sortie .= substr($reste, 0, $finOuvrante);
                $reste = substr($reste, $finOuvrante);
                continue;
            }

            [$debutFermante, $finFermante] = $fermeture;

            $balise = substr($reste, $debutBalise, $finOuvrante - $debutBalise);
            $interieur = substr($reste, $finOuvrante, $debutFermante - $finOuvrante);

            $nouveau = $this->remplirGrille($balise, $interieur);

            $sortie .= substr($reste, 0, $finOuvrante) . $nouveau;
            $sortie .= substr($reste, $debutFermante, $finFermante - $debutFermante);
            $reste = substr($reste, $finFermante);
        }

        return $sortie . $reste;
    }

    /**
     * Retourne [début, fin] de la balise fermante correspondante, en tenant
     * compte de l'imbrication de balises de même nom.
     *
     * @return array{0:int,1:int}|null
     */
    private function trouverFermeture(string $html, string $tag, int $depuis): ?array
    {
        $motif = '/<(?<slash>\/?)' . preg_quote($tag, '/') . '\b[^>]*>/i';
        $profondeur = 1;
        $position = $depuis;

        while (preg_match($motif, $html, $m, PREG_OFFSET_CAPTURE, $position)) {
            $debut = $m[0][1];
            $fin = $debut + strlen($m[0][0]);

            if ($m['slash'][0] === '/') {
                if (--$profondeur === 0) {
                    return [$debut, $fin];
                }
            } elseif (substr(rtrim($m[0][0], '>'), -1) !== '/') {
                $profondeur++;      // <div ... /> ne compte pas comme ouverture
            }

            $position = $fin;
        }

        return null;
    }

    /**
     * Reconstruit l'intérieur d'une grille. Retourne l'original si aucune carte
     * modèle n'est trouvée ou si l'établissement n'a pas de produit publié.
     */
    private function remplirGrille(string $baliseOuvrante, string $interieur): string
    {
        $options = $this->options($baliseOuvrante);

        $doc = $this->charger($interieur);
        if ($doc === null) {
            return $interieur;
        }

        [$doc, $racine] = $doc;
        $xpath = new \DOMXPath($doc);

        $cartes = $this->cartes($xpath, $racine);
        if ($cartes === []) {
            return $interieur;
        }

        $limite = $options['limit'] > 0 ? $options['limit'] : count($cartes);
        $produits = $this->produits($limite, $options['category'], $options['sort']);

        if ($produits->isEmpty()) {
            return $interieur;              // catalogue vide : on garde la démo
        }

        $modele = $cartes[0];

        // Les clones sont insérés AVANT le modèle puis les cartes d'origine
        // sont retirées : l'ordre des produits est respecté sans avoir à
        // manipuler nextSibling pendant qu'on modifie l'arbre.
        foreach ($produits as $produit) {
            $clone = $modele->cloneNode(true);
            $modele->parentNode->insertBefore($clone, $modele);
            $this->remplirCarte($doc, $xpath, $clone, $produit, $options['currency']);
        }

        foreach ($cartes as $ancienne) {
            if ($ancienne->parentNode) {
                $ancienne->parentNode->removeChild($ancienne);
            }
        }

        $out = '';
        foreach ($racine->childNodes as $enfant) {
            $out .= $doc->saveHTML($enfant);
        }

        return $out;
    }

    /** @return array{0:\DOMDocument,1:\DOMElement}|null */
    private function charger(string $fragment): ?array
    {
        $doc = new \DOMDocument('1.0', 'UTF-8');

        $precedent = libxml_use_internal_errors(true);
        $ok = $doc->loadHTML(
            '<?xml encoding="utf-8"?><div id="gx-grid">' . $fragment . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();
        libxml_use_internal_errors($precedent);

        if (! $ok) {
            return null;
        }

        $racine = $doc->getElementById('gx-grid');

        return $racine ? [$doc, $racine] : null;
    }

    /** @return array{limit:int,category:string,sort:string,currency:string} */
    private function options(string $balise): array
    {
        $lire = function (string $suffixe) use ($balise): string {
            $motif = '/\s' . preg_quote(self::MARKER . $suffixe, '/')
                . '\s*=\s*("([^"]*)"|\'([^\']*)\')/i';

            if (preg_match($motif, $balise, $m)) {
                return trim($m[2] ?? $m[3] ?? '');
            }

            return '';
        };

        $limite = (int) $lire('-limit');

        return [
            'limit' => $limite > 0 ? min(48, $limite) : 0,
            'category' => $lire('-category'),
            'sort' => $lire('-sort'),
            'currency' => $lire('-currency') ?: '$',
        ];
    }

    /**
     * Cartes modèles : les descendants marqués `data-gx-product`, sinon les
     * enfants directs (grille non annotée).
     *
     * @return \DOMElement[]
     */
    private function cartes(\DOMXPath $xpath, \DOMElement $racine): array
    {
        $cartes = [];

        $marquees = $xpath->query('.//*[@data-gx-product]', $racine);
        if ($marquees !== false && $marquees->length > 0) {
            foreach ($marquees as $noeud) {
                if (! $this->aUnParentMarque($noeud, $racine)) {
                    $cartes[] = $noeud;
                }
            }

            return $cartes;
        }

        foreach ($racine->childNodes as $enfant) {
            if ($enfant instanceof \DOMElement) {
                $cartes[] = $enfant;
            }
        }

        return $cartes;
    }

    private function aUnParentMarque(\DOMNode $noeud, \DOMElement $limite): bool
    {
        for ($p = $noeud->parentNode; $p && $p !== $limite; $p = $p->parentNode) {
            if ($p instanceof \DOMElement && $p->hasAttribute('data-gx-product')) {
                return true;
            }
        }

        return false;
    }

    private function remplirCarte(
        \DOMDocument $doc,
        \DOMXPath $xpath,
        \DOMElement $carte,
        Product $produit,
        string $devise
    ): void {
        $carte->setAttribute('data-gx-product-id', (string) $produit->id);

        $image = $this->imageUrl($produit);
        $prix = $this->prix($produit);
        $categorie = $this->categorie($produit);
        $pastille = $this->pastille($produit);
        $lien = $this->lien($produit);

        $champs = $xpath->query('.//*[@data-gx-field]', $carte);
        if ($champs === false) {
            return;
        }

        // La liste est copiée : supprimer un nœud pendant l'itération sur une
        // DOMNodeList vivante ferait sauter l'élément suivant.
        $noeuds = [];
        foreach ($champs as $noeud) {
            if ($noeud instanceof \DOMElement) {
                $noeuds[] = $noeud;
            }
        }

        foreach ($noeuds as $noeud) {
            switch ($noeud->getAttribute('data-gx-field')) {
                case 'image':
                    $this->poserImage($noeud, $image, (string) $produit->name);
                    break;

                case 'name':
                    $this->poserTexte($doc, $noeud, (string) $produit->name);
                    break;

                case 'desc':
                    $this->poserTexte($doc, $noeud, $this->description($produit));
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
                        $prix === null ? 'Sur demande' : $this->montant($prix, $devise)
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

    private function poserTexte(\DOMDocument $doc, \DOMElement $noeud, string $valeur): void
    {
        while ($noeud->firstChild) {
            $noeud->removeChild($noeud->firstChild);
        }

        $noeud->appendChild($doc->createTextNode($valeur));
    }

    private function poserImage(\DOMElement $noeud, ?string $url, string $alt): void
    {
        if ($url === null) {
            return;                         // pas de photo : on garde la démo
        }

        if (strtolower($noeud->nodeName) === 'img') {
            $noeud->setAttribute('src', $url);
            $noeud->setAttribute('alt', $alt);
            $noeud->setAttribute('loading', 'lazy');

            // Un srcset hérité du gabarit gagnerait sur src : la photo du
            // produit ne s'afficherait jamais.
            $noeud->removeAttribute('srcset');
            $noeud->removeAttribute('sizes');

            return;
        }

        $style = preg_replace('/background-image\s*:[^;]*;?/i', '', $noeud->getAttribute('style'));
        $noeud->setAttribute(
            'style',
            trim(trim((string) $style, ' ;') . ';background-image:url(\'' . $url . '\');', ';') . ';'
        );
    }

    private function retirer(\DOMElement $noeud): void
    {
        if ($noeud->parentNode) {
            $noeud->parentNode->removeChild($noeud);
        }
    }

    /**
     * Pose le contrat attendu par le tiroir panier
     * (partials/landing-cart-drawer.blade.php).
     */
    private function poserPanier(
        \DOMElement $noeud,
        Product $produit,
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

    /** @return \Illuminate\Support\Collection<int,Product> */
    private function produits(int $limite, string $categorie, string $tri)
    {
        $query = Product::query()
            ->with(['etablissement:id,name', 'category:id,name', 'family:id,name'])
            ->where('etablissement_id', $this->etablissementId)
            ->where('is_public', true)
            ->where('is_available_for_sale', true);

        if ($categorie !== '') {
            $query->where(function ($q) use ($categorie) {
                $q->whereHas('category', fn ($c) => $c->where('name', 'like', '%' . $categorie . '%'))
                    ->orWhereHas('family', fn ($f) => $f->where('name', 'like', '%' . $categorie . '%'));
            });
        }

        match ($tri) {
            'sales' => $query->orderByDesc('sales_count'),
            'price' => $query->orderBy('price_ttc'),
            'price-desc' => $query->orderByDesc('price_ttc'),
            default => $query->orderByDesc('created_at'),
        };

        return $query->limit(max(1, $limite))->get();
    }

    // Prix, pastille, description et image sont délégués à ProductPresenter :
    // les grilles de template et les pages de boutique doivent afficher
    // exactement la même chose du même produit.

    private function prix(Product $produit): ?float
    {
        return ProductPresenter::prix($produit);
    }

    private function montant(float $valeur, string $devise): string
    {
        return ProductPresenter::montant($valeur, $devise);
    }

    private function description(Product $produit): string
    {
        return ProductPresenter::description($produit);
    }

    private function categorie(Product $produit): ?string
    {
        $libelle = optional($produit->category)->name ?: optional($produit->family)->name;

        return $libelle ? (string) $libelle : null;
    }

    private function pastille(Product $produit): ?string
    {
        return ProductPresenter::pastille($produit);
    }

    private function lien(Product $produit): string
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

    private function imageUrl(Product $produit): ?string
    {
        return ProductPresenter::image($produit);
    }
}
