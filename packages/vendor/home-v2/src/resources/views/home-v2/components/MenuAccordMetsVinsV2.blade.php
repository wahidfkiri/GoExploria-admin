{{-- ============================================================
     MENU À LA CARTE — Layout alternant texte + carousel
     Sections : Entrées · Salades · Pâtes · Tartares · Classiques · Desserts
     ============================================================ --}}

@php(ob_start());@endphp
@php
$menuSections = [
    [
        'id'       => 'entrees',
        'title'    => 'Entrées',
        'category' => 'Mise en bouche',
        'subtitle' => 'Nos entrées subliment les meilleurs produits du terroir québécois et de la Méditerranée.',
        'icon'     => 'fa-leaf',
        'color'    => '#2c7a4b',
        'imgs'     => [
            'https://images.unsplash.com/photo-1541614101331-1a5a3a194e92?w=900&h=700&fit=crop',
            'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?w=900&h=700&fit=crop',
            'https://images.unsplash.com/photo-1559339352-11d035aa65de?w=900&h=700&fit=crop',
        ],
        'items' => [
            ['name'=>"Burrata, gelée de tomates, tapenade d'olives et crumble",       'desc'=>"Huile verte, oignons marinés, pousses de basilic et pain foccacia",                                                                   'price'=>'28 $'],
            ['name'=>'Polpettes de veau et filet mignon',                              'desc'=>'Sauce tomates maison, pousse de basilic et parmesan',                                                                               'price'=>'19 $'],
            ['name'=>'Poêlée de ris de veau',                                          'desc'=>'Champignons marinés au balsamique',                                                                                                 'price'=>'28 $'],
            ['name'=>'Bruschetta au canard confit',                                    'desc'=>"Pain à l'ail gratiné au fromage Doré-mi",                                                                                           'price'=>'18 $'],
            ['name'=>"Soupe à l'oignon gratinée au migneron de Charlevoix",           'desc'=>null,                                                                                                                                'price'=>'15 $'],
            ['name'=>'Tartare de Thon, salsa de mangues, tortillas de maïs',          'desc'=>'Servi avec salade du marché',                                                                                                       'price'=>'26 $'],
            ['name'=>'Potage de saison au goût du jour',                               'desc'=>null,                                                                                                                                'price'=>'9 $'],
            ['name'=>'Tomate Caprèse',                                                 'desc'=>'Mozzarella di Bufala, tomate confite au pesto, caramel de balsamique et roquette',                                                 'price'=>'17 $'],
            ['name'=>'Feuilleté de crevettes et pétoncles',                           'desc'=>"Beurre nantais et tombée d'épinards",                                                                                               'price'=>'24 $'],
            ['name'=>'Dégustation de saumon en trois temps',                          'desc'=>"Tartare, gravlax et fumé de la Boucanerie d'Henry",                                                                                 'price'=>'24 $'],
            ['name'=>"Escargots crémeux parfumé à l'estragon",                        'desc'=>"Foccacia à l'ail grillé",                                                                                                           'price'=>'20 $'],
            ['name'=>"Duo d'arancini aux champignons et fondue parmesan",              'desc'=>'Ketchup maison, roquette',                                                                                                          'price'=>'19 $'],
            ['name'=>'Carpaccio de filet mignon de bœuf',                             'desc'=>"Aïoli maison, citron confit, copeaux de vieux parmesan, câpres, noix de pin, huile de roquette et pousse de basilic",             'price'=>'25 $'],
        ],
    ],
    [
        'id'       => 'salades',
        'title'    => 'Salades',
        'category' => 'Fraîcheur & Légèreté',
        'subtitle' => 'Des salades généreuses pour accompagner ou en plat principal.',
        'icon'     => 'fa-seedling',
        'color'    => '#5a8a2e',
        'imgs'     => [
            'https://images.unsplash.com/photo-1546793665-c74683f339c1?w=900&h=700&fit=crop',
            'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=900&h=700&fit=crop',
        ],
        'items' => [
            ['name'=>'César', 'desc'=>'Jambon de parme et parmigiano reggiano — Extra poulet grillé (+7 $)', 'price'=>'19 $'],
        ],
    ],
    [
        'id'       => 'pates',
        'title'    => 'Les Pâtes & Risottos',
        'category' => 'Plats principaux',
        'subtitle' => "Notre chef revisite les classiques italiens avec des produits locaux d'exception.",
        'icon'     => 'fa-utensils',
        'color'    => '#c0392b',
        'imgs'     => [
            'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=900&h=700&fit=crop',
            'https://images.unsplash.com/photo-1563379926898-05f4575a45d8?w=900&h=700&fit=crop',
            'https://images.unsplash.com/photo-1612874742237-6526221588e3?w=900&h=700&fit=crop',
        ],
        'items' => [
            ['name'=>'Risotto Graffiti',                                   'desc'=>'Flanc de porc croustillant, tomates fraîches, champignons, fines herbes, crumble de panko, poireaux au beurre, parmesan',    'price'=>'35 $'],
            ['name'=>'Risotto au canard confit',                           'desc'=>'Canneberges, poireaux et mascarpone, fines herbes et parmesan reggiano',                                                      'price'=>'35 $'],
            ['name'=>'Raviolis aux champignons sauvages',                  'desc'=>'Noix de pin, tomates, épinard frit, crème, vin blanc et parmesan reggiano',                                                  'price'=>'29 $'],
            ['name'=>'Gnocchis aux pommes caramélisées',                  'desc'=>'Fromage Haloumi, noix de cajou rôties, tomates fraîches, crème, vin blanc et parmesan',                                      'price'=>'29 $'],
            ['name'=>'Linguine Graffiti',                                  'desc'=>'Jambon de Parme, champignons, tomates fraîches, vin blanc, crème et parmesan reggiano',                                     'price'=>'27 $'],
            ['name'=>'Fettucine Alfredo au poulet grillé',                 'desc'=>'Crème, vin blanc et parmesan',                                                                                               'price'=>'26 $'],
            ['name'=>'Lasagne maison à la chair de saucisse',              'desc'=>'Ricotta et épinard — Extra salade césar +8 $',                                                                               'price'=>'25 $'],
            ['name'=>'Spaghetti pomodoro',                                 'desc'=>'Sauce tomate maison, pesto de basilic',                                                                                      'price'=>'22 $'],
            ['name'=>'Linguine aux fruits de mer',                         'desc'=>'Pétoncles, crevettes, moules et palourdes, sauce crème et vin blanc',                                                       'price'=>'37 $'],
            ['name'=>'Fettucine au canard confit et oignons caramélisés',  'desc'=>'Tombée de poireaux, échalote et noix de cajou torréfiée',                                                                   'price'=>'35 $'],
        ],
    ],
    [
        'id'       => 'tartares',
        'title'    => 'Les Tartares',
        'category' => 'Spécialités crudités',
        'subtitle' => 'Servis en entrée ou en plat, nos tartares sont préparés minute devant vous.',
        'icon'     => 'fa-fish',
        'color'    => '#1a6896',
        'imgs'     => [
            'https://images.unsplash.com/photo-1529193591184-b1d58069ecdd?w=900&h=700&fit=crop',
            'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?w=900&h=700&fit=crop',
        ],
        'items' => [
            ['name'=>'Tartare de bœuf classique',  'desc'=>'Pommes de terre frites et salade',                               'price'=>'Entrée 25 $ | Plat 33 $'],
            ['name'=>'Tartare de saumon',           'desc'=>"Chutney d'ananas et mangue, pommes de terre frites et salade",  'price'=>'Entrée 25 $ | Plat 33 $'],
        ],
    ],
    [
        'id'       => 'classiques',
        'title'    => 'Les Classiques du Graffiti',
        'category' => 'Pièces de résistance',
        'subtitle' => 'Nos signatures gastronomiques — plats nobles travaillés avec passion et précision.',
        'icon'     => 'fa-crown',
        'color'    => '#7d3c98',
        'imgs'     => [
            'https://images.unsplash.com/photo-1544025162-d76694265947?w=900&h=700&fit=crop',
            'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=900&h=700&fit=crop',
            'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=900&h=700&fit=crop',
        ],
        'items' => [
            ['name'=>'Filet mignon de bœuf, sauce porto et fromage migneron',       'desc'=>'Risotto aux champignons sauvages, huile de truffes et légumes du moment',                                           'price'=>'56 $'],
            ['name'=>'Escalope de veau parmigiana',                                  'desc'=>'Tomates, gratinée au parmesan et mozzarella avec linguine et légumes du moment',                                   'price'=>'37 $'],
            ['name'=>'Joue de bœuf braisée à basse température',                   'desc'=>"Sauce aux fines herbes et pommes caramélisées, tombée d'épinards, poireaux frits et purée de pommes de terre",     'price'=>'44 $'],
            ['name'=>'Ris de veau poêlés aux champignons marinés au balsamique',    'desc'=>'Gratin dauphinois et légumes du moment',                                                                             'price'=>'50 $'],
            ['name'=>'Escalope de veau Graffiti',                                   'desc'=>'Sauce crème aux champignons et linguine avec légumes du moment',                                                    'price'=>'36 $'],
            ['name'=>"Saumon de l'Atlantique rôti et crevettes",                    'desc'=>'Beurre blanc citronné, risotto et légumes du moment',                                                               'price'=>'42 $'],
            ['name'=>'Escalope de veau au citron',                                  'desc'=>'Linguine et légumes du moment',                                                                                     'price'=>'35 $'],
        ],
    ],
    [
        'id'       => 'desserts',
        'title'    => 'Desserts',
        'category' => 'Douceurs',
        'subtitle' => 'Une conclusion sucrée pour couronner votre expérience Graffiti.',
        'icon'     => 'fa-ice-cream',
        'color'    => '#b7860b',
        'imgs'     => [
            'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=900&h=700&fit=crop',
            'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=900&h=700&fit=crop',
        ],
        'items' => [
            ['name'=>'Crème brulée vanille', 'desc'=>'Petits fruits — sans gluten', 'price'=>'—'],
        ],
    ],
];
@endphp

