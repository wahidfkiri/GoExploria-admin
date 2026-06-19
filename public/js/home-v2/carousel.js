/**
 * Video Carousel Controller
 * Gère le carrousel de 3 vidéos en arrière-plan
 * Optimisé pour tous les écrans
 */

class VideoCarousel {
    constructor() {
        this.currentSlide = 0;
        this.slides = document.querySelectorAll('.video-slide');
        this.dots = document.querySelectorAll('.carousel-dot');
        this.videoCards = document.querySelectorAll('.hero-video-card');
        this.prevBtn = document.querySelector('.carousel-nav-btn.prev');
        this.nextBtn = document.querySelector('.carousel-nav-btn.next');
        this.cardsContainer = document.querySelector('.hero-video-cards');
        this.autoPlayInterval = null;
        this.autoPlayDelay = 15000;
        this.isMobile = window.innerWidth <= 768;
        this.isReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        this.scrollPosition = 0;
        
        this.init();
    }
    
    init() {
        if (this.slides.length === 0) return;

        this.updateNavButtonsVisibility();
        
        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', () => this.goToSlide(index));
        });
        
        this.videoCards.forEach((card, index) => {
            card.addEventListener('click', () => this.goToSlide(index));
            
            const thumbnail = card.querySelector('.hero-video-card-thumbnail');
            if (thumbnail && thumbnail.tagName === 'VIDEO') {
                thumbnail.currentTime = 2;
            }
        });

        this.setupVideoCardFallbacks();
        
        if (this.prevBtn && this.nextBtn) {
            this.prevBtn.addEventListener('click', () => this.scrollCarousel('prev'));
            this.nextBtn.addEventListener('click', () => this.scrollCarousel('next'));
        }
        
        if (this.isMobile) {
            this.optimizeForMobile();
            this.addSwipeSupport();
        }
        
        this.playCurrentVideo();
        this.updateDots();
        
        if (!this.isReducedMotion) {
            this.startAutoPlay();
        }
        
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.pauseCurrentVideo();
                this.stopAutoPlay();
            } else {
                this.playCurrentVideo();
                if (!this.isReducedMotion) {
                    this.startAutoPlay();
                }
            }
        });
        
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                this.isMobile = window.innerWidth <= 768;
                this.handleResize();
            }, 250);
        });
    }
    
    optimizeForMobile() {
        this.slides.forEach((slide, index) => {
            if (index !== this.currentSlide) {
                const video = slide.querySelector('video');
                if (video) {
                    video.preload = 'metadata';
                }
            }
        });
    }

    updateNavButtonsVisibility() {
        const videosCount = Math.max(this.slides.length, this.videoCards.length);
        const shouldShowNav = videosCount > 5;

        [this.prevBtn, this.nextBtn].forEach(btn => {
            if (!btn) return;
            btn.style.display = shouldShowNav ? '' : 'none';
            btn.setAttribute('aria-hidden', shouldShowNav ? 'false' : 'true');
        });
    }

    setupVideoCardFallbacks() {
        this.videoCards.forEach((card, index) => {
            const thumbnail = card.querySelector('.hero-video-card-thumbnail');
            const imagePath = this.getCardImagePath(index);
            const videoUrl = this.getSlideVideoUrl(index);

            if (!thumbnail) {
                this.applyThumbnailVideoFallback(card, index, imagePath || videoUrl);
                return;
            }

            if (thumbnail.tagName === 'IMG') {
                const src = this.toAbsoluteUrl((thumbnail.getAttribute('src') || '').trim());
                if (!src) {
                    this.applyThumbnailVideoFallback(card, index, imagePath || videoUrl);
                    return;
                }

                thumbnail.src = src;
                thumbnail.setAttribute('title', src);
                thumbnail.dataset.fullPath = src;

                thumbnail.addEventListener('error', () => {
                    this.applyThumbnailVideoFallback(card, index, src);
                }, { once: true });

                // If the image is already broken before listeners are attached,
                // fallback immediately to full path text.
                if (thumbnail.complete && thumbnail.naturalWidth === 0) {
                    this.applyThumbnailVideoFallback(card, index, src);
                }
                return;
            }

            if (thumbnail.tagName === 'VIDEO') {
                const source = thumbnail.querySelector('source');
                const src = ((source && source.getAttribute('src')) || thumbnail.getAttribute('src') || '').trim();

                if (!src) {
                    this.applyThumbnailVideoFallback(card, index, imagePath || videoUrl);
                }
            }
        });
    }

    applyThumbnailVideoFallback(card, index, fallbackText) {
        if (card.dataset.thumbnailVideoFallbackApplied === '1') return;

        const media = this.createCardVideoPreview(index);
        if (media) {
            const existing = card.querySelector('.hero-video-card-thumbnail');
            if (existing) {
                existing.replaceWith(media);
            } else {
                card.prepend(media);
            }
            card.dataset.thumbnailVideoFallbackApplied = '1';
            return;
        }

        this.applyVideoUrlFallback(card, fallbackText);
    }

    createCardVideoPreview(index) {
        const slide = this.slides[index];
        if (!slide) return null;

        const iframe = slide.querySelector('iframe.video-background, iframe');
        if (iframe) {
            const src = this.withQueryParam(
                this.withQueryParam(
                    this.withQueryParam(
                        this.withQueryParam((iframe.getAttribute('src') || '').trim(), 'autoplay', '0'),
                        'mute',
                        '1'
                    ),
                    'controls',
                    '0'
                ),
                'playsinline',
                '1'
            );

            if (!src) return null;

            const preview = document.createElement('iframe');
            preview.className = 'hero-video-card-thumbnail';
            preview.src = src;
            preview.setAttribute('frameborder', '0');
            preview.setAttribute('allow', 'autoplay; encrypted-media');
            preview.setAttribute('allowfullscreen', '');
            preview.style.pointerEvents = 'none';
            return preview;
        }

        const slideVideo = slide.querySelector('video');
        if (slideVideo) {
            const source = slide.querySelector('video source');
            const src = ((source && source.getAttribute('src')) || slideVideo.getAttribute('src') || '').trim();
            if (!src) return null;

            const preview = document.createElement('video');
            preview.className = 'hero-video-card-thumbnail';
            preview.muted = true;
            preview.loop = true;
            preview.autoplay = true;
            preview.playsInline = true;

            const previewSource = document.createElement('source');
            previewSource.src = src;
            previewSource.type = 'video/mp4';
            preview.appendChild(previewSource);

            return preview;
        }

        return null;
    }

    withQueryParam(url, key, value) {
        if (!url) return '';

        try {
            const parsed = new URL(url, window.location.origin);
            parsed.searchParams.set(key, value);
            return parsed.href;
        } catch (e) {
            return url;
        }
    }

    getCardImagePath(index) {
        const card = this.videoCards[index];
        if (!card) return '';

        const img = card.querySelector('img.hero-video-card-thumbnail');
        if (!img) return '';

        const src = (img.getAttribute('src') || '').trim();
        return this.toAbsoluteUrl(src);
    }

    toAbsoluteUrl(url) {
        if (!url) return '';

        try {
            return new URL(url, window.location.origin).href;
        } catch (e) {
            return url;
        }
    }

    getSlideVideoUrl(index) {
        const slide = this.slides[index];
        if (!slide) return '';

        const iframe = slide.querySelector('iframe');
        if (iframe) {
            return (iframe.getAttribute('src') || '').trim();
        }

        const source = slide.querySelector('video source');
        if (source) {
            return (source.getAttribute('src') || '').trim();
        }

        const video = slide.querySelector('video');
        if (video) {
            return (video.getAttribute('src') || '').trim();
        }

        return '';
    }

    applyVideoUrlFallback(card, videoUrl) {
        if (!videoUrl || card.dataset.videoUrlFallbackApplied === '1') return;

        card.dataset.videoUrlFallbackApplied = '1';

        const thumbnail = card.querySelector('.hero-video-card-thumbnail');
        if (thumbnail) {
            thumbnail.style.display = 'none';
        }

        const title = card.querySelector('.hero-video-card-title');
        if (title) {
            title.textContent = videoUrl;
        } else {
            card.textContent = videoUrl;
        }
    }
    
    handleResize() {
        this.slides.forEach(slide => {
            const video = slide.querySelector('video');
            if (video) {
                video.style.objectFit = 'contain';
                video.style.objectPosition = 'center center';
            }
        });
    }
    
    addSwipeSupport() {
        let touchStartX = 0;
        let touchEndX = 0;
        const carousel = document.querySelector('.video-carousel-background');
        
        if (!carousel) return;
        
        carousel.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        
        carousel.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe(touchStartX, touchEndX);
        }, { passive: true });
    }
    
    handleSwipe(startX, endX) {
        const swipeThreshold = 50;
        const diff = startX - endX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                this.nextSlide();
            } else {
                this.previousSlide();
            }
        }
    }
    
    previousSlide() {
        const prevIndex = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        this.goToSlide(prevIndex);
    }
    
    goToSlide(index) {
        if (index === this.currentSlide) return;
        
        this.stopAutoPlay();
        this.slides[this.currentSlide].classList.remove('active');
        this.pauseCurrentVideo();
        
        this.currentSlide = index;
        this.slides[this.currentSlide].classList.add('active');
        this.playCurrentVideo();
        this.updateDots();
        
        if (!this.isReducedMotion) {
            this.startAutoPlay();
        }
    }
    
    nextSlide() {
        const nextIndex = (this.currentSlide + 1) % this.slides.length;
        this.goToSlide(nextIndex);
    }
    
    playCurrentVideo() {
        const slide = this.slides[this.currentSlide];
        const video = slide.querySelector('video');
        const iframe = slide.querySelector('iframe');
        
        if (video) {
            if (video.readyState < 2) {
                video.load();
            }
            
            video.play().catch(err => {
                console.log('Erreur de lecture vidéo:', err);
            });
        }
        
        if (iframe) {
            // Pour YouTube/Vimeo : On force le rechargement avec autoplay=1 pour s'assurer que ça démarre
            let src = iframe.src;
            if (src.includes('autoplay=0')) {
                src = src.replace('autoplay=0', 'autoplay=1');
            } else if (!src.includes('autoplay=')) {
                src += (src.includes('?') ? '&' : '?') + 'autoplay=1';
            }
            iframe.src = src;
        }
    }
    
    pauseCurrentVideo() {
        const slide = this.slides[this.currentSlide];
        const video = slide.querySelector('video');
        const iframe = slide.querySelector('iframe');
        
        if (video) {
            video.pause();
        }
        
        if (iframe) {
            // Arrêter la vidéo en mettant autoplay=0
            let src = iframe.src;
            if (src.includes('autoplay=1')) {
                src = src.replace('autoplay=1', 'autoplay=0');
            }
            iframe.src = src;
        }
    }
    
    updateDots() {
        this.dots.forEach((dot, index) => {
            if (index === this.currentSlide) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
        
        this.videoCards.forEach((card, index) => {
            if (index === this.currentSlide) {
                card.classList.add('active');
            } else {
                card.classList.remove('active');
            }
        });
    }
    
    startAutoPlay() {
        this.stopAutoPlay();
        this.autoPlayInterval = setInterval(() => {
            this.nextSlide();
        }, this.autoPlayDelay);
    }
    
    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
    
    scrollCarousel(direction) {
        if (!this.cardsContainer) return;
        
        const cardWidth = 250 + 20; // largeur carte + gap
        const scrollAmount = cardWidth * 2; // Défiler 2 cartes à la fois
        
        if (direction === 'next') {
            this.cardsContainer.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        } else {
            this.cardsContainer.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new VideoCarousel();
});
