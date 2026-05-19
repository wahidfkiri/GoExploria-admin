@php(ob_start());@endphp

{{-- ============================================================
     Chasse et Peche - Meme structure/design que ProductsVedette
     ============================================================ --}}
@php
    $huntFishCategories = [
        'cannes'    => ['label' => 'Cannes & Moulinets', 'icon' => 'fa-fish-fins'],
        'leurres'   => ['label' => 'Leurres & Accessoires', 'icon' => 'fa-water'],
        'vettements'=> ['label' => 'Vetements techniques', 'icon' => 'fa-vest'],
        'chasse'    => ['label' => 'Equipement chasse', 'icon' => 'fa-binoculars'],
        'hiver'     => ['label' => 'Peche blanche', 'icon' => 'fa-snowflake'],
    ];

    $huntFishItems = [
        ['cat' => 'cannes',     'img' => 'https://images.unsplash.com/photo-1473116763249-2faaef81ccda?w=600&h=600&fit=crop', 'title' => 'Canne Shimano Stradic 7\'0" + moulinet 2500',     'brand' => 'Latulippe Quebec',    'price' => 219.00, 'old' => 259.00, 'badge' => 'promo',    'rating' => 5, 'reviews' => 126],
        ['cat' => 'cannes',     'img' => 'https://images.unsplash.com/photo-1513836279014-a89f7a76ae86?w=600&h=600&fit=crop', 'title' => 'Ensemble peche truite Abu Garcia Pro Max',          'brand' => 'Sail Montreal',       'price' => 139.00, 'old' => null,   'badge' => 'new',      'rating' => 4, 'reviews' => 88],
        ['cat' => 'leurres',    'img' => 'https://images.unsplash.com/photo-1473445361085-b9a07f55608b?w=600&h=600&fit=crop', 'title' => 'Coffret Rapala 12 leurres eau douce',               'brand' => 'Peche Expert',         'price' => 74.00,  'old' => null,   'badge' => 'trending', 'rating' => 5, 'reviews' => 203],
        ['cat' => 'leurres',    'img' => 'https://images.unsplash.com/photo-1488866022504-f2584929ca5f?w=600&h=600&fit=crop', 'title' => 'Tresse Berkley X9 + fluoro Seaguar (combo)',       'brand' => 'Pro Nature',           'price' => 49.00,  'old' => 59.00,  'badge' => 'promo',    'rating' => 4, 'reviews' => 97],
        ['cat' => 'vettements', 'img' => 'https://images.unsplash.com/photo-1548883354-7622d03aca27?w=600&h=600&fit=crop', 'title' => 'Waders respirants Simms Freestone',                 'brand' => 'Sail Quebec',          'price' => 329.00, 'old' => null,   'badge' => 'hot',      'rating' => 5, 'reviews' => 61],
        ['cat' => 'vettements', 'img' => 'https://images.unsplash.com/photo-1601758124510-52d02ddb7cbd?w=600&h=600&fit=crop', 'title' => 'Veste thermique anti-pluie Helly Hansen',          'brand' => 'Latulippe',            'price' => 189.00, 'old' => 219.00, 'badge' => 'promo',    'rating' => 4, 'reviews' => 73],
        ['cat' => 'chasse',     'img' => 'https://images.unsplash.com/photo-1504851149312-7a075b496cc7?w=600&h=600&fit=crop', 'title' => 'Pack observation chasse (jumelles + trépied)',      'brand' => 'Cabela\'s Canada',     'price' => 249.00, 'old' => null,   'badge' => 'new',      'rating' => 5, 'reviews' => 54],
        ['cat' => 'chasse',     'img' => 'https://images.unsplash.com/photo-1511886929837-354d827aae26?w=600&h=600&fit=crop', 'title' => 'Sac terrain 45L camouflage + housse etanche',      'brand' => 'Pro Nature',           'price' => 119.00, 'old' => null,   'badge' => null,       'rating' => 4, 'reviews' => 65],
        ['cat' => 'hiver',      'img' => 'https://images.unsplash.com/photo-1482784160316-6eb046863ece?w=600&h=600&fit=crop', 'title' => 'Abri peche sur glace 2-3 personnes',               'brand' => 'Aventure Nordik',      'price' => 279.00, 'old' => 319.00, 'badge' => 'promo',    'rating' => 5, 'reviews' => 92],
        ['cat' => 'hiver',      'img' => 'https://images.unsplash.com/photo-1516557070061-c3d1653fa646?w=600&h=600&fit=crop', 'title' => 'Vrillette manuelle 8" + kit peche blanche',        'brand' => 'Peche Blanche QC',     'price' => 159.00, 'old' => null,   'badge' => 'hot',      'rating' => 4, 'reviews' => 81],
    ];

    $huntFishSlides = [
        [
            'main' => [
                'src'   => 'https://images.unsplash.com/photo-1466721591366-2d5fba72006d?w=900&h=500&fit=crop',
                'video' => 'M-2eAiU09qg',
                'title' => 'CHASSE ET PECHE',
                'desc'  => 'Equipements fiables pour sorties nature, peche sportive et aventures en forets',
                'badge' => 'new',
            ],
            'grid' => [
                ['src' => 'https://images.unsplash.com/photo-1513836279014-a89f7a76ae86?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Peche en lac',      'desc' => 'Materiel pour eau douce',         'badge' => 'popular'],
                ['src' => 'https://images.unsplash.com/photo-1473445361085-b9a07f55608b?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Camps de chasse',   'desc' => 'Equipements de terrain',          'badge' => 'hot'],
                ['src' => 'https://images.unsplash.com/photo-1488866022504-f2584929ca5f?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Vetements tech',    'desc' => 'Protection 4 saisons',            'badge' => 'trending'],
                ['src' => 'https://images.unsplash.com/photo-1482784160316-6eb046863ece?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Peche blanche',     'desc' => 'Sorties hivernales au Quebec',    'badge' => 'new'],
            ],
        ],
    ];
