{{-- ============================================================
     BLOC 2 — ACTIVEZ VOS PLANS NEXT LEVEL
     Entreprises · Destinations · Partenaires · Activités · Produits
     ============================================================ --}}
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

    $canOpenPlanDetail = \Illuminate\Support\Facades\Route::has('plan.detail');
    $canOpenPlansPresentation = \Illuminate\Support\Facades\Route::has('plans.show');
    $plansPresentationUrl = $canOpenPlansPresentation ? route('plans.show') : url('/plans-detail');

    $cleanPlanText = function ($value, $limit = 140) {
        $raw = (string) ($value ?? '');
        $raw = str_ireplace(['<br>', '<br/>', '<br />', '</p>', '</div>', '</li>'], ' ', $raw);
        $raw = strip_tags($raw);
        $raw = preg_replace('/\s+/u', ' ', $raw);
        $raw = trim((string) $raw);
        return \Illuminate\Support\Str::limit($raw, $limit);
    };

    $planIconClass = function ($icon) {
        $raw = trim((string) ($icon ?? ''));
        if ($raw === '') {
            return 'fas fa-layer-group';
        }
        if (str_contains($raw, ' ')) {
            return $raw;
        }
        if (str_starts_with($raw, 'fa-')) {
            return 'fas ' . $raw;
        }
        return 'fas fa-' . ltrim($raw, '-');
    };

    $palette = [
        ['color' => '#e8761a', 'bg' => 'linear-gradient(135deg,#e8761a,#c04f10)'],
        ['color' => '#3b82f6', 'bg' => 'linear-gradient(135deg,#3b82f6,#1d4ed8)'],
        ['color' => '#10b981', 'bg' => 'linear-gradient(135deg,#10b981,#059669)'],
        ['color' => '#8b5cf6', 'bg' => 'linear-gradient(135deg,#8b5cf6,#6d28d9)'],
        ['color' => '#f59e0b', 'bg' => 'linear-gradient(135deg,#f59e0b,#d97706)'],
    ];

    $defaultFeatures = [
        'Activation rapide de votre espace',
        'Accompagnement stratégique',
        'Optimisation visibilité digitale',
        'Support technique prioritaire',
    ];

    $plansFromDb = collect();
    try {
        $plansFromDb = \App\Models\Plan::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'name', 'slug', 'description', 'icon', 'price', 'currency', 'billing_cycle', 'features', 'is_popular']);
    } catch (\Throwable $e) {
        $plansFromDb = collect();
    }

    $nlPlans = $plansFromDb->values()->map(function ($plan, $index) use ($palette, $planIconClass, $cleanPlanText, $defaultFeatures, $canOpenPlanDetail, $plansPresentationUrl) {
        $theme = $palette[$index % count($palette)];
        $cardUrl = ($plan->slug ?? '') !== ''
            ? url('/plan-detail/' . $plan->slug)
            : ($canOpenPlanDetail ? route('plan.detail', ['id' => $plan->id]) : $plansPresentationUrl);

        $features = is_array($plan->features) ? array_values(array_filter($plan->features, fn($f) => is_string($f) && trim($f) !== '')) : [];
        if (empty($features)) {
            $features = $defaultFeatures;
        }
        $features = array_slice($features, 0, 4);

        $priceRaw = $plan->getAttributes()['price'] ?? $plan->price;
        $priceNum = $priceRaw === null || $priceRaw === '' ? null : (float) $priceRaw;
        $billingSuffix = $plan->billing_cycle === 'yearly' ? '/an' : '/mois';
        $priceText = ($priceNum !== null && $priceNum > 0)
            ? number_format($priceNum, 0, ',', ' ') . ' ' . ($plan->currency ?: 'CAD') . ' ' . $billingSuffix
            : 'Sur demande';

        return [
            'icon' => $planIconClass($plan->icon ?? null),
            'color' => $theme['color'],
            'bg' => $theme['bg'],
            'label' => 'NEXT LEVEL',
            'title' => (string) ($plan->name ?? 'Plan GoExploria'),
            'desc' => $cleanPlanText($plan->description, 140) ?: 'Activez votre plan professionnel et accélérez votre croissance digitale.',
            'features' => $features,
            'cta' => 'Voir le plan',
            'url' => $cardUrl,
            'badge' => !empty($plan->is_popular) ? 'POPULAIRE' : null,
            'price' => $priceText,
        ];
    })->all();

    if (empty($nlPlans)) {
        $nlPlans = [
        [
            'icon'    => 'fas fa-building',
            'color'   => '#e8761a',
            'bg'      => 'linear-gradient(135deg,#e8761a,#c04f10)',
            'label'   => 'ENTREPRISES',
            'title'   => 'Espace Entreprise Pro',
            'desc'    => 'Site web complet, CRM, mail marketing, social media et analytics pour propulser votre business local et international.',
            'features'=> ['Site web multipage responsive','CRM & gestion contacts','Dashboard analytics','Intégrations API avancées'],
            'cta'     => 'Activer mon Espace',
            'url'     => 'next-level-entreprises',
            'badge'   => 'POPULAIRE',
        ],
        [
            'icon'    => 'fas fa-map-marked-alt',
            'color'   => '#3b82f6',
            'bg'      => 'linear-gradient(135deg,#3b82f6,#1d4ed8)',
            'label'   => 'DESTINATIONS',
            'title'   => 'Espace Destination',
            'desc'    => 'Vitrine touristique complète avec galerie photos, vidéos, carte interactive, avis clients et système de réservation.',
            'features'=> ['Page destination optimisée SEO','Galerie photos & vidéos HD','Système de réservation','Avis clients vérifiés'],
            'cta'     => 'Activer ma Destination',
            'url'     => 'next-level-destinations',
            'badge'   => 'NOUVEAU',
        ],
        [
            'icon'    => 'fas fa-handshake',
            'color'   => '#10b981',
            'bg'      => 'linear-gradient(135deg,#10b981,#059669)',
            'label'   => 'PARTENAIRES AFFILIÉS',
            'title'   => 'Programme Partenaire',
            'desc'    => 'Rejoignez notre réseau d\'affiliés et générez des revenus passifs en recommandant nos solutions à votre réseau professionnel.',
            'features'=> ['Commission jusqu\'à 30%','Tableau de bord affilié','Liens trackés personnalisés','Paiements mensuels automatiques'],
            'cta'     => 'Devenir Partenaire',
            'url'     => 'next-level-partenaires',
            'badge'   => 'RECOMMANDÉ',
        ],
        [
            'icon'    => 'fas fa-person-hiking',
            'color'   => '#8b5cf6',
            'bg'      => 'linear-gradient(135deg,#8b5cf6,#6d28d9)',
            'label'   => 'ACTIVITÉS',
            'title'   => 'Espace Activités',
            'desc'    => 'Référencez et gérez vos activités touristiques, sportives ou culturelles avec un système de réservation en ligne performant.',
            'features'=> ['Fiche activité enrichie','Calendrier & disponibilités','Réservation & paiement en ligne','Notifications automatiques'],
            'cta'     => 'Publier mes Activités',
            'url'     => 'next-level-activites',
            'badge'   => null,
        ],
        [
            'icon'    => 'fas fa-box-open',
            'color'   => '#f59e0b',
            'bg'      => 'linear-gradient(135deg,#f59e0b,#d97706)',
            'label'   => 'PRODUITS & SERVICES',
            'title'   => 'Espace Boutique',
            'desc'    => 'Créez votre boutique en ligne complète avec gestion des stocks, paiements sécurisés et livraison intégrée pour vendre partout.',
            'features'=> ['Boutique e-commerce complète','Gestion stock & variantes','Paiements multi-devises','Intégration livraison'],
            'cta'     => 'Ouvrir ma Boutique',
            'url'     => 'next-level-produits',
            'badge'   => 'HOT',
        ],
        ];
    }
