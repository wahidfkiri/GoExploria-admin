/**
 * Menu Vertical V2 Controller
 * Gère l'ouverture/fermeture du menu vertical principal
 */

class VerticalMenuV2 {
    constructor() {
        this.menu = document.getElementById('verticalMenuV2');
        this.overlay = document.getElementById('verticalMenuOverlay');
        this.openBtn = document.getElementById('openVerticalMenu');
        this.closeBtn = document.getElementById('closeVerticalMenu');
        this.menuLinks = document.querySelectorAll('.vertical-menu-v2-link');
        this.isOpen = false;
        
        this.init();
    }
    
    init() {
        if (!this.menu || !this.overlay || !this.openBtn) return;
        
        // Ouvrir le menu
        this.openBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            this.openMenu();
        });
        
        // Fermer le menu
        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', () => {
                this.closeMenu();
            });
        }
        
        // Fermer en cliquant sur l'overlay
        this.overlay.addEventListener('click', () => {
            this.closeMenu();
        });
        
        // Fermer au clic sur un lien (sauf accordéon)
        this.menuLinks.forEach(link => {
            if (!link.classList.contains('vertical-menu-v2-accordion-trigger')) {
                link.addEventListener('click', () => {
                    this.closeMenu();
                });
            }
        });
        
        // Gestion de l'accordéon
        this.initAccordion();
        
        // Charger les vidéos dans le sous-menu
        this.loadVideosSubmenu();
        
        // Fermer les sous-menus au clic
        const subLinks = document.querySelectorAll('.vertical-menu-v2-sublink');
        subLinks.forEach(link => {
            link.addEventListener('click', () => {
                this.closeMenu();
            });
        });
        
        // Fermer avec la touche Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.closeMenu();
            }
        });
        
        // Empêcher le scroll du body quand le menu est ouvert
        this.menu.addEventListener('touchmove', (e) => {
            e.stopPropagation();
        }, { passive: false });
    }
    
    initAccordion() {
        const accordionTriggers = document.querySelectorAll('.vertical-menu-v2-accordion-trigger');
        
        accordionTriggers.forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                const parentItem = trigger.closest('.vertical-menu-v2-accordion');
                const isActive = parentItem.classList.contains('active');
                
                // Fermer tous les autres accordéons
                document.querySelectorAll('.vertical-menu-v2-accordion').forEach(item => {
                    if (item !== parentItem) {
                        item.classList.remove('active');
                    }
                });
                
                // Toggle l'accordéon actuel
                if (isActive) {
                    parentItem.classList.remove('active');
                } else {
                    parentItem.classList.add('active');
                }
            });
        });
    }
    
    openMenu() {
        this.isOpen = true;
        this.menu.classList.add('active');
        this.overlay.classList.add('active');
        this.openBtn.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Afficher les items instantanément sans animation
        const items = this.menu.querySelectorAll('.vertical-menu-v2-item');
        items.forEach((item) => {
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        });
    }
    
    closeMenu() {
        this.isOpen = false;
        this.menu.classList.remove('active');
        this.overlay.classList.remove('active');
        this.openBtn.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    toggleMenu() {
        if (this.isOpen) {
            this.closeMenu();
        } else {
            this.openMenu();
        }
    }
    
    loadVideosSubmenu() {
        const videosSubmenu = document.getElementById('submenu-videos');
        if (!videosSubmenu) return;
        
        // Données des vidéos (identiques à celles du dropdown)
        const videos = [
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
        
        if (videos.length === 0) {
            videosSubmenu.innerHTML = `
                <div class="vertical-menu-v2-videos-empty">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <p>Aucune vidéo disponible</p>
                </div>
            `;
            return;
        }
        
        const videosHTML = videos.map(video => `
            <li class="vertical-menu-v2-video-item" data-video-id="${video.id}">
                <div class="vertical-menu-v2-video-thumbnail">
                    <img src="${video.thumbnail}" alt="${video.title}">
                    <div class="vertical-menu-v2-video-play-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                    <span class="vertical-menu-v2-video-duration">${video.duration}</span>
                </div>
                <div class="vertical-menu-v2-video-info">
                    <h4 class="vertical-menu-v2-video-title">${video.title}</h4>
                    <div class="vertical-menu-v2-video-meta">
                        <span class="vertical-menu-v2-video-category">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            ${video.category}
                        </span>
                        <span class="vertical-menu-v2-video-date">${video.date}</span>
                    </div>
                </div>
            </li>
        `).join('');
        
        videosSubmenu.innerHTML = videosHTML;
        
        // Ajouter les événements de clic sur les vidéos
        videosSubmenu.querySelectorAll('.vertical-menu-v2-video-item').forEach(item => {
            item.addEventListener('click', (e) => {
                e.stopPropagation();
                const videoId = parseInt(item.dataset.videoId);
                const video = videos.find(v => v.id === videoId);
                
                if (video) {
                    this.openVideoModal(video);
                    this.closeMenu();
                }
            });
        });
    }
    
    openVideoModal(video) {
        // Ouvrir la modal ViewingCarousel
        const modal = document.getElementById('videoModal');
        if (!modal) {
            console.warn('Modal vidéo non trouvée');
            return;
        }
        
        // Afficher la modal
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Charger la vidéo dans la modal
        const modalPlayer = document.getElementById('modalVideoPlayer');
        const modalTitle = document.getElementById('modalTitle');
        const modalBadge = document.getElementById('modalBadge');
        const modalDate = document.getElementById('modalDate');
        const modalDescription = document.getElementById('modalDescription');
        
        // Charger la vidéo YouTube
        if (modalPlayer) {
            const youtubeId = 'dQw4w9WgXcQ'; // ID par défaut
            modalPlayer.src = `https://www.youtube.com/embed/${youtubeId}?autoplay=1`;
        }
        
        // Mettre à jour les informations
        if (modalTitle) modalTitle.textContent = video.title;
        if (modalBadge) modalBadge.textContent = video.category;
        if (modalDate) modalDate.textContent = video.date;
        if (modalDescription) modalDescription.textContent = video.description;
    }
}

// Initialiser le menu vertical quand le DOM est prêt
document.addEventListener('DOMContentLoaded', () => {
    const menuInstance = new VerticalMenuV2();
    
    // Initialiser les accordéons et vidéos instantanément
    menuInstance.initAccordion();
    menuInstance.loadVideosSubmenu();
});
