<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Activez vos Plans Next Level | GoExploria Business — Entreprises, Destinations, Partenaires, Activités, Produits</title>
<meta name="description" content="Choisissez votre espace GoExploria Business Next Level : Entreprise Pro, Destination touristique, Programme Partenaire, Activités ou Boutique. Solutions clé-en-main, démarrage en 48h, résultats garantis.">
<meta name="keywords" content="plans next level, espace entreprise, destination touristique, programme partenaire affilié, activités touristiques, boutique en ligne, GoExploria Business, marketing digital, visibilité">
<meta property="og:title" content="Plans Next Level GoExploria Business — Votre espace professionnel clé en main">
<meta property="og:description" content="5 types d'espaces pour chaque acteur : entreprises, destinations, partenaires, activités et produits. Démarrez en 48h.">
<meta property="og:type" content="website">
<link rel="canonical" href="https://GoExploria Business.com/next-level/plans">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Outfit:wght@300;400;500;600;700;800&family=Bebas+Neue&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ═══════════════ TOKENS ═══════════════ */
:root {
  --ink: #0c0f1a;
  --ink-mid: #1e2535;
  --ink-soft: #4b5568;
  --smoke: #f5f7fc;
  --smoke-2: #eef1f8;
  --white: #ffffff;
  --amber: #e8761a;
  --amber-dk: #bf560e;
  --amber-glow: rgba(232,118,26,0.14);
  --blue: #3b82f6;
  --emerald: #10b981;
  --violet: #8b5cf6;
  --gold: #f59e0b;
  --navy: #0f2240;
  --navy-mid: #1e3a5f;
  --border: #e2e8f0;
  --radius-xl: 28px;
  --radius-lg: 20px;
  --radius-md: 14px;
  --radius-sm: 10px;
  --shadow-sm: 0 2px 12px rgba(12,15,26,0.06);
  --shadow-md: 0 8px 32px rgba(12,15,26,0.09);
  --shadow-hover: 0 24px 64px rgba(12,15,26,0.13);
  --ease: cubic-bezier(0.4,0,0.2,1);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
  font-family: 'Outfit', sans-serif;
  background: var(--white);
  color: var(--ink);
  -webkit-font-smoothing: antialiased;
  overflow-x: hidden;
}
img { max-width: 100%; display: block; }
a { text-decoration: none; }
ul { list-style: none; }

::-webkit-scrollbar { width: 4px; }
::-webkit-scrollbar-thumb { background: var(--amber); border-radius: 99px; }

