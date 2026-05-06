@php(ob_start());@endphp
{{-- MEGA MENU SERVICES V4 --}}

<!-- Overlay -->
<div class="smm-v4-overlay" id="smmV4Overlay"></div>

<!-- Container Mega Menu -->
<div class="smm-v4-container" id="smmV4Container">

    <!-- SIDEBAR GAUCHE : GRANDS TITRES (BLOCS) -->
    <div class="smm-v4-sidebar">
        <div class="smm-v4-sidebar-header">
            <i class="fas fa-th-large"></i>
            <span>NOS ESPACES</span>
        </div>
        <div class="smm-v4-categories" id="smmV4Categories">
            <!-- Généré par JS -->
        </div>
    </div>

    <!-- PANNEAU PRINCIPAL DROIT -->
    <div class="smm-v4-main">
        <div class="smm-v4-main-header">
            <h3 id="smmV4MainTitle"></h3>
            <button class="smm-v4-close" id="smmV4Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="smm-v4-content" id="smmV4Content">
            <!-- Généré par JS -->
        </div>
    </div>
</div>

<script>
// ============================================================
// DONNÉES COMPLÈTES — BLOCS > CATÉGORIES > SOUS-CATÉGORIES
// ============================================================
const menuData = {

    'espaces-medias': {
        title: 'ESPACES MÉDIAS',
        tag: 'go exploria espaces media',
        icon: 'fas fa-photo-video',
        categories: [
            { icon: 'fas fa-briefcase',       name: 'ESPACES TOURISME ET BUSINESS',        desc: 'Business & Tourisme',                         link: '#business-tourism' },
            { icon: 'fas fa-map-marked-alt',  name: 'ACTIVEZ VOTRE ESPACES DESTINATIONS',  desc: 'Québec, Canada, Europe, Monde',               link: '#activez-destinations' },
            { icon: 'fas fa-globe',           name: 'ESPACE GÉO-CARTE-VIDÉOS',             desc: 'Cartographie interactive',                    link: '#geo-carte-videos' },
            { icon: 'fas fa-language',        name: 'ESPACES MULTILINGUES',                desc: 'Contenu international',                       link: '#multilingue' },
            { icon: 'fas fa-images',          name: 'ESPACES SLIDE-SHOW MULTIPLES',        desc: 'Galeries & Diaporamas',                       link: '#slideshow' },
            { icon: 'fab fa-tiktok',          name: 'ESPACES GO-TOK-TOK',                  desc: 'Vidéos courtes verticales',                   link: '#go-tok-tok' },
            { icon: 'fab fa-youtube',         name: 'ESPACES MY-TUBE',                     desc: 'Chaîne vidéos YouTube',                       link: '#my-tube' },
            { icon: 'fas fa-film',            name: 'ESPACES CHAÎNE VIDÉOS',               desc: 'Playlists & Lives',                           link: '#vp-chaine' },
            {
                icon: 'fas fa-camera',
                name: 'ESPACES PHOTOS',
                desc: 'Galeries photo multiples',
                link: '#photos',
                grandchildren: ['Flickr', '500px', 'INSTAGRAM', 'Amalgram', 'Fotify / Kwikpic', 'Joomeo', 'Kululu']
            },
            { icon: 'fas fa-share-alt',       name: 'ESPACES RÉSEAUX SOCIAUX',             desc: 'Gestion de réseaux sociaux — blocs à faire', link: '#reseaux-sociaux' },
            // { icon: 'fab fa-pinterest-p',     name: 'ESPACES INSPIRATION PINTEREST',       desc: 'Tableaux & Collections',                      link: '#pinterest' },
            { icon: 'fas fa-star-half-alt',   name: 'ESPACES AVIS CLIENTS',                desc: 'Témoignages & Évaluations',                   link: '#avis-clients' }
        ]
    },

    'next-level': {
        title: 'ESPACES NEXT LEVEL',
        tag: 'Prêt à passer au niveau supérieur',
        icon: 'fas fa-level-up-alt',
        categories: [
            { icon: 'fas fa-chart-line',      name: 'ESPACES OPTIMISEZ VOTRE PRÉSENCE EN LIGNE',  desc: 'Visibilité & Performance',                link: '#optimisez' },
            { icon: 'fas fa-handshake',       name: 'PARTENAIRES MASTER USER GO EXPLORIA',         desc: 'Choisissez votre niveau de partenariat',  link: '#partenaires-master' },
            { icon: 'fas fa-map-marked-alt',  name: 'ACTIVEZ VOTRE ESPACES DESTINATIONS',          desc: 'Activez votre espace destinations',        link: '#activez-destinations' },
            { icon: 'fas fa-building',        name: 'ACTIVEZ VOTRE ESPACES ENTREPRISES',            desc: 'Activez votre espace entreprises',         link: '#activez-entreprises' },
            { icon: 'fas fa-user-circle',     name: 'ACTIVEZ VOTRE ESPACES PERSO',                 desc: 'Activez votre espace personnel',           link: '#activez-perso' },
            {
                icon: 'fas fa-rocket',
                name: 'ESPACES PLANS NEXT LEVEL',
                desc: 'Liste des plans — un plan par page',
                link: '#plans-next-level',
                grandchildren: ['1 — PLAN DE DÉVELOPPEMENT DES MARCHÉS', '2 — RÉSEAUTAGES RÉGIONAUX', '3 — À FINALISER']
            },
            {
                icon: 'fas fa-users',
                name: 'ESPACES PARTENAIRES AFFILIÉS',
                desc: 'Réseau de partenaires',
                link: '#partenaires-affilies',
                grandchildren: ['1 — MASTER PARTENAIRES DESTINATION : MRC, RÉGIONS TOURISTIQUES', '2 — PARTENAIRES SPONTANÉS : AVIS CLIENTS, PARTAGE PHOTOS/VIDÉOS', '3 — PARTENAIRES MARCHÉS CIBLES', '4 — PARTENAIRES RÉGIONAUX', '5 — PARTENAIRES NATIONAUX']
            },
            { icon: 'fas fa-laptop-code',     name: 'ESPACES ÉDITEUR DE SITE WEB',                desc: 'Création sans code',                       link: '#editeur-site' },
            { icon: 'fas fa-store',           name: 'ÉDITEUR D\'ESPACES ENTREPRISES',              desc: 'Personnalisation avancée',                 link: '#editeur-entreprises' },
            { icon: 'fas fa-user-edit',       name: 'ÉDITEUR D\'ESPACES PERSO',                    desc: 'Espace personnel',                         link: '#editeur-perso' },
            { icon: 'fas fa-globe',           name: 'ESPACES GÉO-CARTE-VIDÉOS',                    desc: 'Cartographie & vidéos',                    link: '#geo-carte-videos' },
            { icon: 'fas fa-rss',             name: 'ESPACES BLOG',                                desc: 'Publication & Articles',                   link: '#blog' },
            { icon: 'fas fa-plug',            name: 'ESPACES API',                                 desc: 'Intégrations & Webhooks',                  link: '#api' },
            { icon: 'fas fa-envelope',         name: 'ESPACES MAIL',                                desc: 'Messagerie & Campagnes',                   link: '#mail' },
            { icon: 'fas fa-comments',         name: 'ESPACES MODULE CHAT',                         desc: 'Ajout comme module',                       link: '#chat' },
            { icon: 'fas fa-paper-plane',     name: 'ESPACES FORMULAIRES',                         desc: 'Contact, Réservation, Inscription',        link: '#formulaires' },
            { icon: 'fas fa-mouse-pointer',   name: 'ESPACES CALL-TO-ACTIONS',                     desc: 'Boutons & Conversions',                    link: '#cta' },
            { icon: 'fas fa-search',          name: 'ESPACES PERFORMANCES SEO INTERNATIONAL',      desc: 'Audit & Optimisation',                     link: '#seo' },
            { icon: 'fas fa-map-pin',         name: 'ESPACES TÉLÉ-POSITIONNEMENT',                 desc: 'Géolocalisation avancée',                  link: '#tele-positionnement' },
            { icon: 'fas fa-external-link-alt', name: 'ESPACES FONCTIONNALITÉS COMPLÈTES',         desc: 'Voir toutes les options',                  link: 'http://www.goexploriabusiness.com/welcome-2', external: true },
            { icon: 'fas fa-trophy',          name: 'PRÊT À PASSER AU NIVEAU SUPÉRIEUR',           desc: 'Démarrez maintenant',                      link: '#niveau-superieur' }
        ]
    },

    'restaurants-alimentations': {
        title: 'ESPACES RESTAURANTS ET ALIMENTATIONS',
        tag: 'Gastronomie & Terroir',
        icon: 'fas fa-utensils',
        categories: [
            { icon: 'fas fa-cocktail',        name: 'ESPACES AMBIANCES RESTAURANTS',                    desc: 'Atmosphère & Décor',              link: '#ambiances-restaurants' },
            { icon: 'fas fa-wine-glass-alt',  name: 'ESPACES MENU ACCORD METS & VINS',                  desc: 'Suggestions harmonieuses',        link: '#mets-vins' },
            { icon: 'fas fa-wine-bottle',     name: 'ESPACE CARTES DES VINS',                           desc: 'Sélection de vins',               link: '#cartes-vins' },
            { icon: 'fas fa-network-wired',   name: 'ESPACES RÉSEAUTAGES RESTO, HÉBERGEMENT, ACTIVITÉS', desc: 'Partenariats & Collaborations',  link: '#reseautage' },
            {
                icon: 'fas fa-bread-slice',
                name: 'ESPACES BOULANGERIES, ÉPICERIE FINE, TERROIR',
                desc: 'Produits du terroir',
                link: '#boulangeries',
                grandchildren: ['Boulangeries', 'Épicerie fine', 'Terroir']
            },
            {
                icon: 'fas fa-store-alt',
                name: 'ESPACES BANNIÈRES ALIMENTATIONS',
                desc: 'Réseaux alimentaires',
                link: '#bannieres',
                grandchildren: ['RÉSEAU IGA', 'MÉTRO', 'SUPER C']
            }
        ]
    },

    'vedettes': {
        title: 'ESPACES VEDETTES',
        tag: 'tous les espaces',
        icon: 'fas fa-star',
        categories: [
            { icon: 'fas fa-video',           name: 'ESPACES VIDÉOS VEDETTES',       desc: 'Contenus vidéo sélectionnés',   link: '#videos-vedettes' },
            { icon: 'fas fa-utensils',        name: 'ESPACES RESTAURANTS VEDETTES',  desc: 'Meilleurs établissements',      link: '#restaurants-vedettes' },
            { icon: 'fas fa-bed',             name: 'ESPACES HÉBERGEMENTS VEDETTES', desc: 'Hôtels & Auberges',             link: '#hebergements-vedettes' },
            { icon: 'fas fa-map-marker-alt',  name: 'ESPACES DESTINATIONS VEDETTES', desc: 'Lieux incontournables',         link: '#destinations-vedettes' },
            { icon: 'fas fa-calendar-alt',    name: 'ESPACES ÉVÉNEMENTS VEDETTES',   desc: 'Festivals & Activités',         link: '#evenements-vedettes' },
            {
                icon: 'fas fa-box',
                name: 'ESPACES PRODUITS VEDETTES',
                desc: 'Produits en vedette',
                link: '#produits-vedettes',
                grandchildren: ['TERROIR', 'PETITES ANNONCES']
            },
            { icon: 'fas fa-building',        name: 'ESPACES ENTREPRISES VEDETTES', desc: 'Partenaires certifiés',          link: '#entreprises-vedettes' },
            { icon: 'fas fa-images',          name: 'ESPACES GALERIES VEDETTES',    desc: 'Photos exceptionnelles',         link: '#galeries-vedettes' },
            { icon: 'fas fa-link',            name: 'ESPACES GRANDES CHAÎNES',      desc: 'Réseaux internationaux',         link: '#grandes-chaines' }
        ]
    },

    'voyages-forfaits': {
        title: 'ESPACES VOYAGES & FORFAITS TOURISTIQUE INTERNATIONAL',
        tag: 'Plus de slides show photos et vidéo dans toutes les sections',
        icon: 'fas fa-plane-departure',
        categories: [
            { icon: 'fas fa-flag',            name: 'ESPACES FORFAIT QUÉBEC',                              desc: 'Découvrez la Belle Province',   link: '#forfaits-quebec' },
            { icon: 'fas fa-star',            name: 'ESPACES NOUVEAUX FORFAITS',                           desc: 'Offres récentes',               link: '#nouveaux-forfaits' },
            { icon: 'fas fa-globe-europe',    name: 'ESPACES FORFAITS EUROPE',                             desc: 'Voyages européens',             link: '#forfaits-europe' },
            { icon: 'fas fa-upload',          name: 'ESPACES AFFICHEZ VOTRE FORFAITS',                     desc: 'Publiez vos offres',            link: '#affichez-forfaits' },
            { icon: 'fas fa-pencil-alt',      name: 'ESPACES CRÉEZ VOS FORFAITS',                          desc: 'Outil de création',             link: '#creez-forfaits' },
            { icon: 'fas fa-bell',            name: 'ESPACES ALERTES VOYAGES',                             desc: 'Notifications & Conseils',      link: '#alertes-voyages' },
            {
                icon: 'fas fa-plane',
                name: 'ESPACES AÉROPORT DU MONDE',
                desc: 'Alertes voyages, Vol en direct',
                link: '#aeroports',
                grandchildren: ['ALERTES VOYAGES', 'VOL EN DIRECT']
            },
            { icon: 'fas fa-mountain',        name: 'ESPACES EXPLOREZ L\'INATTENDU / ACTIVITÉS PLEIN AIR', desc: 'Activités plein air',          link: '#explorez-inattendu' },
            {
                icon: 'fas fa-compass',
                name: 'ESPACES IDÉES D\'AVENTURES',
                desc: 'Blocs nom de la destination',
                link: '#idees-aventures',
                grandchildren: ['RÉVEIL VOLCANS']
            },
            { icon: 'fas fa-sun',             name: 'ESPACES ACTIVITÉS QUATRE SAISONS',  desc: 'Destinations, type d\'activités',  link: '#activites-4-saisons' },
            { icon: 'fas fa-snowflake',       name: 'ESPACES ACTIVITÉS HIVERNALES',      desc: 'Ski, Raquette, Patinage',          link: '#activites-hiver' },
            { icon: 'fas fa-leaf',            name: 'ESPACES ACTIVITÉS PRINTEMPS ÉTÉ',   desc: 'Randonnée, Kayak, Vélo',           link: '#activites-ete' },
            { icon: 'fas fa-tree',            name: 'ESPACES ACTIVITÉS AUTOMNALES',      desc: 'Observation feuillage, Cueillette', link: '#activites-automne' }
        ]
    },

    'marketplace': {
        title: 'ESPACES MARKET PLACE',
        tag: 'Achats & Ventes',
        icon: 'fas fa-shopping-cart',
        categories: [
            { icon: 'fas fa-tag',             name: 'ESPACES MES PETITES ANNONCES',                       desc: 'Achats & Ventes locales',       link: '#petites-annonces' },
            { icon: 'fas fa-box-open',        name: 'ESPACES AFFICHEZ VOS PRODUITS D\'ICI ET D\'AILLEURS', desc: 'Terroir & Artisanat',           link: '#produits-marketplace' },
            { icon: 'fas fa-gift',            name: 'ESPACES CERTIFICATS-CARTES-PRODUITS CADEAUX',         desc: 'Cartes & Bons cadeaux',         link: '#certificats' },
            { icon: 'fas fa-cubes',           name: 'ESPACES PACKAGES CADEAUX',                            desc: 'Coffrets & Forfaits',           link: '#packages-cadeaux' }
        ]
    },

    'espaces-specialises': {
        title: 'ESPACES SPÉCIALISÉS',
        tag: 'Immobilier, hébergement, alimentation & mobilité touristique',
        icon: 'fas fa-layer-group',
        categories: [
            { icon: 'fas fa-home',             name: 'IMMO QUÉBEC',                                  desc: 'Plateforme immobilière québécoise',        link: '#immo-quebec' },
            { icon: 'fas fa-key',              name: 'CHALETS À LOUER',                              desc: 'Locations saisonnières & escapades',       link: '#chalets-a-louer' },
            { icon: 'fas fa-shopping-basket',  name: 'MARCHÉS D\'ALIMENTATIONS',                     desc: 'Épiceries, marchés publics & terroir',     link: '#marches-alimentations' },
            { icon: 'fas fa-car-side',         name: 'LOCATION AUTO, VUS, VÉHICULES RÉCRÉATIFS 4 SAISONS', desc: 'Autos, VUS, VR, motoneiges, bateaux', link: '#location-vehicules' },
            { icon: 'fas fa-mountain',         name: 'ESPACES CHALETS À VENDRE',                     desc: 'Chalets & Propriétés en nature',           link: '#chalets-vendre' },
            { icon: 'fas fa-house-user',       name: 'ESPACES MAISONS CHALETS À VENDRE',             desc: 'Maisons & Chalets résidentiels',           link: '#maisons-chalets' },
            { icon: 'fas fa-building',         name: 'ESPACES PROJET IMMOBILIER TOURISTIQUE',        desc: 'Développement & Investissement',           link: '#projet-immo' }
        ]
    },

    'a-la-une': {
        title: 'ESPACES À LA UNE',
        tag: 'Actualités & Nouvelles',
        icon: 'fas fa-newspaper',
        categories: [
            { icon: 'fas fa-clock',           name: 'ESPACES NOUVELLES DE L\'HEURE',  desc: 'Info en temps réel',           link: '#nouvelles-heure' },
            { icon: 'fas fa-rss',             name: 'DERNIÈRE NOUVELLE',              desc: 'Actualités récentes',          link: '#dernieres-nouvelles' },
            { icon: 'fas fa-map',             name: 'NOUVELLE PAR RÉGIONS',           desc: 'Info locale & régionale',      link: '#nouvelles-regions' }
        ]
    }
};

