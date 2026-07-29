{{-- resources/views/landing/index.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>ActiveZone — Vivez l'Aventure</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <style>
        :root {
            --navy: #0A1628;
            --navy-mid: #112240;
            --orange: #FF6B35;
            --orange-light: #FF8C5A;
            --gold: #FFB800;
            --white: #FFFFFF;
            --gray-light: #F0F4FF;
            --gray-mid: #8892A4;
            --text-dark: #1A2744;
            --text-muted: #6B7A99;
            --card-bg: #FFFFFF;
            --border: #E4EAF6;
            --radius: 16px;
            --shadow: 0 8px 32px rgba(10,22,40,0.10);
            --shadow-lg: 0 20px 60px rgba(10,22,40,0.18);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--white);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--navy); }
        ::-webkit-scrollbar-thumb { background: var(--orange); border-radius: 3px; }

        /* ===== NAV ===== */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            padding: 0 40px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.4s, box-shadow 0.4s;
        }
        nav.scrolled {
            background: rgba(10,22,40,0.97);
            box-shadow: 0 4px 24px rgba(0,0,0,0.3);
            backdrop-filter: blur(12px);
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .nav-logo .logo-icon {
            width: 40px; height: 40px;
            background: var(--orange);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: white;
            font-weight: 900;
        }
        .nav-logo span {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 22px;
            color: white;
            letter-spacing: -0.5px;
        }
        .nav-logo span em { color: var(--orange); font-style: normal; }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }
        .nav-links a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.3px;
            transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--orange); }
        .nav-cta {
            background: var(--orange);
            color: white !important;
            padding: 10px 22px;
            border-radius: 50px;
            font-weight: 600 !important;
            transition: background 0.2s, transform 0.2s !important;
        }
        .nav-cta:hover { background: var(--orange-light); transform: translateY(-1px); }
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 8px;
        }
        .hamburger span {
            display: block;
            width: 24px; height: 2px;
            background: white;
            border-radius: 2px;
            transition: all 0.3s;
        }

        /* ===== HERO SLIDER ===== */
        #hero {
            position: relative;
            height: 100vh;
            min-height: 600px;
            overflow: hidden;
        }
        .hero-swiper {
            width: 100%; height: 100%;
        }
        .hero-slide {
            position: relative;
            overflow: hidden;
        }
        .hero-slide .bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transform: scale(1.08);
            transition: transform 8s ease;
        }
        .swiper-slide-active .bg { transform: scale(1); }
        .slide-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(10,22,40,0.85) 0%, rgba(10,22,40,0.4) 60%, rgba(255,107,53,0.15) 100%);
        }
        .hero-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 80px;
            max-width: 800px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,107,53,0.2);
            border: 1px solid rgba(255,107,53,0.5);
            color: var(--orange);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 8px 16px;
            border-radius: 50px;
            width: fit-content;
            margin-bottom: 24px;
            animation: fadeUp 0.8s ease 0.2s both;
        }
        .hero-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: clamp(42px, 6vw, 80px);
            line-height: 1.05;
            color: white;
            margin-bottom: 20px;
            animation: fadeUp 0.8s ease 0.4s both;
        }
        .hero-title .highlight {
            color: var(--orange);
            position: relative;
        }
        .hero-subtitle {
            font-size: 18px;
            color: rgba(255,255,255,0.75);
            line-height: 1.7;
            margin-bottom: 40px;
            max-width: 520px;
            animation: fadeUp 0.8s ease 0.6s both;
        }
        .hero-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            animation: fadeUp 0.8s ease 0.8s both;
        }
        .btn-primary {
            background: var(--orange);
            color: white;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 15px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        .btn-primary:hover {
            background: var(--orange-light);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(255,107,53,0.4);
        }
        .btn-secondary {
            background: rgba(255,255,255,0.1);
            color: white;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(255,255,255,0.3);
            transition: all 0.3s;
            backdrop-filter: blur(8px);
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
        .hero-stats {
            position: absolute;
            bottom: 60px;
            right: 80px;
            display: flex;
            gap: 40px;
            z-index: 2;
            animation: fadeUp 0.8s ease 1s both;
        }
        .stat-item { text-align: right; }
        .stat-number {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 32px;
            color: white;
            line-height: 1;
        }
        .stat-number span { color: var(--orange); }
        .stat-label {
            font-size: 12px;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 4px;
        }

        /* Hero Swiper Controls */
        .hero-swiper .swiper-pagination {
            bottom: 30px;
            left: 80px;
            right: auto;
            width: auto;
        }
        .hero-swiper .swiper-pagination-bullet {
            width: 32px; height: 4px;
            border-radius: 2px;
            background: rgba(255,255,255,0.4);
            opacity: 1;
            transition: all 0.3s;
        }
        .hero-swiper .swiper-pagination-bullet-active {
            background: var(--orange);
            width: 52px;
        }
        .hero-swiper .swiper-button-next,
        .hero-swiper .swiper-button-prev {
            color: white;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            width: 52px; height: 52px;
            border-radius: 50%;
            backdrop-filter: blur(8px);
            transition: all 0.3s;
        }
        .hero-swiper .swiper-button-next:hover,
        .hero-swiper .swiper-button-prev:hover {
            background: var(--orange);
            border-color: var(--orange);
        }
        .hero-swiper .swiper-button-next::after,
        .hero-swiper .swiper-button-prev::after {
            font-size: 14px;
            font-weight: 900;
        }

        /* ===== SECTION BASE ===== */
        section { padding: 100px 0; }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }
        .section-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--orange);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 14px;
        }
        .section-eyebrow::before {
            content: '';
            display: block;
            width: 24px; height: 2px;
            background: var(--orange);
            border-radius: 2px;
        }
        .section-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: clamp(32px, 4vw, 52px);
            line-height: 1.1;
            color: var(--text-dark);
            margin-bottom: 16px;
        }
        .section-title.light { color: white; }
        .section-subtitle {
            font-size: 17px;
            color: var(--text-muted);
            line-height: 1.7;
            max-width: 580px;
        }
        .section-subtitle.light { color: rgba(255,255,255,0.65); }
        .section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 60px;
            gap: 30px;
            flex-wrap: wrap;
        }
        .section-header-left { flex: 1; }

        /* ===== ACTIVITIES CATEGORIES ===== */
        #activites {
            background: var(--gray-light);
            padding: 100px 0;
        }
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 24px;
        }
        .cat-card {
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.35s;
            cursor: pointer;
            text-decoration: none;
            display: block;
        }
        .cat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }
        .cat-img {
            height: 180px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .cat-img::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(10,22,40,0.7) 0%, transparent 60%);
        }
        .cat-icon {
            position: absolute;
            bottom: 16px;
            left: 16px;
            z-index: 1;
            width: 44px; height: 44px;
            background: var(--orange);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 20px;
        }
        .cat-body { padding: 20px; }
        .cat-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 17px;
            color: var(--text-dark);
            margin-bottom: 6px;
        }
        .cat-count {
            font-size: 13px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ===== EVENTS ===== */
        #evenements { background: white; }
        .events-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        .event-card-featured {
            grid-row: span 2;
            background: var(--navy);
            border-radius: var(--radius);
            overflow: hidden;
            position: relative;
            min-height: 500px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            cursor: pointer;
        }
        .event-card-featured .bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: transform 0.4s;
        }
        .event-card-featured:hover .bg { transform: scale(1.05); }
        .event-card-featured::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(10,22,40,0.95) 0%, rgba(10,22,40,0.2) 60%);
        }
        .event-card-featured .content {
            position: relative;
            z-index: 1;
            padding: 32px;
        }
        .event-badge {
            display: inline-block;
            background: var(--orange);
            color: white;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 50px;
            margin-bottom: 14px;
        }
        .event-featured-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 26px;
            color: white;
            margin-bottom: 14px;
            line-height: 1.25;
        }
        .event-meta {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .event-meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: rgba(255,255,255,0.75);
        }
        .event-meta-item i { color: var(--orange); width: 16px; }

        .event-card-sm {
            background: var(--gray-light);
            border-radius: var(--radius);
            overflow: hidden;
            display: flex;
            gap: 0;
            transition: all 0.3s;
            cursor: pointer;
        }
        .event-card-sm:hover { box-shadow: var(--shadow); transform: translateX(4px); }
        .event-card-sm-date {
            background: var(--navy);
            width: 80px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 10px;
        }
        .event-card-sm-date .day {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 30px;
            color: var(--orange);
            line-height: 1;
        }
        .event-card-sm-date .month {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255,255,255,0.7);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .event-card-sm-body { padding: 18px 20px; }
        .event-card-sm-body .badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--orange);
            margin-bottom: 6px;
        }
        .event-card-sm-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 15px;
            color: var(--text-dark);
            margin-bottom: 8px;
            line-height: 1.35;
        }
        .event-card-sm-loc {
            font-size: 13px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ===== BLOG ===== */
        #blog { background: var(--gray-light); }
        .blog-swiper { overflow: visible; }
        .blog-swiper .swiper-wrapper { padding-bottom: 40px; }
        .blog-card {
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.35s;
        }
        .blog-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
        .blog-img {
            height: 220px;
            background-size: cover;
            background-position: center;
            position: relative;
            overflow: hidden;
        }
        .blog-img img { width: 100%; height: 100%; object-fit: cover; }
        .blog-cat-tag {
            position: absolute;
            top: 16px; left: 16px;
            background: var(--orange);
            color: white;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 50px;
        }
        .blog-body { padding: 24px; }
        .blog-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 12px;
            font-size: 13px;
            color: var(--text-muted);
        }
        .blog-meta span { display: flex; align-items: center; gap: 5px; }
        .blog-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 17px;
            color: var(--text-dark);
            line-height: 1.45;
            margin-bottom: 12px;
        }
        .blog-excerpt {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.65;
            margin-bottom: 20px;
        }
        .blog-link {
            font-size: 14px;
            font-weight: 600;
            color: var(--orange);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: gap 0.2s;
        }
        .blog-link:hover { gap: 10px; }

        /* ===== NEWS ===== */
        #actualites { background: var(--navy); }
        .news-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        .news-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius);
            padding: 28px;
            transition: all 0.3s;
            cursor: pointer;
        }
        .news-card:hover {
            background: rgba(255,255,255,0.09);
            border-color: rgba(255,107,53,0.4);
            transform: translateY(-4px);
        }
        .news-date {
            font-size: 12px;
            color: var(--orange);
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .news-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 16px;
            color: white;
            line-height: 1.45;
            margin-bottom: 14px;
        }
        .news-excerpt {
            font-size: 13px;
            color: rgba(255,255,255,0.55);
            line-height: 1.65;
            margin-bottom: 20px;
        }
        .news-link {
            font-size: 13px;
            color: var(--orange);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: gap 0.2s;
        }
        .news-link:hover { gap: 10px; }

        /* ===== AVIS ===== */
        #avis { background: white; }
        .reviews-swiper { overflow: visible; }
        .reviews-swiper .swiper-wrapper { padding-bottom: 50px; }
        .review-card {
            background: var(--gray-light);
            border-radius: var(--radius);
            padding: 32px;
            position: relative;
        }
        .review-quote {
            font-size: 60px;
            color: var(--orange);
            font-family: Georgia, serif;
            line-height: 0.5;
            margin-bottom: 20px;
            opacity: 0.3;
        }
        .review-text {
            font-size: 16px;
            color: var(--text-dark);
            line-height: 1.75;
            margin-bottom: 24px;
            font-style: italic;
        }
        .review-stars {
            display: flex;
            gap: 4px;
            margin-bottom: 20px;
        }
        .review-stars i { color: var(--gold); font-size: 14px; }
        .reviewer {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .reviewer-avatar {
            width: 48px; height: 48px;
            border-radius: 50%;
            background: var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 18px;
            color: var(--orange);
            flex-shrink: 0;
        }
        .reviewer-name {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 15px;
            color: var(--text-dark);
        }
        .reviewer-role {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
        }
        .reviews-rating-hero {
            display: flex;
            align-items: center;
            gap: 50px;
            background: var(--navy);
            border-radius: var(--radius);
            padding: 40px 50px;
            margin-bottom: 60px;
        }
        .rating-big {
            text-align: center;
        }
        .rating-big .num {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 72px;
            color: white;
            line-height: 1;
        }
        .rating-big .stars { display: flex; gap: 6px; margin: 8px 0; }
        .rating-big .stars i { color: var(--gold); font-size: 18px; }
        .rating-big .label { font-size: 14px; color: rgba(255,255,255,0.6); }
        .rating-bars { flex: 1; }
        .rating-bar-item {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 12px;
        }
        .rating-bar-label { font-size: 13px; color: rgba(255,255,255,0.7); width: 50px; }
        .rating-bar-track {
            flex: 1;
            height: 8px;
            background: rgba(255,255,255,0.1);
            border-radius: 4px;
            overflow: hidden;
        }
        .rating-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--orange), var(--gold));
            border-radius: 4px;
            transition: width 1.5s ease;
        }
        .rating-bar-pct { font-size: 13px; color: rgba(255,255,255,0.5); width: 36px; text-align: right; }

        /* ===== A PROPOS ===== */
        #apropos { background: var(--gray-light); }
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }
        .about-img-wrap {
            position: relative;
        }
        .about-img-main {
            border-radius: 20px;
            overflow: hidden;
            height: 500px;
        }
        .about-img-main .img {
            width: 100%; height: 100%;
            background-size: cover;
            background-position: center;
        }
        .about-img-badge {
            position: absolute;
            bottom: -24px;
            right: -24px;
            background: var(--orange);
            color: white;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            box-shadow: var(--shadow-lg);
        }
        .about-img-badge .big {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 36px;
            line-height: 1;
        }
        .about-img-badge .sm { font-size: 13px; opacity: 0.9; margin-top: 4px; }
        .about-float {
            position: absolute;
            top: -20px;
            left: -20px;
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .about-float-icon {
            width: 48px; height: 48px;
            background: rgba(255,107,53,0.1);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            color: var(--orange);
        }
        .about-float-text .num {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 20px;
            color: var(--text-dark);
        }
        .about-float-text .lbl { font-size: 12px; color: var(--text-muted); }
        .about-content .section-subtitle { margin-bottom: 30px; }
        .about-features {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 36px;
        }
        .about-features li {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            font-size: 15px;
            color: var(--text-dark);
            line-height: 1.5;
        }
        .about-features li .check {
            width: 24px; height: 24px;
            background: rgba(255,107,53,0.1);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--orange);
            font-size: 12px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .about-team {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 32px;
        }
        .team-avatars { display: flex; }
        .team-avatars .av {
            width: 40px; height: 40px;
            border-radius: 50%;
            border: 3px solid white;
            background: var(--navy);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: var(--orange);
            margin-left: -10px;
        }
        .team-avatars .av:first-child { margin-left: 0; }
        .team-text { font-size: 14px; color: var(--text-muted); }
        .team-text strong { color: var(--text-dark); font-weight: 600; }

        /* ===== PARTENAIRES ===== */
        #partenaires {
            background: white;
            padding: 60px 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }
        .partners-label {
            text-align: center;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 36px;
        }
        .partners-swiper .swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 60px;
        }
        .partner-logo {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 20px;
            color: var(--text-muted);
            opacity: 0.45;
            letter-spacing: -0.5px;
            transition: opacity 0.3s;
            cursor: pointer;
        }
        .partner-logo:hover { opacity: 0.9; }

        /* ===== CTA BAND ===== */
        #cta {
            background: linear-gradient(135deg, var(--orange) 0%, #E8420A 100%);
            padding: 90px 0;
            position: relative;
            overflow: hidden;
        }
        #cta::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
        }
        #cta::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }
        .cta-inner {
            text-align: center;
            position: relative;
            z-index: 1;
        }
        .cta-inner h2 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: clamp(30px, 4vw, 52px);
            color: white;
            margin-bottom: 16px;
        }
        .cta-inner p {
            font-size: 18px;
            color: rgba(255,255,255,0.85);
            margin-bottom: 40px;
        }
        .btn-white {
            background: white;
            color: var(--orange);
            padding: 18px 40px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        }
        .btn-white:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(0,0,0,0.3); }

        /* ===== CONTACT ===== */
        #contact { background: var(--navy); padding: 100px 0 0; }
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            padding-bottom: 80px;
        }
        .contact-info .section-title { color: white; margin-bottom: 16px; }
        .contact-info .section-subtitle { color: rgba(255,255,255,0.6); margin-bottom: 40px; }
        .contact-details {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .contact-detail-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }
        .contact-detail-icon {
            width: 48px; height: 48px;
            background: rgba(255,107,53,0.15);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: var(--orange);
            font-size: 18px;
            flex-shrink: 0;
        }
        .contact-detail-text .label {
            font-size: 12px;
            color: rgba(255,255,255,0.45);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        .contact-detail-text .val {
            font-size: 15px;
            color: white;
            font-weight: 500;
        }
        .contact-form {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 20px;
            padding: 40px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }
        .form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px; }
        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.7);
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 14px;
            color: white;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.3s;
            width: 100%;
        }
        .form-group select option { background: var(--navy); }
        .form-group input::placeholder,
        .form-group textarea::placeholder { color: rgba(255,255,255,0.3); }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: var(--orange);
        }
        .form-group textarea { resize: none; height: 110px; }

        /* ===== FOOTER ===== */
        footer {
            background: rgba(0,0,0,0.3);
            border-top: 1px solid rgba(255,255,255,0.07);
            padding: 40px;
        }
        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }
        .footer-copy {
            font-size: 13px;
            color: rgba(255,255,255,0.4);
        }
        .footer-socials { display: flex; gap: 14px; }
        .footer-socials a {
            width: 38px; height: 38px;
            background: rgba(255,255,255,0.07);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 15px;
            transition: all 0.3s;
        }
        .footer-socials a:hover { background: var(--orange); color: white; }
        .footer-nav { display: flex; gap: 24px; }
        .footer-nav a {
            font-size: 13px;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-nav a:hover { color: var(--orange); }

        /* ===== SCROLL TO TOP ===== */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 48px; height: 48px;
            background: var(--orange);
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            cursor: pointer;
            z-index: 900;
            box-shadow: 0 6px 20px rgba(255,107,53,0.4);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s;
            text-decoration: none;
        }
        .scroll-top.visible { opacity: 1; transform: translateY(0); }
        .scroll-top:hover { background: var(--orange-light); transform: translateY(-3px); }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }

        /* ===== SWIPER CUSTOM ===== */
        .blog-swiper .swiper-pagination-bullet,
        .reviews-swiper .swiper-pagination-bullet {
            background: var(--text-muted);
            opacity: 1;
            width: 10px; height: 10px;
        }
        .blog-swiper .swiper-pagination-bullet-active,
        .reviews-swiper .swiper-pagination-bullet-active {
            background: var(--orange);
            width: 28px;
            border-radius: 5px;
        }

        /* ===== MOBILE NAV ===== */
        .mobile-menu {
            display: none;
            position: fixed;
            inset: 0;
            background: var(--navy);
            z-index: 999;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 32px;
        }
        .mobile-menu.open { display: flex; }
        .mobile-menu a {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 24px;
            color: white;
            text-decoration: none;
            transition: color 0.2s;
        }
        .mobile-menu a:hover { color: var(--orange); }
        .mobile-menu .close-btn {
            position: absolute;
            top: 24px; right: 24px;
            background: none;
            border: none;
            color: white;
            font-size: 28px;
            cursor: pointer;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .events-grid { grid-template-columns: 1fr; }
            .event-card-featured { grid-row: span 1; min-height: 360px; }
            .news-grid { grid-template-columns: 1fr 1fr; }
            .about-grid { grid-template-columns: 1fr; gap: 60px; }
            .about-img-wrap { max-width: 500px; }
            .contact-grid { grid-template-columns: 1fr; gap: 50px; }
        }
        @media (max-width: 768px) {
            nav { padding: 0 20px; }
            .nav-links { display: none; }
            .hamburger { display: flex; }
            .hero-content { padding: 0 24px; }
            .hero-stats { right: 24px; bottom: 100px; gap: 20px; }
            .stat-number { font-size: 24px; }
            section { padding: 70px 0; }
            .container { padding: 0 20px; }
            .section-header { flex-direction: column; align-items: flex-start; }
            .news-grid { grid-template-columns: 1fr; }
            .events-grid { grid-template-columns: 1fr; }
            .reviews-rating-hero { flex-direction: column; padding: 28px; gap: 30px; }
            .rating-big .num { font-size: 56px; }
            .form-row { grid-template-columns: 1fr; }
            .footer-inner { flex-direction: column; align-items: flex-start; }
            .about-img-badge { right: 0; bottom: -16px; }
            .about-float { left: 0; top: -16px; }
        }
    </style>
