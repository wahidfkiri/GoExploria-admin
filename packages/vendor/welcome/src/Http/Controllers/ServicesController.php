<?php

namespace Vendor\Welcome\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;

/**
 * Landing publique des Services (gérés dans l'admin /services).
 * Affiche un service et l'ensemble de ses contenus (about, événements, blog,
 * vidéos, galerie, témoignages, FAQ, contact) dans une page landing.
 */
class ServicesController extends Controller
{
    public function show(string $slug)
    {
        $service = Service::active()
            ->where('slug', $slug)
            ->firstOrFail();

        $contents = $service->pageContents()
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        $grouped = $contents->groupBy('type');

        $typeLabels = [
            'about'       => 'À propos',
            'event'       => 'Événements',
            'blog'        => 'Actualités',
            'video'       => 'Vidéos',
            'gallery'     => 'Galerie',
            'testimonial' => 'Témoignages',
            'faq'         => 'FAQ',
            'contact'     => 'Contact',
        ];

        return view('welcome-home.pages.service-landing', [
            'service'    => $service,
            'grouped'    => $grouped,
            'typeLabels' => $typeLabels,
        ]);
    }
}
