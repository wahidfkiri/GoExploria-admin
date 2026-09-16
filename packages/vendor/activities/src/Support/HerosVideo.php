<?php

namespace Vendor\Activities\Support;

/**
 * Bandeau (héros) de la page de site d'une activité : des vidéos seulement.
 *
 * Demandes du 2026-09-16 : plus d'image sous les vidéos, plus de bouton
 * « Voir la vidéo », plus de flèche « Défiler ». L'admin retire tout cela des
 * pages (à l'ouverture de l'éditeur et par
 * `activites:page-par-defaut --heros`) ; on le retire aussi ici, au rendu,
 * pour qu'une page déjà enregistrée ne l'affiche plus. Même logique que
 * Vendor\Activitie\Support\PageParDefaut côté admin — les deux projets sont
 * déployés séparément.
 */
class HerosVideo
{
    /** Tout le nettoyage du bandeau. */
    public static function nettoyer(?string $html): string
    {
        $html = static::sansImage($html);
        $html = static::retirerBlocs($html, 'video-bx2');

        return static::retirerBlocs($html, 'scroll-indicator');
    }

    /**
     * L'image qui ouvre le bandeau (`<img class="plx-fond">`) — seulement quand
     * le bandeau porte des vidéos : sans diaporama, elle reste le seul visuel
     * du héros. Les autres fonds (section Destinations, `.plx-fond-parent`)
     * restent.
     */
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

    /**
     * Retire chaque `<div>` portant la classe donnée, avec tout son contenu.
     * Le bloc est borné en comptant les `<div>` ouvrants et fermants ; un
     * balisage déséquilibré est laissé tel quel.
     */
    protected static function retirerBlocs(string $html, string $classe): string
    {
        $ouverture = '/<div\b[^>]*\bclass="(?:[^"]*\s)?' . preg_quote($classe, '/') . '(?:\s[^"]*)?"[^>]*>/i';

        while (preg_match($ouverture, $html, $m, PREG_OFFSET_CAPTURE)) {
            $debut = $m[0][1];
            $position = $debut + strlen($m[0][0]);
            $profondeur = 1;

            while ($profondeur > 0 && preg_match('/<(\/?)div\b[^>]*>/i', $html, $t, PREG_OFFSET_CAPTURE, $position)) {
                $profondeur += $t[1][0] === '/' ? -1 : 1;
                $position = $t[0][1] + strlen($t[0][0]);
            }

            if ($profondeur > 0) {
                break;
            }

            $html = substr($html, 0, $debut) . substr($html, $position);
        }

        return $html;
    }
}
