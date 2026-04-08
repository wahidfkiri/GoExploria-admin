/**
 * Viewing Carousel V2 - Grille de visionnage vidéo
 * Gestion des clics sur les vidéos
 */

class ViewingCarouselV2 {
    constructor() {
        this.modal = document.getElementById('videoModal');
        this.modalPlayer = document.getElementById('modalVideoPlayer');
        this.modalTitle = document.getElementById('modalTitle');
        this.modalBadge = document.getElementById('modalBadge');
        this.modalDate = document.getElementById('modalDate');
        this.modalDescription = document.getElementById('modalDescription');
        this.modalPlaylistItems = document.getElementById('modalPlaylistItems');
        this.closeBtn = document.getElementById('closeModal');
        
        console.log('[ViewingCarousel] Éléments DOM trouvés:', {
            modal: !!this.modal,
            modalPlayer: !!this.modalPlayer,
            modalTitle: !!this.modalTitle,
            closeBtn: !!this.closeBtn
        });
        
        if (!this.modal) {
            console.error('[ViewingCarousel] ERREUR: La modal #videoModal n\'existe pas dans le DOM!');
        }
        
        this.videos = [
            {
                id: 'dQw4w9WgXcQ',
                title: 'This is the power of gathering: it inspire...',
                category: 'GENERAL',
                date: 'AUGUST 28, 2022',
                description: 'Découvrez comment le pouvoir du rassemblement peut inspirer et transformer nos vies. Une exploration fascinante des dynamiques sociales.',
                thumbnail: 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg'
            },
            {
                id: 'dQw4w9WgXcQ',
                title: 'There are big problems that...',
                category: 'NEWS',
                date: 'APRIL 2, 2022',
                description: 'Analyse approfondie des grands défis auxquels nous sommes confrontés aujourd\'hui et les solutions possibles pour l\'avenir.',
                thumbnail: 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg'
            },
            {
                id: 'dQw4w9WgXcQ',
                title: 'We are part of this universe; we are in...',
                category: 'SPECIAL',
                date: 'MAY 11, 2022',
                description: 'Une réflexion profonde sur notre place dans l\'univers et notre connexion avec le cosmos qui nous entoure.',
                thumbnail: 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg'
            },
            {
                id: 'dQw4w9WgXcQ',
                title: 'What we have once enjoyed we can nev...',
                category: 'NEWS',
                date: 'JANUARY 1, 2022',
                description: 'Les souvenirs précieux et les moments inoubliables qui façonnent notre existence et notre vision du monde.',
                thumbnail: 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg'
            }
        ];
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.generatePlaylist();
    }

    setupEventListeners() {
        // Gérer les clics sur les cartes vidéo
        const videoCards = document.querySelectorAll('.viewing-carousel-v2-card');
        
        videoCards.forEach((card, index) => {
            const playBtn = card.querySelector('.viewing-carousel-v2-play-btn');
            const videoWrapper = card.querySelector('.viewing-carousel-v2-video');
            
            // Limiter l'index aux 4 premières vidéos (ignorer les duplicatas)
            const videoIndex = index % 4;
            
            // Clic sur le bouton play
            if (playBtn) {
                playBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.openModal(videoIndex);
                });
            }
            
            // Clic sur toute la carte
            if (videoWrapper) {
                videoWrapper.addEventListener('click', () => {
                    this.openModal(videoIndex);
                });
            }
        });

        // Fermer la modal
        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', () => {
                this.closeModal();
            });
        }

        // Fermer en cliquant sur l'overlay
        if (this.modal) {
            const overlay = this.modal.querySelector('.viewing-carousel-v2-modal-overlay');
            if (overlay) {
                overlay.addEventListener('click', () => {
                    this.closeModal();
                });
            }
        }

        // Fermer avec la touche Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal.style.display === 'flex') {
                this.closeModal();
            }
        });
    }

    generatePlaylist() {
        if (!this.modalPlaylistItems) return;

        this.modalPlaylistItems.innerHTML = '';
        
        this.videos.forEach((video, index) => {
            const item = document.createElement('li');
            item.className = 'viewing-carousel-v2-modal-playlist-item';
            if (index === 0) item.classList.add('active');
            
            item.innerHTML = `
                <div class="viewing-carousel-v2-modal-playlist-thumbnail">
                    <img src="${video.thumbnail}" alt="${video.title}">
                </div>
                <div class="viewing-carousel-v2-modal-playlist-info">
                    <p class="viewing-carousel-v2-modal-playlist-category">${video.category}</p>
                    <h4 class="viewing-carousel-v2-modal-playlist-name">${video.title}</h4>
                    <p class="viewing-carousel-v2-modal-playlist-date">${video.date}</p>
                </div>
            `;
            
            item.addEventListener('click', () => {
                this.loadVideo(index);
            });
            
            this.modalPlaylistItems.appendChild(item);
        });
    }

    openModal(videoIndex) {
        console.log('[ViewingCarousel] openModal appelé avec index:', videoIndex);
        
        if (!this.modal) {
            console.error('[ViewingCarousel] Impossible d\'ouvrir la modal - élément modal introuvable');
            return;
        }
        
        console.log('[ViewingCarousel] Ouverture de la modal...');
        this.modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        this.loadVideo(videoIndex);
        console.log('[ViewingCarousel] Modal affichée avec succès');
    }

    closeModal() {
        if (!this.modal) return;
        
        this.modal.style.display = 'none';
        document.body.style.overflow = '';
        
        // Arrêter la vidéo
        if (this.modalPlayer) {
            this.modalPlayer.src = '';
        }
    }

    loadVideo(index) {
        const video = this.videos[index];
        if (!video) return;

        // Charger la vidéo YouTube
        if (this.modalPlayer) {
            this.modalPlayer.src = `https://www.youtube.com/embed/${video.id}?autoplay=1`;
        }

        // Mettre à jour les informations
        if (this.modalTitle) this.modalTitle.textContent = video.title;
        if (this.modalBadge) this.modalBadge.textContent = video.category;
        if (this.modalDate) this.modalDate.textContent = video.date;
        if (this.modalDescription) this.modalDescription.textContent = video.description;

        // Mettre à jour la playlist active
        const items = this.modalPlaylistItems.querySelectorAll('.viewing-carousel-v2-modal-playlist-item');
        items.forEach((item, i) => {
            if (i === index) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }
}

// Initialiser le carousel au chargement du DOM et le rendre accessible globalement
let viewingCarouselInstance = null;

document.addEventListener('DOMContentLoaded', () => {
    viewingCarouselInstance = new ViewingCarouselV2();
    window.ViewingCarouselV2Instance = viewingCarouselInstance;
    console.log('[ViewingCarousel] Instance créée et accessible globalement:', window.ViewingCarouselV2Instance);
});
