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
            <span class="shop-kicker">{{ $rayonActif ? 'Rayon' : 'Boutique' }}</span>
            <h1 class="shop-title">{{ $rayonActif ? $rayonActif->name : 'Nos produits' }}</h1>
            <p class="shop-sub">
                @if ($recherche !== '')
                    {{ $produits->total() }}
                    {{ $produits->total() > 1 ? 'résultats' : 'résultat' }}
                    pour « {{ $recherche }} »{{ $rayonActif ? ' dans ce rayon' : '' }}.
                @else
                    {{ $produits->total() }}
                    {{ $produits->total() > 1 ? 'produits disponibles' : 'produit disponible' }}
                    {{ $rayonActif ? 'dans ce rayon.' : 'chez ' . $etablissement->name . '.' }}
                @endif
            </p>
        </div>

        <form class="shop-search" method="get" action="{{ $boutiqueUrl }}" role="search">
            {{-- Le rayon actif est conservé : chercher ne doit pas faire sortir
                 du rayon qu'on est en train de parcourir. --}}
            @if ($rayonActif)
                <input type="hidden" name="rayon" value="{{ $rayonActif->id }}">
            @endif
            <div class="shop-search-field">
                <i class="fas fa-magnifying-glass"></i>
                <input type="search" name="q" value="{{ $recherche }}"
                       placeholder="Rechercher un produit, une référence…"
                       aria-label="Rechercher un produit">
            </div>
            <button type="submit" class="shop-search-btn">Rechercher</button>
            @if ($recherche !== '')
                <a class="shop-search-clear"
                   href="{{ $boutiqueUrl }}{{ $rayonActif ? '?rayon=' . $rayonActif->id : '' }}">
                    Effacer
                </a>
            @endif
        </form>

        @if ($rayons->isNotEmpty())
            <div class="shop-filters">
                <a href="{{ $boutiqueUrl }}" class="shop-filter {{ $rayonActif ? '' : 'is-active' }}">
                    Tous les rayons
                </a>
                @foreach ($rayons as $rayon)
                    <a href="{{ $boutiqueUrl }}?rayon={{ $rayon->id }}"
                       class="shop-filter {{ $rayonActif && $rayonActif->id === $rayon->id ? 'is-active' : '' }}">
                        {{ $rayon->name }} <span>{{ $rayon->products_count }}</span>
                    </a>
                @endforeach
            </div>
        @endif

        @if ($produits->isEmpty())
            <div class="shop-empty">
                <p style="margin:0 0 6px;font-weight:800;color:var(--ink)">
                    @if ($recherche !== '')
                        Aucun produit ne correspond à « {{ $recherche }} ».
                    @elseif ($rayonActif)
                        Ce rayon est vide pour le moment.
                    @else
                        Aucun produit en ligne pour le moment.
                    @endif
                </p>
                <p style="margin:0">
                    @if ($recherche !== '' || $rayonActif)
                        <a href="{{ $boutiqueUrl }}" style="text-decoration:underline">Voir tous les produits</a>
                    @else
                        Revenez bientôt, le catalogue se remplit au fil des arrivages.
                    @endif
                </p>
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
