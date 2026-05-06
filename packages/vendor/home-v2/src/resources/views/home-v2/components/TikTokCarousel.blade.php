{{-- GoExploria Chaîne Vidéos TIK-TOK --}}
@php(ob_start());@endphp
@php
$tiktokVideos = [
    [
        'id'       => 1,
        'ytid'     => 'xPPLbEFbCAo',
        'thumb'    => 'https://images.unsplash.com/photo-1467810563316-b5476525c0f9?w=400&h=700&fit=crop',
        'user'     => 'goexploria.official',
        'handle'   => '@goexploria.official',
        'date'     => '4-9',
        'views'    => '253.4K',
        'likes'    => '8 160',
        'comments' => '1 554',
        'saves'    => '858',
        'caption'  => 'Gala Saint-Sylvestre 2026 — La soirée de rêve à Montréal 🎉🥂 #GoExploria #Montréal #NewYear',
        'sound'    => 'original sound - GoExploria',
        'overlay'  => 'Gala Saint-Sylvestre',
    ],
    [
        'id'       => 2,
        'ytid'     => 'xPPLbEFbCAo',
        'thumb'    => 'https://images.unsplash.com/photo-1536935338788-846bb9981813?w=400&h=700&fit=crop',
        'user'     => 'goexploria.aventure',
        'handle'   => '@goexploria.aventure',
        'date'     => '3-31',
        'views'    => '5.5M',
        'likes'    => '33 400',
        'comments' => '2 100',
        'saves'    => '4 200',
        'caption'  => 'Baleines à Tadoussac 🐋 Un moment magique au Saguenay #Québec #Nature #Baleines',
        'sound'    => 'original sound - GoExploria Aventure',
        'overlay'  => '',
    ],
    [
        'id'       => 3,
        'ytid'     => 'xPPLbEFbCAo',
        'thumb'    => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=700&fit=crop',
        'user'     => 'goexploria.ski',
        'handle'   => '@goexploria.ski',
        'date'     => '3-28',
        'views'    => '147.1K',
        'likes'    => '12 340',
        'comments' => '987',
        'saves'    => '2 345',
        'caption'  => 'Mont-Tremblant en hiver â›·ï¸ Les pistes comme vous ne les avez jamais vues #Ski #Tremblant',
        'sound'    => 'original sound - GoExploria Ski',
        'overlay'  => 'Transgender Day of Visibility',
    ],
    [
        'id'       => 4,
        'ytid'     => 'xPPLbEFbCAo',
        'thumb'    => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=400&h=700&fit=crop',
        'user'     => 'goexploria.culture',
        'handle'   => '@goexploria.culture',
        'date'     => '3-25',
        'views'    => '19M',
        'likes'    => '54 200',
        'comments' => '3 100',
        'saves'    => '8 900',
        'caption'  => 'Festival de Jazz Montréal 🎷 L\'ambiance électrisante en exclusivité #Jazz #Culture',
        'sound'    => 'original sound - GoExploria Culture',
        'overlay'  => '',
    ],
    [
        'id'       => 5,
        'ytid'     => 'xPPLbEFbCAo',
        'thumb'    => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=400&h=700&fit=crop',
        'user'     => 'goexploria.gastro',
        'handle'   => '@goexploria.gastro',
        'date'     => '3-22',
        'views'    => '11.8M',
        'likes'    => '41 000',
        'comments' => '2 800',
        'saves'    => '6 500',
        'caption'  => 'Les meilleurs restaurants Montréal 2026 🍽️ Notre top 10 secret #Gastronomie #Foodie',
        'sound'    => 'original sound - GoExploria Gastronomie',
        'overlay'  => '',
    ],
    [
        'id'       => 6,
        'ytid'     => 'xPPLbEFbCAo',
        'thumb'    => 'https://images.unsplash.com/photo-1559329007-40df8a9345d8?w=400&h=700&fit=crop',
        'user'     => 'goexploria.destinations',
        'handle'   => '@goexploria.destinations',
        'date'     => '3-19',
        'views'    => '101.7K',
        'likes'    => '9 870',
        'comments' => '765',
        'saves'    => '1 200',
        'caption'  => 'Vieux-Québec en 4K 🏰 Balade dans le quartier historique UNESCO #Québec #Patrimoine',
        'sound'    => 'original sound - GoExploria Destinations',
        'overlay'  => 'Can you hear these TikTok Moments?',
    ],
    [
        'id'       => 7,
        'ytid'     => 'xPPLbEFbCAo',
        'thumb'    => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400&h=700&fit=crop',
        'user'     => 'goexploria.cabane',
        'handle'   => '@goexploria.cabane',
        'date'     => '3-15',
        'views'    => '23.2M',
        'likes'    => '67 000',
        'comments' => '4 500',
        'saves'    => '12 000',
        'caption'  => 'Cabane à sucre authentique 🍁 La vraie expérience québécoise #Érable #Tradition',
        'sound'    => 'original sound - GoExploria Cabane',
        'overlay'  => '',
    ],
    [
        'id'       => 8,
        'ytid'     => 'xPPLbEFbCAo',
        'thumb'    => 'https://images.unsplash.com/photo-1547592180-85f173990554?w=400&h=700&fit=crop',
        'user'     => 'goexploria.road',
        'handle'   => '@goexploria.road',
        'date'     => '3-10',
        'views'    => '33.4M',
        'likes'    => '89 000',
        'comments' => '6 200',
        'saves'    => '18 500',
        'caption'  => '3 POV\'s : Road Trip Charlevoix de Québec à Baie-Saint-Paul 🚗',
        'sound'    => 'original sound - GoExploria Road',
        'overlay'  => "3 POV's:\nCharlevoix\nRoad Trip",
    ],
    [
        'id'       => 9,
        'ytid'     => 'xPPLbEFbCAo',
        'thumb'    => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=700&fit=crop',
        'user'     => 'goexploria.carnaval',
        'handle'   => '@goexploria.carnaval',
        'date'     => '3-5',
        'views'    => '134.2K',
        'likes'    => '22 100',
        'comments' => '1 890',
        'saves'    => '3 400',
        'caption'  => 'brb learning how to make tire d\'érable so I can catch up to @goexploria.gastro 😄 #TheDiscoverList #Québec',
        'sound'    => 'original sound - GoExploria Carnaval',
        'overlay'  => '',
    ],
    [
        'id'       => 10,
        'ytid'     => 'xPPLbEFbCAo',
        'thumb'    => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=400&h=700&fit=crop',
        'user'     => 'goexploria.events',
        'handle'   => '@goexploria.events',
        'date'     => '3-1',
        'views'    => '148.3K',
        'likes'    => '18 400',
        'comments' => '2 300',
        'saves'    => '4 100',
        'caption'  => 'You Asked, We Listened: GoExploria Radio 🎙️ #GoExploria #Radio',
        'sound'    => 'original sound - GoExploria Events',
        'overlay'  => "You Asked,\nWe Listened:\nGoExploria Radio",
    ],
    [
        'id'       => 11,
        'ytid'     => 'xPPLbEFbCAo',
        'thumb'    => 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?w=400&h=700&fit=crop',
        'user'     => 'goexploria.destinations',
        'handle'   => '@goexploria.destinations',
        'date'     => '2-28',
        'views'    => '19M',
        'likes'    => '48 000',
        'comments' => '3 700',
        'saves'    => '9 600',
        'caption'  => 'Les Îles-de-la-Madeleine - Paradis sauvage du Québec 🌊 #ÎlesdelaMadeleine #Québec',
        'sound'    => 'original sound - GoExploria Destinations',
        'overlay'  => '',
    ],
    [
        'id'       => 12,
        'ytid'     => 'xPPLbEFbCAo',
        'thumb'    => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=400&h=700&fit=crop',
        'user'     => 'goexploria.gastro',
        'handle'   => '@goexploria.gastro',
        'date'     => '2-24',
        'views'    => '151.6K',
        'likes'    => '25 300',
        'comments' => '1 980',
        'saves'    => '5 700',
        'caption'  => 'Accord Mets & Vins masterclass avec notre sommelier 🍷 #Gastronomie #Vins #Québec',
        'sound'    => 'original sound - GoExploria Gastro',
        'overlay'  => '',
    ],
];

