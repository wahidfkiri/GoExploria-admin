/**
 * Video Modal - Lecteur vidéo réutilisable pour toute la plateforme
 * Peut être utilisé depuis n'importe quel composant
 */

class VideoModal {
    constructor() {
        this.modal = document.getElementById('videoModal');
        this.modalPlayer = document.getElementById('videoModalPlayer');
        this.modalTitle = document.getElementById('videoModalTitle');
        this.modalBadge = document.getElementById('videoModalBadge');
        this.modalDate = document.getElementById('videoModalDate');
        this.modalDescription = document.getElementById('videoModalDescription');
        this.modalPlaylistItems = document.getElementById('videoModalPlaylistItems');
        this.closeBtn = document.getElementById('closeVideoModal');
        
        console.log('[VideoModal] Éléments DOM trouvés:', {
            modal: !!this.modal,
            modalPlayer: !!this.modalPlayer,
            modalTitle: !!this.modalTitle,
            closeBtn: !!this.closeBtn
        });
        
        if (!this.modal) {
            console.error('[VideoModal] ERREUR: La modal #videoModal n\'existe pas dans le DOM!');
        }
        
        this.videos = [];
        this.currentVideoIndex = 0;
        
        this.init();
    }

    init() {
        this.setupEventListeners();
    }

    setupEventListeners() {
        // Fermer la modal
        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', () => {
                this.closeModal();
            });
        }

        // Fermer en cliquant sur l'overlay
        if (this.modal) {
            const overlay = this.modal.querySelector('.video-modal-overlay');
            if (overlay) {
                overlay.addEventListener('click', () => {
                    this.closeModal();
                });
            }
        }

        // Fermer avec la touche Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal && this.modal.style.display === 'flex') {
                this.closeModal();
            }
        });
    }

    /**
     * Ouvrir la modal avec une vidéo
     * @param {Object} videoData - Données de la vidéo {id, title, category, date, description, thumbnail}
     * @param {Array} playlist - Liste optionnelle de vidéos pour la playlist
     */
    open(videoData, playlist = []) {
        console.log('[VideoModal] Ouverture avec vidéo:', videoData);
        
        if (!this.modal) {
            console.error('[VideoModal] Impossible d\'ouvrir la modal - élément modal introuvable');
            return;
        }

        // Ajouter la vidéo à la playlist si elle n'existe pas
        const existingIndex = this.videos.findIndex(v => v.id === videoData.id && v.title === videoData.title);
        
        if (existingIndex !== -1) {
            this.currentVideoIndex = existingIndex;
        } else {
            this.videos.push(videoData);
            this.currentVideoIndex = this.videos.length - 1;
        }

        // Ajouter les vidéos de la playlist si fournie
        if (playlist.length > 0) {
            playlist.forEach(video => {
                const exists = this.videos.findIndex(v => v.id === video.id && v.title === video.title);
                if (exists === -1) {
                    this.videos.push(video);
                }
            });
        }

        this.generatePlaylist();
        this.modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        this.loadVideo(this.currentVideoIndex);
        
        console.log('[VideoModal] Modal affichée avec succès');
    }

    closeModal() {
        if (!this.modal) return;
        
        this.modal.style.display = 'none';
        document.body.style.overflow = '';
        
        // Arrêter la vidéo
        if (this.modalPlayer) {
            this.modalPlayer.src = '';
        }
        
        console.log('[VideoModal] Modal fermée');
    }

    loadVideo(index) {
        const video = this.videos[index];
        if (!video) return;

        this.currentVideoIndex = index;

        // Charger le média (Vidéo YouTube ou Image)
        if (this.modalPlayer) {
            this.modalPlayer.parentElement.innerHTML = ''; // Nettoyer le conteneur
            const container = this.modalPlayer.parentElement || document.getElementById('videoModalPlayerContainer');
            
            if (video.type === 'image') {
                const img = document.createElement('img');
                img.src = video.id; // Dans ce cas, l'id est l'URL de l'image
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'contain';
                img.id = 'videoModalPlayer'; // On garde l'ID pour la reférence futur
                container.appendChild(img);
                this.modalPlayer = img;
            } else {
                const iframe = document.createElement('iframe');
                iframe.src = `https://www.youtube.com/embed/${video.id}?autoplay=1`;
                iframe.style.width = '100%';
                iframe.style.height = '100%';
                iframe.style.border = 'none';
                iframe.allow = 'autoplay; encrypted-media';
                iframe.allowFullscreen = true;
                iframe.id = 'videoModalPlayer';
                container.appendChild(iframe);
                this.modalPlayer = iframe;
            }
        }

        // Mettre à jour les informations
        if (this.modalTitle) this.modalTitle.textContent = video.title;
        if (this.modalBadge) this.modalBadge.textContent = video.category || 'GENERAL';
        if (this.modalDate) this.modalDate.textContent = video.date || '';
        if (this.modalDescription) this.modalDescription.textContent = video.description || '';

        // Mettre à jour la playlist active
        const items = this.modalPlaylistItems.querySelectorAll('.video-modal-playlist-item');
        items.forEach((item, i) => {
            if (i === index) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
        
        console.log('[VideoModal] Vidéo chargée:', video.title);
    }

    generatePlaylist() {
        if (!this.modalPlaylistItems) return;

        this.modalPlaylistItems.innerHTML = '';
        
        this.videos.forEach((video, index) => {
            const item = document.createElement('li');
            item.className = 'video-modal-playlist-item';
            if (index === this.currentVideoIndex) item.classList.add('active');
            
            item.innerHTML = `
                <div class="video-modal-playlist-thumbnail">
                    <img src="${video.thumbnail || 'https://img.youtube.com/vi/' + video.id + '/mqdefault.jpg'}" alt="${video.title}">
                </div>
                <div class="video-modal-playlist-info">
                    <p class="video-modal-playlist-category">${video.category || 'GENERAL'}</p>
                    <h4 class="video-modal-playlist-name">${video.title}</h4>
                    <p class="video-modal-playlist-date">${video.date || ''}</p>
                </div>
            `;
            
            item.addEventListener('click', () => {
                this.loadVideo(index);
            });
            
            this.modalPlaylistItems.appendChild(item);
        });
    }

    /**
     * Réinitialiser la playlist
     */
    clearPlaylist() {
        this.videos = [];
        this.currentVideoIndex = 0;
        if (this.modalPlaylistItems) {
            this.modalPlaylistItems.innerHTML = '';
        }
    }
}

// Initialiser la modal au chargement du DOM et la rendre accessible globalement
let videoModalInstance = null;

document.addEventListener('DOMContentLoaded', () => {
    videoModalInstance = new VideoModal();
    window.VideoModalInstance = videoModalInstance;
    console.log('[VideoModal] Instance créée et accessible globalement:', window.VideoModalInstance);
});
