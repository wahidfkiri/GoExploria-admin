{{-- ═══════════════════════════════════════════════════════════════════════
     SHELL PLATEFORME — Version optimisée avec gestion des erreurs,
     cache et Shadow DOM pour une isolation totale.
     ═══════════════════════════════════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $etablissement->name }} — GoExploria Business</title>

    {{-- Préchargement des polices --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Assets de la plateforme (version minifiée) --}}
    @stack('platform-styles')
    <link rel="stylesheet" href="{{ mix('css/home-v2/styles.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/home-v2/vertical-menu.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/home-v2/navigation.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/home-v2/footer.min.css') }}">

    {{-- Styles de l'embed --}}
    <style>
        /* --- Reset --- */
        html, body { 
            margin: 0; 
            padding: 0; 
            height: 100%;
        }
        body {
            background: #ffffff;
            overflow-x: hidden;
            font-family: 'Montserrat', system-ui, sans-serif;
        }

        /* --- Variables configurables --- */
        :root {
            --header-height: {{ $config['headerHeight'] }}px;
            --mobile-header-height: {{ $config['mobileHeaderHeight'] }}px;
            --z-header: {{ $config['zIndex']['header'] }};
            --z-menu: {{ $config['zIndex']['menu'] }};
            --z-modal: {{ $config['zIndex']['modal'] }};
        }

        /* --- Layout --- */
        .gx-embed-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .gx-embed-content {
            flex: 1;
            padding-top: var(--header-height);
            position: relative;
            z-index: 0;
        }

        @media (max-width: 992px) {
            .gx-embed-content {
                padding-top: var(--mobile-header-height);
            }
        }

        .gx-embed-content.has-extracted-header {
            padding-top: calc(var(--header-height) + var(--extracted-header-height, 64px));
        }

        @media (max-width: 992px) {
            .gx-embed-content.has-extracted-header {
                padding-top: calc(var(--mobile-header-height) + var(--extracted-header-height, 64px));
            }
        }

        /* --- Loader --- */
        .gx-embed-loader {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
            padding: 80px 20px;
            color: #6b7280;
        }

        .gx-embed-loader .spinner {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 4px solid #e5e7eb;
            border-top-color: #16794c;
            animation: spin 0.8s linear infinite;
        }

        .gx-embed-loader .error-icon {
            font-size: 48px;
            color: #dc2626;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* --- Header extrait --- */
        .gx-extracted-header {
            position: fixed;
            top: var(--header-height);
            left: 0;
            right: 0;
            z-index: var(--z-header);
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transform: translateY(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
            display: none;
            will-change: transform;
        }

        @media (max-width: 992px) {
            .gx-extracted-header {
                top: var(--mobile-header-height);
            }
        }

        .gx-extracted-header.is-visible {
            transform: translateY(0);
            display: block;
        }

        .gx-extracted-header.is-hidden-at-top {
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
        }

        .gx-extracted-header-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        @media (min-width: 1400px) {
            .gx-extracted-header-inner {
                padding: 0 40px;
            }
        }

        /* --- Shadow DOM Container --- */
        #gxShadowContainer {
            width: 100%;
            min-height: 200px;
        }

        /* --- Bouton menu mobile --- */
        .gx-embed-menu-btn {
            position: fixed;
            left: 20px;
            bottom: calc(80px + env(safe-area-inset-bottom, 0px));
            z-index: var(--z-menu);
            display: none;
            align-items: center;
            gap: 9px;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 800;
            color: #ffffff;
            background: #111827;
            border: none;
            border-radius: 999px;
            box-shadow: 0 14px 34px rgba(0,0,0,0.3);
            cursor: pointer;
            opacity: 0;
            pointer-events: none;
            transform: translateY(12px);
            transition: opacity 0.22s ease, transform 0.22s ease;
        }

        @media (max-width: 1024px) {
            .gx-embed-menu-btn { display: inline-flex; }
        }

        .gx-embed-menu-btn.is-visible {
            opacity: 1;
            pointer-events: auto;
            transform: none;
        }

        .gx-embed-menu-btn:hover {
            background: #1f2937;
        }

        /* --- Bouton scroll top --- */
        .gx-scroll-top-btn {
            position: fixed;
            right: 20px;
            bottom: 80px;
            z-index: var(--z-menu);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            background: #16794c;
            color: #ffffff;
            border: none;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            cursor: pointer;
            transition: all 0.2s ease;
            opacity: 0;
            transform: translateY(20px);
            pointer-events: none;
        }

        @media (max-width: 1024px) {
            .gx-scroll-top-btn { bottom: 140px; }
        }

        .gx-scroll-top-btn.is-visible {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .gx-scroll-top-btn:hover {
            background: #0f5d3a;
            transform: scale(1.05);
        }

        /* --- États de chargement --- */
        .gx-embed-content.is-loading .gx-embed-loader {
            display: flex;
        }

        .gx-embed-content.is-loading #gxShadowContainer {
            display: none;
        }

        .gx-embed-content.is-loaded .gx-embed-loader {
            display: none;
        }

        .gx-embed-content.is-loaded #gxShadowContainer {
            display: block;
        }

        .gx-embed-content.has-error .gx-embed-loader {
            display: flex;
        }

        .gx-embed-content.has-error #gxShadowContainer {
            display: none;
        }

        /* --- Toast notifications --- */
        .gx-toast {
            position: fixed;
            top: calc(var(--header-height) + 20px);
            right: 20px;
            z-index: 99999;
            padding: 16px 24px;
            background: #1f2937;
            color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transform: translateX(120%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            max-width: 400px;
        }

        .gx-toast.is-visible {
            transform: translateX(0);
        }

        .gx-toast.error {
            background: #dc2626;
        }

        .gx-toast.success {
            background: #16794c;
        }
    </style>
</head>
<body>
    <div class="gx-embed-wrapper">
        {{-- HEADER GoExploria --}}
        @include('cms::web.embed.partials.platform-header')

        {{-- HEADER EXTRAIT --}}
        <div class="gx-extracted-header" id="gxExtractedHeader">
            <div class="gx-extracted-header-inner" id="gxExtractedHeaderInner"></div>
        </div>

        {{-- CONTENU PRINCIPAL --}}
        <main class="gx-embed-content is-loading" id="gxEmbedContent">
            {{-- Loader --}}
            <div class="gx-embed-loader" id="gxEmbedLoader">
                <div class="spinner"></div>
                <span>Chargement du site...</span>
            </div>

            {{-- Shadow DOM Container --}}
            <div id="gxShadowContainer"></div>
        </main>

        {{-- FOOTER GoExploria --}}
        @include('cms::web.embed.partials.platform-footer')
    </div>

    {{-- Éléments flottants --}}
    @include('cms::web.fallback.partials.landing-contact-ajax')
    @include('cms::web.fallback.partials.landing-contact-widget')
    @include('cms::web.fallback.partials.landing-cart-drawer')
    @include('cms::web.fallback.partials.landing-back-to-top')

    {{-- Boutons flottants --}}
    <button type="button" class="gx-embed-menu-btn" id="gxEmbedMenuBtn" aria-label="Ouvrir le menu">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
            <path d="M4 7h16M4 12h16M4 17h16"/>
        </svg>
        Menu du site
    </button>

    <button type="button" class="gx-scroll-top-btn" id="gxScrollTopBtn" aria-label="Remonter">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 19V5M5 12l7-7 7 7"/>
        </svg>
    </button>

    {{-- Toast --}}
    <div class="gx-toast" id="gxToast"></div>

    {{-- Assets JS de la plateforme (version minifiée) --}}
    @stack('platform-scripts')
    <script src="{{ mix('js/home-v2/navigation.min.js') }}"></script>
    <script src="{{ mix('js/home-v2/vertical-menu.min.js') }}"></script>
    <script src="{{ mix('js/home-v2/mega-menu.min.js') }}"></script>

    {{-- Script principal de l'embed --}}
    <script>
        (function() {
            'use strict';

            class EmbedManager {
                constructor(config) {
                    this.config = config;
                    this.elements = {
                        container: document.getElementById('gxShadowContainer'),
                        loader: document.getElementById('gxEmbedLoader'),
                        content: document.getElementById('gxEmbedContent'),
                        header: document.getElementById('gxExtractedHeader'),
                        headerInner: document.getElementById('gxExtractedHeaderInner'),
                        menuBtn: document.getElementById('gxEmbedMenuBtn'),
                        scrollBtn: document.getElementById('gxScrollTopBtn'),
                        toast: document.getElementById('gxToast')
                    };

                    this.shadowRoot = null;
                    this.isHeaderFixed = false;
                    this.headerHeight = 0;
                    this.state = {
                        isLoading: true,
                        isLoaded: false,
                        hasError: false
                    };

                    this.init();
                }

                init() {
                    if (!this.elements.container) return;
                    this.loadContent();
                    this.setupEventListeners();
                    this.setupObservers();
                }

                // ── CHARGEMENT DU CONTENU ──────────────────────────────
                async loadContent() {
                    try {
                        this.setState('loading');
                        
                        const url = '{{ route("embed.content", ["etablissementId" => $etablissement->id]) }}';
                        const response = await fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}`);
                        }

                        const data = await response.json();
                        
                        if (!data.success) {
                            throw new Error(data.message || 'Erreur de chargement');
                        }

                        this.renderContent(data.data);
                        this.setState('loaded');

                    } catch (error) {
                        console.error('Erreur:', error);
                        this.setState('error', error.message);
                        this.showToast(error.message, 'error');
                    }
                }

                // ── RENDU DU CONTENU ────────────────────────────────────
                renderContent(data) {
                    // Créer le Shadow DOM
                    this.createShadowRoot();

                    // Injecter les styles
                    if (data.styles && data.styles.length > 0) {
                        data.styles.forEach(styleContent => {
                            const styleEl = document.createElement('style');
                            styleEl.textContent = styleContent;
                            this.shadowRoot.appendChild(styleEl);
                        });
                    }

                    // Injecter le contenu
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = data.content || '';
                    this.shadowRoot.appendChild(wrapper);

                    // Extraire et afficher le header
                    if (data.header) {
                        this.extractAndDisplayHeader(data.header);
                    }

                    // Exécuter les scripts
                    if (data.scripts && data.scripts.length > 0) {
                        this.executeScripts(data.scripts);
                    }

                    // Initialiser les composants
                    this.initializeComponents();

                    // Ajuster la hauteur
                    this.adjustHeight();
                }

                // ── SHADOW DOM ──────────────────────────────────────────
                createShadowRoot() {
                    if (this.elements.container.shadowRoot) {
                        this.shadowRoot = this.elements.container.shadowRoot;
                        this.shadowRoot.innerHTML = '';
                    } else {
                        this.shadowRoot = this.elements.container.attachShadow({ mode: 'open' });
                    }

                    // Style de base
                    const resetStyle = document.createElement('style');
                    resetStyle.textContent = `
                        :host { display: block; width: 100%; }
                        * { box-sizing: border-box; }
                    `;
                    this.shadowRoot.appendChild(resetStyle);

                    return this.shadowRoot;
                }

                // ── EXTRACTION DU HEADER ───────────────────────────────
                extractAndDisplayHeader(headerHtml) {
                    if (!this.elements.headerInner) return;

                    // Nettoyer le header
                    const temp = document.createElement('div');
                    temp.innerHTML = headerHtml;
                    const header = temp.firstElementChild;

                    if (!header) return;

                    // Nettoyer les scripts
                    header.querySelectorAll('script').forEach(el => el.remove());

                    // Nettoyer les attributs problématiques
                    header.style.position = 'relative';
                    header.style.top = 'auto';
                    header.style.left = 'auto';
                    header.style.right = 'auto';
                    header.style.bottom = 'auto';
                    header.style.width = '100%';
                    header.style.zIndex = 'auto';
                    header.style.transform = 'none';

                    // Mesurer la hauteur
                    const rect = header.getBoundingClientRect();
                    this.headerHeight = rect.height || 64;

                    // Injecter
                    this.elements.headerInner.innerHTML = '';
                    this.elements.headerInner.appendChild(header);

                    // Afficher
                    this.elements.header.style.display = 'block';
                    this.elements.header.style.top = this.isMobile() 
                        ? `${this.config.mobileHeaderHeight}px` 
                        : `${this.config.headerHeight}px`;

                    // Mettre à jour le padding
                    this.updatePadding(this.headerHeight);

                    // Animation
                    requestAnimationFrame(() => {
                        this.elements.header.classList.add('is-visible');
                        this.isHeaderFixed = true;
                        this.updateHeaderVisibility();
                    });

                    // Bouton scroll
                    if (this.elements.scrollBtn) {
                        this.elements.scrollBtn.classList.add('is-visible');
                    }

                    // Synchroniser les clics
                    this.synchronizeClicks(header);
                }

                // ── EXÉCUTION DES SCRIPTS ──────────────────────────────
                executeScripts(scripts) {
                    scripts.forEach(scriptData => {
                        const script = document.createElement('script');
                        
                        if (scriptData.type === 'external') {
                            script.src = scriptData.src;
                            script.async = false;
                        } else {
                            script.textContent = scriptData.content;
                        }

                        this.shadowRoot.appendChild(script);
                    });
                }

                // ── INITIALISATION DES COMPOSANTS ──────────────────────
                initializeComponents() {
                    setTimeout(() => {
                        // Réinitialiser Swiper
                        if (typeof Swiper !== 'undefined' && this.shadowRoot) {
                            this.shadowRoot.querySelectorAll('.swiper-container, .swiper').forEach(el => {
                                if (el.swiper) el.swiper.destroy(true, true);
                                new Swiper(el, {});
                            });
                        }

                        // Réinitialiser les menus mobiles
                        if (this.shadowRoot) {
                            this.shadowRoot.querySelectorAll('.menu-toggle, .navbar-toggler, .hamburger')
                                .forEach(btn => {
                                    btn.addEventListener('click', (e) => {
                                        const target = btn.dataset.target || btn.getAttribute('data-target');
                                        if (target) {
                                            const menu = this.shadowRoot.querySelector(target);
                                            if (menu) {
                                                menu.classList.toggle('show');
                                                menu.classList.toggle('active');
                                                btn.classList.toggle('is-active');
                                            }
                                        }
                                    });
                                });
                        }

                        // Déclencher DOMContentLoaded
                        const event = new Event('DOMContentLoaded', { bubbles: true });
                        if (this.shadowRoot) this.shadowRoot.dispatchEvent(event);
                        document.dispatchEvent(event);

                    }, 100);
                }

                // ── UTILITAIRES ──────────────────────────────────────────
                setState(state, message = '') {
                    this.state.isLoading = state === 'loading';
                    this.state.isLoaded = state === 'loaded';
                    this.state.hasError = state === 'error';

                    const content = this.elements.content;
                    content.classList.remove('is-loading', 'is-loaded', 'has-error');
                    
                    if (state === 'loading') content.classList.add('is-loading');
                    if (state === 'loaded') content.classList.add('is-loaded');
                    if (state === 'error') content.classList.add('has-error');

                    if (state === 'error' && this.elements.loader) {
                        this.elements.loader.innerHTML = `
                            <div class="error-icon">❌</div>
                            <span>${message}</span>
                            <button onclick="location.reload()" style="
                                margin-top: 12px;
                                padding: 8px 24px;
                                background: #16794c;
                                color: #fff;
                                border: none;
                                border-radius: 4px;
                                cursor: pointer;
                            ">Réessayer</button>
                        `;
                    }
                }

                isMobile() {
                    return window.innerWidth <= 992;
                }

                updatePadding(height) {
                    const isMobile = this.isMobile();
                    const basePadding = isMobile 
                        ? this.config.mobileHeaderHeight 
                        : this.config.headerHeight;
                    
                    const content = this.elements.content;
                    content.style.setProperty('--extracted-header-height', height + 'px');
                    content.classList.add('has-extracted-header');
                }

                updateHeaderVisibility() {
                    if (!this.elements.header || !this.isHeaderFixed) return;
                    
                    const threshold = this.headerHeight || 100;
                    const shouldHide = window.scrollY < threshold;
                    
                    this.elements.header.classList.toggle('is-hidden-at-top', shouldHide);
                    
                    if (this.elements.scrollBtn) {
                        this.elements.scrollBtn.classList.toggle('is-visible', shouldHide && this.isHeaderFixed);
                    }
                }

                adjustHeight() {
                    if (!this.shadowRoot) return;
                    const height = this.shadowRoot.host.scrollHeight || 200;
                    const content = this.elements.content;
                    if (content) {
                        content.style.minHeight = (height + 100) + 'px';
                    }
                }

                synchronizeClicks(clonedHeader) {
                    clonedHeader.querySelectorAll('a, button').forEach(el => {
                        el.addEventListener('click', (e) => {
                            e.preventDefault();
                            
                            // Chercher l'élément correspondant dans le shadow DOM
                            let target = null;
                            
                            if (el.id) {
                                target = this.shadowRoot.getElementById(el.id);
                            }
                            
                            if (!target && el.textContent.trim()) {
                                const text = el.textContent.trim();
                                const elements = this.shadowRoot.querySelectorAll('a, button');
                                for (let i = 0; i < elements.length; i++) {
                                    if (elements[i].textContent.trim() === text) {
                                        target = elements[i];
                                        break;
                                    }
                                }
                            }
                            
                            if (target && target.click) {
                                target.click();
                            }
                        });
                    });
                }

                // ── TOAST ─────────────────────────────────────────────────
                showToast(message, type = 'info') {
                    const toast = this.elements.toast;
                    if (!toast) return;

                    toast.textContent = message;
                    toast.className = `gx-toast ${type}`;
                    toast.classList.add('is-visible');

                    clearTimeout(this.toastTimeout);
                    this.toastTimeout = setTimeout(() => {
                        toast.classList.remove('is-visible');
                    }, 5000);
                }

                // ── ÉVÉNEMENTS ──────────────────────────────────────────
                setupEventListeners() {
                    // Menu
                    if (this.elements.menuBtn) {
                        this.elements.menuBtn.addEventListener('click', () => {
                            if (this.shadowRoot) {
                                const toggle = this.shadowRoot.querySelector('.menu-toggle, .navbar-toggler, .hamburger');
                                if (toggle && toggle.click) toggle.click();
                            }
                        });

                        let menuThreshold = 400;
                        let menuVisible = false;
                        window.addEventListener('scroll', () => {
                            const shouldShow = window.scrollY > menuThreshold;
                            if (shouldShow !== menuVisible) {
                                menuVisible = shouldShow;
                                this.elements.menuBtn.classList.toggle('is-visible', shouldShow);
                            }
                        }, { passive: true });
                        
                        // État initial
                        this.elements.menuBtn.classList.toggle('is-visible', window.scrollY > menuThreshold);
                    }

                    // Scroll top
                    if (this.elements.scrollBtn) {
                        this.elements.scrollBtn.addEventListener('click', () => {
                            if (this.isHeaderFixed) {
                                const rect = this.elements.header.getBoundingClientRect();
                                const top = rect.top + window.scrollY - 10;
                                window.scrollTo({ top, behavior: 'smooth' });
                            }
                        });
                    }

                    // Scroll pour la visibilité du header
                    let scrollTimeout = null;
                    window.addEventListener('scroll', () => {
                        if (scrollTimeout) return;
                        scrollTimeout = setTimeout(() => {
                            this.updateHeaderVisibility();
                            scrollTimeout = null;
                        }, 50);
                    }, { passive: true });

                    // Resize
                    let resizeTimeout = null;
                    window.addEventListener('resize', () => {
                        clearTimeout(resizeTimeout);
                        resizeTimeout = setTimeout(() => {
                            if (this.isHeaderFixed && this.elements.header) {
                                const rect = this.elements.header.getBoundingClientRect();
                                if (rect.height !== this.headerHeight) {
                                    this.headerHeight = rect.height;
                                    this.updatePadding(this.headerHeight);
                                }
                                
                                this.elements.header.style.top = this.isMobile()
                                    ? `${this.config.mobileHeaderHeight}px`
                                    : `${this.config.headerHeight}px`;
                            }
                            
                            this.adjustHeight();
                        }, 200);
                    }, { passive: true });
                }

                // ── OBSERVATEURS ────────────────────────────────────────
                setupObservers() {
                    // MutationObserver pour la hauteur
                    if (window.MutationObserver && this.shadowRoot) {
                        const observer = new MutationObserver(() => this.adjustHeight());
                        observer.observe(this.shadowRoot.host, {
                            childList: true,
                            subtree: true,
                            attributes: true
                        });
                    }

                    // ResizeObserver
                    if (window.ResizeObserver && this.elements.container) {
                        const ro = new ResizeObserver(() => this.adjustHeight());
                        ro.observe(this.elements.container);
                    }
                }
            }

            // ── INITIALISATION ──────────────────────────────────────────
            document.addEventListener('DOMContentLoaded', () => {
                const config = @json($config);
                window.embedManager = new EmbedManager(config);
            });

        })();
    </script>
</body>
</html>