{{-- Hero Section Component --}}
<section class="hero-v2">
    {{-- Video Carousel Background - Confiné au Hero --}}
    <div class="video-carousel-background">
        <div class="video-carousel-container">
            @foreach($sliders as $index => $slider)
            <div class="video-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                @if($slider->video_type === 'youtube' || $slider->video_type === 'vimeo')
                    {{-- Vidéo YouTube/Vimeo avec iframe --}}
                    <iframe 
                        class="video-background" 
                        src="{{ $slider->video_embed_url }}?autoplay={{ $index === 0 ? '1' : '0' }}&mute=1&loop=1&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1" 
                        frameborder="0" 
                        allow="autoplay; encrypted-media" 
                        allowfullscreen
                    ></iframe>
                @else
                    {{-- Vidéo uploadée avec balise video HTML5 --}}
                    <video class="video-background" {{ $index === 0 ? 'autoplay' : '' }} muted loop playsinline>
                        <source src="{{ $slider->video_embed_url }}" type="video/mp4">
                    </video>
                @endif
                
                {{-- Overlay avec titre et bouton sur la vidéo principale --}}
                <div class="hero-video-overlay">
                    <div class="hero-video-info">
                        <h2 class="hero-video-main-title">{{ $slider->name }}</h2>
                        @if($slider->button_text && $slider->button_url)
                            <a href="{{ $slider->button_url }}" class="hero-video-main-button">
                                {{ $slider->button_text }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Cartes vidéo miniatures sur la vidéo principale --}}
        <div class="hero-video-cards-overlay">
            <button class="carousel-nav-btn prev" aria-label="Précédent">
                <svg viewBox="0 0 24 24">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>
            <div class="hero-video-cards">
                @foreach($sliders as $index => $slider)
                <div class="hero-video-card {{ $index === 0 ? 'active' : '' }}" data-video="{{ $index }}">
                    @if($slider->video_type === 'youtube' || $slider->video_type === 'vimeo')
                        <img class="hero-video-card-thumbnail" src="{{ $slider->thumbnail_url }}" alt="{{ $slider->name }}">
                    @else
                        <video class="hero-video-card-thumbnail" muted>
                            <source src="{{ $slider->video_embed_url }}" type="video/mp4">
                        </video>
                    @endif
                    <div class="hero-video-card-overlay">
                        <div class="hero-video-card-play">
                            <svg viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="hero-video-card-title">{{ $slider->name }}</div>
                </div>
                @endforeach
            </div>
            <button class="carousel-nav-btn next" aria-label="Suivant">
                <svg viewBox="0 0 24 24">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </button>
        </div>
        
        <div class="carousel-controls">
            @foreach($sliders as $index => $slider)
            <button class="carousel-dot" data-slide="{{ $index }}" aria-label="Video {{ $index + 1 }}"></button>
            @endforeach
        </div>
    </div>

    {{-- Section mobile uniquement : Email + Logo + Map --}}
    <div class="hero-mobile-header">
        <div class="hero-mobile-email">
            <a href="mailto:INFOGOEXPLORIA@GMAIL.COM">INFOGOEXPLORIA@GMAIL.COM</a>
        </div>
        <div class="hero-mobile-logo-container">
            <a href="#" class="hero-mobile-logo">
                <img src="{{ asset('logo.png') }}" alt="GO EXPLORIA" class="hero-mobile-logo-img">
                <!-- <div class="logo-text">
                    <div class="logo-exploria">GO EXPLORIA</div>
                    <div class="logo-location">QUÉBEC, CANADA</div>
                </div> -->
            </a>
            <img src="{{ asset('header_info/map2.png') }}" alt="Map" class="hero-mobile-map">
        </div>
    </div>
    
    <div class="hero-content">
        <!-- <div class="hero-text">
            <h1 class="hero-title">
                <span class="hero-main">GO EXPLORIA</span>
            </h1>
        </div> -->
        
        {{-- Barre horizontale complète avec destinations + recherche --}}
        <div class="search-bar-v2">
            <div class="search-bar-v2-container">
                {{-- Logo REDI + DESTINATIONS (un seul élément à gauche) --}}
                <div class="search-bar-v2-destinations" style="position: relative;">
                    <img src="{{ asset('REDI.png') }}" alt="Destinations" class="search-bar-v2-globe-icon">
                    <span class="search-bar-v2-destinations-title" id="destinationsMainTrigger">DESTINATIONS</span>
                    <div class="search-bar-v2-destinations-links" id="destinationsBreadcrumb">
                        {{-- Le fil d'Ariane sera généré dynamiquement par JavaScript --}}
                        <span class="search-bar-v2-destinations-link">Survolez pour explorer</span>
                    </div>
                    
                    {{-- Mega Menu Destinations Principal --}}
                    @include('home-v2.components.DestinationsMegaMenu')
                </div>

                {{-- Barre de recherche --}}
                <div class="search-bar-v2-search">
                    <div class="search-bar-v2-input-wrapper">
                        <svg class="search-bar-v2-search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                        <input 
                            type="text" 
                            class="search-bar-v2-input" 
                            id="searchBarInput"
                            placeholder="Rechercher une destination, activité, hébergement..."
                            aria-label="Rechercher une destination"
                            autocomplete="off"
                        >
                        <button class="search-bar-v2-clear-btn" id="searchBarClearBtn" aria-label="Effacer">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>

                    {{-- Dropdown des résultats --}}
                    <div class="search-bar-v2-results" id="searchBarResults">
                        <div class="search-bar-v2-results-header">
                            <h4 class="search-bar-v2-results-title">Résultats de la recherche</h4>
                        </div>
                        <ul class="search-bar-v2-results-list" id="searchBarResultsList">
                            {{-- Les résultats seront injectés ici par JavaScript --}}
                        </ul>
                    </div>
                </div>

                {{-- NOUVEAU : 6 Boutons Icônes FontAwesome Rapides --}}
                <div class="search-bar-v2-quick-links">
                    <div class="quick-link-item info-trigger" id="infoTrigger">
                        <div class="icon-circle icon-standard">
                            <i class="fas fa-info"></i>
                        </div>
                    </div>
                    
                    {{-- Categories Mega Menu Trigger --}}
                    <div class="quick-link-item" id="catMegaTrigger" style="cursor:pointer;" title="Catégories & Activités">
                        <div class="icon-circle icon-standard">
                            <i class="fas fa-tag"></i>
                        </div>
                    </div>
                    
                    <a href="{{ url('/offres') }}" class="quick-link-item">
                        <div class="icon-circle icon-standard">
                            <i class="fas fa-clock"></i>
                        </div>
                    </a>
                    
                    <!-- <a href="{{ url('/nouvelles') }}" class="quick-link-item">
                        <div class="icon-circle icon-standard">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    </a>
                    
                    <a href="{{ url('/must-see') }}" class="quick-link-item">
                        <div class="icon-circle icon-standard">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </a>
                    
                    <a href="{{ url('/aventures') }}" class="quick-link-item">
                        <div class="icon-circle icon-standard">
                            <i class="fas fa-binoculars"></i>
                        </div>
                    </a> -->
                </div>

                {{-- Logo Plan-n-go --}}
                <div class="search-bar-v2-brand">
                    <img src="{{ asset('plan-n-go.png') }}" alt="PLAN-N-GO" class="search-bar-v2-logo">
                </div>
            </div>
        </div>
        
    </div>
</section>

{{-- INFO MEGA MENU - Hors de tout overflow parent pour un positionnement correct --}}
@include('home-v2.components.InfoMegaMenu')

{{-- CATEGORIES MEGA MENU - Panel fixed, positionné par JS sous le trigger --}}
@include('home-v2.components.CategoriesMegaMenu')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const infoBtn = document.getElementById('infoTrigger');
    const megaMenu = document.getElementById('infoMegaMenuV2');
    if (!infoBtn || !megaMenu) return;

    // Fonction pour positionner le menu dynamiquement sous le bouton sur desktop
    function positionMegaMenu() {
        if (window.innerWidth > 1025 && megaMenu.classList.contains('active')) {
            const rect = infoBtn.getBoundingClientRect();
            megaMenu.style.top = (rect.bottom + 15) + 'px';
        } else {
            megaMenu.style.top = ''; // Laisse CSS gérer sur mobile
        }
    }

    // Toggle au clic
    infoBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const isOpen = megaMenu.classList.contains('active');
        megaMenu.classList.toggle('active', !isOpen);
        infoBtn.classList.toggle('active', !isOpen);
        if (!isOpen) positionMegaMenu();
    });

    // Gestion du survol dynamique sur desktop (avec pont temporel pour l'écart de 15px)
    let hoverTimeout;
    const handleMouseLeave = () => {
        if (window.innerWidth > 1025) {
            hoverTimeout = setTimeout(() => {
                if (!megaMenu.matches(':hover') && !infoBtn.matches(':hover')) {
                    megaMenu.classList.remove('active');
                    infoBtn.classList.remove('active');
                }
            }, 250); // Espace de tolérance pour traverser le gap de 15px
        }
    };

    const handleMouseEnter = () => {
        if (window.innerWidth > 1025) {
            clearTimeout(hoverTimeout);
            megaMenu.classList.add('active');
            infoBtn.classList.add('active');
            positionMegaMenu();
        }
    };

    infoBtn.addEventListener('mouseenter', handleMouseEnter);
    infoBtn.addEventListener('mouseleave', handleMouseLeave);
    megaMenu.addEventListener('mouseenter', handleMouseEnter);
    megaMenu.addEventListener('mouseleave', handleMouseLeave);

    // Fermer si clic ailleurs (fonctionne car clics en dehors, incluant la marge vide au dessus sur mobile)
    document.addEventListener('click', function(e) {
        if (!infoBtn.contains(e.target) && !megaMenu.contains(e.target)) {
            megaMenu.classList.remove('active');
            infoBtn.classList.remove('active');
        }
    });

    window.addEventListener('resize', positionMegaMenu);
    window.addEventListener('scroll', positionMegaMenu);
});
</script>
