{{-- ============================================================
     BLOC 7 — ESPACES TÉLÉ-POSITIONNEMENT
     Géolocalisation avancée · Cartes interactives · Suivi GPS · Zones de chalandise
     ============================================================ --}}
@php
    $tr = static function (string $text): string {
        $locale = app()->getLocale();
        if ($locale === 'fr') return $text;
        static $maps = [];
        if (!array_key_exists($locale, $maps)) {
            $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
            $maps[$locale] = is_file($path) ? (require $path) : [];
        }
        return $maps[$locale][$text] ?? $text;
    };

    $geoTools = [
        [
            'icon' => 'fas fa-map-marker-alt',
            'color' => '#e8761a',
            'title' => 'Géolocalisation Temps Réel',
            'desc' => 'Suivez vos collaborateurs, flottes ou actifs en temps réel sur une carte interactive. Historique des positions et alertes de zone.',
            'tag' => 'Live tracking'
        ],
        [
            'icon' => 'fas fa-draw-polygon',
            'color' => '#3b82f6',
            'title' => 'Zones de Chalandise',
            'desc' => 'Définissez et visualisez vos zones d\'influence. Analyse de couverture, isochrones et géomarketing avancé.',
            'tag' => 'Geomarketing'
        ],
        [
            'icon' => 'fas fa-chart-pie',
            'color' => '#10b981',
            'title' => 'Analyse de Flux',
            'desc' => 'Cartographie des déplacements, points de passage fréquents, heatmaps et optimisation des tournées.',
            'tag' => 'Heatmap'
        ],
        [
            'icon' => 'fas fa-bell',
            'color' => '#8b5cf6',
            'title' => 'Alertes Géospatiales',
            'desc' => 'Notifications automatiques à l\'entrée/sortie de zones prédéfinies. Idéal pour la sécurité et la logistique.',
            'tag' => 'Geofencing'
        ],
        [
            'icon' => 'fas fa-route',
            'color' => '#f59e0b',
            'title' => 'Optimisation d\'Itinéraires',
            'desc' => 'Calcul automatique des trajets optimaux multi-points. Réduction des temps de trajet et de la consommation.',
            'tag' => 'Routing'
        ],
        [
            'icon' => 'fas fa-chart-line',
            'color' => '#ef4444',
            'title' => 'Statistiques & Reporting',
            'desc' => 'Tableaux de bord personnalisés : distances parcourues, temps d\'arrêt, performances par zone.',
            'tag' => 'Analytics'
        ],
    ];

    $useCases = [
        ['icon' => 'fas fa-truck', 'title' => 'Logistique & Transport', 'desc' => 'Suivez votre flotte en temps réel'],
        ['icon' => 'fas fa-store', 'title' => 'Commerces & Retail', 'desc' => 'Analysez votre zone de chalandise'],
        ['icon' => 'fas fa-hard-hat', 'title' => 'Chantiers & Construction', 'desc' => 'Gérez vos équipes sur le terrain'],
        ['icon' => 'fas fa-hand-holding-heart', 'title' => 'Services à la personne', 'desc' => 'Optimisez les tournées d\'intervention'],
        ['icon' => 'fas fa-taxi', 'title' => 'Mobilité & VTC', 'desc' => 'Suivez vos véhicules en direct'],
        ['icon' => 'fas fa-building', 'title' => 'Immobilier', 'desc' => 'Cartographiez vos biens et prospects'],
    ];
@endphp

