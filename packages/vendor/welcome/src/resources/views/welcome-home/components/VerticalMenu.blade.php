@php(ob_start());@endphp
{{-- Menu Vertical Principal Component --}}
@php
$tr = static function (string $text): string {
    $locale = app()->getLocale();
    if ($locale === 'fr') { return $text; }
    static $maps = [];
    if (! array_key_exists($locale, $maps)) {
        $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
        $maps[$locale] = is_file($path) ? (require $path) : [];
    }
    return $maps[$locale][$text] ?? $text;
};
@endphp

<div class="vertical-menu-v2-overlay" id="verticalMenuOverlay"></div>

<aside class="vertical-menu-v2" id="verticalMenuV2">
    <div class="vertical-menu-v2-header">
        <h2 class="vertical-menu-v2-title"><img src="{{asset('logo.png')}}" alt="Go Exploria" class="vertical-menu-v2-logo"></h2>
        <button class="vertical-menu-v2-close" id="closeVerticalMenu" aria-label="Fermer le menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <nav class="vertical-menu-v2-content">
        <div class="vertical-menu-v2-list" id="verticalMenuList">
            {{-- Destinations (toujours en premier) --}}
            <div class="vertical-menu-v2-item vertical-menu-v2-destinations-item">
                <a href="#" class="vertical-menu-v2-link vertical-menu-v2-destinations-trigger">
                    <span>&#127758; {{ $tr('Destinations') }}</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </div>

            {{-- Pictos (i / iT / iB / EE / ED / MP / Car / Plane / P&GO) --}}
            <div class="vmenu">
                <div class="vmenu-quick-link-item" id="vmenuTriggerInfo" title="{{ $tr('Informations') }}">
                    <div class="icon-circle icon-blue"><span class="picto-label">i</span></div>
                </div>
                <div class="vmenu-quick-link-item" id="vmenuTriggerTourisme" title="{{ $tr('Activités Tourisme') }}">
                    <div class="icon-circle icon-blue"><span class="picto-label">iT</span></div>
                </div>
                <div class="vmenu-quick-link-item" id="vmenuTriggerBusiness" title="{{ $tr('Activités Business') }}">
                    <div class="icon-circle icon-blue"><span class="picto-label">iB</span></div>
                </div>
                <div class="vmenu-quick-link-item" id="vmenuTriggerEE" title="{{ $tr('Espace Entreprise') }}">
                    <div class="icon-circle icon-blue"><span class="picto-label">EE</span></div>
                </div>
                <div class="vmenu-quick-link-item" id="vmenuTriggerED" title="{{ $tr('Espace Destination') }}">
                    <div class="icon-circle icon-blue"><span class="picto-label">ED</span></div>
                </div>
                <div class="vmenu-quick-link-item" id="vmenuTriggerMP" title="{{ $tr('Marketplace') }}">
                    <div class="icon-circle icon-blue"><span class="picto-label">MP</span></div>
                </div>
                <div class="vmenu-quick-link-item" id="vmenuTriggerCar" title="{{ $tr('Location Véhicule') }}">
                    <div class="icon-circle icon-blue"><i class="fas fa-car picto-icon"></i></div>
                </div>
                <div class="vmenu-quick-link-item" id="vmenuTriggerPlane" title="{{ $tr('Billets Avion') }}">
                    <div class="icon-circle icon-blue"><i class="fas fa-plane picto-icon"></i></div>
                </div>
                <div class="vmenu-quick-link-item" id="vmenuTriggerPlanGo" title="{{ $tr('Plan & GO') }}">
                    <div class="icon-circle icon-blue" style="font-size:9px;font-weight:800;"><span class="picto-label">P&GO</span></div>
                </div>
            </div>

            {{-- Section items --}}
            <div class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="espaces-medias">
                <a href="#" class="vertical-menu-v2-link"><span>Espaces M&eacute;dias</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="espaces-next-level">
                <a href="#" class="vertical-menu-v2-link"><span>Espaces Next Level</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="restaurants-alimentations">
                <a href="#" class="vertical-menu-v2-link"><span>Espaces Restaurants &amp; Alimentations</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="vedettes">
                <a href="#" class="vertical-menu-v2-link"><span>Espaces Vedettes</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="espaces-voyages-forfaits">
                <a href="#" class="vertical-menu-v2-link"><span>Espaces Voyages &amp; Forfaits Touristique</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="marketplace">
                <a href="#" class="vertical-menu-v2-link"><span>Espaces Market Place</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="a-la-une">
                <a href="#" class="vertical-menu-v2-link"><span>Espaces &Agrave; la Une</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            </div>

            {{-- Mobile-only items --}}
            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="#valeurs" class="vertical-menu-v2-link"><span>INFO GO</span></a>
            </div>

            {{-- Accordéon Nos Services --}}
            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only vertical-menu-v2-accordion">
                <button class="vertical-menu-v2-link vertical-menu-v2-accordion-trigger" data-accordion="services">
                    <span>Nos Services</span>
                    <svg class="vertical-menu-v2-accordion-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="vertical-menu-v2-submenu" id="submenu-services">
                    <div class="vertical-menu-v2-subcat">Espaces M&eacute;dias</div>
                    <div><a href="#tourisme-business" class="vertical-menu-v2-sublink">Espaces Tourisme et Business</a></div>
                    <div><a href="#activez-destinations" class="vertical-menu-v2-sublink">Activez votre Espaces Destinations</a></div>
                    <div><a href="#geo-carte-videos" class="vertical-menu-v2-sublink">Espace Géo-Carte-Vidéos</a></div>
                    <div><a href="#multilingue" class="vertical-menu-v2-sublink">Espaces Multilingues</a></div>
                    <div><a href="#slideshow" class="vertical-menu-v2-sublink">Espaces Slide-Show Multiples</a></div>
                    <div><a href="#go-tik-tok" class="vertical-menu-v2-sublink">Espaces Go-Tik-Tok</a></div>
                    <div><a href="#my-tube" class="vertical-menu-v2-sublink">Espaces My-Tube</a></div>
                    <div><a href="#chaine-videos" class="vertical-menu-v2-sublink">Espaces Chaine Vidéos</a></div>
                    <div><a href="#photos" class="vertical-menu-v2-sublink">Espaces Photos</a></div>
                    <div><a href="#reseaux-sociaux" class="vertical-menu-v2-sublink">Espaces Réseaux Sociaux</a></div>
                    <div><a href="#pinterest" class="vertical-menu-v2-sublink">Espaces Inspiration Pinterest</a></div>
                    <div><a href="#avis-clients" class="vertical-menu-v2-sublink">Espaces Avis Clients</a></div>

                    <div class="vertical-menu-v2-subcat">Espaces Next Level</div>
                    <div><a href="#optimisez" class="vertical-menu-v2-sublink">Optimisez votre Présence en Ligne</a></div>
                    <div><a href="#partenaires-master" class="vertical-menu-v2-sublink">Partenaires Master User Go Exploria</a></div>
                    <div><a href="#activez-destinations" class="vertical-menu-v2-sublink">Activez votre Espaces Destinations</a></div>
                    <div><a href="#activez-entreprises" class="vertical-menu-v2-sublink">Activez votre Espaces Entreprises</a></div>
                    <div><a href="#activez-perso" class="vertical-menu-v2-sublink">Activez votre Espaces Perso</a></div>
                    <div><a href="#plans-next-level" class="vertical-menu-v2-sublink">Espaces Plans Next Level</a></div>
                    <div><a href="#partenaires-affilies" class="vertical-menu-v2-sublink">Espaces Partenaires Affiliés</a></div>
                    <div><a href="#editeur-site" class="vertical-menu-v2-sublink">Espaces éditeur de Site Web</a></div>
                    <div><a href="#editeur-entreprises" class="vertical-menu-v2-sublink">Editeur d'Espaces Entreprises</a></div>
                    <div><a href="#editeur-perso" class="vertical-menu-v2-sublink">Editeur d'Espaces Perso</a></div>
                    <div><a href="#geo-carte-videos" class="vertical-menu-v2-sublink">Espaces Géo-Carte-Vidéos</a></div>
                    <div><a href="#blog" class="vertical-menu-v2-sublink">Espaces Blog</a></div>
                    <div><a href="#api" class="vertical-menu-v2-sublink">Espaces API</a></div>
                    <div><a href="#mail" class="vertical-menu-v2-sublink">Espaces Mail</a></div>
                    <div><a href="#chat" class="vertical-menu-v2-sublink">Espaces Module Chat</a></div>
                    <div><a href="#formulaires" class="vertical-menu-v2-sublink">Espaces Formulaires</a></div>
                    <div><a href="#cta" class="vertical-menu-v2-sublink">Espaces Call-to-Actions</a></div>
                    <div><a href="#seo" class="vertical-menu-v2-sublink">Performances SEO International</a></div>
                    <div><a href="#tele-positionnement" class="vertical-menu-v2-sublink">Espaces T&eacute;l&eacute;-Positionnement</a></div>
                    <div><a href="https://goexploriabusiness.com/welcome-2" target="_blank" class="vertical-menu-v2-sublink">Fonctionnalit&eacute;s Compl&egrave;tes &nearr;</a></div>

                    <div class="vertical-menu-v2-subcat">Restaurants &amp; Alimentations</div>
                    <div><a href="#ambiances-restaurants" class="vertical-menu-v2-sublink">Espaces Ambiances Restaurants</a></div>
                    <div><a href="#mets-vins" class="vertical-menu-v2-sublink">Espaces Menu Accord Mets &amp; Vins</a></div>
                    <div><a href="#cartes-vins" class="vertical-menu-v2-sublink">Espace Cartes des Vins</a></div>
                    <div><a href="#reseautage" class="vertical-menu-v2-sublink">R&eacute;seautages Resto, H&eacute;bergement, Activit&eacute;s</a></div>
                    <div><a href="#boulangeries" class="vertical-menu-v2-sublink">Boulangeries, &Eacute;picerie Fine, Terroir</a></div>
                    <div><a href="#bannieres" class="vertical-menu-v2-sublink">Banni&egrave;res Alimentations (IGA, M&eacute;tro, Super C)</a></div>

                    <div class="vertical-menu-v2-subcat">Espaces Vedettes</div>
                    <div><a href="#videos-vedettes" class="vertical-menu-v2-sublink">Espaces Vid&eacute;os Vedettes</a></div>
                    <div><a href="#restaurants-vedettes" class="vertical-menu-v2-sublink">Espaces Restaurants Vedettes</a></div>
                    <div><a href="#hebergements-vedettes" class="vertical-menu-v2-sublink">Espaces H&eacute;bergements Vedettes</a></div>
                    <div><a href="#destinations-vedettes" class="vertical-menu-v2-sublink">Espaces Destinations Vedettes</a></div>
                    <div><a href="#evenements-vedettes" class="vertical-menu-v2-sublink">Espaces &Eacute;v&eacute;nements Vedettes</a></div>
                    <div><a href="#produits-vedettes" class="vertical-menu-v2-sublink">Espaces Produits Vedettes</a></div>
                    <div><a href="#entreprises-vedettes" class="vertical-menu-v2-sublink">Espaces Entreprises Vedettes</a></div>
                    <div><a href="#galeries-vedettes" class="vertical-menu-v2-sublink">Espaces Galeries Vedettes</a></div>
                    <div><a href="#grandes-chaines" class="vertical-menu-v2-sublink">Espaces Grandes Cha&icirc;nes</a></div>

                    <div class="vertical-menu-v2-subcat">Voyages &amp; Forfaits Touristique International</div>
                    <div><a href="#forfaits-quebec" class="vertical-menu-v2-sublink">Espaces Forfait Qu&eacute;bec</a></div>
                    <div><a href="#nouveaux-forfaits" class="vertical-menu-v2-sublink">Espaces Nouveaux Forfaits</a></div>
                    <div><a href="#forfaits-europe" class="vertical-menu-v2-sublink">Espaces Forfaits Europe</a></div>
                    <div><a href="#affichez-forfaits" class="vertical-menu-v2-sublink">Affichez votre Forfaits</a></div>
                    <div><a href="#creez-forfaits" class="vertical-menu-v2-sublink">Cr&eacute;ez vos Forfaits</a></div>
                    <div><a href="#alertes-voyages" class="vertical-menu-v2-sublink">Espaces Alertes Voyages</a></div>
                    <div><a href="#aeroports" class="vertical-menu-v2-sublink">Espaces A&eacute;roport du Monde</a></div>
                    <div><a href="#explorez-inattendu" class="vertical-menu-v2-sublink">Explorez l&apos;Inattendu / Activit&eacute;s Plein Air</a></div>
                    <div><a href="#idees-aventures" class="vertical-menu-v2-sublink">Espaces Id&eacute;es d&apos;Aventures</a></div>
                    <div><a href="#activites-4-saisons" class="vertical-menu-v2-sublink">Espaces Activit&eacute;s Quatre Saisons</a></div>
                    <div><a href="#activites-hiver" class="vertical-menu-v2-sublink">Espaces Activit&eacute;s Hivernales</a></div>
                    <div><a href="#activites-ete" class="vertical-menu-v2-sublink">Espaces Activit&eacute;s Printemps &Eacute;t&eacute;</a></div>
                    <div><a href="#activites-automne" class="vertical-menu-v2-sublink">Espaces Activit&eacute;s Automnales</a></div>

                    <div class="vertical-menu-v2-subcat">Marketplace</div>
                    <div><a href="#petites-annonces" class="vertical-menu-v2-sublink">Espaces Mes Petites Annonces</a></div>
                    <div><a href="#produits-marketplace" class="vertical-menu-v2-sublink">Affichez vos Produits d&apos;Ici et d&apos;Ailleurs</a></div>
                    <div><a href="#certificats" class="vertical-menu-v2-sublink">Certificats-Cartes-Produits Cadeaux</a></div>
                    <div><a href="#packages-cadeaux" class="vertical-menu-v2-sublink">Espaces Packages Cadeaux</a></div>

                    <div class="vertical-menu-v2-subcat">Espaces Sp&eacute;cialis&eacute;s</div>
                    <div><a href="#immo-quebec" class="vertical-menu-v2-sublink">Immo Qu&eacute;bec</a></div>
                    <div><a href="#chalets-a-louer" class="vertical-menu-v2-sublink">Chalets &agrave; Louer</a></div>
                    <div><a href="#marches-alimentations" class="vertical-menu-v2-sublink">March&eacute;s d&apos;Alimentations</a></div>
                    <div><a href="#location-vehicules" class="vertical-menu-v2-sublink">Location Auto, VUS, V&eacute;hicules R&eacute;cr&eacute;atifs 4 Saisons</a></div>
                    <div><a href="#chalets-vendre" class="vertical-menu-v2-sublink">Espaces Chalets &agrave; Vendre</a></div>
                    <div><a href="#maisons-chalets" class="vertical-menu-v2-sublink">Espaces Maisons Chalets &agrave; Vendre</a></div>
                    <div><a href="#projet-immo" class="vertical-menu-v2-sublink">Espaces Projet Immobilier Touristique</a></div>

                    <div class="vertical-menu-v2-subcat">&Agrave; la Une</div>
                    <div><a href="#nouvelles-heure" class="vertical-menu-v2-sublink">Espaces Nouvelles de l&apos;Heure</a></div>
                    <div><a href="#dernieres-nouvelles" class="vertical-menu-v2-sublink">Derni&egrave;re Nouvelle</a></div>
                    <div><a href="#nouvelles-regions" class="vertical-menu-v2-sublink">Nouvelle par R&eacute;gions</a></div>
                </div>
            </div>

            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('contact') }}" class="vertical-menu-v2-link"><span>Contact</span></a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('inscription') }}" class="vertical-menu-v2-link"><span>Inscription</span></a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('mon-compte') }}" class="vertical-menu-v2-link"><span>Mon Compte</span></a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('devis') }}" class="vertical-menu-v2-link"><span>Devis Gratuit</span></a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('favoris') }}" class="vertical-menu-v2-link"><span>Mes Favoris</span></a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('panier') }}" class="vertical-menu-v2-link"><span>Mon Panier</span></a>
            </div>
        </div>
    </nav>

    {{-- Mega Menus --}}
    @include('welcome-home.components.VerticalDestinationsMegaMenu')
    @include('welcome-home.components.VerticalSectionsMegaMenu')

    {{-- Source components — rendered once, moved into panels by JS --}}
    <div class="vmenu-components-source">
        @include('welcome-home.components.InfoMegaMenu')
        @include('welcome-home.components.CategoriesMegaMenu')
        @include('welcome-home.components.HeroQuickMegaMenus')
    </div>

    {{-- Inline Mega Panels for vmenu pictos --}}
    <div class="vmenu-destinations-mega vmenu-inline-panel" id="vmenuPanelInfo">
        <div class="vmenu-destinations-mega-header">
            <h3 class="vmenu-destinations-mega-title">
                <svg class="vmenu-destinations-mega-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <span>{{ $tr('Informations') }}</span>
            </h3>
            <button class="vmenu-destinations-mega-close vmenu-inline-close" data-panel="vmenuPanelInfo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="vmenu-destinations-mega-content vmenu-panel-content" id="vmenuContentInfo"></div>
    </div>

    <div class="vmenu-destinations-mega vmenu-inline-panel" id="vmenuPanelTourisme">
        <div class="vmenu-destinations-mega-header">
            <h3 class="vmenu-destinations-mega-title">
                <svg class="vmenu-destinations-mega-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <span>{{ $tr('Activités Tourisme') }}</span>
            </h3>
            <button class="vmenu-destinations-mega-close vmenu-inline-close" data-panel="vmenuPanelTourisme">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="vmenu-destinations-mega-content vmenu-panel-content" id="vmenuContentTourisme"></div>
    </div>

    <div class="vmenu-destinations-mega vmenu-inline-panel" id="vmenuPanelBusiness">
        <div class="vmenu-destinations-mega-header">
            <h3 class="vmenu-destinations-mega-title">
                <svg class="vmenu-destinations-mega-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                <span>{{ $tr('Activités Business') }}</span>
            </h3>
            <button class="vmenu-destinations-mega-close vmenu-inline-close" data-panel="vmenuPanelBusiness">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="vmenu-destinations-mega-content vmenu-panel-content" id="vmenuContentBusiness"></div>
    </div>

    <div class="vmenu-destinations-mega vmenu-inline-panel" id="vmenuPanelEE">
        <div class="vmenu-destinations-mega-header">
            <h3 class="vmenu-destinations-mega-title">
                <svg class="vmenu-destinations-mega-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span>{{ $tr('Espace Entreprise') }}</span>
            </h3>
            <button class="vmenu-destinations-mega-close vmenu-inline-close" data-panel="vmenuPanelEE">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="vmenu-destinations-mega-content vmenu-panel-content" id="vmenuContentEE"></div>
    </div>

    <div class="vmenu-destinations-mega vmenu-inline-panel" id="vmenuPanelED">
        <div class="vmenu-destinations-mega-header">
            <h3 class="vmenu-destinations-mega-title">
                <svg class="vmenu-destinations-mega-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <span>{{ $tr('Espace Destination') }}</span>
            </h3>
            <button class="vmenu-destinations-mega-close vmenu-inline-close" data-panel="vmenuPanelED">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="vmenu-destinations-mega-content vmenu-panel-content" id="vmenuContentED"></div>
    </div>

    <div class="vmenu-destinations-mega vmenu-inline-panel" id="vmenuPanelMP">
        <div class="vmenu-destinations-mega-header">
            <h3 class="vmenu-destinations-mega-title">
                <svg class="vmenu-destinations-mega-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <span>{{ $tr('Marketplace') }}</span>
            </h3>
            <button class="vmenu-destinations-mega-close vmenu-inline-close" data-panel="vmenuPanelMP">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="vmenu-destinations-mega-content vmenu-panel-content" id="vmenuContentMP"></div>
    </div>

    <div class="vmenu-destinations-mega vmenu-inline-panel" id="vmenuPanelCar">
        <div class="vmenu-destinations-mega-header">
            <h3 class="vmenu-destinations-mega-title">
                <svg class="vmenu-destinations-mega-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 16H9m10 0h3V9l-3-5H5L2 9v7h3m10 0a2 2 0 1 1-4 0m4 0a2 2 0 1 0-4 0"/></svg>
                <span>{{ $tr('Location Véhicule') }}</span>
            </h3>
            <button class="vmenu-destinations-mega-close vmenu-inline-close" data-panel="vmenuPanelCar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="vmenu-destinations-mega-content vmenu-panel-content" id="vmenuContentCar"></div>
    </div>

    <div class="vmenu-destinations-mega vmenu-inline-panel" id="vmenuPanelPlane">
        <div class="vmenu-destinations-mega-header">
            <h3 class="vmenu-destinations-mega-title">
                <svg class="vmenu-destinations-mega-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/></svg>
                <span>{{ $tr('Billets Avion') }}</span>
            </h3>
            <button class="vmenu-destinations-mega-close vmenu-inline-close" data-panel="vmenuPanelPlane">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="vmenu-destinations-mega-content vmenu-panel-content" id="vmenuContentPlane"></div>
    </div>

    <div class="vmenu-destinations-mega vmenu-inline-panel" id="vmenuPanelPlanGo">
        <div class="vmenu-destinations-mega-header">
            <h3 class="vmenu-destinations-mega-title">
                <svg class="vmenu-destinations-mega-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                <span>{{ $tr('Plan & GO') }}</span>
            </h3>
            <button class="vmenu-destinations-mega-close vmenu-inline-close" data-panel="vmenuPanelPlanGo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="vmenu-destinations-mega-content vmenu-panel-content" id="vmenuContentPlanGo"></div>
    </div>
</aside>

@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
