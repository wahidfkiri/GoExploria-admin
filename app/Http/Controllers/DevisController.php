<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
            'consent' => ['accepted'],
        ], [
            'selected_services.required' => 'Veuillez sélectionner au moins un service.',
            'consent.accepted' => 'Veuillez accepter la politique de confidentialité.',
        ]);

        $validated['selected_services'] = array_values(array_unique($validated['selected_services']));

        try {
            Mail::send('emails.devis-request', [
                'data' => $validated,
                'submittedAt' => now(),
            ], function ($message) use ($validated): void {
                $fullName = trim(($validated['first_name'] ?? '') . ' ' . ($validated['last_name'] ?? ''));
                $message->to('wahidfkiri5@gmail.com')
                    ->subject('Nouvelle demande de devis - ' . ($fullName !== '' ? $fullName : 'Client'))
                    ->replyTo($validated['email'], $fullName !== '' ? $fullName : null);
            });
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Impossible d’envoyer votre demande pour le moment. Merci de réessayer.');
        }

        return redirect()
            ->route('devis')
            ->with('success', 'Votre demande de devis a été envoyée avec succès. Notre équipe vous répondra rapidement.');
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

    /**
     * @return array<int, array{key:string,label:string,description:string}>
     */
    private function servicesCatalog(): array
    {
        return [
            ['key' => 'site_vitrine', 'label' => 'Site vitrine', 'description' => 'Présence professionnelle claire et rapide'],
            ['key' => 'ecommerce', 'label' => 'Boutique e-commerce', 'description' => 'Vente en ligne avec paiements sécurisés'],
            ['key' => 'seo', 'label' => 'SEO international', 'description' => 'Optimisation de votre visibilité Google'],
            ['key' => 'social_media', 'label' => 'Réseaux sociaux', 'description' => 'Animation et stratégie de contenu'],
            ['key' => 'brand_content', 'label' => 'Contenu de marque', 'description' => 'Textes, images, vidéos et storytelling'],
            ['key' => 'ads', 'label' => 'Publicités Meta/Google', 'description' => 'Campagnes d’acquisition performantes'],
            ['key' => 'geo_video', 'label' => 'Géo-carte vidéo', 'description' => 'Intégration des médias et destinations'],
            ['key' => 'maintenance', 'label' => 'Maintenance & support', 'description' => 'Suivi technique et évolutions continues'],
        ];
    }
}

