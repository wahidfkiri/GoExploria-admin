<nav class="tl-nav" id="navbar" aria-label="Navigation {{ $siteName }}">
  <div class="nav-inner">
    <a href="#accueil" class="logo">
      @if($brandLogo)
        <img src="{{ $brandLogo }}" alt="{{ $siteName }}">
      @else
        <div class="logo-mark">{{ $initials }}</div>
        <div class="logo-text">{{ $siteShortName }}<span>Espace Forfait</span></div>
      @endif
    </a>
    <div class="nav-links">
      <a href="#services">Services</a>
      <a href="#forfaits">Forfaits</a>
      <a href="#transat">Alpha Europe</a>
      <a href="#itineraire">Itinéraire</a>
      <a href="#galerie">Galerie</a>
      <a href="#avis">Avis</a>
      <a href="#contact">Contact</a>
    </div>
    <div class="nav-cta">
      <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="phone-link"><i class="fa-solid fa-phone"></i> {{ $phone }}</a>
      <a href="#contact" class="btn btn-primary">Réserver</a>
    </div>
    <button type="button" class="hamburger" onclick="toggleMenu()" aria-label="Menu mobile"><span></span><span></span><span></span></button>
  </div>
</nav>
<div class="tl-mobile-menu" id="mobileMenu">
  <a href="#services" onclick="toggleMenu()">Services</a>
  <a href="#forfaits" onclick="toggleMenu()">Forfaits motoneige</a>
  <a href="#transat" onclick="toggleMenu()">Alpha Europe · Transat</a>
  <a href="#itineraire" onclick="toggleMenu()">Itinéraire</a>
  <a href="#hebergement" onclick="toggleMenu()">Hébergement</a>
  <a href="#galerie" onclick="toggleMenu()">Galerie & Instagram</a>
  <a href="#avis" onclick="toggleMenu()">Avis clients</a>
  <a href="#faq" onclick="toggleMenu()">FAQ</a>
  <a href="#contact" onclick="toggleMenu()">Contact & Réservation</a>
</div>
