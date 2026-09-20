{{-- ══════════════════════════════════════════════════════════════════════
     BARRE DE RACCOURCIS (droite) — langue, recherche, favoris, activités,
     destinations, panier, carte interactive.

     Posée sur toutes les pages qui incluent l'en-tête de la plateforme
     (partials/platform-header) ET sur l'accueil, qui inclut ses composants
     directement.

     Autonome par construction : ses panneaux ne dépendent NI du hero de
     l'accueil (la loupe du header ne fait qu'y révéler la barre de recherche)
     NI du tiroir du menu vertical. Chaque page la rend donc utilisable telle
     quelle.

     Les deux méga-menus sont chargés à la PREMIÈRE ouverture depuis le
     package travel_destination (routes menu/activites et menu/destinations,
     mises en cache 10 min côté serveur) : ~950 activités et l'arbre des
     destinations ne sont pas embarqués dans chaque page.

     Desktop : colonne flottante à droite, centrée verticalement.
     Mobile (≤ 992 px) : barre horizontale en bas de l'écran, panneaux en
     plein écran.
     ══════════════════════════════════════════════════════════════════════ --}}
@once
@php
    $gxRailLocales = [
        'fr' => ['flag' => 'fr', 'code' => 'FR', 'label' => __('home-v2.language.fr')],
        'en' => ['flag' => 'gb', 'code' => 'EN', 'label' => __('home-v2.language.en')],
        'es' => ['flag' => 'es', 'code' => 'ES', 'label' => __('home-v2.language.es')],
        'de' => ['flag' => 'de', 'code' => 'DE', 'label' => __('home-v2.language.de')],
        'it' => ['flag' => 'it', 'code' => 'IT', 'label' => __('home-v2.language.it')],
    ];
    $gxRailLocale = array_key_exists(app()->getLocale(), $gxRailLocales) ? app()->getLocale() : 'fr';

    $gxRailRoute = static fn (string $name, $params = []) => \Illuminate\Support\Facades\Route::has($name)
        ? route($name, $params)
        : null;

    $gxRailFavoris = $gxRailRoute('favoris');
    $gxRailPanier = $gxRailRoute('panier');
    $gxRailActivites = $gxRailRoute('travel-destination.activities-menu');
    $gxRailDestinations = $gxRailRoute('travel-destination.destinations-menu');
    // La carte interactive vit sur l'accueil : ancre ici, lien absolu ailleurs.
    $gxRailCarte = url('/') . '#section-carte-amerique-nord';
@endphp

<aside class="gxrail" id="gxRail" aria-label="Raccourcis GoExploria">
    <div class="gxrail__inner">
        <button type="button" class="gxrail__item" data-gxrail-open="lang"
                aria-haspopup="dialog" aria-expanded="false" aria-controls="gxRailLang">
            <span class="gxrail__ico gxrail__ico--text">{{ $gxRailLocales[$gxRailLocale]['code'] }}</span>
            <span class="gxrail__label">Langue</span>
        </button>

        <button type="button" class="gxrail__item" data-gxrail-open="search"
                aria-haspopup="dialog" aria-expanded="false" aria-controls="gxRailSearch">
            <span class="gxrail__ico"><i class="fas fa-magnifying-glass" aria-hidden="true"></i></span>
            <span class="gxrail__label">Rechercher</span>
        </button>

        @if($gxRailFavoris)
        <a class="gxrail__item" href="{{ $gxRailFavoris }}">
            <span class="gxrail__ico"><i class="fas fa-heart" aria-hidden="true"></i></span>
            <span class="gxrail__label">Favoris</span>
        </a>
        @endif

        @if($gxRailActivites)
        <button type="button" class="gxrail__item" data-gxrail-open="activites" data-gxrail-src="{{ $gxRailActivites }}"
                aria-haspopup="dialog" aria-expanded="false" aria-controls="gxRailActivites">
            <span class="gxrail__ico"><i class="fas fa-person-hiking" aria-hidden="true"></i></span>
            <span class="gxrail__label">Activités</span>
        </button>
        @endif

        @if($gxRailDestinations)
        <button type="button" class="gxrail__item" data-gxrail-open="destinations" data-gxrail-src="{{ $gxRailDestinations }}"
                aria-haspopup="dialog" aria-expanded="false" aria-controls="gxRailDestinations">
            <span class="gxrail__ico"><i class="fas fa-earth-americas" aria-hidden="true"></i></span>
            <span class="gxrail__label">Destinations</span>
        </button>
        @endif

        @if($gxRailPanier)
        <a class="gxrail__item" href="{{ $gxRailPanier }}">
            <span class="gxrail__ico"><i class="fas fa-cart-shopping" aria-hidden="true"></i></span>
            <span class="gxrail__label">Panier</span>
        </a>
        @endif

        <a class="gxrail__item" href="{{ $gxRailCarte }}">
            <span class="gxrail__ico"><i class="fas fa-map-location-dot" aria-hidden="true"></i></span>
            <span class="gxrail__label">Carte<br>interactive</span>
        </a>
    </div>
