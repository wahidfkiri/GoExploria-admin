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
    
  <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
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

    @include('components.front.navbar')


    <!-- Video Slider Full Width -->
    <section class="video-slider-section">
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
      
<!-- Marketing -->
<!-- <iframe 
    id="iframe-page-marketing-1"
    src="{{ url('/theme/marketing/page-1') }}" 
    width="100%" 
    style="border:0; overflow:hidden;"
    scrolling="no">
</iframe> -->


<!-- Business -->
<iframe 
    id="iframe-page-business-1"
    src="{{ url('/theme/business/page-1') }}" 
    width="100%" 
    style="border:0; overflow:hidden;"
    scrolling="no">
</iframe>
<!-- E-commerce -->
<iframe 
    id="iframe-page-1"
    src="{{ url('/theme/ecommerce/page-1') }}" 
    width="100%" 
    style="border:0; overflow:hidden;"
    scrolling="no">
</iframe>

<iframe 
    id="iframe-page-2"
    src="{{ url('/theme/ecommerce/page-2') }}" 
    width="100%" 
    style="border:0; overflow:hidden;"
    scrolling="no">
</iframe>

<iframe 
    id="iframe-page-3"
    src="{{ url('/theme/ecommerce/page-3') }}" 
    width="100%" 
    style="border:0; overflow:hidden;"
    scrolling="no">
</iframe>
<!-- Travel Pages-->
 
<iframe 
    id="iframe-page-travel-1"
    src="{{ url('/theme/travel/page-1') }}" 
    width="100%" 
    style="border:0; overflow:hidden;"
    scrolling="no">
</iframe>
<iframe 
    id="iframe-page-travel-2"
    src="{{ url('/theme/travel/page-2') }}" 
    width="100%" 
    style="border:0; overflow:hidden;"
    scrolling="no">
</iframe>
<iframe 
    id="iframe-page-travel-3"
    src="{{ url('/theme/travel/page-3') }}" 
    width="100%" 
    style="border:0; overflow:hidden;"
    scrolling="no">
</iframe>

<!-- Media -->
 
<iframe 
    id="iframe-page-media-2"
    src="{{ url('/theme/media/page-2') }}" 
    width="100%" 
    style="border:0; overflow:hidden;"
    scrolling="no">
</iframe>


<!-- SEO -->
<iframe 
    id="iframe-page-seo-1"
    src="{{ url('/theme/seo/page-1') }}" 
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

@include('chat.index')
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