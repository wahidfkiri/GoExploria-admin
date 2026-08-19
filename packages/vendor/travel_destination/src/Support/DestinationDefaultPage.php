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
                'css'  => (string) $row->css_content,
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