</head>
<body>

<!-- NAV -->
<nav id="navbar">
    <a href="#" class="nav-logo">
        <div class="logo-icon"><i class="fas fa-bolt"></i></div>
        <span>Active<em>Zone</em></span>
    </a>
    <ul class="nav-links">
        <li><a href="#activites">Activités</a></li>
        <li><a href="#evenements">Événements</a></li>
        <li><a href="#blog">Blog</a></li>
        <li><a href="#actualites">Actualités</a></li>
        <li><a href="#avis">Avis</a></li>
        <li><a href="#apropos">À Propos</a></li>
        <li><a href="#contact" class="nav-cta">Nous Contacter</a></li>
    </ul>
    <div class="hamburger" id="hamburger">
        <span></span><span></span><span></span>
    </div>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
    <button class="close-btn" id="closeMenu"><i class="fas fa-times"></i></button>
    <a href="#activites" onclick="closeMobile()">Activités</a>
    <a href="#evenements" onclick="closeMobile()">Événements</a>
    <a href="#blog" onclick="closeMobile()">Blog</a>
    <a href="#actualites" onclick="closeMobile()">Actualités</a>
    <a href="#avis" onclick="closeMobile()">Avis</a>
    <a href="#apropos" onclick="closeMobile()">À Propos</a>
    <a href="#contact" onclick="closeMobile()" style="color:var(--orange)">Nous Contacter</a>
