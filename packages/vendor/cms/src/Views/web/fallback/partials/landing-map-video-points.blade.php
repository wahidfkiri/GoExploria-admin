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

    // Config de la section carte (logo client + position/taille + couleurs), éditée côté admin.
    $landingMapCfg = function_exists('get_maps_section_config') ? get_maps_section_config($etablissement->id) : [];
    $landingMapLogoHtml = function_exists('client_section_logo_html') ? client_section_logo_html($landingMapCfg) : '';
    $landingMapLogoPos = $landingMapCfg['logo_position'] ?? 'left';
    $landingMapSubtitle = trim((string) ($landingMapCfg['subtitle'] ?? '')) !== ''
        ? $landingMapCfg['subtitle']
        : 'Cliquez sur les marqueurs pour en savoir plus';
    $landingMapTitleColor = $landingMapCfg['title_color'] ?? '#000000';
    $landingMapSubtitleColor = $landingMapCfg['subtitle_color'] ?? '#000000';
    // Le titre configuré côté admin (config carte) est prioritaire — corrige le
    // cas où seul le sous-titre s'affichait (titre issu d'une autre clé/vide).
    if (trim((string) ($landingMapCfg['title'] ?? '')) !== '') {
        $landingMapSectionTitle = $landingMapCfg['title'];
    }

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

    $landingMapEstablishmentWebsite = $etablissement->website ?? ($etablissement->site_web ?? null);
    $landingMapPayload = $landingMapPoints->map(function ($point) use ($landingMapMediaUrl, $landingMapFallbackGallery, $landingMapSocialLinks, $landingMapNormalizeSocialUrl, $landingMapEstablishmentWebsite) {
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
            // Provenance de la vidéo : 'youtube' ou 'file'. Sans elle, la
            // page devrait redeviner la source depuis l'adresse.
            'video_type' => method_exists($point, 'estVideoFichier') && $point->estVideoFichier() ? 'file' : 'youtube',
            'gallery' => $pointImages->isNotEmpty() ? $pointImages : $landingMapFallbackGallery,
            'socials' => $pointSocialLinks->isNotEmpty() ? $pointSocialLinks : $landingMapSocialLinks,
            'website' => $landingMapNormalizeSocialUrl($details?->website ?: ($point->has_details_page ? $point->details_url : null) ?: $landingMapEstablishmentWebsite),
        ];
    })->values();

    /* ═══════════════════════════════════════════════════════════════════════
       BIENS IMMOBILIERS SUR LA CARTE DE L'ÉTABLISSEMENT

       Un bien placé côté admin (onglet Immobilier → « Position sur la carte »)
       rejoint ici les points de la carte, dans la MÊME liste : il hérite donc
       du filtre par catégorie, du popup et de la modale de détail existants,
       sans dupliquer une seconde carte.

       Le bien reste la source de vérité : rien n'est recopié dans map_points,
       une modification côté admin se voit immédiatement.

       Seuls les biens VISIBLES et POSITIONNÉS entrent : sans coordonnées, un
       bien n'a pas de place sur une carte.
       ═══════════════════════════════════════════════════════════════════════ */
    try {
        if (isset($etablissement)
            && class_exists(\Vendor\Cms\Models\Property::class)
            && \Illuminate\Support\Facades\Schema::connection('cms')->hasTable('cms_properties')) {

            $landingMapBiens = \Vendor\Cms\Models\Property::forEtablissement($etablissement->id)
                ->visible()
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->orderBy('position')
                ->orderByDesc('id')
                ->limit(200)
                ->get();

            $landingMapBiensPayload = $landingMapBiens->map(function ($bien) use ($landingMapMediaUrl) {
                // Galerie : la couverture d'abord, puis les photos du bien.
                $images = collect([$bien->vignette()])
                    ->merge((array) $bien->gallery)
                    ->filter()
                    ->unique()
                    ->take(12)
                    ->map(fn ($url) => [
                        'src'     => $url,
                        'thumb'   => $url,
                        'caption' => (string) $bien->title,
                    ])
                    ->values();

                $prix = $bien->price > 0
                    ? trim(number_format((float) $bien->price, 0, ',', ' ') . ' ' . ($bien->currency ?: 'USD')
                        . ' ' . (string) $bien->price_label)
                    : null;

                return [
                    'id'          => 'immo-' . $bien->id,
                    'title'       => (string) $bien->title,
                    'description' => (string) $bien->description,
                    // Sa propre catégorie : le filtre de la carte la propose
                    // alors comme n'importe quelle autre.
                    'category'    => 'Immobilier',
                    'region'      => trim((string) ($bien->city ?: $bien->area)) ?: 'Autre region',
                    'latitude'    => (float) $bien->latitude,
                    'longitude'   => (float) $bien->longitude,
                    'adresse'     => trim(collect([$bien->address, $bien->area, $bien->city])->filter()->implode(', ')),
                    // Un bien peut porter une vidéo ; sinon le popup montre sa photo.
                    'youtube_id'  => null,
                    'embed_url'   => $bien->estVideo() ? $bien->urlLectureVideo() : null,
                    'video_type'  => 'youtube',
                    'gallery'     => $images,
                    'socials'     => [],
                    'website'     => null,
                    // Laissez-passer : la carte n'affiche que des points vidéo,
                    // un bien doit pouvoir y figurer sans vidéo.
                    'is_property' => true,
                    'immo'        => [
                        'price'     => $prix,
                        'type'      => $bien->type ?: null,
                        'intent'    => \Vendor\Cms\Models\Property::INTENTS[$bien->intent] ?? null,
                        'surface'   => $bien->surface ? $bien->surface . ' m²' : null,
                        'bedrooms'  => $bien->bedrooms !== null ? (int) $bien->bedrooms : null,
                        'bathrooms' => $bien->bathrooms !== null ? (int) $bien->bathrooms : null,
                        'reference' => $bien->reference ?: null,
                        'cover'     => $bien->vignette(),
                    ],
                ];
            });

            if ($landingMapBiensPayload->isNotEmpty()) {
                $landingMapPayload = $landingMapPayload->concat($landingMapBiensPayload)->values();
            }
        }
    } catch (\Throwable $e) {
        // Les biens sont un complément : leur indisponibilité ne doit jamais
        // empêcher la carte de s'afficher.
        report($e);
    }

    $landingMapRegions = $landingMapPayload
        ->pluck('region')
        ->filter()
        ->unique()
        ->sort()
        ->values();
