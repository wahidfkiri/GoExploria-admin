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

    $sectionId = $sectionId ?? 'featured-space';
    $carouselId = $sectionId . 'Grid';
    $prevId = $sectionId . 'Prev';
    $nextId = $sectionId . 'Next';
    $barId = $sectionId . 'Bar';
    $slideshowId = $sectionId . 'Media';
    $title = $title ?? 'ESPACE VEDETTE';
    $subtitle = $subtitle ?? 'Sélection GoExploria en vedette.';
    $ctaLabel = $ctaLabel ?? 'En savoir';
    $rightLabel = $rightLabel ?? 'Vedette';
    $learnMoreUrl = $learnMoreUrl ?? '#';
    $categories = $categories ?? [];
    $items = $items ?? [];
    $slides = $slides ?? [];
@endphp

<section class="events-vedette-v2-section featured-space-v2-section" id="{{ $sectionId }}">
    <div class="events-vedette-v2-container">
        <div class="resto-header-block">
            <div class="resto-header-main">
                <div class="resto-header-logo-left">
                    <a href="#" class="resto-accord-btn" title="{{ $tr('GoExploria') }}">
                        <div class="logo-wrapper">
                            <img loading="lazy" decoding="async" src="{{ asset('logo.png') }}" alt="{{ $tr('GoExploria') }}">
                        </div>
                        <span class="resto-accord-btn-label">{{ $tr('GoExploria') }}</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-external-link-alt"></i> {{ $tr('Visiter') }}
                        </span>
                    </a>
                </div>

                <div class="resto-header-center">
                    <h1 class="resto-header-title">{{ $tr($title) }}</h1>
                    <p class="resto-header-subtitle">{{ $tr($subtitle) }}</p>
                </div>

                <div class="resto-header-logo-right">
                    <a href="{{ $learnMoreUrl }}" title="{{ $tr($ctaLabel) }}" target="_blank" rel="noopener noreferrer">
                        <img class="bt-next-level-image" src="{{ asset('images/Next-level.png') }}" alt="Next Level" loading="lazy">
                    </a>
                </div>
            </div>

            <div class="resto-header-destinations-bar">
                <div class="resto-dest-row">
                    <div class="resto-dest-icon-box">
                        <img loading="lazy" decoding="async" src="{{ asset('REDI.png') }}" alt="Destinations">
                        <span>{{ $tr('Destinations') }}</span>
                    </div>

                    <div class="resto-dest-breadcrumb vp-dest-breadcrumb">
                        <select id="{{ $sectionId }}-continent-select" class="vp-dest-select" aria-label="Continent">
                            <option value="amerique-nord">{{ $tr('Amérique du Nord') }}</option>
                            <option value="europe">{{ $tr('Europe') }}</option>
                            <option value="afrique">{{ $tr('Afrique') }}</option>
                            <option value="asie">{{ $tr('Asie') }}</option>
                            <option value="amerique-sud">{{ $tr('Amérique du Sud') }}</option>
                            <option value="oceanie">{{ $tr('Océanie') }}</option>
                        </select>
                        <span class="resto-dest-sep">/</span>
                        <select id="{{ $sectionId }}-country-select" class="vp-dest-select" aria-label="Pays">
                            <option value="canada">{{ $tr('Canada') }}</option>
                        </select>
                        <span class="resto-dest-sep">/</span>
                        <select id="{{ $sectionId }}-province-select" class="vp-dest-select" aria-label="Province">
                            <option value="quebec">{{ $tr('Québec') }}</option>
                            <option value="ontario">{{ $tr('Ontario') }}</option>
                            <option value="alberta">{{ $tr('Alberta') }}</option>
                            <option value="colombie-britannique">{{ $tr('Colombie-Britannique') }}</option>
                            <option value="nouvelle-ecosse">{{ $tr('Nouvelle-Écosse') }}</option>
                        </select>
                        <span class="resto-dest-sep">/</span>
                        <select id="{{ $sectionId }}-region-select" class="vp-dest-select" aria-label="Région">
                            <option value="region-de-quebec">{{ $tr('Région de Québec') }}</option>
                            <option value="montreal-metro">{{ $tr('Montréal Métro') }}</option>
                            <option value="mauricie">{{ $tr('Mauricie') }}</option>
                            <option value="gaspesie">{{ $tr('Gaspésie') }}</option>
                            <option value="saguenay">{{ $tr('Saguenay') }}</option>
                        </select>
                    </div>
                </div>

                <div class="resto-actions-row">
                    <div class="resto-header-ctas">
                        <div class="events-vedette-v2-filters">
                            <button class="events-vedette-v2-filter-btn active" data-filter="all">
                                <i class="fas fa-th-large"></i> {{ $tr('Toutes les options') }}
                            </button>
                            @foreach($categories as $key => $cat)
                                <button class="events-vedette-v2-filter-btn" data-filter="{{ $key }}">
                                    <i class="fas {{ $cat['icon'] ?? 'fa-star' }}"></i> {{ $tr($cat['label'] ?? $key) }}
                                </button>
                            @endforeach
                        </div>
                        <a href="{{ $learnMoreUrl }}" class="resto-cta-btn secondary" target="_blank" rel="noopener noreferrer">
                            {{ $tr($ctaLabel) }} <span class="cta-plus">+</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="resto-header-shimmer"></div>
        </div>

        <div class="vedette-carousel-outer">
            <button class="vedette-carousel-btn vedette-carousel-prev" id="{{ $prevId }}" aria-label="{{ $tr('Précédent') }}"><i class="fas fa-chevron-left"></i></button>
            <div class="events-vedette-v2-scroll-wrapper">
                <div class="events-vedette-v2-scroll-container" id="{{ $carouselId }}">
                    @foreach($items as $item)
                        <article class="events-vedette-v2-card featured-space-v2-card" data-category="{{ $item['cat'] ?? 'all' }}">
                            <div class="events-vedette-v2-card-image">
                                <img src="{{ $item['img'] }}" alt="{{ $tr($item['title']) }}" loading="lazy">
                                <div class="events-vedette-v2-card-date featured-space-v2-badge">
                                    <span class="events-vedette-v2-date-text">{{ $tr($item['badge'] ?? $rightLabel) }}</span>
                                </div>
                            </div>
                            <div class="events-vedette-v2-card-content">
                                <h3 class="events-vedette-v2-card-title">{{ $tr($item['title']) }}</h3>
                                <p class="events-vedette-v2-card-description">{{ $tr($item['desc']) }}</p>
                                <div class="events-vedette-v2-card-footer">
                                    <span class="events-vedette-v2-card-location">{{ $tr($item['location'] ?? 'Québec') }}</span>
                                    <span class="events-vedette-v2-card-tag">{{ $tr($item['tag'] ?? $rightLabel) }}</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
            <button class="vedette-carousel-btn vedette-carousel-next" id="{{ $nextId }}" aria-label="{{ $tr('Suivant') }}"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="vedette-carousel-progress"><div class="vedette-carousel-bar" id="{{ $barId }}"></div></div>

        @if(!empty($slides))
            @include('welcome-home.components.MediaSlideshow', [
                'slideshowId' => $slideshowId,
                'slides' => $slides,
            ])
        @endif
    </div>
