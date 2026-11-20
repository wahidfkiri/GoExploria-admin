<?php

namespace Vendor\Cms\Support;

use App\Models\Etablissement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Vendor\Cms\Models\Property;

/**
 * GABARIT INTERNE — le site des établissements importés, sans copie.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * CE QUE C'EST, ET POURQUOI
 * ─────────────────────────────────────────────────────────────────────────
 *
 * Un établissement qui reçoit un gabarit CMS en reçoit une COPIE : le HTML du
 * template, sa feuille et ses scripts — de l'ordre de 500 Ko — sont recopiés
 * dans `etablissement_templates`, puis dans une `cms_pages` par page créée.
 * Multiplié par les milliers de fiches reprises d'annuaires, c'est la
 * principale masse de la base (`cms_pages` : 11 Go pour 97 000 lignes).
 *
 * Ces copies ne servent à rien tant que personne n'a ouvert l'éditeur : ce
 * sont mille exemplaires identiques du même gabarit, à un nom et une adresse
 * près. Le gabarit interne les remplace par UN SEUL fichier de vue, rendu à
 * la volée avec les données de l'établissement.
 *
 *   · rien n'est écrit en base ni au dépôt de fichiers ;
 *   · une correction du gabarit profite à TOUS les sites concernés, sans
 *     repasser sur chaque établissement ;
 *   · l'établissement garde ses données — médias, horaires, carte, produits,
 *     biens, articles : ce sont elles que la vue affiche.
 *
 * ⚠ En contrepartie, ce site N'EST PAS MODIFIABLE dans l'éditeur Vvveb : il
 * n'y a pas de contenu à éditer. C'est le prix à payer, et il est assumé —
 * l'établissement n'a rien demandé, personne ne l'a encore ouvert. Le jour où
 * il devient client, on lui installe un vrai gabarit : [[actif]] redevient
 * faux et le site bascule sur la copie, sans rien perdre.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * OÙ VIVENT LES DONNÉES
 * ─────────────────────────────────────────────────────────────────────────
 *
 * Nulle part de nouveau. Chaque section lit la MÊME source que la grille de
 * template correspondante, par `donnees()` du socle [[TemplateGrid]] : le
 * catalogue, les rayons, les activités, les forfaits, les articles et les
 * lieux voisins sortent des requêtes déjà écrites pour les gabarits. Deux
 * requêtes jumelles auraient dérivé au premier filtre ajouté d'un seul côté.
 */
class GabaritInterne
{
    /** Classe d'enveloppe de la vue. Sert aussi de repère aux greffes du site. */
    public const ENVELOPPE = 'gxi-tpl';

    /** Colonne qui marque un établissement servi par ce gabarit. */
    public const COLONNE = 'site_interne';

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

        if (! $colonne) {
            return false;
        }

