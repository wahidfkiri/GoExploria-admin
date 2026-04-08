{{-- Video Player Component - MA CHAÎNE·VIDÉOS --}}
@php
/* ----------------------------------------------------------------
   CONFIG
---------------------------------------------------------------- */
$vpConfig = [
    'title'      => 'MA CHAÎNE·VIDÉOS',
    'subtitle'   => 'Films · Documentaires · Plein air · Gastronomie — Explorez le Québec en images avec la chaîne vidéo officielle GoExploria.',
    'logo_left'  => [
        'src'   => asset('GO-EXPLORIA-MY-TUBE.png'),
        'alt'   => 'GoExploria MyTube',
        'href'  => '#',
        'label' => 'GoExploria MyTube',
    ],
    'logo_plans' => [
        'src'   => asset('plan-n-go.png'),
        'alt'   => 'Plans Web Go Exploria',
        'href'  => '#',
        'label' => 'Plans Web Go',
    ],
];

/* ----------------------------------------------------------------
   MÉDIAS — Playlist
---------------------------------------------------------------- */
$vpMediaItems = [
    [
        'type'        => 'video',
        'src'         => asset('home2/videos/hero-video-1.mp4.mp4'),
        'poster'      => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=900&h=500&fit=crop',
        'thumb'       => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=160&h=90&fit=crop',
        'title'       => 'Paysage Montagneux',
        'description' => 'Un magnifique panorama de montagnes enneigées au coucher du soleil.',
        'badge'       => 'Image',
        'has_play'    => false,
        'category'    => 'destination',
    ],
    [
        'type'        => 'video',
        'src'         => asset('home2/videos/hero-video-2.mp4.mp4'),
        'poster'      => 'https://images.unsplash.com/photo-1511497584788-876760111969?w=900&h=500&fit=crop',
        'thumb'       => 'https://images.unsplash.com/photo-1511497584788-876760111969?w=160&h=90&fit=crop',
        'title'       => 'Forêt Tropicale',
        'description' => "Explorez la beauté luxuriante d'une forêt tropicale dense.",
        'badge'       => 'Vidéo · 0:15',
        'has_play'    => true,
        'category'    => 'activite',
    ],
    [
        'type'        => 'video',
        'src'         => asset('home2/videos/hero-video-3.mp4.mp4'),
        'poster'      => 'https://images.unsplash.com/photo-1514565131-fce0801e5785?w=900&h=500&fit=crop',
        'thumb'       => 'https://images.unsplash.com/photo-1514565131-fce0801e5785?w=160&h=90&fit=crop',
        'title'       => 'Ville Nocturne',
        'description' => "Découvrez l'énergie vibrante d'une métropole illuminée la nuit.",
        'badge'       => 'Image',
        'has_play'    => false,
        'category'    => 'destination',
    ],
    [
        'type'        => 'video',
        'src'         => asset('home2/videos/hero-video-1.mp4.mp4'),
        'poster'      => 'https://images.unsplash.com/photo-1505142468610-359e7d316be0?w=900&h=500&fit=crop',
        'thumb'       => 'https://images.unsplash.com/photo-1505142468610-359e7d316be0?w=160&h=90&fit=crop',
        'title'       => 'Océan et Vagues',
        'description' => "Laissez-vous bercer par le son apaisant des vagues de l'océan.",
        'badge'       => 'Vidéo · 0:12',
        'has_play'    => true,
        'category'    => 'activite',
    ],
    [
        'type'        => 'video',
        'src'         => asset('home2/videos/hero-video-2.mp4.mp4'),
        'poster'      => 'https://images.unsplash.com/photo-1509316785289-025f5b846b35?w=900&h=500&fit=crop',
        'thumb'       => 'https://images.unsplash.com/photo-1509316785289-025f5b846b35?w=160&h=90&fit=crop',
        'title'       => 'Désert et Ciel Étoilé',
        'description' => "Admirez la majesté d'un ciel étoilé au-dessus du désert.",
        'badge'       => 'Image',
        'has_play'    => false,
        'category'    => 'entreprise',
    ],
];
@endphp

