<!-- Barre de navigation horizontale personnalisée -->
<style>
/* Styles personnalisés pour éviter les conflits avec le thème */
.gx-horizontal-nav-bar {
    background: linear-gradient(90deg, #2c3e50 0%, #34495e 100%);
    padding: 12px 0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    width: 100%;
    clear: both;
    display: block;
    position: relative;
    z-index: 998;
}

.gx-horizontal-nav-container {
    max-width: 100%;
    margin: 0 auto;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0;
}

/* Menu Destinations */
.gx-destinations-menu-wrapper {
    position: relative;
}

.gx-destinations-trigger {
    background: transparent;
    border: none;
    color: #ffffff;
    font-size: 1.05rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 10px 15px 10px 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    border-radius: 6px;
}

.gx-destinations-trigger:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #ff9800;
}

.gx-destinations-trigger i {
    font-size: 1.3rem;
}

/* Vertical separators */
.gx-separator {
    width: 1px;
    height: 35px;
    background: rgba(255, 255, 255, 0.3);
    margin: 0;
}

/* Left and Right sections */
.gx-nav-left {
    display: flex;
    align-items: center;
    gap: 0;
}

.gx-nav-right {
    display: flex;
    align-items: center;
    gap: 0;
    margin-left: auto;
}

/* Breadcrumb */
.gx-breadcrumb-text {
    color: #ffffff;
    font-size: 1.5rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 0 25px;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 8px;
}

.gx-breadcrumb-text a {
    color: #ffffff;
    text-decoration: none;
    transition: color 0.3s ease;
}

.gx-breadcrumb-text a:hover {
    color: #ff9800;
    text-decoration: underline;
}

.gx-breadcrumb-separator {
    color: rgba(255, 255, 255, 0.6);
    font-weight: 400;
}

/* Bouton Plan-N-Go */
.gx-plan-n-go-btn {
    background: transparent;
    border: none;
    padding: 0 25px;
    cursor: pointer;
    transition: transform 0.3s ease;
    display: flex;
    align-items: center;
}

.gx-plan-n-go-btn:hover {
    transform: scale(1.05);
}

.gx-plan-n-go-btn img {
    height: 45px;
    width: auto;
    display: block;
}

/* Barre de recherche */
.gx-search-wrapper {
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 25px;
    padding: 8px 14px 8px 20px;
    min-width: 380px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    margin-left: 25px;
    margin-right: 20px;
}

.gx-search-wrapper:focus-within {
    background: #ffffff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.gx-search-icon {
    color: #2c3e50;
    font-size: 1.1rem;
    margin-right: 12px;
}

.gx-search-input {
    flex: 1;
    border: none;
    outline: none;
    background: transparent;
    color: #2c3e50;
    font-size: 0.95rem;
    font-weight: 500;
    padding: 8px 0;
}

.gx-search-input::placeholder {
    color: #7f8c8d;
    font-style: italic;
}

.gx-search-btn {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: #ffffff;
    border: none;
    padding: 9px 20px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.3s ease;
    letter-spacing: 0.6px;
}

.gx-search-btn:hover {
    background: linear-gradient(135deg, #2980b9, #21618c);
    transform: scale(1.05);
}

/* Search Mega Menu */
.gx-search-mega-menu {
    position: absolute;
    top: calc(100% + 10px);
    right: 20px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    padding: 25px;
    min-width: 900px;
    max-height: 600px;
    overflow-y: auto;
    display: none;
    z-index: 1000;
    opacity: 0;
    transform: translateY(-20px) scale(0.95);
    transition: opacity 0.4s ease, transform 0.4s ease;
}

/* Custom scrollbar for search mega menu only */
.gx-search-mega-menu::-webkit-scrollbar {
    width: 8px;
}

.gx-search-mega-menu::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.gx-search-mega-menu::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #3498db, #2980b9);
    border-radius: 10px;
    transition: background 0.3s ease;
}

.gx-search-mega-menu::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #2980b9, #21618c);
}

/* Firefox scrollbar */
.gx-search-mega-menu {
    scrollbar-width: thin;
    scrollbar-color: #3498db #f1f1f1;
}

.gx-search-mega-menu.active {
    display: block;
    opacity: 1;
    transform: translateY(0) scale(1);
}

