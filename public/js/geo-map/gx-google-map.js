/* ══════════════════════════════════════════════════════════════════════════
   GxGoogleMap — moteur de carte Google Maps réutilisable pour GoExploria.

   Remplace Leaflet par Google Maps (rues + satellite + Street View natif) SANS
   changer la logique métier. Les marqueurs sont rendus en HTML via OverlayView
   → ils affichent FIDÈLEMENT l'icône de la catégorie issue de la base
   (image OU icon_class + couleur + étoile « featured »), exactement comme les
   L.divIcon de Leaflet, et CE SANS nécessiter de Map ID Google.

   Le popup vidéo (iframe YouTube) est rendu dans une InfoWindow, avec le MÊME
   HTML que l'appelant fournit.

   API publique
   ------------
   GxGoogleMap.load(apiKey, { mapId })      -> Promise (résolue quand prêt)
   GxGoogleMap.create(elId, {center,zoom,mapId,mapTypeControl,streetView})
   engine.addMarker(place, {
       position:{lat,lng},
       iconHtml,                         // HTML brut d'icône (prioritaire), ou
       icon:{ color, iconClass, image }, // données catégorie (base) -> HTML auto
       featured, popupHtml, onClick, onOpen
   }) -> { open }
   engine.clearMarkers() / fitToMarkers(pad) / panTo(lat,lng,zoom)
   engine.closePopup() / openStreetView(lat,lng) / getZoom() / map
   ══════════════════════════════════════════════════════════════════════════ */