</div>

<!-- ===== HERO ===== -->
<section id="hero">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            @foreach($heroSlides as $slide)
            <div class="swiper-slide hero-slide">
                <div class="bg" style="background-image: url('{{ $slide['image'] }}')"></div>
                <div class="slide-overlay"></div>
                <div class="hero-content">
                    <div class="hero-badge"><i class="fas fa-star"></i> {{ $slide['badge'] }}</div>
                    <h1 class="hero-title">{!! $slide['title'] !!}</h1>
                    <p class="hero-subtitle">{{ $slide['subtitle'] }}</p>
                    <div class="hero-actions">
                        <a href="{{ $slide['primary_btn_link'] }}" class="btn-primary">
                            <i class="fas fa-play"></i> {{ $slide['primary_btn_text'] }}
                        </a>
                        <a href="{{ $slide['secondary_btn_link'] }}" class="btn-secondary">
                            <i class="fas fa-calendar"></i> {{ $slide['secondary_btn_text'] }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
    <!-- Stats -->
    <div class="hero-stats">
        <div class="stat-item">
            <div class="stat-number">{{ number_format($stats['total_participants']) }}<span>+</span></div>
            <div class="stat-label">Participants</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $stats['total_activities'] }}<span>+</span></div>
            <div class="stat-label">Activités</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $stats['average_rating'] }}<span>★</span></div>
            <div class="stat-label">Note moyenne</div>
        </div>
    </div>
