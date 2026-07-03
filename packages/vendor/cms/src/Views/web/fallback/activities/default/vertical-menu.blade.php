@php(ob_start());@endphp
{{-- Menu Vertical Principal Component --}}
<div class="vertical-menu-v2-overlay" id="verticalMenuOverlay"></div>

<aside class="vertical-menu-v2" id="verticalMenuV2">
    <div class="vertical-menu-v2-header">
        <h2 class="vertical-menu-v2-title">ESPACES GO EXPLORIA</h2>
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
            
            {{-- Menus principaux Espaces Go Exploria --}}
            <li class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="espaces-medias">
                <a href="#" class="vertical-menu-v2-link">
                    <span>Espaces M&eacute;dias</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </li>
            <li class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="espaces-next-level">
                <a href="#" class="vertical-menu-v2-link">
                    <span>Espaces Next Level</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </li>
            <li class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="restaurants-alimentations">
                <a href="#" class="vertical-menu-v2-link">
                    <span>Espaces Restaurants &amp; Alimentations</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </li>
            <li class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="vedettes">
                <a href="#" class="vertical-menu-v2-link">
                    <span>Espaces Vedettes</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </li>
            <li class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="espaces-voyages-forfaits">
                <a href="#" class="vertical-menu-v2-link">
                    <span>Espaces Voyages &amp; Forfaits Touristique</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </li>
            <li class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="marketplace">
                <a href="#" class="vertical-menu-v2-link">
                    <span>Espaces Market Place</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </li>
            <li class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="a-la-une">
                <a href="#" class="vertical-menu-v2-link">
                    <span>Espaces &Agrave; la Une</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
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

                    {{-- BLOC 1 : ESPACES MÉDIAS --}}
                    <li class="vertical-menu-v2-subcat">Espaces M&eacute;dias</li>
                    <li><a href="#tourisme-business" class="vertical-menu-v2-sublink">Espaces Tourisme et Business</a></li>
                    <li><a href="#activez-destinations" class="vertical-menu-v2-sublink">Activez votre Espaces Destinations</a></li>
                    <li><a href="#geo-carte-videos" class="vertical-menu-v2-sublink">Espace Géo-Carte-Vidéos</a></li>
                    <li><a href="#multilingue" class="vertical-menu-v2-sublink">Espaces Multilingues</a></li>
                    <li><a href="#slideshow" class="vertical-menu-v2-sublink">Espaces Slide-Show Multiples</a></li>
                    <li><a href="#go-tik-tok" class="vertical-menu-v2-sublink">Espaces Go-Tik-Tok</a></li>
                    <li><a href="#my-tube" class="vertical-menu-v2-sublink">Espaces My-Tube</a></li>
                    <li><a href="#chaine-videos" class="vertical-menu-v2-sublink">Espaces Chaine Vidéos</a></li>
                    <li><a href="#photos" class="vertical-menu-v2-sublink">Espaces Photos</a></li>
                    <li><a href="#reseaux-sociaux" class="vertical-menu-v2-sublink">Espaces Réseaux Sociaux</a></li>
                    <li><a href="#pinterest" class="vertical-menu-v2-sublink">Espaces Inspiration Pinterest</a></li>
                    <li><a href="#avis-clients" class="vertical-menu-v2-sublink">Espaces Avis Clients</a></li>

                    {{-- BLOC 2 : ESPACES NEXT LEVEL --}}
                    <li class="vertical-menu-v2-subcat">Espaces Next Level</li>
                    <li><a href="#optimisez" class="vertical-menu-v2-sublink">Optimisez votre Présence en Ligne</a></li>
                    <li><a href="#partenaires-master" class="vertical-menu-v2-sublink">Partenaires Master User Go Exploria</a></li>
                    <li><a href="#activez-destinations" class="vertical-menu-v2-sublink">Activez votre Espaces Destinations</a></li>
                    <li><a href="#activez-entreprises" class="vertical-menu-v2-sublink">Activez votre Espaces Entreprises</a></li>
                    <li><a href="#activez-perso" class="vertical-menu-v2-sublink">Activez votre Espaces Perso</a></li>
                    <li><a href="#plans-next-level" class="vertical-menu-v2-sublink">Espaces Plans Next Level</a></li>
                    <li><a href="#partenaires-affilies" class="vertical-menu-v2-sublink">Espaces Partenaires Affiliés</a></li>
                    <li><a href="#editeur-site" class="vertical-menu-v2-sublink">Espaces éditeur de Site Web</a></li>
                    <li><a href="#editeur-entreprises" class="vertical-menu-v2-sublink">Editeur d'Espaces Entreprises</a></li>
                    <li><a href="#editeur-perso" class="vertical-menu-v2-sublink">Editeur d'Espaces Perso</a></li>
                    <li><a href="#geo-carte-videos" class="vertical-menu-v2-sublink">Espaces Géo-Carte-Vidéos</a></li>
                    <li><a href="#blog" class="vertical-menu-v2-sublink">Espaces Blog</a></li>
                    <li><a href="#api" class="vertical-menu-v2-sublink">Espaces API</a></li>
                    <li><a href="#mail" class="vertical-menu-v2-sublink">Espaces Mail</a></li>
                    <li><a href="#chat" class="vertical-menu-v2-sublink">Espaces Module Chat</a></li>
                    <li><a href="#formulaires" class="vertical-menu-v2-sublink">Espaces Formulaires</a></li>
                    <li><a href="#cta" class="vertical-menu-v2-sublink">Espaces Call-to-Actions</a></li>
                    <li><a href="#seo" class="vertical-menu-v2-sublink">Performances SEO International</a></li>
                    <li><a href="#tele-positionnement" class="vertical-menu-v2-sublink">Espaces T&eacute;l&eacute;-Positionnement</a></li>
                    <li><a href="https://goexploriabusiness.com/welcome-2" target="_blank" class="vertical-menu-v2-sublink">Fonctionnalit&eacute;s Compl&egrave;tes ↗</a></li>

                    {{-- BLOC 3 : RESTAURANTS ET ALIMENTATIONS --}}
                    <li class="vertical-menu-v2-subcat">Restaurants &amp; Alimentations</li>
                    <li><a href="#ambiances-restaurants" class="vertical-menu-v2-sublink">Espaces Ambiances Restaurants</a></li>
                    <li><a href="#mets-vins" class="vertical-menu-v2-sublink">Espaces Menu Accord Mets &amp; Vins</a></li>
                    <li><a href="#cartes-vins" class="vertical-menu-v2-sublink">Espace Cartes des Vins</a></li>
                    <li><a href="#reseautage" class="vertical-menu-v2-sublink">R&eacute;seautages Resto, H&eacute;bergement, Activit&eacute;s</a></li>
                    <li><a href="#boulangeries" class="vertical-menu-v2-sublink">Boulangeries, &Eacute;picerie Fine, Terroir</a></li>
                    <li><a href="#bannieres" class="vertical-menu-v2-sublink">Banni&egrave;res Alimentations (IGA, M&eacute;tro, Super C)</a></li>

                    {{-- BLOC 4 : ESPACES VEDETTES --}}
                    <li class="vertical-menu-v2-subcat">Espaces Vedettes</li>
                    <li><a href="#videos-vedettes" class="vertical-menu-v2-sublink">Espaces Vid&eacute;os Vedettes</a></li>
                    <li><a href="#restaurants-vedettes" class="vertical-menu-v2-sublink">Espaces Restaurants Vedettes</a></li>
                    <li><a href="#hebergements-vedettes" class="vertical-menu-v2-sublink">Espaces H&eacute;bergements Vedettes</a></li>
                    <li><a href="#destinations-vedettes" class="vertical-menu-v2-sublink">Espaces Destinations Vedettes</a></li>
                    <li><a href="#evenements-vedettes" class="vertical-menu-v2-sublink">Espaces &Eacute;v&eacute;nements Vedettes</a></li>
                    <li><a href="#produits-vedettes" class="vertical-menu-v2-sublink">Espaces Produits Vedettes</a></li>
                    <li><a href="#entreprises-vedettes" class="vertical-menu-v2-sublink">Espaces Entreprises Vedettes</a></li>
                    <li><a href="#galeries-vedettes" class="vertical-menu-v2-sublink">Espaces Galeries Vedettes</a></li>
                    <li><a href="#grandes-chaines" class="vertical-menu-v2-sublink">Espaces Grandes Cha&icirc;nes</a></li>

                    {{-- BLOC 5 : VOYAGES & FORFAITS --}}
                    <li class="vertical-menu-v2-subcat">Voyages &amp; Forfaits Touristique International</li>
                    <li><a href="#forfaits-quebec" class="vertical-menu-v2-sublink">Espaces Forfait Qu&eacute;bec</a></li>
                    <li><a href="#nouveaux-forfaits" class="vertical-menu-v2-sublink">Espaces Nouveaux Forfaits</a></li>
                    <li><a href="#forfaits-europe" class="vertical-menu-v2-sublink">Espaces Forfaits Europe</a></li>
                    <li><a href="#affichez-forfaits" class="vertical-menu-v2-sublink">Affichez votre Forfaits</a></li>
                    <li><a href="#creez-forfaits" class="vertical-menu-v2-sublink">Cr&eacute;ez vos Forfaits</a></li>
                    <li><a href="#alertes-voyages" class="vertical-menu-v2-sublink">Espaces Alertes Voyages</a></li>
                    <li><a href="#aeroports" class="vertical-menu-v2-sublink">Espaces A&eacute;roport du Monde</a></li>
                    <li><a href="#explorez-inattendu" class="vertical-menu-v2-sublink">Explorez l&apos;Inattendu / Activit&eacute;s Plein Air</a></li>
                    <li><a href="#idees-aventures" class="vertical-menu-v2-sublink">Espaces Id&eacute;es d&apos;Aventures</a></li>
                    <li><a href="#activites-4-saisons" class="vertical-menu-v2-sublink">Espaces Activit&eacute;s Quatre Saisons</a></li>
                    <li><a href="#activites-hiver" class="vertical-menu-v2-sublink">Espaces Activit&eacute;s Hivernales</a></li>
                    <li><a href="#activites-ete" class="vertical-menu-v2-sublink">Espaces Activit&eacute;s Printemps &Eacute;t&eacute;</a></li>
                    <li><a href="#activites-automne" class="vertical-menu-v2-sublink">Espaces Activit&eacute;s Automnales</a></li>

                    {{-- BLOC 6 : MARKETPLACE --}}
                    <li class="vertical-menu-v2-subcat">Marketplace</li>
                    <li><a href="#petites-annonces" class="vertical-menu-v2-sublink">Espaces Mes Petites Annonces</a></li>
                    <li><a href="#produits-marketplace" class="vertical-menu-v2-sublink">Affichez vos Produits d&apos;Ici et d&apos;Ailleurs</a></li>
                    <li><a href="#certificats" class="vertical-menu-v2-sublink">Certificats-Cartes-Produits Cadeaux</a></li>
                    <li><a href="#packages-cadeaux" class="vertical-menu-v2-sublink">Espaces Packages Cadeaux</a></li>

                    {{-- BLOC 7 : ESPACES SPÉCIALISÉS --}}
                    <li class="vertical-menu-v2-subcat">Espaces Sp&eacute;cialis&eacute;s</li>
                    <li><a href="#immo-quebec" class="vertical-menu-v2-sublink">Immo Qu&eacute;bec</a></li>
                    <li><a href="#chalets-a-louer" class="vertical-menu-v2-sublink">Chalets &agrave; Louer</a></li>
                    <li><a href="#marches-alimentations" class="vertical-menu-v2-sublink">March&eacute;s d&apos;Alimentations</a></li>
                    <li><a href="#location-vehicules" class="vertical-menu-v2-sublink">Location Auto, VUS, V&eacute;hicules R&eacute;cr&eacute;atifs 4 Saisons</a></li>
                    <li><a href="#chalets-vendre" class="vertical-menu-v2-sublink">Espaces Chalets &agrave; Vendre</a></li>
                    <li><a href="#maisons-chalets" class="vertical-menu-v2-sublink">Espaces Maisons Chalets &agrave; Vendre</a></li>
                    <li><a href="#projet-immo" class="vertical-menu-v2-sublink">Espaces Projet Immobilier Touristique</a></li>

                    {{-- BLOC 8 : À LA UNE --}}
                    <li class="vertical-menu-v2-subcat">&Agrave; la Une</li>
                    <li><a href="#nouvelles-heure" class="vertical-menu-v2-sublink">Espaces Nouvelles de l&apos;Heure</a></li>
                    <li><a href="#dernieres-nouvelles" class="vertical-menu-v2-sublink">Derni&egrave;re Nouvelle</a></li>
                    <li><a href="#nouvelles-regions" class="vertical-menu-v2-sublink">Nouvelle par R&eacute;gions</a></li>

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
    @include('cms::web.fallback.activities.default.vertical-destinations-mega-menu')

    {{-- Mega Menu Sections (Médias, Next Level, etc.) --}}
    @include('home-v2.components.VerticalSectionsMegaMenu')
</aside>
@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp

