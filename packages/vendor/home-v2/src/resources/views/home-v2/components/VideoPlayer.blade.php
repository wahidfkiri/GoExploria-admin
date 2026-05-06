{{-- Video Player Component - MA CHAINE VIDEO --}}
@php
/* ----------------------------------------------------------------
   TRADUCTION LOCALE
---------------------------------------------------------------- */
$tr = static function (string $text): string {
    $locale = app()->getLocale();
    if ($locale === 'fr') {
        return $text;
    }

    static $maps = [];
    if (! array_key_exists($locale, $maps)) {
        $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
        $maps[$locale] = is_file($path) ? (require $path) : [];
    }

    return $maps[$locale][$text] ?? $text;
};

/* ----------------------------------------------------------------
   CONFIG
---------------------------------------------------------------- */
$vpConfig = [
    'title'      => 'MA CHAINE VIDEO',
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

if (app()->getLocale() !== 'fr') {
    $vpConfig['title'] = $tr($vpConfig['title']);
    $vpConfig['subtitle'] = $tr($vpConfig['subtitle']);
    $vpConfig['logo_left']['alt'] = $tr($vpConfig['logo_left']['alt']);
    $vpConfig['logo_left']['label'] = $tr($vpConfig['logo_left']['label']);
    $vpConfig['logo_plans']['alt'] = $tr($vpConfig['logo_plans']['alt']);
    $vpConfig['logo_plans']['label'] = $tr($vpConfig['logo_plans']['label']);
}

/* ----------------------------------------------------------------
   CATEGORIES VIDEOS
---------------------------------------------------------------- */
$vpCategories = [
    'destination' => ['label' => 'Destination', 'icon' => 'fa-map-marked-alt'],
    'activite'    => ['label' => 'Activité', 'icon' => 'fa-person-hiking'],
    'gastronomie' => ['label' => 'Gastronomie', 'icon' => 'fa-utensils'],
    'culture'     => ['label' => 'Culture', 'icon' => 'fa-landmark'],
    'aventure'    => ['label' => 'Aventure', 'icon' => 'fa-mountain'],
];

/* ----------------------------------------------------------------
   DESTINATIONS (1 pays par continent, 5 provinces, 5 regions)
---------------------------------------------------------------- */
$vpDestinationHierarchy = [
    [
        'continent' => ['slug' => 'amerique-nord', 'name' => 'Amérique du Nord'],
        'country'   => ['slug' => 'canada', 'name' => 'Canada'],
        'provinces' => [
            ['slug' => 'quebec', 'name' => 'Québec', 'regions' => ['Région de Québec', 'Montréal Métro', 'Mauricie', 'Gaspésie', 'Saguenay']],
            ['slug' => 'ontario', 'name' => 'Ontario', 'regions' => ['Toronto', 'Ottawa', 'Niagara', 'Kingston', 'Muskoka']],
            ['slug' => 'alberta', 'name' => 'Alberta', 'regions' => ['Calgary', 'Edmonton', 'Banff', 'Jasper', 'Red Deer']],
            ['slug' => 'colombie-britannique', 'name' => 'Colombie-Britannique', 'regions' => ['Vancouver', 'Victoria', 'Whistler', 'Kelowna', 'Tofino']],
            ['slug' => 'nouvelle-ecosse', 'name' => 'Nouvelle-Écosse', 'regions' => ['Halifax', 'Cape Breton', 'Lunenburg', 'Annapolis', 'Yarmouth']],
        ],
    ],
    [
        'continent' => ['slug' => 'europe', 'name' => 'Europe'],
        'country'   => ['slug' => 'france', 'name' => 'France'],
        'provinces' => [
            ['slug' => 'ile-de-france', 'name' => 'Île-de-France', 'regions' => ['Paris', 'Versailles', 'Saint-Denis', 'Fontainebleau', 'Meaux']],
            ['slug' => 'provence', 'name' => 'Provence', 'regions' => ['Marseille', 'Aix-en-Provence', 'Cassis', 'Arles', 'Avignon']],
            ['slug' => 'normandie', 'name' => 'Normandie', 'regions' => ['Rouen', 'Caen', 'Deauville', 'Étretat', 'Le Havre']],
            ['slug' => 'bretagne', 'name' => 'Bretagne', 'regions' => ['Rennes', 'Saint-Malo', 'Quimper', 'Brest', 'Vannes']],
            ['slug' => 'alpes', 'name' => 'Alpes', 'regions' => ['Chamonix', 'Annecy', 'Grenoble', 'Megève', 'Val d’Isère']],
        ],
    ],
    [
        'continent' => ['slug' => 'afrique', 'name' => 'Afrique'],
        'country'   => ['slug' => 'maroc', 'name' => 'Maroc'],
        'provinces' => [
            ['slug' => 'casablanca-settat', 'name' => 'Casablanca-Settat', 'regions' => ['Casablanca', 'Settat', 'El Jadida', 'Mohammedia', 'Berrechid']],
            ['slug' => 'rabat-sale-kenitra', 'name' => 'Rabat-Salé-Kénitra', 'regions' => ['Rabat', 'Salé', 'Kénitra', 'Skhirat', 'Témara']],
            ['slug' => 'marrakech-safi', 'name' => 'Marrakech-Safi', 'regions' => ['Marrakech', 'Essaouira', 'Safi', 'Ouarzazate', 'Chichaoua']],
            ['slug' => 'fes-meknes', 'name' => 'Fès-Meknès', 'regions' => ['Fès', 'Meknès', 'Ifrane', 'Sefrou', 'Taza']],
            ['slug' => 'souss-massa', 'name' => 'Souss-Massa', 'regions' => ['Agadir', 'Taroudant', 'Tiznit', 'Chtouka', 'Tata']],
        ],
    ],
    [
        'continent' => ['slug' => 'asie', 'name' => 'Asie'],
        'country'   => ['slug' => 'japon', 'name' => 'Japon'],
        'provinces' => [
            ['slug' => 'tokyo', 'name' => 'Tokyo', 'regions' => ['Shinjuku', 'Shibuya', 'Asakusa', 'Ueno', 'Odaiba']],
            ['slug' => 'osaka', 'name' => 'Osaka', 'regions' => ['Namba', 'Umeda', 'Sakai', 'Tennoji', 'Minoh']],
            ['slug' => 'kyoto', 'name' => 'Kyoto', 'regions' => ['Gion', 'Arashiyama', 'Fushimi', 'Uji', 'Kameoka']],
            ['slug' => 'hokkaido', 'name' => 'Hokkaido', 'regions' => ['Sapporo', 'Otaru', 'Niseko', 'Hakodate', 'Furano']],
            ['slug' => 'okinawa', 'name' => 'Okinawa', 'regions' => ['Naha', 'Nago', 'Ishigaki', 'Miyakojima', 'Onna']],
        ],
    ],
    [
        'continent' => ['slug' => 'amerique-sud', 'name' => 'Amérique du Sud'],
        'country'   => ['slug' => 'bresil', 'name' => 'Brésil'],
        'provinces' => [
            ['slug' => 'sao-paulo', 'name' => 'São Paulo', 'regions' => ['Centro', 'Campinas', 'Santos', 'Guarulhos', 'Ribeirão Preto']],
            ['slug' => 'rio-de-janeiro', 'name' => 'Rio de Janeiro', 'regions' => ['Copacabana', 'Ipanema', 'Niterói', 'Petrópolis', 'Barra da Tijuca']],
            ['slug' => 'bahia', 'name' => 'Bahia', 'regions' => ['Salvador', 'Ilhéus', 'Porto Seguro', 'Feira de Santana', 'Chapada']],
            ['slug' => 'parana', 'name' => 'Paraná', 'regions' => ['Curitiba', 'Londrina', 'Maringá', 'Foz do Iguaçu', 'Ponta Grossa']],
            ['slug' => 'ceara', 'name' => 'Ceará', 'regions' => ['Fortaleza', 'Jericoacoara', 'Sobral', 'Crato', 'Canoa Quebrada']],
        ],
    ],
    [
        'continent' => ['slug' => 'oceanie', 'name' => 'Océanie'],
        'country'   => ['slug' => 'australie', 'name' => 'Australie'],
        'provinces' => [
            ['slug' => 'nouvelle-galles-du-sud', 'name' => 'Nouvelle-Galles du Sud', 'regions' => ['Sydney', 'Newcastle', 'Byron Bay', 'Wollongong', 'Blue Mountains']],
            ['slug' => 'victoria', 'name' => 'Victoria', 'regions' => ['Melbourne', 'Geelong', 'Great Ocean Road', 'Ballarat', 'Bendigo']],
            ['slug' => 'queensland', 'name' => 'Queensland', 'regions' => ['Brisbane', 'Gold Coast', 'Cairns', 'Townsville', 'Whitsundays']],
            ['slug' => 'tasmanie', 'name' => 'Tasmanie', 'regions' => ['Hobart', 'Launceston', 'Freycinet', 'Devonport', 'Cradle Mountain']],
            ['slug' => 'australie-occidentale', 'name' => 'Australie-Occidentale', 'regions' => ['Perth', 'Broome', 'Margaret River', 'Albany', 'Fremantle']],
        ],
    ],
];

/* ----------------------------------------------------------------
   MEDIAS — 5 videos par pays => total videos = nb pays x 5
---------------------------------------------------------------- */
$videoSeeds = [
    [
        'src'      => 'https://www.youtube.com/embed/VhPCb_gSu-4?autoplay=1&mute=1&loop=1&playlist=VhPCb_gSu-4&rel=0&modestbranding=1',
        'poster'   => 'https://img.youtube.com/vi/VhPCb_gSu-4/hqdefault.jpg',
        'thumb'    => 'https://img.youtube.com/vi/VhPCb_gSu-4/hqdefault.jpg',
        'suffix'   => 'Panorama Signature',
        'desc'     => 'Panorama 4 saisons et vues iconiques.',
        'badge'    => 'Vidéo · 0:05',
        'category' => 'destination',
    ],
    [
        'src'      => 'https://www.youtube.com/embed/uyrBtsvmzqM?autoplay=1&mute=1&loop=1&playlist=uyrBtsvmzqM&rel=0&modestbranding=1',
        'poster'   => 'https://img.youtube.com/vi/uyrBtsvmzqM/hqdefault.jpg',
        'thumb'    => 'https://img.youtube.com/vi/uyrBtsvmzqM/hqdefault.jpg',
        'suffix'   => 'Expériences Plein Air',
        'desc'     => 'Randonnée, aventure et nature active.',
        'badge'    => 'Vidéo · 0:10',
        'category' => 'activite',
    ],
    [
        'src'      => 'https://www.youtube.com/embed/Scxs7L0vhZ4?autoplay=1&mute=1&loop=1&playlist=Scxs7L0vhZ4&rel=0&modestbranding=1',
        'poster'   => 'https://img.youtube.com/vi/Scxs7L0vhZ4/hqdefault.jpg',
        'thumb'    => 'https://img.youtube.com/vi/Scxs7L0vhZ4/hqdefault.jpg',
        'suffix'   => 'Saveurs & Gastronomie',
        'desc'     => 'Table locale, terroir et découvertes gourmandes.',
        'badge'    => 'Vidéo · 0:15',
        'category' => 'gastronomie',
    ],
    [
        'src'      => 'https://www.youtube.com/embed/ysz5S6PUM-U?autoplay=1&mute=1&loop=1&playlist=ysz5S6PUM-U&rel=0&modestbranding=1',
        'poster'   => 'https://img.youtube.com/vi/ysz5S6PUM-U/hqdefault.jpg',
        'thumb'    => 'https://img.youtube.com/vi/ysz5S6PUM-U/hqdefault.jpg',
        'suffix'   => 'Patrimoine & Culture',
        'desc'     => 'Culture locale, histoire et patrimoine vivant.',
        'badge'    => 'Vidéo · 0:20',
        'category' => 'culture',
    ],
    [
        'src'      => 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&mute=1&loop=1&playlist=dQw4w9WgXcQ&rel=0&modestbranding=1',
        'poster'   => 'https://img.youtube.com/vi/dQw4w9WgXcQ/hqdefault.jpg',
        'thumb'    => 'https://img.youtube.com/vi/dQw4w9WgXcQ/hqdefault.jpg',
        'suffix'   => 'Aventure Nature',
        'desc'     => 'Circuits emblématiques et escapades inspirantes.',
        'badge'    => 'Vidéo · 0:30',
        'category' => 'aventure',
    ],
];

$vpMediaItems = [];
foreach ($vpDestinationHierarchy as $continentData) {
    $continent = $continentData['continent'];
    $country   = $continentData['country'];
    $provinces = $continentData['provinces'];

    for ($i = 0; $i < 5; $i++) {
        $seed = $videoSeeds[$i];
        $province = $provinces[$i];
        $regionName = $province['regions'][$i % 5];

        $vpMediaItems[] = [
            'type'          => 'video',
            'src'           => $seed['src'],
            'poster'        => $seed['poster'],
            'thumb'         => $seed['thumb'],
            'title'         => $country['name'] . ' — ' . $seed['suffix'],
            'description'   => $seed['desc'] . ' · ' . $province['name'] . ' / ' . $regionName,
            'badge'         => $seed['badge'],
            'has_play'      => true,
            'category'      => $seed['category'],
            'continent'     => $continent['slug'],
            'country'       => $country['slug'],
            'province'      => $province['slug'],
            'region'        => strtolower(str_replace([' ', '’', "'"], ['-', '', ''], $regionName)),
        ];
    }
}

$vpTotalVideos = count($vpMediaItems);
@endphp

<section class="video-player-v2-section" id="vp-chaine">
    <div class="video-player-v2-container">

        <div class="resto-header-block">
            <div class="resto-header-main">
                <div class="resto-header-logo-left">
                    <a href="{{ $vpConfig['logo_left']['href'] }}" class="resto-accord-btn" title="{{ $vpConfig['logo_left']['label'] }}">
                        <div class="logo-wrapper">
                            <img src="{{ $vpConfig['logo_left']['src'] }}" alt="{{ $vpConfig['logo_left']['alt'] }}">
                        </div>
                        <span class="resto-accord-btn-label">{{ $vpConfig['logo_left']['label'] }}</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-external-link-alt"></i> {{ $tr('Visiter') }}
                        </span>
                    </a>
                </div>

                <div class="resto-header-center">
                    <h1 class="resto-header-title">{{ $vpConfig['title'] }}</h1>
                    <p class="resto-header-subtitle">{{ $vpConfig['subtitle'] }}</p>

                    <div class="resto-header-tabs">
                        <a href="#" class="resto-tab-btn active">
                            <i class="fas fa-th-large"></i> {{ $tr('Toutes les options') }}
                        </a>
                        <a href="#" class="resto-tab-btn">
                            <i class="fas fa-briefcase"></i> {{ $tr('Espace entreprise') }}
                        </a>
                        <a href="#" class="resto-tab-btn">
                            <i class="fas fa-map-marker-alt"></i> {{ $tr('Espace destination') }}
                        </a>
                        <a href="#" class="resto-tab-btn">
                            <i class="fas fa-person-hiking"></i> {{ $tr('Espace activité') }}
                        </a>
                    </div>
                </div>

                <div class="resto-header-logo-right">
                    <a href="{{ $vpConfig['logo_plans']['href'] }}" class="resto-accord-btn" title="{{ $vpConfig['logo_plans']['label'] }}">
                        <div class="logo-wrapper">
                            <img src="{{ $vpConfig['logo_plans']['src'] }}" alt="{{ $vpConfig['logo_plans']['alt'] }}">
                        </div>
                        <span class="resto-accord-btn-label">{{ $vpConfig['logo_plans']['label'] }}</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-external-link-alt"></i> {{ $tr('Visiter') }}
                        </span>
                    </a>
                </div>
            </div>

            <div class="resto-header-destinations-bar">
                <div class="resto-dest-row">
    <div class="resto-dest-icon-box">
        <img src="{{ asset('REDI.png') }}" alt="Destinations">
        <span>Destinations</span>
    </div>

    <div class="resto-dest-breadcrumb vp-dest-breadcrumb">
        <select id="vp-continent-select" class="vp-dest-select" aria-label="Continent">
            <option value="amerique-nord">Amérique du Nord</option>
            <option value="europe">Europe</option>
            <option value="afrique">Afrique</option>
            <option value="asie">Asie</option>
            <option value="amerique-sud">Amérique du Sud</option>
            <option value="oceanie">Océanie</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-country-select" class="vp-dest-select" aria-label="Pays">
            <option value="canada">Canada</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-province-select" class="vp-dest-select" aria-label="Province">
            <option value="quebec">Québec</option>
            <option value="ontario">Ontario</option>
            <option value="alberta">Alberta</option>
            <option value="colombie-britannique">Colombie-Britannique</option>
            <option value="nouvelle-ecosse">Nouvelle-Écosse</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-region-select" class="vp-dest-select" aria-label="Région">
            <option value="region-de-quebec">Région de Québec</option>
            <option value="montreal-metro">Montréal Métro</option>
            <option value="mauricie">Mauricie</option>
            <option value="gaspesie">Gaspésie</option>
            <option value="saguenay">Saguenay</option>
        </select>
    </div>
</div>

                <div class="resto-actions-row">
                    <div class="resto-header-ctas">
                        <div class="products-vedette-v2-filters video-player-v2-filters" id="vp-category-filters">
                            <button class="products-vedette-v2-filter-btn video-player-v2-filter-btn active" data-filter="all" type="button">
                                <i class="fas fa-th-large"></i> {{ $tr('Toutes catégories') }}
                            </button>
                            @foreach($vpCategories as $catKey => $cat)
                                <button class="products-vedette-v2-filter-btn video-player-v2-filter-btn" data-filter="{{ $catKey }}" type="button">
                                    <i class="fas {{ $cat['icon'] }}"></i> {{ $tr($cat['label']) }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="resto-header-shimmer"></div>
        </div>

        <div class="video-player-v2-content">
            <div class="video-player-v2-main">
                <div class="video-player-v2-wrapper">
                    <iframe
                        id="mainVideoPlayerIframe"
                        class="video-player-v2-video"
                        src="{{ $vpMediaItems[0]['src'] }}"
                        title="{{ $vpMediaItems[0]['title'] }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen></iframe>
                </div>

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
                            <span class="video-player-v2-counter" id="mediaCounter">1 / 5</span>
                            <button class="video-player-v2-control-btn" id="fullscreenBtn">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="video-player-v2-info">
                    <h2 class="video-player-v2-title" id="videoTitle">{{ $vpMediaItems[0]['title'] }}</h2>
                    <p class="video-player-v2-description" id="videoDescription">{{ $vpMediaItems[0]['description'] }}</p>
                </div>
            </div>

            <div class="video-player-v2-playlist">
                <div class="video-player-v2-playlist-header">
                    <h3 class="video-player-v2-playlist-title">
                        <i class="fas fa-list"></i> {{ $tr('PLAYLIST') }}
                    </h3>
                    <span class="vp-playlist-count"><span id="vpPlaylistVisibleCount">5</span> / {{ $vpTotalVideos }} {{ $tr('vidéos') }}</span>
                </div>
                <ul class="video-player-v2-playlist-items" id="playlistItems">
                    @foreach($vpMediaItems as $i => $item)
                    <li class="video-player-v2-playlist-item {{ $i === 0 ? 'active' : '' }}"
                        data-type="{{ $item['type'] }}"
                        data-src="{{ $item['src'] }}"
                        data-title="{{ $item['title'] }}"
                        data-description="{{ $item['description'] }}"
                        data-poster="{{ $item['poster'] }}"
                        data-category="{{ $item['category'] }}"
                        data-continent="{{ $item['continent'] }}"
                        data-country="{{ $item['country'] }}"
                        data-province="{{ $item['province'] }}"
                        data-region="{{ $item['region'] }}">
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
            </div>
        </div>
    </div>
</section>

<style>
#vp-chaine .vp-dest-select {
    min-width: 150px;
    max-width: 210px;
    padding: 6px 28px 6px 10px;
    border: 1px solid rgba(10, 22, 40, 0.18);
    border-radius: 8px;
    background: #fff;
    color: #0a1628;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
#vp-chaine .vp-dest-select:focus {
    outline: none;
    border-color: #f26522;
    box-shadow: 0 0 0 2px rgba(242, 101, 34, 0.18);
}
#vp-chaine .vp-dest-breadcrumb {
    flex: 1;
    min-width: 0;
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    gap: 8px;
}
#vp-chaine .resto-dest-row {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    gap: 12px;
}
#vp-chaine .vp-dest-select {
    flex: 1;
    min-width: 120px;
}
#vp-chaine .video-player-v2-controls {
    display: none;
}
@media (max-width: 992px) {
    #vp-chaine .resto-dest-row {
        flex-wrap: wrap;
    }
    #vp-chaine .vp-dest-breadcrumb {
        width: 100%;
        flex-wrap: wrap;
    }
    #vp-chaine .vp-dest-select {
        min-width: 145px;
    }
}
</style>

