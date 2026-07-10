@php
    $sectionId = 'maisons-chalets';
    $eyebrow = 'Maisons chalets';
    $title = 'ESPACE MAISON CHALET À VENDRE';
    $subtitle = 'Des propriétés hybrides pour vivre le confort d’une maison et l’émotion d’un chalet, en résidence principale ou secondaire.';
    $ctaUrl = route('pages.maison-forestiere-eclipse');
    $ctaText = 'Découvrir les maisons chalets';
    $cards = [
        [
            'image' => 'https://images.unsplash.com/photo-1572120360610-d971b9d7767c?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Famille',
            'price' => 'À partir de 510 000 CAD',
            'title' => 'Maison chalet lacustre',
            'location' => 'Laurentides, Québec',
            'features' => [
                ['icon' => 'fas fa-ruler-combined', 'label' => '175 m²'],
                ['icon' => 'fas fa-bed', 'label' => '4 chambres'],
                ['icon' => 'fas fa-water', 'label' => 'Vue sur lac'],
            ],
            'url' => route('pages.maison-forestiere-eclipse'),
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Bois rond',
            'price' => 'À partir de 595 000 CAD',
            'title' => 'Maison bois rond prestige',
            'location' => 'Mauricie, Québec',
            'features' => [
                ['icon' => 'fas fa-tree', 'label' => 'Bois massif'],
                ['icon' => 'fas fa-bed', 'label' => '4 chambres'],
                ['icon' => 'fas fa-fire', 'label' => 'Foyer pierre'],
            ],
            'url' => route('pages.chalet-rental-lac-azur'),
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Design',
            'price' => 'À partir de 650 000 CAD',
            'title' => 'Maison chalet contemporaine',
            'location' => 'Cantons-de-l’Est, Québec',
            'features' => [
                ['icon' => 'fas fa-ruler-combined', 'label' => '210 m²'],
                ['icon' => 'fas fa-sun', 'label' => 'Fenestration'],
                ['icon' => 'fas fa-leaf', 'label' => 'Écoénergie'],
            ],
            'url' => route('pages.maison-forestiere-eclipse'),
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1598228723793-52759bba239c?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Bord de l’eau',
            'price' => 'À partir de 735 000 CAD',
            'title' => 'Domaine familial privé',
            'location' => 'Outaouais, Québec',
            'features' => [
                ['icon' => 'fas fa-water', 'label' => 'Quai privé'],
                ['icon' => 'fas fa-bed', 'label' => '5 chambres'],
                ['icon' => 'fas fa-shield-alt', 'label' => 'Intimité'],
            ],
            'url' => route('pages.chalet-rental-detail'),
        ],
    ];
@endphp

@include('welcome-home.components.espace_specialisés._PropertySpecializedSection')
