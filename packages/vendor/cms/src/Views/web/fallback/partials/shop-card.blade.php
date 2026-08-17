{{--
    Carte produit de la boutique.

    Autonome : elle recalcule image et prix depuis le produit, pour pouvoir être
    incluse aussi bien dans la grille que dans les « produits similaires ».

    Attend : $produit, $etablissement
--}}
@php
    $carteImage = \Vendor\Cms\Support\ProductPresenter::image($produit);
    $cartePrix = \Vendor\Cms\Support\ProductPresenter::prix($produit);
    $carteLien = route('cms.company.products.show', [
        'etablissementId' => $etablissement->id,
        'productId' => $produit->id,
    ]);
    $carteCategorie = optional($produit->category)->name ?: optional($produit->family)->name;
    $cartePastille = \Vendor\Cms\Support\ProductPresenter::pastille($produit);
@endphp
<article class="shop-card">
    <a href="{{ $carteLien }}" class="shop-card-media">
        @if ($carteImage)
            <img src="{{ $carteImage }}" alt="{{ $produit->name }}" loading="lazy">
        @endif
        @if ($cartePastille)
            <span class="shop-card-tag">{{ $cartePastille }}</span>
        @endif
    </a>
    <div class="shop-card-body">
        @if ($carteCategorie)
            <span class="shop-card-cat">{{ $carteCategorie }}</span>
        @endif
        <h3 class="shop-card-name"><a href="{{ $carteLien }}">{{ $produit->name }}</a></h3>
        @if ($produit->short_description)
            <p class="shop-card-desc">{{ \Illuminate\Support\Str::limit(strip_tags($produit->short_description), 90) }}</p>
        @endif
        <div class="shop-card-foot">
            @if ($cartePrix === null)
                <span class="shop-quote">Sur demande</span>
                <a class="shop-add" href="{{ $carteLien }}">Voir</a>
            @else
                <span class="shop-price">
                    {{ \Vendor\Cms\Support\ProductPresenter::montant($cartePrix) }}
                    @if ($produit->billing_unit)<small>/ {{ $produit->billing_unit }}</small>@endif
                </span>
                <button type="button" class="shop-add"
                        data-cms-cart-add
                        data-product-id="{{ $produit->id }}"
                        data-product-name="{{ $produit->name }}"
                        data-product-price="{{ $cartePrix }}"
                        data-product-image="{{ $carteImage }}"
                        data-product-url="{{ $carteLien }}"
                        data-etablissement-id="{{ $etablissement->id }}"
                        data-etablissement-name="{{ $etablissement->name }}"
                        aria-label="Ajouter {{ $produit->name }} au panier">
                    <i class="fas fa-cart-plus"></i>
                </button>
            @endif
        </div>
    </div>
</article>
