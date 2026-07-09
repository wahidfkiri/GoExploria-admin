@php(ob_start());@endphp
{{-- Menu Vertical Principal Component --}}
@php
$tr = static function (string $text): string {
    $locale = app()->getLocale();
    if ($locale === 'fr') {
        return $text;
    }

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
        <h2 class="vertical-menu-v2-title">ESPACES GO EXPLORIA</h2>
        <button class="vertical-menu-v2-close" id="closeVerticalMenu" aria-label="Fermer le menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
    
    <nav class="vertical-menu-v2-content">
        <div class="vertical-menu-v2-list" id="verticalMenuList">
            {{-- Menu Destinations avec Mega Menu (TOUJOURS EN PREMIER) --}}
            <div class="vertical-menu-v2-item vertical-menu-v2-destinations-item">
                <a href="#" class="vertical-menu-v2-link vertical-menu-v2-destinations-trigger">
                    <span>🌍 {{ $tr('Destinations') }}</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </div>

            {{-- Div vmenu contenant les pictos de CategoriesMegaMenu après Destinations --}}
            <div class="vmenu" style="display: flex; gap: 15px; padding: 12px 20px; align-items: center; border-bottom: 1px solid #e9ecef; background-color: #f8f9fa;">
                <div class="vmenu-quick-link-item" id="vmenuTriggerTourisme" style="cursor:pointer;" title="{{ $tr('Activités Tourisme') }}">
                    <div class="icon-circle icon-blue" style="width: 40px; height: 40px; border-radius: 50%; background-color: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.3); display: flex; align-items: center; justify-content: center; color: #d4af37; font-weight: bold; transition: all 0.2s;">
                        <span class="picto-label">iT</span>
                    </div>
                </div>
                <div class="vmenu-quick-link-item" id="vmenuTriggerBusiness" style="cursor:pointer;" title="{{ $tr('Activités Business') }}">
                    <div class="icon-circle icon-blue" style="width: 40px; height: 40px; border-radius: 50%; background-color: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.3); display: flex; align-items: center; justify-content: center; color: #d4af37; font-weight: bold; transition: all 0.2s;">
                        <span class="picto-label">iB</span>
                    </div>
                </div>
            </div>
            
            {{-- Menus principaux Espaces Go Exploria --}}
            <div class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="espaces-medias">
                <a href="#" class="vertical-menu-v2-link">
                    <span>Espaces M&eacute;dias</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="espaces-next-level">
                <a href="#" class="vertical-menu-v2-link">
                    <span>Espaces Next Level</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="restaurants-alimentations">
                <a href="#" class="vertical-menu-v2-link">
                    <span>Espaces Restaurants &amp; Alimentations</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="vedettes">
                <a href="#" class="vertical-menu-v2-link">
                    <span>Espaces Vedettes</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="espaces-voyages-forfaits">
                <a href="#" class="vertical-menu-v2-link">
                    <span>Espaces Voyages &amp; Forfaits Touristique</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="marketplace">
                <a href="#" class="vertical-menu-v2-link">
                    <span>Espaces Market Place</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </div>
            <div class="vertical-menu-v2-item vertical-menu-v2-section-item" data-section="a-la-une">
                <a href="#" class="vertical-menu-v2-link">
                    <span>Espaces &Agrave; la Une</span>
                    <svg class="vertical-menu-v2-open-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </div>
            
            {{-- Menu horizontal ajouté sur mobile/tablette (NE PAS TOUCHER) --}}
            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="#valeurs" class="vertical-menu-v2-link">
                    <span>Nos Valeurs</span>
                </a>
            </div>
            
            {{-- Accordéon Nos Services — miroir exact du mega menu desktop --}}
            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only vertical-menu-v2-accordion">
                <button class="vertical-menu-v2-link vertical-menu-v2-accordion-trigger" data-accordion="services">
                    <span>Nos Services</span>
                    <svg class="vertical-menu-v2-accordion-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="vertical-menu-v2-submenu" id="submenu-services">

                    {{-- BLOC 1 : ESPACES MÉDIAS --}}
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

                    {{-- BLOC 2 : ESPACES NEXT LEVEL --}}
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
                    <div><a href="https://goexploriabusiness.com/welcome-2" target="_blank" class="vertical-menu-v2-sublink">Fonctionnalit&eacute;s Compl&egrave;tes ↗</a></div>

                    {{-- BLOC 3 : RESTAURANTS ET ALIMENTATIONS --}}
                    <div class="vertical-menu-v2-subcat">Restaurants &amp; Alimentations</div>
                    <div><a href="#ambiances-restaurants" class="vertical-menu-v2-sublink">Espaces Ambiances Restaurants</a></div>
                    <div><a href="#mets-vins" class="vertical-menu-v2-sublink">Espaces Menu Accord Mets &amp; Vins</a></div>
                    <div><a href="#cartes-vins" class="vertical-menu-v2-sublink">Espace Cartes des Vins</a></div>
                    <div><a href="#reseautage" class="vertical-menu-v2-sublink">R&eacute;seautages Resto, H&eacute;bergement, Activit&eacute;s</a></div>
                    <div><a href="#boulangeries" class="vertical-menu-v2-sublink">Boulangeries, &Eacute;picerie Fine, Terroir</a></div>
                    <div><a href="#bannieres" class="vertical-menu-v2-sublink">Banni&egrave;res Alimentations (IGA, M&eacute;tro, Super C)</a></div>

                    {{-- BLOC 4 : ESPACES VEDETTES --}}
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

                    {{-- BLOC 5 : VOYAGES & FORFAITS --}}
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

                    {{-- BLOC 6 : MARKETPLACE --}}
                    <div class="vertical-menu-v2-subcat">Marketplace</div>
                    <div><a href="#petites-annonces" class="vertical-menu-v2-sublink">Espaces Mes Petites Annonces</a></div>
                    <div><a href="#produits-marketplace" class="vertical-menu-v2-sublink">Affichez vos Produits d&apos;Ici et d&apos;Ailleurs</a></div>
                    <div><a href="#certificats" class="vertical-menu-v2-sublink">Certificats-Cartes-Produits Cadeaux</a></div>
                    <div><a href="#packages-cadeaux" class="vertical-menu-v2-sublink">Espaces Packages Cadeaux</a></div>

                    {{-- BLOC 7 : ESPACES SPÉCIALISÉS --}}
                    <div class="vertical-menu-v2-subcat">Espaces Sp&eacute;cialis&eacute;s</div>
                    <div><a href="#immo-quebec" class="vertical-menu-v2-sublink">Immo Qu&eacute;bec</a></div>
                    <div><a href="#chalets-a-louer" class="vertical-menu-v2-sublink">Chalets &agrave; Louer</a></div>
                    <div><a href="#marches-alimentations" class="vertical-menu-v2-sublink">March&eacute;s d&apos;Alimentations</a></div>
                    <div><a href="#location-vehicules" class="vertical-menu-v2-sublink">Location Auto, VUS, V&eacute;hicules R&eacute;cr&eacute;atifs 4 Saisons</a></div>
                    <div><a href="#chalets-vendre" class="vertical-menu-v2-sublink">Espaces Chalets &agrave; Vendre</a></div>
                    <div><a href="#maisons-chalets" class="vertical-menu-v2-sublink">Espaces Maisons Chalets &agrave; Vendre</a></div>
                    <div><a href="#projet-immo" class="vertical-menu-v2-sublink">Espaces Projet Immobilier Touristique</a></div>

                    {{-- BLOC 8 : À LA UNE --}}
                    <div class="vertical-menu-v2-subcat">&Agrave; la Une</div>
                    <div><a href="#nouvelles-heure" class="vertical-menu-v2-sublink">Espaces Nouvelles de l&apos;Heure</a></div>
                    <div><a href="#dernieres-nouvelles" class="vertical-menu-v2-sublink">Derni&egrave;re Nouvelle</a></div>
                    <div><a href="#nouvelles-regions" class="vertical-menu-v2-sublink">Nouvelle par R&eacute;gions</a></div>

                </div>
            </div>
            
            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('contact') }}" class="vertical-menu-v2-link">
                    <span>Contact</span>
                </a>
            </div>
            
            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('inscription') }}" class="vertical-menu-v2-link">
                    <span>Inscription</span>
                </a>
            </div>
            
            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('mon-compte') }}" class="vertical-menu-v2-link">
                    <span>Mon Compte</span>
                </a>
            </div>
            
            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('devis') }}" class="vertical-menu-v2-link">
                    <span>Devis Gratuit</span>
                </a>
            </div>
            
            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('favoris') }}" class="vertical-menu-v2-link">
                    <span>Mes Favoris</span>
                </a>
            </div>
            
            <div class="vertical-menu-v2-item vertical-menu-v2-mobile-only">
                <a href="{{ route('cms.checkout') }}" class="vertical-menu-v2-link">
                    <span>Mon Panier</span>
                </a>
            </div>
        </div>
    </nav>
    
    {{-- Mega Menu Destinations --}}
    @include('cms::web.fallback.activities.default.vertical-destinations-mega-menu')

    {{-- Mega Menu Sections (Médias, Next Level, etc.) --}}
    @include('home-v2.components.VerticalSectionsMegaMenu')