</section>

<!-- ===== ACTIVITES ===== -->
<section id="activites">
    <div class="container">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-eyebrow">Nos Activités</div>
                <h2 class="section-title">Trouvez Votre<br>Prochaine Aventure</h2>
                <p class="section-subtitle">Du sport extrême à la balade nature, nous proposons des activités pour tous les goûts et tous les niveaux.</p>
            </div>
            <a href="#" class="btn-primary" style="white-space:nowrap">Voir tout <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="categories-grid">
            @foreach($categories as $category)
            <a href="#" class="cat-card reveal">
                <div class="cat-img" style="background-image:url('{{ $category['image'] }}')">
                    <div class="cat-icon"><i class="fas {{ $category['icon'] }}"></i></div>
                </div>
                <div class="cat-body">
                    <div class="cat-title">{{ $category['name'] }}</div>
                    <div class="cat-count"><i class="fas fa-layer-group"></i> {{ $category['count'] }} activités disponibles</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Carrousel d'annonces (cards) --}}
@include('components.ads-cards', ['adContext' => 'activities'])

<!-- ===== ÉVÉNEMENTS ===== -->
<section id="evenements">
    <div class="container">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-eyebrow">Événements</div>
                <h2 class="section-title">À Ne Pas Manquer</h2>
                <p class="section-subtitle">Rejoignez nos prochains événements sportifs et culturels organisés partout en France.</p>
            </div>
            <a href="#" class="btn-primary" style="white-space:nowrap">Tous les événements <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="events-grid">
            @if($featuredEvents->count() > 0)
                <!-- Featured Event -->
                <div class="event-card-featured reveal">
                    <div class="bg" style="background-image:url('{{ $featuredEvents->first()->image_url ?? 'https://images.unsplash.com/photo-1513151233558-d860c5398176?w=900&q=80' }}')"></div>
                    <div class="content">
                        <span class="event-badge">🔥 Événement Vedette</span>
                        <div class="event-featured-title">{{ $featuredEvents->first()->title }}</div>
                        <div class="event-meta">
                            <div class="event-meta-item"><i class="fas fa-calendar"></i> {{ $featuredEvents->first()->event_start_date ? $featuredEvents->first()->event_start_date->format('d F Y') : 'Date à définir' }}</div>
                            <div class="event-meta-item"><i class="fas fa-map-marker-alt"></i> {{ $featuredEvents->first()->event_location ?? 'Lieu à définir' }}</div>
                            @if($featuredEvents->first()->event_capacity)
                            <div class="event-meta-item"><i class="fas fa-users"></i> {{ $featuredEvents->first()->event_capacity }} participants</div>
                            @endif
                            <div class="event-meta-item"><i class="fas fa-ticket-alt"></i> {{ $featuredEvents->first()->event_is_free ? 'Gratuit' : 'À partir de ' . number_format($featuredEvents->first()->event_price ?? 0, 0, ',', ' ') . ' €' }}</div>
                        </div>
                        <a href="#" class="btn-primary" style="margin-top:20px">Je m'inscris <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Small Events -->
                @foreach($featuredEvents->skip(1) as $event)
                <div class="event-card-sm reveal">
                    <div class="event-card-sm-date">
                        <div class="day">{{ $event->event_start_date ? $event->event_start_date->format('d') : '--' }}</div>
                        <div class="month">{{ $event->event_start_date ? $event->event_start_date->format('M') : '---' }}</div>
                    </div>
                    <div class="event-card-sm-body">
                        <div class="badge">{{ $event->event_category ?? 'Événement' }}</div>
                        <div class="event-card-sm-title">{{ $event->title }}</div>
                        <div class="event-card-sm-loc"><i class="fas fa-map-marker-alt"></i> {{ $event->event_location ?? 'Lieu à définir' }}</div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state" style="grid-column: 1/-1; text-align:center; padding:40px;">
                    <p>Aucun événement disponible pour le moment.</p>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- ===== BLOG ===== -->
