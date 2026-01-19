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
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/geo-map/css/map.css') }}">
    <style>
        /* Styles pour les onglets avec liens */
.app-tabs {
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
}

.tabs-header {
    display: flex;
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 0;
}

.tab-link {
    flex: 1;
    padding: 1rem 1.5rem;
    text-decoration: none;
    color: #495057;
    text-align: center;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.tab-link:hover {
    background: #e9ecef;
    color: #007bff;
    text-decoration: none;
}

.tab-link.active {
    color: #007bff;
    border-bottom: 3px solid #007bff;
    background: white;
    font-weight: 500;
}

.tabs-content {
    flex: 1;
    overflow: hidden;
}

.tab-pane {
    display: none;
    height: 100%;
    width: 100%;
}

.tab-pane.active {
    display: flex;
}

/* Pour l'onglet carte, conserver le layout existant */
#tab-carte {
    flex-direction: row;
}

/* Styles pour les contenus des autres onglets */
.info-content,
.generale-content {
    padding: 2rem;
    overflow-y: auto;
    width: 100%;
    background: #f8f9fa;
}

.info-content h2,
.generale-content h2 {
    color: #2c3e50;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e9ecef;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.info-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.info-card i {
    font-size: 2.5rem;
    color: #3498db;
    margin-bottom: 1rem;
}

.info-card h3 {
    margin-bottom: 0.75rem;
    color: #2c3e50;
    font-size: 1.2rem;
}

.info-card p {
    color: #7f8c8d;
    font-size: 0.95rem;
    line-height: 1.5;
}

.info-text {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    margin-top: 2rem;
}

.info-text h3 {
    color: #2c3e50;
    margin-bottom: 1rem;
}

.info-text ol {
    padding-left: 1.5rem;
    color: #34495e;
}

.info-text li {
    margin-bottom: 0.75rem;
    line-height: 1.5;
}

.settings-section {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
    border: 1px solid #e9ecef;
}

