{{-- ============================================================
     BLOC 7 — ESPACES TÉLÉ-POSITIONNEMENT · CONTACT DIRECT
     Avatar avec casque d'écoute · Diffuseur d'information · Mix Médias · Courriel
     ============================================================ --}}
@php
    $tr = static function (string $text): string {
        $locale = app()->getLocale();
        if ($locale === 'fr') return $text;
        static $maps = [];
        if (!array_key_exists($locale, $maps)) {
            $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-contact-direct.php');
            $maps[$locale] = is_file($path) ? (require $path) : [];
        }
        return $maps[$locale][$text] ?? $text;
    };

    $channels = [
        [
            'icon'  => 'fas fa-user-headset',
            'color' => '#e8761a',
            'title' => 'Contact Direct Avatar',
            'desc'  => 'Un avatar professionnel avec casque d\'écoute prend en charge vos clients cibles en temps réel. Interaction humaine et digitale fusionnée.',
            'tag'   => 'Avatar Live',
        ],
        [
            'icon'  => 'fas fa-broadcast-tower',
            'color' => '#3b82f6',
            'title' => 'Diffuseur d\'Information',
            'desc'  => 'Diffusez vos messages directement chez vos clients cibles via le mix médias : SMS, push, audio et visual broadcasting en simultané.',
            'tag'   => 'Broadcast',
        ],
        [
            'icon'  => 'fas fa-envelope-open-text',
            'color' => '#10b981',
            'title' => 'Envoi de Courriel Professionnel',
            'desc'  => 'Créez et envoyez des courriels avec visuels professionnels adaptés à vos services. Templates responsive, brandés et percutants.',
            'tag'   => 'Email Pro',
        ],
        [
            'icon'  => 'fas fa-photo-video',
            'color' => '#8b5cf6',
            'title' => 'Visuel Adapté à Vos Services',
            'desc'  => 'Chaque communication inclut un visuel professionnel sur-mesure. Images, bannières et médias riches adaptés à votre identité.',
            'tag'   => 'Rich Media',
        ],
        [
            'icon'  => 'fas fa-bullseye',
            'color' => '#f59e0b',
            'title' => 'Ciblage Client Précis',
            'desc'  => 'Atteignez exactement vos clients cibles grâce au mix médias intelligent. Segmentation avancée et personnalisation de masse.',
            'tag'   => 'Targeting',
        ],
        [
            'icon'  => 'fas fa-chart-bar',
            'color' => '#ef4444',
            'title' => 'Suivi & Performance',
            'desc'  => 'Mesurez l\'impact de chaque diffusion en temps réel : taux d\'ouverture, clics, conversions et retour sur investissement.',
            'tag'   => 'Analytics',
        ],
    ];

    $sectors = [
        ['icon' => 'fas fa-store',          'title' => 'Commerces & Retail',       'desc' => 'Informez vos clients en direct'],
        ['icon' => 'fas fa-clinic-medical',  'title' => 'Santé & Bien-être',        'desc' => 'Communiquez avec vos patients'],
        ['icon' => 'fas fa-graduation-cap', 'title' => 'Éducation & Formation',    'desc' => 'Engagez vos apprenants'],
        ['icon' => 'fas fa-hotel',          'title' => 'Hôtellerie & Tourisme',    'desc' => 'Fidélisez vos voyageurs'],
        ['icon' => 'fas fa-building',       'title' => 'Immobilier',               'desc' => 'Touchez vos prospects'],
        ['icon' => 'fas fa-concierge-bell', 'title' => 'Services aux entreprises', 'desc' => 'Renforcez votre relation B2B'],
    ];
@endphp