@endphp

<section class="nl-plans-section" id="nl-plans">

    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="Plans Next Level">
                    <div class="logo-wrapper">
                        <img src="{{ asset('images/Next-level.png') }}" alt="Next Level">
                    </div>
                    <span class="resto-accord-btn-label">Plans Pro</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-star"></i> Premium</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('ACTIVEZ VOS PLANS NEXT LEVEL') }}</h1>
                <h2 class="resto-header-eyebrow">{{ $tr('Choisissez votre espace · Démarrez en 48h · Résultats garantis') }}</h2>
                <p class="resto-header-subtitle">{{ $tr('Des solutions clé-en-main pour chaque type d\'acteur : entreprises, destinations, partenaires, prestataires d\'activités et vendeurs de produits.') }}</p>
            </div>
            <div class="resto-header-logo-right">
                <a href="{{ url('next-level-plans') }}" title="{{ $tr('Tous les plans') }}" target="_blank" rel="noopener noreferrer">
                    <img class="bt-next-level-image" src="{{ asset('images/Next-level.png') }}" alt="{{ $tr('Next Level') }}" loading="lazy">
                </a>
            </div>
        </div>
        @include('home-v2.components.espace_next_level.SectionNavBarNextLevel')
        <div class="resto-header-shimmer"></div>
    </div>

    <div class="nl-plans-body">

        {{-- INTRO STRIP --}}
        <div class="nl-plans-intro">
            <div class="nl-plans-intro-text">
                <p>{{ $tr('GoExploria Next Level vous offre des espaces professionnels dédiés, pensés pour chaque acteur du tourisme et du commerce digital. Chaque plan inclut hébergement, SSL, support premium et accès à toutes nos fonctionnalités.') }}</p>
            </div>
            <div class="nl-plans-intro-stats">
                <div class="nl-intro-stat"><strong>5</strong><span>{{ $tr('Types d\'espaces') }}</span></div>
                <div class="nl-intro-stat"><strong>48h</strong><span>{{ $tr('Démarrage garanti') }}</span></div>
                <div class="nl-intro-stat"><strong>100%</strong><span>{{ $tr('Clé en main') }}</span></div>
                <div class="nl-intro-stat"><strong>24/7</strong><span>{{ $tr('Support inclus') }}</span></div>
            </div>
        </div>

        {{-- PLANS GRID --}}
        <div class="nl-plans-grid">
            @foreach($nlPlans as $plan)
            <div class="nl-plan-card {{ $plan['badge'] === 'POPULAIRE' ? 'nl-plan-featured' : '' }}">
                @if($plan['badge'])
                <div class="nl-plan-badge" style="background:{{ $plan['color'] }}">{{ $plan['badge'] }}</div>
                @endif
                <div class="nl-plan-icon-wrap" style="background:{{ $plan['bg'] }}">
                    <i class="{{ $plan['icon'] }}"></i>
                </div>
                <div class="nl-plan-label" style="color:{{ $plan['color'] }}">{{ $plan['label'] }}</div>
                <h3 class="nl-plan-title">{{ $tr($plan['title']) }}</h3>
                <p class="nl-plan-desc">{{ $tr($plan['desc']) }}</p>
                <ul class="nl-plan-features">
                    @foreach($plan['features'] as $f)
                    <li><i class="fas fa-check-circle" style="color:{{ $plan['color'] }}"></i> {{ $tr($f) }}</li>
                    @endforeach
                </ul>
                @if(!empty($plan['price']))
                <div class="nl-plan-price">{{ $plan['price'] }}</div>
                @endif
                @php
                    $planHref = str_starts_with((string) $plan['url'], 'http') ? $plan['url'] : url((string) $plan['url']);
                @endphp
                <a href="{{ $planHref }}" class="nl-plan-cta" style="background:{{ $plan['bg'] }}" target="_blank" rel="noopener noreferrer">
                    {{ $tr($plan['cta']) }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endforeach
        </div>

        {{-- COMPARATIF STRIP --}}
        <div class="nl-plans-compare-banner">
            <div class="nl-compare-left">
                <h3>{{ $tr('Pas sûr de quel plan choisir ?') }}</h3>
                <p>{{ $tr('Notre équipe vous guide gratuitement vers la solution la mieux adaptée à vos objectifs et à votre budget.') }}</p>
            </div>
            <div class="nl-compare-btns">
                <a href="{{ url('next-level-comparatif') }}" class="nl-compare-btn-primary" target="_blank">
                    <i class="fas fa-balance-scale"></i> {{ $tr('Comparer les plans') }}
                </a>
                <a href="{{ url('next-level-conseils') }}" class="nl-compare-btn-secondary" target="_blank">
                    <i class="fas fa-phone-alt"></i> {{ $tr('Parler à un expert') }}
                </a>
            </div>
        </div>

    </div>
</section>

<style>
.nl-plans-section { background: #fff; }
.nl-plans-body { padding: 0 40px 60px; }

.nl-plans-intro {
    display: flex; justify-content: space-between; align-items: center;
    gap: 40px; margin: 24px 0 40px; padding: 32px 40px;
    background: linear-gradient(135deg,#f8faff,#fff);
    border: 1px solid #e5e7eb; border-radius: 20px;
}
.nl-plans-intro-text p { font-size: 15px; color: #555; line-height: 1.8; max-width: 600px; }
.nl-plans-intro-stats { display: flex; gap: 32px; flex-shrink: 0; }
.nl-intro-stat { text-align: center; }
.nl-intro-stat strong { display: block; font-family: 'Bebas Neue', sans-serif; font-size: 42px; color: #e8761a; line-height: 1; }
.nl-intro-stat span { font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: 0.8px; margin-top: 4px; display: block; }

.nl-plans-grid { display: grid; grid-template-columns: repeat(5,1fr); gap: 18px; margin-bottom: 32px; }
.nl-plan-card {
    background: #fff; border: 2px solid #e5e7eb; border-radius: 24px; padding: 32px;
    position: relative; overflow: hidden; transition: all 0.3s; display: flex; flex-direction: column;
}
.nl-plan-card:hover { transform: translateY(-6px); box-shadow: 0 24px 60px rgba(0,0,0,0.1); }
.nl-plan-card.nl-plan-featured { border-color: #e8761a; background: linear-gradient(160deg,#fffbf7,#fff); }
.nl-plan-badge {
    position: absolute; top: 0; right: 0;
    color: #fff; font-size: 10px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.8px;
    padding: 5px 14px; border-radius: 0 22px 0 12px;
}
.nl-plan-icon-wrap {
    width: 60px; height: 60px; border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; color: #fff; margin-bottom: 16px;
}
.nl-plan-label { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 10px; }
.nl-plan-title { font-size: 17px; font-weight: 700; color: #1a1a1a; margin-bottom: 10px; line-height: 1.3; }
.nl-plan-desc { font-size: 13px; color: #666; line-height: 1.65; margin-bottom: 20px; flex: 1; }
.nl-plan-features { list-style: none; display: flex; flex-direction: column; gap: 8px; margin-bottom: 24px; }
.nl-plan-features li { font-size: 12px; color: #444; display: flex; align-items: flex-start; gap: 8px; line-height: 1.5; }
.nl-plan-features li i { font-size: 12px; flex-shrink: 0; margin-top: 2px; }
.nl-plan-price {
    display: inline-flex; align-self: flex-start;
    margin: 0 0 14px; padding: 5px 10px;
    border-radius: 999px; font-size: 11px; font-weight: 800;
    color: #fff; background: #1f2a44;
}
.nl-plan-cta {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    color: #fff; font-weight: 700; font-size: 13px; padding: 12px;
    border-radius: 10px; text-decoration: none; text-align: center;
    transition: all 0.2s;
}
.nl-plan-cta:hover { opacity: 0.9; transform: translateY(-1px); color: #fff; }

.nl-plans-compare-banner {
    background: linear-gradient(135deg,#0f2240,#1e3a5f); border-radius: 20px;
    padding: 40px 48px; display: flex; justify-content: space-between;
    align-items: center; gap: 40px;
}
.nl-compare-left h3 { font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 8px; }
.nl-compare-left p { font-size: 14px; color: rgba(255,255,255,0.7); line-height: 1.7; max-width: 500px; }
.nl-compare-btns { display: flex; gap: 12px; flex-shrink: 0; }
.nl-compare-btn-primary {
    background: #e8761a; color: #fff; padding: 14px 24px; border-radius: 10px;
    font-weight: 700; font-size: 14px; text-decoration: none;
    display: inline-flex; align-items: center; gap: 8px; white-space: nowrap;
}
.nl-compare-btn-secondary {
    border: 2px solid rgba(255,255,255,0.3); color: #fff; padding: 14px 24px;
    border-radius: 10px; font-weight: 700; font-size: 14px; text-decoration: none;
    display: inline-flex; align-items: center; gap: 8px; white-space: nowrap;
}
.nl-compare-btn-secondary:hover { border-color: #fff; color: #fff; }

@media(max-width:1300px) { .nl-plans-grid { grid-template-columns: repeat(3,1fr); } }
@media(max-width:900px) { .nl-plans-grid { grid-template-columns: repeat(2,1fr); } .nl-plans-intro { flex-direction: column; } .nl-plans-compare-banner { flex-direction: column; } }
@media(max-width:640px) { .nl-plans-body { padding: 0 16px 40px; } .nl-plans-grid { grid-template-columns: 1fr; } .nl-plans-intro-stats { flex-wrap: wrap; gap: 20px; } }
</style>