</aside>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const vmenuTourisme = document.getElementById('vmenuTriggerTourisme');
    const vmenuBusiness = document.getElementById('vmenuTriggerBusiness');
    
    if (vmenuTourisme) {
        vmenuTourisme.addEventListener('click', (e) => {
            e.stopPropagation();
            e.preventDefault();
            // Close vertical menu
            const closeBtn = document.getElementById('closeVerticalMenu');
            if (closeBtn) closeBtn.click();
            
            // Open tourism mega panel
            const heroTrigger = document.getElementById('catMegaTriggerTourisme');
            if (heroTrigger) {
                heroTrigger.click();
            } else {
                // Fallback: Toggle manually if hero trigger not found
                const panel = document.getElementById('catMegaPanelTourisme');
                if (panel) panel.classList.toggle('open');
            }
        });
    }
    
    if (vmenuBusiness) {
        vmenuBusiness.addEventListener('click', (e) => {
            e.stopPropagation();
            e.preventDefault();
            // Close vertical menu
            const closeBtn = document.getElementById('closeVerticalMenu');
            if (closeBtn) closeBtn.click();
            
            // Open business mega panel
            const heroTrigger = document.getElementById('catMegaTriggerBusiness');
            if (heroTrigger) {
                heroTrigger.click();
            } else {
                // Fallback: Toggle manually if hero trigger not found
                const panel = document.getElementById('catMegaPanelBusiness');
                if (panel) panel.classList.toggle('open');
            }
        });
    }
});
</script>

@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp