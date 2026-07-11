<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('home-v2.pages.contact_title') }}</title>
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
        :root{
            --navy:#0a1628; --navy2:#1a2942; --navy3:#2a3a52;
            --gold:#d4af37; --gold-deep:#c9980a;
            --ink:#0a1628; --muted:#6b7280; --line:#e5e7eb;
            --bg:#f4f6f9; --card:#fff;
            --shadow-sm:0 2px 16px rgba(10,22,40,.06);
            --shadow-lg:0 18px 50px rgba(10,22,40,.14);
        }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Montserrat',sans-serif;background:var(--bg);color:var(--ink);overflow-x:hidden}
        a{text-decoration:none}
        .cx-wrap{max-width:1200px;margin:0 auto;padding:0 32px}

        /* ── HERO ─────────────────────────────────────── */
        .cx-hero{position:relative;padding:190px 0 140px;overflow:hidden;background:var(--navy);isolation:isolate}
        .cx-hero::before{content:'';position:absolute;inset:0;z-index:-2;
            background:url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1600&q=80') center/cover no-repeat;
            transform:scale(1.05);filter:saturate(1.05)}
        .cx-hero::after{content:'';position:absolute;inset:0;z-index:-1;
            background:linear-gradient(115deg,rgba(10,22,40,.94) 0%,rgba(10,22,40,.80) 45%,rgba(26,41,66,.55) 100%)}
        .cx-hero-orb{position:absolute;border-radius:50%;filter:blur(70px);z-index:-1;opacity:.55}
        .cx-hero-orb.o1{width:420px;height:420px;background:rgba(212,175,55,.28);top:-120px;right:-80px}
        .cx-hero-orb.o2{width:360px;height:360px;background:rgba(67,97,238,.22);bottom:-160px;left:-100px}
        .cx-hero-inner{position:relative;max-width:760px}
        .cx-badge{display:inline-flex;align-items:center;gap:8px;padding:7px 16px;
            background:rgba(212,175,55,.14);border:1px solid rgba(212,175,55,.35);border-radius:30px;
            font-size:11px;font-weight:700;color:var(--gold);letter-spacing:2px;text-transform:uppercase;margin-bottom:22px}
        .cx-badge i{font-size:9px}
        .cx-hero h1{font-size:clamp(2.1rem,5vw,3.5rem);font-weight:900;color:#fff;line-height:1.08;letter-spacing:-.5px}
        .cx-hero h1 span{color:var(--gold);position:relative;white-space:nowrap}
        .cx-hero p{margin-top:20px;font-size:clamp(14px,1.6vw,17px);line-height:1.7;color:rgba(255,255,255,.72);max-width:560px}
        .cx-hero-chips{display:flex;flex-wrap:wrap;gap:14px;margin-top:38px}
        .cx-chip{display:inline-flex;align-items:center;gap:11px;padding:13px 20px;
            background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.14);border-radius:14px;
            backdrop-filter:blur(6px);transition:all .25s}
        .cx-chip:hover{background:rgba(255,255,255,.12);transform:translateY(-2px)}
        .cx-chip i{width:38px;height:38px;flex-shrink:0;border-radius:10px;display:flex;align-items:center;justify-content:center;
            background:rgba(212,175,55,.16);color:var(--gold);font-size:15px}
        .cx-chip .cx-chip-txt{display:flex;flex-direction:column;line-height:1.3}
        .cx-chip .cx-chip-k{display:block;font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.5)}
        .cx-chip .cx-chip-v{display:block;font-size:14px;font-weight:700;color:#fff;margin-top:2px}
        .cx-wave{position:absolute;left:0;right:0;bottom:-1px;z-index:0;line-height:0}
        .cx-wave svg{width:100%;height:70px;display:block}

        /* ── SECTION HEAD ─────────────────────────────── */
        .cx-section{padding:0 0}
        .cx-head{max-width:640px;margin-bottom:38px}
        .cx-head.center{margin-left:auto;margin-right:auto;text-align:center}
        .cx-label{font-size:11px;font-weight:800;color:var(--gold-deep);letter-spacing:3px;text-transform:uppercase;margin-bottom:12px}
        .cx-title{font-size:clamp(1.5rem,3vw,2.1rem);font-weight:900;color:var(--ink);line-height:1.2}
        .cx-sub{margin-top:10px;font-size:14.5px;color:var(--muted);line-height:1.7}

        /* ── INFO CARDS ───────────────────────────────── */
        .info-strip{margin-top:-64px;position:relative;z-index:5}
        .info-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px}
        .info-card{background:var(--card);border-radius:18px;padding:30px;box-shadow:var(--shadow-lg);
            display:flex;flex-direction:column;gap:14px;position:relative;overflow:hidden;transition:transform .28s,box-shadow .28s}
        .info-card::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;background:var(--accent,var(--gold))}
        .info-card:hover{transform:translateY(-6px);box-shadow:0 26px 60px rgba(10,22,40,.18)}
        .info-card.card-addr{--accent:#4361ee}
        .info-card.card-phone{--accent:#2dc653}
        .info-card.card-email{--accent:var(--gold)}
        .info-icon{width:54px;height:54px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;
            background:color-mix(in srgb,var(--accent) 12%,#fff);color:var(--accent)}
        .info-card h3{font-size:14px;font-weight:800;color:var(--ink);letter-spacing:.4px}
        .info-card p{font-size:13px;color:var(--muted);line-height:1.75}
        .info-card a.inline{color:#4361ee;font-weight:600}
        .info-card a.inline:hover{text-decoration:underline}
        .info-link{margin-top:auto;display:inline-flex;align-items:center;gap:7px;font-size:12.5px;font-weight:700;color:var(--ink)}
        .info-link i{color:var(--accent);transition:transform .2s}
        .info-card:hover .info-link i{transform:translateX(3px)}
        .info-badge{display:inline-flex;align-items:center;gap:6px;padding:5px 11px;border-radius:20px;font-size:11px;font-weight:700;
            background:rgba(45,198,83,.1);color:#2dc653;width:fit-content}
        .info-badge i{font-size:8px;animation:pulse 1.8s infinite}
        @keyframes pulse{0%,100%{opacity:1}50%{opacity:.3}}

        /* ── FORM + MAP ───────────────────────────────── */
        .contact-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:32px;align-items:stretch}
        .form-card{background:var(--card);border-radius:20px;padding:44px;box-shadow:var(--shadow-sm);border:1px solid rgba(10,22,40,.05)}
        .form-card h2{font-size:1.35rem;font-weight:900;color:var(--ink)}
        .form-card .sub{font-size:13px;color:#9ba3af;margin:6px 0 30px}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .form-group{margin-bottom:18px;display:flex;flex-direction:column;gap:7px}
        .form-group label{font-size:11px;font-weight:700;color:#374151;letter-spacing:.6px;text-transform:uppercase}
        .form-group input,.form-group select,.form-group textarea{width:100%;padding:13px 15px;border:1.5px solid var(--line);
            border-radius:11px;font-family:'Montserrat',sans-serif;font-size:13.5px;color:var(--ink);outline:none;background:#fbfbfd;
            transition:border-color .2s,box-shadow .2s,background .2s}
        .form-group input::placeholder,.form-group textarea::placeholder{color:#b3b9c4}
        .form-group input:focus,.form-group select:focus,.form-group textarea:focus{
            border-color:var(--gold);background:#fff;box-shadow:0 0 0 4px rgba(212,175,55,.13)}
        .form-group textarea{resize:vertical;min-height:130px}
        .btn-submit{width:100%;padding:16px;background:linear-gradient(135deg,var(--navy),var(--navy2));color:#fff;border:none;
            border-radius:12px;font-family:'Montserrat',sans-serif;font-size:13px;font-weight:700;letter-spacing:1px;text-transform:uppercase;
            cursor:pointer;transition:all .25s;display:flex;align-items:center;justify-content:center;gap:10px;margin-top:6px}
        .btn-submit:hover{background:linear-gradient(135deg,var(--navy2),var(--navy3));transform:translateY(-2px);box-shadow:0 14px 32px rgba(10,22,40,.32)}
        .btn-submit i{font-size:14px;color:var(--gold)}
        .form-consent{margin-top:16px;font-size:11.5px;color:#9ba3af;line-height:1.6;text-align:center}
        .form-consent i{color:#2dc653}

        /* ── MAP CARD ─────────────────────────────────── */
        .map-card{background:var(--card);border-radius:20px;overflow:hidden;box-shadow:var(--shadow-sm);
            border:1px solid rgba(10,22,40,.05);display:flex;flex-direction:column}
        .map-embed{flex:1;min-height:280px;position:relative;background:#e8ecf4}
        .map-embed iframe{width:100%;height:100%;min-height:280px;border:0;display:block;filter:grayscale(.15) contrast(1.02)}
        .map-info{padding:26px 30px}
        .map-info-head{display:flex;align-items:center;gap:12px;margin-bottom:14px}
        .map-info-head .pin{width:44px;height:44px;flex-shrink:0;border-radius:12px;background:rgba(212,175,55,.13);color:var(--gold-deep);
            display:flex;align-items:center;justify-content:center;font-size:18px}
        .map-address{font-size:14px;font-weight:800;color:var(--ink)}
        .map-city{font-size:12.5px;color:var(--muted);margin-top:2px}
        .map-actions{display:flex;gap:10px;margin-top:8px}
        .map-btn{flex:1;display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px;border-radius:11px;
            font-size:12.5px;font-weight:700;transition:all .2s}
        .map-btn-primary{background:var(--navy);color:#fff}
        .map-btn-primary:hover{background:var(--navy2);transform:translateY(-2px)}
        .map-btn-secondary{border:1.5px solid var(--line);color:#374151}
        .map-btn-secondary:hover{border-color:var(--navy);color:var(--navy)}

        /* ── HOURS ────────────────────────────────────── */
        .hours-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:8px}
        .hours-card{background:var(--card);border-radius:20px;padding:34px;box-shadow:var(--shadow-sm);border:1px solid rgba(10,22,40,.05)}
        .hours-card h3{font-size:14px;font-weight:800;color:var(--ink);margin-bottom:22px;display:flex;align-items:center;gap:10px}
        .hours-card h3 i{width:38px;height:38px;border-radius:10px;background:rgba(212,175,55,.12);color:var(--gold-deep);
            display:flex;align-items:center;justify-content:center;font-size:15px}
        .hours-row{display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid #f1f3f6;font-size:13px}
        .hours-row:last-child{border-bottom:none}
        .hours-day{font-weight:600;color:#374151}
        .hours-time{font-weight:700;color:var(--ink)}
        .hours-closed{color:#e63946;font-weight:700}
        .hours-open{color:#2dc653}
        .hours-today{background:rgba(212,175,55,.08);border-radius:10px;padding:12px 16px;margin:0 -16px;border-bottom:none !important}

        /* ── SOCIAL BAND ──────────────────────────────── */
        .social-band{position:relative;overflow:hidden;border-radius:24px;padding:56px 40px;text-align:center;
            background:linear-gradient(135deg,var(--navy) 0%,var(--navy2) 100%);isolation:isolate}
        .social-band::before{content:'';position:absolute;width:340px;height:340px;border-radius:50%;
            background:rgba(212,175,55,.16);filter:blur(80px);top:-120px;right:-60px;z-index:-1}
        .social-band .cx-label{color:var(--gold)}
        .social-band h2{font-size:clamp(1.3rem,2.6vw,1.8rem);font-weight:900;color:#fff;margin-bottom:10px}
        .social-band p{font-size:14px;color:rgba(255,255,255,.62);max-width:440px;margin:0 auto 28px}
        .social-links{display:flex;justify-content:center;gap:14px;flex-wrap:wrap}
        .social-btn{width:52px;height:52px;border-radius:15px;display:flex;align-items:center;justify-content:center;font-size:19px;
            color:#fff;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.14);transition:all .25s}
        .social-btn:hover{transform:translateY(-5px)}
        .social-btn.sb-fb:hover{background:#1877f2;border-color:#1877f2}
        .social-btn.sb-ig:hover{background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);border-color:transparent}
        .social-btn.sb-yt:hover{background:#ff0000;border-color:#ff0000}
        .social-btn.sb-li:hover{background:#0077b5;border-color:#0077b5}
        .social-btn.sb-tt:hover{background:#000;border-color:#000}

        /* ── REVEAL ANIM ──────────────────────────────── */
        .reveal{opacity:0;transform:translateY(26px);transition:opacity .6s ease,transform .6s ease}
        .reveal.in{opacity:1;transform:none}

        /* ── RESPONSIVE ───────────────────────────────── */
        @media(max-width:960px){
            .info-grid{grid-template-columns:1fr}
            .contact-grid{grid-template-columns:1fr}
            .hours-grid{grid-template-columns:1fr}
            .info-strip{margin-top:-40px}
        }
        @media(max-width:600px){
            .cx-wrap{padding:0 20px}
            .cx-hero{padding:150px 0 110px}
            .form-card{padding:30px 22px}
            .form-row{grid-template-columns:1fr}
            .hours-card{padding:26px 22px}
            .social-band{padding:44px 24px}
        }
        @media(prefers-reduced-motion:reduce){.reveal{opacity:1;transform:none;transition:none}}
    </style>
</head>
<body>

@include('home-v2.components.VerticalMenu')
@include('home-v2.components.Header')

@php
    // Contact info managed from the admin back-office (Paramètres → Informations de contact).
    // Read live so admin edits reflect immediately. NO fallback: a field that is empty/null
    // in the database is simply NOT displayed.
    $s   = \App\Models\SiteSetting::map();
    $g   = fn($k) => (isset($s[$k]) && trim((string) $s[$k]) !== '') ? trim((string) $s[$k]) : null;
    $tel = fn($v) => preg_replace('/[^0-9+]/', '', (string) $v);

    $companyName  = $g('company_name');
    $phoneLocal   = $g('phone_local');
    $phoneToll    = $g('phone_tollfree');
    $faxNumber    = $g('fax');
    $emailGeneral = $g('email_general');
    $emailSupport = $g('email_support');
    $emailPartner = $g('email_partners');
    $addrLine     = $g('address_line');
    $addrCity     = $g('address_city');
    $addrPostal   = $g('address_postal');
    $addrCountry  = $g('address_country');
    $mapQuery     = $g('map_query');
    $mapsUrl      = $mapQuery ? 'https://maps.google.com/?q=' . urlencode($mapQuery) : null;
    $mapEmbed     = $mapQuery ? 'https://www.google.com/maps?q=' . urlencode($mapQuery) . '&output=embed' : null;

    // City / postal line + full address lines (only present parts)
    if ($addrCity && $addrPostal)      $cityLine = $addrCity . ', ' . $addrPostal;
    elseif ($addrCity)                 $cityLine = $addrCity;
    elseif ($addrPostal)               $cityLine = $addrPostal;
    else                               $cityLine = null;
    $addrLines = array_values(array_filter([$addrLine, $cityLine, $addrCountry]));

    // Contact-line HTML (only for non-empty fields)
    $phoneLines = [];
    if ($phoneToll)  $phoneLines[] = '<strong>Sans frais :</strong> ' . e($phoneToll);
    if ($phoneLocal) $phoneLines[] = '<strong>Local :</strong> <a href="tel:' . e($tel($phoneLocal)) . '" class="inline">' . e($phoneLocal) . '</a>';
    if ($faxNumber)  $phoneLines[] = '<strong>Fax :</strong> ' . e($faxNumber);

    $emailLines = [];
    if ($emailGeneral) $emailLines[] = '<strong>G&eacute;n&eacute;ral :</strong> <a href="mailto:' . e($emailGeneral) . '" class="inline">' . e($emailGeneral) . '</a>';
    if ($emailSupport) $emailLines[] = '<strong>Support :</strong> <a href="mailto:' . e($emailSupport) . '" class="inline">' . e($emailSupport) . '</a>';
    if ($emailPartner) $emailLines[] = '<strong>Partenariats :</strong> <a href="mailto:' . e($emailPartner) . '" class="inline">' . e($emailPartner) . '</a>';

    $hasAddress   = (bool) count($addrLines);
    $hasPhoneCard = (bool) count($phoneLines);
    $hasEmailCard = (bool) count($emailLines);
    $hasMapCard   = $mapEmbed || $hasAddress || $mapsUrl || $phoneLocal;

    // Opening hours — [label, value, isOpen]; drop rows with no value
    $officeHours = array_values(array_filter([
        ['Lundi &mdash; Vendredi', $g('hours_office_weekdays'), false],
        ['Samedi',                 $g('hours_office_saturday'), false],
        ['Dimanche',               $g('hours_office_sunday'),   false],
        ['Jours f&eacute;ri&eacute;s', $g('hours_office_holidays'), false],
    ], fn($r) => $r[1] !== null));
    $supportHours = array_values(array_filter([
        ['Lundi &mdash; Vendredi',   $g('hours_support_weekdays'),  false],
        ['Samedi &mdash; Dimanche',  $g('hours_support_weekend'),   false],
        ['Chat en direct',           $g('hours_support_chat'),      true],
        ['Urgences voyage',          $g('hours_support_emergency'), true],
    ], fn($r) => $r[1] !== null));
    $hasHours = count($officeHours) || count($supportHours);

    $closedRe   = '/^\s*(ferm|closed)/iu';
    $hourClass  = function ($v, $open = false) use ($closedRe) {
        if (preg_match($closedRe, (string) $v)) return 'hours-closed';
        return $open ? 'hours-time hours-open' : 'hours-time';
    };

    $socials = [
        ['key' => 'social_facebook',  'cls' => 'sb-fb', 'icon' => 'fa-facebook-f',  'label' => 'Facebook'],
        ['key' => 'social_instagram', 'cls' => 'sb-ig', 'icon' => 'fa-instagram',   'label' => 'Instagram'],
        ['key' => 'social_youtube',   'cls' => 'sb-yt', 'icon' => 'fa-youtube',     'label' => 'YouTube'],
        ['key' => 'social_linkedin',  'cls' => 'sb-li', 'icon' => 'fa-linkedin-in', 'label' => 'LinkedIn'],
        ['key' => 'social_tiktok',    'cls' => 'sb-tt', 'icon' => 'fa-tiktok',      'label' => 'TikTok'],
    ];
@endphp

{{-- ── HERO ─────────────────────────────────────────────────────── --}}
<section class="cx-hero">
    <span class="cx-hero-orb o1"></span>
    <span class="cx-hero-orb o2"></span>
    <div class="cx-wrap">
        <div class="cx-hero-inner">
            <span class="cx-badge"><i class="fas fa-circle"></i> Contactez-nous</span>
            <h1>Parlons de votre<br><span>prochaine aventure</span></h1>
            <p>Une question, un projet de voyage sur mesure ou une demande de partenariat&nbsp;? Notre &eacute;quipe vous r&eacute;pond en moins de 24&nbsp;heures ouvrables.</p>
            @php $heroHours = $g('hours_office_weekdays'); @endphp
            @if($phoneLocal || $emailGeneral || $heroHours)
            <div class="cx-hero-chips">
                @if($phoneLocal)
                <a href="tel:{{ $tel($phoneLocal) }}" class="cx-chip">
                    <i class="fas fa-phone-alt"></i>
                    <span class="cx-chip-txt"><span class="cx-chip-k">Appelez-nous</span><span class="cx-chip-v">{{ $phoneLocal }}</span></span>
                </a>
                @endif
                @if($emailGeneral)
                <a href="mailto:{{ $emailGeneral }}" class="cx-chip">
                    <i class="fas fa-envelope"></i>
                    <span class="cx-chip-txt"><span class="cx-chip-k">&Eacute;crivez-nous</span><span class="cx-chip-v">{{ $emailGeneral }}</span></span>
                </a>
                @endif
                @if($heroHours)
                <div class="cx-chip">
                    <i class="fas fa-clock"></i>
                    <span class="cx-chip-txt"><span class="cx-chip-k">Lun &ndash; Ven</span><span class="cx-chip-v">{{ $heroHours }}</span></span>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
    <div class="cx-wave">
        <svg viewBox="0 0 1440 70" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,70 L0,70 Z" fill="#f4f6f9"></path>
        </svg>
    </div>
</section>

{{-- ── INFO CARDS ───────────────────────────────────────────────── --}}
<div class="cx-wrap info-strip">
    <div class="info-grid">
        @if($hasAddress || $mapsUrl)
        <div class="info-card card-addr reveal">
            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
            <h3>Notre Bureau</h3>
            @if($hasAddress)<p>{!! implode('<br>', array_map(fn($l) => e($l), $addrLines)) !!}</p>@endif
            @if($mapsUrl)
            <a href="{{ $mapsUrl }}" target="_blank" rel="noopener" class="info-link">
                Voir sur Google Maps <i class="fas fa-arrow-right"></i>
            </a>
            @endif
        </div>
        @endif
        @if($hasPhoneCard)
        <div class="info-card card-phone reveal">
            <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
            <h3>T&eacute;l&eacute;phone &amp; Fax</h3>
            <p>{!! implode('<br>', $phoneLines) !!}</p>
            <span class="info-badge"><i class="fas fa-circle"></i> Disponible maintenant</span>
        </div>
        @endif
        @if($hasEmailCard)
        <div class="info-card card-email reveal">
            <div class="info-icon"><i class="fas fa-envelope"></i></div>
            <h3>Courriel &amp; R&eacute;seaux</h3>
            <p>{!! implode('<br>', $emailLines) !!}</p>
        </div>
        @endif
    </div>
</div>

{{-- ── FORM + MAP ───────────────────────────────────────────────── --}}
<div class="cx-wrap" style="padding-top:80px">
    <div class="cx-head">
        <div class="cx-label">Formulaire de contact</div>
        <h2 class="cx-title">Envoyez-nous un message</h2>
        <p class="cx-sub">R&eacute;ponse garantie sous 24&nbsp;heures ouvrables. Tous les champs marqu&eacute;s * sont obligatoires.</p>
    </div>
    <div class="contact-grid"@if(!$hasMapCard) style="grid-template-columns:1fr"@endif>
        <div class="form-card reveal">
            <h2>Votre demande</h2>
            <p class="sub">Remplissez le formulaire, nous revenons vers vous rapidement.</p>
            <form>
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
                    <label>Sujet *</label>
                    <select>
                        <option value="">-- S&eacute;lectionner un sujet --</option>
                        <option>Demande d&apos;information g&eacute;n&eacute;rale</option>
                        <option>R&eacute;servation de forfait</option>
                        <option>Demande de devis</option>
                        <option>Partenariat commercial</option>
                        <option>Probl&egrave;me technique</option>
                        <option>Autre</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Votre message *</label>
                    <textarea placeholder="D&eacute;crivez votre demande en d&eacute;tail..."></textarea>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Envoyer le message
                </button>
                <p class="form-consent"><i class="fas fa-lock"></i> Vos donn&eacute;es sont confidentielles et ne seront jamais partag&eacute;es.</p>
            </form>
        </div>

        @if($hasMapCard)
        <div class="map-card reveal">
            @if($mapEmbed)
            <div class="map-embed">
                <iframe
                    src="{{ $mapEmbed }}"
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    title="{{ $companyName ? 'Bureau ' . $companyName : 'Localisation' }}"></iframe>
            </div>
            @endif
            @if($hasAddress || $mapsUrl || $phoneLocal)
            <div class="map-info">
                @if($hasAddress)
                <div class="map-info-head">
                    <span class="pin"><i class="fas fa-map-marker-alt"></i></span>
                    <div>
                        @if($addrLine)<p class="map-address">{{ $addrLine }}</p>@endif
                        @if($cityLine || $addrCountry)<p class="map-city">{{ $cityLine }}@if($cityLine && $addrCountry) &mdash; @endif{{ $addrCountry }}</p>@endif
                    </div>
                </div>
                @endif
                @if($mapsUrl || $phoneLocal)
                <div class="map-actions">
                    @if($mapsUrl)
                    <a href="{{ $mapsUrl }}" target="_blank" rel="noopener" class="map-btn map-btn-primary">
                        <i class="fas fa-directions"></i> Itin&eacute;raire
                    </a>
                    @endif
                    @if($phoneLocal)
                    <a href="tel:{{ $tel($phoneLocal) }}" class="map-btn map-btn-secondary">
                        <i class="fas fa-phone"></i> Appeler
                    </a>
                    @endif
                </div>
                @endif
            </div>
            @endif
        </div>
        @endif
    </div>
</div>

{{-- ── HORAIRES ─────────────────────────────────────────────────── --}}
@if($hasHours)
<div class="cx-wrap" style="padding-top:80px">
    <div class="cx-head">
        <div class="cx-label">Disponibilit&eacute;</div>
        <h2 class="cx-title">Horaires d&apos;ouverture</h2>
        <p class="cx-sub">Nos &eacute;quipes sont &agrave; votre service en agence et en ligne.</p>
    </div>
    <div class="hours-grid">
        @if(count($officeHours))
        <div class="hours-card reveal">
            <h3><i class="fas fa-building"></i> Bureau principal @if($addrCity)&mdash; {{ $addrCity }}@endif</h3>
            @foreach($officeHours as $i => $row)
            <div class="hours-row @if($i === 0) hours-today @endif">
                <span class="hours-day">{!! $row[0] !!}</span>
                <span class="{{ $hourClass($row[1], $row[2]) }}">{{ $row[1] }}</span>
            </div>
            @endforeach
        </div>
        @endif
        @if(count($supportHours))
        <div class="hours-card reveal">
            <h3><i class="fas fa-headset"></i> Support en ligne</h3>
            @foreach($supportHours as $i => $row)
            <div class="hours-row @if($i === 0) hours-today @endif">
                <span class="hours-day">{!! $row[0] !!}</span>
                <span class="{{ $hourClass($row[1], $row[2]) }}">{{ $row[1] }}</span>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endif

{{-- ── R&eacute;SEAUX SOCIAUX ──────────────────────────────────────────── --}}
@php
    $activeSocials = array_filter($socials, fn($soc) => $g($soc['key']) && $g($soc['key']) !== '#');
@endphp
@if(count($activeSocials))
<div class="cx-wrap" style="padding-top:80px;padding-bottom:80px">
    <div class="social-band reveal">
        <div class="cx-label">Restons connect&eacute;s</div>
        <h2>Suivez-nous sur les r&eacute;seaux</h2>
        <p>Inspiration voyage, offres exclusives et coulisses de nos destinations &mdash; chaque semaine.</p>
        <div class="social-links">
            @foreach($activeSocials as $soc)
                <a href="{{ $g($soc['key']) }}" target="_blank" rel="noopener" class="social-btn {{ $soc['cls'] }}" aria-label="{{ $soc['label'] }}"><i class="fab {{ $soc['icon'] }}"></i></a>
            @endforeach
        </div>
    </div>
</div>
@endif

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
    // Reveal-on-scroll
    (function(){
        var els = document.querySelectorAll('.reveal');
        if(!('IntersectionObserver' in window)){els.forEach(function(e){e.classList.add('in')});return;}
        var io = new IntersectionObserver(function(entries){
            entries.forEach(function(en){ if(en.isIntersecting){ en.target.classList.add('in'); io.unobserve(en.target); } });
        }, {threshold:.12, rootMargin:'0px 0px -40px 0px'});
        els.forEach(function(e){ io.observe(e); });
    })();
</script>
</body>
</html>
