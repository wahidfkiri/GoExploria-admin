{{-- flag-icons CDN --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css">

{{-- Header Component --}}
<header class="header-v2">
    <!-- <div class="header-top">
        <div class="header-contact">
            <a href="mailto:INFOGOEXPLORIA@GMAIL.COM">INFOGOEXPLORIA@GMAIL.COM</a>
        </div>
        <div class="header-promo">
            <span>GO PROMO</span>
        </div>
    </div> -->
    
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
                    <!-- <li class="nav-menu-v2-has-videos" id="videosMenuItem">
                        <a href="#videos">VIDÉOS</a>
                    </li> -->
                    <li><a href="#section-nos-plans">NOS PLANS</a></li>
                    <li><a href="{{ route('contact') }}">CONTACT</a></li>
                    <li><a href="{{ route('inscription') }}">INSCRIPTION</a></li>
                    <li><a href="{{ route('mon-compte') }}" class="nav-account-icon" title="Mon compte" aria-label="Mon compte"><i class="fas fa-user-circle"></i></a></li>
                </ul>
            </div>
            
            @include('home-v2.components.ServicesMegaMenuV2')
            
            <div class="nav-right">
                <a href="javascript:void(0)" class="nav-icon mobile-search-trigger" id="mobileSearchTrigger" aria-label="Recherche">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </a>
                {{-- ── Language Switcher ── --}}
                <div class="lang-switcher" id="langSwitcher">
                    <button class="lang-btn" id="langBtn" aria-label="Sélectionner la langue" aria-expanded="false">
                        <span class="fi fi-fr lang-flag" id="langCurrentFlag"></span>
                        <span class="lang-code" id="langCurrentCode">FR</span>
                        <svg class="lang-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <ul class="lang-dropdown" id="langDropdown" role="listbox">
                        <li class="lang-option lang-active" role="option" data-lang="fr" data-flag="fr" data-code="FR">
                            <span class="fi fi-fr lang-flag"></span>
                            <span class="lang-name">Fran&ccedil;ais</span>
                        </li>
                        <li class="lang-option" role="option" data-lang="en" data-flag="gb" data-code="EN">
                            <span class="fi fi-gb lang-flag"></span>
                            <span class="lang-name">English</span>
                        </li>
                        <li class="lang-option" role="option" data-lang="es" data-flag="es" data-code="ES">
                            <span class="fi fi-es lang-flag"></span>
                            <span class="lang-name">Espa&ntilde;ol</span>
                        </li>
                        <li class="lang-option" role="option" data-lang="de" data-flag="de" data-code="DE">
                            <span class="fi fi-de lang-flag"></span>
                            <span class="lang-name">Deutsch</span>
                        </li>
                        <li class="lang-option" role="option" data-lang="it" data-flag="it" data-code="IT">
                            <span class="fi fi-it lang-flag"></span>
                            <span class="lang-name">Italiano</span>
                        </li>
                        <li class="lang-option" role="option" data-lang="pt" data-flag="pt" data-code="PT">
                            <span class="fi fi-pt lang-flag"></span>
                            <span class="lang-name">Portugu&ecirc;s</span>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('devis') }}" class="nav-icon" aria-label="Devis">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </a>
                <a href="{{ route('favoris') }}" class="nav-icon" aria-label="Favoris">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </a>
                <a href="{{ route('panier') }}" class="nav-icon cart" aria-label="Panier">
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

<script>
    // Déclencheur JS pour le dropdown Vidéos
    (function() {
        const trigger = document.getElementById('videosMenuItem');
        const dropdown = document.getElementById('videosDropdown');
        if (!trigger || !dropdown) return;

        function closeDropdown() {
            dropdown.classList.remove('active');
        }

        // Ouverture/fermeture au survol
        trigger.addEventListener('mouseenter', () => dropdown.classList.add('active'));
        trigger.addEventListener('mouseleave', () => {
            setTimeout(() => {
                if (!dropdown.matches(':hover')) closeDropdown();
            }, 100);
        });
        dropdown.addEventListener('mouseleave', () => closeDropdown());
        dropdown.addEventListener('mouseenter', () => dropdown.classList.add('active'));

        // FERMETURE AUTOMATIQUE dès qu'un lien vidéo est cliqué
        dropdown.addEventListener('click', function(e) {
            const link = e.target.closest('a, button, .video-card, [data-video]');
            if (link) {
                closeDropdown();
            }
        });

        // Fermer si on clique ailleurs sur la page
        document.addEventListener('click', function(e) {
            if (!trigger.contains(e.target) && !dropdown.contains(e.target)) {
                closeDropdown();
            }
        });
    })();

    // ── Language Switcher ──────────────────────────────────────────
    (function() {
        const switcher = document.getElementById('langSwitcher');
        const btn      = document.getElementById('langBtn');
        const dropdown = document.getElementById('langDropdown');
        if (!switcher || !btn || !dropdown) return;

        function open()  { switcher.classList.add('open');    btn.setAttribute('aria-expanded', 'true'); }
        function close() { switcher.classList.remove('open'); btn.setAttribute('aria-expanded', 'false'); }
        function toggle(){ switcher.classList.contains('open') ? close() : open(); }

        btn.addEventListener('click', function(e) { e.stopPropagation(); toggle(); });

        // Sélection d'une langue
        dropdown.querySelectorAll('.lang-option').forEach(function(opt) {
            opt.addEventListener('click', function() {
                dropdown.querySelectorAll('.lang-option').forEach(o => o.classList.remove('lang-active'));
                opt.classList.add('lang-active');
                const flagEl = document.getElementById('langCurrentFlag');
                flagEl.className = 'fi fi-' + opt.dataset.flag + ' lang-flag';
                document.getElementById('langCurrentCode').textContent = opt.dataset.code;
                close();
                // TODO: connecter à la route de changement de locale Laravel
                // window.location.href = '/lang/' + opt.dataset.lang;
            });
        });

        // Fermer si clic à l'extérieur
        document.addEventListener('click', function(e) {
            if (!switcher.contains(e.target)) close();
        });

        // Fermer sur Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') close();
        });
    })();
</script>
