<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de Devis &mdash; GoExploria</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-destinations-mega.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Montserrat',sans-serif;background:#f4f6f9;color:#0a1628;overflow-x:hidden}

        /* Page Banner */
        .page-banner{background:linear-gradient(135deg,#0a1628,#1a2942);padding:48px 40px;text-align:center;position:relative;overflow:hidden}
        .page-banner::before{content:'';position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1400&q=80') center/cover;opacity:.08}
        .page-banner-inner{position:relative;z-index:1;max-width:700px;margin:0 auto}
        .page-banner-badge{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;background:rgba(212,175,55,.15);border:1px solid rgba(212,175,55,.3);border-radius:20px;font-size:11px;font-weight:700;color:#d4af37;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:14px}
        .page-banner-title{font-size:clamp(1.6rem,3.5vw,2.4rem);font-weight:900;color:#fff;margin-bottom:8px;line-height:1.15}
        .page-banner-title span{color:#d4af37}
        .page-banner-sub{font-size:14px;color:rgba(255,255,255,.6);line-height:1.6;margin-bottom:28px}
        .step-chips{display:flex;justify-content:center;gap:0;flex-wrap:wrap}
        .step-chip{display:flex;align-items:center;gap:0}
        .step-pill{display:flex;align-items:center;gap:8px;padding:8px 16px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:20px;font-size:11px;font-weight:700;color:rgba(255,255,255,.7)}
        .step-pill.active{background:rgba(212,175,55,.2);border-color:rgba(212,175,55,.4);color:#d4af37}
        .step-pill .num{width:20px;height:20px;border-radius:50%;background:rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:900}
        .step-pill.active .num{background:#d4af37;color:#0a1628}
        .step-arrow{padding:0 8px;color:rgba(255,255,255,.3);font-size:12px}

        /* Main layout */
        .page-wrap{max-width:1100px;margin:150px auto 0;padding:40px 32px 60px}
        .quote-grid{display:grid;grid-template-columns:1fr 380px;gap:32px;align-items:start}

        /* Form Card */
        .form-card{background:#fff;border-radius:16px;padding:40px;box-shadow:0 2px 16px rgba(0,0,0,.06)}
        .form-section{margin-bottom:32px}
        .form-section-title{font-size:13px;font-weight:800;color:#0a1628;letter-spacing:.5px;margin-bottom:18px;display:flex;align-items:center;gap:10px;padding-bottom:10px;border-bottom:1.5px solid #f0f2f5}
        .form-section-title .num{width:26px;height:26px;border-radius:50%;background:#0a1628;color:#fff;font-size:11px;font-weight:900;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .form-section-title .num.gold{background:#d4af37;color:#0a1628}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .form-row-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px}
        .form-group{margin-bottom:14px;display:flex;flex-direction:column;gap:5px}
        .form-group label{font-size:11px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.5px}
        .form-group input,.form-group select,.form-group textarea{width:100%;padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:'Montserrat',sans-serif;font-size:13px;color:#0a1628;outline:none;transition:all .2s;background:#fff}
        .form-group input:focus,.form-group select:focus,.form-group textarea:focus{border-color:#d4af37;box-shadow:0 0 0 3px rgba(212,175,55,.1)}
        .form-group textarea{resize:vertical;min-height:100px}
        .counter-row{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border:1.5px solid #e5e7eb;border-radius:8px;margin-bottom:10px}
        .counter-label{font-size:13px;font-weight:600;color:#374151}
        .counter-sub{font-size:11px;color:#9ba3af;margin-top:1px}
        .counter-ctrl{display:flex;align-items:center;gap:12px}
        .counter-btn{width:30px;height:30px;border-radius:50%;border:1.5px solid #e5e7eb;background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:16px;font-weight:700;color:#374151;transition:all .18s;line-height:1}
        .counter-btn:hover{border-color:#d4af37;color:#d4af37}
        .counter-val{font-size:15px;font-weight:800;color:#0a1628;width:22px;text-align:center}
        .services-check{display:grid;grid-template-columns:1fr 1fr;gap:10px}
        .service-opt{display:flex;align-items:center;gap:9px;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;cursor:pointer;transition:all .18s}
        .service-opt:hover{border-color:#d4af37;background:rgba(212,175,55,.04)}
        .service-opt input[type="checkbox"]{accent-color:#d4af37;width:15px;height:15px;cursor:pointer}
        .service-opt-text{font-size:12px;font-weight:600;color:#374151}
        .service-opt-text small{display:block;color:#9ba3af;font-weight:400;font-size:10.5px}
        .btn-submit{width:100%;padding:14px;background:linear-gradient(135deg,#0a1628,#1a2942);color:#fff;border:none;border-radius:10px;font-family:'Montserrat',sans-serif;font-size:13px;font-weight:700;letter-spacing:1px;text-transform:uppercase;cursor:pointer;transition:all .25s;display:flex;align-items:center;justify-content:center;gap:10px;margin-top:8px}
        .btn-submit:hover{transform:translateY(-1px);box-shadow:0 8px 24px rgba(10,22,40,.25)}
        .btn-submit i{color:#d4af37}

        /* Summary Card */
        .summary-card{background:#fff;border-radius:16px;padding:28px;box-shadow:0 2px 16px rgba(0,0,0,.06);position:sticky;top:80px}
        .summary-title{font-size:13px;font-weight:800;color:#0a1628;margin-bottom:20px;display:flex;align-items:center;gap:8px}
        .summary-title i{color:#d4af37}
        .summary-row{display:flex;justify-content:space-between;align-items:flex-start;padding:10px 0;border-bottom:1px solid #f3f4f6;font-size:12px}
        .summary-row:last-child{border-bottom:none}
        .summary-key{color:#6b7280;font-weight:600}
        .summary-val{font-weight:700;color:#0a1628;text-align:right;max-width:160px}
        .summary-highlight{background:rgba(212,175,55,.08);border-radius:10px;padding:14px 16px;margin:16px 0;display:flex;align-items:center;gap:12px}
        .sh-icon{font-size:20px;color:#d4af37;flex-shrink:0}
        .sh-text{font-size:11.5px;color:#374151;line-height:1.5}
        .sh-text strong{display:block;font-weight:800;color:#0a1628;margin-bottom:2px}
        .trust-list{margin-top:16px;display:flex;flex-direction:column;gap:8px}
        .trust-item{display:flex;align-items:center;gap:8px;font-size:11.5px;color:#6b7280}
        .trust-item i{color:#2dc653;font-size:12px;width:14px}

        /* Inspiration */
        .inspi-section{margin-top:56px}
        .section-label{font-size:11px;font-weight:800;color:#d4af37;letter-spacing:2.5px;text-transform:uppercase;margin-bottom:10px}
        .section-title{font-size:1.6rem;font-weight:900;color:#0a1628;margin-bottom:24px}
        .inspi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px}
        .inspi-card{border-radius:14px;overflow:hidden;position:relative;aspect-ratio:3/4;cursor:pointer}
        .inspi-card img{width:100%;height:100%;object-fit:cover;transition:transform .35s}
        .inspi-card:hover img{transform:scale(1.06)}
        .inspi-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(10,22,40,.85) 0%,rgba(10,22,40,.2) 60%,transparent 100%);display:flex;flex-direction:column;justify-content:flex-end;padding:18px}
        .inspi-country{font-size:10px;font-weight:700;color:rgba(255,255,255,.6);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px}
        .inspi-name{font-size:14px;font-weight:800;color:#fff;line-height:1.2;margin-bottom:6px}
        .inspi-price{font-size:12px;font-weight:700;color:#d4af37}

        @media(max-width:960px){.quote-grid{grid-template-columns:1fr}.summary-card{position:static}.inspi-grid{grid-template-columns:repeat(2,1fr)}}
        @media(max-width:600px){.page-wrap{padding:36px 20px}.form-row,.form-row-3{grid-template-columns:1fr}.services-check{grid-template-columns:1fr}.inspi-grid{grid-template-columns:repeat(2,1fr)}.page-banner{padding:32px 20px}}
    </style>
</head>
<body>

@include('home-v2.components.VerticalMenu')
@include('home-v2.components.Header')

<div class="page-wrap">
    <div class="quote-grid">

        {{-- Form --}}
        <div class="form-card">

            {{-- Section 1 : Destination --}}
            <div class="form-section">
                <div class="form-section-title"><span class="num">1</span> Destination &amp; Dates</div>
                <div class="form-group">
                    <label>Destination principale *</label>
                    <select>
                        <option value="">-- S&eacute;lectionner une destination --</option>
                        <optgroup label="Qu&eacute;bec">
                            <option>Montr&eacute;al</option>
                            <option>Qu&eacute;bec City</option>
                            <option>Gasp&eacute;sie</option>
                            <option>Charlevoix</option>
                            <option>Laurentides</option>
                            <option>Cantons-de-l&apos;Est</option>
                            <option>Saguenay &mdash; Lac-Saint-Jean</option>
                        </optgroup>
                        <optgroup label="Canada">
                            <option>Toronto, Ontario</option>
                            <option>Vancouver, C.-B.</option>
                            <option>Banff, Alberta</option>
                        </optgroup>
                        <optgroup label="International">
                            <option>Paris, France</option>
                            <option>Marrakech, Maroc</option>
                            <option>New York, &Eacute;U</option>
                        </optgroup>
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Date de d&eacute;part *</label><input type="date"></div>
                    <div class="form-group"><label>Date de retour *</label><input type="date"></div>
                </div>
                <div class="form-group">
                    <label>Flexibilit&eacute; des dates</label>
                    <select>
                        <option>Dates fix&eacute;es</option>
                        <option>&plusmn; 2&nbsp;jours</option>
                        <option>&plusmn; 5&nbsp;jours</option>
                        <option>&plusmn; 1&nbsp;semaine</option>
                        <option>Tr&egrave;s flexible</option>
                    </select>
                </div>
            </div>

            {{-- Section 2 : Voyageurs --}}
            <div class="form-section">
                <div class="form-section-title"><span class="num">2</span> Composition du groupe</div>
                <div class="counter-row">
                    <div><div class="counter-label">Adultes</div><div class="counter-sub">18 ans et plus</div></div>
                    <div class="counter-ctrl">
                        <button class="counter-btn" type="button">-</button>
                        <span class="counter-val" id="adults">2</span>
                        <button class="counter-btn" type="button">+</button>
                    </div>
                </div>
                <div class="counter-row">
                    <div><div class="counter-label">Enfants</div><div class="counter-sub">2 &mdash; 17 ans</div></div>
                    <div class="counter-ctrl">
                        <button class="counter-btn" type="button">-</button>
                        <span class="counter-val" id="children">0</span>
                        <button class="counter-btn" type="button">+</button>
                    </div>
                </div>
                <div class="counter-row">
                    <div><div class="counter-label">Bambins</div><div class="counter-sub">Moins de 2 ans</div></div>
                    <div class="counter-ctrl">
                        <button class="counter-btn" type="button">-</button>
                        <span class="counter-val" id="babies">0</span>
                        <button class="counter-btn" type="button">+</button>
                    </div>
                </div>
            </div>

            {{-- Section 3 : Services --}}
            <div class="form-section">
                <div class="form-section-title"><span class="num gold">3</span> Services souhait&eacute;s</div>
                <div class="services-check">
                    <label class="service-opt"><input type="checkbox" checked><div class="service-opt-text">H&ocirc;tel / H&eacute;bergement<small>H&ocirc;tels, auberges, lodges</small></div></label>
                    <label class="service-opt"><input type="checkbox" checked><div class="service-opt-text">Transport a&eacute;rien<small>Vols aller-retour</small></div></label>
                    <label class="service-opt"><input type="checkbox"><div class="service-opt-text">Location de voiture<small>Avec ou sans chauffeur</small></div></label>
                    <label class="service-opt"><input type="checkbox"><div class="service-opt-text">Guide touristique<small>Francophone disponible</small></div></label>
                    <label class="service-opt"><input type="checkbox"><div class="service-opt-text">Activit&eacute;s &amp; excursions<small>Ski, rando, kayak&hellip;</small></div></label>
                    <label class="service-opt"><input type="checkbox"><div class="service-opt-text">Assurance voyage<small>Annulation, sant&eacute;</small></div></label>
                    <label class="service-opt"><input type="checkbox"><div class="service-opt-text">Restauration<small>Petit-d&eacute;j., demi-pension</small></div></label>
                    <label class="service-opt"><input type="checkbox"><div class="service-opt-text">Transferts a&eacute;roport<small>Navettes priv&eacute;es</small></div></label>
                </div>
            </div>

            {{-- Section 4 : Budget & Détails --}}
            <div class="form-section">
                <div class="form-section-title"><span class="num">4</span> Budget &amp; D&eacute;tails</div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Budget total estim&eacute; ($CAD)</label>
                        <select>
                            <option>Moins de 2&nbsp;000 $</option>
                            <option selected>2&nbsp;000 $ &mdash; 5&nbsp;000 $</option>
                            <option>5&nbsp;000 $ &mdash; 10&nbsp;000 $</option>
                            <option>10&nbsp;000 $ &mdash; 20&nbsp;000 $</option>
                            <option>Plus de 20&nbsp;000 $</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type de voyage</label>
                        <select>
                            <option>Famille</option>
                            <option>Couple / Lune de miel</option>
                            <option>Entre amis</option>
                            <option>Solo</option>
                            <option>Groupe / Corporate</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Exigences sp&eacute;cifiques</label>
                    <textarea placeholder="Ex. : chambre accessible, r&eacute;gime v&eacute;g&eacute;tarien, voyage surprise, feux d'artifice&hellip;"></textarea>
                </div>
            </div>

            {{-- Section 5 : Contact --}}
            <div class="form-section">
                <div class="form-section-title"><span class="num">5</span> Vos coordonn&eacute;es</div>
                <div class="form-row">
                    <div class="form-group"><label>Pr&eacute;nom *</label><input type="text" placeholder="Jean"></div>
                    <div class="form-group"><label>Nom *</label><input type="text" placeholder="Tremblay"></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Courriel *</label><input type="email" placeholder="jean@exemple.com"></div>
                    <div class="form-group"><label>T&eacute;l&eacute;phone *</label><input type="tel" placeholder="+1 (514) 000-0000"></div>
                </div>
                <div class="form-group">
                    <label>Mode de contact pr&eacute;f&eacute;r&eacute;</label>
                    <select>
                        <option>Courriel</option>
                        <option>T&eacute;l&eacute;phone</option>
                        <option>WhatsApp</option>
                        <option>Zoom / Vid&eacute;o</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i> Envoyer ma demande de devis
            </button>
        </div>

        {{-- Summary Sidebar --}}
        <div class="summary-card">
            <div class="summary-title"><i class="fas fa-clipboard-check"></i> R&eacute;capitulatif</div>
            <div class="summary-row"><span class="summary-key">Destination</span><span class="summary-val">&mdash;</span></div>
            <div class="summary-row"><span class="summary-key">D&eacute;part</span><span class="summary-val">&mdash;</span></div>
            <div class="summary-row"><span class="summary-key">Retour</span><span class="summary-val">&mdash;</span></div>
            <div class="summary-row"><span class="summary-key">Voyageurs</span><span class="summary-val">2 adultes</span></div>
            <div class="summary-row"><span class="summary-key">Budget</span><span class="summary-val">2 000 $ &mdash; 5 000 $</span></div>
            <div class="summary-row"><span class="summary-key">Services</span><span class="summary-val">H&ocirc;tel, Vols</span></div>

            <div class="summary-highlight">
                <i class="fas fa-clock sh-icon"></i>
                <div class="sh-text">
                    <strong>R&eacute;ponse en 24 h</strong>
                    Notre &eacute;quipe vous contacte avec une proposition personnalis&eacute;e.
                </div>
            </div>

            <div class="trust-list">
                <div class="trust-item"><i class="fas fa-check-circle"></i> Devis 100&nbsp;% gratuit et sans engagement</div>
                <div class="trust-item"><i class="fas fa-check-circle"></i> Conseiller d&eacute;di&eacute; tout au long de votre voyage</div>
                <div class="trust-item"><i class="fas fa-check-circle"></i> Plus de 15&nbsp;ans d&apos;expertise au Qu&eacute;bec</div>
                <div class="trust-item"><i class="fas fa-check-circle"></i> Paiement s&eacute;curis&eacute; et garanties incluses</div>
                <div class="trust-item"><i class="fas fa-check-circle"></i> Assistance 24&nbsp;h&thinsp;/&thinsp;7 pendant votre voyage</div>
            </div>
        </div>
    </div>

    {{-- Inspiration --}}
    <div class="inspi-section">
        <div class="section-label">Inspiration</div>
        <h2 class="section-title">Destinations populaires</h2>
        <div class="inspi-grid">
            <div class="inspi-card">
                <img src="https://images.unsplash.com/photo-1519003722824-194d4455a60c?w=400&q=80" alt="Qu&eacute;bec">
                <div class="inspi-overlay">
                    <div class="inspi-country">Canada</div>
                    <div class="inspi-name">Vieux-Qu&eacute;bec</div>
                    <div class="inspi-price">D&egrave;s 1 290 $ / pers.</div>
                </div>
            </div>
            <div class="inspi-card">
                <img src="https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w=400&q=80" alt="Gasp&eacute;sie">
                <div class="inspi-overlay">
                    <div class="inspi-country">Qu&eacute;bec</div>
                    <div class="inspi-name">Circuit Gasp&eacute;sie</div>
                    <div class="inspi-price">D&egrave;s 2 490 $ / pers.</div>
                </div>
            </div>
            <div class="inspi-card">
                <img src="https://images.unsplash.com/photo-1537531613430-6a0e15c41f90?w=400&q=80" alt="Charlevoix">
                <div class="inspi-overlay">
                    <div class="inspi-country">Qu&eacute;bec</div>
                    <div class="inspi-name">Charlevoix Gourmand</div>
                    <div class="inspi-price">D&egrave;s 890 $ / pers.</div>
                </div>
            </div>
            <div class="inspi-card">
                <img src="https://images.unsplash.com/photo-1511497584788-876760111969?w=400&q=80" alt="Laurentides">
                <div class="inspi-overlay">
                    <div class="inspi-country">Qu&eacute;bec</div>
                    <div class="inspi-name">Laurentides Ski &amp; Spa</div>
                    <div class="inspi-price">D&egrave;s 750 $ / pers.</div>
                </div>
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
<script>
document.querySelectorAll('.counter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const row = btn.closest('.counter-row');
        const val = row.querySelector('.counter-val');
        let v = parseInt(val.textContent);
        if(btn.textContent === '+') val.textContent = v + 1;
        else if(v > 0) val.textContent = v - 1;
    });
});
</script>
</body>
</html>
