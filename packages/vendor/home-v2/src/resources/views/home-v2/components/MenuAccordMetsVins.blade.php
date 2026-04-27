{{-- ============================================================
     ACCORD METS & VINS — Bloc Premium GoExploria
     Hero · Carousel images+vidéo · Cartes vins · Lightbox · Modal · Réservation
     ============================================================ --}}

@php(ob_start());@endphp
@php
/* ---- Slides du carousel (images locales + 1 vidéo YouTube) ---- */
$amvSlides = [
    [
        'type'    => 'image',
        'src'     => asset('home2/aventure-accords-met-vin/accord_mets_vin.jpg'),
        'fullsrc' => asset('home2/aventure-accords-met-vin/accord_mets_vin.jpg'),
        'title'   => 'Accord Parfait',
        'caption' => 'Mets & Vins — l\'art de l\'harmonie gastronomique',
    ],
    [
        'type'    => 'image',
        'src'     => asset('home2/aventure-accords-met-vin/magret-canard.jpg'),
        'fullsrc' => asset('home2/aventure-accords-met-vin/magret-canard.jpg'),
        'title'   => 'Gastronomie de Prestige',
        'caption' => 'Magret de canard & Cahors — un accord emblématique',
    ],
    [
        'type'    => 'video',
        'ytid'    => 'xPPLbEFbCAo',
        'thumb'   => asset('home2/aventure-accords-met-vin/accord-m-v.jpg'),
        'title'   => 'Découvrez Notre Univers',
        'caption' => 'Inspiration gastronomique — cliquez pour visionner',
    ],
    [
        'type'    => 'image',
        'src'     => asset('home2/aventure-accords-met-vin/cave.jpg'),
        'fullsrc' => asset('home2/aventure-accords-met-vin/cave.jpg'),
        'title'   => 'Cave d\'Exception',
        'caption' => 'Plus de 200 références soigneusement sélectionnées',
    ],
    [
        'type'    => 'image',
        'src'     => asset('home2/aventure-accords-met-vin/restaurant-fruits-de-mer-accord-vin.jpg'),
        'fullsrc' => asset('home2/aventure-accords-met-vin/restaurant-fruits-de-mer-accord-vin.jpg'),
        'title'   => 'Fruits de Mer & Vins Blancs',
        'caption' => 'Plateau de fruits de mer & Chablis Premier Cru',
    ],
    [
        'type'    => 'image',
        'src'     => asset('home2/aventure-accords-met-vin/cave-de-degustation-des-vins.png'),
        'fullsrc' => asset('home2/aventure-accords-met-vin/cave-de-degustation-des-vins.png'),
        'title'   => 'Dégustations Privées',
        'caption' => 'Événements exclusifs dans notre cave de dégustation',
    ],
    [
        'type'    => 'image',
        'src'     => asset('home2/aventure-accords-met-vin/Conseils-pour-debuter-cave-a-vin.jpg'),
        'fullsrc' => asset('home2/aventure-accords-met-vin/Conseils-pour-debuter-cave-a-vin.jpg'),
        'title'   => 'Initiez-vous aux Vins',
        'caption' => 'Notre sommelier vous guide dans l\'art des accords',
    ],
];

