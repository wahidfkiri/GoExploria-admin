@php
$sectionId = 'produit-vedette-evenement';
$title = 'ESPACE PRODUIT VEDETTE';
$subtitle = 'Produits locaux · boutiques · souvenirs · cadeaux — Les articles qui méritent une mise en avant commerciale.';
$rightLabel = 'Produit';
$learnMoreUrl = url('produits');
$categories = [
    'terroir' => ['label' => 'Terroir', 'icon' => 'fa-jar'],
    'artisanat' => ['label' => 'Artisanat', 'icon' => 'fa-hands-holding'],
    'cadeaux' => ['label' => 'Cadeaux', 'icon' => 'fa-gift'],
    'pleinair' => ['label' => 'Plein air', 'icon' => 'fa-campground'],
];
$items = [
    ['cat'=>'terroir','img'=>'https://images.unsplash.com/photo-1606787366850-de6330128bfc?w=600&h=400&fit=crop','badge'=>'Terroir','title'=>'Sirop d’érable premium','desc'=>'Produit local emblématique pour touristes, familles et entreprises.','location'=>'Québec','tag'=>'Gourmand'],
    ['cat'=>'artisanat','img'=>'https://images.unsplash.com/photo-1513542789411-b6a5d4f31634?w=600&h=400&fit=crop','badge'=>'Artisan','title'=>'Affiche vintage Québec','desc'=>'Souvenir design inspiré des destinations et quartiers iconiques.','location'=>'Montréal','tag'=>'Artisanat'],
    ['cat'=>'cadeaux','img'=>'https://images.unsplash.com/photo-1513885535751-8b9238bd345a?w=600&h=400&fit=crop','badge'=>'Cadeau','title'=>'Coffret découverte local','desc'=>'Une sélection cadeau prête à offrir pour toutes les occasions.','location'=>'Canada','tag'=>'Cadeau'],
    ['cat'=>'pleinair','img'=>'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=600&h=400&fit=crop','badge'=>'Outdoor','title'=>'Tente aventure 4 saisons','desc'=>'Produit vedette pour explorateurs et amateurs de plein air.','location'=>'Laurentides','tag'=>'Plein air'],
    ['cat'=>'terroir','img'=>'https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&h=400&fit=crop','badge'=>'Panier','title'=>'Panier gourmand terroir','desc'=>'Produits régionaux emballés pour cadeaux et événements.','location'=>'Charlevoix','tag'=>'Terroir'],
    ['cat'=>'cadeaux','img'=>'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=600&h=400&fit=crop','badge'=>'Premium','title'=>'Carte cadeau destination','desc'=>'Offrez une expérience GoExploria personnalisable.','location'=>'International','tag'=>'Carte cadeau'],
];
$slides = [[
    'main'=>['src'=>'https://images.unsplash.com/photo-1513885535751-8b9238bd345a?w=900&h=500&fit=crop','video'=>'M-2eAiU09qg','title'=>'Produits vedettes','desc'=>'Mettez vos meilleurs produits au premier plan avec une vitrine dynamique.','badge'=>'popular'],
    'grid'=>[
        ['src'=>'https://images.unsplash.com/photo-1606787366850-de6330128bfc?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Terroir','desc'=>'Saveurs locales','badge'=>'hot'],
        ['src'=>'https://images.unsplash.com/photo-1513542789411-b6a5d4f31634?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Artisanat','desc'=>'Créations uniques','badge'=>'new'],
        ['src'=>'https://images.unsplash.com/photo-1542838132-92c53300491e?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Paniers cadeaux','desc'=>'Offres premium','badge'=>'trending'],
        ['src'=>'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Plein air','desc'=>'Équipement vedette','badge'=>'popular'],
    ],
]];
@endphp
@include('welcome-home.components.espace_evenement_vidette._FeaturedVedetteSection', compact('sectionId','title','subtitle','rightLabel','learnMoreUrl','categories','items','slides'))