<section class="nl-geo-section" id="nl-geo">

    {{-- EN-TÊTE STANDARD --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="Géolocalisation Next Level">
                    <div class="logo-wrapper">
                        <img src="{{ asset('images/Next-level.png') }}" alt="Next Level">
                    </div>
                    <span class="resto-accord-btn-label">Géo Tracking</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-map-marker-alt"></i> Pro</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('ESPACES TÉLÉ-POSITIONNEMENT') }}</h1>
                <h2 class="resto-header-eyebrow">{{ $tr('Géolocalisation avancée — Cartes · Suivi GPS · Zones de chalandise') }}</h2>
                <p class="resto-header-subtitle">{{ $tr('Solution professionnelle de géolocalisation temps réel. Optimisez vos déplacements, sécurisez vos équipes et analysez vos zones d\'influence.') }}</p>
            </div>
            <div class="resto-header-logo-right">
                <a href="{{ url('next-level-geolocalisation') }}" title="{{ $tr('Découvrir') }}" target="_blank" rel="noopener noreferrer">
                    <img class="bt-next-level-image" src="{{ asset('images/Next-level.png') }}" alt="{{ $tr('Next Level') }}" loading="lazy">
                </a>
            </div>
        </div>
        @include('home-v2.components.espace_next_level.SectionNavBarNextLevel')
        <div class="resto-header-shimmer"></div>
    </div>

    <div class="nl-geo-body">

        {{-- HERO BANNER --}}
        <div class="nl-geo-hero">
            <div class="nl-geo-hero-content">
                <div class="nl-geo-badge">
                    <i class="fas fa-satellite-dish"></i> {{ $tr('Précision GPS · Mise à jour 1s') }}
                </div>
                <h2>
                    {{ $tr('Géolocalisez vos actifs') }}<br>
                    <em>{{ $tr('en temps réel, où qu\'ils soient') }}</em>
                </h2>
                <p>{{ $tr('Notre plateforme de télé-positionnement vous offre une vision complète de vos actifs mobiles. Suivez vos collaborateurs, véhicules ou équipements sur une carte interactive, définissez des zones de sécurité et analysez vos flux de déplacement.') }}</p>
                <div class="nl-geo-stats">
                    <div class="nl-geo-stat"><i class="fas fa-map-marked-alt"></i><div><strong>1M+</strong><span>{{ $tr('Positions/jour') }}</span></div></div>
                    <div class="nl-geo-stat"><i class="fas fa-satellite"></i><div><strong>&lt;1s</strong><span>{{ $tr('Latence') }}</span></div></div>
                    <div class="nl-geo-stat"><i class="fas fa-draw-polygon"></i><div><strong>Illimité</strong><span>{{ $tr('Zones') }}</span></div></div>
                    <div class="nl-geo-stat"><i class="fas fa-shield-alt"></i><div><strong>GDPR</strong><span>{{ $tr('Conforme') }}</span></div></div>
                </div>
                <div class="nl-geo-actions">
                    <a href="{{ url('next-level-geo-demo') }}" class="nl-btn-primary" target="_blank">
                        <i class="fas fa-map"></i> {{ $tr('Essayer la démo interactive') }}
                    </a>
                    <a href="#nl-geo-features" class="nl-btn-secondary-geo">
                        <i class="fas fa-arrow-down"></i> {{ $tr('En savoir plus') }}
                    </a>
                </div>
            </div>
            <div class="nl-geo-hero-visual">
                <div class="nl-geo-map-mock">
                    <div class="nl-map-header">
                        <i class="fas fa-map-pin"></i> {{ $tr('Live Tracking — 12 actifs connectés') }}
                        <span class="nl-map-live"><i class="fas fa-circle"></i> {{ $tr('En direct') }}</span>
                    </div>
                    <div class="nl-map-container">
                        <div class="nl-map-bg"></div>
                        <div class="nl-map-marker nl-marker-1" style="top:30%;left:25%">
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="nl-marker-label">Client A</span>
                        </div>
                        <div class="nl-map-marker nl-marker-2" style="top:55%;left:45%">
                            <i class="fas fa-truck"></i>
                            <span class="nl-marker-label">Véhicule #12</span>
                        </div>
                        <div class="nl-map-marker nl-marker-3" style="top:70%;left:65%">
                            <i class="fas fa-user"></i>
                            <span class="nl-marker-label">Jean Martin</span>
                        </div>
                        <div class="nl-map-marker nl-marker-4" style="top:20%;left:70%">
                            <i class="fas fa-store"></i>
                            <span class="nl-marker-label">Magasin Lyon</span>
                        </div>
                        <div class="nl-map-zone" style="top:40%;left:30%;width:120px;height:120px">
                            <div class="nl-zone-label">Zone sécurisée</div>
                        </div>
                        <div class="nl-map-route"></div>
                    </div>
                    <div class="nl-map-footer">
                        <div class="nl-map-legend">
                            <span><i class="fas fa-map-marker-alt" style="color:#e8761a"></i> {{ $tr('Actifs mobiles') }}</span>
                            <span><i class="fas fa-store" style="color:#3b82f6"></i> {{ $tr('Points d\'intérêt') }}</span>
                            <span><i class="fas fa-draw-polygon" style="color:#10b981"></i> {{ $tr('Zones définies') }}</span>
                        </div>
                        <div class="nl-map-update">{{ $tr('Dernière mise à jour : il y a 2s') }} <i class="fas fa-sync-alt fa-spin"></i></div>
                    </div>
                </div>
                <div class="nl-geo-floating-card">
                    <i class="fas fa-bell"></i>
                    <div>
                        <strong>{{ $tr('Entrée en zone sécurisée') }}</strong>
                        <span>{{ $tr('Véhicule #12 est arrivé • 14:32') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- FEATURES GRID --}}
        <div class="nl-geo-features" id="nl-geo-features">
            <div class="nl-section-header">
                <span class="nl-section-eyebrow"><i class="fas fa-cogs"></i> {{ $tr('Fonctionnalités avancées') }}</span>
                <h3>{{ $tr('Une solution complète de') }}<br><span class="nl-gradient-text">{{ $tr('télé-positionnement') }}</span></h3>
                <p>{{ $tr('Gérez, surveillez et optimisez tous vos actifs géolocalisés depuis une interface unique.') }}</p>
            </div>
            <div class="nl-geo-features-grid">
                @foreach($geoTools as $tool)
                <div class="nl-geo-feature-card">
                    <div class="nl-geo-feature-icon" style="background:{{ $tool['color'] }}20;color:{{ $tool['color'] }}">
                        <i class="{{ $tool['icon'] }}"></i>
                    </div>
                    <h4>{{ $tr($tool['title']) }}</h4>
                    <p>{{ $tr($tool['desc']) }}</p>
                    <div class="nl-geo-feature-tag" style="background:{{ $tool['color'] }}15;color:{{ $tool['color'] }}">
                        {{ $tr($tool['tag']) }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- USE CASES --}}
        <div class="nl-geo-usecases">
            <div class="nl-section-header">
                <span class="nl-section-eyebrow"><i class="fas fa-briefcase"></i> {{ $tr('Cas d\'usage') }}</span>
                <h3>{{ $tr('Adapté à tous les secteurs') }}<br><span class="nl-gradient-text">{{ $tr('d\'activité') }}</span></h3>
                <p>{{ $tr('Des solutions sur mesure pour chaque métier.') }}</p>
            </div>
            <div class="nl-usecases-grid">
                @foreach($useCases as $case)
                <div class="nl-usecase-card">
                    <div class="nl-usecase-icon"><i class="{{ $case['icon'] }}"></i></div>
                    <h4>{{ $tr($case['title']) }}</h4>
                    <p>{{ $tr($case['desc']) }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- TECHNOLOGIES --}}
        <div class="nl-geo-tech">
            <div class="nl-tech-content">
                <span class="nl-tech-badge"><i class="fas fa-microchip"></i> {{ $tr('Technologies supportées') }}</span>
                <h3>{{ $tr('Multi-technologies,') }}<br><span class="nl-gradient-text">{{ $tr('multi-appareils') }}</span></h3>
                <p>{{ $tr('Notre solution s\'adapte à tous vos équipements : smartphones, traceurs GPS embarqués, balises dédiées ou API.') }}</p>
                <div class="nl-tech-icons">
                    <div class="nl-tech-item"><i class="fas fa-mobile-alt"></i> <span>iOS / Android</span></div>
                    <div class="nl-tech-item"><i class="fas fa-truck-moving"></i> <span>Traceurs embarqués</span></div>
                    <div class="nl-tech-item"><i class="fas fa-microchip"></i> <span>Balises GPS</span></div>
                    <div class="nl-tech-item"><i class="fas fa-code"></i> <span>API REST</span></div>
                    <div class="nl-tech-item"><i class="fas fa-bluetooth"></i> <span>BLE / Beacon</span></div>
                    <div class="nl-tech-item"><i class="fas fa-wifi"></i> <span>Wi-Fi positioning</span></div>
                </div>
            </div>
            <div class="nl-tech-stats">
                <div class="nl-tech-stat"><strong>99.9%</strong><span>{{ $tr('Taux de disponibilité') }}</span></div>
                <div class="nl-tech-stat"><strong>24/7</strong><span>{{ $tr('Support technique') }}</span></div>
                <div class="nl-tech-stat"><strong>100%</strong><span>{{ $tr('Sécurité des données') }}</span></div>
            </div>
        </div>

        {{-- FORMULAIRE DE DEMO --}}
        <div class="nl-geo-form" id="nl-geo-form">
            <div class="nl-form-left">
                <div class="nl-form-badge">
                    <i class="fas fa-calendar-alt"></i> {{ $tr('Démo personnalisée') }}
                </div>
                <h3>{{ $tr('Testez notre solution') }}<br><em>{{ $tr('gratuitement pendant 14 jours') }}</em></h3>
                <p>{{ $tr('Accédez à une plateforme de démonstration complète. Créez vos zones, suivez des actifs simulés et découvrez toutes les fonctionnalités.') }}</p>
                <ul class="nl-form-benefits">
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Installation en 5 minutes') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('5 actifs inclus') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Support prioritaire') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Sans carte bancaire') }}</li>
                </ul>
            </div>
            <div class="nl-form-right">
                <form class="nl-geo-request-form" id="nlGeoForm">
                    <div class="nl-form-group">
                        <label>{{ $tr('Nom de l\'entreprise') }}</label>
                        <input type="text" placeholder="{{ $tr('Ex: Ma Société') }}" required>
                    </div>
                    <div class="nl-form-row">
                        <div class="nl-form-group">
                            <label>{{ $tr('Votre nom') }}</label>
                            <input type="text" placeholder="{{ $tr('Jean Dupont') }}" required>
                        </div>
                        <div class="nl-form-group">
                            <label>{{ $tr('Email professionnel') }}</label>
                            <input type="email" placeholder="contact@entreprise.com" required>
                        </div>
                    </div>
                    <div class="nl-form-group">
                        <label>{{ $tr('Nombre d\'actifs à géolocaliser') }}</label>
                        <select required>
                            <option value="">{{ $tr('Sélectionnez') }}</option>
                            <option>1-5 actifs</option>
                            <option>6-20 actifs</option>
                            <option>21-50 actifs</option>
                            <option>51-100 actifs</option>
                            <option>100+ actifs</option>
                        </select>
                    </div>
                    <button type="submit" class="nl-btn-submit-geo">
                        <i class="fas fa-rocket"></i> {{ $tr('Démarrer ma démo gratuite') }}
                    </button>
                    <p class="nl-form-note">{{ $tr('Démo immédiate · Aucun engagement · Support inclus') }}</p>
                </form>
            </div>
        </div>

        {{-- CTA FINAL --}}
        <div class="nl-geo-cta">
            <div class="nl-cta-content">
                <i class="fas fa-map-marked-alt"></i>
                <h3>{{ $tr('Prêt à optimiser vos déplacements ?') }}</h3>
                <p>{{ $tr('Rejoignez les centaines d\'entreprises qui utilisent notre solution de télé-positionnement au quotidien.') }}</p>
            </div>
            <div class="nl-cta-buttons">
                <a href="{{ url('next-level-geo-contact') }}" class="nl-cta-primary" target="_blank">
                    <i class="fas fa-headset"></i> {{ $tr('Parler à un expert') }}
                </a>
                <a href="{{ url('next-level-geo-demo') }}" class="nl-cta-secondary" target="_blank">
                    <i class="fas fa-chalkboard-user"></i> {{ $tr('Voir une démo') }}
                </a>
            </div>
        </div>

    </div>
