@php
    // ==========================================================================
    // Landing UNIQUE (générique) — gère tous les établissements.
    // Les sections sont appelées via partials/ (statiques) ou via les partials DB.
    // Aucune section inline ici : uniquement préparation des données + orchestration.
    // ==========================================================================
    $siteName = trim((string) (get_site_name($etablissement->id) ?: ($etablissement->name ?? 'GoExploria')));
    $siteDescription = trim((string) (
        $etablissement->getSetting('site_description', null, 'general')
        ?: get_site_description($etablissement->id)
        ?: ($etablissement->description ?? '')
    ));
    $devisLink = $devisUrl ?? route('devis');
    $logoUrl = $brandLogoUrl ?? get_logo_url($etablissement->id);
    $address = trim((string) ($etablissement->adresse ?? $etablissement->address ?? $etablissement->ville ?? ''));
    $email = trim((string) ($etablissement->email ?? $etablissement->contact_email ?? ''));
    $phone = trim((string) ($etablissement->telephone ?? $etablissement->phone ?? ''));
    $phoneHref = preg_replace('/\s+/', '', $phone);
    $hours = $etablissement->getSetting('opening_hours', [], 'company');
    $workingHours = normalize_cms_opening_hours($hours, $workingHours ?? []);
    $mapLat = (float) ($mapLatitude ?? 46.8139);
    $mapLng = (float) ($mapLongitude ?? -71.2082);
    $socialLinks = collect($socialLinks ?? [])->filter(fn ($link) => !empty(data_get($link, 'url')))->values();

    $assetUrl = static function ($path) {
        $path = trim((string) $path);
        if ($path === '') {
            return null;
        }
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }
        if (\Illuminate\Support\Str::startsWith($path, ['/storage/', 'storage/', '/'])) {
            return asset(ltrim($path, '/'));
        }
        return asset('storage/' . ltrim($path, '/'));
    };

    $youtubeIdFromUrl = static function ($value) {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }
        if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/i', $value, $match)) {
            $value = $match[1];
        }
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|live\/|embed\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $value, $match)) {
            return $match[1];
        }
        return null;
    };

    $heroSlides = collect(get_slider_items($etablissement->id))->map(function ($slider) use ($assetUrl, $youtubeIdFromUrl) {
        $type = strtolower((string) (data_get($slider, 'type') ?: 'image'));
        $rawUrl = data_get($slider, 'url') ?: data_get($slider, 'image_url') ?: data_get($slider, 'image_path') ?: data_get($slider, 'video_url');
        $media = $assetUrl($rawUrl);
        $poster = $assetUrl(data_get($slider, 'poster_url') ?: data_get($slider, 'thumbnail_url'));
        $iframe = null;
        foreach ([data_get($slider, 'video_html'), data_get($slider, 'embed'), $rawUrl] as $candidate) {
            if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/i', (string) $candidate, $match)) {
                $iframe = trim((string) $match[1]);
                break;
            }
        }
        $youtubeId = $youtubeIdFromUrl($media ?: $rawUrl);
        if (!$poster && $youtubeId) {
            $poster = 'https://i.ytimg.com/vi/' . $youtubeId . '/hqdefault.jpg';
        }
        $embed = $iframe ?: ($youtubeId ? 'https://www.youtube.com/embed/' . $youtubeId . '?autoplay=1&mute=1&muted=1&loop=1&playlist=' . $youtubeId . '&controls=0&rel=0&modestbranding=1&playsinline=1' : null);
        return [
            'type' => $type,
            'url' => $media,
            'poster' => $poster,
            'embed' => $embed,
            'title' => trim((string) (data_get($slider, 'title') ?: '')),
            'subtitle' => trim((string) (data_get($slider, 'subtitle') ?: data_get($slider, 'description') ?: '')),
            'button_text' => trim((string) (data_get($slider, 'button_text') ?: '')),
            'button_url' => trim((string) (data_get($slider, 'button_link') ?: data_get($slider, 'button_url') ?: '')),
            'order' => (int) data_get($slider, 'order', 0),
        ];
    })->filter(fn ($slide) => !empty($slide['url']) || !empty($slide['embed']) || !empty($slide['poster']))->sortBy('order')->values();

    $cmsLandingProducts = collect();
    try {
        if (!empty($etablissement->id) && class_exists(\App\Models\Product::class) && \Illuminate\Support\Facades\Schema::hasTable('products')) {
            $cmsLandingProducts = \App\Models\Product::query()
                ->with(['category:id,name', 'family:id,name'])
                ->where('etablissement_id', $etablissement->id)
                ->where('is_available_for_sale', true)
                ->latest('updated_at')
                ->limit(8)
                ->get();
        }
    } catch (\Throwable $e) {
        $cmsLandingProducts = collect();
    }

    $blogCards = collect($blogPosts ?? [])->filter(fn ($post) => trim((string) data_get($post, 'title')) !== '')->take(3)->values();

    // Le site CMS d'un établissement affiche SON header (issu du template) et non
    // celui de la plateforme. Le chrome global n'est rendu qu'en repli, lorsque
    // l'établissement n'a pas encore défini son propre header — sinon la page se
    // retrouverait sans aucune navigation.
    $cmsEtabHeaderHtml = function_exists('get_cms_header_html')
        ? trim((string) get_cms_header_html($etablissement->id))
        : '';
    $cmsHasEtabHeader = $cmsEtabHeaderHtml !== '';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteName }}</title>
    @if($siteDescription !== '')<meta name="description" content="{{ \Illuminate\Support\Str::limit($siteDescription, 160) }}">@endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu-videos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/categories-mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/videos-dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/slideshows.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/media-slideshow.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/products-vedette.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
    <style>
        :root{--lp-accent:#2563eb;--lp-accent-2:#1d4ed8;--lp-bg:#ffffff;--lp-bg-alt:#f5f7fb;--lp-card:#ffffff;--lp-text:#0f172a;--lp-muted:#64748b;--lp-line:rgba(15,23,42,.1);--lp-shadow:0 24px 70px rgba(15,23,42,.1)}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:var(--lp-bg);color:var(--lp-text);font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif;overflow-x:hidden}a{color:inherit;text-decoration:none}img,video,iframe{max-width:100%}.container{width:min(1180px,calc(100% - 40px));margin:auto}
        .lp-kicker{display:inline-flex;gap:10px;align-items:center;color:var(--lp-accent);font-size:11px;letter-spacing:3px;text-transform:uppercase;font-weight:800}
        .lp-hero{position:relative;min-height:88vh;display:flex;align-items:flex-end;overflow:hidden;background:var(--lp-bg-alt)}.lp-hero-media{position:absolute;inset:0}.lp-hero-media img,.lp-hero-media video,.lp-hero-media iframe{width:100%;height:100%;object-fit:cover;border:0}.lp-hero-media iframe{position:absolute;inset:50% auto auto 50%;width:177.78vh;height:56.25vw;min-width:100%;min-height:100%;transform:translate(-50%,-50%);pointer-events:none}.lp-hero::after{content:"";position:absolute;inset:0;background:linear-gradient(to top,rgba(2,6,23,.86),rgba(2,6,23,.28),rgba(2,6,23,.12))}
        .lp-hero-inner{position:relative;z-index:2;padding:150px 0 80px}.lp-h1{font-family:"Playfair Display",serif;font-size:clamp(40px,7vw,88px);font-weight:700;line-height:1;margin:14px 0 20px;color:#fff}.lp-desc{max-width:620px;color:rgba(255,255,255,.82);line-height:1.8;font-size:17px}.lp-hero-buttons{display:flex;gap:14px;flex-wrap:wrap;margin-top:30px}.lp-btn{display:inline-flex;align-items:center;gap:10px;border-radius:999px;padding:14px 26px;font-size:12px;letter-spacing:1.5px;text-transform:uppercase;font-weight:800;border:1px solid rgba(255,255,255,.35);color:#fff}.lp-btn.gold{background:var(--lp-accent);color:#fff;border-color:var(--lp-accent)}
        .lp-section{padding:80px 0;background:var(--lp-bg)}.lp-section.alt{background:var(--lp-bg-alt)}.lp-head{display:flex;align-items:end;justify-content:space-between;gap:30px;margin-bottom:34px}.lp-title{font-family:"Playfair Display",serif;font-size:clamp(30px,4vw,52px);line-height:1.05;margin:8px 0 0}.lp-sub{max-width:560px;color:var(--lp-muted);line-height:1.7}
        .lp-blog-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:22px}.lp-blog{background:var(--lp-card);border:1px solid var(--lp-line);border-radius:20px;overflow:hidden;transition:all .25s ease;box-shadow:var(--lp-shadow)}.lp-blog:hover{transform:translateY(-4px)}.lp-blog-img{height:210px;background:#e2e8f0}.lp-blog-img img{width:100%;height:100%;object-fit:cover}.lp-blog-body{padding:22px}.lp-date{font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--lp-accent);margin-bottom:10px;font-weight:700}.lp-blog h3{font-family:"Playfair Display",serif;font-size:24px;line-height:1.15;margin:0 0 10px}.lp-blog p{color:var(--lp-muted);line-height:1.6;margin:0}.lp-blog-more{display:inline-flex;align-items:center;gap:8px;margin-top:16px;color:var(--lp-accent);font-size:12px;font-weight:800;letter-spacing:1px;text-transform:uppercase}
        .lp-contact-grid{display:grid;grid-template-columns:.9fr 1.1fr;gap:30px}.lp-info,.lp-form{background:var(--lp-card);border:1px solid var(--lp-line);border-radius:22px;padding:30px;box-shadow:var(--lp-shadow)}.lp-info-list{display:grid;gap:14px}.lp-info-item{display:grid;grid-template-columns:44px 1fr;gap:14px;align-items:start}.lp-info-item i{width:44px;height:44px;border-radius:14px;background:var(--lp-accent);color:#fff;display:grid;place-items:center}.lp-info-item strong{display:block;margin-bottom:3px}.lp-info-item span,.lp-info-item a{color:var(--lp-muted);line-height:1.5}.lp-social{display:flex;gap:10px;flex-wrap:wrap;margin-top:22px}.lp-social a{width:42px;height:42px;border-radius:50%;display:grid;place-items:center;border:1px solid var(--lp-line);color:var(--lp-accent)}
        .lp-form{display:grid;gap:14px}.lp-form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}.lp-field label{display:block;font-size:11px;letter-spacing:1.5px;text-transform:uppercase;color:var(--lp-muted);margin-bottom:7px}.lp-field input,.lp-field select,.lp-field textarea{width:100%;border:1px solid var(--lp-line);background:#fff;color:var(--lp-text);border-radius:14px;padding:14px 15px;font:inherit}.lp-field textarea{min-height:130px;resize:vertical}.lp-submit{border:0;background:var(--lp-accent);color:#fff;border-radius:999px;padding:15px 24px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;cursor:pointer}
        .lp-footer{padding:40px 0;background:#0f172a;color:rgba(255,255,255,.75);border-top:1px solid rgba(255,255,255,.08)}.lp-footer .container{display:flex;justify-content:space-between;gap:20px;flex-wrap:wrap;align-items:center}.lp-footer strong{color:#fff}
        @media(max-width:900px){.lp-contact-grid{grid-template-columns:1fr}.lp-form-row{grid-template-columns:1fr}.lp-head{display:block}.lp-hero-inner{padding-top:130px}}
    </style>
</head>
<body>
    {{-- Chrome global de la plateforme --}}
    {{-- Chrome global : uniquement si l'établissement n'a pas son propre header. --}}
    @unless($cmsHasEtabHeader)
        @include('home-v2.components.VerticalMenu')
        @include('home-v2.components.Header')
    @endunless

    {{-- Header propre à l'établissement (cms_header_footers) --}}
    @include('cms::web.fallback.partials.landing-cms-header')

    {{-- Sections : statiques via partials/sections, données via partials DB --}}
    @include('cms::web.fallback.partials.sections.hero')

    <main>
        @include('cms::web.fallback.partials.landing-map-video-points')

        @if(collect($cmsPageSections ?? [])->isNotEmpty())
            @foreach(collect($cmsPageSections) as $cmsPage)
                {!! data_get($cmsPage, 'content') !!}
            @endforeach
        @endif

        @include('cms::web.fallback.partials.sections.products')
        @include('cms::web.fallback.partials.sections.blog')
        @include('cms::web.fallback.partials.landing-working-hours')
        @include('cms::web.fallback.partials.sections.contact')
    </main>

    @include('cms::web.fallback.partials.landing-media-slideshow')

    {{-- Footer propre à l'établissement (cms_header_footers) puis footer landing --}}
    @include('cms::web.fallback.partials.landing-cms-footer')
    @include('cms::web.fallback.partials.sections.footer')

    @include('cms::web.fallback.partials.landing-contact-ajax')
    @include('cms::web.fallback.partials.landing-cart-drawer')
    @include('cms::web.fallback.partials.landing-back-to-top')

    {{-- Swiper : hero-sliders des templates/sections CMS. --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
    @include('cms::web.fallback.partials.gx-galleries')
    {{-- Activités proposées par l'établissement (onglet « Activités » du CMS). --}}
    @include('cms::web.fallback.partials.gx-activities')
    @include('cms::web.fallback.partials.gx-announcements')
</body>
</html>
