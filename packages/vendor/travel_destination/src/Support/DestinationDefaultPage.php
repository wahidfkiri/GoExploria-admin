<?php

namespace Vendor\TravelDestination\Support;

use App\Models\Page;
use Illuminate\Support\Str;

/**
 * LA page de destination, côté site public.
 *
 * Chaque destination en possède une, mais la ligne `pages` n'est créée que
 * lorsque l'administrateur y touche (édition, publication/masquage,
 * réinitialisation). Tant qu'elle n'existe pas, on rend le gabarit
 * « Carnet d'Atlas » tel quel :
 *
 *   - pas de duplication de ~95 Ko de HTML identique par destination ;
 *   - les destinations jamais retouchées suivent les évolutions du gabarit.
 *
 * Le gabarit est un fichier généré par
 * `admin/scripts/build_destination_template.py`, qui en dépose une copie ici
 * (les deux projets sont déployés séparément).
 */
class DestinationDefaultPage
{
    /** @var array{html: string, css: string}|null */
    private static ?array $template = null;

    public static function stubPath(): string
    {
        return __DIR__ . '/../../resources/templates/destination-default/index.html';
    }

    /**
     * Contenu à injecter pour une destination, ou `null` si la page a été
     * masquée par l'administrateur (ou si le gabarit est introuvable).
     *
     * @return array{slug: string, css: string, html: string}|null
     */
    public static function resolve($entity): ?array
    {
        $row = Page::where('pageable_type', get_class($entity))
            ->where('pageable_id', $entity->id)
            ->where('is_default', true)
            ->first();

        if ($row !== null) {
            // Masquée : la destination n'affiche aucune page de contenu.
            if (! $row->is_active) {
                return null;
            }

            return [
                'slug' => $row->slug,
                'css'  => self::stripEditorCss($row->css_content),
                'html' => (string) $row->html_content,
            ];
        }

        $template = self::template();

        if ($template === null) {
            return null;
        }

        return [
            'slug' => Str::slug(($entity->name ?? 'destination') . '-page') ?: 'page-destination',
            'css'  => $template['css'],
            'html' => self::personalize($template['html'], $entity),
        ];
    }

    /**
     * Le héros en diaporama du gabarit, personnalisé pour la destination.
     * `null` si le gabarit n'en porte pas.
     *
     * Sert de repli (2026-09-16) : une page de destination enregistrée AVANT
     * l'arrivée du héros n'en contient pas, et la destination retombait sur
     * l'ancienne bannière statique (constaté sur le Canada, niveau pays). Ses
     * styles sont déjà dans destination-atlas.css, non scopé : aucune feuille
     * à émettre avec lui.
     */
    public static function heroSection($entity): ?string
    {
        $template = self::template();

        if ($template === null
            || ! preg_match('/<section\b[^>]*data-gx-destination-hero\b[^>]*>.*?<\/section>/is', $template['html'], $m)) {
            return null;
        }

        return self::personalize($m[0], $entity);
    }

    /**
     * Mur vidéo (demande du 2026-09-17) sur une page par défaut enregistrée
     * avant son arrivée : le bloc du gabarit, après la section vidéo (à
     * défaut, avant les hébergements). Proposé UNE fois — la racine
     * `.gx-dest-tpl` porte alors `data-gx-mur-video`, et un bloc supprimé par
     * le client ne revient pas. Même logique que
     * DestinationDefaultTemplate::addVideoWall() côté admin.
     */
    public static function avecMurVideo(string $html): string
    {
        if (str_contains($html, 'data-gx-mur-video') || str_contains($html, 'data-name="gx-video-wall"')) {
            return $html;
        }

        $template = self::template();

        if ($template === null
            || ! preg_match('/<section\b[^>]*\bdata-name="gx-video-wall"[^>]*>.*?<\/section>/is', $template['html'], $mur)
            || ! preg_match('/<div\b[^>]*class="[^"]*\bgx-dest-tpl\b[^"]*"[^>]*>/i', $html, $racine, PREG_OFFSET_CAPTURE)) {
            return $html;
        }

        if (preg_match('/<section\b[^>]*\bid="video"[^>]*>.*?<\/section>/is', $html, $ancre, PREG_OFFSET_CAPTURE)) {
            $html = substr_replace($html, "\n" . $mur[0], $ancre[0][1] + strlen($ancre[0][0]), 0);
        } elseif (preg_match('/<section\b[^>]*\bid="hebergements"/i', $html, $ancre, PREG_OFFSET_CAPTURE)) {
            $html = substr_replace($html, $mur[0] . "\n", $ancre[0][1], 0);
        } else {
            return $html;
        }

        $finOuverture = $racine[0][1] + strlen($racine[0][0]) - 1;

        return substr_replace($html, ' data-gx-mur-video="propose"', $finOuverture, 0);
    }