{{-- ============================================================
     HÉRO VIDÉO — texte gauche + sélecteur vidéos + iframe droite
     ============================================================ --}}
@php
$heroVideos = [
    ['id' => 'xPPLbEFbCAo', 'label' => 'Ambiance Graffiti',   'icon' => 'fa-glass-cheers'],
    ['id' => 'kM1ff5bJAhE', 'label' => 'Notre Cuisine',        'icon' => 'fa-utensils'],
    ['id' => 'f5IQ8_dXFyU', 'label' => 'Accords Mets &amp; Vins', 'icon' => 'fa-wine-glass'],
    ['id' => 'iZNPI1w2XK8', 'label' => 'Sélection du Chef',   'icon' => 'fa-crown'],
];
@endphp
<div class="amv-hero-video-wrap">

    {{-- Gauche : texte + tabs + CTAs --}}
    <div class="amv-hero-video-left">
        <span class="amv-hero-eyebrow"><i class="fas fa-star"></i> Notre univers</span>
        <h1 class="amv-hero-title">Vivez l'Expérience<br><span>Graffiti</span></h1>
        <p class="amv-hero-lead">Découvrez l'ambiance unique de notre restaurant, notre cuisine italienne contemporaine et l'art de nos accords mets &amp; vins.</p>
        <div class="amv-hero-vtabs">
            @foreach($heroVideos as $vi => $vid)
            <button class="amv-hero-vtab {{ $vi === 0 ? 'active' : '' }}"
                    data-vid="{{ $vid['id'] }}"
                    onclick="amvSwitchVideo('{{ $vid['id'] }}', this)">
                <i class="fas {{ $vid['icon'] }}"></i>
                <span>{{ $vid['label'] }}</span>
            </button>
            @endforeach
        </div>
        <div class="amv-hero-actions">
            <a href="#amv-menu-section" class="amv-hero-btn-primary">
                <i class="fas fa-utensils"></i> Voir le menu
            </a>
            <button class="amv-hero-btn-secondary" onclick="openGoExpResaModal('table')">
                <i class="fas fa-calendar-check"></i> Réserver
            </button>
        </div>
    </div>

    {{-- Droite : iframe YouTube sélectionnable --}}
    <div class="amv-hero-video-right">
        <div class="amv-hero-video-frame">
            <iframe id="amv-hero-iframe"
                src="https://www.youtube.com/embed/{{ $heroVideos[0]['id'] }}?rel=0&amp;modestbranding=1&amp;color=white"
                title="Resto Graffiti"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
    </div>

