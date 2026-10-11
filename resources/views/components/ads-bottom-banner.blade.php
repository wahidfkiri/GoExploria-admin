{{-- ═══════════════════════════════════════════════════════════════════════
     Bannière publicitaire pleine largeur EN BAS DE PAGE (Ads Manager).

     Zone « banner_bottom_full ». Rendue CÔTÉ SERVEUR depuis la base PARTAGÉE
     avec l'administration, puis posée en fin de page par le middleware
     InjectAdsBottomBanner : elle paraît ainsi sur TOUTES les pages du site,
     quelle que soit leur mise en page.

       • pleine largeur, ratio 1920/200 (hauteur plancher sur mobile) ;
       • plusieurs annonces → rotation en fondu, durée = slide_duration ;
       • image / vidéo / html / texte ;
       • ciblage respecté : display_locations (contexte de la page courante) et
         target_etablissements sur /company/{id}/… (vide = tous) ;
       • impression comptée à la PREMIÈRE apparition de chaque annonce à
         l'écran, clic compté par l'admin qui redirige vers la destination.

     ⚠ Pas de JSON_LENGTH() (propre à MySQL) : on teste '[]' / '' à la place.

     Variables attendues (fournies par le middleware) :
       $gxbbLocation : contexte de la page (home, activities, etablissements…)
                       ou null quand la page n'appartient à aucune famille —
                       seules les annonces sans restriction paraissent alors ;
       $gxbbEtab     : identifiant de l'établissement de la page, ou null.
     ═══════════════════════════════════════════════════════════════════════ --}}
@php
    $gxbbLocation = $gxbbLocation ?? null;
    $gxbbEtab     = isset($gxbbEtab) ? (int) $gxbbEtab : null;
    $gxbbAdmin    = rtrim((string) config('ads.admin_url', ''), '/');
    $gxbbZone     = config('ads.bottom_banner_zone', 'banner_bottom_full');
    $gxbbDefaultDuration = max(1, (int) config('ads.popup_default_duration', 5));

    try {
        $gxbbToday     = now()->toDateString();
        $gxbbPlacement = \Illuminate\Support\Facades\DB::table('ad_placements')
            ->where('code', $gxbbZone)->where('is_active', true)->first();

        $gxbbAds = collect();
        if ($gxbbPlacement) {
            $gxbbAds = \Illuminate\Support\Facades\DB::table('ads')
                ->join('ad_placement', 'ads.id', '=', 'ad_placement.ad_id')
                ->where('ad_placement.placement_id', $gxbbPlacement->id)
                ->where('ad_placement.is_active', true)
                ->where('ads.status', 'active')
                ->whereNull('ads.deleted_at')
                ->where(fn ($q) => $q->whereNull('ads.start_date')->orWhere('ads.start_date', '<=', $gxbbToday))
                ->where(fn ($q) => $q->whereNull('ads.end_date')->orWhere('ads.end_date', '>=', $gxbbToday))
                ->where(fn ($q) => $q->whereNull('ads.budget_total')->orWhereRaw('ads.budget_total > ads.budget_spent'))
                // Pages où l'annonce peut paraître : aucune case cochée = partout.
                ->where(function ($q) use ($gxbbLocation) {
                    $q->whereNull('ads.display_locations')->orWhereIn('ads.display_locations', ['[]', '']);

                    if ($gxbbLocation) {
                        $q->orWhereJsonContains('ads.display_locations', $gxbbLocation);
                    }
                })
                // Établissements ciblés : le formulaire enregistre les ids en
                // chaînes (« ["12"] »), d'anciens enregistrements en entiers.
                ->where(function ($q) use ($gxbbEtab) {
                    $q->whereNull('ads.target_etablissements')->orWhereIn('ads.target_etablissements', ['[]', '']);

                    if ($gxbbEtab) {
                        $q->orWhereJsonContains('ads.target_etablissements', (string) $gxbbEtab)
                          ->orWhereJsonContains('ads.target_etablissements', $gxbbEtab);
                    }
                })
                ->select('ads.*')
                ->orderBy('ads.priority')
                ->orderByDesc('ads.id')
                ->limit(max(1, (int) ($gxbbPlacement->max_ads ?: 10)))
                ->get();
        }
    } catch (\Throwable $e) {
        $gxbbAds = collect();
    }

    // Images stockées côté admin (storage séparé) => URL absolue vers l'admin.
    $gxbbImg = function (?string $path) use ($gxbbAdmin) {
        $path = trim((string) $path);
        if ($path === '') return '';
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])) return $path;
        return $gxbbAdmin . '/storage/' . ltrim($path, '/');
    };
    $gxbbVideo = function (?string $url) {
        $url = trim((string) $url);
        if ($url === '') return '';
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $url, $m)) {
            return '<iframe src="https://www.youtube.com/embed/' . $m[1] . '?autoplay=1&mute=1&loop=1&playlist=' . $m[1] . '&controls=0&rel=0&playsinline=1" allow="autoplay; encrypted-media" tabindex="-1" title="Annonce vidéo"></iframe>';
        }
        if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/i', $url, $m)) {
            return '<iframe src="https://player.vimeo.com/video/' . $m[1] . '?background=1&muted=1" allow="autoplay; fullscreen" tabindex="-1" title="Annonce vidéo"></iframe>';
        }
        return '<video src="' . e($url) . '" autoplay muted loop playsinline preload="metadata"></video>';
    };

    // Une annonce image sans visuel n'a rien à montrer dans une bannière.
    $gxbbAds = $gxbbAds->filter(function ($ad) {
        return match ($ad->type) {
            'image' => trim((string) $ad->image_path) !== '',
            'video' => trim((string) ($ad->video_url ?: $ad->destination_url)) !== '',
            'html'  => trim((string) $ad->html_content) !== '',
            default => trim((string) ($ad->titre . $ad->text_content)) !== '',
        };
    })->values();
