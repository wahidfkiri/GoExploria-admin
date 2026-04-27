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

{{-- Web Services Component --}}
<section class="web-services-v2-section" id="web-services">

    {{-- ============================================================
         ENTÊTE STANDARD — SERVICES WEB
         ============================================================ --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
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
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('DÉVELOPPEZ VOTRE PRÉSENCE EN LIGNE AVEC NOS SERVICES WEB') }}</h1>
                <p class="resto-header-subtitle">
                    {{ $tr('Solutions Web Professionnelles — Plateforme tout-en-un pour créer, gérer et optimiser votre présence numérique.') }}
                </p>
                <div class="resto-header-tabs" role="tablist">
                    <button class="resto-tab-btn active" role="tab" data-espace="all">
                        <i class="fas fa-th-large"></i> {{ $tr('Tous les services') }}
                    </button>
                    <button class="resto-tab-btn" role="tab" data-espace="entreprise">
                        <i class="fas fa-briefcase"></i> {{ $tr('Espace entreprise') }}
                    </button>
                    <button class="resto-tab-btn" role="tab" data-espace="destination">
                        <i class="fas fa-map-marker-alt"></i> {{ $tr('Espace destination') }}
                    </button>
                    <button class="resto-tab-btn" role="tab" data-espace="activite">
                        <i class="fas fa-person-hiking"></i> {{ $tr('Espace activité') }}
                    </button>
                </div>
            </div>
            <div class="resto-header-logo-right">
                <a href="#" class="resto-accord-btn" title="{{ $tr('Plans Web Go') }}">
                    <div class="logo-wrapper">
                        <img src="{{ asset('plan-n-go.png') }}" alt="{{ $tr('Plans Web Go') }}">
                    </div>
                    <span class="resto-accord-btn-label">{{ $tr('Plans Web Go') }}</span>
                    <span class="resto-accord-btn-cta">
                        <i class="fas fa-external-link-alt"></i> {{ $tr('Visiter') }}
                    </span>
                </a>
            </div>
        </div>
        <div class="resto-header-destinations-bar">
            <div class="resto-dest-row">
                <div class="resto-dest-icon-box">
                    <img src="{{ asset('REDI.png') }}" alt="{{ $tr('Destinations') }}">
                    <span>{{ $tr('Destinations') }}</span>
                </div>
                <div class="resto-dest-breadcrumb">
                    <a href="#" class="resto-dest-link active">{{ $tr('Toutes destinations') }}</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">{{ $tr('Amérique du Nord') }}</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">{{ $tr('Canada') }}</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">{{ $tr('Québec') }}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         CONTENU PRINCIPAL
         ============================================================ --}}
    <div class="ws-container">

            {{-- 1. Les 3 Carrousels --}}
            <div class="web-carousels-grid">
                
                {{-- Carrousel Entreprises --}}
                <div class="web-carousel-box">
                    <div class="web-carousel-header">
                        <div class="web-carousel-icon"><i class="fas fa-building"></i></div>
                        <h2>{{ $tr('Entreprises') }}<br><span>{{ $tr('Clients satisfaits dans tous les secteurs') }}</span></h2>
                    </div>
                    <div class="web-carousel-content">
                        <div class="web-inner-item">
                            <div class="web-item-circle"><i class="fas fa-code"></i></div>
                            <h3 class="web-item-name">TechInnov Solutions</h3>
                            <p class="web-item-sub">{{ $tr('Île-de-France • France') }}</p>
                            <span class="web-item-tag">{{ $tr('Développement Logiciel & IA') }}</span>
                            <div style="margin-top: 15px;">
                                <a href="#" class="design-bosse-more-btn" style="font-size: 11px; padding: 10px 20px;">{{ $tr('Voir le profil') }} <span class="events-vedette-v2-plus-icon">+</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Carrousel Région --}}
                <div class="web-carousel-box">
                    <div class="web-carousel-header">
                        <div class="web-carousel-icon"><i class="fas fa-globe-europe"></i></div>
                        <h2>{{ $tr('Région') }}<br><span>{{ $tr('Présence internationale avec drapeaux') }}</span></h2>
                    </div>
                    <div class="web-carousel-content">
                        <div class="web-inner-item">
                            <div class="web-item-circle"><img src="https://flagcdn.com/w160/eu.png" alt="{{ $tr('Europe') }}"></div>
                            <h3 class="web-item-name">{{ $tr('Europe International') }}</h3>
                            <p class="web-item-sub">{{ $tr('Marché Européen') }}</p>
                            <span class="web-item-tag">{{ $tr('89 Entreprises • +22% Croissance') }}</span>
                            <div style="margin-top: 15px;">
                                <a href="#" class="design-bosse-more-btn" style="font-size: 11px; padding: 10px 20px;">{{ $tr('Explorer la région') }} <span class="events-vedette-v2-plus-icon">+</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Carrousel Activité --}}
                <div class="web-carousel-box">
                    <div class="web-carousel-header">
                        <div class="web-carousel-icon"><i class="fas fa-chart-line"></i></div>
                        <h2>{{ $tr('Activité') }}<br><span>{{ $tr('Secteurs d\'activité et spécialisations') }}</span></h2>
                    </div>
                    <div class="web-carousel-content">
                        <div class="web-inner-item">
                            <div class="web-carousel-icon" style="margin: 0 auto 20px; width: 80px; height: 80px; border-radius: 20px; background: rgba(26,58,143,0.1); color: #1a3a8f;">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <h3 class="web-item-name">{{ $tr('Commerce en ligne') }}</h3>
                            <p class="web-item-sub">{{ $tr('E-commerce complet') }}</p>
                            <span class="web-item-tag">{{ $tr('+45% de croissance annuelle') }}</span>
                            <div style="margin-top: 15px;">
                                <a href="#" class="design-bosse-more-btn" style="font-size: 11px; padding: 10px 20px;">{{ $tr('Voir solutions') }} <span class="events-vedette-v2-plus-icon">+</span></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- 2. Éditeur de Site Web --}}
            <div class="web-editor-block">
                <div class="web-editor-text">
                    <h3><i class="fas fa-laptop-code"></i> {{ $tr('ÉDITEUR DE SITE WEB') }} <span class="ai-pill">{{ $tr('IA INTÉGRÉE') }}</span></h3>
                    <p><strong>{{ $tr('AUTONOME & INTUITIF') }}</strong> : {{ $tr('Créez votre site web facilement avec nos assistants humains ou IA. Notre éditeur vous guide pas à pas dans la création d\'un site professionnel sans aucune compétence technique requise.') }}</p>
                    <p><strong>{{ $tr('INSCRIVEZ-VOUS') }}</strong> {{ $tr('pour afficher votre entreprise et obtenir des résultats concrets avec une visibilité accrue et des outils marketing intégrés.') }}</p>
                    
                    <div class="web-editor-features">
                        <div class="web-ef-unit"><i class="fas fa-robot"></i> {{ $tr('Assistance IA 24/7') }}</div>
                        <div class="web-ef-unit"><i class="fas fa-palette"></i> {{ $tr('Design personnalisable') }}</div>
                        <div class="web-ef-unit"><i class="fas fa-mobile-alt"></i> {{ $tr('100% Responsive') }}</div>
                        <div class="web-ef-unit"><i class="fas fa-bolt"></i> {{ $tr('Chargement ultra-rapide') }}</div>
                    </div>
                </div>
                
                <div class="web-browser-visual">
                    <div class="web-browser-ui">
                        <div class="ui-head">
                            <span class="ui-dot red"></span>
                            <span class="ui-dot yellow"></span>
                            <span class="ui-dot green"></span>
                            <div class="ui-url">https://www.goexploria-pro.com/mon-nouveau-site</div>
                        </div>
                        <div class="ui-content">
                            <h4 style="font-size: 24px; font-weight: 800; color: #1a3a8f; margin-bottom: 15px;">{{ $tr('Création de site simplifiée') }}</h4>
                            <p style="font-size: 13px; color: #777; margin-bottom: 25px;">{{ $tr('Glissez-déposez les éléments, personnalisez les couleurs et polices, et publiez en un clic.') }}</p>
                            <a href="#" class="design-bosse-more-btn">{{ $tr('Essayer la démo') }} <span class="events-vedette-v2-plus-icon">+</span></a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. Liste des Services Complets --}}
            <div style="margin-top: 80px; text-align: center;">
                <h3 class="design-bosse-label" style="font-size: 22px; margin-bottom: 40px; color: #333;">{{ $tr('LISTE DES SERVICES COMPLETS') }}</h3>
            </div>
            
            <div class="web-services-grid">
                {{-- Blogs --}}
                <div class="web-service-card blog">
                    <span class="tech-badge">SEO-BOOST</span>
                    <i class="fas fa-blog"></i>
                    <h4>{{ $tr('BLOGS') }}</h4>
                    <p>{{ $tr('Créez et gérez un blog professionnel avec éditeur visuel et optimisation SEO.') }}</p>
                </div>
                {{-- Formulaires --}}
                <div class="web-service-card forms">
                    <span class="tech-badge">CRM-SYNC</span>
                    <i class="fas fa-file-signature"></i>
                    <h4>{{ $tr('BUILDER FORMULAIRES') }}</h4>
                    <p>{{ $tr('Concevez des formulaires avancés avec validation et intégration CRM.') }}</p>
                </div>
                {{-- CTA IA --}}
                <div class="web-service-card cta">
                    <span class="tech-badge">AI-DRIVEN</span>
                    <i class="fas fa-robot"></i>
                    <h4>{{ $tr('CALL-TO-ACTION IA') }}</h4>
                    <p>{{ $tr('Générez automatiquement des boutons optimisés selon le comportement des visiteurs.') }}</p>
                </div>
                {{-- SEO --}}
                <div class="web-service-card seo">
                    <span class="tech-badge">GLOBAL</span>
                    <i class="fas fa-chart-line"></i>
                    <h4>{{ $tr('PERFORMANCES SEO') }}</h4>
                    <p>{{ $tr('Optimisez votre site pour le SEO international avec suivi en temps réel.') }}</p>
                </div>
                {{-- Télémarketing --}}
                <div class="web-service-card phone">
                    <span class="tech-badge">DYNAMIC</span>
                    <i class="fas fa-phone-alt"></i>
                    <h4>{{ $tr('TÉLÉ-MARKETING') }}</h4>
                    <p>{{ $tr('Outils de télémarketing intégrés avec gestion des contacts et suivi.') }}</p>
                </div>
                {{-- Multilingue --}}
                <div class="web-service-card lang">
                    <span class="tech-badge">25 LANGUES</span>
                    <i class="fas fa-language"></i>
                    <h4>{{ $tr('SITE MULTILINGUES') }}</h4>
                    <p>{{ $tr('Traduction automatique et gestion de contenu pour une audience globale.') }}</p>
                </div>
                {{-- Vidéos Carte --}}
                <div class="web-service-card video">
                    <span class="tech-badge">G-MAPS+</span>
                    <i class="fas fa-video"></i>
                    <h4>{{ $tr('VIDÉOS CARTE') }}</h4>
                    <p>{{ $tr('Intégration de vidéos et positionnement sur Google Maps avec fiches.') }}</p>
                </div>
                {{-- API/CRM --}}
                <div class="web-service-card api">
                    <span class="tech-badge">CLOUD</span>
                    <i class="fas fa-cogs"></i>
                    <h4>{{ $tr('API, CRM, ETC.') }}</h4>
                    <p>{{ $tr('Intégrations API complètes avec les principaux outils de productivité.') }}</p>
                </div>
            </div>

            {{-- CTA Final --}}
            <div class="ws-cta-final">
                <h2 class="ws-cta-title">{{ $tr('PRÊT À TRANSFORMER VOTRE PRÉSENCE EN LIGNE ?') }}</h2>
                <p class="ws-cta-desc">
                    {{ $tr('Rejoignez des centaines d\'entreprises qui ont déjà augmenté leur visibilité et leurs résultats avec nos solutions web innovantes.') }}
                </p>
                <a href="#" class="ws-cta-btn">{{ $tr('INSCRIVEZ-VOUS MAINTENANT') }} <i class="fas fa-arrow-right"></i></a>
            </div>

    </div>{{-- /ws-container --}}
</section>
