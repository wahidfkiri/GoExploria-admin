{{-- Agency Section — GoExploria Consulting & Expertise --}}
<section class="agency-v2-section" id="consulting-section">

    {{-- ============================================================
         ENTÊTE STANDARD — AGENCE DE CONSEIL
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
                <h1 class="resto-header-title">AGENCE DE CONSEIL POUR VOTRE ENTREPRISE</h1>
                <p class="resto-header-subtitle">
                    Consulting · Expertise · Stratégie · Digital — Développez votre entreprise avec nos solutions sur mesure et notre accompagnement professionnel.
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
                    <a href="#" class="agency-header-more-btn">
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
    <div class="agency-v2-container">
        <div class="agency-v2-content">

            {{-- Colonne Gauche : Présentation entreprise --}}
            <div class="agency-v2-info-card">
                <div class="agency-v2-brand">
                    <div class="agency-v2-logo-box">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="agency-v2-brand-text">
                        <h2>Stratégis Conseil</h2>
                        <p>Votre succès, notre expertise</p>
                    </div>
                </div>

                <div class="agency-v2-description">
                    <h3>Notre Accompagnement</h3>
                    <p>Nous sommes une agence de conseil spécialisée dans l'accompagnement des entreprises vers l'excellence opérationnelle et la croissance durable.</p>
                    <p>Notre équipe d'experts vous aide à identifier les opportunités, optimiser vos processus et mettre en place des stratégies efficaces pour atteindre vos objectifs.</p>
                </div>

                <ul class="agency-v2-features">
                    <li><i class="fas fa-check-circle"></i> Conseil stratégique</li>
                    <li><i class="fas fa-check-circle"></i> Analyse de marché</li>
                    <li><i class="fas fa-check-circle"></i> Solutions digitales</li>
                    <li><i class="fas fa-check-circle"></i> Accompagnement global</li>
                </ul>

                <div class="agency-v2-footer-content">
                    <div class="agency-v2-plans-grid">
                        <div class="agency-v2-plan-item">
                            <div class="agency-v2-plan-icon"><i class="fas fa-star"></i></div>
                            <h4>Essentiel</h4>
                            <p>Analyse initiale & recommandations</p>
                        </div>
                        <div class="agency-v2-plan-item">
                            <div class="agency-v2-plan-icon"><i class="fas fa-gem"></i></div>
                            <h4>Pro</h4>
                            <p>Accompagnement complet</p>
                        </div>
                        <div class="agency-v2-plan-item">
                            <div class="agency-v2-plan-icon"><i class="fas fa-crown"></i></div>
                            <h4>Enterprise</h4>
                            <p>Solutions sur mesure</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Colonne Droite : Formulaire interactif --}}
            <div class="agency-v2-form-card">
                <h3 class="agency-v2-form-title">Demandez Votre Consultation</h3>
                <form class="agency-v2-form" id="agencyConsultationForm">
                    <div class="agency-v2-form-grid">
                        <div class="agency-v2-input-group">
                            <label for="agency-company-name">Nom de votre société</label>
                            <input type="text" id="agency-company-name" name="company_name" placeholder="Ex: Ma Société SARL" required>
                        </div>

                        <div class="agency-v2-input-group">
                            <label for="agency-contact-name">Votre nom complet</label>
                            <input type="text" id="agency-contact-name" name="contact_name" placeholder="Ex: Jean Dupont" required>
                        </div>

                        <div class="agency-v2-input-group full">
                            <label for="agency-email">Adresse email</label>
                            <input type="email" id="agency-email" name="email" placeholder="exemple@societe.com" required>
                        </div>

                        <div class="agency-v2-input-group full">
                            <label for="agency-service">Service souhaité</label>
                            <select id="agency-service" name="service" required>
                                <option value="">Sélectionnez un service</option>
                                <option value="strategy">Conseil stratégique</option>
                                <option value="digital">Transformation digitale</option>
                                <option value="management">Management opérationnel</option>
                                <option value="marketing">Stratégie marketing</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="agency-v2-submit-btn">
                        <i class="fas fa-paper-plane"></i>
                        <span>Envoyer ma demande</span>
                    </button>
                </form>

                {{-- Stats compactes --}}
                <div class="agency-v2-stats">
                    <div class="agency-v2-stat-unit">
                        <span class="agency-v2-stat-value">+42%</span>
                        <span class="agency-v2-stat-label">Croissance</span>
                    </div>
                    <div class="agency-v2-stat-unit">
                        <span class="agency-v2-stat-value">94%</span>
                        <span class="agency-v2-stat-label">Satisfaction</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const agencyForm = document.getElementById('agencyConsultationForm');
        if (agencyForm) {
            agencyForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                console.log('Consultation Request Submited:', data);
                alert(`Merci ${data.contact_name}, votre demande pour le service "${data.service}" a bien été enregistrée. Notre équipe vous contactera sous 48h.`);
                this.reset();
            });
        }
    });
</script>
