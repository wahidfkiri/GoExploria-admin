@php
    $devisLink = $devisUrl ?? route('devis');
    $siteName = get_site_name($etablissement->id) ?: ($etablissement->name ?? 'Top Location Charlevoix');
    $siteShortName = \Illuminate\Support\Str::limit($siteName, 22, '');
    $siteDescription = $etablissement->getSetting('description', null, 'general')
        ?: $etablissement->getSetting('site_description', null, 'general')
        ?: get_site_description($etablissement->id)
        ?: 'Location de motoneige, quad, côte-à-côte et forfaits d’aventure avec une expérience de réservation moderne.';
    $heroPrimaryCtaText = $etablissement->getSetting('hero_cta_text', null, 'landing')
        ?: $etablissement->getSetting('cta_text', null, 'general');
    $heroPrimaryCtaUrl = $etablissement->getSetting('hero_cta_url', null, 'landing')
        ?: $devisLink;
    $heroSecondaryCtaText = $etablissement->getSetting('hero_secondary_cta_text', null, 'landing');
    $heroSecondaryCtaUrl = $etablissement->getSetting('hero_secondary_cta_url', null, 'landing');
    $brandLogo = get_logo_url($etablissement->id) ?: ($brandLogoUrl ?? null);
    $phone = $etablissement->getSetting('phone', null, 'company') ?: $etablissement->getSetting('phone', null, 'general') ?: $etablissement->getSetting('telephone', null, 'general') ?: ($etablissement->phone ?? null) ?: ($etablissement->telephone ?? null) ?: '(418) 525-7748';
    $phoneDial = preg_replace('/\D+/', '', $phone);
    $phoneDial = strlen($phoneDial) === 10 ? '+1' . $phoneDial : $phoneDial;
    $email = $etablissement->getSetting('email', null, 'general') ?: $etablissement->getSetting('email_contact', null, 'general') ?: ($etablissement->email_contact ?? null) ?: ($etablissement->email ?? null) ?: 'info@goexploriabusiness.com';
    $address = $etablissement->getSetting('address', null, 'company') ?: $etablissement->getSetting('adress', null, 'company') ?: $etablissement->getSetting('address', null, 'general') ?: $etablissement->getSetting('adresse', null, 'general') ?: ($etablissement->adresse ?? null) ?: '1000-B Chemin des Loisirs, La Malbaie, QC';
    $hours = $etablissement->getSetting('opening_hours', [], 'company');
    $workingHours = normalize_cms_opening_hours($hours, [
        ['day' => 'Lundi au vendredi', 'hours' => '9h à 17h'],
        ['day' => 'Fin de semaine', 'hours' => 'Sur réservation'],
    ]);
    $socialLinks = $socialLinks ?? get_establishment_social_links($etablissement);
    $facebookUrl = $socialLinks['facebook']['url'] ?? null;
    $instagramUrl = $socialLinks['instagram']['url'] ?? null;
    $youtubeUrl = $socialLinks['youtube']['url'] ?? null;
    $mapLat = (float) ($mapLatitude ?? $etablissement->latitude ?? 47.6577);
    $mapLng = (float) ($mapLongitude ?? $etablissement->longitude ?? -70.1526);
    $initials = collect(explode(' ', $siteName))->filter()->take(2)->map(fn ($part) => mb_substr($part, 0, 1, 'UTF-8'))->implode('') ?: 'TL';

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

    $fallbackImages = collect([
        ['thumbnail' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=1800&q=80', 'name' => 'Sentiers de Charlevoix'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1548438294-1ad5d5f4f063?w=1800&q=80', 'name' => 'Motoneige premium'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=1800&q=80', 'name' => 'Expédition guidée'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1544551763-92ab472cad5d?w=1800&q=80', 'name' => 'Paysages hivernaux'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1601758124510-52d02ddb7cbd?w=1800&q=80', 'name' => 'Côte-à-côte aventure'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1517089596392-fb9a9033e05b?w=1800&q=80', 'name' => 'Forfaits nature'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1558980394-4c7c9299fe96?w=1800&q=80', 'name' => 'Quad en forêt'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1800&q=80', 'name' => 'Voyage organisé'],
    ]);

    $gallery = collect($mainGalleryMedia ?? [])->map(function ($row) use ($mediaUrl) {
        $url = $mediaUrl(data_get($row, 'thumbnail') ?: data_get($row, 'url') ?: data_get($row, 'path'));
        return [
            'thumbnail' => $url,
            'url' => $mediaUrl(data_get($row, 'url') ?: data_get($row, 'path')) ?: $url,
            'name' => data_get($row, 'name') ?: data_get($row, 'title') ?: 'Aventure',
            'type' => strtolower((string) (data_get($row, 'type') ?: 'image')),
        ];
    })->filter(fn ($row) => !empty($row['thumbnail']))->values();
    if ($gallery->isEmpty()) {
        $gallery = collect($galleryMedia ?? [])->map(function ($row) use ($mediaUrl) {
            $url = $mediaUrl(data_get($row, 'thumbnail') ?: data_get($row, 'url') ?: data_get($row, 'path'));
            return [
                'thumbnail' => $url,
                'url' => $mediaUrl(data_get($row, 'url') ?: data_get($row, 'path')) ?: $url,
                'name' => data_get($row, 'name') ?: data_get($row, 'title') ?: 'Aventure',
                'type' => strtolower((string) (data_get($row, 'type') ?: 'image')),
            ];
        })->filter(fn ($row) => !empty($row['thumbnail']))->values();
    }
    if ($gallery->isEmpty()) $gallery = $fallbackImages;
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

    $heroSlides = collect($sliders ?? [])->map(function ($slider) use ($mediaUrl, $siteName, $siteDescription, $heroPrimaryCtaText, $heroPrimaryCtaUrl) {
        $type = strtolower((string) data_get($slider, 'type', 'image'));
        $url = $mediaUrl(data_get($slider, 'image_url') ?: data_get($slider, 'thumbnail_url') ?: data_get($slider, 'video_url') ?: data_get($slider, 'url') ?: data_get($slider, 'image_path'));
        $embed = data_get($slider, 'video_embed_url') ?: data_get($slider, 'embed');
        return [
            'type' => $type,
            'url' => $url,
            'embed' => $embed,
            'title' => data_get($slider, 'title') ?: $siteName,
            'subtitle' => data_get($slider, 'subtitle') ?: data_get($slider, 'description') ?: $siteDescription,
            'button_text' => data_get($slider, 'button_text') ?: $heroPrimaryCtaText,
            'button_url' => data_get($slider, 'button_url') ?: data_get($slider, 'button_link') ?: $heroPrimaryCtaUrl,
            'caption' => data_get($slider, 'caption') ?: data_get($slider, 'title') ?: $siteName,
        ];
    })->filter(fn ($slide) => !empty($slide['url']) || !empty($slide['embed']))->values();
    if ($heroSlides->isEmpty()) {
        $heroSlides = collect([
            ['type' => 'image', 'url' => $fallbackImages[0]['thumbnail'], 'embed' => null, 'title' => $siteName, 'subtitle' => $siteDescription, 'button_text' => $heroPrimaryCtaText, 'button_url' => $heroPrimaryCtaUrl, 'caption' => $fallbackImages[0]['name'] ?? $siteName],
            ['type' => 'image', 'url' => $fallbackImages[1]['thumbnail'], 'embed' => null, 'title' => $siteName, 'subtitle' => $siteDescription, 'button_text' => $heroPrimaryCtaText, 'button_url' => $heroPrimaryCtaUrl, 'caption' => $fallbackImages[1]['name'] ?? $siteName],
            ['type' => 'image', 'url' => $fallbackImages[2]['thumbnail'], 'embed' => null, 'title' => $siteName, 'subtitle' => $siteDescription, 'button_text' => $heroPrimaryCtaText, 'button_url' => $heroPrimaryCtaUrl, 'caption' => $fallbackImages[2]['name'] ?? $siteName],
            ['type' => 'image', 'url' => $fallbackImages[3]['thumbnail'], 'embed' => null, 'title' => $siteName, 'subtitle' => $siteDescription, 'button_text' => $heroPrimaryCtaText, 'button_url' => $heroPrimaryCtaUrl, 'caption' => $fallbackImages[3]['name'] ?? $siteName],
            ['type' => 'image', 'url' => $fallbackImages[4]['thumbnail'], 'embed' => null, 'title' => $siteName, 'subtitle' => $siteDescription, 'button_text' => $heroPrimaryCtaText, 'button_url' => $heroPrimaryCtaUrl, 'caption' => $fallbackImages[4]['name'] ?? $siteName],
        ]);
    }

    $cmsLandingProducts = collect();
    try {
        if (class_exists(\App\Models\Product::class) && \Illuminate\Support\Facades\Schema::hasTable('products')) {
            $cmsLandingProducts = \App\Models\Product::query()
                ->with(['category:id,name', 'family:id,name'])
                ->where('etablissement_id', $etablissement->id)
                ->where('is_available_for_sale', true)
                ->latest('updated_at')
                ->limit(9)
                ->get();
        }
    } catch (\Throwable $e) { $cmsLandingProducts = collect(); }

    $productPrice = static function ($product) {
        $value = $product->price_ttc ?? $product->price_ht ?? null;
        return $value === null || $value === '' ? 'Sur demande' : number_format((float) $value, 0, ',', ' ') . ' $';
    };

    $fallbackForfaits = collect([
        ['tag' => '2 jours · 1 nuit', 'title' => 'La Gourmande', 'type' => 'Forfait guidé', 'distance' => '300 km', 'level' => 'Débutant', 'people' => 'Solo ou duo', 'price' => '1 055', 'unit' => 'CAD/pers.', 'image' => $gallery[0]['thumbnail'], 'featured' => false],
        ['tag' => '2 jours · 1 nuit', 'title' => 'Le Douillet', 'type' => 'Forfait confort', 'distance' => '300 km', 'level' => 'Débutant', 'people' => 'Hôtel inclus', 'price' => '1 125', 'unit' => 'CAD/pers.', 'image' => $gallery[2]['thumbnail'], 'featured' => true],
        ['tag' => '3 jours · 2 nuits', 'title' => 'Monts-Valin 700 km', 'type' => 'Expédition', 'distance' => '700 km', 'level' => 'Avancé', 'people' => 'Solo ou duo', 'price' => '1 499', 'unit' => 'CAD/pers.', 'image' => $gallery[3]['thumbnail'], 'featured' => false],
    ]);

    $forfaitCards = $cmsLandingProducts->isNotEmpty()
        ? $cmsLandingProducts->map(function ($product, $index) use ($mediaUrl, $productPrice, $gallery) {
            $galleryImage = is_array($product->gallery_images ?? null) ? data_get($product->gallery_images, 0) : null;
            $image = $mediaUrl($product->main_image ?: $galleryImage) ?: ($gallery[$index % max(1, $gallery->count())]['thumbnail'] ?? null);
            return [
                'tag' => optional($product->category)->name ?: optional($product->family)->name ?: 'Produit à vendre',
                'title' => $product->name,
                'type' => optional($product->family)->name ?: 'Forfait',
                'distance' => 'Disponible',
                'level' => $product->stock_management === 'sur_commande' ? 'Sur commande' : 'En stock',
                'people' => 'Demande directe',
                'price' => $productPrice($product),
                'unit' => '',
                'image' => $image,
                'featured' => $index === 1,
                'product_id' => $product->id,
                'description' => $product->short_description ?: \Illuminate\Support\Str::limit(strip_tags((string) $product->long_description), 110),
            ];
        })->values()
        : $fallbackForfaits;

    $tlSlideCaptions = $heroSlides->pluck('caption')->values();
    $tlForfaitsData = $forfaitCards->map(function ($item) {
        return [
            'name' => $item['title'] ?? 'Forfait',
            'type' => $item['type'] ?? 'Forfait',
            'tag' => $item['tag'] ?? '',
            'icon' => '🏔️',
            'km' => $item['distance'] ?? '',
            'level' => $item['level'] ?? '',
            'price' => $item['price'] ?? '',
            'unit' => $item['unit'] ?? '',
            'rooms' => $item['people'] ?? '',
            'best' => !empty($item['featured']),
        ];
    })->values();

    $serviceCards = collect([
        ['title' => 'Location de Motoneige', 'desc' => 'BRP 600 Touring et 900 Renegade pour découvrir les panoramas du fleuve, des sommets et des sentiers balisés.', 'price' => '149', 'unit' => 'CAD / 2h', 'badge' => 'Populaire', 'image' => $gallery[1]['thumbnail']],
        ['title' => 'Quad & VTT', 'desc' => 'Sentiers estivaux, demi-journée, journée complète ou parcours personnalisés pour vivre la forêt autrement.', 'price' => '189', 'unit' => 'CAD / 4h', 'badge' => 'Été', 'image' => $gallery[6]['thumbnail']],
        ['title' => 'Côte-à-côte SSV', 'desc' => 'Expérience duo ou groupe avec confort, sécurité et vues panoramiques dans les plus beaux secteurs.', 'price' => '249', 'unit' => 'CAD / 4h', 'badge' => 'Aventure', 'image' => $gallery[4]['thumbnail']],
    ]);

    $hotelCards = collect([
        ['name' => 'Le Petit Manoir du Casino', 'city' => 'La Malbaie, Charlevoix', 'stars' => 4, 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=900&q=80', 'amenities' => ['Spa', 'Restaurant', 'Vue sur fleuve']],
        ['name' => 'Maison Germain-Fleury', 'city' => 'Baie-Saint-Paul, Charlevoix', 'stars' => 5, 'image' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=900&q=80', 'amenities' => ['Foyer', 'Jardin', 'Déjeuner']],
        ['name' => 'Chalets Spa Canada', 'city' => 'Saint-Aimé-des-Lacs, Charlevoix', 'stars' => 3, 'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=900&q=80', 'amenities' => ['Bain nordique', 'Nature']],
        ['name' => 'Hôtel Transat · Rome', 'city' => 'Rome, Italie · Forfait Alpha', 'stars' => 4, 'image' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=900&q=80', 'amenities' => ['Centre-ville', 'Petit-déjeuner']],
        ['name' => 'Grand Hôtel · Barcelone', 'city' => 'Barcelone, Espagne · Forfait Alpha', 'stars' => 5, 'image' => 'https://images.unsplash.com/photo-1521624098240-3bba72a38c28?w=900&q=80', 'amenities' => ['Vue mer', 'Bar rooftop']],
        ['name' => 'Boutique Hôtel · Paris', 'city' => 'Paris, France · Forfait Alpha', 'stars' => 4, 'image' => 'https://images.unsplash.com/photo-1608736009375-59891b8f7e97?w=900&q=80', 'amenities' => ['Vue Tour Eiffel', 'Boulangerie']],
    ]);

    $reviewCards = collect($reviews ?? [])->take(4)->map(function ($review) {
        $rating = (float) (data_get($review, 'rating') ?: 5);

        return [
            'text' => \Illuminate\Support\Str::limit(strip_tags((string) (data_get($review, 'comment') ?: data_get($review, 'text') ?: 'Expérience exceptionnelle, service rapide et organisation professionnelle.')), 320),
            'author' => \Illuminate\Support\Str::limit(strip_tags((string) (data_get($review, 'author') ?: data_get($review, 'name') ?: 'Client satisfait')), 80),
            'source' => \Illuminate\Support\Str::limit(strip_tags((string) (data_get($review, 'source') ?: 'Google')), 40),
            'rating' => max(0, min(5, $rating)),
        ];
    })->values();
    if ($reviewCards->isEmpty()) {
        $reviewCards = collect([
            ['author' => 'Marie-Luce B.', 'source' => 'Google', 'rating' => 5, 'text' => 'Une expérience mémorable, très bien organisée et parfaitement expliquée avant le départ.'],
            ['author' => 'François T.', 'source' => 'Facebook', 'rating' => 5, 'text' => 'Équipement impeccable, équipe rassurante et parcours magnifique. Je recommande sans hésiter.'],
            ['author' => 'Sophie C.', 'source' => 'Google', 'rating' => 5, 'text' => 'Le forfait était clair, simple à réserver et l’expérience sur place a dépassé nos attentes.'],
        ]);
    }

    $videoItems = collect($allGalleryMedia ?? $galleryMedia ?? [])->filter(fn ($row) => in_array(strtolower((string) data_get($row, 'type')), ['video', 'iframe'], true) || str_contains((string) data_get($row, 'url'), 'youtube') || str_contains((string) data_get($row, 'url'), 'vimeo'))->take(3)->values();
    $mapVideoUrl = 'https://www.youtube.com/embed/g5U3XGhdElM?autoplay=1&mute=1&start=5&playsinline=1&rel=0';
    $tlConfig = [
        'slideCaptions' => $tlSlideCaptions,
        'forfaitsData' => $tlForfaitsData,
        'devisLink' => $devisLink,
        'etablissementId' => $etablissement->id,
        'siteName' => $siteName,
        'address' => $address,
        'mapVideoUrl' => $mapVideoUrl,
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($siteDescription), 155) }}">
    <title>{{ $siteName }} | Espace Forfait</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
    @include('cms::web.fallback.partials.espace-forfait.styles')
</head>
<body>
    @include('home-v2.components.Header')
    <main class="tl-page">
        @include('cms::web.fallback.partials.espace-forfait.nav')
        @if(is_slider_enabled($etablissement->id))
            @if(has_slider($etablissement->id))
                {!! get_slider_html($etablissement->id) !!}
            @else
                @include('cms::web.fallback.partials.espace-forfait.hero')
            @endif
        @endif
        @if(collect($cmsPageSections ?? [])->isNotEmpty())
            <section id="cms-pages-content">
                <div class="container" style="display:grid;gap:22px;">
                    @foreach(collect($cmsPageSections) as $cmsPage)
                        <article class="tl-cms-page" id="cms-page-{{ \Illuminate\Support\Str::slug(data_get($cmsPage, 'slug') ?: data_get($cmsPage, 'title') ?: $loop->iteration) }}">
                            <div class="tl-cms-page-content">
                                {!! data_get($cmsPage, 'content') !!}
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
        @include('cms::web.fallback.partials.espace-forfait.reservation')
        @include('cms::web.fallback.partials.espace-forfait.services')
        @include('cms::web.fallback.partials.espace-forfait.forfaits')
        @include('cms::web.fallback.partials.espace-forfait.transat')
        @include('cms::web.fallback.partials.espace-forfait.itineraire')
        @include('cms::web.fallback.partials.espace-forfait.hebergement')
        @include('cms::web.fallback.partials.espace-forfait.galerie')
        @include('cms::web.fallback.partials.espace-forfait.videos')
        @include('cms::web.fallback.partials.espace-forfait.avis')
        @include('cms::web.fallback.partials.espace-forfait.faq')
        @include('cms::web.fallback.partials.landing-working-hours')
        @include('cms::web.fallback.partials.espace-forfait.contact')
        @include('cms::web.fallback.partials.espace-forfait.partenaires')
        @if(is_slideshow_enabled($etablissement->id) && has_slider($etablissement->id))
            {!! get_slider_html($etablissement->id) !!}
        @endif
        @include('cms::web.fallback.partials.landing-media-slideshow')
        @include('cms::web.fallback.partials.landing-contact-ajax')
        @include('cms::web.fallback.partials.espace-forfait.footer')
        <div class="toast" id="toast"></div>
    </main>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/services-mega-menu-v2.js') }}"></script>
    @include('cms::web.fallback.partials.espace-forfait.scripts')
</body>
</html>