<section id="blog">
    <div class="container">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-eyebrow">Blog & Conseils</div>
                <h2 class="section-title">Inspirations & Astuces</h2>
                <p class="section-subtitle">Découvrez nos articles de conseils, guides terrain et récits d'aventures rédigés par nos experts.</p>
            </div>
            <a href="{{ route('landing.blogs') }}" class="btn-primary" style="white-space:nowrap">Voir le blog <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="swiper blog-swiper">
            <div class="swiper-wrapper">
                @forelse($blogs as $blog)
                <div class="swiper-slide">
                    <div class="blog-card">
                        <div class="blog-img" style="background:url('{{ $blog->image_url ?? 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=600&q=80' }}') center/cover">
                            <span class="blog-cat-tag">{{ $blog->blog_category ?? 'Blog' }}</span>
                        </div>
                        <div class="blog-body">
                            <div class="blog-meta">
                                <span><i class="fas fa-user"></i> {{ $blog->blog_author ?? 'Admin' }}</span>
                                <span><i class="fas fa-calendar"></i> {{ $blog->published_at ? $blog->published_at->format('d F Y') : $blog->created_at->format('d F Y') }}</span>
                            </div>
                            <div class="blog-title">{{ $blog->title }}</div>
                            <div class="blog-excerpt">{{ Str::limit(strip_tags($blog->blog_excerpt ?? $blog->content ?? ''), 120) }}</div>
                            <a href="{{ route('landing.blog.show', $blog->id) }}" class="blog-link">Lire l'article <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="swiper-slide">
                    <div class="blog-card">
                        <div class="blog-img" style="background:url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=600&q=80') center/cover">
                            <span class="blog-cat-tag">Blog</span>
                        </div>
                        <div class="blog-body">
                            <div class="blog-meta">
                                <span><i class="fas fa-user"></i> Admin</span>
                                <span><i class="fas fa-calendar"></i> {{ date('d F Y') }}</span>
                            </div>
                            <div class="blog-title">Bientôt des articles disponibles</div>
                            <div class="blog-excerpt">Revenez bientôt pour découvrir nos articles de blog.</div>
                            <a href="#" class="blog-link">Lire l'article <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
            <div class="swiper-pagination" style="margin-top:10px"></div>
        </div>
    </div>
