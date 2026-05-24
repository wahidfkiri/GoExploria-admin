<?php

namespace Vendor\Cms\Controllers\Web;

use App\Http\Controllers\Controller;
use Vendor\Cms\Models\Theme;
use Vendor\Cms\Models\Page;
use Vendor\Cms\Models\Setting;
use Vendor\Cms\Models\Media;
use App\Models\Etablissement;
use App\Models\Activity;
use App\Models\Plan;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class WebThemeController extends Controller
{
    protected $etablissement;
    protected $previewMode = false;

    /**
     * Constructeur - Récupère l'établissement depuis l'URL
     */
    public function __construct(Request $request, $etablissementId = null)
    {
        // Récupérer l'établissement uniquement depuis l'URL
        if ($etablissementId) {
            $this->etablissement = Etablissement::findOrFail($etablissementId);
        }
        
        // Vérifier le mode prévisualisation
        $this->checkPreviewMode($request);
    }

    /**
     * Affiche la page d'accueil avec le thème actif
     * Gère le paramètre GET preview_theme
     */
    public function home(Request $request, $etablissementId)
    {
        // Récupérer l'établissement
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;
        
        // Vérifier le paramètre preview_theme dans l'URL (GET)
        $previewThemeSlug = $request->query('preview_theme');
        
        if ($previewThemeSlug) {
            // Chercher le thème par slug (sans condition d'établissement)
            $previewTheme = Theme::where('slug', $previewThemeSlug)->first();
            
            if ($previewTheme) {
                $this->previewMode = true;
                // Stocker en session pour les pages suivantes
                session([
                    'theme_preview_mode' => true,
                    'preview_theme_id' => $previewTheme->id,
                    'preview_theme_slug' => $previewTheme->slug
                ]);
                $theme = $previewTheme;
            } else {
                $theme = $this->getThemeToUse();
            }
        } 
        // Vérifier la session
        elseif (session()->has('theme_preview_mode') && session('theme_preview_mode') === true) {
            $this->previewMode = true;
            $previewThemeId = session('preview_theme_id');
            if ($previewThemeId) {
                $previewTheme = Theme::find($previewThemeId);
                if ($previewTheme) {
                    $theme = $previewTheme;
                } else {
                    $this->previewMode = false;
                    session()->forget(['theme_preview_mode', 'preview_theme_id', 'preview_theme_slug']);
                    $theme = $this->getThemeToUse();
                }
            } else {
                $theme = $this->getThemeToUse();
            }
        } 
        else {
            $theme = $this->getThemeToUse();
        }
        
        if (!$theme) {
            return $this->renderNoThemeLanding('Aucun thème actif ou installé pour cet établissement.');
        }
        
        // Récupérer la page d'accueil
        $page = $this->getHomePage();
        
        if (!$page) {
            $page = $this->createDefaultHomePage();
        }
        
        return $this->renderTheme($theme, $page, $this->previewMode);
    }

    /**
     * Nettoyer le mode prévisualisation
     */
    public function clearPreview(Request $request, $etablissementId)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        
        // Nettoyer la session
        session()->forget(['theme_preview_mode', 'preview_theme_id', 'preview_theme_slug', 'preview_page_id', 'quick_preview']);
        
        // Rediriger vers la page d'accueil sans paramètre
        return redirect()->route('cms.company.home', ['etablissementId' => $etablissement->id]);
    }

    /**
     * Affiche une page avec le thème
     */
    public function showPage(Request $request, $etablissementId, $slug)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;
        
        $theme = $this->getThemeToUse();
        
        if (!$theme) {
            return $this->renderNoThemeLanding('Aucun thème actif ou installé pour cet établissement.');
        }
        
        $page = Page::where('etablissement_id', $this->etablissement->id)
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();
        
        if (!$page) {
            abort(404, 'Page non trouvée');
        }
        
        return $this->renderTheme($theme, $page);
    }

    /**
     * Prévisualisation publique d'un thème (sans authentification)
     */
    public function publicPreview(Request $request, $etablissementId, $id)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;
        
        $theme = Theme::findOrFail($id);
        
        // Stocker en session pour la prévisualisation
        session([
            'theme_preview_mode' => true,
            'preview_theme_id' => $theme->id,
            'preview_theme_slug' => $theme->slug
        ]);
        
        // Récupérer la page d'accueil
        $page = $this->getHomePage();
        
        if (!$page) {
            $page = $this->createDefaultHomePage();
        }
        
        return $this->renderTheme($theme, $page, true);
    }

    /**
     * Prévisualisation d'une page avec un thème spécifique
     */
    public function previewPage(Request $request, $etablissementId, $themeId, $pageId)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;
        
        $theme = Theme::findOrFail($themeId);
        $page = Page::findOrFail($pageId);
        
        return $this->renderTheme($theme, $page, true);
    }

    /**
     * Liste des thèmes disponibles pour l'établissement
     */
    public function index(Request $request, $etablissementId)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;
        
        // Récupérer les thèmes liés à l'établissement
        $themes = $etablissement->themes()
            ->orderByPivot('is_active', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $activeTheme = $etablissement->themes()
            ->wherePivot('is_active', true)
            ->first();
        
        return view('cms::web.themes.index', compact('themes', 'activeTheme', 'etablissement'));
    }

    /**
     * Détails d'un thème
     */
    public function show(Request $request, $etablissementId, $id)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;
        
        $theme = Theme::findOrFail($id);
        
        $screenshots = $this->getThemeScreenshots($theme);
        $config = $this->getThemeConfig($theme);
        
        return view('cms::web.themes.show', compact('theme', 'screenshots', 'config', 'etablissement'));
    }

    /**
     * Aperçu rapide d'un thème
     */
    public function quickPreview(Request $request, $etablissementId, $id)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;
        
        $theme = Theme::findOrFail($id);
        
        // Récupérer le contenu de démonstration
        $demoContent = $this->getDemoContent($theme);
        
        return $this->renderTheme($theme, null, true, $demoContent);
    }

    // App\Http\Controllers\PageWithIframeController.php
    public function preview($etablissementId)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        return view('cms::page-with-iframe', compact('etablissement'));
    }

    /**
 * Assets du thème (CSS, JS, images)
 */
