@php
$sectionId = 'entreprise-vedette';
$title = 'ESPACE ENTREPRISE VEDETTE';
$subtitle = 'Entreprises locales · partenaires certifiés · services professionnels — Les marques à mettre en avant.';
$rightLabel = 'Entreprise';
$learnMoreUrl = url('entreprises');
$categories = [
    'services' => ['label' => 'Services', 'icon' => 'fa-briefcase'],
    'tourisme' => ['label' => 'Tourisme', 'icon' => 'fa-route'],
    'commerce' => ['label' => 'Commerce', 'icon' => 'fa-store'],
    'innovation' => ['label' => 'Innovation', 'icon' => 'fa-lightbulb'],
];
$items = [
    ['cat'=>'services','img'=>'https://images.unsplash.com/photo-1556761175-4b46a572b786?w=600&h=400&fit=crop','badge'=>'Service','title'=>'Agence expérience client','desc'=>'Accompagnement, visibilité et solutions web pour développer une marque locale.','location'=>'Québec','tag'=>'Services'],
    ['cat'=>'tourisme','img'=>'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600&h=400&fit=crop','badge'=>'Tourisme','title'=>'Partenaire tourisme régional','desc'=>'Entreprise experte en accueil, circuits et expériences de destination.','location'=>'Charlevoix','tag'=>'Tourisme'],
    ['cat'=>'commerce','img'=>'https://images.unsplash.com/photo-1556740758-90de374c12ad?w=600&h=400&fit=crop','badge'=>'Commerce','title'=>'Boutique locale certifiée','desc'=>'Produits, cadeaux, services et offres commerciales à forte valeur ajoutée.','location'=>'Montréal','tag'=>'Commerce'],
    ['cat'=>'innovation','img'=>'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=600&h=400&fit=crop','badge'=>'Innovation','title'=>'Studio numérique touristique','desc'=>'Solutions digitales pour transformer les visiteurs en clients.','location'=>'Canada','tag'=>'Innovation'],
    ['cat'=>'services','img'=>'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=600&h=400&fit=crop','badge'=>'Conseil','title'=>'Consultants croissance locale','desc'=>'Stratégie, contenu, référencement et conversion pour entreprises.','location'=>'Laval','tag'=>'Conseil'],
    ['cat'=>'commerce','img'=>'https://images.unsplash.com/photo-1556761175-b413da4baf72?w=600&h=400&fit=crop','badge'=>'B2B','title'=>'Réseau partenaires affaires','desc'=>'Mise en relation, offres croisées et visibilité entre partenaires.','location'=>'International','tag'=>'B2B'],
];
$slides = [[
    'main'=>['src'=>'https://images.unsplash.com/photo-1556761175-4b46a572b786?w=900&h=500&fit=crop','video'=>'M-2eAiU09qg','title'=>'Entreprises vedettes','desc'=>'Une vitrine professionnelle pour valoriser les partenaires, commerces et services.','badge'=>'new'],
    'grid'=>[
        ['src'=>'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Partenaires tourisme','desc'=>'Réseau destination','badge'=>'hot'],
        ['src'=>'https://images.unsplash.com/photo-1556740758-90de374c12ad?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Commerces locaux','desc'=>'Offres à découvrir','badge'=>'popular'],
        ['src'=>'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Innovation','desc'=>'Solutions digitales','badge'=>'trending'],
        ['src'=>'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=500&h=300&fit=crop','video'=>'M-2eAiU09qg','title'=>'Conseil','desc'=>'Croissance locale','badge'=>'new'],
    ],
]];
@endphp
@include('welcome-home.components.espace_evenement_vidette._FeaturedVedetteSection', compact('sectionId','title','subtitle','rightLabel','learnMoreUrl','categories','items','slides'))
