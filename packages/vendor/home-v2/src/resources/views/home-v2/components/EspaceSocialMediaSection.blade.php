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

<section class="social-space-section" id="reseaux-sociaux">
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="Social Hub">
                    <div class="logo-wrapper">
                        <i class="fas fa-hashtag"></i>
                    </div>
                    <span class="resto-accord-btn-label">Social Hub</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-bolt"></i> Live</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('ESPACES RÉSEAUX SOCIAUX') }}</h1>
                <p class="resto-header-subtitle">{{ $tr('Nous gérons vos réseaux sociaux de manière stratégique: contenu, community management, campagnes, social ads et croissance de votre audience.') }}</p>
                <div class="resto-header-tabs">
                    <button class="resto-tab-btn active">{{ $tr('Gestion complète') }}</button>
                    <button class="resto-tab-btn">{{ $tr('Création de contenu') }}</button>
                    <button class="resto-tab-btn">{{ $tr('Publicité sociale') }}</button>
                </div>
            </div>
            <div class="resto-header-logo-right">
                <a href="#" class="resto-accord-btn" title="Performance sociale">
                    <div class="logo-wrapper">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span class="resto-accord-btn-label">Social Performance</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-arrow-trend-up"></i> Growth</span>
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
        <div class="resto-header-shimmer"></div>
    </div>

    <div class="social-space-container">
        <div class="social-intro-card">
            <h3>{{ $tr('Un service social media 360° pour votre marque') }}</h3>
            <p>{{ $tr('De la stratégie éditoriale jusqu’au reporting mensuel, notre équipe pilote votre présence digitale sur les réseaux les plus performants pour votre marché. Nous publions régulièrement, modérons les interactions, optimisons vos campagnes et transformons votre audience en communauté engagée.') }}</p>
        </div>

        <div class="social-icons-grid">
            <div class="social-icon-card pinterest"><i class="fab fa-pinterest-p"></i><span>Pinterest</span></div>
            <div class="social-icon-card instagram"><i class="fab fa-instagram"></i><span>Instagram</span></div>
            <div class="social-icon-card facebook"><i class="fab fa-facebook-f"></i><span>Facebook</span></div>
            <div class="social-icon-card tiktok"><i class="fab fa-tiktok"></i><span>TikTok</span></div>
            <div class="social-icon-card linkedin"><i class="fab fa-linkedin-in"></i><span>LinkedIn</span></div>
            <div class="social-icon-card twitch"><i class="fab fa-twitch"></i><span>Twitch</span></div>
            <div class="social-icon-card snapchat"><i class="fab fa-snapchat-ghost"></i><span>Snapchat</span></div>
            <div class="social-icon-card youtube"><i class="fab fa-youtube"></i><span>YouTube</span></div>
        </div>

        <div class="social-services-grid">
            <article class="social-service-item">
                <h4><i class="fas fa-pen-nib"></i> {{ $tr('Stratégie & contenu') }}</h4>
                <p>{{ $tr('Calendrier éditorial, storytelling de marque, scripts reels, hooks performants et planification multi-plateformes.') }}</p>
            </article>
            <article class="social-service-item">
                <h4><i class="fas fa-comments"></i> {{ $tr('Community management') }}</h4>
                <p>{{ $tr('Réponses aux commentaires/messages, gestion de réputation, animation de communauté et protocole de modération.') }}</p>
            </article>
            <article class="social-service-item">
                <h4><i class="fas fa-bullhorn"></i> {{ $tr('Campagnes & social ads') }}</h4>
                <p>{{ $tr('Création de campagnes Meta, LinkedIn et TikTok Ads avec ciblage intelligent, tests A/B et optimisation du budget.') }}</p>
            </article>
            <article class="social-service-item">
                <h4><i class="fas fa-chart-pie"></i> {{ $tr('Analyse & performance') }}</h4>
                <p>{{ $tr('KPIs hebdomadaires, dashboards clairs, recommandations d’optimisation continue et suivi de conversion.') }}</p>
            </article>
        </div>
    </div>
</section>
