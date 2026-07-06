<?php

namespace App\Http\Controllers;

use App\Models\DevisRequest;
use App\Models\BillingDiscount;
use App\Models\BillingRequest;
use App\Models\BillingRequestService;
use App\Models\BillingSetting;
use App\Models\Customer;
use App\Models\Etablissement;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\MapCategory;
use App\Models\MapPoint;
use App\Models\Plan;
use App\Models\Tax;
use App\Services\Payment\DevisPayPalCheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class DevisController extends Controller
{
    private const DEFAULT_CURRENCY = 'CAD';

    /**
     * Affiche le détail d'un service de devis (billing_request_services)
     */
    public function serviceDetail(BillingRequestService $billingRequestService): View
    {
        app()->setLocale('fr');
        session(['locale' => 'fr']);

        $mapPoints = MapPoint::with(['details', 'images', 'mainImage'])
            ->active()
            ->whereNotNull('adresse')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->orderBy('is_featured', 'desc')
            ->orderBy('views', 'desc')
            ->limit(500)
            ->get();

        $mapCategories = MapCategory::where('is_active', true)->orderBy('sort_order')->get(['slug', 'name', 'icon_class', 'color', 'image']);

        return view('home-v2.pages.service-detail', [
            'service' => $billingRequestService,
            'mapPoints' => $mapPoints,
            'mapCategories' => $mapCategories,
        ]);
    }

    /**
     * Affiche la page de demande de devis
     */
    public function show(Request $request): View
    {
        $plans = Plan::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'name', 'slug', 'description', 'icon', 'price', 'currency', 'billing_cycle']);

        $billingServices = $this->billingServicesCatalog();

        $activeTaxes = Tax::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->get(['id', 'name', 'code', 'rate']);

        $paypalMode = (string) config('paypal.mode', 'sandbox');
        $paypalClientId = (string) config('paypal.' . ($paypalMode === 'live' ? 'live' : 'sandbox') . '.client_id', '');

        return view('home-v2.pages.devis', [
            'plans' => $plans,
            'serviceSubjects' => $this->serviceSubjects(),
            'servicesCatalog' => $billingServices,
            'billingServices' => $billingServices,
            'activeTaxes' => $activeTaxes,
            'paypalClientId' => $paypalClientId,
            'paypalCurrency' => self::DEFAULT_CURRENCY,
        ]);
    }

    /**
     * Soumet une demande de devis
     */
    public function submit(Request $request, DevisPayPalCheckoutService $paypalCheckout): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'checkout_action' => ['nullable', 'in:request,pay_now'],
            'payment_method' => ['nullable', 'in:paypal,card'],
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['required', 'string', 'max:60'],
            'company' => ['nullable', 'string', 'max:180'],
            'city' => ['nullable', 'string', 'max:120'],
            'country' => ['nullable', 'string', 'max:120'],
            'client_address' => ['nullable', 'string', 'max:255'],
            'client_zipcode' => ['nullable', 'string', 'max:30'],
            'client_vat_number' => ['nullable', 'string', 'max:60'],
            'preferred_contact' => ['required', 'in:email,phone,whatsapp,zoom'],
            'service_quantities' => ['required', 'array', 'min:1'],
            'service_quantities.*' => ['nullable', 'integer', 'min:0', 'max:999'],
            'plan_interest' => ['nullable', 'string', 'max:180'],
            'budget' => ['nullable', 'string', 'max:120'],
            'project_deadline' => ['nullable', 'date'],
            'project_details' => ['nullable', 'string', 'min:10', 'max:4000'],
            'media_files' => ['nullable', 'array', 'max:10'],
            'media_files.*' => ['file', 'max:20480', 'mimes:jpg,jpeg,png,gif,webp,bmp,svg,pdf,csv,txt,xls,xlsx,ods,doc,docx,ppt,pptx,zip,rar'],
            'consent' => ['accepted'],
        ], [
            'service_quantities.required' => 'Veuillez sélectionner au moins un service.',
            'media_files.*.mimes' => 'Un ou plusieurs fichiers ont un format non autorisé.',
            'media_files.*.max' => 'Chaque fichier doit faire moins de 20 Mo.',
            'consent.accepted' => 'Veuillez accepter la politique de confidentialité.',
        ]);

        $validated['service_subject'] = 'Demande de devis services';
        $checkoutAction = $validated['checkout_action'] ?? 'request';
        $validated['project_details'] = $validated['project_details'] ?? null;

        $selectedQuantities = collect($validated['service_quantities'] ?? [])
            ->mapWithKeys(fn ($quantity, $serviceId) => [(int) $serviceId => max(0, (int) $quantity)])
            ->filter(fn (int $quantity) => $quantity > 0);

        if ($selectedQuantities->isEmpty()) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Veuillez sélectionner au moins un service avec une quantité supérieure à zéro.'], 422);
            }
            return back()
                ->withErrors(['service_quantities' => 'Veuillez sélectionner au moins un service avec une quantité supérieure à zéro.'])
                ->withInput();
        }

        $selectedServices = BillingRequestService::query()
            ->with('tax')
            ->active()
            ->whereIn('id', $selectedQuantities->keys()->all())
            ->get()
            ->keyBy('id');

        if ($selectedServices->count() !== $selectedQuantities->count()) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Un ou plusieurs services sélectionnés ne sont plus disponibles.'], 422);
            }
            return back()
                ->withErrors(['service_quantities' => 'Un ou plusieurs services sélectionnés ne sont plus disponibles.'])
                ->withInput();
        }

        $selectedServiceLabels = $selectedServices
            ->map(fn (BillingRequestService $service) => $service->title . ' x' . $selectedQuantities->get($service->id, 1))
            ->values()
            ->all();

        $validated['selected_services'] = $selectedServiceLabels;

        $storedMedia = $this->handleMediaFiles($request);

        $billingRequests = collect();

        DB::transaction(function () use ($validated, $request, $selectedServices, $selectedQuantities, $selectedServiceLabels, &$billingRequests): void {
            $billingRequests = $this->createBillingRequestsFromServices($validated, $request, $selectedServices, $selectedQuantities, $selectedServiceLabels);
        });

        $devisRequest = $this->createDevisRequest($validated, $request, $storedMedia);

        $this->sendDevisEmail($devisRequest, $validated, $storedMedia, $billingRequests);

        // Génère la facture et l'envoie au client par email.
        $this->sendClientInvoiceEmail($validated, $billingRequests);

        if ($checkoutAction === 'pay_now') {
            $paymentMethod = ($validated['payment_method'] ?? 'paypal') === 'card' ? 'card' : 'paypal';
            if ($request->wantsJson()) {
                return $this->handlePayPalPaymentJson($billingRequests, $devisRequest, $paymentMethod);
            }
            return $this->handlePayPalPayment($billingRequests, $devisRequest, $paymentMethod);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => 'Votre facture a bien été générée et envoyée à votre adresse email. Notre équipe vous répondra rapidement.']);
        }

        return redirect()
            ->route('devis')
            ->with('success', 'Votre facture a bien été générée et envoyée à votre adresse email. Notre équipe vous répondra rapidement.');
    }

    /**
     * Gère le succès du paiement PayPal
     */
    public function paypalSuccess(Request $request, DevisPayPalCheckoutService $paypalCheckout): RedirectResponse
    {
        $paypalOrderId = (string) $request->query('token', $request->query('order_id', ''));

        try {
            $result = $paypalCheckout->captureCheckout($paypalOrderId);
            $message = $result['receipt_sent']
                ? 'Paiement confirmé avec succès. Votre reçu a été envoyé par email.'
                : 'Paiement confirmé avec succès. Le reçu sera envoyé par notre équipe.';

            return redirect()->route('devis')->with('success', $message);
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('devis')
                ->with('error', 'Nous n\'avons pas pu confirmer le paiement PayPal. Si le montant a été débité, contactez notre équipe avec votre référence PayPal.');
        }
    }

    /**
     * Gère l'annulation du paiement PayPal
     */
    public function paypalCancel(Request $request, DevisPayPalCheckoutService $paypalCheckout): RedirectResponse
    {
        $paypalCheckout->cancelCheckout((string) $request->query('token', ''));

        return redirect()
            ->route('devis')
            ->with('error', 'Paiement PayPal annulé. Votre demande de devis reste enregistrée.');
    }

    /**
     * Catalogue des services de facturation
     */
    private function billingServicesCatalog(): Collection
    {
        return BillingRequestService::query()
            ->with('tax')
            ->active()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get()
            ->map(function (BillingRequestService $service): array {
                $defaultSettings = $this->getDefaultBillingSettings();
                $taxRate = $this->serviceTaxRate($service, $defaultSettings);
                $discountRule = $this->discountRuleFor($defaultSettings);
                $taxComponents = $this->serviceTaxComponents($service, $defaultSettings);
                $defaultTaxComponents = $this->defaultTaxComponents($defaultSettings);

                return [
                    'id' => (int) $service->id,
                    'title' => (string) $service->title,
                    'description' => (string) ($service->description ?? ''),
                    'image_url' => $this->resolveServiceImageUrl($service->image_url),
                    'unit_price' => (float) $service->unit_price,
                    'tax_rate' => $taxRate,
                    'tax_components' => $taxComponents,
                    'default_tax_components' => $defaultTaxComponents,
                    'billing_unit' => (string) ($service->billing_unit ?: 'forfait'),
                    'is_featured' => (bool) $service->is_featured,
                    'discount' => $discountRule,
                    'discount_percentage' => $discountRule['type'] === 'percentage' ? (float) $discountRule['value'] : 0.0,
                    'shipping_fees' => (float) ($defaultSettings['default_shipping_fees'] ?? 0),
                    'administration_fees' => (float) ($defaultSettings['default_administration_fees'] ?? 0),
                    'fees_tax_rate' => $this->serviceTaxRateFromComponents($defaultTaxComponents),
                    'fees_tax_components' => $defaultTaxComponents,
                    'currency' => (string) ($defaultSettings['currency'] ?? self::DEFAULT_CURRENCY),
                ];
            });
    }

    /**
     * Crée les demandes de facturation à partir des services sélectionnés
     */
    private function createBillingRequestsFromServices(
        array $validated,
        Request $request,
        Collection $selectedServices,
        Collection $selectedQuantities,
        array $selectedServiceLabels
    ): Collection {
        $defaultSettings = $this->getDefaultBillingSettings();
        $discountRule = $this->discountRuleFor($defaultSettings);
        
        // Calcul du total brut des services
        $serviceGrossTotal = $selectedServices->sum(function (BillingRequestService $service) use ($selectedQuantities): float {
            return round((float) $service->unit_price * (int) $selectedQuantities->get($service->id, 1), 2);
        });
        
        $requestDiscountAmount = $this->discountAmountFor($serviceGrossTotal, $discountRule);
        $taxesBreakdown = [];
        $subtotal = 0.0;
        $taxTotal = 0.0;
        $linePayloads = [];

        // Création des lignes pour chaque service
        foreach ($selectedServices->values() as $index => $service) {
            $quantity = (int) $selectedQuantities->get($service->id, 1);
            $unitPrice = round((float) $service->unit_price, 2);
            $grossSubtotal = round($unitPrice * $quantity, 2);
            $discountAmount = $serviceGrossTotal > 0
                ? round($requestDiscountAmount * ($grossSubtotal / $serviceGrossTotal), 2)
                : 0.0;
            $lineSubtotal = round($grossSubtotal - $discountAmount, 2);
            
            $taxComponents = $this->serviceTaxComponents($service, $defaultSettings);
            $taxRate = round(array_sum(array_column($taxComponents, 'rate')), 3);
            $taxAmount = round($lineSubtotal * ($taxRate / 100), 2);
            $lineTotal = round($lineSubtotal + $taxAmount, 2);

            // Agrégation des taxes
            foreach ($taxComponents as $component) {
                $code = $component['code'];
                $amount = round($lineSubtotal * (((float) $component['rate']) / 100), 2);
                $taxesBreakdown[$code] ??= [
                    'name' => $component['name'],
                    'code' => $code,
                    'rate' => (float) $component['rate'],
                    'amount' => 0.0,
                ];
                $taxesBreakdown[$code]['amount'] = round($taxesBreakdown[$code]['amount'] + $amount, 2);
            }

            $subtotal = round($subtotal + $lineSubtotal, 2);
            $taxTotal = round($taxTotal + $taxAmount, 2);
            
            $linePayloads[] = [
                'billing_request_id' => null,
                'billing_request_service_id' => $service->id,
                'line_number' => $index + 1,
                'title' => $service->title,
                'description' => $service->description,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $lineSubtotal,
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'total' => $lineTotal,
                'metadata' => [
                    'billing_unit' => $service->billing_unit,
                    'image_url' => $service->image_url,
                    'gross_subtotal' => $grossSubtotal,
                    'discount_rule' => $discountRule,
                    'discount_amount' => $discountAmount,
                    'tax_components' => $taxComponents,
                ],
            ];
        }

        // Ajout des frais supplémentaires
        foreach ($this->billingFeeLines($defaultSettings) as $feeLine) {
            $taxComponents = $this->defaultTaxComponents($defaultSettings);
            $taxRate = round(array_sum(array_column($taxComponents, 'rate')), 3);
            $lineSubtotal = round((float) $feeLine['amount'], 2);
            $taxAmount = round($lineSubtotal * ($taxRate / 100), 2);
            $lineTotal = round($lineSubtotal + $taxAmount, 2);

            foreach ($taxComponents as $component) {
                $code = $component['code'];
                $amount = round($lineSubtotal * (((float) $component['rate']) / 100), 2);
                $taxesBreakdown[$code] ??= [
                    'name' => $component['name'],
                    'code' => $code,
                    'rate' => (float) $component['rate'],
                    'amount' => 0.0,
                ];
                $taxesBreakdown[$code]['amount'] = round($taxesBreakdown[$code]['amount'] + $amount, 2);
            }

            $subtotal = round($subtotal + $lineSubtotal, 2);
            $taxTotal = round($taxTotal + $taxAmount, 2);
            
            $linePayloads[] = [
                'billing_request_id' => null,
                'billing_request_service_id' => null,
                'line_number' => count($linePayloads) + 1,
                'title' => $feeLine['title'],
                'description' => $feeLine['description'],
                'quantity' => 1,
                'unit_price' => $lineSubtotal,
                'subtotal' => $lineSubtotal,
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'total' => $lineTotal,
                'metadata' => [
                    'type' => $feeLine['type'],
                    'tax_components' => $taxComponents,
                ],
            ];
        }

        // Création du BillingRequest
        $billingRequest = BillingRequest::create([
            'status' => 'new',
            'name' => trim(($validated['first_name'] ?? '') . ' ' . ($validated['last_name'] ?? '')),
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'company' => $validated['company'] ?? null,
            'city' => $validated['city'] ?? null,
            'country' => $validated['country'] ?? null,
            'message' => $validated['project_details'] ?? null,
            'subtotal' => $subtotal,
            'tax_total' => $taxTotal,
            'total' => round($subtotal + $taxTotal, 2),
            'taxes_breakdown' => array_values($taxesBreakdown),
            'metadata' => [
                'source' => 'devis_page',
                'service_subject' => $validated['service_subject'],
                'selected_services' => $selectedServiceLabels,
                'preferred_contact' => $validated['preferred_contact'],
                'plan_interest' => $validated['plan_interest'] ?? null,
                'budget' => $validated['budget'] ?? null,
                'project_deadline' => $validated['project_deadline'] ?? null,
                'discount_rule' => $discountRule,
                'discount_amount' => $requestDiscountAmount,
                'default_shipping_fees' => (float) ($defaultSettings['default_shipping_fees'] ?? 0),
                'default_administration_fees' => (float) ($defaultSettings['default_administration_fees'] ?? 0),
                'currency' => (string) ($defaultSettings['currency'] ?? self::DEFAULT_CURRENCY),
                'client_ip' => $request->ip(),
                'user_agent' => (string) $request->userAgent(),
                'source_url' => (string) $request->headers->get('referer', ''),
            ],
        ]);

        // Mise à jour des items avec le billing_request_id
        foreach ($linePayloads as &$linePayload) {
            $linePayload['billing_request_id'] = $billingRequest->id;
        }

        // Création des items
        $billingRequest->items()->createMany($linePayloads);

        return collect([$billingRequest->load('items')]);
    }

    /**
     * Récupère les paramètres de facturation par défaut
     */
    private function getDefaultBillingSettings(): array
    {
        $settings = BillingSetting::first();
        
        if ($settings) {
            return [
                'default_shipping_fees' => (float) ($settings->default_shipping_fees ?? 0),
                'default_administration_fees' => (float) ($settings->default_administration_fees ?? 0),
                'default_discount_percentage' => (float) ($settings->default_discount_percentage ?? 0),
                'default_discount_id' => $settings->default_discount_id,
                'default_tax_ids' => $settings->default_tax_ids ?? [],
                'currency' => $settings->currency ?? self::DEFAULT_CURRENCY,
            ];
        }

        return [
            'default_shipping_fees' => 0.0,
            'default_administration_fees' => 0.0,
            'default_discount_percentage' => 0.0,
            'default_discount_id' => null,
            'default_tax_ids' => [],
            'currency' => self::DEFAULT_CURRENCY,
        ];
    }

    /**
     * Calcule le taux de taxe pour un service
     */
    private function serviceTaxRate(BillingRequestService $service, array $defaultSettings): float
    {
        return $this->serviceTaxRateFromComponents($this->serviceTaxComponents($service, $defaultSettings));
    }

    /**
     * Calcule le taux de taxe à partir des composants
     */
    private function serviceTaxRateFromComponents(array $components): float
    {
        return round(array_sum(array_column($components, 'rate')), 3);
    }

    /**
     * Récupère les composants de taxe pour un service
     */
    private function serviceTaxComponents(BillingRequestService $service, array $defaultSettings): array
    {
        // Priorité 1: Taxe liée au service
        if ($service->tax && $service->tax->is_active) {
            return [[
                'name' => (string) $service->tax->name,
                'code' => (string) $service->tax->code,
                'rate' => (float) $service->tax->rate,
            ]];
        }

        // Priorité 2: Taux de taxe numérique du service
        if ((float) $service->tax_rate > 0) {
            return [[
                'name' => optional($service->tax)->name ?: 'Taxe',
                'code' => optional($service->tax)->code ?: 'TAX',
                'rate' => (float) $service->tax_rate,
            ]];
        }

        // Priorité 3: Taxes par défaut
        return $this->defaultTaxComponents($defaultSettings);
    }

    /**
     * Récupère les composants de taxe par défaut
     */
    private function defaultTaxComponents(array $defaultSettings): array
    {
        $defaultTaxIds = collect($defaultSettings['default_tax_ids'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->values();

        if ($defaultTaxIds->isNotEmpty()) {
            return $this->taxComponentsFromIds($defaultTaxIds);
        }

        return $this->activeTaxComponents();
    }

    /**
     * Récupère les composants de taxe à partir des IDs
     */
    private function taxComponentsFromIds(Collection $taxIds): array
    {
        if ($taxIds->isEmpty()) {
            return [];
        }

        return Tax::query()
            ->whereIn('id', $taxIds->all())
            ->where('is_active', true)
            ->orderBy('id')
            ->get()
            ->map(fn (Tax $tax) => [
                'name' => (string) $tax->name,
                'code' => (string) $tax->code,
                'rate' => (float) $tax->rate,
            ])
            ->all();
    }

    /**
     * Récupère les taxes actives
     */
    private function activeTaxComponents(): array
    {
        return Tax::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->get(['name', 'code', 'rate'])
            ->map(fn (Tax $tax) => [
                'name' => (string) $tax->name,
                'code' => (string) $tax->code,
                'rate' => (float) $tax->rate,
            ])
            ->all();
    }

    /**
     * Détermine la règle de réduction
     */
    private function discountRuleFor(array $defaultSettings): array
    {
        $discount = null;

        // Priorité 1: Réduction par défaut définie dans les paramètres
        if (!empty($defaultSettings['default_discount_id'])) {
            $discount = BillingDiscount::query()
                ->active()
                ->where('id', $defaultSettings['default_discount_id'])
                ->first();
        }

        // Priorité 2: Réduction globale par défaut
        if (!$discount) {
            $discount = BillingDiscount::query()
                ->active()
                ->where('is_default', true)
                ->orderByDesc('id')
                ->first();
        }

        if ($discount) {
            return [
                'id' => (int) $discount->id,
                'name' => (string) $discount->name,
                'code' => (string) ($discount->code ?: ''),
                'type' => $discount->type === 'fixed' ? 'fixed' : 'percentage',
                'value' => (float) $discount->value,
                'source' => 'billing_discounts',
            ];
        }

        // Fallback: Pourcentage de réduction legacy
        $legacyPercentage = (float) ($defaultSettings['default_discount_percentage'] ?? 0);

        return [
            'id' => null,
            'name' => $legacyPercentage > 0 ? 'Remise par défaut' : '',
            'code' => '',
            'type' => 'percentage',
            'value' => max(0, min(100, $legacyPercentage)),
            'source' => 'billing_settings',
        ];
    }

    /**
     * Calcule le montant de la réduction
     */
    private function discountAmountFor(float $amount, array $discountRule): float
    {
        $value = max(0, (float) ($discountRule['value'] ?? 0));

        if ($amount <= 0 || $value <= 0) {
            return 0.0;
        }

        if (($discountRule['type'] ?? 'percentage') === 'fixed') {
            return round(min($amount, $value), 2);
        }

        return round($amount * (min(100, $value) / 100), 2);
    }

    /**
     * Récupère les lignes de frais supplémentaires
     */
    private function billingFeeLines(array $defaultSettings): array
    {
        $lines = [];
        $shipping = (float) ($defaultSettings['default_shipping_fees'] ?? 0);
        $administration = (float) ($defaultSettings['default_administration_fees'] ?? 0);

        if ($shipping > 0) {
            $lines[] = [
                'type' => 'shipping',
                'title' => 'Frais de livraison',
                'description' => 'Frais de livraison par défaut',
                'amount' => $shipping,
            ];
        }

        if ($administration > 0) {
            $lines[] = [
                'type' => 'administration',
                'title' => 'Frais administratifs',
                'description' => 'Frais administratifs par défaut',
                'amount' => $administration,
            ];
        }

        return $lines;
    }

    /**
     * Résout l'URL de l'image du service
     */
    private function resolveServiceImageUrl(?string $imageUrl): ?string
    {
        $imageUrl = trim((string) $imageUrl);

        if ($imageUrl === '') {
            return null;
        }

        if (Str::startsWith($imageUrl, ['http://', 'https://', '/'])) {
            return $imageUrl;
        }

        return Storage::disk('public')->url($imageUrl);
    }

    /**
     * Gère les fichiers médias uploadés
     */
    private function handleMediaFiles(Request $request): array
    {
        $storedMedia = [];

        if ($request->hasFile('media_files')) {
            foreach ((array) $request->file('media_files') as $file) {
                if (!$file || !$file->isValid()) {
                    continue;
                }

                $originalName = (string) $file->getClientOriginalName();
                $safeOriginal = preg_replace('/[^A-Za-z0-9._-]/', '-', $originalName) ?: 'media-file';
                $storedPath = $file->storeAs(
                    'devis-media/' . now()->format('Y/m'),
                    Str::uuid() . '-' . $safeOriginal,
                    'public'
                );

                if (!$storedPath) {
                    continue;
                }

                $storedMedia[] = [
                    'original_name' => $originalName,
                    'stored_path' => $storedPath,
                    'url' => Storage::disk('public')->url($storedPath),
                    'size' => (int) $file->getSize(),
                    'mime' => (string) $file->getClientMimeType(),
                    'extension' => (string) $file->getClientOriginalExtension(),
                ];
            }
        }

        return $storedMedia;
    }

    /**
     * Crée une demande de devis
     */
    private function createDevisRequest(array $validated, Request $request, array $storedMedia): DevisRequest
    {
        return DevisRequest::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company'] ?? null,
            'city' => $validated['city'] ?? null,
            'country' => $validated['country'] ?? null,
            'preferred_contact' => $validated['preferred_contact'],
            'service_subject' => $validated['service_subject'],
            'selected_services' => $validated['selected_services'],
            'plan_interest' => $validated['plan_interest'] ?? null,
            'budget' => $validated['budget'] ?? null,
            'project_deadline' => $validated['project_deadline'] ?? null,
            'project_details' => $validated['project_details'] ?? '',
            'media_files' => $storedMedia,
            'email_sent' => false,
            'email_error' => null,
            'client_ip' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
            'source_url' => (string) $request->headers->get('referer', ''),
        ]);
    }

    /**
     * Envoie l'email de demande de devis
     */
    private function sendDevisEmail(DevisRequest $devisRequest, array $validated, array $storedMedia, Collection $billingRequests): void
    {
        try {
            Mail::send('emails.devis-request', [
                'data' => $validated,
                'submittedAt' => now(),
                'mediaFiles' => $storedMedia,
                'billingRequests' => $billingRequests,
            ], function ($message) use ($validated, $storedMedia): void {
                $fullName = trim(($validated['first_name'] ?? '') . ' ' . ($validated['last_name'] ?? ''));
                $message->to('infogoexploria@gmail.com')
                    ->cc('wahidfkiri5@gmail.com')
                    ->subject('Nouvelle demande de facture - ' . ($fullName !== '' ? $fullName : 'Client'))
                    ->replyTo($validated['email'], $fullName !== '' ? $fullName : null);

                foreach ($storedMedia as $media) {
                    $path = Storage::disk('public')->path($media['stored_path'] ?? '');
                    if (!is_file($path)) {
                        continue;
                    }

                    $message->attach($path, [
                        'as' => $media['original_name'] ?? basename($path),
                        'mime' => $media['mime'] ?? null,
                    ]);
                }
            });

            $devisRequest->update([
                'email_sent' => true,
                'email_error' => null,
            ]);
        } catch (Throwable $e) {
            report($e);
            $devisRequest->update([
                'email_sent' => false,
                'email_error' => Str::limit((string) $e->getMessage(), 2000, ''),
            ]);
        }
    }

    /**
     * Génère la facture à partir de la demande de facturation et l'envoie
     * au client par email (avec copie à l'équipe). Non bloquant.
     */
    private function sendClientInvoiceEmail(array $validated, Collection $billingRequests): void
    {
        try {
            $billingRequest = $billingRequests->first();
            $clientEmail = $validated['email'] ?? null;

            if (! $billingRequest || ! $clientEmail) {
                return;
            }

            $fullName = trim(($validated['first_name'] ?? '') . ' ' . ($validated['last_name'] ?? ''));
            $fullName = $fullName !== '' ? $fullName : 'Client';
            $currency = (string) data_get($billingRequest->metadata, 'currency', self::DEFAULT_CURRENCY);
            $issuedAt = now();
            $dueAt = now()->addDays(3);
            $invoiceNumber = 'FAC-' . $issuedAt->format('Ymd') . '-' . str_pad((string) $billingRequest->id, 5, '0', STR_PAD_LEFT);

            // Enregistre la facture en base (non bloquant). Si l'insertion réussit,
            // on réutilise son numéro officiel.
            $invoice = $this->persistInvoice($invoiceNumber, $validated, $billingRequest, $issuedAt, $dueAt);
            if ($invoice && $invoice->invoice_number) {
                $invoiceNumber = $invoice->invoice_number;
            }

            $viewData = [
                'invoiceNumber' => $invoiceNumber,
                'client' => $validated,
                'fullName' => $fullName,
                'billingRequest' => $billingRequest,
                'items' => $billingRequest->items,
                'currency' => $currency,
                'issuedAt' => $issuedAt,
                'dueAt' => $dueAt,
            ];

            // Génère le PDF de la facture (non bloquant).
            $pdfData = null;
            try {
                $pdfData = Pdf::loadView('pdf.invoice', $viewData)->output();
            } catch (Throwable $e) {
                report($e);
            }

            Mail::send('emails.invoice-client', $viewData, function ($message) use ($clientEmail, $fullName, $invoiceNumber, $pdfData): void {
                $message->to($clientEmail, $fullName)
                    ->cc('infogoexploria@gmail.com')
                    ->subject('Votre facture ' . $invoiceNumber . ' - Go Exploria Business');

                if ($pdfData !== null) {
                    $message->attachData($pdfData, 'facture-' . $invoiceNumber . '.pdf', ['mime' => 'application/pdf']);
                }
            });
        } catch (Throwable $e) {
            report($e);
        }
    }

    /**
     * Enregistre la facture (Invoice + InvoiceLine) en base. Non bloquant :
     * en cas d'échec (contraintes, établissement manquant…) on renvoie null
     * et l'email/PDF partent quand même.
     */
    private function persistInvoice(string $invoiceNumber, array $validated, BillingRequest $billingRequest, $issuedAt, $dueAt): ?Invoice
    {
        try {
            $etablissementId = (int) (env('DEVIS_INVOICE_ETABLISSEMENT_ID') ?: 0);
            if ($etablissementId <= 0) {
                $etablissementId = (int) (optional(Etablissement::query()->orderBy('id')->first())->id ?? 0);
            }
            if ($etablissementId <= 0) {
                return null;
            }

            // Client (customer) : recherche par email, création sinon.
            $customer = Customer::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'etablissement_id' => $etablissementId,
                    'type' => 'particulier',
                    'prenom' => $validated['first_name'] ?? null,
                    'nom' => $validated['last_name'] ?? null,
                    'telephone' => $validated['phone'] ?? null,
                    'entreprise_nom' => $validated['company'] ?? null,
                    'no_tva' => $validated['client_vat_number'] ?? null,
                    'adresse' => $validated['client_address'] ?? null,
                    'code_postal' => $validated['client_zipcode'] ?? null,
                    'ville' => $validated['city'] ?? null,
                    'pays' => $validated['country'] ?? null,
                ]
            );

            $fullName = trim(($validated['first_name'] ?? '') . ' ' . ($validated['last_name'] ?? ''));

            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'etablissement_id' => $etablissementId,
                'client_id' => $customer->id,
                'invoice_date' => $issuedAt->toDateString(),
                'due_date' => $dueAt->toDateString(),
                'subtotal' => $billingRequest->subtotal,
                'tax_total' => $billingRequest->tax_total,
                'total' => $billingRequest->total,
                'paid_amount' => 0,
                'remaining_amount' => $billingRequest->total,
                'taxes_breakdown' => $billingRequest->taxes_breakdown,
                'status' => 'envoyee',
                'client_name' => $fullName !== '' ? $fullName : ($validated['company'] ?? 'Client'),
                'client_address' => $validated['client_address'] ?? null,
                'client_zipcode' => $validated['client_zipcode'] ?? null,
                'client_city' => $validated['city'] ?? null,
                'client_country' => $validated['country'] ?? null,
                'client_vat_number' => $validated['client_vat_number'] ?? null,
                'footer' => 'Merci pour votre confiance — Go Exploria Business',
                'metadata' => [
                    'source' => 'devis_page',
                    'client_email' => $validated['email'] ?? null,
                    'client_phone' => $validated['phone'] ?? null,
                    'company' => $validated['company'] ?? null,
                    'billing_request_id' => $billingRequest->id,
                ],
            ]);

            foreach ($billingRequest->items as $index => $item) {
                InvoiceLine::create([
                    'invoice_id' => $invoice->id,
                    'line_number' => $index + 1,
                    'description' => $item->title,
                    'detailed_description' => $item->description,
                    'type' => 'service',
                    'quantity' => (int) $item->quantity,
                    'unit_price' => $item->unit_price,
                    'subtotal' => $item->subtotal,
                    'tax_rate' => $item->tax_rate,
                    'tax_amount' => $item->tax_amount,
                    'total' => $item->total,
                ]);
            }

            return $invoice;
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    /**
     * Gère le paiement PayPal
     */
    private function handlePayPalPayment(Collection $billingRequests, DevisRequest $devisRequest, string $paymentMethod = 'paypal'): RedirectResponse
    {
        try {
            $paypalCheckout = app(DevisPayPalCheckoutService::class);
            $approvalUrl = $paypalCheckout->createCheckout($billingRequests, $devisRequest, $paymentMethod);

            return redirect()->away($approvalUrl);
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('devis')
                ->with('error', 'Votre demande a été enregistrée, mais le paiement PayPal n\'a pas pu démarrer. Notre équipe vous contactera rapidement.');
        }
    }

    /**
     * Capture d'un ordre PayPal créé via les Smart Buttons (SDK JS).
     * L'ordre a été créé par submit() (checkout_action=pay_now) ; ici on le capture.
     */
    public function paypalCaptureOrder(Request $request, DevisPayPalCheckoutService $paypalCheckout): JsonResponse
    {
        $orderId = trim((string) ($request->input('orderID') ?? $request->input('order_id') ?? ''));

        if ($orderId === '') {
            return response()->json(['error' => 'Identifiant de commande PayPal manquant.'], 422);
        }

        try {
            $paypalCheckout->captureCheckout($orderId);

            return response()->json([
                'success' => 'Paiement confirmé, merci ! Votre facture vous a été envoyée par email.',
            ]);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'error' => "Le paiement n'a pas pu être confirmé. Veuillez réessayer ou nous contacter.",
            ], 500);
        }
    }

    private function handlePayPalPaymentJson(Collection $billingRequests, DevisRequest $devisRequest, string $paymentMethod = 'paypal'): JsonResponse
    {
        try {
            $paypalCheckout = app(DevisPayPalCheckoutService::class);
            $approvalUrl = $paypalCheckout->createCheckout($billingRequests, $devisRequest, $paymentMethod);

            return response()->json(['paypal_url' => $approvalUrl]);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'error' => 'Votre demande a été enregistrée, mais le paiement PayPal n\'a pas pu démarrer. Notre équipe vous contactera rapidement.',
            ], 500);
        }
    }

    /**
     * @return array<int, string>
     */
    private function serviceSubjects(): array
    {
        return [
            'Création de site web',
            'Refonte de site existant',
            'SEO et visibilité',
            'Marketing digital',
            'Espace destination',
            'Espace entreprise',
            'Espace médias',
            'Plan Next Level',
            'Autre demande',
        ];
    }
}