</div>

{{-- ============================================================
     À PROPOS
     ============================================================ --}}
@php
$aproposImgs = [
    'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=900&h=700&fit=crop',
    'https://images.unsplash.com/photo-1559339352-11d035aa65de?w=900&h=700&fit=crop',
    'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=900&h=700&fit=crop',
];
@endphp

<div class="amv-apropos-wrap" id="amv-apropos">
    <div class="amv-apropos-section">

        {{-- Texte gauche --}}
        <div class="amv-apropos-text">
            <span class="amv-apropos-eyebrow"><i class="fas fa-info-circle"></i> À Propos</span>
            <h2 class="amv-apropos-title">Resto Graffiti<br><span style="color:#f26522;">Montréal</span></h2>
            <p class="amv-apropos-desc">Depuis 1998, le Resto Graffiti est une institution gastronomique montréalaise. Niché au cœur du Plateau-Mont-Royal, notre cuisine italienne contemporaine célèbre les meilleurs produits du terroir québécois et de la Méditerranée. Chaque plat est une invitation au voyage, chaque accord mets &amp; vins une révélation.</p>
            <div class="amv-apropos-infos">
                <div class="amv-apropos-info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>123 rue Saint-Denis, Montréal, QC H2X 3K4</span>
                </div>
                <div class="amv-apropos-info-item">
                    <i class="fas fa-phone"></i>
                    <span>(514) 555-0194</span>
                </div>
                <div class="amv-apropos-info-item">
                    <i class="fas fa-clock"></i>
                    <span>Mar – Ven : 11h30 – 22h00</span>
                </div>
                <div class="amv-apropos-info-item">
                    <i class="fas fa-clock"></i>
                    <span>Sam – Dim : 10h30 – 23h00</span>
                </div>
                <div class="amv-apropos-info-item">
                    <i class="fas fa-envelope"></i>
                    <span>info@restograffiti.ca</span>
                </div>
            </div>
            <button class="amv-apropos-cta" onclick="openGoExpResaModal('table')">
                <i class="fas fa-calendar-check"></i>
                Réserver une Table
            </button>
        </div>

        {{-- Carousel droite --}}
        <div class="amv-apropos-media">
            <div class="amv-apropos-carousel" id="apropos-carousel">
                <div class="amv-apropos-carousel-track" id="apropos-carousel-track">
                    @foreach($aproposImgs as $img)
                    <div class="amv-apropos-carousel-slide">
                        <img src="{{ $img }}" alt="Resto Graffiti" loading="lazy">
                    </div>
                    @endforeach
                </div>
                <button class="amv-apropos-carousel-btn prev" onclick="aproposNav(-1)" aria-label="Précédent">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="amv-apropos-carousel-btn next" onclick="aproposNav(1)" aria-label="Suivant">
                    <i class="fas fa-chevron-right"></i>
                </button>
                <div class="amv-apropos-carousel-dots" id="apropos-dots"></div>
            </div>
        </div>

    </div>
