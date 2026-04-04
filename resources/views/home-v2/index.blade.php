<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GO EXPLORIA - Découvrez le Québec autrement">
    <title>GO EXPLORIA - Canada, Québec</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu-videos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-destinations-mega.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/videos-dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/interactive-map.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/viewing-carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/viewing-carousel-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/video-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/slideshows.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/video-player.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/events-vedette.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-vedette.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/restaurants-vedette.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/menu-accord-mets-vins.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/page-6-packages.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/page-3-infos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/page-5-tourism.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/business-tourism.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('css/home-v2/multilingual-grid.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/news-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/web-services.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/agency-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/partners-master.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/real-estate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
</head>
<body>
    @include('home-v2.components.VerticalMenu')
    @include('home-v2.components.Header')
    
    <main class="main-content">
        @include('home-v2.components.Hero')
        @include('home-v2.components.slideshows')
        @include('home-v2.components.InteractiveMap')
        @include('home-v2.components.VideoPlayer')
        @include('home-v2.components.EventsVedette')
        @include('home-v2.components.DestinationsVedette')
        @include('home-v2.components.RestaurantsVedette')
        @include('home-v2.components.MenuAccordMetsVins')
        @include('home-v2.components.TravelPackages')
        @include('home-v2.components.TravelInfos')
        @include('home-v2.components.TourismSection')
        @include('home-v2.components.PartnersMaster')
        @include('home-v2.components.AgencySection')
        @include('home-v2.components.RealEstateSection')
        @include('home-v2.components.MultilingualGrid')
        @include('home-v2.components.NewsSection')
        @include('home-v2.components.WebServices')
        @include('home-v2.components.BusinessTourism')
    </main>
    
    {{-- Modal vidéo réutilisable pour toute la plateforme --}}
    @include('components.VideoModal')
    
    @include('home-v2.components.Footer')
    
    <script src="{{ asset('js/home-v2/carousel.js') }}"></script>
    <script src="{{ asset('js/home-v2/navigation.js') }}"></script>
    {{-- Charger le service API pour les menus EN PREMIER --}}
    <script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
    {{-- Charger le service API pour le mega menu destinations --}}
    <script src="{{ asset('js/home-v2/mega-menu-service.js') }}"></script>
    {{-- Charger le menu vertical dynamique --}}
    <script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
    {{-- Charger le contrôleur du menu vertical (gestion accordéon et vidéos) --}}
    <script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
    {{-- Charger le mega menu Destinations pour le menu vertical --}}
    <script src="{{ asset('js/home-v2/vertical-destinations-mega.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/destinations-mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/destinations-search.js') }}"></script>
    <script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
    {{-- Charger le service API pour la carte interactive --}}
    <script src="{{ asset('js/home-v2/map-api-service.js') }}"></script>
    <script src="{{ asset('js/home-v2/interactive-map-dynamic.js') }}"></script>
    {{-- Charger video-modal.js EN PREMIER car les autres composants en dépendent --}}
    <script src="{{ asset('js/video-modal.js') }}"></script>
    <script src="{{ asset('js/home-v2/viewing-carousel.js') }}"></script>
    <script src="{{ asset('js/home-v2/videos-dropdown.js') }}"></script>
    <script src="{{ asset('js/home-v2/slideshows.js') }}"></script>
    <script src="{{ asset('js/home-v2/video-player.js') }}"></script>
    <script src="{{ asset('js/home-v2/events-vedette.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="{{ asset('js/home-v2/business-tourism.js') }}"></script>
    <script src="{{ asset('js/home-v2/partners-master.js') }}"></script>
</body>
</html>
