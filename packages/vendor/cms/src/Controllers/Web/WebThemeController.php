<?php

namespace Vendor\Cms\Controllers\Web;

use App\Http\Controllers\Controller;
use Vendor\Cms\Models\Theme;
use Vendor\Cms\Models\Page;
use Vendor\Cms\Models\Setting;
use Vendor\Cms\Models\Media;
use Vendor\Cms\Models\BlogPost;
use Vendor\Cms\Models\CmsSlideshow;
use Vendor\Cms\Models\EtablissementTemplate;
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
use Illuminate\Support\Str;

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
        // TOUS les sites d'établissement s'affichent DANS le shell GoExploria
        // Business (header + footer globaux). Le site réel est rendu isolé dans
        // une iframe same-origin (route cms.company.embed → renderSite()).
        return $this->platformSite($request, $etablissementId);
    }

    /**
     * Rendu BRUT du site de l'établissement (thème actif ou landing de repli).
     * = ancien corps de home(). Sert de CONTENU d'iframe via embed(), et n'est
     * jamais servi seul avec le chrome plateforme (fourni par le shell parent).
     */
    protected function renderSite(Request $request, $etablissementId)
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
     * SHELL PLATEFORME — affiche le site de l'établissement DANS GoExploria
     * Business : Header GoExploria + iframe (site isolé) + Footer GoExploria.
     *
     * Le site de l'établissement est chargé dans une iframe same-origin
     * (route `cms.company.embed`) : isolation totale du CSS/JS/CDN du template
     * vis-à-vis de la plateforme. Hauteur pilotée par postMessage (voir la vue
     * cms::web.embed.platform-shell + le partial child-bridge).
     */
    public function platformSite(Request $request, $etablissementId)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);

        return view('cms::web.embed.platform-shell', compact('etablissement'));
    }

    /**
     * CONTENU DE L'IFRAME — rend le site de l'établissement en mode
     * « embarqué » : identique à la page d'accueil publique, mais
     *   1) sans le chrome plateforme (Header/menu GoExploria), fourni par le
     *      shell parent — piloté par la variable partagée `embedInPlatform` ;
     *   2) avec le pont de hauteur (child-bridge) injecté avant </body>.
     */
    public function embed(Request $request, $etablissementId)
    {
        // Signale à toutes les vues incluses de masquer le chrome plateforme.
        View::share('embedInPlatform', true);

        // Rendu BRUT du site (thème actif ou landing de repli). On appelle
        // renderSite() et NON home() : home() rend désormais le shell, ce qui
        // provoquerait une récursion shell → iframe → shell.
        $response = $this->renderSite($request, $etablissementId);

        // Injecte le pont de hauteur côté enfant juste avant </body>.
        try {
            $content = method_exists($response, 'getContent') ? $response->getContent() : null;

            // buildResponse() pose désormais le pont sur TOUTE page
            // d'établissement. Ce filet ne sert plus que pour un chemin de
            // rendu qui ne passerait pas par lui ; il ne doit surtout pas en
            // poser un second, deux ponts se disputant la hauteur annoncée.
            if (is_string($content) && $content !== ''
                && strpos($content, "CHANNEL = 'gx-embed'") === false) {
                $pos = strripos($content, '</body>');
                if ($pos !== false) {
                    $bridge = view('cms::web.embed.partials.child-bridge')->render();
                    $content = substr($content, 0, $pos) . $bridge . substr($content, $pos);
                    $response->setContent($content);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Embed height-bridge injection failed: ' . $e->getMessage());
        }

        return $response;
    }

    /**
     * Affiche une page avec le thème
     */
    public function showPage(Request $request, $etablissementId, $slug)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;

        $page = Page::where('etablissement_id', $this->etablissement->id)
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$page) {
            abort(404, 'Page non trouvée');
        }

        $theme = $this->getThemeToUse();

        // Établissement sur thème classique (cms_themes) : rendu via le thème disque.
        if ($theme) {
            return $this->renderTheme($theme, $page);
        }

        // Établissement sur templates CMS (pas de cms_theme, ex. éditeur GrapesJS/VvvebJS) :
        // afficher le contenu enregistré de la page, enveloppé du header/footer du template.
        return $this->renderCmsPageFallback($page);
    }

    /**
     * Rendu de repli d'une page CMS pour les établissements qui utilisent les
     * templates (aucun cms_theme actif) : affiche le contenu éditeur ($page->content)
     * entouré des régions header/footer configurées (cms_header_footers).
     */
    protected function renderCmsPageFallback(Page $page)
    {
        $content = (string) ($page->content ?? '');
        if (method_exists($this, 'injectDynamicContent')) {
            $content = $this->injectDynamicContent($content);
        }

        // Même traitement que sur la page d'accueil : une page intérieure peut
        // elle aussi porter une grille produits ou rayons.
        $etablissementId = $this->etablissement->id ?? null;
        $content = \Vendor\Cms\Support\TemplateProducts::hydrate($content, $etablissementId);
        $content = \Vendor\Cms\Support\TemplateCategories::hydrate($content, $etablissementId);
        $content = \Vendor\Cms\Support\TemplateActivities::hydrate($content, $etablissementId);

        $html = view('cms::web.fallback.cms-page', [
            'etablissement' => $this->etablissement,
            'page' => $page,
            'content' => $content,
            'brandLogoUrl' => function_exists('get_logo_url') ? get_logo_url($this->etablissement->id) : null,
        ])->render();

        // Passe par buildResponse() — et non plus par un view() direct — pour
        // que ces pages reçoivent, comme la page d'accueil, le tiroir panier et
        // les balises SEO. Sans cela, un « Ajouter au panier » posé sur une page
        // intérieure n'avait aucun panier pour l'accueillir.
        return $this->buildResponse($html, $this->buildSeoContext($page));
    }

    /**
     * Affiche le detail public d'un article de blog d'etablissement.
     */
    public function showBlogPost(Request $request, $etablissementId, $slug)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;

        if (function_exists('is_blog_enabled') && !is_blog_enabled($etablissement->id)) {
            abort(404, 'Blog non disponible');
        }

        $post = BlogPost::query()
            ->where('etablissement_id', $etablissement->id)
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $relatedPosts = BlogPost::query()
            ->where('etablissement_id', $etablissement->id)
            ->where('id', '!=', $post->id)
            ->published()
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get()
            ->map(function (BlogPost $related) {
                $image = $this->resolveLandingAssetUrl($related->featured_image ?: $related->og_image_url);

                return [
                    'title' => $related->display_title,
                    'excerpt' => trim((string) ($related->excerpt ?: Str::limit(strip_tags((string) $related->content), 120))),
                    'image' => $image,
                    'date' => optional($related->published_at ?: $related->created_at)->translatedFormat('j M Y'),
                    'url' => $this->resolveLandingBlogUrl($related),
                ];
            })
            ->values();

        return view('cms::web.fallback.blog-detail', [
            'etablissement' => $etablissement,
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'featuredImageUrl' => $this->resolveLandingAssetUrl($post->featured_image ?: $post->og_image_url),
            'brandLogoUrl' => function_exists('get_logo_url') ? get_logo_url($etablissement->id) : null,
            'backUrl' => route('cms.company.home', ['etablissementId' => $etablissement->id]) . '#blog',
        ]);
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
        $view = $this->resolveTemplateLandingView($data['selectedEtablissementTemplate'] ?? null);
        $html = view($view, $data)->render();

        return $this->buildResponse($html, $this->buildSeoContext(null, false));
    }

    public function videoChannel(Request $request, $etablissementId)
    {
        return redirect()->route('cms.videos.channel');
    }

    public function globalVideoChannel(Request $request)
    {
        $videos = $this->getGlobalVideoChannelItems();
        $html = view('cms::web.fallback.landing-chaine-videos', [
            'siteName' => 'GoExploria Chaine videos',
            'siteDescription' => 'Toutes les videos publiees par les etablissements GoExploria, regroupees depuis les sliders, les sliders CMS et les medias videos.',
            'videoChannelVideos' => $videos,
            'videoSearchUrl' => route('cms.videos.search'),
        ])->render();

        return $this->buildResponse($html, [
            'title' => 'GoExploria Chaine videos',
            'description' => 'Toutes les videos publiees par les etablissements GoExploria.',
            'canonical' => route('cms.videos.channel'),
            'site_name' => 'GoExploria',
            'robots' => 'index, follow',
        ]);
    }

    public function globalVideoSearch(Request $request)
    {
        $query = trim((string) $request->query('q', ''));
        $channel = trim((string) $request->query('channel', 'all'));
        $limit = max(1, min((int) $request->query('limit', 36), 90));

        $allVideos = $this->getGlobalVideoChannelItems();
        $videos = $allVideos;

        if ($channel !== '' && $channel !== 'all') {
            $videos = $videos->filter(fn ($video) => strcasecmp((string) ($video['channel'] ?? ''), $channel) === 0);
        }

        if ($query !== '') {
            $needle = Str::lower(Str::ascii($query));
            $videos = $videos->filter(function ($video) use ($needle) {
                $haystack = Str::lower(Str::ascii(implode(' ', [
                    $video['title'] ?? '',
                    $video['description'] ?? '',
                    $video['channel'] ?? '',
                    $video['source_label'] ?? '',
                    $video['origin_label'] ?? '',
                    $video['establishment_name'] ?? '',
                ])));

                return str_contains($haystack, $needle);
            });
        }

        $videos = $videos->values();

        return response()->json([
            'videos' => $videos->take($limit)->values(),
            'total' => $videos->count(),
            'suggestions' => $this->buildGlobalVideoSuggestions($allVideos, $query),
            'video_suggestions' => $this->buildGlobalVideoItemSuggestions($videos, $query),
            'channels' => $allVideos
                ->groupBy('channel')
                ->map(fn ($items, $name) => ['name' => $name, 'count' => $items->count()])
                ->values(),
        ]);
    }

    /**
     * Build data for the no-theme landing page.
     */
    protected function prepareNoThemeLandingData(?string $message = null): array
    {
        $activities = $this->getEtablissementActivities();
        $activeEtablissementTemplates = $this->getActiveEtablissementTemplates();
        $selectedEtablissementTemplate = $this->selectLandingEtablissementTemplate($activeEtablissementTemplates);
        $selectedCmsTemplate = $selectedEtablissementTemplate?->template;

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

        $landingMedia = $this->getLandingMediaGroups();
        $galleryMedia = $landingMedia['main']->isNotEmpty() ? $landingMedia['main'] : $landingMedia['all'];
        $slideshowMediaGroups = $this->getLandingCmsSlideshowGroups();
        if ($slideshowMediaGroups->isEmpty()) {
            $slideshowMediaGroups = $this->buildLandingSlideshowGroups($landingMedia['all']);
        }
        $blogPosts = $this->getLandingBlogPosts();
        $cmsPageSections = $this->getActiveTemplatePageSections($activeEtablissementTemplates);
        $videoChannelVideos = $this->getLandingVideoChannelItems();

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

        $workingHoursFallback = [
            ['day' => 'Lundi', 'hours' => '08:30 - 18:00'],
            ['day' => 'Mardi', 'hours' => '08:30 - 18:00'],
            ['day' => 'Mercredi', 'hours' => '08:30 - 18:00'],
            ['day' => 'Jeudi', 'hours' => '08:30 - 20:00'],
            ['day' => 'Vendredi', 'hours' => '08:30 - 20:00'],
            ['day' => 'Samedi', 'hours' => '09:30 - 17:00'],
            ['day' => 'Dimanche', 'hours' => 'Sur rendez-vous'],
        ];
        $workingHours = get_establishment_opening_hours($this->etablissement, $workingHoursFallback);

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
            'allGalleryMedia' => $landingMedia['all'],
            'mainGalleryMedia' => $landingMedia['main'],
            'facebookGalleryMedia' => $landingMedia['facebook'],
            'instagramGalleryMedia' => $landingMedia['instagram'],
            'pinterestGalleryMedia' => $landingMedia['pinterest'],
            'slideshowMediaGroups' => $slideshowMediaGroups,
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
            'socialLinks' => get_establishment_social_links($this->etablissement),
            'blogPosts' => $blogPosts,
            'cmsPageSections' => $cmsPageSections,
            'videoChannelVideos' => $videoChannelVideos,
            'activeEtablissementTemplates' => $activeEtablissementTemplates,
            'selectedEtablissementTemplate' => $selectedEtablissementTemplate,
            'selectedCmsTemplate' => $selectedCmsTemplate,
            'selectedTemplateCategory' => $selectedCmsTemplate?->category,
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
        $groups = $this->getLandingMediaGroups();

        return $groups['main']->isNotEmpty() ? $groups['main'] : $groups['all'];
    }

    /**
     * Load published blog posts for fallback landing pages.
     */
    protected function getLandingBlogPosts(): Collection
    {
        try {
            if (function_exists('is_blog_enabled') && !is_blog_enabled($this->etablissement->id)) {
                return collect();
            }

            return BlogPost::query()
                ->where('etablissement_id', $this->etablissement->id)
                ->published()
                ->orderByDesc('is_featured')
                ->orderByDesc('published_at')
                ->orderByDesc('created_at')
                ->limit(6)
                ->get()
                ->map(function (BlogPost $post) {
                    $tags = collect($post->tags ?? [])
                        ->filter(fn ($tag) => is_string($tag) && trim($tag) !== '')
                        ->values();
                    $image = $post->featured_image ?: $post->og_image_url;
                    $excerpt = trim((string) ($post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags((string) $post->content), 150)));

                    return [
                        'id' => $post->id,
                        'title' => $post->display_title,
                        'excerpt' => $excerpt,
                        'image' => $this->resolveLandingAssetUrl($image),
                        'tag' => $tags->first() ?: 'Blog',
                        'tags' => $tags,
                        'date' => optional($post->published_at ?: $post->created_at)->translatedFormat('j M Y'),
                        'reading_time' => $post->reading_time,
                        'url' => $this->resolveLandingBlogUrl($post),
                        'is_featured' => (bool) $post->is_featured,
                    ];
                })
                ->values();
        } catch (\Throwable $e) {
            Log::warning('Unable to load landing blog posts: ' . $e->getMessage(), [
                'etablissement_id' => $this->etablissement->id ?? null,
            ]);

            return collect();
        }
    }

    protected function resolveLandingAssetUrl($path): ?string
    {
        $path = trim((string) $path);
        if ($path === '') {
            return null;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['/storage/'])) {
            return asset(ltrim($path, '/'));
        }

        if (\Illuminate\Support\Str::startsWith($path, ['storage/'])) {
            return asset($path);
        }

        if (\Illuminate\Support\Str::startsWith($path, ['/'])) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    protected function resolveLandingBlogUrl(BlogPost $post): string
    {
        $slug = trim((string) $post->slug);
        if ($slug === '') {
            return '#blog';
        }

        return route('cms.company.blog.show', [
            'etablissementId' => $post->etablissement_id ?: ($this->etablissement->id ?? null),
            'slug' => $slug,
        ]);
    }

    /**
     * Load active templates installed for the current establishment.
     */
    protected function getActiveEtablissementTemplates(): Collection
    {
        try {
            return EtablissementTemplate::query()
                ->with(['template' => function ($query) {
                    $query->select([
                        'id',
                        'name',
                        'slug',
                        'category',
                        'page_content',
                        'status',
                        'is_active',
                    ]);
                }])
                ->where('etablissement_id', $this->etablissement->id)
                ->where('is_active', true)
                ->orderByDesc('activated_at')
                ->orderByDesc('installed_at')
                ->orderByDesc('updated_at')
                ->orderByDesc('id')
                ->get();
        } catch (\Throwable $e) {
            Log::warning('Unable to load active etablissement templates: ' . $e->getMessage(), [
                'etablissement_id' => $this->etablissement->id ?? null,
            ]);

            return collect();
        }
    }

    /**
     * Pick the active template that decides which landing view should be rendered.
     */
    protected function selectLandingEtablissementTemplate(Collection $templates): ?EtablissementTemplate
    {
        // Landing unique : on prend simplement le premier template actif.
        return $templates->first();
    }

    /**
     * Convert active etablissement template content into the same section format used by CMS pages.
     */
    protected function getActiveTemplatePageSections(Collection $templates): Collection
    {
        return $templates
            ->map(function (EtablissementTemplate $etablissementTemplate) {
                $template = $etablissementTemplate->template;
                $content = $this->getEtablissementTemplateContent($etablissementTemplate);

                if ($content === '') {
                    return null;
                }

                return [
                    'id' => 'etablissement-template-' . $etablissementTemplate->id,
                    'title' => $template?->name ?: 'Template',
                    'slug' => $template?->slug ?: 'template-' . $etablissementTemplate->id,
                    'category' => $template?->category,
                    'content' => $content,
                    'source' => 'etablissement_template',
                ];
            })
            ->filter()
            ->values();
    }

    protected function getEtablissementTemplateContent(EtablissementTemplate $template): string
    {
        $content = $template->getAttribute('page_contents');

        if ($content === null || trim((string) $content) === '') {
            $content = $template->getAttribute('page_content');
        }

        if ($content === null || trim((string) $content) === '') {
            $content = data_get($template->config, 'page_contents');
        }

        if ($content === null || trim((string) $content) === '') {
            $content = data_get($template->config, 'page_content');
        }

        // Les templates portent les coordonnées de leur maquette. Les éléments
        // marqués data-gx-bind reçoivent ici celles de l'établissement ; les
        // autres, et ceux dont la donnée manque, gardent leur valeur d'origine.
        // Remplacement au rendu seulement : rien n'est réécrit en base, et
        // corriger la fiche de l'établissement suffit à mettre le site à jour.
        $coordonnees = $this->coordonneesPourTemplate();

        $content = \Vendor\Cms\Support\TemplateDataBinder::bind(
            trim((string) $content),
            $this->etablissement,
            [
                'lat'   => $coordonnees['lat'] ?? null,
                'lng'   => $coordonnees['lng'] ?? null,
                'hours' => $this->horairesPourTemplate(),
            ]
        );

        // Grilles marquées data-gx-products / data-gx-categories : les cartes de
        // démonstration sont remplacées par le vrai catalogue et les vrais
        // rayons de l'établissement (espace entreprise → E-commerce). Sans
        // donnée publiée, la démonstration reste en place.
        $etablissementId = $this->etablissement->id ?? null;

        $content = \Vendor\Cms\Support\TemplateProducts::hydrate($content, $etablissementId);
        $content = \Vendor\Cms\Support\TemplateCategories::hydrate($content, $etablissementId);

        return \Vendor\Cms\Support\TemplateActivities::hydrate($content, $etablissementId);
    }

    /**
     * Coordonnées de l'établissement, mémorisées.
     *
     * Calculées à la demande et non lues depuis la variable de la vue : le
     * contenu des templates est préparé AVANT elle dans buildLandingData().
     */
    private ?array $coordonneesTemplate = null;

    private function coordonneesPourTemplate(): array
    {
        return $this->coordonneesTemplate ??= $this->resolveEtablissementCoordinates();
    }

    /**
     * Horaires réels de l'établissement, sans repli.
     *
     * Le repli générique de la page d'accueil ne convient pas ici : le template
     * porte déjà ses propres horaires, et il vaut mieux les laisser que d'y
     * substituer des horaires inventés. Un tableau vide signifie « ne touche à
     * rien » pour le lieur.
     */
    private ?array $horairesTemplate = null;

    private function horairesPourTemplate(): array
    {
        if ($this->horairesTemplate !== null) {
            return $this->horairesTemplate;
        }

        try {
            $horaires = function_exists('get_establishment_opening_hours')
                ? get_establishment_opening_hours($this->etablissement, [])
                : [];
        } catch (\Throwable $e) {
            $horaires = [];
        }

        return $this->horairesTemplate = is_array($horaires) ? $horaires : [];
    }

    /**
     * Load CMS page content blocks for fallback landing pages.
     */
    protected function getLandingCmsPageSections(): Collection
    {
        try {
            return Page::query()
                ->where('etablissement_id', $this->etablissement->id)
                ->where('status', 'published')
                ->where(function ($query) {
                    $query->whereNull('visibility')
                        ->orWhere('visibility', 'public');
                })
                ->where(function ($query) {
                    $query->whereNull('published_at')
                        ->orWhere('published_at', '<=', now());
                })
                ->whereNotNull('content')
                ->orderByDesc('is_home')
                ->orderBy('id')
                ->get(['id', 'title', 'slug', 'content'])
                ->filter(fn (Page $page) => trim((string) $page->content) !== '')
                ->map(fn (Page $page) => [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'content' => $page->content,
                ])
                ->values();
        } catch (\Throwable $e) {
            Log::warning('Unable to load landing CMS page sections: ' . $e->getMessage(), [
                'etablissement_id' => $this->etablissement->id ?? null,
            ]);

            return collect();
        }
    }

    /**
     * Load landing media grouped by CMS gallery flags.
     */
    protected function getLandingMediaGroups(): array
    {
        try {
            $mediaItems = Media::query()
                ->where('etablissement_id', $this->etablissement->id)
                ->where('is_public', true)
                ->whereNull('deleted_at')
                ->ordered()
                ->limit(48)
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
                        'title' => $media->title,
                        'description' => $media->description,
                        'thumbnail' => $thumbnail,
                        'url' => $videoUrl ?: $media->url,
                        'type' => $media->type,
                        'is_main_gallery' => (bool) ($media->is_main_gallery ?? false),
                        'is_facebook_gallery' => (bool) ($media->is_facebook_gallery ?? false),
                        'is_instagram_gallery' => (bool) ($media->is_instagram_gallery ?? false),
                        'is_pinterest_gallery' => (bool) ($media->is_pinterest_gallery ?? false),
                    ];
                })
                ->filter(fn ($item) => !empty($item['thumbnail']))
                ->values();

            return [
                'all' => $mediaItems,
                'main' => $mediaItems->where('is_main_gallery', true)->values(),
                'facebook' => $mediaItems->where('is_facebook_gallery', true)->values(),
                'instagram' => $mediaItems->where('is_instagram_gallery', true)->values(),
                'pinterest' => $mediaItems->where('is_pinterest_gallery', true)->values(),
            ];
        } catch (\Throwable $e) {
            Log::warning('Unable to load landing gallery media: ' . $e->getMessage(), [
                'etablissement_id' => $this->etablissement->id,
            ]);

            return [
                'all' => collect(),
                'main' => collect(),
                'facebook' => collect(),
                'instagram' => collect(),
                'pinterest' => collect(),
            ];
        }
    }

    protected function buildLandingSlideshowGroups(Collection $mediaItems): Collection
    {
        $items = $mediaItems
            ->map(function ($item) {
                $url = trim((string) data_get($item, 'url'));
                $thumbnail = trim((string) (data_get($item, 'thumbnail') ?: $url));

                if ($url === '' || $thumbnail === '') {
                    return null;
                }

                $youtubeId = $this->extractYoutubeId($url);
                $type = strtolower((string) data_get($item, 'type'));
                $isVideo = $youtubeId
                    || str_starts_with($type, 'video')
                    || preg_match('/\.(mp4|webm|ogg)(\?.*)?$/i', $url);

                return [
                    'src' => $thumbnail,
                    'video' => $isVideo ? ($youtubeId ?: $url) : null,
                    'title' => data_get($item, 'title') ?: data_get($item, 'name') ?: 'Media',
                    'desc' => data_get($item, 'description') ?: '',
                    'badge' => null,
                ];
            })
            ->filter()
            ->values();

        return $items
            ->chunk(5)
            ->map(function ($chunk) {
                $chunk = $chunk->values();

                return [
                    'main' => $chunk->first(),
                    'grid' => $chunk->slice(1, 4)->values()->all(),
                ];
            })
            ->filter(fn ($group) => !empty($group['main']['src']))
            ->values();
    }

    protected function getLandingCmsSlideshowGroups(): Collection
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::connection('cms')->hasTable('cms_slideshows')) {
                return collect();
            }

            $slideshows = CmsSlideshow::query()
                ->where('etablissement_id', $this->etablissement->id)
                ->active()
                ->orderBy('sort_order')
                ->orderByDesc('id')
                ->limit(50)
                ->get();

            $items = $slideshows
                ->map(fn (CmsSlideshow $slideshow) => $this->normalizeLandingCmsSlideshowItem($slideshow))
                ->filter(fn ($item) => !empty($item['src']))
                ->values();

            return $items
                ->chunk(5)
                ->map(function ($chunk) {
                    $chunk = $chunk->values();

                    return [
                        'main' => $chunk->first(),
                        'grid' => $chunk->slice(1, 4)->values()->all(),
                    ];
                })
                ->filter(fn ($group) => !empty($group['main']['src']))
                ->values();
        } catch (\Throwable $e) {
            Log::warning('Unable to load landing CMS slideshow: ' . $e->getMessage(), [
                'etablissement_id' => $this->etablissement->id ?? null,
            ]);

            return collect();
        }
    }

    protected function normalizeLandingCmsSlideshowItem(CmsSlideshow $slideshow): ?array
    {
        $options = is_array($slideshow->options) ? $slideshow->options : [];
        $source = trim((string) ($slideshow->source ?? ''));
        $sourceAsImage = $this->isLandingCmsSlideshowImagePath($source) ? $source : null;
        $sourceAsVideo = $this->isLandingCmsSlideshowVideoPath($source) ? $source : null;

        $rawVideo = collect([
            $slideshow->video_url,
            $slideshow->video_path,
            data_get($options, 'video_url'),
            data_get($options, 'video_path'),
            data_get($options, 'video'),
            data_get($options, 'embed_url'),
            data_get($options, 'iframe_url'),
            $sourceAsVideo,
        ])->first(fn ($value) => is_string($value) && trim($value) !== '');

        $poster = collect([
            $slideshow->poster_url,
            data_get($options, 'poster_url'),
            data_get($options, 'thumbnail_url'),
            data_get($options, 'thumbnail'),
            data_get($options, 'image_url'),
            data_get($options, 'image'),
            $sourceAsImage,
        ])->first(fn ($value) => is_string($value) && trim($value) !== '');

        $videoUrl = $this->normalizeLandingCmsSlideshowVideoUrl($rawVideo);
        $youtubeId = $this->extractYoutubeId($videoUrl);
        if (!$youtubeId && is_string($videoUrl) && preg_match('/^[A-Za-z0-9_-]{11}$/', $videoUrl)) {
            $youtubeId = $videoUrl;
        }
        $posterUrl = $this->resolveLandingAssetUrl($poster);

        if (!$posterUrl && $youtubeId) {
            $posterUrl = 'https://i.ytimg.com/vi/' . $youtubeId . '/hqdefault.jpg';
        }

        if (!$posterUrl) {
            return null;
        }

        $video = null;
        if ($videoUrl) {
            if ($youtubeId) {
                $video = $youtubeId;
            } elseif (preg_match('/^[A-Za-z0-9_-]{11}$/', $videoUrl)) {
                $video = $videoUrl;
            } elseif (preg_match('/\.(mp4|webm|ogg)(\?.*)?$/i', $videoUrl)) {
                $video = $videoUrl;
            }
        }

        $sourceLabel = $source !== '' && !$sourceAsImage && !$sourceAsVideo ? $source : null;

        return [
            'src' => $posterUrl,
            'video' => $video,
            'title' => trim((string) ($slideshow->title ?: data_get($options, 'title') ?: ($this->etablissement->name ?? 'Media'))),
            'desc' => trim((string) ($slideshow->subtitle ?: data_get($options, 'subtitle') ?: data_get($options, 'description') ?: '')),
            'badge' => data_get($options, 'badge') ?: $sourceLabel,
        ];
    }

    protected function normalizeLandingCmsSlideshowVideoUrl($value): ?string
    {
        $raw = trim((string) $value);
        if ($raw === '') {
            return null;
        }

        $raw = $this->extractIframeSrc($raw) ?: $raw;

        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $raw)) {
            return $raw;
        }

        if (\Illuminate\Support\Str::startsWith($raw, ['http://', 'https://', '//'])) {
            return $raw;
        }

        return $this->resolveLandingAssetUrl($raw);
    }

    protected function isLandingCmsSlideshowImagePath(string $value): bool
    {
        if ($value === '') {
            return false;
        }

        return (bool) preg_match('/\.(jpg|jpeg|png|gif|webp|avif|svg)(\?.*)?$/i', $value);
    }

    protected function isLandingCmsSlideshowVideoPath(string $value): bool
    {
        if ($value === '') {
            return false;
        }

        if ($this->extractIframeSrc($value) || $this->extractYoutubeId($value)) {
            return true;
        }

        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $value)) {
            return true;
        }

        return (bool) preg_match('/\.(mp4|webm|ogg)(\?.*)?$/i', $value);
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

    protected function getLandingVideoChannelItems(): Collection
    {
        return collect()
            ->merge($this->getCmsSliderVideoChannelItems())
            ->merge($this->getCmsMediaVideoChannelItems())
            ->merge($this->getGlobalSliderVideoChannelItems())
            ->filter(fn ($video) => !empty($video['play_url']))
            ->unique(fn ($video) => md5(mb_strtolower((string) ($video['play_url'] ?? ''), 'UTF-8') . '|' . mb_strtolower((string) ($video['title'] ?? ''), 'UTF-8')))
            ->sortBy([
                ['order', 'asc'],
                ['id', 'desc'],
            ])
            ->values()
            ->map(function ($video, $index) {
                $video['id'] = $video['id'] ?: ('video-' . ($index + 1));
                $video['display_id'] = 'video-' . ($index + 1);

                return $video;
            });
    }

    protected function getGlobalVideoChannelItems(): Collection
    {
        return collect()
            ->merge($this->getGlobalCmsSliderVideoChannelItems())
            ->merge($this->getGlobalCmsMediaVideoChannelItems())
            ->merge($this->getGlobalSliderVideoChannelItems())
            ->filter(fn ($video) => !empty($video['play_url']))
            ->unique(fn ($video) => md5(
                mb_strtolower((string) ($video['play_url'] ?? ''), 'UTF-8') . '|'
                . mb_strtolower((string) ($video['title'] ?? ''), 'UTF-8') . '|'
                . (string) ($video['establishment_id'] ?? '')
            ))
            ->sortBy([
                ['order', 'asc'],
                ['id', 'desc'],
            ])
            ->values()
            ->map(function ($video, $index) {
                $video['id'] = $video['id'] ?: ('global-video-' . ($index + 1));
                $video['display_id'] = 'global-video-' . ($index + 1);

                return $video;
            });
    }

    protected function getGlobalVideoEstablishments(): Collection
    {
        return Etablissement::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->limit(500)
            ->get(['id', 'name', 'slug'])
            ->keyBy('id');
    }

    protected function getGlobalCmsSliderVideoChannelItems(): Collection
    {
        if (!function_exists('get_slider_items')) {
            return collect();
        }

        return $this->getGlobalVideoEstablishments()
            ->flatMap(function ($etablissement) {
                try {
                    return collect(get_slider_items($etablissement->id))
                        ->filter(function ($item) {
                            $url = trim((string) (data_get($item, 'video_html') ?: data_get($item, 'url') ?: data_get($item, 'video_url')));
                            return $this->isVideoChannelPayload(data_get($item, 'type'), $url);
                        })
                        ->map(function ($item, $index) use ($etablissement) {
                            return $this->makeVideoChannelItem([
                                'id' => 'cms-slider-' . $etablissement->id . '-' . (data_get($item, 'id') ?: $index),
                                'title' => data_get($item, 'title') ?: data_get($item, 'name') ?: 'Video',
                                'description' => data_get($item, 'subtitle') ?: data_get($item, 'description'),
                                'url' => data_get($item, 'video_html') ?: data_get($item, 'url') ?: data_get($item, 'video_url'),
                                'thumbnail' => data_get($item, 'poster_url') ?: data_get($item, 'thumbnail_url') ?: data_get($item, 'image_url'),
                                'channel' => $etablissement->name ?: 'Etablissement',
                                'origin' => 'cms_sliders',
                                'origin_label' => 'CMS sliders',
                                'order' => (int) data_get($item, 'order', $index + 1),
                                'establishment_id' => $etablissement->id,
                                'establishment_name' => $etablissement->name,
                                'establishment_url' => route('cms.company.home', ['etablissementId' => $etablissement->id]),
                            ]);
                        });
                } catch (\Throwable $e) {
                    return collect();
                }
            })
            ->values();
    }

    protected function getGlobalCmsMediaVideoChannelItems(): Collection
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::connection('cms')->hasTable('cms_media')) {
                return collect();
            }

            $establishments = $this->getGlobalVideoEstablishments();
            if ($establishments->isEmpty()) {
                return collect();
            }

            $hasVideoUrl = \Illuminate\Support\Facades\Schema::connection('cms')->hasColumn('cms_media', 'video_url');
            $query = Media::query()
                ->whereIn('etablissement_id', $establishments->keys()->all())
                ->where(function ($query) use ($hasVideoUrl) {
                    $query->where('type', 'like', 'video%')
                        ->orWhere('mime_type', 'like', 'video/%');

                    if ($hasVideoUrl) {
                        $query->orWhereNotNull('video_url');
                    }
                });

            if (\Illuminate\Support\Facades\Schema::connection('cms')->hasColumn('cms_media', 'is_public')) {
                $query->where('is_public', true);
            }

            if (\Illuminate\Support\Facades\Schema::connection('cms')->hasColumn('cms_media', 'order')) {
                $query->orderBy('order')->orderByDesc('id');
            } else {
                $query->orderByDesc('id');
            }

            return $query
                ->limit(500)
                ->get()
                ->map(function ($media) use ($establishments) {
                    $etablissement = $establishments->get($media->etablissement_id);
                    $etablissementName = $etablissement?->name ?: 'Etablissement';
                    $videoUrl = trim((string) ($media->video_url ?? ''));

                    return $this->makeVideoChannelItem([
                        'id' => 'cms-media-' . $media->id,
                        'title' => $media->title ?: $media->name ?: $media->original_name ?: 'Video',
                        'description' => $media->description,
                        'url' => $videoUrl ?: $media->url,
                        'thumbnail' => $media->thumbnail_url ?? null,
                        'channel' => $etablissementName,
                        'origin' => 'cms_media',
                        'origin_label' => ($media->folder && $media->folder !== '/' ? trim($media->folder, '/') : 'CMS media'),
                        'order' => (int) ($media->order ?? 1000),
                        'establishment_id' => $media->etablissement_id,
                        'establishment_name' => $etablissementName,
                        'establishment_url' => $etablissement ? route('cms.company.home', ['etablissementId' => $etablissement->id]) : null,
                    ]);
                });
        } catch (\Throwable $e) {
            return collect();
        }
    }

    protected function getCmsSliderVideoChannelItems(): Collection
    {
        try {
            return collect(get_slider_items($this->etablissement->id))
                ->filter(function ($item) {
                    $url = trim((string) (data_get($item, 'video_html') ?: data_get($item, 'url') ?: data_get($item, 'video_url')));
                    return $this->isVideoChannelPayload(data_get($item, 'type'), $url);
                })
                ->map(function ($item, $index) {
                    return $this->makeVideoChannelItem([
                        'id' => 'cms-slider-' . (data_get($item, 'id') ?: $index),
                        'title' => data_get($item, 'title') ?: data_get($item, 'name') ?: 'Video',
                        'description' => data_get($item, 'subtitle') ?: data_get($item, 'description'),
                        'url' => data_get($item, 'video_html') ?: data_get($item, 'url') ?: data_get($item, 'video_url'),
                        'thumbnail' => data_get($item, 'poster_url') ?: data_get($item, 'thumbnail_url') ?: data_get($item, 'image_url'),
                        'channel' => 'CMS sliders',
                        'origin' => 'cms_sliders',
                        'origin_label' => 'CMS sliders',
                        'order' => (int) data_get($item, 'order', $index + 1),
                    ]);
                });
        } catch (\Throwable $e) {
            return collect();
        }
    }

    protected function getCmsMediaVideoChannelItems(): Collection
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::connection('cms')->hasTable('cms_media')) {
                return collect();
            }

            $hasVideoUrl = \Illuminate\Support\Facades\Schema::connection('cms')->hasColumn('cms_media', 'video_url');
            $query = Media::query()
                ->where('etablissement_id', $this->etablissement->id)
                ->where(function ($query) use ($hasVideoUrl) {
                    $query->where('type', 'like', 'video%')
                        ->orWhere('mime_type', 'like', 'video/%');

                    if ($hasVideoUrl) {
                        $query->orWhereNotNull('video_url');
                    }
                });

            if (\Illuminate\Support\Facades\Schema::connection('cms')->hasColumn('cms_media', 'is_public')) {
                $query->where('is_public', true);
            }

            if (\Illuminate\Support\Facades\Schema::connection('cms')->hasColumn('cms_media', 'order')) {
                $query->orderBy('order')->orderByDesc('id');
            } else {
                $query->orderByDesc('id');
            }

            return $query
                ->limit(200)
                ->get()
                ->map(function ($media) {
                    $videoUrl = trim((string) ($media->video_url ?? ''));

                    return $this->makeVideoChannelItem([
                        'id' => 'cms-media-' . $media->id,
                        'title' => $media->title ?: $media->name ?: $media->original_name ?: 'Video',
                        'description' => $media->description,
                        'url' => $videoUrl ?: $media->url,
                        'thumbnail' => $media->thumbnail_url ?? null,
                        'channel' => $media->folder && $media->folder !== '/' ? trim($media->folder, '/') : 'CMS media',
                        'origin' => 'cms_media',
                        'origin_label' => 'CMS media',
                        'order' => (int) ($media->order ?? 1000),
                    ]);
                });
        } catch (\Throwable $e) {
            return collect();
        }
    }

    protected function getGlobalSliderVideoChannelItems(): Collection
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('sliders')) {
                return collect();
            }

            return Slider::query()
                ->active()
                ->videos()
                ->ordered()
                ->limit(100)
                ->get()
                ->map(function ($slider) {
                    return $this->makeVideoChannelItem([
                        'id' => 'slider-' . $slider->id,
                        'title' => $slider->name ?: 'Video',
                        'description' => $slider->description,
                        'url' => $slider->video_embed_url ?: $slider->video_url ?: $slider->video_path,
                        'thumbnail' => $slider->thumbnail_url ?: $slider->image_url,
                        'channel' => 'GoExploria',
                        'origin' => 'sliders',
                        'origin_label' => 'Sliders',
                        'order' => (int) ($slider->order ?? 1000),
                        'establishment_id' => null,
                        'establishment_name' => 'GoExploria',
                        'establishment_url' => url('/'),
                    ]);
                });
        } catch (\Throwable $e) {
            return collect();
        }
    }

    protected function makeVideoChannelItem(array $data): array
    {
        $rawUrl = trim((string) ($data['url'] ?? ''));
        $iframeSrc = $this->extractIframeSrc($rawUrl) ?: $rawUrl;
        $source = $this->detectVideoChannelSource($iframeSrc);
        $embed = $this->toVideoChannelEmbedUrl($iframeSrc, $source);
        $thumbnail = trim((string) ($data['thumbnail'] ?? ''));

        if ($thumbnail === '' && $source['name'] === 'youtube' && $source['id']) {
            $thumbnail = 'https://i.ytimg.com/vi/' . $source['id'] . '/hqdefault.jpg';
        }

        return [
            'id' => $data['id'] ?? null,
            'title' => trim((string) ($data['title'] ?? 'Video')),
            'description' => trim((string) ($data['description'] ?? '')),
            'channel' => trim((string) ($data['channel'] ?? $data['origin_label'] ?? 'Videos')) ?: 'Videos',
            'origin' => $data['origin'] ?? 'videos',
            'origin_label' => $data['origin_label'] ?? 'Videos',
            'source' => $source['name'],
            'source_label' => $source['label'],
            'source_id' => $source['id'],
            'play_url' => $embed ?: $iframeSrc,
            'raw_url' => $iframeSrc,
            'thumbnail' => $thumbnail !== '' ? $thumbnail : null,
            'is_iframe' => $source['name'] !== 'local',
            'order' => (int) ($data['order'] ?? 1000),
            'establishment_id' => $data['establishment_id'] ?? null,
            'establishment_name' => $data['establishment_name'] ?? null,
            'establishment_url' => $data['establishment_url'] ?? null,
        ];
    }

    protected function buildGlobalVideoSuggestions(Collection $videos, string $query): array
    {
        $needle = Str::lower(Str::ascii(trim($query)));

        return $videos
            ->flatMap(fn ($video) => [
                $video['title'] ?? null,
                $video['channel'] ?? null,
                $video['source_label'] ?? null,
                $video['origin_label'] ?? null,
                $video['establishment_name'] ?? null,
            ])
            ->filter()
            ->unique()
            ->filter(function ($value) use ($needle) {
                if ($needle === '') {
                    return true;
                }

                return str_contains(Str::lower(Str::ascii((string) $value)), $needle);
            })
            ->take(10)
            ->values()
            ->all();
    }

    protected function buildGlobalVideoItemSuggestions(Collection $videos, string $query): array
    {
        $needle = Str::lower(Str::ascii(trim($query)));

        return $videos
            ->filter(function ($video) use ($needle) {
                if ($needle === '') {
                    return true;
                }

                $haystack = Str::lower(Str::ascii(implode(' ', [
                    $video['title'] ?? '',
                    $video['description'] ?? '',
                    $video['channel'] ?? '',
                    $video['source_label'] ?? '',
                    $video['origin_label'] ?? '',
                    $video['establishment_name'] ?? '',
                ])));

                return str_contains($haystack, $needle);
            })
            ->take(6)
            ->values()
            ->all();
    }

    protected function isVideoChannelPayload($type, ?string $url): bool
    {
        $type = mb_strtolower((string) $type, 'UTF-8');
        $url = trim((string) $url);

        return str_contains($type, 'video')
            || $this->detectVideoChannelSource($url)['name'] !== 'local'
            || (bool) preg_match('/\.(mp4|webm|ogg|mov|m4v)(\?.*)?$/i', $url);
    }

    protected function detectVideoChannelSource(?string $url): array
    {
        $value = trim((string) $url);

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|live\/|embed\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $value, $m)) {
            return ['name' => 'youtube', 'label' => 'YouTube', 'id' => $m[1]];
        }

        if (preg_match('/(?:vimeo\.com\/(?:.*\/)?|player\.vimeo\.com\/video\/)(\d+)/i', $value, $m)) {
            return ['name' => 'vimeo', 'label' => 'Vimeo', 'id' => $m[1]];
        }

        if (preg_match('/dailymotion\.com\/(?:embed\/)?video\/([A-Za-z0-9]+)/i', $value, $m)) {
            return ['name' => 'dailymotion', 'label' => 'Dailymotion', 'id' => $m[1]];
        }

        return ['name' => 'local', 'label' => 'Video', 'id' => null];
    }

    protected function toVideoChannelEmbedUrl(?string $url, array $source): ?string
    {
        $value = trim((string) $url);
        if ($value === '') {
            return null;
        }

        return match ($source['name']) {
            'youtube' => 'https://www.youtube.com/embed/' . $source['id'],
            'vimeo' => 'https://player.vimeo.com/video/' . $source['id'],
            'dailymotion' => 'https://www.dailymotion.com/embed/video/' . $source['id'],
            default => $value,
        };
    }

    /**
     * Resolve the fallback landing from the active establishment template category.
     */
    protected function resolveTemplateLandingView(?EtablissementTemplate $etablissementTemplate): string
    {
        // Landing UNIQUE : plus de sélection par catégorie de template.
        // Tous les établissements utilisent la même landing générique.
        return 'cms::web.fallback.landing';
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

        $orderedActivities = collect();

        if (!empty($this->etablissement->other_activity_label)) {
            $fallback = new Activity();
            $fallback->name = (string) $this->etablissement->other_activity_label;
            $fallback->description = 'Activité principale de cet établissement.';
            $orderedActivities->push($fallback);
        }

        if ($primaryActivity) {
            $orderedActivities->push($primaryActivity);
        }

        $activities
            ->reject(fn ($activity) => $primaryActivity && (int) ($activity->id ?? 0) === (int) $primaryActivity->id)
            ->each(fn ($activity) => $orderedActivities->push($activity));

        return $orderedActivities
            ->unique(fn ($activity) => mb_strtolower(\Illuminate\Support\Str::ascii((string) ($activity->name ?? '')), 'UTF-8'))
            ->values();
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
        $html = $this->injectCartDrawer($html);
        $html = $this->injectProductModal($html);
        $html = $this->injectImmoRequestForm($html);
        $html = $this->injectSwiperAssets($html);
        $html = $this->injectEmbedBridge($html);

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=utf-8',
        ]);
    }

    /**
     * Injecte le pont parent-enfant sur TOUTE page d'établissement.
     *
     * ─────────────────────────────────────────────────────────────────────
     * POURQUOI ICI, ET PLUS SEULEMENT DANS embed()
     * ─────────────────────────────────────────────────────────────────────
     * Le pont n'était posé que par `embed()`, qui ne rend que l'ACCUEIL. Or
     * l'iframe du shell ne se referme pas quand le visiteur clique un lien du
     * menu : elle navigue vers `/company/{id}/page/{slug}`, une page rendue
     * sans pont. Conséquences, toutes silencieuses :
     *
     *   • la hauteur n'est plus annoncée — l'iframe garde celle de l'accueil,
     *     et la page intérieure se retrouve tronquée ou suivie d'un grand vide ;
     *   • aucune modale n'est recalée sur la bande visible : dans une iframe
     *     haute comme son contenu, un `position:fixed` se centre sur la PAGE,
     *     donc la fiche s'ouvre tout en bas.
     *
     * Ce défaut est resté invisible tant que les gabarits n'avaient qu'une
     * page. Il est apparu avec les pages secondaires livrées par les
     * templates (voir TemplateInstaller::createSecondaryPages).
     *
     * Poser le pont partout ne coûte rien : sa toute première ligne est
     * `if (window.self === window.top) return;`. Hors iframe, il ne fait
     * strictement rien.
     */
    protected function injectEmbedBridge($html)
    {
        if (! is_string($html) || $html === '') {
            return $html;
        }

        $pos = strripos($html, '</body>');

        if ($pos === false) {
            return $html;
        }

        // Déjà posé : embed() garde son injection, et deux ponts se
        // disputeraient la hauteur annoncée. Le shell parent porte le même
        // marqueur, mais il ne passe jamais par cet entonnoir — platformSite()
        // le rend directement.
        if (strpos($html, "CHANNEL = 'gx-embed'") !== false) {
            return $html;
        }

        try {
            $pont = view('cms::web.embed.partials.child-bridge')->render();
        } catch (\Throwable $e) {
            Log::warning('Embed bridge injection failed: ' . $e->getMessage());

            return $html;
        }

        return substr($html, 0, $pos) . $pont . substr($html, $pos);
    }

    /**
     * Charge et initialise Swiper côté front lorsque la page contient du markup
     * Swiper (hero vidéos, galerie). Les templates ne portent aucun <script>.
     */
    protected function injectSwiperAssets($html)
    {
        if (!is_string($html) || $html === '') {
            return $html;
        }
        if (stripos($html, '</body>') === false) {
            return $html;
        }
        // Rien à faire si pas de markup Swiper, ou si déjà initialisé
        if (stripos($html, 'swiper-slide') === false && stripos($html, 'data-swiper') === false) {
            return $html;
        }
        if (stripos($html, 'swiper-bundle') !== false) {
            return $html;
        }

        try {
            $assets = view('cms::web.fallback.partials.swiper-autoinit')->render();
        } catch (\Throwable $e) {
            \Log::warning('Swiper assets injection failed: ' . $e->getMessage());
            return $html;
        }

        return preg_replace_callback('/<\/body>/i', function () use ($assets) {
            return $assets . '</body>';
        }, $html, 1);
    }

    /**
     * Injecte le panier (drawer + icône flottante + logique) sur les sites des
     * établissements. Ne fait rien si le panier est déjà présent (pages landing
     * qui l'incluent déjà) ou si la page n'a pas de balise </body>.
     */
    protected function injectCartDrawer($html)
    {
        if (!is_string($html) || $html === '') {
            return $html;
        }
        if (stripos($html, '</body>') === false) {
            return $html;
        }
        if (stripos($html, 'data-cms-cart-drawer') !== false) {
            return $html; // déjà présent
        }

        try {
            $drawer = view('cms::web.fallback.partials.landing-cart-drawer', [
                'etablissement' => $this->etablissement,
            ])->render();
        } catch (\Throwable $e) {
            \Log::warning('Cart drawer injection failed: ' . $e->getMessage());
            return $html;
        }

        // Callback pour éviter l'interprétation des `$` (le drawer contient des
        // template-literals ${...} et des symboles $ qui seraient traités comme
        // des backreferences par preg_replace.
        return preg_replace_callback('/<\/body>/i', function () use ($drawer) {
            return $drawer . '</body>';
        }, $html, 1);
    }

    /**
     * Branche le formulaire de demande de la fiche d'un bien.
     *
     * Le gabarit immobilier affiche un message de succès sans rien envoyer :
     * ce bloc complète le formulaire (dates, voyageurs) et transmet vraiment
     * la demande. Injecté au rendu, il atteint aussi les sites déjà installés,
     * dont la page est une copie figée du gabarit.
     *
     * N'agit que sur les pages qui portent la fiche (`data-im-detail`).
     */
    protected function injectImmoRequestForm($html)
    {
        if (! is_string($html) || $html === '') {
            return $html;
        }
        if (stripos($html, '</body>') === false) {
            return $html;
        }
        if (stripos($html, 'data-im-detail') === false) {
            return $html;   // pas de fiche de bien sur cette page
        }
        if (stripos($html, '__gxImmoRequest') !== false) {
            return $html;   // déjà branché
        }

        try {
            // Le calendrier vient APRÈS le formulaire : il s'installe dans les
            // champs de date que celui-ci pose.
            $bloc = view('cms::web.fallback.partials.gx-immo-request', [
                'etablissement' => $this->etablissement,
            ])->render()
                . view('cms::web.fallback.partials.gx-immo-calendar', [
                    'etablissement' => $this->etablissement,
                ])->render()
                // Media principal de la fiche : photo ou video. Lit GX_IMMO,
                // deja pose par gx-immo-data — aucune requete de plus.
                . view('cms::web.fallback.partials.gx-immo-media')->render();
        } catch (\Throwable $e) {
            \Log::warning('Immo request form injection failed: ' . $e->getMessage());

            return $html;
        }

        // preg_replace_callback et non preg_replace : le script contient des
        // séquences que le remplacement prendrait pour des références.
        return preg_replace_callback('/<\/body>/i', function () use ($bloc) {
            return $bloc . '</body>';
        }, $html, 1);
    }

    /**
     * Injecte la modale de détail produit sur les pages qui portent des cartes
     * hydratées (`data-gx-modal`). Rien à faire ailleurs : une page sans
     * produit n'a aucune raison d'embarquer ce balisage ni ce script.
     */
    protected function injectProductModal($html)
    {
        if (!is_string($html) || $html === '') {
            return $html;
        }
        if (stripos($html, '</body>') === false) {
            return $html;
        }
        if (stripos($html, 'data-gx-modal') === false) {
            return $html;   // aucune carte produit sur cette page
        }
        if (stripos($html, 'data-gxpm-shell') !== false) {
            return $html;   // déjà présente
        }

        try {
            $modale = view('cms::web.fallback.partials.gx-product-modal')->render();
        } catch (\Throwable $e) {
            \Log::warning('Product modal injection failed: ' . $e->getMessage());

            return $html;
        }

        // Même précaution que pour le tiroir : le script contient des `${...}`
        // que preg_replace prendrait pour des références de capture.
        return preg_replace_callback('/<\/body>/i', function () use ($modale) {
            return $modale . '</body>';
        }, $html, 1);
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

        $slogan = trim((string) ($this->etablissement->getSetting('slogan', null, 'general') ?? ''));

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
            'slogan' => $slogan,
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