</section>

<!-- ===== ACTUALITES ===== -->
<section id="actualites">
    <div class="container">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-eyebrow" style="color:var(--orange)">Actualités</div>
                <h2 class="section-title light">Les Dernières Nouvelles</h2>
                <p class="section-subtitle light">Suivez toute l'actu du sport outdoor, de nos partenaires et de la communauté ActiveZone.</p>
            </div>
            <a href="#" class="btn-secondary" style="white-space:nowrap">Toutes les actus <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="news-grid">
            @php
                $newsItems = [
                    [
                        'date' => '12 Juin 2025',
                        'title' => 'ActiveZone s\'associe avec la Fédération Française de Montagne et d\'Escalade',
                        'excerpt' => 'Un partenariat stratégique pour développer la pratique de l\'escalade auprès des jeunes en France.'
                    ],
                    [
                        'date' => '8 Juin 2025',
                        'title' => 'Nouvelle application mobile ActiveZone disponible sur iOS et Android',
                        'excerpt' => 'Réservez vos activités, suivez vos performances et rejoignez notre communauté depuis votre smartphone.'
                    ],
                    [
                        'date' => '2 Juin 2025',
                        'title' => 'Record d\'inscription pour le Trail des Sommets 2025 : plus de 450 coureurs',
                        'excerpt' => 'L\'édition 2025 de notre trail phare bat tous les records avec une liste d\'attente déjà ouverte.'
                    ],
                ]
            @endphp
            @foreach($newsItems as $index => $news)
            <div class="news-card reveal {{ $index === 0 ? '' : ($index === 1 ? 'reveal-delay-1' : 'reveal-delay-2') }}">
                <div class="news-date"><i class="fas fa-circle" style="font-size:8px"></i> {{ $news['date'] }}</div>
                <div class="news-title">{{ $news['title'] }}</div>
                <div class="news-excerpt">{{ $news['excerpt'] }}</div>
                <a href="#" class="news-link">Lire plus <i class="fas fa-arrow-right"></i></a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===== AVIS ===== -->
