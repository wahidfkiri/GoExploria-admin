{{-- ═══════════════════════════════════════════════════════════════════════
     Carrousel d'annonces en cards horizontales (Ads Manager).

     Rendu CÔTÉ SERVEUR depuis la base PARTAGÉE (zone « cards_below_map ») :
       • ~5 cards visibles, défilement AUTOMATIQUE + scrollbar horizontale ;
       • responsive (moins de cards sur mobile) ;
       • image / vidéo / html / texte ;
       • tracking best-effort (impression + clic) vers l'admin ;
       • Swiper auto-chargé si absent.

     Images : stockées côté admin (storage séparé) => URL ABSOLUE vers l'admin.
     À inclure sous la carte : @include('components.ads-cards')
     ═══════════════════════════════════════════════════════════════════════ --}}
@if(config('ads.cards_enabled', true))
@php
    $gxcAdminUrl = rtrim(config('ads.admin_url'), '/');
    $gxcZone     = config('ads.cards_zone', 'cards_below_map');
    $gxcAutoplay = max(1, (int) config('ads.cards_autoplay', 4)) * 1000;

    try {
        $gxcToday     = now()->toDateString();
        $gxcPlacement = \Illuminate\Support\Facades\DB::table('ad_placements')
            ->where('code', $gxcZone)->where('is_active', true)->first();

        $gxcAds = collect();
        if ($gxcPlacement) {
            $gxcAds = \Illuminate\Support\Facades\DB::table('ads')
                ->join('ad_placement', 'ads.id', '=', 'ad_placement.ad_id')
                ->where('ad_placement.placement_id', $gxcPlacement->id)
                ->where('ad_placement.is_active', true)
                ->where('ads.status', 'active')
                ->where(fn ($q) => $q->whereNull('ads.start_date')->orWhere('ads.start_date', '<=', $gxcToday))
                ->where(fn ($q) => $q->whereNull('ads.end_date')->orWhere('ads.end_date', '>=', $gxcToday))
                ->where(fn ($q) => $q->whereNull('ads.budget_total')->orWhereRaw('ads.budget_total > ads.budget_spent'))
                ->select('ads.*')
                ->orderBy('ads.priority')
                ->limit(($gxcPlacement->max_ads ?: 24))
                ->get();
        }
    } catch (\Throwable $e) {
        $gxcAds = collect();
    }

    $gxcImg = function (?string $path) use ($gxcAdminUrl) {
        $path = trim((string) $path);
        if ($path === '') return '';
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])) return $path;
        return $gxcAdminUrl . '/storage/' . ltrim($path, '/');
    };
    $gxcVideo = function (?string $url) {
        $url = trim((string) $url);
        if ($url === '') return '';
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $url, $m)) {
            return '<div class="gxcad-frame"><iframe src="https://www.youtube.com/embed/' . $m[1] . '?rel=0&mute=1" allow="encrypted-media" allowfullscreen></iframe></div>';
        }
        if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/i', $url, $m)) {
            return '<div class="gxcad-frame"><iframe src="https://player.vimeo.com/video/' . $m[1] . '" allow="fullscreen" allowfullscreen></iframe></div>';
        }
        return '<div class="gxcad-frame"><video src="' . e($url) . '" muted playsinline preload="metadata" controls></video></div>';
    };
@endphp

