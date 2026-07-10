@php
    $sectionId = 'chalets-vendre';
    $eyebrow = 'Chalets à vendre';
    $title = 'ESPACE CHALET À VENDRE';
    $subtitle = 'Des chalets au bord de l’eau, en montagne ou en forêt pour créer votre refuge, votre revenu locatif ou votre projet de vie.';
    $ctaUrl = route('pages.chalet-rental-lac-azur');
    $ctaText = 'Voir les chalets';
    $cards = [
        [
            'image' => 'https://images.unsplash.com/photo-1449158743715-0a90ebb6d2d8?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Nature',
            'price' => 'À partir de 289 000 CAD',
            'title' => 'Chalet forêt boréale',
            'location' => 'Charlevoix, Québec',
            'features' => [
                ['icon' => 'fas fa-ruler-combined', 'label' => '95 m²'],
                ['icon' => 'fas fa-bed', 'label' => '2 chambres'],
                ['icon' => 'fas fa-tree', 'label' => 'Terrain boisé'],
            ],
            'url' => route('pages.chalet-rental-lac-azur'),
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1542718610-a1d656d1884c?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Lac',
            'price' => 'À partir de 368 000 CAD',
            'title' => 'Chalet rive privée',
            'location' => 'Lac-Supérieur, Laurentides',
            'features' => [
                ['icon' => 'fas fa-water', 'label' => 'Accès lac'],
                ['icon' => 'fas fa-bed', 'label' => '3 chambres'],
                ['icon' => 'fas fa-fire', 'label' => 'Foyer central'],
            ],
            'url' => route('pages.chalet-rental-lac-azur'),
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1601918774946-25832a4be0d6?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Montagne',
            'price' => 'À partir de 445 000 CAD',
            'title' => 'Chalet panorama ski',
            'location' => 'Mont-Tremblant, Québec',
            'features' => [
                ['icon' => 'fas fa-mountain', 'label' => 'Vue montagne'],
                ['icon' => 'fas fa-skiing', 'label' => 'Près des pistes'],
                ['icon' => 'fas fa-hot-tub', 'label' => 'Spa extérieur'],
            ],
            'url' => route('pages.projet-touristique-boreal'),
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1518732714860-b62714ce0c59?w=1200&auto=format&fit=crop&q=70',
            'badge' => 'Locatif',
            'price' => 'À partir de 520 000 CAD',
            'title' => 'Chalet prêt à louer',
            'location' => 'Estrie, Québec',
            'features' => [
                ['icon' => 'fas fa-key', 'label' => 'Clé en main'],
                ['icon' => 'fas fa-users', 'label' => '10 voyageurs'],
                ['icon' => 'fas fa-chart-line', 'label' => 'Fort rendement'],
            ],
            'url' => route('pages.chalet-rental-detail'),
        ],
    ];
@endphp

@include('welcome-home.components.espace_specialisés._PropertySpecializedSection')
