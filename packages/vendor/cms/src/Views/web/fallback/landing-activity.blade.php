<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Landing commerciale de {{ $etablissement->name }}">
    <title>{{ $etablissement->name }} | Go Exploria Business</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">

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
        :root {
            --lf-bg: #f3f6fb;
            --lf-card: #ffffff;
            --lf-ink: #10203a;
            --lf-muted: #607089;
            --lf-accent: #eb5a2a;
            --lf-blue: #1751d1;
            --lf-border: #dce4ef;
            --lf-radius: 16px;
        }

        body {
            background: var(--lf-bg);
            color: var(--lf-ink);
        }

        .lf-wrap {
            max-width: 1580px;
            margin: 0 auto;
            padding: 24px 16px 34px;
            margin-top: 100px;
        }

        .lf-grid {
            display: grid;
            grid-template-columns: minmax(260px, 0.9fr) minmax(0, 2.7fr);
            gap: 18px;
            align-items: start;
        }

        .lf-left {
            display: grid;
            gap: 14px;
            position: sticky;
            top: 106px;
        }

        .lf-card {
            background: var(--lf-card);
            border: 1px solid var(--lf-border);
            border-radius: var(--lf-radius);
            box-shadow: 0 10px 24px rgba(14, 28, 53, 0.08);
            overflow: hidden;
        }

        .lf-head {
            padding: 16px 16px 8px;
            border-bottom: 1px solid #e8eef7;
        }

        .lf-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f203c;
        }

        .lf-sub {
            margin-top: 6px;
            color: var(--lf-muted);
            line-height: 1.5;
            font-size: 0.9rem;
        }

        .lf-body {
            padding: 14px 16px 16px;
        }

        .lf-est-line {
            display: flex;
            gap: 9px;
            font-size: 0.9rem;
            color: #294463;
            margin-bottom: 8px;
            align-items: flex-start;
        }

        .lf-pill-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }

        .lf-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            border: 1px solid #cfdbec;
            background: #f8fbff;
            color: #214069;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 5px 10px;
        }

        .lf-ads-swiper {
            border-radius: 12px;
            border: 1px solid #d9e4f2;
            overflow: hidden;
        }

        .lf-ad-item {
            position: relative;
            min-height: 184px;
            background: #eff4fc;
        }

        .lf-ad-item img {
            width: 100%;
            height: 184px;
            object-fit: cover;
            display: block;
        }

        .lf-ad-overlay {
            position: absolute;
            inset: auto 0 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.74) 100%);
            color: #fff;
            font-size: 0.88rem;
            font-weight: 700;
            padding: 10px;
        }

        .lf-hours-list {
            display: grid;
            gap: 8px;
        }

        .lf-hour {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            border: 1px solid #d9e3f2;
            border-radius: 10px;
            background: #f8fbff;
            padding: 8px 10px;
            font-size: 0.9rem;
        }

        .lf-hour span:first-child {
            color: #45607f;
            font-weight: 600;
        }

        .lf-hour span:last-child {
            color: #1e3150;
            font-weight: 800;
        }

        .lf-right {
            display: grid;
            gap: 16px;
        }

        .lf-right [id^="section-"] {
            scroll-margin-top: 110px;
        }

        .lf-hero-embed {
            padding: 0;
            overflow: hidden;
        }

        .lf-section {
            background: #fff;
            border: 1px solid var(--lf-border);
            border-radius: var(--lf-radius);
            box-shadow: 0 10px 22px rgba(16, 32, 58, 0.06);
            padding: 16px;
        }

        .lf-row-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .lf-row-head h3 {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 900;
            letter-spacing: 0.2px;
            color: #0f203c;
            text-transform: uppercase;
        }

        .lf-en-savoir {
            text-decoration: none;
            color: #fff;
            background: linear-gradient(135deg, #ec4a32, #cc1f2b);
            border-radius: 999px;
            padding: 10px 18px;
            font-size: 0.92rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .lf-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .lf-chip {
            border: 1px solid #d5deea;
            border-radius: 999px;
            padding: 8px 14px;
            font-weight: 700;
            font-size: 0.88rem;
            color: #233d61;
            background: #fff;
        }

        .lf-chip.is-active {
            background: #e23433;
            color: #fff;
            border-color: #e23433;
        }

        .lf-events {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
        }

        .lf-event {
            border: 1px solid #dde6f3;
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
            display: flex;
            flex-direction: column;
        }

        .lf-event-media {
            position: relative;
            height: 150px;
            background: #eef3fc;
        }

        .lf-event-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .lf-date {
            position: absolute;
            top: 10px;
            left: 10px;
            border-radius: 9px;
            background: #126f2f;
            color: #fff;
            font-size: 0.8rem;
            font-weight: 800;
            padding: 8px 10px;
        }

        .lf-event-body {
            padding: 12px;
            display: grid;
            gap: 8px;
            flex: 1;
        }

        .lf-event-body h4 {
            margin: 0;
            font-size: 1.02rem;
            font-weight: 800;
            color: #0f223f;
        }

        .lf-event-body p {
            margin: 0;
            color: #5c6f89;
            line-height: 1.5;
            font-size: 0.9rem;
        }

        .lf-event-meta {
            margin-top: auto;
            border-top: 1px solid #e6edf8;
            padding-top: 8px;
            font-size: 0.82rem;
            color: #355379;
            font-weight: 700;
            display: flex;
            justify-content: space-between;
            gap: 6px;
        }

        .lf-cms-page-content {
            color: #5c6f89;
            line-height: 1.75;
        }

        .lf-cms-page-content :where(h1,h2,h3,h4,h5,h6) {
            color: #0f203c;
            margin: 0 0 14px;
            line-height: 1.15;
        }

        .lf-cms-page-content :where(p,ul,ol,blockquote,figure) { margin: 0 0 16px; }
        .lf-cms-page-content :where(img,video,iframe) { max-width: 100%; border-radius: 12px; }

        .lf-destination-shell {
            border: 1px solid #dde7f4;
            border-radius: 14px;
            padding: 10px;
            background: #f9fbff;
        }

        .lf-destination-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            border-bottom: 2px solid #f36f22;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .lf-destination-breadcrumb {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px;
            font-weight: 800;
            color: #1a314f;
            text-transform: uppercase;
            font-size: 0.88rem;
        }

        .lf-destination-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #f6ba95;
            background: #fff0e8;
            border-radius: 9px;
            color: #ec6a23;
            padding: 8px 12px;
            font-weight: 800;
        }

        .lf-destination-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
        }

        .lf-destination-card {
            border: 1px solid #dfe8f5;
            border-radius: 12px;
            background: #fff;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .lf-destination-card img {
            height: 170px;
            width: 100%;
            object-fit: cover;
            display: block;
        }

        .lf-destination-card .txt {
            padding: 12px;
        }

        .lf-destination-card h4 {
            margin: 0 0 6px;
            font-size: 1.05rem;
            font-weight: 900;
            color: #10203a;
        }

        .lf-destination-card p {
            margin: 0;
            color: #5f7089;
            line-height: 1.5;
            font-size: 0.9rem;
        }

        .lf-cta-3col {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .lf-cta-card {
            border-radius: 14px;
            border: 1px solid #d8e3f2;
            background: linear-gradient(145deg, #152f57, #234a88);
            color: #fff;
            padding: 14px;
            display: grid;
            gap: 8px;
        }

        .lf-cta-card:nth-child(2) {
            background: linear-gradient(145deg, #0f6c5e, #125f73);
        }

        .lf-cta-card:nth-child(3) {
            background: linear-gradient(145deg, #b95f1f, #a8471c);
        }

        .lf-cta-card h4 {
            margin: 0;
            font-size: 1.02rem;
            font-weight: 800;
        }

        .lf-cta-card p {
            margin: 0;
            font-size: 0.9rem;
            line-height: 1.45;
            color: rgba(255, 255, 255, 0.92);
        }

        .lf-cta-link {
            margin-top: 2px;
            text-decoration: none;
            color: #fff;
            background: rgba(255, 255, 255, 0.17);
            border: 1px solid rgba(255, 255, 255, 0.38);
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 0.82rem;
            font-weight: 800;
            width: fit-content;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .lf-reviews-a {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 10px;
        }

        .lf-review-card-a {
            border: 1px solid #dbe5f2;
            border-radius: 12px;
            background: #fff;
            padding: 12px;
        }

        .lf-review-title {
            margin: 0 0 4px;
            color: #1354be;
            font-weight: 700;
            font-size: 1.02rem;
        }

        .lf-review-stars {
            color: #f4ae1d;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .lf-review-text {
            margin: 0;
            color: #5f718b;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .lf-review-foot {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #55709a;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .lf-reviews-b {
            display: grid;
            gap: 10px;
        }

        .lf-review-row {
            border: 1px solid #dbe5f2;
            border-radius: 12px;
            padding: 12px;
            background: #fff;
            display: grid;
            grid-template-columns: 94px minmax(0, 1fr);
            gap: 14px;
            align-items: start;
        }

        .lf-review-row img {
            width: 94px;
            height: 94px;
            border-radius: 14px;
            object-fit: cover;
        }

        .lf-review-row h5 {
            margin: 0 0 6px;
            font-size: 1.04rem;
            font-weight: 800;
            color: #1a2c48;
        }

        .lf-review-row p {
            margin: 0;
            color: #6a7d95;
            line-height: 1.5;
        }

        .lf-review-row .metrics {
            margin-top: 8px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            color: #33527a;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .lf-insta-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 8px;
        }

        .lf-insta-item {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #dde6f2;
            background: #f1f6ff;
        }

        .lf-insta-item img {
            width: 100%;
            height: 118px;
            object-fit: cover;
            display: block;
            transition: transform 0.25s ease;
        }

        .lf-insta-item:hover img {
            transform: scale(1.05);
        }

        .lf-contact-map {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 12px;
        }

        .lf-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .lf-input,
        .lf-select,
        .lf-textarea {
            width: 100%;
            border: 1px solid #d2deee;
            border-radius: 10px;
            background: #fff;
            color: #1f3558;
            font: inherit;
            padding: 10px 11px;
        }

        .lf-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .lf-col-full {
            grid-column: 1 / -1;
        }

        .lf-submit {
            border: 0;
            border-radius: 10px;
            background: linear-gradient(135deg, #ea7d18, #bf5f0f);
            color: #fff;
            font-weight: 800;
            font-size: 0.92rem;
            padding: 11px 14px;
            cursor: pointer;
        }

        .lf-map-box {
            border: 1px solid #d9e3f2;
            border-radius: 12px;
            overflow: hidden;
            background: #f8fbff;
            min-height: 360px;
            position: relative;
        }

        .lf-map {
            width: 100%;
            height: 100%;
            min-height: 360px;
        }

        .lf-map-note {
            position: absolute;
            left: 8px;
            right: 8px;
            bottom: 8px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid #dbe5f3;
            border-radius: 8px;
            padding: 6px 8px;
            font-size: 0.8rem;
            color: #294767;
            z-index: 500;
        }

        .lf-plan-strip {
            margin-top: 18px;
            background: #fff;
            border: 1px solid #d9e3f1;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 12px 22px rgba(20, 35, 56, 0.08);
        }

        .lf-plan-grid {
            margin-top: 10px;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
        }

        .lf-plan-card {
            text-decoration: none;
            border-radius: 12px;
            background: linear-gradient(145deg, #122645, #1d3f74);
            color: #fff;
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            min-height: 145px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .lf-plan-card h5 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 800;
        }

        .lf-plan-card p {
            margin: 0;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.88);
        }

        .lf-plan-price {
            margin-top: auto;
            font-weight: 800;
            font-size: 0.88rem;
        }

        .lf-backtop {
            position: fixed;
            right: 18px;
            bottom: 18px;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            border: 0;
            background: linear-gradient(135deg, #1d57d8, #0f3ea5);
            color: #fff;
            box-shadow: 0 12px 24px rgba(16, 38, 84, 0.28);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 9999;
            transition: transform 0.2s ease, opacity 0.2s ease;
            opacity: 0;
            pointer-events: none;
        }

        .lf-backtop.is-visible {
            opacity: 1;
            pointer-events: auto;
        }

        .lf-backtop:hover {
            transform: translateY(-2px);
        }

        .lf-marker-wrap {
            width: 34px;
            height: 34px;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            background: #e43733;
            border: 2px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .lf-marker-wrap i {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%) rotate(45deg);
            color: #fff;
            font-size: 13px;
        }

        @media (max-width: 1320px) {
            .lf-events {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .lf-destination-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .lf-insta-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        @media (max-width: 1180px) {
            .lf-grid {
                grid-template-columns: 1fr;
            }

            .lf-left {
                position: static;
            }

            .lf-cta-3col,
            .lf-reviews-a {
                grid-template-columns: 1fr;
            }

            .lf-plan-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 860px) {
            .lf-events {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .lf-contact-map,
            .lf-form-grid {
                grid-template-columns: 1fr;
            }

            .lf-review-row {
                grid-template-columns: 1fr;
            }

            .lf-review-row img {
                width: 78px;
                height: 78px;
            }

            .lf-insta-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 560px) {
            .lf-events,
            .lf-destination-grid,
            .lf-plan-grid {
                grid-template-columns: 1fr;
            }

            .lf-insta-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .lf-row-head h3 {
                font-size: 1.05rem;
            }

        }
    </style>
</head>
<body>
    @php
        $activityNamesForViews = collect($activities ?? [])
            ->map(fn ($activity) => mb_strtolower((string) ($activity->name ?? ''), 'UTF-8'))
            ->implode(' ');

        $activityViewFolder = 'default';
        if (str_contains($activityNamesForViews, 'restaurant') || str_contains($activityNamesForViews, 'alimentation') || str_contains($activityNamesForViews, 'cuisine')) {
            $activityViewFolder = 'restaurant';
        } elseif (str_contains($activityNamesForViews, 'hotel') || str_contains($activityNamesForViews, 'hébergement') || str_contains($activityNamesForViews, 'hebergement')) {
            $activityViewFolder = 'hotel';
        } elseif (str_contains($activityNamesForViews, 'voyage') || str_contains($activityNamesForViews, 'tourisme') || str_contains($activityNamesForViews, 'forfait')) {
            $activityViewFolder = 'voyage';
        } elseif (str_contains($activityNamesForViews, 'immo') || str_contains($activityNamesForViews, 'chalet') || str_contains($activityNamesForViews, 'maison')) {
            $activityViewFolder = 'immobilier';
        }
    @endphp

    @include("cms::web.fallback.activities.$activityViewFolder.vertical-menu")
    @include('home-v2.components.Header')

    @php
        $devisLink = $devisUrl ?? route('devis');
        $hours = $etablissement->getSetting('opening_hours', [], 'company');
        $workingHours = normalize_cms_opening_hours($hours, $workingHours ?? []);
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

        $eventCards = [
            [
                'date' => '15-24 JUIN',
                'title' => 'Festival d\'été de Québec',
                'desc' => 'Le plus grand festival extérieur en Amérique du Nord, avec des artistes internationaux.',
                'place' => 'Québec',
                'cat' => 'Scènes extérieures',
                'img' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'date' => '28 FÉV - 10 MAR',
                'title' => 'Carnaval de Québec',
                'desc' => 'Le plus grand carnaval d\'hiver au monde avec Bonhomme Carnaval comme ambassadeur.',
                'place' => 'Québec',
                'cat' => 'Activités hivernales',
                'img' => 'https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'date' => 'AOÛT 2026',
                'title' => 'Osheaga',
                'desc' => 'Festival de musique et arts contemporains sur l\'île Sainte-Hélène à Montréal.',
                'place' => 'Montréal',
                'cat' => 'Musique & Arts',
                'img' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'date' => 'OCT 2026',
                'title' => 'Festival des couleurs',
                'desc' => 'Célébration de l\'automne et des magnifiques paysages colorés des Cantons-de-l\'Est.',
                'place' => 'Cantons-de-l\'Est',
                'cat' => 'Nature & Culture',
                'img' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'date' => 'SEPT 2026',
                'title' => 'Festival de montgolfières',
                'desc' => 'Le plus grand rassemblement de montgolfières au Canada à Saint-Jean-sur-Richelieu.',
                'place' => 'Saint-Jean-sur-Richelieu',
                'cat' => 'Aventure',
                'img' => 'https://images.unsplash.com/photo-1506157786151-b8491531f063?auto=format&fit=crop&w=900&q=80',
            ],
        ];

        $destinationCards = [
            [
                'title' => 'Laurentides',
                'desc' => 'Paradis du ski et des activités de plein air, lacs et montagnes à perte de vue.',
                'img' => 'https://images.unsplash.com/photo-1510798831971-661eb04b3739?auto=format&fit=crop&w=1000&q=80',
            ],
            [
                'title' => 'Mont-Tremblant',
                'desc' => 'Station de ski de renommée mondiale avec village piétonnier européen.',
                'img' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?auto=format&fit=crop&w=1000&q=80',
            ],
            [
                'title' => 'Îles de la Madeleine',
                'desc' => 'Archipel unique avec plages de sable fin, falaises rouges et culture acadienne.',
                'img' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1000&q=80',
            ],
            [
                'title' => 'Vieux-Québec',
                'desc' => 'Seule ville fortifiée d\'Amérique du Nord, patrimoine mondial de l\'UNESCO.',
                'img' => 'https://images.unsplash.com/photo-1534351590666-13e3e96b5017?auto=format&fit=crop&w=1000&q=80',
            ],
        ];

        $reviewCardsA = [
            [
                'title' => 'Visibilité qui progresse',
                'rating' => '★★★★★ 4.9',
                'text' => 'La visibilité de notre entreprise a augmenté rapidement. Équipe proactive et orientée résultats.',
                'user' => 'Breana Murazik',
                'date' => '6 décembre 2025',
                'votes' => '60 votes',
            ],
            [
                'title' => 'Très bon accompagnement',
                'rating' => '★★★★☆ 4.3',
                'text' => 'Leur stratégie de diffusion et la structure de page ont amélioré nos conversions en quelques semaines.',
                'user' => 'Kaleb Wyman',
                'date' => '12 janvier 2026',
                'votes' => '55 votes',
            ],
            [
                'title' => 'Service professionnel',
                'rating' => '★★★★★ 5.0',
                'text' => 'Support rapide, design moderne et parcours client fluide. On recommande pour les PME touristiques.',
                'user' => 'Ideil Larson',
                'date' => '17 janvier 2026',
                'votes' => '62 votes',
            ],
        ];

        $reviewCardsB = [
            [
                'name' => 'Rosalina D. William',
                'text' => 'Excellent accompagnement, nos offres sont mieux présentées et nos prospects sont plus qualifiés.',
                'img' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80',
            ],
            [
                'name' => 'Michael J. Carter',
                'text' => 'Nos campagnes locales performent mieux depuis la nouvelle landing. Interface claire et très professionnelle.',
                'img' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=200&q=80',
            ],
        ];

        $activityText = $activities
            ->pluck('name')
            ->filter()
            ->map(fn ($name) => mb_strtolower((string) $name, 'UTF-8'))
            ->implode(' ');

        $galleryByActivity = [
            'restaurant' => [
                'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=700&q=80',
                'https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&w=700&q=80',
                'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?auto=format&fit=crop&w=700&q=80',
                'https://images.unsplash.com/photo-1424847651672-bf20a4b0982b?auto=format&fit=crop&w=700&q=80',
            ],
            'hotel' => [
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=700&q=80',
                'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?auto=format&fit=crop&w=700&q=80',
                'https://images.unsplash.com/photo-1455587734955-081b22074882?auto=format&fit=crop&w=700&q=80',
                'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=700&q=80',
            ],
            'voyage' => [
                'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=700&q=80',
                'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=700&q=80',
                'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=700&q=80',
                'https://images.unsplash.com/photo-1527631746610-bca00a040d60?auto=format&fit=crop&w=700&q=80',
            ],
            'immobilier' => [
                'https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=700&q=80',
                'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?auto=format&fit=crop&w=700&q=80',
                'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=700&q=80',
                'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=700&q=80',
            ],
            'default' => [
                'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=700&q=80',
                'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=700&q=80',
                'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=700&q=80',
                'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=700&q=80',
            ],
        ];

        $galleryImages = [];

        if (isset($galleryMedia) && collect($galleryMedia)->isNotEmpty()) {
            $galleryImages = collect($galleryMedia)
                ->pluck('thumbnail')
                ->filter()
                ->take(4)
                ->values()
                ->all();
        }

        if (count($galleryImages) === 0) {
            $chosen = 'default';
            if (str_contains($activityText, 'restaurant') || str_contains($activityText, 'alimentation') || str_contains($activityText, 'cuisine')) {
                $chosen = 'restaurant';
            } elseif (str_contains($activityText, 'hotel') || str_contains($activityText, 'hébergement') || str_contains($activityText, 'hebergement')) {
                $chosen = 'hotel';
            } elseif (str_contains($activityText, 'voyage') || str_contains($activityText, 'forfait') || str_contains($activityText, 'tourisme')) {
                $chosen = 'voyage';
            } elseif (str_contains($activityText, 'immo') || str_contains($activityText, 'chalet') || str_contains($activityText, 'maison')) {
                $chosen = 'immobilier';
            }

            $galleryImages = $galleryByActivity[$chosen];
        }

        $galleryImages = array_slice($galleryImages, 0, 4);
    @endphp

    <main>
        <section class="lf-wrap">
            <div class="lf-grid">
                <aside class="lf-left">
                    <article class="lf-card">
                        <div class="lf-head">
                            <h2 class="lf-title">{{ $etablissement->name }}</h2>
                            <p class="lf-sub">Présence digitale performante selon vos activités principales.</p>
                        </div>
                        <div class="lf-body">
                            @if($etablissement->adresse)
                                <div class="lf-est-line"><i class="fas fa-location-dot"></i><span>{{ $etablissement->adresse }}</span></div>
                            @endif
                            @if($etablissement->phone)
                                <div class="lf-est-line"><i class="fas fa-phone"></i><span>{{ $etablissement->phone }}</span></div>
                            @endif
                            @if($etablissement->email_contact)
                                <div class="lf-est-line"><i class="fas fa-envelope"></i><span>{{ $etablissement->email_contact }}</span></div>
                            @endif
                            @if($etablissement->website)
                                <div class="lf-est-line"><i class="fas fa-globe"></i><span>{{ $etablissement->website }}</span></div>
                            @endif

                            <div class="lf-pill-list">
                                @forelse($activities as $activity)
                                    <span class="lf-pill"><i class="fas fa-tag"></i> {{ $activity->name }}</span>
                                @empty
                                    <span class="lf-pill"><i class="fas fa-tag"></i> Activité en configuration</span>
                                @endforelse
                            </div>
                        </div>
                    </article>

                    <article class="lf-card">
                        <div class="lf-head">
                            <h3 class="lf-title">Publicités & promotions</h3>
                            <p class="lf-sub">Carousel promotionnel pour vos visuels.</p>
                        </div>
                        <div class="lf-body">
                            <div class="swiper lf-ads-swiper" id="lfAdsSwiper">
                                <div class="swiper-wrapper">
                                    @forelse($ads as $ad)
                                        <a class="swiper-slide lf-ad-item" href="{{ $ad['button_url'] ?? $devisLink }}" target="_blank" rel="noopener noreferrer">
                                            <img src="{{ $ad['url'] }}" alt="{{ $ad['name'] }}">
                                            <div class="lf-ad-overlay">{{ $ad['name'] }}</div>
                                        </a>
                                    @empty
                                        @for($i = 1; $i <= 3; $i++)
                                            <div class="swiper-slide lf-ad-item">
                                                <img src="https://picsum.photos/seed/lf-ad-{{ $i }}/800/420" alt="Publicité {{ $i }}">
                                                <div class="lf-ad-overlay">Espace publicitaire premium</div>
                                            </div>
                                        @endfor
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="lf-card">
                        <div class="lf-head">
                            <h3 class="lf-title">Business Hours</h3>
                        </div>
                        <div class="lf-body">
                            <div class="lf-hours-list">
                                @foreach($workingHours as $row)
                                    <div class="lf-hour">
                                        <span>{{ $row['day'] }}</span>
                                        <span>{{ $row['hours'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </article>
                </aside>

                <div class="lf-right">
                    @include("cms::web.fallback.activities.$activityViewFolder.header")
    @include('cms::web.fallback.partials.landing-cms-header')

                    @if(is_slider_enabled($etablissement->id))
                    <article id="section-hero"  style="margin-top:0px !important;" class="lf-section lf-hero-embed">
                        @if(has_slider($etablissement->id))
                            {!! get_slider_html($etablissement->id) !!}
                        @else
                            @include("cms::web.fallback.activities.$activityViewFolder.hero", ['hideSearchBarV2' => true])
                        @endif
                    </article>
                    @endif

                    @include('cms::web.fallback.partials.landing-map-video-points')

                    @if(collect($cmsPageSections ?? [])->isNotEmpty())
                        @foreach(collect($cmsPageSections) as $cmsPage)
                            <article class="lf-section" id="cms-page-{{ \Illuminate\Support\Str::slug(data_get($cmsPage, 'slug') ?: data_get($cmsPage, 'title') ?: $loop->iteration) }}">
                                <div class="lf-cms-page-content">
                                    {!! data_get($cmsPage, 'content') !!}
                                </div>
                            </article>
                        @endforeach
                    @endif

                    @if(!empty($hasRestaurantActivity))
                        <article id="section-restaurant" class="lf-section">
                            <div class="lf-row-head">
                                <h3>Restaurant</h3>
                            </div>
                            <p style="margin:0 0 12px;color:#324a69;font-weight:600;line-height:1.6;">
                                Expériences culinaires et terroir en vedette.
                                Menus vedettes, ambiance et storytelling de marque.
                                Promotions ciblées et mise en avant de vos spécialités.
                                Parcours client orienté réservation et demande de devis.
                            </p>

                            <div class="lf-cta-3col">
                                <article class="lf-cta-card">
                                    <h4>Activez votre espace destination maintenant</h4>
                                    <p>Augmentez votre visibilité locale et internationale avec une présence géociblée Go Exploria.</p>
                                    <a href="{{ $devisLink }}" target="_blank" rel="noopener noreferrer" class="lf-cta-link"><i class="fas fa-paper-plane"></i> Demander un devis</a>
                                </article>
                                <article class="lf-cta-card">
                                    <h4>Activez votre espace entreprise</h4>
                                    <p>Présentez vos offres, services et médias dans une vitrine professionnelle orientée conversion.</p>
                                    <a href="{{ $devisLink }}" target="_blank" rel="noopener noreferrer" class="lf-cta-link"><i class="fas fa-paper-plane"></i> Demander un devis</a>
                                </article>
                                <article class="lf-cta-card">
                                    <h4>Activez votre espace personnel</h4>
                                    <p>Centralisez vos favoris, interactions et contenus dans un espace moderne à haute performance.</p>
                                    <a href="{{ $devisLink }}" target="_blank" rel="noopener noreferrer" class="lf-cta-link"><i class="fas fa-paper-plane"></i> Demander un devis</a>
                                </article>
                            </div>
                        </article>

                        @if(\Illuminate\Support\Facades\View::exists("cms::web.fallback.activities.$activityViewFolder.restaurant-ambiance-vedette-v2"))
                            <article class="lf-section" style="padding:10px;overflow:hidden;">
                                @include("cms::web.fallback.activities.$activityViewFolder.restaurant-ambiance-vedette-v2")
                            </article>
                        @endif
                    @endif

                    <article id="section-events" class="lf-section">
                        <div class="lf-row-head">
                            <h3>Événements vedette au Québec</h3>
                            <a href="{{ $devisLink }}" class="lf-en-savoir" target="_blank" rel="noopener noreferrer">En savoir <i class="fas fa-circle-plus"></i></a>
                        </div>
                        <div class="lf-chips" style="margin-bottom:12px;">
                            <span class="lf-chip is-active">Toutes les vidéos</span>
                            <span class="lf-chip">Nature</span>
                            <span class="lf-chip">Culture</span>
                            <span class="lf-chip">Gastronomie</span>
                            <span class="lf-chip">Aventures</span>
                        </div>

                        <div class="lf-events">
                            @foreach($eventCards as $card)
                                <article class="lf-event">
                                    <div class="lf-event-media">
                                        <img src="{{ $card['img'] }}" alt="{{ $card['title'] }}">
                                        <span class="lf-date">{{ $card['date'] }}</span>
                                    </div>
                                    <div class="lf-event-body">
                                        <h4>{{ $card['title'] }}</h4>
                                        <p>{{ $card['desc'] }}</p>
                                        <div class="lf-event-meta">
                                            <span><i class="fas fa-location-dot"></i> {{ $card['place'] }}</span>
                                            <span>{{ $card['cat'] }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </article>

                    <article id="section-destinations" class="lf-section">
                        <div class="lf-row-head">
                            <h3>Destinations vedettes</h3>
                            <a href="{{ $devisLink }}" class="lf-en-savoir" target="_blank" rel="noopener noreferrer">En savoir <i class="fas fa-circle-plus"></i></a>
                        </div>

                        <div class="lf-destination-shell">
                            <div class="lf-destination-top">
                                <div class="lf-destination-breadcrumb">
                                    <span class="lf-destination-badge"><i class="fas fa-globe-americas"></i> Destinations</span>
                                    <span>Toutes destinations</span>
                                    <span>/</span>
                                    <span>Amérique du Nord</span>
                                    <span>/</span>
                                    <span>Canada</span>
                                    <span>/</span>
                                    <span>Québec</span>
                                </div>
                                <div class="lf-chips">
                                    <span class="lf-chip is-active">Toutes destinations</span>
                                    <span class="lf-chip">Patrimoine & Culture</span>
                                    <span class="lf-chip">Villes & Cités</span>
                                    <span class="lf-chip">Nature & Paysage</span>
                                    <span class="lf-chip">Plein air & Ski</span>
                                </div>
                            </div>

                            <div class="lf-destination-grid">
                                @foreach($destinationCards as $card)
                                    <article class="lf-destination-card">
                                        <img src="{{ $card['img'] }}" alt="{{ $card['title'] }}">
                                        <div class="txt">
                                            <h4>{{ $card['title'] }}</h4>
                                            <p>{{ $card['desc'] }}</p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    </article>

                    @include('cms::web.fallback.partials.establishment-products', [
                        'etablissement' => $etablissement,
                        'devisLink' => $devisLink,
                        'cmsProductsTitle' => 'Nos Produits disponible',
                    ])

                    <article id="section-reviews" class="lf-section">
                        <div class="lf-row-head">
                            <h3>Avis clients</h3>
                        </div>

                        <div class="lf-reviews-a">
                            @foreach($reviewCardsA as $review)
                                <article class="lf-review-card-a">
                                    <h4 class="lf-review-title">{{ $review['title'] }}</h4>
                                    <div class="lf-review-stars">{{ $review['rating'] }}</div>
                                    <p class="lf-review-text">{{ $review['text'] }}</p>
                                    <div class="lf-review-foot">
                                        <span>{{ $review['user'] }} · {{ $review['date'] }}</span>
                                        <span><i class="fas fa-thumbs-up"></i> {{ $review['votes'] }}</span>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="lf-reviews-b">
                            @foreach($reviewCardsB as $review)
                                <article class="lf-review-row">
                                    <img src="{{ $review['img'] }}" alt="{{ $review['name'] }}">
                                    <div>
                                        <h5>{{ $review['name'] }}</h5>
                                        <p>{{ $review['text'] }}</p>
                                        <div class="metrics">
                                            <span>Rating ★★★★☆</span>
                                            <span>Hospitality ★★★★★</span>
                                            <span>Services ★★★★☆</span>
                                            <span>Pricing ★★★★☆</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </article>

                    @if(is_blog_enabled($etablissement->id) && collect($blogPosts ?? [])->isNotEmpty())
                        @php
                            $activityBlogSectionTitle = function_exists('get_blog_section_title')
                                ? get_blog_section_title($etablissement->id)
                                : 'Blog & actualités';
                            $activityBlogSectionTitle = trim((string) $activityBlogSectionTitle) !== '' ? $activityBlogSectionTitle : 'Blog & actualités';
                        @endphp
                        <article id="blog" class="lf-section">
                            <div class="lf-row-head">
                                <h3>{{ $activityBlogSectionTitle }}</h3>
                            </div>
                            <div class="lf-events">
                                @foreach(collect($blogPosts)->take(5) as $post)
                                    @php
                                        $blogUrl = data_get($post, 'url') ?: '#blog';
                                        $isExternalBlogUrl = !\Illuminate\Support\Str::startsWith($blogUrl, '#');
                                        $blogTargetAttrs = $isExternalBlogUrl ? ' target="_blank" rel="noopener noreferrer"' : '';
                                        $blogImage = data_get($post, 'image') ?: ($galleryImages[$loop->index] ?? $galleryImages[0] ?? null);
                                    @endphp
                                    <article class="lf-event">
                                        @if($blogImage)
                                            <div class="lf-event-media">
                                                <img src="{{ $blogImage }}" alt="{{ data_get($post, 'title', 'Article') }}">
                                                <div class="lf-date">{{ data_get($post, 'tag', 'Blog') }}</div>
                                            </div>
                                        @endif
                                        <div class="lf-event-body">
                                            <h4>{{ data_get($post, 'title') }}</h4>
                                            @if(data_get($post, 'excerpt'))
                                                <p>{{ data_get($post, 'excerpt') }}</p>
                                            @endif
                                            <div class="lf-event-meta">
                                                <span>{{ data_get($post, 'date') }}</span>
                                                <a href="{{ $blogUrl }}"{!! $blogTargetAttrs !!}>Lire</a>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </article>
                    @endif

                    <article id="section-gallery" class="lf-section">
                        <div class="lf-row-head">
                            <h3>Notre gallerie</h3>
                        </div>
                        <div class="lf-insta-grid">
                            @foreach($galleryImages as $img)
                                <div class="lf-insta-item">
                                    <img src="{{ $img }}" alt="Galerie {{ $loop->iteration }}">
                                </div>
                            @endforeach
                        </div>
                    </article>

                    <article id="section-contact-map" class="lf-section">
                        <div class="lf-row-head">
                            <h3>Contact rapide & carte</h3>
                        </div>

                        <div class="lf-contact-map">
                            <form id="lfLandingContactForm" class="lf-form-grid" method="POST" action="{{ route('cms.company.contact.send', ['etablissementId' => $etablissement->id]) }}" data-cms-contact-form data-cms-form-name="landing_activity">
                                @csrf
                                <div>
                                    <input class="lf-input" type="text" name="first_name" placeholder="Prénom" required>
                                </div>
                                <div>
                                    <input class="lf-input" type="text" name="last_name" placeholder="Nom" required>
                                </div>
                                <div>
                                    <input class="lf-input" type="email" name="email" placeholder="Email" required>
                                </div>
                                <div>
                                    <input class="lf-input" type="text" name="phone" placeholder="Téléphone">
                                </div>
                                <div class="lf-col-full">
                                    <select class="lf-select" name="service">
                                        <option value="Espace destination">Espace destination</option>
                                        <option value="Espace entreprise">Espace entreprise</option>
                                        <option value="Espace personnel">Espace personnel</option>
                                        <option value="Plan marketing">Plan marketing</option>
                                    </select>
                                </div>
                                <div class="lf-col-full">
                                    <textarea class="lf-textarea" name="message" placeholder="Décrivez votre besoin commercial..." required></textarea>
                                </div>
                                <div class="lf-col-full">
                                    <button class="lf-submit" type="submit">
                                        <i class="fas fa-paper-plane"></i> Continuer vers la demande de devis
                                    </button>
                                </div>
                            </form>

                        </div>
                    </article>
                </div>
            </div>

            <section id="section-plans" class="lf-plan-strip">
                <h3 style="margin:0;">Nos plans disponibles</h3>
                <p style="margin:6px 0 0;color:#607089;">Accès direct aux détails de chaque plan pour activer rapidement votre croissance.</p>

                <div class="lf-plan-grid">
                    @forelse($plans as $plan)
                        @php
                            $priceValue = $plan->price !== null ? (float) $plan->price : 0.0;
                            $priceText = $priceValue > 0 ? number_format($priceValue, 0, ',', ' ') . ' ' . ($plan->currency ?: 'CAD') : 'Sur demande';
                        @endphp
                        <a href="{{ url('/plan-detail/' . ($plan->slug ?: $plan->id)) }}" class="lf-plan-card" target="_blank" rel="noopener noreferrer">
                            <div><i class="{{ str_contains((string) $plan->icon, 'fa') ? $plan->icon : 'fas fa-layer-group' }}"></i></div>
                            <h5>{{ $plan->name }}</h5>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags((string) $plan->description), 90) }}</p>
                            <div class="lf-plan-price">{{ $priceText }}</div>
                        </a>
                    @empty
                        @for($i = 1; $i <= 4; $i++)
                            <a href="{{ $devisLink }}" class="lf-plan-card" target="_blank" rel="noopener noreferrer">
                                <div><i class="fas fa-layer-group"></i></div>
                                <h5>Plan Go Exploria {{ $i }}</h5>
                                <p>Activez votre espace et demandez une proposition personnalisée.</p>
                                <div class="lf-plan-price">Sur demande</div>
                            </a>
                        @endfor
                    @endforelse
                </div>
            </section>
        </section>
    </main>

    <button type="button" class="lf-backtop" id="lfBackTop" aria-label="Retour en haut">
        <i class="fas fa-arrow-up"></i>
    </button>
    @include('cms::web.fallback.partials.landing-media-slideshow')
    @include('cms::web.fallback.partials.landing-contact-ajax')

    @include('cms::web.fallback.partials.landing-cms-footer')

    @include("cms::web.fallback.activities.$activityViewFolder.footer")

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
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
        document.addEventListener('DOMContentLoaded', function () {
            if (window.Swiper) {
                new Swiper('#lfAdsSwiper', {
                    loop: true,
                    slidesPerView: 1,
                    spaceBetween: 0,
                    autoplay: {
                        delay: 2700,
                        disableOnInteraction: false
                    },
                    speed: 700
                });
            }

            const backTop = document.getElementById('lfBackTop');
            const toggleBackTop = function () {
                if (!backTop) return;
                if (window.scrollY > 260) {
                    backTop.classList.add('is-visible');
                } else {
                    backTop.classList.remove('is-visible');
                }
            };

            if (backTop) {
                backTop.addEventListener('click', function () {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
                toggleBackTop();
                window.addEventListener('scroll', toggleBackTop, { passive: true });
            }

            const form = document.getElementById('lfLandingContactForm');
            if (form) {
                form.addEventListener('submit', function (event) {
                    if (form.hasAttribute('data-cms-contact-form')) {
                        return;
                    }

                    event.preventDefault();
                    const formData = new FormData(form);
                    const params = new URLSearchParams();

                    params.set('first_name', String(formData.get('first_name') || ''));
                    params.set('last_name', String(formData.get('last_name') || ''));
                    params.set('email', String(formData.get('email') || ''));
                    params.set('phone', String(formData.get('phone') || ''));
                    params.set('service', String(formData.get('service') || ''));
                    params.set('message', String(formData.get('message') || ''));
                    params.set('etablissement_id', '{{ $etablissement->id }}');

                    window.location.href = '{{ $devisLink }}' + '?' + params.toString();
                });
            }

            if (window.L && document.getElementById('lfMap')) {
                const fallbackLat = 46.8139;
                const fallbackLng = -71.2082;
                const rawLat = Number('{{ $mapLatitude ?? 0 }}');
                const rawLng = Number('{{ $mapLongitude ?? 0 }}');
                const lat = Number.isFinite(rawLat) && rawLat !== 0 ? rawLat : fallbackLat;
                const lng = Number.isFinite(rawLng) && rawLng !== 0 ? rawLng : fallbackLng;

                const map = L.map('lfMap', {
                    zoomControl: true,
                    scrollWheelZoom: false
                }).setView([lat, lng], 12);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                const markerIcon = L.divIcon({
                    className: 'lf-marker',
                    html: '<div class="lf-marker-wrap"><i class="fas fa-store"></i></div>',
                    iconSize: [34, 34],
                    iconAnchor: [17, 32]
                });

                L.marker([lat, lng], { icon: markerIcon })
                    .addTo(map)
                    .bindPopup('<strong>{{ addslashes($etablissement->name) }}</strong><br>{{ addslashes((string) ($etablissement->adresse ?? 'Adresse non précisée')) }}');

                setTimeout(function () {
                    map.invalidateSize();
                }, 260);
            }
        });
    </script>
    @include('cms::web.fallback.partials.landing-cart-drawer')
    @include('cms::web.fallback.partials.landing-back-to-top')
</body>
</html>
