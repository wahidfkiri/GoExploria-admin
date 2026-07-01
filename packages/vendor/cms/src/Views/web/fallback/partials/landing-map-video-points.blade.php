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
            .cms-map-video-section{padding:64px 24px;background:linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%);color:#1a1d28;position:relative;overflow:hidden}
            .cms-map-video-section:before{content:'';position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,#2a5bd7,#00c9b7)}
            .cms-map-video-inner{max-width:1240px;margin:0 auto;position:relative;z-index:1}
            .cms-map-video-section.is-inline{padding:0;background:transparent;color:inherit;height:100%;min-height:420px}
            .cms-map-video-section.is-inline:before,.cms-map-video-section.is-inline .cms-map-video-head{display:none}
            .cms-map-video-section.is-inline .cms-map-video-inner,.cms-map-video-section.is-inline .cms-map-video-app{height:100%;max-width:none;min-height:420px;margin:0}
            .cms-map-video-head{display:flex;justify-content:space-between;align-items:end;gap:24px;margin-bottom:22px}
            .cms-map-video-kicker{display:inline-flex;align-items:center;gap:8px;margin:0 0 8px;color:#2a5bd7;font-size:12px;font-weight:900;letter-spacing:.18em;text-transform:uppercase}
            .cms-map-video-title{margin:0;color:#0a1628;font-size:clamp(28px,4vw,46px);line-height:1.05;font-weight:900}
            .cms-map-video-count{display:inline-flex;align-items:center;gap:8px;color:#0a1628;background:#fff;border:1px solid #d8e2ff;border-radius:999px;padding:10px 14px;font-weight:800;box-shadow:0 10px 30px rgba(0,0,0,.08)}
            .cms-map-video-app{width:100%;height:620px;position:relative;border-radius:20px;overflow:hidden;background:#fff;box-shadow:0 20px 50px rgba(15,23,42,.12);border:1px solid rgba(15,23,42,.08)}
            .cms-map-video-map-container{position:absolute;inset:0}
            .cms-map-video-canvas{height:100%;width:100%;background:#e5e7eb}
            .cms-map-video-sidebar{position:absolute;top:0;right:0;bottom:0;width:370px;background:#fff;box-shadow:-5px 0 20px rgba(0,0,0,.10);overflow:auto;z-index:500;display:flex;flex-direction:column}
            .cms-map-video-filters{padding:20px;border-bottom:1px solid #e9ecef;background:#fff;flex-shrink:0}
            .cms-map-video-filter-group{margin-bottom:14px}
            .cms-map-video-filter-group label{display:block;margin-bottom:6px;color:#1a1d28;font-size:.88rem;font-weight:800}
            .cms-map-video-filter-group i{color:#2a5bd7;margin-right:6px}
            .cms-map-filters{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px}
            .cms-map-filter-btn{padding:8px 16px;border:1px solid #d8e2ff;border-radius:999px;font-size:.82rem;font-weight:700;color:#64748b;cursor:pointer;background:#fff;display:inline-flex;align-items:center;gap:6px;transition:all .2s}
            .cms-map-filter-btn:hover{border-color:#2a5bd7;color:#2a5bd7;background:#f5f7ff}
            .cms-map-filter-btn.active{background:#2a5bd7;color:#fff;border-color:#2a5bd7}
            .cms-map-filter-btn__icon{display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;font-size:.9rem;flex-shrink:0}
            .cms-map-filter-btn__label{white-space:nowrap}
            .cms-map-video-select{width:100%;min-height:42px;border:1px solid #d8e2ff;border-radius:10px;background:#fff;color:#1a1d28;padding:9px 12px;font:inherit;font-size:.92rem;font-weight:650;outline:none;transition:border-color .2s,box-shadow .2s}
            .cms-map-video-select:focus{border-color:#2a5bd7;box-shadow:0 0 0 3px rgba(42,91,215,.12)}
            .cms-map-video-locate{width:100%;min-height:42px;border:0;border-radius:10px;background:linear-gradient(90deg,#2a5bd7,#1a3fa0);color:#fff;font-weight:850;display:flex;align-items:center;justify-content:center;gap:8px;cursor:pointer}
            .cms-map-video-locate:hover{filter:brightness(1.04)}
            .cms-map-video-stats{margin-top:14px;text-align:center;padding:12px;border-radius:10px;background:#f5f7ff;color:#1a1d28;font-weight:750}
            .cms-map-video-stats span{font-size:1.1rem;color:#2a5bd7;font-weight:950}
            .cms-map-video-list{padding:18px;overflow:auto;flex:1}
            .cms-map-video-place{background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;margin-bottom:16px;box-shadow:0 5px 16px rgba(15,23,42,.08);cursor:pointer;transition:transform .2s,box-shadow .2s,border-color .2s}
            .cms-map-video-place:hover,.cms-map-video-place.is-active{transform:translateY(-3px);border-color:#2a5bd7;box-shadow:0 14px 28px rgba(42,91,215,.16)}
            .cms-map-video-place-media{position:relative;height:138px;background:#000;overflow:hidden}
            .cms-map-video-place-media iframe{width:100%;height:100%;border:0;display:block;pointer-events:none}
            .cms-map-video-play{position:absolute;inset:auto 12px 12px auto;width:38px;height:38px;border-radius:999px;background:rgba(255,255,255,.92);color:#2a5bd7;display:grid;place-items:center;box-shadow:0 10px 24px rgba(0,0,0,.22)}
            .cms-map-video-place-info{padding:14px}
            .cms-map-video-place-info h4{margin:0 0 8px;color:#111827;font-size:1.02rem;line-height:1.25;font-weight:900}
            .cms-map-video-place-meta{display:flex;align-items:center;gap:7px;flex-wrap:wrap;margin-bottom:8px}
            .cms-map-video-chip{display:inline-flex;align-items:center;gap:5px;border-radius:999px;padding:5px 9px;background:#2a5bd7;color:#fff;font-size:.74rem;font-weight:800}
            .cms-map-video-region{color:#64748b;font-size:.82rem;font-weight:700}
            .cms-map-video-place-info p{margin:0;color:#64748b;font-size:.86rem;line-height:1.5}
            .cms-map-video-empty{display:grid;place-items:center;text-align:center;min-height:180px;color:#64748b;padding:30px 18px}
            .cms-map-video-empty i{font-size:2.4rem;color:#cbd5e1;margin-bottom:12px}
            .cms-map-video-popup{width:320px;max-width:100%;padding:0}
            .cms-map-video-popup h4{margin:0 0 10px;color:#111827;font-size:16px;line-height:1.25}
            .cms-map-video-popup iframe{width:100%;height:190px;border:0;border-radius:12px;background:#000}
            .cms-map-video-popup-meta{display:flex;gap:7px;flex-wrap:wrap;margin:8px 0 0;color:#64748b;font-size:12px;font-weight:700}
            .cms-map-video-details-btn{width:100%;min-height:38px;margin-top:12px;border:0;border-radius:8px;background:#2a5bd7;color:#fff;font-size:12px;font-weight:850;display:flex;align-items:center;justify-content:center;gap:7px;cursor:pointer;transition:background .2s,transform .2s}
            .cms-map-video-details-btn:hover{background:#1a3fa0;transform:translateY(-1px)}
            .cms-map-video-place-actions{display:flex;gap:10px;margin-top:13px}
            .cms-map-video-place-actions .cms-map-video-details-btn{margin:0;min-height:36px}
            .cms-map-video-marker{width:40px;height:40px;border-radius:50%;display:grid;place-items:center;color:#fff;border:3px solid #fff;box-shadow:0 10px 28px rgba(0,0,0,.35);transition:transform .2s,box-shadow .2s}
            .cms-map-video-marker i{font-size:16px;line-height:1}
            .cms-map-video-marker.is-filtered{transform:scale(1.13);box-shadow:0 0 0 4px rgba(42,91,215,.24),0 12px 30px rgba(0,0,0,.38)}
            .cms-map-video-modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.78);z-index:99999;overflow:auto;padding:34px 16px}
            .cms-map-video-modal.is-open{display:block}
            .cms-map-video-modal-card{position:relative;width:min(920px,94vw);margin:36px auto;background:#fff;color:#111827;border-radius:20px;overflow:hidden;box-shadow:0 30px 90px rgba(0,0,0,.35);animation:cmsMapModalIn .25s ease}
            .cms-map-video-modal-close{position:absolute;top:16px;right:16px;z-index:3;width:42px;height:42px;border:0;border-radius:50%;background:rgba(0,0,0,.58);color:#fff;font-size:24px;line-height:1;display:grid;place-items:center;cursor:pointer;transition:background .2s,transform .2s}
            .cms-map-video-modal-close:hover{background:rgba(0,0,0,.82);transform:rotate(90deg)}
            .cms-map-video-modal-media{position:relative;background:#000;aspect-ratio:16/9}
            .cms-map-video-modal-media iframe{position:absolute;inset:0;width:100%;height:100%;border:0}
            .cms-map-video-modal-body{padding:clamp(22px,4vw,36px)}
            .cms-map-video-modal-tags{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px}
            .cms-map-video-modal-tag{display:inline-flex;align-items:center;gap:7px;border-radius:999px;padding:7px 11px;background:#f5f7ff;color:#2a5bd7;font-size:12px;font-weight:850}
            .cms-map-video-modal-body h3{margin:0 0 12px;color:#111827;font-size:clamp(24px,3vw,36px);line-height:1.08;font-weight:950}
            .cms-map-video-modal-body p{margin:0;color:#475569;line-height:1.72}
            .cms-map-video-modal-address{margin-top:18px;padding-top:18px;border-top:1px solid #e5e7eb;color:#64748b;font-weight:750}
            .cms-map-video-modal-section{margin-top:24px;padding-top:22px;border-top:1px solid #e5e7eb}
            .cms-map-video-modal-section-title{display:flex;align-items:center;gap:8px;margin:0 0 14px;color:#111827;font-size:14px;font-weight:950;letter-spacing:.08em;text-transform:uppercase}
            .cms-map-video-modal-gallery{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px}
            .cms-map-video-modal-gallery a{position:relative;display:block;min-height:108px;border-radius:12px;overflow:hidden;background:#e5e7eb;border:1px solid #e5e7eb}
            .cms-map-video-modal-gallery img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .25s}
            .cms-map-video-modal-gallery a:hover img{transform:scale(1.06)}
            .cms-map-video-modal-socials{display:flex;flex-wrap:wrap;gap:10px}
            .cms-map-video-modal-social{display:inline-flex;align-items:center;gap:8px;min-height:40px;border-radius:999px;padding:9px 13px;background:#f5f7ff;color:#2a5bd7;text-decoration:none;font-size:13px;font-weight:850;border:1px solid #d8e2ff;transition:transform .2s,background .2s,color .2s}
            .cms-map-video-modal-social:hover{transform:translateY(-2px);background:#2a5bd7;color:#fff}
            .cms-map-video-modal-cta{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:42px;margin-top:20px;border-radius:10px;padding:10px 16px;background:#111827;color:#fff;text-decoration:none;font-weight:900}
            .cms-map-video-modal-cta:hover{background:#2a5bd7;color:#fff}
            @keyframes cmsMapModalIn{from{opacity:0;transform:translateY(-24px)}to{opacity:1;transform:translateY(0)}}
            .leaflet-popup-content-wrapper{border-radius:14px;overflow:hidden}
            .leaflet-popup-content{margin:12px}
            @media(max-width:980px){.cms-map-video-app{height:auto;min-height:0;overflow:visible}.cms-map-video-map-container{position:relative;height:430px;border-radius:20px 20px 0 0;overflow:hidden}.cms-map-video-sidebar{position:relative;inset:auto;width:100%;max-height:none;border-radius:0 0 20px 20px}.cms-map-video-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}.cms-map-video-place{margin:0}.cms-map-video-head{display:block}.cms-map-video-count{margin-top:14px}}
            @media(max-width:640px){.cms-map-video-section{padding:46px 14px}.cms-map-video-title{font-size:26px}.cms-map-video-map-container{height:380px}.cms-map-video-filters{padding:16px}.cms-map-video-list{grid-template-columns:1fr;padding:16px}.cms-map-video-place-media{height:150px}.cms-map-video-modal-gallery{grid-template-columns:repeat(2,minmax(0,1fr))}.cms-map-video-modal-gallery a{min-height:104px}}
        </style>
    @endonce

    <section class="cms-map-video-section{{ $landingMapIsInline ? ' is-inline' : '' }}" id="map">
        <div class="cms-map-video-inner">
            <div class="cms-map-video-head">
                <div>
                    <p class="cms-map-video-kicker"><i class="fas fa-map-location-dot"></i> Carte interactive</p>
                    <h2 class="cms-map-video-title">{{ $landingMapSectionTitle }}</h2>
                </div>
                <div class="cms-map-video-count"><i class="fas fa-map-pin"></i> <span data-cms-map-total="{{ $landingMapId }}">{{ $landingMapPoints->count() }}</span> lieu{{ $landingMapPoints->count() > 1 ? 'x' : '' }} trouvé{{ $landingMapPoints->count() > 1 ? 's' : '' }}</div>
            </div>

            <div class="cms-map-video-app" data-cms-map-app="{{ $landingMapId }}">
                <div class="cms-map-video-map-container">
                    <div id="{{ $landingMapId }}" class="cms-map-video-canvas"></div>
                </div>
                <aside class="cms-map-video-sidebar">
                    <div class="cms-map-video-filters">
                        <div class="cms-map-video-filter-group">
                            <label><i class="fas fa-tag"></i> Catégorie</label>
                            <div class="cms-map-filters" data-cms-map-filters="{{ $landingMapId }}">
                                <button class="cms-map-filter-btn active" data-filter="all">Tous</button>
                                @foreach($landingMapCategories as $category)
                                    <button class="cms-map-filter-btn" data-filter="{{ $category }}">{{ $category }}</button>
                                @endforeach
                            </div>
                        </div>
                        <div class="cms-map-video-filter-group">
                            <label for="{{ $landingMapId }}-region"><i class="fas fa-location-dot"></i> Région</label>
                            <select id="{{ $landingMapId }}-region" class="cms-map-video-select" data-cms-map-region="{{ $landingMapId }}">
                                <option value="all">Toutes les régions</option>
                                @foreach($landingMapRegions as $region)
                                    <option value="{{ $region }}">{{ $region }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="cms-map-video-locate" data-cms-map-locate="{{ $landingMapId }}">
                            <i class="fas fa-location-arrow"></i> Me localiser
                        </button>
                        <div class="cms-map-video-stats">
                            <i class="fas fa-map-pin"></i> <span data-cms-map-count="{{ $landingMapId }}">{{ $landingMapPoints->count() }}</span> lieux affichés
                        </div>
                    </div>
                    <div class="cms-map-video-list" data-cms-map-list="{{ $landingMapId }}"></div>
                </aside>
            </div>
        </div>
    </section>
    <div id="{{ $landingMapId }}-modal" class="cms-map-video-modal" aria-hidden="true">
        <div class="cms-map-video-modal-card" role="dialog" aria-modal="true" aria-labelledby="{{ $landingMapId }}-modal-title">
            <button type="button" class="cms-map-video-modal-close" data-cms-map-modal-close="{{ $landingMapId }}" aria-label="Fermer">&times;</button>
            <div data-cms-map-modal-content="{{ $landingMapId }}"></div>
        </div>
    </div>

    @once
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    @endonce
    <script>
        (function () {
            const mapNode = document.getElementById(@json($landingMapId));
            if (!mapNode || !window.L) return;

            const mapKey = @json($landingMapId);
            const filtersNode = document.querySelector(`[data-cms-map-filters="${mapKey}"]`);
            const categoryBtns = filtersNode ? [...filtersNode.querySelectorAll('.cms-map-filter-btn')] : [];
            const regionSelect = document.querySelector(`[data-cms-map-region="${mapKey}"]`);
            const listNode = document.querySelector(`[data-cms-map-list="${mapKey}"]`);
            const countNode = document.querySelector(`[data-cms-map-count="${mapKey}"]`);
            const totalNode = document.querySelector(`[data-cms-map-total="${mapKey}"]`);
            const locateButton = document.querySelector(`[data-cms-map-locate="${mapKey}"]`);
            const modalNode = document.getElementById(`${mapKey}-modal`);
            const modalContentNode = document.querySelector(`[data-cms-map-modal-content="${mapKey}"]`);
            const modalCloseButton = document.querySelector(`[data-cms-map-modal-close="${mapKey}"]`);
            const allowedCategories = @json($landingMapCategories);
            let points = @json($landingMapPayload);

            const esc = value => String(value || '').replace(/[&<>"']/g, char => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[char]);

            const normalize = value => String(value || '')
                .trim()
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9]+/g, '_')
                .replace(/^_+|_+$/g, '');

            const categoryAliases = {
                tourism: 'Tourisme',
                tourisme: 'Tourisme',
                voyage: 'Tourisme',
                voyages: 'Tourisme',
                culture: 'Culture',
                histoire: 'Histoire',
                history: 'Histoire',
                nature: 'Nature',
                aventure: 'Aventure',
                adventure: 'Aventure',
                shopping: 'Shopping',
                science: 'Science',
                plage: 'Plage',
                beach: 'Plage',
                famille: 'Famille',
                family: 'Famille',
                restaurant: 'Restaurant',
                food: 'Restaurant',
                alimentation: 'Restaurant',
                hotel: 'Hôtel',
                hebergement: 'Hôtel',
                commerce: 'Commerce',
                ecommerce: 'Commerce',
                boutique: 'Commerce',
                sante: 'Santé',
                medical: 'Santé',
                health: 'Santé',
                education: 'Éducation',
                sport: 'Sport',
                loisirs: 'Loisirs',
                transport: 'Transport',
                automobile: 'Transport',
                auto: 'Transport',
                location_vehicule: 'Transport',
                immobilier: 'Immobilier',
                real_estate: 'Immobilier',
                chalet: 'Chalet',
                commercial: 'Commercial',
                domaine: 'Domaine',
                residence: 'Résidence',
                condo: 'Condo',
                maison: 'Maison',
                terrain: 'Terrain',
                service: 'Service',
                services: 'Service',
                general: 'Autre',
                autre: 'Autre'
            };

            const categoryIconMap = {
                tourisme: { icon: 'fas fa-route', color: '#2a5bd7' },
                culture: { icon: 'fas fa-masks-theater', color: '#805ad5' },
                histoire: { icon: 'fas fa-landmark', color: '#7c3aed' },
                nature: { icon: 'fas fa-tree', color: '#16a34a' },
                aventure: { icon: 'fas fa-person-hiking', color: '#ea580c' },
                shopping: { icon: 'fas fa-bag-shopping', color: '#ca8a04' },
                science: { icon: 'fas fa-flask', color: '#0891b2' },
                plage: { icon: 'fas fa-umbrella-beach', color: '#0ea5e9' },
                famille: { icon: 'fas fa-people-roof', color: '#db2777' },
                restaurant: { icon: 'fas fa-utensils', color: '#e53e3e' },
                hotel: { icon: 'fas fa-bed', color: '#38a169' },
                commerce: { icon: 'fas fa-store', color: '#ca8a04' },
                sante: { icon: 'fas fa-heart-pulse', color: '#dc2626' },
                education: { icon: 'fas fa-graduation-cap', color: '#2563eb' },
                sport: { icon: 'fas fa-dumbbell', color: '#059669' },
                loisirs: { icon: 'fas fa-gamepad', color: '#9333ea' },
                transport: { icon: 'fas fa-car', color: '#ea580c' },
                immobilier: { icon: 'fas fa-building', color: '#475569' },
                chalet: { icon: 'fas fa-house-chimney', color: '#92400e' },
                commercial: { icon: 'fas fa-briefcase', color: '#0f766e' },
                domaine: { icon: 'fas fa-map', color: '#166534' },
                residence: { icon: 'fas fa-house-user', color: '#64748b' },
                condo: { icon: 'fas fa-city', color: '#475569' },
                maison: { icon: 'fas fa-house', color: '#475569' },
                terrain: { icon: 'fas fa-mountain-sun', color: '#65a30d' },
                service: { icon: 'fas fa-handshake', color: '#0f766e' },
                autre: { icon: 'fas fa-map-marker-alt', color: '#f2b705' }
            };

            const resolveCategoryLabel = value => {
                const rawKey = normalize(value);
                const direct = allowedCategories.find(category => normalize(category) === rawKey);
                return direct || categoryAliases[rawKey] || 'Autre';
            };

            const categoryMarkerMeta = category => {
                const label = resolveCategoryLabel(category);
                return categoryIconMap[normalize(label)] || categoryIconMap.autre;
            };

            const galleryHtml = point => {
                const gallery = Array.isArray(point.gallery) ? point.gallery.filter(item => item && item.thumb) : [];
                if (!gallery.length) return '';

                return `
                    <div class="cms-map-video-modal-section">
                        <h4 class="cms-map-video-modal-section-title"><i class="fas fa-images"></i> Galerie</h4>
                        <div class="cms-map-video-modal-gallery">
                            ${gallery.map(item => `
                                <a href="${esc(item.src || item.thumb)}" target="_blank" rel="noopener noreferrer" title="${esc(item.caption || point.title)}">
                                    <img src="${esc(item.thumb)}" alt="${esc(item.caption || point.title)}" loading="lazy">
                                </a>
                            `).join('')}
                        </div>
                    </div>
                `;
            };

            const socialsHtml = point => {
                const socials = Array.isArray(point.socials) ? point.socials.filter(item => item && item.url) : [];
                if (!socials.length) return '';

                return `
                    <div class="cms-map-video-modal-section">
                        <h4 class="cms-map-video-modal-section-title"><i class="fas fa-share-nodes"></i> Réseaux sociaux</h4>
                        <div class="cms-map-video-modal-socials">
                            ${socials.map(item => `
                                <a class="cms-map-video-modal-social" href="${esc(item.url)}" target="_blank" rel="noopener noreferrer" aria-label="${esc(item.label || 'Réseau social')}">
                                    <i class="${esc(item.icon || 'fas fa-link')}"></i>
                                    <span>${esc(item.label || item.key || 'Lien')}</span>
                                </a>
                            `).join('')}
                        </div>
                    </div>
                `;
            };

            const modalHtml = point => {
                const markerMeta = categoryMarkerMeta(point.category_label);
                return `
                    <div class="cms-map-video-modal-media">
                        <iframe src="${esc(point.embed_url)}" title="${esc(point.title)}" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="cms-map-video-modal-body">
                        <div class="cms-map-video-modal-tags">
                            <span class="cms-map-video-modal-tag"><i class="${markerMeta.icon}"></i> ${esc(point.category_label)}</span>
                            <span class="cms-map-video-modal-tag"><i class="fas fa-location-dot"></i> ${esc(point.region || 'Autre region')}</span>
                        </div>
                        <h3 id="${esc(mapKey)}-modal-title">${esc(point.title)}</h3>
                        ${point.description ? `<p>${esc(point.description)}</p>` : '<p>Aucune description disponible.</p>'}
                        ${point.adresse ? `<div class="cms-map-video-modal-address"><i class="fas fa-map-marker-alt"></i> ${esc(point.adresse)}</div>` : ''}
                        ${galleryHtml(point)}
                        ${socialsHtml(point)}
                        ${point.website ? `<a class="cms-map-video-modal-cta" href="${esc(point.website)}" target="_blank" rel="noopener noreferrer"><i class="fas fa-arrow-up-right-from-square"></i> Voir le site</a>` : ''}
                    </div>
                `;
            };

            const closeModal = () => {
                if (!modalNode || !modalContentNode) return;
                modalNode.classList.remove('is-open');
                modalNode.setAttribute('aria-hidden', 'true');
                modalContentNode.innerHTML = '';
                document.body.style.overflow = '';
            };

            const openModal = point => {
                if (!modalNode || !modalContentNode || !point) return;
                modalContentNode.innerHTML = modalHtml(point);
                modalNode.classList.add('is-open');
                modalNode.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            };

            points = points
                .filter(point => Number.isFinite(Number(point.latitude)) && Number.isFinite(Number(point.longitude)) && point.youtube_id)
                .map(point => ({
                    ...point,
                    category_label: resolveCategoryLabel(point.category),
                    category_key: normalize(resolveCategoryLabel(point.category)),
                    region_key: normalize(point.region || 'Autre region'),
                    embed_url: point.embed_url || ('https://www.youtube.com/embed/' + point.youtube_id + '?autoplay=0&rel=0&playsinline=1')
                }));

            if (!points.length) return;

            if (totalNode) totalNode.textContent = points.length;

            window.__cmsLandingVideoMaps = window.__cmsLandingVideoMaps || {};
            if (window.__cmsLandingVideoMaps[mapKey]) {
                window.__cmsLandingVideoMaps[mapKey].remove();
                delete window.__cmsLandingVideoMaps[mapKey];
            }
            if (mapNode._leaflet_id) {
                delete mapNode._leaflet_id;
            }

            const map = L.map(mapNode, { scrollWheelZoom: false, zoomControl: true })
                .setView([Number(points[0].latitude), Number(points[0].longitude)], points.length > 1 ? 10 : 13);
            window.__cmsLandingVideoMaps[mapKey] = map;

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.control.scale().addTo(map);

            const markerLayer = L.layerGroup().addTo(map);
            const markerRefs = new Map();
            let activePlaceId = null;

            const getSelectedCategory = () => {
                const active = categoryBtns.find(btn => btn.classList.contains('active'));
                return active ? active.dataset.filter : 'all';
            };

            const getFilteredPoints = () => {
                const category = getSelectedCategory();
                const region = regionSelect?.value || 'all';

                return points.filter(point => {
                    const categoryMatch = category === 'all' || point.category_key === normalize(category);
                    const regionMatch = region === 'all' || point.region_key === normalize(region);
                    return categoryMatch && regionMatch;
                });
            };

            const popupHtml = point => `
                <div class="cms-map-video-popup">
                    <h4>${esc(point.title)}</h4>
                    <iframe src="${esc(point.embed_url)}" title="${esc(point.title)}" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                    <div class="cms-map-video-popup-meta">
                        <span><i class="fas fa-tag"></i> ${esc(point.category_label)}</span>
                        <span><i class="fas fa-location-dot"></i> ${esc(point.region || '')}</span>
                    </div>
                    <button type="button" class="cms-map-video-details-btn" data-cms-map-details="${esc(point.id)}">
                        <i class="fas fa-info-circle"></i> Voir détail
                    </button>
                </div>
            `;

            const renderList = filteredPoints => {
                if (!listNode) return;

                if (!filteredPoints.length) {
                    listNode.innerHTML = '<div class="cms-map-video-empty"><div><i class="fas fa-map-marker-alt"></i><h4>Aucun lieu trouvé</h4><p>Essayez une autre catégorie ou une autre region.</p></div></div>';
                    return;
                }

                listNode.innerHTML = filteredPoints.map(point => `
                    <article class="cms-map-video-place${activePlaceId === point.id ? ' is-active' : ''}" data-cms-map-place="${esc(point.id)}">
                        <div class="cms-map-video-place-media">
                            <iframe src="${esc(point.embed_url)}" title="${esc(point.title)}" loading="lazy" allow="encrypted-media; picture-in-picture" allowfullscreen></iframe>
                            <span class="cms-map-video-play"><i class="fas fa-play"></i></span>
                        </div>
                        <div class="cms-map-video-place-info">
                            <div class="cms-map-video-place-meta">
                                <span class="cms-map-video-chip"><i class="${categoryMarkerMeta(point.category_label).icon}"></i> ${esc(point.category_label)}</span>
                                <span class="cms-map-video-region"><i class="fas fa-location-dot"></i> ${esc(point.region || 'Autre region')}</span>
                            </div>
                            <h4>${esc(point.title)}</h4>
                            ${point.description ? `<p>${esc(point.description).slice(0, 140)}</p>` : ''}
                            <div class="cms-map-video-place-actions">
                                <button type="button" class="cms-map-video-details-btn" data-cms-map-details="${esc(point.id)}">
                                    <i class="fas fa-eye"></i> Voir détail
                                </button>
                            </div>
                        </div>
                    </article>
                `).join('');

                listNode.querySelectorAll('[data-cms-map-place]').forEach(item => {
                    item.addEventListener('click', () => {
                        const pointId = String(item.dataset.cmsMapPlace);
                        const point = filteredPoints.find(candidate => String(candidate.id) === pointId);
                        const marker = markerRefs.get(pointId);
                        if (!point || !marker) return;

                        activePlaceId = point.id;
                        map.setView([Number(point.latitude), Number(point.longitude)], Math.max(map.getZoom(), 13), { animate: true });
                        marker.openPopup();
                        renderList(filteredPoints);
                    });
                });

                listNode.querySelectorAll('[data-cms-map-details]').forEach(button => {
                    button.addEventListener('click', event => {
                        event.stopPropagation();
                        const point = points.find(candidate => String(candidate.id) === String(button.dataset.cmsMapDetails));
                        openModal(point);
                    });
                });
            };

            const renderMarkers = () => {
                const filteredPoints = getFilteredPoints();
                markerLayer.clearLayers();
                markerRefs.clear();

                const bounds = [];

                filteredPoints.forEach(point => {
                    const lat = Number(point.latitude);
                    const lng = Number(point.longitude);
                    const markerMeta = categoryMarkerMeta(point.category_label);
                    const icon = L.divIcon({
                        className: '',
                        html: `<div class="cms-map-video-marker is-filtered" style="background:${markerMeta.color}"><i class="${markerMeta.icon}"></i></div>`,
                        iconSize: [40, 40],
                        iconAnchor: [20, 40],
                        popupAnchor: [0, -36],
                    });

                    const marker = L.marker([lat, lng], { icon })
                        .addTo(markerLayer)
                        .bindPopup(popupHtml(point), { maxWidth: 340, minWidth: 280 });

                    marker.on('click', () => {
                        activePlaceId = point.id;
                        renderList(filteredPoints);
                    });
                    marker.on('popupopen', event => {
                        const popupNode = event.popup.getElement();
                        popupNode?.querySelectorAll('[data-cms-map-details]').forEach(button => {
                            button.addEventListener('click', clickEvent => {
                                clickEvent.preventDefault();
                                clickEvent.stopPropagation();
                                openModal(point);
                            });
                        });
                    });

                    markerRefs.set(String(point.id), marker);
                    bounds.push([lat, lng]);
                });

                if (countNode) countNode.textContent = filteredPoints.length;
                if (totalNode) totalNode.textContent = filteredPoints.length;
                renderList(filteredPoints);

                if (bounds.length > 1) {
                    map.fitBounds(bounds, { padding: [42, 42] });
                } else if (bounds.length === 1) {
                    map.setView(bounds[0], 13);
                }

                setTimeout(() => map.invalidateSize(), 120);
            };

            categoryBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    categoryBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    activePlaceId = null;
                    renderMarkers();
                });
            });
            regionSelect?.addEventListener('change', () => {
                activePlaceId = null;
                renderMarkers();
            });

            locateButton?.addEventListener('click', () => {
                if (!navigator.geolocation) return;

                locateButton.disabled = true;
                navigator.geolocation.getCurrentPosition(position => {
                    locateButton.disabled = false;
                    map.setView([position.coords.latitude, position.coords.longitude], 12);
                    L.circleMarker([position.coords.latitude, position.coords.longitude], {
                        radius: 9,
                        color: '#fff',
                        weight: 3,
                        fillColor: '#2a5bd7',
                        fillOpacity: 1
                    }).addTo(map).bindPopup('Votre position').openPopup();
                }, () => {
                    locateButton.disabled = false;
                }, { enableHighAccuracy: true, timeout: 10000 });
            });
            modalCloseButton?.addEventListener('click', closeModal);
            modalNode?.addEventListener('click', event => {
                if (event.target === modalNode) closeModal();
            });
            document.addEventListener('keydown', event => {
                if (event.key === 'Escape' && modalNode?.classList.contains('is-open')) {
                    closeModal();
                }
            });

            renderMarkers();
            setTimeout(() => map.invalidateSize(), 250);
        })();
    </script>
@endif
