<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Conseils Entreprises | GoExploria Next Level — Visibilité & Performance Digitale</title>
<meta name="description" content="Transformez votre présence en ligne avec GoExploria Next Level. Audit digital, stratégie de croissance, accompagnement expert et IA intégrée pour les entreprises ambitieuses. Consultation gratuite en 48h.">
<meta name="keywords" content="conseil entreprise, SEO, marketing digital, audit digital, croissance en ligne, stratégie digitale, GoExploria, Next Level, visibilité Google, consultant digital">
<meta property="og:title" content="GoExploria Next Level — Conseils Entreprises">
<meta property="og:description" content="Passez au niveau supérieur avec nos experts certifiés. Résultats mesurables dès les premières semaines.">
<meta property="og:type" content="website">
<link rel="canonical" href="https://goexploria.com/next-level-conseils">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600;700&family=Bebas+Neue&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ── DESIGN SYSTEM ── */
:root {
  --ink: #0d1117;
  --ink-mid: #1e2a3a;
  --ink-soft: #374151;
  --smoke: #f4f6fa;
  --white: #ffffff;
  --amber: #e8761a;
  --amber-dark: #c04f10;
  --amber-glow: rgba(232,118,26,0.18);
  --emerald: #10b981;
  --sapphire: #3b82f6;
  --violet: #8b5cf6;
  --navy: #0f2240;
  --navy-mid: #1e3a5f;
  --border: #e4e9f0;
  --radius-lg: 24px;
  --radius-md: 16px;
  --radius-sm: 10px;
  --shadow-card: 0 4px 24px rgba(13,17,23,0.07);
  --shadow-hover: 0 20px 60px rgba(232,118,26,0.12);
  --transition: all 0.32s cubic-bezier(0.4,0,0.2,1);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
  font-family: 'DM Sans', sans-serif;
  background: var(--white);
  color: var(--ink);
  -webkit-font-smoothing: antialiased;
  overflow-x: hidden;
}
img { max-width: 100%; display: block; }
a { text-decoration: none; }

/* ── SCROLLBAR ── */
::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: var(--smoke); }
::-webkit-scrollbar-thumb { background: var(--amber); border-radius: 99px; }

/* ══════════════════════════════════
   NAV
══════════════════════════════════ */
.nl-nav {
  position: sticky; top: 0; z-index: 100;
  background: rgba(255,255,255,0.92);
  backdrop-filter: blur(16px);
  border-bottom: 1px solid var(--border);
  padding: 0 clamp(20px, 4vw, 64px);
  display: flex; align-items: center; justify-content: space-between;
  height: 64px;
}
.nl-nav-logo {
  display: flex; align-items: center; gap: 10px;
  font-family: 'Bebas Neue', sans-serif;
  font-size: 22px; letter-spacing: 2px; color: var(--ink);
}
.nl-nav-logo span { color: var(--amber); }
.nl-nav-badge {
  font-size: 9px; font-weight: 700; text-transform: uppercase;
  letter-spacing: 2px; color: var(--amber);
  border: 1px solid var(--amber); padding: 2px 8px;
  border-radius: 4px; margin-left: 4px;
}
.nl-nav-links {
  display: flex; align-items: center; gap: 28px;
  list-style: none;
}
.nl-nav-links a {
  font-size: 13px; font-weight: 500; color: var(--ink-soft);
  transition: color 0.2s;
}
.nl-nav-links a:hover { color: var(--amber); }
.nl-nav-cta {
  background: var(--amber); color: #fff !important;
  padding: 9px 20px; border-radius: 8px; font-weight: 700 !important;
  font-size: 13px !important; transition: var(--transition) !important;
}
.nl-nav-cta:hover { background: var(--amber-dark) !important; transform: translateY(-1px); }
.nl-nav-hamburger {
  display: none; flex-direction: column; gap: 5px;
  cursor: pointer; padding: 4px;
}
.nl-nav-hamburger span {
  display: block; width: 24px; height: 2px;
  background: var(--ink); border-radius: 2px; transition: var(--transition);
}

/* ══════════════════════════════════
   BREADCRUMB
══════════════════════════════════ */
.nl-breadcrumb {
  background: var(--smoke);
  padding: 12px clamp(20px, 4vw, 64px);
  font-size: 12px; color: var(--ink-soft);
  display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
}
.nl-breadcrumb a { color: var(--amber); font-weight: 500; }
.nl-breadcrumb i { font-size: 9px; color: #9ca3af; }

/* ══════════════════════════════════
   HERO
══════════════════════════════════ */
.nl-hero {
  background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 55%, #0d1b35 100%);
  position: relative; overflow: hidden;
  padding: clamp(56px, 8vw, 100px) clamp(20px, 4vw, 64px);
  min-height: 88vh;
  display: grid; grid-template-columns: 1fr 1fr;
  gap: clamp(40px, 6vw, 80px); align-items: center;
}
.nl-hero-grid-bg {
  position: absolute; inset: 0; pointer-events: none;
  background-image:
    linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
  background-size: 44px 44px;
}
.nl-hero-orb {
  position: absolute; border-radius: 50%; pointer-events: none; filter: blur(80px);
}
.nl-hero-orb-1 {
  width: 500px; height: 500px; right: -100px; top: -100px;
  background: radial-gradient(circle, rgba(232,118,26,0.2) 0%, transparent 70%);
}
.nl-hero-orb-2 {
  width: 300px; height: 300px; left: 30%; bottom: -60px;
  background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, transparent 70%);
}
.nl-hero-left { position: relative; z-index: 2; }
.nl-hero-eyebrow {
  display: inline-flex; align-items: center; gap: 8px;
  font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.8px;
  color: #34d399; background: rgba(52,211,153,0.12);
  border: 1px solid rgba(52,211,153,0.25); border-radius: 999px;
  padding: 7px 18px; margin-bottom: 28px;
  animation: fadeUp 0.7s 0.1s both;
}
.nl-pulse-dot {
  width: 8px; height: 8px; background: #34d399; border-radius: 50%;
  animation: pulse 2s infinite;
}
@keyframes pulse { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(1.5);opacity:0.4} }
@keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

