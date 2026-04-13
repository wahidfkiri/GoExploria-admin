{{-- RealEstateSection — GoExploria Immobilier --}}
<section class="immo-v2-section" id="real-estate-section">

    {{-- ============================================================
         ENTÊTE STANDARD — IMMOBILIER
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
                <h1 class="resto-header-title">TROUVEZ LA PROPRIÉTÉ DE VOS RÊVES</h1>
                <p class="resto-header-subtitle">
                    Maisons · Appartements · Villas · Studios — Des biens sélectionnés pour correspondre à vos projets et à votre budget.
                </p>
                <div class="resto-header-tabs" role="tablist">
                    <button class="resto-tab-btn active" role="tab" data-filter="all">
                        <i class="fas fa-th-large"></i> Tous les biens
                    </button>
                    <button class="resto-tab-btn" role="tab" data-filter="maison">
                        <i class="fas fa-home"></i> Maisons
                    </button>
                    <button class="resto-tab-btn" role="tab" data-filter="appartement">
                        <i class="fas fa-building"></i> Appartements
                    </button>
                    <a href="#" class="immo-header-more-btn">
                        En savoir plus <i class="fas fa-arrow-right"></i>
                    </a>
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
    <div class="immo-v2-container">

        <!-- GRILLE DE CARTES (4 propriétés) -->
        <div class="immo-v2-grid">
            <!-- Carte 1 : Appartement moderne -->
            <article class="immo-v2-card">
                <div class="immo-v2-card-img">
                    <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800&auto=format&fit=crop&q=70" alt="Appartement moderne">
                    <span class="immo-v2-img-badge">À vendre</span>
                </div>
                <div class="immo-v2-card-content">
                    <div class="immo-v2-price">345 000 €</div>
                    <h3 class="immo-v2-card-title">Appartement Lumière</h3>
                    <div class="immo-v2-location"><i class="fas fa-map-pin"></i> Quartier Centre, Lyon</div>
                    <div class="immo-v2-features">
                        <span class="immo-v2-feature-item"><i class="fas fa-arrows-alt"></i> 85 m²</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-bed"></i> 3 chambres</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-bath"></i> 2 sdb</span>
                    </div>
                    <a href="#" class="immo-v2-btn">Voir le détail <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>

            <!-- Carte 2 : Maison contemporaine -->
            <article class="immo-v2-card">
                <div class="immo-v2-card-img">
                    <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&auto=format&fit=crop&q=70" alt="Maison contemporaine">
                    <span class="immo-v2-img-badge">Coup de cœur</span>
                </div>
                <div class="immo-v2-card-content">
                    <div class="immo-v2-price">895 000 €</div>
                    <h3 class="immo-v2-card-title">Villa Moderne</h3>
                    <div class="immo-v2-location"><i class="fas fa-map-pin"></i> Saint-Germain, Paris</div>
                    <div class="immo-v2-features">
                        <span class="immo-v2-feature-item"><i class="fas fa-arrows-alt"></i> 160 m²</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-bed"></i> 5 chambres</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-tree"></i> Jardin 300 m²</span>
                    </div>
                    <a href="#" class="immo-v2-btn">Voir le détail <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>

            <!-- Carte 3 : Studio investissement -->
            <article class="immo-v2-card">
                <div class="immo-v2-card-img">
                    <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800&auto=format&fit=crop&q=70" alt="Studio rénové">
                    <span class="immo-v2-img-badge">Investissement</span>
                </div>
                <div class="immo-v2-card-content">
                    <div class="immo-v2-price">125 000 €</div>
                    <h3 class="immo-v2-card-title">Studio Centre</h3>
                    <div class="immo-v2-location"><i class="fas fa-map-pin"></i> Bordeaux Centre</div>
                    <div class="immo-v2-features">
                        <span class="immo-v2-feature-item"><i class="fas fa-arrows-alt"></i> 32 m²</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-door-open"></i> 1 pièce</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-chart-line"></i> Rendement 6%</span>
                    </div>
                    <a href="#" class="immo-v2-btn">Voir le détail <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>

            <!-- Carte 4 : Duplex de standing -->
            <article class="immo-v2-card">
                <div class="immo-v2-card-img">
                    <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=800&auto=format&fit=crop&q=70" alt="Duplex terrasse">
                    <span class="immo-v2-img-badge">Exclusivité</span>
                </div>
                <div class="immo-v2-card-content">
                    <div class="immo-v2-price">580 000 €</div>
                    <h3 class="immo-v2-card-title">Duplex Terrasse</h3>
                    <div class="immo-v2-location"><i class="fas fa-map-pin"></i> Montpellier</div>
                    <div class="immo-v2-features">
                        <span class="immo-v2-feature-item"><i class="fas fa-arrows-alt"></i> 110 m²</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-bed"></i> 4 chambres</span>
                        <span class="immo-v2-feature-item"><i class="fas fa-sun"></i> Terrasse 40 m²</span>
                    </div>
                    <a href="#" class="immo-v2-btn">Voir le détail <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>
        </div>

        <!-- BLOC AGENT / CONTACT ÉDITABLE -->
        <div class="immo-v2-agent-cta">
            <div class="immo-v2-agent-info">
                <img class="immo-v2-agent-img" src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=200&auto=format&fit=crop&q=60" alt="Sophie Martin">
                <div class="immo-v2-agent-details">
                    <h4>Sophie Martin</h4>
                    <p>Conseillère immobilière spécialisée centre-ville</p>
                    <p style="font-weight: 700; margin-top: 5px; color: #1a3a8f;"><i class="fas fa-phone-alt"></i> 06 12 34 56 78</p>
                </div>
            </div>
            <a href="#" class="immo-v2-contact-btn"><i class="fas fa-envelope"></i> Contacter l'agent</a>
        </div>
    </div>
</section>
