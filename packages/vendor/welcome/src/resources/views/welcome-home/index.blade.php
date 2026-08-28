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

    {{-- Détecte au plus tôt si le skeleton a déjà été montré (1re visite uniquement) --}}
    <script>
        (function () {
            try {
                if (localStorage.getItem('goexp_home_seen') === '1') {
                    document.documentElement.classList.add('home-skeleton-seen');
                }
            } catch (e) {}
        })();
    </script>

    {{-- Préconnexion aux CDN tiers pour accélérer le premier rendu --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://unpkg.com" crossorigin>
    {{-- Police chargée sans bloquer le rendu --}}
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"></noscript>

    {{-- Font Awesome chargé sans bloquer le rendu (bascule en feuille de style au chargement) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></noscript>
    
    {{-- ⚡ OPTIMISATION : 42 feuilles CSS combinées en 1 seule requête (cache-busting auto via filemtime) --}}
    <link rel="stylesheet" href="{{ asset('css/welcome/welcome.bundle.css') }}?v={{ @filemtime(public_path('css/welcome/welcome.bundle.css')) ?: '1' }}">
    {{-- Assets non critiques (modal vidéo + carte) chargés sans bloquer le rendu --}}
    <link rel="stylesheet" href="{{ asset('css/video-modal.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    </noscript>
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

    {{-- ── Skeleton : header + hero s'affichent IMMÉDIATEMENT. Le skeleton se superpose (overlay)
         uniquement au contenu SOUS le hero, sans le retirer du flux (JS sliders/carte OK). ── --}}
    <style id="home-skeleton-style">
        #home-below-fold { position: relative; }
        #home-skeleton {
            position: absolute; top: 0; left: 0; right: 0; min-height: 100vh;
            background: #ffffff; z-index: 40; padding: 24px 0 40px; overflow: hidden;
            opacity: 1; transition: opacity .4s ease;
        }
        #home-skeleton.is-hidden { opacity: 0; pointer-events: none; }
        /* Visite déjà vue : aucun skeleton, contenu direct */
        html.home-skeleton-seen #home-skeleton { display: none !important; }

        .hs-wrap { max-width: 1440px; margin: 0 auto; padding: 0 clamp(12px, 2.4vw, 32px); }
        .hs-block { position: relative; overflow: hidden; background: #eceff3; border-radius: 12px; }
        .hs-block::after {
            content: ""; position: absolute; inset: 0; transform: translateX(-100%);
            background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,.65) 50%, rgba(255,255,255,0) 100%);
            animation: hs-shimmer 1.35s infinite;
        }
        @keyframes hs-shimmer { 100% { transform: translateX(100%); } }
        .hs-pills { display: flex; gap: 12px; flex-wrap: wrap; margin: 8px 0 22px; }
        .hs-pills .hs-block { width: 120px; height: 38px; border-radius: 20px; }
        .hs-title { width: 320px; max-width: 70%; height: 30px; margin: 30px auto 22px; border-radius: 8px; }
        .hs-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
        .hs-card { height: 220px; border-radius: 14px; }
        @media (max-width: 1200px) { .hs-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 992px) { .hs-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; } }
        @media (max-width: 560px) { .hs-grid { grid-template-columns: 1fr; } .hs-card { height: 180px; } .hs-pills .hs-block { width: 96px; height: 34px; } }
    </style>
    <noscript><style>#home-skeleton{display:none!important}#home-below-fold{display:block!important}</style></noscript>
</head>
<body>
    {{-- Le skeleton n'est plus un overlay plein écran : header + hero s'affichent d'abord.
         Le skeleton du contenu inférieur est injecté plus bas, juste sous le hero. --}}
    <script>
        (function () {
            var root = document.documentElement;
            /* Visite déjà vue : contenu direct, aucun skeleton */
            if (root.classList.contains('home-skeleton-seen')) { return; }
            var done = false;
            function ready() {
                if (done) return; done = true;
                try { localStorage.setItem('goexp_home_seen', '1'); } catch (e) {}
                var sk = document.getElementById('home-skeleton');
                if (!sk) return;
                sk.classList.add('is-hidden'); /* fond du skeleton s'estompe → contenu déjà en place dessous */
                window.setTimeout(function () { if (sk.parentNode) sk.parentNode.removeChild(sk); }, 450);
            }
            if (document.readyState === 'interactive' || document.readyState === 'complete') {
                window.requestAnimationFrame(ready);
            } else {
                document.addEventListener('DOMContentLoaded', function () { window.requestAnimationFrame(ready); });
            }
            window.setTimeout(ready, 3000); /* filet de sécurité */
        })();
    </script>

    @include('welcome-home.components.VerticalMenu')
    @include('welcome-home.components.Header')
    
    <main class="main-content">
        <div class="{{ $destinationContext ? 'destination-hero-wrapper' : '' }}">
            @include('welcome-home.components.Hero')
        </div>

        {{-- Tout le contenu sous le hero reste dans le flux (JS sliders/carte fonctionnent),
             le skeleton se superpose par-dessus jusqu'à ce que la page soit prête. --}}
        <div id="home-below-fold">
        <div id="home-skeleton" aria-hidden="true" role="presentation">
            <div class="hs-wrap">
                <div class="hs-pills">
                    <div class="hs-block"></div><div class="hs-block"></div><div class="hs-block"></div><div class="hs-block"></div><div class="hs-block"></div>
                </div>
                <div class="hs-block hs-title"></div>
                <div class="hs-grid">
                    <div class="hs-block hs-card"></div><div class="hs-block hs-card"></div><div class="hs-block hs-card"></div><div class="hs-block hs-card"></div>
                </div>
                <div class="hs-block hs-title"></div>
                <div class="hs-grid">
                    <div class="hs-block hs-card"></div><div class="hs-block hs-card"></div><div class="hs-block hs-card"></div><div class="hs-block hs-card"></div>
                </div>
            </div>
        </div>

        @if($destinationContext)
            {{-- Même carte que la page destination (/travel-destination/continent/…) --}}
            @include('geo-map::index')
        @endif

        @include('welcome-home.components.SectionsNavBar')

        <div id="section-medias" class="snb-anchor"></div>
        
        <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> GO EXPLORIA ESPACES MÉDIAS </h1>
        <hr></hr>
            @include('welcome-home.components.SectionNavbarEspaceMedia')
        
        
        @unless($destinationContext)
            @isset($naMap)
                @include('welcome-home.components.espace_media.TravelMapAmeriqueNord')
            @else
                @include('geo-map::index')
            @endisset
        @endunless

        {{-- Carrousel d'annonces (cards) sous la carte --}}
        @include('components.ads-cards', ['adContext' => 'home'])
        {{-- ══════════════════════════════════════════════════════════════════
             SECTIONS APRÈS LA CARTE — rendues DYNAMIQUEMENT depuis l'admin
             (Constructeur /welcome : tables welcome_zones / welcome_sections).
             Chaque section : contenu édité en GrapeJS (content_source='builder')
             ou composant Blade d'origine ('view'). L'ordre et la visibilité
             (is_active) sont pilotés depuis l'admin. Repli automatique sur le
             rendu d'origine si la table est vide ou indisponible.
             ══════════════════════════════════════════════════════════════════ --}}
        @php
            try {
                $welcomeZones = \App\Models\WelcomeZone::query()
                    ->where('is_active', true)
                    ->orderBy('order')->orderBy('id')
                    ->with(['sections' => function ($q) {
                        $q->where('is_active', true)->orderBy('order')->orderBy('id');
                    }])
                    ->get();
            } catch (\Throwable $e) {
                $welcomeZones = collect();
            }
        @endphp

        @forelse($welcomeZones as $wZone)
            {{-- L'entête de la zone "medias" est déjà affichée avant la carte --}}
            @unless($wZone->key === 'medias')
                <div id="{{ $wZone->anchor ?: 'section-'.$wZone->key }}" class="snb-anchor"></div>
                <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> {{ $wZone->title }} </h1>
                <hr>
            @endunless

            @foreach($wZone->sections as $wSection)
                @if($wSection->content_source === 'builder' && filled($wSection->html_content))
                    @if(filled($wSection->css_content))<style>{!! $wSection->css_content !!}</style>@endif
                    {!! $wSection->html_content !!}
                    @if(filled($wSection->js_content))<script>{!! $wSection->js_content !!}</script>@endif
                @elseif($wSection->view && view()->exists($wSection->view))
                    {{-- $wsData : données saisies dans le constructeur pour cette
                         section (welcome_sections.settings). Les composants les
                         superposent à leurs valeurs d'origine via
                         gx_section_data() ; un composant qui ne s'en sert pas
                         continue de fonctionner à l'identique. --}}
                    @include($wSection->view, ['wsData' => $wSection->settings ?? []])
                @endif
            @endforeach
        @empty
            {{-- ── Repli : rendu d'origine (table welcome_sections vide/indisponible) ── --}}
            @include('welcome-home.components.espace_media.VideoPlayer')
            @include('welcome-home.components.espace_media.ViewingCarousel')
            @include('welcome-home.components.espace_media.TikTokCarousel')
            @include('welcome-home.components.espace_media.GallerieCaroussel')
            @include('welcome-home.components.espace_media.slideshows')
            @include('welcome-home.components.espace_media.MultilingualGrid')
            @include('welcome-home.components.espace_media.EspaceSocialMediaSection')
            @include('welcome-home.components.espace_media.AvisClientsSection')
            @include('welcome-home.components.espace_media.EspacesTemplatesSection')
            @include('welcome-home.components.espace_media.EspaceMailMarketingSection')
            @include('welcome-home.components.espace_media.EspaceChatSection')
            @include('welcome-home.components.espace_media.EspaceBlogSection')

            <div id="section-next-level" class="snb-anchor"></div>
            <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> GO EXPLORIA NEXT LEVEL </h1>
            <hr>
            @include('welcome-home.components.espace_next_level.01_AgencySection')
            @include('welcome-home.components.espace_next_level.02_PlansNextLevel')
            @include('welcome-home.components.espace_next_level.03_EspacesEditeur')
            @include('welcome-home.components.espace_next_level.04_EspacesApi')
            @include('welcome-home.components.espace_next_level.05_EspacesFormulaire')
            @include('welcome-home.components.espace_next_level.06_Espaces_Performance_SEO')
            @include('welcome-home.components.espace_next_level.07_Espaces_Tele_Positionnement')

            <div id="section-restaurants" class="snb-anchor"></div>
            <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> ESPACES RESTAURANTS ET ALIMENTATIONS </h1>
            <hr>
            @include('welcome-home.components.espace_restaurant.RestaurantAmbianceVedetteV2')

            <div id="section-vedettes" class="snb-anchor"></div>
            <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> GO EXPLORIA ESPACES VEDETTES </h1>
            <hr>
            @include('welcome-home.components.espace_evenement_vidette.EventsVedette')
            @include('welcome-home.components.espace_evenement_vidette.VideoVedette')
            @include('welcome-home.components.espace_evenement_vidette.RestaurantVedette')
            @include('welcome-home.components.espace_evenement_vidette.DestinationVedette')
            @include('welcome-home.components.espace_evenement_vidette.HebergementVedette')
            @include('welcome-home.components.espace_evenement_vidette.ProduitVedette')
            @include('welcome-home.components.espace_evenement_vidette.EntrepriseVedette')
            @include('welcome-home.components.espace_evenement_vidette.GallerieVedette')

            <div id="section-marketplace" class="snb-anchor"></div>
            <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> ESPACES GO EXPLORIA MARKETPLACE </h1>
            <hr>
            @include('welcome-home.components.espace_marketplace.RealEstateSection')
            @include('welcome-home.components.espace_marketplace.ProductsVedette')
            @include('welcome-home.components.espace_marketplace.CertificatsCartesCadeaux')

            <div id="section-voyages" class="snb-anchor"></div>
            <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> ESPACES GO EXPLORIA ESPACES VOYAGES & FORFAITS TOURISTIQUE INTERNATIONAL </h1>
            <hr>
            @include('welcome-home.components.espace_forfait.TravelPackages')
            @include('welcome-home.components.espace_forfait.TravelInfos')
            @include('welcome-home.components.espace_forfait.TourismSection')

            <div id="section-specialises" class="snb-anchor"></div>
            <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> ESPACES GO EXPLORIA ESPACES SPECIALISÉS </h1>
            <hr>
            @include('welcome-home.components.espace_specialisés.ImmobiliersQuebec')
            @include('welcome-home.components.espace_specialisés.ChaletsAVendre')
            @include('welcome-home.components.espace_specialisés.MaisonsChaletsAVendre')
            @include('welcome-home.components.espace_specialisés.ImmobilierTouristique')
            @include('welcome-home.components.espace_marketplace.MarketFoodVedette')
            @include('welcome-home.components.espace_marketplace.LocationVehiculesVedette')
            @include('welcome-home.components.espace_marketplace.ChassePecheVedette')

            <div id="section-a-la-une" class="snb-anchor"></div>
            <h1 class="resto-header-title" style="text-align: center;margin-top: 20px;"> ZONE GO EXPLORIA INFO </h1>
            <hr>
            @include('welcome-home.components.espace_go_exp_info.NewsSection')
            @include('welcome-home.components.espace_go_exp_info.bloc-nouvelles-regionales')
        @endforelse

        <div id="section-nos-plans" class="snb-anchor"></div>
        </div>{{-- /#home-below-fold --}}
    </main>
    
    {{-- Modal réservation global Table & Vin --}}
    @include('welcome-home.components.ResaModal')

    {{-- Modal vidéo réutilisable pour toute la plateforme --}}
    @include('components.VideoModal')
    
    {{-- Retirés de /welcome : bouton « Contact » (btn btn-primary btn-sm) + sa modale, et le chatbot (chatbotToggle) --}}
    {{-- @include('components.front.call-action') --}}
    {{-- @include('chat.index') --}}
    @include('welcome-home.components.ButtonTop')
    @include('welcome-home.components.Footer')

    {{-- Popup publicitaire rotatif (Ads Manager) --}}
    @include('components.ads-popup', ['adContext' => 'home'])
    
    <script defer src="{{ asset('js/welcome/carousel.js') }}"></script>
    <script defer src="{{ asset('js/welcome/navigation.js') }}"></script>
    {{-- Charger le service API pour les menus EN PREMIER --}}
    <script defer src="{{ asset('js/welcome/menu-api-service.js') }}"></script>
    {{-- Charger le service API pour le mega menu destinations --}}
    <script defer src="{{ asset('js/welcome/mega-menu-service.js') }}"></script>
    {{-- Charger le menu vertical dynamique --}}
    <script defer src="{{ asset('js/welcome/vertical-menu-dynamic.js') }}"></script>
    {{-- Charger le contrôleur du menu vertical (gestion accordéon et vidéos) --}}
    <script defer src="{{ asset('js/welcome/vertical-menu.js') }}"></script>
    {{-- Charger le mega menu Destinations pour le menu vertical --}}
    <script defer src="{{ asset('js/welcome/vertical-destinations-mega.js') }}"></script>
    <script defer src="{{ asset('js/welcome/mega-menu.js') }}"></script>
    <script defer src="{{ asset('js/welcome/destinations-mega-menu.js') }}?v={{ @filemtime(public_path('js/welcome/destinations-mega-menu.js')) ?: '1' }}"></script>
    <script defer src="{{ asset('js/welcome/destinations-search.js') }}"></script>
    <script defer src="{{ asset('js/welcome/search-bar.js') }}"></script>
    {{-- Charger le service API pour la carte interactive --}}
    {{-- Charger video-modal.js EN PREMIER car les autres composants en dépendent --}}
    <script defer src="{{ asset('js/video-modal.js') }}"></script>
    <script defer src="{{ asset('js/welcome/viewing-carousel.js') }}"></script>
    <script defer src="{{ asset('js/welcome/videos-dropdown.js') }}"></script>
    <script defer src="{{ asset('js/welcome/espace-chat-section.js') }}"></script>
    <script defer src="{{ asset('js/welcome/espace-mail-marketing-section.js') }}"></script>
    <script defer src="{{ asset('js/welcome/espace-blog-section.js') }}"></script>
    <script defer src="{{ asset('js/welcome/slideshows.js') }}"></script>
    <script defer src="{{ asset('js/welcome/video-player.js') }}"></script>
    <script defer src="{{ asset('js/welcome/events-vedette.js') }}"></script>
    <script defer src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script defer src="{{ asset('js/welcome/business-tourism.js') }}"></script>
    <script defer src="{{ asset('js/welcome/partners-master.js') }}"></script>
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
