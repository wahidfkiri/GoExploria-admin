<?php

namespace Vendor\Cms\Support;

use Illuminate\Support\Facades\Log;

/**
 * Remplace, dans le HTML d'un template, les données de démonstration par celles
 * de l'établissement.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * LE PROBLÈME
 * ─────────────────────────────────────────────────────────────────────────
 *
 * Le contenu d'un template est une chaîne HTML figée, copiée telle quelle sur
 * chaque établissement. Sans traitement, tous les sites d'un même template
 * affichent l'adresse, le téléphone et la carte de la maquette.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * LE PRINCIPE
 * ─────────────────────────────────────────────────────────────────────────
 *
 * Le template marque les éléments concernés d'un attribut `data-gx-bind` et
 * GARDE ses valeurs de démonstration :
 *
 *     <p data-gx-bind="address">18 Avenue des Artisans, 69003 Lyon</p>
 *     <a href="tel:+33184602210" data-gx-bind="phone">01 84 60 22 10</a>
 *
 * Trois conséquences voulues :
 *
 *   · L'ÉDITEUR affiche un texte lisible, pas un gabarit `{{ … }}`. Ce que
 *     l'utilisateur voit est ce qu'il modifie.
 *   · Une donnée non renseignée laisse la valeur de démonstration en place :
 *     jamais de trou ni de « null » sur le site.
 *   · Le remplacement a lieu au RENDU, jamais en base : corriger la fiche de
 *     l'établissement suffit, il n'y a rien à réinstaller.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * POURQUOI DES EXPRESSIONS RÉGULIÈRES ET PAS UN PARSEUR
 * ─────────────────────────────────────────────────────────────────────────
 *
 * DOMDocument ne connaît que HTML 4 : sur ces templates — 150 Ko, SVG en ligne,
 * attributs booléens — il réécrit le document à la sérialisation et casse le
 * balisage. Le risque est disproportionné pour remplacer une quinzaine de
 * valeurs.
 *
 * Le remplacement de texte est donc volontairement limité aux éléments SANS
 * balise imbriquée : le motif capture `[^<]*`, il lui est structurellement
 * impossible d'avaler du balisage. Un élément qui en contient garde son
 * contenu ; seuls ses attributs (href, src) sont ajustés. Le template
 * enveloppe pour cette raison le numéro de l'en-tête dans un `<span>`.
 */
class TemplateDataBinder
{
    /**
     * @param  object|null  $etablissement
     * @param  array{lat?:float|string|null,lng?:float|string|null,hours?:array}  $extra
     */
    public static function bind(?string $html, $etablissement, array $extra = []): string
    {
        $html = (string) $html;

        if ($html === '' || ! $etablissement || ! str_contains($html, 'data-gx-bind')) {
            return $html;
        }

        try {
            $valeurs = self::valeurs($etablissement, $extra);

            foreach ($valeurs as $cle => $valeur) {
                if ($valeur === null || $valeur === '') {
                    continue;   // donnée absente : la valeur de démonstration reste
                }

                $html = self::appliquer($html, $cle, $valeur);
            }

            $html = self::appliquerCarte($html, $extra);
        } catch (\Throwable $e) {
            // Un site qui s'affiche avec les valeurs de démonstration vaut mieux
            // qu'un site qui ne s'affiche pas.
            Log::warning('TemplateDataBinder : liaison abandonnée — ' . $e->getMessage());
        }

        return $html;
    }

    /** @return array<string,string|null> */
    private static function valeurs($e, array $extra): array
    {
        $telephone = self::premier($e, ['phone', 'telephone', 'tel', 'mobile']);
        $adresse   = self::premier($e, ['address', 'adresse']);
        $ville     = self::premier($e, ['ville', 'city']);

        if ($adresse && $ville && ! str_contains(mb_strtolower($adresse), mb_strtolower($ville))) {
            $adresse .= ', ' . $ville;
        }

        $valeurs = [
            'name'    => self::premier($e, ['name', 'nom', 'title']),
            'phone'   => $telephone,
            'email'   => self::premier($e, ['email', 'mail']),
            'address' => $adresse,
            'city'    => $ville,
        ];

        // Horaires : hours.0 (dimanche) … hours.6 (samedi), même numérotation
        // que Date::getDay() côté navigateur, celle qu'emploie le template.
        foreach (self::horaires($extra) as $jour => $plage) {
            $valeurs['hours.' . $jour] = $plage;
        }

        return $valeurs;
    }

