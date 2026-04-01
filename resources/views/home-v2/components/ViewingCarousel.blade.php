{{-- Viewing Carousel Component - Modal uniquement (bloc visuel masqué) --}}
<section class="viewing-carousel-v2-section" style="display: none;">
    {{-- Titre du bloc --}}
    <div class="viewing-carousel-v2-title-bar">
        <h2 class="viewing-carousel-v2-main-title">VISIONNEZ TOUTES LES VIDÉOS ICI</h2>
        <img src="{{ asset('UPLOAD-2026.png') }}" alt="Upload" class="viewing-carousel-v2-title-logo">
    </div>

    {{-- Header de navigation --}}
    <div class="viewing-carousel-v2-nav-header">
        {{-- Logo --}}
        <div class="viewing-carousel-v2-logo">
            <img src="{{ asset('GO-EXPLORIA-MY-TUBE.png') }}" alt="GO EXPLORIA MYTUBE" class="viewing-carousel-v2-logo-img">
        </div>

        {{-- Navigation 2 lignes --}}
        <div class="viewing-carousel-v2-nav-wrapper">
            {{-- LIGNE 1 : Date, liens et réseaux sociaux --}}
            <div class="viewing-carousel-v2-nav-row-1">
                <div class="viewing-carousel-v2-nav-row-1-left">
                    <span class="viewing-carousel-v2-date-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        FRIDAY 27 MARCH 2026
                    </span>
                    <a href="#" class="viewing-carousel-v2-nav-link">BLOG</a>
                    <a href="#" class="viewing-carousel-v2-nav-link">SHOP</a>
                    <a href="#" class="viewing-carousel-v2-nav-link">CONTACT</a>
                    <a href="#" class="viewing-carousel-v2-nav-link">voir toutes les vidéos</a>
                </div>

                <div class="viewing-carousel-v2-nav-row-1-right">
                      <div class="viewing-carousel-v2-social-icons">
                        <a href="#" class="viewing-carousel-v2-social-icon" aria-label="Facebook">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="viewing-carousel-v2-social-icon" aria-label="Instagram">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" fill="none" stroke="white" stroke-width="2"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke="white" stroke-width="2"></line>
                            </svg>
                        </a>
                        <a href="#" class="viewing-carousel-v2-social-icon" aria-label="YouTube">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814z"/>
                                <polygon points="9.545 15.568 15.818 12 9.545 8.432 9.545 15.568" fill="white"/>
                            </svg>
                        </a>
                        <a href="#" class="viewing-carousel-v2-social-icon" aria-label="Pinterest">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M8 12c0-2.5 2-4.5 4.5-4.5S17 9.5 17 12c0 1.5-.5 2.5-1.5 2.5S14 13.5 14 12" fill="none" stroke="white" stroke-width="2"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- LIGNE 2 : Menu principal et boutons --}}
            <div class="viewing-carousel-v2-nav-row-2">
                <nav class="viewing-carousel-v2-main-menu">
                    <a href="#" class="viewing-carousel-v2-menu-item">HOME</a>
                    <a href="#" class="viewing-carousel-v2-menu-item">
                        NEWS
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <a href="#" class="viewing-carousel-v2-menu-item">
                        CATEGORIES
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <a href="#" class="viewing-carousel-v2-menu-item">
                        FEATURES
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <a href="#" class="viewing-carousel-v2-menu-item">
                        VIDEO
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <a href="#" class="viewing-carousel-v2-menu-item">
                        SHOP
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                </nav>

                <div class="viewing-carousel-v2-action-buttons">
                    <button class="viewing-carousel-v2-mode-btn" aria-label="Mode sombre">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                    </button>
                    <button class="viewing-carousel-v2-search-btn" aria-label="Rechercher">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                    </button>
                    <button class="viewing-carousel-v2-cart-btn" aria-label="Panier">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <span class="viewing-carousel-v2-cart-badge">0</span>
                    </button>
                    <button class="viewing-carousel-v2-live-btn">
                        <img src="{{ asset('UPLOAD-2026.png') }}" alt="Upload" class="viewing-carousel-v2-live-logo">
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Grille de vidéos avec carousel infini --}}
    <div class="viewing-carousel-v2-grid">
        <div class="viewing-carousel-v2-track">
        {{-- Vidéo 1 --}}
        <div class="viewing-carousel-v2-card">
            <div class="viewing-carousel-v2-video">
                <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Video thumbnail" class="viewing-carousel-v2-thumbnail">
                <div class="viewing-carousel-v2-overlay">
                    <button class="viewing-carousel-v2-play-btn">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="12" fill="white" opacity="0.9"/>
                            <path d="M10 8l6 4-6 4V8z" fill="#1a2942"/>
                        </svg>
                    </button>
                    <div class="viewing-carousel-v2-content">
                        <span class="viewing-carousel-v2-badge">GENERAL</span>
                        <h3 class="viewing-carousel-v2-video-title">This is the power of gathering: it inspire...</h3>
                        <p class="viewing-carousel-v2-date">AUGUST 28, 2022</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Vidéo 2 --}}
        <div class="viewing-carousel-v2-card">
            <div class="viewing-carousel-v2-video">
                <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Video thumbnail" class="viewing-carousel-v2-thumbnail">
                <div class="viewing-carousel-v2-overlay">
                    <button class="viewing-carousel-v2-play-btn">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="12" fill="white" opacity="0.9"/>
                            <path d="M10 8l6 4-6 4V8z" fill="#1a2942"/>
                        </svg>
                    </button>
                    <div class="viewing-carousel-v2-content">
                        <span class="viewing-carousel-v2-badge">NEWS</span>
                        <h3 class="viewing-carousel-v2-video-title">There are big problems that...</h3>
                        <p class="viewing-carousel-v2-date">APRIL 2, 2022</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Vidéo 3 --}}
        <div class="viewing-carousel-v2-card">
            <div class="viewing-carousel-v2-video">
                <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Video thumbnail" class="viewing-carousel-v2-thumbnail">
                <div class="viewing-carousel-v2-overlay">
                    <button class="viewing-carousel-v2-play-btn">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="12" fill="white" opacity="0.9"/>
                            <path d="M10 8l6 4-6 4V8z" fill="#1a2942"/>
                        </svg>
                    </button>
                    <div class="viewing-carousel-v2-content">
                        <span class="viewing-carousel-v2-badge">SPECIAL</span>
                        <h3 class="viewing-carousel-v2-video-title">We are part of this universe; we are in...</h3>
                        <p class="viewing-carousel-v2-date">MAY 11, 2022</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Vidéo 4 --}}
        <div class="viewing-carousel-v2-card">
            <div class="viewing-carousel-v2-video">
                <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Video thumbnail" class="viewing-carousel-v2-thumbnail">
                <div class="viewing-carousel-v2-overlay">
                    <button class="viewing-carousel-v2-play-btn">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="12" fill="white" opacity="0.9"/>
                            <path d="M10 8l6 4-6 4V8z" fill="#1a2942"/>
                        </svg>
                    </button>
                    <div class="viewing-carousel-v2-content">
                        <span class="viewing-carousel-v2-badge">NEWS</span>
                        <h3 class="viewing-carousel-v2-video-title">What we have once enjoyed we can nev...</h3>
                        <p class="viewing-carousel-v2-date">JANUARY 1, 2022</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Duplication des 4 vidéos pour carousel infini --}}
        {{-- Vidéo 1 (copie) --}}
        <div class="viewing-carousel-v2-card">
            <div class="viewing-carousel-v2-video">
                <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Video thumbnail" class="viewing-carousel-v2-thumbnail">
                <div class="viewing-carousel-v2-overlay">
                    <button class="viewing-carousel-v2-play-btn">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="12" fill="white" opacity="0.9"/>
                            <path d="M10 8l6 4-6 4V8z" fill="#1a2942"/>
                        </svg>
                    </button>
                    <div class="viewing-carousel-v2-content">
                        <span class="viewing-carousel-v2-badge">GENERAL</span>
                        <h3 class="viewing-carousel-v2-video-title">This is the power of gathering: it inspire...</h3>
                        <p class="viewing-carousel-v2-date">AUGUST 28, 2022</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Vidéo 2 (copie) --}}
        <div class="viewing-carousel-v2-card">
            <div class="viewing-carousel-v2-video">
                <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Video thumbnail" class="viewing-carousel-v2-thumbnail">
                <div class="viewing-carousel-v2-overlay">
                    <button class="viewing-carousel-v2-play-btn">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="12" fill="white" opacity="0.9"/>
                            <path d="M10 8l6 4-6 4V8z" fill="#1a2942"/>
                        </svg>
                    </button>
                    <div class="viewing-carousel-v2-content">
                        <span class="viewing-carousel-v2-badge">NEWS</span>
                        <h3 class="viewing-carousel-v2-video-title">There are big problems that...</h3>
                        <p class="viewing-carousel-v2-date">APRIL 2, 2022</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Vidéo 3 (copie) --}}
        <div class="viewing-carousel-v2-card">
            <div class="viewing-carousel-v2-video">
                <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Video thumbnail" class="viewing-carousel-v2-thumbnail">
                <div class="viewing-carousel-v2-overlay">
                    <button class="viewing-carousel-v2-play-btn">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="12" fill="white" opacity="0.9"/>
                            <path d="M10 8l6 4-6 4V8z" fill="#1a2942"/>
                        </svg>
                    </button>
                    <div class="viewing-carousel-v2-content">
                        <span class="viewing-carousel-v2-badge">SPECIAL</span>
                        <h3 class="viewing-carousel-v2-video-title">We are part of this universe; we are in...</h3>
                        <p class="viewing-carousel-v2-date">MAY 11, 2022</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Vidéo 4 (copie) --}}
        <div class="viewing-carousel-v2-card">
            <div class="viewing-carousel-v2-video">
                <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Video thumbnail" class="viewing-carousel-v2-thumbnail">
                <div class="viewing-carousel-v2-overlay">
                    <button class="viewing-carousel-v2-play-btn">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="12" fill="white" opacity="0.9"/>
                            <path d="M10 8l6 4-6 4V8z" fill="#1a2942"/>
                        </svg>
                    </button>
                    <div class="viewing-carousel-v2-content">
                        <span class="viewing-carousel-v2-badge">NEWS</span>
                        <h3 class="viewing-carousel-v2-video-title">What we have once enjoyed we can nev...</h3>
                        <p class="viewing-carousel-v2-date">JANUARY 1, 2022</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

