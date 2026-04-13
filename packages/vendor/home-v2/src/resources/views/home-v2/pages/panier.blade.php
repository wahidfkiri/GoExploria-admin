<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier &mdash; GoExploria</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-destinations-mega.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Montserrat',sans-serif;background:#f4f6f9;color:#0a1628;overflow-x:hidden}

        /* Page Banner */
        .page-banner{background:linear-gradient(135deg,#0a1628,#1a2942);padding:32px 40px;position:relative;overflow:hidden}
        .page-banner::before{content:'';position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1400&q=80') center/cover;opacity:.07}
        .page-banner-inner{position:relative;z-index:1;max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap}
        .banner-title{font-size:1.6rem;font-weight:900;color:#fff;display:flex;align-items:center;gap:12px}
        .banner-title i{color:#d4af37}
        .banner-sub{font-size:12px;color:rgba(255,255,255,.5);margin-top:4px}
        .progress-steps{display:flex;align-items:center;gap:0}
        .pstep{display:flex;align-items:center;gap:0}
        .pstep-item{display:flex;align-items:center;gap:7px;padding:7px 14px;border-radius:20px;font-size:11px;font-weight:700;color:rgba(255,255,255,.5)}
        .pstep-item.active{background:rgba(212,175,55,.2);color:#d4af37;border:1px solid rgba(212,175,55,.3)}
        .pstep-item .dot{width:18px;height:18px;border-radius:50%;background:rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:900}
        .pstep-item.active .dot{background:#d4af37;color:#0a1628}
        .pstep-item.done .dot{background:#2dc653;color:#fff}
        .pstep-item.done{color:rgba(255,255,255,.6)}
        .pstep-arrow{color:rgba(255,255,255,.2);font-size:10px;padding:0 6px}

        /* Layout */
        .page-wrap{max-width:1200px;margin:150px auto 0;padding:40px 32px 60px}
        .cart-grid{display:grid;grid-template-columns:1fr 360px;gap:28px;align-items:start}

        /* Cart Items */
        .cart-items{display:flex;flex-direction:column;gap:16px}
        .cart-item{background:#fff;border-radius:14px;padding:20px;box-shadow:0 2px 12px rgba(0,0,0,.05);display:flex;gap:18px;align-items:flex-start;transition:all .2s}
        .cart-item:hover{box-shadow:0 4px 20px rgba(0,0,0,.09)}
        .ci-img{width:110px;height:80px;border-radius:10px;object-fit:cover;flex-shrink:0}
        .ci-body{flex:1;min-width:0}
        .ci-type{font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px}
        .type-forfait{color:#4361ee}.type-activite{color:#2dc653}.type-resto{color:#e63946}.type-heb{color:#c9980a}
        .ci-name{font-size:14px;font-weight:800;color:#0a1628;margin-bottom:5px;line-height:1.25}
        .ci-meta{display:flex;flex-wrap:wrap;gap:12px;margin-bottom:10px}
        .ci-meta-item{display:flex;align-items:center;gap:5px;font-size:11.5px;color:#6b7280;font-weight:500}
        .ci-meta-item i{color:#9ba3af;font-size:11px;width:13px}
        .ci-controls{display:flex;align-items:center;gap:10px}
        .qty-ctrl{display:flex;align-items:center;gap:8px;border:1.5px solid #e5e7eb;border-radius:8px;padding:4px 10px}
        .qty-btn{background:none;border:none;cursor:pointer;color:#6b7280;font-size:15px;font-weight:700;line-height:1;padding:0 2px;transition:color .18s}
        .qty-btn:hover{color:#0a1628}
        .qty-val{font-size:13px;font-weight:800;color:#0a1628;width:18px;text-align:center}
        .ci-save{font-size:11px;font-weight:700;color:#4361ee;text-decoration:none;cursor:pointer;background:none;border:none;font-family:'Montserrat',sans-serif;transition:all .2s}
        .ci-save:hover{text-decoration:underline}
        .ci-delete{font-size:11px;font-weight:700;color:#e63946;text-decoration:none;cursor:pointer;background:none;border:none;font-family:'Montserrat',sans-serif;transition:all .2s}
        .ci-delete:hover{text-decoration:underline}
        .ci-price{text-align:right;flex-shrink:0}
        .ci-price .amount{font-size:16px;font-weight:900;color:#0a1628}
        .ci-price .per{font-size:10px;color:#9ba3af;font-weight:500;margin-top:2px}
        .ci-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 8px;background:rgba(45,198,83,.1);border-radius:6px;font-size:10px;font-weight:700;color:#2dc653;margin-top:6px}

        /* Section title */
        .section-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
        .section-head-title{font-size:12px;font-weight:800;color:#0a1628;letter-spacing:.5px}
        .section-head-action{font-size:11.5px;font-weight:700;color:#e63946;text-decoration:none;cursor:pointer;border:none;background:none;font-family:'Montserrat',sans-serif}
        .section-head-action:hover{text-decoration:underline}

        /* Order Summary */
        .summary-card{background:#fff;border-radius:16px;padding:28px;box-shadow:0 2px 16px rgba(0,0,0,.06);position:sticky;top:80px}
        .summary-title{font-size:14px;font-weight:800;color:#0a1628;margin-bottom:22px;display:flex;align-items:center;gap:8px}
        .summary-title i{color:#d4af37}
        .sum-row{display:flex;justify-content:space-between;align-items:center;font-size:13px;padding:8px 0;border-bottom:1px solid #f3f4f6}
        .sum-row:last-of-type{border-bottom:none}
        .sum-key{color:#6b7280;font-weight:500}
        .sum-val{font-weight:700;color:#0a1628}
        .sum-discount{color:#2dc653}
        .sum-total{display:flex;justify-content:space-between;align-items:center;padding:16px 0 0;margin-top:8px;border-top:2px solid #0a1628}
        .sum-total-key{font-size:14px;font-weight:800;color:#0a1628}
        .sum-total-val{font-size:1.4rem;font-weight:900;color:#0a1628}

        /* Promo */
        .promo-wrap{margin:18px 0}
        .promo-input-row{display:flex;gap:8px}
        .promo-input{flex:1;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:'Montserrat',sans-serif;font-size:12px;color:#0a1628;outline:none;transition:all .2s}
        .promo-input:focus{border-color:#d4af37;box-shadow:0 0 0 3px rgba(212,175,55,.1)}
        .promo-btn{padding:10px 16px;background:#0a1628;color:#fff;border:none;border-radius:8px;font-family:'Montserrat',sans-serif;font-size:12px;font-weight:700;cursor:pointer;white-space:nowrap;transition:all .2s}
        .promo-btn:hover{background:#1a2942}

        /* CTA */
        .btn-checkout{width:100%;padding:15px;background:linear-gradient(135deg,#d4af37,#c9980a);color:#0a1628;border:none;border-radius:12px;font-family:'Montserrat',sans-serif;font-size:14px;font-weight:800;letter-spacing:.8px;text-transform:uppercase;cursor:pointer;transition:all .25s;display:flex;align-items:center;justify-content:center;gap:10px;margin-top:6px}
        .btn-checkout:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(212,175,55,.4)}
        .btn-continue{width:100%;padding:11px;border:1.5px solid #e5e7eb;background:#fff;color:#374151;border-radius:10px;font-family:'Montserrat',sans-serif;font-size:12px;font-weight:700;cursor:pointer;transition:all .2s;margin-top:10px;display:flex;align-items:center;justify-content:center;gap:8px}
        .btn-continue:hover{border-color:#0a1628;color:#0a1628}

        /* Trust */
        .trust-row{display:flex;flex-direction:column;gap:8px;margin-top:18px;padding-top:16px;border-top:1px solid #f3f4f6}
        .trust-item{display:flex;align-items:center;gap:8px;font-size:11.5px;color:#6b7280}
        .trust-item i{color:#2dc653;width:14px;font-size:12px}

        /* Suggestions */
        .sugg-section{margin-top:40px}
        .sugg-title{font-size:1.1rem;font-weight:800;color:#0a1628;margin-bottom:16px;display:flex;align-items:center;gap:8px}
        .sugg-title i{color:#d4af37}
        .sugg-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
        .sugg-card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.05);transition:all .2s;cursor:pointer}
        .sugg-card:hover{transform:translateY(-3px);box-shadow:0 6px 22px rgba(0,0,0,.1)}
        .sugg-img{aspect-ratio:16/9;overflow:hidden}
        .sugg-img img{width:100%;height:100%;object-fit:cover;transition:transform .3s}
        .sugg-card:hover .sugg-img img{transform:scale(1.05)}
        .sugg-body{padding:14px 16px}
        .sugg-name{font-size:13px;font-weight:800;color:#0a1628;margin-bottom:3px}
        .sugg-price{font-size:12px;font-weight:700;color:#4361ee}
        .sugg-add{display:flex;justify-content:flex-end;margin-top:10px}
        .sbtn-add{display:inline-flex;align-items:center;gap:5px;padding:7px 14px;background:#f4f6f9;border-radius:7px;font-size:11px;font-weight:700;color:#374151;border:1.5px solid #e5e7eb;transition:all .2s;border:none;cursor:pointer;font-family:'Montserrat',sans-serif}
        .sbtn-add:hover{background:#0a1628;color:#fff}

        @media(max-width:960px){.cart-grid{grid-template-columns:1fr}.summary-card{position:static}.sugg-grid{grid-template-columns:repeat(2,1fr)}}
        @media(max-width:640px){.page-wrap{padding:28px 16px}.page-banner{padding:24px 20px}.progress-steps{display:none}.cart-item{flex-direction:column}.ci-img{width:100%;height:160px}.sugg-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>

@include('home-v2.components.VerticalMenu')
@include('home-v2.components.Header')

<div class="page-wrap">
    <div class="cart-grid">

        {{-- Articles --}}
        <div>
            <div class="section-head">
                <div class="section-head-title">Articles (3)</div>
                <button class="section-head-action"><i class="fas fa-trash-alt"></i> Vider le panier</button>
            </div>
            <div class="cart-items">

                {{-- Item 1 --}}
                <div class="cart-item">
                    <img class="ci-img" src="https://images.unsplash.com/photo-1519003722824-194d4455a60c?w=300&q=80" alt="Qu&eacute;bec">
                    <div class="ci-body">
                        <div class="ci-type type-forfait"><i class="fas fa-suitcase-rolling"></i> Forfait voyage</div>
                        <div class="ci-name">Forfait Qu&eacute;bec City &amp; Charlevoix &mdash; 7 nuits</div>
                        <div class="ci-meta">
                            <span class="ci-meta-item"><i class="fas fa-calendar"></i> 15 &mdash; 22 juin 2025</span>
                            <span class="ci-meta-item"><i class="fas fa-users"></i> 2 adultes</span>
                            <span class="ci-meta-item"><i class="fas fa-hotel"></i> H&ocirc;tel 4 &eacute;toiles</span>
                        </div>
                        <div class="ci-controls">
                            <div class="qty-ctrl">
                                <button class="qty-btn" type="button">-</button>
                                <span class="qty-val">1</span>
                                <button class="qty-btn" type="button">+</button>
                            </div>
                            <button class="ci-save"><i class="fas fa-heart"></i> Sauvegarder</button>
                            <button class="ci-delete"><i class="fas fa-trash"></i> Supprimer</button>
                        </div>
                    </div>
                    <div class="ci-price">
                        <div class="amount">3 240 $</div>
                        <div class="per">2 pers. / 7 nuits</div>
                        <div class="ci-badge"><i class="fas fa-tag"></i> -15&nbsp;%</div>
                    </div>
                </div>

                {{-- Item 2 --}}
                <div class="cart-item">
                    <img class="ci-img" src="https://images.unsplash.com/photo-1504704911898-68304a7d2807?w=300&q=80" alt="Ski">
                    <div class="ci-body">
                        <div class="ci-type type-activite"><i class="fas fa-skiing"></i> Activit&eacute;</div>
                        <div class="ci-name">Journee de ski &mdash; Mont-Tremblant + &eacute;cole de ski</div>
                        <div class="ci-meta">
                            <span class="ci-meta-item"><i class="fas fa-calendar"></i> 16 juin 2025</span>
                            <span class="ci-meta-item"><i class="fas fa-users"></i> 2 adultes</span>
                            <span class="ci-meta-item"><i class="fas fa-snowflake"></i> Inclus : mat&eacute;riel</span>
                        </div>
                        <div class="ci-controls">
                            <div class="qty-ctrl">
                                <button class="qty-btn" type="button">-</button>
                                <span class="qty-val">2</span>
                                <button class="qty-btn" type="button">+</button>
                            </div>
                            <button class="ci-save"><i class="fas fa-heart"></i> Sauvegarder</button>
                            <button class="ci-delete"><i class="fas fa-trash"></i> Supprimer</button>
                        </div>
                    </div>
                    <div class="ci-price">
                        <div class="amount">168 $</div>
                        <div class="per">2 &times; 84 $ / journ&eacute;e</div>
                    </div>
                </div>

                {{-- Item 3 --}}
                <div class="cart-item">
                    <img class="ci-img" src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=300&q=80" alt="Restaurant">
                    <div class="ci-body">
                        <div class="ci-type type-resto"><i class="fas fa-utensils"></i> R&eacute;servation restaurant</div>
                        <div class="ci-name">Le Mousso &mdash; Menu d&eacute;gustation 8 services</div>
                        <div class="ci-meta">
                            <span class="ci-meta-item"><i class="fas fa-calendar"></i> 17 juin 2025, 19 h 30</span>
                            <span class="ci-meta-item"><i class="fas fa-users"></i> 2 couverts</span>
                            <span class="ci-meta-item"><i class="fas fa-wine-glass-alt"></i> Accord vins inclus</span>
                        </div>
                        <div class="ci-controls">
                            <button class="ci-save"><i class="fas fa-heart"></i> Sauvegarder</button>
                            <button class="ci-delete"><i class="fas fa-trash"></i> Supprimer</button>
                        </div>
                    </div>
                    <div class="ci-price">
                        <div class="amount">440 $</div>
                        <div class="per">2 &times; 220 $ / couvert</div>
                    </div>
                </div>

            </div>

            {{-- Suggestions --}}
            <div class="sugg-section">
                <div class="sugg-title"><i class="fas fa-lightbulb"></i> Vous aimerez aussi</div>
                <div class="sugg-grid">
                    <div class="sugg-card">
                        <div class="sugg-img"><img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400&q=80" alt="Kayak"></div>
                        <div class="sugg-body">
                            <div class="sugg-name">Kayak &mdash; Saguenay</div>
                            <div class="sugg-price">D&egrave;s 149 $ / pers.</div>
                            <div class="sugg-add"><button class="sbtn-add" type="button"><i class="fas fa-plus"></i> Ajouter</button></div>
                        </div>
                    </div>
                    <div class="sugg-card">
                        <div class="sugg-img"><img src="https://images.unsplash.com/photo-1445019980597-93fa8acb246c?w=400&q=80" alt="H&ocirc;tel"></div>
                        <div class="sugg-body">
                            <div class="sugg-name">Ch&acirc;teau Frontenac</div>
                            <div class="sugg-price">D&egrave;s 389 $ / nuit</div>
                            <div class="sugg-add"><button class="sbtn-add" type="button"><i class="fas fa-plus"></i> Ajouter</button></div>
                        </div>
                    </div>
                    <div class="sugg-card">
                        <div class="sugg-img"><img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=400&q=80" alt="SPA"></div>
                        <div class="sugg-body">
                            <div class="sugg-name">Spa Nordique Charlevoix</div>
                            <div class="sugg-price">D&egrave;s 95 $ / pers.</div>
                            <div class="sugg-add"><button class="sbtn-add" type="button"><i class="fas fa-plus"></i> Ajouter</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Summary --}}
        <div class="summary-card">
            <div class="summary-title"><i class="fas fa-receipt"></i> R&eacute;capitulatif</div>

            <div class="sum-row"><span class="sum-key">Forfait Qu&eacute;bec 7 nuits</span><span class="sum-val">3 240 $</span></div>
            <div class="sum-row"><span class="sum-key">Ski Mont-Tremblant (x2)</span><span class="sum-val">168 $</span></div>
            <div class="sum-row"><span class="sum-key">Restaurant Le Mousso (x2)</span><span class="sum-val">440 $</span></div>
            <div class="sum-row"><span class="sum-key">Sous-total</span><span class="sum-val">3 848 $</span></div>
            <div class="sum-row"><span class="sum-key">Rabais membre (15&nbsp;%)</span><span class="sum-val sum-discount">-486 $</span></div>
            <div class="sum-row"><span class="sum-key">Frais de service</span><span class="sum-val">49 $</span></div>
            <div class="sum-row"><span class="sum-key">TPS (5&nbsp;%)</span><span class="sum-val">170 $</span></div>
            <div class="sum-row"><span class="sum-key">TVQ (9,975&nbsp;%)</span><span class="sum-val">339 $</span></div>
            <div class="sum-total">
                <span class="sum-total-key">Total</span>
                <span class="sum-total-val">3 920 $</span>
            </div>

            <div class="promo-wrap">
                <div style="font-size:11px;font-weight:700;color:#374151;margin-bottom:7px;text-transform:uppercase;letter-spacing:.5px">Code promo</div>
                <div class="promo-input-row">
                    <input class="promo-input" type="text" placeholder="Ex. : GOEXPLORIA20">
                    <button class="promo-btn" type="button">Appliquer</button>
                </div>
            </div>

            <button class="btn-checkout" type="button">
                <i class="fas fa-lock"></i> Proc&eacute;der au paiement
            </button>
            <button class="btn-continue" type="button" onclick="window.location.href='{{ url('/') }}'">
                <i class="fas fa-arrow-left"></i> Continuer mes achats
            </button>

            <div class="trust-row">
                <div class="trust-item"><i class="fas fa-shield-alt"></i> Paiement 100&nbsp;% s&eacute;curis&eacute; (SSL)</div>
                <div class="trust-item"><i class="fas fa-undo"></i> Remboursement garanti sous 14 jours</div>
                <div class="trust-item"><i class="fas fa-headset"></i> Support 24&nbsp;h&thinsp;/&thinsp;7 pendant votre voyage</div>
                <div class="trust-item"><i class="fas fa-credit-card"></i> Visa, Mastercard, PayPal, Interac</div>
            </div>
        </div>
    </div>
</div>

@include('home-v2.components.Footer')

<script src="{{ asset('js/home-v2/navigation.js') }}"></script>
<script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
<script src="{{ asset('js/home-v2/mega-menu-service.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-destinations-mega.js') }}"></script>
<script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/destinations-mega-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
</body>
</html>