// Ordre des blocs dans la sidebar
const mainTitlesOrder = [
    'espaces-medias',
    'next-level',
    'restaurants-alimentations',
    'vedettes',
    'voyages-forfaits',
    'marketplace',
    'espaces-specialises',
    'a-la-une'
];

// Les liens directs définis dans menuData (category.link) sont conservés tels quels.

// ============================================================
// GÉNÉRATION SIDEBAR
// ============================================================
function generateSidebar() {
    const container = document.getElementById('smmV4Categories');
    container.innerHTML = '';
    mainTitlesOrder.forEach(function(catKey) {
        const cat = menuData[catKey];
        if (!cat) return;
        const div = document.createElement('div');
        div.className = 'smm-v4-cat';
        div.setAttribute('data-cat', catKey);
        div.innerHTML = '<i class="' + cat.icon + '"></i><span>' + cat.title + '</span><i class="fas fa-chevron-right"></i>';
        container.appendChild(div);
    });
    const first = container.querySelector('.smm-v4-cat');
    if (first) first.classList.add('active');
}

// ============================================================
// GÉNÉRATION GRILLE DE CARTES (3 par ligne)
// ============================================================
function generateMainContent(catKey) {
    const cat = menuData[catKey];
    if (!cat) return;

    document.getElementById('smmV4MainTitle').innerHTML =
        cat.title;

    const contentEl = document.getElementById('smmV4Content');
    contentEl.innerHTML = '';

    const grid = document.createElement('div');
    grid.className = 'smm-v4-cards-grid';

    cat.categories.forEach(function(category) {
        const card = document.createElement('div');
        card.className = 'smm-v4-card';

        const iconClass  = category.icon || cat.icon || 'fas fa-layer-group';
        const linkTarget = category.external ? '_blank' : '_self';

        card.innerHTML =
            '<a href="' + (category.link || '#') + '" target="' + linkTarget + '" class="smm-v4-card-link">' +
                '<div class="smm-v4-card-icon"><i class="' + iconClass + '"></i></div>' +
                '<div class="smm-v4-card-body">' +
                    '<div class="smm-v4-card-name">' + category.name + '</div>' +
                    (category.desc ? '<div class="smm-v4-card-desc">' + category.desc + '</div>' : '') +
                '</div>' +
            '</a>';

        grid.appendChild(card);
    });

    contentEl.appendChild(grid);
}

