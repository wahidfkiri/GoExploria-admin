{{-- ═══════════════════════════════════════════════════════════════════════
     Annonces de l'établissement (produit, image, vidéo, HTML, texte).

     Rendu serveur des annonces diffusables — actives, dans la fenêtre de dates
     et sous leurs plafonds (scope live()). Positionnées (centre / bas-droite /
     bas-gauche), fermables, avec délai d'apparition et mémorisation de la
     fermeture (localStorage).

     Reprend les règles de campagne posées côté admin :
       · display_locations — l'annonce ne paraît que sur les contextes cochés.
         Passer $gxAnnouncementContext (« home », « city », « activities »…)
         pour activer ce filtre ; sans lui, toutes les annonces sont candidates.
       · frequency_cap — nombre d'affichages par visiteur et par jour, compté
         en localStorage (le serveur ne connaît pas les visiteurs anonymes).
       · priorité — les annonces les plus prioritaires sortent en premier.
       · impressions / clics — comptés via l'admin : un pixel pour l'affichage,
         une redirection pour le clic. C'est ce qui rend les plafonds effectifs.

     Nécessite $etablissement. À inclure une fois (@once).
     ═══════════════════════════════════════════════════════════════════════ --}}
@isset($etablissement)
@php
    $gxContext = $gxAnnouncementContext ?? null;

    try {
        $gxAnnouncements = \Vendor\Cms\Models\Announcement::where('etablissement_id', $etablissement->id)
            ->live()
            ->visibleOn($gxContext)
            ->ordered()
            ->limit(6)
            ->get();
    } catch (\Throwable $e) {
        $gxAnnouncements = collect();
    }

    // Base publique de l'admin : le suivi vit là-bas, le site ici.
    $gxAdmin = rtrim((string) config('ads.admin_url', ''), '/');

    // Résout l'URL d'un média (absolu tel quel, sinon /storage/…).
    $gxMediaUrl = function ($path) {
        $path = trim((string) $path);
        if ($path === '') return '';
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])) return $path;
        return asset('storage/' . ltrim($path, '/'));
    };

    // Embed vidéo (YouTube/Vimeo → iframe ; sinon <video>).
    $gxVideo = function ($url) {
        $url = trim((string) $url);
        if ($url === '') return '';
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $url, $m)) {
            return '<iframe src="https://www.youtube.com/embed/' . $m[1] . '?rel=0" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>';
        }
        if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/i', $url, $m)) {
            return '<iframe src="https://player.vimeo.com/video/' . $m[1] . '" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
        }
        return '<video src="' . e($url) . '" controls muted playsinline preload="metadata"></video>';
    };
@endphp