.nl-hero-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(36px, 4.5vw, 68px);
  font-weight: 900; line-height: 1.05;
  color: #fff; margin-bottom: 24px;
  animation: fadeUp 0.7s 0.2s both;
}
.nl-hero-title em { font-style: italic; color: var(--amber); }
.nl-hero-title .nl-title-line { display: block; }
.nl-hero-desc {
  font-size: clamp(14px, 1.3vw, 17px); color: rgba(255,255,255,0.68);
  line-height: 1.9; margin-bottom: 40px; max-width: 520px;
  animation: fadeUp 0.7s 0.3s both;
}
.nl-hero-actions {
  display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 52px;
  animation: fadeUp 0.7s 0.4s both;
}
.nl-btn-primary {
  background: var(--amber); color: #fff;
  padding: 15px 30px; border-radius: var(--radius-sm);
  font-weight: 700; font-size: 14px;
  display: inline-flex; align-items: center; gap: 9px;
  transition: var(--transition); letter-spacing: 0.3px;
}
.nl-btn-primary:hover { background: var(--amber-dark); transform: translateY(-3px); box-shadow: 0 14px 40px rgba(232,118,26,0.4); color: #fff; }
.nl-btn-outline {
  border: 1.5px solid rgba(255,255,255,0.28); color: #fff;
  padding: 15px 30px; border-radius: var(--radius-sm);
  font-weight: 700; font-size: 14px;
  display: inline-flex; align-items: center; gap: 9px;
  transition: var(--transition);
}
.nl-btn-outline:hover { border-color: #fff; background: rgba(255,255,255,0.08); color: #fff; }

.nl-hero-kpis {
  display: flex; gap: clamp(24px, 3vw, 40px); flex-wrap: wrap;
  animation: fadeUp 0.7s 0.5s both;
}
.nl-kpi-item { border-left: 2px solid rgba(232,118,26,0.4); padding-left: 16px; }
.nl-kpi-item strong {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(36px, 3.5vw, 52px); color: var(--amber); display: block; line-height: 1;
}
.nl-kpi-item span {
  font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px;
  color: rgba(255,255,255,0.5); margin-top: 4px; display: block;
}

/* Dashboard Visual */
.nl-hero-right { position: relative; z-index: 2; animation: fadeUp 0.9s 0.4s both; }
.nl-dashboard-card {
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: var(--radius-lg); overflow: hidden;
  backdrop-filter: blur(12px);
}
.nl-dash-header {
  background: rgba(255,255,255,0.05);
  border-bottom: 1px solid rgba(255,255,255,0.08);
  padding: 12px 18px; display: flex; align-items: center; gap: 10px;
}
.nl-dash-dots { display: flex; gap: 6px; }
.nl-dash-dots span { width: 10px; height: 10px; border-radius: 50%; }
.nl-dash-dots span:nth-child(1) { background: #ff5f57; }
.nl-dash-dots span:nth-child(2) { background: #febc2e; }
.nl-dash-dots span:nth-child(3) { background: #28c840; }
.nl-dash-title-bar { font-size: 11px; color: rgba(255,255,255,0.35); font-family: 'Space Mono', monospace; margin-left: 6px; }
.nl-dash-body { padding: 28px; display: flex; flex-direction: column; gap: 20px; }
.nl-dash-metric { display: flex; align-items: center; gap: 14px; }
.nl-dash-lbl { font-size: 12px; color: rgba(255,255,255,0.55); width: 140px; flex-shrink: 0; }
.nl-dash-track { flex: 1; height: 7px; background: rgba(255,255,255,0.07); border-radius: 99px; overflow: hidden; }
.nl-dash-fill {
  height: 100%; border-radius: 99px;
  background: linear-gradient(90deg, var(--amber), #f5a623);
  animation: fillBar 1.4s cubic-bezier(0.4,0,0.2,1) forwards;
  width: 0%;
}
@keyframes fillBar { to { width: var(--w); } }
.nl-dash-pct { font-size: 13px; font-weight: 700; min-width: 52px; text-align: right; }
.nl-dash-footer {
  display: flex; justify-content: space-between;
  padding: 14px 28px; border-top: 1px solid rgba(255,255,255,0.06);
  font-size: 11px; color: rgba(255,255,255,0.35); font-family: 'Space Mono', monospace;
}
.nl-live-dot { display: inline-flex; align-items: center; gap: 6px; }
.nl-live-dot::before {
  content: ''; width: 6px; height: 6px; background: #10b981;
  border-radius: 50%; display: inline-block; animation: pulse 2s infinite;
}

/* Mini cards below dashboard */
.nl-dash-mini-cards { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; margin-top: 14px; }
.nl-dash-mini {
  background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
  border-radius: 12px; padding: 16px; text-align: center;
}
.nl-dash-mini .val {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 28px; color: var(--amber); display: block; line-height: 1;
}
.nl-dash-mini .lbl { font-size: 10px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.8px; margin-top: 4px; }

/* ══════════════════════════════════
   SECTION WRAPPER
══════════════════════════════════ */
.nl-section {
  padding: clamp(60px, 8vw, 100px) clamp(20px, 4vw, 64px);
}
.nl-section-alt { background: var(--smoke); }
.nl-section-dark { background: var(--navy); }

.nl-tag {
  display: inline-flex; align-items: center; gap: 6px;
  font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;
  color: var(--amber); background: var(--amber-glow);
  padding: 6px 16px; border-radius: 999px; margin-bottom: 16px;
}
.nl-section-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(28px, 3.5vw, 48px);
  font-weight: 900; color: var(--ink); line-height: 1.1;
  margin-bottom: 16px;
}
.nl-section-title em { font-style: italic; color: var(--amber); }
.nl-section-lead {
  font-size: clamp(15px, 1.3vw, 17px);
  color: var(--ink-soft); line-height: 1.85; max-width: 640px;
}
.nl-section-header { max-width: 640px; }
.nl-section-header-center { text-align: center; max-width: 700px; margin: 0 auto 56px; }
.nl-section-header-center .nl-section-lead { max-width: none; }

/* ══════════════════════════════════
   SERVICES GRID (4 CARDS)
══════════════════════════════════ */
.nl-services-grid {
  display: grid; grid-template-columns: repeat(4, 1fr);
  gap: 20px; margin-top: 48px;
}
.nl-service-card {
  background: var(--white); border: 1.5px solid var(--border);
  border-radius: var(--radius-lg); padding: 36px 28px;
  position: relative; overflow: hidden;
  transition: var(--transition); cursor: default;
}
.nl-service-card::before {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(135deg, var(--amber-glow), transparent);
  opacity: 0; transition: var(--transition);
}
.nl-service-card:hover {
  border-color: var(--amber); transform: translateY(-6px);
  box-shadow: var(--shadow-hover);
}
.nl-service-card:hover::before { opacity: 1; }
.nl-service-number {
  font-family: 'Bebas Neue', sans-serif; font-size: 64px;
  color: var(--border); position: absolute; top: -4px; right: 20px;
  line-height: 1; transition: var(--transition);
}
.nl-service-card:hover .nl-service-number { color: var(--amber-glow); }
.nl-service-icon-wrap {
  width: 56px; height: 56px; border-radius: 16px;
  display: flex; align-items: center; justify-content: center;
  font-size: 24px; margin-bottom: 22px; position: relative;
}
.nl-service-card h3 {
  font-size: 18px; font-weight: 700; color: var(--ink);
  margin-bottom: 12px; line-height: 1.3;
}
.nl-service-card p {
  font-size: 13.5px; color: var(--ink-soft); line-height: 1.75;
  margin-bottom: 20px;
}
.nl-service-tag {
  display: inline-block; font-size: 10px; font-weight: 700;
  text-transform: uppercase; letter-spacing: 1px;
  padding: 4px 12px; border-radius: 6px;
}
.nl-service-features {
  margin-top: 16px; display: flex; flex-direction: column; gap: 8px;
}
.nl-service-features li {
  font-size: 12.5px; color: var(--ink-soft);
  display: flex; align-items: center; gap: 8px; list-style: none;
}
.nl-service-features li i { font-size: 10px; color: var(--emerald); flex-shrink: 0; }

/* ══════════════════════════════════
   HOW IT WORKS — PROCESS
══════════════════════════════════ */
.nl-process-grid {
  display: grid; grid-template-columns: repeat(5, 1fr);
  gap: 0; margin-top: 56px; position: relative;
}
.nl-process-grid::before {
  content: ''; position: absolute;
  top: 38px; left: 10%; width: 80%; height: 2px;
  background: linear-gradient(90deg, transparent, var(--amber), transparent);
  z-index: 0;
}
.nl-process-step { text-align: center; padding: 0 12px; position: relative; z-index: 1; }
.nl-process-num {
  width: 76px; height: 76px; border-radius: 50%;
  background: var(--white); border: 2.5px solid var(--amber);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 20px;
  font-family: 'Bebas Neue', sans-serif; font-size: 28px; color: var(--amber);
  box-shadow: 0 0 0 6px var(--amber-glow);
  transition: var(--transition);
}
.nl-process-step:hover .nl-process-num {
  background: var(--amber); color: #fff;
  box-shadow: 0 0 0 8px var(--amber-glow), 0 8px 30px rgba(232,118,26,0.3);
}
.nl-process-step h4 { font-size: 14px; font-weight: 700; color: var(--ink); margin-bottom: 8px; }
.nl-process-step p { font-size: 12.5px; color: var(--ink-soft); line-height: 1.65; }

/* ══════════════════════════════════
   EXPERTISE SPLIT SECTION
══════════════════════════════════ */
.nl-expertise-split {
  display: grid; grid-template-columns: 1fr 1fr;
  gap: clamp(40px, 6vw, 80px); align-items: center;
}
.nl-expertise-visual {
  position: relative; border-radius: var(--radius-lg); overflow: hidden;
  background: linear-gradient(135deg, var(--navy), var(--navy-mid));
  padding: 48px 40px; min-height: 480px;
  display: flex; flex-direction: column; justify-content: space-between;
}
.nl-expertise-chart { display: flex; flex-direction: column; gap: 18px; }
.nl-chart-item { display: flex; flex-direction: column; gap: 8px; }
.nl-chart-lbl { display: flex; justify-content: space-between; font-size: 12px; color: rgba(255,255,255,0.65); }
.nl-chart-bar-bg { height: 10px; background: rgba(255,255,255,0.08); border-radius: 99px; overflow: hidden; }
.nl-chart-bar-fill {
  height: 100%; border-radius: 99px;
  animation: fillBar 1.6s cubic-bezier(0.4,0,0.2,1) forwards;
}
.nl-expertise-quote {
  margin-top: 40px; padding: 24px; border-radius: 14px;
  background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
}
.nl-expertise-quote p {
  font-family: 'Playfair Display', serif; font-style: italic;
  font-size: 16px; color: rgba(255,255,255,0.85); line-height: 1.7;
  margin-bottom: 12px;
}
.nl-expertise-quote cite { font-size: 11px; color: rgba(255,255,255,0.45); text-transform: uppercase; letter-spacing: 1px; }

.nl-expertise-content .nl-section-title { margin-bottom: 20px; }
.nl-expertise-content .nl-section-lead { margin-bottom: 32px; }
.nl-expertise-list { display: flex; flex-direction: column; gap: 20px; }
.nl-exp-item {
  display: flex; gap: 18px; align-items: flex-start;
  padding: 20px; border-radius: var(--radius-md);
  border: 1px solid var(--border); transition: var(--transition);
}
.nl-exp-item:hover { border-color: var(--amber); background: #fffaf5; }
.nl-exp-icon {
  width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center; font-size: 18px;
}
.nl-exp-item h4 { font-size: 15px; font-weight: 700; color: var(--ink); margin-bottom: 4px; }
.nl-exp-item p { font-size: 13px; color: var(--ink-soft); line-height: 1.65; }

/* ══════════════════════════════════
   RESULTS / TESTIMONIALS
══════════════════════════════════ */
.nl-results-grid {
  display: grid; grid-template-columns: repeat(3, 1fr);
  gap: 24px; margin-top: 56px;
}
.nl-result-card {
  border-radius: var(--radius-lg); padding: 36px 28px;
  background: var(--white); border: 1.5px solid var(--border);
  transition: var(--transition); position: relative;
}
.nl-result-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-hover); border-color: var(--amber); }
.nl-result-stars { color: #f59e0b; font-size: 13px; letter-spacing: 2px; margin-bottom: 16px; }
.nl-result-quote {
  font-family: 'Playfair Display', serif; font-style: italic;
  font-size: 16px; color: var(--ink); line-height: 1.75; margin-bottom: 24px;
}
.nl-result-quote::before { content: '\201C'; font-size: 36px; color: var(--amber); line-height: 0; vertical-align: -14px; margin-right: 4px; }
.nl-result-author { display: flex; align-items: center; gap: 14px; }
.nl-result-avatar {
  width: 46px; height: 46px; border-radius: 50%;
  background: linear-gradient(135deg, var(--amber), var(--amber-dark));
  display: flex; align-items: center; justify-content: center;
  font-weight: 700; font-size: 16px; color: #fff; flex-shrink: 0;
}
.nl-result-name { font-size: 14px; font-weight: 700; color: var(--ink); }
.nl-result-role { font-size: 12px; color: #9ca3af; }
.nl-result-metric {
  position: absolute; top: 28px; right: 28px;
  font-family: 'Bebas Neue', sans-serif;
  font-size: 48px; line-height: 1; color: var(--amber-glow);
}

/* ══════════════════════════════════
   STATS BANNER
══════════════════════════════════ */
.nl-stats-banner {
  display: grid; grid-template-columns: repeat(4, 1fr);
  gap: 0; border-radius: var(--radius-lg);
  overflow: hidden; border: 1.5px solid var(--border);
  margin-top: 56px;
}
.nl-stat-cell {
  padding: 40px 32px; text-align: center;
  border-right: 1px solid var(--border);
  transition: var(--transition);
}
.nl-stat-cell:last-child { border-right: none; }
.nl-stat-cell:hover { background: #fffaf5; }
.nl-stat-val {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(44px, 4vw, 64px); color: var(--amber);
  display: block; line-height: 1;
}
.nl-stat-label { font-size: 12px; color: var(--ink-soft); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px; }

/* ══════════════════════════════════
   PLANS
══════════════════════════════════ */
.nl-plans-grid {
  display: grid; grid-template-columns: repeat(3, 1fr);
  gap: 24px; margin-top: 56px; align-items: start;
}
.nl-plan-card {
  border-radius: var(--radius-lg); padding: 40px 32px;
  border: 1.5px solid var(--border); background: var(--white);
  transition: var(--transition); position: relative; overflow: hidden;
}
.nl-plan-card.nl-featured {
  background: linear-gradient(145deg, var(--navy), var(--navy-mid));
  border-color: var(--amber);
  box-shadow: 0 24px 64px rgba(13, 18, 64, 0.25);
  transform: translateY(-12px);
}
.nl-plan-badge {
  position: absolute; top: 24px; right: -28px;
  background: var(--amber); color: #fff;
  font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px;
  padding: 6px 40px; transform: rotate(45deg);
}
.nl-plan-name {
  font-size: 12px; font-weight: 700; text-transform: uppercase;
  letter-spacing: 2px; color: var(--amber); margin-bottom: 8px;
}
.nl-plan-price {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 56px; color: var(--ink); line-height: 1;
  margin-bottom: 4px;
}
.nl-plan-card.nl-featured .nl-plan-price { color: #fff; }
.nl-plan-period { font-size: 12px; color: #9ca3af; margin-bottom: 24px; }
.nl-plan-divider { height: 1px; background: var(--border); margin: 24px 0; }
.nl-plan-card.nl-featured .nl-plan-divider { background: rgba(255,255,255,0.1); }
.nl-plan-features { display: flex; flex-direction: column; gap: 12px; list-style: none; margin-bottom: 32px; }
.nl-plan-features li {
  font-size: 13.5px; display: flex; align-items: flex-start; gap: 10px;
  color: var(--ink-soft); line-height: 1.5;
}
.nl-plan-card.nl-featured .nl-plan-features li { color: rgba(255,255,255,0.75); }
.nl-plan-features li i { color: var(--emerald); flex-shrink: 0; margin-top: 2px; font-size: 12px; }
.nl-plan-features li.nl-plan-no i { color: #9ca3af; }
.nl-plan-features li.nl-plan-no { opacity: 0.5; }
.nl-plan-btn {
  display: flex; align-items: center; justify-content: center; gap: 8px;
  width: 100%; padding: 15px; border-radius: var(--radius-sm);
  font-weight: 700; font-size: 14px; transition: var(--transition); cursor: pointer;
  border: none; font-family: 'DM Sans', sans-serif;
}
.nl-plan-btn-outline {
  background: transparent; border: 1.5px solid var(--border); color: var(--ink);
}
.nl-plan-btn-outline:hover { border-color: var(--amber); color: var(--amber); }
.nl-plan-btn-filled { background: var(--amber); color: #fff; }
.nl-plan-btn-filled:hover { background: var(--amber-dark); transform: translateY(-2px); box-shadow: 0 12px 32px rgba(232,118,26,0.35); }

/* ══════════════════════════════════
   FAQ
══════════════════════════════════ */
.nl-faq-grid {
  display: grid; grid-template-columns: 1fr 1fr;
  gap: 16px; margin-top: 48px;
}
.nl-faq-item {
  border: 1.5px solid var(--border); border-radius: var(--radius-md);
  overflow: hidden; transition: var(--transition);
}
.nl-faq-item:hover { border-color: var(--amber); }
.nl-faq-q {
  display: flex; align-items: center; justify-content: space-between;
  padding: 20px 24px; cursor: pointer; gap: 16px;
  font-size: 14px; font-weight: 600; color: var(--ink);
}
.nl-faq-q i { color: var(--amber); flex-shrink: 0; transition: var(--transition); }
.nl-faq-item.open .nl-faq-q i { transform: rotate(45deg); }
.nl-faq-a {
  display: none; padding: 0 24px 20px;
  font-size: 13.5px; color: var(--ink-soft); line-height: 1.8;
}
.nl-faq-item.open .nl-faq-a { display: block; }

/* ══════════════════════════════════
   TRUST LOGOS
══════════════════════════════════ */
.nl-trust-strip {
  border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
  padding: 36px clamp(20px, 4vw, 64px);
  display: flex; align-items: center; gap: 40px; overflow-x: auto; flex-wrap: wrap;
  justify-content: center;
}
.nl-trust-label {
  font-size: 11px; font-weight: 700; text-transform: uppercase;
  letter-spacing: 2px; color: #9ca3af; white-space: nowrap;
}
.nl-trust-logos { display: flex; align-items: center; gap: 48px; flex-wrap: wrap; justify-content: center; }
.nl-trust-logo {
  font-family: 'Bebas Neue', sans-serif; font-size: 22px;
  color: #c4c9d4; letter-spacing: 2px; transition: var(--transition);
  cursor: default;
}
.nl-trust-logo:hover { color: var(--ink); }

/* ══════════════════════════════════
   CONTACT FORM SECTION
══════════════════════════════════ */
.nl-contact-wrap {
  display: grid; grid-template-columns: 1fr 1.2fr;
  gap: clamp(40px, 6vw, 80px); align-items: start;
}
.nl-contact-info .nl-section-title { margin-bottom: 20px; }
.nl-contact-info .nl-section-lead { margin-bottom: 36px; }
.nl-contact-cards { display: flex; flex-direction: column; gap: 16px; margin-bottom: 36px; }
.nl-contact-card {
  display: flex; align-items: flex-start; gap: 16px;
  padding: 20px; border-radius: var(--radius-md);
  border: 1px solid var(--border); transition: var(--transition);
}
.nl-contact-card:hover { border-color: var(--amber); background: #fffaf5; }
.nl-contact-card-icon {
  width: 44px; height: 44px; border-radius: 12px;
  background: var(--amber-glow); color: var(--amber);
  display: flex; align-items: center; justify-content: center;
  font-size: 18px; flex-shrink: 0;
}
.nl-contact-card h4 { font-size: 14px; font-weight: 700; color: var(--ink); margin-bottom: 3px; }
.nl-contact-card p { font-size: 13px; color: var(--ink-soft); }
.nl-benefits-list { display: flex; flex-direction: column; gap: 10px; }
.nl-benefit-item {
  display: flex; align-items: center; gap: 10px;
  font-size: 13.5px; color: var(--ink-soft);
}
.nl-benefit-item i { color: var(--emerald); font-size: 13px; flex-shrink: 0; }

/* Form */
.nl-form-card {
  background: var(--white); border: 1.5px solid var(--border);
  border-radius: var(--radius-lg); padding: clamp(32px, 4vw, 52px);
  box-shadow: var(--shadow-card);
}
.nl-form-card-header { margin-bottom: 32px; }
.nl-form-card-header h3 {
  font-family: 'Playfair Display', serif;
  font-size: 24px; font-weight: 700; color: var(--ink); margin-bottom: 6px;
}
.nl-form-card-header p { font-size: 13.5px; color: var(--ink-soft); }
.nl-form { display: flex; flex-direction: column; gap: 18px; }
.nl-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.nl-fg { display: flex; flex-direction: column; gap: 6px; }
.nl-fg label { font-size: 12px; font-weight: 700; color: var(--ink); text-transform: uppercase; letter-spacing: 0.5px; }
.nl-fg input, .nl-fg select, .nl-fg textarea {
  border: 1.5px solid var(--border); border-radius: var(--radius-sm);
  padding: 13px 16px; font-size: 14px; color: var(--ink);
  background: var(--white); outline: none; transition: var(--transition);
  font-family: 'DM Sans', sans-serif;
}
.nl-fg input:focus, .nl-fg select:focus, .nl-fg textarea:focus {
  border-color: var(--amber); box-shadow: 0 0 0 3px var(--amber-glow);
}
.nl-fg textarea { resize: vertical; min-height: 100px; }
.nl-budget-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 8px; }
.nl-budget-opt {
  border: 1.5px solid var(--border); border-radius: 8px;
  padding: 10px 8px; text-align: center; cursor: pointer;
  font-size: 12px; font-weight: 600; color: var(--ink-soft);
  transition: var(--transition);
}
.nl-budget-opt:hover, .nl-budget-opt.selected {
  border-color: var(--amber); color: var(--amber); background: var(--amber-glow);
}
.nl-submit-btn {
  background: linear-gradient(135deg, var(--amber), var(--amber-dark));
  color: #fff; border: none; border-radius: var(--radius-sm);
  padding: 16px; font-size: 15px; font-weight: 700;
  cursor: pointer; display: flex; align-items: center; justify-content: center;
  gap: 9px; transition: var(--transition); font-family: 'DM Sans', sans-serif;
  letter-spacing: 0.3px;
}
.nl-submit-btn:hover { transform: translateY(-3px); box-shadow: 0 14px 40px rgba(232,118,26,0.4); }
.nl-form-note { font-size: 11.5px; color: #9ca3af; text-align: center; }
.nl-form-note i { color: #6b7280; }

/* ══════════════════════════════════
   FOOTER CTA STRIP
══════════════════════════════════ */
.nl-cta-strip {
  background: linear-gradient(135deg, var(--navy), var(--navy-mid));
  padding: clamp(56px, 8vw, 88px) clamp(20px, 4vw, 64px);
  text-align: center; position: relative; overflow: hidden;
}
.nl-cta-strip::before {
  content: ''; position: absolute; inset: 0; pointer-events: none;
  background-image: linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
  background-size: 44px 44px;
}
.nl-cta-strip h2 {
  font-family: 'Playfair Display', serif;
  font-size: clamp(28px, 4vw, 52px); font-weight: 900;
  color: #fff; line-height: 1.1; margin-bottom: 18px; position: relative;
}
.nl-cta-strip h2 em { font-style: italic; color: var(--amber); }
.nl-cta-strip p {
  font-size: clamp(14px, 1.2vw, 17px); color: rgba(255,255,255,0.65);
  line-height: 1.8; margin-bottom: 40px; max-width: 600px; margin-left: auto; margin-right: auto;
  position: relative;
}
.nl-cta-strip .nl-cta-actions { display: flex; justify-content: center; gap: 16px; flex-wrap: wrap; position: relative; }

/* ══════════════════════════════════
   FOOTER
══════════════════════════════════ */
.nl-footer {
  background: var(--ink); padding: 56px clamp(20px, 4vw, 64px) 28px;
}
.nl-footer-grid {
  display: grid; grid-template-columns: 2fr 1fr 1fr 1fr;
  gap: 48px; margin-bottom: 48px;
}
.nl-footer-brand-name {
  font-family: 'Bebas Neue', sans-serif; font-size: 26px;
  letter-spacing: 2px; color: #fff; margin-bottom: 12px;
}
.nl-footer-brand-name span { color: var(--amber); }
.nl-footer-brand-desc { font-size: 13px; color: rgba(255,255,255,0.45); line-height: 1.8; margin-bottom: 24px; }
.nl-footer-socials { display: flex; gap: 12px; }
.nl-social-btn {
  width: 36px; height: 36px; border-radius: 8px;
  background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
  display: flex; align-items: center; justify-content: center;
  color: rgba(255,255,255,0.55); font-size: 14px; transition: var(--transition);
}
.nl-social-btn:hover { background: var(--amber); border-color: var(--amber); color: #fff; }
.nl-footer-col h5 {
  font-size: 12px; font-weight: 700; text-transform: uppercase;
  letter-spacing: 1.5px; color: rgba(255,255,255,0.4); margin-bottom: 18px;
}
.nl-footer-links { display: flex; flex-direction: column; gap: 11px; }
.nl-footer-links a {
  font-size: 13px; color: rgba(255,255,255,0.55); transition: color 0.2s;
}
.nl-footer-links a:hover { color: var(--amber); }
.nl-footer-bottom {
  border-top: 1px solid rgba(255,255,255,0.07);
  padding-top: 24px; display: flex; justify-content: space-between;
  align-items: center; flex-wrap: gap; gap: 12px;
  font-size: 12px; color: rgba(255,255,255,0.3);
}
.nl-footer-bottom a { color: rgba(255,255,255,0.4); transition: color 0.2s; }
.nl-footer-bottom a:hover { color: var(--amber); }

/* ══════════════════════════════════
   SCROLL TO TOP
══════════════════════════════════ */
.nl-scroll-top {
  position: fixed; bottom: 28px; right: 28px;
  width: 44px; height: 44px; border-radius: 12px;
  background: var(--amber); color: #fff; border: none; cursor: pointer;
  display: none; align-items: center; justify-content: center;
  font-size: 16px; box-shadow: 0 8px 24px rgba(232,118,26,0.35);
  transition: var(--transition); z-index: 99;
}
.nl-scroll-top:hover { transform: translateY(-3px); }
.nl-scroll-top.visible { display: flex; }

/* ══════════════════════════════════
   RESPONSIVE
══════════════════════════════════ */
@media (max-width: 1100px) {
  .nl-hero { grid-template-columns: 1fr; min-height: auto; }
  .nl-hero-right { display: none; }
  .nl-services-grid { grid-template-columns: repeat(2, 1fr); }
  .nl-process-grid { grid-template-columns: repeat(3, 1fr); gap: 24px; }
  .nl-process-grid::before { display: none; }
  .nl-expertise-split { grid-template-columns: 1fr; }
  .nl-expertise-visual { min-height: auto; }
  .nl-results-grid { grid-template-columns: repeat(2, 1fr); }
  .nl-stats-banner { grid-template-columns: repeat(2, 1fr); }
  .nl-stat-cell:nth-child(2) { border-right: none; }
  .nl-stat-cell:nth-child(3) { border-right: 1px solid var(--border); }
  .nl-stats-banner .nl-stat-cell:nth-child(3),
  .nl-stats-banner .nl-stat-cell:nth-child(4) { border-top: 1px solid var(--border); }
  .nl-plans-grid { grid-template-columns: 1fr; max-width: 480px; margin-left: auto; margin-right: auto; }
  .nl-plan-card.nl-featured { transform: none; }
  .nl-faq-grid { grid-template-columns: 1fr; }
  .nl-contact-wrap { grid-template-columns: 1fr; }
  .nl-footer-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 640px) {
  .nl-nav-links { display: none; }
  .nl-nav-hamburger { display: flex; }
  .nl-services-grid { grid-template-columns: 1fr; }
  .nl-process-grid { grid-template-columns: 1fr 1fr; }
  .nl-results-grid { grid-template-columns: 1fr; }
  .nl-stats-banner { grid-template-columns: 1fr 1fr; }
  .nl-stat-cell { border-right: none; border-bottom: 1px solid var(--border); }
  .nl-form-row { grid-template-columns: 1fr; }
  .nl-footer-grid { grid-template-columns: 1fr; }
  .nl-hero-kpis { gap: 16px; }
  .nl-dash-mini-cards { display: none; }
}

/* ── Reveal animations ── */
.nl-reveal {
  opacity: 0; transform: translateY(28px);
  transition: opacity 0.65s ease, transform 0.65s ease;
}
.nl-reveal.visible { opacity: 1; transform: translateY(0); }
</style>
</head>
<body>

<!-- ═══════════════════════════════ NAV ═══════════════════════════════ -->
<nav class="nl-nav" role="navigation" aria-label="Navigation principale">
  <div class="nl-nav-logo">
            <img src="{{ asset('logo.png') }}" alt="Next Level" style="height: 75px;">
  </div>
  <ul class="nl-nav-links">
    <li><a href="#services">Services</a></li>
    <li><a href="#expertise">Expertise</a></li>
    <li><a href="#resultats">Résultats</a></li>
    <!-- <li><a href="#formules">Formules</a></li> -->
    <li><a href="#faq">FAQ</a></li>
    <li><a href="{{url('devis')}}" class="nl-nav-cta"><i class="fas fa-rocket"></i> Consultation gratuite</a></li>
  </ul>
  <div class="nl-nav-hamburger" onclick="toggleNav()" aria-label="Menu">
    <span></span><span></span><span></span>
  </div>
</nav>

<!-- BREADCRUMB -->
<nav class="nl-breadcrumb" aria-label="Fil d'Ariane">
  <a href="/">Accueil</a>
  <i class="fas fa-chevron-right"></i>
  <a href="/next-level">Next Level</a>
  <i class="fas fa-chevron-right"></i>
  <span>Conseils Entreprises</span>
</nav>

<!-- ═══════════════════════════════ HERO ═══════════════════════════════ -->
<header class="nl-hero" role="banner">
  <div class="nl-hero-grid-bg"></div>
  <div class="nl-hero-orb nl-hero-orb-1"></div>
  <div class="nl-hero-orb nl-hero-orb-2"></div>

  <div class="nl-hero-left">
    <div class="nl-hero-eyebrow">
      <div class="nl-pulse-dot"></div>
      Experts disponibles — Démarrez en 48h
    </div>
    <h1 class="nl-hero-title">
      <span class="nl-title-line">Conseils Entreprises</span>
      <span class="nl-title-line">Passez au <em>Niveau Supérieur</em></span>
    </h1>
    <p class="nl-hero-desc">Notre équipe de consultants certifiés analyse votre situation, identifie les opportunités clés et déploie des stratégies digitales qui génèrent des résultats mesurables dès les premières semaines. Visibilité. Performance. Croissance réelle.</p>
    <div class="nl-hero-actions">
      <a href="{{url('devis')}}" class="nl-btn-primary"><i class="fas fa-rocket"></i> Consultation gratuite</a>
      <a href="#services" class="nl-btn-outline"><i class="fas fa-play-circle"></i> Découvrir nos services</a>
    </div>
    <div class="nl-hero-kpis">
      <div class="nl-kpi-item"><strong>+42%</strong><span>Croissance moyenne</span></div>
      <div class="nl-kpi-item"><strong>94%</strong><span>Clients satisfaits</span></div>
      <div class="nl-kpi-item"><strong>250+</strong><span>Projets livrés</span></div>
      <div class="nl-kpi-item"><strong>48h</strong><span>Démarrage garanti</span></div>
    </div>
  </div>

  <div class="nl-hero-right">
    <div class="nl-dashboard-card">
      <div class="nl-dash-header">
        <div class="nl-dash-dots"><span></span><span></span><span></span></div>
        <div class="nl-dash-title-bar">GoExploria Dashboard — Performance Live</div>
      </div>
      <div class="nl-dash-body">
        <div class="nl-dash-metric">
          <span class="nl-dash-lbl">Visibilité Google</span>
          <div class="nl-dash-track"><div class="nl-dash-fill" style="--w:84%;background:linear-gradient(90deg,#e8761a,#f5a623)"></div></div>
          <span class="nl-dash-pct" style="color:var(--amber)">84%</span>
        </div>
        <div class="nl-dash-metric">
          <span class="nl-dash-lbl">Taux de conversion</span>
          <div class="nl-dash-track"><div class="nl-dash-fill" style="--w:67%;background:linear-gradient(90deg,#10b981,#34d399)"></div></div>
          <span class="nl-dash-pct" style="color:#10b981">67%</span>
        </div>
        <div class="nl-dash-metric">
          <span class="nl-dash-lbl">Score SEO</span>
          <div class="nl-dash-track"><div class="nl-dash-fill" style="--w:91%;background:linear-gradient(90deg,#3b82f6,#60a5fa)"></div></div>
          <span class="nl-dash-pct" style="color:#3b82f6">91/100</span>
        </div>
        <div class="nl-dash-metric">
          <span class="nl-dash-lbl">Leads entrants</span>
          <div class="nl-dash-track"><div class="nl-dash-fill" style="--w:73%;background:linear-gradient(90deg,#8b5cf6,#a78bfa)"></div></div>
          <span class="nl-dash-pct" style="color:#8b5cf6">+73%</span>
        </div>
        <div class="nl-dash-metric">
          <span class="nl-dash-lbl">ROI campagnes</span>
          <div class="nl-dash-track"><div class="nl-dash-fill" style="--w:88%;background:linear-gradient(90deg,#f59e0b,#fbbf24)"></div></div>
          <span class="nl-dash-pct" style="color:#f59e0b">×3.8</span>
        </div>
      </div>
      <div class="nl-dash-footer">
        <span class="nl-live-dot">Mis à jour en temps réel</span>
        <span style="font-family:Space Mono,monospace">Il y a 2 min.</span>
      </div>
    </div>
    <div class="nl-dash-mini-cards">
      <div class="nl-dash-mini"><span class="val">250+</span><span class="lbl">Projets</span></div>
      <div class="nl-dash-mini"><span class="val">94%</span><span class="lbl">Satisfaction</span></div>
      <div class="nl-dash-mini"><span class="val">48h</span><span class="lbl">Démarrage</span></div>
    </div>
  </div>
</header>

<!-- TRUST STRIP -->
<div class="nl-trust-strip" aria-label="Entreprises partenaires">
  <span class="nl-trust-label">Ils nous font confiance</span>
  <div class="nl-trust-logos">
    <span class="nl-trust-logo">TOURISTICA</span>
    <span class="nl-trust-logo">NEXHO</span>
    <span class="nl-trust-logo">VOYAGO</span>
    <span class="nl-trust-logo">RESTORIA</span>
    <span class="nl-trust-logo">IMMOTEK</span>
    <span class="nl-trust-logo">COMERCIO</span>
    <span class="nl-trust-logo">SERVICEPRO</span>
  </div>
</div>

<!-- ═══════════════════════════════ SERVICES ═══════════════════════════════ -->
<section class="nl-section" id="services" aria-labelledby="services-title">
  <div class="nl-section-header-center nl-reveal">
    <div class="nl-tag"><i class="fas fa-layer-group"></i> Nos Services</div>
    <h2 class="nl-section-title" id="services-title">Quatre piliers pour votre <em>croissance digitale</em></h2>
    <p class="nl-section-lead">Des solutions complètes et sur-mesure pour chaque aspect de votre présence en ligne, déployées par des experts certifiés qui connaissent votre marché.</p>
  </div>

  <div class="nl-services-grid">
    <article class="nl-service-card nl-reveal">
      <span class="nl-service-number">01</span>
      <div class="nl-service-icon-wrap" style="background:linear-gradient(135deg,#fef3ea,#fde4c5);color:#e8761a">
        <i class="fas fa-chart-line"></i>
      </div>
      <h3>Audit Digital Complet</h3>
      <p>Analyse approfondie de votre présence en ligne, positionnement SEO, campagnes actives et cartographie de vos concurrents directs. Rapport complet remis sous 72h.</p>
      <ul class="nl-service-features">
        <li><i class="fas fa-check-circle"></i> Analyse technique du site web</li>
        <li><i class="fas fa-check-circle"></i> Audit des backlinks & autorité</li>
        <li><i class="fas fa-check-circle"></i> Benchmarking concurrentiel</li>
        <li><i class="fas fa-check-circle"></i> Rapport PDF premium + présentation</li>
      </ul>
      <div class="nl-service-tag" style="background:rgba(232,118,26,0.1);color:#e8761a">Rapport en 72h</div>
    </article>

    <article class="nl-service-card nl-reveal" style="transition-delay:0.1s">
      <span class="nl-service-number">02</span>
      <div class="nl-service-icon-wrap" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);color:#3b82f6">
        <i class="fas fa-bullseye"></i>
      </div>
      <h3>Stratégie de Croissance</h3>
      <p>Plan d'action personnalisé sur 3, 6 et 12 mois avec objectifs chiffrés, canaux prioritaires et budget optimisé pour votre marché et vos ambitions.</p>
      <ul class="nl-service-features">
        <li><i class="fas fa-check-circle"></i> Feuille de route détaillée</li>
        <li><i class="fas fa-check-circle"></i> Canaux d'acquisition priorisés</li>
        <li><i class="fas fa-check-circle"></i> Objectifs KPIs & tableaux de bord</li>
        <li><i class="fas fa-check-circle"></i> Budget & ROI prévisionnel</li>
      </ul>
      <div class="nl-service-tag" style="background:rgba(59,130,246,0.1);color:#3b82f6">ROI garanti</div>
    </article>

    <article class="nl-service-card nl-reveal" style="transition-delay:0.2s">
      <span class="nl-service-number">03</span>
      <div class="nl-service-icon-wrap" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);color:#10b981">
        <i class="fas fa-users-cog"></i>
      </div>
      <h3>Accompagnement Expert</h3>
      <p>Un consultant dédié pilote l'exécution de votre stratégie, forme vos équipes et assure un suivi hebdomadaire de l'ensemble de vos KPIs avec ajustements en temps réel.</p>
      <ul class="nl-service-features">
        <li><i class="fas fa-check-circle"></i> Chef de projet dédié</li>
        <li><i class="fas fa-check-circle"></i> Réunion hebdomadaire de suivi</li>
        <li><i class="fas fa-check-circle"></i> Formation équipes internes</li>
        <li><i class="fas fa-check-circle"></i> Accès dashboard temps réel</li>
      </ul>
      <div class="nl-service-tag" style="background:rgba(16,185,129,0.1);color:#10b981">Suivi hebdomadaire</div>
    </article>

    <article class="nl-service-card nl-reveal" style="transition-delay:0.3s">
      <span class="nl-service-number">04</span>
      <div class="nl-service-icon-wrap" style="background:linear-gradient(135deg,#fdf4ff,#f3e8ff);color:#8b5cf6">
        <i class="fas fa-robot"></i>
      </div>
      <h3>Optimisation IA</h3>
      <p>Intégration des derniers outils d'intelligence artificielle pour automatiser vos processus, personnaliser vos contenus et multiplier votre productivité opérationnelle.</p>
      <ul class="nl-service-features">
        <li><i class="fas fa-check-circle"></i> Automatisation des workflows</li>
        <li><i class="fas fa-check-circle"></i> Personnalisation contenus & offres</li>
        <li><i class="fas fa-check-circle"></i> Chatbots & assistants IA</li>
        <li><i class="fas fa-check-circle"></i> Analyses prédictives avancées</li>
      </ul>
      <div class="nl-service-tag" style="background:rgba(139,92,246,0.1);color:#8b5cf6">IA intégrée</div>
    </article>
  </div>
</section>

<!-- ═══════════════════════════════ PROCESS ═══════════════════════════════ -->
<section class="nl-section nl-section-alt" id="processus" aria-labelledby="process-title">
  <div class="nl-section-header-center nl-reveal">
    <div class="nl-tag"><i class="fas fa-route"></i> Notre Méthode</div>
    <h2 class="nl-section-title" id="process-title">Un processus <em>éprouvé</em> en 5 étapes</h2>
    <p class="nl-section-lead">Chaque mission suit une méthodologie rigoureuse développée sur 250+ projets pour garantir des résultats prévisibles et mesurables à chaque étape.</p>
  </div>

  <div class="nl-process-grid nl-reveal">
    <div class="nl-process-step">
      <div class="nl-process-num">01</div>
      <h4>Diagnostic initial</h4>
      <p>Appel de découverte de 45 min. pour cerner vos objectifs, défis et opportunités immédiates.</p>
    </div>
    <div class="nl-process-step">
      <div class="nl-process-num">02</div>
      <h4>Audit complet</h4>
      <p>Analyse exhaustive de votre situation digitale, SEO, concurrents et potentiel de croissance.</p>
    </div>
    <div class="nl-process-step">
      <div class="nl-process-num">03</div>
      <h4>Plan stratégique</h4>
      <p>Feuille de route sur 12 mois avec priorités, budgets, KPIs et calendrier d'exécution.</p>
    </div>
    <div class="nl-process-step">
      <div class="nl-process-num">04</div>
      <h4>Déploiement</h4>
      <p>Mise en œuvre par nos équipes spécialisées avec reporting hebdomadaire et ajustements continus.</p>
    </div>
    <div class="nl-process-step">
      <div class="nl-process-num">05</div>
      <h4>Optimisation</h4>
      <p>Analyse des données, tests A/B, amélioration continue pour maximiser votre ROI sur la durée.</p>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ EXPERTISE SPLIT ═══════════════════════════════ -->
<section class="nl-section" id="expertise" aria-labelledby="expertise-title">
  <div class="nl-expertise-split">
    <div class="nl-expertise-visual nl-reveal">
      <div>
        <div class="nl-tag" style="background:rgba(232,118,26,0.15)"><i class="fas fa-signal"></i> Performance réelle</div>
        <h3 style="font-family:'Playfair Display',serif;font-size:clamp(22px,2.5vw,32px);color:#fff;margin:16px 0 32px;line-height:1.2">Résultats clients — <em style="color:var(--amber)">Moyennes sectorielles</em></h3>
        <div class="nl-expertise-chart">
          <div class="nl-chart-item">
            <div class="nl-chart-lbl"><span>Trafic organique</span><span style="color:var(--amber)">+68%</span></div>
            <div class="nl-chart-bar-bg"><div class="nl-chart-bar-fill" style="--w:68%;background:linear-gradient(90deg,#e8761a,#f5a623)"></div></div>
          </div>
          <div class="nl-chart-item">
            <div class="nl-chart-lbl"><span>Leads qualifiés</span><span style="color:#10b981">+54%</span></div>
            <div class="nl-chart-bar-bg"><div class="nl-chart-bar-fill" style="--w:54%;background:linear-gradient(90deg,#10b981,#34d399)"></div></div>
          </div>
          <div class="nl-chart-item">
            <div class="nl-chart-lbl"><span>Taux de conversion</span><span style="color:#3b82f6">+41%</span></div>
            <div class="nl-chart-bar-bg"><div class="nl-chart-bar-fill" style="--w:41%;background:linear-gradient(90deg,#3b82f6,#60a5fa)"></div></div>
          </div>
          <div class="nl-chart-item">
            <div class="nl-chart-lbl"><span>Retour sur investissement</span><span style="color:#8b5cf6">×3.8</span></div>
            <div class="nl-chart-bar-bg"><div class="nl-chart-bar-fill" style="--w:76%;background:linear-gradient(90deg,#8b5cf6,#a78bfa)"></div></div>
          </div>
          <div class="nl-chart-item">
            <div class="nl-chart-lbl"><span>Notoriété de marque</span><span style="color:#f59e0b">+89%</span></div>
            <div class="nl-chart-bar-bg"><div class="nl-chart-bar-fill" style="--w:89%;background:linear-gradient(90deg,#f59e0b,#fbbf24)"></div></div>
          </div>
        </div>
      </div>
      <div class="nl-expertise-quote">
        <p>En 6 mois, GoExploria a transformé notre présence en ligne. Notre trafic a doublé et nos réservations ont augmenté de 73%.</p>
        <cite>— Sophie M., Directrice Hôtel Lumière, Québec</cite>
      </div>
    </div>

    <div class="nl-expertise-content nl-reveal" style="transition-delay:0.15s">
      <div class="nl-tag"><i class="fas fa-award"></i> Notre Expertise</div>
      <h2 class="nl-section-title" id="expertise-title">Pourquoi choisir <em>GoExploria Next Level</em>&nbsp;?</h2>
      <p class="nl-section-lead">Nous ne sommes pas une agence généraliste. Nous sommes des spécialistes du digital pour les entreprises touristiques, hôtelières et de services qui veulent dominer leur marché.</p>
      <div class="nl-expertise-list">
        <div class="nl-exp-item">
          <div class="nl-exp-icon" style="background:var(--amber-glow);color:var(--amber)"><i class="fas fa-certificate"></i></div>
          <div>
            <h4>Consultants certifiés Google & Meta</h4>
            <p>Chaque expert de notre équipe est certifié par les principales plateformes digitales et se forme en continu aux dernières évolutions.</p>
          </div>
        </div>
        <div class="nl-exp-item">
          <div class="nl-exp-icon" style="background:rgba(16,185,129,0.1);color:#10b981"><i class="fas fa-map-marked-alt"></i></div>
          <div>
            <h4>Spécialistes du marché québécois & canadien</h4>
            <p>Connaissance approfondie du marché local, des comportements consommateurs et des spécificités culturelles qui font la différence.</p>
          </div>
        </div>
        <div class="nl-exp-item">
          <div class="nl-exp-icon" style="background:rgba(59,130,246,0.1);color:#3b82f6"><i class="fas fa-tachometer-alt"></i></div>
          <div>
            <h4>Résultats mesurables dès la 1ère semaine</h4>
            <p>Notre méthode est orientée résultats concrets. Vous suivez chaque indicateur clé dans un dashboard personnalisé en temps réel.</p>
          </div>
        </div>
        <div class="nl-exp-item">
          <div class="nl-exp-icon" style="background:rgba(139,92,246,0.1);color:#8b5cf6"><i class="fas fa-headset"></i></div>
          <div>
            <h4>Support dédié 7j/7</h4>
            <p>Un consultant attitré répond à vos questions et vous accompagne dans toutes vos décisions stratégiques, sans délai.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- STATS BANNER -->
<div style="padding: 0 clamp(20px, 4vw, 64px)">
  <div class="nl-stats-banner nl-reveal">
    <div class="nl-stat-cell">
      <span class="nl-stat-val">250+</span>
      <p class="nl-stat-label">Projets livrés avec succès</p>
    </div>
    <div class="nl-stat-cell">
      <span class="nl-stat-val">94%</span>
      <p class="nl-stat-label">Taux de satisfaction client</p>
    </div>
    <div class="nl-stat-cell">
      <span class="nl-stat-val">×3.8</span>
      <p class="nl-stat-label">ROI moyen généré</p>
    </div>
    <div class="nl-stat-cell">
      <span class="nl-stat-val">48h</span>
      <p class="nl-stat-label">Délai de démarrage garanti</p>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════ TESTIMONIALS ═══════════════════════════════ -->
<section class="nl-section nl-section-alt" id="resultats" aria-labelledby="results-title">
  <div class="nl-section-header-center nl-reveal">
    <div class="nl-tag"><i class="fas fa-star"></i> Témoignages</div>
    <h2 class="nl-section-title" id="results-title">Ce que disent <em>nos clients</em></h2>
    <p class="nl-section-lead">Des entreprises comme la vôtre ont transformé leur visibilité et leur chiffre d'affaires grâce à notre accompagnement. Voici leur expérience.</p>
  </div>

  <div class="nl-results-grid">
    <article class="nl-result-card nl-reveal">
      <div class="nl-result-metric">+73%</div>
      <div class="nl-result-stars">★★★★★</div>
      <p class="nl-result-quote">GoExploria a complètement transformé notre stratégie digitale. En 6 mois, notre taux de réservation a explosé et notre visibilité sur Google est passée du 8e au 1er rang.</p>
      <div class="nl-result-author">
        <div class="nl-result-avatar">SM</div>
        <div>
          <p class="nl-result-name">Sophie Marchand</p>
          <p class="nl-result-role">Directrice — Hôtel Lumière, Québec</p>
        </div>
      </div>
    </article>

    <article class="nl-result-card nl-reveal" style="transition-delay:0.1s">
      <div class="nl-result-metric">×4.2</div>
      <div class="nl-result-stars">★★★★★</div>
      <p class="nl-result-quote">L'audit a révélé des problèmes que nous ne soupçonnions pas. La stratégie mise en place a multiplié nos leads par 4 en moins de trois mois. Impressionnant.</p>
      <div class="nl-result-author">
        <div class="nl-result-avatar" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8)">JT</div>
        <div>
          <p class="nl-result-name">Jean-Pierre Tremblay</p>
          <p class="nl-result-role">PDG — Voyage & Détente, Montréal</p>
        </div>
      </div>
    </article>

    <article class="nl-result-card nl-reveal" style="transition-delay:0.2s">
      <div class="nl-result-metric">+89%</div>
      <div class="nl-result-stars">★★★★★</div>
      <p class="nl-result-quote">Le consultant assigné à notre compte est exceptionnel. Il comprend notre industrie, anticipe nos besoins et nous livre des résultats chaque semaine. Une valeur inestimable.</p>
      <div class="nl-result-author">
        <div class="nl-result-avatar" style="background:linear-gradient(135deg,#10b981,#059669)">AL</div>
        <div>
          <p class="nl-result-name">Amélie Lapointe</p>
          <p class="nl-result-role">Fondatrice — Gastronomie du Nord, Saguenay</p>
        </div>
      </div>
    </article>
  </div>
</section>

<!-- ═══════════════════════════════ PLANS ═══════════════════════════════ -->
<section class="nl-section" id="formules" aria-labelledby="plans-title" style="display: none;">
  <div class="nl-section-header-center nl-reveal">
    <div class="nl-tag"><i class="fas fa-tag"></i> Formules</div>
    <h2 class="nl-section-title" id="plans-title">Des formules <em>adaptées</em> à chaque ambition</h2>
    <p class="nl-section-lead">Choisissez la formule qui correspond à votre stade de développement. Toutes incluent une consultation initiale gratuite et un démarrage sous 48h.</p>
  </div>

  <div class="nl-plans-grid">
    <!-- Essentiel -->
    <div class="nl-plan-card nl-reveal">
      <p class="nl-plan-name">Essentiel</p>
      <p class="nl-plan-price">797<span style="font-size:22px;font-family:'DM Sans',sans-serif;color:#9ca3af">$</span></p>
      <p class="nl-plan-period">/ mois · Sans engagement</p>
      <div class="nl-plan-divider"></div>
      <ul class="nl-plan-features">
        <li><i class="fas fa-check-circle"></i> Audit digital initial complet</li>
        <li><i class="fas fa-check-circle"></i> Stratégie SEO de base</li>
        <li><i class="fas fa-check-circle"></i> 1 rapport mensuel</li>
        <li><i class="fas fa-check-circle"></i> Support par courriel</li>
        <li><i class="fas fa-check-circle"></i> Dashboard de suivi</li>
        <li class="nl-plan-no"><i class="fas fa-times-circle"></i> Consultant dédié</li>
        <li class="nl-plan-no"><i class="fas fa-times-circle"></i> Campagnes payantes</li>
        <li class="nl-plan-no"><i class="fas fa-times-circle"></i> Intégration IA avancée</li>
      </ul>
      <button class="nl-plan-btn nl-plan-btn-outline" onclick="location.href='#contact'">
        <i class="fas fa-paper-plane"></i> Commencer
      </button>
    </div>

    <!-- Pro — Featured -->
    <div class="nl-plan-card nl-featured nl-reveal" style="transition-delay:0.1s">
      <div class="nl-plan-badge">Populaire</div>
      <p class="nl-plan-name">Pro</p>
      <p class="nl-plan-price" style="color:#fff">1997<span style="font-size:22px;font-family:'DM Sans',sans-serif;color:rgba(255,255,255,0.5)">$</span></p>
      <p class="nl-plan-period" style="color:rgba(255,255,255,0.45)">/ mois · Sans engagement</p>
      <div class="nl-plan-divider"></div>
      <ul class="nl-plan-features">
        <li><i class="fas fa-check-circle"></i> Tout l'Essentiel inclus</li>
        <li><i class="fas fa-check-circle"></i> Stratégie SEO + SEM avancée</li>
        <li><i class="fas fa-check-circle"></i> Consultant dédié (réunion hebdo)</li>
        <li><i class="fas fa-check-circle"></i> Gestion campagnes Meta & Google</li>
        <li><i class="fas fa-check-circle"></i> Rapports hebdomadaires</li>
        <li><i class="fas fa-check-circle"></i> Création de contenus (8/mois)</li>
        <li><i class="fas fa-check-circle"></i> Formation équipes incluse</li>
        <li class="nl-plan-no"><i class="fas fa-times-circle"></i> Intégration IA sur-mesure</li>
      </ul>
      <button class="nl-plan-btn nl-plan-btn-filled" onclick="location.href='#contact'">
        <i class="fas fa-rocket"></i> Choisir Pro
      </button>
    </div>

    <!-- Elite -->
    <div class="nl-plan-card nl-reveal" style="transition-delay:0.2s">
      <p class="nl-plan-name">Elite</p>
      <p class="nl-plan-price">3997<span style="font-size:22px;font-family:'DM Sans',sans-serif;color:#9ca3af">$</span></p>
      <p class="nl-plan-period">/ mois · Contrat 6 mois</p>
      <div class="nl-plan-divider"></div>
      <ul class="nl-plan-features">
        <li><i class="fas fa-check-circle"></i> Tout le Pro inclus</li>
        <li><i class="fas fa-check-circle"></i> Intégration IA sur-mesure</li>
        <li><i class="fas fa-check-circle"></i> Automatisations avancées</li>
        <li><i class="fas fa-check-circle"></i> Création contenus illimitée</li>
        <li><i class="fas fa-check-circle"></i> Support prioritaire 7j/7</li>
        <li><i class="fas fa-check-circle"></i> Audit trimestriel approfondi</li>
        <li><i class="fas fa-check-circle"></i> Accès bêta aux nouveaux outils</li>
        <li><i class="fas fa-check-circle"></i> Direction stratégique mensuelle</li>
      </ul>
      <button class="nl-plan-btn nl-plan-btn-outline" onclick="location.href='#contact'">
        <i class="fas fa-star"></i> Choisir Elite
      </button>
    </div>
  </div>

  <p style="text-align:center;font-size:13px;color:#9ca3af;margin-top:32px"><i class="fas fa-shield-alt" style="color:var(--emerald)"></i> Tous les plans incluent une consultation gratuite de 45 min. et un démarrage garanti sous 48h. Annulation possible à tout moment.</p>
</section>

<!-- ═══════════════════════════════ FAQ ═══════════════════════════════ -->
<section class="nl-section nl-section-alt" id="faq" aria-labelledby="faq-title">
  <div class="nl-section-header-center nl-reveal">
    <div class="nl-tag"><i class="fas fa-question-circle"></i> FAQ</div>
    <h2 class="nl-section-title" id="faq-title">Questions <em>fréquentes</em></h2>
    <p class="nl-section-lead">Tout ce que vous devez savoir avant de démarrer avec GoExploria Next Level.</p>
  </div>

  <div class="nl-faq-grid nl-reveal">
    <div class="nl-faq-item">
      <div class="nl-faq-q" onclick="toggleFaq(this)">
        <span>En combien de temps verrai-je des résultats&nbsp;?</span>
        <i class="fas fa-plus"></i>
      </div>
      <div class="nl-faq-a">La plupart de nos clients constatent des améliorations mesurables dès les 2 à 4 premières semaines (visibilité, trafic, leads). Des résultats significatifs se matérialisent généralement entre 30 et 90 jours selon votre secteur et votre situation de départ.</div>
    </div>
    <div class="nl-faq-item">
      <div class="nl-faq-q" onclick="toggleFaq(this)">
        <span>Comment se passe la consultation gratuite&nbsp;?</span>
        <i class="fas fa-plus"></i>
      </div>
      <div class="nl-faq-a">C'est un appel vidéo de 45 minutes avec l'un de nos consultants seniors. Nous analysons votre situation, identifions vos principaux blocages et vous remettons 3 recommandations actionnables immédiatement — même si vous ne choisissez pas de travailler avec nous.</div>
    </div>
    <div class="nl-faq-item">
      <div class="nl-faq-q" onclick="toggleFaq(this)">
        <span>Est-ce que je peux annuler à tout moment&nbsp;?</span>
        <i class="fas fa-plus"></i>
      </div>
      <div class="nl-faq-a">Les formules Essentiel et Pro sont sans engagement et peuvent être annulées à tout moment avec un préavis de 30 jours. La formule Elite est soumise à un contrat de 6 mois pour garantir l'exécution complète de la stratégie et maximiser votre ROI.</div>
    </div>
    <div class="nl-faq-item">
      <div class="nl-faq-q" onclick="toggleFaq(this)">
        <span>Travaillez-vous avec tous les secteurs d'activité&nbsp;?</span>
        <i class="fas fa-plus"></i>
      </div>
      <div class="nl-faq-a">Notre expertise principale couvre le tourisme, l'hôtellerie, la restauration, le commerce et les services. Nous prenons en charge des clients d'autres secteurs au cas par cas selon la compatibilité avec notre méthodologie. Contactez-nous pour en discuter.</div>
    </div>
    <div class="nl-faq-item">
      <div class="nl-faq-q" onclick="toggleFaq(this)">
        <span>Que comprend exactement le dashboard de suivi&nbsp;?</span>
        <i class="fas fa-plus"></i>
      </div>
      <div class="nl-faq-a">Votre dashboard personnalisé affiche en temps réel votre trafic organique, les positions SEO par mot-clé, les performances de vos campagnes payantes, le nombre et la qualité des leads, votre score de visibilité et le calcul automatique de votre ROI.</div>
    </div>
    <div class="nl-faq-item">
      <div class="nl-faq-q" onclick="toggleFaq(this)">
        <span>Comment fonctionne l'intégration IA dans la formule Elite&nbsp;?</span>
        <i class="fas fa-plus"></i>
      </div>
      <div class="nl-faq-a">Nous analysons vos processus métiers et identifions les tâches automatisables (qualification de leads, réponses aux questions fréquentes, génération de contenus, personnalisation des offres). Nous déployons ensuite des solutions IA sur-mesure connectées à vos outils existants.</div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ CONTACT FORM ═══════════════════════════════ -->
<section class="nl-section" id="contact" aria-labelledby="contact-title">
  <div class="nl-contact-wrap">
    <div class="nl-contact-info nl-reveal">
      <div class="nl-tag"><i class="fas fa-calendar-check"></i> Consultation offerte</div>
      <h2 class="nl-section-title" id="contact-title">Demandez votre <em>diagnostic gratuit</em></h2>
      <p class="nl-section-lead">En 45 minutes, nos experts analysent votre situation et vous remettent un plan d'action concret. Sans engagement, sans pression.</p>

      <div class="nl-contact-cards">
        <div class="nl-contact-card">
          <div class="nl-contact-card-icon"><i class="fas fa-phone"></i></div>
          <div>
            <h4>Par téléphone</h4>
            <p>+1 (418) 555-0192 · Lun–Ven 9h–18h</p>
          </div>
        </div>
        <div class="nl-contact-card">
          <div class="nl-contact-card-icon"><i class="fas fa-envelope"></i></div>
          <div>
            <h4>Par courriel</h4>
            <p>conseils@goexploria.com · Réponse &lt; 4h</p>
          </div>
        </div>
        <div class="nl-contact-card">
          <div class="nl-contact-card-icon"><i class="fas fa-video"></i></div>
          <div>
            <h4>Appel vidéo (Zoom / Teams)</h4>
            <p>Planifiez directement dans notre agenda en ligne</p>
          </div>
        </div>
      </div>

      <div class="nl-benefits-list">
        <div class="nl-benefit-item"><i class="fas fa-check-circle"></i> Audit de votre site web et présence digitale</div>
        <div class="nl-benefit-item"><i class="fas fa-check-circle"></i> Analyse SEO et positionnement concurrentiel</div>
        <div class="nl-benefit-item"><i class="fas fa-check-circle"></i> Recommandations personnalisées immédiatement</div>
        <div class="nl-benefit-item"><i class="fas fa-check-circle"></i> Estimation du potentiel de croissance chiffré</div>
        <div class="nl-benefit-item"><i class="fas fa-check-circle"></i> Zéro spam · Confidentialité totale assurée</div>
      </div>
    </div>

    <div class="nl-form-card nl-reveal" style="transition-delay:0.15s">
      <div class="nl-form-card-header">
        <h3>Demande de consultation</h3>
        <p>Remplissez ce formulaire et un expert vous contacte sous 24h ouvrables.</p>
      </div>
      <form class="nl-form" id="nlMainForm" novalidate>
        <div class="nl-form-row">
          <div class="nl-fg">
            <label for="company">Nom de votre entreprise</label>
            <input type="text" id="company" placeholder="Ex : Ma Société Inc." required>
          </div>
          <div class="nl-fg">
            <label for="fullname">Votre nom complet</label>
            <input type="text" id="fullname" placeholder="Ex : Jean Dupont" required>
          </div>
        </div>
        <div class="nl-form-row">
          <div class="nl-fg">
            <label for="email">Courriel professionnel</label>
            <input type="email" id="email" placeholder="jean@entreprise.com" required>
          </div>
          <div class="nl-fg">
            <label for="phone">Téléphone (optionnel)</label>
            <input type="tel" id="phone" placeholder="+1 (514) 000-0000">
          </div>
        </div>
        <div class="nl-form-row">
          <div class="nl-fg">
            <label for="sector">Secteur d'activité</label>
            <select id="sector" required>
              <option value="">Choisissez votre secteur</option>
              <option>Tourisme & Hôtellerie</option>
              <option>Commerce & E-commerce</option>
              <option>Services & Conseil</option>
              <option>Restauration & Gastronomie</option>
              <option>Immobilier & Construction</option>
              <option>Technologie & SaaS</option>
              <option>Santé & Bien-être</option>
              <option>Autre secteur</option>
            </select>
          </div>
          <div class="nl-fg">
            <label for="goal">Objectif principal</label>
            <select id="goal">
              <option value="">Votre priorité actuelle</option>
              <option>Augmenter mon trafic organique</option>
              <option>Générer plus de leads qualifiés</option>
              <option>Améliorer mon taux de conversion</option>
              <option>Lancer mes campagnes publicitaires</option>
              <option>Automatiser avec l'IA</option>
              <option>Stratégie globale de croissance</option>
            </select>
          </div>
        </div>
        <div class="nl-fg">
          <label>Budget mensuel envisagé</label>
          <div class="nl-budget-grid" id="budgetGrid">
            <div class="nl-budget-opt" onclick="selectBudget(this)">Moins de 500 $</div>
            <div class="nl-budget-opt" onclick="selectBudget(this)">500 $ – 2 000 $</div>
            <div class="nl-budget-opt" onclick="selectBudget(this)">2 000 $ – 5 000 $</div>
            <div class="nl-budget-opt" onclick="selectBudget(this)">5 000 $ – 10 000 $</div>
            <div class="nl-budget-opt" onclick="selectBudget(this)">10 000 $ +</div>
            <div class="nl-budget-opt" onclick="selectBudget(this)">À définir ensemble</div>
          </div>
        </div>
        <div class="nl-fg">
          <label for="challenge">Votre principal défi en ce moment</label>
          <textarea id="challenge" placeholder="Décrivez brièvement votre situation, vos objectifs et ce que vous avez déjà essayé..." rows="4"></textarea>
        </div>
        <button type="submit" class="nl-submit-btn">
          <i class="fas fa-paper-plane"></i> Envoyer ma demande — Réponse sous 24h
        </button>
        <p class="nl-form-note"><i class="fas fa-lock"></i> Réponse garantie sous 24h · Zéro spam · Données 100% confidentielles</p>
      </form>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════ CTA STRIP ═══════════════════════════════ -->
<div class="nl-cta-strip">
  <h2>Prêt à passer au <em>niveau supérieur</em>&nbsp;?</h2>
  <p>Rejoignez les 250+ entreprises qui ont transformé leur présence digitale avec GoExploria Next Level. La consultation initiale est gratuite et sans engagement.</p>
  <div class="nl-cta-actions">
    <a href="#contact" class="nl-btn-primary"><i class="fas fa-rocket"></i> Démarrer maintenant — C'est gratuit</a>
    <a href="tel:+14185550192" class="nl-btn-outline"><i class="fas fa-phone"></i> Nous appeler directement</a>
  </div>
</div>

<!-- ═══════════════════════════════ FOOTER ═══════════════════════════════ -->
<footer class="nl-footer" role="contentinfo">
  <div class="nl-footer-grid">
    <div>
      <div class="nl-footer-brand-name">
                    <img src="{{ asset('logo.png') }}" alt="Next Level" style="height: 75px;">

      </div>
      <p class="nl-footer-brand-desc">Votre partenaire de croissance digitale. Experts en visibilité, performance et transformation digitale pour les entreprises ambitieuses du Québec et du Canada.</p>
      <div class="nl-footer-socials">
        <a href="#" class="nl-social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="nl-social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="#" class="nl-social-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        <a href="#" class="nl-social-btn" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
      </div>
    </div>
    <div class="nl-footer-col">
      <h5>Services</h5>
      <div class="nl-footer-links">
        <a href="#services">Audit Digital</a>
        <a href="#services">Stratégie SEO</a>
        <a href="#services">Campagnes payantes</a>
        <a href="#services">Création de contenus</a>
        <a href="#services">Intégration IA</a>
        <a href="#services">Formation équipes</a>
      </div>
    </div>
    <div class="nl-footer-col">
      <h5>Entreprise</h5>
      <div class="nl-footer-links">
        <a href="#">À propos de nous</a>
        <a href="#">Notre équipe</a>
        <a href="#">Cas clients</a>
        <a href="#">Blog & Ressources</a>
        <a href="#">Partenaires</a>
        <a href="#">Carrières</a>
      </div>
    </div>
    <div class="nl-footer-col">
      <h5>Contact</h5>
      <div class="nl-footer-links">
        <a href="#contact">Consultation gratuite</a>
        <a href="mailto:info@goexploriabusiness.com">info@goexploriabusiness.com</a>
        <a href="tel:+14185550192">+1 (418) 555-0192</a>
        <a href="#">Québec, QC, Canada</a>
        <a href="#">Politique de confidentialité</a>
        <a href="#">Conditions d'utilisation</a>
      </div>
    </div>
  </div>
  <div class="nl-footer-bottom">
    <span>© 2026 GoExploria Business. Tous droits réservés.</span>
    <span>Conçu avec <span style="color:var(--amber)">♥</span> au Québec</span>
  </div>
</footer>

<!-- Scroll to top -->
<button class="nl-scroll-top" id="scrollTopBtn" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="Retour en haut">
  <i class="fas fa-chevron-up"></i>
</button>

<script>
/* ── Reveal on scroll ── */
const reveals = document.querySelectorAll('.nl-reveal');
const revealObs = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); revealObs.unobserve(e.target); } });
}, { threshold: 0.12 });
reveals.forEach(el => revealObs.observe(el));

/* ── Bar fill animation ── */
const bars = document.querySelectorAll('.nl-chart-bar-fill');
const barObs = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) { e.target.style.width = e.target.style.getPropertyValue('--w') || getComputedStyle(e.target).getPropertyValue('--w'); barObs.unobserve(e.target); } });
}, { threshold: 0.3 });
bars.forEach(b => barObs.observe(b));