<section class="cd-section" id="nl-tele-positionnement">

    {{-- EN-TÊTE STANDARD --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="Contact Direct GoExploria">
                    <div class="logo-wrapper">
                        <img src="{{ asset('images/Next-level.png') }}" alt="Next Level">
                    </div>
                    <span class="resto-accord-btn-label">Contact Direct</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-user-headset"></i> Pro</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('ESPACES TÉLÉ-POSITIONNEMENT · CONTACT DIRECT') }}</h1>
                <h2 class="resto-header-eyebrow">{{ $tr('Avatar · Diffuseur d\'Information · Mix Médias · Courriel Professionnel') }}</h2>
                <p class="resto-header-subtitle">{{ $tr('La meilleure façon de diffuser vos informations en direct chez vos clients cibles grâce au diffuseur d\'information, au mix médias contact direct et à l\'envoi de courriel avec visuels professionnels.') }}</p>
            </div>
            <div class="resto-header-logo-right">
                <a href="{{ url('espace-next-level/tele-positionnement') }}" title="{{ $tr('Découvrir') }}" target="_blank" rel="noopener noreferrer">
                    <img class="bt-next-level-image" src="{{ asset('images/Next-level.png') }}" alt="{{ $tr('Next Level') }}" loading="lazy">
                </a>
            </div>
        </div>
        @include('home-v2.components.espace_next_level.SectionNavBarNextLevel')
        <div class="resto-header-shimmer"></div>
    </div>

    <div class="cd-body">

        {{-- HERO BANNER --}}
        <div class="cd-hero">
            <div class="cd-hero-content">
                <div class="cd-badge">
                    <i class="fas fa-broadcast-tower"></i>
                    {{ $tr('Diffusion en Direct · Mix Médias Intelligent') }}
                </div>
                <h2>
                    {{ $tr('La meilleure façon de diffuser') }}<br>
                    <em>{{ $tr('vos informations chez vos clients cibles') }}</em>
                </h2>
                <p>{{ $tr('Grâce au diffuseur d\'information et au mix médias contact direct client cible, diffusez vos messages en temps réel avec un avatar professionnel, des courriels visuels et un ciblage précis.') }}</p>
                <div class="cd-stats">
                    <div class="cd-stat"><i class="fas fa-user-headset"></i><div><strong>100%</strong><span>{{ $tr('Personnalisé') }}</span></div></div>
                    <div class="cd-stat"><i class="fas fa-bolt"></i><div><strong>&lt;2s</strong><span>{{ $tr('Diffusion') }}</span></div></div>
                    <div class="cd-stat"><i class="fas fa-layer-group"></i><div><strong>Multi</strong><span>{{ $tr('Canaux') }}</span></div></div>
                    <div class="cd-stat"><i class="fas fa-shield-alt"></i><div><strong>RGPD</strong><span>{{ $tr('Conforme') }}</span></div></div>
                </div>
                <div class="cd-actions">
                    <a href="{{ url('devis') }}" class="nl-btn-primary" target="_blank">
                        <i class="fas fa-paper-plane"></i> {{ $tr('Démarrer maintenant') }}
                    </a>
                </div>
            </div>

            {{-- VISUEL HERO : Avatar + Email Mock --}}
            <div class="cd-hero-visual">

                {{-- Avatar Card --}}
                <div class="cd-avatar-card">
                    <div class="cd-avatar-img-wrap">
                        <img src="{{ asset('images/ASSISTANT-WEB-G-EX.png') }}"
                             alt="{{ $tr('Assistant Web GoExploria') }}"
                             class="cd-avatar-img"
                             loading="lazy">
                        <span class="cd-avatar-live"><i class="fas fa-circle"></i> {{ $tr('En direct') }}</span>
                    </div>
                    <div class="cd-avatar-info">
                        <strong>{{ $tr('Assistants Web') }}</strong>
                        <span>{{ $tr('Contact Direct · GoExploria') }}</span>
                    </div>
                    <div class="cd-avatar-wave">
                        <span></span><span></span><span></span><span></span><span></span>
                    </div>
                </div>

                {{-- Email Mock --}}
                <div class="cd-email-mock">
                    <div class="cd-email-header">
                        <div class="cd-email-dots">
                            <span style="background:#ef4444"></span>
                            <span style="background:#f59e0b"></span>
                            <span style="background:#10b981"></span>
                        </div>
                        <span class="cd-email-title"><i class="fas fa-envelope"></i> {{ $tr('Nouveau message') }}</span>
                    </div>
                    <div class="cd-email-meta">
                        <div class="cd-email-row"><label>{{ $tr('De') }} :</label><span>contact@goexploria.com</span></div>
                        <div class="cd-email-row"><label>{{ $tr('À') }} :</label><span>{{ $tr('client.cible@entreprise.com') }}</span></div>
                        <div class="cd-email-row"><label>{{ $tr('Objet') }} :</label><span class="cd-email-subject">{{ $tr('🚀 Votre offre personnalisée est prête') }}</span></div>
                    </div>
                    <div class="cd-email-body">
                        <div class="cd-email-banner">
                            <i class="fas fa-user-headset"></i>
                            <div>
                                <strong>{{ $tr('GoExploria · Assistants Web') }}</strong>
                                <span>{{ $tr('Solutions de communication directe') }}</span>
                            </div>
                        </div>
                        <div class="cd-email-text">
                            <div class="cd-email-line cd-line-lg"></div>
                            <div class="cd-email-line cd-line-md"></div>
                            <div class="cd-email-line cd-line-sm"></div>
                            <div class="cd-email-line cd-line-md"></div>
                        </div>
                        <div class="cd-email-cta-btn">
                            <i class="fas fa-arrow-right"></i> {{ $tr('Voir mon offre') }}
                        </div>
                        <div class="cd-email-footer-mock">
                            <div class="cd-email-line cd-line-sm" style="width:40%"></div>
                        </div>
                    </div>
                </div>

                {{-- Floating notification --}}
                <div class="cd-floating-notif">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <strong>{{ $tr('Message envoyé !') }}</strong>
                        <span>{{ $tr('1 240 clients atteints · 14:32') }}</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- FEATURES GRID --}}
        <div class="cd-features" id="cd-features">
            <div class="cd-section-header">
                <span class="cd-eyebrow"><i class="fas fa-cogs"></i> {{ $tr('Fonctionnalités') }}</span>
                <h3>{{ $tr('Une solution complète de') }}<br><span class="cd-gradient-text">{{ $tr('communication directe') }}</span></h3>
                <p>{{ $tr('Combinez avatar, diffusion et courriel professionnel pour toucher vos clients cibles avec impact.') }}</p>
            </div>
            <div class="cd-features-grid">
                @foreach($channels as $ch)
                <div class="cd-feature-card">
                    <div class="cd-feature-icon" style="background:{{ $ch['color'] }}20;color:{{ $ch['color'] }}">
                        <i class="{{ $ch['icon'] }}"></i>
                    </div>
                    <h4>{{ $tr($ch['title']) }}</h4>
                    <p>{{ $tr($ch['desc']) }}</p>
                    <div class="cd-feature-tag" style="background:{{ $ch['color'] }}15;color:{{ $ch['color'] }}">{{ $tr($ch['tag']) }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- CTA FINAL --}}
        <div class="cd-cta">
            <div class="cd-cta-content">
                <i class="fas fa-user-headset"></i>
                <h3>{{ $tr('Prêt à communiquer directement avec vos clients ?') }}</h3>
                <p>{{ $tr('Rejoignez des centaines d\'entreprises qui diffusent leurs informations en direct grâce à nos solutions de contact direct.') }}</p>
            </div>
            <div class="cd-cta-buttons">
                <a href="{{ url('devis') }}" class="cd-cta-primary" target="_blank">
                    <i class="fas fa-headset"></i> {{ $tr('Parler à un expert') }}
                </a>
            </div>
        </div>

    </div>
