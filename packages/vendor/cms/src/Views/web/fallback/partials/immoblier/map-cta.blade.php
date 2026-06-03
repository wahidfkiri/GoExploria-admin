<section class="pc-map-cta" id="carte">
    @if(is_maps_enabled($etablissement->id) && get_map_video_points($etablissement->id)->isNotEmpty())
        <div class="pc-map-wrap">
            @include('cms::web.fallback.partials.landing-map-video-points', ['landingMapVariant' => 'inline'])
        </div>
    @endif
</section>
