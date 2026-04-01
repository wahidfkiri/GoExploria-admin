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
            width: auto;
            max-width: 90vw;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(0, 0, 0, 0.05);
            padding: 25px;
            z-index: 1050;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            border: 1px solid #e0e0e0;
        }
        
        .mega-menu-container:hover .mega-menu {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(10px);
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
            width: 100px;
            height: 100px;
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
        
        /* Style spécifique pour le méga-menu templates */
        .mega-menu-templates {
            width: 1200px !important;
            max-width: 95vw !important;
            grid-template-columns: repeat(4, 1fr) !important;
            gap: 20px !important;
            padding: 25px !important;
        }
        
        .mega-menu-templates .mega-menu-column {
            margin-bottom: 20px;
        }
        
        .mega-menu-templates .mega-menu-column h4 {
            font-size: 1rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .mega-menu-templates .mega-menu-column h4 i {
            color: var(--primary-color);
            font-size: 0.9rem;
        }
        
        .mega-menu-templates .mega-menu-link:hover .mega-menu-image {
            transform: scale(1.05);
        }
        
        /* CSS pour les nouveaux menus de la top bar */
        
        /* Mega menu link simple pour Devises */
        .mega-menu-link-simple {
            display: flex;
            align-items: center;
            padding: 14px 18px;
            text-decoration: none;
            color: #2c3e50;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin-bottom: 8px;
            background:#3498db ;
            border: 1px solid #e9ecef;
        }
        
        .mega-menu-link-simple:hover {
            background: #3498db;
            color: white;
            transform: translateX(5px);
            border-color: #2980b9;
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.25);
        }
        
        .mega-menu-link-simple i {
            width: 24px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        /* Mega menu Devises */
        .mega-menu-devises {
            min-width: 250px !important;
            width: 250px !important;
            padding: 20px !important;
            grid-template-columns: 1fr !important;
            display: flex !important;
            flex-direction: column !important;
        }
        
        /* Mega menu Inscription */
        .mega-menu-inscription {
            width: 650px !important;
            max-width: 90vw !important;
            padding: 30px !important;
            display: block !important;
        }
        
        .inscription-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        
        .inscription-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 22px 18px;
            background: #2980b9;
            border-radius: 12px;
            text-decoration: none;
            color: #e9ecef;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: 2px solid #e9ecef;
            text-align: center;
            min-height: 120px;
        }
        
        .inscription-item:hover {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border-color: #2980b9;
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
        }
        
        .inscription-item i {
            font-size: 2.2rem;
            margin-bottom: 12px;
            opacity: 0.9;
        }
        
        .inscription-item:hover i {
            opacity: 1;
        }
        
        .inscription-item span {
            line-height: 1.4;
            font-size: 0.88rem;
        }
        
        /* Mega menu Langue */
        .mega-menu-langue {
            min-width: 450px !important;
            width: 450px !important;
            max-width: 90vw !important;
            padding: 35px !important;
            display: block !important;
        }
        
        .mega-menu-langue h4 {
            color: #2c3e50 !important;
            font-weight: 700 !important;
            margin-bottom: 15px !important;
        }
        
        .mega-menu-langue p {
            color: #7f8c8d !important;
            line-height: 1.7 !important;
        }
        
        /* Mega menu Panier */
        .mega-menu-panier {
            min-width: 380px !important;
            width: 380px !important;
            max-width: 90vw !important;
            padding: 40px 35px !important;
            display: block !important;
        }
        
        .mega-menu-panier h5 {
            color: #2c3e50 !important;
            font-weight: 700 !important;
        }
        
        .mega-menu-panier p {
            color: #7f8c8d !important;
        }
        
        /* Mega menu Favoris */
        .mega-menu-favoris {
            min-width: 380px !important;
            width: 380px !important;
            max-width: 90vw !important;
            padding: 40px 35px !important;
            display: block !important;
            left: auto !important;
            right: 0 !important;
            transform: translateX(0) translateY(15px) !important;
        }
        
        .mega-menu-container:hover .mega-menu-favoris {
            transform: translateX(0) translateY(10px) !important;
        }
        
        .mega-menu-favoris h5 {
            color: #2c3e50 !important;
            font-weight: 700 !important;
        }
        
        .mega-menu-favoris p {
            color: #7f8c8d !important;
        }
        
        /* Ajustements pour les boutons de la top bar */
        .item-btns .btn {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
        }
        
        /* Mega menu Info combiné */
        .mega-menu-info-combined {
            min-width: 320px !important;
            width: 320px !important;
            max-width: 90vw !important;
            padding: 20px !important;
            grid-template-columns: 1fr !important;
            display: flex !important;
            flex-direction: column !important;
        }
        
        /* Animation pour les mega menus */
        .mega-menu-container:hover .mega-menu-info-combined,
        .mega-menu-container:hover .mega-menu-devises,
        .mega-menu-container:hover .mega-menu-inscription,
        .mega-menu-container:hover .mega-menu-langue,
        .mega-menu-container:hover .mega-menu-panier,
        .mega-menu-container:hover .mega-menu-favoris {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(10px);
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
        
        /* Bande publicitaire en haut du header */
        .header-ad-banner {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 50%, #ff6b6b 100%);
            color: white;
            text-align: center;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            position: relative;
            overflow: hidden;
            z-index: 999;
        }
        
        .header-ad-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        /* Styles pour le nouveau header avec bande défilante */
        .info-header {
            background: linear-gradient(90deg, #1a3a5f 0%, #2c5282 50%, #1a3a5f 100%);
            padding: 6px 0;
            color: white;
            position: relative;
            overflow: visible;
            z-index: 1000;
        }
        
        .info-header .container {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        
        /* Layout principal du header */
        .header-content-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            gap: 20px;
            max-width: 100%;
            margin: 0 auto;
        }
        
        /* Barre de 6 boutons rectangulaires de navigation */
        .header-icons-bar {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 15px;
            flex-wrap: nowrap;
            overflow-x: auto;
            overflow-y: hidden;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        
        .header-icons-bar::-webkit-scrollbar {
            display: none;
        }
        
        .header-icon-container {
            position: relative;
        }
        
        .header-icon-container:hover .header-mega-menu {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateX(-50%) translateY(0) !important;
        }
        
        .header-icon-link {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
            background: transparent;
            padding: 8px 15px;
            transition: all 0.3s ease;
        }
        
        .header-icon-link:hover {
            transform: translateY(-2px);
        }
        
        .icon-image {
            width: 50px;
            height: 50px;
            object-fit: contain;
            flex-shrink: 0;
        }
        
        /* Icône Info plus grosse à gauche avec animation flash */
        .icon-image-info {
            width: 70px !important;
            height: 70px !important;
            order: -1;
            animation: flash-info 2s infinite;
        }
        
        @keyframes flash-info {
            0%, 50%, 100% {
                opacity: 1;
            }
            25%, 75% {
                opacity: 0.4;
            }
        }
        
        .header-icon-link-info {
            order: -1;
        }
        
        .icon-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            opacity: 0.95;
        }
        
        /* Mega Menu Header - Layout Professionnel avec Scroll */
        .header-mega-menu {
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%) translateY(15px);
            width: 1400px;
            max-width: 95vw;
            max-height: 600px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 0;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 2000;
            border: 2px solid #e0e0e0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .mega-menu-trigger:hover .header-mega-menu {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }
        
        /* Ticker Bourse/Météo en haut */
        .mega-menu-ticker {
            background: linear-gradient(135deg, #1a3a5f 0%, #2c5282 100%);
            color: white;
            padding: 10px 20px;
            display: flex;
            gap: 30px;
            overflow: hidden;
            border-bottom: 2px solid #3498db;
        }
        
        .ticker-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            white-space: nowrap;
            text-decoration: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .ticker-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: scale(1.05);
        }
        
        .ticker-item i {
            font-size: 1rem;
            color: #ffd700;
        }
        
        .ticker-up {
            color: #2ecc71;
            font-weight: 700;
        }
        
        /* Contenu principal : 3 Colonnes + Carrousel */
        .mega-menu-main-content {
            display: flex;
            gap: 20px;
            padding: 20px;
            box-sizing: border-box;
            overflow-y: auto;
            overflow-x: hidden;
            flex: 1;
        }
        
        .mega-menu-main-content::-webkit-scrollbar {
            width: 8px;
        }
        
        .mega-menu-main-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .mega-menu-main-content::-webkit-scrollbar-thumb {
            background: #3498db;
            border-radius: 10px;
        }
        
        .mega-menu-main-content::-webkit-scrollbar-thumb:hover {
            background: #2980b9;
        }
        
        /* Container des 5 colonnes */
        .mega-menu-columns-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            flex: 1;
        }
        
        /* Colonne verticale */
        .mega-menu-column {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        /* Item avec image carrée + nom */
        .mega-menu-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            padding: 15px 10px;
            border-radius: 8px;
            background: #f8f9fa;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        
        .mega-menu-item:hover {
            background: #ffffff;
            border-color: #3498db;
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.2);
        }
        
        /* Image carrée */
        .mega-menu-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        /* Label du menu */
        .mega-menu-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #2c3e50;
            line-height: 1.2;
            text-align: center;
        }
        
        /* Boutons de catégorie en bas */
        .mega-menu-category-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 12px;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            margin-top: 8px;
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
        }
        
        .mega-menu-category-btn:hover {
            background: linear-gradient(135deg, #2980b9 0%, #21618c 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
            color: white;
        }
        
        /* Section des 3 menus en bas */
        .mega-menu-bottom-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            padding: 15px 20px;
            background: #f8f9fa;
            border-top: 2px solid #e0e0e0;
        }
        
        .mega-menu-bottom-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 15px;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
        }
        
        .mega-menu-bottom-item:hover {
            background: linear-gradient(135deg, #2980b9 0%, #21618c 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
            color: white;
        }
        
        .mega-menu-bottom-item i {
            font-size: 1.1rem;
        }
        
        /* Carrousel Vidéo/Photo - Défilement Vertical */
        .mega-menu-carousel {
            width: 260px;
            min-width: 260px;
            max-width: 260px;
            position: relative;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            flex-shrink: 0;
            align-self: stretch;
            box-sizing: border-box;
        }
        
        .carousel-scroll-container {
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }
        
        .carousel-item-simple {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }
        
        .carousel-item-simple.active {
            opacity: 1;
            z-index: 1;
            pointer-events: auto;
        }
        
        .carousel-item-simple img,
        .carousel-item-simple > div {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0;
        }
        
        .carousel-indicators {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 10;
        }
        
        .carousel-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .carousel-dot.active {
            background: #3498db;
            width: 30px;
            border-radius: 5px;
        }
        
        /* Boutons de navigation */
        .carousel-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.9);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 20;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        .carousel-nav-btn:hover {
            background: #3498db;
            color: white;
            transform: translateY(-50%) scale(1.1);
        }
        
        .carousel-nav-btn.prev {
            left: 10px;
        }
        
        .carousel-nav-btn.next {
            right: 10px;
        }
        
        .carousel-nav-btn i {
            font-size: 18px;
        }
        
        .carousel-scroll-container::-webkit-scrollbar {
            width: 6px;
        }
        
        .carousel-scroll-container::-webkit-scrollbar-track {
            background: #1a1a2e;
        }
        
        .carousel-scroll-container::-webkit-scrollbar-thumb {
            background: #3498db;
            border-radius: 3px;
        }
        
        .carousel-scroll-container::-webkit-scrollbar-thumb:hover {
            background: #2980b9;
        }
        
        .carousel-item {
            position: relative;
            width: 100%;
            min-height: 150px;
            height: 150px;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            flex-shrink: 0;
            background: #000;
        }
        
        .carousel-item:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(52, 152, 219, 0.4);
            z-index: 10;
        }
        
        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: all 0.4s ease;
        }
        
        .carousel-item:hover img {
            transform: scale(1.1);
            filter: brightness(1.1);
        }
        
        .play-overlay,
        .zoom-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 3.5rem;
            color: white;
            opacity: 0;
            transition: all 0.3s ease;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.7);
            pointer-events: none;
        }
        
        .carousel-item:hover .play-overlay,
        .carousel-item:hover .zoom-overlay {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1.2);
        }
        
        .play-overlay i {
            color: #ff0000;
            filter: drop-shadow(0 0 10px rgba(255, 0, 0, 0.5));
        }
        
        .zoom-overlay i {
            color: #3498db;
            filter: drop-shadow(0 0 10px rgba(52, 152, 219, 0.5));
        }
        
        /* Boutons de navigation */
        .carousel-nav {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 40px;
            background: rgba(52, 152, 219, 0.9);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 100;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        
        .carousel-nav:hover {
            background: #2980b9;
            transform: translateX(-50%) scale(1.1);
        }
        
        .carousel-prev {
            top: 10px;
        }
        
        .carousel-next {
            bottom: 10px;
        }
        
        /* Modal pour vidéo/image en grand */
        .media-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            z-index: 10000;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .modal-content-wrapper {
            position: relative;
            width: 90%;
            max-width: 1200px;
            height: 80%;
            background: #000;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);
        }
        
        .modal-close {
            position: absolute;
            top: -50px;
            right: 0;
            background: transparent;
            border: none;
            color: white;
            font-size: 3rem;
            cursor: pointer;
            z-index: 10001;
            transition: all 0.3s ease;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-close:hover {
            color: #3498db;
            transform: scale(1.2);
        }
        
        #modalMediaContainer {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
        }
        
        #modalMediaContainer iframe {
            border: none;
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
        }
        
        .travel-icon-img {
            width: 20px;
            height: 20px;
            margin-right: 8px;
            object-fit: contain;
            font-size: 0.9rem;
        }
        
        .travel-end-img {
            width: 16px;
            height: 16px;
            margin-left: 8px;
            object-fit: contain;
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
            
            .mega-menu-templates {
                grid-template-columns: repeat(2, 1fr) !important;
                width: 95vw !important;
            }
            
            .mega-menu-main-content {
                flex-direction: column;
            }
            
            .mega-menu-icons-container {
                flex-direction: column;
            }
            
            .mega-menu-carousel {
                width: 100%;
            }
            
            .header-mega-menu {
                width: 92vw;
            }
            
            .header-content-wrapper {
                gap: 20px;
            }
            
            .mega-icon-circle {
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
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
            
            .mega-menu-templates {
                grid-template-columns: 1fr !important;
            }
            
            .header-content-wrapper {
                flex-direction: column;
                gap: 15px;
            }
            
            .left-info-items {
                width: 100%;
                justify-content: center;
            }
            
            .header-icons-bar {
                gap: 20px;
                flex-wrap: wrap;
            }
            
            .icon-circle {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }
            
            .icon-label {
                font-size: 0.75rem;
            }
            
            .mega-menu-icons-vertical {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }
            
            .header-mega-menu {
                width: 95vw;
            }
            
            .mega-menu-main-content {
                padding: 15px;
            }
            
            .mega-icon-circle {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }
            
            .mega-icon-label {
                font-size: 0.6rem;
            }
            
            .mega-menu-ticker {
                padding: 8px 15px;
                font-size: 0.75rem;
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
</head>
<body>
    <!-- Bouton retour en haut -->
    <button class="back-to-top" id="backToTop" aria-label="Retour en haut">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Bande publicitaire en haut du header -->
    <div class="header-ad-banner">
        <i class="fas fa-star me-2"></i>
        <strong>OFFRE SPÉCIALE :</strong> Profitez de -30% sur tous nos forfaits voyage jusqu'au 31 mars !
        <i class="fas fa-star ms-2"></i>
    </div>

    <!-- Header avec infos et navigation -->
    <header class="info-header" id="myScrollableContainer">
        <div class="container">
            <div class="header-content-wrapper">
                <!-- Barre de 5 icônes de navigation -->
                <div class="header-icons-bar" style="flex-shrink: 0;">
                <!-- Bouton 1: Info avec Mega Menu - Icône à gauche avec animation flash -->
                <div class="header-icon-container mega-menu-trigger">
                    <a href="#" class="header-icon-link header-icon-link-info" id="infoIconBtn">
                        <img src="{{asset('header_info/info.png')}}" alt="Info" class="icon-image icon-image-info">
                        <span class="icon-label">Info</span>
                    </a>
                    
                    <!-- Mega Menu Info - Layout Complet -->
                    <div class="header-mega-menu" id="infoMegaMenu">
                        <!-- Défilement Bourse/Météo en haut - Cliquable -->
                        <div class="mega-menu-ticker">
                            <a href="#iframe-page-meteo-1" class="ticker-item">
                                <i class="fas fa-chart-line"></i>
                                <span>Bourse TSX: 21,450.12 <span class="ticker-up">+1.2%</span></span>
                            </a>
                            <a href="#iframe-page-meteo-1" class="ticker-item">
                                <i class="fas fa-cloud-sun"></i>
                                <span>Météo QC: -5°C Ensoleillé</span>
                            </a>
                            <a href="#iframe-page-meteo-1" class="ticker-item">
                                <i class="fas fa-chart-line"></i>
                                <span>Bourse TSX: 21,450.12 <span class="ticker-up">+1.2%</span></span>
                            </a>
                            <a href="#iframe-page-meteo-1" class="ticker-item">
                                <i class="fas fa-cloud-sun"></i>
                                <span>Météo QC: -5°C Ensoleillé</span>
                            </a>
                        </div>
                        
                        <!-- Contenu principal : 3 Colonnes + Carrousel -->
                        <div class="mega-menu-main-content">
                            <!-- Container des 5 colonnes -->
                            <div class="mega-menu-columns-container">
                                <!-- Colonne 1 - 6 items -->
                                <div class="mega-menu-column">
                                    <a href="{{url('/landing/accessibilite')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/k-roule-acces-andicape-quebec.png')}}" alt="Accessibilité" class="mega-menu-image">
                                        <span class="mega-menu-label">Accessibilité</span>
                                    </a>
                                    <a href="{{url('/landing/ambulance')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/AMBULANCE-911-QUEBEC.png')}}" alt="Ambulance" class="mega-menu-image">
                                        <span class="mega-menu-label">Ambulance 911</span>
                                    </a>
                                    <a href="{{url('/landing/defibrillateur')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/borne-defibrilateur-urgence.png')}}" alt="Défibrillateur" class="mega-menu-image">
                                        <span class="mega-menu-label">Défibrillateur</span>
                                    </a>
                                    <a href="{{url('/landing/circuits')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/CIRCUITS-TOURSITIQUES-QUEBEC.png')}}" alt="Circuits" class="mega-menu-image">
                                        <span class="mega-menu-label">Circuits</span>
                                    </a>
                                   
                                    <a href="{{url('/landing/evenements')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/EVENEMENTS-QUEBEC.png')}}" alt="Événements" class="mega-menu-image">
                                        <span class="mega-menu-label">Événements</span>
                                    </a>
                                </div>
                                
                                <!-- Colonne 2 - 5 items -->
                                <div class="mega-menu-column">
                                    <a href="{{url('/landing/fabrique-quebec')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/fabriquer-au-quebec.png')}}" alt="Fabriqué" class="mega-menu-image">
                                        <span class="mega-menu-label">Fabriqué Québec</span>
                                    </a>
                                    <a href="{{url('/landing/info-tourisme')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/INFO-TOURISME.png')}}" alt="Info" class="mega-menu-image">
                                        <span class="mega-menu-label">Info Tourisme</span>
                                    </a>
                                    <a href="{{url('/landing/transport')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/MOYEN-TRANSPORT-QUEBEC.png')}}" alt="Transport" class="mega-menu-image">
                                        <span class="mega-menu-label">Transport</span>
                                    </a>
                                    <a href="{{url('/landing/gare-train')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/GARE-DE-TRAIN-QUEBEC.png')}}" alt="Gare" class="mega-menu-image">
                                        <span class="mega-menu-label">Gare Train</span>
                                    </a>
                                   
                                </div>
                                
                                <!-- Colonne 3 - 5 items -->
                                <div class="mega-menu-column">
                                    <a href="{{url('/landing/garage')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/GARAGE.png')}}" alt="Garage" class="mega-menu-image">
                                        <span class="mega-menu-label">Garage</span>
                                    </a>
                                    <a href="{{url('/landing/indice-uv')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/INDICE-UV.png')}}" alt="UV" class="mega-menu-image">
                                        <span class="mega-menu-label">Indice UV</span>
                                    </a>
                                    <a href="{{url('/landing/indice')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/INDICE.png')}}" alt="Indices" class="mega-menu-image">
                                        <span class="mega-menu-label">Indices</span>
                                    </a>
                                    <a href="{{url('/landing/parcs-canada')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/PARC-CANADA.png')}}" alt="Parcs" class="mega-menu-image">
                                        <span class="mega-menu-label">Parcs Canada</span>
                                    </a>
                                   
                                </div>
                                
                                <!-- Colonne 4 - 5 items -->
                                <div class="mega-menu-column">
                                    <a href="{{url('/landing/chasse')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/CHASSE-PERIODE-DE.png')}}" alt="Chasse" class="mega-menu-image">
                                        <span class="mega-menu-label">Chasse</span>
                                    </a>
                                    <a href="{{url('/landing/croisieres')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/croisieres.png')}}" alt="Croisières" class="mega-menu-image">
                                        <span class="mega-menu-label">Croisières</span>
                                    </a>
                                    <a href="{{url('/landing/billets-avion')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/billet-avion-pas-cher.png')}}" alt="Billets" class="mega-menu-image">
                                        <span class="mega-menu-label">Billets Avion</span>
                                    </a>
                                    <a href="{{url('/landing/alerte-voyage')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/ALERTE VOYAGE-CANADA.png')}}" alt="Alerte" class="mega-menu-image">
                                        <span class="mega-menu-label">Alerte Voyage</span>
                                    </a>
                                </div>



                                 <!-- Colonne 5 -->
                                <div class="mega-menu-column">
                                     <a href="{{url('/landing/culture')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/CULTURE-ATTRAITS.png')}}" alt="Culture" class="mega-menu-image">
                                        <span class="mega-menu-label">Culture</span>
                                    </a>
                                    <a href="{{url('/landing/ferry')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/FERRY.png')}}" alt="Ferry" class="mega-menu-image">
                                        <span class="mega-menu-label">Ferry</span>
                                    </a>
                                     <a href="{{url('/landing/nouvelles')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/nouvelles-proviciales.png')}}" alt="Nouvelles" class="mega-menu-image">
                                        <span class="mega-menu-label">Nouvelles</span>
                                    </a>
    
                                    <a href="{{url('/landing/canada-quebec')}}" class="mega-menu-item">
                                        <img src="{{asset('header_info/megamenu/CANADA-QUEBEC.png')}}" alt="Canada" class="mega-menu-image">
                                        <span class="mega-menu-label">Canada Québec</span>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Carrousel Vidéo/Photo à droite -->
                            <div class="mega-menu-carousel">
                                <div class="carousel-scroll-container" id="carouselContainer">
                                    <!-- Vidéo YouTube 1 -->
                                    <div class="carousel-item-simple active" onclick="openMediaModal('video', 'https://www.youtube.com/embed/hdxKTW1ER5w?autoplay=1')">
                                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; position: relative; cursor: pointer; overflow: hidden;">
                                            <i class="fab fa-youtube" style="font-size: 60px; color: white; opacity: 0.9;"></i>
                                            <div style="position: absolute; bottom: 20px; left: 20px; color: white; font-size: 18px; font-weight: 600;">🎥 Québec Travel</div>
                                        </div>
                                    </div>
                                    
                                    <!-- Image 1 -->
                                    <div class="carousel-item-simple" onclick="openMediaModal('image', 'https://picsum.photos/800/600?random=1')">
                                        <img src="https://picsum.photos/270/400?random=1" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px; cursor: pointer;" alt="Québec">
                                    </div>
                                    
                                    <!-- Vidéo YouTube 2 -->
                                    <div class="carousel-item-simple" onclick="openMediaModal('video', 'https://www.youtube.com/embed/SBjQ9tuuTJQ?autoplay=1')">
                                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; position: relative; cursor: pointer; overflow: hidden;">
                                            <i class="fab fa-youtube" style="font-size: 60px; color: white; opacity: 0.9;"></i>
                                            <div style="position: absolute; bottom: 20px; left: 20px; color: white; font-size: 18px; font-weight: 600;">🎥 Canada Travel</div>
                                        </div>
                                    </div>
                                    
                                    <!-- Image 2 -->
                                    <div class="carousel-item-simple" onclick="openMediaModal('image', 'https://picsum.photos/800/600?random=2')">
                                        <img src="https://picsum.photos/270/400?random=2" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px; cursor: pointer;" alt="Montréal">
                                    </div>
                                    
                                    <!-- Image 3 -->
                                    <div class="carousel-item-simple" onclick="openMediaModal('image', 'https://picsum.photos/800/600?random=3')">
                                        <img src="https://picsum.photos/270/400?random=3" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px; cursor: pointer;" alt="Nature">
                                    </div>
                                    
                                    <!-- Vidéo YouTube 3 -->
                                    <div class="carousel-item-simple" onclick="openMediaModal('video', 'https://www.youtube.com/embed/Uj3_KqkI9Zo?autoplay=1')">
                                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; position: relative; cursor: pointer; overflow: hidden;">
                                            <i class="fab fa-youtube" style="font-size: 60px; color: white; opacity: 0.9;"></i>
                                            <div style="position: absolute; bottom: 20px; left: 20px; color: white; font-size: 18px; font-weight: 600;">🎥 Nature Travel</div>
                                        </div>
                                    </div>
                                    
                                    <!-- Image 4 -->
                                    <div class="carousel-item-simple" onclick="openMediaModal('image', 'https://picsum.photos/800/600?random=4')">
                                        <img src="https://picsum.photos/270/400?random=4" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px; cursor: pointer;" alt="Aventure">
                                    </div>
                                    
                                    <!-- Image 5 -->
                                    <div class="carousel-item-simple" onclick="openMediaModal('image', 'https://picsum.photos/800/600?random=5')">
                                        <img src="https://picsum.photos/270/400?random=5" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px; cursor: pointer;" alt="Ski">
                                    </div>
                                    
                                    <!-- Image 6 -->
                                    <div class="carousel-item-simple" onclick="openMediaModal('image', 'https://picsum.photos/800/600?random=6')">
                                        <img src="https://picsum.photos/270/400?random=6" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px; cursor: pointer;" alt="Festival">
                                    </div>
                                    
                                    <!-- Image 7 -->
                                    <div class="carousel-item-simple" onclick="openMediaModal('image', 'https://picsum.photos/800/600?random=7')">
                                        <img src="https://picsum.photos/270/400?random=7" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px; cursor: pointer;" alt="Gastronomie">
                                    </div>
                                    
                                    <!-- Indicateurs de navigation -->
                                    <div class="carousel-indicators">
                                        <span class="carousel-dot active" data-index="0"></span>
                                        <span class="carousel-dot" data-index="1"></span>
                                        <span class="carousel-dot" data-index="2"></span>
                                        <span class="carousel-dot" data-index="3"></span>
                                        <span class="carousel-dot" data-index="4"></span>
                                        <span class="carousel-dot" data-index="5"></span>
                                        <span class="carousel-dot" data-index="6"></span>
                                        <span class="carousel-dot" data-index="7"></span>
                                        <span class="carousel-dot" data-index="8"></span>
                                        <span class="carousel-dot" data-index="9"></span>
                                    </div>
                                    
                                    <!-- Boutons de navigation -->
                                    <button class="carousel-nav-btn prev" id="carouselPrev">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button class="carousel-nav-btn next" id="carouselNext">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Section des 3 menus en bas -->
                        <div class="mega-menu-bottom-section">
                            <a href="{{url('/landing/experiences-quebec')}}" class="mega-menu-bottom-item">
                                <i class="fas fa-maple-leaf"></i>
                                <span>Expériences Québec</span>
                            </a>
                            <a href="{{url('/landing/experiences-canada')}}" class="mega-menu-bottom-item">
                                <i class="fas fa-flag"></i>
                                <span>Expériences Canada</span>
                            </a>
                            <a href="{{url('/landing/experiences-monde')}}" class="mega-menu-bottom-item">
                                <i class="fas fa-globe-americas"></i>
                                <span>Expériences Monde</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Bouton 2: Deals Billets Avion -->
                <div class="header-icon-container">
                    <a href="{{url('/landing/deals-billets')}}" class="header-icon-link">
                        <img src="{{asset('header_info/DEALS-BILLET-AVION.png')}}" alt="Deals Billets" class="icon-image">
                        <span class="icon-label">Deals Billets</span>
                    </a>
                </div>
                
                <!-- Bouton 3: Offres Dernière Minute -->
                <div class="header-icon-container">
                    <a href="{{url('/landing/offres-derniere-minute')}}" class="header-icon-link">
                        <img src="{{asset('header_info/offre-derniere-minutes.png')}}" alt="Offres" class="icon-image">
                        <span class="icon-label">Offres</span>
                    </a>
                </div>
                
                <!-- Bouton 4: Nouvelles du Jour -->
                <div class="header-icon-container">
                    <a href="{{url('/landing/nouvelles')}}" class="header-icon-link">
                        <img src="{{asset('header_info/NOUVELLES-DU-JOUR.png')}}" alt="Nouvelles" class="icon-image">
                        <span class="icon-label">Nouvelles</span>
                    </a>
                </div>
                
                <!-- Bouton 5: Must à Voir -->
                <div class="header-icon-container">
                    <a href="{{url('/landing/must-voir')}}" class="header-icon-link">
                        <img src="{{asset('header_info/MOSTS-A-VOIR.png')}}" alt="Must à Voir" class="icon-image">
                        <span class="icon-label">Must à Voir</span>
                    </a>
                </div>
                
                <!-- Bouton 6: Qualité Véridique -->
                <div class="header-icon-container">
                    <a href="{{url('/landing/qualite')}}" class="header-icon-link">
                        <img src="{{asset('header_info/STATIONS-AVENTURE-QUEBEC.png')}}" alt="Qualité" class="icon-image">
                        <span class="icon-label">Stations aventure quebec</span>
                    </a>
                </div>
            </div>
            
            <!-- Bande défilante avec messages aux voyageurs -->
            <div class="travel-marquee-container">
                <div class="travel-marquee">
                    <!-- Message 1: Info -->
                    <div class="travel-message">
                        <span class="travel-text">Découvrez toutes les informations essentielles pour planifier votre voyage au Québec et au Canada</span>
                        <img src="https://cdn-icons-png.flaticon.com/512/471/471662.png" alt="Info" class="travel-end-img">
                    </div>
                    <!-- Message 2: Deals Billets -->
                    <div class="travel-message">
                         <span class="travel-text">Profitez de nos deals exclusifs sur les billets d'avion vers les plus belles destinations</span>
                        <img src="{{asset('header_info/DEALS-BILLET-AVION.png')}}" alt="Deals" class="travel-end-img">
                    </div>
                    <!-- Message 3: Offres Dernière Minute -->
                    <div class="travel-message">
                          <span class="travel-text">Saisissez nos offres de dernière minute et économisez jusqu'à 40% sur vos réservations</span>
                        <img src="{{asset('header_info/offre-derniere-minutes.png')}}" alt="Offres" class="travel-end-img">
                    </div>
                    <!-- Message 4: Nouvelles du Jour -->
                    <div class="travel-message">
                         <span class="travel-text">Restez informé avec les dernières nouvelles et actualités du monde du voyage</span>
                        <img src="{{asset('header_info/NOUVELLES-DU-JOUR.png')}}" alt="Nouvelles" class="travel-end-img">
                    </div>
                    <!-- Message 5: Must à Voir -->
                    <div class="travel-message">
                          <span class="travel-text">Explorez les incontournables et les sites à ne pas manquer lors de votre séjour</span>
                        <img src="{{asset('header_info/MOSTS-A-VOIR.png')}}" alt="Must" class="travel-end-img">
                    </div>
                    <!-- Message 6: Qualité Véridique -->
                    <div class="travel-message">
                         <span class="travel-text">Voyagez en toute confiance avec notre certification qualité et nos services vérifiés</span>
                        <img src="{{asset('header_info/GO-EXPLORIA-QUALITE-VERIDIQUE.png')}}" alt="Qualité" class="travel-end-img">
                    </div>
                </div>
            </div>
            </div>
            
            <!-- Modal pour afficher vidéo/image en grand -->
            <div id="mediaModal" class="media-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.95); z-index: 10000; justify-content: center; align-items: center;">
                <button onclick="closeMediaModal()" style="position: absolute; top: 20px; right: 30px; background: transparent; border: none; color: white; font-size: 40px; cursor: pointer; z-index: 10001;">&times;</button>
                <div id="modalMediaContainer" style="width: 90%; max-width: 1200px; height: 80%; background: #000; border-radius: 12px; overflow: hidden;"></div>
            </div>
            
            <script>
            // Fonction pour ouvrir la modal
            function openMediaModal(type, src) {
                const modal = document.getElementById('mediaModal');
                const container = document.getElementById('modalMediaContainer');
                
                container.innerHTML = '';
                
                if (type === 'video') {
                    const iframe = document.createElement('iframe');
                    iframe.src = src;
                    iframe.style.width = '100%';
                    iframe.style.height = '100%';
                    iframe.style.border = 'none';
                    iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                    iframe.allowFullscreen = true;
                    container.appendChild(iframe);
                } else {
                    const img = document.createElement('img');
                    img.src = src;
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'contain';
                    container.appendChild(img);
                }
                
                modal.style.display = 'flex';
            }
            
            // Fonction pour fermer la modal
            function closeMediaModal() {
                const modal = document.getElementById('mediaModal');
                const container = document.getElementById('modalMediaContainer');
                modal.style.display = 'none';
                container.innerHTML = '';
            }
            
            // Fermer en cliquant en dehors
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('mediaModal');
                if (modal) {
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            closeMediaModal();
                        }
                    });
                }
                
                // Carrousel automatique (slideshow)
                const carouselItems = document.querySelectorAll('.carousel-item-simple');
                const carouselDots = document.querySelectorAll('.carousel-dot');
                let currentIndex = 0;
                let autoPlayInterval;
                
                function showSlide(index) {
                    // Retirer la classe active de tous les items et dots
                    carouselItems.forEach(item => item.classList.remove('active'));
                    carouselDots.forEach(dot => dot.classList.remove('active'));
                    
                    // Ajouter la classe active à l'item et dot courant
                    if (carouselItems[index]) {
                        carouselItems[index].classList.add('active');
                    }
                    if (carouselDots[index]) {
                        carouselDots[index].classList.add('active');
                    }
                    
                    currentIndex = index;
                }
                
                function nextSlide() {
                    let nextIndex = (currentIndex + 1) % carouselItems.length;
                    showSlide(nextIndex);
                }
                
                function startAutoPlay() {
                    autoPlayInterval = setInterval(nextSlide, 4000); // Change toutes les 4 secondes
                }
                
                function stopAutoPlay() {
                    clearInterval(autoPlayInterval);
                }
                
                function prevSlide() {
                    let prevIndex = (currentIndex - 1 + carouselItems.length) % carouselItems.length;
                    showSlide(prevIndex);
                }
                
                // Navigation par les dots
                carouselDots.forEach((dot, index) => {
                    dot.addEventListener('click', function() {
                        stopAutoPlay();
                        showSlide(index);
                        startAutoPlay();
                    });
                });
                
                // Navigation par les boutons
                const prevBtn = document.getElementById('carouselPrev');
                const nextBtn = document.getElementById('carouselNext');
                
                if (prevBtn) {
                    prevBtn.addEventListener('click', function() {
                        stopAutoPlay();
                        prevSlide();
                        startAutoPlay();
                    });
                }
                
                if (nextBtn) {
                    nextBtn.addEventListener('click', function() {
                        stopAutoPlay();
                        nextSlide();
                        startAutoPlay();
                    });
                }
                
                // Pause au hover du carrousel
                const carouselContainer = document.getElementById('carouselContainer');
                if (carouselContainer) {
                    carouselContainer.addEventListener('mouseenter', stopAutoPlay);
                    carouselContainer.addEventListener('mouseleave', startAutoPlay);
                }
                
                // Démarrer l'autoplay
                if (carouselItems.length > 0) {
                    startAutoPlay();
                }
            });
            </script>
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
                    
                    <!-- NOUVEAUX MENUS -->
                    <!-- NOS VALEURS/FAQ -->
                    <a href="{{url('/espace-entreprise')}}" class="btn btn-sm btn-info me-2">
                        <i class="fas fa-info-circle me-1"></i>NOS VALEURS/FAQ
                    </a>
                    
                    <!-- GO NEXT LEVEL - Logo -->
                    <a href="{{url('/espace-entreprise')}}" class="me-2" style="display: inline-block; background: none; border: none; padding: 0; height: 31px; width: 80px; position: relative; vertical-align: middle;">
                        <img src="{{asset('header_info/GO-EXPLORIA-NEXT-LEVEL.png')}}" alt="GO NEXT LEVEL" style="height: 65px; width: auto; object-fit: contain; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 100; transition: transform 0.3s ease;" onmouseover="this.style.transform='translate(-50%, -50%) scale(1.08)'" onmouseout="this.style.transform='translate(-50%, -50%) scale(1)'">
                    </a>
                    
                    <!-- S'INSCRIRE avec mega menu -->
                    <div class="mega-menu-container">
                        <button class="btn btn-sm btn-success me-2" id="inscriptionBtn">
                            <i class="fas fa-user-plus me-1"></i>S'INSCRIRE
                        </button>
                        <div class="mega-menu mega-menu-inscription" id="inscriptionMegaMenu">
                            <div class="inscription-grid">
                                <a href="{{url('/register/administrateur')}}" class="inscription-item">
                                    <i class="fas fa-user-shield"></i>
                                    <span>Administrateur</span>
                                </a>
                                <a href="{{url('/register/executif')}}" class="inscription-item">
                                    <i class="fas fa-user-tie"></i>
                                    <span>Exécutif</span>
                                </a>
                                <a href="{{url('/register/client')}}" class="inscription-item">
                                    <i class="fas fa-user"></i>
                                    <span>Client</span>
                                </a>
                                <a href="{{url('/register/chef-entreprise')}}" class="inscription-item">
                                    <i class="fas fa-briefcase"></i>
                                    <span>Chef d'entreprise</span>
                                </a>
                                <a href="{{url('/register/client-2')}}" class="inscription-item">
                                    <i class="fas fa-user-circle"></i>
                                    <span>Client</span>
                                </a>
                                <a href="{{url('/register/employe')}}" class="inscription-item">
                                    <i class="fas fa-id-badge"></i>
                                    <span>Employé</span>
                                </a>
                                <a href="{{url('/register/directeur-ventes')}}" class="inscription-item">
                                    <i class="fas fa-chart-line"></i>
                                    <span>Directeur des ventes</span>
                                </a>
                                <a href="{{url('/register/agent-vente')}}" class="inscription-item">
                                    <i class="fas fa-handshake"></i>
                                    <span>Agent de vente</span>
                                </a>
                                <a href="{{url('/register/chef-projet')}}" class="inscription-item">
                                    <i class="fas fa-tasks"></i>
                                    <span>Chef de projet</span>
                                </a>
                                <a href="{{url('/register/gestionnaire-stock')}}" class="inscription-item">
                                    <i class="fas fa-boxes"></i>
                                    <span>Gestionnaire de stock</span>
                                </a>
                                <a href="{{url('/register/fournisseur')}}" class="inscription-item">
                                    <i class="fas fa-truck"></i>
                                    <span>Fournisseur</span>
                                </a>
                                <a href="{{url('/register/documentation')}}" class="inscription-item">
                                    <i class="fas fa-book"></i>
                                    <span>Documentation</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="top-bar-icons">
                    <!-- Mon compte -->
                    <a href="{{route('login')}}" class="top-bar-icon">
                        <i class="fas fa-user"></i>
                        <span>Mon compte</span>
                    </a>
                    
                    <!-- LANGUE avec mega menu - Toutes les langues du monde -->
                    <div class="mega-menu-container">
                        <button class="btn btn-sm btn-outline-info me-2" id="langueBtn">
                            <i class="fas fa-globe me-1"></i>LANGUE
                        </button>
                        <div class="mega-menu mega-menu-langue" id="langueMegaMenu" style="min-width: 600px; max-height: 500px; overflow-y: auto; padding: 20px;">
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px;">
                                <a href="#" class="mega-menu-link-simple" data-langue="fr"><span style="font-size: 1.2rem; margin-right: 8px;">🇫🇷</span>Français</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="en"><span style="font-size: 1.2rem; margin-right: 8px;">🇬🇧</span>English</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="es"><span style="font-size: 1.2rem; margin-right: 8px;">🇪🇸</span>Español</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="de"><span style="font-size: 1.2rem; margin-right: 8px;">🇩🇪</span>Deutsch</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="it"><span style="font-size: 1.2rem; margin-right: 8px;">🇮🇹</span>Italiano</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="pt"><span style="font-size: 1.2rem; margin-right: 8px;">🇵🇹</span>Português</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="nl"><span style="font-size: 1.2rem; margin-right: 8px;">🇳🇱</span>Nederlands</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="ru"><span style="font-size: 1.2rem; margin-right: 8px;">🇷🇺</span>Русский</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="zh"><span style="font-size: 1.2rem; margin-right: 8px;">🇨🇳</span>中文</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="ja"><span style="font-size: 1.2rem; margin-right: 8px;">🇯🇵</span>日本語</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="ko"><span style="font-size: 1.2rem; margin-right: 8px;">🇰🇷</span>한국어</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="ar"><span style="font-size: 1.2rem; margin-right: 8px;">🇸🇦</span>العربية</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="hi"><span style="font-size: 1.2rem; margin-right: 8px;">🇮🇳</span>हिन्दी</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="tr"><span style="font-size: 1.2rem; margin-right: 8px;">🇹🇷</span>Türkçe</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="pl"><span style="font-size: 1.2rem; margin-right: 8px;">🇵🇱</span>Polski</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="sv"><span style="font-size: 1.2rem; margin-right: 8px;">🇸🇪</span>Svenska</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="no"><span style="font-size: 1.2rem; margin-right: 8px;">🇳🇴</span>Norsk</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="da"><span style="font-size: 1.2rem; margin-right: 8px;">🇩🇰</span>Dansk</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="fi"><span style="font-size: 1.2rem; margin-right: 8px;">🇫🇮</span>Suomi</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="cs"><span style="font-size: 1.2rem; margin-right: 8px;">🇨🇿</span>Čeština</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="el"><span style="font-size: 1.2rem; margin-right: 8px;">🇬🇷</span>Ελληνικά</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="he"><span style="font-size: 1.2rem; margin-right: 8px;">🇮🇱</span>עברית</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="th"><span style="font-size: 1.2rem; margin-right: 8px;">🇹🇭</span>ไทย</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="vi"><span style="font-size: 1.2rem; margin-right: 8px;">🇻🇳</span>Tiếng Việt</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="id"><span style="font-size: 1.2rem; margin-right: 8px;">🇮🇩</span>Bahasa Indonesia</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="ms"><span style="font-size: 1.2rem; margin-right: 8px;">🇲🇾</span>Bahasa Melayu</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="tl"><span style="font-size: 1.2rem; margin-right: 8px;">🇵🇭</span>Tagalog</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="uk"><span style="font-size: 1.2rem; margin-right: 8px;">🇺🇦</span>Українська</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="ro"><span style="font-size: 1.2rem; margin-right: 8px;">🇷🇴</span>Română</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="hu"><span style="font-size: 1.2rem; margin-right: 8px;">🇭🇺</span>Magyar</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="bg"><span style="font-size: 1.2rem; margin-right: 8px;">🇧🇬</span>Български</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="hr"><span style="font-size: 1.2rem; margin-right: 8px;">🇭🇷</span>Hrvatski</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="sr"><span style="font-size: 1.2rem; margin-right: 8px;">🇷🇸</span>Српски</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="sk"><span style="font-size: 1.2rem; margin-right: 8px;">🇸🇰</span>Slovenčina</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="sl"><span style="font-size: 1.2rem; margin-right: 8px;">🇸🇮</span>Slovenščina</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="lt"><span style="font-size: 1.2rem; margin-right: 8px;">🇱🇹</span>Lietuvių</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="lv"><span style="font-size: 1.2rem; margin-right: 8px;">🇱🇻</span>Latviešu</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="et"><span style="font-size: 1.2rem; margin-right: 8px;">🇪🇪</span>Eesti</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="fa"><span style="font-size: 1.2rem; margin-right: 8px;">🇮🇷</span>فارسی</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="ur"><span style="font-size: 1.2rem; margin-right: 8px;">🇵🇰</span>اردو</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="bn"><span style="font-size: 1.2rem; margin-right: 8px;">🇧🇩</span>বাংলা</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="sw"><span style="font-size: 1.2rem; margin-right: 8px;">🇰🇪</span>Kiswahili</a>
                                <a href="#" class="mega-menu-link-simple" data-langue="af"><span style="font-size: 1.2rem; margin-right: 8px;">🇿🇦</span>Afrikaans</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- YouTube Icon -->
                    <!-- <a href="https://www.youtube.com/user/explorezlemonde/videos?view_as=subscriber" target="_blank" class="top-bar-icon">
                        <i class="fab fa-youtube"></i>
                    </a> -->
                    
                    <!-- Panier avec mega menu vide -->
                    <div class="mega-menu-container">
                        <button class="btn btn-sm btn-outline-warning me-2" id="panierBtn">
                            <i class="fas fa-shopping-cart me-1"></i>PANIER
                        </button>
                        <div class="mega-menu mega-menu-panier" id="panierMegaMenu" style="min-width: 350px; padding: 40px; text-align: center;">
                            <i class="fas fa-shopping-cart" style="font-size: 64px; color: #bdc3c7; margin-bottom: 20px;"></i>
                            <h5 style="color: #7f8c8d; margin-bottom: 10px;">Votre panier est vide</h5>
                            <p style="color: #95a5a6; font-size: 0.95rem;">
                                Vous n'avez pas encore d'achats dans votre panier.
                            </p>
                            <a href="{{url('/landing/explorer')}}" class="btn btn-primary mt-3">
                                <i class="fas fa-search me-2"></i>Découvrir nos offres
                            </a>
                        </div>
                    </div>
                    
                    <!-- DEVISES - Déplacé avant Favoris -->
                    <div class="mega-menu-container">
                        <button class="btn btn-sm btn-outline-secondary me-2" id="devisesBtn">
                            <i class="fas fa-dollar-sign me-1"></i>Devises
                        </button>
                        <div class="mega-menu mega-menu-devises" id="devisesMegaMenu">
                            <a href="#" class="mega-menu-link-simple" data-devise="EUR">
                                <i class="fas fa-euro-sign me-2"></i>EURO (EUR)
                            </a>
                            <a href="#" class="mega-menu-link-simple" data-devise="CAD">
                                <i class="fas fa-dollar-sign me-2"></i>CANADIEN (CAD)
                            </a>
                            <a href="#" class="mega-menu-link-simple" data-devise="USD">
                                <i class="fas fa-dollar-sign me-2"></i>USA (USD)
                            </a>
                        </div>
                    </div>
                    
                    <!-- Favoris avec mega menu vide -->
                    <div class="mega-menu-container">
                        <button class="btn btn-sm btn-outline-danger me-2" id="favorisBtn">
                            <i class="fas fa-heart me-1"></i>FAVORIS
                        </button>
                        <div class="mega-menu mega-menu-favoris" id="favorisMegaMenu" style="min-width: 350px; padding: 40px; text-align: center;">
                            <i class="fas fa-heart" style="font-size: 64px; color: #bdc3c7; margin-bottom: 20px;"></i>
                            <h5 style="color: #7f8c8d; margin-bottom: 10px;">Aucun favori</h5>
                            <p style="color: #95a5a6; font-size: 0.95rem;">
                                Vous n'avez pas encore de favoris enregistrés.
                            </p>
                            <a href="{{url('/landing/destinations')}}" class="btn btn-danger mt-3">
                                <i class="fas fa-globe me-2"></i>Explorer les destinations
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.front.navbar')
    @include('components.front.horizontal-nav')
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
    @php
    // IDs à afficher en premier
    $priorityIds = [22, 23];
    
    // Récupérer les pages prioritaires dans l'ordre spécifié
    $priorityPages = collect();
    foreach ($priorityIds as $id) {
        $page = \App\Models\Menu::where('id', $id)
            ->where('is_active', true)
            ->where('has_page', true)
            ->whereNull('parent_id')
            ->first();
        if ($page) {
            $priorityPages->push($page);
        }
    }
    
    // Récupérer toutes les autres pages
    $otherPages = \App\Models\Menu::where('is_active', true)
        ->where('has_page', true)
        ->where('menu_type', 'Accueil')
        ->whereNull('parent_id')
        ->whereNotIn('id', $priorityIds)
        ->orderBy('order','ASC')
        ->get();
    
    // Fusionner les collections
    $pages = $priorityPages->concat($otherPages);
