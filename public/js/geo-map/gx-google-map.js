/* ══════════════════════════════════════════════════════════════════════════
   GxGoogleMap — moteur de carte Google Maps réutilisable pour GoExploria.

   Remplace Leaflet par Google Maps (rues + satellite + Street View natif) SANS
   changer la logique métier. Le moteur est « callback-driven » : l'appelant
   fournit l'icône (HTML + couleur) et le HTML de popup (avec l'iframe vidéo
   YouTube). Le moteur les affiche dans un marqueur Google + une InfoWindow.

   Deux modes de marqueur, choisis automatiquement :
     • AVEC Map ID  → AdvancedMarkerElement (icône HTML fidèle) + clustering.
     • SANS Map ID  → google.maps.Marker classique (pin SVG couleur catégorie).
   Le Map ID est requis par Google pour les Advanced Markers ; sans lui on
   bascule proprement sur les marqueurs classiques → ça marche avec la seule clé.

   API publique
   ------------
   GxGoogleMap.load(apiKey, { mapId })            -> Promise (résolue quand prêt)
   GxGoogleMap.create(elementId, {center,zoom,mapId,mapTypeControl,streetView})
   engine.addMarker(place, { position, iconHtml, color, popupHtml, featured,
                             onClick, onOpen })   -> { marker, open }
   engine.clearMarkers()  /  fitToMarkers(pad)  /  panTo(lat,lng,zoom)
   engine.openStreetView(lat,lng)  /  engine.map (google.maps.Map)
   ══════════════════════════════════════════════════════════════════════════ */
