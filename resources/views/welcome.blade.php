<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go Exploria Business - Plateforme de Création Digitale</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    
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
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
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
        
        .top-bar-icons {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .top-bar-icon {
            display: flex;
            align-items: center;
            gap: 5px;
            transition: var(--transition);
        }
        
        .top-bar-icon:hover {
            color: var(--accent-color);
        }
        
        .language-selector {
            position: relative;
            display: inline-block;
        }
        
        .language-btn {
            background: none;
            border: none;
            color: white;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 4px;
            transition: var(--transition);
        }
        
        .language-btn:hover {
            background-color: rgba(255,255,255,0.1);
        }
        
        .language-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 6px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            min-width: 120px;
            z-index: 9999;
            display: none;
        }
        
        .language-dropdown.show {
            display: block;
        }
        
        .language-option {
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: black !important;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .language-option:hover {
            background-color: #f8f9fa;
            color: var(--primary-color);
        }
        
        .flag-icon {
            width: 20px;
            height: 15px;
            object-fit: cover;
            border-radius: 2px;
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
        
        /* Main Navigation - RESPONSIVE */
        .main-navbar {
            background-color: white;
            box-shadow: var(--box-shadow);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        
        .navbar-brand {
            padding: 10px 0;
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
            /* position: absolute; */
            width: 0;
            height: 3px;
            background: var(--secondary-color);
            /* bottom: 0;
            left: 15px; */
            transition: var(--transition);
        }
        
        .nav-link:hover:after, .nav-link.active:after {
            /* width: calc(100% - 30px); */
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
        
        /* CORRECTIONS DÉFINITIVES - DROPDOWN CENTRÉ ET IMAGES COLLÉES */
        .dropdown-menu.full-width {
            width: 100vw !important;
            max-width: 100vw !important;
            right: auto !important;
            transform: translateX(-50%) !important;
            margin: 0 !important;
            padding: 20px !important;
            border: none !important;
            box-shadow: 0 15px 40px rgba(0,0,0,0.15) !important;
            border-radius: 0 0 var(--border-radius) var(--border-radius) !important;
            overflow: hidden !important;
            position: absolute !important;
            top: 100% !important;
            z-index: 9999 !important;
        }
        
        .dropdown-menu.full-width .container {
            max-width: 100% !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        
        .row.mega-menu-regions {
            margin-left: -4px !important;
            margin-right: -4px !important;
            --bs-gutter-x: 0.25rem !important;
            --bs-gutter-y: 0.25rem !important;
            display: flex !important;
            flex-wrap: wrap !important;
            width: calc(100% + 8px) !important;
        }
        
        .row.mega-menu-regions .col-md-3 {
            padding-left: 4px !important;
            padding-right: 4px !important;
            margin-bottom: 8px !important;
            flex: 0 0 25%;
            max-width: 25%;
        }
        
        .dropdown-item-with-img {
            display: block !important;
            padding: 0 !important;
            margin: 0 !important;
            text-decoration: none;
            border-radius: 6px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.08);
            background: white;
            height: 100%;
            width: 100%;
        }
        
        .dropdown-item-with-img:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            border-color: var(--secondary-color);
        }
        
        .dropdown-img {
            width: 100% !important;
            height: 160px !important;
            object-fit: cover;
            display: block;
            margin: 0 !important;
            padding: 0 !important;
            border-bottom: 3px solid var(--secondary-color);
            transition: transform 0.4s ease;
        }
        
        .dropdown-item-with-img:hover .dropdown-img {
            transform: scale(1.08);
        }
        
        .dropdown-item-content {
            padding: 10px !important;
            text-align: center;
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .dropdown-item-title {
            font-weight: 700 !important;
            color: var(--primary-color) !important;
            margin: 0 !important;
            font-size: 1rem !important;
            line-height: 1.3;
            text-decoration: none;
            display: block;
            width: 100%;
        }
        
        .dropdown-item-with-img:hover .dropdown-item-title {
            color: var(--secondary-color) !important;
        }
        
        .navbar .dropdown-menu {
            border: none;
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .dropdown-menu.full-width {
            max-height: 75vh;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .dropdown-divider.my-3 {
            margin: 15px 0 !important;
            width: 100% !important;
        }
        
        .text-center.d-block {
            display: block !important;
            width: 100% !important;
            margin: 10px auto 0 !important;
            padding: 12px !important;
            background: linear-gradient(135deg, var(--light-color) 0%, #e9ecef 100%);
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            border: 2px dashed var(--secondary-color);
            transition: var(--transition);
        }
        
        .text-center.d-block:hover {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #38b2ac 100%);
            color: white !important;
            border-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .row.mega-menu-regions .col-md-3 {
                flex: 0 0 33.333%;
                max-width: 33.333%;
            }
            
            .dropdown-img {
                height: 140px !important;
            }
        }
        
        @media (max-width: 992px) {
            .dropdown-menu.full-width {
                position: static !important;
                width: 100% !important;
                left: 0 !important;
                transform: none !important;
                margin-top: 0 !important;
            }
            
            .row.mega-menu-regions .col-md-3 {
                flex: 0 0 0;
                max-width: 50%;
            }
            
            .dropdown-img {
                height: 130px !important;
            }
            
            .row.mega-menu-regions {
                margin-left: -3px !important;
                margin-right: -3px !important;
            }
            
            .row.mega-menu-regions .col-md-3 {
                padding-left: 3px !important;
                padding-right: 3px !important;
            }
            
            /* Navigation mobile */
            .navbar-collapse {
                background: white;
                padding: 20px;
                border-radius: var(--border-radius);
                box-shadow: var(--box-shadow);
                margin-top: 10px;
            }
        }
        
        @media (max-width: 768px) {
            .dropdown-menu.full-width {
                padding: 15px 8px !important;
            }
            
            .row.mega-menu-regions .col-md-3 {
                flex: 0 0 100%;
                max-width: 80%;
                padding-left: 0 !important;
                padding-right: 0 !important;
                margin-bottom: 10px !important;
            }
            
            .dropdown-img {
                height: 150px !important;
            }
            
            .row.mega-menu-regions {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
            
            .special-buttons {
                margin-top: 15px;
                justify-content: center;
                flex-wrap: wrap;
            }
        }
        
        /* Dropdown on hover - Full Width */
        .navbar .nav-item.dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
        }
        
        /* FIX POUR L'AFFICHAGE MOBILE */
        @media (max-width: 992px) {
            .navbar .nav-item.dropdown:hover .dropdown-menu {
                display: none;
            }
            
            .navbar .nav-item.dropdown .dropdown-menu.show {
                display: block !important;
            }
        }
        
        /* Override Bootstrap position */
        .dropdown-menu[data-bs-popper] {
            margin-top: 0 !important;
        }
        
        /* Video Slider Full Width */
        .video-slider-section {
            position: relative;
            width: 100%;
            height: 600px;
            overflow: hidden;
        }
        
        .video-slider-container {
            width: 100%;
            height: 100%;
        }
        
        .video-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        
        .video-slide.active {
            opacity: 1;
        }
        
        .video-slide iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .video-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .slider-controls {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }
        
        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
            cursor: pointer;
            transition: var(--transition);
        }
        
        .slider-dot.active {
            background: white;
            transform: scale(1.2);
        }
        
        .slider-content {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(26, 95, 122, 0.8) 0%, rgba(44, 62, 80, 0.7) 50%, transparent 100%);
            display: flex;
            align-items: center;
            padding: 0 50px;
            z-index: 5;
        }
        
        .slider-text {
            color: white;
            max-width: 600px;
        }
        
        .slider-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .slider-subtitle {
            font-size: 1.3rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        /* Mega Menu Dropdown amélioré */
        .mega-dropdown-container {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
            padding: 30px;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-20px);
            transition: all 0.3s ease;
        }
        
        .mega-dropdown-container.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        /* Régions en grille full width */
        .region-grid-full {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .region-card-large {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            cursor: pointer;
            border: 1px solid rgba(0,0,0,0.05);
            height: 300px;
            position: relative;
        }
        
        .region-card-large:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .region-card-img-large {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .region-card-large:hover .region-card-img-large {
            transform: scale(1.1);
        }
        
        .region-card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            padding: 20px;
            color: white;
        }
        
        .region-card-title-large {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
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
            background: linear-gradient(135deg, #1a5f7a 0%, #2c3e50 100%);
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
            background: linear-gradient(135deg, #1a5f7a 0%, #2c3e50 100%);
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
        
        /* Section titre */
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
        
        /* Responsive Design */
        @media (max-width: 1200px) {
            .region-grid-full {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .slider-title {
                font-size: 3rem;
            }
        }
        
        @media (max-width: 992px) {
            .slider-title {
                font-size: 2.5rem;
            }
            
            .region-grid-full {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .region-columns {
                columns: 2;
            }
        }
        
        @media (max-width: 768px) {
            .slider-title {
                font-size: 2rem;
            }
            
            .slider-subtitle {
                font-size: 1.1rem;
            }
            
            .slider-content {
                padding: 0 20px;
            }
            
            .video-slider-section {
                height: 500px;
            }
            
            .top-bar .d-flex {
                flex-direction: column;
                text-align: center;
            }
            
            .top-bar-icons {
                justify-content: center;
                margin-top: 10px;
                flex-wrap: wrap;
                gap: 10px;
            }
            
            .info-items {
                justify-content: center;
            }
            
            .info-item {
                margin: 5px 10px;
            }
            
            .region-grid-full {
                grid-template-columns: 1fr;
            }
            
            .region-columns {
                columns: 1;
            }
            
            .editor-section, .features-section, .clients-section, .video-section {
                padding: 60px 0;
            }
        }
        
        @media (max-width: 576px) {
            .slider-title {
                font-size: 1.8rem;
            }
            
            .slider-dot {
                width: 10px;
                height: 10px;
            }
            
            .video-slider-section {
                height: 400px;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
            
            .mega-dropdown-container {
                padding: 20px 15px;
            }
        }
        
        /* CORRECTION POUR TOUS LES DROPDOWNS */
        .navbar-nav .dropdown-menu {
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .navbar .container {
            position: relative;
        }
        
        .dropdown-item-with-img {
            position: relative;
            overflow: hidden;
        }
        
        .dropdown-item-with-img::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }
        
        .dropdown-item-with-img:hover::after {
            opacity: 1;
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
                
                <div class="top-bar-icons">
                    <!-- Panier -->
                    <a href="#" class="top-bar-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Panier</span>
                    </a>
                    
                    <!-- Mon compte -->
                    <a href="{{route('login')}}" class="top-bar-icon">
                        <i class="fas fa-user"></i>
                        <span>Mon compte</span>
                    </a>
                    
                    <!-- Localisation / Langue -->
                    <div class="language-selector">
                        <button class="language-btn" id="languageBtn">
                            <img src="https://flagcdn.com/w20/fr.png" class="flag-icon" alt="Français">
                            <span>FR</span>
                            <i class="fas fa-chevron-down ms-1"></i>
                        </button>
                        <div class="language-dropdown" id="languageDropdown">
                            <a href="#" class="language-option" data-lang="fr">
                                <img src="https://flagcdn.com/w20/fr.png" class="flag-icon" alt="Français">
                                <span>Français</span>
                            </a>
                            <a href="#" class="language-option" data-lang="en">
                                <img src="https://flagcdn.com/w20/gb.png" class="flag-icon" alt="English">
                                <span>English</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- YouTube Icon -->
                    <a href="https://www.youtube.com/user/explorezlemonde/videos?view_as=subscriber" target="_blank" class="top-bar-icon">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation - RESPONSIVE -->
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
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="explorerDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
        <i class="fas fa-map-marked-alt me-1"></i>Explorer Région
    </a>
    <div class="dropdown-menu full-width" aria-labelledby="explorerDropdown">
        <div class="container">
            <div class="row mega-menu-regions" id="regionsDropdownContainer">
                <!-- Les régions seront chargées par AJAX ici -->
                <div class="col-12 text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="mt-2">Chargement des régions...</p>
                </div>
            </div>
        </div>
    </div>
</li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="fas fa-concierge-bell me-1"></i> GO Explorez
                        </a>
                        <div class="dropdown-menu full-width" aria-labelledby="servicesDropdown">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="dropdown-header">Services Digitaux</h5>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-briefcase me-2"></i>GO Business
                                            <span class="text-muted d-block small mt-1">Solutions pour entreprises</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-store me-2"></i>GO Local
                                            <span class="text-muted d-block small mt-1">Promotion commerciale locale</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-crown me-2"></i>GO Prime Time
                                            <span class="text-muted d-block small mt-1">Services premium</span>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="dropdown-header">Médias & Contenu</h5>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-tv me-2"></i>GO Web TV
                                            <span class="text-muted d-block small mt-1">Chaîne vidéo en ligne</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-camera me-2"></i>GO Photos
                                            <span class="text-muted d-block small mt-1">Banque d'images exclusive</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-newspaper me-2"></i>GO Actualités
                                            <span class="text-muted d-block small mt-1">Nouvelles locales et régionales</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="resourcesDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="fas fa-book me-1"></i>Ressources
                        </a>
                        <div class="dropdown-menu full-width" aria-labelledby="resourcesDropdown">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h5 class="dropdown-header">Contenu Éducatif</h5>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-file-alt me-2"></i>Blog
                                            <span class="text-muted d-block small mt-1">Articles et conseils</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-newspaper me-2"></i>Actualités
                                            <span class="text-muted d-block small mt-1">Nouvelles du Québec</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-graduation-cap me-2"></i>Guides
                                            <span class="text-muted d-block small mt-1">Guides touristiques</span>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="dropdown-header">Événements</h5>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-calendar-alt me-2"></i>Calendrier
                                            <span class="text-muted d-block small mt-1">Événements à venir</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-ticket-alt me-2"></i>Billeterie
                                            <span class="text-muted d-block small mt-1">Achetez vos billets</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-bullhorn me-2"></i>Promotions
                                            <span class="text-muted d-block small mt-1">Offres spéciales</span>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="dropdown-header">Support</h5>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-question-circle me-2"></i>Aide & FAQ
                                            <span class="text-muted d-block small mt-1">Questions fréquentes</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-headset me-2"></i>Support Client
                                            <span class="text-muted d-block small mt-1">Assistance 24/7</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-download me-2"></i>Téléchargements
                                            <span class="text-muted d-block small mt-1">Ressources gratuites</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        
        <div class="region-grid-full" id="regionGrid">
            <!-- Les cartes régions seront ajoutées par JavaScript -->
        </div>
        
        <div class="region-list-all">
            <h4>Toutes les régions disponibles</h4>
            <div class="region-columns" id="regionColumns">
                <!-- La liste complète sera ajoutée par JavaScript -->
            </div>
        </div>
    </div>

    <!-- Video Slider Full Width -->
    <section class="video-slider-section" id="home">
        <div class="video-slider-container">
            <!-- Slide 1: Vidéo YouTube -->
            <div class="video-slide active">
                <iframe src="https://www.youtube.com/embed/VKWE89nmIWs?autoplay=1&mute=1&loop=1&playlist=VKWE89nmIWs" title="YouTube video" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            
            <!-- Slide 2: Image -->
            <div class="video-slide">
                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Montagnes canadiennes">
            </div>
            
            <!-- Slide 3: Image -->
            <div class="video-slide">
                <img src="https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Paysage hivernal">
            </div>
            
            <!-- Slide 4: Image -->
            <div class="video-slide">
                <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Ville de Québec">
            </div>
            
            <!-- Slide 5: Image -->
            <div class="video-slide">
                <img src="https://images.unsplash.com/photo-1596394516093-9baa8e6c2b5e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Lac canadien">
            </div>
        </div>
        
        <div class="slider-content">
            <div class="slider-text">
                <h1 class="slider-title">Créez votre présence digitale avec Go Exploria Business</h1>
                <p class="slider-subtitle">Notre plateforme tout-en-un vous permet de créer, gérer et optimiser votre site web avec des outils puissants d'analyse, SEO, messagerie et IA intégrée.</p>
                <div class="hero-buttons">
                    <a href="#editor" class="btn btn-primary btn-lg">
                        <i class="fas fa-play-circle me-2"></i>Essayer la démo
                    </a>
                    <a href="#features" class="btn btn-outline-light btn-lg ms-2">
                        <i class="fas fa-list-alt me-2"></i>Voir les fonctionnalités
                    </a>
                </div>
            </div>
        </div>
        
        <div class="slider-controls">
            <div class="slider-dot active" data-slide="0"></div>
            <div class="slider-dot" data-slide="1"></div>
            <div class="slider-dot" data-slide="2"></div>
            <div class="slider-dot" data-slide="3"></div>
            <div class="slider-dot" data-slide="4"></div>
        </div>
    </section>

    <!-- Les autres sections restent identiques -->
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
                        
                        <a href="#contact" class="btn btn-primary btn-lg">
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

    <!-- Footer -->
    <footer class="main-footer" style="background-color: var(--dark-color); color: white; padding: 80px 0 30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <img src="https://www.goexploria.com/images/logo-go-exploria-qc-3.png" alt="GoExploria" style="height: 70px; margin-bottom: 25px;">
                    <p>Votre guide touristique et d'affaires pour le Québec. Découvrez, explorez, vivez le Québec comme jamais auparavant.</p>
                    <div class="social-icons mt-3">
                        <a href="https://www.youtube.com/user/explorezlemonde/videos?view_as=subscriber" target="_blank">
                            <i class="fab fa-youtube fa-2x"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h4 style="color: white; font-size: 1.3rem; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid var(--accent-color); display: inline-block;">Liens rapides</h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 12px;"><a href="#home" style="color: #ddd; text-decoration: none; transition: var(--transition);">Accueil Digital</a></li>
                        <li style="margin-bottom: 12px;"><a href="#editor" style="color: #ddd; text-decoration: none; transition: var(--transition);">Éditeur de site</a></li>
                        <li style="margin-bottom: 12px;"><a href="#features" style="color: #ddd; text-decoration: none; transition: var(--transition);">Fonctionnalités</a></li>
                        <li style="margin-bottom: 12px;"><a href="#clients" style="color: #ddd; text-decoration: none; transition: var(--transition);">Nos clients</a></li>
                        <li style="margin-bottom: 12px;"><a href="#regions" class="mega-menu-trigger" style="color: #ddd; text-decoration: none; transition: var(--transition);">Régions Canada</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h4 style="color: white; font-size: 1.3rem; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid var(--accent-color); display: inline-block;">Contactez-nous</h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 12px;"><i class="fas fa-phone me-2"></i> (418) 525-7748</li>
                        <li style="margin-bottom: 12px;"><i class="fas fa-envelope me-2"></i> infogoexploria@gmail.com</li>
                        <li style="margin-bottom: 12px;"><i class="fas fa-map-marker-alt me-2"></i> Québec, Canada</li>
                    </ul>
                    <div class="mt-4">
                        <a href="https://www.goexploria.com/company/68620/go-exploria-plans-de-relance" class="btn btn-outline-light me-2">Plans de relance</a>
                        <a href="https://www.goexploria.com/company/68619/go-exploria-services-web" class="btn btn-accent" style="background-color: var(--accent-color); border-color: var(--accent-color); color: white;">Services web</a>
                    </div>
                </div>
            </div>
            
            <div class="copyright" style="text-align: center; padding-top: 40px; margin-top: 40px; border-top: 1px solid #444; color: #aaa; font-size: 0.95rem;">
                <p>&copy; 2023 GoExploria. Tous droits réservés. | <a href="#" style="color: white;">Politique de confidentialité</a> | <a href="#" style="color: white;">Conditions d'utilisation</a></p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Variables globales
    let currentSlide = 0;
    let slideInterval;

    // Initialisation complète
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser le mega menu
        initMegaMenu();
        
        // Initialiser le sélecteur de langue
        initLanguageSelector();
        
        // Initialiser le slider vidéo
        initVideoSlider();
        
        // Initialiser les animations de défilement
        initScrollAnimations();
        
        // Initialiser les compteurs animés
        initCounters();
        
        // Initialiser la navigation
        initNavigation();
        
        // Mettre à jour les informations en temps réel
        updateLiveInfo();
        
        // Configurer les dropdowns Bootstrap avec AJAX
        initBootstrapDropdowns();

        // Centrer les dropdowns
        centerAndFixDropdowns();
        
        // Précharger les destinations sur desktop
        if (window.innerWidth > 992) {
            setTimeout(() => {
                loadDestinationsFromAPI();
            }, 1000);
        }
    });
    
    // Initialiser les dropdowns Bootstrap avec AJAX
    function initBootstrapDropdowns() {
        const dropdowns = document.querySelectorAll('.dropdown');
        
        dropdowns.forEach(dropdown => {
            // Pour desktop, ouvrir au hover
            if (window.innerWidth > 992) {
                dropdown.addEventListener('mouseenter', function() {
                    const dropdownMenu = this.querySelector('.dropdown-menu');
                    if (dropdownMenu) {
                        dropdownMenu.classList.add('show');
                        centerAndFixDropdowns();
                        
                        // Charger les régions si c'est le dropdown "Explorer Région"
                        if (this.querySelector('#explorerDropdown')) {
                            loadDestinationsFromAPI();
                        }
                    }
                });
                
                dropdown.addEventListener('mouseleave', function() {
                    const dropdownMenu = this.querySelector('.dropdown-menu');
                    if (dropdownMenu) {
                        dropdownMenu.classList.remove('show');
                    }
                });
            }
        });
        
        // Écouter les événements de Bootstrap pour mobile
        document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
            toggle.addEventListener('show.bs.dropdown', function(e) {
                // Charger les régions si c'est le dropdown "Explorer Région"
                if (this.id === 'explorerDropdown') {
                    loadDestinationsFromAPI();
                }
            });
        });
    }

    // Charger les destinations depuis l'API
    function loadDestinationsFromAPI() {
        const container = document.getElementById('regionsDropdownContainer');
        
        // Vérifier si les données sont déjà chargées
        if (container.getAttribute('data-loaded') === 'true') {
            return;
        }
        
        // Afficher le loader
        container.innerHTML = `
            <div class="col-12 text-center py-3">
                <div class="spinner-border text-primary spinner-border-sm" role="status"></div>
                <span class="ms-2 small text-muted">Chargement des régions...</span>
            </div>
        `;
        
        // URL de l'API Laravel (à adapter)
        const apiUrl = '/api/destinations';
        
        // Options de la requête
        const options = {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        };
        
        // Ajouter le token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (csrfToken) {
            options.headers['X-CSRF-TOKEN'] = csrfToken;
        }
        
        // Timeout de 5 secondes
        const timeout = 5000;
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), timeout);
        options.signal = controller.signal;
        
        // Exécuter la requête
        fetch(apiUrl, options)
        .then(response => {
            clearTimeout(timeoutId);
            
            if (!response.ok) {
                throw new Error(`Erreur ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            const formattedData = formatDestinationsData(data);
            renderDestinationsDropdown(formattedData, container);
            container.setAttribute('data-loaded', 'true');
            container.classList.add('loaded');
            
            // Réinitialiser après 5 minutes
            setTimeout(() => {
                container.setAttribute('data-loaded', 'false');
            }, 300000);
        })
        .catch(error => {
            clearTimeout(timeoutId);
            console.error('Erreur AJAX:', error);
            
            if (error.name === 'AbortError') {
                showErrorMessage(container, 'Le chargement a pris trop de temps');
            } else {
                showErrorMessage(container, 'Impossible de charger les régions');
            }
        });
    }

    // Formater les données de l'API
    function formatDestinationsData(data) {
        // Si les données sont déjà dans le bon format
        if (Array.isArray(data)) {
            return data.map(item => ({
                id: item.id || Math.random(),
                name: item.name || item.title || 'Région',
                image: item.image || item.image_url || getRandomDefaultImage(),
                link: item.link || '#'
            }));
        }
        
        // Si les données ont une propriété 'data'
        if (data.data && Array.isArray(data.data)) {
            return formatDestinationsData(data.data);
        }
        
        // Si les données ont une propriété 'destinations'
        if (data.destinations && Array.isArray(data.destinations)) {
            return formatDestinationsData(data.destinations);
        }
        
        // Retourner des données par défaut
        return getDefaultDestinations();
    }

    // Obtenir une image par défaut aléatoire
    function getRandomDefaultImage() {
        const defaultImages = [
            'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80',
            'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80',
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80',
            'https://images.unsplash.com/photo-1605058015762-7627e9b4b8c5?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80',
            'https://images.unsplash.com/photo-1582436416930-f5d21b5e1f2e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80'
        ];
        return defaultImages[Math.floor(Math.random() * defaultImages.length)];
    }

    // Données par défaut
    function getDefaultDestinations() {
        return [
            { id: 1, name: "Québec", image: "https://images.unsplash.com/photo-1605058015762-7627e9b4b8c5?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80", link: "#" },
            { id: 2, name: "Ontario", image: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80", link: "#" },
            { id: 3, name: "Colombie-Britannique", image: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80", link: "#" },
            { id: 4, name: "Alberta", image: "https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80", link: "#" },
            { id: 5, name: "Manitoba", image: "https://images.unsplash.com/photo-1582436416930-f5d21b5e1f2e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80", link: "#" },
            { id: 6, name: "Saskatchewan", image: "https://images.unsplash.com/photo-1528181304800-259b08848526?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80", link: "#" },
            { id: 7, name: "Nouvelle-Écosse", image: "https://images.unsplash.com/photo-1506929562872-bb421503ef21?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80", link: "#" },
            { id: 8, name: "Nouveau-Brunswick", image: "https://images.unsplash.com/photo-1541692641319-981cc79ee10a?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80", link: "#" },
            { id: 9, name: "Terre-Neuve", image: "https://images.unsplash.com/photo-1512476446317-8e4296b3d1f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80", link: "#" },
            { id: 10, name: "Île-du-Prince-Édouard", image: "https://images.unsplash.com/photo-1529461174355-fd1f3f32d0b7?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80", link: "#" },
            { id: 11, name: "Yukon", image: "https://images.unsplash.com/photo-1519681393784-d120267933ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80", link: "#" },
            { id: 12, name: "Territoires du Nord-Ouest", image: "https://images.unsplash.com/photo-1534083220759-4c66c2bf7498?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80", link: "#" },
            { id: 13, name: "Nunavut", image: "https://images.unsplash.com/photo-1534270804882-6b5048b1c1fc?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80", link: "#" },
            { id: 14, name: "Montréal", image: "https://images.unsplash.com/photo-1514715526270-5c7a5c9d35e5?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80", link: "#" },
            { id: 15, name: "Vancouver", image: "https://images.unsplash.com/photo-1559501268-51b7d3e6b998?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=150&q=80", link: "#" }
        ];
    }

    // Afficher les destinations dans le dropdown (5 colonnes)
    function renderDestinationsDropdown(destinations, container) {
        if (!destinations || destinations.length === 0) {
            container.innerHTML = `
                <div class="col-12 text-center py-4">
                    <i class="fas fa-map-marked-alt fa-3x text-muted mb-3 opacity-50"></i>
                    <p class="text-muted small mb-0">Aucune région disponible</p>
                </div>
            `;
            return;
        }
        
        // Calculer la répartition en 5 colonnes
        const totalDestinations = destinations.length;
        const destinationsPerColumn = Math.ceil(totalDestinations / 5);
        
        let html = '';
        
        // Créer 5 colonnes
        for (let colIndex = 0; colIndex < 5; colIndex++) {
            html += `<div class="col-md-2-4">`; // 20% de largeur (100/5=20)
            
            // Calculer les indices pour cette colonne
            const startIndex = colIndex * destinationsPerColumn;
            const endIndex = Math.min(startIndex + destinationsPerColumn, totalDestinations);
            
            // Ajouter les destinations pour cette colonne
            for (let i = startIndex; i < endIndex; i++) {
                const destination = destinations[i];
                
                html += `
                    <a href="${destination.link}" class="region-item-simple" data-id="${destination.id}">
                        <div class="region-card-simple">
                            <div class="region-img-wrapper">
                                <img src="${destination.image}" 
                                     alt="${destination.name}" 
                                     class="region-img-simple"
                                     loading="lazy"
                                     onerror="this.onerror=null; this.src='${getRandomDefaultImage()}'">
                            </div>
                            <div class="region-name">${destination.name}</div>
                        </div>
                    </a>
                `;
            }
            
            html += `</div>`;
        }
        
        // Bouton "Voir toutes les régions"
        html += `
            <div class="col-12 mt-3 pt-3 border-top">
                <div class="text-center">
                    <a href="/destinations" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-list me-1"></i>
                        Voir toutes les régions (${totalDestinations})
                    </a>
                    <button class="btn btn-link btn-sm text-muted ms-2" onclick="refreshDestinations()" title="Actualiser">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
            </div>
        `;
        
        // Animation d'apparition
        container.style.opacity = '0';
        container.innerHTML = html;
        
        // Appliquer l'animation
        setTimeout(() => {
            container.style.opacity = '1';
            initSimpleRegionHover();
            applyStaggerAnimation();
        }, 10);
    }

    // Appliquer l'animation en cascade
    function applyStaggerAnimation() {
        const items = document.querySelectorAll('.region-item-simple');
        items.forEach((item, index) => {
            item.style.setProperty('--item-index', index);
            item.style.animationDelay = `${index * 0.05}s`;
        });
    }

    // Initialiser les effets de hover
    function initSimpleRegionHover() {
        const regionItems = document.querySelectorAll('.region-item-simple');
        
        regionItems.forEach(item => {
            // Effet au survol
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
                this.querySelector('.region-card-simple').style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
                this.querySelector('.region-img-simple').style.transform = 'scale(1.05)';
            });
            
            // Effet quand la souris quitte
            item.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.querySelector('.region-card-simple').style.boxShadow = '';
                this.querySelector('.region-img-simple').style.transform = '';
            });
            
            // Animation au clic
            item.addEventListener('click', function(e) {
                const id = this.getAttribute('data-id');
                const name = this.querySelector('.region-name').textContent;
                
                // Animation de clic
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
                
                console.log(`Navigation vers: ${name} (ID: ${id})`);
            });
        });
    }

    // Rafraîchir les destinations
    function refreshDestinations() {
        const container = document.getElementById('regionsDropdownContainer');
        container.setAttribute('data-loaded', 'false');
        container.classList.remove('loaded');
        loadDestinationsFromAPI();
    }

    // Afficher un message d'erreur
    function showErrorMessage(container, message) {
        container.innerHTML = `
            <div class="col-12 text-center py-4">
                <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
                <p class="small text-muted mb-3">${message}</p>
                <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-primary btn-sm" onclick="refreshDestinations()">
                        <i class="fas fa-redo me-1"></i> Réessayer
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="useDefaultData()">
                        <i class="fas fa-eye me-1"></i> Exemples
                    </button>
                </div>
            </div>
        `;
    }

    // Utiliser les données par défaut
    function useDefaultData() {
        const container = document.getElementById('regionsDropdownContainer');
        const defaultData = getDefaultDestinations();
        renderDestinationsDropdown(defaultData, container);
        container.setAttribute('data-loaded', 'true');
    }

    // Fonction pour centrer les dropdowns
    function centerAndFixDropdowns() {
        const dropdowns = document.querySelectorAll('.dropdown-menu.full-width');
        
        dropdowns.forEach(dropdown => {
            if (dropdown.classList.contains('show') && window.innerWidth > 992) {
                // Centrer le dropdown
                dropdown.style.left = '50%';
                dropdown.style.transform = 'translateX(-50%)';
                dropdown.style.width = '100vw';
                dropdown.style.maxWidth = '100vw';
                dropdown.style.padding = '20px';
                
                // Vérifier et corriger le débordement
                const rect = dropdown.getBoundingClientRect();
                const windowWidth = window.innerWidth;
                
                // Débordement à droite
                if (rect.right > windowWidth) {
                    const overflow = rect.right - windowWidth;
                    dropdown.style.left = `calc(50% - ${overflow}px)`;
                }
                
                // Débordement à gauche
                if (rect.left < 0) {
                    const overflow = Math.abs(rect.left);
                    dropdown.style.left = `calc(50% + ${overflow}px)`;
                }
                
                // Limiter la hauteur
                dropdown.style.maxHeight = '70vh';
                dropdown.style.overflowY = 'auto';
                dropdown.style.boxShadow = '0 10px 40px rgba(0,0,0,0.15)';
            }
        });
    }

    // Initialiser le mega menu
    function initMegaMenu() {
        const megaDropdown = document.getElementById('megaDropdown');
        const megaMenuTrigger = document.querySelector('.mega-menu-trigger');
        const closeMegaMenu = document.getElementById('closeMegaMenu');
        const regionGrid = document.getElementById('regionGrid');
        const regionColumns = document.getElementById('regionColumns');
        
        // Remplir les cartes de région
        getDefaultDestinations().forEach(region => {
            const regionCard = document.createElement('div');
            regionCard.className = 'region-card-large';
            regionCard.innerHTML = `
                <img src="${region.image}" alt="${region.name}" class="region-card-img-large">
                <div class="region-card-overlay">
                    <h3 class="region-card-title-large">${region.name}</h3>
                </div>
            `;
            
            regionCard.addEventListener('click', function() {
                console.log(`Navigation vers: ${region.name}`);
                megaDropdown.classList.remove('active');
                megaMenuTrigger.classList.remove('active');
            });
            
            regionGrid.appendChild(regionCard);
        });
        
        // Remplir la liste des régions
        getDefaultDestinations().forEach(region => {
            const regionItem = document.createElement('div');
            regionItem.className = 'region-list-item';
            regionItem.innerHTML = `
                <i class="fas fa-map-marker-alt me-2" style="color: var(--secondary-color);"></i>
                ${region.name}
            `;
            
            regionItem.addEventListener('click', function() {
                console.log(`Sélection: ${region.name}`);
                megaDropdown.classList.remove('active');
                megaMenuTrigger.classList.remove('active');
            });
            
            regionColumns.appendChild(regionItem);
        });
        
        // Ouvrir/fermer le mega menu
        megaMenuTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            megaDropdown.classList.toggle('active');
            this.classList.toggle('active');
        });
        
        closeMegaMenu.addEventListener('click', function() {
            megaDropdown.classList.remove('active');
            megaMenuTrigger.classList.remove('active');
        });
        
        // Fermer en cliquant à l'extérieur
        document.addEventListener('click', function(e) {
            if (!megaDropdown.contains(e.target) && !megaMenuTrigger.contains(e.target)) {
                megaDropdown.classList.remove('active');
                megaMenuTrigger.classList.remove('active');
            }
        });
    }

    // Initialiser le sélecteur de langue
    function initLanguageSelector() {
        const languageBtn = document.getElementById('languageBtn');
        const languageDropdown = document.getElementById('languageDropdown');
        const languageOptions = document.querySelectorAll('.language-option');
        
        languageBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            languageDropdown.classList.toggle('show');
        });
        
        languageOptions.forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                const lang = this.getAttribute('data-lang');
                const flag = this.querySelector('img').src;
                const text = this.querySelector('span').textContent;
                
                languageBtn.querySelector('img').src = flag;
                languageBtn.querySelector('span').textContent = text.toUpperCase().substring(0, 2);
                languageDropdown.classList.remove('show');
                
                console.log(`Langue changée: ${lang}`);
            });
        });
        
        document.addEventListener('click', function() {
            languageDropdown.classList.remove('show');
        });
        
        languageDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    // Initialiser le slider vidéo
    function initVideoSlider() {
        const slides = document.querySelectorAll('.video-slide');
        const dots = document.querySelectorAll('.slider-dot');
        
        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            currentSlide = index;
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                showSlide(index);
                resetInterval();
            });
        });
        
        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }
        
        function startInterval() {
            slideInterval = setInterval(nextSlide, 5000);
        }
        
        function resetInterval() {
            clearInterval(slideInterval);
            startInterval();
        }
        
        const sliderContainer = document.querySelector('.video-slider-container');
        sliderContainer.addEventListener('mouseenter', () => {
            clearInterval(slideInterval);
        });
        
        sliderContainer.addEventListener('mouseleave', () => {
            startInterval();
        });
        
        startInterval();
    }

    // Initialiser les animations de défilement
    function initScrollAnimations() {
        const animateElements = document.querySelectorAll('.feature-card, .editor-preview, .category-card');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        animateElements.forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
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
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
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
                if (this.getAttribute('href') && this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();
                    
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
        }, 10000);
    }

    // Gestionnaires d'événements pour les dropdowns
    window.addEventListener('load', function() {
        setTimeout(centerAndFixDropdowns, 100);
    });
    
    window.addEventListener('resize', function() {
        setTimeout(centerAndFixDropdowns, 50);
    });
    
    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('show.bs.dropdown', function() {
            setTimeout(centerAndFixDropdowns, 10);
        });
        
        toggle.addEventListener('shown.bs.dropdown', function() {
            setTimeout(centerAndFixDropdowns, 50);
        });
    });
    
    window.addEventListener('scroll', function() {
        const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
        if (openDropdowns.length > 0) {
            centerAndFixDropdowns();
        }
    });
    
    // Debounce pour le redimensionnement
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            centerAndFixDropdowns();
            initBootstrapDropdowns();
        }, 150);
    });
    
    // Initialisation finale
    setTimeout(centerAndFixDropdowns, 200);
</script>
<style>
    /* 5 colonnes - 20% chacune */
    .col-md-2-4 {
        width: 20%;
        float: left;
        padding: 0 8px;
        box-sizing: border-box;
    }
    
    /* Clearfix */
    #regionsDropdownContainer::after {
        content: "";
        display: table;
        clear: both;
    }
    
    /* Style minimaliste des cartes */
    .region-card-simple {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 12px;
        border: 1px solid #e9ecef;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .region-card-simple:hover {
        border-color: #007bff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .region-img-wrapper {
        height: 80px;
        overflow: hidden;
        position: relative;
    }
    
    .region-img-simple {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .region-name {
        padding: 10px 8px;
        text-align: center;
        font-size: 0.85rem;
        font-weight: 600;
        color: #333;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }
    
    .region-item-simple {
        text-decoration: none;
        display: block;
        animation: fadeIn 0.3s ease forwards;
        opacity: 0;
    }
    
    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .col-md-2-4 { width: 25%; padding: 0 6px; }
    }
    
    @media (max-width: 992px) {
        .col-md-2-4 { width: 33.333%; padding: 0 5px; }
        .region-img-wrapper { height: 70px; }
    }
    
    @media (max-width: 768px) {
        .col-md-2-4 { width: 50%; padding: 0 4px; }
        .region-img-wrapper { height: 65px; }
        .region-name { font-size: 0.8rem; padding: 8px 4px; }
    }
    
    @media (max-width: 480px) {
        .col-md-2-4 { width: 100%; padding: 0; }
        .region-card-simple { 
            display: flex; 
            align-items: center;
            margin-bottom: 8px;
        }
        .region-img-wrapper { 
            width: 100px; 
            height: 60px; 
            flex-shrink: 0; 
        }
        .region-name { 
            flex-grow: 1; 
            border: none; 
            text-align: left; 
            padding-left: 12px;
            background: white;
        }
    }
    
    /* Loader */
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
    }
    
    /* Dropdown centré */
    .dropdown-menu.full-width {
        min-width: 100vw !important;
    }
</style>
</body>
</html>