{{-- ==========================================================================
     CARTE DE LA DESTINATION — moteur (Leaflet + grappes, ou Google Maps si une
     clé est configurée).

     Extrait tel quel de la vue historique (landing/classic.blade.php) pour être
     partagé avec le template « Carnet d'Atlas ». Le balisage attendu est celui
     de landing/partials/map-section.blade.php : mêmes identifiants (#travel-map,
     #mapFilters, #mapGeoSearch, #mapGeoDropdown, #mapDetailModal…).

     Variables requises : $entity, $normalizedType, $slug, $childEntities,
     $mapCategories, $mapPoints.
     ========================================================================== --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

@php
    // Bascule Google Maps (rues/satellite + Street View). Sans clé → Leaflet.
    $gmKey = config('services.google.maps.key');
    $gmMapId = config('services.google.maps.map_id');
@endphp
@if($gmKey)
<script>
    window.GX_MAPS = window.GX_MAPS || { key: @json($gmKey), mapId: @json($gmMapId ?: '') };
</script>
<script src="{{ asset('js/geo-map/gx-google-map.js') }}?v={{ @filemtime(public_path('js/geo-map/gx-google-map.js')) ?: '4' }}"></script>
<style>
    .gm-style .map-popup { width: 280px; max-width: 78vw; }
    .gm-style .map-popup__video { height: 160px; background: #000; }
    .gm-style .map-popup__video iframe { width: 100%; height: 100%; border: 0; display: block; }
    .gm-style .map-popup__body { padding: 12px 14px; }
    .gm-style .map-popup__title { font-size: 0.95rem; font-weight: 700; margin: 0 0 6px; color: #111827; }
    .gm-style .map-popup__desc { font-size: 0.8rem; color: #4b5563; line-height: 1.5; margin: 0 0 10px; }
    .gm-style .map-popup__detail-btn { display: block; width: 100%; padding: 9px 14px; background: #F5A623; color: #000; border: 0; border-radius: 8px; font-size: 0.82rem; font-weight: 700; cursor: pointer; }
</style>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
  var mapEl = document.getElementById('travel-map');
  if (!mapEl) return;

  @php
    $centerLat = is_numeric($entity->latitude) ? (float)$entity->latitude : null;
    $centerLng = is_numeric($entity->longitude) ? (float)$entity->longitude : null;
    if (is_null($centerLat) && isset($childEntities) && $childEntities->count() > 0) {
      $withLat = $childEntities->filter(fn($ce) => is_numeric($ce->latitude));
      if ($withLat->count() > 0) {
        $centerLat = ((float)$withLat->min('latitude') + (float)$withLat->max('latitude')) / 2;
        $centerLng = ((float)$withLat->min('longitude') + (float)$withLat->max('longitude')) / 2;
      }
    }
  @endphp
  var entityLat = {{ $centerLat ?? 0 }};
  var entityLng = {{ $centerLng ?? 0 }};
  var entityName = {!! json_encode($entity->name ?? '', JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};
  var entityType = {!! json_encode($normalizedType, JSON_UNESCAPED_UNICODE) !!};
  var mapPointsUrl = '{{ route("travel-destination.map-points", ["type" => $normalizedType, "slug" => $slug], false) }}';
  var childEntities = {!! json_encode($childEntities->map(function($ce) {
        $typeName = strtolower(class_basename($ce));
        $zMap = ['continent' => 3, 'country' => 5, 'province' => 7, 'region' => 9, 'ville' => 11, 'city' => 11, 'secteur' => 13];
        return ['name' => $ce->name, 'slug' => $ce->slug ?? (string)$ce->id, 'type' => class_basename($ce), 'latitude' => $ce->latitude ? (float)$ce->latitude : null, 'longitude' => $ce->longitude ? (float)$ce->longitude : null, 'zoom' => $zMap[$typeName] ?? 10];
      })->values(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};
  var mapCategories = {!! json_encode($mapCategories->keyBy('slug')->map(function($mc) {
        return ['name' => $mc->name, 'icon_class' => $mc->icon_class, 'color' => $mc->color, 'image' => $mc->image];
      })->toArray(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};
  var serverPoints = {!! json_encode($mapPoints->map(function($p) {
        $img = $p->mainImage ? $p->mainImage->url : ($p->youtube_id ? 'https://img.youtube.com/vi/' . $p->youtube_id . '/hqdefault.jpg' : null);
        return [
          'id' => $p->id,
          'title' => $p->title,
          'description' => $p->description,
          'latitude' => (float)$p->latitude,
          'longitude' => (float)$p->longitude,
          'category' => $p->category,
          'type' => $p->type,
          'adresse' => $p->adresse,
          'ville' => $p->ville,
          'youtube_url' => $p->youtube_url,
          'youtube_id' => $p->youtube_id,
          'thumbnail' => $img,
          'is_featured' => (bool)$p->is_featured,
          'has_details_page' => (bool)$p->has_details_page,
          'views' => $p->views,
          'details' => $p->details ? [
            'long_description' => $p->details->long_description,
            'phone' => $p->details->phone,
            'email' => $p->details->email,
            'website' => $p->details->website,
            'horaires' => $p->details->horaires,
            'services' => $p->details->services,
            'tarifs' => $p->details->tarifs,
            'rating' => (float)$p->details->rating,
            'reviews_count' => $p->details->reviews_count,
            'slug' => $p->details->slug,
          ] : null,
          'images' => $p->images->map(fn($img) => ['url' => $img->url, 'thumbnail' => $img->thumb_url, 'caption' => $img->caption, 'is_main' => (bool)$img->is_main])->toArray(),
        ];
      })->values(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};
  var zoomByType = { continent: 3, country: 5, province: 7, region: 9, ville: 11, city: 11, secteur: 13 };
  var isContinent = entityType === 'continent';
  var defaultZoom = entityLat && !isContinent ? (zoomByType[entityType] || 6) : 2;
  var center = entityLat ? [entityLat, entityLng] : [20, 0];

  // ── Backend Google Maps (rues/satellite + Street View natif) ─────────
  // Réutilise buildPopupHtml / showPlaceModal / getCategoryData / closePlaceModal
  // (hoistées) → MÊME logique de marqueurs + popup vidéo + modale que Leaflet.
  if (window.GX_MAPS && window.GX_MAPS.key && window.GxGoogleMap) {
    window.GxGoogleMap.load(window.GX_MAPS.key, { mapId: window.GX_MAPS.mapId })
      .then(function () {
        var eng = window.GxGoogleMap.create('travel-map', {
          center: { lat: center[0], lng: center[1] },
          zoom: defaultZoom,
          mapId: window.GX_MAPS.mapId || undefined,
          streetView: true,
          cluster: true
        });
        var gPoints = [];

        if (entityLat) {
          eng.addMarker({ name: entityName }, {
            position: { lat: entityLat, lng: entityLng }, color: '#F5A623',
            iconHtml: '<div style="width:30px;height:30px;border-radius:50%;background:#F5A623;display:flex;align-items:center;justify-content:center;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,.4);color:#000"><svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg></div>',
            popupHtml: '<div class="map-popup"><div class="map-popup__body"><strong>' + escapeHtml(entityName) + '</strong></div></div>'
          });
        }

        function gColor(cat) {
          var cd = getCategoryData(cat);
          if (cd && cd.color) return cd.color;
          var m = { sightseeing:'#e74c3c', museum:'#3498db', restaurant:'#f39c12', hotel:'#2ecc71', adventure:'#9b59b6', shopping:'#1abc9c' };
          return m[cat] || '#e74c3c';
        }
        function gRender(data) {
          eng.clearMarkers();
          gPoints = data.slice();
          data.forEach(function (p, idx) {
            if (p.latitude == null || p.longitude == null) return;
            var cd = getCategoryData(p.category) || {};
            eng.addMarker(p, {
              position: { lat: Number(p.latitude), lng: Number(p.longitude) },
              icon: { color: gColor(p.category), iconClass: cd.icon_class, image: cd.image },
              popupHtml: buildPopupHtml(p, idx),
              featured: !!p.is_featured
            });
          });
          if (!isContinent) eng.fitToMarkers(40);
        }

        // Bouton « Voir détails » (délégation, robuste avec les InfoWindow).
        document.addEventListener('click', function (e) {
          var b = e.target.closest && e.target.closest('.map-popup__detail-btn');
          if (!b) return;
          var pt = gPoints[parseInt(b.getAttribute('data-index'), 10)];
          if (pt) showPlaceModal(pt);
        });

        // Fermeture du modal (handlers d'origine après le return → rebranchés ici).
        var mClose = document.getElementById('mapModalClose');
        var mBackdrop = document.getElementById('mapModalBackdrop');
        if (mClose) mClose.addEventListener('click', closePlaceModal);
        if (mBackdrop) mBackdrop.addEventListener('click', closePlaceModal);
        document.addEventListener('keydown', function (e) {
          if (e.key !== 'Escape') return;
          var m = document.getElementById('mapDetailModal');
          if (m && m.style.display !== 'none') closePlaceModal();
        });

        // Adaptateur pour le filtre hiérarchique (map-filter.blade.php) :
        // il ne connaît ni Google ni Leaflet, seulement ces deux verbes.
        window.GX_DEST_MAP = {
          focus: function (lat, lng, zoom) { eng.panTo(lat, lng, zoom); },
          render: function (points) { gRender(points); },
          fitAll: function () { eng.fitToMarkers(40); }
        };
        document.dispatchEvent(new CustomEvent('gx:map-ready'));

        // Points : serverPoints pré-chargés, sinon AJAX (comme Leaflet).
        if (serverPoints && serverPoints.length) gRender(serverPoints);
        else fetch(mapPointsUrl).then(function (r) { return r.json(); })
          .then(function (res) { if (res.success && res.data && res.data.length) gRender(res.data); })
          .catch(function (err) { console.error('Travel map (google) load error:', err); });
      })
      .catch(function (e) { console.warn('Google Maps indisponible :', e); });
    return;
  }

  var map = L.map('travel-map', {
    center: center,
    zoom: defaultZoom,
    zoomControl: true,
    scrollWheelZoom: true
  });

  var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '\u00a9 <a href="https://openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);
  map.whenReady(function () { map.invalidateSize(); });

  if (entityLat) {
    L.marker([entityLat, entityLng], {
      icon: L.divIcon({
        className: 'map-marker map-marker--main',
        html: '<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>',
        iconSize: [24, 24],
        iconAnchor: [12, 24]
      })
    }).addTo(map).bindPopup('<strong>' + entityName + '</strong>');
  }

  // Regroupement des markers en grappes « +N » : le clic sur une grappe
  // zoome automatiquement sur la zone pour révéler les points individuels.
  function makeMapClusterLayer() {
    if (typeof L.markerClusterGroup !== 'function') return L.layerGroup();
    return L.markerClusterGroup({
      showCoverageOnHover: false,
      maxClusterRadius: 60,
      spiderfyOnMaxZoom: true,
      zoomToBoundsOnClick: true,
      iconCreateFunction: function (cluster) {
        var n = cluster.getChildCount();
        var size = n >= 50 ? 44 : (n >= 20 ? 38 : 32);
        return L.divIcon({
          html: '<div style="width:' + size + 'px;height:' + size + 'px;border-radius:50%;background:linear-gradient(135deg,#F5A623,#e08900);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:' + (n >= 100 ? 13 : 15) + 'px;border:3px solid #fff;box-shadow:0 3px 12px rgba(0,0,0,0.45);cursor:pointer">+' + n + '</div>',
          className: 'marker-cluster-custom',
          iconSize: [size, size],
          iconAnchor: [size / 2, size / 2]
        });
      }
    });
  }
  var markersLayer = makeMapClusterLayer().addTo(map);

  var pointsData = [];
  var currentPointsData = [];
  var geoFilterActive = null;
  var geoFilterEntity = null;

  var childTypeMap = { continent: 'country', country: 'province', province: 'region', region: 'city', city: 'secteur', secteur: '' };
  var childZoomMap = { continent: 3, country: 5, province: 7, region: 9, city: 11, secteur: 13 };
  var childType = childTypeMap[entityType] || '';

  function zoomToEntity(lat, lng, zoom) {
    if (lat !== undefined && lat !== null && lng !== undefined && lng !== null) {
      map.flyTo([lat, lng], zoom || defaultZoom, { duration: 1 });
    }
  }

  var geoSearch = document.getElementById('mapGeoSearch');
  var geoDropdown = document.getElementById('mapGeoDropdown');
  var geoOptions = [];
  if (geoSearch && geoDropdown && childType && childEntities.length) {
    geoOptions = [{ label: 'Tout ' + entityName, value: '', type: '' }].concat(
      childEntities.map(function (ce) { return { label: ce.name, value: ce.slug, type: ce.type }; })
    );
    function renderGeoOptions(filter) {
      geoDropdown.innerHTML = '';
      var match = filter ? filter.toLowerCase() : '';
      geoOptions.forEach(function (opt) {
        if (match && opt.label.toLowerCase().indexOf(match) === -1) return;
        var div = document.createElement('div');
        div.className = 'map-geo-option';
        if (!opt.value && !geoFilterActive) div.classList.add('active');
        else if (opt.value && geoFilterActive && geoFilterActive.slug === opt.value) div.classList.add('active');
        div.textContent = opt.label;
        div.addEventListener('click', function () {
          if (!opt.value) { geoFilterActive = null; geoFilterEntity = null; geoSearch.value = opt.label; zoomToEntity(entityLat, entityLng, defaultZoom); }
          else {
            geoFilterActive = { type: opt.type, slug: opt.value };
            geoSearch.value = opt.label;
            var matched = childEntities.filter(function (ce) { return ce.slug == opt.value; });
            geoFilterEntity = matched.length ? matched[0] : null;
            if (geoFilterEntity && geoFilterEntity.latitude && geoFilterEntity.longitude) {
              zoomToEntity(geoFilterEntity.latitude, geoFilterEntity.longitude, geoFilterEntity.zoom || 10);
            }
          }
          geoDropdown.querySelectorAll('.map-geo-option').forEach(function (o) { o.classList.remove('active'); });
          div.classList.add('active');
          geoDropdown.style.display = 'none';
        });
        geoDropdown.appendChild(div);
      });
    }
    renderGeoOptions('');
    geoSearch.addEventListener('input', function () { renderGeoOptions(this.value); geoDropdown.style.display = 'block'; });
    geoSearch.addEventListener('focus', function () { renderGeoOptions(this.value); geoDropdown.style.display = 'block'; });
    geoSearch.addEventListener('blur', function () { setTimeout(function () { geoDropdown.style.display = 'none'; }, 200); });
    geoSearch.value = geoOptions[0].label;
  }

  function renderPointsOnMap(data) {
    markersLayer.clearLayers();
    pointsData = [];
    currentPointsData = data;
    var bounds = [];
    var categories = {};
    var markerIndex = 0;
    data.forEach(function (p) {
      var cat = p.category || 'other';
      if (!categories[cat]) categories[cat] = true;
      pointsData.push(p);
      var popupHtml = buildPopupHtml(p, markerIndex);
      var marker = L.marker([p.latitude, p.longitude], { icon: getMarkerIcon(p.category, p.is_featured), zIndexOffset: p.is_featured ? 1000 : 0 })
        .addTo(markersLayer)
        .bindPopup(popupHtml, { maxWidth: 320, className: 'map-popup-wrapper' });
      marker._pointIndex = markerIndex;
      markerIndex++;
      bounds.push([p.latitude, p.longitude]);
    });
    if (bounds.length && !isContinent) map.fitBounds(bounds, { padding: [40, 40], maxZoom: 14 });
    rebuildCategoryFilters(categories, data);
  }

  function renderChildEntities() {
    if (!childEntities || !childEntities.length) return;
    markersLayer.clearLayers();
    var bounds = [];
    childEntities.forEach(function (ce) {
      if (!ce.latitude || !ce.longitude) return;
      var marker = L.marker([ce.latitude, ce.longitude], {
        icon: L.divIcon({
          className: 'map-marker map-marker--child',
          html: '<div style="width:22px;height:22px;border-radius:50%;background:var(--amber,#f5a623);display:flex;align-items:center;justify-content:center;box-shadow:0 2px 7px rgba(0,0,0,0.4);border:2px solid #fff;font-size:11px;font-weight:700;color:#000">' + ce.name.charAt(0) + '</div>',
          iconSize: [22, 22],
          iconAnchor: [11, 22]
        })
      }).addTo(markersLayer);
      marker.bindPopup('<strong>' + ce.name + '</strong><br><a href="/travel-destination/' + (childType || 'country') + '/' + ce.slug + '" style="color:var(--amber,#f5a623)">Voir les d\u00e9tails</a>');
      bounds.push([ce.latitude, ce.longitude]);
    });
    if (bounds.length && !isContinent) map.fitBounds(bounds, { padding: [40, 40], maxZoom: 5 });
  }

  function reloadMapPoints() {
    if (serverPoints && serverPoints.length) {
      renderPointsOnMap(serverPoints);
      return;
    }
    fetch(mapPointsUrl)
      .then(function (r) { return r.json(); })
      .then(function (res) {
        if (!res.success || !res.data || !res.data.length) {
          if (geoFilterActive) { markersLayer.clearLayers(); return; }
          renderChildEntities();
          return;
        }
        console.log('Map points received:', res.data.length);
        renderPointsOnMap(res.data);
      })
      .catch(function (err) { console.error('Map reload error:', err); var mapEl = document.getElementById('travel-map'); if (mapEl) mapEl.insertAdjacentHTML('afterend', '<div style="padding:12px;background:#fee;color:#c00;border-radius:8px">Map points failed to load: ' + err.message + '</div>'); });
  }

  // Même contrat que la branche Google, pour que le filtre hiérarchique
  // fonctionne à l'identique quel que soit le moteur de carte actif.
  window.GX_DEST_MAP = {
    focus: function (lat, lng, zoom) { map.flyTo([lat, lng], zoom || defaultZoom, { duration: 1 }); },
    render: function (points) { renderPointsOnMap(points); },
    fitAll: function () { zoomToEntity(entityLat, entityLng, defaultZoom); }
  };
  document.dispatchEvent(new CustomEvent('gx:map-ready'));

  function rebuildCategoryFilters(categories, data) {
    var filterEl = document.getElementById('mapFilters');
    if (!filterEl) return;
    filterEl.innerHTML = '<button class="map-filter-btn active" data-filter="all">Tous</button>';
    mapCategories && Object.keys(mapCategories).forEach(function (slug) {
      var cat = mapCategories[slug];
      var btn = document.createElement('button');
      btn.className = 'map-filter-btn';
      btn.setAttribute('data-filter', slug);
      var iconHtml = '';
      if (cat.image) {
        iconHtml = '<img src="' + cat.image + '" alt="" class="map-filter-btn__img" />';
      } else if (cat.icon_class) {
        iconHtml = '<span class="' + cat.icon_class + '" style="color:' + (cat.color || '#e74c3c') + '"></span>';
      }
      btn.innerHTML = iconHtml ? '<span class="map-filter-btn__icon">' + iconHtml + '</span><span class="map-filter-btn__label">' + (cat.name || slug) + '</span>' : (cat.name || slug);
      filterEl.appendChild(btn);
    });
    filterEl.querySelectorAll('.map-filter-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        filterEl.querySelectorAll('.map-filter-btn').forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');
        var filter = btn.getAttribute('data-filter');
        markersLayer.clearLayers();
        data.forEach(function (p, idx) {
          if (filter === 'all' || resolveCategorySlug(p.category) === filter) {
            var marker = L.marker([p.latitude, p.longitude], { icon: getMarkerIcon(p.category, p.is_featured), zIndexOffset: p.is_featured ? 1000 : 0 })
              .addTo(markersLayer)
              .bindPopup(buildPopupHtml(p, idx), { maxWidth: 320, className: 'map-popup-wrapper' });
            marker._pointIndex = idx;
          }
        });
      });
    });
  }

  function youtubeEmbedUrl(youtubeUrl, youtubeId) {
    var id = youtubeId || '';
    if (!id && youtubeUrl) {
      var m = youtubeUrl.match(/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/);
      if (m) id = m[1];
    }
    return id ? 'https://www.youtube.com/embed/' + id + '?autoplay=1' : '';
  }

  function getCategoryData(category) {
    if (!category) return null;
    if (mapCategories[category]) return mapCategories[category];
    var aliasMap = {
      'adventure': 'sport', 'nature': 'natural', 'culture': 'cultural',
      'history': 'historic', 'science': 'museum', 'family': 'entertainment',
      'park': 'parc', 'video_map': 'entertainment'
    };
    var alias = aliasMap[category];
    if (alias && mapCategories[alias]) return mapCategories[alias];
    return null;
  }

  function resolveCategorySlug(category) {
    if (!category) return null;
    if (mapCategories[category]) return category;
    var aliasMap = {
      'adventure': 'sport', 'nature': 'natural', 'culture': 'cultural',
      'history': 'historic', 'science': 'museum', 'family': 'entertainment',
      'park': 'parc', 'video_map': 'entertainment'
    };
    return aliasMap[category] || null;
  }

  function getMarkerIcon(category, featured) {
    var size = featured ? 30 : 24;
    var ring = featured ? 'box-shadow:0 0 0 3px rgba(255,193,7,0.45),0 3px 10px rgba(0,0,0,0.5);border:2px solid #FFC107' : 'box-shadow:0 2px 7px rgba(0,0,0,0.4);border:2px solid #fff';
    var star = featured ? '<span style="position:absolute;top:-5px;right:-5px;width:13px;height:13px;border-radius:50%;background:#FFC107;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(0,0,0,0.4);z-index:2"><svg viewBox="0 0 24 24" width="8" height="8" fill="#fff"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></span>' : '';
    var catData = getCategoryData(category);
    if (catData && catData.image) {
      return L.divIcon({
        className: 'map-marker',
        html: '<div style="width:' + size + 'px;height:' + size + 'px;border-radius:50%;background-size:cover;background-image:url(' + catData.image + ');' + ring + ';position:relative">' + star + '</div>',
        iconSize: [size + 4, size + 4],
        iconAnchor: [(size + 4) / 2, size + 4]
      });
    } else if (catData && catData.icon_class) {
      var color = catData.color || '#e74c3c';
      return L.divIcon({
        className: 'map-marker',
        html: '<div style="width:' + size + 'px;height:' + size + 'px;border-radius:50%;background:' + color + ';display:flex;align-items:center;justify-content:center;' + ring + ';position:relative"><span class="' + catData.icon_class + '" style="font-size:' + Math.round(size * 0.55) + 'px;color:#fff"></span>' + star + '</div>',
        iconSize: [size + 4, size + 4],
        iconAnchor: [(size + 4) / 2, size + 4]
      });
    }
    var colors = { sightseeing: '#e74c3c', museum: '#3498db', restaurant: '#f39c12', hotel: '#2ecc71', adventure: '#9b59b6', shopping: '#1abc9c', default: '#e74c3c' };
    var color = colors[category] || colors.default;
    return L.divIcon({
      className: 'map-marker',
      html: '<div style="width:' + size + 'px;height:' + size + 'px;border-radius:50%;background:' + color + ';display:flex;align-items:center;justify-content:center;' + ring + ';position:relative"><svg viewBox="0 0 24 24" width="' + Math.round(size * 0.6) + '" height="' + Math.round(size * 0.6) + '" fill="#fff"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>' + star + '</div>',
      iconSize: [size + 4, size + 4],
      iconAnchor: [(size + 4) / 2, size + 4]
    });
  }

  function escapeHtml(str) {
    if (!str) return '';
    var d = document.createElement('div');
    d.appendChild(document.createTextNode(str));
    return d.innerHTML;
  }

  function buildPopupHtml(p, idx) {
    var embedUrl = (p.youtube_url || p.youtube_id) ? youtubeEmbedUrl(p.youtube_url, p.youtube_id) : '';
    var html = '<div class="map-popup">';
    if (embedUrl) {
      html += '<div class="map-popup__video">';
      html += '<iframe src="' + embedUrl + '" frameborder="0" allowfullscreen></iframe>';
      html += '</div>';
    }
    html += '<div class="map-popup__body">';
    html += '<h4 class="map-popup__title">' + escapeHtml(p.title) + '</h4>';
    if (p.description) html += '<p class="map-popup__desc">' + escapeHtml(p.description.substring(0, 120)) + '</p>';
    html += '<button class="map-popup__detail-btn" data-index="' + idx + '">Voir détails</button>';
    html += '</div></div>';
    return html;
  }

  reloadMapPoints();

  map.on('popupopen', function (e) {
    var container = e.popup.getElement();
    if (!container) return;
    container.querySelectorAll('.map-popup__detail-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var idx = parseInt(btn.getAttribute('data-index'));
        var point = pointsData[idx];
        if (point) showPlaceModal(point);
      });
    });
  });

  function showPlaceModal(point) {
    var modal = document.getElementById('mapDetailModal');
    var mc = document.getElementById('mapModalMeta');
    if (!modal || !mc) return;
    document.getElementById('map-modal-title').textContent = point.title || 'Details';

    var videoEl = document.getElementById('mapModalVideo');
    var embedModalUrl = (point.youtube_url || point.youtube_id) ? youtubeEmbedUrl(point.youtube_url, point.youtube_id) : '';
    if (videoEl) {
      videoEl.innerHTML = embedModalUrl ? '<iframe src="' + embedModalUrl.replace('?autoplay=1', '?autoplay=0&rel=0') + '" frameborder="0" allowfullscreen></iframe>' : '';
    }

    var descEl = modal.querySelector('.map-modal__description');
    descEl.innerHTML = point.details && point.details.long_description ? point.details.long_description : (point.description || '');
    var metaHtml = '';
    if (point.category) metaHtml += '<span class="map-modal__tag">' + escapeHtml(point.category) + '</span>';
    if (point.city) metaHtml += '<span class="map-modal__tag">' + escapeHtml(point.city) + '</span>';
    if (point.details) {
      if (point.details.rating) metaHtml += '<span class="map-modal__rating">&#9733; ' + point.details.rating + (point.details.reviews_count ? ' (' + point.details.reviews_count + ' avis)' : '') + '</span>';
      if (point.details.phone) metaHtml += '<span class="map-modal__meta-item">&#9742; ' + escapeHtml(point.details.phone) + '</span>';
      if (point.details.email) metaHtml += '<span class="map-modal__meta-item">&#9993; ' + escapeHtml(point.details.email) + '</span>';
      if (point.details.horaires) metaHtml += '<span class="map-modal__meta-item">&#9200; ' + escapeHtml(point.details.horaires) + '</span>';
      if (point.details.tarifs) metaHtml += '<span class="map-modal__meta-item">&#36; ' + escapeHtml(point.details.tarifs) + '</span>';
      if (point.details.services) metaHtml += '<div class="map-modal__services"><strong>Services :</strong> ' + escapeHtml(point.details.services) + '</div>';
    }
    mc.innerHTML = metaHtml;
    var galleryEl = document.getElementById('mapModalGallery');
    galleryEl.innerHTML = '';
    if (point.images && point.images.length) {
      point.images.forEach(function (img) {
        var el = document.createElement('img');
        el.src = img.thumbnail || img.url;
        el.alt = img.caption || '';
        el.loading = 'lazy';
        galleryEl.appendChild(el);
      });
    }
    var websiteLink = document.getElementById('mapModalWebsite');
    if (point.details && point.details.website) {
      websiteLink.href = point.details.website;
      websiteLink.style.display = 'inline-flex';
    } else {
      websiteLink.style.display = 'none';
    }
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
  }

  function closePlaceModal() {
    var modal = document.getElementById('mapDetailModal');
    if (!modal) return;
    modal.style.display = 'none';
    document.body.style.overflow = '';
  }

  document.getElementById('mapModalClose').addEventListener('click', closePlaceModal);
  document.getElementById('mapModalBackdrop').addEventListener('click', closePlaceModal);
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      var modal = document.getElementById('mapDetailModal');
      if (modal && modal.style.display === 'block') closePlaceModal();
    }
  });
});
</script>
