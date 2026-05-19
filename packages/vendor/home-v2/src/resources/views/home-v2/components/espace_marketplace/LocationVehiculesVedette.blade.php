@php(ob_start());@endphp

{{-- ============================================================
     Location Auto, Bus, Vehicules Recreatifs 4 Saisons
     Meme design que ProductsVedette
     ============================================================ --}}
@php
    $vehicleCategories = [
        'autos'   => ['label' => 'Autos', 'icon' => 'fa-car-side'],
        'vus'     => ['label' => 'VUS 4x4', 'icon' => 'fa-truck-monster'],
        'bus'     => ['label' => 'Bus & Minibus', 'icon' => 'fa-bus'],
        'vr'      => ['label' => 'VR 4 Saisons', 'icon' => 'fa-caravan'],
        'special' => ['label' => 'Hiver & Nautique', 'icon' => 'fa-snowmobile'],
    ];

    $vehicleOffers = [
        ['cat' => 'autos',   'img' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=600&h=600&fit=crop', 'title' => 'Toyota Corolla 2025 - Economique',               'brand' => 'Hertz Montreal',        'price' => 69.00,  'old' => 79.00,  'badge' => 'promo',    'rating' => 5, 'reviews' => 172],
        ['cat' => 'autos',   'img' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=600&h=600&fit=crop', 'title' => 'Honda Civic Touring - Kilometrage illimite',    'brand' => 'Avis Quebec',           'price' => 74.00,  'old' => null,   'badge' => 'new',      'rating' => 4, 'reviews' => 131],
        ['cat' => 'vus',     'img' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?w=600&h=600&fit=crop', 'title' => 'Jeep Grand Cherokee 4x4 - Route et montagne',   'brand' => 'Budget Laurentides',    'price' => 129.00, 'old' => 149.00, 'badge' => 'hot',      'rating' => 5, 'reviews' => 98],
        ['cat' => 'vus',     'img' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=600&h=600&fit=crop', 'title' => 'Ford Explorer AWD - Famille et aventure',       'brand' => 'Enterprise QC',         'price' => 119.00, 'old' => null,   'badge' => 'trending', 'rating' => 4, 'reviews' => 114],
        ['cat' => 'bus',     'img' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=600&h=600&fit=crop', 'title' => 'Minibus 15 places - Sorties groupees',           'brand' => 'Autocars Charlevoix',   'price' => 189.00, 'old' => null,   'badge' => null,       'rating' => 5, 'reviews' => 67],
        ['cat' => 'bus',     'img' => 'https://images.unsplash.com/photo-1519003722824-194d4455a60c?w=600&h=600&fit=crop', 'title' => 'Bus tourisme 33 places - Excursions privees',   'brand' => 'Quebec Coach Lines',    'price' => 420.00, 'old' => 470.00, 'badge' => 'promo',    'rating' => 5, 'reviews' => 42],
        ['cat' => 'vr',      'img' => 'https://images.unsplash.com/photo-1470246973918-29a93221c455?w=600&h=600&fit=crop', 'title' => 'VR Classe C 4 saisons - 6 couchages',           'brand' => 'VR Canada',             'price' => 249.00, 'old' => null,   'badge' => 'new',      'rating' => 5, 'reviews' => 86],
        ['cat' => 'vr',      'img' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=600&h=600&fit=crop', 'title' => 'Van amenage hiver/isole - Roadtrip nordique',   'brand' => 'Nomad Van QC',          'price' => 179.00, 'old' => 199.00, 'badge' => 'trending', 'rating' => 4, 'reviews' => 103],
        ['cat' => 'special', 'img' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=600&h=600&fit=crop', 'title' => 'Motoneige Expedition - Forfaits 4 saisons',      'brand' => 'Aventure Saguenay',     'price' => 149.00, 'old' => null,   'badge' => 'hot',      'rating' => 5, 'reviews' => 77],
        ['cat' => 'special', 'img' => 'https://images.unsplash.com/photo-1534447677768-be436bb09401?w=600&h=600&fit=crop', 'title' => 'Bateau ponton - Lacs et rivieres du Quebec',    'brand' => 'Marina Laurentides',    'price' => 199.00, 'old' => 229.00, 'badge' => 'promo',    'rating' => 4, 'reviews' => 58],
    ];

    $vehicleSlides = [
        [
            'main' => [
                'src'   => 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=900&h=500&fit=crop',
                'video' => 'M-2eAiU09qg',
                'title' => 'LOCATION AUTO, BUS, VEHICULES RECREATIFS 4 SAISONS',
                'desc'  => 'Autos, VUS, bus, VR, motoneiges et bateaux pour voyager toute l annee',
                'badge' => 'new',
            ],
            'grid' => [
                ['src' => 'https://images.unsplash.com/photo-1493238792000-8113da705763?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Autos compactes',  'desc' => 'Ville et trajets economiques',      'badge' => 'popular'],
                ['src' => 'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'VUS & 4x4',         'desc' => 'Routes hivernales et nature',       'badge' => 'hot'],
                ['src' => 'https://images.unsplash.com/photo-1570125909232-eb263c188f7e?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Bus groupes',       'desc' => 'Transport prive et scolaire',       'badge' => 'trending'],
                ['src' => 'https://images.unsplash.com/photo-1470246973918-29a93221c455?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'VR 4 saisons',      'desc' => 'Confort nomade en toute saison',    'badge' => 'new'],
            ],
        ],
    ];
@endphp

<section class="products-vedette-v2-section" id="location-vehicules">
    <div class="products-vedette-v2-container">
        <div class="resto-header-block">
            <div class="resto-header-main">
                <div class="resto-header-logo-left">
                    <a href="#" class="resto-accord-btn" title="Location GoExploria">
                        <div class="logo-wrapper">
                            <img src="{{ asset('logo.png') }}" alt="Location GoExploria">
                        </div>
                        <span class="resto-accord-btn-label">GoExploria Mobility</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-external-link-alt"></i> Decouvrir
                        </span>
                    </a>
                </div>

                <div class="resto-header-center">
                    <h1 class="resto-header-title">LOCATION AUTO, BUS, VÉHICULES RÉCRÉATIFS 4 SAISONS</h1>
                    <p class="resto-header-subtitle">
                        Autos, VUS, bus prives et VR equipes pour 4 saisons a travers le Quebec et le Canada.
                    </p></div>

                <div class="resto-header-logo-right">
                    <a href="#" class="resto-accord-btn" title="Reservation location">
                        <div class="logo-wrapper">
                            <img src="{{ asset('plan-n-go.png') }}" alt="Reservation location">
                        </div>
                        <span class="resto-accord-btn-label">Reservations</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-calendar-check"></i> Reserver
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
                            @foreach($vehicleCategories as $key => $cat)
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
            <button class="vedette-carousel-btn vedette-carousel-prev" id="vehicleCarouselPrev" aria-label="Precedent"><i class="fas fa-chevron-left"></i></button>
            <div class="products-vedette-v2-scroll-wrapper">
                <div class="products-vedette-v2-scroll-container" id="vehicleVedetteGrid">
                    @foreach($vehicleOffers as $item)
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
                                    <span class="products-vedette-v2-price">{{ number_format($item['price'], 2, ',', ' ') }} $ / jour</span>
                                </div>
                                <button class="products-vedette-v2-add-btn" type="button" aria-label="Reserver">
                                    <i class="fas fa-key"></i>
                                </button>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            <button class="vedette-carousel-btn vedette-carousel-next" id="vehicleCarouselNext" aria-label="Suivant"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="vedette-carousel-progress"><div class="vedette-carousel-bar" id="vehicleCarouselBar"></div></div>

        @include('home-v2.components.MediaSlideshow', [
            'slideshowId' => 'vehicleMedia',
            'slides'      => $vehicleSlides,
        ])
    </div>
</section>

<script>
(function () {
    var wrapper = document.getElementById('vehicleVedetteGrid');
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

    var bar = document.getElementById('vehicleCarouselBar');
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

    var prev = document.getElementById('vehicleCarouselPrev');
    var next = document.getElementById('vehicleCarouselNext');
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
