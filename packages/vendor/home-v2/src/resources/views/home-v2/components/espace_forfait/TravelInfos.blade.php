@php
    $tr = static function (string $text): string {
        $locale = app()->getLocale();
        if ($locale === 'fr') {
            return $text;
        }

        static $maps = [];
        if (! array_key_exists($locale, $maps)) {
            $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
            $maps[$locale] = is_file($path) ? (require $path) : [];
        }

        return $maps[$locale][$text] ?? $text;
    };
@endphp

<section class="travel-section" id="alertes-voyages">

    {{-- ============================================================
         EN-TÊTE STANDARD — ALERTE VOYAGES / COMPAGNIES AÉRIENNES
    ============================================================ --}}
    <div class="resto-header-block">

        <div class="resto-header-main">

            {{-- Logo gauche : GoExploria --}}
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="{{ $tr('GoExploria') }}">
                    <div class="logo-wrapper">
                        <img src="{{ asset('logo.png') }}" alt="{{ $tr('GoExploria') }}">
                    </div>
                    <span class="resto-accord-btn-label">{{ $tr('GoExploria') }}</span>
                    <span class="resto-accord-btn-cta">
                        <i class="fas fa-external-link-alt"></i> {{ $tr('Visiter') }}
                    </span>
                </a>
            </div>

            {{-- Centre : titre + sous-titre + onglets --}}
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('ALERTE VOYAGES / COMPAGNIES AÉRIENNES') }}</h1>
                <p class="resto-header-subtitle">{{ $tr('Informations en temps réel · Alertes, vols en direct et compagnies aériennes partenaires') }}</p></div>

            {{-- Logo droit : Compagnie Aérienne --}}
            <div class="resto-header-logo-right">
                <a href="#" class="resto-accord-btn" title="{{ $tr('Compagnie Aérienne') }}">
                    <div class="logo-wrapper travelinfo-airline-icon">
                        <i class="fas fa-plane-departure"></i>
                    </div>
                    <span class="resto-accord-btn-label">{{ $tr('Compagnie Aérienne') }}</span>
                    <span class="resto-accord-btn-cta">
                        <i class="fas fa-external-link-alt"></i> {{ $tr('Partenaires') }}
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

    <div class="resto-dest-breadcrumb vp-dest-breadcrumb">
        <select id="vp-continent-select" class="vp-dest-select" aria-label="Continent">
            <option value="amerique-nord">Amérique du Nord</option>
            <option value="europe">Europe</option>
            <option value="afrique">Afrique</option>
            <option value="asie">Asie</option>
            <option value="amerique-sud">Amérique du Sud</option>
            <option value="oceanie">Océanie</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-country-select" class="vp-dest-select" aria-label="Pays">
            <option value="canada">Canada</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-province-select" class="vp-dest-select" aria-label="Province">
            <option value="quebec">Québec</option>
            <option value="ontario">Ontario</option>
            <option value="alberta">Alberta</option>
            <option value="colombie-britannique">Colombie-Britannique</option>
            <option value="nouvelle-ecosse">Nouvelle-Écosse</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-region-select" class="vp-dest-select" aria-label="Région">
            <option value="region-de-quebec">Région de Québec</option>
            <option value="montreal-metro">Montréal Métro</option>
            <option value="mauricie">Mauricie</option>
            <option value="gaspesie">Gaspésie</option>
            <option value="saguenay">Saguenay</option>
        </select>
    </div>
