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
     $mapPoints, $activity.
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
