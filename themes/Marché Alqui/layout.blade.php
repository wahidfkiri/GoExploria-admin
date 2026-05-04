<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', get_site_name() . (get_site_slogan() ? ' - ' . get_site_slogan() : ''))</title>
    <meta name="description" content="@yield('description', get_site_description() ?? 'Marché Alqui – Fraîcheur et diversité à Saint-Ambroise')">
    
    <!-- Favicon -->
    @if(has_favicon())
        {!! get_favicon_html() !!}
        {!! get_apple_touch_icon_html() !!}
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif
    
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', get_site_name())">
    <meta property="og:description" content="@yield('description', get_site_description())">
    <meta property="og:image" content="{{ get_logo_url() ?? asset('images/default-og-image.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ get_site_name() }}">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', get_site_name())">
    <meta name="twitter:description" content="@yield('description', get_site_description())">
    <meta name="twitter:image" content="{{ get_logo_url() ?? asset('images/default-og-image.jpg') }}">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <!-- Theme Styles -->
    <link rel="stylesheet" href="{{ theme_asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('css/responsive.css') }}">
    
    <!-- Custom CSS -->
    @php $customCss = theme_setting('custom_css'); @endphp
    @if($customCss)
        <style>{!! $customCss !!}</style>
    @endif
    
    @stack('styles')
</head>
<body>

    <!-- Header -->
    @include('theme::partials.header')
    
    <!-- Hero Slider (Swiper avec vidéos/images) - visible sur toutes les pages sauf si hideSlider est défini -->
    @if(has_slider() && !isset($hideSlider))
        {!! get_slider_html() !!}
    @endif
    
    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Map Section -->
    @php $hasMap = (!isset($hideMap) && has_map_points()); @endphp
    @if($hasMap)
        {!! get_map_section_html() !!}
    @endif
    
    <!-- Footer -->
    @include('theme::partials.footer')
    
    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top" title="Retour en haut">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- WhatsApp Floating Button -->
    @if(has_whatsapp())
        {!! get_whatsapp_button_html() !!}
    @endif
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ theme_asset('js/main.js') }}"></script>
    
    <!-- Custom JS -->
    @php $customJs = theme_setting('custom_js'); @endphp
    @if($customJs)
        <script>{!! $customJs !!}</script>
    @endif
    
    @stack('scripts')
    
    <!-- Google Analytics -->
    @php $googleAnalyticsId = theme_setting('google_analytics_id'); @endphp
    @if($googleAnalyticsId)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $googleAnalyticsId }}');
        </script>
    @endif
</body>
</html>