@php
    $tr = static function (string $text): string {
        $locale = app()->getLocale();
        if ($locale === 'fr') {
            return $text;
        }

        static $maps = [];
        if (! array_key_exists($locale, $maps)) {
            $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
            $maps[$locale] = is_file($path) ? (require $path) : [];
        }

        return $maps[$locale][$text] ?? $text;
    };
@endphp

{{-- Destinations Vedette Component - Destinations vedette --}}
<section class="destinations-vedette-v2-section" id="destinations-vedette">
    <div class="destinations-vedette-v2-container">
        {{-- ============================================================
             ENTÊTE DESTINATIONS VEDETTES — même layout que RestaurantHeader
             ============================================================ --}}
        <div class="resto-header-block">

            <div class="resto-header-main">

                {{-- Logo gauche : GoExploria --}}
                <div class="resto-header-logo-left">
                    <a href="#" class="resto-accord-btn" title="{{ $tr('GoExploria') }}">
                        <div class="logo-wrapper">
                            <img src="{{ asset('logo.png') }}" alt="{{ $tr('GoExploria') }}">
                        </div>
                        <span class="resto-accord-btn-label">{{ $tr('GoExploria') }}</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-external-link-alt"></i> {{ $tr('Visiter') }}
                        </span>
                    </a>
                </div>

                {{-- Centre : titre + sous-titre + 4 boutons espaces --}}
                <div class="resto-header-center">
                    <h1 class="resto-header-title">{{ $tr('DESTINATIONS VEDETTES') }}</h1>
                    <p class="resto-header-subtitle">
                        {{ $tr('Québec · Canada · Amérique du Nord — Découvrez les plus belles destinations sublimées par l\'expertise GoExploria.') }}
                    </p>

                    <div class="resto-header-tabs" role="tablist">
                        <button class="resto-tab-btn active" role="tab" data-espace="all">
                            <i class="fas fa-th-large"></i> {{ $tr('Toutes les options') }}
                        </button>
                        <button class="resto-tab-btn" role="tab" data-espace="entreprise">
                            <i class="fas fa-briefcase"></i> {{ $tr('Espace entreprise') }}
                        </button>
                        <button class="resto-tab-btn" role="tab" data-espace="destination">
                            <i class="fas fa-map-marker-alt"></i> {{ $tr('Espace destination') }}
                        </button>
                        <button class="resto-tab-btn" role="tab" data-espace="activite">
                            <i class="fas fa-person-hiking"></i> {{ $tr('Espace activité') }}
                        </button>
                    </div>
                </div>

                {{-- Logo droit : Destinations Vedettes --}}
                <div class="resto-header-logo-right">
                    <a href="#" class="resto-accord-btn" title="{{ $tr('Destinations Vedettes') }}">
                        <div class="logo-wrapper">
                            <img src="{{ asset('REDI.png') }}" alt="{{ $tr('Destinations Vedettes') }}">
                        </div>
                        <span class="resto-accord-btn-label">{{ $tr('Destinations Vedettes') }}</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-external-link-alt"></i> {{ $tr('Visiter') }}
                        </span>
                    </a>
                </div>

            </div>

            {{-- Barre Destinations + Filtres --}}
            <div class="resto-header-destinations-bar">

                <div class="resto-dest-row">
                    <div class="resto-dest-icon-box">
                        <img src="{{ asset('REDI.png') }}" alt="{{ $tr('Destinations') }}">
                        <span>{{ $tr('Destinations') }}</span>
                    </div>
                    <div class="resto-dest-breadcrumb">
                        <a href="#" class="resto-dest-link active" data-dest="all">{{ $tr('Toutes destinations') }}</a>
                        <span class="resto-dest-sep">/</span>
                        <a href="#" class="resto-dest-link" data-dest="amerique-nord">{{ $tr('Amérique du Nord') }}</a>
                        <span class="resto-dest-sep">/</span>
                        <a href="#" class="resto-dest-link" data-dest="canada">{{ $tr('Canada') }}</a>
                        <span class="resto-dest-sep">/</span>
                        <a href="#" class="resto-dest-link" data-dest="quebec">{{ $tr('Québec') }}</a>
                        <span class="resto-dest-sep">/</span>
                        <a href="#" class="resto-dest-link" data-dest="region-quebec">{{ $tr('Région de Québec') }}</a>
                    </div>
                </div>

                <div class="resto-actions-row">
                    <div class="resto-header-ctas">
                        <div class="destinations-vedette-v2-filters">
                            <button class="destinations-vedette-v2-filter-btn active" data-filter="all"><i class="fas fa-th-large"></i> {{ $tr('Toutes les destinations') }}</button>
                            <button class="destinations-vedette-v2-filter-btn" data-filter="patrimoine"><i class="fas fa-landmark"></i> {{ $tr('Patrimoine & Culture') }}</button>
                            <button class="destinations-vedette-v2-filter-btn" data-filter="urbain"><i class="fas fa-city"></i> {{ $tr('Villes & Cités') }}</button>
                            <button class="destinations-vedette-v2-filter-btn" data-filter="nature"><i class="fas fa-mountain"></i> {{ $tr('Nature & Paysage') }}</button>
                            <button class="destinations-vedette-v2-filter-btn" data-filter="plein-air"><i class="fas fa-person-skiing"></i> {{ $tr('Plein air & Ski') }}</button>
                        </div>
                        <a href="#" class="resto-cta-btn secondary">
                            {{ $tr('En savoir') }} <span class="cta-plus">+</span>
                        </a>
                    </div>
                </div>

            </div>

            <div class="resto-header-shimmer"></div>
        </div>
 {{-- Carousel des destinations --}}
        <div class="vedette-carousel-outer">
            <button class="vedette-carousel-btn vedette-carousel-prev" id="destCarouselPrev" aria-label="{{ $tr('Précédent') }}"><i class="fas fa-chevron-left"></i></button>
            <div class="destinations-vedette-v2-scroll-wrapper">
                <div class="destinations-vedette-v2-scroll-container" id="destinationsVedetteGrid">
            {{-- Destination Card 1 --}}
            <article class="destinations-vedette-v2-card" data-category="patrimoine">
                <div class="destinations-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1519112232436-9923c6ba3d26?w=600&h=400&fit=crop" alt="{{ $tr('Vieux-Québec') }}">
                </div>
                <div class="destinations-vedette-v2-card-content">
                    <h3 class="destinations-vedette-v2-card-title">{{ $tr('Vieux-Québec') }}</h3>
                    <p class="destinations-vedette-v2-card-description">
                        {{ $tr('Seule ville fortifiée en Amérique du Nord, patrimoine mondial de l\'UNESCO.') }}
                    </p>
                    <div class="destinations-vedette-v2-card-footer">
                        <span class="destinations-vedette-v2-card-location">{{ $tr('Québec') }}</span>
                        <div class="destinations-vedette-v2-card-rating">
                            ⭐⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
            </article>

            {{-- Destination Card 2 --}}
            <article class="destinations-vedette-v2-card" data-category="urbain">
                <div class="destinations-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1517935706615-2717063c2225?w=600&h=400&fit=crop" alt="{{ $tr('Montréal Métropolitain') }}">
                </div>
                <div class="destinations-vedette-v2-card-content">
                    <h3 class="destinations-vedette-v2-card-title">{{ $tr('Montréal Métropolitain') }}</h3>
                    <p class="destinations-vedette-v2-card-description">
                        {{ $tr('Ville vibrante alliant histoire, culture, gastronomie et vie nocturne animée.') }}
                    </p>
                    <div class="destinations-vedette-v2-card-footer">
                        <span class="destinations-vedette-v2-card-location">{{ $tr('Montréal') }}</span>
                        <div class="destinations-vedette-v2-card-rating">
                            ⭐⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
            </article>

            {{-- Destination Card 3 --}}
            <article class="destinations-vedette-v2-card" data-category="nature">
                <div class="destinations-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&h=400&fit=crop" alt="{{ $tr('Charlevoix') }}">
                </div>
                <div class="destinations-vedette-v2-card-content">
                    <h3 class="destinations-vedette-v2-card-title">{{ $tr('Charlevoix') }}</h3>
                    <p class="destinations-vedette-v2-card-description">
                        {{ $tr('Région reconnue pour ses paysages magnifiques, sa gastronomie et ses artistes.') }}
                    </p>
                    <div class="destinations-vedette-v2-card-footer">
                        <span class="destinations-vedette-v2-card-location">{{ $tr('Charlevoix') }}</span>
                        <div class="destinations-vedette-v2-card-rating">
                            ⭐⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
            </article>

            {{-- Destination Card 4 --}}
            <article class="destinations-vedette-v2-card" data-category="nature">
                <div class="destinations-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=600&h=400&fit=crop" alt="{{ $tr('Gaspésie') }}">
                </div>
                <div class="destinations-vedette-v2-card-content">
                    <h3 class="destinations-vedette-v2-card-title">{{ $tr('Gaspésie') }}</h3>
                    <p class="destinations-vedette-v2-card-description">
                        {{ $tr('Péninsule sauvage offrant des paysages côtiers spectaculaires et une faune riche.') }}
                    </p>
                    <div class="destinations-vedette-v2-card-footer">
                        <span class="destinations-vedette-v2-card-location">{{ $tr('Gaspésie') }}</span>
                        <div class="destinations-vedette-v2-card-rating">
                            ⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
            </article>

            {{-- Destination Card 5 --}}
            <article class="destinations-vedette-v2-card" data-category="plein-air">
                <div class="destinations-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1551582045-6ec9c11d8697?w=600&h=400&fit=crop" alt="{{ $tr('Laurentides') }}">
                </div>
                <div class="destinations-vedette-v2-card-content">
                    <h3 class="destinations-vedette-v2-card-title">{{ $tr('Laurentides') }}</h3>
                    <p class="destinations-vedette-v2-card-description">
                        {{ $tr('Paradis du ski et des activités de plein air, lacs et montagnes à perte de vue.') }}
                    </p>
                    <div class="destinations-vedette-v2-card-footer">
                        <span class="destinations-vedette-v2-card-location">{{ $tr('Laurentides') }}</span>
                        <div class="destinations-vedette-v2-card-rating">
                            ⭐⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
            </article>

            {{-- Destination Card 6 --}}
            <article class="destinations-vedette-v2-card" data-category="plein-air">
                <div class="destinations-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1605540436563-5bca919ae766?w=600&h=400&fit=crop" alt="{{ $tr('Mont-Tremblant') }}">
                </div>
                <div class="destinations-vedette-v2-card-content">
                    <h3 class="destinations-vedette-v2-card-title">{{ $tr('Mont-Tremblant') }}</h3>
                    <p class="destinations-vedette-v2-card-description">
                        {{ $tr('Station de ski de renommée mondiale avec village piétonnier européen.') }}
                    </p>
                    <div class="destinations-vedette-v2-card-footer">
                        <span class="destinations-vedette-v2-card-location">{{ $tr('Laurentides') }}</span>
                        <div class="destinations-vedette-v2-card-rating">
                            ⭐⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
            </article>

            {{-- Destination Card 7 --}}
            <article class="destinations-vedette-v2-card" data-category="nature">
                <div class="destinations-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=600&h=400&fit=crop" alt="{{ $tr('Îles de la Madeleine') }}">
                </div>
                <div class="destinations-vedette-v2-card-content">
                    <h3 class="destinations-vedette-v2-card-title">{{ $tr('Îles de la Madeleine') }}</h3>
                    <p class="destinations-vedette-v2-card-description">
                        {{ $tr('Archipel unique avec plages de sable fin, falaises rouges et culture acadienne.') }}
                    </p>
                    <div class="destinations-vedette-v2-card-footer">
                        <span class="destinations-vedette-v2-card-location">{{ $tr('Îles de la Madeleine') }}</span>
                        <div class="destinations-vedette-v2-card-rating">
                            ⭐⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
            </article>
                </div>
            </div>
            <button class="vedette-carousel-btn vedette-carousel-next" id="destCarouselNext" aria-label="{{ $tr('Suivant') }}"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="vedette-carousel-progress"><div class="vedette-carousel-bar" id="destCarouselBar"></div></div>
  

        {{-- SLIDESHOW MULTI-CARTE DESTINATIONS --}}
        @php
        $destSlides = [
            [
                'main' => [
                    'src'   => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=900&h=500&fit=crop',
                    'video' => 'M-2eAiU09qg',
                    'title' => 'Vieux-Québec',
                    'desc'  => 'Le cœur historique de la capitale, classé UNESCO',
                    'badge' => 'new',
                ],
                'grid' => [
                    [
                        'src'   => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Charlevoix',
                        'desc'  => 'Paysages époustouflants entre fleuve et montagnes',
                        'badge' => 'hot',
                    ],
                    [
                        'src'   => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Gaspésie',
                        'desc'  => 'Falaises, rochers et mer déchaînée',
                        'badge' => 'trending',
                    ],
                    [
                        'src'   => 'https://images.unsplash.com/photo-1507608616759-54f48f0af0ee?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Mont-Tremblant',
                        'desc'  => 'Station four-saisons au cœur des Laurentides',
                        'badge' => 'popular',
                    ],
                    [
                        'src'   => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Saguenay–Lac-Saint-Jean',
                        'desc'  => 'Fjords majestueux et nature sauvage',
                        'badge' => 'new',
                    ],
                ],
            ],
            [
                'main' => [
                    'src'   => 'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?w=900&h=500&fit=crop',
                    'video' => 'M-2eAiU09qg',
                    'title' => 'Îles-de-la-Madeleine',
                    'desc'  => 'Un archipel unique au milieu du golfe Saint-Laurent',
                    'badge' => 'trending',
                ],
                'grid' => [
                    [
                        'src'   => 'https://images.unsplash.com/photo-1502134249126-9f3755a50d78?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Laurentides',
                        'desc'  => 'Lacs, forêts et stations de ski emblématiques',
                        'badge' => 'popular',
                    ],
                    [
                        'src'   => 'https://images.unsplash.com/photo-1512273222628-4daea6e55abb?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Cantons-de-l\'Est',
                        'desc'  => 'Vignobles, auberges et villages pittoresques',
                        'badge' => 'hot',
                    ],
                    [
                        'src'   => 'https://images.unsplash.com/photo-1439066615861-d1af74d74000?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Mauricie',
                        'desc'  => 'Parc national et rivières cristallines',
                        'badge' => 'new',
                    ],
                    [
                        'src'   => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Montréal',
                        'desc'  => 'Métropole vibrante, culture et gastronomie',
                        'badge' => 'popular',
                    ],
                ],
            ],
        ];

        if (app()->getLocale() !== 'fr') {
            foreach ($destSlides as &$slide) {
                if (isset($slide['main']['title'])) {
                    $slide['main']['title'] = $tr($slide['main']['title']);
                }
                if (isset($slide['main']['desc'])) {
                    $slide['main']['desc'] = $tr($slide['main']['desc']);
                }
                if (! empty($slide['grid']) && is_array($slide['grid'])) {
                    foreach ($slide['grid'] as &$item) {
                        if (isset($item['title'])) {
                            $item['title'] = $tr($item['title']);
                        }
                        if (isset($item['desc'])) {
                            $item['desc'] = $tr($item['desc']);
                        }
                    }
                    unset($item);
                }
            }
            unset($slide);
        }
        @endphp
        @include('home-v2.components.MediaSlideshow', [
            'slideshowId' => 'destMedia',
            'slides'      => $destSlides,
        ])

         </div>
</section>
<script>
(function () {
    var wrapper = document.getElementById('destinationsVedetteGrid');
    var section = wrapper ? wrapper.closest('section') : null;
    if (!wrapper || !section) return;

    var GAP   = 20;
    var PAUSE = 4000;
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

    var bar = document.getElementById('destCarouselBar');
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

    var prev = document.getElementById('destCarouselPrev');
    var next = document.getElementById('destCarouselNext');
    if (prev) prev.addEventListener('click', function () { stopAuto(); shiftRight(); startAuto(); });
    if (next) next.addEventListener('click', function () { stopAuto(); shiftLeft();  startAuto(); });

    section.querySelectorAll('.destinations-vedette-v2-filter-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            section.querySelectorAll('.destinations-vedette-v2-filter-btn').forEach(function (b) { b.classList.remove('active'); });
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
})();
</script>
