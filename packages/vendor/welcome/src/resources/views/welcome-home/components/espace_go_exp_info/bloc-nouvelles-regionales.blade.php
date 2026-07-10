@php(ob_start());@endphp

{{-- ============================================================
     BLOC — NOUVELLES RÉGIONALES, NATIONALES & INTERNATIONALES
     Info locale · Articles récents par région · Alertes Nouvelles
     Afrique · Europe · Asie · Amériques · et plus
     ============================================================ --}}

@php
    $tr = static function (string $text): string {
        $locale = app()->getLocale();
        if ($locale === 'fr') return $text;
        static $maps = [];
        if (!array_key_exists($locale, $maps)) {
            $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-nouvelles.php');
            $maps[$locale] = is_file($path) ? (require $path) : [];
        }
        return $maps[$locale][$text] ?? $text;
    };

    $regions = [
        [
            'slug'    => 'afrique',
            'label'   => 'Afrique',
            'flag'    => '🌍',
            'color'   => '#e8761a',
            'count'   => '245',
            'accent'  => '#fff3e6',
            'articles' => [
                [
                    'cat'   => 'Économie',
                    'title' => 'Croissance record des économies d\'Afrique de l\'Ouest',
                    'desc'  => 'La CEDEAO annonce une croissance de 6.2% pour le dernier trimestre, dépassant toutes les prévisions des analystes.',
                    'time'  => '3h',
                    'img'   => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=600&q=80',
                ],
                [
                    'cat'   => 'Culture',
                    'title' => 'Le festival Afropop attire 2 millions de visiteurs',
                    'desc'  => 'Un record d\'affluence pour cette édition panafricaine célébrant la musique et l\'art contemporain.',
                    'time'  => '5h',
                    'img'   => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?w=600&q=80',
                ],
            ],
        ],
        [
            'slug'    => 'europe',
            'label'   => 'Europe',
            'flag'    => '🌍',
            'color'   => '#1a3a8f',
            'count'   => '189',
            'accent'  => '#eef1fb',
            'articles' => [
                [
                    'cat'   => 'Politique',
                    'title' => 'Nouvelle politique migratoire de l\'Union Européenne',
                    'desc'  => 'Les membres de l\'UE trouvent un accord sur une approche commune pour la gestion des frontières extérieures.',
                    'time'  => '6h',
                    'img'   => 'https://images.unsplash.com/photo-1526628953301-3e589a6a8b74?w=600&q=80',
                ],
                [
                    'cat'   => 'Économie',
                    'title' => 'La BCE maintient ses taux directeurs stables',
                    'desc'  => 'Face aux incertitudes mondiales, la Banque Centrale Européenne choisit la prudence pour le second semestre.',
                    'time'  => '9h',
                    'img'   => 'https://images.unsplash.com/photo-1467803738586-46b7eb7b16a1?w=600&q=80',
                ],
            ],
        ],
        [
            'slug'    => 'asie',
            'label'   => 'Asie',
            'flag'    => '🌏',
            'color'   => '#10b981',
            'count'   => '312',
            'accent'  => '#edfaf5',
            'articles' => [
                [
                    'cat'   => 'Innovation',
                    'title' => 'Le Japon lance son plus grand satellite d\'observation',
                    'desc'  => 'Une avancée majeure pour la surveillance climatique et la prévention des catastrophes naturelles en Asie-Pacifique.',
                    'time'  => '8h',
                    'img'   => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w=600&q=80',
                ],
                [
                    'cat'   => 'Tech',
                    'title' => 'Corée du Sud : boom de l\'intelligence artificielle',
                    'desc'  => 'Seoul devient le nouveau hub mondial de l\'IA avec 40 milliards d\'investissements annoncés pour 2026.',
                    'time'  => '11h',
                    'img'   => 'https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?w=600&q=80',
                ],
            ],
        ],
        [
            'slug'    => 'ameriques',
            'label'   => 'Amériques',
            'flag'    => '🌎',
            'color'   => '#8b5cf6',
            'count'   => '278',
            'accent'  => '#f5f0ff',
            'articles' => [
                [
                    'cat'   => 'Politique',
                    'title' => 'Sommet des Amériques : accord historique sur le climat',
                    'desc'  => 'Les 35 nations membres signent un engagement commun pour réduire de 45% leurs émissions d\'ici 2035.',
                    'time'  => '2h',
                    'img'   => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=600&q=80',
                ],
                [
                    'cat'   => 'Économie',
                    'title' => 'Le Brésil dépasse le Canada comme 9e économie mondiale',
                    'desc'  => 'Une progression portée par les exportations agricoles et la montée en puissance du secteur technologique brésilien.',
                    'time'  => '14h',
                    'img'   => 'https://images.unsplash.com/photo-1483729558449-99ef09a8c325?w=600&q=80',
                ],
            ],
        ],
    ];
