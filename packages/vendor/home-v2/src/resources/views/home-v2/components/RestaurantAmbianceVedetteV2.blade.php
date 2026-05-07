@php(ob_start());@endphp

{{-- ============================================================
     Restaurant Ambiance Vedette V2
     New standalone component (same interaction logic as ProductsVedette)
     ============================================================ --}}
@php
    $restoConfig = [
        'title'    => 'AMBIANCE RESTO - ACCORD METS ET VIN',
        'subtitle' => 'Entrees - Mets principaux - Desserts - Vins. Decouvrez des cartes gastronomiques et accords soignes.',
        'logo_restaurant' => [
            'src'   => asset('logo.png'),
            'alt'   => 'Logo Restaurant',
            'href'  => '#',
            'label' => 'Logo Restaurant',
        ],
        'logo_accord' => [
            'src'   => asset('home2/aventure-accords-met-vin/accord_mets_vin.jpg'),
            'alt'   => 'Accord Mets & Vins',
            'href'  => route('pages.accord-mets-vins'),
            'label' => 'Accord Mets & Vins',
        ],
    ];

    $restoCategories = [
        'entrees'         => ['label' => 'Entrees & Salades', 'icon' => 'fa-seedling'],
        'mets-principaux' => ['label' => 'Plats principaux',  'icon' => 'fa-utensils'],
        'desserts'        => ['label' => 'Desserts',          'icon' => 'fa-ice-cream'],
        'vins'            => ['label' => 'Vins',              'icon' => 'fa-wine-glass'],
    ];

    $restoCards = [
        // Entrees & Salades (7)
        ['cat' => 'entrees', 'img' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=600&h=600&fit=crop', 'title' => 'Burrata, gelee de tomates et tapenade', 'subtitle' => 'Entrees & Salades', 'accord' => 'Chablis - Blanc sec', 'price' => '28 $', 'badge' => 'signature', 'badge_class' => 'cat-entrees'],
        ['cat' => 'entrees', 'img' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=600&h=600&fit=crop', 'title' => 'Polpettes de veau et filet mignon', 'subtitle' => 'Entrees & Salades', 'accord' => 'Chianti Classico', 'price' => '19 $', 'badge' => 'popular', 'badge_class' => 'cat-entrees'],
        ['cat' => 'entrees', 'img' => 'https://images.unsplash.com/photo-1547592180-85f173990554?w=600&h=600&fit=crop', 'title' => "Soupe a l oignon gratinee", 'subtitle' => 'Entrees & Salades', 'accord' => 'Chardonnay - Vin blanc sec', 'price' => '15 $', 'badge' => 'new', 'badge_class' => 'cat-entrees'],
        ['cat' => 'entrees', 'img' => 'https://images.unsplash.com/photo-1580822184713-fc5400e7fe10?w=600&h=600&fit=crop', 'title' => 'Tartare de thon, salsa mangue', 'subtitle' => 'Entrees & Salades', 'accord' => 'Sauvignon Blanc - Pouilly Fume', 'price' => '26 $', 'badge' => 'popular', 'badge_class' => 'cat-entrees'],
        ['cat' => 'entrees', 'img' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=600&h=600&fit=crop', 'title' => 'Feuillete crevettes et petoncles', 'subtitle' => 'Entrees & Salades', 'accord' => 'Chablis - Blanc de Blancs', 'price' => '24 $', 'badge' => 'signature', 'badge_class' => 'cat-entrees'],
        ['cat' => 'entrees', 'img' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=600&h=600&fit=crop', 'title' => 'Salade Cesar au jambon de parme', 'subtitle' => 'Entrees & Salades', 'accord' => 'Pinot Grigio', 'price' => '19 $', 'badge' => 'popular', 'badge_class' => 'cat-entrees'],
        ['cat' => 'entrees', 'img' => 'https://images.unsplash.com/photo-1476124369491-e7addf5db371?w=600&h=600&fit=crop', 'title' => 'Carpaccio de boeuf, parmesan', 'subtitle' => 'Entrees & Salades', 'accord' => 'Barolo', 'price' => '25 $', 'badge' => 'new', 'badge_class' => 'cat-entrees'],

        // Plats principaux (7)
        ['cat' => 'mets-principaux', 'img' => 'https://images.unsplash.com/photo-1476124369491-e7addf5db371?w=600&h=600&fit=crop', 'title' => 'Risotto Graffiti', 'subtitle' => 'Plats principaux', 'accord' => 'Barolo - Nebbiolo', 'price' => '35 $', 'badge' => 'signature', 'badge_class' => 'cat-mets'],
        ['cat' => 'mets-principaux', 'img' => 'https://images.unsplash.com/photo-1558030006-450675393462?w=600&h=600&fit=crop', 'title' => 'Filet mignon sauce porto', 'subtitle' => 'Plats principaux', 'accord' => 'Saint Emilion - Pomerol', 'price' => '56 $', 'badge' => 'popular', 'badge_class' => 'cat-mets'],
        ['cat' => 'mets-principaux', 'img' => 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=600&h=600&fit=crop', 'title' => 'Raviolis champignons sauvages', 'subtitle' => 'Plats principaux', 'accord' => 'Pinot Noir - Bourgogne', 'price' => '29 $', 'badge' => 'new', 'badge_class' => 'cat-mets'],
        ['cat' => 'mets-principaux', 'img' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=600&h=600&fit=crop', 'title' => 'Linguine fruits de mer', 'subtitle' => 'Plats principaux', 'accord' => 'Muscadet', 'price' => '37 $', 'badge' => 'popular', 'badge_class' => 'cat-mets'],
        ['cat' => 'mets-principaux', 'img' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=600&h=600&fit=crop', 'title' => 'Escalope de veau parmigiana', 'subtitle' => 'Plats principaux', 'accord' => 'Chianti Classico', 'price' => '37 $', 'badge' => 'signature', 'badge_class' => 'cat-mets'],
        ['cat' => 'mets-principaux', 'img' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=600&h=600&fit=crop', 'title' => 'Joue de boeuf braisee', 'subtitle' => 'Plats principaux', 'accord' => 'Pomerol - Merlot', 'price' => '44 $', 'badge' => 'popular', 'badge_class' => 'cat-mets'],
        ['cat' => 'mets-principaux', 'img' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=600&h=600&fit=crop', 'title' => 'Saumon roti et crevettes', 'subtitle' => 'Plats principaux', 'accord' => 'Chablis Grand Cru', 'price' => '42 $', 'badge' => 'new', 'badge_class' => 'cat-mets'],

        // Desserts (7)
        ['cat' => 'desserts', 'img' => 'https://images.unsplash.com/photo-1470324161839-ce2bb6fa6bc3?w=600&h=600&fit=crop', 'title' => 'Creme brulee vanille', 'subtitle' => 'Desserts', 'accord' => 'Sauternes - Moelleux', 'price' => '11 $', 'badge' => 'new', 'badge_class' => 'cat-desserts'],
        ['cat' => 'desserts', 'img' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=600&h=600&fit=crop', 'title' => 'Tiramisu maison', 'subtitle' => 'Desserts', 'accord' => 'Moscato d Asti', 'price' => '12 $', 'badge' => 'popular', 'badge_class' => 'cat-desserts'],
        ['cat' => 'desserts', 'img' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=600&h=600&fit=crop', 'title' => 'Fondant chocolat coeur coulant', 'subtitle' => 'Desserts', 'accord' => 'Porto Ruby', 'price' => '13 $', 'badge' => 'signature', 'badge_class' => 'cat-desserts'],
        ['cat' => 'desserts', 'img' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=600&h=600&fit=crop', 'title' => 'Cheesecake fruits rouges', 'subtitle' => 'Desserts', 'accord' => 'Late Harvest Riesling', 'price' => '12 $', 'badge' => 'popular', 'badge_class' => 'cat-desserts'],
        ['cat' => 'desserts', 'img' => 'https://images.unsplash.com/photo-1464306076886-da185f6a9d05?w=600&h=600&fit=crop', 'title' => 'Mille feuille pralinette', 'subtitle' => 'Desserts', 'accord' => 'Champagne Demi Sec', 'price' => '14 $', 'badge' => 'new', 'badge_class' => 'cat-desserts'],
        ['cat' => 'desserts', 'img' => 'https://images.unsplash.com/photo-1495147466023-ac5c588e2e94?w=600&h=600&fit=crop', 'title' => 'Pavlova agrumes et vanille', 'subtitle' => 'Desserts', 'accord' => 'Gewurztraminer', 'price' => '13 $', 'badge' => 'popular', 'badge_class' => 'cat-desserts'],
        ['cat' => 'desserts', 'img' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=600&h=600&fit=crop', 'title' => 'Tarte fine pommes carmelisees', 'subtitle' => 'Desserts', 'accord' => 'Cidre de glace', 'price' => '12 $', 'badge' => 'signature', 'badge_class' => 'cat-desserts'],

        // Vins (7)
        ['cat' => 'vins', 'img' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=600&h=600&fit=crop', 'title' => 'Selection Sommelier', 'subtitle' => 'Vins', 'accord' => 'Accords du chef', 'price' => '39 $', 'badge' => 'new', 'badge_class' => 'cat-vins'],
        ['cat' => 'vins', 'img' => 'https://images.unsplash.com/photo-1474722883778-792e7990302f?w=600&h=600&fit=crop', 'title' => 'Grand Cru Rouge - Cave Prestige', 'subtitle' => 'Vins', 'accord' => 'Viandes braisees', 'price' => '56 $', 'badge' => 'signature', 'badge_class' => 'cat-vins'],
        ['cat' => 'vins', 'img' => 'https://images.unsplash.com/photo-1470337458703-46ad1756a187?w=600&h=600&fit=crop', 'title' => 'Blanc mineral - recolte cotiere', 'subtitle' => 'Vins', 'accord' => 'Fruits de mer', 'price' => '44 $', 'badge' => 'popular', 'badge_class' => 'cat-vins'],
        ['cat' => 'vins', 'img' => 'https://images.unsplash.com/photo-1497534446932-c925b458314e?w=600&h=600&fit=crop', 'title' => 'Rose et bulles - soiree festive', 'subtitle' => 'Vins', 'accord' => 'Aperitifs et desserts', 'price' => '48 $', 'badge' => 'new', 'badge_class' => 'cat-vins'],
        ['cat' => 'vins', 'img' => 'https://images.unsplash.com/photo-1506377247377-2a5b3b417ebb?w=600&h=600&fit=crop', 'title' => 'Pinot Noir reserve', 'subtitle' => 'Vins', 'accord' => 'Canard et champignons', 'price' => '52 $', 'badge' => 'popular', 'badge_class' => 'cat-vins'],
        ['cat' => 'vins', 'img' => 'https://images.unsplash.com/photo-1432139555190-58524dae6a55?w=600&h=600&fit=crop', 'title' => 'Chardonnay barrique', 'subtitle' => 'Vins', 'accord' => 'Poissons en sauce', 'price' => '46 $', 'badge' => 'signature', 'badge_class' => 'cat-vins'],
        ['cat' => 'vins', 'img' => 'https://images.unsplash.com/photo-1547595628-c61a29f496f0?w=600&h=600&fit=crop', 'title' => 'Cremant brut prestige', 'subtitle' => 'Vins', 'accord' => 'Desserts et reception', 'price' => '42 $', 'badge' => 'new', 'badge_class' => 'cat-vins'],
    ];

    $restoSlides = [
        [
            'main' => [
                'src'   => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=900&h=500&fit=crop',
                'video' => 'xPPLbEFbCAo',
                'title' => 'Ambiance resto - Accord mets et vins',
                'desc'  => 'Selection gastronomique et cave de degustation',
                'badge' => 'new',
            ],
            'grid' => [
                ['src' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=500&h=300&fit=crop', 'video' => 'xPPLbEFbCAo', 'title' => 'Selection de vins', 'desc' => 'Rouges, blancs et bulles', 'badge' => 'popular'],
                ['src' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500&h=300&fit=crop', 'video' => 'xPPLbEFbCAo', 'title' => 'Cuisine raffinee', 'desc' => 'Mets signatures du chef', 'badge' => 'hot'],
                ['src' => 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?w=500&h=300&fit=crop', 'video' => 'xPPLbEFbCAo', 'title' => 'Accords parfaits', 'desc' => 'Chaque plat avec son vin', 'badge' => 'trending'],
                ['src' => 'https://images.unsplash.com/photo-1559329007-40df8a9345d8?w=500&h=300&fit=crop', 'video' => 'xPPLbEFbCAo', 'title' => 'Moments dexception', 'desc' => 'Experience haut de gamme', 'badge' => 'new'],
            ],
        ],
        [
            'main' => [
                'src'   => 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?w=900&h=500&fit=crop',
                'video' => 'xPPLbEFbCAo',
                'title' => 'Cave de degustation premium',
                'desc'  => 'Decouverte des meilleurs crus avec sommeliers',
                'badge' => 'trending',
            ],
            'grid' => [
                ['src' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=500&h=300&fit=crop', 'video' => 'xPPLbEFbCAo', 'title' => 'Rouges de caractere', 'desc' => 'Selection Bordeaux, Rhone et Italie', 'badge' => 'popular'],
                ['src' => 'https://images.unsplash.com/photo-1474722883778-792e7990302f?w=500&h=300&fit=crop', 'video' => 'xPPLbEFbCAo', 'title' => 'Accords viandes', 'desc' => 'Cabernet, Merlot et Syrah', 'badge' => 'hot'],
                ['src' => 'https://images.unsplash.com/photo-1470337458703-46ad1756a187?w=500&h=300&fit=crop', 'video' => 'xPPLbEFbCAo', 'title' => 'Accords poissons', 'desc' => 'Chardonnay et Sauvignon Blanc', 'badge' => 'trending'],
                ['src' => 'https://images.unsplash.com/photo-1497534446932-c925b458314e?w=500&h=300&fit=crop', 'video' => 'xPPLbEFbCAo', 'title' => 'Rose et bulles', 'desc' => 'Aperitif et soirees festives', 'badge' => 'new'],
            ],
        ],
        [
            'main' => [
                'src'   => 'https://images.unsplash.com/photo-1466978913421-dad2ebd01d17?w=900&h=500&fit=crop',
                'video' => 'xPPLbEFbCAo',
                'title' => 'Menu degustation signature',
                'desc'  => 'Parcours gastronomique en plusieurs services',
                'badge' => 'hot',
            ],
            'grid' => [
                ['src' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=500&h=300&fit=crop', 'video' => 'xPPLbEFbCAo', 'title' => 'Entrees marines', 'desc' => 'Thon, saumon et petoncles', 'badge' => 'popular'],
                ['src' => 'https://images.unsplash.com/photo-1476124369491-e7addf5db371?w=500&h=300&fit=crop', 'video' => 'xPPLbEFbCAo', 'title' => 'Risottos et pates', 'desc' => 'Textures fondantes et parfums intenses', 'badge' => 'trending'],
                ['src' => 'https://images.unsplash.com/photo-1558030006-450675393462?w=500&h=300&fit=crop', 'video' => 'xPPLbEFbCAo', 'title' => 'Plats nobles', 'desc' => 'Filet mignon et reductions maison', 'badge' => 'hot'],
                ['src' => 'https://images.unsplash.com/photo-1470324161839-ce2bb6fa6bc3?w=500&h=300&fit=crop', 'video' => 'xPPLbEFbCAo', 'title' => 'Final sucre', 'desc' => 'Desserts delicats et accords doux', 'badge' => 'new'],
            ],
        ],
    ];

    $restoDests = [
        ['key' => 'all',           'label' => 'Toutes destinations'],
        ['key' => 'amerique-nord', 'label' => 'Amerique du Nord'],
        ['key' => 'canada',        'label' => 'Canada'],
        ['key' => 'quebec',        'label' => 'Quebec'],
        ['key' => 'region-quebec', 'label' => 'Region de Quebec'],
    ];
@endphp

<section class="products-vedette-v2-section" id="resto-ambiance-vedette-v2">
    <div class="products-vedette-v2-container">

        <div class="resto-header-block">
            <div class="resto-header-main">
                <div class="resto-header-logo-left">
                    <a href="{{ $restoConfig['logo_restaurant']['href'] }}"
                       class="resto-accord-btn"
                       title="{{ $restoConfig['logo_restaurant']['label'] }}"
                       target="_blank"
                       rel="noopener noreferrer">
                        <div class="logo-wrapper">
                            <img src="{{ $restoConfig['logo_restaurant']['src'] }}"
                                 alt="{{ $restoConfig['logo_restaurant']['alt'] }}">
                        </div>
                        <span class="resto-accord-btn-label">{{ $restoConfig['logo_restaurant']['label'] }}</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-external-link-alt"></i> Visiter
                        </span>
                    </a>
                </div>

                <div class="resto-header-center">
                    <h1 class="resto-header-title" id="restoHeaderTitle">{{ $restoConfig['title'] }}</h1>
                    <p class="resto-header-subtitle" id="restoHeaderSubtitle">{{ $restoConfig['subtitle'] }}</p>
                    <div class="resto-header-tabs" id="restoHeaderTabs" role="tablist">
                        @php
                            $allCount = count($restoCards);
                            $entreesCount = count(array_filter($restoCards, fn($m) => $m['cat'] === 'entrees'));
                            $metsCount = count(array_filter($restoCards, fn($m) => $m['cat'] === 'mets-principaux'));
                            $dessertsCount = count(array_filter($restoCards, fn($m) => $m['cat'] === 'desserts'));
                            $vinsCount = count(array_filter($restoCards, fn($m) => $m['cat'] === 'vins'));
                        @endphp
                        <button class="resto-tab-btn active" role="tab" data-cat="all" aria-selected="true">
                            <span class="resto-tab-count">{{ $allCount }}</span> Toutes les formules
                        </button>
                        <button class="resto-tab-btn" role="tab" data-cat="entrees" aria-selected="false">
                            <span class="resto-tab-count">{{ $entreesCount }}</span> Entrees & Salades
                        </button>
                        <button class="resto-tab-btn" role="tab" data-cat="mets-principaux" aria-selected="false">
                            <span class="resto-tab-count">{{ $metsCount }}</span> Plats principaux
                        </button>
                        <button class="resto-tab-btn" role="tab" data-cat="desserts" aria-selected="false">
                            <span class="resto-tab-count">{{ $dessertsCount }}</span> Desserts
                        </button>
                        <button class="resto-tab-btn" role="tab" data-cat="vins" aria-selected="false">
                            <span class="resto-tab-count">{{ $vinsCount }}</span> Vins
                        </button>
                    </div>
                </div>

                <div class="resto-header-logo-right">
                    <a href="{{ $restoConfig['logo_accord']['href'] }}"
                       class="resto-accord-btn"
                       title="{{ $restoConfig['logo_accord']['label'] }}"
                       target="_blank"
                       rel="noopener noreferrer">
                        <div class="logo-wrapper">
                            <img src="{{ $restoConfig['logo_accord']['src'] }}"
                                 alt="{{ $restoConfig['logo_accord']['alt'] }}">
                        </div>
                        <span class="resto-accord-btn-label">{{ $restoConfig['logo_accord']['label'] }}</span>
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
                        <a href="#" class="resto-cta-btn primary" onclick="openGoExpResaModal('table'); return false;">
                            <i class="fas fa-calendar-check"></i>
                            Reservez une table
                        </a>
                        <a href="#resto-ambiance-vedette-v2" class="resto-cta-btn secondary">
                            En savoir
                            <span class="cta-plus">+</span>
                        </a>
                    </div>

                    <a href="#section-vedettes" class="resto-cta-btn resto-events-nav-btn">
                        <i class="fas fa-calendar-days"></i>
                        Evenements
                    </a>

                    <a href="#section-next-level" class="resto-plans-btn">
                        <i class="fas fa-rocket"></i>
                        <span>Plans Go Next Level</span>
                    </a>

                    <div class="resto-lang-switcher">
                        <i class="fas fa-globe"></i>
                        <select class="resto-lang-select" onchange="restoSwitchLang(this.value)">
                            <option value="fr">Francais</option>
                            <option value="en">English</option>
                            <option value="es">Espanol</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="resto-header-shimmer"></div>
        </div>

        <div class="vedette-carousel-outer products-vedette-v2-carousel">
            <button class="vedette-carousel-btn vedette-carousel-prev" id="restoAmbianceCarouselPrev" aria-label="Precedent"><i class="fas fa-chevron-left"></i></button>
            <div class="products-vedette-v2-scroll-wrapper">
                <div class="products-vedette-v2-scroll-container" id="restoAmbianceVedetteGrid">
                    @foreach($restoCards as $c)
                    <article class="resto-card resto-ambiance-v2-card"
                             data-category="{{ $c['cat'] }}"
                             data-badge="{{ $c['badge'] ?? '' }}">
                        <div class="resto-card-img">
                            <img src="{{ $c['img'] }}" alt="{{ $c['title'] }}" loading="lazy">
                            <div class="resto-card-badges">
                                <span class="resto-badge {{ $c['badge_class'] ?? 'cat-entrees' }}">{{ $c['subtitle'] }}</span>
                            </div>
                            <div class="resto-price-overlay">{{ $c['price'] }}</div>
                        </div>

                        <div class="resto-card-body">
                            <h3 class="resto-card-name">{{ $c['title'] }}</h3>
                            <p class="resto-card-desc">{{ $c['subtitle'] }}</p>
                            <div class="resto-card-accord">
                                <i class="fas fa-wine-glass-alt"></i>
                                Accord : {{ $c['accord'] }}
                            </div>
                        </div>

                        <div class="resto-card-footer">
                            <span class="resto-card-subcategory">{{ $c['subtitle'] }}</span>
                            <button class="resto-card-reserve-btn resto-ambiance-v2-reserve-btn"
                                    type="button"
                                    aria-label="Reserver"
                                    data-item="{{ $c['title'] }}">
                                    <i class="fas fa-calendar-check"></i>
                                    Reservez
                            </button>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            <button class="vedette-carousel-btn vedette-carousel-next" id="restoAmbianceCarouselNext" aria-label="Suivant"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="vedette-carousel-progress"><div class="vedette-carousel-bar" id="restoAmbianceCarouselBar"></div></div>

        @include('home-v2.components.MediaSlideshow', [
            'slideshowId' => 'restoAmbianceMediaV2',
            'slides'      => $restoSlides,
        ])
    </div>
</section>

<style>
/* Header override: 3 colonnes égales + gauche masqué */
#resto-ambiance-vedette-v2 .resto-header-main {
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 10px;
}
#resto-ambiance-vedette-v2 .resto-header-center {
    grid-column: 2;
    width: 100%;
    max-width: 100%;
}
#resto-ambiance-vedette-v2 .resto-header-logo-left {
    display: none !important;
}
#resto-ambiance-vedette-v2 .resto-header-logo-right {
    grid-column: 3;
    justify-self: end;
    width: auto;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

/* garde le style droit compact */
#resto-ambiance-vedette-v2 .resto-header-logo-right {
    pointer-events: auto;
}

@media (max-width: 1024px) {
    #resto-ambiance-vedette-v2 .resto-header-main {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

/* Keep ProductsVedette logic (horizontal carousel), but with Restau card design */
#resto-ambiance-vedette-v2 .products-vedette-v2-scroll-container {
    display: flex;
    gap: 20px;
    overflow: visible;
    padding-bottom: 8px;
    will-change: transform;
}
#resto-ambiance-vedette-v2 .resto-ambiance-v2-card {
    min-width: 280px;
    max-width: 280px;
    flex-shrink: 0;
}
#resto-ambiance-vedette-v2 .resto-ambiance-v2-card .resto-card-img {
    height: 220px;
}
</style>

<script>
(function () {
    var wrapper = document.getElementById('restoAmbianceVedetteGrid');
    var section = wrapper ? wrapper.closest('section') : null;
    if (!wrapper || !section) return;

    var GAP = 20;
    var PAUSE = 3500;
    var ANIM = 480;
    var timer = null;
    var busy = false;

    function vis() {
        return Array.from(wrapper.children).filter(function (c) { return c.style.display !== 'none'; });
    }

    function shiftLeft() {
        var vc = vis();
        if (busy || vc.length < 2) return;
        busy = true;
        var shift = vc[0].offsetWidth + GAP;
        wrapper.style.transition = 'transform ' + ANIM + 'ms cubic-bezier(0.4,0,0.2,1)';
        wrapper.style.transform = 'translateX(-' + shift + 'px)';
        setTimeout(function () {
            wrapper.style.transition = 'none';
            wrapper.style.transform = 'translateX(0)';
            wrapper.appendChild(vc[0]);
            busy = false;
            resetBar();
        }, ANIM + 20);
    }

    function shiftRight() {
        var vc = vis();
        if (busy || vc.length < 2) return;
        busy = true;
        var last = vc[vc.length - 1];
        var shift = last.offsetWidth + GAP;
        wrapper.style.transition = 'none';
        wrapper.insertBefore(last, wrapper.firstChild);
        wrapper.style.transform = 'translateX(-' + shift + 'px)';
        wrapper.offsetWidth;
        wrapper.style.transition = 'transform ' + ANIM + 'ms cubic-bezier(0.4,0,0.2,1)';
        wrapper.style.transform = 'translateX(0)';
        setTimeout(function () { busy = false; resetBar(); }, ANIM + 20);
    }

    function startAuto() { timer = setInterval(shiftLeft, PAUSE); }
    function stopAuto() { clearInterval(timer); }

    var bar = document.getElementById('restoAmbianceCarouselBar');
    function resetBar() {
        if (!bar) return;
        bar.style.transition = 'none';
        bar.style.width = '0%';
        bar.offsetWidth;
        bar.style.transition = 'width ' + PAUSE + 'ms linear';
        bar.style.width = '100%';
    }
    resetBar();

    section.addEventListener('mouseenter', stopAuto);
    section.addEventListener('mouseleave', startAuto);
    startAuto();

    var prev = document.getElementById('restoAmbianceCarouselPrev');
    var next = document.getElementById('restoAmbianceCarouselNext');
    if (prev) prev.addEventListener('click', function () { stopAuto(); shiftRight(); startAuto(); });
    if (next) next.addEventListener('click', function () { stopAuto(); shiftLeft(); startAuto(); });

    section.querySelectorAll('.resto-tab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            section.querySelectorAll('.resto-tab-btn').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            var mode = btn.getAttribute('data-cat');
            Array.from(wrapper.children).forEach(function (c) {
                var cat = c.getAttribute('data-category') || '';
                c.style.display = (mode === 'all' || cat === mode) ? '' : 'none';
            });
            wrapper.style.transition = 'none';
            wrapper.style.transform = 'translateX(0)';
            busy = false;
            resetBar();
            stopAuto();
            startAuto();
        });
    });

    // Meme logique que l'ancien bloc RestaurantHeader -> modal global goexpResaModal
    wrapper.querySelectorAll('.resto-ambiance-v2-reserve-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var itemName = btn.getAttribute('data-item') || '';
            if (typeof openGoExpResaModal === 'function') {
                openGoExpResaModal('table', itemName);
            }
        });
    });
})();
</script>

@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
