{{-- Hero Section Component --}}
<section class="hero-v2">
    @php
        $tr = static function (string $text): string {
            $locale = app()->getLocale();
            if ($locale === 'fr') {
                return $text;
            }

            static $maps = [];
            if (! array_key_exists($locale, $maps)) {
                $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
                $maps[$locale] = is_file($path) ? (require $path) : [];
            }

            return $maps[$locale][$text] ?? $text;
        };

        $heroPlaceholderPhrases = [
            $tr('Explorez le monde…'),
            $tr('Rechercher une destination…'),
            $tr('Découvrez des activités…'),
            $tr('Trouvez un hébergement…'),
        ];
    @endphp
    @php($orderedSliders = collect($sliders ?? [])->sortBy('order')->values())
    @php($showCarouselNav = $orderedSliders->count() > 5)
    {{-- Video Carousel Background - Confiné au Hero --}}
    <div class="video-carousel-background">
        <div class="video-carousel-container">
            @foreach($orderedSliders as $index => $slider)
            <div class="video-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                @if($slider->type === 'image' && $slider->image_url)
                    <img class="video-background" src="{{ $slider->image_url }}" alt="{{ $slider->name }}">
                @elseif($slider->video_type === 'youtube' || $slider->video_type === 'vimeo' || $slider->video_type === 'iframe')
                    {{-- Vidéo YouTube/Vimeo avec iframe --}}
                    <iframe
                        class="video-background"
                        src="{{ $slider->video_embed_url }}{{ str_contains($slider->video_embed_url ?? '', '?') ? '&' : '?' }}autoplay=1&mute=1&muted=1&loop=1&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1"
                        frameborder="0"
                        allow="autoplay; encrypted-media"
                        allowfullscreen
                    ></iframe>
                @else
                    {{-- Vidéo uploadée avec balise video HTML5 --}}
                    <video class="video-background" autoplay muted loop playsinline preload="auto">
                        <source src="{{ $slider->video_embed_url }}" type="video/mp4">
                    </video>
                @endif

                {{-- Overlay avec titre et bouton sur la vidéo principale --}}
                <div class="hero-video-overlay">
                    <div class="hero-video-info">
                        <h2 class="hero-video-main-title">{{ $slider->name }}</h2>
                        @if($slider->button_text && $slider->button_url)
                            <a href="{{ $slider->button_url }}" class="hero-video-main-button" target="_blank" rel="noopener noreferrer">
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
            @if($showCarouselNav)
            <button class="carousel-nav-btn prev" aria-label="{{ $tr('Précédent') }}">
                <svg viewBox="0 0 24 24">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>
            @endif
            <div class="hero-video-cards">
                @foreach($orderedSliders as $index => $slider)
                <div class="hero-video-card {{ $index === 0 ? 'active' : '' }}" data-video="{{ $index }}">
                    @php($isImageSlide = $slider->type === 'image')
                    @php($isExternalVideo = $slider->video_type === 'youtube' || $slider->video_type === 'vimeo' || $slider->video_type === 'iframe')
                    @php($hasCardImage = !empty($slider->thumbnail_path) || !empty($slider->image_path))
                    @if($isImageSlide)
                        <img class="hero-video-card-thumbnail" src="{{ $slider->thumbnail_url ?: $slider->image_url }}" alt="{{ $slider->name }}">
                    @elseif($isExternalVideo && $hasCardImage)
                        <img class="hero-video-card-thumbnail" src="{{ $slider->thumbnail_url }}" alt="{{ $slider->name }}">
                    @elseif($isExternalVideo)
                        @php($iframeSeparator = str_contains($slider->video_embed_url ?? '', '?') ? '&' : '?')
                        <iframe
                            class="hero-video-card-thumbnail"
                            src="{{ $slider->video_embed_url }}{{ $iframeSeparator }}autoplay=0&mute=1&controls=0&loop=1&playsinline=1&rel=0&modestbranding=1"
                            frameborder="0"
                            allow="autoplay; encrypted-media"
                            allowfullscreen
                            style="pointer-events: none;"
                        ></iframe>
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
            @if($showCarouselNav)
            <button class="carousel-nav-btn next" aria-label="{{ $tr('Suivant') }}">
                <svg viewBox="0 0 24 24">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </button>
            @endif
        </div>

        <div class="carousel-controls">
            @foreach($orderedSliders as $index => $slider)
            <button class="carousel-dot" data-slide="{{ $index }}" aria-label="{{ $tr('Vidéo') }} {{ $index + 1 }}"></button>
            @endforeach
        </div>

        {{-- Bouton son vidéo (mute/unmute) — gauche du Hero --}}
        <button type="button" class="hero-sound-toggle" id="heroSoundToggle" aria-label="{{ $tr('Activer le son') }}" title="{{ $tr('Activer le son') }}">
            <svg class="hero-sound-icon-muted" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                <line x1="23" y1="9" x2="17" y2="15"></line>
                <line x1="17" y1="9" x2="23" y2="15"></line>
            </svg>
            <svg class="hero-sound-icon-on" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                <path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                <path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path>
            </svg>
        </button>
    </div>

    {{-- Section mobile uniquement : Email + Logo + Map --}}
    <div class="hero-mobile-header">
        <div class="hero-mobile-email">
            <a href="mailto:{{ __('home-v2.common.email') }}">{{ __('home-v2.common.email') }}</a>
        </div>
        <div class="hero-mobile-logo-container">
            <a href="#" class="hero-mobile-logo">
                <img src="{{ asset('logo.png') }}" alt="GO EXPLORIA" class="hero-mobile-logo-img">
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
        @if(!($hideSearchBarV2 ?? false))
        <div class="search-bar-v2">
            <div class="search-bar-v2-container">
                {{-- Globe Destinations --}}
                <div class="search-bar-v2-destinations" style="position: relative; flex-direction: column; gap: 2px; align-items: center;">
                    <img src="{{ asset('REDI.png') }}" alt="Destinations" class="search-bar-v2-globe-icon" id="destinationsMainTrigger" style="cursor:pointer;">
                    <span class="search-bar-v2-destinations-title" id="destinationsBreadcrumb">{{ $tr('Destinations') }}</span>

                    {{-- Mega Menu Destinations Principal --}}
                    @include('cms::web.fallback.activities.default.destinations-mega-menu')
                </div>


                {{-- 3 Pictos ronds bleus : i · iT · iB --}}
                <div class="search-bar-v2-quick-links">
                    {{-- Info i --}}
                    <div class="quick-link-item info-trigger" id="infoTrigger" title="{{ $tr('Informations') }}">
                        <div class="icon-circle icon-blue">
                            <span class="picto-label">i</span>
                        </div>
                    </div>

                    {{-- iT Tourisme --}}
                    <div class="quick-link-item" id="catMegaTriggerTourisme" style="cursor:pointer;" title="{{ $tr('Activités Tourisme') }}">
                        <div class="icon-circle icon-blue">
                            <span class="picto-label">iT</span>
                        </div>
                    </div>

                    {{-- iB Business --}}
                    <div class="quick-link-item" id="catMegaTriggerBusiness" style="cursor:pointer;" title="{{ $tr('Activités Business') }}">
                        <div class="icon-circle icon-blue">
                            <span class="picto-label">iB</span>
                        </div>
                    </div>
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
                            placeholder="{{ $tr('Rechercher une destination, activité, hébergement...') }}"
                            aria-label="{{ $tr('Rechercher une destination') }}"
                            autocomplete="off"
                        >
                        <button class="search-bar-v2-clear-btn" id="searchBarClearBtn" aria-label="{{ $tr('Effacer') }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>

                    {{-- Dropdown des résultats --}}
                    <div class="search-bar-v2-results" id="searchBarResults">
                        <div class="search-bar-v2-results-header">
                            <h4 class="search-bar-v2-results-title">{{ $tr('Résultats de la recherche') }}</h4>
                        </div>
                        <ul class="search-bar-v2-results-list" id="searchBarResultsList">
                            {{-- Les résultats seront injectés ici par JavaScript --}}
                        </ul>
                    </div>
                </div>


                {{-- Boutons rapides après la barre de recherche : EE · ED · MP · Voiture · Avion --}}
                <div class="search-bar-v2-quick-links search-bar-v2-quick-links--post">
                    {{-- EE — Espace Entreprise --}}
                    <div class="quick-link-item" id="quickLinkEE" style="cursor:pointer;" title="{{ $tr('Espace Entreprise') }}">
                        <div class="icon-circle icon-blue">
                            <span class="picto-label">EE</span>
                        </div>
                    </div>

                    {{-- ED — Espace Destination --}}
                    <div class="quick-link-item" id="quickLinkED" style="cursor:pointer;" title="{{ $tr('Espace Destination') }}">
                        <div class="icon-circle icon-blue">
                            <span class="picto-label">ED</span>
                        </div>
                    </div>

                    {{-- MP — Marketplace --}}
                    <div class="quick-link-item" id="quickLinkMP" style="cursor:pointer;" title="{{ $tr('Marketplace') }}">
                        <div class="icon-circle icon-blue">
                            <span class="picto-label">MP</span>
                        </div>
                    </div>

                    {{-- Voiture — Location Véhicule --}}
                    <div class="quick-link-item" id="quickLinkCar" style="cursor:pointer;" title="{{ $tr('Location Véhicule') }}">
                        <div class="icon-circle icon-blue">
                            <i class="fas fa-car picto-icon"></i>
                        </div>
                    </div>

                    {{-- Avion — Billets Avion --}}
                    <div class="quick-link-item" id="quickLinkPlane" style="cursor:pointer;" title="{{ $tr('Billets Avion') }}">
                        <div class="icon-circle icon-blue">
                            <i class="fas fa-plane picto-icon"></i>
                        </div>
                    </div>
                </div>

                {{-- Logo Plan-n-go — déclencheur du méga-menu Plan & GO --}}
                <div class="search-bar-v2-brand" id="planNGoTrigger" style="cursor:pointer;" title="{{ $tr('Plan & GO') }}">
                    <img src="{{ asset('plan-n-go.png') }}" alt="PLAN-N-GO" class="search-bar-v2-logo">
                </div>
            </div>
        </div>
        @endif

    </div>
