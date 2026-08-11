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

    {{-- ── FOOTER GoExploria Business (dédié) ─────────────────────────── --}}
    @include('cms::web.embed.partials.platform-footer')

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
        });

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
