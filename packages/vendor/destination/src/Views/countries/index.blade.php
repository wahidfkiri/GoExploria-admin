@extends('destination::layouts.app')
@section('content')
    
    <!-- Conteneur principal avec padding -->
    <div class="main-container">
        
        <!-- FIL D'ARIANE STYLE CARD -->
        <div class="breadcrumb-alt">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="fas fa-globe-americas"></i> Amérique du Nord
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="fas fa-map"></i> Canada
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fas fa-city"></i> Québec
                    </li>
                </ol>
            </nav>
        </div>  

        
        <!-- CARTE FULL WIDTH EN DEHORS DU two-columns-layout -->
        <div class="map-fullwidth-section" id="carte-interactive">
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
        </div> 
        
        <div class="two-columns-layout">
            <!-- COLONNE GAUCHE -->
            <div class="col-left">
                
                <!-- SLIDER VIDEOS -->
                <div class="videos-slider-section">
                    <div class="slider-header">
                        <h2>🎬 Découvrez le Québec en Vidéo</h2>
                    </div>
                    <div class="video-slider-container">
                        <div class="video-slider" id="videoSlider">
                            <!-- Vidéo 1 - Québec City -->
                            <div class="video-card">
                                <div class="video-iframe-wrapper">
                                    <iframe 
                                        src="https://www.youtube.com/embed/xPPLbEFbCAo?autoplay=0&rel=0&modestbranding=1" 
                                        title="Vidéo Québec" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                </div>
                                <div class="video-info">
                                    <h4>Ville de Québec</h4>
                                    <p>Découvrez la beauté de la capitale québécoise</p>
                                </div>
                            </div>
                            <!-- Vidéo 2 - Montréal -->
                            <div class="video-card">
                                <div class="video-iframe-wrapper">
                                    <iframe 
                                        src="https://www.youtube.com/embed/5rZ0Jqp1VcY?autoplay=0&rel=0&modestbranding=1" 
                                        title="Vidéo Montréal" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                </div>
                                <div class="video-info">
                                    <h4>Montréal</h4>
                                    <p>La métropole culturelle du Québec</p>
                                </div>
                            </div>
                            <!-- Vidéo 3 - Charlevoix -->
                            <div class="video-card">
                                <div class="video-iframe-wrapper">
                                    <iframe 
                                        src="https://www.youtube.com/embed/SYP6n1eguIY?autoplay=0&rel=0&modestbranding=1" 
                                        title="Vidéo Charlevoix" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                </div>
                                <div class="video-info">
                                    <h4>Charlevoix</h4>
                                    <p>Les paysages à couper le souffle</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HISTORIQUE AMÉLIORÉ AVEC CARTES INFO -->
                <div class="historique-section">
                    <div class="country-header">
                        <div class="country-flag">
                            @if($country->flag)
                                <img src="{{ asset('storage/' . $country->flag) }}" alt="Drapeau {{ $country->name }}">
                            @else
                                <i class="fas fa-flag-checkered"></i>
                            @endif
                        </div>
                        <div class="country-title">
                            <h3>
                                <i class="fas fa-landmark"></i>
                                {{ $country->name }} : Un Voyage à Travers l'Histoire
                            </h3>
                        </div>
                    </div>
                    
                    <!-- Cartes d'informations -->
                    <div class="country-info-cards">
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-city"></i>
                            </div>
                            <div class="info-content">
                                <h4>Capitale</h4>
                                <p>{{ $country->capital ?? 'Ottawa' }}</p>
                            </div>
                        </div>
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="info-content">
                                <h4>Population</h4>
                                <p>{{ number_format($country->population ?? 38000000) }} habitants</p>
                            </div>
                        </div>
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-globe-americas"></i>
                            </div>
                            <div class="info-content">
                                <h4>Superficie</h4>
                                <p>{{ number_format($country->area ?? 9984670, 0, ',', ' ') }} km²</p>
                            </div>
                        </div>
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-language"></i>
                            </div>
                            <div class="info-content">
                                <h4>Langues officielles</h4>
                                <p>{{ $country->official_language ?? 'Anglais, Français' }}</p>
                            </div>
                        </div>
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="info-content">
                                <h4>Monnaie</h4>
                                <p>{{ $country->currency ?? 'Dollar canadien' }} ({{ $country->currency_symbol ?? '$' }})</p>
                            </div>
                        </div>
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="info-content">
                                <h4>Indicatif</h4>
                                <p>{{ $country->phone_code ?? '+1' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description historique enrichie -->
                    <div class="historique-content">
                        <div class="history-text">
                            {!! nl2br(e($country->description)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLONNE DROITE -->
            <div class="col-right">
                
                <!-- SLIDER PUBLICITAIRE MULTI-VIDEOS AVEC SWIPER -->
                <div class="ads-slider-section">
                    <div class="ads-header">
                        <h3><i class="fas fa-star"></i> Offres & Découvertes</h3>
                    </div>
                    
                    <!-- Swiper Container -->
                    <div class="swiper adsSwiper">
                        <div class="swiper-wrapper">
                            <!-- Slide 1 -->
                            <div class="swiper-slide ad-slide">
                                <div class="ad-image" style="background-image: url('https://img.youtube.com/vi/xPPLbEFbCAo/maxresdefault.jpg')">
                                    <div class="ad-play-overlay"><i class="fas fa-play"></i></div>
                                </div>
                                <div class="ad-content">
                                    <h4>Forfait Découverte</h4>
                                    <p>Explorez Québec -25%</p>
                                    <a href="#" class="ad-link">Voir l'offre <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                            <!-- Slide 2 -->
                            <div class="swiper-slide ad-slide">
                                <div class="ad-image" style="background-image: url('https://img.youtube.com/vi/5rZ0Jqp1VcY/maxresdefault.jpg')">
                                    <div class="ad-play-overlay"><i class="fas fa-play"></i></div>
                                </div>
                                <div class="ad-content">
                                    <h4>Circuit Montréalais</h4>
                                    <p>Le meilleur de Montréal</p>
                                    <a href="#" class="ad-link">Réserver <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                            <!-- Slide 3 -->
                            <div class="swiper-slide ad-slide">
                                <div class="ad-image" style="background-image: url('https://img.youtube.com/vi/SYP6n1eguIY/maxresdefault.jpg')">
                                    <div class="ad-play-overlay"><i class="fas fa-play"></i></div>
                                </div>
                                <div class="ad-content">
                                    <h4>Escapade Charlevoix</h4>
                                    <p>Nature et panoramas grandioses</p>
                                    <a href="#" class="ad-link">En savoir plus <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- Pagination -->
                        <div class="swiper-pagination"></div>
                        <!-- Navigation Buttons -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>

                <!-- LISTE DES PROVINCES -->
                <div class="provinces-list-section">
                    <div class="provinces-header">
                        <h3><i class="fas fa-map-marked-alt"></i> Liste des provinces</h3>
                        <p>Découvrez toutes les provinces du Canada</p>
                    </div>
                    <div class="provinces-grid">
    @foreach($provinces as $province)
        <a href="{{ route('destination.province', ['countryCode' => \Str::lower($country->code), 'code' => \Str::lower($province->code)]) }}" class="province-card">
            <div class="province-icon">
                <i class="fas fa-map-pin"></i>
            </div>
            <div class="province-info">
                <h4>{{ $province->name }}</h4>
                @if($province->cities_count)
                    <span>{{ $province->cities_count }} villes</span>
                @endif
            </div>
            <div class="province-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
    @endforeach
</div>
                </div>
            </div>
        </div>

    </div>

<style>
    /* Styles pour les régions */
    .regions-section {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }
    
    .regions-section h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .regions-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .region-card {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: #f1f5f9;
        border-radius: 30px;
        text-decoration: none;
        color: #475569;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .region-card:hover {
        background: #0284c7;
        color: white;
        transform: translateY(-2px);
    }
    
    .region-card i {
        font-size: 0.75rem;
    }
</style>
    <script src="{{ asset('vendor/destination/js/interactive-map.js') }}"></script>
     <script>
    // ============================================
    // DONNÉES PHP PASSÉES À JAVASCRIPT
    // ============================================
    const countryLat = {{ $country->latitude ?? 56.1304 }};
    const countryLng = {{ $country->longitude ?? -106.3468 }};
    const countryZoom = {{ $country->zoom ?? 3 }};
    
    // Provinces
    const provinces = [];
    <?php if(isset($provinces)): ?>
        <?php foreach($provinces as $province): ?>
        provinces.push({
            id: '<?php echo $province->id; ?>',
            name: '<?php echo addslashes($province->name); ?>',
            code: '<?php echo $province->code; ?>',
            latitude: <?php echo $province->latitude ? (float)$province->latitude : 'null'; ?>,
            longitude: <?php echo $province->longitude ? (float)$province->longitude : 'null'; ?>,
            zoom: <?php echo $province->zoom ?? 6; ?>
        });
        <?php endforeach; ?>
    <?php endif; ?>
    
    // Points de la carte depuis la base de données
    const places = <?php echo isset($places) ? json_encode($places) : '[]'; ?>;
    
    // ============================================
    // VARIABLES GLOBALES
    // ============================================
    let map;
    let markers = [];
    let userMarker = null;
    let adsSwiper = null;
    
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
        const mapElement = document.getElementById('interactiveMap');
        if(!mapElement) return;
        
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
    // ZOOM SUR PROVINCE PAR ID
    // ============================================
    function zoomToProvinceById(provinceId) {
        const province = provinces.find(p => p.id == provinceId);
        if (province && province.latitude && province.longitude) {
            map.setView([province.latitude, province.longitude], province.zoom || 7);
            return true;
        }
        return false;
    }
    
    // ============================================
    // RÉINITIALISER LA VUE PAYS
    // ============================================
    function resetToCountryView() {
        if(!map) return;
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
            
            // Arrêter l'autoplay du Swiper si une vidéo est jouée
            if(adsSwiper && adsSwiper.autoplay) {
                adsSwiper.autoplay.stop();
            }
        }
    }
    
    function closeVideoModal() {
        const modal = document.getElementById('videoModal');
        const iframe = document.getElementById('videoIframe');
        if(modal && iframe) {
            iframe.src = '';
            modal.style.display = 'none';
            
            // Redémarrer l'autoplay du Swiper
            if(adsSwiper && adsSwiper.autoplay) {
                adsSwiper.autoplay.start();
            }
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
    // INITIALISATION DU SWIPER ADS
    // ============================================
    function initAdsSwiper() {
        const swiperContainer = document.querySelector('.adsSwiper');
        if(swiperContainer && typeof Swiper !== 'undefined') {
            adsSwiper = new Swiper('.adsSwiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                loop: true,
                effect: 'slide',
                speed: 500,
                breakpoints: {
                    640: { slidesPerView: 1 },
                    768: { slidesPerView: 1 },
                    1024: { slidesPerView: 1 }
                }
            });
            
            // Gestionnaire de clic pour les vidéos publicitaires
            document.querySelectorAll('.ad-slide').forEach(slide => {
                const playButton = slide.querySelector('.ad-play-overlay');
                const adImage = slide.querySelector('.ad-image');
                
                if(playButton) {
                    playButton.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const videoId = slide.getAttribute('data-video');
                        if(videoId) {
                            openVideoModal(videoId);
                        }
                    });
                }
                
                if(adImage) {
                    adImage.addEventListener('click', function(e) {
                        if(!e.target.closest('.ad-play-overlay') && !e.target.closest('.ad-link')) {
                            const videoId = slide.getAttribute('data-video');
                            if(videoId) {
                                openVideoModal(videoId);
                            }
                        }
                    });
                }
            });
        }
    }
    
    // ============================================
    // INITIALISATION DES ÉVÉNEMENTS
    // ============================================
    document.addEventListener('DOMContentLoaded', () => {
        // Initialiser la carte
        initMap();
        
        // Initialiser le Swiper Ads
        initAdsSwiper();
        
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
    });
    </script>
    @endsection
