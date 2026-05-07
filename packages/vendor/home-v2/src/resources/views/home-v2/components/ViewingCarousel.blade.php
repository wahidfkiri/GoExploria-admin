{{-- GoExploria MyTUBE - Lecteur vidéo style YouTube --}}
@php(ob_start());@endphp
@php
$gxtVideos = [
    [
        'id'        => 'xPPLbEFbCAo',
        'thumb'     => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=480&h=270&fit=crop',
        'duration'  => '14:28',
        'title'     => 'Guide 2026 - Les meilleurs restaurants de Montréal',
        'channel'   => 'GoExploria Gastronomie',
        'cat'       => 'gastronomie',
        'cat_label' => 'Gastronomie',
        'views'     => '24,1K',
        'date'      => 'Il y a 3 jours',
        'desc'      => 'Notre équipe a testé plus de 50 restaurants à Montréal pour vous offrir la sélection ultime 2026. Du bistro intime au grand gastronomique, toutes les adresses incontournables.',
    ],
    [
        'id'        => 'xPPLbEFbCAo',
        'thumb'     => 'https://images.unsplash.com/photo-1559329007-40df8a9345d8?w=480&h=270&fit=crop',
        'duration'  => '18:42',
        'title'     => 'Vieux-Québec en 4K - Promenade dans le quartier historique',
        'channel'   => 'GoExploria Destinations',
        'cat'       => 'destinations',
        'cat_label' => 'Destinations',
        'views'     => '41,7K',
        'date'      => 'Il y a 1 semaine',
        'desc'      => "Explorez les ruelles pavées, les fortifications et l'architecture coloniale du Vieux-Québec, classé au patrimoine mondial de l'UNESCO.",
    ],
    [
        'id'        => 'xPPLbEFbCAo',
        'thumb'     => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=480&h=270&fit=crop',
        'duration'  => '09:15',
        'title'     => 'Ski & Montagne - Mont-Tremblant en plein hiver',
        'channel'   => 'GoExploria Aventure',
        'cat'       => 'aventure',
        'cat_label' => 'Aventure',
        'views'     => '15,3K',
        'date'      => 'Il y a 2 semaines',
        'desc'      => "Pistes enneigées, chalets chaleureux et vie nocturne de Mont-Tremblant : tout ce qu'il faut savoir pour un séjour ski parfait.",
    ],
    [
        'id'        => 'xPPLbEFbCAo',
        'thumb'     => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=480&h=270&fit=crop',
        'duration'  => '22:07',
        'title'     => 'Accord Mets & Vins - Masterclass avec notre sommelier',
        'channel'   => 'GoExploria Gastronomie',
        'cat'       => 'gastronomie',
        'cat_label' => 'Gastronomie',
        'views'     => '32,9K',
        'date'      => 'Il y a 4 jours',
        'desc'      => "Notre sommelier expert vous guide dans l'art des accords mets et vins pour sublimer chaque repas. Découvrez les secrets des meilleurs mariages gastronomiques.",
    ],
    [
        'id'        => 'xPPLbEFbCAo',
        'thumb'     => 'https://images.unsplash.com/photo-1467810563316-b5476525c0f9?w=480&h=270&fit=crop',
        'duration'  => '11:33',
        'title'     => 'Gala Saint-Sylvestre 2026 - Soirée de rêve à Montréal',
        'channel'   => 'GoExploria Événements',
        'cat'       => 'evenements',
        'cat_label' => 'Événements',
        'views'     => '8,4K',
        'date'      => 'Il y a 5 jours',
        'desc'      => "Revivez les meilleurs moments du Gala Saint-Sylvestre 2026 : dîner 5 services, champagne à minuit, orchestre live et feux d'artifice sur le fleuve.",
    ],
    [
        'id'        => 'xPPLbEFbCAo',
        'thumb'     => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=480&h=270&fit=crop',
        'duration'  => '07:52',
        'title'     => 'Festival de Jazz de Montréal - Les moments inoubliables',
        'channel'   => 'GoExploria Culture',
        'cat'       => 'culture',
        'cat_label' => 'Culture',
        'views'     => '19,6K',
        'date'      => 'Il y a 3 semaines',
        'desc'      => "Plongez dans l'atmosphère électrisante du plus grand festival de jazz en Amérique du Nord. Scènes extérieures, concerts intimistes et découvertes musicales.",
    ],
    [
        'id'        => 'xPPLbEFbCAo',
        'thumb'     => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=480&h=270&fit=crop',
        'duration'  => '16:20',
        'title'     => 'La Cabane à Sucre - Expérience authentique québécoise',
        'channel'   => 'GoExploria Gastronomie',
        'cat'       => 'gastronomie',
        'cat_label' => 'Gastronomie',
        'views'     => '27,8K',
        'date'      => 'Il y a 1 mois',
        'desc'      => "Tire d'érable, œufs dans le sirop, jambon fumé et violoneux... Vivez la véritable expérience de la cabane à sucre québécoise dans toute sa splendeur.",
    ],
    [
        'id'        => 'xPPLbEFbCAo',
        'thumb'     => 'https://images.unsplash.com/photo-1547592180-85f173990554?w=480&h=270&fit=crop',
        'duration'  => '20:14',
        'title'     => 'Road Trip Charlevoix - De Québec à Baie-Saint-Paul',
        'channel'   => 'GoExploria Destinations',
        'cat'       => 'destinations',
        'cat_label' => 'Destinations',
        'views'     => '38,2K',
        'date'      => 'Il y a 2 semaines',
        'desc'      => "Suivez notre road trip le long du fleuve Saint-Laurent, de Québec à Baie-Saint-Paul en passant par les plus beaux villages de Charlevoix.",
    ],
    [
        'id'        => 'xPPLbEFbCAo',
        'thumb'     => 'https://images.unsplash.com/photo-1536935338788-846bb9981813?w=480&h=270&fit=crop',
        'duration'  => '13:05',
        'title'     => 'Observation des Baleines à Tadoussac',
        'channel'   => 'GoExploria Aventure',
        'cat'       => 'aventure',
        'cat_label' => 'Aventure',
        'views'     => '45,1K',
        'date'      => 'Il y a 1 mois',
        'desc'      => "Partez à la rencontre des rorquals, bélugas et orques dans les eaux de Tadoussac. Une expérience inoubliable au confluent du Saguenay et du Saint-Laurent.",
    ],
    [
        'id'        => 'xPPLbEFbCAo',
        'thumb'     => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=480&h=270&fit=crop',
        'duration'  => '05:48',
        'title'     => 'Carnaval de Québec 2026 - Traditions hivernales incontournables',
        'channel'   => 'GoExploria Culture',
        'cat'       => 'culture',
        'cat_label' => 'Culture',
        'views'     => '61,4K',
        'date'      => 'Il y a 2 mois',
        'desc'      => "Bonhomme Carnaval, sculptures de glace monumentales, courses en canot sur le fleuve gelé... Le Carnaval de Québec comme vous ne l'avez jamais vu.",
    ],
    [
        'id'        => 'xPPLbEFbCAo',
        'thumb'     => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=480&h=270&fit=crop',
        'duration'  => '25:00',
        'title'     => 'Mariage & Réception VIP - Forfait GoExploria Premium',
        'channel'   => 'GoExploria Événements',
        'cat'       => 'evenements',
        'cat_label' => 'Événements',
        'views'     => '12,7K',
        'date'      => 'Il y a 6 jours',
        'desc'      => "Forfaits mariage haut de gamme : salle de réception, traiteur gastronomique, décoration florale et animation musicale sur mesure.",
    ],
    [
        'id'        => 'xPPLbEFbCAo',
        'thumb'     => 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?w=480&h=270&fit=crop',
        'duration'  => '17:38',
        'title'     => 'Les Îles-de-la-Madeleine - Paradis sauvage du Québec',
        'channel'   => 'GoExploria Destinations',
        'cat'       => 'destinations',
        'cat_label' => 'Destinations',
        'views'     => '53,9K',
        'date'      => 'Il y a 3 semaines',
        'desc'      => "Falaises rouges, plages désertes, fruits de mer frais et vent du large : les Îles-de-la-Madeleine sont le paradis ultime pour les amateurs de nature sauvage.",
    ],
];
@endphp

