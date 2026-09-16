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
    /** Tout le nettoyage du bandeau, puis le mur vidéo s'il manque. */
    public static function nettoyer(?string $html): string
    {
        $html = static::sansImage($html);
        $html = static::retirerBlocs($html, 'video-bx2');
        $html = static::retirerBlocs($html, 'scroll-indicator');

        return static::avecMurVideo($html);
    }

    /**
     * Le mur vidéo (demande du 2026-09-17) sur une page enregistrée avant son
     * arrivée : après la section vidéo, à défaut avant la section
     * Destinations. Proposé UNE fois — la racine porte alors
     * `data-gx-mur-video`, et un bloc supprimé par le client ne revient pas.
     * Même logique que PageParDefaut::ajouterMurVideo() côté admin ; le
     * fragment (stubs/mur-video.html) est déposé par
     * admin/scripts/build_activity_default_page.py.
     */
    public static function avecMurVideo(string $html): string
    {
        if (str_contains($html, 'data-gx-mur-video') || str_contains($html, 'data-name="gx-video-wall"')) {
            return $html;
        }

        $mur = trim((string) @file_get_contents(__DIR__ . '/stubs/mur-video.html'));

        if ($mur === ''
            || ! preg_match('/<div\b[^>]*class="[^"]*\bactpage-tpl\b[^"]*"[^>]*>/i', $html, $racine, PREG_OFFSET_CAPTURE)) {
            return $html;
        }

        if (preg_match('/<section\b[^>]*\bid="plx-video"[^>]*>.*?<\/section>/is', $html, $ancre, PREG_OFFSET_CAPTURE)) {
            $html = substr_replace($html, $mur . "\n", $ancre[0][1] + strlen($ancre[0][0]), 0);
        } elseif (preg_match('/<section\b[^>]*\bid="plx-destinations"/i', $html, $ancre, PREG_OFFSET_CAPTURE)) {
            $html = substr_replace($html, $mur . "\n", $ancre[0][1], 0);
        } else {
            return $html;
        }

        $finOuverture = $racine[0][1] + strlen($racine[0][0]) - 1;

        return substr_replace($html, ' data-gx-mur-video="propose"', $finOuverture, 0);
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
