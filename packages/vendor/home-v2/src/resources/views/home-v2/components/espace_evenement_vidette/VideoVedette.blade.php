@php
$sectionId = 'video-vedette';
$title = 'ESPACE VIDÉO VEDETTE';
$subtitle = 'Chaînes vidéo · reportages · créateurs · capsules destination — Les contenus vidéo à mettre en avant.';
$rightLabel = 'Vidéo';
$learnMoreUrl = url('videos');
$categories = [
    'youtube' => ['label' => 'YouTube', 'icon' => 'fa-play'],
    'destination' => ['label' => 'Destinations', 'icon' => 'fa-map-location-dot'],
    'interview' => ['label' => 'Interviews', 'icon' => 'fa-microphone'],
    'reel' => ['label' => 'Reels courts', 'icon' => 'fa-mobile-screen'],
];
$items = [
    ['cat'=>'youtube','img'=>'https://images.unsplash.com/photo-1611162616475-46b635cb6868?w=600&h=400&fit=crop','badge'=>'YouTube','title'=>'Chaîne GoExploria MyTube','desc'=>'Capsules vidéo, destinations, services et découvertes locales à regarder maintenant.','location'=>'International','tag'=>'Chaîne vidéo'],
    ['cat'=>'destination','img'=>'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=600&h=400&fit=crop','badge'=>'4K','title'=>'Destination Québec en images','desc'=>'Une série immersive pour inspirer les voyageurs et guider les visiteurs.','location'=>'Québec','tag'=>'Destination'],
    ['cat'=>'interview','img'=>'https://images.unsplash.com/photo-1492724441997-5dc865305da7?w=600&h=400&fit=crop','badge'=>'Podcast','title'=>'Rencontre avec les artisans','desc'=>'Entrepreneurs, restaurateurs et créateurs racontent leur espace et leur histoire.','location'=>'Canada','tag'=>'Interview'],
    ['cat'=>'reel','img'=>'https://images.unsplash.com/photo-1611162618071-b39a2ec055fb?w=600&h=400&fit=crop','badge'=>'Shorts','title'=>'Reels activités à proximité','desc'=>'Formats courts pour découvrir rapidement activités, restaurants et hébergements.','location'=>'Mobile','tag'=>'Reels'],
    ['cat'=>'youtube','img'=>'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=600&h=400&fit=crop','badge'=>'Live','title'=>'Émissions vidéo en direct','desc'=>'Diffusions live pour événements, lancements et visites guidées en ligne.','location'=>'En direct','tag'=>'Live vidéo'],
    ['cat'=>'destination','img'=>'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&h=400&fit=crop','badge'=>'Série','title'=>'Routes touristiques vedettes','desc'=>'Itinéraires vidéo pour faire découvrir les régions et leurs incontournables.','location'=>'Régions','tag'=>'Route vidéo'],
];
$slides = [[
    'main'=>['src'=>'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=900&h=500&fit=crop','video'=>'M-2eAiU09qg','title'=>'Espace vidéo vedette','desc'=>'Un hub vidéo moderne pour promouvoir destinations, services et marques.','badge'=>'new'],
    'grid'=>[
        ['src'=>'https://images.unsplash.com/photo-1611162616475-46b635cb6868?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Chaînes sociales','desc'=>'YouTube, Vimeo, Rumble et plus','badge'=>'hot'],
        ['src'=>'https://images.unsplash.com/photo-1492724441997-5dc865305da7?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Interviews','desc'=>'Portraits et histoires','badge'=>'popular'],
        ['src'=>'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Destinations','desc'=>'Voyage en images','badge'=>'trending'],
        ['src'=>'https://images.unsplash.com/photo-1611162618071-b39a2ec055fb?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Reels courts','desc'=>'Format mobile rapide','badge'=>'new'],
    ],
]];
@endphp
@include('home-v2.components.espace_evenement_vidette._FeaturedVedetteSection', compact('sectionId','title','subtitle','rightLabel','learnMoreUrl','categories','items','slides'))