</div>

{{-- ---- Sections alternantes ---- --}}
<div class="amv-page-content-wrap" id="amv-menu-section">
    {{-- Barre de filtre catégories --}}
    <div class="amv-menu-filter-bar">
        <nav class="amv-menu-filter-nav" aria-label="Filtrer par catégorie">
            @foreach($menuSections as $s)
            <a href="#amv-section-{{ $s['id'] }}" class="amv-nav-pill" style="--pill-color: {{ $s['color'] }}">
                <i class="fas {{ $s['icon'] }}"></i>
                {{ $s['title'] }}
            </a>
            @endforeach
        </nav>
    </div>
@foreach($menuSections as $idx => $section)
<section class="amv-page-section {{ $idx % 2 !== 0 ? 'amv-reverse' : '' }}"
         id="amv-section-{{ $section['id'] }}"
         style="--accent: {{ $section['color'] }}">

    {{-- Côté MÉDIA --}}
    <div class="amv-page-section-media">
        <div class="amv-page-carousel" id="apc-{{ $section['id'] }}">
            <div class="amv-page-carousel-track" id="apct-{{ $section['id'] }}">
                @foreach($section['imgs'] as $img)
                <div class="amv-page-carousel-slide">
                    <img src="{{ $img }}" alt="{{ $section['title'] }}" loading="lazy">
                </div>
                @endforeach
            </div>

            @if(count($section['imgs']) > 1)
            <button class="amv-page-carousel-btn prev"
                    onclick="amvPageNav('{{ $section['id'] }}',-1)"
                    aria-label="Précédent">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="amv-page-carousel-btn next"
                    onclick="amvPageNav('{{ $section['id'] }}',1)"
                    aria-label="Suivant">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="amv-page-carousel-dots" id="apcd-{{ $section['id'] }}"></div>
            @endif

            <span class="amv-page-section-badge" style="background:{{ $section['color'] }}">
                <i class="fas {{ $section['icon'] }}"></i>
                {{ $section['category'] }}
            </span>
        </div>
    </div>

    {{-- Côté TEXTE --}}
    <div class="amv-page-section-text">
        <div class="amv-page-section-text-inner">

            <p class="amv-page-section-eyebrow" style="color:{{ $section['color'] }}">
                <i class="fas {{ $section['icon'] }}"></i>
                {{ $section['category'] }}
            </p>
            <h3 class="amv-page-section-title">{{ $section['title'] }}</h3>
            @if($section['subtitle'])
            <p class="amv-page-section-lead">{{ $section['subtitle'] }}</p>
            @endif

            <ul class="amv-page-items-list">
                @foreach(array_slice($section['items'], 0, 4) as $item)
                <li class="amv-page-item">
                    <div class="amv-page-item-top">
                        <span class="amv-page-item-name">{{ $item['name'] }}</span>
                        <span class="amv-page-item-price" style="color:{{ $section['color'] }}">{{ $item['price'] }}</span>
                    </div>
                    @if(!empty($item['desc']))
                    <p class="amv-page-item-desc">{{ $item['desc'] }}</p>
                    @endif
                </li>
                @endforeach
            </ul>

            <button class="amv-page-section-cta"
                    style="background:{{ $section['color'] }}"
                    onclick="openGoExpResaModal('table','{{ addslashes($section['title']) }}')">
                <i class="fas fa-calendar-check"></i>
                Réserver pour ce menu
            </button>

        </div>
    </div>

