<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Adresse d'un média téléversé depuis l'ADMIN (points de carte, galeries…).
 *
 * Règle : tout média téléversé depuis l'admin est servi par l'admin (ou par
 * le CDN). Une adresse complète, enregistrée ainsi depuis le 2026-11-25, est
 * rendue telle quelle ; un ancien chemin relatif est résolu contre l'admin
 * (config ads.admin_url), jamais contre ce site, où le fichier n'existe pas.
 */
final class MediaAdmin
{
    public static function url(?string $valeur): ?string
    {
        $valeur = trim((string) $valeur);
        if ($valeur === '') {
            return null;
        }
        if (Str::startsWith($valeur, ['http://', 'https://', '//', 'data:'])) {
            return $valeur;
        }

        $chemin = ltrim(preg_replace('#^/?storage/#', '', $valeur), '/');
        $base = rtrim((string) config('ads.admin_url', ''), '/');

        return $base !== '' ? $base . '/storage/' . $chemin : asset('storage/' . $chemin);
    }
}
