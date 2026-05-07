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

<section class="chat-space-section" id="espace-chat">
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="GoExploria Chat">
                    <div class="logo-wrapper">
                        <img src="{{ asset('logo.png') }}" alt="GoExploria Chat">
                    </div>
                    <span class="resto-accord-btn-label">GoExploria Chat</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-external-link-alt"></i> Visiter</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('ESPACE CHAT CLIENT MODERNE') }}</h1>
                <p class="resto-header-subtitle">{{ $tr('Centralisez vos conversations WhatsApp, Messenger, Instagram et site web dans une inbox unifiee rapide et professionnelle.') }}</p></div>
            
            <div class="resto-header-logo-right">
                
                <a href="{{url('page-chat')}}" title="En savoir plus" target="_blank" rel="noopener noreferrer">
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
        
            @include('home-v2.components.SectionNavbarEspaceMedia')
        <div class="resto-header-destinations-bar">
            <div class="resto-dest-row">
    <div class="resto-dest-icon-box">
        <img src="{{ asset('REDI.png') }}" alt="Destinations">
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

    <div class="chat-space-container">
        <div class="chat-space-overview">
            <div class="chat-kpi-card">
                <span>Temps moyen de reponse</span>
                <strong>1m 48s</strong>
            </div>
            <div class="chat-kpi-card">
                <span>Conversations aujourd'hui</span>
                <strong>326</strong>
            </div>
            <div class="chat-kpi-card">
                <span>Taux satisfaction</span>
                <strong>96%</strong>
            </div>
        </div>

        <div class="chat-single-showcase">
            <div class="chat-single-image-wrap">
                <div class="chat-image-card">
                    <img src="{{ asset('images/chat.png') }}" alt="Module chat GoExploria principal">
                </div>
                <div class="chat-image-card">
                    <img src="{{ asset('images/chat-1.png') }}" alt="Module chat GoExploria secondaire">
                </div>
                <div class="chat-image-card">
                    <img src="{{ asset('images/chat-2.png') }}" alt="Module chat GoExploria secondaire">
                </div>
            </div>
            <div class="chat-single-content">
                <h3>{{ $tr('Un seul espace pour toutes vos conversations clients') }}</h3>
                <p>{{ $tr('Le module chat GoExploria permet de repondre plus vite, de ne perdre aucun lead et de transformer chaque message en opportunite commerciale.') }}</p>
                <p>{{ $tr('Vos equipes support, ventes et marketing collaborent dans une interface unique avec historique complet, etiquetage intelligent et suivi des performances en temps reel.') }}</p>
                <div class="chat-service-points">
                    <span><i class="fas fa-comments"></i> {{ $tr('Inbox omnicanale unifiee') }}</span>
                    <span><i class="fas fa-bolt"></i> {{ $tr('Reponses rapides avec IA assistee') }}</span>
                    <span><i class="fas fa-user-shield"></i> {{ $tr('Priorisation VIP et SLA') }}</span>
                    <span><i class="fas fa-chart-line"></i> {{ $tr('Rapports conversion et satisfaction') }}</span>
                </div>
            </div>
        </div>
    </div>
</section>
