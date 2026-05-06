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

<section class="mail-space-section" id="espace-mail-marketing">
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="GoExploria Mail">
                    <div class="logo-wrapper">
                        <img src="{{ asset('logo.png') }}" alt="GoExploria Mail">
                    </div>
                    <span class="resto-accord-btn-label">Mail Studio</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-external-link-alt"></i> Visiter</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('ESPACE MAIL MARKETING') }}</h1>
                <p class="resto-header-subtitle">{{ $tr('Concevez des campagnes qui convertissent: segmentation intelligente, design responsive et analytics en temps reel.') }}</p>
                <div class="resto-header-tabs">
                    <button class="resto-tab-btn active" data-campaign-target="all">{{ $tr('Tous') }}</button>
                    <button class="resto-tab-btn" data-campaign-target="tourisme">{{ $tr('Tourisme') }}</button>
                    <button class="resto-tab-btn" data-campaign-target="business">Business</button>
                    <button class="resto-tab-btn" data-campaign-target="ecommerce">E-commerce</button>
                </div>
            </div>
            <div class="resto-header-logo-right">
                <a href="#" class="resto-accord-btn" title="Automatisation">
                    <div class="logo-wrapper">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=200&h=200&fit=crop" alt="Automatisation marketing">
                    </div>
                    <span class="resto-accord-btn-label">Automation</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-paper-plane"></i> Live</span>
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

    <div class="mail-space-container">
        <div class="mail-performance">
            <div class="mail-metric"><span>Ouverture</span><strong>42.7%</strong></div>
            <div class="mail-metric"><span>Clic</span><strong>12.4%</strong></div>
            <div class="mail-metric"><span>Conversion</span><strong>6.9%</strong></div>
        </div>

        <div class="mail-campaign-grid" id="mailCampaignGrid">
            <article class="mail-campaign-card" data-campaign-type="ecommerce">
                <img src="{{asset('images/mail-ecommerce.png')}}" alt="Campagne tourisme">
                <div class="mail-campaign-body">
                    <div class="mail-campaign-head">
                        <span class="mail-campaign-badge"><i class="fas fa-cart-shopping"></i> E-commerce</span>
                        <h3>Email Marketing E-commerce</h3>
                        <p>Relance panier abandonne, recommandations produit et sequence post-achat pour augmenter la valeur vie client.</p>
                    </div>
                    <div class="mail-svg-widget" aria-hidden="true">
                        <svg viewBox="0 0 320 80" xmlns="http://www.w3.org/2000/svg">
                            <polyline points="10,62 55,50 95,54 140,35 188,40 235,20 280,24 310,12" fill="none" stroke="#2d7ff9" stroke-width="4" stroke-linecap="round"/>
                            <circle cx="235" cy="20" r="6" fill="#2d7ff9"/>
                            <circle cx="310" cy="12" r="6" fill="#1fb981"/>
                        </svg>
                    </div>
                    <ul class="mail-feature-list">
                        <li><i class="fas fa-repeat"></i> Workflow de relance en 3 emails</li>
                        <li><i class="fas fa-percent"></i> Offres code promo dynamique</li>
                        <li><i class="fas fa-chart-line"></i> Conversion moyenne +18.6%</li>
                    </ul>
                </div>
            </article>
            <article class="mail-campaign-card" data-campaign-type="business">
                <img src="{{asset('images/mail-business.png')}}" alt="Campagne business B2B">
                <div class="mail-campaign-body">
                    <div class="mail-campaign-head">
                        <span class="mail-campaign-badge"><i class="fas fa-briefcase"></i> Business</span>
                        <h3>Email Marketing Business</h3>
                        <p>Nurturing B2B pour qualifier vos leads: sequence webinar, etude de cas et prise de rendez-vous commerciale.</p>
                    </div>
                    <div class="mail-svg-widget" aria-hidden="true">
                        <svg viewBox="0 0 320 80" xmlns="http://www.w3.org/2000/svg">
                            <rect x="20" y="48" width="28" height="18" rx="4" fill="#87b7ff"/>
                            <rect x="70" y="40" width="28" height="26" rx="4" fill="#6da4ff"/>
                            <rect x="120" y="30" width="28" height="36" rx="4" fill="#4f90ff"/>
                            <rect x="170" y="22" width="28" height="44" rx="4" fill="#2d7ff9"/>
                            <rect x="220" y="14" width="28" height="52" rx="4" fill="#1f6ae0"/>
                            <rect x="270" y="8" width="28" height="58" rx="4" fill="#1153c1"/>
                        </svg>
                    </div>
                    <ul class="mail-feature-list">
                        <li><i class="fas fa-user-check"></i> Score leads automatique</li>
                        <li><i class="fas fa-calendar-check"></i> CTA prise de rendez-vous CRM</li>
                        <li><i class="fas fa-bullseye"></i> SQL generees +27%</li>
                    </ul>
                </div>
            </article>
            <article class="mail-campaign-card" data-campaign-type="tourisme">
                <img src="{{asset('images/mail-tourism.png')}}" alt="Campagne ecommerce">
                <div class="mail-campaign-body">
                    <div class="mail-campaign-head">
                        <span class="mail-campaign-badge"><i class="fas fa-plane-departure"></i> Tourism</span>
                        <h3>Email Marketing Tourism</h3>
                        <p>Campagnes inspiration destination, alertes forfaits et guides saisonniers pour augmenter les reservations.</p>
                    </div>
                    <div class="mail-svg-widget" aria-hidden="true">
                        <svg viewBox="0 0 320 80" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 58 C60 30, 96 50, 140 26 C178 6, 236 18, 306 10" stroke="#1fb981" stroke-width="4" fill="none" stroke-linecap="round"/>
                            <path d="M18 58 L44 58 M84 44 L110 44 M154 30 L180 30 M230 20 L256 20" stroke="#1fb981" stroke-width="4" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <ul class="mail-feature-list">
                        <li><i class="fas fa-map-marked-alt"></i> Segmentation par destination</li>
                        <li><i class="fas fa-clock"></i> Alertes "dernieres places"</li>
                        <li><i class="fas fa-suitcase-rolling"></i> Reservations +21.3%</li>
                    </ul>
                </div>
            </article>
        </div>
    </div>
</section>
