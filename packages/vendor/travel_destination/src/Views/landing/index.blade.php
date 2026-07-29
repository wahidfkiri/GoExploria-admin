<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="{{ $heroSlide?->meta_description ?? 'Découvrez ' . $entity->name }}" />
  <title>{{ $entity->name }} – GoExploria</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Italiana&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
  <link rel="stylesheet" href="{{ asset('vendor/travel-destination/css/travel-destination.css') }}" />
</head>
<body>

<header class="nav" id="navbar" role="banner">
  <div class="nav__container">
    <a href="{{ url('/') }}" class="nav__logo" aria-label="Accueil GoExploria">
      <img src="{{ asset('logo.png') }}" alt="GoExploria" />
    </a>

    <nav class="nav__links" aria-label="Navigation principale">
      @php
        // Type des entités enfants selon la chaîne :
        // Continent → Pays → Provinces → Régions → Secteurs → Villes → Arrondissements → Quartiers
        $childType = match ($normalizedType) {
            'continent' => 'country',
            'country' => 'province',
            'province' => 'region',
            'region' => 'city',
            'secteur' => 'city',
            'city' => 'arrondissement',
            'arrondissement' => 'quartier',
            default => 'city',
        };
        $navSections = [];
        if ($aboutContents->count() > 0) $navSections[] = ['id' => 'about', 'label' => 'À propos'];
        if ($destinations->count() > 0 || $childEntities->count() > 0) $navSections[] = ['id' => 'destinations', 'label' => 'Destinations'];
        if (isset($destinationActivities) && $destinationActivities->count() > 0) $navSections[] = ['id' => 'activities', 'label' => 'Activités'];
        if ($testimonials->count() > 0) $navSections[] = ['id' => 'testimonials', 'label' => 'Témoignages'];
        if ($events->count() > 0) $navSections[] = ['id' => 'events', 'label' => 'Événements'];
        if ($galleryItems->count() > 0) $navSections[] = ['id' => 'gallery', 'label' => 'Galerie'];
        if ($faqs->count() > 0) $navSections[] = ['id' => 'faq', 'label' => 'FAQ'];
        if ($blogs->count() > 0) $navSections[] = ['id' => 'blog', 'label' => 'Blog'];
        if ($contactInfo->count() > 0) $navSections[] = ['id' => 'contact', 'label' => 'Contact'];
        $navSections[] = ['id' => 'map', 'label' => 'Carte'];
      @endphp
      @foreach($navSections as $ns)
        @if($ns['id'] === 'destinations')
          <div class="nav__dropdown-wrap">
            <a href="#{{ $ns['id'] }}" class="nav__link">{{ $ns['label'] }} <span style="font-size:0.6em;margin-left:4px">&#9662;</span></a>
            @if(isset($childEntities) && $childEntities->count() > 0)
              <div class="nav__mega">
                @foreach($childEntities as $ce)
                  <a href="{{ route('travel-destination.show', ['type' => $childType, 'slug' => $ce->slug ?? $ce->id, 'slug2' => Str::slug($ce->name ?? $ce->id)]) }}" class="nav__mega-item">
                    @if($ce->image) <img src="{{ $ce->image }}" alt="{{ $ce->name }}" loading="lazy" />
                    @else <div class="nav__mega-img-placeholder"></div>
                    @endif
                    <span>{{ $ce->name }}</span>
                  </a>
                @endforeach
              </div>
            @endif
          </div>
        @elseif($ns['id'] === 'activities')
          <div class="nav__dropdown-wrap">
            <a href="#activites" class="nav__link">Activités <span style="font-size:0.6em;margin-left:4px">&#9662;</span></a>
            <div class="nav__mega">
              @foreach($destinationActivities as $act)
                <a href="{{ route('activity.show', ['slug' => $act->slug]) }}" class="nav__mega-item nav__mega-item--activity">
                  @if($act->image_url) <img src="{{ $act->image_url }}" alt="{{ $act->name }}" loading="lazy" />
                  @else <div class="nav__mega-img-placeholder nav__mega-img-placeholder--act"></div>
                  @endif
                  <span>{{ $act->name }}</span>
                </a>
              @endforeach
            </div>
          </div>
        @else
          <a href="#{{ $ns['id'] }}" class="nav__link">{{ $ns['label'] }}</a>
        @endif
      @endforeach
    </nav>

    <div class="nav__actions">
      <button class="theme-toggle" id="themeToggle" aria-label="Mode sombre/clair">
        <svg class="theme-toggle__sun" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
        <svg class="theme-toggle__moon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
      </button>
      <button class="nav__search-btn" id="navSearchBtn" aria-label="Ouvrir la recherche">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      </button>
    </div>

    <button class="nav__hamburger" id="hamburger" aria-label="Menu mobile" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>

  <div class="mobile-menu" id="mobileMenu" aria-hidden="true">
    <div class="mobile-menu__inner">
      @foreach($navSections as $ns)
        @if($ns['id'] === 'destinations')
          <div class="mobile-menu__group">
            <a href="#{{ $ns['id'] }}" class="mobile-menu__link mobile-menu__link--parent">{{ $ns['label'] }}</a>
            @if(isset($childEntities) && $childEntities->count() > 0)
              <div class="mobile-menu__sublinks">
                @foreach($childEntities as $ce)
                  <a href="{{ route('travel-destination.show', ['type' => $childType, 'slug' => $ce->slug ?? $ce->id, 'slug2' => Str::slug($ce->name ?? $ce->id)]) }}" class="mobile-menu__link mobile-menu__link--sub">{{ $ce->name }}</a>
                @endforeach
              </div>
            @endif
          </div>
        @elseif($ns['id'] === 'activities')
          <div class="mobile-menu__group">
            <a href="#activites" class="mobile-menu__link mobile-menu__link--parent">Activités</a>
            <div class="mobile-menu__sublinks">
              @foreach($destinationActivities as $act)
                <a href="{{ route('activity.show', ['slug' => $act->slug]) }}" class="mobile-menu__link mobile-menu__link--sub">{{ $act->name }}</a>
              @endforeach
            </div>
          </div>
        @else
          <a href="#{{ $ns['id'] }}" class="mobile-menu__link">{{ $ns['label'] }}</a>
        @endif
      @endforeach
    </div>
  </div>

  <div class="search-overlay" id="searchOverlay" aria-hidden="true">
    <button class="search-overlay__close" id="closeSearch" aria-label="Fermer la recherche">&times;</button>
    <div class="search-overlay__inner">
      <p class="search-overlay__hint">Où souhaitez-vous aller ?</p>
      <input type="text" class="search-overlay__input" placeholder="Rechercher destinations, hôtels, visites…" aria-label="Rechercher" />
      <div class="search-overlay__suggestions">
        @if($childEntities)
          @foreach($childEntities->take(6) as $child)
            <span class="search-tag">{{ $child->name }}</span>
          @endforeach
        @endif
      </div>
    </div>
  </div>
</header>

<section class="hero" id="hero" aria-label="Bannière {{ $entity->name }}">
  <div class="hero__wordmark" aria-hidden="true">{{ strtoupper($entity->name) }}</div>

