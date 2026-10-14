{{-- ═══════════════════════════════════════════════════════════════════════
     Bannière publicitaire pleine largeur EN BAS DE PAGE (Ads Manager).

     Zone « banner_bottom_full ». Rendue CÔTÉ SERVEUR depuis la base PARTAGÉE
     avec l'administration, puis posée en fin de page par le middleware
     InjectAdsBottomBanner : elle paraît ainsi sur TOUTES les pages du site,
     quelle que soit leur mise en page.

       • pleine largeur, ratio 1920/200 (hauteur plancher sur mobile) ;
       • plusieurs annonces → rotation en fondu, durée = slide_duration ;
       • image / vidéo / html / texte ;
       • ciblage respecté : display_locations (contexte de la page courante) ;
         target_etablissements ne s'applique que sur /company/{id}/… ;
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
                // ⚠ display_locations et target_etablissements sont des colonnes
                // JSON (MySQL). Les comparer à '' lève « Invalid JSON text » et
                // l'erreur, avalée par le catch, vidait la bannière sur tout le
                // site — invisible en SQLite, où ces colonnes sont du texte.
                // Le tri par ciblage se fait donc en PHP, juste après.
                ->select('ads.*')
                ->orderBy('ads.priority')
                ->orderByDesc('ads.id')
                // Garde-fou avant le tri en PHP ; la limite de la zone s'applique après.
                ->limit(50)
                ->get();
        }
    } catch (\Throwable $e) {
        $gxbbAds = collect();
    }

    // Une valeur JSON de ciblage, rendue en tableau. Null, « [] » ou une
    // chaîne vide valent « aucune restriction ».
    $gxbbListe = function ($valeur): array {
        if (is_array($valeur)) {
            return $valeur;
        }

        $valeur = trim((string) $valeur);

        if ($valeur === '' || $valeur === '[]' || $valeur === 'null') {
            return [];
        }

        $decode = json_decode($valeur, true);

        return is_array($decode) ? $decode : [];
    };

    // Ciblage, appliqué ici plutôt qu'en SQL (voir ci-dessus) :
    //   • pages d'affichage : aucune case cochée = partout ;
    //   • établissements visés : ne filtre que SUR le site d'un établissement,
    //     sinon une annonce de commerce serait invisible sur tout le reste.
    $gxbbAds = $gxbbAds->filter(function ($ad) use ($gxbbLocation, $gxbbEtab, $gxbbListe) {
        $lieux = $gxbbListe($ad->display_locations ?? null);

        if ($lieux !== [] && (! $gxbbLocation || ! in_array($gxbbLocation, $lieux, true))) {
            return false;
        }

        $cibles = array_map('strval', $gxbbListe($ad->target_etablissements ?? null));

        return ! ($gxbbEtab && $cibles !== [] && ! in_array((string) $gxbbEtab, $cibles, true));
    });

    if ($gxbbPlacement ?? null) {
        $gxbbAds = $gxbbAds->take(max(1, (int) ($gxbbPlacement->max_ads ?: 10)));
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
    /* Barre fixe en bas de l'écran, au-dessus de tout le reste.
       Elle part du bord DROIT et s'étend vers la gauche en laissant libre le
       coin bas-gauche, occupé par le popup publicitaire (320 px + marges).
       z-index : au-dessus des couches les plus hautes du site (le popup est à
       99 990, certains gabarits montent à 2 147 483 200). */
    .gxbb{position:fixed;right:14px;bottom:14px;left:360px;z-index:2147483600;
        box-sizing:border-box;pointer-events:none}
    .gxbb *{box-sizing:border-box}
    .gxbb.is-hidden{display:none}
    .gxbb__stage{position:relative;width:100%;height:112px;margin-left:auto;border-radius:14px;overflow:hidden;
        background:#0f172a;box-shadow:0 14px 40px rgba(2,6,23,.38);pointer-events:auto}
    .gxbb__slide{position:absolute;inset:0;opacity:0;visibility:hidden;transition:opacity .5s ease,visibility .5s ease}
    .gxbb__slide.is-active{opacity:1;visibility:visible;z-index:1}

    /* Chaque annonce : visuel à gauche, titre et bouton à droite. */
    .gxbb__link{display:flex;align-items:center;gap:16px;width:100%;height:100%;color:#fff;text-decoration:none;padding-right:16px}
    .gxbb__media{position:relative;flex:none;width:200px;height:100%;overflow:hidden;background:#0b1220}
    .gxbb__media img{width:100%;height:100%;object-fit:cover;display:block}
    .gxbb__media iframe,.gxbb__media video{position:absolute;inset:0;width:100%;height:100%;border:0;object-fit:cover;pointer-events:none}
    /* Un iframe YouTube ne se recadre pas : on l'agrandit pour qu'il couvre
       la vignette sans bandes noires. */
    .gxbb__media iframe{top:50%;left:50%;right:auto;bottom:auto;width:auto;height:100%;aspect-ratio:16/9;transform:translate(-50%,-50%)}

    .gxbb__corps{flex:1;min-width:0;display:flex;align-items:center;justify-content:space-between;gap:16px;padding:10px 0}
    .gxbb__texte{min-width:0}
    .gxbb__titre{display:block;font-size:17px;font-weight:800;line-height:1.2;color:#fff;
        overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .gxbb__desc{display:block;margin-top:3px;font-size:13px;line-height:1.35;color:rgba(255,255,255,.78);
        overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .gxbb__cta{flex:none;display:inline-flex;align-items:center;gap:7px;padding:10px 18px;border-radius:999px;
        background:#d4af37;color:#1a1304;font-size:13px;font-weight:800;white-space:nowrap;
        box-shadow:0 6px 16px rgba(212,175,55,.35);transition:transform .2s ease,box-shadow .2s ease}
    .gxbb__link:hover .gxbb__cta{transform:translateY(-1px);box-shadow:0 10px 22px rgba(212,175,55,.45)}
    .gxbb__html{flex:1;height:100%;overflow:hidden;background:#fff;color:#0f172a}

    .gxbb__tag{position:absolute;top:8px;left:8px;z-index:3;font-size:9px;font-weight:700;letter-spacing:.06em;
        text-transform:uppercase;color:#fff;background:rgba(15,23,42,.65);border-radius:5px;padding:2px 7px;pointer-events:none}
    .gxbb__close{position:absolute;top:6px;right:8px;z-index:4;width:26px;height:26px;padding:0;border:0;border-radius:50%;
        background:rgba(15,23,42,.6);color:#fff;font-size:15px;line-height:1;cursor:pointer;pointer-events:auto}
    .gxbb__close:hover{background:rgba(15,23,42,.85)}
    .gxbb__dots{position:absolute;right:10px;bottom:8px;z-index:3;display:flex;gap:6px}
    .gxbb__dot{width:8px;height:8px;padding:0;border:0;border-radius:50%;background:rgba(255,255,255,.5);
        box-shadow:0 0 0 1px rgba(15,23,42,.25);cursor:pointer;transition:background .2s,transform .2s;pointer-events:auto}
    .gxbb__dot.is-active{background:#fff;transform:scale(1.25)}

    /* Tablette : on réduit la réserve laissée au popup. */
    @media (max-width:1200px){
        .gxbb{left:200px}
        .gxbb__media{width:160px}
        .gxbb__titre{font-size:15px}
    }
    /* Mobile : pleine largeur, posée AU-DESSUS de la barre d'outils du site
       (le rail latéral devient une barre basse d'environ 74 px sous 992 px). */
    @media (max-width:992px){
        .gxbb{left:10px;right:10px;bottom:84px}
        .gxbb__stage{height:92px}
        .gxbb__media{width:120px}
        .gxbb__titre{font-size:14px}
        .gxbb__desc{display:none}
        .gxbb__cta{padding:8px 14px;font-size:12px}
    }
    @media (max-width:520px){
        .gxbb__cta{padding:8px 12px;font-size:0;gap:0}
        .gxbb__cta::after{content:'→';font-size:15px}
    }
    /* Annonce sans visuel (texte seul) : la vignette disparaît et le texte
       prend toute la barre. Déclaré APRÈS les media queries, qui fixent une
       largeur de vignette et l'emporteraient sinon. */
    .gxbb .gxbb__media--vide{width:0;flex-basis:0}
    .gxbb .gxbb__media--vide + .gxbb__corps{padding-left:18px}
    @media(prefers-reduced-motion:reduce){.gxbb__slide{transition:none}}
</style>

<aside class="gxbb" aria-label="Annonces partenaires" data-gxbb>
    <div class="gxbb__stage">
        <span class="gxbb__tag">Annonce</span>
        <button type="button" class="gxbb__close" data-gxbb-close aria-label="Fermer la bannière">&times;</button>

        @foreach($gxbbAds as $ad)
            @php
                $dest     = trim((string) $ad->destination_url);
                $query    = '?pid=' . $gxbbPlacement->id . ($gxbbEtab ? '&eid=' . $gxbbEtab : '');
                // Le clic passe par l'admin, qui compte puis redirige.
                $href     = $dest !== '' ? ($gxbbAdmin !== '' ? $gxbbAdmin . '/ads/track/click/' . $ad->id . $query : $dest) : '';
                $pixel    = $gxbbAdmin !== '' ? $gxbbAdmin . '/ads/track/impression/' . $ad->id . $query : '';
                $newTab   = (int) $ad->open_new_tab === 1;
                $duration = (int) ($ad->slide_duration ?? 0) > 0 ? (int) $ad->slide_duration : $gxbbDefaultDuration;
                $desc     = trim((string) ($ad->text_content ?: $ad->description));
                // Le visuel : vidéo, image, ou rien pour une annonce en texte seul.
                $visuel   = $ad->type === 'video'
                    ? $gxbbVideo($ad->video_url ?: $ad->destination_url)
                    : ($ad->type === 'image' && trim((string) $ad->image_path) !== ''
                        ? '<img src="' . e($gxbbImg($ad->image_path)) . '" alt="' . e($ad->titre) . '" loading="lazy">'
                        : '');
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

                    @if($ad->type === 'html')
                        <div class="gxbb__html">{!! $ad->html_content !!}</div>
                    @else
                        <span class="gxbb__media{{ $visuel === '' ? ' gxbb__media--vide' : '' }}">{!! $visuel !!}</span>
                        <span class="gxbb__corps">
                            <span class="gxbb__texte">
                                <strong class="gxbb__titre">{{ $ad->titre }}</strong>
                                @if($desc !== '')<span class="gxbb__desc">{{ $desc }}</span>@endif
                            </span>
                            @if($href !== '')
                                <span class="gxbb__cta">Découvrir</span>
                            @endif
                        </span>
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

        // Fermeture : la barre est fixe et couvre le bas de l'écran ; le
        // visiteur doit pouvoir s'en débarrasser. La fermeture ne vaut que
        // pour la page affichée (même règle que le popup, dont la mémorisation
        // est à zéro par défaut).
        var fermer = banner.querySelector('[data-gxbb-close]');
        if (fermer) {
            fermer.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                clearTimeout(timer);
                banner.classList.add('is-hidden');
            });
        }

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
