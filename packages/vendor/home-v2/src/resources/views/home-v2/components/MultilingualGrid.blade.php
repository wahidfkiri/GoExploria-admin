{{-- Multilingual Grid Component (VOTRE ESPACE ENTREPRISE MULTILINGUES) --}}
<section class="multilingual-v2-section" id="enterprise-multilingual">

    {{-- ============================================================
         ENTÊTE STANDARD — ESPACE MULTILINGUE
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
                <h1 class="resto-header-title">VOTRE ESPACE ENTREPRISE MULTILINGUES</h1>
                <p class="resto-header-subtitle">
                    Choisissez votre langue préférée afin de pénétrer les marchés internationaux et offrir une expérience de shopping exclusive.
                </p>
                <div class="resto-header-tabs" role="tablist">
                    <button class="resto-tab-btn active" role="tab" data-espace="all">
                        <i class="fas fa-th-large"></i> Toutes les langues
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
         CONTENU PRINCIPAL
         ============================================================ --}}
    <div class="mlg-container">

            {{-- Grille des Langues --}}
            <div class="lang-grid-container">
                
                {{-- Français (PRINCIPALE) --}}
                <div class="lang-card">
                    <span class="lang-status-badge principale">PRINCIPALE</span>
                    <div class="flag-circle">
                        <img src="https://flagcdn.com/w160/fr.png" alt="Drapeau Français">
                    </div>
                    <h3>Français</h3>
                    <p>Langue originale. Contenu complet et support client en français.</p>
                    <button class="lang-select-btn selected">
                        <i class="fas fa-check"></i> Sélectionné
                    </button>
                </div>

                {{-- Anglais (POPULAIRE) --}}
                <div class="lang-card">
                    <span class="lang-status-badge populaire">POPULAIRE</span>
                    <div class="flag-circle">
                        <img src="https://flagcdn.com/w160/gb.png" alt="Drapeau Anglais">
                    </div>
                    <h3>ANGLAIS</h3>
                    <p>International version. Full content and customer support.</p>
                    <button class="lang-select-btn">
                        <i class="fas fa-globe"></i> Select
                    </button>
                </div>

                {{-- Espagnol (NOUVEAU) --}}
                <div class="lang-card">
                    <span class="lang-status-badge nouveau">NOUVEAU</span>
                    <div class="flag-circle">
                        <img src="https://flagcdn.com/w160/es.png" alt="Drapeau Espagnol">
                    </div>
                    <h3>Español</h3>
                    <p>Versión internacional. Contenido completo y soporte.</p>
                    <button class="lang-select-btn">
                        <i class="fas fa-globe"></i> Seleccionar
                    </button>
                </div>

                {{-- Allemand (PROCHAINE) --}}
                <div class="lang-card">
                    <span class="lang-status-badge prochaine">PROCHAINE</span>
                    <div class="flag-circle">
                        <img src="https://flagcdn.com/w160/de.png" alt="Drapeau Allemand">
                    </div>
                    <h3>ALLEMAND</h3>
                    <p>Internationale Version. Vollständiger Inhalt.</p>
                    <button class="lang-select-btn">
                        <i class="fas fa-globe"></i> Auswählen
                    </button>
                </div>

            </div>

            {{-- Footer Note SEO / CDN --}}
            <div class="enterprise-footer-note">
                <div class="note-box">
                    <i class="fas fa-globe-americas"></i>
                    <span>🌐 Votre ESPACE ENTREPRISE inclut LE SEO GOOGLE / CDN + 4/8/12 jusqu'à 25 langues disponibles</span>
                </div>
            </div>

            {{-- Deuxième Ligne de Langues Optionnelles (Chinois, Hindi, Portugais, Arabe) --}}
            {{-- Caché par défaut ou affiché selon besoin - Ici je le mets en 2ème grille pour la démo --}}
            <div class="lang-grid-container" style="margin-top: 50px; opacity: 0.85;">
                
                {{-- Chinois Mandarin --}}
                <div class="lang-card">
                    <span class="lang-status-badge principale">PRINCIPALE</span>
                    <div class="flag-circle"><img src="https://flagcdn.com/w160/cn.png" alt="Drapeau Chinois"></div>
                    <h3>CHINOIS MANDARIN</h3>
                    <p>Langue stratégique pour le marché asiatique. Support partiel.</p>
                    <button class="lang-select-btn"><i class="fas fa-globe"></i> Send</button>
                </div>

                {{-- Hindi Inde --}}
                <div class="lang-card">
                    <span class="lang-status-badge populaire">POPULAIRE</span>
                    <div class="flag-circle"><img src="https://flagcdn.com/w160/in.png" alt="Drapeau Hindi"></div>
                    <h3>HINDI INDE</h3>
                    <p>International version. Full content and support.</p>
                    <button class="lang-select-btn"><i class="fas fa-globe"></i> Send</button>
                </div>

                {{-- Portugais --}}
                <div class="lang-card">
                    <span class="lang-status-badge nouveau">NOUVEAU</span>
                    <div class="flag-circle"><img src="https://flagcdn.com/w160/pt.png" alt="Drapeau Portugal"></div>
                    <h3>PORTUGAIS</h3>
                    <p>Versión internacional. Contenido completo y soporte.</p>
                    <button class="lang-select-btn"><i class="fas fa-globe"></i> Send</button>
                </div>

                {{-- Arabe --}}
                <div class="lang-card">
                    <span class="lang-status-badge prochaine">PROCHAINE</span>
                    <div class="flag-circle"><img src="https://flagcdn.com/w160/sa.png" alt="Drapeau Arabie"></div>
                    <h3>ARABE</h3>
                    <p>Internationale Version. Vollständiger Inhalt.</p>
                    <button class="lang-select-btn"><i class="fas fa-globe"></i> Send</button>
                </div>

            </div>

    </div>{{-- /mlg-container --}}
</section>
