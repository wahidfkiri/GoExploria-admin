/**
 * Interactive Map V2 - Carte interactive avec filtres et détails
 * Gestion de la carte Leaflet, marqueurs, popups et interactions
 */

class InteractiveMapV2 {
    constructor() {
        this.map = null;
        this.markers = [];
        this.currentFilter = {
            region: '',
            category: ''
        };
        this.currentPlace = null;
        
        // Éléments DOM
        this.mapElement = document.getElementById('interactiveMap');
        this.regionFilter = document.getElementById('regionFilter');
        this.categoryFilter = document.getElementById('categoryFilter');
        this.locateBtn = document.getElementById('locateBtn');
        this.resultsCount = document.getElementById('resultsCount');
        this.hoverPopup = document.getElementById('hoverPopup');
        this.hoverThumbnail = document.getElementById('hoverThumbnail');
        this.hoverDescription = document.getElementById('hoverDescription');
        this.destinationsList = document.getElementById('destinationsList');
        this.detailsScreen = document.getElementById('detailsScreen');
        this.closeDetailsScreen = document.getElementById('closeDetailsScreen');
        this.closeDetailsBtn = document.getElementById('closeDetailsBtn');
        this.itineraryBtn = document.getElementById('itineraryBtn');
        
        // Données des lieux (mock data)
        this.places = [
            {
                id: 1,
                name: 'Restaurant Toqué!',
                category: 'restaurant',
                region: 'montreal',
                lat: 45.5017,
                lng: -73.5673,
                description: 'Restaurant gastronomique étoilé au guide Michelin',
                video: 'dQw4w9WgXcQ',
                address: '900 Place Jean-Paul-Riopelle, Montréal',
                phone: '+1-514-499-2084',
                website: 'https://www.restaurant-toque.com'
            },
            {
                id: 2,
                name: 'Musée des Beaux-Arts de Montréal',
                category: 'museum',
                region: 'montreal',
                lat: 45.4986,
                lng: -73.5792,
                description: 'Plus grand musée d\'art du Canada avec collections internationales',
                video: 'dQw4w9WgXcQ',
                address: '1380 Rue Sherbrooke O, Montréal, QC H3G 1J5',
                phone: '+1-514-285-2000',
                website: 'https://www.mbam.qc.ca'
            },
            {
                id: 3,
                name: 'Centre des Congrès de Québec',
                category: 'activity',
                region: 'quebec-city',
                lat: 46.8139,
                lng: -71.2080,
                description: 'Centre de congrès moderne avec architecture unique',
                video: 'dQw4w9WgXcQ',
                address: '1000 Boulevard René-Lévesque E, Québec',
                phone: '+1-418-644-4000',
                website: 'https://www.convention.qc.ca'
            },
            {
                id: 4,
                name: 'Hôtel Fairmont Le Château Frontenac',
                category: 'hotel',
                region: 'quebec-city',
                lat: 46.8121,
                lng: -71.2044,
                description: 'Hôtel emblématique surplombant le fleuve Saint-Laurent',
                video: 'dQw4w9WgXcQ',
                address: '1 Rue des Carrières, Québec',
                phone: '+1-418-692-3861',
                website: 'https://www.fairmont.fr/frontenac-quebec'
            },
            {
                id: 5,
                name: 'Parc Omega',
                category: 'activity',
                region: 'gatineau',
                lat: 45.6167,
                lng: -75.0833,
                description: 'Parc animalier avec animaux en liberté',
                video: 'dQw4w9WgXcQ',
                address: '399 Route 323 Nord, Montebello',
                phone: '+1-819-423-5487',
                website: 'https://www.parcomega.ca'
            },
            {
                id: 6,
                name: 'Musée de la Civilisation',
                category: 'museum',
                region: 'quebec-city',
                lat: 46.8123,
                lng: -71.2025,
                description: 'Musée interactif sur l\'histoire et la culture québécoise',
                video: 'dQw4w9WgXcQ',
                address: '85 Rue Dalhousie, Québec',
                phone: '+1-418-643-2158',
                website: 'https://www.mcq.org'
            }
        ];
        
        this.init();
    }
    
    init() {
        if (!this.mapElement) return;
        
        // Initialiser la carte Leaflet
        this.initMap();
        
        // Ajouter les marqueurs
        this.addMarkers();
        
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
        
        // Générer les cartes destinations
        this.renderDestinationCards();
        
        // Mettre à jour le compteur
        this.updateResultsCount();
    }
    
