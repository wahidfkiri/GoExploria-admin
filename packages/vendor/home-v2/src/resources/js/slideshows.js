/**
 * Slideshows V2 - Carousel de galerie vidéo
 * Gère le carousel infini avec navigation et modal vidéo
 */

class SlideshowsV2 {
    constructor() {
        this.slides = [];
        this.currentSlide = 0;
        this.autoSlideInterval = null;
        this.isTransitioning = false;
        this.slideDuration = 10000;
        this.transitionDuration = 30000;
        
        this.track = document.getElementById('slideshowsV2Track');
        this.dotsContainer = document.getElementById('slideshowsV2Dots');
        this.prevBtn = document.getElementById('slideshowsV2PrevBtn');
        this.nextBtn = document.getElementById('slideshowsV2NextBtn');
        // La modal est gérée par ViewingCarouselV2, pas besoin de références locales
        this.container = document.querySelector('.slideshows-v2-container');
        
        this.loadSlides();
        this.init();
    }
    
    loadSlides() {
        this.slides = [
            {
                largeImage: {
                    title: "Aventure en Montagne",
                    description: "Découvrez les paysages époustouflants des Alpes",
                    image: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                    videoId: "M-2eAiU09qg",
                    badge: "new"
                },
                smallImages: [
                    {
                        title: "Forêt Enchantée",
                        description: "Une balade magique à travers la forêt",
                        image: "https://images.unsplash.com/photo-1441974231531-c6227db76b6e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "hot"
                    },
                    {
                        title: "Coucher de Soleil",
                        description: "Les plus beaux couchers de soleil de l'année",
                        image: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "trending"
                    },
                    {
                        title: "Océan Infini",
                        description: "Plongez dans les profondeurs de l'océan",
                        image: "https://images.unsplash.com/photo-1439066615861-d1af74d74000?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "popular"
                    },
                    {
                        title: "Ville Lumineuse",
                        description: "La vie nocturne des grandes métropoles",
                        image: "https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "new"
                    }
                ]
            },
            {
                largeImage: {
                    title: "Désert Mystique",
                    description: "Traversez les étendues infinies du Sahara",
                    image: "https://images.unsplash.com/photo-1505118380757-91f5f5632de0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                    videoId: "M-2eAiU09qg",
                    badge: "trending"
                },
                smallImages: [
                    {
                        title: "Aurore Boréale",
                        description: "Le spectacle magique des aurores boréales",
                        image: "https://images.unsplash.com/photo-1502134249126-9f3755a50d78?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "hot"
                    },
                    {
                        title: "Chutes d'Eau",
                        description: "La puissance et la beauté des cascades",
                        image: "https://images.unsplash.com/photo-1512273222628-4daea6e55abb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "popular"
                    },
                    {
                        title: "Architecture Moderne",
                        description: "Les bâtiments les plus innovants du monde",
                        image: "https://images.unsplash.com/photo-1487958449943-2429e8be8625?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "new"
                    },
                    {
                        title: "Vie Sauvage",
                        description: "Rencontrez les animaux dans leur habitat naturel",
                        image: "https://images.unsplash.com/photo-1519066629447-267fffa62d4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "trending"
                    }
                ]
            },
            {
                largeImage: {
                    title: "Aurores Polaires",
                    description: "Un spectacle céleste inoubliable en Laponie",
                    image: "https://images.unsplash.com/photo-1502134249126-9f3755a50d78?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                    videoId: "M-2eAiU09qg",
                    badge: "hot"
                },
                smallImages: [
                    {
                        title: "Plages Tropicales",
                        description: "Le sable blanc et l'eau turquoise des Caraïbes",
                        image: "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "popular"
                    },
                    {
                        title: "Randonnée Alpine",
                        description: "Les sentiers les plus spectaculaires des Alpes",
                        image: "https://images.unsplash.com/photo-1536152471326-642d5c8b905d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "new"
                    },
                    {
                        title: "Art Urbain",
                        description: "Les fresques murales qui colorent la ville",
                        image: "https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "trending"
                    },
                    {
                        title: "Volcans Actifs",
                        description: "La puissance impressionnante de la nature",
                        image: "https://images.unsplash.com/photo-1547448526-5e9d57fa28f7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "hot"
                    }
                ]
            },
            {
                largeImage: {
                    title: "Cuisine du Monde",
                    description: "Découvrez les spécialités culinaires internationales",
                    image: "https://images.unsplash.com/photo-1565958011703-44f9829ba187?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                    videoId: "M-2eAiU09qg",
                    badge: "popular"
                },
                smallImages: [
                    {
                        title: "Sports Extrêmes",
                        description: "Adrénaline et sensations fortes garanties",
                        image: "https://images.unsplash.com/photo-1530549387789-4c1017266635?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "new"
                    },
                    {
                        title: "Fleurs Exotiques",
                        description: "La beauté vibrante des fleurs tropicales",
                        image: "https://images.unsplash.com/photo-1463320898484-cdee8141c787?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "trending"
                    },
                    {
                        title: "Voyage Spatial",
                        description: "Explorez l'univers et au-delà",
                        image: "https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "hot"
                    },
                    {
                        title: "Art Contemporain",
                        description: "Les œuvres les plus innovantes du moment",
                        image: "https://images.unsplash.com/photo-1541961017774-22349e4a1262?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "popular"
                    }
                ]
            },
            {
                largeImage: {
                    title: "Voyage en Italie",
                    description: "Explorez les trésors de l'Italie",
                    image: "https://images.unsplash.com/photo-1534447677768-be436bb09401?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                    videoId: "M-2eAiU09qg",
                    badge: "new"
                },
                smallImages: [
                    {
                        title: "Culture Japonaise",
                        description: "Découvrez la richesse de la culture japonaise",
                        image: "https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "trending"
                    },
                    {
                        title: "Safari Africain",
                        description: "Rencontrez les animaux de la savane",
                        image: "https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "hot"
                    },
                    {
                        title: "Sports Nautiques",
                        description: "Les sports aquatiques les plus excitants",
                        image: "https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "popular"
                    },
                    {
                        title: "Festivals Musicaux",
                        description: "Les plus grands festivals de musique",
                        image: "https://images.unsplash.com/photo-1470225620780-dba8ba36b745?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                        videoId: "M-2eAiU09qg",
                        badge: "new"
                    }
                ]
            }
        ];
    }
    
