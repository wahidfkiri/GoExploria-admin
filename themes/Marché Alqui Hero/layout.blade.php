@php
    use Illuminate\Support\Str;

    $slides = collect($sliderMedia ?? [])->filter(function ($slide) {
        return is_array($slide) && (!empty($slide['image_url']) || !empty($slide['video_url']));
    })->values();

    $toYoutubeEmbed = static function (?string $url): ?string {
        $url = trim((string) $url);
        if ($url === '') return null;
        if (Str::contains($url, ['youtube.com/embed/', 'youtube-nocookie.com/embed/'])) return $url;
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }
        return null;
    };

    $toVimeoEmbed = static function (?string $url): ?string {
        $url = trim((string) $url);
        if ($url === '') return null;
        if (Str::contains($url, 'player.vimeo.com/video/')) return $url;
        if (preg_match('/vimeo\.com\/(?:.*\/)?([0-9]+)/', $url, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1];
        }
        return null;
    };
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', get_site_name() . (get_site_slogan() ? ' - ' . get_site_slogan() : ''))</title>
    <meta name="description" content="@yield('description', get_site_description() ?? 'Marche Alqui Hero')">

    @if(has_favicon())
        {!! get_favicon_html() !!}
        {!! get_apple_touch_icon_html() !!}
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <meta property="og:title" content="@yield('title', get_site_name())">
    <meta property="og:description" content="@yield('description', get_site_description())">
    <meta property="og:image" content="{{ get_logo_url() ?? asset('images/default-og-image.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ get_site_name() }}">

    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ theme_asset('css/style.css') }}?v=20260504-1">

    @php $customCss = theme_setting('custom_css'); @endphp
    @if($customCss)
        <style>{!! $customCss !!}</style>
    @endif

    @stack('styles')
</head>
<body>
    @includeIf('theme::partials.header')

    <section class="mah-hero" id="hero-slider-media">
        @if($slides->isNotEmpty())
            <div class="mah-hero-slides" id="mahHeroSlides">
                @foreach($slides as $index => $slide)
                    @php
                        $name = trim((string) ($slide['name'] ?? 'Slide'));
                        $desc = trim((string) ($slide['description'] ?? ''));
                        $imageUrl = trim((string) ($slide['image_url'] ?? ''));
                        $videoUrl = trim((string) ($slide['video_url'] ?? ''));
                        $youtubeEmbed = $toYoutubeEmbed($videoUrl);
                        $vimeoEmbed = $youtubeEmbed ? null : $toVimeoEmbed($videoUrl);
                        $buttonText = trim((string) ($slide['button_text'] ?? ''));
                        $buttonUrl = trim((string) ($slide['button_url'] ?? ''));
                    @endphp
                    <article class="mah-slide {{ $index === 0 ? 'is-active' : '' }}" data-slide="{{ $index }}">
                        @if($videoUrl !== '')
                            @if($imageUrl !== '')
                                <img class="mah-media" src="{{ $imageUrl }}" alt="{{ $name }}">
                            @endif
                            @if($youtubeEmbed || $vimeoEmbed)
                                <iframe
                                    class="mah-media"
                                    src="{{ ($youtubeEmbed ?: $vimeoEmbed) . ((Str::contains(($youtubeEmbed ?: $vimeoEmbed), '?') ? '&' : '?') . 'autoplay=' . ($index === 0 ? '1' : '0') . '&mute=1&loop=1&controls=0&playsinline=1&rel=0') }}"
                                    frameborder="0"
                                    allow="autoplay; encrypted-media"
                                    allowfullscreen
                                ></iframe>
                            @else
                                <video class="mah-media" {{ $index === 0 ? 'autoplay' : '' }} muted loop playsinline>
                                    <source src="{{ $videoUrl }}" type="video/mp4">
                                </video>
                            @endif
                        @elseif($imageUrl !== '')
                            <img class="mah-media" src="{{ $imageUrl }}" alt="{{ $name }}">
                        @endif

                        <div class="mah-overlay"></div>
                        <div class="mah-caption container">
                            <h1>{{ $name }}</h1>
                            @if($desc !== '')
                                <p>{{ $desc }}</p>
                            @endif
                            @if($buttonText !== '' && $buttonUrl !== '')
                                <a class="mah-btn" href="{{ $buttonUrl }}">{{ $buttonText }}</a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mah-thumbs" id="mahThumbs">
                @foreach($slides as $index => $slide)
                    @php
                        $thumbUrl = trim((string) ($slide['thumbnail_url'] ?? ''));
                        if ($thumbUrl === '') $thumbUrl = trim((string) ($slide['image_url'] ?? ''));
                    @endphp
                    <button class="mah-thumb {{ $index === 0 ? 'is-active' : '' }}" type="button" data-target="{{ $index }}" aria-label="Slide {{ $index + 1 }}">
                        @if($thumbUrl !== '')
                            <img src="{{ $thumbUrl }}" alt="Thumb {{ $index + 1 }}">
                        @else
                            <span>{{ $index + 1 }}</span>
                        @endif
                    </button>
                @endforeach
            </div>
        @else
            <div class="mah-empty-hero">
                <div class="container">
                    <h2>Aucun média slider trouvé</h2>
                    <p>Vérifier la table <code>cms.cms_media</code> avec <code>is_slider = 1</code> pour cet établissement.</p>
                </div>
            </div>
        @endif
    </section>

    <main class="main-content">
        @yield('content')
    </main>

    @php $hasMap = (!isset($hideMap) && has_map_points()); @endphp
    @if($hasMap)
        {!! get_map_section_html() !!}
    @endif

    @includeIf('theme::partials.footer')

    @if(has_whatsapp())
        {!! get_whatsapp_button_html() !!}
    @endif

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ theme_asset('js/main.js') }}?v=20260504-1"></script>

    @php $customJs = theme_setting('custom_js'); @endphp
    @if($customJs)
        <script>{!! $customJs !!}</script>
    @endif

    @stack('scripts')
</body>
</html>



