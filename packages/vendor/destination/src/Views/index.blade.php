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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
    <style>
        /* ============================================
           STYLE TOURISM MODERN - DESIGN BLEU/CYAN
        ============================================ */
       
      

        /* Layout deux colonnes */
        .two-columns-layout {
            display: flex;
            gap: 30px;
            margin-top: 30px;
        }

        .col-left {
            flex: 8;
            min-width: 0;
        }

        .col-right {
            flex: 4;
            min-width: 0;
        }

        /* ============================================
           SLIDER VIDEOS SECTION
        ============================================ */
        .videos-slider-section {
            background: white;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .slider-header {
            padding: 28px 32px;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
            color: white;
        }

        .slider-header h2 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .slider-header p {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 24px;
            max-width: 80%;
        }

        .btn-explore {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            padding: 12px 28px;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-explore:hover {
            background: white;
            color: #1e3a5f;
            transform: translateY(-2px);
        }

        .video-slider-container {
            padding: 30px 32px 40px;
        }

        .video-slider {
            display: flex;
            gap: 24px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 10px 5px 20px;
        }

        .video-slider::-webkit-scrollbar {
            height: 6px;
        }

        .video-slider::-webkit-scrollbar-track {
            background: #e0e0e0;
            border-radius: 10px;
        }

        .video-slider::-webkit-scrollbar-thumb {
            background: #1e3a5f;
            border-radius: 10px;
        }

        .video-card {
            flex: 0 0 340px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .video-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 40px -12px rgba(0,0,0,0.25);
        }

        .video-thumbnail {
            position: relative;
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .video-thumbnail::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.3);
        }

        .play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 56px;
            height: 56px;
            background: rgba(255,255,255,0.95);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e3a5f;
            font-size: 22px;
            transition: all 0.3s ease;
        }

        .video-card:hover .play-icon {
            transform: translate(-50%, -50%) scale(1.15);
        }

        .video-info {
            padding: 20px;
        }

        .video-info h4 {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #1e293b;
        }

        .video-info p {
            font-size: 13px;
            color: #64748b;
        }

        /* ============================================
           MAP CARD - STYLE TOURISM (BLEU/CYAN)
        ============================================ */
        .map-card-modern {
            background: white;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .map-header {
            padding: 24px 28px;
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: white;
        }

        .map-header h2 {
            font-size: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .map-header p {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 8px;
        }

        .map-filters {
            padding: 20px 28px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .filter-group label {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
        }

        .filter-group select {
            padding: 10px 16px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: white;
            font-family: inherit;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-group select:focus {
            outline: none;
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2,132,199,0.1);
        }

        .btn-locate {
            background: #0284c7;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-locate:hover {
            background: #0369a1;
            transform: translateY(-2px);
        }

        .results-count {
            margin-left: auto;
            font-size: 13px;
            color: #64748b;
            background: #f1f5f9;
            padding: 8px 16px;
            border-radius: 20px;
        }

        .results-count span {
            color: #0284c7;
            font-weight: 800;
        }

        .map-wrapper {
            height: 450px;
        }

        #interactiveMap {
            height: 100%;
            width: 100%;
        }

        /* Marqueurs personnalisés avec images en cercle */
        .custom-marker {
            background: transparent;
        }

        .marker-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: white;
            border: 3px solid #0284c7;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .marker-circle:hover {
            transform: scale(1.1);
            border-color: #0ea5e9;
        }

        .marker-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .marker-circle i {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0284c7, #0369a1);
            color: white;
            font-size: 20px;
        }

        .destinations-list {
            padding: 20px 28px;
            max-height: 350px;
            overflow-y: auto;
            background: #f8fafc;
        }

        .destinations-list h4 {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .destination-item {
            display: flex;
            gap: 15px;
            padding: 14px;
            border-radius: 16px;
            background: white;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.25s ease;
            border: 1px solid #e2e8f0;
        }

        .destination-item:hover {
            border-color: #0284c7;
            transform: translateX(8px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .destination-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            overflow: hidden;
            background: linear-gradient(135deg, #e0f2fe, #bae6fd);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .destination-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .destination-icon i {
            font-size: 24px;
            color: #0284c7;
        }

        .destination-details {
            flex: 1;
        }

        .destination-details h5 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #1e293b;
        }

        .destination-details p {
            font-size: 12px;
            color: #64748b;
        }

        /* ============================================
           HISTORIQUE SECTION
        ============================================ */
        .historique-section {
            background: white;
            border-radius: 28px;
            padding: 32px;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.08);
        }

        .historique-section h3 {
            font-size: 26px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .historique-section h3 i {
            color: #0284c7;
        }

        .historique-content {
            color: #475569;
            line-height: 1.8;
        }

        .historique-content p {
            margin-bottom: 18px;
        }

        /* ============================================
           SLIDER PUBLICITAIRE MULTI-VIDEOS
        ============================================ */
        .ads-slider-section {
            background: white;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .ads-header {
            padding: 20px 24px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .ads-header h3 {
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .swiper {
            width: 100%;
            padding: 24px;
        }

        .ad-slide {
            background: #f8fafc;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .ad-slide:hover {
            transform: translateY(-5px);
        }

        .ad-image {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .ad-play-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            background: rgba(0,0,0,0.7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            opacity: 0;
            transition: 0.3s;
        }

        .ad-slide:hover .ad-play-overlay {
            opacity: 1;
        }

        .ad-content {
            padding: 20px;
        }

        .ad-content h4 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #1e293b;
        }

        .ad-content p {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 15px;
        }

        .ad-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #0284c7;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
        }

        .ad-link:hover {
            gap: 12px;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #0284c7;
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 18px;
        }

        .swiper-pagination-bullet-active {
            background: #0284c7;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .two-columns-layout {
                flex-direction: column;
            }
            .main-content {
                padding: 20px;
            }
            .slider-header p {
                max-width: 100%;
            }
            .video-card {
                flex: 0 0 260px;
            }
            .map-filters {
                flex-direction: column;
                align-items: stretch;
            }
            .results-count {
                margin-left: 0;
                text-align: center;
            }
            .map-wrapper {
                height: 350px;
            }
        }
    </style>
</head>
<body>
    @include('home-v2.components.VerticalMenu')
    @include('home-v2.components.Header')
    
    <main class="main-content">
        
        <div class="two-columns-layout" style="margin-top: 120px;">
            
            <!-- COLONNE GAUCHE -->
            <div class="col-left">
                
                <!-- SLIDER VIDEOS -->
                <div class="videos-slider-section">
                    <div class="slider-header">
                        <h2>🎬 Découvrez le Québec en Vidéo</h2>
                    </div>
                    <div class="video-slider-container">
                        <div class="video-slider" id="videoSlider">
                            <div class="video-card" data-video="dQw4w9WgXcQ">
                                <div class="video-thumbnail" style="background-image: url('https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg')">
                                    <div class="play-icon"><i class="fas fa-play"></i></div>
                                </div>
                                <div class="video-info">
                                    <h4>Chutes Montmorency</h4>
                                    <p>Découvrez les impressionnantes chutes</p>
                                </div>
                            </div>
                            <div class="video-card" data-video="9bZkp7q19f0">
                                <div class="video-thumbnail" style="background-image: url('https://img.youtube.com/vi/9bZkp7q19f0/maxresdefault.jpg')">
                                    <div class="play-icon"><i class="fas fa-play"></i></div>
                                </div>
                                <div class="video-info">
                                    <h4>Vieux-Québec</h4>
                                    <p>Promenade dans les ruelles historiques</p>
                                </div>
                            </div>
                            <div class="video-card" data-video="OPf0YbXqDm0">
                                <div class="video-thumbnail" style="background-image: url('https://img.youtube.com/vi/OPf0YbXqDm0/maxresdefault.jpg')">
                                    <div class="play-icon"><i class="fas fa-play"></i></div>
                                </div>
                                <div class="video-info">
                                    <h4>Mont-Tremblant</h4>
                                    <p>Aventures en montagne</p>
                                </div>
                            </div>
                            <div class="video-card" data-video="L_jWHffIx5E">
                                <div class="video-thumbnail" style="background-image: url('https://img.youtube.com/vi/L_jWHffIx5E/maxresdefault.jpg')">
                                    <div class="play-icon"><i class="fas fa-play"></i></div>
                                </div>
                                <div class="video-info">
                                    <h4>Gaspésie</h4>
                                    <p>Les plus beaux paysages côtiers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARTE MODERNE - STYLE TOURISM -->
                <!-- CARTE MODERNE - STYLE TOURISM AVEC ZOOM DYNAMIQUE -->
<div class="map-card-modern">
    <div class="map-header">
        <h2><i class="fas fa-map-marked-alt"></i> Explorez le {{ $country->name }}</h2>
        <p>Restaurants, Musées, Hôtels et Activités</p>
    </div>
    <div class="map-filters">
        <div class="filter-group">
            <label><i class="fas fa-map-marker-alt"></i> Province :</label>
            <select id="regionFilter">
                <option value="">Toutes les provinces</option>
                @foreach($provinces as $province)
                    <option value="{{ $province->name }}" data-lat="{{ $province->latitude }}" data-lng="{{ $province->longitude }}">
                        {{ $province->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label><i class="fas fa-tag"></i> Catégorie :</label>
            <select id="categoryFilter">
                <option value="">Toutes</option>
                <option value="restaurant">🍽️ Restaurants</option>
                <option value="museum">🏛️ Musées</option>
                <option value="hotel">🏨 Hôtels</option>
                <option value="activity">🎯 Activités</option>
            </select>
        </div>
        <button class="btn-locate" id="locateBtn">
            <i class="fas fa-location-dot"></i> Me localiser
        </button>
        <button class="btn-reset" id="resetViewBtn">
            <i class="fas fa-globe-americas"></i> Vue pays
        </button>
        <div class="results-count">
            <i class="fas fa-map-pin"></i> <span id="resultsCount">0</span> lieux
        </div>
    </div>
    <div class="map-wrapper">
        <div id="interactiveMap"></div>
    </div>
    <div class="destinations-list">
        <h4><i class="fas fa-compass"></i> LIEUX À DÉCOUVRIR</h4>
        <div id="destinationsList"></div>
    </div>
</div>

<style>
    .btn-reset {
        background: #475569;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }
    .btn-reset:hover {
        background: #334155;
        transform: translateY(-2px);
    }
</style>


                <!-- HISTORIQUE -->
                <div class="historique-section">
                    <h3>
                        <i class="fas fa-landmark"></i>
                        {{$country->name}} : Un Voyage à Travers l'Histoire
                    </h3>
                    <div class="historique-content">
                        {!! $country->description !!}
                    </div>
                </div>
            </div>

            <!-- COLONNE DROITE -->
            <div class="col-right">
                
                <!-- SLIDER PUBLICITAIRE MULTI-VIDEOS -->
                <div class="ads-slider-section">
                    <div class="ads-header">
                        <h3><i class="fas fa-star"></i> Offres & Découvertes</h3>
                    </div>
                    <div class="swiper adsSwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide ad-slide" data-video="dQw4w9WgXcQ">
                                <div class="ad-image" style="background-image: url('https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg')">
                                    <div class="ad-play-overlay"><i class="fas fa-play"></i></div>
                                </div>
                                <div class="ad-content">
                                    <h4>Forfait Découverte</h4>
                                    <p>Explorez les Chutes Montmorency -25%</p>
                                    <a href="#" class="ad-link">Voir l'offre <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="swiper-slide ad-slide" data-video="9bZkp7q19f0">
                                <div class="ad-image" style="background-image: url('https://img.youtube.com/vi/9bZkp7q19f0/maxresdefault.jpg')">
                                    <div class="ad-play-overlay"><i class="fas fa-play"></i></div>
                                </div>
                                <div class="ad-content">
                                    <h4>Circuit Historique</h4>
                                    <p>Le Vieux-Québec en petit groupe</p>
                                    <a href="#" class="ad-link">Réserver <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="swiper-slide ad-slide" data-video="OPf0YbXqDm0">
                                <div class="ad-image" style="background-image: url('https://img.youtube.com/vi/OPf0YbXqDm0/maxresdefault.jpg')">
                                    <div class="ad-play-overlay"><i class="fas fa-play"></i></div>
                                </div>
                                <div class="ad-content">
                                    <h4>Aventure en Montagne</h4>
                                    <p>Ski et randonnées au Mont-Tremblant</p>
                                    <a href="#" class="ad-link">En savoir plus <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="swiper-slide ad-slide" data-video="L_jWHffIx5E">
                                <div class="ad-image" style="background-image: url('https://img.youtube.com/vi/L_jWHffIx5E/maxresdefault.jpg')">
                                    <div class="ad-play-overlay"><i class="fas fa-play"></i></div>
                                </div>
                                <div class="ad-content">
                                    <h4>Escapade en Gaspésie</h4>
                                    <p>Les plus beaux paysages côtiers</p>
                                    <a href="#" class="ad-link">Je réserve <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    @include('components.VideoModal')
    @include('components.front.call-action')
    @include('chat.index')
    @include('home-v2.components.ButtonTop')
    @include('home-v2.components.Footer')
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/home-v2/carousel.js') }}"></script>
    <script src="{{ asset('js/home-v2/navigation.js') }}"></script>
    <script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu-service.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
    <script src="{{ asset('js/video-modal.js') }}"></script>

    <script>
    // ============================================
    // DONNÉES PHP PASSÉES À JAVASCRIPT
    // ============================================
    const countryLat = {{ $country->latitude ?? 56.1304 }};
    const countryLng = {{ $country->longitude ?? -106.3468 }};
    const countryZoom = 3;
    
    // Provinces
    const provinces = [];
    <?php foreach($provinces as $province): ?>
    provinces.push({
        name: '<?php echo addslashes($province->name); ?>',
        latitude: <?php echo $province->latitude ? (float)$province->latitude : 'null'; ?>,
        longitude: <?php echo $province->longitude ? (float)$province->longitude : 'null'; ?>,
        zoom: 6
    });
    <?php endforeach; ?>
    
    // Points de la carte depuis la base de données
    const places = <?php echo json_encode($places); ?>;
    
    // ============================================
    // VARIABLES GLOBALES
    // ============================================
    let map;
    let markers = [];
    let userMarker = null;
    
    // ============================================
    // FONCTIONS UTILITAIRES
    // ============================================
    function getCategoryIconClass(category) {
        const icons = { 
            restaurant: 'fa-utensils', 
            museum: 'fa-landmark', 
            hotel: 'fa-hotel', 
            activity: 'fa-hiking',
            parc: 'fa-tree',
            shopping: 'fa-shopping-bag',
            culture: 'fa-theater-masks'
        };
        return icons[category] || 'fa-map-pin';
    }
    
    function getCategoryColor(category) {
        const colors = {
            restaurant: '#ef4444',
            museum: '#8b5cf6',
            hotel: '#3b82f6',
            activity: '#10b981',
            parc: '#22c55e',
            shopping: '#f59e0b',
            culture: '#ec4899'
        };
        return colors[category] || '#0284c7';
    }
    
    // ============================================
    // INITIALISATION DE LA CARTE
    // ============================================
    function initMap() {
        // Créer la carte centrée sur le pays
        map = L.map('interactiveMap').setView([countryLat, countryLng], countryZoom);
        
        // Ajouter le fond de carte (style light)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; CartoDB',
            subdomains: 'abcd',
            maxZoom: 19,
            minZoom: 3
        }).addTo(map);
        
        // Ajouter le contrôle de zoom
        map.zoomControl.setPosition('bottomright');
        
        // Mettre à jour les marqueurs et la liste
        updateMarkers();
        updateDestinationsList();
    }
    
    // ============================================
    // ZOOM SUR PROVINCE
    // ============================================
    function zoomToProvince(provinceName) {
        const province = provinces.find(p => p.name === provinceName);
        if (province && province.latitude && province.longitude) {
            map.setView([province.latitude, province.longitude], province.zoom || 7);
        }
    }
    
    // ============================================
    // RÉINITIALISER LA VUE PAYS
    // ============================================
    function resetToCountryView() {
        map.setView([countryLat, countryLng], countryZoom);
        const regionSelect = document.getElementById('regionFilter');
        if(regionSelect) regionSelect.value = '';
        updateMarkers();
        updateDestinationsList();
    }
    
    // ============================================
    // METTRE À JOUR LES MARQUEURS
    // ============================================
    function updateMarkers() {
        if(!map) return;
        
        // Supprimer les anciens marqueurs
        markers.forEach(m => {
            if(map && m) map.removeLayer(m);
        });
        markers = [];
        
        // Récupérer les filtres
        const provinceFilter = document.getElementById('regionFilter') ? document.getElementById('regionFilter').value : '';
        const categoryFilter = document.getElementById('categoryFilter') ? document.getElementById('categoryFilter').value : '';
        
        // Filtrer les lieux
        const filtered = places.filter(p => {
            if(provinceFilter && p.province !== provinceFilter) return false;
            if(categoryFilter && p.category !== categoryFilter) return false;
            return true;
        });
        
        // Mettre à jour le compteur
        const resultsSpan = document.getElementById('resultsCount');
        if(resultsSpan) resultsSpan.innerText = filtered.length;
        
        // Créer les nouveaux marqueurs
        filtered.forEach(place => {
            const markerColor = getCategoryColor(place.category);
            
            // HTML du marqueur personnalisé
            const markerHtml = `
                <div class="marker-circle" style="width:46px;height:46px;border-radius:50%;background:white;border:3px solid ${markerColor};box-shadow:0 4px 15px rgba(0,0,0,0.2);overflow:hidden;cursor:pointer;transition:transform 0.2s ease;">
                    ${place.image ? 
                        `<img src="${place.image}" alt="${place.name}" style="width:100%;height:100%;object-fit:cover;">` : 
                        `<i class="fas ${getCategoryIconClass(place.category)}" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,${markerColor},${markerColor}dd);color:white;font-size:20px;"></i>`
                    }
                </div>
            `;
            
            // Icône personnalisée
            const customIcon = L.divIcon({
                html: markerHtml,
                className: 'custom-marker',
                iconSize: [46, 46],
                popupAnchor: [0, -23]
            });
            
            // Créer le marqueur
            const marker = L.marker([parseFloat(place.lat), parseFloat(place.lng)], { icon: customIcon }).addTo(map);
            
            // Contenu du popup
            const popupContent = `
                <div style="min-width: 300px; max-width: 320px; border-radius: 16px; overflow: hidden; font-family: 'Montserrat', sans-serif;">
                    <div style="position: relative;">
                        <iframe width="100%" height="180" src="https://www.youtube.com/embed/${place.videoId || 'dQw4w9WgXcQ'}" frameborder="0" allowfullscreen style="border: none;"></iframe>
                    </div>
                    <div style="padding: 16px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                            <span style="background: ${markerColor}; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase;">${place.category}</span>
                            <span style="color: #64748b; font-size: 12px;"><i class="fas fa-map-marker-alt"></i> ${place.city || place.province}</span>
                        </div>
                        <h4 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 700; color: #1e293b;">${place.name}</h4>
                        <p style="margin: 0 0 12px 0; font-size: 13px; color: #64748b; line-height: 1.5;">${place.desc || 'Découvrez ce lieu exceptionnel'}</p>
                        ${place.adresse ? `<p style="margin: 0 0 12px 0; font-size: 12px; color: #94a3b8;"><i class="fas fa-location-dot"></i> ${place.adresse}</p>` : ''}
                        <div style="display: flex; gap: 10px; margin-top: 12px;">
                            ${place.has_details_page ? `<a href="${place.details_url || '#'}" class="popup-btn" style="flex:1;background:${markerColor};color:white;text-align:center;padding:8px;border-radius:10px;text-decoration:none;font-size:12px;font-weight:600;"><i class="fas fa-info-circle"></i> Détails</a>` : ''}
                            <a href="#" class="popup-btn itinerary-btn" data-lat="${place.lat}" data-lng="${place.lng}" style="flex:1;background:#f1f5f9;color:#475569;text-align:center;padding:8px;border-radius:10px;text-decoration:none;font-size:12px;font-weight:600;"><i class="fas fa-directions"></i> Itinéraire</a>
                        </div>
                    </div>
                </div>
            `;
            
            marker.bindPopup(popupContent);
            
            // Gestionnaire d'événement pour le bouton itinéraire
            marker.on('popupopen', function() {
                const itineraryBtn = document.querySelector('.itinerary-btn');
                if(itineraryBtn) {
                    itineraryBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const lat = this.dataset.lat;
                        const lng = this.dataset.lng;
                        window.open(`https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`, '_blank');
                    });
                }
            });
            
            markers.push(marker);
        });
    }
    
    // ============================================
    // METTRE À JOUR LA LISTE DES DESTINATIONS
    // ============================================
    function updateDestinationsList() {
        const provinceFilter = document.getElementById('regionFilter') ? document.getElementById('regionFilter').value : '';
        const categoryFilter = document.getElementById('categoryFilter') ? document.getElementById('categoryFilter').value : '';
        
        const filtered = places.filter(p => {
            if(provinceFilter && p.province !== provinceFilter) return false;
            if(categoryFilter && p.category !== categoryFilter) return false;
            return true;
        });
        
        const container = document.getElementById('destinationsList');
        if(!container) return;
        
        if(filtered.length === 0) {
            container.innerHTML = `
                <div style="text-align:center;padding:40px 20px;">
                    <i class="fas fa-map-marker-alt" style="font-size:48px;color:#cbd5e1;margin-bottom:16px;"></i>
                    <p style="color:#94a3b8;font-size:14px;">Aucun lieu trouvé</p>
                    <p style="color:#cbd5e1;font-size:12px;margin-top:8px;">Essayez de modifier vos filtres</p>
                </div>
            `;
            return;
        }
        
        container.innerHTML = filtered.map(place => {
            const markerColor = getCategoryColor(place.category);
            return `
                <div class="destination-item" onclick="focusOnPlace(${place.lat}, ${place.lng})" style="display:flex;gap:15px;padding:14px;border-radius:16px;background:white;margin-bottom:12px;cursor:pointer;transition:all 0.25s ease;border:1px solid #e2e8f0;">
                    <div class="destination-icon" style="width:52px;height:52px;border-radius:50%;overflow:hidden;background:linear-gradient(135deg,${markerColor}20,${markerColor}10);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        ${place.image ? 
                            `<img src="${place.image}" alt="${place.name}" style="width:100%;height:100%;object-fit:cover;">` : 
                            `<i class="fas ${getCategoryIconClass(place.category)}" style="font-size:24px;color:${markerColor};"></i>`
                        }
                    </div>
                    <div class="destination-details" style="flex:1;">
                        <h5 style="font-size:15px;font-weight:700;margin-bottom:5px;color:#1e293b;">${place.name}</h5>
                        <p style="font-size:12px;color:#64748b;margin-bottom:4px;"><i class="fas fa-map-marker-alt"></i> ${place.city || place.province}</p>
                        <p style="font-size:11px;color:#94a3b8;">${place.desc ? place.desc.substring(0, 60) : ''}${place.desc && place.desc.length > 60 ? '...' : ''}</p>
                    </div>
                </div>
            `;
        }).join('');
    }
    
    // ============================================
    // FOCUS SUR UN LIEU
    // ============================================
    function focusOnPlace(lat, lng) {
        if(!map) return;
        map.setView([parseFloat(lat), parseFloat(lng)], 14);
        setTimeout(() => {
            markers.forEach(marker => {
                const pos = marker.getLatLng();
                if(Math.abs(pos.lat - lat) < 0.0001 && Math.abs(pos.lng - lng) < 0.0001) {
                    marker.openPopup();
                }
            });
        }, 300);
    }
    
    // ============================================
    // OUVRIR LE MODAL VIDÉO
    // ============================================
    function openVideoModal(videoId) {
        const modal = document.getElementById('videoModal');
        const iframe = document.getElementById('videoIframe');
        if(modal && iframe && videoId) {
            iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
            modal.style.display = 'flex';
        }
    }
    
    function closeVideoModal() {
        const modal = document.getElementById('videoModal');
        const iframe = document.getElementById('videoIframe');
        if(modal && iframe) {
            iframe.src = '';
            modal.style.display = 'none';
        }
    }
    
    // ============================================
    // GÉOLOCALISATION
    // ============================================
    function locateUser() {
        const locateBtn = document.getElementById('locateBtn');
        if(locateBtn) {
            locateBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Localisation...';
            locateBtn.disabled = true;
        }
        
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    if(map) {
                        map.setView([lat, lng], 13);
                        
                        // Supprimer l'ancien marqueur utilisateur
                        if(userMarker) map.removeLayer(userMarker);
                        
                        // Ajouter un marqueur pour l'utilisateur
                        const userIcon = L.divIcon({
                            html: '<div style="width:36px;height:36px;border-radius:50%;background:#3b82f6;border:3px solid white;box-shadow:0 2px 10px rgba(0,0,0,0.2);display:flex;align-items:center;justify-content:center;"><i class="fas fa-user" style="color:white;font-size:16px;"></i></div>',
                            iconSize: [36, 36],
                            popupAnchor: [0, -18]
                        });
                        
                        userMarker = L.marker([lat, lng], { icon: userIcon }).addTo(map);
                        userMarker.bindPopup("📍 Vous êtes ici").openPopup();
                    }
                    
                    if(locateBtn) {
                        locateBtn.innerHTML = '<i class="fas fa-location-dot"></i> Me localiser';
                        locateBtn.disabled = false;
                    }
                },
                function(error) {
                    console.error("Erreur de géolocalisation:", error);
                    let errorMessage = "Impossible de vous localiser.";
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = "Permission refusée. Autorisez la géolocalisation.";
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = "Position non disponible.";
                            break;
                        case error.TIMEOUT:
                            errorMessage = "Délai dépassé.";
                            break;
                    }
                    alert(errorMessage);
                    if(locateBtn) {
                        locateBtn.innerHTML = '<i class="fas fa-location-dot"></i> Me localiser';
                        locateBtn.disabled = false;
                    }
                }
            );
        } else {
            alert("La géolocalisation n'est pas supportée par votre navigateur.");
            if(locateBtn) {
                locateBtn.innerHTML = '<i class="fas fa-location-dot"></i> Me localiser';
                locateBtn.disabled = false;
            }
        }
    }
    
    // ============================================
    // INITIALISATION DES ÉVÉNEMENTS
    // ============================================
    document.addEventListener('DOMContentLoaded', () => {
        // Initialiser la carte
        initMap();
        
        // Filtre par province
        const regionFilter = document.getElementById('regionFilter');
        if(regionFilter) {
            regionFilter.addEventListener('change', (e) => {
                const selectedProvince = e.target.value;
                if (selectedProvince) {
                    zoomToProvince(selectedProvince);
                }
                updateMarkers();
                updateDestinationsList();
            });
        }
        
        // Filtre par catégorie
        const categoryFilter = document.getElementById('categoryFilter');
        if(categoryFilter) {
            categoryFilter.addEventListener('change', () => {
                updateMarkers();
                updateDestinationsList();
            });
        }
        
        // Bouton de localisation
        const locateBtn = document.getElementById('locateBtn');
        if(locateBtn) {
            locateBtn.addEventListener('click', locateUser);
        }
        
        // Bouton reset vue pays
        const resetBtn = document.getElementById('resetViewBtn');
        if(resetBtn) {
            resetBtn.addEventListener('click', resetToCountryView);
        }
        
        // Fermeture du modal vidéo avec la touche Echap
        document.addEventListener('keydown', function(e) {
            if(e.key === 'Escape') {
                closeVideoModal();
            }
        });
        
        // Fermeture du modal vidéo en cliquant en dehors
        const videoModal = document.getElementById('videoModal');
        if(videoModal) {
            videoModal.addEventListener('click', function(e) {
                if(e.target === videoModal) {
                    closeVideoModal();
                }
            });
        }
        
        // Cartes vidéo du slider
        document.querySelectorAll('.video-card').forEach(card => {
            card.addEventListener('click', () => {
                const videoId = card.dataset.video;
                if(videoId) openVideoModal(videoId);
            });
        });
        
        // Slides publicitaires
        document.querySelectorAll('.ad-slide').forEach(slide => {
            slide.addEventListener('click', (e) => {
                if(!e.target.closest('.ad-link')) {
                    const videoId = slide.dataset.video;
                    if(videoId) openVideoModal(videoId);
                }
            });
        });
    });
</script>

<!-- Styles additionnels pour la carte -->
<style>
    .custom-marker {
        background: transparent;
        transition: transform 0.2s ease;
    }
    
    .custom-marker:hover {
        transform: scale(1.1);
        z-index: 1000;
    }
    
    .marker-circle {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .marker-circle:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0,0,0,0.25);
    }
    
    /* Styles pour les popups */
    .leaflet-popup-content-wrapper {
        border-radius: 16px;
        padding: 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    
    .leaflet-popup-content {
        margin: 0;
        width: auto !important;
    }
    
    .leaflet-popup-tip {
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    
    .popup-btn {
        transition: all 0.2s ease;
    }
    
    .popup-btn:hover {
        transform: translateY(-2px);
    }
    
    /* Animation de chargement */
    .map-wrapper.loading {
        position: relative;
        opacity: 0.6;
    }
    
    .map-wrapper.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 40px;
        height: 40px;
        border: 3px solid #e2e8f0;
        border-top-color: #0284c7;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        z-index: 10;
    }
    
    @keyframes spin {
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }
</style>
</body>
</html>