@php
$sectionId = 'hebergement-vedette';
$title = 'ESPACE HÉBERGEMENT VEDETTE';
$subtitle = 'Hôtels · chalets · auberges · hébergements insolites — Les séjours qui déclenchent la réservation.';
$rightLabel = 'Hébergement';
$learnMoreUrl = url('hebergements');
$categories = [
    'hotel' => ['label' => 'Hôtels', 'icon' => 'fa-hotel'],
    'chalet' => ['label' => 'Chalets', 'icon' => 'fa-house-chimney'],
    'auberge' => ['label' => 'Auberges', 'icon' => 'fa-bed'],
    'insolite' => ['label' => 'Insolites', 'icon' => 'fa-campground'],
];
$items = [
    ['cat'=>'hotel','img'=>'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&h=400&fit=crop','badge'=>'Hôtel','title'=>'Hôtel boutique centre-ville','desc'=>'Confort, design et accès rapide aux attraits touristiques.','location'=>'Montréal','tag'=>'Hôtel'],
    ['cat'=>'chalet','img'=>'https://images.unsplash.com/photo-1518780664697-55e3ad937233?w=600&h=400&fit=crop','badge'=>'Chalet','title'=>'Chalet bord de lac','desc'=>'Un refuge chaleureux pour escapades familiales et week-ends nature.','location'=>'Laurentides','tag'=>'Chalet'],
    ['cat'=>'auberge','img'=>'https://images.unsplash.com/photo-1501117716987-c8e1ecb210e0?w=600&h=400&fit=crop','badge'=>'Auberge','title'=>'Auberge de charme terroir','desc'=>'Accueil humain, cuisine locale et atmosphère de village.','location'=>'Charlevoix','tag'=>'Auberge'],
    ['cat'=>'insolite','img'=>'https://images.unsplash.com/photo-1504851149312-7a075b496cc7?w=600&h=400&fit=crop','badge'=>'Insolite','title'=>'Dôme nature panoramique','desc'=>'Dormir sous les étoiles avec confort et vue immersive.','location'=>'Estrie','tag'=>'Insolite'],
    ['cat'=>'hotel','img'=>'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=600&h=400&fit=crop','badge'=>'Spa','title'=>'Resort spa & détente','desc'=>'Séjour bien-être, piscines, soins et gastronomie.','location'=>'Québec','tag'=>'Spa'],
    ['cat'=>'chalet','img'=>'https://images.unsplash.com/photo-1523217582562-09d0def993a6?w=600&h=400&fit=crop','badge'=>'Famille','title'=>'Chalet familial premium','desc'=>'Grand espace, cuisine complète et accès aux activités.','location'=>'Mauricie','tag'=>'Famille'],
];
$slides = [[
    'main'=>['src'=>'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=900&h=500&fit=crop','video'=>'M-2eAiU09qg','title'=>'Hébergements vedettes','desc'=>'Une vitrine visuelle qui transforme l’envie de séjour en réservation.','badge'=>'new'],
    'grid'=>[
        ['src'=>'https://images.unsplash.com/photo-1518780664697-55e3ad937233?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Chalets nature','desc'=>'Séjours au calme','badge'=>'hot'],
        ['src'=>'https://images.unsplash.com/photo-1501117716987-c8e1ecb210e0?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Auberges','desc'=>'Accueil local','badge'=>'popular'],
        ['src'=>'https://images.unsplash.com/photo-1504851149312-7a075b496cc7?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Insolite','desc'=>'Expériences mémorables','badge'=>'trending'],
        ['src'=>'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Spa & resort','desc'=>'Détente premium','badge'=>'new'],
    ],
]];
@endphp
@include('home-v2.components.espace_evenement_vidette._FeaturedVedetteSection', compact('sectionId','title','subtitle','rightLabel','learnMoreUrl','categories','items','slides'))