</section>
@endforeach
</div>{{-- /.amv-page-content-wrap --}}


{{-- ============================================================
     CARTE DES VINS
     ============================================================ --}}
@php
$wineCats = [
    [
        'key'   => 'rouges',
        'label' => 'Vins Rouges',
        'icon'  => 'fa-wine-glass',
        'color' => '#8b1a1a',
        'wines' => [
            ['name'=>'Château Graffiti — Bordeaux',     'region'=>'Bordeaux, France',   'desc'=>'Notes de fruits rouges, cassis et boisé élégant. Accord parfait avec nos viandes.',    'price'=>'48 $ / btl', 'img'=>'https://images.unsplash.com/photo-1553361371-9b22f78e8b1d?w=500&h=200&fit=crop'],
            ['name'=>'Barolo Classico DOCG',             'region'=>'Piémont, Italie',    'desc'=>'Structure tannique prononcée, cerise noire, violette et épices douces.',                'price'=>'65 $ / btl', 'img'=>'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=500&h=200&fit=crop'],
            ['name'=>'Côtes du Rhône Réserve',          'region'=>'Rhône, France',      'desc'=>'Assemblage Grenache-Syrah, notes épicées et fruitées, parfait avec nos pâtes.',        'price'=>'38 $ / btl', 'img'=>'https://images.unsplash.com/photo-1569919659476-f0852f6834b7?w=500&h=200&fit=crop'],
        ],
    ],
    [
        'key'   => 'blancs',
        'label' => 'Vins Blancs',
        'icon'  => 'fa-wine-bottle',
        'color' => '#b8a830',
        'wines' => [
            ['name'=>'Pouilly-Fumé — La Doucette',      'region'=>'Loire, France',      'desc'=>'Sauvignon Blanc minéral, notes d\'agrumes et de silex, parfait avec nos poissons.',  'price'=>'52 $ / btl', 'img'=>'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=200&fit=crop'],
            ['name'=>'Pinot Grigio di Venezia DOC',     'region'=>'Vénétie, Italie',    'desc'=>'Frais et léger, arômes de poire et de fleurs blanches. Idéal avec nos fruits de mer.','price'=>'39 $ / btl', 'img'=>'https://images.unsplash.com/photo-1566995541428-f2246c17cda1?w=500&h=200&fit=crop'],
            ['name'=>'Chablis Premier Cru',             'region'=>'Bourgogne, France',  'desc'=>'Chardonnay d\'exception, minéralité et salinité, parfait avec notre saumon.',         'price'=>'61 $ / btl', 'img'=>'https://images.unsplash.com/photo-1474722883778-792e7990302f?w=500&h=200&fit=crop'],
        ],
    ],
    [
        'key'   => 'roses',
        'label' => 'Rosés',
        'icon'  => 'fa-heart',
        'color' => '#d4607a',
        'wines' => [
            ['name'=>'Provence Rosé — Sélection',       'region'=>'Provence, France',   'desc'=>'Grenache et Cinsault, fruits rouges délicats, fraîcheur et légèreté.',               'price'=>'42 $ / btl', 'img'=>'https://images.unsplash.com/photo-1584916201218-f4242ceb4809?w=500&h=200&fit=crop'],
            ['name'=>'Bandol Rosé Domaine de la Tour',  'region'=>'Provence, France',   'desc'=>'Mourvèdre dominant, structure et élégance, bouche persistante et minérale.',          'price'=>'54 $ / btl', 'img'=>'https://images.unsplash.com/photo-1592483648228-b35146a4330c?w=500&h=200&fit=crop'],
        ],
    ],
    [
        'key'   => 'bulles',
        'label' => 'Bulles & Champagnes',
        'icon'  => 'fa-star',
        'color' => '#c9a84c',
        'wines' => [
            ['name'=>'Champagne Brut Nature NV',        'region'=>'Champagne, France',  'desc'=>'Élégance et finesse absolue, bulles persistantes, fraîcheur et vivacité.',            'price'=>'95 $ / btl', 'img'=>'https://images.unsplash.com/photo-1548247416-ec66f4900b2e?w=500&h=200&fit=crop'],
            ['name'=>'Prosecco Superiore DOC',          'region'=>'Vénétie, Italie',    'desc'=>'Léger et fruité, notes de pomme verte et de fleurs, parfait en apéritif.',            'price'=>'44 $ / btl', 'img'=>'https://images.unsplash.com/photo-1574200397786-3e20e4a4b0b1?w=500&h=200&fit=crop'],
        ],
    ],
    [
        'key'   => 'verre',
        'label' => 'Au Verre',
        'icon'  => 'fa-circle',
        'color' => '#3a7dc9',
        'wines' => [
            ['name'=>'Rouge du moment — Sélection chef', 'region'=>'Variable',          'desc'=>'Notre sommelier sélectionne chaque semaine un vin rouge d\'exception pour vous.',     'price'=>'12 $ / verre', 'img'=>'https://images.unsplash.com/photo-1553361371-9b22f78e8b1d?w=500&h=200&fit=crop'],
            ['name'=>'Blanc du moment — Sélection chef', 'region'=>'Variable',          'desc'=>'Notre blanc de la semaine, choisi pour sublimer nos plats du jour.',                  'price'=>'11 $ / verre', 'img'=>'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=200&fit=crop'],
            ['name'=>'Bulles du moment',                 'region'=>'Variable',          'desc'=>'Un vin effervescent changeant au fil des semaines pour célébrer chaque instant.',     'price'=>'14 $ / verre', 'img'=>'https://images.unsplash.com/photo-1548247416-ec66f4900b2e?w=500&h=200&fit=crop'],
        ],
    ],
];
@endphp