$ttkCategories = [
    1 => 'evenement',
    2 => 'nature',
    3 => 'aventure',
    4 => 'evenement',
    5 => 'gastronomie',
    6 => 'nature',
    7 => 'gastronomie',
    8 => 'aventure',
    9 => 'culture',
    10 => 'evenement',
    11 => 'nature',
    12 => 'gastronomie',
];
@endphp

<section id="go-tik-tok" class="ttk-section">

    {{-- ============================================================
         ENTÊTE STANDARD — CHAÎNE VIDÉOS TIK-TOK
         ============================================================ --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
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
            <div class="resto-header-center">
                <h1 class="resto-header-title">CHAÎNE VIDÉOS TIK-TOK</h1>
                <p class="resto-header-subtitle">
                    Découvertes · Aventures · Gastronomie · Culture — Explorez le Québec en format court avec GoExploria TIK-TOK.
                </p></div>
            <div class="resto-header-logo-right">
                <a href="#" class="resto-accord-btn" title="Plans Web Go">
                    <div class="logo-wrapper">
                        <img src="{{ asset('plan-n-go.png') }}" alt="Plans Web Go">
                    </div>
                    <span class="resto-accord-btn-label">Plans Web Go</span>
                    <span class="resto-accord-btn-cta">
                        <i class="fas fa-external-link-alt"></i> Visiter
                    </span>
                </a>
            </div>
        </div>
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
            <div class="resto-actions-row">
                <div class="resto-header-ctas">
                    <div class="products-vedette-v2-filters ttk-filters">
                        <button class="products-vedette-v2-filter-btn ttk-filter-btn active" type="button" data-filter="all">
                            <i class="fas fa-th-large"></i> Toutes catégories
                        </button>
                        <button class="products-vedette-v2-filter-btn ttk-filter-btn" type="button" data-filter="nature">
                            <i class="fas fa-leaf"></i> Nature
                        </button>
                        <button class="products-vedette-v2-filter-btn ttk-filter-btn" type="button" data-filter="aventure">
                            <i class="fas fa-mountain"></i> Aventure
                        </button>
                        <button class="products-vedette-v2-filter-btn ttk-filter-btn" type="button" data-filter="gastronomie">
                            <i class="fas fa-utensils"></i> Gastronomie
                        </button>
                        <button class="products-vedette-v2-filter-btn ttk-filter-btn" type="button" data-filter="culture">
                            <i class="fas fa-landmark"></i> Culture
                        </button>
                        <button class="products-vedette-v2-filter-btn ttk-filter-btn" type="button" data-filter="evenement">
                            <i class="fas fa-calendar-alt"></i> Événement
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         GRILLE VIDÉOS (6 colonnes, 2 lignes, style TikTok)
         ============================================================ --}}
    <div class="ttk-grid" id="ttkGrid">
        @foreach($tiktokVideos as $i => $v)
        <div class="ttk-card"
             data-index="{{ $i }}"
             data-ytid="{{ $v['ytid'] }}"
             data-thumb="{{ $v['thumb'] }}"
             data-user="{{ $v['user'] }}"
             data-handle="{{ $v['handle'] }}"
             data-date="{{ $v['date'] }}"
             data-views="{{ $v['views'] }}"
             data-likes="{{ $v['likes'] }}"
             data-comments="{{ $v['comments'] }}"
             data-saves="{{ $v['saves'] }}"
             data-category="{{ $ttkCategories[$v['id']] ?? 'all' }}"
             data-caption="{{ addslashes($v['caption']) }}"
             data-sound="{{ addslashes($v['sound']) }}"
             tabindex="0" role="button">
            <div class="ttk-card-inner">
                <img src="{{ $v['thumb'] }}" alt="{{ $v['user'] }}" class="ttk-card-img" loading="lazy">
                @if(!empty($v['overlay']))
                <div class="ttk-card-text-overlay">{{ $v['overlay'] }}</div>
                @endif
                <div class="ttk-card-bottom">
                    <span class="ttk-card-views"><i class="fas fa-play"></i> {{ $v['views'] }}</span>
                </div>
                <div class="ttk-card-hover-play">
                    <i class="fas fa-play"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</section>

