@php
    $devisLink = $devisUrl ?? route('devis');
    $siteName = get_site_name($etablissement->id) ?: ($etablissement->name ?? 'Top Location Charlevoix');
    $siteShortName = \Illuminate\Support\Str::limit($siteName, 22, '');
    $siteDescription = $etablissement->getSetting('description', null, 'general')
        ?: $etablissement->getSetting('site_description', null, 'general')
        ?: get_site_description($etablissement->id)
        ?: '';
    $heroPrimaryCtaText = $etablissement->getSetting('hero_cta_text', null, 'landing')
        ?: $etablissement->getSetting('cta_text', null, 'general');
    $heroPrimaryCtaUrl = $etablissement->getSetting('hero_cta_url', null, 'landing')
        ?: $devisLink;
    $heroSecondaryCtaText = $etablissement->getSetting('hero_secondary_cta_text', null, 'landing');
    $heroSecondaryCtaUrl = $etablissement->getSetting('hero_secondary_cta_url', null, 'landing');
    $brandLogo = get_logo_url($etablissement->id) ?: ($brandLogoUrl ?? null);
    $phone = $etablissement->getSetting('phone', null, 'company') ?: $etablissement->getSetting('phone', null, 'general') ?: $etablissement->getSetting('telephone', null, 'general') ?: ($etablissement->phone ?? null) ?: ($etablissement->telephone ?? null) ?: null;
    $phoneDial = preg_replace('/\D+/', '', $phone);
    $phoneDial = strlen($phoneDial) === 10 ? '+1' . $phoneDial : $phoneDial;
    $email = $etablissement->getSetting('email', null, 'general') ?: $etablissement->getSetting('email_contact', null, 'general') ?: ($etablissement->email_contact ?? null) ?: ($etablissement->email ?? null) ?: null;
    $address = $etablissement->getSetting('address', null, 'company') ?: $etablissement->getSetting('adress', null, 'company') ?: $etablissement->getSetting('address', null, 'general') ?: $etablissement->getSetting('adresse', null, 'general') ?: ($etablissement->adresse ?? null) ?: null;
    $hours = $etablissement->getSetting('opening_hours', [], 'company');
    $workingHours = normalize_cms_opening_hours($hours, $workingHours ?? []);
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

    $fallbackImages = collect();

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
    $instagramGallery = $normalizeSocialMedia($instagramGalleryMedia ?? [], collect());
    $facebookGallery = $normalizeSocialMedia($facebookGalleryMedia ?? [], collect());

    $heroSlides = collect($sliders ?? [])->map(function ($slider) use ($mediaUrl) {
        $type = strtolower((string) data_get($slider, 'type', 'image'));
        $url = $mediaUrl(data_get($slider, 'image_url') ?: data_get($slider, 'thumbnail_url') ?: data_get($slider, 'video_url') ?: data_get($slider, 'url') ?: data_get($slider, 'image_path'));
        $embed = data_get($slider, 'video_embed_url') ?: data_get($slider, 'embed');
        return [
            'type' => $type,
            'url' => $url,
            'embed' => $embed,
            'title' => data_get($slider, 'title'),
            'subtitle' => data_get($slider, 'subtitle') ?: data_get($slider, 'description'),
            'button_text' => data_get($slider, 'button_text'),
            'button_url' => data_get($slider, 'button_url') ?: data_get($slider, 'button_link'),
            'caption' => data_get($slider, 'caption') ?: data_get($slider, 'title'),
        ];
    })->filter(fn ($slide) => !empty($slide['url']) || !empty($slide['embed']))->values();

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
        return $value === null || $value === '' ? null : number_format((float) $value, 0, ',', ' ') . ' $';
    };

    $fallbackForfaits = collect();

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
                'raw_price' => (float) ($product->price_ttc ?? $product->price_ht ?? 0),
                'unit' => '',
                'image' => $image,
                'featured' => $index === 1,
                'product_id' => $product->id,
                'etablissement_id' => $product->etablissement_id,
                'description' => $product->short_description ?: \Illuminate\Support\Str::limit(strip_tags((string) $product->long_description), 110),
            ];
        })->values()
        : collect();

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

    $serviceCards = collect();
    $hotelCards = collect();

    $reviewCards = collect($reviews ?? [])->take(4)->map(function ($review) {
        $rating = (float) (data_get($review, 'rating') ?: 5);

        return [
            'text' => \Illuminate\Support\Str::limit(strip_tags((string) (data_get($review, 'comment') ?: data_get($review, 'text'))), 320),
            'author' => \Illuminate\Support\Str::limit(strip_tags((string) (data_get($review, 'author') ?: data_get($review, 'name'))), 80),
            'source' => \Illuminate\Support\Str::limit(strip_tags((string) data_get($review, 'source')), 40),
            'rating' => max(0, min(5, $rating)),
        ];
    })->filter(fn ($review) => !empty($review['text']) && !empty($review['author']))->values();

    $videoItems = collect($allGalleryMedia ?? $galleryMedia ?? [])->filter(fn ($row) => in_array(strtolower((string) data_get($row, 'type')), ['video', 'iframe'], true) || str_contains((string) data_get($row, 'url'), 'youtube') || str_contains((string) data_get($row, 'url'), 'vimeo'))->take(3)->values();
    $mapVideoUrl = null;
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
    @include('cms::web.fallback.partials.landing-cms-header')
        @if(is_slider_enabled($etablissement->id) && (has_slider($etablissement->id) || $heroSlides->isNotEmpty()))
            @if(has_slider($etablissement->id))
                {!! get_slider_html($etablissement->id) !!}
            @elseif($heroSlides->isNotEmpty())
                @include('cms::web.fallback.partials.espace-forfait.hero')
            @endif
        @endif
        @include('cms::web.fallback.partials.landing-map-video-points')

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
        @if($serviceCards->isNotEmpty())
            @include('cms::web.fallback.partials.espace-forfait.services')
        @endif
        @if($forfaitCards->isNotEmpty())
            @include('cms::web.fallback.partials.espace-forfait.forfaits')
        @endif
        @if($hotelCards->isNotEmpty())
            @include('cms::web.fallback.partials.espace-forfait.hebergement')
        @endif
        @if($gallery->isNotEmpty())
            @include('cms::web.fallback.partials.espace-forfait.galerie')
        @endif
        @if($videoItems->isNotEmpty())
            @include('cms::web.fallback.partials.espace-forfait.videos')
        @endif
        @if($reviewCards->isNotEmpty())
            @include('cms::web.fallback.partials.espace-forfait.avis')
        @endif
        @include('cms::web.fallback.partials.landing-working-hours')
        @include('cms::web.fallback.partials.espace-forfait.contact')
        @include('cms::web.fallback.partials.landing-media-slideshow')
        @include('cms::web.fallback.partials.landing-contact-ajax')
        @include('cms::web.fallback.partials.landing-cms-footer')
        @include('cms::web.fallback.partials.espace-forfait.footer')
        <div class="toast" id="toast"></div>
    </main>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/services-mega-menu-v2.js') }}"></script>
    @include('cms::web.fallback.partials.espace-forfait.scripts')
    @include('cms::web.fallback.partials.landing-cart-drawer')
    @include('cms::web.fallback.partials.landing-back-to-top')
</body>
</html>