</div>

            <div class="resto-actions-row">
                <div class="resto-header-ctas">
                    <a href="#" class="resto-cta-btn primary">
                        <i class="fas fa-calendar-check"></i> {{ $tr('Réservez') }}
                    </a>
                    <a href="#" class="resto-cta-btn secondary">
                        {{ $tr('En savoir') }} <span class="cta-plus">+</span>
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
                    <h2 class="info-section-title">{{ $tr('Alertes voyage') }}</h2>
                    <p class="info-section-sub">{{ $tr('Informations en temps réel • 3 alertes') }}</p>
                </div>
            </div>

            <!-- Alerte 1 - Orange (Météo) -->
            <div class="alert-card">
                <div class="alert-icon alert-orange"><i class="fas fa-wind"></i></div>
                <div class="alert-content">
                    <h3 class="alert-title">{{ $tr('Fortes turbulences - Atlantique Nord') }}</h3>
                    <p class="alert-desc">{{ $tr('Des turbulences sévères sont signalées sur les vols entre New York et Londres. Prévoyez des retards possibles.') }}</p>
                    <div class="alert-meta">
                        <span class="meta-item"><i class="far fa-clock"></i> {{ $tr('Il y a 25 min') }}</span>
                        <span class="meta-item"><i class="fas fa-map-marker-alt"></i> {{ $tr('Zone A4') }}</span>
                        <span class="meta-item"><i class="fas fa-plane"></i> {{ $tr('8 vols concernés') }}</span>
                    </div>
                </div>
            </div>

            <!-- Alerte 2 - Bleue (Grève) -->
            <div class="alert-card">
                <div class="alert-icon alert-blue"><i class="fas fa-bullhorn"></i></div>
                <div class="alert-content">
                    <h3 class="alert-title">{{ $tr('Mouvement social - Aéroport de Paris') }}</h3>
                    <p class="alert-desc">{{ $tr('Préavis de grève des contrôleurs aériens ce vendredi. Jusqu\'à 40% des vols pourraient être annulés.') }}</p>
                    <div class="alert-meta">
                        <span class="meta-item"><i class="far fa-clock"></i> {{ $tr('Il y a 2h') }}</span>
                        <span class="meta-item"><i class="fas fa-map-marker-alt"></i> {{ $tr('CDG, ORY') }}</span>
                        <span class="meta-item"><i class="far fa-calendar-alt"></i> {{ $tr('15-16 Mars') }}</span>
                    </div>
                </div>
            </div>

            <!-- Alerte 3 - Rouge (Sécurité) -->
            <div class="alert-card">
                <div class="alert-icon alert-red"><i class="fas fa-shield-alt"></i></div>
                <div class="alert-content">
                    <h3 class="alert-title">{{ $tr('Niveau de sécurité renforcé - Tel Aviv') }}</h3>
                    <p class="alert-desc">{{ $tr('Mesures de contrôle supplémentaires. Prévoyez 3h d\'avance pour votre départ.') }}</p>
                    <div class="alert-meta">
                        <span class="meta-item"><i class="far fa-clock"></i> {{ $tr('Il y a 45 min') }}</span>
                        <span class="meta-item"><i class="fas fa-map-marker-alt"></i> {{ $tr('TLV') }}</span>
                        <span class="meta-item"><i class="fas fa-exclamation-circle"></i> {{ $tr('Vigilance') }}</span>
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
                    <h2 class="info-section-title">{{ $tr('COMPAGNIES AÉRIENNES') }}</h2>
                    <p class="info-section-sub">{{ $tr('Suivi des départs • 4 vols') }}</p>
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
                            <span>{{ $tr('Paris → New York') }}</span>
                            <span class="status-badge">{{ $tr('À l\'heure') }}</span>
                        </p>
                        <div class="flight-time">
                            <i class="far fa-clock"></i> {{ $tr('14:45 • Terminal 2E') }}
                        </div>
                        <div class="weather-badge">
                            <i class="fas fa-cloud"></i> {{ $tr('7°C • Visibilité bonne') }}
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
                            <span>{{ $tr('Francfort → Tokyo') }}</span>
                            <span class="status-badge status-warning">{{ $tr('Retard 25min') }}</span>
                        </p>
                        <div class="flight-time">
                            <i class="far fa-clock"></i> {{ $tr('22:10 • Porte B43') }}
                        </div>
                        <div class="weather-badge">
                            <i class="fas fa-cloud-showers-heavy"></i> {{ $tr('13°C • Pluie légère') }}
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
                            <span>{{ $tr('Londres → Dubai') }}</span>
                            <span class="status-badge">{{ $tr('À l\'heure') }}</span>
                        </p>
                        <div class="flight-time">
                            <i class="far fa-clock"></i> {{ $tr('09:20 • Gate 12') }}
                        </div>
                        <div class="weather-badge">
                            <i class="fas fa-sun"></i> {{ $tr('28°C • Ciel dégagé') }}
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
                            <span>{{ $tr('Milan → Dubaï') }}</span>
                            <span class="status-badge">{{ $tr('Embarquement') }}</span>
                        </p>
                        <div class="flight-time">
                            <i class="far fa-clock"></i> {{ $tr('16:30 • Porte D7') }}
                        </div>
                        <div class="weather-badge">
                            <i class="fas fa-sun"></i> {{ $tr('22°C • Vent faible') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lien voir tous les vols -->
            <div style="margin-top: 30px; text-align: right;">
                <a href="#" class="btn-outline-primary">
                    {{ $tr('Voir tous les vols') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>