@php
  $isYouTube = function($url) {
    if (!$url) return false;
    return preg_match('/(youtube\.com|youtu\.be)/i', $url);
  };
  $youTubeEmbed = function($url, $muted = true) {
    if (!$url) return '';
    preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $m);
    $muteParam = $muted ? '1' : '0';
    return isset($m[1]) ? 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=1&mute=' . $muteParam . '&loop=1&playlist=' . $m[1] . '&controls=0&showinfo=0&rel=0&enablejsapi=1' : '';
  };
  $showVideosOnly = $videos->count() > 0;
  $hasMultipleSlides = $showVideosOnly ? $videos->count() > 1 : $heroContents->count() > 1;
@endphp

  <div class="swiper hero-swiper">
    <div class="swiper-wrapper">
      @if($showVideosOnly)
        @foreach($videos as $video)
          @php $videoMuted = $video->video_muted ?? true; @endphp
          <div class="swiper-slide hero__slide hero__slide--video">
            @if($isYouTube($video->video_url))
              <iframe class="hero__video-bg" src="{{ $youTubeEmbed($video->video_url, $videoMuted) }}" frameborder="0" allow="autoplay; encrypted-media" loading="lazy"></iframe>
            @else
              <video class="hero__video-bg" src="{{ $video->video_url }}" autoplay @if($videoMuted) muted @endif loop playsinline loading="lazy"></video>
            @endif
            <div class="hero__click-capture"></div>
            <button class="hero__video-toggle" aria-label="Lecture/Pause">&#10074;&#10074;</button>
            <button class="hero__video-mute" aria-label="Son activé/désactivé"><i class="fas fa-volume-xmark"></i></button>
            <div class="hero__overlay"></div>
            <div class="hero__content">
              @if($video->title || $video->meta_title || $video->content)
                <span class="hero__eyebrow">{{ $video->meta_title ?? 'Vidéo à la une' }}</span>
                <h1 class="hero__title">{{ $video->title ?? $entity->name }}</h1>
                <div class="hero__desc">{!! $video->content ?? '' !!}</div>
                <div class="hero__ctas">
                  @if($video->button_text && $video->button_url)
                    <a href="{{ $video->button_url }}" class="btn btn--amber" rel="noopener">{{ $video->button_text }}</a>
                  @else
                    <a href="#destinations" class="btn btn--amber">Explorer</a>
                  @endif
                </div>
              @endif
            </div>
          </div>
        @endforeach
      @elseif($heroContents->count() > 0)
        @foreach($heroContents as $i => $slide)
          <div class="swiper-slide hero__slide">
            <div class="hero__bg" style="background-image:url('{{ $slide->image_url ?? $entity->image ?? 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1600&q=85' }}')"></div>
            <div class="hero__overlay"></div>
            <div class="hero__content">
              <span class="hero__eyebrow">{{ $slide->meta_title ?? 'Destination à la une' }}</span>
              <h1 class="hero__title">{{ $entity->name }}<br/>@if(isset($entity->country))<em>{{ $entity->country->name }}</em>@endif</h1>
              <div class="hero__desc">{!! $slide->content ?? '' !!}</div>
              <div class="hero__ctas">
                @if($slide->button_text && $slide->button_url)
                  <a href="{{ $slide->button_url }}" class="btn btn--amber" rel="noopener">{{ $slide->button_text }}</a>
                @else
                  <a href="#destinations" class="btn btn--amber">Explorer</a>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      @else
        <div class="swiper-slide hero__slide">
          <div class="hero__bg" style="background-image:url('{{ $entity->image ?? $heroImage ?? 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1600&q=85' }}')"></div>
          <div class="hero__overlay"></div>
          <div class="hero__content">
            <span class="hero__eyebrow">Explorer</span>
            <h1 class="hero__title">{{ $entity->name }}</h1>
            <div class="hero__desc">Découvrez la beauté et les merveilles de {{ $entity->name }}</div>
            <div class="hero__ctas">
              <a href="#destinations" class="btn btn--amber">Explorer</a>
            </div>
          </div>
        </div>
      @endif
    </div>

    @if($hasMultipleSlides)
      <div class="swiper-pagination hero-pagination"></div>
      <div class="swiper-button-prev hero-prev" aria-label="Diapositive précédente"></div>
      <div class="swiper-button-next hero-next" aria-label="Diapositive suivante"></div>
    @endif
  </div>

  @if(count($stats) > 0)
    <div class="hero__stats" aria-label="Statistiques clés">
      @foreach($stats as $i => $stat)
        <div class="hero__stat">
          <span class="hero__stat-num counter" data-target="{{ preg_replace('/[^0-9]/', '', $stat['value']) }}">0</span>
          @if(strpos($stat['value'], '+') !== false)<sup>+</sup>@endif
          <span class="hero__stat-label">{{ $stat['label'] }}</span>
        </div>
        @if(!$loop->last)
          <div class="hero__stat-div"></div>
        @endif
      @endforeach
    </div>
  @endif

</section>

@if($breadcrumb->count() > 1)
  <section class="breadcrumb-section">
    <div class="container">
      <nav class="breadcrumb" aria-label="Fil d'Ariane">
        <ol>
          @foreach($breadcrumb as $i => $crumb)
            <li>
              @if($crumb['url'])
                <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
              @else
                <span aria-current="page">{{ $crumb['label'] }}</span>
              @endif
            </li>
          @endforeach
        </ol>
      </nav>
    </div>
  </section>
@endif

<section class="map-section section" id="map" aria-labelledby="map-heading">
  <div class="container">
    <div class="section-header reveal-up">
      <span class="eyebrow">Explorer</span>
      <h2 class="section-title" id="map-heading">Découvrez les points d'intérêt</h2>
      <p class="section-subtitle">Cliquez sur les marqueurs pour en savoir plus</p>
    </div>
    <div class="map-geo-filter" id="mapGeoFilter">
      <div class="map-geo-filter__wrapper">
        <input type="text" class="map-geo-filter__search" id="mapGeoSearch" placeholder="Rechercher une destination..." autocomplete="off">
        <div class="map-geo-filter__dropdown" id="mapGeoDropdown"></div>
      </div>
    </div>
    <div class="map-filters reveal-up" id="mapFilters">
      <button class="map-filter-btn active" data-filter="all">Tous</button>
    </div>
    <div class="map-wrapper">
      <div id="travel-map" class="travel-map"></div>
    </div>
  </div>
</section>