    /**
     * Horaires par jour de semaine, à partir de ce que fournit le contrôleur.
     *
     * @return array<int,string>
     */
    private static function horaires(array $extra): array
    {
        $source = $extra['hours'] ?? null;

        if (! is_array($source) || ! $source) {
            return [];
        }

        $jours = [
            'dimanche' => 0, 'sunday' => 0, 'sun' => 0,
            'lundi'    => 1, 'monday' => 1, 'mon' => 1,
            'mardi'    => 2, 'tuesday' => 2, 'tue' => 2,
            'mercredi' => 3, 'wednesday' => 3, 'wed' => 3,
            'jeudi'    => 4, 'thursday' => 4, 'thu' => 4,
            'vendredi' => 5, 'friday' => 5, 'fri' => 5,
            'samedi'   => 6, 'saturday' => 6, 'sat' => 6,
        ];

        $resultat = [];

        foreach ($source as $cle => $ligne) {
            $nom = is_array($ligne)
                ? mb_strtolower(trim((string) ($ligne['day'] ?? $ligne['jour'] ?? $ligne['label'] ?? $cle)))
                : mb_strtolower(trim((string) $cle));

            $index = $jours[$nom] ?? (is_int($cle) && $cle >= 0 && $cle <= 6 ? $cle : null);

            if ($index === null) {
                continue;
            }

            $plage = is_array($ligne)
                ? trim((string) ($ligne['hours'] ?? $ligne['value'] ?? $ligne['horaire'] ?? ''))
                : trim((string) $ligne);

            if ($plage !== '') {
                $resultat[$index] = $plage;
            }
        }

        return $resultat;
    }

    /** Première propriété non vide parmi les noms proposés. */
    private static function premier($e, array $noms): ?string
    {
        foreach ($noms as $nom) {
            $v = null;

            try {
                $v = $e->{$nom} ?? null;
            } catch (\Throwable $ex) {
                continue;   // accesseur absent ou en erreur : on passe au suivant
            }

            if (is_scalar($v) && trim((string) $v) !== '') {
                return trim((string) $v);
            }
        }

        return null;
    }

    /** Pose la valeur sur tous les éléments marqués de cette clé. */
    private static function appliquer(string $html, string $cle, string $valeur): string
    {
        $marque = 'data-gx-bind="' . preg_quote($cle, '/') . '"';
        $texte  = htmlspecialchars($valeur, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        // 1. href des liens d'appel et de courriel, sur la balise ouvrante.
        if ($cle === 'phone') {
            $html = preg_replace_callback(
                '/<a\b([^>]*' . $marque . '[^>]*)>/i',
                fn ($m) => '<a' . self::remplacerAttribut($m[1], 'href', 'tel:' . self::numeroLien($valeur)) . '>',
                $html
            );
        } elseif ($cle === 'email') {
            $html = preg_replace_callback(
                '/<a\b([^>]*' . $marque . '[^>]*)>/i',
                fn ($m) => '<a' . self::remplacerAttribut($m[1], 'href', 'mailto:' . $valeur) . '>',
                $html
            );
        }

        // 2. Texte, uniquement sur les éléments sans balise imbriquée. `[^<]*`
        //    rend impossible d'avaler du balisage : un élément qui en contient
        //    ne correspond simplement pas au motif et reste intact.
        return preg_replace(
            '/(<([a-z][a-z0-9]*)\b[^>]*' . $marque . '[^>]*>)([^<]*)(<\/\2>)/i',
            '${1}' . str_replace('$', '\$', $texte) . '${4}',
            $html
        );
    }

    /** Recentre la carte sur les coordonnées de l'établissement. */
    private static function appliquerCarte(string $html, array $extra): string
    {
        $lat = $extra['lat'] ?? null;
        $lng = $extra['lng'] ?? null;

        if (! is_numeric($lat) || ! is_numeric($lng)) {
            return $html;
        }

        $lat = (float) $lat;
        $lng = (float) $lng;
        $d   = 0.02;   // même cadrage que la maquette

        $src = sprintf(
            'https://www.openstreetmap.org/export/embed.html?bbox=%s%%2C%s%%2C%s%%2C%s&layer=mapnik&marker=%s%%2C%s',
            round($lng - $d, 5), round($lat - $d, 5), round($lng + $d, 5), round($lat + $d, 5),
            round($lat, 5), round($lng, 5)
        );

        return preg_replace_callback(
            '/<iframe\b([^>]*data-gx-bind="map"[^>]*)>/i',
            fn ($m) => '<iframe' . self::remplacerAttribut($m[1], 'src', $src) . '>',
            $html
        );
    }

    /** Remplace (ou ajoute) un attribut dans une chaîne d'attributs. */
    private static function remplacerAttribut(string $attributs, string $nom, string $valeur): string
    {
        $echappee = htmlspecialchars($valeur, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $motif    = '/\s' . preg_quote($nom, '/') . '="[^"]*"/i';

        if (preg_match($motif, $attributs)) {
            return preg_replace($motif, ' ' . $nom . '="' . str_replace('$', '\$', $echappee) . '"', $attributs, 1);
        }

        return $attributs . ' ' . $nom . '="' . $echappee . '"';
    }

    /** Numéro utilisable dans un href tel: — chiffres et « + » seulement. */
    private static function numeroLien(string $numero): string
    {
        return preg_replace('/[^\d+]/', '', $numero) ?: $numero;
    }
}
