@php
    $devisLink = $devisUrl ?? route('devis');
    $siteName = get_site_name($etablissement->id) ?: ($etablissement->name ?? 'Appartements Place des Cerisiers');
    $siteDescription = $etablissement->getSetting('description', null, 'general')
        ?: $etablissement->getSetting('site_description', null, 'general')
        ?: get_site_description($etablissement->id)
        ?: 'Appartements lumineux, espaces verts, stationnement inclus et emplacement privilégié à proximité des services.';
    $heroPrimaryCtaText = $etablissement->getSetting('hero_cta_text', null, 'landing')
        ?: $etablissement->getSetting('cta_text', null, 'general');
    $heroPrimaryCtaUrl = $etablissement->getSetting('hero_cta_url', null, 'landing')
        ?: $devisLink;
    $heroSecondaryCtaText = $etablissement->getSetting('hero_secondary_cta_text', null, 'landing');
    $heroSecondaryCtaUrl = $etablissement->getSetting('hero_secondary_cta_url', null, 'landing');
    $slogan = trim((string) $etablissement->getSetting('slogan', null, 'general')) ?: '';
    $brandLogo = get_logo_url($etablissement->id) ?: ($brandLogoUrl ?? null);
    $phone = $etablissement->getSetting('phone', null, 'company') ?: $etablissement->getSetting('phone', null, 'general') ?: $etablissement->getSetting('telephone', null, 'general') ?: ($etablissement->phone ?? null) ?: ($etablissement->telephone ?? null) ?: '(418) 525-7748';
    $phoneDial = preg_replace('/\D+/', '', $phone);
    $phoneDial = strlen($phoneDial) === 10 ? '+1' . $phoneDial : $phoneDial;
    $email = $etablissement->getSetting('email', null, 'general') ?: $etablissement->getSetting('email_contact', null, 'general') ?: ($etablissement->email_contact ?? null) ?: ($etablissement->email ?? null) ?: 'info@goexploriabusiness.com';
    $address = $etablissement->getSetting('address', null, 'company') ?: $etablissement->getSetting('adress', null, 'company') ?: $etablissement->getSetting('address', null, 'general') ?: $etablissement->getSetting('adresse', null, 'general') ?: ($etablissement->adresse ?? null) ?: 'Rue des Jonquilles, Rivière-du-Loup, QC';
    $hours = $etablissement->getSetting('opening_hours', [], 'company');
    $workingHours = normalize_cms_opening_hours($hours, [
        ['day' => 'Lundi au vendredi', 'hours' => '9h à 17h'],
        ['day' => 'Visites', 'hours' => 'Sur rendez-vous'],
    ]);
    $socialLinks = $socialLinks ?? get_establishment_social_links($etablissement);
    $facebookUrl = $socialLinks['facebook']['url'] ?? null;
    $instagramUrl = $socialLinks['instagram']['url'] ?? null;
    $pinterestUrl = $socialLinks['pinterest']['url'] ?? null;
    $mapLat = (float) ($mapLatitude ?? $etablissement->latitude ?? 47.8358);
    $mapLng = (float) ($mapLongitude ?? $etablissement->longitude ?? -69.5369);
    $initials = collect(explode(' ', $siteName))->filter()->take(2)->map(fn ($part) => mb_substr($part, 0, 1, 'UTF-8'))->implode('') ?: 'PC';

    $mediaUrl = static function ($path) {
        if (empty($path)) return null;
        if (is_array($path)) $path = data_get($path, 'url') ?: data_get($path, 'thumbnail') ?: data_get($path, 0);
        $path = trim((string) $path);
        if ($path === '') return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, ['/storage/'])) return asset(ltrim($path, '/'));
        if (\Illuminate\Support\Str::startsWith($path, ['storage/'])) return asset($path);
        if (\Illuminate\Support\Str::startsWith($path, ['/'])) return asset(ltrim($path, '/'));
        return asset('storage/' . ltrim($path, '/'));
    };

    $heroEmbedUrl = static function ($value) {
        $raw = trim((string) $value);
        if ($raw === '') return null;
        if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/i', $raw, $match)) {
            $raw = trim((string) $match[1]);
        }

        $videoId = null;
        $host = (string) parse_url($raw, PHP_URL_HOST);
        $path = (string) parse_url($raw, PHP_URL_PATH);

        if (str_contains($host, 'youtu.be')) {
            $videoId = trim($path, '/');
        } elseif (str_contains($host, 'youtube.com')) {
            parse_str((string) parse_url($raw, PHP_URL_QUERY), $query);
            if (!empty($query['v'])) {
                $videoId = (string) $query['v'];
            } elseif (preg_match('#/(embed|shorts)/([^/?]+)#', $path, $match)) {
                $videoId = $match[2];
            }
        }

        if ($videoId) {
            return 'https://www.youtube.com/embed/' . $videoId . '?autoplay=1&mute=1&loop=1&playlist=' . $videoId . '&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1';
        }

        if (str_contains($host, 'youtube.com')) {
            $separator = str_contains($raw, '?') ? '&' : '?';
            return $raw . $separator . 'autoplay=1&mute=1&loop=1&controls=0&rel=0&modestbranding=1&playsinline=1';
        }

        return $raw;
    };

    $fallbackImages = collect([
        ['thumbnail' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1800&q=85', 'name' => 'Appartement lumineux'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1560448075-bb485b067938?w=1800&q=85', 'name' => 'Salon contemporain'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=1800&q=85', 'name' => 'Chambre confortable'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=1800&q=85', 'name' => 'Cuisine équipée'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=1800&q=85', 'name' => 'Espace de vie'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1800&q=85', 'name' => 'Immeuble résidentiel'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1800&q=85', 'name' => 'Extérieur paisible'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=1800&q=85', 'name' => 'Décor soigné'],
    ]);

    $gallery = collect($mainGalleryMedia ?? [])->map(function ($row) use ($mediaUrl) {
        $url = $mediaUrl(data_get($row, 'thumbnail') ?: data_get($row, 'url') ?: data_get($row, 'path'));
        return [
            'thumbnail' => $url,
            'url' => $mediaUrl(data_get($row, 'url') ?: data_get($row, 'path')) ?: $url,
            'name' => data_get($row, 'name') ?: data_get($row, 'title') ?: 'Galerie',
            'type' => strtolower((string) (data_get($row, 'type') ?: 'image')),
        ];
    })->filter(fn ($row) => !empty($row['thumbnail']))->values();
    if ($gallery->isEmpty()) {
        $gallery = collect($galleryMedia ?? [])->map(function ($row) use ($mediaUrl) {
            $url = $mediaUrl(data_get($row, 'thumbnail') ?: data_get($row, 'url') ?: data_get($row, 'path'));
            return [
                'thumbnail' => $url,
                'url' => $mediaUrl(data_get($row, 'url') ?: data_get($row, 'path')) ?: $url,
                'name' => data_get($row, 'name') ?: data_get($row, 'title') ?: 'Galerie',
                'type' => strtolower((string) (data_get($row, 'type') ?: 'image')),
            ];
        })->filter(fn ($row) => !empty($row['thumbnail']))->values();
    }
    if ($gallery->isEmpty()) {
        $gallery = $fallbackImages;
    }
    while ($gallery->count() < 8) $gallery = $gallery->concat($fallbackImages)->values();

    $normalizeSocialMedia = static function ($items, $fallback) use ($mediaUrl) {
        $media = collect($items ?? [])->map(function ($row) use ($mediaUrl) {
            $url = $mediaUrl(data_get($row, 'thumbnail') ?: data_get($row, 'url') ?: data_get($row, 'path'));
            return [
                'thumbnail' => $url,
                'url' => $mediaUrl(data_get($row, 'url') ?: data_get($row, 'path')) ?: $url,
                'name' => data_get($row, 'name') ?: data_get($row, 'title') ?: 'Publication',
            ];
        })->filter(fn ($row) => !empty($row['thumbnail']))->values();

        return $media->isNotEmpty() ? $media : $fallback->values();
    };
    $instagramGallery = $normalizeSocialMedia($instagramGalleryMedia ?? [], $gallery);
    $facebookGallery = $normalizeSocialMedia($facebookGalleryMedia ?? [], $gallery);
    $pinterestGallery = $normalizeSocialMedia($pinterestGalleryMedia ?? [], $gallery);

    $heroSlides = collect($sliders ?? [])->map(function ($slider) use ($mediaUrl, $heroEmbedUrl, $siteName, $siteDescription, $heroPrimaryCtaText, $heroPrimaryCtaUrl) {
        $type = strtolower((string) data_get($slider, 'type', 'image'));
        $url = $mediaUrl(data_get($slider, 'image_url') ?: data_get($slider, 'thumbnail_url') ?: data_get($slider, 'video_url') ?: data_get($slider, 'url') ?: data_get($slider, 'image_path'));
        $embed = $heroEmbedUrl(data_get($slider, 'video_embed_url') ?: data_get($slider, 'embed') ?: ($type === 'iframe' ? data_get($slider, 'url') : null));
        return [
            'type' => $type,
            'url' => $url,
            'embed' => $embed,
            'title' => data_get($slider, 'title') ?: $siteName,
            'subtitle' => data_get($slider, 'subtitle') ?: data_get($slider, 'description') ?: $siteDescription,
            'button_text' => data_get($slider, 'button_text') ?: $heroPrimaryCtaText,
            'button_url' => data_get($slider, 'button_url') ?: data_get($slider, 'button_link') ?: $heroPrimaryCtaUrl,
        ];
    })->filter(fn ($slide) => !empty($slide['url']) || !empty($slide['embed']))->values();
    if ($heroSlides->isEmpty()) {
        $heroSlides = collect([
            ['type' => 'image', 'url' => $gallery[0]['thumbnail'], 'embed' => null, 'title' => $siteName, 'subtitle' => $siteDescription, 'button_text' => $heroPrimaryCtaText, 'button_url' => $heroPrimaryCtaUrl],
            ['type' => 'image', 'url' => $gallery[1]['thumbnail'], 'embed' => null, 'title' => $siteName, 'subtitle' => $siteDescription, 'button_text' => $heroPrimaryCtaText, 'button_url' => $heroPrimaryCtaUrl],
            ['type' => 'image', 'url' => $gallery[2]['thumbnail'], 'embed' => null, 'title' => $siteName, 'subtitle' => $siteDescription, 'button_text' => $heroPrimaryCtaText, 'button_url' => $heroPrimaryCtaUrl],
        ]);
    }

    $fallbackApartments = collect([
        ['title' => '3 1/2 lumineux', 'tag' => 'Disponible', 'price' => 'À partir de 925 $', 'surface' => '720 pi²', 'rooms' => '1 chambre', 'floor' => '2e étage', 'image' => $gallery[0]['thumbnail'], 'desc' => 'Appartement confortable avec cuisine équipée, grand salon et belle lumière naturelle.'],
        ['title' => '4 1/2 familial', 'tag' => 'Vedette', 'price' => 'À partir de 1 175 $', 'surface' => '920 pi²', 'rooms' => '2 chambres', 'floor' => 'Rez-de-chaussée', 'image' => $gallery[1]['thumbnail'], 'desc' => 'Logement spacieux, stationnement inclus et accès rapide aux services du quartier.'],
        ['title' => '5 1/2 prestige', 'tag' => 'Grand espace', 'price' => 'Sur demande', 'surface' => '1 150 pi²', 'rooms' => '3 chambres', 'floor' => 'Étage supérieur', 'image' => $gallery[2]['thumbnail'], 'desc' => 'Idéal pour famille ou télétravail, avec rangements, balcon et atmosphère calme.'],
    ]);
    $apartmentCards = $fallbackApartments;

    $amenities = collect([
        ['title' => 'Stationnement inclus', 'text' => 'Accès pratique pour résidents et visiteurs.'],
        ['title' => 'Entrée laveuse-sécheuse', 'text' => 'Confort quotidien directement dans le logement.'],
        ['title' => 'Près des services', 'text' => 'Épicerie, écoles, parcs et axes routiers à proximité.'],
        ['title' => 'Espaces lumineux', 'text' => 'Grandes fenêtres et pièces bien divisées.'],
        ['title' => 'Gestion attentive', 'text' => 'Demandes traitées avec sérieux et rapidité.'],
        ['title' => 'Quartier paisible', 'text' => 'Un environnement calme pour habiter longtemps.'],
    ]);

    $reviewCards = collect($reviews ?? [])->take(5)->map(function ($review) {
        return [
            'text' => \Illuminate\Support\Str::limit(strip_tags((string) (data_get($review, 'comment') ?: data_get($review, 'text') ?: 'Très belle expérience et service professionnel.')), 240),
            'author' => \Illuminate\Support\Str::limit(strip_tags((string) (data_get($review, 'author') ?: data_get($review, 'name') ?: 'Client satisfait')), 80),
            'source' => \Illuminate\Support\Str::limit(strip_tags((string) (data_get($review, 'source') ?: 'Google')), 40),
            'rating' => max(0, min(5, (float) (data_get($review, 'rating') ?: 5))),
        ];
    })->values();
    if ($reviewCards->isEmpty()) {
        $reviewCards = collect([
            ['author' => 'Camille L.', 'source' => 'Google', 'rating' => 5, 'text' => 'Appartement propre, lumineux et très bien situé. Le processus de location a été simple du début à la fin.'],
            ['author' => 'Nicolas B.', 'source' => 'Facebook', 'rating' => 5, 'text' => 'Gestion professionnelle, réponses rapides et immeuble tranquille. Je recommande sans hésiter.'],
            ['author' => 'Sophie T.', 'source' => 'Google', 'rating' => 5, 'text' => 'Bel environnement, proche de tout, avec un vrai sentiment de confort au quotidien.'],
        ]);
    }

    $pcConfig = [
        'siteName' => $siteName,
        'address' => $address,
        'lat' => $mapLat,
        'lng' => $mapLng,
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($siteDescription), 155) }}">
    <title>{{ $siteName }} | Immobilier</title>
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
    @include('cms::web.fallback.partials.immoblier.styles')
</head>
<body>
    @include('home-v2.components.Header')
    <main class="pc-page">
        <!-- @include('cms::web.fallback.partials.immoblier.nav') -->
        @include('cms::web.fallback.partials.immoblier.hero')
        @if(collect($cmsPageSections ?? [])->isNotEmpty())
                @foreach(collect($cmsPageSections) as $cmsPage)
                                {!! data_get($cmsPage, 'content') !!}
                @endforeach
        @endif
        @include('cms::web.fallback.partials.immoblier.gallery')
        @include('cms::web.fallback.partials.immoblier.amenities')
        @include('cms::web.fallback.partials.immoblier.social')
        @include('cms::web.fallback.partials.immoblier.contact')
        @include('cms::web.fallback.partials.immoblier.map-cta')
        @include('cms::web.fallback.partials.landing-media-slideshow')
        @include('cms::web.fallback.partials.landing-contact-ajax')
        @include('cms::web.fallback.partials.immoblier.footer')
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/services-mega-menu-v2.js') }}"></script>
    @include('cms::web.fallback.partials.immoblier.scripts')
</body>
</html>
