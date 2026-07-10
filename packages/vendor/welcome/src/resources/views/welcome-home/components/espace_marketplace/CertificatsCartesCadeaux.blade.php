@php(ob_start());@endphp

{{-- ============================================================
     ESPACES CERTIFICATS-CARTES-PRODUITS CADEAUX
     Même logique visuelle/carousel que ProductsVedette
     ============================================================ --}}
@php
    $giftCategories = [
        'certificats' => ['label' => 'Certificats', 'icon' => 'fa-certificate'],
        'cartes'      => ['label' => 'Cartes cadeaux', 'icon' => 'fa-credit-card'],
        'coffrets'    => ['label' => 'Coffrets', 'icon' => 'fa-gift'],
        'experiences' => ['label' => 'Expériences', 'icon' => 'fa-ticket'],
        'entreprises' => ['label' => 'Entreprises', 'icon' => 'fa-briefcase'],
    ];

    $giftProducts = [
        ['cat' => 'certificats', 'img' => 'https://images.unsplash.com/photo-1607083206968-13611e3d76db?w=600&h=600&fit=crop', 'title' => 'Certificat GoExploria Découverte', 'brand' => 'GoExploria', 'price' => 50.00, 'old' => null, 'badge' => 'new', 'rating' => 5],
        ['cat' => 'certificats', 'img' => 'https://images.unsplash.com/photo-1513885535751-8b9238bd345a?w=600&h=600&fit=crop', 'title' => 'Certificat Weekend Destination', 'brand' => 'Destinations', 'price' => 150.00, 'old' => 180.00, 'badge' => 'promo', 'rating' => 5],
        ['cat' => 'certificats', 'img' => 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=600&h=600&fit=crop', 'title' => 'Certificat Premium Évasion', 'brand' => 'GoExploria', 'price' => 250.00, 'old' => null, 'badge' => 'hot', 'rating' => 5],
        ['cat' => 'certificats', 'img' => 'https://images.unsplash.com/photo-1607344645866-009c320b63e0?w=600&h=600&fit=crop', 'title' => 'Bon Cadeau Activités Locales', 'brand' => 'Expériences', 'price' => 75.00, 'old' => null, 'badge' => 'trending', 'rating' => 4],

        ['cat' => 'cartes', 'img' => 'https://images.unsplash.com/photo-1556742502-ec7c0e9f34b1?w=600&h=600&fit=crop', 'title' => 'Carte Cadeau Numérique', 'brand' => 'E-Gift', 'price' => 25.00, 'old' => null, 'badge' => 'new', 'rating' => 5],
        ['cat' => 'cartes', 'img' => 'https://images.unsplash.com/photo-1601597111158-2fceff292cdc?w=600&h=600&fit=crop', 'title' => 'Carte Cadeau Restaurant', 'brand' => 'Table & Saveurs', 'price' => 100.00, 'old' => null, 'badge' => 'hot', 'rating' => 5],
        ['cat' => 'cartes', 'img' => 'https://images.unsplash.com/photo-1579621970795-87facc2f976d?w=600&h=600&fit=crop', 'title' => 'Carte Cadeau Marketplace', 'brand' => 'Marketplace', 'price' => 125.00, 'old' => 150.00, 'badge' => 'promo', 'rating' => 4],
        ['cat' => 'cartes', 'img' => 'https://images.unsplash.com/photo-1556741533-411cf82e4e2d?w=600&h=600&fit=crop', 'title' => 'Carte Famille Aventures', 'brand' => 'GoExploria', 'price' => 200.00, 'old' => null, 'badge' => 'trending', 'rating' => 5],

        ['cat' => 'coffrets', 'img' => 'https://images.unsplash.com/photo-1512909006721-3d6018887383?w=600&h=600&fit=crop', 'title' => 'Coffret Terroir Québécois', 'brand' => 'Héritage', 'price' => 89.00, 'old' => 119.00, 'badge' => 'promo', 'rating' => 5],
        ['cat' => 'coffrets', 'img' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&h=600&fit=crop', 'title' => 'Panier Gourmand Signature', 'brand' => 'Saveurs locales', 'price' => 129.00, 'old' => null, 'badge' => 'hot', 'rating' => 5],
        ['cat' => 'coffrets', 'img' => 'https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?w=600&h=600&fit=crop', 'title' => 'Coffret Bien-être Nordique', 'brand' => 'Spa & Nature', 'price' => 159.00, 'old' => null, 'badge' => 'new', 'rating' => 4],
        ['cat' => 'coffrets', 'img' => 'https://images.unsplash.com/photo-1527529482837-4698179dc6ce?w=600&h=600&fit=crop', 'title' => 'Boîte Célébration VIP', 'brand' => 'Événements', 'price' => 199.00, 'old' => 249.00, 'badge' => 'promo', 'rating' => 5],

        ['cat' => 'experiences', 'img' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=600&h=600&fit=crop', 'title' => 'Expérience Nature & Plein Air', 'brand' => 'Aventures', 'price' => 110.00, 'old' => null, 'badge' => 'trending', 'rating' => 5],
        ['cat' => 'experiences', 'img' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600&h=600&fit=crop', 'title' => 'Séjour Hôtel Boutique', 'brand' => 'Hébergement', 'price' => 299.00, 'old' => 349.00, 'badge' => 'promo', 'rating' => 5],
        ['cat' => 'experiences', 'img' => 'https://images.unsplash.com/photo-1551218808-94e220e084d2?w=600&h=600&fit=crop', 'title' => 'Atelier Gastronomie Locale', 'brand' => 'Gourmand', 'price' => 95.00, 'old' => null, 'badge' => 'new', 'rating' => 4],
        ['cat' => 'experiences', 'img' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?w=600&h=600&fit=crop', 'title' => 'Billet Événement Vedette', 'brand' => 'Événements', 'price' => 65.00, 'old' => null, 'badge' => 'hot', 'rating' => 5],

        ['cat' => 'entreprises', 'img' => 'https://images.unsplash.com/photo-1556761175-b413da4baf72?w=600&h=600&fit=crop', 'title' => 'Pack Cadeaux Employés', 'brand' => 'Corporate', 'price' => 499.00, 'old' => null, 'badge' => 'hot', 'rating' => 5],
        ['cat' => 'entreprises', 'img' => 'https://images.unsplash.com/photo-1553729459-efe14ef6055d?w=600&h=600&fit=crop', 'title' => 'Cartes Cadeaux Entreprise x10', 'brand' => 'Corporate', 'price' => 750.00, 'old' => 850.00, 'badge' => 'promo', 'rating' => 5],
        ['cat' => 'entreprises', 'img' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=600&h=600&fit=crop', 'title' => 'Programme Fidélité Partenaires', 'brand' => 'GoExploria Pro', 'price' => 999.00, 'old' => null, 'badge' => 'trending', 'rating' => 5],
        ['cat' => 'entreprises', 'img' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=600&h=600&fit=crop', 'title' => 'Coffrets Clients Premium', 'brand' => 'Corporate', 'price' => 1200.00, 'old' => null, 'badge' => 'new', 'rating' => 5],
    ];

    $giftSlides = [
        [
            'main' => [
                'src'   => 'https://images.unsplash.com/photo-1513885535751-8b9238bd345a?w=900&h=500&fit=crop',
                'video' => 'M-2eAiU09qg',
                'title' => 'Certificats & cartes cadeaux GoExploria',
                'desc'  => 'Offrez des expériences locales, destinations, produits et moments mémorables',
                'badge' => 'new',
            ],
            'grid' => [
                ['src' => 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Certificats Premium', 'desc' => 'Bons cadeaux personnalisables', 'badge' => 'hot'],
                ['src' => 'https://images.unsplash.com/photo-1556742502-ec7c0e9f34b1?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Cartes numériques', 'desc' => 'Envoi rapide et simple', 'badge' => 'new'],
                ['src' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Coffrets terroir', 'desc' => 'Produits locaux et cadeaux gourmands', 'badge' => 'popular'],
                ['src' => 'https://images.unsplash.com/photo-1556761175-b413da4baf72?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Solutions entreprises', 'desc' => 'Cadeaux clients et employés', 'badge' => 'trending'],
            ],
        ],
        [
            'main' => [
                'src'   => 'https://images.unsplash.com/photo-1527529482837-4698179dc6ce?w=900&h=500&fit=crop',
                'video' => 'M-2eAiU09qg',
                'title' => 'Produits cadeaux pour toutes les occasions',
                'desc'  => 'Anniversaires, fêtes, événements, séjours, activités et coffrets personnalisés',
                'badge' => 'trending',
            ],
            'grid' => [
                ['src' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Expériences nature', 'desc' => 'Activités et plein air', 'badge' => 'hot'],
                ['src' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Séjours cadeaux', 'desc' => 'Hôtels et escapades', 'badge' => 'popular'],
                ['src' => 'https://images.unsplash.com/photo-1551218808-94e220e084d2?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Ateliers gourmands', 'desc' => 'Saveurs locales', 'badge' => 'new'],
                ['src' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?w=500&h=300&fit=crop', 'video' => 'M-2eAiU09qg', 'title' => 'Billets événements', 'desc' => 'Moments à partager', 'badge' => 'trending'],
            ],
        ],
    ];
@endphp

<section class="products-vedette-v2-section gifts-vedette-v2-section" id="certificats-cartes-cadeaux">
    <div class="products-vedette-v2-container">
        <div class="resto-header-block">
            <div class="resto-header-main">
                <div class="resto-header-logo-left">
                    <a href="#" class="resto-accord-btn" title="GoExploria cadeaux">
                        <div class="logo-wrapper">
                            <img loading="lazy" decoding="async" src="{{ asset('logo.png') }}" alt="GoExploria">
                        </div>
                        <span class="resto-accord-btn-label">GoExploria</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-external-link-alt"></i> Visiter
                        </span>
                    </a>
                </div>

                <div class="resto-header-center">
                    <h1 class="resto-header-title">ESPACES CERTIFICATS-CARTES-PRODUITS CADEAUX</h1>
                    <p class="resto-header-subtitle">
                        Certificats cadeaux · Cartes numériques · Coffrets terroir · Expériences locales · Cadeaux corporatifs.
                    </p>
                </div>

                <div class="resto-header-logo-right">
                    <a href="#" class="resto-accord-btn" title="Cadeaux GoExploria">
                        <div class="logo-wrapper">
                            <img loading="lazy" decoding="async" src="{{ asset('plan-n-go.png') }}" alt="Cadeaux GoExploria">
                        </div>
                        <span class="resto-accord-btn-label">Cadeaux</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-gift"></i> Offrir
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
                        <select id="gifts-continent-select" class="vp-dest-select" aria-label="Continent">
                            <option value="amerique-nord">Amérique du Nord</option>
                            <option value="europe">Europe</option>
                            <option value="afrique">Afrique</option>
                            <option value="asie">Asie</option>
                            <option value="amerique-sud">Amérique du Sud</option>
                            <option value="oceanie">Océanie</option>
                        </select>
                        <span class="resto-dest-sep">/</span>
                        <select id="gifts-country-select" class="vp-dest-select" aria-label="Pays">
                            <option value="canada">Canada</option>
                        </select>
                        <span class="resto-dest-sep">/</span>
                        <select id="gifts-province-select" class="vp-dest-select" aria-label="Province">
                            <option value="quebec">Québec</option>
                            <option value="ontario">Ontario</option>
                            <option value="alberta">Alberta</option>
                            <option value="colombie-britannique">Colombie-Britannique</option>
                            <option value="nouvelle-ecosse">Nouvelle-Écosse</option>
                        </select>
                        <span class="resto-dest-sep">/</span>
                        <select id="gifts-region-select" class="vp-dest-select" aria-label="Région">
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
                                <i class="fas fa-th-large"></i> Toutes catégories
                            </button>
                            @foreach($giftCategories as $key => $cat)
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
            <button class="vedette-carousel-btn vedette-carousel-prev" id="giftsCarouselPrev" aria-label="Précédent"><i class="fas fa-chevron-left"></i></button>
            <div class="products-vedette-v2-scroll-wrapper">
                <div class="products-vedette-v2-scroll-container" id="giftsVedetteGrid">
                    @foreach($giftProducts as $p)
                        <article class="products-vedette-v2-card"
                                 data-category="{{ $p['cat'] }}"
                                 data-badge="{{ $p['badge'] ?? '' }}">
                            <div class="products-vedette-v2-card-image">
                                <img src="{{ $p['img'] }}" alt="{{ $p['title'] }}" loading="lazy">

                                @if(!empty($p['badge']))
                                    <span class="products-vedette-v2-badge products-vedette-v2-badge--{{ $p['badge'] }}">
                                        @switch($p['badge'])
                                            @case('promo') <i class="fas fa-tag"></i> PROMO @break
                                            @case('new') <i class="fas fa-star"></i> NOUVEAU @break
                                            @case('hot') <i class="fas fa-fire"></i> HOT @break
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
                                    <span class="products-vedette-v2-card-reviews">({{ rand(18, 420) }})</span>
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
            <button class="vedette-carousel-btn vedette-carousel-next" id="giftsCarouselNext" aria-label="Suivant"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="vedette-carousel-progress"><div class="vedette-carousel-bar" id="giftsCarouselBar"></div></div>

        @include('welcome-home.components.MediaSlideshow', [
            'slideshowId' => 'giftsMedia',
            'slides' => $giftSlides,
        ])
    </div>
</section>

<style>
.gifts-vedette-v2-section .resto-header-title {
    color: #0f172a;
}
.gifts-vedette-v2-section .products-vedette-v2-card-image::after {
    background: linear-gradient(180deg, rgba(255,255,255,0) 42%, rgba(230,82,22,.16) 100%);
}
</style>

<script>
(function () {
    var wrapper = document.getElementById('giftsVedetteGrid');
    var section = wrapper ? wrapper.closest('section') : null;
    if (!wrapper || !section) return;

    var GAP = 20;
    var PAUSE = 3500;
    var ANIM = 480;
    var timer = null;
    var busy = false;

    function visibleCards() {
        return Array.from(wrapper.children).filter(function (card) {
            return card.style.display !== 'none';
        });
    }

    function resetBar() {
        var bar = document.getElementById('giftsCarouselBar');
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

    var prev = document.getElementById('giftsCarouselPrev');
    var next = document.getElementById('giftsCarouselNext');
    if (prev) prev.addEventListener('click', function () { stopAuto(); shiftRight(); startAuto(); });
    if (next) next.addEventListener('click', function () { stopAuto(); shiftLeft(); startAuto(); });

    section.querySelectorAll('.products-vedette-v2-filter-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            section.querySelectorAll('.products-vedette-v2-filter-btn').forEach(function (item) {
                item.classList.remove('active');
            });
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

    wrapper.querySelectorAll('.products-vedette-v2-fav').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.stopPropagation();
            var icon = button.querySelector('i');
            if (!icon) return;
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
            button.classList.toggle('is-active');
        });
    });
})();
</script>

@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
