<?php

namespace Vendor\Cms\Support\Traductions;

use Illuminate\Support\Facades\Log;
use Vendor\Cms\Models\Traduction;
use Vendor\Cms\Support\LanguesSite;

/**
 * Contenus des modules traduisibles (sites multilingues, étape 5 —
 * docs/CONCEPTION-MULTILINGUE.md § 9) : boutique, blog, immobilier.
 *
 * ⚠ Classe présente en DOUBLE : admin (écran Traductions) et front (blocs
 * remplis au rendu). Toute modification se reporte dans les deux projets.
 *
 * Une traduction de contenu est une ligne de cms_traductions :
 *   proprietaire_type = type (produit, rayon, article, bien)
 *   proprietaire_id   = id de l'enregistrement
 *   cle               = « produit:12@name » (unique pour l'établissement,
 *                       comme les étiquettes des pages)
 *
 * Format d'un champ : « texte » (texte brut) ou « riche » (HTML : balises
 * conservées, vérifiées à la traduction par l'IA).
 */
final class ContenusTraduisibles
{
    public const MODULES = [
        'produits' => [
            'type'    => 'produit',
            'modele'  => \App\Models\Product::class,
            'libelle' => 'Boutique — produits',
            'icone'   => 'fa-shopping-bag',
            'titre'   => 'name',
            'champs'  => [
                'name'              => ['Nom', 'texte'],
                'short_description' => ['Description courte', 'texte'],
                'long_description'  => ['Description détaillée', 'riche'],
            ],
        ],
        'rayons' => [
            'type'    => 'rayon',
            'modele'  => \App\Models\ProductCategory::class,
            'libelle' => 'Boutique — rayons',
            'icone'   => 'fa-tags',
            'titre'   => 'name',
            'champs'  => [
                'name'        => ['Nom du rayon', 'texte'],
                'description' => ['Description', 'texte'],
            ],
        ],
        'articles' => [
            'type'    => 'article',
            'modele'  => \Vendor\Cms\Models\BlogPost::class,
            'libelle' => 'Blog — articles',
            'icone'   => 'fa-newspaper',
            'titre'   => 'title',
            'champs'  => [
                'title'           => ['Titre', 'texte'],
                'excerpt'         => ['Résumé', 'texte'],
                'content'         => ['Contenu', 'riche'],
                'seo_title'       => ['Titre SEO', 'texte'],
                'seo_description' => ['Description SEO', 'texte'],
            ],
        ],
        'biens' => [
            'type'    => 'bien',
            'modele'  => \Vendor\Cms\Models\Property::class,
            'libelle' => 'Immobilier — biens et forfaits',
            'icone'   => 'fa-house',
            'titre'   => 'title',
            'champs'  => [
                'title'       => ['Titre', 'texte'],
                'description' => ['Description', 'riche'],
            ],
        ],
    ];

    /** Clé d'un champ : « produit:12@name ». */
    public static function cle(string $type, int $id, string $champ): string
    {
        return $type . ':' . $id . '@' . $champ;
    }

    /**
     * Décompose une clé de contenu ; null pour une clé de page ou de région.
     *
     * @return array{type: string, id: int, champ: string, module: string, format: string}|null
     */
    public static function analyserCle(string $cle): ?array
    {
        if (! preg_match('/^([a-z]+):(\d+)@([a-z_]+)$/', $cle, $m)) {
            return null;
        }
        foreach (self::MODULES as $module => $def) {
            if ($def['type'] === $m[1] && isset($def['champs'][$m[3]])) {
                return ['type' => $m[1], 'id' => (int) $m[2], 'champ' => $m[3], 'module' => $module, 'format' => $def['champs'][$m[3]][1]];
            }
        }

        return null;
    }

    /** Définition d'un module par son type (produit, rayon…). */
    public static function parType(string $type): ?array
    {
        foreach (self::MODULES as $def) {
            if ($def['type'] === $type) {
                return $def;
            }
        }

        return null;
    }

    /* ───────────────────────── Rendu du site (front) ───────────────────────── */

    /**
     * Langue à appliquer au rendu : celle de l'adresse (/company/{id}/en/…),
     * null pour la langue principale (rien à faire).
     */
    public static function langueDuRendu(int $etablissementId): ?string
    {
        try {
            $langue = (string) request()->attributes->get('gx_langue', '');
        } catch (\Throwable $e) {
            return null;
        }
        if ($langue === '') {
            return null;
        }
        $langues = LanguesSite::pour($etablissementId);

        return ($langue !== $langues['principale'] && LanguesSite::estVisible($langues, $langue)) ? $langue : null;
    }

    /**
     * Remplace EN MÉMOIRE (jamais enregistré) les champs traduits des
     * enregistrements d'un type, dans la langue du rendu. Une seule requête ;
     * un champ sans traduction garde la langue principale. Les produits
     * emportent la traduction de leur rayon (relation « category » chargée).
     *
     * @param  iterable<\Illuminate\Database\Eloquent\Model>  $modeles
     */
    public static function appliquer(iterable $modeles, string $type, int $etablissementId): void
    {
        $def = self::parType($type);
        $langue = $def ? self::langueDuRendu($etablissementId) : null;
        if (! $langue || ! Traduction::disponible()) {
            return;
        }

        $liste = [];
        foreach ($modeles as $m) {
            if ($m && $m->getKey()) {
                $liste[] = $m;
            }
        }
        if (! $liste) {
            return;
        }

        try {
            $cles = [];
            foreach ($liste as $m) {
                foreach (array_keys($def['champs']) as $champ) {
                    $cles[] = self::cle($type, (int) $m->getKey(), $champ);
                }
            }

            $traductions = [];
            foreach (array_chunk($cles, 500) as $lot) {
                $traductions += Traduction::where('etablissement_id', $etablissementId)
                    ->where('langue', $langue)
                    ->whereIn('cle', $lot)
                    ->pluck('texte', 'cle')
                    ->all();
            }

            foreach ($liste as $m) {
                foreach (array_keys($def['champs']) as $champ) {
                    $texte = $traductions[self::cle($type, (int) $m->getKey(), $champ)] ?? null;
                    if ($texte !== null && trim($texte) !== '') {
                        $m->setAttribute($champ, $texte);
                    }
                }
            }

            if ($type === 'produit') {
                $rayons = [];
                foreach ($liste as $m) {
                    if ($m->relationLoaded('category') && $m->category) {
                        $rayons[$m->category->getKey()] = $m->category;
                    }
                }
                if ($rayons) {
                    self::appliquer(array_values($rayons), 'rayon', $etablissementId);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Traduction des contenus (' . $type . ') : ' . $e->getMessage());
        }
    }
}