<div class="amv-wine-carte-wrap" id="menu-accord-section">
    <div class="amv-wine-carte-header">
        <div class="amv-wine-carte-eyebrow"><i class="fas fa-wine-glass"></i> Sélection du Sommelier</div>
        <h2 class="amv-wine-carte-title">Carte des Vins</h2>
        <p class="amv-wine-carte-lead">Une sélection rigoureuse de vins du monde entier pour sublimer chaque plat de notre carte.</p>
    </div>
    <div class="amv-wine-cats-tabs" id="amvWineTabs">
        @foreach($wineCats as $i => $cat)
        <button class="amv-wine-cat-btn {{ $i === 0 ? 'active' : '' }}"
                data-wcat="{{ $cat['key'] }}"
                type="button"
                style="{{ $i === 0 ? 'background:linear-gradient(135deg,#0a1628,#1a2942);color:#fff;border-color:#0a1628' : '' }}">
            <i class="fas {{ $cat['icon'] }}"></i>
            {{ $cat['label'] }}
        </button>
        @endforeach
    </div>
    <div class="amv-wine-cat-lists">
        @foreach($wineCats as $cat)
        <div class="amv-wine-cat-list {{ $loop->first ? 'visible' : '' }}" data-wlist="{{ $cat['key'] }}">
            @foreach($cat['wines'] as $wine)
            <div class="amv-wine-card-v2" style="--wcolor: {{ $cat['color'] }}">
                @if(!empty($wine['img']))
                <div class="amv-wine-card-v2-img">
                    <img src="{{ $wine['img'] }}" alt="{{ $wine['name'] }}" loading="lazy">
                    <span class="amv-wine-card-v2-price-badge" style="background:{{ $cat['color'] }}">{{ $wine['price'] }}</span>
                </div>
                @endif
                <div class="amv-wine-card-v2-body">
                    <span class="amv-wine-card-v2-name">{{ $wine['name'] }}</span>
                    <div class="amv-wine-card-v2-region"><i class="fas fa-map-marker-alt"></i> {{ $wine['region'] }}</div>
                    <p class="amv-wine-card-v2-desc">{{ $wine['desc'] }}</p>
                    <button class="amv-wine-card-v2-btn"
                            onclick="openGoExpResaModal('vin','{{ addslashes($wine['name']) }}')">
                        <i class="fas fa-wine-glass"></i>
                        Réserver ce vin
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>