</section>

{{-- Modal de lecture vidéo (en dehors de la section pour ne pas être masquée) --}}
<div class="viewing-carousel-v2-modal" id="videoModal" style="display: none;">
    <div class="viewing-carousel-v2-modal-overlay"></div>
    <div class="viewing-carousel-v2-modal-content">
        <button class="viewing-carousel-v2-modal-close" id="closeModal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <div class="viewing-carousel-v2-modal-body">
            {{-- Lecteur vidéo principal --}}
            <div class="viewing-carousel-v2-modal-main">
                <div class="viewing-carousel-v2-modal-video-wrapper">
                    <iframe 
                        id="modalVideoPlayer"
                        class="viewing-carousel-v2-modal-video"
                        src=""
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
                
                {{-- Informations de la vidéo --}}
                <div class="viewing-carousel-v2-modal-info">
                    <div class="viewing-carousel-v2-modal-badge-wrapper">
                        <span class="viewing-carousel-v2-modal-badge" id="modalBadge">GENERAL</span>
                    </div>
                    <h2 class="viewing-carousel-v2-modal-title" id="modalTitle">Titre de la vidéo</h2>
                    <p class="viewing-carousel-v2-modal-date" id="modalDate">DATE</p>
                    <p class="viewing-carousel-v2-modal-description" id="modalDescription">Description de la vidéo sélectionnée.</p>
                </div>
            </div>

            {{-- Playlist à droite --}}
            <div class="viewing-carousel-v2-modal-playlist">
                <div class="viewing-carousel-v2-modal-playlist-header">
                    <h3 class="viewing-carousel-v2-modal-playlist-title">Playlist</h3>
                </div>
                <ul class="viewing-carousel-v2-modal-playlist-items" id="modalPlaylistItems">
                    {{-- Les items seront générés dynamiquement --}}
                </ul>
            </div>
        </div>
    </div>
</div>