<section id="avis">
    <div class="container">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-eyebrow">Témoignages</div>
                <h2 class="section-title">Ce Que Disent Nos Aventuriers</h2>
                <p class="section-subtitle">Des milliers de participants nous font confiance. Voici ce qu'ils pensent de leurs expériences.</p>
            </div>
        </div>

        <!-- Rating Overview -->
        <div class="reviews-rating-hero reveal">
            <div class="rating-big">
                <div class="num">{{ $stats['average_rating'] }}</div>
                <div class="stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </div>
                <div class="label">Basé sur {{ number_format($stats['total_reviews']) }} avis</div>
            </div>
            <div class="rating-bars">
                <div class="rating-bar-item">
                    <div class="rating-bar-label">5 ★</div>
                    <div class="rating-bar-track"><div class="rating-bar-fill" style="width:88%"></div></div>
                    <div class="rating-bar-pct">88%</div>
                </div>
                <div class="rating-bar-item">
                    <div class="rating-bar-label">4 ★</div>
                    <div class="rating-bar-track"><div class="rating-bar-fill" style="width:9%"></div></div>
                    <div class="rating-bar-pct">9%</div>
                </div>
                <div class="rating-bar-item">
                    <div class="rating-bar-label">3 ★</div>
                    <div class="rating-bar-track"><div class="rating-bar-fill" style="width:2%"></div></div>
                    <div class="rating-bar-pct">2%</div>
                </div>
                <div class="rating-bar-item">
                    <div class="rating-bar-label">2 ★</div>
                    <div class="rating-bar-track"><div class="rating-bar-fill" style="width:1%"></div></div>
                    <div class="rating-bar-pct">1%</div>
                </div>
            </div>
        </div>

        <!-- Reviews Slider -->
        <div class="swiper reviews-swiper">
            <div class="swiper-wrapper">
                @forelse($testimonials as $testimonial)
                <div class="swiper-slide">
                    <div class="review-card">
                        <div class="review-quote">"</div>
                        <div class="review-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= ($testimonial->testimonial_rating ?? 5))
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="fas fa-star" style="color: #e2e8f0;"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="review-text">{{ Str::limit(strip_tags($testimonial->content ?? $testimonial->testimonial_content ?? ''), 200) }}</p>
                        <div class="reviewer">
                            <div class="reviewer-avatar">{{ substr($testimonial->testimonial_name ?? 'CL', 0, 2) }}</div>
                            <div>
                                <div class="reviewer-name">{{ $testimonial->testimonial_name ?? 'Client' }}</div>
                                <div class="reviewer-role">{{ $testimonial->testimonial_role ?? 'Participant' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="swiper-slide">
                    <div class="review-card">
                        <div class="review-quote">"</div>
                        <div class="review-stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="review-text">Une expérience incroyable ! Je recommande vivement ActiveZone pour leurs activités de qualité et leurs guides passionnés.</p>
                        <div class="reviewer">
                            <div class="reviewer-avatar">CL</div>
                            <div>
                                <div class="reviewer-name">Claire Lemoine</div>
                                <div class="reviewer-role">Participante</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
            <div class="swiper-pagination" style="margin-top:20px"></div>
        </div>
    </div>
</section>

<!-- ===== A PROPOS ===== -->
<section id="apropos">
    <div class="container">
        <div class="about-grid">
            <div class="about-img-wrap reveal">
                <div class="about-img-main">
                    <div class="img" style="background-image:url('{{ $about->image_url ?? 'https://images.unsplash.com/photo-1522163182402-834f871fd851?w=800&q=80' }}')"></div>
                </div>
                <div class="about-img-badge">
                    <div class="big">15</div>
                    <div class="sm">Ans d'expertise</div>
                </div>
                <div class="about-float">
                    <div class="about-float-icon"><i class="fas fa-trophy"></i></div>
                    <div class="about-float-text">
                        <div class="num">48 Prix</div>
                        <div class="lbl">Récompenses nationales</div>
                    </div>
                </div>
            </div>
            <div class="about-content reveal reveal-delay-2">
                <div class="section-eyebrow">À Propos de Nous</div>
                <h2 class="section-title">{{ $about->title ?? 'Votre Partenaire d\'Aventure Depuis 2010' }}</h2>
                <p class="section-subtitle">{{ $about->content ?? 'ActiveZone est née d\'une passion commune pour le sport outdoor et l\'aventure. Depuis 15 ans, nous accompagnons des milliers d\'aventuriers à travers des expériences uniques, sécurisées et inoubliables.' }}</p>
                <ul class="about-features">
                    <li>
                        <span class="check"><i class="fas fa-check"></i></span>
                        <span>Guides certifiés et expérimentés avec minimum 10 ans de pratique terrain</span>
                    </li>
                    <li>
                        <span class="check"><i class="fas fa-check"></i></span>
                        <span>Équipements homologués et renouvelés chaque saison pour votre sécurité</span>
                    </li>
                    <li>
                        <span class="check"><i class="fas fa-check"></i></span>
                        <span>Groupes de taille réduite (max 12 personnes) pour une expérience personnalisée</span>
                    </li>
                    <li>
                        <span class="check"><i class="fas fa-check"></i></span>
                        <span>Activités adaptées à tous les niveaux, du débutant absolu au sportif confirmé</span>
                    </li>
                    <li>
                        <span class="check"><i class="fas fa-check"></i></span>
                        <span>Engagement éco-responsable : pratique durable et respect des milieux naturels</span>
                    </li>
                </ul>
                <a href="#contact" class="btn-primary">Nous Découvrir <i class="fas fa-arrow-right"></i></a>
                <div class="about-team">
                    <div class="team-avatars">
                        <div class="av">ML</div>
                        <div class="av">TR</div>
                        <div class="av">SC</div>
                        <div class="av">JB</div>
                    </div>
                    <div class="team-text"><strong>+40 guides</strong> passionnés à votre service</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== PARTENAIRES ===== -->
<section id="partenaires">
    <div class="container">
        <div class="partners-label">Ils nous font confiance</div>
        <div class="swiper partners-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><div class="partner-logo">SALOMON</div></div>
                <div class="swiper-slide"><div class="partner-logo">MAMMUT</div></div>
                <div class="swiper-slide"><div class="partner-logo">PATAGONIA</div></div>
                <div class="swiper-slide"><div class="partner-logo">GARMIN</div></div>
                <div class="swiper-slide"><div class="partner-logo">DECATHLON</div></div>
                <div class="swiper-slide"><div class="partner-logo">BLACK DIAMOND</div></div>
                <div class="swiper-slide"><div class="partner-logo">THE NORTH FACE</div></div>
                <div class="swiper-slide"><div class="partner-logo">OSPREY</div></div>
            </div>
        </div>
    </div>
</section>

<!-- ===== CTA ===== -->
<section id="cta">
    <div class="container">
        <div class="cta-inner">
            <h2>Prêt à Vivre Votre Prochaine<br>Grande Aventure ?</h2>
            <p>Rejoignez plus de {{ number_format($stats['total_participants']) }} aventuriers et réservez dès maintenant votre expérience inoubliable.</p>
            <a href="#contact" class="btn-white"><i class="fas fa-rocket"></i> Démarrer l'Aventure</a>
        </div>
    </div>
</section>

<!-- ===== CONTACT ===== -->
<section id="contact">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info reveal">
                <div class="section-eyebrow" style="color:var(--orange)">Contact</div>
                <h2 class="section-title" style="color:white">Parlons de<br>Votre Projet</h2>
                <p class="section-subtitle" style="color:rgba(255,255,255,0.6);margin-bottom:40px">{{ $contact->content ?? 'Notre équipe est disponible pour répondre à toutes vos questions et vous accompagner dans le choix de vos activités.' }}</p>
                <div class="contact-details">
                    @php
                        $contactDetails = [
                            ['icon' => 'fa-map-marker-alt', 'label' => 'Adresse', 'value' => '12 Rue des Aventuriers, 75008 Paris, France'],
                            ['icon' => 'fa-phone', 'label' => 'Téléphone', 'value' => '+33 (0)1 23 45 67 89'],
                            ['icon' => 'fa-envelope', 'label' => 'Email', 'value' => $contact->contact_email ?? 'contact@activezone.fr'],
                            ['icon' => 'fa-clock', 'label' => 'Horaires', 'value' => $contact->contact_hours ?? 'Lun–Sam : 9h00 – 18h30'],
                        ]
                    @endphp
                    @foreach($contactDetails as $detail)
                    <div class="contact-detail-item">
                        <div class="contact-detail-icon"><i class="fas {{ $detail['icon'] }}"></i></div>
                        <div class="contact-detail-text">
                            <div class="label">{{ $detail['label'] }}</div>
                            <div class="val">{{ $detail['value'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="contact-form reveal reveal-delay-2">
                <form action="#" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label>Prénom</label>
                            <input type="text" placeholder="Votre prénom" required/>
                        </div>
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" placeholder="Votre nom" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" placeholder="votre@email.fr" required/>
                    </div>
                    <div class="form-group">
                        <label>Activité souhaitée</label>
                        <select>
                            <option value="">Sélectionnez une activité</option>
                            <option>Ski & Snowboard</option>
                            <option>Randonnée & Trekking</option>
                            <option>Surf & Sports nautiques</option>
                            <option>Cyclisme & VTT</option>
                            <option>Sports Extrêmes</option>
                            <option>Autre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea placeholder="Décrivez votre projet d'aventure..." required></textarea>
                    </div>
                    <button class="btn-primary" style="width:100%;justify-content:center">
                        <i class="fas fa-paper-plane"></i> Envoyer le message
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-inner">
            <div class="footer-copy">© 2025 ActiveZone. Tous droits réservés.</div>
            <nav class="footer-nav">
                <a href="#">Mentions légales</a>
                <a href="#">Politique de confidentialité</a>
                <a href="#">CGU</a>
                <a href="#">Cookies</a>
            </nav>
            <div class="footer-socials">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-tiktok"></i></a>
                <a href="#"><i class="fab fa-strava"></i></a>
            </div>
        </div>
    </footer>
</section>

<!-- Scroll Top -->
<a href="#hero" class="scroll-top" id="scrollTop"><i class="fas fa-chevron-up"></i></a>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    // ===== NAV SCROLL =====
    const navbar = document.getElementById('navbar');
    const scrollTopBtn = document.getElementById('scrollTop');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 60) {
            navbar.classList.add('scrolled');
            scrollTopBtn.classList.add('visible');
        } else {
            navbar.classList.remove('scrolled');
            scrollTopBtn.classList.remove('visible');
        }
    });

    // ===== MOBILE MENU =====
    document.getElementById('hamburger').addEventListener('click', () => {
        document.getElementById('mobileMenu').classList.add('open');
    });
    document.getElementById('closeMenu').addEventListener('click', () => {
        document.getElementById('mobileMenu').classList.remove('open');
    });
    function closeMobile() {
        document.getElementById('mobileMenu').classList.remove('open');
    }

    // ===== HERO SWIPER =====
    new Swiper('.hero-swiper', {
        loop: true,
        speed: 900,
        autoplay: { delay: 5500, disableOnInteraction: false },
        effect: 'fade',
        fadeEffect: { crossFade: true },
        pagination: { el: '.hero-swiper .swiper-pagination', clickable: true },
        navigation: {
            nextEl: '.hero-swiper .swiper-button-next',
            prevEl: '.hero-swiper .swiper-button-prev'
        }
    });

    // ===== BLOG SWIPER =====
    new Swiper('.blog-swiper', {
        slidesPerView: 1,
        spaceBetween: 24,
        loop: true,
        autoplay: { delay: 4000, disableOnInteraction: false },
        pagination: { el: '.blog-swiper .swiper-pagination', clickable: true },
        breakpoints: {
            640: { slidesPerView: 2 },
            1024: { slidesPerView: 3 }
        }
    });

    // ===== REVIEWS SWIPER =====
    new Swiper('.reviews-swiper', {
        slidesPerView: 1,
        spaceBetween: 24,
        loop: true,
        autoplay: { delay: 4500, disableOnInteraction: false },
        pagination: { el: '.reviews-swiper .swiper-pagination', clickable: true },
        breakpoints: {
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 }
        }
    });

    // ===== PARTNERS SWIPER =====
    new Swiper('.partners-swiper', {
        slidesPerView: 2,
        spaceBetween: 40,
        loop: true,
        speed: 3000,
        autoplay: { delay: 0, disableOnInteraction: false },
        freeMode: true,
        breakpoints: {
            480: { slidesPerView: 3 },
            768: { slidesPerView: 4 },
            1024: { slidesPerView: 6 }
        }
    });

    // ===== SCROLL REVEAL =====
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    reveals.forEach(el => observer.observe(el));

    // ===== ACTIVE NAV LINK =====
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-links a');
    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(sec => {
            if (window.scrollY >= sec.offsetTop - 100) current = sec.getAttribute('id');
        });
        navLinks.forEach(a => {
            a.style.color = a.getAttribute('href') === `#${current}` ? 'var(--orange)' : '';
        });
    });
</script>
{{-- Popup publicitaire rotatif (Ads Manager) --}}
@include('components.ads-popup', ['adContext' => 'activities'])
</body>
</html>