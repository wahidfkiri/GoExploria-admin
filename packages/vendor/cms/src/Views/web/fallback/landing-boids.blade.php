<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Landing Boids de {{ get_site_name($etablissement->id) }}">
    <title>{{ get_site_name($etablissement->id) }} | Landing Boids</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
            --boids-bg: #f4f0e8;
            --boids-card: #fff;
            --boids-ink: #1e1610;
            --boids-muted: #6b6254;
            --boids-forest: #000000;
            --boids-forest-mid: #1a1a1a;
            --boids-gold: #e65216;
            --boids-gold-light: #ff8a5d;
            --boids-radius: 16px;
            --boids-border: #ded4c3;
        }

        body { background: var(--boids-bg); color: var(--boids-ink); }

        .boids-fb-header {
            background: rgba(0, 0, 0, 0.97);
            border: 1px solid rgba(230, 82, 22, 0.35);
            border-radius: 14px;
            padding: 12px 16px;
            margin-top:0px !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
        }

        .boids-fb-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
        }

        .boids-fb-brand img {
            height: 100px;
            width: auto;
            object-fit: contain;
            border-radius: 8px;
            background: #fff;
            padding: 4px;
        }

        .boids-fb-links {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .boids-fb-links a {
            color: rgba(255,255,255,.88);
            text-decoration: none;
            font-size: .82rem;
            font-weight: 600;
            letter-spacing: .03em;
            text-transform: uppercase;
            padding: 6px 8px;
            border-radius: 8px;
        }

        .boids-fb-links a:hover {
            color: var(--boids-gold-light);
            background: rgba(255,255,255,.06);
        }

        .boids-fb-cta {
            background: var(--boids-gold);
            color: #3d2b1a;
            padding: 9px 14px;
            border-radius: 999px;
            text-decoration: none;
            font-size: .84rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .boids-wrap {
            max-width: 1580px;
            margin: 0 auto;
            padding: 24px 16px 34px;
            margin-top: 100px;
        }

        .boids-grid {
            display: grid;
            grid-template-columns: minmax(280px, 3fr) minmax(0, 9fr);
            gap: 18px;
            align-items: start;
        }

        .boids-left {
            display: grid;
            gap: 14px;
            position: sticky;
            top: 106px;
        }

        .boids-card {
            background: var(--boids-card);
            border: 1px solid var(--boids-border);
            border-radius: var(--boids-radius);
            box-shadow: 0 10px 24px rgba(14, 28, 53, 0.08);
            overflow: hidden;
        }

        .boids-head {
            padding: 16px 16px 8px;
            border-bottom: 1px solid #ebe3d6;
        }

        .boids-head--primary {
            text-align: center;
        }

        .boids-site-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 2px auto 12px;
        }

        .boids-site-logo img {
            width: 132px;
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }

        .boids-title {
            margin: 0;
            font-size: 1.08rem;
            font-weight: 800;
            color: #1f1f1f;
        }

        .boids-sub {
            margin-top: 6px;
            color: var(--boids-muted);
            line-height: 1.5;
            font-size: 0.9rem;
        }

        .boids-body { padding: 14px 16px 16px; }

        .boids-line {
            display: flex;
            gap: 9px;
            font-size: 0.9rem;
            color: #3b4a3f;
            margin-bottom: 8px;
            align-items: flex-start;
        }

        .boids-pill-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }

        .boids-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            background: #f4f4f4;
            border: 1px solid #d8d8d8;
            color: #1f1f1f;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .boids-ads {
            display: grid;
            gap: 10px;
        }

        .boids-ad {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #d8dfd3;
            text-decoration: none;
            display: block;
        }

        .boids-ad img {
            width: 100%;
            height: 136px;
            object-fit: cover;
            display: block;
        }

        .boids-ad span {
            position: absolute;
            left: 8px;
            right: 8px;
            bottom: 8px;
            background: rgba(0, 0, 0, 0.55);
            color: #fff;
            border-radius: 8px;
            padding: 5px 8px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .boids-hours { display: grid; gap: 6px; }

        .boids-hour {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            border-bottom: 1px dashed #e6dccd;
            padding-bottom: 5px;
            font-size: 0.86rem;
            color: #4a4a4a;
        }

        .boids-hour:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .boids-right { display: grid; gap: 14px; }

        .boids-section {
            background: #fff;
            border: 1px solid var(--boids-border);
            border-radius: var(--boids-radius);
            box-shadow: 0 8px 20px rgba(29, 32, 25, 0.05);
            padding: 22px;
        }

        .boids-hero-embed {
            overflow: hidden;
            padding: 0;
        }

        .boids-row-head {
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .boids-row-head h3 {
            margin: 0;
            font-family: "Playfair Display", serif;
            font-size: 1.7rem;
            color: #111111;
            line-height: 1.15;
        }

        .boids-row-head p {
            margin: 0;
            color: var(--boids-muted);
            max-width: 760px;
            line-height: 1.55;
        }

        .boids-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 12px;
            border-radius: 999px;
            border: 1px solid #d6d6d6;
            background: #edf6ed;
            color: #1f1f1f;
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .boids-about {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 16px;
            align-items: center;
        }

        .boids-about-stack {
            position: relative;
            min-height: 340px;
        }

        .boids-about-main {
            width: 78%;
            height: 270px;
            object-fit: cover;
            border-radius: 16px;
            border: 1px solid #d9ddce;
            box-shadow: 0 14px 36px rgba(20, 26, 20, 0.14);
        }

        .boids-about-second {
            width: 52%;
            height: 170px;
            object-fit: cover;
            position: absolute;
            right: 0;
            bottom: 0;
            border-radius: 14px;
            border: 4px solid #fff;
            box-shadow: 0 10px 24px rgba(20, 26, 20, 0.14);
        }

        .boids-badge {
            position: absolute;
            left: 54%;
            top: 58%;
            transform: translate(-50%, -50%);
            background: var(--boids-forest);
            color: #fff;
            border-radius: 12px;
            padding: 12px 14px;
            text-align: center;
            min-width: 130px;
        }

        .boids-badge strong {
            display: block;
            color: var(--boids-gold-light);
            font-size: 1.5rem;
            line-height: 1;
            font-family: "Playfair Display", serif;
        }

        .boids-feature-list {
            list-style: none;
            display: grid;
            gap: 9px;
            margin-top: 12px;
        }

        .boids-feature-list li {
            background: #f7f2ea;
            border-left: 3px solid var(--boids-forest-mid);
            border-radius: 10px;
            padding: 11px 12px;
            font-size: 0.92rem;
            color: #3f4338;
        }

        .boids-services {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .boids-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
        }

        .boids-stat {
            border: 1px solid #ddd5c8;
            border-radius: 12px;
            padding: 14px 12px;
            background: #fffdf9;
            text-align: center;
        }

        .boids-stat strong {
            display: block;
            font-family: "Playfair Display", serif;
            font-size: 1.9rem;
            line-height: 1;
            color: #111111;
        }

        .boids-stat span {
            display: block;
            margin-top: 6px;
            font-size: 0.82rem;
            color: #5d564a;
        }

        .boids-service {
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #ddd5c8;
            background: #fffdf9;
        }

        .boids-service img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            display: block;
        }

        .boids-service-body { padding: 12px; }

        .boids-service-body h4 {
            margin: 0 0 6px;
            font-family: "Playfair Display", serif;
            color: #1d1d1d;
            font-size: 1.12rem;
        }

        .boids-service-body p {
            margin: 0;
            color: #605b4f;
            line-height: 1.5;
            font-size: 0.89rem;
        }

        .boids-products {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .boids-product {
            border: 1px solid #ddd5c8;
            border-radius: 14px;
            overflow: hidden;
            background: #fffdfa;
        }

        .boids-product img {
            width: 100%;
            height: 210px;
            object-fit: cover;
            display: block;
        }

        .boids-product-body {
            padding: 12px;
        }

        .boids-product-tag {
            display: inline-flex;
            align-items: center;
            border: 1px solid #ffd2c0;
            color: #bb3c0c;
            background: #fff2ec;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 800;
            padding: 4px 8px;
            margin-bottom: 8px;
        }

        .boids-product-body h4 {
            margin: 0 0 6px;
            font-family: "Playfair Display", serif;
            color: #161616;
            font-size: 1.1rem;
        }

        .boids-product-body p {
            margin: 0;
            color: #625b4e;
            font-size: 0.88rem;
            line-height: 1.55;
        }

        .boids-gallery {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            grid-auto-rows: 170px;
            gap: 8px;
        }

        .boids-filter-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 12px;
        }

        .boids-filter-pill {
            border: 1px solid #dadada;
            background: #f6f6f6;
            color: #1f1f1f;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .boids-media {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #d7ddcf;
            position: relative;
            cursor: zoom-in;
        }

        .boids-media--wide { grid-column: span 2; }
        .boids-media--tall { grid-row: span 2; }

        .boids-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .25s ease;
            display: block;
        }

        .boids-media:hover img { transform: scale(1.04); }

        .boids-media-label {
            position: absolute;
            left: 8px;
            right: 8px;
            bottom: 8px;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 5px 8px;
            border-radius: 7px;
        }

        .boids-reviews {
            overflow: hidden;
            position: relative;
        }

        .boids-reviews-track {
            display: flex;
            gap: 12px;
            transition: transform .35s ease;
        }

        .boids-review {
            border: 1px solid #ddd5c7;
            border-radius: 12px;
            padding: 12px;
            background: #fff;
            min-width: min(360px, 100%);
            flex: 0 0 min(360px, 100%);
        }

        .boids-stars {
            color: #f3b127;
            letter-spacing: 2px;
            font-size: 0.93rem;
            margin-bottom: 7px;
        }

        .boids-review p {
            margin: 0 0 8px;
            color: #5f5b50;
            line-height: 1.5;
            font-size: .89rem;
        }

        .boids-review strong {
            color: #232323;
            font-size: .85rem;
        }

        .boids-reviews-controls {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
        }

        .boids-reviews-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid #cbcbcb;
            background: #fff;
            color: #111;
            cursor: pointer;
            font-size: 1rem;
        }

        .boids-videos {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .boids-video-featured {
            grid-column: span 3;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #ddd5c8;
            min-height: 330px;
            background: #000;
        }

        .boids-video-featured iframe {
            width: 100%;
            height: 100%;
            min-height: 330px;
            border: 0;
        }

        .boids-video-card {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #ddd5c8;
            position: relative;
            cursor: pointer;
            min-height: 180px;
        }

        .boids-video-card img {
            width: 100%;
            height: 100%;
            min-height: 180px;
            object-fit: cover;
            display: block;
            filter: brightness(0.72);
        }

        .boids-video-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 8px;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        .boids-video-play {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(230, 82, 22, 0.92);
            color: #fff;
            font-size: 0.95rem;
            border: 1px solid rgba(255,255,255,.45);
        }

        .boids-video-title {
            font-size: 0.82rem;
            font-weight: 700;
            line-height: 1.3;
        }

        .boids-social-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .boids-social-card {
            border: 1px solid #ddd5c8;
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
        }

        .boids-social-head {
            padding: 10px 12px;
            border-bottom: 1px solid #efe6d9;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            color: #1d1d1d;
        }

        .boids-social-body {
            padding: 10px 12px 12px;
        }

        .boids-social-post {
            border: 1px solid #efe6d9;
            border-radius: 10px;
            background: #fbf8f2;
            padding: 9px;
            font-size: 0.82rem;
            color: #4a4338;
            line-height: 1.5;
            margin-bottom: 8px;
        }

        .boids-social-post:last-child {
            margin-bottom: 0;
        }

        .boids-social-pics {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 6px;
        }

        .boids-social-pics img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ece3d7;
        }

        .boids-social-videos {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
        }

        .boids-social-videos a {
            position: relative;
            display: block;
        }

        .boids-social-videos img {
            width: 100%;
            height: 130px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ece3d7;
            filter: brightness(.78);
        }

        .boids-social-videos span {
            position: absolute;
            inset: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1rem;
            text-shadow: 0 1px 4px rgba(0,0,0,.45);
        }

        .boids-social-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            margin-top: 10px;
            padding: 8px 10px;
            border-radius: 10px;
            text-decoration: none;
            color: #fff;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .boids-social-btn--fb { background: #1877f2; }
        .boids-social-btn--ig { background: #25292e; }
        .boids-social-btn--yt { background: #ff0000; }

        .boids-hours-contact {
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            gap: 12px;
        }

        .boids-hours-card, .boids-contact-card {
            border: 1px solid #ddd5c7;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }

        .boids-hours-title {
            background: var(--boids-gold);
            color: #3e2d1f;
            padding: 10px 12px;
            font-weight: 800;
            font-size: .92rem;
        }

        .boids-hours-body, .boids-contact-body { padding: 12px; }

        .boids-contact-item {
            display: flex;
            gap: 10px;
            margin-bottom: 8px;
            color: #4e5148;
            font-size: .9rem;
        }

        .boids-contact-item:last-child { margin-bottom: 0; }

        .boids-contact-item i {
            color: #1f1f1f;
            margin-top: 2px;
        }

        .boids-cta-band {
            border-radius: 15px;
            border: 1px solid #1f1f1f;
            background: linear-gradient(130deg, #000000 0%, #111111 50%, #222222 100%);
            color: #fff;
            padding: 24px;
            text-align: center;
        }

        .boids-cta-band h3 {
            margin: 0 0 10px;
            font-family: "Playfair Display", serif;
            font-size: 2rem;
            color: #fff;
        }

        .boids-cta-band p {
            margin: 0 0 16px;
            color: rgba(255,255,255,.85);
        }

        .boids-cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            border-radius: 999px;
            background: var(--boids-gold);
            color: #3b2d1c;
            font-weight: 800;
            padding: 11px 20px;
            border: 1px solid #f2d48d;
        }

        .boids-contact-grid {
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            gap: 12px;
        }

        .boids-map-wrap {
            border: 1px solid #dad4c7;
            border-radius: 12px;
            overflow: hidden;
            height: 100%;
            min-height: 300px;
            position: relative;
            background: #f8fbff;
        }

        .boids-map { width: 100%; height: 100%; min-height: 300px; }

        .lf-marker-wrap {
            width: 34px;
            height: 34px;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            background: #1a1a1a;
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

        .boids-form {
            border: 1px solid #ddd4c5;
            border-radius: 12px;
            background: #fff;
            padding: 14px;
        }

        .boids-form h4 {
            margin: 0 0 6px;
            color: #1f1f1f;
            font-family: "Playfair Display", serif;
            font-size: 1.5rem;
        }

        .boids-form p {
            margin: 0 0 12px;
            color: #665f52;
            font-size: .88rem;
        }

        .boids-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .boids-input, .boids-select, .boids-textarea {
            width: 100%;
            border: 1px solid #d8cfbe;
            border-radius: 10px;
            background: #fbf8f2;
            padding: 10px 11px;
            font: inherit;
            color: #1f1f1f;
        }

        .boids-textarea { min-height: 120px; resize: vertical; }
        .boids-col-full { grid-column: 1 / -1; }

        .boids-submit {
            border: 0;
            border-radius: 10px;
            background: linear-gradient(135deg, #000000, #1a1a1a);
            color: #fff;
            font-weight: 800;
            font-size: .9rem;
            padding: 11px 14px;
            cursor: pointer;
        }

        .boids-backtop {
            position: fixed;
            right: 18px;
            bottom: 18px;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            border: 0;
            background: linear-gradient(135deg, #000000, #1a1a1a);
            color: #fff;
            box-shadow: 0 12px 24px rgba(16, 38, 84, 0.28);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 9999;
            transition: transform .2s ease, opacity .2s ease;
            opacity: 0;
            pointer-events: none;
        }

        .boids-backtop.is-visible {
            opacity: 1;
            pointer-events: auto;
        }

        .boids-lightbox {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: rgba(0,0,0,.88);
            align-items: center;
            justify-content: center;
            padding: 22px;
        }

        .boids-lightbox.open { display: flex; }

        .boids-lightbox img {
            max-width: 92vw;
            max-height: 88vh;
            border-radius: 12px;
            border: 2px solid #fff;
        }

        .boids-lightbox-close {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 0;
            background: rgba(255,255,255,.18);
            color: #fff;
            cursor: pointer;
            font-size: 22px;
        }

        @media (max-width: 1180px) {
            .boids-grid { grid-template-columns: 1fr; }
            .boids-left { position: static; }
            .boids-about,
            .boids-hours-contact,
            .boids-contact-grid { grid-template-columns: 1fr; }
            .boids-services { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .boids-products { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .boids-videos { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .boids-video-featured { grid-column: span 2; }
            .boids-social-grid { grid-template-columns: 1fr 1fr; }
            .boids-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 860px) {
            .boids-services { grid-template-columns: 1fr; }
            .boids-products { grid-template-columns: 1fr; }
            .boids-videos { grid-template-columns: 1fr; }
            .boids-video-featured { grid-column: span 1; min-height: 260px; }
            .boids-video-featured iframe { min-height: 260px; }
            .boids-social-grid { grid-template-columns: 1fr; }
            .boids-stats { grid-template-columns: 1fr; }
            .boids-gallery { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .boids-media--wide, .boids-media--tall { grid-column: span 1; grid-row: span 1; }
            .boids-form-grid { grid-template-columns: 1fr; }
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
        } elseif (str_contains($activityNamesForViews, 'hotel') || str_contains($activityNamesForViews, 'hebergement') || str_contains($activityNamesForViews, 'hebergement')) {
            $activityViewFolder = 'hotel';
        } elseif (str_contains($activityNamesForViews, 'voyage') || str_contains($activityNamesForViews, 'tourisme') || str_contains($activityNamesForViews, 'forfait')) {
            $activityViewFolder = 'voyage';
        } elseif (str_contains($activityNamesForViews, 'immo') || str_contains($activityNamesForViews, 'chalet') || str_contains($activityNamesForViews, 'maison')) {
            $activityViewFolder = 'immobilier';
        }

        $devisLink = $devisUrl ?? route('devis');
        $siteName = get_site_name($etablissement->id);
        $siteDescription = $etablissement->getSetting('description', null, 'general')
            ?: get_site_description($etablissement->id)
            ?: 'Description du site en cours de configuration.';
        $phone = $etablissement->phone ?? $etablissement->telephone ?? null;
        $email = $etablissement->email_contact ?? $etablissement->email ?? null;
        $address = $etablissement->adresse ?? 'Adresse en cours de configuration';

        $gallery = collect($galleryMedia ?? [])->filter(fn ($row) => !empty($row['thumbnail']))->values();
        $galleryFallback = collect([
            ['thumbnail' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/GALLERY_01.jpg', 'name' => 'Projet 1'],
            ['thumbnail' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/GALLERY_02.jpg', 'name' => 'Projet 2'],
            ['thumbnail' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/GALLERY_03.jpg', 'name' => 'Projet 3'],
            ['thumbnail' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/GALLERY_04.jpg', 'name' => 'Projet 4'],
            ['thumbnail' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/GALLERY_05.jpg', 'name' => 'Projet 5'],
            ['thumbnail' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/GALLERY_06.jpg', 'name' => 'Projet 6'],
            ['thumbnail' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/GALLERY_07.jpg', 'name' => 'Projet 7'],
            ['thumbnail' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/GALLERY_08.jpg', 'name' => 'Projet 8'],
        ]);
        if ($gallery->isEmpty()) {
            $gallery = $galleryFallback;
        }

        $mainImage = $gallery->first()['thumbnail'] ?? null;
        $secondImage = $gallery->skip(1)->first()['thumbnail'] ?? $mainImage;

        if ($gallery->count() < 16 && $gallery->isNotEmpty()) {
            $seed = $gallery->values();
            while ($gallery->count() < 16) {
                foreach ($seed as $item) {
                    $gallery->push($item);
                    if ($gallery->count() >= 16) {
                        break;
                    }
                }
            }
            $gallery = $gallery->values();
        }

        $serviceTitles = [
            'Sciage Haute Precision',
            'Poutres Piece sur Piece',
            'Revetement en Bois',
            'Affutage de Lames',
            'Planage & Emboutement',
            'Transport & Recuperation',
        ];

        $productCards = [
            ['tag' => 'Populaire', 'title' => 'Poutres Structurales', 'desc' => 'Poutres taillees sur mesure pour vos constructions residentielles et commerciales.'],
            ['tag' => 'Bestseller', 'title' => 'Bardage a Clin', 'desc' => 'Revetement exterieur en bois massif, durable et esthetique, pret a installer.'],
            ['tag' => 'Nouveau', 'title' => 'Planches Rabotees', 'desc' => 'Planches sciees et planees avec precision pour des finitions interieures et exterieures.'],
        ];

        $reviewCards = [
            ['text' => 'Je vous le recommande fortement. Rapidité, efficacité et sécurité. Service très professionnel.', 'author' => 'François Robitaille · Google'],
            ['text' => 'Travail de qualité, équipe ponctuelle et excellente communication. Résultat au-delà des attentes.', 'author' => 'Stéphane St-Aubin · Facebook'],
            ['text' => 'Très bon rapport qualité-prix, service fiable et précis. Idéal pour les projets résidentiels.', 'author' => 'Jérémie Auger Laforce · Google'],
            ['text' => 'Service impeccable du début à la fin. Équipe organisée et très respectueuse des délais.', 'author' => 'Marie-Lise Tremblay · Facebook'],
            ['text' => 'Découpe parfaite de mes billots. Je recommande à 100 % pour la qualité du rendu final.', 'author' => 'Pierre Gagnon · Google'],
        ];

        $videoChannelUrl = 'https://www.youtube.com/@Moulin_%C3%A0_Scie_Lanaudi%C3%A8re';
        $videoThumbs = [
            'https://img.youtube.com/vi/0edALYi7_Qs/hqdefault.jpg',
            'https://img.youtube.com/vi/7Wq5hRTvN5g/hqdefault.jpg',
            'https://img.youtube.com/vi/6M4f5HXQYvQ/hqdefault.jpg',
        ];
    @endphp

    @include("cms::web.fallback.activities.$activityViewFolder.vertical-menu")
    @include('home-v2.components.Header')

    <main>
        <section class="boids-wrap">
            <div class="boids-grid">
                <aside class="boids-left">
                    <article class="boids-card">
                        <div class="boids-head boids-head--primary">
                            @if(!empty($brandLogoUrl))
                                <div class="boids-site-logo">
                                    <img src="{{ $brandLogoUrl }}" alt="{{ $siteName }}">
                                </div>
                            @endif
                            <h2 class="boids-title">{{ $siteName }}</h2>
                            <p class="boids-sub">{{ $siteDescription }}</p>
                        </div>
                        <div class="boids-body">
                            @if($address)
                                <div class="boids-line"><i class="fas fa-location-dot"></i><span>{{ $address }}</span></div>
                            @endif
                            @if($phone)
                                <div class="boids-line"><i class="fas fa-phone"></i><span>{{ $phone }}</span></div>
                            @endif
                            @if($email)
                                <div class="boids-line"><i class="fas fa-envelope"></i><span>{{ $email }}</span></div>
                            @endif

                            <div class="boids-pill-list">
                                @forelse($activities as $activity)
                                    <span class="boids-pill"><i class="fas fa-tag"></i> {{ $activity->name }}</span>
                                @empty
                                    <span class="boids-pill"><i class="fas fa-tag"></i> Activite en configuration</span>
                                @endforelse
                            </div>
                        </div>
                    </article>

                    <article class="boids-card">
                        <div class="boids-head">
                            <h3 class="boids-title">Promotions</h3>
                            <p class="boids-sub">Visuels publicitaires associes a l'etablissement.</p>
                        </div>
                        <div class="boids-body">
                            <div class="boids-ads">
                                @forelse($ads as $ad)
                                    <a class="boids-ad" href="{{ $ad['button_url'] ?? $devisLink }}" target="_blank" rel="noopener noreferrer">
                                        <img src="{{ $ad['url'] }}" alt="{{ $ad['name'] }}">
                                        <span>{{ $ad['name'] }}</span>
                                    </a>
                                @empty
                                    @foreach($gallery->take(3) as $media)
                                        <a class="boids-ad" href="{{ $devisLink }}" target="_blank" rel="noopener noreferrer">
                                            <img src="{{ $media['thumbnail'] }}" alt="{{ $media['name'] ?? 'Publicite' }}">
                                            <span>Espace promotionnel</span>
                                        </a>
                                    @endforeach
                                @endforelse
                            </div>
                        </div>
                    </article>

                    <article class="boids-card">
                        <div class="boids-head">
                            <h3 class="boids-title">Business Hours</h3>
                        </div>
                        <div class="boids-body">
                            <div class="boids-hours">
                                @foreach($workingHours as $row)
                                    <div class="boids-hour">
                                        <span>{{ $row['day'] }}</span>
                                        <span>{{ $row['hours'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </article>
                </aside>

                <div class="boids-right">
                    <article class="boids-fb-header">
                        <a href="#section-hero" class="boids-fb-brand">
                            @if(!empty($brandLogoUrl))
                                <img src="{{ $brandLogoUrl }}" alt="{{ $siteName }}">
                            @endif
                            <span>{{ $siteName }}</span>
                        </a>
                        <ul class="boids-fb-links">
                            <li><a href="#section-stats">Stats</a></li>
                            <li><a href="#section-services">Services</a></li>
                            <li><a href="#section-gallery">Realisations</a></li>
                            <li><a href="#section-products">Produits</a></li>
                            <li><a href="#section-reviews">Avis</a></li>
                            <li><a href="#section-videos">Videos</a></li>
                            <li><a href="#section-social">Reseaux</a></li>
                            <li><a href="#section-hours">Horaire</a></li>
                            <li><a href="#section-contact">Contact</a></li>
                        </ul>
                        <a href="{{ $devisLink }}" class="boids-fb-cta" target="_blank" rel="noopener noreferrer">Soumission Gratuite</a>
                    </article>

                    <article class="boids-section boids-hero-embed" id="section-hero">
                        @include("cms::web.fallback.activities.$activityViewFolder.hero", ['hideSearchBarV2' => true])
                    </article>

                    <article class="boids-section" id="section-about">
    <span class="boids-kicker"><i class="fas fa-tree"></i> À propos</span>
    <div class="boids-row-head">
        <h3>Votre Bois, Notre Expertise</h3>
        <p>Un positionnement premium pour votre activité de sciage, transformation, revêtement et services techniques bois.</p>
    </div>
    <div class="boids-about">
        <div class="boids-about-stack">
            <img class="boids-about-main" src="{{ $mainImage }}" alt="Projet principal">
            <img class="boids-about-second" src="{{ $secondImage }}" alt="Projet secondaire">
            <div class="boids-badge">
                <strong>100%</strong>
                Mobile & Sur place
            </div>
        </div>
        <div>
            <ul class="boids-feature-list">
                <li>Équipement hydraulique informatisé pour des coupes précises.</li>
                <li>Service mobile régional avec intervention rapide.</li>
                <li>Valorisation du bois local et production sur mesure.</li>
            </ul>
        </div>
    </div>
</article>

<article class="boids-section" id="section-stats">
    <span class="boids-kicker"><i class="fas fa-chart-column"></i> Chiffres clés</span>
    <div class="boids-stats">
        <div class="boids-stat"><strong>38″</strong><span>Diamètre max. de billots</span></div>
        <div class="boids-stat"><strong>20′</strong><span>Longueur max. de coupe</span></div>
        <div class="boids-stat"><strong>7/7</strong><span>Jours de service</span></div>
        <div class="boids-stat"><strong>3</strong><span>Régions desservies</span></div>
    </div>
</article>

<article class="boids-section" id="section-services">
    <span class="boids-kicker"><i class="fas fa-screwdriver-wrench"></i> Services</span>
    <div class="boids-row-head">
        <h3>Sciage & Transformation du Bois</h3>
    </div>
    <div class="boids-services">
        @foreach($gallery->take(6)->values() as $index => $media)
            <div class="boids-service">
                <img src="{{ $media['thumbnail'] }}" alt="{{ $media['name'] ?? 'Service' }}">
                <div class="boids-service-body">
                    <h4>{{ $serviceTitles[$index] ?? 'Service spécialisé' }}</h4>
                    <p>Présentation optimisée de vos prestations avec visuels forts et message commercial clair.</p>
                </div>
            </div>
        @endforeach
    </div>
</article>

<article class="boids-section" id="section-gallery">
    <span class="boids-kicker"><i class="fas fa-images"></i> Réalisations</span>
    <div class="boids-row-head">
        <h3>Galerie de Projets</h3>
        <p>La galerie se remplit automatiquement depuis la médiathèque CMS quand des médias existent.</p>
    </div>
    <div class="boids-filter-pills">
        <span class="boids-filter-pill">Tous</span>
        <span class="boids-filter-pill">Sciage</span>
        <span class="boids-filter-pill">Poutres</span>
        <span class="boids-filter-pill">Bardage</span>
        <span class="boids-filter-pill">Planage</span>
    </div>
    <div class="boids-gallery" id="boidsGallery">
        @foreach($gallery->take(16)->values() as $index => $media)
            @php
                $galleryClass = 'boids-media';
                if ($index === 0) {
                    $galleryClass .= ' boids-media--wide boids-media--tall';
                } elseif (in_array($index, [5, 11], true)) {
                    $galleryClass .= ' boids-media--wide';
                }
            @endphp
            <div class="{{ $galleryClass }}" data-src="{{ $media['thumbnail'] }}">
                <img src="{{ $media['thumbnail'] }}" alt="{{ $media['name'] ?? ('Projet ' . ($index + 1)) }}">
                <div class="boids-media-label">{{ $media['name'] ?? ('Projet ' . ($index + 1)) }}</div>
            </div>
        @endforeach
    </div>
</article>

<article class="boids-section" id="section-products">
    <span class="boids-kicker"><i class="fas fa-box-open"></i> Produits Vedette</span>
    <div class="boids-row-head">
        <h3>Nos Matériaux Phares</h3>
        <p>Des matériaux de qualité supérieure issus de notre expertise en transformation du bois.</p>
    </div>
    <div class="boids-products">
        @foreach($productCards as $index => $product)
            @php $media = $gallery->get(($index + 1) % $gallery->count()); @endphp
            <div class="boids-product">
                <img src="{{ $media['thumbnail'] }}" alt="{{ $product['title'] }}">
                <div class="boids-product-body">
                    <span class="boids-product-tag">{{ $product['tag'] }}</span>
                    <h4>{{ $product['title'] }}</h4>
                    <p>{{ $product['desc'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</article>

<article class="boids-section" id="section-reviews">
    <span class="boids-kicker"><i class="fas fa-star"></i> Avis Clients</span>
    <div class="boids-row-head">
        <h3>Votre Confiance, Notre Fierté</h3>
        <p>Basé sur les retours clients Google et Facebook.</p>
    </div>
    <div class="boids-reviews">
        <div class="boids-reviews-track" id="boidsReviewsTrack">
            @foreach($reviewCards as $review)
                <div class="boids-review">
                    <div class="boids-stars">★★★★★</div>
                    <p>{{ $review['text'] }}</p>
                    <strong>{{ $review['author'] }}</strong>
                </div>
            @endforeach
        </div>
    </div>
    <div class="boids-reviews-controls">
        <button type="button" class="boids-reviews-btn" id="boidsReviewPrev" aria-label="Précédent">‹</button>
        <button type="button" class="boids-reviews-btn" id="boidsReviewNext" aria-label="Suivant">›</button>
    </div>
</article>

<article class="boids-section" id="section-videos">
    <span class="boids-kicker"><i class="fas fa-video"></i> Vidéos</span>
    <div class="boids-row-head">
        <h3>Voyez Notre Expertise en Vidéo</h3>
        <p>Présentez vos réalisations en action avec un bloc vidéo premium.</p>
    </div>
    <div class="boids-videos">
        <div class="boids-video-featured">
            <iframe
                src="https://www.youtube.com/embed/0edALYi7_Qs?autoplay=0&mute=1&rel=0"
                title="Vidéo vedette"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
        @foreach($videoThumbs as $index => $thumb)
            <a class="boids-video-card" href="{{ $videoChannelUrl }}" target="_blank" rel="noopener noreferrer">
                <img src="{{ $thumb }}" alt="Vidéo {{ $index + 1 }}">
                <div class="boids-video-overlay">
                    <span class="boids-video-play"><i class="fas fa-play"></i></span>
                    <span class="boids-video-title">Séquence vidéo {{ $index + 1 }}</span>
                </div>
            </a>
        @endforeach
    </div>
</article>

<article class="boids-section" id="section-social">
    <span class="boids-kicker"><i class="fas fa-share-nodes"></i> Réseaux Sociaux</span>
    <div class="boids-row-head">
        <h3>Suivez-Nous En Ligne</h3>
        <p>Restez connectés et valorisez vos contenus sur tous les canaux.</p>
    </div>
    <div class="boids-social-grid">
        <div class="boids-social-card">
            <div class="boids-social-head"><i class="fab fa-facebook"></i> Facebook</div>
            <div class="boids-social-body">
                <div class="boids-social-post">Nouveau projet de sciage complété avec succès. Résultat précis et client satisfait.</div>
                <div class="boids-social-post">Service mobile rapide sur site avec découpe personnalisée selon les besoins.</div>
                <a class="boids-social-btn boids-social-btn--fb" href="https://www.facebook.com/MoulinaciesLanaudiere" target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-facebook"></i> Suivre sur Facebook
                </a>
            </div>
        </div>
        <div class="boids-social-card">
            <div class="boids-social-head"><i class="fab fa-instagram"></i> Galerie Sociale</div>
            <div class="boids-social-body">
                <div class="boids-social-pics">
                    @foreach($gallery->take(6) as $media)
                        <img src="{{ $media['thumbnail'] }}" alt="{{ $media['name'] ?? 'Photo' }}">
                    @endforeach
                </div>
                <a class="boids-social-btn boids-social-btn--ig" href="{{ $devisLink }}" target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-images"></i> Voir plus de photos
                </a>
            </div>
        </div>
        <div class="boids-social-card">
            <div class="boids-social-head"><i class="fab fa-youtube"></i> YouTube</div>
            <div class="boids-social-body">
                <div class="boids-social-videos">
                    @foreach($videoThumbs as $thumb)
                        <a href="{{ $videoChannelUrl }}" target="_blank" rel="noopener noreferrer">
                            <img src="{{ $thumb }}" alt="Vignette vidéo">
                            <span><i class="fas fa-play-circle"></i></span>
                        </a>
                    @endforeach
                </div>
                <a class="boids-social-btn boids-social-btn--yt" href="{{ $videoChannelUrl }}" target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-youtube"></i> S'abonner sur YouTube
                </a>
            </div>
        </div>
    </div>
</article>
<article class="boids-section" id="section-hours">
                        <span class="boids-kicker"><i class="fas fa-clock"></i> Horaire & Contact</span>
                        <div class="boids-hours-contact">
                            <div class="boids-hours-card">
                                <div class="boids-hours-title">Heures d'ouverture</div>
                                <div class="boids-hours-body">
                                    @foreach($workingHours as $row)
                                        <div class="boids-hour">
                                            <span>{{ $row['day'] }}</span>
                                            <span>{{ $row['hours'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="boids-contact-card">
                                <div class="boids-hours-title">Coordonnees</div>
                                <div class="boids-contact-body">
                                    <div class="boids-contact-item"><i class="fas fa-location-dot"></i><span>{{ $address }}</span></div>
                                    @if($phone)<div class="boids-contact-item"><i class="fas fa-phone"></i><span>{{ $phone }}</span></div>@endif
                                    @if($email)<div class="boids-contact-item"><i class="fas fa-envelope"></i><span>{{ $email }}</span></div>@endif
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="boids-section">
                        <div class="boids-cta-band">
                            <h3>Pret a Transformer Votre Bois ?</h3>
                            <p>Recevez une soumission claire, rapide et adaptee a votre projet.</p>
                            <a href="{{ $devisLink }}" class="boids-cta-btn" target="_blank" rel="noopener noreferrer"><i class="fas fa-paper-plane"></i> Demander ma Soumission</a>
                        </div>
                    </article>

                    <article class="boids-section" id="section-contact">
                        <span class="boids-kicker"><i class="fas fa-envelope-open-text"></i> Soumission</span>
                        <div class="boids-contact-grid">
                            <div class="boids-map-wrap">
                                <div id="boidsMap" class="boids-map" style="height:100%;"></div>
                            </div>
                            <form id="boidsLandingContactForm" class="boids-form">
                                <h4>Soumission Gratuite</h4>
                                <p>Decrivez votre projet et nous vous recontactons rapidement.</p>
                                <div class="boids-form-grid">
                                    <input class="boids-input" type="text" name="first_name" placeholder="Prenom">
                                    <input class="boids-input" type="text" name="last_name" placeholder="Nom">
                                    <input class="boids-input boids-col-full" type="email" name="email" placeholder="Courriel">
                                    <input class="boids-input boids-col-full" type="text" name="phone" placeholder="Telephone">
                                    <select class="boids-select boids-col-full" name="service">
                                        <option value="">Type de service</option>
                                        <option value="Sciage haute precision">Sciage haute precision</option>
                                        <option value="Poutres piece sur piece">Poutres piece sur piece</option>
                                        <option value="Revetement en bois">Revetement en bois</option>
                                        <option value="Planage et emboutement">Planage et emboutement</option>
                                    </select>
                                    <textarea class="boids-textarea boids-col-full" name="message" placeholder="Decrivez vos besoins"></textarea>
                                    <button class="boids-submit boids-col-full" type="submit">Envoyer ma demande de soumission</button>
                                </div>
                            </form>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <div class="boids-lightbox" id="boidsLightbox">
        <button type="button" class="boids-lightbox-close" id="boidsLightboxClose" aria-label="Fermer">×</button>
        <img src="" alt="Preview" id="boidsLightboxImage">
    </div>

    <button type="button" class="boids-backtop" id="boidsBackTop" aria-label="Retour en haut">
        <i class="fas fa-arrow-up"></i>
    </button>

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
            const backTop = document.getElementById('boidsBackTop');
            if (backTop) {
                const toggleBackTop = function () {
                    if (window.scrollY > 260) {
                        backTop.classList.add('is-visible');
                    } else {
                        backTop.classList.remove('is-visible');
                    }
                };

                backTop.addEventListener('click', function () {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });

                toggleBackTop();
                window.addEventListener('scroll', toggleBackTop, { passive: true });
            }

            const form = document.getElementById('boidsLandingContactForm');
            if (form) {
                form.addEventListener('submit', function (event) {
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

            const lightbox = document.getElementById('boidsLightbox');
            const lightboxImg = document.getElementById('boidsLightboxImage');
            const lightboxClose = document.getElementById('boidsLightboxClose');
            document.querySelectorAll('#boidsGallery .boids-media').forEach(function (item) {
                item.addEventListener('click', function () {
                    const src = item.getAttribute('data-src');
                    if (!src || !lightbox || !lightboxImg) return;
                    lightboxImg.src = src;
                    lightbox.classList.add('open');
                });
            });
            if (lightbox && lightboxClose) {
                lightboxClose.addEventListener('click', function () {
                    lightbox.classList.remove('open');
                });
                lightbox.addEventListener('click', function (event) {
                    if (event.target === lightbox) {
                        lightbox.classList.remove('open');
                    }
                });
            }

            const reviewsTrack = document.getElementById('boidsReviewsTrack');
            const reviewPrev = document.getElementById('boidsReviewPrev');
            const reviewNext = document.getElementById('boidsReviewNext');
            if (reviewsTrack && reviewPrev && reviewNext) {
                let offset = 0;
                const step = function () {
                    const card = reviewsTrack.querySelector('.boids-review');
                    return card ? (card.getBoundingClientRect().width + 12) : 372;
                };

                reviewNext.addEventListener('click', function () {
                    const max = Math.max(0, reviewsTrack.scrollWidth - reviewsTrack.parentElement.clientWidth);
                    offset = Math.min(offset + step(), max);
                    reviewsTrack.style.transform = 'translateX(-' + offset + 'px)';
                });

                reviewPrev.addEventListener('click', function () {
                    offset = Math.max(offset - step(), 0);
                    reviewsTrack.style.transform = 'translateX(-' + offset + 'px)';
                });

                window.addEventListener('resize', function () {
                    const max = Math.max(0, reviewsTrack.scrollWidth - reviewsTrack.parentElement.clientWidth);
                    if (offset > max) {
                        offset = max;
                        reviewsTrack.style.transform = 'translateX(-' + offset + 'px)';
                    }
                });
            }

            if (window.L && document.getElementById('boidsMap')) {
                // Adresse exacte demandee: St-Alphonse Rodriguez, Quebec J0K 1W0
                const lat = 46.18506;
                const lng = -73.692169;
                const exactAddress = 'St-Alphonse Rodriguez, Quebec J0K 1W0';

                const map = L.map('boidsMap', {
                    zoomControl: true,
                    scrollWheelZoom: false
                }).setView([lat, lng], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                const markerIcon = L.divIcon({
                    className: 'lf-marker',
                    html: '<div class="lf-marker-wrap"><i class="fas fa-tree"></i></div>',
                    iconSize: [34, 34],
                    iconAnchor: [17, 32]
                });

                const mapVideoHtml = `
                    <div style="width:320px;max-width:100%;">
                        <div style="font-weight:700;margin-bottom:8px;">{{ addslashes($siteName) }}</div>
                        <iframe
                            width="320"
                            height="180"
                            src="https://www.youtube.com/embed/0edALYi7_Qs?autoplay=1&mute=1&playsinline=1&rel=0"
                            title="Video map"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            style="display:block;width:100%;border-radius:8px;">
                        </iframe>
                    </div>
                `;

                L.marker([lat, lng], { icon: markerIcon })
                    .addTo(map)
                    .bindPopup(mapVideoHtml, { maxWidth: 360, minWidth: 260 });

                setTimeout(function () {
                    map.invalidateSize();
                }, 260);
            }
        });
    </script>
</body>
</html>


