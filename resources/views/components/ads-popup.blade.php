{{-- ═══════════════════════════════════════════════════════════════════════
     Popup publicitaire rotatif (Ads Manager) — bas à droite.

     Rendu CÔTÉ SERVEUR : les annonces de la zone « popup_bottom_right » sont
     lues directement dans la base PARTAGÉE (tables ads / ad_placements), donc
     le popup s'affiche SANS dépendre d'un second serveur (admin) ni de CORS.

       • carrousel Swiper, rotation auto, durée PAR annonce (slide_duration) ;
       • bouton fermeture haut-droite + mémorisation (localStorage) ;
       • image / vidéo / html / texte ;
       • tracking best-effort (impression pixel + clic beacon) vers l'admin ;
       • clic → destination directe (n'exige pas l'admin en ligne).

     Images : stockées côté admin (storage séparé) => URL ABSOLUE vers l'admin.
     À inclure une fois par page : @include('components.ads-popup')
     ═══════════════════════════════════════════════════════════════════════ --}}
@if(config('ads.popup_enabled', true))
@php
    $gxAdsAdminUrl = rtrim(config('ads.admin_url'), '/');
    $gxAdsZone     = config('ads.popup_zone', 'popup_bottom_right');
    $gxAdsDefault  = (int) config('ads.popup_default_duration', 5);
    // Contexte de page (home, city, activities…) : filtre display_locations.
    $gxCtx = ($adContext ?? null) === 'ville' ? 'city' : ($adContext ?? null);

    try {
        $gxToday     = now()->toDateString();
        $gxPlacement = \Illuminate\Support\Facades\DB::table('ad_placements')
            ->where('code', $gxAdsZone)->where('is_active', true)->first();

        $gxAds = collect();
        if ($gxPlacement) {
            $gxAds = \Illuminate\Support\Facades\DB::table('ads')
                ->join('ad_placement', 'ads.id', '=', 'ad_placement.ad_id')
                ->where('ad_placement.placement_id', $gxPlacement->id)
                ->where('ad_placement.is_active', true)
                ->where('ads.status', 'active')
                ->where(fn ($q) => $q->whereNull('ads.start_date')->orWhere('ads.start_date', '<=', $gxToday))
                ->where(fn ($q) => $q->whereNull('ads.end_date')->orWhere('ads.end_date', '>=', $gxToday))
                ->where(fn ($q) => $q->whereNull('ads.budget_total')->orWhereRaw('ads.budget_total > ads.budget_spent'))
                ->when($gxCtx, fn ($q) => $q->where(fn ($w) => $w
                    ->whereNull('ads.display_locations')
                    ->orWhereRaw('JSON_LENGTH(ads.display_locations) = 0')
                    ->orWhereJsonContains('ads.display_locations', $gxCtx)))
                ->select('ads.*')
                ->orderBy('ads.priority')
                ->limit(($gxPlacement->max_ads ?: 8))
                ->get();
        }
    } catch (\Throwable $e) {
        $gxAds = collect();
    }

    // URL absolue d'une image stockée côté admin (storages front/admin distincts).
    $gxAdsImg = function (?string $path) use ($gxAdsAdminUrl) {
        $path = trim((string) $path);
        if ($path === '') return '';
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])) return $path;
        return $gxAdsAdminUrl . '/storage/' . ltrim($path, '/');
    };

    // Embed vidéo : YouTube/Vimeo => iframe ; sinon <video>.
    $gxAdsVideo = function (?string $url) {
        $url = trim((string) $url);
        if ($url === '') return '';
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $url, $m)) {
            return '<div class="gxad-frame"><iframe src="https://www.youtube.com/embed/' . $m[1] . '?rel=0&mute=1" allow="encrypted-media" allowfullscreen></iframe></div>';
        }
        if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/i', $url, $m)) {
            return '<div class="gxad-frame"><iframe src="https://player.vimeo.com/video/' . $m[1] . '" allow="fullscreen" allowfullscreen></iframe></div>';
        }
        return '<div class="gxad-frame"><video src="' . e($url) . '" muted playsinline preload="metadata" controls></video></div>';
    };
@endphp

