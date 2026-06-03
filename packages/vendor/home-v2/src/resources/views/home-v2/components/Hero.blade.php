@php
    $tr = static function (string $text): string {
        $locale = app()->getLocale();
        if ($locale === 'fr') {
            return $text;
        }

        static $maps = [];
        if (! array_key_exists($locale, $maps)) {
            $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
            $maps[$locale] = is_file($path) ? (require $path) : [];
        }

        return $maps[$locale][$text] ?? $text;
    };

    $assetUrl = static function ($value) {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        if (\Illuminate\Support\Str::startsWith($value, ['http://', 'https://', '//'])) {
            return $value;
        }

        if (\Illuminate\Support\Str::startsWith($value, ['/storage/'])) {
            return asset(ltrim($value, '/'));
        }

        if (\Illuminate\Support\Str::startsWith($value, ['storage/', 'home2/'])) {
            return asset($value);
        }

        if (\Illuminate\Support\Str::startsWith($value, ['/'])) {
            return asset(ltrim($value, '/'));
        }

        return asset('storage/' . ltrim($value, '/'));
    };

    $youtubeIdFromUrl = static function ($value) {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/i', $value, $match)) {
            $value = trim((string) $match[1]);
        }

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|live\/|embed\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $value, $match)) {
            return $match[1];
        }

        return preg_match('/^[A-Za-z0-9_-]{11}$/', $value) ? $value : null;
    };

    $vimeoIdFromUrl = static function ($value) {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/i', $value, $match)) {
            return $match[1];
        }

        return null;
    };

    $isImageUrl = static function ($value): bool {
        $value = trim((string) $value);
        if ($value === '') {
            return false;
        }

        return (bool) preg_match('/\.(jpg|jpeg|png|gif|webp|avif|svg)(\?.*)?$/i', $value);
    };

    $destinationContext = $destinationContext ?? null;
    $destinationBreadcrumbPath = [];
    $destinationBreadcrumbItems = collect($destinationContext['breadcrumb'] ?? [])->map(function ($item) use (&$destinationBreadcrumbPath) {
        $destinationBreadcrumbPath[] = $item['slug'] ?? \Illuminate\Support\Str::slug($item['name'] ?? '');

        return [
            'name' => $item['name'] ?? '',
            'url' => url('/' . implode('/', array_filter($destinationBreadcrumbPath))),
        ];
    })->filter(fn ($item) => ! empty($item['name']))->values();

    $heroPlaceholderPhrases = [
        $tr('Explorez le monde...'),
        $tr('Rechercher une destination...'),
        $tr('Decouvrez des activites...'),
        $tr('Trouvez un hebergement...'),
    ];

    $heroSlides = collect($sliders ?? [])->sortBy('order')->values()->map(function ($slider, $index) use ($assetUrl, $youtubeIdFromUrl, $vimeoIdFromUrl, $isImageUrl) {
        $type = strtolower((string) data_get($slider, 'type', 'image')) === 'video' ? 'video' : 'image';
        $videoRaw = data_get($slider, 'video_url') ?: data_get($slider, 'video_embed_url') ?: data_get($slider, 'video_path');
        $imageRaw = data_get($slider, 'image_url') ?: data_get($slider, 'image_path');
        $thumbRaw = data_get($slider, 'thumbnail_url') ?: data_get($slider, 'thumbnail_path') ?: $imageRaw;
        $media = $type === 'video' ? ($videoRaw ?: $imageRaw) : $imageRaw;
        $mediaUrl = $assetUrl($media);
        $poster = $assetUrl($thumbRaw);
        $youtubeId = $youtubeIdFromUrl($mediaUrl ?: $media);
        $vimeoId = $vimeoIdFromUrl($mediaUrl ?: $media);
        $videoType = data_get($slider, 'video_type') ?: ($youtubeId ? 'youtube' : ($vimeoId ? 'vimeo' : 'upload'));

        if ($poster && ! $isImageUrl($poster)) {
            $poster = null;
        }

        if (!$poster && $youtubeId) {
            $poster = 'https://img.youtube.com/vi/' . $youtubeId . '/maxresdefault.jpg';
        }

        if (!$poster && $type === 'image') {
            $poster = $mediaUrl;
        }

        return [
            'title' => data_get($slider, 'name') ?: data_get($slider, 'title') ?: ('Video ' . ($index + 1)),
            'description' => data_get($slider, 'description') ?: data_get($slider, 'subtitle') ?: '',
            'type' => $type,
            'video_type' => $videoType,
            'media' => $mediaUrl,
            'poster' => $poster,
            'youtube_id' => $youtubeId,
            'vimeo_id' => $vimeoId,
            'button_text' => data_get($slider, 'button_text'),
            'button_url' => data_get($slider, 'button_url'),
            'badge' => data_get($slider, 'settings.badge') ?: ($type === 'video' ? 'Video' : 'Image'),
        ];
    })->filter(fn ($slide) => ! empty($slide['media']) || ! empty($slide['poster']))->values();

    $hasHeroSlides = $heroSlides->isNotEmpty();
    $heroId = 'goHomeHero' . substr(md5((string) request()->fullUrl()), 0, 8);
