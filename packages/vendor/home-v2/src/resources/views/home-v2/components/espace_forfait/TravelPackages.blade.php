@php(ob_start());@endphp
@php
/* ================================================================
   TravelPackages — données configurables
================================================================ */
$pkgConfig = [
    'title'    => 'AFFICHEZ VOS FORFAITS ICI',
    'subtitle' => 'Québec · Canada · Amérique du Nord — Découvrez les plus belles destinations sublimées par l\'expertise GoExploria.',
    'logo_left'  => ['src' => asset('logo.png'),      'alt' => 'GoExploria',       'label' => 'GoExploria',      'href' => '#'],
    'logo_right' => ['src' => asset('plan-n-go.png'), 'alt' => 'Forfaits Voyages', 'label' => 'Forfaits Voyages','href' => '#'],
];

$pkgQuebec = [
    [
        'img'      => 'https://images.pexels.com/photos/2499786/pexels-photo-2499786.jpeg?auto=compress&cs=tinysrgb&w=800&h=500&dpr=1',
        'badge'    => 'POPULAIRE', 'badge_cls' => 'pkg-badge--popular',
        'title'    => 'Escapade Montréal & Québec', 'price' => '$1 899',
        'location' => 'Montréal, Québec',
        'desc'     => 'Séjour de 5 jours dans les plus belles villes du Québec. Visites guidées, gastronomie locale et hébergement 4 étoiles inclus.',
        'features' => ['Culture', 'Gastronomie', 'Histoire'], 'category' => 'escapades',
    ],
    [
        'img'      => 'https://images.pexels.com/photos/4276490/pexels-photo-4276490.jpeg?auto=compress&cs=tinysrgb&w=800&h=500&dpr=1',
        'badge'    => 'NOUVEAU', 'badge_cls' => 'pkg-badge--new',
        'title'    => 'Aventure Gaspésie', 'price' => '$2 199',
        'location' => 'Gaspé, Québec',
        'desc'     => 'Parc national Forillon, observation des baleines, randonnée et découverte du Rocher Percé.',
        'features' => ['Nature', 'Aventure', 'Faune'], 'category' => 'escapades',
    ],
    [
        'img'      => 'https://images.pexels.com/photos/848599/pexels-photo-848599.jpeg?auto=compress&cs=tinysrgb&w=800&h=500&dpr=1',
        'badge'    => 'LUXE', 'badge_cls' => 'pkg-badge--luxe',
        'title'    => 'Ski & Spa Charlevoix', 'price' => '$2 499',
        'location' => 'Charlevoix, Québec',
        'desc'     => 'Forfait ski dans les Laurentides avec hébergement luxueux et accès au spa nordique.',
        'features' => ['Sport', 'Bien-être', 'Luxe'], 'category' => 'promotions',
    ],
];

$pkgEurope = [
    [
        'img'      => 'https://images.pexels.com/photos/338515/pexels-photo-338515.jpeg?auto=compress&cs=tinysrgb&w=800&h=500&dpr=1',
        'badge'    => 'COUPLE', 'badge_cls' => 'pkg-badge--couple',
        'title'    => 'Romantique Paris', 'price' => '$2 899',
        'location' => 'Paris, France',
        'desc'     => 'Week-end romantique à Paris avec croisière sur la Seine, dîner gastronomique et visite des monuments emblématiques.',
        'features' => ['Romantique', 'Culture', 'Gastronomie'], 'category' => 'voyages',
    ],
    [
        'img'      => 'https://images.pexels.com/photos/1571442/pexels-photo-1571442.jpeg?auto=compress&cs=tinysrgb&w=800&h=500&dpr=1',
        'badge'    => 'EXCLUSIF', 'badge_cls' => 'pkg-badge--exclusif',
        'title'    => 'Route des Vins Toscane', 'price' => '$3 299',
        'location' => 'Toscane, Italie',
        'desc'     => 'Circuit œnologique dans les plus beaux domaines viticoles toscans. Dégustations, ateliers et hébergement dans un agriturismo.',
        'features' => ['Vin', 'Gastronomie', 'Détente'], 'category' => 'voyages',
    ],
    [
        'img'      => 'https://images.pexels.com/photos/1933239/pexels-photo-1933239.jpeg?auto=compress&cs=tinysrgb&w=800&h=500&dpr=1',
        'badge'    => 'INCONTOURNABLE', 'badge_cls' => 'pkg-badge--top',
        'title'    => 'Aurores Boréales Islande', 'price' => '$3 999',
        'location' => 'Reykjavik, Islande',
        'desc'     => 'Chasse aux aurores boréales, bains géothermiques et découverte des paysages lunaires islandais.',
        'features' => ['Aventure', 'Nordique', 'Photographie'], 'category' => 'promotions',
    ],
];
@endphp

