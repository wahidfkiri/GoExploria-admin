@php
    $landingMapPoints = is_maps_enabled($etablissement->id)
        ? get_map_video_points($etablissement->id)
        : collect();

    $landingMapVariant = $landingMapVariant ?? 'section';
    $landingMapIsInline = $landingMapVariant === 'inline';
    $landingMapSectionTitle = method_exists($etablissement, 'getSetting')
        ? $etablissement->getSetting('map_section_title', null, 'general')
        : null;
    $landingMapSectionTitle = trim((string) $landingMapSectionTitle) !== ''
        ? $landingMapSectionTitle
        : (function_exists('get_maps_section_title')
        ? get_maps_section_title($etablissement->id)
        : null);
    $landingMapSectionTitle = trim((string) $landingMapSectionTitle) !== ''
        ? $landingMapSectionTitle
        : (($siteName ?? $etablissement->name ?? 'Carte interactive') . ' sur la carte');

    $landingMapMediaUrl = static function ($path) {
        if (empty($path)) {
            return null;
        }

        if (is_array($path)) {
            $path = data_get($path, 'url') ?: data_get($path, 'thumbnail') ?: data_get($path, 'image') ?: data_get($path, 'path') ?: data_get($path, 0);
        }

        $path = trim((string) $path);
        if ($path === '') {
            return null;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['/storage/'])) {
            return asset(ltrim($path, '/'));
        }

        if (\Illuminate\Support\Str::startsWith($path, ['storage/'])) {
            return asset($path);
        }

        if (\Illuminate\Support\Str::startsWith($path, ['/'])) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/' . ltrim($path, '/'));
    };

    $landingMapGallerySource = collect($allGalleryMedia ?? []);
    if ($landingMapGallerySource->isEmpty()) {
        $landingMapGallerySource = collect($mainGalleryMedia ?? []);
    }
    if ($landingMapGallerySource->isEmpty()) {
        $landingMapGallerySource = collect($galleryMedia ?? []);
    }

    $landingMapFallbackGallery = $landingMapGallerySource
        ->map(function ($item) use ($landingMapMediaUrl) {
            $type = strtolower((string) data_get($item, 'type', 'image'));
            $src = $landingMapMediaUrl(data_get($item, 'url') ?: data_get($item, 'path') ?: data_get($item, 'image'));
            $thumb = $landingMapMediaUrl(data_get($item, 'thumbnail') ?: data_get($item, 'thumb') ?: $src);

            if (!$thumb || str_contains($type, 'video') || str_contains((string) $src, 'youtube.com') || str_contains((string) $src, 'youtu.be')) {
                return null;
            }

            return [
                'src' => $src ?: $thumb,
                'thumb' => $thumb,
                'caption' => data_get($item, 'name') ?: data_get($item, 'title') ?: 'Galerie',
            ];
        })
        ->filter()
        ->unique('thumb')
        ->take(8)
        ->values();

    $landingMapNormalizeSocialUrl = static function ($url) {
        $url = trim((string) $url);
        if ($url === '' || $url === '#' || in_array(strtolower($url), ['null', 'undefined', 'none', 'n/a'], true)) {
            return null;
        }

        if (!preg_match('#^(https?:)?//#i', $url) && !preg_match('#^(mailto:|tel:)#i', $url)) {
            $url = 'https://' . ltrim($url, '/');
        }

        return $url;
    };

    $landingMapSocialLinks = collect(function_exists('get_establishment_social_links') ? get_establishment_social_links($etablissement) : ($socialLinks ?? []))
        ->map(function ($link, $key) use ($landingMapNormalizeSocialUrl) {
            $url = $landingMapNormalizeSocialUrl(data_get($link, 'url') ?: (is_string($link) ? $link : null));
            if (!$url) {
                return null;
            }

            return [
                'key' => is_string($key) ? $key : (data_get($link, 'key') ?: data_get($link, 'name') ?: 'link'),
                'url' => $url,
                'label' => data_get($link, 'label') ?: data_get($link, 'name') ?: ucfirst((string) $key),
                'icon' => data_get($link, 'icon') ?: 'fas fa-link',
            ];
        })
        ->filter()
        ->values();
    static $landingMapRenderCount = 0;
    $landingMapRenderCount++;
    $landingMapId = 'landingVideoMap' . substr(md5((string) ($etablissement->id ?? 'global')), 0, 8) . '-' . $landingMapRenderCount;

    $landingMapCategories = [
        'Tourisme',
        'Culture',
        'Histoire',
        'Nature',
        'Aventure',
        'Shopping',
        'Science',
        'Plage',
        'Famille',
        'Restaurant',
        'Hôtel',
        'Commerce',
        'Santé',
        'Éducation',
        'Sport',
        'Loisirs',
        'Transport',
        'Immobilier',
        'Chalet',
        'Commercial',
        'Domaine',
        'Résidence',
        'Condo',
        'Maison',
        'Terrain',
        'Service',
        'Autre',
    ];

    $landingMapPayload = $landingMapPoints->map(function ($point) use ($landingMapMediaUrl, $landingMapFallbackGallery, $landingMapSocialLinks, $landingMapNormalizeSocialUrl) {
        $region = trim((string) ($point->ville ?: $point->adresse ?: 'Autre region'));
        $details = $point->relationLoaded('details') ? $point->details : null;
        $pointImages = collect();

        if (!empty($point->main_image)) {
            $mainImageUrl = $landingMapMediaUrl($point->main_image);
            if ($mainImageUrl) {
                $pointImages->push([
                    'src' => $mainImageUrl,
                    'thumb' => $mainImageUrl,
                    'caption' => $point->title ?: 'Image principale',
                ]);
            }
        }

        if ($point->relationLoaded('mainImage') && $point->mainImage) {
            $mainImageUrl = $landingMapMediaUrl($point->mainImage->image ?? null);
            $mainThumbUrl = $landingMapMediaUrl($point->mainImage->thumbnail ?? null) ?: $mainImageUrl;
            if ($mainThumbUrl) {
                $pointImages->push([
                    'src' => $mainImageUrl ?: $mainThumbUrl,
                    'thumb' => $mainThumbUrl,
                    'caption' => $point->mainImage->caption ?: ($point->title ?: 'Image principale'),
                ]);
            }
        }

        if ($point->relationLoaded('images')) {
            collect($point->images)->each(function ($image) use ($pointImages, $landingMapMediaUrl) {
                $imageUrl = $landingMapMediaUrl($image->image ?? null);
                $thumbUrl = $landingMapMediaUrl($image->thumbnail ?? null) ?: $imageUrl;
                if ($thumbUrl) {
                    $pointImages->push([
                        'src' => $imageUrl ?: $thumbUrl,
                        'thumb' => $thumbUrl,
                        'caption' => $image->caption ?: 'Galerie',
                    ]);
                }
            });
        }

        $pointImages = $pointImages
            ->filter(fn ($item) => !empty($item['thumb']))
            ->unique('thumb')
            ->take(8)
            ->values();

        $pointSocialLinks = collect($details?->social_networks ?? [])
            ->map(function ($link, $key) use ($landingMapNormalizeSocialUrl) {
                $url = $landingMapNormalizeSocialUrl(data_get($link, 'url') ?: (is_string($link) ? $link : null));
                if (!$url) {
                    return null;
                }

                return [
                    'key' => is_string($key) ? $key : 'link',
                    'url' => $url,
                    'label' => data_get($link, 'label') ?: ucfirst((string) $key),
                    'icon' => data_get($link, 'icon') ?: 'fas fa-link',
                ];
            })
            ->filter()
            ->values();

        return [
            'id' => $point->id,
            'title' => $point->title ?: ($point->video_title ?? 'Point video'),
            'description' => $details?->long_description ?: $point->description,
            'category' => $point->category ?: 'Autre',
            'region' => $region !== '' ? $region : 'Autre region',
            'latitude' => (float) $point->latitude,
            'longitude' => (float) $point->longitude,
            'adresse' => trim(collect([$point->adresse, $point->ville, $point->code_postal])->filter()->implode(', ')),
            'youtube_id' => $point->youtube_id,
            'embed_url' => $point->embed_url,
            'gallery' => $pointImages->isNotEmpty() ? $pointImages : $landingMapFallbackGallery,
            'socials' => $pointSocialLinks->isNotEmpty() ? $pointSocialLinks : $landingMapSocialLinks,
            'website' => $landingMapNormalizeSocialUrl($details?->website ?: ($point->has_details_page ? $point->details_url : null)),
        ];
    })->values();

    $landingMapRegions = $landingMapPayload
        ->pluck('region')
        ->filter()
        ->unique()
        ->sort()
        ->values();