{{-- Carrousel d'annonces (cards) sous la carte --}}
@include('components.ads-cards', ['adContext' => $normalizedType])

<!-- Map Detail Modal -->
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

@if(isset($ads) && $ads->count() > 0)
  <section class="ads-section section" id="ads" aria-labelledby="ads-heading">
    <div class="container">
      <div class="section-header reveal-up">
        <span class="eyebrow">Sponsorisé</span>
        <h2 class="section-title" id="ads-heading">Publicités</h2>
      </div>
      <div class="ads-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px">
        @foreach($ads as $ad)
          @php
            $isYoutube = $ad->video_url && preg_match('/(youtube\.com|youtu\.be)/i', $ad->video_url);
            $isLocalVideo = $ad->video_url && !$isYoutube && preg_match('/\.(mp4|webm|ogg)$/i', $ad->video_url);
            $ytId = '';
            if ($isYoutube) {
                preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $ad->video_url, $m);
                $ytId = $m[1] ?? '';
            }
          @endphp
          <a href="{{ $ad->destination_url ?? '#' }}" target="{{ $ad->open_new_tab ? '_blank' : '_self' }}" rel="noopener" class="ad-card" style="display:block;background:var(--card-bg);border:1px solid var(--border);border-radius:var(--radius-md);overflow:hidden;transition:all var(--transition);text-decoration:none;color:inherit">
            @if($ad->image_path)
              <img src="{{ $ad->image_path }}" alt="{{ $ad->titre }}" style="width:100%;height:180px;object-fit:cover;display:block" loading="lazy">
            @elseif($isYoutube && $ytId)
              <div style="position:relative;width:100%;height:180px;background:#000;overflow:hidden">
                <img src="https://img.youtube.com/vi/{{ $ytId }}/hqdefault.jpg" alt="{{ $ad->titre }}" style="width:100%;height:100%;object-fit:cover;display:block" loading="lazy">
                <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.25);transition:background 0.3s" onmouseover="this.style.background='rgba(0,0,0,0.4)'" onmouseout="this.style.background='rgba(0,0,0,0.25)'">
                  <i class="fab fa-youtube" style="font-size:44px;color:#ff0000;filter:drop-shadow(0 2px 6px rgba(0,0,0,0.5))"></i>
                </div>
              </div>
            @elseif($isLocalVideo)
              <video src="{{ $ad->video_url }}" style="width:100%;height:180px;object-fit:cover;display:block" muted preload="metadata" onmouseover="this.play()" onmouseout="this.pause();this.currentTime=0"></video>
            @elseif($ad->video_url)
              <div style="width:100%;height:180px;background:var(--navy-3);display:flex;align-items:center;justify-content:center;font-size:14px;color:var(--text-muted)">
                <i class="fas fa-play-circle" style="font-size:40px;margin-right:8px"></i> Vidéo
              </div>
            @endif
            <div style="padding:16px">
              <h3 style="margin:0 0 6px;font-size:15px;font-weight:600;color:var(--text-main)">{{ $ad->titre }}</h3>
              @if($ad->description)
                <p style="margin:0;font-size:13px;color:var(--text-muted);line-height:1.5">{{ \Illuminate\Support\Str::limit($ad->description, 100) }}</p>
              @endif
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </section>
@endif

@if($aboutContents->count() > 0)
  <section class="about-section section" id="about" aria-labelledby="about-heading">
    <div class="container">
      <div class="about-grid">
        <div class="about-content reveal-up">
          <div class="section-header" style="text-align:left">
            <span class="eyebrow">{{ $aboutContents->first()->meta_title ?? 'À propos' }}</span>
            <h2 class="section-title" id="about-heading">{{ $aboutContents->first()->title ?? 'À propos de ' . $entity->name }}</h2>
          </div>
          <div class="about-text">
            {!! $aboutContents->first()->content ?? '' !!}
          </div>
        </div>
        <div class="about-image reveal-up" style="--delay:0.15s">
          <img src="{{ $aboutContents->first()->image_url ?? $entity->image ?? 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=800&q=80' }}" alt="{{ $entity->name }}" loading="lazy" />
        </div>
      </div>
    </div>
  </section>
@endif

@if($destinations->count() > 0 || $childEntities->count() > 0)
  <section class="destinations section" id="destinations" aria-labelledby="dest-heading">
    <div class="container">
      <div class="section-header reveal-up">
        <span class="eyebrow">Explorer</span>
        <h2 class="section-title" id="dest-heading">
          @if($destinations->count() > 0)
            {{ $destinations->first()->title ?? 'Destinations populaires' }}
          @else
            {{ $childEntities->count() > 0 ? 'Explorer ' . $entity->name : 'Destinations populaires' }}
          @endif
        </h2>
        <div class="section-sub">{!! $destinations->first()->content ?? ($childEntities->count() > 0 ? 'Découvrez les meilleurs endroits de ' . $entity->name : 'Des destinations sélectionnées pour vous') !!}</div>
      </div>
      <div class="dest-grid reveal-up" id="destGrid">
        @php $destCount = 0; @endphp
        @if($childEntities->count() > 0)
          @foreach($childEntities as $i => $child)
            @php $destCount++; @endphp
            <article class="dest-card{{ $i >= 3 ? ' dest-card--extra' : '' }}" tabindex="0"{!! $i >= 3 ? ' style="display:none"' : '' !!}>
              <div class="dest-card__img-wrap">
                @if($child->image)
                  <img src="{{ $child->image }}" alt="{{ $child->name }}" loading="lazy" class="dest-card__img" />
                @else
                  <div class="dest-card__img-placeholder"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
                @endif
                <span class="dest-card__badge">{{ $typeLabels[$normalizedType] ?? 'Destination' }}</span>
              </div>
              <div class="dest-card__body">
                <div class="dest-card__meta"><span class="dest-card__country">{{ $entity->name }}</span></div>
                <h3 class="dest-card__name">{{ $child->name }}</h3>
                <div class="dest-card__tags">@if(isset($child->population))<span class="tag">{{ number_format($child->population) }} hab</span>@endif</div>
                <div class="dest-card__footer"><a href="{{ route('travel-destination.show', ['type' => $childType, 'slug' => $child->slug ?? $child->id, 'slug2' => Str::slug($child->name ?? $child->id)]) }}" class="btn btn--sm btn--amber">Explorer</a></div>
              </div>
            </article>
          @endforeach
        @endif
        @if($destinations->count() > 0)
          @foreach($destinations as $i => $dest)
            @php $totalIdx = $destCount + $i; @endphp
            <article class="dest-card{{ $totalIdx >= 3 ? ' dest-card--extra' : '' }}" tabindex="0"{!! $totalIdx >= 3 ? ' style="display:none"' : '' !!}>
              <div class="dest-card__img-wrap">
                @if($dest->image_url)
                  <img src="{{ $dest->image_url }}" alt="{{ $dest->title }}" loading="lazy" class="dest-card__img" />
                @else
                  <div class="dest-card__img-placeholder"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
                @endif</div>
              <div class="dest-card__body">
                <h3 class="dest-card__name">{{ $dest->title }}</h3>
                <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:12px">{{ Str::limit(strip_tags($dest->content ?? ''), 100) }}</p>
              </div>
            </article>
          @endforeach
        @endif
      </div>
      @if(($childEntities->count() + $destinations->count()) > 3)
        <div style="text-align:center;margin-top:24px">
          <button id="showAllDestBtn" class="btn btn--amber" style="cursor:pointer">Afficher tous</button>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
          var btn = document.getElementById('showAllDestBtn');
          if (!btn) return;
          btn.addEventListener('click', function () {
            var showing = btn.getAttribute('data-showing') === '1';
            document.querySelectorAll('.dest-card--extra').forEach(function (el) { el.style.display = showing ? 'none' : ''; });
            btn.textContent = showing ? 'Afficher tous' : 'Afficher moins';
            btn.setAttribute('data-showing', showing ? '0' : '1');
          });
        });
        </script>
      @endif
    </div>
  </section>
