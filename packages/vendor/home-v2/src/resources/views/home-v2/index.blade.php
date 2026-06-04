@php
    $destinationContext = $destinationContext ?? null;
    $destinationName = $destinationContext['name'] ?? null;
    $destinationTitleSuffix = $destinationContext['title_suffix'] ?? ($destinationName ? ' pour ' . $destinationName : '');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $destinationName ? __('home-v2.home.meta_description') . ' - ' . $destinationName : __('home-v2.home.meta_description') }}">
    <title>{{ $destinationName ? __('home-v2.home.meta_title') . ' - ' . $destinationName : __('home-v2.home.meta_title') }}</title>
    
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
    @if($destinationName)
        <style>
            .destination-title-suffix {
                display: inline-block;
                color: #1677ff;
                margin-left: 10px;
                font-weight: 900;
            }
        </style>
    @endif
    <style>
        .home-v2-responsive-guard,
        .main-content,
        .main-content > * {
            max-width: 100%;
        }

        html,
        body {
            overflow-x: hidden;
        }

        .main-content section,
        .main-content .container,
        .main-content .row {
            max-width: 100%;
        }

        .main-content .resto-header-block,
        .main-content .resto-header-destinations-bar,
        .main-content .resto-dest-row,
        .main-content .resto-actions-row,
        .main-content .vp-dest-breadcrumb,
        .main-content .products-vedette-v2-scroll-wrapper,
        .main-content .events-vedette-v2-scroll-wrapper {
            min-width: 0;
            max-width: 100%;
        }

        .main-content .vp-dest-breadcrumb {
            overflow: hidden;
        }

        .main-content .vp-dest-select,
        .main-content .resto-dest-select {
            min-width: 0;
            max-width: 100%;
        }

        #geo-carte-videos {
            width: 100%;
            max-width: min(100%, 1440px);
            padding-left: clamp(12px, 2.4vw, 32px);
            padding-right: clamp(12px, 2.4vw, 32px);
        }

        #geo-carte-videos .row {
            margin-left: 0;
            margin-right: 0;
        }

        #geo-carte-videos .app-container {
            isolation: isolate;
        }

        #geo-carte-videos .sidebar-right {
            max-width: min(350px, calc(100% - 72px));
        }

        #resto-ambiance-vedette-v2 .products-vedette-v2-scroll-wrapper,
        #resto-ambiance-vedette-v2 .products-vedette-v2-carousel {
            overflow: hidden;
        }

        #resto-ambiance-vedette-v2 .resto-card-name,
        #resto-ambiance-vedette-v2 .resto-card-desc,
        #resto-ambiance-vedette-v2 .resto-card-accord,
        #resto-ambiance-vedette-v2 .resto-card-subcategory {
            overflow-wrap: anywhere;
        }

        @media (max-width: 1200px) {
            .main-content .resto-header-main {
                grid-template-columns: minmax(0, 1fr) !important;
                gap: 16px;
            }

            .main-content .resto-header-center,
            .main-content .resto-header-logo-left,
            .main-content .resto-header-logo-right {
                grid-column: auto !important;
                width: 100%;
                max-width: 100%;
                justify-self: center;
            }

            .main-content .resto-header-logo-left,
            .main-content .resto-header-logo-right {
                display: flex;
                justify-content: center;
            }

            #resto-ambiance-vedette-v2 .resto-header-logo-left {
                display: none !important;
            }
        }

        @media (max-width: 992px) {
            .main-content .resto-header-destinations-bar {
                padding: 12px clamp(12px, 3vw, 20px);
            }

            .main-content .resto-dest-row {
                align-items: stretch;
            }

            .main-content .resto-dest-icon-box {
                width: 100%;
                justify-content: center;
            }

            .main-content .resto-dest-breadcrumb.vp-dest-breadcrumb,
            #geo-carte-videos .resto-dest-breadcrumb {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
                width: 100%;
                overflow: visible;
            }

            .main-content .resto-dest-sep {
                display: none;
            }

            .main-content .vp-dest-select,
            .main-content .resto-dest-select {
                width: 100%;
                min-width: 0 !important;
                max-width: none !important;
                font-size: 11px;
            }

            .main-content .resto-actions-row {
                justify-content: flex-start;
            }

            .main-content .resto-header-ctas,
            .main-content .events-vedette-v2-filters,
            .main-content .products-vedette-v2-filters {
                width: 100%;
                overflow-x: auto;
                flex-wrap: nowrap;
                justify-content: flex-start;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }

            .main-content .resto-header-ctas::-webkit-scrollbar,
            .main-content .events-vedette-v2-filters::-webkit-scrollbar,
            .main-content .products-vedette-v2-filters::-webkit-scrollbar {
                display: none;
            }

            #geo-carte-videos.container {
                margin-top: 28px !important;
            }

            #geo-carte-videos .section-title,
            #geo-carte-videos .resto-header-title {
                font-size: clamp(18px, 5vw, 30px);
                line-height: 1.15;
            }

            #geo-carte-videos .resto-header-center h2 {
                font-size: clamp(13px, 3.2vw, 18px);
                line-height: 1.35;
            }

            #geo-carte-videos .app-container {
                height: auto;
                min-height: 0;
                overflow: visible;
                border-radius: 16px;
            }

            #geo-carte-videos .map-container {
                position: relative;
                height: min(62vh, 480px);
                min-height: 360px;
                border-radius: 16px;
                overflow: hidden;
            }

            #geo-carte-videos #map {
                min-height: 360px;
            }

            #geo-carte-videos .sidebar-right {
                position: relative;
                inset: auto;
                width: 100%;
                max-width: 100%;
                max-height: none;
                transform: none !important;
                z-index: 1;
                border-radius: 0 0 16px 16px;
            }

            #geo-carte-videos .sidebar-toggle {
                display: none;
            }

            #geo-carte-videos .filters-section {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
                padding: 14px;
            }

            #geo-carte-videos .filter-group {
                margin-bottom: 0;
            }

            #geo-carte-videos .filters-section .stats {
                grid-column: 1 / -1;
                margin-top: 0;
            }

            #geo-carte-videos .places-list {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
                padding: 14px;
            }

            #geo-carte-videos .place-item {
                margin-bottom: 0;
            }

            #resto-ambiance-vedette-v2 .resto-header-tabs {
                width: 100%;
                overflow-x: auto;
                flex-wrap: nowrap;
                justify-content: flex-start;
                padding-bottom: 4px;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }

            #resto-ambiance-vedette-v2 .resto-header-tabs::-webkit-scrollbar {
                display: none;
            }

            #resto-ambiance-vedette-v2 .resto-tab-btn {
                flex: 0 0 auto;
                white-space: nowrap;
            }

            #resto-ambiance-vedette-v2 .products-vedette-v2-scroll-container {
                gap: 14px;
            }

            #resto-ambiance-vedette-v2 .resto-ambiance-v2-card {
                min-width: min(260px, 58vw);
                max-width: min(260px, 58vw);
            }

            #resto-ambiance-vedette-v2 .resto-ambiance-v2-card .resto-card-img {
                height: 190px;
            }
        }

        @media (max-width: 640px) {
            .main-content > h1.resto-header-title {
                font-size: 18px !important;
                line-height: 1.2;
                padding: 0 14px;
                overflow-wrap: anywhere;
            }

            .main-content .resto-header-block {
                border-radius: 0 0 14px 14px;
                overflow: hidden;
            }

            .main-content .resto-header-main {
                padding-left: 12px;
                padding-right: 12px;
            }

            .main-content .resto-header-title {
                font-size: clamp(16px, 5vw, 22px);
                line-height: 1.18;
                overflow-wrap: anywhere;
            }

            .main-content .resto-header-subtitle {
                font-size: 12px;
                line-height: 1.45;
            }

            .main-content .resto-dest-breadcrumb.vp-dest-breadcrumb,
            #geo-carte-videos .resto-dest-breadcrumb {
                grid-template-columns: 1fr;
            }

            .main-content .resto-actions-row {
                align-items: stretch;
            }

            .main-content .resto-cta-btn,
            .main-content .resto-plans-btn,
            .main-content .resto-events-nav-btn {
                width: 100%;
                min-width: 0;
            }

            #geo-carte-videos {
                padding-left: 10px;
                padding-right: 10px;
            }

            #geo-carte-videos .map-container {
                height: 420px;
                min-height: 420px;
            }

            #geo-carte-videos #map {
                min-height: 420px;
            }

            #geo-carte-videos .filters-section,
            #geo-carte-videos .places-list {
                grid-template-columns: 1fr;
            }

            #geo-carte-videos .place-actions {
                flex-direction: column;
            }

            #geo-carte-videos .leaflet-popup-content {
                min-width: 220px;
            }

            #geo-carte-videos .modal-content {
                width: calc(100% - 20px);
                margin: 20px auto;
                border-radius: 14px;
            }

            #resto-ambiance-vedette-v2 .products-vedette-v2-container,
            #resto-ambiance-vedette-v2 .vedette-carousel-outer {
                padding-left: 8px;
                padding-right: 8px;
            }

            #resto-ambiance-vedette-v2 .products-vedette-v2-scroll-container {
                gap: 12px;
            }

            #resto-ambiance-vedette-v2 .resto-ambiance-v2-card {
                min-width: 78vw;
                max-width: 78vw;
            }

            #resto-ambiance-vedette-v2 .resto-ambiance-v2-card .resto-card-img {
                height: min(58vw, 230px);
            }

            #resto-ambiance-vedette-v2 .resto-card-footer {
                align-items: stretch;
                flex-direction: column;
                gap: 8px;
            }

            #resto-ambiance-vedette-v2 .resto-card-reserve-btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 420px) {
            #resto-ambiance-vedette-v2 .resto-ambiance-v2-card {
                min-width: 84vw;
                max-width: 84vw;
            }

            #geo-carte-videos .map-container,
            #geo-carte-videos #map {
                min-height: 380px;
                height: 380px;
            }
        }
    </style>