@if($gxAds->isNotEmpty())
<style>
    #gx-ads-popup{position:fixed;right:20px;bottom:20px;z-index:99990;width:320px;max-width:calc(100vw - 32px);background:#fff;border-radius:16px;box-shadow:0 24px 60px rgba(2,6,23,.30);overflow:hidden;opacity:0;visibility:hidden;transform:translateY(18px);transition:opacity .35s ease,transform .35s ease}
    #gx-ads-popup.is-open{opacity:1;visibility:visible;transform:none}
    #gx-ads-popup .gxad-close{position:absolute;top:8px;right:8px;z-index:6;width:30px;height:30px;border:0;border-radius:50%;background:rgba(15,23,42,.55);color:#fff;font-size:15px;line-height:1;cursor:pointer;display:flex;align-items:center;justify-content:center}
    #gx-ads-popup .gxad-close:hover{background:rgba(15,23,42,.85)}
    #gx-ads-popup .gxad-label{position:absolute;top:8px;left:10px;z-index:5;font-size:10px;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:#fff;background:rgba(15,23,42,.45);border-radius:6px;padding:2px 7px}
    #gx-ads-popup .swiper{width:100%}
    #gx-ads-popup .gxad-slide{display:block;text-decoration:none;color:inherit;background:#0f172a}
    #gx-ads-popup .gxad-media{position:relative;width:100%;background:#0f172a}
    #gx-ads-popup .gxad-media img{width:100%;display:block;max-height:230px;object-fit:cover}
    #gx-ads-popup .gxad-frame{position:relative;padding-top:56.25%}
    #gx-ads-popup .gxad-frame iframe,#gx-ads-popup .gxad-frame video{position:absolute;inset:0;width:100%;height:100%;border:0;object-fit:cover}
    #gx-ads-popup .gxad-body{padding:12px 14px 14px;background:#fff}
    #gx-ads-popup .gxad-title{font-size:15px;font-weight:800;color:#0f172a;margin:0 0 4px;line-height:1.3}
    #gx-ads-popup .gxad-desc{font-size:13px;color:#64748b;line-height:1.5;margin:0}
    #gx-ads-popup .gxad-html{padding:12px 14px;background:#fff;font-size:13px;color:#0f172a}
    #gx-ads-popup .gxad-cta{display:inline-flex;align-items:center;gap:6px;margin-top:10px;padding:8px 16px;border-radius:999px;background:#0284c7;color:#fff;font-weight:700;font-size:13px;text-decoration:none}
    #gx-ads-popup .swiper-pagination{position:static;margin-top:8px;padding-bottom:10px}
    #gx-ads-popup .swiper-pagination-bullet-active{background:#0284c7}
    /* Flèches de navigation manuelle (annonce précédente / suivante) */
    #gx-ads-popup .gxad-nav{position:absolute;top:50%;transform:translateY(-50%);z-index:5;width:32px;height:32px;border:0;border-radius:50%;background:rgba(15,23,42,.5);color:#fff;font-size:14px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s}
    #gx-ads-popup .gxad-nav:hover{background:rgba(2,132,199,.9)}
    #gx-ads-popup .gxad-prev{left:8px}
    #gx-ads-popup .gxad-next{right:8px}
    #gx-ads-popup .gxad-nav.swiper-button-disabled{opacity:.35;cursor:default}
    @media(max-width:420px){#gx-ads-popup{right:12px;left:12px;bottom:12px;width:auto}}
</style>

<div id="gx-ads-popup" role="complementary" aria-label="Annonce"
     data-admin="{{ $gxAdsAdminUrl }}" data-dismiss-hours="{{ (int) config('ads.popup_dismiss_hours', 12) }}"
     data-zone="{{ $gxAdsZone }}">
    <span class="gxad-label">Annonce</span>
    <button class="gxad-close" type="button" aria-label="Fermer">&times;</button>
    <div class="swiper gxad-swiper">
        <div class="swiper-wrapper">
            @foreach($gxAds as $ad)
                @php
                    $dur = max(1, (int) ($ad->slide_duration ?: $gxAdsDefault)) * 1000;
                    $dest = trim((string) $ad->destination_url);
                    $newTab = (int) $ad->open_new_tab === 1;
                    $trackClick = $gxAdsAdminUrl . '/ads/track/click/' . $ad->id;
                    $trackImp   = $gxAdsAdminUrl . '/ads/track/impression/' . $ad->id;
                    $openTag = $dest !== ''
                        ? '<a class="gxad-slide" href="' . e($dest) . '"' . ($newTab ? ' target="_blank" rel="noopener"' : '') . ' data-gxad-click="' . e($trackClick) . '">'
                        : '<div class="gxad-slide">';
                    $closeTag = $dest !== '' ? '</a>' : '</div>';
                @endphp
                <div class="swiper-slide" data-swiper-autoplay="{{ $dur }}" data-gxad-imp="{{ e($trackImp) }}">
                    {!! $openTag !!}
                    @if($ad->type === 'video')
                        <div class="gxad-media">{!! $gxAdsVideo($ad->video_url ?: $ad->destination_url) !!}</div>
                        <div class="gxad-body"><h3 class="gxad-title">{{ $ad->titre }}</h3></div>
                    @elseif($ad->type === 'html' && $ad->html_content)
                        <div class="gxad-html">{!! $ad->html_content !!}</div>
                    @elseif($ad->type === 'text')
                        <div class="gxad-body">
                            <h3 class="gxad-title">{{ $ad->titre }}</h3>
                            @if($ad->text_content)<p class="gxad-desc">{{ $ad->text_content }}</p>@endif
                            @if($dest !== '')<span class="gxad-cta">En savoir plus <i class="fas fa-arrow-right"></i></span>@endif
                        </div>
                    @else
                        @php $img = $gxAdsImg($ad->image_path); @endphp
                        @if($img)<div class="gxad-media"><img src="{{ $img }}" alt="{{ $ad->titre }}" loading="lazy"></div>@endif
                        <div class="gxad-body">
                            <h3 class="gxad-title">{{ $ad->titre }}</h3>
                            @if($dest !== '')<span class="gxad-cta">Découvrir <i class="fas fa-arrow-right"></i></span>@endif
                        </div>
                    @endif
                    {!! $closeTag !!}
                </div>
            @endforeach
        </div>
        @if($gxAds->count() > 1)
            <div class="swiper-pagination"></div>
            <button class="gxad-nav gxad-prev" type="button" aria-label="Annonce précédente"><i class="fas fa-chevron-left"></i></button>
            <button class="gxad-nav gxad-next" type="button" aria-label="Annonce suivante"><i class="fas fa-chevron-right"></i></button>
        @endif
    </div>
</div>

<script>
(function () {
    var pop = document.getElementById('gx-ads-popup');
    if (!pop) return;

    var dismissHours = parseInt(pop.getAttribute('data-dismiss-hours'), 10) || 12;
    var DISMISS_KEY = 'gx_ads_popup_dismissed_' + (pop.getAttribute('data-zone') || 'popup');

    // Ne pas réafficher si fermé récemment.
    try {
        var until = parseInt(localStorage.getItem(DISMISS_KEY) || '0', 10);
        if (until && Date.now() < until) { pop.remove(); return; }
    } catch (e) {}

    var slides = pop.querySelectorAll('.swiper-slide');
    var count  = slides.length;

    function fireImpression(slide) {
        if (!slide || slide._seen) return;
        slide._seen = true;
        var url = slide.getAttribute('data-gxad-imp');
        if (!url) return;
        try {
            var sep = url.indexOf('?') === -1 ? '?' : '&';
            var px = new Image();
            px.src = url + sep + 'url=' + encodeURIComponent(location.href) + '&_=' + Date.now();
        } catch (e) {}
    }

    // Clic tracké sans bloquer la navigation (beacon best-effort vers l'admin).
    pop.querySelectorAll('[data-gxad-click]').forEach(function (a) {
        a.addEventListener('click', function () {
            var url = a.getAttribute('data-gxad-click');
            if (!url) return;
            try {
                if (navigator.sendBeacon) { navigator.sendBeacon(url); }
                else { var px = new Image(); px.src = url + (url.indexOf('?') === -1 ? '?' : '&') + '_=' + Date.now(); }
            } catch (e) {}
        });
    });

    // Fermeture + mémorisation.
    pop.querySelector('.gxad-close').addEventListener('click', function () {
        pop.classList.remove('is-open');
        try { localStorage.setItem(DISMISS_KEY, String(Date.now() + dismissHours * 3600 * 1000)); } catch (e) {}
        setTimeout(function () { pop.remove(); }, 400);
    });

    // Charge Swiper (CSS+JS) si absent, puis initialise le carrousel.
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

    function reveal() { requestAnimationFrame(function () { pop.classList.add('is-open'); }); }

    ensureSwiper(function () {
        if (typeof window.Swiper === 'undefined') {
            // CDN indisponible : on affiche quand même la 1re annonce (statique).
            fireImpression(slides[0]);
            reveal();
            return;
        }
        var firstDur = parseInt(slides[0].getAttribute('data-swiper-autoplay'), 10) || 5000;
        new Swiper(pop.querySelector('.gxad-swiper'), {
            loop: count > 1,
            autoplay: count > 1 ? { delay: firstDur, disableOnInteraction: false } : false,
            pagination: count > 1 ? { el: pop.querySelector('.swiper-pagination'), clickable: true } : false,
            // Flèches manuelles précédent / suivant.
            navigation: count > 1 ? { prevEl: pop.querySelector('.gxad-prev'), nextEl: pop.querySelector('.gxad-next') } : false,
            on: {
                init: function () { fireImpression(slides[this.realIndex] || slides[0]); },
                slideChange: function () { fireImpression(slides[this.realIndex]); }
            }
        });
        reveal();
    });
})();
</script>
@endif
@endif
