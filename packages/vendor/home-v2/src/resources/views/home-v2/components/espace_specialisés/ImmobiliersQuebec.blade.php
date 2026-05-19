@php
    $sectionId = 'immo-quebec';
    $eyebrow = 'Immobiliers Québec';
    $title = 'IMMOBILIERS QUÉBEC';
    $subtitle = 'Un espace vitrine pour repérer, comparer et propulser les meilleures opportunités immobilières au Québec.';
    $ctaUrl = route('pages.chalet-rental-detail');
    $ctaText = 'Explorer les propriétés';
    $cards = [
        [
            'image' => 'https://images.unsplash.com/photo-1464146072230-91cabc968266?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Québec',
            'price' => 'À partir de 420 000 CAD',
            'title' => 'Condo urbain premium',
            'location' => 'Québec, Capitale-Nationale',
            'features' => [
                ['icon' => 'fas fa-ruler-combined', 'label' => '140 m²'],
                ['icon' => 'fas fa-bed', 'label' => '3 chambres'],
                ['icon' => 'fas fa-car', 'label' => '2 stationnements'],
            ],
            'url' => route('pages.chalet-rental-detail'),
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Famille',
            'price' => 'À partir de 585 000 CAD',
            'title' => 'Maison familiale moderne',
            'location' => 'Lévis, Chaudière-Appalaches',
            'features' => [
                ['icon' => 'fas fa-ruler-combined', 'label' => '185 m²'],
                ['icon' => 'fas fa-bed', 'label' => '4 chambres'],
                ['icon' => 'fas fa-tree', 'label' => 'Cour intime'],
            ],
            'url' => route('pages.maison-forestiere-eclipse'),
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Investissement',
            'price' => 'À partir de 765 000 CAD',
            'title' => 'Plex revenu locatif',
            'location' => 'Montréal, Québec',
            'features' => [
                ['icon' => 'fas fa-building', 'label' => '4 unités'],
                ['icon' => 'fas fa-chart-line', 'label' => 'Revenus stables'],
                ['icon' => 'fas fa-subway', 'label' => 'Près métro'],
            ],
            'url' => route('pages.projet-touristique-boreal'),
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Prestige',
            'price' => 'À partir de 980 000 CAD',
            'title' => 'Résidence signature',
            'location' => 'Brossard, Montérégie',
            'features' => [
                ['icon' => 'fas fa-ruler-combined', 'label' => '230 m²'],
                ['icon' => 'fas fa-bed', 'label' => '5 chambres'],
                ['icon' => 'fas fa-star', 'label' => 'Finition luxe'],
            ],
            'url' => route('pages.chalet-rental-detail'),
        ],
    ];
@endphp

@include('home-v2.components.espace_specialisés._PropertySpecializedSection')
