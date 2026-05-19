@php
    $sectionId = 'projet-immo';
    $eyebrow = 'Immobilier touristique';
    $title = 'ESPACE IMMOBILIER TOURISTIQUE';
    $subtitle = 'Des projets à fort potentiel pour développer, exploiter et commercialiser des expériences touristiques rentables.';
    $ctaUrl = route('pages.projet-touristique-boreal');
    $ctaText = 'Voir les projets touristiques';
    $cards = [
        [
            'image' => 'https://images.unsplash.com/photo-1487958449943-2429e8be8625?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Investissement',
            'price' => 'À partir de 1 250 000 CAD',
            'title' => 'Domaine touristique boréal',
            'location' => 'Mont-Tremblant, Québec',
            'features' => [
                ['icon' => 'fas fa-ruler-combined', 'label' => '420 m²'],
                ['icon' => 'fas fa-building', 'label' => '8 unités'],
                ['icon' => 'fas fa-chart-line', 'label' => 'Potentiel locatif'],
            ],
            'url' => route('pages.projet-touristique-boreal'),
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Resort',
            'price' => 'À partir de 1 690 000 CAD',
            'title' => 'Micro-resort nature',
            'location' => 'Charlevoix, Québec',
            'features' => [
                ['icon' => 'fas fa-campground', 'label' => '12 hébergements'],
                ['icon' => 'fas fa-spa', 'label' => 'Espace bien-être'],
                ['icon' => 'fas fa-route', 'label' => 'Sentiers privés'],
            ],
            'url' => route('pages.projet-touristique-boreal'),
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Écotourisme',
            'price' => 'À partir de 875 000 CAD',
            'title' => 'Site d’hébergements insolites',
            'location' => 'Gaspésie, Québec',
            'features' => [
                ['icon' => 'fas fa-leaf', 'label' => 'Écoresponsable'],
                ['icon' => 'fas fa-home', 'label' => '6 unités'],
                ['icon' => 'fas fa-camera', 'label' => 'Expérience forte'],
            ],
            'url' => route('pages.chalet-rental-lac-azur'),
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Développement',
            'price' => 'Sur demande',
            'title' => 'Projet immobilier mixte',
            'location' => 'Québec, Canada',
            'features' => [
                ['icon' => 'fas fa-drafting-compass', 'label' => 'Plan concept'],
                ['icon' => 'fas fa-handshake', 'label' => 'Partenariats'],
                ['icon' => 'fas fa-bullhorn', 'label' => 'Mise en marché'],
            ],
            'url' => route('pages.projet-touristique-boreal'),
        ],
    ];
@endphp

@include('home-v2.components.espace_specialisés._PropertySpecializedSection')
