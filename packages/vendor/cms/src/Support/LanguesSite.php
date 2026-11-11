<?php

namespace Vendor\Cms\Support;

use Vendor\Cms\Models\Setting;

/**
 * Langues du site public d'un établissement (sites multilingues, étape 1 —
 * docs/CONCEPTION-MULTILINGUE.md).
 *
 * ⚠ Classe présente en DOUBLE : admin (réglage) et front (adresses par langue,
 * hreflang, sélecteur). Toute modification se reporte dans les deux projets.
 *
 * Un seul réglage JSON : cms_settings, groupe « langues », clé « config » :
 *   { principale: "fr", actives: ["fr","en"], visibles: ["fr","en"], selecteur: true }
 *
 * - `principale` : langue de la mise en page ; ses adresses n'ont PAS de
 *   préfixe (les adresses actuelles restent valables).
 * - `actives`    : langues proposées (la principale en fait toujours partie).
 *   Décocher une langue la masque sans rien effacer.
 * - `visibles`   : langues publiées sur le site (sous-ensemble des actives).
 *   Une langue active mais non visible se traduit sans paraître en ligne.
 * - `selecteur`  : afficher le sélecteur de langue sur le site.
 */
final class LanguesSite
{
    public const GROUPE = 'langues';
    public const CLE = 'config';

    /** Langues proposées, dans l'ordre d'affichage. */
    public const LANGUES = [
        'fr' => 'Français',
        'en' => 'English',
        'es' => 'Español',
        'de' => 'Deutsch',
        'it' => 'Italiano',
    ];

    /** Codes courts du sélecteur. */
    public const DRAPEAUX = [
        'fr' => 'FR',
        'en' => 'EN',
        'es' => 'ES',
        'de' => 'DE',
        'it' => 'IT',
    ];

    /** Motif de route d'un segment de langue. */
    public static function motif(): string
    {
        return implode('|', array_keys(self::LANGUES));
    }

    /** Configuration par défaut : français seul, sélecteur affiché. */
    public static function defaut(): array
    {
        return [
            'principale' => 'fr',
            'actives'    => ['fr'],
            'visibles'   => ['fr'],
            'selecteur'  => true,
        ];
    }

    /** @var array<int, array> mémoire de la requête */
    private static array $cache = [];

    /** Configuration normalisée d'un établissement. */
    public static function pour(int|string $etablissementId): array
    {
        $id = (int) $etablissementId;
        if (isset(self::$cache[$id])) {
            return self::$cache[$id];
        }

        $brut = null;
        try {
            $brut = Setting::where('etablissement_id', $id)
                ->where('group', self::GROUPE)
                ->where('key', self::CLE)
                ->value('value');
        } catch (\Throwable $e) {
            $brut = null;
        }

        $valeur = is_string($brut) ? json_decode($brut, true) : $brut;

        return self::$cache[$id] = self::normaliser(is_array($valeur) ? $valeur : []);
    }

    /** Oublie la mémoire de la requête (après un enregistrement, en test). */
    public static function oublier(): void
    {
        self::$cache = [];
    }

    /** Remet une configuration saisie dans un état cohérent. */
    public static function normaliser(array $config): array
    {
        $defaut = self::defaut();

        $principale = (string) ($config['principale'] ?? $defaut['principale']);
        if (! isset(self::LANGUES[$principale])) {
            $principale = $defaut['principale'];
        }

        $filtrer = static function ($liste): array {
            $liste = is_array($liste) ? $liste : [];

            // Ordre de LANGUES, sans doublon ni code inconnu.
            return array_values(array_filter(
                array_keys(self::LANGUES),
                static fn (string $code) => in_array($code, $liste, true)
            ));
        };

        $actives = $filtrer($config['actives'] ?? []);
        if (! in_array($principale, $actives, true)) {
            array_unshift($actives, $principale);
            $actives = $filtrer($actives);
        }

        $visibles = array_values(array_intersect($filtrer($config['visibles'] ?? $actives), $actives));
        if (! in_array($principale, $visibles, true)) {
            array_unshift($visibles, $principale);
            $visibles = $filtrer($visibles);
        }

        return [
            'principale' => $principale,
            'actives'    => $actives,
            'visibles'   => $visibles,
            'selecteur'  => (bool) ($config['selecteur'] ?? $defaut['selecteur']),
        ];
    }

    /** Enregistre la configuration (normalisée) et la renvoie. */
    public static function enregistrer(int|string $etablissementId, array $config): array
    {
        $config = self::normaliser($config);

        Setting::updateOrCreate(
            ['etablissement_id' => (int) $etablissementId, 'group' => self::GROUPE, 'key' => self::CLE],
            ['value' => json_encode($config, JSON_UNESCAPED_UNICODE)]
        );

        self::oublier();

        return $config;
    }

    /** Langue publiée sur le site (visible) ? */
    public static function estVisible(array $config, string $langue): bool
    {
        return in_array($langue, $config['visibles'], true);
    }

    /** Le site a-t-il plus d'une langue publiée ? */
    public static function estMultilingue(array $config): bool
    {
        return count($config['visibles']) > 1;
    }

    /**
     * Préfixe un chemin du site (/company/{id}/...) avec la langue.
     * La langue principale n'a jamais de préfixe ; un préfixe existant est
     * remplacé.
     */
    public static function prefixer(string $chemin, string $langue, array $config): string
    {
        $motif = self::motif();

        if (! preg_match('#^(/company/\d+)(?:/(?:' . $motif . '))?(?=/|$|\?|\#)(.*)$#s', $chemin, $m)) {
            return $chemin;
        }

        $base = $m[1];
        $reste = $m[2];

        if ($langue === $config['principale'] || ! isset(self::LANGUES[$langue])) {
            return $base . $reste;
        }

        return $base . '/' . $langue . $reste;
    }

    /** Retire le préfixe de langue d'un chemin du site. */
    public static function sansLangue(string $chemin): string
    {
        return (string) preg_replace('#^(/company/\d+)/(?:' . self::motif() . ')(?=/|$|\?|\#)#', '$1', $chemin);
    }
}