/* ---- Menu du Restaurant — 5 catégories × 3 plats ---- */
$amvMenuCategories = [
    [
        'id'    => 'entrees',
        'label' => 'Entrées',
        'icon'  => 'fas fa-leaf',
        'items' => [
            [
                'name'  => 'Burrata & Tapenade',
                'desc'  => 'Gelée de tomates, tapenade d\'olives et crumble. Huile verte, oignons marinés, pousses de basilic et pain foccacia.',
                'price' => '28 $',
                'img'   => 'https://images.unsplash.com/photo-1625944525533-473f1a3d54e7?w=560&h=315&fit=crop',
            ],
            [
                'name'  => 'Carpaccio de Filet Mignon',
                'desc'  => 'Aïoli maison, citron confit, copeaux de vieux parmesan, câpres, noix de pin, huile de roquette et pousses de basilic.',
                'price' => '25 $',
                'img'   => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=560&h=315&fit=crop',
            ],
            [
                'name'  => 'Feuilleté Crevettes & Pétoncles',
                'desc'  => 'Beurre nantais et tombée d\'épinards.',
                'price' => '24 $',
                'img'   => 'https://images.unsplash.com/photo-1559742811-822873691df8?w=560&h=315&fit=crop',
            ],
        ],
    ],
    [
        'id'    => 'salades',
        'label' => 'Salades',
        'icon'  => 'fas fa-seedling',
        'items' => [
            [
                'name'  => 'Salade César',
                'desc'  => 'Jambon de parme et parmigiano reggiano. Extra poulet grillé (+7 $)',
                'price' => '19 $',
                'img'   => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=560&h=315&fit=crop',
            ],
            [
                'name'  => 'Tomate Caprèse',
                'desc'  => 'Mozzarella di Bufala, tomate confite au pesto, caramel de balsamique et roquette.',
                'price' => '17 $',
                'img'   => 'https://images.unsplash.com/photo-1592417817098-8fd3d9eb14a5?w=560&h=315&fit=crop',
            ],
            [
                'name'  => 'Soupe à l\'Oignon Gratinée',
                'desc'  => 'Gratinée au migneron de Charlevoix.',
                'price' => '15 $',
                'img'   => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=560&h=315&fit=crop',
            ],
        ],
    ],
    [
        'id'    => 'pates',
        'label' => 'Les Pâtes',
        'icon'  => 'fas fa-utensils',
        'items' => [
            [
                'name'  => 'Risotto Graffiti',
                'desc'  => 'Flanc de porc croustillant, tomates fraîches, champignons, fines herbes, crumble de panko, poireaux au beurre, parmesan.',
                'price' => '35 $',
                'img'   => 'https://images.unsplash.com/photo-1476124369491-e7addf5db371?w=560&h=315&fit=crop',
            ],
            [
                'name'  => 'Linguine aux Fruits de Mer',
                'desc'  => 'Pétoncles, crevettes, moules et palourdes. Sauce crème et vin blanc.',
                'price' => '37 $',
                'img'   => 'https://images.unsplash.com/photo-1563379926898-05f4575a45d8?w=560&h=315&fit=crop',
            ],
            [
                'name'  => 'Raviolis aux Champignons Sauvages',
                'desc'  => 'Noix de pin, tomates, épinard frit, crème, vin blanc et parmesan reggiano.',
                'price' => '29 $',
                'img'   => 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=560&h=315&fit=crop',
            ],
        ],
    ],
    [
        'id'    => 'tartares',
        'label' => 'Les Tartares',
        'icon'  => 'fas fa-drumstick-bite',
        'items' => [
            [
                'name'  => 'Tartare de Bœuf Classique',
                'desc'  => 'Pommes de terre frites et salade.',
                'price' => 'Entrée 25 $ · Plat 33 $',
                'img'   => 'https://images.unsplash.com/photo-1602030638412-bb8dcc0bc8b0?w=560&h=315&fit=crop',
            ],
            [
                'name'  => 'Tartare de Saumon',
                'desc'  => 'Chutney d\'ananas et mangue, pommes de terre frites et salade.',
                'price' => 'Entrée 25 $ · Plat 33 $',
                'img'   => 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?w=560&h=315&fit=crop',
            ],
            [
                'name'  => 'Tartare de Thon',
                'desc'  => 'Salsa de mangues, tortillas de maïs. Servi avec salade du marché.',
                'price' => '26 $',
                'img'   => 'https://images.unsplash.com/photo-1534482421-64566f976cfa?w=560&h=315&fit=crop',
            ],
        ],
    ],
    [
        'id'    => 'classiques',
        'label' => 'Les Classiques',
        'icon'  => 'fas fa-crown',
        'items' => [
            [
                'name'  => 'Filet Mignon Sauce Porto',
                'desc'  => 'Fromage migneron, risotto aux champignons sauvages, huile de truffes et légumes du moment.',
                'price' => '56 $',
                'img'   => 'https://images.unsplash.com/photo-1558030137-a56c1b002c72?w=560&h=315&fit=crop',
            ],
            [
                'name'  => 'Joue de Bœuf Braisée',
                'desc'  => 'Sauce aux fines herbes et pommes caramélisées, tombée d\'épinards, poireaux frits et purée de pommes de terre.',
                'price' => '44 $',
                'img'   => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=560&h=315&fit=crop',
            ],
            [
                'name'  => 'Ris de Veau Poêlés',
                'desc'  => 'Champignons marinés au balsamique, gratin dauphinois et légumes du moment.',
                'price' => '50 $',
                'img'   => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=560&h=315&fit=crop',
            ],
        ],
    ],
];