// ============================================================
// INTERACTIONS
// ============================================================
const smmOverlay   = document.getElementById('smmV4Overlay');
const smmContainer = document.getElementById('smmV4Container');
const smmClose     = document.getElementById('smmV4Close');
const smmTrigger   = document.getElementById('servicesMenuItem');

function openMenu() {
    smmOverlay.classList.add('active');
    smmContainer.classList.add('active');
    const activeCat = document.querySelector('.smm-v4-cat.active');
    generateMainContent(activeCat ? activeCat.getAttribute('data-cat') : 'espaces-medias');
}

function closeMenu() {
    smmOverlay.classList.remove('active');
    smmContainer.classList.remove('active');
}

// Timeout partagé — évite le clignotement lors du passage trigger → container
let smmCloseTimer = null;

function scheduleClose() {
    clearTimeout(smmCloseTimer);
    smmCloseTimer = setTimeout(closeMenu, 400);
}

function cancelClose() {
    clearTimeout(smmCloseTimer);
}

// Hover + clic sur "NOS SERVICES"
if (smmTrigger) {
    smmTrigger.addEventListener('mouseenter', function() { cancelClose(); openMenu(); });
    smmTrigger.addEventListener('mouseleave', scheduleClose);
    smmTrigger.addEventListener('click', function(e) { e.preventDefault(); cancelClose(); openMenu(); });
}

