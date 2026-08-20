{{-- ==========================================================================
     CARTE DE LA DESTINATION — balisage (template « Carnet d'Atlas »).

     Exigence client : la carte est TOUJOURS la première section de contenu.
     Les identifiants sont ceux qu'attend landing/partials/map-scripts.blade.php
     (#travel-map, #mapFilters, #mapGeoSearch, #mapGeoDropdown, #mapDetailModal) :
     les renommer casserait le moteur de carte.

     Variables : $entity, $normalizedType, $mapPoints (facultatif, pour le compte).
     ========================================================================== --}}
@php
    $mapLat = is_numeric($entity->latitude ?? null) ? (float) $entity->latitude : null;
    $mapLng = is_numeric($entity->longitude ?? null) ? (float) $entity->longitude : null;
    $mapPointCount = isset($mapPoints) ? $mapPoints->count() : 0;
    $mapChildCount = isset($childEntities) ? $childEntities->count() : 0;
    $mapActivityCount = isset($destinationActivities) ? $destinationActivities->count() : 0;
@endphp

<section class="map-section destination-map" id="map" aria-labelledby="map-heading">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">S'orienter</span>
      <h2 id="map-heading">Carte de {{ $entity->name }}</h2>
      <p>Repérez d'un coup d'œil les lieux, activités et adresses de la destination.</p>
    </div>

    {{-- ======================================================================
         FILTRE HIÉRARCHIQUE — un champ par niveau, dans l'ordre du fil
         d'Ariane (Continent → Pays → Province → Région → Secteur → Ville →
         Arrondissement → Quartier).

         Les niveaux jusqu'à la destination courante sont figés : on est déjà
         sur cette page. Les niveaux en dessous sont des champs de recherche
         qui se remplissent en cascade, et chaque choix recentre la carte.
         ====================================================================== --}}
    <div class="map-filterbar reveal" id="mapFilterBar">
      <div class="map-filterbar__head">
        <span class="eyebrow">Filtrer la carte</span>
        <button type="button" class="map-filterbar__reset" id="mapFilterReset" hidden>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/></svg>
          Toute la destination
        </button>
      </div>

      <div class="map-filterbar__chain" id="mapFilterChain">
        @foreach($mapFilterChain as $level)
          @if($level['fixed'])
            <div class="map-filterfield map-filterfield--fixed">
              <span class="map-filterfield__label">{{ $level['label'] }}</span>
              <span class="map-filterfield__fixed-value">{{ $level['current'] }}</span>
            </div>
          @else
            <div class="map-filterfield" data-level="{{ $level['type'] }}">
              <label class="map-filterfield__label" for="mapFilter-{{ $level['type'] }}">{{ $level['label'] }}</label>
              <input type="text" class="map-filterfield__input" id="mapFilter-{{ $level['type'] }}"
                     placeholder="Tous — {{ mb_strtolower($level["label"]) }}s"
                     autocomplete="off" role="combobox" aria-expanded="false"
                     aria-label="Filtrer par {{ mb_strtolower($level["label"]) }}"
                     data-options='@json($level['options'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS)'>
              <div class="map-filterfield__list" role="listbox"></div>
            </div>
          @endif
        @endforeach
      </div>

      <div class="map-filters" id="mapFilters">
        <button class="map-filter-btn active" data-filter="all">Tous</button>
      </div>
    </div>

  </div>

  {{-- Carte PLEINE LARGEUR : elle sort du conteneur, le panneau d'informations
       se pose dessus (et s'empile dessous en mobile, cf. destination-atlas.css). --}}
  <div class="map-fullbleed reveal">
    <div class="map-canvas">
      <div id="travel-map" class="travel-map"></div>
    </div>
    <div class="map-info map-info--floating">
      <h3>{{ $entity->name }}</h3>
      @if($mapLat !== null && $mapLng !== null)
        <p class="coord">
          {{ number_format(abs($mapLat), 4) }}° {{ $mapLat >= 0 ? 'N' : 'S' }},
          {{ number_format(abs($mapLng), 4) }}° {{ $mapLng >= 0 ? 'E' : 'O' }}
        </p>
      @endif
      <p>Cliquez sur un marqueur pour ouvrir sa fiche : photos, vidéo, horaires et coordonnées.</p>
      <ul class="map-poi-list">
        <li><span class="name">Points d'intérêt</span><span class="dist">{{ $mapPointCount }}</span></li>
        @if($mapChildCount > 0)
          <li><span class="name">Destinations à explorer</span><span class="dist">{{ $mapChildCount }}</span></li>
        @endif
        @if($mapActivityCount > 0)
          <li><span class="name">Activités</span><span class="dist">{{ $mapActivityCount }}</span></li>
        @endif
      </ul>
      @if($mapLat !== null && $mapLng !== null)
        <a href="https://www.openstreetmap.org/?mlat={{ $mapLat }}&mlon={{ $mapLng }}#map=10/{{ $mapLat }}/{{ $mapLng }}"
           target="_blank" rel="noopener" class="btn btn-primary btn-sm">
          Itinéraire
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      @endif
    </div>
  </div>
</section>

{{-- Fiche détaillée d'un point d'intérêt (ouverte par le script de la carte,
     qui bascule directement `style.display`). --}}
<div class="map-modal" id="mapDetailModal" style="display:none" role="dialog" aria-modal="true" aria-labelledby="map-modal-title">
  <div class="map-modal__backdrop" id="mapModalBackdrop"></div>
  <div class="map-modal__content">
    <button class="map-modal__close" id="mapModalClose" aria-label="Fermer">&times;</button>
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