<section id="my-tube" class="gxt-section">

    {{-- ============================================================
         ENTÊTE GOEXPLORIA MYTUBE — même layout que RestaurantHeader
         ============================================================ --}}
    <div class="resto-header-block">

        <div class="resto-header-main">

            {{-- Logo gauche : GoExploria --}}
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="GoExploria">
                    <div class="logo-wrapper">
                        <img src="{{ asset('logo.png') }}" alt="GoExploria">
                    </div>
                    <span class="resto-accord-btn-label">GoExploria</span>
                    <span class="resto-accord-btn-cta">
                        <i class="fas fa-external-link-alt"></i> Visiter
                    </span>
                </a>
            </div>

            {{-- Centre : titre + sous-titre + 4 boutons espaces --}}
            <div class="resto-header-center">
                <div class="gxt-header-brand gxt-header-brand--hero">
                    <img src="{{ asset('GO-EXPLORIA-MY-TUBE.png') }}" alt="GoExploria MyTUBE" class="gxt-logo">
                </div>
                <h1 class="resto-header-title">GOEXPLORIA MYTUBE</h1>
                <p class="resto-header-subtitle">
                    Films · Documentaires · Plein air · Gastronomie — Explorez le Québec en images avec la chaîne vidéo officielle GoExploria.
                </p></div>

            {{-- Logo droit : GoExploria MyTube --}}
            
            <div class="resto-header-logo-right">
                
                <a href="{{url('page-videos')}}" title="En savoir plus" target="_blank" rel="noopener noreferrer">
                    <!-- <i class="fas fa-circle-info"></i>
                    <span>Go Next Level</span> -->
                    <img
                    class="bt-next-level-image"
                    src="{{ asset('images/Next-level.png') }}"
                    alt="Next Level"
                    loading="lazy"
                >
                </a>
            </div>

        </div>

        {{-- Barre Destinations + Filtres --}}
        <div class="resto-header-destinations-bar">

            <div class="resto-dest-row">
    <div class="resto-dest-icon-box">
        <img src="{{ asset('REDI.png') }}" alt="Destinations">
        <span>Destinations</span>
    </div>

    <div class="resto-dest-breadcrumb vp-dest-breadcrumb">
        <select id="vp-continent-select" class="vp-dest-select" aria-label="Continent">
            <option value="amerique-nord">Amérique du Nord</option>
            <option value="europe">Europe</option>
            <option value="afrique">Afrique</option>
            <option value="asie">Asie</option>
            <option value="amerique-sud">Amérique du Sud</option>
            <option value="oceanie">Océanie</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-country-select" class="vp-dest-select" aria-label="Pays">
            <option value="canada">Canada</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-province-select" class="vp-dest-select" aria-label="Province">
            <option value="quebec">Québec</option>
            <option value="ontario">Ontario</option>
            <option value="alberta">Alberta</option>
            <option value="colombie-britannique">Colombie-Britannique</option>
            <option value="nouvelle-ecosse">Nouvelle-Écosse</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-region-select" class="vp-dest-select" aria-label="Région">
            <option value="region-de-quebec">Région de Québec</option>
            <option value="montreal-metro">Montréal Métro</option>
            <option value="mauricie">Mauricie</option>
            <option value="gaspesie">Gaspésie</option>
            <option value="saguenay">Saguenay</option>
        </select>
    </div>
