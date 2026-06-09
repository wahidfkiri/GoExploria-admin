@php
    $devisLink = $devisUrl ?? route('devis');
    $siteName = get_site_name($etablissement->id) ?: ($etablissement->name ?? 'Location Vehicule');
    $siteDescription = $etablissement->getSetting('description', null, 'general')
        ?: $etablissement->getSetting('site_description', null, 'general')
        ?: get_site_description($etablissement->id)
        ?: 'Location de voitures, SUV, utilitaires et vehicules premium avec reservation rapide.';
    $brandLogo = get_logo_url($etablissement->id) ?: ($brandLogoUrl ?? null);
    $initials = collect(explode(' ', $siteName))->filter()->take(2)->map(fn ($part) => mb_substr($part, 0, 1, 'UTF-8'))->implode('') ?: 'LV';
    $phone = $etablissement->getSetting('phone', null, 'company') ?: $etablissement->getSetting('phone', null, 'general') ?: $etablissement->getSetting('telephone', null, 'general') ?: ($etablissement->phone ?? null) ?: ($etablissement->telephone ?? null) ?: '+1 514 000 0000';
    $phoneDial = preg_replace('/\D+/', '', $phone);
    $phoneDial = strlen($phoneDial) === 10 ? '+1' . $phoneDial : $phoneDial;
    $email = $etablissement->getSetting('email', null, 'company') ?: $etablissement->getSetting('email', null, 'general') ?: $etablissement->getSetting('email_contact', null, 'general') ?: ($etablissement->email_contact ?? null) ?: ($etablissement->email ?? null) ?: 'reservation@goexploria.com';
    $address = $etablissement->getSetting('address', null, 'company') ?: $etablissement->getSetting('adress', null, 'company') ?: $etablissement->getSetting('address', null, 'general') ?: $etablissement->getSetting('adresse', null, 'general') ?: ($etablissement->adresse ?? null) ?: 'Agence principale';
    $hours = $etablissement->getSetting('opening_hours', [], 'company');
    $workingHours = normalize_cms_opening_hours($hours, [
        ['day' => 'Lundi au vendredi', 'hours' => '08h00 - 19h00'],
        ['day' => 'Samedi', 'hours' => '09h00 - 17h00'],
        ['day' => 'Dimanche', 'hours' => 'Sur reservation'],
    ]);
    $openingHoursText = format_cms_opening_hours($workingHours);
    $socialLinks = $socialLinks ?? get_establishment_social_links($etablissement);
    $visibleSocialLinks = collect($socialLinks ?? [])->filter(fn ($item) => !empty(data_get($item, 'url')))->values();
    $socialIcons = [
        'facebook' => 'fab fa-facebook-f',
        'instagram' => 'fab fa-instagram',
        'twitter' => 'fab fa-x-twitter',
        'pinterest' => 'fab fa-pinterest-p',
        'linkedin' => 'fab fa-linkedin-in',
        'youtube' => 'fab fa-youtube',
        'tiktok' => 'fab fa-tiktok',
    ];
    $mapLat = (float) ($mapLatitude ?? $etablissement->latitude ?? 45.5017);
    $mapLng = (float) ($mapLongitude ?? $etablissement->longitude ?? -73.5673);
    $mapBbox = implode(',', [$mapLng - 0.02, $mapLat - 0.01, $mapLng + 0.02, $mapLat + 0.01]);

    $youtubeIdFromUrl = static function ($value) {
        $raw = trim((string) $value);
        if ($raw === '') return null;
        if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/i', $raw, $match)) {
            $raw = trim((string) $match[1]);
        }
        $host = (string) parse_url($raw, PHP_URL_HOST);
        $path = (string) parse_url($raw, PHP_URL_PATH);
        if (str_contains($host, 'youtu.be')) return trim($path, '/');
        if (str_contains($host, 'youtube.com')) {
            parse_str((string) parse_url($raw, PHP_URL_QUERY), $query);
            if (!empty($query['v'])) return (string) $query['v'];
            if (preg_match('#/(embed|shorts)/([^/?]+)#', $path, $match)) return $match[2];
        }
        return null;
    };

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
        ['thumbnail' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=1800&q=85', 'name' => 'Voiture sportive'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=1800&q=85', 'name' => 'Berline premium'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?w=1800&q=85', 'name' => 'SUV aventure'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=1200&q=85', 'name' => 'Vehicule electrique'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?w=1200&q=85', 'name' => '4x4 premium'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1541348263662-e068662d82af?w=1200&q=85', 'name' => 'Business'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=1200&q=85', 'name' => 'Route ouverte'],
        ['thumbnail' => 'https://images.unsplash.com/photo-1441148345475-03a2e82f9719?w=1200&q=85', 'name' => 'Road trip'],
    ]);

    $normalizeVehicleMedia = static function ($items, $fallback) use ($mediaUrl) {
        $media = collect($items ?? [])->map(function ($row) use ($mediaUrl) {
            $url = $mediaUrl(data_get($row, 'thumbnail') ?: data_get($row, 'url') ?: data_get($row, 'path'));
            return [
                'thumbnail' => $url,
                'url' => $mediaUrl(data_get($row, 'url') ?: data_get($row, 'path')) ?: $url,
                'name' => data_get($row, 'name') ?: data_get($row, 'title') ?: 'Vehicule',
            ];
        })->filter(fn ($row) => !empty($row['thumbnail']))->values();

        return $media->isNotEmpty() ? $media : collect($fallback)->values();
    };

    $gallery = $normalizeVehicleMedia($mainGalleryMedia ?? [], collect());
    if ($gallery->isEmpty()) $gallery = $normalizeVehicleMedia($galleryMedia ?? [], $fallbackImages);
    while ($gallery->count() < 8) $gallery = $gallery->concat($fallbackImages)->values();
    $instagramGallery = $normalizeVehicleMedia($instagramGalleryMedia ?? [], $gallery);
    $facebookGallery = $normalizeVehicleMedia($facebookGalleryMedia ?? [], $gallery);
    $pinterestGallery = $normalizeVehicleMedia($pinterestGalleryMedia ?? [], $gallery);

    $fallbackYoutubeId = $youtubeIdFromUrl($socialLinks['youtube']['url'] ?? null) ?: 'MfAAJgCzOAs';
    $vehicleMapQuery = collect();
    try {
        if (class_exists(\App\Models\MapPoint::class) && \Illuminate\Support\Facades\Schema::hasTable('map_points')) {
            $vehicleMapQuery = \App\Models\MapPoint::with(['videos'])
                ->active()
                ->where('etablissement_id', $etablissement->id)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->orderByDesc('is_featured')
                ->latest('updated_at')
                ->limit(80)
                ->get();
        }
    } catch (\Throwable $e) {
        $vehicleMapQuery = collect();
    }

    $vehicleMapPoints = $vehicleMapQuery->map(function ($point) use ($youtubeIdFromUrl, $fallbackYoutubeId) {
        $video = optional($point->videos->first());
        $youtubeId = $point->youtube_id ?: $video->youtube_id ?: $youtubeIdFromUrl($point->youtube_url ?: $video->youtube_url) ?: $fallbackYoutubeId;

        return [
            'title' => $point->title ?: 'Point de location',
            'description' => \Illuminate\Support\Str::limit(strip_tags((string) $point->description), 140),
            'category' => strtolower((string) ($point->category ?: 'vehicule')),
            'lat' => (float) $point->latitude,
            'lng' => (float) $point->longitude,
            'address' => $point->adresse ?: trim(collect([$point->ville, $point->code_postal])->filter()->implode(' ')),
            'video_embed' => 'https://www.youtube.com/embed/' . $youtubeId . '?autoplay=1&mute=1&muted=1&playsinline=1&rel=0&modestbranding=1',
        ];
    })->values();

    if ($vehicleMapPoints->isEmpty()) {
        $vehicleMapPoints = collect([[
            'title' => $siteName,
            'description' => $siteDescription,
            'category' => 'vehicule',
            'lat' => $mapLat,
            'lng' => $mapLng,
            'address' => $address,
            'video_embed' => 'https://www.youtube.com/embed/' . $fallbackYoutubeId . '?autoplay=1&mute=1&muted=1&playsinline=1&rel=0&modestbranding=1',
        ]]);
    }

    $heroSlides = collect(get_slider_items($etablissement->id))->map(function ($slider) use ($mediaUrl, $youtubeIdFromUrl) {
        $type = strtolower((string) (data_get($slider, 'type') ?: 'image'));
        $rawUrl = data_get($slider, 'url');
        $media = $mediaUrl($rawUrl);
        $poster = $mediaUrl(data_get($slider, 'poster_url'));
        $iframe = null;

        if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/i', (string) data_get($slider, 'video_html'), $match)) {
            $iframe = trim((string) $match[1]);
        }

        $youtubeId = $youtubeIdFromUrl($media);
        if (!$poster && $youtubeId) {
            $poster = 'https://i.ytimg.com/vi/' . $youtubeId . '/hqdefault.jpg';
        }

        $embed = $iframe ?: ($youtubeId ? 'https://www.youtube.com/embed/' . $youtubeId . '?autoplay=1&mute=1&muted=1&loop=1&playlist=' . $youtubeId . '&controls=0&rel=0&modestbranding=1&playsinline=1' : null);

        return [
            'type' => $type,
            'url' => $type === 'image' ? $media : ($poster ?: $media),
            'media_url' => $media,
            'embed' => $embed,
            'title' => data_get($slider, 'title'),
            'subtitle' => data_get($slider, 'subtitle'),
            'button_text' => data_get($slider, 'button_text'),
            'button_url' => data_get($slider, 'button_link'),
            'order' => (int) data_get($slider, 'order', 0),
        ];
    })->filter(fn ($slide) => !empty($slide['url']) || !empty($slide['embed']))->sortBy('order')->values();

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

    $formatPrice = static function ($value) {
        return $value === null || $value === '' ? 'Sur demande' : number_format((float) $value, 0, ',', ' ') . ' $';
    };
    $vehicleCards = $cmsLandingProducts
        ->map(function ($product, $index) use ($mediaUrl, $formatPrice, $gallery) {
            $galleryImage = is_array($product->gallery_images ?? null) ? data_get($product->gallery_images, 0) : null;
            $image = $mediaUrl($product->main_image ?: $galleryImage) ?: ($gallery[$index % max(1, $gallery->count())]['thumbnail'] ?? null);
            $category = optional($product->category)->name ?: optional($product->family)->name ?: 'Vehicule';
            return [
                'brand' => $category,
                'name' => $product->name,
                'category' => \Illuminate\Support\Str::slug($category),
                'badge' => $product->stock_management === 'sur_commande' ? 'Sur demande' : 'Disponible',
                'price' => $formatPrice($product->price_ttc ?? $product->price_ht ?? null),
                'raw_price' => (float) ($product->price_ttc ?? $product->price_ht ?? 0),
                'unit' => '',
                'image' => $image,
                'description' => $product->short_description ?: \Illuminate\Support\Str::limit(strip_tags((string) $product->long_description), 110),
                'specs' => [$category, $product->stock_management === 'sur_commande' ? 'Sur commande' : 'En stock', 'Devis rapide', 'Assistance'],
                'product_id' => $product->id,
                'etablissement_id' => $product->etablissement_id,
            ];
        })
        ->filter(fn ($vehicle) => !empty($vehicle['name']))
        ->values();
    $heroStats = collect($etablissement->getSetting('hero_stats', [], 'landing'))
        ->map(fn ($stat) => [
            'value' => data_get($stat, 'value') ?: data_get($stat, 'number'),
            'label' => data_get($stat, 'label') ?: data_get($stat, 'title'),
        ])
        ->filter(fn ($stat) => !empty($stat['value']) && !empty($stat['label']))
        ->take(3)
        ->values();

    $reviewCards = collect($reviews ?? [])->take(6)->map(function ($review) {
        return [
            'author' => data_get($review, 'author') ?: data_get($review, 'name') ?: 'Client satisfait',
            'source' => data_get($review, 'role') ?: data_get($review, 'source') ?: 'Avis verifie',
            'text' => \Illuminate\Support\Str::limit(strip_tags((string) (data_get($review, 'comment') ?: data_get($review, 'text') ?: 'Service rapide, vehicule propre et reservation simple.')), 280),
            'rating' => max(1, min(5, (int) (data_get($review, 'rating') ?: 5))),
        ];
    })->values();
    if ($reviewCards->isEmpty()) {
        $reviewCards = collect([
            ['author' => 'Marc L.', 'source' => 'Client affaires', 'rating' => 5, 'text' => 'Vehicule impeccable, pret a l heure et service tres professionnel.'],
            ['author' => 'Sophie M.', 'source' => 'Road trip famille', 'rating' => 5, 'text' => 'Reservation simple, SUV propre et retour sans attente.'],
            ['author' => 'Karim B.', 'source' => 'Location premium', 'rating' => 5, 'text' => 'Tarifs clairs, equipe reactive et voiture exactement comme annoncee.'],
        ]);
    }
    $blogCards = collect($blogPosts ?? [])->take(3);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($siteDescription), 155) }}">
    <title>{{ $siteName }} | Location de vehicules</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Nunito+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
        :root{--y:#f5c518;--y2:#ffd84d;--r:#e63946;--tr:all .45s cubic-bezier(.23,1,.32,1);--rad:14px}
        [data-theme=dark]{--bg:#0c0c0e;--bg2:#111115;--bg3:#18181e;--card:#141418;--card2:#1c1c24;--border:rgba(255,255,255,.08);--border2:rgba(255,255,255,.14);--text:#f5f2ff;--text2:#918ba6;--nav-bg:rgba(12,12,14,.92);--inp:rgba(255,255,255,.06);--sh:0 30px 80px rgba(0,0,0,.55)}
        [data-theme=light]{--bg:#f7f7fb;--bg2:#eceef8;--bg3:#e3e5f0;--card:#fff;--card2:#f1f1f8;--border:rgba(0,0,0,.08);--border2:rgba(0,0,0,.14);--text:#101018;--text2:#5d596d;--nav-bg:rgba(247,247,251,.94);--inp:rgba(0,0,0,.04);--sh:0 20px 60px rgba(0,0,0,.12)}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:var(--bg);color:var(--text);font-family:'Nunito Sans',sans-serif;overflow-x:hidden}a{color:inherit;text-decoration:none}img{display:block;max-width:100%}.container{max-width:1240px;margin:auto;padding:0 28px}section{padding:96px 0}.btn-y,body>nav#navbar .nav-cta,.car-book,.price-cta,.cf-submit{background:var(--y);color:#0c0c0e;border:0;border-radius:999px;font-weight:900;text-transform:uppercase;letter-spacing:1.5px;cursor:pointer;transition:var(--tr)}.btn-y:hover,body>nav#navbar .nav-cta:hover,.car-book:hover,.price-cta:hover,.cf-submit:hover{background:var(--y2);transform:translateY(-2px)}
        body>nav#navbar{position:fixed;inset:0 0 auto;z-index:1000;height:76px;padding:0 46px;display:flex;align-items:center;justify-content:space-between;transition:var(--tr)}body>nav#navbar.solid{background:var(--nav-bg);backdrop-filter:blur(22px);border-bottom:1px solid var(--border)}body>nav#navbar .logo{display:flex;align-items:center;gap:12px}body>nav#navbar .logo-mark{width:42px;height:42px;border-radius:10px;background:var(--y);color:#0c0c0e;display:grid;place-items:center;font-family:'Barlow Condensed',sans-serif;font-weight:900;font-size:20px;transform:skewX(-8deg);overflow:hidden}body>nav#navbar .logo-mark img{width:100%;height:100%;object-fit:contain;padding:4px;background:#fff}body>nav#navbar .logo-text{font-family:'Barlow Condensed',sans-serif;font-size:28px;font-weight:900;letter-spacing:2px;text-transform:uppercase}body>nav#navbar .logo-text span,.acc{color:var(--y)}body>nav#navbar .nav-links{display:flex;gap:26px;list-style:none;margin:0;padding:0}body>nav#navbar .nav-links a{font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:2px;color:var(--text2)}body>nav#navbar .nav-links a:hover{color:var(--y)}body>nav#navbar .nav-right{display:flex;gap:12px;align-items:center}body>nav#navbar .theme-toggle{display:none!important}body>nav#navbar .nav-cta{padding:11px 20px;font-size:12px}body>nav#navbar .ham{display:none;background:transparent;border:0}body>nav#navbar .ham span{display:block;width:24px;height:2px;background:var(--text);margin:5px}.mob-menu{display:none;position:fixed;inset:0;z-index:999;background:var(--bg);place-items:center;align-content:center;gap:22px}.mob-menu.open{display:grid}.mob-menu a{font-family:'Barlow Condensed';font-size:38px;text-transform:uppercase}.mob-close{position:absolute;right:28px;top:22px;background:none;border:0;color:var(--text);font-size:30px}
        #hero{position:relative;height:100vh;min-height:720px;overflow:hidden}.hero-swiper,.hero-swiper .swiper-wrapper,.hero-swiper .swiper-slide{height:100%}.h-slide{height:100%;position:relative}.h-img{position:absolute;inset:0;background-size:cover;background-position:center;transform:scale(1.06);transition:transform 9s ease}.swiper-slide-active .h-img{transform:scale(1)}.h-overlay{position:absolute;inset:0;background:linear-gradient(105deg,rgba(0,0,0,.86),rgba(0,0,0,.45) 55%,rgba(0,0,0,.12))}.h-content{position:absolute;z-index:2;top:50%;left:9%;transform:translateY(-48%);max-width:720px}.eyebrow{color:var(--y);font-weight:900;font-size:11px;letter-spacing:4px;text-transform:uppercase;margin-bottom:20px}.h-title{font-family:'Barlow Condensed',sans-serif;font-size:clamp(64px,10vw,128px);font-weight:900;line-height:.86;text-transform:uppercase;margin:0 0 24px;color:#fff}.h-title .stroke{-webkit-text-stroke:2px rgba(255,255,255,.72);color:transparent}.h-sub{max-width:540px;color:rgba(255,255,255,.72);font-size:17px;line-height:1.8}.h-actions{display:flex;gap:14px;flex-wrap:wrap;margin-top:34px}.btn-y{display:inline-flex;padding:15px 32px}.btn-ghost{border:1px solid rgba(255,255,255,.36);border-radius:999px;color:white;padding:14px 28px;text-transform:uppercase;font-weight:900;letter-spacing:1px}.h-kpis{position:absolute;right:52px;bottom:52px;z-index:3;display:flex;gap:10px}.h-kpi{min-width:118px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.16);backdrop-filter:blur(12px);padding:18px}.h-kpi-n{font-family:'Barlow Condensed';font-size:30px;font-weight:900;color:var(--y)}.h-kpi-l{font-size:11px;text-transform:uppercase;letter-spacing:1px;color:white}
        .booking{position:relative;z-index:5;max-width:1180px;margin:-42px auto 0;background:var(--card);border:1px solid var(--border);box-shadow:var(--sh);border-radius:18px;padding:16px;display:grid;grid-template-columns:1.2fr repeat(3,1fr) auto;gap:12px}.bb-field{background:var(--inp);border:1px solid var(--border);border-radius:12px;padding:12px}.bb-label{font-size:10px;text-transform:uppercase;letter-spacing:1.7px;color:var(--text2);font-weight:900}.bb-field input,.bb-field select{width:100%;border:0;background:transparent;color:var(--text);font:inherit;font-weight:800;outline:0;margin-top:4px}.bb-submit{border-radius:12px;padding:0 24px}
        .s-head{display:flex;justify-content:space-between;gap:34px;margin-bottom:48px}.s-label{font-size:12px;letter-spacing:3px;text-transform:uppercase;color:var(--y);font-weight:900}.s-title{font-family:'Barlow Condensed';font-size:clamp(42px,7vw,82px);line-height:.9;text-transform:uppercase;margin:10px 0 0}.s-title .str{-webkit-text-stroke:1.5px var(--text2);color:transparent}.s-sub{max-width:500px;color:var(--text2);line-height:1.8}.tabs{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:28px}.tab{border:1px solid var(--border2);background:var(--card);color:var(--text2);border-radius:999px;padding:11px 17px;font-weight:900;cursor:pointer}.tab.on,.tab:hover{background:var(--y);color:#0c0c0e;border-color:var(--y)}
        .cars-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}.car-card{background:var(--card);border:1px solid var(--border);border-radius:var(--rad);overflow:hidden;transition:var(--tr)}.car-card:hover{transform:translateY(-8px);border-color:var(--y);box-shadow:var(--sh)}.car-card.is-hidden{display:none}.car-img{height:230px;position:relative;overflow:hidden}.car-img img{width:100%;height:100%;object-fit:cover;transition:transform .6s}.car-card:hover .car-img img{transform:scale(1.07)}.badge{position:absolute;left:14px;top:14px;background:var(--y);color:#0c0c0e;border-radius:999px;padding:6px 10px;font-size:11px;font-weight:900}.wish{position:absolute;right:14px;top:14px;width:36px;height:36px;border-radius:50%;border:1px solid rgba(255,255,255,.35);background:rgba(0,0,0,.35);color:white}.car-body{padding:24px}.car-brand{color:var(--y);font-size:11px;text-transform:uppercase;letter-spacing:2px;font-weight:900}.car-name{font-family:'Barlow Condensed';font-size:30px;font-weight:900;text-transform:uppercase;line-height:.96;margin:8px 0}.car-desc{color:var(--text2);font-size:14px;line-height:1.65}.specs{display:grid;grid-template-columns:repeat(2,1fr);gap:8px;margin:18px 0}.spec{background:var(--inp);border:1px solid var(--border);border-radius:10px;padding:10px;font-size:12px;color:var(--text2)}.spec strong{display:block;color:var(--text)}.car-foot{display:flex;justify-content:space-between;align-items:center;gap:12px}.price{font-family:'Barlow Condensed';font-size:31px;font-weight:900;color:var(--y)}.price span{font-family:'Nunito Sans';font-size:12px;color:var(--text2)}.car-book{padding:12px 18px;font-size:12px}
        .cms-pages{background:var(--bg2);padding:78px 28px}.cms-card{max-width:1180px;margin:0 auto 22px;background:var(--card);border:1px solid var(--border);border-radius:var(--rad);box-shadow:var(--sh);padding:clamp(26px,4vw,52px)}.cms-content{color:var(--text2);line-height:1.8}.cms-content :where(h1,h2,h3,h4,h5,h6){font-family:'Barlow Condensed';color:var(--text);line-height:.95;text-transform:uppercase;margin:0 0 16px}.cms-content :where(p,ul,ol,blockquote,figure){margin:0 0 18px}.cms-content :where(img,video,iframe){max-width:100%;border-radius:14px}
        .why-grid,.pricing-grid,.blog-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px}.why-grid{grid-template-columns:repeat(4,1fr)}.card,.why-card,.price-card,.blog-card,.review-card{background:var(--card);border:1px solid var(--border);border-radius:var(--rad);padding:28px}.why-icon{width:50px;height:50px;border-radius:14px;background:var(--y);color:#0c0c0e;display:grid;place-items:center;font-size:22px}.why-num{color:var(--text2);font-family:'Barlow Condensed';font-size:42px;font-weight:900}.why-title,.proc-title{font-family:'Barlow Condensed';font-size:27px;text-transform:uppercase;font-weight:900}.why-desc,.proc-desc,.price-desc,.blog-excerpt{color:var(--text2);line-height:1.7}.about{display:grid;grid-template-columns:1fr 1fr;gap:54px;align-items:center}.about-img{border-radius:20px;overflow:hidden;box-shadow:var(--sh)}.about-img img{width:100%;height:520px;object-fit:cover}.process-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}.proc-step{border-top:3px solid var(--y);padding-top:22px}.proc-circle{font-family:'Barlow Condensed';font-size:52px;color:var(--y);font-weight:900}.price-card.featured{border-color:var(--y);transform:translateY(-12px)}.price-plan{font-family:'Barlow Condensed';font-size:30px;font-weight:900;text-transform:uppercase}.price-amount{font-family:'Barlow Condensed';font-size:70px;font-weight:900;color:var(--y)}.price-feats{display:grid;gap:10px;margin:24px 0}.price-cta{display:block;text-align:center;padding:14px}
        .media-panel{display:none}.media-panel.on{display:block}.gallery-grid{display:grid;grid-template-columns:repeat(4,1fr);grid-auto-rows:210px;gap:12px}.g-item{position:relative;border-radius:14px;overflow:hidden;background:var(--card)}.g-item:nth-child(1),.g-item:nth-child(6){grid-column:span 2}.g-item img{width:100%;height:100%;object-fit:cover;transition:transform .6s}.g-item:hover img{transform:scale(1.08)}.reviews-wrap{display:grid;grid-template-columns:.8fr 1.2fr;gap:34px;align-items:center}.swiper{width:100%}.review-card{min-height:270px}.stars{color:var(--y);letter-spacing:2px}.review-author{font-weight:900;margin-top:20px}.blog-card{padding:0;overflow:hidden}.blog-img{height:210px}.blog-img img{width:100%;height:100%;object-fit:cover}.blog-body{padding:24px}.blog-date{font-size:11px;color:var(--y);font-weight:900;text-transform:uppercase;letter-spacing:2px}.blog-title{font-family:'Barlow Condensed';font-size:28px;line-height:1;text-transform:uppercase;margin:10px 0}.blog-more{display:inline-flex;align-items:center;gap:8px;margin-top:16px;color:var(--y);font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:1.4px}
        .faq-layout,.contact-layout{display:grid;grid-template-columns:.85fr 1.15fr;gap:46px}.faq-list{display:grid;gap:12px}.faq-item{background:var(--card);border:1px solid var(--border);border-radius:14px;overflow:hidden}.faq-q{display:flex;justify-content:space-between;gap:18px;padding:20px;font-weight:900;cursor:pointer}.faq-a{display:none;color:var(--text2);line-height:1.75;padding:0 20px 20px}.faq-item.open .faq-a{display:block}.contact-info{display:grid;gap:12px}.c-item{display:grid;grid-template-columns:48px 1fr;gap:14px;align-items:center;background:var(--card);border:1px solid var(--border);border-radius:14px;padding:16px}.c-icon,.social a{width:46px;height:46px;border-radius:12px;background:var(--y);color:#0c0c0e;display:grid;place-items:center}.c-label{font-size:11px;text-transform:uppercase;letter-spacing:1.6px;color:var(--text2);font-weight:900}.c-val{font-weight:800}.hours{display:grid;gap:7px}.hours-row{display:flex;justify-content:space-between;gap:14px;border-bottom:1px solid var(--border);padding-bottom:7px}.social{display:flex;gap:10px;flex-wrap:wrap;margin-top:18px}.contact-form{background:var(--card);border:1px solid var(--border);border-radius:18px;padding:30px}.form-title{font-family:'Barlow Condensed';font-size:34px;text-transform:uppercase;font-weight:900;margin-bottom:18px}.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}.fg{margin-bottom:14px}.fg label{display:block;font-size:11px;color:var(--text2);font-weight:900;text-transform:uppercase;letter-spacing:1.5px;margin-bottom:6px}.fg input,.fg select,.fg textarea{width:100%;border:1px solid var(--border);background:var(--inp);border-radius:12px;color:var(--text);padding:14px;font:inherit}.fg-full{grid-column:1/-1}.cf-submit{width:100%;padding:15px}
        .map{height:420px;position:relative}.map iframe{width:100%;height:100%;border:0;filter:grayscale(.2)}[data-theme=dark] .map iframe{filter:invert(.9) hue-rotate(180deg) saturate(.6)}.map-card{position:absolute;left:28px;bottom:28px;background:var(--card);border:1px solid var(--border);border-radius:16px;padding:20px;box-shadow:var(--sh);max-width:320px}.footer{background:#060607;padding:70px 0 26px;color:white}.footer-grid{display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr;gap:34px}.footer h4{font-family:'Barlow Condensed';font-size:22px;text-transform:uppercase;color:var(--y)}.footer a,.footer p{color:rgba(255,255,255,.68)}.footer ul{list-style:none;margin:0;padding:0;display:grid;gap:10px}.footer-bottom{border-top:1px solid rgba(255,255,255,.1);margin-top:36px;padding-top:22px;display:flex;justify-content:space-between;gap:20px;flex-wrap:wrap}.float-btn{position:fixed;right:24px;bottom:24px;z-index:99;width:58px;height:58px;border-radius:50%;background:var(--y);color:#0c0c0e;display:grid;place-items:center;box-shadow:var(--sh)}
        @media(max-width:1050px){body>nav#navbar .nav-links{display:none}body>nav#navbar .ham{display:block}.booking,.cars-grid,.why-grid,.pricing-grid,.blog-grid,.process-grid,.footer-grid,.about,.faq-layout,.contact-layout,.reviews-wrap{grid-template-columns:1fr}.booking{margin:0 20px}.h-kpis{left:24px;right:24px;bottom:24px}.gallery-grid{grid-template-columns:repeat(2,1fr)}}
        @media(max-width:620px){body>nav#navbar{padding:0 20px}body>nav#navbar .logo-text{font-size:22px}.h-content{left:24px;right:24px}.h-title{font-size:58px}.h-kpis{display:none}.s-head{display:block}.form-grid{grid-template-columns:1fr}.gallery-grid{grid-template-columns:1fr}.g-item:nth-child(n){grid-column:auto}.booking{grid-template-columns:1fr}}
        body > .mob-menu, body > nav#navbar, body > footer.footer, body > .float-btn{display:none!important}.lv-global-wrap{max-width:1580px;margin:0 auto;padding:24px 16px 36px;margin-top:100px}.lv-global-row.row{display:grid;grid-template-columns:1fr;gap:18px;align-items:start}.lv-content{display:grid;gap:16px;width:100%;max-width:none;padding:0}.lv-content>section,.lv-content>.map{background:var(--card);border:1px solid var(--border);border-radius:16px;box-shadow:0 10px 22px rgba(0,0,0,.08);overflow:hidden}.lv-content section{padding:60px 0}.lv-content .container{max-width:none;padding:0 24px}.lv-content #hero{height:auto;min-height:640px;padding:0}.lv-content .booking{max-width:none;margin:0;grid-template-columns:1fr 1fr;box-shadow:none;border-radius:16px}.lv-content .cars-grid{grid-template-columns:repeat(3,minmax(0,1fr))}.lv-content .why-grid,.lv-content .process-grid{grid-template-columns:repeat(4,minmax(0,1fr))}.lv-content .pricing-grid,.lv-content .blog-grid{grid-template-columns:repeat(3,minmax(0,1fr))}.lv-content .about,.lv-content .faq-layout,.lv-content .contact-layout,.lv-content .reviews-wrap{grid-template-columns:1fr 1fr}.lv-content .gallery-grid{grid-template-columns:repeat(4,minmax(0,1fr))}@media(max-width:1050px){.lv-content .cars-grid,.lv-content .why-grid,.lv-content .process-grid,.lv-content .pricing-grid,.lv-content .blog-grid,.lv-content .gallery-grid,.lv-content .about,.lv-content .faq-layout,.lv-content .contact-layout,.lv-content .reviews-wrap{grid-template-columns:1fr}.lv-content .booking{grid-template-columns:1fr}}
    </style>
</head>
<body>
    @include('cms::web.fallback.activities.default.vertical-menu')
    @include('home-v2.components.Header')

    <main class="lv-global-wrap">
        <div class="lv-global-row row">
            <div class="lv-content">
    @include('cms::web.fallback.partials.landing-cms-header')

    @if(is_slider_enabled($etablissement->id) && $heroSlides->isNotEmpty())
    <section id="hero">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                @foreach($heroSlides as $slide)
                    @php
                        $words = collect(explode(' ', (string) $slide['title']))->filter()->values();
                        $first = $words->take(max(1, (int) ceil($words->count() / 2)))->implode(' ');
                        $second = $words->slice(max(1, (int) ceil($words->count() / 2)))->implode(' ');
                    @endphp
                    <div class="swiper-slide">
                        <div class="h-slide">
                            @if(!empty($slide['embed']))
                                @php
                                    $slideEmbed = $slide['embed']
                                        . (str_contains((string) $slide['embed'], '?') ? '&' : '?')
                                        . 'autoplay=1&mute=1&muted=1&playsinline=1';
                                @endphp
                                <iframe src="{{ $slideEmbed }}" title="{{ $slide['title'] }}" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen style="position:absolute;inset:0;width:100%;height:100%;border:0;"></iframe>
                            @elseif(($slide['type'] ?? 'image') === 'video' && !empty($slide['media_url']))
                                <video src="{{ $slide['media_url'] }}" autoplay muted loop playsinline style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;"></video>
                            @elseif(!empty($slide['url']))
                                <div class="h-img" style="background-image:url('{{ $slide['url'] }}')"></div>
                            @endif
                            <div class="h-overlay"></div>
                            <div class="h-content">
                                @if($words->isNotEmpty())
                                    <h1 class="h-title">{{ $first }}@if($second !== '')<br><span class="acc">{{ $second }}</span>@endif</h1>
                                @endif
                                @if(!empty($slide['subtitle']))
                                    <p class="h-sub">{{ $slide['subtitle'] }}</p>
                                @endif
                                @if(!empty($slide['button_text']) && !empty($slide['button_url']))
                                    <div class="h-actions">
                                        <a class="btn-y" href="{{ $slide['button_url'] }}">{{ $slide['button_text'] }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
    @endif

    @include('cms::web.fallback.partials.landing-map-video-points')

    @if(collect($cmsPageSections ?? [])->isNotEmpty())
            @foreach(collect($cmsPageSections) as $cmsPage)
                  {!! data_get($cmsPage, 'content') !!}
            @endforeach
    @endif


    @if($vehicleCards->isNotEmpty())
    <section id="fleet">
        <div class="container">
            <div class="s-head">
                <div><div class="s-label">Produits</div><h2 class="s-title">Nos Produits<br><span class="acc">disponible</span></h2></div>
                <p class="s-sub">Cette section affiche uniquement les produits ajoutes pour cet etablissement.</p>
            </div>
            @if($vehicleCards->pluck('category')->unique()->filter()->count() > 1)
            <div class="tabs">
                <button class="tab on" onclick="filterFleet(this,'all')">Tous</button>
                @foreach($vehicleCards->pluck('category')->unique()->filter()->take(6) as $cat)
                    <button class="tab" onclick="filterFleet(this,'{{ $cat }}')">{{ \Illuminate\Support\Str::headline($cat) }}</button>
                @endforeach
            </div>
            @endif
            <div class="cars-grid" id="carsGrid">
                @foreach($vehicleCards as $car)
                    @php $productLink = $devisLink . (str_contains($devisLink, '?') ? '&' : '?') . http_build_query(['etablissement_id' => $etablissement->id, 'product_id' => $car['product_id'] ?? null]); @endphp
                    <article class="car-card" data-category="{{ $car['category'] ?? 'all' }}">
                        <div class="car-img">
                            @if(!empty($car['image']))
                                <img src="{{ $car['image'] }}" alt="{{ $car['name'] }}">
                            @endif
                            <span class="badge">{{ $car['badge'] }}</span>
                            <button class="wish" type="button" onclick="toggleWish(this)">♡</button>
                        </div>
                        <div class="car-body">
                            <div class="car-brand">{{ $car['brand'] }}</div>
                            <h3 class="car-name">{{ $car['name'] }}</h3>
                            @if(!empty($car['description']))<p class="car-desc">{{ $car['description'] }}</p>@endif
                            <div class="specs">
                                @foreach(array_slice($car['specs'] ?? [], 0, 4) as $spec)
                                    <div class="spec"><strong>{{ $spec }}</strong></div>
                                @endforeach
                            </div>
                            <div class="car-foot">
                                <div class="price">{{ $car['price'] }}<span>{{ $car['unit'] ?? '' }}</span></div>
                                <button
                                    class="car-book"
                                    type="button"
                                    data-cms-cart-add
                                    data-product-id="{{ $car['product_id'] ?? '' }}"
                                    data-product-name="{{ $car['name'] }}"
                                    data-product-price="{{ $car['raw_price'] ?? 0 }}"
                                    data-product-image="{{ $car['image'] ?? '' }}"
                                    data-product-url="{{ $productLink }}"
                                    data-etablissement-id="{{ $car['etablissement_id'] ?? $etablissement->id }}"
                                    data-etablissement-name="{{ $siteName }}"
                                >
                                    Commander
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(is_blog_enabled($etablissement->id) && $blogCards->isNotEmpty())
        <section id="blog">
            <div class="container">
                <div class="s-head"><div><div class="s-label">Blog</div><h2 class="s-title">Conseils<br><span class="acc">et actualites</span></h2></div></div>
                <div class="blog-grid">
                    @foreach($blogCards as $post)
                        @php
                            $postImage = $mediaUrl(data_get($post, 'featured_image') ?: data_get($post, 'image') ?: data_get($post, 'thumbnail')) ?: ($gallery[$loop->index]['thumbnail'] ?? $gallery[0]['thumbnail']);
                            $blogUrl = data_get($post, 'url') ?: '#blog';
                            $isExternalBlogUrl = !\Illuminate\Support\Str::startsWith($blogUrl, '#');
                            $blogTargetAttrs = $isExternalBlogUrl ? ' target="_blank" rel="noopener noreferrer"' : '';
                        @endphp
                        <a class="blog-card" href="{{ $blogUrl }}"{!! $blogTargetAttrs !!}><div class="blog-img"><img src="{{ $postImage }}" alt="{{ data_get($post, 'title') }}"></div><div class="blog-body"><div class="blog-date">{{ data_get($post, 'date') ?: 'Blog' }}</div><h3 class="blog-title">{{ data_get($post, 'title') }}</h3><p class="blog-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags((string) (data_get($post, 'excerpt') ?: data_get($post, 'content'))), 140) }}</p><span class="blog-more">Lire la suite <i class="fa-solid fa-arrow-right"></i></span></div></a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('cms::web.fallback.partials.landing-working-hours')

    <section id="contact">
        <div class="container contact-layout">
            <div>
                <div class="s-label">Reservation</div>
                <h2 class="s-title">Reservez<br><span class="acc">votre vehicule</span></h2>
                <div class="contact-info">
                    <div class="c-item"><div class="c-icon"><i class="fa-solid fa-phone"></i></div><div><div class="c-label">Telephone</div><div class="c-val"><a href="tel:{{ $phoneDial }}">{{ $phone }}</a></div></div></div>
                    <div class="c-item"><div class="c-icon"><i class="fa-solid fa-envelope"></i></div><div><div class="c-label">Email</div><div class="c-val"><a href="mailto:{{ $email }}">{{ $email }}</a></div></div></div>
                    <div class="c-item"><div class="c-icon"><i class="fa-solid fa-location-dot"></i></div><div><div class="c-label">Agence</div><div class="c-val">{{ $address }}</div></div></div>
                    <div class="c-item"><div class="c-icon"><i class="fa-solid fa-clock"></i></div><div><div class="c-label">Horaires</div><div class="hours">@foreach($workingHours as $row)<div class="hours-row"><span>{{ $row['day'] ?? '' }}</span><strong>{{ $row['hours'] ?? '' }}</strong></div>@endforeach</div></div></div>
                </div>
                @if($visibleSocialLinks->isNotEmpty())
                    <div class="social">
                        @foreach($visibleSocialLinks as $social)
                            @php $key = data_get($social, 'key') ?: data_get($social, 'name'); $icon = $socialIcons[$key] ?? 'fa-solid fa-share-nodes'; @endphp
                            <a href="{{ data_get($social, 'url') }}" target="_blank" rel="noopener noreferrer" aria-label="{{ data_get($social, 'label') ?: $key }}"><i class="{{ $icon }}"></i></a>
                        @endforeach
                    </div>
                @endif
            </div>
            <form class="contact-form" method="POST" action="{{ route('cms.company.contact.send', ['etablissementId' => $etablissement->id]) }}" data-cms-contact-form data-cms-form-name="landing_location_vehicule">
                @csrf
                <input type="hidden" name="etablissement_id" value="{{ $etablissement->id }}">
                <div class="form-title">Demande de reservation</div>
                <div class="form-grid">
                    <div class="fg"><label>Prenom</label><input name="first_name" type="text" required></div>
                    <div class="fg"><label>Nom</label><input name="last_name" type="text"></div>
                    <div class="fg"><label>Email</label><input name="email" type="email" required></div>
                    <div class="fg"><label>Telephone</label><input name="phone" type="tel"></div>
                    <div class="fg fg-full"><label>Vehicule souhaite</label><select name="vehicle">@foreach($vehicleCards as $car)<option>{{ $car['name'] }}</option>@endforeach<option>Autre besoin</option></select></div>
                    <div class="fg"><label>Date depart</label><input name="start_date" type="date"></div>
                    <div class="fg"><label>Date retour</label><input name="end_date" type="date"></div>
                    <div class="fg fg-full"><label>Message</label><textarea name="message" rows="4" required></textarea></div>
                </div>
                <button class="cf-submit" type="submit">Envoyer ma demande</button>
            </form>
        </div>
    </section>
     
        @include('cms::web.fallback.partials.landing-media-slideshow')
        @include('cms::web.fallback.partials.landing-contact-ajax')
    

            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="logo"><span class="logo-mark">{{ $initials }}</span><span class="logo-text">{{ \Illuminate\Support\Str::limit($siteName, 18, '') }}<span>.</span></span></div>
                    <p>{{ $siteDescription }}</p>
                    @if($visibleSocialLinks->isNotEmpty())
                        <div class="social">
                            @foreach($visibleSocialLinks as $social)
                                @php
                                    $key = data_get($social, 'key') ?: data_get($social, 'name');
                                    $icon = $socialIcons[$key] ?? 'fa-solid fa-share-nodes';
                                @endphp
                                <a href="{{ data_get($social, 'url') }}" target="_blank" rel="noopener noreferrer"><i class="{{ $icon }}"></i></a>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div><h4>Vehicules</h4><ul><li><a href="#fleet">Citadines</a></li><li><a href="#fleet">Berlines</a></li><li><a href="#fleet">SUV</a></li><li><a href="#fleet">Prestige</a></li></ul></div>
                <div><h4>Services</h4><ul><li><a href="#pricing">Courte duree</a></li><li><a href="#pricing">Longue duree</a></li><li><a href="#contact">Livraison</a></li><li><a href="#contact">Assistance</a></li></ul></div>
                <div><h4>Contact</h4><ul><li><a href="tel:{{ $phoneDial }}">{{ $phone }}</a></li><li><a href="mailto:{{ $email }}">{{ $email }}</a></li><li><a href="#map">{{ \Illuminate\Support\Str::limit($address, 36) }}</a></li></ul></div>
            </div>
            <div class="footer-bottom"><span>© {{ date('Y') }} {{ $siteName }}.</span><span><a href="#fleet">Flotte</a> · <a href="#pricing">Tarifs</a> · <a href="#contact">Reservation</a></span></div>
        </div>
    </footer>
    @include('cms::web.fallback.partials.landing-cms-footer')
    @include('cms::web.fallback.activities.default.footer')
    <a href="#contact" class="float-btn" title="Reserver"><i class="fa-solid fa-car-side"></i></a>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/home-v2/carousel.js') }}"></script>
    <script src="{{ asset('js/home-v2/navigation.js') }}"></script>
    <script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu-service.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-destinations-mega.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/destinations-mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/destinations-search.js') }}"></script>
    <script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
    <script src="{{ asset('js/home-v2/videos-dropdown.js') }}"></script>
    <script src="{{ asset('js/home-v2/slideshows.js') }}"></script>
    <script>
        document.documentElement.setAttribute('data-theme', 'light');
        try { localStorage.setItem('dx-theme', 'light'); } catch (error) {}
        window.addEventListener('scroll', () => document.getElementById('navbar')?.classList.toggle('solid', window.scrollY > 60));
        function openMob(){document.getElementById('mobMenu')?.classList.add('open');}
        function closeMob(){document.getElementById('mobMenu')?.classList.remove('open');}
        if (document.querySelector('.hero-swiper')) {
            new Swiper('.hero-swiper', {loop:true, autoplay:{delay:6000, disableOnInteraction:false}, effect:'fade', fadeEffect:{crossFade:true}, speed:1200, pagination:{el:'.hero-swiper .swiper-pagination', clickable:true}});
        }
        new Swiper('.rev-swiper', {loop:true, autoplay:{delay:5000}, speed:800, spaceBetween:20, pagination:{el:'.rev-swiper .swiper-pagination', clickable:true}, breakpoints:{768:{slidesPerView:2}}});
        function filterFleet(btn, id){document.querySelectorAll('#fleet .tab').forEach(b => b.classList.remove('on')); btn.classList.add('on'); document.querySelectorAll('#carsGrid .car-card').forEach(card => card.classList.toggle('is-hidden', id !== 'all' && card.dataset.category !== id));}
        function switchMedia(btn, id){document.querySelectorAll('#gallery .tab').forEach(b => b.classList.remove('on')); btn.classList.add('on'); document.querySelectorAll('.media-panel').forEach(panel => panel.classList.remove('on')); document.getElementById('media-' + id)?.classList.add('on');}
        function toggleFaq(q){const item = q.parentElement; const wasOpen = item.classList.contains('open'); document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open')); if(!wasOpen) item.classList.add('open');}
        function toggleWish(btn){const active = btn.classList.toggle('active'); btn.textContent = active ? '♥' : '♡';}
        function searchCars(){const select = document.getElementById('fleetSelect'); const id = select?.value || 'all'; const tab = [...document.querySelectorAll('#fleet .tab')].find(b => b.getAttribute('onclick')?.includes("'" + id + "'")) || document.querySelector('#fleet .tab'); if(tab) filterFleet(tab, id); document.getElementById('fleet')?.scrollIntoView({behavior:'smooth'});}
        const today = new Date(); const start = document.getElementById('startDate'); const end = document.getElementById('endDate'); if(start) start.value = today.toISOString().split('T')[0]; if(end){const later = new Date(today); later.setDate(today.getDate() + 3); end.value = later.toISOString().split('T')[0];}
    </script>
    @include('cms::web.fallback.partials.landing-cart-drawer')
    @include('cms::web.fallback.partials.landing-back-to-top')
</body>
</html>