</section>

{{-- INFO MEGA MENU - Hors de tout overflow parent pour un positionnement correct --}}
@include('cms::web.fallback.activities.default.info-mega-menu')

{{-- CATEGORIES MEGA MENU - Panel fixed, positionné par JS sous le trigger --}}
@include('cms::web.fallback.activities.default.categories-mega-menu')

{{-- QUICK LINKS MEGA MENUS — Panels pour MP, EE, ED, Voiture, Avion, Plan & GO --}}
@include('cms::web.fallback.activities.default.hero-quick-mega-menus')

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

/* ─────────────────────────────────────────────
   Animation dactylographique du placeholder
   Boucle : écriture → pause → effacement
   ───────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('searchBarInput');
    if (!input) return;

    const phrases = @json($heroPlaceholderPhrases ?? []);

    let phraseIdx = 0;
    let charIdx = 0;
    let isDeleting = false;
    const typeSpeed = 70;     // ms par caractère (écriture)
    const eraseSpeed = 40;    // ms par caractère (effacement)
    const holdDelay = 2000;   // pause à la fin de chaque phrase
    const startDelay = 500;   // avant de démarrer l'effacement / mot suivant

    function tick() {
        // Stop l'animation dès que l'utilisateur saisit quelque chose
        if (input.value && !input.dataset.animating) return;

        const phrase = phrases[phraseIdx];
        if (!isDeleting) {
            charIdx++;
            input.placeholder = phrase.substring(0, charIdx);
            if (charIdx === phrase.length) {
                isDeleting = true;
                return setTimeout(tick, holdDelay);
            }
            setTimeout(tick, typeSpeed);
        } else {
            charIdx--;
            input.placeholder = phrase.substring(0, charIdx);
            if (charIdx === 0) {
                isDeleting = false;
                phraseIdx = (phraseIdx + 1) % phrases.length;
                return setTimeout(tick, startDelay);
            }
            setTimeout(tick, eraseSpeed);
        }
    }

    // Démarrer au chargement
    input.dataset.animating = '1';
    tick();

    // Stopper l'animation dès que l'utilisateur tape
    input.addEventListener('input', function() {
        if (input.value.length > 0) {
            delete input.dataset.animating;
            input.placeholder = @json($tr('Rechercher…'));
        }
    });
});

/* ─────────────────────────────────────────────
   Bouton mute/unmute vidéo Hero
   Gère <video> HTML5 + iframes YouTube/Vimeo
   ───────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('heroSoundToggle');
    if (!btn) return;

    const labelSoundOn = @json($tr('Activer le son'));
    const labelSoundOff = @json($tr('Couper le son'));

    const iconMuted = btn.querySelector('.hero-sound-icon-muted');
    const iconOn = btn.querySelector('.hero-sound-icon-on');
    let isMuted = true;

    function isYouTubeIframe(el) {
        if (!el || el.tagName !== 'IFRAME') return false;
        const src = (el.getAttribute('src') || '').toLowerCase();
        return src.includes('youtube.com/embed') || src.includes('youtube-nocookie.com/embed');
    }

    function requestYouTubeHd(el) {
        // The YouTube iframe API can throw internal errors on some embeds.
        // Keep playback stable by avoiding postMessage quality commands.
        return;
    }

    function boostActiveYouTubeQuality() {
        const el = getActiveVideoEl();
        if (!el) return;
        [250, 800, 1600, 3000].forEach(function(delay) {
            setTimeout(function() {
                requestYouTubeHd(el);
            }, delay);
        });
    }

    function getActiveVideoEl() {
        const active = document.querySelector('.video-slide.active');
        if (!active) return null;
        return active.querySelector('video.video-background, iframe.video-background');
    }

    function setMuteState(muted) {
        isMuted = muted;
        const el = getActiveVideoEl();
        if (!el) return;

        if (el.tagName === 'VIDEO') {
            el.muted = muted;
            if (!muted) {
                const p = el.play();
                if (p && typeof p.catch === 'function') p.catch(() => {});
            }
        } else if (el.tagName === 'IFRAME') {
            if (isYouTubeIframe(el)) {
                // Avoid YouTube iframe postMessage API; update URL params instead.
                try {
                    const currentSrc = new URL(el.getAttribute('src'), window.location.href);
                    currentSrc.searchParams.set('mute', muted ? '1' : '0');
                    currentSrc.searchParams.set('autoplay', '1');
                    el.setAttribute('src', currentSrc.toString());
                } catch (e) { /* ignore */ }
            } else {
                // Vimeo postMessage API
                try {
                    el.contentWindow.postMessage(JSON.stringify({
                        method: 'setVolume',
                        value: muted ? 0 : 1
                    }), '*');
                } catch (e) { /* ignore */ }
            }
        }

        // UI
        btn.classList.toggle('is-unmuted', !muted);
        btn.setAttribute('aria-label', muted ? labelSoundOn : labelSoundOff);
        btn.setAttribute('title', muted ? labelSoundOn : labelSoundOff);
        if (iconMuted) iconMuted.style.display = muted ? '' : 'none';
        if (iconOn) iconOn.style.display = muted ? 'none' : '';
    }

    btn.addEventListener('click', function() {
        setMuteState(!isMuted);
    });

    // Re-synchroniser l'état mute à chaque changement de slide
    document.querySelectorAll('.carousel-dot, .hero-video-card, .carousel-nav-btn').forEach(function(el) {
        el.addEventListener('click', function() {
            setTimeout(function() {
                setMuteState(isMuted);
                boostActiveYouTubeQuality();
            }, 400);
        });
    });

    const carouselContainer = document.querySelector('.video-carousel-container');
    if (carouselContainer) {
        const observer = new MutationObserver(function(mutations) {
            let hasActiveChange = false;
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' &&
                    mutation.attributeName === 'class' &&
                    mutation.target.classList &&
                    mutation.target.classList.contains('video-slide')) {
                    hasActiveChange = true;
                }
            });
            if (hasActiveChange) {
                setTimeout(function() {
                    setMuteState(isMuted);
                    boostActiveYouTubeQuality();
                }, 300);
            }
        });
        observer.observe(carouselContainer, {
            subtree: true,
            attributes: true,
            attributeFilter: ['class']
        });
    }

    boostActiveYouTubeQuality();
});

