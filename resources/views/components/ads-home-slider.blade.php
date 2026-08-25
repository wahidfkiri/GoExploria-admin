{{-- ═══════════════════════════════════════════════════════════════════════
     Annonces intercalées dans le carrousel de la page d'accueil (Ads Manager).

     Rendu CÔTÉ SERVEUR depuis la base PARTAGÉE (zone « slider_home_welcome »),
     comme le carrousel de cards. Ce partial ne dessine RIEN par lui-même : il
     publie `window.GX_ADS_HOME_SLIDES`, que le carrousel d'accueil
     (components/front/slideshows.blade.php) fusionne à ses propres slides.

     Chaque vue du carrousel = 5 annonces : une grande à gauche, quatre tuiles
     à droite — la mise en page du carrousel éditorial. Un groupe incomplet
     affiche simplement moins de tuiles.

     ⚠ À inclure AVANT @include('components.front.slideshows'), puisque celui-ci
     lit la variable au moment de construire ses slides.
     ═══════════════════════════════════════════════════════════════════════ --}}
@if(config('ads.home_slider_enabled', true))
@php
    $gxhAdminUrl = rtrim(config('ads.admin_url'), '/');
    $gxhZone     = config('ads.home_slider_zone', 'slider_home_welcome');

    try {
        $gxhToday     = now()->toDateString();
        $gxhPlacement = \Illuminate\Support\Facades\DB::table('ad_placements')
            ->where('code', $gxhZone)->where('is_active', true)->first();

        $gxhAds = collect();
        if ($gxhPlacement) {
            $gxhAds = \Illuminate\Support\Facades\DB::table('ads')
                ->join('ad_placement', 'ads.id', '=', 'ad_placement.ad_id')
                ->where('ad_placement.placement_id', $gxhPlacement->id)
                ->where('ad_placement.is_active', true)
                ->where('ads.status', 'active')
                ->where(fn ($q) => $q->whereNull('ads.start_date')->orWhere('ads.start_date', '<=', $gxhToday))
                ->where(fn ($q) => $q->whereNull('ads.end_date')->orWhere('ads.end_date', '>=', $gxhToday))
                ->where(fn ($q) => $q->whereNull('ads.budget_total')->orWhereRaw('ads.budget_total > ads.budget_spent'))
                // La zone est propre à l'accueil : on respecte quand même un
                // ciblage explicite posé sur l'annonce.
                //
                // Pas de JSON_LENGTH() ici, contrairement au carrousel de cards :
                // cette fonction n'existe que sur MySQL, et comme la requête est
                // enveloppée dans un try, une autre base ferait disparaître les
                // annonces sans le moindre signe. La comparaison au littéral
                // « [] » couvre le même cas partout.
                ->where(fn ($q) => $q
                    ->whereNull('ads.display_locations')
                    ->orWhereIn('ads.display_locations', ['[]', ''])
                    ->orWhereJsonContains('ads.display_locations', 'home'))
                ->select('ads.*')
                ->orderBy('ads.priority')
                ->limit(($gxhPlacement->max_ads ?: 15))
                ->get();
        }
    } catch (\Throwable $e) {
        // Une zone absente ou une base indisponible ne doit pas casser l'accueil.
        $gxhAds = collect();
    }

    // Images stockées côté admin (storage séparé) => URL absolue.
    $gxhImg = function (?string $path) use ($gxhAdminUrl) {
        $path = trim((string) $path);
        if ($path === '') return '';
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])) return $path;
        return $gxhAdminUrl . '/storage/' . ltrim($path, '/');
    };

    // Identifiant YouTube : sert au bouton lecture et, à défaut d'image, à la
    // vignette de la vidéo.
    $gxhYoutube = function (?string $url) {
        $url = trim((string) $url);
        if ($url === '') return '';
        return preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $url, $m)
            ? $m[1] : '';
    };

    $gxhItems = $gxhAds->map(function ($ad) use ($gxhImg, $gxhYoutube, $gxhAdminUrl) {
        $videoId = $ad->type === 'video' ? $gxhYoutube($ad->video_url ?: $ad->destination_url) : '';
        $image   = $gxhImg($ad->image_path);

        // Pas d'image mais une vidéo YouTube : sa vignette fait l'affaire.
        if ($image === '' && $videoId !== '') {
            $image = 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg';
        }

        $description = (string) ($ad->description ?? '');
        if ($description === '' && $ad->type === 'text') {
            $description = (string) ($ad->text_content ?? '');
        }

        return [
            'title'       => (string) $ad->titre,
            'description' => $description,
            'image'       => $image,
            // Le carrousel ouvre sa modale vidéo sur ce champ ; vide pour une
            // annonce cliquable, qui doit mener à sa destination.
            'videoId'     => $videoId,
            'badge'       => 'sponsor',
            // Champs propres aux annonces, lus par le carrousel.
            'sponsored'   => true,
            'href'        => trim((string) $ad->destination_url),
            'newTab'      => (int) $ad->open_new_tab === 1,
            'track'       => $gxhAdminUrl . '/ads/track/click/' . $ad->id,
            'imp'         => $gxhAdminUrl . '/ads/track/impression/' . $ad->id,
        ];
    })->values();

    // Une vue = 1 grande + 4 tuiles.
    $gxhSlides = $gxhItems->chunk(5)->map(fn ($groupe) => [
        'largeImage'  => $groupe->first(),
        'smallImages' => $groupe->slice(1)->values(),
        'sponsored'   => true,
    ])->values();
@endphp

@if($gxhSlides->isNotEmpty())
<script>
    // Vues sponsorisées à fusionner dans le carrousel d'accueil.
    window.GX_ADS_HOME_SLIDES = @json($gxhSlides);
    window.GX_ADS_HOME_FIRST  = @json((bool) config('ads.home_slider_first', true));
</script>
@endif
@endif
