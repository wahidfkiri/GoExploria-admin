{{-- resources/views/landing/activity-detail.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $activity->name }} - Go Exploria Business</title>
    <meta name="description" content="{{ $activity->description ?? 'Découvrez notre activité' }}" />

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
            background: rgba(10,22,40,0.97);
            box-shadow: 0 4px 24px rgba(0,0,0,0.3);
            backdrop-filter: blur(12px);
        }
        nav.scrolled {
            background: rgba(10,22,40,0.97);
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

        /* ===== MEGA MENU ACTIVITÉS ===== */
        .nav-dropdown-wrap { position: relative; }
        .nav-link-dropdown { cursor: pointer; }
        .dropdown-arrow { font-size: 0.6em; margin-left: 4px; }
        .nav-mega {
            display: none;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--navy);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            min-width: 600px;
            max-width: 800px;
            box-shadow: var(--shadow-lg);
            z-index: 999;
            gap: 16px;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        }
        .nav-dropdown-wrap:hover .nav-mega { display: grid; }
        .nav-mega-col { break-inside: avoid; }
        .nav-mega-cat-title {
            color: var(--orange);
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .nav-mega-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 8px;
            border-radius: 8px;
            color: rgba(255,255,255,0.75);
            font-size: 0.78rem;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
            margin-bottom: 2px;
        }
        .nav-mega-item:hover { background: rgba(255,107,53,0.1); color: var(--orange); }
        .nav-mega-item img,
        .nav-mega-placeholder {
            width: 28px; height: 28px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }
        .nav-mega-placeholder {
            background: var(--navy-mid);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
            color: var(--gray-mid);
        }
        .nav-mega-item span { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        @media (max-width: 900px) {
            .nav-mega { min-width: 400px; max-width: 500px; grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .nav-mega { min-width: 260px; max-width: 300px; grid-template-columns: 1fr; padding: 12px; }
            .nav-mega-item { font-size: 0.72rem; }
        }

        /* ===== HERO ===== */
        #hero {
            position: relative;
            height: 100vh;
            min-height: 600px;
            overflow: hidden;
            background: var(--navy);
        }
        .hero-swiper {
            width: 100%; height: 100%;
        }
        .hero-slide {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 100%;
        }

        /* Video Background - Full Width Cover */
        .hero-slide .video-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        .hero-slide .video-bg iframe {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100vw;
            height: 56.25vw;
            min-height: 100vh;
            min-width: 177.78vh;
            border: none;
            pointer-events: none;
        }
        .hero-slide .video-bg iframe[src*="vimeo"] {
            pointer-events: none;
        }

        .video-thumbnail {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            z-index: 2;
            width: 100%;
            height: 100%;
        }

        .slide-overlay-video {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(10,22,40,0.6) 0%, rgba(10,22,40,0.2) 60%, rgba(255,107,53,0.1) 100%);
            z-index: 3;
        }

        .hero-content {
            position: relative;
            z-index: 4;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 80px;
            max-width: 800px;
        }
        .hero-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 40px;
            line-height: 1.15;
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
        .hero-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--orange);
            color: #fff;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: background 0.2s, transform 0.2s;
            align-self: flex-start;
            animation: fadeUp 0.8s ease 0.8s both;
        }
        .hero-btn:hover { background: var(--orange-light); transform: translateY(-2px); }
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

        /* Hero Swiper Controls */
        .hero-swiper .swiper-pagination {
            bottom: 30px;
            left: 80px;
            right: auto;
            width: auto;
            z-index: 10;
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
            z-index: 10;
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

        @media (max-width: 768px) {
            .hero-content { padding: 0 24px; }
            .hero-swiper .swiper-pagination {
                left: 24px;
                bottom: 20px;
            }
            .hero-swiper .swiper-button-next,
            .hero-swiper .swiper-button-prev {
                display: none;
            }
            .hero-slide .video-bg iframe {
                width: 177.78vw;
                height: 100vh;
                min-width: auto;
                min-height: auto;
            }
        }

        @media (max-width: 480px) {
            .hero-title { font-size: 30px; }
            .hero-subtitle { font-size: 15px; }
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

        /* ===== ABOUT ===== */
        #about { background: var(--gray-light); }
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
            height: 400px;
        }
        .about-img-main .img {
            width: 100%; height: 100%;
            background-size: cover;
            background-position: center;
        }
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
            min-height: 400px;
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
            font-size: 24px;
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
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }
        .blog-card {
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.35s;
            text-decoration: none;
            display: block;
        }
        .blog-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
        .blog-img {
            height: 220px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
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

        /* ===== TESTIMONIALS ===== */
        #avis { background: white; }
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 30px;
        }
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

        /* ===== FAQ ===== */
        #faq { background: var(--gray-light); }
        .faq-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        .faq-item {
            background: white;
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow);
            transition: all 0.3s;
        }
        .faq-item:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); }
        .faq-question {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 16px;
            color: var(--text-dark);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .faq-question i { color: var(--orange); }
        .faq-answer {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.7;
        }

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
            background: var(--navy);
            padding: 40px;
            border-top: 1px solid rgba(255,255,255,0.07);
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

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .events-grid { grid-template-columns: 1fr; }
            .event-card-featured { grid-row: span 1; min-height: 360px; }
            .about-grid { grid-template-columns: 1fr; gap: 60px; }
            .contact-grid { grid-template-columns: 1fr; gap: 50px; }
            .faq-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            nav { padding: 0 20px; }
            .nav-links { display: none; }
            section { padding: 70px 0; }
            .container { padding: 0 20px; }
            .section-header { flex-direction: column; align-items: flex-start; }
            .events-grid { grid-template-columns: 1fr; }
            .blog-grid { grid-template-columns: 1fr; }
            .testimonials-grid { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
            .footer-inner { flex-direction: column; align-items: flex-start; }
        }

    </style>
</head>
<body>

<!-- NAV -->
<nav id="navbar">
    <ul class="nav-links">
        @if(isset($navCategories) && $navCategories->count() > 0)
        <li class="nav-dropdown-wrap">
            <a href="#activites" class="nav-link-dropdown">Activités <span class="dropdown-arrow">&#9662;</span></a>
            <div class="nav-mega">
                @foreach($navCategories as $cat)
                <div class="nav-mega-col">
                    <div class="nav-mega-cat-title">{{ $cat->name }}</div>
                    @foreach($cat->activities as $act)
                    <a href="{{ route('landing.activity.show', $act->slug) }}" class="nav-mega-item">
                        @if($act->image_url)
                        <img src="{{ $act->image_url }}" alt="{{ $act->name }}" loading="lazy" />
                        @else
                        <div class="nav-mega-placeholder"></div>
                        @endif
                        <span>{{ $act->name }}</span>
                    </a>
                    @endforeach
                </div>
                @endforeach
            </div>
        </li>
        @endif
        @if($about)
        <li><a href="#about">À propos</a></li>
        @endif
        @if(isset($events) && $events->count() > 0)
        <li><a href="#evenements">Événements</a></li>
        @endif
        @if(isset($blogs) && $blogs->count() > 0)
        <li><a href="#blog">Blog</a></li>
        @endif
        @if(isset($testimonials) && $testimonials->count() > 0)
        <li><a href="#avis">Avis</a></li>
        @endif
        @if(isset($faqs) && $faqs->count() > 0)
        <li><a href="#faq">FAQ</a></li>
        @endif
        @if($contact)
        <li><a href="#contact" class="nav-cta">Nous Contacter</a></li>
        @endif
    </ul>
    <a href="{{ route('landing.home') }}" class="nav-logo">
        <img src="{{asset('logo.png')}}" alt="Logo" class="logo-img" width="160px;">
    </a>
</nav>

<!-- ===== HERO ===== -->
@if(count($heroSlides) > 0)
<section id="hero">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            @foreach($heroSlides as $slideIndex => $slide)
            @php
                $slideType = $slide['type'] ?? 'video';
                $slideThumbnail = $slide['thumbnail'] ?? null;
                $slideVideoUrl = $slide['video_url'] ?? null;
                $slideBadge = $slide['badge'] ?? 'Vidéo';
                $slideTitle = $slide['title'] ?? $activity->name;
                $slideSubtitle = $slide['subtitle'] ?? ($activity->description ?? '');
                $slidePrimaryText = $slide['primary_btn_text'] ?? 'Lire la vidéo';
                $slideSecondaryText = $slide['secondary_btn_text'] ?? null;
                $slideSecondaryLink = $slide['secondary_btn_link'] ?? '#about';
                $slideButtonText = $slide['button_text'] ?? null;
                $slideButtonUrl = $slide['button_url'] ?? null;
            @endphp
            <div class="swiper-slide hero-slide" data-type="{{ $slideType }}" data-index="{{ $slideIndex }}">
                <!-- Vidéo en full width cover -->
                <div class="video-bg" id="videoBg-{{ $slideIndex }}">
                    <iframe id="heroVideo-{{ $slideIndex }}" 
                            src="{{ $slideVideoUrl }}?autoplay=1"
                            allow="autoplay; encrypted-media; fullscreen"
                            allowfullscreen
                            style="width:100%;height:100%;border:none;position:relative;z-index:2;object-fit:cover;">
                    </iframe>
                </div>
                <div class="slide-overlay-video"></div>
                
                <div class="hero-content">
                    <h1 class="hero-title">{!! $slideTitle !!}</h1>
                    <p class="hero-subtitle">{{ $slideSubtitle }}</p>
                    @if($slideButtonText && $slideButtonUrl)
                    <a href="{{ $slideButtonUrl }}" class="hero-btn" target="_blank" rel="noopener">{{ $slideButtonText }}</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>
@endif

<!-- ===== ABOUT ===== -->
@if($about)
<section id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-img-wrap reveal">
                <div class="about-img-main">
                    <div class="img" style="background-image:url('{{ $about->image_url ?? 'https://images.unsplash.com/photo-1522163182402-834f871fd851?w=800&q=80' }}')"></div>
                </div>
            </div>
            <div class="about-content reveal reveal-delay-2">
                <div class="section-eyebrow">À Propos</div>
                <h2 class="section-title">{{ $about->title ?? 'Découvrez Notre Activité' }}</h2>
                {!! $about->content ?? '' !!}
                @if($about->about_values)
                <ul class="about-features">
                    @foreach(explode("\n", $about->about_values) as $value)
                        @if(trim($value))
                        <li>
                            <span class="check"><i class="fas fa-check"></i></span>
                            <span>{{ trim($value) }}</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

<!-- ===== EVENTS ===== -->
@if($events->count() > 0)
<section id="evenements">
    <div class="container">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-eyebrow">Événements</div>
                <h2 class="section-title">À Ne Pas Manquer</h2>
                <p class="section-subtitle">Rejoignez nos prochains événements organisés autour de notre activité.</p>
            </div>
            @if($events->count() > 5)
            <a href="{{ route('landing.activity.event.index', $activity->slug) }}" class="btn-primary" style="white-space:nowrap">Tous les événements <i class="fas fa-arrow-right"></i></a>
            @endif
        </div>
        <div class="events-grid">
            <!-- Featured Event -->
            <div class="event-card-featured reveal">
                <div class="bg" style="background-image:url('{{ $events->first()->image_url ?? 'https://images.unsplash.com/photo-1513151233558-d860c5398176?w=900&q=80' }}')"></div>
                <div class="content">
                    <span class="event-badge">🔥 Événement Vedette</span>
                    <div class="event-featured-title">{{ $events->first()->title }}</div>
                    <div class="event-meta">
                        @if($events->first()->event_start_date)
                        <div class="event-meta-item"><i class="fas fa-calendar"></i> {{ $events->first()->event_start_date->format('d F Y') }}</div>
                        @endif
                        @if($events->first()->event_location)
                        <div class="event-meta-item"><i class="fas fa-map-marker-alt"></i> {{ $events->first()->event_location }}</div>
                        @endif
                        <div class="event-meta-item"><i class="fas fa-ticket-alt"></i> {{ $events->first()->event_is_free ? 'Gratuit' : 'À partir de ' . number_format($events->first()->event_price ?? 0, 0, ',', ' ') . ' €' }}</div>
                    </div>
                    <a href="{{ route('landing.activity.event.show', [$activity->slug, $events->first()->id]) }}" class="btn-primary" style="margin-top:20px">Je m'inscris <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <!-- Small Events -->
            @foreach($events->skip(1)->take(4) as $event)
            <div class="event-card-sm reveal">
                <div class="event-card-sm-date">
                    <div class="day">{{ $event->event_start_date ? $event->event_start_date->format('d') : '--' }}</div>
                    <div class="month">{{ $event->event_start_date ? $event->event_start_date->format('M') : '---' }}</div>
                </div>
                <div class="event-card-sm-body">
                    <div class="badge">{{ $event->event_category ?? 'Événement' }}</div>
                    <div class="event-card-sm-title">{{ $event->title }}</div>
                    @if($event->event_location)
                    <div class="event-card-sm-loc"><i class="fas fa-map-marker-alt"></i> {{ $event->event_location }}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ===== BLOG ===== -->
@if($blogs->count() > 0)
<section id="blog">
    <div class="container">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-eyebrow">Blog & Conseils</div>
                <h2 class="section-title">Articles & Inspirations</h2>
                <p class="section-subtitle">Découvrez nos articles de conseils et récits d'aventures.</p>
            </div>
            @if($blogs->count() > 3)
            <a href="{{ route('landing.activity.blog.index', $activity->slug) }}" class="btn-primary" style="white-space:nowrap">Voir le blog <i class="fas fa-arrow-right"></i></a>
            @endif
        </div>
        <div class="blog-grid">
            @foreach($blogs->take(3) as $blog)
            <a href="{{ route('landing.activity.blog.show', [$activity->slug, $blog->id]) }}" class="blog-card reveal">
                <div class="blog-img" style="background-image:url('{{ $blog->image_url ?? 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=600&q=80' }}')">
                    @if($blog->blog_category)
                    <span class="blog-cat-tag">{{ $blog->blog_category }}</span>
                    @endif
                </div>
                <div class="blog-body">
                    <div class="blog-meta">
                        @if($blog->blog_author)
                        <span><i class="fas fa-user"></i> {{ $blog->blog_author }}</span>
                        @endif
                        <span><i class="fas fa-calendar"></i> {{ $blog->published_at ? $blog->published_at->format('d/m/Y') : $blog->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="blog-title">{{ $blog->title }}</div>
                    <p class="blog-excerpt">{{ Str::limit(strip_tags($blog->blog_excerpt ?? $blog->content ?? ''), 100) }}</p>
                    <span class="blog-link">Lire l'article <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ===== TESTIMONIALS ===== -->
@if($testimonials->count() > 0)
<section id="avis">
    <div class="container">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-eyebrow">Témoignages</div>
                <h2 class="section-title">Ce Que Disent Nos Participants</h2>
                <p class="section-subtitle">Découvrez les retours de ceux qui ont vécu l'expérience.</p>
            </div>
            @if($testimonials->count() > 3)
            <a href="{{ route('landing.activity.testimonials', $activity->slug) }}" class="btn-primary" style="white-space:nowrap">Voir tous les avis <i class="fas fa-arrow-right"></i></a>
            @endif
        </div>
        <div class="testimonials-grid">
            @foreach($testimonials->take(3) as $testimonial)
            <div class="review-card reveal">
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
                <p class="review-text">{{ Str::limit(strip_tags($testimonial->content ?? $testimonial->testimonial_content ?? ''), 150) }}</p>
                <div class="reviewer">
                    <div class="reviewer-avatar">{{ substr($testimonial->testimonial_name ?? 'CL', 0, 2) }}</div>
                    <div>
                        <div class="reviewer-name">{{ $testimonial->testimonial_name ?? 'Client' }}</div>
                        @if($testimonial->testimonial_role)
                        <div class="reviewer-role">{{ $testimonial->testimonial_role }}</div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ===== FAQ ===== -->
@if($faqs->count() > 0)
<section id="faq">
    <div class="container">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-eyebrow">FAQ</div>
                <h2 class="section-title">Questions Fréquentes</h2>
                <p class="section-subtitle">Trouvez rapidement des réponses à vos questions les plus courantes.</p>
            </div>
        </div>
        <div class="faq-grid">
            @foreach($faqs as $faq)
            <div class="faq-item reveal">
                <div class="faq-question">
                    <i class="fas fa-question-circle"></i>
                    {{ $faq->faq_question ?? $faq->title ?? 'Question' }}
                </div>
                <div class="faq-answer">{!! $faq->content !!}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ===== CONTACT ===== -->
@if($contact)
<section id="contact">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info reveal">
                <div class="section-eyebrow" style="color:var(--orange)">Contact</div>
                <h2 class="section-title" style="color:white">Parlons de<br>Votre Projet</h2>
                <p class="section-subtitle" style="color:rgba(255,255,255,0.6);margin-bottom:40px">{{ strip_tags($contact->content ?? 'Notre équipe est disponible pour répondre à toutes vos questions.') }}</p>
                <div class="contact-details">
                    <div class="contact-detail-item">
                        <div class="contact-detail-icon"><i class="fas fa-envelope"></i></div>
                        <div class="contact-detail-text">
                            <div class="label">Email</div>
                            <div class="val">{{ $contact->contact_email ?? 'contact@activezone.fr' }}</div>
                        </div>
                    </div>
                    @if($contact->contact_phone)
                    <div class="contact-detail-item">
                        <div class="contact-detail-icon"><i class="fas fa-phone"></i></div>
                        <div class="contact-detail-text">
                            <div class="label">Téléphone</div>
                            <div class="val">{{ $contact->contact_phone }}</div>
                        </div>
                    </div>
                    @endif
                    @if($contact->contact_address)
                    <div class="contact-detail-item">
                        <div class="contact-detail-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="contact-detail-text">
                            <div class="label">Adresse</div>
                            <div class="val">{{ $contact->contact_address }}</div>
                        </div>
                    </div>
                    @endif
                    @if($contact->contact_hours)
                    <div class="contact-detail-item">
                        <div class="contact-detail-icon"><i class="fas fa-clock"></i></div>
                        <div class="contact-detail-text">
                            <div class="label">Horaires</div>
                            <div class="val">{{ $contact->contact_hours }}</div>
                        </div>
                    </div>
                    @endif
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
                        <label>Message</label>
                        <textarea placeholder="Décrivez votre projet..." required></textarea>
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
@endif

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

    // ===== HERO SWIPER =====
    const heroSwiper = new Swiper('.hero-swiper', {
        loop: true,
        speed: 900,
        autoplay: { 
            delay: 6000, 
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        effect: 'fade',
        fadeEffect: { crossFade: true },
        pagination: { 
            el: '.hero-swiper .swiper-pagination', 
            clickable: true 
        },
        navigation: {
            nextEl: '.hero-swiper .swiper-button-next',
            prevEl: '.hero-swiper .swiper-button-prev'
        },
        on: {
            slideChange: function() {
                document.querySelectorAll('.hero-slide iframe').forEach(iframe => {
                    iframe.contentWindow.postMessage('{"event":"command","func":"stopVideo","args":""}', '*');
                });
            }
        }
    });

    // ===== GESTION DU FULLSCREEN =====
    document.addEventListener('fullscreenchange', function() {
        if (!document.fullscreenElement) {
            // L'utilisateur a quitté le fullscreen, reprendre l'autoplay
            if (heroSwiper) {
                heroSwiper.autoplay.start();
            }
        }
    });

    document.addEventListener('webkitfullscreenchange', function() {
        if (!document.webkitFullscreenElement) {
            if (heroSwiper) {
                heroSwiper.autoplay.start();
            }
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

    // ===== KEYBOARD SHORTCUT =====
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            if (heroSwiper) heroSwiper.slidePrev();
        } else if (e.key === 'ArrowRight') {
            if (heroSwiper) heroSwiper.slideNext();
        } else if (e.key === 'Escape') {
            // Sortie du fullscreen avec ESC
            if (document.fullscreenElement) {
                document.exitFullscreen().catch(() => {});
            }
        }
    });
</script>
</body>
</html>