/* ─────────────────────────────────────────────
   Fit précis des iframes YouTube/Vimeo du Hero
   Réduit le zoom tout en évitant les bandes noires
   ───────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function() {
    const VIDEO_RATIO = 16 / 9;
    const VERTICAL_FOCUS_TOP = 54;

    function fitHeroIframes() {
        document.querySelectorAll('.video-slide iframe.video-background').forEach(function(iframe) {
            const container = iframe.closest('.video-slide');
            if (!container) return;

            const cw = container.clientWidth;
            const ch = container.clientHeight;
            if (!cw || !ch) return;

            const containerRatio = cw / ch;

            iframe.style.left = '50%';
            // Favorise la zone haute de la vidéo (moins de coupe en haut)
            iframe.style.top = VERTICAL_FOCUS_TOP + '%';
            iframe.style.transform = 'translate(-50%, -50%)';

            if (containerRatio > VIDEO_RATIO) {
                // Conteneur plus large : on ajuste sur la largeur, hauteur auto 16:9
                iframe.style.width = cw + 'px';
                iframe.style.height = (cw / VIDEO_RATIO) + 'px';
            } else {
                // Conteneur plus haut : on ajuste sur la hauteur, largeur auto 16:9
                iframe.style.width = (ch * VIDEO_RATIO) + 'px';
                iframe.style.height = ch + 'px';
            }
        });
    }

    fitHeroIframes();
    window.addEventListener('resize', fitHeroIframes);
    window.addEventListener('orientationchange', fitHeroIframes);

    document.querySelectorAll('.carousel-dot, .hero-video-card, .carousel-nav-btn').forEach(function(el) {
        el.addEventListener('click', function() {
            setTimeout(fitHeroIframes, 420);
        });
    });
});

/* ─────────────────────────────────────────────
   Search-bar sticky : reste visible au scroll (comme le header)
   Garde sa position normale au chargement dans le Hero
   ───────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function() {
    const searchBar = document.querySelector('.hero-v2 .search-bar-v2');
    const header = document.querySelector('.header-v2');
    if (!searchBar || !header) return;

    const spacer = document.createElement('div');
    spacer.style.display = 'none';
    searchBar.insertAdjacentElement('afterend', spacer);

    let stickyStart = 0;

    function measureStickyStart() {
        const wasFloating = searchBar.classList.contains('search-bar-v2-floating');
        if (wasFloating) {
            searchBar.classList.remove('search-bar-v2-floating');
            searchBar.style.top = '';
            spacer.style.display = 'none';
            spacer.style.height = '0px';
        }

        stickyStart = searchBar.getBoundingClientRect().top + window.scrollY;

        if (wasFloating) {
            searchBar.classList.add('search-bar-v2-floating');
        }
    }

    function updateStickySearchBar() {
        if (window.innerWidth <= 1024) {
            searchBar.classList.remove('search-bar-v2-floating');
            searchBar.style.top = '';
            spacer.style.display = 'none';
            spacer.style.height = '0px';
            return;
        }

        const headerBottom = Math.max(0, header.getBoundingClientRect().bottom);
        const shouldFloat = (window.scrollY + headerBottom + 8) >= stickyStart;

        if (shouldFloat) {
            searchBar.classList.add('search-bar-v2-floating');
            searchBar.style.top = (headerBottom + 8) + 'px';
            spacer.style.display = 'block';
            spacer.style.height = searchBar.offsetHeight + 'px';
        } else {
            searchBar.classList.remove('search-bar-v2-floating');
            searchBar.style.top = '';
            spacer.style.display = 'none';
            spacer.style.height = '0px';
        }
    }

    measureStickyStart();
    updateStickySearchBar();

    window.addEventListener('scroll', updateStickySearchBar, { passive: true });
    window.addEventListener('resize', function() {
        measureStickyStart();
        updateStickySearchBar();
    });
});
</script>