@endif

@if($testimonials->count() > 0)
  <section class="testimonials section section--alt" aria-labelledby="test-heading">
    <div class="container">
      <div class="section-header reveal-up">
        <span class="eyebrow">Témoignages</span>
        <h2 class="section-title" id="test-heading">Ce que disent les voyageurs</h2>
      </div>
      <div class="swiper testimonials-swiper reveal-up">
        <div class="swiper-wrapper">
          @foreach($testimonials as $test)
            <div class="swiper-slide">
              <div class="test-card">
                <div class="test-card__stars">{!! str_repeat('★', $test->testimonial_rating ?? 5) !!}</div>
                <div class="test-card__quote">{!! $test->testimonial_content ?? $test->content !!}</div>
                <div class="test-card__author">
                  <img src="{{ $test->image_url ?? 'https://i.pravatar.cc/48?img=' . $loop->index }}" alt="{{ $test->testimonial_name ?? 'Voyageur' }}" />
                  <div>
                    <strong>{{ $test->testimonial_name ?? 'Anonyme' }}</strong>
                    <span>{{ $test->testimonial_role ?? 'Voyageur' }}</span>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="swiper-pagination test-pagination"></div>
      </div>
    </div>
  </section>
@endif

@if($events->count() > 0)
  <section class="events section" aria-labelledby="events-heading">
    <div class="container">
      <div class="section-header reveal-up">
        <span class="eyebrow">Réservez la date</span>
        <h2 class="section-title" id="events-heading">Événements à venir</h2>
      </div>
      <div class="events-grid reveal-up">
        @foreach($events as $event)
          <article class="event-card">
            <div class="event-card__date">
              <span class="event-card__day">{{ $event->event_start_date ? date('d', strtotime($event->event_start_date)) : '--' }}</span>
              <span class="event-card__month">{{ $event->event_start_date ? strtoupper(date('M', strtotime($event->event_start_date))) : '---' }}</span>
            </div>
            <div class="event-card__body">
              <span class="event-card__type">{{ $event->title ?? 'Événement' }}</span>
              <h3 class="event-card__name">{!! $event->content ?? 'Événement' !!}</h3>
              <p class="event-card__location">{{ $event->event_location ? '📍 ' . $event->event_location : '' }}</p>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>
@endif

@if($galleryItems->count() > 0)
@php
  $galleryImages = collect();
  foreach ($galleryItems as $item) {
    $cat = is_string($item->meta_title) ? Str::slug($item->meta_title) : 'all';
    $title = is_string($item->title) ? $item->title : 'Galerie';
    if (!empty($item->extra_data['gallery']) && is_array($item->extra_data['gallery'])) {
      foreach ($item->extra_data['gallery'] as $imgUrl) {
        if (is_string($imgUrl)) {
          $galleryImages->push(['url' => $imgUrl, 'category' => $cat, 'title' => $title]);
        }
      }
    } elseif (is_string($item->image_url)) {
      $galleryImages->push(['url' => $item->image_url, 'category' => $cat, 'title' => $title]);
    }
  }
@endphp
@if($galleryImages->count() > 0)
  <section class="gallery section section--alt" aria-labelledby="gallery-heading">
    <div class="container">
      <div class="section-header reveal-up">
        <span class="eyebrow">Galerie</span>
        <h2 class="section-title" id="gallery-heading">Instants capturés</h2>
      </div>
      <div class="gallery-filters reveal-up">
        <button class="filter-btn active" data-filter="all">Tous</button>
        @foreach($galleryItems->unique('meta_title') as $item)
          @if(is_string($item->meta_title) && $item->meta_title)
            <button class="filter-btn" data-filter="{{ Str::slug($item->meta_title) }}">{{ $item->meta_title }}</button>
          @endif
        @endforeach
      </div>
      <div class="masonry-gallery reveal-up">
        @foreach($galleryImages as $i => $img)
          <div class="masonry-item @if($i === 0)masonry-item--tall @endif @if($i === 3)masonry-item--wide @endif" data-category="{{ $img['category'] }}">
            <img src="{{ $img['url'] }}" alt="{{ $img['title'] }}" loading="lazy" />
            <div class="masonry-item__overlay">
              <button class="lightbox-trigger" data-img="{{ $img['url'] }}" aria-label="Agrandir">&plus;</button>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
@endif
@endif

<div class="lightbox" id="lightbox" hidden>
  <button class="lightbox__close" id="lightboxClose" aria-label="Fermer la visionneuse">&times;</button>
  <button class="lightbox__nav lightbox__nav--prev" id="lightboxPrev" aria-label="Image précédente">&lsaquo;</button>
  <button class="lightbox__nav lightbox__nav--next" id="lightboxNext" aria-label="Image suivante">&rsaquo;</button>
  <div class="lightbox__img-wrap">
    <img id="lightboxImg" src="" alt="Image de la galerie" />
  </div>
</div>

<div class="video-popup" id="videoPopup" hidden>
  <div class="video-popup__backdrop" id="videoBackdrop"></div>
  <div class="video-popup__inner">
    <button class="video-popup__close" id="videoClose" aria-label="Fermer la vidéo">&times;</button>
    <video controls autoplay class="video-popup__video">
      <source src="" type="video/mp4" />
    </video>
  </div>
</div>

@if($faqs->count() > 0)
  <section class="faq-section section" aria-labelledby="faq-heading">
    <div class="container container--narrow">
      <div class="section-header reveal-up">
        <span class="eyebrow">FAQ</span>
        <h2 class="section-title" id="faq-heading">Questions fréquentes</h2>
      </div>
      <div class="faq-list reveal-up">
        @foreach($faqs as $faq)
          <div class="faq-item">
            <button class="faq-question" aria-expanded="false">
              <span>{{ $faq->faq_question ?? $faq->title }}</span>
              <svg class="faq-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
            </button>
            <div class="faq-answer">
              <div>{!! $faq->content ?? $faq->faq_question ?? '' !!}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
@endif

@if($blogs->count() > 0)
  <section class="blog-section section section--alt" id="blog" aria-labelledby="blog-heading">
    <div class="container">
      <div class="section-header reveal-up">
        <span class="eyebrow">Blog</span>
        <h2 class="section-title" id="blog-heading">Derniers articles</h2>
      </div>
      <div class="blog-grid reveal-up">
        @foreach($blogs as $i => $post)
          <article class="blog-card @if($i === 0)blog-card--featured @endif">
            <div class="blog-card__img-wrap">
              <img src="{{ $post->image_url ?? 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=600&q=80' }}" alt="{{ $post->title }}" loading="lazy" />
              <span class="blog-card__cat">{{ $post->blog_category ?? 'Voyage' }}</span>
            </div>
            <div class="blog-card__body">
              <div class="blog-card__meta">{{ $post->published_at ? date('M d, Y', strtotime($post->published_at)) : '' }} &middot; {{ $post->blog_author ?? 'GoExploria' }}</div>
              <h3 class="blog-card__title">{{ $post->title }}</h3>
              <p>{{ $post->blog_excerpt ?? Str::limit(strip_tags($post->content ?? ''), 120) }}</p>
              <a href="#" class="blog-card__link">Lire la suite &rarr;</a>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>