</div>

        </div>

    </div>

    {{-- --------------- BARRE DE NAVIGATION --------------- --}}
    <header class="gxt-header">
        <div class="gxt-search-wrap">
            <div class="gxt-search-bar">
                <input type="text" id="gxtSearchInput" placeholder="Rechercher une vidéo GoExploria..." class="gxt-search-input" autocomplete="off">
                <button class="gxt-search-btn" aria-label="Rechercher">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="gxt-header-actions">
            <a href="#" class="gxt-social-btn" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="gxt-social-btn" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" class="gxt-social-btn gxt-social-yt" title="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
    </header>

    {{-- --------------- FILTRES CATÉGORIES --------------- --}}
    <div class="gxt-filters-bar">
        <div class="gxt-filters-inner">
            <button class="gxt-filter active" data-filter="all">
                <i class="fas fa-th-large"></i> Tous
            </button>
            <button class="gxt-filter" data-filter="destinations">
                <i class="fas fa-map-marker-alt"></i> Destinations
            </button>
            <button class="gxt-filter" data-filter="gastronomie">
                <i class="fas fa-utensils"></i> Gastronomie
            </button>
            <button class="gxt-filter" data-filter="aventure">
                <i class="fas fa-mountain"></i> Aventure
            </button>
            <button class="gxt-filter" data-filter="evenements">
                <i class="fas fa-star"></i> Événements
            </button>
            <button class="gxt-filter" data-filter="culture">
                <i class="fas fa-theater-masks"></i> Culture
            </button>
        </div>
    </div>

    {{-- --------------- LECTEUR INLINE (affiché au clic) --------------- --}}
    <div class="gxt-player-wrap" id="gxtPlayerWrap">
        <div class="gxt-player-main">
            <div class="gxt-player-embed">
                <iframe id="gxtPlayerIframe" src="" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
            <div class="gxt-player-info">
                <div class="gxt-player-top">
                    <span class="gxt-player-badge" id="gxtPlayerBadge"></span>
                    <button class="gxt-close-player" id="gxtClosePlayer" title="Fermer le lecteur">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <h2 class="gxt-player-title" id="gxtPlayerTitle"></h2>
                <div class="gxt-player-stats">
                    <span><i class="fas fa-eye"></i> <strong id="gxtPlayerViews"></strong> vues</span>
                    <span class="gxt-dot">·</span>
                    <span id="gxtPlayerDate"></span>
                    <span class="gxt-dot">·</span>
                    <span id="gxtPlayerChannel"></span>
                </div>
                <p class="gxt-player-desc" id="gxtPlayerDesc"></p>
                <div class="gxt-player-actions">
                    <a href="#" class="gxt-action-btn"><i class="fas fa-share-alt"></i> Partager</a>
                    <a href="#" class="gxt-action-btn"><i class="fas fa-heart"></i> Ajouter</a>
                </div>
            </div>
        </div>
        <aside class="gxt-player-sidebar">
            <h3 class="gxt-sidebar-title"><i class="fas fa-list-ul"></i> À suivre</h3>
            <div class="gxt-sidebar-list" id="gxtSidebarList"></div>
        </aside>
    </div>

    {{-- --------------- BARRE TITRE SECTION --------------- --}}
    <div class="gxt-content-bar">
        <h2 class="gxt-content-title">
            <i class="fas fa-fire"></i>
            <span id="gxtSectionLabel">Vidéos populaires</span>
        </h2>
        <span class="gxt-video-count"><span id="gxtVideoCount">{{ count($gxtVideos) }}</span> vidéos</span>
    </div>

    {{-- --------------- GRILLE VIDÉOS --------------- --}}
    <div class="gxt-grid" id="gxtGrid">
        @foreach($gxtVideos as $v)
        <div class="gxt-card"
             data-id="{{ $v['id'] }}"
             data-cat="{{ $v['cat'] }}"
             data-title="{{ addslashes($v['title']) }}"
             data-views="{{ $v['views'] }}"
             data-date="{{ $v['date'] }}"
             data-desc="{{ addslashes($v['desc']) }}"
             data-channel="{{ $v['channel'] }}"
             data-badge="{{ $v['cat_label'] }}"
             data-thumb="{{ $v['thumb'] }}"
             role="button" tabindex="0">
            <div class="gxt-thumb">
                <img src="{{ $v['thumb'] }}" alt="{{ $v['title'] }}" class="gxt-thumb-img" loading="lazy">
                <span class="gxt-duration">{{ $v['duration'] }}</span>
                <div class="gxt-play-overlay">
                    <div class="gxt-play-icon"><i class="fas fa-play"></i></div>
                </div>
                <span class="gxt-cat-pill gxt-cat-{{ $v['cat'] }}">{{ $v['cat_label'] }}</span>
            </div>
            <div class="gxt-card-body">
                <div class="gxt-avatar">
                    <img src="{{ asset('GO-EXPLORIA-MY-TUBE.png') }}" alt="{{ $v['channel'] }}" class="gxt-avatar-img">
                </div>
                <div class="gxt-card-meta">
                    <h3 class="gxt-card-title">{{ $v['title'] }}</h3>
                    <p class="gxt-card-channel">{{ $v['channel'] }}</p>
                    <p class="gxt-card-stats"><i class="fas fa-eye"></i> {{ $v['views'] }} vues · {{ $v['date'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Message aucun résultat --}}
    <div class="gxt-no-results" id="gxtNoResults">
        <i class="fas fa-video-slash"></i>
        <p>Aucune vidéo trouvée pour cette catégorie.</p>
    </div>

</section>

<style>
/* Header override local: centre full width, côtés compacts */
#my-tube .resto-header-main {
    grid-template-columns: 110px minmax(0, 1fr) 110px;
    gap: 14px;
}
#my-tube .resto-header-center {
    grid-column: 2;
    width: 100%;
    max-width: 100%;
}
#my-tube .resto-header-logo-left,
#my-tube .resto-header-logo-right {
    visibility: visible;
    pointer-events: auto;
    width: auto;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
