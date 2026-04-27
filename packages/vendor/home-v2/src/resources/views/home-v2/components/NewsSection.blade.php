@php(ob_start());@endphp

{{-- Dernières Nouvelles Component --}}
<section class="news-v2-section" id="news-section">

    {{-- ============================================================
         ENTÊTE STANDARD — DERNIÈRES NOUVELLES
         ============================================================ --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="GoExploria">
                    <div class="logo-wrapper">
                        <img src="{{ asset('logo.png') }}" alt="GoExploria">
                    </div>
                    <span class="resto-accord-btn-label">GoExploria</span>
                    <span class="resto-accord-btn-cta">
                        <i class="fas fa-external-link-alt"></i> Visiter
                    </span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">DERNIÈRES NOUVELLES</h1>
                <p class="resto-header-subtitle">
                    Les articles les plus récents par région — Afrique · Europe · Asie · Amériques
                </p>
                <div class="resto-header-tabs" role="tablist">
                    <button class="resto-tab-btn active" role="tab" data-region="all">
                        <i class="fas fa-globe"></i> Toutes régions
                    </button>
                    <button class="resto-tab-btn" role="tab" data-region="afrique">
                        <i class="fas fa-map-marker-alt"></i> Afrique
                    </button>
                    <button class="resto-tab-btn" role="tab" data-region="europe">
                        <i class="fas fa-map-marker-alt"></i> Europe
                    </button>
                    <button class="resto-tab-btn" role="tab" data-region="asie">
                        <i class="fas fa-map-marker-alt"></i> Asie
                    </button>
                    <button class="resto-tab-btn" role="tab" data-region="ameriques">
                        <i class="fas fa-map-marker-alt"></i> Amériques
                    </button>
                </div>
            </div>
            <div class="resto-header-logo-right">
                <a href="#" class="resto-accord-btn" title="Plans Web Go">
                    <div class="logo-wrapper">
                        <img src="{{ asset('plan-n-go.png') }}" alt="Plans Web Go">
                    </div>
                    <span class="resto-accord-btn-label">Plans Web Go</span>
                    <span class="resto-accord-btn-cta">
                        <i class="fas fa-external-link-alt"></i> Visiter
                    </span>
                </a>
            </div>
        </div>
        <div class="resto-header-destinations-bar">
            <div class="resto-dest-row">
                <div class="resto-dest-icon-box">
                    <img src="{{ asset('REDI.png') }}" alt="Destinations">
                    <span>Destinations</span>
                </div>
                <div class="resto-dest-breadcrumb">
                    <a href="#" class="resto-dest-link active">Toutes destinations</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">Amérique du Nord</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">Canada</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">Québec</a>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         CONTENU PRINCIPAL
         ============================================================ --}}
    <div class="news-container">

            {{-- 1. Grille des Articles Récents --}}
            <div class="news-articles-grid">
                
                {{-- Article Afrique --}}
                <div class="news-article-card">
                    <div class="news-article-image">
                        <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Afrique">
                        <span class="news-region-badge">AFRIQUE</span>
                    </div>
                    <div class="news-article-body">
                        <span class="news-category">Économie • Afrique</span>
                        <h3>Croissance record des économies d'Afrique de l'Ouest</h3>
                        <p>La CEDEAO annonce une croissance économique de 6.2% pour le dernier trimestre, dépassant toutes les prévisions.</p>
                        <div class="news-article-footer">
                            <span class="news-time">Il y a 3 heures</span>
                            <a href="#" class="news-read-btn">Lire <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

                {{-- Article Europe --}}
                <div class="news-article-card">
                    <div class="news-article-image">
                        <img src="https://images.unsplash.com/photo-1526628953301-3e589a6a8b74?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Europe">
                        <span class="news-region-badge">EUROPE</span>
                    </div>
                    <div class="news-article-body">
                        <span class="news-category">Politique • Europe</span>
                        <h3>Nouvelle politique migratoire de l'Union Européenne</h3>
                        <p>Les membres de l'UE trouvent un accord sur une approche commune pour la gestion des frontières et l'accueil des réfugiés.</p>
                        <div class="news-article-footer">
                            <span class="news-time">Il y a 6 heures</span>
                            <a href="#" class="news-read-btn">Lire <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

                {{-- Article Asie --}}
                <div class="news-article-card">
                    <div class="news-article-image">
                        <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Asie">
                        <span class="news-region-badge">ASIE</span>
                    </div>
                    <div class="news-article-body">
                        <span class="news-category">Innovation • Asie</span>
                        <h3>Le Japon lance son plus grand satellite d'observation</h3>
                        <p>Une avancée majeure pour la surveillance climatique et la prévention des catastrophes naturelles en Asie-Pacifique.</p>
                        <div class="news-article-footer">
                            <span class="news-time">Il y a 8 heures</span>
                            <a href="#" class="news-read-btn">Lire <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- 2. Zone d'Exploration par Région --}}
            <div class="news-explore-divider">
                <h2 class="design-bosse-label" style="font-size: 22px; color: #1a3a8f; margin-bottom: 10px;">Explorez les actualités spécifiques</h2>
                <p style="font-size: 14px; color: #888;">Explorez les actualités spécifiques à chaque région du monde</p>
            </div>

            <div class="news-region-grid">
                
                {{-- Afrique --}}
                <div class="region-explore-card africa">
                    <h4>Afrique</h4>
                    <span class="region-count"><i class="far fa-newspaper"></i> 245 nouvelles aujourd'hui</span>
                    <button class="region-explore-btn">Explorer</button>
                </div>

                {{-- Europe --}}
                <div class="region-explore-card europe">
                    <h4>Europe</h4>
                    <span class="region-count"><i class="far fa-newspaper"></i> 189 nouvelles aujourd'hui</span>
                    <button class="region-explore-btn">Explorer</button>
                </div>

                {{-- Asie --}}
                <div class="region-explore-card asia">
                    <h4>Asie</h4>
                    <span class="region-count"><i class="far fa-newspaper"></i> 312 nouvelles aujourd'hui</span>
                    <button class="region-explore-btn">Explorer</button>
                </div>

                {{-- Amériques --}}
                <div class="region-explore-card americas">
                    <h4>Amériques</h4>
                    <span class="region-count"><i class="far fa-newspaper"></i> 278 nouvelles aujourd'hui</span>
                    <button class="region-explore-btn">Explorer</button>
                </div>

            </div>

    </div>{{-- /news-container --}}
</section>

@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
