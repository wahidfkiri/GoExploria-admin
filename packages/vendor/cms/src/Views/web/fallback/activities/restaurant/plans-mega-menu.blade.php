@php
    $canOpenPlanDetail = \Illuminate\Support\Facades\Route::has('plan.detail');
    $canOpenPlansPresentation = \Illuminate\Support\Facades\Route::has('plans.show');
    $plansForMegaMenu = collect();

    try {
        $plansForMegaMenu = \App\Models\Plan::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'name', 'slug', 'description', 'icon', 'price', 'currency', 'billing_cycle']);
    } catch (\Throwable $e) {
        $plansForMegaMenu = collect();
    }

    $plansPresentationUrl = $canOpenPlansPresentation ? route('plans.show') : url('/plans-detail');

    $cleanPlanText = function ($value, $limit = 95) {
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

    $plansMegaCards = [
        [
            'title' => 'ESPACES ENTREPRISES',
            'description' => 'ACTIVEZ VOS ESPACES ENTREPRISES ICI',
            'price' => 'À partir de 299 CAD / mois',
            'icon' => 'fas fa-building',
            'color' => 'plans-mega-card-enterprise',
            'fallback' => $plansPresentationUrl,
        ],
        [
            'title' => 'ESPACES DESTINATIONS',
            'description' => 'ACTIVEZ VOS ESPACES DESTINATION ICI',
            'price' => 'À partir de 249 CAD / mois',
            'icon' => 'fas fa-map-marked-alt',
            'color' => 'plans-mega-card-destination',
            'fallback' => $plansPresentationUrl,
        ],
        [
            'title' => 'ESPACE ACTIVITÉ → PRODUITS & SERVICES',
            'description' => 'ACTIVER VOTRE ESPACE ACTIVITÉ AVEC LIENS DIRECT',
            'price' => 'À partir de 199 CAD / mois',
            'icon' => 'fas fa-box-open',
            'color' => 'plans-mega-card-activity',
            'fallback' => $plansPresentationUrl,
        ],
        [
            'title' => 'ESPACES PARTENAIRES AFFILIÉS',
            'description' => 'ACTIVEZ VOS ESPACES PARTENAIRES AFFILIÉS ICI',
            'price' => 'À partir de 179 CAD / mois',
            'icon' => 'fas fa-handshake',
            'color' => 'plans-mega-card-partner',
            'fallback' => $plansPresentationUrl,
        ],
        [
            'title' => 'ESPACES PERSO',
            'description' => 'ACTIVEZ VOS ESPACES PERSO ICI',
            'price' => 'À partir de 99 CAD / mois',
            'icon' => 'fas fa-user-circle',
            'color' => 'plans-mega-card-personal',
            'fallback' => $plansPresentationUrl,
        ],
    ];

    $plansMegaColors = [
        'plans-mega-card-enterprise',
        'plans-mega-card-destination',
        'plans-mega-card-activity',
        'plans-mega-card-partner',
        'plans-mega-card-personal',
    ];
@endphp

<div class="plans-mega-v2-overlay" id="plansMegaOverlay"></div>
<div class="plans-mega-v2" id="plansMegaMenu" aria-hidden="true">
    <button class="plans-mega-v2-close" id="plansMegaClose" aria-label="Fermer">
        <i class="fas fa-times"></i>
    </button>
    <div class="plans-mega-v2-head">
        <div class="plans-mega-v2-kicker">PASSEZ AU NIVEAU SUPÉRIEURE</div>
        <h3>PLANS GO EXPLORIA - NEXT LEVEL</h3>
        <!-- <p class="plans-mega-v2-intro">
            GO EXPLORIA BUSINESS - NEXT LEVEL, c'est :
        </p>
        <ul class="plans-mega-v2-points">
            <li>✔ Un investissement marketing massif</li>
            <li>✔ Une plateforme technologique complète</li>
            <li>✔ Une visibilité internationale immédiate</li>
            <li>✔ Des performances mesurables et rentables</li>
            <li>✔ Une solution conçue pour propulser les entreprises vers une croissance rapide et durable à l'échelle mondiale.</li>
        </ul> -->
        <!-- <p class="plans-mega-v2-cta-main">PASSEZ AU NIVEAU SUPÉRIEURE</p>
        <p class="plans-mega-v2-cta-title">GO EXPLORIA BUSINESS - NEXT LEVEL</p>
        <p>Plateforme marketing régional, national et internationale, votre croissance au cœur de nos offres!</p> -->
        <p class="plans-mega-v2-cta-end"> OBTENEZ DES RÉSULTATS CONCRET.</p>
        <a href="{{ url('espace-next-level/plans') }}" class="plans-mega-v2-cta-link" target="_blank" rel="noopener noreferrer">
            <span class="plans-mega-v2-cta-button">
                <i class="fas fa-external-link-alt"></i> En savoir plus 
            </span>
        </a>
    </div>

    <div class="plans-mega-v2-grid">
        @if ($plansForMegaMenu->isNotEmpty())
            @foreach ($plansForMegaMenu as $index => $plan)
                @php
                    $cardColor = $plansMegaColors[$index % count($plansMegaColors)];
                    $cardUrl = ($plan->slug ?? '') !== ''
                        ? url('/plan-detail/' . $plan->slug)
                        : ($canOpenPlanDetail ? route('plan.detail', ['id' => $plan->id]) : $plansPresentationUrl);
                    $cardTitle = (string) ($plan->name ?? 'Plan GoExploria');
                    $cardDescription = $cleanPlanText($plan->description, 95) ?: 'Activez votre espace plan ici.';
                    $cardIcon = $planIconClass($plan->icon ?? null);
                    $priceRaw = $plan->getAttributes()['price'] ?? $plan->price;
                    $priceNum = $priceRaw === null || $priceRaw === '' ? null : (float) $priceRaw;
                    $hasPublishedPrice = $priceNum !== null && $priceNum > 0;
                    $billingSuffix = $plan->billing_cycle === 'yearly' ? '/an' : '/mois';
                    $cardPrice = $hasPublishedPrice
                        ? (number_format($priceNum, 0, ',', ' ') . ' ' . ($plan->currency ?: 'CAD') . ' ' . $billingSuffix)
                        : 'Sur demande';
                @endphp
                <a href="{{ $cardUrl }}" class="plans-mega-v2-card {{ $cardColor }}">
                    <div class="plans-mega-v2-card-icon"><i class="{{ $cardIcon }}"></i></div>
                    <div class="plans-mega-v2-card-title">{{ $cardTitle }}</div>
                    <div class="plans-mega-v2-card-desc">{{ $cardDescription }}</div>
                    <div class="plans-mega-v2-card-price">{{ $cardPrice }}</div>
                    <div class="plans-mega-v2-card-plan">{{ $plan->name }}</div>
                </a>
            @endforeach
        @else
            @foreach ($plansMegaCards as $card)
                <a href="{{ $card['fallback'] }}" class="plans-mega-v2-card {{ $card['color'] }}">
                    <div class="plans-mega-v2-card-icon"><i class="{{ $card['icon'] }}"></i></div>
                    <div class="plans-mega-v2-card-title">{{ $card['title'] }}</div>
                    <div class="plans-mega-v2-card-desc">{{ $card['description'] }}</div>
                    <div class="plans-mega-v2-card-price">{{ $card['price'] }}</div>
                </a>
            @endforeach
        @endif
    </div>
</div>

<style>
    .plans-mega-v2-overlay {
        position: fixed;
        inset: 0;
        background: rgba(8, 16, 32, 0.44);
        backdrop-filter: blur(2px);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.22s ease, visibility 0.22s ease;
        z-index: 10010;
    }

    .plans-mega-v2 {
        position: fixed;
        top: 88px;
        left: 50%;
        transform: translateX(-50%) translateY(-12px);
        width: min(1260px, calc(100vw - 36px));
        background: linear-gradient(180deg, #ffffff 0%, #f7f9fc 100%);
        border: 1px solid rgba(26, 41, 66, 0.1);
        border-radius: 20px;
        box-shadow: 0 34px 55px rgba(8, 20, 44, 0.22);
        padding: 24px;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.26s ease, transform 0.26s ease, visibility 0.26s ease;
        z-index: 10020;
    }

    .plans-mega-v2.active,
    .plans-mega-v2-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .plans-mega-v2.active {
        transform: translateX(-50%) translateY(0);
    }

    .plans-mega-v2-close {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 1px solid rgba(16, 32, 58, 0.2);
        background: #ffffff;
        color: #10203a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform 0.18s ease, background 0.18s ease, color 0.18s ease;
        z-index: 2;
    }

    .plans-mega-v2-close:hover {
        transform: translateY(-1px);
        background: #10203a;
        color: #ffffff;
    }

    .plans-mega-v2-head {
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1px solid rgba(26, 41, 66, 0.1);
        text-align: center;
    }

    .plans-mega-v2-kicker {
        color: #c89c2f;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .plans-mega-v2-head h3 {
        margin: 0 0 7px;
        color: #10203a;
        font-size: 28px;
        line-height: 1.18;
        font-weight: 900;
        text-transform: uppercase;
    }

    .plans-mega-v2-head p {
        margin: 0;
        color: #3d4d66;
        font-size: 14px;
        line-height: 1.5;
        max-width: 760px;
        margin-left: auto;
        margin-right: auto;
    }

    .plans-mega-v2-intro {
        font-weight: 700;
        margin-bottom: 8px !important;
    }

    .plans-mega-v2-points {
        list-style: none;
        margin: 0 auto 10px;
        padding: 0;
        max-width: 760px;
        text-align: left;
        display: grid;
        gap: 4px;
    }

    .plans-mega-v2-points li {
        color: #253754;
        font-size: 14px;
        line-height: 1.45;
        font-weight: 600;
    }

    .plans-mega-v2-cta-main {
        margin-top: 4px !important;
        color: #c89c2f !important;
        font-size: 13px !important;
        font-weight: 900 !important;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .plans-mega-v2-cta-title {
        margin-top: 2px !important;
        margin-bottom: 4px !important;
        color: #10203a !important;
        font-size: 16px !important;
        font-weight: 900 !important;
        text-transform: uppercase;
    }

    .plans-mega-v2-cta-end {
        margin-top: 6px !important;
        color: #10203a !important;
        font-size: 13px !important;
        font-weight: 900 !important;
        text-transform: uppercase;
    }

    .plans-mega-v2-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 14px;
    }

    .plans-mega-v2-card {
        text-decoration: none;
        border-radius: 16px;
        padding: 15px 13px;
        min-height: 185px;
        color: #fff;
        display: flex;
        flex-direction: column;
        gap: 8px;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 14px 26px rgba(16, 25, 45, 0.22);
    }

    .plans-mega-v2-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 30px rgba(16, 25, 45, 0.28);
    }

    .plans-mega-v2-card-icon {
        font-size: 22px;
        margin-bottom: 2px;
    }

    .plans-mega-v2-card-title {
        font-weight: 800;
        font-size: 15px;
        line-height: 1.35;
        text-transform: uppercase;
        min-height: 44px;
    }

    .plans-mega-v2-card-desc {
        font-size: 13.5px;
        line-height: 1.35;
        opacity: 0.95;
    }

    .plans-mega-v2-card-price {
        display: inline-flex;
        align-self: flex-start;
        margin-top: 2px;
        padding: 4px 9px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.4);
        font-size: 11.5px;
        font-weight: 800;
        letter-spacing: 0.01em;
    }

    .plans-mega-v2-card-plan {
        font-size: 12.5px;
        font-weight: 700;
        opacity: 0.98;
        border-top: 1px solid rgba(255, 255, 255, 0.3);
        padding-top: 8px;
    }

    .plans-mega-card-enterprise { background: linear-gradient(145deg, #1f4fa6, #243f7b); }
    .plans-mega-card-destination { background: linear-gradient(145deg, #067f73, #0c5b63); }
    .plans-mega-card-activity { background: linear-gradient(145deg, #a34a24, #7b3218); }
    .plans-mega-card-partner { background: linear-gradient(145deg, #6b3aa0, #4a2c72); }
    .plans-mega-card-personal { background: linear-gradient(145deg, #b08a22, #8a6612); }

    @media (max-width: 1220px) {
        .plans-mega-v2-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 900px) {
        .plans-mega-v2 {
            top: 66px;
            width: calc(100vw - 20px);
            padding: 16px;
            max-height: calc(100vh - 80px);
            overflow-y: auto;
        }

        .plans-mega-v2-head h3 {
            font-size: 20px;
        }

        .plans-mega-v2-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }
    }

    @media (max-width: 620px) {
        .plans-mega-v2-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    (function() {
        const trigger = document.getElementById('plansMenuItem');
        const triggerLink = document.getElementById('plansMenuTrigger');
        const menu = document.getElementById('plansMegaMenu');
        const overlay = document.getElementById('plansMegaOverlay');
        const closeBtn = document.getElementById('plansMegaClose');
        const header = document.querySelector('.header-v2');
        if (!trigger || !menu || !overlay) return;

        let closeTimer = null;

        function positionMenu() {
            if (!header) return;
            const headerRect = header.getBoundingClientRect();
            menu.style.top = Math.max(64, Math.round(headerRect.bottom + 8)) + 'px';
        }

        function openPlansMenu() {
            clearTimeout(closeTimer);
            positionMenu();
            menu.classList.add('active');
            overlay.classList.add('active');
            trigger.classList.add('active');
            menu.setAttribute('aria-hidden', 'false');
        }

        function closePlansMenu() {
            menu.classList.remove('active');
            overlay.classList.remove('active');
            trigger.classList.remove('active');
            menu.setAttribute('aria-hidden', 'true');
        }

        function scheduleClose() {
            clearTimeout(closeTimer);
            closeTimer = setTimeout(closePlansMenu, 400);
        }

        function cancelClose() {
            clearTimeout(closeTimer);
        }

        // Logique identique à "Nos services"
        trigger.addEventListener('mouseenter', function() {
            cancelClose();
            openPlansMenu();
        });
        trigger.addEventListener('mouseleave', scheduleClose);

        menu.addEventListener('mouseenter', cancelClose);
        menu.addEventListener('mouseleave', scheduleClose);

        overlay.addEventListener('mouseenter', cancelClose);
        overlay.addEventListener('mouseleave', scheduleClose);

        if (triggerLink) {
            triggerLink.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                cancelClose();
                if (window.innerWidth <= 900 && menu.classList.contains('active')) {
                    closePlansMenu();
                    return;
                }
                openPlansMenu();
            });
        }

        overlay.addEventListener('click', closePlansMenu);
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closePlansMenu();
            });
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePlansMenu();
            }
        });
        window.addEventListener('resize', positionMenu);
        window.addEventListener('scroll', positionMenu, { passive: true });
        document.addEventListener('click', function(e) {
            if (!menu.contains(e.target) && !trigger.contains(e.target)) {
                closePlansMenu();
            }
        });
    })();
</script>

