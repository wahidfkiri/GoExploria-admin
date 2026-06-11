<?php

namespace App\Http\Controllers;

use App\Models\DevisRequest;
use App\Models\BillingRequest;
use App\Models\BillingRequestService;
use App\Models\BillingSetting;
use App\Models\Plan;
use App\Models\Tax;
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
    public function show(Request $request): View
    {
        $plans = Plan::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'name', 'slug', 'description', 'icon', 'price', 'currency', 'billing_cycle']);

        $billingServices = $this->billingServicesCatalog($request->integer('etablissement_id') ?: null);

        return view('home-v2.pages.devis', [
            'plans' => $plans,
            'serviceSubjects' => $this->serviceSubjects(),
            'servicesCatalog' => $billingServices,
            'billingServices' => $billingServices,
        ]);
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'etablissement_id' => ['nullable', 'integer', 'exists:etablissements,id'],
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['required', 'string', 'max:60'],
            'company' => ['nullable', 'string', 'max:180'],
            'city' => ['nullable', 'string', 'max:120'],
            'country' => ['nullable', 'string', 'max:120'],
            'preferred_contact' => ['required', 'in:email,phone,whatsapp,zoom'],
            'service_subject' => ['required', 'string', 'max:160'],
            'service_quantities' => ['required', 'array', 'min:1'],
            'service_quantities.*' => ['nullable', 'integer', 'min:0', 'max:999'],
            'plan_interest' => ['nullable', 'string', 'max:180'],
            'budget' => ['nullable', 'string', 'max:120'],
            'project_deadline' => ['nullable', 'date'],
            'project_details' => ['required', 'string', 'min:10', 'max:4000'],
            'media_files' => ['nullable', 'array', 'max:10'],
            'media_files.*' => ['file', 'max:20480', 'mimes:jpg,jpeg,png,gif,webp,bmp,svg,pdf,csv,txt,xls,xlsx,ods,doc,docx,ppt,pptx,zip,rar'],
            'consent' => ['accepted'],
        ], [
            'service_quantities.required' => 'Veuillez selectionner au moins un service.',
            'media_files.*.mimes' => 'Un ou plusieurs fichiers ont un format non autorise.',
            'media_files.*.max' => 'Chaque fichier doit faire moins de 20 Mo.',
            'consent.accepted' => 'Veuillez accepter la politique de confidentialite.',
        ]);

        $selectedQuantities = collect($validated['service_quantities'] ?? [])
            ->mapWithKeys(fn ($quantity, $serviceId) => [(int) $serviceId => max(0, (int) $quantity)])
            ->filter(fn (int $quantity) => $quantity > 0);

        if ($selectedQuantities->isEmpty()) {
            return back()
                ->withErrors(['service_quantities' => 'Veuillez selectionner au moins un service avec une quantite superieure a zero.'])
                ->withInput();
        }

        $selectedServices = BillingRequestService::query()
            ->with('tax')
            ->active()
            ->whereIn('id', $selectedQuantities->keys()->all())
            ->get()
            ->keyBy('id');

        if ($selectedServices->count() !== $selectedQuantities->count()) {
            return back()
                ->withErrors(['service_quantities' => 'Un ou plusieurs services selectionnes ne sont plus disponibles.'])
                ->withInput();
        }

        $selectedServiceLabels = $selectedServices
            ->map(fn (BillingRequestService $service) => $service->title . ' x' . $selectedQuantities->get($service->id, 1))
            ->values()
            ->all();

        $validated['selected_services'] = $selectedServiceLabels;

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

        $billingRequests = collect();

        DB::transaction(function () use ($validated, $request, $selectedServices, $selectedQuantities, $selectedServiceLabels, &$billingRequests): void {
            $billingRequests = $this->createBillingRequestsFromServices($validated, $request, $selectedServices, $selectedQuantities, $selectedServiceLabels);
        });

        $devisRequest = DevisRequest::create([
            'etablissement_id' => $validated['etablissement_id'] ?? null,
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
            'project_details' => $validated['project_details'],
            'media_files' => $storedMedia,
            'email_sent' => false,
            'email_error' => null,
            'client_ip' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
            'source_url' => (string) $request->headers->get('referer', ''),
        ]);

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
                    ->subject('Nouvelle demande de devis - ' . ($fullName !== '' ? $fullName : 'Client'))
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

        return redirect()
            ->route('devis')
            ->with('success', 'Votre demande de devis a bien ete enregistree et envoyee. Notre equipe vous repondra rapidement.');
    }

    private function billingServicesCatalog(?int $etablissementId = null): Collection
    {
        return BillingRequestService::query()
            ->with(['tax', 'etablissement:id,name'])
            ->active()
            ->when($etablissementId, fn ($query) => $query->where('etablissement_id', $etablissementId))
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get()
            ->map(function (BillingRequestService $service): array {
                $taxRate = $this->serviceTaxRate($service, $this->billingSettingFor((int) $service->etablissement_id));

                return [
                    'id' => (int) $service->id,
                    'etablissement_id' => (int) $service->etablissement_id,
                    'etablissement_name' => (string) optional($service->etablissement)->name,
                    'title' => (string) $service->title,
                    'description' => (string) ($service->description ?? ''),
                    'image_url' => $this->resolveServiceImageUrl($service->image_url),
                    'unit_price' => (float) $service->unit_price,
                    'tax_rate' => $taxRate,
                    'billing_unit' => (string) ($service->billing_unit ?: 'forfait'),
                    'is_featured' => (bool) $service->is_featured,
                    'discount_percentage' => (float) ($this->billingSettingFor((int) $service->etablissement_id)?->default_discount_percentage ?? 0),
                ];
            });
    }

    private function createBillingRequestsFromServices(array $validated, Request $request, Collection $selectedServices, Collection $selectedQuantities, array $selectedServiceLabels): Collection
    {
        return $selectedServices
            ->groupBy('etablissement_id')
            ->map(function (Collection $services, int $etablissementId) use ($validated, $request, $selectedQuantities, $selectedServiceLabels): BillingRequest {
                $setting = $this->billingSettingFor($etablissementId);
                $discountPercentage = max(0, min(100, (float) ($setting?->default_discount_percentage ?? 0)));
                $taxesBreakdown = [];
                $subtotal = 0.0;
                $taxTotal = 0.0;
                $linePayloads = [];

                foreach ($services->values() as $index => $service) {
                    $quantity = (int) $selectedQuantities->get($service->id, 1);
                    $unitPrice = round((float) $service->unit_price, 2);
                    $grossSubtotal = round($unitPrice * $quantity, 2);
                    $discountAmount = round($grossSubtotal * ($discountPercentage / 100), 2);
                    $lineSubtotal = round($grossSubtotal - $discountAmount, 2);
                    $taxComponents = $this->serviceTaxComponents($service, $setting);
                    $taxRate = round(array_sum(array_column($taxComponents, 'rate')), 3);
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
                            'discount_percentage' => $discountPercentage,
                            'discount_amount' => $discountAmount,
                            'tax_components' => $taxComponents,
                        ],
                    ];
                }

                $billingRequest = BillingRequest::create([
                    'etablissement_id' => $etablissementId,
                    'client_etablissement_id' => $validated['etablissement_id'] ?? null,
                    'status' => 'new',
                    'name' => trim(($validated['first_name'] ?? '') . ' ' . ($validated['last_name'] ?? '')),
                    'email' => $validated['email'],
                    'phone' => $validated['phone'] ?? null,
                    'company' => $validated['company'] ?? null,
                    'city' => $validated['city'] ?? null,
                    'country' => $validated['country'] ?? null,
                    'message' => $validated['project_details'],
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
                        'default_discount_percentage' => $discountPercentage,
                        'client_ip' => $request->ip(),
                        'user_agent' => (string) $request->userAgent(),
                        'source_url' => (string) $request->headers->get('referer', ''),
                    ],
                ]);

                $billingRequest->items()->createMany($linePayloads);

                return $billingRequest->load('items');
            })
            ->values();
    }

    private function billingSettingFor(int $etablissementId): ?BillingSetting
    {
        static $settings = [];

        if (!array_key_exists($etablissementId, $settings)) {
            $settings[$etablissementId] = BillingSetting::where('etablissement_id', $etablissementId)->first();
        }

        return $settings[$etablissementId];
    }

    private function serviceTaxRate(BillingRequestService $service, ?BillingSetting $setting = null): float
    {
        return round(array_sum(array_column($this->serviceTaxComponents($service, $setting), 'rate')), 3);
    }

    private function serviceTaxComponents(BillingRequestService $service, ?BillingSetting $setting = null): array
    {
        if ((float) $service->tax_rate > 0) {
            return [[
                'name' => optional($service->tax)->name ?: 'Taxe',
                'code' => optional($service->tax)->code ?: 'TAX',
                'rate' => (float) $service->tax_rate,
            ]];
        }

        if ($service->tax) {
            return [[
                'name' => (string) $service->tax->name,
                'code' => (string) $service->tax->code,
                'rate' => (float) $service->tax->rate,
            ]];
        }

        $defaultTaxIds = collect($setting?->default_tax_ids ?? [])
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->values();

        if ($defaultTaxIds->isEmpty()) {
            return [];
        }

        return Tax::query()
            ->whereIn('id', $defaultTaxIds->all())
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
     * @return array<int, string>
     */
    private function serviceSubjects(): array
    {
        return [
            'Creation de site web',
            'Refonte de site existant',
            'SEO et visibilite',
            'Marketing digital',
            'Espace destination',
            'Espace entreprise',
            'Espace medias',
            'Plan Next Level',
            'Autre demande',
        ];
    }

    /**
     * @return array<int, array{key:string,label:string,description:string}>
     */
    private function servicesCatalog(): array
    {
        return [
            ['key' => 'site_vitrine', 'label' => 'Site vitrine', 'description' => 'Presence professionnelle claire et rapide'],
            ['key' => 'ecommerce', 'label' => 'Boutique e-commerce', 'description' => 'Vente en ligne avec paiements securises'],
            ['key' => 'seo', 'label' => 'SEO international', 'description' => 'Optimisation de votre visibilite Google'],
            ['key' => 'social_media', 'label' => 'Reseaux sociaux', 'description' => 'Animation et strategie de contenu'],
            ['key' => 'brand_content', 'label' => 'Contenu de marque', 'description' => 'Textes, images, videos et storytelling'],
            ['key' => 'ads', 'label' => 'Publicites Meta/Google', 'description' => 'Campagnes d acquisition performantes'],
            ['key' => 'geo_video', 'label' => 'Geo-carte video', 'description' => 'Integration des medias et destinations'],
            ['key' => 'maintenance', 'label' => 'Maintenance & support', 'description' => 'Suivi technique et evolutions continues'],
        ];
    }
}
