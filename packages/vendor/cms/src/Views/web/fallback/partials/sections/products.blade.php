{{-- Section Produits (DB : produits publiés de l'établissement) --}}
@if(($cmsLandingProducts ?? collect())->isNotEmpty())
    <section class="lp-section alt" id="offres">
        <div class="container">
            @include('cms::web.fallback.partials.establishment-products', [
                'cmsLandingProducts' => $cmsLandingProducts,
                'cmsProductsLimit' => 8,
                'cmsProductsSectionId' => 'offres',
                'cmsProductsTitle' => 'Nos produits & services',
                'cmsProductsSubtitle' => 'Les produits publiés par cet établissement sont affichés automatiquement.',
            ])
        </div>
    </section>
@endif
