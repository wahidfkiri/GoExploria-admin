{{-- ============================================================
     BLOC 3 — ESPACES ÉDITEUR DE SITE WEB & ESPACES ENTREPRISES
     Création sans code
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

<section class="nl-editor-section" id="nl-editeur">

    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="Éditeur Web">
                    <div class="logo-wrapper">
                        <i class="fas fa-laptop-code" style="font-size:24px;color:#e8761a"></i>
                    </div>
                    <span class="resto-accord-btn-label">Web Studio</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-wand-magic-sparkles"></i> IA</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('ÉDITEUR DE SITE WEB & ESPACES ENTREPRISES') }}</h1>
                <h2 class="resto-header-eyebrow">{{ $tr('Création sans code · IA intégrée · Résultats professionnels en minutes') }}</h2>
                <p class="resto-header-subtitle">{{ $tr('Créez, personnalisez et publiez votre site web professionnel sans aucune compétence technique. Notre éditeur visuel intelligent s\'adapte à votre secteur.') }}</p>
            </div>
            <div class="resto-header-logo-right">
                <a href="{{ url('next-level-editeur') }}" title="{{ $tr('Essayer l\'éditeur') }}" target="_blank" rel="noopener noreferrer">
                    <img class="bt-next-level-image" src="{{ asset('images/Next-level.png') }}" alt="{{ $tr('Next Level') }}" loading="lazy">
                </a>
            </div>
        </div>
        @include('home-v2.components.espace_next_level.SectionNavBarNextLevel')
        <div class="resto-header-shimmer"></div>
    </div>

    <div class="nl-editor-body">

        {{-- BROWSER PREVIEW --}}
        <div class="nl-editor-showcase">
            <div class="nl-editor-left">
                <span class="nl-ed-eyebrow"><i class="fas fa-wand-magic-sparkles"></i> {{ $tr('IA Intégrée') }}</span>
                <h2>{{ $tr('Votre site web en ligne') }}<br><em>{{ $tr('en moins d\'une heure') }}</em></h2>
                <p>{{ $tr('Notre éditeur glisser-déposer intelligent génère automatiquement votre structure de site selon votre secteur. Ajoutez votre contenu, choisissez vos couleurs, publiez. C\'est tout.') }}</p>
                <div class="nl-ed-steps">
                    <div class="nl-ed-step">
                        <div class="nl-ed-step-num">1</div>
                        <div>
                            <h4>{{ $tr('Choisissez votre template') }}</h4>
                            <p>{{ $tr('200+ modèles professionnels classés par secteur d\'activité.') }}</p>
                        </div>
                    </div>
                    <div class="nl-ed-step">
                        <div class="nl-ed-step-num">2</div>
                        <div>
                            <h4>{{ $tr('Personnalisez avec l\'IA') }}</h4>
                            <p>{{ $tr('Décrivez votre business, l\'IA génère vos textes et suggestions visuelles.') }}</p>
                        </div>
                    </div>
                    <div class="nl-ed-step">
                        <div class="nl-ed-step-num">3</div>
                        <div>
                            <h4>{{ $tr('Publiez en un clic') }}</h4>
                            <p>{{ $tr('Domaine, hébergement SSL et CDN mondial inclus dans chaque plan.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="nl-ed-actions">
                    <a href="{{ url('devis') }}" class="nl-btn-primary" target="_blank">
                        <i class="fas fa-play"></i> {{ $tr('Essayer gratuitement') }}
                    </a>
                    {{-- <a href="{{ url('next-level-templates') }}" class="nl-btn-outline-dark" target="_blank">
                        <i class="fas fa-th-large"></i> {{ $tr('Voir les templates') }}
                    </a>
                    --}}
                </div>
            </div>

            <div class="nl-editor-right">
                <div class="nl-browser-frame">
                    <div class="nl-browser-bar">
                        <div class="nl-browser-dots"><span></span><span></span><span></span></div>
                        <div class="nl-browser-url">https://votre-entreprise.goexploria.com</div>
                        <div class="nl-browser-actions">
                            <span><i class="fas fa-arrows-rotate"></i></span>
                            <span><i class="fas fa-share-from-square"></i></span>
                        </div>
                    </div>
                    <div class="nl-browser-content">
                        <div class="nl-preview-hero">
                            <div class="nl-preview-nav">
                                <span class="nl-prev-logo">◆ BrandName</span>
                                <div class="nl-prev-links"><span>Accueil</span><span>Services</span><span>À propos</span><span>Contact</span></div>
                                <span class="nl-prev-cta-btn">Réserver</span>
                            </div>
                            <div class="nl-preview-hero-content">
                                <div class="nl-prev-eyebrow">Tourisme & Aventure</div>
                                <div class="nl-prev-title">Découvrez le<br>Québec avec nous</div>
                                <div class="nl-prev-sub">Expériences uniques, destinations exclusives</div>
                                <div class="nl-prev-btns">
                                    <span class="nl-prev-btn-a">Découvrir</span>
                                    <span class="nl-prev-btn-b">En savoir plus</span>
                                </div>
                            </div>
                        </div>
                        <div class="nl-preview-cards">
                            <div class="nl-prev-card" style="background:#f0f9ff"><i class="fas fa-mountain" style="color:#3b82f6"></i><span>Aventure</span></div>
                            <div class="nl-prev-card" style="background:#fef3ea"><i class="fas fa-utensils" style="color:#e8761a"></i><span>Gastronomie</span></div>
                            <div class="nl-prev-card" style="background:#f0fdf4"><i class="fas fa-camera" style="color:#10b981"></i><span>Galerie</span></div>
                        </div>
                        <div class="nl-editor-tools-overlay">
                            <div class="nl-tool-badge"><i class="fas fa-wand-magic-sparkles"></i> IA génère votre contenu</div>
                        </div>
                    </div>
                </div>
                <!-- Floating pill badges -->
                <div class="nl-floating-pill nl-fp-1"><i class="fas fa-mobile-alt"></i> 100% Responsive</div>
                <div class="nl-floating-pill nl-fp-2"><i class="fas fa-shield-halved"></i> SSL Inclus</div>
                <div class="nl-floating-pill nl-fp-3"><i class="fas fa-bolt"></i> Ultra Rapide</div>
            </div>
        </div>

        {{-- FONCTIONNALITES --}}
        <div class="nl-ed-features-grid">
            @php
            $edFeatures = [
                ['icon'=>'fas fa-arrows-up-down-left-right','color'=>'#e8761a','title'=>'Glisser-Déposer Visuel','desc'=>'Interface intuitive : déplacez, redimensionnez et personnalisez chaque élément de votre site sans toucher une ligne de code.'],
                ['icon'=>'fas fa-palette','color'=>'#3b82f6','title'=>'Design Personnalisable','desc'=>'Couleurs, polices, animations et mise en page entièrement personnalisables. 500+ éléments de design professionnels inclus.'],
                ['icon'=>'fas fa-mobile-screen','color'=>'#10b981','title'=>'100% Responsive','desc'=>'Votre site s\'adapte parfaitement à tous les écrans : desktop, tablette et mobile. Testé sur 50+ appareils.'],
                ['icon'=>'fas fa-robot','color'=>'#8b5cf6','title'=>'Rédaction IA','desc'=>'L\'IA génère automatiquement vos textes, meta-descriptions et contenus SEO optimisés selon votre secteur d\'activité.'],
                ['icon'=>'fas fa-globe','color'=>'#f59e0b','title'=>'Multilingue Intégré','desc'=>'Publiez votre site en jusqu\'à 25 langues avec traduction automatique IA et gestion des versions localisées.'],
                ['icon'=>'fas fa-chart-mixed','color'=>'#ef4444','title'=>'Analytics Intégré','desc'=>'Tableau de bord en temps réel : visiteurs, conversions, sources de trafic et heatmaps pour optimiser votre performance.'],
            ];
            @endphp
            @foreach($edFeatures as $f)
            <div class="nl-ed-feature-card">
                <div class="nl-ed-feature-icon" style="background:{{ $f['color'] }}20;color:{{ $f['color'] }}">
                    <i class="{{ $f['icon'] }}"></i>
                </div>
                <h4>{{ $tr($f['title']) }}</h4>
                <p>{{ $tr($f['desc']) }}</p>
            </div>
            @endforeach
        </div>


    </div>
</section>

<style>
.nl-editor-section { background: #f8faff; }
.nl-editor-body { padding: 0 40px 60px; }

/* Showcase */
.nl-editor-showcase {
    display: grid; grid-template-columns: 1fr 1fr; gap: 70px;
    align-items: center; margin: 24px 0 48px;
}
.nl-ed-eyebrow {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px;
    color: #8b5cf6; background: rgba(139,92,246,0.1); padding: 6px 14px;
    border-radius: 999px; margin-bottom: 16px;
}
.nl-editor-left h2 { font-family: 'Playfair Display', serif; font-size: clamp(28px,3vw,42px); color: #1a1a1a; line-height: 1.15; margin-bottom: 16px; }
.nl-editor-left h2 em { font-style: italic; color: #e8761a; }
.nl-editor-left > p { font-size: 15px; color: #555; line-height: 1.8; margin-bottom: 28px; }
.nl-editor-left { padding: 0 24px; }
.nl-ed-steps { display: flex; flex-direction: column; gap: 20px; margin-bottom: 32px; }
.nl-ed-step { display: flex; gap: 16px; align-items: flex-start; }
.nl-ed-step-num {
    width: 36px; height: 36px; border-radius: 50%; background: #e8761a; color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 14px; flex-shrink: 0;
}
.nl-ed-step h4 { font-size: 14px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px; }
.nl-ed-step p { font-size: 13px; color: #666; line-height: 1.6; }
.nl-ed-actions { display: flex; gap: 12px; flex-wrap: wrap; }
.nl-btn-outline-dark {
    border: 2px solid #1a1a1a; color: #1a1a1a; padding: 14px 24px; border-radius: 10px;
    font-weight: 700; font-size: 14px; text-decoration: none;
    display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;
}
.nl-btn-outline-dark:hover { background: #1a1a1a; color: #fff; }

/* Browser Frame */
.nl-editor-right { position: relative; justify-self: end; width: 100%; max-width: 700px; }
.nl-browser-frame {
    background: #fff; border-radius: 16px; overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,0.15); border: 1px solid #e5e7eb;
}
.nl-browser-bar {
    background: #f1f3f5; padding: 10px 16px; display: flex; align-items: center; gap: 12px;
    border-bottom: 1px solid #e5e7eb;
}
.nl-browser-dots { display: flex; gap: 5px; }
.nl-browser-dots span { width: 10px; height: 10px; border-radius: 50%; }
.nl-browser-dots span:nth-child(1) { background: #ff5f57; }
.nl-browser-dots span:nth-child(2) { background: #febc2e; }
.nl-browser-dots span:nth-child(3) { background: #28c840; }
.nl-browser-url { flex: 1; background: #fff; border: 1px solid #e5e7eb; border-radius: 6px; padding: 4px 12px; font-size: 11px; color: #666; text-align: center; }
.nl-browser-actions { display: flex; gap: 10px; color: #888; font-size: 13px; }
.nl-browser-content { position: relative; }
.nl-preview-hero {
    background: linear-gradient(135deg,#0f2240,#1e3a5f); padding: 14px 16px 20px;
}
.nl-preview-nav { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.nl-prev-logo { font-size: 12px; font-weight: 800; color: #fff; }
.nl-prev-links { display: flex; gap: 12px; }
.nl-prev-links span { font-size: 9px; color: rgba(255,255,255,0.7); }
.nl-prev-cta-btn { background: #e8761a; color: #fff; font-size: 9px; font-weight: 700; padding: 4px 10px; border-radius: 5px; }
.nl-preview-hero-content { padding: 0 8px; }
.nl-prev-eyebrow { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #e8761a; margin-bottom: 6px; }
.nl-prev-title { font-size: 18px; font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 6px; }
.nl-prev-sub { font-size: 10px; color: rgba(255,255,255,0.65); margin-bottom: 14px; }
.nl-prev-btns { display: flex; gap: 8px; }
.nl-prev-btn-a { background: #e8761a; color: #fff; font-size: 9px; font-weight: 700; padding: 5px 12px; border-radius: 5px; }
.nl-prev-btn-b { border: 1px solid rgba(255,255,255,0.4); color: #fff; font-size: 9px; font-weight: 700; padding: 5px 12px; border-radius: 5px; }
.nl-preview-cards { display: grid; grid-template-columns: repeat(3,1fr); gap: 8px; padding: 12px; }
.nl-prev-card { border-radius: 8px; padding: 12px; text-align: center; font-size: 10px; font-weight: 700; color: #1a1a1a; }
.nl-prev-card i { display: block; font-size: 18px; margin-bottom: 5px; }
.nl-editor-tools-overlay {
    position: absolute; bottom: 60px; right: 10px;
}
.nl-tool-badge {
    background: rgba(139,92,246,0.9); color: #fff; font-size: 10px; font-weight: 700;
    padding: 6px 12px; border-radius: 20px;
    display: flex; align-items: center; gap: 5px;
}
.nl-floating-pill {
    position: absolute; background: #fff; border: 1px solid #e5e7eb;
    border-radius: 999px; padding: 6px 14px; font-size: 11px; font-weight: 700;
    color: #1a1a1a; box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    display: flex; align-items: center; gap: 6px;
}
.nl-fp-1 { bottom: -10px; left: -20px; }
.nl-fp-2 { bottom: 40px; right: -20px; }
.nl-fp-3 { top: 20px; right: -30px; }
.nl-floating-pill i { color: #e8761a; }

/* Features Grid */
.nl-ed-features-grid { width: 100%; display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 20px; margin-bottom: 48px; }
.nl-ed-feature-card { background: #fff; border: 1.5px solid #e5e7eb; border-radius: 20px; padding: 28px; transition: all 0.3s; }
.nl-ed-feature-card:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(0,0,0,0.08); }
.nl-ed-feature-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 16px; }
.nl-ed-feature-card h4 { font-size: 15px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px; }
.nl-ed-feature-card p { font-size: 13px; color: #666; line-height: 1.65; }

/* Plans */
.nl-ed-plans-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
.nl-ed-plan { background: #fff; border: 2px solid #e5e7eb; border-radius: 20px; padding: 36px; position: relative; }
.nl-ed-plan-featured { border-color: #e8761a; background: linear-gradient(160deg,#fffbf7,#fff); }
.nl-ed-plan-badge { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #e8761a; margin-bottom: 12px; }
.nl-ed-plan-name { font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 8px; }
.nl-ed-plan-price { font-family: 'Bebas Neue', sans-serif; font-size: 44px; color: #1a1a1a; line-height: 1; margin-bottom: 4px; }
.nl-ed-plan-price span { font-size: 15px; font-weight: 400; color: #888; font-family: 'DM Sans', sans-serif; }
.nl-ed-plan-list { list-style: none; display: flex; flex-direction: column; gap: 10px; margin: 20px 0 28px; }
.nl-ed-plan-list li { font-size: 13px; color: #444; display: flex; align-items: center; gap: 8px; }
.nl-ed-plan-list li i { color: #10b981; font-size: 13px; }
.nl-disabled { opacity: 0.45; }
.nl-disabled i { color: #ccc !important; }
.nl-ed-plan-cta { display: block; text-align: center; padding: 14px; border-radius: 10px; font-weight: 700; font-size: 14px; text-decoration: none; transition: all 0.2s; }
.nl-ed-cta-light { background: #f0f4ff; color: #1e3a5f; border: 2px solid #e5e7eb; }
.nl-ed-cta-light:hover { background: #1e3a5f; color: #fff; }
.nl-ed-cta-orange { background: #e8761a; color: #fff; }
.nl-ed-cta-orange:hover { background: #c45e0e; color: #fff; }

@media(max-width:1100px) {
    .nl-editor-showcase { grid-template-columns: repeat(2,minmax(0,1fr)); gap: 28px; align-items: start; }
    .nl-editor-left { padding: 0; }
    .nl-ed-features-grid { grid-template-columns: repeat(2,1fr); }
    .nl-ed-plans-row { grid-template-columns: 1fr; }
    .nl-floating-pill { display: none; }
}
@media(max-width:900px) {
    .nl-editor-showcase { grid-template-columns: 1fr; }
    .nl-editor-right { justify-self: stretch; max-width: none; }
}
@media(max-width:640px) {
    .nl-editor-body { padding: 0 16px 40px; }
    .nl-ed-features-grid { grid-template-columns: 1fr; }
}
</style>
