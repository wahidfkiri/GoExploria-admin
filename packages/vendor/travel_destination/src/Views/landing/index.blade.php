{{-- ==========================================================================
     PAGE DE DESTINATION — template « Carnet d'Atlas »

     Gabarit par défaut de toutes les destinations (continent, pays, province,
     région, secteur, ville, arrondissement, quartier). Le design vient de la
     maquette fournie (Templates/index.html + destination.css) ; la feuille et
     le script sont générés dans public/vendor/travel-destination/ par
     admin/scripts/build_destination_template.py — c'est la MÊME feuille que
     celle du template VvvebJS côté admin, d'où un rendu identique entre
     l'éditeur et le site.

     ⚠ Exigence client : la CARTE est toujours la première section de contenu,
     juste sous la bannière.

     L'ancienne page reste disponible via ?template=classic
     (landing/classic.blade.php).
     ========================================================================== --}}
@php
    use Illuminate\Support\Str;

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

    $typeLabels = [
        'continent' => 'Continent', 'country' => 'Pays', 'province' => 'Province',
        'region' => 'Région', 'secteur' => 'Secteur', 'city' => 'Ville',
        'arrondissement' => 'Arrondissement', 'quartier' => 'Quartier',
    ];
    $childLabel = $typeLabels[$childType] ?? 'Destination';

    $heroTitle = $heroSlide?->title ?: $entity->name;
    $heroEyebrow = $heroSlide?->meta_title ?: ($typeLabels[$normalizedType] ?? 'Destination');
    $heroDesc = $heroSlide?->content
        ?: ($aboutContents->first()?->content
            ? Str::limit(strip_tags($aboutContents->first()->content), 220)
            : 'Découvrez ' . $entity->name . ' : lieux à voir, activités, adresses et bons plans.');
    $heroBg = $heroImage
        ?? $entity->image
        ?? 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?q=80&w=1920&auto=format&fit=crop';

    $lat = is_numeric($entity->latitude ?? null) ? (float) $entity->latitude : null;
    $lng = is_numeric($entity->longitude ?? null) ? (float) $entity->longitude : null;

    // Images de galerie : un contenu « gallery » porte soit un tableau
    // extra_data.gallery, soit une image unique.
    $galleryImages = collect();
    foreach ($galleryItems as $item) {
        $title = is_string($item->title) ? $item->title : 'Galerie';
        if (! empty($item->extra_data['gallery']) && is_array($item->extra_data['gallery'])) {
            foreach ($item->extra_data['gallery'] as $imgUrl) {
                if (is_string($imgUrl)) {
                    $galleryImages->push(['url' => $imgUrl, 'title' => $title]);
                }
            }
        } elseif (is_string($item->image_url)) {
            $galleryImages->push(['url' => $item->image_url, 'title' => $title]);
        }
    }

    // Contenus composés dans l'éditeur visuel. Leur première section est
    // l'emplacement de la carte : la vraie carte étant rendue en tête de page,
    // on retire cet emplacement pour ne pas l'afficher deux fois.
    $stripMapPlaceholder = fn ($html) => preg_replace(
        '/<section\b[^>]*data-gx-destination-map\b[^>]*>.*?<\/section>/is',
        '',
        (string) $html
    );

    $builderBlocks = collect();

    // D'abord LA page de destination : chaque destination en possède une, issue
    // du template « Carnet d'Atlas ». $defaultPage vaut null si l'administrateur
    // l'a masquée ; sinon il porte soit la version personnalisée enregistrée,
    // soit le gabarit rendu à la volée (aucune ligne en base).
    if (! empty($defaultPage)) {
        $builderBlocks->push([
            'slug' => $defaultPage['slug'],
            'css'  => $defaultPage['css'],
            'html' => $stripMapPlaceholder($defaultPage['html']),
        ]);
    }

    // Puis les pages visuelles ajoutées à côté.
    foreach ($builderPages ?? [] as $page) {
        $builderBlocks->push([
            'slug' => $page->slug,
            'css'  => (string) $page->css_content,
            'html' => $stripMapPlaceholder($page->html_content),
        ]);
    }

    // Ancres du menu : seules les sections réellement rendues y figurent.
    $navSections = [['id' => 'map', 'label' => 'Carte']];
    if ($aboutContents->count() > 0) $navSections[] = ['id' => 'a-propos', 'label' => 'À propos'];
    if ($childEntities->count() > 0 || $destinations->count() > 0) $navSections[] = ['id' => 'destinations', 'label' => 'Destinations'];
    if ($destinationActivities->count() > 0) $navSections[] = ['id' => 'activites', 'label' => 'Activités'];
    if ($galleryImages->count() > 0) $navSections[] = ['id' => 'galerie', 'label' => 'Galerie'];
    if ($events->count() > 0) $navSections[] = ['id' => 'evenements', 'label' => 'Événements'];
    if ($blogs->count() > 0) $navSections[] = ['id' => 'blog', 'label' => 'Blog'];
    if ($faqs->count() > 0) $navSections[] = ['id' => 'faq', 'label' => 'FAQ'];
    $navSections[] = ['id' => 'contact', 'label' => 'Contact'];

    $childUrl = fn ($child) => route('travel-destination.show', [
        'type' => $childType,
        'slug' => $child->slug ?? $child->id,
        'slug2' => Str::slug($child->name ?? $child->id),
    ]);

    // Bloc contact : utilisé par l'appel à l'action final ET par le pied de page.
    $contact = $contactInfo->first();

    $atlasCss = public_path('vendor/travel-destination/css/destination-atlas.css');
    $atlasJs  = public_path('vendor/travel-destination/js/destination-atlas.js');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $entity->name }} — Guide de destination | GoExploria</title>
  <meta name="description" content="{{ $heroSlide?->meta_description ?? Str::limit(strip_tags($heroDesc), 160) }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css">
  <link rel="stylesheet" href="{{ asset('vendor/travel-destination/css/destination-atlas.css') }}?v={{ @filemtime($atlasCss) ?: '1' }}">

  @if($lat !== null && $lng !== null)
    <script type="application/ld+json">
      {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'TouristDestination',
        'name' => $entity->name,
        'description' => Str::limit(strip_tags($heroDesc), 300),
        'geo' => ['@type' => 'GeoCoordinates', 'latitude' => $lat, 'longitude' => $lng],
      ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
  @endif
</head>
<body>

{{-- ==========================================================================
     EN-TÊTE
     ========================================================================== --}}
<header class="site-header">
  <div class="container">
    {{-- Même logo et même bascule mobile que l'en-tête de la page d'accueil
         (welcome-home/components/Header.blade.php) : <picture> plutôt que deux
         <img> masqués en CSS, le navigateur ne télécharge qu'un fichier. --}}
    <a href="{{ url('/') }}" class="logo" aria-label="{{ __('home-v2.brand.name_upper') }}">
      <picture>
        <source media="(max-width: 992px)" srcset="{{ asset('Logo-mobile.png') }}">
        <img src="{{ asset('logo.png') }}" alt="{{ __('home-v2.brand.name_upper') }}">
      </picture>
    </a>

    <nav class="main-nav" aria-label="Navigation principale">
      @foreach($navSections as $ns)
        <a href="#{{ $ns['id'] }}">{{ $ns['label'] }}</a>
      @endforeach
    </nav>

    <div class="header-actions">
      <button class="theme-toggle" data-theme-toggle aria-label="Changer le thème clair / sombre">
        <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="4.2"/><path d="M12 2.5v2.4M12 19.1v2.4M4.2 4.2l1.7 1.7M18.1 18.1l1.7 1.7M2.5 12h2.4M19.1 12h2.4M4.2 19.8l1.7-1.7M18.1 5.9l1.7-1.7"/></svg>
        <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M20 14.5A8.5 8.5 0 1 1 9.5 4a6.8 6.8 0 0 0 10.5 10.5z"/></svg>
      </button>
      <a href="#contact" class="btn btn-primary btn-sm">
        Planifier mon séjour
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </a>
      <button class="hamburger" aria-label="Ouvrir le menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>

<nav class="mobile-nav" aria-label="Navigation mobile">
  @foreach($navSections as $ns)
    <a href="#{{ $ns['id'] }}">{{ $ns['label'] }}</a>
  @endforeach
  <a href="#contact" class="btn btn-primary">Planifier mon séjour</a>
</nav>

<main>

{{-- ==========================================================================
     BANNIÈRE
     ========================================================================== --}}
<section class="hero destination-hero" id="hero">
  <div class="hero-media">
    <img src="{{ $heroBg }}" alt="{{ $entity->name }}" loading="eager">
  </div>
  <svg class="hero-contour" viewBox="0 0 1440 90" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0 60 C 200 20, 400 90, 620 40 S 1000 70, 1200 30 S 1440 55, 1440 55 V90 H0 Z" fill="none" stroke="currentColor" stroke-width="1"/>
    <path d="M0 75 C 220 35, 420 90, 660 55 S 1020 85, 1220 45 S 1440 70, 1440 70" fill="none" stroke="currentColor" stroke-width="1" opacity=".6"/>
  </svg>
  <div class="hero-inner">
    @if($breadcrumb->count() > 1)
      <nav class="breadcrumb" aria-label="Fil d'Ariane">
        @foreach($breadcrumb as $crumb)
          @if(! $loop->first)<span>/</span>@endif
          @if($crumb['url'])
            <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
          @else
            {{ $crumb['label'] }}
          @endif
        @endforeach
      </nav>
    @endif
    <div class="hero-grid">
      <div>
        <h1 class="hero-title">{{ $heroTitle }}</h1>
        <p class="hero-sub">{!! strip_tags($heroDesc, '<em><strong><br>') !!}</p>
        @if($lat !== null && $lng !== null)
          <div class="hero-locate">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s7-7.4 7-13a7 7 0 1 0-14 0c0 5.6 7 13 7 13z"/><circle cx="12" cy="9" r="2.4"/></svg>
            {{ number_format(abs($lat), 4) }}° {{ $lat >= 0 ? 'N' : 'S' }},
            {{ number_format(abs($lng), 4) }}° {{ $lng >= 0 ? 'E' : 'O' }}
          </div>
        @endif
        <div class="hero-actions">
          <a href="#map" class="btn btn-primary">
            Voir la carte
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </a>
          @if($destinationActivities->count() > 0)
            <a href="#activites" class="btn btn-ghost-light">Voir les activités</a>
          @elseif($childEntities->count() > 0)
            <a href="#destinations" class="btn btn-ghost-light">Explorer {{ $entity->name }}</a>
          @endif
        </div>
      </div>
      @if(count($stats) > 0)
        <div class="hero-meta-panel">
          @foreach($stats as $stat)
            <div class="item"><span>{{ $stat['label'] }}</span><span>{{ $stat['value'] }}</span></div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
  <div class="hero-scroll"><span>Défiler</span><span class="line"></span></div>
</section>

{{-- ==========================================================================
     CARTE — TOUJOURS EN PREMIÈRE POSITION
     ========================================================================== --}}
@include('travel-destination::landing.partials.map-section')

{{-- Carrousel d'annonces (cards) sous la carte --}}
@include('components.ads-cards', ['adContext' => $normalizedType])

{{-- ==========================================================================
     PAGES COMPOSÉES DANS L'ÉDITEUR VISUEL (admin → destination → Éditeur)
     Elles arrivent avec leur CSS, déjà scopé sur .gx-dest-tpl.
     ========================================================================== --}}
@foreach($builderBlocks as $block)
  @if(filled($block['css']))
    <style>{!! $block['css'] !!}</style>
  @endif
  <section class="builder-page-section" id="page-{{ $block['slug'] }}">
    {!! $block['html'] !!}
  </section>
@endforeach

{{-- ==========================================================================
     À PROPOS
     ========================================================================== --}}
@if($aboutContents->count() > 0)
  @php $about = $aboutContents->first(); @endphp
  <section class="intro destination-intro" id="a-propos">
    <div class="container">
      <div class="intro-media reveal">
        <img src="{{ $about->image_url ?? $heroBg }}" alt="{{ $about->title ?? $entity->name }}" loading="lazy">
        <div class="intro-media-tag">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s7-7.4 7-13a7 7 0 1 0-14 0c0 5.6 7 13 7 13z"/><circle cx="12" cy="9" r="2.4"/></svg>
          {{ $entity->name }}
        </div>
      </div>
      <div class="intro-content reveal">
        <span class="eyebrow">{{ $about->meta_title ?? 'L\'essentiel' }}</span>
        <h2>{{ $about->title ?? 'À propos de ' . $entity->name }}</h2>
        {!! $about->content !!}
        @if(count($stats) > 0)
          <div class="intro-stat">
            @foreach(array_slice($stats, 0, 2) as $stat)
              <div>
                <div class="num">{{ $stat['value'] }}</div>
                <div class="label">{{ $stat['label'] }}</div>
              </div>
            @endforeach
          </div>
        @endif
        @if($childEntities->count() > 0)
          <a href="#destinations" class="btn btn-outline">
            Explorer {{ $entity->name }}
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </a>
        @endif
      </div>
    </div>
  </section>
@endif

{{-- ==========================================================================
     INFORMATIONS CLÉS
     ========================================================================== --}}
@if(count($stats) > 0)
  <section class="info-strip destination-info">
    <div class="container">
      <div class="info-grid">
        @foreach($stats as $stat)
          <div class="info-card reveal">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><path d="M12 3a15 15 0 0 1 0 18M3 12h18"/></svg>
            <div class="val">{{ $stat['value'] }}</div>
            <div class="lbl">{{ $stat['label'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
@endif

{{-- ==========================================================================
     DESTINATIONS ENFANTS
     ========================================================================== --}}
@if($childEntities->count() > 0 || $destinations->count() > 0)
  <section class="highlights destination-must-see" id="destinations">
    <div class="container">
      <div class="section-head reveal">
        <span class="eyebrow">Explorer</span>
        <h2>{{ $destinations->first()->title ?? ($childEntities->count() > 0 ? $childLabel . 's de ' . $entity->name : 'Destinations à découvrir') }}</h2>
        @if($destinations->first()?->content)
          <p>{{ Str::limit(strip_tags($destinations->first()->content), 200) }}</p>
        @endif
      </div>
      <div class="card-grid cols-4 reveal-stagger child-grid">
        @foreach($childEntities as $child)
          <article class="poi-card reveal">
            <div class="poi-media">
              <img src="{{ $child->image ?: 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?q=80&w=700&auto=format&fit=crop' }}" alt="{{ $child->name }}" loading="lazy">
              <span class="poi-badge">{{ $childLabel }}</span>
            </div>
            <div class="poi-body">
              <h3>{{ $child->name }}</h3>
              <div class="poi-loc">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s7-7.4 7-13a7 7 0 1 0-14 0c0 5.6 7 13 7 13z"/></svg>
                {{ $entity->name }}
              </div>
              <div class="poi-foot">
                <span class="poi-price">{{ $child->population ? number_format($child->population) . ' hab.' : '' }}</span>
                <a href="{{ $childUrl($child) }}">Explorer <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
              </div>
            </div>
          </article>
        @endforeach
        @foreach($destinations as $dest)
          <article class="poi-card reveal">
            <div class="poi-media">
              <img src="{{ $dest->image_url ?: 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?q=80&w=700&auto=format&fit=crop' }}" alt="{{ $dest->title }}" loading="lazy">
              <span class="poi-badge">Destination</span>
            </div>
            <div class="poi-body">
              <h3>{{ $dest->title }}</h3>
              <p class="poi-desc">{{ Str::limit(strip_tags($dest->content ?? ''), 110) }}</p>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>
@endif

{{-- ==========================================================================
     ACTIVITÉS
     ========================================================================== --}}
@if($destinationActivities->count() > 0)
  <section class="highlights destination-activities" id="activites">
    <div class="container">
      <div class="section-head reveal">
        <span class="eyebrow">À faire sur place</span>
        <h2>Activités à découvrir</h2>
        <p>Des expériences pour tous les rythmes, sélectionnées à {{ $entity->name }}.</p>
      </div>
      <div class="card-grid cols-4 reveal-stagger">
        @foreach($destinationActivities as $activity)
          <article class="poi-card reveal">
            <div class="poi-media">
              <img src="{{ $activity->image_url ?: 'https://images.unsplash.com/photo-1500534623283-312aade485b7?q=80&w=700&auto=format&fit=crop' }}" alt="{{ $activity->name }}" loading="lazy">
              @if($activity->category?->name ?? null)
                <span class="poi-badge">{{ $activity->category->name }}</span>
              @endif
            </div>
            <div class="poi-body">
              <h3>{{ $activity->name }}</h3>
              <div class="poi-loc">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s7-7.4 7-13a7 7 0 1 0-14 0c0 5.6 7 13 7 13z"/></svg>
                {{ $entity->name }}
              </div>
              @if($activity->description ?? null)
                <p class="poi-desc">{{ Str::limit(strip_tags($activity->description), 110) }}</p>
              @endif
              <div class="poi-foot">
                <span class="poi-price">{{ isset($activity->price) && $activity->price ? number_format($activity->price, 2) . ' €' : '' }}</span>
                <a href="{{ route('activity.show', ['slug' => $activity->slug]) }}">Découvrir <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>
@endif

{{-- ==========================================================================
     GALERIE
     ========================================================================== --}}
@if($galleryImages->count() > 0)
  <section class="gallery destination-gallery-masonry" id="galerie">
    <div class="container">
      <div class="section-head reveal">
        <span class="eyebrow">En images</span>
        <h2>{{ $entity->name }} en photos</h2>
      </div>
      <div class="masonry-gallery reveal">
        @foreach($galleryImages as $img)
          <div class="m-item" data-lightbox-src="{{ $img['url'] }}" data-lightbox-alt="{{ $img['title'] }}">
            <img src="{{ $img['url'] }}" alt="{{ $img['title'] }}" loading="lazy">
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Visionneuse partagée par toutes les galeries de la page --}}
  <div class="lightbox">
    <button class="lightbox-close" aria-label="Fermer"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 6l12 12M18 6L6 18"/></svg></button>
    <button class="lightbox-prev" aria-label="Image précédente"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M15 18l-6-6 6-6"/></svg></button>
    <img src="" alt="">
    <button class="lightbox-next" aria-label="Image suivante"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 6l6 6-6 6"/></svg></button>
    <div class="lightbox-counter">1 / 1</div>
  </div>
@endif

{{-- ==========================================================================
     VIDÉOS
     ========================================================================== --}}
@if($videos->count() > 0)
  @php $video = $videos->first(); @endphp
  <section class="video-section destination-video" id="video">
    <div class="container">
      <div class="section-head reveal">
        <span class="eyebrow">Immersion</span>
        <h2>{{ $video->title ?? $entity->name . ' en vidéo' }}</h2>
      </div>
      <div class="video-frame reveal">
        <img src="{{ $video->image_url ?? $heroBg }}" alt="{{ $video->title ?? $entity->name }}" loading="lazy">
        @php
          preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', (string) $video->video_url, $ytMatch);
          $videoType = isset($ytMatch[1]) ? 'youtube' : 'local';
          $videoSrc = isset($ytMatch[1]) ? 'https://www.youtube.com/embed/' . $ytMatch[1] : $video->video_url;
        @endphp
        <button class="play-btn" data-video-play data-video-type="{{ $videoType }}" data-video-src="{{ $videoSrc }}" aria-label="Lancer la vidéo">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
        </button>
        @if($video->content)
          <div class="video-caption">
            <h3>{{ $video->title ?? $entity->name }}</h3>
            <p>{{ Str::limit(strip_tags($video->content), 140) }}</p>
          </div>
        @endif
      </div>
    </div>
  </section>

  <div class="video-modal">
    <div class="modal-inner"></div>
    <button class="video-modal-close" aria-label="Fermer la vidéo"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="16" height="16"><path d="M6 6l12 12M18 6L6 18"/></svg></button>
  </div>
@endif

{{-- ==========================================================================
     ÉVÉNEMENTS
     ========================================================================== --}}
@if($events->count() > 0)
  <section class="highlights destination-events" id="evenements">
    <div class="container">
      <div class="section-head reveal">
        <span class="eyebrow">Agenda</span>
        <h2>Événements à venir</h2>
      </div>
      <div class="card-grid cols-4 reveal-stagger">
        @foreach($events as $event)
          <article class="poi-card reveal">
            <div class="poi-media">
              <img src="{{ $event->image_url ?: 'https://images.unsplash.com/photo-1533105079780-92b9be482077?q=80&w=700&auto=format&fit=crop' }}" alt="{{ $event->title }}" loading="lazy">
              @if($event->event_start_date)
                <span class="poi-badge">
                  {{ \Carbon\Carbon::parse($event->event_start_date)->translatedFormat('d M') }}
                  @if($event->event_end_date && $event->event_end_date !== $event->event_start_date)
                    – {{ \Carbon\Carbon::parse($event->event_end_date)->translatedFormat('d M') }}
                  @endif
                </span>
              @endif
            </div>
            <div class="poi-body">
              <h3>{{ $event->title ?? 'Événement' }}</h3>
              @if($event->event_location)
                <div class="poi-loc">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s7-7.4 7-13a7 7 0 1 0-14 0c0 5.6 7 13 7 13z"/></svg>
                  {{ $event->event_location }}
                </div>
              @endif
              <p class="poi-desc">{{ Str::limit(strip_tags($event->content ?? ''), 110) }}</p>
              <div class="poi-foot">
                <span class="poi-price">
                  {{ $event->event_is_free ? 'Gratuit' : ($event->event_price ? number_format($event->event_price, 2) . ' €' : '') }}
                </span>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>
@endif

{{-- ==========================================================================
     TÉMOIGNAGES
     ========================================================================== --}}
@if($testimonials->count() > 0)
  <section class="slider-section destination-testimonials" id="temoignages">
    <div class="container">
      <div class="gallery-head reveal">
        <div class="section-head" style="margin-bottom:0;">
          <span class="eyebrow">Avis voyageurs</span>
          <h2>Ce que disent nos visiteurs</h2>
        </div>
        <div class="slider-controls">
          <button class="slider-btn slider-prev" aria-label="Précédent"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M15 18l-6-6 6-6"/></svg></button>
          <button class="slider-btn slider-next" aria-label="Suivant"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 6l6 6-6 6"/></svg></button>
        </div>
      </div>
      <div class="slider-viewport reveal" data-slider>
        <div class="slider-track">
          @foreach($testimonials as $test)
            <div class="testimonial-slide">
              <div class="testimonial-stars">
                @for($i = 0; $i < ($test->testimonial_rating ?? 5); $i++)
                  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1z"/></svg>
                @endfor
              </div>
              <p>{{ strip_tags($test->testimonial_content ?? $test->content ?? '') }}</p>
              <div class="testimonial-person">
                <img src="{{ $test->image_url ?? 'https://i.pravatar.cc/96?img=' . ($loop->index + 1) }}" alt="{{ $test->testimonial_name ?? 'Voyageur' }}" loading="lazy">
                <div>
                  <div class="name">{{ $test->testimonial_name ?? 'Anonyme' }}</div>
                  <div class="loc">{{ $test->testimonial_role ?? 'Voyageur' }}</div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>
@endif

{{-- ==========================================================================
     BLOG
     ========================================================================== --}}
@if($blogs->count() > 0)
  <section class="highlights destination-blog" id="blog">
    <div class="container">
      <div class="section-head reveal">
        <span class="eyebrow">Carnet de route</span>
        <h2>Derniers articles</h2>
      </div>
      <div class="card-grid reveal-stagger">
        @foreach($blogs as $post)
          <article class="poi-card reveal">
            <div class="poi-media">
              <img src="{{ $post->image_url ?: 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?q=80&w=700&auto=format&fit=crop' }}" alt="{{ $post->title }}" loading="lazy">
              <span class="poi-badge">{{ $post->blog_category ?? 'Voyage' }}</span>
            </div>
            <div class="poi-body">
              <h3>{{ $post->title }}</h3>
              <p class="poi-desc">{{ $post->blog_excerpt ?? Str::limit(strip_tags($post->content ?? ''), 130) }}</p>
              <div class="poi-foot">
                <span class="poi-price">{{ $post->blog_author ?? 'GoExploria' }}</span>
                <span class="coord">{{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->translatedFormat('d M Y') : '' }}</span>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>
@endif

{{-- ==========================================================================
     PUBLICITÉS
     ========================================================================== --}}
@if(isset($ads) && $ads->count() > 0)
  <section class="ads-strip" id="ads">
    <div class="container">
      <div class="section-head reveal">
        <span class="eyebrow">Sponsorisé</span>
        <h2>Nos partenaires</h2>
      </div>
      <div class="ads-grid reveal-stagger">
        @foreach($ads as $ad)
          <article class="poi-card reveal">
            @if($ad->image_url ?? null)
              <div class="poi-media"><img src="{{ $ad->image_url }}" alt="{{ $ad->title ?? '' }}" loading="lazy"></div>
            @endif
            <div class="poi-body">
              <h3>{{ $ad->title ?? 'Annonce' }}</h3>
              @if($ad->description ?? null)
                <p class="poi-desc">{{ Str::limit(strip_tags($ad->description), 120) }}</p>
              @endif
              @if($ad->target_url ?? null)
                <div class="poi-foot">
                  <a href="{{ $ad->target_url }}" target="_blank" rel="noopener sponsored">
                    En savoir plus <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                  </a>
                </div>
              @endif
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>
@endif

{{-- ==========================================================================
     FAQ
     ========================================================================== --}}
@if($faqs->count() > 0)
  <section class="faq destination-faq" id="faq">
    <div class="container">
      <div class="section-head center reveal">
        <span class="eyebrow">Questions fréquentes</span>
        <h2>Tout savoir avant de partir</h2>
      </div>
      <div class="faq-list reveal">
        @foreach($faqs as $faq)
          <div class="faq-item @if($loop->first) is-open @endif">
            <button class="faq-q"><span>{{ $faq->faq_question ?? $faq->title }}</span><span class="plus"></span></button>
            <div class="faq-a"><div class="faq-a-inner">{!! $faq->content !!}</div></div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
@endif

{{-- ==========================================================================
     CONTACT / APPEL À L'ACTION FINAL
     ========================================================================== --}}
<section class="final-cta destination-final-cta" id="contact">
  <div class="hero-media">
    <img src="{{ $heroBg }}" alt="{{ $entity->name }}" loading="lazy">
  </div>
  <div class="final-cta-inner">
    <span class="eyebrow" style="justify-content:center;color:var(--accent-light);">Prêt pour l'aventure</span>
    <h2>Prêt à découvrir {{ $entity->name }} ?</h2>
    <p>{{ $contact?->contact_message ? strip_tags($contact->contact_message) : 'Composez votre séjour sur mesure : nature, culture, gastronomie et rencontres.' }}</p>
    @if($contact)
      <div class="hero-meta-panel" style="border:0;padding:0;margin-top:1.6em;flex-direction:row;flex-wrap:wrap;justify-content:center;gap:24px;">
        @if($contact->contact_email)<div class="item"><span>Courriel</span><span>{{ $contact->contact_email }}</span></div>@endif
        @if($contact->contact_phone)<div class="item"><span>Téléphone</span><span>{{ $contact->contact_phone }}</span></div>@endif
        @if($contact->contact_address)<div class="item"><span>Adresse</span><span>{{ $contact->contact_address }}</span></div>@endif
        @if($contact->contact_hours)<div class="item"><span>Horaires</span><span>{{ $contact->contact_hours }}</span></div>@endif
      </div>
    @endif
    <div class="final-cta-actions">
      <a href="#map" class="btn btn-primary">
        Explorer la carte
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </a>
      <a href="{{ url('/contact') }}" class="btn btn-ghost-light">Nous écrire</a>
    </div>
  </div>
</section>

</main>

{{-- ==========================================================================
     PIED DE PAGE
     ========================================================================== --}}
<footer class="site-footer">
  <div class="container">
    <div class="footer-top">
      <div class="footer-brand">
        <a href="{{ url('/') }}" class="logo" aria-label="{{ __('home-v2.brand.name_upper') }}">
          <img src="{{ asset('logo.png') }}" alt="{{ __('home-v2.brand.name_upper') }}">
        </a>
        <p>Le guide de référence pour explorer les plus belles destinations, une région à la fois.</p>
      </div>
      <div class="footer-col">
        <h4>Cette page</h4>
        <ul>
          @foreach($navSections as $ns)
            <li><a href="#{{ $ns['id'] }}">{{ $ns['label'] }}</a></li>
          @endforeach
        </ul>
      </div>
      <div class="footer-col">
        <h4>{{ $childLabel }}s</h4>
        <ul>
          @foreach($childEntities->take(5) as $child)
            <li><a href="{{ $childUrl($child) }}">{{ $child->name }}</a></li>
          @endforeach
        </ul>
      </div>
      <div class="footer-col">
        <h4>Fil d'Ariane</h4>
        <ul>
          @foreach($breadcrumb as $crumb)
            <li>
              @if($crumb['url'])<a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
              @else<span>{{ $crumb['label'] }}</span>@endif
            </li>
          @endforeach
        </ul>
      </div>
      <div class="footer-col footer-contact">
        <h4>Contact</h4>
        <ul>
          @if($contact?->contact_address)
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 22s7-7.4 7-13a7 7 0 1 0-14 0c0 5.6 7 13 7 13z"/></svg>{{ $contact->contact_address }}</li>
          @endif
          @if($contact?->contact_phone)
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.7a2 2 0 0 1-.5 2.1L8 9.7a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.5 2.7.6a2 2 0 0 1 1.7 2z"/></svg>{{ $contact->contact_phone }}</li>
          @endif
          <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 4h16v16H4z"/><path d="m22 6-10 7L2 6"/></svg>{{ $contact?->contact_email ?? 'bonjour@goexploria.com' }}</li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; {{ date('Y') }} GoExploria. Tous droits réservés.</span>
      <div class="footer-legal">
        <a href="{{ url('/') }}">Accueil</a>
        <a href="{{ url('/destination') }}">Destinations</a>
      </div>
    </div>
  </div>
</footer>

<script src="{{ asset('vendor/travel-destination/js/destination-atlas.js') }}?v={{ @filemtime($atlasJs) ?: '1' }}"></script>

{{-- Moteur de la carte (Leaflet + grappes, ou Google Maps si une clé existe) --}}
@include('travel-destination::landing.partials.map-scripts')

{{-- Popup publicitaire rotatif (Ads Manager) --}}
@include('components.ads-popup', ['adContext' => $normalizedType])

</body>
</html>
