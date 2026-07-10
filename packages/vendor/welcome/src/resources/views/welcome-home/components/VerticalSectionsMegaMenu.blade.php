@php(ob_start());@endphp
<div class="vmenu-destinations-mega" id="verticalSectionsMega">
    <div class="vmenu-destinations-mega-header">
        <h3 class="vmenu-destinations-mega-title">
            <i class="fas fa-th-large" style="color:#d4af37;font-size:20px;"></i>
            <span>Nos Espaces</span>
        </h3>
        <button class="vmenu-destinations-mega-close" aria-label="Fermer">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="vmenu-destinations-mega-content">
        <div class="vmenu-destinations-mega-grid" id="vSectionsGrid">
        </div>
    </div>
</div>

<script>
window.sectionsMenuData = {
    'espaces-medias': {
        title: 'Espaces Médias',
        categories: [
            { icon: 'fas fa-briefcase',       name: 'Espaces Tourisme et Business',        desc: 'Business & Tourisme',                         link: '#business-tourism' },
            { icon: 'fas fa-globe',           name: 'Espace Géo-Carte-Vidéos',             desc: 'Cartographie interactive',                    link: '#geo-carte-videos' },
            { icon: 'fas fa-film',            name: 'Espaces Chaîne Vidéos',               desc: 'Playlists & Lives',                           link: '#vp-chaine' },
            { icon: 'fab fa-youtube',         name: 'Espaces My-Tube',                     desc: 'Chaîne vidéos YouTube',                       link: '#my-tube' },
            { icon: 'fab fa-tiktok',          name: 'Espaces Go-Tok-Tok',                  desc: 'Vidéos courtes verticales',                   link: '#go-tok-tok' },
            { icon: 'fas fa-camera',          name: 'Espaces Photos',                      desc: 'Galeries photo multiples',                    link: '#photos' },
            { icon: 'fas fa-images',          name: 'Espaces Slide-Show Multiples',        desc: 'Galeries & Diaporamas',                       link: '#slideshow' },
            { icon: 'fas fa-language',        name: 'Espaces Multilingues',                desc: 'Contenu international',                       link: '#multilingue' },
            { icon: 'fas fa-share-alt',       name: 'Espaces Réseaux Sociaux',             desc: 'Gestion de réseaux sociaux',                  link: '#reseaux-sociaux' },
            { icon: 'fas fa-star-half-alt',   name: 'Espaces Avis Clients Google',         desc: 'Témoignages & Évaluations',                   link: '#avis-clients' },
            { icon: 'fas fa-layer-group',     name: 'Espaces Templates',                   desc: 'Templates sites web',                         link: '#espace-templates' },
            { icon: 'fas fa-envelope',        name: 'Espaces Mail',                        desc: 'Messagerie & Campagnes',                      link: '#espace-mail-marketing' },
            { icon: 'fas fa-comments',        name: 'Espaces Module Chat',                 desc: 'Ajout comme module',                          link: '#espace-chat' },
            { icon: 'fas fa-rss',             name: 'Espaces Blog',                        desc: 'Publication & Articles',                      link: '#espace-blog' },
        ]
    },
    'espaces-next-level': {
        title: 'Espaces Next Level',
        categories: [
            { icon: 'fas fa-building',        name: 'Conseils Entreprises',                desc: 'Activez votre espace entreprises',            link: '#activez-entreprises' },
            { icon: 'fas fa-rocket',          name: 'Espaces Plans Next Level',            desc: 'Liste des plans — un plan par page',          link: '#nl-plans' },
            { icon: 'fas fa-laptop-code',     name: 'Espaces Éditeur de Site Web',         desc: 'Création sans code',                          link: '#nl-editeur' },
            { icon: 'fas fa-plug',            name: 'Espaces API',                         desc: 'Intégrations & Webhooks',                     link: '#nl-api' },
            { icon: 'fas fa-paper-plane',     name: 'Espaces Formulaires',                 desc: 'Contact, Réservation, Inscription',           link: '#nl-formulaires' },
            { icon: 'fas fa-search',          name: 'Espaces Performances SEO International', desc: 'Audit & Optimisation',                     link: '#nl-seo' },
            { icon: 'fas fa-map-pin',         name: 'Espaces Télé-Positionnement',         desc: 'Géolocalisation avancée',                     link: '#nl-tele-positionnement' },
        ]
    },
    'restaurants-alimentations': {
        title: 'Espaces Restaurants et Alimentations',
        categories: [
            { icon: 'fas fa-cocktail',        name: 'Espaces Ambiances Restaurants',       desc: 'Atmosphère & Décor',                          link: '#resto-ambiance-vedette-v2' },
            { icon: 'fas fa-wine-glass-alt',  name: 'Espaces Menu Accord Mets & Vins',     desc: 'Suggestions harmonieuses',                    link: '#resto-ambiance-vedette-v2' },
            { icon: 'fas fa-wine-bottle',     name: 'Espace Cartes des Vins',              desc: 'Sélection de vins',                           link: '#resto-ambiance-vedette-v2' },
            { icon: 'fas fa-network-wired',   name: 'Espaces Réseautages Resto, Hébergement, Activités', desc: 'Partenariats & Collaborations', link: '#resto-ambiance-vedette-v2' },
            { icon: 'fas fa-bread-slice',     name: 'Espaces Boulangeries, Épicerie Fine, Terroir', desc: 'Produits du terroir',               link: '#resto-ambiance-vedette-v2' },
            { icon: 'fas fa-store-alt',       name: 'Espaces Bannières Alimentations',     desc: 'Réseaux alimentaires',                        link: '#resto-ambiance-vedette-v2' },
        ]
    },
    'vedettes': {
        title: 'Go Exploria Espaces Vedettes',
        categories: [
            { icon: 'fas fa-calendar-alt',    name: 'Espaces Événements Vedettes',         desc: 'Festivals & Activités',                       link: '#evenements-vedettes' },
            { icon: 'fas fa-video',           name: 'Espaces Vidéos Vedettes',             desc: 'Contenus vidéo sélectionnés',                 link: '#video-vedette' },
            { icon: 'fas fa-utensils',        name: 'Espaces Restaurants Vedettes',        desc: 'Meilleurs établissements',                    link: '#restaurant-vedette' },
            { icon: 'fas fa-bed',             name: 'Espaces Hébergements Vedettes',       desc: 'Hôtels & Auberges',                           link: '#hebergement-vedette' },
            { icon: 'fas fa-map-marker-alt',  name: 'Espaces Destinations Vedettes',       desc: 'Lieux incontournables',                       link: '#destination-vedette' },
            { icon: 'fas fa-box',             name: 'Espaces Produits Vedettes',           desc: 'Produits en vedette',                         link: '#produit-vedette-evenement' },
            { icon: 'fas fa-building',        name: 'Espaces Entreprises Vedettes',        desc: 'Partenaires certifiés',                       link: '#entreprise-vedette' },
            { icon: 'fas fa-images',          name: 'Espaces Galeries Vedettes',           desc: 'Photos exceptionnelles',                      link: '#gallerie-vedette' },
        ]
    },
    'espaces-voyages-forfaits': {
        title: 'Espaces Voyages & Forfaits Touristique International',
        categories: [
            { icon: 'fas fa-flag',            name: 'Espaces Forfait Québec',              desc: 'Découvrez la Belle Province',                 link: '#forfaits-quebec' },
            { icon: 'fas fa-star',            name: 'Espaces Nouveaux Forfaits',           desc: 'Offres récentes',                             link: '#nouveaux-forfaits' },
            { icon: 'fas fa-globe-europe',    name: 'Espaces Forfaits Europe',             desc: 'Voyages européens',                           link: '#forfaits-europe' },
            { icon: 'fas fa-upload',          name: 'Espaces Affichez Votre Forfaits',     desc: 'Publiez vos offres',                          link: '#affichez-forfaits' },
            { icon: 'fas fa-bell',            name: 'Espaces Alertes Voyages',             desc: 'Notifications & Conseils',                    link: '#alertes-voyages' },
            { icon: 'fas fa-plane',           name: 'Espaces Aéroport du Monde',           desc: 'Alertes voyages, Vol en direct',              link: '#aeroports' },
            { icon: 'fas fa-mountain',        name: 'Espaces Explorez l\'Inattendu / Activités Plein Air', desc: 'Activités plein air',         link: '#explorez-inattendu' },
            { icon: 'fas fa-compass',         name: 'Espaces Idées d\'Aventures',           desc: 'Blocs nom de la destination',                 link: '#idees-aventures' },
            { icon: 'fas fa-sun',             name: 'Espaces Activités Quatre Saisons',    desc: 'Destinations, type d\'activités',             link: '#activites-4-saisons' },
            { icon: 'fas fa-snowflake',       name: 'Espaces Activités Hivernales',        desc: 'Ski, Raquette, Patinage',                     link: '#activites-hiver' },
            { icon: 'fas fa-leaf',            name: 'Espaces Activités Printemps Été',     desc: 'Randonnée, Kayak, Vélo',                      link: '#activites-ete' },
            { icon: 'fas fa-tree',            name: 'Espaces Activités Automnales',        desc: 'Observation feuillage, Cueillette',            link: '#activites-automne' },
        ]
    },
    'marketplace': {
        title: 'Espaces Market Place',
        categories: [
            { icon: 'fas fa-tag',             name: 'Espaces Mes Petites Annonces',        desc: 'Achats & Ventes locales',                     link: '#petites-annonces' },
            { icon: 'fas fa-box-open',        name: 'Espaces Affichez Vos Produits d\'Ici et d\'Ailleurs', desc: 'Terroir & Artisanat',           link: '#produits-marketplace' },
            { icon: 'fas fa-gift',            name: 'Espaces Certificats-Cartes-Produits Cadeaux', desc: 'Cartes & Bons cadeaux',                 link: '#certificats-cartes-cadeaux' },
        ]
    },
    'a-la-une': {
        title: 'Zone Go Exploria Info',
        categories: [
            { icon: 'fas fa-clock',           name: 'Espaces Nouvelles de l\'Heure',       desc: 'Info en temps réel',                          link: '#news-section' },
            { icon: 'fas fa-rss',             name: 'Dernière Nouvelle',                   desc: 'Actualités récentes',                         link: '#nv-nouvelles' },
            { icon: 'fas fa-map',             name: 'Nouvelle par Régions',                desc: 'Info locale & régionale',                     link: '#nv-regions' },
        ]
    }
};
</script>
@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
