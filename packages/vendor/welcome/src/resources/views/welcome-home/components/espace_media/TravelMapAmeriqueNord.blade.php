{{-- ════════════════════════════════════════════════════════════════════════
     Carte "Amérique du Nord" pour la page d'accueil.
     Même principe & design que /travel-destination/continent/amerique-du-nord :
     carte Leaflet, recherche géo, filtres de catégories, popups vidéo, modal détail.
     100% scopée sous .ta-namap pour ne pas affecter le design de la page d'accueil.
     Les points sont chargés en AJAX (route travel-destination.map-points).
     ═══════════════════════════════════════════════════════════════════════ --}}
@isset($naMap)
@php
    $naEntity        = $naMap['entity'];
    $naSlug          = $naMap['slug'];
    $naType          = $naMap['normalizedType'];
    $naChildEntities = $naMap['childEntities'];
    $naMapCategories = $naMap['mapCategories'];
@endphp

<style>
    /* ── Variables locales (thème sombre de la carte travel-destination) ── */
    .ta-namap {
        --amber: #F5A623;
        --amber-dark: #D4891A;
        --text-main: #E8D5B0;
        --text-muted: #8A95A8;
        --border: rgba(232,213,176,0.12);
        --glass-bg: rgba(255,255,255,0.06);
        --glass-border: rgba(255,255,255,0.12);
        --card-bg: #111827;
        --section-alt: #0F1522;
        --shadow-md: 0 8px 32px rgba(0,0,0,0.4);
        --shadow-lg: 0 24px 60px rgba(0,0,0,0.5);
        --radius-sm: 8px;
        --radius-md: 16px;
        --transition: 0.35s cubic-bezier(0.4,0,0.2,1);
        background: var(--section-alt);
        padding: 72px 0;
        font-family: 'Montserrat','DM Sans',sans-serif;
    }
    .ta-namap .ta-container { width: min(1280px, 92vw); margin-inline: auto; }
    .ta-namap .ta-section-header { text-align: center; margin-bottom: 40px; }
    .ta-namap .ta-eyebrow {
        display: inline-block; font-size: 0.72rem; font-weight: 600; letter-spacing: 0.22em;
        text-transform: uppercase; color: var(--amber); margin-bottom: 14px;
    }
    .ta-namap .ta-section-title {
        color: var(--text-main); font-size: clamp(1.6rem, 4vw, 2.4rem); font-weight: 700;
        line-height: 1.15; margin: 0;
    }
    .ta-namap .ta-section-subtitle { margin-top: 14px; font-size: 1rem; color: var(--text-muted); }

    /* ── Recherche géo ── */
    .ta-namap .map-geo-filter { max-width: 360px; margin: 0 auto 24px; }
    .ta-namap .map-geo-filter__wrapper { position: relative; }
    .ta-namap .map-geo-filter__search {
        width: 100%; padding: 12px 16px; border: 1px solid var(--border); border-radius: var(--radius-sm);
        background: var(--card-bg); color: var(--text-main); font-size: 0.9rem; outline: none;
        transition: border-color var(--transition);
    }
    .ta-namap .map-geo-filter__search:focus { border-color: var(--amber); }
    .ta-namap .map-geo-filter__search::placeholder { color: var(--text-muted); }
    .ta-namap .map-geo-filter__dropdown {
        display: none; position: absolute; top: 100%; left: 0; right: 0; z-index: 2000;
        background: var(--card-bg); border: 1px solid var(--border); border-top: none;
        border-radius: 0 0 var(--radius-sm) var(--radius-sm); max-height: 240px; overflow-y: auto;
        box-shadow: var(--shadow-md);
    }
    .ta-namap .map-geo-option {
        padding: 10px 16px; cursor: pointer; font-size: 0.88rem; color: var(--text-main);
        transition: background var(--transition);
    }
    .ta-namap .map-geo-option:hover { background: rgba(245,166,35,0.08); }
    .ta-namap .map-geo-option.active { background: rgba(245,166,35,0.15); color: var(--amber); font-weight: 600; }

    /* ── Filtres de catégories ── */
    .ta-namap .map-filters { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; margin-bottom: 24px; }
    .ta-namap .map-filter-btn {
        padding: 8px 20px; border: 1px solid var(--border); border-radius: 50px;
        font-size: 0.82rem; font-weight: 600; color: var(--text-muted);
        transition: all var(--transition); cursor: pointer; background: transparent;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .ta-namap .map-filter-btn:hover { border-color: var(--amber); color: var(--amber); }
    .ta-namap .map-filter-btn.active { background: var(--amber); color: #000; border-color: var(--amber); }
    .ta-namap .map-filter-btn__icon { display: inline-flex; align-items: center; justify-content: center; width: 20px; height: 20px; font-size: 1rem; flex-shrink: 0; }
    .ta-namap .map-filter-btn__icon img { width: 20px; height: 20px; border-radius: 4px; object-fit: cover; }
    .ta-namap .map-filter-btn__label { white-space: nowrap; }

    /* ── Carte ── */
    .ta-namap .map-wrapper { border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-md); }
    .ta-namap .travel-map { width: 100%; height: 500px; z-index: 1; }
    .ta-namap .travel-map .leaflet-container { font-family: 'DM Sans', sans-serif; background: #1a1a2e; }
    .ta-namap .travel-map .leaflet-control-zoom a { background: rgba(255,255,255,0.1); color: var(--text-main); border-color: var(--border); }
    .ta-namap .travel-map .leaflet-control-zoom a:hover { background: var(--amber); color: #000; }
    .ta-namap .travel-map .leaflet-control-attribution { background: transparent; color: var(--text-muted); font-size: 0.65rem; }
    .ta-namap .travel-map .leaflet-control-attribution a { color: var(--amber); }

    /* ── Marqueurs ── */
    .ta-namap .map-marker { background: transparent !important; border: none !important; }
    .ta-namap .map-marker--main svg { filter: drop-shadow(0 2px 8px rgba(245,166,35,0.6)); color: var(--amber); }

    /* ── Popup (rendu hors du wrapper par Leaflet → scope global dédié) ── */
    .ta-map-popup .leaflet-popup-content-wrapper {
        background: #111827; color: #E8D5B0; border-radius: 8px; box-shadow: 0 24px 60px rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.12); padding: 0; overflow: hidden;
    }
    .ta-map-popup .leaflet-popup-tip { background: #111827; border: 1px solid rgba(255,255,255,0.12); }
    .ta-map-popup .leaflet-popup-content { margin: 0; width: 280px !important; }
    .ta-map-popup .leaflet-popup-close-button { color: #8A95A8 !important; top: 8px !important; right: 8px !important; font-size: 1.2rem !important; z-index: 2; }
    .ta-map-popup .map-popup__video { height: 160px; overflow: hidden; background: #000; }
    .ta-map-popup .map-popup__video iframe { width: 100%; height: 100%; border: 0; }
    .ta-map-popup .map-popup__body { padding: 14px 16px; }
    .ta-map-popup .map-popup__title { font-size: 0.95rem; font-weight: 600; margin-bottom: 6px; }
    .ta-map-popup .map-popup__desc { font-size: 0.8rem; color: #8A95A8; line-height: 1.5; margin-bottom: 10px; }
    .ta-map-popup .map-popup__detail-btn {
        display: block; width: 100%; padding: 10px 16px; background: #F5A623; color: #000; border: none;
        border-radius: 8px; font-size: 0.82rem; font-weight: 600; text-align: center; cursor: pointer;
    }
    .ta-map-popup .map-popup__detail-btn:hover { background: #D4891A; }

    /* ── Modal détail ── */
    #taNaMapModal { display: none; position: fixed; inset: 0; z-index: 2147483200; background: rgba(0,0,0,0.8); overflow-y: auto; }
    #taNaMapModal .map-modal__backdrop { position: fixed; inset: 0; z-index: -1; }
    #taNaMapModal .map-modal__content {
        position: relative; width: min(720px, 94vw); max-height: 90vh; background: #111827; color: #E8D5B0;
        border-radius: 16px; overflow-y: auto; margin: 50px auto; animation: taNaModalIn 0.3s ease;
        font-family: 'Montserrat','DM Sans',sans-serif;
    }
    @keyframes taNaModalIn { from{transform:translateY(-50px);opacity:0} to{transform:translateY(0);opacity:1} }
    #taNaMapModal .map-modal__close {
        position: absolute; top: 16px; right: 16px; z-index: 1; width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center; font-size: 1.6rem; color: #8A95A8;
        background: rgba(0,0,0,0.1); border: none; border-radius: 50%; cursor: pointer; transition: all .35s;
    }
    #taNaMapModal .map-modal__close:hover { color: #F5A623; background: rgba(255,255,255,0.06); }
    #taNaMapModal .map-modal__video { width: 100%; height: 0; padding-bottom: 56.25%; position: relative; background: #000; border-radius: 16px 16px 0 0; overflow: hidden; }
    #taNaMapModal .map-modal__video iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }
    #taNaMapModal .map-modal__video:empty { display: none; }
    #taNaMapModal .map-modal__body { padding: 32px; }
    #taNaMapModal .map-modal__gallery { display: flex; gap: 8px; overflow-x: auto; margin-bottom: 24px; padding-bottom: 8px; }
    #taNaMapModal .map-modal__gallery img { width: 160px; height: 100px; object-fit: cover; border-radius: 8px; flex-shrink: 0; }
    #taNaMapModal .map-modal__title { font-size: 1.6rem; margin-bottom: 12px; }
    #taNaMapModal .map-modal__description { font-size: 0.92rem; color: #8A95A8; line-height: 1.7; margin-bottom: 16px; }
    #taNaMapModal .map-modal__meta { display: flex; flex-wrap: wrap; gap: 8px 16px; margin-bottom: 20px; }
    #taNaMapModal .map-modal__tag { padding: 4px 12px; background: rgba(245,166,35,0.12); color: #F5A623; border-radius: 50px; font-size: 0.75rem; font-weight: 600; }
    #taNaMapModal .map-modal__rating { font-size: 0.85rem; color: #F5A623; }
    #taNaMapModal .map-modal__meta-item { font-size: 0.82rem; color: #8A95A8; }
    #taNaMapModal .map-modal__services { font-size: 0.85rem; color: #8A95A8; line-height: 1.6; margin-top: 8px; }
    #taNaMapModal .map-modal__actions { margin-top: 24px; }
    #taNaMapModal .btn--primary {
        display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; background: #F5A623; color: #000;
        border-radius: 50px; font-weight: 600; font-size: 0.9rem; text-decoration: none;
    }
    #taNaMapModal .btn--primary:hover { background: #D4891A; }

    @media (max-width: 768px) {
        .ta-namap { padding: 48px 0; }
        .ta-namap .travel-map { height: 420px; }
    }
    @media (max-width: 600px) {
        .ta-map-popup .leaflet-popup-content { width: 220px !important; }
        .ta-map-popup .map-popup__video { height: 120px; }
        .ta-namap .travel-map { height: 380px; }
        #taNaMapModal .map-modal__body { padding: 20px; }
    }
</style>

<section class="ta-namap" id="section-carte-amerique-nord" aria-labelledby="ta-namap-heading">
    <div class="ta-container">
        <div class="ta-section-header">
            <span class="ta-eyebrow">Explorer</span>
            <h2 class="ta-section-title" id="ta-namap-heading">Découvrez les points d'intérêt</h2>
            <p class="ta-section-subtitle">Cliquez sur les marqueurs pour en savoir plus</p>
        </div>
        <div class="map-geo-filter" id="taNaMapGeoFilter">
            <div class="map-geo-filter__wrapper">
                <input type="text" class="map-geo-filter__search" id="taNaMapGeoSearch" placeholder="Rechercher une destination..." autocomplete="off">
                <div class="map-geo-filter__dropdown" id="taNaMapGeoDropdown"></div>
            </div>
        </div>
        <div class="map-filters" id="taNaMapFilters">
            <button class="map-filter-btn active" data-filter="all">Tous</button>
        </div>
        <div class="map-wrapper">
            <div id="taNaMapCanvas" class="travel-map"></div>
        </div>
    </div>
</section>

<div class="map-modal" id="taNaMapModal">
    <div class="map-modal__backdrop" id="taNaMapModalBackdrop"></div>
    <div class="map-modal__content">
        <button class="map-modal__close" id="taNaMapModalClose">&times;</button>
        <div class="map-modal__body">
            <div class="map-modal__video" id="taNaMapModalVideo"></div>
            <div class="map-modal__gallery" id="taNaMapModalGallery"></div>
            <div class="map-modal__info">
                <h3 class="map-modal__title" id="taNaMapModalTitle"></h3>
                <div class="map-modal__description"></div>
                <div class="map-modal__meta" id="taNaMapModalMeta"></div>
                <div class="map-modal__actions">
                    <a href="#" class="btn--primary" id="taNaMapModalWebsite" target="_blank" rel="noopener">Visiter le site</a>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    // Bascule Google Maps (rues/satellite + Street View). Si aucune clé n'est
    // configurée, la carte reste sur Leaflet (repli, aucune régression).
    $gmKey = config('services.google.maps.key');
    $gmMapId = config('services.google.maps.map_id');
@endphp
@if($gmKey)
<script>
    window.GX_MAPS = window.GX_MAPS || { key: @json($gmKey), mapId: @json($gmMapId ?: '') };
</script>
<script src="{{ asset('js/geo-map/gx-google-map.js') }}?v={{ @filemtime(public_path('js/geo-map/gx-google-map.js')) ?: '4' }}"></script>
<style>
    /* Popup vidéo dans les InfoWindow Google (le CSS Leaflet ne s'y applique pas). */
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
    var mapEl = document.getElementById('taNaMapCanvas');
    if (!mapEl) return;
    // Backend Google si une clé est présente ; sinon Leaflet (comme avant).
    if (window.GX_MAPS && window.GX_MAPS.key && window.GxGoogleMap) { taNaInitMap(); return; }
    if (typeof L === 'undefined') return;
    taNaEnsureCluster(taNaInitMap);
});

// Charge le plugin Leaflet.markercluster (grappes « +N »), puis initialise la
// carte. En cas d'echec du CDN, la carte s'initialise sans clustering.
function taNaEnsureCluster(cb) {
    if (typeof L.markerClusterGroup === 'function') return cb();
    ['MarkerCluster.css', 'MarkerCluster.Default.css'].forEach(function (f) {
        var l = document.createElement('link');
        l.rel = 'stylesheet';
        l.href = 'https://unpkg.com/leaflet.markercluster@1.5.3/dist/' + f;
        document.head.appendChild(l);
    });
    var sc = document.createElement('script');
    sc.src = 'https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js';
    sc.onload = cb;
    sc.onerror = cb;
    document.head.appendChild(sc);
}

function taNaInitMap() {
    var mapEl = document.getElementById('taNaMapCanvas');
    if (!mapEl) return;

    @php
        $centerLat = is_numeric($naEntity->latitude) ? (float) $naEntity->latitude : null;
        $centerLng = is_numeric($naEntity->longitude) ? (float) $naEntity->longitude : null;
        if (is_null($centerLat) && $naChildEntities->count() > 0) {
            $withLat = $naChildEntities->filter(fn($ce) => is_numeric($ce->latitude));
            if ($withLat->count() > 0) {
                $centerLat = ((float) $withLat->min('latitude') + (float) $withLat->max('latitude')) / 2;
                $centerLng = ((float) $withLat->min('longitude') + (float) $withLat->max('longitude')) / 2;
            }
        }
    @endphp
    var entityLat  = {{ $centerLat ?? 0 }};
    var entityLng  = {{ $centerLng ?? 0 }};
    var entityName = {!! json_encode($naEntity->name ?? '', JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};
    var entityType = {!! json_encode($naType, JSON_UNESCAPED_UNICODE) !!};
    var mapPointsUrl = '{{ route("travel-destination.map-points", ["type" => $naType, "slug" => $naSlug], false) }}';
    var childEntities = {!! json_encode($naChildEntities->map(function ($ce) {
            $typeName = strtolower(class_basename($ce));
            $zMap = ['continent' => 3, 'country' => 5, 'province' => 7, 'region' => 9, 'secteur' => 10, 'ville' => 11, 'city' => 11, 'arrondissement' => 13, 'quartier' => 14];
            return ['name' => $ce->name, 'slug' => $ce->slug ?? (string) $ce->id, 'type' => class_basename($ce), 'latitude' => $ce->latitude ? (float) $ce->latitude : null, 'longitude' => $ce->longitude ? (float) $ce->longitude : null, 'zoom' => $zMap[$typeName] ?? 10];
        })->values(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};
    var mapCategories = {!! json_encode($naMapCategories->keyBy('slug')->map(function ($mc) {
            return ['name' => $mc->name, 'icon_class' => $mc->icon_class, 'color' => $mc->color, 'image' => $mc->image];
        })->toArray(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};
    var serverPoints = []; // chargés en AJAX pour préserver la vitesse de la page d'accueil

    var zoomByType = { continent: 3, country: 5, province: 7, region: 9, secteur: 10, ville: 11, city: 11, arrondissement: 13, quartier: 14 };
    var isContinent = entityType === 'continent';
    var defaultZoom = entityLat && !isContinent ? (zoomByType[entityType] || 6) : 2;
    var center = entityLat ? [entityLat, entityLng] : [45, -100];

    // ── Backend Google Maps (rues/satellite + Street View natif) ─────────
    // Réutilise buildPopupHtml / showPlaceModal / getMarkerIcon / getCategoryData
    // (fonctions déclarées plus bas, hoistées) → MÊME logique de marqueurs +
    // popup vidéo + iframe + modale « Voir détails » que la version Leaflet.
    if (window.GX_MAPS && window.GX_MAPS.key && window.GxGoogleMap) {
        window.GxGoogleMap.load(window.GX_MAPS.key, { mapId: window.GX_MAPS.mapId })
            .then(function () {
                // Vue par défaut centrée sur l'Amérique du Nord (continent) ;
                // sinon l'entité courante (pages destination).
                var gCenter = isContinent ? { lat: 46, lng: -96 } : { lat: center[0], lng: center[1] };
                var gZoom = isContinent ? 3 : defaultZoom;
                var eng = window.GxGoogleMap.create('taNaMapCanvas', {
                    center: gCenter,
                    zoom: gZoom,
                    mapId: window.GX_MAPS.mapId || undefined,
                    streetView: true,
                    cluster: true
                });
                var gPoints = [];

                if (entityLat) {
                    eng.addMarker({ name: entityName }, {
                        position: { lat: entityLat, lng: entityLng }, color: '#F5A623',
                        iconHtml: '<div style="width:34px;height:34px;border-radius:50%;background:#F5A623;display:flex;align-items:center;justify-content:center;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,.4);color:#000"><svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg></div>',
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
                            // Icône issue de la BASE (map_categories) : image ou
                            // icon_class + couleur, comme les marqueurs Leaflet.
                            icon: { color: gColor(p.category), iconClass: cd.icon_class, image: cd.image },
                            popupHtml: buildPopupHtml(p, idx),
                            featured: !!p.is_featured
                        });
                    });
                    // Sur le continent, on garde la vue Amérique du Nord ; sur une
                    // page destination, on cadre sur les points.
                    if (!isContinent) eng.fitToMarkers(40);
                }

                // Bouton « Voir détails » des popups (délégation : robuste avec les
                // InfoWindow Google dont le contenu est monté dynamiquement).
                document.addEventListener('click', function (e) {
                    var b = e.target.closest && e.target.closest('.map-popup__detail-btn');
                    if (!b) return;
                    var pt = gPoints[parseInt(b.getAttribute('data-index'), 10)];
                    if (pt) showPlaceModal(pt);
                });

                // Recherche géo → recentrage (flyTo Leaflet → panTo Google).
                var gSearch = document.getElementById('taNaMapGeoSearch');
                var gDrop = document.getElementById('taNaMapGeoDropdown');
                if (gSearch && gDrop && childEntities && childEntities.length) {
                    var gopts = [{ label: 'Tout ' + entityName, lat: entityLat, lng: entityLng, zoom: defaultZoom }]
                        .concat(childEntities.filter(function (c) { return c.latitude && c.longitude; })
                            .map(function (c) { return { label: c.name, lat: c.latitude, lng: c.longitude, zoom: c.zoom || 10 }; }));
                    var gRenderOpts = function (f) {
                        gDrop.innerHTML = ''; var mm = (f || '').toLowerCase();
                        gopts.forEach(function (o) {
                            if (mm && o.label.toLowerCase().indexOf(mm) === -1) return;
                            var d = document.createElement('div'); d.className = 'map-geo-option'; d.textContent = o.label;
                            d.addEventListener('click', function () { gSearch.value = o.label; eng.panTo(o.lat, o.lng, o.zoom); gDrop.style.display = 'none'; });
                            gDrop.appendChild(d);
                        });
                    };
                    gRenderOpts('');
                    gSearch.addEventListener('input', function () { gRenderOpts(this.value); gDrop.style.display = 'block'; });
                    gSearch.addEventListener('focus', function () { gRenderOpts(this.value); gDrop.style.display = 'block'; });
                    gSearch.addEventListener('blur', function () { setTimeout(function () { gDrop.style.display = 'none'; }, 200); });
                    gSearch.value = gopts[0].label;
                }

                // Points : même source AJAX que Leaflet.
                if (serverPoints && serverPoints.length) gRender(serverPoints);
                else fetch(mapPointsUrl).then(function (r) { return r.json(); })
                    .then(function (res) { if (res.success && res.data && res.data.length) gRender(res.data); })
                    .catch(function (err) { console.error('NA map (google) load error:', err); });
            })
            .catch(function (e) { console.warn('Google Maps indisponible :', e); });
        return;
    }

    var map = L.map('taNaMapCanvas', { center: center, zoom: defaultZoom, zoomControl: true, scrollWheelZoom: true });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© <a href="https://openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    map.whenReady(function () { map.invalidateSize(); });

    if (entityLat) {
        L.marker([entityLat, entityLng], {
            icon: L.divIcon({
                className: 'map-marker map-marker--main',
                html: '<svg viewBox="0 0 24 24" width="32" height="32" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>',
                iconSize: [32, 32], iconAnchor: [16, 32]
            })
        }).addTo(map).bindPopup('<strong>' + entityName + '</strong>');
    }

    // Grappes « +N » : clic = zoom automatique sur la zone
    function taNaMakeClusterLayer() {
        if (typeof L.markerClusterGroup !== 'function') return L.layerGroup();
        return L.markerClusterGroup({
            showCoverageOnHover: false,
            maxClusterRadius: 60,
            spiderfyOnMaxZoom: true,
            zoomToBoundsOnClick: true,
            iconCreateFunction: function (cluster) {
                var n = cluster.getChildCount();
                var size = n >= 50 ? 54 : (n >= 20 ? 48 : 42);
                return L.divIcon({
                    html: '<div style="width:' + size + 'px;height:' + size + 'px;border-radius:50%;background:linear-gradient(135deg,#F5A623,#e08900);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:' + (n >= 100 ? 13 : 15) + 'px;border:3px solid #fff;box-shadow:0 3px 12px rgba(0,0,0,0.45);cursor:pointer">+' + n + '</div>',
                    className: 'marker-cluster-custom',
                    iconSize: [size, size],
                    iconAnchor: [size / 2, size / 2]
                });
            }
        });
    }
    var markersLayer = taNaMakeClusterLayer().addTo(map);
    var pointsData = [];
    var geoFilterActive = null;
    var geoFilterEntity = null;
    var childTypeMap = { continent: 'country', country: 'province', province: 'region', region: 'city', secteur: 'city', city: 'arrondissement', arrondissement: 'quartier', quartier: '' };
    var childType = childTypeMap[entityType] || '';

    function zoomToEntity(lat, lng, zoom) {
        if (lat != null && lng != null) map.flyTo([lat, lng], zoom || defaultZoom, { duration: 1 });
    }

    var geoSearch = document.getElementById('taNaMapGeoSearch');
    var geoDropdown = document.getElementById('taNaMapGeoDropdown');
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
        var bounds = [];
        var categories = {};
        var markerIndex = 0;
        data.forEach(function (p) {
            var cat = p.category || 'other';
            if (!categories[cat]) categories[cat] = true;
            pointsData.push(p);
            var marker = L.marker([p.latitude, p.longitude], { icon: getMarkerIcon(p.category, p.is_featured), zIndexOffset: p.is_featured ? 1000 : 0 })
                .addTo(markersLayer)
                .bindPopup(buildPopupHtml(p, markerIndex), { maxWidth: 320, className: 'ta-map-popup' });
            marker._pointIndex = markerIndex;
            markerIndex++;
            bounds.push([p.latitude, p.longitude]);
        });
        if (bounds.length && !isContinent) map.fitBounds(bounds, { padding: [40, 40], maxZoom: 14 });
        rebuildCategoryFilters(data);
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
                    html: '<div style="width:28px;height:28px;border-radius:50%;background:#F5A623;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,0.4);border:2px solid #fff;font-size:14px;font-weight:700;color:#000">' + ce.name.charAt(0) + '</div>',
                    iconSize: [32, 32], iconAnchor: [16, 32]
                })
            }).addTo(markersLayer);
            marker.bindPopup('<strong>' + ce.name + '</strong><br><a href="/travel-destination/' + (childType || 'country') + '/' + ce.slug + '" style="color:#F5A623">Voir les détails</a>', { className: 'ta-map-popup' });
            bounds.push([ce.latitude, ce.longitude]);
        });
        if (bounds.length && !isContinent) map.fitBounds(bounds, { padding: [40, 40], maxZoom: 5 });
    }

    function reloadMapPoints() {
        if (serverPoints && serverPoints.length) { renderPointsOnMap(serverPoints); return; }
        fetch(mapPointsUrl)
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (!res.success || !res.data || !res.data.length) {
                    if (geoFilterActive) { markersLayer.clearLayers(); return; }
                    renderChildEntities();
                    return;
                }
                renderPointsOnMap(res.data);
            })
            .catch(function (err) { console.error('NA map reload error:', err); });
    }

    function rebuildCategoryFilters(data) {
        var filterEl = document.getElementById('taNaMapFilters');
        if (!filterEl) return;
        filterEl.innerHTML = '<button class="map-filter-btn active" data-filter="all">Tous</button>';
        mapCategories && Object.keys(mapCategories).forEach(function (slug) {
            var cat = mapCategories[slug];
            var btn = document.createElement('button');
            btn.className = 'map-filter-btn';
            btn.setAttribute('data-filter', slug);
            var iconHtml = '';
            if (cat.image) iconHtml = '<img loading="lazy" decoding="async" src="' + cat.image + '" alt="" class="map-filter-btn__img" />';
            else if (cat.icon_class) iconHtml = '<span class="' + cat.icon_class + '" style="color:' + (cat.color || '#e74c3c') + '"></span>';
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
                            .bindPopup(buildPopupHtml(p, idx), { maxWidth: 320, className: 'ta-map-popup' });
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
        var aliasMap = { 'adventure': 'sport', 'nature': 'natural', 'culture': 'cultural', 'history': 'historic', 'science': 'museum', 'family': 'entertainment', 'park': 'parc', 'video_map': 'entertainment' };
        var alias = aliasMap[category];
        if (alias && mapCategories[alias]) return mapCategories[alias];
        return null;
    }

    function resolveCategorySlug(category) {
        if (!category) return null;
        if (mapCategories[category]) return category;
        var aliasMap = { 'adventure': 'sport', 'nature': 'natural', 'culture': 'cultural', 'history': 'historic', 'science': 'museum', 'family': 'entertainment', 'park': 'parc', 'video_map': 'entertainment' };
        return aliasMap[category] || null;
    }

    function getMarkerIcon(category, featured) {
        var size = featured ? 40 : 32;
    var ring = featured ? 'box-shadow:0 0 0 4px rgba(255,193,7,0.45),0 3px 12px rgba(0,0,0,0.5);border:3px solid #FFC107' : 'box-shadow:0 2px 8px rgba(0,0,0,0.4);border:2px solid #fff';
    var star = featured ? '<span style="position:absolute;top:-7px;right:-7px;width:18px;height:18px;border-radius:50%;background:#FFC107;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(0,0,0,0.4);z-index:2"><svg viewBox="0 0 24 24" width="11" height="11" fill="#fff"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></span>' : '';
        var catData = getCategoryData(category);
        if (catData && catData.image) {
            return L.divIcon({ className: 'map-marker', html: '<div style="width:' + size + 'px;height:' + size + 'px;border-radius:50%;background-size:cover;background-image:url(' + catData.image + ');' + ring + ';position:relative">' + star + '</div>', iconSize: [size + 4, size + 4], iconAnchor: [(size + 4) / 2, size + 4] });
        } else if (catData && catData.icon_class) {
            var c = catData.color || '#e74c3c';
            return L.divIcon({ className: 'map-marker', html: '<div style="width:' + size + 'px;height:' + size + 'px;border-radius:50%;background:' + c + ';display:flex;align-items:center;justify-content:center;' + ring + ';position:relative"><span class="' + catData.icon_class + '" style="font-size:' + Math.round(size * 0.55) + 'px;color:#fff"></span>' + star + '</div>', iconSize: [size + 4, size + 4], iconAnchor: [(size + 4) / 2, size + 4] });
        }
        var colors = { sightseeing: '#e74c3c', museum: '#3498db', restaurant: '#f39c12', hotel: '#2ecc71', adventure: '#9b59b6', shopping: '#1abc9c', default: '#e74c3c' };
        var color = colors[category] || colors.default;
        return L.divIcon({ className: 'map-marker', html: '<div style="width:' + size + 'px;height:' + size + 'px;border-radius:50%;background:' + color + ';display:flex;align-items:center;justify-content:center;' + ring + ';position:relative"><svg viewBox="0 0 24 24" width="' + Math.round(size * 0.6) + '" height="' + Math.round(size * 0.6) + '" fill="#fff"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>' + star + '</div>', iconSize: [size + 4, size + 4], iconAnchor: [(size + 4) / 2, size + 4] });
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
        if (embedUrl) html += '<div class="map-popup__video"><iframe src="' + embedUrl + '" frameborder="0" allowfullscreen></iframe></div>';
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
                var point = pointsData[parseInt(btn.getAttribute('data-index'))];
                if (point) showPlaceModal(point);
            });
        });
    });

    function showPlaceModal(point) {
        var modal = document.getElementById('taNaMapModal');
        var mc = document.getElementById('taNaMapModalMeta');
        if (!modal || !mc) return;
        document.getElementById('taNaMapModalTitle').textContent = point.title || 'Détails';

        var videoEl = document.getElementById('taNaMapModalVideo');
        var embedModalUrl = (point.youtube_url || point.youtube_id) ? youtubeEmbedUrl(point.youtube_url, point.youtube_id) : '';
        if (videoEl) videoEl.innerHTML = embedModalUrl ? '<iframe src="' + embedModalUrl.replace('?autoplay=1', '?autoplay=0&rel=0') + '" frameborder="0" allowfullscreen></iframe>' : '';

        modal.querySelector('.map-modal__description').innerHTML = point.details && point.details.long_description ? point.details.long_description : (point.description || '');
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

        var galleryEl = document.getElementById('taNaMapModalGallery');
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
        var websiteLink = document.getElementById('taNaMapModalWebsite');
        if (point.details && point.details.website) { websiteLink.href = point.details.website; websiteLink.style.display = 'inline-flex'; }
        else websiteLink.style.display = 'none';

        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closePlaceModal() {
        var modal = document.getElementById('taNaMapModal');
        if (!modal) return;
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    document.getElementById('taNaMapModalClose').addEventListener('click', closePlaceModal);
    document.getElementById('taNaMapModalBackdrop').addEventListener('click', closePlaceModal);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            var modal = document.getElementById('taNaMapModal');
            if (modal && modal.style.display === 'block') closePlaceModal();
        }
    });
}
</script>
@endisset