/* ── Dash fill bars ── */
const dashFills = document.querySelectorAll('.nl-dash-fill');
const dashObs = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      const w = e.target.style.cssText.match(/--w:\s*([^;]+)/)?.[1];
      if (w) { setTimeout(() => { e.target.style.width = w; }, 300); }
      dashObs.unobserve(e.target);
    }
  });
}, { threshold: 0.3 });
dashFills.forEach(d => dashObs.observe(d));

/* ── FAQ ── */
function toggleFaq(el) {
  const item = el.closest('.nl-faq-item');
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.nl-faq-item.open').forEach(i => i.classList.remove('open'));
  if (!isOpen) item.classList.add('open');
}

/* ── Budget select ── */
function selectBudget(el) {
  document.querySelectorAll('.nl-budget-opt').forEach(o => o.classList.remove('selected'));
  el.classList.add('selected');
}

/* ── Form submit ── */
document.getElementById('nlMainForm')?.addEventListener('submit', function(e) {
  e.preventDefault();
  const btn = this.querySelector('.nl-submit-btn');
  btn.innerHTML = '<i class="fas fa-check-circle"></i> Demande envoyée — Merci !';
  btn.style.background = 'linear-gradient(135deg,#10b981,#059669)';
  btn.disabled = true;
  setTimeout(() => {
    btn.innerHTML = '<i class="fas fa-paper-plane"></i> Envoyer ma demande — Réponse sous 24h';
    btn.style.background = '';
    btn.disabled = false;
    this.reset();
    document.querySelectorAll('.nl-budget-opt.selected').forEach(o => o.classList.remove('selected'));
  }, 5000);
});

