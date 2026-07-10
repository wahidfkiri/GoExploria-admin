@extends('welcome-home.layouts.app')

@section('title', 'Médias & Plateformes Vidéo — GoExploria Business')
@section('meta_description', 'GoExploria Business crée et gère vos chaînes sur toutes les plateformes vidéo : YouTube, Vimeo, Twitch, Rumble, PeerTube et plus. Diffusion mondiale, qualité professionnelle.')

@section('breadcrumb')
<span class="current">Plateformes Médias</span>
@endsection

@section('page-styles')

/* =========================================================
   MEDIA PLAYERS PAGE — Broadcast Studio Dark Premium
   ========================================================= */

/* ── Root & Page Background ── */
#media-page {
  background: #080c14;
  color: #fff;
}

/* ── HERO ── */
.mp-hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  padding: 120px 40px 80px;
  background: #080c14;
}

/* Animated mesh background */
.mp-hero-bg {
  position: absolute;
  inset: 0;
  overflow: hidden;
  pointer-events: none;
}
.mp-hero-bg::before {
  content: '';
  position: absolute;
  top: -20%;
  left: -10%;
  width: 70%;
  height: 70%;
  background: radial-gradient(ellipse, rgba(232,118,26,0.12) 0%, transparent 65%);
  animation: blobDrift 12s ease-in-out infinite alternate;
}
.mp-hero-bg::after {
  content: '';
  position: absolute;
  bottom: -15%;
  right: -5%;
  width: 55%;
  height: 55%;
  background: radial-gradient(ellipse, rgba(37,244,238,0.06) 0%, transparent 65%);
  animation: blobDrift 16s ease-in-out infinite alternate-reverse;
}
@keyframes blobDrift {
  from { transform: translate(0, 0) scale(1); }
  to   { transform: translate(4%, 6%) scale(1.08); }
}

/* Grid overlay texture */
.mp-hero-grid-tex {
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.018) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.018) 1px, transparent 1px);
  background-size: 60px 60px;
}

.mp-hero-inner {
  position: relative;
  max-width: 1300px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 100px;
  align-items: center;
}

.mp-hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: rgba(232,118,26,0.12);
  border: 1px solid rgba(232,118,26,0.35);
  border-radius: 999px;
  padding: 8px 18px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: #e8761a;
  margin-bottom: 28px;
}
.mp-hero-badge-dot {
  width: 7px;
  height: 7px;
  background: #e8761a;
  border-radius: 50%;
  animation: pulse 2s infinite;
}
@keyframes pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50%       { opacity: 0.5; transform: scale(1.4); }
}

.mp-hero-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(40px, 4.5vw, 68px);
  font-weight: 900;
  line-height: 1.05;
  margin-bottom: 24px;
  color: #fff;
}
.mp-hero-title em {
  font-style: italic;
  background: linear-gradient(135deg, #e8761a, #ffb366);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.mp-hero-desc {
  font-size: 17px;
  color: rgba(255,255,255,0.6);
  line-height: 1.85;
  max-width: 520px;
  margin-bottom: 40px;
}

.mp-hero-actions {
  display: flex;
  gap: 14px;
  flex-wrap: wrap;
  margin-bottom: 56px;
}

.mp-hero-stats-row {
  display: flex;
  gap: 40px;
}
.mp-hero-stat strong {
  display: block;
  font-family: 'Bebas Neue', sans-serif;
  font-size: 44px;
  color: #e8761a;
  line-height: 1;
}
.mp-hero-stat span {
  font-size: 11px;
  color: rgba(255,255,255,0.45);
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-top: 4px;
  display: block;
}

/* Hero right — floating platform mosaic */
.mp-hero-visual {
  position: relative;
  height: 520px;
}

.mp-platform-mosaic {
  position: absolute;
  inset: 0;
}

.mp-mosaic-card {
  position: absolute;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.09);
  border-radius: 16px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 8px;
  font-size: 11px;
  font-weight: 700;
  color: rgba(255,255,255,0.75);
  text-transform: uppercase;
  letter-spacing: 0.8px;
  cursor: default;
  transition: all 0.35s;
  backdrop-filter: blur(8px);
}
.mp-mosaic-card:hover {
  background: rgba(232,118,26,0.12);
  border-color: rgba(232,118,26,0.4);
  color: #e8761a;
  transform: scale(1.06);
  z-index: 5;
  box-shadow: 0 16px 48px rgba(232,118,26,0.18);
}

