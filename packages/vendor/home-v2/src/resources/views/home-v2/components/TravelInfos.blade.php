<section class="travel-section">

    {{-- ============================================================
         EN-TÊTE STANDARD — ALERTE VOYAGES / COMPAGNIES AÉRIENNES
    ============================================================ --}}
    <div class="resto-header-block">

        <div class="resto-header-main">

            {{-- Logo gauche : GoExploria --}}
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

            {{-- Centre : titre + sous-titre + onglets --}}
            <div class="resto-header-center">
                <h1 class="resto-header-title">ALERTE VOYAGES / COMPAGNIES AÉRIENNES</h1>
                <p class="resto-header-subtitle">Informations en temps réel · Alertes, vols en direct et compagnies aériennes partenaires</p>

                <div class="resto-header-tabs">
                    <button class="resto-tab-btn active">
                        <i class="fas fa-exclamation-triangle"></i> Alertes voyage
                    </button>
                    <button class="resto-tab-btn">
                        <i class="fas fa-plane-departure"></i> Vols en direct
                    </button>
                    <button class="resto-tab-btn">
                        <i class="fas fa-plane"></i> Compagnie aérienne
                    </button>
                </div>
            </div>

            {{-- Logo droit : Compagnie Aérienne --}}
            <div class="resto-header-logo-right">
                <a href="#" class="resto-accord-btn" title="Compagnie Aérienne">
                    <div class="logo-wrapper travelinfo-airline-icon">
                        <i class="fas fa-plane-departure"></i>
                    </div>
                    <span class="resto-accord-btn-label">Compagnie Aérienne</span>
                    <span class="resto-accord-btn-cta">
                        <i class="fas fa-external-link-alt"></i> Partenaires
                    </span>
                </a>
            </div>

        </div>

        {{-- Barre Destinations + Filtres --}}
        <div class="resto-header-destinations-bar">

            <div class="resto-dest-row">
                <div class="resto-dest-icon-box">
                    <img src="{{ asset('REDI.png') }}" alt="Destinations">
                    <span>Destinations</span>
                </div>
                  <div class="resto-dest-row">
                <div class="resto-dest-icon-box">
                    <img src="{{ asset('REDI.png') }}" alt="Destinations">
                    <span>Destinations</span>
                </div>
                <div class="resto-dest-breadcrumb">
                    <a href="#" class="resto-dest-link active">Toutes destinations</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">Europe</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">Ontario</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">Mauricie</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">Île d'Orléans</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">Vieux-Québec</a>
                </div>
            </div>
            </div>

            <div class="resto-actions-row">
                <div class="resto-header-ctas">
                    <a href="#" class="resto-cta-btn primary">
                        <i class="fas fa-calendar-check"></i> Réservez
                    </a>
                    <a href="#" class="resto-cta-btn secondary">
                        En savoir <span class="cta-plus">+</span>
                    </a>
                </div>
            </div>

        </div>

        <div class="resto-header-shimmer"></div>
    </div>{{-- /.resto-header-block --}}

    <div class="travel-container">
        
        <!-- COLONNE GAUCHE : ALERTS VOYAGE -->
        <div class="travel-alerts">
            <div class="info-section-header">
                <div class="info-section-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <h2 class="info-section-title">Alertes voyage</h2>
                    <p class="info-section-sub">Informations en temps réel • 3 alertes</p>
                </div>
            </div>

            <!-- Alerte 1 - Orange (Météo) -->
            <div class="alert-card">
                <div class="alert-icon alert-orange"><i class="fas fa-wind"></i></div>
                <div class="alert-content">
                    <h3 class="alert-title">Fortes turbulences - Atlantique Nord</h3>
                    <p class="alert-desc">Des turbulences sévères sont signalées sur les vols entre New York et Londres. Prévoyez des retards possibles.</p>
                    <div class="alert-meta">
                        <span class="meta-item"><i class="far fa-clock"></i> Il y a 25 min</span>
                        <span class="meta-item"><i class="fas fa-map-marker-alt"></i> Zone A4</span>
                        <span class="meta-item"><i class="fas fa-plane"></i> 8 vols concernés</span>
                    </div>
                </div>
            </div>

            <!-- Alerte 2 - Bleue (Grève) -->
            <div class="alert-card">
                <div class="alert-icon alert-blue"><i class="fas fa-bullhorn"></i></div>
                <div class="alert-content">
                    <h3 class="alert-title">Mouvement social - Aéroport de Paris</h3>
                    <p class="alert-desc">Préavis de grève des contrôleurs aériens ce vendredi. Jusqu'à 40% des vols pourraient être annulés.</p>
                    <div class="alert-meta">
                        <span class="meta-item"><i class="far fa-clock"></i> Il y a 2h</span>
                        <span class="meta-item"><i class="fas fa-map-marker-alt"></i> CDG, ORY</span>
                        <span class="meta-item"><i class="far fa-calendar-alt"></i> 15-16 Mars</span>
                    </div>
                </div>
            </div>

            <!-- Alerte 3 - Rouge (Sécurité) -->
            <div class="alert-card">
                <div class="alert-icon alert-red"><i class="fas fa-shield-alt"></i></div>
                <div class="alert-content">
                    <h3 class="alert-title">Niveau de sécurité renforcé - Tel Aviv</h3>
                    <p class="alert-desc">Mesures de contrôle supplémentaires. Prévoyez 3h d'avance pour votre départ.</p>
                    <div class="alert-meta">
                        <span class="meta-item"><i class="far fa-clock"></i> Il y a 45 min</span>
                        <span class="meta-item"><i class="fas fa-map-marker-alt"></i> TLV</span>
                        <span class="meta-item"><i class="fas fa-exclamation-circle"></i> Vigilance</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- COLONNE DROITE : BULLETS D'AVIONS -->
        <div class="travel-bullets">
            <div class="info-section-header">
                <div class="info-section-icon">
                    <i class="fas fa-plane-departure"></i>
                </div>
                <div>
                    <h2 class="info-section-title">COMPAGNIES AÉRIENNES</h2>
                    <p class="info-section-sub">Suivi des départs • 4 vols</p>
                </div>
            </div>

            <div class="bullets-grid">
                <!-- Bullet 1 - AF 164 -->
                <div class="bullet-item">
                    <div class="plane-icon">
                        <i class="fas fa-plane"></i>
                    </div>
                    <div class="plane-details">
                        <h4 class="plane-route">
                            <span>AF 164</span>
                            <i class="fas fa-arrow-right"></i>
                        </h4>
                        <p class="plane-status">
                            <span>Paris → New York</span>
                            <span class="status-badge">À l'heure</span>
                        </p>
                        <div class="flight-time">
                            <i class="far fa-clock"></i> 14:45 • Terminal 2E
                        </div>
                        <div class="weather-badge">
                            <i class="fas fa-cloud"></i> 7°C • Visibilité bonne
                        </div>
                    </div>
                </div>

                <!-- Bullet 2 - LH 456 -->
                <div class="bullet-item">
                    <div class="plane-icon">
                        <i class="fas fa-plane"></i>
                    </div>
                    <div class="plane-details">
                        <h4 class="plane-route">
                            <span>LH 456</span>
                            <i class="fas fa-arrow-right"></i>
                        </h4>
                        <p class="plane-status">
                            <span>Francfort → Tokyo</span>
                            <span class="status-badge status-warning">Retard 25min</span>
                        </p>
                        <div class="flight-time">
                            <i class="far fa-clock"></i> 22:10 • Porte B43
                        </div>
                        <div class="weather-badge">
                            <i class="fas fa-cloud-showers-heavy"></i> 13°C • Pluie légère
                        </div>
                    </div>
                </div>

                <!-- Bullet 3 - BA 278 -->
                <div class="bullet-item">
                    <div class="plane-icon">
                        <i class="fas fa-plane"></i>
                    </div>
                    <div class="plane-details">
                        <h4 class="plane-route">
                            <span>BA 278</span>
                            <i class="fas fa-arrow-right"></i>
                        </h4>
                        <p class="plane-status">
                            <span>Londres → Dubai</span>
                            <span class="status-badge">À l'heure</span>
                        </p>
                        <div class="flight-time">
                            <i class="far fa-clock"></i> 09:20 • Gate 12
                        </div>
                        <div class="weather-badge">
                            <i class="fas fa-sun"></i> 28°C • Ciel dégagé
                        </div>
                    </div>
                </div>

                <!-- Bullet 4 - EK 202 -->
                <div class="bullet-item">
                    <div class="plane-icon">
                        <i class="fas fa-plane"></i>
                    </div>
                    <div class="plane-details">
                        <h4 class="plane-route">
                            <span>EK 202</span>
                            <i class="fas fa-arrow-right"></i>
                        </h4>
                        <p class="plane-status">
                            <span>Milan → Dubaï</span>
                            <span class="status-badge">Embarquement</span>
                        </p>
                        <div class="flight-time">
                            <i class="far fa-clock"></i> 16:30 • Porte D7
                        </div>
                        <div class="weather-badge">
                            <i class="fas fa-sun"></i> 22°C • Vent faible
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lien voir tous les vols -->
            <div style="margin-top: 30px; text-align: right;">
                <a href="#" class="btn-outline-primary">
                    Voir tous les vols <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>
