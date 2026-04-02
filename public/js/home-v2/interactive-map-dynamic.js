/**
 * Interactive Map V2 - Version dynamique avec API backend
 * Gestion de la carte Leaflet avec données réelles depuis l'API
 */

class InteractiveMapV2Dynamic {
    constructor() {
        this.map = null;
        this.markers = [];
        this.currentFilter = {
            ville: '',
            category: ''
        };
        this.currentPlace = null;
        this.places = [];
        this.categories = [];
        
        // Service API
        this.apiService = window.mapAPIService;
        
        // Éléments DOM
        this.mapElement = document.getElementById('interactiveMap');
        this.regionFilter = document.getElementById('regionFilter');
        this.categoryFilter = document.getElementById('categoryFilter');
        this.locateBtn = document.getElementById('locateBtn');
        this.resultsCount = document.getElementById('resultsCount');
        this.hoverPopup = document.getElementById('hoverPopup');
        this.hoverIframe = document.getElementById('hoverIframe');
        this.hoverDescription = document.getElementById('hoverDescription');
        this.destinationsList = document.getElementById('destinationsList');
        this.detailsScreen = document.getElementById('detailsScreen');
        this.closeDetailsScreen = document.getElementById('closeDetailsScreen');
        this.closeDetailsBtn = document.getElementById('closeDetailsBtn');
        this.itineraryBtn = document.getElementById('itineraryBtn');
        
        this.init();
    }
    
    async init() {
        if (!this.mapElement) return;
        
        // Afficher un loader
        this.showLoader();
        
        // Initialiser la carte Leaflet
        this.initMap();
        
        // Charger les catégories depuis l'API
        await this.loadCategories();
        
        // Charger les points depuis l'API
        await this.loadPoints();
        
        // Ajouter les marqueurs
        this.addMarkers();
        
        // Générer les cartes destinations
        this.renderDestinationCards();
        
        // Mettre à jour le compteur
        this.updateResultsCount();
        
        // Événements des filtres
        if (this.regionFilter) {
            this.regionFilter.addEventListener('change', () => this.applyFilters());
        }
        
        if (this.categoryFilter) {
            this.categoryFilter.addEventListener('change', () => this.applyFilters());
        }
        
        if (this.locateBtn) {
            this.locateBtn.addEventListener('click', () => this.locateUser());
        }
        
        // Événements du panneau détails
        if (this.closeDetailsScreen) {
            this.closeDetailsScreen.addEventListener('click', () => this.hideDetails());
        }
        
        if (this.closeDetailsBtn) {
            this.closeDetailsBtn.addEventListener('click', () => this.hideDetails());
        }
        
        if (this.itineraryBtn) {
            this.itineraryBtn.addEventListener('click', () => this.openItinerary());
        }
        
        // Cacher le loader
        this.hideLoader();
    }
    
    showLoader() {
        if (this.destinationsList) {
            this.destinationsList.innerHTML = '<div class="map-loader">Chargement des points...</div>';
        }
    }
    
    hideLoader() {
        const loader = document.querySelector('.map-loader');
        if (loader) {
            loader.remove();
        }
    }
    
    async loadCategories() {
        try {
            this.categories = await this.apiService.getCategories();
            this.populateCategoryFilter();
        } catch (error) {
            console.error('Erreur lors du chargement des catégories:', error);
        }
    }
    