@endphp

@if($gxbbAds->isNotEmpty())
<style>
    .gxbb{position:relative;width:100%;max-width:1920px;margin:0 auto;box-sizing:border-box;padding:18px clamp(12px,2.4vw,32px) 24px;clear:both}
    .gxbb *{box-sizing:border-box}
    .gxbb__stage{position:relative;width:100%;aspect-ratio:1920/200;min-height:90px;border-radius:14px;overflow:hidden;background:#0f172a;box-shadow:0 8px 26px rgba(2,6,23,.12)}
    .gxbb__slide{position:absolute;inset:0;opacity:0;visibility:hidden;transition:opacity .6s ease,visibility .6s ease}
    .gxbb__slide.is-active{opacity:1;visibility:visible;z-index:1}
    .gxbb__link{display:block;width:100%;height:100%;color:inherit;text-decoration:none}
    .gxbb__slide img{width:100%;height:100%;object-fit:cover;display:block}
    .gxbb__slide iframe,.gxbb__slide video{position:absolute;inset:0;width:100%;height:100%;border:0;object-fit:cover;pointer-events:none}
    /* Un iframe YouTube ne se recadre pas : on l'agrandit pour qu'il couvre
       le bandeau très large sans bandes noires. */
    .gxbb__slide iframe{top:50%;left:50%;right:auto;bottom:auto;width:100%;height:auto;aspect-ratio:16/9;transform:translate(-50%,-50%)}
    .gxbb__html{width:100%;height:100%;overflow:hidden;background:#fff;color:#0f172a}
    .gxbb__text{width:100%;height:100%;display:flex;flex-direction:column;justify-content:center;gap:4px;padding:12px clamp(18px,4vw,64px);background:linear-gradient(100deg,#0c4a6e 0%,#0284c7 60%,#38bdf8 100%);color:#fff}
    .gxbb__text strong{font-size:clamp(15px,2vw,28px);font-weight:800;line-height:1.15}
    .gxbb__text span{font-size:clamp(12px,1.2vw,16px);opacity:.9;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
    .gxbb__tag{position:absolute;top:8px;left:8px;z-index:3;font-size:9px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#fff;background:rgba(15,23,42,.55);border-radius:5px;padding:2px 7px;pointer-events:none}
    .gxbb__dots{position:absolute;right:10px;bottom:8px;z-index:3;display:flex;gap:6px}
    .gxbb__dot{width:8px;height:8px;padding:0;border:0;border-radius:50%;background:rgba(255,255,255,.5);box-shadow:0 0 0 1px rgba(15,23,42,.25);cursor:pointer;transition:background .2s,transform .2s}
    .gxbb__dot.is-active{background:#fff;transform:scale(1.25)}
    @media(prefers-reduced-motion:reduce){.gxbb__slide{transition:none}}
</style>

<aside class="gxbb" aria-label="Annonces partenaires" data-gxbb>
    <div class="gxbb__stage">
        <span class="gxbb__tag">Annonce</span>
        @foreach($gxbbAds as $ad)
            @php
                $dest     = trim((string) $ad->destination_url);
                $query    = '?pid=' . $gxbbPlacement->id . ($gxbbEtab ? '&eid=' . $gxbbEtab : '');
                // Le clic passe par l'admin, qui compte puis redirige.
                $href     = $dest !== '' ? ($gxbbAdmin !== '' ? $gxbbAdmin . '/ads/track/click/' . $ad->id . $query : $dest) : '';
                $pixel    = $gxbbAdmin !== '' ? $gxbbAdmin . '/ads/track/impression/' . $ad->id . $query : '';
                $newTab   = (int) $ad->open_new_tab === 1;
                $duration = (int) ($ad->slide_duration ?? 0) > 0 ? (int) $ad->slide_duration : $gxbbDefaultDuration;
            @endphp
            <div class="gxbb__slide{{ $loop->first ? ' is-active' : '' }}"
                 data-gxbb-slide data-duration="{{ $duration * 1000 }}"
                 @if($pixel !== '') data-pixel="{{ $pixel }}" @endif
                 @unless($loop->first) aria-hidden="true" @endunless>
                @if($href !== '')
                    <a class="gxbb__link" href="{{ $href }}" @if($newTab) target="_blank" rel="noopener sponsored" @else rel="sponsored" @endif aria-label="{{ $ad->titre }}">
                @else
                    <div class="gxbb__link">
                @endif

                @if($ad->type === 'video')
                    {!! $gxbbVideo($ad->video_url ?: $ad->destination_url) !!}
                @elseif($ad->type === 'html')
                    <div class="gxbb__html">{!! $ad->html_content !!}</div>
                @elseif($ad->type === 'text')
                    <div class="gxbb__text">
                        <strong>{{ $ad->titre }}</strong>
                        @if($ad->text_content || $ad->description)<span>{{ $ad->text_content ?: $ad->description }}</span>@endif
                    </div>
                @else
                    <img src="{{ $gxbbImg($ad->image_path) }}" alt="{{ $ad->titre }}" width="1920" height="200" loading="lazy">
                @endif

                @if($href !== '')
                    </a>
                @else
                    </div>
                @endif
            </div>
        @endforeach

        @if($gxbbAds->count() > 1)
            <div class="gxbb__dots" role="tablist">
                @foreach($gxbbAds as $ad)
                    <button type="button" class="gxbb__dot{{ $loop->first ? ' is-active' : '' }}" data-gxbb-dot="{{ $loop->index }}" aria-label="Annonce {{ $loop->iteration }}"></button>
                @endforeach
            </div>
        @endif
    </div>
</aside>

<script>
(function () {
    function init(banner) {
        if (banner.__gxbbReady) return;
        banner.__gxbbReady = true;

        var slides = Array.prototype.slice.call(banner.querySelectorAll('[data-gxbb-slide]'));
        var dots   = Array.prototype.slice.call(banner.querySelectorAll('[data-gxbb-dot]'));
        var current = 0, timer = null, paused = false, visible = false;

        // Impression : une fois par annonce et par page, et seulement quand
        // la bannière est réellement à l'écran — elle est en bas de page.
        function impression(slide) {
            if (!slide || slide.__gxbbSeen || !visible) return;
            var url = slide.getAttribute('data-pixel');
            if (!url) return;
            slide.__gxbbSeen = true;
            try {
                var px = new Image();
                px.src = url + (url.indexOf('?') > -1 ? '&' : '?') + 'url=' + encodeURIComponent(location.href) + '&_=' + Date.now();
            } catch (e) {}
        }

        function show(index) {
            current = (index + slides.length) % slides.length;
            slides.forEach(function (s, i) {
                var on = i === current;
                s.classList.toggle('is-active', on);
                if (on) { s.removeAttribute('aria-hidden'); } else { s.setAttribute('aria-hidden', 'true'); }
            });
            dots.forEach(function (d, i) { d.classList.toggle('is-active', i === current); });
            impression(slides[current]);
            schedule();
        }

        function schedule() {
            clearTimeout(timer);
            if (slides.length < 2 || paused || !visible) return;
            var delay = parseInt(slides[current].getAttribute('data-duration'), 10) || 5000;
            timer = setTimeout(function () { show(current + 1); }, delay);
        }

        dots.forEach(function (d) {
            d.addEventListener('click', function () { show(parseInt(d.getAttribute('data-gxbb-dot'), 10) || 0); });
        });
        banner.addEventListener('mouseenter', function () { paused = true; clearTimeout(timer); });
        banner.addEventListener('mouseleave', function () { paused = false; schedule(); });

        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (entries) {
                visible = entries[0].isIntersecting;
                if (visible) { impression(slides[current]); schedule(); } else { clearTimeout(timer); }
            }, { threshold: 0.3 }).observe(banner);
        } else {
            visible = true;
            impression(slides[current]);
            schedule();
        }
    }

    function boot() { document.querySelectorAll('[data-gxbb]').forEach(init); }
    if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', boot); } else { boot(); }
})();
</script>
@endif
