@php
$sectionId = 'restaurant-vedette';
$title = 'ESPACE RESTAURANT VEDETTE';
$subtitle = 'Tables gourmandes · ambiances · menus · réservations — Les restaurants à découvrir en priorité.';
$rightLabel = 'Restaurant';
$learnMoreUrl = url('restaurants');
$categories = [
    'gastronomie' => ['label' => 'Gastronomie', 'icon' => 'fa-utensils'],
    'terroir' => ['label' => 'Terroir', 'icon' => 'fa-seedling'],
    'ambiance' => ['label' => 'Ambiance', 'icon' => 'fa-champagne-glasses'],
    'famille' => ['label' => 'Famille', 'icon' => 'fa-people-group'],
];
$items = [
    ['cat'=>'gastronomie','img'=>'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600&h=400&fit=crop','badge'=>'Chef','title'=>'Table signature du Québec','desc'=>'Cuisine créative, produits locaux et expérience culinaire mémorable.','location'=>'Québec','tag'=>'Gastronomie'],
    ['cat'=>'terroir','img'=>'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&h=400&fit=crop','badge'=>'Terroir','title'=>'Bistro terroir & produits locaux','desc'=>'Une adresse chaleureuse centrée sur les saveurs régionales.','location'=>'Charlevoix','tag'=>'Terroir'],
    ['cat'=>'ambiance','img'=>'https://images.unsplash.com/photo-1552566626-52f8b828add9?w=600&h=400&fit=crop','badge'=>'Soirée','title'=>'Restaurant ambiance urbaine','desc'=>'Décor vibrant, cocktails et plats à partager pour sorties réussies.','location'=>'Montréal','tag'=>'Ambiance'],
    ['cat'=>'famille','img'=>'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=600&h=400&fit=crop','badge'=>'Famille','title'=>'Brunch familial vedette','desc'=>'Menus généreux, service rapide et atmosphère conviviale.','location'=>'Laval','tag'=>'Famille'],
    ['cat'=>'gastronomie','img'=>'https://images.unsplash.com/photo-1551218808-94e220e084d2?w=600&h=400&fit=crop','badge'=>'Dégustation','title'=>'Menu dégustation saisonnier','desc'=>'Un parcours gastronomique pour mettre en scène chaque saison.','location'=>'Québec','tag'=>'Chef'],
    ['cat'=>'terroir','img'=>'https://images.unsplash.com/photo-1544025162-d76694265947?w=600&h=400&fit=crop','badge'=>'Grill','title'=>'Grillades et fumoir local','desc'=>'Viandes, poissons et légumes préparés avec savoir-faire.','location'=>'Mauricie','tag'=>'Fumoir'],
];
$slides = [[
    'main'=>['src'=>'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=900&h=500&fit=crop','video'=>'M-2eAiU09qg','title'=>'Restaurants vedettes','desc'=>'Des tables à fort potentiel commercial, prêtes à recevoir vos visiteurs.','badge'=>'hot'],
    'grid'=>[
        ['src'=>'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Cuisine terroir','desc'=>'Produits locaux','badge'=>'new'],
        ['src'=>'https://images.unsplash.com/photo-1552566626-52f8b828add9?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Ambiances uniques','desc'=>'Décor et expérience','badge'=>'trending'],
        ['src'=>'https://images.unsplash.com/photo-1551218808-94e220e084d2?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Chefs en action','desc'=>'Créations et savoir-faire','badge'=>'popular'],
        ['src'=>'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Sorties famille','desc'=>'Moments conviviaux','badge'=>'new'],
    ],
]];
@endphp
@include('welcome-home.components.espace_evenement_vidette._FeaturedVedetteSection', compact('sectionId','title','subtitle','rightLabel','learnMoreUrl','categories','items','slides'))