</section>

<style>
/* ══════════════════════════════════════════════════
   CONTACT DIRECT — STYLES
   ══════════════════════════════════════════════════ */
.cd-section { background: linear-gradient(180deg,#f8faff 0%,#fff 100%); }
.cd-body    { padding: 0 40px 60px; }

/* ── Gradient text ── */
.cd-gradient-text {
    background: linear-gradient(135deg,#e8761a,#f59e0b);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

/* ── Section header ── */
.cd-section-header { text-align: center; margin-bottom: 40px; }
.cd-eyebrow {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 1.5px; color: #e8761a; background: #fef3ea;
    padding: 6px 14px; border-radius: 999px; margin-bottom: 16px;
}
.cd-section-header h3 {
    font-family: 'Playfair Display', serif; font-size: 28px;
    color: #1a1a1a; margin-bottom: 12px;
}
.cd-section-header p { font-size: 15px; color: #666; max-width: 580px; margin: 0 auto; }

/* ── Hero ── */
.cd-hero {
    background: linear-gradient(135deg,#0a1628 0%,#1a2a4a 100%);
    border-radius: 28px; margin: 24px 0 48px; padding: 56px 64px;
    display: grid; grid-template-columns: 1fr 1fr; gap: 50px;
    align-items: center; position: relative; overflow: hidden;
}
.cd-hero::before {
    content: ''; position: absolute; top: -30%; left: -20%; width: 70%; height: 160%;
    background: radial-gradient(circle,rgba(232,118,26,.08) 0%,transparent 70%);
    pointer-events: none;
}

.cd-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(52,211,153,.15); border: 1px solid rgba(52,211,153,.3);
    color: #34d399; border-radius: 999px; padding: 6px 16px;
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 1px; margin-bottom: 24px;
}
.cd-hero h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(28px,3vw,42px); color: #fff;
    line-height: 1.15; margin-bottom: 20px;
}
.cd-hero h2 em { font-style: italic; color: #e8761a; }
.cd-hero > p, .cd-hero-content > p {
    font-size: 15px; color: rgba(255,255,255,.7); line-height: 1.8; margin-bottom: 28px;
}

/* Stats */
.cd-stats { display: flex; gap: 18px; margin-bottom: 32px; flex-wrap: wrap; }
.cd-stat {
    display: flex; align-items: center; gap: 10px;
    background: rgba(255,255,255,.05); padding: 10px 16px;
    border-radius: 12px; border: 1px solid rgba(255,255,255,.1);
}
.cd-stat i { font-size: 22px; color: #e8761a; }
.cd-stat strong { display: block; font-family:'Bebas Neue',sans-serif; font-size: 20px; color: #fff; line-height: 1; }
.cd-stat span   { font-size: 10px; color: rgba(255,255,255,.6); text-transform: uppercase; letter-spacing: .5px; }

.cd-actions { display: flex; gap: 14px; flex-wrap: wrap; }

/* ── Hero Visual ── */
.cd-hero-visual { position: relative; display: flex; flex-direction: column; gap: 20px; }

/* Avatar card */
.cd-avatar-card {
    background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.12);
    border-radius: 20px; padding: 20px 24px;
    display: flex; align-items: center; gap: 16px;
    backdrop-filter: blur(12px);
}
.cd-avatar-img-wrap { position: relative; flex-shrink: 0; }
.cd-avatar-img { width: 90px; height: 90px; border-radius: 50%; object-fit: cover; object-position: top; border: 3px solid #e8761a; }
.cd-avatar-live {
    position: absolute; bottom: -4px; left: 50%; transform: translateX(-50%);
    background: #10b981; color: #fff; font-size: 8px; font-weight: 700;
    padding: 2px 8px; border-radius: 999px; white-space: nowrap;
    display: flex; align-items: center; gap: 4px;
}
.cd-avatar-live i { font-size: 6px; animation: cdBlink 1.5s infinite; }
@keyframes cdBlink { 0%,100%{opacity:1} 50%{opacity:.2} }
.cd-avatar-info strong { display: block; font-size: 14px; color: #fff; font-weight: 700; }
.cd-avatar-info span   { font-size: 11px; color: rgba(255,255,255,.5); }

/* Voice wave animation */
.cd-avatar-wave { display: flex; align-items: center; gap: 3px; margin-left: auto; }
.cd-avatar-wave span {
    display: block; width: 4px; border-radius: 99px; background: #e8761a;
    animation: cdWave 1.2s ease-in-out infinite;
}
.cd-avatar-wave span:nth-child(1){ height:8px;  animation-delay:0s; }
.cd-avatar-wave span:nth-child(2){ height:16px; animation-delay:.1s; }
.cd-avatar-wave span:nth-child(3){ height:24px; animation-delay:.2s; }
.cd-avatar-wave span:nth-child(4){ height:16px; animation-delay:.3s; }
.cd-avatar-wave span:nth-child(5){ height:8px;  animation-delay:.4s; }
@keyframes cdWave {
    0%,100%{ transform: scaleY(1); opacity:.6; }
    50%     { transform: scaleY(1.8); opacity:1; }
}

/* Email mock */
.cd-email-mock {
    background: #fff; border-radius: 16px; overflow: hidden;
    box-shadow: 0 12px 40px rgba(0,0,0,.18);
}
.cd-email-header {
    background: #f3f4f6; padding: 10px 16px;
    display: flex; align-items: center; gap: 10px;
    border-bottom: 1px solid #e5e7eb;
}
.cd-email-dots { display: flex; gap: 5px; }
.cd-email-dots span { width: 10px; height: 10px; border-radius: 50%; display: block; }
.cd-email-title { font-size: 12px; font-weight: 600; color: #555; display: flex; align-items: center; gap: 6px; }
.cd-email-title i { color: #e8761a; }

.cd-email-meta { padding: 10px 16px; border-bottom: 1px solid #f0f0f0; }
.cd-email-row  { display: flex; gap: 8px; font-size: 11px; padding: 2px 0; }
.cd-email-row label { color: #999; min-width: 36px; }
.cd-email-row span  { color: #555; }
.cd-email-subject   { color: #1a1a1a; font-weight: 700; }

.cd-email-body { padding: 14px 16px; }
.cd-email-banner {
    background: linear-gradient(135deg,#0a1628,#1e3a5f);
    border-radius: 10px; padding: 12px 16px;
    display: flex; align-items: center; gap: 12px; margin-bottom: 14px;
}
.cd-email-banner i { font-size: 24px; color: #e8761a; }
.cd-email-banner strong { display: block; font-size: 12px; color: #fff; }
.cd-email-banner span  { font-size: 10px; color: rgba(255,255,255,.6); }

.cd-email-text { margin-bottom: 12px; display: flex; flex-direction: column; gap: 6px; }
.cd-email-line { height: 8px; background: #f0f0f0; border-radius: 4px; }
.cd-line-lg { width: 90%; }
.cd-line-md { width: 70%; }
.cd-line-sm { width: 50%; }

.cd-email-cta-btn {
    background: linear-gradient(135deg,#e8761a,#c04f10);
    color: #fff; border-radius: 8px; padding: 10px 18px;
    font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;
    margin-bottom: 12px;
}
.cd-email-footer-mock { padding-top: 10px; border-top: 1px solid #f0f0f0; }

/* Floating notification */
.cd-floating-notif {
    position: absolute; bottom: -16px; left: -16px;
    background: #fff; border-radius: 12px; padding: 10px 14px;
    display: flex; align-items: center; gap: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,.15);
}
.cd-floating-notif i { font-size: 18px; color: #10b981; }
.cd-floating-notif strong { display: block; font-size: 11px; color: #1a1a1a; }
.cd-floating-notif span  { font-size: 10px; color: #666; }

/* ── Features grid ── */
.cd-features { margin-bottom: 60px; }
.cd-features-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; }
.cd-feature-card {
    background: #fff; border: 1.5px solid #e5e7eb;
    border-radius: 20px; padding: 32px; transition: all .3s;
}
.cd-feature-card:hover { transform: translateY(-4px); border-color: #e8761a; box-shadow: 0 20px 40px rgba(0,0,0,.08); }
.cd-feature-icon {
    width: 52px; height: 52px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; margin-bottom: 18px;
}
.cd-feature-card h4 { font-size: 16px; font-weight: 700; color: #1a1a1a; margin-bottom: 10px; }
.cd-feature-card p  { font-size: 13px; color: #666; line-height: 1.7; margin-bottom: 16px; }
.cd-feature-tag {
    display: inline-block; font-size: 10px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .8px; padding: 4px 10px; border-radius: 6px;
}

/* ── How it works ── */
.cd-how {
    background: linear-gradient(135deg,#0a1628,#1e3a5f);
    border-radius: 28px; padding: 56px 48px; margin-bottom: 60px;
}
.cd-how .cd-section-header h3 { color: #fff; }
.cd-how .cd-section-header p  { color: rgba(255,255,255,.6); }
.cd-how .cd-eyebrow { background: rgba(232,118,26,.2); }

.cd-steps { display: flex; align-items: center; gap: 16px; justify-content: center; flex-wrap: wrap; }
.cd-step {
    flex: 1; min-width: 200px; max-width: 260px; text-align: center;
    background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.1);
    border-radius: 20px; padding: 32px 24px; position: relative;
}
.cd-step-num {
    position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
    font-family: 'Bebas Neue', sans-serif; font-size: 28px; color: #e8761a;
    background: #0a1628; padding: 0 8px; line-height: 1;
}
.cd-step-icon {
    width: 60px; height: 60px; background: rgba(232,118,26,.15);
    border-radius: 18px; display: flex; align-items: center; justify-content: center;
    font-size: 26px; color: #e8761a; margin: 16px auto 20px;
}
.cd-step h4 { font-size: 18px; color: #fff; margin-bottom: 10px; font-weight: 700; }
.cd-step p  { font-size: 13px; color: rgba(255,255,255,.6); line-height: 1.7; }

.cd-step-arrow { font-size: 24px; color: rgba(255,255,255,.2); flex-shrink: 0; }

/* ── Sectors ── */
.cd-sectors {
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 28px; padding: 48px; margin-bottom: 60px;
}
.cd-sectors-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; margin-top: 8px; }
.cd-sector-card {
    text-align: center; padding: 24px; background: #f8faff;
    border-radius: 20px; transition: all .3s;
}
.cd-sector-card:hover { transform: translateY(-4px); background: #fff; box-shadow: 0 12px 24px rgba(0,0,0,.08); }
.cd-sector-icon {
    width: 60px; height: 60px; background: linear-gradient(135deg,#e8761a20,#f59e0b20);
    border-radius: 20px; display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px; font-size: 28px; color: #e8761a;
}
.cd-sector-card h4 { font-size: 15px; margin-bottom: 6px; font-weight: 700; color: #1a1a1a; }
.cd-sector-card p  { font-size: 12px; color: #888; }

/* ── Form ── */
.cd-form {
    background: linear-gradient(135deg,#fff,#f8faff);
    border: 1px solid #e5e7eb; border-radius: 28px; padding: 56px;
    display: grid; grid-template-columns: 1fr 1fr; gap: 60px; margin-bottom: 60px;
}
.cd-form-badge {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px;
    color: #10b981; background: rgba(16,185,129,.1); padding: 6px 14px;
    border-radius: 999px; margin-bottom: 16px;
}
.cd-form-left h3 { font-family:'Playfair Display',serif; font-size: 26px; margin-bottom: 14px; }
.cd-form-left h3 em { font-style: italic; color: #e8761a; }
.cd-form-left p  { font-size: 15px; color: #666; line-height: 1.8; margin-bottom: 24px; }
.cd-benefits { list-style: none; display: flex; flex-direction: column; gap: 12px; }
.cd-benefits li { font-size: 14px; color: #444; display: flex; align-items: center; gap: 10px; }
.cd-benefits li i { color: #10b981; }

.cd-form-group  { margin-bottom: 16px; }
.cd-form-row    { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.cd-form-group label {
    display: block; font-size: 12px; font-weight: 700; color: #374151; margin-bottom: 6px;
}
.cd-form-group input,
.cd-form-group select {
    width: 100%; border: 1.5px solid #e5e7eb; border-radius: 10px;
    padding: 12px 14px; font-size: 14px; transition: border-color .2s;
}
.cd-form-group input:focus,
.cd-form-group select:focus { outline: none; border-color: #e8761a; }
.cd-btn-submit {
    width: 100%; background: linear-gradient(135deg,#e8761a,#c04f10);
    color: #fff; border: none; border-radius: 10px; padding: 14px;
    font-size: 14px; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .2s; margin-top: 8px;
}
.cd-btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(232,118,26,.35); }
.cd-form-note { font-size: 11px; color: #9ca3af; text-align: center; margin-top: 12px; }

/* ── CTA ── */
.cd-cta {
    background: linear-gradient(135deg,#0f2240,#1e3a5f);
    border-radius: 24px; padding: 48px 56px;
    display: flex; justify-content: space-between; align-items: center;
    gap: 40px; flex-wrap: wrap;
}
.cd-cta-content { display: flex; flex-direction: column; align-items: flex-start; }
.cd-cta-content i  { font-size: 36px; color: #e8761a; margin-bottom: 12px; }
.cd-cta-content h3 { font-size: 22px; color: #fff; margin-bottom: 8px; }
.cd-cta-content p  { font-size: 14px; color: rgba(255,255,255,.7); max-width: 500px; }
.cd-cta-buttons    { display: flex; gap: 14px; flex-wrap: wrap; }
.cd-cta-primary {
    background: #e8761a; color: #fff; padding: 14px 28px; border-radius: 10px;
    font-weight: 700; font-size: 14px; text-decoration: none;
    display: inline-flex; align-items: center; gap: 8px; transition: all .2s;
}
.cd-cta-primary:hover { background: #c45e0e; transform: translateY(-2px); color: #fff; }
.cd-cta-secondary {
    border: 2px solid rgba(255,255,255,.3); color: #fff; padding: 14px 28px;
    border-radius: 10px; font-weight: 700; font-size: 14px; text-decoration: none;
    display: inline-flex; align-items: center; gap: 8px; transition: all .2s;
}
.cd-cta-secondary:hover { border-color: #fff; background: rgba(255,255,255,.08); color: #fff; }

/* ── Responsive ── */
@media (max-width:1100px) {
    .cd-hero        { grid-template-columns: 1fr; padding: 40px; }
    .cd-features-grid { grid-template-columns: repeat(2,1fr); }
    .cd-sectors-grid  { grid-template-columns: repeat(2,1fr); }
    .cd-form        { grid-template-columns: 1fr; gap: 32px; }
    .cd-steps       { flex-direction: column; align-items: stretch; }
    .cd-step-arrow  { transform: rotate(90deg); text-align: center; }
}
@media (max-width:768px) {
    .cd-body        { padding: 0 20px 40px; }
    .cd-features-grid { grid-template-columns: 1fr; }
    .cd-sectors-grid  { grid-template-columns: 1fr; }
    .cd-cta         { flex-direction: column; text-align: center; padding: 32px 24px; }
    .cd-cta-content { align-items: center; text-align: center; }
    .cd-form .cd-form-row { grid-template-columns: 1fr; }
    .cd-floating-notif { position: static; margin-top: 8px; }
}
</style>

<script>
document.getElementById('cdContactForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Merci ! Votre demande de démo a été enregistrée. Notre équipe vous contacte sous 24h pour activer votre accès.');
    this.reset();
});
</script>