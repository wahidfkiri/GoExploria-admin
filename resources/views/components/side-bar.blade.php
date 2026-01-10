<!-- SIDEBAR -->
    <aside class="dashboard-sidebar" id="dashboardSidebar">
        <div class="sidebar-logo">
            <div class="logo-main">
               <img src="{{asset('logo.png')}}" style="width:210px;">
            </div>
            <!-- <div class="logo-sub">Plateforme Builder Web</div> -->
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-title">Navigation</li>
            <li>
                <a href="{{route('dashboard')}}" class="menu-item active">
                    <span class="menu-icon"><i class="fas fa-tachometer-alt"></i></span>
                    <span class="menu-text">Tableau de bord</span>
                </a>
            </li>
            <li>
                <a href="{{route('customers.index')}}" class="menu-item">
                    <span class="menu-icon"><i class="fas fa-users"></i></span>
                    <span class="menu-text">Clients</span>
                </a>
            </li>
            <li>
                <a href="{{route('websites.index')}}" class="menu-item">
                    <span class="menu-icon"><i class="fas fa-globe"></i></span>
                    <span class="menu-text">Sites web</span>
                    <!-- <span class="menu-badge">12</span> -->
                </a>
            </li>
            <li>
                <a href="{{route('templates')}}" class="menu-item">
                    <span class="menu-icon"><i class="fas fa-palette"></i></span>
                    <span class="menu-text">Templates</span>
                    <!-- <span class="menu-badge">5</span> -->
                </a>
            </li>
            
            <li class="menu-title">Contenu</li>
            <li>
                <a href="#" class="menu-item">
                    <span class="menu-icon"><i class="fas fa-images"></i></span>
                    <span class="menu-text">Médias</span>
                </a>
            </li>
            <li>
                <a href="#" class="menu-item">
                    <span class="menu-icon"><i class="fas fa-video"></i></span>
                    <span class="menu-text">Vidéos</span>
                </a>
            </li>
            <!-- <li>
                <a href="#" class="menu-item">
                    <span class="menu-icon"><i class="fas fa-newspaper"></i></span>
                    <span class="menu-text">Articles</span>
                </a>
            </li> -->
            <li>
                <a href="{{route('destinations.index')}}" class="menu-item">
                    <span class="menu-icon"><i class="fas fa-map-marked-alt"></i></span>
                    <span class="menu-text">Destinations</span>
                </a>
            </li>
            
            <!-- <li class="menu-title">E-commerce</li>
            <li>
                <a href="#" class="menu-item">
                    <span class="menu-icon"><i class="fas fa-shopping-cart"></i></span>
                    <span class="menu-text">Boutique</span>
                </a>
            </li> -->
            <!-- <li>
                <a href="#" class="menu-item">
                    <span class="menu-icon"><i class="fas fa-gift"></i></span>
                    <span class="menu-text">Forfaits</span>
                </a>
            </li>
            <li>
                <a href="#" class="menu-item">
                    <span class="menu-icon"><i class="fas fa-tags"></i></span>
                    <span class="menu-text">Promotions</span>
                    <span class="menu-badge">3</span>
                </a>
            </li> -->
            
            <li class="menu-title">Administration</li>
            <li>
                <a href="#" class="menu-item">
                    <span class="menu-icon"><i class="fas fa-users"></i></span>
                    <span class="menu-text">Utilisateurs</span>
                </a>
            </li>
            <li>
                <a href="#" class="menu-item">
                    <span class="menu-icon"><i class="fas fa-chart-line"></i></span>
                    <span class="menu-text">Analytics</span>
                </a>
            </li>
            <li>
                <a href="#" class="menu-item">
                    <span class="menu-icon"><i class="fas fa-cog"></i></span>
                    <span class="menu-text">Paramètres</span>
                </a>
            </li>
            <li>
                <a class="menu-item" href="{{route('logout')}}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
        
                    <span class="menu-icon"><i class="fas fa-sign-out"></i></span>
                    <span class="menu-text">Se déconnecter</span>
                </a>
                 
            </li>
        </ul>
    </aside>