@endphp

<section class="products-vedette-v2-section" id="chasse-peche">
    <div class="products-vedette-v2-container">
        <div class="resto-header-block">
            <div class="resto-header-main">
                <div class="resto-header-logo-left">
                    <a href="#" class="resto-accord-btn" title="Chasse et peche">
                        <div class="logo-wrapper">
                            <img src="{{ asset('logo.png') }}" alt="Chasse et peche">
                        </div>
                        <span class="resto-accord-btn-label">GoExploria Outdoor</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-external-link-alt"></i> Explorer
                        </span>
                    </a>
                </div>

                <div class="resto-header-center">
                    <h1 class="resto-header-title">CHASSE ET PÊCHE</h1>
                    <p class="resto-header-subtitle">
                        Cannes, leurres, equipement de chasse et peche blanche pour vos expeditions toute l annee.
                    </p></div>

                <div class="resto-header-logo-right">
                    <a href="#" class="resto-accord-btn" title="Reservation sorties">
                        <div class="logo-wrapper">
                            <img src="{{ asset('plan-n-go.png') }}" alt="Reservation sorties">
                        </div>
                        <span class="resto-accord-btn-label">Sorties nature</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-tree"></i> Voir options
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
                        <div class="products-vedette-v2-filters">
                            <button class="products-vedette-v2-filter-btn active" data-filter="all">
                                <i class="fas fa-th-large"></i> Toutes categories
                            </button>
                            @foreach($huntFishCategories as $key => $cat)
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
            <button class="vedette-carousel-btn vedette-carousel-prev" id="huntFishCarouselPrev" aria-label="Precedent"><i class="fas fa-chevron-left"></i></button>
            <div class="products-vedette-v2-scroll-wrapper">
                <div class="products-vedette-v2-scroll-container" id="huntFishVedetteGrid">
                    @foreach($huntFishItems as $item)
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
            <button class="vedette-carousel-btn vedette-carousel-next" id="huntFishCarouselNext" aria-label="Suivant"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="vedette-carousel-progress"><div class="vedette-carousel-bar" id="huntFishCarouselBar"></div></div>

        @include('home-v2.components.MediaSlideshow', [
            'slideshowId' => 'huntFishMedia',
            'slides'      => $huntFishSlides,
        ])
    </div>
</section>

<script>
(function () {
    var wrapper = document.getElementById('huntFishVedetteGrid');
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

    var bar = document.getElementById('huntFishCarouselBar');
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

    var prev = document.getElementById('huntFishCarouselPrev');
    var next = document.getElementById('huntFishCarouselNext');
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
