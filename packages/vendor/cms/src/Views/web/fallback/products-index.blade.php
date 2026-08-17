{{--
    Boutique d'un établissement : tout son catalogue publié.

    Cible des liens posés par TemplateProducts sur les grilles de template, et
    catalogue complet quand la page d'accueil n'en montre qu'une sélection.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Boutique — {{ $etablissement->name }}</title>
    @include('cms::web.fallback.partials.shop-styles')
</head>
<body>
    <div class="shop-wrap">
        <div class="shop-crumb">
            <a href="{{ $siteUrl }}">{{ $etablissement->name }}</a> &rsaquo; <span>Boutique</span>
        </div>

        <div class="shop-head">
            <span class="shop-kicker">Boutique</span>
            <h1 class="shop-title">Nos produits</h1>
            <p class="shop-sub">
                {{ $produits->total() }}
                {{ $produits->total() > 1 ? 'produits disponibles' : 'produit disponible' }}
                chez {{ $etablissement->name }}.
            </p>
        </div>

        @if ($produits->isEmpty())
            <div class="shop-empty">
                <p style="margin:0 0 6px;font-weight:800;color:var(--ink)">Aucun produit en ligne pour le moment.</p>
                <p style="margin:0">Revenez bientôt, le catalogue se remplit au fil des arrivages.</p>
            </div>
        @else
            <div class="shop-grid">
                @foreach ($produits as $produit)
                    @include('cms::web.fallback.partials.shop-card', ['produit' => $produit])
                @endforeach
            </div>

            <div style="margin-top:30px">
                {{ $produits->links() }}
            </div>
        @endif
    </div>

    @include('cms::web.fallback.partials.landing-cart-drawer')
</body>
</html>
