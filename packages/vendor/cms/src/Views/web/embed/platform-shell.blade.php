{{-- ═══════════════════════════════════════════════════════════════════════
     SHELL PLATEFORME — Affiche le site d'un établissement DANS GoExploria
     Business, avec ISOLATION TOTALE via Shadow DOM.
     
     Le contenu est chargé dans un Shadow DOM, ce qui isole :
     - Les CSS (styles du template vs plateforme)
     - Les JS (pas de conflit de variables globales)
     - Le DOM (les sélecteurs ne se mélangent pas)
     
     LE HEADER EST FIXE CAR IL EST DANS LE DOM PRINCIPAL
     ═══════════════════════════════════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ function_exists('get_site_name') ? get_site_name($etablissement->id) : $etablissement->name }} — GoExploria Business</title>

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
        /* --- Réinitialisation --- */
        html, body { margin: 0; padding: 0; }
        body {
            background: #ffffff;
            overflow-x: hidden;
        }

        /* --- Zone du contenu --- */
        .gx-content-stage {
            width: 100%;
            padding-top: 96px;
            box-sizing: border-box;
            position: relative;
            z-index: 0;
            min-height: 80vh;
        }
        @media (max-width: 992px) {
            .gx-content-stage { padding-top: 80px; }
        }

        /* --- Chargeur --- */
        .gx-content-loader {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 80px 16px;
            color: #6b7280;
            font-family: Montserrat, system-ui, sans-serif;
            font-size: 14px;
        }
        .gx-content-loader .spinner {
            width: 22px; height: 22px; border-radius: 50%;
            border: 3px solid #e5e7eb; border-top-color: #16794c;
            animation: spin .8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* --- Shadow DOM Container --- */
        #gxShadowContainer {
            width: 100%;
            min-height: 200px;
        }

        /* --- Header extrait du template (affiché dans le DOM parent) --- */
        .gx-extracted-header {
            position: fixed;
            top: 96px;
            left: 0;
            right: 0;
            z-index: 9998;
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transform: translateY(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: none;
            max-height: 80vh;
            overflow-y: auto;
        }
        @media (max-width: 992px) {
            .gx-extracted-header {
                top: 80px;
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

        /* --- Ajustement du padding --- */
        .gx-content-stage.has-extracted-header {
            padding-top: 160px;
        }
        @media (max-width: 992px) {
            .gx-content-stage.has-extracted-header {
                padding-top: 140px;
            }
        }

        /* --- Bouton Menu du site (mobile) --- */
        .gx-embed-menu {
            position: fixed;
            left: 20px;
            bottom: calc(80px + env(safe-area-inset-bottom, 0px));
            z-index: 9997;
            display: none;
            align-items: center;
            gap: 9px;
            padding: 12px 18px;
            font-family: Montserrat, system-ui, sans-serif;
            font-size: 14px;
            font-weight: 800;
            color: #ffffff;
            background: #111827;
            border: 0;
            border-radius: 999px;
            box-shadow: 0 14px 34px rgba(0, 0, 0, .3);
            cursor: pointer;
            opacity: 0;
            pointer-events: none;
            transform: translateY(12px);
            transition: opacity .22s ease, transform .22s ease;
        }
        @media (max-width: 1024px) {
            .gx-embed-menu { display: inline-flex; }
        }
        .gx-embed-menu.is-visible {
            opacity: 1;
            pointer-events: auto;
            transform: none;
        }
        .gx-embed-menu:hover { background: #1f2937; }

        /* --- Bouton scroll top --- */
        .gx-scroll-top-btn {
            position: fixed;
            right: 20px;
            bottom: 80px;
            z-index: 9999;
            display: none;
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
    </style>
</head>
<body>
    {{-- HEADER GoExploria Business --}}
    @include('cms::web.embed.partials.platform-header')

    {{-- HEADER EXTRAIT DU TEMPLATE (affiché en fixed dans le parent) --}}
    <div class="gx-extracted-header" id="gxExtractedHeader">
        <div class="gx-extracted-header-inner" id="gxExtractedHeaderInner">
            <!-- Le header du template sera extrait et affiché ici -->
        </div>
    </div>

    {{-- CONTENU DE L'ÉTABLISSEMENT (dans Shadow DOM) --}}
    <main class="gx-content-stage" id="gxContentStage">
        <div class="gx-content-loader" id="gxContentLoader">
            <span class="spinner" role="status" aria-hidden="true"></span>
            Chargement du site...
        </div>
        <div id="gxShadowContainer"></div>
    </main>

    {{-- FOOTER GoExploria Business --}}
    @include('cms::web.embed.partials.platform-footer')

    {{-- ÉLÉMENTS FLOTTANTS --}}
    @include('cms::web.fallback.partials.landing-contact-ajax')
    @include('cms::web.fallback.partials.landing-contact-widget')
    @include('cms::web.fallback.partials.landing-cart-drawer')
    @include('cms::web.fallback.partials.landing-back-to-top')

    {{-- Bouton Menu du site --}}
    <button type="button" class="gx-embed-menu" id="gxEmbedMenu" aria-label="Ouvrir le menu du site">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true">
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

    {{-- SCRIPT PRINCIPAL AVEC SHADOW DOM --}}
    <script>
    (function() {
        'use strict';

        var container = document.getElementById('gxShadowContainer');
        var loader = document.getElementById('gxContentLoader');
        var stage = document.getElementById('gxContentStage');
        var headerContainer = document.getElementById('gxExtractedHeader');
        var headerInner = document.getElementById('gxExtractedHeaderInner');
        var scrollBtn = document.getElementById('gxScrollTopBtn');
        var menuBtn = document.getElementById('gxEmbedMenu');

        if (!container) return;

        var url = '{{ route('cms.company.embed', ['etablissementId' => $etablissement->id]) }}';
        var shadowRoot = null;
        var isHeaderFixed = false;
        var headerHeight = 0;
        var templateStyles = [];

        // ── CRÉATION DU SHADOW DOM ──────────────────────────────────────
        function createShadowRoot() {
            if (container.shadowRoot) {
                shadowRoot = container.shadowRoot;
                shadowRoot.innerHTML = '';
            } else {
                shadowRoot = container.attachShadow({ mode: 'open' });
            }

            // Style par défaut pour le shadow DOM (réinitialisation)
            var resetStyle = document.createElement('style');
            resetStyle.textContent = `
                :host {
                    display: block;
                    width: 100%;
                    min-height: 200px;
                }
                /* Réinitialisation minimale */
                * {
                    box-sizing: border-box;
                }
                body {
                    margin: 0;
                    padding: 0;
                }
            `;
            shadowRoot.appendChild(resetStyle);

            return shadowRoot;
        }

        // ── CHARGEMENT DU CONTENU ──────────────────────────────────────
        function loadContent() {
            if (loader) loader.style.display = 'flex';
            container.innerHTML = '';

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Erreur de chargement');
                }
                return response.text();
            })
            .then(function(html) {
                if (loader) loader.style.display = 'none';

                // Créer le shadow root
                createShadowRoot();

                // Extraire le contenu
                var content = extractContent(html);
                
                // Extraire les styles du template
                var styles = extractStyles(html);
                templateStyles = styles;

                // Injecter les styles dans le shadow DOM
                styles.forEach(function(styleContent) {
                    var styleEl = document.createElement('style');
                    styleEl.textContent = styleContent;
                    shadowRoot.appendChild(styleEl);
                });

                // Injecter le contenu dans le shadow DOM
                var wrapper = document.createElement('div');
                wrapper.innerHTML = content;
                shadowRoot.appendChild(wrapper);

                // Extraire et afficher le header dans le parent
                extractAndDisplayHeader(wrapper);

                // Exécuter les scripts dans le shadow DOM
                executeScriptsInShadow(wrapper);

                // Initialiser les composants du template
                initializeTemplateInShadow();

                // Ajuster la hauteur
                adjustHeight();

                console.log('✅ Contenu chargé avec succès dans Shadow DOM');
            })
            .catch(function(error) {
                console.error('Erreur:', error);
                if (loader) {
                    loader.innerHTML = `
                        <span style="color:#dc2626;">❌</span>
                        <span>Erreur de chargement. <a href="${url}" target="_blank">Voir le site directement</a></span>
                    `;
                }
            });
        }

        // ── EXTRACTION DU CONTENU ──────────────────────────────────────
        function extractContent(html) {
            var match = html.match(/<body[^>]*>([\s\S]*?)<\/body>/i);
            if (match && match[1]) {
                return match[1];
            }
            return html;
        }

        // ── EXTRACTION DES STYLES ──────────────────────────────────────
        function extractStyles(html) {
            var styles = [];
            var regex = /<style[^>]*>([\s\S]*?)<\/style>/gi;
            var match;
            while ((match = regex.exec(html)) !== null) {
                styles.push(match[1]);
            }

            // Extraire aussi les link CSS
            var linkRegex = /<link[^>]*rel=["']stylesheet["'][^>]*href=["']([^"']+)["'][^>]*>/gi;
            while ((match = linkRegex.exec(html)) !== null) {
                var href = match[1];
                // On ne peut pas charger les liens CSS directement dans le shadow DOM
                // On les ignore ou on les charge via fetch
                styles.push('/* Link CSS ignoré: ' + href + ' */');
            }

            return styles;
        }

        // ── EXTRACTION ET AFFICHAGE DU HEADER ──────────────────────────
        function extractAndDisplayHeader(wrapper) {
            // Chercher le header dans le shadow DOM
            var header = wrapper.querySelector('header') || 
                        wrapper.querySelector('.header') || 
                        wrapper.querySelector('[role="banner"]') ||
                        wrapper.querySelector('#header');

            if (header) {
                // Cloner le header
                var clone = header.cloneNode(true);
                
                // Nettoyer les scripts
                var scripts = clone.querySelectorAll('script');
                scripts.forEach(function(script) {
                    script.remove();
                });

                // Nettoyer les attributs problématiques
                clone.style.position = 'relative';
                clone.style.top = 'auto';
                clone.style.left = 'auto';
                clone.style.right = 'auto';
                clone.style.bottom = 'auto';
                clone.style.width = '100%';
                clone.style.zIndex = 'auto';
                clone.style.transform = 'none';

                // Récupérer les styles calculés
                var computedStyle = window.getComputedStyle(header);
                var importantStyles = ['background', 'background-color', 'color', 'font-family', 
                                      'font-size', 'font-weight', 'padding', 'margin', 'display',
                                      'align-items', 'justify-content', 'flex-direction', 'flex-wrap',
                                      'border-bottom', 'box-shadow', 'height', 'min-height'];
                
                importantStyles.forEach(function(prop) {
                    var value = computedStyle[prop];
                    if (value && value !== 'none' && value !== 'normal' && value !== 'auto') {
                        clone.style[prop] = value;
                    }
                });

                // Mesurer la hauteur
                var rect = header.getBoundingClientRect();
                headerHeight = rect.height || 64;

                // Injecter dans le parent
                headerInner.innerHTML = '';
                headerInner.appendChild(clone);

                // Afficher le header
                headerContainer.style.display = 'block';
                headerContainer.style.top = (window.innerWidth <= 992 ? '80px' : '96px');
                
                // Mettre à jour le padding
                updatePadding(headerHeight);

                // Afficher avec animation
                requestAnimationFrame(function() {
                    headerContainer.classList.add('is-visible');
                    isHeaderFixed = true;
                    updateHeaderVisibility();
                });

                // Afficher le bouton de scroll
                if (scrollBtn) {
                    scrollBtn.classList.add('is-visible');
                }

                // Synchroniser les clics
                synchronizeClicks(clone);
            }
        }

        // ── SYNCHRONISATION DES CLICS ──────────────────────────────────
        function synchronizeClicks(clonedHeader) {
            var links = clonedHeader.querySelectorAll('a, button');
            links.forEach(function(el) {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Simuler le clic dans le shadow DOM
                    var target = findCorrespondingElementInShadow(el);
                    if (target && target.click) {
                        target.click();
                    }
                });
            });
        }

        function findCorrespondingElementInShadow(el) {
            if (!shadowRoot) return null;

            // Par ID
            if (el.id) {
                var found = shadowRoot.getElementById(el.id);
                if (found) return found;
            }

            // Par attribut data
            var dataAttrs = el.dataset;
            for (var key in dataAttrs) {
                var selector = '[data-' + key + '="' + dataAttrs[key] + '"]';
                var found = shadowRoot.querySelector(selector);
                if (found) return found;
            }

            // Par texte
            var text = el.textContent.trim();
            if (text) {
                var elements = shadowRoot.querySelectorAll('a, button');
                for (var i = 0; i < elements.length; i++) {
                    if (elements[i].textContent.trim() === text) {
                        return elements[i];
                    }
                }
            }

            return null;
        }

        // ── EXÉCUTION DES SCRIPTS DANS LE SHADOW DOM ───────────────────
        function executeScriptsInShadow(wrapper) {
            var scripts = wrapper.querySelectorAll('script');
            scripts.forEach(function(oldScript) {
                var newScript = document.createElement('script');
                
                // Copier les attributs
                Array.from(oldScript.attributes).forEach(function(attr) {
                    newScript.setAttribute(attr.name, attr.value);
                });
                
                // Copier le contenu
                if (oldScript.src) {
                    newScript.src = oldScript.src;
                    newScript.async = false;
                } else {
                    newScript.textContent = oldScript.textContent;
                }
                
                // Remplacer dans le shadow DOM
                oldScript.parentNode.replaceChild(newScript, oldScript);
            });
        }

        // ── INITIALISATION DES COMPOSANTS ──────────────────────────────
        function initializeTemplateInShadow() {
            // Réinitialiser les composants dans le shadow DOM
            setTimeout(function() {
                // Réinitialiser les swipers
                if (shadowRoot && typeof Swiper !== 'undefined') {
                    shadowRoot.querySelectorAll('.swiper-container, .swiper').forEach(function(el) {
                        if (el.swiper) {
                            el.swiper.destroy(true, true);
                        }
                        new Swiper(el, {
                            // Options
                        });
                    });
                }

                // Réinitialiser les menus mobiles
                if (shadowRoot) {
                    var menuToggles = shadowRoot.querySelectorAll('.menu-toggle, .navbar-toggler, .hamburger');
                    menuToggles.forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
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
                }

                // Déclencher l'événement pour les scripts qui en dépendent
                var event = new Event('DOMContentLoaded', { bubbles: true });
                if (shadowRoot) {
                    shadowRoot.dispatchEvent(event);
                }
                document.dispatchEvent(event);

            }, 100);
        }

        // ── GESTION DU PADDING ──────────────────────────────────────────
        function updatePadding(height) {
            var isMobile = window.innerWidth <= 992;
            var basePadding = isMobile ? 80 : 96;
            stage.style.paddingTop = (basePadding + height) + 'px';
            stage.classList.add('has-extracted-header');
        }

        // ── VISIBILITÉ DU HEADER ────────────────────────────────────────
        function updateHeaderVisibility() {
            if (!headerContainer || !isHeaderFixed) return;
            var seuil = headerHeight || 100;
            var shouldHide = window.scrollY < seuil;
            headerContainer.classList.toggle('is-hidden-at-top', shouldHide);
            
            if (scrollBtn) {
                scrollBtn.classList.toggle('is-visible', shouldHide && isHeaderFixed);
            }
        }

        // ── AJUSTEMENT DE LA HAUTEUR ────────────────────────────────────
        function adjustHeight() {
            if (!shadowRoot) return;
            var height = shadowRoot.host.scrollHeight || 200;
            stage.style.minHeight = (height + 100) + 'px';
        }

        // ── OBSERVER LES CHANGEMENTS ────────────────────────────────────
        function observeChanges() {
            if (!shadowRoot) return;

            // Observer les mutations dans le shadow DOM
            if (window.MutationObserver) {
                var observer = new MutationObserver(function() {
                    adjustHeight();
                });
                observer.observe(shadowRoot.host, {
                    childList: true,
                    subtree: true,
                    attributes: true
                });
            }

            // ResizeObserver
            if (window.ResizeObserver) {
                var ro = new ResizeObserver(function() {
                    adjustHeight();
                });
                ro.observe(container);
            }
        }

        // ── ÉVÉNEMENTS DE SCROLL ──────────────────────────────────────
        var scrollTimeout = null;
        window.addEventListener('scroll', function() {
            if (scrollTimeout) return;
            scrollTimeout = setTimeout(function() {
                updateHeaderVisibility();
                scrollTimeout = null;
            }, 50);
        }, { passive: true });

        // ── BOUTON MENU ──────────────────────────────────────────────────
        if (menuBtn) {
            menuBtn.addEventListener('click', function() {
                // Ouvrir le menu dans le shadow DOM
                if (shadowRoot) {
                    var menuToggle = shadowRoot.querySelector('.menu-toggle, .navbar-toggler, .hamburger');
                    if (menuToggle && menuToggle.click) {
                        menuToggle.click();
                    } else {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                }
            });

            var seuilMenu = 400;
            var majMenu = function() {
                menuBtn.classList.toggle('is-visible', window.scrollY > seuilMenu);
            };
            window.addEventListener('scroll', majMenu, { passive: true });
            majMenu();
        }

        // ── BOUTON SCROLL ──────────────────────────────────────────────────
        if (scrollBtn) {
            scrollBtn.addEventListener('click', function() {
                if (isHeaderFixed) {
                    var targetTop = headerContainer.getBoundingClientRect().top + window.scrollY;
                    window.scrollTo({ top: targetTop - 10, behavior: 'smooth' });
                }
            });
        }

        // ── RECALCUL AU REDIMENSIONNEMENT ──────────────────────────────
        var resizeTimeout = null;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                if (isHeaderFixed && headerContainer) {
                    var rect = headerContainer.getBoundingClientRect();
                    if (rect.height !== headerHeight) {
                        headerHeight = rect.height;
                        updatePadding(headerHeight);
                    }
                }
                
                if (headerContainer) {
                    var isMobile = window.innerWidth <= 992;
                    headerContainer.style.top = isMobile ? '80px' : '96px';
                }
                
                adjustHeight();
            }, 200);
        }, { passive: true });

        // ── INITIALISATION ──────────────────────────────────────────────
        loadContent();
        observeChanges();

        // ── RECHARGER SI L'URL CHANGE ──────────────────────────────────
        document.addEventListener('click', function(e) {
            var link = e.target.closest('a');
            if (link && link.href && link.href.indexOf(window.location.origin) === 0) {
                if (link.href !== window.location.href && link.target !== '_blank') {
                    e.preventDefault();
                    // Navigation SPA
                    window.history.pushState(null, '', link.href);
                    loadContent();
                }
            }
        });

    })();
    </script>
</body>
</html>