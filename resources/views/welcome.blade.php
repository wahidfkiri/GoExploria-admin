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
    <script>
// À placer en tête de page
document.addEventListener('DOMContentLoaded', function() {
    // État verrouillé
    let scrollLocked = true;
    
    // Force brute - bloquer physiquement
    document.body.style.overflow = 'hidden';
    document.documentElement.style.overflow = 'hidden';
    
    // Scroll immédiat et répété
    const lockScroll = () => {
        window.scrollTo(0, 0);
        document.documentElement.scrollTop = 0;
        document.body.scrollTop = 0;
    };
    
    // Appliquer intensément
    lockScroll();
    const intenseInterval = setInterval(lockScroll, 10);
    
    // Observer la position de scroll
    const scrollObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting && scrollLocked) {
                lockScroll();
            }
        });
    }, { threshold: 0 });
    
    // Créer un élément d'ancrage en haut
    const anchor = document.createElement('div');
    anchor.id = 'scroll-anchor';
    anchor.style.position = 'absolute';
    anchor.style.top = '0';
    anchor.style.left = '0';
    anchor.style.width = '1px';
    anchor.style.height = '1px';
    document.body.prepend(anchor);
    scrollObserver.observe(anchor);
    
    // Gérer les iframes
    const iframes = document.querySelectorAll('iframe');
    let loadedCount = 0;
    
    iframes.forEach(iframe => {
        // Désactiver le scroll dans l'iframe
        iframe.style.pointerEvents = 'none';
        
        iframe.addEventListener('load', function() {
            loadedCount++;
            
            // Forcer le scroll dans l'iframe
            try {
                this.contentWindow.scrollTo(0, 0);
                this.contentDocument.body.style.overflow = 'hidden';
            } catch(e) {}
            
            // Activer après chargement
            this.style.pointerEvents = 'auto';
            
            // Quand tous sont chargés
            if (loadedCount === iframes.length) {
                setTimeout(() => {
                    scrollLocked = false;
                    clearInterval(intenseInterval);
                    
                    // Libérer le scroll
                    document.body.style.overflow = 'auto';
                    document.documentElement.style.overflow = 'auto';
                    
                    // Dernier ajustement
                    lockScroll();
                    
                    // Nettoyer
                    scrollObserver.unobserve(anchor);
                    anchor.remove();
                }, 500);
            }
        });
    });
    
    // Sécurité : déverrouiller après 3s
    setTimeout(() => {
        if (scrollLocked) {
            scrollLocked = false;
            clearInterval(intenseInterval);
            document.body.style.overflow = 'auto';
            document.documentElement.style.overflow = 'auto';
        }
    }, 3000);
});
</script>
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <style>
        /* Style pour le bouton retour en haut */
        .back-to-top {
            position: fixed;
            bottom: 100px;
            right: 35px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            transform: translateY(-10px);
        }
        
        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .back-to-top:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
        }
        
        /* Styles pour le méga-menu */
        .mega-menu-container {
            position: relative;
            display: inline-block;
        }
        
        .mega-menu {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(15px);
            width: 1100px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            padding: 30px;
            z-index: 1050;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }
        
        .mega-menu-container:hover .mega-menu {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }
        
        .mega-menu-column h4 {
            color: var(--dark-color);
            font-size: 1.1rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
        }
        
        .mega-menu-link {
            display: flex;
            align-items: center;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            transition: all 0.2s ease;
            background: #f9f9f9;
        }
        
        .mega-menu-link:hover {
            background: var(--primary-color);
            color: white;
            transform: translateX(5px);
        }
        
        .mega-menu-image {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            margin-right: 15px;
            object-fit: cover;
            transition: all 0.2s ease;
        }
        
        .mega-menu-text {
            flex: 1;
        }
        
        .mega-menu-text h6 {
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .mega-menu-text p {
            font-size: 0.8rem;
            opacity: 0.8;
            margin: 0;
        }
        
        .mega-menu-highlight {
            grid-column: span 2;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 10px;
            padding: 25px;
            color: white;
            margin-top: 10px;
        }
        
        .mega-menu-highlight h4 {
            color: white;
            border-bottom-color: rgba(255,255,255,0.3);
        }
        
        .highlight-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
        }
        
        .highlight-icon {
            font-size: 1.5rem;
            margin-right: 15px;
        }
        
        /* Footer avec photo de fond filtrée */
        .footer-with-bg {
            position: relative;
            background-color: var(--dark-color);
            color: white;
            padding: 80px 0 30px;
            overflow: hidden;
        }
        
        .footer-bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
            opacity: 0.15;
            filter: blur(2px) grayscale(30%) brightness(0.7);
        }
        
        .footer-content {
            position: relative;
            z-index: 2;
        }
        
        .footer-logo {
            height: 70px;
            margin-bottom: 25px;
            filter: brightness(0) invert(1);
        }
        
        .footer-social-icons {
            margin-top: 25px;
        }
        
        .footer-social-icons a {
            display: inline-block;
            margin-right: 15px;
            color: white;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .footer-social-icons a:hover {
            color: var(--accent-color);
            transform: translateY(-3px);
        }
        
        .footer-section-title {
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
            color: white;
            padding-left: 5px;
        }
        
        .footer-contact li {
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
        }
        
        .footer-contact i {
            margin-right: 10px;
            color: var(--accent-color);
            margin-top: 3px;
        }
        
        .footer-buttons {
            margin-top: 25px;
        }
        
        .footer-copyright {
            text-align: center;
            padding-top: 40px;
            margin-top: 40px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.7);
            font-size: 0.95rem;
            position: relative;
            z-index: 2;
        }
        
        /* Styles pour le nouveau header avec bande défilante */
        .info-header {
            background: linear-gradient(90deg, #1a3a5f 0%, #2c5282 50%, #1a3a5f 100%);
            padding: 8px 0;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .info-header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .left-info-items {
            display: flex;
            gap: 20px;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
            transition: all 0.3s ease;
            padding: 4px 12px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .info-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .info-icon {
            margin-right: 8px;
            font-size: 0.9rem;
        }
        
        .info-label {
            font-weight: 600;
            font-size: 0.85rem;
            margin-right: 4px;
        }
        
        .info-value {
            font-size: 0.85rem;
        }
        
        .info-up {
            color: #4ade80;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .info-down {
            color: #f87171;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .info-details {
            font-size: 0.8rem;
            opacity: 0.9;
        }
        
        /* Bande défilante des voyageurs */
        .travel-marquee-container {
            flex: 1;
            overflow: hidden;
            position: relative;
            margin: 0 20px;
            height: 24px;
            display: flex;
            align-items: center;
        }
        
        .travel-marquee {
            display: inline-block;
            white-space: nowrap;
            animation: marquee 65s linear infinite;
            padding-left: 100%;
        }
        
        .travel-marquee:hover {
            animation-play-state: paused;
        }
        
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-100%);
            }
        }
        
        .travel-message {
            display: inline-flex;
            align-items: center;
            margin: 0 30px;
            font-size: 0.85rem;
            color: white;
        }
        
        .travel-icon {
            margin-right: 8px;
            color: #fbbf24;
            font-size: 0.9rem;
        }
        
        .travel-text {
            position: relative;
        }
        
        .travel-text::after {
            content: "•";
            margin-left: 30px;
            color: rgba(255, 255, 255, 0.3);
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .mega-menu {
                width: 95vw;
                grid-template-columns: repeat(2, 1fr);
            }
            
            .mega-menu-highlight {
                grid-column: span 2;
            }
            
            .travel-marquee {
                animation: marquee 65s linear infinite;
            }
        }
        
        @media (max-width: 992px) {
            .mega-menu {
                width: 95vw;
                left: 50%;
                transform: translateX(-50%) translateY(15px);
                grid-template-columns: repeat(2, 1fr);
                padding: 20px;
            }
            
            .mega-menu-container:hover .mega-menu {
                transform: translateX(-50%) translateY(0);
            }
            
            .footer-with-bg {
                padding: 60px 0 25px;
            }
            
            .info-header .container {
                flex-direction: column;
                gap: 10px;
            }
            
            .left-info-items {
                justify-content: center;
                width: 100%;
            }
            
            .travel-marquee-container {
                width: 100%;
                margin: 10px 0;
                order: 3;
            }
        }
        
        @media (max-width: 768px) {
            .back-to-top {
                width: 45px;
                height: 45px;
                font-size: 1.3rem;
                bottom: 250px;
                right: 15px;
            }
            
            .mega-menu {
                width: 90vw;
            }
            
            .footer-with-bg {
                padding: 50px 0 20px;
            }
            
            .footer-logo {
                height: 60px;
            }
            
            .left-info-items {
                flex-direction: column;
                gap: 8px;
            }
            
            .info-item {
                justify-content: center;
                width: 100%;
                max-width: 250px;
            }
            
            .travel-marquee {
                animation: marquee 55s linear infinite;
            }
            
            .travel-message {
                margin: 0 15px;
            }
        }
        
        @media (max-width: 576px) {
            .mega-menu {
                grid-template-columns: 1fr;
                width: 85vw;
            }
            
            .mega-menu-highlight {
                grid-column: span 1;
            }
            
            .travel-marquee {
                animation: marquee 50s linear infinite;
            }
            
            .travel-text::after {
                margin-left: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Bouton retour en haut -->
    <button class="back-to-top" id="backToTop" aria-label="Retour en haut">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Header avec informations en temps réel et bande défilante -->
    <header class="info-header" id="myScrollableContainer">
        <div class="container">
            <!-- Bourse et Météo à gauche -->
            <div class="left-info-items">
                <a href="#iframe-page-meteo-1" class="info-item">
                    <i class="fas fa-chart-line info-icon"></i>
                    <span class="info-label">Bourse TSX:</span>
                    <span class="info-value ms-1">21,450.12</span>
                    <span class="info-up ms-1">+1.2%</span>
                </a>
                <a href="#iframe-page-meteo-1" class="info-item">
                    <i class="fas fa-cloud-sun info-icon"></i>
                    <span class="info-label">Météo QC:</span>
                    <span class="info-value ms-1">-5°C</span>
                    <span class="info-details ms-1">Ensoleillé</span>
                </a>
            </div>
            
            <!-- Bande défilante avec messages aux voyageurs -->
            <div class="travel-marquee-container">
                <div class="travel-marquee">
                    <div class="travel-message">
                        <i class="fas fa-plane travel-icon"></i>
                        <span class="travel-text">✈️ Explorez les magnifiques paysages du Québec cet été !</span>
                    </div>
                    <div class="travel-message">
                        <i class="fas fa-snowflake travel-icon"></i>
                        <span class="travel-text">❄️ Stations de ski ouvertes - Profitez de la poudreuse fraîche !</span>
                    </div>
                    <div class="travel-message">
                        <i class="fas fa-map-marked-alt travel-icon"></i>
                        <span class="travel-text">🗺️ Découvrez nos itinéraires touristiques exclusifs</span>
                    </div>
                    <div class="travel-message">
                        <i class="fas fa-utensils travel-icon"></i>
                        <span class="travel-text">🍽️ Goûtez à la cuisine québécoise authentique dans nos restaurants partenaires</span>
                    </div>
                    <div class="travel-message">
                        <i class="fas fa-tags travel-icon"></i>
                        <span class="travel-text">🏷️ Offres spéciales vacances - Jusqu'à 30% de réduction</span>
                    </div>
                    <div class="travel-message">
                        <i class="fas fa-calendar-alt travel-icon"></i>
                        <span class="travel-text">📅 Événements à venir : Festival d'été de Québec, Fête nationale et plus !</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Top Bar avec méga-menu -->
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

                <div class="item-btns">
                    <!-- Bouton Services Web avec méga-menu -->
                    <div class="mega-menu-container">
                        <button class="btn btn-sm btn-primary me-2" id="servicesWebBtn">
                            <i class="fas fa-globe me-1"></i>Services Web
                        </button>
                        
                        <!-- Méga-menu -->
                        <div class="mega-menu" id="webServicesMegaMenu">
                            <!-- Colonne 1 : Création Web -->
                            <div class="mega-menu-column">
                                <h4>Création Web</h4>
                                <a href="#iframe-page-web-1" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=400&fit=crop" class="mega-menu-image" alt="Sites Vitrine">
                                    <div class="mega-menu-text">
                                        <h6>Sites Vitrine</h6>
                                        <p>Présence en ligne professionnelle</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=400&h=400&fit=crop" class="mega-menu-image" alt="E-commerce">
                                    <div class="mega-menu-text">
                                        <h6>E-commerce</h6>
                                        <p>Boutique en ligne complète</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1499951360447-b19be8fe80f5?w=400&h=400&fit=crop" class="mega-menu-image" alt="Blogs & CMS">
                                    <div class="mega-menu-text">
                                        <h6>Blogs & CMS</h6>
                                        <p>Plateformes de contenu</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1551650975-87deedd944c3?w=400&h=400&fit=crop" class="mega-menu-image" alt="Applications Web">
                                    <div class="mega-menu-text">
                                        <h6>Applications Web</h6>
                                        <p>Solutions sur mesure</p>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Colonne 2 : Marketing Digital -->
                            <div class="mega-menu-column">
                                <h4>Marketing Digital</h4>
                                <a href="#" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=400&fit=crop" class="mega-menu-image" alt="SEO">
                                    <div class="mega-menu-text">
                                        <h6>SEO</h6>
                                        <p>Optimisation pour moteurs</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&h=400&fit=crop" class="mega-menu-image" alt="Publicité en Ligne">
                                    <div class="mega-menu-text">
                                        <h6>Publicité en Ligne</h6>
                                        <p>Google Ads, Facebook Ads</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&h=400&fit=crop" class="mega-menu-image" alt="Analyse Web">
                                    <div class="mega-menu-text">
                                        <h6>Analyse Web</h6>
                                        <p>Google Analytics, tracking</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1545235617-9465d2a55698?w=400&h=400&fit=crop" class="mega-menu-image" alt="Email Marketing">
                                    <div class="mega-menu-text">
                                        <h6>Email Marketing</h6>
                                        <p>Campagnes automatiques</p>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Colonne 3 : Hébergement & Support -->
                            <div class="mega-menu-column">
                                <h4>Hébergement & Support</h4>
                                <a href="#" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=400&h=400&fit=crop" class="mega-menu-image" alt="Hébergement Web">
                                    <div class="mega-menu-text">
                                        <h6>Hébergement Web</h6>
                                        <p>Serveurs performants</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1556075798-4825dfaaf498?w=400&h=400&fit=crop" class="mega-menu-image" alt="Sécurité SSL">
                                    <div class="mega-menu-text">
                                        <h6>Sécurité SSL</h6>
                                        <p>Certificats de sécurité</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=400&h=400&fit=crop" class="mega-menu-image" alt="Maintenance">
                                    <div class="mega-menu-text">
                                        <h6>Maintenance</h6>
                                        <p>Mises à jour régulières</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=400&h=400&fit=crop" class="mega-menu-image" alt="Support 24/7">
                                    <div class="mega-menu-text">
                                        <h6>Support 24/7</h6>
                                        <p>Assistance technique</p>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Colonne 4 : Solutions Entreprise -->
                            <div class="mega-menu-column">
                                <h4>Solutions Entreprise</h4>
                                <a href="#" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=400&fit=crop" class="mega-menu-image" alt="ERP & CRM">
                                    <div class="mega-menu-text">
                                        <h6>ERP & CRM</h6>
                                        <p>Systèmes de gestion intégrés</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&h=400&fit=crop" class="mega-menu-image" alt="Réseaux Sociaux">
                                    <div class="mega-menu-text">
                                        <h6>Gestion Réseaux Sociaux</h6>
                                        <p>Stratégie et publication</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400&h=400&fit=crop" class="mega-menu-image" alt="Formation">
                                    <div class="mega-menu-text">
                                        <h6>Formation Digital</h6>
                                        <p>Formation à vos outils</p>
                                    </div>
                                </a>
                                
                                <a href="#" class="mega-menu-link">
                                    <img src="https://images.unsplash.com/photo-1533750349088-cd871a92f312?w=400&h=400&fit=crop" class="mega-menu-image" alt="Consultation">
                                    <div class="mega-menu-text">
                                        <h6>Consultation Stratégique</h6>
                                        <p>Audit et recommandations</p>
                                    </div>
                                </a>
                            </div>

                            
                        <div>
                            <a href="">Voir nos plans d'affichages</a>
                        </div>
                            
                        </div>
                    </div>
                    
                    <a href="#info-forfaits-go-exploria" class="btn btn-sm btn-secondary">
                        <i class="fas fa-list me-1"></i>Nos plans
                    </a>
                </div>
                
                <div class="top-bar-icons">
                    
                    <!-- Mon compte -->
                    <a href="{{route('register')}}" class="top-bar-icon">
                        <i class="fas fa-user-plus"></i>
                        <span>S'inscrire</span>
                    </a>
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
                    <!-- Panier -->
                    <a href="#" class="top-bar-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Panier</span>
                    </a>
                    <!-- Panier -->
                    <a href="#" class="top-bar-icon">
                        <i class="fas fa-heart"></i>
                        <span>Favoris</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('components.front.navbar')
    @include('components.front.slideshows')

    <!-- Video Slider Full Width -->
    <section class="video-slider-section d-none">
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

    <!-- resources/views/main.blade.php -->
    @foreach(\App\Models\Menu::where('is_active', true)->where('has_page', true)->whereNull('parent_id')->orderBy('order','ASC')->get() as $page)
    <iframe 
        id="{{$page->slug}}"
        src="{{ url('/theme/'.$page->slug.'/preview') }}" 
        width="100%" 
        style="border:0; overflow:hidden;"
        scrolling="no">
    </iframe>
    @endforeach
    
    <!-- Marketing -->
    <iframe 
        id="iframe-page-web-1"
        src="{{ url('/theme/web/page-1') }}" 
        width="100%" 
        style="border:0; overflow:hidden;"
        scrolling="no">
    </iframe>

    <!-- <iframe 
        id="iframe-page-meteo-1"
        src="{{ url('/theme/meteo/page-1') }}" 
        width="100%" 
        style="border:0; overflow:hidden;"
        scrolling="no">
    </iframe> -->

    <!-- Business -->
    <iframe 
        id="business-tourism"
        src="{{ url('/theme/business/page-1') }}" 
        width="100%" 
        style="border:0; overflow:hidden;"
        scrolling="no">
    </iframe>

    <script>
    window.addEventListener('message', function(event) {
        if (!event.data || event.data.type !== 'setHeight') return;

        const iframeId = event.data.iframeId;
        const height   = event.data.height;

        const iframe = document.getElementById(iframeId);
        if (iframe) {
            iframe.style.height = height + 'px';
        }
    });
    </script>

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
    <section class="clients-section d-none" id="clients">
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
    
    @include('components.front.call-action')
    @include('chat.index')

    <!-- Footer avec photo de fond filtrée -->
   @include('components.front.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    let resizing = false;

    window.addEventListener('message', function(event) {
        if (!event.data || event.data.type !== 'setHeight') return;

        resizing = true;

        const iframe = document.getElementById(event.data.iframeId);
        if (iframe) {
            iframe.style.height = event.data.height + 'px';
        }

        // Restore scroll to top if first load
        if (resizing) {
            window.scrollTo({ top: 0, behavior: 'instant' });
            resizing = false;
        }
    });

    // Script pour le bouton retour en haut
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopButton = document.getElementById('backToTop');
        
        // Afficher/masquer le bouton selon le défilement
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });
        
        // Retour en haut avec animation fluide
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Script pour fermer le méga-menu en cliquant ailleurs
        document.addEventListener('click', function(event) {
            const megaMenu = document.getElementById('webServicesMegaMenu');
            const servicesBtn = document.getElementById('servicesWebBtn');
            
            if (megaMenu && servicesBtn) {
                if (!megaMenu.contains(event.target) && !servicesBtn.contains(event.target)) {
                    megaMenu.style.opacity = '0';
                    megaMenu.style.visibility = 'hidden';
                    megaMenu.style.transform = 'translateX(-50%) translateY(15px)';
                }
            }
        });
        
        // Ouvrir/fermer le méga-menu au clic sur mobile
        const servicesBtn = document.getElementById('servicesWebBtn');
        const megaMenu = document.getElementById('webServicesMegaMenu');
        
        if (servicesBtn && megaMenu) {
            servicesBtn.addEventListener('click', function(event) {
               // if (window.innerWidth < 992) {
                    event.preventDefault();
                    const isVisible = megaMenu.style.opacity === '1';
                    
                    if (isVisible) {
                        megaMenu.style.opacity = '0';
                        megaMenu.style.visibility = 'hidden';
                        megaMenu.style.transform = 'translateX(-50%) translateY(15px)';
                    } else {
                        megaMenu.style.opacity = '1';
                        megaMenu.style.visibility = 'visible';
                        megaMenu.style.transform = 'translateX(-50%) translateY(0)';
                    }
               // }
            });
        }
        
        // Mettre à jour l'année dynamiquement
        function updateCurrentYear() {
            const currentYear = new Date().getFullYear();
            document.getElementById('currentYear').textContent = currentYear;
        }
        
        // Appeler la fonction au chargement
        updateCurrentYear();
        
        // Dupliquer le contenu de la bande défilante pour un défilement fluide
        const marqueeContent = document.querySelector('.travel-marquee').innerHTML;
        document.querySelector('.travel-marquee').innerHTML += marqueeContent + marqueeContent;
    });
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