@endif

@if($contactInfo->count() > 0)
  <section class="contact-section section" id="contact" aria-labelledby="contact-heading">
    <div class="container">
      <div class="section-header reveal-up">
        <span class="eyebrow">Prenez contact</span>
        <h2 class="section-title" id="contact-heading">Contactez-nous</h2>
      </div>
      <div class="contact-grid reveal-up">
        <div class="contact-info">
          @foreach($contactInfo as $contact)
            @if($contact->contact_email)
              <div class="contact-detail">
                <span class="contact-detail__icon">&#9993;</span>
                <div>
                  <strong>Email</strong>
                  <p>{{ $contact->contact_email }}</p>
                </div>
              </div>
            @endif
            @if($contact->contact_phone)
              <div class="contact-detail">
                <span class="contact-detail__icon">&#9742;</span>
                <div>
                  <strong>Téléphone</strong>
                  <p>{{ $contact->contact_phone }}</p>
                </div>
              </div>
            @endif
            @if($contact->contact_address)
              <div class="contact-detail">
                <span class="contact-detail__icon">&#9873;</span>
                <div>
                  <strong>Adresse</strong>
                  <p>{{ $contact->contact_address }}</p>
                </div>
              </div>
            @endif
            @if($contact->contact_hours)
              <div class="contact-detail">
                <span class="contact-detail__icon">&#128339;</span>
                <div>
                  <strong>Horaires</strong>
                  <p>{{ $contact->contact_hours }}</p>
                </div>
              </div>
            @endif
          @endforeach
        </div>
        <form class="contact-form" action="{{ url('/contact') }}" method="POST">
          @csrf
          <div class="contact-form__row">
            <input type="text" id="name" name="name" placeholder="Votre nom" required class="contact-form__input" />
            <input type="email" id="email" name="email" placeholder="Votre email" required class="contact-form__input" />
          </div>
          <input type="text" id="subject" name="subject" placeholder="Sujet" class="contact-form__input" />
          <textarea id="message" name="message" placeholder="Votre message" rows="5" required class="contact-form__input contact-form__textarea"></textarea>
          <button type="submit" class="btn btn--amber contact-form__btn">Envoyer</button>
        </form>
      </div>
    </div>
  </section>
@endif

<footer class="footer" role="contentinfo">
  <div class="container">
    <div class="footer__grid">
      <div class="footer__col">
        <h4 class="footer__brand">GoExploria</h4>
        <p>Des expériences de voyage sélectionnées à travers les destinations les plus extraordinaires du monde.</p>
      </div>
      <div class="footer__col">
        <h4>Liens rapides</h4>
        <a href="#destinations">Destinations</a>
        <a href="#tours">Visites</a>
        <a href="#packages">Forfaits</a>
        <a href="#blog">Blog</a>
      </div>
      <div class="footer__col">
        <h4>Assistance</h4>
        <a href="#contact">Contactez-nous</a>
        <a href="#">FAQ</a>
        <a href="#">Politique de confidentialité</a>
        <a href="#">Conditions d'utilisation</a>
      </div>
      <div class="footer__col">
        <h4>Suivez-nous</h4>
        <div class="footer__social">
          <a href="#" class="social-link" aria-label="Facebook">f</a>
          <a href="#" class="social-link" aria-label="Instagram">in</a>
          <a href="#" class="social-link" aria-label="Twitter">x</a>
          <a href="#" class="social-link" aria-label="YouTube">yt</a>
        </div>
      </div>
    </div>
    <div class="footer__bottom">
      <p>&copy; {{ date('Y') }} GoExploria. Tous droits réservés.</p>
    </div>
  </div>
</footer>