.settings-section h3 {
    color: #2c3e50;
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.setting-item {
    margin-bottom: 1.25rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid #f1f1f1;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.setting-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.setting-item label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #495057;
    font-weight: 500;
    cursor: pointer;
}

.setting-item .form-control,
.setting-item .form-select {
    max-width: 300px;
}

.about-info {
    color: #495057;
}

.about-info p {
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.about-info strong {
    color: #2c3e50;
    min-width: 150px;
    display: inline-block;
}

/* Style pour les boutons dans les paramètres */
.btn-outline-primary,
.btn-outline-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-right: 0.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .app-tabs {
        flex-direction: column;
    }
    
    .tabs-header {
        flex-wrap: nowrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .tab-link {
        min-width: 120px;
        padding: 1rem;
        font-size: 0.85rem;
    }
    
    .info-content,
    .generale-content {
        padding: 1rem;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .setting-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
    
    .setting-item .form-control,
    .setting-item .form-select {
        max-width: 100%;
        width: 100%;
    }
    
    .about-info strong {
        min-width: 120px;
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

   <!-- Main Content -->
<div class="app-container" id="appContainer">
    <!-- Onglets de navigation -->
    <div class="app-tabs" id="appTabs">
        <div class="tabs-header">
            <a href="#carte" class="tab-link active" data-tab="carte">
                <i class="fas fa-map"></i> Carte
            </a>
            <a href="#info" class="tab-link" data-tab="info">
                <i class="fas fa-info-circle"></i> Informations
            </a>
            <a href="#generale" class="tab-link" data-tab="generale">
                <i class="fas fa-cog"></i> Générale
            </a>
            <!-- Ajoutez d'autres onglets au besoin -->
        </div>
        
        <!-- Contenu des onglets -->
        <div class="tabs-content">
            <!-- Onglet Carte -->
            <div class="tab-pane active" id="tab-carte">
                <!-- Carte à gauche -->
                <div class="map-container">
                    <div id="map"></div>
                    
                    <!-- Overlay de chargement -->
                    <div class="loading-overlay" id="mapLoading">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Chargement de la carte...</span>
                            </div>
                            <p class="mt-2">Chargement de la carte...</p>
                        </div>
                    </div>
                    
                    <!-- Bouton pour ouvrir/fermer sidebar sur mobile -->
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars" id="sidebarToggleIcon"></i>
                    </button>
                </div>
                
                <!-- Sidebar à droite - Positionnée dans app-container -->
                <div class="sidebar-right" id="sidebarRight">
                    
                    <div class="filters-section">
                        <h3>Filtres</h3>
                        
                        <!-- Sélection de province -->
                        <div class="filter-group">
                            <label for="province-filter">Province/Région :</label>
                            <select id="province-filter" class="form-select">
                                <option value="">Chargement des provinces...</option>
                            </select>
                        </div>
                        
                        <!-- Sélection de catégorie -->
                        <div class="filter-group">
                            <label for="category-filter">Catégorie :</label>
                            <select id="category-filter" class="form-select">
                                <option value="all">Toutes les catégories</option>
                            </select>
                        </div>
                        
                        <!-- Filtre de rayon -->
                        <div class="filter-group">
                            <label for="radius-filter">Rayon de recherche :</label>
                            <div class="slider-container">
                                <input type="range" id="radius-filter" min="1" max="500" value="100" class="form-range">
                                <span id="radius-value">100 km</span>
                            </div>
                        </div>
                        
                        <!-- Bouton de localisation -->
                        <div class="filter-group">
                            <button id="locate-me" class="btn locate-btn">
                                <i class="fas fa-location-arrow"></i> Me localiser
                            </button>
                        </div>
                        
                        <!-- Statistiques -->
                        <div class="stats">
                            <p><span id="places-count">0</span> lieux trouvés dans la zone</p>
                        </div>
                    </div>
                    
                    <!-- Liste des lieux -->
                    <div class="places-list" id="places-list">
                        <div class="no-results">
                            <i class="fas fa-map-marker-alt"></i>
                            <h4>Aucun lieu trouvé</h4>
                            <p>Utilisez les filtres pour trouver des lieux intéressants</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Onglet Informations -->
            <div class="tab-pane" id="tab-info">
                <div class="info-content">
                    <h2><i class="fas fa-info-circle"></i> Informations sur l'application</h2>
                    <div class="info-grid">
                        <div class="info-card">
                            <i class="fas fa-globe"></i>
                            <h3>Carte Interactive</h3>
                            <p>Explorez les lieux sur une carte interactive avec filtres avancés pour une recherche précise.</p>
                        </div>
                        <div class="info-card">
                            <i class="fas fa-filter"></i>
                            <h3>Filtres Dynamiques</h3>
                            <p>Filtrez par province, catégorie et rayon de recherche pour trouver exactement ce que vous cherchez.</p>
                        </div>
                        <div class="info-card">
                            <i class="fas fa-map-marker-alt"></i>
                            <h3>Localisation</h3>
                            <p>Trouvez des lieux près de votre position actuelle avec la fonction de géolocalisation.</p>
                        </div>
                        <div class="info-card">
                            <i class="fas fa-list"></i>
                            <h3>Liste Détailée</h3>
                            <p>Consultez la liste des lieux avec toutes les informations importantes en un coup d'œil.</p>
                        </div>
                    </div>
                    
                    <div class="info-text">
                        <h3>Comment utiliser l'application</h3>
                        <ol>
                            <li>Sélectionnez une province ou région dans le filtre</li>
                            <li>Choisissez une catégorie si nécessaire</li>
                            <li>Définissez le rayon de recherche</li>
                            <li>Cliquez sur "Me localiser" pour centrer sur votre position</li>
                            <li>Explorez les lieux sur la carte ou dans la liste</li>
                        </ol>
                    </div>
                </div>
            </div>
            
            <!-- Onglet Générale -->
            <div class="tab-pane" id="tab-generale">
                <div class="generale-content">
                    <h2><i class="fas fa-cog"></i> Paramètres Généraux</h2>
                    
                    <div class="settings-section">
                        <h3><i class="fas fa-palette"></i> Préférences d'affichage</h3>
                        <div class="setting-item">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" id="darkModeToggle">
                                <i class="fas fa-moon"></i> Mode sombre
                            </label>
                        </div>
                        <div class="setting-item">
                            <label for="mapStyleSelect"><i class="fas fa-map"></i> Style de carte :</label>
                            <select id="mapStyleSelect" class="form-select">
                                <option value="streets">Rues</option>
                                <option value="satellite">Satellite</option>
                                <option value="light">Clair</option>
                                <option value="dark">Sombre</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="settings-section">
                        <h3><i class="fas fa-search"></i> Paramètres de recherche</h3>
                        <div class="setting-item">
                            <label for="defaultRadius"><i class="fas fa-ruler"></i> Rayon par défaut (km) :</label>
                            <input type="number" id="defaultRadius" class="form-control" value="100" min="1" max="500">
                        </div>
                        <div class="setting-item">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" id="autoLocationToggle">
                                <i class="fas fa-location-arrow"></i> Localisation automatique au démarrage
                            </label>
                        </div>
                    </div>
                    
                    <div class="settings-section">
                        <h3><i class="fas fa-database"></i> Données</h3>
                        <div class="setting-item">
                            <button class="btn btn-outline-primary" id="clearCacheBtn">
                                <i class="fas fa-trash-alt"></i> Vider le cache
                            </button>
                            <button class="btn btn-outline-secondary" id="refreshDataBtn">
                                <i class="fas fa-sync-alt"></i> Actualiser les données
                            </button>
                        </div>
                    </div>
                    
                    <div class="settings-section">
                        <h3><i class="fas fa-info-circle"></i> À propos</h3>
                        <div class="about-info">
                            <p><strong>Version :</strong> 1.0.0</p>
                            <p><strong>Dernière mise à jour :</strong> <span id="lastUpdateDate"></span></p>
                            <p><strong>Données chargées :</strong> <span id="dataCount">0</span> lieux disponibles</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
    <!-- Modal pour les détails -->
    <div id="place-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div id="modal-content"></div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <script>
    class InteractiveMap {
        constructor() {
            this.map = null;
            this.markers = {};
            this.currentLocation = null;
            this.places = [];
            this.categories = [];
            this.provinces = [];
            this.selectedCategory = 'all';
            this.selectedProvince = '';
            this.radius = 100;
            this.swiper = null;
            this.countryCode = "<?php echo $countrie->code; ?>";
            this.countryLat = <?php echo $countrie->latitude; ?>;
            this.countryLng = <?php echo $countrie->longitude; ?>;
            this.hoverTimeout = null;
            this.activePlaceId = null;
            this.tooltips = {};
            this.userMarker = null;
            this.activePlace = null;
            
            // Images statiques par catégorie
            this.staticImages = {
                restaurant: [
                    'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4',
                    'https://images.unsplash.com/photo-1559925393-8be0ec4767c8',
                    'https://images.unsplash.com/photo-1414235077428-338989a2e8c0',
                    'https://images.unsplash.com/photo-1554679665-f5537f187268'
                ],
                hotel: [
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945',
                    'https://images.unsplash.com/photo-1564501049418-3c27787d01e8',
                    'https://images.unsplash.com/photo-1584132967334-10e028bd69f7',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d'
                ],
                museum: [
                    'https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99',
                    'https://images.unsplash.com/photo-1582555172866-f73bb12a2ab3',
                    'https://images.unsplash.com/photo-1578662996442-48f60103fc96',
                    'https://images.unsplash.com/photo-1596462502278-27bfdc403348'
                ],
                park: [
                    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4',
                    'https://images.unsplash.com/photo-1503614472-8c93d56e92ce',
                    'https://images.unsplash.com/photo-1518837695005-2083093ee35b',
                    'https://images.unsplash.com/photo-1448375240586-882707db888b'
                ],
                shopping: [
                    'https://images.unsplash.com/photo-1441986300917-64674bd600d8',
                    'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d',
                    'https://images.unsplash.com/photo-1556742044-3c52d6e88c62',
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7'
                ],
                monument: [
                    'https://images.unsplash.com/photo-1546436836-07bfe9ee8b9c',
                    'https://images.unsplash.com/photo-1559592413-7cec4d0cae2b',
                    'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9',
                    'https://images.unsplash.com/photo-1529260830199-42c24126f198'
                ]
            };
            
            // Images par défaut si catégorie inconnue
            this.defaultImages = [
                'https://images.unsplash.com/photo-1518837695005-2083093ee35b',
                'https://images.unsplash.com/photo-1506905925346-21bda4d32df4',
                'https://images.unsplash.com/photo-1448375240586-882707db888b',
                'https://images.unsplash.com/photo-1503614472-8c93d56e92ce'
            ];
            
            this.init();
        }
        
        async init() {
            try {
                // Initialiser la carte
                this.initMap();
                
                // Initialiser la sidebar
                this.initSidebar();
                
                // Charger les provinces
                await this.loadProvinces();
                
                // Charger les catégories
                await this.loadCategories();
                
                // Charger les lieux initiaux
                await this.loadPlaces();
                
                // Écouter les événements
                this.setupEventListeners();
                
                console.log('Carte interactive initialisée avec succès');
            } catch (error) {
                console.error('Erreur lors de l\'initialisation:', error);
            }
        }
        
        initMap() {
            try {
                // Cacher le loading overlay
                document.getElementById('mapLoading').style.display = 'none';
                
                // Créer la carte avec la position du pays
                this.map = L.map('map').setView([this.countryLat, this.countryLng], 4);
                
                // Ajouter les tuiles OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributeurs',
                    maxZoom: 19,
                    detectRetina: true
                }).addTo(this.map);
                
                // Ajouter un contrôle d'échelle
                L.control.scale({ imperial: false }).addTo(this.map);
                
                // Ajouter un contrôle de localisation custom
                this.addLocateControl();
                
            } catch (error) {
                console.error('Erreur lors de l\'initialisation de la carte:', error);
                document.getElementById('mapLoading').innerHTML = `
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                        <h4>Erreur de chargement de la carte</h4>
                        <p>${error.message}</p>
                        <button onclick="location.reload()" class="btn btn-primary mt-2">
                            <i class="fas fa-redo"></i> Réessayer
                        </button>
                    </div>
                `;
            }
        }
        
        initSidebar() {
            // Gérer la sidebar sur mobile
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebarRight');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('active');
                    const icon = document.getElementById('sidebarToggleIcon');
                    if (sidebar.classList.contains('active')) {
                        icon.className = 'fas fa-times';
                    } else {
                        icon.className = 'fas fa-bars';
                    }
                });
            }
            
            // Fermer la sidebar au clic en dehors sur mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 768 && 
                    sidebar.classList.contains('active') &&
                    !sidebar.contains(e.target) &&
                    !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('active');
                    document.getElementById('sidebarToggleIcon').className = 'fas fa-bars';
                }
            });
            
            // Ajuster la hauteur de la sidebar en fonction du header
            this.adjustSidebarHeight();
        }
        
        adjustSidebarHeight() {
            const sidebar = document.getElementById('sidebarRight');
            if (!sidebar) return;
            
            // Calculer la hauteur totale des headers
            const infoHeader = document.querySelector('.info-header');
            const topBar = document.querySelector('.top-bar');
            const mainNavbar = document.querySelector('.main-navbar');
            
            let totalHeaderHeight = 0;
            if (infoHeader) totalHeaderHeight += infoHeader.offsetHeight;
            if (topBar) totalHeaderHeight += topBar.offsetHeight;
            if (mainNavbar) totalHeaderHeight += mainNavbar.offsetHeight;
            
            // Définir la hauteur de la sidebar
            const viewportHeight = window.innerHeight;
            const sidebarHeight = viewportHeight - totalHeaderHeight;
            
     
            
           
            
            // Recalculer lors du redimensionnement
            window.addEventListener('resize', () => {
                this.adjustSidebarHeight();
            });
        }
        
        addLocateControl() {
            const locateControl = L.control({ position: 'topright' });
            
            locateControl.onAdd = (map) => {
                const container = L.DomUtil.create('div', 'leaflet-control-locate-custom leaflet-bar leaflet-control');
                
                const link = L.DomUtil.create('a', '', container);
                link.href = '#';
                link.title = 'Me localiser';
                link.innerHTML = '<i class="fas fa-location-arrow"></i>';
                
                L.DomEvent.on(link, 'click', (e) => {
                    L.DomEvent.stopPropagation(e);
                    L.DomEvent.preventDefault(e);
                    this.locateUser();
                });
                
                return container;
            };
            
            locateControl.addTo(this.map);
        }
        
        async loadProvinces() {
            try {
                // Récupérer les provinces via l'API
                const response = await axios.get(`/api/provinces/${this.countryCode}`);
                this.provinces = response.data.provinces || response.data;
                this.populateProvinceFilter();
            } catch (error) {
                console.error('Erreur lors du chargement des provinces:', error);
                
                // Données par défaut pour le Canada
                this.provinces = [
                    { id: 'qc', name: 'Québec', latitude: 52.9399, longitude: -73.5491 },
                    { id: 'on', name: 'Ontario', latitude: 51.2538, longitude: -85.3232 },
                    { id: 'bc', name: 'Colombie-Britannique', latitude: 53.7267, longitude: -127.6476 },
                    { id: 'ab', name: 'Alberta', latitude: 53.9333, longitude: -116.5765 },
                    { id: 'mb', name: 'Manitoba', latitude: 53.7609, longitude: -98.8139 },
                    { id: 'sk', name: 'Saskatchewan', latitude: 52.9399, longitude: -106.4509 },
                    { id: 'ns', name: 'Nouvelle-Écosse', latitude: 44.6820, longitude: -63.7443 },
                    { id: 'nb', name: 'Nouveau-Brunswick', latitude: 46.5653, longitude: -66.4619 },
                    { id: 'nl', name: 'Terre-Neuve-et-Labrador', latitude: 53.1355, longitude: -57.6604 },
                    { id: 'pe', name: 'Île-du-Prince-Édouard', latitude: 46.5107, longitude: -63.4168 },
                    { id: 'yt', name: 'Yukon', latitude: 64.2823, longitude: -135.0000 },
                    { id: 'nt', name: 'Territoires du Nord-Ouest', latitude: 64.8255, longitude: -124.8457 },
                    { id: 'nu', name: 'Nunavut', latitude: 70.2998, longitude: -83.1076 }
                ];
                
                this.populateProvinceFilter();
            }
        }
        
        populateProvinceFilter() {
            const filter = document.getElementById('province-filter');
            if (!filter) return;
            
            filter.innerHTML = '<option value="">Toutes les provinces</option>';
            
            this.provinces.forEach(province => {
                const option = document.createElement('option');
                option.value = province.id || province.code;
                option.textContent = province.name || province.province_name;
                option.dataset.lat = province.latitude;
                option.dataset.lng = province.longitude;
                filter.appendChild(option);
            });
        }
        
        async loadCategories() {
            try {
                const response = await axios.get('/api/categories');
                this.categories = response.data;
                this.populateCategoryFilter();
            } catch (error) {
                console.error('Erreur lors du chargement des catégories:', error);
                this.categories = ['restaurant', 'hotel', 'museum', 'park', 'shopping', 'monument'];
                this.populateCategoryFilter();
            }
        }
        
        populateCategoryFilter() {
            const filter = document.getElementById('category-filter');
            if (!filter) return;
            
            filter.innerHTML = '<option value="all">Toutes les catégories</option>';
            
            this.categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category;
                option.textContent = this.capitalizeFirstLetter(category);
                filter.appendChild(option);
            });
        }
        
        async loadPlaces() {
            try {
                // Afficher le chargement
                const placesList = document.getElementById('places-list');
                if (placesList) {
                    placesList.innerHTML = `
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Chargement...</span>
                            </div>
                            <p class="mt-2">Recherche des lieux...</p>
                        </div>
                    `;
                }
                
                const params = {
                    category: this.selectedCategory === 'all' ? null : this.selectedCategory,
                    province: this.selectedProvince || null,
                    radius: this.radius,
                    lat: this.currentLocation?.lat || this.countryLat,
                    lng: this.currentLocation?.lng || this.countryLng
                };
                
                // Filtrer les paramètres null
                const filteredParams = {};
                Object.keys(params).forEach(key => {
                    if (params[key] !== null && params[key] !== undefined) {
                        filteredParams[key] = params[key];
                    }
                });
                
                const response = await axios.get('/api/places', { 
                    params: filteredParams,
                    timeout: 10000
                });
                
                this.places = Array.isArray(response.data) ? response.data : [];
                
                if (response.data?.data && Array.isArray(response.data.data)) {
                    this.places = response.data.data;
                }
                
                if (response.data?.places && Array.isArray(response.data.places)) {
                    this.places = response.data.places;
                }
                
                // Ajouter des images statiques aux lieux
                this.addStaticImagesToPlaces();
                
                this.updatePlacesCount();
                this.renderPlacesList();
                this.addMarkersToMap();
                
            } catch (error) {
                console.error('Erreur lors du chargement des lieux:', error);
                this.showSamplePlaces();
            }
        }
        
        addStaticImagesToPlaces() {
            // Ajouter des images statiques à chaque lieu
            this.places = this.places.map(place => {
                // Déterminer les images à utiliser
                let images = [];
                const category = place.category || 'monument';
                
                if (this.staticImages[category]) {
                    images = [...this.staticImages[category]];
                } else {
                    images = [...this.defaultImages];
                }
                
                // Mélanger les images pour la variété
                images = this.shuffleArray(images);
                
                // Garder seulement 4 images maximum
                images = images.slice(0, 4);
                
                return {
                    ...place,
                    images: images
                };
            });
        }
        
        shuffleArray(array) {
            const newArray = [...array];
            for (let i = newArray.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [newArray[i], newArray[j]] = [newArray[j], newArray[i]];
            }
            return newArray;
        }
        
        showSamplePlaces() {
            // Données de démonstration avec images statiques
            this.places = [
                {
                    id: 1,
                    name: 'Château Frontenac',
                    description: 'Hôtel historique emblématique de Québec',
                    latitude: 46.8117,
                    longitude: -71.2044,
                    category: 'hotel',
                    address: '1 Rue des Carrières, Québec, QC',
                    phone: '+1-418-692-3861',
                    website: 'https://www.fairmont.com/frontenac-quebec/'
                },
                {
                    id: 2,
                    name: 'Tour CN',
                    description: 'Tour de communication emblématique de Toronto',
                    latitude: 43.6426,
                    longitude: -79.3871,
                    category: 'monument',
                    address: '290 Bremner Blvd, Toronto, ON',
                    phone: '+1-416-868-6937',
                    website: 'https://www.cntower.ca'
                }
            ];
            
            // Ajouter des images statiques
            this.addStaticImagesToPlaces();
            
            this.updatePlacesCount();
            this.renderPlacesList();
            this.addMarkersToMap();
        }
        
        addMarkersToMap() {
            this.clearMarkers();
            
            this.places.forEach(place => {
                this.createMarker(place);
            });
            
            if (this.places.length > 0) {
                const bounds = this.getMarkersBounds();
                this.map.fitBounds(bounds, { padding: [50, 50] });
            }
        }
        
        clearMarkers() {
            Object.values(this.markers).forEach(marker => {
                if (marker && marker.remove) {
                    marker.remove();
                }
            });
            this.markers = {};
            
            // Supprimer les tooltips
            Object.values(this.tooltips).forEach(tooltip => {
                if (tooltip && tooltip.remove) {
                    tooltip.remove();
                }
            });
            this.tooltips = {};
        }
        
        createMarker(place) {
            const icon = L.divIcon({
                className: 'custom-marker',
                html: `
                    <div class="marker-icon marker-${place.category}" 
                         style="background: ${this.getCategoryColor(place.category)};">
                        <i class="${this.getCategoryIcon(place.category)}"></i>
                    </div>
                `,
                iconSize: [40, 40],
                iconAnchor: [20, 40],
                popupAnchor: [0, -40]
            });
            
            const marker = L.marker([place.latitude, place.longitude], { 
                icon: icon,
                title: place.name
            }).addTo(this.map);
            
            // Créer un tooltip pour le survol
            const tooltip = L.tooltip({
                direction: 'top',
                className: 'place-tooltip',
                offset: [0, -10],
                permanent: false,
                opacity: 0.9,
                interactive: true
            })
            .setContent(this.createTooltipContent(place))
            .setLatLng([place.latitude, place.longitude]);
            
            // Événements de survol
            marker.on('mouseover', () => {
                this.highlightPlace(place.id);
                tooltip.addTo(this.map);
            });
            
            marker.on('mouseout', () => {
                this.unhighlightPlace(place.id);
                setTimeout(() => {
                    if (!this.isMouseOverTooltip) {
                        tooltip.remove();
                    }
                }, 100);
            });
            
            marker.on('click', () => {
                this.showPlaceModal(place);
            });
            
            // Gérer les événements du tooltip
            tooltip.on('add', () => {
                this.setupTooltipEvents(tooltip, place);
            });
            
            this.markers[place.id] = marker;
            this.tooltips[place.id] = tooltip;
            
            return marker;
        }
        
        setupTooltipEvents(tooltip, place) {
            // Attendre que le tooltip soit rendu
            setTimeout(() => {
                const tooltipElement = tooltip.getElement();
                if (tooltipElement) {
                    // Gérer l'entrée/sortie de la souris
                    tooltipElement.addEventListener('mouseenter', () => {
                        this.isMouseOverTooltip = true;
                        this.highlightPlace(place.id);
                    });
                    
                    tooltipElement.addEventListener('mouseleave', () => {
                        this.isMouseOverTooltip = false;
                        this.unhighlightPlace(place.id);
                        setTimeout(() => {
                            if (!this.isMouseOverTooltip) {
                                tooltip.remove();
                            }
                        }, 100);
                    });
                    
                    // Trouver le bouton dans le tooltip
                    const detailsBtn = tooltipElement.querySelector('.tooltip-details-btn');
                    if (detailsBtn) {
                        detailsBtn.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            this.showPlaceModal(place);
                        });
                    }
                }
            }, 50);
        }
        
        createTooltipContent(place) {
            const firstImage = place.images && place.images.length > 0 
                ? place.images[0] 
                : 'https://via.placeholder.com/200x150?text=No+Image';
            
            return `
                <div style="min-width:200px; padding:10px;">
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                        <div style="width:40px; height:40px; border-radius:50%; background:${this.getCategoryColor(place.category)}; display:flex; align-items:center; justify-content:center;">
                            <i class="${this.getCategoryIcon(place.category)}" style="color:white; font-size:18px;"></i>
                        </div>
                        <div>
                            <strong style="color:#1a1a1a; font-size:15px;">${place.name}</strong>
                            <div style="font-size:12px; color:#666; margin-top:2px;">${this.capitalizeFirstLetter(place.category)}</div>
                        </div>
                    </div>
                    <div style="width:100%; height:100px; border-radius:6px; overflow:hidden; margin-bottom:8px;">
                        <img src="${firstImage}" alt="${place.name}" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <p style="margin:0; font-size:12px; color:#666; line-height:1.4; -webkit-line-clamp: 3;">
                        ${place.description?.substring(0, 30) || 'Aucune description disponible'}...
                    </p>
                    <div style="margin-top:10px; text-align:center;">
                        <button class="tooltip-details-btn" 
                                style="background:#4299e1; color:white; border:none; border-radius:4px; padding:8px 15px; font-size:13px; cursor:pointer; width:100%; transition:all 0.3s ease;">
                            <i class="fas fa-info-circle"></i> Voir détails complets
                        </button>
                    </div>
                </div>
            `;
        }
        
        highlightPlace(placeId) {
            // Mettre en surbrillance le marqueur
            const marker = this.markers[placeId];
            if (marker) {
                const iconElement = marker.getElement();
                if (iconElement) {
                    const markerIcon = iconElement.querySelector('.marker-icon');
                    if (markerIcon) {
                        markerIcon.classList.add('highlighted');
                    }
                }
            }
            
            // Mettre en surbrillance l'élément dans la sidebar
            const placeElement = document.querySelector(`.place-item[data-id="${placeId}"]`);
            if (placeElement) {
                placeElement.classList.add('active');
                
                // Faire défiler jusqu'à l'élément
                placeElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }
        
        unhighlightPlace(placeId) {
            // Retirer la surbrillance du marqueur
            const marker = this.markers[placeId];
            if (marker) {
                const iconElement = marker.getElement();
                if (iconElement) {
                    const markerIcon = iconElement.querySelector('.marker-icon');
                    if (markerIcon) {
                        markerIcon.classList.remove('highlighted');
                    }
                }
            }
            
            // Retirer la surbrillance de l'élément dans la sidebar
            const placeElement = document.querySelector(`.place-item[data-id="${placeId}"]`);
            if (placeElement) {
                placeElement.classList.remove('active');
            }
        }
        
        getCategoryColor(category) {
            const colors = {
                restaurant: '#e53e3e',
                hotel: '#38a169',
                museum: '#805ad5',
                park: '#d69e2e',
                shopping: '#3182ce',
                monument: '#dd6b20',
                default: '#718096'
            };
            return colors[category] || colors.default;
        }
        
        getCategoryIcon(category) {
            const icons = {
                restaurant: 'fas fa-utensils',
                hotel: 'fas fa-hotel',
                museum: 'fas fa-landmark',
                park: 'fas fa-tree',
                shopping: 'fas fa-shopping-bag',
                monument: 'fas fa-monument',
                default: 'fas fa-map-marker-alt'
            };
            return icons[category] || icons.default;
        }
        
        getMarkersBounds() {
            const bounds = L.latLngBounds();
            this.places.forEach(place => {
                bounds.extend([place.latitude, place.longitude]);
            });
            return bounds;
        }
        
        renderPlacesList() {
            const container = document.getElementById('places-list');
            if (!container) return;
            
            container.innerHTML = '';
            
            if (this.places.length === 0) {
                container.innerHTML = `
                    <div class="no-results">
                        <i class="fas fa-map-marker-alt"></i>
                        <h4>Aucun lieu trouvé</h4>
                        <p>Essayez de modifier vos filtres de recherche</p>
                    </div>
                `;
                return;
            }
            
            this.places.forEach(place => {
                const placeEl = this.createPlaceElement(place);
                container.appendChild(placeEl);
            });
        }
        
        createPlaceElement(place) {
            const div = document.createElement('div');
            div.className = 'place-item';
            div.dataset.id = place.id;
            
            const image = place.images && place.images.length > 0 
                ? place.images[0] 
                : 'https://via.placeholder.com/400x150?text=No+Image';
            
            div.innerHTML = `
                <div class="place-image">
                    <img src="${image}" alt="${place.name}" loading="lazy">
                </div>
                <div class="place-info">
                    <h4>${place.name}</h4>
                    <span class="place-category" style="background:${this.getCategoryColor(place.category)}">
                        ${this.capitalizeFirstLetter(place.category)}
                    </span>
                    <p class="place-description">${place.description?.substring(0, 100) || 'Aucune description disponible'}...</p>
                    <div class="place-actions">
                        <button class="btn view-details-btn" data-id="${place.id}" style="background:#4299e1; color:white;">
                            <i class="fas fa-eye"></i> Détails
                        </button>
                        <button class="btn locate-btn-small" data-id="${place.id}" style="background:#48bb78; color:white;">
                            <i class="fas fa-map-marker-alt"></i> Carte
                        </button>
                    </div>
                </div>
            `;
            
            // Événements pour la sidebar
            div.addEventListener('mouseenter', () => {
                this.highlightPlace(place.id);
            });
            
            div.addEventListener('mouseleave', () => {
                this.unhighlightPlace(place.id);
            });
            
            div.querySelector('.view-details-btn').addEventListener('click', (e) => {
                e.stopPropagation();
                this.showPlaceModal(place);
            });
            
            div.querySelector('.locate-btn-small').addEventListener('click', (e) => {
                e.stopPropagation();
                this.centerOnPlace(place);
            });
            
            div.addEventListener('click', (e) => {
                if (!e.target.closest('button')) {
                    this.showPlaceModal(place);
                }
            });
            
            return div;
        }
        
        centerOnPlace(place) {
            this.map.setView([place.latitude, place.longitude], 15);
            this.highlightPlace(place.id);
            
            // Ouvrir le tooltip
            const tooltip = this.tooltips[place.id];
            if (tooltip) {
                tooltip.addTo(this.map);
                
                // Fermer le tooltip après 3 secondes
                setTimeout(() => {
                    tooltip.remove();
                }, 3000);
            }
        }
        
        showPlaceModal(place) {
            const modal = document.getElementById('place-modal');
            const modalContent = document.getElementById('modal-content');
            
            if (!modal || !modalContent) return;
            
            this.activePlace = place;
            modalContent.innerHTML = this.createModalContent(place);
            modal.style.display = 'block';
            
            // Initialiser Swiper avec un délai
            setTimeout(() => {
                this.initModalSwiper();
            }, 100);
            
            this.centerOnPlace(place);
        }
        
        createModalContent(place) {
            const images = place.images && place.images.length > 0 
                ? place.images 
                : ['https://via.placeholder.com/800x400?text=No+Image'];
            
            return `
                <div class="place-modal-content">
                    <!-- Slider d'images -->
                    <div class="modal-slider">
                        <div class="swiper modalSwiper">
                            <div class="swiper-wrapper">
                                ${images.map((img, index) => `
                                    <div class="swiper-slide">
                                        <img src="${img}" alt="${place.name} - Image ${index + 1}" loading="lazy">
                                        <div class="image-counter">${index + 1} / ${images.length}</div>
                                    </div>
                                `).join('')}
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    
                    <!-- Thumbnails -->
                    <div class="modal-thumbnails" id="modalThumbnails">
                        ${images.map((img, index) => `
                            <div class="thumbnail ${index === 0 ? 'active' : ''}" data-index="${index}">
                                <img src="${img}" alt="Thumbnail ${index + 1}" loading="lazy">
                            </div>
                        `).join('')}
                    </div>
                    
                    <!-- Contenu de la modal -->
                    <div style="padding:30px;">
                        <div class="modal-header" style="margin-bottom:25px;">
                            <h2 style="margin:0 0 10px 0; color:#1a1a1a; font-size:1.8rem;">${place.name}</h2>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <span style="background:${this.getCategoryColor(place.category)}; color:white; padding:6px 16px; border-radius:20px; font-size:14px; font-weight:500;">
                                    ${this.capitalizeFirstLetter(place.category)}
                                </span>
                                <span style="color:#666; font-size:14px;">
                                    <i class="fas fa-map-marker-alt"></i> ${this.getProvinceName(place.latitude, place.longitude)}
                                </span>
                            </div>
                        </div>
                        
                        <div class="place-details">
                            ${place.description ? `
                                <div style="margin-bottom:30px;">
                                    <h4 style="color:#333; margin-bottom:15px; font-size:1.2rem;">
                                        <i class="fas fa-info-circle" style="color:#4299e1;"></i> Description
                                    </h4>
                                    <p style="color:#666; line-height:1.6; font-size:16px;">${place.description}</p>
                                </div>
                            ` : ''}
                            
                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(250px, 1fr)); gap:20px; margin-bottom:30px;">
                                ${place.address ? `
                                    <div style="background:#f8f9fa; padding:20px; border-radius:10px; border-left:4px solid #4299e1;">
                                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                                            <i class="fas fa-map-marker-alt" style="color:#4299e1; font-size:18px;"></i>
                                            <strong style="color:#333; font-size:16px;">Adresse</strong>
                                        </div>
                                        <p style="margin:0; color:#666; font-size:15px;">${place.address}</p>
                                    </div>
                                ` : ''}
                                
                                ${place.phone ? `
                                    <div style="background:#f8f9fa; padding:20px; border-radius:10px; border-left:4px solid #38a169;">
                                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                                            <i class="fas fa-phone" style="color:#38a169; font-size:18px;"></i>
                                            <strong style="color:#333; font-size:16px;">Contact</strong>
                                        </div>
                                        <p style="margin:0; color:#666; font-size:15px;">
                                            <a href="tel:${place.phone}" style="color:#4299e1; text-decoration:none; font-weight:500;">${place.phone}</a>
                                        </p>
                                    </div>
                                ` : ''}
                                
                                ${place.website ? `
                                    <div style="background:#f8f9fa; padding:20px; border-radius:10px; border-left:4px solid #805ad5;">
                                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                                            <i class="fas fa-globe" style="color:#805ad5; font-size:18px;"></i>
                                            <strong style="color:#333; font-size:16px;">Site web</strong>
                                        </div>
                                        <p style="margin:0;">
                                            <a href="${place.website}" target="_blank" style="color:#4299e1; text-decoration:none; font-weight:500; font-size:15px;">Visiter le site officiel</a>
                                        </p>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                        
                        <div style="display:flex; gap:15px; margin-top:30px; padding-top:25px; border-top:1px solid #e0e0e0;">
                            <button onclick="window.mapApp.getDirections(${JSON.stringify(place).replace(/"/g, '&quot;')})" 
                                    style="flex:1; padding:14px; background:#48bb78; color:white; border:none; border-radius:8px; cursor:pointer; font-size:16px; font-weight:500; display:flex; align-items:center; justify-content:center; gap:10px;">
                                <i class="fas fa-route"></i> Itinéraire
                            </button>
                            <button onclick="window.mapApp.closeModal()" 
                                    style="flex:1; padding:14px; background:#f0f0f0; color:#333; border:none; border-radius:8px; cursor:pointer; font-size:16px; font-weight:500; display:flex; align-items:center; justify-content:center; gap:10px;">
                                <i class="fas fa-times"></i> Fermer
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }
        
        initModalSwiper() {
            // Détruire Swiper existant
            if (this.swiper && this.swiper.destroy) {
                try {
                    this.swiper.destroy(true, true);
                } catch (error) {
                    console.warn('Error destroying Swiper:', error);
                }
                this.swiper = null;
            }
            
            // Vérifier si Swiper est chargé
            if (typeof Swiper === 'undefined') {
                console.error('Swiper is not loaded');
                return;
            }
            
            // Vérifier si l'élément Swiper existe
            const swiperElement = document.querySelector('.modalSwiper');
            if (!swiperElement) {
                console.error('Swiper element not found');
                return;
            }
            
            try {
                this.swiper = new Swiper('.modalSwiper', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                    on: {
                        init: () => {
                            console.log('Swiper initialized');
                            // Mettre à jour les thumbnails après l'initialisation
                            setTimeout(() => {
                                this.updateThumbnails();
                            }, 50);
                        },
                        slideChange: () => {
                            this.updateThumbnails();
                        }
                    }
                });
                
                // Gérer les thumbnails
                this.setupThumbnailEvents();
                
            } catch (error) {
                console.error('Error initializing Swiper:', error);
            }
        }
        
        setupThumbnailEvents() {
            // Attendre que le DOM soit mis à jour
            setTimeout(() => {
                const thumbnails = document.querySelectorAll('.thumbnail');
                if (!thumbnails || thumbnails.length === 0) {
                    return;
                }
                
                thumbnails.forEach(thumbnail => {
                    // Retirer les anciens événements
                    const newThumbnail = thumbnail.cloneNode(true);
                    thumbnail.parentNode.replaceChild(newThumbnail, thumbnail);
                });
                
                // Référencer les nouveaux éléments
                const newThumbnails = document.querySelectorAll('.thumbnail');
                
                newThumbnails.forEach(thumbnail => {
                    thumbnail.addEventListener('click', () => {
                        if (!this.swiper) return;
                        
                        const index = parseInt(thumbnail.dataset.index);
                        if (!isNaN(index)) {
                            this.swiper.slideTo(index);
                            this.updateThumbnails();
                        }
                    });
                });
            }, 100);
        }
        
        updateThumbnails() {
            // Vérifier si Swiper est initialisé
            if (!this.swiper || !this.swiper.realIndex) {
                return;
            }
            
            const thumbnails = document.querySelectorAll('.thumbnail');
            if (!thumbnails || thumbnails.length === 0) {
                return;
            }
            
            const activeIndex = this.swiper.realIndex;
            
            thumbnails.forEach((thumbnail, index) => {
                if (index === activeIndex) {
                    thumbnail.classList.add('active');
                } else {
                    thumbnail.classList.remove('active');
                }
            });
        }
        
        getDirections(place) {
            // Vérifier si place est défini
            if (!place) {
                console.error('Place is undefined');
                return;
            }
            
            // Vérifier si l'utilisateur est localisé
            if (!this.currentLocation) {
                alert('Veuillez d\'abord vous localiser en cliquant sur "Me localiser" pour calculer un itinéraire.');
                return;
            }
            
            // Vérifier les coordonnées
            if (!place.latitude || !place.longitude) {
                alert('Impossible de calculer l\'itinéraire : coordonnées du lieu manquantes.');
                return;
            }
            
            const startLat = this.currentLocation.lat;
            const startLng = this.currentLocation.lng;
            const endLat = place.latitude;
            const endLng = place.longitude;
            
            // Calculer la distance
            const distance = this.calculateDistance(startLat, startLng, endLat, endLng);
            
            // Ouvrir Google Maps avec l'itinéraire
            const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${startLat},${startLng}&destination=${endLat},${endLng}&travelmode=driving`;
            
            // Afficher une confirmation
            const confirmMessage = `Calcul d'itinéraire vers "${place.name}":
            
            • Distance: ${distance.toFixed(1)} km
            • Départ: Votre position actuelle
            • Arrivée: ${place.address || 'Destination'}

            Voulez-vous ouvrir Google Maps pour voir l'itinéraire détaillé ?`;
            
            if (confirm(confirmMessage)) {
                window.open(googleMapsUrl, '_blank');
            }
            
            // Fermer la modal
            this.closeModal();
        }
        
        calculateDistance(lat1, lon1, lat2, lon2) {
            // Formule de Haversine pour calculer la distance en km
            const R = 6371; // Rayon de la Terre en km
            const dLat = this.deg2rad(lat2 - lat1);
            const dLon = this.deg2rad(lon2 - lon1);
            const a = 
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(this.deg2rad(lat1)) * Math.cos(this.deg2rad(lat2)) * 
                Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }
        
        deg2rad(deg) {
            return deg * (Math.PI/180);
        }
        
        getProvinceName(lat, lng) {
            // Simple approximation pour déterminer la province
            const provinces = {
                'qc': { lat: 52.9399, lng: -73.5491, name: 'Québec' },
                'on': { lat: 51.2538, lng: -85.3232, name: 'Ontario' },
                'bc': { lat: 53.7267, lng: -127.6476, name: 'Colombie-Britannique' },
                'ab': { lat: 53.9333, lng: -116.5765, name: 'Alberta' },
                'mb': { lat: 53.7609, lng: -98.8139, name: 'Manitoba' },
                'sk': { lat: 52.9399, lng: -106.4509, name: 'Saskatchewan' },
                'ns': { lat: 44.6820, lng: -63.7443, name: 'Nouvelle-Écosse' },
                'nb': { lat: 46.5653, lng: -66.4619, name: 'Nouveau-Brunswick' },
                'nl': { lat: 53.1355, lng: -57.6604, name: 'Terre-Neuve-et-Labrador' },
                'pe': { lat: 46.5107, lng: -63.4168, name: 'Île-du-Prince-Édouard' }
            };
            
            let closestProvince = 'Canada';
            let minDistance = Infinity;
            
            for (const [code, province] of Object.entries(provinces)) {
                const distance = Math.sqrt(
                    Math.pow(lat - province.lat, 2) + 
                    Math.pow(lng - province.lng, 2)
                );
                if (distance < minDistance) {
                    minDistance = distance;
                    closestProvince = province.name;
                }
            }
            
            return closestProvince;
        }
        
        setupEventListeners() {
            // Filtre de province
            const provinceFilter = document.getElementById('province-filter');
            if (provinceFilter) {
                provinceFilter.addEventListener('change', (e) => {
                    this.selectedProvince = e.target.value;
                    
                    // Centrer sur la province si une province spécifique est sélectionnée
                    if (this.selectedProvince) {
                        const option = e.target.selectedOptions[0];
                        const lat = parseFloat(option.dataset.lat);
                        const lng = parseFloat(option.dataset.lng);
                        
                        if (!isNaN(lat) && !isNaN(lng)) {
                            this.map.setView([lat, lng], 6);
                        }
                    }
                    
                    this.loadPlaces();
                });
            }
            
            // Filtre de catégorie
            const categoryFilter = document.getElementById('category-filter');
            if (categoryFilter) {
                categoryFilter.addEventListener('change', (e) => {
                    this.selectedCategory = e.target.value;
                    this.loadPlaces();
                });
            }
            
            // Filtre de rayon
            const radiusSlider = document.getElementById('radius-filter');
            const radiusValue = document.getElementById('radius-value');
            
            if (radiusSlider && radiusValue) {
                radiusSlider.addEventListener('input', (e) => {
                    this.radius = parseInt(e.target.value);
                    radiusValue.textContent = `${this.radius} km`;
                });
                
                radiusSlider.addEventListener('change', () => {
                    this.loadPlaces();
                });
            }
            
            // Bouton "Me localiser"
            const locateBtn = document.getElementById('locate-me');
            if (locateBtn) {
                locateBtn.addEventListener('click', () => {
                    this.locateUser();
                });
            }
            
            // Fermer la modal
            document.querySelector('.close-modal')?.addEventListener('click', () => {
                this.closeModal();
            });
            
            // Fermer au clic en dehors
            window.addEventListener('click', (e) => {
                const modal = document.getElementById('place-modal');
                if (e.target === modal) {
                    this.closeModal();
                }
            });
            
            // Touche Échap
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.closeModal();
                }
            });
        }
        
        locateUser() {
            if (!navigator.geolocation) {
                alert('La géolocalisation n\'est pas supportée par votre navigateur.');
                return;
            }
            
            // Afficher un indicateur de chargement
            const locateBtn = document.getElementById('locate-me');
            const originalHTML = locateBtn.innerHTML;
            locateBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Localisation...';
            locateBtn.disabled = true;
            
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const { latitude, longitude } = position.coords;
                    this.currentLocation = { lat: latitude, lng: longitude };
                    
                    // Centrer la carte sur la position
                    this.map.setView([latitude, longitude], 12);
                    
                    // Ajouter un marqueur pour la position de l'utilisateur
                    this.addUserMarker(latitude, longitude);
                    
                    // Charger les lieux autour de la position
                    this.loadPlaces();
                    
                    // Restaurer le bouton
                    locateBtn.innerHTML = originalHTML;
                    locateBtn.disabled = false;
                },
                (error) => {
                    console.error('Erreur de géolocalisation:', error);
                    let errorMessage = 'Impossible de vous localiser.';
                    
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = 'Autorisation de géolocalisation refusée. Veuillez autoriser l\'accès à votre position.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = 'Informations de localisation non disponibles.';
                            break;
                        case error.TIMEOUT:
                            errorMessage = 'La demande de localisation a expiré.';
                            break;
                    }
                    
                    alert(errorMessage);
                    
                    // Restaurer le bouton
                    locateBtn.innerHTML = originalHTML;
                    locateBtn.disabled = false;
                },
                {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0
                }
            );
        }
        
        addUserMarker(lat, lng) {
            // Supprimer l'ancien marqueur s'il existe
            if (this.userMarker) {
                this.userMarker.remove();
            }
            
            // Créer un marqueur personnalisé pour l'utilisateur
            const userIcon = L.divIcon({
                className: 'custom-marker',
                html: `
                    <div class="user-marker-icon">
                        <i class="fas fa-user"></i>
                    </div>
                `,
                iconSize: [50, 50],
                iconAnchor: [25, 50],
                popupAnchor: [0, -50]
            });
            
            // Ajouter le marqueur
            this.userMarker = L.marker([lat, lng], { 
                icon: userIcon,
                title: 'Votre position'
            }).addTo(this.map);
            
            // Ajouter une popup
            this.userMarker.bindPopup(`
                <div style="text-align:center; padding:10px;">
                    <h4 style="margin:0 0 10px 0; color:#4299e1;">
                        <i class="fas fa-user"></i> Votre position
                    </h4>
                    <p style="margin:0; font-size:14px; color:#666;">
                        Latitude: ${lat.toFixed(6)}<br>
                        Longitude: ${lng.toFixed(6)}
                    </p>
                </div>
            `).openPopup();
            
            // Animer le marqueur
            this.animateUserMarker();
        }
        
        animateUserMarker() {
            if (!this.userMarker) return;
            
            const markerElement = this.userMarker.getElement();
            if (markerElement) {
                const userIcon = markerElement.querySelector('.user-marker-icon');
                if (userIcon) {
                    // Ajouter une animation de pulsation
                    userIcon.style.animation = 'userMarkerPulse 2s infinite';
                }
            }
        }
        
        closeModal() {
            // Détruire Swiper avant de fermer
            if (this.swiper && this.swiper.destroy) {
                try {
                    this.swiper.destroy(true, true);
                } catch (error) {
                    console.warn('Error destroying Swiper:', error);
                }
                this.swiper = null;
            }
            
            const modal = document.getElementById('place-modal');
            if (modal) {
                modal.style.display = 'none';
            }
            
            this.activePlace = null;
        }
        
        updatePlacesCount() {
            const countEl = document.getElementById('places-count');
            if (countEl) {
                countEl.textContent = this.places.length;
            }
        }
        
        capitalizeFirstLetter(string) {
            if (!string) return '';
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    }
    
    // Initialisation
    document.addEventListener('DOMContentLoaded', () => {
        try {
            window.mapApp = new InteractiveMap();
            console.log('Application carte interactive prête');
        } catch (error) {
            console.error('Erreur fatale:', error);
            alert('Erreur lors du chargement de l\'application. Veuillez recharger la page.');
        }
    });