/* ── Scroll top ── */
window.addEventListener('scroll', () => {
  document.getElementById('scrollTopBtn').classList.toggle('visible', window.scrollY > 500);
});

/* ── Nav toggle mobile ── */
function toggleNav() {
  const links = document.querySelector('.nl-nav-links');
  if (links.style.display === 'flex') {
    links.style.display = '';
  } else {
    links.style.cssText = 'display:flex;flex-direction:column;position:absolute;top:64px;left:0;right:0;background:#fff;border-bottom:1px solid #e4e9f0;padding:20px 24px;gap:18px;z-index:99;box-shadow:0 8px 32px rgba(0,0,0,0.1)';
  }
}

/* ── Smooth active nav ── */
const sections = document.querySelectorAll('section[id], header[id]');
const navLinks = document.querySelectorAll('.nl-nav-links a[href^="#"]');
const navObs = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      navLinks.forEach(l => l.classList.remove('active'));
      const active = document.querySelector(`.nl-nav-links a[href="#${e.target.id}"]`);
      if (active) active.classList.add('active');
    }
  });
}, { rootMargin: '-40% 0px -55% 0px' });
sections.forEach(s => navObs.observe(s));

/* ── Counter animation ── */
function animateCounter(el, target, suffix='') {
  const start = performance.now();
  const duration = 1600;
  const update = (now) => {
    const progress = Math.min((now - start) / duration, 1);
    const ease = 1 - Math.pow(1 - progress, 3);
    el.textContent = (typeof target === 'string' ? target : Math.round(ease * parseFloat(target))) + suffix;
    if (progress < 1) requestAnimationFrame(update);
  };
  requestAnimationFrame(update);
}