</section>

<style>
/* ── GÉOLOCALISATION SECTION ── */
.nl-geo-section { background: linear-gradient(180deg, #f8faff 0%, #fff 100%); }
.nl-geo-body { padding: 0 40px 60px; }

/* Hero Banner */
.nl-geo-hero {
    background: linear-gradient(135deg, #0a1628 0%, #1a2a4a 100%);
    border-radius: 28px;
    margin: 24px 0 48px;
    padding: 56px 64px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.nl-geo-hero::before {
    content: '';
    position: absolute;
    top: -30%;
    left: -20%;
    width: 70%;
    height: 160%;
    background: radial-gradient(circle, rgba(232,118,26,0.08) 0%, transparent 70%);
    pointer-events: none;
}

.nl-geo-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(52,211,153,0.15);
    border: 1px solid rgba(52,211,153,0.3);
    color: #34d399;
    border-radius: 999px;
    padding: 6px 16px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 24px;
}

.nl-geo-hero h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(32px, 3.2vw, 46px);
    color: #fff;
    line-height: 1.15;
    margin-bottom: 20px;
}

.nl-geo-hero h2 em { font-style: italic; color: #e8761a; }
.nl-geo-hero > p {
    font-size: 15px;
    color: rgba(255,255,255,0.7);
    line-height: 1.8;
    margin-bottom: 28px;
}

.nl-geo-stats {
    display: flex;
    gap: 24px;
    margin-bottom: 32px;
    flex-wrap: wrap;
}

.nl-geo-stat {
    display: flex;
    align-items: center;
    gap: 12px;
    background: rgba(255,255,255,0.05);
    padding: 10px 18px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.1);
}

.nl-geo-stat i {
    font-size: 24px;
    color: #e8761a;
}

.nl-geo-stat strong {
    display: block;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 22px;
    color: #fff;
    line-height: 1;
}

.nl-geo-stat span {
    font-size: 10px;
    color: rgba(255,255,255,0.6);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.nl-geo-actions {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
}

.nl-btn-secondary-geo {
    border: 2px solid rgba(255,255,255,0.3);
    color: #fff;
    padding: 14px 28px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}

.nl-btn-secondary-geo:hover {
    border-color: #fff;
    background: rgba(255,255,255,0.08);
    color: #fff;
}

/* Map Mock */
.nl-geo-hero-visual {
    position: relative;
}

.nl-geo-map-mock {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
    overflow: hidden;
    backdrop-filter: blur(10px);
}

.nl-map-header {
    background: rgba(255,255,255,0.08);
    padding: 14px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(255,255,255,0.08);
    font-size: 12px;
    color: rgba(255,255,255,0.8);
}

.nl-map-live {
    font-size: 10px;
    color: #34d399;
    display: flex;
    align-items: center;
    gap: 6px;
}

.nl-map-live i { font-size: 6px; }

.nl-map-container {
    position: relative;
    height: 280px;
    background: linear-gradient(135deg, #1a3a5c, #0a1a2e);
    margin: 0;
    overflow: hidden;
}

.nl-map-bg {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle at 30% 40%, rgba(232,118,26,0.1) 0%, transparent 50%),
                      repeating-linear-gradient(90deg, rgba(255,255,255,0.02) 0px, rgba(255,255,255,0.02) 1px, transparent 1px, transparent 40px),
                      repeating-linear-gradient(0deg, rgba(255,255,255,0.02) 0px, rgba(255,255,255,0.02) 1px, transparent 1px, transparent 40px);
}

.nl-map-marker {
    position: absolute;
    cursor: pointer;
    z-index: 10;
}

.nl-map-marker i {
    font-size: 24px;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
}

.nl-map-marker .nl-marker-label {
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0,0,0,0.8);
    color: #fff;
    font-size: 9px;
    padding: 2px 6px;
    border-radius: 4px;
    white-space: nowrap;
    margin-bottom: 4px;
    display: none;
}

.nl-map-marker:hover .nl-marker-label {
    display: block;
}

.nl-marker-1 i { color: #e8761a; }
.nl-marker-2 i { color: #f59e0b; }
.nl-marker-3 i { color: #10b981; }
.nl-marker-4 i { color: #3b82f6; }

.nl-map-zone {
    position: absolute;
    border: 2px dashed #10b981;
    border-radius: 50%;
    background: rgba(16,185,129,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
}

.nl-zone-label {
    font-size: 8px;
    color: #10b981;
    background: rgba(16,185,129,0.2);
    padding: 2px 6px;
    border-radius: 10px;
}

.nl-map-route {
    position: absolute;
    bottom: 30%;
    left: 20%;
    width: 60%;
    height: 2px;
    background: linear-gradient(90deg, transparent, #e8761a, #f59e0b, transparent);
    transform: rotate(-15deg);
}

.nl-map-footer {
    background: rgba(255,255,255,0.05);
    padding: 12px 20px;
    display: flex;
    justify-content: space-between;
    font-size: 10px;
    color: rgba(255,255,255,0.4);
    flex-wrap: wrap;
    gap: 10px;
}

.nl-map-legend {
    display: flex;
    gap: 16px;
}

.nl-map-legend span {
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.nl-geo-floating-card {
    position: absolute;
    bottom: 30px;
    left: -20px;
    background: #fff;
    border-radius: 12px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.nl-geo-floating-card i {
    font-size: 20px;
    color: #f59e0b;
}

.nl-geo-floating-card strong {
    display: block;
    font-size: 11px;
    color: #1a1a1a;
}

.nl-geo-floating-card span {
    font-size: 10px;
    color: #666;
}

/* Section Header */
.nl-section-header {
    text-align: center;
    margin-bottom: 40px;
}

.nl-section-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #e8761a;
    background: #fef3ea;
    padding: 6px 14px;
    border-radius: 999px;
    margin-bottom: 16px;
}

.nl-section-header h3 {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    color: #1a1a1a;
    margin-bottom: 12px;
}

.nl-gradient-text {
    background: linear-gradient(135deg, #e8761a, #f59e0b);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.nl-section-header p {
    font-size: 15px;
    color: #666;
    max-width: 550px;
    margin: 0 auto;
}

/* Features Grid */
.nl-geo-features {
    margin-bottom: 60px;
}

.nl-geo-features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.nl-geo-feature-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 20px;
    padding: 32px;
    transition: all 0.3s;
}

.nl-geo-feature-card:hover {
    transform: translateY(-4px);
    border-color: #e8761a;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
}

.nl-geo-feature-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 18px;
}

.nl-geo-feature-card h4 {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 10px;
}

.nl-geo-feature-card p {
    font-size: 13px;
    color: #666;
    line-height: 1.7;
    margin-bottom: 16px;
}

.nl-geo-feature-tag {
    display: inline-block;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 4px 10px;
    border-radius: 6px;
}

/* Use Cases */
.nl-geo-usecases {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 28px;
    padding: 48px;
    margin-bottom: 60px;
}

.nl-usecases-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-top: 32px;
}

.nl-usecase-card {
    text-align: center;
    padding: 24px;
    background: #f8faff;
    border-radius: 20px;
    transition: all 0.3s;
}

.nl-usecase-card:hover {
    transform: translateY(-4px);
    background: #fff;
    box-shadow: 0 12px 24px rgba(0,0,0,0.08);
}

.nl-usecase-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #e8761a20, #f59e0b20);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 28px;
    color: #e8761a;
}

.nl-usecase-card h4 {
    font-size: 16px;
    margin-bottom: 8px;
}

.nl-usecase-card p {
    font-size: 12px;
    color: #888;
}

/* Technologies */
.nl-geo-tech {
    background: linear-gradient(135deg, #f8faff, #fff);
    border: 1px solid #e5e7eb;
    border-radius: 28px;
    padding: 48px;
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 40px;
    margin-bottom: 60px;
    align-items: center;
}

.nl-tech-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #8b5cf6;
    background: rgba(139,92,246,0.1);
    padding: 6px 12px;
    border-radius: 999px;
    margin-bottom: 16px;
}

.nl-tech-content h3 {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    margin-bottom: 12px;
}

.nl-tech-content > p {
    font-size: 14px;
    color: #666;
    margin-bottom: 24px;
}

.nl-tech-icons {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.nl-tech-item {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 50px;
    padding: 8px 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
}

.nl-tech-item i { color: #e8761a; }

.nl-tech-stats {
    display: flex;
    flex-direction: column;
    gap: 20px;
    min-width: 150px;
}

.nl-tech-stat {
    text-align: center;
    padding: 16px;
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
}

.nl-tech-stat strong {
    display: block;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 32px;
    color: #e8761a;
}

.nl-tech-stat span {
    font-size: 11px;
    color: #888;
}

/* Form */
.nl-geo-form {
    background: linear-gradient(135deg, #fff, #f8faff);
    border: 1px solid #e5e7eb;
    border-radius: 28px;
    padding: 56px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    margin-bottom: 60px;
}

.nl-form-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #10b981;
    background: rgba(16,185,129,0.1);
    padding: 6px 14px;
    border-radius: 999px;
    margin-bottom: 16px;
}

.nl-form-left h3 {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    margin-bottom: 14px;
}

.nl-form-left h3 em {
    font-style: italic;
    color: #e8761a;
}

.nl-form-left p {
    font-size: 15px;
    color: #666;
    line-height: 1.8;
    margin-bottom: 24px;
}

.nl-form-benefits {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.nl-form-benefits li {
    font-size: 14px;
    color: #444;
    display: flex;
    align-items: center;
    gap: 10px;
}

.nl-form-benefits li i {
    color: #10b981;
}

.nl-geo-request-form .nl-form-group {
    margin-bottom: 16px;
}

.nl-geo-request-form .nl-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.nl-geo-request-form .nl-form-group label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 6px;
}

.nl-geo-request-form .nl-form-group input,
.nl-geo-request-form .nl-form-group select {
    width: 100%;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    padding: 12px 14px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.nl-geo-request-form .nl-form-group input:focus,
.nl-geo-request-form .nl-form-group select:focus {
    outline: none;
    border-color: #e8761a;
}

.nl-btn-submit-geo {
    width: 100%;
    background: linear-gradient(135deg, #e8761a, #c04f10);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 14px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s;
    margin-top: 8px;
}

.nl-btn-submit-geo:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(232,118,26,0.35);
}

.nl-form-note {
    font-size: 11px;
    color: #9ca3af;
    text-align: center;
    margin-top: 12px;
}

/* CTA */
.nl-geo-cta {
    background: linear-gradient(135deg, #0f2240, #1e3a5f);
    border-radius: 24px;
    padding: 48px 56px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 40px;
    flex-wrap: wrap;
}

.nl-geo-cta .nl-cta-content {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.nl-geo-cta .nl-cta-content i {
    font-size: 36px;
    color: #f59e0b;
    margin-bottom: 12px;
}

.nl-geo-cta .nl-cta-content h3 {
    font-size: 24px;
    color: #fff;
    margin-bottom: 8px;
}

.nl-geo-cta .nl-cta-content p {
    font-size: 14px;
    color: rgba(255,255,255,0.7);
    max-width: 500px;
}

.nl-cta-primary {
    background: #e8761a;
    color: #fff;
    padding: 14px 28px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}

.nl-cta-primary:hover {
    background: #c45e0e;
    transform: translateY(-2px);
    color: #fff;
}

.nl-cta-secondary {
    border: 2px solid rgba(255,255,255,0.3);
    color: #fff;
    padding: 14px 28px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}

.nl-cta-secondary:hover {
    border-color: #fff;
    background: rgba(255,255,255,0.08);
    color: #fff;
}

/* Responsive */
@media (max-width: 1100px) {
    .nl-geo-hero { grid-template-columns: 1fr; padding: 40px; }
    .nl-geo-features-grid { grid-template-columns: repeat(2, 1fr); }
    .nl-usecases-grid { grid-template-columns: repeat(2, 1fr); }
    .nl-geo-form { grid-template-columns: 1fr; gap: 32px; }
    .nl-geo-tech { grid-template-columns: 1fr; }
}

@media (max-width: 768px) {
    .nl-geo-body { padding: 0 20px 40px; }
    .nl-geo-features-grid { grid-template-columns: 1fr; }
    .nl-usecases-grid { grid-template-columns: 1fr; }
    .nl-geo-cta { flex-direction: column; text-align: center; padding: 32px 24px; }
    .nl-geo-cta .nl-cta-content { align-items: center; text-align: center; }
    .nl-geo-form .nl-form-row { grid-template-columns: 1fr; }
}
</style>

<script>
document.getElementById('nlGeoForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Merci ! Votre demande de démo a été enregistrée. Notre équipe vous contacte sous 24h pour activer votre accès.');
    this.reset();
});
</script>