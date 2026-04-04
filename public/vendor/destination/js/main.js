 // ============================================
        // MODAL VIDÉO
        // ============================================
        function openVideoModal(videoId) {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('videoIframe');
            iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
            modal.style.display = 'flex';
        }

        function closeVideoModal() {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('videoIframe');
            iframe.src = '';
            modal.style.display = 'none';
        }

        // Écouteurs vidéos
        document.querySelectorAll('.video-card').forEach(card => {
            card.addEventListener('click', () => {
                const videoId = card.dataset.video;
                if(videoId) openVideoModal(videoId);
            });
        });

        // ============================================
        // CARTE LEAFLET
        // ============================================
        let map;
        let markers = [];
        
        // Données des lieux
        const places = [
            { id: 1, name: "Musée des Beaux-Arts", lat: 45.4986, lng: -73.5798, category: "museum", city: "Montréal", desc: "Plus grand musée d'art du Canada", videoId: "dQw4w9WgXcQ" },
            { id: 2, name: "Château Frontenac", lat: 46.8123, lng: -71.2050, category: "hotel", city: "Québec", desc: "Hôtel emblématique de Québec", videoId: "9bZkp7q19f0" },
            { id: 3, name: "Restaurant Le Saint-Amour", lat: 46.8110, lng: -71.2070, category: "restaurant", city: "Québec", desc: "Cuisine gastronomique française", videoId: "OPf0YbXqDm0" },
            { id: 4, name: "Mont-Tremblant", lat: 46.1169, lng: -74.5982, category: "activity", city: "Mont-Tremblant", desc: "Station de ski renommée", videoId: "L_jWHffIx5E" },
            { id: 5, name: "Vieux-Port de Montréal", lat: 45.5088, lng: -73.5540, category: "activity", city: "Montréal", desc: "Activités nautiques et promenades", videoId: "dQw4w9WgXcQ" },
            { id: 6, name: "Hôtel de Glace", lat: 46.8267, lng: -71.2246, category: "hotel", city: "Québec", desc: "Expérience unique en glace", videoId: "9bZkp7q19f0" }
        ];

        function initMap() {
            map = L.map('interactiveMap').setView([46.5, -71.5], 6);
            
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> & CartoDB'
            }).addTo(map);

            updateMarkers();
            updateDestinationsList();
        }

        function updateMarkers() {
            // Supprimer anciens marqueurs
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            const regionFilter = document.getElementById('regionFilter').value;
            const categoryFilter = document.getElementById('categoryFilter').value;

            const filtered = places.filter(place => {
                if(regionFilter && place.city !== regionFilter) return false;
                if(categoryFilter && place.category !== categoryFilter) return false;
                return true;
            });

            document.getElementById('resultsCount').innerText = filtered.length;

            filtered.forEach(place => {
                const customIcon = L.divIcon({
                    html: `<div style="background: #1a472a; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.3); border: 2px solid white;">
                        <i class="fas ${getCategoryIcon(place.category)}"></i>
                    </div>`,
                    className: 'custom-marker',
                    iconSize: [32, 32],
                    popupAnchor: [0, -16]
                });

                const marker = L.marker([place.lat, place.lng], { icon: customIcon }).addTo(map);
                
                const popupContent = `
                    <div class="custom-popup" style="min-width: 260px;">
                        <div class="popup-video">
                            <iframe src="https://www.youtube.com/embed/${place.videoId}" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <div class="popup-info">
                            <h4>${place.name}</h4>
                            <p>${place.desc}</p>
                            <small><i class="fas fa-map-marker-alt"></i> ${place.city}</small>
                        </div>
                    </div>
                `;
                marker.bindPopup(popupContent);
                markers.push(marker);
            });
        }

        function getCategoryIcon(category) {
            const icons = {
                restaurant: 'fa-utensils',
                museum: 'fa-landmark',
                hotel: 'fa-hotel',
                activity: 'fa-hiking'
            };
            return icons[category] || 'fa-map-pin';
        }

        function updateDestinationsList() {
            const regionFilter = document.getElementById('regionFilter').value;
            const categoryFilter = document.getElementById('categoryFilter').value;
            
            const filtered = places.filter(place => {
                if(regionFilter && place.city !== regionFilter) return false;
                if(categoryFilter && place.category !== categoryFilter) return false;
                return true;
            });

            const container = document.getElementById('destinationsList');
            if(filtered.length === 0) {
                container.innerHTML = '<p style="text-align: center; color: #999;">Aucun lieu trouvé</p>';
                return;
            }

            container.innerHTML = filtered.map(place => `
                <div class="destination-item" onclick="focusOnPlace(${place.lat}, ${place.lng})">
                    <div class="destination-icon">
                        <i class="fas ${getCategoryIcon(place.category)}"></i>
                    </div>
                    <div class="destination-details">
                        <h5>${place.name}</h5>
                        <p>${place.city} • ${place.desc.substring(0, 40)}...</p>
                    </div>
                </div>
            `).join('');
        }

        function focusOnPlace(lat, lng) {
            map.setView([lat, lng], 14);
            // Trouver et ouvrir le popup correspondant
            markers.forEach(marker => {
                if(marker.getLatLng().lat === lat && marker.getLatLng().lng === lng) {
                    marker.openPopup();
                }
            });
        }

        // Géolocalisation
        document.getElementById('locateBtn').addEventListener('click', () => {
            if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    map.setView([position.coords.latitude, position.coords.longitude], 12);
                    L.marker([position.coords.latitude, position.coords.longitude])
                        .addTo(map)
                        .bindPopup("Vous êtes ici")
                        .openPopup();
                });
            } else {
                alert("Géolocalisation non supportée");
            }
        });

        // Filtres
        document.getElementById('regionFilter').addEventListener('change', () => {
            updateMarkers();
            updateDestinationsList();
        });
        document.getElementById('categoryFilter').addEventListener('change', () => {
            updateMarkers();
            updateDestinationsList();
        });

        // Initialisation
        document.addEventListener('DOMContentLoaded', () => {
            initMap();
        });