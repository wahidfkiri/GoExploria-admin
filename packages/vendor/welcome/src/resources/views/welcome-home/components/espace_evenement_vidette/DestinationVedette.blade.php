@php
$sectionId = 'destination-vedette';
$title = 'ESPACE DESTINATION VEDETTE';
$subtitle = 'Régions · villes · nature · patrimoine — Les destinations qui méritent une visibilité premium.';
$rightLabel = 'Destination';
$learnMoreUrl = url('destinations');
$categories = [
    'villes' => ['label' => 'Villes & Cités', 'icon' => 'fa-city'],
    'nature' => ['label' => 'Nature', 'icon' => 'fa-mountain-sun'],
    'culture' => ['label' => 'Culture', 'icon' => 'fa-landmark'],
    'pleinair' => ['label' => 'Plein air', 'icon' => 'fa-person-hiking'],
];
$items = [
    ['cat'=>'villes','img'=>'https://images.unsplash.com/photo-1519178614-68673b201f36?w=600&h=400&fit=crop','badge'=>'Ville','title'=>'Vieux-Québec historique','desc'=>'Patrimoine UNESCO, ruelles charmantes et expériences culturelles.','location'=>'Québec','tag'=>'Patrimoine'],
    ['cat'=>'nature','img'=>'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=600&h=400&fit=crop','badge'=>'Nature','title'=>'Charlevoix grandeur nature','desc'=>'Paysages spectaculaires, fleuve, montagnes et art de vivre.','location'=>'Charlevoix','tag'=>'Nature'],
    ['cat'=>'culture','img'=>'https://images.unsplash.com/photo-1519451241324-20b4ea2c4220?w=600&h=400&fit=crop','badge'=>'Culture','title'=>'Montréal créative','desc'=>'Quartiers vivants, festivals, gastronomie et scène artistique.','location'=>'Montréal','tag'=>'Culture'],
    ['cat'=>'pleinair','img'=>'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&h=400&fit=crop','badge'=>'Ski','title'=>'Mont-Tremblant actif','desc'=>'Station quatre saisons pour ski, randonnée, vélo et détente.','location'=>'Laurentides','tag'=>'Plein air'],
    ['cat'=>'nature','img'=>'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=600&h=400&fit=crop','badge'=>'Forêt','title'=>'Mauricie sauvage','desc'=>'Parcs, lacs, forêts et expériences nature authentiques.','location'=>'Mauricie','tag'=>'Forêt'],
    ['cat'=>'culture','img'=>'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&h=400&fit=crop','badge'=>'Mer','title'=>'Îles de la Madeleine','desc'=>'Falaises rouges, plages, culture acadienne et horizons marins.','location'=>'Golfe du Saint-Laurent','tag'=>'Culture maritime'],
];
$slides = [[
    'main'=>['src'=>'https://images.unsplash.com/photo-1519178614-68673b201f36?w=900&h=500&fit=crop','video'=>'M-2eAiU09qg','title'=>'Destinations vedettes','desc'=>'Des lieux iconiques à présenter avec une narration forte et commerciale.','badge'=>'trending'],
    'grid'=>[
        ['src'=>'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Nature grandiose','desc'=>'Paysages et parcs','badge'=>'hot'],
        ['src'=>'https://images.unsplash.com/photo-1519451241324-20b4ea2c4220?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Culture urbaine','desc'=>'Arts et quartiers','badge'=>'popular'],
        ['src'=>'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Plein air','desc'=>'Aventures quatre saisons','badge'=>'new'],
        ['src'=>'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Bord de mer','desc'=>'Évasion maritime','badge'=>'trending'],
    ],
]];
@endphp
@include('welcome-home.components.espace_evenement_vidette._FeaturedVedetteSection', compact('sectionId','title','subtitle','rightLabel','learnMoreUrl','categories','items','slides'))
