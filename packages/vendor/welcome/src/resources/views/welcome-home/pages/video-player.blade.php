<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GO EXPLORIA - Découvrez le Québec autrement">
    <title>{{ __('welcome-home.pages.video_player_title') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/welcome/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/vertical-menu-videos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/vertical-destinations-mega.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/videos-dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/interactive-map.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/viewing-carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/viewing-carousel-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/video-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/slideshows.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/video-player.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/events-vedette.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/destinations-vedette.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/restaurants-vedette.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/menu-accord-mets-vins.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/footer.css') }}">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: #0a0a2a;
            color: #fff;
            overflow-x: hidden;
        }

        /* ============================================
           VIDEO PLAYER SECTION (Original)
           ============================================ */
        .video-player-v2-section {
            padding: 2rem 0;
            background: linear-gradient(135deg, #0a0a2a 0%, #1a1a3a 100%);
        }

        .video-player-v2-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .video-player-v2-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .video-player-v2-header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
        }

        .video-player-v2-play-circle {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
        }

        .video-player-v2-main-title {
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: #fff;
        }

        .video-player-v2-logo {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 1;
        }

        .video-player-v2-brand-logo {
            height: 100px;
            width: auto;
        }

        .video-player-v2-brand-name {
            font-size: 1.25rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: 1px;
        }

        .video-player-v2-upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .video-player-v2-upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .video-player-v2-learn-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .video-player-v2-learn-btn:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .video-player-v2-header-right {
            display: flex;
            gap: 1rem;
            z-index: 1;
        }

        .video-player-v2-content {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 2rem;
        }

        .video-player-v2-main {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            overflow: hidden;
        }

        .video-player-v2-wrapper {
            position: relative;
            padding-bottom: 56.25%;
            background: #000;
        }

        .video-player-v2-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-player-v2-controls {
            padding: 1rem;
            background: rgba(0, 0, 0, 0.8);
        }

        .video-player-v2-progress-bar {
            width: 100%;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            cursor: pointer;
            margin-bottom: 1rem;
        }

        .video-player-v2-progress-filled {
            width: 0%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
            position: relative;
        }

        .video-player-v2-controls-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .video-player-v2-controls-left,
        .video-player-v2-controls-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .video-player-v2-control-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0.5rem;
            transition: all 0.3s ease;
        }

        .video-player-v2-control-btn:hover {
            color: #667eea;
        }

        .video-player-v2-time {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .video-player-v2-counter {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .video-player-v2-info {
            padding: 1rem;
        }

        .video-player-v2-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .video-player-v2-description {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .video-player-v2-playlist {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            overflow: hidden;
        }

        .video-player-v2-playlist-header {
            padding: 1rem;
            background: rgba(0, 0, 0, 0.5);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .video-player-v2-playlist-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .video-player-v2-playlist-items {
            list-style: none;
            max-height: 500px;
            overflow-y: auto;
        }

        .video-player-v2-playlist-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .video-player-v2-playlist-item:hover,
        .video-player-v2-playlist-item.active {
            background: rgba(102, 126, 234, 0.2);
        }

        .video-player-v2-playlist-thumbnail {
            position: relative;
            width: 120px;
            height: 68px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .video-player-v2-playlist-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-player-v2-playlist-badge {
            position: absolute;
            bottom: 4px;
            right: 4px;
            background: rgba(0, 0, 0, 0.7);
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.7rem;
        }

        .video-player-v2-play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .video-player-v2-playlist-item:hover .video-player-v2-play-icon {
            opacity: 1;
        }

        .video-player-v2-playlist-info {
            flex: 1;
        }

        .video-player-v2-playlist-name {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .video-player-v2-playlist-type {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.5);
        }

        /* ============================================
           CREATE CHANNEL HERO SECTION
           ============================================ */
        .create-channel-hero {
            padding: 5rem 0;
            background: linear-gradient(135deg, #0a0a2a 0%, #1a1a3a 100%);
            position: relative;
            overflow: hidden;
        }

        .create-channel-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path fill="rgba(102,126,234,0.05)" d="M0 0h200v200H0z"/><circle cx="100" cy="100" r="80" fill="none" stroke="rgba(102,126,234,0.1)" stroke-width="2"/></svg>') repeat;
            pointer-events: none;
        }

        .create-channel-hero-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .create-channel-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(102, 126, 234, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(102, 126, 234, 0.3);
        }

        .create-channel-hero-badge i {
            color: #667eea;
            font-size: 0.9rem;
        }

        .create-channel-hero-badge span {
            color: #fff;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .create-channel-hero-title {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            color: #fff;
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .create-channel-hero-description {
            font-size: 1.1rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
        }

        .create-channel-hero-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.8rem 1.8rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.8rem 1.8rem;
            background: transparent;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .create-channel-hero-stats {
            display: flex;
            gap: 2rem;
            padding-top: 1rem;
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: #667eea;
        }

        .stat-label {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .create-channel-hero-image {
            position: relative;
            min-height: 400px;
        }

        .hero-illustration {
            width: 100%;
            height: 350px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(118, 75, 162, 0.2));
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .placeholder-illustration i {
            font-size: 6rem;
            color: rgba(102, 126, 234, 0.6);
        }

        .floating-card {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            padding: 0.8rem 1.2rem;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: float 3s ease-in-out infinite;
        }

        .floating-card i {
            color: #667eea;
            font-size: 1.2rem;
        }

        .floating-card span {
            color: white;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .card-1 {
            top: -20px;
            left: -20px;
            animation-delay: 0s;
        }

        .card-2 {
            bottom: 40px;
            right: -30px;
            animation-delay: 0.5s;
        }

        .card-3 {
            bottom: -10px;
            left: 20%;
            animation-delay: 1s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        /* ============================================
           FEATURES SECTION
           ============================================ */
        .channel-features {
            padding: 5rem 0;
            background: #0f0f2a;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-tag {
            display: inline-block;
            padding: 0.4rem 1rem;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.7);
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 2rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(102, 126, 234, 0.5);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .feature-icon i {
            font-size: 1.8rem;
            color: white;
        }

        .feature-card h3 {
            font-size: 1.3rem;
            margin-bottom: 0.75rem;
            color: #fff;
        }

        .feature-card p {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
        }

        /* ============================================
           HOW IT WORKS SECTION
           ============================================ */
        .how-it-works {
            padding: 5rem 0;
            background: #0a0a2a;
        }

        .steps-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .step-item {
            flex: 1;
            min-width: 200px;
            text-align: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .step-number {
            font-size: 3rem;
            font-weight: 800;
            color: rgba(102, 126, 234, 0.2);
            position: absolute;
            top: 1rem;
            right: 1rem;
        }

        .step-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .step-icon i {
            font-size: 2rem;
            color: white;
        }

        .step-item h3 {
            font-size: 1.2rem;
            margin-bottom: 0.75rem;
            color: #fff;
        }

        .step-item p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .step-arrow i {
            font-size: 2rem;
            color: #667eea;
        }

        /* ============================================
           BENEFITS SECTION
           ============================================ */
        .creator-benefits {
            padding: 5rem 0;
            background: linear-gradient(135deg, #0f0f2a 0%, #1a1a3a 100%);
        }

        .benefits-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .benefits-content .section-tag {
            background: rgba(102, 126, 234, 0.2);
        }

        .benefits-content h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: #fff;
        }

        .benefits-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .benefit-item {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }

        .benefit-item i {
            font-size: 1.5rem;
            color: #667eea;
            margin-top: 0.2rem;
        }

        .benefit-item h4 {
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
            color: #fff;
        }

        .benefit-item p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .benefits-image {
            display: flex;
            justify-content: center;
        }

        .image-wrapper {
            width: 100%;
            max-width: 400px;
            height: 400px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(118, 75, 162, 0.2));
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .image-wrapper i {
            font-size: 8rem;
            color: rgba(102, 126, 234, 0.6);
        }

        /* ============================================
           TESTIMONIALS SECTION
           ============================================ */
        .creator-testimonials {
            padding: 5rem 0;
            background: #0a0a2a;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .testimonial-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 2rem;
            border-radius: 20px;
            display: flex;
            gap: 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.08);
        }

        .testimonial-avatar img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }

        .testimonial-content {
            flex: 1;
        }

        .testimonial-content i {
            font-size: 1.5rem;
            color: #667eea;
            opacity: 0.5;
            margin-bottom: 0.5rem;
        }

        .testimonial-content p {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .testimonial-content h4 {
            color: #fff;
            margin-bottom: 0.25rem;
        }

        .testimonial-content span {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
        }

        /* ============================================
           FAQ SECTION
           ============================================ */
        .channel-faq {
            padding: 5rem 0;
            background: #0f0f2a;
        }

        .faq-grid {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .faq-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem 1.5rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .faq-question:hover {
            background: rgba(102, 126, 234, 0.1);
        }

        .faq-question h3 {
            font-size: 1rem;
            color: #fff;
        }

        .faq-question i {
            color: #667eea;
            transition: transform 0.3s ease;
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding: 0 1.5rem;
        }

        .faq-item.active .faq-answer {
            max-height: 200px;
            padding: 0 1.5rem 1.2rem;
        }

        .faq-answer p {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
        }

        /* ============================================
           FINAL CTA SECTION
           ============================================ */
        .final-cta {
            padding: 5rem 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .cta-wrapper {
            text-align: center;
            color: white;
        }

        .cta-wrapper h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .cta-wrapper p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .btn-large {
            padding: 1rem 2rem;
            font-size: 1.1rem;
        }

        .btn-outline {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            background: white;
            color: #667eea;
        }

        .cta-note {
            font-size: 0.85rem;
            opacity: 0.7;
        }

        /* ============================================
           FOOTER
           ============================================ */
        .footer {
            background: #050514;
            padding: 3rem 0 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer-logo h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .footer-logo p {
            color: rgba(255, 255, 255, 0.6);
        }

        .footer-links h4,
        .footer-social h4 {
            margin-bottom: 1rem;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #667eea;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background: #667eea;
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.85rem;
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 992px) {
            .create-channel-hero-container {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .create-channel-hero-stats {
                justify-content: center;
            }
            
            .create-channel-hero-buttons {
                justify-content: center;
            }
            
            .steps-container {
                flex-direction: column;
            }
            
            .step-arrow {
                transform: rotate(90deg);
            }
            
            .benefits-wrapper {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .benefit-item {
                text-align: left;
            }
            
            .video-player-v2-content {
                grid-template-columns: 1fr;
            }
            
            .video-player-v2-logo {
                position: static;
                transform: none;
                order: -1;
                justify-content: center;
                width: 100%;
            }
            
            .video-player-v2-header {
                justify-content: center;
            }
            
            .video-player-v2-header-left {
                order: 1;
                width: 100%;
                justify-content: center;
            }
            
            .video-player-v2-header-right {
                order: 2;
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .create-channel-hero-title {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            .testimonial-card {
                flex-direction: column;
                text-align: center;
                align-items: center;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .testimonials-grid {
                grid-template-columns: 1fr;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .video-player-v2-upload-btn span,
            .video-player-v2-learn-btn span {
                display: none;
            }
            
            .video-player-v2-upload-btn,
            .video-player-v2-learn-btn {
                padding: 0.6rem;
            }
        }
    </style>
</head>
<body>

    @include('welcome-home.components.VerticalMenu')
    @include('welcome-home.components.Header1')

    <main class="main-content">
    {{-- VIDEO PLAYER SECTION --}}
    <section class="video-player-v2-section" style="margin-top:250px;">
        <div class="video-player-v2-container">
            <div class="video-player-v2-header">
                <div class="video-player-v2-header-left">
                    <div class="video-player-v2-play-circle">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                    <h1 class="video-player-v2-main-title">CRÉEZ DE VOTRE CHAÎNE VIDÉO GO EXPLORIA MYTUBE / DIFFUSION INTERNATIONAL ICI</h1>
                </div>

                <div class="video-player-v2-logo">
                    <img src="{{ asset('GO-EXPLORIA-MY-TUBE.png') }}" alt="Go Exploria" class="video-player-v2-brand-logo" onerror="this.style.display='none'">
                </div>

                <div class="video-player-v2-header-right">
                    <a href="#" class="video-player-v2-upload-btn" id="uploadVideoBtn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/>
                        </svg>
                        <span>Télécharger votre première vidéo</span>
                    </a>
                </div>
            </div>

            <div class="video-player-v2-content">
                <div class="video-player-v2-main">
                    <div class="video-player-v2-wrapper">
                        <video id="mainVideoPlayer" class="video-player-v2-video">
                            <source src="https://storage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4" type="video/mp4">
                            Votre navigateur ne supporte pas la lecture de vidéos.
                        </video>
                    </div>
                    
                    <div class="video-player-v2-controls" id="videoControls">
                        <div class="video-player-v2-progress-bar" id="progressBar">
                            <div class="video-player-v2-progress-filled" id="progressFilled"></div>
                        </div>
                        <div class="video-player-v2-controls-bottom">
                            <div class="video-player-v2-controls-left">
                                <button class="video-player-v2-control-btn play-btn" id="playPauseBtn">
                                    <i class="fas fa-play play-icon"></i>
                                    <i class="fas fa-pause pause-icon" style="display: none;"></i>
                                </button>
                                <button class="video-player-v2-control-btn" id="volumeBtn">
                                    <i class="fas fa-volume-up volume-on-icon"></i>
                                    <i class="fas fa-volume-mute volume-off-icon" style="display: none;"></i>
                                </button>
                                <span class="video-player-v2-time" id="timeDisplay">0:00 / 0:00</span>
                            </div>
                            <div class="video-player-v2-controls-right">
                                <span class="video-player-v2-counter" id="mediaCounter">1 / 5</span>
                                <button class="video-player-v2-control-btn" id="fullscreenBtn">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="video-player-v2-info">
                        <h2 class="video-player-v2-title" id="videoTitle">Paysage Montagneux</h2>
                        <p class="video-player-v2-description" id="videoDescription">Un magnifique panorama de montagnes enneigées au coucher du soleil.</p>
                    </div>
                </div>

                <div class="video-player-v2-playlist">
                    <div class="video-player-v2-playlist-header">
                        <h3 class="video-player-v2-playlist-title">Playlist</h3>
                    </div>
                    <ul class="video-player-v2-playlist-items" id="playlistItems">
                        <li class="video-player-v2-playlist-item active" data-src="https://storage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4" data-title="Paysage Montagneux" data-description="Un magnifique panorama de montagnes enneigées au coucher du soleil.">
                            <div class="video-player-v2-playlist-thumbnail">
                                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=150&h=100&fit=crop" alt="Paysage Montagneux">
                                <span class="video-player-v2-playlist-badge">Vidéo</span>
                            </div>
                            <div class="video-player-v2-playlist-info">
                                <h4 class="video-player-v2-playlist-name">Paysage Montagneux</h4>
                                <p class="video-player-v2-playlist-type">Vidéo • 0:30</p>
                            </div>
                        </li>
                        <li class="video-player-v2-playlist-item" data-src="https://storage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFunflies.mp4" data-title="Forêt Tropicale" data-description="Explorez la beauté luxuriante d'une forêt tropicale dense.">
                            <div class="video-player-v2-playlist-thumbnail">
                                <img src="https://images.unsplash.com/photo-1511497584788-876760111969?w=150&h=100&fit=crop" alt="Forêt Tropicale">
                                <span class="video-player-v2-playlist-badge">Vidéo</span>
                            </div>
                            <div class="video-player-v2-playlist-info">
                                <h4 class="video-player-v2-playlist-name">Forêt Tropicale</h4>
                                <p class="video-player-v2-playlist-type">Vidéo • 0:15</p>
                            </div>
                        </li>
                        <li class="video-player-v2-playlist-item" data-src="https://storage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4" data-title="Ville Nocturne" data-description="Découvrez l'énergie vibrante d'une métropole illuminée la nuit.">
                            <div class="video-player-v2-playlist-thumbnail">
                                <img src="https://images.unsplash.com/photo-1514565131-fce0801e5785?w=150&h=100&fit=crop" alt="Ville Nocturne">
                                <span class="video-player-v2-playlist-badge">Vidéo</span>
                            </div>
                            <div class="video-player-v2-playlist-info">
                                <h4 class="video-player-v2-playlist-name">Ville Nocturne</h4>
                                <p class="video-player-v2-playlist-type">Vidéo • 0:25</p>
                            </div>
                        </li>
                        <li class="video-player-v2-playlist-item" data-src="https://storage.googleapis.com/gtv-videos-bucket/sample/ForBiggerJoyrides.mp4" data-title="Océan et Vagues" data-description="Laissez-vous bercer par le son apaisant des vagues de l'océan.">
                            <div class="video-player-v2-playlist-thumbnail">
                                <img src="https://images.unsplash.com/photo-1505142468610-359e7d316be0?w=150&h=100&fit=crop" alt="Océan et Vagues">
                                <span class="video-player-v2-playlist-badge">Vidéo</span>
                            </div>
                            <div class="video-player-v2-playlist-info">
                                <h4 class="video-player-v2-playlist-name">Océan et Vagues</h4>
                                <p class="video-player-v2-playlist-type">Vidéo • 0:12</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- CREATE CHANNEL HERO SECTION --}}
    <section class="create-channel-hero">
        <div class="create-channel-hero-container">
            <div class="create-channel-hero-content">
                <div class="create-channel-hero-badge">
                    <i class="fas fa-crown"></i>
                    <span>Créez votre chaîne gratuitement</span>
                </div>
                <h1 class="create-channel-hero-title">
                    Devenez créateur de contenu<br>
                    <span class="gradient-text">avec GO EXPLORIA MyTube</span>
                </h1>
                <p class="create-channel-hero-description">
                    Lancez votre propre chaîne vidéo, partagez vos aventures, et diffusez vos créations 
                    à une audience internationale. Une plateforme dédiée aux passionnés de voyage, 
                    de culture et de découverte.
                </p>
                <div class="create-channel-hero-buttons">
                    <button class="btn-primary" id="startChannelBtn">
                        <i class="fas fa-play-circle"></i>
                        Créer ma chaîne maintenant
                    </button>
                    <button class="btn-secondary" id="learnMoreChannelBtn">
                        <i class="fas fa-info-circle"></i>
                        En savoir plus
                    </button>
                </div>
                <div class="create-channel-hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">Créateurs actifs</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">10K+</span>
                        <span class="stat-label">Vidéos publiées</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">1M+</span>
                        <span class="stat-label">Vues par mois</span>
                    </div>
                </div>
            </div>
            <div class="create-channel-hero-image">
                <div class="floating-card card-1">
                    <i class="fas fa-video"></i>
                    <span>Upload facile</span>
                </div>
                <div class="floating-card card-2">
                    <i class="fas fa-chart-line"></i>
                    <span>Statistiques en temps réel</span>
                </div>
                <div class="floating-card card-3">
                    <i class="fas fa-globe"></i>
                    <span>Diffusion internationale</span>
                </div>
                <div class="hero-illustration">
                    <div class="placeholder-illustration">
                        <i class="fas fa-film"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES SECTION --}}
    <section class="channel-features">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Fonctionnalités</span>
                <h2 class="section-title">Tout ce qu'il vous faut pour <span class="gradient-text">réussir</span></h2>
                <p class="section-subtitle">Des outils professionnels pour créer, gérer et monétiser votre contenu vidéo</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-upload"></i>
                    </div>
                    <h3>Upload simplifié</h3>
                    <p>Importez vos vidéos en quelques clics. Support de tous les formats (MP4, MOV, AVI, WebM). Upload en arrière-plan avec barre de progression.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3>Éditeur intégré</h3>
                    <p>Outils d'édition basiques : coupe, filtre, ajout de musique, sous-titres automatiques et miniatures personnalisées.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-simple"></i>
                    </div>
                    <h3>Analytique avancée</h3>
                    <p>Suivez vos performances : vues, temps de visionnage, taux de rétention, données démographiques de votre audience.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3>Monétisation</h3>
                    <p>Gagnez de l'argent avec vos vidéos via la publicité, les dons de fans et les partenariats exclusifs.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Communauté engagée</h3>
                    <p>Interagissez avec vos abonnés via commentaires, likes et live streaming. Créez une communauté fidèle.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Multi-plateforme</h3>
                    <p>Accédez à votre tableau de bord depuis mobile, tablette ou ordinateur. Gérez votre chaîne où que vous soyez.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS SECTION --}}
    <section class="how-it-works">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Guide simple</span>
                <h2 class="section-title">Comment <span class="gradient-text">créer votre chaîne</span> en 4 étapes</h2>
                <p class="section-subtitle">Un processus rapide et intuitif pour lancer votre aventure de créateur</p>
            </div>
            <div class="steps-container">
                <div class="step-item">
                    <div class="step-number">01</div>
                    <div class="step-icon"><i class="fas fa-user-plus"></i></div>
                    <h3>Inscription gratuite</h3>
                    <p>Créez votre compte créateur en moins de 2 minutes. Aucune information bancaire requise pour démarrer.</p>
                </div>
                <div class="step-arrow"><i class="fas fa-arrow-right"></i></div>
                <div class="step-item">
                    <div class="step-number">02</div>
                    <div class="step-icon"><i class="fas fa-palette"></i></div>
                    <h3>Personnalisez votre chaîne</h3>
                    <p>Choisissez votre nom, ajoutez un logo, une bannière et créez votre identité visuelle unique.</p>
                </div>
                <div class="step-arrow"><i class="fas fa-arrow-right"></i></div>
                <div class="step-item">
                    <div class="step-number">03</div>
                    <div class="step-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                    <h3>Publiez votre première vidéo</h3>
                    <p>Upload, édition, ajout de métadonnées et publication. Votre contenu est en ligne en quelques minutes.</p>
                </div>
                <div class="step-arrow"><i class="fas fa-arrow-right"></i></div>
                <div class="step-item">
                    <div class="step-number">04</div>
                    <div class="step-icon"><i class="fas fa-chart-line"></i></div>
                    <h3>Développez votre audience</h3>
                    <p>Analysez vos performances, interagissez avec votre communauté et optimisez votre stratégie.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- BENEFITS SECTION --}}
    <section class="creator-benefits">
        <div class="container">
            <div class="benefits-wrapper">
                <div class="benefits-content">
                    <span class="section-tag">Pourquoi nous choisir</span>
                    <h2>Des avantages exclusifs pour <span class="gradient-text">les créateurs</span></h2>
                    <div class="benefits-list">
                        <div class="benefit-item">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h4>100% Gratuit</h4>
                                <p>Création de chaîne et upload illimité sans frais cachés.</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h4>Stockage illimité</h4>
                                <p>Espace de stockage sans limite pour toutes vos vidéos.</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h4>Support prioritaire</h4>
                                <p>Assistance dédiée 24/7 pour les créateurs certifiés.</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h4>Programme partenaire</h4>
                                <p>Accédez à des opportunités de collaboration exclusive.</p>
                            </div>
                        </div>
                    </div>
                    <button class="btn-primary">Devenir créateur</button>
                </div>
                <div class="benefits-image">
                    <div class="image-wrapper">
                        <i class="fas fa-chalkboard-user"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS SECTION --}}
    <section class="creator-testimonials">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Ils ont choisi MyTube</span>
                <h2 class="section-title">Ce que nos <span class="gradient-text">créateurs</span> disent</h2>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-avatar">
                        <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Marie Dubois">
                    </div>
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left"></i>
                        <p>Grâce à MyTube, j'ai pu partager mes voyages à travers le Québec et bâtir une communauté incroyable de passionnés. La plateforme est intuitive et le support est réactif.</p>
                        <h4>Marie Dubois</h4>
                        <span>35K abonnés | Voyage & Découverte</span>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-avatar">
                        <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Jean Tremblay">
                    </div>
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left"></i>
                        <p>Je suis passé de zéro à 50 000 vues par mois en seulement 6 mois. Les outils d'analytique m'ont permis d'optimiser mon contenu et de fidéliser mon audience.</p>
                        <h4>Jean Tremblay</h4>
                        <span>50K abonnés | Food & Culture</span>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-avatar">
                        <img src="https://randomuser.me/api/portraits/women/3.jpg" alt="Sophie Bernard">
                    </div>
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left"></i>
                        <p>La monétisation est simple et transparente. J'ai pu transformer ma passion en revenu complémentaire. Je recommande MyTube à tous les créateurs!</p>
                        <h4>Sophie Bernard</h4>
                        <span>120K abonnés | Lifestyle</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ SECTION --}}
    <section class="channel-faq">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Questions fréquentes</span>
                <h2 class="section-title">Tout ce que vous devez <span class="gradient-text">savoir</span></h2>
            </div>
            <div class="faq-grid">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Combien coûte la création d'une chaîne ?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>La création d'une chaîne est totalement gratuite. Vous pouvez uploader un nombre illimité de vidéos sans frais. La monétisation est optionnelle et vous pouvez en bénéficier dès que vous atteignez 1000 abonnés.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Quels formats de vidéo sont acceptés ?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Nous acceptons tous les formats courants : MP4, MOV, AVI, WebM, MKV. La taille maximale par vidéo est de 10 Go. Nous recommandons le format MP4 pour une qualité optimale.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Comment puis-je monétiser mes vidéos ?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>La monétisation est activée automatiquement pour les chaînes éligibles (1000+ abonnés et 4000+ heures de visionnage). Vous pouvez gagner de l'argent via la publicité, les super chats, les abonnements et les dons de fans.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Puis-je importer mes vidéos YouTube ?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Oui, nous proposons un outil d'importation automatique depuis YouTube. Il vous suffit de fournir l'URL de votre vidéo YouTube et nous la transférons sur votre chaîne MyTube.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Y a-t-il une limite de stockage ?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Non, le stockage est illimité pour tous les créateurs. Vous pouvez uploader autant de vidéos que vous le souhaitez, sans aucune restriction.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Comment promouvoir ma chaîne ?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Nous mettons à votre disposition des outils de promotion : partage automatique sur les réseaux sociaux, référencement SEO optimisé, et mise en avant dans nos playlists éditoriales pour les meilleurs contenus.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FINAL CTA SECTION --}}
    <section class="final-cta">
        <div class="container">
            <div class="cta-wrapper">
                <h2>Prêt à lancer votre chaîne vidéo ?</h2>
                <p>Rejoignez une communauté dynamique de créateurs et partagez votre passion avec le monde entier.</p>
                <div class="cta-buttons">
                    <button class="btn-primary btn-large">
                        <i class="fas fa-rocket"></i>
                        Créer ma chaîne maintenant
                    </button>
                    <button class="btn-outline btn-large">
                        <i class="fas fa-calendar-alt"></i>
                        Planifier une démo
                    </button>
                </div>
                <p class="cta-note">Aucune carte de crédit requise. Commencez gratuitement.</p>
            </div>
        </div>
    </section>
    </main>

    {{-- Modal vidéo réutilisable pour toute la plateforme --}}
    @include('components.VideoModal')
    
    @include('components.front.call-action')
    @include('chat.index')
    @include('welcome-home.components.ButtonTop')
    @include('welcome-home.components.Footer')

    <script>
        // ============================================
        // VIDEO PLAYER SCRIPT
        // ============================================
        const video = document.getElementById('mainVideoPlayer');
        const playPauseBtn = document.getElementById('playPauseBtn');
        const playIcon = document.querySelector('.play-icon');
        const pauseIcon = document.querySelector('.pause-icon');
        const progressBar = document.getElementById('progressBar');
        const progressFilled = document.getElementById('progressFilled');
        const timeDisplay = document.getElementById('timeDisplay');
        const volumeBtn = document.getElementById('volumeBtn');
        const volumeOnIcon = document.querySelector('.volume-on-icon');
        const volumeOffIcon = document.querySelector('.volume-off-icon');
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        const mediaCounter = document.getElementById('mediaCounter');
        const playlistItems = document.querySelectorAll('.video-player-v2-playlist-item');
        const videoTitle = document.getElementById('videoTitle');
        const videoDescription = document.getElementById('videoDescription');

        let currentIndex = 0;
        let isPlaying = false;

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }

        function updateProgress() {
            const percent = (video.currentTime / video.duration) * 100;
            progressFilled.style.width = `${percent}%`;
            timeDisplay.textContent = `${formatTime(video.currentTime)} / ${formatTime(video.duration)}`;
        }

        function loadVideo(index) {
            const item = playlistItems[index];
            const src = item.dataset.src;
            const title = item.dataset.title;
            const description = item.dataset.description;
            
            video.src = src;
            videoTitle.textContent = title;
            videoDescription.textContent = description;
            mediaCounter.textContent = `${index + 1} / ${playlistItems.length}`;
            
            playlistItems.forEach((li, i) => {
                if (i === index) {
                    li.classList.add('active');
                } else {
                    li.classList.remove('active');
                }
            });
            
            video.load();
            video.play();
            isPlaying = true;
            playIcon.style.display = 'none';
            pauseIcon.style.display = 'block';
        }

        playPauseBtn.addEventListener('click', () => {
            if (isPlaying) {
                video.pause();
                playIcon.style.display = 'block';
                pauseIcon.style.display = 'none';
                isPlaying = false;
            } else {
                video.play();
                playIcon.style.display = 'none';
                pauseIcon.style.display = 'block';
                isPlaying = true;
            }
        });

        video.addEventListener('timeupdate', updateProgress);
        video.addEventListener('ended', () => {
            currentIndex = (currentIndex + 1) % playlistItems.length;
            loadVideo(currentIndex);
        });

        progressBar.addEventListener('click', (e) => {
            const rect = progressBar.getBoundingClientRect();
            const percent = (e.clientX - rect.left) / rect.width;
            video.currentTime = percent * video.duration;
        });

        volumeBtn.addEventListener('click', () => {
            if (video.muted) {
                video.muted = false;
                volumeOnIcon.style.display = 'block';
                volumeOffIcon.style.display = 'none';
            } else {
                video.muted = true;
                volumeOnIcon.style.display = 'none';
                volumeOffIcon.style.display = 'block';
            }
        });

        fullscreenBtn.addEventListener('click', () => {
            if (video.requestFullscreen) {
                video.requestFullscreen();
            }
        });

        playlistItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                currentIndex = index;
                loadVideo(currentIndex);
            });
        });

        // ============================================
        // FAQ ACCORDION
        // ============================================
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.parentElement;
                faqItem.classList.toggle('active');
            });
        });

        // ============================================
        // BUTTON ACTIONS
        // ============================================
        document.getElementById('uploadVideoBtn')?.addEventListener('click', () => {
            alert('Fonctionnalité d\'upload de vidéo - Bientôt disponible!');
        });

        document.getElementById('learnMoreBtn')?.addEventListener('click', () => {
            document.querySelector('.create-channel-hero')?.scrollIntoView({ behavior: 'smooth' });
        });

        document.getElementById('startChannelBtn')?.addEventListener('click', () => {
            alert('Redirection vers la page de création de chaîne!');
        });

        document.getElementById('learnMoreChannelBtn')?.addEventListener('click', () => {
            document.querySelector('.how-it-works')?.scrollIntoView({ behavior: 'smooth' });
        });

        // Smooth scroll for all anchor links
        document.querySelectorAll('button[data-scroll]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const target = document.querySelector(btn.dataset.scroll);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
<script src="{{ asset('js/welcome/carousel.js') }}"></script>
    <script src="{{ asset('js/welcome/navigation.js') }}"></script>
    {{-- Charger le service API pour les menus EN PREMIER --}}
    <script src="{{ asset('js/welcome/menu-api-service.js') }}"></script>
    {{-- Charger le service API pour le mega menu destinations --}}
    <script src="{{ asset('js/welcome/mega-menu-service.js') }}"></script>
    {{-- Charger le menu vertical dynamique --}}
    <script src="{{ asset('js/welcome/vertical-menu-dynamic.js') }}"></script>
    {{-- Charger le contrôleur du menu vertical (gestion accordéon et vidéos) --}}
    <script src="{{ asset('js/welcome/vertical-menu.js') }}"></script>
    {{-- Charger le mega menu Destinations pour le menu vertical --}}
    <script src="{{ asset('js/welcome/vertical-destinations-mega.js') }}"></script>
    <script src="{{ asset('js/welcome/mega-menu.js') }}"></script>
    <script src="{{ asset('js/welcome/destinations-mega-menu.js') }}"></script>
    <script src="{{ asset('js/welcome/destinations-search.js') }}"></script>
    <script src="{{ asset('js/welcome/search-bar.js') }}"></script>
    {{-- Charger le service API pour la carte interactive --}}
    <script src="{{ asset('js/welcome/map-api-service.js') }}"></script>
    <script src="{{ asset('js/welcome/interactive-map-dynamic.js') }}"></script>
    {{-- Charger video-modal.js EN PREMIER car les autres composants en dépendent --}}
    <script src="{{ asset('js/video-modal.js') }}"></script>
    <script src="{{ asset('js/welcome/viewing-carousel.js') }}"></script>
    <script src="{{ asset('js/welcome/videos-dropdown.js') }}"></script>
    <script src="{{ asset('js/welcome/slideshows.js') }}"></script>
    <script src="{{ asset('js/welcome/video-player.js') }}"></script>
    <script src="{{ asset('js/welcome/events-vedette.js') }}"></script>
</html>


