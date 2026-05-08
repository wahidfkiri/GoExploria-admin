<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('home-v2.home.meta_description') }}">
    <title>{{ __('home-v2.home.meta_title') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome pour les icÃ´nes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu-videos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-destinations-mega.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/sections-nav-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/categories-mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/videos-dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/viewing-carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/tiktok-carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/espace-chat-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/espace-mail-marketing-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/espace-blog-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/espace-social-media-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/video-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/slideshows.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/video-player.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/media-slideshow.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/events-vedette.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-vedette.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/restaurants-vedette.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/products-vedette.css') }}">
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
    <link rel="stylesheet" href="{{ asset('css/home-v2/restaurant-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/resa-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/nos-plans.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
</head>
<body>
    @include('home-v2.components.VerticalMenu')
    @include('home-v2.components.Header')
    
    <main class="main-content">
        @include('home-v2.components.Hero')
        @include('home-v2.components.SectionsNavBar')

        <div id="section-medias" class="snb-anchor"></div>
        @include('home-v2.components.espace_media.BusinessTourism')
        @include('home-v2.components.espace_media.DestinationsVedette')
        @include('geo-map::index')
        @include('home-v2.components.espace_media.MultilingualGrid')
        @include('home-v2.components.espace_media.slideshows')
        @include('home-v2.components.espace_media.TikTokCarousel')
        @include('home-v2.components.espace_media.ViewingCarousel')
        @include('home-v2.components.espace_media.VideoPlayer')
        @include('home-v2.components.espace_media.GallerieCaroussel')
        @include('home-v2.components.espace_media.EspaceSocialMediaSection')
        @include('home-v2.components.espace_media.EspaceChatSection')
        @include('home-v2.components.espace_media.EspaceMailMarketingSection')
        @include('home-v2.components.espace_media.EspaceBlogSection')
        @include('home-v2.components.espace_media.AvisClientsSection')


        <div id="section-next-level" class="snb-anchor"></div>
        <!-- @include('home-v2.components.PartnersMaster') -->
         @include('home-v2.components.espace_next_level.01_AgencySection')
         @include('home-v2.components.espace_next_level.02_PlansNextLevel')
         @include('home-v2.components.espace_next_level.03_EspacesEditeur')
         @include('home-v2.components.espace_next_level.04_EspacesApi')
         @include('home-v2.components.espace_next_level.05_EspacesFormulaire')
         @include('home-v2.components.espace_next_level.06_Espaces_Performance_SEO')
         @include('home-v2.components.espace_next_level.07_Espaces_Tele_Positionnement')
      

        <div id="section-vedettes" class="snb-anchor"></div>
        @include('home-v2.components.EventsVedette')

        <div id="section-restaurants" class="snb-anchor"></div>
        {{-- EntÃªte standard restaurant â€” autonome, hors template --}}
        @include('home-v2.components.RestaurantAmbianceVedetteV2')

        <div id="section-voyages" class="snb-anchor"></div>
        @include('home-v2.components.TravelPackages')
        @include('home-v2.components.TravelInfos')
        @include('home-v2.components.TourismSection')


        <div id="section-marketplace" class="snb-anchor"></div>
        @include('home-v2.components.SpecializedSpacesSection')
        @include('home-v2.components.RealEstateSection')
        @include('home-v2.components.ProductsVedette')

        <div id="section-a-la-une" class="snb-anchor"></div>
        @include('home-v2.components.NewsSection')

        <div id="section-nos-plans" class="snb-anchor"></div>
        @include('home-v2.components.NosPlans')
        @include('home-v2.components.MarketFoodVedette')
        @include('home-v2.components.LocationVehiculesVedette')
        @include('home-v2.components.ChassePecheVedette')
    </main>
    
    {{-- Modal rÃ©servation global Table & Vin --}}
    @include('home-v2.components.ResaModal')

    {{-- Modal vidÃ©o rÃ©utilisable pour toute la plateforme --}}
    @include('components.VideoModal')
    
    @include('components.front.call-action')
    @include('chat.index')
    @include('home-v2.components.ButtonTop')
    @include('home-v2.components.Footer')
    
    <script src="{{ asset('js/home-v2/carousel.js') }}"></script>
    <script src="{{ asset('js/home-v2/navigation.js') }}"></script>
    {{-- Charger le service API pour les menus EN PREMIER --}}
    <script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
    {{-- Charger le service API pour le mega menu destinations --}}
    <script src="{{ asset('js/home-v2/mega-menu-service.js') }}"></script>
    {{-- Charger le menu vertical dynamique --}}
    <script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
    {{-- Charger le contrÃ´leur du menu vertical (gestion accordÃ©on et vidÃ©os) --}}
    <script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
    {{-- Charger le mega menu Destinations pour le menu vertical --}}
    <script src="{{ asset('js/home-v2/vertical-destinations-mega.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/destinations-mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/destinations-search.js') }}"></script>
    <script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
    {{-- Charger le service API pour la carte interactive --}}
    {{-- Charger video-modal.js EN PREMIER car les autres composants en dÃ©pendent --}}
    <script src="{{ asset('js/video-modal.js') }}"></script>
    <script src="{{ asset('js/home-v2/viewing-carousel.js') }}"></script>
    <script src="{{ asset('js/home-v2/videos-dropdown.js') }}"></script>
    <script src="{{ asset('js/home-v2/espace-chat-section.js') }}"></script>
    <script src="{{ asset('js/home-v2/espace-mail-marketing-section.js') }}"></script>
    <script src="{{ asset('js/home-v2/espace-blog-section.js') }}"></script>
    <script src="{{ asset('js/home-v2/slideshows.js') }}"></script>
    <script src="{{ asset('js/home-v2/video-player.js') }}"></script>
    <script src="{{ asset('js/home-v2/events-vedette.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="{{ asset('js/home-v2/business-tourism.js') }}"></script>
    <script src="{{ asset('js/home-v2/partners-master.js') }}"></script>
</body>
</html>