(function (global) {
    'use strict';

    var _loadPromise = null;

    function load(apiKey) {
        if (_loadPromise) return _loadPromise;
        _loadPromise = new Promise(function (resolve, reject) {
            if (!apiKey) { reject(new Error('GxGoogleMap: clé API manquante')); return; }
            if (global.google && global.google.maps && global.google.maps.OverlayView) {
                resolve(global.google.maps); return;
            }
            var cbName = '__gxGmapsReady_' + Date.now();
            global[cbName] = function () {
                try { delete global[cbName]; } catch (e) { global[cbName] = undefined; }
                resolve(global.google.maps);
            };
            var s = document.createElement('script');
            s.src = 'https://maps.googleapis.com/maps/api/js?key=' + encodeURIComponent(apiKey) +
                    '&loading=async&v=weekly&callback=' + cbName;
            s.async = true; s.defer = true;
            s.onerror = function () { reject(new Error('GxGoogleMap: échec de chargement du script')); };
            document.head.appendChild(s);
        });
        return _loadPromise;
    }

    /* Construit le HTML de l'icône à partir des données catégorie de la BASE.
       Reproduit la logique des L.divIcon de la version Leaflet. */
    function buildIconHtml(icon, featured) {
        icon = icon || {};
        var size = featured ? 40 : 32;
        var ring = featured
            ? 'box-shadow:0 0 0 4px rgba(255,193,7,.45),0 3px 12px rgba(0,0,0,.5);border:3px solid #FFC107'
            : 'box-shadow:0 2px 8px rgba(0,0,0,.4);border:2px solid #fff';
        var star = featured
            ? '<span style="position:absolute;top:-7px;right:-7px;width:18px;height:18px;border-radius:50%;background:#FFC107;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(0,0,0,.4)"><svg viewBox="0 0 24 24" width="11" height="11" fill="#fff"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></span>'
            : '';
        if (icon.image) {
            return '<div style="width:' + size + 'px;height:' + size + 'px;border-radius:50%;background-size:cover;background-position:center;background-image:url(' + icon.image + ');' + ring + ';position:relative">' + star + '</div>';
        }
        if (icon.iconClass) {
            var c = icon.color || '#e74c3c';
            return '<div style="width:' + size + 'px;height:' + size + 'px;border-radius:50%;background:' + c + ';display:flex;align-items:center;justify-content:center;' + ring + ';position:relative"><span class="' + icon.iconClass + '" style="font-size:' + Math.round(size * 0.55) + 'px;color:#fff"></span>' + star + '</div>';
        }
        var col = icon.color || '#e74c3c';
        return '<div style="width:' + size + 'px;height:' + size + 'px;border-radius:50%;background:' + col + ';display:flex;align-items:center;justify-content:center;' + ring + ';position:relative"><svg viewBox="0 0 24 24" width="' + Math.round(size * 0.6) + '" height="' + Math.round(size * 0.6) + '" fill="#fff"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg>' + star + '</div>';
    }

    /* Marqueur HTML via OverlayView (fonctionne SANS Map ID). */
    function makeHtmlMarker(gmaps, map, position, html, handlers, featured) {
        function Marker() {
            this._latLng = new gmaps.LatLng(position.lat, position.lng);
            this._html = html;
            this._div = null;
            this.setMap(map);
        }
        Marker.prototype = new gmaps.OverlayView();
        Marker.prototype.onAdd = function () {
            var div = document.createElement('div');
            div.style.position = 'absolute';
            div.style.transform = 'translate(-50%, -100%)';
            div.style.cursor = 'pointer';
            div.style.zIndex = featured ? '1000' : '1';
            div.innerHTML = this._html;
            this._div = div;
            this.getPanes().overlayMouseTarget.appendChild(div);
            var self = this;
            div.addEventListener('click', function (e) { e.stopPropagation(); if (handlers.onClick) handlers.onClick(self); });
            div.addEventListener('mouseenter', function () { if (handlers.onHover) handlers.onHover(self); });
        };
        Marker.prototype.draw = function () {
            if (!this._div) return;
            var proj = this.getProjection();
            if (!proj) return;
            var p = proj.fromLatLngToDivPixel(this._latLng);
            if (p) { this._div.style.left = p.x + 'px'; this._div.style.top = p.y + 'px'; }
        };
        Marker.prototype.onRemove = function () {
            if (this._div && this._div.parentNode) { this._div.parentNode.removeChild(this._div); }
            this._div = null;
        };
        Marker.prototype.getLatLng = function () { return this._latLng; };
        return new Marker();
    }

    function Engine(el, gmaps, options) {
        this.gmaps = gmaps;
        this.markers = [];
        this._info = new gmaps.InfoWindow({ maxWidth: 320 });
        this._openInfo = null;
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
    }

    Engine.prototype._open = function (latLng, html, place, onOpen) {
        if (!html) return;
        this._info.setContent(html);
        this._info.setPosition(latLng);
        this._info.open(this.map);
        this._openInfo = this._info;
        if (typeof onOpen === 'function') { var iw = this._info; setTimeout(function () { onOpen(iw, place); }, 30); }
    };

    Engine.prototype.addMarker = function (place, cfg) {
        var self = this, pos = cfg.position;
        if (!pos || pos.lat == null || pos.lng == null || isNaN(pos.lat) || isNaN(pos.lng)) return null;

        var html = cfg.iconHtml || buildIconHtml(cfg.icon, cfg.featured);
        var marker = makeHtmlMarker(this.gmaps, this.map, pos, html, {
            onClick: function (m) {
                self._open(m.getLatLng(), cfg.popupHtml, place, cfg.onOpen);
                if (typeof cfg.onClick === 'function') cfg.onClick(place);
            },
            onHover: function (m) { self._open(m.getLatLng(), cfg.popupHtml, place, cfg.onOpen); }
        }, cfg.featured);

        this.markers.push({ marker: marker, position: pos });
        return { open: function () { self._open(marker.getLatLng(), cfg.popupHtml, place, cfg.onOpen); } };
    };

    Engine.prototype.clearMarkers = function () {
        if (this._openInfo) { this._openInfo.close(); this._openInfo = null; }
        this.markers.forEach(function (m) { m.marker.setMap(null); });
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
