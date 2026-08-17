{{--
    Fiche produit.

    Le bouton d'ajout porte `data-product-quantity`, tenu à jour par le
    sélecteur : le tiroir panier lit cet attribut et ajoute la quantité voulue
    en une fois, au lieu d'obliger à cliquer N fois.
--}}
@php
    $galerie = \Vendor\Cms\Support\ProductPresenter::galerie($produit);
    $prix = \Vendor\Cms\Support\ProductPresenter::prix($produit);
    $categorie = optional($produit->category)->name ?: optional($produit->family)->name;
    $epuise = \Vendor\Cms\Support\ProductPresenter::estEpuise($produit);
    $lienProduit = route('cms.company.products.show', [
        'etablissementId' => $etablissement->id,
        'productId' => $produit->id,
    ]);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $produit->name }} — {{ $etablissement->name }}</title>
    @include('cms::web.fallback.partials.shop-styles')
</head>
<body>
    <div class="shop-wrap">
        <div class="shop-crumb">
            <a href="{{ $siteUrl }}">{{ $etablissement->name }}</a> &rsaquo;
            <a href="{{ $boutiqueUrl }}">Boutique</a> &rsaquo;
            <span>{{ $produit->name }}</span>
        </div>

        <div class="product-grid">
            <div>
                <div class="product-media">
                    @if (count($galerie))
                        <img src="{{ $galerie[0] }}" alt="{{ $produit->name }}" id="productMainImage">
                    @else
                        <div style="aspect-ratio:4/3;display:grid;place-items:center;color:var(--muted)">
                            <i class="fas fa-image" style="font-size:44px"></i>
                        </div>
                    @endif
                </div>

                @if (count($galerie) > 1)
                    <div class="product-thumbs">
                        @foreach ($galerie as $i => $image)
                            <button type="button" class="{{ $i === 0 ? 'is-active' : '' }}" data-image="{{ $image }}">
                                <img src="{{ $image }}" alt="{{ $produit->name }} — vue {{ $i + 1 }}" loading="lazy">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="product-panel">
                @if ($categorie)
                    <span class="shop-card-cat">{{ $categorie }}</span>
                @endif
                <h1 class="product-name">{{ $produit->name }}</h1>

                @if ($prix === null)
                    <div class="product-price">Sur demande</div>
                    <div class="product-tax">Contactez {{ $etablissement->name }} pour un devis.</div>
                @else
                    <div class="product-price">
                        {{ \Vendor\Cms\Support\ProductPresenter::montant($prix) }}
                        @if ($produit->billing_unit)<small>/ {{ $produit->billing_unit }}</small>@endif
                    </div>
                    <div class="product-tax">
                        {{ $produit->is_taxable ? 'Taxes incluses' : 'Non taxable' }}
                    </div>
                @endif

                @if ($produit->short_description)
                    <p class="product-desc">{{ $produit->short_description }}</p>
                @endif

                <div class="product-meta">
                    @if ($produit->reference)
                        <div><span>Référence</span><span>{{ $produit->reference }}</span></div>
                    @endif
                    <div>
                        <span>Disponibilité</span>
                        <span>
                            @if ($epuise)
                                Épuisé
                            @elseif ($produit->stock_management === 'sur_commande')
                                Sur commande
                            @else
                                En stock
                            @endif
                        </span>
                    </div>
                    <div><span>Vendu par</span><span>{{ $etablissement->name }}</span></div>
                </div>

                @if ($prix !== null && ! $epuise)
                    <div class="product-buy">
                        <div class="qty">
                            <button type="button" data-qty-minus aria-label="Diminuer la quantité">&minus;</button>
                            <input type="number" id="productQty" value="1" min="1" max="99" aria-label="Quantité">
                            <button type="button" data-qty-plus aria-label="Augmenter la quantité">+</button>
                        </div>
                        <button type="button" class="shop-add" id="productAdd"
                                data-cms-cart-add
                                data-product-id="{{ $produit->id }}"
                                data-product-name="{{ $produit->name }}"
                                data-product-price="{{ $prix }}"
                                data-product-image="{{ $galerie[0] ?? '' }}"
                                data-product-url="{{ $lienProduit }}"
                                data-product-quantity="1"
                                data-etablissement-id="{{ $etablissement->id }}"
                                data-etablissement-name="{{ $etablissement->name }}">
                            <i class="fas fa-cart-plus"></i> Ajouter au panier
                        </button>
                    </div>
                    <p class="product-note">Vous pourrez modifier les quantités dans le panier avant de valider.</p>
                @elseif ($epuise)
                    <div class="product-buy">
                        <button type="button" class="shop-add" disabled>Produit épuisé</button>
                    </div>
                @endif
            </div>
        </div>

        @if ($produit->long_description)
            <h2 class="product-section-title">Description</h2>
            <div class="product-panel">
                <div class="product-desc" style="margin:0">{!! nl2br(e(strip_tags($produit->long_description))) !!}</div>
            </div>
        @endif

        @if ($similaires->isNotEmpty())
            <h2 class="product-section-title">Dans le même rayon</h2>
            <div class="shop-grid">
                @foreach ($similaires as $produit)
                    @include('cms::web.fallback.partials.shop-card', ['produit' => $produit])
                @endforeach
            </div>
        @endif
    </div>

    @include('cms::web.fallback.partials.landing-cart-drawer')

    <script>
    (() => {
        // Galerie : la vignette cliquée devient l'image principale.
        const principale = document.getElementById('productMainImage');
        document.querySelectorAll('.product-thumbs button').forEach((vignette) => {
            vignette.addEventListener('click', () => {
                if (!principale) return;
                principale.src = vignette.dataset.image;
                document.querySelectorAll('.product-thumbs button').forEach((b) => b.classList.remove('is-active'));
                vignette.classList.add('is-active');
            });
        });

        // Quantité : on la reporte sur le bouton d'ajout, que le tiroir panier
        // lit au clic. Sans ce report, seule 1 unité serait ajoutée.
        const champ = document.getElementById('productQty');
        const bouton = document.getElementById('productAdd');
        if (!champ || !bouton) return;

        const borner = (v) => Math.max(1, Math.min(99, Number(v) || 1));
        const reporter = () => {
            champ.value = borner(champ.value);
            bouton.dataset.productQuantity = String(champ.value);
        };

        champ.addEventListener('input', reporter);
        champ.addEventListener('change', reporter);
        document.querySelector('[data-qty-minus]')?.addEventListener('click', () => {
            champ.value = borner(Number(champ.value) - 1);
            reporter();
        });
        document.querySelector('[data-qty-plus]')?.addEventListener('click', () => {
            champ.value = borner(Number(champ.value) + 1);
            reporter();
        });
        reporter();
    })();
    </script>
</body>
</html>