const statObs = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.querySelectorAll('.nl-stat-val').forEach(v => {
        const txt = v.textContent.trim();
        if (txt.includes('%')) animateCounter(v, parseFloat(txt), '%');
        else if (txt.includes('+')) animateCounter(v, parseFloat(txt.replace('+','')), '+');
        else if (txt.includes('×')) { /* skip */ }
      });
      statObs.unobserve(e.target);
    }
  });
}, { threshold: 0.5 });
document.querySelectorAll('.nl-stats-banner').forEach(b => statObs.observe(b));
</script>

<!-- Structured Data — JSON-LD -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ProfessionalService",
  "name": "GoExploria Next Level — Conseils Entreprises",
  "description": "Agence de conseil digital spécialisée en visibilité, performance SEO et croissance numérique pour les entreprises au Québec et au Canada.",
  "url": "https://goexploria.com/next-level-conseils",
  "telephone": "+14185550192",
  "email": "conseils@goexploria.com",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "Québec",
    "addressRegion": "QC",
    "addressCountry": "CA"
  },
  "priceRange": "$797 – $3997 / mois",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.9",
    "reviewCount": "94"
  },
  "hasOfferCatalog": {
    "@type": "OfferCatalog",
    "name": "Services de conseil digital",
    "itemListElement": [
      {"@type": "Offer", "name": "Formule Essentiel", "price": "797", "priceCurrency": "CAD"},
      {"@type": "Offer", "name": "Formule Pro", "price": "1997", "priceCurrency": "CAD"},
      {"@type": "Offer", "name": "Formule Elite", "price": "3997", "priceCurrency": "CAD"}
    ]
  }
}
</script>
</body>
</html>