@if($gxAnnouncements->isNotEmpty())
@once
<style>
    .gxa-pop{position:fixed;z-index:99997;max-width:340px;width:calc(100% - 32px);background:#fff;border-radius:16px;box-shadow:0 24px 60px rgba(2,6,23,.28);overflow:hidden;font-family:inherit;opacity:0;visibility:hidden;transform:translateY(16px);transition:opacity .3s ease,transform .3s ease}
    .gxa-pop.is-open{opacity:1;visibility:visible;transform:none}
    .gxa-pop[data-position="bottom-right"]{right:20px;bottom:20px}
    .gxa-pop[data-position="bottom-left"]{left:20px;bottom:20px}
    .gxa-pop[data-position="center"]{left:50%;top:50%;transform:translate(-50%,calc(-50% + 16px));max-width:440px}
    .gxa-pop[data-position="center"].is-open{transform:translate(-50%,-50%)}
    .gxa-backdrop{position:fixed;inset:0;z-index:99996;background:rgba(2,6,23,.55);opacity:0;visibility:hidden;transition:opacity .3s}
    .gxa-backdrop.is-open{opacity:1;visibility:visible}
    .gxa-close{position:absolute;top:10px;right:10px;z-index:3;width:34px;height:34px;border:0;border-radius:50%;background:rgba(15,23,42,.55);color:#fff;font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center}
    .gxa-close:hover{background:rgba(15,23,42,.85)}
    .gxa-media{position:relative;background:#0f172a}
    .gxa-media img{width:100%;display:block;max-height:240px;object-fit:cover}
    .gxa-media .gxa-frame{position:relative;padding-top:56.25%}
    .gxa-media .gxa-frame iframe,.gxa-media .gxa-frame video{position:absolute;inset:0;width:100%;height:100%;border:0;object-fit:cover}
    .gxa-body{padding:16px 18px 18px}
    .gxa-title{font-size:17px;font-weight:800;color:#0f172a;margin:0 0 6px}
    .gxa-msg{font-size:14px;color:#64748b;line-height:1.55;margin:0}
    .gxa-text{font-size:14.5px;color:#334155;line-height:1.6;margin:0;white-space:pre-line}
    .gxa-html{font-size:14px;color:#334155;line-height:1.55}
    .gxa-price{font-size:20px;font-weight:800;color:#0284c7;margin:8px 0 0}
    .gxa-btn{display:inline-flex;align-items:center;gap:8px;margin-top:14px;padding:12px 20px;border-radius:999px;background:#0284c7;color:#fff;font-weight:700;font-size:14px;text-decoration:none;border:0;cursor:pointer}
    .gxa-btn:hover{background:#0369a1}
    .gxa-pixel{position:absolute;width:1px;height:1px;opacity:0;pointer-events:none}
    @media(max-width:520px){.gxa-pop[data-position]{left:50%;right:auto;bottom:16px;top:auto;transform:translateX(-50%) translateY(16px);max-width:calc(100% - 24px)}.gxa-pop[data-position].is-open{transform:translateX(-50%)}}
</style>
<div class="gxa-backdrop" data-gxa-backdrop></div>
@endonce

@foreach($gxAnnouncements as $a)
    @php
        $isCenter = $a->position === 'center';
        $prod = $a->productData();
        $mediaHtml = '';
        if ($a->type === 'image') {
            $src = $gxMediaUrl($a->media_url ?: ($prod['image'] ?? ''));
            if ($src) $mediaHtml = '<div class="gxa-media"><img src="' . e($src) . '" alt="' . e($a->title) . '"></div>';
        } elseif ($a->type === 'video') {
            $mediaHtml = '<div class="gxa-media"><div class="gxa-frame">' . $gxVideo($a->video_url ?: $a->media_url) . '</div></div>';
        } elseif ($a->type === 'product' && $prod) {
            $pimg = $gxMediaUrl($prod['image'] ?? '');
            if ($pimg) $mediaHtml = '<div class="gxa-media"><img src="' . e($pimg) . '" alt="' . e($prod['name']) . '"></div>';
        }

        // Le clic passe par l'admin, qui compte puis redirige : sans ce détour
        // le plafond de clics ne serait jamais atteint.
        $lien = $a->link_url;
        if ($lien && $gxAdmin !== '') {
            $lien = $gxAdmin . '/announcements/track/click/' . $a->id;
        }
    @endphp
    <div class="gxa-pop" data-gxa data-id="{{ $a->id }}" data-position="{{ $a->position }}"
         data-center="{{ $isCenter ? '1' : '0' }}" data-delay="{{ (int) $a->display_delay }}"
         data-cap="{{ (int) $a->frequency_cap }}"
         @if($gxAdmin !== '') data-pixel="{{ $gxAdmin }}/announcements/track/impression/{{ $a->id }}" @endif
         role="dialog" aria-label="Annonce">
        @if($a->dismissible)
            <button class="gxa-close" data-gxa-close aria-label="Fermer">&times;</button>
        @endif
        {!! $mediaHtml !!}
        <div class="gxa-body">
            @if($a->type === 'product' && $prod)
                <h3 class="gxa-title">{{ $a->title ?: $prod['name'] }}</h3>
                @if($a->message)<p class="gxa-msg">{{ $a->message }}</p>@endif
                @if(!is_null($prod['price']))<div class="gxa-price">{{ number_format((float) $prod['price'], 2, ',', ' ') }} $</div>@endif
                <button class="gxa-btn" type="button"
                    data-cms-cart-add
                    data-product-id="{{ $prod['id'] }}"
                    data-product-name="{{ e($prod['name']) }}"
                    data-product-price="{{ $prod['price'] }}"
                    data-product-image="{{ e($gxMediaUrl($prod['image'] ?? '')) }}"
                    data-product-url="#"
                    data-etablissement-id="{{ $etablissement->id }}"
                    data-etablissement-name="{{ e($etablissement->name ?? '') }}">
                    <i class="fa-solid fa-cart-plus"></i> {{ $a->button_label ?: 'Ajouter au panier' }}
                </button>
            @else
                @if($a->title)<h3 class="gxa-title">{{ $a->title }}</h3>@endif
                @if($a->message)<p class="gxa-msg">{{ $a->message }}</p>@endif

                @if($a->type === 'text' && $a->text_content)
                    <p class="gxa-text">{{ $a->text_content }}</p>
                @elseif($a->type === 'html' && $a->html_content)
                    {{-- Contenu saisi par le gestionnaire de l'établissement dans
                         son propre espace : rendu tel quel, comme un bloc CMS. --}}
                    <div class="gxa-html">{!! $a->html_content !!}</div>
                @endif

                @if($lien)
                    <a class="gxa-btn" href="{{ $lien }}"
                       @if($a->open_new_tab) target="_blank" rel="noopener" @endif>
                        {{ $a->button_label ?: 'Découvrir' }} <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @endif
            @endif
        </div>
    </div>
@endforeach

@once
<script>
(function () {
    var backdrop = document.querySelector('[data-gxa-backdrop]');
    function key(id) { return 'gxa_dismissed_' + id; }
    function capKey(id) { return 'gxa_seen_' + id + '_' + new Date().toISOString().slice(0, 10); }

    document.querySelectorAll('[data-gxa]').forEach(function (pop) {
        var id = pop.dataset.id;

        // Ne pas réafficher une annonce déjà fermée.
        try { if (localStorage.getItem(key(id))) { pop.remove(); return; } } catch (e) {}

        // Plafond par visiteur et par jour : le serveur ne peut pas le tenir
        // pour des visiteurs anonymes, on le compte donc ici.
        var cap = parseInt(pop.dataset.cap, 10) || 0;
        if (cap > 0) {
            var vues = 0;
            try { vues = parseInt(localStorage.getItem(capKey(id)), 10) || 0; } catch (e) {}
            if (vues >= cap) { pop.remove(); return; }
        }

        var isCenter = pop.dataset.center === '1';
        var delay = (parseInt(pop.dataset.delay, 10) || 0) * 1000;

        function compterImpression() {
            if (cap > 0) {
                try { localStorage.setItem(capKey(id), String((parseInt(localStorage.getItem(capKey(id)), 10) || 0) + 1)); } catch (e) {}
            }
            // Pixel plutôt que fetch : traverse les domaines sans CORS.
            if (pop.dataset.pixel) {
                var px = new Image();
                px.className = 'gxa-pixel';
                px.src = pop.dataset.pixel + '?t=' + Date.now();
            }
        }

        function open() {
            pop.classList.add('is-open');
            if (isCenter && backdrop) { backdrop.classList.add('is-open'); }
            compterImpression();
        }
        function close() {
            pop.classList.remove('is-open');
            if (isCenter && backdrop && !document.querySelector('.gxa-pop[data-center="1"].is-open')) {
                backdrop.classList.remove('is-open');
            }
            try { localStorage.setItem(key(id), '1'); } catch (e) {}
            setTimeout(function () { pop.remove(); }, 350);
        }

        var closeBtn = pop.querySelector('[data-gxa-close]');
        if (closeBtn) { closeBtn.addEventListener('click', close); }
        // Le clic sur le fond ferme les popups centrées.
        if (isCenter && backdrop) {
            backdrop.addEventListener('click', function () {
                document.querySelectorAll('.gxa-pop[data-center="1"] [data-gxa-close]').forEach(function (b) { b.click(); });
            });
        }
        setTimeout(open, delay);
    });
})();
</script>
@endonce
@endif
@endisset
