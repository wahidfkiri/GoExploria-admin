<?php

namespace Vendor\Welcome\Support;

/**
 * Prépare un contenu CMS à être INSÉRÉ dans une page qui ne lui appartient pas.
 *
 * LE PROBLÈME
 *
 * Un contenu CMS est fait pour vivre dans une page à lui (voir
 * `cms::web.fallback.cms-page`) : sa feuille de style y est seule et peut
 * écrire `body { … }` sans conséquence. Ici, on l'insère au milieu de la page
 * d'accueil, sous un en-tête, un héro et une carte qui restent rendus par le
 * site. Posée après les feuilles du site, la feuille du gabarit gagne la
 * cascade — mesuré sur le gabarit GoExploria : 63 règles atteignaient l'en-tête
 * du site (`.header-nav`, `.nav-container`, `.logo`, `.menu-toggle`,
 * `.nav-devis-btn`, `.lang-*`), plus `body`, `html` et quatre `:root`.
 *
 * Ces règles ne sont pas des scories : elles habillent l'en-tête que le gabarit
 * emporte avec lui, et un établissement qui affiche cet en-tête en a besoin.
 * Les retirer du gabarit casserait son site. La correction appartient donc au
 * point d'insertion, pas au gabarit.
 *
 * LA CORRECTION
 *
 * Chaque sélecteur est préfixé par l'identifiant du conteneur : une règle ne
 * peut alors plus désigner que des éléments du contenu inséré. `html`, `body`
 * et `:root` deviennent le conteneur lui-même — les variables CSS restent donc
 * disponibles pour tout ce qu'il contient.
 *
 * DEUX EXCEPTIONS, VOULUES
 *
 *   • `@keyframes` et `@font-face` n'ont pas de sélecteur ;
 *   • les sélecteurs `html.gx-tpl-verrou` / `html.gx-tpl-edition` restent sur
 *     `<html>` : ce sont les classes d'exécution du §5 de
 *     docs/TEMPLATES-CMS.md, posées hors du contenu enregistré, et les
 *     déplacer les rendrait inopérantes.
 *
 * Le résultat est stable pour un contenu donné : mettez-le en cache.
 */
class ContenuCmsIntegre
{
    /** Classes d'exécution qui doivent rester sur <html>. */
    protected const RACINES_CONSERVEES = ['gx-tpl-verrou', 'gx-tpl-edition'];

    /**
     * @param string $contenu  `cms_pages.content` : un <style> puis le wrapper
     * @param string $racine   identifiant du conteneur, sans le dièse
     */
    public static function preparer(string $contenu, string $racine = 'gx-accueil-cms'): string
    {
        $contenu = trim($contenu);

        if ($contenu === '') {
            return '';
        }

        $portee = '#' . $racine;

        $contenu = self::retirerRegions($contenu);

        $contenu = preg_replace_callback(
            '/<style\b[^>]*>(.*?)<\/style>/is',
            fn ($m) => '<style>' . self::cloisonner($m[1], $portee) . '</style>',
            $contenu
        );

        return '<div id="' . e($racine) . '">' . $contenu . '</div>';
    }

    /**
     * Retire l'en-tête et le pied du gabarit s'ils sont restés dans le contenu.
     *
     * La page garde les siens : le site est déjà coiffé de son en-tête, de son
     * héro et de sa carte quand ce contenu s'insère dessous. Normalement
     * l'installation les a déjà déplacés vers `cms_header_footers` (§6 de
     * docs/TEMPLATES-CMS.md) et il n'y a rien à retirer ; mais un contenu collé
     * à la main ou importé autrement les emporte, et la page afficherait alors
     * deux en-têtes.
     *
     * Ne vise que les régions marquées : l'en-tête `.gx-header-region` et le
     * pied `.*-tpl-footer` du gabarit. Les vingt-et-une barres
     * `<nav class="snb-bar">` sont des navigations de section : elles font
     * partie du contenu et restent. Un conteneur `data-cms-region` resté autour
     * se retrouve vide, ce qui ne se voit pas.
     */
    protected static function retirerRegions(string $contenu): string
    {
        $motifs = [
            '/<nav\b[^>]*class="[^"]*gx-header-region[^"]*"[^>]*>.*?<\/nav>/is',
            '/<footer\b[^>]*class="[^"]*-tpl-footer[^"]*"[^>]*>.*?<\/footer>/is',
        ];

        foreach ($motifs as $motif) {
            $reduit = preg_replace($motif, '', $contenu);
            // preg_replace renvoie null si le sujet épuise le moteur : dans ce
            // cas on préfère le contenu intact à une page vide.
            if ($reduit !== null) {
                $contenu = $reduit;
            }
        }

        return $contenu;
    }

