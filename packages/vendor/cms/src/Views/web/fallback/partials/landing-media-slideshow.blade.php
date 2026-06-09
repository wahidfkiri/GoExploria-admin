@php
    $landingSlideshowEnabled = true;
    $landingSlideshowEtablissementId = data_get($etablissement ?? null, 'id');
    $landingSlideshowTitle = $landingSlideshowEtablissementId && function_exists('get_slideshow_section_title')
        ? get_slideshow_section_title($landingSlideshowEtablissementId)
        : 'Galerie médias';
    $landingSlideshowTitle = trim((string) $landingSlideshowTitle) !== '' ? $landingSlideshowTitle : 'Galerie médias';

    if ($landingSlideshowEtablissementId && function_exists('is_slideshow_enabled')) {
        $landingSlideshowEnabled = is_slideshow_enabled($landingSlideshowEtablissementId);
    }

    $landingSlideshowGroups = collect($slideshowMediaGroups ?? [])->filter(fn ($group) => !empty(data_get($group, 'main.src')))->values();

    if ($landingSlideshowEnabled && $landingSlideshowGroups->isEmpty()) {
        $landingSlideshowSource = collect($allGalleryMedia ?? []);
        if ($landingSlideshowSource->isEmpty()) {
            $landingSlideshowSource = collect($galleryMedia ?? []);
        }

        $rawMedia = $landingSlideshowSource
            ->filter(fn ($item) => !empty(data_get($item, 'thumbnail')) || !empty(data_get($item, 'url')))
            ->map(function ($item) {
                $url = trim((string) (data_get($item, 'url') ?: data_get($item, 'thumbnail')));
                $thumbnail = trim((string) (data_get($item, 'thumbnail') ?: $url));
                $type = strtolower((string) data_get($item, 'type'));
                $youtubeId = null;

                if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|live\/|embed\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $url, $match)) {
                    $youtubeId = $match[1];
                }

                return [
                    'src' => $thumbnail,
                    'video' => ($youtubeId || str_starts_with($type, 'video') || preg_match('/\.(mp4|webm|ogg)(\?.*)?$/i', $url))
                        ? ($youtubeId ?: $url)
                        : null,
                    'title' => data_get($item, 'title') ?: data_get($item, 'name') ?: ($siteName ?? ''),
                    'desc' => data_get($item, 'description') ?: '',
                    'badge' => null,
                ];
            })
            ->filter(fn ($item) => !empty($item['src']))
            ->values();

        $landingSlideshowGroups = $rawMedia->chunk(5)->map(fn ($chunk) => [
            'main' => $chunk->values()->first(),
            'grid' => $chunk->values()->slice(1, 4)->values()->all(),
        ])->filter(fn ($group) => !empty(data_get($group, 'main.src')))->values();
    }

    $landingSlideshowId = 'landingCmsMedia' . substr(md5((string) ($etablissement->id ?? 'global')), 0, 8);
@endphp

@if($landingSlideshowEnabled && $landingSlideshowGroups->isNotEmpty())
    @once
        <link rel="stylesheet" href="{{ asset('css/home-v2/media-slideshow.css') }}">
        <style>
            .cms-landing-slideshow-section{padding:64px 24px;background:var(--bg,#0b1220);color:var(--text,#fff)}
            .cms-landing-slideshow-section>.container{max-width:1240px;margin:0 auto}
            .cms-landing-slideshow-head{margin-bottom:24px}
            .cms-landing-slideshow-kicker{display:inline-flex;align-items:center;gap:8px;margin:0 0 8px;color:#f5c542;font-size:12px;font-weight:900;letter-spacing:.16em;text-transform:uppercase}
            .cms-landing-slideshow-title{margin:0;color:inherit;font-size:clamp(28px,4vw,46px);line-height:1.05;font-weight:950}
            .cms-landing-slideshow-section .mss-gallery-wrapper{margin-bottom:0}
        </style>
    @endonce

    <section class="cms-landing-slideshow-section" id="slideshow">
        <div class="container">
            <div class="cms-landing-slideshow-head">
                <p class="cms-landing-slideshow-kicker">Slideshow</p>
                <h2 class="cms-landing-slideshow-title">{{ $landingSlideshowTitle }}</h2>
            </div>
            @include('home-v2.components.MediaSlideshow', [
                'slideshowId' => $landingSlideshowId,
                'slides' => $landingSlideshowGroups->all(),
            ])
        </div>
    </section>
@endif
