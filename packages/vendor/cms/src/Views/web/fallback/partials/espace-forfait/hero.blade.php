<section id="accueil">
  <div class="hero-slideshow" id="heroSlideshow">
    @foreach($heroSlides as $index => $slide)
      @php
        $slideUrl = $slide['embed'] ?: $slide['url'];
        $isUploadVideo = preg_match('/\.(mp4|webm|ogg)(\?.*)?$/i', (string) $slideUrl);
        $isIframe = in_array($slide['type'], ['youtube', 'vimeo', 'iframe'], true) || (!empty($slide['embed']) && !$isUploadVideo);
      @endphp
      <div class="hero-slide {{ $index === 0 ? 'active' : '' }}">
        @if($isUploadVideo)
          <video src="{{ $slideUrl }}" autoplay muted loop playsinline></video>
        @elseif($isIframe)
          <iframe src="{{ $slideUrl }}{{ str_contains($slideUrl, '?') ? '&' : '?' }}autoplay=1&mute=1&loop=1&controls=0&playsinline=1" title="{{ $slide['title'] }}" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
        @else
          <img src="{{ $slideUrl }}" alt="{{ $slide['title'] }}">
        @endif
      </div>
    @endforeach
  </div>
  <div class="hero-overlay"></div>
  <div class="hero-snow" id="snowContainer"></div>
  <button class="hero-arrow hero-arrow-prev" onclick="slideshowNav(-1)" aria-label="Précédent">←</button>
  <button class="hero-arrow hero-arrow-next" onclick="slideshowNav(1)" aria-label="Suivant">→</button>
  <div class="hero-slide-caption" id="slideCaption">{{ $heroSlides->first()['caption'] ?? 'Aventure forfait' }}</div>
  <div class="hero-content">
    <h1 class="hero-title">{{ $heroSlides->first()['title'] ?? 'L’aventure hivernale' }} <span class="accent">{{ $siteName }}</span></h1>
    <p class="hero-sub">{{ $heroSlides->first()['subtitle'] ?? $siteDescription }}</p>
    <div class="hero-actions">
      <a href="#reserver" class="btn btn-hero btn-white">Réserver un forfait</a>
      <a href="#services" class="btn btn-hero btn-ghost">Nos services ↓</a>
    </div>
  </div>
  <div class="hero-dots" id="heroDots">
    @foreach($heroSlides as $index => $slide)
      <button class="hero-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})" aria-label="Slide {{ $index + 1 }}"></button>
    @endforeach
  </div>
  <div class="hero-progress"><div class="hero-progress-bar animating" id="heroProgressBar"></div></div>
  <div class="hero-scroll"><div class="scroll-line"></div><span>Défiler</span></div>
</section>
