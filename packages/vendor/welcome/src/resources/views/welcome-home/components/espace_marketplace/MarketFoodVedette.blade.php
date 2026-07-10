@php(ob_start());@endphp

{{-- ============================================================
     Marches d'alimentation - Meme design que ProductsVedette
     ============================================================ --}}
@php
    $marketFoodCategories = [
        'fromages'   => ['label' => 'Fromages', 'icon' => 'fa-cheese'],
        'boulangerie'=> ['label' => 'Boulangerie', 'icon' => 'fa-bread-slice'],
        'fruits'     => ['label' => 'Fruits & Legumes', 'icon' => 'fa-apple-whole'],
        'terroir'    => ['label' => 'Produits du terroir', 'icon' => 'fa-jar'],
        'seafood'    => ['label' => 'Poissons & Fruits de mer', 'icon' => 'fa-fish'],
    ];

    $marketFoods = [
        ['cat' => 'fromages',    'img' => 'https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?w=600&h=600&fit=crop', 'title' => 'Selection de fromages fermiers du Quebec', 'brand' => 'Marche Atwater', 'price' => 22.90, 'old' => null,  'badge' => 'new',      'rating' => 5, 'reviews' => 143],
        ['cat' => 'fromages',    'img' => 'https://images.unsplash.com/photo-1452195100486-9cc805987862?w=600&h=600&fit=crop', 'title' => 'Plateau Brie, Cheddar vieilli et Bleu',      'brand' => 'Jean-Talon',     'price' => 28.50, 'old' => 33.00, 'badge' => 'promo',    'rating' => 5, 'reviews' => 89],
        ['cat' => 'boulangerie', 'img' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&h=600&fit=crop', 'title' => 'Pain de campagne au levain naturel',        'brand' => 'Boulangerie du Marche', 'price' => 7.90, 'old' => null, 'badge' => 'hot', 'rating' => 5, 'reviews' => 211],
        ['cat' => 'boulangerie', 'img' => 'https://images.unsplash.com/photo-1506084868230-bb9d95c24759?w=600&h=600&fit=crop', 'title' => 'Croissants pur beurre artisanaux (x6)',      'brand' => 'Maison Boulange','price' => 12.00, 'old' => null,  'badge' => 'trending', 'rating' => 4, 'reviews' => 167],
        ['cat' => 'fruits',      'img' => 'https://images.unsplash.com/photo-1619566636858-adf3ef46400b?w=600&h=600&fit=crop', 'title' => 'Panier de saison pommes, poires et raisins', 'brand' => 'Fermes locales', 'price' => 18.50, 'old' => null,  'badge' => null,       'rating' => 5, 'reviews' => 75],
        ['cat' => 'fruits',      'img' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&h=600&fit=crop', 'title' => 'Legumes bio du jour (panier familial)',      'brand' => 'Marche Bio',     'price' => 24.00, 'old' => 29.00, 'badge' => 'promo',    'rating' => 4, 'reviews' => 96],
        ['cat' => 'terroir',     'img' => 'https://images.unsplash.com/photo-1514996937319-344454492b37?w=600&h=600&fit=crop', 'title' => "Sirop d'erable pur et caramel maison",       'brand' => 'Terroir QC',     'price' => 16.90, 'old' => null,  'badge' => 'new',      'rating' => 5, 'reviews' => 188],
        ['cat' => 'terroir',     'img' => 'https://images.unsplash.com/photo-1574484284002-952d92456975?w=600&h=600&fit=crop', 'title' => 'Confitures artisanales petits fruits',        'brand' => 'Saveurs Boreales','price' => 9.50, 'old' => null,  'badge' => null,       'rating' => 4, 'reviews' => 120],
        ['cat' => 'seafood',     'img' => 'https://images.unsplash.com/photo-1559737558-2f5a35f4523b?w=600&h=600&fit=crop', 'title' => 'Filets de saumon atlantique frais',           'brand' => 'Poissonnerie Port','price' => 31.00, 'old' => 36.00, 'badge' => 'promo', 'rating' => 5, 'reviews' => 62],
        ['cat' => 'seafood',     'img' => 'https://images.unsplash.com/photo-1615141982883-c7ad0e69fd62?w=600&h=600&fit=crop', 'title' => 'Mix fruits de mer pour paella maison',       'brand' => 'Ocean Marche',   'price' => 27.40, 'old' => null,  'badge' => 'trending', 'rating' => 4, 'reviews' => 58],
    ];

    $marketFoodSlides = [
        [
            'main' => [
                'src'   => 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?w=900&h=500&fit=crop',
                'video' => 'M-2eAiU09qg',
                'title' => 'MARCHÉS D’ALIMENTATION',
                'desc'  => 'Produits frais, artisans locaux et saveurs authentiques du Quebec',
                'badge' => 'new',
            ],
            'grid' => [
                ['src' => 'https://images.unsplash.com/photo-1506617420156-8e4536971650?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Etals de fruits',       'desc' => 'Fraicheur du jour',                 'badge' => 'hot'],
                ['src' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Boulangeries',          'desc' => 'Pains et viennoiseries artisanales', 'badge' => 'popular'],
                ['src' => 'https://images.unsplash.com/photo-1452195100486-9cc805987862?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Fromageries',          'desc' => 'Selection du terroir',               'badge' => 'trending'],
                ['src' => 'https://images.unsplash.com/photo-1514996937319-344454492b37?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Epiceries fines',       'desc' => 'Confitures et produits locaux',      'badge' => 'new'],
            ],
        ],
    ];
@endphp

<section class="products-vedette-v2-section" id="marches-alimentations">
    <div class="products-vedette-v2-container">
        <div class="resto-header-block">
            <div class="resto-header-main">
                <div class="resto-header-logo-left">
                    <a href="#" class="resto-accord-btn" title="Marche local">
                        <div class="logo-wrapper">
                            <img loading="lazy" decoding="async" src="{{ asset('logo.png') }}" alt="Marche local">
                        </div>
                        <span class="resto-accord-btn-label">Marche local</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-external-link-alt"></i> Decouvrir
                        </span>
                    </a>
                </div>

                <div class="resto-header-center">
                    <h1 class="resto-header-title">MARCHÉS D’ALIMENTATION</h1>
                    <p class="resto-header-subtitle">
                        Fromageries, boulangeries, fruits & legumes, produits du terroir et poissons frais dans les meilleurs marches.
                    </p></div>

                <div class="resto-header-logo-right">
                    <a href="#" class="resto-accord-btn" title="Marches alimentaires">
                        <div class="logo-wrapper">
                            <img loading="lazy" decoding="async" src="{{ asset('plan-n-go.png') }}" alt="Marches alimentaires">
                        </div>
                        <span class="resto-accord-btn-label">Alimentation</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-basket-shopping"></i> Voir tout
                        </span>
                    </a>
                </div>
            </div>

            <div class="resto-header-destinations-bar">
                <div class="resto-dest-row">
    <div class="resto-dest-icon-box">
        <img loading="lazy" decoding="async" src="{{ asset('REDI.png') }}" alt="Destinations">
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
                        <div class="products-vedette-v2-filters">
                            <button class="products-vedette-v2-filter-btn active" data-filter="all">
                                <i class="fas fa-th-large"></i> Toutes categories
                            </button>
                            @foreach($marketFoodCategories as $key => $cat)
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

        <div class="vedette-carousel-outer products-vedette-v2-carousel">
            <button class="vedette-carousel-btn vedette-carousel-prev" id="marketFoodCarouselPrev" aria-label="Precedent"><i class="fas fa-chevron-left"></i></button>
            <div class="products-vedette-v2-scroll-wrapper">
                <div class="products-vedette-v2-scroll-container" id="marketFoodVedetteGrid">
                    @foreach($marketFoods as $item)
                    <article class="products-vedette-v2-card"
                             data-category="{{ $item['cat'] }}"
                             data-badge="{{ $item['badge'] ?? '' }}">
                        <div class="products-vedette-v2-card-image">
                            <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}" loading="lazy">

                            @if(!empty($item['badge']))
                                <span class="products-vedette-v2-badge products-vedette-v2-badge--{{ $item['badge'] }}">
                                    @switch($item['badge'])
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
                                    <i class="fas fa-eye"></i> Apercu rapide
                                </button>
                            </div>
                        </div>

                        <div class="products-vedette-v2-card-content">
                            <div class="products-vedette-v2-card-brand">{{ $item['brand'] }}</div>
                            <h3 class="products-vedette-v2-card-title">{{ $item['title'] }}</h3>

                            <div class="products-vedette-v2-card-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $item['rating'] ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                                <span class="products-vedette-v2-card-reviews">({{ $item['reviews'] }})</span>
                            </div>

                            <div class="products-vedette-v2-card-footer">
                                <div class="products-vedette-v2-price-block">
                                    @if(!empty($item['old']))
                                        <span class="products-vedette-v2-price-old">{{ number_format($item['old'], 2, ',', ' ') }} $</span>
                                    @endif
                                    <span class="products-vedette-v2-price">{{ number_format($item['price'], 2, ',', ' ') }} $</span>
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
            <button class="vedette-carousel-btn vedette-carousel-next" id="marketFoodCarouselNext" aria-label="Suivant"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="vedette-carousel-progress"><div class="vedette-carousel-bar" id="marketFoodCarouselBar"></div></div>

        @include('welcome-home.components.MediaSlideshow', [
            'slideshowId' => 'marketFoodMedia',
            'slides'      => $marketFoodSlides,
        ])
    </div>
</section>

<script>
(function () {
    var wrapper = document.getElementById('marketFoodVedetteGrid');
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
        if (!vc[0]) { busy = false; return; }
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
        if (!last) { busy = false; return; }
        var shift = last.offsetWidth + GAP;
        wrapper.style.transition = 'none';
        wrapper.insertBefore(last, wrapper.firstChild);
        wrapper.style.transform  = 'translateX(-' + shift + 'px)';
        if (wrapper) wrapper.offsetWidth;
        wrapper.style.transition = 'transform ' + ANIM + 'ms cubic-bezier(0.4,0,0.2,1)';
        wrapper.style.transform  = 'translateX(0)';
        setTimeout(function () { busy = false; resetBar(); }, ANIM + 20);
    }

    function startAuto() { timer = setInterval(shiftLeft, PAUSE); }
    function stopAuto()  { clearInterval(timer); }

    var bar = document.getElementById('marketFoodCarouselBar');
    function resetBar() {
        if (!bar) return;
        bar.style.transition = 'none';
        bar.style.width = '0%';
        if (bar) bar.offsetWidth;
        bar.style.transition = 'width ' + PAUSE + 'ms linear';
        bar.style.width = '100%';
    }
    resetBar();

    section.addEventListener('mouseenter', stopAuto);
    section.addEventListener('mouseleave', startAuto);
    startAuto();

    var prev = document.getElementById('marketFoodCarouselPrev');
    var next = document.getElementById('marketFoodCarouselNext');
    if (prev) prev.addEventListener('click', function () { stopAuto(); shiftRight(); startAuto(); });
    if (next) next.addEventListener('click', function () { stopAuto(); shiftLeft();  startAuto(); });

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
