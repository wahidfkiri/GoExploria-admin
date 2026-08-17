<?php

namespace Vendor\Cms\Support;

use App\Models\Product;
use Illuminate\Support\Str;

/**
 * Règles d'affichage d'un produit, partagées par tout le front.
 *
 * Elles sont utilisées à deux endroits qui doivent impérativement dire la même
 * chose : les grilles de template remplies par [[TemplateProducts]] et les
 * pages de boutique (liste, fiche produit). Un prix affiché « 3,90 $ » dans la
 * grille et « 3.9 » sur la fiche, ou une pastille « Épuisé » d'un côté seulement,
 * feraient douter le client au moment d'acheter.
 */
class ProductPresenter
{
    /** Devise d'affichage du front. Voir PublicPageController::DEVISE_COMMANDE. */
    public const SYMBOLE = '$';

    /**
     * Prix de vente, ou null s'il n'y en a pas (produit « sur demande »).
     *
     * Le TTC fait foi : c'est ce que paie le client. Le HT ne sert qu'au repli
     * quand le TTC n'a pas été saisi.
     */
    public static function prix($produit): ?float
    {
        $valeur = $produit->price_ttc ?? $produit->price_ht ?? null;

        if ($valeur === null || $valeur === '' || (float) $valeur <= 0) {
            return null;
        }

        return round((float) $valeur, 2);
    }

    public static function montant(float $valeur, string $devise = self::SYMBOLE): string
    {
        return number_format($valeur, 2, ',', ' ') . ' ' . $devise;
    }

    /**
     * Pastille d'état : sur commande, épuisé ou nouveauté — sinon aucune.
     *
     * Volontairement muette dans le cas courant : une pastille sur chaque carte
     * n'attirerait plus l'œil sur rien.
     */
    public static function pastille($produit): ?string
    {
        if ($produit->stock_management === 'sur_commande') {
            return 'Sur commande';
        }

        if ($produit->stock_management === 'gestion_stock'
            && $produit->current_stock !== null
            && (int) $produit->current_stock <= 0) {
            return 'Épuisé';
        }

        if ($produit->created_at && $produit->created_at->gt(now()->subDays(30))) {
            return 'Nouveau';
        }

        return null;
    }

    /** Un produit épuisé reste visible mais ne peut pas être mis au panier. */
    public static function estEpuise($produit): bool
    {
        return $produit->stock_management === 'gestion_stock'
            && $produit->current_stock !== null
            && (int) $produit->current_stock <= 0;
    }

    public static function description($produit, int $longueur = 120): string
    {
        $texte = (string) ($produit->short_description ?: $produit->long_description ?: '');

        return Str::limit(trim((string) preg_replace('/\s+/', ' ', strip_tags($texte))), $longueur);
    }

    /** Image principale, ou première image de la galerie. */
    public static function image($produit): ?string
    {
        $chemin = $produit->main_image;

        if (empty($chemin)) {
            $galerie = $produit->gallery_images;
            if (is_array($galerie)) {
                $chemin = $galerie[0] ?? null;
            }
        }

        return self::url($chemin);
    }

    /**
     * Toutes les images du produit, principale en tête, sans doublon.
     *
     * @return string[]
     */
    public static function galerie($produit): array
    {
        $images = [self::image($produit)];

        $galerie = $produit->gallery_images;
        if (is_array($galerie)) {
            foreach ($galerie as $entree) {
                $images[] = self::url($entree);
            }
        }

        return array_values(array_unique(array_filter($images)));
    }

    /**
     * Résout un chemin d'image : URL absolue, /storage/…, ou chemin relatif au
     * disque public. Les trois formes existent en base selon l'ancienneté de la
     * fiche produit.
     */
    public static function url($chemin): ?string
    {
        if (is_array($chemin)) {
            $chemin = $chemin['url'] ?? $chemin['thumbnail'] ?? ($chemin[0] ?? null);
        }

        $chemin = trim((string) $chemin);
        if ($chemin === '') {
            return null;
        }

        if (Str::startsWith($chemin, ['http://', 'https://', '//'])) {
            return $chemin;
        }

        if (Str::startsWith($chemin, ['/storage/', 'storage/', '/'])) {
            return asset(ltrim($chemin, '/'));
        }

        return asset('storage/' . ltrim($chemin, '/'));
    }
}
