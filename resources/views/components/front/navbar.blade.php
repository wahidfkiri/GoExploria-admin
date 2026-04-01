<link rel="stylesheet" href="front/css/main.css">
<link rel="stylesheet" href="front/css/navbar-custom.css">

<style>
/* ===================================================
   MEGA MENU DESTINATIONS - BLEU NUIT PROFESSIONNEL
   =================================================== */

/* Wrapper */
.destination-mega-menu-wrapper { position: relative; }

/* Boite du mega menu — positionnée via JS sur <body> */
.destination-mega-menu {
    display: none;
    position: fixed;
    top: 120px;
    left: 15px;
    right: 15px;
    bottom: 15px;
    width: auto;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 25px 70px rgba(0,0,0,0.4);
    z-index: 999999;
    overflow: hidden;
}
@keyframes dmSlideDown {
    from { opacity: 0; transform: translateY(-14px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ---- BARRE HORIZONTALE ---- */
.destination-top-bar {
    position: absolute;
    top: 0;
    left: 290px;
    right: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 30px;
    background: linear-gradient(90deg, #0d1b2a 0%, #1b2e45 60%, #243b55 100%);
    border-bottom: 3px solid #ff9800;
    height: 70px;
    z-index: 10;
}

.destination-breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    flex: 1;
    flex-wrap: wrap;
}

.breadcrumb-link {
    color: #e0e8f0;
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 5px 10px;
    border-radius: 4px;
    transition: all 0.25s;
}
.breadcrumb-link:hover { color: #ff9800; background: rgba(255,152,0,0.12); }
.breadcrumb-link.active { color: #ff9800; font-weight: 700; }
.breadcrumb-separator { color: #607d8b; font-size: 1rem; }

.destination-top-actions { display: flex; align-items: center; gap: 14px; }

/* Bouton PLAN-N-GO */
.plan-n-go-btn {
    background: linear-gradient(135deg, #ff9800, #e65100);
    color: #fff;
    border: none;
    padding: 11px 28px;
    border-radius: 25px;
    font-weight: 800;
    font-size: 0.92rem;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 4px 18px rgba(255,152,0,0.45);
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}
.plan-n-go-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 7px 22px rgba(255,152,0,0.65);
    background: linear-gradient(135deg, #ffb300, #ff6f00);
}
.plan-n-go-btn i { margin-right: 8px; }

/* Barre de recherche horizontale */
.destination-top-search {
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 25px;
    padding: 8px 16px;
    gap: 10px;
    border: 2px solid #dde3eb;
    box-shadow: 0 3px 14px rgba(0,0,0,0.18);
    transition: border-color 0.3s, box-shadow 0.3s;
}
.destination-top-search:focus-within {
    border-color: #ff9800;
    box-shadow: 0 4px 18px rgba(255,152,0,0.3);
}
.destination-top-search i { color: #ff9800; font-size: 1rem; }
.top-search-input {
    border: none; outline: none;
    font-size: 0.93rem; width: 220px;
    color: #1b2e45; font-weight: 500;
    background: transparent;
}
.top-search-input::placeholder { color: #90a4ae; font-style: italic; }
.top-search-btn {
    background: linear-gradient(135deg, #1b2e45, #243b55);
    color: #fff; border: none;
    padding: 9px 22px; border-radius: 20px;
    font-weight: 700; font-size: 0.85rem;
    cursor: pointer; text-transform: uppercase;
    letter-spacing: 0.5px; transition: all 0.3s;
}
.top-search-btn:hover { background: linear-gradient(135deg, #243b55, #2c4a68); transform: scale(1.04); }

/* ---- CONTENEUR PRINCIPAL ---- */
.destination-main-container {
    display: flex;
    height: 100%;
    background: #f4f6f9;
    position: relative;
}

/* ---- SIDEBAR VERTICALE ---- */
.destination-sidebar {
    width: 290px;
    min-width: 290px;
    background: linear-gradient(180deg, #0d1b2a 0%, #1b2e45 100%);
    border-right: 3px solid #ff9800;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    z-index: 5;
}

.sidebar-search {
    padding: 18px 16px;
    background: #091523;
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 2px solid #ff9800;
}
.sidebar-search i { color: #ff9800; font-size: 1.05rem; flex-shrink: 0; }
.sidebar-search input {
    flex: 1; border: none; outline: none;
    padding: 9px 12px; border-radius: 7px;
    background: #1b2e45; color: #e0e8f0;
    font-size: 0.9rem; transition: background 0.3s;
}
.sidebar-search input:focus { background: #243b55; box-shadow: 0 0 0 2px #ff9800; }
.sidebar-search input::placeholder { color: #607d8b; font-style: italic; }

.sidebar-destinations-list {
    flex: 1; overflow-y: auto; padding: 12px 8px;
}
/* Scrollbar sidebar */
.sidebar-destinations-list::-webkit-scrollbar { width: 7px; }
.sidebar-destinations-list::-webkit-scrollbar-track { background: #091523; }
.sidebar-destinations-list::-webkit-scrollbar-thumb { background: #ff9800; border-radius: 4px; }
.sidebar-destinations-list::-webkit-scrollbar-thumb:hover { background: #ffb300; }

.destination-category { margin-bottom: 18px; }

.category-header {
    display: flex; align-items: center; gap: 10px;
    padding: 11px 14px;
    background: rgba(255,152,0,0.12);
    border-left: 4px solid #ff9800;
    color: #ff9800; font-weight: 800; font-size: 0.93rem;
    border-radius: 0 7px 7px 0;
    margin-bottom: 8px; cursor: pointer;
    transition: all 0.25s;
}
.category-header:hover { background: rgba(255,152,0,0.22); transform: translateX(4px); }
.category-header i { font-size: 1.1rem; }

.destination-items { list-style: none; padding: 0; margin: 0 0 0 8px; }
.destination-items li { margin-bottom: 5px; }

.destination-item {
    display: block; padding: 9px 14px;
    color: #b0c4d8; text-decoration: none;
    border-radius: 7px; font-size: 0.9rem; font-weight: 500;
    border-left: 3px solid transparent;
    transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
}
.destination-item:hover {
    background: rgba(255,152,0,0.14);
    color: #ff9800; transform: translateX(6px);
    border-left-color: #ff9800;
}
.destination-item.active {
    background: linear-gradient(90deg, #ff9800, #e65100);
    color: #fff; font-weight: 700; border-left-color: transparent;
    box-shadow: 0 3px 12px rgba(255,152,0,0.4);
}

/* ---- ZONE DE CONTENU ---- */
.destination-content {
    flex: 1;
    background: #edf1f5;
    overflow-y: auto;
    padding-top: 70px;
    text-align: left;
}
.destination-content-scroll {
    padding: 28px 32px;
    overflow-y: auto;
    height: 100%;
    text-align: left;
}
/* Scrollbar contenu */
.destination-content-scroll::-webkit-scrollbar { width: 10px; }
.destination-content-scroll::-webkit-scrollbar-track { background: #edf1f5; border-radius: 5px; }
.destination-content-scroll::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #1b2e45, #243b55);
    border-radius: 5px; border: 2px solid #edf1f5;
}
.destination-content-scroll::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, #243b55, #2c4a68); }

.destination-title {
    color: #0d1b2a; font-size: 1.8rem; font-weight: 800;
    margin-bottom: 28px; padding-bottom: 16px;
    border-bottom: 3px solid #ff9800;
    text-transform: uppercase; letter-spacing: 0.8px;
}
.destination-title i { color: #ff9800; font-size: 1.5rem; margin-right: 10px; }

.destination-section { margin-bottom: 38px; text-align: left; }
.section-title {
    color: #1b2e45; font-size: 1.25rem; font-weight: 700;
    margin-bottom: 20px; padding-left: 16px;
    border-left: 4px solid #ff9800;
    text-align: left;
}

/* Grille cartes */
.destination-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(185px, 1fr));
    gap: 18px;
    text-align: left;
}

.destination-card {
    position: relative; border-radius: 12px; overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
    text-decoration: none; background: #fff;
    border: 2px solid transparent;
}
.destination-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 10px 30px rgba(255,152,0,0.35);
    border-color: #ff9800;
}
.destination-card img {
    width: 100%; height: 145px; object-fit: cover;
    transition: transform 0.45s; filter: brightness(0.92);
}
.destination-card:hover img { transform: scale(1.12); filter: brightness(1); }

.card-content {
    padding: 14px 16px;
    background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
    position: relative;
}
.card-content::after {
    content: ''; position: absolute; bottom: 0; left: 0;
    width: 0; height: 3px;
    background: linear-gradient(90deg, #ff9800, #e65100);
    transition: width 0.35s;
}
.destination-card:hover .card-content::after { width: 100%; }
.card-content h4 {
    color: #0d1b2a; font-size: 1rem; font-weight: 700;
    margin: 0 0 5px 0; transition: color 0.25s;
    text-align: left;
}
.destination-card:hover .card-content h4 { color: #ff9800; }
.card-content p { color: #78909c; font-size: 0.82rem; margin: 0; text-align: left; }

/* Liste liens cliquables */
.destination-list { display: flex; flex-direction: column; gap: 8px; }
.list-item {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 16px; background: #f8fafc;
    border-radius: 8px; text-decoration: none; color: #1b2e45;
    border-left: 3px solid transparent;
    box-shadow: 0 2px 7px rgba(0,0,0,0.07);
    transition: all 0.25s;
}
.list-item:hover {
    background: #fff8f0; border-left-color: #ff9800;
    transform: translateX(6px);
    box-shadow: 0 4px 14px rgba(255,152,0,0.18);
}
.list-item i { color: #ff9800; font-size: 1rem; }
.list-item span { font-weight: 600; font-size: 0.92rem; }

/* ---- SECTION PUBLICITES ---- */
.destination-ads {
    width: 250px; min-width: 250px;
    background: #edf1f5; padding: 18px 14px;
    padding-top: 88px;
    display: flex; flex-direction: column; gap: 18px;
    overflow-y: auto; border-left: 2px solid #dde3eb;
}
.destination-ads::-webkit-scrollbar { width: 6px; }
.destination-ads::-webkit-scrollbar-track { background: #dde3eb; }
.destination-ads::-webkit-scrollbar-thumb { background: #90a4ae; border-radius: 3px; }

.destination-ads h4 {
    color: #1b2e45; font-size: 0.85rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.5px;
    margin: 0 0 8px 0; padding-bottom: 6px;
    border-bottom: 2px solid #ff9800;
}
.ad-item {
    position: relative; border-radius: 9px; overflow: hidden;
    box-shadow: 0 3px 12px rgba(0,0,0,0.13);
    transition: transform 0.3s, box-shadow 0.3s;
}
.ad-item:hover { transform: scale(1.02); box-shadow: 0 5px 18px rgba(0,0,0,0.2); }
.ad-item img { width: 100%; height: auto; display: block; }
.ad-label {
    position: absolute; top: 8px; right: 8px;
    background: rgba(13,27,42,0.75); color: #fff;
    padding: 3px 8px; border-radius: 4px;
    font-size: 0.7rem; font-weight: 600; letter-spacing: 0.3px;
}
</style>

<header id="header" data-transparent="true" data-fullwidth="true" class="dark submenu-light">
    <div class="header-inner">
        <div class="container">
            <!--Logo avec texte qui change et image map rotative-->
<div id="logo" style="position: relative; display: flex; align-items: center; gap: 20px; top:10px; z-index: 100;">
    <a href="{{url('/')}}" style="position: relative; display: inline-block;">
        <img src="logo.png" class="d-block" style="max-width: 200px; height: auto;">
        <!-- Texte qui change en bas à droite -->
        <div id="logo-text" style="
            position: absolute;
            top: 40px;
            right: 5px;
            font-weight: bold;
            font-style: italic;
            font-size: 15px;
            color: red;
            padding: 2px 6px;
            border-radius: 3px;
            white-space: nowrap;
        ">{{\App\Models\Menu::firstOrFail()->title}}</div>
    </a>
    
    <!-- Image map qui tourne -->
    <a href="{{ url('/theme/business/page-1#plans-daffichage-mondial') }}" 
       target="business-iframe" 
       style="cursor: pointer; display: inline-block;">
        <img src="{{ asset('header_info/map2.png') }}" 
             alt="Map" 
             class="rotating-map"
             style="width: 70px; height: 70px; object-fit: contain; animation: rotateVertical 3s linear infinite; display: block;">
    </a>
</div>

<style>
@keyframes rotateVertical {
    from {
        transform: rotateY(0deg);
    }
    to {
        transform: rotateY(360deg);
    }
}

.rotating-map {
    transition: transform 0.3s ease;
}

.rotating-map:hover {
    animation-play-state: paused;
}
</style>
<!--End: Logo-->

            
            <!--Header Extras-->
            <!-- <div class="header-extras">
                <ul>
                    <li>
                        <a id="btn-search" href="#"><i class="icon-search"></i></a>
                    </li>
                    <li>
                        <div class="p-dropdown">
                            <a href="##"><i class="icon-globe"></i><span>EN</span></a>
                            <ul class="p-dropdown-content">
                                <li><a href="##">French</a></li>
                                <li><a href="##">Spanish</a></li>
                                <li><a href="##">English</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div> -->
            <!--end: Header Extras-->
            
            <!--Navigation Responsive Trigger-->
            <div id="mainMenu-trigger">
                <a class="lines-button x"><span class="lines"></span></a>
            </div>

            {{-- resources/views/components/mega-menu.blade.php --}}
@php
    use App\Helpers\MenuRenderer;
@endphp

{!! MenuRenderer::renderMenu() !!}
            <!--end: Navigation Responsive Trigger g-->
<!--end: Navigation-->
        </div>
    </div>
</header>

{!! \App\Helpers\MenuRenderer::getMegaMenuPanel() !!}

<script src="front/js/jquery.js"></script>
<script src="front/js/functions.js"></script>
<script>
(function() {
    function initDestMegaMenu() {
        var wrapper = document.querySelector('.destination-mega-menu-wrapper');
        var menu    = document.getElementById('destinationMegaMenuPanel');
        if (!wrapper || !menu) return;

        var hideTimer = null;
        var isVisible = false;

        function showMenu() {
            clearTimeout(hideTimer);
            menu.style.display = 'block';
            menu.style.animation = 'dmSlideDown 0.3s cubic-bezier(0.4,0,0.2,1)';
            isVisible = true;
        }

        function hideMenu() {
            hideTimer = setTimeout(function() {
                menu.style.display = 'none';
                isVisible = false;
            }, 150);
        }

        wrapper.addEventListener('mouseenter', showMenu);
        wrapper.addEventListener('mouseleave', hideMenu);
        menu.addEventListener('mouseenter', function() { clearTimeout(hideTimer); });
        menu.addEventListener('mouseleave', hideMenu);

        // Handle country hover to update content area
        var countryItems = menu.querySelectorAll('.country-item');
        var breadcrumbDiv = menu.querySelector('.destination-breadcrumb');
        var contentScroll = menu.querySelector('.destination-content-scroll');

        countryItems.forEach(function(item) {
            item.addEventListener('mouseenter', function(e) {
                e.preventDefault();
                var countryData = JSON.parse(this.getAttribute('data-country'));
                
                // Update breadcrumb
                if (breadcrumbDiv) {
                    var breadcrumbHTML = '<a href="#" class="breadcrumb-link">' + countryData.continent + '</a>';
                    breadcrumbHTML += '<span class="breadcrumb-separator">/</span>';
                    breadcrumbHTML += '<a href="#" class="breadcrumb-link active">' + countryData.flag + countryData.name + '</a>';
                    breadcrumbDiv.innerHTML = breadcrumbHTML;
                }

                // Update content area with provinces, regions, villes
                if (contentScroll && countryData.provinces && countryData.provinces.length > 0) {
                    var contentHTML = '<h2 class="destination-title"><i class="fas fa-map-marked-alt"></i> ' + countryData.flag + countryData.name + '</h2>';
                    
                    countryData.provinces.forEach(function(province) {
                        if (province.regions && province.regions.length > 0) {
                            contentHTML += '<div class="destination-section">';
                            contentHTML += '<h3 class="section-title">' + province.name + '</h3>';
                            
                            province.regions.forEach(function(region) {
                                if (region.villes && region.villes.length > 0) {
                                    contentHTML += '<div style="margin-bottom: 24px;">';
                                    contentHTML += '<h4 style="color: #243b55; font-size: 1.05rem; font-weight: 600; margin-bottom: 12px; padding-left: 12px; border-left: 3px solid #ff9800;">' + region.name + '</h4>';
                                    contentHTML += '<div class="destination-grid">';
                                    
                                    region.villes.forEach(function(ville) {
                                        var villeImg = 'https://picsum.photos/seed/' + ville.id + '/300/200';
                                        var population = ville.population ? ville.population.toLocaleString() + ' hab.' : '';
                                        
                                        contentHTML += '<div style="margin-bottom: 20px;">';
                                        contentHTML += '<a href="#" class="destination-card" style="margin-bottom: 10px;">';
                                        contentHTML += '<img src="' + villeImg + '" alt="' + ville.name + '">';
                                        contentHTML += '<div class="card-content">';
                                        contentHTML += '<h4>' + ville.name + '</h4>';
                                        contentHTML += '<p>' + population + '</p>';
                                        contentHTML += '</div>';
                                        contentHTML += '</a>';
                                        
                                        // Afficher les quartiers si disponibles
                                        if (ville.quartiers && ville.quartiers.length > 0) {
                                            contentHTML += '<div style="padding-left: 15px; margin-top: 8px;">';
                                            contentHTML += '<p style="font-size: 0.85rem; color: #607d8b; font-weight: 600; margin-bottom: 6px;"><i class="fas fa-map-marker-alt" style="color: #ff9800; margin-right: 5px;"></i>Quartiers:</p>';
                                            contentHTML += '<div style="display: flex; flex-wrap: wrap; gap: 6px;">';
                                            ville.quartiers.forEach(function(quartier) {
                                                contentHTML += '<a href="#" style="display: inline-block; padding: 4px 10px; background: #f0f4f8; border-radius: 12px; font-size: 0.8rem; color: #1b2e45; text-decoration: none; border: 1px solid #dde3eb; transition: all 0.2s;" onmouseover="this.style.background=\'#fff8f0\'; this.style.borderColor=\'#ff9800\'; this.style.color=\'#ff9800\';" onmouseout="this.style.background=\'#f0f4f8\'; this.style.borderColor=\'#dde3eb\'; this.style.color=\'#1b2e45\';">';
                                                contentHTML += quartier;
                                                contentHTML += '</a>';
                                            });
                                            contentHTML += '</div>';
                                            contentHTML += '</div>';
                                        }
                                        
                                        contentHTML += '</div>';
                                    });
                                    
                                    contentHTML += '</div>'; // fin destination-grid
                                    contentHTML += '</div>';
                                }
                            });
                            
                            contentHTML += '</div>'; // fin destination-section
                        }
                    });
                    
                    contentScroll.innerHTML = contentHTML;
                }

                // Highlight active country
                countryItems.forEach(function(ci) { ci.classList.remove('active'); });
                this.classList.add('active');
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDestMegaMenu);
    } else {
        initDestMegaMenu();
    }
})();
</script>

<!-- Script pour faire changer le texte automatiquement -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const logoText = document.getElementById('logo-text');
    const texts = [
        <?php $menus = \App\Models\Menu::where('is_active', 1)->get();
        foreach($menus as $menu) {
            echo "'" . addslashes($menu->title) . "',";
        }
        ?>
    ];
    let currentIndex = 0;
    
    // Changer le texte toutes les 3 secondes
    setInterval(() => {
        currentIndex = (currentIndex + 1) % texts.length;
        logoText.textContent = texts[currentIndex];
    }, 3000);
});
</script>
