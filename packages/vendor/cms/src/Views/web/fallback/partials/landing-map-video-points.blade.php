@php
    $landingMapPoints = is_maps_enabled($etablissement->id)
        ? get_map_video_points($etablissement->id)
        : collect();

    $landingMapId = 'landingVideoMap' . substr(md5((string) ($etablissement->id ?? 'global')), 0, 8);
    $landingMapVariant = $landingMapVariant ?? 'section';
    $landingMapIsInline = $landingMapVariant === 'inline';

    $landingMapPayload = $landingMapPoints->map(function ($point) {
        return [
            'id' => $point->id,
            'title' => $point->title ?: ($point->video_title ?? 'Point video'),
            'description' => $point->description,
            'category' => $point->category,
            'latitude' => (float) $point->latitude,
            'longitude' => (float) $point->longitude,
            'adresse' => trim(collect([$point->adresse, $point->ville, $point->code_postal])->filter()->implode(', ')),
            'youtube_id' => $point->youtube_id,
            'thumbnail' => $point->thumbnail,
            'embed_url' => $point->embed_url,
        ];
    })->values();
@endphp

@if($landingMapPoints->isNotEmpty())
    @once
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
        <style>
            .cms-map-video-section{padding:64px 24px;background:var(--bg,var(--dark,#0b1220));color:var(--text,#fff)}
            .cms-map-video-inner{max-width:1240px;margin:0 auto}
            .cms-map-video-section.is-inline{padding:0;background:transparent;color:inherit;height:100%;min-height:420px}
            .cms-map-video-section.is-inline .cms-map-video-inner{height:100%;max-width:none}
            .cms-map-video-section.is-inline .cms-map-video-head{display:none}
            .cms-map-video-section.is-inline .cms-map-video-canvas{height:100%;min-height:420px;border-radius:inherit}
            .cms-map-video-head{display:flex;justify-content:space-between;align-items:end;gap:24px;margin-bottom:22px}
            .cms-map-video-kicker{margin:0 0 8px;color:var(--gold,#d4af37);font-size:12px;font-weight:800;letter-spacing:.18em;text-transform:uppercase}
            .cms-map-video-title{margin:0;font-size:clamp(28px,4vw,46px);line-height:1.05}
            .cms-map-video-count{color:var(--muted,rgba(255,255,255,.65));font-weight:700}
            .cms-map-video-canvas{height:520px;width:100%;border-radius:18px;overflow:hidden;border:1px solid rgba(255,255,255,.12);background:#111;box-shadow:0 24px 60px rgba(0,0,0,.22)}
            .cms-map-video-popup{width:310px;max-width:100%}
            .cms-map-video-popup img{width:100%;height:142px;object-fit:cover;border-radius:12px;margin-bottom:10px;background:#111}
            .cms-map-video-popup h4{margin:0 0 6px;color:#111;font-size:16px;line-height:1.25}
            .cms-map-video-popup p{margin:0 0 10px;color:#555;font-size:13px;line-height:1.5}
            .cms-map-video-popup iframe{width:100%;height:174px;border:0;border-radius:12px;background:#000}
            .cms-map-video-marker{width:38px;height:38px;border-radius:50%;display:grid;place-items:center;background:#f2b705;color:#121212;border:3px solid #fff;box-shadow:0 10px 28px rgba(0,0,0,.35)}
            @media(max-width:720px){.cms-map-video-section{padding:46px 16px}.cms-map-video-head{display:block}.cms-map-video-canvas{height:430px}}
        </style>
    @endonce

    <section class="cms-map-video-section{{ $landingMapIsInline ? ' is-inline' : '' }}" id="map">
        <div class="cms-map-video-inner">
            <div class="cms-map-video-head">
                <div>
                    <p class="cms-map-video-kicker">Carte interactive</p>
                    <h2 class="cms-map-video-title">{{ $siteName ?? $etablissement->name }} sur la carte</h2>
                </div>
                <div class="cms-map-video-count">{{ $landingMapPoints->count() }} point{{ $landingMapPoints->count() > 1 ? 's' : '' }} video</div>
            </div>
            <div id="{{ $landingMapId }}" class="cms-map-video-canvas"></div>
        </div>
    </section>

    @once
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    @endonce
    <script>
        (function () {
            const mapNode = document.getElementById(@json($landingMapId));
            if (!mapNode || !window.L) return;

            let points = @json($landingMapPayload);

            points = points.filter(point => Number.isFinite(Number(point.latitude)) && Number.isFinite(Number(point.longitude)) && point.youtube_id);
            if (!points.length) return;

            const map = L.map(mapNode, { scrollWheelZoom: false, zoomControl: true })
                .setView([Number(points[0].latitude), Number(points[0].longitude)], points.length > 1 ? 10 : 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const bounds = [];
            const esc = value => String(value || '').replace(/[&<>"']/g, char => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[char]);

            points.forEach(point => {
                const lat = Number(point.latitude);
                const lng = Number(point.longitude);
                const icon = L.divIcon({
                    className: '',
                    html: '<div class="cms-map-video-marker"><i class="fa-solid fa-play"></i></div>',
                    iconSize: [38, 38],
                    iconAnchor: [19, 38],
                    popupAnchor: [0, -34],
                });
                const embed = point.embed_url || ('https://www.youtube.com/embed/' + point.youtube_id + '?autoplay=0&rel=0&playsinline=1');
                const popup = `
                    <div class="cms-map-video-popup">
                        ${point.thumbnail ? `<img src="${esc(point.thumbnail)}" alt="${esc(point.title)}" loading="lazy">` : ''}
                        <h4>${esc(point.title)}</h4>
                        ${point.adresse ? `<p>${esc(point.adresse)}</p>` : ''}
                        ${point.description ? `<p>${esc(point.description)}</p>` : ''}
                        <iframe src="${esc(embed)}" title="${esc(point.title)}" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                    </div>
                `;

                L.marker([lat, lng], { icon }).addTo(map).bindPopup(popup, { maxWidth: 340, minWidth: 280 });
                bounds.push([lat, lng]);
            });

            if (bounds.length > 1) {
                map.fitBounds(bounds, { padding: [40, 40] });
            }

            setTimeout(() => map.invalidateSize(), 250);
        })();
    </script>
@endif
