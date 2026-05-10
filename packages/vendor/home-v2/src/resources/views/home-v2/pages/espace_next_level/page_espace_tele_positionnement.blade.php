{{-- ============================================================
     PAGE DÉTAIL — ESPACES TÉLÉ-POSITIONNEMENT · CONTACT DIRECT
     Avatar · Diffuseur d'Information · Mix Médias · Courriel
     ============================================================ --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Direct – Avatar & Courriel Professionnel | GoExploria Next Level</title>
    <meta name="description" content="Diffusez vos informations en direct chez vos clients cibles grâce à notre avatar avec casque d'écoute, notre diffuseur d'information mix médias et notre outil d'envoi de courriel avec visuels professionnels.">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
*{ margin:0; padding:0; box-sizing:border-box; }
body{ font-family:'DM Sans',sans-serif; background:#fff; color:#1a1a1a; line-height:1.5; }

/* ── Utilities ── */
.cd-container   { max-width:1280px; margin:0 auto; padding:0 24px; }
.cd-grad-text   { background:linear-gradient(135deg,#e8761a,#f59e0b); -webkit-background-clip:text; background-clip:text; color:transparent; }
.cd-section-tag {
    display:inline-flex; align-items:center; gap:8px;
    font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px;
    color:#e8761a; background:#fef3ea; padding:6px 16px; border-radius:999px; margin-bottom:20px;
}
.cd-section-header        { margin-bottom:48px; }
.cd-section-header.center { text-align:center; }
.cd-section-header h2     { font-family:'Playfair Display',serif; font-size:36px; color:#1a1a1a; margin-bottom:16px; line-height:1.2; }
.cd-section-header p      { font-size:16px; color:#666; max-width:600px; margin:0 auto; }

/* ── Buttons ── */
.cd-btn-primary {
    background:#e8761a; color:#fff; padding:14px 28px; border-radius:10px;
    font-weight:700; font-size:14px; text-decoration:none;
    display:inline-flex; align-items:center; gap:8px; transition:all .2s; border:none; cursor:pointer;
}
.cd-btn-primary:hover { background:#c45e0e; transform:translateY(-2px); color:#fff; }
.cd-btn-outline {
    border:2px solid rgba(255,255,255,.3); color:#fff; background:transparent;
    border-radius:10px; font-weight:700; text-decoration:none;
    display:inline-flex; align-items:center; gap:8px; transition:all .2s; padding:14px 28px;
}
.cd-btn-outline:hover { border-color:#e8761a; background:rgba(232,118,26,.15); color:#fff; }
.btn-lg { padding:16px 32px; font-size:15px; }
.btn-xl { padding:18px 36px; font-size:16px; }

/* ═══════════════════════════════
   NAVIGATION
═══════════════════════════════ */
.cd-nav {
    background:#fff; border-bottom:1px solid #e5e7eb;
    position:sticky; top:0; z-index:100;
}
.cd-nav-inner {
    display:flex; justify-content:space-between; align-items:center;
    padding:14px 24px; max-width:1280px; margin:0 auto;
}
.cd-nav-logo { display:flex; align-items:center; gap:10px; text-decoration:none; }
.cd-nav-logo img { height:60px; }
.cd-nav-logo span { font-weight:800; font-size:17px; color:#1a1a1a; }
.cd-nav-links { display:flex; gap:28px; align-items:center; }
.cd-nav-links a { text-decoration:none; color:#555; font-weight:500; font-size:14px; transition:color .2s; }
.cd-nav-links a:hover { color:#e8761a; }
.cd-nav-cta { background:#e8761a; color:#fff !important; padding:8px 20px; border-radius:8px; }

/* ═══════════════════════════════
   HERO
═══════════════════════════════ */
.cd-hero {
    background:linear-gradient(135deg,#0a1628 0%,#1a2a4a 100%);
    padding:80px 0 60px; position:relative; overflow:hidden;
}
.cd-hero::before {
    content:''; position:absolute; top:-30%; right:-20%; width:70%; height:160%;
    background:radial-gradient(circle,rgba(232,118,26,.12) 0%,transparent 70%);
    pointer-events:none;
}
.cd-hero .cd-container { display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center; }

.cd-hero-badge {
    display:inline-flex; align-items:center; gap:10px;
    background:rgba(52,211,153,.15); border:1px solid rgba(52,211,153,.3);
    color:#34d399; border-radius:999px; padding:6px 16px;
    font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:24px;
}
.cd-badge-dot { width:7px; height:7px; background:#34d399; border-radius:50%; animation:cdPulse 2s infinite; }
@keyframes cdPulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(1.4)} }

.cd-hero h1 {
    font-family:'Playfair Display',serif; font-size:clamp(36px,4.5vw,58px);
    color:#fff; line-height:1.1; margin-bottom:24px;
}
.cd-hero-desc {
    font-size:16px; color:rgba(255,255,255,.7); line-height:1.8;
    margin-bottom:32px; max-width:520px;
}
.cd-hero-ctas { display:flex; gap:16px; flex-wrap:wrap; margin-bottom:40px; }
.cd-hero-stats { display:flex; gap:20px; flex-wrap:wrap; }
.cd-stat {
    display:flex; align-items:center; gap:10px;
    background:rgba(255,255,255,.05); padding:10px 16px;
    border-radius:12px; border:1px solid rgba(255,255,255,.1);
}
.cd-stat i        { font-size:22px; color:#e8761a; }
.cd-stat strong   { display:block; font-family:'Bebas Neue',sans-serif; font-size:22px; color:#fff; line-height:1; }
.cd-stat span     { font-size:10px; color:rgba(255,255,255,.6); text-transform:uppercase; letter-spacing:.5px; }

/* ── Hero visual ── */
.cd-hero-visual { position:relative; display:flex; flex-direction:column; gap:20px; }

/* Avatar card */
.cd-avatar-card {
    background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.12);
    border-radius:20px; padding:20px 24px;
    display:flex; align-items:center; gap:16px;
    backdrop-filter:blur(12px);
}
.cd-avatar-wrap { position:relative; flex-shrink:0; }
.cd-avatar-img  {
    width:100px; height:100px; border-radius:50%;
    object-fit:cover; object-position:top;
    border:3px solid #e8761a;
}
.cd-avatar-live {
    position:absolute; bottom:-4px; left:50%; transform:translateX(-50%);
    background:#10b981; color:#fff; font-size:8px; font-weight:700;
    padding:2px 8px; border-radius:999px; white-space:nowrap;
    display:flex; align-items:center; gap:4px;
}
.cd-avatar-live i { font-size:6px; animation:cdBlink 1.5s infinite; }
@keyframes cdBlink { 0%,100%{opacity:1} 50%{opacity:.2} }
.cd-avatar-info strong { display:block; font-size:15px; color:#fff; font-weight:700; }
.cd-avatar-info span   { font-size:11px; color:rgba(255,255,255,.5); }
.cd-avatar-wave { display:flex; align-items:center; gap:3px; margin-left:auto; }
.cd-avatar-wave span { display:block; width:4px; border-radius:99px; background:#e8761a; animation:cdWave 1.2s ease-in-out infinite; }
.cd-avatar-wave span:nth-child(1){ height:8px;  animation-delay:0s; }
.cd-avatar-wave span:nth-child(2){ height:16px; animation-delay:.1s; }
.cd-avatar-wave span:nth-child(3){ height:24px; animation-delay:.2s; }
.cd-avatar-wave span:nth-child(4){ height:16px; animation-delay:.3s; }
.cd-avatar-wave span:nth-child(5){ height:8px;  animation-delay:.4s; }
@keyframes cdWave { 0%,100%{transform:scaleY(1);opacity:.6} 50%{transform:scaleY(1.8);opacity:1} }

/* Email mock */
.cd-email-mock { background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 16px 48px rgba(0,0,0,.2); }
.cd-email-topbar { background:#f3f4f6; padding:10px 16px; display:flex; align-items:center; gap:10px; border-bottom:1px solid #e5e7eb; }
.cd-email-dots { display:flex; gap:5px; }
.cd-email-dots span { width:10px; height:10px; border-radius:50%; display:block; }
.cd-email-topbar-title { font-size:12px; font-weight:600; color:#555; display:flex; align-items:center; gap:6px; }
.cd-email-topbar-title i { color:#e8761a; }
.cd-email-meta { padding:10px 16px; border-bottom:1px solid #f0f0f0; }
.cd-email-row  { display:flex; gap:8px; font-size:11px; padding:2px 0; }
.cd-email-row label { color:#999; min-width:36px; }
.cd-email-row span  { color:#555; }
.cd-email-subject   { color:#1a1a1a; font-weight:700; }
.cd-email-body   { padding:16px; }
.cd-email-banner {
    background:linear-gradient(135deg,#0a1628,#1e3a5f);
    border-radius:10px; padding:14px 16px;
    display:flex; align-items:center; gap:12px; margin-bottom:14px;
}
.cd-email-banner i        { font-size:26px; color:#e8761a; }
.cd-email-banner strong   { display:block; font-size:13px; color:#fff; }
.cd-email-banner span     { font-size:11px; color:rgba(255,255,255,.6); }
.cd-email-lines { display:flex; flex-direction:column; gap:6px; margin-bottom:14px; }
.cd-eline { height:9px; background:#f0f0f0; border-radius:4px; }
.cd-eline-lg { width:92%; } .cd-eline-md { width:72%; } .cd-eline-sm { width:52%; }
.cd-email-cta-wrap { display:flex; gap:10px; margin-bottom:12px; }
.cd-email-cta-btn {
    background:linear-gradient(135deg,#e8761a,#c04f10);
    color:#fff; border-radius:8px; padding:10px 18px;
    font-size:12px; font-weight:700;
    display:inline-flex; align-items:center; gap:6px;
}
.cd-email-footer-strip { border-top:1px solid #f0f0f0; padding-top:10px; }
.cd-floating-card {
    position:absolute; bottom:-14px; left:-18px; background:#fff;
    border-radius:12px; padding:10px 14px;
    display:flex; align-items:center; gap:10px;
    box-shadow:0 8px 20px rgba(0,0,0,.15);
}
.cd-floating-card i        { font-size:18px; color:#10b981; }
.cd-floating-card strong   { display:block; font-size:11px; color:#1a1a1a; }
.cd-floating-card span     { font-size:10px; color:#666; }

/* ═══════════════════════════════
   FEATURES
═══════════════════════════════ */
.cd-features { padding:80px 0; background:#fff; }
.cd-features-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:24px; }
.cd-feature-card {
    background:#fff; border:1.5px solid #e5e7eb;
    border-radius:20px; padding:32px; transition:all .3s;
}
.cd-feature-card:hover { transform:translateY(-4px); border-color:#e8761a; box-shadow:0 20px 40px rgba(0,0,0,.08); }
.cd-feature-icon {
    width:52px; height:52px; border-radius:14px;
    display:flex; align-items:center; justify-content:center;
    font-size:22px; margin-bottom:18px;
}
.cd-feature-card h3 { font-size:16px; font-weight:700; color:#1a1a1a; margin-bottom:10px; }
.cd-feature-card p  { font-size:13px; color:#666; line-height:1.7; margin-bottom:16px; }
.cd-feature-tag {
    display:inline-block; font-size:10px; font-weight:700;
    text-transform:uppercase; letter-spacing:.8px; padding:4px 10px; border-radius:6px;
}

/* ═══════════════════════════════
   HOW IT WORKS
═══════════════════════════════ */
.cd-how { padding:80px 0; background:#f8faff; }
.cd-how-wrapper {
    background:linear-gradient(135deg,#0a1628,#1e3a5f);
    border-radius:28px; padding:60px 48px;
}
.cd-how-wrapper .cd-section-header h2 { color:#fff; }
.cd-how-wrapper .cd-section-header p  { color:rgba(255,255,255,.6); }
.cd-how-wrapper .cd-section-tag { background:rgba(232,118,26,.2); }
.cd-steps { display:flex; align-items:flex-start; gap:20px; justify-content:center; flex-wrap:wrap; }
.cd-step {
    flex:1; min-width:200px; max-width:260px; text-align:center;
    background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.1);
    border-radius:20px; padding:36px 24px; position:relative;
}
.cd-step-num {
    position:absolute; top:-14px; left:50%; transform:translateX(-50%);
    font-family:'Bebas Neue',sans-serif; font-size:28px; color:#e8761a;
    background:#0a1628; padding:0 8px; line-height:1;
}
.cd-step-icon {
    width:60px; height:60px; background:rgba(232,118,26,.15);
    border-radius:18px; display:flex; align-items:center; justify-content:center;
    font-size:26px; color:#e8761a; margin:14px auto 20px;
}
.cd-step h3 { font-size:18px; color:#fff; font-weight:700; margin-bottom:10px; }
.cd-step p  { font-size:13px; color:rgba(255,255,255,.6); line-height:1.7; }
.cd-step-arrow { font-size:24px; color:rgba(255,255,255,.25); flex-shrink:0; padding-top:80px; }

/* ═══════════════════════════════
   BENEFITS
═══════════════════════════════ */
.cd-benefits-sec { padding:80px 0; background:#fff; }
.cd-benefits-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:24px; }
.cd-benefit-card {
    text-align:center; padding:32px 24px; background:#f8faff;
    border-radius:20px; transition:all .3s;
}
.cd-benefit-card:hover { transform:translateY(-4px); background:#fff; box-shadow:0 12px 24px rgba(0,0,0,.08); }
.cd-benefit-icon {
    width:70px; height:70px; background:linear-gradient(135deg,#e8761a20,#f59e0b20);
    border-radius:24px; display:flex; align-items:center; justify-content:center;
    margin:0 auto 20px; font-size:32px; color:#e8761a;
}
.cd-benefit-card h3 { font-size:18px; margin-bottom:10px; font-weight:700; }
.cd-benefit-card p  { font-size:13px; color:#666; line-height:1.6; }

/* ═══════════════════════════════
   USE CASES
═══════════════════════════════ */
.cd-usecases { padding:80px 0; background:#f8faff; }
.cd-usecases-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:24px; }
.cd-usecase-card {
    background:#fff; border-radius:20px; padding:32px; text-align:center;
    transition:all .3s; border:1px solid #e5e7eb;
}
.cd-usecase-card:hover { transform:translateY(-4px); border-color:#e8761a; }
.cd-usecase-icon {
    width:64px; height:64px; background:linear-gradient(135deg,#e8761a20,#f59e0b20);
    border-radius:20px; display:flex; align-items:center; justify-content:center;
    margin:0 auto 20px; font-size:28px; color:#e8761a;
}
.cd-usecase-card h3 { font-size:17px; margin-bottom:10px; font-weight:700; }
.cd-usecase-card p  { font-size:13px; color:#666; }

/* ═══════════════════════════════
   TECHNOLOGIES / CHANNELS
═══════════════════════════════ */
.cd-tech { padding:80px 0; background:#fff; }
.cd-tech-wrapper { background:#f8faff; border-radius:28px; padding:56px; border:1px solid #e5e7eb; }
.cd-tech-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:24px; margin-top:40px; }
.cd-tech-item { text-align:center; padding:24px; background:#fff; border-radius:16px; transition:all .3s; }
.cd-tech-item:hover { transform:translateY(-4px); box-shadow:0 8px 16px rgba(0,0,0,.08); }
.cd-tech-item i    { font-size:36px; color:#e8761a; margin-bottom:12px; }
.cd-tech-item h4   { font-size:14px; font-weight:700; margin-bottom:6px; }
.cd-tech-item span { font-size:11px; color:#888; }

/* ═══════════════════════════════
   FAQ
═══════════════════════════════ */
.cd-faq { padding:80px 0; background:#f8faff; }
.cd-faq-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:20px; margin-top:40px; }
.cd-faq-item { background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:20px 24px; transition:all .2s; }
.cd-faq-item:hover { border-color:#e8761a; }
.cd-faq-question { font-weight:700; font-size:15px; color:#1a1a1a; display:flex; align-items:center; gap:10px; cursor:pointer; }
.cd-faq-question i { color:#e8761a; font-size:14px; }
.cd-faq-answer { font-size:13px; color:#666; line-height:1.7; margin-top:12px; padding-top:12px; border-top:1px solid #f0f0f0; display:none; }
.cd-faq-answer.active { display:block; }

/* ═══════════════════════════════
   DEMO FORM
═══════════════════════════════ */
.cd-demo { padding:80px 0; background:#fff; }
.cd-form-wrapper {
    background:linear-gradient(135deg,#f8faff,#fff);
    border:1px solid #e5e7eb; border-radius:28px; padding:56px;
    display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center;
}
.cd-form-badge {
    display:inline-flex; align-items:center; gap:6px;
    font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px;
    color:#10b981; background:rgba(16,185,129,.1); padding:6px 14px;
    border-radius:999px; margin-bottom:16px;
}
.cd-form-left h2    { font-family:'Playfair Display',serif; font-size:32px; margin-bottom:14px; }
.cd-form-left h2 em { font-style:italic; color:#e8761a; }
.cd-form-left p     { font-size:15px; color:#666; line-height:1.8; margin-bottom:24px; }
.cd-form-perks { list-style:none; display:flex; flex-direction:column; gap:12px; }
.cd-form-perks li { font-size:14px; color:#444; display:flex; align-items:center; gap:10px; }
.cd-form-perks li i { color:#10b981; }
.cd-form-group  { margin-bottom:16px; }
.cd-form-row    { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.cd-form-group label { display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:6px; }
.cd-form-group input,
.cd-form-group select {
    width:100%; border:1.5px solid #e5e7eb; border-radius:10px;
    padding:12px 14px; font-size:14px; transition:border-color .2s;
}
.cd-form-group input:focus,
.cd-form-group select:focus { outline:none; border-color:#e8761a; }
.cd-btn-submit {
    width:100%; background:linear-gradient(135deg,#e8761a,#c04f10);
    color:#fff; border:none; border-radius:10px; padding:14px;
    font-size:14px; font-weight:700; cursor:pointer;
    display:flex; align-items:center; justify-content:center; gap:8px;
    transition:all .2s; margin-top:8px;
}
.cd-btn-submit:hover { transform:translateY(-2px); box-shadow:0 12px 32px rgba(232,118,26,.35); }
.cd-form-note { font-size:11px; color:#9ca3af; text-align:center; margin-top:12px; }

/* ═══════════════════════════════
   CTA FINAL
═══════════════════════════════ */
.cd-cta-sec { padding:80px 0; background:linear-gradient(135deg,#fef3ea,#fff3e6); }
.cd-cta-inner { text-align:center; max-width:800px; margin:0 auto; }
.cd-cta-inner h2 { font-family:'Playfair Display',serif; font-size:40px; color:#1a1a1a; margin-bottom:16px; }
.cd-cta-inner p  { font-size:16px; color:#666; margin-bottom:32px; }
.cd-cta-btns { display:flex; gap:20px; justify-content:center; flex-wrap:wrap; margin-bottom:24px; }
.cd-cta-note { font-size:13px; color:#888; }

/* ── Footer ── */
.cd-footer { background:#0a1628; padding:40px 0; text-align:center; color:rgba(255,255,255,.45); font-size:13px; }

/* ── Responsive ── */
@media(max-width:1200px){
    .cd-features-grid { grid-template-columns:repeat(2,1fr); }
    .cd-benefits-grid { grid-template-columns:repeat(2,1fr); }
    .cd-usecases-grid { grid-template-columns:repeat(2,1fr); }
    .cd-tech-grid     { grid-template-columns:repeat(2,1fr); }
    .cd-faq-grid      { grid-template-columns:1fr; }
}
@media(max-width:1000px){
    .cd-hero .cd-container { grid-template-columns:1fr; }
    .cd-form-wrapper { grid-template-columns:1fr; gap:32px; }
    .cd-nav-links    { display:none; }
    .cd-steps        { flex-direction:column; align-items:stretch; }
    .cd-step-arrow   { transform:rotate(90deg); text-align:center; padding-top:0; }
}
@media(max-width:768px){
    .cd-container     { padding:0 20px; }
    .cd-features-grid { grid-template-columns:1fr; }
    .cd-benefits-grid { grid-template-columns:1fr; }
    .cd-usecases-grid { grid-template-columns:1fr; }
    .cd-tech-grid     { grid-template-columns:1fr; }
    .cd-form-wrapper  { padding:32px 24px; }
    .cd-form-row      { grid-template-columns:1fr; }
    .cd-floating-card { position:static; margin-top:8px; }
}
</style>
</head>
<body>

{{-- NAVIGATION --}}
<nav class="cd-nav">
    <div class="cd-nav-inner">
        <a href="#" class="cd-nav-logo">
            <img src="{{ asset('logo.png') }}" alt="GoExploria Next Level">
        </a>
        <div class="cd-nav-links">
            <a href="#features">Fonctionnalités</a>
            <a href="#how">Comment ça marche</a>
            <a href="#faq">FAQ</a>
            <a href="{{ route('devis') }}" class="cd-nav-cta">Demander un devis</a>
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="cd-hero">
    <div class="cd-container">
        <div>
            <div class="cd-hero-badge">
                <span class="cd-badge-dot"></span>
                Diffusion en direct · Mix Médias Intelligent
            </div>
            <h1>
                Contact direct<br>
                <span class="cd-grad-text">chez vos clients cibles</span>
            </h1>
            <p class="cd-hero-desc">
                La meilleure façon de diffuser vos informations en direct grâce au diffuseur d'information et au mix médias contact direct client cible — incluant un avatar avec casque d'écoute, l'envoi de courriel avec visuel professionnel adapté à vos services.
            </p>
            <div class="cd-hero-ctas">
                <a href="{{ route('devis') }}" class="cd-btn-primary btn-lg">
                    <i class="fas fa-paper-plane"></i> Demander un devis
                </a>
                <a href="#how" class="cd-btn-outline btn-lg">
                    <i class="fas fa-play-circle"></i> Voir comment ça marche
                </a>
            </div>
            <div class="cd-hero-stats">
                <div class="cd-stat"><i class="fas fa-user-headset"></i><div><strong>100%</strong><span>Personnalisé</span></div></div>
                <div class="cd-stat"><i class="fas fa-bolt"></i><div><strong>&lt;2s</strong><span>Diffusion</span></div></div>
                <div class="cd-stat"><i class="fas fa-layer-group"></i><div><strong>Multi</strong><span>Canaux</span></div></div>
                <div class="cd-stat"><i class="fas fa-shield-alt"></i><div><strong>RGPD</strong><span>Conforme</span></div></div>
            </div>
        </div>
        <div class="cd-hero-visual">
            {{-- Avatar card --}}
            <div class="cd-avatar-card">
                <div class="cd-avatar-wrap">
                    <img src="{{ asset('images/ASSISTANT-WEB-G-EX.png') }}" alt="Assistants Web GoExploria" class="cd-avatar-img">
                    <span class="cd-avatar-live"><i class="fas fa-circle"></i> En direct</span>
                </div>
                <div class="cd-avatar-info">
                    <strong>Assistants Web</strong>
                    <span>Contact Direct · GoExploria</span>
                </div>
                <div class="cd-avatar-wave">
                    <span></span><span></span><span></span><span></span><span></span>
                </div>
            </div>
            {{-- Email mock --}}
            <div class="cd-email-mock">
                <div class="cd-email-topbar">
                    <div class="cd-email-dots">
                        <span style="background:#ef4444"></span>
                        <span style="background:#f59e0b"></span>
                        <span style="background:#10b981"></span>
                    </div>
                    <span class="cd-email-topbar-title"><i class="fas fa-envelope"></i> Nouveau message</span>
                </div>
                <div class="cd-email-meta">
                    <div class="cd-email-row"><label>De :</label><span>contact@goexploria.com</span></div>
                    <div class="cd-email-row"><label>À :</label><span>client.cible@entreprise.com</span></div>
                    <div class="cd-email-row"><label>Objet :</label><span class="cd-email-subject">🚀 Votre offre personnalisée est prête</span></div>
                </div>
                <div class="cd-email-body">
                    <div class="cd-email-banner">
                        <i class="fas fa-user-headset"></i>
                        <div>
                            <strong>GoExploria · Assistants Web</strong>
                            <span>Solutions de communication directe</span>
                        </div>
                    </div>
                    <div class="cd-email-lines">
                        <div class="cd-eline cd-eline-lg"></div>
                        <div class="cd-eline cd-eline-md"></div>
                        <div class="cd-eline cd-eline-sm"></div>
                        <div class="cd-eline cd-eline-md"></div>
                    </div>
                    <div class="cd-email-cta-wrap">
                        <div class="cd-email-cta-btn"><i class="fas fa-arrow-right"></i> Voir mon offre</div>
                    </div>
                    <div class="cd-email-footer-strip">
                        <div class="cd-eline cd-eline-sm" style="width:40%"></div>
                    </div>
                </div>
            </div>
            {{-- Floating --}}
            <div class="cd-floating-card">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>Message envoyé !</strong>
                    <span>1 240 clients atteints · 14:32</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FEATURES --}}
<section class="cd-features" id="features">
    <div class="cd-container">
        <div class="cd-section-header center">
            <span class="cd-section-tag"><i class="fas fa-cogs"></i> Fonctionnalités</span>
            <h2>Une solution complète de<br><span class="cd-grad-text">communication directe</span></h2>
            <p>Combinez avatar, diffusion et courriel professionnel pour toucher vos clients cibles avec impact.</p>
        </div>
        <div class="cd-features-grid">
            <div class="cd-feature-card">
                <div class="cd-feature-icon" style="background:#e8761a20;color:#e8761a"><i class="fas fa-user-headset"></i></div>
                <h3>Contact Direct Avatar</h3>
                <p>Un avatar professionnel avec casque d'écoute prend en charge vos clients cibles en temps réel. Interaction humaine et digitale fusionnée.</p>
                <div class="cd-feature-tag" style="background:#e8761a15;color:#e8761a">Avatar Live</div>
            </div>
            <div class="cd-feature-card">
                <div class="cd-feature-icon" style="background:#3b82f620;color:#3b82f6"><i class="fas fa-broadcast-tower"></i></div>
                <h3>Diffuseur d'Information</h3>
                <p>Diffusez vos messages directement chez vos clients cibles via le mix médias : SMS, push, audio et visual broadcasting en simultané.</p>
                <div class="cd-feature-tag" style="background:#3b82f615;color:#3b82f6">Broadcast</div>
            </div>
            <div class="cd-feature-card">
                <div class="cd-feature-icon" style="background:#10b98120;color:#10b981"><i class="fas fa-envelope-open-text"></i></div>
                <h3>Courriel Professionnel</h3>
                <p>Créez et envoyez des courriels avec visuels professionnels adaptés à vos services. Templates responsive, brandés et percutants.</p>
                <div class="cd-feature-tag" style="background:#10b98115;color:#10b981">Email Pro</div>
            </div>
            <div class="cd-feature-card">
                <div class="cd-feature-icon" style="background:#8b5cf620;color:#8b5cf6"><i class="fas fa-photo-video"></i></div>
                <h3>Visuel Adapté à Vos Services</h3>
                <p>Chaque communication inclut un visuel professionnel sur-mesure. Images, bannières et médias riches adaptés à votre identité.</p>
                <div class="cd-feature-tag" style="background:#8b5cf615;color:#8b5cf6">Rich Media</div>
            </div>
            <div class="cd-feature-card">
                <div class="cd-feature-icon" style="background:#f59e0b20;color:#f59e0b"><i class="fas fa-bullseye"></i></div>
                <h3>Ciblage Client Précis</h3>
                <p>Atteignez exactement vos clients cibles grâce au mix médias intelligent. Segmentation avancée et personnalisation de masse.</p>
                <div class="cd-feature-tag" style="background:#f59e0b15;color:#f59e0b">Targeting</div>
            </div>
            <div class="cd-feature-card">
                <div class="cd-feature-icon" style="background:#ef444420;color:#ef4444"><i class="fas fa-chart-bar"></i></div>
                <h3>Suivi & Performance</h3>
                <p>Mesurez l'impact de chaque diffusion en temps réel : taux d'ouverture, clics, conversions et retour sur investissement.</p>
                <div class="cd-feature-tag" style="background:#ef444415;color:#ef4444">Analytics</div>
            </div>
        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section class="cd-how" id="how">
    <div class="cd-container">
        <div class="cd-how-wrapper">
            <div class="cd-section-header center">
                <span class="cd-section-tag"><i class="fas fa-play-circle"></i> Comment ça marche</span>
                <h2>Diffusez en 3 étapes simples</h2>
                <p>De la définition de votre cible à la diffusion en temps réel, tout en quelques minutes.</p>
            </div>
            <div class="cd-steps">
                <div class="cd-step">
                    <div class="cd-step-num">01</div>
                    <div class="cd-step-icon"><i class="fas fa-bullseye"></i></div>
                    <h3>Ciblez</h3>
                    <p>Définissez votre audience : segmentation géographique, comportementale ou sectorielle.</p>
                </div>
                <div class="cd-step-arrow"><i class="fas fa-chevron-right"></i></div>
                <div class="cd-step">
                    <div class="cd-step-num">02</div>
                    <div class="cd-step-icon"><i class="fas fa-paint-brush"></i></div>
                    <h3>Créez</h3>
                    <p>Composez votre message avec notre éditeur : avatar, courriel visuel et contenu multimédia.</p>
                </div>
                <div class="cd-step-arrow"><i class="fas fa-chevron-right"></i></div>
                <div class="cd-step">
                    <div class="cd-step-num">03</div>
                    <div class="cd-step-icon"><i class="fas fa-broadcast-tower"></i></div>
                    <h3>Diffusez</h3>
                    <p>Lancez votre campagne en un clic. Suivez les résultats en temps réel depuis votre tableau de bord.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BENEFITS --}}
<section class="cd-benefits-sec">
    <div class="cd-container">
        <div class="cd-section-header center">
            <span class="cd-section-tag"><i class="fas fa-chart-line"></i> Bénéfices</span>
            <h2>Pourquoi choisir<br><span class="cd-grad-text">le contact direct ?</span></h2>
            <p>Des résultats concrets pour votre communication.</p>
        </div>
        <div class="cd-benefits-grid">
            <div class="cd-benefit-card">
                <div class="cd-benefit-icon"><i class="fas fa-bolt"></i></div>
                <h3>Impact immédiat</h3>
                <p>Vos messages atteignent vos clients en moins de 2 secondes sur tous les canaux.</p>
            </div>
            <div class="cd-benefit-card">
                <div class="cd-benefit-icon"><i class="fas fa-users"></i></div>
                <h3>Engagement accru</h3>
                <p>+65% de taux d'ouverture grâce à l'avatar et au visuel professionnel personnalisé.</p>
            </div>
            <div class="cd-benefit-card">
                <div class="cd-benefit-icon"><i class="fas fa-euro-sign"></i></div>
                <h3>Coût optimisé</h3>
                <p>Réduisez votre coût par contact de 40% par rapport aux méthodes traditionnelles.</p>
            </div>
            <div class="cd-benefit-card">
                <div class="cd-benefit-icon"><i class="fas fa-chart-pie"></i></div>
                <h3>Mesurable à 100%</h3>
                <p>Chaque diffusion est tracée en temps réel : ouvertures, clics, conversions, ROI.</p>
            </div>
        </div>
    </div>
</section>

{{-- USE CASES --}}
<section class="cd-usecases" id="usecases">
    <div class="cd-container">
        <div class="cd-section-header center">
            <span class="cd-section-tag"><i class="fas fa-briefcase"></i> Cas d'usage</span>
            <h2>Adapté à tous les secteurs<br><span class="cd-grad-text">d'activité</span></h2>
            <p>Des solutions de contact direct sur mesure pour chaque métier.</p>
        </div>
        <div class="cd-usecases-grid">
            <div class="cd-usecase-card">
                <div class="cd-usecase-icon"><i class="fas fa-store"></i></div>
                <h3>Commerces & Retail</h3>
                <p>Informez vos clients en direct de vos promotions, nouveautés et événements via courriel et diffusion multicanal.</p>
            </div>
            <div class="cd-usecase-card">
                <div class="cd-usecase-icon"><i class="fas fa-clinic-medical"></i></div>
                <h3>Santé & Bien-être</h3>
                <p>Communiquez avec vos patients pour rappels, informations de santé et suivi personnalisé.</p>
            </div>
            <div class="cd-usecase-card">
                <div class="cd-usecase-icon"><i class="fas fa-graduation-cap"></i></div>
                <h3>Éducation & Formation</h3>
                <p>Engagez vos apprenants avec du contenu adapté, des rappels et des newsletters visuelles.</p>
            </div>
            <div class="cd-usecase-card">
                <div class="cd-usecase-icon"><i class="fas fa-hotel"></i></div>
                <h3>Hôtellerie & Tourisme</h3>
                <p>Fidélisez vos voyageurs avec des offres personnalisées et des communications visuelles haut de gamme.</p>
            </div>
            <div class="cd-usecase-card">
                <div class="cd-usecase-icon"><i class="fas fa-building"></i></div>
                <h3>Immobilier</h3>
                <p>Touchez vos prospects avec des présentations immobilières visuelles envoyées directement dans leur boîte mail.</p>
            </div>
            <div class="cd-usecase-card">
                <div class="cd-usecase-icon"><i class="fas fa-concierge-bell"></i></div>
                <h3>Services aux entreprises</h3>
                <p>Renforcez votre relation B2B avec des communications professionnelles ciblées et mesurables.</p>
            </div>
        </div>
    </div>
</section>

{{-- TECHNOLOGIES --}}
<section class="cd-tech">
    <div class="cd-container">
        <div class="cd-tech-wrapper">
            <div class="cd-section-header center">
                <span class="cd-section-tag"><i class="fas fa-layer-group"></i> Canaux supportés</span>
                <h2>Multi-canaux,<br><span class="cd-grad-text">multi-appareils</span></h2>
                <p>Notre solution s'adapte à tous vos modes de communication.</p>
            </div>
            <div class="cd-tech-grid">
                <div class="cd-tech-item">
                    <i class="fas fa-user-headset"></i><h4>Avatar Live</h4><span>Contact temps réel</span>
                </div>
                <div class="cd-tech-item">
                    <i class="fas fa-envelope-open-text"></i><h4>Courriel HTML</h4><span>Visuel professionnel</span>
                </div>
                <div class="cd-tech-item">
                    <i class="fas fa-sms"></i><h4>SMS & MMS</h4><span>Diffusion directe</span>
                </div>
                <div class="cd-tech-item">
                    <i class="fas fa-bell"></i><h4>Push Notification</h4><span>Mobile & Web</span>
                </div>
                <div class="cd-tech-item">
                    <i class="fas fa-photo-video"></i><h4>Rich Media</h4><span>Image & Vidéo</span>
                </div>
                <div class="cd-tech-item">
                    <i class="fas fa-broadcast-tower"></i><h4>Broadcast Live</h4><span>Diffusion simultanée</span>
                </div>
                <div class="cd-tech-item">
                    <i class="fas fa-code"></i><h4>API REST</h4><span>Intégration sur mesure</span>
                </div>
                <div class="cd-tech-item">
                    <i class="fas fa-chart-bar"></i><h4>Analytics</h4><span>Tableau de bord temps réel</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="cd-faq" id="faq">
    <div class="cd-container">
        <div class="cd-section-header center">
            <span class="cd-section-tag"><i class="fas fa-question-circle"></i> FAQ</span>
            <h2>Tout ce que vous <span class="cd-grad-text">devez savoir</span></h2>
        </div>
        <div class="cd-faq-grid">
            <div class="cd-faq-item">
                <div class="cd-faq-question"><i class="fas fa-plus-circle"></i> Comment fonctionne l'avatar avec casque d'écoute ?</div>
                <div class="cd-faq-answer">Notre avatar est une représentation digitale professionnelle de votre marque. Il peut répondre en temps réel aux clients, diffuser des messages personnalisés et créer un lien humain dans vos communications digitales.</div>
            </div>
            <div class="cd-faq-item">
                <div class="cd-faq-question"><i class="fas fa-plus-circle"></i> Qu'est-ce que le diffuseur d'information mix médias ?</div>
                <div class="cd-faq-answer">Notre diffuseur d'information permet d'envoyer simultanément votre message sur plusieurs canaux : courriel, SMS, push notification et broadcast live. Vous atteignez vos clients là où ils se trouvent, en un seul clic.</div>
            </div>
            <div class="cd-faq-item">
                <div class="cd-faq-question"><i class="fas fa-plus-circle"></i> Les visuels sont-ils adaptés à mon secteur ?</div>
                <div class="cd-faq-answer">Absolument. Nos équipes créent des visuels professionnels adaptés à votre identité et à votre secteur d'activité. Vous pouvez également utiliser notre éditeur en ligne pour personnaliser vos templates.</div>
            </div>
            <div class="cd-faq-item">
                <div class="cd-faq-question"><i class="fas fa-plus-circle"></i> Combien de temps pour lancer une campagne ?</div>
                <div class="cd-faq-answer">Avec nos templates prêts à l'emploi, vous pouvez lancer votre première campagne en moins de 15 minutes. Notre équipe vous accompagne lors de l'onboarding pour une prise en main rapide.</div>
            </div>
            <div class="cd-faq-item">
                <div class="cd-faq-question"><i class="fas fa-plus-circle"></i> Comment est assuré le respect du RGPD ?</div>
                <div class="cd-faq-answer">Toutes nos communications intègrent des mécanismes de désinscription conformes au RGPD. Nous gérons les consentements, les préférences et l'archivage légal de vos données d'envoi.</div>
            </div>
            <div class="cd-faq-item">
                <div class="cd-faq-question"><i class="fas fa-plus-circle"></i> Puis-je intégrer ma base de contacts existante ?</div>
                <div class="cd-faq-answer">Oui, vous pouvez importer votre base de contacts en CSV ou via notre API REST. Nous supportons également les intégrations CRM (HubSpot, Salesforce, Zoho) pour une synchronisation automatique.</div>
            </div>
        </div>
    </div>
</section>

{{-- DEMO FORM --}}
<section class="cd-demo" id="demo">
    <div class="cd-container">
        <div class="cd-form-wrapper">
            <div class="cd-form-left">
                <div class="cd-form-badge"><i class="fas fa-calendar-alt"></i> Démo gratuite</div>
                <h2>Testez le contact direct<br><em>pendant 14 jours</em></h2>
                <p>Créez votre premier message avec avatar, configurez votre courriel visuel et diffusez à vos clients cibles.</p>
                <ul class="cd-form-perks">
                    <li><i class="fas fa-check-circle"></i> Avatar personnalisé inclus</li>
                    <li><i class="fas fa-check-circle"></i> 500 envois offerts</li>
                    <li><i class="fas fa-check-circle"></i> Templates professionnels</li>
                    <li><i class="fas fa-check-circle"></i> Sans carte bancaire</li>
                </ul>
            </div>
            <div>
                <form id="cdDemoForm">
                    <div class="cd-form-group">
                        <label>Nom de l'entreprise</label>
                        <input type="text" placeholder="Ex: Ma Société" required>
                    </div>
                    <div class="cd-form-row">
                        <div class="cd-form-group">
                            <label>Votre nom</label>
                            <input type="text" placeholder="Jean Dupont" required>
                        </div>
                        <div class="cd-form-group">
                            <label>Email professionnel</label>
                            <input type="email" placeholder="contact@entreprise.com" required>
                        </div>
                    </div>
                    <div class="cd-form-group">
                        <label>Volume d'envoi mensuel</label>
                        <select required>
                            <option value="">Sélectionnez</option>
                            <option>Moins de 500</option>
                            <option>500 – 5 000</option>
                            <option>5 000 – 20 000</option>
                            <option>20 000 – 100 000</option>
                            <option>100 000+</option>
                        </select>
                    </div>
                    <button type="submit" class="cd-btn-submit">
                        <i class="fas fa-paper-plane"></i> Démarrer ma démo gratuite
                    </button>
                    <p class="cd-form-note">Démo immédiate · Aucun engagement · Support inclus</p>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- CTA FINAL --}}
<section class="cd-cta-sec">
    <div class="cd-container">
        <div class="cd-cta-inner">
            <i class="fas fa-user-headset" style="font-size:48px;color:#e8761a;margin-bottom:20px;display:block;"></i>
            <h2>Prêt à communiquer directement avec vos clients ?</h2>
            <p>Rejoignez des centaines d'entreprises qui diffusent leurs informations en direct grâce à nos solutions de contact direct.</p>
            <div class="cd-cta-btns">
                <a href="#demo" class="cd-btn-primary btn-xl"><i class="fas fa-rocket"></i> Démarrer ma démo gratuite</a>
                <a href="{{ route('devis') }}" class="cd-btn-primary btn-xl" style="background:linear-gradient(135deg,#0a1628,#1e3a5f);">
                    <i class="fas fa-headset"></i> Parler à un expert
                </a>
            </div>
            <p class="cd-cta-note"><i class="fas fa-check-circle" style="color:#10b981"></i> Essai 14 jours · Sans engagement · Installation accompagnée</p>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="cd-footer">
    <div class="cd-container">
        <p>© 2026 GoExploria Next Level. Tous droits réservés.</p>
    </div>
</footer>

<script>
document.querySelectorAll('.cd-faq-question').forEach(q => {
    q.addEventListener('click', () => {
        const a = q.nextElementSibling;
        a.classList.toggle('active');
        const ic = q.querySelector('i');
        ic.classList.toggle('fa-plus-circle');
        ic.classList.toggle('fa-minus-circle');
    });
});
document.getElementById('cdDemoForm')?.addEventListener('submit', function(e){
    e.preventDefault();
    alert('Merci ! Votre demande de démo a été enregistrée. Un expert vous contacte sous 24h.');
    this.reset();
});
</script>
</body>
</html>