@endphp

<section class="nv-section" id="nv-nouvelles">

    {{-- ============================================================
         ENTÊTE STANDARD
         ============================================================ --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="GoExploria">
                    <div class="logo-wrapper">
                        <img loading="lazy" decoding="async" src="{{ asset('logo.png') }}" alt="GoExploria">
                    </div>
                    <span class="resto-accord-btn-label">GoExploria</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-external-link-alt"></i> Visiter</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('NOUVELLES RÉGIONALES, NATIONALES & INTERNATIONALES') }}</h1>
                <h2 class="resto-header-eyebrow">{{ $tr('Info locale & régionale · Articles récents par région · Alertes Nouvelles') }}</h2>
                <p class="resto-header-subtitle">{{ $tr('Restez informé en temps réel avec les actualités les plus récentes par région — Afrique · Europe · Asie · Amériques. Inscrivez-vous aux Alertes Nouvelles régionales.') }}</p>
            </div>
            
            <div class="resto-header-logo-right">
                
                <a href="" title="En savoir plus" target="_blank" rel="noopener noreferrer">
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

        {{-- Barre destinations --}}
        <div class="resto-header-destinations-bar">
            <div class="resto-dest-row">
                <div class="resto-dest-icon-box">
                    <img loading="lazy" decoding="async" src="{{ asset('REDI.png') }}" alt="Destinations">
                    <span>Destinations</span>
                </div>
                <div class="resto-dest-breadcrumb vp-dest-breadcrumb">
                    <select id="nv-continent-select" class="vp-dest-select" aria-label="Continent">
                        <option value="amerique-nord">Amérique du Nord</option>
                        <option value="europe">Europe</option>
                        <option value="afrique">Afrique</option>
                        <option value="asie">Asie</option>
                        <option value="amerique-sud">Amérique du Sud</option>
                        <option value="oceanie">Océanie</option>
                    </select>
                    <span class="resto-dest-sep">/</span>
                    <select id="nv-country-select" class="vp-dest-select" aria-label="Pays">
                        <option value="canada">Canada</option>
                    </select>
                    <span class="resto-dest-sep">/</span>
                    <select id="nv-province-select" class="vp-dest-select" aria-label="Province">
                        <option value="quebec">Québec</option>
                        <option value="ontario">Ontario</option>
                        <option value="alberta">Alberta</option>
                        <option value="colombie-britannique">Colombie-Britannique</option>
                        <option value="nouvelle-ecosse">Nouvelle-Écosse</option>
                    </select>
                    <span class="resto-dest-sep">/</span>
                    <select id="nv-region-select" class="vp-dest-select" aria-label="Région">
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

    {{-- ============================================================
         CORPS PRINCIPAL
         ============================================================ --}}
    <div class="nv-body">

        {{-- ── TICKER D'ALERTES LIVE ── --}}
        <div class="nv-ticker">
            <div class="nv-ticker-label"><i class="fas fa-circle"></i> {{ $tr('LIVE') }}</div>
            <div class="nv-ticker-track">
                <div class="nv-ticker-inner">
                    <span>🌍 Afrique : Nouveau sommet de l'UA convoqué à Addis-Abeba</span>
                    <span>🌍 Europe : La Commission européenne présente son plan énergie 2030</span>
                    <span>🌏 Asie : Tokyo enregistre sa plus forte hausse boursière de l'année</span>
                    <span>🌎 Amériques : Le G7 se réunit à Ottawa pour la sécurité alimentaire</span>
                    <span>🇨🇦 Canada : Québec annonce 3,2 Md$ pour l'infrastructure régionale</span>
                    <span>🌍 Afrique : Nouveau sommet de l'UA convoqué à Addis-Abeba</span>
                    <span>🌍 Europe : La Commission européenne présente son plan énergie 2030</span>
                    <span>🌏 Asie : Tokyo enregistre sa plus forte hausse boursière de l'année</span>
                </div>
            </div>
        </div>

        {{-- ── HERO : ARTICLE VEDETTE ── --}}
        <div class="nv-hero">
            <div class="nv-hero-featured">
                <div class="nv-hero-img-wrap">
                    <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=1200&q=80"
                         alt="Article vedette" class="nv-hero-img">
                    <div class="nv-hero-overlay">
                        <span class="nv-hero-badge"><i class="fas fa-fire"></i> {{ $tr('À la une') }}</span>
                        <div class="nv-hero-regions">
                            <span class="nv-region-pill" style="background:#e8761a">🌍 {{ $tr('Mondial') }}</span>
                            <span class="nv-region-pill" style="background:#1a3a8f">{{ $tr('International') }}</span>
                        </div>
                        <h2 class="nv-hero-title">{{ $tr('Conférence mondiale sur le climat : 150 nations s\'engagent pour la neutralité carbone') }}</h2>
                        <p class="nv-hero-desc">{{ $tr('Un accord historique signé à Genève réunit les principales puissances mondiales autour d\'objectifs contraignants de réduction des émissions pour 2030 et 2050.') }}</p>
                        <div class="nv-hero-meta">
                            <span><i class="far fa-clock"></i> {{ $tr('Il y a 1 heure') }}</span>
                            <span><i class="far fa-eye"></i> 48 200 {{ $tr('lectures') }}</span>
                            <a href="{{ url('nouvelles/article/conference-mondiale-climat') }}" class="nv-hero-read-btn" target="_blank">
                                {{ $tr('Lire l\'article') }} <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar mini-articles --}}
            <div class="nv-hero-sidebar">
                <div class="nv-sidebar-label">
                    <i class="fas fa-bolt"></i> {{ $tr('Dernière heure') }}
                </div>
                @foreach([
                    ['time'=>'12 min', 'cat'=>'Afrique',   'title'=>'Le Ghana inaugure son plus grand parc solaire d\'Afrique subsaharienne'],
                    ['time'=>'34 min', 'cat'=>'Europe',    'title'=>'La France et l\'Allemagne signent un nouveau pacte de défense commune'],
                    ['time'=>'51 min', 'cat'=>'Asie',      'title'=>'L\'Inde franchit le cap des 1,5 milliard d\'habitants connectés'],
                    ['time'=>'1h 12', 'cat'=>'Amériques',  'title'=>'Mexique : découverte archéologique majeure dans le Yucatán'],
                    ['time'=>'1h 45', 'cat'=>'Canada',     'title'=>'Montréal classée 3e ville la plus connectée d\'Amérique du Nord'],
                ] as $mini)
                <a href="#" class="nv-mini-article">
                    <div class="nv-mini-meta">
                        <span class="nv-mini-time"><i class="far fa-clock"></i> {{ $mini['time'] }}</span>
                        <span class="nv-mini-cat">{{ $mini['cat'] }}</span>
                    </div>
                    <p class="nv-mini-title">{{ $tr($mini['title']) }}</p>
                </a>
                @endforeach
            </div>
        </div>

        {{-- ── ONGLETS RÉGIONS ── --}}
        <div class="nv-regions-block" id="nv-regions">
            <div class="nv-block-header">
                <div>
                    <span class="nv-eyebrow"><i class="fas fa-globe-americas"></i> {{ $tr('Par région') }}</span>
                    <h3 class="nv-block-title">{{ $tr('Actualités ') }}<span class="nv-grad-text">{{ $tr('par région du monde') }}</span></h3>
                </div>
                <a href="{{ url('nouvelles') }}" class="nv-see-all" target="_blank">
                    {{ $tr('Toutes les nouvelles') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            {{-- Tabs --}}
            <div class="nv-tabs" role="tablist">
                @foreach($regions as $i => $r)
                <button class="nv-tab {{ $i === 0 ? 'active' : '' }}"
                        data-tab="nv-tab-{{ $r['slug'] }}"
                        style="--tab-color:{{ $r['color'] }}"
                        role="tab"
                        aria-selected="{{ $i === 0 ? 'true' : 'false' }}">
                    <span class="nv-tab-flag">{{ $r['flag'] }}</span>
                    {{ $tr($r['label']) }}
                    <span class="nv-tab-count" style="background:{{ $r['color'] }}20;color:{{ $r['color'] }}">{{ $r['count'] }}</span>
                </button>
                @endforeach
            </div>

            {{-- Tab panels --}}
            @foreach($regions as $i => $r)
            <div class="nv-tab-panel {{ $i === 0 ? 'active' : '' }}" id="nv-tab-{{ $r['slug'] }}" role="tabpanel">
                <div class="nv-articles-grid">
                    @foreach($r['articles'] as $art)
                    <div class="nv-article-card">
                        <div class="nv-article-img-wrap">
                            <img src="{{ $art['img'] }}" alt="{{ $art['title'] }}" class="nv-article-img" loading="lazy">
                            <span class="nv-article-region-badge" style="background:{{ $r['color'] }}">{{ $tr($r['label']) }}</span>
                        </div>
                        <div class="nv-article-body">
                            <span class="nv-article-cat" style="color:{{ $r['color'] }}">{{ $tr($art['cat']) }}</span>
                            <h4 class="nv-article-title">{{ $tr($art['title']) }}</h4>
                            <p class="nv-article-desc">{{ $tr($art['desc']) }}</p>
                            <div class="nv-article-footer">
                                <span class="nv-article-time"><i class="far fa-clock"></i> {{ $tr('Il y a') }} {{ $art['time'] }}</span>
                                <a href="#" class="nv-article-read" style="color:{{ $r['color'] }}">
                                    {{ $tr('Lire') }} <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    {{-- Carte "Explorer plus" --}}
                    <div class="nv-article-card nv-explore-more" style="background:{{ $r['accent'] }};border-color:{{ $r['color'] }}30">
                        <div class="nv-explore-icon" style="color:{{ $r['color'] }}">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h4 style="color:{{ $r['color'] }}">{{ $tr('Explorer') }} {{ $tr($r['label']) }}</h4>
                        <p>{{ $r['count'] }} {{ $tr('nouvelles aujourd\'hui') }}</p>
                        <a href="{{ url('nouvelles/' . $r['slug']) }}" class="nv-explore-btn" style="background:{{ $r['color'] }}" target="_blank">
                            <i class="fas fa-newspaper"></i> {{ $tr('Voir tout') }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- ── CARTE RÉGIONS RAPIDE ── --}}
        <div class="nv-quick-regions">
            <div class="nv-block-header" style="margin-bottom:24px">
                <span class="nv-eyebrow"><i class="fas fa-map-marked-alt"></i> {{ $tr('Couverture mondiale') }}</span>
            </div>
            <div class="nv-quick-grid">
                @foreach([
                    ['flag'=>'🌍','label'=>'Afrique',          'color'=>'#e8761a','count'=>'245','slug'=>'afrique'],
                    ['flag'=>'🌍','label'=>'Europe',            'color'=>'#1a3a8f','count'=>'189','slug'=>'europe'],
                    ['flag'=>'🌏','label'=>'Asie',              'color'=>'#10b981','count'=>'312','slug'=>'asie'],
                    ['flag'=>'🌎','label'=>'Amériques',         'color'=>'#8b5cf6','count'=>'278','slug'=>'ameriques'],
                    ['flag'=>'🇨🇦','label'=>'Canada',           'color'=>'#ef4444','count'=>'134','slug'=>'canada'],
                    ['flag'=>'🌐','label'=>'International',     'color'=>'#f59e0b','count'=>'421','slug'=>'international'],
                ] as $q)
                <a href="{{ url('nouvelles/' . $q['slug']) }}" class="nv-quick-card" style="--qc:{{ $q['color'] }}" target="_blank">
                    <span class="nv-quick-flag">{{ $q['flag'] }}</span>
                    <span class="nv-quick-label">{{ $tr($q['label']) }}</span>
                    <span class="nv-quick-count" style="color:{{ $q['color'] }}">{{ $q['count'] }} {{ $tr('nouvelles') }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- ── ALERTES NOUVELLES — INSCRIPTION ── --}}
        <div class="nv-alerts-block" id="nv-alertes">
            <div class="nv-alerts-left">
                <div class="nv-alerts-badge"><i class="fas fa-bell"></i> {{ $tr('Alertes Nouvelles') }}</div>
                <h3>{{ $tr('Recevez les nouvelles') }}<br><em>{{ $tr('régionales en temps réel') }}</em></h3>
                <p>{{ $tr('Inscrivez-vous et recevez instantanément les alertes nouvelles régionales, nationales et internationales qui vous concernent, directement dans votre boîte mail.') }}</p>
                <ul class="nv-alerts-features">
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Alertes personnalisées par région') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Notification instantanée') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Résumé quotidien') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Sans publicité') }}</li>
                </ul>
            </div>
            <div class="nv-alerts-right">
                <form class="nv-alert-form" id="nvAlertForm">
                    <div class="nv-form-group">
                        <label>{{ $tr('Votre adresse courriel') }}</label>
                        <input type="email" placeholder="votre@courriel.com" required>
                    </div>
                    <div class="nv-form-group">
                        <label>{{ $tr('Choisissez vos régions d\'intérêt') }}</label>
                        <div class="nv-region-checkboxes">
                            @foreach([
                                ['slug'=>'afrique',      'label'=>'🌍 Afrique',      'color'=>'#e8761a'],
                                ['slug'=>'europe',       'label'=>'🌍 Europe',        'color'=>'#1a3a8f'],
                                ['slug'=>'asie',         'label'=>'🌏 Asie',          'color'=>'#10b981'],
                                ['slug'=>'ameriques',    'label'=>'🌎 Amériques',     'color'=>'#8b5cf6'],
                                ['slug'=>'canada',       'label'=>'🇨🇦 Canada',       'color'=>'#ef4444'],
                                ['slug'=>'international','label'=>'🌐 International', 'color'=>'#f59e0b'],
                            ] as $ck)
                            <label class="nv-checkbox-label">
                                <input type="checkbox" name="regions[]" value="{{ $ck['slug'] }}">
                                <span class="nv-checkbox-pill" style="--cc:{{ $ck['color'] }}">{{ $ck['label'] }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="nv-form-group">
                        <label>{{ $tr('Fréquence des alertes') }}</label>
                        <select>
                            <option value="instant">{{ $tr('Instantané (breaking news)') }}</option>
                            <option value="daily">{{ $tr('Résumé quotidien') }}</option>
                            <option value="weekly">{{ $tr('Hebdomadaire') }}</option>
                        </select>
                    </div>
                    <button type="submit" class="nv-btn-submit">
                        <i class="fas fa-bell"></i> {{ $tr('M\'inscrire aux alertes') }}
                    </button>
                    <p class="nv-form-note">{{ $tr('Gratuit · Désabonnement en 1 clic · RGPD conforme') }}</p>
                </form>
            </div>
        </div>

        {{-- ── CTA FINAL ── --}}
        <div class="nv-cta">
            <div class="nv-cta-content">
                <i class="fas fa-newspaper"></i>
                <h3>{{ $tr('Explorez toute l\'actualité mondiale') }}</h3>
                <p>{{ $tr('Des milliers d\'articles mis à jour chaque heure, organisés par région, pays et thématique.') }}</p>
            </div>
            <div class="nv-cta-buttons">
                <a href="{{ url('nouvelles') }}" class="nv-cta-primary" target="_blank">
                    <i class="fas fa-globe"></i> {{ $tr('Toutes les nouvelles') }}
                </a>
                <a href="#nv-alertes" class="nv-cta-secondary">
                    <i class="fas fa-bell"></i> {{ $tr('Alertes gratuites') }}
                </a>
            </div>
        </div>

    </div>{{-- /nv-body --}}
</section>

{{-- ╔══════════════════════════════════════════
    STYLES
══════════════════════════════════════════╗ --}}
<style>
/* ── Variables ── */
:root {
    --nv-blue:   #1a3a8f;
    --nv-orange: #e8761a;
    --nv-green:  #10b981;
    --nv-purple: #8b5cf6;
    --nv-dark:   #0d1f3c;
    --nv-light:  #f8faff;
    --nv-border: #e5e7eb;
}

.nv-section { background: linear-gradient(180deg,#f8faff 0%,#fff 100%); }
.nv-body    { padding: 0 40px 60px; }

/* ── Gradient text ── */
.nv-grad-text {
    background: linear-gradient(135deg, var(--nv-orange), #f59e0b);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

/* ── Eyebrow / block header ── */
.nv-eyebrow {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px;
    color: var(--nv-orange); background: #fef3ea;
    padding: 5px 14px; border-radius: 999px; margin-bottom: 10px;
}
.nv-block-header {
    display: flex; justify-content: space-between; align-items: flex-end;
    margin-bottom: 28px; flex-wrap: wrap; gap: 12px;
}
.nv-block-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 26px; color: #1a1a1a; margin: 0;
}
.nv-see-all {
    font-size: 13px; font-weight: 700; color: var(--nv-orange);
    text-decoration: none; display: flex; align-items: center; gap: 6px; white-space: nowrap;
}
.nv-see-all:hover { text-decoration: underline; }

/* ══════════════════════════
   TICKER
══════════════════════════ */
.nv-ticker {
    background: var(--nv-dark); border-radius: 10px; padding: 0;
    display: flex; align-items: stretch; margin: 20px 0 32px;
    overflow: hidden; height: 40px;
}
.nv-ticker-label {
    background: var(--nv-orange); color: #fff; padding: 0 16px;
    font-size: 11px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase;
    display: flex; align-items: center; gap: 6px; flex-shrink: 0;
}
.nv-ticker-label i { font-size: 7px; animation: nvBlink 1.2s infinite; }
@keyframes nvBlink { 0%,100%{opacity:1} 50%{opacity:.1} }
.nv-ticker-track {
    flex: 1; overflow: hidden; display: flex; align-items: center;
}
.nv-ticker-inner {
    display: flex; gap: 60px; white-space: nowrap;
    animation: nvTicker 40s linear infinite; padding-left: 24px;
}
.nv-ticker-inner span { font-size: 13px; color: rgba(255,255,255,.85); flex-shrink: 0; }
@keyframes nvTicker { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }

/* ══════════════════════════
   HERO FEATURED
══════════════════════════ */
.nv-hero {
    display: grid; grid-template-columns: 1fr 340px;
    gap: 24px; margin-bottom: 48px; align-items: stretch;
}
.nv-hero-img-wrap {
    position: relative; border-radius: 20px; overflow: hidden;
    min-height: 380px;
}
.nv-hero-img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform .5s;
}
.nv-hero-img-wrap:hover .nv-hero-img { transform: scale(1.04); }
.nv-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(0deg, rgba(10,22,40,.92) 0%, rgba(10,22,40,.3) 60%, transparent 100%);
    padding: 28px 32px; display: flex; flex-direction: column; justify-content: flex-end;
}
.nv-hero-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--nv-orange); color: #fff;
    font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;
    padding: 4px 12px; border-radius: 6px; margin-bottom: 12px; align-self: flex-start;
}
.nv-hero-regions { display: flex; gap: 8px; margin-bottom: 14px; flex-wrap: wrap; }
.nv-region-pill {
    font-size: 10px; font-weight: 700; color: #fff;
    padding: 3px 10px; border-radius: 999px;
}
.nv-hero-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(20px, 2.2vw, 30px); color: #fff;
    line-height: 1.25; margin-bottom: 12px;
}
.nv-hero-desc { font-size: 14px; color: rgba(255,255,255,.75); line-height: 1.7; margin-bottom: 18px; }
.nv-hero-meta {
    display: flex; align-items: center; gap: 20px; flex-wrap: wrap;
}
.nv-hero-meta span { font-size: 12px; color: rgba(255,255,255,.6); display: flex; align-items: center; gap: 5px; }
.nv-hero-read-btn {
    background: var(--nv-orange); color: #fff; padding: 8px 18px; border-radius: 8px;
    font-size: 13px; font-weight: 700; text-decoration: none;
    display: inline-flex; align-items: center; gap: 7px; transition: background .2s;
    margin-left: auto;
}
.nv-hero-read-btn:hover { background: #c45e0e; color: #fff; }

/* Sidebar */
.nv-hero-sidebar {
    background: #fff; border: 1.5px solid var(--nv-border);
    border-radius: 20px; overflow: hidden; display: flex; flex-direction: column;
}
.nv-sidebar-label {
    background: var(--nv-dark); color: #fff;
    padding: 12px 18px; font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 1px;
    display: flex; align-items: center; gap: 7px;
}
.nv-sidebar-label i { color: var(--nv-orange); }
.nv-mini-article {
    padding: 12px 18px; border-bottom: 1px solid #f0f0f0;
    text-decoration: none; display: block; transition: background .2s;
}
.nv-mini-article:last-child { border-bottom: none; }
.nv-mini-article:hover { background: var(--nv-light); }
.nv-mini-meta { display: flex; align-items: center; gap: 8px; margin-bottom: 5px; }
.nv-mini-time { font-size: 10px; color: #999; display: flex; align-items: center; gap: 4px; }
.nv-mini-cat  { font-size: 9px; font-weight: 700; text-transform: uppercase; color: var(--nv-orange); background: #fef3ea; padding: 2px 7px; border-radius: 4px; }
.nv-mini-title { font-size: 13px; font-weight: 600; color: #1a1a1a; line-height: 1.45; margin: 0; }

/* ══════════════════════════
   ONGLETS RÉGIONS
══════════════════════════ */
.nv-regions-block { margin-bottom: 48px; }
.nv-tabs {
    display: flex; gap: 8px; margin-bottom: 24px;
    border-bottom: 2px solid var(--nv-border); padding-bottom: 0;
    overflow-x: auto; scrollbar-width: none; flex-wrap: nowrap;
}
.nv-tabs::-webkit-scrollbar { display: none; }
.nv-tab {
    display: flex; align-items: center; gap: 7px;
    padding: 10px 20px; border: none; background: transparent;
    font-size: 14px; font-weight: 600; color: #666; cursor: pointer;
    border-bottom: 3px solid transparent; margin-bottom: -2px;
    white-space: nowrap; transition: all .2s; border-radius: 0;
}
.nv-tab:hover { color: var(--tab-color); }
.nv-tab.active { color: var(--tab-color); border-bottom-color: var(--tab-color); }
.nv-tab-flag  { font-size: 16px; }
.nv-tab-count {
    font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 999px;
}

/* Tab panels */
.nv-tab-panel { display: none; }
.nv-tab-panel.active { display: block; }
.nv-articles-grid {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
}
.nv-article-card {
    background: #fff; border: 1.5px solid var(--nv-border);
    border-radius: 18px; overflow: hidden; transition: all .3s;
    display: flex; flex-direction: column;
}
.nv-article-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,.08); border-color: var(--nv-orange); }
.nv-article-img-wrap { position: relative; height: 180px; overflow: hidden; }
.nv-article-img      { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.nv-article-card:hover .nv-article-img { transform: scale(1.06); }
.nv-article-region-badge {
    position: absolute; top: 10px; left: 10px;
    color: #fff; font-size: 9px; font-weight: 800; text-transform: uppercase;
    letter-spacing: .8px; padding: 3px 9px; border-radius: 5px;
}
.nv-article-body { padding: 18px 20px; flex: 1; display: flex; flex-direction: column; }
.nv-article-cat  { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; margin-bottom: 8px; }
.nv-article-title { font-family: 'Playfair Display', Georgia, serif; font-size: 16px; font-weight: 700; color: #1a1a1a; line-height: 1.4; margin-bottom: 10px; }
.nv-article-desc  { font-size: 12px; color: #666; line-height: 1.65; flex: 1; margin-bottom: 14px; }
.nv-article-footer { display: flex; justify-content: space-between; align-items: center; }
.nv-article-time   { font-size: 11px; color: #999; display: flex; align-items: center; gap: 4px; }
.nv-article-read   { font-size: 12px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 4px; }
.nv-article-read:hover { text-decoration: underline; }

/* Explore more card */
.nv-explore-more {
    display: flex !important; flex-direction: column !important;
    align-items: center; justify-content: center; text-align: center;
    padding: 32px 24px; border-width: 2px; border-style: dashed;
}
.nv-explore-icon { font-size: 44px; margin-bottom: 14px; }
.nv-explore-more h4 { font-size: 18px; font-weight: 700; margin-bottom: 8px; }
.nv-explore-more p  { font-size: 13px; color: #888; margin-bottom: 20px; }
.nv-explore-btn {
    color: #fff; padding: 10px 22px; border-radius: 10px;
    font-size: 13px; font-weight: 700; text-decoration: none;
    display: inline-flex; align-items: center; gap: 7px; transition: opacity .2s;
}
.nv-explore-btn:hover { opacity: .88; color: #fff; }

/* ══════════════════════════
   QUICK REGIONS GRID
══════════════════════════ */
.nv-quick-regions { margin-bottom: 48px; }
.nv-quick-grid {
    display: grid; grid-template-columns: repeat(6, 1fr); gap: 14px;
}
.nv-quick-card {
    background: #fff; border: 1.5px solid var(--nv-border);
    border-radius: 14px; padding: 18px 14px; text-decoration: none;
    display: flex; flex-direction: column; align-items: center; text-align: center; gap: 6px;
    transition: all .25s;
    border-top: 3px solid var(--qc, var(--nv-orange));
}
.nv-quick-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,.07); }
.nv-quick-flag  { font-size: 28px; }
.nv-quick-label { font-size: 13px; font-weight: 700; color: #1a1a1a; }
.nv-quick-count { font-size: 11px; font-weight: 600; }

/* ══════════════════════════
   ALERTES INSCRIPTION
══════════════════════════ */
.nv-alerts-block {
    background: linear-gradient(135deg, #0d1f3c, #1a3a8f);
    border-radius: 28px; padding: 56px; margin-bottom: 48px;
    display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start;
}
.nv-alerts-badge {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(232,118,26,.2); border: 1px solid rgba(232,118,26,.35);
    color: #e8761a; padding: 5px 14px; border-radius: 999px;
    font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
    margin-bottom: 18px;
}
.nv-alerts-left h3 {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 28px; color: #fff; line-height: 1.2; margin-bottom: 14px;
}
.nv-alerts-left h3 em { font-style: italic; color: var(--nv-orange); }
.nv-alerts-left p { font-size: 14px; color: rgba(255,255,255,.7); line-height: 1.8; margin-bottom: 22px; }
.nv-alerts-features { list-style: none; display: flex; flex-direction: column; gap: 10px; }
.nv-alerts-features li { font-size: 13px; color: rgba(255,255,255,.8); display: flex; align-items: center; gap: 9px; }
.nv-alerts-features li i { color: var(--nv-green); }

/* Form */
.nv-form-group  { margin-bottom: 16px; }
.nv-form-group label {
    display: block; font-size: 12px; font-weight: 700;
    color: rgba(255,255,255,.8); margin-bottom: 7px;
}
.nv-form-group input,
.nv-form-group select {
    width: 100%; background: rgba(255,255,255,.08);
    border: 1.5px solid rgba(255,255,255,.15);
    border-radius: 10px; padding: 12px 14px;
    font-size: 14px; color: #fff; transition: border-color .2s;
}
.nv-form-group input::placeholder { color: rgba(255,255,255,.4); }
.nv-form-group select option { background: #1a3a8f; color: #fff; }
.nv-form-group input:focus,
.nv-form-group select:focus { outline: none; border-color: var(--nv-orange); }

/* Checkboxes régions */
.nv-region-checkboxes { display: flex; flex-wrap: wrap; gap: 8px; }
.nv-checkbox-label    { cursor: pointer; }
.nv-checkbox-label input { display: none; }
.nv-checkbox-pill {
    display: inline-block; padding: 5px 12px; border-radius: 999px;
    font-size: 12px; font-weight: 600; color: rgba(255,255,255,.7);
    background: rgba(255,255,255,.08); border: 1.5px solid rgba(255,255,255,.15);
    transition: all .2s; cursor: pointer;
}
.nv-checkbox-label input:checked + .nv-checkbox-pill {
    background: var(--cc, var(--nv-orange)); color: #fff;
    border-color: var(--cc, var(--nv-orange));
}
.nv-btn-submit {
    width: 100%; background: linear-gradient(135deg, var(--nv-orange), #c04f10);
    color: #fff; border: none; border-radius: 10px; padding: 14px;
    font-size: 14px; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .2s; margin-top: 6px;
}
.nv-btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(232,118,26,.4); }
.nv-form-note { font-size: 11px; color: rgba(255,255,255,.4); text-align: center; margin-top: 10px; }

/* ══════════════════════════
   CTA FINAL
══════════════════════════ */
.nv-cta {
    background: linear-gradient(135deg, #fef3ea, #fff3e6);
    border-radius: 24px; padding: 40px 48px;
    display: flex; justify-content: space-between; align-items: center;
    gap: 32px; flex-wrap: wrap;
}
.nv-cta-content { display: flex; flex-direction: column; }
.nv-cta-content i  { font-size: 32px; color: var(--nv-orange); margin-bottom: 10px; }
.nv-cta-content h3 { font-size: 22px; color: #1a1a1a; margin-bottom: 6px; }
.nv-cta-content p  { font-size: 14px; color: #666; }
.nv-cta-buttons { display: flex; gap: 12px; flex-wrap: wrap; }
.nv-cta-primary {
    background: var(--nv-orange); color: #fff; padding: 12px 24px;
    border-radius: 10px; font-weight: 700; font-size: 14px; text-decoration: none;
    display: inline-flex; align-items: center; gap: 7px; transition: all .2s;
}
.nv-cta-primary:hover { background: #c45e0e; transform: translateY(-2px); color: #fff; }
.nv-cta-secondary {
    border: 2px solid var(--nv-orange); color: var(--nv-orange); padding: 12px 24px;
    border-radius: 10px; font-weight: 700; font-size: 14px; text-decoration: none;
    display: inline-flex; align-items: center; gap: 7px; transition: all .2s;
}
.nv-cta-secondary:hover { background: var(--nv-orange); color: #fff; }

/* ══════════════════════════
   RESPONSIVE
══════════════════════════ */
@media(max-width:1200px) {
    .nv-quick-grid { grid-template-columns: repeat(3, 1fr); }
    .nv-hero       { grid-template-columns: 1fr; }
    .nv-hero-sidebar { min-height: 0; }
    .nv-alerts-block { grid-template-columns: 1fr; gap: 36px; }
}
@media(max-width:900px) {
    .nv-body           { padding: 0 20px 40px; }
    .nv-articles-grid  { grid-template-columns: 1fr 1fr; }
    .nv-quick-grid     { grid-template-columns: repeat(2, 1fr); }
    .nv-alerts-block   { padding: 36px 24px; }
    .nv-cta            { flex-direction: column; text-align: center; }
    .nv-cta-content    { align-items: center; }
    .nv-cta-buttons    { justify-content: center; }
}
@media(max-width:600px) {
    .nv-articles-grid  { grid-template-columns: 1fr; }
    .nv-quick-grid     { grid-template-columns: repeat(2, 1fr); }
    .nv-tabs           { flex-wrap: nowrap; }
    .nv-hero-overlay   { padding: 20px; }
}
</style>

{{-- ╔══════════════════════════════════════════
    JAVASCRIPT
══════════════════════════════════════════╗ --}}
<script>
(function () {
    // Onglets régions
    const tabs = document.querySelectorAll('#nv-nouvelles .nv-tab');
    const panels = document.querySelectorAll('#nv-nouvelles .nv-tab-panel');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => { t.classList.remove('active'); t.setAttribute('aria-selected','false'); });
            panels.forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            tab.setAttribute('aria-selected','true');
            const target = document.getElementById(tab.dataset.tab);
            if (target) target.classList.add('active');
        });
    });

    // Formulaire alertes
    document.getElementById('nvAlertForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('.nv-btn-submit');
        btn.innerHTML = '<i class="fas fa-check"></i> Inscription confirmée !';
        btn.style.background = '#10b981';
        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-bell"></i> M\'inscrire aux alertes';
            btn.style.background = '';
            this.reset();
        }, 3000);
    });
})();
</script>

@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp