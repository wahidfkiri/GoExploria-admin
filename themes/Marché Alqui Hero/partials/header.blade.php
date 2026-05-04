<header>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                @if(has_logo())
                    <img src="{{ get_logo_url() }}" alt="{{ get_site_name() }}" class="logo-img">
                @else
                    <h1>{{ get_site_name() }}</h1>
                @endif
                @if(get_site_slogan())
                    <span>{{ get_site_slogan() }}</span>
                @else
                    <span>Fraîcheur & diversité • Saint-Ambroise</span>
                @endif
            </div>
            
            <div class="menu-toggle" id="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
            
            <div class="nav-links" id="nav-links">
                @foreach(theme_menu('main_menu') as $item)
                    <a href="{{ $item['url'] }}" class="{{ $item['active'] ? 'active' : '' }}">
                        @if($item['icon'])
                            <i class="{{ $item['icon'] }}"></i>
                        @endif
                        {{ $item['label'] }}
                    </a>
                @endforeach
                
                <a href="#contact" class="btn-contact-nav">
                                    <i class="fas fa-phone-alt"></i> Nous joindre
                </a>
            </div>
        </div>
    </nav>
</header>