@php(ob_start());@endphp

{{-- ============================================================
     Products Vedette Component — Boutique GoExploria
     Même layout d'entête standard que EventsVedette / RestaurantHeader
     ============================================================ --}}
@php
    // Données démo — à remplacer par la source réelle quand dispo
    $productsCategories = [
        'vetements'    => ['label' => 'Vêtements',   'icon' => 'fa-shirt'],
        'chaussures'   => ['label' => 'Chaussures',  'icon' => 'fa-shoe-prints'],
        'accessoires'  => ['label' => 'Accessoires', 'icon' => 'fa-hat-cowboy'],
        'equipement'   => ['label' => 'Équipement',  'icon' => 'fa-campground'],
        'souvenirs'    => ['label' => 'Souvenirs',   'icon' => 'fa-gift'],
    ];

    $products = [
        // --- VÊTEMENTS ---
        ['cat' => 'vetements',   'img' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600&h=600&fit=crop', 'title' => 'Parka Grand Nord Explorer',      'brand' => 'GoExploria',   'price' => 249.00, 'old' => 329.00, 'badge' => 'promo',    'rating' => 5],
        ['cat' => 'vetements',   'img' => 'https://images.unsplash.com/photo-1556906781-9a412961c28c?w=600&h=600&fit=crop', 'title' => "T-shirt Érable Québec",         'brand' => 'Boréal',       'price' => 34.99,  'old' => null,   'badge' => 'new',      'rating' => 4],
        ['cat' => 'vetements',   'img' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=600&h=600&fit=crop', 'title' => "Chandail Laine Mérinos",         'brand' => 'Laurentides',  'price' => 119.00, 'old' => 149.00, 'badge' => 'promo',    'rating' => 5],
        ['cat' => 'vetements',   'img' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=600&h=600&fit=crop', 'title' => 'Coupe-vent Saint-Laurent',        'brand' => 'GoExploria',   'price' => 89.00,  'old' => null,   'badge' => 'trending', 'rating' => 4],
        ['cat' => 'vetements',   'img' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=600&h=600&fit=crop', 'title' => 'Tuque Bonhomme Classique',        'brand' => 'Carnaval',     'price' => 24.99,  'old' => null,   'badge' => null,       'rating' => 5],
        ['cat' => 'vetements',   'img' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=600&h=600&fit=crop', 'title' => 'Jeans Trappeur Slim',              'brand' => 'NordFit',      'price' => 79.00,  'old' => 99.00,  'badge' => 'promo',    'rating' => 4],

        // --- CHAUSSURES ---
        ['cat' => 'chaussures',  'img' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&h=600&fit=crop', 'title' => 'Bottes Canadiennes Hiver',        'brand' => 'Boréal',       'price' => 199.00, 'old' => 259.00, 'badge' => 'promo',    'rating' => 5],
        ['cat' => 'chaussures',  'img' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=600&h=600&fit=crop', 'title' => 'Raquettes à neige Alpha',        'brand' => 'NordTrek',     'price' => 149.00, 'old' => null,   'badge' => 'new',      'rating' => 5],
        ['cat' => 'chaussures',  'img' => 'https://images.unsplash.com/photo-1520256862855-398228c41684?w=600&h=600&fit=crop', 'title' => 'Baskets Randonnée Charlevoix',   'brand' => 'GoExploria',   'price' => 129.00, 'old' => null,   'badge' => 'trending', 'rating' => 4],
        ['cat' => 'chaussures',  'img' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=600&h=600&fit=crop', 'title' => "Souliers d'été Québec",           'brand' => 'Urbain QC',    'price' => 69.00,  'old' => 89.00,  'badge' => 'promo',    'rating' => 4],
        ['cat' => 'chaussures',  'img' => 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?w=600&h=600&fit=crop', 'title' => 'Mocassins Cuir Autochtone',       'brand' => 'Artisan QC',   'price' => 159.00, 'old' => null,   'badge' => 'hot',      'rating' => 5],
        ['cat' => 'chaussures',  'img' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=600&h=600&fit=crop', 'title' => 'Patins Lame Pro Glace',           'brand' => 'NordFit',      'price' => 219.00, 'old' => null,   'badge' => null,       'rating' => 4],

        // --- ACCESSOIRES ---
        ['cat' => 'accessoires', 'img' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=600&h=600&fit=crop', 'title' => 'Mitaines Fourrure Doublée',       'brand' => 'Laurentides',  'price' => 59.00,  'old' => 79.00,  'badge' => 'promo',    'rating' => 5],
        ['cat' => 'accessoires', 'img' => 'https://images.unsplash.com/photo-1584464491033-06628f3a6b7b?w=600&h=600&fit=crop', 'title' => 'Foulard Tissé Main',              'brand' => 'Artisan QC',   'price' => 44.00,  'old' => null,   'badge' => 'new',      'rating' => 5],
        ['cat' => 'accessoires', 'img' => 'https://images.unsplash.com/photo-1517254797898-04edd251bfb3?w=600&h=600&fit=crop', 'title' => 'Ceinture Fléchée Québécoise',     'brand' => 'Héritage',     'price' => 69.00,  'old' => null,   'badge' => 'hot',      'rating' => 5],
        ['cat' => 'accessoires', 'img' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600&h=600&fit=crop', 'title' => 'Montre Aventure Pro',              'brand' => 'Boréal',       'price' => 299.00, 'old' => null,   'badge' => null,       'rating' => 5],

        // --- ÉQUIPEMENT ---
        ['cat' => 'equipement',  'img' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=600&h=600&fit=crop', 'title' => 'Tente 4 Saisons Summit',          'brand' => 'NordTrek',     'price' => 449.00, 'old' => 549.00, 'badge' => 'promo',    'rating' => 5],
        ['cat' => 'equipement',  'img' => 'https://images.unsplash.com/photo-1478827387698-1527781a4887?w=600&h=600&fit=crop', 'title' => 'Sac de couchage -20°C',           'brand' => 'Boréal',       'price' => 189.00, 'old' => null,   'badge' => 'new',      'rating' => 5],
        ['cat' => 'equipement',  'img' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=600&h=600&fit=crop', 'title' => 'Kayak Gonflable Fleuve',          'brand' => 'GoExploria',   'price' => 699.00, 'old' => null,   'badge' => 'trending', 'rating' => 4],
        ['cat' => 'equipement',  'img' => 'https://images.unsplash.com/photo-1533240332313-0db49b459ad6?w=600&h=600&fit=crop', 'title' => 'Lampe Frontale Ultra',            'brand' => 'NordFit',      'price' => 49.00,  'old' => 69.00,  'badge' => 'promo',    'rating' => 4],
        ['cat' => 'equipement',  'img' => 'https://images.unsplash.com/photo-1580795478844-5ed694336c90?w=600&h=600&fit=crop', 'title' => 'Réchaud Camping Pro',              'brand' => 'Laurentides',  'price' => 89.00,  'old' => null,   'badge' => null,       'rating' => 5],
       
        // --- SOUVENIRS ---
        ['cat' => 'souvenirs',   'img' => 'https://images.unsplash.com/photo-1606787366850-de6330128bfc?w=600&h=600&fit=crop', 'title' => 'Sirop d\'Érable Pur 500ml',       'brand' => 'Héritage',     'price' => 19.99,  'old' => null,   'badge' => 'hot',      'rating' => 5],
        ['cat' => 'souvenirs',   'img' => 'https://images.unsplash.com/photo-1528825871115-3581a5387919?w=600&h=600&fit=crop', 'title' => 'Mug Montréal Collector',           'brand' => 'GoExploria',   'price' => 14.99,  'old' => null,   'badge' => 'new',      'rating' => 4],
        ['cat' => 'souvenirs',   'img' => 'https://images.unsplash.com/photo-1513885535751-8b9238bd345a?w=600&h=600&fit=crop', 'title' => 'Chandelle Parfumée Sapin',         'brand' => 'Boréal',       'price' => 24.00,  'old' => null,   'badge' => null,       'rating' => 5],
        ['cat' => 'souvenirs',   'img' => 'https://images.unsplash.com/photo-1513542789411-b6a5d4f31634?w=600&h=600&fit=crop', 'title' => 'Affiche Vintage Québec',           'brand' => 'Artisan QC',   'price' => 39.00,  'old' => null,   'badge' => 'trending', 'rating' => 4],
        ['cat' => 'souvenirs',   'img' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&h=600&fit=crop', 'title' => 'Panier Gourmand Terroir',          'brand' => 'Héritage',     'price' => 89.00,  'old' => 119.00, 'badge' => 'promo',    'rating' => 5],
    ];

    $productsSlides = [
        [
            'main' => [
                'src'   => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=900&h=500&fit=crop',
                'video' => 'M-2eAiU09qg',
                'title' => 'Collection Hiver GoExploria',
                'desc'  => 'Parkas, bottes et accessoires pour braver le froid canadien',
                'badge' => 'new',
            ],
            'grid' => [
                ['src' => 'https://images.unsplash.com/photo-1556906781-9a412961c28c?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Vêtements Signature',  'desc' => "T-shirts, chandails et plus",       'badge' => 'trending'],
                ['src' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Bottes & Chaussures',   'desc' => 'Pour tous les terrains du Québec', 'badge' => 'hot'],
                ['src' => 'https://images.unsplash.com/photo-1590736704728-f4e2d8e1fc3a?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Sacs & Accessoires',    'desc' => 'Explorez avec style',               'badge' => 'popular'],
                ['src' => 'https://images.unsplash.com/photo-1606787366850-de6330128bfc?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Produits du Terroir',   'desc' => "Sirop d'érable, gourmandises",     'badge' => 'new'],
            ],
        ],
        [
            'main' => [
                'src'   => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=900&h=500&fit=crop',
                'video' => 'M-2eAiU09qg',
                'title' => 'Équipement Plein Air Premium',
                'desc'  => 'Tentes, kayaks et équipement pour toutes vos aventures',
                'badge' => 'trending',
            ],
            'grid' => [
                ['src' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Tentes & Abris',       'desc' => 'Dormir sous les étoiles du Nord', 'badge' => 'popular'],
                ['src' => 'https://images.unsplash.com/photo-1478827387698-1527781a4887?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Sacs de couchage',      'desc' => 'Confort par tous temps',          'badge' => 'hot'],
                ['src' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Raquettes & Patins',    'desc' => 'Hiver québécois',                  'badge' => 'new'],
                ['src' => 'https://images.unsplash.com/photo-1517254797898-04edd251bfb3?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Artisanat Local',       'desc' => 'Fabriqué au Québec',              'badge' => 'trending'],
            ],
        ],
    ];
@endphp

<section class="products-vedette-v2-section" id="produits-vedette">
    <div class="products-vedette-v2-container">

        {{-- ============================================================
             ENTÊTE STANDARD — même layout que RestaurantHeader
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

                {{-- Centre : titre + sous-titre + espaces --}}
                <div class="resto-header-center">
                    <h1 class="resto-header-title">BOUTIQUE GOEXPLORIA — PRODUITS VEDETTE</h1>
                    <p class="resto-header-subtitle">
                        Vêtements · Chaussures · Accessoires · Équipement · Souvenirs — La sélection officielle GoExploria inspirée du Québec.
                    </p>

                    <div class="resto-header-tabs" role="tablist">
                        <button class="resto-tab-btn active" role="tab" data-espace="all">
                            <i class="fas fa-store"></i> Toute la boutique
                        </button>
                        <button class="resto-tab-btn" role="tab" data-espace="promo">
                            <i class="fas fa-tag"></i> Promotions
                        </button>
                        <button class="resto-tab-btn" role="tab" data-espace="new">
                            <i class="fas fa-star"></i> Nouveautés
                        </button>
                        <button class="resto-tab-btn" role="tab" data-espace="hot">
                            <i class="fas fa-fire"></i> Tendances
                        </button>
                    </div>
                </div>

                {{-- Logo droit : Plan N Go --}}
                <div class="resto-header-logo-right">
                    <a href="#" class="resto-accord-btn" title="Boutique GoExploria">
                        <div class="logo-wrapper">
                            <img src="{{ asset('plan-n-go.png') }}" alt="Boutique GoExploria">
                        </div>
                        <span class="resto-accord-btn-label">Boutique</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-shopping-bag"></i> Acheter
                        </span>
                    </a>
                </div>

            </div>

            {{-- Barre Destinations + Filtres catégories --}}
            <div class="resto-header-destinations-bar">

                <div class="resto-dest-row">
                    <div class="resto-dest-icon-box">
                        <img src="{{ asset('REDI.png') }}" alt="Destinations">
                        <span>Livraison</span>
                    </div>
                    <div class="resto-dest-breadcrumb">
                        <a href="#" class="resto-dest-link active" data-dest="all">Partout au Canada</a>
                        <span class="resto-dest-sep">/</span>
                        <a href="#" class="resto-dest-link" data-dest="quebec">Québec</a>
                        <span class="resto-dest-sep">/</span>
                        <a href="#" class="resto-dest-link" data-dest="montreal">Montréal</a>
                        <span class="resto-dest-sep">/</span>
                        <a href="#" class="resto-dest-link" data-dest="ontario">Ontario</a>
                    </div>
                </div>

                <div class="resto-actions-row">
                    <div class="resto-header-ctas">
                        <div class="products-vedette-v2-filters">
                            <button class="products-vedette-v2-filter-btn active" data-filter="all">
                                <i class="fas fa-th-large"></i> Toutes catégories
                            </button>
                            @foreach($productsCategories as $key => $cat)
                                <button class="products-vedette-v2-filter-btn" data-filter="{{ $key }}">
                                    <i class="fas {{ $cat['icon'] }}"></i> {{ $cat['label'] }}
                                </button>
                            @endforeach
                        </div>
                        <a href="#" class="resto-cta-btn secondary">
                            En savoir <span class="cta-plus">+</span>
                        </a>
                    </div>
                </div>

            </div>

            <div class="resto-header-shimmer"></div>
        </div>

        {{-- ============================================================
             CAROUSEL PRODUITS — une seule ligne, filtrée par catégorie
             ============================================================ --}}
        <div class="vedette-carousel-outer products-vedette-v2-carousel">
            <button class="vedette-carousel-btn vedette-carousel-prev" id="productsCarouselPrev" aria-label="Précédent"><i class="fas fa-chevron-left"></i></button>
            <div class="products-vedette-v2-scroll-wrapper">
                <div class="products-vedette-v2-scroll-container" id="productsVedetteGrid">
                    @foreach($products as $p)
                    <article class="products-vedette-v2-card"
                             data-category="{{ $p['cat'] }}"
                             data-badge="{{ $p['badge'] ?? '' }}">
                        <div class="products-vedette-v2-card-image">
                            <img src="{{ $p['img'] }}" alt="{{ $p['title'] }}" loading="lazy">

                            @if(!empty($p['badge']))
                                <span class="products-vedette-v2-badge products-vedette-v2-badge--{{ $p['badge'] }}">
                                    @switch($p['badge'])
                                        @case('promo')    <i class="fas fa-tag"></i> PROMO @break
                                        @case('new')      <i class="fas fa-star"></i> NOUVEAU @break
                                        @case('hot')      <i class="fas fa-fire"></i> HOT @break
                                        @case('trending') <i class="fas fa-bolt"></i> TENDANCE @break
                                    @endswitch
                                </span>
                            @endif

                            <button class="products-vedette-v2-fav" aria-label="Ajouter aux favoris">
                                <i class="far fa-heart"></i>
                            </button>

                            <div class="products-vedette-v2-quick">
                                <button class="products-vedette-v2-quick-btn" type="button">
                                    <i class="fas fa-eye"></i> Aperçu rapide
                                </button>
                            </div>
                        </div>

                        <div class="products-vedette-v2-card-content">
                            <div class="products-vedette-v2-card-brand">{{ $p['brand'] }}</div>
                            <h3 class="products-vedette-v2-card-title">{{ $p['title'] }}</h3>

                            <div class="products-vedette-v2-card-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $p['rating'] ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                                <span class="products-vedette-v2-card-reviews">({{ rand(12, 348) }})</span>
                            </div>

                            <div class="products-vedette-v2-card-footer">
                                <div class="products-vedette-v2-price-block">
                                    @if(!empty($p['old']))
                                        <span class="products-vedette-v2-price-old">{{ number_format($p['old'], 2, ',', ' ') }} $</span>
                                    @endif
                                    <span class="products-vedette-v2-price">{{ number_format($p['price'], 2, ',', ' ') }} $</span>
                                </div>
                                <button class="products-vedette-v2-add-btn" type="button" aria-label="Ajouter au panier">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            <button class="vedette-carousel-btn vedette-carousel-next" id="productsCarouselNext" aria-label="Suivant"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="vedette-carousel-progress"><div class="vedette-carousel-bar" id="productsCarouselBar"></div></div>

        {{-- ============================================================
             SLIDESHOW MULTI-CARTE (même composant que les vedettes)
             ============================================================ --}}
        @include('home-v2.components.MediaSlideshow', [
            'slideshowId' => 'productsMedia',
            'slides'      => $productsSlides,
        ])

    </div>
</section>

<script>
(function () {
    var wrapper = document.getElementById('productsVedetteGrid');
    var section = wrapper ? wrapper.closest('section') : null;
    if (!wrapper || !section) return;

    var GAP   = 20;
    var PAUSE = 3500;
    var ANIM  = 480;
    var timer = null;
    var busy  = false;

    function vis() {
        return Array.from(wrapper.children).filter(function (c) { return c.style.display !== 'none'; });
    }

    function shiftLeft() {
        var vc = vis();
        if (busy || vc.length < 2) return;
        busy = true;
        var shift = vc[0].offsetWidth + GAP;
        wrapper.style.transition = 'transform ' + ANIM + 'ms cubic-bezier(0.4,0,0.2,1)';
        wrapper.style.transform  = 'translateX(-' + shift + 'px)';
        setTimeout(function () {
            wrapper.style.transition = 'none';
            wrapper.style.transform  = 'translateX(0)';
            wrapper.appendChild(vc[0]);
            busy = false;
            resetBar();
        }, ANIM + 20);
    }

    function shiftRight() {
        var vc = vis();
        if (busy || vc.length < 2) return;
        busy = true;
        var last  = vc[vc.length - 1];
        var shift = last.offsetWidth + GAP;
        wrapper.style.transition = 'none';
        wrapper.insertBefore(last, wrapper.firstChild);
        wrapper.style.transform  = 'translateX(-' + shift + 'px)';
        wrapper.offsetWidth;
        wrapper.style.transition = 'transform ' + ANIM + 'ms cubic-bezier(0.4,0,0.2,1)';
        wrapper.style.transform  = 'translateX(0)';
        setTimeout(function () { busy = false; resetBar(); }, ANIM + 20);
    }

    function startAuto() { timer = setInterval(shiftLeft, PAUSE); }
    function stopAuto()  { clearInterval(timer); }

    var bar = document.getElementById('productsCarouselBar');
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

    var prev = document.getElementById('productsCarouselPrev');
    var next = document.getElementById('productsCarouselNext');
    if (prev) prev.addEventListener('click', function () { stopAuto(); shiftRight(); startAuto(); });
    if (next) next.addEventListener('click', function () { stopAuto(); shiftLeft();  startAuto(); });

    // Filtres par catégorie (barre basse)
    section.querySelectorAll('.products-vedette-v2-filter-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            section.querySelectorAll('.products-vedette-v2-filter-btn').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            var f = btn.getAttribute('data-filter');
            Array.from(wrapper.children).forEach(function (c) {
                var cat = c.getAttribute('data-category') || '';
                c.style.display = (f === 'all' || cat === f) ? '' : 'none';
            });
            wrapper.style.transition = 'none';
            wrapper.style.transform  = 'translateX(0)';
            busy = false;
            resetBar();
            stopAuto(); startAuto();
        });
    });

    // Tabs "espaces" du header (Promotions / Nouveautés / Tendances) → filtre par badge
    section.querySelectorAll('.resto-tab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            section.querySelectorAll('.resto-tab-btn').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            var esp = btn.getAttribute('data-espace');
            Array.from(wrapper.children).forEach(function (c) {
                if (esp === 'all') {
                    c.style.display = '';
                } else if (esp === 'hot') {
                    var b = c.getAttribute('data-badge');
                    c.style.display = (b === 'hot' || b === 'trending') ? '' : 'none';
                } else {
                    c.style.display = (c.getAttribute('data-badge') === esp) ? '' : 'none';
                }
            });
            wrapper.style.transition = 'none';
            wrapper.style.transform  = 'translateX(0)';
            busy = false;
            resetBar();
            stopAuto(); startAuto();
        });
    });

    // Favoris toggle
    wrapper.querySelectorAll('.products-vedette-v2-fav').forEach(function (b) {
        b.addEventListener('click', function (e) {
            e.stopPropagation();
            var icon = b.querySelector('i');
            if (!icon) return;
            if (icon.classList.contains('far')) {
                icon.classList.remove('far'); icon.classList.add('fas');
                b.classList.add('is-active');
            } else {
                icon.classList.remove('fas'); icon.classList.add('far');
                b.classList.remove('is-active');
            }
        });
    });
})();
</script>

@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