<section class="pkg-section" id="forfaits-voyages">
<div class="page6-wrapper">

    {{-- ============================================================
         EN-TÊTE STANDARD — même layout que EventsVedette
    ============================================================ --}}
    <div class="resto-header-block">

        <div class="resto-header-main">

            {{-- Logo gauche : GoExploria --}}
            <div class="resto-header-logo-left">
                <a href="{{ $pkgConfig['logo_left']['href'] }}" class="resto-accord-btn" title="{{ $pkgConfig['logo_left']['label'] }}">
                    <div class="logo-wrapper">
                        <img src="{{ $pkgConfig['logo_left']['src'] }}" alt="{{ $pkgConfig['logo_left']['alt'] }}">
                    </div>
                    <span class="resto-accord-btn-label">{{ $pkgConfig['logo_left']['label'] }}</span>
                    <span class="resto-accord-btn-cta">
                        <i class="fas fa-external-link-alt"></i> Visiter
                    </span>
                </a>
            </div>

            {{-- Centre : titre + sous-titre + onglets navigation --}}
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $pkgConfig['title'] }}</h1>
                <p class="resto-header-subtitle">{{ $pkgConfig['subtitle'] }}</p></div>

            {{-- Logo droit : Forfaits Voyages --}}
            
            <div class="resto-header-logo-right">
                
                <a href="{{url('forfaits-voyages')}}" title="En savoir plus" target="_blank" rel="noopener noreferrer">
                    <!-- <i class="fas fa-circle-info"></i>
                    <span>Go Next Level</span> -->
                    <img
                    class="bt-next-level-image"
                    src="{{ asset('images/Next-level.png') }}"
                    alt="Next Level"
                    loading="lazy"
                >
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
                    <div class="pkg-filters">
                        <button class="pkg-filter-btn active" data-filter="all">
                            <i class="fas fa-th-large"></i> Toutes les options
                        </button>
                        <button class="pkg-filter-btn" data-filter="escapades">
                            <i class="fas fa-route"></i> Escapades
                        </button>
                        <button class="pkg-filter-btn" data-filter="voyages">
                            <i class="fas fa-plane"></i> Voyages
                        </button>
                        <button class="pkg-filter-btn" data-filter="promotions">
                            <i class="fas fa-tag"></i> Promotions
                        </button>
                    </div>
                    <a href="#" class="resto-cta-btn secondary">
                        En savoir <span class="cta-plus">+</span>
                    </a>
                </div>
            </div>

        </div>

        <div class="resto-header-shimmer"></div>
    </div>{{-- /.resto-header-block --}}

    {{-- ============================================================
         CONTENU FORFAITS
    ============================================================ --}}
    <div class="pkg-content-area">

        {{-- â”€â”€ Forfaits Québec â”€â”€ --}}
        <div class="pkg-category-section" id="pkg-quebec">
            <div class="pkg-category-header">
                <div class="pkg-cat-icon pkg-cat-icon--quebec">
                    <i class="fas fa-maple-leaf"></i>
                </div>
                <div class="pkg-cat-titles">
                    <h2 class="pkg-category-title">Forfaits Québec</h2>
                    <p class="pkg-category-subtitle">Découvrez la Belle Province</p>
                </div>
                <span class="pkg-category-count">{{ count($pkgQuebec) }} forfaits</span>
            </div>

            <div class="packages-grid" id="pkg-grid-quebec">
                @foreach($pkgQuebec as $pkg)
                <article class="package-card" data-filter="{{ $pkg['category'] }}">
                    <div class="package-image">
                        <img src="{{ $pkg['img'] }}" alt="{{ $pkg['title'] }}" loading="lazy">
                        <div class="package-badge {{ $pkg['badge_cls'] }}">{{ $pkg['badge'] }}</div>
                    </div>
                    <div class="package-content">
                        <div class="package-header">
                            <h3>{{ $pkg['title'] }}</h3>
                            <div class="package-price">{{ $pkg['price'] }}<span>/pers.</span></div>
                        </div>
                        <div class="package-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $pkg['location'] }}</span>
                        </div>
                        <p class="package-description">{{ $pkg['desc'] }}</p>
                        <div class="package-features">
                            @foreach($pkg['features'] as $feat)
                            <div class="feature"><i class="fas fa-check"></i> {{ $feat }}</div>
                            @endforeach
                        </div>
                        <a href="#" class="pkg-btn-primary">
                            <i class="fas fa-calendar-check"></i>
                            Voir le forfait
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>

        {{-- â”€â”€ Forfaits Europe â”€â”€ --}}
        <div class="pkg-category-section" id="pkg-europe">
            <div class="pkg-category-header">
                <div class="pkg-cat-icon pkg-cat-icon--europe">
                    <i class="fas fa-globe-europe"></i>
                </div>
                <div class="pkg-cat-titles">
                    <h2 class="pkg-category-title">Forfaits Europe</h2>
                    <p class="pkg-category-subtitle">Voyagez à travers l'Europe</p>
                </div>
                <span class="pkg-category-count">{{ count($pkgEurope) }} forfaits</span>
            </div>

            <div class="packages-grid" id="pkg-grid-europe">
                @foreach($pkgEurope as $pkg)
                <article class="package-card" data-filter="{{ $pkg['category'] }}">
                    <div class="package-image">
                        <img src="{{ $pkg['img'] }}" alt="{{ $pkg['title'] }}" loading="lazy">
                        <div class="package-badge {{ $pkg['badge_cls'] }}">{{ $pkg['badge'] }}</div>
                    </div>
                    <div class="package-content">
                        <div class="package-header">
                            <h3>{{ $pkg['title'] }}</h3>
                            <div class="package-price">{{ $pkg['price'] }}<span>/pers.</span></div>
                        </div>
                        <div class="package-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $pkg['location'] }}</span>
                        </div>
                        <p class="package-description">{{ $pkg['desc'] }}</p>
                        <div class="package-features">
                            @foreach($pkg['features'] as $feat)
                            <div class="feature"><i class="fas fa-check"></i> {{ $feat }}</div>
                            @endforeach
                        </div>
                        <a href="#" class="pkg-btn-primary">
                            <i class="fas fa-calendar-check"></i>
                            Voir le forfait
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>

        {{-- â”€â”€ Showcase compact â”€â”€ --}}
        <section class="showcase-packages">
            <div class="showcase-header">
                <h2>Afficher vos forfaits ici</h2>
                <p>Découvrez tous nos forfaits exclusifs en un coup d'œil</p>
            </div>
            <div class="showcase-grid">
                @foreach($pkgQuebec as $pkg)
                <div class="showcase-item">
                    <span class="showcase-badge quebec"><i class="fas fa-maple-leaf"></i> Québec</span>
                    <h4>{{ $pkg['title'] }}</h4>
                    <p>{{ \Illuminate\Support\Str::limit($pkg['desc'], 70) }}</p>
                    <div class="showcase-item-footer">
                        <div class="showcase-price">{{ $pkg['price'] }}<span>/pers.</span></div>
                        <a href="#" class="showcase-details-btn"><i class="fas fa-eye"></i> Voir détails</a>
                    </div>
                </div>
                @endforeach
                @foreach($pkgEurope as $pkg)
                <div class="showcase-item">
                    <span class="showcase-badge europe"><i class="fas fa-globe-europe"></i> Europe</span>
                    <h4>{{ $pkg['title'] }}</h4>
                    <p>{{ \Illuminate\Support\Str::limit($pkg['desc'], 70) }}</p>
                    <div class="showcase-item-footer">
                        <div class="showcase-price">{{ $pkg['price'] }}<span>/pers.</span></div>
                        <a href="#" class="showcase-details-btn"><i class="fas fa-eye"></i> Voir détails</a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        {{-- â”€â”€ Création de forfait â”€â”€ --}}
        <section class="creation-section">
            <div class="creation-card">
                <div class="creation-info">
                    <div class="creation-slider" id="creationSlider">
                        <div class="creation-slide active">
                            <img src="https://images.pexels.com/photos/2325446/pexels-photo-2325446.jpeg?auto=compress&cs=tinysrgb&w=600&h=360&dpr=1" alt="Destinations">
                        </div>
                        <div class="creation-slide">
                            <img src="https://images.pexels.com/photos/3155666/pexels-photo-3155666.jpeg?auto=compress&cs=tinysrgb&w=600&h=360&dpr=1" alt="Voyages en couple">
                        </div>
                        <div class="creation-slide">
                            <img src="https://images.pexels.com/photos/1371360/pexels-photo-1371360.jpeg?auto=compress&cs=tinysrgb&w=600&h=360&dpr=1" alt="Aventures">
                        </div>
                        <div class="creation-slide-dots">
                            <span class="creation-dot active" data-slide="0"></span>
                            <span class="creation-dot" data-slide="1"></span>
                            <span class="creation-dot" data-slide="2"></span>
                        </div>
                    </div>
                    <h3>Créez votre forfait personnalisé</h3>
                    <p>Composez le voyage de vos rêves en quelques clics. Sélectionnez vos destinations, activités et hébergements préférés.</p>
                    <ul class="features-list">
                        <li><i class="fas fa-check-circle"></i> Choix illimité de destinations</li>
                        <li><i class="fas fa-check-circle"></i> Activités sur mesure</li>
                        <li><i class="fas fa-check-circle"></i> Hébergements premium</li>
                        <li><i class="fas fa-check-circle"></i> Devis instantané</li>
                        <li><i class="fas fa-check-circle"></i> Support personnalisé 24/7</li>
                    </ul>
                </div>
                <div class="creation-form">
                    <h3>Nouveau forfait</h3>
                    <form id="package-creation-form">
                        <div class="pkg-form-group">
                            <label for="pkg-title">Titre du forfait</label>
                            <input type="text" id="pkg-title" placeholder="Ex: Escapade à Montréal">
                        </div>
                        <div class="pkg-form-group">
                            <label for="pkg-cat">Catégorie</label>
                            <select id="pkg-cat">
                                <option value="">Sélectionnez une catégorie</option>
                                <option value="quebec">Québec</option>
                                <option value="europe">Europe</option>
                            </select>
                        </div>
                        <div class="pkg-form-group">
                            <label for="pkg-dest">Destination</label>
                            <input type="text" id="pkg-dest" placeholder="Ville, Pays">
                        </div>
                        <div class="pkg-form-group">
                            <label for="pkg-price-input">Prix (par personne)</label>
                            <input type="number" id="pkg-price-input" placeholder="1899">
                        </div>
                        <div class="pkg-form-group">
                            <label for="pkg-desc">Description</label>
                            <textarea id="pkg-desc" placeholder="Décrivez votre forfait..."></textarea>
                        </div>
                        <button type="submit" class="btn-create">
                            <i class="fas fa-magic"></i>
                            Créer le forfait
                        </button>
                    </form>
                </div>
            </div>
        </section>

    </div>{{-- /.pkg-content-area --}}

