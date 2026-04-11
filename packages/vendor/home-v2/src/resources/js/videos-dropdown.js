/**
 * Videos Dropdown Menu - Gestion du menu déroulant des vidéos
 * Charge et affiche les vidéos, gère l'ouverture du lecteur vidéo
 */

class VideosDropdownMenu {
    constructor() {
        this.dropdownList = document.getElementById('videosDropdownList');
        this.videosMenuItem = document.getElementById('videosMenuItem');
        
        // Données des vidéos (mock data - à remplacer par des vraies données)
        this.videos = [
            {
                id: 1,
                title: 'Découvrez les merveilles du Québec',
                category: 'Tourisme',
                date: '15 Mars 2024',
                duration: '12:45',
                thumbnail: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg',
                videoUrl: 'home2/videos/hero-video-1.mp4.mp4',
                description: 'Une exploration fascinante des plus beaux sites touristiques du Québec'
            },
            {
                id: 2,
                title: 'Guide complet des restaurants de Montréal',
                category: 'Gastronomie',
                date: '12 Mars 2024',
                duration: '8:30',
                thumbnail: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg',
                videoUrl: 'home2/videos/hero-video-2.mp4.mp4',
                description: 'Les meilleurs restaurants et expériences culinaires de Montréal'
            },
            {
                id: 3,
                title: 'Activités d\'hiver au Canada',
                category: 'Aventure',
                date: '10 Mars 2024',
                duration: '15:20',
                thumbnail: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg',
                videoUrl: 'home2/videos/hero-video-3.mp4.mp4',
                description: 'Ski, raquette et autres activités hivernales exceptionnelles'
            },
            {
                id: 4,
                title: 'Hébergements de luxe à Québec',
                category: 'Hôtels',
                date: '8 Mars 2024',
                duration: '10:15',
                thumbnail: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg',
                videoUrl: 'home2/videos/hero-video-1.mp4.mp4',
                description: 'Les plus beaux hôtels et hébergements de la ville de Québec'
            },
            {
                id: 5,
                title: 'Événements culturels de l\'été',
                category: 'Culture',
                date: '5 Mars 2024',
                duration: '11:40',
                thumbnail: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg',
                videoUrl: 'home2/videos/hero-video-2.mp4.mp4',
                description: 'Festivals, concerts et événements culturels à ne pas manquer'
            },
            {
                id: 6,
                title: 'Parcs nationaux du Québec',
                category: 'Nature',
                date: '2 Mars 2024',
                duration: '14:25',
                thumbnail: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg',
                videoUrl: 'home2/videos/hero-video-3.mp4.mp4',
                description: 'Exploration des plus beaux parcs nationaux et réserves naturelles'
            },
            {
                id: 7,
                title: 'Histoire et patrimoine de Montréal',
                category: 'Histoire',
                date: '28 Fév 2024',
                duration: '9:50',
                thumbnail: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg',
                videoUrl: 'home2/videos/hero-video-1.mp4.mp4',
                description: 'Découvrez l\'histoire fascinante de Montréal et son patrimoine'
            },
            {
                id: 8,
                title: 'Activités familiales au Québec',
                category: 'Famille',
                date: '25 Fév 2024',
                duration: '13:10',
                thumbnail: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg',
                videoUrl: 'home2/videos/hero-video-2.mp4.mp4',
                description: 'Les meilleures activités pour toute la famille'
            }
        ];
        
        this.init();
    }
    
    init() {
        this.renderVideos();
        this.attachEventListeners();
    }
    
    renderVideos() {
        if (!this.dropdownList) return;
        
        if (this.videos.length === 0) {
            this.dropdownList.innerHTML = `
                <div class="nav-videos-empty">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <p>Aucune vidéo disponible pour le moment</p>
                </div>
            `;
            return;
        }
        
        const videosHTML = this.videos.map(video => `
            <div class="nav-video-item" data-video-id="${video.id}">
                <div class="nav-video-thumbnail">
                    <img src="${video.thumbnail}" alt="${video.title}">
                    <div class="nav-video-play-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                    <span class="nav-video-duration">${video.duration}</span>
                </div>
                <div class="nav-video-info">
                    <h4 class="nav-video-title">${video.title}</h4>
                    <div class="nav-video-meta">
                        <span class="nav-video-category">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            ${video.category}
                        </span>
                        <span class="nav-video-date">${video.date}</span>
                    </div>
                </div>
            </div>
        `).join('');
        
        this.dropdownList.innerHTML = videosHTML;
    }
    
    attachEventListeners() {
        if (!this.dropdownList) return;
        
        // Événement de clic sur les items vidéo
        this.dropdownList.addEventListener('click', (e) => {
            const videoItem = e.target.closest('.nav-video-item');
            if (!videoItem) return;
            
            const videoId = parseInt(videoItem.dataset.videoId);
            const video = this.videos.find(v => v.id === videoId);
            
            if (video) {
                this.openVideoPlayer(video);
            }
        });
        
        // NE PAS stopPropagation ici, ça bloquait la fermeture du dropdown
    }
    
    openVideoPlayer(video) {
        // FERMER LE DROPDOWN IMMÉDIATEMENT avant d'ouvrir le lecteur
        const dropdown = document.getElementById('videosDropdown');
        if (dropdown) {
            dropdown.classList.remove('active');
        }

        console.log('[VideosDropdown] Tentative d\'ouverture de la vidéo:', video);
        console.log('[VideosDropdown] VideoModalInstance disponible:', !!window.VideoModalInstance);

        // Utiliser l'instance globale de VideoModal
        if (window.VideoModalInstance) {
            const videoData = {
                id: video.youtubeId || 'dQw4w9WgXcQ',
                title: video.title,
                category: video.category,
                date: video.date,
                description: video.description,
                thumbnail: video.thumbnail
            };
            window.VideoModalInstance.open(videoData);
            console.log('[VideosDropdown] Modal ouverte avec succès');
        } else {
            console.error('[VideosDropdown] VideoModal instance NON disponible');
        }
    }
}

// Initialiser le menu déroulant des vidéos au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    new VideosDropdownMenu();
});