    init() {
        if (!this.track || !this.dotsContainer) return;
        
        this.renderSlides();
        this.renderDots();
        this.attachEvents();
        this.updateSlider();
        
        setTimeout(() => {
            this.startAutoSlide();
        }, 2000);
    }
    
    renderSlides() {
        const slidesToShow = this.slides.concat(this.slides);
        
        slidesToShow.forEach((slide) => {
            const slideElement = document.createElement('div');
            slideElement.className = 'slideshows-v2-slide';
            
            slideElement.innerHTML = `
                <div class="slideshows-v2-column slideshows-v2-half slideshows-v2-main-tile slideshows-v2-item" data-video-id="${slide.largeImage.videoId}" data-title="${slide.largeImage.title}">
                    ${slide.largeImage.badge ? `<div class="slideshows-v2-badge slideshows-v2-badge-${slide.largeImage.badge}">${slide.largeImage.badge}</div>` : ''}
                    <img src="${slide.largeImage.image}" alt="${slide.largeImage.title}" loading="lazy">
                    <div class="slideshows-v2-overlay">
                        <div class="slideshows-v2-title">${slide.largeImage.title}</div>
                        <div class="slideshows-v2-description">${slide.largeImage.description}</div>
                    </div>
                    <div class="slideshows-v2-play-btn">
                        <i class="fas fa-play"></i>
                    </div>
                </div>
                <div class="slideshows-v2-column slideshows-v2-half slideshows-v2-grid">
                    ${slide.smallImages.map(img => `
                        <div class="slideshows-v2-tile slideshows-v2-item" data-video-id="${img.videoId}" data-title="${img.title}">
                            ${img.badge ? `<div class="slideshows-v2-badge slideshows-v2-badge-${img.badge}">${img.badge}</div>` : ''}
                            <img src="${img.image}" alt="${img.title}" loading="lazy">
                            <div class="slideshows-v2-overlay">
                                <div class="slideshows-v2-title">${img.title}</div>
                                <div class="slideshows-v2-description">${img.description}</div>
                            </div>
                            <div class="slideshows-v2-play-btn">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
            
            this.track.appendChild(slideElement);
        });
        
        this.track.style.transition = `transform ${this.transitionDuration}ms cubic-bezier(0.25, 0.46, 0.45, 0.94)`;
    }
    
    renderDots() {
        this.slides.forEach((_, index) => {
            const dot = document.createElement('div');
            dot.className = `slideshows-v2-dot ${index === 0 ? 'slideshows-v2-dot-active' : ''}`;
            dot.dataset.index = index;
            dot.addEventListener('click', () => this.goToSlide(index));
            this.dotsContainer.appendChild(dot);
        });
    }
    
