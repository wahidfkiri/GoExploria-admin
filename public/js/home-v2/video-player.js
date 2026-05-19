/**
 * Video Player V2 - Lecteur vidéo avec playlist
 * Gestion de la lecture de vidéos et d'images avec playlist interactive
 */

class VideoPlayerV2 {
    constructor() {
        this.videoPlayer = document.getElementById('mainVideoPlayer');
        this.videoTitle = document.getElementById('videoTitle');
        this.videoDescription = document.getElementById('videoDescription');
        this.playlistItems = document.querySelectorAll('.video-player-v2-playlist-item');
        this.playPauseBtn = document.getElementById('playPauseBtn');
        this.volumeBtn = document.getElementById('volumeBtn');
        this.fullscreenBtn = document.getElementById('fullscreenBtn');
        this.progressBar = document.getElementById('progressBar');
        this.progressFilled = document.getElementById('progressFilled');
        this.timeDisplay = document.getElementById('timeDisplay');
        this.mediaCounter = document.getElementById('mediaCounter');
        
        this.currentIndex = 0;
        this.isMuted = false;
        this.isReady = !!(this.videoPlayer && this.playlistItems.length);
        
        this.init();
    }
    
    init() {
        if (!this.isReady) return;
        
        // Événements de clic sur les items de la playlist
        this.playlistItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                this.playMedia(index);
            });
        });
        
        // Événement de fin de vidéo - passer au suivant
        this.videoPlayer.addEventListener('ended', () => {
            this.playNext();
        });
        
        // Contrôles vidéo
        if (this.playPauseBtn) {
            this.playPauseBtn.addEventListener('click', () => this.togglePlayPause());
        }
        
        if (this.volumeBtn) {
            this.volumeBtn.addEventListener('click', () => this.toggleMute());
        }
        
        if (this.fullscreenBtn) {
            this.fullscreenBtn.addEventListener('click', () => this.toggleFullscreen());
        }
        
        if (this.progressBar) {
            this.progressBar.addEventListener('click', (e) => this.seek(e));
        }
        
        // Mise à jour de la progression
        this.videoPlayer.addEventListener('timeupdate', () => this.updateProgress());
        this.videoPlayer.addEventListener('loadedmetadata', () => this.updateTime());
        
        // Mettre à jour le compteur initial
        this.updateCounter();
    }

    isItemVisible(item) {
        return !!item && item.style.display !== 'none';
    }

    getVisibleIndices() {
        const indices = [];
        this.playlistItems.forEach((item, index) => {
            if (this.isItemVisible(item)) {
                indices.push(index);
            }
        });
        return indices;
    }
    
    playMedia(index) {
        if (!this.isReady) return;
        if (index < 0 || index >= this.playlistItems.length) return;
        
        const item = this.playlistItems[index];
        const type = item.dataset.type;
        const src = item.dataset.src;
        const title = item.dataset.title;
        const description = item.dataset.description || '';
        const poster = item.dataset.poster || '';
        
        // Mettre à jour l'index actuel
        this.currentIndex = index;
        
        // Retirer la classe active de tous les items
        this.playlistItems.forEach(i => i.classList.remove('active'));
        
        // Ajouter la classe active à l'item sélectionné
        item.classList.add('active');
        
        // Mettre à jour le titre et la description
        if (this.videoTitle) {
            this.videoTitle.textContent = title;
        }
        if (this.videoDescription) {
            this.videoDescription.textContent = description;
        }
        
        // Mettre à jour le compteur
        this.updateCounter();
        
        if (type === 'video') {
            // Charger et lire la vidéo
            this.videoPlayer.src = src;
            if (poster) {
                this.videoPlayer.poster = poster;
            }
            this.videoPlayer.load();
            this.videoPlayer.play().catch(err => {
                console.log('Lecture automatique bloquée:', err);
            });
            this.updatePlayPauseIcon(false);
        } else if (type === 'image') {
            // Afficher l'image comme poster
            this.videoPlayer.src = '';
            this.videoPlayer.poster = src;
            this.videoPlayer.load();
        }
        
        // Scroll vers l'item dans la playlist si nécessaire
        this.scrollToItem(item);
    }
    
    playNext() {
        const visible = this.getVisibleIndices();
        if (!visible.length) return;

        const currentVisiblePos = visible.indexOf(this.currentIndex);
        const nextPos = currentVisiblePos === -1 ? 0 : (currentVisiblePos + 1) % visible.length;
        this.playMedia(visible[nextPos]);
    }
    
    playPrevious() {
        const visible = this.getVisibleIndices();
        if (!visible.length) return;

        const currentVisiblePos = visible.indexOf(this.currentIndex);
        const prevPos = currentVisiblePos === -1 ? 0 : (currentVisiblePos - 1 + visible.length) % visible.length;
        this.playMedia(visible[prevPos]);
    }
    
    scrollToItem(item) {
        const playlist = document.querySelector('.video-player-v2-playlist-items');
        if (!playlist) return;
        
        const itemTop = item.offsetTop;
        const itemHeight = item.offsetHeight;
        const playlistHeight = playlist.offsetHeight;
        const scrollTop = playlist.scrollTop;
        
        // Vérifier si l'item est visible
        if (itemTop < scrollTop || itemTop + itemHeight > scrollTop + playlistHeight) {
            // Scroll vers l'item
            playlist.scrollTo({
                top: itemTop - (playlistHeight / 2) + (itemHeight / 2),
                behavior: 'smooth'
            });
        }
    }
    
    togglePlayPause() {
        if (!this.videoPlayer) return;
        if (this.videoPlayer.paused) {
            this.videoPlayer.play();
            this.updatePlayPauseIcon(false);
        } else {
            this.videoPlayer.pause();
            this.updatePlayPauseIcon(true);
        }
    }
    
    updatePlayPauseIcon(isPaused) {
        if (!this.playPauseBtn) return;
        const playIcon = this.playPauseBtn.querySelector('.play-icon');
        const pauseIcon = this.playPauseBtn.querySelector('.pause-icon');
        if (!playIcon || !pauseIcon) return;
        
        if (isPaused) {
            playIcon.style.display = 'block';
            pauseIcon.style.display = 'none';
        } else {
            playIcon.style.display = 'none';
            pauseIcon.style.display = 'block';
        }
    }
    
    toggleMute() {
        if (!this.videoPlayer || !this.volumeBtn) return;
        this.isMuted = !this.isMuted;
        this.videoPlayer.muted = this.isMuted;
        
        const volumeOnIcon = this.volumeBtn.querySelector('.volume-on-icon');
        const volumeOffIcon = this.volumeBtn.querySelector('.volume-off-icon');
        if (!volumeOnIcon || !volumeOffIcon) return;
        
        if (this.isMuted) {
            volumeOnIcon.style.display = 'none';
            volumeOffIcon.style.display = 'block';
        } else {
            volumeOnIcon.style.display = 'block';
            volumeOffIcon.style.display = 'none';
        }
    }
    
    toggleFullscreen() {
        if (!this.videoPlayer || !this.videoPlayer.parentElement) return;
        if (!document.fullscreenElement) {
            this.videoPlayer.parentElement.requestFullscreen();
        } else {
            document.exitFullscreen();
        }
    }
    
    seek(e) {
        if (!this.progressBar || !this.videoPlayer || !this.videoPlayer.duration) return;
        const rect = this.progressBar.getBoundingClientRect();
        const percent = (e.clientX - rect.left) / rect.width;
        this.videoPlayer.currentTime = percent * this.videoPlayer.duration;
    }
    
    updateProgress() {
        if (!this.videoPlayer || !this.progressFilled) return;
        const percent = (this.videoPlayer.currentTime / this.videoPlayer.duration) * 100;
        this.progressFilled.style.width = percent + '%';
        this.updateTime();
    }
    
    updateTime() {
        if (!this.videoPlayer || !this.timeDisplay) return;
        const current = this.formatTime(this.videoPlayer.currentTime);
        const duration = this.formatTime(this.videoPlayer.duration);
        this.timeDisplay.textContent = `${current} / ${duration}`;
    }
    
    formatTime(seconds) {
        if (isNaN(seconds)) return '0:00';
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    }
    
    updateCounter() {
        if (!this.mediaCounter) return;

        const visible = this.getVisibleIndices();
        if (!visible.length) {
            this.mediaCounter.textContent = '0 / 0';
            return;
        }

        const currentVisiblePos = visible.indexOf(this.currentIndex);
        const position = currentVisiblePos === -1 ? 1 : currentVisiblePos + 1;
        this.mediaCounter.textContent = `${position} / ${visible.length}`;
    }
}

// Initialiser le lecteur vidéo au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    const player = new VideoPlayerV2();
    if (!player.isReady) return;
    
    // Charger le premier média automatiquement
    const visible = player.getVisibleIndices();
    if (visible.length > 0) {
        player.playMedia(visible[0]);
    } else if (player.playlistItems.length > 0) {
        player.playMedia(0);
    }
});