    /**
     * Section « Établissements à proximité » (2026-09-24) sur une page
     * enregistrée avant son arrivée : le bloc du gabarit, posé avant les
     * activités (à défaut, avant les hébergements).
     *
     * Proposée UNE fois, comme le mur vidéo : repère `data-gx-etab-propose`
     * sur la racine, donc une section supprimée par le client ne revient pas.
     * Ses cartes sont ensuite remplies par TemplateEtablissements, comme
     * celles du gabarit.
     */
    public static function avecEtablissements(string $html): string
    {
        if (str_contains($html, 'data-gx-etablissements') || str_contains($html, 'data-gx-etab-propose')) {
            return $html;
        }

        $template = self::template();

        if ($template === null
            || ! preg_match('/<section\b[^>]*\bid="etablissements"[^>]*>.*?<\/section>/is', $template['html'], $section)
            || ! preg_match('/<div\b[^>]*class="[^"]*\bgx-dest-tpl\b[^"]*"[^>]*>/i', $html, $racine, PREG_OFFSET_CAPTURE)) {
            return $html;
        }

        if (preg_match('/<section\b[^>]*\bid="activites"/i', $html, $ancre, PREG_OFFSET_CAPTURE)) {
            $html = substr_replace($html, $section[0] . "\n", $ancre[0][1], 0);
        } elseif (preg_match('/<section\b[^>]*\bid="hebergements"/i', $html, $ancre, PREG_OFFSET_CAPTURE)) {
            $html = substr_replace($html, $section[0] . "\n", $ancre[0][1], 0);
        } else {
            return $html;
        }

        $finOuverture = $racine[0][1] + strlen($racine[0][0]) - 1;

        return substr_replace($html, ' data-gx-etab-propose="propose"', $finOuverture, 0);
    }

    /**
     * Héros : des vidéos seulement (demande du 2026-09-16). Retire du héros
     * composé dans l'éditeur les diapositives qui ne portent qu'une image
     * (`<div class="hero-slide…"><img></div>`) ; les vidéos restent.
     *
     * Même geste que DestinationDefaultTemplate::removeImageSlides() côté
     * admin, qui l'applique à l'ouverture de l'éditeur et par la commande
     * destinations:hero-diaporama. Ici, au rendu : une page pas encore
     * ré-enregistrée n'affiche déjà plus ses images.
     *
     * Si le héros ne contient QUE des images, il est laissé tel quel : mieux
     * vaut des photos qu'une bannière vide.
     */
    public static function sansDiapositivesImage(string $html): string
    {
        $nouveau = preg_replace(
            '/\s*<div\b[^>]*class="[^"]*\bhero-slide\b[^"]*"[^>]*>\s*<img\b[^>]*>\s*<\/div>/i',
            '',
            $html
        ) ?? $html;

        if ($nouveau === $html || ! preg_match('/class="[^"]*\bhero-slide\b/i', $nouveau)) {
            return $html;
        }

        return $nouveau;
    }

