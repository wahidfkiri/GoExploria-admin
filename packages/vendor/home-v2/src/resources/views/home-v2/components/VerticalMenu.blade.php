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
            
            {{-- Accordéon Nos Services — miroir exact du mega menu desktop --}}
            <li class="vertical-menu-v2-item vertical-menu-v2-mobile-only vertical-menu-v2-accordion">
                <button class="vertical-menu-v2-link vertical-menu-v2-accordion-trigger" data-accordion="services">
                    <span>Nos Services</span>
                    <svg class="vertical-menu-v2-accordion-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <ul class="vertical-menu-v2-submenu" id="submenu-services">
                    <li class="vertical-menu-v2-subcat">Explorer</li>
                    <li><a href="#carte-interactive" class="vertical-menu-v2-sublink">Carte Interactive</a></li>
                    <li><a href="#destinations-vedette" class="vertical-menu-v2-sublink">Destinations Vedettes</a></li>
                    <li><a href="#evenements-vedette" class="vertical-menu-v2-sublink">&Eacute;v&eacute;nements Vedettes</a></li>
                    <li><a href="#tourisme-business" class="vertical-menu-v2-sublink">Tourisme &amp; Business</a></li>
                    <li class="vertical-menu-v2-subcat">M&eacute;dias</li>
                    <li><a href="#goexploria-mytube" class="vertical-menu-v2-sublink">GoExploria MyTube</a></li>
                    <li><a href="#goexploria-tiktok" class="vertical-menu-v2-sublink">Cha&icirc;ne TikTok</a></li>
                    <li><a href="#news-section" class="vertical-menu-v2-sublink">Derni&egrave;res Nouvelles</a></li>
                    <li class="vertical-menu-v2-subcat">Voyages</li>
                    <li><a href="#forfaits-voyages" class="vertical-menu-v2-sublink">Forfaits Voyages</a></li>
                    <li><a href="#alertes-voyages" class="vertical-menu-v2-sublink">Alertes &amp; Infos Voyages</a></li>
                    <li><a href="#resto-service-block" class="vertical-menu-v2-sublink">Restaurant &amp; Table</a></li>
                    <li class="vertical-menu-v2-subcat">Services Pro</li>
                    <li><a href="#consulting-section" class="vertical-menu-v2-sublink">Agence de Conseil</a></li>
                    <li><a href="#partners-master" class="vertical-menu-v2-sublink">Partenaires Master</a></li>
                    <li><a href="#web-services" class="vertical-menu-v2-sublink">Solutions Web</a></li>
                    <li><a href="#real-estate-section" class="vertical-menu-v2-sublink">Immobilier</a></li>
                    <li><a href="#enterprise-multilingual" class="vertical-menu-v2-sublink">Espace Multilingue</a></li>
                </ul>
            </li>
            
            <li class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('contact') }}" class="vertical-menu-v2-link">
                    <span>Contact</span>
                </a>
            </li>
            
            <li class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('inscription') }}" class="vertical-menu-v2-link">
                    <span>Inscription</span>
                </a>
            </li>
            
            <li class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('mon-compte') }}" class="vertical-menu-v2-link">
                    <span>Mon Compte</span>
                </a>
            </li>
            
            <li class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('devis') }}" class="vertical-menu-v2-link">
                    <span>Devis Gratuit</span>
                </a>
            </li>
            
            <li class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('favoris') }}" class="vertical-menu-v2-link">
                    <span>Mes Favoris</span>
                </a>
            </li>
            
            <li class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('panier') }}" class="vertical-menu-v2-link">
                    <span>Mon Panier</span>
                </a>
            </li>
        </ul>
    </nav>
    
    {{-- Mega Menu Destinations --}}
    @include('home-v2.components.VerticalDestinationsMegaMenu')
</aside>
