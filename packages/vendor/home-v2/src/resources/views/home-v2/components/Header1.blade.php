{{-- Header Component --}}
<header class="header-v2" style="
    background-color: var(--navy-dark);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);">
    <div class="header-top">
        <div class="header-contact">
            <a href="mailto:{{ __('home-v2.common.email') }}">{{ __('home-v2.common.email') }}</a>
        </div>
        <div class="header-promo">
            <span>GO PROMO</span>
        </div>
    </div>
    
    <nav class="header-nav">
        <div class="nav-container">
            <div class="nav-left">
                <button class="vertical-menu-v2-trigger" id="openVerticalMenu" aria-label="Menu Principal">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                
                <a href="/" class="logo">
                     <img src="{{ asset('logo.png') }}" alt="GO EXPLORIA">
                </a>
                <a href="#carte-interactive" class="logo-map-link" title="Voir la carte interactive">
                    <img src="{{ asset('header_info/map2.png') }}" alt="Carte Interactive" class="logo-map-icon">
                </a>
            </div>
            
            <div class="nav-center">
                <ul class="nav-menu">
                    <li><a href="#valeurs">NOS VALEURS</a></li>
                    <li class="nav-menu-v2-has-mega" id="servicesMenuItem">
                        <a href="#services">NOS SERVICES</a>
                    </li>
                    <li class="nav-menu-v2-has-videos" id="videosMenuItem">
                        <a href="#videos">VIDÉOS</a>
                        <div class="nav-videos-dropdown" id="videosDropdown">
                            <div class="nav-videos-header">
                                <h3 class="nav-videos-title">Nos Vidéos</h3>
                                <p class="nav-videos-subtitle">Découvrez notre collection de vidéos</p>
                            </div>
                            <div class="nav-videos-list" id="videosDropdownList">
                                {{-- Les vidéos seront chargées dynamiquement --}}
                            </div>
                        </div>
                    </li>
                    <li><a href="#contact">CONTACT</a></li>
                    <li><a href="#inscription">INSCRIPTION</a></li>
                    <li><a href="#compte">MON COMPTE</a></li>
                </ul>
            </div>
            
            @include('home-v2.components.MegaMenu')
            
            <div class="nav-right">
                <a href="#" class="nav-icon" aria-label="Langue">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="2" y1="12" x2="22" y2="12"></line>
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                    </svg>
                </a>
                <a href="#" class="nav-icon" aria-label="Devis">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </a>
                <a href="#" class="nav-icon" aria-label="Favoris">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </a>
                <a href="#" class="nav-icon cart" aria-label="Panier">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </nav>
</header>

