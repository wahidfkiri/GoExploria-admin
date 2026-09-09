{{-- ==========================================================================
     CARTE MONDIALE — greffée dans la page d'une activité à la place de sa
     section d'attente `data-gx-map` (docs/TEMPLATES-CMS.md §4).

     Le MOTEUR n'est pas réécrit : c'est celui des pages de destination
     (travel-destination::landing.partials.map-scripts, Leaflet + grappes, ou
     Google Maps si une clé est configurée). Seul le balisage change, pour
     épouser le gabarit de la page d'activité.

     ⚠ Les identifiants sont ceux qu'attend le moteur — #travel-map,
     #mapFilters, #mapDetailModal, #mapModalClose, #mapModalBackdrop,
     #mapModalVideo, #mapModalGallery, #mapModalMeta, #mapModalWebsite,
     #map-modal-title. Les deux écouteurs de fermeture sont posés SANS garde
     de nullité : retirer la modale casserait tout le script de la carte.

     Variables (fournies par LandingPageController::contexteCarteMonde) :
     $entity, $normalizedType, $slug, $childEntities, $mapCategories,
     $mapPoints, $activity, $mapFilterChain, $typeLabels.
     ========================================================================== --}}

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css">
<link rel="stylesheet" href="{{ asset('vendor/activities/css/activity-map.css') }}?v={{ @filemtime(public_path('vendor/activities/css/activity-map.css')) ?: '1' }}">

<section class="content-inner bg-white plx-carte" id="plx-carte" aria-labelledby="plx-carte-titre">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center m-b30">
        <div class="section-head style-10">
          <div class="sub-title">S’orienter</div>
          <h2 class="title" id="plx-carte-titre">La carte des points d’intérêt</h2>
          <p class="plx-carte-chapeau">
            {{ $mapPoints->count() }} {{ $mapPoints->count() > 1 ? 'lieux référencés' : 'lieu référencé' }}
            dans le monde. Cliquez sur un marqueur pour ouvrir sa fiche : photos,
            vidéo, horaires et coordonnées.
          </p>
        </div>
      </div>

      <div class="col-12">
        {{-- FILTRE PAR DESTINATION — même dispositif que les pages de
             destination (travel-destination::landing.partials.map-filter).
             La carte couvre le monde : la cascade part donc du continent, et
             chaque choix recentre ET zoome la carte sur la destination avant
             de recharger ses seuls points d'intérêt.

             Les identifiants #mapFilterChain / #mapFilterReset sont ceux
             qu'attend le filtre : les renommer le rendrait inerte. --}}
        @if(!empty($mapFilterChain))
          <div class="map-filterbar plx-carte-destinations" id="mapFilterBar">
            <div class="map-filterbar__head">
              <span class="plx-carte-destinations__titre">Filtrer par destination</span>
              <button type="button" class="map-filterbar__reset" id="mapFilterReset" hidden>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/></svg>
                Tout le monde
              </button>
            </div>

            <div class="map-filterbar__chain" id="mapFilterChain">
              @foreach($mapFilterChain as $level)
                <div class="map-filterfield" data-level="{{ $level['type'] }}">
                  <label class="map-filterfield__label" for="mapFilter-{{ $level['type'] }}">{{ $level['label'] }}</label>
                  <input type="text" class="map-filterfield__input" id="mapFilter-{{ $level['type'] }}"
                         placeholder="Tous — {{ mb_strtolower($level["label"]) }}s"
                         autocomplete="off" role="combobox" aria-expanded="false"
                         aria-label="Filtrer par {{ mb_strtolower($level["label"]) }}"
                         data-options='@json($level['options'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS)'>
                  <div class="map-filterfield__list" role="listbox"></div>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        {{-- Filtres par catégorie : le moteur les reconstruit à partir des
             points réellement chargés (rebuildCategoryFilters). --}}
        <div class="plx-carte-filtres" id="mapFilters">
          <button type="button" class="map-filter-btn active" data-filter="all">Tous</button>
        </div>

        <div class="plx-carte-cadre">
          <div id="travel-map" class="travel-map"></div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Fiche détaillée d'un point, ouverte par le moteur (il bascule
     directement `style.display`). --}}
<div class="map-modal" id="mapDetailModal" style="display:none" role="dialog" aria-modal="true" aria-labelledby="map-modal-title">
  <div class="map-modal__backdrop" id="mapModalBackdrop"></div>
  <div class="map-modal__content">
    <button type="button" class="map-modal__close" id="mapModalClose" aria-label="Fermer">&times;</button>
    <div class="map-modal__body">
      <div class="map-modal__video" id="mapModalVideo"></div>
      <div class="map-modal__gallery" id="mapModalGallery"></div>
      <div class="map-modal__info">
        <h3 class="map-modal__title" id="map-modal-title"></h3>
        <div class="map-modal__description"></div>
        <div class="map-modal__meta" id="mapModalMeta"></div>
        <div class="map-modal__actions">
          <a href="#" class="btn btn-primary" id="mapModalWebsite" target="_blank" rel="noopener">Visiter le site</a>
        </div>
      </div>
    </div>
  </div>
</div>

@include('travel-destination::landing.partials.map-scripts', [
    'entity' => $entity,
    'normalizedType' => $normalizedType,
    'slug' => $slug,
    'childEntities' => $childEntities,
    'mapCategories' => $mapCategories,
    'mapPoints' => $mapPoints,
])

@if(!empty($mapFilterChain))
  {{-- « Tout le monde » : le filtre ne rappelle la vue d'ensemble que si la
       destination de la page a des coordonnées, et « Le monde » n'en a pas.
       On lui en donne (celles du centre de la vue globale du moteur) et on
       redéfinit fitAll, qui sur une page de destination recadre sur l'entité :
       ici, il doit rendre la vue mondiale.

       L'écouteur est posé AVANT que le moteur ne s'initialise (il émet
       gx:map-ready depuis son DOMContentLoaded), et le filtre relit
       window.GX_DEST_MAP à chaque usage : la redéfinition est donc vue. --}}
  <script>
    document.addEventListener('gx:map-ready', function () {
      var moteur = window.GX_DEST_MAP;
      if (!moteur) return;
      moteur.fitAll = function () { moteur.focus(20, 0, 2); };
    });
  </script>

  @include('travel-destination::landing.partials.map-filter', [
      'entity' => (object) ['latitude' => 20, 'longitude' => 0],
      'normalizedType' => $normalizedType,
      'slug' => $slug,
      'typeLabels' => $typeLabels,
  ])
@endif
