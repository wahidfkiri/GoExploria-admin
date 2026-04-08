<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Go Exploria Mail Marketing</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --ink:     #0b0f1a;
  --ink-2:   #3a3f52;
  --ink-3:   #7a809a;
  --surface: #f7f8fc;
  --white:   #ffffff;
  --accent-o: #f5a623;
  --accent-b: #1a3a8f;
  --accent-b2: #2d5cc2;
  --radius-lg: 24px;
  --radius-md: 14px;
  --radius-sm: 8px;
}

body { font-family: 'DM Sans', sans-serif; background: var(--surface); color: var(--ink); }

/* ── Section wrapper ── */
.mm-section {
  padding: 80px 24px 100px;
  background: var(--surface);
  overflow: hidden;
}

.mm-inner { max-width: 1240px; margin: 0 auto; }

/* ── Header ── */
.mm-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 32px;
  margin-bottom: 64px;
  flex-wrap: wrap;
}

.mm-header-left { max-width: 600px; }

.mm-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: linear-gradient(135deg, #fff7e6, #fef0cc);
  border: 1px solid #f5c96880;
  color: #b87512;
  font-family: 'Syne', sans-serif;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  padding: 6px 16px;
  border-radius: 40px;
  margin-bottom: 22px;
}
.mm-eyebrow-dot {
  width: 6px; height: 6px; border-radius: 50%;
  background: var(--accent-o);
  animation: dotPulse 1.8s ease-in-out infinite;
}
@keyframes dotPulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.7)} }

.mm-title {
  font-family: 'Syne', sans-serif;
  font-size: clamp(32px, 5vw, 56px);
  font-weight: 800;
  color: var(--ink);
  line-height: 1.08;
  letter-spacing: -1.5px;
  margin-bottom: 18px;
}
.mm-title span {
  background: linear-gradient(135deg, var(--accent-b2), var(--accent-o));
  -webkit-background-clip: text; background-clip: text; color: transparent;
}

.mm-subtitle {
  font-size: 16px;
  line-height: 1.7;
  color: var(--ink-3);
  max-width: 500px;
}

.mm-cta-group { display: flex; gap: 12px; flex-wrap: wrap; }

.mm-btn-primary {
  display: inline-flex; align-items: center; gap: 10px;
  background: var(--ink);
  color: white;
  font-family: 'Syne', sans-serif;
  font-size: 14px; font-weight: 700;
  padding: 14px 28px; border-radius: 50px;
  text-decoration: none; transition: all .25s;
  border: none; cursor: pointer;
  letter-spacing: .3px;
}
.mm-btn-primary:hover { background: var(--accent-b); transform: translateY(-2px); }

.mm-btn-outline {
  display: inline-flex; align-items: center; gap: 10px;
  background: transparent;
  color: var(--ink);
  font-family: 'Syne', sans-serif;
  font-size: 14px; font-weight: 700;
  padding: 14px 28px; border-radius: 50px;
  text-decoration: none; transition: all .25s;
  border: 1.5px solid rgba(11,15,26,.15); cursor: pointer;
  letter-spacing: .3px;
}
.mm-btn-outline:hover { border-color: var(--accent-b); color: var(--accent-b); }

/* ── Stats row ── */
.mm-stats {
  display: flex;
  gap: 0;
  background: white;
  border-radius: var(--radius-lg);
  border: 1px solid rgba(11,15,26,.07);
  overflow: hidden;
  margin-bottom: 64px;
  box-shadow: 0 2px 20px rgba(11,15,26,.04);
}
.mm-stat {
  flex: 1;
  padding: 28px 32px;
  border-right: 1px solid rgba(11,15,26,.07);
  position: relative;
}
.mm-stat:last-child { border-right: none; }
.mm-stat-num {
  font-family: 'Syne', sans-serif;
  font-size: 36px; font-weight: 800;
  color: var(--ink);
  letter-spacing: -1px;
  line-height: 1;
  margin-bottom: 6px;
}
.mm-stat-num span { color: var(--accent-o); }
.mm-stat-label { font-size: 13px; color: var(--ink-3); font-weight: 400; }

/* ── Category filter tabs ── */
.mm-tabs {
  display: flex;
  gap: 8px;
  margin-bottom: 40px;
  flex-wrap: wrap;
}
.mm-tab {
  padding: 9px 20px;
  border-radius: 40px;
  font-size: 13px;
  font-weight: 500;
  background: white;
  border: 1.5px solid rgba(11,15,26,.1);
  color: var(--ink-2);
  cursor: pointer;
  transition: all .2s;
  font-family: 'DM Sans', sans-serif;
}
.mm-tab:hover { border-color: var(--accent-b); color: var(--accent-b); }
.mm-tab.active {
  background: var(--ink);
  border-color: var(--ink);
  color: white;
}

/* ── Card grid ── */
.mm-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-bottom: 80px;
}

/* ── Email card ── */
.mail-card-v2 {
  background: white;
  border-radius: var(--radius-lg);
  border: 1px solid rgba(11,15,26,.07);
  overflow: hidden;
  transition: all .3s cubic-bezier(.2,0,0,1);
  cursor: pointer;
  position: relative;
  display: flex;
  flex-direction: column;
}
.mail-card-v2:hover {
  transform: translateY(-6px);
  box-shadow: 0 24px 48px rgba(11,15,26,.10);
  border-color: rgba(11,15,26,.12);
}

/* Card illustration area */
.mc-visual {
  height: 200px;
  position: relative;
  overflow: hidden;
  flex-shrink: 0;
}

/* SVG Illustration backgrounds */
.mc-visual-inner {
  width: 100%; height: 100%;
  display: flex; align-items: center; justify-content: center;
  position: relative;
}