@endphp

@once
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endonce

<section class="hero-v2 go-home-hero {{ $hasHeroSlides ? '' : 'go-home-hero--empty' }}" id="{{ $heroId }}" @if(!$hasHeroSlides && ($hideSearchBarV2 ?? false)) style="display:none" @endif>
    @if($hasHeroSlides)
        <div class="hero-swiper swiper">
            <div class="swiper-wrapper">
                @foreach($heroSlides as $slide)
                    @php
                        $isVideo = ($slide['type'] ?? 'image') === 'video';
                        $youtubeId = $slide['youtube_id'] ?? null;
                        $vimeoId = $slide['vimeo_id'] ?? null;
                        $youtubeSrc = $youtubeId
                            ? 'https://www.youtube.com/embed/' . $youtubeId . '?autoplay=1&mute=1&loop=1&playlist=' . $youtubeId . '&controls=0&showinfo=0&rel=0&modestbranding=1&iv_load_policy=3&playsinline=1&vq=hd1080&hd=1'
                            : null;
                        $vimeoSrc = $vimeoId
                            ? 'https://player.vimeo.com/video/' . $vimeoId . '?autoplay=1&muted=1&loop=1&background=1'
                            : null;
                        $ctaUrl = trim((string) ($slide['button_url'] ?? ''));
                        $ctaText = trim((string) ($slide['button_text'] ?? ''));
                    @endphp
                    <div class="swiper-slide">
                        <div class="go-hero-media" @if(!empty($slide['poster'])) style="background-image:url('{{ $slide['poster'] }}')" @endif>
                            @if($isVideo && $youtubeSrc)
                                <iframe class="go-hero-youtube" src="{{ $youtubeSrc }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="{{ $loop->first ? 'eager' : 'lazy' }}"></iframe>
                            @elseif($isVideo && $vimeoSrc)
                                <iframe class="go-hero-youtube" src="{{ $vimeoSrc }}" frameborder="0" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen loading="{{ $loop->first ? 'eager' : 'lazy' }}"></iframe>
                            @elseif($isVideo && !empty($slide['media']))
                                <video class="go-hero-local-video" autoplay muted loop playsinline preload="{{ $loop->first ? 'auto' : 'metadata' }}" @if(!empty($slide['poster'])) poster="{{ $slide['poster'] }}" @endif>
                                    <source src="{{ $slide['media'] }}" type="video/mp4">
                                </video>
                            @elseif(!empty($slide['media']))
                                <img class="go-hero-image" src="{{ $slide['media'] }}" alt="{{ $slide['title'] }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                            @endif
                        </div>
                        <div class="go-hero-content">
                            <h1 class="go-hero-title">{{ $slide['title'] }}</h1>
                            @if(!empty($slide['description']))
                                <p class="go-hero-description">{{ $slide['description'] }}</p>
                            @endif
                            @if($ctaUrl !== '' && $ctaText !== '')
                                <a class="go-hero-cta" href="{{ $ctaUrl }}" target="_blank" rel="noopener noreferrer">
                                    {{ $ctaText }} <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($heroSlides->count() > 1)
                <button class="swiper-button-prev" type="button" aria-label="{{ $tr('Precedent') }}">
                    <i class="fas fa-chevron-left" aria-hidden="true"></i>
                </button>
                <button class="swiper-button-next" type="button" aria-label="{{ $tr('Suivant') }}">
                    <i class="fas fa-chevron-right" aria-hidden="true"></i>
                </button>
            @endif
        </div>
    @endif

    @if($heroSlides->count() > 1)
        <div class="go-hero-thumbs-shell" aria-label="{{ $tr('Selection videos') }}">
            <button class="go-hero-thumb-nav go-hero-thumb-prev" type="button" aria-label="{{ $tr('Videos precedentes') }}">
                <i class="fas fa-chevron-left" aria-hidden="true"></i>
            </button>
            <div class="go-hero-thumbnails swiper">
                <div class="swiper-wrapper">
                    @foreach($heroSlides as $slide)
                        <button class="go-hero-thumbnail swiper-slide {{ $loop->first ? 'active' : '' }}" type="button" data-index="{{ $loop->index }}">
                            <span class="go-hero-thumbnail-img">
                                <i class="fas fa-play-circle" aria-hidden="true"></i>
                                @if(!empty($slide['poster']))
                                    <img src="{{ $slide['poster'] }}" alt="{{ $slide['title'] }}" loading="lazy">
                                @endif
                            </span>
                            <span class="go-hero-thumbnail-info">
                                <strong>{{ $slide['title'] }}</strong>
                                <small>{{ $slide['badge'] ?? 'Video' }}</small>
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>
            <button class="go-hero-thumb-nav go-hero-thumb-next" type="button" aria-label="{{ $tr('Videos suivantes') }}">
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
            </button>
        </div>
    @endif

    @if(!($hideSearchBarV2 ?? false))
        <div class="go-hero-search-layer">
            <div class="search-bar-v2">
                <div class="search-bar-v2-container">
                    <div class="search-bar-v2-destinations">
                        @if($destinationBreadcrumbItems->isNotEmpty())
                            <nav class="search-bar-v2-destination-breadcrumb" aria-label="{{ $tr('Fil d Ariane destination') }}">
                                @foreach($destinationBreadcrumbItems as $breadcrumbItem)
                                    <a href="{{ $breadcrumbItem['url'] }}">{{ $breadcrumbItem['name'] }}</a>
                                    @if(! $loop->last)
                                        <span>/</span>
                                    @endif
                                @endforeach
                            </nav>
                        @endif
                        <img src="{{ asset('REDI.png') }}" alt="Destinations" class="search-bar-v2-globe-icon" id="destinationsMainTrigger" style="cursor:pointer;">
                        <span class="search-bar-v2-destinations-title" id="destinationsBreadcrumb">{{ $tr('Destinations') }}</span>
                        @include('home-v2.components.DestinationsMegaMenu')
                    </div>

                    <div class="search-bar-v2-quick-links">
                        <div class="quick-link-item info-trigger" id="infoTrigger" title="{{ $tr('Informations') }}">
                            <div class="icon-circle icon-blue"><span class="picto-label">i</span></div>
                        </div>
                        <div class="quick-link-item" id="catMegaTriggerTourisme" style="cursor:pointer;" title="{{ $tr('Activites Tourisme') }}">
                            <div class="icon-circle icon-blue"><span class="picto-label">iT</span></div>
                        </div>
                        <div class="quick-link-item" id="catMegaTriggerBusiness" style="cursor:pointer;" title="{{ $tr('Activites Business') }}">
                            <div class="icon-circle icon-blue"><span class="picto-label">iB</span></div>
                        </div>
                    </div>

                    <div class="search-bar-v2-search">
                        <div class="search-bar-v2-input-wrapper">
                            <svg class="search-bar-v2-search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                            <input type="text" class="search-bar-v2-input" id="searchBarInput" placeholder="{{ $tr('Rechercher une destination, activite, hebergement...') }}" aria-label="{{ $tr('Rechercher une destination') }}" autocomplete="off">
                            <button class="search-bar-v2-clear-btn" id="searchBarClearBtn" aria-label="{{ $tr('Effacer') }}">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        <div class="search-bar-v2-results" id="searchBarResults">
                            <div class="search-bar-v2-results-header">
                                <h4 class="search-bar-v2-results-title">{{ $tr('Resultats de la recherche') }}</h4>
                            </div>
                            <ul class="search-bar-v2-results-list" id="searchBarResultsList"></ul>
                        </div>
                    </div>

                    <div class="search-bar-v2-quick-links search-bar-v2-quick-links--post">
                        <div class="quick-link-item" id="quickLinkEE" style="cursor:pointer;" title="{{ $tr('Espace Entreprise') }}"><div class="icon-circle icon-blue"><span class="picto-label">EE</span></div></div>
                        <div class="quick-link-item" id="quickLinkED" style="cursor:pointer;" title="{{ $tr('Espace Destination') }}"><div class="icon-circle icon-blue"><span class="picto-label">ED</span></div></div>
                        <div class="quick-link-item" id="quickLinkMP" style="cursor:pointer;" title="{{ $tr('Marketplace') }}"><div class="icon-circle icon-blue"><span class="picto-label">MP</span></div></div>
                        <div class="quick-link-item" id="quickLinkCar" style="cursor:pointer;" title="{{ $tr('Location Vehicule') }}"><div class="icon-circle icon-blue"><i class="fas fa-car picto-icon"></i></div></div>
                        <div class="quick-link-item" id="quickLinkPlane" style="cursor:pointer;" title="{{ $tr('Billets Avion') }}"><div class="icon-circle icon-blue"><i class="fas fa-plane picto-icon"></i></div></div>
                    </div>

                    <div class="search-bar-v2-brand" id="planNGoTrigger" style="cursor:pointer;" title="{{ $tr('Plan & GO') }}">
                        <img src="{{ asset('plan-n-go.png') }}" alt="PLAN-N-GO" class="search-bar-v2-logo">
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>

