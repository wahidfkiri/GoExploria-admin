{{-- Menu Vertical Principal Component --}}
<div class="vertical-menu-v2-overlay" id="verticalMenuOverlay"></div>

<aside class="vertical-menu-v2" id="verticalMenuV2">
    <div class="vertical-menu-v2-header">
        <h2 class="vertical-menu-v2-title">Menu Principal</h2>
        <button class="vertical-menu-v2-close" id="closeVerticalMenu" aria-label="Fermer le menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
    
    <nav class="vertical-menu-v2-content">
        <ul class="vertical-menu-v2-list" id="verticalMenuList">
            {{-- Menu Destinations avec Mega Menu (TOUJOURS EN PREMIER) --}}
            <li class="vertical-menu-v2-item vertical-menu-v2-destinations-item">
                <a href="#" class="vertical-menu-v2-link vertical-menu-v2-destinations-trigger">
                    <span>🌍 Destinations</span>
                </a>
            </li>
            
            {{-- Les menus principaux seront chargés dynamiquement par JavaScript depuis l'API --}}
            <li class="vertical-menu-v2-item vertical-menu-v2-loading">
                <div class="vertical-menu-v2-loader">
                    <div class="spinner"></div>
                    <span>Chargement des menus...</span>
                </div>
            </li>
            
            {{-- Menu horizontal ajouté sur mobile/tablette (NE PAS TOUCHER) --}}
            <li class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="#valeurs" class="vertical-menu-v2-link">
                    <span>Nos Valeurs</span>
                </a>
            </li>
            
            {{-- Accordéon Vidéos avec liste des vidéos --}}
            <li class="vertical-menu-v2-item vertical-menu-v2-mobile-only vertical-menu-v2-accordion">
                <button class="vertical-menu-v2-link vertical-menu-v2-accordion-trigger" data-accordion="videos">
                    <span>Nos vidéos</span>
                    <svg class="vertical-menu-v2-accordion-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <ul class="vertical-menu-v2-submenu vertical-menu-v2-videos-submenu" id="submenu-videos">
                    {{-- Les vidéos seront chargées dynamiquement par JavaScript --}}
                </ul>
            </li>
            
            <li class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="#faq" class="vertical-menu-v2-link">
                    <span>FAQ</span>
                </a>
            </li>
            
            {{-- Accordéon Nos Services avec sous-menus --}}
            <li class="vertical-menu-v2-item vertical-menu-v2-mobile-only vertical-menu-v2-accordion">
                <button class="vertical-menu-v2-link vertical-menu-v2-accordion-trigger" data-accordion="services">
                    <span>Nos Services</span>
                    <svg class="vertical-menu-v2-accordion-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <ul class="vertical-menu-v2-submenu" id="submenu-services">
                    <li><a href="#videos" class="vertical-menu-v2-sublink">Videos</a></li>
                    <li><a href="#forfaits-voyage" class="vertical-menu-v2-sublink">Forfaits Voyage</a></li>
                    <li><a href="#alertes-voyage" class="vertical-menu-v2-sublink">Alertes Voyage</a></li>
                    <li><a href="#vols-direct" class="vertical-menu-v2-sublink">Vols en Direct</a></li>
                    <li><a href="#idees-aventures" class="vertical-menu-v2-sublink">Idées Aventures</a></li>
                    <li><a href="#activites-4-saisons" class="vertical-menu-v2-sublink">Activités 4 Saisons</a></li>
                    <li><a href="#activites-hivernales" class="vertical-menu-v2-sublink">Activités Hivernales</a></li>
                    <li><a href="#pinterest" class="vertical-menu-v2-sublink">Pinterest</a></li>
                    <li><a href="#temoignage" class="vertical-menu-v2-sublink">Témoignage</a></li>
                    <li><a href="#agence-conseil" class="vertical-menu-v2-sublink">Agence de Conseil</a></li>
                    <li><a href="#biens-immobiliers" class="vertical-menu-v2-sublink">Nos Biens Immobiliers</a></li>
                    <li><a href="#partenaires-master" class="vertical-menu-v2-sublink">Partenaires Master</a></li>
                    <li><a href="#dernieres-nouvelles" class="vertical-menu-v2-sublink">Dernières Nouvelles</a></li>
                    <li><a href="#nouvelles-region" class="vertical-menu-v2-sublink">Nouvelles Par Région</a></li>
                    <li><a href="#lecteur-media" class="vertical-menu-v2-sublink">Lecteur Media Slideshow</a></li>
                    <li><a href="#vetements-chauds" class="vertical-menu-v2-sublink">Vêtements Chauds</a></li>
                    <li><a href="#vos-forfaits" class="vertical-menu-v2-sublink">Vos Forfaits</a></li>
                    <li><a href="#solutions-web" class="vertical-menu-v2-sublink">Solutions Web Professionnelles</a></li>
                    <li><a href="#excellence-pro" class="vertical-menu-v2-sublink">Excellence Professionnelle</a></li>
                    <li><a href="#carte-interactive" class="vertical-menu-v2-sublink">Carte Interactive</a></li>
                    <li><a href="#fonctionnalites" class="vertical-menu-v2-sublink">Fonctionnalités Complètes</a></li>
                </ul>
            </li>
            
            <li class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="#inscription" class="vertical-menu-v2-link">
                    <span>Inscription</span>
                </a>
            </li>
            
            <li class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="#compte" class="vertical-menu-v2-link">
                    <span>Mon Compte</span>
                </a>
            </li>
            
            <li class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="#contact" class="vertical-menu-v2-link">
                    <span>Contact</span>
                </a>
            </li>
        </ul>
    </nav>
    
    {{-- Mega Menu Destinations --}}
    @include('home-v2.components.VerticalDestinationsMegaMenu')
</aside>
