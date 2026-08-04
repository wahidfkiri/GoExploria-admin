{{-- flag-icons CDN --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css">
<link rel="stylesheet" href="{{ asset('css/home-v2/services-mega-menu-v2.css') }}">

@php
    $supportedLocales = [
        'fr' => ['flag' => 'fr', 'code' => 'FR', 'label' => __('home-v2.language.fr')],
        'en' => ['flag' => 'gb', 'code' => 'EN', 'label' => __('home-v2.language.en')],
        'es' => ['flag' => 'es', 'code' => 'ES', 'label' => __('home-v2.language.es')],
        'de' => ['flag' => 'de', 'code' => 'DE', 'label' => __('home-v2.language.de')],
        'it' => ['flag' => 'it', 'code' => 'IT', 'label' => __('home-v2.language.it')],
    ];
    $currentLocale = app()->getLocale();
    if (! array_key_exists($currentLocale, $supportedLocales)) {
        $currentLocale = 'fr';
    }
    $currentLanguage = $supportedLocales[$currentLocale];
    $headerVideoChannelUrl = \Illuminate\Support\Facades\Route::has('cms.videos.channel')
        ? route('cms.videos.channel')
        : url('/chaine-videos');
@endphp

{{-- Header Component --}}
<header class="header-v2">
    <!-- <div class="header-top">
        <div class="header-contact">
            <a href="mailto:{{ __('home-v2.common.email') }}">{{ __('home-v2.common.email') }}</a>
        </div>
        <div class="header-promo">
            <span>GO PROMO</span>
        </div>
    </div> -->
    
    <nav class="header-nav">
        <div class="nav-container">
            <div class="nav-left">
                <button class="vertical-menu-v2-trigger menu-toggle" id="openVerticalMenu" aria-label="Menu Principal">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                
                <a href="/" class="logo">
                    {{-- Logo dédié au mobile. <picture> plutôt que deux <img>
                         masqués en CSS : le navigateur ne télécharge qu'un seul
                         fichier. Le palier 992 px est celui où le header bascule
                         déjà en mise en page mobile (cf. styles.css).
                         display:block en ligne car la règle vit dans deux
                         feuilles distinctes, dont un bundle généré. --}}
                    <picture style="display:block;">
                        <source media="(max-width: 992px)" srcset="{{ asset('Logo-mobile.png') }}">
                        <img src="{{ asset('logo.png') }}" alt="{{ __('home-v2.brand.name_upper') }}">
                    </picture>
                </a>
                <a href="#section-carte-amerique-nord" class="logo-map-link" title="Voir la carte interactive">
                    <img src="{{ asset('header_info/map2.png') }}" alt="Carte Interactive" class="logo-map-icon">
                </a>
            </div>
            
            <div class="nav-center">
                <ul class="nav-menu">
                    <li><a href="{{ route('valeurs') }}">{{ __('home-v2.header.menu.values') }}</a></li>
                    <li class="nav-menu-v2-has-mega" id="servicesMenuItem">
                        <a href="#services">{{ __('home-v2.header.menu.services') }}</a>
                    </li>
                    <!-- <li class="nav-menu-v2-has-videos" id="videosMenuItem">
                        <a href="#videos">VIDÃ‰OS</a>
                    </li> -->
                    <li>
                        <a href="{{ $headerVideoChannelUrl }}" class="nav-video-channel-link" target="_blank" rel="noopener noreferrer">
                            <i class="fas fa-video" aria-hidden="true"></i>
                            <span>Chaîne vidéos</span>
                        </a>
                    </li>
                    <li class="nav-menu-v2-has-plans" style="display:none" id="plansMenuItem">
                        <a href="#section-nos-plans" id="plansMenuTrigger">{{ __('home-v2.header.menu.plans') }}</a>
                    </li>
                    <li><a href="{{ route('contact') }}">{{ __('home-v2.header.menu.contact') }}</a></li>
                    <li><a href="{{ route('mon-compte') }}" class="nav-account-icon" title="{{ __('home-v2.common.account') }}" aria-label="{{ __('home-v2.common.account') }}"><i class="fas fa-user-circle"></i>Activer Mon Compte</a></li>
                </ul>
            </div>
            
            @include('home-v2.components.ServicesMegaMenuV2')
            @include('home-v2.components.PlansMegaMenu')
            
            <div class="nav-right">
                <a href="javascript:void(0)" class="nav-icon mobile-search-trigger" id="mobileSearchTrigger" aria-label="{{ __('home-v2.common.search') }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </a>
                <a href="{{ route('devis') }}" class="nav-devis-btn" target="_blank" rel="noopener noreferrer" aria-label="Demander un devis">
                    <i class="fas fa-file-signature" aria-hidden="true"></i>
                    <span>AFFICHEZ VOUS</span>
                </a>
                {{-- â€”â€” Language Switcher â€”â€” --}}
                <div class="lang-switcher" id="langSwitcher">
                    <button class="lang-btn" id="langBtn" aria-label="{{ __('home-v2.language.select') }}" aria-expanded="false">
                        <span class="fi fi-{{ $currentLanguage['flag'] }} lang-flag" id="langCurrentFlag"></span>
                        <span class="lang-code" id="langCurrentCode">{{ $currentLanguage['code'] }}</span>
                        <svg class="lang-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <ul class="lang-dropdown" id="langDropdown" role="listbox">
                        @foreach ($supportedLocales as $localeCode => $localeData)
                            <li class="lang-option {{ $localeCode === $currentLocale ? 'lang-active' : '' }}" role="option" data-lang="{{ $localeCode }}" data-flag="{{ $localeData['flag'] }}" data-code="{{ $localeData['code'] }}">
                                <span class="fi fi-{{ $localeData['flag'] }} lang-flag"></span>
                                <span class="lang-name">{{ $localeData['label'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <a href="{{ route('favoris') }}" class="nav-icon" aria-label="{{ __('home-v2.common.favorites') }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </a>
                <a href="{{ route('panier') }}" class="nav-icon cart" aria-label="{{ __('home-v2.common.cart') }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <!-- <span class="cart-badge">0</span> -->
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

        // Fermeture automatique dÃ¨s qu'un lien vidÃ©o est cliquÃ©
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

    // â€”â€” Language Switcher â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”â€”
    (function() {
        const switcher = document.getElementById('langSwitcher');
        const btn = document.getElementById('langBtn');
        const dropdown = document.getElementById('langDropdown');
        if (!switcher || !btn || !dropdown) return;

        function open() { switcher.classList.add('open'); btn.setAttribute('aria-expanded', 'true'); }
        function close() { switcher.classList.remove('open'); btn.setAttribute('aria-expanded', 'false'); }
        function toggle() { switcher.classList.contains('open') ? close() : open(); }

        btn.addEventListener('click', function(e) { e.stopPropagation(); toggle(); });

        // SÃ©lection d'une langue
        dropdown.querySelectorAll('.lang-option').forEach(function(opt) {
            opt.addEventListener('click', function() {
                dropdown.querySelectorAll('.lang-option').forEach(function(o) { o.classList.remove('lang-active'); });
                opt.classList.add('lang-active');

                const flagEl = document.getElementById('langCurrentFlag');
                flagEl.className = 'fi fi-' + opt.dataset.flag + ' lang-flag';
                document.getElementById('langCurrentCode').textContent = opt.dataset.code;

                close();

                const targetUrl = '{{ route('locale.switch', ['locale' => '__LOCALE__']) }}'.replace('__LOCALE__', opt.dataset.lang);
                window.location.href = targetUrl + '?redirect=' + encodeURIComponent(window.location.href);
            });
        });

        // Fermer si clic Ã  l'extÃ©rieur
        document.addEventListener('click', function(e) {
            if (!switcher.contains(e.target)) close();
        });

        // Fermer sur Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') close();
        });
    })();
</script>
