<?php

namespace Vendor\Cms\Support;

/**
 * Configuration de la section « Carte interactive », par établissement.
 * Stockée dans cms_settings (group « maps », clé « maps_section_config »).
 * Éditée côté admin, lue ici (front) pour rendre l'en-tête de section.
 *
 * Miroir de {@see ContactFormConfig} pour rester cohérent.
 */
class MapSectionConfig
{
    public const SETTING_KEY   = 'maps_section_config';
    public const SETTING_GROUP = 'maps';

    public const POSITIONS = ['left', 'center', 'right'];

    public const SIZE_MIN = 32;
    public const SIZE_MAX = 320;

    public static function defaults(): array
    {
        return [
            'title'          => 'Carte interactive',
            'subtitle'       => '',
            'title_color'    => '#000000',
            'subtitle_color' => '#000000',
            'show_logo'      => false,
            'logo_path'      => '',
            'logo_position'  => 'left',
            'logo_size'      => 96,
        ];
    }

    /** Normalise une couleur hex (#rrggbb), sinon retombe sur $fallback. */
    public static function color($value, string $fallback = '#000000'): string
    {
        $value = strtolower(trim((string) $value));

        if (preg_match('/^#[0-9a-f]{6}$/', $value)) {
            return $value;
        }

        if (preg_match('/^#[0-9a-f]{3}$/', $value)) {
            return '#' . $value[1] . $value[1] . $value[2] . $value[2] . $value[3] . $value[3];
        }

        return $fallback;
    }

    /**
     * Configuration effective pour un établissement (défauts + surcharge BD).
     *
     * @param mixed $etablissement doit exposer getSetting() (trait HasSettings)
     */
    public static function for($etablissement): array
    {
        $defaults = self::defaults();

        $raw = null;
        try {
            $raw = $etablissement?->getSetting(self::SETTING_KEY, null, self::SETTING_GROUP);
        } catch (\Throwable $e) {
            $raw = null;
        }

        if (is_string($raw)) {
            $raw = json_decode($raw, true);
        }

        if (! is_array($raw)) {
            $legacyTitle = null;
            try {
                $legacyTitle = $etablissement?->getSetting('maps_section_title', null);
            } catch (\Throwable $e) {
                $legacyTitle = null;
            }

            if (is_string($legacyTitle) && trim($legacyTitle) !== '') {
                $defaults['title'] = trim($legacyTitle);
            }

            return $defaults;
        }

        return self::merge($defaults, $raw);
    }

    public static function sanitize($input): array
    {
        return self::merge(self::defaults(), is_array($input) ? $input : []);
    }

    private static function merge(array $defaults, array $raw): array
    {
        $cut = fn ($v, $len, $fallback = '') => mb_substr(trim((string) ($v ?? '')), 0, $len) ?: $fallback;

        $position = strtolower(trim((string) ($raw['logo_position'] ?? $defaults['logo_position'])));
        if (! in_array($position, self::POSITIONS, true)) {
            $position = $defaults['logo_position'];
        }

        $size = (int) ($raw['logo_size'] ?? $defaults['logo_size']);
        $size = max(self::SIZE_MIN, min(self::SIZE_MAX, $size));

        return [
            'title'          => $cut($raw['title'] ?? null, 191, $defaults['title']),
            'subtitle'       => $cut($raw['subtitle'] ?? null, 255, ''),
            'title_color'    => self::color($raw['title_color'] ?? null, $defaults['title_color']),
            'subtitle_color' => self::color($raw['subtitle_color'] ?? null, $defaults['subtitle_color']),
            'show_logo'      => filter_var($raw['show_logo'] ?? $defaults['show_logo'], FILTER_VALIDATE_BOOLEAN),
            'logo_path'      => $cut($raw['logo_path'] ?? null, 500, ''),
            'logo_position'  => $position,
            'logo_size'      => $size,
        ];
    }
}