/* ---- Sélection de vins ---- */
$amvWines = [
    ['name'=>'Chablis Premier Cru','grape'=>'Chardonnay','region'=>'Bourgogne, France',
     'type'=>'blanc','price'=>'38 $','unit'=>'/ bouteille','stars'=>'★★★★★',
     'desc'=>'Notes de citron vert, pomme verte et minéralité. Finesse et élégance incomparables.',
     'accord'=>'Burrata · Fruits de mer · Saumon',
     'img'=>'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=420&h=280&fit=crop'],
    ['name'=>'Chianti Classico Riserva','grape'=>'Sangiovese','region'=>'Toscane, Italie',
     'type'=>'rouge','price'=>'42 $','unit'=>'/ bouteille','stars'=>'★★★★★',
     'desc'=>'Cerise et violette au nez, bouche structurée avec des tanins soyeux et une longue finale.',
     'accord'=>'Pâtes · Lasagne · Veau parmigiana',
     'img'=>'https://images.unsplash.com/photo-1474722883778-792e7990302f?w=420&h=280&fit=crop'],
    ['name'=>'Barolo DOCG','grape'=>'Nebbiolo','region'=>'Piémont, Italie',
     'type'=>'rouge','price'=>'58 $','unit'=>'/ bouteille','stars'=>'★★★★★',
     'desc'=>"Le roi des vins italiens. Tannique et complexe, arômes de roses séchées et de goudron.",
     'accord'=>'Risotto Graffiti · Filet mignon · Truffes',
     'img'=>'https://images.unsplash.com/photo-1553361371-9b22f78e8b1d?w=420&h=280&fit=crop'],
    ['name'=>'Saint-Émilion Grand Cru','grape'=>'Merlot · Cabernet Franc','region'=>'Bordeaux, France',
     'type'=>'rouge','price'=>'65 $','unit'=>'/ bouteille','stars'=>'★★★★★',
     'desc'=>'Opulent et généreux. Fruits noirs, chocolat et épices douces en finale persistante.',
     'accord'=>'Filet mignon sauce porto · Gibier',
     'img'=>'https://images.unsplash.com/photo-1560679659-c9c8b18f6edd?w=420&h=280&fit=crop'],
    ['name'=>'Sancerre Blanc','grape'=>'Sauvignon Blanc','region'=>'Loire, France',
     'type'=>'blanc','price'=>'44 $','unit'=>'/ bouteille','stars'=>'★★★★☆',
     'desc'=>'Vif et minéral, notes de buis, agrumes et silex. Fraîcheur et précision élégante.',
     'accord'=>'Tartare de saumon · Thon · Chèvre',
     'img'=>'https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=420&h=280&fit=crop'],
    ['name'=>'Pomerol','grape'=>'Merlot','region'=>'Bordeaux, France',
     'type'=>'rouge','price'=>'72 $','unit'=>'/ bouteille','stars'=>'★★★★★',
     'desc'=>'Velours et profondeur. Truffe noire, prune confite et notes torréfiées d\'une rare complexité.',
     'accord'=>'Joue de bœuf braisée · Canard confit',
     'img'=>'https://images.unsplash.com/photo-1548170462-fae2e43b0e30?w=420&h=280&fit=crop'],
    ['name'=>'Meursault','grape'=>'Chardonnay','region'=>'Bourgogne, France',
     'type'=>'blanc','price'=>'55 $','unit'=>'/ bouteille','stars'=>'★★★★★',
     'desc'=>'Beurré et noisette, richesse onctueuse et acidité parfaitement équilibrée.',
     'accord'=>'Ris de veau · Pétoncles · Crème',
     'img'=>'https://images.unsplash.com/photo-1566936737687-8f392a237b8b?w=420&h=280&fit=crop'],
    ['name'=>'Pinot Noir Côte de Nuits','grape'=>'Pinot Noir','region'=>'Bourgogne, France',
     'type'=>'rouge','price'=>'48 $','unit'=>'/ bouteille','stars'=>'★★★★☆',
     'desc'=>'Cerise, framboise et sous-bois. Vin délicat aux tanins fins, d\'une élégance racée.',
     'accord'=>'Canard confit · Champignons · Raviolis',
     'img'=>'https://images.unsplash.com/photo-1506377247377-2a5b3b417ebb?w=420&h=280&fit=crop'],
];
@endphp