{{-- ============================================================
     MODAL TIK-TOK (lecteur + infos)
     ============================================================ --}}
<div class="ttk-modal" id="ttkModal" role="dialog" aria-modal="true" aria-label="Lecteur TIK-TOK">
    <div class="ttk-modal-inner">

        {{-- Barre supérieure --}}
        <div class="ttk-modal-topbar">
            <button class="ttk-modal-close" id="ttkModalClose" title="Fermer">
                <i class="fas fa-times"></i>
            </button>
            <div class="ttk-modal-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Trouver du contenu associé" readonly>
            </div>
            <div class="ttk-modal-nav">
                <button class="ttk-nav-btn" id="ttkNavPrev" title="Précédent"><i class="fas fa-chevron-up"></i></button>
                <button class="ttk-nav-btn" id="ttkNavNext" title="Suivant"><i class="fas fa-chevron-down"></i></button>
            </div>
        </div>

        {{-- Corps : vidéo gauche + panneau infos droite --}}
        <div class="ttk-modal-body">

            {{-- Vidéo gauche --}}
            <div class="ttk-modal-video">
                <div class="ttk-modal-player" id="ttkModalPlayer">
                    <iframe id="ttkModalIframe" src="" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>

            {{-- Panneau infos droite --}}
            <div class="ttk-modal-panel">

                {{-- Header --}}
                <div class="ttk-panel-header">
                    <div class="ttk-panel-user">
                        <img src="{{ asset('logo.png') }}" alt="" class="ttk-panel-avatar" id="ttkPanelAvatar">
                        <div class="ttk-panel-user-info">
                            <div class="ttk-panel-username" id="ttkPanelUsername">
                                <img src="https://sf16-website-login.neutral.ttwstatic.com/obj/tiktok_web_login_static/tiktok/webapp/main/webapp-desktop/8152caf0c8e8bc67ae0d.png" alt="TikTok" class="ttk-tiktok-icon">
                                <span id="ttkPanelUser">goexploria</span>
                                <i class="fas fa-check-circle ttk-panel-verified"></i>
                            </div>
                            <div class="ttk-panel-date" id="ttkPanelDate">4-9</div>
                        </div>
                    </div>
                    <div class="ttk-panel-header-actions">
                        <button class="ttk-panel-dots"><i class="fas fa-ellipsis-h"></i></button>
                        <button class="ttk-panel-follow">Suivre</button>
                    </div>
                </div>

                {{-- Caption --}}
                <div class="ttk-panel-caption" id="ttkPanelCaption"></div>
                <a href="#" class="ttk-panel-translate">Voir la traduction</a>

                {{-- Son --}}
                <div class="ttk-panel-sound">
                    <i class="fas fa-music"></i>
                    <span id="ttkPanelSound"></span>
                </div>

                {{-- Stats + partage --}}
                <div class="ttk-panel-stats">
                    <div class="ttk-stat ttk-stat-like">
                        <button class="ttk-stat-btn ttk-like-btn" id="ttkLikeBtn">
                            <i class="fas fa-heart"></i>
                        </button>
                        <span id="ttkPanelLikes"></span>
                    </div>
                    <div class="ttk-stat">
                        <button class="ttk-stat-btn">
                            <i class="fas fa-comment-dots"></i>
                        </button>
                        <span id="ttkPanelComments"></span>
                    </div>
                    <div class="ttk-stat">
                        <button class="ttk-stat-btn">
                            <i class="fas fa-bookmark"></i>
                        </button>
                        <span id="ttkPanelSaves"></span>
                    </div>
                    <div class="ttk-share-icons">
                        <button class="ttk-share-btn ttk-share-fb" title="Facebook"><i class="fab fa-facebook-f"></i></button>
                        <button class="ttk-share-btn ttk-share-wa" title="WhatsApp"><i class="fab fa-whatsapp"></i></button>
                        <button class="ttk-share-btn ttk-share-tw" title="Twitter/X"><i class="fab fa-twitter"></i></button>
                        <button class="ttk-share-btn ttk-share-link" title="Copier le lien"><i class="fas fa-link"></i></button>
                        <button class="ttk-share-btn ttk-share-more" title="Plus"><i class="fas fa-ellipsis-h"></i></button>
                    </div>
                </div>

                {{-- Lien --}}
                <div class="ttk-panel-link-row">
                    <span class="ttk-panel-link-url" id="ttkPanelUrl">https://goexploria.com/tiktok/...</span>
                    <button class="ttk-panel-copy" onclick="navigator.clipboard.writeText(document.getElementById('ttkPanelUrl').textContent)">Copier le lien</button>
                </div>

                {{-- Onglets --}}
                <div class="ttk-panel-tabs">
                    <button class="ttk-ptab active" data-tab="comments">
                        Commentaires <span id="ttkTabCommentCount">(0)</span>
                    </button>
                    <button class="ttk-ptab" data-tab="creator">Vidéos du créateur</button>
                </div>

                {{-- Commentaires --}}
                <div class="ttk-panel-comments" id="ttkPanelCommentsList">
                    <div class="ttk-comment">
                        <img src="{{ asset('logo.png') }}" alt="" class="ttk-comment-avatar">
                        <div class="ttk-comment-body">
                            <span class="ttk-comment-user">GoExploria.Fan</span>
                            <span class="ttk-comment-text">Incroyable ! Le Québec est magnifique 🍁</span>
                            <div class="ttk-comment-meta">Il y a 2h · Répondre <span class="ttk-comment-likes"><i class="fas fa-heart"></i> 43</span></div>
                        </div>
                    </div>
                    <div class="ttk-comment">
                        <img src="{{ asset('logo.png') }}" alt="" class="ttk-comment-avatar">
                        <div class="ttk-comment-body">
                            <span class="ttk-comment-user">Voyageur2026</span>
                            <span class="ttk-comment-text">J'y vais cet été, merci GoExploria ! 🙏</span>
                            <div class="ttk-comment-meta">Il y a 8h · Répondre <span class="ttk-comment-likes"><i class="fas fa-heart"></i> 2</span></div>
                        </div>
                    </div>
                </div>

                {{-- CTA Se connecter --}}
                <div class="ttk-panel-cta">
                    <button class="ttk-panel-cta-btn">
                        <i class="fas fa-comment"></i> Se connecter pour commenter
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var videos  = @json($tiktokVideos);
    var section = document.getElementById('goexploria-tiktok');
    var cards   = document.querySelectorAll('#ttkGrid .ttk-card');
    var modal   = document.getElementById('ttkModal');
    var iframe  = document.getElementById('ttkModalIframe');
    var current = 0;
    var activeFilter = 'all';

    function applyGridFilter() {
        cards.forEach(function (card) {
            var category = card.getAttribute('data-category') || 'all';
            var visible = (activeFilter === 'all' || category === activeFilter);
            card.style.display = visible ? '' : 'none';
        });
    }

    function openModal(index) {
        current = index;
        var v = videos[index];
        iframe.src = 'https://www.youtube.com/embed/' + v.ytid + '?autoplay=1&rel=0&enablejsapi=1';
        document.getElementById('ttkPanelUser').textContent    = v.user;
        document.getElementById('ttkPanelDate').textContent    = v.date;
        document.getElementById('ttkPanelCaption').textContent = v.caption;
        document.getElementById('ttkPanelSound').textContent   = v.sound;
        document.getElementById('ttkPanelLikes').textContent   = v.likes;
        document.getElementById('ttkPanelComments').textContent= v.comments;
        document.getElementById('ttkPanelSaves').textContent   = v.saves;
        document.getElementById('ttkTabCommentCount').textContent = '(' + v.comments + ')';
        document.getElementById('ttkPanelUrl').textContent     = 'https://goexploria.com/tiktok/video/' + v.id;
        modal.classList.add('ttk-modal--open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        iframe.src = '';
        modal.classList.remove('ttk-modal--open');
        document.body.style.overflow = '';
    }

    function navigate(dir) {
        current = (current + dir + videos.length) % videos.length;
        iframe.src = '';
        setTimeout(function () { openModal(current); }, 50);
    }

    cards.forEach(function (card) {
        card.addEventListener('click', function () { openModal(parseInt(card.getAttribute('data-index'))); });
        card.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openModal(parseInt(card.getAttribute('data-index'))); } });
    });

    if (section) {
        section.querySelectorAll('.ttk-filter-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                section.querySelectorAll('.ttk-filter-btn').forEach(function (b) { b.classList.remove('active'); });
                btn.classList.add('active');
                activeFilter = btn.getAttribute('data-filter') || 'all';
                applyGridFilter();
            });
        });
    }

    document.getElementById('ttkModalClose').addEventListener('click', closeModal);
    document.getElementById('ttkNavPrev').addEventListener('click', function () { navigate(-1); });
    document.getElementById('ttkNavNext').addEventListener('click', function () { navigate(1); });

    modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });

    document.addEventListener('keydown', function (e) {
        if (!modal.classList.contains('ttk-modal--open')) return;
        if (e.key === 'Escape') closeModal();
        if (e.key === 'ArrowUp')   navigate(-1);
        if (e.key === 'ArrowDown') navigate(1);
    });

    document.getElementById('ttkLikeBtn').addEventListener('click', function () {
        this.classList.toggle('ttk-liked');
    });

    var ptabs = document.querySelectorAll('.ttk-ptab');
    ptabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            ptabs.forEach(function (t) { t.classList.remove('active'); });
            tab.classList.add('active');
        });
    });
    applyGridFilter();
})();
</script>
@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