#my-tube .resto-header-logo-right {
    grid-column: 3;
    justify-self: auto;
}

@media (max-width: 1024px) {
    #my-tube .resto-header-main {
        grid-template-columns: 90px minmax(0, 1fr) 90px;
    }
}

@media (max-width: 768px) {
    #my-tube .resto-header-logo-left {
        display: flex !important;
    }
    #my-tube .resto-header-logo-right {
        width: auto;
    }
}
</style>

{{-- --------------- JS INTERACTIVITÉ --------------- --}}
<script>
(function () {
    var cards       = Array.from(document.querySelectorAll('.gxt-card'));
    var filters     = document.querySelectorAll('.gxt-filter');
    var searchInput = document.getElementById('gxtSearchInput');
    var playerWrap  = document.getElementById('gxtPlayerWrap');
    var iframe      = document.getElementById('gxtPlayerIframe');
    var noResults   = document.getElementById('gxtNoResults');
    var countEl     = document.getElementById('gxtVideoCount');
    var labelEl     = document.getElementById('gxtSectionLabel');

    var catLabels = { all:'Vidéos populaires', destinations:'Destinations', gastronomie:'Gastronomie', aventure:'Aventure', evenements:'Événements', culture:'Culture' };

    /* -- Filtrage ------------------------------------------- */
    function filterCards(cat, search) {
        var count = 0;
        cards.forEach(function (c) {
            var matchCat    = cat === 'all' || c.getAttribute('data-cat') === cat;
            var matchSearch = !search || c.getAttribute('data-title').toLowerCase().indexOf(search.toLowerCase()) !== -1;
            var show = matchCat && matchSearch;
            c.style.display = show ? '' : 'none';
            if (show) count++;
        });
        countEl.textContent = count;
        labelEl.textContent = search ? 'Résultats de recherche' : (catLabels[cat] || 'Vidéos');
        noResults.style.display = count === 0 ? 'flex' : 'none';
    }

    filters.forEach(function (btn) {
        btn.addEventListener('click', function () {
            filters.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            filterCards(btn.getAttribute('data-filter'), searchInput.value.trim());
        });
    });

    searchInput.addEventListener('input', function () {
        var cat = document.querySelector('.gxt-filter.active').getAttribute('data-filter');
        filterCards(cat, this.value.trim());
    });

    /* -- Lecture -------------------------------------------- */
    function playVideo(card) {
        var id      = card.getAttribute('data-id');
        var title   = card.getAttribute('data-title');
        var views   = card.getAttribute('data-views');
        var date    = card.getAttribute('data-date');
        var desc    = card.getAttribute('data-desc');
        var channel = card.getAttribute('data-channel');
        var badge   = card.getAttribute('data-badge');

        document.getElementById('gxtPlayerTitle').textContent   = title;
        document.getElementById('gxtPlayerBadge').textContent   = badge;
        document.getElementById('gxtPlayerViews').textContent   = views;
        document.getElementById('gxtPlayerDate').textContent    = date;
        document.getElementById('gxtPlayerChannel').textContent = channel;
        document.getElementById('gxtPlayerDesc').textContent    = desc;

        iframe.src = 'https://www.youtube.com/embed/' + id + '?autoplay=1&rel=0&enablejsapi=1';

        playerWrap.classList.add('gxt-player-active');
        cards.forEach(function (c) { c.classList.remove('gxt-card--playing'); });
        card.classList.add('gxt-card--playing');

        populateSidebar(card);
        playerWrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    cards.forEach(function (card) {
        card.addEventListener('click', function () { playVideo(card); });
        card.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); playVideo(card); } });
    });

    /* -- Sidebar -------------------------------------------- */
    function populateSidebar(current) {
        var list = document.getElementById('gxtSidebarList');
        list.innerHTML = '';
        var visible = cards.filter(function (c) {
            return c !== current && c.style.display !== 'none';
        }).slice(0, 9);
        visible.forEach(function (c) {
            var item = document.createElement('div');
            item.className = 'gxt-sidebar-item';
            item.innerHTML =
                '<img src="' + c.getAttribute('data-thumb') + '" class="gxt-sidebar-thumb" alt="">' +
                '<div class="gxt-sidebar-meta">' +
                    '<p class="gxt-sidebar-item-title">' + c.getAttribute('data-title') + '</p>' +
                    '<p class="gxt-sidebar-item-channel">' + c.getAttribute('data-channel') + '</p>' +
                    '<p class="gxt-sidebar-item-stats"><i class="fas fa-eye"></i> ' + c.getAttribute('data-views') + ' · ' + c.getAttribute('data-date') + '</p>' +
                '</div>';
            item.addEventListener('click', function () { playVideo(c); });
            list.appendChild(item);
        });
    }

    /* -- Fermer le lecteur ---------------------------------- */
    document.getElementById('gxtClosePlayer').addEventListener('click', function () {
        iframe.src = '';
        playerWrap.classList.remove('gxt-player-active');
        cards.forEach(function (c) { c.classList.remove('gxt-card--playing'); });
    });
})();
</script>
@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
