{{-- ==========================================================================
     INDEX DES DESTINATIONS — `/destination`

     L'adresse était déjà écrite dans le fil d'Ariane et le pied de page de
     chaque destination, mais aucune route ne la servait : elle rendait 404.

     Deux affichages, selon `?niveau=` :
       - sans niveau, un aperçu de chacun (les huit premières destinations et
         le compte total, avec un lien vers la liste complète) ;
       - avec un niveau, sa liste complète, paginée en base.

     La carte est celle des pages de destination (mêmes partiels, même moteur
     Leaflet + OpenStreetMap), nourrie ici par le type `all` : tous les points
     actifs, pas ceux d'une destination.

     Variables : $niveaux, $comptes, $apercus, $liste, $niveauActif,
     $recherche, plus celles qu'attendent les partiels de carte (voir
     TravelDestinationController@index).
     ========================================================================== --}}
@php
    use Illuminate\Support\Str;

    $atlasCss = public_path('vendor/travel-destination/css/destination-atlas.css');
    $atlasJs  = public_path('vendor/travel-destination/js/destination-atlas.js');

    $typeLabels = collect($niveaux)->map(fn ($n) => $n[1])->all();

    /* Visuel d'une destination : la colonne `image` porte tantôt une adresse
       complète, tantôt un chemin relatif au disque public. */
    $visuel = function ($destination) {
        $valeur = trim((string) ($destination->image ?? ''));

        if ($valeur === '') {
            return null;
        }

        return Str::startsWith($valeur, ['http://', 'https://', '//', '/'])
            ? $valeur
            : asset('storage/' . ltrim($valeur, '/'));
    };

    /* Le slug est vide en base pour plusieurs niveaux ; le site sait résoudre
       un nom normalisé (voir TravelDestinationController@loadEntity). */
    $lien = function (string $type, $destination) {
        $slug = trim((string) ($destination->slug ?? ''));

        return route('travel-destination.show', [
            'type' => $type,
            'slug' => $slug !== '' ? $slug : Str::slug((string) $destination->name),
        ], false);
    };

    $adresseNiveau = fn (?string $type) => route('travel-destination.index', array_filter([
        'niveau' => $type,
        'q'      => $recherche !== '' ? $recherche : null,
    ]), false);

    $total = collect($comptes)->sum('total');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toutes les destinations | GoExploria</title>
  <meta name="description" content="Parcourez toutes les destinations GoExploria — continents, pays, provinces, régions, secteurs et villes — et repérez leurs points d'intérêt sur la carte.">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css">
  <link rel="stylesheet" href="{{ asset('vendor/travel-destination/css/destination-atlas.css') }}?v={{ @filemtime($atlasCss) ?: '1' }}">

  {{-- Styles AVANT le balisage : le navigateur peint la page au fil de sa
       lecture, et ces règles n'arriveraient sinon qu'après les cartes. --}}
  <style>
    .gxdx-hero {
      position: relative; padding: calc(var(--gx-entete-plateforme, 96px) + 48px) 0 40px;
      background: linear-gradient(135deg, #0a1628 0%, #1a2942 60%, #2a3f5f 100%);
      color: #fff;
    }
    .gxdx-hero__inner { width: min(1280px, 100%); margin: 0 auto; padding: 0 clamp(16px, 3vw, 32px); }
    .gxdx-hero h1 { margin: 6px 0 10px; font-size: clamp(30px, 4vw, 46px); line-height: 1.1; }
    .gxdx-hero p { margin: 0; max-width: 62ch; color: rgba(255, 255, 255, .78); font-size: 15px; line-height: 1.6; }
    .gxdx-hero__eyebrow {
      display: inline-flex; align-items: center; gap: 8px;
      font-size: 11px; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; color: #d4af37;
    }

    /* Recherche : un formulaire GET, pour que le résultat soit partageable. */
    .gxdx-recherche { display: flex; gap: 10px; margin: 22px 0 0; max-width: 560px; }
    .gxdx-recherche input {
      flex: 1 1 auto; min-width: 0; padding: 12px 18px; border-radius: 999px;
      border: 1px solid rgba(255, 255, 255, .18); background: rgba(255, 255, 255, .10);
      color: #fff; font: inherit; font-size: 14px;
    }
    .gxdx-recherche input::placeholder { color: rgba(255, 255, 255, .55); }
    .gxdx-recherche input:focus { outline: 2px solid #d4af37; outline-offset: 1px; }
    .gxdx-recherche button {
      flex: 0 0 auto; padding: 12px 22px; border: 0; border-radius: 999px; cursor: pointer;
      background: #d4af37; color: #0a1628; font: inherit; font-weight: 800; font-size: 13.5px;
    }
    .gxdx-recherche button:hover { filter: brightness(1.06); }
    .gxdx-recherche a {
      align-self: center; color: rgba(255, 255, 255, .7); font-size: 13px; text-decoration: underline;
    }

    /* Barre de niveaux */
    .gxdx-niveaux { display: flex; flex-wrap: wrap; gap: 8px; margin: 26px 0 0; }
    .gxdx-niveau {
      display: inline-flex; align-items: center; gap: 7px; padding: 8px 15px;
      border-radius: 999px; border: 1px solid rgba(255, 255, 255, .20);
      background: rgba(255, 255, 255, .06); color: #fff; text-decoration: none;
      font-size: 13px; font-weight: 600; transition: background .18s ease, border-color .18s ease;
    }
    .gxdx-niveau:hover { background: rgba(255, 255, 255, .14); }
    .gxdx-niveau.is-actif { background: #d4af37; border-color: #d4af37; color: #0a1628; }
    .gxdx-niveau em {
      font-style: normal; font-size: 11px; font-weight: 800; padding: 1px 7px; border-radius: 999px;
      background: rgba(10, 22, 40, .22); color: inherit;
    }
    .gxdx-niveau.is-actif em { background: rgba(10, 22, 40, .18); }

    /* Sections et grille de fiches */
    .gxdx-corps { width: min(1280px, 100%); margin: 0 auto; padding: 40px clamp(16px, 3vw, 32px) 64px; }
    .gxdx-groupe { margin: 0 0 44px; }
    .gxdx-groupe__tete { display: flex; align-items: baseline; justify-content: space-between; gap: 16px; margin: 0 0 16px; }
    .gxdx-groupe__tete h2 { margin: 0; font-size: 21px; }
    .gxdx-groupe__tete a { font-size: 13px; font-weight: 700; color: #8a6d10; text-decoration: none; white-space: nowrap; }
    .gxdx-groupe__tete a:hover { text-decoration: underline; }

    .gxdx-grille { display: grid; gap: 18px; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); }

    .gxdx-fiche {
      display: flex; flex-direction: column; overflow: hidden; text-decoration: none;
      background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; color: #0f172a;
      box-shadow: 0 1px 2px rgba(2, 6, 23, .04);
      transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }
    .gxdx-fiche:hover { transform: translateY(-3px); box-shadow: 0 16px 34px rgba(2, 6, 23, .14); border-color: #d4af37; }
    .gxdx-fiche__media { position: relative; aspect-ratio: 16 / 10; background: #eef2f7; overflow: hidden; }
    .gxdx-fiche__media img { width: 100%; height: 100%; object-fit: cover; display: block; }
    /* Sans visuel, l'initiale sur un aplat : jamais d'image cassée, et les
       fiches gardent la même hauteur. */
    .gxdx-fiche__initiale {
      width: 100%; height: 100%; display: grid; place-items: center;
      background: linear-gradient(135deg, #1a2942, #3d5a80);
      color: rgba(255, 255, 255, .92); font-size: 40px; font-weight: 800;
    }
    .gxdx-fiche__badge {
      position: absolute; top: 10px; left: 10px; padding: 4px 10px; border-radius: 999px;
      background: rgba(10, 22, 40, .78); color: #fff;
      font-size: 10.5px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase;
    }
    .gxdx-fiche__corps { display: flex; flex-direction: column; gap: 4px; padding: 13px 15px 15px; }
    .gxdx-fiche__nom { margin: 0; font-size: 15.5px; font-weight: 800; line-height: 1.3; }
    .gxdx-fiche__meta { margin: 0; font-size: 12.5px; color: #64748b; }
    .gxdx-fiche__lire {
      margin-top: 8px; display: inline-flex; align-items: center; gap: 6px;
      font-size: 12.5px; font-weight: 700; color: #8a6d10;
    }

    .gxdx-vide {
      padding: 36px; border: 1px dashed #cbd5e1; border-radius: 16px;
      text-align: center; color: #64748b; font-size: 14.5px;
    }

    .gxdx-pagination {
      display: flex; flex-wrap: wrap; align-items: center; justify-content: center;
      gap: 12px; margin: 30px 0 0;
    }
    .gxdx-page {
      padding: 9px 18px; border-radius: 999px; border: 1px solid #e5e7eb;
      background: #fff; color: #0f172a; text-decoration: none; font-size: 13.5px; font-weight: 700;
    }
    .gxdx-page:hover { border-color: #d4af37; color: #8a6d10; }
    .gxdx-page.is-inerte { opacity: .4; }
    .gxdx-page__compte { font-size: 13px; color: #64748b; }

    @media (max-width: 640px) {
      .gxdx-recherche { flex-wrap: wrap; }
      .gxdx-grille { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; }
      .gxdx-fiche__nom { font-size: 14px; }
    }
  </style>
</head>
<body>

@include('welcome-home.partials.platform-header')

<header class="gxdx-hero">
  <div class="gxdx-hero__inner">
    <span class="gxdx-hero__eyebrow"><i class="fas fa-earth-americas" aria-hidden="true"></i> Explorer</span>
    <h1>Toutes les destinations</h1>
    <p>
      {{ $total }} destination{{ $total > 1 ? 's' : '' }} référencée{{ $total > 1 ? 's' : '' }}, du continent au quartier.
      Choisissez un niveau, cherchez un nom, ou repérez les lieux directement sur la carte.
    </p>

    <form class="gxdx-recherche" method="get" action="{{ route('travel-destination.index', [], false) }}" role="search">
      @if($niveauActif)<input type="hidden" name="niveau" value="{{ $niveauActif }}">@endif
      <input type="search" name="q" value="{{ $recherche }}" placeholder="Chercher une destination…" aria-label="Chercher une destination">
      <button type="submit">Chercher</button>
      @if($recherche !== '')
        <a href="{{ route('travel-destination.index', array_filter(['niveau' => $niveauActif]), false) }}">Effacer</a>
      @endif
    </form>

    <nav class="gxdx-niveaux" aria-label="Niveaux de destination">
      <a class="gxdx-niveau {{ $niveauActif === null ? 'is-actif' : '' }}" href="{{ $adresseNiveau(null) }}">
        Tous les niveaux <em>{{ $total }}</em>
      </a>
      @foreach($comptes as $type => $info)
        @if($info['total'] > 0)
          <a class="gxdx-niveau {{ $niveauActif === $type ? 'is-actif' : '' }}" href="{{ $adresseNiveau($type) }}">
            {{ $info['pluriel'] }} <em>{{ $info['total'] }}</em>
          </a>
        @endif
      @endforeach
    </nav>
  </div>
</header>

{{-- Carte : tous les points actifs (type `all`), filtrables par catégorie. --}}
@include('travel-destination::landing.partials.map-section')

<main class="gxdx-corps">
  @if($niveauActif === null)

    {{-- ── Aperçu : chaque niveau peuplé, huit destinations ── --}}
    @forelse($apercus as $type => $groupe)
      <section class="gxdx-groupe">
        <div class="gxdx-groupe__tete">
          <h2>{{ $groupe['pluriel'] }}</h2>
          @if($groupe['total'] > count($groupe['items']))
            <a href="{{ $adresseNiveau($type) }}">Voir les {{ $groupe['total'] }} →</a>
          @endif
        </div>

        <div class="gxdx-grille">
          @foreach($groupe['items'] as $destination)
            @include('travel-destination::landing.partials.destination-card', [
              'destination' => $destination,
              'type'        => $type,
              'libelle'     => $groupe['libelle'],
            ])
          @endforeach
        </div>
      </section>
    @empty
      <p class="gxdx-vide">
        @if($recherche !== '')
          Aucune destination ne correspond à « {{ $recherche }} ».
        @else
          Aucune destination active pour le moment.
        @endif
      </p>
    @endforelse

  @else

    {{-- ── Liste complète d'un niveau, paginée ── --}}
    <section class="gxdx-groupe">
      <div class="gxdx-groupe__tete">
        <h2>
          {{ $comptes[$niveauActif]['pluriel'] ?? 'Destinations' }}
          @if($recherche !== '') — « {{ $recherche }} » @endif
        </h2>
        <a href="{{ $adresseNiveau(null) }}">← Tous les niveaux</a>
      </div>

      @if($liste && $liste->total() > 0)
        <div class="gxdx-grille">
          @foreach($liste as $destination)
            @include('travel-destination::landing.partials.destination-card', [
              'destination' => $destination,
              'type'        => $niveauActif,
              'libelle'     => $comptes[$niveauActif]['libelle'] ?? 'Destination',
            ])
          @endforeach
        </div>

        {{-- Pagination écrite ici : la vue par défaut de Laravel suppose
             Tailwind, que ce site ne charge pas. --}}
        @if($liste->hasPages())
          <nav class="gxdx-pagination" aria-label="Pages de résultats">
            @if($liste->onFirstPage())
              <span class="gxdx-page is-inerte" aria-disabled="true">← Précédent</span>
            @else
              <a class="gxdx-page" href="{{ $liste->previousPageUrl() }}" rel="prev">← Précédent</a>
            @endif

            <span class="gxdx-page__compte">
              Page {{ $liste->currentPage() }} sur {{ $liste->lastPage() }}
              ({{ $liste->total() }} destination{{ $liste->total() > 1 ? 's' : '' }})
            </span>

            @if($liste->hasMorePages())
              <a class="gxdx-page" href="{{ $liste->nextPageUrl() }}" rel="next">Suivant →</a>
            @else
              <span class="gxdx-page is-inerte" aria-disabled="true">Suivant →</span>
            @endif
          </nav>
        @endif
      @else
        <p class="gxdx-vide">
          @if($recherche !== '')
            Aucune destination ne correspond à « {{ $recherche }} » à ce niveau.
          @else
            Aucune destination active à ce niveau.
          @endif
        </p>
      @endif
    </section>

  @endif
</main>

<footer class="site-footer">
  <div class="container">
    <div class="footer-bottom">
      <span>&copy; {{ date('Y') }} GoExploria. Tous droits réservés.</span>
      <div class="footer-legal">
        <a href="{{ url('/') }}">Accueil</a>
        <a href="{{ route('travel-destination.index', [], false) }}">Destinations</a>
      </div>
    </div>
  </div>
</footer>

<script src="{{ asset('vendor/travel-destination/js/destination-atlas.js') }}?v={{ @filemtime($atlasJs) ?: '1' }}"></script>

{{-- Moteur de la carte (Leaflet + OpenStreetMap + grappes), puis le filtre
     hiérarchique posé au-dessus d'elle. --}}
@include('travel-destination::landing.partials.map-scripts')
@include('travel-destination::landing.partials.map-filter')

@include('components.ads-popup', ['adContext' => 'destinations'])

</body>
</html>
