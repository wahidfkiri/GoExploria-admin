<?php

namespace Vendor\Cms\Support;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

/**
 * GABARIT INTERNE — le site des établissements importés, sans copie.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * CE QUE C'EST, ET POURQUOI
 * ─────────────────────────────────────────────────────────────────────────
 *
 * Un établissement qui reçoit un gabarit CMS en reçoit une COPIE : le HTML du
 * template — un demi-mégaoctet — est recopié dans `etablissement_templates`,
 * puis dans une `cms_pages` par page créée. Multiplié par les milliers de
 * fiches reprises d'annuaires, c'est la principale masse de la base
 * (`cms_pages` : 11 Go pour 97 000 lignes), et ce sont mille exemplaires du
 * même gabarit à un nom et une adresse près.
 *
 * Ici, DEUX FICHIERS sur le disque servent tous ces sites :
 *
 *   packages/vendor/cms/resources/gabarit-interne/code.html   (le gabarit)
 *   public/vendor/cms/gabarit-interne/code.css                (sa feuille)
 *
 * Le HTML est lu à chaque rendu et rempli avec les données de l'établissement
 * par la MÊME chaîne d'hydratation que les gabarits installés
 * (WebThemeController::hydraterContenuTemplate) : nom, coordonnées, horaires,
 * catalogue, rayons, activités, forfaits, articles, lieux voisins, carte.
 *
 *   · rien n'est écrit en base ni au dépôt de fichiers ;
 *   · corriger les deux fichiers corrige TOUS les sites d'un coup ;
 *   · la feuille est un fichier statique : le navigateur la met en cache une
 *     fois pour toutes, au lieu de la retélécharger site après site.
 *
 * ⚠ En contrepartie, ce site N'EST PAS MODIFIABLE dans l'éditeur Vvveb : il
 * n'y a pas de contenu à éditer. C'est le prix, et il est assumé —
 * l'établissement n'a rien demandé, personne ne l'a encore ouvert. Le jour où
 * il devient client, on lui installe un vrai gabarit : [[TemplateInstaller]]
 * remet `site_interne` à 0 et le site bascule sur sa copie, sans rien perdre.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * METTRE LE GABARIT À JOUR
 * ─────────────────────────────────────────────────────────────────────────
 *
 * Remplacer les deux fichiers, et rien d'autre. La version de la feuille
 * suit sa date de modification : le navigateur la recharge tout seul.
 */
class GabaritInterne
{
    /** Colonne qui marque un établissement servi par ce gabarit. */
    public const COLONNE = 'site_interne';

    /** Classe d'enveloppe du gabarit livré (Horizon). Sert aux greffes du site. */
    public const ENVELOPPE = 'hz-tpl';

    /** Le gabarit, relatif à la racine du paquet CMS. */
    private const SOURCE = '/resources/gabarit-interne/code.html';

    /** Sa feuille, servie en statique depuis `public/`. */
    private const FEUILLE = 'vendor/cms/gabarit-interne/code.css';

    /**
     * Cet établissement est-il servi par le gabarit interne ?
     *
     * ⚠ La colonne peut manquer : le front est déployé à la main, et rien ne
     * garantit qu'il tourne sur une base déjà migrée. Dans le doute on répond
     * NON, et le site retombe sur le comportement d'avant.
     */
    public static function actif($etablissement): bool
    {
        if (! $etablissement) {
            return false;
        }

        static $colonne = null;

        if ($colonne === null) {
            try {
                $colonne = Schema::hasColumn('etablissements', self::COLONNE);
            } catch (\Throwable $e) {
                $colonne = false;
            }
        }

        return $colonne && (bool) $etablissement->getAttribute(self::COLONNE);
    }

    /** Chemin du gabarit sur le disque. */
    public static function chemin(): string
    {
        return dirname(__DIR__, 2) . self::SOURCE;
    }

    /**
     * Le gabarit, tel qu'il est sur le disque.
     *
     * Mémorisé pour la durée de la requête : une page peut le demander deux
     * fois, et c'est un demi-mégaoctet à relire.
     */
    public static function source(): string
    {
        static $source = null;

        if ($source !== null) {
            return $source;
        }

        $chemin = self::chemin();

        if (! is_file($chemin) || ! is_readable($chemin)) {
            Log::error('Gabarit interne introuvable : ' . $chemin);

            return $source = '';
        }

        return $source = (string) file_get_contents($chemin);
    }

    /**
     * Adresse de la feuille, horodatée.
     *
     * La date de modification sert de version : remplacer le fichier suffit à
     * faire recharger la feuille chez tous les visiteurs, sans vider de cache
     * ni toucher au code.
     */
    public static function feuille(): string
    {
        $chemin = public_path(self::FEUILLE);
        $version = is_file($chemin) ? (string) filemtime($chemin) : '0';

        return asset(self::FEUILLE) . '?v=' . $version;
    }

    /**
     * Sépare les `<link>` de tête du corps du gabarit.
     *
     * Le fichier livré commence par ses feuilles externes (polices, icônes),
     * puis vient `<div class="hz-tpl">`. Les laisser dans le corps marche —
     * les navigateurs les remontent — mais le document est alors invalide et,
     * surtout, la page s'affiche un instant sans style. On les met donc où
     * elles vont : dans le `<head>`.
     *
     * Les doublons sont écartés au passage : le fichier répète la même police
     * et la même feuille d'icônes une dizaine de fois, héritage des blocs
     * d'accueil empilés dans l'éditeur.
     *
     * @return array{liens:string, corps:string}
     */
    public static function decouper(string $html): array
    {
        $liens = [];

        // On ne regarde QUE le début : un `<link>` au milieu du corps
        // appartient à un bloc, et le déplacer changerait l'ordre des règles.
        $corps = preg_replace_callback(
            '#\A(?:\s*<link\b[^>]*>)+#i',
            function (array $m) use (&$liens) {
                preg_match_all('#<link\b[^>]*>#i', $m[0], $trouves);

                foreach ($trouves[0] as $lien) {
                    $cle = preg_match('#href\s*=\s*"([^"]*)"#i', $lien, $h)
                        ? strtolower(trim($h[1]))
                        : strtolower($lien);

                    $liens[$cle] = $lien;
                }

                return '';
            },
            $html,
            1
        );

        return [
            'liens' => implode("\n", $liens),
            'corps' => ltrim((string) $corps),
        ];
    }
}
