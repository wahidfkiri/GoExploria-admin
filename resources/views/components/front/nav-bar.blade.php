<nav class="navbar navbar-expand-lg navbar-light main-navbar">
    <div class="container">
        <a class="navbar-brand" href="/fr/">
            <div class="site-logo">
                <img src="https://www.goexploria.com/images/logo-go-exploria-qc-3.png" alt="GoExploria" class="logo-img">
                <div class="logo-text">
                    <span class="logo-title">GoExploria</span>
                    <span class="logo-subtitle">Affaires</span>
                </div>
            </div>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav mx-auto">
                <!-- Menu Explorer Région -->
                <li class="nav-item dropdown position-static">
                    <a class="nav-link dropdown-toggle" href="#" id="explorerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-map-marked-alt me-1"></i>Explorer Région
                    </a>
                    
                    <!-- Mega Menu Statique des Régions -->
                    <div class="regions-mega-menu" aria-labelledby="explorerDropdown">
                        <div class="container">
                            <div class="region-grid">
                                @foreach(\App\Models\Continent::active()->get() as $continent)
                                <div class="region-card">
                                    <a href="#" class="region-link">
                                        <img src="{{asset('storage/continents')}}/{{$continent->image}}" 
                                             alt="Québec" 
                                             class="region-image">
                                        <div class="region-content">
                                            <h4 class="region-title">
                                                <i class="fas fa-map-marker-alt"></i> {{$continent->name}}
                                            </h4>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </li>
                
                <!-- Menu GO Explorez -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        <i class="fas fa-concierge-bell me-1"></i> GO Explorez
                    </a>
                    <div class="dropdown-menu full-width" aria-labelledby="servicesDropdown">
    <div class="container">
        <div class="row" style="padding-right:50px;padding-left:50px;">
            @php
                $types = \App\Models\CategorieType::with(['categories.activities'])->get();
                $chunkSize = ceil($types->count() / 3);
                $chunks = $types->chunk($chunkSize);
            @endphp
            
            @foreach($chunks as $chunk)
            <div class="col-md-4">
                @foreach($chunk as $type)
                <div class="dropdown-submenu">
                    <a class="dropdown-item has-submenu" href="#" data-bs-toggle="dropdown" data-bs-auto-close="false">
                        {{ $type->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <!-- Catégories pour ce type -->
                        @if($type->categories && $type->categories->count() > 0)
                            @foreach($type->categories as $category)
                            <li class="dropdown-submenu">
                                <a class="dropdown-item has-submenu" href="#" data-bs-toggle="dropdown" data-bs-auto-close="false">
                                    <i class="fas fa-tag me-2"></i>{{ $category->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- Activités pour cette catégorie -->
                                    @if($category->activities && $category->activities->count() > 0)
                                        @foreach($category->activities as $activity)
                                        @if($activity)
                                        <li>
                                            <a class="dropdown-item" href="{{ url('activities.show', $activity->slug) }}">
                                                <i class="fas fa-star me-2"></i>{{ $activity->name }}
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</div>
                </li>
            </ul>
            
            <div class="special-buttons d-flex">
                <a href="https://www.goexploria.com/company/68620/go-exploria-plans-de-relance" class="btn btn-primary">
                    <i class="fas fa-seedling btn-icon"></i> Plans de relance
                </a>
                <a href="https://www.goexploria.com/company/68619/go-exploria-services-web" class="btn btn-secondary">
                    <i class="fas fa-globe btn-icon"></i> Services web
                </a>
            </div>
        </div>
    </div>
</nav>

<style>
/* Styles pour le mega menu des régions */
.regions-mega-menu {
    position: absolute;
    left: 0;
    top: 100%;
    width: 100%;
    background: white;
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    border-radius: 0 0 12px 12px;
    padding: 30px 0;
    z-index: 1000;
    display: none;
    opacity: 0;
    transform: translateY(-10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
    border-top: 3px solid #3498db;
    max-height: 80vh;
    overflow-y: auto;
}

.regions-mega-menu.active {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

.region-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.region-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
    height: 100%;
}

.region-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    border-color: #3498db;
}

.region-image {
    height: 140px;
    width: 100%;
    object-fit: cover;
}

.region-content {
    padding: 15px;
}

.region-title {
    font-size: 1rem;
    font-weight: 600;
    color: #333;
    margin: 0;
    text-align: center;
}

.region-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.region-link:hover {
    color: inherit;
}

.region-list {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-top: 25px;
    padding-top: 25px;
    border-top: 1px solid #eee;
}

.region-list-item {
    padding: 8px 0;
}

.region-list-item a {
    color: #555;
    text-decoration: none;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
}

.region-list-item a:hover {
    color: #3498db;
}

.region-list-item i {
    margin-right: 8px;
    color: #3498db;
}
/* Amélioration du positionnement des sous-menus */
.dropdown-menu .dropdown-menu {
    position: absolute;
    left: 100% !important;
    top: 0 !important;
    margin-top: -1px;
    margin-left: 0;
}

/* Empêcher le décalage sur mobile */
@media (max-width: 991.98px) {
    .dropdown-menu .dropdown-menu {
        position: static !important;
        left: auto !important;
        top: auto !important;
        margin-left: 20px;
    }
}

/* S'assurer que le sous-menu reste visible */
.dropdown-submenu:hover > .dropdown-menu {
    display: block;
    opacity: 1;
    transform: translateY(0);
}
/* Styles pour les sous-menus dropdown */
.dropdown-menu .dropdown-menu {
    position: absolute;
    left: 100%;
    top: 0;
    margin-top: -1px;
    margin-left: 0;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    min-width: 220px;
    display: none;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    border-top: 3px solid #3498db;
}

.dropdown-menu .dropdown-menu.show {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

/* Style pour les sous-menus de niveau 3 */
.dropdown-menu .dropdown-menu .dropdown-menu {
    left: 100%;
    top: 0;
}

/* Pour les sous-menus à gauche sur mobile */
@media (max-width: 991.98px) {
    .dropdown-menu .dropdown-menu {
        position: static;
        left: 0;
        margin-left: 20px;
        box-shadow: none;
        border: none;
        border-left: 2px solid #eee;
    }
    
    .dropdown-menu .dropdown-menu .dropdown-menu {
        margin-left: 20px;
    }
}

/* Styles pour les items avec sous-menu */
.dropdown-item.has-submenu {
    position: relative;
    padding-right: 40px;
}

.dropdown-item.has-submenu::after {
    content: '\f054';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.8rem;
    color: #6c757d;
}

/* Style pour les sous-items */
.dropdown-menu .dropdown-item {
    padding: 8px 20px 8px 40px;
    font-size: 0.9rem;
    border-left: 3px solid transparent;
    transition: all 0.2s ease;
}

.dropdown-menu .dropdown-item:hover {
    background-color: #f8f9fa;
    border-left-color: #3498db;
    padding-left: 45px;
}

/* Pour les sous-items niveau 3 */
.dropdown-menu .dropdown-menu .dropdown-item {
    padding-left: 50px;
}

.dropdown-menu .dropdown-menu .dropdown-item:hover {
    padding-left: 55px;
}

/* Container pour les sous-menus */
.dropdown-submenu {
    position: relative;
}

/* Style pour le menu principal */
.full-width {
    width: 800px;
    max-width: 90vw;
}

.dropdown-header {
    font-size: 0.85rem;
    font-weight: 600;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 15px;
    margin-bottom: 10px;
}

.dropdown-item {
    padding: 10px 20px;
    border-radius: 5px;
    margin: 2px 5px;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-item .small {
    font-size: 0.8rem;
    line-height: 1.3;
}

/* Animation pour l'ouverture des sous-menus */
@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(-10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.dropdown-menu .dropdown-menu.show {
    animation: slideInRight 0.2s ease forwards;
}

/* Animation pour le mega menu */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.regions-mega-menu.active {
    animation: fadeInDown 0.3s ease forwards;
}

/* Gestion du dropdown Bootstrap */
.dropdown:hover .regions-mega-menu,
.dropdown:hover .dropdown-menu.full-width {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

/* Pour mobile, utiliser le toggle Bootstrap */
@media (max-width: 992px) {
    .dropdown:hover .regions-mega-menu,
    .dropdown:hover .dropdown-menu.full-width {
        display: none;
    }
    
    .dropdown.show .regions-mega-menu,
    .dropdown.show .dropdown-menu.full-width {
        display: block;
    }
}

/* Responsive styles */
@media (max-width: 1200px) {
    .region-grid {
        grid-template-columns: repeat(4, 1fr);
    }
    
    .region-list {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 992px) {
    .regions-mega-menu {
        position: static;
        box-shadow: none;
        border-radius: 0;
        padding: 20px 15px;
        display: none;
        max-height: none;
        overflow-y: visible;
    }
    
    .regions-mega-menu.active {
        display: block;
    }
    
    .region-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }
    
    .region-image {
        height: 120px;
    }
    
    .region-list {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .full-width {
        width: 100%;
    }
    
    .dropdown-menu {
        border: none;
        box-shadow: none;
    }
}

@media (max-width: 768px) {
    .region-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .region-list {
        grid-template-columns: 1fr;
    }
    
    .region-image {
        height: 100px;
    }
}

@media (max-width: 576px) {
    .region-grid {
        grid-template-columns: 1fr;
    }
    
    .region-image {
        height: 140px;
    }
}
</style>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    // Gérer les mega menus
    initMegaMenus();
    
    // Gérer les sous-menus
    initSubmenus();
    
    // Gérer le comportement hover pour desktop
    initHoverBehavior();
});

// Gérer les mega menus (Explorer Région)
function initMegaMenus() {
    const explorerDropdown = document.getElementById('explorerDropdown');
    const regionsMegaMenu = document.querySelector('.regions-mega-menu');
    
    // Gestion hover pour desktop
    if (window.innerWidth > 992) {
        const dropdownItem = explorerDropdown.closest('.dropdown');
        
        dropdownItem.addEventListener('mouseenter', function() {
            regionsMegaMenu.classList.add('active');
        });
        
        dropdownItem.addEventListener('mouseleave', function(e) {
            if (!regionsMegaMenu.contains(e.relatedTarget) && !explorerDropdown.contains(e.relatedTarget)) {
                regionsMegaMenu.classList.remove('active');
            }
        });
        
        regionsMegaMenu.addEventListener('mouseleave', function(e) {
            if (!dropdownItem.contains(e.relatedTarget)) {
                regionsMegaMenu.classList.remove('active');
            }
        });
    }
    
    // Gestion responsive
    window.addEventListener('resize', function() {
        if (window.innerWidth <= 992) {
            regionsMegaMenu.classList.remove('active');
        }
    });
}

// Gérer les sous-menus (GO Explorez)
// Gérer les sous-menus (GO Explorez)
function initSubmenus() {
    // Tous les éléments avec sous-menu
    const submenuToggles = document.querySelectorAll('.dropdown-item.has-submenu');
    
    submenuToggles.forEach(toggle => {
        // Empêcher le comportement par défaut du clic
        toggle.addEventListener('click', function(e) {
            if (window.innerWidth > 991.98) {
                // Sur desktop, empêcher le clic de fermer
                e.preventDefault();
                e.stopPropagation();
                
                const submenu = this.nextElementSibling;
                if (submenu && submenu.classList.contains('dropdown-menu')) {
                    // Fermer tous les autres sous-menus
                    const allOpenSubmenus = document.querySelectorAll('.dropdown-menu .dropdown-menu.show');
                    allOpenSubmenus.forEach(menu => {
                        if (menu !== submenu) {
                            menu.classList.remove('show');
                        }
                    });
                    
                    // Ouvrir/fermer le sous-menu courant
                    submenu.classList.toggle('show');
                    
                    // Positionner correctement le sous-menu
                    if (submenu.classList.contains('show')) {
                        const rect = this.getBoundingClientRect();
                        submenu.style.top = '0';
                        submenu.style.left = '100%';
                    }
                }
            }
            // Sur mobile, laisser Bootstrap gérer
        });
        
        // Gestion hover pour desktop
        if (window.innerWidth > 991.98) {
            toggle.addEventListener('mouseenter', function() {
                const submenu = this.nextElementSibling;
                if (submenu && submenu.classList.contains('dropdown-menu')) {
                    submenu.classList.add('show');
                    submenu.style.top = '0';
                    submenu.style.left = '100%';
                }
            });
            
            toggle.addEventListener('mouseleave', function(e) {
                // Retarder la fermeture pour permettre le déplacement vers le sous-menu
                setTimeout(() => {
                    const submenu = this.nextElementSibling;
                    if (submenu && !submenu.contains(e.relatedTarget)) {
                        submenu.classList.remove('show');
                    }
                }, 100);
            });
            
            // Gérer la sortie du sous-menu
            const submenu = toggle.nextElementSibling;
            if (submenu) {
                submenu.addEventListener('mouseleave', function(e) {
                    if (!toggle.contains(e.relatedTarget)) {
                        this.classList.remove('show');
                    }
                });
            }
        }
    });
    
    // Fermer tous les sous-menus en cliquant ailleurs (desktop seulement)
    document.addEventListener('click', function(e) {
        if (window.innerWidth > 991.98) {
            if (!e.target.closest('.dropdown-submenu')) {
                document.querySelectorAll('.dropdown-menu .dropdown-menu.show').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        }
    });
    
    // Gestion responsive
    window.addEventListener('resize', function() {
        // Sur mobile, fermer tous les sous-menus
        if (window.innerWidth <= 991.98) {
            document.querySelectorAll('.dropdown-menu .dropdown-menu.show').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });
}

// Gérer le comportement hover pour les menus principaux
function initHoverBehavior() {
    const mainDropdowns = document.querySelectorAll('.nav-item.dropdown');
    
    mainDropdowns.forEach(dropdown => {
        if (window.innerWidth > 992) {
            dropdown.addEventListener('mouseenter', function() {
                const toggle = this.querySelector('.dropdown-toggle');
                if (toggle) {
                    const bsDropdown = bootstrap.Dropdown.getInstance(toggle);
                    if (!bsDropdown || !bsDropdown._isShown()) {
                        const dropdownMenu = this.querySelector('.dropdown-menu');
                        if (dropdownMenu) {
                            dropdownMenu.classList.add('show');
                            this.classList.add('show');
                        }
                    }
                }
            });
            
            dropdown.addEventListener('mouseleave', function(e) {
                setTimeout(() => {
                    if (!this.contains(e.relatedTarget)) {
                        const toggle = this.querySelector('.dropdown-toggle');
                        if (toggle) {
                            const bsDropdown = bootstrap.Dropdown.getInstance(toggle);
                            if (bsDropdown) {
                                bsDropdown.hide();
                            }
                        }
                    }
                }, 100);
            });
        }
    });
}

// Initialiser les dropdowns Bootstrap
const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
dropdownElementList.map(function (dropdownToggleEl) {
    return new bootstrap.Dropdown(dropdownToggleEl, {
        autoClose: 'outside'
    });
});
</script>