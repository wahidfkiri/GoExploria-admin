{{-- ═══════════════════════════════════════════════════════════════════════
     SHELL PLATEFORME — Affiche le site d'un établissement DANS GoExploria
     Business, isolé dans une iframe same-origin, entre le Header et le
     Footer GoExploria dédiés.

        ┌─────────────────────────────────────────┐
        │ HEADER GoExploria Business (document parent)
        ├─────────────────────────────────────────┤
        │ <iframe> → site établissement (document isolé)
        │     ├── HTML / CSS / JS / CDN / plugins
        │     └── header + menu mobile PROPRES au template
        ├─────────────────────────────────────────┤
        │ FOOTER GoExploria Business (document parent)
        └─────────────────────────────────────────┘

     Isolation : l'iframe crée un document séparé → aucun CSS/JS/DOM du
     template ne peut atteindre le header/footer/menu de la plateforme, et
     inversement. Les versions de Bootstrap/jQuery/Swiper/etc. du template
     n'entrent jamais en conflit avec celles de GoExploria.

     Hauteur : jamais fixe. Le contenu de l'iframe mesure sa hauteur et la
     transmet par postMessage (cf. partials/child-bridge) ; ce shell adapte
     l'iframe en conséquence. Fonctionne desktop ET mobile.

     Nécessite : $etablissement
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

    {{-- Assets de la plateforme (identiques à cms::layouts.app) pour que le
         Header/Footer GoExploria aient exactement le même rendu que sur `/`. --}}
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
        /* ——— Réinitialisation minimale du shell (n'affecte PAS l'iframe) ——— */
        html, body { margin: 0; padding: 0; }
        body {
            background: #ffffff;
            /* La police globale reste celle de la plateforme (styles.css). */
            overflow-x: hidden;
        }

        /* Zone du site établissement : occupe toute la largeur, sous le header
           fixe de la plateforme. Le padding-top compense le header sticky
           (~96px desktop, ~80px mobile) comme le font les pages `/company`. */
        .gx-embed-stage {
            width: 100%;
            padding-top: 96px;
            box-sizing: border-box;
            /* Contexte d'empilement bas : le header/menu plateforme (z-index
               élevés) passent TOUJOURS au-dessus de l'iframe. */
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
            /* Hauteur initiale avant la 1re mesure ; remplacée par le pont JS. */
            height: 100vh;
            /* Le scroll est porté par la page parente (hauteur = contenu). */
            overflow: hidden;
            background: #ffffff;
        }

        /* Voile de chargement le temps que l'iframe et la 1re mesure arrivent. */
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

        /* ── HEADER FIXE DU CONTENU (reçu de l'iframe) ────────────────────
           Ce header est affiché par le parent pour simuler un header fixe
           alors que le contenu réel est dans l'iframe. Il reçoit le HTML du
           header de l'établissement via postMessage. */
        .gx-content-header {
            position: fixed;
            top: 96px; /* Sous le header GoExploria */
            left: 0;
            right: 0;
            z-index: 9998;
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transform: translateY(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
            /* Le contenu HTML sera injecté ici */
        }
        @media (max-width: 992px) {
            .gx-content-header {
                top: 80px;
            }
        }
        .gx-content-header.is-visible {
            transform: translateY(0);
        }
        /* Animation d'entrée plus douce */
        .gx-content-header.is-visible {
            animation: gxHeaderSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @keyframes gxHeaderSlideIn {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        /* Cache le header fixe quand on est en haut de page (le header du contenu
           est visible dans l'iframe) */
        .gx-content-header.is-hidden-at-top {
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
        }

        /* ── CONTENEUR POUR LE HEADER FIXE (reçu de l'iframe) ──────────── */
        .gx-content-header-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Ajustement pour les écrans très larges */
        @media (min-width: 1400px) {
            .gx-content-header-inner {
                padding: 0 40px;
            }
        }

        /* ── BOUTON POUR REVENIR AU HEADER DU CONTENU ──────────────────── */
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

        /* ——— Bouton « Menu du site » (mobile) ———————————————————————
           L'en-tête de l'établissement vit DANS l'iframe, en position:fixed.
           Or l'iframe n'a pas de défilement propre : sa hauteur suit le
           contenu, et c'est cette page qui défile. Un position:fixed à
           l'intérieur se cale donc sur la boîte de l'iframe — l'en-tête reste
           en haut du document et sort de l'écran dès qu'on défile. Mesuré :
           le burger passe à −1 397 px après 1 500 px de défilement, et le
           menu du template devient inatteignable.

           Aucune règle CSS écrite dans l'iframe ne peut corriger cela : seul
           un élément de CE document peut se caler sur l'écran. D'où ce
           bouton, qui demande à l'iframe d'ouvrir son propre menu. */
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
        /* Uniquement sur mobile — au-dessus de 1024 px les templates montrent
           leur navigation complète, il n'y a pas de menu à ouvrir. */
        @media (max-width: 1024px) {
            .gx-embed-menu { display: inline-flex; }
        }
        /* Et seulement une fois qu'on a défilé : en haut de page, l'en-tête du
           site est visible, le bouton ferait double emploi. */
        .gx-embed-menu.is-visible {
            opacity: 1;
            pointer-events: auto;
            transform: none;
        }
        .gx-embed-menu:hover { background: #1f2937; }

        /* Ajustement pour éviter que le header fixe du contenu ne cache
           le contenu de l'iframe */
        .gx-embed-stage.has-content-header {
            padding-top: 160px; /* Ajuster selon la hauteur du header du contenu */
        }
        @media (max-width: 992px) {
            .gx-embed-stage.has-content-header {
                padding-top: 140px;
            }
        }
    </style>
</head>
<body>
    {{-- ── HEADER GoExploria Business (dédié) ─────────────────────────── --}}
    @include('cms::web.embed.partials.platform-header')

    {{-- ── HEADER FIXE DU CONTENU (injecté par l'iframe) ──────────────── --}}
    <div class="gx-content-header" id="gxContentHeader" style="display:none;">
        <div class="gx-content-header-inner" id="gxContentHeaderInner">
            <!-- Le HTML du header de l'établissement sera injecté ici -->
        </div>
    </div>

    {{-- ── SITE DE L'ÉTABLISSEMENT (isolé en iframe) ──────────────────── --}}
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

    {{-- Bouton « Menu du site » : voir le commentaire de .gx-embed-menu. --}}
    <button type="button" class="gx-embed-menu" id="gxEmbedMenu" aria-label="Ouvrir le menu du site">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true">
            <path d="M4 7h16M4 12h16M4 17h16"/>
        </svg>
        Menu du site
    </button>

    {{-- ── FOOTER GoExploria Business (dédié) ─────────────────────────── --}}
    @include('cms::web.embed.partials.platform-footer')

    {{-- ── ÉLÉMENTS FLOTTANTS ─────────────────────────────────────────────
         Contact, panier et retour-en-haut vivent ICI, dans le document
         parent, et non dans l'iframe.

         Raison : l'iframe n'a pas de défilement propre (scrolling="no", sa
         hauteur suit le contenu) ; c'est cette page qui défile. Un
         `position: fixed` À L'INTÉRIEUR se cale donc sur la boîte de
         l'iframe et reste collé au fond du document au lieu de suivre le
         visiteur. Rendus ici, ils se calent sur l'écran comme prévu.

         Le PANIER partage son état avec l'iframe par localStorage : le
         template ajoute au panier depuis l'iframe, l'événement `storage`
         prévient ce document, et le compteur se met à jour. C'est le
         mécanisme que le partial utilise déjà pour synchroniser plusieurs
         onglets — un parent et son iframe sont deux documents de même
         origine, il fonctionne à l'identique.

         Le paiement redirige désormais la page ENTIÈRE et non l'iframe. --}}
    @include('cms::web.fallback.partials.landing-contact-ajax')
    @include('cms::web.fallback.partials.landing-contact-widget')
    @include('cms::web.fallback.partials.landing-cart-drawer')
    @include('cms::web.fallback.partials.landing-back-to-top')

    {{-- Bouton pour remonter au header du contenu (uniquement quand le header fixe est affiché) --}}
    <button type="button" class="gx-content-header-scroll-btn" id="gxContentHeaderScrollBtn" aria-label="Remonter au menu">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 19V5M5 12l7-7 7 7"/>
        </svg>
    </button>

    {{-- ── Assets JS de la plateforme (header/menu/footer) ────────────── --}}
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

    {{-- ── PONT PARENT ↔ IFRAME (hauteur dynamique) ───────────────────── --}}
    <script>
    (function () {
        var CHANNEL = 'gx-embed';
        var stage = document.getElementById('gxEmbedStage');
        var frame = document.getElementById('gxEmbedFrame');
        var headerContainer = document.getElementById('gxContentHeader');
        var headerInner = document.getElementById('gxContentHeaderInner');
        var scrollBtn = document.getElementById('gxContentHeaderScrollBtn');
        if (!frame) return;
        var selfOrigin = window.location.origin;
        var headerHeight = 0;
        var isHeaderFixed = false;

        function applyHeight(h) {
            if (!h || h < 1) return;
            frame.style.height = h + 'px';
            stage.classList.add('is-ready');
        }

        // ── Réception des messages de l'iframe ──────────────────────────
        window.addEventListener('message', function (e) {
            // On n'accepte QUE les messages same-origin de notre iframe.
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

                case 'request-viewport':
                    envoyerBandeVisible();
                    break;

                case 'overlay-open':
                    suivreBandeVisible(true);
                    break;

                case 'overlay-close':
                    suivreBandeVisible(false);
                    break;

                // ── NOUVEAU : Recevoir le header du contenu ──────────────
                case 'header-fixed':
                    if (data.html) {
                        afficherHeaderFixe(data.html, data.height || 64);
                    }
                    break;

                case 'header-unfix':
                    cacherHeaderFixe();
                    break;

                case 'header-toggle':
                    // Demande de bascule manuelle (ex: clic sur un bouton dans l'iframe)
                    if (isHeaderFixed) {
                        cacherHeaderFixe();
                    } else {
                        // L'iframe doit envoyer le HTML à ce moment
                        frame.contentWindow.postMessage(
                            { channel: CHANNEL, type: 'request-header' }, selfOrigin
                        );
                    }
                    break;
            }
        });

        // ── GESTION DU HEADER FIXE ───────────────────────────────────────
        function afficherHeaderFixe(html, hauteur) {
            if (!headerContainer || !headerInner) return;
            
            // Injecter le HTML du header
            headerInner.innerHTML = html;
            headerContainer.style.display = 'block';
            
            // Mesurer la hauteur réelle
            var rect = headerContainer.getBoundingClientRect();
            headerHeight = rect.height || hauteur || 64;
            
            // Appliquer le padding-top au stage pour compenser
            var currentPadding = parseInt(stage.style.paddingTop) || 96;
            stage.style.paddingTop = (currentPadding + headerHeight) + 'px';
            stage.classList.add('has-content-header');
            
            // Afficher avec animation
            requestAnimationFrame(function() {
                headerContainer.classList.add('is-visible');
                // Masquer en haut de page
                majHeaderVisibility();
                isHeaderFixed = true;
            });
            
            // Afficher le bouton de scroll
            if (scrollBtn) {
                scrollBtn.classList.add('is-visible');
            }
            
            // Notifier l'iframe que le header est affiché
            try {
                frame.contentWindow.postMessage({
                    channel: CHANNEL,
                    type: 'header-displayed',
                    height: headerHeight
                }, selfOrigin);
            } catch (err) { /* silencieux */ }
        }

        function cacherHeaderFixe() {
            if (!headerContainer) return;
            headerContainer.classList.remove('is-visible');
            headerContainer.style.display = 'none';
            stage.classList.remove('has-content-header');
            
            // Restaurer le padding-top original
            var isMobile = window.innerWidth <= 992;
            stage.style.paddingTop = isMobile ? '80px' : '96px';
            
            if (scrollBtn) {
                scrollBtn.classList.remove('is-visible');
            }
            
            isHeaderFixed = false;
            
            // Notifier l'iframe
            try {
                frame.contentWindow.postMessage({
                    channel: CHANNEL,
                    type: 'header-hidden'
                }, selfOrigin);
            } catch (err) { /* silencieux */ }
        }

        function majHeaderVisibility() {
            if (!headerContainer || !isHeaderFixed) return;
            var seuil = 100; // Seuil en pixels
            var shouldHide = window.scrollY < seuil;
            headerContainer.classList.toggle('is-hidden-at-top', shouldHide);
            
            // Le bouton de scroll est visible seulement quand le header est caché
            if (scrollBtn) {
                scrollBtn.classList.toggle('is-visible', shouldHide && isHeaderFixed);
            }
        }

        // ── BANDE VISIBLE DE L'IFRAME ────────────────────────────────────
        function envoyerBandeVisible() {
            var boite = frame.getBoundingClientRect();
            var hauteurEcran = window.innerHeight || document.documentElement.clientHeight;

            var debut = Math.max(0, -boite.top);
            var fin = Math.min(boite.height, hauteurEcran - boite.top);

            try {
                frame.contentWindow.postMessage({
                    channel: CHANNEL,
                    type: 'viewport',
                    offset: debut,
                    height: Math.max(0, fin - debut)
                }, selfOrigin);
            } catch (err) { /* silencieux */ }
        }

        var suiviBande = null;
        var defilementAvant = null;
        var zIndexAvant = null;
        var Z_MODALE = '10000001';

        function suivreBandeVisible(actif) {
            var scene = document.getElementById('gxEmbedStage');

            if (actif) {
                envoyerBandeVisible();
                if (suiviBande) return;

                if (scene) {
                    zIndexAvant = scene.style.zIndex;
                    scene.style.zIndex = Z_MODALE;
                }

                var barre = window.innerWidth - document.documentElement.clientWidth;
                defilementAvant = {
                    overflow: document.body.style.overflow,
                    paddingRight: document.body.style.paddingRight
                };
                document.body.style.overflow = 'hidden';
                if (barre > 0) { document.body.style.paddingRight = barre + 'px'; }

                suiviBande = function () { envoyerBandeVisible(); };
                window.addEventListener('scroll', suiviBande, { passive: true });
                window.addEventListener('resize', suiviBande, { passive: true });
                return;
            }

            if (scene && zIndexAvant !== null) {
                scene.style.zIndex = zIndexAvant;
                zIndexAvant = null;
            }

            if (defilementAvant) {
                document.body.style.overflow = defilementAvant.overflow;
                document.body.style.paddingRight = defilementAvant.paddingRight;
                defilementAvant = null;
            }

            if (!suiviBande) return;
            window.removeEventListener('scroll', suiviBande);
            window.removeEventListener('resize', suiviBande);
            suiviBande = null;
        }

        // ── BOUTON « Menu du site » ──────────────────────────────────────
        var boutonMenu = document.getElementById('gxEmbedMenu');
        if (boutonMenu) {
            boutonMenu.addEventListener('click', function () {
                try {
                    frame.contentWindow.postMessage(
                        { channel: CHANNEL, type: 'open-menu' }, selfOrigin
                    );
                } catch (err) {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });

            var seuilMenu = 400;
            var majMenu = function () {
                boutonMenu.classList.toggle('is-visible', window.scrollY > seuilMenu);
            };
            window.addEventListener('scroll', majMenu, { passive: true });
            majMenu();
        }

        // ── BOUTON DE SCROLL VERS LE HEADER ──────────────────────────────
        if (scrollBtn) {
            scrollBtn.addEventListener('click', function () {
                if (isHeaderFixed) {
                    // Faire défiler jusqu'en haut du header fixe
                    var targetTop = headerContainer.getBoundingClientRect().top + window.scrollY;
                    window.scrollTo({ top: targetTop - 10, behavior: 'smooth' });
                } else {
                    // Si le header n'est pas fixe, demander à l'iframe de scroller
                    try {
                        frame.contentWindow.postMessage(
                            { channel: CHANNEL, type: 'scroll-top' }, selfOrigin
                        );
                    } catch (err) {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                }
            });
        }

        // ── GESTION DU SCROLL POUR LE HEADER ─────────────────────────────
        var majHeaderDebounce = null;
        window.addEventListener('scroll', function () {
            if (majHeaderDebounce) return;
            majHeaderDebounce = setTimeout(function() {
                majHeaderVisibility();
                majHeaderDebounce = null;
            }, 50);
        }, { passive: true });

        // ── RECALCUL DE LA HAUTEUR ──────────────────────────────────────
        var rt;
        window.addEventListener('resize', function () {
            clearTimeout(rt);
            rt = setTimeout(function () {
                // Recalculer la hauteur du header fixe si présent
                if (isHeaderFixed && headerContainer) {
                    var rect = headerContainer.getBoundingClientRect();
                    if (rect.height !== headerHeight) {
                        headerHeight = rect.height;
                        var isMobile = window.innerWidth <= 992;
                        var basePadding = isMobile ? 80 : 96;
                        stage.style.paddingTop = (basePadding + headerHeight) + 'px';
                    }
                }
                
                try {
                    frame.contentWindow.postMessage(
                        { channel: CHANNEL, type: 'request-height' }, selfOrigin
                    );
                } catch (err) { /* silencieux */ }
            }, 200);
        }, { passive: true });

        // ── FILET DE SÉCURITÉ ────────────────────────────────────────────
        frame.addEventListener('load', function () {
            setTimeout(function () {
                if (stage.classList.contains('is-ready')) return;
                try {
                    var doc = frame.contentDocument || frame.contentWindow.document;
                    var h = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight);
                    applyHeight(h);
                } catch (err) { /* cross-origin ou bloqué : on garde 100vh */ }
            }, 400);
        });
    })();
    </script>
</body>
</html>