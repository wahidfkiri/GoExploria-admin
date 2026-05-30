@php
    $landingSlideshowGroups = collect($slideshowMediaGroups ?? [])->filter(fn ($group) => !empty(data_get($group, 'main.src')))->values();

    if ($landingSlideshowGroups->isEmpty()) {
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

@if($landingSlideshowGroups->isNotEmpty())
    @once
        <link rel="stylesheet" href="{{ asset('css/home-v2/media-slideshow.css') }}">
        <style>
            .cms-landing-slideshow-section{padding:64px 24px;background:var(--bg,#0b1220);color:var(--text,#fff)}
            .cms-landing-slideshow-section>.container{max-width:1240px;margin:0 auto}
            .cms-landing-slideshow-section .mss-gallery-wrapper{margin-bottom:0}
        </style>
    @endonce

    <section class="cms-landing-slideshow-section" id="slideshow">
        <div class="container">
            @include('home-v2.components.MediaSlideshow', [
                'slideshowId' => $landingSlideshowId,
                'slides' => $landingSlideshowGroups->all(),
            ])
        </div>
    </section>
@endif
