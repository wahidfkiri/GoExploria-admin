{{-- ═══════════════════════════════════════════════════════════════════════
     Section « Produits » (fallback) de la landing commerce-alimentaire.
     Grille commerciale statique affichée uniquement si $showFallbackProducts
     est actif et qu'aucun produit CMS live n'existe. Utilise les classes
     .food-* définies dans landing-commerce-alimentaire.blade.php.
     Nécessite : $etablissement, $showFallbackProducts, $cmsHasLiveProducts,
     $productCards.
     ═══════════════════════════════════════════════════════════════════════ --}}
@if(false && !empty($showFallbackProducts) && !$cmsHasLiveProducts)
    @php
        $foodProductsSectionTitle = function_exists('get_ecommerce_section_title')
            ? get_ecommerce_section_title($etablissement->id)
            : 'Nos Produits disponible';
        $foodProductsSectionTitle = trim((string) $foodProductsSectionTitle) !== '' ? $foodProductsSectionTitle : 'Nos Produits disponible';
    @endphp
    <section class="food-section food-section-pad" id="produits">
        <span class="food-kicker">Produits</span>
        <h2 class="food-title">{{ $foodProductsSectionTitle }}</h2>
        <p class="food-copy">Une grille commerciale inspirée du design sélectionné pour présenter prix, catégories, images et textes courts.</p>
        <div class="food-product-grid">
            @foreach($productCards as $product)
                <article class="food-product-card">
                    <img src="{{ $product['image'] }}" alt="{{ $product['title'] }}">
                    <div class="food-product-body">
                        <span class="food-product-tag">{{ $product['tag'] }}</span>
                        <h3>{{ $product['title'] }}</h3>
                        <p>{{ $product['desc'] }}</p>
                        <strong class="food-price">{{ $product['price'] }}</strong>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endif
