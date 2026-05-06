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

{{-- Events Vedette Component - Événements vedette au Québec --}}
<section class="events-vedette-v2-section" id="evenements-vedette">
    <div class="events-vedette-v2-container">
        {{-- ============================================================
             ENTÊTE ÉVÉNEMENTS VEDETTE — même layout que RestaurantHeader
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
                    <h1 class="resto-header-title">{{ $tr('ÉVÉNEMENTS VEDETTE AU QUÉBEC') }}</h1>
                    <p class="resto-header-subtitle">
                        {{ $tr('Festivals · Culture · Plein air · Gastronomie — Les événements incontournables de la Belle Province sélectionnés par GoExploria.') }}
                    </p></div>

                {{-- Logo droit : Événements Québec --}}
                <div class="resto-header-logo-right">
                    <a href="#" class="resto-accord-btn" title="{{ $tr('Événements Québec') }}">
                        <div class="logo-wrapper">
                            <img src="{{ asset('plan-n-go.png') }}" alt="{{ $tr('Événements Québec') }}">
                        </div>
                        <span class="resto-accord-btn-label">{{ $tr('Événements Québec') }}</span>
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
                        <div class="events-vedette-v2-filters">
                            <button class="events-vedette-v2-filter-btn active" data-filter="all"><i class="fas fa-th-large"></i> {{ $tr('Tous les événements') }}</button>
                            <button class="events-vedette-v2-filter-btn" data-filter="culture"><i class="fas fa-palette"></i> {{ $tr('Culture & Arts') }}</button>
                            <button class="events-vedette-v2-filter-btn" data-filter="gastronomie"><i class="fas fa-utensils"></i> {{ $tr('Gastronomie') }}</button>
                            <button class="events-vedette-v2-filter-btn" data-filter="nature"><i class="fas fa-leaf"></i> {{ $tr('Nature & Plein air') }}</button>
                            <button class="events-vedette-v2-filter-btn" data-filter="aventures"><i class="fas fa-person-hiking"></i> {{ $tr('Aventure & Sports') }}</button>
                        </div>
                        <a href="#" class="resto-cta-btn secondary">
                            {{ $tr('En savoir') }} <span class="cta-plus">+</span>
                        </a>
                    </div>
                </div>

            </div>

            <div class="resto-header-shimmer"></div>
        </div>

         {{-- Carousel des événements --}}
        <div class="vedette-carousel-outer">
            <button class="vedette-carousel-btn vedette-carousel-prev" id="eventsCarouselPrev" aria-label="{{ $tr('Précédent') }}"><i class="fas fa-chevron-left"></i></button>
            <div class="events-vedette-v2-scroll-wrapper">
                <div class="events-vedette-v2-scroll-container" id="eventsVedetteGrid">
            {{-- Event Card 1 --}}
            <article class="events-vedette-v2-card" data-category="culture">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=600&h=400&fit=crop" alt="{{ $tr('Festival d\'été de Québec') }}">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">{{ $tr('15-24 JUIN') }}</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">{{ $tr('Festival d\'été de Québec') }}</h3>
                    <p class="events-vedette-v2-card-description">
                        {{ $tr('Le plus grand festival extérieur en Amérique du Nord, avec des artistes internationaux.') }}
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">{{ $tr('Québec') }}</span>
                        <span class="events-vedette-v2-card-tag">{{ $tr('Scènes extérieures') }}</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 2 --}}
            <article class="events-vedette-v2-card" data-category="gastronomie">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1555244162-803834f70033?w=600&h=400&fit=crop" alt="{{ $tr('Carnaval de Québec') }}">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">{{ $tr('28 FÉV - 10 MAR') }}</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">{{ $tr('Carnaval de Québec') }}</h3>
                    <p class="events-vedette-v2-card-description">
                        {{ $tr('Le plus grand carnaval d\'hiver au monde avec Bonhomme Carnaval comme ambassadeur.') }}
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">{{ $tr('Québec') }}</span>
                        <span class="events-vedette-v2-card-tag">{{ $tr('Activités hivernales') }}</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 3 --}}
            <article class="events-vedette-v2-card" data-category="culture">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&h=400&fit=crop" alt="{{ $tr('Osheaga') }}">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">{{ $tr('AOÛT 2024') }}</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">{{ $tr('Osheaga') }}</h3>
                    <p class="events-vedette-v2-card-description">
                        {{ $tr('Festival de musique et arts contemporains sur l\'île Sainte-Hélène à Montréal.') }}
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">{{ $tr('Montréal') }}</span>
                        <span class="events-vedette-v2-card-tag">{{ $tr('Musique & Arts') }}</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 4 --}}
            <article class="events-vedette-v2-card" data-category="nature">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=600&h=400&fit=crop" alt="{{ $tr('Festival des couleurs') }}">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">{{ $tr('OCT 2024') }}</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">{{ $tr('Festival des couleurs') }}</h3>
                    <p class="events-vedette-v2-card-description">
                        {{ $tr('Célébration de l\'automne et des magnifiques paysages colorés des Cantons-de-l\'Est.') }}
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">{{ $tr('Cantons-de-l\'Est') }}</span>
                        <span class="events-vedette-v2-card-tag">{{ $tr('Nature & Culture') }}</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 5 --}}
            <article class="events-vedette-v2-card" data-category="aventures">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=600&h=400&fit=crop" alt="{{ $tr('Festival de montgolfières') }}">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">{{ $tr('SEPT 2024') }}</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">{{ $tr('Festival de montgolfières') }}</h3>
                    <p class="events-vedette-v2-card-description">
                        {{ $tr('Le plus grand rassemblement de montgolfières au Canada à Saint-Jean-sur-Richelieu.') }}
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">{{ $tr('Saint-Jean-sur-Richelieu') }}</span>
                        <span class="events-vedette-v2-card-tag">{{ $tr('Aventures') }}</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 6 --}}
            <article class="events-vedette-v2-card" data-category="culture">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=600&h=400&fit=crop" alt="{{ $tr('Festival Juste pour rire') }}">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">{{ $tr('JUIL 2024') }}</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">{{ $tr('Festival Juste pour rire') }}</h3>
                    <p class="events-vedette-v2-card-description">
                        {{ $tr('Le plus grand festival d\'humour au monde avec des spectacles et animations.') }}
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">{{ $tr('Montréal') }}</span>
                        <span class="events-vedette-v2-card-tag">{{ $tr('Humour & Spectacles') }}</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 7 --}}
            <article class="events-vedette-v2-card" data-category="gastronomie">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&h=400&fit=crop" alt="{{ $tr('Festival gastronomique') }}">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">{{ $tr('MAI 2024') }}</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">{{ $tr('Festival gastronomique') }}</h3>
                    <p class="events-vedette-v2-card-description">
                        {{ $tr('Découvrez la richesse culinaire du Québec avec des chefs renommés.') }}
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">{{ $tr('Montréal') }}</span>
                        <span class="events-vedette-v2-card-tag">{{ $tr('Gastronomie') }}</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 8 --}}
            <article class="events-vedette-v2-card" data-category="nature">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=600&h=400&fit=crop" alt="{{ $tr('Festival des baleines') }}">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">{{ $tr('JUIN 2024') }}</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">{{ $tr('Festival des baleines') }}</h3>
                    <p class="events-vedette-v2-card-description">
                        {{ $tr('Observation des baleines et célébration de la faune marine du Saint-Laurent.') }}
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">{{ $tr('Tadoussac') }}</span>
                        <span class="events-vedette-v2-card-tag">{{ $tr('Nature & Faune') }}</span>
                    </div>
                </div>
            </article>
                </div>
            </div>
            <button class="vedette-carousel-btn vedette-carousel-next" id="eventsCarouselNext" aria-label="{{ $tr('Suivant') }}"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="vedette-carousel-progress"><div class="vedette-carousel-bar" id="eventsCarouselBar"></div></div>
    

        {{-- SLIDESHOW MULTI-CARTE ÉVÉNEMENTS --}}
        @php
        $eventsSlides = [
            [
                'main' => [
                    'src'   => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=900&h=500&fit=crop',
                    'video' => 'M-2eAiU09qg',
                    'title' => "Festival d'été de Québec",
                    'desc'  => 'Le plus grand festival en plein air de la francophonie',
                    'badge' => 'new',
                ],
                'grid' => [
                    [
                        'src'   => 'https://images.unsplash.com/photo-1502134249126-9f3755a50d78?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Carnaval de Québec',
                        'desc'  => "Le plus grand carnaval d'hiver au monde",
                        'badge' => 'hot',
                    ],
                    [
                        'src'   => 'https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Osheaga — Montréal',
                        'desc'  => 'Musique, arts et culture au cœur de Montréal',
                        'badge' => 'trending',
                    ],
                    [
                        'src'   => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Jazz de Montréal',
                        'desc'  => 'Le plus grand festival de jazz du monde',
                        'badge' => 'popular',
                    ],
                    [
                        'src'   => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Fête des Neiges',
                        'desc'  => 'Glisse, sculptures de glace et festivités hivernales',
                        'badge' => 'new',
                    ],
                ],
            ],
            [
                'main' => [
                    'src'   => 'https://images.unsplash.com/photo-1507608616759-54f48f0af0ee?w=900&h=500&fit=crop',
                    'video' => 'M-2eAiU09qg',
                    'title' => 'Festival des Couleurs — Laurentides',
                    'desc'  => "L'explosion de couleurs des Laurentides en automne",
                    'badge' => 'trending',
                ],
                'grid' => [
                    [
                        'src'   => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Juste pour Rire',
                        'desc'  => 'Le plus grand festival de comédie au monde',
                        'badge' => 'popular',
                    ],
                    [
                        'src'   => 'https://images.unsplash.com/photo-1530549387789-4c1017266635?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Grand Prix du Canada',
                        'desc'  => 'Formule 1 sur le Circuit Gilles-Villeneuve',
                        'badge' => 'hot',
                    ],
                    [
                        'src'   => 'https://images.unsplash.com/photo-1487958449943-2429e8be8625?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Cirque du Soleil',
                        'desc'  => 'Magie, acrobaties et spectacles inoubliables',
                        'badge' => 'new',
                    ],
                    [
                        'src'   => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=500&h=300&fit=crop',
                        'video' => 'M-2eAiU09qg',
                        'title' => 'Francofolies',
                        'desc'  => 'La chanson francophone à l\'honneur à Montréal',
                        'badge' => 'trending',
                    ],
                ],
            ],
        ];

        if (app()->getLocale() !== 'fr') {
            foreach ($eventsSlides as &$slide) {
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
            'slideshowId' => 'eventsMedia',
            'slides'      => $eventsSlides,
        ])

       </div>
</section>
<script>
(function () {
    var wrapper = document.getElementById('eventsVedetteGrid');
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

    var bar = document.getElementById('eventsCarouselBar');
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

    var prev = document.getElementById('eventsCarouselPrev');
    var next = document.getElementById('eventsCarouselNext');
    if (prev) prev.addEventListener('click', function () { stopAuto(); shiftRight(); startAuto(); });
    if (next) next.addEventListener('click', function () { stopAuto(); shiftLeft();  startAuto(); });

    section.querySelectorAll('.events-vedette-v2-filter-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            section.querySelectorAll('.events-vedette-v2-filter-btn').forEach(function (b) { b.classList.remove('active'); });
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
