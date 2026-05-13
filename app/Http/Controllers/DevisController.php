<?php

namespace App\Http\Controllers;

use App\Models\DevisRequest;
use App\Models\Plan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class DevisController extends Controller
{
    public function show(): View
    {
        $plans = Plan::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'name', 'slug', 'description', 'icon', 'price', 'currency', 'billing_cycle']);

        return view('home-v2.pages.devis', [
            'plans' => $plans,
            'serviceSubjects' => $this->serviceSubjects(),
            'servicesCatalog' => $this->servicesCatalog(),
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
            'selected_services' => ['required', 'array', 'min:1'],
            'selected_services.*' => ['string', 'max:120'],
            'plan_interest' => ['nullable', 'string', 'max:180'],
            'budget' => ['nullable', 'string', 'max:120'],
            'project_deadline' => ['nullable', 'date'],
            'project_details' => ['required', 'string', 'min:10', 'max:4000'],
            'media_files' => ['nullable', 'array', 'max:10'],
            'media_files.*' => ['file', 'max:20480', 'mimes:jpg,jpeg,png,gif,webp,bmp,svg,pdf,csv,txt,xls,xlsx,ods,doc,docx,ppt,pptx,zip,rar'],
            'consent' => ['accepted'],
        ], [
            'selected_services.required' => 'Veuillez selectionner au moins un service.',
            'media_files.*.mimes' => 'Un ou plusieurs fichiers ont un format non autorise.',
            'media_files.*.max' => 'Chaque fichier doit faire moins de 20 Mo.',
            'consent.accepted' => 'Veuillez accepter la politique de confidentialite.',
        ]);

        $validated['selected_services'] = array_values(array_unique($validated['selected_services']));

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