@include('home-v2.components.InfoMegaMenu')
@include('home-v2.components.CategoriesMegaMenu')
@include('home-v2.components.HeroQuickMegaMenus')

<style>
    .go-home-hero {
        position: relative;
        width: 100%;
        height: 100vh;
        min-height: 660px;
        margin-top: 0 !important;
        padding-top: 0 !important;
        overflow: hidden;
        background: #000;
        font-family: 'Montserrat', 'Arial', sans-serif;
    }

    .go-home-hero--empty {
        height: auto;
        min-height: 108px;
        overflow: visible;
        background: transparent;
    }

    .go-home-hero--empty .go-hero-search-layer {
        position: relative;
        top: auto;
        padding: 18px;
    }

    .go-home-hero .hero-swiper,
    .go-home-hero .hero-swiper > .swiper-wrapper,
    .go-home-hero .hero-swiper > .swiper-wrapper > .swiper-slide {
        width: 100%;
        height: 100%;
    }

    .go-home-hero .hero-swiper > .swiper-wrapper > .swiper-slide {
        position: relative;
        overflow: hidden;
    }

    .go-home-hero .hero-swiper > .swiper-wrapper > .swiper-slide::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 5;
        background: linear-gradient(0deg, rgba(0,0,0,.58), rgba(0,0,0,.22));
        pointer-events: none;
    }

    .go-hero-media {
        position: absolute;
        inset: 0;
        overflow: hidden;
        background: #000 center / cover no-repeat;
    }

    .go-hero-local-video,
    .go-hero-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .go-hero-youtube {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 177.78vh;
        height: 56.25vw;
        min-width: 100%;
        min-height: 100%;
        transform: translate(-50%, -50%);
        border: 0;
        pointer-events: none;
    }

    .go-hero-content {
        position: absolute;
        z-index: 10;
        top: 49%;
        left: 50%;
        width: min(88%, 780px);
        transform: translate(-50%, -50%);
        color: #fff;
        text-align: center;
        text-shadow: 0 2px 10px rgba(0,0,0,.3);
    }

    .go-hero-title {
        margin: 0 0 16px;
        font-size: 35px;
        font-weight: 800;
        line-height: 1.05;
        letter-spacing: 0;
        color: #fff;
    }

    .go-hero-description {
        margin: 0 auto 28px;
        max-width: 720px;
        font-size: clamp(1rem, 2vw, 1.45rem);
        line-height: 1.6;
        color: rgba(255,255,255,.92);
    }

    .go-hero-cta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 34px;
        color: #fff;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 999px;
        font-weight: 700;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: transform .25s ease, box-shadow .25s ease, gap .25s ease;
    }

    .go-hero-cta:focus,
    .go-hero-cta:hover {
        gap: 15px;
        color: #fff;
        text-decoration: none;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,.32);
    }

    .go-home-hero .swiper-button-prev,
    .go-home-hero .swiper-button-next {
        width: 56px;
        height: 56px;
        color: #fff;
        background: rgba(255,255,255,.15);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 50%;
        z-index: 30;
        transition: transform .25s ease, background .25s ease, box-shadow .25s ease;
    }

    .go-home-hero .swiper-button-prev { left: 30px; }
    .go-home-hero .swiper-button-next { right: 30px; }
    .go-home-hero .swiper-button-prev::after,
    .go-home-hero .swiper-button-next::after { display: none; }
    .go-home-hero .swiper-button-prev i,
    .go-home-hero .swiper-button-next i { font-size: 24px; }

    .go-home-hero .swiper-button-prev:hover,
    .go-home-hero .swiper-button-next:hover {
        background: rgba(102,126,234,.9);
        transform: scale(1.08);
        box-shadow: 0 8px 25px rgba(102,126,234,.38);
    }

    .go-hero-thumbs-shell {
        position: absolute;
        left: 50%;
        bottom: 24px;
        z-index: 35;
        display: grid;
        grid-template-columns: 42px minmax(0, 648px) 42px;
        align-items: center;
        gap: 12px;
        width: min(92vw, 756px);
        transform: translateX(-50%);
    }

    .go-hero-thumbnails {
        width: 100%;
        overflow: hidden;
    }

    .go-hero-thumbnails .swiper-wrapper {
        align-items: stretch;
    }

    .go-hero-thumb-nav {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        padding: 0;
        color: #fff;
        background: rgba(5,15,35,.68);
        border: 1px solid rgba(255,255,255,.28);
        border-radius: 50%;
        backdrop-filter: blur(8px);
        cursor: pointer;
        box-shadow: 0 8px 22px rgba(0,0,0,.28);
        transition: transform .2s ease, background .2s ease, border-color .2s ease;
    }

    .go-hero-thumb-nav:hover {
        transform: translateY(-1px);
        background: rgba(102,126,234,.9);
        border-color: rgba(255,255,255,.45);
    }

    .go-hero-thumb-nav.swiper-button-disabled {
        opacity: .38;
        cursor: default;
        pointer-events: none;
    }

    .go-hero-thumbnail {
        display: block;
        width: auto;
        height: auto;
        padding: 0;
        overflow: hidden;
        color: #fff;
        text-align: left;
        background: rgba(0,0,0,.7);
        backdrop-filter: blur(10px);
        border: 2px solid transparent;
        border-radius: 10px;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0,0,0,.3);
        transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease;
    }

    .go-hero-thumbnail:hover {
        transform: translateY(-3px);
        border-color: rgba(255,255,255,.32);
    }

    .go-hero-thumbnail.active {
        border-color: #667eea;
        transform: translateY(-3px);
        box-shadow: 0 0 20px rgba(102,126,234,.5);
    }

    .go-hero-thumbnail-img {
        position: relative;
        display: block;
        width: 100%;
        height: 80px;
        overflow: hidden;
        background: #111;
    }

    .go-hero-thumbnail-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .25s ease;
    }

    .go-hero-thumbnail:hover .go-hero-thumbnail-img img {
        transform: scale(1.1);
    }

    .go-hero-thumbnail-img i {
        position: absolute;
        z-index: 2;
        top: 50%;
        left: 50%;
        color: #fff;
        font-size: 24px;
        opacity: .85;
        transform: translate(-50%, -50%);
        text-shadow: 0 0 10px rgba(0,0,0,.55);
    }

    .go-hero-thumbnail-info {
        display: block;
        padding: 8px 10px;
    }

    .go-hero-thumbnail-info strong,
    .go-hero-thumbnail-info small {
        display: block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .go-hero-thumbnail-info strong {
        font-size: 12px;
        font-weight: 700;
    }

    .go-hero-thumbnail-info small {
        margin-top: 3px;
        font-size: 10px;
        opacity: .7;
    }

    .go-hero-search-layer {
        position: absolute;
        left: 0;
        right: 0;
        top: 24px;
        bottom: auto;
        z-index: 36;
        padding: 0 18px;
    }

    .go-home-hero .search-bar-v2 {
        width: min(1180px, 100%);
        margin: 0 auto;
        background: rgba(5,15,35,.62);
        backdrop-filter: blur(10px);
    }

    @media (max-width: 1024px) {
        .go-hero-search-layer {
            top: 18px;
            z-index: 40;
        }

        .go-home-hero .search-bar-v2 {
            display: block !important;
            opacity: 1 !important;
            position: relative !important;
            top: auto !important;
            left: auto !important;
            width: min(100%, 760px) !important;
            height: auto !important;
            padding: 10px 0 !important;
            margin: 0 auto !important;
            transform: none !important;
            background: rgba(5,15,35,.72) !important;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 18px;
            box-shadow: 0 14px 34px rgba(0,0,0,.28);
        }

        .go-home-hero .search-bar-v2-container {
            display: grid !important;
            grid-template-columns: auto minmax(0, 1fr) auto;
            align-items: center;
            gap: 10px !important;
            width: 100%;
            max-width: 100%;
            padding: 0 12px !important;
        }

        .go-home-hero .search-bar-v2-destinations {
            min-width: 0;
            width: auto !important;
            max-width: none !important;
            padding: 0 !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 6px !important;
        }

        .go-home-hero .search-bar-v2-globe-icon {
            display: block !important;
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
        }

        .go-home-hero .search-bar-v2-destinations-title,
        .go-home-hero .search-bar-v2-destination-breadcrumb,
        .go-home-hero .search-bar-v2-brand,
        .go-home-hero .search-bar-v2-quick-links {
            display: none !important;
        }

        .go-home-hero .search-bar-v2-search {
            order: initial !important;
            min-width: 0 !important;
            width: 100% !important;
            max-width: none !important;
            padding: 0 !important;
        }

        .go-home-hero .search-bar-v2-input-wrapper {
            min-height: 42px;
            padding: 8px 12px !important;
            border-radius: 999px;
        }

        .go-home-hero .search-bar-v2-input {
            min-width: 0;
            font-size: 13px !important;
        }

        .go-home-hero .search-bar-v2-results {
            left: 50% !important;
            top: calc(100% + 10px) !important;
            width: min(92vw, 560px) !important;
            max-height: min(58vh, 420px);
            transform: translateX(-50%) !important;
            overflow: hidden;
        }

        .go-hero-thumbs-shell {
            bottom: 18px;
            grid-template-columns: 38px minmax(0, 1fr) 38px;
            gap: 10px;
        }
    }

    @media (max-width: 768px) {
        .main-content {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .go-home-hero {
            height: calc(100vh - 76px) !important;
            min-height: 560px !important;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .go-hero-content {
            top: 52%;
            width: min(92%, 620px);
        }

        .go-hero-search-layer {
            top: 84px;
        }

        .go-home-hero .swiper-button-prev,
        .go-home-hero .swiper-button-next {
            width: 42px;
            height: 42px;
        }

        .go-home-hero .swiper-button-prev { left: 15px; }
        .go-home-hero .swiper-button-next { right: 15px; }
        .go-home-hero .swiper-button-prev i,
        .go-home-hero .swiper-button-next i { font-size: 18px; }

        .go-hero-cta {
            padding: 11px 24px;
            font-size: .9rem;
        }

        .go-hero-thumbnail-img {
            height: 64px;
        }

        .go-hero-thumbnail-info strong {
            font-size: 10px;
        }

        .go-hero-thumb-nav {
            width: 38px;
            height: 38px;
        }
    }

    @media (max-width: 560px) {
        .go-home-hero {
            height: calc(100vh - 74px) !important;
            min-height: 540px !important;
        }

        .go-hero-search-layer {
            top: 82px;
            padding: 0 10px;
        }

        .go-home-hero .search-bar-v2 {
            border-radius: 15px;
            padding: 8px 0 !important;
        }

        .go-home-hero .search-bar-v2-container {
            grid-template-columns: minmax(0, 1fr);
            padding: 0 10px !important;
        }

        .go-home-hero .search-bar-v2-destinations {
            display: none !important;
        }

        .go-home-hero .search-bar-v2-input-wrapper {
            min-height: 40px;
            padding: 8px 11px !important;
        }

        .go-home-hero .search-bar-v2-search-icon {
            width: 17px;
            height: 17px;
        }

        .go-home-hero .search-bar-v2-input {
            font-size: 12px !important;
        }

        .go-home-hero .search-bar-v2-input::placeholder {
            font-size: 12px !important;
        }

        .go-hero-content {
            top: 57%;
            width: min(88%, 360px);
        }

        .go-hero-title {
            font-size: 26px;
            line-height: 1.12;
            overflow-wrap: anywhere;
        }

        .go-hero-description {
            display: none;
        }

        .go-hero-thumbs-shell {
            grid-template-columns: 30px minmax(0, 1fr) 30px;
            gap: 6px;
            width: min(96vw, 420px);
            bottom: 10px;
        }

        .go-hero-thumb-nav {
            width: 30px;
            height: 30px;
        }

        .go-hero-thumbnail-img {
            height: 58px;
        }

        .go-hero-thumbnail-info {
            padding: 7px 8px;
        }
    }

    @media (max-width: 390px) {
        .go-hero-title {
            font-size: 23px;
        }

        .go-hero-content {
            top: 56%;
        }
    }
</style>

@once
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endonce

<script>
document.addEventListener('DOMContentLoaded', function () {
    const root = document.getElementById(@json($heroId));
    if (!root || typeof Swiper === 'undefined') return;

    const heroSwiperEl = root.querySelector('.hero-swiper');
    if (!heroSwiperEl) return;

    const heroSlideDelayMs = 30000;
    const swiper = new Swiper(heroSwiperEl, {
        loop: {{ $heroSlides->count() > 1 ? 'true' : 'false' }},
        autoplay: {
            delay: heroSlideDelayMs,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        effect: 'slide',
        speed: 800,
        navigation: {
            nextEl: root.querySelector('.swiper-button-next'),
            prevEl: root.querySelector('.swiper-button-prev')
        },
        keyboard: { enabled: true }
    });

    const thumbnails = Array.from(root.querySelectorAll('.go-hero-thumbnail'));
    const thumbsEl = root.querySelector('.go-hero-thumbnails');
    const thumbsSwiper = thumbsEl ? new Swiper(thumbsEl, {
        slidesPerView: 2,
        spaceBetween: 10,
        watchOverflow: true,
        navigation: {
            nextEl: root.querySelector('.go-hero-thumb-next'),
            prevEl: root.querySelector('.go-hero-thumb-prev')
        },
        breakpoints: {
            480: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 12
            },
            1100: {
                slidesPerView: 4,
                spaceBetween: 14
            }
        }
    }) : null;

    swiper.on('slideChange', function () {
        thumbnails.forEach(function (thumb, index) {
            thumb.classList.toggle('active', index === swiper.realIndex);
        });
        if (thumbsSwiper) {
            thumbsSwiper.slideTo(swiper.realIndex);
        }
    });

    thumbnails.forEach(function (thumb, index) {
        thumb.addEventListener('click', function () {
            swiper.slideToLoop(index);
            if (thumbsSwiper) {
                thumbsSwiper.slideTo(index);
            }
            if (swiper.autoplay) {
                swiper.autoplay.stop();
                swiper.autoplay.start();
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const infoBtn = document.getElementById('infoTrigger');
    const megaMenu = document.getElementById('infoMegaMenuV2');
    if (!infoBtn || !megaMenu) return;

    function positionMegaMenu() {
        if (window.innerWidth > 1025 && megaMenu.classList.contains('active')) {
            const rect = infoBtn.getBoundingClientRect();
            megaMenu.style.top = (rect.bottom + 15) + 'px';
        } else {
            megaMenu.style.top = '';
        }
    }

    infoBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const isOpen = megaMenu.classList.contains('active');
        megaMenu.classList.toggle('active', !isOpen);
        infoBtn.classList.toggle('active', !isOpen);
        if (!isOpen) positionMegaMenu();
    });

    document.addEventListener('click', function(e) {
        if (!infoBtn.contains(e.target) && !megaMenu.contains(e.target)) {
            megaMenu.classList.remove('active');
            infoBtn.classList.remove('active');
        }
    });

    window.addEventListener('resize', positionMegaMenu);
    window.addEventListener('scroll', positionMegaMenu);
});

document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('searchBarInput');
    if (!input) return;

    const phrases = @json($heroPlaceholderPhrases);
    let phraseIdx = 0;
    let charIdx = 0;
    let isDeleting = false;

    function tick() {
        if (input.value && !input.dataset.animating) return;
        const phrase = phrases[phraseIdx] || '';
        if (!isDeleting) {
            charIdx++;
            input.placeholder = phrase.substring(0, charIdx);
            if (charIdx === phrase.length) {
                isDeleting = true;
                return setTimeout(tick, 2000);
            }
            return setTimeout(tick, 70);
        }

        charIdx--;
        input.placeholder = phrase.substring(0, charIdx);
        if (charIdx === 0) {
            isDeleting = false;
            phraseIdx = (phraseIdx + 1) % phrases.length;
            return setTimeout(tick, 500);
        }
        setTimeout(tick, 40);
    }

    input.dataset.animating = '1';
    tick();

    input.addEventListener('input', function() {
        if (input.value.length > 0) {
            delete input.dataset.animating;
            input.placeholder = @json($tr('Rechercher...'));
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const searchBar = document.querySelector('.hero-v2 .search-bar-v2');
    const header = document.querySelector('.header-v2');
    if (!searchBar || !header) return;

    const spacer = document.createElement('div');
    spacer.style.display = 'none';
    searchBar.insertAdjacentElement('afterend', spacer);
    let stickyStart = 0;

    function measureStickyStart() {
        const wasFloating = searchBar.classList.contains('search-bar-v2-floating');
        if (wasFloating) {
            searchBar.classList.remove('search-bar-v2-floating');
            searchBar.style.top = '';
            spacer.style.display = 'none';
            spacer.style.height = '0px';
        }

        stickyStart = searchBar.getBoundingClientRect().top + window.scrollY;

        if (wasFloating) {
            searchBar.classList.add('search-bar-v2-floating');
        }
    }

    function updateStickySearchBar() {
        if (window.innerWidth <= 1024) {
            searchBar.classList.remove('search-bar-v2-floating');
            searchBar.style.top = '';
            spacer.style.display = 'none';
            spacer.style.height = '0px';
            return;
        }

        const headerBottom = Math.max(0, header.getBoundingClientRect().bottom);
        const shouldFloat = (window.scrollY + headerBottom + 8) >= stickyStart;

        if (shouldFloat) {
            searchBar.classList.add('search-bar-v2-floating');
            searchBar.style.top = (headerBottom + 8) + 'px';
            spacer.style.display = 'block';
            spacer.style.height = searchBar.offsetHeight + 'px';
        } else {
            searchBar.classList.remove('search-bar-v2-floating');
            searchBar.style.top = '';
            spacer.style.display = 'none';
            spacer.style.height = '0px';
        }
    }

    measureStickyStart();
    updateStickySearchBar();
    window.addEventListener('scroll', updateStickySearchBar, { passive: true });
    window.addEventListener('resize', function() {
        measureStickyStart();
        updateStickySearchBar();
    });
});
</script>