@if($gxcAds->isNotEmpty())
<section id="gx-ads-cards" class="gxcad-section" aria-label="Annonces partenaires"
         data-admin="{{ $gxcAdminUrl }}" data-autoplay="{{ $gxcAutoplay }}">
    <style>
        .gxcad-section{width:100%;max-width:1440px;margin:8px auto 28px;padding:0 clamp(12px,2.4vw,32px);box-sizing:border-box}
        .gxcad-head{display:flex;align-items:center;gap:8px;margin:0 0 12px}
        .gxcad-head h3{font-size:clamp(16px,2vw,20px);font-weight:800;color:#0f172a;margin:0}
        .gxcad-head .gxcad-tag{font-size:10px;font-weight:700;letter-spacing:.05em;text-transform:uppercase;color:#0284c7;background:#e0f2fe;border-radius:6px;padding:3px 8px}
        #gx-ads-cards .swiper{padding-bottom:22px}
        #gx-ads-cards .gxcad-card{display:block;text-decoration:none;color:inherit;background:#fff;border:1px solid #e5e9f0;border-radius:14px;overflow:hidden;box-shadow:0 4px 14px rgba(2,6,23,.06);height:100%;transition:transform .2s,box-shadow .2s}
        #gx-ads-cards .gxcad-card:hover{transform:translateY(-3px);box-shadow:0 12px 26px rgba(2,6,23,.14)}
        #gx-ads-cards .gxcad-media{position:relative;background:#0f172a;aspect-ratio:16/10;overflow:hidden}
        #gx-ads-cards .gxcad-media img{width:100%;height:100%;object-fit:cover;display:block}
        #gx-ads-cards .gxcad-frame{position:relative;width:100%;height:100%}
        #gx-ads-cards .gxcad-frame iframe,#gx-ads-cards .gxcad-frame video{position:absolute;inset:0;width:100%;height:100%;border:0;object-fit:cover}
        #gx-ads-cards .gxcad-badge{position:absolute;top:8px;left:8px;font-size:9px;font-weight:700;text-transform:uppercase;color:#fff;background:rgba(15,23,42,.55);border-radius:5px;padding:2px 6px}
        #gx-ads-cards .gxcad-body{padding:10px 12px 12px}
        #gx-ads-cards .gxcad-title{font-size:14px;font-weight:700;color:#0f172a;margin:0 0 3px;line-height:1.3;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        #gx-ads-cards .gxcad-desc{font-size:12px;color:#64748b;line-height:1.45;margin:0;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        #gx-ads-cards .gxcad-html{padding:10px 12px;font-size:12px;color:#0f172a}
        #gx-ads-cards .swiper-scrollbar{background:rgba(2,6,23,.08);height:6px}
        #gx-ads-cards .swiper-scrollbar-drag{background:#0284c7}
        #gx-ads-cards .gxcad-arrow{width:34px;height:34px;border-radius:50%;border:1px solid #e5e9f0;background:#fff;color:#0f172a;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 3px 10px rgba(2,6,23,.1)}
        #gx-ads-cards .gxcad-arrow:hover{background:#0284c7;color:#fff}
        #gx-ads-cards .gxcad-arrow.swiper-button-disabled{opacity:.4;cursor:default}
        #gx-ads-cards .gxcad-arrows{display:flex;gap:8px;margin-left:auto}
    </style>

    <div class="gxcad-head">
        <span class="gxcad-tag">Annonces</span>
        <h3>À la une</h3>
        <div class="gxcad-arrows">
            <button class="gxcad-arrow gxcad-prev" type="button" aria-label="Précédent"><i class="fas fa-chevron-left"></i></button>
            <button class="gxcad-arrow gxcad-next" type="button" aria-label="Suivant"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>

    <div class="swiper gxcad-swiper">
        <div class="swiper-wrapper">
            @foreach($gxcAds as $ad)
                @php
                    $dest = trim((string) $ad->destination_url);
                    $newTab = (int) $ad->open_new_tab === 1;
                    $trackClick = $gxcAdminUrl . '/ads/track/click/' . $ad->id;
                    $trackImp   = $gxcAdminUrl . '/ads/track/impression/' . $ad->id;
                    $openTag = $dest !== ''
                        ? '<a class="gxcad-card" href="' . e($dest) . '"' . ($newTab ? ' target="_blank" rel="noopener"' : '') . ' data-gxcad-click="' . e($trackClick) . '">'
                        : '<div class="gxcad-card">';
                    $closeTag = $dest !== '' ? '</a>' : '</div>';
                    $typeLabel = ['video' => 'Vidéo', 'image' => 'Sponsorisé', 'text' => 'Info', 'html' => 'Sponsorisé'][$ad->type] ?? 'Sponsorisé';
                @endphp
                <div class="swiper-slide" data-gxcad-imp="{{ e($trackImp) }}">
                    {!! $openTag !!}
                    @if($ad->type === 'video')
                        <div class="gxcad-media"><span class="gxcad-badge">{{ $typeLabel }}</span>{!! $gxcVideo($ad->video_url ?: $ad->destination_url) !!}</div>
                        <div class="gxcad-body"><h4 class="gxcad-title">{{ $ad->titre }}</h4></div>
                    @elseif($ad->type === 'html' && $ad->html_content)
                        <div class="gxcad-html">{!! $ad->html_content !!}</div>
                    @elseif($ad->type === 'text')
                        <div class="gxcad-body">
                            <span class="gxcad-badge" style="position:static;display:inline-block;margin-bottom:6px;background:#e0f2fe;color:#0284c7">{{ $typeLabel }}</span>
                            <h4 class="gxcad-title">{{ $ad->titre }}</h4>
                            @if($ad->text_content)<p class="gxcad-desc">{{ $ad->text_content }}</p>@endif
                        </div>
                    @else
                        @php $img = $gxcImg($ad->image_path); @endphp
                        <div class="gxcad-media">
                            <span class="gxcad-badge">{{ $typeLabel }}</span>
                            @if($img)<img src="{{ $img }}" alt="{{ $ad->titre }}" loading="lazy">@endif
                        </div>
                        <div class="gxcad-body">
                            <h4 class="gxcad-title">{{ $ad->titre }}</h4>
                            @if($ad->description)<p class="gxcad-desc">{{ $ad->description }}</p>@endif
                        </div>
                    @endif
                    {!! $closeTag !!}
                </div>
            @endforeach
        </div>
        <div class="swiper-scrollbar"></div>
    </div>
</section>

<script>
(function () {
    var sec = document.getElementById('gx-ads-cards');
    if (!sec) return;
    var autoplay = parseInt(sec.getAttribute('data-autoplay'), 10) || 4000;
    var slides = sec.querySelectorAll('.swiper-slide');

    function fireImpression(slide) {
        if (!slide || slide._seen) return;
        slide._seen = true;
        var url = slide.getAttribute('data-gxcad-imp');
        if (!url) return;
        try {
            var sep = url.indexOf('?') === -1 ? '?' : '&';
            var px = new Image(); px.src = url + sep + 'url=' + encodeURIComponent(location.href) + '&_=' + Date.now();
        } catch (e) {}
    }

    // Clic tracké sans bloquer la navigation.
    sec.querySelectorAll('[data-gxcad-click]').forEach(function (a) {
        a.addEventListener('click', function () {
            var url = a.getAttribute('data-gxcad-click');
            if (!url) return;
            try {
                if (navigator.sendBeacon) { navigator.sendBeacon(url); }
                else { var px = new Image(); px.src = url + (url.indexOf('?') === -1 ? '?' : '&') + '_=' + Date.now(); }
            } catch (e) {}
        });
    });

    function ensureSwiper(cb) {
        if (typeof window.Swiper !== 'undefined') { return cb(); }
        if (!document.querySelector('link[data-gxad-swiper]')) {
            var l = document.createElement('link');
            l.rel = 'stylesheet'; l.setAttribute('data-gxad-swiper', '1');
            l.href = 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css';
            document.head.appendChild(l);
        }
        var s = document.createElement('script');
        s.src = 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js';
        s.onload = cb; s.onerror = cb;
        document.head.appendChild(s);
    }

    ensureSwiper(function () {
        if (typeof window.Swiper === 'undefined') { fireImpression(slides[0]); return; }
        var count = slides.length;
        new Swiper(sec.querySelector('.gxcad-swiper'), {
            slidesPerView: 1.15,
            spaceBetween: 14,
            grabCursor: true,
            loop: count > 5,
            autoplay: count > 1 ? { delay: autoplay, disableOnInteraction: false, pauseOnMouseEnter: true } : false,
            scrollbar: { el: sec.querySelector('.swiper-scrollbar'), draggable: true },
            navigation: { prevEl: sec.querySelector('.gxcad-prev'), nextEl: sec.querySelector('.gxcad-next') },
            breakpoints: {
                480:  { slidesPerView: 2,    spaceBetween: 14 },
                768:  { slidesPerView: 3,    spaceBetween: 16 },
                1024: { slidesPerView: 4,    spaceBetween: 18 },
                1280: { slidesPerView: 5,    spaceBetween: 18 }
            },
            on: {
                init: function () { fireImpression(slides[this.activeIndex] || slides[0]); },
                slideChange: function () { fireImpression(slides[this.activeIndex]); }
            }
        });
    });
})();
</script>
@endif
@endif
