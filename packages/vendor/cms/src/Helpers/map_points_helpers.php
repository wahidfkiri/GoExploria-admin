<?php

// ==================== MAP POINT HELPERS ====================
// Add these functions to your welcome_page_helpers.php file

if (!function_exists('has_map_points')) {
    /**
     * Check if the current establishment has active map points.
     *
     * @param int|null $etablissementId
     * @return bool
     */
    function has_map_points($etablissementId = null)
    {
        $etablissement = $etablissementId
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();

        if (!$etablissement) {
            return false;
        }

        try {
            return \App\Models\MapPoint::active()
                ->where('etablissement_id', $etablissement->id)
                ->exists();
        } catch (\Exception $e) {
            \Log::error('has_map_points error: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('get_map_points')) {
    /**
     * Get all active map points for the current establishment.
     *
     * @param int|null  $etablissementId
     * @param array     $options  ['limit' => 50, 'category' => null, 'with_details' => false]
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_map_points($etablissementId = null, array $options = [])
    {
        $etablissement = $etablissementId
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();

        if (!$etablissement) {
            return collect();
        }

        $defaults = [
            'limit'        => 50,
            'category'     => null,
            'with_details' => false,
        ];
        $options = array_merge($defaults, $options);

        try {
            $with = ['images', 'mainImage'];
            if ($options['with_details']) {
                $with[] = 'details';
            }

            $query = \App\Models\MapPoint::with($with)
                ->active()
                ->where('etablissement_id', $etablissement->id)
                ->orderBy('is_featured', 'desc')
                ->orderBy('views', 'desc');

            if (!empty($options['category'])) {
                $query->byCategory($options['category']);
            }

            return $query->limit((int) $options['limit'])->get();

        } catch (\Exception $e) {
            \Log::error('get_map_points error: ' . $e->getMessage());
            return collect();
        }
    }
}

if (!function_exists('get_map_points_json')) {
    /**
     * Get map points serialised as JSON — ready to be injected into a JS variable.
     *
     * @param int|null $etablissementId
     * @param array    $options  Forwarded to get_map_points()
     * @return string  JSON string
     */
    function get_map_points_json($etablissementId = null, array $options = [])
    {
        $points = get_map_points($etablissementId, $options);

        $data = $points->map(function ($point) {
            $thumbnail = null;

            if ($point->youtube_id) {
                $thumbnail = "https://img.youtube.com/vi/{$point->youtube_id}/hqdefault.jpg";
            } elseif ($point->main_image) {
                $thumbnail = asset('storage/' . $point->main_image);
            } elseif ($point->mainImage) {
                $thumbnail = $point->mainImage->url;
            }

            return [
                'id'          => $point->id,
                'title'       => $point->title,
                'description' => $point->description,
                'category'    => $point->category,
                'type'        => $point->type,
                'latitude'    => (float) $point->latitude,
                'longitude'   => (float) $point->longitude,
                'adresse'     => $point->adresse,
                'ville'       => $point->ville,
                'thumbnail'   => $thumbnail,
                'details_url' => $point->has_details_page ? $point->details_url : null,
                'is_featured' => (bool) $point->is_featured,
                'youtube_id'  => $point->youtube_id,
            ];
        });

        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
    }
}

if (!function_exists('get_map_center')) {
    /**
     * Compute the geographic center (centroid) of all map points for the establishment.
     * Falls back to a default center if no points exist.
     *
     * @param int|null $etablissementId
     * @param array    $default  ['lat' => 46.8, 'lng' => -71.2]  (Québec default)
     * @return array   ['lat' => float, 'lng' => float]
     */
    function get_map_center($etablissementId = null, array $default = ['lat' => 46.8, 'lng' => -71.2])
    {
        $etablissement = $etablissementId
            ? \App\Models\Etablissement::find($etablissementId)
            : getCurrentEtablissement();

        if (!$etablissement) {
            return $default;
        }

        try {
            $result = \App\Models\MapPoint::active()
                ->where('etablissement_id', $etablissement->id)
                ->selectRaw('AVG(latitude) as avg_lat, AVG(longitude) as avg_lng')
                ->first();

            if ($result && $result->avg_lat && $result->avg_lng) {
                return [
                    'lat' => round((float) $result->avg_lat, 6),
                    'lng' => round((float) $result->avg_lng, 6),
                ];
            }
        } catch (\Exception $e) {
            \Log::error('get_map_center error: ' . $e->getMessage());
        }

        return $default;
    }
}

if (!function_exists('get_map_section_html')) {
    /**
     * Render the full interactive Leaflet map section HTML.
     *
     * Injects Leaflet CSS/JS (from CDN), renders all active map points as markers,
     * and shows a styled popup card on click.
     *
     * @param int|null $etablissementId
     * @param array    $options
     *   - height        string   CSS height of the map container  (default '480px')
     *   - zoom          int      Initial zoom level               (default 11)
     *   - title         string   Section heading                  (default 'Nous trouver')
     *   - show_title    bool     Display the section heading      (default true)
     *   - tile_url      string   Leaflet tile URL template        (default OSM)
     *   - limit         int      Max points to load               (default 50)
     * @return string  HTML string (safe to echo with {!! !!})
     */
    function get_map_section_html($etablissementId = null, array $options = [])
    {
        if (!has_map_points($etablissementId)) {
            return '';
        }

        $defaults = [
            'height'     => '480px',
            'zoom'       => 11,
            'title'      => 'Nous trouver',
            'show_title' => true,
            'tile_url'   => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'limit'      => 50,
        ];
        $options = array_merge($defaults, $options);

        $center      = get_map_center($etablissementId);
        $pointsJson  = get_map_points_json($etablissementId, ['limit' => $options['limit']]);
        $mapId       = 'map-' . uniqid();
        $height      = htmlspecialchars($options['height']);
        $zoom        = (int) $options['zoom'];
        $tileUrl     = htmlspecialchars($options['tile_url']);
        $centerLat   = $center['lat'];
        $centerLng   = $center['lng'];
        $sectionTitle = htmlspecialchars($options['title']);

        $titleHtml = $options['show_title']
            ? '<h2 class="map-section-title">' . $sectionTitle . '</h2>'
            : '';

        $html = <<<HTML
<!-- Leaflet Map Section -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
<section class="map-section" aria-label="Carte des points d'intérêt">
    <div class="map-section-inner">
        {$titleHtml}
        <div id="{$mapId}" class="map-container" style="height:{$height}; width:100%; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.12);"></div>
    </div>
</section>
<style>
.map-section {
    padding: 60px 0 0;
    background: transparent;
}
.map-section-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}
.map-section-title {
    text-align: center;
    margin-bottom: 28px;
    font-size: 2rem;
    font-weight: 700;
    color: var(--color-heading, #1a1a2e);
    letter-spacing: -0.5px;
}
/* Leaflet popup overrides */
.leaflet-popup-content-wrapper {
    border-radius: 12px;
    padding: 0;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    min-width: 220px;
    max-width: 280px;
}
.leaflet-popup-content {
    margin: 0;
    width: 100% !important;
}
.leaflet-popup-tip-container { margin-top: -1px; }
.map-popup-img {
    width: 100%;
    height: 130px;
    object-fit: cover;
    display: block;
}
.map-popup-body {
    padding: 12px 14px 14px;
}
.map-popup-category {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--color-primary, #e05c00);
    margin-bottom: 4px;
}
.map-popup-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 4px;
    line-height: 1.3;
}
.map-popup-address {
    font-size: 0.8rem;
    color: #666;
    margin-bottom: 10px;
    display: flex;
    align-items: flex-start;
    gap: 4px;
}
.map-popup-desc {
    font-size: 0.82rem;
    color: #444;
    margin-bottom: 10px;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.map-popup-link {
    display: inline-block;
    padding: 6px 14px;
    background: var(--color-primary, #e05c00);
    color: #fff !important;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: opacity 0.2s;
}
.map-popup-link:hover { opacity: 0.85; }
</style>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV/XN2GqvE=" crossorigin=""></script>
<script>
(function() {
    function initMap() {
        if (typeof L === 'undefined') {
            setTimeout(initMap, 100);
            return;
        }

        var mapEl = document.getElementById('{$mapId}');
        if (!mapEl) return;

        var map = L.map('{$mapId}', {
            center: [{$centerLat}, {$centerLng}],
            zoom: {$zoom},
            scrollWheelZoom: false
        });

        L.tileLayer('{$tileUrl}', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 19
        }).addTo(map);

        // Enable scroll zoom on click
        map.once('focus', function() { map.scrollWheelZoom.enable(); });

        var points = {$pointsJson};

        if (!points || points.length === 0) return;

        var bounds = [];

        points.forEach(function(point) {
            if (!point.latitude || !point.longitude) return;

            var latlng = [point.latitude, point.longitude];
            bounds.push(latlng);

            var marker = L.marker(latlng).addTo(map);

            // Build popup HTML
            var imgHtml = '';
            if (point.thumbnail) {
                imgHtml = '<img class="map-popup-img" src="' + point.thumbnail + '" alt="' + (point.title || '') + '" loading="lazy">';
            }

            var addressHtml = '';
            if (point.adresse || point.ville) {
                var addr = [point.adresse, point.ville].filter(Boolean).join(', ');
                addressHtml = '<p class="map-popup-address"><i class="fas fa-map-marker-alt" style="color:var(--color-primary,#e05c00);margin-top:2px"></i> ' + addr + '</p>';
            }

            var descHtml = '';
            if (point.description) {
                descHtml = '<p class="map-popup-desc">' + point.description + '</p>';
            }

            var linkHtml = '';
            if (point.details_url) {
                linkHtml = '<a href="' + point.details_url + '" class="map-popup-link">Voir plus</a>';
            }

            var categoryHtml = '';
            if (point.category) {
                categoryHtml = '<div class="map-popup-category">' + point.category + '</div>';
            }

            var popupContent =
                '<div>' +
                imgHtml +
                '<div class="map-popup-body">' +
                categoryHtml +
                '<p class="map-popup-title">' + (point.title || '') + '</p>' +
                addressHtml +
                descHtml +
                linkHtml +
                '</div></div>';

            marker.bindPopup(popupContent, { maxWidth: 280, minWidth: 220 });
        });

        // Fit map to all markers if more than one
        if (bounds.length > 1) {
            map.fitBounds(bounds, { padding: [40, 40], maxZoom: 14 });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMap);
    } else {
        initMap();
    }
})();
</script>
HTML;

        return $html;
    }
}