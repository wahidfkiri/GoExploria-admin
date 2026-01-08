<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoExploria - Tourisme & Affaires Québec</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1a5f7a;
            --secondary-color: #57cc99;
            --accent-color: #ff9a3c;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
            --text-color: #333;
            --border-radius: 8px;
            --box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
        }
        
        /* Header avec informations en temps réel */
        .info-header {
            background-color: var(--dark-color);
            color: white;
            padding: 8px 0;
            font-size: 0.85rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .info-items {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            align-items: center;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            margin-right: 20px;
            padding: 3px 0;
            transition: var(--transition);
        }
        
        .info-item:hover {
            color: var(--accent-color);
        }
        
        .info-icon {
            margin-right: 6px;
            font-size: 0.9rem;
            color: var(--secondary-color);
        }
        
        .info-value {
            font-weight: 500;
        }
        
        .info-up {
            color: #57cc99;
            font-weight: 600;
        }
        
        .info-down {
            color: #ff6b6b;
            font-weight: 600;
        }
        
        /* Top Bar */
        .top-bar {
            background-color: #1c2836;
            color: white;
            padding: 8px 0;
            font-size: 0.9rem;
        }
        
        .top-bar a {
            color: white;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .top-bar a:hover {
            color: var(--accent-color);
        }
        
        .contact-link {
            margin-right: 15px;
            display: inline-block;
        }
        
        .social-icons a {
            color: white;
            margin-left: 10px;
            font-size: 1.1rem;
            transition: var(--transition);
        }
        
        .social-icons a:hover {
            color: var(--accent-color);
            transform: translateY(-2px);
        }
        
        /* Main Navigation */
        .main-navbar {
            background-color: white;
            box-shadow: var(--box-shadow);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        
        .navbar-brand {
            padding: 0;
        }
        
        .site-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .logo-img {
            height: 50px;
            margin-right: 10px;
        }
        
        .logo-text {
            display: flex;
            flex-direction: column;
        }
        
        .logo-title {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color);
            line-height: 1;
        }
        
        .logo-subtitle {
            font-size: 0.85rem;
            color: var(--accent-color);
            font-weight: 500;
            letter-spacing: 1px;
        }
        
        .nav-link {
            color: var(--dark-color) !important;
            font-weight: 500;
            padding: 20px 15px !important;
            position: relative;
            transition: var(--transition);
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            background: var(--secondary-color);
            bottom: 0;
            left: 15px;
            transition: var(--transition);
        }
        
        .nav-link:hover:after, .nav-link.active:after {
            width: calc(100% - 30px);
        }
        
        .special-buttons .btn {
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            margin-left: 10px;
            display: inline-flex;
            align-items: center;
            transition: var(--transition);
        }
        
        .special-buttons .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .special-buttons .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .special-buttons .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .btn-icon {
            margin-right: 8px;
            font-size: 1.2rem;
        }
        
        /* Mega Menu Slider amélioré */
        .mega-menu-section {
            padding: 30px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .mega-menu-title {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary-color);
            font-size: 1.8rem;
            font-weight: 700;
            position: relative;
            padding-bottom: 15px;
        }
        
        .mega-menu-title:after {
            content: '';
            position: absolute;
            width: 80px;
            height: 4px;
            background: var(--secondary-color);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .mega-menu-slider {
            position: relative;
            overflow: hidden;
            padding: 10px 0;
        }
        
        .mega-menu-cards {
            display: flex;
            transition: transform 0.5s ease;
            gap: 20px;
            padding: 10px 0;
        }
        
        .mega-menu-card {
            flex: 0 0 calc(20% - 20px);
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            cursor: pointer;
            transform: scale(0.95);
            opacity: 0.9;
        }
        
        .mega-menu-card:hover {
            transform: translateY(-10px) scale(1);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
            opacity: 1;
            z-index: 10;
        }
        
        .mega-menu-card-img {
            height: 160px;
            width: 100%;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .mega-menu-card:hover .mega-menu-card-img {
            transform: scale(1.05);
        }
        
        .mega-menu-card-content {
            padding: 20px;
            transition: var(--transition);
        }
        
        .mega-menu-card-title {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-bottom: 8px;
            font-weight: 700;
        }
        
        .mega-menu-card-desc {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.5;
        }
        
        /* Region List on Hover */
        .region-list-container {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            padding: 25px;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.4s ease;
        }
        
        .mega-menu-slider:hover .region-list-container {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .region-list-title {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--secondary-color);
            display: inline-block;
        }
        
        .region-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
        }
        
        .region-list-item {
            padding: 12px 15px;
            background: #f8f9fa;
            border-radius: 6px;
            transition: var(--transition);
            display: flex;
            align-items: center;
        }
        
        .region-list-item:hover {
            background: var(--primary-color);
            color: white;
            transform: translateX(5px);
        }
        
        .region-list-item:hover .region-name {
            color: white;
        }
        
        .region-flag {
            width: 30px;
            height: 20px;
            object-fit: cover;
            border-radius: 3px;
            margin-right: 12px;
        }
        
        .region-name {
            font-weight: 600;
            color: var(--dark-color);
            flex-grow: 1;
        }
        
        .region-details {
            font-size: 0.85rem;
            color: #777;
        }
        
        .region-list-item:hover .region-details {
            color: #ddd;
        }
        
        .slider-nav {
            display: flex;
            justify-content: center;
            margin-top: 25px;
            gap: 15px;
        }
        
        .slider-nav-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1.2rem;
        }
        
        .slider-nav-btn:hover {
            background-color: var(--dark-color);
            transform: scale(1.1);
        }
        
        .slider-nav-btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        
        .slider-dots {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        
        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #ddd;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .slider-dot.active {
            background-color: var(--primary-color);
            transform: scale(1.3);
        }
        
        /* Search Bar */
        .search-container {
            background-color: #f1f8ff;
            padding: 20px 0;
            border-bottom: 1px solid #dee2e6;
        }
        
        .search-box {
            max-width: 700px;
            margin: 0 auto;
        }
        
        .search-box input {
            border-radius: 50px 0 0 50px;
            border: 1px solid #ddd;
            padding: 15px 25px;
            font-size: 1.1rem;
        }
        
        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(26, 95, 122, 0.25);
        }
        
        .search-box button {
            border-radius: 0 50px 50px 0;
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0 30px;
            font-size: 1.1rem;
        }
        
        /* Hero Carousel */
        .hero-carousel {
            margin-top: 20px;
        }
        
        .carousel-item {
            height: 550px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .carousel-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.7));
        }
        
        .carousel-caption {
            bottom: 120px;
            text-align: left;
            max-width: 800px;
            margin: 0 auto;
            left: 0;
            right: 0;
        }
        
        .carousel-caption h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
        }
        
        .carousel-caption p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.7);
        }
        
        .carousel-caption .btn {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            border-radius: 50px;
            padding: 15px 35px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
        }
        
        .carousel-caption .btn:hover {
            background-color: #e88b2a;
            border-color: #e88b2a;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        /* Categories Section */
        .categories-section {
            padding: 80px 0;
            background-color: var(--light-color);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 20px;
            font-size: 2.2rem;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            width: 100px;
            height: 5px;
            background: var(--secondary-color);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .category-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            height: 100%;
            margin-bottom: 30px;
        }
        
        .category-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .category-img {
            height: 220px;
            background-size: cover;
            background-position: center;
            transition: var(--transition);
        }
        
        .category-card:hover .category-img {
            transform: scale(1.05);
        }
        
        .category-content {
            padding: 25px;
        }
        
        .category-title {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 1.4rem;
        }
        
        .category-link {
            color: var(--accent-color);
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
            transition: var(--transition);
        }
        
        .category-link:hover {
            color: var(--primary-color);
            transform: translateX(8px);
        }
        
        /* Featured Companies */
        .featured-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }
        
        .company-list {
            list-style: none;
            padding: 0;
        }
        
        .company-list li {
            padding: 18px 0;
            border-bottom: 1px solid #eee;
            transition: var(--transition);
        }
        
        .company-list li:hover {
            background-color: #f8f9fa;
            padding-left: 15px;
            border-radius: 6px;
        }
        
        .company-list li:last-child {
            border-bottom: none;
        }
        
        .company-list a {
            color: var(--primary-color);
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
            font-size: 1.1rem;
        }
        
        .company-list a:hover {
            color: var(--accent-color);
        }
        
        .company-list .activity {
            color: #777;
            font-size: 0.95rem;
            margin-left: 10px;
        }
        
        /* Gallery Section */
        .gallery-section {
            padding: 80px 0;
            background-color: var(--light-color);
        }
        
        .media-card {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
            transition: var(--transition);
            background: white;
        }
        
        .media-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .media-img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .media-card:hover .media-img {
            transform: scale(1.05);
        }
        
        .media-content {
            padding: 20px;
        }
        
        .media-title {
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-bottom: 8px;
            font-weight: 700;
        }
        
        .media-description {
            color: #666;
            font-size: 0.95rem;
        }
        
        /* Welcome Section */
        .welcome-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            position: relative;
            overflow: hidden;
        }
        
        .welcome-section:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: cover;
        }
        
        .welcome-content {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        .welcome-content h1 {
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 2.5rem;
        }
        
        .welcome-content p {
            font-size: 1.2rem;
            margin-bottom: 25px;
        }
        
        /* Footer */
        .main-footer {
            background-color: var(--dark-color);
            color: white;
            padding: 80px 0 30px;
        }
        
        .footer-logo {
            height: 70px;
            margin-bottom: 25px;
        }
        
        .footer-title {
            color: white;
            font-size: 1.3rem;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--accent-color);
            display: inline-block;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: #ddd;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .footer-links a:hover {
            color: var(--accent-color);
            padding-left: 8px;
        }
        
        .copyright {
            text-align: center;
            padding-top: 40px;
            margin-top: 40px;
            border-top: 1px solid #444;
            color: #aaa;
            font-size: 0.95rem;
        }
        
        /* Animation pour le défilement automatique */
        @keyframes autoScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-100% - 20px)); }
        }
        
        .mega-menu-cards.auto-scroll {
            animation: autoScroll 30s linear infinite;
        }
        
        .mega-menu-cards.auto-scroll:hover {
            animation-play-state: paused;
        }
        
        /* Responsive Styles */
        @media (max-width: 1200px) {
            .mega-menu-card {
                flex: 0 0 calc(25% - 20px);
            }
            
            .region-list {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
        
        @media (max-width: 992px) {
            .mega-menu-card {
                flex: 0 0 calc(33.333% - 20px);
            }
            
            .carousel-item {
                height: 450px;
            }
            
            .carousel-caption h1 {
                font-size: 2.5rem;
            }
            
            .carousel-caption {
                bottom: 80px;
            }
            
            .nav-link {
                padding: 15px 12px !important;
            }
            
            .section-title {
                font-size: 1.9rem;
            }
            
            .info-items {
                justify-content: center;
            }
            
            .info-item {
                margin: 5px 15px;
            }
        }
        
        @media (max-width: 768px) {
            .mega-menu-card {
                flex: 0 0 calc(50% - 20px);
            }
            
            .mega-menu-title {
                font-size: 1.5rem;
            }
            
            .top-bar .d-flex {
                flex-direction: column;
                text-align: center;
            }
            
            .contact-info {
                margin-bottom: 10px;
            }
            
            .carousel-item {
                height: 400px;
            }
            
            .carousel-caption h1 {
                font-size: 2rem;
            }
            
            .carousel-caption p {
                font-size: 1.1rem;
            }
            
            .special-buttons {
                margin-top: 15px;
                justify-content: center;
            }
            
            .categories-section, .featured-section, .gallery-section, .welcome-section {
                padding: 60px 0;
            }
            
            .region-list-container {
                display: none;
            }
        }
        
        @media (max-width: 576px) {
            .mega-menu-card {
                flex: 0 0 calc(100% - 20px);
            }
            
            .carousel-item {
                height: 350px;
            }
            
            .carousel-caption {
                bottom: 50px;
            }
            
            .carousel-caption h1 {
                font-size: 1.7rem;
            }
            
            .logo-title {
                font-size: 1.2rem;
            }
            
            .nav-link {
                padding: 12px 10px !important;
                font-size: 0.9rem;
            }
            
            .section-title {
                font-size: 1.7rem;
            }
            
            .info-header {
                font-size: 0.75rem;
            }
            
            .info-item {
                margin: 3px 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Header avec informations en temps réel -->
    <header class="info-header">
        <div class="container">
            <div class="info-items">
                <div class="info-item">
                    <i class="fas fa-chart-line info-icon"></i>
                    <span class="info-label">Bourse TSX: </span>
                    <span class="info-value ms-1">21,450.12</span>
                    <span class="info-up ms-1">+1.2%</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-cloud-sun info-icon"></i>
                    <span class="info-label">Météo QC: </span>
                    <span class="info-value ms-1">-5°C</span>
                    <span class="info-details ms-1">Ensoleillé</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-road info-icon"></i>
                    <span class="info-label">Routes: </span>
                    <span class="info-value ms-1">Majoritairement dégagées</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-broadcast-tower info-icon"></i>
                    <span class="info-label">Message aux voyageurs: </span>
                    <span class="info-value ms-1">Pas d'alerte en vigueur</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-charging-station info-icon"></i>
                    <span class="info-label">Bornes électriques: </span>
                    <span class="info-value ms-1">85% disponibles</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="contact-info">
                    <a href="tel:4185257748" class="contact-link">
                        <i class="fas fa-phone-alt me-1"></i> (418) 525-7748
                    </a>
                    <a href="mailto:infogoexploria@gmail.com" class="contact-link">
                        <i class="fas fa-envelope me-1"></i> infogoexploria@gmail.com
                    </a>
                </div>
                <div class="social-icons">
                    <a href="https://www.youtube.com/user/explorezlemonde/videos?view_as=subscriber" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light main-navbar">
        <div class="container">
            <a class="navbar-brand" href="/fr/">
                <div class="site-logo">
                    <img src="https://www.goexploria.com/images/logo-go-exploria-qc-3.png" alt="GoExploria" class="logo-img">
                    <div class="logo-text">
                        <span class="logo-title">GoExploria</span>
                        <span class="logo-subtitle">Affaires</span>
                    </div>
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="a_tourisme">GO Explorez</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="a_business">GO Business</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="a_local">GO Local</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="a_prime">GO Prime Time</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="a_videos">GO Web TV</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="a_photos">GO Photos</a>
                    </li>
                </ul>
                
                <div class="special-buttons d-flex">
                    <a href="https://www.goexploria.com/company/68620/go-exploria-plans-de-relance" class="btn btn-primary">
                        <i class="fas fa-seedling btn-icon"></i> Plans de relance
                    </a>
                    <a href="https://www.goexploria.com/company/68619/go-exploria-services-web" class="btn btn-secondary">
                        <i class="fas fa-globe btn-icon"></i> Services web
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Search Bar -->
    <div class="search-container">
        <div class="container">
            <div class="search-box">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Recherchez une destination, une entreprise ou une activité...">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mega Menu Slider amélioré -->
    <section class="mega-menu-section">
        <div class="container">
            <h2 class="mega-menu-title">Explorez les Régions du Canada</h2>
            
            <div class="mega-menu-slider">
                <div class="mega-menu-cards auto-scroll" id="megaMenuCards">
                    <!-- Les cartes seront ajoutées par JavaScript -->
                </div>
                
                <div class="region-list-container" id="regionListContainer">
                    <h3 class="region-list-title">Toutes les régions du Canada</h3>
                    <div class="region-list" id="regionList">
                        <!-- La liste des régions sera ajoutée par JavaScript -->
                    </div>
                </div>
                
                <div class="slider-nav">
                    <button class="slider-nav-btn" id="prevBtn" aria-label="Précédent">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="slider-nav-btn" id="nextBtn" aria-label="Suivant">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                
                <div class="slider-dots" id="sliderDots">
                    <!-- Les points seront ajoutés par JavaScript -->
                </div>
            </div>
        </div>
    </section>

    <!-- Hero Carousel -->
    <section class="hero-carousel">
        <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
            </div>
            
            <div class="carousel-inner">
                <div class="carousel-item active" style="background-image: url('https://www.goexploria.com/uploads/galleries/336/voyage-quebec-canada.jpg');">
                    <div class="carousel-caption">
                        <h1>VOYAGE MOTONEIGE QUÉBEC-CANADA</h1>
                        <p>Découvrez les plus belles aventures hivernales au Québec</p>
                        <a href="https://www.goexploria.com/company/78/location-motoneige-charlevoix" target="_blank" class="btn btn-primary">En savoir plus</a>
                    </div>
                </div>
                
                <div class="carousel-item" style="background-image: url('https://www.goexploria.com/uploads/galleries/336/go-exploria-baie-st-paul.jpg');">
                    <div class="carousel-caption">
                        <h1>GO EXPLORIA BAIE-SAINT-PAUL</h1>
                        <p>Explorez la région de Charlevoix et ses trésors cachés</p>
                        <a href="https://www.goexploria.com/location/na/canada/quebec/charlevoix/baie-saint-paul" target="_blank" class="btn btn-primary">En savoir plus</a>
                    </div>
                </div>
                
                <div class="carousel-item" style="background-image: url('https://www.goexploria.com/uploads/galleries/336/quebec-france.jpg');">
                    <div class="carousel-caption">
                        <h1>DÉVELOPPEMENT MARCHÉ FRANÇAIS</h1>
                        <p>Connectez avec le marché touristique français</p>
                        <a href="https://www.goexploria.com/fr/location/eu/france" target="_blank" class="btn btn-primary">En savoir plus</a>
                    </div>
                </div>
            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="container">
            <div class="welcome-content">
                <h1 class="text-center mb-4">Bienvenue sur GO EXPLORIA</h1>
                <p>C'est votre site web d'informations touristiques et pour le monde des affaires, au Québec.</p>
                <p>Notre objectif est de vous diriger vers les centres d'aventures, les activités en plein air 4 saisons et encore plus!</p>
                <p>Merci de l'utiliser et planifiez vos escapades, vos vacances, ou pour trouvez un produit ou un service.</p>
                <p class="text-center"><strong>Profitez du Québec, il est grand, il est beau et rempli d'aventures 4 saisons</strong></p>
                <div class="text-center mt-4">
                    <img src="https://www.goexploria.com/images/logo-go-exploria-qc-3.png" alt="GoExploria" style="max-width: 300px;">
                </div>
                <h3 class="text-center mt-4" style="color: var(--primary-color);">La Force Numérique au Québec</h3>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section">
        <div class="container">
            <h2 class="section-title">Explorez par catégories</h2>
            
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-img" style="background-image: url('https://www.goexploria.com/uploads/galleries/336/voyage-quebec-canada.jpg');"></div>
                        <div class="category-content">
                            <h3 class="category-title">Activités hivernales</h3>
                            <p>Découvrez les meilleures activités pour profiter de l'hiver québécois</p>
                            <a href="#" class="category-link">Explorer <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-img" style="background-image: url('https://www.goexploria.com/uploads/galleries/336/go-exploria-baie-st-paul.jpg');"></div>
                        <div class="category-content">
                            <h3 class="category-title">Agrotourisme et terroir</h3>
                            <p>Dégustez les produits locaux et visitez nos fermes et vignobles</p>
                            <a href="#" class="category-link">Explorer <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-img" style="background-image: url('https://www.goexploria.com/uploads/galleries/336/restaurant-la-promenade-go-exploria.jpg');"></div>
                        <div class="category-content">
                            <h3 class="category-title">Restaurants et alimentation</h3>
                            <p>Découvrez les meilleures tables et produits du Québec</p>
                            <a href="#" class="category-link">Explorer <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-img" style="background-image: url('https://www.goexploria.com/uploads/galleries/336/galerie-d-art-charlevoix-qc.jpg');"></div>
                        <div class="category-content">
                            <h3 class="category-title">Art et culture</h3>
                            <p>Explorez la riche scène culturelle et artistique du Québec</p>
                            <a href="#" class="category-link">Explorer <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Companies -->
    <section class="featured-section">
        <div class="container">
            <h2 class="section-title">Établissements en vedette</h2>
            
            <div class="row">
                <div class="col-lg-8">
                    <ul class="company-list">
                        <li>
                            <a href="https://www.goexploria.com/company/147257/poissonnerie-unipeche-mdm">Poissonnerie Unipêche MDM</a>
                            <span class="activity"> - Boutiques du terroir</span>
                        </li>
                        <li>
                            <a href="https://www.goexploria.com/company/147256/yourtes-et-cabanes-chez-chalets-lanaudiere">Yourtes et Cabanes chez Chalets Lanaudière</a>
                            <span class="activity"> - Traîneau à chiens</span>
                        </li>
                        <li>
                            <a href="https://www.goexploria.com/company/147255/restaurant-tonino-quebec">Restaurant Tonino Québec</a>
                            <span class="activity"> - Italiens</span>
                        </li>
                        <li>
                            <a href="https://www.goexploria.com/company/147254/chalets-a-louer-la-malbaie-grand-fonds">CHALETS A LOUER La Malbaie Grand-Fonds</a>
                            <span class="activity"> - Location motoneige</span>
                        </li>
                        <li>
                            <a href="https://www.goexploria.com/company/147253/chalet-des-grands-duc">CHALET DES GRANDS DUC</a>
                            <span class="activity"> - Traîneau à chiens</span>
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Besoin d'aide ?</h5>
                            <p class="card-text">Contactez-nous pour planifier votre prochaine aventure ou pour ajouter votre entreprise sur GoExploria.</p>
                            <a href="tel:4185257748" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-phone me-2"></i> (418) 525-7748
                            </a>
                            <a href="mailto:infogoexploria@gmail.com" class="btn btn-secondary w-100">
                                <i class="fas fa-envelope me-2"></i> Nous écrire
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section">
        <div class="container">
            <h2 class="section-title">Galeries en vedette</h2>
            
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="media-card">
                        <img src="https://www.goexploria.com/uploads/galleries/710/location-motoneige-grand-fonds.jpg" alt="Location de motoneige" class="media-img">
                        <div class="media-content">
                            <h3 class="media-title">Location-de-motoneige-quebec</h3>
                            <p class="media-description">LOCATION DE MOTONEIGE-MONT-STE-ANNE</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="media-card">
                        <img src="https://www.goexploria.com/uploads/galleries/2668/boulangerie-charlevoix.jpg" alt="Boulangerie Bouchard" class="media-img">
                        <div class="media-content">
                            <h3 class="media-title">Boulangerie Bouchard</h3>
                            <p class="media-description">Boulangerie Bouchard - L'Isle-aux-Coudres</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="media-card">
                        <img src="https://www.goexploria.com/uploads/galleries/2645/kit-chalet-bois-rond.jpg" alt="Kit chalet bois rond" class="media-img">
                        <div class="media-content">
                            <h3 class="media-title">KIT Chalet bois rond</h3>
                            <p class="media-description">Construisez votre propre chalet en bois rond</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <img src="https://www.goexploria.com/images/logo-go-exploria-qc-3.png" alt="GoExploria" class="footer-logo">
                    <p>Votre guide touristique et d'affaires pour le Québec. Découvrez, explorez, vivez le Québec comme jamais auparavant.</p>
                    <div class="social-icons mt-3">
                        <a href="https://www.youtube.com/user/explorezlemonde/videos?view_as=subscriber" target="_blank">
                            <i class="fab fa-youtube fa-2x"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h4 class="footer-title">Liens rapides</h4>
                    <ul class="footer-links">
                        <li><a href="#">GO Explorez</a></li>
                        <li><a href="#">GO Business</a></li>
                        <li><a href="#">GO Local</a></li>
                        <li><a href="#">GO Prime Time</a></li>
                        <li><a href="#">GO Web TV</a></li>
                        <li><a href="#">GO Photos</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h4 class="footer-title">Contactez-nous</h4>
                    <ul class="footer-links">
                        <li><i class="fas fa-phone me-2"></i> (418) 525-7748</li>
                        <li><i class="fas fa-envelope me-2"></i> infogoexploria@gmail.com</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i> Québec, Canada</li>
                    </ul>
                    <div class="mt-4">
                        <a href="https://www.goexploria.com/company/68620/go-exploria-plans-de-relance" class="btn btn-outline-light me-2">Plans de relance</a>
                        <a href="https://www.goexploria.com/company/68619/go-exploria-services-web" class="btn btn-accent">Services web</a>
                    </div>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 GoExploria. Tous droits réservés. | <a href="#" class="text-white">Politique de confidentialité</a> | <a href="#" class="text-white">Conditions d'utilisation</a></p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Données pour le méga menu slider
        const canadianRegions = [
            {
                id: 1,
                title: "Québec",
                description: "Province francophone avec une riche culture et histoire",
                image: "https://images.unsplash.com/photo-1605058015762-7627e9b4b8c5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                flag: "https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/Flag_of_Quebec.svg/640px-Flag_of_Quebec.svg.png",
                capital: "Québec",
                population: "8,5 millions"
            },
            {
                id: 2,
                title: "Ontario",
                description: "Province la plus peuplée avec Toronto comme capitale économique",
                image: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                flag: "https://upload.wikimedia.org/wikipedia/commons/thumb/8/88/Flag_of_Ontario.svg/640px-Flag_of_Ontario.svg.png",
                capital: "Toronto",
                population: "14,8 millions"
            },
            {
                id: 3,
                title: "Colombie-Britannique",
                description: "Province côtière avec des montagnes spectaculaires",
                image: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                flag: "https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/Flag_of_British_Columbia.svg/640px-Flag_of_British_Columbia.svg.png",
                capital: "Victoria",
                population: "5,2 millions"
            },
            {
                id: 4,
                title: "Alberta",
                description: "Province des Rocheuses et de l'industrie pétrolière",
                image: "https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                flag: "https://upload.wikimedia.org/wikipedia/commons/thumb/f/f5/Flag_of_Alberta.svg/640px-Flag_of_Alberta.svg.png",
                capital: "Edmonton",
                population: "4,4 millions"
            },
            {
                id: 5,
                title: "Manitoba",
                description: "Province des prairies avec de nombreux lacs",
                image: "https://images.unsplash.com/photo-1582436416930-f5d21b5e1f2e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                flag: "https://upload.wikimedia.org/wikipedia/commons/thumb/c/c4/Flag_of_Manitoba.svg/640px-Flag_of_Manitoba.svg.png",
                capital: "Winnipeg",
                population: "1,4 million"
            },
            {
                id: 6,
                title: "Saskatchewan",
                description: "Province des grandes plaines et de l'agriculture",
                image: "https://images.unsplash.com/photo-1528181304800-259b08848526?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                flag: "https://upload.wikimedia.org/wikipedia/commons/thumb/b/bb/Flag_of_Saskatchewan.svg/640px-Flag_of_Saskatchewan.svg.png",
                capital: "Regina",
                population: "1,2 million"
            },
            {
                id: 7,
                title: "Nouvelle-Écosse",
                description: "Province maritime avec une riche histoire acadienne",
                image: "https://images.unsplash.com/photo-1506929562872-bb421503ef21?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                flag: "https://upload.wikimedia.org/wikipedia/commons/thumb/c/c0/Flag_of_Nova_Scotia.svg/640px-Flag_of_Nova_Scotia.svg.png",
                capital: "Halifax",
                population: "1 million"
            },
            {
                id: 8,
                title: "Nouveau-Brunswick",
                description: "Seule province officiellement bilingue du Canada",
                image: "https://images.unsplash.com/photo-1541692641319-981cc79ee10a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                flag: "https://upload.wikimedia.org/wikipedia/commons/thumb/f/fb/Flag_of_New_Brunswick.svg/640px-Flag_of_New_Brunswick.svg.png",
                capital: "Fredericton",
                population: "800 000"
            },
            {
                id: 9,
                title: "Terre-Neuve-et-Labrador",
                description: "Province la plus à l'est avec une culture unique",
                image: "https://images.unsplash.com/photo-1536152471326-642d4bb49547?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                flag: "https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/Flag_of_Newfoundland_and_Labrador.svg/640px-Flag_of_Newfoundland_and_Labrador.svg.png",
                capital: "St. John's",
                population: "520 000"
            },
            {
                id: 10,
                title: "Île-du-Prince-Édouard",
                description: "La plus petite province, connue pour ses plages rouges",
                image: "https://images.unsplash.com/photo-1590080667306-eb444a5c5c8a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                flag: "https://upload.wikimedia.org/wikipedia/commons/thumb/d/d7/Flag_of_Prince_Edward_Island.svg/640px-Flag_of_Prince_Edward_Island.svg.png",
                capital: "Charlottetown",
                population: "165 000"
            }
        ];

        // Configuration du slider
        let currentSlide = 0;
        let cardsPerView = 5;
        let totalSlides = Math.ceil(canadianRegions.length / cardsPerView);
        let autoScrollInterval;

        // Initialisation du méga menu slider
        document.addEventListener('DOMContentLoaded', function() {
            const megaMenuCards = document.getElementById('megaMenuCards');
            const regionList = document.getElementById('regionList');
            const sliderDots = document.getElementById('sliderDots');
            
            // Créer les cartes
            canadianRegions.forEach(region => {
                const card = document.createElement('div');
                card.className = 'mega-menu-card';
                card.innerHTML = `
                    <img src="${region.image}" alt="${region.title}" class="mega-menu-card-img">
                    <div class="mega-menu-card-content">
                        <h3 class="mega-menu-card-title">${region.title}</h3>
                        <p class="mega-menu-card-desc">${region.description}</p>
                    </div>
                `;
                
                // Ajouter un événement de clic
                card.addEventListener('click', function() {
                    console.log(`Clic sur la région: ${region.title}`);
                    // Ici, vous pouvez rediriger vers la page de la région
                    // window.location.href = region.link;
                });
                
                megaMenuCards.appendChild(card);
            });
            
            // Créer la liste complète des régions
            canadianRegions.forEach(region => {
                const listItem = document.createElement('div');
                listItem.className = 'region-list-item';
                listItem.innerHTML = `
                    <img src="${region.flag}" alt="${region.title}" class="region-flag">
                    <span class="region-name">${region.title}</span>
                    <span class="region-details">${region.capital} • ${region.population} hab.</span>
                `;
                
                listItem.addEventListener('click', function() {
                    console.log(`Sélection de la région: ${region.title}`);
                    // Ici, vous pouvez rediriger vers la page de la région
                    // window.location.href = region.link;
                });
                
                regionList.appendChild(listItem);
            });
            
            // Créer les points de navigation
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('div');
                dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
                dot.dataset.slide = i;
                dot.addEventListener('click', function() {
                    goToSlide(parseInt(this.dataset.slide));
                });
                sliderDots.appendChild(dot);
            }
            
            // Gestion des boutons de navigation
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            
            prevBtn.addEventListener('click', function() {
                prevSlide();
            });
            
            nextBtn.addEventListener('click', function() {
                nextSlide();
            });
            
            // Mettre à jour la visibilité des boutons
            updateNavButtons();
            
            // Démarrer le défilement automatique
            startAutoScroll();
            
            // Arrêter le défilement automatique au survol
            const megaMenuSlider = document.querySelector('.mega-menu-slider');
            megaMenuSlider.addEventListener('mouseenter', function() {
                stopAutoScroll();
            });
            
            megaMenuSlider.addEventListener('mouseleave', function() {
                startAutoScroll();
            });
            
            // Gestion du carousel principal
            const myCarousel = document.querySelector('#mainCarousel');
            const carousel = new bootstrap.Carousel(myCarousel, {
                interval: 5000,
                wrap: true
            });
            
            // Gestion des liens de navigation
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    navLinks.forEach(item => item.classList.remove('active'));
                    this.classList.add('active');
                    
                    const targetId = this.id;
                    console.log(`Navigation vers: ${targetId}`);
                    
                    if(this.getAttribute('href') === '#') {
                        e.preventDefault();
                    }
                });
            });
            
            // Animation au défilement
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.main-navbar');
                if (window.scrollY > 100) {
                    navbar.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
                } else {
                    navbar.style.boxShadow = '0 5px 15px rgba(0,0,0,0.08)';
                }
            });
            
            // Ajustement responsive du nombre de cartes par vue
            window.addEventListener('resize', function() {
                updateCardsPerView();
            });
            
            // Initialiser le nombre de cartes par vue
            updateCardsPerView();
            
            // Simuler des mises à jour des informations en temps réel
            updateLiveInfo();
        });
        
        // Fonction pour démarrer le défilement automatique
        function startAutoScroll() {
            const megaMenuCards = document.getElementById('megaMenuCards');
            megaMenuCards.classList.add('auto-scroll');
        }
        
        // Fonction pour arrêter le défilement automatique
        function stopAutoScroll() {
            const megaMenuCards = document.getElementById('megaMenuCards');
            megaMenuCards.classList.remove('auto-scroll');
        }
        
        // Fonction pour mettre à jour les informations en temps réel
        function updateLiveInfo() {
            // Simuler des changements de valeurs
            setInterval(() => {
                // Mettre à jour la bourse
                const stockElement = document.querySelector('.info-item:nth-child(1) .info-value');
                if (stockElement) {
                    const currentValue = parseFloat(stockElement.textContent.replace(',', ''));
                    const change = (Math.random() - 0.5) * 100;
                    const newValue = currentValue + change;
                    stockElement.textContent = newValue.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                    
                    // Mettre à jour la flèche
                    const directionElement = stockElement.nextElementSibling;
                    if (directionElement) {
                        if (change > 0) {
                            directionElement.textContent = '+' + change.toFixed(2) + '%';
                            directionElement.className = 'info-up ms-1';
                        } else {
                            directionElement.textContent = change.toFixed(2) + '%';
                            directionElement.className = 'info-down ms-1';
                        }
                    }
                }
                
                // Mettre à jour la température
                const tempElement = document.querySelector('.info-item:nth-child(2) .info-value');
                if (tempElement) {
                    const currentTemp = parseFloat(tempElement.textContent);
                    const change = (Math.random() - 0.5) * 2;
                    const newTemp = currentTemp + change;
                    tempElement.textContent = newTemp.toFixed(1) + '°C';
                }
                
                // Mettre à jour la disponibilité des bornes électriques
                const chargerElement = document.querySelector('.info-item:nth-child(5) .info-value');
                if (chargerElement) {
                    const currentValue = parseFloat(chargerElement.textContent);
                    const change = (Math.random() - 0.5) * 10;
                    let newValue = currentValue + change;
                    newValue = Math.max(0, Math.min(100, newValue));
                    chargerElement.textContent = newValue.toFixed(0) + '% disponibles';
                }
            }, 10000); // Mettre à jour toutes les 10 secondes
        }
        
        // Fonctions pour le slider
        function updateCardsPerView() {
            const width = window.innerWidth;
            if (width < 576) {
                cardsPerView = 1;
            } else if (width < 768) {
                cardsPerView = 2;
            } else if (width < 992) {
                cardsPerView = 3;
            } else if (width < 1200) {
                cardsPerView = 4;
            } else {
                cardsPerView = 5;
            }
            
            // Recalculer le nombre total de slides
            totalSlides = Math.ceil(canadianRegions.length / cardsPerView);
            
            // Revenir à la première slide
            currentSlide = 0;
            goToSlide(0);
        }
        
        function goToSlide(slideIndex) {
            const megaMenuCards = document.getElementById('megaMenuCards');
            const cardWidth = document.querySelector('.mega-menu-card').offsetWidth + 20; // + gap
            const translateX = -slideIndex * (cardsPerView * cardWidth);
            
            megaMenuCards.style.transform = `translateX(${translateX}px)`;
            currentSlide = slideIndex;
            
            // Mettre à jour les points actifs
            const dots = document.querySelectorAll('.slider-dot');
            dots.forEach((dot, index) => {
                if (index === slideIndex) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
            
            // Mettre à jour la visibilité des boutons
            updateNavButtons();
        }
        
        function prevSlide() {
            if (currentSlide > 0) {
                goToSlide(currentSlide - 1);
            }
        }
        
        function nextSlide() {
            if (currentSlide < totalSlides - 1) {
                goToSlide(currentSlide + 1);
            }
        }
        
        function updateNavButtons() {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            
            prevBtn.disabled = currentSlide === 0;
            nextBtn.disabled = currentSlide === totalSlides - 1;
        }
    </script>
</body>
</html>