/* ═══════════════ NAV ═══════════════ */
.nav {
  position: sticky; top: 0; z-index: 200;
  height: 62px; padding: 0 clamp(18px,4vw,60px);
  display: flex; align-items: center; justify-content: space-between;
  background: rgba(255,255,255,0.95); backdrop-filter: blur(20px);
  border-bottom: 1px solid var(--border);
}
.nav-logo {
  display: flex; align-items: center; gap: 0;
  font-family: 'Bebas Neue', sans-serif; font-size: 20px; letter-spacing: 2px; color: var(--ink);
}
.nav-logo em { color: var(--amber); font-style: normal; }
.nav-pill {
  margin-left: 10px; font-size: 9px; font-weight: 800; text-transform: uppercase;
  letter-spacing: 1.8px; color: var(--amber); border: 1.5px solid var(--amber);
  padding: 3px 9px; border-radius: 6px;
}
.nav-links { display: flex; align-items: center; gap: 24px; }
.nav-links a { font-size: 13px; font-weight: 500; color: var(--ink-soft); transition: color 0.2s; }
.nav-links a:hover { color: var(--amber); }
.nav-cta {
  background: var(--amber); color: #fff !important;
  padding: 9px 20px; border-radius: 8px;
  font-weight: 700 !important; font-size: 13px !important;
  display: inline-flex; align-items: center; gap: 7px;
  transition: background 0.2s, transform 0.2s !important;
}
.nav-cta:hover { background: var(--amber-dk) !important; transform: translateY(-1px); }
.nav-burger { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
.nav-burger span { display: block; width: 22px; height: 2px; background: var(--ink); border-radius: 2px; }

/* BREADCRUMB */
.breadcrumb {
  padding: 11px clamp(18px,4vw,60px);
  background: var(--smoke); font-size: 12px; color: var(--ink-soft);
  display: flex; align-items: center; gap: 7px; flex-wrap: wrap;
  border-bottom: 1px solid var(--border);
}
.breadcrumb a { color: var(--amber); font-weight: 600; }
.breadcrumb i { font-size: 8px; color: #adb5c8; }

/* ═══════════════ HERO ═══════════════ */
.hero {
  background: linear-gradient(140deg, var(--navy) 0%, var(--navy-mid) 60%, #0b1829 100%);
  padding: clamp(64px,10vw,112px) clamp(18px,4vw,60px) clamp(48px,7vw,80px);
  position: relative; overflow: hidden; text-align: center;
}
.hero-mesh {
  position: absolute; inset: 0; pointer-events: none;
  background-image:
    linear-gradient(rgba(255,255,255,0.022) 1px, transparent 1px),
    linear-gradient(90deg,rgba(255,255,255,0.022) 1px, transparent 1px);
  background-size: 48px 48px;
}
.hero-glow-l, .hero-glow-r {
  position: absolute; border-radius: 50%; pointer-events: none; filter: blur(100px);
}
.hero-glow-l {
  width: 600px; height: 600px; left: -180px; top: -100px;
  background: radial-gradient(circle, rgba(232,118,26,0.18) 0%, transparent 70%);
}
.hero-glow-r {
  width: 500px; height: 500px; right: -120px; bottom: -80px;
  background: radial-gradient(circle, rgba(59,130,246,0.14) 0%, transparent 70%);
}
.hero-inner { position: relative; z-index: 2; max-width: 820px; margin: 0 auto; }
.hero-eyebrow {
  display: inline-flex; align-items: center; gap: 9px;
  background: rgba(232,118,26,0.14); border: 1px solid rgba(232,118,26,0.3);
  color: var(--amber); border-radius: 999px; padding: 7px 20px;
  font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;
  margin-bottom: 28px; animation: fadeUp 0.6s 0.1s both;
}
.pulse { width: 7px; height: 7px; background: var(--amber); border-radius: 50%; animation: pulse 2s infinite; }
@keyframes pulse { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(1.6);opacity:0.4} }
@keyframes fadeUp { from{opacity:0;transform:translateY(22px)} to{opacity:1;transform:translateY(0)} }
.hero-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(38px,6vw,80px); font-weight: 700;
  color: #fff; line-height: 1.0; margin-bottom: 22px;
  animation: fadeUp 0.6s 0.2s both;
}
.hero-title em { font-style: italic; color: var(--amber); }
.hero-desc {
  font-size: clamp(15px,1.4vw,18px); color: rgba(255,255,255,0.65);
  line-height: 1.85; margin-bottom: 44px; animation: fadeUp 0.6s 0.3s both;
}
.hero-actions { display: flex; justify-content: center; gap: 14px; flex-wrap: wrap; animation: fadeUp 0.6s 0.4s both; margin-bottom: 56px; }
.btn-primary {
  background: var(--amber); color: #fff; padding: 15px 32px;
  border-radius: var(--radius-md); font-weight: 700; font-size: 14px;
  display: inline-flex; align-items: center; gap: 9px;
  transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
}
.btn-primary:hover { background: var(--amber-dk); transform: translateY(-3px); box-shadow: 0 14px 40px rgba(232,118,26,0.42); color: #fff; }
.btn-outline {
  border: 1.5px solid rgba(255,255,255,0.3); color: #fff;
  padding: 15px 32px; border-radius: var(--radius-md);
  font-weight: 700; font-size: 14px;
  display: inline-flex; align-items: center; gap: 9px;
  transition: border-color 0.2s, background 0.2s;
}
.btn-outline:hover { border-color: #fff; background: rgba(255,255,255,0.08); color: #fff; }

/* Hero stats row */
.hero-stats {
  display: flex; justify-content: center; gap: clamp(28px,4vw,60px);
  flex-wrap: wrap; animation: fadeUp 0.6s 0.5s both;
}
.hero-stat { text-align: center; }
.hero-stat strong {
  display: block; font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(38px,4vw,56px); color: var(--amber); line-height: 1;
}
.hero-stat span { font-size: 11px; color: rgba(255,255,255,0.45); text-transform: uppercase; letter-spacing: 1px; margin-top: 5px; display: block; }

/* ═══════════════ TYPE TABS ═══════════════ */
.type-nav {
  background: var(--smoke); border-bottom: 1px solid var(--border);
  padding: 0 clamp(18px,4vw,60px);
  display: flex; align-items: center; gap: 0; overflow-x: auto;
}
.type-tab {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 16px 20px; font-size: 13px; font-weight: 600;
  color: var(--ink-soft); border-bottom: 2.5px solid transparent;
  cursor: pointer; white-space: nowrap; transition: color 0.2s, border-color 0.2s;
}
.type-tab:hover { color: var(--amber); }
.type-tab.active { color: var(--amber); border-bottom-color: var(--amber); }
.type-tab i { font-size: 14px; }

/* ═══════════════ SECTION WRAPPER ═══════════════ */
.section { padding: clamp(60px,8vw,96px) clamp(18px,4vw,60px); }
.section-alt { background: var(--smoke); }
.section-dark { background: var(--navy); }

.tag {
  display: inline-flex; align-items: center; gap: 7px;
  font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 2.2px;
  color: var(--amber); background: var(--amber-glow);
  padding: 6px 16px; border-radius: 999px; margin-bottom: 14px;
}
.section-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(28px,3.5vw,48px); font-weight: 700;
  color: var(--ink); line-height: 1.1; margin-bottom: 14px;
}
.section-title em { font-style: italic; color: var(--amber); }
.section-lead {
  font-size: clamp(14px,1.2vw,16px); color: var(--ink-soft);
  line-height: 1.9; max-width: 640px;
}
.header-c { text-align: center; max-width: 720px; margin: 0 auto 56px; }
.header-c .section-lead { max-width: none; }

/* ═══════════════ INTRO STRIP ═══════════════ */
.intro-strip {
  display: grid; grid-template-columns: 1fr auto;
  gap: 40px; align-items: center;
  background: linear-gradient(135deg,#f8faff,var(--white));
  border: 1.5px solid var(--border); border-radius: var(--radius-xl);
  padding: 36px 48px; margin-bottom: 40px;
}
.intro-strip p { font-size: 15px; color: var(--ink-soft); line-height: 1.85; max-width: 600px; }
.intro-stats { display: flex; gap: 36px; }
.istat { text-align: center; }
.istat strong {
  display: block; font-family: 'Bebas Neue', sans-serif;
  font-size: 44px; color: var(--amber); line-height: 1;
}
.istat span { font-size: 11px; color: var(--ink-soft); text-transform: uppercase; letter-spacing: 0.8px; margin-top: 4px; display: block; }

/* ═══════════════ PLANS GRID ═══════════════ */
.plans-grid {
  display: grid; grid-template-columns: repeat(5,1fr);
  gap: 18px; margin-bottom: 36px;
}
.plan-card {
  background: var(--white); border: 2px solid var(--border);
  border-radius: var(--radius-xl); padding: 30px 24px;
  display: flex; flex-direction: column;
  position: relative; overflow: hidden;
  transition: transform 0.32s var(--ease), box-shadow 0.32s var(--ease), border-color 0.2s;
}
.plan-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-hover); }
.plan-card.featured { background: linear-gradient(160deg,#fffbf5,var(--white)); }
.plan-badge {
  position: absolute; top: 0; right: 0;
  color: #fff; font-size: 9px; font-weight: 800;
  text-transform: uppercase; letter-spacing: 1.2px;
  padding: 5px 16px; border-radius: 0 var(--radius-xl) 0 14px;
}
.plan-icon {
  width: 62px; height: 62px; border-radius: 18px;
  display: flex; align-items: center; justify-content: center;
  font-size: 26px; color: #fff; margin-bottom: 18px;
}
.plan-label {
  font-size: 9px; font-weight: 800; text-transform: uppercase;
  letter-spacing: 2px; margin-bottom: 9px;
}
.plan-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 19px; font-weight: 700; color: var(--ink);
  line-height: 1.25; margin-bottom: 10px;
}
.plan-desc { font-size: 12.5px; color: var(--ink-soft); line-height: 1.7; margin-bottom: 18px; flex: 1; }
.plan-features { display: flex; flex-direction: column; gap: 9px; margin-bottom: 22px; }
.plan-features li {
  font-size: 12px; color: #444;
  display: flex; align-items: flex-start; gap: 8px; line-height: 1.5;
}
.plan-features li i { font-size: 11px; flex-shrink: 0; margin-top: 2px; }
.plan-price {
  align-self: flex-start; margin-bottom: 14px;
  background: var(--ink); color: #fff;
  font-size: 11px; font-weight: 700; padding: 5px 12px;
  border-radius: 999px; letter-spacing: 0.3px;
}
.plan-cta {
  display: flex; align-items: center; justify-content: center; gap: 8px;
  color: #fff; font-weight: 700; font-size: 13px;
  padding: 13px 16px; border-radius: var(--radius-sm);
  text-decoration: none; transition: opacity 0.2s, transform 0.2s;
  letter-spacing: 0.2px;
}
.plan-cta:hover { opacity: 0.88; transform: translateY(-1px); color: #fff; }

/* ═══════════════ DETAIL SECTIONS PER PLAN ═══════════════ */
.plan-section { scroll-margin-top: 80px; }

/* Split layout */
.split { display: grid; grid-template-columns: 1fr 1fr; gap: clamp(40px,6vw,80px); align-items: center; }
.split-rev { direction: rtl; }
.split-rev > * { direction: ltr; }

/* Visual block */
.plan-visual {
  border-radius: var(--radius-xl); overflow: hidden;
  position: relative; min-height: 420px;
  display: flex; flex-direction: column; justify-content: flex-end;
  padding: 40px;
}
.plan-visual-bg { position: absolute; inset: 0; z-index: 0; }
.plan-visual-mesh {
  position: absolute; inset: 0; z-index: 1; pointer-events: none;
  background-image: linear-gradient(rgba(0,0,0,0.04) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(0,0,0,0.04) 1px, transparent 1px);
  background-size: 32px 32px;
}
.plan-visual-content { position: relative; z-index: 2; }
.plan-visual-icon {
  width: 72px; height: 72px; border-radius: 20px;
  background: rgba(255,255,255,0.18); backdrop-filter: blur(10px);
  border: 1.5px solid rgba(255,255,255,0.25);
  display: flex; align-items: center; justify-content: center;
  font-size: 30px; color: #fff; margin-bottom: 20px;
}
.plan-visual h3 {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(24px,2.8vw,36px); font-weight: 700;
  color: #fff; line-height: 1.15; margin-bottom: 12px;
}
.plan-visual p { font-size: 14px; color: rgba(255,255,255,0.72); line-height: 1.75; }
.plan-visual-chips { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 20px; }
.chip {
  background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2);
  color: rgba(255,255,255,0.9); font-size: 11px; font-weight: 600;
  padding: 5px 13px; border-radius: 999px; backdrop-filter: blur(8px);
}

/* Feature list in detail */
.feat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 28px; }
.feat-item {
  display: flex; gap: 14px; align-items: flex-start;
  padding: 18px; border-radius: var(--radius-md);
  border: 1px solid var(--border); transition: border-color 0.2s, background 0.2s;
}
.feat-item:hover { border-color: var(--amber); background: #fffbf7; }
.feat-item-icon {
  width: 38px; height: 38px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 16px; flex-shrink: 0;
}
.feat-item h5 { font-size: 13px; font-weight: 700; color: var(--ink); margin-bottom: 3px; }
.feat-item p { font-size: 12px; color: var(--ink-soft); line-height: 1.55; }

/* ═══════════════ COMPARISON TABLE ═══════════════ */
.compare-table-wrap { overflow-x: auto; border-radius: var(--radius-xl); border: 1.5px solid var(--border); box-shadow: var(--shadow-sm); }
.compare-table { width: 100%; border-collapse: collapse; min-width: 720px; }
.compare-table th {
  padding: 18px 20px; font-size: 12px; font-weight: 700;
  text-transform: uppercase; letter-spacing: 1px;
  background: var(--smoke); text-align: center;
  border-bottom: 1.5px solid var(--border); color: var(--ink-mid);
}
.compare-table th:first-child { text-align: left; }
.compare-table td {
  padding: 15px 20px; font-size: 13px;
  border-bottom: 1px solid var(--smoke-2); text-align: center; vertical-align: middle;
}
.compare-table td:first-child { text-align: left; font-weight: 600; color: var(--ink); }
.compare-table tr:last-child td { border-bottom: none; }
.compare-table tr:hover td { background: #fffbf7; }
.ct-check { color: var(--emerald); font-size: 14px; }
.ct-no { color: #d1d5db; font-size: 14px; }
.ct-badge {
  display: inline-block; font-size: 10px; font-weight: 800;
  padding: 3px 10px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.8px;
}
.ct-pop { background: var(--amber-glow); color: var(--amber); }
.ct-new { background: rgba(59,130,246,0.1); color: var(--blue); }
.ct-rec { background: rgba(16,185,129,0.1); color: var(--emerald); }
.ct-hot { background: rgba(245,158,11,0.1); color: var(--gold); }
.compare-table th.highlighted { background: linear-gradient(135deg,#fffbf5,#fef3e8); color: var(--amber); }
.compare-table td.highlighted { background: rgba(232,118,26,0.03); }

/* ═══════════════ PARTNER PROGRAM ═══════════════ */
.partner-steps { display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; margin-top: 48px; }
.partner-step { text-align: center; padding: 32px 20px; }
.partner-step-num {
  width: 64px; height: 64px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 18px;
  font-family: 'Bebas Neue', sans-serif; font-size: 26px; color: #fff;
}
.partner-step h4 { font-size: 15px; font-weight: 700; color: var(--ink); margin-bottom: 8px; }
.partner-step p { font-size: 13px; color: var(--ink-soft); line-height: 1.65; }
.partner-commissions {
  display: grid; grid-template-columns: repeat(3,1fr);
  gap: 20px; margin-top: 40px;
}
.commission-card {
  border-radius: var(--radius-lg); padding: 32px 24px; text-align: center;
  border: 1.5px solid var(--border); transition: var(--ease) 0.3s;
}
.commission-card:hover { border-color: var(--emerald); transform: translateY(-4px); box-shadow: 0 16px 48px rgba(16,185,129,0.12); }
.commission-pct {
  font-family: 'Bebas Neue', sans-serif; font-size: 64px;
  color: var(--emerald); line-height: 1; display: block; margin-bottom: 6px;
}
.commission-card h4 { font-size: 14px; font-weight: 700; color: var(--ink); margin-bottom: 6px; }
.commission-card p { font-size: 12.5px; color: var(--ink-soft); line-height: 1.65; }

/* ═══════════════ TESTIMONIALS MINI ═══════════════ */
.reviews-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; margin-top: 48px; }
.review-card {
  border-radius: var(--radius-lg); padding: 28px 24px;
  border: 1.5px solid var(--border); background: var(--white);
  transition: transform 0.3s, box-shadow 0.3s;
}
.review-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-hover); }
.review-stars { color: #f59e0b; font-size: 12px; letter-spacing: 2px; margin-bottom: 14px; }
.review-text {
  font-family: 'Cormorant Garamond', serif; font-style: italic;
  font-size: 16px; color: var(--ink); line-height: 1.7; margin-bottom: 20px;
}
.review-text::before { content: '\201C'; font-size: 32px; color: var(--amber); line-height: 0; vertical-align: -12px; margin-right: 4px; }
.review-author { display: flex; align-items: center; gap: 12px; }
.review-avatar {
  width: 42px; height: 42px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-weight: 700; font-size: 14px; color: #fff; flex-shrink: 0;
}
.review-name { font-size: 13px; font-weight: 700; color: var(--ink); }
.review-role { font-size: 11.5px; color: #9ca3af; }
.review-plan-badge {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: 10px; font-weight: 700; text-transform: uppercase;
  padding: 3px 10px; border-radius: 999px; margin-bottom: 12px;
}

/* ═══════════════ FAQ ═══════════════ */
.faq-list { display: flex; flex-direction: column; gap: 12px; max-width: 800px; margin: 48px auto 0; }
.faq-item {
  border: 1.5px solid var(--border); border-radius: var(--radius-md); overflow: hidden;
  transition: border-color 0.2s;
}
.faq-item:hover { border-color: var(--amber); }
.faq-q {
  display: flex; justify-content: space-between; align-items: center;
  padding: 18px 22px; cursor: pointer; gap: 16px;
  font-size: 14px; font-weight: 600; color: var(--ink);
}
.faq-q i { color: var(--amber); flex-shrink: 0; transition: transform 0.28s; }
.faq-item.open .faq-q i { transform: rotate(45deg); }
.faq-a { display: none; padding: 0 22px 18px; font-size: 13.5px; color: var(--ink-soft); line-height: 1.8; }
.faq-item.open .faq-a { display: block; }

/* ═══════════════ COMPARE BANNER ═══════════════ */
.cta-banner {
  background: linear-gradient(135deg, var(--navy), var(--navy-mid));
  border-radius: var(--radius-xl); padding: 52px 56px;
  display: flex; justify-content: space-between; align-items: center;
  gap: 40px; position: relative; overflow: hidden;
}
.cta-banner::before {
  content: ''; position: absolute; inset: 0; pointer-events: none;
  background-image: linear-gradient(rgba(255,255,255,0.022) 1px, transparent 1px),
                    linear-gradient(90deg,rgba(255,255,255,0.022) 1px, transparent 1px);
  background-size: 44px 44px;
}
.cta-banner-text h3 {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(22px,3vw,34px); font-weight: 700;
  color: #fff; line-height: 1.2; margin-bottom: 10px; position: relative;
}
.cta-banner-text h3 em { font-style: italic; color: var(--amber); }
.cta-banner-text p { font-size: 14px; color: rgba(255,255,255,0.62); line-height: 1.75; max-width: 520px; position: relative; }
.cta-banner-btns { display: flex; gap: 12px; flex-shrink: 0; position: relative; }
.btn-amber { background: var(--amber); color: #fff; padding: 14px 26px; border-radius: var(--radius-sm); font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s, transform 0.2s; white-space: nowrap; }
.btn-amber:hover { background: var(--amber-dk); transform: translateY(-2px); color: #fff; }
.btn-ghost { border: 1.5px solid rgba(255,255,255,0.28); color: #fff; padding: 14px 26px; border-radius: var(--radius-sm); font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: border-color 0.2s; white-space: nowrap; }
.btn-ghost:hover { border-color: #fff; color: #fff; }

/* ═══════════════ FOOTER ═══════════════ */
.footer { background: var(--ink); padding: 56px clamp(18px,4vw,60px) 26px; }
.footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 48px; margin-bottom: 48px; }
.footer-brand { font-family: 'Bebas Neue', sans-serif; font-size: 24px; letter-spacing: 2px; color: #fff; margin-bottom: 12px; }
.footer-brand em { color: var(--amber); font-style: normal; }
.footer-desc { font-size: 13px; color: rgba(255,255,255,0.4); line-height: 1.8; margin-bottom: 24px; }
.footer-socials { display: flex; gap: 10px; }
.social-btn {
  width: 36px; height: 36px; border-radius: 8px;
  background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
  display: flex; align-items: center; justify-content: center;
  color: rgba(255,255,255,0.5); font-size: 14px; transition: background 0.2s, color 0.2s;
}
.social-btn:hover { background: var(--amber); border-color: var(--amber); color: #fff; }
.footer-col h5 { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.8px; color: rgba(255,255,255,0.35); margin-bottom: 18px; }
.footer-col a { display: block; font-size: 13px; color: rgba(255,255,255,0.52); margin-bottom: 10px; transition: color 0.2s; }
.footer-col a:hover { color: var(--amber); }
.footer-bottom {
  border-top: 1px solid rgba(255,255,255,0.07); padding-top: 22px;
  display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;
  font-size: 12px; color: rgba(255,255,255,0.28);
}

/* ═══════════════ SCROLL TOP ═══════════════ */
.scroll-top {
  position: fixed; bottom: 26px; right: 26px;
  width: 44px; height: 44px; border-radius: 12px;
  background: var(--amber); color: #fff; border: none; cursor: pointer;
  display: none; align-items: center; justify-content: center;
  font-size: 16px; box-shadow: 0 8px 24px rgba(232,118,26,0.35);
  transition: transform 0.2s; z-index: 99;
}
.scroll-top:hover { transform: translateY(-3px); }
.scroll-top.visible { display: flex; }

/* Reveal */
.reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.6s var(--ease), transform 0.6s var(--ease); }
.reveal.visible { opacity: 1; transform: translateY(0); }

/* ═══════════════ RESPONSIVE ═══════════════ */
@media(max-width:1280px) { .plans-grid { grid-template-columns: repeat(3,1fr); } .partner-steps { grid-template-columns: repeat(2,1fr); } }
@media(max-width:1024px) {
  .split { grid-template-columns: 1fr; }
  .split-rev { direction: ltr; }
  .compare-table-wrap { border-radius: var(--radius-md); }
  .feat-grid { grid-template-columns: 1fr; }
  .footer-grid { grid-template-columns: 1fr 1fr; }
  .cta-banner { flex-direction: column; padding: 40px 32px; }
}
@media(max-width:860px) {
  .plans-grid { grid-template-columns: repeat(2,1fr); }
  .intro-strip { grid-template-columns: 1fr; }
  .intro-stats { flex-wrap: wrap; }
  .partner-commissions { grid-template-columns: 1fr; }
  .reviews-row { grid-template-columns: 1fr; }
}
@media(max-width:600px) {
  .plans-grid { grid-template-columns: 1fr; }
  .partner-steps { grid-template-columns: 1fr; }
  .footer-grid { grid-template-columns: 1fr; }
  .hero-stats { gap: 20px; }
  .nav-links { display: none; }
  .nav-burger { display: flex; }
  .cta-banner-btns { flex-direction: column; width: 100%; }
}
</style>
</head>
<body>

<!-- ═══ NAV ═══ -->
<nav class="nav">
  <div class="nav-logo">
    <img src="{{ asset('logo.png') }}" alt="Next Level" style="height: 75px;">
  </div>
  <ul class="nav-links">
    <li><a href="#plans">Nos Plans</a></li>
    <li><a href="#entreprise">Entreprise</a></li>
    <li><a href="#destinations">Destinations</a></li>
    <li><a href="#partenaires">Partenaires</a></li>
    <li><a href="#activites">Activités</a></li>
    <li><a href="#produits">Boutique</a></li>
    <li><a href="{{url('devis')}}" class="nav-cta"><i class="fas fa-rocket"></i> Démarrer</a></li>
  </ul>
  <div class="nav-burger" onclick="toggleNav()"><span></span><span></span><span></span></div>
</nav>

<!-- BREADCRUMB -->
<nav class="breadcrumb">
  <a href="/">Accueil</a><i class="fas fa-chevron-right"></i>
  <a href="/next-level">Next Level</a><i class="fas fa-chevron-right"></i>
  <span>Activez vos Plans</span>
</nav>

<!-- ═══ HERO ═══ -->
<header class="hero">
  <div class="hero-mesh"></div>
  <div class="hero-glow-l"></div>
  <div class="hero-glow-r"></div>
  <div class="hero-inner">
    <div class="hero-eyebrow"><div class="pulse"></div> 5 espaces · Démarrage en 48h · Clé en main</div>
    <h1 class="hero-title">Activez vos Plans<br><em>Next Level</em></h1>
    <p class="hero-desc">Des solutions professionnelles sur-mesure pour chaque acteur du tourisme et du commerce digital — entreprises, destinations, partenaires affiliés, prestataires d'activités et vendeurs de produits.</p>
    <div class="hero-actions">
      <a href="#plans" class="btn-primary"><i class="fas fa-star"></i> Voir tous les plans</a>
      <a href="{{url('devis')}}" class="btn-outline"><i class="fas fa-phone-alt"></i> Parler à un expert</a>
    </div>
    <div class="hero-stats">
      <div class="hero-stat"><strong>5</strong><span>Types d'espaces</span></div>
      <div class="hero-stat"><strong>48h</strong><span>Démarrage garanti</span></div>
      <div class="hero-stat"><strong>100%</strong><span>Clé en main</span></div>
      <div class="hero-stat"><strong>24/7</strong><span>Support inclus</span></div>
      <div class="hero-stat"><strong>250+</strong><span>Espaces actifs</span></div>
    </div>
  </div>
</header>

<!-- TYPE TABS -->
<div class="type-nav">
  <div class="type-tab active" onclick="scrollTo('#plans')"><i class="fas fa-layer-group"></i> Tous les plans</div>
  <div class="type-tab" onclick="scrollTo('#entreprise')"><i class="fas fa-building"></i> Entreprise</div>
  <div class="type-tab" onclick="scrollTo('#destinations')"><i class="fas fa-map-marked-alt"></i> Destinations</div>
  <div class="type-tab" onclick="scrollTo('#partenaires')"><i class="fas fa-handshake"></i> Partenaires</div>
  <div class="type-tab" onclick="scrollTo('#activites')"><i class="fas fa-person-hiking"></i> Activités</div>
  <div class="type-tab" onclick="scrollTo('#produits')"><i class="fas fa-box-open"></i> Boutique</div>
</div>

<!-- ═══ PLANS OVERVIEW ═══ -->
<section class="section" id="plans">
  <div class="header-c reveal">
    <div class="tag"><i class="fas fa-layer-group"></i> Nos Plans</div>
    <h2 class="section-title">Choisissez votre <em>espace professionnel</em></h2>
    <p class="section-lead">Chaque plan est une solution complète avec hébergement, SSL, tableau de bord, support premium et accès à toutes nos fonctionnalités Next Level. Aucune configuration technique requise.</p>
  </div>

  <div class="intro-strip reveal">
    <p>GoExploria Business Next Level vous offre des espaces professionnels dédiés, pensés pour chaque acteur du tourisme et du commerce digital. Chaque plan inclut hébergement, SSL, support premium et accès à toutes nos fonctionnalités. Nos experts vous accompagnent de la configuration initiale jusqu'à l'optimisation continue de vos performances.</p>
    <div class="intro-stats">
      <div class="istat"><strong>5</strong><span>Types d'espaces</span></div>
      <div class="istat"><strong>48h</strong><span>Démarrage</span></div>
      <div class="istat"><strong>100%</strong><span>Clé en main</span></div>
      <div class="istat"><strong>24/7</strong><span>Support</span></div>
    </div>
  </div>

  <div class="plans-grid reveal">
    <!-- Entreprise -->
    <div class="plan-card featured" style="border-color:#e8761a">
      <div class="plan-badge" style="background:#e8761a">POPULAIRE</div>
      <div class="plan-icon" style="background:linear-gradient(135deg,#e8761a,#c04f10)"><i class="fas fa-building"></i></div>
      <div class="plan-label" style="color:#e8761a">ENTREPRISES</div>
      <div class="plan-title">Espace Entreprise Pro</div>
      <p class="plan-desc">Site web complet, CRM, mail marketing, social media et analytics pour propulser votre business local et international.</p>
      <ul class="plan-features">
        <li><i class="fas fa-check-circle" style="color:#e8761a"></i> Site web multipage responsive</li>
        <li><i class="fas fa-check-circle" style="color:#e8761a"></i> CRM & gestion contacts</li>
        <li><i class="fas fa-check-circle" style="color:#e8761a"></i> Dashboard analytics avancé</li>
        <li><i class="fas fa-check-circle" style="color:#e8761a"></i> Intégrations API avancées</li>
      </ul>
      <div class="plan-price">À partir de 797 CAD /mois</div>
      <a href="#entreprise" class="plan-cta" style="background:linear-gradient(135deg,#e8761a,#c04f10)">Activer mon Espace <i class="fas fa-arrow-right"></i></a>
    </div>
    <!-- Destinations -->
    <div class="plan-card" style="--hov:#3b82f6">
      <div class="plan-badge" style="background:#3b82f6">NOUVEAU</div>
      <div class="plan-icon" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8)"><i class="fas fa-map-marked-alt"></i></div>
      <div class="plan-label" style="color:#3b82f6">DESTINATIONS</div>
      <div class="plan-title">Espace Destination</div>
      <p class="plan-desc">Vitrine touristique avec galerie, carte interactive, avis clients et système de réservation intégré.</p>
      <ul class="plan-features">
        <li><i class="fas fa-check-circle" style="color:#3b82f6"></i> Page destination optimisée SEO</li>
        <li><i class="fas fa-check-circle" style="color:#3b82f6"></i> Galerie photos & vidéos HD</li>
        <li><i class="fas fa-check-circle" style="color:#3b82f6"></i> Système de réservation</li>
        <li><i class="fas fa-check-circle" style="color:#3b82f6"></i> Avis clients vérifiés</li>
      </ul>
      <div class="plan-price">À partir de 597 CAD /mois</div>
      <a href="#destinations" class="plan-cta" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8)">Activer ma Destination <i class="fas fa-arrow-right"></i></a>
    </div>
    <!-- Partenaires -->
    <div class="plan-card">
      <div class="plan-badge" style="background:#10b981">RECOMMANDÉ</div>
      <div class="plan-icon" style="background:linear-gradient(135deg,#10b981,#059669)"><i class="fas fa-handshake"></i></div>
      <div class="plan-label" style="color:#10b981">PARTENAIRES AFFILIÉS</div>
      <div class="plan-title">Programme Partenaire</div>
      <p class="plan-desc">Générez des revenus passifs en recommandant nos solutions à votre réseau. Commission jusqu'à 30%.</p>
      <ul class="plan-features">
        <li><i class="fas fa-check-circle" style="color:#10b981"></i> Commission jusqu'à 30%</li>
        <li><i class="fas fa-check-circle" style="color:#10b981"></i> Tableau de bord affilié</li>
        <li><i class="fas fa-check-circle" style="color:#10b981"></i> Liens trackés personnalisés</li>
        <li><i class="fas fa-check-circle" style="color:#10b981"></i> Paiements mensuels automatiques</li>
      </ul>
      <div class="plan-price">Commission sur résultats</div>
      <a href="#partenaires" class="plan-cta" style="background:linear-gradient(135deg,#10b981,#059669)">Devenir Partenaire <i class="fas fa-arrow-right"></i></a>
    </div>
    <!-- Activités -->
    <div class="plan-card">
      <div class="plan-icon" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9)"><i class="fas fa-person-hiking"></i></div>
      <div class="plan-label" style="color:#8b5cf6">ACTIVITÉS</div>
      <div class="plan-title">Espace Activités</div>
      <p class="plan-desc">Référencez vos activités touristiques avec réservation en ligne, calendrier et paiements intégrés.</p>
      <ul class="plan-features">
        <li><i class="fas fa-check-circle" style="color:#8b5cf6"></i> Fiche activité enrichie</li>
        <li><i class="fas fa-check-circle" style="color:#8b5cf6"></i> Calendrier & disponibilités</li>
        <li><i class="fas fa-check-circle" style="color:#8b5cf6"></i> Réservation & paiement en ligne</li>
        <li><i class="fas fa-check-circle" style="color:#8b5cf6"></i> Notifications automatiques</li>
      </ul>
      <div class="plan-price">À partir de 297 CAD /mois</div>
      <a href="#activites" class="plan-cta" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9)">Publier mes Activités <i class="fas fa-arrow-right"></i></a>
    </div>
    <!-- Boutique -->
    <div class="plan-card">
      <div class="plan-badge" style="background:#f59e0b">HOT</div>
      <div class="plan-icon" style="background:linear-gradient(135deg,#f59e0b,#d97706)"><i class="fas fa-box-open"></i></div>
      <div class="plan-label" style="color:#f59e0b">PRODUITS & SERVICES</div>
      <div class="plan-title">Espace Boutique</div>
      <p class="plan-desc">Boutique e-commerce complète avec gestion stocks, paiements multi-devises et livraison intégrée.</p>
      <ul class="plan-features">
        <li><i class="fas fa-check-circle" style="color:#f59e0b"></i> Boutique e-commerce complète</li>
        <li><i class="fas fa-check-circle" style="color:#f59e0b"></i> Gestion stock & variantes</li>
        <li><i class="fas fa-check-circle" style="color:#f59e0b"></i> Paiements multi-devises</li>
        <li><i class="fas fa-check-circle" style="color:#f59e0b"></i> Intégration livraison</li>
      </ul>
      <div class="plan-price">À partir de 497 CAD /mois</div>
      <a href="#produits" class="plan-cta" style="background:linear-gradient(135deg,#f59e0b,#d97706)">Ouvrir ma Boutique <i class="fas fa-arrow-right"></i></a>
    </div>
  </div>
</section>

<!-- ═══ COMPARISON TABLE ═══ -->
<section class="section section-alt" id="comparatif">
  <div class="header-c reveal">
    <div class="tag"><i class="fas fa-balance-scale"></i> Comparatif</div>
    <h2 class="section-title">Comparez les <em>fonctionnalités</em></h2>
    <p class="section-lead">Un aperçu clair de ce que comprend chacun de nos espaces pour vous aider à choisir la solution la mieux adaptée à votre activité.</p>
  </div>
  <div class="compare-table-wrap reveal">
    <table class="compare-table" role="table">
      <thead>
        <tr>
          <th>Fonctionnalité</th>
          <th class="highlighted">Entreprise <span class="ct-badge ct-pop">Pop</span></th>
          <th>Destination <span class="ct-badge ct-new">New</span></th>
          <th>Partenaire <span class="ct-badge ct-rec">Rec</span></th>
          <th>Activités</th>
          <th>Boutique <span class="ct-badge ct-hot">Hot</span></th>
        </tr>
      </thead>
      <tbody>
        <tr><td>Hébergement & SSL inclus</td><td class="highlighted"><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td></tr>
        <tr><td>Support 24/7 dédié</td><td class="highlighted"><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td></tr>
        <tr><td>Dashboard analytics</td><td class="highlighted"><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td></tr>
        <tr><td>Site web multipage</td><td class="highlighted"><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td></tr>
        <tr><td>CRM & gestion contacts</td><td class="highlighted"><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-check-circle ct-check"></i></td></tr>
        <tr><td>Système de réservation</td><td class="highlighted"><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-times-circle ct-no"></i></td></tr>
        <tr><td>Galerie photos & vidéos HD</td><td class="highlighted"><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td></tr>
        <tr><td>Boutique e-commerce</td><td class="highlighted"><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-check-circle ct-check"></i></td></tr>
        <tr><td>Commissions & revenus passifs</td><td class="highlighted"><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-times-circle ct-no"></i></td></tr>
        <tr><td>Optimisation SEO locale</td><td class="highlighted"><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-check-circle ct-check"></i></td></tr>
        <tr><td>Intégration IA disponible</td><td class="highlighted"><i class="fas fa-check-circle ct-check"></i></td><td><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-times-circle ct-no"></i></td><td><i class="fas fa-check-circle ct-check"></i></td></tr>
      </tbody>
    </table>
  </div>
</section>

<!-- ═══ ESPACE ENTREPRISE ═══ -->
<section class="section plan-section" id="entreprise">
  <div class="split reveal">
    <div class="plan-visual" style="background:linear-gradient(140deg,#0f2240,#e8761a)">
      <div class="plan-visual-bg" style="background:linear-gradient(140deg,#0f2240 30%,#c04f10 100%)"></div>
      <div class="plan-visual-mesh"></div>
      <div class="plan-visual-content">
        <div class="plan-visual-icon"><i class="fas fa-building"></i></div>
        <h3>Espace<br>Entreprise Pro</h3>
        <p>La solution tout-en-un pour propulser votre entreprise sur le digital : site, CRM, analytics, marketing automation et IA intégrée.</p>
        <div class="plan-visual-chips">
          <span class="chip">Site responsive</span>
          <span class="chip">CRM intégré</span>
          <span class="chip">Analytics</span>
          <span class="chip">IA ready</span>
        </div>
      </div>
    </div>
    <div class="reveal" style="transition-delay:0.12s">
      <div class="tag"><i class="fas fa-building"></i> Espace Entreprise</div>
      <h2 class="section-title">Votre vitrine <em>professionnelle</em> complète</h2>
      <p class="section-lead">De la création de votre site web à la gestion de vos contacts, en passant par le marketing automatisé — tout est inclus, configuré et maintenu par nos équipes pour que vous puissiez vous concentrer sur votre métier.</p>
      <div class="feat-grid">
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(232,118,26,0.1);color:#e8761a"><i class="fas fa-globe"></i></div><div><h5>Site web multipage</h5><p>Design sur-mesure, responsive, optimisé Core Web Vitals et chargement ultra-rapide.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(59,130,246,0.1);color:#3b82f6"><i class="fas fa-users"></i></div><div><h5>CRM & contacts</h5><p>Gérez vos clients, prospects et opportunités commerciales depuis un seul endroit.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(16,185,129,0.1);color:#10b981"><i class="fas fa-envelope"></i></div><div><h5>Mail marketing</h5><p>Campagnes automatisées, segmentation avancée et A/B testing pour convertir vos contacts.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(139,92,246,0.1);color:#8b5cf6"><i class="fas fa-chart-bar"></i></div><div><h5>Analytics & rapports</h5><p>Tableau de bord en temps réel avec KPIs, entonnoirs de conversion et insights actionnables.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b"><i class="fas fa-share-alt"></i></div><div><h5>Social media intégré</h5><p>Planification, publication et analyse de vos contenus sur toutes les plateformes sociales.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(232,118,26,0.1);color:#e8761a"><i class="fas fa-robot"></i></div><div><h5>IA & automatisations</h5><p>Génération de contenu, qualification de leads et personnalisation avec l'intelligence artificielle.</p></div></div>
      </div>
      <a href="#contact" class="btn-primary" style="margin-top:28px;display:inline-flex"><i class="fas fa-rocket"></i> Activer mon Espace Entreprise</a>
    </div>
  </div>
</section>

<!-- ═══ DESTINATIONS ═══ -->
<section class="section section-alt plan-section" id="destinations">
  <div class="split split-rev reveal">
    <div>
      <div class="tag"><i class="fas fa-map-marked-alt"></i> Espace Destination</div>
      <h2 class="section-title">Votre destination <em>rayonne</em> sur le web</h2>
      <p class="section-lead">Une vitrine touristique complète, optimisée pour attirer les voyageurs et convertir les visites en réservations concrètes. Tout est inclus pour faire briller votre région ou votre établissement.</p>
      <div class="feat-grid">
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(59,130,246,0.1);color:#3b82f6"><i class="fas fa-search"></i></div><div><h5>SEO Touristique</h5><p>Optimisation pour les recherches "quoi faire à [ville]" et les requêtes voyage de longue traîne.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(59,130,246,0.1);color:#3b82f6"><i class="fas fa-images"></i></div><div><h5>Galerie HD immersive</h5><p>Photos et vidéos haute résolution avec visite virtuelle 360° en option.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(59,130,246,0.1);color:#3b82f6"><i class="fas fa-calendar-check"></i></div><div><h5>Réservation intégrée</h5><p>Système de booking en temps réel avec confirmation automatique et gestion des disponibilités.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(59,130,246,0.1);color:#3b82f6"><i class="fas fa-star"></i></div><div><h5>Avis & réputation</h5><p>Collecte automatisée d'avis vérifiés, affichés avec réponses pour maximiser la confiance.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(59,130,246,0.1);color:#3b82f6"><i class="fas fa-map"></i></div><div><h5>Carte interactive</h5><p>Points d'intérêt, hébergements, restaurants et activités géolocalisés sur une carte dynamique.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(59,130,246,0.1);color:#3b82f6"><i class="fas fa-language"></i></div><div><h5>Multilingue</h5><p>Votre page en français, anglais et espagnol pour atteindre les voyageurs internationaux.</p></div></div>
      </div>
      <a href="#contact" class="btn-primary" style="margin-top:28px;display:inline-flex;background:linear-gradient(135deg,#3b82f6,#1d4ed8)"><i class="fas fa-map-marked-alt"></i> Activer ma Destination</a>
    </div>
    <div class="plan-visual reveal" style="transition-delay:0.12s">
      <div class="plan-visual-bg" style="background:linear-gradient(140deg,#1d4ed8 0%,#0e7490 100%)"></div>
      <div class="plan-visual-mesh"></div>
      <div class="plan-visual-content">
        <div class="plan-visual-icon"><i class="fas fa-map-marked-alt"></i></div>
        <h3>Espace<br>Destination</h3>
        <p>Faites rayonner votre région, ville ou établissement avec une vitrine touristique professionnelle qui convertit les visiteurs en réservations.</p>
        <div class="plan-visual-chips">
          <span class="chip">SEO Touristique</span><span class="chip">Réservation</span><span class="chip">Galerie HD</span><span class="chip">Multilingue</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══ PARTENAIRES ═══ -->
<section class="section plan-section" id="partenaires">
  <div class="header-c reveal">
    <div class="tag"><i class="fas fa-handshake"></i> Programme Partenaire</div>
    <h2 class="section-title">Gagnez jusqu'à <em>30% de commission</em></h2>
    <p class="section-lead">Rejoignez notre réseau d'affiliés et transformez votre réseau professionnel en source de revenus passifs réguliers. Système de tracking transparent, paiements mensuels automatiques.</p>
  </div>

  <div class="partner-steps reveal">
    <div class="partner-step">
      <div class="partner-step-num" style="background:linear-gradient(135deg,#10b981,#059669)">01</div>
      <h4>Inscrivez-vous</h4>
      <p>Créez votre compte partenaire gratuitement en moins de 5 minutes. Validation sous 24h ouvrables.</p>
    </div>
    <div class="partner-step">
      <div class="partner-step-num" style="background:linear-gradient(135deg,#10b981,#059669)">02</div>
      <h4>Recevez vos liens</h4>
      <p>Accédez à votre tableau de bord affilié avec vos liens trackés personnalisés et vos supports marketing.</p>
    </div>
    <div class="partner-step">
      <div class="partner-step-num" style="background:linear-gradient(135deg,#10b981,#059669)">03</div>
      <h4>Recommandez</h4>
      <p>Partagez GoExploria Business à votre réseau par email, réseaux sociaux, blog ou en direct lors de vos rencontres.</p>
    </div>
    <div class="partner-step">
      <div class="partner-step-num" style="background:linear-gradient(135deg,#10b981,#059669)">04</div>
      <h4>Encaissez</h4>
      <p>Virement automatique chaque 1er du mois sur votre compte. Commission à vie sur chaque abonnement actif.</p>
    </div>
  </div>

  <div class="partner-commissions reveal">
    <div class="commission-card">
      <span class="commission-pct">15%</span>
      <h4>Partenaire Essentiel</h4>
      <p>Accès aux supports de base, liens personnalisés et tableau de bord de suivi de vos conversions.</p>
    </div>
    <div class="commission-card">
      <span class="commission-pct">22%</span>
      <h4>Partenaire Pro</h4>
      <p>Support marketing avancé, accès aux webinaires exclusifs, formations et co-branding autorisé.</p>
    </div>
    <div class="commission-card">
      <span class="commission-pct">30%</span>
      <h4>Partenaire Elite</h4>
      <p>Accès prioritaire, gestionnaire de compte dédié, commission à vie + bonus de performance trimestriels.</p>
    </div>
  </div>
  <div style="text-align:center;margin-top:36px">
    <a href="#contact" class="btn-primary" style="background:linear-gradient(135deg,#10b981,#059669);display:inline-flex"><i class="fas fa-handshake"></i> Devenir Partenaire Affilié</a>
  </div>
</section>

<!-- ═══ ACTIVITÉS ═══ -->
<section class="section section-alt plan-section" id="activites">
  <div class="split split-rev reveal">
    <div>
      <div class="tag"><i class="fas fa-person-hiking"></i> Espace Activités</div>
      <h2 class="section-title">Vos activités réservées <em>24h/24</em></h2>
      <p class="section-lead">Randonnées, sports nautiques, visites guidées, cours de cuisine — référencez et gérez toutes vos activités avec un système de réservation en ligne professionnel qui travaille pour vous même quand vous dormez.</p>
      <div class="feat-grid">
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(139,92,246,0.1);color:#8b5cf6"><i class="fas fa-list-alt"></i></div><div><h5>Fiches enrichies</h5><p>Description, photos, durée, niveau, équipement requis, inclusions — tout ce qui convainc le voyageur.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(139,92,246,0.1);color:#8b5cf6"><i class="fas fa-calendar-alt"></i></div><div><h5>Calendrier dynamique</h5><p>Gestion des disponibilités en temps réel avec gestion des groupes et capacités maximales.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(139,92,246,0.1);color:#8b5cf6"><i class="fas fa-credit-card"></i></div><div><h5>Paiement sécurisé</h5><p>Stripe et PayPal intégrés. Acomptes, paiement complet ou paiement sur place au choix.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(139,92,246,0.1);color:#8b5cf6"><i class="fas fa-bell"></i></div><div><h5>Notifications auto</h5><p>Confirmations, rappels 48h avant, instructions de rendez-vous envoyés automatiquement.</p></div></div>
      </div>
      <a href="#contact" class="btn-primary" style="margin-top:28px;display:inline-flex;background:linear-gradient(135deg,#8b5cf6,#6d28d9)"><i class="fas fa-person-hiking"></i> Publier mes Activités</a>
    </div>
    <div class="plan-visual reveal" style="transition-delay:0.12s">
      <div class="plan-visual-bg" style="background:linear-gradient(140deg,#4c1d95,#8b5cf6 100%)"></div>
      <div class="plan-visual-mesh"></div>
      <div class="plan-visual-content">
        <div class="plan-visual-icon"><i class="fas fa-person-hiking"></i></div>
        <h3>Espace<br>Activités</h3>
        <p>Randonnée, kayak, cours de cuisine, visites guidées — chaque activité mérite une fiche professionnelle qui transforme les curieux en réservations confirmées.</p>
        <div class="plan-visual-chips"><span class="chip">Réservation live</span><span class="chip">Multi-activités</span><span class="chip">Paiement sécurisé</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ═══ BOUTIQUE ═══ -->
<section class="section plan-section" id="produits">
  <div class="split reveal">
    <div class="plan-visual">
      <div class="plan-visual-bg" style="background:linear-gradient(140deg,#78350f,#f59e0b)"></div>
      <div class="plan-visual-mesh"></div>
      <div class="plan-visual-content">
        <div class="plan-visual-icon"><i class="fas fa-box-open"></i></div>
        <h3>Espace<br>Boutique</h3>
        <p>Vendez vos produits artisanaux, souvenirs, vêtements, ou services partout dans le monde avec une boutique e-commerce clé en main.</p>
        <div class="plan-visual-chips"><span class="chip">E-commerce complet</span><span class="chip">Multi-devises</span><span class="chip">Livraison intégrée</span></div>
      </div>
    </div>
    <div class="reveal" style="transition-delay:0.12s">
      <div class="tag"><i class="fas fa-box-open"></i> Espace Boutique</div>
      <h2 class="section-title">Vendez vos produits <em>partout dans le monde</em></h2>
      <p class="section-lead">Ouvrez votre boutique en ligne complète en 48h. Gestion des stocks, variantes de produits, paiements sécurisés et logistique intégrée — tout ce qu'il faut pour vendre sans friction.</p>
      <div class="feat-grid">
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b"><i class="fas fa-store"></i></div><div><h5>Boutique professionnelle</h5><p>Catalogue illimité, variantes (taille, couleur), photos HD et descriptions optimisées SEO.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b"><i class="fas fa-warehouse"></i></div><div><h5>Gestion des stocks</h5><p>Alertes rupture de stock, seuils automatiques et synchronisation multi-canal en temps réel.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b"><i class="fas fa-globe-americas"></i></div><div><h5>Paiements multi-devises</h5><p>CAD, USD, EUR — 25+ devises acceptées. Stripe, PayPal et Apple Pay intégrés.</p></div></div>
        <div class="feat-item"><div class="feat-item-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b"><i class="fas fa-truck"></i></div><div><h5>Livraison & logistique</h5><p>Calcul automatique des frais, étiquettes d'expédition et suivi de colis pour vos clients.</p></div></div>
      </div>
      <a href="#contact" class="btn-primary" style="margin-top:28px;display:inline-flex;background:linear-gradient(135deg,#f59e0b,#d97706)"><i class="fas fa-box-open"></i> Ouvrir ma Boutique</a>
    </div>
  </div>
</section>

<!-- ═══ TESTIMONIALS ═══ -->
<section class="section section-alt">
  <div class="header-c reveal">
    <div class="tag"><i class="fas fa-star"></i> Témoignages</div>
    <h2 class="section-title">Ils ont <em>activé leur espace</em></h2>
    <p class="section-lead">Des entrepreneurs et gestionnaires comme vous ont transformé leur présence digitale avec GoExploria Business Next Level. Voici leurs résultats.</p>
  </div>
  <div class="reviews-row">
    <article class="review-card reveal">
      <div class="review-plan-badge" style="background:rgba(232,118,26,0.1);color:#e8761a"><i class="fas fa-building"></i> Espace Entreprise</div>
      <div class="review-stars">★★★★★</div>
      <p class="review-text">En 3 mois, notre trafic a doublé et nos demandes de devis ont été multipliées par 4. L'espace Entreprise Pro est exactement ce qu'il nous fallait.</p>
      <div class="review-author">
        <div class="review-avatar" style="background:linear-gradient(135deg,#e8761a,#c04f10)">MB</div>
        <div><p class="review-name">Marc Beauchamp</p><p class="review-role">PDG — Beauchamp Construction, Québec</p></div>
      </div>
    </article>
    <article class="review-card reveal" style="transition-delay:0.1s">
      <div class="review-plan-badge" style="background:rgba(59,130,246,0.1);color:#3b82f6"><i class="fas fa-map-marked-alt"></i> Espace Destination</div>
      <div class="review-stars">★★★★★</div>
      <p class="review-text">Notre région est maintenant #1 sur Google pour les recherches touristiques. Les réservations directes ont augmenté de 68% sans aucune publicité payante.</p>
      <div class="review-author">
        <div class="review-avatar" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8)">CL</div>
        <div><p class="review-name">Chantal Lafleur</p><p class="review-role">Directrice — Office du Tourisme de Charlevoix</p></div>
      </div>
    </article>
    <article class="review-card reveal" style="transition-delay:0.2s">
      <div class="review-plan-badge" style="background:rgba(16,185,129,0.1);color:#10b981"><i class="fas fa-handshake"></i> Programme Partenaire</div>
      <div class="review-stars">★★★★★</div>
      <p class="review-text">Je génère maintenant 2 300 $ de commissions par mois en parlant simplement de GoExploria Business à mes clients consultants. Le tableau de bord est transparent et les paiements sont toujours à l'heure.</p>
      <div class="review-author">
        <div class="review-avatar" style="background:linear-gradient(135deg,#10b981,#059669)">JD</div>
        <div><p class="review-name">Jean-Daniel Côté</p><p class="review-role">Consultant Marketing — Montréal</p></div>
      </div>
    </article>
  </div>
</section>

<!-- ═══ FAQ ═══ -->
<section class="section" id="faq">
  <div class="header-c reveal">
    <div class="tag"><i class="fas fa-question-circle"></i> FAQ</div>
    <h2 class="section-title">Vos questions, <em>nos réponses</em></h2>
  </div>
  <div class="faq-list reveal">
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)"><span>Puis-je changer de plan après l'activation ?</span><i class="fas fa-plus"></i></div>
      <div class="faq-a">Oui, vous pouvez évoluer vers un plan supérieur à tout moment. Le changement est effectif dans les 48h suivant votre demande. La facturation est proratisée au jour près. Il est également possible de combiner plusieurs types d'espaces selon vos besoins.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)"><span>Y a-t-il des frais d'installation ou de configuration ?</span><i class="fas fa-plus"></i></div>
      <div class="faq-a">Aucun frais caché. Le prix affiché inclut la configuration initiale complète, l'hébergement, le certificat SSL, le support technique et l'accompagnement de démarrage. Notre équipe configure tout pour vous gratuitement lors de l'activation.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)"><span>Est-ce que je garde mes données si je résilie ?</span><i class="fas fa-plus"></i></div>
      <div class="faq-a">Absolument. Vos données vous appartiennent. Lors de toute résiliation, nous vous remettons une exportation complète de vos données (contacts, contenus, analytics) dans des formats standards (CSV, JSON) dans un délai de 5 jours ouvrables.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)"><span>Puis-je activer plusieurs types d'espaces simultanément ?</span><i class="fas fa-plus"></i></div>
      <div class="faq-a">Oui. Par exemple, un hôtel peut combiner l'Espace Destination (pour le SEO touristique), l'Espace Activités (pour ses excursions), et l'Espace Boutique (pour ses produits locaux). Nous proposons des tarifs groupés avantageux pour les combinaisons. Contactez-nous pour un devis personnalisé.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)"><span>En combien de temps mon espace est-il opérationnel ?</span><i class="fas fa-plus"></i></div>
      <div class="faq-a">La configuration de base est effectuée dans les 48h suivant la validation de votre demande. Pour les espaces plus complexes (Entreprise Pro avec CRM personnalisé, Boutique avec catalogue important), comptez 3 à 5 jours ouvrables pour une configuration complète et optimale.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)"><span>Le programme Partenaire est-il disponible pour les non-résidents du Canada ?</span><i class="fas fa-plus"></i></div>
      <div class="faq-a">Oui, notre programme partenaire est ouvert aux résidents de tous les pays. Les paiements sont effectués en CAD par virement international (SWIFT) ou PayPal. Un minimum de 100 $ de commissions accumulées est requis pour déclencher le virement mensuel.</div>
    </div>
  </div>
</section>

<!-- ═══ CTA BANNER ═══ -->
<section style="padding: 0 clamp(18px,4vw,60px) 60px">
  <div class="cta-banner reveal" id="contact">
    <div class="cta-banner-text">
      <h3>Pas sûr de quel plan choisir ? <em>On vous guide.</em></h3>
      <p>Notre équipe analyse gratuitement votre situation et vous recommande l'espace le mieux adapté à vos objectifs et à votre budget. Consultation sans engagement, réponse sous 24h.</p>
    </div>
    <div class="cta-banner-btns">
      <a href="{{ url('devis') }}" class="btn-amber"><i class="fas fa-rocket"></i> Consultation gratuite</a>
      <a href="tel:(418) 525-7748" class="btn-ghost"><i class="fas fa-phone-alt"></i> Nous appeler</a>
    </div>
  </div>
</section>

<!-- ═══ FOOTER ═══ -->
<footer class="footer">
  <div class="footer-grid">
    <div>
      <div class="footer-brand">
            <img src="{{ asset('logo.png') }}" alt="Next Level" style="height: 75px;">
      </div>
      <p class="footer-desc">Des espaces professionnels clé en main pour chaque acteur du tourisme et du commerce digital. Votre succès digital commence ici.</p>
      <div class="footer-socials">
        <a href="#" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="#" class="social-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        <a href="#" class="social-btn" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
      </div>
    </div>
    <div class="footer-col">
      <h5>Nos Plans</h5>
      <a href="#entreprise">Espace Entreprise Pro</a>
      <a href="#destinations">Espace Destination</a>
      <a href="#partenaires">Programme Partenaire</a>
      <a href="#activites">Espace Activités</a>
      <a href="#produits">Espace Boutique</a>
    </div>
    <div class="footer-col">
      <h5>GoExploria Business</h5>
      <a href="#">À propos</a>
      <a href="#">Conseils Entreprises</a>
      <a href="#">Blog & Ressources</a>
      <a href="#">Cas clients</a>
      <a href="#">Carrières</a>
    </div>
    <div class="footer-col">
      <h5>Contact</h5>
      <a href="/devis">Consultation gratuite</a>
      <a href="mailto:info@GoExploriaBusiness.com">info@GoExploriaBusiness.com</a>
      <a href="tel:+14185550192">+1 (418) 555-0192</a>
      <a href="#">Québec, QC, Canada</a>
      <a href="#">Politique de confidentialité</a>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© 2026 GoExploria Business. Tous droits réservés.</span>
    <span>Conçu avec <span style="color:var(--amber)">♥</span> au Québec</span>
  </div>
</footer>

<button class="scroll-top" id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="Retour en haut">
  <i class="fas fa-chevron-up"></i>
</button>

<!-- JSON-LD -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Plans Next Level GoExploria Business",
  "description": "Espaces professionnels clé en main pour entreprises, destinations touristiques, partenaires affiliés, activités et boutiques.",
  "url": "https://GoExploriaBusiness.com/next-level/plans",
  "publisher": { "@type": "Organization", "name": "GoExploria Business", "url": "https://GoExploriaBusiness.com" },
  "mainEntity": {
    "@type": "ItemList",
    "itemListElement": [
      {"@type":"ListItem","position":1,"name":"Espace Entreprise Pro","url":"https://GoExploriaBusiness.com/next-level-entreprises"},
      {"@type":"ListItem","position":2,"name":"Espace Destination","url":"https://GoExploriaBusiness.com/next-level-destinations"},
      {"@type":"ListItem","position":3,"name":"Programme Partenaire","url":"https://GoExploriaBusiness.com/next-level-partenaires"},
      {"@type":"ListItem","position":4,"name":"Espace Activités","url":"https://GoExploriaBusiness.com/next-level-activites"},
      {"@type":"ListItem","position":5,"name":"Espace Boutique","url":"https://GoExploriaBusiness.com/next-level-produits"}
    ]
  }
}
</script>