public function asset($etablissementId, $themeId, $path)
{
    try {
        $theme = Theme::findOrFail($themeId);

        $assetPaths = [
            storage_path("app/public/cms/themes/{$etablissementId}/{$theme->slug}/assets/{$path}"),
            storage_path("app/public/cms/themes/{$theme->slug}/assets/{$path}"),
        ];

        $fullPath = null;
        foreach ($assetPaths as $candidate) {
            if (File::exists($candidate)) {
                $fullPath = str_replace('\\', '/', $candidate);
                break;
            }
        }

        if (!$fullPath) {
            abort(404);
        }
        
        $file = File::get($fullPath);
        $mimeType = File::mimeType($fullPath);
        $cacheControl = 'public, max-age=31536000, immutable';
        
        return response($file, 200, [
            'Content-Type' => $mimeType,
            'Content-Length' => File::size($fullPath),
            'Cache-Control' => $cacheControl,
        ]);
        
    } catch (\Exception $e) {
        Log::error('Theme asset error: ' . $e->getMessage());
        abort(404);
    }
}
    /**
     * Téléchargement d'un thème
     */
    public function download(Request $request, $etablissementId, $id)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;
        
        $theme = Theme::findOrFail($id);
        
        $themePath = $this->getThemePath($theme);
        
        if (!File::exists($themePath)) {
            abort(404, 'Dossier du thème introuvable');
        }
        
        $zipFile = tempnam(sys_get_temp_dir(), 'theme_') . '.zip';
        $zip = new \ZipArchive();
        
        if ($zip->open($zipFile, \ZipArchive::CREATE) !== true) {
            abort(500, 'Impossible de créer l\'archive');
        }
        
        $this->addDirectoryToZip($zip, $themePath, '');
        $zip->close();
        
        return response()->download($zipFile, $theme->slug . '.zip')->deleteFileAfterSend(true);
    }

    /**
     * Sitemap XML
     */
    public function sitemap(Request $request, $etablissementId)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;
        
        $pages = Page::where('etablissement_id', $this->etablissement->id)
            ->where('status', 'published')
            ->where('visibility', 'public')
            ->orderBy('updated_at', 'desc')
            ->get();
        
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        // Page d'accueil
        $sitemap .= '  <url>' . "\n";
        $sitemap .= '    <loc>' . e(url('/company/' . $etablissement->id)) . '</loc>' . "\n";
        $sitemap .= '    <priority>1.0</priority>' . "\n";
        $sitemap .= '  </url>' . "\n";
        
        foreach ($pages as $page) {
            $sitemap .= '  <url>' . "\n";
            $sitemap .= '    <loc>' . e(url('/company/' . $etablissement->id . '/page/' . $page->slug)) . '</loc>' . "\n";
            $sitemap .= '    <lastmod>' . $page->updated_at->format('Y-m-d') . '</lastmod>' . "\n";
            $sitemap .= '    <priority>0.8</priority>' . "\n";
            $sitemap .= '  </url>' . "\n";
        }
        
        $sitemap .= '</urlset>';
        
        return response($sitemap, 200, [
            'Content-Type' => 'application/xml',
            'Cache-Control' => 'public, max-age=3600'
        ]);
    }

    /**
     * Robots.txt
     */
    public function robots(Request $request, $etablissementId)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;
        
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Sitemap: " . url('/company/' . $etablissement->id . '/sitemap.xml') . "\n";
        
        // Disallow admin paths
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /login\n";
        
        return response($content, 200, [
            'Content-Type' => 'text/plain',
            'Cache-Control' => 'public, max-age=86400'
        ]);
    }

    // ============================================
    // MÉTHODES PRIVÉES
    // ============================================

    /**
 * Rendu du thème
 */
