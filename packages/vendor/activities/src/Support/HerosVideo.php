<?php

namespace Vendor\Activities\Support;

/**
 * Héros de la page de site d'une activité : des vidéos seulement.
 *
 * Jusqu'au 2026-09-16, le bandeau (#plx-accueil) portait l'image de
 * l'activité (`<img class="plx-fond">`), gardée ensuite sous les vidéos. Le
 * client n'en veut plus. L'admin la retire des pages (à l'ouverture de
 * l'éditeur et par `activites:page-par-defaut --heros`) ; on la retire aussi
 * ici, au rendu, pour qu'une page déjà enregistrée ne l'affiche plus.
 *
 * Seule l'image qui ouvre le bandeau est visée — et seulement quand le
 * bandeau porte des vidéos : sans diaporama, elle reste le seul visuel du
 * héros. Les autres fonds (section Destinations, `.plx-fond-parent`) restent.
 */
class HerosVideo
{
    public static function sansImage(?string $html): string
    {
        $html = (string) $html;

        if (! str_contains($html, 'plx-diapos')) {
            return $html;
        }

        return preg_replace(
            '/(<div\b[^>]*\bid="plx-accueil"[^>]*>)\s*<img\b[^>]*\bplx-fond\b[^>]*>/i',
            '$1',
            $html,
            1
        ) ?? $html;
    }
}