{{-- ---- Carousel JS ---- --}}
<script>
/* ---- Sélecteur vidéo héro ---- */
function amvSwitchVideo(videoId, btn) {
    var iframe = document.getElementById('amv-hero-iframe');
    if (iframe) {
        iframe.src = 'https://www.youtube.com/embed/' + videoId + '?rel=0&modestbranding=1&color=white&autoplay=1';
    }
    document.querySelectorAll('.amv-hero-vtab').forEach(function (b) { b.classList.remove('active'); });
    if (btn) btn.classList.add('active');
}

var _amvP = {};
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.amv-page-carousel[id^="apc-"]').forEach(function (el) {
        var id     = el.id.replace('apc-', '');
        var slides = el.querySelectorAll('.amv-page-carousel-slide');
        var total  = slides.length;
        _amvP[id]  = { cur: 0, total: total };

        var dotsEl = document.getElementById('apcd-' + id);
        if (dotsEl) {
            for (var i = 0; i < total; i++) {
                (function (idx) {
                    var d = document.createElement('button');
                    d.className = 'amv-page-cdot' + (idx === 0 ? ' active' : '');
                    d.setAttribute('aria-label', 'Image ' + (idx + 1));
                    d.onclick = function () { amvPageGo(id, idx); };
                    dotsEl.appendChild(d);
                })(i);
            }
        }
        amvPageGo(id, 0);
        setInterval(function () { amvPageNav(id, 1); }, 5000);
    });
});

