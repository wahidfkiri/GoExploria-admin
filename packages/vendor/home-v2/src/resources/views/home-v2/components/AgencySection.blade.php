@php
    $tr = static function (string $text): string {
        $locale = app()->getLocale();
        if ($locale === 'fr') {
            return $text;
        }

        static $maps = [];
        if (! array_key_exists($locale, $maps)) {
            $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
            $maps[$locale] = is_file($path) ? (require $path) : [];
        }

        return $maps[$locale][$text] ?? $text;
    };
@endphp

{{-- Agency Section — GoExploria Consulting & Expertise --}}
<section class="agency-v2-section" id="activez-entreprises">

    {{-- ============================================================
         ENTÊTE STANDARD — AGENCE DE CONSEIL
         ============================================================ --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="{{ $tr('GoExploria') }}">
                    <div class="logo-wrapper">
                        <img src="{{ asset('logo.png') }}" alt="{{ $tr('GoExploria') }}">
                    </div>
                    <span class="resto-accord-btn-label">{{ $tr('GoExploria') }}</span>
                    <span class="resto-accord-btn-cta">
                        <i class="fas fa-external-link-alt"></i> {{ $tr('Visiter') }}
                    </span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('AGENCE DE CONSEIL POUR VOTRE ENTREPRISE') }}</h1>
                <p class="resto-header-subtitle">
                    {{ $tr('Consulting · Expertise · Stratégie · Digital — Développez votre entreprise avec nos solutions sur mesure et notre accompagnement professionnel.') }}
                </p></div>
            <div class="resto-header-logo-right">
                <a href="#" class="resto-accord-btn" title="{{ $tr('Plans Web Go') }}">
                    <div class="logo-wrapper">
                        <img src="{{ asset('plan-n-go.png') }}" alt="{{ $tr('Plans Web Go') }}">
                    </div>
                    <span class="resto-accord-btn-label">{{ $tr('Plans Web Go') }}</span>
                    <span class="resto-accord-btn-cta">
                        <i class="fas fa-external-link-alt"></i> {{ $tr('Visiter') }}
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
                        <h2>{{ $tr('Stratégis Conseil') }}</h2>
                        <p>{{ $tr('Votre succès, notre expertise') }}</p>
                    </div>
                </div>

                <div class="agency-v2-description">
                    <h3>{{ $tr('Notre Accompagnement') }}</h3>
                    <p>{{ $tr('Nous sommes une agence de conseil spécialisée dans l\'accompagnement des entreprises vers l\'excellence opérationnelle et la croissance durable.') }}</p>
                    <p>{{ $tr('Notre équipe d\'experts vous aide à identifier les opportunités, optimiser vos processus et mettre en place des stratégies efficaces pour atteindre vos objectifs.') }}</p>
                </div>

                <ul class="agency-v2-features">
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Conseil stratégique') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Analyse de marché') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Solutions digitales') }}</li>
                    <li><i class="fas fa-check-circle"></i> {{ $tr('Accompagnement global') }}</li>
                </ul>

                <div class="agency-v2-footer-content">
                    <div class="agency-v2-plans-grid">
                        <div class="agency-v2-plan-item">
                            <div class="agency-v2-plan-icon"><i class="fas fa-star"></i></div>
                            <h4>{{ $tr('Essentiel') }}</h4>
                            <p>{{ $tr('Analyse initiale & recommandations') }}</p>
                        </div>
                        <div class="agency-v2-plan-item">
                            <div class="agency-v2-plan-icon"><i class="fas fa-gem"></i></div>
                            <h4>{{ $tr('Pro') }}</h4>
                            <p>{{ $tr('Accompagnement complet') }}</p>
                        </div>
                        <div class="agency-v2-plan-item">
                            <div class="agency-v2-plan-icon"><i class="fas fa-crown"></i></div>
                            <h4>{{ $tr('Enterprise') }}</h4>
                            <p>{{ $tr('Solutions sur mesure') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Colonne Droite : Formulaire interactif --}}
            <div class="agency-v2-form-card">
                <h3 class="agency-v2-form-title">{{ $tr('Demandez Votre Consultation') }}</h3>
                <form class="agency-v2-form" id="agencyConsultationForm">
                    <div class="agency-v2-form-grid">
                        <div class="agency-v2-input-group">
                            <label for="agency-company-name">{{ $tr('Nom de votre société') }}</label>
                            <input type="text" id="agency-company-name" name="company_name" placeholder="{{ $tr('Ex: Ma Société SARL') }}" required>
                        </div>

                        <div class="agency-v2-input-group">
                            <label for="agency-contact-name">{{ $tr('Votre nom complet') }}</label>
                            <input type="text" id="agency-contact-name" name="contact_name" placeholder="{{ $tr('Ex: Jean Dupont') }}" required>
                        </div>

                        <div class="agency-v2-input-group full">
                            <label for="agency-email">{{ $tr('Adresse email') }}</label>
                            <input type="email" id="agency-email" name="email" placeholder="exemple@societe.com" required>
                        </div>

                        <div class="agency-v2-input-group full">
                            <label for="agency-service">{{ $tr('Service souhaité') }}</label>
                            <select id="agency-service" name="service" required>
                                <option value="">{{ $tr('Sélectionnez un service') }}</option>
                                <option value="strategy">{{ $tr('Conseil stratégique') }}</option>
                                <option value="digital">{{ $tr('Transformation digitale') }}</option>
                                <option value="management">{{ $tr('Management opérationnel') }}</option>
                                <option value="marketing">{{ $tr('Stratégie marketing') }}</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="agency-v2-submit-btn">
                        <i class="fas fa-paper-plane"></i>
                        <span>{{ $tr('Envoyer ma demande') }}</span>
                    </button>
                </form>

                {{-- Stats compactes --}}
                <div class="agency-v2-stats">
                    <div class="agency-v2-stat-unit">
                        <span class="agency-v2-stat-value">+42%</span>
                        <span class="agency-v2-stat-label">{{ $tr('Croissance') }}</span>
                    </div>
                    <div class="agency-v2-stat-unit">
                        <span class="agency-v2-stat-value">94%</span>
                        <span class="agency-v2-stat-label">{{ $tr('Satisfaction') }}</span>
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
                const formLabels = {
                    strategy: @json($tr('Conseil stratégique')),
                    digital: @json($tr('Transformation digitale')),
                    management: @json($tr('Management opérationnel')),
                    marketing: @json($tr('Stratégie marketing'))
                };
                const selectedServiceLabel = formLabels[data.service] || data.service;
                const successTemplate = @json($tr('Merci :name, votre demande pour le service ":service" a bien été enregistrée. Notre équipe vous contactera sous 48h.'));
                alert(successTemplate.replace(':name', data.contact_name || '').replace(':service', selectedServiceLabel || ''));
                this.reset();
            });
        }
    });
</script>