</section>

<script>
(function () {
    var wrapper = document.getElementById(@json($carouselId));
    var section = wrapper ? wrapper.closest('section') : null;
    if (!wrapper || !section) return;

    var GAP = 20;
    var PAUSE = 3500;
    var ANIM = 480;
    var timer = null;
    var busy = false;

    function visibleCards() {
        return Array.from(wrapper.children).filter(function (card) { return card.style.display !== 'none'; });
    }

    function resetBar() {
        var bar = document.getElementById(@json($barId));
        if (!bar) return;
        bar.style.transition = 'none';
        bar.style.width = '0%';
        if (bar) bar.offsetWidth;
        bar.style.transition = 'width ' + PAUSE + 'ms linear';
        bar.style.width = '100%';
    }

    function shiftLeft() {
        var cards = visibleCards();
        if (busy || cards.length < 2) return;
        busy = true;
        if (!cards[0]) { busy = false; return; }
        var shift = cards[0].offsetWidth + GAP;
        wrapper.style.transition = 'transform ' + ANIM + 'ms cubic-bezier(0.4,0,0.2,1)';
        wrapper.style.transform = 'translateX(-' + shift + 'px)';
        setTimeout(function () {
            wrapper.style.transition = 'none';
            wrapper.style.transform = 'translateX(0)';
            wrapper.appendChild(cards[0]);
            busy = false;
            resetBar();
        }, ANIM + 20);
    }

    function shiftRight() {
        var cards = visibleCards();
        if (busy || cards.length < 2) return;
        busy = true;
        var last = cards[cards.length - 1];
        if (!last) { busy = false; return; }
        var shift = last.offsetWidth + GAP;
        wrapper.style.transition = 'none';
        wrapper.insertBefore(last, wrapper.firstChild);
        wrapper.style.transform = 'translateX(-' + shift + 'px)';
        if (wrapper) wrapper.offsetWidth;
        wrapper.style.transition = 'transform ' + ANIM + 'ms cubic-bezier(0.4,0,0.2,1)';
        wrapper.style.transform = 'translateX(0)';
        setTimeout(function () { busy = false; resetBar(); }, ANIM + 20);
    }

    function startAuto() { timer = setInterval(shiftLeft, PAUSE); }
    function stopAuto() { clearInterval(timer); }

    resetBar();
    section.addEventListener('mouseenter', stopAuto);
    section.addEventListener('mouseleave', startAuto);
    startAuto();

    var prev = document.getElementById(@json($prevId));
    var next = document.getElementById(@json($nextId));
    if (prev) prev.addEventListener('click', function () { stopAuto(); shiftRight(); startAuto(); });
    if (next) next.addEventListener('click', function () { stopAuto(); shiftLeft(); startAuto(); });

    section.querySelectorAll('.events-vedette-v2-filter-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            section.querySelectorAll('.events-vedette-v2-filter-btn').forEach(function (item) { item.classList.remove('active'); });
            btn.classList.add('active');
            var filter = btn.getAttribute('data-filter');
            Array.from(wrapper.children).forEach(function (card) {
                var category = card.getAttribute('data-category') || '';
                card.style.display = (filter === 'all' || category === filter) ? '' : 'none';
            });
            wrapper.style.transition = 'none';
            wrapper.style.transform = 'translateX(0)';
            busy = false;
            resetBar();
            stopAuto();
            startAuto();
        });
    });
})();
</script>