@endphp

{{-- On teste le PAYLOAD, pas les seuls points vidéo : depuis que les biens
     immobiliers rejoignent la carte, un établissement peut n'avoir aucun point
     vidéo et pourtant des biens à situer. Le payload est l'union des deux. --}}
@if($landingMapPayload->isNotEmpty())
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
            .section-title{font-family:'Italiana',serif;color:black;font-size:clamp(28px,4vw,46px);line-height:1.05;font-weight:900}
            .section-subtitle{margin-top:12px;font-size:1rem;color:black}
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
            .map-popup__price{font-size:0.95rem;font-weight:700;color:var(--td-amber);margin-bottom:6px}
            .map-popup__detail-btn{display:block;width:100%;padding:10px 16px;background:var(--td-amber);color:#000;border-radius:var(--td-radius-sm);font-size:0.82rem;font-weight:600;text-align:center;transition:all var(--td-transition);cursor:pointer;border:0}
            .map-popup__detail-btn:hover{background:var(--td-amber-dark)}
            .map-popup__video{height:160px;overflow:hidden;background:#000}
            .map-popup__video .gxmap-swiper{width:100%;height:100%}
            /* Dans les DEUX boîtes média (popup et modale), le conteneur est
               étiré par positionnement absolu : la hauteur doit être propagée
               jusqu'aux diapositives, sinon Swiper les calcule à 0 et rien ne
               s'affiche alors même que les images sont chargées. */
            .map-popup__video .gxmap-swiper .swiper,.map-popup__video .gxmap-swiper .swiper-wrapper,
            .map-popup__video .gxmap-swiper .swiper-slide,
            .map-modal__video .gxmap-swiper .swiper,.map-modal__video .gxmap-swiper .swiper-wrapper,
            .map-modal__video .gxmap-swiper .swiper-slide{height:100%}
            .map-popup__video iframe,.map-popup__video video{width:100%;height:100%;border:0;object-fit:cover;background:#000}
            .map-region-filter{text-align:center;margin-bottom:16px}
            .map-region-select{padding:10px 20px;border:1px solid var(--td-border);border-radius:50px;font-size:0.85rem;font-weight:600;color:var(--td-sand);background:var(--td-glass-bg);cursor:pointer;min-width:220px;max-width:100%;outline:none;transition:border-color var(--td-transition);appearance:auto}
            .map-region-select:hover,.map-region-select:focus{border-color:var(--td-amber)}
            .map-filters{display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin-bottom:24px}
            .map-filter-btn{padding:8px 20px;border:1px solid var(--td-border);border-radius:50px;font-size:0.82rem;font-weight:600;color:var(--td-text-muted);transition:all var(--td-transition);cursor:pointer;background:transparent;display:inline-flex;align-items:center;gap:6px}
            .map-filter-btn:hover{border-color:var(--td-amber);color:var(--td-amber)}
            .map-filter-btn.active{background:var(--td-amber);color:#000;border-color:var(--td-amber)}
            .map-filter-btn__icon{display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;font-size:1rem;flex-shrink:0}
            .map-filter-btn__label{white-space:nowrap}
            /* Au-dessus de toute la charte globale : header (10060) et
               méga-menus (jusqu'à 9999999). Le modal est déplacé sous <body>
               à l'ouverture, ce z-index se compare donc bien à eux. */
            .map-modal{display:none;position:fixed;inset:0;z-index:10000000;background:rgba(0,0,0,0.8);overflow-y:auto}
            .map-modal__backdrop{position:fixed;inset:0;z-index:-1}
            .map-modal__content{position:relative;width:min(1140px,96vw);max-height:92vh;background:var(--td-card-bg);border-radius:var(--td-radius-md);overflow-y:auto;margin:40px auto;animation:modalSlideIn .3s ease}
            .map-modal__socials{display:none;flex-wrap:wrap;gap:10px;margin:14px 0 4px}
            .map-modal__social{width:40px;height:40px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:var(--td-glass-bg,rgba(255,255,255,.08));border:1px solid var(--td-glass-border,rgba(255,255,255,.15));color:var(--td-sand,#e9dcc3);font-size:16px;text-decoration:none;transition:all .2s ease}
            .map-modal__social:hover{transform:translateY(-2px);background:var(--td-amber,#d4af37);color:#0a1628}
            @keyframes modalSlideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
            /* ⚠ Swiper pose lui-même `z-index:1` sur `.swiper` : à valeur égale
               c'est l'ordre du DOM qui tranche, et le média vient APRÈS ce
               bouton — il le recouvrait. D'où un cran plus haut, et un fond
               assez opaque pour rester lisible sur n'importe quelle photo. */
            .map-modal__close{position:absolute;top:16px;right:16px;z-index:6;width:40px;height:40px;display:flex;align-items:center;justify-content:center;font-size:1.6rem;line-height:1;color:#fff;background:rgba(0,0,0,0.55);backdrop-filter:blur(2px);border-radius:50%;transition:all var(--td-transition);cursor:pointer;border:0;box-shadow:0 2px 10px rgba(0,0,0,.35)}
            .map-modal__close:hover{color:#000;background:var(--td-amber,#d4af37)}
            .map-modal__body{padding:0 32px 32px}
            .map-modal__video{width:100%;height:0;padding-bottom:56.25%;position:relative;background:#000;border-radius:var(--td-radius-sm) var(--td-radius-sm) 0 0;overflow:hidden}
            .map-modal__video iframe,.map-modal__video video,
            .map-modal__video img,.map-modal__video .gxmap-swiper{position:absolute;inset:0;width:100%;height:100%;border:0;object-fit:contain;background:#000}
            .map-modal__video:empty{display:none}
            .map-modal__gallery{display:flex;gap:8px;overflow-x:auto;margin-bottom:24px;padding-bottom:8px}
            .map-modal__gallery img{width:160px;height:100px;object-fit:cover;border-radius:var(--td-radius-sm);flex-shrink:0}
            /* Carrousel : le conteneur reprend la main sur le repli en défilement. */
            .map-modal__gallery:has(.gxmap-swiper){display:block;overflow:visible;padding-bottom:0}
            .map-modal__gallery .gxmap-swiper{width:100%;border-radius:var(--td-radius-sm);overflow:hidden}
            /* Quatre vignettes de front : la diapositive n'occupe plus toute
               la largeur, elle est donc bien plus basse qu'en vue unique. */
            .map-modal__gallery .gxmap-swiper{overflow:visible}
            .map-modal__gallery .gxmap-swiper .swiper{overflow:hidden;border-radius:var(--td-radius-sm)}
            .map-modal__gallery .gxmap-swiper .swiper-slide{height:170px;border-radius:var(--td-radius-sm);overflow:hidden}
            .map-modal__gallery .gxmap-swiper img{width:100%;height:100%;object-fit:cover;border-radius:0;flex-shrink:1}

            /* Carrousel commun popup + modale */
            .gxmap-swiper{position:relative;background:#000}
            .gxmap-swiper .swiper-slide{display:flex;align-items:center;justify-content:center;background:#000}
            .gxmap-swiper .swiper-slide img{width:100%;height:100%;object-fit:cover;display:block}
            .gxmap-swiper .swiper-button-prev,.gxmap-swiper .swiper-button-next{width:30px;height:30px;border-radius:50%;background:rgba(0,0,0,.45);color:var(--td-sand,#e9dcc3);transition:background .2s ease}
            .gxmap-swiper .swiper-button-prev:after,.gxmap-swiper .swiper-button-next:after{font-size:12px;font-weight:800}
            .gxmap-swiper .swiper-button-prev:hover,.gxmap-swiper .swiper-button-next:hover{background:var(--td-amber,#d4af37);color:#000}
            .gxmap-swiper .swiper-pagination-bullet{background:var(--td-sand,#e9dcc3);opacity:.55}
            .gxmap-swiper .swiper-pagination-bullet-active{background:var(--td-amber,#d4af37);opacity:1}
            /* Compteur : utile dès que la galerie dépasse quelques photos. */
            .gxmap-swiper__compte{position:absolute;right:8px;top:8px;z-index:2;padding:2px 8px;border-radius:999px;background:rgba(0,0,0,.55);color:#fff;font-size:11px;font-weight:700;letter-spacing:.02em}
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
                @if($landingMapLogoHtml !== '' && $landingMapLogoPos === 'center')
                    <div class="section-logo section-logo--center" style="margin-bottom:14px;">{!! $landingMapLogoHtml !!}</div>
                @endif
                <div class="section-head-row section-head-row--{{ $landingMapLogoPos }}"
                     @if($landingMapLogoHtml !== '' && $landingMapLogoPos !== 'center') style="display:flex;align-items:center;gap:18px;justify-content:{{ $landingMapLogoPos === 'right' ? 'flex-end' : 'flex-start' }};text-align:{{ $landingMapLogoPos === 'right' ? 'right' : 'left' }};" @endif>
                    @if($landingMapLogoHtml !== '' && $landingMapLogoPos === 'left')
                        <div class="section-logo">{!! $landingMapLogoHtml !!}</div>
                    @endif
                    <div>
                        <h2 class="section-title" id="map-heading" style="color:{{ $landingMapTitleColor }};">{{ $landingMapSectionTitle }}</h2>
                        <p class="section-subtitle" style="color:{{ $landingMapSubtitleColor }};">{{ $landingMapSubtitle }}</p>
                    </div>
                    @if($landingMapLogoHtml !== '' && $landingMapLogoPos === 'right')
                        <div class="section-logo">{!! $landingMapLogoHtml !!}</div>
                    @endif
                </div>
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
                    <div class="map-modal__socials" id="mapModalSocials"></div>
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
    @once
        @if(config('services.google.maps.key'))
        {{-- Bascule Google Maps (rues/satellite + Street View). Sans clé → Leaflet. --}}
        <script>
            window.GX_MAPS = window.GX_MAPS || { key: @json(config('services.google.maps.key')), mapId: @json(config('services.google.maps.map_id') ?: '') };
        </script>
        <script src="{{ asset('js/geo-map/gx-google-map.js') }}?v={{ @filemtime(public_path('js/geo-map/gx-google-map.js')) ?: '4' }}"></script>
        <style>
            .gm-style .map-popup { width: 280px; max-width: 78vw; }
            .gm-style .map-popup__video { height: 160px; background: #000; }
            .gm-style .map-popup__video iframe,
            .gm-style .map-popup__video video { width: 100%; height: 100%; border: 0; display: block; object-fit: cover; background: #000; }
            .gm-style .map-popup__body { padding: 12px 14px; }
            .gm-style .map-popup__title { font-size: 0.95rem; font-weight: 700; margin: 0 0 6px; color: #111827; }
            .gm-style .map-popup__desc { font-size: 0.8rem; color: #4b5563; line-height: 1.5; margin: 0 0 10px; }
            .gm-style .map-popup__detail-btn { display: block; width: 100%; padding: 9px 14px; background: #F5A623; color: #000; border: 0; border-radius: 8px; font-size: 0.82rem; font-weight: 700; cursor: pointer; }
        </style>
        @endif
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
            var estFichier = p.video_type === 'file';
            // La carte est celle des points VIDÉO : un point sans vidéo n'a
            // rien à y montrer. Un bien immobilier fait exception — c'est sa
            // photo et sa fiche qui font le contenu.
            if (!p.youtube_id && !p.embed_url && !p.is_property) return;
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
                youtube_id: estFichier ? '' : (p.youtube_id || ''),
                video_type: estFichier ? 'file' : 'youtube',
                embed_url: estFichier
                    ? (p.embed_url || '')
                    : (p.embed_url || (p.youtube_id ? 'https://www.youtube.com/embed/' + p.youtube_id + '?autoplay=0&rel=0&playsinline=1' : '')),
                gallery: Array.isArray(p.gallery) ? p.gallery : [],
                socials: Array.isArray(p.socials) ? p.socials : [],
                website: p.website || '',
                is_property: !!p.is_property,
                immo: p.immo || null
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

        // ── Backend Google Maps (rues/satellite + Street View natif) ─────
        // Réutilise getCategoryStyle / buildPopupHtml / showPlaceModal /
        // closePlaceModal (hoistées) → MÊME logique de marqueurs + popup vidéo
        // + modale. Sans Map ID, marqueurs HTML via OverlayView (icône + couleur
        // de la catégorie). Le filtre catégorie/région reste à câbler (Leaflet).
        /* ------------------------------------------------------------------
           CARROUSELS

           Les deux moteurs de carte n'offrent pas le même crochet : Leaflet
           émet « popupopen », Google insère son InfoWindow sans prévenir. On
           n'initialise donc pas au moment de l'ouverture : un observateur
           réveille tout carrousel dès qu'il entre dans le document, quel que
           soit celui qui l'a posé.

           ⚠ CE BLOC DOIT RESTER AVANT LA BRANCHE GOOGLE MAPS.
           Celle-ci se termine par un `return` : tout ce qui suit n'est
           jamais EXÉCUTÉ quand une clé Google est configurée — donc en
           production. Les `function` sont hissées et survivent, mais pas
           `var swipersVivants = []` (resté undefined → la modale plantait)
           ni l'enregistrement de l'observateur (→ carrousels morts).
        ------------------------------------------------------------------ */
        function imagesDe(p) {
            return (p.gallery || [])
                .map(function (img) { return (img && (img.src || img.thumb)) || ''; })
                .filter(Boolean);
        }

        /* Un carrousel n'a de sens qu'à partir de deux images : au-dessous on
           renvoie une simple photo, qui se charge plus vite et ne montre ni
           flèches ni puces inutiles. */
        function galerieHtml(p, options) {
            options = options || {};
            var images = imagesDe(p);
            if (!images.length) { return ''; }

            var alt = escapeAttr(p.title || '');

            /* ⚠ PAS de loading="lazy" ici : popup et modale ne sont construits
               QU'À l'ouverture, et leur conteneur vient d'être révélé. Le
               chargement paresseux n'y gagne rien et laisse la vue blanche —
               le navigateur ne juge jamais ces images « visibles ». */
            if (images.length === 1) {
                return '<img src="' + escapeAttr(images[0]) + '" alt="' + alt + '">';
            }

            var slides = images.map(function (src) {
                return '<div class="swiper-slide"><img src="' + escapeAttr(src) + '" alt="' + alt + '"></div>';
            }).join('');

            // La variante voyage sur l'attribut : `initSwipers` est générique et
            // ne connaît pas l'appelant, c'est le balisage qui la renseigne.
            var variante = options.variante === 'galerie' ? 'galerie' : 'media';

            return '<div class="gxmap-swiper" data-gxmap-swiper="' + variante + '">'
                 + '<span class="gxmap-swiper__compte">' + images.length + ' photos</span>'
                 + '<div class="swiper"><div class="swiper-wrapper">' + slides + '</div>'
                 + (options.puces === false ? '' : '<div class="swiper-pagination"></div>')
                 + '<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>'
                 + '</div></div>';
        }

        var swipersVivants = [];

        function detruireSwipers() {
            swipersVivants.forEach(function (s) {
                try { s.destroy(true, true); } catch (e) {}
            });
            swipersVivants = [];
        }

        function initSwipers(racine) {
            if (typeof Swiper === 'undefined') { return; }   // page sans Swiper : le repli suffit

            (racine || document).querySelectorAll('[data-gxmap-swiper]').forEach(function (bloc) {
                if (bloc.__gxPret) { return; }
                var piste = bloc.querySelector('.swiper');
                if (!piste) { return; }
                bloc.__gxPret = true;

                var nb = bloc.querySelectorAll('.swiper-slide').length;
                var estGalerie = bloc.getAttribute('data-gxmap-swiper') === 'galerie';

                var reglages = {
                    pagination: { el: bloc.querySelector('.swiper-pagination'), clickable: true },
                    navigation: {
                        prevEl: bloc.querySelector('.swiper-button-prev'),
                        nextEl: bloc.querySelector('.swiper-button-next')
                    },
                    keyboard: { enabled: true }
                };

                if (estGalerie) {
                    // Quatre vignettes de front sur grand écran, moins à mesure
                    // que la place manque.
                    reglages.slidesPerView = 2;
                    reglages.spaceBetween = 8;
                    reglages.breakpoints = {
                        480:  { slidesPerView: 2, spaceBetween: 8 },
                        768:  { slidesPerView: 3, spaceBetween: 8 },
                        1024: { slidesPerView: 4, spaceBetween: 10 }
                    };
                    // Pas de boucle : Swiper exige au moins deux fois plus de
                    // diapositives que de vues simultanées, ce qu'une galerie de
                    // 5 photos n'atteint pas — elle sauterait à l'affichage.
                    reglages.loop = false;
                    reglages.slidesPerGroup = 1;
                } else {
                    reglages.slidesPerView = 1;
                    reglages.spaceBetween = 0;
                    reglages.loop = nb > 2;
                }

                swipersVivants.push(new Swiper(piste, reglages));
            });
        }

        // Popups Leaflet ET InfoWindows Google passent par le document : un seul
        // observateur suffit à les couvrir tous les deux.
        if (typeof MutationObserver !== 'undefined') {
            new MutationObserver(function () { initSwipers(document); })
                .observe(document.body, { childList: true, subtree: true });
        }

        if (window.GX_MAPS && window.GX_MAPS.key && window.GxGoogleMap) {
            var gLat0 = (Math.min.apply(null, lats) + Math.max.apply(null, lats)) / 2;
            var gLng0 = (Math.min.apply(null, lngs) + Math.max.apply(null, lngs)) / 2;
            window.GxGoogleMap.load(window.GX_MAPS.key, { mapId: window.GX_MAPS.mapId })
                .then(function () {
                    var eng = window.GxGoogleMap.create(mapEl, {
                        center: { lat: gLat0, lng: gLng0 }, zoom: 8,
                        mapId: window.GX_MAPS.mapId || undefined, streetView: true, cluster: true
                    });
                    var gPoints = points.slice();
                    points.forEach(function (p, idx) {
                        var s = getCategoryStyle(p.category);
                        eng.addMarker(p, {
                            position: { lat: Number(p.latitude), lng: Number(p.longitude) },
                            icon: { color: s.color, iconClass: s.icon },
                            popupHtml: buildPopupHtml(p, idx),
                            featured: !!p.is_featured
                        });
                    });
                    eng.fitToMarkers(40);

                    // Bouton « Voir détails » (délégation, robuste InfoWindow).
                    document.addEventListener('click', function (e) {
                        var b = e.target.closest && e.target.closest('.map-popup__detail-btn');
                        if (!b) return;
                        var pt = gPoints[parseInt(b.getAttribute('data-index'), 10)];
                        if (pt) showPlaceModal(pt);
                    });
                    // Fermeture du modal (handlers d'origine après le return).
                    var mClose = document.getElementById('mapModalClose');
                    var mBackdrop = document.getElementById('mapModalBackdrop');
                    if (mClose) mClose.addEventListener('click', closePlaceModal);
                    if (mBackdrop) mBackdrop.addEventListener('click', closePlaceModal);
                    document.addEventListener('keydown', function (e) {
                        if (e.key !== 'Escape') return;
                        var m = document.getElementById('mapDetailModal');
                        if (m && m.style.display !== 'none') closePlaceModal();
                    });
                })
                .catch(function (e) { console.warn('Google Maps indisponible :', e); });
            return;
        }

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
        // Décode les entités (descriptions parfois double-encodées : &lt;p&gt;…)
        function decodeHtml(str) { if (!str) return ''; var t = document.createElement('textarea'); t.innerHTML = str; return t.value; }
        // Texte brut sans balises (pour les aperçus / popups)
        function plainText(str) { if (!str) return ''; var d = document.createElement('div'); d.innerHTML = decodeHtml(str); return (d.textContent || d.innerText || '').replace(/\s+/g, ' ').trim(); }

        function getFilteredPoints() {
            return allPoints.filter(function (p) {
                var catMatch = activeCategory === 'all' || (p.category || 'Autre') === activeCategory;
                var regionMatch = activeRegion === 'all' || (p.region || 'Autre region') === activeRegion;
                return catMatch && regionMatch;
            });
        }

        /* Un point vidéo vient soit de YouTube, soit d'un fichier servi en
           direct. Les deux passent par ce lecteur unique : sans lui, chaque
           endroit qui affiche une vidéo devrait connaître les deux cas. */
        function buildVideoPlayer(p, autoplay) {
            if (!p) return '';

            if (p.video_type === 'file') {
                if (!p.embed_url) return '';
                // playsinline : sans lui, iOS ouvre la vidéo en plein écran
                // et quitte la carte.
                return '<video src="' + escapeAttr(p.embed_url) + '" controls preload="metadata" '
                     + 'playsinline' + (autoplay ? ' autoplay muted' : '')
                     + ' style="width:100%;height:100%;object-fit:cover;background:#000;border:0"></video>';
            }

            var eu = p.embed_url || (p.youtube_id
                ? 'https://www.youtube.com/embed/' + p.youtube_id + (autoplay ? '?autoplay=1' : '?autoplay=0&rel=0')
                : '');
            if (!eu) return '';

            return '<iframe src="' + escapeAttr(eu) + '" frameborder="0" allowfullscreen></iframe>';
        }

        function escapeAttr(v) {
            return String(v == null ? '' : v)
                .replace(/&/g, '&amp;').replace(/"/g, '&quot;')
                .replace(/</g, '&lt;').replace(/>/g, '&gt;');
        }


        /* Média de tête : la vidéo du point, sinon ses photos. Un bien sans
           vidéo montre ainsi toute sa galerie au lieu de sa seule couverture. */
        function buildMediaHtml(p, autoplay) {
            var lecteur = buildVideoPlayer(p, autoplay);
            if (lecteur) return lecteur;

            var galerie = galerieHtml(p, { puces: true });
            if (galerie) { return galerie; }

            if (p.is_property && p.immo && p.immo.cover) {
                return '<img src="' + escapeAttr(p.immo.cover) + '" alt="' + escapeAttr(p.title || '') + '">';
            }
            return '';
        }

        /* Chiffres cles d'un bien, repris a l'identique dans le popup et la
           modale pour que les deux racontent la meme chose. */
        function immoFacts(p) {
            if (!p.is_property || !p.immo) return [];
            var i = p.immo;
            return [
                i.intent, i.type, i.surface,
                i.bedrooms ? i.bedrooms + ' ch.' : null,
                i.bathrooms ? i.bathrooms + ' sdb' : null
            ].filter(Boolean);
        }

        function buildPopupHtml(p, idx) {
            var media = buildMediaHtml(p, true);
            var h = '<div class="map-popup">';
            if (media) h += '<div class="map-popup__video">' + media + '</div>';
            h += '<div class="map-popup__body"><h4 class="map-popup__title">' + escapeHtml(p.title) + '</h4>';

            if (p.is_property && p.immo) {
                if (p.immo.price) h += '<p class="map-popup__price">' + escapeHtml(p.immo.price) + '</p>';
                var facts = immoFacts(p);
                if (facts.length) h += '<p class="map-popup__desc">' + escapeHtml(facts.join(' \u00b7 ')) + '</p>';
            } else if (p.description) {
                var _pd = plainText(p.description);
                if (_pd) h += '<p class="map-popup__desc">' + escapeHtml(_pd.substring(0, 120)) + (_pd.length > 120 ? '\u2026' : '') + '</p>';
            }

            h += '<button class="map-popup__detail-btn" data-index="' + idx + '">Voir d\u00e9tails</button></div></div>';
            return h;
        }

        function getMarkerIcon(cat, featured) {
            var s = getCategoryStyle(cat);
            // Points « Mis en avant » : plus grands, anneau doré + étoile
            var size = featured ? 40 : 32;
            var ring = featured ? 'box-shadow:0 0 0 4px rgba(255,193,7,0.45),0 3px 12px rgba(0,0,0,0.5);border:3px solid #FFC107' : 'box-shadow:0 2px 8px rgba(0,0,0,0.4);border:2px solid #fff';
            var star = featured ? '<span style="position:absolute;top:-7px;right:-7px;width:18px;height:18px;border-radius:50%;background:#FFC107;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(0,0,0,0.4);z-index:2"><i class="fas fa-star" style="font-size:9px;color:#fff"></i></span>' : '';
            return L.divIcon({
                className: 'map-marker',
                html: '<div style="position:relative;width:' + size + 'px;height:' + size + 'px;border-radius:50%;background:' + s.color + ';display:flex;align-items:center;justify-content:center;' + ring + '">' + star + '<i class="' + s.icon + '" style="font-size:' + Math.round(size * 0.44) + 'px;color:#fff"></i></div>',
                iconSize: [size + 4, size + 4], iconAnchor: [(size + 4) / 2, size + 4]
            });
        }

        function renderFilteredPoints() {
            var data = getFilteredPoints();
            markersLayer.clearLayers();
            pointsData = [];
            var bounds = [];
            data.forEach(function (p, idx) {
                pointsData.push(p);
                var m = L.marker([p.latitude, p.longitude], { icon: getMarkerIcon(p.category, p.is_featured), zIndexOffset: p.is_featured ? 1000 : 0 }).addTo(markersLayer).bindPopup(buildPopupHtml(p, idx), { maxWidth: 320, className: 'map-popup-wrapper' });
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
            initSwipers(c);
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

            /* ------------------------------------------------------------------
               LE MODAL DOIT VIVRE À LA RACINE DU DOCUMENT

               Les sections du site sont animées : un ancêtre porte un
               `transform`, ce qui a DEUX conséquences pour un enfant en
               `position:fixed` —
                 • il crée un contexte d'empilement, donc le z-index du modal
                   (99999) ne se compare plus au header global (10060) mais
                   reste prisonnier de la section ;
                 • le `fixed` se cale sur cet ancêtre au lieu de la fenêtre,
                   et le contenu remonte sous le header (mesuré à -10 px).

               Le déplacer une fois sous <body> règle les deux d'un coup, sans
               dépendre du z-index de la charte globale.
            ------------------------------------------------------------------ */
            if (modal.parentElement !== document.body) {
                document.body.appendChild(modal);
            }

            // Les carrousels de la fiche précédente partent AVANT toute
            // reconstruction : les détruire en cours de route emporterait ceux
            // qu'on vient de créer (le média principal, posé juste après).
            detruireSwipers();

            document.getElementById('map-modal-title').textContent = point.title || 'D\u00e9tails';
            var ve = document.getElementById('mapModalVideo');
            if (ve) { ve.innerHTML = buildMediaHtml(point, false); }
            var de = modal.querySelector('.map-modal__description');
            // Rendu HTML décodé (jamais de balises visibles type "<p>…</p>")
            de.innerHTML = decodeHtml(point.description || '');
            var mh = '';
            // Un bien met en avant son prix et ses caracteristiques ; le
            // reste (categorie, adresse, region) suit comme tout point.
            if (point.is_property && point.immo) {
                if (point.immo.price) mh += '<span class="map-modal__tag">' + escapeHtml(point.immo.price) + '</span>';
                immoFacts(point).forEach(function (f) {
                    mh += '<span class="map-modal__meta-item">' + escapeHtml(f) + '</span>';
                });
                if (point.immo.reference) mh += '<span class="map-modal__meta-item">R\u00e9f. ' + escapeHtml(point.immo.reference) + '</span>';
            }
            if (point.category) mh += '<span class="map-modal__tag">' + escapeHtml(point.category) + '</span>';
            if (point.adresse) mh += '<span class="map-modal__tag">' + escapeHtml(point.adresse) + '</span>';
            if (point.region) mh += '<span class="map-modal__meta-item">&#9906; ' + escapeHtml(point.region) + '</span>';
            mc.innerHTML = mh;
            var ge = document.getElementById('mapModalGallery');
            ge.innerHTML = galerieHtml(point, { puces: true, variante: 'galerie' });
            // Réseaux sociaux (affichés seulement s'ils existent)
            var se = document.getElementById('mapModalSocials');
            if (se) {
                se.innerHTML = '';
                if (point.socials && point.socials.length) {
                    point.socials.forEach(function (s) {
                        if (!s || !s.url) return;
                        var a = document.createElement('a');
                        a.href = s.url; a.target = '_blank'; a.rel = 'noopener';
                        a.className = 'map-modal__social';
                        a.title = s.label || '';
                        a.setAttribute('aria-label', s.label || 'Lien');
                        a.innerHTML = '<i class="' + (s.icon || 'fas fa-link') + '"></i>';
                        se.appendChild(a);
                    });
                    se.style.display = se.children.length ? 'flex' : 'none';
                } else {
                    se.style.display = 'none';
                }
            }
            var wl = document.getElementById('mapModalWebsite');
            if (point.website) { wl.href = point.website; wl.style.display = 'inline-flex'; } else { wl.style.display = 'none'; }
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';

            // ⚠ APRÈS l'affichage seulement : initialisé pendant que la modale
            // est encore masquée, Swiper mesure 0 et n'applique jamais ses
            // classes d'état ni ses positions — les photos restent figées.
            initSwipers(modal);
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
