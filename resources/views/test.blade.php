<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go Exploria Business - Plateforme de Création Digitale</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    
    <style>
        :root {
            --primary-color: #1a5f7a;
            --secondary-color: #57cc99;
            --accent-color: #ff9a3c;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
            --text-color: #333;
            --border-radius: 12px;
            --box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
            --gradient-primary: linear-gradient(135deg, #1a5f7a 0%, #2c3e50 100%);
            --gradient-secondary: linear-gradient(135deg, #57cc99 0%, #38b2ac 100%);
            --gradient-accent: linear-gradient(135deg, #ff9a3c 0%, #ff6b6b 100%);
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
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }
        
        /* Animations générales */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-15px);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease forwards;
        }
        
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
        
        .animate-pulse-slow {
            animation: pulse 3s ease-in-out infinite;
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
        
        /* Mega Menu Dropdown amélioré */
        .mega-dropdown-container {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            border-radius: 0 0 var(--border-radius) var(--border-radius);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
            padding: 30px;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-20px);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            max-height: 70vh;
            overflow-y: auto;
        }
        
        .mega-dropdown-container.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .region-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .region-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            cursor: pointer;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .region-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .region-card-img {
            height: 180px;
            width: 100%;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .region-card:hover .region-card-img {
            transform: scale(1.1);
        }
        
        .region-card-content {
            padding: 20px;
        }
        
        .region-card-title {
            font-size: 1.3rem;
            color: var(--primary-color);
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .region-card-desc {
            font-size: 0.95rem;
            color: #666;
            line-height: 1.5;
        }
        
        .region-list-all {
            background: #f8f9fa;
            border-radius: var(--border-radius);
            padding: 25px;
            margin-top: 20px;
        }
        
        .region-list-all h4 {
            color: var(--primary-color);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--secondary-color);
        }
        
        .region-columns {
            columns: 3;
            column-gap: 30px;
        }
        
        .region-list-item {
            padding: 8px 0;
            border-bottom: 1px dashed #ddd;
            transition: var(--transition);
        }
        
        .region-list-item:hover {
            color: var(--primary-color);
            transform: translateX(5px);
        }
        
        .close-mega-menu {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark-color);
            cursor: pointer;
            transition: var(--transition);
        }
        
        .close-mega-menu:hover {
            color: var(--accent-color);
            transform: rotate(90deg);
        }
        
        /* Section Hero pour création digitale */
        .modern-hero {
            padding: 100px 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            position: relative;
            overflow: hidden;
        }
        
        .modern-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
            opacity: 0.1;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            color: var(--dark-color);
            margin-bottom: 30px;
            max-width: 600px;
        }
        
        .hero-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .hero-btn {
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .hero-btn-primary {
            background: var(--gradient-primary);
            color: white;
        }
        
        .hero-btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(26, 95, 122, 0.3);
        }
        
        .hero-btn-secondary {
            background: var(--gradient-secondary);
            color: white;
        }
        
        .hero-btn-secondary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(87, 204, 153, 0.3);
        }
        
        .hero-image {
            position: relative;
            text-align: center;
        }
        
        .hero-image img {
            max-width: 100%;
            border-radius: var(--border-radius);
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            animation: float 6s ease-in-out infinite;
        }
        
        /* Section Éditeur de Site Web */
        .editor-section {
            padding: 100px 0;
            background: white;
        }
        
        .editor-preview {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            position: relative;
        }
        
        .editor-toolbar {
            background: #2c3e50;
            padding: 15px;
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .toolbar-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        
        .dot-red { background: #ff5f56; }
        .dot-yellow { background: #ffbd2e; }
        .dot-green { background: #27ca3f; }
        
        .editor-window {
            background: white;
            height: 400px;
            position: relative;
            overflow: hidden;
        }
        
        .editor-content {
            padding: 30px;
            height: 100%;
        }
        
        .editor-element {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: var(--transition);
            border-left: 4px solid var(--secondary-color);
        }
        
        .editor-element:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }
        
        /* Section Fonctionnalités */
        .features-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        .feature-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            height: 100%;
            text-align: center;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .feature-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
        }
        
        .feature-title {
            font-size: 1.4rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        /* Section Clients */
        .clients-section {
            padding: 100px 0;
            background: white;
        }
        
        .client-logo {
            padding: 20px;
            text-align: center;
            filter: grayscale(100%);
            opacity: 0.7;
            transition: var(--transition);
        }
        
        .client-logo:hover {
            filter: grayscale(0%);
            opacity: 1;
            transform: scale(1.1);
        }
        
        .client-logo img {
            max-height: 80px;
            max-width: 100%;
        }
        
        /* Section Vidéo */
        .video-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #2c3e50 0%, #1a5f7a 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .video-section::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
            opacity: 0.1;
            top: 0;
            left: 0;
        }
        
        .video-container {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        }
        
        /* Section Statistiques */
        .stats-section {
            padding: 80px 0;
            background: var(--gradient-primary);
            color: white;
        }
        
        .stat-item {
            text-align: center;
            padding: 20px;
        }
        
        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 10px;
            color: var(--accent-color);
        }
        
        .stat-label {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        /* Bouton pour activer le mega menu */
        .mega-menu-trigger {
            position: relative;
        }
        
        .mega-menu-trigger i {
            transition: var(--transition);
        }
        
        .mega-menu-trigger.active i {
            transform: rotate(180deg);
        }
        
        /* Categories Section (existante) */
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
        
        /* Featured Companies (existante) */
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
        
        /* Gallery Section (existante) */
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
        
        /* Welcome Section (existante) */
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
        
        /* Footer (existant) */
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
        
        /* Boutons avec animation */
        .btn-modern {
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.2);
            transition: var(--transition);
            z-index: -1;
        }
        
        .btn-modern:hover::before {
            left: 100%;
        }
        
        /* Swiper custom */
        .swiper {
            width: 100%;
            padding: 30px 0 50px;
        }
        
        .swiper-slide {
            background-position: center;
            background-size: cover;
            width: 300px;
            height: 400px;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }
        
        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .region-columns {
                columns: 2;
            }
            
            .hero-title {
                font-size: 3rem;
            }
        }
        
        @media (max-width: 992px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .region-columns {
                columns: 1;
            }
            
            .info-items {
                justify-content: center;
            }
            
            .info-item {
                margin: 5px 15px;
            }
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .top-bar .d-flex {
                flex-direction: column;
                text-align: center;
            }
            
            .contact-info {
                margin-bottom: 10px;
            }
            
            .hero-buttons {
                justify-content: center;
            }
            
            .special-buttons {
                margin-top: 15px;
                justify-content: center;
            }
            
            .modern-hero, .editor-section, .features-section, .clients-section, .video-section {
                padding: 60px 0;
            }
        }
        
        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.8rem;
            }
            
            .hero-btn {
                padding: 12px 25px;
                font-size: 1rem;
            }
            
            .mega-dropdown-container {
                padding: 20px 15px;
            }
            
            .info-header {
                font-size: 0.75rem;
            }
            
            .info-item {
                margin: 3px 10px;
            }
            
            .stat-number {
                font-size: 2.5rem;
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
                    <li class="nav-item mega-menu-trigger-container">
                        <a class="nav-link mega-menu-trigger" href="#regions">
                            <i class="fas fa-map-marker-alt me-1"></i>Régions Canada
                        </a>
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

    <!-- Mega Menu Dropdown pour les régions -->
    <div class="mega-dropdown-container" id="megaDropdown">
        <button class="close-mega-menu" id="closeMegaMenu">
            <i class="fas fa-times"></i>
        </button>
        
        <h3 class="section-title mb-4">Explorez les Régions du Canada</h3>
        
        <div class="region-grid" id="regionGrid">
            <!-- Les cartes régions seront ajoutées par JavaScript -->
        </div>
        
        <div class="region-list-all">
            <h4>Toutes les régions disponibles</h4>
            <div class="region-columns" id="regionColumns">
                <!-- La liste complète sera ajoutée par JavaScript -->
            </div>
        </div>
    </div>

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

    <!-- Section Hero pour création digitale -->
    <section class="modern-hero" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content animate-fade-in-up">
                        <h1 class="hero-title">Créez votre présence digitale avec Go Exploria Business</h1>
                        <p class="hero-subtitle">Notre plateforme tout-en-un vous permet de créer, gérer et optimiser votre site web avec des outils puissants d'analyse, SEO, messagerie et IA intégrée.</p>
                        <div class="hero-buttons">
                            <a href="#editor" class="hero-btn hero-btn-primary btn-modern">
                                <i class="fas fa-play-circle me-2"></i>Essayer la démo
                            </a>
                            <a href="#features" class="hero-btn hero-btn-secondary btn-modern">
                                <i class="fas fa-list-alt me-2"></i>Voir les fonctionnalités
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image">
                        <img src="https://images.unsplash.com/photo-1558655146-9f40138edfeb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1064&q=80" alt="Création de site web moderne" class="animate-float">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Éditeur de Site Web -->
    <section class="editor-section" id="editor">
        <div class="container">
            <h2 class="section-title text-center mb-5">Notre Éditeur de Site Web Intuitif</h2>
            
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="editor-preview">
                        <div class="editor-toolbar">
                            <div class="toolbar-dot dot-red"></div>
                            <div class="toolbar-dot dot-yellow"></div>
                            <div class="toolbar-dot dot-green"></div>
                            <span class="text-white ms-3">Créateur de site Go Exploria Business</span>
                        </div>
                        <div class="editor-window">
                            <div class="editor-content">
                                <div class="editor-element">
                                    <h5>En-tête personnalisable</h5>
                                    <p class="mb-0">Logo, navigation, bannière</p>
                                </div>
                                <div class="editor-element">
                                    <h5>Galerie d'images responsive</h5>
                                    <p class="mb-0">Glisser-déposer pour organiser</p>
                                </div>
                                <div class="editor-element">
                                    <h5>Section services</h5>
                                    <p class="mb-0">Présentez vos offres</p>
                                </div>
                                <div class="editor-element">
                                    <h5>Formulaire de contact intelligent</h5>
                                    <p class="mb-0">Avec gestion des leads</p>
                                </div>
                                <div class="editor-element">
                                    <h5>Intégration réseaux sociaux</h5>
                                    <p class="mb-0">Automatisée et modifiable</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ps-lg-5 mt-5 mt-lg-0">
                        <h3 class="mb-4" style="color: var(--primary-color);">Créez un site professionnel sans codage</h3>
                        <p class="mb-4">Notre éditeur visuel vous permet de créer un site web professionnel en quelques heures, sans aucune connaissance technique.</p>
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <i class="fas fa-check-circle" style="color: var(--secondary-color); font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h5>Glisser-déposer intuitif</h5>
                                <p>Organisez vos pages avec une interface simple de glisser-déposer.</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <i class="fas fa-check-circle" style="color: var(--secondary-color); font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h5>Modèles professionnels</h5>
                                <p>Choisissez parmi des centaines de modèles conçus par des experts.</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-4">
                            <div class="me-3">
                                <i class="fas fa-check-circle" style="color: var(--secondary-color); font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h5>Optimisation mobile automatique</h5>
                                <p>Votre site sera parfaitement adapté à tous les appareils.</p>
                            </div>
                        </div>
                        
                        <a href="#contact" class="hero-btn hero-btn-primary btn-modern">
                            <i class="fas fa-magic me-2"></i>Créer mon site maintenant
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Fonctionnalités -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title text-center mb-5">Fonctionnalités Complètes</h2>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">Analytics Avancés</h3>
                        <p>Suivez les performances de votre site avec des tableaux de bord détaillés et des rapports personnalisés.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="feature-title">Optimisation SEO</h3>
                        <p>Améliorez votre visibilité sur les moteurs de recherche avec nos outils SEO intégrés.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3 class="feature-title">Messagerie Intelligente</h3>
                        <p>Gérez vos communications avec un système de messagerie unifié et automatisé.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-robot"></i>
                        </div>
                        <h3 class="feature-title">Assistance IA</h3>
                        <p>Bénéficiez de l'assistance d'une IA pour la rédaction de contenu et l'optimisation.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3 class="feature-title">Gestion des Tâches</h3>
                        <p>Organisez vos projets avec des outils de gestion de tâches et de collaboration.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="feature-title">Suivi en Temps Réel</h3>
                        <p>Surveillez l'activité sur votre site en temps réel avec des notifications instantanées.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Clients -->
    <section class="clients-section" id="clients">
        <div class="container">
            <h2 class="section-title text-center mb-5">Nos Clients Fidèles</h2>
            
            <div class="row align-items-center justify-content-center g-4">
                <div class="col-lg-2 col-md-3 col-4">
                    <div class="client-logo">
                        <img src="https://www.goexploria.com/uploads/companies/78/logo/logo-78.png" alt="Client 1">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4">
                    <div class="client-logo">
                        <img src="https://www.goexploria.com/uploads/companies/147257/logo/logo-147257.png" alt="Client 2">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4">
                    <div class="client-logo">
                        <img src="https://www.goexploria.com/uploads/companies/147256/logo/logo-147256.png" alt="Client 3">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4">
                    <div class="client-logo">
                        <img src="https://www.goexploria.com/uploads/companies/147255/logo/logo-147255.png" alt="Client 4">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4">
                    <div class="client-logo">
                        <img src="https://www.goexploria.com/uploads/companies/147254/logo/logo-147254.png" alt="Client 5">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4">
                    <div class="client-logo">
                        <img src="https://www.goexploria.com/uploads/companies/147253/logo/logo-147253.png" alt="Client 6">
                    </div>
                </div>
            </div>
            
            <!-- Swiper pour les captures d'écran -->
            <div class="mt-5">
                <h3 class="text-center mb-4" style="color: var(--primary-color);">Sites créés avec notre plateforme</h3>
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="https://images.unsplash.com/photo-1559028012-481c04fa702d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1036&q=80" alt="Site web restaurant" />
                        </div>
                        <div class="swiper-slide">
                            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1015&q=80" alt="Site web entreprise" />
                        </div>
                        <div class="swiper-slide">
                            <img src="https://images.unsplash.com/photo-1551650975-87deedd944c3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80" alt="Site web e-commerce" />
                        </div>
                        <div class="swiper-slide">
                            <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Site web portfolio" />
                        </div>
                        <div class="swiper-slide">
                            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Site web agence" />
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Vidéo -->
    <section class="video-section" id="video">
        <div class="container">
            <h2 class="section-title text-center mb-5" style="color: white;">Démonstration en Vidéo</h2>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="video-container">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Statistiques -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number" data-count="1500">0</div>
                        <div class="stat-label">Sites créés</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number" data-count="98">0</div>
                        <div class="stat-label">% de satisfaction</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number" data-count="24">0</div>
                        <div class="stat-label">Heures de création</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number" data-count="50">0</div>
                        <div class="stat-label">Régions couvertes</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section (existante) -->
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

    <!-- Featured Companies (existante) -->
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

    <!-- Gallery Section (existante) -->
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

    <!-- Welcome Section (existante) -->
    <section class="welcome-section">
        <div class="container">
            <div class="welcome-content">
                <h1 class="text-center mb-4">Bienvenue sur GO EXPLORIA BUSINESS</h1>
                <p>C'est votre plateforme de création digitale pour le monde des affaires au Québec.</p>
                <p>Notre objectif est de vous aider à créer votre présence en ligne avec des outils puissants et faciles à utiliser.</p>
                <p>Merci de nous faire confiance pour vos projets web et digitaux.</p>
                <p class="text-center"><strong>Profitez du Québec, il est grand, il est beau et rempli d'opportunités digitales</strong></p>
                <div class="text-center mt-4">
                    <img src="https://www.goexploria.com/images/logo-go-exploria-qc-3.png" alt="GoExploria" style="max-width: 300px;">
                </div>
                <h3 class="text-center mt-4" style="color: var(--primary-color);">La Force Numérique au Québec</h3>
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
                        <li><a href="#home">Accueil Digital</a></li>
                        <li><a href="#editor">Éditeur de site</a></li>
                        <li><a href="#features">Fonctionnalités</a></li>
                        <li><a href="#clients">Nos clients</a></li>
                        <li><a href="#video">Démonstration</a></li>
                        <li><a href="#regions" class="mega-menu-trigger">Régions Canada</a></li>
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
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    
    <script>
        // Données pour les régions
        const canadianRegions = [
            {
                id: 1,
                title: "Québec",
                description: "Province francophone avec une riche culture et histoire",
                image: "https://images.unsplash.com/photo-1605058015762-7627e9b4b8c5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                capital: "Québec",
                population: "8,5 millions"
            },
            {
                id: 2,
                title: "Ontario",
                description: "Province la plus peuplée avec Toronto comme capitale économique",
                image: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                capital: "Toronto",
                population: "14,8 millions"
            },
            {
                id: 3,
                title: "Colombie-Britannique",
                description: "Province côtière avec des montagnes spectaculaires",
                image: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                capital: "Victoria",
                population: "5,2 millions"
            },
            {
                id: 4,
                title: "Alberta",
                description: "Province des Rocheuses et de l'industrie pétrolière",
                image: "https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                capital: "Edmonton",
                population: "4,4 millions"
            },
            {
                id: 5,
                title: "Manitoba",
                description: "Province des prairies avec de nombreux lacs",
                image: "https://images.unsplash.com/photo-1582436416930-f5d21b5e1f2e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                capital: "Winnipeg",
                population: "1,4 million"
            },
            {
                id: 6,
                title: "Saskatchewan",
                description: "Province des grandes plaines et de l'agriculture",
                image: "https://images.unsplash.com/photo-1528181304800-259b08848526?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                capital: "Regina",
                population: "1,2 million"
            },
            {
                id: 7,
                title: "Nouvelle-Écosse",
                description: "Province maritime avec une riche histoire acadienne",
                image: "https://images.unsplash.com/photo-1506929562872-bb421503ef21?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                capital: "Halifax",
                population: "1 million"
            },
            {
                id: 8,
                title: "Nouveau-Brunswick",
                description: "Seule province officiellement bilingue du Canada",
                image: "https://images.unsplash.com/photo-1541692641319-981cc79ee10a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80",
                link: "#",
                capital: "Fredericton",
                population: "800 000"
            }
        ];

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser le mega menu
            initMegaMenu();
            
            // Initialiser Swiper
            initSwiper();
            
            // Initialiser les animations de défilement
            initScrollAnimations();
            
            // Initialiser les compteurs animés
            initCounters();
            
            // Initialiser la navigation
            initNavigation();
            
            // Mettre à jour les informations en temps réel
            updateLiveInfo();
        });
        
        // Initialiser le mega menu
        function initMegaMenu() {
            const megaDropdown = document.getElementById('megaDropdown');
            const megaMenuTrigger = document.querySelector('.mega-menu-trigger');
            const closeMegaMenu = document.getElementById('closeMegaMenu');
            const regionGrid = document.getElementById('regionGrid');
            const regionColumns = document.getElementById('regionColumns');
            
            // Remplir les cartes de région
            canadianRegions.forEach(region => {
                const regionCard = document.createElement('div');
                regionCard.className = 'region-card';
                regionCard.innerHTML = `
                    <img src="${region.image}" alt="${region.title}" class="region-card-img">
                    <div class="region-card-content">
                        <h3 class="region-card-title">${region.title}</h3>
                        <p class="region-card-desc">${region.description}</p>
                        <div class="d-flex justify-content-between mt-3">
                            <small><i class="fas fa-landmark me-1"></i> ${region.capital}</small>
                            <small><i class="fas fa-users me-1"></i> ${region.population}</small>
                        </div>
                    </div>
                `;
                
                regionCard.addEventListener('click', function() {
                    console.log(`Navigation vers: ${region.title}`);
                    // Fermer le mega menu après sélection
                    megaDropdown.classList.remove('active');
                    megaMenuTrigger.classList.remove('active');
                    // Ici, vous pouvez rediriger vers la page de la région
                    // window.location.href = region.link;
                });
                
                regionGrid.appendChild(regionCard);
            });
            
            // Remplir la liste complète des régions
            canadianRegions.forEach(region => {
                const regionItem = document.createElement('div');
                regionItem.className = 'region-list-item';
                regionItem.innerHTML = `
                    <i class="fas fa-map-marker-alt me-2" style="color: var(--secondary-color);"></i>
                    ${region.title}
                `;
                
                regionItem.addEventListener('click', function() {
                    console.log(`Sélection de la région: ${region.title}`);
                    megaDropdown.classList.remove('active');
                    megaMenuTrigger.classList.remove('active');
                });
                
                regionColumns.appendChild(regionItem);
            });
            
            // Ouvrir le mega menu
            megaMenuTrigger.addEventListener('click', function(e) {
                e.preventDefault();
                megaDropdown.classList.toggle('active');
                this.classList.toggle('active');
            });
            
            // Fermer le mega menu
            closeMegaMenu.addEventListener('click', function() {
                megaDropdown.classList.remove('active');
                megaMenuTrigger.classList.remove('active');
            });
            
            // Fermer le mega menu en cliquant à l'extérieur
            document.addEventListener('click', function(e) {
                if (!megaDropdown.contains(e.target) && !megaMenuTrigger.contains(e.target)) {
                    megaDropdown.classList.remove('active');
                    megaMenuTrigger.classList.remove('active');
                }
            });
        }
        
        // Initialiser Swiper
        function initSwiper() {
            const swiper = new Swiper(".mySwiper", {
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                coverflowEffect: {
                    rotate: 20,
                    stretch: 0,
                    depth: 200,
                    modifier: 1,
                    slideShadows: true,
                },
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                    1024: {
                        slidesPerView: 4,
                    },
                },
            });
        }
        
        // Initialiser les animations de défilement
        function initScrollAnimations() {
            // Animation des éléments au défilement
            const animateElements = document.querySelectorAll('.feature-card, .editor-preview, .hero-content, .category-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in-up');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            animateElements.forEach(element => {
                observer.observe(element);
            });
        }
        
        // Initialiser les compteurs animés
        function initCounters() {
            const counters = document.querySelectorAll('.stat-number');
            const speed = 200;
            
            const animateCounter = () => {
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-count');
                    const count = +counter.innerText.replace(/,/g, '');
                    const increment = target / speed;
                    
                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment).toLocaleString();
                        setTimeout(animateCounter, 20);
                    } else {
                        counter.innerText = target.toLocaleString();
                    }
                });
            };
            
            // Démarrer les compteurs quand la section est visible
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });
            
            // Observer la section statistiques
            const statsSection = document.querySelector('.stats-section');
            if (statsSection) {
                observer.observe(statsSection);
            }
        }
        
        // Initialiser la navigation
        function initNavigation() {
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href').startsWith('#')) {
                        e.preventDefault();
                        
                        // Retirer la classe active de tous les liens
                        navLinks.forEach(item => item.classList.remove('active'));
                        
                        // Ajouter la classe active au lien cliqué
                        this.classList.add('active');
                        
                        // Fermer le mega menu s'il est ouvert
                        const megaDropdown = document.getElementById('megaDropdown');
                        const megaMenuTrigger = document.querySelector('.mega-menu-trigger');
                        megaDropdown.classList.remove('active');
                        megaMenuTrigger.classList.remove('active');
                        
                        // Faire défiler jusqu'à la section
                        const targetId = this.getAttribute('href');
                        if (targetId !== '#') {
                            const targetSection = document.querySelector(targetId);
                            if (targetSection) {
                                window.scrollTo({
                                    top: targetSection.offsetTop - 100,
                                    behavior: 'smooth'
                                });
                            }
                        }
                    }
                });
            });
        }
        
        // Mettre à jour les informations en temps réel
        function updateLiveInfo() {
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
    </script>
</body>
</html>