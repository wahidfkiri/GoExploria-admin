<?php

namespace Vendor\Cms\Controllers\Web;

use App\Http\Controllers\Controller;
use Vendor\Cms\Models\Page;
use Vendor\Cms\Models\Theme;
use Vendor\Cms\Models\Setting;
use Vendor\Cms\Models\ContactMessage;
use Vendor\Cms\Models\Media;
use Vendor\Cms\Models\Traits\HasSettings;
use App\Models\Customer;
use App\Models\Etablissement;
use App\Models\OnlineOrder;
use App\Models\OnlineOrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PublicPageController extends Controller
{
    use HasSettings;

    /**
     * Devise des commandes passées depuis les sites d'établissement.
     *
     * Les prix sont affichés en dollars sur tout le front (tiroir panier,
     * checkout, PayPal) : la colonne `currency` doit dire la même chose, sans
     * quoi les totaux de l'espace entreprise seraient libellés à tort en euros
     * (valeur par défaut de la table).
     */
    protected const DEVISE_COMMANDE = 'CAD';

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
        // PayPal disponible uniquement s'il est activé et configuré côté admin
        $paypal = ['enabled' => false, 'client_id' => null, 'mode' => 'sandbox', 'currency' => 'CAD'];
        try {
            if (class_exists(\App\Models\PaymentGateway::class)) {
                $gateway = \App\Models\PaymentGateway::where('code', 'paypal')
                    ->where('is_active', true)
                    ->whereNotNull('paypal_client_id')
                    ->where('paypal_client_id', '!=', '')
                    ->orderByDesc('is_default')
                    ->first();

                if ($gateway) {
                    $paypal = [
                        'enabled' => true,
                        'client_id' => $gateway->paypal_client_id,
                        'mode' => $gateway->mode ?: 'sandbox',
                        'currency' => (is_array($gateway->supported_currencies) && !empty($gateway->supported_currencies))
                            ? (string) $gateway->supported_currencies[0]
                            : 'CAD',
                    ];
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('Checkout PayPal config lookup failed: ' . $e->getMessage());
        }

        $html = view('cms::web.fallback.checkout', [
            'checkoutSubmitUrl' => route('cms.checkout.submit'),
            'paypal' => $paypal,
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
            'payment_method' => ['nullable', 'in:cod,paypal'],
            'payment_reference' => ['nullable', 'string', 'max:120'],
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

                $quantity = (int) $item['quantity'];

                // Le prix affiché au client est le TTC. Le HT est reconstitué
                // depuis le taux de taxe du produit lorsqu'il n'est pas saisi,
                // pour que la facture et les statistiques restent justes.
                $taxRate = (float) ($product->tax_rate ?? 0);
                $unitTtc = (float) ($product->price_ttc ?? 0);
                $unitHt = (float) ($product->price_ht ?? 0);

                if ($unitTtc <= 0 && $unitHt > 0) {
                    $unitTtc = $taxRate > 0 ? round($unitHt * (1 + $taxRate / 100), 2) : $unitHt;
                }
                if ($unitHt <= 0 && $unitTtc > 0) {
                    $unitHt = $taxRate > 0 ? round($unitTtc / (1 + $taxRate / 100), 2) : $unitTtc;
                }

                return [
                    'product_id' => $product->id,
                    'etablissement_id' => $product->etablissement_id,
                    'etablissement_name' => optional($product->etablissement)->name,
                    'name' => $product->name,
                    'reference' => $product->reference,
                    'category' => optional($product->category)->name ?: optional($product->family)->name,
                    'quantity' => $quantity,
                    'tax_rate' => $taxRate,
                    'unit_price' => $unitTtc,
                    'unit_price_ht' => $unitHt,
                    'line_total_ht' => round($unitHt * $quantity, 2),
                    'line_total' => round($unitTtc * $quantity, 2),
                ];
            })
            ->filter()
            ->values();

        if ($lines->isEmpty()) {
            return $this->checkoutValidationResponse($request, ['cart_payload' => ['Aucun produit disponible dans ce panier.']]);
        }

        $reference = 'CMD-' . now()->format('YmdHis') . '-' . strtoupper(\Illuminate\Support\Str::random(5));
        $paymentMethod = $request->input('payment_method') === 'paypal' ? 'paypal' : 'cod';
        $paymentReference = trim((string) $request->input('payment_reference'));
        $paymentLabel = $paymentMethod === 'paypal'
            ? 'PayPal' . ($paymentReference !== '' ? ' (réf. ' . $paymentReference . ')' : '')
            : 'Paiement à la livraison';
        $visitorName = trim((string) $request->input('first_name') . ' ' . (string) $request->input('last_name'));
        $grandTotal = round((float) $lines->sum('line_total'), 2);
        $paye = $paymentMethod === 'paypal' && $paymentReference !== '';
        $commandes = collect();
        $aNotifier = collect();

        // Un panier peut mélanger les produits de plusieurs établissements :
        // chacun reçoit SA commande, sinon un commerçant verrait les lignes
        // d'un confrère. La référence commune relie le tout côté client.
        try {
            DB::transaction(function () use (
                $request, $lines, $reference, $paymentMethod, $paymentReference,
                $visitorName, $grandTotal, $paye, &$commandes, &$aNotifier
            ) {
                $rang = 0;

                foreach ($lines->groupBy('etablissement_id') as $etablissementId => $groupLines) {
                    $etablissementId = (int) $etablissementId;
                    $rang++;

                    $client = $this->resoudreClientCommande($request, $etablissementId, $visitorName);

                    $totalHt = round((float) $groupLines->sum('line_total_ht'), 2);
                    $totalTtc = round((float) $groupLines->sum('line_total'), 2);

                    $commande = OnlineOrder::create([
                        'order_number' => $reference . '-' . $rang,
                        'etablissement_id' => $etablissementId,
                        'customer_id' => $client->id,
                        'status' => $paye ? 'paid' : 'pending_payment',
                        'payment_status' => $paye ? 'paid' : 'pending',
                        'subtotal_ht' => $totalHt,
                        'subtotal_ttc' => $totalTtc,
                        'tax_total' => round($totalTtc - $totalHt, 2),
                        'shipping_amount' => 0,
                        'discount_amount' => 0,
                        'total' => $totalTtc,
                        'currency' => self::DEVISE_COMMANDE,
                        'payment_gateway_code' => $paymentMethod === 'paypal' ? 'paypal' : null,
                        'billing_address' => [
                            'first_name' => $request->input('first_name'),
                            'last_name' => $request->input('last_name'),
                            'email' => $request->input('email'),
                            'phone' => $request->input('phone'),
                            'company' => $request->input('company'),
                        ],
                        'notes' => $request->input('message') ?: null,
                        'metadata' => [
                            'source' => 'cms_checkout',
                            'reference_panier' => $reference,
                            'payment_method' => $paymentMethod,
                            'payment_reference' => $paymentReference ?: null,
                            'grand_total_panier' => $grandTotal,
                            'ip' => $request->ip(),
                        ],
                        'ordered_at' => now(),
                        'paid_at' => $paye ? now() : null,
                    ]);

                    foreach ($groupLines as $ligne) {
                        OnlineOrderItem::create([
                            'online_order_id' => $commande->id,
                            'product_id' => $ligne['product_id'],
                            'product_name' => $ligne['name'],
                            'product_reference' => $ligne['reference'],
                            'quantity' => $ligne['quantity'],
                            'unit_price_ht' => $ligne['unit_price_ht'],
                            'unit_price_ttc' => $ligne['unit_price'],
                            'tax_rate' => $ligne['tax_rate'],
                            'tax_amount' => round($ligne['line_total'] - $ligne['line_total_ht'], 2),
                            'line_subtotal_ht' => $ligne['line_total_ht'],
                            'line_subtotal_ttc' => $ligne['line_total'],
                            'line_total' => $ligne['line_total'],
                            'metadata' => ['category' => $ligne['category']],
                        ]);

                        // Compteur de ventes du catalogue : sert au tri
                        // « meilleures ventes » des grilles de template.
                        Product::where('id', $ligne['product_id'])
                            ->increment('sales_count', $ligne['quantity']);
                    }

                    $commandes->push($commande);
                    $aNotifier->push([$commande, $groupLines]);
                }
            });
        } catch (\Throwable $e) {
            \Log::error('Unable to save checkout order: ' . $e->getMessage(), [
                'reference' => $reference,
                'exception' => $e,
            ]);

            return $this->checkoutValidationResponse($request, ['checkout' => ['Impossible d enregistrer la commande.']]);
        }

        // APRÈS la transaction, volontairement. La messagerie vit sur la
        // connexion « cms », distincte de celle des commandes : une écriture
        // pendant la transaction ne serait de toute façon pas couverte par le
        // rollback, et ferait attendre un verrou. On notifie donc une fois la
        // commande durablement enregistrée.
        foreach ($aNotifier as [$commande, $groupLines]) {
            $this->notifierCommande(
                $request,
                $commande,
                $groupLines,
                $reference,
                $visitorName,
                $paymentLabel,
                $grandTotal
            );
        }

        $response = [
            'success' => true,
            'message' => 'Votre commande a ete enregistree.',
            'reference' => $reference,
            'orders_count' => $commandes->count(),
            'order_numbers' => $commandes->pluck('order_number')->all(),
            'total' => $grandTotal,
            'redirect_url' => route('cms.checkout.success', ['reference' => $reference]),
        ];

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json($response);
        }

        return redirect()->route('cms.checkout.success', ['reference' => $reference]);
    }

    /**
     * Retrouve ou crée le client de l'établissement à partir de l'e-mail saisi.
     *
     * Le rattachement est fait PAR ÉTABLISSEMENT : deux commerçants ne
     * partagent pas leur fichier client, et un même acheteur existe donc une
     * fois chez chacun.
     */
    protected function resoudreClientCommande(Request $request, int $etablissementId, string $visitorName): Customer
    {
        $email = trim((string) $request->input('email'));
        $entreprise = trim((string) $request->input('company'));

        $donnees = [
            'type' => $entreprise !== '' ? 'entreprise' : 'particulier',
            'prenom' => $request->input('first_name'),
            'nom' => $request->input('last_name') ?: $visitorName,
            'telephone' => $request->input('phone'),
            'entreprise_nom' => $entreprise ?: null,
        ];

        $client = Customer::where('etablissement_id', $etablissementId)
            ->where('email', $email)
            ->first();

        if ($client) {
            // On complète les champs restés vides sans écraser une fiche déjà
            // renseignée par le commerçant.
            $client->fill(array_filter(
                $donnees,
                fn ($valeur, $cle) => !empty($valeur) && empty($client->{$cle}),
                ARRAY_FILTER_USE_BOTH
            ))->save();

            return $client;
        }

        return Customer::create($donnees + [
            'etablissement_id' => $etablissementId,
            'email' => $email,
        ]);
    }

    /**
     * Dépose la commande dans la messagerie de l'établissement.
     *
     * Volontairement tolérante aux pannes : si la notification échoue, la
     * commande — déjà enregistrée — ne doit pas être perdue pour autant.
     */
    protected function notifierCommande(
        Request $request,
        OnlineOrder $commande,
        $groupLines,
        string $reference,
        string $visitorName,
        string $paymentLabel,
        float $grandTotal
    ): void {
        try {
            $recap = $groupLines
                ->map(fn ($l) => '- ' . $l['name'] . ' x ' . $l['quantity']
                    . ' = ' . number_format($l['line_total'], 2, ',', ' ') . ' $')
                ->implode("\n");

            ContactMessage::create([
                'etablissement_id' => $commande->etablissement_id,
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
                'subject' => 'Commande ' . $commande->order_number,
                'message' => "Commande {$commande->order_number}\n\n"
                    . "Client: {$visitorName}\n"
                    . 'Email: ' . $request->input('email') . "\n"
                    . 'Telephone: ' . ($request->input('phone') ?: '-') . "\n"
                    . "Paiement: {$paymentLabel}\n\n"
                    . "Produits:\n{$recap}\n\n"
                    . 'Total etablissement: ' . number_format((float) $commande->total, 2, ',', ' ') . " $\n\n"
                    . "Message client:\n" . ($request->input('message') ?: '-'),
                'status' => 'new',
                'priority' => 'high',
                'consent' => true,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'metadata' => [
                    'type' => 'product_checkout',
                    'reference' => $reference,
                    'online_order_id' => $commande->id,
                    'order_number' => $commande->order_number,
                    'grand_total' => $grandTotal,
                    'etablissement_total' => (float) $commande->total,
                    'items' => $groupLines->values()->all(),
                ],
            ]);
        } catch (\Throwable $e) {
            \Log::warning('Checkout notification failed: ' . $e->getMessage(), [
                'order_number' => $commande->order_number,
            ]);
        }
    }

    /**
     * Boutique d'un établissement : tous ses produits publiés.
     *
     * Sert de page de repli aux liens posés par TemplateProducts sur les
     * grilles de template, et de catalogue complet quand la grille de la page
     * d'accueil n'en montre qu'une sélection.
     */
    public function products(Request $request, $etablissementId)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);

        // Filtre par rayon : c'est la cible des tuiles « Nos rayons » du site.
        // Le rayon doit appartenir à l'établissement (ou à la plateforme),
        // sinon l'URL permettrait de sonder les rayons privés d'un confrère.
        $rayon = null;
        if ($request->filled('rayon')) {
            $rayon = \App\Models\ProductCategory::pourEtablissement($etablissement->id)
                ->find((int) $request->input('rayon'));
        }

        // Recherche plein texte simple : nom, description courte et référence.
        // La référence est incluse parce qu'un client rappelle souvent une
        // commande par ce code plutôt que par le libellé du produit.
        $recherche = trim((string) $request->input('q'));

        $produits = Product::query()
            ->with(['category:id,name', 'family:id,name'])
            ->where('etablissement_id', $etablissement->id)
            ->where('is_public', true)
            ->where('is_available_for_sale', true)
            ->when($rayon, fn ($q) => $q->where('product_category_id', $rayon->id))
            ->when($recherche !== '', function ($q) use ($recherche) {
                // Les jokers du client sont neutralisés : « 100 % » ne doit pas
                // se comporter comme un joker SQL.
                $terme = '%' . str_replace(['%', '_'], ['\%', '\_'], $recherche) . '%';

                $q->where(function ($sous) use ($terme) {
                    $sous->where('name', 'like', $terme)
                        ->orWhere('short_description', 'like', $terme)
                        ->orWhere('reference', 'like', $terme);
                });
            })
            ->orderByDesc('sales_count')
            ->orderByDesc('created_at')
            ->paginate(24)
            ->withQueryString();

        // Rayons non vides, pour la barre de filtres. whereHas et non having() :
        // `products_count` est une sous-requête, pas un agrégat, et SQLite
        // refuse un HAVING sans GROUP BY.
        $siens = fn ($q) => $q
            ->where('etablissement_id', $etablissement->id)
            ->where('is_public', true)
            ->where('is_available_for_sale', true);

        $rayons = \App\Models\ProductCategory::pourEtablissement($etablissement->id)
            ->where('is_active', true)
            ->withCount(['products' => $siens])
            ->whereHas('products', $siens)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $html = view('cms::web.fallback.products-index', [
            'etablissement' => $etablissement,
            'produits' => $produits,
            'rayons' => $rayons,
            'rayonActif' => $rayon,
            'recherche' => $recherche,
            'siteUrl' => url('/company/' . $etablissement->id),
            'boutiqueUrl' => url('/company/' . $etablissement->id . '/produits'),
        ])->render();

        return $this->buildResponse($html, [
            'title' => ($rayon ? $rayon->name . ' — ' : '') . 'Boutique — ' . $etablissement->name,
            'description' => $rayon
                ? 'Les produits du rayon ' . $rayon->name . ' chez ' . $etablissement->name . '.'
                : 'Tous les produits proposés par ' . $etablissement->name . '.',
            // Une page de résultats n'a pas à être indexée : autant d'URL que
            // de requêtes, pour un contenu qui existe déjà dans la boutique.
            'robots' => $recherche !== '' ? 'noindex,follow' : null,
        ]);
    }

    /**
     * Fiche d'un produit.
     *
     * Le filtre par établissement n'est pas décoratif : sans lui, l'URL d'un
     * établissement permettrait d'afficher le produit d'un autre commerçant,
     * et le bouton « ajouter au panier » rattacherait la vente au mauvais.
     */
    public function productShow(Request $request, $etablissementId, $productId)
    {
        $etablissement = Etablissement::findOrFail($etablissementId);

        $produit = Product::query()
            ->with(['category:id,name', 'family:id,name'])
            ->where('etablissement_id', $etablissement->id)
            ->where('is_public', true)
            ->findOrFail($productId);

        // Compteur de consultations, sans faire échouer la page s'il manque.
        try {
            Product::where('id', $produit->id)->increment('views_count');
        } catch (\Throwable $e) {
            // colonne absente ou base en lecture seule : sans importance ici
        }

        $similaires = Product::query()
            ->where('etablissement_id', $etablissement->id)
            ->where('is_public', true)
            ->where('is_available_for_sale', true)
            ->where('id', '!=', $produit->id)
            ->when($produit->product_category_id, fn ($q) => $q->where('product_category_id', $produit->product_category_id))
            ->orderByDesc('sales_count')
            ->limit(4)
            ->get();

        $html = view('cms::web.fallback.product-show', [
            'etablissement' => $etablissement,
            'produit' => $produit,
            'similaires' => $similaires,
            'siteUrl' => url('/company/' . $etablissement->id),
            'boutiqueUrl' => url('/company/' . $etablissement->id . '/produits'),
        ])->render();

        return $this->buildResponse($html, [
            'title' => $produit->meta_title ?: ($produit->name . ' — ' . $etablissement->name),
            'description' => $produit->meta_description
                ?: \Illuminate\Support\Str::limit(strip_tags((string) $produit->short_description), 155),
        ]);
    }

    /**
     * Confirmation d'achat : récapitule les commandes créées à partir de leur
     * référence de panier commune.
     */
    public function checkoutSuccess(Request $request, string $reference)
    {
        $commandes = OnlineOrder::with(['items', 'etablissement:id,name'])
            ->where('order_number', 'like', $reference . '-%')
            ->orderBy('id')
            ->get();

        if ($commandes->isEmpty()) {
            abort(404, 'Commande introuvable.');
        }

        $html = view('cms::web.fallback.checkout-success', [
            'reference' => $reference,
            'commandes' => $commandes,
            'total' => round((float) $commandes->sum('total'), 2),
            'boutiqueUrl' => url('/'),
        ])->render();

        return $this->buildResponse($html, [
            'title' => 'Commande confirmée',
            'description' => 'Confirmation de votre commande ' . $reference . '.',
            'robots' => 'noindex,nofollow',
        ]);
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
        $html = $this->injectGlobalHeader($html);

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=utf-8',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Injecte l'en-tête global du site (repris de « / », version solide) juste
     * après <body> sur les pages établissements. Totalement protégé : en cas
     * d'erreur, la page est retournée telle quelle.
     */
    protected function injectGlobalHeader($html)
    {
        try {
            if (! is_string($html) || $html === '') {
                return $html;
            }
            // Déjà injecté ? (évite les doublons)
            if (strpos($html, 'id="cghHeader"') !== false) {
                return $html;
            }
            // Nécessite une balise <body>
            if (! preg_match('/<body[^>]*>/i', $html)) {
                return $html;
            }

            if (! preg_match('/<body[^>]*>/i', $html, $m, PREG_OFFSET_CAPTURE)) {
                return $html;
            }

            $header = view('cms::web.partials.global-site-header')->render();

            // Insertion par position (évite l'interprétation de « $ » par preg_replace).
            $pos = $m[0][1] + strlen($m[0][0]);

            return substr($html, 0, $pos) . "\n" . $header . substr($html, $pos);
        } catch (\Throwable $e) {
            \Log::warning('Injection en-tête global échouée: ' . $e->getMessage());
            return $html;
        }
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

        // Configuration du formulaire (admin) : détermine les champs requis.
        $cfCfg = \Vendor\Cms\Support\ContactFormConfig::for($etablissement);
        $cfFields = $cfCfg['fields'] ?? [];
        $reqRule = function (string $key, array $base) use ($cfFields) {
            $required = ! empty($cfFields[$key]['enabled']) && ! empty($cfFields[$key]['required']);
            return array_merge([$required ? 'required' : 'nullable'], $base);
        };

        $validator = Validator::make($request->all(), [
            'first_name' => $reqRule('first_name', ['string', 'max:120']),
            'last_name' => $reqRule('last_name', ['string', 'max:120']),
            'name' => ['nullable', 'string', 'max:190'],
            'email' => $reqRule('email', ['email', 'max:190']),
            'phone' => $reqRule('phone', ['string', 'max:80']),
            'company' => $reqRule('company', ['string', 'max:190']),
            'preferred_contact_method' => ['nullable', 'string', 'max:80'],
            'subject' => $reqRule('subject', ['string', 'max:190']),
            'service' => ['nullable', 'string', 'max:190'],
            'message' => $reqRule('message', array_merge(['string', 'max:5000'], ! empty($cfFields['message']['required']) ? ['min:5'] : [])),
            'attachment' => ['nullable', 'file', 'max:10240', 'mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp,txt,zip'],
            'consent' => ['nullable', 'boolean'],
            'newsletter_opt_in' => ['nullable', 'boolean'],
        ], [
            'first_name.required' => 'Le prénom est requis.',
            'email.required' => 'Le courriel est requis.',
            'email.email' => 'Le courriel doit être valide.',
            'message.required' => 'Le message est requis.',
            'message.min' => 'Le message doit contenir au moins 5 caractères.',
            'attachment.max' => 'La pièce jointe ne doit pas dépasser 10 Mo.',
            'attachment.mimes' => 'Format de pièce jointe non supporté.',
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

        // Pièce jointe optionnelle → stockée sur le disque public.
        $attachmentPath = null;
        $attachmentName = null;
        if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
            $file = $request->file('attachment');
            $attachmentName = $file->getClientOriginalName();
            $safeName = Str::slug(pathinfo($attachmentName, PATHINFO_FILENAME)) ?: 'piece-jointe';
            $storedName = $safeName . '-' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $relativePath = $file->storeAs(
                'cms/contact-attachments/' . $etablissement->id,
                $storedName,
                'public'
            );
            // On sauvegarde l'URL complète (https://.../storage/...) en base.
            $attachmentPath = $relativePath
                ? url(Storage::disk('public')->url($relativePath))
                : null;
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
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
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

    /**
     * Demande de réservation ou de visite envoyée depuis la fiche d'un bien.
     *
     * Le template immobilier portait un formulaire qui se contentait
     * d'afficher « votre demande a bien été envoyée » : rien ne partait, et la
     * demande était perdue. Elle est désormais enregistrée et remonte dans
     * l'onglet « Immobilier » de l'espace entreprise.
     *
     * Le titre et la référence du bien sont RECOPIÉS dans la demande : un bien
     * retiré du site ne doit pas rendre illisibles les demandes déjà reçues.
     */
    public function submitPropertyRequest(Request $request, $etablissementId)
    {
        $donnees = $request->validate([
            'property_id'    => ['nullable', 'integer'],
            'name'           => ['required', 'string', 'max:190'],
            'email'          => ['required', 'email', 'max:190'],
            'phone'          => ['nullable', 'string', 'max:40'],
            'arrival_date'   => ['nullable', 'date'],
            // Le départ ne peut pas précéder l'arrivée ; `after_or_equal` et
            // non `after` : une visite se demande pour une seule journée.
            'departure_date' => ['nullable', 'date', 'after_or_equal:arrival_date'],
            'adults'         => ['nullable', 'integer', 'min:0', 'max:99'],
            'children'       => ['nullable', 'integer', 'min:0', 'max:99'],
            'message'        => ['nullable', 'string', 'max:2000'],
        ]);

        try {
            $etablissement = \App\Models\Etablissement::findOrFail($etablissementId);

            // Le bien doit appartenir à CET établissement : sans ce contrôle,
            // une demande pourrait être rattachée au bien d'une autre agence.
            $bien = null;
            if (! empty($donnees['property_id'])
                && class_exists(\Vendor\Cms\Models\Property::class)) {
                $bien = \Vendor\Cms\Models\Property::where('etablissement_id', $etablissement->id)
                    ->find($donnees['property_id']);
            }

            // Le calendrier grise déjà les nuits prises, mais il vit chez le
            // visiteur : on revérifie ici. Deux personnes peuvent demander les
            // mêmes dates à la même seconde, et rien n'empêche d'appeler ce
            // point d'entrée sans passer par la page.
            if ($bien
                && ! empty($donnees['arrival_date'])
                && ! empty($donnees['departure_date'])
                && class_exists(\Vendor\Cms\Models\PropertyBooking::class)
                && \Illuminate\Support\Facades\Schema::connection('cms')->hasTable('cms_property_bookings')) {

                $occupe = \Vendor\Cms\Models\PropertyBooking::pourBien($bien->id)
                    ->chevauchant($donnees['arrival_date'], $donnees['departure_date'])
                    ->exists();

                if ($occupe) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ces dates viennent d\'être réservées. Choisissez d\'autres nuits.',
                    ], 422);
                }
            }

            $demande = \Vendor\Cms\Models\PropertyRequest::create([
                'etablissement_id'   => $etablissement->id,
                'property_id'        => $bien?->id,
                'agent_id'           => $bien?->agent_id,
                'property_title'     => $bien?->title,
                'property_reference' => $bien?->reference,
                'name'               => $donnees['name'],
                'email'              => $donnees['email'],
                'phone'              => $donnees['phone'] ?? null,
                'arrival_date'       => $donnees['arrival_date'] ?? null,
                'departure_date'     => $donnees['departure_date'] ?? null,
                'adults'             => $donnees['adults'] ?? null,
                'children'           => $donnees['children'] ?? null,
                'message'            => $donnees['message'] ?? null,
                'status'             => \Vendor\Cms\Models\PropertyRequest::STATUT_NOUVEAU,
                'ip'                 => $request->ip(),
                'user_agent'         => substr((string) $request->userAgent(), 0, 255),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Votre demande a bien été envoyée.',
                'id'      => $demande->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Demande immobilière : ' . $e->getMessage(), [
                'etablissement_id' => $etablissementId,
            ]);

            return response()->json([
                'success' => false,
                'message' => "Votre demande n'a pas pu être enregistrée. Réessayez ou appelez-nous.",
            ], 500);
        }
    }


    /**
     * Nuits déjà prises d'un bien, pour le calendrier du site.
     *
     * On ne renvoie que les périodes qui ne sont pas entièrement passées : le
     * calendrier ne remonte pas dans le temps, et une agence qui loue depuis
     * des années n'a pas à charger tout son historique à chaque ouverture.
     *
     * Seules les dates sortent d'ici — jamais le nom du client ni le libellé
     * interne du blocage : c'est une page publique.
     */
    public function propertyAvailability(Request $request, $etablissementId, $propertyId)
    {
        try {
            $etablissement = \App\Models\Etablissement::findOrFail($etablissementId);

            $bien = \Vendor\Cms\Models\Property::where('etablissement_id', $etablissement->id)
                ->find($propertyId);

            if (! $bien) {
                return response()->json(['success' => true, 'periods' => []]);
            }

            if (! \Illuminate\Support\Facades\Schema::connection('cms')->hasTable('cms_property_bookings')) {
                return response()->json(['success' => true, 'periods' => []]);
            }

            $periodes = \Vendor\Cms\Models\PropertyBooking::pourBien($bien->id)
                ->aVenir()
                ->orderBy('start_date')
                ->limit(400)
                ->get()
                ->map(fn ($p) => [
                    'start' => $p->start_date->toDateString(),
                    'end'   => $p->end_date->toDateString(),
                ]);

            return response()->json([
                'success' => true,
                'periods' => $periodes,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Disponibilités du bien : ' . $e->getMessage());

            // Un calendrier sans période grisée vaut mieux qu'une fiche cassée.
            return response()->json(['success' => true, 'periods' => []]);
        }
    }

}
