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

{{-- Business & Tourism Component --}}
<section class="bt-section" id="business-tourism">

    {{-- EN-TÊTE STANDARD --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div>
                <div class="bt-left-brand" style="display:none;" aria-label="{{ $tr('GoExploria') }}">
                    <div class="logo-wrapper"><img src="{{ asset('logo.png') }}" alt="{{ $tr('GoExploria') }}"></div>
                    <span class="bt-left-brand-label">{{ $tr('GoExploria') }}</span>
                </div>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('SOLUTIONS BUSINESS & TOURISME') }}</h1>
                <p class="resto-header-subtitle">{{ $tr('Expertise commerciale et expériences touristiques pour les professionnels') }}</p>
                <div class="resto-dest-row bt-header-dest-row">
    <div class="resto-dest-icon-box">
        <img src="{{ asset('REDI.png') }}" alt="{{ $tr('Destinations') }}">
        <span>{{ $tr('Destinations') }}</span>
    </div>
    <div class="resto-dest-breadcrumb">
        <a href="#" class="resto-dest-link active">{{ $tr('Amérique du Nord') }}</a>
        <span class="resto-dest-sep">/</span>
        <a href="#" class="resto-dest-link">{{ $tr('Canada') }}</a>
        <span class="resto-dest-sep">/</span>
        <a href="#" class="resto-dest-link">{{ $tr('Québec') }}</a>
    </div>
</div>
            </div>
            <div class="resto-header-logo-right">
                <a href="https://goexploria.com" class="bt-more-btn" title="{{ $tr('En savoir plus') }}" target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-circle-info"></i>
                    <span>Go Next Level</span>
                </a>
            </div>
        </div>
    </div>

    {{-- CONTENU PRINCIPAL --}}
    <div class="bt-body">

        {{-- Duo Business / Tourisme --}}
        <div class="bt-dual-grid">

            {{-- CARTE BUSINESS --}}
            <div class="bt-card">
                <img style="width: 200px;margin-right: auto;margin-left: auto;" class="bt-icon-image" src="{{ asset('images/info-business.png') }}" alt="{{ $tr('Solutions Business') }}" loading="lazy">
                <div class="bt-card-top">
                    <!-- <div class="bt-icon-box bt-icon-image-box">
                        <img class="bt-icon-image" src="{{ asset('images/info-business.png') }}" alt="{{ $tr('Solutions Business') }}" loading="lazy">
                    </div> -->
                    <div>
                        <h2 class="bt-card-title">{{ $tr('SOLUTIONS WEB BUSINESS ') }}</h2>
                        <p class="bt-card-desc">{{ $tr('Stratégies sur mesure pour développer votre entreprise, optimiser vos processus et maximiser votre rentabilité sur le marché international.') }}</p>
                    </div>
                </div>
                <ul class="bt-features">
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Consultation stratégique et analyse de marché') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Développement de partenariats internationaux') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Optimisation des processus opérationnels') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Solutions digitales innovantes') }}</li>
                </ul>

                {{-- Carousel vidÃ©os Business --}}
                <div class="bt-carousel" data-videos='[
                    {"id":"xPPLbEFbCAo","title":"{{ $tr('Solutions Business GoExploria') }}"},
                    {"id":"xPPLbEFbCAo","title":"{{ $tr('Développement International') }}"}
                ]'>
                    <div class="bt-carousel-stage">
                        <img class="bt-carousel-preview" src="https://img.youtube.com/vi/xPPLbEFbCAo/maxresdefault.jpg" alt="{{ $tr('Solutions Business GoExploria') }}" data-videoid="xPPLbEFbCAo">
                        <button class="bt-carousel-play" aria-label="{{ $tr('Lire') }}"><i class="fas fa-play"></i></button>
                        <button class="bt-carousel-arrow bt-carousel-prev" aria-label="{{ $tr('Précédent') }}"><i class="fas fa-chevron-left"></i></button>
                        <button class="bt-carousel-arrow bt-carousel-next" aria-label="{{ $tr('Suivant') }}"><i class="fas fa-chevron-right"></i></button>
                        <div class="bt-carousel-counter"><span class="bt-carousel-cur">1</span> / <span class="bt-carousel-tot">2</span></div>
                        <div class="bt-carousel-title-bar">{{ $tr('Solutions Business GoExploria') }}</div>
                    </div>
                </div>

                <a href="#" class="bt-cta-btn bt-cta-primary">{{ $tr('DÉCOUVRIR NOS SOLUTIONS') }} <i class="fas fa-arrow-right"></i></a>
            </div>

            {{-- CARTE TOURISME --}}
            <div class="bt-card">
                <img style="width: 200px;margin-right: auto;margin-left: auto;" class="bt-icon-image" src="{{ asset('images/info-tourism.png') }}" alt="{{ $tr('Expériences Touristiques') }}" loading="lazy">

                <div class="bt-card-top">
                    <!-- <div class="bt-icon-box bt-icon-image-box">
                        <img class="bt-icon-image" src="{{ asset('images/info-tourism.png') }}" alt="{{ $tr('Expériences Touristiques') }}" loading="lazy">
                    </div> -->
                    <div>
                        <h2 class="bt-card-title">{{ $tr('SOLUTIONS WEB TOURISME') }}</h2>
                        <p class="bt-card-desc">{{ $tr('Voyages sur mesure combinant découvertes culturelles, aventures uniques et moments de détente pour les professionnels et leurs équipes.') }}</p>
                    </div>
                </div>
                <ul class="bt-features">
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Voyages d\'affaires sur mesure') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Retraites d\'entreprise en destinations exclusives') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Team-building aventure et culturel') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Circuits découverte pour partenaires') }}</li>
                </ul>

                {{-- Carousel vidÃ©os Tourisme --}}
                <div class="bt-carousel" data-videos='[
                    {"id":"xPPLbEFbCAo","title":"{{ $tr('Expériences Touristiques GoExploria') }}"},
                    {"id":"xPPLbEFbCAo","title":"{{ $tr('Découverte du Québec') }}"}
                ]'>
                    <div class="bt-carousel-stage">
                        <img class="bt-carousel-preview" src="https://img.youtube.com/vi/xPPLbEFbCAo/maxresdefault.jpg" alt="{{ $tr('Expériences Touristiques GoExploria') }}" data-videoid="xPPLbEFbCAo">
                        <button class="bt-carousel-play" aria-label="{{ $tr('Lire') }}"><i class="fas fa-play"></i></button>
                        <button class="bt-carousel-arrow bt-carousel-prev" aria-label="{{ $tr('Précédent') }}"><i class="fas fa-chevron-left"></i></button>
                        <button class="bt-carousel-arrow bt-carousel-next" aria-label="{{ $tr('Suivant') }}"><i class="fas fa-chevron-right"></i></button>
                        <div class="bt-carousel-counter"><span class="bt-carousel-cur">1</span> / <span class="bt-carousel-tot">2</span></div>
                        <div class="bt-carousel-title-bar">{{ $tr('Expériences Touristiques GoExploria') }}</div>
                    </div>
                </div>

                <a href="#" class="bt-cta-btn bt-cta-secondary">{{ $tr('EXPLORER NOS DESTINATIONS') }} <i class="fas fa-arrow-right"></i></a>
            </div>

        </div>

        {{-- STATS --}}
        <div class="bt-stats-grid">
            <div class="bt-stat-unit">
                <span class="bt-stat-number">250+</span>
                <span class="bt-stat-label">{{ $tr('Projets réalisés') }}</span>
            </div>
            <div class="bt-stat-unit">
                <span class="bt-stat-number">40</span>
                <span class="bt-stat-label">{{ $tr('Pays couverts') }}</span>
            </div>
            <div class="bt-stat-unit">
                <span class="bt-stat-number">98%</span>
                <span class="bt-stat-label">{{ $tr('Satisfaction') }}</span>
            </div>
            <div class="bt-stat-unit">
                <span class="bt-stat-number">15+</span>
                <span class="bt-stat-label">{{ $tr('Années d\'expérience') }}</span>
            </div>
        </div>

    </div>
