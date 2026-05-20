@php
    $geoMapDestinationContext = $geoMapDestinationContext ?? null;
@endphp
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    :root {
        --primary: #2a5bd7;
        --primary-dark: #1a3fa0;
        --secondary: #00c9b7;
        --dark: #1a1d28;
        --light: #f8f9fa;
        --gray: #6c757d;
        --light-gray: #e9ecef;
        --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.12);
    }
    body {
        background-color: #f5f7ff;
        color: var(--dark);
        font-family: 'Montserrat', 'Segoe UI', system-ui, sans-serif;
        line-height: 1.6;
    }
    .section-header { text-align:center; margin:60px 0; padding:0 20px; opacity:0; transform:translateY(30px); animation:fadeUp 0.8s forwards 0.3s; }
    .section-tag { display:inline-block; background:linear-gradient(90deg,var(--primary),var(--secondary)); color:white; padding:8px 20px; border-radius:50px; font-size:0.9rem; font-weight:600; letter-spacing:1px; margin-bottom:20px; box-shadow:var(--shadow); }
    .section-title { font-size:3.2rem; font-weight:800; margin-bottom:15px; background:linear-gradient(90deg,var(--dark),var(--primary)); -webkit-background-clip:text; background-clip:text; color:transparent; line-height:1.2; }
    .section-title-map { font-size:clamp(18px,2.4vw,28px); font-weight:900; text-transform:uppercase; letter-spacing:2px; color:#0a1628; line-height:1.2; text-shadow:none; margin:0; }
    .section-subtitle { font-size:1.2rem; color:var(--gray); max-width:700px; margin:0 auto; }
    .section-subtitle-map { font-size:clamp(11px,1.1vw,14px); font-weight:500; color:rgba(10,22,40,0.68); line-height:1.55; max-width:520px; margin:0; text-shadow:none; }
    .business-tourism-section { padding:80px 0; background:linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%); position:relative; overflow:hidden; }
    .business-tourism-section::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,var(--primary),var(--secondary)); }
    .content-wrapper { display:flex; flex-wrap:wrap; gap:40px; margin-bottom:60px; opacity:0; transform:translateY(30px); animation:fadeUp 0.8s forwards 0.6s; }
    .info-section { flex:1; min-width:300px; }
    .info-card { background:white; border-radius:20px; padding:40px; box-shadow:var(--shadow); transition:var(--transition); height:100%; position:relative; overflow:hidden; border:1px solid rgba(0,0,0,0.05); }
    .info-card:hover { transform:translateY(-10px); box-shadow:var(--shadow-hover); }
    .info-card::before { content:''; position:absolute; top:0; left:0; width:6px; height:100%; background:linear-gradient(to bottom,var(--primary),var(--secondary)); }
    .info-icon { width:70px; height:70px; background:linear-gradient(135deg,var(--primary),var(--secondary)); border-radius:18px; display:flex; align-items:center; justify-content:center; margin-bottom:25px; color:white; font-size:28px; box-shadow:0 8px 20px rgba(42,91,215,0.25); }
    .info-title { font-size:1.8rem; font-weight:700; margin-bottom:15px; color:var(--dark); }
    .info-text { color:var(--gray); margin-bottom:25px; font-size:1.05rem; }
    .features-list { list-style:none; padding:0; margin-bottom:30px; }
    .features-list li { padding:10px 0 10px 30px; position:relative; border-bottom:1px solid var(--light-gray); }
    .features-list li:last-child { border-bottom:none; }
    .features-list li::before { content:'\f058'; font-family:'Font Awesome 6 Free'; font-weight:900; position:absolute; left:0; color:var(--secondary); font-size:1.2rem; }
    .btn { display:inline-flex; align-items:center; gap:10px; background:linear-gradient(90deg,var(--primary),var(--primary-dark)); color:white; padding:14px 28px; border-radius:12px; text-decoration:none; font-weight:600; transition:var(--transition); border:none; cursor:pointer; box-shadow:0 5px 15px rgba(42,91,215,0.3); }
    .btn:hover { transform:translateY(-3px); box-shadow:0 10px 25px rgba(42,91,215,0.4); color:white; }
    .stats-section { display:flex; justify-content:space-around; flex-wrap:wrap; gap:30px; margin-top:40px; opacity:0; transform:translateY(30px); animation:fadeUp 0.8s forwards 0.9s; }
    .stat-item { text-align:center; padding:25px; background:white; border-radius:16px; box-shadow:var(--shadow); transition:var(--transition); min-width:200px; flex:1; }
    .stat-item:hover { transform:translateY(-5px); box-shadow:var(--shadow-hover); }
    .stat-number { font-size:3rem; font-weight:800; background:linear-gradient(90deg,var(--primary),var(--secondary)); -webkit-background-clip:text; background-clip:text; color:transparent; line-height:1; margin-bottom:10px; }
    .stat-label { color:var(--gray); font-weight:600; font-size:1.1rem; }
    @keyframes fadeUp { to { opacity:1; transform:translateY(0); } }
    @keyframes pulse { 0%{transform:scale(1)} 50%{transform:scale(1.05)} 100%{transform:scale(1)} }
    .pulse { animation:pulse 2s infinite; }

    /* Map */
    .app-container { width:100%; height:600px; position:relative; border-radius:20px; overflow:hidden; box-shadow:var(--shadow); margin:40px auto; }
    .map-container { position:absolute; top:0; left:0; right:0; bottom:0; }
    #map { width:100%; height:100%; }

    /* Sidebar */
    .sidebar-right { position:absolute; top:0; right:0; bottom:0; width:350px; background:white; box-shadow:-5px 0 20px rgba(0,0,0,0.1); overflow-y:auto; transform:translateX(0); transition:transform 0.3s ease; z-index:1000; }
    .sidebar-toggle { position:absolute; top:20px; right:370px; z-index:1001; background:white; border:none; width:50px; height:50px; border-radius:50%; box-shadow:var(--shadow); display:flex; align-items:center; justify-content:center; cursor:pointer; transition:var(--transition); }
    .sidebar-toggle:hover { background:var(--primary); color:white; }

    /* Markers */
    .custom-marker { background:transparent; border:none; }
    .marker-icon { width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:18px; box-shadow:0 3px 10px rgba(0,0,0,0.2); transition:all 0.3s ease; cursor:pointer; }
    .marker-icon:hover { transform:scale(1.1); box-shadow:0 5px 15px rgba(0,0,0,0.3); }
    .marker-icon.highlighted { transform:scale(1.2); box-shadow:0 0 0 3px rgba(66,153,225,0.5); }
    .user-marker-icon { width:50px; height:50px; background:linear-gradient(135deg,#00c9b7,#2a5bd7); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:22px; box-shadow:0 3px 15px rgba(0,0,0,0.3); border:3px solid white; animation:userMarkerPulse 2s infinite; }
    @keyframes userMarkerPulse { 0%{transform:scale(1);box-shadow:0 0 0 0 rgba(42,91,215,0.7)} 70%{transform:scale(1.05);box-shadow:0 0 0 10px rgba(42,91,215,0)} 100%{transform:scale(1);box-shadow:0 0 0 0 rgba(42,91,215,0)} }

    /* Places list */
    .places-list { padding:20px; }
    .place-item { background:white; border-radius:12px; overflow:hidden; margin-bottom:20px; box-shadow:0 3px 10px rgba(0,0,0,0.08); transition:var(--transition); cursor:pointer; }
    .place-item:hover { transform:translateY(-5px); box-shadow:0 10px 25px rgba(0,0,0,0.15); }
    .place-item.active { border:2px solid var(--primary); box-shadow:0 5px 20px rgba(42,91,215,0.3); }
    .place-image { height:150px; overflow:hidden; background:var(--light-gray); position:relative; }
    .place-image img,
    .place-image iframe,
    .place-image video { width:100%; height:100%; object-fit:cover; display:block; border:0; transition:transform 0.5s ease; }
    .place-item:hover .place-image img { transform:scale(1.05); }
    .place-info { padding:15px; }
    .place-info h4 { margin:0 0 10px 0; font-size:1.2rem; color:var(--dark); }
    .place-category { display:inline-block; padding:4px 12px; background:var(--primary); color:white; border-radius:20px; font-size:0.8rem; font-weight:500; margin-bottom:10px; }
    .place-description { color:var(--gray); font-size:0.9rem; margin-bottom:15px; line-height:1.4; }
    .place-actions { display:flex; gap:10px; }
    .place-actions button { flex:1; padding:8px 12px; border:none; border-radius:6px; font-size:0.9rem; cursor:pointer; transition:var(--transition); display:flex; align-items:center; justify-content:center; gap:5px; }
    .view-details-btn { background:var(--primary); color:white; }
    .view-details-btn:hover { background:var(--primary-dark); }
    .locate-btn-small { background:var(--secondary); color:white; }
    .locate-btn-small:hover { background:#00b5a4; }

    /* Filters */
    .filters-section { padding:20px; border-bottom:1px solid var(--light-gray); }
    .filter-group { margin-bottom:15px; }
    .filter-group label { display:block; margin-bottom:5px; font-weight:500; color:var(--dark); }
    .form-select { width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; font-size:0.9rem; transition:var(--transition); }
    .form-select:focus { outline:none; border-color:var(--primary); box-shadow:0 0 0 3px rgba(42,91,215,0.1); }
    .resto-dest-breadcrumb { display:flex; align-items:center; flex-wrap:wrap; gap:8px; }
    .resto-dest-select {
        min-width: 170px;
        max-width: 220px;
        padding: 6px 30px 6px 10px;
        border: 1px solid #d8e2ff;
        border-radius: 10px;
        background: #fff;
        color: #1a1d28;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }
    .resto-dest-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(42,91,215,0.12);
    }
    .resto-dest-sep { color:#6c757d; font-weight:700; }
    .locate-btn { width:100%; padding:12px; background:linear-gradient(90deg,var(--primary),var(--primary-dark)); color:white; border:none; border-radius:8px; font-weight:500; cursor:pointer; transition:var(--transition); display:flex; align-items:center; justify-content:center; gap:8px; }
    .locate-btn:hover:not(:disabled) { background:linear-gradient(90deg,var(--primary-dark),var(--primary)); transform:translateY(-2px); }
    .locate-btn:disabled { opacity:0.6; cursor:not-allowed; }
    .stats { text-align:center; padding:15px; background:var(--light-gray); border-radius:8px; margin-top:15px; }
    .stats p { margin:0; font-size:0.9rem; color:var(--dark); }
    #places-count { font-weight:700; color:var(--primary); font-size:1.1rem; }

    /* No results */
    .no-results { text-align:center; padding:40px 20px; color:var(--gray); }
    .no-results i { font-size:3rem; color:#ddd; margin-bottom:20px; display:block; }
    .no-results h4 { margin-bottom:10px; color:var(--dark); }

    /* Modal */
    .modal { display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.8); z-index:2000; overflow-y:auto; }
    .modal-content { position:relative; background:white; margin:50px auto; width:90%; max-width:900px; border-radius:20px; overflow:hidden; animation:modalSlideIn 0.3s ease; }
    @keyframes modalSlideIn { from{transform:translateY(-50px);opacity:0} to{transform:translateY(0);opacity:1} }
    .close-modal { position:absolute; top:20px; right:20px; background:rgba(0,0,0,0.5); color:white; border:none; width:40px; height:40px; border-radius:50%; font-size:20px; cursor:pointer; z-index:2001; display:flex; align-items:center; justify-content:center; transition:var(--transition); }
    .close-modal:hover { background:rgba(0,0,0,0.8); transform:rotate(90deg); }

    /* Toast */
    .toast-notification { position:fixed; bottom:20px; right:20px; background:white; border-radius:12px; padding:15px 20px; box-shadow:var(--shadow-hover); border-left:4px solid var(--primary); z-index:2002; animation:slideInRight 0.3s ease; max-width:350px; }
    .toast-notification.error   { border-left-color:#e53e3e; }
    .toast-notification.success { border-left-color:#38a169; }
    @keyframes slideInRight { from{transform:translateX(100%);opacity:0} to{transform:translateX(0);opacity:1} }

    /* Leaflet popup */
    .leaflet-popup { margin-bottom:20px; animation:popupFadeIn 0.3s ease; pointer-events:auto !important; }
    .leaflet-popup-content-wrapper { border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.15); border:2px solid var(--primary); overflow:hidden; }
    .leaflet-popup-content { margin:0; padding:0; min-width:280px; }
    .leaflet-popup-tip { background:var(--primary); }
    .hover-popup-content { cursor:default; }
    .popup-details-btn { background:#3b82f6; color:white; border:none; border-radius:4px; padding:8px 12px; font-size:11px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px; font-weight:500; width:100%; }
    .popup-details-btn:hover { background:#2563eb; }
    .youtube-video-container { position:relative; width:100%; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:8px; margin:8px 0; background:#000; }
    .youtube-video-container iframe { position:absolute; top:0; left:0; width:100%; height:100%; border:none; }
    @keyframes popupFadeIn { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }

    /* ==========================================
       OPS VIDEO SWIPER
    ========================================== */
    .ops-slider-wrapper {
        margin-bottom: 30px;
        background: #f8faff;
        border-radius: 16px;
        padding: 20px 20px 24px;
        border: 1px solid #e0e7ff;
    }
    .ops-slider-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e0e7ff;
    }
    .ops-slider-header h4 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #1a1d28;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .ops-badge {
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        color: white;
        font-size: 10px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        letter-spacing: 0.5px;
    }

    /* Swiper wrapper */
    .ops-swiper {
        width: 100%;
        overflow: hidden;
        padding-bottom: 40px !important;
    }
    .ops-swiper .swiper-slide { height: auto; }

    /* Card */
    .ops-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e9ecef;
        box-shadow: 0 3px 10px rgba(0,0,0,0.06);
        transition: box-shadow 0.2s, transform 0.2s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .ops-card:hover { box-shadow:0 8px 24px rgba(42,91,215,0.13); transform:translateY(-2px); }
    .ops-card-video { position:relative; padding-bottom:56.25%; height:0; background:#000; flex-shrink:0; }
    .ops-card-video iframe { position:absolute; top:0; left:0; width:100%; height:100%; border:none; }
    .ops-card-meta { display:flex; align-items:center; gap:8px; padding:10px 12px; flex:1; }
    .ops-card-meta-icon { width:30px; height:30px; border-radius:50%; flex-shrink:0; display:flex; align-items:center; justify-content:center; }
    .ops-card-meta-icon i { color:white; font-size:12px; }
    .ops-card-meta-info { flex:1; min-width:0; }
    .ops-card-meta-name { font-weight:600; font-size:12px; color:#1a1a1a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .ops-card-meta-loc { font-size:10px; color:#888; margin-top:1px; }
    .ops-card-meta-btn { flex-shrink:0; padding:5px 10px; background:var(--primary); color:white; border:none; border-radius:6px; font-size:10px; font-weight:600; cursor:pointer; white-space:nowrap; transition:background 0.2s; }
    .ops-card-meta-btn:hover { background:var(--primary-dark); }

    /* Swiper overrides — pagination */
    .ops-swiper .swiper-pagination-bullet { background:#ccc; opacity:1; width:8px; height:8px; transition:background .2s,transform .2s; }
    .ops-swiper .swiper-pagination-bullet-active { background:var(--primary); transform:scale(1.3); }

    /* Nav row below swiper */
    .ops-nav-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 6px;
    }
    .ops-nav-btn {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: white;
        border: 1.5px solid #dde3f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        color: var(--primary);
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
        transition: all 0.2s;
        line-height: 1;
    }
    .ops-nav-btn:hover { background:var(--primary); color:white; border-color:var(--primary); }
    .ops-nav-btn.swiper-button-disabled { opacity:0.3; pointer-events:none; }

    /* Header principal (même logique de largeur que home-v2) */
    #geo-carte-videos .resto-header-main {
        grid-template-columns: 220px minmax(0, 1fr) 320px;
        gap: 12px;
        align-items: start;
    }
    #geo-carte-videos .resto-header-center {
        width: 100%;
        max-width: 1240px;
        margin: 0 auto;
    }
    #geo-carte-videos .resto-header-center .resto-header-title,
    #geo-carte-videos .resto-header-center .resto-header-title-highlight,
    #geo-carte-videos .resto-header-center h2 {
        max-width: 1100px;
        margin-left: auto;
        margin-right: auto;
    }
    #geo-carte-videos .resto-header-center .resto-header-subtitle {
        max-width: 980px;
    }

    /* Responsive */
    @media (max-width:1200px) { .sidebar-right{width:300px} .sidebar-toggle{right:320px} }
    @media (max-width:1024px) { #geo-carte-videos .resto-header-main{ grid-template-columns:160px minmax(0,1fr) 240px; } }
    @media (max-width:992px)  { .content-wrapper{flex-direction:column} .section-title{font-size:2.5rem} .app-container{height:500px} }
    @media (max-width:768px)  { .section-title{font-size:2rem} .app-container{height:400px} .sidebar-right{width:100%;transform:translateX(100%)} .sidebar-right.active{transform:translateX(0)} .sidebar-toggle{right:20px;top:20px} .stat-item{min-width:150px;padding:20px} .stat-number{font-size:2.5rem} }
    @media (max-width:576px)  { .info-card{padding:25px} .info-title{font-size:1.5rem} .app-container{height:350px} .modal-content{width:95%;margin:20px auto} .leaflet-popup-content{min-width:240px} }
</style>

<!-- HTML -->
<div class="container mt-5 mb-5" id="geo-carte-videos">
    <div class="row">
        <div class="resto-header-block">
            <div class="resto-header-main">
                <div class="resto-header-logo-left">
                    <a href="#" class="resto-accord-btn" title="GoExploria">
                        <div class="logo-wrapper">
                            <img src="{{ asset('logo.png') }}" alt="GoExploria">
                        </div>
                        <span class="resto-accord-btn-label">GoExploria</span>
                        <span class="resto-accord-btn-cta">
                            <i class="fas fa-external-link-alt"></i> Visiter
                        </span>
                    </a>
                </div>
                <div class="resto-header-center">
                    <h1 class="resto-header-title">LA GÉO CARTE VIDÉO</h1>
                    <h1 class="resto-header-title resto-header-title-highlight">Votre nouveau « Call-To-Action »</h1>
                    <h2>VOS VIDÉOS SUR VOS ESPACES, LES ACTIVITÉS À PROXIMITÉ : HÉBERGEMENT, ACTIVITÉS HIVERNALES, MAGASINS D'ALIMENTATION, HÔPITAUX, ETC.</h2>
                    <p class="resto-header-subtitle">Découvrez les lieux incontournables sur notre carte interactive et planifiez vos aventures au Canada.</p>
                    <div class="resto-header-tabs" role="tablist">
                        <button class="resto-tab-btn active" role="tab" data-espace="all">
                            <i class="fas fa-globe"></i> Toutes les options
                        </button>
                        <!-- <button class="resto-tab-btn" role="tab" data-espace="entreprise">
                            <i class="fas fa-briefcase"></i> Espace entreprise
                        </button>
                        <button class="resto-tab-btn" role="tab" data-espace="destination">
                            <i class="fas fa-map-marker-alt"></i> Espace destination
                        </button>
                        <button class="resto-tab-btn" role="tab" data-espace="activite">
                            <i class="fas fa-person-hiking"></i> Espace activité
                        </button> -->
                    </div>
                </div><div class="resto-header-logo-right">
                
                <a href="{{url('avis-clients')}}" title="En savoir plus" target="_blank" rel="noopener noreferrer">
                    <!-- <i class="fas fa-circle-info"></i>
                    <span>Go Next Level</span> -->
                    <img
                    class="bt-next-level-image"
                    src="{{ asset('images/Next-level.png') }}"
                    alt="Next Level"
                    loading="lazy"
                >
                </a>
            </div>
                
            </div>
            @include('home-v2.components.SectionNavbarEspaceMedia')
            <div class="resto-header-destinations-bar">
                <div class="resto-dest-row">
                    <div class="resto-dest-icon-box">
                        <img src="{{ asset('REDI.png') }}" alt="Destinations">
                        <span>Destinations</span>
                    </div>
                                        <div class="resto-dest-breadcrumb">
                        <select id="dest-continent-select" class="resto-dest-select" aria-label="Continent"></select>
                        <span class="resto-dest-sep">/</span>
                        <select id="dest-country-select" class="resto-dest-select" aria-label="Pays"></select>
                        <span class="resto-dest-sep">/</span>
                        <select id="dest-province-select" class="resto-dest-select" aria-label="Province"></select>
                        <span class="resto-dest-sep">/</span>
                        <select id="dest-region-select" class="resto-dest-select" aria-label="Région"></select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="app-container">
                <div class="map-container">
                    <div id="map"></div>
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars" id="sidebarToggleIcon"></i>
                    </button>
                </div>
                <div class="sidebar-right" id="sidebarRight">
                    <div class="filters-section">
                        <div class="filter-group">
                            <label for="province-filter"><i class="fas fa-map-marker-alt"></i> Province/Région (Zoom) :</label>
                            <select id="province-filter" class="form-select"><option value="">Toutes les destinations</option></select>
                        </div>
                        <div class="filter-group">
                            <label for="category-filter"><i class="fas fa-tag"></i> Catégorie (Filtre) :</label>
                            <select id="category-filter" class="form-select"><option value="all">Toutes les catégories</option></select>
                        </div>
                        <div class="filter-group">
                            <button id="locate-me" class="locate-btn"><i class="fas fa-location-arrow"></i> Me localiser</button>
                        </div>
                        <div class="stats"><p><i class="fas fa-map-pin"></i> <span id="places-count">0</span> lieux trouvés</p></div>
                    </div>
                    <div class="places-list" id="places-list">
                        <div class="no-results"><i class="fas fa-map-marker-alt"></i><h4>Chargement des lieux...</h4><p>Veuillez patienter</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="place-modal" class="modal">
    <div class="modal-content">
        <button class="close-modal">&times;</button>
        <div id="modal-content"></div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept']            = 'application/json';
const API_BASE_URL = window.location.origin + '/geo-map';
const DESTINATION_MAP_CONTEXT = @json($geoMapDestinationContext);

class InteractiveMap {
    constructor() {
        this.map              = null;
        this.markers          = {};
        this.currentLocation  = null;
        this.places           = [];
        this.selectedCategory = 'all';
        this.userMarker       = null;
        this.activePlace      = null;
        this.isLoading        = false;
        this._swipers         = [];   // track all Swiper instances
        this.init();
    }

    /* -- Static data -- */
    getStaticProvinces() {
        return [
            {code:'ab',name:'Alberta',                   lat:53.9333,lng:-116.5765},
            {code:'bc',name:'Colombie-Britannique',      lat:53.7267,lng:-127.6476},
            {code:'mb',name:'Manitoba',                  lat:53.7609,lng:-98.8139 },
            {code:'nb',name:'Nouveau-Brunswick',         lat:46.5653,lng:-66.4619 },
            {code:'nl',name:'Terre-Neuve-et-Labrador',  lat:53.1355,lng:-57.6604 },
            {code:'ns',name:'Nouvelle-Écosse',          lat:44.6820,lng:-63.7443 },
            {code:'nt',name:'Territoires du Nord-Ouest',lat:64.8255,lng:-124.8457},
            {code:'nu',name:'Nunavut',                   lat:70.2998,lng:-83.1076 },
            {code:'on',name:'Ontario',                   lat:51.2538,lng:-85.3232 },
            {code:'pe',name:'Île-du-Prince-Édouard',    lat:46.5107,lng:-63.4168 },
            {code:'qc',name:'Québec',                   lat:52.9399,lng:-73.5491 },
            {code:'sk',name:'Saskatchewan',              lat:52.9399,lng:-106.4509},
            {code:'yt',name:'Yukon',                    lat:64.2823,lng:-135.0000}
        ];
    }
    getStaticCategories() {
        return [
            {value:'tourism',    label:'Tourisme',    icon:'fas fa-route',              color:'#00a6a6'},
            {value:'culture',    label:'Culture',     icon:'fas fa-palette',            color:'#8b5cf6'},
            {value:'history',    label:'Histoire',    icon:'fas fa-landmark',           color:'#92400e'},
            {value:'nature',     label:'Nature',      icon:'fas fa-tree',               color:'#16a34a'},
            {value:'adventure',  label:'Aventure',    icon:'fas fa-person-hiking',      color:'#f97316'},
            {value:'shopping',   label:'Shopping',    icon:'fas fa-bag-shopping',       color:'#db2777'},
            {value:'science',    label:'Science',     icon:'fas fa-flask',              color:'#2563eb'},
            {value:'beach',      label:'Plage',       icon:'fas fa-umbrella-beach',     color:'#0ea5e9'},
            {value:'family',     label:'Famille',     icon:'fas fa-people-roof',        color:'#f59e0b'},
            {value:'restaurant', label:'Restaurant',  icon:'fas fa-utensils',           color:'#ef4444'},
            {value:'hotel',      label:'Hôtel',       icon:'fas fa-hotel',              color:'#7c3aed'},
            {value:'commerce',   label:'Commerce',    icon:'fas fa-store',              color:'#0891b2'},
            {value:'sante',      label:'Santé',       icon:'fas fa-heart-pulse',        color:'#dc2626'},
            {value:'education',  label:'Éducation',   icon:'fas fa-graduation-cap',     color:'#4f46e5'},
            {value:'sport',      label:'Sport',       icon:'fas fa-dumbbell',           color:'#059669'},
            {value:'loisirs',    label:'Loisirs',     icon:'fas fa-gamepad',            color:'#c026d3'},
            {value:'transport',  label:'Transport',   icon:'fas fa-bus',                color:'#475569'},
            {value:'immobilier', label:'Immobilier',  icon:'fas fa-house-chimney',      color:'#b45309'},
            {value:'service',    label:'Service',     icon:'fas fa-screwdriver-wrench', color:'#334155'},
            {value:'autre',      label:'Autre',       icon:'fas fa-location-dot',       color:'#64748b'}
        ];
    }

    /* -- Init -- */
    async init() {
        try {
            this.initMap();
            this.initSidebar();
            await this.loadStats();
            this.loadFiltersStatic();
            await this.loadPlaces();
            this.setupEventListeners();
        } catch(e) {
            console.error('Init error:', e);
            this.showNotification('Erreur lors du chargement de la carte', 'error');
        }
    }

    initMap() {
        const destination = DESTINATION_MAP_CONTEXT?.destination;
        const center = destination?.latitude && destination?.longitude
            ? [Number(destination.latitude), Number(destination.longitude)]
            : [52.0, -85.0];
        const zoom = destination?.zoom || 4;
        this.map = L.map('map').setView(center, zoom);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution:'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributeurs',
            maxZoom:19, detectRetina:true
        }).addTo(this.map);
        L.control.scale({imperial:false,metric:true}).addTo(this.map);
    }

    /* -- Filters -- */
    loadFiltersStatic() {
        const provinces  = this.getStaticProvinces();
        const categories = this.getStaticCategories();
        const pf = document.getElementById('province-filter');
        const dynamicFilters = DESTINATION_MAP_CONTEXT?.filters?.items || [];
        if (pf) {
            const label = document.querySelector('label[for="province-filter"]');
            if (label && DESTINATION_MAP_CONTEXT?.filters?.label) {
                label.innerHTML = `<i class="fas fa-map-marker-alt"></i> ${DESTINATION_MAP_CONTEXT.filters.label}`;
            }

            pf.innerHTML = '';
            const allOption = document.createElement('option');
            allOption.value = '';
            allOption.textContent = DESTINATION_MAP_CONTEXT?.filters?.all_label || 'Toutes les destinations';
            pf.appendChild(allOption);
            const filterItems = dynamicFilters.length ? dynamicFilters : provinces;
            filterItems.forEach(p => {
                const o = document.createElement('option');
                o.value = p.code;
                o.textContent = p.name;
                o.dataset.type = p.type || DESTINATION_MAP_CONTEXT?.filters?.child_type || '';
                if (p.lat !== null && p.lat !== undefined && p.lat !== '') o.dataset.lat = p.lat;
                if (p.lng !== null && p.lng !== undefined && p.lng !== '') o.dataset.lng = p.lng;
                pf.appendChild(o);
            });
        }
        const cf = document.getElementById('category-filter');
        if (cf) {
            cf.innerHTML = '<option value="all">Toutes les catégories</option>';
            categories.forEach(c => { const o=document.createElement('option'); o.value=c.value; o.textContent=c.label; cf.appendChild(o); });
        }
        if (document.getElementById('totalProvinces'))  this.animateCounter('totalProvinces',  0, provinces.length);
        if (document.getElementById('totalCategories')) this.animateCounter('totalCategories', 0, categories.length);
    }

    /* -- Stats -- */
    async loadStats() {
        try {
            const r = await axios.get(`${API_BASE_URL}/stats`);
            if (r.data.success) {
                this.animateCounter('totalPoints', 0, r.data.data.total_points||0);
                this.animateCounter('totalViews',  0, r.data.data.total_views ||0);
            }
        } catch(e) { console.error('Stats:',e); }
    }

    /* -- Load places -- */
    async loadPlaces() {
        if (DESTINATION_MAP_CONTEXT?.places?.length) {
            const allPlaces = DESTINATION_MAP_CONTEXT.places;
            this.places = this.selectedCategory === 'all'
                ? allPlaces
                : allPlaces.filter((place) => this.normalizeCategory(place.category) === this.selectedCategory);
            this.updatePlacesCount();
            this.renderPlacesList();
            this.addMarkersToMap();
            return;
        }

        if (this.isLoading) return;
        this.isLoading = true;
        try {
            const params = {per_page:200};
            const r = await axios.get(`${API_BASE_URL}/points`, {params});
            if (r.data.success) {
                const allPlaces = Array.isArray(r.data.data) ? r.data.data : [];
                this.places = this.selectedCategory === 'all'
                    ? allPlaces
                    : allPlaces.filter((place) => this.normalizeCategory(place.category) === this.selectedCategory);
                this.updatePlacesCount();
                this.renderPlacesList();
                this.addMarkersToMap();
            } else throw new Error(r.data.message);
        } catch(e) {
            console.error('Places:',e);
            this.showNotification('Impossible de charger les lieux','error');
        } finally { this.isLoading = false; }
    }

    /* -- Map helpers -- */
    zoomToProvince(code) {
        const dynamicFilters = DESTINATION_MAP_CONTEXT?.filters?.items || [];
        const p = dynamicFilters.find(p=>p.code===code) || this.getStaticProvinces().find(p=>p.code===code);
        if (p?.lat && p?.lng) {
            const zoom = DESTINATION_MAP_CONTEXT?.destination?.zoom ? DESTINATION_MAP_CONTEXT.destination.zoom + 1 : 6;
            this.map.setView([Number(p.lat), Number(p.lng)], zoom);
            this.showNotification(`Zoom sur ${p.name}`,'success');
            return;
        }

        this.showNotification(`${p?.name || 'Destination'} est affichée dans le filtre, mais ses coordonnées ne sont pas encore renseignées.`, 'info');
    }
    addMarkersToMap() { this.clearMarkers(); this.places.forEach(p=>this.createMarker(p)); }
    clearMarkers() {
        Object.values(this.markers).forEach(({marker})=>{ if(marker?.remove) marker.remove(); });
        this.markers = {};
    }
    createMarker(place) {
        const icon = L.divIcon({
            className:'custom-marker',
            html:`<div class="marker-icon" style="background:${this.getCategoryColor(place.category)};"><i class="${this.getCategoryIcon(place.category)}"></i></div>`,
            iconSize:[40,40], iconAnchor:[20,40]
        });
        const marker = L.marker([place.latitude,place.longitude],{icon,title:place.name}).addTo(this.map);
        const popup  = L.popup({maxWidth:300,closeButton:true,autoClose:true,closeOnClick:false,offset:L.point(0,-45)})
                        .setContent(this.createPopupContent(place));
        let ht;
        marker.on('mouseover', ()=>{ clearTimeout(ht); ht=setTimeout(()=>{ popup.setLatLng(marker.getLatLng()).openOn(this.map); document.querySelector(`.place-item[data-id="${place.id}"]`)?.classList.add('active'); marker.getElement()?.querySelector('.marker-icon')?.classList.add('highlighted'); },150); });
        marker.on('mouseout',  ()=>{ clearTimeout(ht); ht=setTimeout(()=>{ const pe=document.querySelector('.leaflet-popup'); if(!pe||!pe.matches(':hover')){ this.map.closePopup(); document.querySelector(`.place-item[data-id="${place.id}"]`)?.classList.remove('active'); marker.getElement()?.querySelector('.marker-icon')?.classList.remove('highlighted'); } },200); });
        marker.on('click', e=>{ L.DomEvent.stopPropagation(e); if(!this.map.hasLayer(popup)) popup.setLatLng(marker.getLatLng()).openOn(this.map); });
        this.markers[place.id] = {marker,popup};
        return marker;
    }

    /* -- Popup -- */
    createPopupContent(place) {
        const videoHtml = this.createPopupVideoHtml(place);
        return `
            <div class="hover-popup-content" data-place-id="${place.id}">
                <div style="padding:12px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                        <div style="width:36px;height:36px;border-radius:50%;background:${this.getCategoryColor(place.category)};display:flex;align-items:center;justify-content:center;">
                            <i class="${this.getCategoryIcon(place.category)}" style="color:white;font-size:16px;"></i>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <h4 style="margin:0;font-size:14px;font-weight:600;color:#1a1a1a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${this.escapeHtml(place.name)}</h4>
                            <div style="font-size:11px;color:#666;">${this.getCategoryLabel(place.category)} • ${place.province||'Canada'}</div>
                        </div>
                    </div>
                    ${videoHtml}
                    <p style="margin:12px 0;font-size:11px;color:#666;line-height:1.4;max-height:40px;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">
                        ${place.description||'Aucune description disponible'}
                    </p>
                    <button class="popup-details-btn" onclick="event.stopPropagation();window.mapApp.showPlaceModal(${JSON.stringify(place).replace(/"/g,'&quot;')})">
                        <i class="fas fa-info-circle"></i> Voir les détails
                    </button>
                </div>
            </div>`;
    }

    createPopupVideoHtml(place) {
        const title = this.escapeHtml(place.name || 'Vidéo');
        const youtubeId = this.extractYoutubeId(place.youtube_id || place.video_id || place.video_url || place.video);
        if (youtubeId) {
            return `
                <div class="youtube-video-container">
                    <iframe src="https://www.youtube-nocookie.com/embed/${youtubeId}?autoplay=0&mute=1&controls=1&modestbranding=1&rel=0&playsinline=1"
                        title="${title}" frameborder="0"
                        allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen
                        style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;"></iframe>
                    <div style="position:absolute;top:8px;right:8px;background:rgba(255,0,0,0.9);color:white;padding:4px 8px;border-radius:4px;font-size:10px;font-weight:600;z-index:10;display:flex;align-items:center;gap:4px;">
                        <i class="fab fa-youtube"></i> YouTube
                    </div>
                </div>`;
        }

        const directVideo = place.video_url || place.video || place.media_video || place.details?.video_url;
        if (directVideo && /\.(mp4|webm|ogg)(\?.*)?$/i.test(directVideo)) {
            return `
                <div class="youtube-video-container">
                    <video controls muted playsinline preload="metadata" style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;object-fit:cover;">
                        <source src="${directVideo}">
                    </video>
                </div>`;
        }

        return '';
    }

    /* ==========================================
       OTHER PLACES VIDEO SWIPER
    ========================================== */
    createOtherPlacesVideoSlider(currentPlace) {
        const others = this.places.filter(p =>
            p.id !== currentPlace.id && p.youtube_id && this.normalizeCategory(p.category) === this.normalizeCategory(currentPlace.category)
        );
        if (others.length === 0) return '';

        // Unique IDs
        const uid    = Date.now();
        const swId   = `ops_sw_${uid}`;
        const prevId = `ops_prev_${uid}`;
        const nextId = `ops_next_${uid}`;
        const pagId  = `ops_pag_${uid}`;

        const slides = others.map(p => {
            let vid = p.youtube_id;
            if (vid?.includes('?')) vid = vid.split('?')[0];
            const pj = JSON.stringify(p).replace(/"/g,'&quot;');
            return `
                <div class="swiper-slide">
                    <div class="ops-card">
                        <div class="ops-card-video">
                            <iframe
                                src="https://www.youtube-nocookie.com/embed/${vid}?autoplay=0&controls=1&modestbranding=1&rel=0"
                                frameborder="0"
                                allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture"
                                allowfullscreen loading="lazy">
                            </iframe>
                        </div>
                        <div class="ops-card-meta">
                            <div class="ops-card-meta-icon" style="background:${this.getCategoryColor(p.category)};">
                                <i class="${this.getCategoryIcon(p.category)}"></i>
                            </div>
                            <div class="ops-card-meta-info">
                                <div class="ops-card-meta-name">${this.escapeHtml(p.name)}</div>
                                <div class="ops-card-meta-loc"><i class="fas fa-map-marker-alt"></i> ${p.province||'Canada'}</div>
                            </div>
                            <button class="ops-card-meta-btn"
                                onclick="window.mapApp.closeModal();setTimeout(()=>window.mapApp.showPlaceModal(${pj}),200)">
                                Voir
                            </button>
                        </div>
                    </div>
                </div>`;
        }).join('');

        /* Boot Swiper after this HTML is in the DOM */
        setTimeout(() => {
            const el = document.getElementById(swId);
            if (!el || typeof Swiper === 'undefined') return;
            const sw = new Swiper(`#${swId}`, {
                slidesPerView: 1,
                spaceBetween: 14,
                grabCursor: true,
                loop: others.length > 3,
                navigation: {
                    prevEl: `#${prevId}`,
                    nextEl: `#${nextId}`
                },
                pagination: {
                    el: `#${pagId}`,
                    clickable: true
                },
                breakpoints: {
                    480:  {slidesPerView: 2, spaceBetween: 12},
                    768:  {slidesPerView: 3, spaceBetween: 14},
                    1024: {slidesPerView: 3, spaceBetween: 14}
                }
            });
            this._swipers.push(sw);
        }, 0);

        return `
            <div class="ops-slider-wrapper">
                <div class="ops-slider-header">
                    <h4><i class="fab fa-youtube" style="color:#FF0000;"></i> Découvrez aussi</h4>
                    <span class="ops-badge">${this.getCategoryLabel(currentPlace.category)}</span>
                </div>

                <div class="swiper ops-swiper" id="${swId}">
                    <div class="swiper-wrapper">${slides}</div>
                    <div class="swiper-pagination" id="${pagId}"></div>
                </div>

                <div class="ops-nav-row">
                    <button id="${prevId}" class="ops-nav-btn" aria-label="Précédent">&#8249;</button>
                    <button id="${nextId}" class="ops-nav-btn" aria-label="Suivant">&#8250;</button>
                </div>
            </div>`;
    }

    /* -- Modal -- */
    showPlaceModal(place) {
        this._destroySwipers();
        const modal = document.getElementById('place-modal');
        const mc    = document.getElementById('modal-content');
        if (!modal || !mc) return;
        mc.innerHTML = this.createModalContent(place);
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    _destroySwipers() {
        this._swipers.forEach(sw => { try { sw.destroy(true,true); } catch(e){} });
        this._swipers = [];
    }

    createModalContent(place) {
        /* Main video */
        let yt = place.youtube_id;
        if (yt?.includes('?')) yt = yt.split('?')[0];
        const videoHtml = yt ? `
            <div style="margin-bottom:20px;border-radius:12px;overflow:hidden;position:relative;">
                <div style="position:relative;padding-bottom:56.25%;height:0;">
                    <iframe src="https://www.youtube-nocookie.com/embed/${yt}?autoplay=1&mute=0&controls=1&modestbranding=1&rel=0"
                        style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;"
                        frameborder="0" allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen>
                    </iframe>
                </div>
                <div style="position:absolute;top:15px;right:15px;background:rgba(255,0,0,0.9);color:white;padding:8px 12px;border-radius:6px;font-size:12px;font-weight:600;">
                    <i class="fab fa-youtube"></i> YouTube
                </div>
            </div>` : '';

        /* Gallery */
        const galleryHtml = (place.images?.length > 0) ? `
            <div style="margin-bottom:30px;">
                <h4 style="color:#333;margin-bottom:15px;font-size:1.1rem;"><i class="fas fa-images" style="color:#4299e1;"></i> Galerie photos</h4>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:10px;">
                    ${place.images.map(img=>`
                        <div onclick="window.mapApp.openGalleryImage('${img.url}')" style="aspect-ratio:1;border-radius:10px;overflow:hidden;cursor:pointer;background:#f0f0f0;position:relative;">
                            <img src="${img.thumbnail||img.url}" alt="${this.escapeHtml(img.caption||'')}" style="width:100%;height:100%;object-fit:cover;transition:transform .3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" loading="lazy">
                            ${img.caption?`<div style="position:absolute;bottom:0;left:0;right:0;background:rgba(0,0,0,0.55);color:white;font-size:10px;padding:4px 6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${this.escapeHtml(img.caption)}</div>`:''}
                        </div>`).join('')}
                </div>
            </div>` : '';

        /* Social */
        const socialIconMap = {
            facebook:{icon:'fab fa-facebook',color:'#1877F2',label:'Facebook'},
            instagram:{icon:'fab fa-instagram',color:'#E1306C',label:'Instagram'},
            twitter:{icon:'fab fa-x-twitter',color:'#000000',label:'X'},
            linkedin:{icon:'fab fa-linkedin',color:'#0A66C2',label:'LinkedIn'},
            youtube:{icon:'fab fa-youtube',color:'#FF0000',label:'YouTube'},
            tiktok:{icon:'fab fa-tiktok',color:'#010101',label:'TikTok'},
            pinterest:{icon:'fab fa-pinterest',color:'#E60023',label:'Pinterest'},
            snapchat:{icon:'fab fa-snapchat',color:'#FFFC00',label:'Snapchat'},
            whatsapp:{icon:'fab fa-whatsapp',color:'#25D366',label:'WhatsApp'},
            telegram:{icon:'fab fa-telegram',color:'#229ED9',label:'Telegram'},
            discord:{icon:'fab fa-discord',color:'#5865F2',label:'Discord'},
            twitch:{icon:'fab fa-twitch',color:'#9146FF',label:'Twitch'},
            reddit:{icon:'fab fa-reddit',color:'#FF4500',label:'Reddit'},
            github:{icon:'fab fa-github',color:'#181717',label:'GitHub'},
            medium:{icon:'fab fa-medium',color:'#000000',label:'Medium'},
            vimeo:{icon:'fab fa-vimeo',color:'#1AB7EA',label:'Vimeo'},
            spotify:{icon:'fab fa-spotify',color:'#1DB954',label:'Spotify'},
            tripadvisor:{icon:'fab fa-tripadvisor',color:'#34E0A1',label:'TripAdvisor'},
            yelp:{icon:'fab fa-yelp',color:'#D32323',label:'Yelp'},
            google_maps:{icon:'fab fa-google',color:'#4285F4',label:'Google Maps'},
        };
        let socialHtml = '';
        if (place.details?.social_networks && Object.keys(place.details.social_networks).length > 0) {
            const btns = Object.entries(place.details.social_networks).map(([k,d])=>{
                const m = socialIconMap[k]||{icon:'fas fa-link',color:'#718096',label:k};
                return `<a href="${d.url}" target="_blank" rel="noopener" title="${m.label}"
                           style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:8px;background:${m.color}18;color:${m.color};text-decoration:none;font-size:13px;font-weight:500;border:1px solid ${m.color}30;transition:all .2s;"
                           onmouseover="this.style.background='${m.color}';this.style.color='white';"
                           onmouseout="this.style.background='${m.color}18';this.style.color='${m.color}';">
                            <i class="${m.icon}" style="font-size:15px;"></i> ${m.label}
                        </a>`;
            }).join('');
            socialHtml = `<div style="margin-bottom:30px;"><h4 style="color:#333;margin-bottom:15px;font-size:1.1rem;"><i class="fas fa-share-alt" style="color:#4299e1;"></i> Réseaux sociaux</h4><div style="display:flex;flex-wrap:wrap;gap:8px;">${btns}</div></div>`;
        }

        /* CTA */
        const ctaMap = {
            restaurant:{label:'Commander',icon:'fa-shopping-cart', color:'#e53e3e'},
            hotel:     {label:'Réserver', icon:'fa-calendar-check',color:'#38a169'},
            tourism:   {label:'Visiter',  icon:'fa-globe-americas',color:'#2a5bd7'},
            museum:    {label:'Visiter',  icon:'fa-landmark',      color:'#805ad5'},
            beach:     {label:'Visiter',  icon:'fa-umbrella-beach',color:'#4299e1'},
            mountain:  {label:'Visiter',  icon:'fa-mountain',      color:'#48bb78'},
            park:      {label:'Visiter',  icon:'fa-tree',          color:'#d69e2e'},
            shopping:  {label:'Commander',icon:'fa-shopping-bag',  color:'#3182ce'},
            event:     {label:'Réserver', icon:'fa-calendar-alt',  color:'#ed64a6'},
            business:  {label:'Contacter',icon:'fa-briefcase',     color:'#2a5bd7'},
        };
        const cta = ctaMap[this.normalizeCategory(place.category)]||{label:'Visiter',icon:'fa-external-link-alt',color:'#2a5bd7'};
        const ctaHtml = place.details?.website ? `
            <a href="${place.details.website}" target="_blank" rel="noopener"
               style="flex:1;padding:14px;background:${cta.color};color:white;border:none;border-radius:8px;cursor:pointer;font-size:16px;font-weight:500;display:flex;align-items:center;justify-content:center;gap:10px;text-decoration:none;transition:opacity .2s;"
               onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                <i class="fas ${cta.icon}"></i> ${cta.label}
            </a>` : '';

        return `
            <div style="padding:30px;">
                <!-- Header -->
                <div style="margin-bottom:30px;">
                    <h2 style="margin:0 0 10px 0;color:#1a1a1a;font-size:1.8rem;">${this.escapeHtml(place.name)}</h2>
                    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                        <span style="background:${this.getCategoryColor(place.category)};color:white;padding:6px 16px;border-radius:20px;font-size:14px;font-weight:500;">${this.getCategoryLabel(place.category)}</span>
                        ${place.details?.rating?`<span style="background:#fbbf24;color:#333;padding:6px 12px;border-radius:20px;font-size:14px;"><i class="fas fa-star"></i> ${place.details.rating} (${place.details.reviews_count||0} avis)</span>`:''}
                        <span style="color:#666;font-size:14px;"><i class="fas fa-map-marker-alt"></i> ${place.province||'Canada'}</span>
                    </div>
                </div>

                ${videoHtml}
                ${this.createOtherPlacesVideoSlider(place)}
                ${galleryHtml}

                <!-- Description -->
                <div style="margin-bottom:30px;">
                    <h4 style="color:#333;margin-bottom:15px;font-size:1.2rem;"><i class="fas fa-info-circle" style="color:#4299e1;"></i> Description</h4>
                    <p style="color:#666;line-height:1.6;font-size:16px;">${place.description||''}</p>
                    ${place.details?.long_description?`<p style="color:#666;line-height:1.6;font-size:16px;margin-top:15px;">${place.details.long_description}</p>`:''}
                </div>

                <!-- Info grid -->
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;margin-bottom:30px;">
                    ${place.address?`
                        <div style="background:#f8f9fa;padding:20px;border-radius:10px;border-left:4px solid #4299e1;">
                            <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;"><i class="fas fa-map-marker-alt" style="color:#4299e1;font-size:18px;"></i><strong style="color:#333;font-size:16px;">Adresse</strong></div>
                            <p style="margin:0;color:#666;font-size:15px;">${this.escapeHtml(place.address)}</p>
                            ${place.city?`<p style="margin:5px 0 0;color:#666;font-size:14px;">${this.escapeHtml(place.city)}${place.postal_code?`, ${place.postal_code}`:''}</p>`:''}
                        </div>`:''}
                    ${place.details?.phone?`
                        <div style="background:#f8f9fa;padding:20px;border-radius:10px;border-left:4px solid #38a169;">
                            <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;"><i class="fas fa-phone" style="color:#38a169;font-size:18px;"></i><strong style="color:#333;font-size:16px;">Contact</strong></div>
                            <p style="margin:0;"><a href="tel:${place.details.phone}" style="color:#4299e1;text-decoration:none;font-weight:500;">${place.details.phone}</a></p>
                            ${place.details.email?`<p style="margin:5px 0 0;"><a href="mailto:${place.details.email}" style="color:#4299e1;text-decoration:none;">${place.details.email}</a></p>`:''}
                        </div>`:''}
                    ${place.details?.website?`
                        <div style="background:#f8f9fa;padding:20px;border-radius:10px;border-left:4px solid #805ad5;">
                            <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;"><i class="fas fa-globe" style="color:#805ad5;font-size:18px;"></i><strong style="color:#333;font-size:16px;">Site web</strong></div>
                            <p style="margin:0;"><a href="${place.details.website}" target="_blank" style="color:#4299e1;text-decoration:none;font-weight:500;">Visiter le site officiel</a></p>
                        </div>`:''}
                </div>

                ${place.details?.horaires?`
                    <div style="margin-bottom:30px;">
                        <h4 style="color:#333;margin-bottom:15px;font-size:1.2rem;"><i class="fas fa-clock"></i> Horaires</h4>
                        <div style="background:#f8f9fa;padding:20px;border-radius:10px;">
                            <pre style="margin:0;white-space:pre-wrap;font-family:inherit;color:#666;">${typeof place.details.horaires==='string'?place.details.horaires:JSON.stringify(place.details.horaires,null,2)}</pre>
                        </div>
                    </div>`:''}

                ${place.details?.services?`
                    <div style="margin-bottom:30px;">
                        <h4 style="color:#333;margin-bottom:15px;font-size:1.2rem;"><i class="fas fa-concierge-bell"></i> Services</h4>
                        <div style="display:flex;flex-wrap:wrap;gap:10px;">
                            ${(typeof place.details.services==='string'?JSON.parse(place.details.services):place.details.services).map(s=>`<span style="background:#e0e7ff;color:#3730a3;padding:5px 12px;border-radius:20px;font-size:13px;">${s}</span>`).join('')}
                        </div>
                    </div>`:''}

                ${socialHtml}

                <!-- Footer -->
                <div style="display:flex;gap:15px;margin-top:30px;padding-top:25px;border-top:1px solid #e0e0e0;">
                    ${ctaHtml}
                    <button onclick="window.mapApp.closeModal()" style="flex:1;padding:14px;background:#f0f0f0;color:#333;border:none;border-radius:8px;cursor:pointer;font-size:16px;font-weight:500;display:flex;align-items:center;justify-content:center;gap:10px;">
                        <i class="fas fa-times"></i> Fermer
                    </button>
                </div>
            </div>`;
    }

    /* -- Places list -- */
    renderPlacesList() {
        const c = document.getElementById('places-list');
        if (!c) return;
        c.innerHTML = '';
        if (!this.places.length) { c.innerHTML=`<div class="no-results"><i class="fas fa-map-marker-alt"></i><h4>Aucun lieu trouvé</h4><p>Essayez de modifier le filtre</p></div>`; return; }
        this.places.forEach(p => c.appendChild(this.createPlaceElement(p)));
    }
    createPlaceElement(place) {
        const div = document.createElement('div');
        div.className = 'place-item'; div.dataset.id = place.id;
        const mediaHtml = this.createPlaceListMedia(place);
        div.innerHTML = `
            ${mediaHtml}
            <div class="place-info">
                <h4>${this.escapeHtml(place.name)}</h4>
                <span class="place-category" style="background:${this.getCategoryColor(place.category)}">${this.getCategoryLabel(place.category)}</span>
                <span style="display:block;font-size:11px;color:#666;margin-top:5px;"><i class="fas fa-map-marker-alt"></i> ${place.province||'Canada'}</span>
                <p class="place-description">${this.escapeHtml(place.description?.substring(0,80)||'Aucune description disponible')}...</p>
                ${place.youtube_id?`<div style="font-size:12px;color:#666;margin-bottom:10px;display:flex;align-items:center;gap:5px;"><i class="fab fa-youtube" style="color:#ff0000;"></i> Vidéo disponible</div>`:''}
                <div class="place-actions">
                    <button class="view-details-btn"><i class="fas fa-eye"></i> Détails</button>
                    <button class="locate-btn-small"><i class="fas fa-map-marker-alt"></i> Carte</button>
                </div>
            </div>`;
        div.querySelector('.view-details-btn').addEventListener('click', e=>{ e.stopPropagation(); this.showPlaceModal(place); });
        div.querySelector('.locate-btn-small').addEventListener('click', e=>{ e.stopPropagation(); this.centerOnPlace(place); });
        div.addEventListener('mouseenter', ()=>{ const md=this.markers[place.id]; if(md?.popup) md.popup.setLatLng([place.latitude,place.longitude]).openOn(this.map); });
        div.addEventListener('mouseleave', ()=>{ setTimeout(()=>{ const pe=document.querySelector('.leaflet-popup'); if(!pe||!pe.matches(':hover')) this.map.closePopup(); },100); });
        return div;
    }
    centerOnPlace(place) {
        this.map.setView([place.latitude,place.longitude],this.map.getZoom());
        const md=this.markers[place.id]; if(md?.popup) md.popup.setLatLng([place.latitude,place.longitude]).openOn(this.map);
    }

    createPlaceListMedia(place) {
        const title = this.escapeHtml(place.name || 'Vidéo');
        const youtubeId = this.extractYoutubeId(place.youtube_id || place.video_id || place.video_url || place.video);
        if (youtubeId) {
            return `
                <div class="place-image place-image--video">
                    <iframe
                        src="https://www.youtube-nocookie.com/embed/${youtubeId}?autoplay=0&mute=1&controls=1&modestbranding=1&rel=0&playsinline=1"
                        title="${title}"
                        loading="lazy"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>`;
        }

        const directVideo = place.video_url || place.video || place.media_video || place.details?.video_url;
        if (directVideo && /\.(mp4|webm|ogg)(\?.*)?$/i.test(directVideo)) {
            return `
                <div class="place-image place-image--video">
                    <video controls muted playsinline preload="metadata">
                        <source src="${directVideo}">
                    </video>
                </div>`;
        }

        const thumb = place.thumbnail || place.main_image || 'https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=400&h=150&fit=crop';
        return `<div class="place-image"><img src="${thumb}" alt="${title}" loading="lazy"></div>`;
    }

    /* -- Geolocation -- */
    locateUser() {
        if (!navigator.geolocation) { this.showNotification('Géolocalisation non supportée','error'); return; }
        const btn=document.getElementById('locate-me'); const orig=btn.innerHTML;
        btn.innerHTML='<i class="fas fa-spinner fa-spin"></i> Localisation...'; btn.disabled=true;
        navigator.geolocation.getCurrentPosition(
            ({coords:{latitude:lat,longitude:lng}})=>{ this.currentLocation={lat,lng}; this.map.setView([lat,lng],13); this.addUserMarker(lat,lng); this.showNotification('Position trouvée avec succès','success'); btn.innerHTML=orig; btn.disabled=false; },
            err=>{ const m={1:"Veuillez autoriser l'accès à votre position.",2:'Position indisponible.',3:'Délai dépassé.'}; this.showNotification('Impossible de vous localiser. '+(m[err.code]||''),'error'); btn.innerHTML=orig; btn.disabled=false; },
            {enableHighAccuracy:true,timeout:10000}
        );
    }
    addUserMarker(lat,lng) {
        if (this.userMarker) this.userMarker.remove();
        const icon=L.divIcon({className:'custom-marker',html:'<div class="user-marker-icon"><i class="fas fa-user"></i></div>',iconSize:[50,50],iconAnchor:[25,50]});
        this.userMarker=L.marker([lat,lng],{icon,title:'Votre position'}).addTo(this.map);
    }

    updatePlacesCount() { const el=document.getElementById('places-count'); if(el) el.textContent=this.places.length; }

    /* -- Sidebar -- */
    initSidebar() {
        const btn=document.getElementById('sidebarToggle'); const side=document.getElementById('sidebarRight');
        if (btn&&side) { btn.addEventListener('click',()=>{ side.classList.toggle('active'); document.getElementById('sidebarToggleIcon').className=side.classList.contains('active')?'fas fa-times':'fas fa-bars'; }); }
    }

    /* -- Event listeners -- */
    setupEventListeners() {
        document.getElementById('province-filter')?.addEventListener('change', e=>{
            if (e.target.value) { this.zoomToProvince(e.target.value); return; }
            const destination = DESTINATION_MAP_CONTEXT?.destination;
            if (destination?.latitude && destination?.longitude) this.map.setView([Number(destination.latitude), Number(destination.longitude)], destination.zoom || 4);
            else this.map.setView([56.1304,-106.3468],4);
        });
        document.getElementById('category-filter')?.addEventListener('change', e=>{ this.selectedCategory=e.target.value; this.loadPlaces(); });
        document.getElementById('locate-me')?.addEventListener('click', ()=>this.locateUser());
        document.querySelector('.close-modal')?.addEventListener('click', ()=>this.closeModal());
        window.addEventListener('click', e=>{ if(e.target===document.getElementById('place-modal')) this.closeModal(); });
        document.addEventListener('keydown', e=>{ if(e.key==='Escape') this.closeModal(); });

        /* Espace tab buttons */
        const espaceMap = {
            all:         null,
            entreprise:  ['business'],
            destination: ['tourism','museum','monument','airport','university'],
            activite:    ['park','beach','mountain','lake','event','shopping','hotel','hospital']
        };
        document.querySelectorAll('.resto-tab-btn[data-espace]').forEach(btn=>{
            btn.addEventListener('click', ()=>{
                document.querySelectorAll('.resto-tab-btn[data-espace]').forEach(b=>b.classList.remove('active'));
                btn.classList.add('active');
                const cats = espaceMap[btn.dataset.espace];
                if (!cats) {
                    this.selectedCategory = 'all';
                    this.loadPlaces();
                } else {
                    this.places.forEach(p=>{
                        const md=this.markers[p.id]; if(!md) return;
                        if(cats.includes(this.normalizeCategory(p.category))) md.marker.addTo(this.map);
                        else md.marker.remove();
                    });
                    const filtered = this.places.filter(p=>cats.includes(this.normalizeCategory(p.category)));
                    const c=document.getElementById('places-list'); if(c){ c.innerHTML=''; filtered.forEach(p=>c.appendChild(this.createPlaceElement(p))); }
                    const el=document.getElementById('places-count'); if(el) el.textContent=filtered.length;
                }
            });
        });
    }

    /* -- Close modal -- */
    closeModal() {
        this._destroySwipers();
        const modal=document.getElementById('place-modal');
        if (modal) { modal.style.display='none'; document.body.style.overflow=''; }
        this.activePlace=null;
    }

    /* -- Utilities -- */
    showNotification(message, type='info') {
        const t=document.createElement('div'); t.className=`toast-notification ${type}`;
        t.innerHTML=`<div style="display:flex;align-items:center;gap:12px;"><i class="fas ${type==='error'?'fa-exclamation-circle':type==='success'?'fa-check-circle':'fa-info-circle'}" style="font-size:20px;color:${type==='error'?'#e53e3e':type==='success'?'#38a169':'#2a5bd7'}"></i><span>${message}</span></div>`;
        document.body.appendChild(t);
        setTimeout(()=>{ t.style.animation='slideInRight 0.3s ease reverse'; setTimeout(()=>t.remove(),300); },4000);
    }
    animateCounter(id,start,end) {
        const el=document.getElementById(id); if(!el) return;
        let cur=start; const step=Math.ceil((end-start)/50);
        const timer=setInterval(()=>{ cur+=step; if(cur>=end){cur=end;clearInterval(timer);} el.textContent=cur; },40);
    }
    getCategoryAliases() {
        return {
            business: 'service', museum: 'culture', musee: 'culture', park: 'nature', parc: 'nature',
            monument: 'history', event: 'loisirs', evenement: 'loisirs', airport: 'transport', aeroport: 'transport',
            university: 'education', universite: 'education', hospital: 'sante', hopital: 'sante', mountain: 'nature',
            montagne: 'nature', lake: 'nature', lac: 'nature', residential: 'immobilier', residentiel: 'immobilier',
            condo: 'immobilier', maison: 'immobilier', chalet: 'immobilier', terrain: 'immobilier', luxe: 'immobilier',
            investissement: 'immobilier', commercial: 'commerce', 'santé': 'sante', health: 'sante', sports: 'sport',
            leisure: 'loisirs', loisirs: 'loisirs', services: 'service', other: 'autre', divers: 'autre'
        };
    }
    normalizeCategory(cat) {
        if (!cat) return 'autre';
        const raw = String(cat).trim().toLowerCase();
        const normalized = raw.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
        const aliases = this.getCategoryAliases();
        return aliases[raw] || aliases[normalized] || (this.getStaticCategories().some(c => c.value === normalized) ? normalized : 'autre');
    }
    getCategoryDefinition(cat) {
        const normalized = this.normalizeCategory(cat);
        return this.getStaticCategories().find(c => c.value === normalized) || this.getStaticCategories().find(c => c.value === 'autre');
    }
    getCategoryColor(cat) { return this.getCategoryDefinition(cat).color; }
    getCategoryIcon(cat)  { return this.getCategoryDefinition(cat).icon; }
    getCategoryLabel(cat) { return this.getCategoryDefinition(cat).label; }
    extractYoutubeId(value) {
        if (!value || typeof value !== 'string') return '';
        const v = value.trim();
        if (!v) return '';
        if (/^[a-zA-Z0-9_-]{11}$/.test(v)) return v;
        const patterns = [
            /(?:youtube\.com\/watch\?v=)([a-zA-Z0-9_-]{11})/i,
            /(?:youtu\.be\/)([a-zA-Z0-9_-]{11})/i,
            /(?:youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/i,
            /(?:youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/i
        ];
        for (const re of patterns) {
            const m = v.match(re);
            if (m && m[1]) return m[1];
        }
        const qp = v.match(/[?&]v=([a-zA-Z0-9_-]{11})/);
        return qp && qp[1] ? qp[1] : '';
    }
    capitalizeFirstLetter(s) { return s?s.charAt(0).toUpperCase()+s.slice(1):''; }
    escapeHtml(text) { if(!text) return ''; const d=document.createElement('div'); d.textContent=text; return d.innerHTML; }
}

function initDestinationBreadcrumb() {
    const continentSelect = document.getElementById('dest-continent-select');
    const countrySelect = document.getElementById('dest-country-select');
    const provinceSelect = document.getElementById('dest-province-select');
    const regionSelect = document.getElementById('dest-region-select');

    if (!continentSelect || !countrySelect || !provinceSelect || !regionSelect) {
        return;
    }

    const dynamicBreadcrumb = DESTINATION_MAP_CONTEXT?.breadcrumb || [];
    if (dynamicBreadcrumb.length) {
        const selects = [continentSelect, countrySelect, provinceSelect, regionSelect];
        selects.forEach((select, index) => {
            const item = dynamicBreadcrumb[index] || dynamicBreadcrumb[dynamicBreadcrumb.length - 1];
            select.innerHTML = `<option value="${item.slug}">${item.name}</option>`;
        });
        return;
    }

    const hierarchy = {
        'Amérique du Nord': ['Canada', 'États-Unis', 'Mexique', 'Cuba', 'Jamaïque', 'Groenland'],
        'Amérique du Sud': ['Brésil', 'Argentine', 'Colombie', 'Pérou', 'Chili', 'Équateur'],
        'Europe': ['France', 'Allemagne', 'Espagne', 'Italie', 'Portugal', 'Belgique'],
        'Afrique': ['Maroc', 'Sénégal', 'Tunisie', 'Côte d’Ivoire', 'Cameroun', 'Kenya'],
        'Asie': ['Japon', 'Corée du Sud', 'Thaïlande', 'Vietnam', 'Inde', 'Singapour'],
        'Océanie': ['Australie', 'Nouvelle-Zélande', 'Fidji', 'Samoa', 'Vanuatu', 'Tonga']
    };

    const provincesByCountry = {
        'Canada': ['Québec', 'Ontario', 'Alberta', 'Colombie-Britannique', 'Manitoba', 'Nouvelle-Écosse'],
        'États-Unis': ['Californie', 'Texas', 'Floride', 'New York', 'Nevada', 'Colorado'],
        'Mexique': ['Yucatán', 'Jalisco', 'Chiapas', 'Oaxaca', 'Puebla', 'Sonora'],
        'Cuba': ['La Havane', 'Matanzas', 'Villa Clara', 'Holguín', 'Santiago', 'Pinar del Río'],
        'Jamaïque': ['Kingston', 'Saint Andrew', 'Saint James', 'Trelawny', 'Hanover', 'Portland'],
        'Groenland': ['Nuuk', 'Ilulissat', 'Qaqortoq', 'Sisimiut', 'Aasiaat', 'Tasiilaq'],
        'Brésil': ['São Paulo', 'Rio de Janeiro', 'Bahia', 'Paraná', 'Ceará', 'Amazonas'],
        'Argentine': ['Buenos Aires', 'Mendoza', 'Córdoba', 'Santa Fe', 'Salta', 'Neuquén'],
        'Colombie': ['Bogotá D.C.', 'Antioquia', 'Bolívar', 'Valle del Cauca', 'Santander', 'Meta'],
        'Pérou': ['Lima', 'Cusco', 'Arequipa', 'Piura', 'Loreto', 'La Libertad'],
        'Chili': ['Santiago', 'Valparaíso', 'Biobío', 'Araucanía', 'Atacama', 'Los Lagos'],
        'Équateur': ['Pichincha', 'Guayas', 'Azuay', 'Manabí', 'Loja', 'Esmeraldas'],
        'France': ['Île-de-France', 'Provence-Alpes-Côte d’Azur', 'Nouvelle-Aquitaine', 'Occitanie', 'Bretagne', 'Normandie'],
        'Allemagne': ['Bavière', 'Berlin', 'Hambourg', 'Saxe', 'Hesse', 'Rhénanie'],
        'Espagne': ['Catalogne', 'Andalousie', 'Madrid', 'Valence', 'Galice', 'Pays Basque'],
        'Italie': ['Lombardie', 'Lazio', 'Toscane', 'Vénétie', 'Sicile', 'Piémont'],
        'Portugal': ['Lisbonne', 'Porto', 'Algarve', 'Madère', 'Açores', 'Coimbra'],
        'Belgique': ['Bruxelles', 'Flandre-Occidentale', 'Anvers', 'Liège', 'Namur', 'Luxembourg'],
        'Maroc': ['Casablanca-Settat', 'Rabat-Salé-Kénitra', 'Marrakech-Safi', 'Fès-Meknès', 'Souss-Massa', 'Tanger-Tétouan'],
        'Sénégal': ['Dakar', 'Thiès', 'Saint-Louis', 'Ziguinchor', 'Kaolack', 'Diourbel'],
        'Tunisie': ['Tunis', 'Sfax', 'Sousse', 'Nabeul', 'Tozeur', 'Bizerte'],
        'Côte d’Ivoire': ['Abidjan', 'Yamoussoukro', 'Bouaké', 'San-Pédro', 'Korhogo', 'Daloa'],
        'Cameroun': ['Littoral', 'Centre', 'Ouest', 'Nord-Ouest', 'Sud', 'Adamaoua'],
        'Kenya': ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret', 'Nyeri'],
        'Japon': ['Tokyo', 'Osaka', 'Kyoto', 'Hokkaido', 'Okinawa', 'Fukuoka'],
        'Corée du Sud': ['Séoul', 'Busan', 'Incheon', 'Daegu', 'Gwangju', 'Jeju'],
        'Thaïlande': ['Bangkok', 'Chiang Mai', 'Phuket', 'Krabi', 'Pattaya', 'Ayutthaya'],
        'Vietnam': ['Hanoï', 'Hô Chi Minh-Ville', 'Da Nang', 'Hué', 'Nha Trang', 'Can Tho'],
        'Inde': ['Maharashtra', 'Delhi', 'Karnataka', 'Tamil Nadu', 'Goa', 'Kerala'],
        'Singapour': ['Centre', 'Est', 'Nord-Est', 'Nord', 'Ouest', 'Marina Bay'],
        'Australie': ['Nouvelle-Galles du Sud', 'Victoria', 'Queensland', 'Tasmanie', 'Australie-Occidentale', 'Territoire du Nord'],
        'Nouvelle-Zélande': ['Auckland', 'Wellington', 'Canterbury', 'Otago', 'Waikato', 'Bay of Plenty'],
        'Fidji': ['Viti Levu', 'Vanua Levu', 'Lomaiviti', 'Kadavu', 'Rotuma', 'Lau'],
        'Samoa': ['Apia', 'Tuamasaga', 'Palauli', 'Faasaleleaga', 'Aiga-i-le-Tai', 'Atua'],
        'Vanuatu': ['Efate', 'Espiritu Santo', 'Malekula', 'Tanna', 'Pentecost', 'Ambrym'],
        'Tonga': ['Tongatapu', 'Vavaʻu', 'Haʻapai', 'ʻEua', 'Niuas', 'Nomuka']
    };

    const regionSuffixes = ['Centre', 'Nord', 'Sud', 'Est', 'Ouest', 'Métropole'];

    function toRegionList(provinceName) {
        return regionSuffixes.map((suffix) => `${provinceName} - ${suffix}`);
    }

    function fillSelect(selectEl, values) {
        selectEl.innerHTML = values.map((v) => `<option value="${v}">${v}</option>`).join('');
    }

    function getCountries(continent) {
        return hierarchy[continent] || Object.values(hierarchy)[0];
    }

    function getProvinces(country) {
        return provincesByCountry[country] || ['Zone A', 'Zone B', 'Zone C', 'Zone D', 'Zone E', 'Zone F'];
    }

    function syncFromContinent() {
        const countries = getCountries(continentSelect.value);
        fillSelect(countrySelect, countries.slice(0, 6));
        countrySelect.selectedIndex = 0;
        syncFromCountry();
    }

    function syncFromCountry() {
        const provinces = getProvinces(countrySelect.value);
        fillSelect(provinceSelect, provinces.slice(0, 6));
        provinceSelect.selectedIndex = 0;
        syncFromProvince();
    }

    function syncFromProvince() {
        const regions = toRegionList(provinceSelect.value);
        fillSelect(regionSelect, regions.slice(0, 6));
        regionSelect.selectedIndex = 0;
    }

    fillSelect(continentSelect, Object.keys(hierarchy).slice(0, 6));
    continentSelect.value = 'Amérique du Nord';
    syncFromContinent();

    countrySelect.value = 'Canada';
    syncFromCountry();
    provinceSelect.value = 'Québec';
    syncFromProvince();

    continentSelect.addEventListener('change', syncFromContinent);
    countrySelect.addEventListener('change', syncFromCountry);
    provinceSelect.addEventListener('change', syncFromProvince);
}

/* -- Bootstrap -- */
document.addEventListener('DOMContentLoaded', ()=>{
    initDestinationBreadcrumb();
    window.mapApp = new InteractiveMap();
    document.querySelectorAll('.info-card').forEach(c=>{
        c.addEventListener('mouseenter',function(){ this.classList.add('pulse'); });
        c.addEventListener('mouseleave',function(){ this.classList.remove('pulse'); });
    });
});

function sendHeight() {
    if (window.parent&&window.parent!==window) {
        window.parent.postMessage({type:'setHeight',iframeId:'affichez-vos-entreprises',height:document.body.scrollHeight},'*');
    }
}
window.onload  = sendHeight;
window.onresize = sendHeight;
</script>


