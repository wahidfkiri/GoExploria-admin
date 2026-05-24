<nav class="pc-nav" id="pcNav">
    <a href="#accueil" class="pc-nav-logo" aria-label="{{ $siteName }}">
        @if($brandLogo)
            <img class="pc-logo-img" src="{{ $brandLogo }}" alt="{{ $siteName }}">
        @else
            <span class="pc-logo-mark">{{ $initials }}</span>
            <span class="pc-logo-text">
                <span class="pc-logo-name">{{ $siteName }}</span>
                <span class="pc-logo-sub">Appartements · Immobilier</span>
            </span>
        @endif
    </a>
    <ul class="pc-nav-links">
        <li><a href="#accueil">Accueil</a></li>
        <li><a href="#logements">Logements</a></li>
        <li><a href="#galerie">Galerie</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#avis">Avis</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a class="pc-nav-cta" href="#contact">Planifier une visite</a></li>
    </ul>
    <button class="pc-hamburger" id="pcHamburger" type="button" aria-label="Menu">
        <span></span><span></span><span></span>
    </button>
</nav>
<div class="pc-mobile-menu" id="pcMobileMenu">
    <a href="#accueil">Accueil</a>
    <a href="#logements">Logements</a>
    <a href="#galerie">Galerie</a>
    <a href="#services">Services</a>
    <a href="#avis">Avis</a>
    <a href="#contact">Contact</a>
</div>
