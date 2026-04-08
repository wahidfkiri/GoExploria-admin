<section class="agency-v2-section" id="consulting-section">
    <div class="agency-v2-container">
        <!-- Header de la section -->
        <div class="agency-v2-header">
            <span class="agency-v2-badge">Consulting & Expertise</span>
            <h1 class="agency-v2-title">Agence de Conseil pour Votre Entreprise</h1>
            <p class="agency-v2-subtitle">Développez votre entreprise avec notre expertise stratégique et nos solutions sur mesure. Demandez votre consultation personnalisée.</p>
        </div>

        <div class="agency-v2-content">
            <!-- Colonne Gauche : Présentation entreprise -->
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

                <!-- Section Plans intégrée dans la colonne info pour un meilleur équilibre -->
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

            <!-- Colonne Droite : Formulaire interactif -->
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

                <!-- Stats compactes au pied du formulaire -->
                <div class="agency-v2-stats" style="margin-top: 30px; gap: 30px; padding: 20px;">
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