<button class="back-to-top" id="backToTop" aria-label="Retour en haut">&uarr;</button>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
<script src="{{ asset('vendor/travel-destination/js/travel-destination.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.hero__video-toggle').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var slide = btn.closest('.hero__slide--video');
      if (!slide) return;
      var iframe = slide.querySelector('iframe.hero__video-bg');
      var video = slide.querySelector('video.hero__video-bg');
      var swiper = window.heroSwiper;
      if (iframe) {
        var paused = btn.getAttribute('data-paused') === '1';
        if (paused) {
          iframe.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
          btn.innerHTML = '&#10074;&#10074;';
          btn.setAttribute('data-paused', '0');
          window.__heroPaused = false;
          if (swiper) swiper.autoplay.start();
        } else {
          iframe.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
          btn.innerHTML = '&#9654;';
          btn.setAttribute('data-paused', '1');
          window.__heroPaused = true;
          if (swiper) swiper.autoplay.stop();
        }
      } else if (video) {
        if (video.paused) {
          video.play();
          btn.innerHTML = '&#10074;&#10074;';
          btn.setAttribute('data-paused', '0');
          window.__heroPaused = false;
          if (swiper) swiper.autoplay.start();
        } else {
          video.pause();
          btn.innerHTML = '&#9654;';
          btn.setAttribute('data-paused', '1');
          window.__heroPaused = true;
          if (swiper) swiper.autoplay.stop();
        }
      }
    });
  });

  // ===== MUTE/UNMUTE VIDEO TOGGLE (global) =====
  document.querySelectorAll('.hero__video-mute').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var muted = btn.getAttribute('data-muted') === '1';
      var newMuted = !muted;
      window.__heroMuted = newMuted;
      document.querySelectorAll('.hero__slide--video').forEach(function (slide) {
        var iframe = slide.querySelector('iframe.hero__video-bg');
        var video = slide.querySelector('video.hero__video-bg');
        if (iframe) {
          iframe.contentWindow.postMessage(newMuted ? '{"event":"command","func":"mute","args":""}' : '{"event":"command","func":"unMute","args":""}', '*');
        } else if (video) {
          video.muted = newMuted;
        }
      });
      var icon = newMuted ? '<i class="fas fa-volume-xmark"></i>' : '<i class="fas fa-volume-high"></i>';
      document.querySelectorAll('.hero__video-mute').forEach(function (b) {
        b.innerHTML = icon;
        b.setAttribute('data-muted', newMuted ? '1' : '0');
      });
    });
  });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var mapEl = document.getElementById('travel-map');
  if (!mapEl) return;

  @php
    $centerLat = is_numeric($entity->latitude) ? (float)$entity->latitude : null;
    $centerLng = is_numeric($entity->longitude) ? (float)$entity->longitude : null;
    if (is_null($centerLat) && isset($childEntities) && $childEntities->count() > 0) {
      $withLat = $childEntities->filter(fn($ce) => is_numeric($ce->latitude));
      if ($withLat->count() > 0) {
        $centerLat = ((float)$withLat->min('latitude') + (float)$withLat->max('latitude')) / 2;
        $centerLng = ((float)$withLat->min('longitude') + (float)$withLat->max('longitude')) / 2;
      }
    }
  @endphp
  var entityLat = {{ $centerLat ?? 0 }};
  var entityLng = {{ $centerLng ?? 0 }};
  var entityName = {!! json_encode($entity->name ?? '', JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};
  var entityType = {!! json_encode($normalizedType, JSON_UNESCAPED_UNICODE) !!};
  var mapPointsUrl = '{{ route("travel-destination.map-points", ["type" => $normalizedType, "slug" => $slug], false) }}';
  var childEntities = {!! json_encode($childEntities->map(function($ce) {
        $typeName = strtolower(class_basename($ce));
        $zMap = ['continent' => 3, 'country' => 5, 'province' => 7, 'region' => 9, 'ville' => 11, 'city' => 11, 'secteur' => 13];
        return ['name' => $ce->name, 'slug' => $ce->slug ?? (string)$ce->id, 'type' => class_basename($ce), 'latitude' => $ce->latitude ? (float)$ce->latitude : null, 'longitude' => $ce->longitude ? (float)$ce->longitude : null, 'zoom' => $zMap[$typeName] ?? 10];
      })->values(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};
  var mapCategories = {!! json_encode($mapCategories->keyBy('slug')->map(function($mc) {
        return ['name' => $mc->name, 'icon_class' => $mc->icon_class, 'color' => $mc->color, 'image' => $mc->image];
      })->toArray(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};
  var serverPoints = {!! json_encode($mapPoints->map(function($p) {
        $img = $p->mainImage ? $p->mainImage->url : ($p->youtube_id ? 'https://img.youtube.com/vi/' . $p->youtube_id . '/hqdefault.jpg' : null);
        return [
          'id' => $p->id,
          'title' => $p->title,
          'description' => $p->description,
          'latitude' => (float)$p->latitude,
          'longitude' => (float)$p->longitude,
          'category' => $p->category,
          'type' => $p->type,
          'adresse' => $p->adresse,
          'ville' => $p->ville,
          'youtube_url' => $p->youtube_url,
          'youtube_id' => $p->youtube_id,
          'thumbnail' => $img,
          'is_featured' => (bool)$p->is_featured,
          'has_details_page' => (bool)$p->has_details_page,
          'views' => $p->views,
          'details' => $p->details ? [
            'long_description' => $p->details->long_description,
            'phone' => $p->details->phone,
            'email' => $p->details->email,
            'website' => $p->details->website,
            'horaires' => $p->details->horaires,
            'services' => $p->details->services,
            'tarifs' => $p->details->tarifs,
            'rating' => (float)$p->details->rating,
            'reviews_count' => $p->details->reviews_count,
            'slug' => $p->details->slug,
          ] : null,
          'images' => $p->images->map(fn($img) => ['url' => $img->url, 'thumbnail' => $img->thumb_url, 'caption' => $img->caption, 'is_main' => (bool)$img->is_main])->toArray(),
        ];
      })->values(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};
  var zoomByType = { continent: 3, country: 5, province: 7, region: 9, ville: 11, city: 11, secteur: 13 };
  var isContinent = entityType === 'continent';
  var defaultZoom = entityLat && !isContinent ? (zoomByType[entityType] || 6) : 2;
  var center = entityLat ? [entityLat, entityLng] : [20, 0];

  var map = L.map('travel-map', {
    center: center,
    zoom: defaultZoom,
    zoomControl: true,
    scrollWheelZoom: true
  });

  var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '\u00a9 <a href="https://openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);
  map.whenReady(function () { map.invalidateSize(); });

  if (entityLat) {
    L.marker([entityLat, entityLng], {
      icon: L.divIcon({
        className: 'map-marker map-marker--main',
        html: '<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>',
        iconSize: [24, 24],
        iconAnchor: [12, 24]
      })
    }).addTo(map).bindPopup('<strong>' + entityName + '</strong>');
  }

  // Regroupement des markers en grappes « +N » : le clic sur une grappe
  // zoome automatiquement sur la zone pour révéler les points individuels.
  function makeMapClusterLayer() {
    if (typeof L.markerClusterGroup !== 'function') return L.layerGroup();
    return L.markerClusterGroup({
      showCoverageOnHover: false,
      maxClusterRadius: 60,
      spiderfyOnMaxZoom: true,
      zoomToBoundsOnClick: true,
      iconCreateFunction: function (cluster) {
        var n = cluster.getChildCount();
        var size = n >= 50 ? 44 : (n >= 20 ? 38 : 32);
        return L.divIcon({
          html: '<div style="width:' + size + 'px;height:' + size + 'px;border-radius:50%;background:linear-gradient(135deg,#F5A623,#e08900);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:' + (n >= 100 ? 13 : 15) + 'px;border:3px solid #fff;box-shadow:0 3px 12px rgba(0,0,0,0.45);cursor:pointer">+' + n + '</div>',
          className: 'marker-cluster-custom',
          iconSize: [size, size],
          iconAnchor: [size / 2, size / 2]
        });
      }
    });
  }
  var markersLayer = makeMapClusterLayer().addTo(map);

  var pointsData = [];
  var currentPointsData = [];
  var geoFilterActive = null;
  var geoFilterEntity = null;

  var childTypeMap = { continent: 'country', country: 'province', province: 'region', region: 'city', city: 'secteur', secteur: '' };
  var childZoomMap = { continent: 3, country: 5, province: 7, region: 9, city: 11, secteur: 13 };
  var childType = childTypeMap[entityType] || '';

  function zoomToEntity(lat, lng, zoom) {
    if (lat !== undefined && lat !== null && lng !== undefined && lng !== null) {
      map.flyTo([lat, lng], zoom || defaultZoom, { duration: 1 });
    }
  }

  var geoSearch = document.getElementById('mapGeoSearch');
  var geoDropdown = document.getElementById('mapGeoDropdown');
  var geoOptions = [];
  if (geoSearch && geoDropdown && childType && childEntities.length) {
    geoOptions = [{ label: 'Tout ' + entityName, value: '', type: '' }].concat(
      childEntities.map(function (ce) { return { label: ce.name, value: ce.slug, type: ce.type }; })
    );
    function renderGeoOptions(filter) {
      geoDropdown.innerHTML = '';
      var match = filter ? filter.toLowerCase() : '';
      geoOptions.forEach(function (opt) {
        if (match && opt.label.toLowerCase().indexOf(match) === -1) return;
        var div = document.createElement('div');
        div.className = 'map-geo-option';
        if (!opt.value && !geoFilterActive) div.classList.add('active');
        else if (opt.value && geoFilterActive && geoFilterActive.slug === opt.value) div.classList.add('active');
        div.textContent = opt.label;
        div.addEventListener('click', function () {
          if (!opt.value) { geoFilterActive = null; geoFilterEntity = null; geoSearch.value = opt.label; zoomToEntity(entityLat, entityLng, defaultZoom); }
          else {
            geoFilterActive = { type: opt.type, slug: opt.value };
            geoSearch.value = opt.label;
            var matched = childEntities.filter(function (ce) { return ce.slug == opt.value; });
            geoFilterEntity = matched.length ? matched[0] : null;
            if (geoFilterEntity && geoFilterEntity.latitude && geoFilterEntity.longitude) {
              zoomToEntity(geoFilterEntity.latitude, geoFilterEntity.longitude, geoFilterEntity.zoom || 10);
            }
          }
          geoDropdown.querySelectorAll('.map-geo-option').forEach(function (o) { o.classList.remove('active'); });
          div.classList.add('active');
          geoDropdown.style.display = 'none';
        });
        geoDropdown.appendChild(div);
      });
    }
    renderGeoOptions('');
    geoSearch.addEventListener('input', function () { renderGeoOptions(this.value); geoDropdown.style.display = 'block'; });
    geoSearch.addEventListener('focus', function () { renderGeoOptions(this.value); geoDropdown.style.display = 'block'; });
    geoSearch.addEventListener('blur', function () { setTimeout(function () { geoDropdown.style.display = 'none'; }, 200); });
    geoSearch.value = geoOptions[0].label;
  }

  function renderPointsOnMap(data) {
    markersLayer.clearLayers();
    pointsData = [];
    currentPointsData = data;
    var bounds = [];
    var categories = {};
    var markerIndex = 0;
    data.forEach(function (p) {
      var cat = p.category || 'other';
      if (!categories[cat]) categories[cat] = true;
      pointsData.push(p);
      var popupHtml = buildPopupHtml(p, markerIndex);
      var marker = L.marker([p.latitude, p.longitude], { icon: getMarkerIcon(p.category, p.is_featured), zIndexOffset: p.is_featured ? 1000 : 0 })
        .addTo(markersLayer)
        .bindPopup(popupHtml, { maxWidth: 320, className: 'map-popup-wrapper' });
      marker._pointIndex = markerIndex;
      markerIndex++;
      bounds.push([p.latitude, p.longitude]);
    });
    if (bounds.length && !isContinent) map.fitBounds(bounds, { padding: [40, 40], maxZoom: 14 });
    rebuildCategoryFilters(categories, data);
  }

  function renderChildEntities() {
    if (!childEntities || !childEntities.length) return;
    markersLayer.clearLayers();
    var bounds = [];
    childEntities.forEach(function (ce) {
      if (!ce.latitude || !ce.longitude) return;
      var marker = L.marker([ce.latitude, ce.longitude], {
        icon: L.divIcon({
          className: 'map-marker map-marker--child',
          html: '<div style="width:22px;height:22px;border-radius:50%;background:var(--amber,#f5a623);display:flex;align-items:center;justify-content:center;box-shadow:0 2px 7px rgba(0,0,0,0.4);border:2px solid #fff;font-size:11px;font-weight:700;color:#000">' + ce.name.charAt(0) + '</div>',
          iconSize: [22, 22],
          iconAnchor: [11, 22]
        })
      }).addTo(markersLayer);
      marker.bindPopup('<strong>' + ce.name + '</strong><br><a href="/travel-destination/' + (childType || 'country') + '/' + ce.slug + '" style="color:var(--amber,#f5a623)">Voir les d\u00e9tails</a>');
      bounds.push([ce.latitude, ce.longitude]);
    });
    if (bounds.length && !isContinent) map.fitBounds(bounds, { padding: [40, 40], maxZoom: 5 });
  }

  function reloadMapPoints() {
    if (serverPoints && serverPoints.length) {
      renderPointsOnMap(serverPoints);
      return;
    }
    fetch(mapPointsUrl)
      .then(function (r) { return r.json(); })
      .then(function (res) {
        if (!res.success || !res.data || !res.data.length) {
          if (geoFilterActive) { markersLayer.clearLayers(); return; }
          renderChildEntities();
          return;
        }
        console.log('Map points received:', res.data.length);
        renderPointsOnMap(res.data);
      })
      .catch(function (err) { console.error('Map reload error:', err); var mapEl = document.getElementById('travel-map'); if (mapEl) mapEl.insertAdjacentHTML('afterend', '<div style="padding:12px;background:#fee;color:#c00;border-radius:8px">Map points failed to load: ' + err.message + '</div>'); });
  }

  function rebuildCategoryFilters(categories, data) {
    var filterEl = document.getElementById('mapFilters');
    if (!filterEl) return;
    filterEl.innerHTML = '<button class="map-filter-btn active" data-filter="all">Tous</button>';
    mapCategories && Object.keys(mapCategories).forEach(function (slug) {
      var cat = mapCategories[slug];
      var btn = document.createElement('button');
      btn.className = 'map-filter-btn';
      btn.setAttribute('data-filter', slug);
      var iconHtml = '';
      if (cat.image) {
        iconHtml = '<img src="' + cat.image + '" alt="" class="map-filter-btn__img" />';
      } else if (cat.icon_class) {
        iconHtml = '<span class="' + cat.icon_class + '" style="color:' + (cat.color || '#e74c3c') + '"></span>';
      }
      btn.innerHTML = iconHtml ? '<span class="map-filter-btn__icon">' + iconHtml + '</span><span class="map-filter-btn__label">' + (cat.name || slug) + '</span>' : (cat.name || slug);
      filterEl.appendChild(btn);
    });
    filterEl.querySelectorAll('.map-filter-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        filterEl.querySelectorAll('.map-filter-btn').forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');
        var filter = btn.getAttribute('data-filter');
        markersLayer.clearLayers();
        data.forEach(function (p, idx) {
          if (filter === 'all' || resolveCategorySlug(p.category) === filter) {
            var marker = L.marker([p.latitude, p.longitude], { icon: getMarkerIcon(p.category, p.is_featured), zIndexOffset: p.is_featured ? 1000 : 0 })
              .addTo(markersLayer)
              .bindPopup(buildPopupHtml(p, idx), { maxWidth: 320, className: 'map-popup-wrapper' });
            marker._pointIndex = idx;
          }
        });
      });
    });
  }

  function youtubeEmbedUrl(youtubeUrl, youtubeId) {
    var id = youtubeId || '';
    if (!id && youtubeUrl) {
      var m = youtubeUrl.match(/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/);
      if (m) id = m[1];
    }
    return id ? 'https://www.youtube.com/embed/' + id + '?autoplay=1' : '';
  }

  function getCategoryData(category) {
    if (!category) return null;
    if (mapCategories[category]) return mapCategories[category];
    var aliasMap = {
      'adventure': 'sport', 'nature': 'natural', 'culture': 'cultural',
      'history': 'historic', 'science': 'museum', 'family': 'entertainment',
      'park': 'parc', 'video_map': 'entertainment'
    };
    var alias = aliasMap[category];
    if (alias && mapCategories[alias]) return mapCategories[alias];
    return null;
  }

  function resolveCategorySlug(category) {
    if (!category) return null;
    if (mapCategories[category]) return category;
    var aliasMap = {
      'adventure': 'sport', 'nature': 'natural', 'culture': 'cultural',
      'history': 'historic', 'science': 'museum', 'family': 'entertainment',
      'park': 'parc', 'video_map': 'entertainment'
    };
    return aliasMap[category] || null;
  }

  function getMarkerIcon(category, featured) {
    var size = featured ? 30 : 24;
    var ring = featured ? 'box-shadow:0 0 0 3px rgba(255,193,7,0.45),0 3px 10px rgba(0,0,0,0.5);border:2px solid #FFC107' : 'box-shadow:0 2px 7px rgba(0,0,0,0.4);border:2px solid #fff';
    var star = featured ? '<span style="position:absolute;top:-5px;right:-5px;width:13px;height:13px;border-radius:50%;background:#FFC107;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(0,0,0,0.4);z-index:2"><svg viewBox="0 0 24 24" width="8" height="8" fill="#fff"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></span>' : '';
    var catData = getCategoryData(category);
    if (catData && catData.image) {
      return L.divIcon({
        className: 'map-marker',
        html: '<div style="width:' + size + 'px;height:' + size + 'px;border-radius:50%;background-size:cover;background-image:url(' + catData.image + ');' + ring + ';position:relative">' + star + '</div>',
        iconSize: [size + 4, size + 4],
        iconAnchor: [(size + 4) / 2, size + 4]
      });
    } else if (catData && catData.icon_class) {
      var color = catData.color || '#e74c3c';
      return L.divIcon({
        className: 'map-marker',
        html: '<div style="width:' + size + 'px;height:' + size + 'px;border-radius:50%;background:' + color + ';display:flex;align-items:center;justify-content:center;' + ring + ';position:relative"><span class="' + catData.icon_class + '" style="font-size:' + Math.round(size * 0.55) + 'px;color:#fff"></span>' + star + '</div>',
        iconSize: [size + 4, size + 4],
        iconAnchor: [(size + 4) / 2, size + 4]
      });
    }
    var colors = { sightseeing: '#e74c3c', museum: '#3498db', restaurant: '#f39c12', hotel: '#2ecc71', adventure: '#9b59b6', shopping: '#1abc9c', default: '#e74c3c' };
    var color = colors[category] || colors.default;
    return L.divIcon({
      className: 'map-marker',
      html: '<div style="width:' + size + 'px;height:' + size + 'px;border-radius:50%;background:' + color + ';display:flex;align-items:center;justify-content:center;' + ring + ';position:relative"><svg viewBox="0 0 24 24" width="' + Math.round(size * 0.6) + '" height="' + Math.round(size * 0.6) + '" fill="#fff"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>' + star + '</div>',
      iconSize: [size + 4, size + 4],
      iconAnchor: [(size + 4) / 2, size + 4]
    });
  }

  function escapeHtml(str) {
    if (!str) return '';
    var d = document.createElement('div');
    d.appendChild(document.createTextNode(str));
    return d.innerHTML;
  }

  function buildPopupHtml(p, idx) {
    var embedUrl = (p.youtube_url || p.youtube_id) ? youtubeEmbedUrl(p.youtube_url, p.youtube_id) : '';
    var html = '<div class="map-popup">';
    if (embedUrl) {
      html += '<div class="map-popup__video">';
      html += '<iframe src="' + embedUrl + '" frameborder="0" allowfullscreen></iframe>';
      html += '</div>';
    }
    html += '<div class="map-popup__body">';
    html += '<h4 class="map-popup__title">' + escapeHtml(p.title) + '</h4>';
    if (p.description) html += '<p class="map-popup__desc">' + escapeHtml(p.description.substring(0, 120)) + '</p>';
    html += '<button class="map-popup__detail-btn" data-index="' + idx + '">Voir détails</button>';
    html += '</div></div>';
    return html;
  }

  reloadMapPoints();

  map.on('popupopen', function (e) {
    var container = e.popup.getElement();
    if (!container) return;
    container.querySelectorAll('.map-popup__detail-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var idx = parseInt(btn.getAttribute('data-index'));
        var point = pointsData[idx];
        if (point) showPlaceModal(point);
      });
    });
  });

  function showPlaceModal(point) {
    var modal = document.getElementById('mapDetailModal');
    var mc = document.getElementById('mapModalMeta');
    if (!modal || !mc) return;
    document.getElementById('map-modal-title').textContent = point.title || 'Details';

    var videoEl = document.getElementById('mapModalVideo');
    var embedModalUrl = (point.youtube_url || point.youtube_id) ? youtubeEmbedUrl(point.youtube_url, point.youtube_id) : '';
    if (videoEl) {
      videoEl.innerHTML = embedModalUrl ? '<iframe src="' + embedModalUrl.replace('?autoplay=1', '?autoplay=0&rel=0') + '" frameborder="0" allowfullscreen></iframe>' : '';
    }

    var descEl = modal.querySelector('.map-modal__description');
    descEl.innerHTML = point.details && point.details.long_description ? point.details.long_description : (point.description || '');
    var metaHtml = '';
    if (point.category) metaHtml += '<span class="map-modal__tag">' + escapeHtml(point.category) + '</span>';
    if (point.city) metaHtml += '<span class="map-modal__tag">' + escapeHtml(point.city) + '</span>';
    if (point.details) {
      if (point.details.rating) metaHtml += '<span class="map-modal__rating">&#9733; ' + point.details.rating + (point.details.reviews_count ? ' (' + point.details.reviews_count + ' avis)' : '') + '</span>';
      if (point.details.phone) metaHtml += '<span class="map-modal__meta-item">&#9742; ' + escapeHtml(point.details.phone) + '</span>';
      if (point.details.email) metaHtml += '<span class="map-modal__meta-item">&#9993; ' + escapeHtml(point.details.email) + '</span>';
      if (point.details.horaires) metaHtml += '<span class="map-modal__meta-item">&#9200; ' + escapeHtml(point.details.horaires) + '</span>';
      if (point.details.tarifs) metaHtml += '<span class="map-modal__meta-item">&#36; ' + escapeHtml(point.details.tarifs) + '</span>';
      if (point.details.services) metaHtml += '<div class="map-modal__services"><strong>Services :</strong> ' + escapeHtml(point.details.services) + '</div>';
    }
    mc.innerHTML = metaHtml;
    var galleryEl = document.getElementById('mapModalGallery');
    galleryEl.innerHTML = '';
    if (point.images && point.images.length) {
      point.images.forEach(function (img) {
        var el = document.createElement('img');
        el.src = img.thumbnail || img.url;
        el.alt = img.caption || '';
        el.loading = 'lazy';
        galleryEl.appendChild(el);
      });
    }
    var websiteLink = document.getElementById('mapModalWebsite');
    if (point.details && point.details.website) {
      websiteLink.href = point.details.website;
      websiteLink.style.display = 'inline-flex';
    } else {
      websiteLink.style.display = 'none';
    }
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
    if (e.key === 'Escape') {
      var modal = document.getElementById('mapDetailModal');
      if (modal && modal.style.display === 'block') closePlaceModal();
    }
  });
});
</script>
{{-- Popup publicitaire rotatif (Ads Manager) --}}
@include('components.ads-popup', ['adContext' => $normalizedType])
</body>
</html>
