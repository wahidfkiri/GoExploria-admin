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

                {{-- Centre : titre + sous-titre + 4 boutons espaces --}}
                <div class="resto-header-center">
                    <h1 class="resto-header-title">ÉVÉNEMENTS VEDETTE AU QUÉBEC</h1>
                    <p class="resto-header-subtitle">
                        Festivals · Culture · Plein air · Gastronomie — Les événements incontournables de la Belle Province sélectionnés par GoExploria.
                    </p>

                    <div class="resto-header-tabs" role="tablist">
                        <button class="resto-tab-btn active" role="tab" data-espace="all">
                            <i class="fas fa-th-large"></i> Toutes les options
                        </button>
                        <button class="resto-tab-btn" role="tab" data-espace="entreprise">
                            <i class="fas fa-briefcase"></i> Espace entreprise
                        </button>
                        <button class="resto-tab-btn" role="tab" data-espace="destination">
                            <i class="fas fa-map-marker-alt"></i> Espace destination
                        </button>
                        <button class="resto-tab-btn" role="tab" data-espace="activite">
                            <i class="fas fa-person-hiking"></i> Espace activité
                        </button>
                    </div>
                </div>

                {{-- Logo droit : Événements Québec --}}
                <div class="resto-header-logo-right">
                    <a href="#" class="resto-accord-btn" title="Événements Québec">
                        <div class="logo-wrapper">
                            <img src="{{ asset('plan-n-go.png') }}" alt="Événements Québec">
                        </div>
                        <span class="resto-accord-btn-label">Événements Québec</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-external-link-alt"></i> Visiter
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
                    <div class="resto-dest-breadcrumb">
                        <a href="#" class="resto-dest-link active" data-dest="all">Toutes destinations</a>
                        <span class="resto-dest-sep">/</span>
                        <a href="#" class="resto-dest-link" data-dest="amerique-nord">Amérique du Nord</a>
                        <span class="resto-dest-sep">/</span>
                        <a href="#" class="resto-dest-link" data-dest="canada">Canada</a>
                        <span class="resto-dest-sep">/</span>
                        <a href="#" class="resto-dest-link" data-dest="quebec">Québec</a>
                        <span class="resto-dest-sep">/</span>
                        <a href="#" class="resto-dest-link" data-dest="region-quebec">Région de Québec</a>
                    </div>
                </div>

                <div class="resto-actions-row">
                    <div class="resto-header-ctas">
                        <div class="events-vedette-v2-filters">
                            <button class="events-vedette-v2-filter-btn active" data-filter="all"><i class="fas fa-th-large"></i> Tous les événements</button>
                            <button class="events-vedette-v2-filter-btn" data-filter="culture"><i class="fas fa-palette"></i> Culture &amp; Arts</button>
                            <button class="events-vedette-v2-filter-btn" data-filter="gastronomie"><i class="fas fa-utensils"></i> Gastronomie</button>
                            <button class="events-vedette-v2-filter-btn" data-filter="nature"><i class="fas fa-leaf"></i> Nature &amp; Plein air</button>
                            <button class="events-vedette-v2-filter-btn" data-filter="aventures"><i class="fas fa-person-hiking"></i> Aventure &amp; Sports</button>
                        </div>
                        <a href="#" class="resto-cta-btn secondary">
                            En savoir <span class="cta-plus">+</span>
                        </a>
                    </div>
                </div>

            </div>

            <div class="resto-header-shimmer"></div>
        </div>

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
        @endphp
        @include('home-v2.components.MediaSlideshow', [
            'slideshowId' => 'eventsMedia',
            'slides'      => $eventsSlides,
        ])

        {{-- Carousel des événements --}}
        <div class="vedette-carousel-outer">
            <button class="vedette-carousel-btn vedette-carousel-prev" id="eventsCarouselPrev" aria-label="Précédent"><i class="fas fa-chevron-left"></i></button>
            <div class="events-vedette-v2-scroll-wrapper">
                <div class="events-vedette-v2-scroll-container" id="eventsVedetteGrid">
            {{-- Event Card 1 --}}
            <article class="events-vedette-v2-card" data-category="culture">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=600&h=400&fit=crop" alt="Festival d'été de Québec">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">15-24 JUIN</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Festival d'été de Québec</h3>
                    <p class="events-vedette-v2-card-description">
                        Le plus grand festival extérieur en Amérique du Nord, avec des artistes internationaux.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Québec</span>
                        <span class="events-vedette-v2-card-tag">Scènes extérieures</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 2 --}}
            <article class="events-vedette-v2-card" data-category="gastronomie">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1555244162-803834f70033?w=600&h=400&fit=crop" alt="Carnaval de Québec">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">28 FÉV - 10 MAR</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Carnaval de Québec</h3>
                    <p class="events-vedette-v2-card-description">
                        Le plus grand carnaval d'hiver au monde avec Bonhomme Carnaval comme ambassadeur.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Québec</span>
                        <span class="events-vedette-v2-card-tag">Activités hivernales</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 3 --}}
            <article class="events-vedette-v2-card" data-category="culture">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&h=400&fit=crop" alt="Osheaga">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">AOÛT 2024</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Osheaga</h3>
                    <p class="events-vedette-v2-card-description">
                        Festival de musique et arts contemporains sur l'île Sainte-Hélène à Montréal.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Montréal</span>
                        <span class="events-vedette-v2-card-tag">Musique & Arts</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 4 --}}
            <article class="events-vedette-v2-card" data-category="nature">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=600&h=400&fit=crop" alt="Festival des couleurs">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">OCT 2024</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Festival des couleurs</h3>
                    <p class="events-vedette-v2-card-description">
                        Célébration de l'automne et des magnifiques paysages colorés des Cantons-de-l'Est.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Cantons-de-l'Est</span>
                        <span class="events-vedette-v2-card-tag">Nature & Culture</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 5 --}}
            <article class="events-vedette-v2-card" data-category="aventures">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=600&h=400&fit=crop" alt="Festival de montgolfières">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">SEPT 2024</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Festival de montgolfières</h3>
                    <p class="events-vedette-v2-card-description">
                        Le plus grand rassemblement de montgolfières au Canada à Saint-Jean-sur-Richelieu.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Saint-Jean-sur-Richelieu</span>
                        <span class="events-vedette-v2-card-tag">Aventures</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 6 --}}
            <article class="events-vedette-v2-card" data-category="culture">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=600&h=400&fit=crop" alt="Festival Juste pour rire">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">JUIL 2024</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Festival Juste pour rire</h3>
                    <p class="events-vedette-v2-card-description">
                        Le plus grand festival d'humour au monde avec des spectacles et animations.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Montréal</span>
                        <span class="events-vedette-v2-card-tag">Humour & Spectacles</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 7 --}}
            <article class="events-vedette-v2-card" data-category="gastronomie">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&h=400&fit=crop" alt="Festival gastronomique">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">MAI 2024</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Festival gastronomique</h3>
                    <p class="events-vedette-v2-card-description">
                        Découvrez la richesse culinaire du Québec avec des chefs renommés.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Montréal</span>
                        <span class="events-vedette-v2-card-tag">Gastronomie</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 8 --}}
            <article class="events-vedette-v2-card" data-category="nature">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=600&h=400&fit=crop" alt="Festival des baleines">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">JUIN 2024</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Festival des baleines</h3>
                    <p class="events-vedette-v2-card-description">
                        Observation des baleines et célébration de la faune marine du Saint-Laurent.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Tadoussac</span>
                        <span class="events-vedette-v2-card-tag">Nature & Faune</span>
                    </div>
                </div>
            </article>
                </div>
            </div>
            <button class="vedette-carousel-btn vedette-carousel-next" id="eventsCarouselNext" aria-label="Suivant"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="vedette-carousel-progress"><div class="vedette-carousel-bar" id="eventsCarouselBar"></div></div>
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
