@php
    $siteName = trim((string) (get_site_name($etablissement->id) ?: ($etablissement->name ?? 'Voyage')));
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
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteName }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        :root{--gold:#C8A96E;--gold2:#E8CFA0;--bg:#080808;--bg2:#0f0f0f;--card:#141414;--text:#F2EDE4;--muted:#A79B8A;--line:rgba(255,255,255,.1);--shadow:0 30px 80px rgba(0,0,0,.5);--tr:all .45s cubic-bezier(.23,1,.32,1)}
        [data-theme=light]{--bg:#FAF8F5;--bg2:#F2EDE4;--card:#fff;--text:#1A1410;--muted:#6A5D4D;--line:rgba(0,0,0,.09);--shadow:0 30px 80px rgba(0,0,0,.1)}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:var(--bg);color:var(--text);font-family:Jost,sans-serif;overflow-x:hidden}a{color:inherit;text-decoration:none}img,video,iframe{max-width:100%}.container{width:min(1180px,calc(100% - 40px));margin:auto}
        .tt-hero{position:relative;min-height:100vh;display:flex;align-items:flex-end;overflow:hidden;background:var(--bg2)}.tt-hero-media{position:absolute;inset:0}.tt-hero-media img,.tt-hero-media video,.tt-hero-media iframe{width:100%;height:100%;object-fit:cover;border:0}.tt-hero-media iframe{position:absolute;inset:50% auto auto 50%;width:177.78vh;height:56.25vw;min-width:100%;min-height:100%;transform:translate(-50%,-50%);pointer-events:none}.tt-hero::after{content:"";position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.9),rgba(0,0,0,.28),rgba(0,0,0,.18))}
        .tt-hero-inner{position:relative;z-index:2;padding:150px 0 90px;display:block}.tt-kicker{display:inline-flex;gap:10px;align-items:center;color:var(--gold);font-size:11px;letter-spacing:4px;text-transform:uppercase}.tt-kicker::before{content:"";width:34px;height:1px;background:var(--gold)}.tt-h1{font-family:"Cormorant Garamond",serif;font-size:clamp(52px,8vw,108px);font-weight:400;line-height:.92;margin:0 0 24px;color:#fff}.tt-h1 em{color:var(--gold);font-style:italic}.tt-desc{max-width:620px;color:rgba(255,255,255,.72);line-height:1.85;font-size:17px}.tt-hero-buttons{display:flex;gap:14px;flex-wrap:wrap;margin-top:34px}.tt-btn{display:inline-flex;align-items:center;gap:10px;border-radius:999px;padding:14px 26px;font-size:12px;letter-spacing:2px;text-transform:uppercase;font-weight:800;border:1px solid rgba(255,255,255,.2)}.tt-btn.gold{background:var(--gold);color:#120e08;border-color:var(--gold)}
        .tt-section{padding:86px 0;background:var(--bg)}.tt-section.alt{background:var(--bg2)}.tt-head{display:flex;align-items:end;justify-content:space-between;gap:30px;margin-bottom:34px}.tt-title{font-family:"Cormorant Garamond",serif;font-size:clamp(34px,4vw,58px);line-height:1;margin:0}.tt-sub{max-width:560px;color:var(--muted);line-height:1.75}
        .tt-db-grid{display:grid;gap:24px}.tt-db-card{background:var(--card);border:1px solid var(--line);border-radius:22px;padding:clamp(24px,4vw,46px);box-shadow:var(--shadow)}.tt-db-content{color:var(--muted);line-height:1.8}.tt-db-content :where(h1,h2,h3,h4,h5,h6){font-family:"Cormorant Garamond",serif;color:var(--text);line-height:1.1;margin:0 0 16px}.tt-db-content :where(p,ul,ol,blockquote,figure){margin:0 0 18px}.tt-db-content :where(img,video,iframe){border-radius:16px}
        .tt-blog-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:22px}.tt-blog{background:var(--card);border:1px solid var(--line);border-radius:20px;overflow:hidden;transition:var(--tr)}.tt-blog:hover{transform:translateY(-4px);border-color:rgba(200,169,110,.5)}.tt-blog-img{height:230px;background:var(--bg3,#222)}.tt-blog-img img{width:100%;height:100%;object-fit:cover}.tt-blog-body{padding:22px}.tt-date{font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--gold);margin-bottom:10px}.tt-blog h3{font-family:"Cormorant Garamond",serif;font-size:26px;line-height:1.1;margin:0 0 10px}.tt-blog p{color:var(--muted);line-height:1.65;margin:0}
        .tt-contact-grid{display:grid;grid-template-columns:.9fr 1.1fr;gap:34px}.tt-info,.tt-form{background:var(--card);border:1px solid var(--line);border-radius:22px;padding:30px}.tt-info-list{display:grid;gap:14px}.tt-info-item{display:grid;grid-template-columns:44px 1fr;gap:14px;align-items:start}.tt-info-item i{width:44px;height:44px;border-radius:14px;background:var(--gold);color:#120e08;display:grid;place-items:center}.tt-info-item strong{display:block;margin-bottom:3px}.tt-info-item span,.tt-info-item a{color:var(--muted);line-height:1.55}.tt-social{display:flex;gap:10px;flex-wrap:wrap;margin-top:24px}.tt-social a{width:42px;height:42px;border-radius:50%;display:grid;place-items:center;border:1px solid var(--line);color:var(--gold)}
        .tt-form{display:grid;gap:14px}.tt-form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}.tt-field label{display:block;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--muted);margin-bottom:7px}.tt-field input,.tt-field select,.tt-field textarea{width:100%;border:1px solid var(--line);background:rgba(255,255,255,.05);color:var(--text);border-radius:14px;padding:14px 15px;font:inherit}.tt-field textarea{min-height:130px;resize:vertical}.tt-submit{border:0;background:var(--gold);color:#120e08;border-radius:999px;padding:15px 24px;font-weight:900;letter-spacing:2px;text-transform:uppercase;cursor:pointer}
        .tt-map{height:520px;position:relative;background:var(--bg2)}#ttMap{height:100%;width:100%}.tt-map-card{position:absolute;left:24px;bottom:24px;z-index:500;background:var(--card);border:1px solid var(--line);border-radius:18px;padding:20px;box-shadow:var(--shadow);max-width:330px}.tt-map-card p{margin:5px 0 0;color:var(--muted)}.tt-popup{width:320px;max-width:100%}.tt-popup h4{margin:0 0 8px;color:#1A1410}.tt-popup p{margin:0 0 10px;color:#6A5D4D}.tt-popup iframe{width:100%;height:180px;border:0;border-radius:10px;display:block}
        .tt-footer{padding:42px 0;background:#050505;color:rgba(255,255,255,.7);border-top:1px solid rgba(255,255,255,.08)}.tt-footer .container{display:flex;justify-content:space-between;gap:20px;flex-wrap:wrap}.tt-footer strong{color:#fff}
        @media(max-width:900px){.tt-contact-grid{grid-template-columns:1fr}.tt-blog-grid{grid-template-columns:1fr}.tt-form-row{grid-template-columns:1fr}.tt-head{display:block}.tt-hero-inner{padding-top:130px}.tt-map{height:460px}}
    </style>
</head>
<body>
    @include('cms::web.fallback.activities.voyage.vertical-menu')
    @include('home-v2.components.Header')
    @include('cms::web.fallback.partials.landing-cms-header')

    @if(is_slider_enabled($etablissement->id))
        @if(has_slider($etablissement->id))
            {!! get_slider_html($etablissement->id) !!}
        @elseif($heroSlides->isNotEmpty())
        @php($hero = $heroSlides->first())
        <section class="tt-hero" id="top">
            <div class="tt-hero-media">
                @if(!empty($hero['embed']))
                    <iframe src="{{ $hero['embed'] }}" title="{{ $hero['title'] ?: $siteName }}" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                @elseif(($hero['type'] ?? 'image') === 'video' && !empty($hero['url']))
                    <video src="{{ $hero['url'] }}" poster="{{ $hero['poster'] }}" autoplay muted loop playsinline></video>
                @else
                    <img src="{{ $hero['url'] ?: $hero['poster'] }}" alt="{{ $hero['title'] ?: $siteName }}">
                @endif
            </div>
            <div class="container tt-hero-inner">
                <div>
                    @if(!empty($hero['title']))
                        <h1 class="tt-h1">{!! e($hero['title']) !!}</h1>
                    @endif
                    @if(!empty($hero['subtitle']))
                        <p class="tt-desc">{{ $hero['subtitle'] }}</p>
                    @elseif($siteDescription)
                        <p class="tt-desc">{{ $siteDescription }}</p>
                    @endif
                    <div class="tt-hero-buttons">
                        @if(!empty($hero['button_text']) && !empty($hero['button_url']))
                            <a class="tt-btn gold" href="{{ $hero['button_url'] }}">{{ $hero['button_text'] }} <i class="fa-solid fa-arrow-right"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        @endif
    @endif

    <main>
        @if(collect($cmsPageSections ?? [])->isNotEmpty())
                        @foreach(collect($cmsPageSections) as $cmsPage)
                                    {!! data_get($cmsPage, 'content') !!}
                        @endforeach
        @endif

        @if($cmsLandingProducts->isNotEmpty())
            <section class="tt-section alt" id="offres">
                <div class="container">
                    @include('cms::web.fallback.partials.establishment-products', [
                        'cmsLandingProducts' => $cmsLandingProducts,
                        'cmsProductsLimit' => 8,
                        'cmsProductsSectionId' => 'offres-tourisme',
                        'cmsProductsTitle' => 'Offres et expÃ©riences disponibles',
                        'cmsProductsSubtitle' => 'Les produits et forfaits publiÃ©s par cet Ã©tablissement sont affichÃ©s automatiquement.'
                    ])
                </div>
            </section>
        @endif

        @if(is_blog_enabled($etablissement->id) && $blogCards->isNotEmpty())
            <section class="tt-section" id="blog">
                <div class="container">
                    <div class="tt-head">
                        <div>
                            <div class="tt-kicker">ActualitÃ©s</div>
                        </div>
                    </div>
                    <div class="tt-blog-grid">
                        @foreach($blogCards as $post)
                            <a class="tt-blog" href="{{ data_get($post, 'url') ?: '#blog' }}">
                                <div class="tt-blog-img">
                                    @if(data_get($post, 'image'))
                                        <img src="{{ data_get($post, 'image') }}" alt="{{ data_get($post, 'title') }}">
                                    @endif
                                </div>
                                <div class="tt-blog-body">
                                    <div class="tt-date">{{ data_get($post, 'date') ?: 'Blog' }}</div>
                                    <h3>{{ data_get($post, 'title') }}</h3>
                                    @if(data_get($post, 'excerpt'))
                                        <p>{{ \Illuminate\Support\Str::limit(strip_tags((string) data_get($post, 'excerpt')), 130) }}</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @include('cms::web.fallback.partials.landing-working-hours')

        <section class="tt-section alt" id="contact">
            <div class="container">
                <div class="tt-head">
                    <div>
                        <div class="tt-kicker">Contact</div>
                        <h2 class="tt-title">PrÃ©parer une demande</h2>
                    </div>
                    <p class="tt-sub">Envoyez votre demande directement Ã  lâ€™Ã©tablissement. Le message est enregistrÃ© dans les contacts CMS.</p>
                </div>
                <div class="tt-contact-grid">
                    <aside class="tt-info">
                        <div class="tt-info-list">
                            @if($phone)<div class="tt-info-item"><i class="fa-solid fa-phone"></i><div><strong>TÃ©lÃ©phone</strong><a href="tel:{{ $phoneHref }}">{{ $phone }}</a></div></div>@endif
                            @if($email)<div class="tt-info-item"><i class="fa-solid fa-envelope"></i><div><strong>Courriel</strong><a href="mailto:{{ $email }}">{{ $email }}</a></div></div>@endif
                            @if($address)<div class="tt-info-item"><i class="fa-solid fa-location-dot"></i><div><strong>Adresse</strong><span>{{ $address }}</span></div></div>@endif
                            @if(!empty($workingHours))<div class="tt-info-item"><i class="fa-solid fa-clock"></i><div><strong>Horaire</strong><span>@foreach($workingHours as $row){{ !empty($row['day']) ? $row['day'] . ' : ' : '' }}{{ $row['hours'] ?? '' }}@if(!$loop->last)<br>@endif @endforeach</span></div></div>@endif
                        </div>
                        @if($socialLinks->isNotEmpty())
                            <div class="tt-social">
                                @foreach($socialLinks as $link)
                                    <a href="{{ data_get($link, 'url') }}" target="_blank" rel="noopener noreferrer" aria-label="{{ data_get($link, 'label') }}"><i class="{{ data_get($link, 'icon') ?: 'fa-solid fa-share-nodes' }}"></i></a>
                                @endforeach
                            </div>
                        @endif
                    </aside>
                    <form class="tt-form" method="POST" action="{{ route('cms.company.contact.send', ['etablissementId' => $etablissement->id]) }}" data-cms-contact-form data-cms-form-name="landing_tourisme">
                        @csrf
                        <div class="tt-form-row">
                            <div class="tt-field"><label>PrÃ©nom</label><input name="first_name" type="text" required></div>
                            <div class="tt-field"><label>Nom</label><input name="last_name" type="text"></div>
                        </div>
                        <div class="tt-form-row">
                            <div class="tt-field"><label>Courriel</label><input name="email" type="email" required></div>
                            <div class="tt-field"><label>TÃ©lÃ©phone</label><input name="phone" type="tel"></div>
                        </div>
                        <div class="tt-form-row">
                            <div class="tt-field"><label>Type de demande</label><select name="service"><option>Forfait ou circuit</option><option>HÃ©bergement</option><option>ActivitÃ© touristique</option><option>Groupe ou Ã©vÃ©nement</option><option>Autre</option></select></div>
                            <div class="tt-field"><label>Date souhaitÃ©e</label><input name="date" type="date"></div>
                        </div>
                        <div class="tt-field"><label>Message</label><textarea name="message" required placeholder="DÃ©crivez votre besoin, vos dates, le nombre de voyageurs ou vos questions."></textarea></div>
                        <button class="tt-submit" type="submit">Envoyer la demande <i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </section>

        @include('cms::web.fallback.partials.landing-map-video-points')
    </main>

    @if(is_slideshow_enabled($etablissement->id) && has_slider($etablissement->id))
        {!! get_slider_html($etablissement->id) !!}
    @endif
    @include('cms::web.fallback.partials.landing-media-slideshow')

    <footer class="tt-footer">
        <div class="container">
            <strong>{{ $siteName }}</strong>
            <span>Â© {{ date('Y') }} Â· Landing tourisme dynamique</span>
        </div>
    </footer>

    @include('cms::web.fallback.partials.landing-contact-ajax')

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        function ttEsc(value) {
            const div = document.createElement('div');
            div.textContent = value || '';
            return div.innerHTML;
        }

        const mapNode = document.getElementById('ttMap');
        if (mapNode && window.L) {
            const fallbackLat = Number(mapNode.dataset.lat || 46.8139);
            const fallbackLng = Number(mapNode.dataset.lng || -71.2082);
            let points = @json($mapPoints);
            if (!points.length) {
                points = [{ title: '{{ addslashes($siteName) }}', description: '{{ addslashes($address) }}', lat: fallbackLat, lng: fallbackLng }];
            }

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
                    '<div class="tt-popup">',
                    '<h4>' + ttEsc(point.title) + '</h4>',
                    point.description ? '<p>' + ttEsc(point.description) + '</p>' : '',
                    point.image ? '<img src="' + ttEsc(point.image) + '" alt="' + ttEsc(point.title) + '" style="width:100%;height:150px;object-fit:cover;border-radius:10px;margin-bottom:10px">' : '',
                    point.video_embed ? '<iframe src="' + ttEsc(point.video_embed) + '" title="' + ttEsc(point.title) + '" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>' : '',
                    '</div>'
                ].join('');
                L.marker([lat, lng]).addTo(map).bindPopup(popup, { maxWidth: 360, minWidth: 260 });
            });

            if (bounds.length > 1) {
                map.fitBounds(bounds, { padding: [40, 40] });
            }
        }
    </script>
    @include('cms::web.fallback.partials.landing-cms-footer')
    @include('cms::web.fallback.partials.landing-back-to-top')
</body>
</html>