function amvPageNav(id, dir) {
    var c = _amvP[id]; if (!c) return;
    amvPageGo(id, (c.cur + dir + c.total) % c.total);
}

function amvPageGo(id, idx) {
    var c = _amvP[id]; if (!c) return;
    c.cur = idx;
    var track = document.getElementById('apct-' + id);
    if (track) track.style.transform = 'translateX(-' + (idx * 100) + '%)';
    var slides = document.querySelectorAll('#apc-' + id + ' .amv-page-carousel-slide');
    slides.forEach(function (s, i) { s.classList.toggle('is-active', i === idx); });
    var dots = document.querySelectorAll('#apcd-' + id + ' .amv-page-cdot');
    dots.forEach(function (d, i) { d.classList.toggle('active', i === idx); });
}

/* ---- Tabs Carte des Vins ---- */
document.addEventListener('DOMContentLoaded', function () {
    var tabBtns = document.querySelectorAll('.amv-wine-cat-btn');
    tabBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var key = btn.getAttribute('data-wcat');
            tabBtns.forEach(function (b) {
                b.classList.remove('active');
                b.style.cssText = '';
            });
            btn.classList.add('active');
            btn.style.cssText = 'background:linear-gradient(135deg,#0a1628,#1a2942);color:#fff;border-color:#0a1628';
            document.querySelectorAll('.amv-wine-cat-list').forEach(function (l) {
                l.classList.toggle('visible', l.getAttribute('data-wlist') === key);
            });
        });
    });
});

/* ---- Carousel À propos ---- */
var _apropos = { cur: 0, total: 0 };
document.addEventListener('DOMContentLoaded', function () {
    var slides = document.querySelectorAll('#apropos-carousel .amv-apropos-carousel-slide');
    _apropos.total = slides.length;
    var dotsEl = document.getElementById('apropos-dots');
    if (dotsEl) {
        for (var i = 0; i < _apropos.total; i++) {
            (function (idx) {
                var d = document.createElement('button');
                d.className = 'amv-page-cdot' + (idx === 0 ? ' active' : '');
                d.setAttribute('aria-label', 'Photo ' + (idx + 1));
                d.onclick = function () { aproposGo(idx); };
                dotsEl.appendChild(d);
            })(i);
        }
    }
    aproposGo(0);
    setInterval(function () { aproposNav(1); }, 5500);
});

function aproposNav(dir) {
    aproposGo((_apropos.cur + dir + _apropos.total) % _apropos.total);
}

function aproposGo(idx) {
    _apropos.cur = idx;
    var track = document.getElementById('apropos-carousel-track');
    if (track) track.style.transform = 'translateX(-' + (idx * 100) + '%)';
    var slides = document.querySelectorAll('#apropos-carousel .amv-apropos-carousel-slide');
    slides.forEach(function (s, i) { s.classList.toggle('is-active', i === idx); });
    var dots = document.querySelectorAll('#apropos-dots .amv-page-cdot');
    dots.forEach(function (d, i) { d.classList.toggle('active', i === idx); });
}
</script>
@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