</head>
<body>
    @include('home-v2.components.VerticalMenu')
    @include('home-v2.components.Header')
    
    <main class="main-content">
        <div class="{{ $destinationContext ? 'destination-hero-wrapper' : '' }}">
            @include('home-v2.components.Hero')
        </div>

        @if($destinationContext)
            @include('geo-map::index')
        @endif

        @include('home-v2.components.SectionsNavBar')

        <div id="section-medias" class="snb-anchor"></div>
        
        <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> GO EXPLORIA ESPACES MÉDIAS </h1>
        <hr></hr>
            @include('home-v2.components.SectionNavbarEspaceMedia')
        
        @include('home-v2.components.espace_media.BusinessTourism')
        @unless($destinationContext)
            @include('geo-map::index')
        @endunless
        @include('home-v2.components.espace_media.VideoPlayer')
        @include('home-v2.components.espace_media.ViewingCarousel')
        @include('home-v2.components.espace_media.TikTokCarousel')
        @include('home-v2.components.espace_media.GallerieCaroussel')
        @include('home-v2.components.espace_media.slideshows')
        @include('home-v2.components.espace_media.MultilingualGrid')
        @include('home-v2.components.espace_media.EspaceSocialMediaSection')
        @include('home-v2.components.espace_media.AvisClientsSection')
        @include('home-v2.components.espace_media.EspacesTemplatesSection')
        @include('home-v2.components.espace_media.EspaceMailMarketingSection')
        @include('home-v2.components.espace_media.EspaceChatSection')
        @include('home-v2.components.espace_media.EspaceBlogSection')


        <div id="section-next-level" class="snb-anchor"></div>
       <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> GO EXPLORIA NEXT LEVEL </h1>
        <hr></hr>

         @include('home-v2.components.espace_next_level.01_AgencySection')
         @include('home-v2.components.espace_next_level.02_PlansNextLevel')
         @include('home-v2.components.espace_next_level.03_EspacesEditeur')
         @include('home-v2.components.espace_next_level.04_EspacesApi')
         @include('home-v2.components.espace_next_level.05_EspacesFormulaire')
         @include('home-v2.components.espace_next_level.06_Espaces_Performance_SEO')
         @include('home-v2.components.espace_next_level.07_Espaces_Tele_Positionnement')
      
      

        <div id="section-restaurants" class="snb-anchor"></div>
        <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> ESPACES RESTAURANTS ET ALIMENTATIONS </h1>
        <hr></hr>
        {{-- Entete standard restaurant autonome, hors template --}}
        @include('home-v2.components.espace_restaurant.RestaurantAmbianceVedetteV2')


        <div id="section-vedettes" class="snb-anchor"></div>
        <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> GO EXPLORIA ESPACES VEDETTES </h1>
        <hr></hr>
        @include('home-v2.components.espace_evenement_vidette.EventsVedette')
        @include('home-v2.components.espace_evenement_vidette.VideoVedette')
        @include('home-v2.components.espace_evenement_vidette.RestaurantVedette')
        @include('home-v2.components.espace_evenement_vidette.DestinationVedette')
        @include('home-v2.components.espace_evenement_vidette.HebergementVedette')
        @include('home-v2.components.espace_evenement_vidette.ProduitVedette')
        @include('home-v2.components.espace_evenement_vidette.EntrepriseVedette')
        @include('home-v2.components.espace_evenement_vidette.GallerieVedette')

        <div id="section-marketplace" class="snb-anchor"></div>
        <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> ESPACES GO EXPLORIA MARKETPLACE </h1>
        <hr></hr>

        @include('home-v2.components.espace_marketplace.RealEstateSection')
        @include('home-v2.components.espace_marketplace.ProductsVedette')
        @include('home-v2.components.espace_marketplace.CertificatsCartesCadeaux')

           
        <div id="section-voyages" class="snb-anchor"></div>
         <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> ESPACES GO EXPLORIA ESPACES VOYAGES & FORFAITS TOURISTIQUE INTERNATIONAL </h1>
        <hr></hr>

        @include('home-v2.components.espace_forfait.TravelPackages')
        @include('home-v2.components.espace_forfait.TravelInfos')
        @include('home-v2.components.espace_forfait.TourismSection')


        <div id="section-specialises" class="snb-anchor"></div>
         <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> ESPACES GO EXPLORIA ESPACES SPECIALISÉS </h1>
        <hr></hr>

        @include('home-v2.components.espace_specialisés.ImmobiliersQuebec')
        @include('home-v2.components.espace_specialisés.ChaletsAVendre')
        @include('home-v2.components.espace_specialisés.MaisonsChaletsAVendre')
        @include('home-v2.components.espace_specialisés.ImmobilierTouristique')
        @include('home-v2.components.espace_marketplace.MarketFoodVedette')
        @include('home-v2.components.espace_marketplace.LocationVehiculesVedette')
        @include('home-v2.components.espace_marketplace.ChassePecheVedette')

        <div id="section-a-la-une" class="snb-anchor"></div>
         <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> ZONE GO EXPLORIA INFO </h1>
        <hr></hr>
        @include('home-v2.components.espace_go_exp_info.NewsSection')
        @include('home-v2.components.espace_go_exp_info.bloc-nouvelles-regionales')

        <div id="section-nos-plans" class="snb-anchor"></div>   
    </main>
    
    {{-- Modal réservation global Table & Vin --}}
    @include('home-v2.components.ResaModal')

    {{-- Modal vidéo réutilisable pour toute la plateforme --}}
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
    {{-- Charger le contrôleur du menu vertical (gestion accordéon et vidéos) --}}
    <script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
    {{-- Charger le mega menu Destinations pour le menu vertical --}}
    <script src="{{ asset('js/home-v2/vertical-destinations-mega.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/destinations-mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/destinations-search.js') }}"></script>
    <script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
    {{-- Charger le service API pour la carte interactive --}}
    {{-- Charger video-modal.js EN PREMIER car les autres composants en dépendent --}}
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
    @if($destinationName)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const destinationName = @json($destinationName);
                document.querySelectorAll('.resto-header-title').forEach(function (title) {
                    const text = title.textContent.trim();
                    if (text && !title.querySelector('.destination-title-suffix')) {
                        const suffix = document.createElement('span');
                        suffix.className = 'destination-title-suffix';
                        suffix.textContent = ' pour ' + destinationName;
                        title.appendChild(suffix);
                    }
                });
            });
        </script>
    @endif
</body>
</html>