    populateCategoryFilter() {
        if (!this.categoryFilter || this.categories.length === 0) return;
        
        // Garder l'option "Toutes les catégories"
        const defaultOption = this.categoryFilter.querySelector('option[value=""]');
        this.categoryFilter.innerHTML = '';
        
        if (defaultOption) {
            this.categoryFilter.appendChild(defaultOption);
        }
        
        // Ajouter les catégories depuis l'API
        this.categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category;
            option.textContent = this.getCategoryName(category);
            this.categoryFilter.appendChild(option);
        });
    }
    
    async loadVilles() {
        try {
            this.villes = await this.apiService.getVilles();
            this.populateVilleFilter();
        } catch (error) {
            console.error('Erreur lors du chargement des villes:', error);
        }
    }
    
    populateVilleFilter() {
        if (!this.regionFilter || this.villes.length === 0) return;
        
        // Garder l'option par défaut "Toutes les régions"
        const defaultOption = this.regionFilter.querySelector('option[value=""]');
        this.regionFilter.innerHTML = '';
        
        if (defaultOption) {
            this.regionFilter.appendChild(defaultOption);
        } else {
            // Créer une option par défaut si elle n'existe pas
            const option = document.createElement('option');
            option.value = '';
            option.textContent = 'Toutes les régions';
            this.regionFilter.appendChild(option);
        }
        
        // Ajouter les régions/villes depuis l'API (triées alphabétiquement)
        const sortedVilles = [...this.villes].sort();
        sortedVilles.forEach(ville => {
            const option = document.createElement('option');
            option.value = ville;
            option.textContent = ville;
            this.regionFilter.appendChild(option);
        });
    }
    
    async loadPoints() {
        try {
            const rawPoints = await this.apiService.getAllPoints();
            
            // Formater les points pour la carte
            this.places = rawPoints.map(point => this.apiService.formatPointForMap(point));
            
            console.log(`${this.places.length} points chargés depuis l'API`);
        } catch (error) {
            console.error('Erreur lors du chargement des points:', error);
            this.places = [];
        }
    }
    
      initMap() {
    this.map = L.map('interactiveMap', {
        zoomControl: true,
        scrollWheelZoom: true
    }).setView([46.8139, -71.2080], 3); // 3 au lieu de 6
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 18
    }).addTo(this.map);

    this.map.on('moveend', () => {
        this.loadPointsInView();
    });
}
    
    async loadPointsInView() {
        const bounds = this.map.getBounds();
        const boundsData = {
            south: bounds.getSouth(),
            west: bounds.getWest(),
            north: bounds.getNorth(),
            east: bounds.getEast()
        };
        
        const category = this.currentFilter.category || null;
        
        try {
            const rawPoints = await this.apiService.getPointsInBounds(boundsData, category);
            const formattedPoints = rawPoints.map(point => this.apiService.formatPointForMap(point));
            
            // Mettre à jour uniquement les points visibles
            this.updateVisibleMarkers(formattedPoints);
        } catch (error) {
            console.error('Erreur lors du chargement des points dans la zone:', error);
        }
    }
    
    updateVisibleMarkers(newPlaces) {
        // Cette méthode peut être utilisée pour optimiser l'affichage
        // Pour l'instant, on garde tous les marqueurs
    }
    
    addMarkers() {
        // Nettoyer les anciens marqueurs
        this.markers.forEach(({ marker }) => {
            this.map.removeLayer(marker);
        });
        this.markers = [];
        
        if (this.places.length === 0) {
            console.warn('Aucun point à afficher sur la carte');
            return;
        }
        
        this.places.forEach(place => {
            // Vérifier que les coordonnées sont valides
            if (!place.lat || !place.lng || isNaN(place.lat) || isNaN(place.lng)) {
                console.warn('Coordonnées invalides pour:', place.name);
                return;
            }
            
            const icon = this.getIconForCategory(place.category);
            
            const marker = L.marker([place.lat, place.lng], {
                icon: L.divIcon({
                    className: 'custom-marker',
                    html: `<div class="marker-icon ${place.category}">${icon}</div>`,
                    iconSize: [60, 60]
                })
            }).addTo(this.map);
            
            // Hover sur marqueur
marker.on('mouseover', (e) => {
    // Passer place uniquement, la position sera calculée depuis les coordonnées lat/lng
    this.showHoverPopup(place);
});
            
            marker.on('mouseout', () => {
                this.hideHoverPopup();
            });
            
            // Click sur marqueur
            marker.on('click', () => {
                this.showDetails(place);
            });
            
            this.markers.push({ marker, place });
        });
        
        // Ajuster la vue pour afficher tous les marqueurs
       if (this.markers.length > 0) {
    const group = L.featureGroup(this.markers.map(m => m.marker));
    this.map.fitBounds(group.getBounds().pad(0.2), {
        maxZoom: 3  // 3 au lieu de 6
    });
}
    }
    
    renderDestinationCards() {
        if (!this.destinationsList) return;
        
        this.destinationsList.innerHTML = '';
        
        if (this.places.length === 0) {
            this.destinationsList.innerHTML = '<p class="no-results">Aucun point trouvé. Essayez de modifier les filtres.</p>';
            return;
        }
        
        this.places.forEach(place => {
            const card = document.createElement('div');
            card.className = 'interactive-map-v2-destination-card';
            
            // Image ou vidéo thumbnail
            const imageUrl = place.videoThumbnail || 
                           place.mainImage || 
                           (place.mainVideo ? `https://img.youtube.com/vi/${place.mainVideo}/mqdefault.jpg` : '');
            
            const imageHtml = imageUrl 
                ? `<img src="${imageUrl}" alt="${place.name}" onerror="this.style.display='none'">`
                : `<div class="no-image-placeholder" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 120px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">${this.getIconForCategory(place.category)}</div>`;
            
            card.innerHTML = `
                ${imageHtml}
                <div class="interactive-map-v2-destination-card-info">
                    <h4 class="interactive-map-v2-destination-card-title">${place.name}</h4>
                    <p class="interactive-map-v2-destination-card-category">${this.getCategoryName(place.category)}</p>
                    ${place.ville ? `<p class="interactive-map-v2-destination-card-ville">${place.ville}</p>` : ''}
                </div>
                <div class="interactive-map-v2-destination-card-actions">
                    <button class="interactive-map-v2-destination-card-btn details" data-id="${place.id}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                        </svg>
                        Détails
                    </button>
                    <button class="interactive-map-v2-destination-card-btn location" data-id="${place.id}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        Voir
                    </button>
                    ${place.mainVideo || place.videos.length > 0 ? `
                    <button class="interactive-map-v2-destination-card-btn youtube" data-id="${place.id}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="white">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </button>
                    ` : ''}
                </div>
            `;
            
            // Événements des boutons
            const detailsBtn = card.querySelector('.details');
            const locationBtn = card.querySelector('.location');
            const youtubeBtn = card.querySelector('.youtube');
            
            if (detailsBtn) {
                detailsBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.showDetails(place);
                    this.apiService.incrementView(place.id);
                });
            }
            
            if (locationBtn) {
                locationBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.centerOnPlace(place);
                });
            }
            
            if (youtubeBtn) {
                youtubeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.openYouTube(place);
                });
            }
            
            this.destinationsList.appendChild(card);
        });
    }
    
