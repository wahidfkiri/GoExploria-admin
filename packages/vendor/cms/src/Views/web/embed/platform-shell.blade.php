{{-- ═══════════════════════════════════════════════════════════════════════
     SHELL PLATEFORME — Affiche le site d'un établissement DANS GoExploria
     Business, isolé dans une iframe same-origin.
     
     SOLUTION AUTOMATIQUE : Détecte le header du template dans l'iframe
     et le clone pour l'afficher en position:fixed dans le parent.
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
        /* ——— Réinitialisation ——— */
        html, body { margin: 0; padding: 0; }
        body {
            background: #ffffff;
            overflow-x: hidden;
        }

        /* Zone du site établissement */
        .gx-embed-stage {
            width: 100%;
            padding-top: 96px;
            box-sizing: border-box;
            position: relative;
            z-index: 0;
        }
        @media (max-width: 992px) {
            .gx-embed-stage { padding-top: 80px; }
        }

        .gx-embed-frame {
            display: block;
            width: 100%;
            border: 0;
            margin: 0;
            height: 100vh;
            overflow: hidden;
            background: #ffffff;
        }

        /* Voile de chargement */
        .gx-embed-loading {
            position: absolute;
            inset: 96px 0 auto 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 48px 16px;
            color: #6b7280;
            font-family: Montserrat, system-ui, sans-serif;
            font-size: 14px;
        }
        .gx-embed-spinner {
            width: 22px; height: 22px; border-radius: 50%;
            border: 3px solid #e5e7eb; border-top-color: #16794c;
            animation: gxspin .8s linear infinite;
        }
        @keyframes gxspin { to { transform: rotate(360deg); } }
        .gx-embed-stage.is-ready .gx-embed-loading { display: none; }

        /* ── HEADER FIXE DU CONTENU (cloné depuis l'iframe) ────────────── */
        .gx-content-header {
            position: fixed;
            top: 96px;
            left: 0;
            right: 0;
            z-index: 9998;
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transform: translateY(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
            display: none;
            max-height: 80vh;
            overflow-y: auto;
        }
        @media (max-width: 992px) {
            .gx-content-header {
                top: 80px;
            }
        }
        .gx-content-header.is-visible {
            transform: translateY(0);
            display: block;
        }
        .gx-content-header.is-hidden-at-top {
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
        }

        .gx-content-header-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ── BOUTON « Menu du site » (mobile) ──────────────────────────── */
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

        /* Ajustement du padding quand le header fixe est affiché */
        .gx-embed-stage.has-content-header {
            padding-top: 160px;
        }
        @media (max-width: 992px) {
            .gx-embed-stage.has-content-header {
                padding-top: 140px;
            }
        }

        /* Bouton pour remonter */
        .gx-content-header-scroll-btn {
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
            .gx-content-header-scroll-btn { bottom: 140px; }
        }
        .gx-content-header-scroll-btn.is-visible {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }
        .gx-content-header-scroll-btn:hover {
            background: #0f5d3a;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    {{-- ── HEADER GoExploria Business ─────────────────────────────────── --}}
    @include('cms::web.embed.partials.platform-header')

    {{-- ── HEADER FIXE DU CONTENU (cloné depuis l'iframe) ─────────────── ──}}
    <div class="gx-content-header" id="gxContentHeader">
        <div class="gx-content-header-inner" id="gxContentHeaderInner">
            <!-- Le header de l'établissement sera cloné ici automatiquement -->
        </div>
    </div>

    {{-- ── SITE DE L'ÉTABLISSEMENT ─────────────────────────────────────── ──}}
    <main class="gx-embed-stage" id="gxEmbedStage">
        <div class="gx-embed-loading" aria-live="polite">
            <span class="gx-embed-spinner" role="status" aria-hidden="true"></span>
            Chargement du site…
        </div>
        <iframe
            id="gxEmbedFrame"
            class="gx-embed-frame"
            src="{{ route('cms.company.embed', ['etablissementId' => $etablissement->id]) }}"
            title="Site de {{ $etablissement->name }}"
            scrolling="no"
            loading="eager"
            referrerpolicy="same-origin"
            allow="autoplay; fullscreen; picture-in-picture; encrypted-media; clipboard-write"
            sandbox="allow-scripts allow-forms allow-popups allow-same-origin allow-popups-to-escape-sandbox allow-modals allow-downloads">
        </iframe>
    </main>

    {{-- Bouton « Menu du site » --}}
    <button type="button" class="gx-embed-menu" id="gxEmbedMenu" aria-label="Ouvrir le menu du site">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true">
            <path d="M4 7h16M4 12h16M4 17h16"/>
        </svg>
        Menu du site
    </button>

    {{-- ── FOOTER GoExploria Business ─────────────────────────────────── ──}}
    @include('cms::web.embed.partials.platform-footer')

    {{-- ── ÉLÉMENTS FLOTTANTS ──────────────────────────────────────────── ──}}
    @include('cms::web.fallback.partials.landing-contact-ajax')
    @include('cms::web.fallback.partials.landing-contact-widget')
    @include('cms::web.fallback.partials.landing-cart-drawer')
    @include('cms::web.fallback.partials.landing-back-to-top')

    {{-- Bouton pour remonter --}}
    <button type="button" class="gx-content-header-scroll-btn" id="gxContentHeaderScrollBtn" aria-label="Remonter au menu">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 19V5M5 12l7-7 7 7"/>
        </svg>
    </button>

    {{-- ── Assets JS de la plateforme ─────────────────────────────────── ──}}
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

    {{-- ── SCRIPT PRINCIPAL : Détection automatique du header ─────────── ──}}
    <script>
    (function() {
        'use strict';

        var CHANNEL = 'gx-embed';
        var frame = document.getElementById('gxEmbedFrame');
        var stage = document.getElementById('gxEmbedStage');
        var headerContainer = document.getElementById('gxContentHeader');
        var headerInner = document.getElementById('gxContentHeaderInner');
        var scrollBtn = document.getElementById('gxContentHeaderScrollBtn');
        
        if (!frame) return;

        var selfOrigin = window.location.origin;
        var isHeaderFixed = false;
        var headerHeight = 0;
        var detectionInterval = null;
        var isDetecting = false;

        // ── FONCTIONS PRINCIPALES ───────────────────────────────────────

        function applyHeight(h) {
            if (!h || h < 1) return;
            frame.style.height = h + 'px';
            stage.classList.add('is-ready');
        }

        // ── DÉTECTION AUTOMATIQUE DU HEADER DANS L'IFRAME ──────────────
        function detectAndCloneHeader() {
            if (isDetecting) return;
            isDetecting = true;

            try {
                var doc = frame.contentDocument || frame.contentWindow.document;
                if (!doc || !doc.body) {
                    isDetecting = false;
                    return;
                }

                // Chercher le header dans l'iframe
                var header = findHeaderInDocument(doc);
                
                if (header) {
                    // Vérifier si c'est un header fixe ou sticky
                    var style = frame.contentWindow.getComputedStyle(header);
                    var isFixed = style.position === 'fixed' || style.position === 'sticky';
                    
                    // Ou vérifier par les classes
                    var hasFixedClass = header.classList.contains('fixed') || 
                                       header.classList.contains('sticky') ||
                                       header.classList.contains('header-fixed') ||
                                       header.classList.contains('fixed-header') ||
                                       header.classList.contains('sticky-header');

                    if (isFixed || hasFixedClass) {
                        cloneHeaderToParent(header, doc);
                        isDetecting = false;
                        return;
                    }
                }

                // Si on a trouvé un header mais pas fixe, on le clone quand même
                // mais on ne l'affiche que quand on défile
                if (header) {
                    cloneHeaderToParent(header, doc);
                    isDetecting = false;
                    return;
                }

                isDetecting = false;

            } catch (err) {
                // Erreur de cross-origin ou autre
                console.log('Erreur de détection:', err);
                isDetecting = false;
            }
        }

        function findHeaderInDocument(doc) {
            // Liste des sélecteurs possibles pour trouver le header
            var selectors = [
                'header.header-fixed',
                'header.sticky-header',
                'header.fixed-top',
                'header.sticky-top',
                'header[class*="fixed"]',
                'header[class*="sticky"]',
                '.header-fixed',
                '.sticky-header',
                '.fixed-header',
                '.sticky-header',
                'header:first-of-type',
                '.header:first-of-type',
                '[role="banner"]',
                '#header',
                '#main-header',
                '#site-header'
            ];

            for (var i = 0; i < selectors.length; i++) {
                var el = doc.querySelector(selectors[i]);
                if (el) return el;
            }

            // Fallback: chercher n'importe quel header
            var headers = doc.querySelectorAll('header');
            if (headers.length > 0) return headers[0];

            return null;
        }

        function cloneHeaderToParent(header, doc) {
            try {
                // Cloner le header
                var clone = header.cloneNode(true);
                
                // Nettoyer les scripts
                var scripts = clone.querySelectorAll('script');
                scripts.forEach(function(script) {
                    script.remove();
                });

                // Nettoyer les attributs de style problématiques
                clone.style.position = 'relative';
                clone.style.top = 'auto';
                clone.style.left = 'auto';
                clone.style.right = 'auto';
                clone.style.bottom = 'auto';
                clone.style.width = '100%';
                clone.style.zIndex = 'auto';
                
                // Récupérer les styles calculés pour les conserver
                var computedStyle = frame.contentWindow.getComputedStyle(header);
                var importantStyles = ['background', 'background-color', 'color', 'font-family', 
                                      'font-size', 'font-weight', 'padding', 'margin', 'display',
                                      'align-items', 'justify-content', 'flex-direction', 'flex-wrap',
                                      'border-bottom', 'box-shadow'];
                
                importantStyles.forEach(function(prop) {
                    var value = computedStyle[prop];
                    if (value && value !== 'none' && value !== 'normal') {
                        clone.style[prop] = value;
                    }
                });

                // Mesurer la hauteur réelle
                var rect = header.getBoundingClientRect();
                var height = rect.height || 64;

                // Injecter dans le parent
                headerInner.innerHTML = '';
                headerInner.appendChild(clone);
                
                // Afficher le header
                headerContainer.style.display = 'block';
                headerContainer.style.top = (window.innerWidth <= 992 ? '80px' : '96px');
                
                // Mettre à jour la hauteur
                headerHeight = height;
                updatePadding(height);
                
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

                // Arrêter la détection
                if (detectionInterval) {
                    clearInterval(detectionInterval);
                    detectionInterval = null;
                }

                // Synchroniser les clics sur les liens
                synchronizeClicks(clone);

            } catch (err) {
                console.log('Erreur de clonage:', err);
            }
        }

        function synchronizeClicks(clonedHeader) {
            // Pour les liens et boutons du header cloné, rediriger vers l'iframe
            var links = clonedHeader.querySelectorAll('a, button');
            links.forEach(function(el) {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Essayer de cliquer sur l'élément correspondant dans l'iframe
                    try {
                        var doc = frame.contentDocument || frame.contentWindow.document;
                        var target = findCorrespondingElement(el, doc);
                        if (target && target.click) {
                            target.click();
                        }
                    } catch (err) {
                        // Si on ne trouve pas, on scrolle en haut
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                });
            });
        }

        function findCorrespondingElement(el, doc) {
            // Essayer de trouver par ID
            if (el.id) {
                var found = doc.getElementById(el.id);
                if (found) return found;
            }
            
            // Essayer par attribut data
            var dataAttrs = el.dataset;
            for (var key in dataAttrs) {
                var selector = '[data-' + key + '="' + dataAttrs[key] + '"]';
                var found = doc.querySelector(selector);
                if (found) return found;
            }
            
            // Essayer par texte
            var text = el.textContent.trim();
            if (text) {
                var elements = doc.querySelectorAll('a, button');
                for (var i = 0; i < elements.length; i++) {
                    if (elements[i].textContent.trim() === text) {
                        return elements[i];
                    }
                }
            }
            
            return null;
        }

        // ── GESTION DU PADDING ──────────────────────────────────────────
        function updatePadding(height) {
            var isMobile = window.innerWidth <= 992;
            var basePadding = isMobile ? 80 : 96;
            stage.style.paddingTop = (basePadding + height) + 'px';
            stage.classList.add('has-content-header');
        }

        // ── VISIBILITÉ DU HEADER FIXE ──────────────────────────────────
        function updateHeaderVisibility() {
            if (!headerContainer || !isHeaderFixed) return;
            var seuil = headerHeight || 100;
            var shouldHide = window.scrollY < seuil;
            headerContainer.classList.toggle('is-hidden-at-top', shouldHide);
            
            if (scrollBtn) {
                scrollBtn.classList.toggle('is-visible', shouldHide && isHeaderFixed);
            }
        }

        // ── RÉCEPTION DES MESSAGES DE L'IFRAME ─────────────────────────
        window.addEventListener('message', function(e) {
            if (e.origin !== selfOrigin) return;
            if (e.source !== frame.contentWindow) return;
            var data = e.data || {};
            if (data.channel !== CHANNEL) return;

            switch (data.type) {
                case 'height':
                    applyHeight(data.height);
                    break;

                case 'scroll-top':
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    break;

                case 'open-menu':
                    // Essayer d'ouvrir le menu dans l'iframe
                    try {
                        var doc = frame.contentDocument || frame.contentWindow.document;
                        var menuBtn = doc.querySelector('.menu-toggle, .navbar-toggler, .hamburger, [aria-label="Menu"]');
                        if (menuBtn && menuBtn.click) {
                            menuBtn.click();
                        } else {
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                    } catch (err) {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                    break;
            }
        });

        // ── BOUTON MENU ──────────────────────────────────────────────────
        var boutonMenu = document.getElementById('gxEmbedMenu');
        if (boutonMenu) {
            boutonMenu.addEventListener('click', function() {
                try {
                    frame.contentWindow.postMessage(
                        { channel: CHANNEL, type: 'open-menu' }, selfOrigin
                    );
                } catch (err) {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });

            var seuilMenu = 400;
            var majMenu = function() {
                boutonMenu.classList.toggle('is-visible', window.scrollY > seuilMenu);
            };
            window.addEventListener('scroll', majMenu, { passive: true });
            majMenu();
        }

        // ── BOUTON SCROLL ───────────────────────────────────────────────
        if (scrollBtn) {
            scrollBtn.addEventListener('click', function() {
                if (isHeaderFixed) {
                    var targetTop = headerContainer.getBoundingClientRect().top + window.scrollY;
                    window.scrollTo({ top: targetTop - 10, behavior: 'smooth' });
                }
            });
        }

        // ── ÉVÉNEMENTS DE SCROLL ───────────────────────────────────────
        var scrollTimeout = null;
        window.addEventListener('scroll', function() {
            if (scrollTimeout) return;
            scrollTimeout = setTimeout(function() {
                updateHeaderVisibility();
                scrollTimeout = null;
            }, 50);
        }, { passive: true });

        // ── DÉTECTION AUTOMATIQUE ──────────────────────────────────────
        function startDetection() {
            // Détection immédiate
            setTimeout(function() {
                detectAndCloneHeader();
            }, 500);

            // Détection périodique (pour les templates qui chargent tard)
            var attempts = 0;
            detectionInterval = setInterval(function() {
                attempts++;
                if (isHeaderFixed || attempts > 20) {
                    clearInterval(detectionInterval);
                    detectionInterval = null;
                    return;
                }
                detectAndCloneHeader();
            }, 1000);

            // Détection au chargement de l'iframe
            frame.addEventListener('load', function() {
                setTimeout(function() {
                    detectAndCloneHeader();
                }, 300);
            });
        }

        // ── INITIALISATION ─────────────────────────────────────────────
        startDetection();

        // ── RECALCUL AU REDIMENSIONNEMENT ─────────────────────────────
        var resizeTimeout = null;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                // Recalculer la hauteur du header si présent
                if (isHeaderFixed && headerContainer) {
                    var rect = headerContainer.getBoundingClientRect();
                    if (rect.height !== headerHeight) {
                        headerHeight = rect.height;
                        updatePadding(headerHeight);
                    }
                }
                
                // Mettre à jour la position du header
                if (headerContainer) {
                    var isMobile = window.innerWidth <= 992;
                    headerContainer.style.top = isMobile ? '80px' : '96px';
                }
            }, 200);
        }, { passive: true });

    })();
    </script>
</body>
</html>