    /** Préfixe tous les sélecteurs d'une feuille par `$portee`. */
    public static function cloisonner(string $css, string $portee): string
    {
        $sortie = '';
        $debut = 0;
        $i = 0;
        $n = strlen($css);

        while ($i < $n) {
            // Une règle @ sans bloc (`@import …;`, `@charset`) se termine par un
            // point-virgule. Sans ce cas, elle serait collée au sélecteur
            // suivant, qui commencerait alors par « @ » et échapperait au
            // cloisonnement — un `:root` entier passait ainsi au travers.
            if ($css[$i] === ';') {
                $sortie .= substr($css, $debut, $i - $debut + 1);
                $i++;
                $debut = $i;
                continue;
            }

            if ($css[$i] !== '{') {
                $i++;
                continue;
            }

            $selecteur = substr($css, $debut, $i - $debut);
            [$corps, $fin] = self::corps($css, $i);
            $nu = trim(self::sansCommentaires($selecteur));

            if ($nu === '') {
                // Commentaire seul avant une accolade : on ne touche à rien.
                $sortie .= $selecteur . $corps;
            } elseif ($nu[0] === '@') {
                // @media / @supports : on cloisonne l'intérieur.
                // @keyframes / @font-face : rien à préfixer.
                $sortie .= self::porteeInterne($nu)
                    ? $selecteur . '{' . self::cloisonner(substr($corps, 1, -1), $portee) . '}'
                    : $selecteur . $corps;
            } else {
                $sortie .= self::prefixer($selecteur, $portee) . $corps;
            }

            $i = $debut = $fin;
        }

        return $sortie . substr($css, $debut);
    }

    /** Le corps `{ … }` qui commence à `$i`, accolades imbriquées comprises. */
    protected static function corps(string $css, int $i): array
    {
        $profondeur = 0;
        $j = $i;
        $n = strlen($css);

        while ($j < $n) {
            if ($css[$j] === '{') {
                $profondeur++;
            } elseif ($css[$j] === '}') {
                $profondeur--;
                if ($profondeur === 0) {
                    $j++;
                    break;
                }
            }
            $j++;
        }

        return [substr($css, $i, $j - $i), $j];
    }

    /** Une règle @ dont le contenu est fait de sélecteurs ? */
    protected static function porteeInterne(string $regle): bool
    {
        return (bool) preg_match('/^@(media|supports|layer|container)\b/i', $regle);
    }

    protected static function sansCommentaires(string $texte): string
    {
        return preg_replace('#/\*.*?\*/#s', '', $texte);
    }

    /**
     * Préfixe chaque sélecteur d'une liste, en gardant commentaires et
     * indentation : la feuille reste lisible pour qui l'inspecte.
     */
    protected static function prefixer(string $selecteur, string $portee): string
    {
        // Les commentaires sont mis de côté puis remis tels quels devant.
        $commentaires = '';
        $selecteur = preg_replace_callback(
            '#/\*.*?\*/#s',
            function ($m) use (&$commentaires) {
                $commentaires .= $m[0];

                return '';
            },
            $selecteur
        );

        $parts = array_map('trim', explode(',', $selecteur));
        $parts = array_values(array_filter($parts, fn ($p) => $p !== ''));

        $prefixes = array_map(function ($p) use ($portee) {
            foreach (self::RACINES_CONSERVEES as $classe) {
                if (str_contains($p, $classe)) {
                    return $p;      // classe d'exécution : elle vit sur <html>
                }
            }

            // `html`, `body`, `:root` : la racine du contenu devient le conteneur.
            $sansRacine = preg_replace('/^(?:html|body|:root)\b\s*/i', '', $p, 1, $remplace);

            if ($remplace) {
                $sansRacine = trim($sansRacine);

                return $sansRacine === '' ? $portee : $portee . ' ' . $sansRacine;
            }

            return $portee . ' ' . $p;
        }, $parts);

        return $commentaires . "\n" . implode(',', $prefixes);
    }
}
