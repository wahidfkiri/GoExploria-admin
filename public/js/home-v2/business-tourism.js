/**
 * Business & Tourism - Interactive Map Logic (GoExploria Business)
 */

class BusinessTourismApp {
    constructor() {
        this.map = null;
        this.markers = {};
        this.currentLocation = null;
        this.places = [];
        this.selectedCategory = 'all';
        this.selectedProvince = '';
        this.userMarker = null;
        this.activePlace = null;
        this.root = document.getElementById('business-tourism');
        this.mapContainer = this.root
            ? this.root.querySelector('[data-business-tourism-map], #business-tourism-map, .bt-map')
            : null;
        
        // Provinces & Territoires Canada
        this.provinces = [
            { code: 'qc', name: 'Québec', lat: 52.9399, lng: -73.5491 },
            { code: 'on', name: 'Ontario', lat: 51.2538, lng: -85.3232 },
            { code: 'bc', name: 'Colombie-Britannique', lat: 53.7267, lng: -127.6476 },
            { code: 'ab', name: 'Alberta', lat: 53.9333, lng: -116.5765 }
        ];
        
        // Données statiques enrichies
        this.staticPlaces = [
            {
                id: 1, name: 'Centre des Congrès de Québec',
                description: 'Centre de congrès moderne pour événements d\'affaires et conférences internationales.',
                latitude: 46.809, longitude: -71.221,
                category: 'business', province: 'qc',
                address: '1000 Bd René-Lévesque E, Québec, QC G1R 5T8',
                video_id: 'g6C3qNRmXz0', img: 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=400&h=150&fit=crop'
            },
            {
                id: 2, name: 'Château Frontenac',
                description: 'Hôtel historique emblématique pour événements d\'entreprise et séminaires de luxe.',
                latitude: 46.8117, longitude: -71.2044,
                category: 'hotel', province: 'qc',
                address: '1 Rue des Carrières, Québec, QC G1R 4P5',
                video_id: '7Pq-S557XQU', img: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=150&fit=crop'
            },
            {
                id: 3, name: 'Vieux-Port de Montréal',
                description: 'Destination touristique animée avec boutiques, restaurants et activités culturelles.',
                latitude: 45.5080, longitude: -73.5525,
                category: 'tourism', province: 'qc',
                video_id: 'Bk4KkC3Efdw', img: 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?w=400&h=150&fit=crop'
            }
        ];
        
        if (!this.root || !this.mapContainer) {
            this.animateCounters();
            return;
        }

        this.init();
    }
    
    init() {
        try {
            this.initMap();
            this.populatePlaces();
            this.setupListeners();
            this.animateCounters();
            console.log('BusinessTourism App ready');
        } catch (error) {
            console.error('Error init BusinessTourismApp:', error);
        }
    }
    