</div>{{-- /.page6-wrapper --}}
</section>

<script>
(function () {
    var section = document.getElementById('forfaits-voyages');
    if (!section) return;

    section.querySelectorAll('.pkg-filter-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            section.querySelectorAll('.pkg-filter-btn').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            var filter = btn.getAttribute('data-filter') || 'all';
            section.querySelectorAll('.package-card').forEach(function (card) {
                var cat = card.getAttribute('data-filter') || '';
                card.style.display = (filter === 'all' || cat === filter) ? '' : 'none';
            });
        });
    });

    var form = document.getElementById('package-creation-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            alert('✓ Forfait créé avec succès ! (Mode démonstration)');
        });
    }

    // Slider section création
    var slider = document.getElementById('creationSlider');
    if (slider) {
        var slides = slider.querySelectorAll('.creation-slide');
        var dots   = slider.querySelectorAll('.creation-dot');
        var cur = 0;
        function goTo(i) {
            slides[cur].classList.remove('active');
            dots[cur].classList.remove('active');
            cur = (i + slides.length) % slides.length;
            slides[cur].classList.add('active');
            dots[cur].classList.add('active');
        }
        dots.forEach(function (dot) {
            dot.addEventListener('click', function () { goTo(parseInt(dot.dataset.slide)); });
        });
        setInterval(function () { goTo(cur + 1); }, 3500);
    }
})();
</script>
@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
