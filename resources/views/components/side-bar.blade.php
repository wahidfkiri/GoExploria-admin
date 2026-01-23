<aside class="dashboard-sidebar" id="dashboardSidebar">
  <div class="sidebar-logo">
    <div class="logo-main">
      <img src="{{asset('logo.png')}}" style="width:210px;">
    </div>
    <!-- <div class="logo-sub">Plateforme Builder Web</div> -->
  </div>
  <ul class="sidebar-menu">
    <li>
      <a href="{{route('dashboard')}}" class="menu-item active">
        <span class="menu-icon">
          <i class="fas fa-tachometer-alt"></i>
        </span>
        <span class="menu-text">Tableau de bord</span>
      </a>
    </li>
    <li class="has-submenu">
      <a href="#" class="menu-link">
        <span class="menu-icon">
          <i class="fas fa-tasks"></i>
        </span>
        <span class="menu-text">Activités</span>
        <span class="menu-arrow">
          <i class="fas fa-chevron-down"></i>
        </span>
      </a>
      <ul class="submenu">
        <li>
          <a href="{{ route('activities.index') }}" class="submenu-item">
            <span class="submenu-text">Activités</span>
          </a>
        </li>
        <li>
          <a href="{{ route('categories.index') }}" class="submenu-item">
            <span class="submenu-text">Catégories</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="has-submenu">
      <a href="#" class="menu-link">
        <span class="menu-icon">
          <i class="fas fa-building"></i>
        </span>
        <span class="menu-text">Etablissements</span>
        <span class="menu-arrow">
          <i class="fas fa-chevron-down"></i>
        </span>
      </a>
      <ul class="submenu">
        <li>
          <a href="{{ route('etablissements.index') }}" class="submenu-item">
            <span class="submenu-text">liste des établissements</span>
          </a>
        </li>
        <li>
          <a href="{{ route('continents.index') }}" class="submenu-item">
            <span class="submenu-text">rendez vous</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="has-submenu">
      <a href="#" class="menu-link">
        <span class="menu-icon">
          <i class="fas fa-map-marked-alt"></i>
        </span>
        <span class="menu-text">Destinations</span>
        <span class="menu-arrow">
          <i class="fas fa-chevron-down"></i>
        </span>
      </a>
      <ul class="submenu">
        <li>
          <a href="{{ route('continents.index') }}" class="submenu-item">
            <span class="submenu-text">Continents</span>
          </a>
        </li>
        <li>
          <a href="{{ route('countries.index') }}" class="submenu-item">
            <span class="submenu-text">Pays</span>
          </a>
        </li>
        <li>
          <a href="{{ route('provinces.index') }}" class="submenu-item">
            <span class="submenu-text">Provinces</span>
          </a>
        </li>
        <li>
          <a href="{{ route('regions.index') }}" class="submenu-item">
            <span class="submenu-text">Régions</span>
          </a>
        </li>
        <li>
          <a href="{{ route('villes.index') }}" class="submenu-item">
            <span class="submenu-text">Villes</span>
          </a>
        </li>
      </ul>
    </li>
    <!-- <li>
      <a href="{{route('customers.index')}}" class="menu-item">
        <span class="menu-icon">
          <i class="fas fa-users"></i>
        </span>
        <span class="menu-text">Clients</span>
      </a>
    </li> -->
    <!-- <li>
      <a href="{{route('websites.index')}}" class="menu-item">
        <span class="menu-icon">
          <i class="fas fa-globe"></i>
        </span>
        <span class="menu-text">Sites web</span>
      </a>
    </li>
    <li>
      <a href="{{route('templates')}}" class="menu-item">
        <span class="menu-icon">
          <i class="fas fa-palette"></i>
        </span>
        <span class="menu-text">Templates</span>
      </a>
    </li> -->
    <!-- <li class="menu-title">Contenu</li> -->
    <li>
      <a href="#" class="menu-item">
        <span class="menu-icon">
          <i class="fas fa-images"></i>
        </span>
        <span class="menu-text">Médias & Contenus</span>
      </a>
    </li>
    <li>
      <a href="#" class="menu-item">
        <span class="menu-icon">
          <i class="fas fa-newspaper"></i>
        </span>
        <span class="menu-text">Articles</span>
      </a>
    </li>
    <li class="has-submenu">
      <a href="#" class="menu-link">
        <span class="menu-icon">
          <i class="fas fa-users"></i>
        </span>
        <span class="menu-text">Utilisateurs</span>
        <span class="menu-arrow">
          <i class="fas fa-chevron-down"></i>
        </span>
      </a>
      <ul class="submenu">
        <li>
          <a href="{{ route('users.index') }}" class="submenu-item">
            <span class="submenu-text">Utilisateurs</span>
          </a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#" class="menu-item">
        <span class="menu-icon">
          <i class="fas fa-chart-line"></i>
        </span>
        <span class="menu-text">Analytics</span>
      </a>
    </li>
    <li class="has-submenu">
      <a href="#" class="menu-link">
        <span class="menu-icon">
          <i class="fas fa-cog"></i>
        </span>
        <span class="menu-text">Paramètres</span>
        <span class="menu-arrow">
          <i class="fas fa-chevron-down"></i>
        </span>
      </a>
      <ul class="submenu">
        <li>
          <a href="{{ route('settings.pages.index') }}" class="submenu-item">
            <span class="submenu-text">UX Design</span>
          </a>
        </li>
      </ul>
    </li>
    <li>
      <a class="menu-item" href="{{route('logout')}}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
        <span class="menu-icon">
          <i class="fas fa-sign-out"></i>
        </span>
        <span class="menu-text">Se déconnecter</span>
      </a>
    </li>
  </ul>
</aside>