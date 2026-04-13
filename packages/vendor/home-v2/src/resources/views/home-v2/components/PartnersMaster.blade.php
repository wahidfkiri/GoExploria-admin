{{-- Partners Master Component — GoExploria --}}
<section class="pm-section" id="partners-master">

    {{-- ============================================================
         ENTÊTE STANDARD — PARTENAIRES MASTER USER GO EXPLORIA
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
                <h1 class="resto-header-title">PARTENAIRES MASTER USER GO EXPLORIA</h1>
                <p class="resto-header-subtitle">
                    Destinations · Entreprises · Activités · Marchés — Activez et gérez votre présence GoExploria avec les outils professionnels dédiés aux partenaires.
                </p>
                <div class="resto-header-tabs" role="tablist">
                    <button class="resto-tab-btn active" role="tab" data-espace="all">
                        <i class="fas fa-th-large"></i> Toutes les options
                    </button>
                    <button class="resto-tab-btn" role="tab" data-espace="entreprise">
                        <i class="fas fa-briefcase"></i> Espace entreprise
                    </button>
                    <button class="resto-tab-btn" role="tab" data-espace="destination">
                        <i class="fas fa-map-marker-alt"></i> Espace destination
                    </button>
                    <button class="resto-tab-btn" role="tab" data-espace="activite">
                        <i class="fas fa-person-hiking"></i> Espace activité
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
         NIVEAUX DE PARTENARIAT
         ============================================================ --}}
    <div class="pm-plans-wrap">
        <div class="pm-plans-header">
            <span class="pm-section-label">Programmes</span>
            <h2 class="pm-section-title">Choisissez votre niveau de partenariat</h2>
            <p class="pm-section-desc">Des offres adaptées à chaque acteur du tourisme, de la petite entreprise locale au grand réseau international.</p>
        </div>
        <div class="pm-plans-grid">

            {{-- Plan Partenaire --}}
            <div class="pm-plan-card">
                <div class="pm-plan-badge pm-badge-partner">PARTENAIRE</div>
                <div class="pm-plan-icon"><i class="fas fa-store"></i></div>
                <h3 class="pm-plan-name">Partenaire</h3>
                <p class="pm-plan-desc">Idéal pour les entreprises locales souhaitant accroître leur visibilité sur la plateforme GoExploria.</p>
                <ul class="pm-plan-features">
                    <li><i class="fas fa-check"></i> Fiche établissement complète</li>
                    <li><i class="fas fa-check"></i> Accès au tableau de bord</li>
                    <li><i class="fas fa-check"></i> Statistiques de base</li>
                    <li><i class="fas fa-check"></i> Support par courriel</li>
                    <li class="pm-plan-feat-off"><i class="fas fa-times"></i> Accès réseau Master</li>
                    <li class="pm-plan-feat-off"><i class="fas fa-times"></i> Données marché avancées</li>
                </ul>
                <a href="#" class="pm-btn pm-btn-light">Commencer <i class="fas fa-arrow-right"></i></a>
            </div>

            {{-- Plan Master (vedette) --}}
            <div class="pm-plan-card pm-plan-featured">
                <div class="pm-plan-ribbon">Plus populaire</div>
                <div class="pm-plan-badge pm-badge-master">MASTER</div>
                <div class="pm-plan-icon"><i class="fas fa-crown"></i></div>
                <h3 class="pm-plan-name">Master</h3>
                <p class="pm-plan-desc">Pour les acteurs régionaux qui veulent gérer plusieurs destinations et maximiser leurs performances.</p>
                <ul class="pm-plan-features">
                    <li><i class="fas fa-check"></i> Gestion multi-destinations</li>
                    <li><i class="fas fa-check"></i> Tableau de bord avancé</li>
                    <li><i class="fas fa-check"></i> Analyse de marché en temps réel</li>
                    <li><i class="fas fa-check"></i> Facturation automatique</li>
                    <li><i class="fas fa-check"></i> Support dédié 7j/7</li>
                    <li><i class="fas fa-check"></i> Formation complète incluse</li>
                </ul>
                <a href="#" class="pm-btn pm-btn-primary">Activer Master <i class="fas fa-arrow-right"></i></a>
            </div>

            {{-- Plan User Go Exploria --}}
            <div class="pm-plan-card">
                <div class="pm-plan-badge pm-badge-exploria">USER GO EXPLORIA</div>
                <div class="pm-plan-icon"><i class="fas fa-globe-americas"></i></div>
                <h3 class="pm-plan-name">User Go Exploria</h3>
                <p class="pm-plan-desc">La solution complète pour les grands réseaux et opérateurs nationaux ou internationaux.</p>
                <ul class="pm-plan-features">
                    <li><i class="fas fa-check"></i> Accès illimité toutes destinations</li>
                    <li><i class="fas fa-check"></i> API & intégrations tierces</li>
                    <li><i class="fas fa-check"></i> Gestion des partenaires réseau</li>
                    <li><i class="fas fa-check"></i> Rapports financiers détaillés</li>
                    <li><i class="fas fa-check"></i> Conseiller dédié exclusif</li>
                    <li><i class="fas fa-check"></i> Tarifs préférentiels premium</li>
                </ul>
                <a href="#" class="pm-btn pm-btn-light">Nous contacter <i class="fas fa-arrow-right"></i></a>
            </div>

        </div>
    </div>

    {{-- ============================================================
         FONCTIONNALITÉS + TABLEAU DE BORD
         ============================================================ --}}
    <div class="pm-features-wrap">
        <div class="pm-features-container">

            {{-- Fonctionnalités --}}
            <div class="pm-features-col">
                <span class="pm-section-label">Fonctionnalités</span>
                <h2 class="pm-section-title pm-section-title--left">Des outils puissants pour chaque besoin</h2>
                <div class="pm-features-list">
                    <div class="pm-feature-item">
                        <div class="pm-icon-box"><i class="fas fa-map-marked-alt"></i></div>
                        <div class="pm-feat-info">
                            <h4>Gestion Multi-Destinations</h4>
                            <p>Centralisez toutes vos destinations depuis une interface unique. Suivez les performances et optimisez vos offres en temps réel.</p>
                        </div>
                    </div>
                    <div class="pm-feature-item">
                        <div class="pm-icon-box"><i class="fas fa-chart-line"></i></div>
                        <div class="pm-feat-info">
                            <h4>Analyse de Marché Avancée</h4>
                            <p>Accédez aux données marché en temps réel, identifiez les tendances et prenez des décisions stratégiques éclairées.</p>
                        </div>
                    </div>
                    <div class="pm-feature-item">
                        <div class="pm-icon-box"><i class="fas fa-users-cog"></i></div>
                        <div class="pm-feat-info">
                            <h4>Gestion des Partenaires</h4>
                            <p>Collaborez efficacement avec votre réseau. Partagez des ressources, synchronisez les calendriers et travaillez en harmonie.</p>
                        </div>
                    </div>
                    <div class="pm-feature-item">
                        <div class="pm-icon-box"><i class="fas fa-file-invoice-dollar"></i></div>
                        <div class="pm-feat-info">
                            <h4>Facturation et Suivi Financier</h4>
                            <p>Générez des factures automatiques, suivez les paiements et analysez vos performances avec des rapports détaillés.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dashboard --}}
            <div class="pm-dashboard-col">
                <div class="pm-dashboard-card">
                    <div class="pm-dash-header">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Tableau de Bord Master</span>
                        <span class="pm-dash-live"><i class="fas fa-circle"></i> En direct</span>
                    </div>
                    <div class="pm-dash-metrics">
                        <div class="pm-metric">
                            <span class="pm-metric-val">+87%</span>
                            <span class="pm-metric-lbl">Croissance réseau</span>
                            <span class="pm-metric-trend up"><i class="fas fa-arrow-up"></i> +12% ce mois</span>
                        </div>
                        <div class="pm-metric">
                            <span class="pm-metric-val">156</span>
                            <span class="pm-metric-lbl">Destinations actives</span>
                            <span class="pm-metric-trend up"><i class="fas fa-arrow-up"></i> +8 nouvelles</span>
                        </div>
                        <div class="pm-metric">
                            <span class="pm-metric-val">2.4M$</span>
                            <span class="pm-metric-lbl">Chiffre d'affaires</span>
                            <span class="pm-metric-trend up"><i class="fas fa-arrow-up"></i> +23% annuel</span>
                        </div>
                        <div class="pm-metric">
                            <span class="pm-metric-val">94%</span>
                            <span class="pm-metric-lbl">Satisfaction clients</span>
                            <span class="pm-metric-trend neutral"><i class="fas fa-minus"></i> Stable</span>
                        </div>
                    </div>
                    <a href="#" class="pm-btn pm-btn-primary pm-dash-cta">
                        <i class="fas fa-external-link-alt"></i> Accéder au Dashboard
                    </a>
                    <div class="pm-dash-advantages">
                        <h4><i class="fas fa-star"></i> Avantages exclusifs Master</h4>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> <strong>Accès prioritaire</strong> aux nouvelles fonctionnalités</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Support dédié</strong> disponible 7j/7</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Formation complète</strong> pour maximiser votre ROI</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Réseau exclusif</strong> de partenaires business</li>
                            <li><i class="fas fa-check-circle"></i> <strong>Tarifs préférentiels</strong> sur les services premium</li>
                        </ul>
                    </div>
                </div>
            </div>




        </div>

         {{-- ============================================================
         ILS NOUS FONT CONFIANCE
         ============================================================ --}}
    <div class="pm-trust-wrap">
        <p class="pm-trust-label">Ils nous font confiance</p>
        <div class="pm-trust-grid">
            <div class="pm-trust-item"><i class="fas fa-hotel"></i><span>Hotel Group Pro</span></div>
            <div class="pm-trust-item"><i class="fas fa-plane"></i><span>Voyage Elite</span></div>
            <div class="pm-trust-item"><i class="fas fa-umbrella-beach"></i><span>Resort Luxury</span></div>
            <div class="pm-trust-item"><i class="fas fa-concierge-bell"></i><span>Event Masters</span></div>
            <div class="pm-trust-item"><i class="fas fa-map-signs"></i><span>Tourism Experts</span></div>
            <div class="pm-trust-item"><i class="fas fa-briefcase"></i><span>Business Travel</span></div>
            <div class="pm-trust-item"><i class="fas fa-ski-jumping"></i><span>Aventures Québec</span></div>
            <div class="pm-trust-item"><i class="fas fa-wine-glass-alt"></i><span>Gastronomie QC</span></div>
        </div>
    </div>
    </div>

   

</section>