{{-- ================================================================
     SECTION PRINCIPALE
     ================================================================ --}}
<section class="amv-section" id="menu-accord-section">

    {{-- ============================================================
         HERO BAND
         ============================================================ --}}
    <div class="amv-hero">
        <img class="amv-hero-bg-img"
             src="{{ asset('home2/aventure-accords-met-vin/cave-de-degustation-des-vins.png') }}"
             alt="">
        <div class="amv-hero-overlay"></div>
        <div class="amv-hero-content">
            <div class="amv-hero-eyebrow">
                <i class="fas fa-wine-glass-alt"></i>
                Expérience Sensorielle
            </div>
            <h2 class="amv-hero-title">
                Accord Parfait
                <span>Mets &amp; Vins</span>
            </h2>
            <p class="amv-hero-subtitle">
                Une symphonie de saveurs où chaque plat raconte une histoire, sublimée par une sélection
                viticole d'exception. Parcourez notre galerie, découvrez nos vins et réservez votre expérience.
            </p>
        </div>
    </div>
    <div class="amv-hero-shimmer"></div>

    {{-- ============================================================
         À PROPOS — Description gauche + Image illustration droite
         ============================================================ --}}
    <section class="amv-apropos-section" id="amv-apropos">
        <div class="amv-apropos-inner">

            {{-- Côté texte (gauche) --}}
            <div class="amv-apropos-text">
                <span class="amv-apropos-eyebrow">Notre Histoire</span>
                <h3 class="amv-apropos-title">
                    L'Art des Accords<br>
                    Mets <span class="amv-gold">&amp; Vins</span>
                </h3>
                <p class="amv-apropos-lead">
                    Depuis 2008, Resto Graffiti célèbre la gastronomie italienne dans toute sa splendeur.
                    Né d'une passion pour les grandes tables et les vins d'exception, notre restaurant est
                    devenu une référence incontournable à Montréal pour les amateurs de cuisine raffinée
                    et de vins soigneusement sélectionnés.
                </p>

                <div class="amv-apropos-feats">
                    <div class="amv-apropos-feat">
                        <i class="fas fa-award"></i>
                        <div>
                            <strong>Sommelier Certifié</strong>
                            <span>Chaque accord est pensé par notre expert pour sublimer votre expérience gustative</span>
                        </div>
                    </div>
                    <div class="amv-apropos-feat">
                        <i class="fas fa-wine-bottle"></i>
                        <div>
                            <strong>200+ Références</strong>
                            <span>Une cave rigoureusement sélectionnée — France, Italie, Espagne et Nouveau Monde</span>
                        </div>
                    </div>
                    <div class="amv-apropos-feat">
                        <i class="fas fa-users"></i>
                        <div>
                            <strong>Événements Privés</strong>
                            <span>Dégustations, soupers thématiques et réceptions dans notre cave privée</span>
                        </div>
                    </div>
                </div>

                <div class="amv-apropos-actions">
                    <button class="amv-apropos-btn primary"
                            onclick="openGoExpResaModal('table')">
                        <i class="fas fa-calendar-check"></i>
                        Réserver une table
                    </button>
                    <a href="#amv-menu-restaurant" class="amv-apropos-btn secondary">
                        <i class="fas fa-utensils"></i>
                        Voir le menu
                    </a>
                </div>
            </div>

            {{-- Côté image (droite) --}}
            <div class="amv-apropos-img-wrap">
                <div class="amv-apropos-img-frame">
                    <img src="{{ asset('home2/aventure-accords-met-vin/cave-de-degustation-des-vins.png') }}"
                         alt="Cave de dégustation — Resto Graffiti"
                         loading="lazy">
                    <div class="amv-apropos-img-badge">
                        <i class="fas fa-star"></i>
                        <span>Depuis 2008</span>
                    </div>
                </div>
                <div class="amv-apropos-stat-card">
                    <div class="amv-stat">
                        <span class="amv-stat-num">200+</span>
                        <span class="amv-stat-lbl">Vins</span>
                    </div>
                    <div class="amv-stat-sep"></div>
                    <div class="amv-stat">
                        <span class="amv-stat-num">15+</span>
                        <span class="amv-stat-lbl">Ans</span>
                    </div>
                    <div class="amv-stat-sep"></div>
                    <div class="amv-stat">
                        <span class="amv-stat-num">98%</span>
                        <span class="amv-stat-lbl">Satisfaction</span>
                    </div>
                    <div class="amv-stat-sep"></div>
                    <div class="amv-stat">
                        <span class="amv-stat-num">5★</span>
                        <span class="amv-stat-lbl">Note</span>
                    </div>
                </div>
            </div>

        </div>
    </section>{{-- /.amv-apropos-section --}}

    {{-- ============================================================
         CAROUSEL MÉDIA — images + vidéo YouTube
         ============================================================ --}}
    <div class="amv-carousel-section">

        <div class="amv-carousel-wrapper" id="amvCarouselWrapper">

            @foreach($amvSlides as $idx => $slide)

                @if($slide['type'] === 'image')
                    <div class="amv-carousel-slide is-image {{ $idx === 0 ? 'active' : '' }}"
                         data-fullsrc="{{ $slide['fullsrc'] }}">
                        <img src="{{ $slide['src'] }}" alt="{{ $slide['title'] }}" loading="{{ $idx === 0 ? 'eager' : 'lazy' }}">
                        <div class="amv-slide-overlay">
                            <div class="amv-zoom-btn" aria-label="Agrandir">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                        <div class="amv-slide-caption">
                            <div class="amv-slide-caption-inner">
                                <span class="amv-slide-caption-badge">
                                    <i class="fas fa-image"></i> Photo
                                </span>
                                <h4 class="amv-slide-title">{{ $slide['title'] }}</h4>
                                <p class="amv-slide-sub">{{ $slide['caption'] }}</p>
                            </div>
                        </div>
                    </div>

                @elseif($slide['type'] === 'video')
                    <div class="amv-carousel-slide is-video {{ $idx === 0 ? 'active' : '' }}"
                         data-ytid="{{ $slide['ytid'] }}">
                        <img class="amv-video-thumb" src="{{ $slide['thumb'] }}" alt="{{ $slide['title'] }}" loading="lazy">
                        <div class="amv-slide-overlay">
                            <div class="amv-play-btn" aria-label="Lire la vidéo">
                                <i class="fas fa-play" style="margin-left:4px;"></i>
                            </div>
                        </div>
                        <div class="amv-slide-caption">
                            <div class="amv-slide-caption-inner">
                                <span class="amv-slide-caption-badge">
                                    <i class="fas fa-play-circle"></i> Vidéo
                                </span>
                                <h4 class="amv-slide-title">{{ $slide['title'] }}</h4>
                                <p class="amv-slide-sub">{{ $slide['caption'] }}</p>
                            </div>
                        </div>
                    </div>
                @endif

            @endforeach

        </div>{{-- /.amv-carousel-wrapper --}}

        {{-- Flèches navigation --}}
        <button class="amv-carousel-prev" id="amvPrev" aria-label="Précédent">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="amv-carousel-next" id="amvNext" aria-label="Suivant">
            <i class="fas fa-chevron-right"></i>
        </button>

        {{-- Dots --}}
        <div class="amv-carousel-dots" id="amvDots" role="tablist">
            @foreach($amvSlides as $idx => $slide)
                <button class="amv-dot {{ $idx === 0 ? 'active' : '' }}"
                        aria-label="Slide {{ $idx + 1 }}"
                        data-idx="{{ $idx }}"></button>
            @endforeach
        </div>

    </div>{{-- /.amv-carousel-section --}}

    {{-- ============================================================
         MENU DU RESTAURANT — Navigation tabs + Cartes plats
         ============================================================ --}}
    <div class="amv-menu-section" id="amv-menu-restaurant">
        <div class="amv-menu-inner">

            <div class="amv-section-header">
                <span class="amv-section-eyebrow">Resto Graffiti</span>
                <h3 class="amv-section-title">Notre Menu</h3>
                <p class="amv-section-subtitle">
                    Explorez nos plats par catégorie et réservez directement depuis la carte.
                    Notre sommelier vous suggère le vin idéal pour chaque plat.
                </p>
            </div>

            {{-- Tabs navigation --}}
            <div class="amv-menu-tabs" id="amvMenuTabs" role="tablist">
                @foreach($amvMenuCategories as $idx => $cat)
                    <button class="amv-menu-tab {{ $idx === 0 ? 'active' : '' }}"
                            data-target="amv-cat-{{ $cat['id'] }}"
                            role="tab"
                            aria-selected="{{ $idx === 0 ? 'true' : 'false' }}"
                            aria-controls="amv-cat-{{ $cat['id'] }}">
                        <i class="{{ $cat['icon'] }}"></i>
                        {{ $cat['label'] }}
                    </button>
                @endforeach
            </div>

            {{-- Panneaux par catégorie --}}
            @foreach($amvMenuCategories as $idx => $cat)
                <div class="amv-menu-cat-panel {{ $idx === 0 ? 'active' : '' }}"
                     id="amv-cat-{{ $cat['id'] }}"
                     role="tabpanel">
                    <div class="amv-menu-cards-grid">
                        @foreach($cat['items'] as $dish)
                        <article class="amv-menu-dish-card">
                            <div class="amv-dish-img">
                                <img src="{{ $dish['img'] }}"
                                     alt="{{ $dish['name'] }}"
                                     loading="lazy">
                                <div class="amv-dish-price-badge">{{ $dish['price'] }}</div>
                            </div>
                            <div class="amv-dish-body">
                                <h4 class="amv-dish-name">{{ $dish['name'] }}</h4>
                                <p class="amv-dish-desc">{{ $dish['desc'] }}</p>
                            </div>
                            <div class="amv-dish-footer">
                                <button class="amv-dish-reserve-btn"
                                        onclick="openGoExpResaModal('table', '{{ addslashes($dish['name']) }}')">
                                    <i class="fas fa-calendar-check"></i>
                                    Réserver ce plat
                                </button>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>{{-- /.amv-menu-section --}}

    {{-- ============================================================
         SÉLECTION DE VINS
         ============================================================ --}}
    <div class="amv-wines-section">
        <div class="amv-wines-inner">

            <div class="amv-section-header">
                <span class="amv-section-eyebrow">Notre Sélection</span>
                <h3 class="amv-section-title">Vins d'Exception</h3>
                <p class="amv-section-subtitle">
                    Chaque vin a été choisi par notre sommelier pour sublimer les plats de notre carte.
                    Cliquez sur <em>Réserver ce vin</em> pour l'ajouter à votre expérience.
                </p>
            </div>

            <div class="amv-wines-grid">
                @foreach($amvWines as $wine)
                <article class="amv-wine-card">

                    <div class="amv-wine-card-img">
                        <img src="{{ $wine['img'] }}"
                             alt="{{ $wine['name'] }}"
                             loading="lazy">
                        <span class="amv-wine-type-badge {{ $wine['type'] }}">
                            {{ $wine['type'] === 'rouge' ? 'Rouge' : 'Blanc' }}
                        </span>
                        <span class="amv-wine-region">{{ $wine['region'] }}</span>
                    </div>

                    <div class="amv-wine-card-body">
                        <div class="amv-wine-name">{{ $wine['name'] }}</div>
                        <div class="amv-wine-grape">{{ $wine['grape'] }}</div>
                        <p class="amv-wine-desc">{{ $wine['desc'] }}</p>
                        <div class="amv-wine-stars">{{ $wine['stars'] }}</div>
                        <div class="amv-wine-accord-line">
                            <i class="fas fa-utensils"></i>{{ $wine['accord'] }}
                        </div>
                    </div>

                    <div class="amv-wine-card-footer">
                        <div class="amv-wine-price">
                            <span class="amv-wine-price-amount">{{ $wine['price'] }}</span>
                            <span class="amv-wine-price-unit">{{ $wine['unit'] }}</span>
                        </div>
                        <button class="amv-wine-reserve-btn"
                                data-wine="{{ $wine['name'] }}"
                                aria-label="Réserver {{ $wine['name'] }}">
                            <i class="fas fa-calendar-check"></i>
                            Réserver
                        </button>
                    </div>

                </article>
                @endforeach
            </div>

        </div>
    </div>{{-- /.amv-wines-section --}}