    initMap() {
        const mapContainer = this.mapContainer;
        if (!mapContainer || typeof L === 'undefined') return;

        if (mapContainer._leaflet_id) {
            return;
        }

        // Centrer sur le Canada
        this.map = L.map(mapContainer).setView([56.1304, -106.3468], 4);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributeurs',
            maxZoom: 19
        }).addTo(this.map);
    }
    
    populatePlaces() {
        this.places = this.staticPlaces;
        this.renderPlaces();
        this.addMarkers();
    }
    
    addMarkers() {
        if (!this.map) return;
        Object.values(this.markers).forEach(m => m.remove());
        this.markers = {};
        
        this.places.forEach(place => {
            const icon = L.divIcon({
                className: 'custom-marker',
                html: `<div style="background:${this.getCategoryColor(place.category)}; width:30px; height:30px; border-radius:50%; border:3px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.2); display:flex; align-items:center; justify-content:center; color:#fff; font-size:12px;"><i class="${this.getCategoryIcon(place.category)}"></i></div>`,
                iconSize: [30, 30],
                iconAnchor: [15, 30]
            });
            
            const marker = L.marker([place.latitude, place.longitude], { icon })
                .addTo(this.map)
                .on('click', () => this.showModal(place))
                .on('mouseover', () => this.highlightPlace(place.id));
                
            this.markers[place.id] = marker;
        });
    }
    
    renderPlaces() {
        const list = document.getElementById('places-list');
        if (!list) return;
        
        list.innerHTML = this.places.map(place => `
            <div class="bt-place-card" data-id="${place.id}" onclick="window.btApp.centerOnPlace(${place.id})">
                <div class="bt-place-img"><img src="${place.img}" alt="${place.name}"></div>
                <div class="bt-place-name">${place.name}</div>
                <span class="bt-place-cat" style="background:${this.getCategoryColor(place.category)}">${place.category.toUpperCase()}</span>
            </div>
        `).join('');
    }
    
    highlightPlace(id) {
        document.querySelectorAll('.bt-place-card').forEach(c => c.classList.remove('active'));
        const card = document.querySelector(`.bt-place-card[data-id="${id}"]`);
        if (card) {
            card.classList.add('active');
            card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
    
    centerOnPlace(id) {
        const place = this.staticPlaces.find(p => p.id === id);
        if (place && this.map) {
            this.map.setView([place.latitude, place.longitude], 12);
            this.highlightPlace(id);
        }
    }
    
    showModal(place) {
        const modal = document.getElementById('place-modal');
        const body = document.getElementById('modal-content-body') || document.getElementById('modal-content');
        if (!modal || !body) return;
        
        body.innerHTML = `
            <div style="background:#fff; padding:40px;">
                <h3 style="font-size:24px; font-weight:800; margin-bottom:10px;">${place.name}</h3>
                <p style="color:#666; margin-bottom:20px;">${place.description}</p>
                
                <div style="aspect-ratio:16/9; border-radius:16px; overflow:hidden; background:#000; margin-bottom:30px;">
                    <iframe src="https://www.youtube.com/embed/${place.video_id}?autoplay=1" style="width:100%; height:100%; border:none;" allowfullscreen></iframe>
                </div>
                
                <div style="display:flex; gap:15px;">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${place.latitude},${place.longitude}" target="_blank" style="flex:1; background:#1a3a8f; color:#fff; text-align:center; padding:15px; border-radius:12px; font-weight:700; text-decoration:none;"><i class="fas fa-route"></i> ITINÉRAIRE</a>
                    <button onclick="window.btApp.closeModal()" style="flex:1; background:#f5f5f5; border:none; padding:15px; border-radius:12px; font-weight:700; cursor:pointer;">FERMER</button>
                </div>
            </div>
        `;
        
        modal.style.display = 'block';
    }
    
    closeModal() {
        const modal = document.getElementById('place-modal');
        const body = document.getElementById('modal-content-body') || document.getElementById('modal-content');
        if (modal) modal.style.display = 'none';
        if (body) body.innerHTML = '';
    }
    
    getCategoryColor(cat) {
        const colors = { business: '#2a5bd7', hotel: '#00c9b7', tourism: '#d32f2f', restaurant: '#f39c12' };
        return colors[cat] || '#718096';
    }
    
    getCategoryIcon(cat) {
        const icons = { business: 'fa-briefcase', hotel: 'fa-hotel', tourism: 'fa-camera', restaurant: 'fa-utensils' };
        return icons[cat] || 'fa-map-marker-alt';
    }
    
    setupListeners() {
        document.getElementById('province-filter')?.addEventListener('change', (e) => {
            this.selectedProvince = e.target.value;
            this.filterPlaces();
        });
        
        document.getElementById('category-filter')?.addEventListener('change', (e) => {
            this.selectedCategory = e.target.value;
            this.filterPlaces();
        });
        
        document.getElementById('locate-me')?.addEventListener('click', () => this.locateUser());
        document.getElementById('closePlaceModal')?.addEventListener('click', () => this.closeModal());
    }
    
    filterPlaces() {
        this.places = this.staticPlaces.filter(p => {
            const catMatch = this.selectedCategory === 'all' || p.category === this.selectedCategory;
            const provMatch = !this.selectedProvince || p.province === this.selectedProvince;
            return catMatch && provMatch;
        });
        
        this.renderPlaces();
        this.addMarkers();
        
        if (this.map && this.places.length > 0 && typeof L !== 'undefined') {
            const bounds = L.latLngBounds(this.places.map(p => [p.latitude, p.longitude]));
            this.map.fitBounds(bounds, { padding: [50, 50] });
        }
    }
    
    locateUser() {
        if (!this.map) return;
        if (!navigator.geolocation) return alert('Géolocalisation non supportée');
        
        navigator.geolocation.getCurrentPosition(pos => {
            const { latitude, longitude } = pos.coords;
            this.map.setView([latitude, longitude], 12);
            if (this.userMarker) this.userMarker.remove();
            this.userMarker = L.marker([latitude, longitude], { icon: L.icon({ iconUrl: 'https://cdn-icons-png.flaticon.com/512/0/622.png', iconSize: [40, 40] }) }).addTo(this.map);
        });
    }
    
    animateCounters() {
        const counters = document.querySelectorAll('.bt-stat-number');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-count');
            let count = 0;
            const update = () => {
                const inc = target / 50;
                if (count < target) {
                    count += inc;
                    counter.innerText = Math.ceil(count) + (counter.innerText.includes('%') ? '%' : '');
                    setTimeout(update, 20);
                } else {
                    counter.innerText = target + (counter.innerText.includes('%') ? '%' : '');
                }
            };
            update();
        });
    }
}

document.addEventListener('DOMContentLoaded', () => { window.btApp = new BusinessTourismApp(); });
