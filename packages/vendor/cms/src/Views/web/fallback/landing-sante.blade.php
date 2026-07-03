@php
    $siteName = trim((string) (get_site_name($etablissement->id) ?: ($etablissement->name ?? 'Sante')));
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
        if (empty($path)) {
            return null;
        }

        $path = trim((string) $path);
        if ($path === '') {
            return null;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['/storage/'])) {
            return asset(ltrim($path, '/'));
        }

        if (\Illuminate\Support\Str::startsWith($path, ['storage/'])) {
            return asset($path);
        }

        if (\Illuminate\Support\Str::startsWith($path, ['/'])) {
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
        $rawUrl = data_get($slider, 'url')
            ?: data_get($slider, 'image_url')
            ?: data_get($slider, 'image_path')
            ?: data_get($slider, 'video_url');
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
        if (
            isset($etablissement)
            && !empty($etablissement->id)
            && class_exists(\App\Models\Product::class)
            && \Illuminate\Support\Facades\Schema::hasTable('products')
        ) {
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

    $mapPoints = collect();
    try {
        if (class_exists(\App\Models\MapPoint::class) && \Illuminate\Support\Facades\Schema::hasTable('map_points')) {
            $mapPoints = \App\Models\MapPoint::with(['videos'])
                ->where('etablissement_id', $etablissement->id)
                ->where('is_active', true)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get()
                ->map(function ($point) use ($youtubeIdFromUrl, $assetUrl) {
                    $video = $point->videos->first();
                    $youtubeId = $point->youtube_id ?: data_get($video, 'youtube_id') ?: $youtubeIdFromUrl($point->youtube_url ?: data_get($video, 'youtube_url'));

                    return [
                        'title' => $point->title ?: 'Point de carte',
                        'description' => $point->description ?: $point->adresse,
                        'lat' => (float) $point->latitude,
                        'lng' => (float) $point->longitude,
                        'image' => $assetUrl($point->main_image),
                        'video_embed' => $youtubeId ? 'https://www.youtube.com/embed/' . $youtubeId . '?autoplay=1&mute=1&playsinline=1&rel=0&modestbranding=1' : null,
                    ];
                })
                ->values();
        }
    } catch (\Throwable $e) {
        $mapPoints = collect();
    }

    if ($mapPoints->isEmpty()) {
        $mapPoints = collect([[
            'title' => $siteName,
            'description' => $address,
            'lat' => $mapLat,
            'lng' => $mapLng,
            'image' => null,
            'video_embed' => null,
        ]]);
    }
@endphp
<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteName }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,300;0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu-videos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-destinations-mega.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/categories-mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/videos-dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/slideshows.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/media-slideshow.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/products-vedette.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/restaurant-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
    <style>
        :root{--sage:#2D6A4F;--sage2:#40916C;--sage3:#52B788;--mint:#95D5B2;--mint2:#D8F3DC;--amber:#E9C46A;--warm:#F4A261;--tr:all .45s cubic-bezier(.23,1,.32,1);--rad:18px;--rad-lg:28px}
        [data-theme=light]{--bg:#FAFAF8;--bg2:#F4F0E8;--bg3:#EDE8DC;--card:#FFFFFF;--border:rgba(45,106,79,.11);--border2:rgba(45,106,79,.2);--text:#1A2E1E;--text2:#4A6355;--text3:#7A9184;--inp:rgba(45,106,79,.05);--sh:0 20px 60px rgba(45,106,79,.1)}
        [data-theme=dark]{--bg:#0D1610;--bg2:#111B14;--bg3:#162219;--card:#131D16;--border:rgba(82,183,136,.11);--border2:rgba(82,183,136,.2);--text:#E8F5EC;--text2:#9BC4AA;--text3:#6B8C77;--inp:rgba(82,183,136,.07);--sh:0 20px 60px rgba(0,0,0,.5)}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:var(--bg);color:var(--text);font-family:"Plus Jakarta Sans",sans-serif;overflow-x:hidden;transition:background .35s,color .35s}a{color:inherit;text-decoration:none}img,video,iframe{max-width:100%}.container{width:min(1180px,calc(100% - 40px));margin:auto}
        .hl-hero{position:relative;min-height:100vh;display:grid;align-items:center;overflow:hidden;background:var(--bg2);padding:140px 0 80px}.hl-hero::before{content:"";position:absolute;inset:-20% -12% auto auto;width:58vw;height:58vw;border-radius:50%;background:radial-gradient(circle at 35% 35%,rgba(216,243,220,.72),rgba(149,213,178,.24) 46%,transparent 72%);pointer-events:none}.hl-hero::after{content:"";position:absolute;inset:0;background:linear-gradient(90deg,var(--bg2) 0%,rgba(244,240,232,.9) 42%,rgba(244,240,232,.18) 100%);pointer-events:none}[data-theme=dark] .hl-hero::after{background:linear-gradient(90deg,var(--bg2) 0%,rgba(17,27,20,.88) 42%,rgba(17,27,20,.2) 100%)}
        .hl-hero-media{position:absolute;inset:0}.hl-hero-media img,.hl-hero-media video{width:100%;height:100%;object-fit:cover}.hl-hero-media iframe{position:absolute;inset:50% auto auto 50%;width:177.78vh;height:56.25vw;min-width:100%;min-height:100%;transform:translate(-50%,-50%);border:0;pointer-events:none}.hl-hero-inner{position:relative;z-index:2;display:block}.hl-h1{font-family:Fraunces,serif;font-size:clamp(46px,6.5vw,84px);font-weight:700;line-height:1;letter-spacing:0;margin:0 0 24px;color:var(--text);max-width:700px}.hl-desc{max-width:560px;color:var(--text2);font-size:17px;line-height:1.9;margin:0}.hl-actions{display:flex;gap:14px;flex-wrap:wrap;margin-top:34px}.hl-btn{display:inline-flex;align-items:center;gap:10px;border:0;background:var(--sage);color:#fff;border-radius:999px;padding:15px 30px;font-size:12px;font-weight:800;letter-spacing:1.4px;text-transform:uppercase;box-shadow:0 12px 34px rgba(45,106,79,.28)}
        .hl-section{padding:92px 0;background:var(--bg)}.hl-section.alt{background:var(--bg2)}.hl-head{display:flex;align-items:end;justify-content:space-between;gap:28px;margin-bottom:36px}.hl-kicker{display:inline-flex;align-items:center;gap:10px;color:var(--sage);font-size:11px;font-weight:800;letter-spacing:2.8px;text-transform:uppercase}.hl-kicker::before{content:"";width:26px;height:2px;background:var(--sage);border-radius:3px}.hl-title{font-family:Fraunces,serif;font-size:clamp(34px,4.6vw,60px);line-height:1;margin:10px 0 0}.hl-sub{max-width:560px;color:var(--text2);line-height:1.8;margin:0}
        .hl-db-grid{display:grid;gap:24px}.hl-db-card{background:var(--card);border:1px solid var(--border);border-radius:var(--rad-lg);padding:clamp(24px,4vw,48px);box-shadow:var(--sh)}.hl-db-content{color:var(--text2);line-height:1.85}.hl-db-content :where(h1,h2,h3,h4,h5,h6){font-family:Fraunces,serif;color:var(--text);line-height:1.1;margin:0 0 16px}.hl-db-content :where(p,ul,ol,blockquote,figure){margin:0 0 18px}.hl-db-content :where(img,video,iframe){border-radius:18px}
        .hl-blog-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:22px}.hl-blog{background:var(--card);border:1px solid var(--border);border-radius:24px;overflow:hidden;transition:var(--tr)}.hl-blog:hover{transform:translateY(-5px);border-color:var(--border2);box-shadow:var(--sh)}.hl-blog-img{height:230px;background:var(--bg3)}.hl-blog-img img{width:100%;height:100%;object-fit:cover}.hl-blog-body{padding:23px}.hl-date{font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--sage);font-weight:800;margin-bottom:10px}.hl-blog h3{font-family:Fraunces,serif;font-size:26px;line-height:1.12;margin:0 0 10px}.hl-blog p{color:var(--text2);line-height:1.7;margin:0}.hl-blog-more{display:inline-flex;align-items:center;gap:8px;margin-top:18px;color:var(--sage);font-size:12px;font-weight:900;letter-spacing:1.4px;text-transform:uppercase}
        .hl-contact-grid{display:grid;grid-template-columns:.88fr 1.12fr;gap:30px}.hl-info,.hl-form{background:var(--card);border:1px solid var(--border);border-radius:var(--rad-lg);padding:30px;box-shadow:var(--sh)}.hl-info-list{display:grid;gap:15px}.hl-info-item{display:grid;grid-template-columns:46px 1fr;gap:14px;align-items:start}.hl-info-item i{width:46px;height:46px;border-radius:16px;background:var(--sage);color:#fff;display:grid;place-items:center}.hl-info-item strong{display:block;margin-bottom:4px}.hl-info-item span,.hl-info-item a{color:var(--text2);line-height:1.6}.hl-social{display:flex;gap:10px;flex-wrap:wrap;margin-top:24px}.hl-social a{width:42px;height:42px;border-radius:50%;display:grid;place-items:center;border:1px solid var(--border2);color:var(--sage);transition:var(--tr)}.hl-social a:hover{background:var(--sage);color:#fff}
        .hl-form{display:grid;gap:14px}.hl-form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}.hl-field label{display:block;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--text3);font-weight:800;margin-bottom:8px}.hl-field input,.hl-field select,.hl-field textarea{width:100%;border:1px solid var(--border);background:var(--inp);color:var(--text);border-radius:16px;padding:14px 15px;font:inherit}.hl-field textarea{min-height:132px;resize:vertical}.hl-submit{border:0;background:var(--sage);color:#fff;border-radius:999px;padding:15px 24px;font-weight:900;letter-spacing:1.6px;text-transform:uppercase;cursor:pointer;transition:var(--tr)}.hl-submit:hover{background:var(--sage2);transform:translateY(-2px)}
        .hl-map{height:520px;position:relative;background:var(--bg2)}#hlMap{height:100%;width:100%}.hl-map-card{position:absolute;left:24px;bottom:24px;z-index:500;background:var(--card);border:1px solid var(--border);border-radius:20px;padding:20px;box-shadow:var(--sh);max-width:330px}.hl-map-card p{margin:5px 0 0;color:var(--text2)}.hl-popup{width:320px;max-width:100%}.hl-popup h4{margin:0 0 8px;color:#1A2E1E}.hl-popup p{margin:0 0 10px;color:#4A6355}.hl-popup iframe{width:100%;height:180px;border:0;border-radius:10px;display:block}
        .hl-footer{padding:42px 0;background:#08100b;color:rgba(232,245,236,.72);border-top:1px solid rgba(255,255,255,.08)}.hl-footer .container{display:flex;justify-content:space-between;gap:20px;flex-wrap:wrap}.hl-footer strong{color:#fff}
        @media(max-width:900px){.hl-contact-grid{grid-template-columns:1fr}.hl-blog-grid{grid-template-columns:1fr}.hl-form-row{grid-template-columns:1fr}.hl-head{display:block}.hl-hero{padding-top:125px}.hl-map{height:460px}}
    </style>
</head>
<body>
    @include('cms::web.fallback.activities.default.vertical-menu')
    @include('home-v2.components.Header')
    @include('cms::web.fallback.partials.landing-cms-header')

    @if(is_slider_enabled($etablissement->id))
        @if(has_slider($etablissement->id))
            {!! get_slider_html($etablissement->id) !!}
        @elseif($heroSlides->isNotEmpty())
        @php($hero = $heroSlides->first())
        @php($heroEmbed = !empty($hero['embed']) ? $hero['embed'] . (str_contains((string) $hero['embed'], '?') ? '&' : '?') . 'autoplay=1&mute=1&muted=1&playsinline=1' : null)
        <section class="hl-hero" id="top">
            <div class="hl-hero-media">
                @if(!empty($heroEmbed))
                    <iframe src="{{ $heroEmbed }}" title="{{ $hero['title'] ?: $siteName }}" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                @elseif(($hero['type'] ?? 'image') === 'video' && !empty($hero['url']))
                    <video src="{{ $hero['url'] }}" poster="{{ $hero['poster'] }}" autoplay muted loop playsinline></video>
                @else
                    <img src="{{ $hero['url'] ?: $hero['poster'] }}" alt="{{ $hero['title'] ?: $siteName }}">
                @endif
            </div>
            <div class="container hl-hero-inner">
                <div>
                    @if(!empty($hero['title']))
                        <h1 class="hl-h1">{{ $hero['title'] }}</h1>
                    @endif
                    @if(!empty($hero['subtitle']))
                        <p class="hl-desc">{{ $hero['subtitle'] }}</p>
                    @endif
                    @if(!empty($hero['button_text']) && !empty($hero['button_url']))
                        <div class="hl-actions">
                            <a class="hl-btn" href="{{ $hero['button_url'] }}">{{ $hero['button_text'] }} <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
        @endif
    @endif

    <main>
        @include('cms::web.fallback.partials.landing-map-video-points')

        @if(collect($cmsPageSections ?? [])->isNotEmpty())
            <section class="hl-section" id="contenu">
                <div class="container hl-db-grid">
                    @foreach(collect($cmsPageSections) as $cmsPage)
                        <article class="hl-db-card">
                            <div class="hl-db-content">
                                {!! data_get($cmsPage, 'content') !!}
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        @if($cmsLandingProducts->isNotEmpty())
            <section class="hl-section alt" id="offres">
                <div class="container">
                    @include('cms::web.fallback.partials.establishment-products', [
                        'cmsLandingProducts' => $cmsLandingProducts,
                        'cmsProductsLimit' => 8,
                        'cmsProductsSectionId' => 'offres-sante',
                        'cmsProductsTitle' => 'Nos Produits disponible',
                        'cmsProductsSubtitle' => 'Les produits et services publies par cet etablissement sont affiches automatiquement.'
                    ])
                </div>
            </section>
        @endif

        @if(is_blog_enabled($etablissement->id) && $blogCards->isNotEmpty())
            @php
                $santeBlogSectionTitle = function_exists('get_blog_section_title')
                    ? get_blog_section_title($etablissement->id)
                    : 'Actualites';
                $santeBlogSectionTitle = trim((string) $santeBlogSectionTitle) !== '' ? $santeBlogSectionTitle : 'Actualites';
            @endphp
            <section class="hl-section" id="blog">
                <div class="container">
                    <div class="hl-head">
                        <div>
                            <div class="hl-kicker">Actualites</div>
                            <h2 class="hl-title">{{ $santeBlogSectionTitle }}</h2>
                        </div>
                    </div>
                    <div class="hl-blog-grid">
                        @foreach($blogCards as $post)
                            @php
                                $blogUrl = data_get($post, 'url') ?: '#blog';
                                $isExternalBlogUrl = !\Illuminate\Support\Str::startsWith($blogUrl, '#');
                                $blogTargetAttrs = $isExternalBlogUrl ? ' target="_blank" rel="noopener noreferrer"' : '';
                            @endphp
                            <a class="hl-blog" href="{{ $blogUrl }}"{!! $blogTargetAttrs !!}>
                                <div class="hl-blog-img">
                                    @if(data_get($post, 'image'))
                                        <img src="{{ data_get($post, 'image') }}" alt="{{ data_get($post, 'title') }}">
                                    @endif
                                </div>
                                <div class="hl-blog-body">
                                    <div class="hl-date">{{ data_get($post, 'date') ?: 'Blog' }}</div>
                                    <h3>{{ data_get($post, 'title') }}</h3>
                                    @if(data_get($post, 'excerpt'))
                                        <p>{{ \Illuminate\Support\Str::limit(strip_tags((string) data_get($post, 'excerpt')), 130) }}</p>
                                    @endif
                                    <span class="hl-blog-more">Lire la suite <i class="fa-solid fa-arrow-right"></i></span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @include('cms::web.fallback.partials.landing-working-hours')

        <section class="hl-section alt" id="contact">
            <div class="container">
                @php
                    $santeContactTitle = function_exists('get_contact_form_title')
                        ? get_contact_form_title($etablissement->id, 'Envoyer une demande')
                        : 'Envoyer une demande';
                @endphp
                <div class="hl-head">
                    <div>
                        <div class="hl-kicker">Contact</div>
                        <h2 class="hl-title">{{ $santeContactTitle }}</h2>
                    </div>
                    <p class="hl-sub">Le message est enregistre dans les contacts CMS et transmis avec les informations saisies.</p>
                </div>
                <div class="hl-contact-grid">
                    <aside class="hl-info">
                        <div class="hl-info-list">
                            @if($phone)<div class="hl-info-item"><i class="fa-solid fa-phone"></i><div><strong>Telephone</strong><a href="tel:{{ $phoneHref }}">{{ $phone }}</a></div></div>@endif
                            @if($email)<div class="hl-info-item"><i class="fa-solid fa-envelope"></i><div><strong>Courriel</strong><a href="mailto:{{ $email }}">{{ $email }}</a></div></div>@endif
                            @if($address)<div class="hl-info-item"><i class="fa-solid fa-location-dot"></i><div><strong>Adresse</strong><span>{{ $address }}</span></div></div>@endif
                            @if(!empty($workingHours))
                                <div class="hl-info-item">
                                    <i class="fa-solid fa-clock"></i>
                                    <div>
                                        <strong>Horaire</strong>
                                        <span>
                                            @foreach($workingHours as $row)
                                                {{ !empty($row['day']) ? $row['day'] . ' : ' : '' }}{{ $row['hours'] ?? '' }}
                                                @if(!$loop->last)<br>@endif
                                            @endforeach
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if($socialLinks->isNotEmpty())
                            <div class="hl-social">
                                @foreach($socialLinks as $link)
                                    <a href="{{ data_get($link, 'url') }}" target="_blank" rel="noopener noreferrer" aria-label="{{ data_get($link, 'label') }}"><i class="{{ data_get($link, 'icon') ?: 'fa-solid fa-share-nodes' }}"></i></a>
                                @endforeach
                            </div>
                        @endif
                    </aside>
                    <form class="hl-form" method="POST" action="{{ route('cms.company.contact.send', ['etablissementId' => $etablissement->id]) }}" data-cms-contact-form data-cms-form-name="landing_sante">
                        @csrf
                        <div class="hl-form-row">
                            <div class="hl-field"><label>Prenom</label><input name="first_name" type="text" required></div>
                            <div class="hl-field"><label>Nom</label><input name="last_name" type="text"></div>
                        </div>
                        <div class="hl-form-row">
                            <div class="hl-field"><label>Courriel</label><input name="email" type="email" required></div>
                            <div class="hl-field"><label>Telephone</label><input name="phone" type="tel"></div>
                        </div>
                        <div class="hl-form-row">
                            <div class="hl-field"><label>Type de demande</label><select name="service"><option>Rendez-vous</option><option>Information</option><option>Service ou produit</option><option>Suivi</option><option>Autre</option></select></div>
                            <div class="hl-field"><label>Date souhaitee</label><input name="date" type="date"></div>
                        </div>
                        <div class="hl-field"><label>Message</label><textarea name="message" required></textarea></div>
                        <button class="hl-submit" type="submit">Envoyer la demande <i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </section>

    </main>
    @include('cms::web.fallback.partials.landing-media-slideshow')

    @include('cms::web.fallback.partials.landing-cms-footer')

    <footer class="hl-footer">
        <div class="container">
            <strong>{{ $siteName }}</strong>
            <span>&copy; {{ date('Y') }} - Landing sante dynamique</span>
        </div>
    </footer>

    @include('cms::web.fallback.partials.landing-contact-ajax')

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        function hlEsc(value) {
            const div = document.createElement('div');
            div.textContent = value || '';
            return div.innerHTML;
        }

        const mapNode = document.getElementById('hlMap');
        if (mapNode && window.L) {
            const fallbackLat = Number(mapNode.dataset.lat || 46.8139);
            const fallbackLng = Number(mapNode.dataset.lng || -71.2082);
            let points = @json($mapPoints);
            if (!points.length) return;

            const map = L.map(mapNode, { scrollWheelZoom: false }).setView([Number(points[0].lat || fallbackLat), Number(points[0].lng || fallbackLng)], points.length > 1 ? 10 : 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const bounds = [];
            points.forEach(point => {
                const lat = Number(point.lat || fallbackLat);
                const lng = Number(point.lng || fallbackLng);
                bounds.push([lat, lng]);
                const popup = [
                    '<div class="hl-popup">',
                    '<h4>' + hlEsc(point.title) + '</h4>',
                    point.description ? '<p>' + hlEsc(point.description) + '</p>' : '',
                    point.image ? '<img src="' + hlEsc(point.image) + '" alt="' + hlEsc(point.title) + '" style="width:100%;height:150px;object-fit:cover;border-radius:10px;margin-bottom:10px">' : '',
                    point.video_embed ? '<iframe src="' + hlEsc(point.video_embed) + '" title="' + hlEsc(point.title) + '" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>' : '',
                    '</div>'
                ].join('');
                L.marker([lat, lng]).addTo(map).bindPopup(popup, { maxWidth: 360, minWidth: 260 });
            });

            if (bounds.length > 1) {
                map.fitBounds(bounds, { padding: [40, 40] });
            }
        }
    </script>
    @include('cms::web.fallback.partials.landing-cart-drawer')
    @include('cms::web.fallback.partials.landing-back-to-top')

    <script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-destinations-mega.js') }}"></script>
</body>
</html>
