@php
    $activityViewFolder = 'restaurant';
    $devisLink = $devisUrl ?? url('/devis');
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
    $cmsHasLiveProducts = $cmsLandingProducts->isNotEmpty();
    $siteName = get_site_name($etablissement->id);
    $siteDescription = $etablissement->getSetting('description', null, 'general')
        ?: get_site_description($etablissement->id)
        ?: '';

    $heroPrimaryCtaText = $etablissement->getSetting('hero_cta_text', null, 'landing')
        ?: $etablissement->getSetting('cta_text', null, 'general');
    $heroPrimaryCtaUrl = $etablissement->getSetting('hero_cta_url', null, 'landing')
        ?: $devisLink;
    $heroSecondaryCtaText = $etablissement->getSetting('hero_secondary_cta_text', null, 'landing');
    $heroSecondaryCtaUrl = $etablissement->getSetting('hero_secondary_cta_url', null, 'landing');
    $heroEyebrow = $etablissement->getSetting('hero_eyebrow', null, 'landing')
        ?: ($etablissement->other_activity_label ?? $siteName);

    $phone = $etablissement->getSetting('phone', null, 'company')
        ?: $etablissement->getSetting('phone', null, 'general')
        ?: $etablissement->getSetting('telephone', null, 'general')
        ?: $etablissement->phone
        ?: $etablissement->telephone
        ?: null;

    $email = $etablissement->getSetting('email', null, 'general')
        ?: $etablissement->getSetting('email_contact', null, 'general')
        ?: $etablissement->email_contact
        ?: $etablissement->email
        ?: null;

    $address = $etablissement->getSetting('address', null, 'company')
        ?: $etablissement->getSetting('adress', null, 'company')
        ?: $etablissement->getSetting('address', null, 'general')
        ?: $etablissement->getSetting('adresse', null, 'general')
        ?: $etablissement->adresse
        ?: 'Adresse en cours de configuration';
    $hours = $etablissement->getSetting('opening_hours', [], 'company');
    $workingHours = normalize_cms_opening_hours($hours, $workingHours ?? []);

    $fallbackImages = collect([
        ['thumbnail' => 'https://images.pexels.com/photos/3296434/pexels-photo-3296434.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Comptoir de produits frais'],
        ['thumbnail' => 'https://images.pexels.com/photos/566345/pexels-photo-566345.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Fruits de mer'],
        ['thumbnail' => 'https://images.pexels.com/photos/3655916/pexels-photo-3655916.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Saumon fumÃ© artisanal'],
        ['thumbnail' => 'https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Ã‰picerie fine'],
        ['thumbnail' => 'https://images.pexels.com/photos/4397919/pexels-photo-4397919.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Produits naturels'],
        ['thumbnail' => 'https://images.pexels.com/photos/6249501/pexels-photo-6249501.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Coffrets gourmands'],
        ['thumbnail' => 'https://images.pexels.com/photos/1410235/pexels-photo-1410235.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Plats prÃ©parÃ©s'],
        ['thumbnail' => 'https://images.pexels.com/photos/1295138/pexels-photo-1295138.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Approvisionnement local'],
    ]);

    $gallery = collect($mainGalleryMedia ?? [])
        ->map(fn ($row) => [
            'thumbnail' => data_get($row, 'thumbnail') ?: data_get($row, 'url'),
            'url' => data_get($row, 'url') ?: data_get($row, 'thumbnail'),
            'name' => data_get($row, 'name') ?: 'Photo du commerce',
            'type' => data_get($row, 'type') ?: 'image',
        ])
        ->filter(fn ($row) => !empty($row['thumbnail']))
        ->values();

    if ($gallery->isEmpty()) {
        $gallery = collect($galleryMedia ?? [])
            ->map(fn ($row) => [
                'thumbnail' => data_get($row, 'thumbnail') ?: data_get($row, 'url'),
                'url' => data_get($row, 'url') ?: data_get($row, 'thumbnail'),
                'name' => data_get($row, 'name') ?: 'Photo du commerce',
                'type' => data_get($row, 'type') ?: 'image',
            ])
            ->filter(fn ($row) => !empty($row['thumbnail']))
            ->values();
    }

    if ($gallery->isEmpty()) {
        $gallery = $fallbackImages;
    }

    if ($gallery->count() < 12 && $gallery->isNotEmpty()) {
        $seed = $gallery->values();
        while ($gallery->count() < 12) {
            foreach ($seed as $item) {
                $gallery->push($item);
                if ($gallery->count() >= 12) {
                    break;
                }
            }
        }
        $gallery = $gallery->values();
    }

    $foodHeroAssetUrl = static function ($path) {
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

    $foodHeroYoutubeIdFromUrl = static function ($value) {
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

    $foodHeroSliderItems = function_exists('get_slider_items')
        ? collect(get_slider_items($etablissement->id))
        : collect();

    if ($foodHeroSliderItems->isEmpty()) {
        $foodHeroSliderItems = collect($sliders ?? []);
    }

    $heroSlides = $foodHeroSliderItems->map(function ($slider) use ($foodHeroAssetUrl, $foodHeroYoutubeIdFromUrl) {
        $type = strtolower((string) (data_get($slider, 'type') ?: 'image'));
        $rawUrl = data_get($slider, 'url')
            ?: data_get($slider, 'image_url')
            ?: data_get($slider, 'image_path')
            ?: data_get($slider, 'video_url');
        $poster = $foodHeroAssetUrl(data_get($slider, 'poster_url') ?: data_get($slider, 'thumbnail_url') ?: data_get($slider, 'thumbnail_path'));
        $media = $foodHeroAssetUrl($rawUrl);
        $iframe = null;

        foreach ([data_get($slider, 'video_html'), data_get($slider, 'embed'), data_get($slider, 'video_embed_url'), $rawUrl] as $candidate) {
            if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/i', (string) $candidate, $match)) {
                $iframe = trim((string) $match[1]);
                break;
            }
        }

        $youtubeId = $foodHeroYoutubeIdFromUrl($iframe ?: $media ?: $rawUrl);
        if (!$poster && $youtubeId) {
            $poster = 'https://i.ytimg.com/vi/' . $youtubeId . '/hqdefault.jpg';
        }

        $embed = $iframe ?: ($youtubeId ? 'https://www.youtube.com/embed/' . $youtubeId . '?autoplay=1&mute=1&muted=1&loop=1&playlist=' . $youtubeId . '&controls=0&rel=0&modestbranding=1&playsinline=1' : null);

        return [
            'type' => $type,
            'url' => $media,
            'poster' => $poster,
            'embed' => $embed,
            'title' => trim((string) (data_get($slider, 'title') ?: data_get($slider, 'name') ?: '')),
            'subtitle' => trim((string) (data_get($slider, 'subtitle') ?: data_get($slider, 'description') ?: '')),
            'button_text' => trim((string) (data_get($slider, 'button_text') ?: '')),
            'button_url' => trim((string) (data_get($slider, 'button_link') ?: data_get($slider, 'button_url') ?: '')),
            'order' => (int) data_get($slider, 'order', 0),
        ];
    })->filter(fn ($slide) => !empty($slide['url']) || !empty($slide['embed']) || !empty($slide['poster']))
        ->sortBy('order')
        ->values();

    $productCards = [
        ['tag' => 'Arrivage', 'title' => 'Poissons frais', 'desc' => 'SÃ©lection quotidienne, conseils de cuisson et dÃ©coupes sur demande.', 'price' => '18,95 $ / lb', 'image' => $gallery->get(0)['thumbnail'] ?? $fallbackImages->get(0)['thumbnail']],
        ['tag' => 'Signature', 'title' => 'Fruits de mer', 'desc' => 'HuÃ®tres, crevettes et plateaux prÃªts Ã  servir pour vos Ã©vÃ©nements.', 'price' => 'Ã€ partir de 29 $', 'image' => $gallery->get(1)['thumbnail'] ?? $fallbackImages->get(1)['thumbnail']],
        ['tag' => 'Maison', 'title' => 'Fumoir artisanal', 'desc' => 'Saumon fumÃ©, marinades et spÃ©cialitÃ©s prÃ©parÃ©es avec soin.', 'price' => '14,50 $ / portion', 'image' => $gallery->get(2)['thumbnail'] ?? $fallbackImages->get(2)['thumbnail']],
        ['tag' => 'Terroir', 'title' => 'Ã‰picerie fine', 'desc' => 'Sauces, conserves, condiments, produits locaux et idÃ©es cadeaux.', 'price' => 'DÃ¨s 8,95 $', 'image' => $gallery->get(3)['thumbnail'] ?? $fallbackImages->get(3)['thumbnail']],
        ['tag' => 'SantÃ©', 'title' => 'Produits naturels', 'desc' => 'Options bio, sans gluten et recettes Ã©quilibrÃ©es pour le quotidien.', 'price' => 'DÃ¨s 6,50 $', 'image' => $gallery->get(4)['thumbnail'] ?? $fallbackImages->get(4)['thumbnail']],
        ['tag' => 'Cadeau', 'title' => 'Coffrets gourmands', 'desc' => 'Coffrets personnalisÃ©s pour clients, employÃ©s et occasions spÃ©ciales.', 'price' => 'Ã€ partir de 39 $', 'image' => $gallery->get(5)['thumbnail'] ?? $fallbackImages->get(5)['thumbnail']],
    ];

    $reviewCards = collect($reviews ?? [])->take(4)->map(fn ($review) => [
        'text' => data_get($review, 'comment') ?: data_get($review, 'text') ?: 'Excellent service et trÃ¨s beaux produits.',
        'author' => data_get($review, 'author') ?: data_get($review, 'name') ?: 'Client satisfait',
    ])->values();

    if ($reviewCards->isEmpty()) {
        $reviewCards = collect([
            ['text' => 'Produits trÃ¨s frais, Ã©quipe chaleureuse et conseils parfaits pour recevoir Ã  la maison.', 'author' => 'Marie-Claude Â· Google'],
            ['text' => 'Belle prÃ©sentation, commandes rapides et spÃ©cialitÃ©s locales vraiment savoureuses.', 'author' => 'Jean-FranÃ§ois Â· Facebook'],
            ['text' => 'Un commerce de confiance pour les plateaux, le poisson frais et les idÃ©es cadeaux.', 'author' => 'Sophie Â· Cliente fidÃ¨le'],
            ['text' => 'Service attentionnÃ©, boutique propre et sÃ©lection gourmande qui donne envie de revenir.', 'author' => 'Karim Â· Avis client'],
        ]);
    }

    $foodBlogPosts = collect($blogPosts ?? [])
        ->filter(fn ($post) => trim((string) data_get($post, 'title')) !== '')
        ->take(3)
        ->values();
    $foodBlogFallbackImage = $gallery->first()['thumbnail'] ?? $fallbackImages->first()['thumbnail'];

    $instagramPosts = collect($instagramGalleryMedia ?? [])->filter(fn ($row) => !empty($row['thumbnail']))->values();
    if ($instagramPosts->isEmpty()) {
        $instagramPosts = $gallery->slice(max(0, $gallery->count() - 4))->values();
    }
    if ($instagramPosts->count() < 4) {
        $instagramPosts = $gallery->take(4)->values();
    }

    $facebookPostsMedia = collect($facebookGalleryMedia ?? [])->filter(fn ($row) => !empty($row['thumbnail']))->values();
    if ($facebookPostsMedia->isEmpty()) {
        $facebookPostsMedia = $gallery->slice(8, 2)->values();
    }
    if ($facebookPostsMedia->count() < 2) {
        $facebookPostsMedia = $gallery->take(2)->values();
    }

    $mapLat = $mapLatitude ?? 46.8139;
    $mapLng = $mapLongitude ?? -71.2082;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($siteDescription), 155) }}">
    <title>{{ $siteName }} | Commerce alimentaire</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/restaurant-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">

    <style>
        :root {
            --food-ink: #1a1714;
            --food-cream: #f7f0e6;
            --food-sand: #e8d9c3;
            --food-rust: #c8552c;
            --food-ocean: #0f5566;
            --food-seafoam: #9fc7bf;
            --food-gold: #d69a3a;
            --food-white: #ffffff;
            --food-smoke: #f5f5f2;
            --food-muted: #766b61;
            --food-border: rgba(26, 23, 20, .12);
            --food-shadow: 0 22px 60px rgba(26, 23, 20, .12);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            background: radial-gradient(circle at top left, rgba(214, 154, 58, .18), transparent 34%), var(--food-cream);
            color: var(--food-ink);
            font-family: Inter, sans-serif;
            overflow-x: hidden;
        }
        img, video, iframe { max-width: 100%; }
        a { color: inherit; }

        .food-page { padding-top: 96px; }
        .food-wrap {
            width: min(1580px, calc(100vw - 28px));
            margin: 0 auto 48px;
        }
        .food-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 18px;
            align-items: start;
        }
        .food-card {
            background: rgba(255, 255, 255, .88);
            border: 1px solid var(--food-border);
            border-radius: 26px;
            box-shadow: var(--food-shadow);
            overflow: hidden;
        }
        .food-card-pad { padding: 22px; }
        .food-brand-card { text-align: center; }
        .food-brand-logo {
            width: min(220px, 78%);
            max-height: 120px;
            object-fit: contain;
            margin: 0 auto 14px;
            display: block;
        }
        .food-brand-fallback {
            width: 94px;
            height: 94px;
            margin: 0 auto 14px;
            border-radius: 30px;
            background: linear-gradient(135deg, var(--food-ocean), var(--food-rust));
            color: #fff;
            display: grid;
            place-items: center;
            font: 900 2.2rem Fraunces, serif;
        }
        .food-brand-card h1 {
            margin: 0 0 10px;
            font: 900 clamp(1.45rem, 3vw, 2rem) Fraunces, serif;
            line-height: 1;
        }
        .food-brand-card p { color: var(--food-muted); margin: 0 0 18px; line-height: 1.65; }
        .food-contact-mini {
            display: grid;
            gap: 9px;
            text-align: left;
            color: var(--food-muted);
            font-size: .93rem;
        }
        .food-contact-mini a, .food-contact-mini span {
            display: flex;
            gap: 9px;
            align-items: flex-start;
            text-decoration: none;
        }
        .food-pills { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; }
        .food-pill {
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(200, 85, 44, .1);
            color: var(--food-rust);
            font-weight: 800;
            font-size: .76rem;
            text-transform: uppercase;
            letter-spacing: .06em;
        }
        .food-side-title {
            margin: 0 0 14px;
            font: 900 1.1rem Fraunces, serif;
        }
        .food-mini-product {
            display: grid;
            grid-template-columns: 72px 1fr;
            gap: 12px;
            padding: 10px 0;
            border-top: 1px solid var(--food-border);
        }
        .food-mini-product:first-of-type { border-top: 0; }
        .food-mini-product img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 18px;
        }
        .food-mini-product strong { display: block; font-size: .93rem; }
        .food-mini-product span { color: var(--food-rust); font-weight: 900; font-size: .86rem; }
        .food-hours { display: grid; gap: 9px; }
        .food-hour-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding-bottom: 9px;
            border-bottom: 1px dashed var(--food-border);
            color: var(--food-muted);
        }
        .food-hour-row strong { color: var(--food-ink); }

        .food-right { min-width: 0; display: grid; gap: 18px; }
        .food-header {
            position: sticky;
            top: 92px;
            z-index: 20;
            background: rgba(26, 23, 20, .96);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 28px;
            box-shadow: 0 18px 45px rgba(0,0,0,.25);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            overflow: hidden;
        }
        .food-header-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            text-decoration: none;
            min-width: 210px;
        }
        .food-header-mark {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: var(--food-gold);
            display: grid;
            place-items: center;
            color: var(--food-ink);
            font-weight: 900;
        }
        .food-header-brand span {
            font: 900 1rem Fraunces, serif;
            line-height: 1;
        }
        .food-header-links {
            display: flex;
            gap: 8px;
            align-items: center;
            overflow-x: auto;
            scrollbar-width: none;
        }
        .food-header-links::-webkit-scrollbar { display: none; }
        .food-header-links a {
            color: rgba(255,255,255,.76);
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: .05em;
            font-weight: 800;
            font-size: .76rem;
            padding: 10px 12px;
            border-radius: 999px;
            white-space: nowrap;
        }
        .food-header-links a:hover { background: rgba(255,255,255,.1); color: #fff; }
        .food-cta {
            background: var(--food-rust);
            color: #fff !important;
            text-decoration: none;
            border-radius: 999px;
            padding: 13px 18px;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 15px 30px rgba(200,85,44,.3);
            white-space: nowrap;
        }

        .food-section {
            background: rgba(255,255,255,.9);
            border: 1px solid var(--food-border);
            border-radius: 32px;
            overflow: hidden;
            box-shadow: var(--food-shadow);
        }
        .food-cms-pages { display: grid; gap: 18px; }
        .food-cms-page-content {
            color: var(--food-text);
            line-height: 1.75;
        }
        .food-cms-page-content :where(h1,h2,h3,h4,h5,h6) {
            color: var(--food-dark);
            margin: 0 0 14px;
            line-height: 1.15;
        }
        .food-cms-page-content :where(p,ul,ol,blockquote,figure) { margin-bottom: 16px; }
        .food-cms-page-content :where(img,video,iframe) {
            max-width: 100%;
            border-radius: 10px;
        }
        .food-kicker {
            color: var(--food-rust);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-size: .78rem;
            margin-bottom: 14px;
        }
        .food-kicker::before { content: ""; width: 42px; height: 2px; background: var(--food-rust); }
        .food-title {
            margin: 0 0 16px;
            font: 900 clamp(2rem, 5vw, 4rem) Fraunces, serif;
            line-height: .98;
        }
        .food-title em { color: var(--food-rust); font-style: italic; }
        .food-copy { color: var(--food-muted); line-height: 1.75; font-size: 1.02rem; }

        .food-hero {
            min-height: 650px;
            position: relative;
            border-radius: 34px;
            overflow: hidden;
            box-shadow: var(--food-shadow);
            background: var(--food-ink);
        }
        .food-hero-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity .8s ease;
        }
        .food-hero-slide.is-active { opacity: 1; z-index: 1; }
        .food-hero-media { position: absolute; inset: 0; }
        .food-hero-media img,
        .food-hero-media video,
        .food-hero-media iframe {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 0;
        }
        .food-hero-slide::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(26,23,20,.88), rgba(26,23,20,.42), rgba(26,23,20,.16)),
                radial-gradient(circle at 80% 10%, rgba(214,154,58,.4), transparent 32%);
        }
        .food-hero-content {
            position: relative;
            z-index: 2;
            width: min(720px, 92%);
            min-height: 650px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: clamp(32px, 6vw, 78px);
            color: #fff;
        }
        .food-hero-badge {
            width: fit-content;
            padding: 9px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.14);
            border: 1px solid rgba(255,255,255,.24);
            color: #fff;
            font-weight: 900;
            letter-spacing: .1em;
            text-transform: uppercase;
            font-size: .77rem;
            margin-bottom: 18px;
        }
        .food-hero h2 {
            margin: 0;
            font: 900 clamp(2.7rem, 7vw, 6.5rem) Fraunces, serif;
            line-height: .92;
        }
        .food-hero p {
            max-width: 560px;
            margin: 22px 0 32px;
            color: rgba(255,255,255,.82);
            font-size: clamp(1rem, 2vw, 1.25rem);
            line-height: 1.65;
        }
        .food-hero-actions { display: flex; flex-wrap: wrap; gap: 12px; }
        .food-btn {
            border: 0;
            border-radius: 999px;
            padding: 15px 24px;
            font-weight: 900;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            cursor: pointer;
        }
        .food-btn-primary { background: var(--food-rust); color: #fff; }
        .food-btn-light { background: #fff; color: var(--food-ink); }
        .food-hero-nav {
            position: absolute;
            z-index: 4;
            right: 24px;
            bottom: 24px;
            display: flex;
            gap: 10px;
        }
        .food-hero-nav button,
        .food-carousel-btn {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,.35);
            background: rgba(255,255,255,.16);
            color: #fff;
            display: grid;
            place-items: center;
            cursor: pointer;
            backdrop-filter: blur(10px);
        }
        .food-dots {
            position: absolute;
            left: 28px;
            bottom: 36px;
            z-index: 4;
            display: flex;
            gap: 8px;
        }
        .food-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            border: 0;
            background: rgba(255,255,255,.45);
            cursor: pointer;
        }
        .food-dot.is-active { width: 30px; background: var(--food-gold); }

        .food-about-grid,
        .food-contact-grid,
        .food-feature-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: clamp(22px, 4vw, 48px);
            align-items: center;
        }
        .food-about-stack {
            position: relative;
            min-height: 500px;
        }
        .food-about-stack img {
            position: absolute;
            object-fit: cover;
            border-radius: 30px;
            box-shadow: var(--food-shadow);
        }
        .food-about-stack img:first-child { inset: 0 auto auto 0; width: 72%; height: 82%; }
        .food-about-stack img:nth-child(2) { right: 0; bottom: 0; width: 58%; height: 52%; border: 8px solid #fff; }
        .food-floating-stat {
            position: absolute;
            right: 10%;
            top: 18%;
            z-index: 2;
            background: var(--food-ocean);
            color: #fff;
            border-radius: 24px;
            padding: 18px 20px;
            box-shadow: var(--food-shadow);
        }
        .food-floating-stat strong { display: block; font: 900 2.3rem Fraunces, serif; color: var(--food-gold); }
        .food-feature-list { display: grid; gap: 12px; margin-top: 24px; }
        .food-feature-item {
            display: grid;
            grid-template-columns: 44px 1fr;
            gap: 12px;
            align-items: start;
            padding: 14px;
            border-radius: 18px;
            background: var(--food-smoke);
        }
        .food-feature-item i {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: var(--food-rust);
            color: #fff;
        }
        .food-feature-item h3 { margin: 0 0 4px; font-size: 1rem; }
        .food-feature-item p { margin: 0; color: var(--food-muted); line-height: 1.55; }

        .food-product-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }
        .food-product-card {
            border-radius: 28px;
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--food-border);
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .food-product-card:hover { transform: translateY(-6px); box-shadow: var(--food-shadow); }
        .food-product-card img { width: 100%; height: 215px; object-fit: cover; display: block; }
        .food-product-body { padding: 20px; }
        .food-product-tag {
            display: inline-flex;
            padding: 7px 11px;
            border-radius: 999px;
            background: rgba(15,85,102,.1);
            color: var(--food-ocean);
            font-weight: 900;
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 10px;
        }
        .food-product-card h3 { margin: 0 0 8px; font: 900 1.35rem Fraunces, serif; }
        .food-product-card p { color: var(--food-muted); line-height: 1.6; margin: 0 0 16px; }
        .food-price { color: var(--food-rust); font-weight: 900; font-size: 1.05rem; }

        .food-blog-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }
        .food-blog-card {
            display: flex;
            flex-direction: column;
            min-height: 100%;
            border-radius: 28px;
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--food-border);
            color: var(--food-ink);
            text-decoration: none;
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .food-blog-card:hover { transform: translateY(-6px); box-shadow: var(--food-shadow); }
        .food-blog-card img { width: 100%; height: 210px; object-fit: cover; display: block; }
        .food-blog-body { display: flex; flex-direction: column; flex: 1; padding: 20px; }
        .food-blog-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 10px;
            color: var(--food-rust);
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
        }
        .food-blog-card h3 { margin: 0 0 10px; font: 900 1.35rem Fraunces, serif; line-height: 1.18; }
        .food-blog-card p { color: var(--food-muted); line-height: 1.6; margin: 0 0 18px; }
        .food-blog-read { margin-top: auto; color: var(--food-ocean); font-weight: 900; }

        .food-feature-section {
            background: linear-gradient(135deg, var(--food-ocean), #0a2e38);
            color: #fff;
        }
        .food-feature-section .food-copy { color: rgba(255,255,255,.76); }
        .food-feature-image {
            min-height: 450px;
            border-radius: 30px;
            object-fit: cover;
            width: 100%;
            box-shadow: 0 28px 65px rgba(0,0,0,.22);
        }
        .food-feature-prices {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-top: 24px;
        }
        .food-feature-price {
            padding: 16px;
            border-radius: 18px;
            background: rgba(255,255,255,.11);
            border: 1px solid rgba(255,255,255,.16);
        }
        .food-feature-price span { display: block; color: var(--food-gold); font-weight: 900; margin-top: 5px; }

        .food-process-grid,
        .food-social-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }
        .food-step {
            border-radius: 24px;
            background: var(--food-smoke);
            overflow: hidden;
            border: 1px solid var(--food-border);
        }
        .food-step img { width: 100%; height: 150px; object-fit: cover; display: block; }
        .food-step div { padding: 18px; }
        .food-step span {
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--food-rust);
            color: #fff;
            font-weight: 900;
            margin-bottom: 12px;
        }
        .food-step h3 { margin: 0 0 6px; }
        .food-step p { margin: 0; color: var(--food-muted); line-height: 1.5; }

        .food-video-banner {
            min-height: 330px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            background: var(--food-ink);
        }
        .food-video-banner img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .35;
        }
        .food-video-banner div { position: relative; z-index: 2; padding: 36px; }

        .food-reviews-track {
            display: grid;
            grid-template-columns: repeat(4, minmax(250px, 1fr));
            gap: 16px;
        }
        .food-review {
            background: #fff;
            border-radius: 24px;
            border: 1px solid var(--food-border);
            padding: 22px;
        }
        .food-stars { color: var(--food-gold); letter-spacing: 2px; margin-bottom: 12px; }
        .food-review p { color: var(--food-muted); line-height: 1.65; margin: 0 0 16px; font-style: italic; }
        .food-review strong { color: var(--food-ink); }

        .food-gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-auto-rows: 190px;
            gap: 10px;
        }
        .food-gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            background: var(--food-smoke);
        }
        .food-gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 2; }
        .food-gallery-item:nth-child(6) { grid-column: span 2; }
        .food-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .35s ease;
        }
        .food-gallery-item:hover img { transform: scale(1.06); }
        .food-gallery-item span {
            position: absolute;
            left: 14px;
            bottom: 14px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255,255,255,.92);
            font-weight: 800;
            font-size: .8rem;
        }

        .food-insta-section {
            background: linear-gradient(145deg, #fff7ed 0%, #ffffff 100%);
        }
        .food-social-grid { grid-template-columns: repeat(4, 1fr); }
        .food-social-card {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            min-height: 280px;
            box-shadow: var(--food-shadow);
        }
        .food-social-card img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .food-social-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(transparent, rgba(0,0,0,.76));
        }
        .food-social-card div {
            position: absolute;
            z-index: 2;
            left: 18px;
            right: 18px;
            bottom: 18px;
            color: #fff;
            font-weight: 900;
        }
        .food-fb-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }
        .food-fb-post {
            background: #fff;
            border-radius: 28px;
            padding: 22px;
            border: 1px solid var(--food-border);
        }
        .food-fb-post img { width: 100%; height: 240px; object-fit: cover; border-radius: 20px; margin-top: 16px; }
        .food-fb-post-header { display: flex; gap: 12px; align-items: center; }
        .food-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #1877f2;
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 900;
        }

        .food-newsletter {
            background: linear-gradient(135deg, var(--food-rust), #eb7b35);
            color: #fff;
            text-align: center;
        }
        .food-newsletter form {
            display: flex;
            gap: 10px;
            max-width: 680px;
            margin: 24px auto 0;
        }
        .food-newsletter input {
            flex: 1;
            border: 0;
            border-radius: 999px;
            padding: 16px 20px;
            font: inherit;
        }

        .food-map {
            height: 420px;
            min-height: 100%;
            border-radius: 28px;
            overflow: hidden;
            border: 1px solid var(--food-border);
        }
        .food-form {
            display: grid;
            gap: 12px;
        }
        .food-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .food-form input,
        .food-form select,
        .food-form textarea {
            width: 100%;
            border: 1px solid var(--food-border);
            border-radius: 18px;
            background: var(--food-smoke);
            padding: 15px 16px;
            font: inherit;
            outline: none;
        }
        .food-form textarea { min-height: 130px; resize: vertical; }

        .food-backtop {
            position: fixed;
            right: 24px;
            bottom: 24px;
            z-index: 1000;
            width: 54px;
            height: 54px;
            border-radius: 50%;
            border: 0;
            background: var(--food-rust);
            color: #fff;
            box-shadow: var(--food-shadow);
            display: none;
            place-items: center;
            cursor: pointer;
        }
        .food-backtop.is-visible { display: grid; }

        @media (max-width: 1180px) {
            .food-grid { grid-template-columns: 1fr; }
            .food-header { top: 82px; }
            .food-product-grid, .food-blog-grid { grid-template-columns: repeat(2, minmax(0,1fr)); }
            .food-process-grid, .food-social-grid { grid-template-columns: repeat(2, minmax(0,1fr)); }
            .food-reviews-track { grid-template-columns: repeat(2, minmax(0,1fr)); }
        }
        @media (max-width: 860px) {
            .food-page { padding-top: 80px; }
            .food-wrap { width: min(100% - 16px, 1580px); }
            .food-about-grid,
            .food-contact-grid,
            .food-feature-grid,
            .food-fb-grid { grid-template-columns: 1fr; }
            .food-header { position: relative; top: 0; align-items: flex-start; flex-direction: column; }
            .food-header-links { width: 100%; }
            .food-hero, .food-hero-content { min-height: 560px; }
            .food-product-grid,
            .food-blog-grid,
            .food-process-grid,
            .food-social-grid,
            .food-reviews-track { grid-template-columns: 1fr; }
            .food-gallery-grid { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 155px; }
            .food-gallery-item:nth-child(1),
            .food-gallery-item:nth-child(6) { grid-column: span 1; grid-row: span 1; }
            .food-form-row,
            .food-newsletter form,
            .food-feature-prices { grid-template-columns: 1fr; display: grid; }
            .food-about-stack { min-height: 330px; }
        }
        @media (max-width: 560px) {
            .food-hero h2 { font-size: 2.45rem; }
            .food-gallery-grid { grid-template-columns: 1fr; }
            .food-header-brand { min-width: 0; }
            .food-cta { width: 100%; justify-content: center; }
        }

        /* Match the selected "marche-landing-v2" visual language inside the CMS 2-column shell. */
        :root {
            --market-ink: #0d0d0d;
            --market-cream: #f5f0e8;
            --market-sand: #e8dfc8;
            --market-rust: #c45c2a;
            --market-ocean: #1a3a4a;
            --market-gold: #c9993a;
            --market-smoke: #6b6560;
            --market-white: #fdfaf5;
        }
        .food-page {
            font-family: 'DM Sans', sans-serif;
            background: var(--market-cream);
        }
        .food-right {
            background: var(--market-cream);
            overflow: hidden;
            position: relative;
        }
        .food-card {
            border-radius: 0;
            border-color: var(--market-sand);
            box-shadow: 0 8px 34px rgba(13, 13, 13, .07);
        }
        .food-brand-card h1,
        .food-side-title {
            font-family: 'Playfair Display', serif;
            color: var(--market-ocean);
        }
        .food-brand-card p {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.08rem;
        }
        .food-pill {
            border-radius: 2px;
            background: transparent;
            color: var(--market-gold);
            border: 1px solid rgba(201, 153, 58, .35);
            letter-spacing: .15em;
        }
        .food-header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 40;
            border-radius: 0;
            border: 0;
            box-shadow: none;
            background: linear-gradient(to bottom, rgba(13,13,13,.72), rgba(13,13,13,0));
            padding: 1.2rem 3rem;
        }
        .food-header-brand {
            color: var(--market-gold);
            font-family: 'Playfair Display', serif;
            font-style: italic;
            min-width: 220px;
        }
        .food-header-mark {
            display: none;
        }
        .food-header-brand span:last-child {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-style: italic;
        }
        .food-header-links {
            gap: 2rem;
        }
        .food-header-links a {
            padding: 0;
            border-radius: 0;
            color: rgba(255,255,255,.82);
            font-size: .78rem;
            letter-spacing: .12em;
        }
        .food-header-links a:hover {
            background: transparent;
            color: var(--market-gold);
        }
        .food-cta,
        .food-btn,
        .food-btn-primary,
        .food-btn-light {
            border-radius: 2px !important;
            text-transform: uppercase;
            letter-spacing: .12em;
            font-size: .78rem;
            box-shadow: none;
        }
        .food-cta,
        .food-btn-primary {
            background: var(--market-rust) !important;
            color: #fff !important;
        }
        .food-btn-light {
            background: transparent !important;
            color: var(--market-white) !important;
            border: 1px solid rgba(245,240,232,.5);
        }
        .food-hero {
            min-height: 100vh;
            border-radius: 0;
            box-shadow: none;
        }
        .food-hero-slide::after {
            background: linear-gradient(to bottom, rgba(10,20,30,.3) 0%, rgba(10,20,30,.55) 50%, rgba(10,20,30,.78) 100%);
        }
        .food-hero-content {
            min-height: 100vh;
            width: 100%;
            max-width: none;
            align-items: center;
            text-align: center;
            padding: 2rem;
        }
        .food-hero-badge {
            background: transparent;
            border: 0;
            border-radius: 0;
            color: var(--market-gold);
            display: flex;
            gap: 1.2rem;
            align-items: center;
            letter-spacing: .3em;
            margin-bottom: 1.8rem;
        }
        .food-hero-badge::before,
        .food-hero-badge::after {
            content: "";
            display: block;
            width: 3rem;
            height: 1px;
            background: var(--market-gold);
        }
        .food-hero h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3.5rem, 8vw, 8rem);
            line-height: .92;
            max-width: 900px;
            color: var(--market-white);
        }
        .food-hero p {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1.1rem, 2vw, 1.5rem);
            color: rgba(245,240,232,.82);
            max-width: 620px;
            margin-top: 1.5rem;
        }
        .food-dots {
            left: 50%;
            bottom: 2.5rem;
            transform: translateX(-50%);
        }
        .food-dot {
            width: 6px;
            height: 6px;
            background: rgba(255,255,255,.4);
        }
        .food-dot.is-active {
            width: 24px;
            background: var(--market-gold);
        }
        .food-hero-nav {
            inset: auto 2rem auto auto;
            top: 50%;
            bottom: auto;
            transform: translateY(-50%);
            flex-direction: column;
        }
        .food-hero-nav button {
            background: rgba(0,0,0,.2);
            border-color: rgba(255,255,255,.35);
            color: #fff;
        }
        .food-section {
            border-radius: 0;
            border: 0;
            box-shadow: none;
            background: var(--market-white);
        }
        .food-kicker {
            color: var(--market-rust);
            letter-spacing: .24em;
            border-radius: 0;
            background: transparent;
            padding: 0;
            margin-bottom: 1.4rem;
        }
        .food-kicker::before {
            background: var(--market-rust);
        }
        .food-title {
            font-family: 'Playfair Display', serif;
            color: var(--market-ocean);
            font-size: clamp(2rem, 3vw, 3.2rem);
            line-height: 1.1;
        }
        .food-title em {
            color: var(--market-rust);
        }
        .food-copy {
            font-family: 'Cormorant Garamond', serif;
            color: var(--market-smoke);
            font-size: 1.18rem;
            line-height: 1.8;
        }
        .food-about-grid {
            grid-template-columns: 1fr 1fr;
            gap: 4px;
        }
        .food-about-stack {
            min-height: 620px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 4px;
        }
        .food-about-stack img {
            position: static;
            width: 100% !important;
            height: 100% !important;
            min-height: 260px;
            border-radius: 0 !important;
            border: 0 !important;
            box-shadow: none !important;
            filter: brightness(.92) saturate(.9);
        }
        .food-about-stack img:first-child {
            grid-row: span 2;
        }
        .food-floating-stat {
            left: 50%;
            right: auto;
            top: 50%;
            transform: translate(-50%, -50%);
            border-radius: 2px;
            background: var(--market-ocean);
        }
        #produits.food-section {
            background: var(--market-ink);
            position: relative;
            overflow: hidden;
        }
        #produits.food-section::before {
            content: "MARCHÃ‰";
            position: absolute;
            font-family: 'Playfair Display', serif;
            font-size: 18vw;
            font-weight: 900;
            color: rgba(255,255,255,.025);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            white-space: nowrap;
        }
        #produits .food-kicker,
        #produits .food-title,
        #produits .food-copy,
        #produits .food-title em {
            position: relative;
            z-index: 1;
        }
        #produits .food-kicker,
        #produits .food-title em {
            color: var(--market-gold);
        }
        #produits .food-title {
            color: var(--market-white);
        }
        #produits .food-copy {
            color: rgba(255,255,255,.5);
        }
        .food-product-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: rgba(255,255,255,.04);
            position: relative;
            z-index: 1;
        }
        .food-product-card {
            border-radius: 0;
            border: 1px solid rgba(255,255,255,.04);
            background: rgba(255,255,255,.04);
            box-shadow: none;
        }
        .food-product-card img {
            height: 180px;
            filter: brightness(.65) saturate(.8);
        }
        .food-product-body {
            padding: 1.5rem 1.5rem 2rem;
        }
        .food-product-card h3 {
            font-family: 'Playfair Display', serif;
            color: var(--market-white);
            font-size: 1.1rem;
        }
        .food-product-card p {
            color: rgba(255,255,255,.42);
            font-size: .8rem;
        }
        .food-product-tag {
            border-radius: 0;
            background: transparent;
            color: var(--market-gold);
            border: 1px solid rgba(201,153,58,.3);
        }
        .food-price {
            color: var(--market-white);
        }
        .food-feature-section {
            background: var(--market-cream);
            color: var(--market-ink);
        }
        .food-feature-section .food-title {
            color: var(--market-ocean);
        }
        .food-feature-section .food-copy {
            color: var(--market-smoke);
        }
        .food-feature-image {
            border-radius: 0;
            min-height: 520px;
            filter: brightness(.58) saturate(.85);
        }
        .food-feature-price {
            border-radius: 0;
            background: transparent;
            border-color: var(--market-sand);
        }
        .food-process-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }
        .food-step {
            border: 0;
            border-radius: 0;
            background: transparent;
            text-align: center;
        }
        .food-step img {
            height: 110px;
            border-radius: 4px;
        }
        .food-step div span,
        .food-step > div > span {
            margin: 0 auto 1.5rem;
            background: var(--market-cream);
            color: var(--market-rust);
            border: 1px solid var(--market-sand);
            font-family: 'Playfair Display', serif;
            font-style: italic;
        }
        .food-video-banner {
            border-radius: 0;
            min-height: 520px;
            background: var(--market-ink);
        }
        .food-video-banner img {
            filter: brightness(.4) saturate(.7);
        }
        .food-video-banner .food-title {
            color: white;
        }
        #avis.food-section {
            background: var(--market-ocean);
            position: relative;
        }
        #avis .food-kicker,
        #avis .food-title {
            color: var(--market-white);
            justify-content: center;
            text-align: center;
        }
        #avis .food-kicker::before {
            background: var(--market-gold);
        }
        #avis .food-title em {
            color: var(--market-gold);
        }
        .food-reviews-track {
            grid-template-columns: repeat(3, 1fr);
        }
        .food-review {
            border-radius: 0;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
            padding: 2.5rem;
        }
        .food-review p {
            font-family: 'Cormorant Garamond', serif;
            color: rgba(245,240,232,.85);
            font-size: 1.1rem;
        }
        .food-review strong {
            color: var(--market-white);
        }
        .food-gallery-grid {
            grid-template-columns: 2fr 1fr 1fr 1fr;
            grid-template-rows: 280px 280px;
            gap: 4px;
        }
        .food-gallery-item {
            border-radius: 0;
        }
        .food-gallery-item:nth-child(1) {
            grid-row: 1 / 3;
            grid-column: span 1;
        }
        .food-gallery-item:nth-child(6) {
            grid-column: span 1;
        }
        .food-gallery-item img {
            filter: brightness(.85) saturate(.9);
        }
        .food-gallery-item span {
            border-radius: 0;
            background: linear-gradient(to top, rgba(0,0,0,.65), transparent);
            color: #fff;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 1.5rem;
            letter-spacing: .1em;
            text-transform: uppercase;
        }
        #social.food-insta-section {
            background: var(--market-ink);
        }
        #social .food-kicker,
        #social .food-title {
            color: var(--market-white);
        }
        #social .food-title em {
            color: var(--market-gold);
        }
        #social .food-copy {
            color: rgba(255,255,255,.5);
        }
        .food-social-grid {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            padding-bottom: 1rem;
        }
        .food-social-card {
            min-width: 300px;
            height: 340px;
            border-radius: 4px;
            box-shadow: none;
        }
        .food-fb-post {
            border-radius: 6px;
            box-shadow: 0 2px 20px rgba(0,0,0,.08);
        }
        .food-fb-post img {
            border-radius: 0;
        }
        .food-newsletter {
            border-radius: 0;
            background: var(--market-rust);
            color: #fff;
            text-align: left;
        }
        .food-newsletter .food-title {
            color: #fff;
        }
        .food-newsletter form {
            flex-direction: column;
            max-width: 600px;
        }
        .food-newsletter input {
            border-radius: 2px;
            background: rgba(255,255,255,.15);
            color: #fff;
            border: 1px solid rgba(255,255,255,.3);
        }
        #contact.food-section {
            background: var(--market-ink);
            color: #fff;
        }
        #contact .food-title {
            color: var(--market-white);
        }
        #contact .food-copy,
        #contact p,
        #contact a {
            color: rgba(245,240,232,.8);
        }
        #contact .food-form input,
        #contact .food-form select,
        #contact .food-form textarea {
            border-radius: 2px;
            background: rgba(255,255,255,.08);
            border-color: rgba(255,255,255,.15);
            color: #fff;
        }
        .food-map {
            border-radius: 0;
            min-height: 600px;
            height: 100%;
        }
        @media (max-width: 1180px) {
            .food-product-grid,
            .food-blog-grid,
            .food-process-grid,
            .food-reviews-track {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 900px) {
            .food-header {
                position: relative;
                background: rgba(13,13,13,.94);
                padding: 1rem 1.2rem;
            }
            .food-header-links {
                width: 100%;
                overflow-x: auto;
            }
            .food-hero,
            .food-hero-content {
                min-height: 620px;
            }
            .food-about-grid,
            .food-feature-grid,
            .food-contact-grid {
                grid-template-columns: 1fr;
            }
            .food-product-grid,
            .food-blog-grid,
            .food-process-grid,
            .food-reviews-track {
                grid-template-columns: 1fr;
            }
            .food-section-pad {
                padding: 4rem 2rem;
            }
            .food-gallery-grid {
                grid-template-columns: 1fr 1fr;
                grid-template-rows: repeat(3,220px);
            }
            .food-gallery-item:nth-child(1) {
                grid-row: auto;
            }
        }
    </style>
</head>
<body>
    @include("cms::web.fallback.activities.$activityViewFolder.vertical-menu")
    @include('home-v2.components.Header')

    <main class="food-page">
        <div class="food-wrap">
            <div class="food-grid">
                <div class="food-right">
    @include('cms::web.fallback.partials.landing-cms-header')

                    @if(is_slider_enabled($etablissement->id) && $heroSlides->isNotEmpty())
                    <section class="food-hero" id="hero">
                        @foreach($heroSlides as $index => $slide)
                            <article class="food-hero-slide {{ $index === 0 ? 'is-active' : '' }}">
                                <div class="food-hero-media">
                                    @php
                                        $slideUrl = $slide['url'] ?: $slide['poster'];
                                        $embedUrl = $slide['embed'] ?: null;
                                        $isUploadVideo = !$embedUrl && (str_contains((string) $slideUrl, '.mp4') || str_contains((string) $slideUrl, '.webm'));
                                        $isFrame = !empty($embedUrl);
                                        $iframeAutoplayUrl = $isFrame
                                            ? $embedUrl . (str_contains((string) $embedUrl, '?') ? '&' : '?') . 'autoplay=1&mute=1&muted=1&playsinline=1&loop=1&rel=0&background=1'
                                            : $slideUrl;
                                    @endphp
                                    @if($isUploadVideo)
                                        <video autoplay muted loop playsinline src="{{ $slideUrl }}" @if(!empty($slide['poster'])) poster="{{ $slide['poster'] }}" @endif></video>
                                    @elseif($isFrame)
                                        @if(!empty($slide['poster']))
                                            <img src="{{ $slide['poster'] }}" alt="{{ $slide['title'] }}">
                                        @endif
                                        <iframe src="{{ $iframeAutoplayUrl }}" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                                    @elseif(!empty($slideUrl))
                                        <img src="{{ $slideUrl }}" alt="{{ $slide['title'] }}">
                                    @endif
                                </div>
                                <div class="food-hero-content">
                                    <h2 style="    font-size: 35px;">{{ $slide['title'] }}</h2>
                                    <p>{{ $slide['subtitle'] }}</p>
                                    <div class="food-hero-actions">
                                        @if(!empty($slide['button_text']) && !empty($slide['button_url']))
                                            <a class="food-btn food-btn-primary" href="{{ $slide['button_url'] }}" target="_blank" rel="noopener">{{ $slide['button_text'] }}</a>
                                        @endif
                                        @if(!empty($heroSecondaryCtaText) && !empty($heroSecondaryCtaUrl))
                                            <a class="food-btn food-btn-light" href="{{ $heroSecondaryCtaUrl }}">{{ $heroSecondaryCtaText }}</a>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                        <div class="food-dots">
                            @foreach($heroSlides as $index => $slide)
                                <button type="button" class="food-dot {{ $index === 0 ? 'is-active' : '' }}" data-food-slide="{{ $index }}" aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                        <div class="food-hero-nav">
                            <button type="button" id="foodHeroPrev" aria-label="Slide prÃ©cÃ©dente"><i class="fa-solid fa-arrow-left"></i></button>
                            <button type="button" id="foodHeroNext" aria-label="Slide suivante"><i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </section>
                    @endif

                    @if(collect($cmsPageSections ?? [])->isNotEmpty())
                            @foreach(collect($cmsPageSections) as $cmsPage)
                                        {!! data_get($cmsPage, 'content') !!}
                            @endforeach
                    @endif


                    @if(!empty($showFallbackProducts) && !$cmsHasLiveProducts)
                    <section class="food-section food-section-pad" id="produits">
                        <span class="food-kicker">Produits</span>
                        <h2 class="food-title">Comptoirs et produits <em>vedettes</em></h2>
                        <p class="food-copy">Une grille commerciale inspirÃ©e du design sÃ©lectionnÃ© pour prÃ©senter prix, catÃ©gories, images et textes courts.</p>
                        <div class="food-product-grid">
                            @foreach($productCards as $product)
                                <article class="food-product-card">
                                    <img src="{{ $product['image'] }}" alt="{{ $product['title'] }}">
                                    <div class="food-product-body">
                                        <span class="food-product-tag">{{ $product['tag'] }}</span>
                                        <h3>{{ $product['title'] }}</h3>
                                        <p>{{ $product['desc'] }}</p>
                                        <strong class="food-price">{{ $product['price'] }}</strong>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    @include('cms::web.fallback.partials.establishment-products', [
                        'etablissement' => $etablissement,
                        'devisLink' => $devisLink,
                        'cmsProductsTitle' => "Produits Ã  vendre de l'Ã©tablissement",
                        'cmsProductsSubtitle' => "Catalogue connectÃ© au CMS : produits publics, disponibles et associÃ©s Ã  cet Ã©tablissement.",
                        'cmsProductsSectionId' => 'produits',
                    ])






                   


                    @include('cms::web.fallback.partials.landing-working-hours')

                    @if(is_blog_enabled($etablissement->id) && $foodBlogPosts->isNotEmpty())
                        <section class="food-section food-section-pad" id="blogs">
                            <span class="food-kicker">Blog</span>
                            <h2 class="food-title">ActualitÃ©s et conseils <em>gourmands</em></h2>
                            <p class="food-copy">Articles publiÃ©s par {{ $siteName }}.</p>
                            <div class="food-blog-grid">
                                @foreach($foodBlogPosts as $post)
                                    @php
                                        $blogUrl = data_get($post, 'url') ?: '#';
                                        $isExternalBlogUrl = \Illuminate\Support\Str::startsWith($blogUrl, ['http://', 'https://', '//']);
                                        $blogImage = data_get($post, 'image') ?: $foodBlogFallbackImage;
                                        $blogExcerpt = \Illuminate\Support\Str::limit(strip_tags((string) (data_get($post, 'excerpt') ?: data_get($post, 'content'))), 140);
                                    @endphp
                                    <a class="food-blog-card" href="{{ $blogUrl }}" @if($isExternalBlogUrl) target="_blank" rel="noopener noreferrer" @endif>
                                        @if($blogImage)
                                            <img src="{{ $blogImage }}" alt="{{ data_get($post, 'title') }}">
                                        @endif
                                        <div class="food-blog-body">
                                            <div class="food-blog-meta">
                                                <span>{{ data_get($post, 'tag') ?: 'Blog' }}</span>
                                                @if(data_get($post, 'date'))
                                                    <span>â€¢</span>
                                                    <span>{{ data_get($post, 'date') }}</span>
                                                @endif
                                            </div>
                                            <h3>{{ data_get($post, 'title') }}</h3>
                                            @if($blogExcerpt)
                                                <p>{{ $blogExcerpt }}</p>
                                            @endif
                                            <span class="food-blog-read">Lire l'article <i class="fa-solid fa-arrow-right"></i></span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    <section class="food-section food-section-pad" id="contact" style="padding:20px;">
                        <div class="food-contact-grid">
                            <div>
                                <span class="food-kicker">Contact</span>
                                <h2 class="food-title">Planifiez une commande ou une demande de devis</h2>
                                <p class="food-copy">{{ $address }}</p>
                                @if($phone)<p><strong>TÃ©lÃ©phone :</strong> <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a></p>@endif
                                @if($email)<p><strong>Courriel :</strong> <a href="mailto:{{ $email }}">{{ $email }}</a></p>@endif
                                <form class="food-form" id="foodContactForm" method="POST" action="{{ route('cms.company.contact.send', ['etablissementId' => $etablissement->id]) }}" data-cms-contact-form data-cms-form-name="landing_commerce_alimentaire">
                                    @csrf
                                    <div class="food-form-row">
                                        <input name="first_name" placeholder="PrÃ©nom" required>
                                        <input name="last_name" placeholder="Nom">
                                    </div>
                                    <div class="food-form-row">
                                        <input name="email" type="email" placeholder="Courriel" required>
                                        <input name="phone" placeholder="TÃ©lÃ©phone">
                                    </div>
                                    <select name="service">
                                        <option>Produits frais</option>
                                        <option>Plateaux et coffrets</option>
                                        <option>Commande spÃ©ciale</option>
                                        <option>Demande de partenariat</option>
                                    </select>
                                    <textarea name="message" placeholder="DÃ©crivez votre besoin" required></textarea>
                                    <button class="food-btn food-btn-primary" type="submit">Envoyer ma demande</button>
                                </form>
                            </div>
                            @if(is_maps_enabled($etablissement->id) && get_map_video_points($etablissement->id)->isNotEmpty())
                                <div class="food-map">
                                    @include('cms::web.fallback.partials.landing-map-video-points', ['landingMapVariant' => 'inline'])
                                </div>
                            @endif
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
    @include('cms::web.fallback.partials.landing-media-slideshow')
    @include('cms::web.fallback.partials.landing-contact-ajax')

    @include("cms::web.fallback.activities.$activityViewFolder.footer")

    <button type="button" class="food-backtop" id="foodBackTop" aria-label="Retour en haut"><i class="fa-solid fa-arrow-up"></i></button>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/services-mega-menu-v2.js') }}"></script>
    <script>
        (function () {
            const slides = Array.from(document.querySelectorAll('.food-hero-slide'));
            const dots = Array.from(document.querySelectorAll('.food-dot'));
            let current = 0;
            let timer = null;

            function showSlide(index) {
                if (!slides.length) return;
                slides[current].classList.remove('is-active');
                dots[current]?.classList.remove('is-active');
                current = (index + slides.length) % slides.length;
                slides[current].classList.add('is-active');
                dots[current]?.classList.add('is-active');
            }

            function restartTimer() {
                if (timer) clearInterval(timer);
                timer = setInterval(() => showSlide(current + 1), 6000);
            }

            document.getElementById('foodHeroNext')?.addEventListener('click', () => { showSlide(current + 1); restartTimer(); });
            document.getElementById('foodHeroPrev')?.addEventListener('click', () => { showSlide(current - 1); restartTimer(); });
            dots.forEach((dot, index) => dot.addEventListener('click', () => { showSlide(index); restartTimer(); }));
            restartTimer();

            const backTop = document.getElementById('foodBackTop');
            window.addEventListener('scroll', () => backTop?.classList.toggle('is-visible', window.scrollY > 500));
            backTop?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

            document.getElementById('foodContactForm')?.addEventListener('submit', function (event) {
                if (this.hasAttribute('data-cms-contact-form')) {
                    return;
                }

                event.preventDefault();
                const params = new URLSearchParams(new FormData(this));
                params.set('etablissement_id', '{{ $etablissement->id }}');
                window.open('{{ $devisLink }}?' + params.toString(), '_blank');
            });

            const mapNode = document.getElementById('foodMap');
            if (mapNode && window.L) {
                const fallbackLat = Number(mapNode.dataset.lat || 46.8139);
                const fallbackLng = Number(mapNode.dataset.lng || -71.2082);
                const title = mapNode.dataset.title || '{{ addslashes($siteName) }}';
                const address = mapNode.dataset.address || '{{ addslashes($address) }}';
                const videoUrl = mapNode.dataset.video || 'https://www.youtube.com/embed/0edALYi7_Qs?autoplay=1&mute=1&playsinline=1&rel=0';

                const map = L.map(mapNode, {
                    zoomControl: true,
                    scrollWheelZoom: false
                }).setView([fallbackLat, fallbackLng], 7);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                const markerIcon = L.divIcon({
                    className: 'food-map-marker',
                    html: '<div style="width:44px;height:44px;border-radius:50%;background:#c45c2a;color:white;display:grid;place-items:center;box-shadow:0 12px 25px rgba(0,0,0,.25);border:3px solid white;"><i class="fa-solid fa-basket-shopping"></i></div>',
                    iconSize: [44, 44],
                    iconAnchor: [22, 40],
                    popupAnchor: [0, -34]
                });

                const popupHtml = `
                    <div style="width:320px;max-width:100%;">
                        <div style="font-weight:800;margin-bottom:4px;color:#1a3a4a;">${title}</div>
                        <div style="font-size:13px;line-height:1.45;color:#6b6560;margin-bottom:10px;">
                            <i class="fa-solid fa-location-dot" style="color:#c45c2a;margin-right:5px;"></i>${address}
                        </div>
                        <iframe
                            width="320"
                            height="180"
                            src="${videoUrl}"
                            title="VidÃ©o Ã©tablissement"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            style="display:block;width:100%;border-radius:8px;">
                        </iframe>
                    </div>
                `;

                let currentMarker = null;
                const placeMarker = function (lat, lng, zoom = 16) {
                    if (currentMarker) {
                        map.removeLayer(currentMarker);
                    }
                    map.setView([lat, lng], zoom);
                    currentMarker = L.marker([lat, lng], { icon: markerIcon })
                        .addTo(map)
                        .bindPopup(popupHtml, { maxWidth: 360, minWidth: 260 });
                    setTimeout(function () {
                        map.invalidateSize();
                    }, 260);
                };

                placeMarker(fallbackLat, fallbackLng, 7);

                if (address && !address.toLowerCase().includes('adresse en cours')) {
                    const geocodeUrl = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(address);
                    fetch(geocodeUrl, { headers: { 'Accept': 'application/json' } })
                        .then(function (response) { return response.ok ? response.json() : []; })
                        .then(function (results) {
                            if (Array.isArray(results) && results.length) {
                                const resultLat = Number(results[0].lat);
                                const resultLng = Number(results[0].lon);
                                if (!Number.isNaN(resultLat) && !Number.isNaN(resultLng)) {
                                    placeMarker(resultLat, resultLng, 8);
                                }
                            }
                        })
                        .catch(function () {
                            placeMarker(fallbackLat, fallbackLng, 7);
                        });
                }
            }
        })();
    </script>
    @include('cms::web.fallback.partials.landing-cms-footer')
    @include('cms::web.fallback.partials.landing-back-to-top')
</body>
</html>