</aside>

{{-- ── Panneau : langue ─────────────────────────────────────────────── --}}
<div class="gxrail-pop" id="gxRailLang" data-gxmenu-panel="lang" role="dialog" aria-label="Choisir la langue" aria-hidden="true">
    <p class="gxrail-pop__title">Langue</p>
    <ul class="gxrail-pop__list">
        @foreach($gxRailLocales as $code => $data)
            <li>
                <a class="gxrail-pop__lang {{ $code === $gxRailLocale ? 'is-active' : '' }}"
                   href="{{ $gxRailRoute('locale.switch', ['locale' => $code]) ? $gxRailRoute('locale.switch', ['locale' => $code]) . '?redirect=' . urlencode(request()->fullUrl()) : '#' }}">
                    <span class="fi fi-{{ $data['flag'] }}" aria-hidden="true"></span>
                    <span>{{ $data['label'] }}</span>
                    <em>{{ $data['code'] }}</em>
                </a>
            </li>
        @endforeach
    </ul>
</div>

{{-- ── Panneau : recherche ──────────────────────────────────────────── --}}
<div class="gxrail-pop gxrail-pop--search" id="gxRailSearch" data-gxmenu-panel="search" role="dialog" aria-label="Rechercher une destination" aria-hidden="true">
    <p class="gxrail-pop__title">Rechercher</p>
    <div class="gxrail-search__field">
        <i class="fas fa-magnifying-glass" aria-hidden="true"></i>
        <input type="search" id="gxRailSearchInput" placeholder="Une destination, une ville…" autocomplete="off" aria-controls="gxRailSearchResults">
    </div>
    <div class="gxrail-search__results" id="gxRailSearchResults" aria-live="polite"></div>
</div>