.gx-search-mega-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #3498db;
}

.gx-search-mega-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.gx-search-mega-column {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.gx-search-column-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #34495e;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    padding-bottom: 5px;
    border-bottom: 2px solid #ecf0f1;
    position: relative;
}

.gx-search-column-title::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 30px;
    height: 2px;
    background: linear-gradient(90deg, #3498db, #2980b9);
    transition: width 0.3s ease;
}

.gx-search-mega-column:hover .gx-search-column-title::after {
    width: 60px;
}

.gx-search-destination-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 10px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: #f8f9fa;
    position: relative;
    overflow: hidden;
}

.gx-search-destination-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(52, 152, 219, 0.1), transparent);
    transition: left 0.5s ease;
}

.gx-search-destination-item:hover::before {
    left: 100%;
}

.gx-search-destination-item:hover {
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    transform: translateX(8px) scale(1.02);
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
}

.gx-search-destination-img {
    width: 40px;
    height: 40px;
    border-radius: 6px;
    object-fit: cover;
    flex-shrink: 0;
    transition: transform 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.gx-search-destination-item:hover .gx-search-destination-img {
    transform: scale(1.1) rotate(2deg);
}

.gx-search-destination-name {
    font-size: 0.9rem;
    font-weight: 600;
    color: #2c3e50;
    flex: 1;
}

.gx-search-destination-item:hover .gx-search-destination-name {
    color: #3498db;
}

/* Overlay supprimé pour éviter les conflits de clics */

/* Responsive */
@media (max-width: 1024px) {
    .gx-horizontal-nav-container {
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .gx-breadcrumb-text {
        flex: 1 1 100%;
        order: 3;
        padding: 10px 0 0 0;
        text-align: center;
    }
    
    .gx-search-wrapper {
        min-width: 200px;
    }
}

@media (max-width: 768px) {
    .gx-breadcrumb-text {
        font-size: 0.75rem;
    }
    
    .gx-search-wrapper {
        min-width: 150px;
    }
    
    .gx-plan-n-go-btn img {
        height: 32px;
    }
}
</style>

<div class="gx-horizontal-nav-bar">
    <div class="gx-horizontal-nav-container">
        <!-- Section gauche: Destinations + Breadcrumb -->
        <div class="gx-nav-left">
            <!-- Menu Destinations -->
            <div class="gx-destinations-menu-wrapper">
                <button class="gx-destinations-trigger" id="gxDestinationsBtn">
                    <i class="fas fa-globe-americas"></i>
                    <span>DESTINATIONS</span>
                </button>
            </div>
            
            <!-- Séparateur vertical -->
            <div class="gx-separator"></div>
            
            <!-- Breadcrumb -->
            <div class="gx-breadcrumb-text" id="gxBreadcrumbText">
                <a href="{{url('/continent/4')}}">AMÉRIQUE DU NORD</a>
                <span class="gx-breadcrumb-separator">/</span>
                <a href="{{url('/country/12')}}">CANADA</a>
                <span class="gx-breadcrumb-separator">/</span>
                <a href="{{url('/province/17')}}">QUÉBEC</a>
                <span class="gx-breadcrumb-separator">/</span>
                <a href="{{url('/region/17')}}">RÉGION DE QUÉBEC</a>
            </div>
        </div>
        
        <!-- Section droite: Plan-N-Go + Recherche -->
        <div class="gx-nav-right">
            <!-- Séparateur vertical -->
            <div class="gx-separator"></div>
            
            <!-- Bouton Plan-N-Go -->
            <a href="{{url('/plan-n-go')}}" class="gx-plan-n-go-btn">
                <img src="{{asset('header_info/GO-EXPLORIA-NEXT-LEVEL.png')}}" alt="Plan-N-Go">
            </a>
            
            <!-- Séparateur vertical -->
            <div class="gx-separator"></div>
            
            <!-- Barre de recherche -->
            <div class="gx-search-wrapper" style="position: relative;">
                <i class="fas fa-search gx-search-icon"></i>
                <input type="text" class="gx-search-input" placeholder="Yacht with Hélip" id="gxSearchInput">
                <button class="gx-search-btn" id="gxSearchBtn">SEARCH</button>
                
                <!-- Search Mega Menu -->
                <div class="gx-search-mega-menu" id="gxSearchMegaMenu">
                    <div class="gx-search-mega-title">
                        <i class="fas fa-map-marked-alt me-2"></i>Destinations Populaires
                    </div>
                    
                    <div class="gx-search-mega-grid">
                        <!-- Colonne Pays -->
                        <div class="gx-search-mega-column">
                            <div class="gx-search-column-title">
                                <i class="fas fa-flag me-1"></i>Pays
                            </div>
                            <a href="{{url('/country/1')}}" class="gx-search-destination-item">
                                <img src="https://flagcdn.com/w40/ca.png" alt="Canada" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Canada</span>
                            </a>
                            <a href="{{url('/country/2')}}" class="gx-search-destination-item">
                                <img src="https://flagcdn.com/w40/us.png" alt="États-Unis" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">États-Unis</span>
                            </a>
                            <a href="{{url('/country/3')}}" class="gx-search-destination-item">
                                <img src="https://flagcdn.com/w40/mx.png" alt="Mexique" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Mexique</span>
                            </a>
                            <a href="{{url('/country/4')}}" class="gx-search-destination-item">
                                <img src="https://flagcdn.com/w40/fr.png" alt="France" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">France</span>
                            </a>
                            <a href="{{url('/country/5')}}" class="gx-search-destination-item">
                                <img src="https://flagcdn.com/w40/cn.png" alt="Chine" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Chine</span>
                            </a>
                        </div>
                        
                        <!-- Colonne Provinces/États -->
                        <div class="gx-search-mega-column">
                            <div class="gx-search-column-title">
                                <i class="fas fa-map me-1"></i>Provinces
                            </div>
                            <a href="{{url('/province/1')}}" class="gx-search-destination-item">
                                <img src="https://images.unsplash.com/photo-1529704193007-e8c78f0f46f9?w=100&h=100&fit=crop" alt="Québec" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Québec</span>
                            </a>
                            <a href="{{url('/province/2')}}" class="gx-search-destination-item">
                                <img src="https://images.unsplash.com/photo-1517935706615-2717063c2225?w=100&h=100&fit=crop" alt="Ontario" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Ontario</span>
                            </a>
                            <a href="{{url('/province/3')}}" class="gx-search-destination-item">
                                <img src="https://images.unsplash.com/photo-1559511260-66a654ae982a?w=100&h=100&fit=crop" alt="Colombie-Britannique" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Colombie-Britannique</span>
                            </a>
                            <a href="{{url('/province/4')}}" class="gx-search-destination-item">
                                <img src="https://images.unsplash.com/photo-1506146332389-18140dc7b2fb?w=100&h=100&fit=crop" alt="Californie" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Californie</span>
                            </a>
                            <a href="{{url('/province/5')}}" class="gx-search-destination-item">
                                <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=100&h=100&fit=crop" alt="Île-de-France" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Île-de-France</span>
                            </a>
                        </div>
                        
                        <!-- Colonne Villes -->
                        <div class="gx-search-mega-column">
                            <div class="gx-search-column-title">
                                <i class="fas fa-city me-1"></i>Villes
                            </div>
                            <a href="{{url('/city/1')}}" class="gx-search-destination-item">
                                <img src="https://images.unsplash.com/photo-1608481337062-4093bf3ed404?w=100&h=100&fit=crop" alt="Ville de Québec" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Ville de Québec</span>
                            </a>
                            <a href="{{url('/city/2')}}" class="gx-search-destination-item">
                                <img src="https://images.unsplash.com/photo-1519451241324-20b4ea2c4220?w=100&h=100&fit=crop" alt="Montréal" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Montréal</span>
                            </a>
                            <a href="{{url('/city/3')}}" class="gx-search-destination-item">
                                <img src="https://images.unsplash.com/photo-1517935706615-2717063c2225?w=100&h=100&fit=crop" alt="Toronto" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Toronto</span>
                            </a>
                            <a href="{{url('/city/4')}}" class="gx-search-destination-item">
                                <img src="https://images.unsplash.com/photo-1559511260-66a654ae982a?w=100&h=100&fit=crop" alt="Vancouver" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Vancouver</span>
                            </a>
                            <a href="{{url('/city/5')}}" class="gx-search-destination-item">
                                <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=100&h=100&fit=crop" alt="Paris" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Paris</span>
                            </a>
                        </div>
                        
                        <!-- Colonne Quartiers -->
                        <div class="gx-search-mega-column">
                            <div class="gx-search-column-title">
                                <i class="fas fa-building me-1"></i>Quartiers
                            </div>
                            <a href="{{url('/quartier/1')}}" class="gx-search-destination-item">
                                <img src="https://images.unsplash.com/photo-1564760055775-d63b17a55c44?w=100&h=100&fit=crop" alt="Vieux-Québec" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Vieux-Québec</span>
                            </a>
                            <a href="{{url('/quartier/2')}}" class="gx-search-destination-item">
                                <img src="https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=100&h=100&fit=crop" alt="Sainte-Foy" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Sainte-Foy</span>
                            </a>
                            <a href="{{url('/quartier/3')}}" class="gx-search-destination-item">
                                <img src="https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?w=100&h=100&fit=crop" alt="Le Plateau" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Le Plateau</span>
                            </a>
                            <a href="{{url('/quartier/4')}}" class="gx-search-destination-item">
                                <img src="https://images.unsplash.com/photo-1523567830207-96731740fa71?w=100&h=100&fit=crop" alt="Vieux-Montréal" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Vieux-Montréal</span>
                            </a>
                            <a href="{{url('/quartier/5')}}" class="gx-search-destination-item">
                                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=100&h=100&fit=crop" alt="Gastown" class="gx-search-destination-img">
                                <span class="gx-search-destination-name">Gastown</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lier le bouton Destinations au mega menu existant avec HOVER
    const gxDestWrapper = document.querySelector('.gx-destinations-menu-wrapper');
    const gxDestBtn = document.getElementById('gxDestinationsBtn');
    const destMegaMenu = document.querySelector('.destination-mega-menu');
    let hoverTimeout;
    
    if (gxDestWrapper && destMegaMenu) {
        // Afficher au hover
        gxDestWrapper.addEventListener('mouseenter', function() {
            clearTimeout(hoverTimeout);
            destMegaMenu.style.display = 'block';
            destMegaMenu.style.animation = 'dmSlideDown 0.4s ease forwards';
        });
        
        // Cacher quand on quitte
        gxDestWrapper.addEventListener('mouseleave', function() {
            hoverTimeout = setTimeout(function() {
                destMegaMenu.style.display = 'none';
            }, 200);
        });
        
        // Garder ouvert quand on est sur le mega menu
        destMegaMenu.addEventListener('mouseenter', function() {
            clearTimeout(hoverTimeout);
        });
        
        destMegaMenu.addEventListener('mouseleave', function() {
            destMegaMenu.style.display = 'none';
        });
    }
    
    // Recherche avec mega menu (sans overlay)
    const searchBtn = document.getElementById('gxSearchBtn');
    const searchInput = document.getElementById('gxSearchInput');
    const searchMegaMenu = document.getElementById('gxSearchMegaMenu');
    
    if (searchBtn && searchInput && searchMegaMenu) {
        // Afficher le mega menu au clic sur l'input
        searchInput.addEventListener('click', function(e) {
            e.stopPropagation();
            searchMegaMenu.classList.add('active');
        });
        
        // Afficher le mega menu au focus
        searchInput.addEventListener('focus', function(e) {
            e.stopPropagation();
            searchMegaMenu.classList.add('active');
        });
        
        // Fermer le mega menu en cliquant en dehors
        document.addEventListener('click', function(e) {
            if (!searchMegaMenu.contains(e.target) && !searchInput.contains(e.target)) {
                searchMegaMenu.classList.remove('active');
            }
        });
        
        // Empêcher la fermeture quand on clique dans le mega menu
        searchMegaMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        
        // Bouton de recherche
        searchBtn.addEventListener('click', function() {
            const query = searchInput.value.trim();
            if (query) {
                // Rediriger vers la page de recherche
                window.location.href = '/search?q=' + encodeURIComponent(query);
            }
        });
        
        // Recherche avec Enter
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = searchInput.value.trim();
                if (query) {
                    window.location.href = '/search?q=' + encodeURIComponent(query);
                }
            }
        });
        
        // Fermer avec Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                searchMegaMenu.classList.remove('active');
            }
        });
    }
});
</script>