@endphp

@foreach($pages as $page)
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

    <!-- Business -->
   
<!-- Iframe avec un name pour le cibler -->
<iframe 
    id="affichez-vos-entreprises"
    name="business-iframe"
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
        const megaMenus = [
            { btn: document.getElementById('servicesWebBtn'), menu: document.getElementById('webServicesMegaMenu') },
            { btn: document.getElementById('templatesBtn'), menu: document.getElementById('templatesMegaMenu') }
        ];
        
        document.addEventListener('click', function(event) {
            megaMenus.forEach(({btn, menu}) => {
                if (menu && btn) {
                    if (!menu.contains(event.target) && !btn.contains(event.target)) {
                        menu.style.opacity = '0';
                        menu.style.visibility = 'hidden';
                        menu.style.transform = 'translateX(-50%) translateY(15px)';
                    }
                }
            });
        });
        
        // Ouvrir/fermer le méga-menu au clic sur mobile pour Services Web
        const servicesBtn = document.getElementById('servicesWebBtn');
        const servicesMegaMenu = document.getElementById('webServicesMegaMenu');
        
        if (servicesBtn && servicesMegaMenu) {
            servicesBtn.addEventListener('click', function(event) {
                event.preventDefault();
                const isVisible = servicesMegaMenu.style.opacity === '1';
                
                // Fermer l'autre menu d'abord
                const templatesBtn = document.getElementById('templatesBtn');
                const templatesMegaMenu = document.getElementById('templatesMegaMenu');
                if (templatesBtn && templatesMegaMenu) {
                    templatesMegaMenu.style.opacity = '0';
                    templatesMegaMenu.style.visibility = 'hidden';
                    templatesMegaMenu.style.transform = 'translateX(-50%) translateY(15px)';
                }
                
                if (isVisible) {
                    servicesMegaMenu.style.opacity = '0';
                    servicesMegaMenu.style.visibility = 'hidden';
                    servicesMegaMenu.style.transform = 'translateX(-50%) translateY(15px)';
                } else {
                    servicesMegaMenu.style.opacity = '1';
                    servicesMegaMenu.style.visibility = 'visible';
                    servicesMegaMenu.style.transform = 'translateX(-50%) translateY(0)';
                }
            });
        }
        
        // Ouvrir/fermer le méga-menu au clic sur mobile pour Templates
        const templatesBtn = document.getElementById('templatesBtn');
        const templatesMegaMenu = document.getElementById('templatesMegaMenu');
        
        if (templatesBtn && templatesMegaMenu) {
            templatesBtn.addEventListener('click', function(event) {
                event.preventDefault();
                const isVisible = templatesMegaMenu.style.opacity === '1';
                
                // Fermer l'autre menu d'abord
                const servicesBtn = document.getElementById('servicesWebBtn');
                const servicesMegaMenu = document.getElementById('webServicesMegaMenu');
                if (servicesBtn && servicesMegaMenu) {
                    servicesMegaMenu.style.opacity = '0';
                    servicesMegaMenu.style.visibility = 'hidden';
                    servicesMegaMenu.style.transform = 'translateX(-50%) translateY(15px)';
                }
                
                if (isVisible) {
                    templatesMegaMenu.style.opacity = '0';
                    templatesMegaMenu.style.visibility = 'hidden';
                    templatesMegaMenu.style.transform = 'translateX(-50%) translateY(15px)';
                } else {
                    templatesMegaMenu.style.opacity = '1';
                    templatesMegaMenu.style.visibility = 'visible';
                    templatesMegaMenu.style.transform = 'translateX(-50%) translateY(0)';
                }
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
        const marquee = document.querySelector('.travel-marquee');
        if (marquee) {
            marquee.innerHTML += marquee.innerHTML;
        }
    });
    </script>

</body>
</html>