<?php

namespace Vendor\Cms\Controllers\Web;

use App\Http\Controllers\Controller;
use Vendor\Cms\Models\Page;
use Vendor\Cms\Models\Theme;
use Vendor\Cms\Models\Setting;
use Vendor\Cms\Models\ContactMessage;
use Vendor\Cms\Models\Media;
use Vendor\Cms\Models\Traits\HasSettings;
use App\Models\Etablissement;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PublicPageController extends Controller
{
    use HasSettings;

    protected $etablissement;
    protected $activeTheme;
    protected $previewMode = false;

    public function __construct(Request $request, $etablissementId = null)
    {
        // Récupérer l'établissement depuis l'URL
        if ($etablissementId) {
            $this->etablissement = Etablissement::findOrFail($etablissementId);
        } else {
            // Fallback pour la compatibilité
            $this->etablissement = $this->resolveEtablissement($request);
        }

        if (!$this->etablissement && $request->routeIs('cms.checkout*')) {
            return;
        }

        if (!$this->etablissement) {
            abort(404, 'Établissement non trouvé');
        }

        // Récupérer le thème actif
        $this->loadActiveTheme();

        // Vérifier le mode prévisualisation
        $this->checkPreviewMode($request);

        // Enregistrer le namespace du thème
        $this->registerThemeNamespace();
    }

    /**
     * Charge le thème actif
     */
    protected function loadActiveTheme()
    {
        // Vérifier le mode prévisualisation
        if ($this->previewMode && session()->has('preview_theme_id')) {
            $this->activeTheme = Theme::where('id', session('preview_theme_id'))
                ->where('etablissement_id', $this->etablissement->id)
                ->first();
        }

        // Sinon, prendre le thème actif
        if (!$this->activeTheme) {
            $this->activeTheme = \DB::connection('cms')->table('cms_themes')
            ->join('cms_etablissement_theme', 'cms_themes.id', '=', 'cms_etablissement_theme.theme_id')
            ->where('cms_etablissement_theme.etablissement_id', $this->etablissement->id)
            ->where('cms_themes.is_active', true)
            ->select('cms_themes.*')
            ->first();
        }

        // Log pour débogage
        if ($this->activeTheme) {
            \Log::info('Theme loaded:', [
                'id' => $this->activeTheme->id,
                'name' => $this->activeTheme->name,
                'slug' => $this->activeTheme->slug,
                'etablissement_id' => $this->etablissement->id,
                'preview_mode' => $this->previewMode
            ]);
        }
    }

    /**
     * Enregistrer le namespace du thème pour les vues
     */
    protected function registerThemeNamespace()
    {
        if (!$this->activeTheme) {
            return;
        }

        // Construire le chemin complet du thème
        $themePath = $this->getThemePath();

        if ($themePath && File::exists($themePath)) {
            // Enregistrer le namespace "theme" pour ce thème
            View::addNamespace('theme', $themePath);

            // Enregistrer un namespace spécifique par slug
            View::addNamespace('theme_' . $this->activeTheme->slug, $themePath);
        }
    }

    /**
     * Récupérer le chemin complet du thème
     */
    protected function getThemePath()
    {
        if (!$this->activeTheme) {
            return null;
        }

        $slug = is_object($this->activeTheme) ? ($this->activeTheme->slug ?? null) : null;
        if (!$slug) {
            return null;
        }

        $paths = [
            storage_path("app/public/cms/themes/{$this->etablissement->id}/{$slug}"),
            storage_path("app/public/cms/themes/{$slug}"),
        ];

        foreach ($paths as $candidate) {
            if (File::exists($candidate)) {
                return $candidate;
            }
        }

        return $paths[0];
    }

    /**
     * Affiche la page d'accueil
     */
    public function home(Request $request, $etablissementId)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;

        // Recharger le thème pour cet établissement
        $this->loadActiveTheme();
        $this->registerThemeNamespace();

        $homePage = null;

        // Vérifier si la colonne is_home existe
        if (Schema::connection('cms')->hasColumn('cms_pages', 'is_home')) {
            $homePage = Page::where('etablissement_id', $this->etablissement->id)
                ->where('is_home', true)
                ->where('status', 'published')
                ->first();
        }

        if (!$homePage) {
            $homePage = Page::where('etablissement_id', $this->etablissement->id)
                ->where('slug', 'home')
                ->where('status', 'published')
                ->first();
        }

        // Si toujours pas de page, créer une page par défaut
        if (!$homePage) {
            $homePage = $this->createDefaultHomePage();
        }

        return $this->renderPage($homePage);
    }

    /**
     * Affiche une page par son slug
     */
    public function show(Request $request, $etablissementId, $slug)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;

        // Recharger le thème pour cet établissement
        $this->loadActiveTheme();
        $this->registerThemeNamespace();

        $page = Page::where('etablissement_id', $this->etablissement->id)
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return $this->renderPage($page);
    }

    /**
     * Rendu d'une page avec le thème
     */
    protected function renderPage($page)
    {
        $cacheKey = $this->getCacheKey($page);

        if (!$this->previewMode && config('cms.cache_pages', false) && Cache::has($cacheKey)) {
            $html = Cache::get($cacheKey);
            return $this->buildResponse($html, $this->buildSeoContext($page));
        }

        $theme = $this->activeTheme;

        if (!$theme) {
            return $this->renderFallback($page, 'Aucun thème installé. Veuillez installer et activer un thème.');
        }

        // Récupérer le chemin du thème
        $themePath = $this->getThemePath();

        if (!$themePath || !File::exists($themePath)) {
            return $this->renderFallback($page, "Le thème '{$theme->name}' est introuvable.");
        }

        // Vérifier si le fichier layout existe
        $layoutFile = $themePath . '/layout.blade.php';

        if (!File::exists($layoutFile)) {
            return $this->renderFallback($page, "Le fichier layout.blade.php est manquant dans le thème '{$theme->name}'");
        }

        try {
            $viewData = $this->prepareViewData($page, $theme);

            // Méthode 1: Utiliser le namespace enregistré
            if (View::exists('theme::layout')) {
                $html = view('theme::layout', $viewData)->render();
            }
            // Méthode 2: Utiliser le namespace spécifique
            elseif (View::exists('theme_' . $theme->slug . '::layout')) {
                $html = view('theme_' . $theme->slug . '::layout', $viewData)->render();
            }
            // Méthode 3: Charger directement le fichier
            else {
                $html = $this->loadViewDirectly($themePath, $viewData);
            }

            if (!$this->previewMode && config('cms.cache_pages', false)) {
                Cache::put($cacheKey, $html, now()->addMinutes(config('cms.page_cache_lifetime', 60)));
            }

            return $this->buildResponse($html, $this->buildSeoContext($page));

        } catch (\Exception $e) {
            \Log::error('Theme rendering error: ' . $e->getMessage(), [
                'theme' => $theme->name,
                'path' => $themePath,
                'page_id' => $page->id,
                'exception' => $e
            ]);

            return $this->renderFallback($page, "Erreur de rendu: " . $e->getMessage());
        }
    }

    /**
     * Prépare les données pour la vue
     */
    protected function prepareViewData($page, $theme)
    {
        return [
            'page' => $page,
            'content' => $page->content,
            'etablissement' => $this->etablissement,
            'activeTheme' => $theme,
            'settings' => $this->getAllSettings(),
            'menu' => $this->getMenu(),
            'sliderMedia' => $this->getSliderMedia(),
            'previewMode' => $this->previewMode,
            'assetBase' => url("/themes/{$this->etablissement->id}/{$theme->id}/assets"),
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
            \Log::warning('Unable to load cms slider media: ' . $e->getMessage(), [
                'etablissement_id' => $this->etablissement->id,
            ]);

            return collect();
        }
    }

    /**
     * Charger une vue directement depuis le fichier
     */
    protected function loadViewDirectly($themePath, $viewData)
    {
        $layoutPath = $themePath . '/layout.blade.php';

        if (!File::exists($layoutPath)) {
            throw new \Exception("Layout file not found: {$layoutPath}");
        }

        // Créer un nom de vue temporaire unique
        $tempViewName = 'temp_theme_' . md5($themePath);
        $compiledPath = storage_path('framework/views/' . $tempViewName . '.blade.php');

        if (!File::exists(dirname($compiledPath))) {
            File::makeDirectory(dirname($compiledPath), 0755, true);
        }

        File::copy($layoutPath, $compiledPath);

        try {
            $html = view()->file($compiledPath, $viewData)->render();
            if (File::exists($compiledPath)) {
                File::delete($compiledPath);
            }
            return $html;
        } catch (\Exception $e) {
            if (File::exists($compiledPath)) {
                File::delete($compiledPath);
            }
            throw $e;
        }
    }

    /**
     * Rendu fallback quand le thème n'est pas disponible
     */
    protected function renderFallback($page, $errorMessage = null)
    {
        $html = $this->getFallbackHtml($page, $errorMessage);
        return $this->buildResponse($html, $this->buildSeoContext($page));
    }

    /**
     * HTML fallback
     */
    protected function getFallbackHtml($page, $errorMessage = null)
    {
        return '<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . e($page->title) . ' - ' . e($this->etablissement->name) . '</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f5f5f5; color: #333; line-height: 1.6; }
                .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 60px 0; text-align: center; margin-bottom: 40px; }
                .header h1 { font-size: 2.5rem; margin-bottom: 10px; }
                .content { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 40px; }
                .alert { background: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 8px; margin-bottom: 20px; color: #856404; }
                .footer { text-align: center; padding: 20px; color: #666; border-top: 1px solid #eee; }
                @media (max-width: 768px) {
                    .header { padding: 40px 0; }
                    .header h1 { font-size: 1.8rem; }
                    .content { padding: 20px; }
                }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="container">
                    <h1>' . e($this->etablissement->name) . '</h1>
                    <p>' . e($page->title) . '</p>
                </div>
            </div>
            <div class="container">
                <div class="content">' .
                ($errorMessage ? '<div class="alert"><strong>⚠️ Attention:</strong> ' . e($errorMessage) . '</div>' : '') .
                '<div class="page-content">' . $page->content . '</div>
                </div>
            </div>
            <div class="footer">
                <p>&copy; ' . date('Y') . ' ' . e($this->etablissement->name) . '. Tous droits réservés.</p>
            </div>
        </body>
        </html>';
    }

    /**
     * Construit la réponse HTTP
     */
    public function checkout(Request $request)
    {
        $html = view('cms::web.fallback.checkout', [
            'checkoutSubmitUrl' => route('cms.checkout.submit'),
        ])->render();

        return $this->buildResponse($html, [
            'title' => 'Finaliser ma commande',
            'description' => 'Finalisation des commandes produits GoExploria.',
        ]);
    }

    public function submitCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:60'],
            'company' => ['nullable', 'string', 'max:180'],
            'message' => ['nullable', 'string', 'max:5000'],
            'cart_payload' => ['required', 'string'],
            'consent' => ['accepted'],
        ]);

        if ($validator->fails()) {
            return $this->checkoutValidationResponse($request, $validator->errors()->toArray());
        }

        $payload = json_decode((string) $request->input('cart_payload'), true);
        if (!is_array($payload)) {
            return $this->checkoutValidationResponse($request, ['cart_payload' => ['Panier invalide.']]);
        }

        $cartItems = collect($payload['items'] ?? $payload)
            ->map(function ($item) {
                return [
                    'id' => (int) data_get($item, 'id'),
                    'quantity' => max(1, min(999, (int) data_get($item, 'quantity', 1))),
                ];
            })
            ->filter(fn ($item) => $item['id'] > 0)
            ->groupBy('id')
            ->map(fn ($items) => [
                'id' => (int) $items->first()['id'],
                'quantity' => (int) $items->sum('quantity'),
            ])
            ->values();

        if ($cartItems->isEmpty()) {
            return $this->checkoutValidationResponse($request, ['cart_payload' => ['Votre panier est vide.']]);
        }

        try {
            $products = Product::query()
                ->with(['etablissement:id,name,email_contact,phone', 'category:id,name', 'family:id,name'])
                ->whereIn('id', $cartItems->pluck('id')->all())
                ->where('is_available_for_sale', true)
                ->where('is_public', true)
                ->get()
                ->keyBy('id');
        } catch (\Throwable $e) {
            \Log::warning('Unable to load checkout products: ' . $e->getMessage());

            return $this->checkoutValidationResponse($request, ['cart_payload' => ['Impossible de verifier les produits du panier.']]);
        }

        $lines = $cartItems
            ->map(function ($item) use ($products) {
                $product = $products->get($item['id']);
                if (!$product) {
                    return null;
                }

                $unitPrice = (float) ($product->price_ttc ?? $product->price_ht ?? 0);
                $quantity = (int) $item['quantity'];

                return [
                    'product_id' => $product->id,
                    'etablissement_id' => $product->etablissement_id,
                    'etablissement_name' => optional($product->etablissement)->name,
                    'name' => $product->name,
                    'reference' => $product->reference,
                    'category' => optional($product->category)->name ?: optional($product->family)->name,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'line_total' => round($unitPrice * $quantity, 2),
                ];
            })
            ->filter()
            ->values();

        if ($lines->isEmpty()) {
            return $this->checkoutValidationResponse($request, ['cart_payload' => ['Aucun produit disponible dans ce panier.']]);
        }

        $reference = 'CMD-' . now()->format('YmdHis') . '-' . strtoupper(\Illuminate\Support\Str::random(5));
        $visitorName = trim((string) $request->input('first_name') . ' ' . (string) $request->input('last_name'));
        $grandTotal = round((float) $lines->sum('line_total'), 2);
        $createdMessages = collect();

        try {
            foreach ($lines->groupBy('etablissement_id') as $etablissementId => $groupLines) {
                $summary = $groupLines
                    ->map(fn ($line) => '- ' . $line['name'] . ' x ' . $line['quantity'] . ' = ' . number_format($line['line_total'], 2, ',', ' ') . ' $')
                    ->implode("\n");

                $message = "Commande {$reference}\n\n"
                    . "Client: {$visitorName}\n"
                    . "Email: " . $request->input('email') . "\n"
                    . "Telephone: " . ($request->input('phone') ?: '-') . "\n\n"
                    . "Produits:\n{$summary}\n\n"
                    . "Message client:\n" . ($request->input('message') ?: '-');

                $createdMessages->push(ContactMessage::create([
                    'etablissement_id' => (int) $etablissementId,
                    'form_name' => 'landing_product_checkout',
                    'source' => 'landing_checkout',
                    'source_url' => $request->headers->get('referer') ?: $request->fullUrl(),
                    'referrer' => $request->headers->get('referer'),
                    'name' => $visitorName,
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'company' => $request->input('company'),
                    'subject' => 'Commande produits ' . $reference,
                    'message' => $message,
                    'status' => 'new',
                    'priority' => 'high',
                    'consent' => true,
                    'ip_address' => $request->ip(),
                    'user_agent' => substr((string) $request->userAgent(), 0, 500),
                    'metadata' => [
                        'type' => 'product_checkout',
                        'reference' => $reference,
                        'grand_total' => $grandTotal,
                        'etablissement_total' => round((float) $groupLines->sum('line_total'), 2),
                        'items' => $groupLines->values()->all(),
                    ],
                ]));
            }
        } catch (\Throwable $e) {
            \Log::error('Unable to save checkout request: ' . $e->getMessage(), [
                'reference' => $reference,
                'exception' => $e,
            ]);

            return $this->checkoutValidationResponse($request, ['checkout' => ['Impossible d enregistrer la commande.']]);
        }

        $response = [
            'success' => true,
            'message' => 'Votre commande a ete envoyee.',
            'reference' => $reference,
            'messages_count' => $createdMessages->count(),
        ];

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json($response);
        }

        return redirect()->route('cms.checkout')->with('checkout_success', $response);
    }

    protected function checkoutValidationResponse(Request $request, array $errors)
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Merci de verifier les informations.',
                'errors' => $errors,
            ], 422);
        }

        return redirect()->back()->withErrors($errors)->withInput();
    }

    protected function buildResponse($html, array $seoContext = [])
    {
        $html = $this->injectSeoMeta($html, $seoContext);

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=utf-8',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    protected function buildSeoContext($page): array
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
            $slider = $this->getSliderMedia()->first();
            $image = trim((string) (
                data_get($slider, 'image_url')
                ?: data_get($slider, 'url')
                ?: data_get($slider, 'path')
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
            'robots' => $this->previewMode ? 'noindex, nofollow' : 'index, follow',
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
     * Créer une page d'accueil par défaut
     */
    protected function createDefaultHomePage()
    {
        return Page::create([
            'etablissement_id' => $this->etablissement->id,
            'title' => 'Accueil',
            'slug' => 'home',
            'content' => '<h1>Bienvenue sur notre site</h1>
                          <p>Ceci est votre page d\'accueil par défaut. Vous pouvez modifier ce contenu depuis l\'interface d\'administration.</p>
                          <h2>Commencez à personnaliser votre site</h2>
                          <ul>
                              <li>Créez de nouvelles pages</li>
                              <li>Installez et activez un thème</li>
                              <li>Configurez les paramètres du site</li>
                          </ul>',
            'status' => 'published',
            'visibility' => 'public',
            'is_home' => true,
            'published_at' => now(),
        ]);
    }

    /**
     * Rendu des assets du thème (CSS, JS, images)
     */
    public function asset($etablissementId, $themeId, $path)
    {
        try {
            $theme = Theme::where('id', $themeId)
                ->where('etablissement_id', $etablissementId)
                ->firstOrFail();

            $path = ltrim($path, '/');
            $filePaths = [
                storage_path("app/public/cms/themes/{$etablissementId}/{$theme->slug}/assets/{$path}"),
                storage_path("app/public/cms/themes/{$theme->slug}/assets/{$path}"),
            ];

            $filePath = null;
            foreach ($filePaths as $candidate) {
                if (file_exists($candidate)) {
                    $filePath = str_replace('\\', '/', $candidate);
                    break;
                }
            }

            if (!$filePath) {
                \Log::warning('Asset not found: ' . $filePath);
                abort(404);
            }

            $file = file_get_contents($filePath);
            $mimeType = mime_content_type($filePath);
            $cacheControl = app()->environment('local') ? 'no-cache' : 'public, max-age=31536000, immutable';

            return response($file, 200, [
                'Content-Type' => $mimeType,
                'Content-Length' => filesize($filePath),
                'Cache-Control' => $cacheControl,
            ]);

        } catch (\Exception $e) {
            \Log::error('Asset error: ' . $e->getMessage());
            abort(404);
        }
    }

    /**
     * Page fallback pour les routes non trouvées
     */
    public function fallback(Request $request, $etablissementId = null)
    {
        if ($etablissementId) {
            $etablissement = Etablissement::find($etablissementId);
            if ($etablissement) {
                $this->etablissement = $etablissement;

                $page404 = Page::where('etablissement_id', $this->etablissement->id)
                    ->where('slug', '404')
                    ->where('status', 'published')
                    ->first();

                if ($page404) {
                    return $this->renderPage($page404);
                }
            }
        }

        abort(404);
    }

    /**
     * Vérifie le mode prévisualisation
     */
    protected function checkPreviewMode(Request $request)
    {
        if ($request->has('preview_theme')) {
            $this->previewMode = true;
            session(['preview_theme_id' => $request->preview_theme]);
        }

        if ($request->has('preview') && $request->preview == 'true') {
            $this->previewMode = true;
        }

        if (session()->has('preview_theme_id')) {
            $this->previewMode = true;
        }

        if (session()->has('page_preview')) {
            $this->previewMode = true;
        }
    }

    /**
     * Récupère la clé de cache
     */
    protected function getCacheKey($page)
    {
        $key = "page_{$this->etablissement->id}_{$page->id}";

        if ($this->previewMode) {
            $key .= '_preview';
        }

        return $key;
    }

    /**
     * Résoudre l'établissement
     */
    protected function resolveEtablissement($request)
    {
        // Par sous-domaine
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];

        // $etablissement = Etablissement::where('subdomain', $subdomain)->first();

        // if ($etablissement) {
        //     return $etablissement;
        // }

        // Par paramètre
        // if ($request->has('etablissement')) {
        //     return Etablissement::where('slug', $request->etablissement)->first();
        // }

        // Établissement par défaut
        return Etablissement::first();
    }

    /**
     * Récupérer tous les paramètres de l'établissement
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
     * Récupérer le menu principal
     */
    protected function getMenu()
    {
        $menuItems = Setting::where('etablissement_id', $this->etablissement->id)
            ->where('group', 'menu')
            ->where('key', 'main_menu')
            ->first();

        if ($menuItems) {
            return $menuItems->value;
        }

        // Menu par défaut
        return [
            ['label' => 'Accueil', 'url' => '/company/' . $this->etablissement->id, 'active' => false],
            ['label' => 'À propos', 'url' => '/company/' . $this->etablissement->id . '/page/about', 'active' => false],
            ['label' => 'Services', 'url' => '/company/' . $this->etablissement->id . '/page/services', 'active' => false],
            ['label' => 'Contact', 'url' => '/company/' . $this->etablissement->id . '/page/contact', 'active' => false],
        ];
    }

    public function subscribeApi(Request $request, $etablissementId)
    {
            $etablissement = \App\Models\Etablissement::findOrFail($etablissementId);
            $this->etablissement = $etablissement;

            // Valider les données
            $request->validate([
                'email' => 'required|email',
            ]);

            \App\Models\MailSubscriber::create([
                'etablissement_id' => $this->etablissement->id,
                'email' => $request->email,
                'nom' => substr($request->email, 0, strpos($request->email, '@')),
            ]);
        // Logique d'abonnement à la newsletter
        return response()->json(['message' => 'Abonnement réussi']);
    }

    public function contact(Request $request, $etablissementId)
    {
        return redirect(route('cms.company.home', ['etablissementId' => $etablissementId]) . '#contact');
    }

    public function videoSearch(Request $request, $etablissementId)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;

        $query = trim((string) $request->query('q', ''));
        $channel = trim((string) $request->query('channel', 'all'));
        $limit = max(1, min((int) $request->query('limit', 24), 60));

        $videos = $this->collectVideoChannelItems();

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
                ])));

                return str_contains($haystack, $needle);
            });
        }

        $videos = $videos->values();
        $suggestions = $this->buildVideoSuggestions($this->collectVideoChannelItems(), $query);

        return response()->json([
            'videos' => $videos->take($limit)->values(),
            'total' => $videos->count(),
            'suggestions' => $suggestions,
            'channels' => $this->collectVideoChannelItems()
                ->groupBy('channel')
                ->map(fn ($items, $name) => ['name' => $name, 'count' => $items->count()])
                ->values(),
        ]);
    }

    public function sendContact(Request $request, $etablissementId)
    {
        return $this->storeContactMessage($request, $etablissementId);
    }

    public function contactApi(Request $request, $etablissementId)
    {
        return $this->storeContactMessage($request, $etablissementId);
    }

    protected function collectVideoChannelItems(): \Illuminate\Support\Collection
    {
        if (!$this->etablissement) {
            return collect();
        }

        $items = collect()
            ->merge($this->collectCmsSliderVideos())
            ->merge($this->collectCmsMediaVideos())
            ->merge($this->collectGlobalSliderVideos())
            ->filter(fn ($video) => !empty($video['play_url']))
            ->unique(fn ($video) => md5(Str::lower((string) ($video['play_url'] ?? '')) . '|' . Str::lower((string) ($video['title'] ?? ''))))
            ->sortBy([
                ['order', 'asc'],
                ['id', 'desc'],
            ])
            ->values();

        return $items->map(function ($video, $index) {
            $video['id'] = $video['id'] ?: ($index + 1);
            $video['display_id'] = 'video-' . ($index + 1);
            return $video;
        });
    }

    protected function collectCmsSliderVideos(): \Illuminate\Support\Collection
    {
        try {
            return collect(get_slider_items($this->etablissement->id))
                ->filter(function ($item) {
                    $url = trim((string) (data_get($item, 'url') ?: data_get($item, 'video_url') ?: data_get($item, 'video_html')));
                    return $this->isVideoPayload(data_get($item, 'type'), $url);
                })
                ->map(function ($item, $index) {
                    $url = trim((string) (data_get($item, 'video_html') ?: data_get($item, 'url') ?: data_get($item, 'video_url')));
                    return $this->makeVideoChannelItem([
                        'id' => 'cms-slider-' . (data_get($item, 'id') ?: $index),
                        'title' => data_get($item, 'title') ?: data_get($item, 'name') ?: 'Video',
                        'description' => data_get($item, 'subtitle') ?: data_get($item, 'description'),
                        'url' => $url,
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

    protected function collectCmsMediaVideos(): \Illuminate\Support\Collection
    {
        try {
            if (!Schema::connection('cms')->hasTable('cms_media')) {
                return collect();
            }

            $hasVideoUrl = Schema::connection('cms')->hasColumn('cms_media', 'video_url');
            $query = Media::query()
                ->where('etablissement_id', $this->etablissement->id)
                ->where(function ($query) use ($hasVideoUrl) {
                    $query->where('type', 'like', 'video%')
                        ->orWhere('mime_type', 'like', 'video/%');
                    if ($hasVideoUrl) {
                        $query->orWhereNotNull('video_url');
                    }
                });

            if (Schema::connection('cms')->hasColumn('cms_media', 'is_public')) {
                $query->where('is_public', true);
            }

            if (Schema::connection('cms')->hasColumn('cms_media', 'order')) {
                $query->orderBy('order')->orderByDesc('id');
            } else {
                $query->orderByDesc('id');
            }

            return $query->limit(200)->get()->map(function ($media) {
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

    protected function collectGlobalSliderVideos(): \Illuminate\Support\Collection
    {
        try {
            if (!Schema::hasTable('sliders')) {
                return collect();
            }

            return \App\Models\Slider::query()
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
                        'channel' => 'Sliders',
                        'origin' => 'sliders',
                        'origin_label' => 'Sliders',
                        'order' => (int) ($slider->order ?? 1000),
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
        $source = $this->detectVideoSource($iframeSrc);
        $embed = $this->toVideoEmbedUrl($iframeSrc, $source);
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
        ];
    }

    protected function isVideoPayload($type, ?string $url): bool
    {
        $type = Str::lower((string) $type);
        $url = trim((string) $url);

        return str_contains($type, 'video')
            || $this->detectVideoSource($url)['name'] !== 'local'
            || (bool) preg_match('/\.(mp4|webm|ogg|mov|m4v)(\?.*)?$/i', $url);
    }

    protected function detectVideoSource(?string $url): array
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

    protected function toVideoEmbedUrl(?string $url, array $source): ?string
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

    protected function buildVideoSuggestions(\Illuminate\Support\Collection $videos, string $query): array
    {
        $needle = Str::lower(Str::ascii(trim($query)));

        return $videos
            ->flatMap(fn ($video) => [$video['title'] ?? null, $video['channel'] ?? null, $video['source_label'] ?? null])
            ->filter()
            ->unique()
            ->filter(function ($value) use ($needle) {
                if ($needle === '') {
                    return true;
                }
                return str_contains(Str::lower(Str::ascii((string) $value)), $needle);
            })
            ->take(8)
            ->values()
            ->all();
    }

    protected function storeContactMessage(Request $request, $etablissementId)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);
        $this->etablissement = $etablissement;

        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['nullable', 'string', 'max:120'],
            'name' => ['nullable', 'string', 'max:190'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:80'],
            'company' => ['nullable', 'string', 'max:190'],
            'preferred_contact_method' => ['nullable', 'string', 'max:80'],
            'subject' => ['nullable', 'string', 'max:190'],
            'service' => ['nullable', 'string', 'max:190'],
            'message' => ['required', 'string', 'min:5', 'max:5000'],
            'consent' => ['nullable', 'boolean'],
            'newsletter_opt_in' => ['nullable', 'boolean'],
        ], [
            'first_name.required' => 'Le prénom est requis.',
            'email.required' => 'Le courriel est requis.',
            'email.email' => 'Le courriel doit être valide.',
            'message.required' => 'Le message est requis.',
            'message.min' => 'Le message doit contenir au moins 5 caractères.',
        ]);

        if ($validator->fails()) {
            return $this->contactValidationResponse($request, $validator);
        }

        $validated = $validator->validated();
        $firstName = trim((string) ($validated['first_name'] ?? ''));
        $lastName = trim((string) ($validated['last_name'] ?? ''));
        $fullName = trim((string) ($validated['name'] ?? trim($firstName . ' ' . $lastName)));
        $service = trim((string) ($validated['service'] ?? ''));
        $subject = trim((string) ($validated['subject'] ?? ''));

        if ($subject === '') {
            $subject = $service !== '' ? $service : 'Message depuis la landing page';
        }

        $reserved = [
            '_token', 'first_name', 'last_name', 'name', 'email', 'phone', 'company',
            'preferred_contact_method', 'subject', 'service', 'message', 'consent',
            'newsletter_opt_in',
        ];

        $metadata = collect($request->except($reserved))
            ->filter(fn ($value) => !is_array($value) && trim((string) $value) !== '')
            ->all();

        if ($service !== '') {
            $metadata['service'] = $service;
        }

        $message = ContactMessage::create([
            'etablissement_id' => $etablissement->id,
            'form_name' => trim((string) $request->input('form_name', 'landing_contact')) ?: 'landing_contact',
            'source' => 'landing_page',
            'source_url' => $request->headers->get('referer') ?: $request->fullUrl(),
            'referrer' => $request->headers->get('referer'),
            'name' => $fullName,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'company' => $validated['company'] ?? null,
            'preferred_contact_method' => $validated['preferred_contact_method'] ?? null,
            'subject' => $subject,
            'message' => $validated['message'],
            'status' => 'new',
            'priority' => 'normal',
            'consent' => (bool) $request->boolean('consent', true),
            'newsletter_opt_in' => (bool) $request->boolean('newsletter_opt_in', false),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
            'utm_source' => $request->input('utm_source'),
            'utm_medium' => $request->input('utm_medium'),
            'utm_campaign' => $request->input('utm_campaign'),
            'metadata' => $metadata,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Votre message a bien été envoyé. Nous vous répondrons rapidement.',
                'id' => $message->id,
            ]);
        }

        return back()->with('success', 'Votre message a bien été envoyé.');
    }

    protected function contactValidationResponse(Request $request, $validator)
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Merci de vérifier les champs requis.',
                'errors' => $validator->errors(),
            ], 422);
        }

        return back()->withErrors($validator)->withInput();
    }
}