    // =====================================================================
    // Règles d'édition publiées par erreur
    //
    // Jusqu'au 2026-09-16, le canvas de l'éditeur (admin) portait ses règles
    // d'édition dans un <style> en ligne, que la sauvegarde enregistrait avec
    // la feuille de la page. Sur le site, elles DÉPLIENT le diaporama du héros
    // en vignettes étiquetées (« Diapositive 1 · vidéo »…) et rendent les
    // vidéos inertes au clic. L'admin ne les enregistre plus et sait les
    // retirer (commande destinations:hero-diaporama) ; on les retire aussi ici,
    // au rendu, pour qu'aucune page pas encore nettoyée ne les affiche.
    //
    // Même logique que Vendor\Destination\Support\DestinationDefaultTemplate
    // ::stripEditorCss() côté admin — les deux projets sont déployés
    // séparément. Le bloc est reconnu par sa première ligne, commune à toutes
    // ses versions, et se termine sur la dernière ligne propre à sa version, de
    // la plus récente à la plus ancienne (une version récente contient aussi
    // les fins des précédentes).
    // =====================================================================

    private const EDITOR_CSS_START = 'html, body { margin: 0; padding: 0; min-height: 100%; }';

    private const EDITOR_CSS_ENDS = [
        'recouvrirait toute la page. */',
        '.gx-dest-tpl [data-gx-map-canvas] { pointer-events: none; }',
        'iframe, video { pointer-events: none !important; }',
    ];

    /** Retire d'une feuille de page les règles d'édition du canvas admin. */
    public static function stripEditorCss(?string $css): string
    {
        $css = (string) $css;

        if (! str_contains($css, self::EDITOR_CSS_START)) {
            return $css;
        }

        while (($debut = strpos($css, self::EDITOR_CSS_START)) !== false) {
            // Le bloc s'arrête au plus tard là où en commence un autre.
            $suivant = strpos($css, self::EDITOR_CSS_START, $debut + 1);
            $segment = substr($css, $debut, $suivant === false ? null : $suivant - $debut);

            $fin = null;
            foreach (self::EDITOR_CSS_ENDS as $marque) {
                $pos = strpos($segment, $marque);
                if ($pos !== false) {
                    $fin = $pos + strlen($marque);
                    break;
                }
            }

            // Début reconnu sans fin connue : on ne devine pas, on s'arrête.
            if ($fin === null) {
                break;
            }

            $css = substr($css, 0, $debut) . substr($css, $debut + $fin);
        }

        return trim($css);
    }

    /**
     * Gabarit lu une seule fois par requête, et séparé en corps + feuille comme
     * le fait la sauvegarde de l'éditeur.
     *
     * @return array{html: string, css: string}|null
     */
    private static function template(): ?array
    {
        if (self::$template !== null) {
            return self::$template;
        }

        $path = self::stubPath();

        if (! is_readable($path)) {
            return null;
        }

        $raw = (string) file_get_contents($path);
        $css = '';

        if (preg_match('/<style[^>]*>(.*?)<\/style>/is', $raw, $m)) {
            $css = trim($m[1]);
            $raw = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $raw, 1);
        }

        return self::$template = ['html' => trim((string) $raw), 'css' => $css];
    }

    /**
     * Mêmes substitutions que côté admin, pour que la page ouvre sur du contenu
     * déjà situé : nom de la maquette et coordonnées réelles.
     */
    private static function personalize(string $html, $entity): string
    {
        $name = trim((string) ($entity->name ?? ''));

        if ($name === '') {
            return $html;
        }

        $html = strtr($html, [
            'Baie-Saint-Paul' => $name,
            'BAIE-SAINT-PAUL' => Str::upper($name),
        ]);

        if (is_numeric($entity->latitude ?? null) && is_numeric($entity->longitude ?? null)) {
            $lat = (float) $entity->latitude;
            $lng = (float) $entity->longitude;

            $html = str_replace(
                '47.4501° N, 70.5019° O',
                sprintf(
                    '%.4f° %s, %.4f° %s',
                    abs($lat), $lat >= 0 ? 'N' : 'S',
                    abs($lng), $lng >= 0 ? 'E' : 'O'
                ),
                $html
            );
        }

        return $html;
    }
}
