{{-- ============================================================
     BLOC 1 — CONSEILS ENTREPRISES / PASSEZ AU NIVEAU SUPÉRIEUR
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
@endphp

<section class="agency-v2-section nl-agency-section" id="activez-entreprises">

    {{-- EN-TÊTE STANDARD --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="GoExploria Next Level">
                    <div class="logo-wrapper">
                        <img src="{{ asset('images/Next-level.png') }}" alt="Next Level">
                    </div>
                    <span class="resto-accord-btn-label">Next Level</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-rocket"></i> Pro</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('CONSEILS ENTREPRISES') }}</h1>
                <h2 class="resto-header-eyebrow">{{ $tr('PASSEZ AU NIVEAU SUPÉRIEUR — Visibilité & Performance') }}</h2>
                <p class="resto-header-subtitle">{{ $tr('Démarrez maintenant et optimisez votre présence en ligne avec nos experts.') }}</p>
            </div>
            <div class="resto-header-logo-right">
                <a href="{{ url('espace-next-level/agency') }}" title="{{ $tr('En savoir plus') }}" target="_blank" rel="noopener noreferrer">
                    <img class="bt-next-level-image" src="{{ asset('images/Next-level.png') }}" alt="{{ $tr('Next Level') }}" loading="lazy">
                </a>
            </div>
        </div>
        @include('home-v2.components.espace_next_level.SectionNavBarNextLevel')
        <div class="resto-header-destinations-bar">
            <div class="resto-dest-row">
                <div class="resto-dest-icon-box">
                    <img src="{{ asset('REDI.png') }}" alt="Destinations">
                    <span>Destinations</span>
                </div>
                <div class="resto-dest-breadcrumb vp-dest-breadcrumb">
                    <select class="vp-dest-select" aria-label="Continent">
                        <option>Amérique du Nord</option><option>Europe</option><option>Afrique</option><option>Asie</option>
                    </select>
                    <span class="resto-dest-sep">/</span>
                    <select class="vp-dest-select" aria-label="Pays"><option>Canada</option></select>
                    <span class="resto-dest-sep">/</span>
                    <select class="vp-dest-select" aria-label="Province">
                        <option>Québec</option><option>Ontario</option><option>Alberta</option>
                    </select>
                    <span class="resto-dest-sep">/</span>
                    <select class="vp-dest-select" aria-label="Région">
                        <option>Région de Québec</option><option>Montréal Métro</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="resto-header-shimmer"></div>
    </div>

    {{-- CORPS PRINCIPAL --}}
    <div class="nl-agency-body">

        {{-- HERO BANNER --}}
        <div class="nl-hero-banner">
            <div class="nl-hero-bg-mesh"></div>
            <div class="nl-hero-content">
                <div class="nl-hero-badge">
                    <span class="nl-badge-dot"></span>
                    {{ $tr('Service actif — Experts disponibles maintenant') }}
                </div>
                <h2 class="nl-hero-title">
                    {{ $tr('Transformez votre visibilité') }}<br>
                    <em>{{ $tr('en croissance réelle') }}</em>
                </h2>
                <p class="nl-hero-desc">{{ $tr('Notre équipe de consultants certifiés analyse votre situation actuelle, identifie les opportunités clés et déploie des stratégies digitales qui génèrent des résultats mesurables dès les premières semaines.') }}</p>
                <div class="nl-hero-actions">
                    <a href="{{ url('devis') }}" class="nl-btn-primary" target="_blank">
                        <i class="fas fa-rocket"></i> {{ $tr('Consultation gratuite') }}
                    </a>
                    <!-- <a href="#nl-plans" class="nl-btn-secondary">
                        <i class="fas fa-list-check"></i> {{ $tr('Voir nos formules') }}
                    </a> -->
                </div>
                <div class="nl-hero-kpis">
                    <div class="nl-kpi"><strong>+42%</strong><span>{{ $tr('Croissance moyenne') }}</span></div>
                    <div class="nl-kpi"><strong>94%</strong><span>{{ $tr('Clients satisfaits') }}</span></div>
                    <div class="nl-kpi"><strong>250+</strong><span>{{ $tr('Projets livrés') }}</span></div>
                    <div class="nl-kpi"><strong>48h</strong><span>{{ $tr('Délai de démarrage') }}</span></div>
                </div>
            </div>
            <div class="nl-hero-visual">
                <div class="nl-dashboard-mock">
                    <div class="nl-dash-topbar">
                        <div class="nl-dash-dots"><span></span><span></span><span></span></div>
                        <div class="nl-dash-title">GoExploria Dashboard — Performance</div>
                    </div>
                    <div class="nl-dash-body">
                        <div class="nl-dash-metric">
                            <span class="nl-dash-label">{{ $tr('Visibilité Google') }}</span>
                            <div class="nl-dash-bar-wrap"><div class="nl-dash-bar" style="width:84%"></div></div>
                            <span class="nl-dash-val">84%</span>
                        </div>
                        <div class="nl-dash-metric">
                            <span class="nl-dash-label">{{ $tr('Taux de conversion') }}</span>
                            <div class="nl-dash-bar-wrap"><div class="nl-dash-bar" style="width:67%;background:linear-gradient(90deg,#10b981,#34d399)"></div></div>
                            <span class="nl-dash-val" style="color:#10b981">67%</span>
                        </div>
                        <div class="nl-dash-metric">
                            <span class="nl-dash-label">{{ $tr('Score SEO') }}</span>
                            <div class="nl-dash-bar-wrap"><div class="nl-dash-bar" style="width:91%;background:linear-gradient(90deg,#3b82f6,#60a5fa)"></div></div>
                            <span class="nl-dash-val" style="color:#3b82f6">91/100</span>
                        </div>
                        <div class="nl-dash-metric">
                            <span class="nl-dash-label">{{ $tr('Leads entrants') }}</span>
                            <div class="nl-dash-bar-wrap"><div class="nl-dash-bar" style="width:73%;background:linear-gradient(90deg,#8b5cf6,#a78bfa)"></div></div>
                            <span class="nl-dash-val" style="color:#8b5cf6">+73%</span>
                        </div>
                        <div class="nl-dash-live">
                            <span><i class="fas fa-circle" style="color:#10b981;font-size:8px"></i> {{ $tr('Mis à jour en temps réel') }}</span>
                            <span>{{ $tr('Il y a 2 min.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SERVICES CONSEIL --}}
        <div class="nl-conseil-grid">
            <div class="nl-conseil-card">
                <div class="nl-conseil-icon" style="background:linear-gradient(135deg,#fef3ea,#fde4c5);color:#e8761a"><i class="fas fa-chart-line"></i></div>
                <h3>{{ $tr('Audit Digital Complet') }}</h3>
                <p>{{ $tr('Analyse en profondeur de votre présence en ligne, de votre positionnement SEO, de vos campagnes actives et de vos concurrents directs.') }}</p>
                <div class="nl-conseil-tag">{{ $tr('Rapport en 72h') }}</div>
            </div>
            <div class="nl-conseil-card">
                <div class="nl-conseil-icon" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);color:#3b82f6"><i class="fas fa-bullseye"></i></div>
                <h3>{{ $tr('Stratégie de Croissance') }}</h3>
                <p>{{ $tr('Plan d\'action personnalisé sur 3, 6 et 12 mois avec objectifs chiffrés, canaux prioritaires et budget optimisé pour votre marché.') }}</p>
                <div class="nl-conseil-tag">{{ $tr('ROI garanti') }}</div>
            </div>
            <div class="nl-conseil-card">
                <div class="nl-conseil-icon" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);color:#10b981"><i class="fas fa-users-cog"></i></div>
                <h3>{{ $tr('Accompagnement Expert') }}</h3>
                <p>{{ $tr('Un consultant dédié qui pilote l\'exécution de votre stratégie, forme vos équipes et assure un suivi hebdomadaire des KPIs.') }}</p>
                <div class="nl-conseil-tag">{{ $tr('Suivi hebdomadaire') }}</div>
            </div>
            <div class="nl-conseil-card">
                <div class="nl-conseil-icon" style="background:linear-gradient(135deg,#fdf4ff,#f3e8ff);color:#8b5cf6"><i class="fas fa-robot"></i></div>
                <h3>{{ $tr('Optimisation IA') }}</h3>
                <p>{{ $tr('Intégration des derniers outils d\'intelligence artificielle pour automatiser vos processus, personnaliser vos contenus et multiplier votre productivité.') }}</p>
                <div class="nl-conseil-tag">{{ $tr('IA intégrée') }}</div>
            </div>
        </div>

        {{-- FORMULAIRE CONSULTATION --}}
        <div class="nl-form-section" id="nl-form">
            <div class="nl-form-left">
                <span class="nl-form-eyebrow"><i class="fas fa-calendar-check"></i> {{ $tr('Consultation offerte') }}</span>
                <h3>{{ $tr('Demandez votre diagnostic gratuit') }}</h3>
                <p>{{ $tr('En 45 minutes, nos experts analysent votre situation et vous remettent un plan d\'action concret. Sans engagement, sans pression.') }}</p>
                <ul class="nl-form-benefits">
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Audit de votre site web et présence digitale') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Analyse SEO et positionnement concurrentiel') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Recommandations personnalisées immédiatement') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Estimation du potentiel de croissance') }}</li>
                </ul>
            </div>
            <div class="nl-form-right">
                <form class="nl-consul-form" id="nlConsulForm">
                    <div class="nl-form-row">
                        <div class="nl-form-group">
                            <label>{{ $tr('Nom de votre entreprise') }}</label>
                            <input type="text" placeholder="{{ $tr('Ex: Ma Société Inc.') }}" required>
                        </div>
                        <div class="nl-form-group">
                            <label>{{ $tr('Votre nom complet') }}</label>
                            <input type="text" placeholder="{{ $tr('Ex: Jean Dupont') }}" required>
                        </div>
                    </div>
                    <div class="nl-form-group">
                        <label>{{ $tr('Adresse courriel professionnelle') }}</label>
                        <input type="email" placeholder="jean@entreprise.com" required>
                    </div>
                    <div class="nl-form-group">
                        <label>{{ $tr('Secteur d\'activité') }}</label>
                        <select required>
                            <option value="">{{ $tr('Choisissez votre secteur') }}</option>
                            <option>{{ $tr('Tourisme & Hôtellerie') }}</option>
                            <option>{{ $tr('Commerce & E-commerce') }}</option>
                            <option>{{ $tr('Services & Conseil') }}</option>
                            <option>{{ $tr('Restauration & Gastronomie') }}</option>
                            <option>{{ $tr('Immobilier & Construction') }}</option>
                            <option>{{ $tr('Autre secteur') }}</option>
                        </select>
                    </div>
                    <div class="nl-form-group">
                        <label>{{ $tr('Votre principal défi en ce moment') }}</label>
                        <textarea placeholder="{{ $tr('Décrivez brièvement votre situation...') }}" rows="3"></textarea>
                    </div>
                    <button type="submit" class="nl-btn-submit">
                        <i class="fas fa-paper-plane"></i> {{ $tr('Envoyer ma demande') }}
                    </button>
                    <p class="nl-form-note">{{ $tr('Réponse garantie sous 24h · Zéro spam · Confidentialité assurée') }}</p>
                </form>
            </div>
        </div>

    </div>
</section>

<style>
/* ── NL AGENCY SECTION ── */
.nl-agency-section { background: linear-gradient(180deg,#f8faff 0%,#fff 100%); }
.nl-agency-body { padding: 0 40px 60px; }

/* Hero Banner */
.nl-hero-banner {
    background: linear-gradient(135deg,#0f2240 0%,#1e3a5f 60%,#0d1b35 100%);
    border-radius: 24px; margin: 24px 0; padding: 64px;
    display: grid; grid-template-columns: 1fr 1fr; gap: 60px;
    align-items: center; position: relative; overflow: hidden;
}
.nl-hero-bg-mesh {
    position: absolute; inset: 0; pointer-events: none;
    background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
    background-size: 40px 40px;
}
.nl-hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(52,211,153,0.15); border: 1px solid rgba(52,211,153,0.3);
    color: #34d399; border-radius: 999px; padding: 6px 16px;
    font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
    margin-bottom: 24px;
}
.nl-badge-dot {
    width: 7px; height: 7px; background: #34d399; border-radius: 50%;
    animation: nlPulse 2s infinite;
}
@keyframes nlPulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.4;transform:scale(1.4)} }
.nl-hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(32px, 3.5vw, 52px); color: #fff;
    line-height: 1.1; margin-bottom: 20px;
}
.nl-hero-title em { font-style: italic; color: #e8761a; }
.nl-hero-desc { font-size: 16px; color: rgba(255,255,255,0.7); line-height: 1.85; margin-bottom: 36px; }
.nl-hero-actions { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 40px; }
.nl-btn-primary {
    background: #e8761a; color: #fff; padding: 14px 28px; border-radius: 10px;
    font-weight: 700; font-size: 14px; text-decoration: none;
    display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;
}
.nl-btn-primary:hover { background: #c45e0e; transform: translateY(-2px); color: #fff; }
.nl-btn-secondary {
    border: 2px solid rgba(255,255,255,0.3); color: #fff; padding: 14px 28px;
    border-radius: 10px; font-weight: 700; font-size: 14px; text-decoration: none;
    display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;
}
.nl-btn-secondary:hover { border-color: #fff; background: rgba(255,255,255,0.08); color: #fff; }
.nl-hero-kpis { display: flex; gap: 32px; }
.nl-kpi strong { display: block; font-family: 'Bebas Neue', sans-serif; font-size: 40px; color: #e8761a; line-height: 1; }
.nl-kpi span { font-size: 11px; color: rgba(255,255,255,0.55); text-transform: uppercase; letter-spacing: 0.8px; margin-top: 4px; display: block; }

/* Dashboard Mock */
.nl-dashboard-mock {
    background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);
    border-radius: 16px; overflow: hidden;
}
.nl-dash-topbar {
    background: rgba(255,255,255,0.06); padding: 10px 16px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
    display: flex; align-items: center; gap: 10px;
}
.nl-dash-dots { display: flex; gap: 5px; }
.nl-dash-dots span { width: 9px; height: 9px; border-radius: 50%; background: rgba(255,255,255,0.2); }
.nl-dash-dots span:nth-child(1) { background: #ff5f57; }
.nl-dash-dots span:nth-child(2) { background: #febc2e; }
.nl-dash-dots span:nth-child(3) { background: #28c840; }
.nl-dash-title { font-size: 11px; color: rgba(255,255,255,0.4); margin-left: 8px; }
.nl-dash-body { padding: 24px; display: flex; flex-direction: column; gap: 18px; }
.nl-dash-metric { display: flex; align-items: center; gap: 12px; }
.nl-dash-label { font-size: 12px; color: rgba(255,255,255,0.6); width: 130px; flex-shrink: 0; }
.nl-dash-bar-wrap { flex: 1; height: 6px; background: rgba(255,255,255,0.08); border-radius: 999px; overflow: hidden; }
.nl-dash-bar { height: 100%; border-radius: 999px; background: linear-gradient(90deg,#e8761a,#f5a623); }
.nl-dash-val { font-size: 13px; font-weight: 700; color: #e8761a; min-width: 48px; text-align: right; }
.nl-dash-live {
    display: flex; justify-content: space-between; padding-top: 12px;
    border-top: 1px solid rgba(255,255,255,0.07); font-size: 11px; color: rgba(255,255,255,0.4);
}

/* Conseil Cards */
.nl-conseil-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; margin: 32px 0; }
.nl-conseil-card {
    background: #fff; border: 1.5px solid #e5e7eb; border-radius: 20px; padding: 32px;
    transition: all 0.3s;
}
.nl-conseil-card:hover { border-color: #e8761a; transform: translateY(-4px); box-shadow: 0 20px 48px rgba(232,118,26,0.1); }
.nl-conseil-icon {
    width: 52px; height: 52px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; margin-bottom: 18px;
}
.nl-conseil-card h3 { font-size: 16px; font-weight: 700; color: #1a1a1a; margin-bottom: 10px; }
.nl-conseil-card p { font-size: 13px; color: #666; line-height: 1.7; margin-bottom: 16px; }
.nl-conseil-tag {
    font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;
    color: #10b981; background: rgba(16,185,129,0.1); padding: 4px 10px;
    border-radius: 6px; display: inline-block;
}

/* Form Section */
.nl-form-section {
    background: #f8faff; border-radius: 24px; padding: 56px;
    display: grid; grid-template-columns: 1fr 1fr; gap: 60px; margin-top: 32px;
}
.nl-form-eyebrow {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px;
    color: #e8761a; background: #fef3ea; padding: 6px 14px; border-radius: 999px; margin-bottom: 16px;
}
.nl-form-left h3 { font-family: 'Playfair Display', serif; font-size: 28px; color: #1a1a1a; margin-bottom: 14px; }
.nl-form-left p { font-size: 15px; color: #666; line-height: 1.8; margin-bottom: 24px; }
.nl-form-benefits { list-style: none; display: flex; flex-direction: column; gap: 12px; }
.nl-form-benefits li { font-size: 14px; color: #444; display: flex; align-items: center; gap: 10px; }
.nl-form-benefits li i { color: #10b981; font-size: 14px; flex-shrink: 0; }
.nl-consul-form { display: flex; flex-direction: column; gap: 16px; }
.nl-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.nl-form-group { display: flex; flex-direction: column; gap: 6px; }
.nl-form-group label { font-size: 12px; font-weight: 700; color: #374151; }
.nl-form-group input, .nl-form-group select, .nl-form-group textarea {
    border: 1.5px solid #e5e7eb; border-radius: 10px; padding: 12px 14px;
    font-size: 14px; color: #1a1a1a; background: #fff; outline: none;
    transition: border-color 0.2s; font-family: 'DM Sans', sans-serif;
}
.nl-form-group input:focus, .nl-form-group select:focus, .nl-form-group textarea:focus { border-color: #e8761a; }
.nl-btn-submit {
    background: linear-gradient(135deg,#e8761a,#c04f10); color: #fff;
    border: none; border-radius: 10px; padding: 16px; font-size: 15px;
    font-weight: 700; cursor: pointer; display: flex; align-items: center;
    justify-content: center; gap: 8px; transition: all 0.2s;
}
.nl-btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(232,118,26,0.35); }
.nl-form-note { font-size: 11px; color: #9ca3af; text-align: center; margin-top: 4px; }

@@media(max-width:1100px) {
    .nl-hero-banner { grid-template-columns: 1fr; }
    .nl-conseil-grid { grid-template-columns: repeat(2,1fr); }
    .nl-form-section { grid-template-columns: 1fr; }
}
@@media(max-width:640px) {
    .nl-agency-body { padding: 0 16px 40px; }
    .nl-hero-banner { padding: 36px 24px; }
    .nl-conseil-grid { grid-template-columns: 1fr; }
    .nl-hero-kpis { flex-wrap: wrap; gap: 20px; }
    .nl-form-row { grid-template-columns: 1fr; }
    .nl-form-section { padding: 32px 24px; }
}
</style>

<script>
document.getElementById('nlConsulForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Merci ! Votre demande a été envoyée. Notre équipe vous contacte sous 24h.');
    this.reset();
});
</script>