        return (bool) $etablissement->getAttribute(self::COLONNE);
    }

    /**
     * Les modules de l'espace entreprise, tels que la vue les attend.
     *
     * Chaque entrée est une collection — vide quand l'onglet n'a rien à
     * montrer. La vue masque alors la section : un site d'établissement
     * importé n'affiche pas une boutique de démonstration.
     */
    public static function modules($etablissement): array
    {
        $id = (int) ($etablissement->id ?? 0);

        if ($id <= 0) {
            return self::vide();
        }

        $biens = self::biens($id);

        return [
            'rayons' => TemplateCategories::donnees($id, 8),
            'produits' => TemplateProducts::donnees($id, 8),
            'activites' => TemplateActivities::donnees($id, 8),
            'articles' => TemplatePosts::donnees($id, 6),
            'proximite' => TemplateNearby::liste($id, 9, 30),
            'hebergements' => $biens['hebergements'],
            'forfaits' => $biens['forfaits'],
            'vehicules' => $biens['vehicules'],
        ];
    }

    /** @return array{rayons:\Illuminate\Support\Collection,produits:\Illuminate\Support\Collection,activites:\Illuminate\Support\Collection,articles:\Illuminate\Support\Collection,proximite:\Illuminate\Support\Collection,hebergements:\Illuminate\Support\Collection,forfaits:\Illuminate\Support\Collection,vehicules:\Illuminate\Support\Collection} */
    private static function vide(): array
    {
        return [
            'rayons' => collect(), 'produits' => collect(), 'activites' => collect(),
            'articles' => collect(), 'proximite' => collect(),
            'hebergements' => collect(), 'forfaits' => collect(), 'vehicules' => collect(),
        ];
    }

    /* ─────────────────────────────────────────────────────────────────────
       BIENS — un seul passage, trois paniers

       L'onglet Immobilier ne distingue pas l'hébergement du forfait ni du
       véhicule : c'est le TYPE saisi qui le dit. On applique ici la règle des
       gabarits — mot du véhicule d'abord, car « Forfait VUS 3 jours » est une
       location de voiture et non une escapade — et on range chaque bien une
       fois pour toutes, plutôt que de relire la table trois fois.
       ───────────────────────────────────────────────────────────────────── */

    /** ⚠ `automobile`, pas `auto` : le mot nu attrape « forfait automne ». */
    private const MOTS_VEHICULE = '/voiture|v[ée]hicule|automobile|\bvus\b|\bsuv\b|berline|camionnette|fourgonnette|minivan|\b4x4\b|scooter|\bmoto\b|motoneige|\bquad\b|caravane|\bvr\b/iu';
    private const MOTS_FORFAIT = '/forfait|s[ée]jour|escapade|circuit|itin[ée]raire|package|exp[ée]dition|croisi[èe]re|weekend|week-end/iu';

    private static function biens(int $etablissementId): array
    {
        $paniers = ['hebergements' => collect(), 'forfaits' => collect(), 'vehicules' => collect()];

        try {
            if (! class_exists(Property::class)
                || ! Schema::connection('cms')->hasTable('cms_properties')) {
                return $paniers;
            }

            $biens = Property::forEtablissement($etablissementId)
                ->visible()
                ->orderBy('position')
                ->orderByDesc('id')
                ->limit(60)
                ->get();
        } catch (\Throwable $e) {
            Log::warning('GabaritInterne : biens illisibles — ' . $e->getMessage(), [
                'etablissement_id' => $etablissementId,
            ]);

            return $paniers;
        }

        foreach ($biens as $bien) {
            $paniers[self::panier($bien)]->push($bien);
        }

        return $paniers;
    }

    private static function panier(Property $bien): string
    {
        $texte = trim(((string) $bien->type) . ' ' . ((string) $bien->title));

        if ($texte !== '' && preg_match(self::MOTS_VEHICULE, $texte)) {
            return 'vehicules';
        }

        return ($texte !== '' && preg_match(self::MOTS_FORFAIT, $texte))
            ? 'forfaits'
            : 'hebergements';
    }

    /* ─────────────────────────────────────────────────────────────────────
       PRÉSENTATION — de quoi la vue a besoin, sans logique dans le Blade
       ───────────────────────────────────────────────────────────────────── */

    /** Image d'un bien : sa photo de couverture, sinon la première de sa galerie. */
    public static function imageBien(Property $bien): ?string
    {
        foreach ([$bien->getAttribute('cover'), $bien->getAttribute('main_image'), $bien->getAttribute('image')] as $champ) {
            $url = ProductPresenter::url($champ);
            if ($url) {
                return $url;
            }
        }

        foreach ((array) $bien->gallery as $photo) {
            $url = ProductPresenter::url(is_array($photo) ? ($photo['url'] ?? $photo['path'] ?? null) : $photo);
            if ($url) {
                return $url;
            }
        }

        return null;
    }

    /** « 185 $ », « Sur demande ». */
    public static function prixBien(Property $bien): string
    {
        $montant = (float) ($bien->getAttribute('nightly_price') ?: $bien->getAttribute('price'));

        return $montant > 0
            ? ProductPresenter::montant($montant, (string) ($bien->getAttribute('currency') ?: ProductPresenter::SYMBOLE))
            : 'Sur demande';
    }

    /** Les deux compteurs et l'unité de prix ne se nomment pas pareil d'un panier à l'autre. */
    public static function libelles(string $panier): array
    {
        return match ($panier) {
            'forfaits' => ['capacite' => 'voyageur', 'second' => 'nuit', 'unite' => '/ forfait', 'badge' => 'Forfait'],
            'vehicules' => ['capacite' => 'passager', 'second' => 'bagage', 'unite' => '/ jour', 'badge' => 'Location'],
            default => ['capacite' => 'voyageur', 'second' => 'chambre', 'unite' => '/ nuit', 'badge' => 'Séjour'],
        };
    }

    public static function pluriel(?int $n, string $mot): string
    {
        return $n > 0 ? $n . ' ' . $mot . ($n > 1 ? 's' : '') : '';
    }

    /**
     * Adresse de consultation d'une vidéo (et non celle du lecteur embarqué) :
     * le bouton « Voir la vidéo » doit ouvrir YouTube, pas une iframe nue.
     */
    public static function pageVideo(?string $source): string
    {
        $source = trim((string) $source);

        if ($source === '') {
            return '';
        }

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/|v\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $source, $m)
            || preg_match('/^([A-Za-z0-9_-]{11})$/', $source, $m)) {
            return 'https://www.youtube.com/watch?v=' . $m[1];
        }

        if (preg_match('#vimeo\.com/(?:video/)?(\d+)#i', $source, $m)) {
            return 'https://vimeo.com/' . $m[1];
        }

        return preg_match('#^(https?:)?//#', $source) || str_starts_with($source, '/') ? $source : '';
    }

    /**
     * Adresse d'intégration d'une vidéo, MUETTE et sans lecture automatique.
     *
     * Muette : une page qui parle toute seule fait fermer l'onglet. Sans
     * lecture automatique : c'est au visiteur de la lancer.
     */
    public static function lecteurVideo(?string $source): string
    {
        $source = trim((string) $source);

        if ($source === '') {
            return '';
        }

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/|v\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $source, $m)
            || preg_match('/^([A-Za-z0-9_-]{11})$/', $source, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1] . '?rel=0&modestbranding=1&playsinline=1&mute=1';
        }

        if (preg_match('#vimeo\.com/(?:video/)?(\d+)#i', $source, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1] . '?muted=1';
        }

        return $source;
    }
}