<script>
(function () {
    var section = document.getElementById('vp-chaine');
    if (!section) return;

    var destinationData = @json($vpDestinationHierarchy, JSON_UNESCAPED_UNICODE);
    var continentSelect = section.querySelector('#vp-continent-select');
    var countrySelect = section.querySelector('#vp-country-select');
    var provinceSelect = section.querySelector('#vp-province-select');
    var regionSelect = section.querySelector('#vp-region-select');
    var categoryBtns = section.querySelectorAll('.products-vedette-v2-filter-btn[data-filter]');
    var playlistItems = Array.prototype.slice.call(section.querySelectorAll('.video-player-v2-playlist-item'));
    var mediaCounter = section.querySelector('#mediaCounter');
    var playlistVisibleCount = section.querySelector('#vpPlaylistVisibleCount');
    var iframeEl = section.querySelector('#mainVideoPlayerIframe');
    var titleEl = section.querySelector('#videoTitle');
    var descEl = section.querySelector('#videoDescription');

    if (!continentSelect || !countrySelect || !provinceSelect || !regionSelect || !playlistItems.length) return;

    function fillSelect(selectEl, items) {
        selectEl.innerHTML = items.map(function (item) {
            return '<option value="' + item.slug + '">' + item.name + '</option>';
        }).join('');
    }

    function getActiveCategory() {
        var active = section.querySelector('.products-vedette-v2-filter-btn.active');
        return active ? active.getAttribute('data-filter') : 'all';
    }

    function getCurrentContinentData() {
        return destinationData.find(function (entry) {
            return entry.continent.slug === continentSelect.value;
        }) || destinationData[0];
    }

    function getCurrentCountryData() {
        var continentData = getCurrentContinentData();
        return continentData.country;
    }

    function getCurrentProvinces() {
        return getCurrentContinentData().provinces || [];
    }

    function getCurrentProvince() {
        var provinces = getCurrentProvinces();
        return provinces.find(function (p) { return p.slug === provinceSelect.value; }) || provinces[0];
    }

    function buildRegionOptions(province) {
        var regionList = (province && province.regions) ? province.regions : [];
        return regionList.map(function (name) {
            return {
                slug: name.toLowerCase().replace(/[’']/g, '').replace(/\s+/g, '-'),
                name: name
            };
        });
    }

    function getVisibleItems() {
        return playlistItems.filter(function (item) {
            return item.style.display !== 'none';
        });
    }

    function playItem(item) {
        if (!item || !iframeEl) return;

        playlistItems.forEach(function (it) { it.classList.remove('active'); });
        item.classList.add('active');

        var src = item.getAttribute('data-src') || '';
        var title = item.getAttribute('data-title') || '';
        var description = item.getAttribute('data-description') || '';

        if (src) {
            iframeEl.src = src;
        }

        if (titleEl) {
            titleEl.textContent = title;
        }
        if (descEl) {
            descEl.textContent = description;
        }

        syncCounters();
    }

    function syncCounters() {
        var visibleItems = getVisibleItems();
        var activeIndex = visibleItems.findIndex(function (item) {
            return item.classList.contains('active');
        });

        if (playlistVisibleCount) {
            playlistVisibleCount.textContent = String(visibleItems.length);
        }

        if (mediaCounter) {
            if (!visibleItems.length) {
                mediaCounter.textContent = '0 / 0';
            } else {
                mediaCounter.textContent = String((activeIndex >= 0 ? activeIndex : 0) + 1) + ' / ' + String(visibleItems.length);
            }
        }
    }

    function applyPlaylistFilters() {
        var country = countrySelect.value;
        var category = getActiveCategory();

        playlistItems.forEach(function (item) {
            var itemCountry = item.getAttribute('data-country') || '';
            var itemCategory = item.getAttribute('data-category') || '';
            var show = (itemCountry === country) && (category === 'all' || itemCategory === category);
            item.style.display = show ? '' : 'none';
            if (!show) {
                item.classList.remove('active');
            }
        });

        var visibleItems = getVisibleItems();
        if (visibleItems.length > 0) {
            playItem(visibleItems[0]);
        }

        syncCounters();
    }

    function refreshRegions() {
        var province = getCurrentProvince();
        var regions = buildRegionOptions(province).slice(0, 5);
        fillSelect(regionSelect, regions);
    }

    function refreshProvinces() {
        var provinces = getCurrentProvinces().map(function (p) {
            return { slug: p.slug, name: p.name };
        }).slice(0, 5);

        fillSelect(provinceSelect, provinces);
        refreshRegions();
    }

    function refreshCountryAndBelow() {
        var country = getCurrentCountryData();
        fillSelect(countrySelect, [{ slug: country.slug, name: country.name }]);
        refreshProvinces();
        applyPlaylistFilters();
    }

    fillSelect(continentSelect, destinationData.map(function (entry) {
        return { slug: entry.continent.slug, name: entry.continent.name };
    }));

    continentSelect.addEventListener('change', refreshCountryAndBelow);
    countrySelect.addEventListener('change', applyPlaylistFilters);
    provinceSelect.addEventListener('change', refreshRegions);

    categoryBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            categoryBtns.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            applyPlaylistFilters();
        });
    });

    playlistItems.forEach(function (item) {
        item.addEventListener('click', function () {
            playItem(item);
            setTimeout(syncCounters, 0);
        });
    });

    refreshCountryAndBelow();
})();
</script>