</section>{{-- /.amv-section --}}

{{-- ============================================================
     LIGHTBOX IMAGE
     ============================================================ --}}
<div class="amv-lightbox" id="amvLightbox" role="dialog" aria-modal="true" aria-label="Image agrandie">
    <button class="amv-lightbox-close" id="amvLightboxClose" aria-label="Fermer">✕</button>
    <img class="amv-lightbox-img" id="amvLightboxImg" src="" alt="Vue plein écran">
</div>

{{-- ============================================================
     VIDEO MODAL
     ============================================================ --}}
<div class="amv-video-modal" id="amvVideoModal" role="dialog" aria-modal="true" aria-label="Vidéo">
    <div class="amv-video-modal-inner">
        <button class="amv-video-modal-close" id="amvVideoModalClose" aria-label="Fermer">✕</button>
        <div class="amv-video-ratio">
            <iframe id="amvVideoIframe"
                    src=""
                    allow="autoplay; encrypted-media; fullscreen"
                    allowfullscreen
                    frameborder="0"
                    title="Vidéo Accord Mets & Vins"></iframe>
        </div>
    </div>
</div>

{{-- ================================================================
     JAVASCRIPT
     ================================================================ --}}
<script>
(function () {
    document.addEventListener('DOMContentLoaded', function () {

        /* =============================================
           CAROUSEL
           ============================================= */
        var slides  = document.querySelectorAll('#amvCarouselWrapper .amv-carousel-slide');
        var dots    = document.querySelectorAll('#amvDots .amv-dot');
        var current = 0;
        var timer   = null;

        function goTo(idx) {
            slides[current].classList.remove('active');
            dots[current].classList.remove('active');
            current = (idx + slides.length) % slides.length;
            slides[current].classList.add('active');
            dots[current].classList.add('active');
        }

        function startTimer() {
            timer = setInterval(function () {
                /* Ne pas avancer automatiquement si c'est une diapo vidéo */
                if (!slides[current].classList.contains('is-video')) {
                    goTo(current + 1);
                }
            }, 5000);
        }

        function resetTimer() { clearInterval(timer); startTimer(); }

        var btnPrev = document.getElementById('amvPrev');
        var btnNext = document.getElementById('amvNext');
        if (btnPrev) btnPrev.addEventListener('click', function () { goTo(current - 1); resetTimer(); });
        if (btnNext) btnNext.addEventListener('click', function () { goTo(current + 1); resetTimer(); });

        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                goTo(parseInt(dot.getAttribute('data-idx')));
                resetTimer();
            });
        });

        startTimer();

        /* =============================================
           LIGHTBOX — slides images
           ============================================= */
        var lightbox   = document.getElementById('amvLightbox');
        var lbImg      = document.getElementById('amvLightboxImg');
        var lbClose    = document.getElementById('amvLightboxClose');

        document.querySelectorAll('#amvCarouselWrapper .amv-carousel-slide.is-image').forEach(function (slide) {
            slide.addEventListener('click', function () {
                lbImg.src = slide.getAttribute('data-fullsrc') || '';
                lightbox.classList.add('open');
            });
        });

        if (lbClose) lbClose.addEventListener('click', closeLightbox);
        if (lightbox) lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox) closeLightbox();
        });

        function closeLightbox() {
            lightbox.classList.remove('open');
            lbImg.src = '';
        }

        /* =============================================
           VIDEO MODAL — slides vidéo
           ============================================= */
        var videoModal  = document.getElementById('amvVideoModal');
        var videoIframe = document.getElementById('amvVideoIframe');
        var vmClose     = document.getElementById('amvVideoModalClose');

        document.querySelectorAll('#amvCarouselWrapper .amv-carousel-slide.is-video').forEach(function (slide) {
            slide.addEventListener('click', function () {
                var ytId = slide.getAttribute('data-ytid');
                if (ytId) {
                    videoIframe.src = 'https://www.youtube.com/embed/' + ytId + '?autoplay=1&rel=0&controls=1';
                    videoModal.classList.add('open');
                }
            });
        });

        if (vmClose) vmClose.addEventListener('click', closeVideoModal);
        if (videoModal) videoModal.addEventListener('click', function (e) {
            if (e.target === videoModal) closeVideoModal();
        });

        function closeVideoModal() {
            videoModal.classList.remove('open');
            videoIframe.src = '';
        }

        /* Touche ESC */
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { closeLightbox(); closeVideoModal(); }
        });

        /* =============================================
           TABS MENU DU RESTAURANT
           ============================================= */
        var menuTabs   = document.querySelectorAll('#amvMenuTabs .amv-menu-tab');
        var menuPanels = document.querySelectorAll('.amv-menu-cat-panel');

        menuTabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var targetId = tab.getAttribute('data-target');

                /* Désactiver tous les tabs et panels */
                menuTabs.forEach(function (t) {
                    t.classList.remove('active');
                    t.setAttribute('aria-selected', 'false');
                });
                menuPanels.forEach(function (p) { p.classList.remove('active'); });

                /* Activer le tab et le panel sélectionnés */
                tab.classList.add('active');
                tab.setAttribute('aria-selected', 'true');
                var panel = document.getElementById(targetId);
                if (panel) panel.classList.add('active');

                /* Scroll doux vers la section menu */
                var menuSection = document.getElementById('amv-menu-restaurant');
                if (menuSection) {
                    menuSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        /* =============================================
           BOUTONS RÉSERVER UN VIN → modal global
           ============================================= */
        document.querySelectorAll('.amv-wine-reserve-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var wineName = btn.getAttribute('data-wine') || '';
                if (typeof openGoExpResaModal === 'function') {
                    openGoExpResaModal('wine', wineName);
                }
            });
        });

    });
})();
</script>
@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
