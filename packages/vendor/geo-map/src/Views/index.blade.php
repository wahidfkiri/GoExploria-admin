
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        /* ... tous vos styles existants ... */
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

        .section-header {
            text-align: center;
            margin: 60px 0;
            padding: 0 20px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s forwards 0.3s;
        }

        .section-tag {
            display: inline-block;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 20px;
            box-shadow: var(--shadow);
        }

        .section-title {
            font-size: 3.2rem;
            font-weight: 800;
            margin-bottom: 15px;
            background: linear-gradient(90deg, var(--dark), var(--primary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            line-height: 1.2;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto;
        }

        .business-tourism-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            position: relative;
            overflow: hidden;
        }

        .business-tourism-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .content-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            margin-bottom: 60px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s forwards 0.6s;
        }

        .info-section {
            flex: 1;
            min-width: 300px;
        }

        .info-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            height: 100%;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .info-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
        }

        .info-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            color: white;
            font-size: 28px;
            box-shadow: 0 8px 20px rgba(42, 91, 215, 0.25);
        }

        .info-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark);
        }

        .info-text {
            color: var(--gray);
            margin-bottom: 25px;
            font-size: 1.05rem;
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin-bottom: 30px;
        }

        .features-list li {
            padding: 10px 0;
            padding-left: 30px;
            position: relative;
            border-bottom: 1px solid var(--light-gray);
        }

        .features-list li:last-child {
            border-bottom: none;
        }

        .features-list li::before {
            content: '\f058';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: 0;
            color: var(--secondary);
            font-size: 1.2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(42, 91, 215, 0.3);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(42, 91, 215, 0.4);
            color: white;
        }

        .stats-section {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 40px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s forwards 0.9s;
        }

        .stat-item {
            text-align: center;
            padding: 25px;
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            min-width: 200px;
            flex: 1;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            line-height: 1;
            margin-bottom: 10px;
        }

        .stat-label {
            color: var(--gray);
            font-weight: 600;
            font-size: 1.1rem;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        .app-container {
            width: 100%;
            height: 600px;
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            margin: 40px auto;
        }

        .map-container {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        #map {
            width: 100%;
            height: 100%;
        }

        .sidebar-right {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 350px;
            background: white;
            box-shadow: -5px 0 20px rgba(0,0,0,0.1);
            overflow-y: auto;
            transform: translateX(0);
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .sidebar-toggle {
            position: absolute;
            top: 20px;
            right: 370px;
            z-index: 1001;
            background: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .sidebar-toggle:hover {
            background: var(--primary);
            color: white;
        }

        .custom-marker {
            background: transparent;
            border: none;
        }

        .marker-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .marker-icon:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .marker-icon.highlighted {
            transform: scale(1.2);
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
        }

        .user-marker-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #00c9b7, #2a5bd7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.3);
            border: 3px solid white;
            animation: userMarkerPulse 2s infinite;
        }

        @keyframes userMarkerPulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(42, 91, 215, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(42, 91, 215, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(42, 91, 215, 0); }
        }

        .places-list {
            padding: 20px;
        }

        .place-item {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            transition: var(--transition);
            cursor: pointer;
        }

        .place-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .place-item.active {
            border: 2px solid var(--primary);
            box-shadow: 0 5px 20px rgba(42, 91, 215, 0.3);
        }

        .place-image {
            height: 150px;
            overflow: hidden;
            background: var(--light-gray);
        }

        .place-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .place-item:hover .place-image img {
            transform: scale(1.05);
        }

        .place-info {
            padding: 15px;
        }

        .place-info h4 {
            margin: 0 0 10px 0;
            font-size: 1.2rem;
            color: var(--dark);
        }

        .place-category {
            display: inline-block;
            padding: 4px 12px;
            background: var(--primary);
            color: white;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .place-description {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .place-actions {
            display: flex;
            gap: 10px;
        }

        .place-actions button {
            flex: 1;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .view-details-btn {
            background: var(--primary);
            color: white;
        }

        .view-details-btn:hover {
            background: var(--primary-dark);
        }

        .locate-btn-small {
            background: var(--secondary);
            color: white;
        }

        .locate-btn-small:hover {
            background: #00b5a4;
        }

        .filters-section {
            padding: 20px;
            border-bottom: 1px solid var(--light-gray);
        }

        .filter-group {
            margin-bottom: 15px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--dark);
        }

        .form-select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(42, 91, 215, 0.1);
        }

        .locate-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .locate-btn:hover:not(:disabled) {
            background: linear-gradient(90deg, var(--primary-dark), var(--primary));
            transform: translateY(-2px);
        }

        .locate-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .stats {
            text-align: center;
            padding: 15px;
            background: var(--light-gray);
            border-radius: 8px;
            margin-top: 15px;
        }

        .stats p {
            margin: 0;
            font-size: 0.9rem;
            color: var(--dark);
        }

        #places-count {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.1rem;
        }

        .no-results {
            text-align: center;
            padding: 40px 20px;
            color: var(--gray);
        }

        .no-results i {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .no-results h4 {
            margin-bottom: 10px;
            color: var(--dark);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.8);
            z-index: 2000;
            overflow-y: auto;
        }

        .modal-content {
            position: relative;
            background: white;
            margin: 50px auto;
            width: 90%;
            max-width: 900px;
            border-radius: 20px;
            overflow: hidden;
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(0,0,0,0.5);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            z-index: 2001;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .close-modal:hover {
            background: rgba(0,0,0,0.8);
            transform: rotate(90deg);
        }

        .toast-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            border-radius: 12px;
            padding: 15px 20px;
            box-shadow: var(--shadow-hover);
            border-left: 4px solid var(--primary);
            z-index: 2002;
            animation: slideInRight 0.3s ease;
            max-width: 350px;
        }

        .toast-notification.error {
            border-left-color: #e53e3e;
        }

        .toast-notification.success {
            border-left-color: #38a169;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .leaflet-popup {
            margin-bottom: 20px;
            animation: popupFadeIn 0.3s ease;
            pointer-events: auto !important;
        }
        
        .leaflet-popup-content-wrapper {
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            border: 2px solid var(--primary);
            overflow: hidden;
        }
        
        .leaflet-popup-content {
            margin: 0;
            padding: 0;
            min-width: 280px;
        }
        
        .leaflet-popup-tip {
            background: var(--primary);
        }

        .hover-popup-content {
            cursor: default;
        }
        
        .popup-details-btn {
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 11px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-weight: 500;
            width: 100%;
        }
        
        .popup-details-btn:hover {
            background: #2563eb;
        }
        
        .youtube-video-container {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 8px;
            margin: 8px 0;
            background: #000;
        }
        
        .youtube-video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .youtube-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(255, 0, 0, 0.9);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        @keyframes popupFadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 1200px) {
            .sidebar-right {
                width: 300px;
            }
            .sidebar-toggle {
                right: 320px;
            }
        }

        @media (max-width: 992px) {
            .content-wrapper {
                flex-direction: column;
            }
            
            .section-title {
                font-size: 2.5rem;
            }
            
            .app-container {
                height: 500px;
            }
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }
            
            .app-container {
                height: 400px;
            }
            
            .sidebar-right {
                width: 100%;
                transform: translateX(100%);
            }
            
            .sidebar-right.active {
                transform: translateX(0);
            }
            
            .sidebar-toggle {
                right: 20px;
                top: 20px;
            }
            
            .stat-item {
                min-width: 150px;
                padding: 20px;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 576px) {
            .info-card {
                padding: 25px;
            }
            
            .info-title {
                font-size: 1.5rem;
            }
            
            .app-container {
                height: 350px;
            }
            
            .modal-content {
                width: 95%;
                margin: 20px auto;
            }
            
            .leaflet-popup-content {
                min-width: 240px;
            }
        }
    </style>

<!-- Section Carte Interactive -->
<div class="container mt-5 mb-5" id="plans-daffichage-mondial">
    <div class="row">
        <div class="col-lg-12 text-center mb-4">
            <span class="section-tag">
                <i class="fas fa-map-marked-alt"></i> Explorer
            </span>
            <h2 class="section-title">Notre Carte Interactive</h2>
            <p class="section-subtitle">Découvrez nos lieux d'intérêt business et tourisme sur la carte</p>
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
                            <label for="province-filter">
                                <i class="fas fa-map-marker-alt"></i> Province/Région (Zoom) :
                            </label>
                            <select id="province-filter" class="form-select">
                                <option value="">Toutes les provinces</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="category-filter">
                                <i class="fas fa-tag"></i> Catégorie (Filtre) :
                            </label>
                            <select id="category-filter" class="form-select">
                                <option value="all">Toutes les catégories</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <button id="locate-me" class="locate-btn">
                                <i class="fas fa-location-arrow"></i> Me localiser
                            </button>
                        </div>
                        
                        <div class="stats">
                            <p><i class="fas fa-map-pin"></i> <span id="places-count">0</span> lieux trouvés</p>
                        </div>
                    </div>
                    
                    <div class="places-list" id="places-list">
                        <div class="no-results">
                            <i class="fas fa-map-marker-alt"></i>
                            <h4>Chargement des lieux...</h4>
                            <p>Veuillez patienter</p>
                        </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
// Configuration Axios
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';

// URL de l'API
const API_BASE_URL = window.location.origin + '/geo-map';

class InteractiveMap {
    constructor() {
        this.map = null;
        this.markers = {};
        this.currentLocation = null;
        this.places = [];
        this.selectedCategory = 'all';
        this.selectedProvince = '';
        this.userMarker = null;
        this.activePlace = null;
        this.isLoading = false;
        this.debounceTimeout = null;
        
        this.init();
    }
    
    // Données statiques des provinces du Canada
    getStaticProvinces() {
        return [
            { code: 'ab', name: 'Alberta', lat: 53.9333, lng: -116.5765, capital: 'Edmonton' },
            { code: 'bc', name: 'Colombie-Britannique', lat: 53.7267, lng: -127.6476, capital: 'Victoria' },
            { code: 'mb', name: 'Manitoba', lat: 53.7609, lng: -98.8139, capital: 'Winnipeg' },
            { code: 'nb', name: 'Nouveau-Brunswick', lat: 46.5653, lng: -66.4619, capital: 'Fredericton' },
            { code: 'nl', name: 'Terre-Neuve-et-Labrador', lat: 53.1355, lng: -57.6604, capital: "St. John's" },
            { code: 'ns', name: 'Nouvelle-Écosse', lat: 44.6820, lng: -63.7443, capital: 'Halifax' },
            { code: 'nt', name: 'Territoires du Nord-Ouest', lat: 64.8255, lng: -124.8457, capital: 'Yellowknife' },
            { code: 'nu', name: 'Nunavut', lat: 70.2998, lng: -83.1076, capital: 'Iqaluit' },
            { code: 'on', name: 'Ontario', lat: 51.2538, lng: -85.3232, capital: 'Toronto' },
            { code: 'pe', name: 'Île-du-Prince-Édouard', lat: 46.5107, lng: -63.4168, capital: 'Charlottetown' },
            { code: 'qc', name: 'Québec', lat: 52.9399, lng: -73.5491, capital: 'Québec' },
            { code: 'sk', name: 'Saskatchewan', lat: 52.9399, lng: -106.4509, capital: 'Regina' },
            { code: 'yt', name: 'Yukon', lat: 64.2823, lng: -135.0000, capital: 'Whitehorse' }
        ];
    }
    
    // Données statiques des catégories
    getStaticCategories() {
        return [
            { value: 'business', label: 'Business', icon: 'fas fa-briefcase', color: '#2a5bd7' },
            { value: 'tourism', label: 'Tourisme', icon: 'fas fa-globe-americas', color: '#00c9b7' },
            { value: 'restaurant', label: 'Restaurant', icon: 'fas fa-utensils', color: '#e53e3e' },
            { value: 'hotel', label: 'Hôtel', icon: 'fas fa-hotel', color: '#38a169' },
            { value: 'museum', label: 'Musée', icon: 'fas fa-landmark', color: '#805ad5' },
            { value: 'shopping', label: 'Shopping', icon: 'fas fa-shopping-bag', color: '#3182ce' },
            { value: 'park', label: 'Parc', icon: 'fas fa-tree', color: '#d69e2e' },
            { value: 'monument', label: 'Monument', icon: 'fas fa-monument', color: '#dd6b20' },
            { value: 'event', label: 'Événement', icon: 'fas fa-calendar-alt', color: '#ed64a6' },
            { value: 'airport', label: 'Aéroport', icon: 'fas fa-plane', color: '#667eea' },
            { value: 'university', label: 'Université', icon: 'fas fa-graduation-cap', color: '#9f7aea' },
            { value: 'hospital', label: 'Hôpital', icon: 'fas fa-hospital', color: '#f56565' },
            { value: 'beach', label: 'Plage', icon: 'fas fa-umbrella-beach', color: '#4299e1' },
            { value: 'mountain', label: 'Montagne', icon: 'fas fa-mountain', color: '#48bb78' },
            { value: 'lake', label: 'Lac', icon: 'fas fa-water', color: '#0bc5ea' }
        ];
    }

    openGalleryImage(url) {
    const overlay = document.createElement('div');
    overlay.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.9);z-index:3000;display:flex;align-items:center;justify-content:center;cursor:zoom-out;';
    overlay.innerHTML = `<img src="${url}" style="max-width:90vw;max-height:90vh;border-radius:8px;object-fit:contain;">`;
    overlay.addEventListener('click', () => overlay.remove());
    document.body.appendChild(overlay);
}
    
    async init() {
        try {
            this.initMap();
            this.initSidebar();
            await this.loadStats();
            this.loadFiltersStatic();
            await this.loadPlaces();
            this.setupEventListeners();
            console.log('Carte interactive initialisée avec succès');
        } catch (error) {
            console.error('Erreur lors de l\'initialisation:', error);
            this.showNotification('Erreur lors du chargement de la carte', 'error');
        }
    }
    
    initMap() {
    try {
        // Position plus à l'est pour mieux voir le Québec et l'Ontario
        // Latitude: 52.0, Longitude: -85.0, Zoom: 4
        this.map = L.map('map').setView([52.0, -85.0], 4);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributeurs',
            maxZoom: 19,
            detectRetina: true
        }).addTo(this.map);
        
        L.control.scale({ imperial: false, metric: true }).addTo(this.map);
        
    } catch (error) {
        console.error('Erreur lors de l\'initialisation de la carte:', error);
    }
}
    
    loadFiltersStatic() {
        const provinces = this.getStaticProvinces();
        const categories = this.getStaticCategories();
        
        // Remplir le filtre des provinces
        const provinceFilter = document.getElementById('province-filter');
        if (provinceFilter) {
            provinceFilter.innerHTML = '<option value="">Toutes les provinces</option>';
            
            provinces.forEach(prov => {
                const option = document.createElement('option');
                option.value = prov.code;
                option.textContent = prov.name;
                option.dataset.lat = prov.lat;
                option.dataset.lng = prov.lng;
                provinceFilter.appendChild(option);
            });
        }
        
        // Remplir le filtre des catégories
        const categoryFilter = document.getElementById('category-filter');
        if (categoryFilter) {
            categoryFilter.innerHTML = '<option value="all">Toutes les catégories</option>';
            
            categories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.value;
                option.textContent = cat.label;
                categoryFilter.appendChild(option);
            });
        }
        
        // Mettre à jour les compteurs
        this.updateProvincesCount(provinces.length);
        this.updateCategoriesCount(categories.length);
    }
    
    updateProvincesCount(count) {
        const element = document.getElementById('totalProvinces');
        if (element) {
            this.animateCounter('totalProvinces', 0, count);
        }
    }
    
    updateCategoriesCount(count) {
        const element = document.getElementById('totalCategories');
        if (element) {
            this.animateCounter('totalCategories', 0, count);
        }
    }
    
    async loadStats() {
        try {
            const response = await axios.get(`${API_BASE_URL}/stats`);
            if (response.data.success) {
                const stats = response.data.data;
                this.animateCounter('totalPoints', 0, stats.total_points || 0);
                this.animateCounter('totalViews', 0, stats.total_views || 0);
            }
        } catch (error) {
            console.error('Erreur chargement stats:', error);
            this.animateCounter('totalPoints', 0, 0);
            this.animateCounter('totalViews', 0, 0);
        }
    }
    
    async loadPlaces() {
        if (this.isLoading) return;
        this.isLoading = true;
        
        try {
            const params = {
                per_page: 200
            };
            
            if (this.selectedCategory !== 'all') {
                params.category = this.selectedCategory;
            }
            
            const response = await axios.get(`${API_BASE_URL}/points`, { params });
            
            if (response.data.success) {
                this.places = response.data.data;
                this.updatePlacesCount();
                this.renderPlacesList();
                this.addMarkersToMap();
            } else {
                throw new Error(response.data.message || 'Erreur de chargement');
            }
        } catch (error) {
            console.error('Erreur chargement lieux:', error);
            this.showNotification('Impossible de charger les lieux', 'error');
        } finally {
            this.isLoading = false;
        }
    }
    
    zoomToProvince(provinceCode) {
        if (!provinceCode) return;
        
        const provinces = this.getStaticProvinces();
        const province = provinces.find(p => p.code === provinceCode);
        
        if (province) {
            this.map.setView([province.lat, province.lng], 6);
            this.showNotification(`Zoom sur ${province.name}`, 'success');
        }
    }
    
    addMarkersToMap() {
        this.clearMarkers();
        
        this.places.forEach(place => {
            this.createMarker(place);
        });
    }
    
    clearMarkers() {
        Object.values(this.markers).forEach(({ marker }) => {
            if (marker && marker.remove) {
                marker.remove();
            }
        });
        this.markers = {};
    }
    
    createMarker(place) {
        const icon = L.divIcon({
            className: 'custom-marker',
            html: `
                <div class="marker-icon" style="background: ${this.getCategoryColor(place.category)};">
                    <i class="${this.getCategoryIcon(place.category)}"></i>
                </div>
            `,
            iconSize: [40, 40],
            iconAnchor: [20, 40]
        });
        
        const marker = L.marker([place.latitude, place.longitude], { 
            icon: icon,
            title: place.name
        }).addTo(this.map);
        
        const popupContent = this.createPopupContent(place);
        const popup = L.popup({
            maxWidth: 300,
            closeButton: true,
            autoClose: true,
            closeOnClick: false,
            offset: L.point(0, -45)
        }).setContent(popupContent);
        
        let hoverTimeout;
        
        marker.on('mouseover', () => {
            clearTimeout(hoverTimeout);
            hoverTimeout = setTimeout(() => {
                popup.setLatLng(marker.getLatLng()).openOn(this.map);
                
                const placeElement = document.querySelector(`.place-item[data-id="${place.id}"]`);
                if (placeElement) placeElement.classList.add('active');
                
                const iconElement = marker.getElement();
                if (iconElement) {
                    const markerIcon = iconElement.querySelector('.marker-icon');
                    if (markerIcon) markerIcon.classList.add('highlighted');
                }
            }, 150);
        });
        
        marker.on('mouseout', () => {
            clearTimeout(hoverTimeout);
            hoverTimeout = setTimeout(() => {
                const popupElement = document.querySelector('.leaflet-popup');
                if (!popupElement || !popupElement.matches(':hover')) {
                    this.map.closePopup();
                    
                    const placeElement = document.querySelector(`.place-item[data-id="${place.id}"]`);
                    if (placeElement) placeElement.classList.remove('active');
                    
                    const iconElement = marker.getElement();
                    if (iconElement) {
                        const markerIcon = iconElement.querySelector('.marker-icon');
                        if (markerIcon) markerIcon.classList.remove('highlighted');
                    }
                }
            }, 200);
        });
        
        marker.on('click', (e) => {
            L.DomEvent.stopPropagation(e);
            if (!this.map.hasLayer(popup)) {
                popup.setLatLng(marker.getLatLng()).openOn(this.map);
            }
        });
        
        this.markers[place.id] = { marker, popup };
        return marker;
    }
    
    createPopupContent(place) {
    // Nettoyer l'ID YouTube
    let youtubeId = place.youtube_id;
    if (youtubeId && youtubeId.includes('?')) {
        youtubeId = youtubeId.split('?')[0];
    }
    
    // Utiliser l'iframe YouTube directement dans le popup
    const videoHtml = youtubeId ? `
        <div class="youtube-video-container" style="position:relative; width:100%; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:8px; margin:8px 0; background:#000;">
            <iframe 
                src="https://www.youtube.com/embed/${youtubeId}?autoplay=0&mute=1&controls=1&modestbranding=1&rel=0&showinfo=0"
                title="Vidéo de ${place.name}"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                style="position:absolute; top:0; left:0; width:100%; height:100%; border:none;">
            </iframe>
            <div style="position:absolute; top:8px; right:8px; background:rgba(255,0,0,0.9); color:white; padding:4px 8px; border-radius:4px; font-size:10px; font-weight:600; z-index:10; display:flex; align-items:center; gap:4px;">
                <i class="fab fa-youtube"></i> YouTube
            </div>
        </div>
    ` : '';
    
    return `
        <div class="hover-popup-content" data-place-id="${place.id}">
            <div style="padding:12px; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;">
                    <div style="width:36px; height:36px; border-radius:50%; background:${this.getCategoryColor(place.category)}; display:flex; align-items:center; justify-content:center;">
                        <i class="${this.getCategoryIcon(place.category)}" style="color:white; font-size:16px;"></i>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <h4 style="margin:0; font-size:14px; font-weight:600; color:#1a1a1a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            ${this.escapeHtml(place.name)}
                        </h4>
                        <div style="font-size:11px; color:#666;">
                            ${this.capitalizeFirstLetter(place.category)} • ${place.province || 'Canada'}
                        </div>
                    </div>
                </div>
                
                ${videoHtml}
                
                <p style="margin:12px 0; font-size:11px; color:#666; line-height:1.4; max-height:40px; overflow:hidden; display:-webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                    ${this.escapeHtml(place.description || 'Aucune description disponible')}
                </p>
                
                <button class="popup-details-btn" onclick="event.stopPropagation(); window.mapApp.showPlaceModal(${JSON.stringify(place).replace(/"/g, '&quot;')})">
                    <i class="fas fa-info-circle"></i> Voir les détails
                </button>
            </div>
        </div>
    `;
}
    
    createModalContent(place) {
    let youtubeId = place.youtube_id;
    if (youtubeId && youtubeId.includes('?')) {
        youtubeId = youtubeId.split('?')[0];
    }

    const videoHtml = youtubeId ? `
        <div style="margin-bottom:30px; border-radius:12px; overflow:hidden; position:relative;">
            <div style="position:relative; padding-bottom:56.25%; height:0;">
                <iframe 
                    src="https://www.youtube-nocookie.com/embed/${youtubeId}?autoplay=1&mute=0&controls=1&modestbranding=1&rel=0&showinfo=0"
                    style="position:absolute; top:0; left:0; width:100%; height:100%; border:none;"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
            <div style="position:absolute; top:15px; right:15px; background:rgba(255,0,0,0.9); color:white; padding:8px 12px; border-radius:6px; font-size:12px; font-weight:600;">
                <i class="fab fa-youtube"></i> YouTube
            </div>
        </div>
    ` : '';

    // ── Image gallery ──────────────────────────────────────────────
    const galleryHtml = (place.images && place.images.length > 0) ? `
        <div style="margin-bottom:30px;">
            <h4 style="color:#333; margin-bottom:15px; font-size:1.1rem;">
                <i class="fas fa-images" style="color:#4299e1;"></i> Galerie photos
            </h4>
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(130px, 1fr)); gap:10px;">
                ${place.images.map((img, i) => `
                    <div onclick="window.mapApp.openGalleryImage('${img.url}')"
                         style="aspect-ratio:1; border-radius:10px; overflow:hidden; cursor:pointer; background:#f0f0f0; position:relative;">
                        <img src="${img.thumbnail || img.url}" alt="${this.escapeHtml(img.caption || '')}"
                             style="width:100%; height:100%; object-fit:cover; transition:transform .3s ease;"
                             onmouseover="this.style.transform='scale(1.05)'"
                             onmouseout="this.style.transform='scale(1)'"
                             loading="lazy">
                        ${img.caption ? `
                            <div style="position:absolute; bottom:0; left:0; right:0; background:rgba(0,0,0,0.55); color:white; font-size:10px; padding:4px 6px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                ${this.escapeHtml(img.caption)}
                            </div>` : ''}
                    </div>
                `).join('')}
            </div>
        </div>
    ` : '';

    // ── Social networks ────────────────────────────────────────────
    const socialIconMap = {
        facebook:    { icon: 'fab fa-facebook',    color: '#1877F2', label: 'Facebook' },
        instagram:   { icon: 'fab fa-instagram',   color: '#E1306C', label: 'Instagram' },
        twitter:     { icon: 'fab fa-x-twitter',   color: '#000000', label: 'X' },
        linkedin:    { icon: 'fab fa-linkedin',    color: '#0A66C2', label: 'LinkedIn' },
        youtube:     { icon: 'fab fa-youtube',     color: '#FF0000', label: 'YouTube' },
        tiktok:      { icon: 'fab fa-tiktok',      color: '#010101', label: 'TikTok' },
        pinterest:   { icon: 'fab fa-pinterest',   color: '#E60023', label: 'Pinterest' },
        snapchat:    { icon: 'fab fa-snapchat',    color: '#FFFC00', label: 'Snapchat' },
        whatsapp:    { icon: 'fab fa-whatsapp',    color: '#25D366', label: 'WhatsApp' },
        telegram:    { icon: 'fab fa-telegram',    color: '#229ED9', label: 'Telegram' },
        discord:     { icon: 'fab fa-discord',     color: '#5865F2', label: 'Discord' },
        twitch:      { icon: 'fab fa-twitch',      color: '#9146FF', label: 'Twitch' },
        reddit:      { icon: 'fab fa-reddit',      color: '#FF4500', label: 'Reddit' },
        github:      { icon: 'fab fa-github',      color: '#181717', label: 'GitHub' },
        medium:      { icon: 'fab fa-medium',      color: '#000000', label: 'Medium' },
        vimeo:       { icon: 'fab fa-vimeo',       color: '#1AB7EA', label: 'Vimeo' },
        spotify:     { icon: 'fab fa-spotify',     color: '#1DB954', label: 'Spotify' },
        tripadvisor: { icon: 'fab fa-tripadvisor', color: '#34E0A1', label: 'TripAdvisor' },
        yelp:        { icon: 'fab fa-yelp',        color: '#D32323', label: 'Yelp' },
        google_maps: { icon: 'fab fa-google',      color: '#4285F4', label: 'Google Maps' },
    };

    let socialHtml = '';
    if (place.details && place.details.social_networks && Object.keys(place.details.social_networks).length > 0) {
        const socialButtons = Object.entries(place.details.social_networks)
            .map(([key, data]) => {
                const meta = socialIconMap[key] || { icon: 'fas fa-link', color: '#718096', label: key };
                return `
                    <a href="${data.url}" target="_blank" rel="noopener"
                       title="${meta.label}"
                       style="display:inline-flex; align-items:center; gap:6px; padding:8px 14px; border-radius:8px;
                              background:${meta.color}18; color:${meta.color}; text-decoration:none;
                              font-size:13px; font-weight:500; border:1px solid ${meta.color}30;
                              transition:all .2s ease;"
                       onmouseover="this.style.background='${meta.color}'; this.style.color='white';"
                       onmouseout="this.style.background='${meta.color}18'; this.style.color='${meta.color}';">
                        <i class="${meta.icon}" style="font-size:15px;"></i> ${meta.label}
                    </a>`;
            }).join('');

        socialHtml = `
            <div style="margin-bottom:30px;">
                <h4 style="color:#333; margin-bottom:15px; font-size:1.1rem;">
                    <i class="fas fa-share-alt" style="color:#4299e1;"></i> Réseaux sociaux
                </h4>
                <div style="display:flex; flex-wrap:wrap; gap:8px;">
                    ${socialButtons}
                </div>
            </div>
        `;
    }

    // ── Dynamic CTA button ─────────────────────────────────────────
    const ctaConfig = {
        restaurant: { label: 'Commander',  icon: 'fa-shopping-cart', color: '#e53e3e', url: place.details?.website },
        hotel:      { label: 'Réserver',   icon: 'fa-calendar-check', color: '#38a169', url: place.details?.website },
        tourism:    { label: 'Visiter',    icon: 'fa-globe-americas', color: '#2a5bd7', url: place.details?.website },
        museum:     { label: 'Visiter',    icon: 'fa-landmark',       color: '#805ad5', url: place.details?.website },
        beach:      { label: 'Visiter',    icon: 'fa-umbrella-beach', color: '#4299e1', url: place.details?.website },
        mountain:   { label: 'Visiter',    icon: 'fa-mountain',       color: '#48bb78', url: place.details?.website },
        park:       { label: 'Visiter',    icon: 'fa-tree',           color: '#d69e2e', url: place.details?.website },
        shopping:   { label: 'Commander',  icon: 'fa-shopping-bag',   color: '#3182ce', url: place.details?.website },
        event:      { label: 'Réserver',   icon: 'fa-calendar-alt',   color: '#ed64a6', url: place.details?.website },
        business:   { label: 'Contacter', icon: 'fa-briefcase',      color: '#2a5bd7', url: place.details?.website },
    };

    const cta = ctaConfig[place.category] || { label: 'Visiter', icon: 'fa-external-link-alt', color: '#2a5bd7', url: place.details?.website };
    const ctaHtml = cta.url ? `
        <a href="${cta.url}" target="_blank" rel="noopener"
           style="flex:1; padding:14px; background:${cta.color}; color:white; border:none; border-radius:8px;
                  cursor:pointer; font-size:16px; font-weight:500; display:flex; align-items:center;
                  justify-content:center; gap:10px; text-decoration:none; transition:opacity .2s;"
           onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
            <i class="fas ${cta.icon}"></i> ${cta.label}
        </a>
    ` : '';

    // ── Assemble ───────────────────────────────────────────────────
    return `
        <div style="padding:30px;">
            <div style="margin-bottom:30px;">
                <h2 style="margin:0 0 10px 0; color:#1a1a1a; font-size:1.8rem;">${this.escapeHtml(place.name)}</h2>
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <span style="background:${this.getCategoryColor(place.category)}; color:white; padding:6px 16px; border-radius:20px; font-size:14px; font-weight:500;">
                        ${this.capitalizeFirstLetter(place.category)}
                    </span>
                    ${place.details?.rating ? `
                        <span style="background:#fbbf24; color:#333; padding:6px 12px; border-radius:20px; font-size:14px;">
                            <i class="fas fa-star"></i> ${place.details.rating} (${place.details.reviews_count || 0} avis)
                        </span>
                    ` : ''}
                    <span style="color:#666; font-size:14px;">
                        <i class="fas fa-map-marker-alt"></i> ${place.province || 'Canada'}
                    </span>
                </div>
            </div>

            ${videoHtml}
            ${galleryHtml}

            <div class="place-details">
                <div style="margin-bottom:30px;">
                    <h4 style="color:#333; margin-bottom:15px; font-size:1.2rem;">
                        <i class="fas fa-info-circle" style="color:#4299e1;"></i> Description
                    </h4>
                    <p style="color:#666; line-height:1.6; font-size:16px;">${this.escapeHtml(place.description || '')}</p>
                    ${place.details?.long_description ? `
                        <p style="color:#666; line-height:1.6; font-size:16px; margin-top:15px;">${this.escapeHtml(place.details.long_description)}</p>
                    ` : ''}
                </div>

                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(250px, 1fr)); gap:20px; margin-bottom:30px;">
                    ${place.address ? `
                        <div style="background:#f8f9fa; padding:20px; border-radius:10px; border-left:4px solid #4299e1;">
                            <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                                <i class="fas fa-map-marker-alt" style="color:#4299e1; font-size:18px;"></i>
                                <strong style="color:#333; font-size:16px;">Adresse</strong>
                            </div>
                            <p style="margin:0; color:#666; font-size:15px;">${this.escapeHtml(place.address)}</p>
                            ${place.city ? `<p style="margin:5px 0 0 0; color:#666; font-size:14px;">${this.escapeHtml(place.city)}${place.postal_code ? `, ${place.postal_code}` : ''}</p>` : ''}
                        </div>
                    ` : ''}

                    ${place.details?.phone ? `
                        <div style="background:#f8f9fa; padding:20px; border-radius:10px; border-left:4px solid #38a169;">
                            <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                                <i class="fas fa-phone" style="color:#38a169; font-size:18px;"></i>
                                <strong style="color:#333; font-size:16px;">Contact</strong>
                            </div>
                            <p style="margin:0;">
                                <a href="tel:${place.details.phone}" style="color:#4299e1; text-decoration:none; font-weight:500;">${place.details.phone}</a>
                            </p>
                            ${place.details.email ? `
                                <p style="margin:5px 0 0 0;">
                                    <a href="mailto:${place.details.email}" style="color:#4299e1; text-decoration:none;">${place.details.email}</a>
                                </p>
                            ` : ''}
                        </div>
                    ` : ''}

                    ${place.details?.website ? `
                        <div style="background:#f8f9fa; padding:20px; border-radius:10px; border-left:4px solid #805ad5;">
                            <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                                <i class="fas fa-globe" style="color:#805ad5; font-size:18px;"></i>
                                <strong style="color:#333; font-size:16px;">Site web</strong>
                            </div>
                            <p style="margin:0;">
                                <a href="${place.details.website}" target="_blank" style="color:#4299e1; text-decoration:none; font-weight:500;">Visiter le site officiel</a>
                            </p>
                        </div>
                    ` : ''}
                </div>

                ${place.details?.horaires ? `
                    <div style="margin-bottom:30px;">
                        <h4 style="color:#333; margin-bottom:15px; font-size:1.2rem;">
                            <i class="fas fa-clock"></i> Horaires
                        </h4>
                        <div style="background:#f8f9fa; padding:20px; border-radius:10px;">
                            <pre style="margin:0; white-space:pre-wrap; font-family:inherit; color:#666;">${typeof place.details.horaires === 'string' ? place.details.horaires : JSON.stringify(place.details.horaires, null, 2)}</pre>
                        </div>
                    </div>
                ` : ''}

                ${place.details?.services ? `
                    <div style="margin-bottom:30px;">
                        <h4 style="color:#333; margin-bottom:15px; font-size:1.2rem;">
                            <i class="fas fa-concierge-bell"></i> Services
                        </h4>
                        <div style="display:flex; flex-wrap:wrap; gap:10px;">
                            ${(typeof place.details.services === 'string' ? JSON.parse(place.details.services) : place.details.services).map(service => `
                                <span style="background:#e0e7ff; color:#3730a3; padding:5px 12px; border-radius:20px; font-size:13px;">${service}</span>
                            `).join('')}
                        </div>
                    </div>
                ` : ''}

                ${socialHtml}
            </div>

            <div style="display:flex; gap:15px; margin-top:30px; padding-top:25px; border-top:1px solid #e0e0e0;">
                ${ctaHtml}
                <button onclick="window.mapApp.closeModal()"
                        style="flex:1; padding:14px; background:#f0f0f0; color:#333; border:none; border-radius:8px; cursor:pointer; font-size:16px; font-weight:500; display:flex; align-items:center; justify-content:center; gap:10px;">
                    <i class="fas fa-times"></i> Fermer
                </button>
            </div>
        </div>
    `;
}
    
    getDirections(place) {
        if (!this.currentLocation) {
            this.showNotification('Veuillez d\'abord vous localiser en cliquant sur "Me localiser"', 'error');
            return;
        }
        
        const url = `https://www.google.com/maps/dir/?api=1&origin=${this.currentLocation.lat},${this.currentLocation.lng}&destination=${place.latitude},${place.longitude}&travelmode=driving`;
        window.open(url, '_blank');
        this.closeModal();
    }
    
    renderPlacesList() {
        const container = document.getElementById('places-list');
        if (!container) return;
        
        container.innerHTML = '';
        
        if (this.places.length === 0) {
            container.innerHTML = `
                <div class="no-results">
                    <i class="fas fa-map-marker-alt"></i>
                    <h4>Aucun lieu trouvé</h4>
                    <p>Essayez de modifier le filtre par catégorie</p>
                </div>
            `;
            return;
        }
        
        this.places.forEach(place => {
            const placeEl = this.createPlaceElement(place);
            container.appendChild(placeEl);
        });
    }
    
    createPlaceElement(place) {
        const div = document.createElement('div');
        div.className = 'place-item';
        div.dataset.id = place.id;
        
        const thumbnail = place.thumbnail || place.main_image || 'https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=400&h=150&fit=crop';
        
        div.innerHTML = `
            <div class="place-image">
                <img src="${thumbnail}" alt="${this.escapeHtml(place.name)}" loading="lazy">
            </div>
            <div class="place-info">
                <h4>${this.escapeHtml(place.name)}</h4>
                <span class="place-category" style="background:${this.getCategoryColor(place.category)}">
                    ${this.capitalizeFirstLetter(place.category)}
                </span>
                <span style="display:block; font-size:11px; color:#666; margin-top:5px;">
                    <i class="fas fa-map-marker-alt"></i> ${place.province || 'Canada'}
                </span>
                <p class="place-description">${this.escapeHtml(place.description?.substring(0, 80) || 'Aucune description disponible')}...</p>
                ${place.youtube_id ? `
                    <div style="font-size:12px; color:#666; margin-bottom:10px; display:flex; align-items:center; gap:5px;">
                        <i class="fab fa-youtube" style="color:#ff0000;"></i> Vidéo disponible
                    </div>
                ` : ''}
                <div class="place-actions">
                    <button class="view-details-btn" data-id="${place.id}">
                        <i class="fas fa-eye"></i> Détails
                    </button>
                    <button class="locate-btn-small" data-id="${place.id}">
                        <i class="fas fa-map-marker-alt"></i> Carte
                    </button>
                </div>
            </div>
        `;
        
        div.querySelector('.view-details-btn').addEventListener('click', (e) => {
            e.stopPropagation();
            this.showPlaceModal(place);
        });
        
        div.querySelector('.locate-btn-small').addEventListener('click', (e) => {
            e.stopPropagation();
            this.centerOnPlace(place);
        });
        
        div.addEventListener('mouseenter', () => {
            const markerData = this.markers[place.id];
            if (markerData && markerData.popup) {
                markerData.popup.setLatLng([place.latitude, place.longitude]).openOn(this.map);
            }
        });
        
        div.addEventListener('mouseleave', () => {
            setTimeout(() => {
                const popupElement = document.querySelector('.leaflet-popup');
                if (!popupElement || !popupElement.matches(':hover')) {
                    this.map.closePopup();
                }
            }, 100);
        });
        
        return div;
    }
    
    centerOnPlace(place) {
        this.map.setView([place.latitude, place.longitude], this.map.getZoom());
        const markerData = this.markers[place.id];
        if (markerData && markerData.popup) {
            markerData.popup.setLatLng([place.latitude, place.longitude]).openOn(this.map);
        }
    }
    
    locateUser() {
        if (!navigator.geolocation) {
            this.showNotification('La géolocalisation n\'est pas supportée', 'error');
            return;
        }
        
        const locateBtn = document.getElementById('locate-me');
        const originalHTML = locateBtn.innerHTML;
        locateBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Localisation...';
        locateBtn.disabled = true;
        
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const { latitude, longitude } = position.coords;
                this.currentLocation = { lat: latitude, lng: longitude };
                
                this.map.setView([latitude, longitude], 13);
                this.addUserMarker(latitude, longitude);
                this.showNotification('Position trouvée avec succès', 'success');
                
                locateBtn.innerHTML = originalHTML;
                locateBtn.disabled = false;
            },
            (error) => {
                console.error('Erreur de géolocalisation:', error);
                let message = 'Impossible de vous localiser. ';
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        message += 'Veuillez autoriser l\'accès à votre position.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        message += 'Position indisponible.';
                        break;
                    case error.TIMEOUT:
                        message += 'Délai d\'attente dépassé.';
                        break;
                }
                this.showNotification(message, 'error');
                locateBtn.innerHTML = originalHTML;
                locateBtn.disabled = false;
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    }
    
    addUserMarker(lat, lng) {
        if (this.userMarker) {
            this.userMarker.remove();
        }
        
        const userIcon = L.divIcon({
            className: 'custom-marker',
            html: '<div class="user-marker-icon"><i class="fas fa-user"></i></div>',
            iconSize: [50, 50],
            iconAnchor: [25, 50]
        });
        
        this.userMarker = L.marker([lat, lng], { icon: userIcon, title: 'Votre position' }).addTo(this.map);
    }
    
    updatePlacesCount() {
        const countEl = document.getElementById('places-count');
        if (countEl) countEl.textContent = this.places.length;
    }
    
    initSidebar() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebarRight');
        
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                const icon = document.getElementById('sidebarToggleIcon');
                icon.className = sidebar.classList.contains('active') ? 'fas fa-times' : 'fas fa-bars';
            });
        }
    }
    
    setupEventListeners() {
        // Province : ZOOM UNIQUEMENT
        const provinceFilter = document.getElementById('province-filter');
        if (provinceFilter) {
            provinceFilter.addEventListener('change', (e) => {
                const provinceCode = e.target.value;
                if (provinceCode) {
                    this.zoomToProvince(provinceCode);
                } else {
                    this.map.setView([56.1304, -106.3468], 4);
                }
            });
        }
        
        // Catégorie : FILTRE LES POINTS
        const categoryFilter = document.getElementById('category-filter');
        if (categoryFilter) {
            categoryFilter.addEventListener('change', (e) => {
                this.selectedCategory = e.target.value;
                this.loadPlaces();
            });
        }
        
        const locateBtn = document.getElementById('locate-me');
        if (locateBtn) {
            locateBtn.addEventListener('click', () => this.locateUser());
        }
        
        const closeModalBtn = document.querySelector('.close-modal');
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', () => this.closeModal());
        }
        
        window.addEventListener('click', (e) => {
            const modal = document.getElementById('place-modal');
            if (e.target === modal) this.closeModal();
        });
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') this.closeModal();
        });
    }
    
    closeModal() {
        const modal = document.getElementById('place-modal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
        this.activePlace = null;
    }
    
    showNotification(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast-notification ${type}`;
        toast.innerHTML = `
            <div style="display:flex; align-items:center; gap:12px;">
                <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : type === 'success' ? 'fa-check-circle' : 'fa-info-circle'}" 
                   style="font-size:20px; color:${type === 'error' ? '#e53e3e' : type === 'success' ? '#38a169' : '#2a5bd7'}"></i>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideInRight 0.3s ease reverse';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }
    
    animateCounter(elementId, start, end) {
        const element = document.getElementById(elementId);
        if (!element) return;
        
        let current = start;
        const increment = Math.ceil((end - start) / 50);
        const duration = 2000;
        const stepTime = Math.floor(duration / 50);
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= end) {
                current = end;
                clearInterval(timer);
            }
            element.textContent = current;
        }, stepTime);
    }
    
    getCategoryColor(category) {
        const categories = this.getStaticCategories();
        const found = categories.find(c => c.value === category);
        return found ? found.color : '#718096';
    }
    
    getCategoryIcon(category) {
        const categories = this.getStaticCategories();
        const found = categories.find(c => c.value === category);
        return found ? found.icon : 'fas fa-map-marker-alt';
    }
    
    capitalizeFirstLetter(string) {
        if (!string) return '';
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    
    escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    window.mapApp = new InteractiveMap();
    
    const infoCards = document.querySelectorAll('.info-card');
    infoCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('pulse');
        });
        card.addEventListener('mouseleave', function() {
            this.classList.remove('pulse');
        });
    });
});

// Fonction pour envoyer la hauteur à l'iframe parent
function sendHeight() {
    const height = document.body.scrollHeight;
    if (window.parent && window.parent !== window) {
        window.parent.postMessage({
            type: 'setHeight',
            iframeId: 'affichez-vos-entreprises',
            height: height
        }, '*');
    }
}

window.onload = sendHeight;
window.onresize = sendHeight;

</script>