    attachEvents() {
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', () => {
                this.prevSlide();
                this.resetAutoSlide();
            });
        }
        
        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', () => {
                this.nextSlide();
                this.resetAutoSlide();
            });
        }
        
        // Les événements de fermeture de modal sont gérés par ViewingCarouselV2
        
        document.querySelectorAll('.slideshows-v2-play-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const item = btn.closest('.slideshows-v2-item');
                const videoId = item.dataset.videoId;
                const title = item.dataset.title;
                this.openVideoModal(videoId, title);
            });
        });
        
        document.querySelectorAll('.slideshows-v2-item').forEach(item => {
            item.addEventListener('click', () => {
                const videoId = item.dataset.videoId;
                const title = item.dataset.title;
                this.openVideoModal(videoId, title);
            });
        });
        
        if (this.container) {
            this.container.addEventListener('mouseenter', () => {
                clearInterval(this.autoSlideInterval);
            });
            
            this.container.addEventListener('mouseleave', () => {
                this.startAutoSlide();
            });
        }
        
        // La touche Escape est gérée par ViewingCarouselV2
    }
    
    goToSlide(slideIndex) {
        if (this.isTransitioning) return;
        this.isTransitioning = true;
        
        this.currentSlide = slideIndex;
        this.updateSlider();
        this.resetAutoSlide();
        
        setTimeout(() => {
            this.isTransitioning = false;
        }, this.transitionDuration);
    }
    
    nextSlide() {
        if (this.isTransitioning) return;
        this.isTransitioning = true;
        
        this.currentSlide++;
        
        const realIndex = this.currentSlide % this.slides.length;
        
        document.querySelectorAll('.slideshows-v2-dot').forEach((dot, index) => {
            dot.classList.toggle('slideshows-v2-dot-active', index === realIndex);
        });
        
        if (this.currentSlide >= this.slides.length * 2 - 1) {
            this.track.style.transition = 'none';
            this.currentSlide = this.slides.length;
            this.updateSlider();
            
            void this.track.offsetWidth;
            
            this.track.style.transition = `transform ${this.transitionDuration}ms cubic-bezier(0.25, 0.46, 0.45, 0.94)`;
            
            setTimeout(() => {
                this.currentSlide++;
                this.updateSlider();
                
                setTimeout(() => {
                    this.isTransitioning = false;
                }, this.transitionDuration);
            }, 50);
        } else {
            this.updateSlider();
            
            setTimeout(() => {
                this.isTransitioning = false;
            }, this.transitionDuration);
        }
    }
    
    prevSlide() {
        if (this.isTransitioning) return;
        this.isTransitioning = true;
        
        this.currentSlide--;
        
        const realIndex = (this.currentSlide + this.slides.length) % this.slides.length;
        
        document.querySelectorAll('.slideshows-v2-dot').forEach((dot, index) => {
            dot.classList.toggle('slideshows-v2-dot-active', index === realIndex);
        });
        
        if (this.currentSlide < 0) {
            this.track.style.transition = 'none';
            this.currentSlide = this.slides.length * 2 - 2;
            this.updateSlider();
            
            void this.track.offsetWidth;
            
            this.track.style.transition = `transform ${this.transitionDuration}ms cubic-bezier(0.25, 0.46, 0.45, 0.94)`;
            
            setTimeout(() => {
                this.currentSlide--;
                this.updateSlider();
                
                setTimeout(() => {
                    this.isTransitioning = false;
                }, this.transitionDuration);
            }, 50);
        } else {
            this.updateSlider();
            
            setTimeout(() => {
                this.isTransitioning = false;
            }, this.transitionDuration);
        }
        
        this.resetAutoSlide();
    }
    
    updateSlider() {
        const translateX = -this.currentSlide * 100;
        this.track.style.transform = `translateX(${translateX}%)`;
    }
    
    openVideoModal(videoId, title) {
        console.log('[Slideshows] Tentative d\'ouverture de la vidéo:', videoId, title);
        console.log('[Slideshows] VideoModalInstance disponible:', !!window.VideoModalInstance);
        
        // Utiliser l'instance globale de VideoModal
        if (window.VideoModalInstance) {
            // Créer un objet vidéo compatible avec VideoModal
            const videoData = {
                id: videoId,
                title: title,
                category: 'SLIDESHOW',
                date: new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }).toUpperCase(),
                description: 'Vidéo du carousel de galerie',
                thumbnail: `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg`
            };
            
            // Ouvrir la modal avec la vidéo
            window.VideoModalInstance.open(videoData);
            
            // Arrêter le défilement automatique du slideshow
            clearInterval(this.autoSlideInterval);
            
            console.log('[Slideshows] Modal ouverte avec succès');
        } else {
            console.error('[Slideshows] VideoModal instance NON disponible - Vérifiez que video-modal.js est chargé avant slideshows.js');
        }
    }
    
    startAutoSlide() {
        this.autoSlideInterval = setInterval(() => this.nextSlide(), this.slideDuration);
    }
    
    resetAutoSlide() {
        clearInterval(this.autoSlideInterval);
        this.startAutoSlide();
    }
}

// Initialiser le carousel quand le DOM est prêt
document.addEventListener('DOMContentLoaded', () => {
    new SlideshowsV2();
});
