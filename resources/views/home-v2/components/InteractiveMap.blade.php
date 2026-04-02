{{-- Interactive Map Component - Carte interactive avec filtres et détails --}}
<section class="interactive-map-v2-section" id="carte-interactive">
    <div class="interactive-map-v2-container">
        <div class="interactive-map-v2-main-layout">
            {{-- ÉCRAN GAUCHE : Carte + Sidebar --}}
            <div class="interactive-map-v2-left-screen">
                {{-- Header écran gauche --}}
                <div class="interactive-map-v2-left-header">
                    <h1 class="interactive-map-v2-title">
                        <span class="interactive-map-v2-title-main">CARTES INTERACTIVES</span>
                        <span class="interactive-map-v2-title-separator">/</span>
                        <span class="interactive-map-v2-title-sub">THÉMATIQUES</span>
                        <span class="interactive-map-v2-title-separator">/</span>
                        <span class="interactive-map-v2-title-cta">CALL-TO-ACTION</span>
                    </h1>
                    <p class="interactive-map-v2-subtitle">Explorez nos lieux d'intérêt business et tourisme sur la carte</p>
                    <a href="#" class="interactive-map-v2-link">VOIR LES INFO GÉOVIDÉOSMAKER ICI</a>
                </div>
                
                {{-- Contenu écran gauche --}}
                <div class="interactive-map-v2-left-content">
                {{-- Carte avec marqueurs --}}
                <div class="interactive-map-v2-map-wrapper">
                    <div id="interactiveMap" class="interactive-map-v2-map"></div>
                    
                    {{-- Popup au hover sur marqueur --}}
<div class="interactive-map-v2-hover-popup" id="hoverPopup" style="display: none;">
    <div class="interactive-map-v2-hover-video">
        <iframe
            id="hoverIframe"
            width="100%"
            height="160"
            src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=0&mute=1"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
        ></iframe>
        <div class="interactive-map-v2-hover-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="white">
                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
            </svg>
            YouTube
        </div>
    </div>
    <div class="interactive-map-v2-hover-info">
        <p class="interactive-map-v2-hover-description" id="hoverDescription"></p>
        <div class="interactive-map-v2-hover-actions">
            <button class="interactive-map-v2-hover-btn details" data-action="details">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                </svg>
                Voir détails
            </button>
            <button class="interactive-map-v2-hover-btn location" data-action="location">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
                Voir
            </button>
            <button class="interactive-map-v2-hover-btn youtube" data-action="youtube">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="white">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
            </button>
        </div>
    </div>