showHoverPopup(place, x, y) {
    if (!this.hoverPopup) return;

    this.currentPlace = place;

    // Mettre à jour l'iframe YouTube
    const videoId = place.mainVideo || place.videos?.[0]?.youtube_id || 'dQw4w9WgXcQ';
    if (this.hoverIframe) {
        this.hoverIframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=0&mute=1`;
    }

    // Description
    this.hoverDescription.textContent = place.description || 'Aucune description disponible';

    // Afficher d'abord pour mesurer la hauteur
    this.hoverPopup.style.visibility = 'hidden';
    this.hoverPopup.style.display = 'block';

    const popupWidth = this.hoverPopup.offsetWidth || 280;
    const popupHeight = this.hoverPopup.offsetHeight || 320;

    // Récupérer la position du conteneur map
    const mapContainer = this.map.getContainer();
    const mapRect = mapContainer.getBoundingClientRect();

    // Convertir la position du marqueur en coordonnées pixel dans la map
    const markerPoint = this.map.latLngToContainerPoint([place.lat, place.lng]);

    // Positionner au-dessus du marqueur, centré horizontalement
    let left = markerPoint.x - (popupWidth / 2);
    let top = markerPoint.y - popupHeight - 20; // 20px au-dessus de l'icône

    // Garde-fous — rester dans les limites de la map
    const mapWidth = mapContainer.offsetWidth;
    const mapHeight = mapContainer.offsetHeight;

    // Débordement à droite
    if (left + popupWidth > mapWidth) {
        left = mapWidth - popupWidth - 10;
    }
    // Débordement à gauche
    if (left < 10) {
        left = 10;
    }
    // Débordement en haut — afficher en dessous si pas de place
    if (top < 10) {
        top = markerPoint.y + 40; // en dessous du marqueur
    }

    this.hoverPopup.style.left = `${left}px`;
    this.hoverPopup.style.top = `${top}px`;
    this.hoverPopup.style.visibility = 'visible';

    // Événements des boutons
    const detailsBtn = this.hoverPopup.querySelector('[data-action="details"]');
    const locationBtn = this.hoverPopup.querySelector('[data-action="location"]');
    const youtubeBtn = this.hoverPopup.querySelector('[data-action="youtube"]');

    if (detailsBtn) {
        detailsBtn.onclick = () => {
            this.showDetails(place);
            this.apiService.incrementView(place.id);
        };
    }

    if (locationBtn) {
        locationBtn.onclick = () => this.centerOnPlace(place);
    }

    if (youtubeBtn) {
        youtubeBtn.onclick = () => this.openYouTube(place);
    }
}
    
    hideHoverPopup() {
    if (this.hoverPopup) {
        setTimeout(() => {
            if (!this.hoverPopup.matches(':hover')) {
                this.hoverPopup.style.display = 'none';
                // Stopper la vidéo en vidant le src
                if (this.hoverIframe) {
                    this.hoverIframe.src = '';
                }
            }
        }, 200);
    }
}
    
    getCategoryName(category) {
        const names = {
            restaurant: 'Restaurant',
            museum: 'Musée',
            hotel: 'Hôtel',
            activity: 'Activité',
            attraction: 'Attraction',
            shop: 'Boutique',
            service: 'Service',
            other: 'Autre'
        };
        return names[category] || category.charAt(0).toUpperCase() + category.slice(1);
    }
    
    getIconForCategory(category) {
        const icons = {
            restaurant: '🍽️',
            museum: '🏛️',
            hotel: '🏨',
            activity: '🎯',
            attraction: '🎪',
            shop: '🛍️',
            service: '🔧',
            other: '📍'
        };
        return icons[category] || '📍';
    }
    
    async applyFilters() {
        this.currentFilter.ville = this.regionFilter?.value || '';
        this.currentFilter.category = this.categoryFilter?.value || '';
        
        this.showLoader();
        
        // Recharger les points avec les filtres
        const filters = {};
        
        if (this.currentFilter.category) {
            filters.category = this.currentFilter.category;
        }
        
        if (this.currentFilter.ville) {
            filters.ville = this.currentFilter.ville;
        }
        
        try {
            const rawPoints = await this.apiService.getAllPoints(filters);
            this.places = rawPoints.map(point => this.apiService.formatPointForMap(point));
            
            // Réafficher les marqueurs et cartes
            this.addMarkers();
            this.renderDestinationCards();
            this.updateResultsCount();
        } catch (error) {
            console.error('Erreur lors de l\'application des filtres:', error);
        }
        
        this.hideLoader();
    }
    
    updateResultsCount(count) {
        if (this.resultsCount) {
            const total = count !== undefined ? count : this.places.length;
            this.resultsCount.textContent = total;
        }
    }
    
    async locateUser() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    const { latitude, longitude } = position.coords;
                    this.map.setView([latitude, longitude], 13);
                    
                    // Ajouter un marqueur pour l'utilisateur
                    L.marker([latitude, longitude], {
                        icon: L.divIcon({
                            className: 'user-marker',
                            html: '<div class="marker-icon user">📍</div>',
                            iconSize: [40, 40]
                        })
                    }).addTo(this.map);
                    
                    // Charger les points à proximité
                    try {
                        const nearbyPoints = await this.apiService.getNearbyPoints(latitude, longitude, 10, 20);
                        if (nearbyPoints.length > 0) {
                            console.log(`${nearbyPoints.length} points trouvés à proximité`);
                        }
                    } catch (error) {
                        console.error('Erreur lors de la recherche de points à proximité:', error);
                    }
                },
                (error) => {
                    console.error('Erreur de géolocalisation:', error);
                    alert('Impossible de vous localiser. Veuillez activer la géolocalisation.');
                }
            );
        } else {
            alert('La géolocalisation n\'est pas supportée par votre navigateur.');
        }
    }
    
    showDetails(place) {
        this.currentPlace = place;
        this.hideHoverPopup();
        
        if (!this.detailsScreen) return;
        
        // Ajouter la classe show-details au layout
        const mainLayout = document.querySelector('.interactive-map-v2-main-layout');
        if (mainLayout) {
            mainLayout.classList.add('show-details');
        }
        
        // Afficher l'écran droit
        this.detailsScreen.style.display = 'block';
        
        // Mettre à jour le contenu
        const title = this.detailsScreen.querySelector('.interactive-map-v2-details-title');
        const description = this.detailsScreen.querySelector('.interactive-map-v2-details-text');
        const videoContainer = this.detailsScreen.querySelector('.interactive-map-v2-details-video');
        const address = this.detailsScreen.querySelector('.interactive-map-v2-contact-item:nth-child(1) p');
        const phone = this.detailsScreen.querySelector('.interactive-map-v2-contact-item:nth-child(2) p');
        const website = this.detailsScreen.querySelector('.interactive-map-v2-contact-item:nth-child(3) a');
        
        if (title) title.textContent = place.name;
        if (description) description.textContent = place.description || 'Aucune description disponible';
        
        // Vidéo
        if (videoContainer) {
            let videoId = null;
            
            // Essayer de récupérer le youtube_id
            if (place.mainVideo) {
                videoId = place.mainVideo;
            } else if (place.videos && place.videos.length > 0) {
                videoId = place.videos[0].youtube_id;
            }
            
            console.log('Affichage vidéo pour:', place.name, 'videoId:', videoId, 'videos:', place.videos);
            
            if (videoId) {
                videoContainer.innerHTML = `
                    <iframe 
                        width="100%" 
                        height="280" 
                        src="https://www.youtube.com/embed/${videoId}" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen
                    ></iframe>
                `;
            } else if (place.mainImage) {
                videoContainer.innerHTML = `<img src="${place.mainImage}" alt="${place.name}" style="width: 100%; height: 280px; object-fit: cover;">`;
            } else {
                videoContainer.innerHTML = `
                    <div style="width: 100%; height: 280px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 64px;">
                        ${this.getIconForCategory(place.category)}
                    </div>
                `;
            }
        }
        
        // Contacts
        if (address) address.textContent = place.address || 'Adresse non disponible';
        
        // Téléphone (utiliser le détail si disponible)
        const phoneNumber = place.details?.phone || place.phone || 'Non disponible';
        if (phone) phone.textContent = phoneNumber;
        
        // Site web (utiliser le détail si disponible)
        const websiteUrl = place.details?.website || place.website;
        if (website) {
            if (websiteUrl) {
                website.textContent = 'Visiter le site officiel';
                website.href = websiteUrl;
                website.target = '_blank';
            } else {
                website.textContent = 'Non disponible';
                website.removeAttribute('href');
            }
        }
        
        // Réseaux sociaux
        this.updateSocialLinks(place);
        
        // Centrer la carte sur le lieu
        this.centerOnPlace(place);
    }
    
    hideDetails() {
        const mainLayout = document.querySelector('.interactive-map-v2-main-layout');
        if (mainLayout) {
            mainLayout.classList.remove('show-details');
        }
        
        if (this.detailsScreen) {
            setTimeout(() => {
                this.detailsScreen.style.display = 'none';
            }, 400);
        }
    }
    
    updateSocialLinks(place) {
        const socialLinks = this.detailsScreen.querySelector('.interactive-map-v2-social-links');
        if (!socialLinks) return;
        
        const socialNetworks = place.socialNetworks || {};
        
        console.log('Réseaux sociaux:', socialNetworks);
        
        // Facebook
        const facebookBtn = socialLinks.querySelector('.facebook');
        if (facebookBtn) {
            if (socialNetworks.facebook) {
                facebookBtn.href = socialNetworks.facebook;
                facebookBtn.style.display = 'inline-flex';
                facebookBtn.target = '_blank';
            } else {
                facebookBtn.style.display = 'none';
            }
        }
        
        // YouTube
        const youtubeBtn = socialLinks.querySelector('.youtube');
        if (youtubeBtn) {
            if (socialNetworks.youtube) {
                youtubeBtn.href = socialNetworks.youtube;
                youtubeBtn.style.display = 'inline-flex';
                youtubeBtn.target = '_blank';
            } else {
                youtubeBtn.style.display = 'none';
            }
        }
        
        // Instagram
        const instagramBtn = socialLinks.querySelector('.instagram');
        if (instagramBtn) {
            if (socialNetworks.instagram) {
                instagramBtn.href = socialNetworks.instagram;
                instagramBtn.style.display = 'inline-flex';
                instagramBtn.target = '_blank';
            } else {
                instagramBtn.style.display = 'none';
            }
        }
        
        // Twitter/X
        const twitterBtn = socialLinks.querySelector('.twitter');
        if (twitterBtn) {
            if (socialNetworks.twitter) {
                twitterBtn.href = socialNetworks.twitter;
                twitterBtn.style.display = 'inline-flex';
                twitterBtn.target = '_blank';
            } else {
                twitterBtn.style.display = 'none';
            }
        }
        
        // LinkedIn
        const linkedinBtn = socialLinks.querySelector('.linkedin');
        if (linkedinBtn) {
            if (socialNetworks.linkedin) {
                linkedinBtn.href = socialNetworks.linkedin;
                linkedinBtn.style.display = 'inline-flex';
                linkedinBtn.target = '_blank';
            } else {
                linkedinBtn.style.display = 'none';
            }
        }
        
        // TikTok
        const tiktokBtn = socialLinks.querySelector('.tiktok');
        if (tiktokBtn) {
            if (socialNetworks.tiktok) {
                tiktokBtn.href = socialNetworks.tiktok;
                tiktokBtn.style.display = 'inline-flex';
                tiktokBtn.target = '_blank';
            } else {
                tiktokBtn.style.display = 'none';
            }
        }
    }
    
    centerOnPlace(place) {
        if (this.map && place.lat && place.lng) {
            this.map.setView([place.lat, place.lng], 15);
        }
    }
    
    openYouTube(place) {
        const videoId = place.mainVideo || place.videos[0]?.youtube_id;
        if (videoId) {
            window.open(`https://www.youtube.com/watch?v=${videoId}`, '_blank');
        }
    }
    
    playVideoInPopup(place) {
        const videoWrapper = this.hoverPopup.querySelector('.interactive-map-v2-hover-video');
        if (!videoWrapper) return;
        
        const videoId = place.mainVideo || place.videos[0]?.youtube_id;
        if (!videoId) return;
        
        const iframe = document.createElement('iframe');
        iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
        iframe.frameBorder = '0';
        iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
        iframe.allowFullscreen = true;
        iframe.style.position = 'absolute';
        iframe.style.top = '0';
        iframe.style.left = '0';
        iframe.style.width = '100%';
        iframe.style.height = '100%';
        
        videoWrapper.innerHTML = '';
        videoWrapper.appendChild(iframe);
    }
    
    openItinerary() {
        if (this.currentPlace && this.currentPlace.lat && this.currentPlace.lng) {
            const url = `https://www.google.com/maps/dir/?api=1&destination=${this.currentPlace.lat},${this.currentPlace.lng}`;
            window.open(url, '_blank');
        }
    }
}

// Initialiser la carte au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    // Charger Leaflet CSS et JS
    const leafletCSS = document.createElement('link');
    leafletCSS.rel = 'stylesheet';
    leafletCSS.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
    document.head.appendChild(leafletCSS);
    
    const leafletJS = document.createElement('script');
    leafletJS.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
    leafletJS.onload = () => {
        // Attendre que le service API soit chargé
        if (window.mapAPIService) {
            new InteractiveMapV2Dynamic();
        } else {
            console.error('MapAPIService non disponible');
        }
    };
    document.head.appendChild(leafletJS);
});
