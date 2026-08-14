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
    </style>
</head>
<body>
    {{-- ── HEADER GoExploria Business (dédié) ─────────────────────────── --}}
    @include('cms::web.embed.partials.platform-header')

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
        if (!frame) return;
        var selfOrigin = window.location.origin;

        function applyHeight(h) {
            if (!h || h < 1) return;
            frame.style.height = h + 'px';
            stage.classList.add('is-ready');
        }

        // Réception de la hauteur mesurée par l'enfant (child-bridge).
        window.addEventListener('message', function (e) {
            // On n'accepte QUE les messages same-origin de notre iframe.
            if (e.origin !== selfOrigin) return;
            if (e.source !== frame.contentWindow) return;
            var data = e.data || {};
            if (data.channel !== CHANNEL) return;
            if (data.type === 'height') applyHeight(data.height);
            // L'enfant demande à remonter en haut : son en-tête y est, et
            // c'est là que son panneau de menu s'ouvre.
            if (data.type === 'scroll-top') {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
            if (data.type === 'request-viewport') envoyerBandeVisible();
            // Une modale s'ouvre dans l'iframe : elle doit suivre le
            // défilement de CETTE page, seule à en avoir un.
            if (data.type === 'overlay-open') suivreBandeVisible(true);
            if (data.type === 'overlay-close') suivreBandeVisible(false);
        });

        /* ── Bande visible de l'iframe ────────────────────────────────────
           L'iframe est haute comme son contenu et ne défile pas : son enfant
           ne peut donc pas savoir ce que le visiteur a réellement sous les
           yeux. On le lui dit — décalage depuis le haut de l'iframe, et
           hauteur visible — pour qu'il y place ses modales. */
        function envoyerBandeVisible() {
            var boite = frame.getBoundingClientRect();
            var hauteurEcran = window.innerHeight || document.documentElement.clientHeight;

            // Intersection entre l'iframe et l'écran, exprimée dans le repère
            // de l'iframe.
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

        /* Le site vit dans une iframe, et un z-index posé DANS un document
           iframé ne peut pas en sortir : l'iframe est un seul élément dans
           l'empilement de cette page. `.gx-embed-stage` la maintient
           volontairement sous le header plateforme (z-index: 0) — sauf
           pendant une modale, qui doit couvrir toute la page. On élève donc
           l'étage entier, au-dessus du plus haut z-index du chrome
           plateforme (le méga-menu mobile monte à 9999999). */
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

                /* Verrou de défilement — c'est CETTE page qui défile, pas
                   l'iframe. Sans lui, le visiteur peut faire sortir le site de
                   l'écran alors que sa modale est ouverte : elle n'aurait plus
                   de bande visible où se poser. C'est aussi le comportement
                   attendu d'une modale. La barre de défilement disparaissant,
                   on compense sa largeur pour éviter un sursaut de la mise en
                   page. */
                var barre = window.innerWidth - document.documentElement.clientWidth;
                defilementAvant = {
                    overflow: document.body.style.overflow,
                    paddingRight: document.body.style.paddingRight
                };
                document.body.style.overflow = 'hidden';
                if (barre > 0) { document.body.style.paddingRight = barre + 'px'; }

                // Filet de sécurité : certains navigateurs mobiles laissent
                // passer un défilement élastique malgré le verrou.
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

        /* ── Bouton « Menu du site » ──────────────────────────────────────
           L'en-tête de l'établissement est DANS l'iframe, laquelle n'a pas de
           défilement propre : son position:fixed se cale sur la boîte de
           l'iframe et sort de l'écran dès qu'on défile. Ce bouton-ci, lui,
           est dans le document qui défile — il tient. Il demande à l'iframe
           d'ouvrir son propre menu (voir partials/child-bridge). */
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

            // Visible seulement une fois qu'on a quitté le haut de page : en
            // haut, l'en-tête du site est là, le bouton ferait double emploi.
            var seuil = 400;
            var maj = function () {
                boutonMenu.classList.toggle('is-visible', window.scrollY > seuil);
            };
            window.addEventListener('scroll', maj, { passive: true });
            maj();
        }

        // Demander un recalcul quand la largeur du parent change (responsive :
        // le reflow interne du template modifie sa hauteur).
        var rt;
        window.addEventListener('resize', function () {
            clearTimeout(rt);
            rt = setTimeout(function () {
                try {
                    frame.contentWindow.postMessage(
                        { channel: CHANNEL, type: 'request-height' }, selfOrigin
                    );
                } catch (err) { /* silencieux */ }
            }, 200);
        }, { passive: true });

        // Filet de sécurité : si aucun message n'arrive (JS enfant bloqué),
        // on tente une mesure directe (possible car same-origin) au load.
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
