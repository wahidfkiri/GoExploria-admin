@php
    $plansCollection = $plans ?? collect();
    $canOpenPlanDetail = \Illuminate\Support\Facades\Route::has('plans.show');
    $canOpenDevis = \Illuminate\Support\Facades\Route::has('devis');
    $cleanPlanText = function ($value, $limit = 200) {
        $raw = (string) ($value ?? '');
        $raw = str_ireplace(['<br>', '<br/>', '<br />', '</p>', '</div>', '</li>'], ' ', $raw);
        $raw = strip_tags($raw);
        $raw = preg_replace('/\s+/u', ' ', $raw);
        $raw = trim((string) $raw);
        return \Illuminate\Support\Str::limit($raw, $limit);
    };
@endphp

<section class="nos-plans-section" id="nos-plans">
    <div class="nos-plans-container">
        <div class="nos-plans-header-block">
            <div class="nos-plans-header-main">
                <div class="nos-plans-header-left">
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

                <div class="nos-plans-header-center">
                    <h1 class="nos-plans-header-title">NOS PLANS</h1>
                    <p class="nos-plans-header-subtitle">
                        Plans organises en 2 colonnes, informations business et destinations, avec plugins integres.
                    </p>
                    <div class="nos-plans-header-tabs" role="tablist">
                        <button class="nos-plans-tab-btn active" role="tab" aria-selected="true">
                            <i class="fas fa-layer-group"></i> Tous les plans actifs
                        </button>
                    </div>
                </div>

                <div class="nos-plans-header-image" aria-hidden="true">
                    <img src="{{ asset('goexploria-plan.png') }}" alt="GoExploria Plan">
                </div>
            </div>
        </div>

        @if($plansCollection->isEmpty())
            <div class="nos-plans-empty">
                Aucun plan actif pour le moment.
            </div>
        @else
            <div class="nos-plans-grid" role="list" aria-label="Liste des plans">
                @foreach($plansCollection as $plan)
                    @php
                        $description = $cleanPlanText($plan->description, 200);
                        $servicesText = $cleanPlanText($plan->services, 200);
                        $visionText = $cleanPlanText($plan->vision_text, 180);
                        $features = collect($plan->features_list ?? [])->filter()->take(4)->values();
                        $marketingFeatures = collect($plan->marketing_features_list ?? [])->filter()->take(3)->values();
                        $languages = collect($plan->market_languages_list ?? [])->filter()->take(3)->values();
                        $destinations = collect($plan->activeDestinations ?? [])->take(6);
                        $includedPlugins = collect($plan->plugins ?? [])
                            ->filter(function ($plugin) {
                                return !isset($plugin->pivot) || (bool) $plugin->pivot->is_included;
                            })
                            ->take(8);

                        $priceLabel = $plan->price ? $plan->formatted_price : 'Sur demande';
                        $cycleLabel = $plan->billing_cycle === 'yearly' ? '/an' : '/mois';
                        $detailsUrl = $canOpenPlanDetail
                            ? route('plans.show', ['slug' => $plan->slug])
                            : '#';
                        $devisUrl = $canOpenDevis ? route('devis') : '#';
                    @endphp

                    <article class="nos-plan-panel" role="listitem">
                        <header class="nos-plan-panel-head">
                            <h3 class="nos-plan-name">{{ $plan->name }}</h3>
                            <div class="nos-plan-head-badges">
                                @if($plan->is_popular)
                                    <span class="nos-plan-badge">Populaire</span>
                                @endif
                                <span class="nos-plan-badge nos-plan-badge-soft">{{ $plan->space_type_label ?? 'Espace entreprise' }}</span>
                            </div>
                        </header>

                        <div class="nos-plan-summary">
                            <p class="nos-plan-description">{{ $description ?: 'Plan disponible avec options personnalisees.' }}</p>
                            <div class="nos-plan-tags">
                                @if(!empty($plan->duration_days))
                                    <span class="nos-plan-tag">{{ $plan->duration_days }} jours</span>
                                @endif
                                <span class="nos-plan-tag">{{ $plan->billing_cycle === 'yearly' ? 'Facturation annuelle' : 'Facturation mensuelle' }}</span>
                                <span class="nos-plan-tag">Budget {{ $plan->formatted_marketing_budget }}</span>
                            </div>
                        </div>

                        <div class="nos-plan-metrics">
                            <div class="nos-plan-metric">
                                <span class="nos-plan-metric-label">Prix</span>
                                <span class="nos-plan-metric-value">{{ $priceLabel }}@if($plan->price) {{ $cycleLabel }}@endif</span>
                            </div>
                            <div class="nos-plan-metric">
                                <span class="nos-plan-metric-label">Cycle</span>
                                <span class="nos-plan-metric-value">{{ $plan->billing_cycle === 'yearly' ? 'Annuel' : 'Mensuel' }}</span>
                            </div>
                            <div class="nos-plan-metric">
                                <span class="nos-plan-metric-label">Position</span>
                                <span class="nos-plan-metric-value">{{ (int) ($plan->sort_order ?? 0) }}</span>
                            </div>
                        </div>

                        <div class="nos-plan-columns">
                            <div class="nos-plan-block">
                                <p class="nos-plan-detail-line">
                                    <strong>Services:</strong> {{ $servicesText ?: 'Selon configuration du plan.' }}
                                </p>
                                <p class="nos-plan-detail-line">
                                    <strong>Vision:</strong> {{ $visionText ?: 'Vision definie dans le plan.' }}
                                </p>
                            </div>

                            <div class="nos-plan-block">
                                @if($features->isNotEmpty() || $marketingFeatures->isNotEmpty() || $languages->isNotEmpty())
                                    <ul class="nos-plan-points">
                                        @if($features->isNotEmpty())
                                            <li><strong>Features:</strong> {{ $features->implode(', ') }}</li>
                                        @endif
                                        @if($marketingFeatures->isNotEmpty())
                                            <li><strong>Marketing:</strong> {{ $marketingFeatures->implode(', ') }}</li>
                                        @endif
                                        @if($languages->isNotEmpty())
                                            <li><strong>Langues:</strong> {{ $languages->implode(', ') }}</li>
                                        @endif
                                    </ul>
                                @else
                                    <p class="nos-plan-detail-line">Aucun detail complementaire pour ce plan.</p>
                                @endif
                            </div>
                        </div>

                        <div class="nos-plan-destinations">
                            <h4 class="nos-plan-subtitle">Marchés</h4>
                            @if($destinations->isEmpty())
                                <p class="nos-plan-dest-empty">Aucun marché actif lié.</p>
                            @else
                                <div class="nos-plan-dest-list">
                                    @foreach($destinations as $destination)
                                        <span class="nos-plan-dest-chip">
                                            {{ $destination->destination_name }}
                                            @if(!empty($destination->full_location))
                                                <small>{{ $destination->full_location }}</small>
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="nos-plan-plugins">
                            <h4 class="nos-plan-subtitle">
                                <i class="fas fa-puzzle-piece"></i>
                                Services intégrés
                            </h4>
                            @if($includedPlugins->isEmpty())
                                <p class="nos-plan-dest-empty">Aucun plugin inclus.</p>
                            @else
                                <div class="nos-plugin-grid">
                                    @foreach($includedPlugins as $plugin)
                                        @php
                                            $pluginIconClass = trim((string) ($plugin->icon ?? ''));
                                            if ($pluginIconClass === '') {
                                                $pluginIconClass = 'fas fa-puzzle-piece';
                                            }
                                        @endphp
                                        <div class="nos-plugin-card">
                                            <div class="nos-plugin-title">
                                                <i class="{{ $pluginIconClass }} nos-plugin-icon" aria-hidden="true"></i>
                                                <span class="nos-plugin-name">{{ $plugin->name }}</span>
                                            </div>
                                            @if(!empty($plugin->description))
                                                <p class="nos-plugin-desc">{{ \Illuminate\Support\Str::limit(strip_tags((string) $plugin->description), 90) }}</p>
                                            @else
                                                <p class="nos-plugin-desc">Plugin integre au plan.</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="nos-plan-actions">
                            <a href="{{ $detailsUrl }}" class="nos-plan-btn">En savoir plus</a>
                            <a href="{{ $devisUrl }}" class="nos-plan-btn nos-plan-btn-secondary">Demander un devis</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