</div>

                    {{-- Légende des activités sur la carte --}}
                    <div class="interactive-map-v2-legend">
                        <h4 class="interactive-map-v2-legend-title">ACTIVITÉS À PROXIMITÉS</h4>
                        <ul class="interactive-map-v2-legend-list">
                            <li class="interactive-map-v2-legend-item">
                                <span class="interactive-map-v2-legend-icon restaurant">🍽️</span>
                                <span>RESTAURANTS</span>
                            </li>
                            <li class="interactive-map-v2-legend-item">
                                <span class="interactive-map-v2-legend-icon experience">🎯</span>
                                <span>EXPÉRIENCES AVENTURES</span>
                            </li>
                            <li class="interactive-map-v2-legend-item">
                                <span class="interactive-map-v2-legend-icon museum">🏛️</span>
                                <span>MUSÉES, ÉVÉNEMENTS</span>
                            </li>
                            <li class="interactive-map-v2-legend-item">
                                <span class="interactive-map-v2-legend-icon urgency">🚨</span>
                                <span>URGENCES, ETC</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Sidebar verticale scrollable --}}
                <div class="interactive-map-v2-sidebar-scroll">
                    {{-- Filtres --}}
                    <div class="interactive-map-v2-filters">
                    <button class="interactive-map-v2-filter-toggle" id="filterToggle">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="4" y1="6" x2="20" y2="6"></line>
                            <line x1="4" y1="12" x2="20" y2="12"></line>
                            <line x1="4" y1="18" x2="20" y2="18"></line>
                        </svg>
                    </button>

                    <div class="interactive-map-v2-filter-group">
                        <label class="interactive-map-v2-filter-label">Ville :</label>
                        <select class="interactive-map-v2-filter-select" id="regionFilter">
                            <option value="">Toutes les villes</option>
                            {{-- Les villes seront chargées dynamiquement depuis l'API --}}
                        </select>
                    </div>

                    <div class="interactive-map-v2-filter-group">
                        <label class="interactive-map-v2-filter-label">Catégorie :</label>
                        <select class="interactive-map-v2-filter-select" id="categoryFilter">
                            <option value="">Toutes les catégories</option>
                            <option value="restaurant">Restaurants</option>
                            <option value="museum">Musées</option>
                            <option value="hotel">Hôtels</option>
                            <option value="activity">Activités</option>
                        </select>
                    </div>

                    <button class="interactive-map-v2-locate-btn" id="locateBtn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3A8.994 8.994 0 0 0 13 3.06V1h-2v2.06A8.994 8.994 0 0 0 3.06 11H1v2h2.06A8.994 8.994 0 0 0 11 20.94V23h2v-2.06A8.994 8.994 0 0 0 20.94 13H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"/>
                        </svg>
                        Me localiser
                    </button>

                        <div class="interactive-map-v2-results-count">
                            <span id="resultsCount">0</span> lieux trouvés dans la zone
                        </div>
                    </div>

                    {{-- Liste des cartes destinations scrollable --}}
                    <div class="interactive-map-v2-destinations-list" id="destinationsList">
                        {{-- Les cartes seront générées par JavaScript --}}
                    </div>
                </div>
                </div>
                
                {{-- Footer écran gauche --}}
                <div class="interactive-map-v2-left-footer">
                    <div class="interactive-map-v2-logo">
                        <img src="{{ asset('GO-EXPLORIA-MY-TUBE.png') }}" alt="GO EXPLORIA" class="interactive-map-v2-logo-img">
                    </div>
                    <p class="interactive-map-v2-logo-subtitle">GÉO VIDÉOS MAKER</p>
                </div>
            </div>

            {{-- ÉCRAN DROIT : Détails de la destination --}}
            <div class="interactive-map-v2-right-screen" id="detailsScreen" style="display: none;">
                {{-- Header écran droit --}}
                <div class="interactive-map-v2-right-header">
                    <p class="interactive-map-v2-cta-title">DÉTAILS DES ENTREPRISES</p>
                    <p class="interactive-map-v2-cta-subtitle">CRÉEZ VOTRE CHAÎNE VIDÉOS ICI</p>
                </div>
                
                <div class="interactive-map-v2-details-panel">
                    <button class="interactive-map-v2-details-close" id="closeDetailsScreen">×</button>
                    
                    <div class="interactive-map-v2-details-header">
                        <h3 class="interactive-map-v2-details-title">Musée des Beaux-Arts de Montréal</h3>
                        <div class="interactive-map-v2-details-badges">
                            <span class="interactive-map-v2-badge museum">Museum</span>
                            <span class="interactive-map-v2-badge location">Québec</span>
                        </div>
                    </div>

                    <div class="interactive-map-v2-details-video">
                        <iframe 
                            width="100%" 
                            height="280" 
                            src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen
                        ></iframe>
                    </div>

                    <div class="interactive-map-v2-details-info">
                        <div class="interactive-map-v2-details-content">
                            <p class="interactive-map-v2-details-text">Plus grand musée d'art du Canada avec collections internationales.</p>
                        </div>

                        <div class="interactive-map-v2-contact-info">
                            <div class="interactive-map-v2-contact-item">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                                <h4>Adresse</h4>
                                <p>1380 Rue Sherbrooke O, Montréal</p>
                            </div>

                            <div class="interactive-map-v2-contact-item">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                </svg>
                                <h4>Contact</h4>
                                <p>+1-514-285-2000</p>
                            </div>

                            <div class="interactive-map-v2-contact-item">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/>
                                </svg>
                                <h4>Site web</h4>
                                <a href="#" target="_blank">Visiter le site</a>
                            </div>
                        </div>

                        <div class="interactive-map-v2-social-links">
                            <a href="#" class="interactive-map-v2-social-btn facebook">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="interactive-map-v2-social-btn youtube">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                            <a href="#" class="interactive-map-v2-social-btn linkedin">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            <a href="#" class="interactive-map-v2-social-btn tiktok">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                </svg>
                            </a>
                        </div>

                        <div class="interactive-map-v2-details-actions">
                            <button class="interactive-map-v2-action-btn itinerary" id="itineraryBtn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21.71 11.29l-9-9c-.39-.39-1.02-.39-1.41 0l-9 9c-.39.39-.39 1.02 0 1.41l9 9c.39.39 1.02.39 1.41 0l9-9c.39-.38.39-1.01 0-1.41zM14 14.5V12h-4v3H8v-4c0-.55.45-1 1-1h5V7.5l3.5 3.5-3.5 3.5z"/>
                                </svg>
                                Itinéraire
                            </button>
                            <button class="interactive-map-v2-action-btn close" id="closeDetailsBtn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                </svg>
                                Fermer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
