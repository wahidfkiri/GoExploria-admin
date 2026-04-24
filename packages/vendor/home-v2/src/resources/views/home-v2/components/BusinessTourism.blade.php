{{-- Business & Tourism Component --}}
<section class="bt-section" id="business-tourism">

    {{-- EN-TÊTE STANDARD --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="GoExploria">
                    <div class="logo-wrapper"><img src="{{ asset('logo.png') }}" alt="GoExploria"></div>
                    <span class="resto-accord-btn-label">GoExploria</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-external-link-alt"></i> Visiter</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">SOLUTIONS BUSINESS &amp; TOURISME</h1>
                <p class="resto-header-subtitle">Expertise commerciale et expériences touristiques pour les professionnels</p>
                <div class="resto-header-tabs">
                    <button class="resto-tab-btn active"><i class="fas fa-chart-line"></i>ESPACE BUSINESS</button>
                    <button class="resto-tab-btn"><i class="fas fa-globe-americas"></i>ESPACE TOURISME</button>
                    <button class="resto-tab-btn"><i class="fas fa-handshake"></i>ESPACE PARTENAIRES</button>
                </div>
            </div>
            <div class="resto-header-logo-right">
                <a href="#" class="resto-accord-btn" title="Partenariats">
                    <div class="logo-wrapper"><img src="{{ asset('REDI.png') }}" alt="Partenariats"></div>
                    <span class="resto-accord-btn-label">Partenariats</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-external-link-alt"></i> Découvrir</span>
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
                <div class="bt-card-top">
                    <div class="bt-icon-box"><i class="fas fa-chart-line"></i></div>
                    <div>
                        <h2 class="bt-card-title">Solutions Business</h2>
                        <p class="bt-card-desc">Stratégies sur mesure pour développer votre entreprise, optimiser vos processus et maximiser votre rentabilité sur le marché international.</p>
                    </div>
                </div>
                <ul class="bt-features">
                    <li><i class="fas fa-check-circle"></i> Consultation stratégique et analyse de marché</li>
                    <li><i class="fas fa-check-circle"></i> Développement de partenariats internationaux</li>
                    <li><i class="fas fa-check-circle"></i> Optimisation des processus opérationnels</li>
                    <li><i class="fas fa-check-circle"></i> Solutions digitales innovantes</li>
                </ul>

                {{-- Carousel vidéos Business --}}
                <div class="bt-carousel" data-videos='[
                    {"id":"xPPLbEFbCAo","title":"Solutions Business GoExploria"},
                    {"id":"xPPLbEFbCAo","title":"Développement International"}
                ]'>
                    <div class="bt-carousel-stage">
                        <img class="bt-carousel-preview" src="https://img.youtube.com/vi/xPPLbEFbCAo/maxresdefault.jpg" alt="Solutions Business GoExploria" data-videoid="xPPLbEFbCAo">
                        <button class="bt-carousel-play" aria-label="Lire"><i class="fas fa-play"></i></button>
                        <button class="bt-carousel-arrow bt-carousel-prev" aria-label="Précédent"><i class="fas fa-chevron-left"></i></button>
                        <button class="bt-carousel-arrow bt-carousel-next" aria-label="Suivant"><i class="fas fa-chevron-right"></i></button>
                        <div class="bt-carousel-counter"><span class="bt-carousel-cur">1</span> / <span class="bt-carousel-tot">2</span></div>
                        <div class="bt-carousel-title-bar">Solutions Business GoExploria</div>
                    </div>
                </div>

                <a href="#" class="bt-cta-btn bt-cta-primary">DÉCOUVRIR NOS SOLUTIONS <i class="fas fa-arrow-right"></i></a>
            </div>

            {{-- CARTE TOURISME --}}
            <div class="bt-card">
                <div class="bt-card-top">
                    <div class="bt-icon-box bt-icon-tourisme"><i class="fas fa-globe-americas"></i></div>
                    <div>
                        <h2 class="bt-card-title">Expériences Touristiques</h2>
                        <p class="bt-card-desc">Voyages sur mesure combinant découvertes culturelles, aventures uniques et moments de détente pour les professionnels et leurs équipes.</p>
                    </div>
                </div>
                <ul class="bt-features">
                    <li><i class="fas fa-check-circle"></i> Voyages d'affaires sur mesure</li>
                    <li><i class="fas fa-check-circle"></i> Retraites d'entreprise en destinations exclusives</li>
                    <li><i class="fas fa-check-circle"></i> Team-building aventure et culturel</li>
                    <li><i class="fas fa-check-circle"></i> Circuits découverte pour partenaires</li>
                </ul>

                {{-- Carousel vidéos Tourisme --}}
                <div class="bt-carousel" data-videos='[
                    {"id":"xPPLbEFbCAo","title":"Expériences Touristiques GoExploria"},
                    {"id":"xPPLbEFbCAo","title":"Découverte du Québec"}
                ]'>
                    <div class="bt-carousel-stage">
                        <img class="bt-carousel-preview" src="https://img.youtube.com/vi/xPPLbEFbCAo/maxresdefault.jpg" alt="Expériences Touristiques GoExploria" data-videoid="xPPLbEFbCAo">
                        <button class="bt-carousel-play" aria-label="Lire"><i class="fas fa-play"></i></button>
                        <button class="bt-carousel-arrow bt-carousel-prev" aria-label="Précédent"><i class="fas fa-chevron-left"></i></button>
                        <button class="bt-carousel-arrow bt-carousel-next" aria-label="Suivant"><i class="fas fa-chevron-right"></i></button>
                        <div class="bt-carousel-counter"><span class="bt-carousel-cur">1</span> / <span class="bt-carousel-tot">2</span></div>
                        <div class="bt-carousel-title-bar">Expériences Touristiques GoExploria</div>
                    </div>
                </div>

                <a href="#" class="bt-cta-btn bt-cta-secondary">EXPLORER NOS DESTINATIONS <i class="fas fa-arrow-right"></i></a>
            </div>

        </div>

        {{-- STATS --}}
        <div class="bt-stats-grid">
            <div class="bt-stat-unit">
                <span class="bt-stat-number">250+</span>
                <span class="bt-stat-label">Projets réalisés</span>
            </div>
            <div class="bt-stat-unit">
                <span class="bt-stat-number">40</span>
                <span class="bt-stat-label">Pays couverts</span>
            </div>
            <div class="bt-stat-unit">
                <span class="bt-stat-number">98%</span>
                <span class="bt-stat-label">Satisfaction</span>
            </div>
            <div class="bt-stat-unit">
                <span class="bt-stat-number">15+</span>
                <span class="bt-stat-label">Années d'expérience</span>
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
            /* Arrêter une éventuelle lecture en cours */
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

        /* Swipe tactile */
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

