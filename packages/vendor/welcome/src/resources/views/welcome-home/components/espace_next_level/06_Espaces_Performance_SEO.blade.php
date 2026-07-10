{{-- ============================================================
     BLOC 6 — ESPACES PERFORMANCES SEO INTERNATIONAL
     Audit · Optimisation · Suivi de positionnement · Conquête internationale
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

    $seoFeatures = [
        [
            'icon' => 'fas fa-chart-line',
            'color' => '#e8761a',
            'title' => 'Audit SEO Complet',
            'desc' => 'Analyse approfondie de votre site : structure technique, maillage interne, contenu, backlinks et concurrents.',
            'tag' => 'Diagnostic 360°'
        ],
        [
            'icon' => 'fas fa-globe',
            'color' => '#3b82f6',
            'title' => 'SEO International',
            'desc' => 'Optimisation multilingue, balises hreflang, sous-domaines par pays et stratégies de géolocalisation.',
            'tag' => 'hreflang + ccTLD'
        ],
        [
            'icon' => 'fas fa-search',
            'color' => '#10b981',
            'title' => 'Recherche de Mots-clés',
            'desc' => 'Identification des meilleures opportunités sémantiques par marché, volume de recherche et intention d\'achat.',
            'tag' => 'Longue traîne'
        ],
        [
            'icon' => 'fas fa-tachometer-alt',
            'color' => '#8b5cf6',
            'title' => 'Suivi de Positionnement',
            'desc' => 'Tableau de bord temps réel avec alertes, historique des positions et analyse de la concurrence.',
            'tag' => 'Monitoring 24/7'
        ],
        [
            'icon' => 'fas fa-link',
            'color' => '#f59e0b',
            'title' => 'Netlinking Stratégique',
            'desc' => 'Campagnes de backlinks qualitatifs, désaveu des liens toxiques et audit de profil de liens entrants.',
            'tag' => 'Authority building'
        ],
        [
            'icon' => 'fas fa-mobile-alt',
            'color' => '#ef4444',
            'title' => 'Core Web Vitals',
            'desc' => 'Optimisation des performances techniques : LCP, FID, CLS. Score Google PageSpeed au top.',
            'tag' => 'Performance'
        ],
    ];

    $seoMetrics = [
        ['label' => 'Sites audités', 'value' => '2 500+', 'icon' => 'fas fa-chart-simple'],
        ['label' => 'Mots-clés suivis', 'value' => '1.2M+', 'icon' => 'fas fa-key'],
        ['label' => 'Pays couverts', 'value' => '85+', 'icon' => 'fas fa-map-marked-alt'],
        ['label' => 'Croissance moyenne', 'value' => '+127%', 'icon' => 'fas fa-rocket'],
    ];

    $internationalMarkets = [
        ['flag' => '🇫🇷', 'country' => 'France', 'engine' => 'Google.fr', 'volume' => '8.2M'],
        ['flag' => '🇨🇦', 'country' => 'Canada (QC)', 'engine' => 'Google.ca', 'volume' => '3.1M'],
        ['flag' => '🇪🇸', 'country' => 'Espagne', 'engine' => 'Google.es', 'volume' => '4.5M'],
        ['flag' => '🇩🇪', 'country' => 'Allemagne', 'engine' => 'Google.de', 'volume' => '6.8M'],
        ['flag' => '🇬🇧', 'country' => 'Royaume-Uni', 'engine' => 'Google.co.uk', 'volume' => '7.2M'],
        ['flag' => '🇺🇸', 'country' => 'États-Unis', 'engine' => 'Google.com', 'volume' => '22.5M'],
    ];

    $seoTools = [
        ['name' => 'Google Search Console', 'icon' => 'fab fa-google', 'color' => '#4285f4'],
        ['name' => 'SEMrush', 'icon' => 'fas fa-chart-line', 'color' => '#ff642d'],
        ['name' => 'Ahrefs', 'icon' => 'fas fa-chart-network', 'color' => '#6c5ce7'],
        ['name' => 'Screaming Frog', 'icon' => 'fas fa-frog', 'color' => '#10b981'],
        ['name' => 'Google Analytics', 'icon' => 'fab fa-google', 'color' => '#34a853'],
        ['name' => 'Majestic', 'icon' => 'fas fa-crown', 'color' => '#1e3a5f'],
    ];
@endphp

<section class="nl-seo-section" id="nl-seo">

    {{-- EN-TÊTE STANDARD --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="SEO Next Level">
                    <div class="logo-wrapper">
                        <img loading="lazy" decoding="async" src="{{ asset('images/Next-level.png') }}" alt="Next Level">
                    </div>
                    <span class="resto-accord-btn-label">SEO Performance</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-chart-line"></i> Pro</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('ESPACES PERFORMANCES SEO INTERNATIONAL') }}</h1>
                <h2 class="resto-header-eyebrow">{{ $tr('Audit & Optimisation — Dominez les moteurs de recherche') }}</h2>
                <p class="resto-header-subtitle">{{ $tr('Analysez votre positionnement, optimisez votre visibilité internationale et suivez vos performances en temps réel.') }}</p>
            </div>
            <div class="resto-header-logo-right">
                <a href="{{ url('espace-next-level/seo') }}" title="{{ $tr('Audit SEO gratuit') }}" target="_blank" rel="noopener noreferrer">
                    <img class="bt-next-level-image" src="{{ asset('images/Next-level.png') }}" alt="{{ $tr('Next Level') }}" loading="lazy">
                </a>
            </div>
        </div>
        @include('welcome-home.components.espace_next_level.SectionNavBarNextLevel')
        <div class="resto-header-shimmer"></div>
    </div>

    <div class="nl-seo-body">

        {{-- HERO BANNER --}}
        <div class="nl-seo-hero">
            <div class="nl-seo-hero-content">
                <div class="nl-seo-badge">
                    <i class="fas fa-chart-line"></i> {{ $tr('Audit SEO offert — Diagnostic sous 48h') }}
                </div>
                <h2>
                    {{ $tr('Dominez les moteurs') }}<br>
                    <em>{{ $tr('de recherche internationaux') }}</em>
                </h2>
                <p>{{ $tr('Notre équipe d\'experts certifiés réalise un audit complet de votre site et déploie une stratégie SEO sur mesure pour conquérir de nouveaux marchés. Augmentez votre visibilité, votre trafic et vos conversions.') }}</p>
                <div class="nl-seo-stats">
                    @foreach($seoMetrics as $metric)
                    <div class="nl-seo-stat">
                        <i class="{{ $metric['icon'] }}"></i>
                        <div>
                            <strong>{{ $metric['value'] }}</strong>
                            <span>{{ $tr($metric['label']) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="nl-seo-actions">
                    <a href="{{ url('devis') }}" class="nl-btn-primary" target="_blank">
                        <i class="fas fa-chart-simple"></i> {{ $tr('Demander un audit gratuit') }}
                    </a>
                    <!-- <a href="#nl-seo-features" class="nl-btn-secondary-seo">
                        <i class="fas fa-eye"></i> {{ $tr('Découvrir nos solutions') }}
                    </a> -->
                </div>
            </div>
            <div class="nl-seo-hero-visual">
                <div class="nl-seo-dashboard-mock">
                    <div class="nl-dash-header">
                        <div class="nl-dash-header-left">
                            <i class="fas fa-chart-line"></i> SEO Dashboard — GoExploria
                        </div>
                        <div class="nl-dash-header-right">
                            <span class="nl-live-badge"><i class="fas fa-circle"></i> Live</span>
                        </div>
                    </div>
                    <div class="nl-dash-score">
                        <div class="nl-score-ring">
                            <svg viewBox="0 0 100 100" width="80" height="80">
                                <circle cx="50" cy="50" r="45" fill="none" stroke="#1e3a5f" stroke-width="8"/>
                                <circle cx="50" cy="50" r="45" fill="none" stroke="#e8761a" stroke-width="8" 
                                        stroke-dasharray="283" stroke-dashoffset="57" transform="rotate(-90 50 50)"/>
                            </svg>
                            <span class="nl-score-value">84</span>
                        </div>
                        <div class="nl-score-info">
                            <strong>{{ $tr('Score SEO global') }}</strong>
                            <span>{{ $tr('Excellent — Top 10% des sites') }}</span>
                        </div>
                    </div>
                    <div class="nl-dash-metrics">
                        <div class="nl-dash-metric-item">
                            <span class="nl-metric-label">{{ $tr('Trafic organique') }}</span>
                            <span class="nl-metric-value up">+42%</span>
                            <div class="nl-progress-bar"><div class="nl-progress-fill" style="width:72%"></div></div>
                        </div>
                        <div class="nl-dash-metric-item">
                            <span class="nl-metric-label">{{ $tr('Mots-clés Top 10') }}</span>
                            <span class="nl-metric-value up">+156</span>
                            <div class="nl-progress-bar"><div class="nl-progress-fill" style="width:64%"></div></div>
                        </div>
                        <div class="nl-dash-metric-item">
                            <span class="nl-metric-label">{{ $tr('Backlinks') }}</span>
                            <span class="nl-metric-value up">+2.4k</span>
                            <div class="nl-progress-bar"><div class="nl-progress-fill" style="width:58%"></div></div>
                        </div>
                        <div class="nl-dash-metric-item">
                            <span class="nl-metric-label">{{ $tr('Taux de conversion') }}</span>
                            <span class="nl-metric-value up">+18%</span>
                            <div class="nl-progress-bar"><div class="nl-progress-fill" style="width:51%"></div></div>
                        </div>
                    </div>
                    <div class="nl-dash-footer">
                        <span><i class="fab fa-google"></i> {{ $tr('Dernier crawl : il y a 2h') }}</span>
                        <span><i class="fas fa-chart-line"></i> {{ $tr('Position moyenne : #4.2') }}</span>
                    </div>
                </div>
                <div class="nl-ai-badge">
                    <i class="fas fa-microchip"></i> {{ $tr('Analyse IA intégrée') }}
                </div>
            </div>
        </div>

        {{-- FEATURES GRID --}}
        <div class="nl-seo-features" id="nl-seo-features">
            <div class="nl-section-header">
                <span class="nl-section-eyebrow"><i class="fas fa-cogs"></i> {{ $tr('Nos solutions SEO') }}</span>
                <h3>{{ $tr('Une stratégie complète') }}<br><span class="nl-gradient-text">{{ $tr('pour chaque objectif') }}</span></h3>
                <p>{{ $tr('De l\'audit technique à la conquête internationale, nous couvrons tous les aspects du SEO moderne.') }}</p>
            </div>
            <div class="nl-seo-features-grid">
                @foreach($seoFeatures as $feature)
                <div class="nl-seo-feature-card">
                    <div class="nl-seo-feature-icon" style="background:{{ $feature['color'] }}20;color:{{ $feature['color'] }}">
                        <i class="{{ $feature['icon'] }}"></i>
                    </div>
                    <h4>{{ $tr($feature['title']) }}</h4>
                    <p>{{ $tr($feature['desc']) }}</p>
                    <div class="nl-seo-feature-tag" style="background:{{ $feature['color'] }}15;color:{{ $feature['color'] }}">
                        {{ $tr($feature['tag']) }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- INTERNATIONAL MARKETS --}}
        <div class="nl-seo-international">
            <div class="nl-section-header">
                <span class="nl-section-eyebrow"><i class="fas fa-globe-americas"></i> {{ $tr('Couverture mondiale') }}</span>
                <h3>{{ $tr('Positionnez-vous sur') }}<br><span class="nl-gradient-text">{{ $tr('les marchés internationaux') }}</span></h3>
                <p>{{ $tr('Notre technologie suit votre performance sur plus de 85 pays et 120 moteurs de recherche différents.') }}</p>
            </div>
            <div class="nl-international-grid">
                @foreach($internationalMarkets as $market)
                <div class="nl-market-card">
                    <div class="nl-market-flag">{{ $market['flag'] }}</div>
                    <div class="nl-market-info">
                        <strong>{{ $market['country'] }}</strong>
                        <span>{{ $market['engine'] }}</span>
                    </div>
                    <div class="nl-market-volume">{{ $market['volume'] }}</div>
                </div>
                @endforeach
                <div class="nl-market-more">
                    <i class="fas fa-plus-circle"></i> {{ $tr('+79 autres pays') }}
                </div>
            </div>
        </div>

        {{-- TOOLS INTEGRATION --}}
        <div class="nl-seo-tools">
            <div class="nl-tools-header">
                <i class="fas fa-tools"></i>
                <h3>{{ $tr('Intégré avec vos outils SEO préférés') }}</h3>
                <p>{{ $tr('Synchronisez vos données et centralisez votre stratégie SEO') }}</p>
            </div>
            <div class="nl-tools-grid">
                @foreach($seoTools as $tool)
                <div class="nl-tool-card">
                    <div class="nl-tool-icon" style="background:{{ $tool['color'] }}20;color:{{ $tool['color'] }}">
                        <i class="{{ $tool['icon'] }}"></i>
                    </div>
                    <span>{{ $tool['name'] }}</span>
                </div>
                @endforeach
                <div class="nl-tool-api">
                    <i class="fas fa-code"></i>
                    <span>{{ $tr('API ouverte — Webhooks') }}</span>
                </div>
            </div>
        </div>


    </div>
</section>

<style>
/* ── SEO SECTION ── */
.nl-seo-section { background: linear-gradient(180deg, #f8faff 0%, #fff 100%); }
.nl-seo-body { padding: 0 40px 60px; }

/* Hero Banner */
.nl-seo-hero {
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

.nl-seo-hero::before {
    content: '';
    position: absolute;
    top: -30%;
    left: -20%;
    width: 70%;
    height: 160%;
    background: radial-gradient(circle, rgba(232,118,26,0.08) 0%, transparent 70%);
    pointer-events: none;
}

.nl-seo-badge {
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

.nl-seo-hero h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(32px, 3.2vw, 46px);
    color: #fff;
    line-height: 1.15;
    margin-bottom: 20px;
}

.nl-seo-hero h2 em { font-style: italic; color: #e8761a; }
.nl-seo-hero > p {
    font-size: 15px;
    color: rgba(255,255,255,0.7);
    line-height: 1.8;
    margin-bottom: 28px;
}

.nl-seo-stats {
    display: flex;
    gap: 24px;
    margin-bottom: 32px;
    flex-wrap: wrap;
}

.nl-seo-stat {
    display: flex;
    align-items: center;
    gap: 12px;
    background: rgba(255,255,255,0.05);
    padding: 10px 18px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.1);
}

.nl-seo-stat i {
    font-size: 24px;
    color: #e8761a;
}

.nl-seo-stat strong {
    display: block;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 22px;
    color: #fff;
    line-height: 1;
}

.nl-seo-stat span {
    font-size: 10px;
    color: rgba(255,255,255,0.6);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.nl-seo-actions {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
}

.nl-btn-secondary-seo {
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

.nl-btn-secondary-seo:hover {
    border-color: #fff;
    background: rgba(255,255,255,0.08);
    color: #fff;
}

/* SEO Dashboard Mock */
.nl-seo-dashboard-mock {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
    overflow: hidden;
    backdrop-filter: blur(10px);
}

.nl-dash-header {
    background: rgba(255,255,255,0.08);
    padding: 14px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

.nl-dash-header-left {
    font-size: 12px;
    font-weight: 600;
    color: rgba(255,255,255,0.8);
}

.nl-live-badge {
    font-size: 10px;
    color: #34d399;
    display: flex;
    align-items: center;
    gap: 6px;
}

.nl-live-badge i { font-size: 6px; }

.nl-dash-score {
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

.nl-score-ring {
    position: relative;
    width: 80px;
    height: 80px;
}

.nl-score-value {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-family: 'Bebas Neue', sans-serif;
    font-size: 28px;
    color: #e8761a;
}

.nl-score-info strong {
    display: block;
    font-size: 14px;
    color: #fff;
    margin-bottom: 4px;
}

.nl-score-info span {
    font-size: 11px;
    color: rgba(255,255,255,0.5);
}

.nl-dash-metrics {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.nl-dash-metric-item {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
}

.nl-metric-label {
    font-size: 11px;
    color: rgba(255,255,255,0.6);
    width: 120px;
}

.nl-metric-value {
    font-size: 13px;
    font-weight: 700;
    width: 60px;
}

.nl-metric-value.up { color: #10b981; }

.nl-progress-bar {
    flex: 1;
    height: 5px;
    background: rgba(255,255,255,0.1);
    border-radius: 999px;
    overflow: hidden;
}

.nl-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #e8761a, #f59e0b);
    border-radius: 999px;
}

.nl-dash-footer {
    background: rgba(255,255,255,0.05);
    padding: 12px 20px;
    display: flex;
    justify-content: space-between;
    font-size: 10px;
    color: rgba(255,255,255,0.4);
}

.nl-ai-badge {
    position: absolute;
    top: 20px;
    right: -10px;
    background: #8b5cf6;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 999px;
    display: flex;
    align-items: center;
    gap: 6px;
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
.nl-seo-features {
    margin-bottom: 60px;
}

.nl-seo-features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.nl-seo-feature-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 20px;
    padding: 32px;
    transition: all 0.3s;
}

.nl-seo-feature-card:hover {
    transform: translateY(-4px);
    border-color: #e8761a;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
}

.nl-seo-feature-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 18px;
}

.nl-seo-feature-card h4 {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 10px;
}

.nl-seo-feature-card p {
    font-size: 13px;
    color: #666;
    line-height: 1.7;
    margin-bottom: 16px;
}

.nl-seo-feature-tag {
    display: inline-block;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 4px 10px;
    border-radius: 6px;
}

/* International Markets */
.nl-seo-international {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 28px;
    padding: 48px;
    margin-bottom: 60px;
}

.nl-international-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-top: 32px;
}

.nl-market-card {
    background: #f8faff;
    border-radius: 16px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all 0.2s;
}

.nl-market-card:hover {
    background: #fff;
    border-color: #e8761a;
    transform: translateX(4px);
}

.nl-market-flag {
    font-size: 28px;
}

.nl-market-info strong {
    display: block;
    font-size: 14px;
    color: #1a1a1a;
}

.nl-market-info span {
    font-size: 11px;
    color: #888;
}

.nl-market-volume {
    margin-left: auto;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 20px;
    color: #e8761a;
}

.nl-market-more {
    text-align: center;
    padding: 16px;
    color: #e8761a;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

/* Tools Integration */
.nl-seo-tools {
    background: #f8faff;
    border-radius: 24px;
    padding: 48px;
    margin-bottom: 60px;
    text-align: center;
}

.nl-tools-header {
    margin-bottom: 32px;
}

.nl-tools-header i {
    font-size: 36px;
    color: #e8761a;
    margin-bottom: 12px;
}

.nl-tools-header h3 {
    font-size: 22px;
    color: #1a1a1a;
    margin-bottom: 8px;
}

.nl-tools-header p {
    font-size: 14px;
    color: #666;
}

.nl-tools-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 16px;
}

.nl-tool-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 50px;
    padding: 10px 20px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.2s;
}

.nl-tool-card:hover {
    border-color: #e8761a;
    transform: translateY(-2px);
}

.nl-tool-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.nl-tool-card span {
    font-size: 13px;
    font-weight: 500;
    color: #1a1a1a;
}

.nl-tool-api {
    background: linear-gradient(135deg, #e8761a, #f59e0b);
    border: none;
    border-radius: 50px;
    padding: 10px 20px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #fff;
}

.nl-tool-api i, .nl-tool-api span {
    color: #fff;
}

/* Audit Form */
.nl-seo-audit-form {
    background: linear-gradient(135deg, #fff, #f8faff);
    border: 1px solid #e5e7eb;
    border-radius: 28px;
    padding: 56px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    margin-bottom: 60px;
}

.nl-audit-badge {
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

.nl-audit-left h3 {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    color: #1a1a1a;
    margin-bottom: 14px;
}

.nl-audit-left h3 em {
    font-style: italic;
    color: #e8761a;
}

.nl-audit-left p {
    font-size: 15px;
    color: #666;
    line-height: 1.8;
    margin-bottom: 24px;
}

.nl-audit-benefits {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.nl-audit-benefits li {
    font-size: 14px;
    color: #444;
    display: flex;
    align-items: center;
    gap: 10px;
}

.nl-audit-benefits li i {
    color: #10b981;
    font-size: 14px;
}

.nl-audit-form .nl-form-group {
    margin-bottom: 16px;
}

.nl-audit-form .nl-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.nl-audit-form .nl-form-group label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 6px;
}

.nl-audit-form .nl-form-group input,
.nl-audit-form .nl-form-group select {
    width: 100%;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    padding: 12px 14px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.nl-audit-form .nl-form-group input:focus,
.nl-audit-form .nl-form-group select:focus {
    outline: none;
    border-color: #e8761a;
}

.nl-btn-submit-audit {
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

.nl-btn-submit-audit:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(232,118,26,0.35);
}

.nl-form-note {
    font-size: 11px;
    color: #9ca3af;
    text-align: center;
    margin-top: 12px;
}

/* CTA Banner */
.nl-seo-cta-banner {
    background: linear-gradient(135deg, #0f2240, #1e3a5f);
    border-radius: 24px;
    padding: 48px 56px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 40px;
    flex-wrap: wrap;
}

.nl-cta-content {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.nl-cta-content i {
    font-size: 36px;
    color: #f59e0b;
    margin-bottom: 12px;
}

.nl-cta-content h3 {
    font-size: 24px;
    color: #fff;
    margin-bottom: 8px;
}

.nl-cta-content p {
    font-size: 14px;
    color: rgba(255,255,255,0.7);
    max-width: 500px;
}

.nl-cta-buttons {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
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
    .nl-seo-hero { grid-template-columns: 1fr; padding: 40px; }
    .nl-seo-features-grid { grid-template-columns: repeat(2, 1fr); }
    .nl-international-grid { grid-template-columns: repeat(2, 1fr); }
    .nl-seo-audit-form { grid-template-columns: 1fr; gap: 32px; }
}

@media (max-width: 768px) {
    .nl-seo-body { padding: 0 20px 40px; }
    .nl-seo-features-grid { grid-template-columns: 1fr; }
    .nl-international-grid { grid-template-columns: 1fr; }
    .nl-seo-cta-banner { flex-direction: column; text-align: center; padding: 32px 24px; }
    .nl-cta-content { align-items: center; text-align: center; }
    .nl-audit-form .nl-form-row { grid-template-columns: 1fr; }
    .nl-seo-stats { justify-content: center; }
}
</style>

<script>
document.getElementById('nlAuditForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Merci ! Votre demande d\'audit SEO a été envoyée. Un expert vous contacte sous 48h.');
    this.reset();
});
</script>