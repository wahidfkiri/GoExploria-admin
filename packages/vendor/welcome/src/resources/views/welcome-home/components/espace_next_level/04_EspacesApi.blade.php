{{-- ============================================================
     BLOC 4 — ESPACES API (INTÉGRATIONS & WEBHOOKS)
     Connectez vos outils · Automatisez vos flux · Scalabilité totale
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

    $apiFeatures = [
        [
            'icon' => 'fas fa-plug',
            'color' => '#e8761a',
            'title' => 'API RESTful Complète',
            'desc' => 'Accédez à l\'intégralité de vos données via une API REST documentée, sécurisée et prête à l\'emploi. Authentification OAuth2 et clés API.',
            'tag' => 'Documentée'
        ],
        [
            'icon' => 'fas fa-code-branch',
            'color' => '#3b82f6',
            'title' => 'Webhooks Temps Réel',
            'desc' => 'Recevez des notifications instantanées sur vos endpoints dès qu\'un événement se produit : réservation, paiement, mise à jour produit.',
            'tag' => 'Temps réel'
        ],
        [
            'icon' => 'fas fa-chart-network',
            'color' => '#10b981',
            'title' => 'Webhooks Sortants',
            'desc' => 'Envoyez automatiquement vos données vers CRM, ERP, outils marketing ou solutions tierces sans aucune intervention manuelle.',
            'tag' => 'Automatisation'
        ],
        [
            'icon' => 'fas fa-shield-alt',
            'color' => '#8b5cf6',
            'title' => 'Sécurité & Conformité',
            'doc' => 'Chiffrement TLS 1.3, validation des signatures HMAC, logs d\'audit complets et conformité RGPD pour une intégration sereine.',
            'tag' => 'RGPD compliant'
        ],
        [
            'icon' => 'fas fa-database',
            'color' => '#f59e0b',
            'title' => 'Webhooks Entrants',
            'doc' => 'Recevez des données depuis vos applications tierces directement dans votre espace Next Level. Synchronisation bidirectionnelle fluide.',
            'tag' => 'Sync intégrée'
        ],
        [
            'icon' => 'fas fa-chart-line',
            'color' => '#ef4444',
            'title' => 'Tableau de Bord API',
            'desc' => 'Console dédiée pour suivre vos appels, logs détaillés, métriques de performance et simulateur de requêtes.',
            'tag' => 'Monitoring'
        ],
    ];

    $apiIntegrations = [
        ['name' => 'Salesforce', 'icon' => 'fab fa-salesforce', 'bg' => '#00a1e0'],
        ['name' => 'HubSpot', 'icon' => 'fab fa-hubspot', 'bg' => '#ff7a59'],
        ['name' => 'Slack', 'icon' => 'fab fa-slack', 'bg' => '#4a154b'],
        ['name' => 'Zapier', 'icon' => 'fas fa-bolt', 'bg' => '#ff4a00'],
        ['name' => 'Make', 'icon' => 'fas fa-cogs', 'bg' => '#6c5ce7'],
        ['name' => 'Shopify', 'icon' => 'fab fa-shopify', 'bg' => '#96bf48'],
        ['name' => 'Mailchimp', 'icon' => 'fab fa-mailchimp', 'bg' => '#ffe01b'],
        ['name' => 'Google', 'icon' => 'fab fa-google', 'bg' => '#4285f4'],
    ];
@endphp

<section class="nl-api-section" id="nl-api">

    {{-- EN-TÊTE STANDARD --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="API Next Level">
                    <div class="logo-wrapper">
                        <img loading="lazy" decoding="async" src="{{ asset('images/Next-level.png') }}" alt="Next Level">
                    </div>
                    <span class="resto-accord-btn-label">API Platform</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-code"></i> Dev</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('ESPACES API') }}</h1>
                <h2 class="resto-header-eyebrow">{{ $tr('Intégrations & Webhooks — Connectez votre écosystème') }}</h2>
                <p class="resto-header-subtitle">{{ $tr('Automatisez vos flux de données, synchronisez vos outils favoris et construisez des expériences sur mesure grâce à notre API puissante et nos webhooks temps réel.') }}</p>
            </div>
            <div class="resto-header-logo-right">
                <a href="{{ url('espace-next-level/api') }}" title="{{ $tr('Documentation API') }}" target="_blank" rel="noopener noreferrer">
                    <img class="bt-next-level-image" src="{{ asset('images/Next-level.png') }}" alt="{{ $tr('Next Level') }}" loading="lazy">
                </a>
            </div>
        </div>
        @include('welcome-home.components.espace_next_level.SectionNavBarNextLevel')
        <div class="resto-header-shimmer"></div>
    </div>

    <div class="nl-api-body">

        {{-- HERO API BANNER --}}
        <div class="nl-api-hero">
            <div class="nl-api-hero-content">
                <div class="nl-api-badge">
                    <i class="fas fa-code"></i> {{ $tr('Disponible immédiatement') }}
                </div>
                <h2>
                    {{ $tr('Une API pensée pour') }}<br>
                    <em>{{ $tr('les scale-ups et agences') }}</em>
                </h2>
                <p>{{ $tr('Notre infrastructure robuste vous permet de connecter vos applications préférées, d\'automatiser vos processus métier et de créer des workflows sur mesure. Plus de 200 endpoints documentés, un taux de disponibilité 99,9% et une équipe dédiée à votre succès technique.') }}</p>
                <div class="nl-api-stats">
                    <div class="nl-api-stat"><strong>200+</strong><span>{{ $tr('Endpoints') }}</span></div>
                    <div class="nl-api-stat"><strong>99.9%</strong><span>{{ $tr('Uptime SLA') }}</span></div>
                    <div class="nl-api-stat"><strong>&lt;50ms</strong><span>{{ $tr('Latence moyenne') }}</span></div>
                    <div class="nl-api-stat"><strong>24/7</strong><span>{{ $tr('Support technique') }}</span></div>
                </div>
                <div class="nl-api-actions">
                    <a href="{{ url('devis') }}" class="nl-btn-primary" target="_blank">
                        Demander un devis
                    </a>
                </div>
            </div>
            <div class="nl-api-hero-code">
                <div class="nl-code-window">
                    <div class="nl-code-header">
                        <span class="nl-code-dot red"></span>
                        <span class="nl-code-dot yellow"></span>
                        <span class="nl-code-dot green"></span>
                        <span class="nl-code-title">POST /webhooks/reservations</span>
                    </div>
                    <div class="nl-code-body">
                        <pre><code>{
  <span style="color:#f59e0b">"event"</span>: <span style="color:#10b981">"reservation.created"</span>,
  <span style="color:#f59e0b">"timestamp"</span>: <span style="color:#10b981">"2024-01-15T10:30:00Z"</span>,
  <span style="color:#f59e0b">"data"</span>: {
    <span style="color:#f59e0b">"reservation_id"</span>: <span style="color:#10b981">"R-2024-001234"</span>,
    <span style="color:#f59e0b">"customer"</span>: {
      <span style="color:#f59e0b">"name"</span>: <span style="color:#10b981">"Jean Dupont"</span>,
      <span style="color:#f59e0b">"email"</span>: <span style="color:#10b981">"jean@email.com"</span>
    },
    <span style="color:#f59e0b">"amount"</span>: <span style="color:#f59e0b">599.00</span>,
    <span style="color:#f59e0b">"currency"</span>: <span style="color:#10b981">"EUR"</span>
  },
  <span style="color:#f59e0b">"signature"</span>: <span style="color:#10b981">"sha256=abc123def456..."</span>
}</code></pre>
                    </div>
                </div>
                <div class="nl-api-floating-badge">
                    <i class="fas fa-bolt"></i> {{ $tr('Webhooks en &lt; 100ms') }}
                </div>
            </div>
        </div>

        {{-- FEATURES GRID --}}
        <div class="nl-api-features">
            @foreach($apiFeatures as $feature)
            <div class="nl-api-feature-card">
                <div class="nl-api-feature-icon" style="background:{{ $feature['color'] }}20;color:{{ $feature['color'] }}">
                    <i class="{{ $feature['icon'] }}"></i>
                </div>
                <h3>{{ $tr($feature['title']) }}</h3>
                <p>{{ $tr($feature['desc'] ?? $feature['doc']) }}</p>
                <div class="nl-api-feature-tag" style="background:{{ $feature['color'] }}15;color:{{ $feature['color'] }}">
                    {{ $tr($feature['tag']) }}
                </div>
            </div>
            @endforeach
        </div>

        {{-- INTEGRATIONS SHOWCASE --}}
        <div class="nl-api-integrations">
            <div class="nl-integrations-header">
                <span class="nl-integrations-eyebrow"><i class="fas fa-share-alt"></i> {{ $tr('Connecteurs natifs') }}</span>
                <h3>{{ $tr('Intégrez vos outils préférés en quelques clics') }}</h3>
                <p>{{ $tr('Notre plateforme propose des connecteurs prêts à l\'emploi avec les solutions les plus populaires. Pas de code requis pour les intégrations standards.') }}</p>
            </div>
            <div class="nl-integrations-grid">
                @foreach($apiIntegrations as $int)
                <div class="nl-integration-card">
                    <div class="nl-integration-icon" style="background:{{ $int['bg'] }}20;color:{{ $int['bg'] }}">
                        <i class="{{ $int['icon'] }}"></i>
                    </div>
                    <span>{{ $int['name'] }}</span>
                </div>
                @endforeach
            </div>
            <div class="nl-integrations-cta">
                <a href="{{ url('espace-next-level/api') }}" target="_blank">
                    {{ $tr('Voir tous les connecteurs') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- WEBHOOKS CONFIGURATION DEMO --}}
        <div class="nl-webhooks-demo">
            <div class="nl-demo-left">
                <div class="nl-demo-badge">
                    <i class="fas fa-code-branch"></i> {{ $tr('Configuration simplifiée') }}
                </div>
                <h3>{{ $tr('Créez vos webhooks') }}<br><em>{{ $tr('en moins de 2 minutes') }}</em></h3>
                <p>{{ $tr('Notre interface intuitive vous permet de configurer des webhooks entrants et sortants sans écrire une ligne de code. Choisissez vos événements, définissez votre endpoint, activez la signature HMAC et c\'est prêt.') }}</p>
                <ul class="nl-demo-list">
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Dashboard dédié à la configuration') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Logs complets et rejeu des événements') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Simulateur de webhooks pour tester') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Alertes automatiques en cas d\'échec') }}</li>
                </ul>
               
            </div>
            <div class="nl-demo-right">
                <div class="nl-webhook-config-mock">
                    <div class="nl-mock-header">
                        <span><i class="fas fa-sliders-h"></i> {{ $tr('Configuration webhook') }}</span>
                        <span class="nl-mock-status"><i class="fas fa-circle" style="color:#10b981;font-size:8px"></i> {{ $tr('Actif') }}</span>
                    </div>
                    <div class="nl-mock-field">
                        <label>{{ $tr('Endpoint URL') }}</label>
                        <div class="nl-mock-input">https://monapp.com/webhooks/goexploria</div>
                    </div>
                    <div class="nl-mock-field">
                        <label>{{ $tr('Événements déclencheurs') }}</label>
                        <div class="nl-mock-tags">
                            <span class="nl-mock-tag">reservation.created</span>
                            <span class="nl-mock-tag">reservation.updated</span>
                            <span class="nl-mock-tag">payment.succeeded</span>
                        </div>
                    </div>
                    <div class="nl-mock-field">
                        <label>{{ $tr('Signature HMAC') }}</label>
                        <div class="nl-mock-input" style="font-family:monospace">whsec_••••••••••••••••••••••</div>
                    </div>
                    <div class="nl-mock-actions">
                        <span class="nl-mock-btn"><i class="fas fa-save"></i> {{ $tr('Sauvegarder') }}</span>
                        <span class="nl-mock-btn"><i class="fas fa-vial"></i> {{ $tr('Tester') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<style>
/* ── API SECTION ── */
.nl-api-section { background: linear-gradient(180deg, #fff 0%, #f8faff 100%); }
.nl-api-body { padding: 0 40px 60px; }

/* Hero */
.nl-api-hero {
    background: linear-gradient(135deg, #0a1628 0%, #1a2a4a 100%);
    border-radius: 28px;
    margin: 24px 0 48px;
    padding: 56px 64px;
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 50px;
    align-items: center;
    position: relative;
    overflow: hidden;
}
.nl-api-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -30%;
    width: 80%;
    height: 200%;
    background: radial-gradient(circle, rgba(232,118,26,0.08) 0%, transparent 70%);
    pointer-events: none;
}
.nl-api-badge {
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
.nl-api-hero h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(32px, 3.2vw, 46px);
    color: #fff;
    line-height: 1.15;
    margin-bottom: 20px;
}
.nl-api-hero h2 em { font-style: italic; color: #e8761a; }
.nl-api-hero > p {
    font-size: 15px;
    color: rgba(255,255,255,0.7);
    line-height: 1.8;
    margin-bottom: 28px;
}
.nl-api-stats {
    display: flex;
    gap: 32px;
    margin-bottom: 32px;
    flex-wrap: wrap;
}
.nl-api-stat strong {
    display: block;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 38px;
    color: #e8761a;
    line-height: 1;
}
.nl-api-stat span {
    font-size: 11px;
    color: rgba(255,255,255,0.55);
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-top: 4px;
    display: block;
}
.nl-api-actions { display: flex; gap: 14px; flex-wrap: wrap; }
.nl-btn-secondary-api {
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
.nl-btn-secondary-api:hover { border-color: #fff; background: rgba(255,255,255,0.08); color: #fff; }

/* Code Window */
.nl-api-hero-code { position: relative; }
.nl-code-window {
    background: #0d1117;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
}
.nl-code-header {
    background: #161b22;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    border-bottom: 1px solid #30363d;
}
.nl-code-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
}
.nl-code-dot.red { background: #ff5f57; }
.nl-code-dot.yellow { background: #febc2e; }
.nl-code-dot.green { background: #28c840; }
.nl-code-title {
    margin-left: 8px;
    font-size: 11px;
    color: #8b949e;
    font-family: monospace;
}
.nl-code-body {
    padding: 20px;
    overflow-x: auto;
}
.nl-code-body pre {
    margin: 0;
    font-family: 'Fira Code', 'Courier New', monospace;
    font-size: 11px;
    line-height: 1.6;
    color: #e6edf3;
}
.nl-api-floating-badge {
    position: absolute;
    bottom: -15px;
    right: -15px;
    background: #e8761a;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    padding: 8px 16px;
    border-radius: 999px;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 8px 20px rgba(232,118,26,0.4);
}

/* Features Grid */
.nl-api-features {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-bottom: 60px;
}
.nl-api-feature-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 20px;
    padding: 32px;
    transition: all 0.3s ease;
}
.nl-api-feature-card:hover {
    transform: translateY(-4px);
    border-color: #e8761a;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
}
.nl-api-feature-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 20px;
}
.nl-api-feature-card h3 {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 10px;
}
.nl-api-feature-card p {
    font-size: 13px;
    color: #666;
    line-height: 1.7;
    margin-bottom: 16px;
}
.nl-api-feature-tag {
    display: inline-block;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 4px 10px;
    border-radius: 6px;
}

/* Integrations */
.nl-api-integrations {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 28px;
    padding: 56px;
    margin-bottom: 60px;
    text-align: center;
}
.nl-integrations-eyebrow {
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
    margin-bottom: 20px;
}
.nl-api-integrations h3 {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    color: #1a1a1a;
    margin-bottom: 12px;
}
.nl-api-integrations > p {
    font-size: 15px;
    color: #666;
    max-width: 550px;
    margin: 0 auto 40px;
}
.nl-integrations-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 16px;
    margin-bottom: 32px;
}
.nl-integration-card {
    background: #f8faff;
    border: 1px solid #e5e7eb;
    border-radius: 50px;
    padding: 8px 20px 8px 12px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.2s;
}
.nl-integration-card:hover {
    border-color: #e8761a;
    transform: translateY(-2px);
}
.nl-integration-icon {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}
.nl-integration-card span {
    font-size: 13px;
    font-weight: 600;
    color: #1a1a1a;
}
.nl-integrations-cta a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #e8761a;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    transition: gap 0.2s;
}
.nl-integrations-cta a:hover { gap: 12px; }

/* Webhooks Demo */
.nl-webhooks-demo {
    background: linear-gradient(135deg, #f8faff 0%, #fff 100%);
    border-radius: 28px;
    padding: 56px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    margin-bottom: 60px;
    border: 1px solid #e5e7eb;
}
.nl-demo-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #8b5cf6;
    background: rgba(139,92,246,0.1);
    padding: 6px 14px;
    border-radius: 999px;
    margin-bottom: 20px;
}
.nl-webhooks-demo h3 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(26px, 2.8vw, 36px);
    color: #1a1a1a;
    line-height: 1.2;
    margin-bottom: 16px;
}
.nl-webhooks-demo h3 em { font-style: italic; color: #e8761a; }
.nl-webhooks-demo > p {
    font-size: 15px;
    color: #666;
    line-height: 1.8;
    margin-bottom: 24px;
}
.nl-demo-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 32px;
}
.nl-demo-list li {
    font-size: 14px;
    color: #444;
    display: flex;
    align-items: center;
    gap: 10px;
}
.nl-demo-list li i { color: #10b981; font-size: 14px; }
.nl-btn-webhook {
    background: linear-gradient(135deg, #8b5cf6, #6d28d9);
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
.nl-btn-webhook:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(139,92,246,0.35); color: #fff; }

.nl-webhook-config-mock {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 20px;
    padding: 28px;
    box-shadow: 0 12px 32px rgba(0,0,0,0.05);
}
.nl-mock-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 16px;
    margin-bottom: 20px;
    border-bottom: 1px solid #e5e7eb;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}
.nl-mock-status { font-size: 11px; display: flex; align-items: center; gap: 5px; }
.nl-mock-field { margin-bottom: 20px; }
.nl-mock-field label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #888;
    margin-bottom: 6px;
}
.nl-mock-input {
    background: #f8faff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 12px 14px;
    font-size: 13px;
    color: #1a1a1a;
    font-family: monospace;
}
.nl-mock-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.nl-mock-tag {
    background: #eff6ff;
    color: #3b82f6;
    font-size: 11px;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 20px;
}
.nl-mock-actions {
    display: flex;
    gap: 12px;
    margin-top: 20px;
}
.nl-mock-btn {
    background: #f1f3f5;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    color: #555;
    cursor: default;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* CTA Banner */
.nl-api-cta-banner {
    background: linear-gradient(135deg, #0f2240, #1e3a5f);
    border-radius: 24px;
    padding: 48px 56px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 30px;
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
.nl-cta-primary:hover { background: #c45e0e; transform: translateY(-2px); color: #fff; }
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
.nl-cta-secondary:hover { border-color: #fff; background: rgba(255,255,255,0.08); color: #fff; }

/* Responsive */
@media(max-width: 1200px) {
    .nl-api-features { grid-template-columns: repeat(2, 1fr); }
}
@media(max-width: 1000px) {
    .nl-api-hero { grid-template-columns: 1fr; padding: 40px; }
    .nl-webhooks-demo { grid-template-columns: 1fr; }
    .nl-api-integrations { padding: 40px 24px; }
}
@media(max-width: 768px) {
    .nl-api-body { padding: 0 20px 40px; }
    .nl-api-hero { padding: 32px 24px; }
    .nl-api-features { grid-template-columns: 1fr; }
    .nl-api-stats { gap: 20px; }
    .nl-api-cta-banner { flex-direction: column; text-align: center; padding: 32px 24px; }
    .nl-integrations-grid { justify-content: center; }
    .nl-api-floating-badge { display: none; }
}
@media(max-width: 480px) {
    .nl-code-body pre { font-size: 8px; }
    .nl-mock-tags { flex-wrap: wrap; }
}
</style>