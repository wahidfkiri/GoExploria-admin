{{-- ═══════════════════════════════════════════════════════════════════════
     SHELL PLATEFORME — Menus totalement isolés
     ═══════════════════════════════════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $etablissement->name }} — GoExploria Business</title>

    {{-- Polices --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Assets de la plateforme --}}
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu-videos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-destinations-mega.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/videos-dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">

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

        :root {
            --header-height: 96px;
            --mobile-header-height: 80px;
            --z-header: 9998;
            --z-menu: 9997;
        }

        @media (max-width: 992px) {
            :root {
                --header-height: 80px;
                --mobile-header-height: 80px;
            }
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
            min-height: 60vh;
        }

        .gx-embed-content.has-extracted-header {
            padding-top: calc(var(--header-height) + var(--extracted-header-height, 64px));
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
            font-size: 14px;
        }

        .gx-embed-loader .spinner {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 4px solid #e5e7eb;
            border-top-color: #16794c;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* --- Header extrait (isolation totale) --- */
        .gx-extracted-header {
            position: fixed;
            top: var(--header-height);
            left: 0;
            right: 0;
            z-index: var(--z-header);
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transform: translateY(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: none;
            will-change: transform;
            pointer-events: auto;
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

        /* --- Shadow DOM Container --- */
        #gxShadowContainer {
            width: 100%;
            min-height: 200px;
        }

        /* --- Bouton menu mobile (pour ouvrir le menu du landing) --- */
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
            font-family: 'Montserrat', system-ui, sans-serif;
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

        /* --- États --- */
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

        .gx-embed-loader .error-icon {
            font-size: 48px;
            color: #dc2626;
        }

        .gx-embed-loader .retry-btn {
            margin-top: 12px;
            padding: 8px 24px;
            background: #16794c;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .gx-embed-loader .retry-btn:hover {
            background: #0f5d3a;
        }
    </style>
</head>
<body>
    <div class="gx-embed-wrapper">
        {{-- HEADER GoExploria (plateforme) --}}
        @include('cms::web.embed.partials.platform-header')

        {{-- HEADER EXTRAIT (landing) - isolé --}}
        <div class="gx-extracted-header" id="gxExtractedHeader">
            <div class="gx-extracted-header-inner" id="gxExtractedHeaderInner"></div>
        </div>

        {{-- CONTENU PRINCIPAL --}}
        <main class="gx-embed-content is-loading" id="gxEmbedContent">
            <div class="gx-embed-loader" id="gxEmbedLoader">
                <div class="spinner"></div>
                <span>Chargement du site...</span>
            </div>
            <div id="gxShadowContainer"></div>
        </main>

        {{-- FOOTER GoExploria --}}
        @include('cms::web.embed.partials.platform-footer')
    </div>

    {{-- Éléments flottants de la plateforme --}}
    @include('cms::web.fallback.partials.landing-contact-ajax')
    @include('cms::web.fallback.partials.landing-contact-widget')
    @include('cms::web.fallback.partials.landing-cart-drawer')
    @include('cms::web.fallback.partials.landing-back-to-top')

    {{-- Bouton pour ouvrir le menu du landing (mobile) --}}
    <button type="button" class="gx-embed-menu-btn" id="gxEmbedMenuBtn" aria-label="Ouvrir le menu du site">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
            <path d="M4 7h16M4 12h16M4 17h16"/>
        </svg>
        Menu du site
    </button>

    {{-- Bouton scroll top --}}
    <button type="button" class="gx-scroll-top-btn" id="gxScrollTopBtn" aria-label="Remonter">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 19V5M5 12l7-7 7 7"/>
        </svg>
    </button>

    {{-- Assets JS de la plateforme --}}
    <script src="{{ asset('js/home-v2/navigation.js') }}"></script>
    <script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu-service.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-destinations-mega.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/destinations-mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/destinations-search.js') }}"></script>
    <script src="{{ asset('js/home-v2/search-bar.js') }}"></script>

    {{-- Script principal (corrigé pour l'isolation des menus) --}}
    <script>
        (function() {
            'use strict';

            // ── CONFIGURATION ──────────────────────────────────────────
            var CONFIG = {
                headerHeight: 96,
                mobileHeaderHeight: 80,
                etablissementId: {{ $etablissement->id }},
                embedUrl: '{{ route("cms.company.embed", ["etablissementId" => $etablissement->id]) }}'
            };

            // ── FLAGS ──────────────────────────────────────────────────
            var isLoaded = false;
            var isLoading = false;
            var loadAttempts = 0;
            var MAX_ATTEMPTS = 1;

            // ── ÉLÉMENTS DOM ──────────────────────────────────────────
            var elements = {
                container: document.getElementById('gxShadowContainer'),
                loader: document.getElementById('gxEmbedLoader'),
                content: document.getElementById('gxEmbedContent'),
                header: document.getElementById('gxExtractedHeader'),
                headerInner: document.getElementById('gxExtractedHeaderInner'),
                menuBtn: document.getElementById('gxEmbedMenuBtn'),
                scrollBtn: document.getElementById('gxScrollTopBtn')
            };

            var shadowRoot = null;
            var isHeaderFixed = false;
            var headerHeight = 64;

            // ── FONCTIONS DE NETTOYAGE POUR ÉVITER LES CONFLITS ──────

            /**
             * Nettoie les scripts pour éviter les conflits avec la plateforme
             */
            function cleanScriptContent(content) {
                if (!content) return content;

                // Bloquer les appels qui pourraient recharger la page
                var cleaned = content
                    .replace(/location\.reload/g, '/* location.reload bloque */')
                    .replace(/window\.location\.reload/g, '/* window.location.reload bloque */')
                    .replace(/document\.location\.reload/g, '/* document.location.reload bloque */')
                    .replace(/history\.pushState/g, '/* history.pushState bloque */')
                    .replace(/history\.replaceState/g, '/* history.replaceState bloque */')
                    .replace(/fetch\s*\(/g, '/* fetch bloque */')
                    .replace(/XMLHttpRequest/g, '/* XMLHttpRequest bloque */')
                    .replace(/\$\.ajax/g, '/* $.ajax bloque */')
                    .replace(/axios/g, '/* axios bloque */');

                return cleaned;
            }

            /**
             * Vérifie si un script peut causer des conflits
             */
            function isConflictScript(src, content) {
                var conflictPatterns = [
                    'navigation.js',
                    'vertical-menu.js',
                    'mega-menu.js',
                    'menu-api-service.js',
                    'header-fixed',
                    'sticky-header'
                ];

                var source = (src || '').toLowerCase();
                var text = (content || '').toLowerCase();

                for (var i = 0; i < conflictPatterns.length; i++) {
                    if (source.indexOf(conflictPatterns[i]) !== -1) {
                        return true;
                    }
                    if (text.indexOf(conflictPatterns[i]) !== -1) {
                        return true;
                    }
                }

                return false;
            }

            // ── CHARGEMENT DU CONTENU ──────────────────────────────────
            function loadContent() {
                if (isLoaded || isLoading) {
                    return;
                }

                if (loadAttempts >= MAX_ATTEMPTS) {
                    return;
                }

                loadAttempts++;
                isLoading = true;
                setState('loading');

                fetch(CONFIG.embedUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Erreur HTTP ' + response.status);
                    }
                    return response.text();
                })
                .then(function(html) {
                    renderContent(html);
                    isLoaded = true;
                    isLoading = false;
                    setState('loaded');
                })
                .catch(function(error) {
                    console.error('Erreur:', error);
                    isLoading = false;
                    setState('error', error.message);
                });
            }

            // ── RENDU DU CONTENU ──────────────────────────────────────
            function renderContent(html) {
                createShadowRoot();

                var content = extractBody(html);
                var styles = extractStyles(html);
                var headerHtml = extractHeader(html);

                // Injecter les styles
                styles.forEach(function(styleContent) {
                    var styleEl = document.createElement('style');
                    styleEl.textContent = styleContent;
                    shadowRoot.appendChild(styleEl);
                });

                // Injecter le contenu
                var wrapper = document.createElement('div');
                wrapper.innerHTML = content;
                shadowRoot.appendChild(wrapper);

                // Extraire et afficher le header
                if (headerHtml) {
                    extractAndDisplayHeader(headerHtml);
                }

                // Exécuter les scripts (avec nettoyage)
                executeScriptsSafely(wrapper);

                // Initialiser les composants du template
                initializeTemplate();

                // Ajuster la hauteur
                adjustHeight();
            }

            // ── SHADOW DOM ─────────────────────────────────────────────
            function createShadowRoot() {
                if (elements.container.shadowRoot) {
                    shadowRoot = elements.container.shadowRoot;
                    shadowRoot.innerHTML = '';
                } else {
                    shadowRoot = elements.container.attachShadow({ mode: 'open' });
                }

                // Style de base pour le shadow DOM
                var resetStyle = document.createElement('style');
                resetStyle.textContent = `
                    :host { 
                        display: block; 
                        width: 100%; 
                    }
                    * {
                        box-sizing: border-box;
                    }
                    .menu-toggle, .navbar-toggler, .hamburger {
                        cursor: pointer;
                    }
                    .nav-menu, .navbar-collapse, .main-menu, .mobile-menu {
                        display: none;
                    }
                    .nav-menu.show, .navbar-collapse.show, .main-menu.show, .mobile-menu.show,
                    .nav-menu.active, .navbar-collapse.active, .main-menu.active, .mobile-menu.active {
                        display: block;
                    }
                `;
                shadowRoot.appendChild(resetStyle);

                return shadowRoot;
            }

            // ── EXTRACTION ─────────────────────────────────────────────
            function extractBody(html) {
                var match = html.match(/<body[^>]*>([\s\S]*?)<\/body>/i);
                if (match && match[1]) {
                    return match[1];
                }
                return html;
            }

            function extractStyles(html) {
                var styles = [];
                var regex = /<style[^>]*>([\s\S]*?)<\/style>/gi;
                var match;
                while ((match = regex.exec(html)) !== null) {
                    styles.push(match[1]);
                }
                return styles;
            }

            function extractHeader(html) {
                var temp = document.createElement('div');
                temp.innerHTML = html;

                var selectors = [
                    'header.header-fixed', 'header.sticky-header', 'header.fixed-top',
                    'header.sticky-top', 'header[class*="fixed"]', 'header[class*="sticky"]',
                    '.header-fixed', '.sticky-header', '.fixed-header',
                    'header:first-of-type', '.header:first-of-type',
                    '[role="banner"]', '#header', '#main-header', '#site-header'
                ];

                for (var i = 0; i < selectors.length; i++) {
                    var el = temp.querySelector(selectors[i]);
                    if (el) {
                        return el.outerHTML;
                    }
                }

                var header = temp.querySelector('header');
                if (header) {
                    return header.outerHTML;
                }

                return null;
            }

            // ── EXÉCUTION SÉCURISÉE DES SCRIPTS ──────────────────────
            function executeScriptsSafely(wrapper) {
                var scripts = wrapper.querySelectorAll('script');
                var scriptCounter = 0;

                scripts.forEach(function(oldScript) {
                    var src = oldScript.getAttribute('src') || '';
                    var content = oldScript.textContent || '';

                    // Ignorer les scripts de la plateforme (conflits)
                    if (isConflictScript(src, content)) {
                        oldScript.parentNode.removeChild(oldScript);
                        return;
                    }

                    var newScript = document.createElement('script');
                    
                    // Copier les attributs
                    Array.from(oldScript.attributes).forEach(function(attr) {
                        newScript.setAttribute(attr.name, attr.value);
                    });
                    
                    if (src) {
                        newScript.src = src;
                        newScript.async = false;
                    } else if (content) {
                        var cleaned = cleanScriptContent(content);
                        newScript.textContent = cleaned;
                    } else {
                        oldScript.parentNode.removeChild(oldScript);
                        return;
                    }
                    
                    newScript.setAttribute('data-embed-executed', 'true');
                    oldScript.parentNode.replaceChild(newScript, oldScript);
                    scriptCounter++;
                });
            }

            // ── EXTRACTION ET AFFICHAGE DU HEADER ─────────────────────
            function extractAndDisplayHeader(headerHtml) {
                if (!elements.headerInner) return;

                var temp = document.createElement('div');
                temp.innerHTML = headerHtml;
                var header = temp.firstElementChild;

                if (!header) return;

                // Supprimer les scripts pour éviter les conflits
                header.querySelectorAll('script').forEach(function(el) {
                    el.remove();
                });

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
                headerHeight = header.offsetHeight || 64;

                // Injecter
                elements.headerInner.innerHTML = '';
                elements.headerInner.appendChild(header);

                // Afficher
                elements.header.style.display = 'block';
                updateHeaderPosition();

                updatePadding(headerHeight);

                requestAnimationFrame(function() {
                    elements.header.classList.add('is-visible');
                    isHeaderFixed = true;
                    updateHeaderVisibility();
                });

                if (elements.scrollBtn) {
                    elements.scrollBtn.classList.add('is-visible');
                }

                // Synchroniser les clics
                synchronizeClicks(header);
            }

            // ── SYNCHRONISATION DES CLICS ─────────────────────────────
            function synchronizeClicks(clonedHeader) {
                var links = clonedHeader.querySelectorAll('a, button');
                links.forEach(function(el) {
                    el.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        var target = null;
                        
                        if (el.id) {
                            target = shadowRoot.getElementById(el.id);
                        }
                        
                        if (!target && el.textContent.trim()) {
                            var text = el.textContent.trim();
                            var elements = shadowRoot.querySelectorAll('a, button');
                            for (var i = 0; i < elements.length; i++) {
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

            // ── INITIALISATION DES COMPOSANTS ─────────────────────────
            function initializeTemplate() {
                setTimeout(function() {
                    if (!shadowRoot) return;

                    // Initialiser SWIPER (si présent)
                    if (typeof Swiper !== 'undefined') {
                        shadowRoot.querySelectorAll('.swiper-container, .swiper').forEach(function(el) {
                            if (el.swiper) {
                                el.swiper.destroy(true, true);
                            }
                            try {
                                new Swiper(el, {});
                            } catch(e) {}
                        });
                    }

                    // Initialiser les menus mobiles UNIQUEMENT dans le shadow DOM
                    var menuToggles = shadowRoot.querySelectorAll('.menu-toggle, .navbar-toggler, .hamburger');
                    menuToggles.forEach(function(btn) {
                        // Supprimer les anciens écouteurs
                        var newBtn = btn.cloneNode(true);
                        btn.parentNode.replaceChild(newBtn, btn);
                        
                        newBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            
                            var target = this.dataset.target || this.getAttribute('data-target');
                            if (target) {
                                var menu = shadowRoot.querySelector(target);
                                if (menu) {
                                    menu.classList.toggle('show');
                                    menu.classList.toggle('active');
                                    this.classList.toggle('is-active');
                                }
                            }
                        });
                    });

                    // Déclencher DOMContentLoaded (une seule fois)
                    var event = new Event('DOMContentLoaded', { bubbles: true });
                    shadowRoot.dispatchEvent(event);

                }, 300);
            }

            // ── OUVERTURE DU MENU MOBILE (landing) ──────────────────
            function openMobileMenu() {
                if (!shadowRoot) {
                    return;
                }

                // 1. Chercher le bouton de menu dans le shadow DOM
                var menuToggle = shadowRoot.querySelector('.menu-toggle, .navbar-toggler, .hamburger, [aria-label="Menu"], [aria-label="Toggle navigation"]');
                
                if (menuToggle) {
                    menuToggle.click();
                    return;
                }

                // 2. Fallback: toggle le menu directement
                var menuSelectors = [
                    '.nav-menu', '.navbar-collapse', '.main-menu', 
                    '.mobile-menu', '.menu-mobile'
                ];
                
                var menu = null;
                for (var i = 0; i < menuSelectors.length; i++) {
                    menu = shadowRoot.querySelector(menuSelectors[i]);
                    if (menu) break;
                }

                if (menu) {
                    menu.classList.toggle('show');
                    menu.classList.toggle('active');
                    
                    var parent = menu.closest('nav') || menu.parentElement;
                    var btn = parent ? parent.querySelector('.menu-toggle, .navbar-toggler, .hamburger') : null;
                    if (btn) {
                        btn.classList.toggle('is-active');
                    }
                    return;
                }
            }

            // ── UTILITAIRES ─────────────────────────────────────────────
            function setState(state, message) {
                var content = elements.content;
                content.classList.remove('is-loading', 'is-loaded', 'has-error');
                
                if (state === 'loading') {
                    content.classList.add('is-loading');
                    if (elements.loader) {
                        elements.loader.innerHTML = `
                            <div class="spinner"></div>
                            <span>Chargement du site...</span>
                        `;
                    }
                } else if (state === 'loaded') {
                    content.classList.add('is-loaded');
                } else if (state === 'error') {
                    content.classList.add('has-error');
                    if (elements.loader) {
                        elements.loader.innerHTML = `
                            <div class="error-icon">❌</div>
                            <span>${message || 'Erreur de chargement'}</span>
                            <button class="retry-btn" onclick="location.reload()">Réessayer</button>
                        `;
                    }
                }
            }

            function isMobile() {
                return window.innerWidth <= 992;
            }

            function updateHeaderPosition() {
                if (elements.header) {
                    var top = isMobile() ? CONFIG.mobileHeaderHeight : CONFIG.headerHeight;
                    elements.header.style.top = top + 'px';
                }
            }

            function updatePadding(height) {
                var content = elements.content;
                content.style.setProperty('--extracted-header-height', (height || 64) + 'px');
                content.classList.add('has-extracted-header');
            }

            function updateHeaderVisibility() {
                if (!elements.header || !isHeaderFixed) return;
                
                var threshold = headerHeight || 100;
                var shouldHide = window.scrollY < threshold;
                
                elements.header.classList.toggle('is-hidden-at-top', shouldHide);
                
                if (elements.scrollBtn) {
                    elements.scrollBtn.classList.toggle('is-visible', shouldHide && isHeaderFixed);
                }
            }

            function adjustHeight() {
                if (!shadowRoot) return;
                var height = shadowRoot.host.scrollHeight || 200;
                var content = elements.content;
                if (content) {
                    content.style.minHeight = (height + 100) + 'px';
                }
            }

            // ── ÉVÉNEMENTS ──────────────────────────────────────────────

            // Bouton menu (ouvre le menu du landing)
            if (elements.menuBtn) {
                elements.menuBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    openMobileMenu();
                });

                // Visibilité du bouton menu
                var menuThreshold = 400;
                window.addEventListener('scroll', function() {
                    var shouldShow = window.scrollY > menuThreshold;
                    elements.menuBtn.classList.toggle('is-visible', shouldShow);
                }, { passive: true });
                
                elements.menuBtn.classList.toggle('is-visible', window.scrollY > menuThreshold);
            }

            // Bouton scroll top
            if (elements.scrollBtn) {
                elements.scrollBtn.addEventListener('click', function() {
                    if (isHeaderFixed) {
                        var rect = elements.header.getBoundingClientRect();
                        var top = rect.top + window.scrollY - 10;
                        window.scrollTo({ top: top, behavior: 'smooth' });
                    }
                });
            }

            // Scroll header
            var scrollTimeout = null;
            window.addEventListener('scroll', function() {
                if (scrollTimeout) return;
                scrollTimeout = setTimeout(function() {
                    updateHeaderVisibility();
                    scrollTimeout = null;
                }, 50);
            }, { passive: true });

            // Resize
            var resizeTimeout = null;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    if (isHeaderFixed && elements.header) {
                        var rect = elements.header.getBoundingClientRect();
                        if (rect.height !== headerHeight) {
                            headerHeight = rect.height;
                            updatePadding(headerHeight);
                        }
                        updateHeaderPosition();
                    }
                    adjustHeight();
                }, 200);
            }, { passive: true });

            // Observers
            if (window.MutationObserver && elements.container) {
                var observer = new MutationObserver(function() {
                    adjustHeight();
                });
                observer.observe(elements.container, {
                    childList: true,
                    subtree: true,
                    attributes: true
                });
            }

            if (window.ResizeObserver && elements.container) {
                var ro = new ResizeObserver(function() {
                    adjustHeight();
                });
                ro.observe(elements.container);
            }

            // ── DÉMARRAGE ──────────────────────────────────────────────
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', loadContent);
            } else {
                loadContent();
            }

        })();
    </script>
</body>
</html>