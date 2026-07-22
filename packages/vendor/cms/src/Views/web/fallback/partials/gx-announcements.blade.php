{{-- ═══════════════════════════════════════════════════════════════════════
     Annonces / popups de l'établissement (produit, image, vidéo).
     Rendu serveur des annonces « live » (actives + dans la fenêtre de dates),
     positionnées (centre / bas-droite / bas-gauche), fermables, avec délai
     d'apparition et mémorisation de la fermeture (localStorage).
     Nécessite $etablissement. À inclure une fois (@once).
     ═══════════════════════════════════════════════════════════════════════ --}}
@isset($etablissement)
@php
    try {
        $gxAnnouncements = \Vendor\Cms\Models\Announcement::where('etablissement_id', $etablissement->id)
            ->live()->ordered()->limit(6)->get();
    } catch (\Throwable $e) {
        $gxAnnouncements = collect();
    }

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
    .gxa-price{font-size:20px;font-weight:800;color:#0284c7;margin:8px 0 0}
    .gxa-btn{display:inline-flex;align-items:center;gap:8px;margin-top:14px;padding:12px 20px;border-radius:999px;background:#0284c7;color:#fff;font-weight:700;font-size:14px;text-decoration:none;border:0;cursor:pointer}
    .gxa-btn:hover{background:#0369a1}
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
    @endphp
    <div class="gxa-pop" data-gxa data-id="{{ $a->id }}" data-position="{{ $a->position }}"
         data-center="{{ $isCenter ? '1' : '0' }}" data-delay="{{ (int) $a->display_delay }}" role="dialog" aria-label="Annonce">
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
                @if($a->link_url)
                    <a class="gxa-btn" href="{{ $a->link_url }}" target="_blank" rel="noopener">
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

    document.querySelectorAll('[data-gxa]').forEach(function (pop) {
        var id = pop.dataset.id;
        // Ne pas réafficher une annonce déjà fermée.
        try { if (localStorage.getItem(key(id))) { pop.remove(); return; } } catch (e) {}

        var isCenter = pop.dataset.center === '1';
        var delay = (parseInt(pop.dataset.delay, 10) || 0) * 1000;

        function open() {
            pop.classList.add('is-open');
            if (isCenter && backdrop) { backdrop.classList.add('is-open'); }
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