.mp-mosaic-card .platform-icon {
  font-size: 28px;
  line-height: 1;
}
.mp-mosaic-card .platform-icon.youtube-color  { color: #ff0000; }
.mp-mosaic-card .platform-icon.vimeo-color    { color: #1ab7ea; }
.mp-mosaic-card .platform-icon.twitch-color   { color: #9146ff; }
.mp-mosaic-card .platform-icon.dm-color       { color: #0066dc; }
.mp-mosaic-card .platform-icon.flickr-color   { color: #ff0084; }
.mp-mosaic-card .platform-icon.rumble-color   { color: #85c742; }
.mp-mosaic-card .platform-icon.peertube-color { color: #f1680d; }
.mp-mosaic-card .platform-icon.twitch2-color  { color: #9146ff; }
.mp-mosaic-card .platform-icon.odysee-color   { color: #ef1970; }
.mp-mosaic-card .platform-icon.bitchute-color { color: #f60; }
.mp-mosaic-card .platform-icon.veoh-color     { color: #57b7e6; }
.mp-mosaic-card .platform-icon.dtube-color    { color: #cc0202; }

/* Mosaic positioning */
.mp-mc-1  { width:120px;height:110px; top:0;    left:80px;  animation: floatA 5s ease-in-out infinite; }
.mp-mc-2  { width:130px;height:115px; top:10px; left:230px; animation: floatB 6s ease-in-out infinite; }
.mp-mc-3  { width:110px;height:105px; top:5px;  left:385px; animation: floatA 7s ease-in-out infinite; }
.mp-mc-4  { width:125px;height:112px; top:140px;left:0;     animation: floatC 5.5s ease-in-out infinite; }
.mp-mc-5  { width:115px;height:110px; top:130px;left:150px; animation: floatB 6.5s ease-in-out infinite; }
.mp-mc-6  { width:130px;height:118px; top:135px;left:295px; animation: floatA 5.8s ease-in-out infinite; }
.mp-mc-7  { width:120px;height:110px; top:125px;left:445px; animation: floatC 7.2s ease-in-out infinite; }
.mp-mc-8  { width:110px;height:108px; top:268px;left:60px;  animation: floatB 5.3s ease-in-out infinite; }
.mp-mc-9  { width:128px;height:115px; top:270px;left:200px; animation: floatA 6.8s ease-in-out infinite; }
.mp-mc-10 { width:118px;height:110px; top:265px;left:355px; animation: floatC 5.1s ease-in-out infinite; }
.mp-mc-11 { width:110px;height:105px; top:400px;left:100px; animation: floatB 7.5s ease-in-out infinite; }
.mp-mc-12 { width:125px;height:112px; top:395px;left:270px; animation: floatA 6.2s ease-in-out infinite; }
.mp-mc-13 { width:115px;height:108px; top:398px;left:415px; animation: floatC 5.9s ease-in-out infinite; }

@keyframes floatA { 0%,100%{transform:translateY(0px)}   50%{transform:translateY(-10px)} }
@keyframes floatB { 0%,100%{transform:translateY(-6px)}  50%{transform:translateY(8px)}   }
@keyframes floatC { 0%,100%{transform:translateY(5px)}   50%{transform:translateY(-12px)} }

/* ── INTRO SECTION ── */
.mp-intro {
  background: #0d1220;
  padding: 100px 40px;
  position: relative;
  overflow: hidden;
}
.mp-intro::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(232,118,26,0.5), transparent);
}
.mp-intro-inner {
  max-width: 1300px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
  align-items: center;
}
.mp-intro-label {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: #e8761a;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.mp-intro-label::before {
  content: '';
  width: 32px;
  height: 2px;
  background: #e8761a;
}
.mp-intro-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(30px, 3vw, 48px);
  color: #fff;
  line-height: 1.15;
  margin-bottom: 24px;
}
.mp-intro-title em {
  font-style: italic;
  color: #e8761a;
}
.mp-intro-desc {
  font-size: 16px;
  color: rgba(255,255,255,0.6);
  line-height: 1.9;
  margin-bottom: 20px;
}
.mp-feature-pills {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-top: 32px;
}
.mp-feature-pill {
  display: flex;
  align-items: center;
  gap: 7px;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 999px;
  padding: 8px 16px;
  font-size: 12px;
  font-weight: 600;
  color: rgba(255,255,255,0.75);
}
.mp-feature-pill i {
  color: #e8761a;
  font-size: 11px;
}
.mp-intro-right {
  background: rgba(255,255,255,0.03);
  border: 1px solid rgba(255,255,255,0.07);
  border-radius: 24px;
  padding: 40px;
}
.mp-process-steps {
  display: flex;
  flex-direction: column;
  gap: 0;
}
.mp-step {
  display: flex;
  gap: 20px;
  padding: 24px 0;
  border-bottom: 1px solid rgba(255,255,255,0.06);
  position: relative;
}
.mp-step:last-child { border-bottom: none; }
.mp-step-num {
  width: 40px;
  height: 40px;
  min-width: 40px;
  border-radius: 12px;
  background: rgba(232,118,26,0.15);
  border: 1px solid rgba(232,118,26,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Bebas Neue', sans-serif;
  font-size: 20px;
  color: #e8761a;
}
.mp-step-content h4 {
  font-size: 15px;
  font-weight: 700;
  color: #fff;
  margin-bottom: 6px;
}
.mp-step-content p {
  font-size: 13px;
  color: rgba(255,255,255,0.5);
  line-height: 1.7;
}

/* ── PLATFORMS GRID ── */
.mp-platforms-section {
  background: #080c14;
  padding: 100px 40px;
  position: relative;
}
.mp-platforms-inner {
  max-width: 1400px;
  margin: 0 auto;
}
.mp-section-head {
  text-align: center;
  margin-bottom: 64px;
}
.mp-section-label {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: #e8761a;
  margin-bottom: 16px;
}
.mp-section-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(32px, 3.5vw, 52px);
  color: #fff;
  line-height: 1.1;
  margin-bottom: 16px;
}
.mp-section-desc {
  font-size: 16px;
  color: rgba(255,255,255,0.5);
  max-width: 600px;
  margin: 0 auto;
  line-height: 1.8;
}

.mp-platforms-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}

.mp-platform-card {
  background: rgba(255,255,255,0.03);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 20px;
  padding: 32px 28px;
  display: flex;
  flex-direction: column;
  gap: 0;
  cursor: pointer;
  transition: all 0.35s cubic-bezier(0.23, 1, 0.32, 1);
  position: relative;
  overflow: hidden;
  text-decoration: none;
}
.mp-platform-card::before {
  content: '';
  position: absolute;
  inset: 0;
  opacity: 0;
  transition: opacity 0.35s;
  border-radius: 20px;
}
.mp-platform-card:hover {
  transform: translateY(-6px);
  border-color: transparent;
  box-shadow: 0 24px 60px rgba(0,0,0,0.5);
}
.mp-platform-card:hover::before { opacity: 1; }

/* Per-platform accent colors */
.mp-pc-youtube   { --accent: #ff0000; }
.mp-pc-vimeo     { --accent: #1ab7ea; }
.mp-pc-daily     { --accent: #0066dc; }
.mp-pc-flickr    { --accent: #ff0084; }
.mp-pc-utreon    { --accent: #7c4dff; }
.mp-pc-rumble    { --accent: #85c742; }
.mp-pc-dtube     { --accent: #cc0202; }
.mp-pc-peertube  { --accent: #f1680d; }
.mp-pc-veoh      { --accent: #57b7e6; }
.mp-pc-twitch    { --accent: #9146ff; }
.mp-pc-crackle   { --accent: #e62429; }
.mp-pc-odysee    { --accent: #ef1970; }
.mp-pc-bitchute  { --accent: #ff6600; }

.mp-platform-card::before {
  background: linear-gradient(135deg, rgba(var(--accent-rgb), 0.1), rgba(var(--accent-rgb), 0.03));
}
.mp-platform-card:hover {
  border-color: color-mix(in srgb, var(--accent) 40%, transparent);
  box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 0 1px color-mix(in srgb, var(--accent) 30%, transparent);
}

.mp-card-top {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 20px;
}
.mp-card-icon-wrap {
  width: 56px;
  height: 56px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 26px;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.08);
  transition: all 0.35s;
  color: var(--accent);
}
.mp-platform-card:hover .mp-card-icon-wrap {
  background: color-mix(in srgb, var(--accent) 15%, transparent);
  border-color: color-mix(in srgb, var(--accent) 35%, transparent);
  box-shadow: 0 0 20px color-mix(in srgb, var(--accent) 25%, transparent);
}
.mp-card-arrow {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: rgba(255,255,255,0.04);
  display: flex;
  align-items: center;
  justify-content: center;
  color: rgba(255,255,255,0.3);
  font-size: 13px;
  transition: all 0.3s;
}
.mp-platform-card:hover .mp-card-arrow {
  background: var(--accent);
  color: #fff;
  transform: rotate(-45deg);
}

.mp-card-platform-name {
  font-size: 18px;
  font-weight: 800;
  color: #fff;
  margin-bottom: 6px;
  font-family: 'Space Grotesk', sans-serif;
  letter-spacing: -0.3px;
}
.mp-card-tagline {
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.8px;
  color: var(--accent);
  margin-bottom: 14px;
}
.mp-card-desc {
  font-size: 13px;
  color: rgba(255,255,255,0.5);
  line-height: 1.7;
  flex: 1;
  margin-bottom: 20px;
}
.mp-card-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
}
.mp-card-tag {
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  padding: 4px 10px;
  border-radius: 999px;
  background: rgba(255,255,255,0.05);
  color: rgba(255,255,255,0.45);
  border: 1px solid rgba(255,255,255,0.08);
}

/* ── SERVICES OFFERED ── */
.mp-services-section {
  background: linear-gradient(180deg, #0d1220 0%, #0f1728 100%);
  padding: 100px 40px;
  position: relative;
  overflow: hidden;
}
.mp-services-section::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(232,118,26,0.4), transparent);
}

.mp-services-inner {
  max-width: 1300px;
  margin: 0 auto;
}

.mp-services-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-top: 56px;
}

.mp-service-card {
  background: rgba(255,255,255,0.03);
  border: 1px solid rgba(255,255,255,0.07);
  border-radius: 20px;
  padding: 36px 32px;
  transition: all 0.3s;
  position: relative;
  overflow: hidden;
}
.mp-service-card::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, #e8761a, #ffb366);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.3s;
}
.mp-service-card:hover {
  border-color: rgba(232,118,26,0.2);
  background: rgba(232,118,26,0.04);
  transform: translateY(-4px);
}
.mp-service-card:hover::after {
  transform: scaleX(1);
}

.mp-service-icon {
  width: 52px;
  height: 52px;
  border-radius: 14px;
  background: rgba(232,118,26,0.12);
  border: 1px solid rgba(232,118,26,0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  color: #e8761a;
  margin-bottom: 20px;
}
.mp-service-title {
  font-size: 18px;
  font-weight: 700;
  color: #fff;
  margin-bottom: 12px;
  font-family: 'Space Grotesk', sans-serif;
}
.mp-service-desc {
  font-size: 14px;
  color: rgba(255,255,255,0.55);
  line-height: 1.8;
}

/* ── COMPARISON TABLE ── */
.mp-table-section {
  background: #080c14;
  padding: 100px 40px;
}
.mp-table-inner {
  max-width: 1300px;
  margin: 0 auto;
}
.mp-comparison-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  margin-top: 56px;
  border: 1px solid rgba(255,255,255,0.07);
  border-radius: 20px;
  overflow: hidden;
}
.mp-comparison-table thead th {
  background: rgba(232,118,26,0.1);
  padding: 18px 20px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: rgba(255,255,255,0.6);
  text-align: left;
  border-bottom: 1px solid rgba(255,255,255,0.08);
}
.mp-comparison-table thead th:first-child {
  color: #e8761a;
}
.mp-comparison-table tbody tr {
  transition: background 0.2s;
}
.mp-comparison-table tbody tr:hover {
  background: rgba(255,255,255,0.025);
}
.mp-comparison-table tbody td {
  padding: 16px 20px;
  font-size: 14px;
  color: rgba(255,255,255,0.65);
  border-bottom: 1px solid rgba(255,255,255,0.05);
}
.mp-comparison-table tbody tr:last-child td {
  border-bottom: none;
}
.mp-comparison-table tbody td:first-child {
  font-weight: 700;
  color: #fff;
  display: flex;
  align-items: center;
  gap: 12px;
}
.mp-table-icon {
  font-size: 16px;
}
.mp-check { color: #4ade80; }
.mp-partial { color: #facc15; }
.mp-cross { color: rgba(255,255,255,0.2); }

/* ── CTA FINALE ── */
.mp-cta-section {
  background: #0d1220;
  padding: 120px 40px;
  position: relative;
  overflow: hidden;
}
.mp-cta-section::before {
  content: '';
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  width: 700px;
  height: 400px;
  background: radial-gradient(ellipse, rgba(232,118,26,0.1), transparent 65%);
  pointer-events: none;
}
.mp-cta-inner {
  max-width: 800px;
  margin: 0 auto;
  text-align: center;
  position: relative;
}
.mp-cta-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(36px, 4vw, 60px);
  color: #fff;
  line-height: 1.1;
  margin-bottom: 20px;
}
.mp-cta-title em {
  font-style: italic;
  color: #e8761a;
}
.mp-cta-desc {
  font-size: 17px;
  color: rgba(255,255,255,0.55);
  line-height: 1.85;
  margin-bottom: 44px;
}
.mp-cta-buttons {
  display: flex;
  justify-content: center;
  gap: 16px;
  flex-wrap: wrap;
}

/* RESPONSIVE */
@media(max-width: 1100px) {
  .mp-hero-inner   { grid-template-columns: 1fr; gap: 60px; }
  .mp-intro-inner  { grid-template-columns: 1fr; gap: 48px; }
  .mp-platforms-grid { grid-template-columns: repeat(3, 1fr); }
  .mp-services-grid  { grid-template-columns: repeat(2, 1fr); }
  .mp-hero-visual  { height: 380px; }
}
@media(max-width: 768px) {
  .mp-hero, .mp-intro, .mp-platforms-section,
  .mp-services-section, .mp-table-section, .mp-cta-section {
    padding-left: 20px;
    padding-right: 20px;
  }
  .mp-platforms-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
  .mp-services-grid  { grid-template-columns: 1fr; }
  .mp-hero-stats-row { gap: 24px; }
  .mp-hero-visual    { display: none; }
  .mp-hero-inner     { grid-template-columns: 1fr; }
  .mp-comparison-table { font-size: 12px; }
  .mp-comparison-table thead th,
  .mp-comparison-table tbody td { padding: 12px 10px; }
}

@endsection

@section('content')
<div id="media-page">

  <!-- ═══════════════════════════════════════
       HERO
  ═══════════════════════════════════════ -->
  <section class="mp-hero">
    <div class="mp-hero-bg">
      <div class="mp-hero-grid-tex"></div>
    </div>
    <div class="mp-hero-inner">
      <!-- Left copy -->
      <div>
        <div class="mp-hero-badge">
          <span class="mp-hero-badge-dot"></span>
          Diffusion Mondiale
        </div>
        <h1 class="mp-hero-title">
          Vos chaînes,<br>
          partout dans<br>
          le <em>monde vidéo</em>
        </h1>
        <p class="mp-hero-desc">
          GoExploria Business crée, configure et gère vos chaînes sur les 13 plus grandes plateformes de diffusion vidéo et médias au monde. Une stratégie unifiée, une présence globale, zéro effort de votre côté.
        </p>
        <div class="mp-hero-actions">
          <a href="#" class="btn-orange"><i class="fas fa-rocket"></i> Lancer ma chaîne</a>
          <a href="#platforms" class="btn-outline-white"><i class="fas fa-play-circle"></i> Voir les plateformes</a>
        </div>
        <div class="mp-hero-stats-row">
          <div class="mp-hero-stat">
            <strong>13</strong>
            <span>Plateformes</span>
          </div>
          <div class="mp-hero-stat">
            <strong>40+</strong>
            <span>Pays couverts</span>
          </div>
          <div class="mp-hero-stat">
            <strong>100%</strong>
            <span>Prise en charge</span>
          </div>
          <div class="mp-hero-stat">
            <strong>HD</strong>
            <span>Qualité maximale</span>
          </div>
        </div>
      </div>

      <!-- Right — floating platform mosaic -->
      <div class="mp-hero-visual">
        <div class="mp-platform-mosaic">
          <div class="mp-mosaic-card mp-mc-1">
            <span class="platform-icon youtube-color"><i class="fab fa-youtube"></i></span>
            <span>YouTube</span>
          </div>
          <div class="mp-mosaic-card mp-mc-2">
            <span class="platform-icon vimeo-color"><i class="fab fa-vimeo-v"></i></span>
            <span>Vimeo</span>
          </div>
          <div class="mp-mosaic-card mp-mc-3">
            <span class="platform-icon twitch-color"><i class="fab fa-twitch"></i></span>
            <span>Twitch</span>
          </div>
          <div class="mp-mosaic-card mp-mc-4">
            <span class="platform-icon dm-color"><i class="fas fa-play-circle"></i></span>
            <span>Dailymotion</span>
          </div>
          <div class="mp-mosaic-card mp-mc-5">
            <span class="platform-icon flickr-color"><i class="fab fa-flickr"></i></span>
            <span>Flickr</span>
          </div>
          <div class="mp-mosaic-card mp-mc-6">
            <span class="platform-icon rumble-color"><i class="fas fa-bolt"></i></span>
            <span>Rumble</span>
          </div>
          <div class="mp-mosaic-card mp-mc-7">
            <span class="platform-icon peertube-color"><i class="fas fa-network-wired"></i></span>
            <span>PeerTube</span>
          </div>
          <div class="mp-mosaic-card mp-mc-8">
            <span class="platform-icon dtube-color"><i class="fab fa-decentraland"></i></span>
            <span>DTube</span>
          </div>
          <div class="mp-mosaic-card mp-mc-9">
            <span class="platform-icon veoh-color"><i class="fas fa-film"></i></span>
            <span>Veoh</span>
          </div>
          <div class="mp-mosaic-card mp-mc-10">
            <span class="platform-icon odysee-color"><i class="fas fa-satellite-dish"></i></span>
            <span>Odysee</span>
          </div>
          <div class="mp-mosaic-card mp-mc-11">
            <span class="platform-icon bitchute-color"><i class="fas fa-broadcast-tower"></i></span>
            <span>Bitchute</span>
          </div>
          <div class="mp-mosaic-card mp-mc-12">
            <span class="platform-icon rumble-color"><i class="fas fa-clapperboard"></i></span>
            <span>Crackle</span>
          </div>
          <div class="mp-mosaic-card mp-mc-13">
            <span class="platform-icon utreon-color"><i class="fas fa-infinity"></i></span>
            <span>Utreon</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════════════════════════════════════
       INTRO — Pourquoi GoExploria
  ═══════════════════════════════════════ -->
  <section class="mp-intro">
    <div class="mp-intro-inner">
      <div>
        <div class="mp-intro-label">Notre approche</div>
        <h2 class="mp-intro-title">
          GoExploria Business crée<br>
          vos chaînes pour vous,<br>
          <em>de A à Z</em>
        </h2>
        <p class="mp-intro-desc">
          Nous ne vous demandons pas de maîtriser 13 interfaces différentes. Notre équipe prend en charge l'intégralité du déploiement de votre présence vidéo : création des comptes, branding des chaînes, optimisation SEO, mise en ligne des contenus et pilotage des analytics.
        </p>
        <p class="mp-intro-desc">
          Chaque plateforme possède ses propres codes, algorithmes et audiences. GoExploria adapte votre message et votre contenu à chaque environnement pour maximiser la portée de votre marque touristique à l'international.
        </p>
        <div class="mp-feature-pills">
          <div class="mp-feature-pill"><i class="fas fa-check"></i> Création complète des chaînes</div>
          <div class="mp-feature-pill"><i class="fas fa-check"></i> Branding cohérent multiplateforme</div>
          <div class="mp-feature-pill"><i class="fas fa-check"></i> SEO vidéo optimisé</div>
          <div class="mp-feature-pill"><i class="fas fa-check"></i> Upload & scheduling</div>
          <div class="mp-feature-pill"><i class="fas fa-check"></i> Analytics unifiés</div>
          <div class="mp-feature-pill"><i class="fas fa-check"></i> Community management</div>
        </div>
      </div>
      <div class="mp-intro-right">
        <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:rgba(255,255,255,0.35);margin-bottom:24px">Notre processus</div>
        <div class="mp-process-steps">
          <div class="mp-step">
            <div class="mp-step-num">01</div>
            <div class="mp-step-content">
              <h4>Audit & stratégie de diffusion</h4>
              <p>Analyse de vos objectifs, de votre audience cible et sélection des plateformes les plus pertinentes pour votre marque.</p>
            </div>
          </div>
          <div class="mp-step">
            <div class="mp-step-num">02</div>
            <div class="mp-step-content">
              <h4>Création & branding des chaînes</h4>
              <p>Ouverture des comptes, personnalisation visuelle (bannières, logos, bios) en cohérence avec votre identité GoExploria.</p>
            </div>
          </div>
          <div class="mp-step">
            <div class="mp-step-num">03</div>
            <div class="mp-step-content">
              <h4>Production & optimisation des contenus</h4>
              <p>Mise en ligne des vidéos avec titres, descriptions, tags et miniatures optimisés pour chaque algorithme de plateforme.</p>
            </div>
          </div>
          <div class="mp-step">
            <div class="mp-step-num">04</div>
            <div class="mp-step-content">
              <h4>Pilotage continu & reporting</h4>
              <p>Suivi mensuel des performances, ajustements stratégiques et rapport consolidé sur toutes vos chaînes actives.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════════════════════════════════════
       PLATFORMS GRID
  ═══════════════════════════════════════ -->
  <section class="mp-platforms-section" id="platforms">
    <div class="mp-platforms-inner">
      <div class="mp-section-head">
        <div class="mp-section-label">13 Plateformes maîtrisées</div>
        <h2 class="mp-section-title">Chaque plateforme,<br>un univers à part entière</h2>
        <p class="mp-section-desc">GoExploria connaît les spécificités de chaque réseau et y déploie votre contenu avec précision pour toucher les bonnes audiences.</p>
      </div>

      <div class="mp-platforms-grid">

        <!-- YouTube -->
        <a href="https://www.youtube.com/" target="_blank" class="mp-platform-card mp-pc-youtube" style="--accent:#ff0000">
          <div class="mp-card-top">
            <div class="mp-card-icon-wrap"><i class="fab fa-youtube"></i></div>
            <div class="mp-card-arrow"><i class="fas fa-arrow-right"></i></div>
          </div>
          <div class="mp-card-platform-name">YouTube</div>
          <div class="mp-card-tagline">Référence mondiale</div>
          <div class="mp-card-desc">Chaînes vidéo, playlists et diffusion mondiale. 2,7 milliards d'utilisateurs actifs. La plateforme incontournable pour toute stratégie vidéo globale.</div>
          <div class="mp-card-tags">
            <span class="mp-card-tag">Chaîne HD</span>
            <span class="mp-card-tag">Playlists</span>
            <span class="mp-card-tag">Shorts</span>
            <span class="mp-card-tag">Analytics</span>
          </div>
        </a>

        <!-- Vimeo -->
        <a href="https://vimeo.com/" target="_blank" class="mp-platform-card mp-pc-vimeo" style="--accent:#1ab7ea">
          <div class="mp-card-top">
            <div class="mp-card-icon-wrap"><i class="fab fa-vimeo-v"></i></div>
            <div class="mp-card-arrow"><i class="fas fa-arrow-right"></i></div>
          </div>
          <div class="mp-card-platform-name">Vimeo</div>
          <div class="mp-card-tagline">Premium & Pro</div>
          <div class="mp-card-desc">Hébergement premium et qualité professionnelle. Idéal pour les films documentaires, portfolios de marque et diffusions sans publicité.</div>
          <div class="mp-card-tags">
            <span class="mp-card-tag">4K HDR</span>
            <span class="mp-card-tag">Sans pub</span>
            <span class="mp-card-tag">Pro Portfolio</span>
          </div>
        </a>

        <!-- Dailymotion -->
        <a href="https://www.dailymotion.com/" target="_blank" class="mp-platform-card mp-pc-daily" style="--accent:#0066dc">
          <div class="mp-card-top">
            <div class="mp-card-icon-wrap"><i class="fas fa-play-circle"></i></div>
            <div class="mp-card-arrow"><i class="fas fa-arrow-right"></i></div>
          </div>
          <div class="mp-card-platform-name">Dailymotion</div>
          <div class="mp-card-tagline">Éditorial & International</div>
          <div class="mp-card-desc">Distribution vidéo éditoriale et internationale. Forte présence en Europe et Afrique francophone, idéale pour GoExploria.</div>
          <div class="mp-card-tags">
            <span class="mp-card-tag">Francophone</span>
            <span class="mp-card-tag">Éditorial</span>
            <span class="mp-card-tag">Distribution</span>
          </div>
        </a>

        <!-- Flickr -->
        <a href="https://www.flickr.com/" target="_blank" class="mp-platform-card mp-pc-flickr" style="--accent:#ff0084">
          <div class="mp-card-top">
            <div class="mp-card-icon-wrap"><i class="fab fa-flickr"></i></div>
            <div class="mp-card-arrow"><i class="fas fa-arrow-right"></i></div>
          </div>
          <div class="mp-card-platform-name">Flickr</div>
          <div class="mp-card-tagline">Galeries Créatives</div>
          <div class="mp-card-desc">Galeries photo créatives et archives médias. Plateforme de référence pour les photographes et les marques à fort capital visuel.</div>
          <div class="mp-card-tags">
            <span class="mp-card-tag">Photo HD</span>
            <span class="mp-card-tag">Galeries</span>
            <span class="mp-card-tag">Archives</span>
          </div>
        </a>

        <!-- Utreon -->
        <a href="https://utreon.com/" target="_blank" class="mp-platform-card mp-pc-utreon" style="--accent:#7c4dff">
          <div class="mp-card-top">
            <div class="mp-card-icon-wrap"><i class="fas fa-infinity"></i></div>
            <div class="mp-card-arrow"><i class="fas fa-arrow-right"></i></div>
          </div>
          <div class="mp-card-platform-name">Utreon</div>
          <div class="mp-card-tagline">Alternative Moderne</div>
          <div class="mp-card-desc">Alternative moderne pour créateurs de contenu. Algorithme transparent, monétisation équitable, audience engagée et en forte croissance.</div>
          <div class="mp-card-tags">
            <span class="mp-card-tag">Créateurs</span>
            <span class="mp-card-tag">Monétisation</span>
            <span class="mp-card-tag">Croissance</span>
          </div>
        </a>

        <!-- Rumble -->
        <a href="https://rumble.com/" target="_blank" class="mp-platform-card mp-pc-rumble" style="--accent:#85c742">
          <div class="mp-card-top">
            <div class="mp-card-icon-wrap"><i class="fas fa-bolt"></i></div>
            <div class="mp-card-arrow"><i class="fas fa-arrow-right"></i></div>
          </div>
          <div class="mp-card-platform-name">Rumble</div>
          <div class="mp-card-tagline">Dynamique & Rentable</div>
          <div class="mp-card-desc">Plateforme vidéo dynamique et monétisation simple. En pleine expansion avec une audience diversifiée et des revenus directs pour les créateurs.</div>
          <div class="mp-card-tags">
            <span class="mp-card-tag">Monétisation</span>
            <span class="mp-card-tag">Expansion</span>
            <span class="mp-card-tag">Direct</span>
          </div>
        </a>

        <!-- DTube -->
        <a href="https://d.tube/" target="_blank" class="mp-platform-card mp-pc-dtube" style="--accent:#cc0202">
          <div class="mp-card-top">
            <div class="mp-card-icon-wrap"><i class="fas fa-link"></i></div>
            <div class="mp-card-arrow"><i class="fas fa-arrow-right"></i></div>
          </div>
          <div class="mp-card-platform-name">DTube</div>
          <div class="mp-card-tagline">Décentralisé & Web3</div>
          <div class="mp-card-desc">Réseau vidéo décentralisé orienté communauté. Aucune censure algorithmique, stockage distribué et rémunération en cryptomonnaie.</div>
          <div class="mp-card-tags">
            <span class="mp-card-tag">Web3</span>
            <span class="mp-card-tag">Blockchain</span>
            <span class="mp-card-tag">Communauté</span>
          </div>
        </a>

        <!-- PeerTube -->
        <a href="https://joinpeertube.org/" target="_blank" class="mp-platform-card mp-pc-peertube" style="--accent:#f1680d">
          <div class="mp-card-top">
            <div class="mp-card-icon-wrap"><i class="fas fa-network-wired"></i></div>
            <div class="mp-card-arrow"><i class="fas fa-arrow-right"></i></div>
          </div>
          <div class="mp-card-platform-name">PeerTube</div>
          <div class="mp-card-tagline">Open Source Fédéré</div>
          <div class="mp-card-desc">Création de chaînes en réseau fédéré open source. Contrôle total des données, indépendance technologique et audience niches engagées.</div>
          <div class="mp-card-tags">
            <span class="mp-card-tag">Open Source</span>
            <span class="mp-card-tag">Fédéré</span>
            <span class="mp-card-tag">Souveraineté</span>
          </div>
        </a>

        <!-- Veoh -->
        <a href="https://www.veoh.com/" target="_blank" class="mp-platform-card mp-pc-veoh" style="--accent:#57b7e6">
          <div class="mp-card-top">
            <div class="mp-card-icon-wrap"><i class="fas fa-film"></i></div>
            <div class="mp-card-arrow"><i class="fas fa-arrow-right"></i></div>
          </div>
          <div class="mp-card-platform-name">Veoh</div>
          <div class="mp-card-tagline">Long Format & Archives</div>
          <div class="mp-card-desc">Contenu long format et chaînes historiques. Parfait pour les documentaires de voyage, reportages complets et séries de destination.</div>
          <div class="mp-card-tags">
            <span class="mp-card-tag">Long format</span>
            <span class="mp-card-tag">Documentaires</span>
            <span class="mp-card-tag">Archives</span>
          </div>
        </a>

        <!-- Twitch -->
        <a href="https://www.twitch.tv/" target="_blank" class="mp-platform-card mp-pc-twitch" style="--accent:#9146ff">
          <div class="mp-card-top">
            <div class="mp-card-icon-wrap"><i class="fab fa-twitch"></i></div>
            <div class="mp-card-arrow"><i class="fas fa-arrow-right"></i></div>
          </div>
          <div class="mp-card-platform-name">Twitch</div>
          <div class="mp-card-tagline">Live & Interactif</div>
          <div class="mp-card-desc">Live streaming interactif pour audiences actives. Idéal pour les événements en direct, lancements de destinations, Q&A et experiences immersives.</div>
          <div class="mp-card-tags">
            <span class="mp-card-tag">Live</span>
            <span class="mp-card-tag">Interactions</span>
            <span class="mp-card-tag">Événements</span>
          </div>
        </a>

        <!-- Crackle -->
        <a href="https://www.crackle.com/" target="_blank" class="mp-platform-card mp-pc-crackle" style="--accent:#e62429">
          <div class="mp-card-top">
            <div class="mp-card-icon-wrap"><i class="fas fa-clapperboard"></i></div>
            <div class="mp-card-arrow"><i class="fas fa-arrow-right"></i></div>
          </div>
          <div class="mp-card-platform-name">Crackle</div>
          <div class="mp-card-tagline">Séries & Divertissement</div>
          <div class="mp-card-desc">Catalogues vidéos, séries et formats divertissement. Plateforme AVOD en pleine croissance, parfaite pour les formats longs et séries documentaires.</div>
          <div class="mp-card-tags">
            <span class="mp-card-tag">Séries</span>
            <span class="mp-card-tag">AVOD</span>
            <span class="mp-card-tag">Premium</span>
          </div>
        </a>

        <!-- Odysee -->
        <a href="https://odysee.com/" target="_blank" class="mp-platform-card mp-pc-odysee" style="--accent:#ef1970">
          <div class="mp-card-top">
            <div class="mp-card-icon-wrap"><i class="fas fa-satellite-dish"></i></div>
            <div class="mp-card-arrow"><i class="fas fa-arrow-right"></i></div>
          </div>
          <div class="mp-card-platform-name">Odysee</div>
          <div class="mp-card-tagline">Diffusion Libre</div>
          <div class="mp-card-desc">Diffusion libre de contenus et communautés niches. Fondée sur la blockchain LBRY, elle offre une liberté éditoriale totale et des micro-communautés passionnées.</div>
          <div class="mp-card-tags">
            <span class="mp-card-tag">LBRY</span>
            <span class="mp-card-tag">Niches</span>
            <span class="mp-card-tag">Liberté</span>
          </div>
        </a>

        <!-- Bitchute -->
        <a href="https://www.bitchute.com/" target="_blank" class="mp-platform-card mp-pc-bitchute" style="--accent:#ff6600">
          <div class="mp-card-top">
            <div class="mp-card-icon-wrap"><i class="fas fa-broadcast-tower"></i></div>
            <div class="mp-card-arrow"><i class="fas fa-arrow-right"></i></div>
          </div>
          <div class="mp-card-platform-name">Bitchute</div>
          <div class="mp-card-tagline">Partage Alternatif</div>
          <div class="mp-card-desc">Partage vidéo alternatif et canaux spécialisés. Peer-to-peer natif, sans filtrage algorithmique, pour des audiences spécifiques et engagées.</div>
          <div class="mp-card-tags">
            <span class="mp-card-tag">P2P</span>
            <span class="mp-card-tag">Alternatif</span>
            <span class="mp-card-tag">Spécialisé</span>
          </div>
        </a>

      </div>
    </div>
  </section>

  <!-- ═══════════════════════════════════════
       SERVICES
  ═══════════════════════════════════════ -->
  <section class="mp-services-section">
    <div class="mp-services-inner">
      <div class="mp-section-head">
        <div class="mp-section-label">Nos prestations</div>
        <h2 class="mp-section-title">Ce que GoExploria<br>fait pour vous</h2>
        <p class="mp-section-desc">Un service clé-en-main qui couvre chaque étape du cycle de vie de vos chaînes vidéo, de la création à l'optimisation continue.</p>
      </div>

      <div class="mp-services-grid">
        <div class="mp-service-card">
          <div class="mp-service-icon"><i class="fas fa-store"></i></div>
          <div class="mp-service-title">Création de chaînes personnalisées</div>
          <div class="mp-service-desc">Nous créons et configurons vos chaînes de zéro sur les plateformes sélectionnées. Noms de chaîne, descriptions localisées, liens croisés et vérification officielle des comptes.</div>
        </div>
        <div class="mp-service-card">
          <div class="mp-service-icon"><i class="fas fa-palette"></i></div>
          <div class="mp-service-title">Branding & identité visuelle</div>
          <div class="mp-service-desc">Conception de bannières, photos de profil, miniatures vidéo et kits graphiques adaptés aux dimensions exactes de chaque plateforme et à votre charte GoExploria.</div>
        </div>
        <div class="mp-service-card">
          <div class="mp-service-icon"><i class="fas fa-search"></i></div>
          <div class="mp-service-title">SEO vidéo & optimisation</div>
          <div class="mp-service-desc">Recherche de mots-clés, rédaction de titres et descriptions optimisés, stratégie de tags et sous-titres multilingues pour maximiser la découvrabilité de vos vidéos.</div>
        </div>
        <div class="mp-service-card">
          <div class="mp-service-icon"><i class="fas fa-calendar-alt"></i></div>
          <div class="mp-service-title">Planification & mise en ligne</div>
          <div class="mp-service-desc">Scheduling stratégique des publications selon les heures de pointe de chaque plateforme, gestion des playlists et organisation thématique du catalogue vidéo.</div>
        </div>
        <div class="mp-service-card">
          <div class="mp-service-icon"><i class="fas fa-chart-line"></i></div>
          <div class="mp-service-title">Analytics & reporting unifié</div>
          <div class="mp-service-desc">Dashboard centralisé regroupant les métriques de toutes vos chaînes : vues, rétention, démographies, revenus et croissance d'abonnés en un seul rapport mensuel.</div>
        </div>
        <div class="mp-service-card">
          <div class="mp-service-icon"><i class="fas fa-comments"></i></div>
          <div class="mp-service-title">Community management vidéo</div>
          <div class="mp-service-desc">Modération des commentaires, réponses aux abonnés, gestion des collaborations et animation de votre communauté pour créer un lien durable avec votre audience.</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════════════════════════════════════
       COMPARISON TABLE
  ═══════════════════════════════════════ -->
  <section class="mp-table-section">
    <div class="mp-table-inner">
      <div class="mp-section-head">
        <div class="mp-section-label">Tableau comparatif</div>
        <h2 class="mp-section-title">Quelle plateforme<br>pour quel objectif ?</h2>
        <p class="mp-section-desc">Un aperçu des forces de chaque plateforme pour vous aider à comprendre notre stratégie de déploiement multicanal.</p>
      </div>
      <table class="mp-comparison-table">
        <thead>
          <tr>
            <th>Plateforme</th>
            <th>Audience mondiale</th>
            <th>Long format</th>
            <th>Live streaming</th>
            <th>Monétisation</th>
            <th>Idéal pour</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><span class="mp-table-icon" style="color:#ff0000"><i class="fab fa-youtube"></i></span> YouTube</td>
            <td><i class="fas fa-check mp-check"></i> Mondiale</td>
            <td><i class="fas fa-check mp-check"></i></td>
            <td><i class="fas fa-check mp-check"></i></td>
            <td><i class="fas fa-check mp-check"></i> AdSense</td>
            <td>Visibilité globale</td>
          </tr>
          <tr>
            <td><span class="mp-table-icon" style="color:#1ab7ea"><i class="fab fa-vimeo-v"></i></span> Vimeo</td>
            <td><i class="fas fa-check mp-check"></i> Pro</td>
            <td><i class="fas fa-check mp-check"></i></td>
            <td><i class="fas fa-minus mp-partial"></i></td>
            <td><i class="fas fa-minus mp-partial"></i> Abonnement</td>
            <td>Qualité documentaire</td>
          </tr>
          <tr>
            <td><span class="mp-table-icon" style="color:#0066dc"><i class="fas fa-play-circle"></i></span> Dailymotion</td>
            <td><i class="fas fa-check mp-check"></i> Europe/Afrique</td>
            <td><i class="fas fa-check mp-check"></i></td>
            <td><i class="fas fa-minus mp-partial"></i></td>
            <td><i class="fas fa-check mp-check"></i> Partage rev.</td>
            <td>Marché francophone</td>
          </tr>
          <tr>
            <td><span class="mp-table-icon" style="color:#ff0084"><i class="fab fa-flickr"></i></span> Flickr</td>
            <td><i class="fas fa-check mp-check"></i> Créatifs</td>
            <td><i class="fas fa-times mp-cross"></i></td>
            <td><i class="fas fa-times mp-cross"></i></td>
            <td><i class="fas fa-times mp-cross"></i></td>
            <td>Archives photo</td>
          </tr>
          <tr>
            <td><span class="mp-table-icon" style="color:#9146ff"><i class="fab fa-twitch"></i></span> Twitch</td>
            <td><i class="fas fa-check mp-check"></i> Gaming/Lifestyle</td>
            <td><i class="fas fa-minus mp-partial"></i></td>
            <td><i class="fas fa-check mp-check"></i> Natif</td>
            <td><i class="fas fa-check mp-check"></i> Subs/Bits</td>
            <td>Événements live</td>
          </tr>
          <tr>
            <td><span class="mp-table-icon" style="color:#85c742"><i class="fas fa-bolt"></i></span> Rumble</td>
            <td><i class="fas fa-check mp-check"></i> En croissance</td>
            <td><i class="fas fa-check mp-check"></i></td>
            <td><i class="fas fa-check mp-check"></i></td>
            <td><i class="fas fa-check mp-check"></i> Direct</td>
            <td>Diversification revenus</td>
          </tr>
          <tr>
            <td><span class="mp-table-icon" style="color:#f1680d"><i class="fas fa-network-wired"></i></span> PeerTube</td>
            <td><i class="fas fa-minus mp-partial"></i> Niches</td>
            <td><i class="fas fa-check mp-check"></i></td>
            <td><i class="fas fa-check mp-check"></i></td>
            <td><i class="fas fa-times mp-cross"></i></td>
            <td>Souveraineté données</td>
          </tr>
          <tr>
            <td><span class="mp-table-icon" style="color:#cc0202"><i class="fas fa-link"></i></span> DTube</td>
            <td><i class="fas fa-minus mp-partial"></i> Web3</td>
            <td><i class="fas fa-check mp-check"></i></td>
            <td><i class="fas fa-times mp-cross"></i></td>
            <td><i class="fas fa-check mp-check"></i> Crypto</td>
            <td>Audience blockchain</td>
          </tr>
          <tr>
            <td><span class="mp-table-icon" style="color:#57b7e6"><i class="fas fa-film"></i></span> Veoh</td>
            <td><i class="fas fa-minus mp-partial"></i> Historique</td>
            <td><i class="fas fa-check mp-check"></i> Illimité</td>
            <td><i class="fas fa-times mp-cross"></i></td>
            <td><i class="fas fa-minus mp-partial"></i></td>
            <td>Formats longs</td>
          </tr>
          <tr>
            <td><span class="mp-table-icon" style="color:#ef1970"><i class="fas fa-satellite-dish"></i></span> Odysee</td>
            <td><i class="fas fa-minus mp-partial"></i> Alternative</td>
            <td><i class="fas fa-check mp-check"></i></td>
            <td><i class="fas fa-check mp-check"></i></td>
            <td><i class="fas fa-check mp-check"></i> LBRY Credits</td>
            <td>Liberté éditoriale</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <!-- ═══════════════════════════════════════
       CTA FINALE
  ═══════════════════════════════════════ -->
  <section class="mp-cta-section">
    <div class="mp-cta-inner">
      <div class="mp-hero-badge" style="justify-content:center;margin:0 auto 32px">
        <span class="mp-hero-badge-dot"></span>
        Démarrez dès aujourd'hui
      </div>
      <h2 class="mp-cta-title">
        Votre marque mérite<br>
        une présence <em>vidéo mondiale</em>
      </h2>
      <p class="mp-cta-desc">
        Laissez GoExploria Business créer, animer et optimiser vos chaînes sur les 13 plus grandes plateformes vidéo mondiales. Concentrez-vous sur vos aventures, nous gérons votre rayonnement.
      </p>
      <div class="mp-cta-buttons">
        <a href="#" class="btn-orange" style="font-size:15px;padding:16px 36px"><i class="fas fa-rocket"></i> Démarrer mon projet vidéo</a>
        <a href="#" class="btn-outline-white" style="font-size:15px;padding:16px 36px"><i class="fas fa-phone-alt"></i> Parler à un expert</a>
      </div>
    </div>
  </section>

</div>
@endsection

@section('scripts')
<script>
// Animate hero stats on scroll
(function() {
  const stats = document.querySelectorAll('.mp-hero-stat strong');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el = entry.target;
      const rawTarget = el.textContent.replace(/[^0-9]/g, '');
      const suffix = el.textContent.replace(/[0-9]/g, '');
      if (!rawTarget) return;
      const target = parseInt(rawTarget);
      let current = 0;
      const inc = target / 55;
      const timer = setInterval(() => {
        current += inc;
        if (current >= target) { current = target; clearInterval(timer); }
        el.textContent = Math.floor(current) + suffix;
      }, 18);
      observer.unobserve(el);
    });
  }, { threshold: 0.5 });
  stats.forEach(s => observer.observe(s));
})();

// Platform card hover ripple
document.querySelectorAll('.mp-platform-card').forEach(card => {
  card.addEventListener('mouseenter', function() {
    this.style.transition = 'all 0.35s cubic-bezier(0.23, 1, 0.32, 1)';
  });
});
</script>
@endsection