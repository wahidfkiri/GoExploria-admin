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
