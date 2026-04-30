{{-- SpecializedSpacesSection — GoExploria Espaces spécialisés --}}
@php(ob_start());@endphp
<section class="immo-v2-section" id="specialized-spaces-section">

    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="{{ route('pages.chalet-rental-detail') }}" class="resto-accord-btn" title="GoExploria">
                    <div class="logo-wrapper">
                        <img src="{{ asset('logo.png') }}" alt="GoExploria">
                    </div>
                    <span class="resto-accord-btn-label">GoExploria</span>
                    <span class="resto-accord-btn-cta">
                        <i class="fas fa-external-link-alt"></i> Visiter
                    </span>
                </a>
            </div>
            <div class="resto-header-center">
                <h2 class="resto-header-title">ESPACES SPÉCIALISÉS</h2>
                <p class="resto-header-subtitle">
                    Sélection d'espaces immobiliers au Québec pour investir, habiter et développer vos projets touristiques.
                </p>
                <div class="resto-header-tabs" role="tablist" aria-label="Catégories espaces spécialisés">
                    <button class="resto-tab-btn active" role="tab" data-filter="all">
                        <i class="fas fa-th-large"></i> Tous les espaces
                    </button>
                    <button class="resto-tab-btn" role="tab" data-filter="chalet">
                        <i class="fas fa-mountain"></i> Chalets
                    </button>
                    <button class="resto-tab-btn" role="tab" data-filter="projet">
                        <i class="fas fa-city"></i> Projets touristiques
                    </button>
                    <a href="{{ route('pages.chalet-rental-detail') }}" class="immo-header-more-btn">
                        Voir plus <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="resto-header-logo-right">
                <a href="{{ route('pages.chalet-rental-detail') }}" class="resto-accord-btn" title="Plans Web Go">
                    <div class="logo-wrapper">
                        <img src="{{ asset('plan-n-go.png') }}" alt="Plans Web Go">
                    </div>
                    <span class="resto-accord-btn-label">Plans Web Go</span>
                    <span class="resto-accord-btn-cta">
                        <i class="fas fa-external-link-alt"></i> Visiter
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
                <div class="resto-dest-breadcrumb">
                    <a href="{{ route('pages.chalet-rental-detail') }}" class="resto-dest-link active">Québec</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="{{ route('pages.chalet-rental-detail') }}" class="resto-dest-link">Espaces spécialisés</a>
                </div>
            </div>
        </div>
    </div>

    <div class="immo-v2-container">
        <div class="immo-v2-grid">
            <article class="immo-v2-card">
                <div class="immo-v2-card-img">
                    <img src="https://images.unsplash.com/photo-1464146072230-91cabc968266?w=1200&auto=format&fit=crop&q=70" alt="Espace Immo Québec">
                    <span class="immo-v2-img-badge">Québec</span>
                </div>
                <div class="immo-v2-card-content">
                    <div class="immo-v2-price">À partir de 420 000 CAD</div>
                    <h3 class="immo-v2-card-title">ESPACE IMMO QUÉBEC</h3>
                    <div class="immo-v2-location"><i class="fas fa-map-pin"></i> Québec, Capitale-Nationale</div>
                    <div class="immo-v2-features">
                        <span class="immo-v2-feature-item"><i class="fas fa-ruler-combined"></i> 140 m²</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-bed"></i> 3 chambres</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-car"></i> 2 stationnements</span>
                    </div>
                    <a href="{{ route('pages.chalet-rental-detail') }}" class="immo-v2-btn">Voir le détail <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>

            <article class="immo-v2-card">
                <div class="immo-v2-card-img">
                    <img src="https://images.unsplash.com/photo-1449158743715-0a90ebb6d2d8?w=1200&auto=format&fit=crop&q=70" alt="Espaces chalets à vendre">
                    <span class="immo-v2-img-badge">Nature</span>
                </div>
                <div class="immo-v2-card-content">
                    <div class="immo-v2-price">À partir de 289 000 CAD</div>
                    <h3 class="immo-v2-card-title">ESPACES CHALETS À VENDRE</h3>
                    <div class="immo-v2-location"><i class="fas fa-map-pin"></i> Charlevoix, Québec</div>
                    <div class="immo-v2-features">
                        <span class="immo-v2-feature-item"><i class="fas fa-ruler-combined"></i> 95 m²</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-bed"></i> 2 chambres</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-tree"></i> Terrain boisé</span>
                    </div>
                    <a href="{{ route('pages.chalet-rental-lac-azur') }}" class="immo-v2-btn">Voir le détail <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>

            <article class="immo-v2-card">
                <div class="immo-v2-card-img">
                    <img src="https://images.unsplash.com/photo-1572120360610-d971b9d7767c?w=1200&auto=format&fit=crop&q=70" alt="Espaces maisons chalets à vendre">
                    <span class="immo-v2-img-badge">Famille</span>
                </div>
                <div class="immo-v2-card-content">
                    <div class="immo-v2-price">À partir de 510 000 CAD</div>
                    <h3 class="immo-v2-card-title">ESPACES MAISONS CHALETS À VENDRE</h3>
                    <div class="immo-v2-location"><i class="fas fa-map-pin"></i> Laurentides, Québec</div>
                    <div class="immo-v2-features">
                        <span class="immo-v2-feature-item"><i class="fas fa-ruler-combined"></i> 175 m²</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-bed"></i> 4 chambres</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-water"></i> Vue sur lac</span>
                    </div>
                    <a href="{{ route('pages.maison-forestiere-eclipse') }}" class="immo-v2-btn">Voir le détail <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>

            <article class="immo-v2-card">
                <div class="immo-v2-card-img">
                    <img src="https://images.unsplash.com/photo-1487958449943-2429e8be8625?w=1200&auto=format&fit=crop&q=70" alt="Espaces projet immobilier touristique">
                    <span class="immo-v2-img-badge">Investissement</span>
                </div>
                <div class="immo-v2-card-content">
                    <div class="immo-v2-price">À partir de 1 250 000 CAD</div>
                    <h3 class="immo-v2-card-title">ESPACES PROJET IMMOBILIER TOURISTIQUE</h3>
                    <div class="immo-v2-location"><i class="fas fa-map-pin"></i> Mont-Tremblant, Québec</div>
                    <div class="immo-v2-features">
                        <span class="immo-v2-feature-item"><i class="fas fa-ruler-combined"></i> 420 m²</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-building"></i> 8 unités</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-chart-line"></i> Fort potentiel locatif</span>
                    </div>
                    <a href="{{ route('pages.projet-touristique-boreal') }}" class="immo-v2-btn">Voir le détail <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>
        </div>
    </div>
</section>
@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
