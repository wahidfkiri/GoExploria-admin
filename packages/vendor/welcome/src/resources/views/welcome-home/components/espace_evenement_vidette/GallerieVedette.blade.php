@php
$sectionId = 'gallerie-vedette';
$title = 'ESPACE GALLERIE VEDETTE';
$subtitle = 'Photos premium · albums · inspirations visuelles · galeries thématiques — Les images qui déclenchent l’envie.';
$rightLabel = 'Galerie';
$learnMoreUrl = url('galeries');
$categories = [
    'photos' => ['label' => 'Photos', 'icon' => 'fa-camera'],
    'albums' => ['label' => 'Albums', 'icon' => 'fa-images'],
    'social' => ['label' => 'Social', 'icon' => 'fa-hashtag'],
    'premium' => ['label' => 'Premium', 'icon' => 'fa-star'],
];
$items = [
    ['cat'=>'photos','img'=>'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=600&h=400&fit=crop','badge'=>'Photo','title'=>'Galerie nature immersive','desc'=>'Paysages, parcs, activités et points de vue à fort impact visuel.','location'=>'Québec','tag'=>'Nature'],
    ['cat'=>'albums','img'=>'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=600&h=400&fit=crop','badge'=>'Album','title'=>'Album événements vedettes','desc'=>'Moments forts, foule, ambiance et storytelling d’événement.','location'=>'Montréal','tag'=>'Événement'],
    ['cat'=>'social','img'=>'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&h=400&fit=crop','badge'=>'Social','title'=>'Flux social inspirant','desc'=>'Images pensées pour Instagram, Pinterest, Facebook et campagnes digitales.','location'=>'Web','tag'=>'Social'],
    ['cat'=>'premium','img'=>'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&h=400&fit=crop','badge'=>'Premium','title'=>'Collection bord de mer','desc'=>'Photos premium pour destinations, hôtels et expériences touristiques.','location'=>'International','tag'=>'Premium'],
    ['cat'=>'photos','img'=>'https://images.unsplash.com/photo-1519451241324-20b4ea2c4220?w=600&h=400&fit=crop','badge'=>'Ville','title'=>'Galerie urbaine créative','desc'=>'Quartiers, architecture, culture et scènes de rue inspirantes.','location'=>'Canada','tag'=>'Urbain'],
    ['cat'=>'albums','img'=>'https://images.unsplash.com/photo-1527529482837-4698179dc6ce?w=600&h=400&fit=crop','badge'=>'Célébration','title'=>'Albums moments cadeaux','desc'=>'Visuels de coffrets, célébrations, expériences et produits vedettes.','location'=>'Québec','tag'=>'Cadeaux'],
];
$slides = [[
    'main'=>['src'=>'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=900&h=500&fit=crop','video'=>'M-2eAiU09qg','title'=>'Galeries vedettes','desc'=>'Un espace visuel premium pour inspirer, rassurer et convertir les visiteurs.','badge'=>'trending'],
    'grid'=>[
        ['src'=>'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Albums événements','desc'=>'Moments forts','badge'=>'hot'],
        ['src'=>'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Social feeds','desc'=>'Images partageables','badge'=>'new'],
        ['src'=>'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Premium','desc'=>'Collections visuelles','badge'=>'popular'],
        ['src'=>'https://images.unsplash.com/photo-1519451241324-20b4ea2c4220?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Urbain','desc'=>'Culture et architecture','badge'=>'trending'],
    ],
]];
@endphp
@include('welcome-home.components.espace_evenement_vidette._FeaturedVedetteSection', compact('sectionId','title','subtitle','rightLabel','learnMoreUrl','categories','items','slides'))
