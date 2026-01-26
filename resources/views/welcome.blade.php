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

    <x-front.nav-bar />


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