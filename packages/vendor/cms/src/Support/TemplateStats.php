<?php

namespace Vendor\Cms\Support;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

/**
 * Chiffres de la boutique dans les gabarits : `data-gx-stat="clé"`.
 *
 *   produits    produits publics et en vente de l'établissement
 *   rayons      rayons actifs affichés par le site (les siens + ceux de la
 *               plateforme où il a des produits — même règle que TemplateCategories)
 *   commandes   commandes payées, en préparation, expédiées ou livrées
 *   clients     clients distincts de ces commandes
 *
 * Le texte de l'élément est remplacé par la valeur. Avec
 * `data-gx-stat-vide="masquer"`, une valeur nulle retire la ligne porteuse de
 * `data-gx-stat-ligne` au lieu d'afficher « 0 » (une boutique qui démarre
 * n'a pas à afficher « 0 commande »), et jamais un chiffre inventé.
 *
 * Remplacement au rendu, par expressions ciblées (pas de DOM global, cf.
 * TemplateDataBinder) : sans repère, la page ressort à l'identique.
 */
class TemplateStats
{
    public const CLES = ['produits', 'rayons', 'commandes', 'clients'];

    public static function hydrate(string $html, ?int $etablissementId): string
    {
        if ($etablissementId === null || strpos($html, 'data-gx-stat=') === false) {
            return $html;
        }

        preg_match_all('/data-gx-stat="([a-z]+)"/', $html, $m);
        $demandees = array_values(array_intersect(self::CLES, array_unique($m[1])));

        foreach ($demandees as $cle) {
            try {
                $valeur = self::valeur($cle, $etablissementId);
            } catch (\Throwable $e) {
                // Table absente ou schéma en retard : on laisse le texte du
                // gabarit plutôt que de casser la page.
                Log::warning("TemplateStats {$cle} : " . $e->getMessage());
                continue;
            }

            $html = self::poser($html, $cle, $valeur);
        }

        return $html;
    }

    protected static function valeur(string $cle, int $etablissementId): int
    {
        return match ($cle) {
            'produits' => Product::where('etablissement_id', $etablissementId)
                ->where('is_public', true)
                ->where('is_available_for_sale', true)
                ->count(),
            'rayons' => ProductCategory::query()
                ->pourEtablissement($etablissementId)
                ->where('is_active', true)
                ->where(function ($q) use ($etablissementId) {
                    $q->where('etablissement_id', $etablissementId)
                        ->orWhereHas('products', fn ($p) => $p->where('etablissement_id', $etablissementId)
                            ->where('is_public', true)->where('is_available_for_sale', true));
                })
                ->count(),
            'commandes' => self::commandes($etablissementId)->count(),
            'clients' => (int) self::commandes($etablissementId)->distinct()->count('customer_id'),
        };
    }

    protected static function commandes(int $etablissementId)
    {
        if (! Schema::hasTable('online_orders')) {
            throw new \RuntimeException('table online_orders absente');
        }

        return DB::table('online_orders')
            ->where('etablissement_id', $etablissementId)
            ->whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])
            ->whereNull('deleted_at');
    }

    protected static function poser(string $html, string $cle, int $valeur): string
    {
        $marque = 'data-gx-stat="' . $cle . '"';

        if ($valeur === 0) {
            // Lignes à masquer quand la valeur est nulle.
            $html = preg_replace_callback(
                '#<(div|li|p|span)\b[^>]*data-gx-stat-ligne[^>]*>(?:(?!</\1>).)*?</\1>#s',
                function ($m) use ($marque) {
                    return (str_contains($m[0], $marque) && str_contains($m[0], 'data-gx-stat-vide="masquer"'))
                        ? ''
                        : $m[0];
                },
                $html
            );
        }

        $texte = number_format($valeur, 0, ',', ' ');

        return preg_replace_callback(
            '#(<([a-z][a-z0-9]*)\b[^>]*' . preg_quote($marque, '#') . '[^>]*>)[^<]*(</\2>)#i',
            fn ($m) => $m[1] . $texte . $m[3],
            $html
        );
    }
}