// Hover sur le container — annule la fermeture
smmContainer.addEventListener('mouseenter', cancelClose);
smmContainer.addEventListener('mouseleave', scheduleClose);

// Hover sur l'overlay — annule aussi la fermeture (espace entre trigger et panel)
smmOverlay.addEventListener('mouseenter', cancelClose);

if (smmClose)   smmClose.addEventListener('click', closeMenu);
if (smmOverlay) smmOverlay.addEventListener('click', closeMenu);

// Fermer le mega menu dès clic sur un lien de carte
smmContainer.addEventListener('click', function(e) {
    const cardLink = e.target.closest('.smm-v4-card-link');
    if (!cardLink) return;
    closeMenu();
});

// Hover sur un bloc dans la sidebar (plus réactif que le clic)
document.addEventListener('mouseover', function(e) {
    const catItem = e.target.closest('.smm-v4-cat');
    if (catItem && smmContainer.classList.contains('active')) {
        const catKey = catItem.getAttribute('data-cat');
        if (catKey) {
            document.querySelectorAll('.smm-v4-cat').forEach(function(c) { c.classList.remove('active'); });
            catItem.classList.add('active');
            generateMainContent(catKey);
        }
    }
});

// Clic sur un bloc dans la sidebar
document.addEventListener('click', function(e) {
    const catItem = e.target.closest('.smm-v4-cat');
    if (catItem && smmContainer.classList.contains('active')) {
        const catKey = catItem.getAttribute('data-cat');
        if (catKey) {
            document.querySelectorAll('.smm-v4-cat').forEach(function(c) { c.classList.remove('active'); });
            catItem.classList.add('active');
            generateMainContent(catKey);
        }
    }
});

document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeMenu(); });

// Init
generateSidebar();
generateMainContent('espaces-medias');
</script>
@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