</script>
<script>
    // Gestion des onglets avec liens
document.addEventListener('DOMContentLoaded', function() {
    const tabLinks = document.querySelectorAll('.tab-link');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    // Fonction pour changer d'onglet
    function switchTab(tabId) {
        // Retirer la classe active de tous les liens
        tabLinks.forEach(link => link.classList.remove('active'));
        // Ajouter la classe active au lien cliqué
        document.querySelector(`.tab-link[data-tab="${tabId}"]`).classList.add('active');
        
        // Masquer tous les panneaux
        tabPanes.forEach(pane => pane.classList.remove('active'));
        // Afficher le panneau correspondant
        document.getElementById(`tab-${tabId}`).classList.add('active');
        
        // Mettre à jour l'URL hash sans déclencher le scroll
        history.pushState(null, null, `#${tabId}`);
    }
    
    // Gérer les clics sur les liens d'onglets
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const tabId = this.getAttribute('data-tab');
            switchTab(tabId);
        });
    });
    
    // Vérifier l'URL hash au chargement
    const hash = window.location.hash.replace('#', '');
    const validTabs = ['carte', 'info', 'generale'];
    
    if (validTabs.includes(hash)) {
        switchTab(hash);
    }
    
    // Gestion des paramètres
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('change', function() {
            document.body.classList.toggle('dark-mode', this.checked);
            localStorage.setItem('darkMode', this.checked);
        });
        
        // Charger la préférence mode sombre
        const darkMode = localStorage.getItem('darkMode') === 'true';
        darkModeToggle.checked = darkMode;
        if (darkMode) {
            document.body.classList.add('dark-mode');
        }
    }
    
    // Gestion de la date de mise à jour
    const lastUpdateDate = document.getElementById('lastUpdateDate');
    if (lastUpdateDate) {
        lastUpdateDate.textContent = new Date().toLocaleDateString('fr-FR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }
    
    // Gestion des données
    const clearCacheBtn = document.getElementById('clearCacheBtn');
    if (clearCacheBtn) {
        clearCacheBtn.addEventListener('click', function() {
            if (confirm('Êtes-vous sûr de vouloir vider le cache ? Toutes vos préférences seront réinitialisées.')) {
                localStorage.clear();
                alert('Cache vidé avec succès ! La page va être rechargée.');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        });
    }
    
    const refreshDataBtn = document.getElementById('refreshDataBtn');
    if (refreshDataBtn) {
        refreshDataBtn.addEventListener('click', function() {
            if (confirm('Actualiser les données ?')) {
                // Simuler le chargement des données
                const btn = this;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualisation...';
                btn.disabled = true;
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    alert('Données actualisées avec succès !');
                }, 2000);
            }
        });
    }
    
    // Sauvegarder les paramètres
    const defaultRadius = document.getElementById('defaultRadius');
    const autoLocationToggle = document.getElementById('autoLocationToggle');
    const mapStyleSelect = document.getElementById('mapStyleSelect');
    
    if (defaultRadius) {
        defaultRadius.addEventListener('change', function() {
            localStorage.setItem('defaultRadius', this.value);
        });
        
        const savedRadius = localStorage.getItem('defaultRadius');
        if (savedRadius) {
            defaultRadius.value = savedRadius;
        }
    }
    
    if (autoLocationToggle) {
        autoLocationToggle.addEventListener('change', function() {
            localStorage.setItem('autoLocation', this.checked);
        });
        
        const savedAutoLocation = localStorage.getItem('autoLocation') === 'true';
        autoLocationToggle.checked = savedAutoLocation;
    }
    
    if (mapStyleSelect) {
        mapStyleSelect.addEventListener('change', function() {
            localStorage.setItem('mapStyle', this.value);
        });
        
        const savedMapStyle = localStorage.getItem('mapStyle') || 'streets';
        mapStyleSelect.value = savedMapStyle;
    }
});
</script>
</body>
</html>