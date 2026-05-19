@php
    $activityViewFolder = 'restaurant';
    $devisLink = $devisUrl ?? url('/devis');
    $siteName = get_site_name($etablissement->id);
    $siteDescription = $etablissement->getSetting('description', null, 'general')
        ?: get_site_description($etablissement->id)
        ?: 'Commerce alimentaire local, produits frais, spécialités gourmandes et service de proximité.';

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

    $fallbackImages = collect([
        ['thumbnail' => 'https://images.pexels.com/photos/3296434/pexels-photo-3296434.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Comptoir de produits frais'],
        ['thumbnail' => 'https://images.pexels.com/photos/566345/pexels-photo-566345.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Fruits de mer'],
        ['thumbnail' => 'https://images.pexels.com/photos/3655916/pexels-photo-3655916.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Saumon fumé artisanal'],
        ['thumbnail' => 'https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Épicerie fine'],
        ['thumbnail' => 'https://images.pexels.com/photos/4397919/pexels-photo-4397919.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Produits naturels'],
        ['thumbnail' => 'https://images.pexels.com/photos/6249501/pexels-photo-6249501.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Coffrets gourmands'],
        ['thumbnail' => 'https://images.pexels.com/photos/1410235/pexels-photo-1410235.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Plats préparés'],
        ['thumbnail' => 'https://images.pexels.com/photos/1295138/pexels-photo-1295138.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop', 'name' => 'Approvisionnement local'],
    ]);

    $gallery = collect($galleryMedia ?? [])
        ->map(fn ($row) => [
            'thumbnail' => data_get($row, 'thumbnail') ?: data_get($row, 'url'),
            'url' => data_get($row, 'url') ?: data_get($row, 'thumbnail'),
            'name' => data_get($row, 'name') ?: 'Photo du commerce',
            'type' => data_get($row, 'type') ?: 'image',
        ])
        ->filter(fn ($row) => !empty($row['thumbnail']))
        ->values();

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

    $heroSlides = collect($sliders ?? [])->map(function ($slider) use ($devisLink) {
        $type = data_get($slider, 'type', 'image');
        $url = data_get($slider, 'image_url')
            ?: data_get($slider, 'thumbnail_url')
            ?: data_get($slider, 'video_url')
            ?: data_get($slider, 'url');

        return [
            'type' => $type,
            'url' => $url,
            'embed' => data_get($slider, 'video_embed_url'),
            'title' => data_get($slider, 'title') ?: data_get($slider, 'name') ?: 'Marché alimentaire & terroir',
            'subtitle' => data_get($slider, 'subtitle') ?: data_get($slider, 'description') ?: 'Produits frais, arrivages sélectionnés et expériences gourmandes locales.',
            'button_text' => data_get($slider, 'button_text') ?: 'Demander un devis',
            'button_url' => data_get($slider, 'button_url') ?: data_get($slider, 'button_link') ?: $devisLink,
        ];
    })->filter(fn ($slide) => !empty($slide['url']) || !empty($slide['embed']))->values();

    if ($heroSlides->isEmpty()) {
        $heroSlides = collect([
            [
                'type' => 'image',
                'url' => 'https://images.pexels.com/photos/3296434/pexels-photo-3296434.jpeg?auto=compress&cs=tinysrgb&w=1920&h=1080&fit=crop',
                'title' => 'Votre marché gourmand de proximité',
                'subtitle' => 'Produits frais, comptoirs spécialisés, découvertes locales et service attentionné.',
                'button_text' => 'Voir les produits',
                'button_url' => '#produits',
            ],
            [
                'type' => 'image',
                'url' => 'https://images.pexels.com/photos/566345/pexels-photo-566345.jpeg?auto=compress&cs=tinysrgb&w=1920&h=1080&fit=crop',
                'title' => 'Arrivages frais chaque semaine',
                'subtitle' => 'Poissonnerie, épicerie fine, plats prêts-à-manger et spécialités de saison.',
                'button_text' => 'Nos spécialités',
                'button_url' => '#specialites',
            ],
            [
                'type' => 'image',
                'url' => 'https://images.pexels.com/photos/3655916/pexels-photo-3655916.jpeg?auto=compress&cs=tinysrgb&w=1920&h=1080&fit=crop',
                'title' => 'Saveurs locales, présentation premium',
                'subtitle' => 'Une vitrine moderne pour vendre, inspirer et convertir vos visiteurs.',
                'button_text' => 'Demander un devis',
                'button_url' => $devisLink,
            ],
        ]);
    }

    $productCards = [
        ['tag' => 'Arrivage', 'title' => 'Poissons frais', 'desc' => 'Sélection quotidienne, conseils de cuisson et découpes sur demande.', 'price' => '18,95 $ / lb', 'image' => $gallery->get(0)['thumbnail'] ?? $fallbackImages->get(0)['thumbnail']],
        ['tag' => 'Signature', 'title' => 'Fruits de mer', 'desc' => 'Huîtres, crevettes et plateaux prêts à servir pour vos événements.', 'price' => 'À partir de 29 $', 'image' => $gallery->get(1)['thumbnail'] ?? $fallbackImages->get(1)['thumbnail']],
        ['tag' => 'Maison', 'title' => 'Fumoir artisanal', 'desc' => 'Saumon fumé, marinades et spécialités préparées avec soin.', 'price' => '14,50 $ / portion', 'image' => $gallery->get(2)['thumbnail'] ?? $fallbackImages->get(2)['thumbnail']],
        ['tag' => 'Terroir', 'title' => 'Épicerie fine', 'desc' => 'Sauces, conserves, condiments, produits locaux et idées cadeaux.', 'price' => 'Dès 8,95 $', 'image' => $gallery->get(3)['thumbnail'] ?? $fallbackImages->get(3)['thumbnail']],
        ['tag' => 'Santé', 'title' => 'Produits naturels', 'desc' => 'Options bio, sans gluten et recettes équilibrées pour le quotidien.', 'price' => 'Dès 6,50 $', 'image' => $gallery->get(4)['thumbnail'] ?? $fallbackImages->get(4)['thumbnail']],
        ['tag' => 'Cadeau', 'title' => 'Coffrets gourmands', 'desc' => 'Coffrets personnalisés pour clients, employés et occasions spéciales.', 'price' => 'À partir de 39 $', 'image' => $gallery->get(5)['thumbnail'] ?? $fallbackImages->get(5)['thumbnail']],
    ];

    $reviewCards = collect($reviews ?? [])->take(4)->map(fn ($review) => [
        'text' => data_get($review, 'comment') ?: data_get($review, 'text') ?: 'Excellent service et très beaux produits.',
        'author' => data_get($review, 'author') ?: data_get($review, 'name') ?: 'Client satisfait',
    ])->values();

    if ($reviewCards->isEmpty()) {
        $reviewCards = collect([
            ['text' => 'Produits très frais, équipe chaleureuse et conseils parfaits pour recevoir à la maison.', 'author' => 'Marie-Claude · Google'],
            ['text' => 'Belle présentation, commandes rapides et spécialités locales vraiment savoureuses.', 'author' => 'Jean-François · Facebook'],
            ['text' => 'Un commerce de confiance pour les plateaux, le poisson frais et les idées cadeaux.', 'author' => 'Sophie · Cliente fidèle'],
            ['text' => 'Service attentionné, boutique propre et sélection gourmande qui donne envie de revenir.', 'author' => 'Karim · Avis client'],
        ]);
    }

    $instagramPosts = $gallery->slice(max(0, $gallery->count() - 4))->values();
    if ($instagramPosts->count() < 4) {
        $instagramPosts = $gallery->take(4)->values();
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
            grid-template-columns: minmax(270px, 3fr) minmax(0, 9fr);
            gap: 18px;
            align-items: start;
        }
        .food-left {
            position: sticky;
            top: 104px;
            display: grid;
            gap: 16px;
            min-width: 0;
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
        .food-section-pad { padding: clamp(24px, 4vw, 54px); }
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
            .food-left { position: relative; top: 0; grid-template-columns: repeat(2, minmax(0,1fr)); }
            .food-header { top: 82px; }
            .food-product-grid { grid-template-columns: repeat(2, minmax(0,1fr)); }
            .food-process-grid, .food-social-grid { grid-template-columns: repeat(2, minmax(0,1fr)); }
            .food-reviews-track { grid-template-columns: repeat(2, minmax(0,1fr)); }
        }
        @media (max-width: 860px) {
            .food-page { padding-top: 80px; }
            .food-wrap { width: min(100% - 16px, 1580px); }
            .food-left,
            .food-about-grid,
            .food-contact-grid,
            .food-feature-grid,
            .food-fb-grid { grid-template-columns: 1fr; }
            .food-header { position: relative; top: 0; align-items: flex-start; flex-direction: column; }
            .food-header-links { width: 100%; }
            .food-hero, .food-hero-content { min-height: 560px; }
            .food-product-grid,
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
            .food-section-pad { padding: 22px; }
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
        .food-section-pad {
            padding: 7rem 5rem;
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
            content: "MARCHÉ";
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
                <aside class="food-left">
                    <section class="food-card food-card-pad food-brand-card">
                        @if(!empty($brandLogoUrl))
                            <img class="food-brand-logo" src="{{ $brandLogoUrl }}" alt="{{ $siteName }}">
                        @else
                            <div class="food-brand-fallback">{{ mb_substr($siteName, 0, 1, 'UTF-8') }}</div>
                        @endif
                        <h1>{{ $siteName }}</h1>
                        <p>{{ $siteDescription }}</p>
                        <div class="food-pills">
                            <span class="food-pill">Frais</span>
                            <span class="food-pill">Local</span>
                            <span class="food-pill">Gourmand</span>
                        </div>
                        <div class="food-contact-mini" style="margin-top:18px;">
                            @if($phone)<a href="tel:{{ preg_replace('/\s+/', '', $phone) }}"><i class="fa-solid fa-phone"></i>{{ $phone }}</a>@endif
                            @if($email)<a href="mailto:{{ $email }}"><i class="fa-solid fa-envelope"></i>{{ $email }}</a>@endif
                            <span><i class="fa-solid fa-location-dot"></i>{{ $address }}</span>
                        </div>
                    </section>

                    <section class="food-card food-card-pad">
                        <h2 class="food-side-title">Produits en vedette</h2>
                        @foreach(array_slice($productCards, 0, 4) as $product)
                            <div class="food-mini-product">
                                <img src="{{ $product['image'] }}" alt="{{ $product['title'] }}">
                                <div>
                                    <strong>{{ $product['title'] }}</strong>
                                    <span>{{ $product['price'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </section>

                    <section class="food-card food-card-pad">
                        <h2 class="food-side-title">Horaire</h2>
                        <div class="food-hours">
                            @forelse($workingHours ?? [] as $row)
                                <div class="food-hour-row"><strong>{{ $row['day'] ?? '' }}</strong><span>{{ $row['hours'] ?? '' }}</span></div>
                            @empty
                                <div class="food-hour-row"><strong>Lundi</strong><span>09:00 - 18:00</span></div>
                                <div class="food-hour-row"><strong>Mardi</strong><span>09:00 - 18:00</span></div>
                                <div class="food-hour-row"><strong>Mercredi</strong><span>09:00 - 18:00</span></div>
                                <div class="food-hour-row"><strong>Jeudi</strong><span>09:00 - 20:00</span></div>
                                <div class="food-hour-row"><strong>Vendredi</strong><span>09:00 - 20:00</span></div>
                                <div class="food-hour-row"><strong>Samedi</strong><span>09:00 - 17:00</span></div>
                                <div class="food-hour-row"><strong>Dimanche</strong><span>10:00 - 16:00</span></div>
                            @endforelse
                        </div>
                    </section>
                </aside>

                <div class="food-right">
                    <nav class="food-header" aria-label="Navigation commerce alimentaire">
                        <a class="food-header-brand" href="#hero">
                            <span class="food-header-mark"><i class="fa-solid fa-basket-shopping"></i></span>
                            <span>{{ $siteName }}</span>
                        </a>
                        <div class="food-header-links">
                            <a href="#about">À propos</a>
                            <a href="#produits">Produits</a>
                            <a href="#specialites">Spécialités</a>
                            <a href="#galerie">Galerie</a>
                            <a href="#avis">Avis</a>
                            <a href="#contact">Contact</a>
                        </div>
                        <a class="food-cta" href="{{ $devisLink }}" target="_blank" rel="noopener">
                            <i class="fa-solid fa-paper-plane"></i> Demander un devis
                        </a>
                    </nav>

                    <section class="food-hero" id="hero">
                        @foreach($heroSlides as $index => $slide)
                            <article class="food-hero-slide {{ $index === 0 ? 'is-active' : '' }}">
                                <div class="food-hero-media">
                                    @php
                                        $slideUrl = $slide['embed'] ?: $slide['url'];
                                        $isUploadVideo = str_contains((string) $slideUrl, '.mp4') || str_contains((string) $slideUrl, '.webm');
                                        $isFrame = in_array($slide['type'], ['youtube', 'vimeo', 'iframe', 'video'], true) && !$isUploadVideo && !empty($slide['embed']);
                                        $iframeAutoplayUrl = $isFrame
                                            ? $slideUrl . (str_contains((string) $slideUrl, '?') ? '&' : '?') . 'autoplay=1&mute=1&muted=1&playsinline=1&loop=1&rel=0&background=1'
                                            : $slideUrl;
                                    @endphp
                                    @if($isUploadVideo)
                                        <video autoplay muted loop playsinline src="{{ $slideUrl }}"></video>
                                    @elseif($isFrame)
                                        <iframe src="{{ $iframeAutoplayUrl }}" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                                    @else
                                        <img src="{{ $slide['url'] }}" alt="{{ $slide['title'] }}">
                                    @endif
                                </div>
                                <div class="food-hero-content">
                                    <span class="food-hero-badge">Commerce alimentaire · GoExploria</span>
                                    <h2>{{ $slide['title'] }}</h2>
                                    <p>{{ $slide['subtitle'] }}</p>
                                    <div class="food-hero-actions">
                                        <a class="food-btn food-btn-primary" href="{{ $slide['button_url'] }}" target="_blank" rel="noopener">{{ $slide['button_text'] }}</a>
                                        <a class="food-btn food-btn-light" href="#produits">Explorer les produits</a>
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
                            <button type="button" id="foodHeroPrev" aria-label="Slide précédente"><i class="fa-solid fa-arrow-left"></i></button>
                            <button type="button" id="foodHeroNext" aria-label="Slide suivante"><i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </section>

                    <section class="food-section food-section-pad" id="about">
                        <div class="food-about-grid">
                            <div class="food-about-stack">
                                <img src="{{ $gallery->get(0)['thumbnail'] }}" alt="Commerce alimentaire">
                                <img src="{{ $gallery->get(1)['thumbnail'] }}" alt="Produits frais">
                                <div class="food-floating-stat"><strong>100%</strong><span>sélection locale</span></div>
                            </div>
                            <div>
                                <span class="food-kicker">À propos</span>
                                <h2 class="food-title">Une vitrine moderne pour vos <em>saveurs</em></h2>
                                <p class="food-copy">{{ $siteDescription }}</p>
                                <div class="food-feature-list">
                                    <div class="food-feature-item"><i class="fa-solid fa-fish"></i><div><h3>Arrivages frais</h3><p>Affichez vos produits, nouveautés et arrivages directement sur votre page.</p></div></div>
                                    <div class="food-feature-item"><i class="fa-solid fa-store"></i><div><h3>Expérience boutique</h3><p>Une présentation premium qui guide le client vers la visite, l'appel ou la demande de devis.</p></div></div>
                                    <div class="food-feature-item"><i class="fa-solid fa-gift"></i><div><h3>Offres et coffrets</h3><p>Mettez en avant vos paniers, plateaux, promotions et services événementiels.</p></div></div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="food-section food-section-pad" id="produits">
                        <span class="food-kicker">Produits</span>
                        <h2 class="food-title">Comptoirs et produits <em>vedettes</em></h2>
                        <p class="food-copy">Une grille commerciale inspirée du design sélectionné pour présenter prix, catégories, images et textes courts.</p>
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

                    <section class="food-section food-section-pad food-feature-section" id="specialites">
                        <div class="food-feature-grid">
                            <div>
                                <span class="food-kicker">Spécialités maison</span>
                                <h2 class="food-title">Des offres gourmandes qui donnent envie de commander</h2>
                                <p class="food-copy">Cette section peut servir pour vos plats prêts-à-manger, fumoirs, plateaux, paniers cadeaux ou produits saisonniers.</p>
                                <div class="food-feature-prices">
                                    <div class="food-feature-price">Plateaux découvertes <span>À partir de 49 $</span></div>
                                    <div class="food-feature-price">Coffrets entreprises <span>Sur devis</span></div>
                                    <div class="food-feature-price">Commandes spéciales <span>24h - 48h</span></div>
                                    <div class="food-feature-price">Livraison locale <span>Selon secteur</span></div>
                                </div>
                            </div>
                            <img class="food-feature-image" src="{{ $gallery->get(2)['thumbnail'] }}" alt="Spécialité alimentaire">
                        </div>
                    </section>

                    <section class="food-section food-section-pad">
                        <span class="food-kicker">Parcours client</span>
                        <h2 class="food-title">Simple, rapide et orienté <em>conversion</em></h2>
                        <div class="food-process-grid">
                            @foreach([
                                ['Sélection', 'Le client découvre les produits frais et catégories.', 'fa-basket-shopping'],
                                ['Conseil', 'Il comprend vos spécialités et vos services.', 'fa-comments'],
                                ['Commande', 'Il demande un devis, appelle ou prépare sa visite.', 'fa-paper-plane'],
                                ['Fidélisation', 'Galerie, avis et réseaux renforcent la confiance.', 'fa-heart'],
                            ] as $stepIndex => $step)
                                <article class="food-step">
                                    <img src="{{ $gallery->get($stepIndex + 3)['thumbnail'] ?? $gallery->first()['thumbnail'] }}" alt="{{ $step[0] }}">
                                    <div><span>{{ $stepIndex + 1 }}</span><h3>{{ $step[0] }}</h3><p>{{ $step[1] }}</p></div>
                                </article>
                            @endforeach
                        </div>
                    </section>

                    <section class="food-section food-video-banner">
                        <img src="{{ $gallery->get(6)['thumbnail'] ?? $gallery->first()['thumbnail'] }}" alt="Marché en action">
                        <div>
                            <span class="food-kicker">Activation commerciale</span>
                            <h2 class="food-title">Prêt à vendre plus de produits en ligne ?</h2>
                            <p>Activez votre espace entreprise et transformez votre présence locale en vitrine moderne.</p>
                            <a class="food-btn food-btn-primary" href="{{ $devisLink }}" target="_blank" rel="noopener">Demander une soumission</a>
                        </div>
                    </section>

                    <section class="food-section food-section-pad" id="avis">
                        <span class="food-kicker">Avis clients</span>
                        <h2 class="food-title">La confiance se construit avec les <em>preuves</em></h2>
                        <div class="food-reviews-track">
                            @foreach($reviewCards as $review)
                                <article class="food-review">
                                    <div class="food-stars">★★★★★</div>
                                    <p>“{{ $review['text'] }}”</p>
                                    <strong>{{ $review['author'] }}</strong>
                                </article>
                            @endforeach
                        </div>
                    </section>

                    <section class="food-section food-section-pad" id="galerie">
                        <span class="food-kicker">Galerie</span>
                        <h2 class="food-title">Notre galerie <em>gourmande</em></h2>
                        <div class="food-gallery-grid">
                            @foreach($gallery->take(8) as $item)
                                <figure class="food-gallery-item">
                                    <img src="{{ $item['thumbnail'] }}" alt="{{ $item['name'] ?? 'Galerie' }}">
                                    <span>{{ $item['name'] ?? 'Photo' }}</span>
                                </figure>
                            @endforeach
                        </div>
                    </section>

                    <section class="food-section food-section-pad food-insta-section" id="social">
                        <span class="food-kicker">Réseaux sociaux</span>
                        <h2 class="food-title">Instagram, Facebook et inspirations</h2>
                        <p class="food-copy">Les 4 dernières images de la médiathèque alimentent automatiquement cette zone sociale.</p>
                        <div class="food-social-grid">
                            @foreach($instagramPosts as $post)
                                <article class="food-social-card">
                                    <img src="{{ $post['thumbnail'] }}" alt="{{ $post['name'] ?? 'Publication' }}">
                                    <div><i class="fa-brands fa-instagram"></i> #saveurslocales</div>
                                </article>
                            @endforeach
                        </div>
                    </section>

                    <section class="food-section food-section-pad">
                        <span class="food-kicker">Facebook</span>
                        <h2 class="food-title">Rejoignez la communauté</h2>
                        <div class="food-fb-grid">
                            <article class="food-fb-post">
                                <div class="food-fb-post-header"><div class="food-avatar">F</div><div><strong>{{ $siteName }}</strong><br><span class="food-copy">Aujourd'hui</span></div></div>
                                <p class="food-copy">Nouveaux arrivages, produits saisonniers et idées repas à découvrir en boutique.</p>
                                <img src="{{ $gallery->get(8)['thumbnail'] ?? $gallery->first()['thumbnail'] }}" alt="Publication Facebook">
                            </article>
                            <article class="food-fb-post">
                                <div class="food-fb-post-header"><div class="food-avatar">G</div><div><strong>Événement gourmand</strong><br><span class="food-copy">Cette semaine</span></div></div>
                                <p class="food-copy">Mettez en avant vos dégustations, promotions et offres spéciales pour attirer plus de visiteurs.</p>
                                <img src="{{ $gallery->get(9)['thumbnail'] ?? $gallery->first()['thumbnail'] }}" alt="Événement Facebook">
                            </article>
                        </div>
                    </section>

                    <section class="food-section food-section-pad food-newsletter">
                        <h2 class="food-title">Recevoir les offres et arrivages</h2>
                        <p>Une section newsletter prête pour vos campagnes locales et promotions de saison.</p>
                        <form onsubmit="event.preventDefault(); this.querySelector('button').textContent='Inscription reçue';">
                            <input type="email" placeholder="Votre courriel" aria-label="Courriel">
                            <button class="food-btn food-btn-light" type="submit">M'inscrire</button>
                        </form>
                    </section>

                    <section class="food-section food-section-pad" id="contact">
                        <div class="food-contact-grid">
                            <div>
                                <span class="food-kicker">Contact</span>
                                <h2 class="food-title">Planifiez une commande ou une demande de devis</h2>
                                <p class="food-copy">{{ $address }}</p>
                                @if($phone)<p><strong>Téléphone :</strong> <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a></p>@endif
                                @if($email)<p><strong>Courriel :</strong> <a href="mailto:{{ $email }}">{{ $email }}</a></p>@endif
                                <form class="food-form" id="foodContactForm">
                                    <div class="food-form-row">
                                        <input name="first_name" placeholder="Prénom">
                                        <input name="last_name" placeholder="Nom">
                                    </div>
                                    <div class="food-form-row">
                                        <input name="email" type="email" placeholder="Courriel">
                                        <input name="phone" placeholder="Téléphone">
                                    </div>
                                    <select name="service">
                                        <option>Produits frais</option>
                                        <option>Plateaux et coffrets</option>
                                        <option>Commande spéciale</option>
                                        <option>Demande de partenariat</option>
                                    </select>
                                    <textarea name="message" placeholder="Décrivez votre besoin"></textarea>
                                    <button class="food-btn food-btn-primary" type="submit">Envoyer ma demande</button>
                                </form>
                            </div>
                            <div
                                id="foodMap"
                                class="food-map"
                                data-lat="{{ $mapLat }}"
                                data-lng="{{ $mapLng }}"
                                data-title="{{ e($siteName) }}"
                                data-address="{{ e($address) }}"
                                data-video="https://www.youtube.com/embed/0edALYi7_Qs?autoplay=1&mute=1&playsinline=1&rel=0">
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

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
                            title="Vidéo établissement"
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
</body>
</html>
