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
        
        this.init();
    }
    
    init() {
        if (!this.videoPlayer || !this.playlistItems.length) return;
        
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
    
    playMedia(index) {
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
        this.videoTitle.textContent = title;
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
        const nextIndex = (this.currentIndex + 1) % this.playlistItems.length;
        this.playMedia(nextIndex);
    }
    
    playPrevious() {
        const prevIndex = (this.currentIndex - 1 + this.playlistItems.length) % this.playlistItems.length;
        this.playMedia(prevIndex);
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
        if (this.videoPlayer.paused) {
            this.videoPlayer.play();
            this.updatePlayPauseIcon(false);
        } else {
            this.videoPlayer.pause();
            this.updatePlayPauseIcon(true);
        }
    }
    
    updatePlayPauseIcon(isPaused) {
        const playIcon = this.playPauseBtn.querySelector('.play-icon');
        const pauseIcon = this.playPauseBtn.querySelector('.pause-icon');
        
        if (isPaused) {
            playIcon.style.display = 'block';
            pauseIcon.style.display = 'none';
        } else {
            playIcon.style.display = 'none';
            pauseIcon.style.display = 'block';
        }
    }
    
    toggleMute() {
        this.isMuted = !this.isMuted;
        this.videoPlayer.muted = this.isMuted;
        
        const volumeOnIcon = this.volumeBtn.querySelector('.volume-on-icon');
        const volumeOffIcon = this.volumeBtn.querySelector('.volume-off-icon');
        
        if (this.isMuted) {
            volumeOnIcon.style.display = 'none';
            volumeOffIcon.style.display = 'block';
        } else {
            volumeOnIcon.style.display = 'block';
            volumeOffIcon.style.display = 'none';
        }
    }
    
    toggleFullscreen() {
        if (!document.fullscreenElement) {
            this.videoPlayer.parentElement.requestFullscreen();
        } else {
            document.exitFullscreen();
        }
    }
    
    seek(e) {
        const rect = this.progressBar.getBoundingClientRect();
        const percent = (e.clientX - rect.left) / rect.width;
        this.videoPlayer.currentTime = percent * this.videoPlayer.duration;
    }
    
    updateProgress() {
        const percent = (this.videoPlayer.currentTime / this.videoPlayer.duration) * 100;
        this.progressFilled.style.width = percent + '%';
        this.updateTime();
    }
    
    updateTime() {
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
        this.mediaCounter.textContent = `${this.currentIndex + 1} / ${this.playlistItems.length}`;
    }
}

// Initialiser le lecteur vidéo au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    const player = new VideoPlayerV2();
    
    // Charger le premier média automatiquement
    if (player.playlistItems.length > 0) {
        player.playMedia(0);
    }
});
