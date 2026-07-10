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
                        <img loading="lazy" decoding="async" src="{{ asset('logo.png') }}" alt="GoExploria Mail">
                    </div>
                    <span class="resto-accord-btn-label">Mail Studio</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-external-link-alt"></i> Visiter</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('ESPACE MAIL MARKETING') }}</h1>
                <p class="resto-header-subtitle">{{ $tr('Concevez des campagnes qui convertissent: segmentation intelligente, design responsive et analytics en temps reel.') }}</p></div>
            
            <div class="resto-header-logo-right">
                
                <a href="{{url('page-mail-marketing')}}" title="En savoir plus" target="_blank" rel="noopener noreferrer">
                    <!-- <i class="fas fa-circle-info"></i>
                    <span>Go Next Level</span> -->
                    <img
                    class="bt-next-level-image"
                    src="{{ asset('images/Next-level.png') }}"
                    alt="Next Level"
                    loading="lazy"
                >
                </a>
            </div>
        </div>
        
            @include('welcome-home.components.SectionNavbarEspaceMedia')
        <div class="resto-header-destinations-bar">
            <div class="resto-dest-row">
    <div class="resto-dest-icon-box">
        <img loading="lazy" decoding="async" src="{{ asset('REDI.png') }}" alt="Destinations">
        <span>Destinations</span>
    </div>

    <div class="resto-dest-breadcrumb vp-dest-breadcrumb">
        <select id="vp-continent-select" class="vp-dest-select" aria-label="Continent">
            <option value="amerique-nord">Amérique du Nord</option>
            <option value="europe">Europe</option>
            <option value="afrique">Afrique</option>
            <option value="asie">Asie</option>
            <option value="amerique-sud">Amérique du Sud</option>
            <option value="oceanie">Océanie</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-country-select" class="vp-dest-select" aria-label="Pays">
            <option value="canada">Canada</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-province-select" class="vp-dest-select" aria-label="Province">
            <option value="quebec">Québec</option>
            <option value="ontario">Ontario</option>
            <option value="alberta">Alberta</option>
            <option value="colombie-britannique">Colombie-Britannique</option>
            <option value="nouvelle-ecosse">Nouvelle-Écosse</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-region-select" class="vp-dest-select" aria-label="Région">
            <option value="region-de-quebec">Région de Québec</option>
            <option value="montreal-metro">Montréal Métro</option>
            <option value="mauricie">Mauricie</option>
            <option value="gaspesie">Gaspésie</option>
            <option value="saguenay">Saguenay</option>
        </select>
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
                <img loading="lazy" decoding="async" src="{{asset('images/mail-ecommerce.png')}}" alt="Campagne tourisme">
                <div class="mail-campaign-body">
                    <div class="mail-campaign-head">
                        <span class="mail-campaign-badge"><i class="fas fa-cart-shopping"></i> E-commerce</span>
                        <h3>Email Marketing E-commerce</h3>
                        <p>Relance panier abandonne, recommandations produit et sequence post-achat pour augmenter la valeur vie client.</p>
                    </div>
                    <ul class="mail-feature-list">
                        <li><i class="fas fa-repeat"></i> Workflow de relance en 3 emails</li>
                        <li><i class="fas fa-percent"></i> Offres code promo dynamique</li>
                        <li><i class="fas fa-chart-line"></i> Conversion moyenne +18.6%</li>
                    </ul>
                </div>
            </article>
            <article class="mail-campaign-card" data-campaign-type="business">
                <img loading="lazy" decoding="async" src="{{asset('images/mail-business.png')}}" alt="Campagne business B2B">
                <div class="mail-campaign-body">
                    <div class="mail-campaign-head">
                        <span class="mail-campaign-badge"><i class="fas fa-briefcase"></i> Business</span>
                        <h3>Email Marketing Business</h3>
                        <p>Nurturing B2B pour qualifier vos leads: sequence webinar, etude de cas et prise de rendez-vous commerciale.</p>
                    </div>
                    <ul class="mail-feature-list">
                        <li><i class="fas fa-user-check"></i> Score leads automatique</li>
                        <li><i class="fas fa-calendar-check"></i> CTA prise de rendez-vous CRM</li>
                        <li><i class="fas fa-bullseye"></i> SQL generees +27%</li>
                    </ul>
                </div>
            </article>
            <article class="mail-campaign-card" data-campaign-type="tourisme">
                <img loading="lazy" decoding="async" src="{{asset('images/mail-tourism.png')}}" alt="Campagne ecommerce">
                <div class="mail-campaign-body">
                    <div class="mail-campaign-head">
                        <span class="mail-campaign-badge"><i class="fas fa-plane-departure"></i> Tourism</span>
                        <h3>Email Marketing Tourism</h3>
                        <p>Campagnes inspiration destination, alertes forfaits et guides saisonniers pour augmenter les reservations.</p>
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
