@php(ob_start());@endphp

{{-- Restaurants Vedette Component - Restaurants vedette --}}
<section class="restaurants-vedette-v2-section">
    <div class="restaurants-vedette-v2-container">
        {{-- Header avec titre et bouton sur même ligne --}}
        {{-- Header avec filtre à gauche, titre au centre et bouton à droite --}}
        <div class="restaurants-vedette-v2-header">
            <h2 class="restaurants-vedette-v2-title">RESTAURANTS VEDETTES</h2>
            
            <div class="restaurants-vedette-v2-header-controls">
                <div class="restaurants-vedette-v2-filters">
                    <span class="filter-label">Filtre par région :</span>
                    <button class="restaurants-vedette-v2-filter-btn active" data-filter="all">Tout</button>
                    <button class="restaurants-vedette-v2-filter-btn" data-filter="montreal">Montréal</button>
                    <button class="restaurants-vedette-v2-filter-btn" data-filter="quebec">Québec</button>
                </div>

                <button class="restaurants-vedette-v2-more-btn">
                    En savoir <span class="restaurants-vedette-v2-plus-icon">+</span>
                </button>
            </div>
        </div>

        {{-- Scroll horizontal des restaurants --}}
        <div class="restaurants-vedette-v2-scroll-wrapper">
            <div class="restaurants-vedette-v2-scroll-container" id="restaurantsVedetteGrid">
            {{-- Restaurant Card 1 --}}
            <article class="restaurants-vedette-v2-card">
                <div class="restaurants-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&h=400&fit=crop" alt="Le Saint-Amour">
                    <div class="restaurants-vedette-v2-card-badge">
                        <span class="restaurants-vedette-v2-badge-text">Gastronomique</span>
                    </div>
                </div>
                <div class="restaurants-vedette-v2-card-content">
                    <h3 class="restaurants-vedette-v2-card-title">Le Saint-Amour</h3>
                    <p class="restaurants-vedette-v2-card-description">
                        Cuisine française raffinée dans un cadre romantique avec jardin intérieur.
                    </p>
                    <div class="restaurants-vedette-v2-card-footer">
                        <span class="restaurants-vedette-v2-card-location">Québec</span>
                        <div class="restaurants-vedette-v2-card-rating">
                            ⭐⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
            </article>

            {{-- Restaurant Card 2 --}}
            <article class="restaurants-vedette-v2-card">
                <div class="restaurants-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600&h=400&fit=crop" alt="Joe Beef">
                    <div class="restaurants-vedette-v2-card-badge">
                        <span class="restaurants-vedette-v2-badge-text">Bistro</span>
                    </div>
                </div>
                <div class="restaurants-vedette-v2-card-content">
                    <h3 class="restaurants-vedette-v2-card-title">Joe Beef</h3>
                    <p class="restaurants-vedette-v2-card-description">
                        Bistro montréalais emblématique, cuisine du marché et ambiance conviviale.
                    </p>
                    <div class="restaurants-vedette-v2-card-footer">
                        <span class="restaurants-vedette-v2-card-location">Montréal</span>
                        <div class="restaurants-vedette-v2-card-rating">
                            ⭐⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
            </article>

            {{-- Restaurant Card 3 --}}
            <article class="restaurants-vedette-v2-card">
                <div class="restaurants-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=600&h=400&fit=crop" alt="Toqué!">
                    <div class="restaurants-vedette-v2-card-badge">
                        <span class="restaurants-vedette-v2-badge-text">Fine Dining</span>
                    </div>
                </div>
                <div class="restaurants-vedette-v2-card-content">
                    <h3 class="restaurants-vedette-v2-card-title">Toqué!</h3>
                    <p class="restaurants-vedette-v2-card-description">
                        Restaurant gastronomique de renommée internationale, produits du Québec.
                    </p>
                    <div class="restaurants-vedette-v2-card-footer">
                        <span class="restaurants-vedette-v2-card-location">Montréal</span>
                        <div class="restaurants-vedette-v2-card-rating">
                            ⭐⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
            </article>

            {{-- Restaurant Card 4 --}}
            <article class="restaurants-vedette-v2-card">
                <div class="restaurants-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?w=600&h=400&fit=crop" alt="Aux Anciens Canadiens">
                    <div class="restaurants-vedette-v2-card-badge">
                        <span class="restaurants-vedette-v2-badge-text">Traditionnel</span>
                    </div>
                </div>
                <div class="restaurants-vedette-v2-card-content">
                    <h3 class="restaurants-vedette-v2-card-title">Aux Anciens Canadiens</h3>
                    <p class="restaurants-vedette-v2-card-description">
                        Cuisine traditionnelle québécoise dans une maison historique de 1675.
                    </p>
                    <div class="restaurants-vedette-v2-card-footer">
                        <span class="restaurants-vedette-v2-card-location">Québec</span>
                        <div class="restaurants-vedette-v2-card-rating">
                            ⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
            </article>

            {{-- Restaurant Card 5 --}}
            <article class="restaurants-vedette-v2-card">
                <div class="restaurants-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?w=600&h=400&fit=crop" alt="Le Mousso">
                    <div class="restaurants-vedette-v2-card-badge">
                        <span class="restaurants-vedette-v2-badge-text">Contemporain</span>
                    </div>
                </div>
                <div class="restaurants-vedette-v2-card-content">
                    <h3 class="restaurants-vedette-v2-card-title">Le Mousso</h3>
                    <p class="restaurants-vedette-v2-card-description">
                        Cuisine créative et innovante, menu dégustation avec accords mets-vins.
                    </p>
                    <div class="restaurants-vedette-v2-card-footer">
                        <span class="restaurants-vedette-v2-card-location">Montréal</span>
                        <div class="restaurants-vedette-v2-card-rating">
                            ⭐⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
            </article>

            {{-- Restaurant Card 6 --}}
            <article class="restaurants-vedette-v2-card">
                <div class="restaurants-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1552566626-52f8b828add9?w=600&h=400&fit=crop" alt="Chez Boulay">
                    <div class="restaurants-vedette-v2-card-badge">
                        <span class="restaurants-vedette-v2-badge-text">Nordique</span>
                    </div>
                </div>
                <div class="restaurants-vedette-v2-card-content">
                    <h3 class="restaurants-vedette-v2-card-title">Chez Boulay</h3>
                    <p class="restaurants-vedette-v2-card-description">
                        Cuisine boréale mettant en valeur les produits locaux et nordiques.
                    </p>
                    <div class="restaurants-vedette-v2-card-footer">
                        <span class="restaurants-vedette-v2-card-location">Québec</span>
                        <div class="restaurants-vedette-v2-card-rating">
                            ⭐⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
            </article>

            {{-- Restaurant Card 7 --}}
            <article class="restaurants-vedette-v2-card">
                <div class="restaurants-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1466978913421-dad2ebd01d17?w=600&h=400&fit=crop" alt="Liverpool House">
                    <div class="restaurants-vedette-v2-card-badge">
                        <span class="restaurants-vedette-v2-badge-text">Italien</span>
                    </div>
                </div>
                <div class="restaurants-vedette-v2-card-content">
                    <h3 class="restaurants-vedette-v2-card-title">Liverpool House</h3>
                    <p class="restaurants-vedette-v2-card-description">
                        Cuisine italienne moderne, fruits de mer frais et ambiance chaleureuse.
                    </p>
                    <div class="restaurants-vedette-v2-card-footer">
                        <span class="restaurants-vedette-v2-card-location">Montréal</span>
                        <div class="restaurants-vedette-v2-card-rating">
                            ⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
            </article>

            {{-- Restaurant Card 8 --}}
            <article class="restaurants-vedette-v2-card">
                <div class="restaurants-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1424847651672-bf20a4b0982b?w=600&h=400&fit=crop" alt="Le Clocher Penché">
                    <div class="restaurants-vedette-v2-card-badge">
                        <span class="restaurants-vedette-v2-badge-text">Brunch</span>
                    </div>
                </div>
                <div class="restaurants-vedette-v2-card-content">
                    <h3 class="restaurants-vedette-v2-card-title">Le Clocher Penché</h3>
                    <p class="restaurants-vedette-v2-card-description">
                        Bistro français réputé pour ses brunchs copieux et sa cuisine de marché.
                    </p>
                    <div class="restaurants-vedette-v2-card-footer">
                        <span class="restaurants-vedette-v2-card-location">Québec</span>
                        <div class="restaurants-vedette-v2-card-rating">
                            ⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
            </article>
            </div>
        </div>
    </div>
</section>

@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