    initMap() {
        // Centrer sur le Québec
        this.map = L.map('interactiveMap').setView([46.8139, -71.2080], 10);
        
        // Ajouter le layer OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18
        }).addTo(this.map);
    }
    
    addMarkers() {
        this.places.forEach(place => {
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
                this.showHoverPopup(place, e.originalEvent.clientX, e.originalEvent.clientY);
            });
            
            marker.on('mouseout', () => {
                this.hideHoverPopup();
            });
            
            this.markers.push({ marker, place });
        });
    }
    
    renderDestinationCards() {
        if (!this.destinationsList) return;
        
        this.destinationsList.innerHTML = '';
        
        this.places.forEach(place => {
            const card = document.createElement('div');
            card.className = 'interactive-map-v2-destination-card';
            card.innerHTML = `
                <img src="https://img.youtube.com/vi/${place.video}/mqdefault.jpg" alt="${place.name}">
                <div class="interactive-map-v2-destination-card-info">
                    <h4 class="interactive-map-v2-destination-card-title">${place.name}</h4>
                    <p class="interactive-map-v2-destination-card-category">${this.getCategoryName(place.category)}</p>
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
                    <button class="interactive-map-v2-destination-card-btn youtube" data-id="${place.id}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="white">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </button>
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
        
        // Mettre à jour le contenu
        this.hoverThumbnail.src = `https://img.youtube.com/vi/${place.video}/mqdefault.jpg`;
        this.hoverDescription.textContent = place.description;
        
        // Positionner le popup
        this.hoverPopup.style.display = 'block';
        this.hoverPopup.style.left = '140px';
        this.hoverPopup.style.top = '120px';
        
        // Événements des boutons
        const playBtn = this.hoverPopup.querySelector('[data-action="play"]');
        const detailsBtn = this.hoverPopup.querySelector('[data-action="details"]');
        const locationBtn = this.hoverPopup.querySelector('[data-action="location"]');
        const youtubeBtn = this.hoverPopup.querySelector('[data-action="youtube"]');
        
        if (playBtn) {
            playBtn.onclick = (e) => {
                e.stopPropagation();
                this.playVideoInPopup(place);
            };
        }
        
        if (detailsBtn) {
            detailsBtn.onclick = () => this.showDetails(place);
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
                }
            }, 200);
        }
    }
    
    getCategoryName(category) {
        const names = {
            restaurant: 'Restaurant',
            museum: 'Musée',
            hotel: 'Hôtel',
            activity: 'Activité'
        };
        return names[category] || category;
    }
    
    getIconForCategory(category) {
        const icons = {
            restaurant: '🍽️',
            museum: '🏛️',
            hotel: '🏨',
            activity: '🎯'
        };
        return icons[category] || '📍';
    }
    
    applyFilters() {
        this.currentFilter.region = this.regionFilter.value;
        this.currentFilter.category = this.categoryFilter.value;
        
        let visibleCount = 0;
        
        this.markers.forEach(({ marker, place }) => {
            const matchRegion = !this.currentFilter.region || place.region === this.currentFilter.region;
            const matchCategory = !this.currentFilter.category || place.category === this.currentFilter.category;
            
            if (matchRegion && matchCategory) {
                marker.addTo(this.map);
                visibleCount++;
            } else {
                this.map.removeLayer(marker);
            }
        });
        
        this.updateResultsCount(visibleCount);
    }
    
    updateResultsCount(count) {
        if (this.resultsCount) {
            const total = count !== undefined ? count : this.places.length;
            this.resultsCount.textContent = total;
        }
    }
    
    locateUser() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const { latitude, longitude } = position.coords;
                    this.map.setView([latitude, longitude], 13);
                    
                    L.marker([latitude, longitude], {
                        icon: L.divIcon({
                            className: 'user-marker',
                            html: '<div class="marker-icon user">📍</div>',
                            iconSize: [40, 40]
                        })
                    }).addTo(this.map);
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
        
        // Ajouter la classe show-details au layout pour l'animation
        const mainLayout = document.querySelector('.interactive-map-v2-main-layout');
        if (mainLayout) {
            mainLayout.classList.add('show-details');
        }
        
        // Afficher l'écran droit
        this.detailsScreen.style.display = 'block';
        
        // Mettre à jour le contenu
        const title = this.detailsScreen.querySelector('.interactive-map-v2-details-title');
        const description = this.detailsScreen.querySelector('.interactive-map-v2-details-text');
        const video = this.detailsScreen.querySelector('iframe');
        const address = this.detailsScreen.querySelector('.interactive-map-v2-contact-item:nth-child(1) p');
        const phone = this.detailsScreen.querySelector('.interactive-map-v2-contact-item:nth-child(2) p');
        const website = this.detailsScreen.querySelector('.interactive-map-v2-contact-item:nth-child(3) a');
        
        if (title) title.textContent = place.name;
        if (description) description.textContent = place.description;
        if (video) video.src = `https://www.youtube.com/embed/${place.video}`;
        if (address) address.textContent = place.address;
        if (phone) phone.textContent = place.phone;
        if (website) {
            website.textContent = 'Visiter le site officiel';
            website.href = place.website;
        }
        
        // Centrer la carte sur le lieu
        this.centerOnPlace(place);
    }
    
    hideDetails() {
        // Retirer la classe show-details du layout
        const mainLayout = document.querySelector('.interactive-map-v2-main-layout');
        if (mainLayout) {
            mainLayout.classList.remove('show-details');
        }
        
        if (this.detailsScreen) {
            // Attendre la fin de l'animation avant de cacher
            setTimeout(() => {
                this.detailsScreen.style.display = 'none';
            }, 400);
        }
    }
    
    centerOnPlace(place) {
        if (this.map) {
            this.map.setView([place.lat, place.lng], 14);
        }
    }
    
    openYouTube(place) {
        window.open(`https://www.youtube.com/watch?v=${place.video}`, '_blank');
    }
    
    playVideoInPopup(place) {
        // Remplacer l'image par un iframe YouTube dans le popup
        const videoWrapper = this.hoverPopup.querySelector('.interactive-map-v2-hover-video');
        if (!videoWrapper) return;
        
        // Créer l'iframe YouTube
        const iframe = document.createElement('iframe');
        iframe.src = `https://www.youtube.com/embed/${place.video}?autoplay=1`;
        iframe.frameBorder = '0';
        iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
        iframe.allowFullscreen = true;
        iframe.style.position = 'absolute';
        iframe.style.top = '0';
        iframe.style.left = '0';
        iframe.style.width = '100%';
        iframe.style.height = '100%';
        
        // Remplacer le contenu
        videoWrapper.innerHTML = '';
        videoWrapper.appendChild(iframe);
    }
    
    openItinerary() {
        if (this.currentPlace) {
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
        new InteractiveMapV2();
    };
    document.head.appendChild(leafletJS);
});