/* Card body */
.mc-body { padding: 24px; flex: 1; display: flex; flex-direction: column; }

.mc-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 5px 12px;
  border-radius: 40px;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  margin-bottom: 14px;
  width: fit-content;
}

.mc-title {
  font-family: 'Syne', sans-serif;
  font-size: 18px;
  font-weight: 700;
  color: var(--ink);
  margin-bottom: 10px;
  line-height: 1.3;
}

.mc-desc {
  font-size: 13.5px;
  color: var(--ink-3);
  line-height: 1.6;
  flex: 1;
  margin-bottom: 20px;
}

.mc-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 16px;
  border-top: 1px solid rgba(11,15,26,.06);
}

.mc-kpi {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  font-weight: 600;
  color: var(--ink-2);
}
.mc-kpi-dot {
  width: 8px; height: 8px; border-radius: 50%;
}

.mc-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  font-weight: 600;
  text-decoration: none;
  transition: gap .2s;
}
.mc-link:hover { gap: 10px; }

/* Card colour themes */
.theme-orange .mc-visual-inner { background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); }
.theme-blue   .mc-visual-inner { background: linear-gradient(135deg, #e8eeff 0%, #c9d8ff 100%); }
.theme-teal   .mc-visual-inner { background: linear-gradient(135deg, #e0f7f4 0%, #b2ebf2 100%); }
.theme-rose   .mc-visual-inner { background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%); }
.theme-green  .mc-visual-inner { background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); }
.theme-purple .mc-visual-inner { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); }

.theme-orange .mc-badge { background:#fff3e0; color:#c77a00; }
.theme-blue   .mc-badge { background:#e8eeff; color:#1a3a8f; }
.theme-teal   .mc-badge { background:#e0f7f4; color:#00695c; }
.theme-rose   .mc-badge { background:#fce4ec; color:#c2185b; }
.theme-green  .mc-badge { background:#e8f5e9; color:#2e7d32; }
.theme-purple .mc-badge { background:#ede7f6; color:#4527a0; }

.theme-orange .mc-kpi-dot { background:#f5a623; }
.theme-blue   .mc-kpi-dot { background:#2d5cc2; }
.theme-teal   .mc-kpi-dot { background:#00897b; }
.theme-rose   .mc-kpi-dot { background:#e91e63; }
.theme-green  .mc-kpi-dot { background:#43a047; }
.theme-purple .mc-kpi-dot { background:#7e57c2; }

.theme-orange .mc-link { color:#c77a00; }
.theme-blue   .mc-link { color:#1a3a8f; }
.theme-teal   .mc-link { color:#00695c; }
.theme-rose   .mc-link { color:#c2185b; }
.theme-green  .mc-link { color:#2e7d32; }
.theme-purple .mc-link { color:#4527a0; }

/* ── Featured wide card ── */
.mail-card-wide {
  grid-column: span 2;
  background: var(--ink);
  border-radius: var(--radius-lg);
  border: none;
  overflow: hidden;
  display: flex;
  transition: all .3s;
  cursor: pointer;
  position: relative;
}
.mail-card-wide:hover { transform: translateY(-6px); box-shadow: 0 24px 48px rgba(11,15,26,.25); }
.mc-wide-body {
  padding: 40px;
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  position: relative;
  z-index: 2;
}
.mc-wide-badge {
  display: inline-flex; align-items: center; gap: 6px;
  background: rgba(255,255,255,.1);
  border: 1px solid rgba(255,255,255,.2);
  color: rgba(255,255,255,.85);
  padding: 5px 14px; border-radius: 40px;
  font-size: 10px; font-weight: 700; letter-spacing: 1.2px;
  text-transform: uppercase; margin-bottom: 20px; width: fit-content;
}
.mc-wide-title {
  font-family: 'Syne', sans-serif;
  font-size: 28px; font-weight: 800; color: white;
  line-height: 1.2; letter-spacing: -.5px; margin-bottom: 14px;
}
.mc-wide-desc { font-size: 14px; color: rgba(255,255,255,.65); line-height: 1.6; margin-bottom: 28px; max-width: 380px; }
.mc-wide-link {
  display: inline-flex; align-items: center; gap: 10px;
  background: white; color: var(--ink);
  font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700;
  padding: 12px 24px; border-radius: 50px;
  text-decoration: none; transition: all .2s; width: fit-content;
}
.mc-wide-link:hover { background: var(--accent-o); }

.mc-wide-visual {
  width: 280px; flex-shrink: 0;
  position: relative; overflow: hidden;
  display: flex; align-items: center; justify-content: center;
}
.mc-wide-visual::before {
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(45,92,194,.5), rgba(245,166,35,.3));
}

/* ── Process strip ── */
.mm-process {
  display: flex;
  align-items: flex-start;
  gap: 0;
  background: white;
  border-radius: var(--radius-lg);
  border: 1px solid rgba(11,15,26,.07);
  overflow: hidden;
  margin-bottom: 80px;
}
.mm-step {
  flex: 1;
  padding: 32px 28px;
  border-right: 1px solid rgba(11,15,26,.07);
  position: relative;
  transition: background .2s;
}
.mm-step:last-child { border-right: none; }
.mm-step:hover { background: #fafbff; }
.mm-step-num {
  font-family: 'Syne', sans-serif;
  font-size: 11px; font-weight: 700;
  color: var(--ink-3); letter-spacing: 2px;
  text-transform: uppercase; margin-bottom: 14px;
}
.mm-step-icon {
  width: 44px; height: 44px; border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 20px; margin-bottom: 14px;
}
.mm-step-title {
  font-family: 'Syne', sans-serif;
  font-size: 15px; font-weight: 700; color: var(--ink);
  margin-bottom: 8px;
}
.mm-step-desc { font-size: 13px; color: var(--ink-3); line-height: 1.55; }
.mm-step-arrow {
  position: absolute;
  right: -12px; top: 50%;
  transform: translateY(-50%);
  width: 24px; height: 24px;
  background: var(--surface);
  border: 1px solid rgba(11,15,26,.08);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 11px; color: var(--ink-3);
  z-index: 10;
}

/* ── Clients marquee ── */
.mm-marquee-wrap {
  overflow: hidden;
  margin-bottom: 80px;
  position: relative;
}
.mm-marquee-label {
  text-align: center;
  font-size: 12px; font-weight: 600;
  color: var(--ink-3); letter-spacing: 2px;
  text-transform: uppercase; margin-bottom: 24px;
}
.mm-marquee-track {
  display: flex; gap: 16px;
  animation: marquee 28s linear infinite;
  width: max-content;
}
.mm-marquee-track:hover { animation-play-state: paused; }
@keyframes marquee { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }
.mm-logo-pill {
  display: inline-flex; align-items: center; gap: 10px;
  background: white;
  border: 1px solid rgba(11,15,26,.08);
  border-radius: 50px;
  padding: 10px 22px;
  font-size: 13px; font-weight: 500;
  color: var(--ink-2);
  white-space: nowrap;
  flex-shrink: 0;
  transition: all .2s;
}
.mm-logo-pill i { font-size: 15px; color: var(--accent-b2); }
.mm-logo-pill:hover { border-color: var(--accent-b); color: var(--accent-b); }

/* ── Bottom CTA ── */
.mm-bottom-cta {
  background: linear-gradient(135deg, var(--accent-b) 0%, #1e4fd8 40%, #0f2f8f 100%);
  border-radius: var(--radius-lg);
  padding: 60px 56px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 40px;
  overflow: hidden;
  position: relative;
}
.mm-bottom-cta::before {
  content: '';
  position: absolute;
  width: 400px; height: 400px;
  border-radius: 50%;
  background: rgba(255,255,255,.04);
  top: -100px; right: -80px;
  pointer-events: none;
}
.mm-bottom-cta::after {
  content: '';
  position: absolute;
  width: 200px; height: 200px;
  border-radius: 50%;
  background: rgba(245,166,35,.12);
  bottom: -60px; left: 40px;
  pointer-events: none;
}
.mm-cta-text { position: relative; z-index: 2; }
.mm-cta-text h3 {
  font-family: 'Syne', sans-serif;
  font-size: clamp(22px, 3vw, 32px);
  font-weight: 800; color: white;
  line-height: 1.15; margin-bottom: 12px;
  letter-spacing: -.5px;
}
.mm-cta-text p { font-size: 15px; color: rgba(255,255,255,.65); max-width: 420px; }
.mm-cta-actions {
  display: flex; gap: 12px; align-items: center;
  position: relative; z-index: 2; flex-shrink: 0; flex-wrap: wrap;
}
.mm-cta-btn-white {
  display: inline-flex; align-items: center; gap: 10px;
  background: white; color: var(--accent-b);
  font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700;
  padding: 14px 28px; border-radius: 50px;
  text-decoration: none; transition: all .25s; border: none; cursor: pointer;
}
.mm-cta-btn-white:hover { background: var(--accent-o); color: white; }
.mm-cta-btn-ghost {
  display: inline-flex; align-items: center; gap: 10px;
  background: rgba(255,255,255,.1); color: white;
  border: 1.5px solid rgba(255,255,255,.25);
  font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700;
  padding: 14px 28px; border-radius: 50px;
  text-decoration: none; transition: all .25s; cursor: pointer;
}
.mm-cta-btn-ghost:hover { background: rgba(255,255,255,.2); }

/* ── Responsive ── */
@media (max-width: 1024px) {
  .mm-grid { grid-template-columns: repeat(2, 1fr); }
  .mail-card-wide { grid-column: span 2; }
  .mm-process { flex-direction: column; }
  .mm-step { border-right: none; border-bottom: 1px solid rgba(11,15,26,.07); }
  .mm-step:last-child { border-bottom: none; }
  .mm-step-arrow { display: none; }
}
@media (max-width: 720px) {
  .mm-grid { grid-template-columns: 1fr; }
  .mail-card-wide { grid-column: span 1; flex-direction: column; }
  .mc-wide-visual { width: 100%; height: 180px; }
  .mm-stats { flex-direction: column; }
  .mm-stat { border-right: none; border-bottom: 1px solid rgba(11,15,26,.07); }
  .mm-bottom-cta { flex-direction: column; padding: 40px 28px; }
  .mm-header { flex-direction: column; align-items: flex-start; }
}
</style>

<section class="mm-section">
  <div class="mm-inner">

    <!-- Header -->
    <div class="mm-header">
      <div class="mm-header-left">
        <div class="mm-eyebrow">
          <span class="mm-eyebrow-dot"></span>
          Email Marketing Platform
        </div>
        <h1 class="mm-title">
          Transformez chaque<br>email en <span>opportunité</span>
        </h1>
        <p class="mm-subtitle">
          Créez, automatisez et analysez vos campagnes d'emailing. Atteignez vos clients au bon moment avec le bon message — dans chaque secteur.
        </p>
      </div>
      <div class="mm-cta-group">
        <a href="#" class="mm-btn-primary">
          <i class="fas fa-rocket" style="font-size:13px;"></i>
          Démarrer gratuit
        </a>
        <a href="#" class="mm-btn-outline">
          <i class="fas fa-play-circle" style="font-size:13px;"></i>
          Voir la démo
        </a>
      </div>
    </div>

    <!-- Stats -->
    <div class="mm-stats">
      <div class="mm-stat">
        <div class="mm-stat-num">98<span>%</span></div>
        <div class="mm-stat-label">Taux de délivrabilité</div>
      </div>
      <div class="mm-stat">
        <div class="mm-stat-num">4.2<span>×</span></div>
        <div class="mm-stat-label">ROI moyen par campagne</div>
      </div>
      <div class="mm-stat">
        <div class="mm-stat-num">12<span>k+</span></div>
        <div class="mm-stat-label">Campagnes envoyées</div>
      </div>
      <div class="mm-stat">
        <div class="mm-stat-num">38<span>%</span></div>
        <div class="mm-stat-label">Taux d'ouverture moyen</div>
      </div>
    </div>

    <!-- Filter tabs -->
    <div class="mm-tabs">
      <button class="mm-tab active">Tous les secteurs</button>
      <button class="mm-tab">Retail & E-commerce</button>
      <button class="mm-tab">Immobilier</button>
      <button class="mm-tab">Tourisme & Voyages</button>
      <button class="mm-tab">Événementiel</button>
      <button class="mm-tab">B2B & Corporate</button>
    </div>

    <!-- Card grid -->
    <div class="mm-grid">

      <!-- Wide featured card — Automation -->
      <div class="mail-card-wide">
        <div class="mc-wide-body">
          <div>
            <div class="mc-wide-badge">
              <i class="fas fa-bolt" style="font-size:10px;"></i> AUTOMATION IA
            </div>
            <div class="mc-wide-title">Séquences email<br>100% automatisées</div>
            <p class="mc-wide-desc">Configurez une fois, convertissez indéfiniment. Notre moteur IA personnalise chaque envoi selon le comportement de vos contacts.</p>
          </div>
          <div style="display:flex;gap:24px;margin-bottom:28px;">
            <div>
              <div style="font-family:'Syne',sans-serif;font-size:22px;font-weight:800;color:white;line-height:1;">+47%</div>
              <div style="font-size:11px;color:rgba(255,255,255,.5);margin-top:3px;">Conversions</div>
            </div>
            <div style="width:1px;background:rgba(255,255,255,.1);"></div>
            <div>
              <div style="font-family:'Syne',sans-serif;font-size:22px;font-weight:800;color:white;line-height:1;">-60%</div>
              <div style="font-size:11px;color:rgba(255,255,255,.5);margin-top:3px;">Temps de travail</div>
            </div>
            <div style="width:1px;background:rgba(255,255,255,.1);"></div>
            <div>
              <div style="font-family:'Syne',sans-serif;font-size:22px;font-weight:800;color:#f5a623;line-height:1;">4.2×</div>
              <div style="font-size:11px;color:rgba(255,255,255,.5);margin-top:3px;">ROI moyen</div>
            </div>
          </div>
          <a href="#" class="mc-wide-link">
            Découvrir l'automation <i class="fas fa-arrow-right" style="font-size:12px;"></i>
          </a>
        </div>
        <div class="mc-wide-visual">
          <!-- Automation illustration -->
          <svg width="260" height="320" viewBox="0 0 260 320" fill="none" xmlns="http://www.w3.org/2000/svg" style="position:relative;z-index:1;">
            <!-- Email flow nodes -->
            <rect x="70" y="20" width="120" height="52" rx="12" fill="rgba(255,255,255,.12)" stroke="rgba(255,255,255,.25)" stroke-width="1"/>
            <circle cx="94" cy="46" r="10" fill="#f5a623" opacity=".9"/>
            <text x="110" y="42" fill="white" font-size="11" font-family="sans-serif" opacity=".9">Trigger</text>
            <text x="110" y="56" fill="rgba(255,255,255,.55)" font-size="10" font-family="sans-serif">Nouvel abonné</text>
            <!-- Arrow -->
            <line x1="130" y1="72" x2="130" y2="96" stroke="rgba(255,255,255,.25)" stroke-width="1.5" stroke-dasharray="4,3"/>
            <polygon points="130,100 125,92 135,92" fill="rgba(255,255,255,.35)"/>
            <!-- Email 1 -->
            <rect x="60" y="104" width="140" height="52" rx="12" fill="rgba(255,255,255,.10)" stroke="rgba(255,255,255,.2)" stroke-width="1"/>
            <rect x="76" y="118" width="24" height="18" rx="4" fill="#2d5cc2" opacity=".9"/>
            <text x="76" y="130" fill="white" font-size="9" font-family="sans-serif" text-anchor="middle" dx="12">E1</text>
            <text x="108" y="127" fill="white" font-size="11" font-family="sans-serif" opacity=".85">Email Bienvenue</text>
            <text x="108" y="141" fill="rgba(255,255,255,.45)" font-size="10" font-family="sans-serif">J+0 · Taux ouv. 61%</text>
            <!-- Arrow -->
            <line x1="130" y1="156" x2="130" y2="180" stroke="rgba(255,255,255,.25)" stroke-width="1.5" stroke-dasharray="4,3"/>
            <polygon points="130,184 125,176 135,176" fill="rgba(255,255,255,.35)"/>
            <!-- Email 2 -->
            <rect x="60" y="188" width="140" height="52" rx="12" fill="rgba(255,255,255,.10)" stroke="rgba(255,255,255,.2)" stroke-width="1"/>
            <rect x="76" y="202" width="24" height="18" rx="4" fill="#f5a623" opacity=".9"/>
            <text x="76" y="214" fill="white" font-size="9" font-family="sans-serif" text-anchor="middle" dx="12">E2</text>
            <text x="108" y="211" fill="white" font-size="11" font-family="sans-serif" opacity=".85">Offre exclusive</text>
            <text x="108" y="225" fill="rgba(255,255,255,.45)" font-size="10" font-family="sans-serif">J+3 · Taux clic 28%</text>
            <!-- Arrow -->
            <line x1="130" y1="240" x2="130" y2="264" stroke="rgba(255,255,255,.25)" stroke-width="1.5" stroke-dasharray="4,3"/>
            <polygon points="130,268 125,260 135,260" fill="rgba(255,255,255,.35)"/>
            <!-- Conversion -->
            <rect x="75" y="272" width="110" height="36" rx="18" fill="#f5a623"/>
            <text x="130" y="295" fill="white" font-size="12" font-family="sans-serif" font-weight="700" text-anchor="middle">Conversion</text>
          </svg>
        </div>
      </div>

      <!-- Card 1 - Produits & Infos -->
      <div class="mail-card-v2 theme-orange">
        <div class="mc-visual">
          <div class="mc-visual-inner">
            <svg width="220" height="180" viewBox="0 0 220 180" fill="none" xmlns="http://www.w3.org/2000/svg">
              <!-- Newsletter mockup -->
              <rect x="30" y="15" width="160" height="150" rx="10" fill="white" opacity=".8"/>
              <rect x="30" y="15" width="160" height="32" rx="10" fill="#f5a623" opacity=".9"/>
              <rect x="30" y="37" width="160" height="10" fill="#f5a623" opacity=".9"/>
              <text x="110" y="36" fill="white" font-size="11" font-weight="700" font-family="sans-serif" text-anchor="middle">NEWSLETTER</text>
              <rect x="44" y="60" width="70" height="45" rx="6" fill="#fff3e0"/>
              <text x="79" y="86" fill="#c77a00" font-size="18" font-family="sans-serif" text-anchor="middle">🏷️</text>
              <rect x="124" y="60" width="52" height="8" rx="4" fill="#f5a623" opacity=".5"/>
              <rect x="124" y="74" width="40" height="6" rx="3" fill="#e0e0e0"/>
              <rect x="124" y="86" width="46" height="6" rx="3" fill="#e0e0e0"/>
              <rect x="44" y="116" width="132" height="6" rx="3" fill="#e0e0e0" opacity=".6"/>
              <rect x="44" y="128" width="100" height="6" rx="3" fill="#e0e0e0" opacity=".4"/>
              <rect x="74" y="145" width="72" height="14" rx="7" fill="#f5a623"/>
              <text x="110" y="156" fill="white" font-size="9" font-family="sans-serif" text-anchor="middle">Découvrir</text>
            </svg>
          </div>
        </div>
        <div class="mc-body">
          <div class="mc-badge">
            <i class="fas fa-tags" style="font-size:9px;"></i> Informations
          </div>
          <div class="mc-title">Emails Produits & Newsletters</div>
          <p class="mc-desc">Promotions exclusives, nouveautés produits et newsletters informatives pour fidéliser et convertir votre audience.</p>
          <div class="mc-footer">
            <div class="mc-kpi">
              <span class="mc-kpi-dot"></span>
              Ouverture 42%
            </div>
            <a href="#" class="mc-link">Explorer <i class="fas fa-arrow-right" style="font-size:11px;"></i></a>
          </div>
        </div>
      </div>

      <!-- Card 2 - Immobilier -->
      <div class="mail-card-v2 theme-blue">
        <div class="mc-visual">
          <div class="mc-visual-inner">
            <svg width="220" height="180" viewBox="0 0 220 180" fill="none" xmlns="http://www.w3.org/2000/svg">
              <!-- Immobilier email mockup -->
              <rect x="25" y="10" width="170" height="155" rx="10" fill="white" opacity=".75"/>
              <rect x="25" y="10" width="170" height="28" rx="10" fill="#1a3a8f"/>
              <rect x="25" y="28" width="170" height="10" fill="#1a3a8f"/>
              <text x="110" y="28" fill="white" font-size="10" font-weight="700" font-family="sans-serif" text-anchor="middle">IMMO CONSEIL</text>
              <!-- Building icon -->
              <rect x="65" y="48" width="90" height="60" rx="5" fill="#e8eeff"/>
              <rect x="78" y="65" width="18" height="25" rx="2" fill="#2d5cc2" opacity=".7"/>
              <rect x="102" y="55" width="18" height="35" rx="2" fill="#1a3a8f" opacity=".8"/>
              <rect x="126" y="62" width="18" height="28" rx="2" fill="#2d5cc2" opacity=".7"/>
              <rect x="65" y="105" width="90" height="5" rx="2" fill="#2d5cc2" opacity=".3"/>
              <!-- Tags -->
              <rect x="35" y="122" width="60" height="16" rx="8" fill="#e8eeff"/>
              <text x="65" y="133" fill="#1a3a8f" font-size="9" font-family="sans-serif" text-anchor="middle" font-weight="600">Nouveau bien</text>
              <rect x="104" y="122" width="50" height="16" rx="8" fill="#e8eeff"/>
              <text x="129" y="133" fill="#1a3a8f" font-size="9" font-family="sans-serif" text-anchor="middle">350 000 €</text>
              <rect x="62" y="148" width="96" height="12" rx="6" fill="#1a3a8f"/>
              <text x="110" y="157" fill="white" font-size="9" font-family="sans-serif" text-anchor="middle">Voir l'annonce</text>
            </svg>
          </div>
        </div>
        <div class="mc-body">
          <div class="mc-badge">
            <i class="fas fa-building" style="font-size:9px;"></i> Immobilier
          </div>
          <div class="mc-title">Emails Immobiliers</div>
          <p class="mc-desc">Annonces exclusives, alertes prix, visites virtuelles et conseils pour investisseurs et acquéreurs.</p>
          <div class="mc-footer">
            <div class="mc-kpi">
              <span class="mc-kpi-dot"></span>
              Conversion 18%
            </div>
            <a href="#" class="mc-link">Explorer <i class="fas fa-arrow-right" style="font-size:11px;"></i></a>
          </div>
        </div>
      </div>

      <!-- Card 3 - Voyages -->
      <div class="mail-card-v2 theme-teal">
        <div class="mc-visual">
          <div class="mc-visual-inner">
            <svg width="220" height="180" viewBox="0 0 220 180" fill="none" xmlns="http://www.w3.org/2000/svg">
              <!-- Travel card mockup -->
              <rect x="30" y="12" width="160" height="155" rx="10" fill="white" opacity=".75"/>
              <!-- Sky gradient area -->
              <rect x="30" y="12" width="160" height="75" rx="10" fill="#00897b" opacity=".15"/>
              <rect x="30" y="77" width="160" height="10" fill="#00897b" opacity=".15"/>
              <!-- Plane icon -->
              <circle cx="110" cy="50" r="28" fill="#e0f7f4"/>
              <text x="110" y="58" font-size="26" text-anchor="middle" font-family="sans-serif">✈️</text>
              <!-- Destination -->
              <text x="110" y="108" fill="#00695c" font-size="13" font-weight="700" font-family="sans-serif" text-anchor="middle">Paris → Montréal</text>
              <rect x="75" y="116" width="70" height="14" rx="7" fill="#e0f7f4"/>
              <text x="110" y="126" fill="#00838f" font-size="9" font-family="sans-serif" text-anchor="middle" font-weight="600">Last minute · -42%</text>
              <rect x="50" y="140" width="52" height="10" rx="5" fill="#e0e0e0" opacity=".5"/>
              <rect x="112" y="140" width="52" height="10" rx="5" fill="#e0e0e0" opacity=".5"/>
              <rect x="65" y="158" width="90" height="12" rx="6" fill="#00897b"/>
              <text x="110" y="167" fill="white" font-size="9" font-family="sans-serif" text-anchor="middle">Réserver maintenant</text>
            </svg>
          </div>
        </div>
        <div class="mc-body">
          <div class="mc-badge">
            <i class="fas fa-plane-departure" style="font-size:9px;"></i> Voyages
          </div>
          <div class="mc-title">Emails Voyages & Tourisme</div>
          <p class="mc-desc">Offres last minute, itinéraires personnalisés, bons plans destinations et inspirations saisonnières.</p>
          <div class="mc-footer">
            <div class="mc-kpi">
              <span class="mc-kpi-dot"></span>
              Engagement 35%
            </div>
            <a href="#" class="mc-link">Explorer <i class="fas fa-arrow-right" style="font-size:11px;"></i></a>
          </div>
        </div>
      </div>

      <!-- Card 4 - Événementiel -->
      <div class="mail-card-v2 theme-rose">
        <div class="mc-visual">
          <div class="mc-visual-inner">
            <svg width="220" height="180" viewBox="0 0 220 180" fill="none" xmlns="http://www.w3.org/2000/svg">
              <!-- Invitation card mockup -->
              <rect x="35" y="15" width="150" height="150" rx="12" fill="white" opacity=".8"/>
              <rect x="35" y="15" width="150" height="48" rx="12" fill="#fce4ec"/>
              <rect x="35" y="53" width="150" height="10" fill="#fce4ec"/>
              <text x="110" y="36" fill="#c2185b" font-size="10" font-weight="700" font-family="sans-serif" text-anchor="middle" letter-spacing="1">INVITATION</text>
              <text x="110" y="52" fill="#c2185b" font-size="9" font-family="sans-serif" text-anchor="middle">Événement Exclusif</text>
              <!-- Calendar icon -->
              <rect x="80" y="72" width="60" height="52" rx="8" fill="#fce4ec" opacity=".6"/>
              <rect x="80" y="72" width="60" height="16" rx="8" fill="#e91e63" opacity=".8"/>
              <text x="110" y="84" fill="white" font-size="9" font-family="sans-serif" text-anchor="middle" font-weight="700">JUIN 2025</text>
              <text x="110" y="112" fill="#c2185b" font-size="22" font-weight="800" font-family="sans-serif" text-anchor="middle">28</text>
              <rect x="50" y="136" width="120" height="6" rx="3" fill="#e0e0e0" opacity=".6"/>
              <rect x="65" y="148" width="90" height="14" rx="7" fill="#e91e63"/>
              <text x="110" y="158" fill="white" font-size="9" font-family="sans-serif" text-anchor="middle">Confirmer ma présence</text>
            </svg>
          </div>
        </div>
        <div class="mc-body">
          <div class="mc-badge">
            <i class="fas fa-calendar-alt" style="font-size:9px;"></i> Événementiel
          </div>
          <div class="mc-title">Emails Événementiels</div>
          <p class="mc-desc">Invitations, rappels, billetterie et feedback post-événement pour maximiser votre impact et votre taux de participation.</p>
          <div class="mc-footer">
            <div class="mc-kpi">
              <span class="mc-kpi-dot"></span>
              Participation 28%
            </div>
            <a href="#" class="mc-link">Explorer <i class="fas fa-arrow-right" style="font-size:11px;"></i></a>
          </div>
        </div>
      </div>

      <!-- Card 5 - E-commerce -->
      <div class="mail-card-v2 theme-green">
        <div class="mc-visual">
          <div class="mc-visual-inner">
            <svg width="220" height="180" viewBox="0 0 220 180" fill="none" xmlns="http://www.w3.org/2000/svg">
              <!-- Cart recovery mockup -->
              <rect x="28" y="12" width="164" height="155" rx="10" fill="white" opacity=".75"/>
              <!-- Header -->
              <rect x="28" y="12" width="164" height="30" rx="10" fill="#43a047" opacity=".15"/>
              <rect x="28" y="32" width="164" height="10" fill="#43a047" opacity=".15"/>
              <text x="110" y="30" fill="#2e7d32" font-size="10" font-weight="700" font-family="sans-serif" text-anchor="middle">PANIER ABANDONNÉ</text>
              <!-- Product items -->
              <rect x="38" y="52" width="55" height="48" rx="8" fill="#e8f5e9"/>
              <text x="65" y="80" font-size="22" text-anchor="middle" font-family="sans-serif">👟</text>
              <rect x="102" y="56" width="80" height="8" rx="4" fill="#2e7d32" opacity=".6"/>
              <rect x="102" y="70" width="56" height="6" rx="3" fill="#e0e0e0"/>
              <text x="102" y="94" fill="#43a047" font-size="14" font-weight="700" font-family="sans-serif">89,00 €</text>
              <rect x="28" y="110" width="164" height="1" fill="#e0e0e0"/>
              <!-- Timer badge -->
              <rect x="54" y="120" width="112" height="18" rx="9" fill="#fff8e1" stroke="#f9a825" stroke-width="1"/>
              <text x="110" y="132" fill="#f57f17" font-size="10" font-family="sans-serif" text-anchor="middle" font-weight="600">⏱ Expire dans 2h 34min</text>
              <!-- CTA -->
              <rect x="48" y="146" width="124" height="14" rx="7" fill="#43a047"/>
              <text x="110" y="156" fill="white" font-size="9" font-family="sans-serif" text-anchor="middle">Finaliser mon achat</text>
            </svg>
          </div>
        </div>
        <div class="mc-body">
          <div class="mc-badge">
            <i class="fas fa-shopping-cart" style="font-size:9px;"></i> E-commerce
          </div>
          <div class="mc-title">Emails E-commerce & Retail</div>
          <p class="mc-desc">Abandons panier, ventes flash, recommandations produits intelligentes et programmes de fidélité automatisés.</p>
          <div class="mc-footer">
            <div class="mc-kpi">
              <span class="mc-kpi-dot"></span>
              Récupération 23%
            </div>
            <a href="#" class="mc-link">Explorer <i class="fas fa-arrow-right" style="font-size:11px;"></i></a>
          </div>
        </div>
      </div>

      <!-- Card 6 - B2B -->
      <div class="mail-card-v2 theme-purple">
        <div class="mc-visual">
          <div class="mc-visual-inner">
            <svg width="220" height="180" viewBox="0 0 220 180" fill="none" xmlns="http://www.w3.org/2000/svg">
              <!-- B2B email mockup -->
              <rect x="25" y="10" width="170" height="158" rx="10" fill="white" opacity=".75"/>
              <!-- Top bar -->
              <rect x="25" y="10" width="170" height="32" rx="10" fill="#4527a0" opacity=".85"/>
              <rect x="25" y="32" width="170" height="10" fill="#4527a0" opacity=".85"/>
              <text x="110" y="29" fill="white" font-size="10" font-weight="700" font-family="sans-serif" text-anchor="middle">RAPPORT TRIMESTRIEL</text>
              <!-- Graph bars -->
              <rect x="42" y="90" width="18" height="50" rx="4" fill="#7e57c2" opacity=".4"/>
              <rect x="68" y="74" width="18" height="66" rx="4" fill="#7e57c2" opacity=".6"/>
              <rect x="94" y="56" width="18" height="84" rx="4" fill="#7e57c2" opacity=".8"/>
              <rect x="120" y="44" width="18" height="96" rx="4" fill="#4527a0"/>
              <rect x="146" y="60" width="18" height="80" rx="4" fill="#7e57c2" opacity=".7"/>
              <!-- Baseline -->
              <rect x="38" y="140" width="140" height="1.5" rx="1" fill="#7e57c2" opacity=".25"/>
              <!-- KPI badges -->
              <rect x="35" y="150" width="44" height="12" rx="6" fill="#ede7f6"/>
              <text x="57" y="159" fill="#4527a0" font-size="8" font-family="sans-serif" text-anchor="middle" font-weight="600">+31% ROI</text>
              <rect x="86" y="150" width="50" height="12" rx="6" fill="#ede7f6"/>
              <text x="111" y="159" fill="#4527a0" font-size="8" font-family="sans-serif" text-anchor="middle" font-weight="600">128 leads</text>
              <rect x="144" y="150" width="48" height="12" rx="6" fill="#ede7f6"/>
              <text x="168" y="159" fill="#4527a0" font-size="8" font-family="sans-serif" text-anchor="middle" font-weight="600">Q4 2024</text>
            </svg>
          </div>
        </div>
        <div class="mc-body">
          <div class="mc-badge">
            <i class="fas fa-briefcase" style="font-size:9px;"></i> B2B & Pro
          </div>
          <div class="mc-title">Emails B2B & Professionnels</div>
          <p class="mc-desc">Newsletters corporate, études de cas, rapports analytiques et contenus premium pour décideurs et équipes.</p>
          <div class="mc-footer">
            <div class="mc-kpi">
              <span class="mc-kpi-dot"></span>
              Clic B2B 31%
            </div>
            <a href="#" class="mc-link">Explorer <i class="fas fa-arrow-right" style="font-size:11px;"></i></a>
          </div>
        </div>
      </div>

    </div><!-- /grid -->

    <!-- Process steps -->
    <div class="mm-process">
      <div class="mm-step">
        <div class="mm-step-num">Étape 01</div>
        <div class="mm-step-icon" style="background:#fff3e0;">
          <span style="font-size:20px;">🎯</span>
        </div>
        <div class="mm-step-title">Définissez votre audience</div>
        <p class="mm-step-desc">Segmentez vos contacts selon leur comportement, secteur et historique d'engagement.</p>
        <div class="mm-step-arrow">›</div>
      </div>
      <div class="mm-step">
        <div class="mm-step-num">Étape 02</div>
        <div class="mm-step-icon" style="background:#e8eeff;">
          <span style="font-size:20px;">✏️</span>
        </div>
        <div class="mm-step-title">Créez votre campagne</div>
        <p class="mm-step-desc">Utilisez nos templates professionnels ou créez votre design sur mesure en glisser-déposer.</p>
        <div class="mm-step-arrow">›</div>
      </div>
      <div class="mm-step">
        <div class="mm-step-num">Étape 03</div>
        <div class="mm-step-icon" style="background:#e0f7f4;">
          <span style="font-size:20px;">🤖</span>
        </div>
        <div class="mm-step-title">Automatisez l'envoi</div>
        <p class="mm-step-desc">Planifiez ou déclenchez selon les actions de vos contacts. L'IA optimise le timing.</p>
        <div class="mm-step-arrow">›</div>
      </div>
      <div class="mm-step">
        <div class="mm-step-num">Étape 04</div>
        <div class="mm-step-icon" style="background:#e8f5e9;">
          <span style="font-size:20px;">📊</span>
        </div>
        <div class="mm-step-title">Analysez & optimisez</div>
        <p class="mm-step-desc">Tableaux de bord temps réel, A/B testing automatique et recommandations intelligentes.</p>
      </div>
    </div>

    <!-- Clients marquee -->
    <div class="mm-marquee-wrap">
      <p class="mm-marquee-label">Ils optimisent leurs campagnes avec Go Exploria</p>
      <div class="mm-marquee-track" id="marqueeTrack">
        <div class="mm-logo-pill"><i class="fas fa-store"></i> Retail Plus</div>
        <div class="mm-logo-pill"><i class="fas fa-home"></i> Immo Conseil</div>
        <div class="mm-logo-pill"><i class="fas fa-globe"></i> World Travel</div>
        <div class="mm-logo-pill"><i class="fas fa-champagne-glasses"></i> Event Factory</div>
        <div class="mm-logo-pill"><i class="fas fa-box"></i> Shop Express</div>
        <div class="mm-logo-pill"><i class="fas fa-handshake"></i> B2B Connect</div>
        <div class="mm-logo-pill"><i class="fas fa-plane"></i> Air Voyages</div>
        <div class="mm-logo-pill"><i class="fas fa-hotel"></i> Séjours Pro</div>
        <div class="mm-logo-pill"><i class="fas fa-chart-line"></i> GrowthLabs</div>
        <div class="mm-logo-pill"><i class="fas fa-building"></i> Bâti Invest</div>
        <!-- Duplicate for seamless loop -->
        <div class="mm-logo-pill"><i class="fas fa-store"></i> Retail Plus</div>
        <div class="mm-logo-pill"><i class="fas fa-home"></i> Immo Conseil</div>
        <div class="mm-logo-pill"><i class="fas fa-globe"></i> World Travel</div>
        <div class="mm-logo-pill"><i class="fas fa-champagne-glasses"></i> Event Factory</div>
        <div class="mm-logo-pill"><i class="fas fa-box"></i> Shop Express</div>
        <div class="mm-logo-pill"><i class="fas fa-handshake"></i> B2B Connect</div>
        <div class="mm-logo-pill"><i class="fas fa-plane"></i> Air Voyages</div>
        <div class="mm-logo-pill"><i class="fas fa-hotel"></i> Séjours Pro</div>
        <div class="mm-logo-pill"><i class="fas fa-chart-line"></i> GrowthLabs</div>
        <div class="mm-logo-pill"><i class="fas fa-building"></i> Bâti Invest</div>
      </div>
    </div>

    <!-- Bottom CTA -->
    <div class="mm-bottom-cta">
      <div class="mm-cta-text">
        <h3>Prêt à booster vos campagnes email ?</h3>
        <p>Rejoignez plus de 1 200 entreprises qui utilisent Go Exploria pour transformer leur communication email en moteur de croissance.</p>
      </div>
      <div class="mm-cta-actions">
        <a href="#" class="mm-cta-btn-white">
          <i class="fas fa-rocket" style="font-size:13px;"></i>
          Démarrer gratuitement
        </a>
        <a href="#" class="mm-cta-btn-ghost">
          <i class="fas fa-phone" style="font-size:13px;"></i>
          Parler à un expert
        </a>
      </div>
    </div>

  </div>
</section>

<script>
// Tab filter interaction
document.querySelectorAll('.mm-tab').forEach(tab => {
  tab.addEventListener('click', () => {
    document.querySelectorAll('.mm-tab').forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
  });
});

// Card hover ripple subtle lift
document.querySelectorAll('.mail-card-v2, .mail-card-wide').forEach(card => {
  card.addEventListener('mouseenter', () => card.style.willChange = 'transform');
  card.addEventListener('mouseleave', () => card.style.willChange = 'auto');
});

// Staggered entrance animation
const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.style.opacity = '1';
      e.target.style.transform = 'translateY(0)';
      observer.unobserve(e.target);
    }
  });
}, { threshold: 0.1 });

document.querySelectorAll('.mail-card-v2, .mail-card-wide, .mm-stat, .mm-step').forEach((el, i) => {
  el.style.opacity = '0';
  el.style.transform = 'translateY(28px)';
  el.style.transition = `opacity .5s ease ${i * 0.07}s, transform .5s ease ${i * 0.07}s`;
  observer.observe(el);
});
</script>
</html>