(function (global) {
    'use strict';

    var _loadPromise = null;

    function load(apiKey) {
        if (_loadPromise) return _loadPromise;
        _loadPromise = new Promise(function (resolve, reject) {
            if (!apiKey) { reject(new Error('GxGoogleMap: clé API manquante')); return; }
            if (global.google && global.google.maps && global.google.maps.Map) {
                resolve(global.google.maps); return;
            }
            var cbName = '__gxGmapsReady_' + Date.now();
            global[cbName] = function () {
                try { delete global[cbName]; } catch (e) { global[cbName] = undefined; }
                resolve(global.google.maps);
            };
            var s = document.createElement('script');
            s.src = 'https://maps.googleapis.com/maps/api/js?key=' + encodeURIComponent(apiKey) +
                    '&libraries=marker&loading=async&v=weekly&callback=' + cbName;
            s.async = true; s.defer = true;
            s.onerror = function () { reject(new Error('GxGoogleMap: échec de chargement du script')); };
            document.head.appendChild(s);
        });
        return _loadPromise;
    }

    function svgPin(color) {
        color = color || '#0369a1';
        var svg = '<svg xmlns="http://www.w3.org/2000/svg" width="34" height="44" viewBox="0 0 34 44">' +
            '<path d="M17 0C7.6 0 0 7.6 0 17c0 12 17 27 17 27s17-15 17-27C34 7.6 26.4 0 17 0z" fill="' + color + '"/>' +
            '<circle cx="17" cy="17" r="6.5" fill="#ffffff"/></svg>';
        return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg);
    }

    /* ── Cluster minimal (uniquement en mode Advanced/Map ID) ───────────── */
    function SimpleClusterer(map, gmaps) {
        this.map = map; this.gmaps = gmaps; this.items = []; this.bubbles = [];
        var self = this;
        map.addListener('idle', function () { self.render(); });
    }
    SimpleClusterer.prototype.add = function (marker, position) { this.items.push({ marker: marker, position: position }); };
    SimpleClusterer.prototype.clear = function () {
        this.items.forEach(function (it) { it.marker.map = null; });
        this.items = []; this._clearBubbles();
    };
    SimpleClusterer.prototype._clearBubbles = function () { this.bubbles.forEach(function (b) { b.map = null; }); this.bubbles = []; };
    SimpleClusterer.prototype.render = function () {
        var gmaps = this.gmaps, map = this.map;
        this._clearBubbles();
        var proj = map.getProjection && map.getProjection();
        var zoom = map.getZoom();
        if (!proj || zoom >= 12) { this.items.forEach(function (it) { it.marker.map = map; }); return; }
        var GRID = 60, scale = Math.pow(2, zoom), groups = {};
        this.items.forEach(function (it) {
            it.marker.map = null;
            var pt = proj.fromLatLngToPoint(new gmaps.LatLng(it.position.lat, it.position.lng));
            var key = Math.floor(pt.x * scale / GRID) + ':' + Math.floor(pt.y * scale / GRID);
            (groups[key] = groups[key] || []).push(it);
        });
        var self = this;
        Object.keys(groups).forEach(function (key) {
            var g = groups[key];
            if (g.length === 1) { g[0].marker.map = map; return; }
            var lat = 0, lng = 0; g.forEach(function (it) { lat += it.position.lat; lng += it.position.lng; });
            lat /= g.length; lng /= g.length;
            var n = g.length, size = n >= 50 ? 44 : (n >= 20 ? 38 : 32);
            var el = document.createElement('div');
            el.style.cssText = 'width:' + size + 'px;height:' + size + 'px;border-radius:50%;background:linear-gradient(135deg,#0284c7,#0369a1);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:' + (n >= 100 ? 13 : 15) + 'px;border:3px solid #fff;box-shadow:0 3px 12px rgba(0,0,0,0.45);cursor:pointer';
            el.textContent = '+' + n;
            var cm = new gmaps.marker.AdvancedMarkerElement({ map: map, position: { lat: lat, lng: lng }, content: el });
            cm.addListener('click', function () { map.panTo({ lat: lat, lng: lng }); map.setZoom(Math.min(16, map.getZoom() + 2)); });
            self.bubbles.push(cm);
        });
    };

    /* ── Instance moteur ───────────────────────────────────────────────── */
    function Engine(el, gmaps, options) {
        this.gmaps = gmaps;
        this.markers = [];
        this._openInfo = null;
        this._info = new gmaps.InfoWindow({ maxWidth: 320 });

        // Advanced markers seulement si un Map ID est fourni ET la lib présente.
        this.useAdvanced = !!(options.mapId && gmaps.marker && gmaps.marker.AdvancedMarkerElement);

        this.map = new gmaps.Map(el, {
            center: options.center || { lat: 52.0, lng: -85.0 },
            zoom: options.zoom || 4,
            mapId: options.mapId || undefined,
            mapTypeControl: options.mapTypeControl !== false, // rues / satellite
            streetViewControl: options.streetView !== false,  // pegman Street View
            fullscreenControl: true,
            clickableIcons: false,
            gestureHandling: 'greedy'
        });

        this.clusterer = this.useAdvanced ? new SimpleClusterer(this.map, gmaps) : null;
    }

    Engine.prototype._openPopup = function (marker, html, place, onOpen) {
        if (!html) return;
        this._info.setContent(html);
        this._info.open({ map: this.map, anchor: marker });
        this._openInfo = this._info;
        if (typeof onOpen === 'function') setTimeout(function () { onOpen(this._info, place); }.bind(this), 30);
    };

    Engine.prototype.addMarker = function (place, cfg) {
        var gmaps = this.gmaps, self = this, pos = cfg.position;
        if (!pos || pos.lat == null || pos.lng == null || isNaN(pos.lat) || isNaN(pos.lng)) return null;

        var marker;
        if (this.useAdvanced) {
            var content = document.createElement('div');
            content.innerHTML = cfg.iconHtml || '';
            content.style.cursor = 'pointer';
            marker = new gmaps.marker.AdvancedMarkerElement({
                position: pos, content: content,
                zIndex: cfg.featured ? 1000 : 1,
                title: place && place.name ? String(place.name) : undefined
            });
            content.addEventListener('mouseenter', function () { self._openPopup(marker, cfg.popupHtml, place, cfg.onOpen); });
            this.clusterer.add(marker, pos);
        } else {
            marker = new gmaps.Marker({
                position: pos, map: this.map,
                title: place && place.name ? String(place.name) : undefined,
                zIndex: cfg.featured ? 1000 : 1,
                icon: {
                    url: svgPin(cfg.color),
                    scaledSize: new gmaps.Size(34, 44),
                    anchor: new gmaps.Point(17, 44)
                }
            });
            marker.addListener('mouseover', function () { self._openPopup(marker, cfg.popupHtml, place, cfg.onOpen); });
        }

        marker.addListener('click', function () {
            self._openPopup(marker, cfg.popupHtml, place, cfg.onOpen);
            if (typeof cfg.onClick === 'function') cfg.onClick(place);
        });

        this.markers.push({ marker: marker, position: pos });
        return {
            marker: marker,
            open: function () { self._openPopup(marker, cfg.popupHtml, place, cfg.onOpen); }
        };
    };

    Engine.prototype.clearMarkers = function () {
        if (this._openInfo) { this._openInfo.close(); this._openInfo = null; }
        if (this.clusterer) {
            this.clusterer.clear();
        } else {
            this.markers.forEach(function (m) { if (m.marker.setMap) m.marker.setMap(null); else m.marker.map = null; });
        }
        this.markers = [];
    };

    Engine.prototype.closePopup = function () {
        if (this._openInfo) { this._openInfo.close(); this._openInfo = null; }
    };

    Engine.prototype.fitToMarkers = function (paddingPx) {
        if (!this.markers.length) return;
        var bounds = new this.gmaps.LatLngBounds();
        this.markers.forEach(function (m) { bounds.extend(m.position); });
        if (this.markers.length === 1) { this.map.setCenter(this.markers[0].position); this.map.setZoom(14); }
        else this.map.fitBounds(bounds, paddingPx || 40);
    };

    Engine.prototype.panTo = function (lat, lng, zoom) {
        this.map.panTo({ lat: Number(lat), lng: Number(lng) });
        if (zoom) this.map.setZoom(zoom);
    };

    Engine.prototype.getZoom = function () { return this.map.getZoom(); };

    Engine.prototype.openStreetView = function (lat, lng) {
        var pano = this.map.getStreetView();
        pano.setPosition({ lat: Number(lat), lng: Number(lng) });
        pano.setPov({ heading: 0, pitch: 0 });
        pano.setVisible(true);
    };

    function create(elementId, options) {
        options = options || {};
        if (!global.google || !global.google.maps) throw new Error('GxGoogleMap.create appelé avant load()');
        var el = typeof elementId === 'string' ? document.getElementById(elementId) : elementId;
        if (!el) throw new Error('GxGoogleMap: élément introuvable: ' + elementId);
        return new Engine(el, global.google.maps, options);
    }

    global.GxGoogleMap = { load: load, create: create };
})(window);