<section class="video-player-v2-section" id="vp-chaine">
    <div class="video-player-v2-container">

        {{-- ============================================================
             EN-TÊTE STANDARD — même layout que EventsVedette / DestinationsVedette
        ============================================================ --}}
        <div class="resto-header-block">

            <div class="resto-header-main">

                {{-- Logo gauche : GoExploria MyTube --}}
                <div class="resto-header-logo-left">
                    <a href="{{ $vpConfig['logo_left']['href'] }}" class="resto-accord-btn" title="{{ $vpConfig['logo_left']['label'] }}">
                        <div class="logo-wrapper">
                            <img src="{{ $vpConfig['logo_left']['src'] }}" alt="{{ $vpConfig['logo_left']['alt'] }}">
                        </div>
                        <span class="resto-accord-btn-label">{{ $vpConfig['logo_left']['label'] }}</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-external-link-alt"></i> Visiter
                        </span>
                    </a>
                </div>

                {{-- Centre : titre + sous-titre + onglets espaces --}}
                <div class="resto-header-center">
                    <h1 class="resto-header-title">{{ $vpConfig['title'] }}</h1>
                    <p class="resto-header-subtitle">{{ $vpConfig['subtitle'] }}</p>

                    <div class="resto-header-tabs">
                        <a href="#" class="resto-tab-btn active">
                            <i class="fas fa-th-large"></i> Toutes les options
                        </a>
                        <a href="#" class="resto-tab-btn">
                            <i class="fas fa-briefcase"></i> Espace entreprise
                        </a>
                        <a href="#" class="resto-tab-btn">
                            <i class="fas fa-map-marker-alt"></i> Espace destination
                        </a>
                        <a href="#" class="resto-tab-btn">
                            <i class="fas fa-person-hiking"></i> Espace activité
                        </a>
                    </div>
                </div>

                {{-- Logo droit : Plans Web Go --}}
                <div class="resto-header-logo-right">
                    <a href="{{ $vpConfig['logo_plans']['href'] }}" class="resto-accord-btn" title="{{ $vpConfig['logo_plans']['label'] }}">
                        <div class="logo-wrapper">
                            <img src="{{ $vpConfig['logo_plans']['src'] }}" alt="{{ $vpConfig['logo_plans']['alt'] }}">
                        </div>
                        <span class="resto-accord-btn-label">{{ $vpConfig['logo_plans']['label'] }}</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-external-link-alt"></i> Visiter
                        </span>
                    </a>
                </div>

            </div>

            {{-- Barre Destinations + Filtres --}}
            <div class="resto-header-destinations-bar">

                <div class="resto-dest-row">
                    <div class="resto-dest-icon-box">
                        <img src="{{ asset('REDI.png') }}" alt="Destinations">
                        <span>Destinations</span>
                    </div>
                    <div class="resto-dest-breadcrumb">
                        <a href="#" class="resto-dest-link active" data-dest="all">Toutes destinations</a>
                        <span class="resto-dest-sep">/</span>
                        <a href="#" class="resto-dest-link" data-dest="amerique-nord">Amérique du Nord</a>
                        <span class="resto-dest-sep">/</span>
                        <a href="#" class="resto-dest-link" data-dest="canada">Canada</a>
                        <span class="resto-dest-sep">/</span>
                        <a href="#" class="resto-dest-link" data-dest="quebec">Québec</a>
                        <span class="resto-dest-sep">/</span>
                        <a href="#" class="resto-dest-link" data-dest="region-quebec">Région de Québec</a>
                    </div>
                </div>

            </div>

            <div class="resto-header-shimmer"></div>
        </div>{{-- /.resto-header-block --}}

        {{-- ============================================================
             CONTENU — Layout YouTube : lecteur (gauche) + playlist (droite)
        ============================================================ --}}
        <div class="video-player-v2-content">

            {{-- ── Lecteur principal ── --}}
            <div class="video-player-v2-main">
                <div class="video-player-v2-wrapper">
                    <video
                        id="mainVideoPlayer"
                        class="video-player-v2-video"
                        poster="{{ $vpMediaItems[0]['poster'] }}"
                    >
                        <source src="{{ $vpMediaItems[0]['src'] }}" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture de vidéos.
                    </video>
                </div>

                {{-- Contrôles --}}
                <div class="video-player-v2-controls" id="videoControls">
                    <div class="video-player-v2-progress-bar" id="progressBar">
                        <div class="video-player-v2-progress-filled" id="progressFilled"></div>
                    </div>
                    <div class="video-player-v2-controls-bottom">
                        <div class="video-player-v2-controls-left">
                            <button class="video-player-v2-control-btn play-btn" id="playPauseBtn">
                                <svg class="play-icon" width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                <svg class="pause-icon" width="28" height="28" viewBox="0 0 24 24" fill="currentColor" style="display:none;"><path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/></svg>
                            </button>
                            <button class="video-player-v2-control-btn" id="volumeBtn">
                                <svg class="volume-on-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
                                <svg class="volume-off-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="display:none;"><path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/></svg>
                            </button>
                            <span class="video-player-v2-time" id="timeDisplay">0:00 / 0:00</span>
                        </div>
                        <div class="video-player-v2-controls-right">
                            <span class="video-player-v2-counter" id="mediaCounter">1 / {{ count($vpMediaItems) }}</span>
                            <button class="video-player-v2-control-btn" id="fullscreenBtn">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Titre + description sous le lecteur --}}
                <div class="video-player-v2-info">
                    <h2 class="video-player-v2-title" id="videoTitle">{{ $vpMediaItems[0]['title'] }}</h2>
                    <p class="video-player-v2-description" id="videoDescription">{{ $vpMediaItems[0]['description'] }}</p>
                </div>
            </div>{{-- /.video-player-v2-main --}}

            {{-- ── Playlist (droite) ── --}}
            <div class="video-player-v2-playlist">
                <div class="video-player-v2-playlist-header">
                    <h3 class="video-player-v2-playlist-title">
                        <i class="fas fa-list"></i> PLAYLIST
                    </h3>
                    <span class="vp-playlist-count">{{ count($vpMediaItems) }} vidéos</span>
                </div>
                <ul class="video-player-v2-playlist-items" id="playlistItems">
                    @foreach($vpMediaItems as $i => $item)
                    <li class="video-player-v2-playlist-item {{ $i === 0 ? 'active' : '' }}"
                        data-type="{{ $item['type'] }}"
                        data-src="{{ $item['src'] }}"
                        data-title="{{ $item['title'] }}"
                        data-description="{{ $item['description'] }}"
                        data-poster="{{ $item['poster'] }}"
                        data-category="{{ $item['category'] }}">
                        <div class="video-player-v2-playlist-thumbnail">
                            <img src="{{ $item['thumb'] }}" alt="{{ $item['title'] }}" loading="lazy">
                            <span class="video-player-v2-playlist-badge">{{ $item['badge'] }}</span>
                            @if($item['has_play'])
                            <div class="video-player-v2-play-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                            @endif
                        </div>
                        <div class="video-player-v2-playlist-info">
                            <h4 class="video-player-v2-playlist-name">{{ $item['title'] }}</h4>
                            <p class="video-player-v2-playlist-type">{{ $item['badge'] }}</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>{{-- /.video-player-v2-playlist --}}

        </div>{{-- /.video-player-v2-content --}}

    </div>{{-- /.video-player-v2-container --}}
</section>
<script>
(function () {
    var section    = document.getElementById('vp-chaine');
    if (!section) return;
    var filterBtns = section.querySelectorAll('.video-player-v2-filter-btn, .resto-tab-btn[data-filter]');
    var plItems    = section.querySelectorAll('.video-player-v2-playlist-item');

    filterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var group = btn.classList.contains('video-player-v2-filter-btn')
                ? '.video-player-v2-filter-btn'
                : '.resto-tab-btn[data-filter]';
            section.querySelectorAll(group).forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');

            var filter = btn.getAttribute('data-filter') || 'all';
            plItems.forEach(function (item) {
                var cat = item.getAttribute('data-category') || '';
                item.style.display = (filter === 'all' || cat === filter) ? '' : 'none';
            });
        });
    });
})();
</script>