@endphp

@if($landingMapPoints->isNotEmpty())
    @once
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
        <style>
            :root {
              --td-navy: #0A0E1A; --td-navy-2: #111827; --td-amber: #F5A623; --td-amber-dark: #D4891A;
              --td-sand: #E8D5B0; --td-text-muted: #8A95A8; --td-border: rgba(232,213,176,0.12);
              --td-glass-bg: rgba(255,255,255,0.06); --td-glass-border: rgba(255,255,255,0.12);
              --td-card-bg: #111827; --td-section-alt: #0F1522; --td-shadow: 0 8px 32px rgba(0,0,0,0.4);
              --td-radius-sm: 8px; --td-radius-md: 16px;
              --td-transition: 0.35s cubic-bezier(0.4,0,0.2,1);
            }
            .container{width:min(1280px,92vw);margin-inline:auto}
            .section{padding:100px 0}
            .section-header{text-align:center;margin-bottom:56px}
            .eyebrow{display:inline-block;font-size:0.75rem;font-weight:600;letter-spacing:0.16em;text-transform:uppercase;color:var(--td-amber);margin-bottom:0.75rem}
            .section-title{font-family:'Italiana',serif;color:var(--td-sand);font-size:clamp(28px,4vw,46px);line-height:1.05;font-weight:900}
            .section-subtitle{margin-top:12px;font-size:1rem;color:var(--td-text-muted)}
            .map-section{position:relative;overflow:hidden;padding:64px 24px}
            .map-section.is-inline{padding:0;background:transparent;height:100%;min-height:420px}
            .map-section.is-inline:before{display:none}
            .map-section.is-inline .container{width:100%;max-width:none}
            .map-section:before{content:'';position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,var(--td-amber),var(--td-amber-dark))}
            .map-wrapper{border-radius:var(--td-radius-md);overflow:hidden;box-shadow:var(--td-shadow)}
            .travel-map{width:100%;height:500px;z-index:1}
            .travel-map .leaflet-container{font-family:'DM Sans',sans-serif;background:var(--td-navy)}
            .travel-map .leaflet-control-zoom a{background:var(--td-glass-bg);color:var(--td-sand);border-color:var(--td-border)}
            .travel-map .leaflet-control-zoom a:hover{background:var(--td-amber);color:#000}
            .travel-map .leaflet-control-attribution{background:transparent;color:var(--td-text-muted);font-size:0.65rem}
            .travel-map .leaflet-control-attribution a{color:var(--td-amber)}
            .map-marker{background:transparent!important;border:none!important}
            .map-popup-wrapper .leaflet-popup-content-wrapper{background:var(--td-card-bg);color:var(--td-sand);border-radius:var(--td-radius-sm);box-shadow:var(--td-shadow);border:1px solid var(--td-glass-border);padding:0;overflow:hidden}
            .map-popup-wrapper .leaflet-popup-tip{background:var(--td-card-bg);border:1px solid var(--td-glass-border)}
            .map-popup-wrapper .leaflet-popup-content{margin:0;width:280px!important}
            .map-popup-wrapper .leaflet-popup-close-button{color:var(--td-text-muted)!important;top:8px!important;right:8px!important;font-size:1.2rem!important;z-index:2}
            .map-popup__body{padding:14px 16px}
            .map-popup__title{font-size:0.95rem;font-weight:600;margin-bottom:6px;color:var(--td-sand)}
            .map-popup__desc{font-size:0.8rem;color:var(--td-text-muted);line-height:1.5;margin-bottom:10px}
            .map-popup__detail-btn{display:block;width:100%;padding:10px 16px;background:var(--td-amber);color:#000;border-radius:var(--td-radius-sm);font-size:0.82rem;font-weight:600;text-align:center;transition:all var(--td-transition);cursor:pointer;border:0}
            .map-popup__detail-btn:hover{background:var(--td-amber-dark)}
            .map-popup__video{height:160px;overflow:hidden;background:#000}
            .map-popup__video iframe{width:100%;height:100%;border:0}
            .map-region-filter{text-align:center;margin-bottom:16px}
            .map-region-select{padding:10px 20px;border:1px solid var(--td-border);border-radius:50px;font-size:0.85rem;font-weight:600;color:var(--td-sand);background:var(--td-glass-bg);cursor:pointer;min-width:220px;max-width:100%;outline:none;transition:border-color var(--td-transition);appearance:auto}
            .map-region-select:hover,.map-region-select:focus{border-color:var(--td-amber)}
            .map-filters{display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin-bottom:24px}
            .map-filter-btn{padding:8px 20px;border:1px solid var(--td-border);border-radius:50px;font-size:0.82rem;font-weight:600;color:var(--td-text-muted);transition:all var(--td-transition);cursor:pointer;background:transparent;display:inline-flex;align-items:center;gap:6px}
            .map-filter-btn:hover{border-color:var(--td-amber);color:var(--td-amber)}
            .map-filter-btn.active{background:var(--td-amber);color:#000;border-color:var(--td-amber)}
            .map-filter-btn__icon{display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;font-size:1rem;flex-shrink:0}
            .map-filter-btn__label{white-space:nowrap}
            .map-modal{display:none;position:fixed;inset:0;z-index:5000;background:rgba(0,0,0,0.8);overflow-y:auto}
            .map-modal__backdrop{position:fixed;inset:0;z-index:-1}
            .map-modal__content{position:relative;width:min(720px,94vw);max-height:90vh;background:var(--td-card-bg);border-radius:var(--td-radius-md);overflow-y:auto;margin:50px auto;animation:modalSlideIn .3s ease}
            @keyframes modalSlideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
            .map-modal__close{position:absolute;top:16px;right:16px;z-index:1;width:40px;height:40px;display:flex;align-items:center;justify-content:center;font-size:1.6rem;color:var(--td-text-muted);background:rgba(0,0,0,0.1);border-radius:50%;transition:all var(--td-transition);cursor:pointer;border:0}
            .map-modal__close:hover{color:var(--td-amber);background:var(--td-glass-bg)}
            .map-modal__body{padding:0 32px 32px}
            .map-modal__video{width:100%;height:0;padding-bottom:56.25%;position:relative;background:#000;border-radius:var(--td-radius-sm) var(--td-radius-sm) 0 0;overflow:hidden}
            .map-modal__video iframe{position:absolute;inset:0;width:100%;height:100%;border:0}
            .map-modal__video:empty{display:none}
            .map-modal__gallery{display:flex;gap:8px;overflow-x:auto;margin-bottom:24px;padding-bottom:8px}
            .map-modal__gallery img{width:160px;height:100px;object-fit:cover;border-radius:var(--td-radius-sm);flex-shrink:0}
            .map-modal__title{font-family:'Italiana',serif;font-size:1.6rem;margin-bottom:12px;color:var(--td-sand)}
            .map-modal__description{font-size:0.92rem;color:var(--td-text-muted);line-height:1.7;margin-bottom:16px}
            .map-modal__meta{display:flex;flex-wrap:wrap;gap:8px 16px;margin-bottom:20px}
            .map-modal__tag{padding:4px 12px;background:rgba(245,166,35,0.12);color:var(--td-amber);border-radius:50px;font-size:0.75rem;font-weight:600}
            .map-modal__meta-item{font-size:0.82rem;color:var(--td-text-muted)}
            .map-modal__actions{margin-top:24px}
            .btn{display:inline-flex;align-items:center;gap:8px;padding:14px 28px;border-radius:50px;font-size:0.9rem;font-weight:600;text-decoration:none;transition:all var(--td-transition)}
            .btn--primary{background:var(--td-amber);color:#000;border:1px solid var(--td-amber)}
            .btn--primary:hover{background:var(--td-amber-dark);border-color:var(--td-amber-dark);transform:translateY(-2px);box-shadow:0 8px 24px rgba(245,166,35,0.4)}
            @media(max-width:600px){.map-popup-wrapper .leaflet-popup-content{width:220px!important}.map-popup__video{height:120px}.map-popup__body{padding:10px 12px}.map-popup__title{font-size:0.85rem}.map-popup__desc{font-size:0.75rem}.map-popup__detail-btn{padding:8px 12px;font-size:0.78rem}}
            @media(max-width:640px){.travel-map{height:380px}}
        </style>
    @endonce

    <section class="map-section section{{ $landingMapIsInline ? ' is-inline' : '' }}" id="map" aria-labelledby="map-heading">
        <div class="container">
            <div class="section-header reveal-up">
                <span class="eyebrow">Explorer</span>
                <h2 class="section-title" id="map-heading">{{ $landingMapSectionTitle }}</h2>
                <p class="section-subtitle">Cliquez sur les marqueurs pour en savoir plus</p>
            </div>
            <div class="map-region-filter">
                <select id="mapRegionSelect" class="map-region-select">
                    <option value="all">Toutes les régions</option>
                    @foreach($landingMapRegions as $region)
                        <option value="{{ $region }}">{{ $region }}</option>
                    @endforeach
                </select>
            </div>
            <div class="map-filters" id="mapFilters">
                <button class="map-filter-btn active" data-filter="all">Tous</button>
            </div>
            <div class="map-wrapper">
                <div id="{{ $landingMapId }}" class="travel-map"></div>
            </div>
        </div>
    </section>
    <div class="map-modal" id="mapDetailModal">
        <div class="map-modal__backdrop" id="mapModalBackdrop"></div>
        <div class="map-modal__content">
            <button class="map-modal__close" id="mapModalClose">&times;</button>
            <div class="map-modal__body">
                <div class="map-modal__video" id="mapModalVideo"></div>
                <div class="map-modal__gallery" id="mapModalGallery"></div>
                <div class="map-modal__info">
                    <h3 class="map-modal__title" id="map-modal-title"></h3>
                    <div class="map-modal__description"></div>
                    <div class="map-modal__meta" id="mapModalMeta"></div>
                    <div class="map-modal__actions">
                        <a href="#" class="btn btn--primary" id="mapModalWebsite" target="_blank" rel="noopener">Visiter le site</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @once
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    @endonce
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var mapEl = document.getElementById('{{ $landingMapId }}');
        if (!mapEl) return;

        var pointsRaw = @json($landingMapPayload);
        var points = [];
        var uniqueCategories = {};
        pointsRaw.forEach(function (p) {
            if (!Number.isFinite(Number(p.latitude)) || !Number.isFinite(Number(p.longitude))) return;
            if (!p.youtube_id && !p.embed_url) return;
            var cat = (p.category || 'Autre').trim();
            if (cat) uniqueCategories[cat] = true;
            points.push({
                id: p.id,
                title: p.title || 'Point',
                description: p.description || '',
                latitude: Number(p.latitude),
                longitude: Number(p.longitude),
                category: cat || 'Autre',
                region: p.region || 'Autre region',
                adresse: p.adresse || '',
                youtube_id: p.youtube_id || '',
                embed_url: p.embed_url || (p.youtube_id ? 'https://www.youtube.com/embed/' + p.youtube_id + '?autoplay=0&rel=0&playsinline=1' : ''),
                gallery: Array.isArray(p.gallery) ? p.gallery : [],
                socials: Array.isArray(p.socials) ? p.socials : [],
                website: p.website || ''
            });
        });
        if (!points.length) return;

        var categoryStyle = {
            'Tourisme': { icon: 'fas fa-route', color: '#2a5bd7' },
            'Culture': { icon: 'fas fa-masks-theater', color: '#805ad5' },
            'Histoire': { icon: 'fas fa-landmark', color: '#7c3aed' },
            'Nature': { icon: 'fas fa-tree', color: '#16a34a' },
            'Aventure': { icon: 'fas fa-person-hiking', color: '#ea580c' },
            'Shopping': { icon: 'fas fa-bag-shopping', color: '#ca8a04' },
            'Plage': { icon: 'fas fa-umbrella-beach', color: '#0ea5e9' },
            'Famille': { icon: 'fas fa-people-roof', color: '#db2777' },
            'Restaurant': { icon: 'fas fa-utensils', color: '#e53e3e' },
            'Hôtel': { icon: 'fas fa-bed', color: '#38a169' },
            'Santé': { icon: 'fas fa-heart-pulse', color: '#dc2626' },
            'Sport': { icon: 'fas fa-dumbbell', color: '#059669' },
            'Loisirs': { icon: 'fas fa-gamepad', color: '#9333ea' },
            'Transport': { icon: 'fas fa-car', color: '#ea580c' },
            'Immobilier': { icon: 'fas fa-building', color: '#475569' },
            'Service': { icon: 'fas fa-handshake', color: '#0f766e' },
            'Autre': { icon: 'fas fa-map-marker-alt', color: '#f2b705' }
        };
        var defaultStyle = { icon: 'fas fa-map-marker-alt', color: '#f2b705' };

        function getCategoryStyle(cat) {
            var cl = (cat || '').toLowerCase();
            for (var k in categoryStyle) { if (k.toLowerCase() === cl) return categoryStyle[k]; }
            return defaultStyle;
        }

        var lats = points.map(function (p) { return p.latitude; });
        var lngs = points.map(function (p) { return p.longitude; });
        var map = L.map('{{ $landingMapId }}', {
            center: [(Math.min.apply(null, lats) + Math.max.apply(null, lats)) / 2, (Math.min.apply(null, lngs) + Math.max.apply(null, lngs)) / 2],
            zoom: 8, zoomControl: true, scrollWheelZoom: true
        });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a>' }).addTo(map);
        map.whenReady(function () { map.invalidateSize(); });

        var markersLayer = L.layerGroup().addTo(map);
        var allPoints = points;
        var pointsData = [];
        var activeCategory = 'all';
        var activeRegion = document.getElementById('mapRegionSelect')?.value || 'all';

        function escapeHtml(str) { if (!str) return ''; var d = document.createElement('div'); d.appendChild(document.createTextNode(str)); return d.innerHTML; }

        function getFilteredPoints() {
            return allPoints.filter(function (p) {
                var catMatch = activeCategory === 'all' || (p.category || 'Autre') === activeCategory;
                var regionMatch = activeRegion === 'all' || (p.region || 'Autre region') === activeRegion;
                return catMatch && regionMatch;
            });
        }

        function buildPopupHtml(p, idx) {
            var eu = p.youtube_id ? 'https://www.youtube.com/embed/' + p.youtube_id + '?autoplay=1' : '';
            var h = '<div class="map-popup">';
            if (eu) h += '<div class="map-popup__video"><iframe src="' + eu + '" frameborder="0" allowfullscreen></iframe></div>';
            h += '<div class="map-popup__body"><h4 class="map-popup__title">' + escapeHtml(p.title) + '</h4>';
            if (p.description) h += '<p class="map-popup__desc">' + escapeHtml(p.description.substring(0, 120)) + '</p>';
            h += '<button class="map-popup__detail-btn" data-index="' + idx + '">Voir d\u00e9tails</button></div></div>';
            return h;
        }

        function getMarkerIcon(cat) {
            var s = getCategoryStyle(cat);
            return L.divIcon({
                className: 'map-marker',
                html: '<div style="width:32px;height:32px;border-radius:50%;background:' + s.color + ';display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,0.4);border:2px solid #fff"><i class="' + s.icon + '" style="font-size:14px;color:#fff"></i></div>',
                iconSize: [36, 36], iconAnchor: [18, 36]
            });
        }

        function renderFilteredPoints() {
            var data = getFilteredPoints();
            markersLayer.clearLayers();
            pointsData = [];
            var bounds = [];
            data.forEach(function (p, idx) {
                pointsData.push(p);
                var m = L.marker([p.latitude, p.longitude], { icon: getMarkerIcon(p.category) }).addTo(markersLayer).bindPopup(buildPopupHtml(p, idx), { maxWidth: 320, className: 'map-popup-wrapper' });
                m._pointIndex = idx;
                bounds.push([p.latitude, p.longitude]);
            });
            if (bounds.length) map.fitBounds(bounds, { padding: [40, 40], maxZoom: 14 });
            rebuildCategoryFilters();
        }

        function rebuildCategoryFilters() {
            var el = document.getElementById('mapFilters');
            if (!el) return;
            var h = '<button class="map-filter-btn' + (activeCategory === 'all' ? ' active' : '') + '" data-filter="all">Tous</button>';
            var seen = {};
            allPoints.forEach(function (p) {
                var c = p.category || 'Autre';
                if (seen[c]) return;
                seen[c] = true;
                var s = getCategoryStyle(c);
                h += '<button class="map-filter-btn' + (activeCategory === c ? ' active' : '') + '" data-filter="' + escapeHtml(c) + '"><span class="map-filter-btn__icon"><i class="' + s.icon + '" style="color:' + s.color + '"></i></span><span class="map-filter-btn__label">' + escapeHtml(c) + '</span></button>';
            });
            el.innerHTML = h;
            el.querySelectorAll('.map-filter-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    activeCategory = btn.getAttribute('data-filter');
                    renderFilteredPoints();
                });
            });
        }

        var regionSelect = document.getElementById('mapRegionSelect');
        if (regionSelect) {
            regionSelect.addEventListener('change', function () {
                activeRegion = this.value;
                activeCategory = 'all';
                renderFilteredPoints();
            });
        }

        renderFilteredPoints();

        map.on('popupopen', function (e) {
            var c = e.popup.getElement();
            if (!c) return;
            c.querySelectorAll('.map-popup__detail-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var idx = parseInt(btn.getAttribute('data-index'));
                    var pt = pointsData[idx];
                    if (pt) showPlaceModal(pt);
                });
            });
        });

        function showPlaceModal(point) {
            var modal = document.getElementById('mapDetailModal');
            var mc = document.getElementById('mapModalMeta');
            if (!modal || !mc) return;
            document.getElementById('map-modal-title').textContent = point.title || 'D\u00e9tails';
            var ve = document.getElementById('mapModalVideo');
            var eu = point.youtube_id ? 'https://www.youtube.com/embed/' + point.youtube_id + '?autoplay=0&rel=0' : '';
            if (ve) ve.innerHTML = eu ? '<iframe src="' + eu + '" frameborder="0" allowfullscreen></iframe>' : '';
            var de = modal.querySelector('.map-modal__description');
            de.innerHTML = point.description || '';
            var mh = '';
            if (point.category) mh += '<span class="map-modal__tag">' + escapeHtml(point.category) + '</span>';
            if (point.adresse) mh += '<span class="map-modal__tag">' + escapeHtml(point.adresse) + '</span>';
            if (point.region) mh += '<span class="map-modal__meta-item">&#9906; ' + escapeHtml(point.region) + '</span>';
            mc.innerHTML = mh;
            var ge = document.getElementById('mapModalGallery');
            ge.innerHTML = '';
            if (point.gallery && point.gallery.length) {
                point.gallery.forEach(function (img) {
                    var el = document.createElement('img');
                    el.src = img.thumb || img.src || '';
                    el.alt = img.caption || '';
                    el.loading = 'lazy';
                    ge.appendChild(el);
                });
            }
            var wl = document.getElementById('mapModalWebsite');
            if (point.website) { wl.href = point.website; wl.style.display = 'inline-flex'; } else { wl.style.display = 'none'; }
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
            if (e.key === 'Escape') { var m = document.getElementById('mapDetailModal'); if (m && m.style.display === 'block') closePlaceModal(); }
        });
    });
    </script>
@endif