</section>

<script>
(function () {
    function initBtCarousel(el) {
        var videos  = JSON.parse(el.dataset.videos || '[]');
        var stage   = el.querySelector('.bt-carousel-stage');
        var preview = el.querySelector('.bt-carousel-preview');
        var titleBar= el.querySelector('.bt-carousel-title-bar');
        var curEl   = el.querySelector('.bt-carousel-cur');
        var totEl   = el.querySelector('.bt-carousel-tot');
        var btnPrev = el.querySelector('.bt-carousel-prev');
        var btnNext = el.querySelector('.bt-carousel-next');
        var btnPlay = el.querySelector('.bt-carousel-play');
        var idx     = 0;

        if (!videos.length) return;
        totEl.textContent = videos.length;

        function goTo(n) {
            var iframe = stage.querySelector('iframe');
            if (iframe) {
                preview.style.display = '';
                btnPlay.style.display = '';
                btnPrev.style.display = '';
                btnNext.style.display = '';
                iframe.remove();
            }

            idx = (n + videos.length) % videos.length;
            var v = videos[idx];

            stage.classList.add('bt-carousel-fade');
            setTimeout(function () {
                preview.src = 'https://img.youtube.com/vi/' + v.id + '/maxresdefault.jpg';
                preview.alt = v.title;
                preview.dataset.videoid = v.id;
                titleBar.textContent = v.title;
                curEl.textContent = idx + 1;
                stage.classList.remove('bt-carousel-fade');
            }, 200);
        }

        function playActive() {
            var v = videos[idx];
            var iframe = document.createElement('iframe');
            iframe.src = 'https://www.youtube.com/embed/' + v.id + '?autoplay=1&rel=0';
            iframe.title = v.title;
            iframe.setAttribute('frameborder', '0');
            iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
            iframe.setAttribute('allowfullscreen', '');
            preview.style.display = 'none';
            btnPlay.style.display = 'none';
            btnPrev.style.display = 'none';
            btnNext.style.display = 'none';
            stage.appendChild(iframe);
        }

        btnPrev.addEventListener('click', function () { goTo(idx - 1); });
        btnNext.addEventListener('click', function () { goTo(idx + 1); });
        btnPlay.addEventListener('click', playActive);

        var touchX = 0;
        stage.addEventListener('touchstart', function (e) { touchX = e.touches[0].clientX; }, { passive: true });
        stage.addEventListener('touchend', function (e) {
            var diff = touchX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 40) goTo(diff > 0 ? idx + 1 : idx - 1);
        });
    }

    document.querySelectorAll('.bt-carousel').forEach(initBtCarousel);
})();
</script>