protected function renderTheme($theme, $page = null, $preview = false, $demoContent = null)
{
    $cacheKey = $this->getCacheKey($theme, $page);
    
    if (!$preview && config('cms.cache_pages', false) && Cache::has($cacheKey)) {
        $html = Cache::get($cacheKey);
        return $this->buildResponse($html, $this->buildSeoContext($page, $preview));
    }
    
    // Récupérer le chemin du thème avec l'ID de l'établissement
    $themePath = $this->getThemePath($theme);
    
    if (!$themePath || !File::exists($themePath)) {
        return $this->renderFallback("Le thème '{$theme->name}' est introuvable. Chemin: {$themePath}");
    }
    
    $layoutFile = $themePath . '/layout.blade.php';
    
    if (!File::exists($layoutFile)) {
        return $this->renderFallback("Le fichier layout.blade.php est manquant.");
    }
    
    try {
        // Enregistrer le namespace avec le chemin complet
        View::addNamespace('theme', $themePath);
        View::addNamespace('theme_' . $theme->slug, $themePath);
        
        // Supporte aussi les themes qui utilisent @include('partials.header') sans namespace.
        $finder = View::getFinder();
        if (method_exists($finder, 'prependLocation')) {
            $finder->prependLocation($themePath);
        } else {
            $finder->addLocation($themePath);
        }
        
        $viewData = $this->prepareViewData($theme, $page, $preview, $demoContent);
        
        // 🔥 CORRECTION ICI 🔥
        // Déterminer quelle vue utiliser en fonction de la page
        // if ($page && $page->slug === 'home') {
            // Page d'accueil : utiliser home.blade.php
        //     $view = 'theme::pages.home';
        // } 
        if ($page) {
            // Autres pages : utiliser page.blade.php
            $view = 'theme::pages.page';
        } else {
            // Fallback : utiliser layout directement
            $view = 'theme::layout';
        }
        
        // Vérifier si la vue existe, sinon fallback
        if (!View::exists($view)) {
            \Log::warning('View not found: ' . $view . ', using layout fallback');
            $view = 'theme::layout';
        }
        
        $html = view($view, $viewData)->render();
        
        if (!$preview && config('cms.cache_pages', false)) {
            Cache::put($cacheKey, $html, now()->addMinutes(config('cms.page_cache_lifetime', 60)));
        }
        
        return $this->buildResponse($html, $this->buildSeoContext($page, $preview));
        
    } catch (\Exception $e) {
        Log::error('Theme rendering error: ' . $e->getMessage(), [
            'theme' => $theme->name,
            'path' => $themePath,
            'exception' => $e
        ]);
        
        return $this->renderFallback("Erreur de rendu: " . $e->getMessage());
    }
}

    /**
     * Enregistre le namespace du thème
     */
    protected function registerThemeNamespace($theme, $themePath)
    {
        View::addNamespace('theme', $themePath);
        View::addNamespace('theme_' . $theme->slug, $themePath);
    }

    /**
     * Prépare les données pour la vue - CORRIGÉ
     */
    protected function prepareViewData($theme, $page, $preview = false, $demoContent = null)
    {
        // Récupérer tous les paramètres de l'établissement
        $settings = [];
        $allSettings = Setting::where('etablissement_id', $this->etablissement->id)->get();
        
        foreach ($allSettings as $setting) {
            $settings[$setting->key] = $setting->value;
        }
        
        return [
            'theme' => $theme,
            'page' => $page,
            'content' => $demoContent ?? ($page ? $page->content : ''),
            'etablissement' => $this->etablissement,
            'settings' => $settings,
            'menu' => $this->getMenu(),
            'sliderMedia' => $this->getSliderMedia(),
            'previewMode' => $preview,
            'assetBase' => url("/themes/{$theme->id}/assets"),
            'isPreview' => $preview,
        ];
    }

    /**
     * Récupère les médias slider (images + vidéos) d'un établissement.
     */
    protected function getSliderMedia()
    {
        if (!$this->etablissement) {
            return collect();
        }

        try {
            return get_slider_media($this->etablissement->id);
        } catch (\Throwable $e) {
            Log::warning('Unable to load cms slider media: ' . $e->getMessage(), [
                'etablissement_id' => $this->etablissement->id,
            ]);

            return collect();
        }
    }

    /**
     * Rendu de la vue
     */
    protected function renderView($viewData)
    {
        if (View::exists('theme::layout')) {
            return view('theme::layout', $viewData)->render();
        }
        
        if (isset($viewData['theme']) && View::exists('theme_' . $viewData['theme']->slug . '::layout')) {
            return view('theme_' . $viewData['theme']->slug . '::layout', $viewData)->render();
        }
        
        throw new \Exception('Layout not found');
    }

    /**
     * Rendu fallback
     */
    protected function renderFallback($errorMessage = null)
    {
        $html = $this->getFallbackHtml($errorMessage);
        return $this->buildResponse($html, $this->buildSeoContext(null, false));
    }

    /**
     * Render a commercial landing page when no active theme is available.
     */
    protected function renderNoThemeLanding(?string $message = null)
    {
        $data = $this->prepareNoThemeLandingData($message);
        $activities = $data['activities'] ?? collect();
        $view = $this->shouldUseBoidsFallback($activities)
            ? 'cms::web.fallback.landing-boids'
            : ($this->shouldUseImmoblierFallback($activities)
                ? 'cms::web.fallback.landing-immoblier'
                : ($this->shouldUseImmobilierConstructionFallback($activities)
                    ? 'cms::web.fallback.landing-immobilier-construction'
                    : ($this->shouldUseCommerceAlimentaireFallback($activities)
                        ? 'cms::web.fallback.landing-commerce-alimentaire'
                        : ($this->shouldUseEspaceForfaitFallback($activities)
                            ? 'cms::web.fallback.landing-espace-forfait'
                            : 'cms::web.fallback.landing-activity'))));
        $html = view($view, $data)->render();

        return $this->buildResponse($html, $this->buildSeoContext(null, false));
    }

    /**
     * Build data for the no-theme landing page.
     */
    protected function prepareNoThemeLandingData(?string $message = null): array
    {
        $activities = $this->getEtablissementActivities();

        $plans = Plan::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'name', 'slug', 'description', 'icon', 'price', 'currency']);

        $sliders = $this->getLandingCmsSliders();
        $defaultSliders = Slider::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        $ads = Media::query()
            ->where('etablissement_id', $this->etablissement->id)
            ->where('is_public', true)
            ->images()
            ->ordered()
            ->limit(10)
            ->get()
            ->map(function ($media) {
                return [
                    'id' => $media->id,
                    'name' => $media->title ?: $media->name,
                    'url' => $media->url,
                    'button_url' => $media->button_url ?: route('devis'),
                ];
            })
            ->filter(fn ($item) => !empty($item['url']))
            ->values();

        if ($sliders->isEmpty() && $defaultSliders->isNotEmpty()) {
            $sliders = $defaultSliders->values();
        }

        if ($sliders->isEmpty() && $ads->isNotEmpty()) {
            $sliders = $ads->take(5)->values()->map(function ($ad, $index) {
                $slider = new Slider();
                $slider->name = $ad['name'] ?: 'GoExploria';
                $slider->type = 'image';
                $slider->image_path = $ad['url'];
                $slider->order = $index + 1;
                $slider->button_text = 'Découvrir';
                $slider->button_url = $ad['button_url'];
                return $slider;
            });
        }

        $galleryMedia = $this->getLandingGalleryMedia();

        $activitySections = $this->buildActivitySections($activities);
        $hasRestaurantActivity = $this->hasActivityKeyword($activities, [
            'restaurant', 'restaurants', 'restauration', 'alimentation', 'food', 'cuisine', 'terroir'
        ]);
        $coordinates = $this->resolveEtablissementCoordinates();

        $restaurantSection = [
            'name' => 'Restaurant',
            'headline' => 'Expériences culinaires et terroir en vedette',
            'items' => [
                'Menus vedettes, ambiance et storytelling de marque.',
                'Promotions ciblées et mise en avant de vos spécialités.',
                'Parcours client orienté réservation et demande de devis.',
            ],
            'cta' => route('devis'),
        ];

        $workingHours = [
            ['day' => 'Lundi', 'hours' => '08:30 - 18:00'],
            ['day' => 'Mardi', 'hours' => '08:30 - 18:00'],
            ['day' => 'Mercredi', 'hours' => '08:30 - 18:00'],
            ['day' => 'Jeudi', 'hours' => '08:30 - 20:00'],
            ['day' => 'Vendredi', 'hours' => '08:30 - 20:00'],
            ['day' => 'Samedi', 'hours' => '09:30 - 17:00'],
            ['day' => 'Dimanche', 'hours' => 'Sur rendez-vous'],
        ];

        $commercialBlocks = [
            [
                'title' => 'Activez votre espace destination maintenant',
                'text' => 'Augmentez votre visibilité locale et internationale avec une présence géociblée sur la plateforme Go Exploria.',
                'cta' => route('devis'),
                'icon' => 'fas fa-map-marked-alt',
            ],
            [
                'title' => 'Activez votre espace entreprise',
                'text' => 'Présentez vos offres, services et médias en une seule vitrine professionnelle orientée conversion.',
                'cta' => route('devis'),
                'icon' => 'fas fa-building',
            ],
            [
                'title' => 'Activez votre espace personnel',
                'text' => 'Centralisez votre profil, vos favoris et vos interactions clients dans un espace moderne prêt à performer.',
                'cta' => route('devis'),
                'icon' => 'fas fa-user-circle',
            ],
        ];

        $reviews = [
            [
                'author' => 'Marie D.',
                'role' => 'Direction Marketing',
                'text' => 'La nouvelle visibilité de notre établissement a généré plus de demandes qualifiées en quelques semaines.',
            ],
            [
                'author' => 'Simon L.',
                'role' => 'Gestionnaire Opérations',
                'text' => 'Une présentation moderne, claire et orientée résultats. L’équipe a gagné du temps et de nouveaux clients.',
            ],
            [
                'author' => 'Nadia R.',
                'role' => 'Responsable Commerciale',
                'text' => 'Excellent levier pour combiner image de marque, contenu vidéo et formulaires de contact performants.',
            ],
        ];

        return [
            'etablissement' => $this->etablissement,
            'sliders' => $sliders,
            'galleryMedia' => $galleryMedia,
            'brandLogoUrl' => get_logo_url($this->etablissement->id),
            'plans' => $plans,
            'ads' => $ads,
            'activities' => $activities,
            'activitySections' => $activitySections,
            'hasRestaurantActivity' => $hasRestaurantActivity,
            'restaurantSection' => $restaurantSection,
            'mapLatitude' => $coordinates['lat'],
            'mapLongitude' => $coordinates['lng'],
            'workingHours' => $workingHours,
            'commercialBlocks' => $commercialBlocks,
            'reviews' => $reviews,
            'devisUrl' => route('devis'),
            'message' => $message,
        ];
    }

    /**
     * Get slider data for landing from cms_media with fallback-ready format for Hero component.
     */
    protected function getLandingCmsSliders(): Collection
    {
        try {
            // Priority: CMS sliders stored in settings (group=slider, value JSON)
            // Example payload:
            // {"type":"image","title":"...","subtitle":"...","button_text":"...","button_link":"...","is_active":true,"url":"..."}
            // {"type":"video","title":"...","subtitle":"...","button_text":"...","button_link":"...","is_active":true,"url":"...mp4"}
            $settingsItems = collect(get_slider_items($this->etablissement->id));
            if ($settingsItems->isNotEmpty()) {
                return $settingsItems
                    ->filter(fn ($item) => (bool) ($item->is_active ?? true))
                    ->map(function ($item, $index) {
                        $row = (array) $item;
                        $type = strtolower((string) ($row['type'] ?? 'image')) === 'video' ? 'video' : 'image';
                        $rawUrl = trim((string) ($row['url'] ?? ''));
                        $iframeSrc = $this->extractIframeSrc($rawUrl);
                        $mediaUrl = $iframeSrc ?: $rawUrl;

                        $youtubeId = $this->extractYoutubeId($mediaUrl);
                        $vimeoId = $this->extractVimeoId($mediaUrl);
                        $videoType = null;
                        $videoEmbed = null;

                        if ($type === 'video') {
                            if ($iframeSrc) {
                                $videoType = 'iframe';
                                $videoEmbed = $mediaUrl;
                            } elseif ($youtubeId) {
                                $videoType = 'youtube';
                                $videoEmbed = 'https://www.youtube.com/embed/' . $youtubeId;
                            } elseif ($vimeoId) {
                                $videoType = 'vimeo';
                                $videoEmbed = 'https://player.vimeo.com/video/' . $vimeoId;
                            } else {
                                $videoType = 'upload';
                                $videoEmbed = $mediaUrl !== '' ? $mediaUrl : null;
                            }
                        }

                        $thumbnail = null;
                        if ($type === 'video' && $youtubeId) {
                            $thumbnail = 'https://i.ytimg.com/vi/' . $youtubeId . '/hqdefault.jpg';
                        } elseif ($mediaUrl !== '') {
                            $thumbnail = $mediaUrl;
                        }

                        return (object) [
                            'id' => (int) ($row['id'] ?? 0),
                            'name' => (string) ($row['title'] ?? ('Slide ' . ($index + 1))),
                            'description' => (string) ($row['subtitle'] ?? ''),
                            'type' => $type,
                            'order' => (int) ($row['order'] ?? ($index + 1)),
                            'is_active' => true,
                            'image_url' => $type === 'image' ? ($mediaUrl !== '' ? $mediaUrl : null) : null,
                            'image_path' => $type === 'image' ? ($mediaUrl !== '' ? $mediaUrl : null) : null,
                            'thumbnail_url' => $thumbnail,
                            'thumbnail_path' => $thumbnail,
                            'video_url' => $type === 'video' ? ($mediaUrl !== '' ? $mediaUrl : null) : null,
                            'video_type' => $type === 'video' ? $videoType : null,
                            'video_embed_url' => $type === 'video' ? $videoEmbed : null,
                            'button_text' => $row['button_text'] ?? null,
                            'button_url' => $row['button_link'] ?? null,
                        ];
                    })
                    ->values();
            }

            // Fallback: slider media from cms_media helper
            $items = collect(get_slider_media($this->etablissement->id));
            if ($items->isEmpty()) {
                return collect();
            }

            return $items->map(function ($item, $index) {
                $row = (array) $item;
                $videoRaw = trim((string) ($row['video_url'] ?? ''));
                $imageRaw = trim((string) ($row['image_url'] ?? ''));

                $videoSrc = $this->extractIframeSrc($videoRaw) ?: $videoRaw;
                $youtubeId = $this->extractYoutubeId($videoSrc);
                $vimeoId = $this->extractVimeoId($videoSrc);

                $videoType = 'upload';
                if ($this->extractIframeSrc($videoRaw)) {
                    $videoType = 'iframe';
                } elseif ($youtubeId) {
                    $videoType = 'youtube';
                } elseif ($vimeoId) {
                    $videoType = 'vimeo';
                }

                $videoEmbed = null;
                if ($videoType === 'youtube' && $youtubeId) {
                    $videoEmbed = 'https://www.youtube.com/embed/' . $youtubeId;
                } elseif ($videoType === 'vimeo' && $vimeoId) {
                    $videoEmbed = 'https://player.vimeo.com/video/' . $vimeoId;
                } elseif ($videoType === 'iframe') {
                    $videoEmbed = $videoSrc;
                } elseif ($videoSrc !== '') {
                    $videoEmbed = $videoSrc;
                }

                $type = strtolower((string) ($row['type'] ?? 'image')) === 'image'
                    ? 'image'
                    : 'video';

                if ($videoEmbed && $type !== 'image') {
                    $type = 'video';
                }

                $thumbnail = trim((string) ($row['thumbnail_url'] ?? ''));
                if ($thumbnail === '' && $youtubeId) {
                    $thumbnail = 'https://i.ytimg.com/vi/' . $youtubeId . '/hqdefault.jpg';
                }
                if ($thumbnail === '' && $imageRaw !== '') {
                    $thumbnail = $imageRaw;
                }

                return (object) [
                    'id' => (int) ($row['id'] ?? 0),
                    'name' => (string) ($row['name'] ?? ('Slide ' . ($index + 1))),
                    'description' => $row['description'] ?? null,
                    'type' => $type,
                    'order' => (int) ($row['order'] ?? ($index + 1)),
                    'is_active' => true,
                    'image_url' => $imageRaw !== '' ? $imageRaw : null,
                    'image_path' => $imageRaw !== '' ? $imageRaw : null,
                    'thumbnail_url' => $thumbnail !== '' ? $thumbnail : null,
                    'thumbnail_path' => $thumbnail !== '' ? $thumbnail : null,
                    'video_url' => $videoSrc !== '' ? $videoSrc : null,
                    'video_type' => $type === 'video' ? $videoType : null,
                    'video_embed_url' => $type === 'video' ? $videoEmbed : null,
                    'button_text' => $row['button_text'] ?? null,
                    'button_url' => $row['button_url'] ?? null,
                ];
            })->values();
        } catch (\Throwable $e) {
            Log::warning('Unable to map landing CMS sliders: ' . $e->getMessage(), [
                'etablissement_id' => $this->etablissement->id,
            ]);

            return collect();
        }
    }

    /**
     * Load gallery media from cms_media for current etablissement.
     */
    protected function getLandingGalleryMedia(): Collection
    {
        try {
            return Media::query()
                ->where('etablissement_id', $this->etablissement->id)
                ->where('is_public', true)
                ->whereNull('deleted_at')
                ->ordered()
                ->limit(24)
                ->get()
                ->map(function (Media $media) {
                    $videoUrl = trim((string) ($media->video_url ?? ''));
                    $youtubeId = $this->extractYoutubeId($videoUrl);
                    $thumbnail = null;

                    if ($youtubeId) {
                        $thumbnail = 'https://i.ytimg.com/vi/' . $youtubeId . '/hqdefault.jpg';
                    } elseif ($media->isImage()) {
                        $thumbnail = $media->url;
                    } elseif (!empty($media->path) && preg_match('/\.(jpg|jpeg|png|gif|webp|avif|svg)(\?.*)?$/i', (string) $media->path)) {
                        $thumbnail = $media->url;
                    }

                    return [
                        'id' => $media->id,
                        'name' => $media->title ?: $media->name,
                        'thumbnail' => $thumbnail,
                        'url' => $media->url,
                        'type' => $media->type,
                    ];
                })
                ->filter(fn ($item) => !empty($item['thumbnail']))
                ->values();
        } catch (\Throwable $e) {
            Log::warning('Unable to load landing gallery media: ' . $e->getMessage(), [
                'etablissement_id' => $this->etablissement->id,
            ]);

            return collect();
        }
    }

    protected function extractYoutubeId(?string $url): ?string
    {
        $value = trim((string) $url);
        if ($value === '') {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|live\/|embed\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $value, $m)) {
            return $m[1];
        }

        return null;
    }

    protected function extractVimeoId(?string $url): ?string
    {
        $value = trim((string) $url);
        if ($value === '') {
            return null;
        }

        if (preg_match('/vimeo\.com\/(?:.*\/)?(\d+)/i', $value, $m)) {
            return $m[1];
        }

        if (preg_match('/player\.vimeo\.com\/video\/(\d+)/i', $value, $m)) {
            return $m[1];
        }

        return null;
    }

    protected function extractIframeSrc(?string $value): ?string
    {
        $raw = trim((string) $value);
        if ($raw === '') {
            return null;
        }

        if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/i', $raw, $m)) {
            return trim((string) $m[1]);
        }

        return null;
    }

    /**
     * Detect if the establishment should use the custom "Boids/Bois" fallback landing.
     */
    protected function shouldUseBoidsFallback(Collection $activities): bool
    {
        $haystack = $activities
            ->pluck('name')
            ->filter()
            ->map(fn ($name) => mb_strtolower((string) $name, 'UTF-8'))
            ->implode(' ');

        if ($haystack === '') {
            $haystack = mb_strtolower((string) ($this->etablissement->other_activity_label ?? ''), 'UTF-8');
        }

        $keywords = [
            'boids',
            'bois',
            'wood',
            'scierie',
            'moulin',
            'sciage',
            'lumber',
            'timber',
        ];

        foreach ($keywords as $keyword) {
            if (str_contains($haystack, $keyword)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detect if the establishment should use the apartment/rental immobilier fallback.
     *
     * The misspelled "Immoblier" label is kept intentionally because it is the
     * requested activity name in the CMS.
     */
    protected function shouldUseImmoblierFallback(Collection $activities): bool
    {
        $haystack = $activities
            ->pluck('name')
            ->filter()
            ->map(fn ($name) => mb_strtolower((string) $name, 'UTF-8'))
            ->implode(' ');

        $otherActivity = mb_strtolower((string) ($this->etablissement->other_activity_label ?? ''), 'UTF-8');
        $haystack = trim($haystack . ' ' . $otherActivity);

        if ($haystack === '') {
            return false;
        }

        $keywords = [
            'immoblier',
            'appartement',
            'appartements',
            'logement',
            'logements',
            'location appartement',
            'location residentielle',
            'immeuble locatif',
            'immeubles locatifs',
            'residence',
            'condo',
            'condos',
            'place des cerisiers',
        ];

        foreach ($keywords as $keyword) {
            if (str_contains($haystack, $keyword)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detect if the establishment should use the "immobilier & construction" fallback landing.
     */
    protected function shouldUseImmobilierConstructionFallback(Collection $activities): bool
    {
        $haystack = $activities
            ->pluck('name')
            ->filter()
            ->map(fn ($name) => mb_strtolower((string) $name, 'UTF-8'))
            ->implode(' ');

        if ($haystack === '') {
            $haystack = mb_strtolower((string) ($this->etablissement->other_activity_label ?? ''), 'UTF-8');
        }

        $keywords = [
            'immobilier',
            'immo',
            'construction',
            'constructeur',
            'habitation',
            'maison',
            'chalet',
            'résidentiel',
            'residentiel',
        ];

        foreach ($keywords as $keyword) {
            if (str_contains($haystack, $keyword)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detect if the establishment should use the "commerce alimentaire" fallback landing.
     */
    protected function shouldUseCommerceAlimentaireFallback(Collection $activities): bool
    {
        $haystack = $activities
            ->pluck('name')
            ->filter()
            ->map(fn ($name) => mb_strtolower((string) $name, 'UTF-8'))
            ->implode(' ');

        if ($haystack === '') {
            $haystack = mb_strtolower((string) ($this->etablissement->other_activity_label ?? ''), 'UTF-8');
        }

        $keywords = [
            'commerce alimentaire',
            'alimentaire',
            'alimentation',
            'epicerie',
            'épicerie',
            'marche',
            'marché',
            'supermarche',
            'supermarché',
            'poissonnerie',
            'boucherie',
            'fromagerie',
            'boulangerie',
            'patisserie',
            'pâtisserie',
            'terroir',
            'traiteur',
            'gourmet',
            'fine food',
        ];

        foreach ($keywords as $keyword) {
            if (str_contains($haystack, $keyword)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detect if the establishment should use the "Espace Forfait" fallback landing.
     */
    protected function shouldUseEspaceForfaitFallback(Collection $activities): bool
    {
        $haystack = $activities
            ->pluck('name')
            ->filter()
            ->map(fn ($name) => mb_strtolower((string) $name, 'UTF-8'))
            ->implode(' ');

        if ($haystack === '') {
            $haystack = mb_strtolower((string) ($this->etablissement->other_activity_label ?? ''), 'UTF-8');
        }

        $keywords = [
            'espace forfait',
            'forfait',
            'forfaits',
            'package',
            'packages',
            'circuit',
            'expedition',
            'expédition',
            'location',
            'motoneige',
            'quad',
            'vtt',
            'côte-à-côte',
            'cote-a-cote',
            'cote à cote',
            'ssv',
            'aventure',
        ];

        foreach ($keywords as $keyword) {
            if (str_contains($haystack, $keyword)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Resolve active activities for the current etablissement.
     */
    protected function getEtablissementActivities(): Collection
    {
        $activities = collect();

        try {
            $activities = $this->etablissement->activities()
                ->where('activities.is_active', true)
                ->get(['activities.id', 'activities.name', 'activities.slug', 'activities.description']);
        } catch (\Throwable $e) {
            Log::warning('Unable to load etablissement activities: ' . $e->getMessage(), [
                'etablissement_id' => $this->etablissement->id,
            ]);
        }

        $primaryActivity = $this->etablissement->primaryActivity()
            ->where('is_active', true)
            ->first(['id', 'name', 'slug', 'description']);

        if ($primaryActivity && !$activities->contains('id', $primaryActivity->id)) {
            $activities->prepend($primaryActivity);
        }

        if ($activities->isEmpty() && !empty($this->etablissement->other_activity_label)) {
            $fallback = new Activity();
            $fallback->name = (string) $this->etablissement->other_activity_label;
            $fallback->description = 'Activité principale de cet établissement.';
            $activities = collect([$fallback]);
        }

        return $activities->values();
    }

    /**
     * Build dynamic sections according to activities.
     */
    protected function buildActivitySections(Collection $activities): array
    {
        $sections = [];

        foreach ($activities as $activity) {
            $name = (string) ($activity->name ?? 'Activité');
            $lower = mb_strtolower($name, 'UTF-8');

            $section = [
                'name' => $name,
                'headline' => 'Développez votre présence sur ce marché',
                'icon' => 'fas fa-bullseye',
                'items' => [
                    'Optimisation de votre visibilité locale et internationale.',
                    'Diffusion multi-canaux de vos contenus et offres.',
                    'Acquisition de contacts qualifiés via vos espaces dédiés.',
                ],
                'cta' => route('devis'),
            ];

            if (str_contains($lower, 'restaurant') || str_contains($lower, 'alimentation') || str_contains($lower, 'café') || str_contains($lower, 'bar')) {
                $section['headline'] = 'Expériences culinaires et terroir en vedette';
                $section['icon'] = 'fas fa-utensils';
                $section['items'] = [
                    'Menus vedettes, ambiance et storytelling de marque.',
                    'Promotions ciblées et mise en avant de vos spécialités.',
                    'Parcours client orienté réservation et demande de devis.',
                ];
            } elseif (str_contains($lower, 'hotel') || str_contains($lower, 'hôtel') || str_contains($lower, 'auberge') || str_contains($lower, 'hébergement') || str_contains($lower, 'hebergement')) {
                $section['headline'] = 'Hébergement premium et conversion directe';
                $section['icon'] = 'fas fa-bed';
                $section['items'] = [
                    'Présentation immersive de vos chambres et services.',
                    'Mise en confiance avec avis clients et preuves sociales.',
                    'Tunnel de conversion vers demande d’information rapide.',
                ];
            } elseif (str_contains($lower, 'voyage') || str_contains($lower, 'tourisme') || str_contains($lower, 'destination') || str_contains($lower, 'forfait')) {
                $section['headline'] = 'Destination et forfaits à fort impact commercial';
                $section['icon'] = 'fas fa-plane-departure';
                $section['items'] = [
                    'Séquences visuelles et offres saisonnières engageantes.',
                    'Parcours multilingue pour marchés nationaux et internationaux.',
                    'Liens directs vers devis et activations marketing.',
                ];
            } elseif (str_contains($lower, 'location') || str_contains($lower, 'auto') || str_contains($lower, 'transport') || str_contains($lower, 'véhicule') || str_contains($lower, 'vehicule')) {
                $section['headline'] = 'Mobilité 4 saisons et offres de location';
                $section['icon'] = 'fas fa-car-side';
                $section['items'] = [
                    'Catalogue clair de vos solutions auto, bus et VR.',
                    'Arguments commerciaux prêts à convertir rapidement.',
                    'Intégration de campagnes ponctuelles et promotions.',
                ];
            } elseif (str_contains($lower, 'immobilier') || str_contains($lower, 'chalet') || str_contains($lower, 'maison')) {
                $section['headline'] = 'Immobilier et résidences touristiques';
                $section['icon'] = 'fas fa-home';
                $section['items'] = [
                    'Mise en scène premium de vos biens et projets.',
                    'Fiches détaillées avec médias engageants.',
                    'Contact qualifié orienté vente et investissement.',
                ];
            }

            $sections[] = $section;
        }

        if (empty($sections)) {
            $sections[] = [
                'name' => 'Activités de votre établissement',
                'headline' => 'Construisez une présence digitale moderne et rentable',
                'icon' => 'fas fa-rocket',
                'items' => [
                    'Page professionnelle prête à convertir vos visiteurs.',
                    'Sections commerciales personnalisées selon votre marché.',
                    'Accès direct aux plans pour accélérer votre croissance.',
                ],
                'cta' => route('devis'),
            ];
        }

        return $sections;
    }

    /**
     * Check if activity list contains one of the given keywords.
     */
    protected function hasActivityKeyword(Collection $activities, array $keywords): bool
    {
        foreach ($activities as $activity) {
            $haystack = mb_strtolower((string) ($activity->name ?? ''), 'UTF-8');
            foreach ($keywords as $keyword) {
                if (str_contains($haystack, mb_strtolower($keyword, 'UTF-8'))) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Resolve best coordinates from etablissement geo hierarchy.
     */
    protected function resolveEtablissementCoordinates(): array
    {
        $fallback = ['lat' => 46.8139, 'lng' => -71.2082];

        try {
            $this->etablissement->loadMissing(['villeRelation', 'region', 'province', 'country', 'continent']);
            $sources = [
                $this->etablissement->villeRelation,
                $this->etablissement->region,
                $this->etablissement->province,
                $this->etablissement->country,
                $this->etablissement->continent,
            ];

            foreach ($sources as $source) {
                if (!$source) {
                    continue;
                }

                $lat = isset($source->latitude) ? (float) $source->latitude : null;
                $lng = isset($source->longitude) ? (float) $source->longitude : null;

                if ($lat !== null && $lng !== null && $lat !== 0.0 && $lng !== 0.0) {
                    return ['lat' => $lat, 'lng' => $lng];
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Unable to resolve establishment coordinates: ' . $e->getMessage(), [
                'etablissement_id' => $this->etablissement->id,
            ]);
        }

        return $fallback;
    }

    /**
     * HTML fallback
     */
    protected function getFallbackHtml($errorMessage = null)
    {
        return '<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . e($this->etablissement->name) . '</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f5f5f5; color: #333; line-height: 1.6; }
                .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 60px 0; text-align: center; margin-bottom: 40px; }
                .header h1 { font-size: 2.5rem; margin-bottom: 10px; }
                .content { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; }
                .alert { background: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 8px; margin-bottom: 20px; color: #856404; }
                .footer { text-align: center; padding: 20px; color: #666; border-top: 1px solid #eee; margin-top: 40px; }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="container">
                    <h1>' . e($this->etablissement->name) . '</h1>
                </div>
            </div>
            <div class="container">
                <div class="content">
                    ' . ($errorMessage ? '<div class="alert">⚠️ ' . e($errorMessage) . '</div>' : '') . '
                    <h2>Site en construction</h2>
                    <p>Notre site est actuellement en cours de configuration.</p>
                </div>
            </div>
            <div class="footer">
                <p>&copy; ' . date('Y') . ' ' . e($this->etablissement->name) . '</p>
            </div>
        </body>
        </html>';
    }

    /**
     * Construit la réponse HTTP
     */
    protected function buildResponse($html, array $seoContext = [])
    {
        $html = $this->injectSeoMeta($html, $seoContext);

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=utf-8',
        ]);
    }

    protected function buildSeoContext($page = null, bool $isPreview = false): array
    {
        $siteName = trim((string) get_site_name($this->etablissement->id));
        if ($siteName === '') {
            $siteName = trim((string) ($this->etablissement->name ?? 'GoExploria'));
        }

        $meta = (array) (($page && is_array($page->meta ?? null)) ? $page->meta : []);
        $title = trim((string) ($meta['seo_title'] ?? ($page->title ?? $siteName)));
        if ($title === '') {
            $title = $siteName;
        }

        $description = trim((string) ($meta['seo_description'] ?? ''));
        if ($description === '') {
            $description = trim((string) ($this->etablissement->getSetting('site_description', null, 'general') ?? ''));
        }
        if ($description === '') {
            $description = trim((string) get_site_description($this->etablissement->id));
        }
        if ($description === '') {
            $description = $siteName . ' - GoExploria';
        }

        $keywords = trim((string) ($meta['seo_keywords'] ?? ''));
        if ($keywords === '') {
            $keywords = trim((string) ($this->etablissement->getSetting('seo_keywords', null, 'seo') ?? ''));
        }

        $canonical = trim((string) ($meta['canonical_url'] ?? ''));
        if ($canonical === '') {
            $canonical = url()->current();
        }

        $image = trim((string) get_logo_url($this->etablissement->id));
        if ($image === '') {
            $slider = $this->getLandingCmsSliders()->first();
            $image = trim((string) (
                data_get($slider, 'image_url')
                ?: data_get($slider, 'thumbnail_url')
                ?: data_get($slider, 'image_path')
                ?: data_get($slider, 'thumbnail_path')
                ?: ''
            ));
        }

        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'canonical' => $canonical,
            'image' => $image,
            'site_name' => $siteName,
            'robots' => $isPreview ? 'noindex, nofollow' : 'index, follow',
        ];
    }

    protected function injectSeoMeta(string $html, array $seoContext = []): string
    {
        if (stripos($html, '<head') === false) {
            return $html;
        }

        $title = e((string) ($seoContext['title'] ?? 'GoExploria'));
        $description = e((string) ($seoContext['description'] ?? ''));
        $keywords = e((string) ($seoContext['keywords'] ?? ''));
        $canonical = e((string) ($seoContext['canonical'] ?? url()->current()));
        $image = e((string) ($seoContext['image'] ?? ''));
        $siteName = e((string) ($seoContext['site_name'] ?? 'GoExploria'));
        $robots = e((string) ($seoContext['robots'] ?? 'index, follow'));

        $html = preg_replace('/\s*<!--\s*CMS SEO START\s*-->.*?<!--\s*CMS SEO END\s*-->\s*/is', "\n", $html);
        $html = preg_replace('/<link[^>]*rel=["\']canonical["\'][^>]*>/i', '', $html);

        $seoBlock = [];
        $seoBlock[] = '<!-- CMS SEO START -->';
        $seoBlock[] = '<title>' . $title . '</title>';
        $seoBlock[] = '<link rel="canonical" href="' . $canonical . '">';
        $seoBlock[] = '<meta name="description" content="' . $description . '">';
        if ($keywords !== '') {
            $seoBlock[] = '<meta name="keywords" content="' . $keywords . '">';
        }
        $seoBlock[] = '<meta name="robots" content="' . $robots . '">';
        $seoBlock[] = '<meta property="og:type" content="website">';
        $seoBlock[] = '<meta property="og:site_name" content="' . $siteName . '">';
        $seoBlock[] = '<meta property="og:title" content="' . $title . '">';
        $seoBlock[] = '<meta property="og:description" content="' . $description . '">';
        $seoBlock[] = '<meta property="og:url" content="' . $canonical . '">';
        if ($image !== '') {
            $seoBlock[] = '<meta property="og:image" content="' . $image . '">';
        }
        $seoBlock[] = '<meta name="twitter:card" content="' . ($image !== '' ? 'summary_large_image' : 'summary') . '">';
        $seoBlock[] = '<meta name="twitter:title" content="' . $title . '">';
        $seoBlock[] = '<meta name="twitter:description" content="' . $description . '">';
        if ($image !== '') {
            $seoBlock[] = '<meta name="twitter:image" content="' . $image . '">';
        }
        $seoBlock[] = '<!-- CMS SEO END -->';

        $seoHtml = implode("\n", $seoBlock) . "\n";

        if (preg_match('/<\/head>/i', $html)) {
            return preg_replace('/<\/head>/i', $seoHtml . '</head>', $html, 1);
        }

        return $html;
    }

    /**
     * Récupère le thème à utiliser - CORRIGÉ
     */
    protected function getThemeToUse()
    {
        if ($this->previewMode && session()->has('theme_preview')) {
            $previewTheme = Theme::find(session('theme_preview'));
            if ($previewTheme) {
                return $previewTheme;
            }
        }
        
        // Récupérer le thème actif via la relation de l'établissement
        $activeTheme = $this->etablissement->themes()
            ->wherePivot('is_active', true)
            ->where('cms_themes.is_active', true)
            ->first();
        
        return $activeTheme;
    }

    /**
     * Récupère la page d'accueil - CORRIGÉ
     */
    protected function getHomePage()
    {
        $homePage = Page::where('etablissement_id', $this->etablissement->id)
            ->where('is_home', true)
            ->where('status', 'published')
            ->first();
        
        if (!$homePage) {
            $homePage = Page::where('etablissement_id', $this->etablissement->id)
                ->where('slug', 'home')
                ->where('status', 'published')
                ->first();
        }
        
        return $homePage;
    }

    /**
     * Crée une page d'accueil par défaut
     */
    protected function createDefaultHomePage()
    {
        $content = '<section class="hero"><div class="container"><h1>Bienvenue</h1><p>Bienvenue sur notre site.</p></div></section>';
        
        return Page::create([
            'etablissement_id' => $this->etablissement->id,
            'title' => 'Accueil',
            'slug' => 'home',
            'content' => $content,
            'status' => 'published',
            'visibility' => 'public',
            'is_home' => true,
            'published_at' => now(),
        ]);
    }

    /**
 * Récupère le chemin du thème
 */
protected function getThemePath($theme)
{
    $etablissementId = $this->etablissement->id;
    $slug = $theme->slug;

    $paths = [
        storage_path("app/public/cms/themes/{$etablissementId}/{$slug}"),
        storage_path("app/public/cms/themes/{$slug}"),
    ];

    foreach ($paths as $candidate) {
        if (File::exists($candidate)) {
            return rtrim($candidate, '/');
        }
    }

    // Fallback to etablissement-scoped path when theme directory is not created yet.
    return rtrim($paths[0], '/');
}

    /**
     * Récupère les captures d'écran du thème
     */
    protected function getThemeScreenshots($theme)
    {
        $screenshots = [];
        $screenshotDir = $this->getThemePath($theme) . '/assets/screenshots';
        
        if (File::exists($screenshotDir)) {
            $files = File::files($screenshotDir);
            foreach ($files as $file) {
                $screenshots[] = url("/themes/{$theme->id}/assets/screenshots/" . $file->getFilename());
            }
        }
        
        if (empty($screenshots) && $theme->preview_image) {
            $screenshots[] = $theme->getPreviewImageUrl();
        }
        
        return $screenshots;
    }

    /**
     * Récupère la configuration du thème
     */
    protected function getThemeConfig($theme)
    {
        $configFile = $this->getThemePath($theme) . '/theme.json';
        
        if (File::exists($configFile)) {
            return json_decode(File::get($configFile), true);
        }
        
        return [];
    }

    /**
     * Récupère le contenu de démonstration
     */
    protected function getDemoContent($theme)
    {
        $demoFile = $this->getThemePath($theme) . '/demo-content.html';
        
        if (File::exists($demoFile)) {
            return File::get($demoFile);
        }
        
        return '<h1>Contenu de démonstration</h1>
                <p>Ceci est un aperçu du thème avec du contenu de démonstration.</p>
                <p>Le thème n\'est pas encore activé sur votre site.</p>';
    }

    /**
     * Ajoute un dossier à une archive ZIP
     */
    protected function addDirectoryToZip($zip, $dir, $relativePath)
    {
        $files = File::files($dir);
        
        foreach ($files as $file) {
            $zip->addFile($file->getPathname(), $relativePath . $file->getFilename());
        }
        
        $directories = File::directories($dir);
        
        foreach ($directories as $subdir) {
            $subdirName = basename($subdir) . '/';
            $this->addDirectoryToZip($zip, $subdir, $relativePath . $subdirName);
        }
    }

    /**
     * Vérifie le mode prévisualisation
     */
    protected function checkPreviewMode(Request $request)
    {
        if ($request->has('preview_theme')) {
            $this->previewMode = true;
            session(['theme_preview' => $request->preview_theme]);
        }
        
        if (session()->has('theme_preview')) {
            $this->previewMode = true;
        }
    }

    /**
     * Récupère la clé de cache
     */
    protected function getCacheKey($theme, $page)
    {
        $key = "theme_{$this->etablissement->id}_{$theme->id}";
        
        if ($page) {
            $key .= "_page_{$page->id}";
        }
        
        if ($this->previewMode) {
            $key .= '_preview';
        }
        
        return $key;
    }

    /**
     * Récupère tous les paramètres
     */
    protected function getAllSettings()
    {
        return Setting::where('etablissement_id', $this->etablissement->id)
            ->get()
            ->groupBy('group')
            ->map(function ($settings) {
                return $settings->pluck('value', 'key');
            });
    }

    /**
     * Récupère le menu à partir des pages publiées - CORRIGÉ
     */
    protected function getMenu()
    {
        // Vérifier si un menu personnalisé existe dans les settings
        $customMenu = Setting::where('etablissement_id', $this->etablissement->id)
            ->where('group', 'menu')
            ->where('key', 'main_menu')
            ->first();
        
        if ($customMenu && $customMenu->value) {
            return $customMenu->value;
        }
        
        // Récupérer TOUTES les pages publiées
        $pages = Page::where('etablissement_id', $this->etablissement->id)
            ->where('status', 'published')
            ->where('visibility', 'public')
            ->orderBy('created_at', 'asc')
            ->get();
        
        // S'IL Y A DES PAGES, les utiliser comme menu
        if ($pages->isNotEmpty()) {
            $menu = [];
            foreach ($pages as $page) {
                $menu[] = [
                    'id' => $page->id,
                    'label' => $page->title,
                    'url' => '/company/' . $this->etablissement->id . '/page/' . $page->slug,
                    'slug' => $page->slug,
                    'active' => request()->route('slug') == $page->slug,
                    'is_home' => $page->is_home,
                    'target' => '_self',
                    'icon' => $page->getMeta('menu_icon'),
                    'children' => [],
                ];
            }
            return $menu;
        }
        
        // SI AUCUNE PAGE, retourner le menu par défaut
        return [
            [
                'label' => 'Accueil',
                'url' => '/company/' . $this->etablissement->id,
                'slug' => 'home',
                'active' => request()->route()->getName() == 'cms.company.home',
                'is_home' => true,
                'target' => '_self',
                'icon' => null,
                'children' => [],
            ],
            [
                'label' => 'À propos',
                'url' => '/company/' . $this->etablissement->id . '/page/about',
                'slug' => 'about',
                'active' => request()->route('slug') == 'about',
                'is_home' => false,
                'target' => '_self',
                'icon' => null,
                'children' => [],
            ],
            [
                'label' => 'Services',
                'url' => '/company/' . $this->etablissement->id . '/page/services',
                'slug' => 'services',
                'active' => request()->route('slug') == 'services',
                'is_home' => false,
                'target' => '_self',
                'icon' => null,
                'children' => [],
            ],
            [
                'label' => 'Contact',
                'url' => '/company/' . $this->etablissement->id . '/page/contact',
                'slug' => 'contact',
                'active' => request()->route('slug') == 'contact',
                'is_home' => false,
                'target' => '_self',
                'icon' => null,
                'children' => [],
            ],
        ];
    }
}