<script>
/* Reveal */
const obs = new IntersectionObserver(e => e.forEach(x => { if(x.isIntersecting){x.target.classList.add('visible');obs.unobserve(x.target);} }), {threshold:0.1});
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

/* Scroll top */
window.addEventListener('scroll', () => document.getElementById('scrollTop').classList.toggle('visible', scrollY > 400));

/* FAQ */
function toggleFaq(el) {
  const item = el.closest('.faq-item');
  const open = item.classList.contains('open');
  document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
  if (!open) item.classList.add('open');
}

/* Smooth scroll tabs */
function scrollTo(id) {
  const el = document.querySelector(id);
  if (el) el.scrollIntoView({behavior:'smooth', block:'start'});
}

/* Nav tabs active on scroll */
const sections = ['plans','entreprise','destinations','partenaires','activites','produits'];
const tabEls = document.querySelectorAll('.type-tab');
const secEls = sections.map(id => document.getElementById(id));
window.addEventListener('scroll', () => {
  let cur = 0;
  secEls.forEach((s, i) => { if (s && s.getBoundingClientRect().top < 120) cur = i; });
  tabEls.forEach((t, i) => t.classList.toggle('active', i === cur));
});

/* Mobile nav */
function toggleNav() {
  const ul = document.querySelector('.nav-links');
  if (ul.style.display === 'flex') { ul.style.display = ''; } else {
    ul.style.cssText='display:flex;flex-direction:column;position:absolute;top:62px;left:0;right:0;background:#fff;border-bottom:1px solid #e2e8f0;padding:18px 20px;gap:16px;z-index:99;box-shadow:0 8px 32px rgba(0,0,0,0.08)';
  }
}

/* Animate stat counters */
document.querySelectorAll('.hero-stat strong').forEach(el => {
  const txt = el.textContent.trim();
  const num = parseFloat(txt);
  if (isNaN(num)) return;
  const suffix = txt.replace(String(num), '');
  el.textContent = '0' + suffix;
  const start = performance.now();
  const animate = now => {
    const p = Math.min((now - start) / 1400, 1);
    const ease = 1 - Math.pow(1 - p, 3);
    el.textContent = Math.round(ease * num) + suffix;
    if (p < 1) requestAnimationFrame(animate);
  };
  setTimeout(() => requestAnimationFrame(animate), 400);
});
</script>
</body>
</html>