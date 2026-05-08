{{-- ============================================================
     BLOC 5 — ESPACES FORMULAIRES (CONTACT, RÉSERVATION, INSCRIPTION)
     Créez vos formulaires sans code · Drag & Drop · Automation
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

    $formTemplates = [
        [
            'icon' => 'fas fa-envelope',
            'color' => '#e8761a',
            'title' => 'Formulaire de Contact',
            'desc' => 'Captez vos prospects avec un formulaire élégant. Notifications email, validation antispam et redirection personnalisée.',
            'fields' => ['Nom', 'Email', 'Téléphone', 'Message'],
            'tag' => 'POPULAIRE'
        ],
        [
            'icon' => 'fas fa-calendar-check',
            'color' => '#3b82f6',
            'title' => 'Formulaire de Réservation',
            'desc' => 'Système de réservation complet avec choix des dates, options de paiement et confirmation automatique.',
            'fields' => ['Arrivée', 'Départ', 'Nombre de personnes', 'Options'],
            'tag' => 'TOUT EN UN'
        ],
        [
            'icon' => 'fas fa-user-plus',
            'color' => '#10b981',
            'title' => 'Formulaire d\'Inscription',
            'desc' => 'Créez votre base de données clients. Inscription simple ou multi-étapes avec vérification email.',
            'fields' => ['Email', 'Mot de passe', 'Confirmation', 'Newsletter'],
            'tag' => 'NEWSLETTER'
        ],
        [
            'icon' => 'fas fa-chalkboard-user',
            'color' => '#8b5cf6',
            'title' => 'Devis & Demande d\'info',
            'desc' => 'Générez des devis automatiques. Clients qualifiés, pièces jointes et réponse sous 24h.',
            'fields' => ['Service souhaité', 'Budget', 'Date souhaitée', 'Fichiers'],
            'tag' => 'PRO'
        ],
        [
            'icon' => 'fas fa-vote-yea',
            'color' => '#f59e0b',
            'title' => 'Sondages & Avis',
            'desc' => 'Collectez les retours clients, évaluez votre service et boostez votre réputation en ligne.',
            'fields' => ['Note /5', 'Commentaire', 'Recommandation', 'Anonyme'],
            'tag' => 'AVIS'
        ],
        [
            'icon' => 'fas fa-ticket-alt',
            'color' => '#ef4444',
            'title' => 'Événements & Billeterie',
            'desc' => 'Vendez vos billets en ligne. QR code généré automatiquement, places limitées et rappels SMS.',
            'fields' => ['Type de billet', 'Quantité', 'Code promo', 'Participant'],
            'tag' => 'BILLETTERIE'
        ],
    ];

    $formFeatures = [
        ['icon' => 'fas fa-arrows-up-down-left-right', 'color' => '#e8761a', 'title' => 'Constructeur visuel', 'desc' => 'Glissez-déposez vos champs, réorganisez les blocs et personnalisez l\'apparence en temps réel.'],
        ['icon' => 'fas fa-bolt', 'color' => '#f59e0b', 'title' => 'Conditions logiques', 'desc' => 'Affichez ou masquez des champs selon les réponses. Des formulaires dynamiques et intelligents.'],
        ['icon' => 'fas fa-shield-alt', 'color' => '#10b981', 'title' => 'Anti-spam intégré', 'desc' => 'Protection reCAPTCHA, honeypot et filtrage automatique. Zéro spam, uniquement des leads qualifiés.'],
        ['icon' => 'fas fa-envelope-open-text', 'color' => '#3b82f6', 'title' => 'Notifications automatiques', 'desc' => 'Email de confirmation client, notification admin, pièces jointes et templates personnalisables.'],
        ['icon' => 'fas fa-database', 'color' => '#8b5cf6', 'title' => 'Stockage & Export', 'desc' => 'Toutes vos soumissions sauvegardées. Export CSV, connexion CRM ou webhook vers vos outils.'],
        ['icon' => 'fab fa-wpforms', 'color' => '#e8761a', 'title' => 'Paiements intégrés', 'desc' => 'Acceptez les paiements Stripe, PayPal. Réservations payantes, acomptes ou paiement complet.'],
    ];

    $integrations = [
        ['name' => 'Mailchimp', 'icon' => 'fab fa-mailchimp', 'bg' => '#ffe01b', 'color' => '#1a1a1a'],
        ['name' => 'Brevo', 'icon' => 'fas fa-fish', 'bg' => '#0b996e', 'color' => '#fff'],
        ['name' => 'Google Sheets', 'icon' => 'fab fa-google', 'bg' => '#4285f4', 'color' => '#fff'],
        ['name' => 'Slack', 'icon' => 'fab fa-slack', 'bg' => '#4a154b', 'color' => '#fff'],
        ['name' => 'Zapier', 'icon' => 'fas fa-bolt', 'bg' => '#ff4a00', 'color' => '#fff'],
        ['name' => 'Salesforce', 'icon' => 'fab fa-salesforce', 'bg' => '#00a1e0', 'color' => '#fff'],
    ];
@endphp

<section class="nl-forms-section" id="nl-formulaires">

    {{-- EN-TÊTE STANDARD --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="Formulaires Next Level">
                    <div class="logo-wrapper">
                        <img src="{{ asset('images/Next-level.png') }}" alt="Next Level">
                    </div>
                    <span class="resto-accord-btn-label">Forms Builder</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-wpforms"></i> Pro</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('ESPACES FORMULAIRES') }}</h1>
                <h2 class="resto-header-eyebrow">{{ $tr('Contact · Réservation · Inscription — Créez vos formulaires en 2 minutes') }}</h2>
                <p class="resto-header-subtitle">{{ $tr('Plus besoin de développeur. Créez des formulaires professionnels avec notre constructeur visuel intelligent. Captez vos leads, automatisez vos process et convertissez plus.') }}</p>
            </div>
            <div class="resto-header-logo-right">
                <a href="{{ url('espace-next-level/formulaire') }}" title="{{ $tr('Créer un formulaire') }}" target="_blank" rel="noopener noreferrer">
                    <img class="bt-next-level-image" src="{{ asset('images/Next-level.png') }}" alt="{{ $tr('Next Level') }}" loading="lazy">
                </a>
            </div>
        </div>
        @include('home-v2.components.espace_next_level.SectionNavBarNextLevel')
        <div class="resto-header-shimmer"></div>
    </div>

    <div class="nl-forms-body">

        {{-- HERO BANNER --}}
        <div class="nl-forms-hero">
            <div class="nl-forms-hero-content">
                <div class="nl-forms-badge">
                    <i class="fas fa-wand-magic-sparkles"></i> {{ $tr('Constructeur sans code') }}
                </div>
                <h2>
                    {{ $tr('Créez des formulaires') }}<br>
                    <em>{{ $tr('qui convertissent') }}</em>
                </h2>
                <p>{{ $tr('Notre constructeur drag & drop vous permet de créer n\'importe quel formulaire en quelques minutes : contact, réservation, inscription, devis, sondage, billetterie. Intégrez-les sur votre site ou partagez un lien direct.') }}</p>
                <div class="nl-forms-stats">
                    <div class="nl-forms-stat"><strong>30+</strong><span>{{ $tr('Types de champs') }}</span></div>
                    <div class="nl-forms-stat"><strong>50+</strong><span>{{ $tr('Templates pro') }}</span></div>
                    <div class="nl-forms-stat"><strong>100%</strong><span>{{ $tr('Responsive') }}</span></div>
                    <div class="nl-forms-stat"><strong>∞</strong><span>{{ $tr('Soumissions illimitées') }}</span></div>
                </div>
                <div class="nl-forms-actions">
                    <a href="{{ url('devis') }}" class="nl-btn-primary" target="_blank">
                        <i class="fas fa-plus-circle"></i> {{ $tr('Créer mon premier formulaire') }}
                    </a>
                </div>
            </div>
            <div class="nl-forms-hero-preview">
                <div class="nl-form-preview-card">
                    <div class="nl-preview-header">
                        <span class="nl-preview-title"><i class="fas fa-calendar-check"></i> {{ $tr('Demande de réservation') }}</span>
                        <span class="nl-preview-badge">{{ $tr('en direct') }}</span>
                    </div>
                    <div class="nl-preview-fields">
                        <div class="nl-preview-field">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="{{ $tr('Nom complet') }}" value="Jean Dupont" readonly>
                        </div>
                        <div class="nl-preview-field">
                            <i class="fas fa-envelope"></i>
                            <input type="email" placeholder="{{ $tr('Email') }}" value="jean@example.com" readonly>
                        </div>
                        <div class="nl-preview-field half">
                            <i class="fas fa-calendar"></i>
                            <input type="text" placeholder="{{ $tr('Date d\'arrivée') }}" value="15/05/2026" readonly>
                        </div>
                        <div class="nl-preview-field half">
                            <i class="fas fa-calendar"></i>
                            <input type="text" placeholder="{{ $tr('Date de départ') }}" value="22/05/2026" readonly>
                        </div>
                        <div class="nl-preview-field">
                            <i class="fas fa-users"></i>
                            <select disabled>
                                <option>{{ $tr('2 adultes') }}</option>
                            </select>
                        </div>
                        <div class="nl-preview-submit">
                            <span><i class="fas fa-paper-plane"></i> {{ $tr('Envoyer la demande') }}</span>
                            <span class="nl-preview-secure"><i class="fas fa-lock"></i> SSL sécurisé</span>
                        </div>
                    </div>
                    <div class="nl-preview-footer">
                        <i class="fas fa-check-circle"></i> {{ $tr('Formulaire actif — 124 soumissions ce mois-ci') }}
                    </div>
                </div>
                <div class="nl-floating-badge nl-fb-1">
                    <i class="fas fa-chart-line"></i> {{ $tr('+32% de conversions') }}
                </div>
                <div class="nl-floating-badge nl-fb-2">
                    <i class="fas fa-clock"></i> {{ $tr('Création en 2 min') }}
                </div>
            </div>
        </div>

        {{-- TEMPLATES GRID --}}
        <div class="nl-forms-templates">
            <div class="nl-section-header">
                <span class="nl-section-eyebrow"><i class="fas fa-star"></i> {{ $tr('Modèles populaires') }}</span>
                <h3>{{ $tr('Des formulaires prêts à l\'emploi') }}</h3>
                <p>{{ $tr('Choisissez parmi plus de 50 templates professionnels, personnalisez-les et publiez-les instantanément.') }}</p>
            </div>
            <div class="nl-templates-grid">
                @foreach($formTemplates as $template)
                <div class="nl-template-card">
                    <div class="nl-template-icon" style="background:{{ $template['color'] }}20;color:{{ $template['color'] }}">
                        <i class="{{ $template['icon'] }}"></i>
                    </div>
                    <div class="nl-template-tag" style="background:{{ $template['color'] }}15;color:{{ $template['color'] }}">
                        {{ $template['tag'] }}
                    </div>
                    <h4>{{ $tr($template['title']) }}</h4>
                    <p>{{ $tr($template['desc']) }}</p>
                    <div class="nl-template-fields">
                        @foreach($template['fields'] as $field)
                        <span><i class="fas fa-circle" style="font-size:4px"></i> {{ $field }}</span>
                        @endforeach
                    </div>
                    <a href="{{ url('next-level-form-template/' . Str::slug($template['title'])) }}" class="nl-template-cta" target="_blank">
                        {{ $tr('Utiliser ce modèle') }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>


    </div>
</section>

<style>
/* ── FORMULAIRES SECTION ── */
.nl-forms-section { background: linear-gradient(180deg, #fff 0%, #f8faff 100%); }
.nl-forms-body { padding: 0 40px 60px; }

/* Hero Banner */
.nl-forms-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f0f1a 100%);
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
.nl-forms-hero::before {
    content: '';
    position: absolute;
    top: -30%;
    left: -20%;
    width: 70%;
    height: 160%;
    background: radial-gradient(circle, rgba(232,118,26,0.08) 0%, transparent 70%);
    pointer-events: none;
}
.nl-forms-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(232,118,26,0.15);
    border: 1px solid rgba(232,118,26,0.3);
    color: #e8761a;
    border-radius: 999px;
    padding: 6px 16px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 24px;
}
.nl-forms-hero h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(32px, 3.2vw, 46px);
    color: #fff;
    line-height: 1.15;
    margin-bottom: 20px;
}
.nl-forms-hero h2 em { font-style: italic; color: #e8761a; }
.nl-forms-hero > p {
    font-size: 15px;
    color: rgba(255,255,255,0.7);
    line-height: 1.8;
    margin-bottom: 28px;
}
.nl-forms-stats {
    display: flex;
    gap: 32px;
    margin-bottom: 32px;
    flex-wrap: wrap;
}
.nl-forms-stat strong {
    display: block;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 38px;
    color: #e8761a;
    line-height: 1;
}
.nl-forms-stat span {
    font-size: 11px;
    color: rgba(255,255,255,0.55);
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-top: 4px;
    display: block;
}
.nl-forms-actions { display: flex; gap: 14px; flex-wrap: wrap; }
.nl-btn-secondary-forms {
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
.nl-btn-secondary-forms:hover { border-color: #fff; background: rgba(255,255,255,0.08); color: #fff; }

/* Preview Card */
.nl-forms-hero-preview { position: relative; }
.nl-form-preview-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.35);
}
.nl-preview-header {
    background: linear-gradient(135deg, #e8761a, #c04f10);
    padding: 14px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #fff;
}
.nl-preview-title { font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px; }
.nl-preview-badge {
    font-size: 10px;
    background: rgba(255,255,255,0.2);
    padding: 4px 10px;
    border-radius: 20px;
}
.nl-preview-fields { padding: 20px; background: #fff; }
.nl-preview-field {
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8faff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 0 12px;
}
.nl-preview-field i { color: #e8761a; font-size: 14px; }
.nl-preview-field input, .nl-preview-field select {
    border: none;
    background: transparent;
    padding: 12px 0;
    width: 100%;
    font-size: 13px;
    outline: none;
}
.nl-preview-field.half { width: calc(50% - 6px); display: inline-flex; margin-right: 12px; }
.nl-preview-field.half:last-child { margin-right: 0; }
.nl-preview-submit {
    background: #e8761a;
    color: #fff;
    padding: 12px;
    border-radius: 10px;
    text-align: center;
    font-weight: 700;
    font-size: 13px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 8px;
}
.nl-preview-secure { font-size: 10px; font-weight: normal; opacity: 0.8; }
.nl-preview-footer {
    background: #f0fdf4;
    padding: 10px 20px;
    font-size: 11px;
    color: #10b981;
    display: flex;
    align-items: center;
    gap: 6px;
    border-top: 1px solid #dcfce7;
}
.nl-floating-badge {
    position: absolute;
    background: #fff;
    border-radius: 999px;
    padding: 8px 16px;
    font-size: 11px;
    font-weight: 700;
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
}
.nl-fb-1 { bottom: -15px; left: -20px; color: #10b981; }
.nl-fb-2 { top: -15px; right: -20px; color: #8b5cf6; }

/* Templates Grid */
.nl-forms-templates, .nl-forms-features { margin-bottom: 60px; }
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
.nl-section-header p {
    font-size: 15px;
    color: #666;
    max-width: 550px;
    margin: 0 auto;
}
.nl-templates-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
.nl-template-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 20px;
    padding: 28px;
    transition: all 0.3s;
    position: relative;
}
.nl-template-card:hover {
    transform: translateY(-4px);
    border-color: #e8761a;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
}
.nl-template-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 16px;
}
.nl-template-tag {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 9px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 4px 10px;
    border-radius: 20px;
}
.nl-template-card h4 {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 8px;
}
.nl-template-card p {
    font-size: 13px;
    color: #666;
    line-height: 1.65;
    margin-bottom: 16px;
}
.nl-template-fields {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 20px;
}
.nl-template-fields span {
    font-size: 10px;
    color: #888;
    background: #f8faff;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.nl-template-cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #e8761a;
    font-weight: 700;
    font-size: 13px;
    text-decoration: none;
    transition: gap 0.2s;
}
.nl-template-cta:hover { gap: 12px; }

/* Features Grid */
.nl-features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
.nl-feature-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 20px;
    padding: 32px;
    transition: all 0.3s;
}
.nl-feature-card:hover { transform: translateY(-3px); border-color: #e8761a; }
.nl-feature-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 18px;
}
.nl-feature-card h4 {
    font-size: 15px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 8px;
}
.nl-feature-card p {
    font-size: 13px;
    color: #666;
    line-height: 1.7;
}

/* Integrations */
.nl-forms-integrations {
    background: linear-gradient(135deg, #f8faff, #fff);
    border: 1px solid #e5e7eb;
    border-radius: 24px;
    padding: 48px;
    text-align: center;
    margin-bottom: 60px;
}
.nl-integrations-header { margin-bottom: 32px; }
.nl-integrations-header i {
    font-size: 32px;
    color: #e8761a;
    margin-bottom: 12px;
}
.nl-integrations-header h3 {
    font-size: 22px;
    color: #1a1a1a;
    margin-bottom: 8px;
}
.nl-integrations-header p {
    font-size: 14px;
    color: #666;
}
.nl-integrations-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 12px;
}
.nl-integration-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 20px;
    border: 1px solid;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s;
}
.nl-integration-item:hover { transform: translateY(-2px); }
.nl-integration-more {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #888;
    font-size: 13px;
}

/* Demo Builder */
.nl-forms-demo {
    background: #0a1628;
    border-radius: 28px;
    padding: 56px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    margin-bottom: 60px;
    align-items: center;
}
.nl-demo-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #34d399;
    background: rgba(52,211,153,0.1);
    padding: 6px 14px;
    border-radius: 999px;
    margin-bottom: 20px;
}
.nl-demo-info h3 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(26px, 2.8vw, 36px);
    color: #fff;
    line-height: 1.2;
    margin-bottom: 16px;
}
.nl-demo-info h3 em { font-style: italic; color: #e8761a; }
.nl-demo-info p {
    font-size: 14px;
    color: rgba(255,255,255,0.7);
    line-height: 1.8;
    margin-bottom: 24px;
}
.nl-demo-info ul {
    list-style: none;
    margin-bottom: 32px;
}
.nl-demo-info li {
    color: rgba(255,255,255,0.8);
    font-size: 14px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.nl-demo-info li i { color: #10b981; }
.nl-demo-btn {
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
.nl-demo-btn:hover { transform: translateY(-2px); background: #c45e0e; color: #fff; }

.nl-builder-mock {
    background: #1e293b;
    border-radius: 16px;
    padding: 20px;
    display: flex;
    gap: 20px;
    border: 1px solid #334155;
}
.nl-builder-sidebar {
    width: 120px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.nl-builder-field-type {
    background: #334155;
    padding: 8px 10px;
    border-radius: 8px;
    font-size: 10px;
    color: #94a3b8;
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: default;
}
.nl-builder-canvas {
    flex: 1;
    background: #0f172a;
    border-radius: 12px;
    padding: 16px;
}
.nl-builder-field-row { display: flex; gap: 12px; margin-bottom: 12px; }
.nl-builder-field {
    background: #334155;
    padding: 10px 12px;
    border-radius: 8px;
    font-size: 11px;
    color: #cbd5e1;
    flex: 1;
}
.nl-field-required { color: #ef4444; }
.nl-builder-submit {
    background: #e8761a;
    padding: 10px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    text-align: center;
    color: #fff;
    margin-top: 12px;
}

/* CTA Final */
.nl-forms-cta {
    background: linear-gradient(135deg, #fef3ea, #fff3e6);
    border-radius: 24px;
    padding: 48px 56px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 30px;
    border: 1px solid #fde4c5;
}
.nl-cta-content h3 {
    font-size: 24px;
    color: #1a1a1a;
    margin-bottom: 8px;
}
.nl-cta-content p {
    font-size: 14px;
    color: #666;
}
.nl-cta-buttons { display: flex; gap: 14px; flex-wrap: wrap; }
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
    border: 2px solid #e8761a;
    color: #e8761a;
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
.nl-cta-secondary:hover { background: #e8761a; color: #fff; }

/* Responsive */
@media(max-width: 1200px) {
    .nl-templates-grid { grid-template-columns: repeat(2, 1fr); }
    .nl-features-grid { grid-template-columns: repeat(2, 1fr); }
}
@media(max-width: 1000px) {
    .nl-forms-hero { grid-template-columns: 1fr; padding: 40px; }
    .nl-forms-demo { grid-template-columns: 1fr; }
}
@media(max-width: 768px) {
    .nl-forms-body { padding: 0 20px 40px; }
    .nl-templates-grid { grid-template-columns: 1fr; }
    .nl-features-grid { grid-template-columns: 1fr; }
    .nl-forms-cta { flex-direction: column; text-align: center; padding: 32px 24px; }
    .nl-floating-badge { display: none; }
    .nl-builder-mock { flex-direction: column; }
    .nl-builder-sidebar { width: 100%; flex-direction: row; flex-wrap: wrap; }
}
</style>