{{-- ── Méga-menus (contenu chargé à l'ouverture) ────────────────────── --}}
@if($gxRailActivites)
<div class="gxrail-mega" id="gxRailActivites" data-gxmenu-panel="activites" role="dialog" aria-label="Activités" aria-hidden="true">
    <div class="gxrail-mega__inner">
        <div class="gxrail-mega__top">
            <p class="gxrail-mega__kicker"><i class="fas fa-person-hiking" aria-hidden="true"></i> Activités</p>
            <button type="button" class="gxrail-mega__close" data-gxrail-close aria-label="Fermer"><i class="fas fa-xmark" aria-hidden="true"></i></button>
        </div>
        <div class="gxrail-mega__body" data-gxrail-body aria-live="polite">
            <p class="gxrail-mega__status"><span class="gxrail-mega__spinner" aria-hidden="true"></span> Chargement…</p>
        </div>
    </div>
</div>
@endif

@if($gxRailDestinations)
<div class="gxrail-mega" id="gxRailDestinations" data-gxmenu-panel="destinations" role="dialog" aria-label="Destinations" aria-hidden="true">
    <div class="gxrail-mega__inner">
        <div class="gxrail-mega__top">
            <p class="gxrail-mega__kicker"><i class="fas fa-earth-americas" aria-hidden="true"></i> Destinations</p>
            <button type="button" class="gxrail-mega__close" data-gxrail-close aria-label="Fermer"><i class="fas fa-xmark" aria-hidden="true"></i></button>
        </div>
        <div class="gxrail-mega__body" data-gxrail-body aria-live="polite">
            <p class="gxrail-mega__status"><span class="gxrail-mega__spinner" aria-hidden="true"></span> Chargement…</p>
        </div>
    </div>
</div>
@endif

<style>
  .gxrail {
    --gxr-ink: #0f172a; --gxr-muted: #64748b; --gxr-line: #e5e7eb;
    --gxr-navy: #0a1628; --gxr-gold: #d4af37; --gxr-gold-ink: #8a6d10;
    position: fixed; right: 14px; top: 50%; transform: translateY(-50%);
    z-index: 10040;
    font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  }
  .gxrail__inner {
    display: flex; flex-direction: column; align-items: stretch; gap: 2px;
    width: 86px; padding: 10px 6px;
    background: #fff; border: 1px solid rgba(15, 23, 42, .06); border-radius: 22px;
    box-shadow: 0 18px 46px rgba(2, 6, 23, .22);
    max-height: calc(100vh - 140px); overflow-y: auto; overscroll-behavior: contain;
  }
  .gxrail__item {
    display: flex; flex-direction: column; align-items: center; gap: 5px;
    padding: 10px 4px; border: 0; border-radius: 14px;
    background: transparent; color: var(--gxr-ink); text-decoration: none; cursor: pointer;
    font-family: inherit; font-size: 11px; font-weight: 600; line-height: 1.2; text-align: center;
    transition: background .18s ease, color .18s ease;
  }
  .gxrail__item:hover, .gxrail__item:focus-visible { background: #f6f7f9; color: var(--gxr-gold-ink); }
  .gxrail__item[aria-expanded="true"] { background: var(--gxr-navy); color: #fff; }
  .gxrail__item[aria-expanded="true"] .gxrail__ico { color: var(--gxr-gold); }
  .gxrail__ico { font-size: 19px; line-height: 1; color: var(--gxr-ink); }
  .gxrail__item:hover .gxrail__ico { color: inherit; }
  .gxrail__ico--text {
    font-size: 16px; font-weight: 800; letter-spacing: .04em;
    padding-bottom: 3px; border-bottom: 2px solid var(--gxr-gold);
  }
  .gxrail__label { color: inherit; }

  /* ── Petits panneaux (langue, recherche) ── */
  .gxrail-pop {
    position: fixed; z-index: 10120; right: 112px; top: 50%; transform: translateY(-50%) translateX(8px);
    width: 268px; padding: 14px; border-radius: 16px;
    background: #fff; border: 1px solid rgba(15, 23, 42, .08);
    box-shadow: 0 18px 46px rgba(2, 6, 23, .24);
    color: #0f172a; font-family: 'Montserrat', -apple-system, sans-serif;
    opacity: 0; visibility: hidden; transition: opacity .18s ease, transform .18s ease, visibility .18s;
  }
  .gxrail-pop.is-open { opacity: 1; visibility: visible; transform: translateY(-50%); }
  .gxrail-pop--search { width: 340px; }
  .gxrail-pop__title { margin: 0 0 10px; font-size: 11px; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; color: #8a6d10; }
  .gxrail-pop__list { list-style: none; margin: 0; padding: 0; }
  .gxrail-pop__lang {
    display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 10px;
    color: #0f172a; text-decoration: none; font-size: 13.5px; font-weight: 600;
  }
  .gxrail-pop__lang:hover { background: #f6f7f9; }
  .gxrail-pop__lang.is-active { background: #0a1628; color: #fff; }
  .gxrail-pop__lang em { margin-left: auto; font-style: normal; font-size: 11px; font-weight: 700; opacity: .7; }

  .gxrail-search__field { display: flex; align-items: center; gap: 8px; padding: 9px 12px; border: 1px solid var(--gxr-line, #e5e7eb); border-radius: 999px; }
  .gxrail-search__field i { color: #94a3b8; font-size: 13px; }
  .gxrail-search__field input { flex: 1 1 auto; min-width: 0; border: 0; outline: 0; font: inherit; font-size: 13.5px; background: transparent; color: #0f172a; }
  .gxrail-search__results { max-height: 320px; overflow-y: auto; margin-top: 8px; }
  .gxrail-search__results a {
    display: flex; align-items: center; gap: 10px; padding: 8px 10px; border-radius: 10px;
    color: #0f172a; text-decoration: none; font-size: 13px; font-weight: 600;
  }
  .gxrail-search__results a:hover { background: #f6f7f9; }
  .gxrail-search__results img { width: 34px; height: 34px; border-radius: 8px; object-fit: cover; flex: 0 0 34px; }
  .gxrail-search__results small { display: block; font-weight: 500; color: #64748b; font-size: 11px; }
  .gxrail-search__msg { padding: 10px; font-size: 12.5px; color: #64748b; }
  .gxrail-search__group {
    margin: 10px 0 2px; padding: 0 10px;
    font-size: 10.5px; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; color: #8a6d10;
  }
  .gxrail-search__group:first-child { margin-top: 2px; }

  /* ── Méga-menus ── */
  .gxrail-mega {
    position: fixed; left: 0; right: 0; top: var(--gxrail-top, 96px); z-index: 10120;
    max-height: calc(100vh - var(--gxrail-top, 96px)); overflow: hidden; display: flex;
    background: #fff; color: #0f172a; border-top: 3px solid #d4af37;
    box-shadow: 0 24px 60px rgba(2, 6, 23, .28);
    font-family: 'Montserrat', -apple-system, sans-serif;
    opacity: 0; visibility: hidden; transform: translateY(-8px);
    transition: opacity .2s ease, transform .2s ease, visibility .2s;
  }
  .gxrail-mega.is-open { opacity: 1; visibility: visible; transform: none; }
  .gxrail-mega__inner { width: min(1320px, 100%); margin: 0 auto; padding: 18px clamp(16px, 3vw, 36px) 22px; display: flex; flex-direction: column; min-height: 0; }
  .gxrail-mega__top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
  .gxrail-mega__kicker { margin: 0; display: inline-flex; align-items: center; gap: 8px; font-size: 11px; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; color: #8a6d10; }
  .gxrail-mega__close { width: 36px; height: 36px; border-radius: 50%; border: 1px solid #e5e7eb; background: #fff; color: #0f172a; cursor: pointer; display: grid; place-items: center; font-size: 16px; }
  .gxrail-mega__close:hover { background: #f6f7f9; }
  .gxrail-mega__body { display: flex; gap: 28px; min-height: 0; flex: 1 1 auto; }
  .gxrail-mega__status, .gxmenu__empty {
    margin: 0; padding: 28px 0; width: 100%; text-align: center; font-size: 14px; color: #64748b;
    display: flex; align-items: center; justify-content: center; gap: 10px;
  }
  .gxrail-mega__status a { color: #8a6d10; font-weight: 700; }
  .gxrail-mega__spinner { width: 18px; height: 18px; border-radius: 50%; border: 2px solid #e5e7eb; border-top-color: #d4af37; animation: gxrailSpin .8s linear infinite; }
  @keyframes gxrailSpin { to { transform: rotate(360deg); } }

  .gxmenu__tabs {
    flex: 0 0 250px; display: flex; flex-direction: column; gap: 2px; padding-right: 18px;
    border-right: 1px solid #e5e7eb; overflow-y: auto; max-height: calc(100vh - var(--gxrail-top, 96px) - 90px);
  }
  .gxmenu__tab {
    display: flex; align-items: center; justify-content: space-between; gap: 10px; width: 100%;
    padding: 10px 12px; border: 0; border-radius: 10px; background: transparent; color: #0f172a; cursor: pointer;
    font-family: inherit; font-size: 13.5px; font-weight: 600; line-height: 1.3; text-align: left;
  }
  .gxmenu__tab em { flex: 0 0 auto; font-style: normal; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 999px; background: #f6f7f9; color: #64748b; }
  .gxmenu__tab:hover { background: #f6f7f9; }
  .gxmenu__tab.is-active { background: #0a1628; color: #fff; }
  .gxmenu__tab.is-active em { background: #d4af37; color: #0a1628; }
  .gxmenu__panes { flex: 1 1 auto; min-width: 0; overflow-y: auto; max-height: calc(100vh - var(--gxrail-top, 96px) - 90px); padding-right: 4px; }
  .gxmenu__pane[hidden] { display: none; }
  .gxmenu__head { display: flex; align-items: baseline; justify-content: space-between; gap: 16px; }
  .gxmenu__title { margin: 2px 0 14px; font-size: 20px; font-weight: 800; }
  .gxmenu__title small { font-size: 12px; font-weight: 600; color: #64748b; margin-left: 6px; }
  .gxmenu__more { font-size: 13px; font-weight: 700; color: #8a6d10; text-decoration: none; white-space: nowrap; }
  .gxmenu__more:hover { text-decoration: underline; }

  /* Activités : index A→Z + vignettes (classes servies par la route) */
  .gxmenu__az { columns: 4 210px; column-gap: 32px; }
  .gxmenu__letter { break-inside: avoid; margin: 0 0 16px; }
  .gxmenu__letter h4 { margin: 0 0 6px; padding-bottom: 4px; border-bottom: 2px solid #d4af37; font-size: 15px; font-weight: 800; color: #8a6d10; }
  .gxmenu__letter ul { list-style: none; margin: 0; padding: 0; }
  .gxmenu__letter a { display: block; padding: 3px 0; font-size: 13px; font-weight: 500; color: #0f172a; text-decoration: none; }
  .gxmenu__letter a:hover { color: #8a6d10; text-decoration: underline; }
  .gxmenu__grid { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: 18px 16px; }
  .gxmenu__card { display: block; min-width: 0; color: #0f172a; text-decoration: none; }
  .gxmenu__media { display: block; position: relative; aspect-ratio: 4 / 3; border-radius: 12px; overflow: hidden; background: #f6f7f9; }
  .gxmenu__media img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .35s ease; }
  .gxmenu__card:hover .gxmenu__media img { transform: scale(1.05); }
  .gxmenu__ph { position: absolute; inset: 0; display: grid; place-items: center; color: #b7bec8; font-size: 26px; }
  .gxmenu__name { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-top: 8px; font-size: 13.5px; font-weight: 600; line-height: 1.3; }

  /* Destinations : pays + provinces */
  .gxmenu-dest__grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 22px 26px; }
  .gxmenu-dest__country { min-width: 0; }
  .gxmenu-dest__country h4 { margin: 0 0 8px; padding-bottom: 6px; border-bottom: 2px solid #d4af37; font-size: 15px; font-weight: 800; }
  .gxmenu-dest__country h4 a { color: #0f172a; text-decoration: none; }
  .gxmenu-dest__country h4 a:hover { color: #8a6d10; }
  .gxmenu-dest__list { list-style: none; margin: 0; padding: 0; }
  .gxmenu-dest__list a { display: block; padding: 3px 0; font-size: 13px; font-weight: 500; color: #334155; text-decoration: none; }
  .gxmenu-dest__list a:hover { color: #8a6d10; text-decoration: underline; }

  @media (max-width: 1280px) { .gxmenu__grid { grid-template-columns: repeat(5, minmax(0, 1fr)); } }
  @media (max-width: 1100px) { .gxmenu__grid { grid-template-columns: repeat(4, minmax(0, 1fr)); } }

  /* ── Mobile : barre horizontale en bas ── */
  @media (max-width: 992px) {
    .gxrail {
      right: 0; left: 0; top: auto; bottom: 0; transform: none;
      padding: 0 8px calc(env(safe-area-inset-bottom, 0px) + 6px);
      background: #fff; box-shadow: 0 -8px 26px rgba(2, 6, 23, .18);
    }
    .gxrail__inner {
      flex-direction: row; width: 100%; max-height: none; gap: 0;
      padding: 6px 2px 4px; border: 0; border-radius: 0; box-shadow: none;
      overflow-x: auto; overflow-y: hidden; -webkit-overflow-scrolling: touch;
    }
    .gxrail__item { flex: 1 0 68px; padding: 6px 2px; font-size: 10px; border-radius: 10px; }
    .gxrail__ico { font-size: 17px; }
    .gxrail__ico--text { font-size: 14px; }
    .gxrail__label br { display: none; }

    .gxrail-pop {
      right: 10px; left: 10px; width: auto; top: auto; bottom: 86px; transform: translateY(8px);
      max-height: 60vh; overflow-y: auto;
    }
    .gxrail-pop.is-open { transform: none; }
    .gxrail-mega { top: 0; max-height: none; height: 100vh; height: 100dvh; padding-bottom: 76px; border-top: 0; z-index: 10400; }
    .gxrail-mega__inner { padding: 14px 14px 0; }
    .gxrail-mega__body { flex-direction: column; gap: 12px; }
    .gxmenu__tabs {
      flex: 0 0 auto; flex-direction: row; gap: 6px; max-height: none; padding: 0 0 10px;
      border-right: 0; border-bottom: 1px solid #e5e7eb; overflow-x: auto; overflow-y: hidden;
    }
    .gxmenu__tab { width: auto; flex: 0 0 auto; white-space: nowrap; padding: 8px 12px; background: #f6f7f9; }
    .gxmenu__panes { max-height: none; flex: 1 1 auto; padding-bottom: 20px; }
    .gxmenu__grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px 12px; }
    .gxmenu__az { columns: 2 150px; column-gap: 20px; }
    .gxmenu-dest__grid { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 16px 18px; }
    .gxmenu__title { font-size: 17px; }
  }
  @media (max-width: 560px) { .gxmenu__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
  @media (min-width: 993px) { .gxrail-mega__close { display: none; } }
  @media (prefers-reduced-motion: reduce) { .gxrail-pop, .gxrail-mega, .gxmenu__media img { transition: none; } .gxrail-mega__spinner { animation: none; } }
  @media print { .gxrail, .gxrail-pop, .gxrail-mega { display: none !important; } }
</style>

<script>
(function () {
  function init() {
    var rail = document.getElementById('gxRail');
    if (!rail || rail.dataset.gxrailBound === '1') { return; }
    rail.dataset.gxrailBound = '1';

    var triggers = rail.querySelectorAll('[data-gxrail-open]');
    var panels = {};
    document.querySelectorAll('[data-gxmenu-panel]').forEach(function (p) {
      panels[p.getAttribute('data-gxmenu-panel')] = p;
    });
    var ouvert = null;
    var chargements = {};

    /* Les méga-menus se collent SOUS l'en-tête, dont la hauteur varie selon la
       page et le défilement. Les pages destination publient déjà
       --gx-entete-plateforme ; ailleurs on mesure la barre. */
    function mesurerEntete() {
      var val = getComputedStyle(document.documentElement).getPropertyValue('--gx-entete-plateforme').trim();
      var haut = parseInt(val, 10);
      if (!haut) {
        var barre = document.querySelector('.header-v2 .header-nav') || document.querySelector('.header-v2');
        haut = barre ? Math.round(barre.getBoundingClientRect().bottom) : 96;
      }
      if (haut > 0) {
        document.documentElement.style.setProperty('--gxrail-top', haut + 'px');
      }
    }

    function fermer() {
      if (!ouvert) { return; }
      var panneau = panels[ouvert];
      if (panneau) {
        panneau.classList.remove('is-open');
        panneau.setAttribute('aria-hidden', 'true');
      }
      var t = rail.querySelector('[data-gxrail-open="' + ouvert + '"]');
      if (t) { t.setAttribute('aria-expanded', 'false'); }
      document.documentElement.style.overflow = '';
      ouvert = null;
    }

    function ouvrir(nom, trigger) {
      var panneau = panels[nom];
      if (!panneau) { return; }
      if (ouvert && ouvert !== nom) { fermer(); }
      // Les autres méga-menus du site se ferment (coordination commune).
      if (typeof window.goCloseOtherMega === 'function') { window.goCloseOtherMega(panneau); }
      mesurerEntete();
      charger(nom, trigger);
      panneau.classList.add('is-open');
      panneau.setAttribute('aria-hidden', 'false');
      trigger.setAttribute('aria-expanded', 'true');
      ouvert = nom;
      if (panneau.classList.contains('gxrail-mega') && window.innerWidth <= 992) {
        document.documentElement.style.overflow = 'hidden';
      }
      if (nom === 'search') {
        var champ = document.getElementById('gxRailSearchInput');
        if (champ) { setTimeout(function () { champ.focus(); }, 60); }
      }
    }

    /* Contenu des méga-menus : une seule requête, gardée pour la session de
       navigation ; en cas d'échec, un lien « Réessayer ». */
    function charger(nom, trigger) {
      var src = trigger.getAttribute('data-gxrail-src');
      if (!src || chargements[nom]) { return chargements[nom]; }
      var corps = panels[nom].querySelector('[data-gxrail-body]');
      if (!corps) { return; }

      chargements[nom] = fetch(src, { headers: { 'Accept': 'text/html' }, credentials: 'same-origin' })
        .then(function (r) {
          if (!r.ok) { throw new Error('HTTP ' + r.status); }
          return r.text();
        })
        .then(function (html) {
          corps.innerHTML = html;
          brancherOnglets(panels[nom]);
        })
        .catch(function () {
          chargements[nom] = null;
          corps.innerHTML = '<p class="gxrail-mega__status">Chargement impossible. <a href="#" data-gxrail-retry>Réessayer</a></p>';
        });

      return chargements[nom];
    }

    function brancherOnglets(panneau) {
      var onglets = panneau.querySelectorAll('.gxmenu__tab');
      var volets = panneau.querySelector('.gxmenu__panes');
      onglets.forEach(function (onglet) {
        onglet.addEventListener('click', function () {
          var volet = document.getElementById(onglet.getAttribute('data-gxmenu-pane'));
          if (!volet || onglet.classList.contains('is-active')) { return; }
          onglets.forEach(function (o) { o.classList.remove('is-active'); o.setAttribute('aria-selected', 'false'); });
          panneau.querySelectorAll('.gxmenu__pane').forEach(function (v) { v.hidden = true; });
          onglet.classList.add('is-active');
          onglet.setAttribute('aria-selected', 'true');
          volet.hidden = false;
          if (volets) { volets.scrollTop = 0; }
        });
      });
    }

    triggers.forEach(function (trigger) {
      trigger.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var nom = trigger.getAttribute('data-gxrail-open');
        (ouvert === nom) ? fermer() : ouvrir(nom, trigger);
      });
    });

    document.addEventListener('click', function (e) {
      if (!ouvert) { return; }
      if (e.target.closest('[data-gxrail-retry]')) {
        e.preventDefault();
        var t = rail.querySelector('[data-gxrail-open="' + ouvert + '"]');
        var corps = panels[ouvert].querySelector('[data-gxrail-body]');
        if (corps) { corps.innerHTML = '<p class="gxrail-mega__status"><span class="gxrail-mega__spinner" aria-hidden="true"></span> Chargement…</p>'; }
        charger(ouvert, t);
        return;
      }
      if (!panels[ouvert].contains(e.target) && !rail.contains(e.target)) { fermer(); }
    });
    document.querySelectorAll('[data-gxrail-close]').forEach(function (b) {
      b.addEventListener('click', fermer);
    });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { fermer(); } });
    window.addEventListener('resize', function () { if (ouvert) { mesurerEntete(); } }, { passive: true });
    window.addEventListener('scroll', function () { if (ouvert) { mesurerEntete(); } }, { passive: true });

    // Les autres méga-menus du site ferment celui-ci.
    window.goMegaClosers = window.goMegaClosers || [];
    window.goMegaClosers.push(function (sauf) {
      if (!ouvert || panels[ouvert] === sauf) { return; }
      fermer();
    });

    /* ── Recherche : même source que la barre du hero ── */
    var champ = document.getElementById('gxRailSearchInput');
    var sortie = document.getElementById('gxRailSearchResults');
    if (champ && sortie) {
      var minuteur = null;
      var enCours = null;

      /* L'API rend les résultats GROUPÉS par type
         ({continents, countries, provinces, regions, villes, secteurs,
         etablissements, activities}), pas une liste : on garde ses groupes,
         et son champ `url`, déjà valide pour chaque type. */
      var GROUPES = {
        continents: 'Continents', countries: 'Pays', provinces: 'Provinces',
        regions: 'Régions', villes: 'Villes', secteurs: 'Secteurs',
        etablissements: 'Établissements', activities: 'Activités'
      };

      var echapper = function (valeur) {
        return String(valeur == null ? '' : valeur)
          .replace(/&/g, '&amp;').replace(/</g, '&lt;')
          .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
      };

      var rendre = function (data) {
        var html = '';
        var total = 0;

        Object.keys(GROUPES).forEach(function (cle) {
          var items = (data && data[cle]) || [];
          if (!items.length) { return; }
          total += items.length;
          html += '<p class="gxrail-search__group">' + GROUPES[cle] + '</p>';
          html += items.slice(0, 6).map(function (it) {
            var img = it.image_url || it.image || '';
            return '<a href="' + echapper(it.url || '#') + '">'
              + (img ? '<img src="' + echapper(img) + '" alt="" loading="lazy">' : '')
              + '<span>' + echapper(it.name || '') + '</span></a>';
          }).join('');
        });

        sortie.innerHTML = total ? html : '<p class="gxrail-search__msg">Aucun résultat.</p>';
      };

      var chercher = function (q) {
        if (enCours) { enCours.abort(); }
        enCours = new AbortController();
        sortie.innerHTML = '<p class="gxrail-search__msg">Recherche…</p>';
        fetch('/api/v1/destinations/search?query=' + encodeURIComponent(q), {
          headers: { 'Accept': 'application/json' },
          signal: enCours.signal
        })
          .then(function (r) { return r.json(); })
          .then(function (res) { rendre(res.data || {}); })
          .catch(function (err) {
            if (err && err.name === 'AbortError') { return; }
            sortie.innerHTML = '<p class="gxrail-search__msg">Recherche indisponible pour le moment.</p>';
          });
      };

      champ.addEventListener('input', function () {
        var q = champ.value.trim();
        clearTimeout(minuteur);
        if (q.length < 2) { sortie.innerHTML = ''; return; }
        minuteur = setTimeout(function () { chercher(q); }, 300);
      });
    }

    mesurerEntete();
  }

  if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', init); }
  else { init(); }
})();
</script>
@endonce
