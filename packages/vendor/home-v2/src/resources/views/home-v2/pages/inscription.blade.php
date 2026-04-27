<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('home-v2.pages.signup_title') }}</title>
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
        body{font-family:'Montserrat',sans-serif;background:#f4f6f9;color:#0a1628;overflow-x:hidden;min-height:100vh;display:flex;flex-direction:column}

        /* ── Page wrapper ── */
        .insc-page{margin-top:150px;padding:48px 32px 80px;max-width:1300px;margin-left:auto;margin-right:auto}
        .insc-page{margin-top:150px}

        /* ── Banner ── */
        .insc-banner{background:linear-gradient(135deg,#0a1628 0%,#1a2942 100%);border-radius:20px;padding:44px 48px;margin-bottom:48px;position:relative;overflow:hidden}
        .insc-banner::before{content:'';position:absolute;inset:0;background:radial-gradient(circle at 80% 50%,rgba(212,175,55,.12),transparent 60%)}
        .insc-banner-badge{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;background:rgba(212,175,55,.15);border:1px solid rgba(212,175,55,.3);border-radius:20px;font-size:11px;font-weight:700;color:#d4af37;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:14px}
        .insc-banner h1{font-size:clamp(1.6rem,3vw,2.4rem);font-weight:900;color:#fff;margin-bottom:8px}
        .insc-banner h1 span{color:#d4af37}
        .insc-banner p{font-size:14px;color:rgba(255,255,255,.65);max-width:560px;line-height:1.6}
        .insc-banner-logos{position:absolute;right:48px;top:50%;transform:translateY(-50%);display:flex;gap:20px;align-items:center}
        .insc-banner-logos img{height:56px;object-fit:contain;filter:brightness(0) invert(1);opacity:.6}

        /* ── Stepper ── */
        .insc-stepper{display:flex;align-items:center;gap:0;margin-bottom:40px}
        .step{display:flex;align-items:center;gap:10px;flex:1}
        .step-num{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;flex-shrink:0;transition:all .3s}
        .step-num.done{background:#2dc653;color:#fff}
        .step-num.active{background:#d4af37;color:#0a1628}
        .step-num.pending{background:#e9ecef;color:#9ba3af}
        .step-label{font-size:12px;font-weight:700;color:#9ba3af}
        .step-label.active{color:#0a1628}
        .step-sep{flex:1;height:2px;background:#e9ecef;margin:0 8px}
        .step-sep.done{background:#2dc653}

        /* ── Étape 1 : Grille des types ── */
        #step1{display:block}
        #step2{display:none}
        .insc-types-title{font-size:1.2rem;font-weight:800;color:#0a1628;margin-bottom:6px}
        .insc-types-sub{font-size:13px;color:#6b7280;margin-bottom:28px}
        .types-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:32px}
        .type-card{background:#fff;border:2px solid #e8ecf0;border-radius:16px;padding:28px 24px;cursor:pointer;transition:all .25s;display:flex;flex-direction:column;gap:14px;position:relative}
        .type-card:hover{border-color:#1a3a8f;box-shadow:0 10px 30px rgba(26,58,143,.1);transform:translateY(-3px)}
        .type-card.selected{border-color:#d4af37;box-shadow:0 10px 30px rgba(212,175,55,.15)}
        .type-card.selected::after{content:'\f00c';font-family:'Font Awesome 6 Free';font-weight:900;position:absolute;top:14px;right:14px;width:26px;height:26px;background:#d4af37;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;display:flex;align-items:center;justify-content:center}
        .type-card-icon{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px}
        .type-card h3{font-size:14px;font-weight:800;color:#0a1628;line-height:1.3}
        .type-card p{font-size:12px;color:#6b7280;line-height:1.6;flex:1}
        .type-card-tag{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:20px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;align-self:flex-start}
        .type-card-link{font-size:11px;font-weight:700;color:#1a3a8f;text-decoration:none;display:flex;align-items:center;gap:4px;margin-top:auto}
        .type-card-link:hover{text-decoration:underline}

        /* Couleurs par type */
        .tc-entreprise .type-card-icon{background:rgba(26,58,143,.08);color:#1a3a8f}
        .tc-entreprise.selected{border-color:#1a3a8f}
        .tc-entreprise.selected::after{background:#1a3a8f}
        .tc-entreprise .type-card-tag{background:rgba(26,58,143,.08);color:#1a3a8f}
        .tc-destination .type-card-icon{background:rgba(0,174,154,.08);color:#00ae9a}
        .tc-destination.selected{border-color:#00ae9a}
        .tc-destination.selected::after{background:#00ae9a}
        .tc-destination .type-card-tag{background:rgba(0,174,154,.08);color:#00ae9a}
        .tc-partenaire .type-card-icon{background:rgba(212,175,55,.1);color:#c9980a}
        .tc-partenaire.selected{border-color:#d4af37}
        .tc-partenaire .type-card-tag{background:rgba(212,175,55,.1);color:#c9980a}
        .tc-web .type-card-icon{background:rgba(67,97,238,.08);color:#4361ee}
        .tc-web.selected{border-color:#4361ee}
        .tc-web.selected::after{background:#4361ee}
        .tc-web .type-card-tag{background:rgba(67,97,238,.08);color:#4361ee}
        .tc-regional .type-card-icon{background:rgba(230,57,70,.08);color:#e63946}
        .tc-regional.selected{border-color:#e63946}
        .tc-regional.selected::after{background:#e63946}
        .tc-regional .type-card-tag{background:rgba(230,57,70,.08);color:#e63946}
        .tc-voyageur .type-card-icon{background:rgba(45,198,83,.08);color:#2dc653}
        .tc-voyageur.selected{border-color:#2dc653}
        .tc-voyageur.selected::after{background:#2dc653}
        .tc-voyageur .type-card-tag{background:rgba(45,198,83,.08);color:#2dc653}

        .btn-next{display:inline-flex;align-items:center;gap:10px;padding:14px 36px;background:linear-gradient(135deg,#0a1628,#1a2942);color:#fff;border:none;border-radius:50px;font-family:'Montserrat',sans-serif;font-size:13px;font-weight:800;letter-spacing:1px;text-transform:uppercase;cursor:pointer;transition:all .25s;opacity:.4;pointer-events:none}
        .btn-next.enabled{opacity:1;pointer-events:auto}
        .btn-next.enabled:hover{background:linear-gradient(135deg,#1a2942,#2a3a52);transform:translateY(-2px);box-shadow:0 8px 24px rgba(10,22,40,.3)}
        .btn-next i{color:#d4af37}

        /* ── Étape 2 : Formulaire ── */
        .form-wrap{display:grid;grid-template-columns:340px 1fr;gap:32px;align-items:start}
        .form-recap{background:#fff;border-radius:16px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,.06);position:sticky;top:120px}
        .form-recap-type{display:flex;align-items:center;gap:14px;margin-bottom:20px}
        .form-recap-icon{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px}
        .form-recap h3{font-size:15px;font-weight:800;color:#0a1628}
        .form-recap p{font-size:12px;color:#6b7280;margin-top:3px}
        .form-recap-perks{list-style:none;padding:0;margin-top:16px;border-top:1px solid #f0f2f5;padding-top:16px}
        .form-recap-perks li{display:flex;align-items:flex-start;gap:8px;font-size:12px;color:#444;padding:5px 0}
        .form-recap-perks li i{color:#2dc653;font-size:13px;margin-top:1px;flex-shrink:0}
        .form-recap-back{display:inline-flex;align-items:center;gap:6px;margin-top:20px;font-size:12px;font-weight:700;color:#6b7280;cursor:pointer;border:none;background:none;font-family:'Montserrat',sans-serif;padding:0}
        .form-recap-back:hover{color:#0a1628}

        .form-panel{background:#fff;border-radius:16px;padding:36px 40px;box-shadow:0 2px 12px rgba(0,0,0,.06)}
        .form-panel h2{font-size:1.3rem;font-weight:900;color:#0a1628;margin-bottom:4px}
        .form-panel .sub{font-size:13px;color:#9ba3af;margin-bottom:24px}
        .social-auth{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px}
        .social-auth-btn{display:flex;align-items:center;justify-content:center;gap:8px;padding:10px;border:1.5px solid #e5e7eb;border-radius:9px;font-size:13px;font-weight:600;color:#374151;cursor:pointer;background:#fff;transition:all .2s;font-family:'Montserrat',sans-serif}
        .social-auth-btn:hover{border-color:#0a1628}
        .divider{display:flex;align-items:center;gap:12px;margin-bottom:20px}
        .divider::before,.divider::after{content:'';flex:1;height:1px;background:#e9ecef}
        .divider span{font-size:11px;font-weight:700;color:#9ba3af;letter-spacing:.5px;text-transform:uppercase}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .form-group{margin-bottom:14px;display:flex;flex-direction:column;gap:5px}
        .form-group label{font-size:11px;font-weight:700;color:#374151;letter-spacing:.5px;text-transform:uppercase}
        .form-group input,.form-group select{width:100%;padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:'Montserrat',sans-serif;font-size:13px;color:#0a1628;outline:none;transition:all .2s}
        .form-group input:focus,.form-group select:focus{border-color:#d4af37;box-shadow:0 0 0 3px rgba(212,175,55,.1)}
        .input-wrap{position:relative}
        .input-wrap input{padding-right:40px}
        .input-icon{position:absolute;right:13px;top:50%;transform:translateY(-50%);color:#9ba3af;font-size:14px;cursor:pointer}
        .pwd-strength{display:flex;gap:4px;margin-top:6px}
        .pwd-bar{flex:1;height:3px;border-radius:2px;background:#e9ecef;transition:background .3s}
        .terms-check{display:flex;align-items:flex-start;gap:10px;margin-bottom:18px}
        .terms-check input[type="checkbox"]{width:16px;height:16px;margin-top:2px;accent-color:#d4af37;cursor:pointer;flex-shrink:0}
        .terms-check label{font-size:12px;color:#6b7280;line-height:1.5;cursor:pointer}
        .terms-check label a{color:#4361ee;font-weight:700;text-decoration:none}
        .btn-submit{width:100%;padding:14px;background:linear-gradient(135deg,#0a1628,#1a2942);color:#fff;border:none;border-radius:10px;font-family:'Montserrat',sans-serif;font-size:13px;font-weight:700;letter-spacing:1px;text-transform:uppercase;cursor:pointer;transition:all .25s;display:flex;align-items:center;justify-content:center;gap:10px}
        .btn-submit:hover{background:linear-gradient(135deg,#1a2942,#2a3a52);transform:translateY(-1px);box-shadow:0 8px 24px rgba(10,22,40,.25)}
        .btn-submit i{color:#d4af37}
        .login-link{text-align:center;margin-top:16px;font-size:12px;color:#9ba3af}
        .login-link a{color:#4361ee;font-weight:700;text-decoration:none}

        @media(max-width:1100px){.types-grid{grid-template-columns:repeat(2,1fr)}}
        @media(max-width:900px){.form-wrap{grid-template-columns:1fr}.form-recap{position:static}.insc-banner-logos{display:none}}
        @media(max-width:600px){.insc-page{padding:32px 16px}.types-grid{grid-template-columns:1fr}.form-panel{padding:24px 20px}.insc-banner{padding:28px 24px}.form-row{grid-template-columns:1fr}.social-auth{grid-template-columns:1fr}}
        footer,.footer-v2{margin-top:0!important}
    </style>
</head>
<body>

@include('home-v2.components.VerticalMenu')
@include('home-v2.components.Header')

<div class="insc-page">

    {{-- ── Stepper ── --}}
    <div class="insc-stepper">
        <div class="step">
            <div class="step-num active" id="stepNum1">1</div>
            <span class="step-label active" id="stepLbl1">Choisir mon espace</span>
        </div>
        <div class="step-sep" id="stepSep1"></div>
        <div class="step">
            <div class="step-num pending" id="stepNum2">2</div>
            <span class="step-label" id="stepLbl2">Cr&eacute;er mon compte</span>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         ÉTAPE 1 — Choix du type
    ══════════════════════════════════════ --}}
    <div id="step1">
        <p class="insc-types-title">Quel est votre profil ?</p>
        <p class="insc-types-sub">S&eacute;lectionnez votre type d&apos;inscription. Chaque espace offre des fonctionnalit&eacute;s adapt&eacute;es &agrave; vos besoins.</p>

        <div class="types-grid">

            <div class="type-card tc-entreprise" data-type="entreprise" onclick="selectType(this)">
                <div class="type-card-icon"><i class="fas fa-building"></i></div>
                <div>
                    <span class="type-card-tag"><i class="fas fa-briefcase"></i> Entreprise</span>
                    <h3>Espace Entreprises</h3>
                </div>
                <p>Profil professionnel complet pour h&ocirc;tels, restaurants, agences, pourvoiries et toute entreprise touristique.</p>
                <a href="#" class="type-card-link" onclick="return false"><i class="fas fa-info-circle"></i> Voir les d&eacute;tails de ce plan</a>
            </div>

            <div class="type-card tc-destination" data-type="destination" onclick="selectType(this)">
                <div class="type-card-icon"><i class="fas fa-map-marked-alt"></i></div>
                <div>
                    <span class="type-card-tag"><i class="fas fa-globe"></i> Destination</span>
                    <h3>Espace Destinations</h3>
                </div>
                <p>Pour les MRC, r&eacute;gions touristiques, municipalit&eacute;s et offices de tourisme souhaitant promouvoir leur territoire.</p>
                <a href="#" class="type-card-link" onclick="return false"><i class="fas fa-info-circle"></i> Voir les d&eacute;tails de ce plan</a>
            </div>

            <div class="type-card tc-partenaire" data-type="partenaire-affilie" onclick="selectType(this)">
                <div class="type-card-icon"><i class="fas fa-handshake"></i></div>
                <div>
                    <span class="type-card-tag"><i class="fas fa-users"></i> Partenaire</span>
                    <h3>Partenaire Affili&eacute; R&eacute;gional</h3>
                </div>
                <p>Pour les associations, f&eacute;d&eacute;rations r&eacute;gionales et organismes souhaitant b&eacute;n&eacute;ficier d&apos;un r&eacute;seau de partenariat GoExploria.</p>
                <a href="#" class="type-card-link" onclick="return false"><i class="fas fa-info-circle"></i> Voir les d&eacute;tails de ce plan</a>
            </div>

            <div class="type-card tc-web" data-type="partenaire-web" onclick="selectType(this)">
                <div class="type-card-icon"><i class="fas fa-laptop-code"></i></div>
                <div>
                    <span class="type-card-tag"><i class="fas fa-globe-americas"></i> Web</span>
                    <h3>Partenaire Web Voyageurs</h3>
                </div>
                <p>Pour les blogueurs voyage, cr&eacute;ateurs de contenu et influenceurs voulant promouvoir des destinations et gagner des commissions.</p>
                <a href="#" class="type-card-link" onclick="return false"><i class="fas fa-info-circle"></i> Voir les d&eacute;tails de ce plan</a>
            </div>

            <div class="type-card tc-regional" data-type="partenaire-regional" onclick="selectType(this)">
                <div class="type-card-icon"><i class="fas fa-map-pin"></i></div>
                <div>
                    <span class="type-card-tag"><i class="fas fa-flag"></i> R&eacute;gional</span>
                    <h3>Partenaire R&eacute;gional</h3>
                </div>
                <p>Pour les acteurs locaux, chambres de commerce et d&eacute;veloppeurs &eacute;conomiques r&eacute;gionaux voulant am&eacute;liorer la visibilit&eacute; de leur r&eacute;gion.</p>
                <a href="#" class="type-card-link" onclick="return false"><i class="fas fa-info-circle"></i> Voir les d&eacute;tails de ce plan</a>
            </div>

            <div class="type-card tc-voyageur" data-type="voyageur" onclick="selectType(this)">
                <div class="type-card-icon"><i class="fas fa-user-circle"></i></div>
                <div>
                    <span class="type-card-tag"><i class="fas fa-plane"></i> Voyageur</span>
                    <h3>Espace Personnel Voyageur</h3>
                </div>
                <p>Pour les particuliers souhaitant planifier leurs voyages, sauvegarder leurs favoris et profiter des offres exclusives GoExploria.</p>
                <a href="#" class="type-card-link" onclick="return false"><i class="fas fa-info-circle"></i> Voir les d&eacute;tails de ce plan</a>
            </div>

        </div>

        <button class="btn-next" id="btnNext" onclick="goStep2()">
            Continuer <i class="fas fa-arrow-right"></i>
        </button>
    </div>

    {{-- ══════════════════════════════════════
         ÉTAPE 2 — Formulaire
    ══════════════════════════════════════ --}}
    <div id="step2">
        <div class="form-wrap">

            {{-- Récap type sélectionné --}}
            <div class="form-recap">
                <div class="form-recap-type">
                    <div class="form-recap-icon" id="recapIcon"></div>
                    <div>
                        <h3 id="recapTitle"></h3>
                        <p id="recapSub"></p>
                    </div>
                </div>
                <ul class="form-recap-perks" id="recapPerks"></ul>
                <button class="form-recap-back" onclick="goStep1()">
                    <i class="fas fa-arrow-left"></i> Changer de type
                </button>
            </div>

            {{-- Formulaire --}}
            <div class="form-panel">
                <h2>Cr&eacute;ez votre compte</h2>
                <p class="sub">D&eacute;j&agrave; membre ? <a href="{{ url('/login') }}" style="color:#4361ee;font-weight:700;">Connectez-vous</a></p>

                <div class="social-auth">
                    <button class="social-auth-btn">
                        <svg width="18" height="18" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.5 0 6.4 1.2 8.7 3.2l6.4-6.4C35.1 2.8 29.9.5 24 .5 14.6.5 6.6 6 2.7 13.9l7.5 5.8C12.2 13.4 17.6 9.5 24 9.5z"/><path fill="#4A90D9" d="M46.1 24.5c0-1.6-.1-3.1-.4-4.5H24v8.5h12.5c-.5 2.7-2.1 5-4.4 6.6l7 5.4c4.1-3.8 6.5-9.4 6.5-16z"/><path fill="#34A853" d="M10.2 28.3A14.7 14.7 0 0 1 9.5 24c0-1.5.3-2.9.7-4.3L2.7 13.9A23.5 23.5 0 0 0 .5 24c0 3.8.9 7.3 2.2 10.5l7.5-6.2z"/><path fill="#FBBC05" d="M24 47.5c5.9 0 10.9-2 14.5-5.3l-7-5.4c-2 1.4-4.5 2.2-7.5 2.2-6.4 0-11.8-4-13.8-9.6l-7.5 6.2C6.6 42 14.6 47.5 24 47.5z"/></svg>
                        Google
                    </button>
                    <button class="social-auth-btn">
                        <svg width="18" height="18" viewBox="0 0 48 48"><path fill="#1877F2" d="M48 24C48 10.7 37.3 0 24 0S0 10.7 0 24c0 12 8.8 21.9 20.3 23.7V30.9h-6.1V24h6.1v-5.3c0-6 3.6-9.3 9-9.3 2.6 0 5.3.5 5.3.5v5.9h-3c-2.9 0-3.8 1.8-3.8 3.7V24h6.5l-1 6.9h-5.5v16.8C39.2 45.9 48 36 48 24z"/></svg>
                        Facebook
                    </button>
                </div>
                <div class="divider"><span>ou avec votre courriel</span></div>

                <form>
                    <input type="hidden" id="hiddenType" name="type">
                    <div id="entrepriseFields" style="display:none">
                        <div class="form-group">
                            <label>Nom de l&apos;entreprise *</label>
                            <input type="text" placeholder="Ex : H&ocirc;tel du Lac">
                        </div>
                        <div class="form-group">
                            <label>Secteur d&apos;activit&eacute;</label>
                            <select>
                                <option>H&ocirc;tellerie &amp; H&eacute;bergement</option>
                                <option>Restauration</option>
                                <option>Activit&eacute;s &amp; Loisirs</option>
                                <option>Agence de voyage</option>
                                <option>Transport</option>
                                <option>Autre</option>
                            </select>
                        </div>
                    </div>
                    <div id="destinationFields" style="display:none">
                        <div class="form-group">
                            <label>Nom de la destination *</label>
                            <input type="text" placeholder="Ex : R&eacute;gion de Charlevoix">
                        </div>
                        <div class="form-group">
                            <label>Type d&apos;organisation</label>
                            <select>
                                <option>MRC</option>
                                <option>R&eacute;gion touristique</option>
                                <option>Municipalit&eacute;</option>
                                <option>Office de tourisme</option>
                                <option>Autre</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Pr&eacute;nom *</label>
                            <input type="text" placeholder="Jean">
                        </div>
                        <div class="form-group">
                            <label>Nom *</label>
                            <input type="text" placeholder="Tremblay">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Adresse courriel *</label>
                        <input type="email" placeholder="jean.tremblay@exemple.com">
                    </div>
                    <div class="form-group">
                        <label>T&eacute;l&eacute;phone</label>
                        <input type="tel" placeholder="+1 (514) 000-0000">
                    </div>
                    <div class="form-group">
                        <label>Pays de r&eacute;sidence</label>
                        <select>
                            <option value="CA" selected>Canada</option>
                            <option value="FR">France</option>
                            <option value="BE">Belgique</option>
                            <option value="CH">Suisse</option>
                            <option value="MA">Maroc</option>
                            <option value="SN">S&eacute;n&eacute;gal</option>
                            <option value="DZ">Alg&eacute;rie</option>
                            <option value="TN">Tunisie</option>
                            <option value="US">&Eacute;tats-Unis</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mot de passe *</label>
                        <div class="input-wrap">
                            <input type="password" id="pwd" placeholder="Minimum 8 caract&egrave;res">
                            <i class="fas fa-eye input-icon" onclick="togglePwd('pwd',this)"></i>
                        </div>
                        <div class="pwd-strength">
                            <div class="pwd-bar" id="bar1"></div><div class="pwd-bar" id="bar2"></div>
                            <div class="pwd-bar" id="bar3"></div><div class="pwd-bar" id="bar4"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirmer le mot de passe *</label>
                        <div class="input-wrap">
                            <input type="password" id="pwd2" placeholder="R&eacute;p&eacute;ter le mot de passe">
                            <i class="fas fa-eye input-icon" onclick="togglePwd('pwd2',this)"></i>
                        </div>
                    </div>
                    <div class="terms-check">
                        <input type="checkbox" id="terms">
                        <label for="terms">J&apos;accepte les <a href="#">Conditions g&eacute;n&eacute;rales</a> et la <a href="#">Politique de confidentialit&eacute;</a> de GoExploria.</label>
                    </div>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-user-plus"></i> Cr&eacute;er mon compte
                    </button>
                    <p class="login-link">D&eacute;j&agrave; inscrit ? <a href="{{ url('/login') }}">Connectez-vous</a></p>
                </form>
            </div>
        </div>
    </div>

</div>{{-- /insc-page --}}

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
const typeData = {
    'entreprise':         { icon:'fas fa-building',    color:'#1a3a8f', bg:'rgba(26,58,143,.1)',  title:'Espace Entreprises',             sub:'Profil professionnel complet', perks:['Profil entreprise complet','Galerie photos & vidéos','Gestion des réservations','Tableau de bord analytique','Intégration carte GoExploria'] },
    'destination':        { icon:'fas fa-map-marked-alt',color:'#00ae9a',bg:'rgba(0,174,154,.1)', title:'Espace Destinations',            sub:'MRC & Régions touristiques',   perks:['Profil destination complet','Gestion des activités locales','Carte interactive GéoVidéo','Statistiques de fréquentation','Espaces multilingues'] },
    'partenaire-affilie': { icon:'fas fa-handshake',   color:'#c9980a', bg:'rgba(212,175,55,.1)', title:'Partenaire Affilié Régional',    sub:'Réseau de partenariat',        perks:['Réseau partenaires GoExploria','Commissions sur références','Accès outils marketing','Support dédié','Badge partenaire certifié'] },
    'partenaire-web':     { icon:'fas fa-laptop-code', color:'#4361ee', bg:'rgba(67,97,238,.1)',  title:'Partenaire Web Voyageurs',        sub:'Blogueurs & Créateurs',        perks:['Espace créateur de contenu','Liens affiliés rémunérés','Accès médiathèque GoExploria','Tableau de bord commissions','Newsletter partenaire'] },
    'partenaire-regional':{ icon:'fas fa-map-pin',     color:'#e63946', bg:'rgba(230,57,70,.1)',  title:'Partenaire Régional',            sub:'Chambres de commerce',         perks:['Profil régional complet','Outils de développement local','Accès statistiques régionales','Réseau entreprises locales','Support prioritaire'] },
    'voyageur':           { icon:'fas fa-user-circle', color:'#2dc653', bg:'rgba(45,198,83,.1)',  title:'Espace Personnel Voyageur',      sub:'Particuliers & Voyageurs',     perks:['Favoris & listes de voyage','Alertes offres exclusives','Réservations en ligne','Avis & recommandations','Journal de voyage'] }
};

let selectedType = null;

function selectType(card) {
    document.querySelectorAll('.type-card').forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');
    selectedType = card.dataset.type;
    document.getElementById('btnNext').classList.add('enabled');
}

function goStep2() {
    if (!selectedType) return;
    const d = typeData[selectedType];
    document.getElementById('step1').style.display = 'none';
    document.getElementById('step2').style.display = 'block';
    document.getElementById('stepNum1').className = 'step-num done';
    document.getElementById('stepNum1').innerHTML = '<i class="fas fa-check" style="font-size:12px"></i>';
    document.getElementById('stepSep1').classList.add('done');
    document.getElementById('stepNum2').className = 'step-num active';
    document.getElementById('stepLbl2').classList.add('active');
    const ri = document.getElementById('recapIcon');
    ri.style.background = d.bg; ri.innerHTML = '<i class="' + d.icon + '" style="color:' + d.color + ';font-size:22px"></i>';
    document.getElementById('recapTitle').textContent = d.title;
    document.getElementById('recapSub').textContent = d.sub;
    document.getElementById('recapPerks').innerHTML = d.perks.map(p => '<li><i class="fas fa-check-circle"></i>' + p + '</li>').join('');
    document.getElementById('hiddenType').value = selectedType;
    document.getElementById('entrepriseFields').style.display = (selectedType === 'entreprise') ? '' : 'none';
    document.getElementById('destinationFields').style.display = (selectedType === 'destination') ? '' : 'none';
    window.scrollTo({top:0,behavior:'smooth'});
}

function goStep1() {
    document.getElementById('step2').style.display = 'none';
    document.getElementById('step1').style.display = 'block';
    document.getElementById('stepNum1').className = 'step-num active';
    document.getElementById('stepNum1').innerHTML = '1';
    document.getElementById('stepSep1').classList.remove('done');
    document.getElementById('stepNum2').className = 'step-num pending';
    document.getElementById('stepLbl2').classList.remove('active');
}

function togglePwd(id,icon){
    const f=document.getElementById(id);
    if(f.type==='password'){f.type='text';icon.classList.replace('fa-eye','fa-eye-slash');}
    else{f.type='password';icon.classList.replace('fa-eye-slash','fa-eye');}
}
</script>
</body>
</html>


