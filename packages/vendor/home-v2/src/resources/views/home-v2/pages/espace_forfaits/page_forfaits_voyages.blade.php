<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forfaits Voyages — GoExploria</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --orange:  #E86B24;
  --orange2: #F08040;
  --teal:    #1B7A8C;
  --teal2:   #14A8C4;
  --gold:    #C9A84C;
  --maple:   #C1372A;
  --globe:   #2E6DA4;
  --dark:    #12181F;
  --mid:     #2C3540;
  --text:    #1A1F26;
  --muted:   #6B7785;
  --border:  #E4E8ED;
  --bg:      #F7F8FA;
  --white:   #FFFFFF;
}

html { scroll-behavior: smooth; }
body { font-family: 'DM Sans', sans-serif; background: var(--white); color: var(--text); overflow-x: hidden; }
img  { display: block; max-width: 100%; }
a    { text-decoration: none; color: inherit; }

/* ──────────── NAV ──────────── */
.nav {
  position: sticky; top: 0; z-index: 100;
  background: rgba(255,255,255,.97);
  border-bottom: 1px solid var(--border);
  backdrop-filter: blur(8px);
}
.nav-inner {
  width: 100%; max-width: 1400px; margin: 0 auto;
  padding: 0 2rem; height: 64px;
  display: flex; align-items: center; justify-content: space-between; gap: 2rem;
}
.nav-logo { display: flex; align-items: center; gap: 10px; }
.nav-logo img { height: 36px; object-fit: contain; }
.nav-logo-text { font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 700; color: var(--orange); }
.nav-logo-text span { color: var(--teal); }
.nav-links { display: flex; align-items: center; gap: 1.8rem; list-style: none; }
.nav-links a { font-size: 14px; font-weight: 500; color: var(--mid); transition: color .2s; }
.nav-links a:hover { color: var(--orange); }
.nav-cta {
  background: var(--orange); color: #fff; border: none;
  padding: 9px 20px; border-radius: 8px;
  font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 600;
  cursor: pointer; white-space: nowrap; transition: background .2s;
}
.nav-cta:hover { background: #CF5D18; }

/* ──────────── HERO ──────────── */
.hero {
  position: relative; width: 100%; height: 580px; overflow: hidden;
}
.hero-bg {
  position: absolute; inset: 0;
  background-image: url('https://images.pexels.com/photos/2325446/pexels-photo-2325446.jpeg?auto=compress&cs=tinysrgb&w=1800&h=700&dpr=1');
  background-size: cover; background-position: center 35%;
  transform: scale(1.04); transition: transform 8s ease-out;
}
.hero-bg.loaded { transform: scale(1); }
.hero-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(110deg, rgba(12,18,26,.85) 0%, rgba(12,18,26,.5) 55%, rgba(12,18,26,.12) 100%);
}
.hero-content {
  position: relative; z-index: 2;
  width: 100%; max-width: 1400px; margin: 0 auto;
  padding: 0 4rem; height: 100%;
  display: flex; flex-direction: column; justify-content: center;
}
.hero-eyebrow {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(232,107,36,.18); border: 1px solid rgba(232,107,36,.5);
  border-radius: 20px; padding: 5px 16px;
  font-size: 11px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase;
  color: #FFB380; margin-bottom: 1.2rem; width: fit-content;
}
.hero-eyebrow::before {
  content:''; width:7px; height:7px; border-radius:50%;
  background: var(--orange2); animation: blink 2s infinite;
}
@keyframes blink { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(1.6)} }
.hero-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.6rem, 5vw, 4rem); font-weight: 900;
  color: #fff; line-height: 1.06; letter-spacing: -.02em;
  margin-bottom: 1.1rem; max-width: 700px;
}
.hero-title em { font-style: normal; color: var(--orange2); }
.hero-sub {
  font-size: 1.05rem; color: rgba(255,255,255,.75); line-height: 1.75;
  max-width: 560px; font-weight: 300; margin-bottom: 2.2rem;
}
.hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
.btn-primary {
  background: var(--orange); color: #fff; border: none;
  padding: 14px 30px; border-radius: 10px;
  font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 600;
  cursor: pointer; transition: background .2s, transform .15s;
  display: inline-flex; align-items: center; gap: 8px;
}
.btn-primary:hover { background: #CF5D18; transform: translateY(-1px); }
.btn-ghost {
  background: rgba(255,255,255,.12); color: #fff;
  border: 1.5px solid rgba(255,255,255,.35);
  padding: 14px 28px; border-radius: 10px;
  font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 500;
  cursor: pointer; transition: background .2s; backdrop-filter: blur(4px);
  display: inline-flex; align-items: center; gap: 8px;
}
.btn-ghost:hover { background: rgba(255,255,255,.22); }

/* HERO STATS */
.hero-stats {
  position: absolute; bottom: 0; left: 0; right: 0;
  background: rgba(12,18,26,.72); backdrop-filter: blur(12px);
  border-top: 1px solid rgba(255,255,255,.08); z-index: 2;
}
.hero-stats-inner {
  width: 100%; max-width: 1400px; margin: 0 auto;
  padding: 0 4rem; display: flex; align-items: stretch;
}
.hero-stat {
  flex: 1; padding: 1.2rem 0; text-align: center;
  border-right: 1px solid rgba(255,255,255,.08);
}
.hero-stat:last-child { border-right: none; }
.hero-stat-num { font-family: 'Playfair Display', serif; font-size: 1.9rem; font-weight: 700; color: var(--orange2); line-height: 1; }
.hero-stat-label { font-size: 11px; color: rgba(255,255,255,.5); letter-spacing: .05em; text-transform: uppercase; margin-top: 4px; }

/* ──────────── DEST BAR ──────────── */
.dest-bar { background: var(--white); border-bottom: 1px solid var(--border); }
.dest-bar-inner {
  width: 100%; max-width: 1400px; margin: 0 auto;
  padding: 0 2rem; display: flex; align-items: center; height: 54px; gap: 0;
}
.dest-icon {
  display: flex; align-items: center; gap: 8px;
  font-size: 13px; font-weight: 600; color: var(--orange);
  padding-right: 1.5rem; border-right: 1px solid var(--border);
  white-space: nowrap; flex-shrink: 0;
}
.dest-selects { display: flex; align-items: center; gap: 4px; padding-left: 1.5rem; flex-wrap: wrap; }
.dest-sep { font-size: 14px; color: #BBC4CF; padding: 0 4px; }
.dest-select {
  border: none; background: transparent;
  font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 500;
  color: var(--text); cursor: pointer; padding: 4px 20px 4px 6px;
  appearance: none; -webkit-appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='7'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23BBC4CF' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: right 4px center;
}
.dest-select:focus { outline: none; color: var(--orange); }

/* ──────────── FILTER BAR ──────────── */
.filter-bar { background: var(--bg); border-bottom: 1px solid var(--border); }
.filter-bar-inner {
  width: 100%; max-width: 1400px; margin: 0 auto;
  padding: 0 2rem; display: flex; align-items: center;
  gap: 8px; height: 56px; overflow-x: auto; scrollbar-width: none;
}
.filter-bar-inner::-webkit-scrollbar { display: none; }
.filter-btn {
  flex-shrink: 0; display: inline-flex; align-items: center; gap: 7px;
  padding: 7px 20px; border-radius: 22px;
  border: 1.5px solid var(--border); background: var(--white);
  color: var(--muted); font-family: 'DM Sans', sans-serif;
  font-size: 13px; font-weight: 500; cursor: pointer; transition: all .2s; white-space: nowrap;
}
.filter-btn:hover, .filter-btn.active {
  background: var(--orange); border-color: var(--orange); color: #fff;
}

/* ──────────── SECTION COMMONS ──────────── */
.section { width: 100%; padding: 4rem 0; }
.section.alt { background: var(--bg); }
.container { width: 100%; max-width: 1400px; margin: 0 auto; padding: 0 2rem; }
.sec-header {
  display: flex; align-items: flex-end; justify-content: space-between;
  margin-bottom: 2.2rem; gap: 1rem; flex-wrap: wrap;
}
.sec-label {
  font-size: 11px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase;
  color: var(--orange); margin-bottom: 6px;
  display: flex; align-items: center; gap: 6px;
}
.sec-label::before { content:''; width:18px; height:2px; background: var(--orange); border-radius:2px; }
.sec-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(1.7rem, 3vw, 2.4rem); font-weight: 700;
  line-height: 1.15; color: var(--text);
}
.sec-link {
  font-size: 13px; font-weight: 600; color: var(--orange);
  display: flex; align-items: center; gap: 5px; white-space: nowrap; transition: gap .2s;
}
.sec-link:hover { gap: 9px; }

/* ──────────── CATEGORY HEADER BLOCK ──────────── */
.pkg-category-block {
  display: flex; align-items: center; gap: 1.2rem;
  margin-bottom: 1.8rem; padding-bottom: 1.2rem;
  border-bottom: 2px solid var(--border);
}
.pkg-cat-icon {
  width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center; font-size: 22px;
}
.pkg-cat-icon.quebec { background: #FFF0EE; color: var(--maple); border: 1.5px solid rgba(193,55,42,.2); }
.pkg-cat-icon.europe { background: #EEF3FA; color: var(--globe); border: 1.5px solid rgba(46,109,164,.2); }
.pkg-cat-titles { flex: 1; }
.pkg-cat-title { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 700; line-height: 1.1; }
.pkg-cat-subtitle { font-size: 13px; color: var(--muted); margin-top: 2px; }
.pkg-cat-count {
  font-size: 12px; font-weight: 700; padding: 5px 14px; border-radius: 20px;
  background: var(--bg); border: 1px solid var(--border); color: var(--muted); white-space: nowrap;
}

/* ──────────── PACKAGES GRID ──────────── */
.packages-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 22px;
  margin-bottom: 3.5rem;
}

.package-card {
  background: var(--white); border: 1.5px solid var(--border);
  border-radius: 18px; overflow: hidden; cursor: pointer;
  transition: box-shadow .3s, transform .3s, border-color .3s;
  display: flex; flex-direction: column;
}
.package-card:hover {
  box-shadow: 0 16px 48px rgba(0,0,0,.11);
  transform: translateY(-5px); border-color: rgba(232,107,36,.3);
}

.package-image {
  position: relative; overflow: hidden;
}
.package-image img {
  width: 100%; aspect-ratio: 16/10; object-fit: cover; display: block;
  transition: transform .55s ease;
}
.package-card:hover .package-image img { transform: scale(1.07); }

/* BADGE */
.package-badge {
  position: absolute; top: 14px; left: 14px;
  font-size: 10px; font-weight: 800; letter-spacing: .1em;
  text-transform: uppercase; padding: 5px 12px; border-radius: 8px; color: #fff;
}
.pkg-badge--popular  { background: var(--orange); }
.pkg-badge--new      { background: var(--teal); }
.pkg-badge--luxe     { background: var(--gold); }
.pkg-badge--couple   { background: #C1587A; }
.pkg-badge--exclusif { background: #5B3FA6; }
.pkg-badge--top      { background: var(--maple); }

/* PRICE RIBBON */
.package-price-ribbon {
  position: absolute; bottom: 0; right: 0;
  background: var(--dark); color: #fff;
  font-family: 'Playfair Display', serif;
  font-size: 1.3rem; font-weight: 700;
  padding: 8px 18px 8px 22px;
  border-radius: 12px 0 0 0;
}
.package-price-ribbon small { font-family: 'DM Sans', sans-serif; font-size: 11px; font-weight: 400; opacity: .6; margin-left: 2px; }

.package-content { padding: 1.4rem; display: flex; flex-direction: column; flex: 1; }

.package-title { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 700; margin-bottom: 6px; line-height: 1.25; }

.package-location {
  display: flex; align-items: center; gap: 5px;
  font-size: 12px; color: var(--muted); margin-bottom: 10px;
}
.package-location i { color: var(--orange); font-size: 11px; }

.package-desc {
  font-size: 13.5px; color: var(--muted); line-height: 1.65;
  margin-bottom: 14px; flex: 1;
}

.package-features {
  display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px;
}
.package-feature {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: 11px; font-weight: 600;
  padding: 4px 10px; border-radius: 10px;
  background: var(--bg); color: var(--mid); border: 1px solid var(--border);
}
.package-feature i { color: var(--teal); font-size: 9px; }

.pkg-btn {
  display: flex; align-items: center; justify-content: center; gap: 8px;
  width: 100%; padding: 12px;
  background: var(--orange); color: #fff; border: none;
  border-radius: 10px; font-family: 'DM Sans', sans-serif;
  font-size: 14px; font-weight: 600; cursor: pointer; transition: background .2s, transform .15s;
}
.pkg-btn:hover { background: #CF5D18; transform: translateY(-1px); }

/* ──────────── PROMO BANNER ──────────── */
.promo-banner {
  background: linear-gradient(135deg, #1B3A4B 0%, #0F5068 50%, #1B4A3A 100%);
  border-radius: 20px; padding: 3.5rem 3rem;
  display: grid; grid-template-columns: 1fr auto;
  align-items: center; gap: 2rem; position: relative; overflow: hidden;
}
.promo-banner::before {
  content:''; position:absolute; width:420px; height:420px; border-radius:50%;
  background: rgba(232,107,36,.12); right:-80px; top:-130px; pointer-events:none;
}
.promo-banner::after {
  content:''; position:absolute; width:200px; height:200px; border-radius:50%;
  background: rgba(20,168,196,.1); left:42%; bottom:-60px; pointer-events:none;
}
.promo-tag {
  display: inline-flex; align-items: center; gap: 6px;
  font-size: 10px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
  color: var(--orange2); margin-bottom: .7rem;
}
.promo-tag::before { content:''; width:16px; height:2px; background:var(--orange2); border-radius:2px; }
.promo-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(1.5rem,2.5vw,2.2rem); font-weight: 700;
  color: #fff; line-height: 1.18; margin-bottom: .8rem;
}
.promo-desc { font-size: 14px; color: rgba(255,255,255,.65); line-height: 1.75; max-width: 520px; }
.promo-actions { display: flex; flex-direction: column; gap: 10px; align-items: flex-end; }
.btn-promo-primary {
  background: var(--orange); color: #fff; border: none;
  padding: 14px 28px; border-radius: 10px;
  font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 600;
  cursor: pointer; white-space: nowrap; transition: background .2s, transform .15s;
}
.btn-promo-primary:hover { background: #CF5D18; transform: translateY(-1px); }
.btn-promo-ghost {
  background: rgba(255,255,255,.1); color: rgba(255,255,255,.8);
  border: 1px solid rgba(255,255,255,.2);
  padding: 11px 22px; border-radius: 10px;
  font-family: 'DM Sans', sans-serif; font-size: 13px;
  cursor: pointer; white-space: nowrap; transition: background .2s; text-align: center;
}
.btn-promo-ghost:hover { background: rgba(255,255,255,.18); }

/* ──────────── SHOWCASE GRID ──────────── */
.showcase-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 16px;
}
.showcase-item {
  background: var(--white); border: 1.5px solid var(--border);
  border-radius: 14px; padding: 1.4rem;
  transition: all .22s; cursor: pointer; position: relative;
}
.showcase-item:hover {
  border-color: rgba(232,107,36,.3);
  box-shadow: 0 8px 28px rgba(0,0,0,.07);
  transform: translateY(-3px);
}
.showcase-badge {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: 10px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
  padding: 4px 10px; border-radius: 10px; margin-bottom: 10px;
}
.showcase-badge.quebec { background: #FFF0EE; color: var(--maple); border: 1px solid rgba(193,55,42,.2); }
.showcase-badge.europe { background: #EEF3FA; color: var(--globe); border: 1px solid rgba(46,109,164,.2); }
.showcase-title {
  font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 700;
  margin-bottom: 6px; line-height: 1.25; color: var(--text);
}
.showcase-desc { font-size: 12.5px; color: var(--muted); line-height: 1.6; margin-bottom: 14px; }
.showcase-footer {
  display: flex; align-items: center; justify-content: space-between;
  border-top: 1px solid var(--border); padding-top: 12px;
}
.showcase-price {
  font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; color: var(--orange);
}
.showcase-price small { font-family: 'DM Sans', sans-serif; font-size: 11px; color: var(--muted); font-weight: 400; margin-left: 2px; }
.showcase-details {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: 12px; font-weight: 600; color: var(--teal);
  background: rgba(27,122,140,.08); border: 1px solid rgba(27,122,140,.2);
  padding: 6px 12px; border-radius: 8px; transition: background .2s;
}
.showcase-details:hover { background: rgba(27,122,140,.15); }

/* ──────────── CREATION SECTION ──────────── */
.creation-wrap {
  display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: start;
}

/* Slider */
.creation-slider {
  position: relative; border-radius: 18px; overflow: hidden;
  aspect-ratio: 16/10; margin-bottom: 2rem;
}
.creation-slide { position: absolute; inset: 0; opacity: 0; transition: opacity .6s ease; }
.creation-slide.active { opacity: 1; position: relative; }
.creation-slide img { width: 100%; height: 100%; object-fit: cover; }
.slide-dots {
  position: absolute; bottom: 14px; left: 50%; transform: translateX(-50%);
  display: flex; gap: 6px;
}
.slide-dot {
  width: 8px; height: 8px; border-radius: 50%;
  background: rgba(255,255,255,.45); border: none; cursor: pointer; transition: background .2s, transform .2s;
}
.slide-dot.active { background: #fff; transform: scale(1.25); }

.creation-info-text h3 {
  font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700;
  margin-bottom: .7rem; line-height: 1.2;
}
.creation-info-text p { font-size: 14px; color: var(--muted); line-height: 1.7; margin-bottom: 1.4rem; }
.features-list { list-style: none; display: flex; flex-direction: column; gap: 9px; }
.features-list li {
  display: flex; align-items: center; gap: 10px;
  font-size: 14px; color: var(--mid); font-weight: 500;
}
.features-list li i { color: var(--teal); font-size: 14px; flex-shrink: 0; }

/* Form */
.creation-form-card {
  background: var(--white); border: 1.5px solid var(--border);
  border-radius: 20px; padding: 2.2rem; box-shadow: 0 8px 40px rgba(0,0,0,.06);
}
.creation-form-card h3 {
  font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700;
  margin-bottom: 1.5rem;
}
.form-group { margin-bottom: 1.1rem; }
.form-group label {
  display: block; font-size: 12px; font-weight: 600;
  color: var(--muted); text-transform: uppercase; letter-spacing: .05em;
  margin-bottom: 5px;
}
.form-group input,
.form-group select,
.form-group textarea {
  width: 100%; padding: 11px 14px;
  border: 1.5px solid var(--border); border-radius: 10px;
  font-family: 'DM Sans', sans-serif; font-size: 14px; color: var(--text);
  background: var(--bg); transition: border-color .2s;
  outline: none;
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus { border-color: var(--orange); background: #fff; }
.form-group textarea { resize: vertical; min-height: 90px; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.btn-create {
  width: 100%; padding: 13px;
  background: var(--orange); color: #fff; border: none; border-radius: 12px;
  font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 700;
  cursor: pointer; transition: background .2s, transform .15s;
  display: flex; align-items: center; justify-content: center; gap: 9px;
  margin-top: 1rem;
}
.btn-create:hover { background: #CF5D18; transform: translateY(-1px); }

/* ──────────── PILLARS ──────────── */
.pillars-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 0; }
.pillar {
  padding: 2.4rem 2rem;
  border-right: 1px solid var(--border);
  border-bottom: 1px solid var(--border);
}
.pillar:nth-child(3n) { border-right: none; }
.pillar:nth-child(n+4) { border-bottom: none; }
.pillar-icon {
  width: 52px; height: 52px; border-radius: 14px;
  background: var(--bg); border: 1px solid var(--border);
  display: flex; align-items: center; justify-content: center;
  font-size: 22px; color: var(--orange); margin-bottom: 1.1rem;
}
.pillar-title { font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; color: var(--text); margin-bottom: .4rem; }
.pillar-desc { font-size: 13.5px; color: var(--muted); line-height: 1.7; }

/* ──────────── TESTIMONIALS ──────────── */
.testimonials-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px,1fr)); gap: 20px; }
.testimonial-card {
  background: var(--white); border: 1.5px solid var(--border);
  border-radius: 16px; padding: 1.6rem; position: relative; overflow: hidden;
}
.testimonial-card::before {
  content: '\201C';
  position: absolute; top: -10px; right: 16px;
  font-size: 6rem; font-family: 'Playfair Display',serif;
  color: rgba(232,107,36,.1); line-height: 1; pointer-events: none;
}
.testimonial-stars { color: #F5A623; font-size: 13px; margin-bottom: 10px; }
.testimonial-text { font-size: 13.5px; color: var(--mid); line-height: 1.7; margin-bottom: 1.1rem; }
.testimonial-author { display: flex; align-items: center; gap: 10px; }
.testimonial-avatar {
  width: 40px; height: 40px; border-radius: 50%;
  background: var(--bg); border: 1.5px solid var(--border);
  display: flex; align-items: center; justify-content: center;
  font-weight: 700; font-size: 14px; color: var(--orange); flex-shrink: 0;
}
.testimonial-name { font-size: 14px; font-weight: 600; color: var(--text); }
.testimonial-trip { font-size: 11px; color: var(--muted); margin-top: 1px; }

/* ──────────── FOOTER CTA ──────────── */
.footer-cta {
  background: var(--dark); padding: 5rem 0; text-align: center; color: #fff;
}
.footer-cta-eyebrow {
  font-size: 11px; font-weight: 700; letter-spacing: .12em;
  text-transform: uppercase; color: var(--orange2); margin-bottom: 1rem;
}
.footer-cta-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2rem,4vw,3.2rem); font-weight: 900;
  line-height: 1.1; margin-bottom: 1.2rem;
}
.footer-cta-title em { font-style: italic; color: var(--orange2); }
.footer-cta-sub {
  font-size: 15px; color: rgba(255,255,255,.6); line-height: 1.75;
  max-width: 540px; margin: 0 auto 2.5rem;
}
.footer-cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

/* ──────────── FOOTER ──────────── */
.footer { background: #0A0F14; padding: 2.5rem 0; border-top: 1px solid rgba(255,255,255,.06); }
.footer-inner {
  width: 100%; max-width: 1400px; margin: 0 auto; padding: 0 2rem;
  display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
}
.footer-brand { display: flex; align-items: center; gap: 10px; }
.footer-brand img { height: 28px; }
.footer-brand-name { font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; color: rgba(255,255,255,.8); }
.footer-copy { font-size: 12px; color: rgba(255,255,255,.4); }
.footer-links { display: flex; gap: 20px; list-style: none; }
.footer-links a { font-size: 12px; color: rgba(255,255,255,.4); transition: color .2s; }
.footer-links a:hover { color: var(--orange2); }

/* ──────────── RESPONSIVE ──────────── */
@media (max-width: 1100px) {
  .creation-wrap { grid-template-columns: 1fr; }
  .pillars-grid { grid-template-columns: 1fr 1fr; }
  .pillar:nth-child(2n) { border-right: none; }
  .pillar:nth-child(n+3) { border-bottom: none; }
}
@media (max-width: 768px) {
  .hero-content { padding: 0 1.5rem; }
  .hero-stats-inner { padding: 0 1.5rem; flex-wrap: wrap; }
  .hero-stat { min-width: 50%; border-right: none; border-bottom: 1px solid rgba(255,255,255,.08); }
  .nav-links { display: none; }
  .packages-grid { grid-template-columns: 1fr; }
  .promo-banner { grid-template-columns: 1fr; }
  .promo-actions { align-items: stretch; }
  .pillars-grid { grid-template-columns: 1fr; }
  .pillar { border-right: none; }
  .form-grid { grid-template-columns: 1fr; }
  .container { padding: 0 1rem; }
}
</style>
</head>
<body>

<!-- ══════════════ NAV ══════════════ -->
<nav class="nav">
  <div class="nav-inner">
    <div class="nav-logo">
      <img src="logo.png" alt="GoExploria" onerror="this.style.display='none'" style="height:60px;">
    </div>
    <ul class="nav-links">
      <li><a href="#">Destinations</a></li>
      <li><a href="#">Forfaits</a></li>
      <li><a href="#">Événements</a></li>
      <li><a href="#">Expériences</a></li>
      <li><a href="#">Gastronomie</a></li>
    </ul>
    <button class="nav-cta">Réserver maintenant &nbsp;→</button>
  </div>
</nav>

<!-- ══════════════ HERO ══════════════ -->
<section class="hero">
  <div class="hero-bg" id="heroBg"></div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">Forfaits exclusifs 2025</div>
    <h1 class="hero-title">
      Affichez vos forfaits<br><em>ici — GoExploria</em>
    </h1>
    <p class="hero-sub">
      Québec · Canada · Amérique du Nord — Découvrez les plus belles destinations sublimées par l'expertise GoExploria. Des expériences sur mesure, des prix imbattables.
    </p>
    <div class="hero-actions">
      <button class="btn-primary"><i class="fas fa-suitcase-rolling"></i> Explorer les forfaits</button>
      <button class="btn-ghost"><i class="fas fa-play-circle"></i> Voir la vidéo</button>
    </div>
  </div>
  <div class="hero-stats">
    <div class="hero-stats-inner">
      <div class="hero-stat"><div class="hero-stat-num">6+</div><div class="hero-stat-label">Forfaits sélectionnés</div></div>
      <div class="hero-stat"><div class="hero-stat-num">2</div><div class="hero-stat-label">Régions disponibles</div></div>
      <div class="hero-stat"><div class="hero-stat-num">4★</div><div class="hero-stat-label">Hébergements</div></div>
      <div class="hero-stat"><div class="hero-stat-num">24/7</div><div class="hero-stat-label">Support conciergerie</div></div>
      <div class="hero-stat"><div class="hero-stat-num">100%</div><div class="hero-stat-label">Sur mesure</div></div>
    </div>
  </div>
</section>

<!-- ══════════════ DEST BAR ══════════════ -->
<div class="dest-bar">
  <div class="dest-bar-inner">
    <div class="dest-icon"><i class="fas fa-map-marker-alt"></i> Destinations</div>
    <div class="dest-selects">
      <select class="dest-select">
        <option>Amérique du Nord</option>
        <option>Europe</option>
        <option>Asie</option>
        <option>Afrique</option>
      </select>
      <span class="dest-sep">/</span>
      <select class="dest-select">
        <option>Canada</option>
        <option>États-Unis</option>
        <option>France</option>
        <option>Italie</option>
        <option>Islande</option>
      </select>
      <span class="dest-sep">/</span>
      <select class="dest-select">
        <option>Québec</option>
        <option>Ontario</option>
        <option>Alberta</option>
        <option>Colombie-Britannique</option>
      </select>
      <span class="dest-sep">/</span>
      <select class="dest-select">
        <option>Région de Québec</option>
        <option>Montréal Métro</option>
        <option>Gaspésie</option>
        <option>Charlevoix</option>
        <option>Laurentides</option>
      </select>
    </div>
  </div>
</div>

<!-- ══════════════ FILTER BAR ══════════════ -->
<div class="filter-bar">
  <div class="filter-bar-inner">
    <button class="filter-btn active" data-filter="all"><i class="fas fa-th-large"></i> Toutes les options</button>
    <button class="filter-btn" data-filter="escapades"><i class="fas fa-route"></i> Escapades</button>
    <button class="filter-btn" data-filter="voyages"><i class="fas fa-plane"></i> Voyages</button>
    <button class="filter-btn" data-filter="promotions"><i class="fas fa-tag"></i> Promotions</button>
    <button class="filter-btn" data-filter="luxe"><i class="fas fa-crown"></i> Luxe & VIP</button>
  </div>
</div>

<!-- ══════════════ FORFAITS QUÉBEC ══════════════ -->
<section class="section">
  <div class="container">
    <div class="pkg-category-block">
      <div class="pkg-cat-icon quebec"><i class="fas fa-leaf"></i></div>
      <div class="pkg-cat-titles">
        <h2 class="pkg-cat-title">Forfaits Québec</h2>
        <p class="pkg-cat-subtitle">Découvrez la Belle Province — nature, culture et gastronomie</p>
      </div>
      <span class="pkg-cat-count">3 forfaits</span>
    </div>

    <div class="packages-grid" id="grid-quebec">

      <!-- Card 1 -->
      <article class="package-card" data-filter="escapades">
        <div class="package-image">
          <img src="https://images.pexels.com/photos/2499786/pexels-photo-2499786.jpeg?auto=compress&cs=tinysrgb&w=800&h=500&dpr=1" alt="Montréal & Québec">
          <div class="package-badge pkg-badge--popular">Populaire</div>
          <div class="package-price-ribbon">$1 899 <small>/pers.</small></div>
        </div>
        <div class="package-content">
          <h3 class="package-title">Escapade Montréal &amp; Québec</h3>
          <div class="package-location"><i class="fas fa-map-marker-alt"></i> Montréal, Québec</div>
          <p class="package-desc">Séjour de 5 jours dans les plus belles villes du Québec. Visites guidées, gastronomie locale et hébergement 4 étoiles inclus.</p>
          <div class="package-features">
            <span class="package-feature"><i class="fas fa-check"></i> Culture</span>
            <span class="package-feature"><i class="fas fa-check"></i> Gastronomie</span>
            <span class="package-feature"><i class="fas fa-check"></i> Histoire</span>
          </div>
          <button class="pkg-btn"><i class="fas fa-calendar-check"></i> Voir le forfait</button>
        </div>
      </article>

      <!-- Card 2 -->
      <article class="package-card" data-filter="escapades">
        <div class="package-image">
          <img src="https://images.pexels.com/photos/4276490/pexels-photo-4276490.jpeg?auto=compress&cs=tinysrgb&w=800&h=500&dpr=1" alt="Aventure Gaspésie">
          <div class="package-badge pkg-badge--new">Nouveau</div>
          <div class="package-price-ribbon">$2 199 <small>/pers.</small></div>
        </div>
        <div class="package-content">
          <h3 class="package-title">Aventure Gaspésie</h3>
          <div class="package-location"><i class="fas fa-map-marker-alt"></i> Gaspé, Québec</div>
          <p class="package-desc">Parc national Forillon, observation des baleines, randonnée et découverte du Rocher Percé au cœur de la nature sauvage.</p>
          <div class="package-features">
            <span class="package-feature"><i class="fas fa-check"></i> Nature</span>
            <span class="package-feature"><i class="fas fa-check"></i> Aventure</span>
            <span class="package-feature"><i class="fas fa-check"></i> Faune</span>
          </div>
          <button class="pkg-btn"><i class="fas fa-calendar-check"></i> Voir le forfait</button>
        </div>
      </article>

      <!-- Card 3 -->
      <article class="package-card" data-filter="promotions">
        <div class="package-image">
          <img src="https://images.pexels.com/photos/848599/pexels-photo-848599.jpeg?auto=compress&cs=tinysrgb&w=800&h=500&dpr=1" alt="Ski & Spa Charlevoix">
          <div class="package-badge pkg-badge--luxe">Luxe</div>
          <div class="package-price-ribbon">$2 499 <small>/pers.</small></div>
        </div>
        <div class="package-content">
          <h3 class="package-title">Ski &amp; Spa Charlevoix</h3>
          <div class="package-location"><i class="fas fa-map-marker-alt"></i> Charlevoix, Québec</div>
          <p class="package-desc">Forfait ski dans les Laurentides avec hébergement luxueux, accès au spa nordique et gastronomie régionale d'exception.</p>
          <div class="package-features">
            <span class="package-feature"><i class="fas fa-check"></i> Sport</span>
            <span class="package-feature"><i class="fas fa-check"></i> Bien-être</span>
            <span class="package-feature"><i class="fas fa-check"></i> Luxe</span>
          </div>
          <button class="pkg-btn"><i class="fas fa-calendar-check"></i> Voir le forfait</button>
        </div>
      </article>

    </div>
  </div>
</section>

<!-- ══════════════ PROMO BANNER ══════════════ -->
<section class="section alt">
  <div class="container">
    <div class="promo-banner">
      <div>
        <div class="promo-tag">Offre exclusive GoExploria</div>
        <h2 class="promo-title">Vivez l'expérience<br>que vous méritez vraiment</h2>
        <p class="promo-desc">Billets prioritaires, loges VIP et forfaits personnalisés conçus par nos experts. Un service conciergerie dédié, disponible 24h/24 pour transformer chaque voyage en souvenir inoubliable.</p>
      </div>
      <div class="promo-actions">
        <button class="btn-promo-primary"><i class="fas fa-crown"></i> &nbsp;Offres VIP GoExploria</button>
        <button class="btn-promo-ghost">En savoir plus →</button>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════ FORFAITS EUROPE ══════════════ -->
<section class="section">
  <div class="container">
    <div class="pkg-category-block">
      <div class="pkg-cat-icon europe"><i class="fas fa-globe-europe"></i></div>
      <div class="pkg-cat-titles">
        <h2 class="pkg-cat-title">Forfaits Europe</h2>
        <p class="pkg-cat-subtitle">Voyagez à travers les plus belles destinations européennes</p>
      </div>
      <span class="pkg-cat-count">3 forfaits</span>
    </div>

    <div class="packages-grid" id="grid-europe">

      <!-- Card 4 -->
      <article class="package-card" data-filter="voyages">
        <div class="package-image">
          <img src="https://images.pexels.com/photos/338515/pexels-photo-338515.jpeg?auto=compress&cs=tinysrgb&w=800&h=500&dpr=1" alt="Paris">
          <div class="package-badge pkg-badge--couple">Couple</div>
          <div class="package-price-ribbon">$2 899 <small>/pers.</small></div>
        </div>
        <div class="package-content">
          <h3 class="package-title">Romantique Paris</h3>
          <div class="package-location"><i class="fas fa-map-marker-alt"></i> Paris, France</div>
          <p class="package-desc">Week-end romantique à Paris avec croisière sur la Seine, dîner gastronomique et visite des monuments emblématiques.</p>
          <div class="package-features">
            <span class="package-feature"><i class="fas fa-check"></i> Romantique</span>
            <span class="package-feature"><i class="fas fa-check"></i> Culture</span>
            <span class="package-feature"><i class="fas fa-check"></i> Gastronomie</span>
          </div>
          <button class="pkg-btn"><i class="fas fa-calendar-check"></i> Voir le forfait</button>
        </div>
      </article>

      <!-- Card 5 -->
      <article class="package-card" data-filter="voyages">
        <div class="package-image">
          <img src="https://images.pexels.com/photos/1571442/pexels-photo-1571442.jpeg?auto=compress&cs=tinysrgb&w=800&h=500&dpr=1" alt="Toscane">
          <div class="package-badge pkg-badge--exclusif">Exclusif</div>
          <div class="package-price-ribbon">$3 299 <small>/pers.</small></div>
        </div>
        <div class="package-content">
          <h3 class="package-title">Route des Vins Toscane</h3>
          <div class="package-location"><i class="fas fa-map-marker-alt"></i> Toscane, Italie</div>
          <p class="package-desc">Circuit œnologique dans les plus beaux domaines viticoles toscans. Dégustations, ateliers et hébergement dans un agriturismo authentique.</p>
          <div class="package-features">
            <span class="package-feature"><i class="fas fa-check"></i> Vin</span>
            <span class="package-feature"><i class="fas fa-check"></i> Gastronomie</span>
            <span class="package-feature"><i class="fas fa-check"></i> Détente</span>
          </div>
          <button class="pkg-btn"><i class="fas fa-calendar-check"></i> Voir le forfait</button>
        </div>
      </article>

      <!-- Card 6 -->
      <article class="package-card" data-filter="promotions">
        <div class="package-image">
          <img src="https://images.pexels.com/photos/1933239/pexels-photo-1933239.jpeg?auto=compress&cs=tinysrgb&w=800&h=500&dpr=1" alt="Islande">
          <div class="package-badge pkg-badge--top">Incontournable</div>
          <div class="package-price-ribbon">$3 999 <small>/pers.</small></div>
        </div>
        <div class="package-content">
          <h3 class="package-title">Aurores Boréales Islande</h3>
          <div class="package-location"><i class="fas fa-map-marker-alt"></i> Reykjavik, Islande</div>
          <p class="package-desc">Chasse aux aurores boréales, bains géothermiques et découverte des paysages lunaires islandais dans un décor hors du commun.</p>
          <div class="package-features">
            <span class="package-feature"><i class="fas fa-check"></i> Aventure</span>
            <span class="package-feature"><i class="fas fa-check"></i> Nordique</span>
            <span class="package-feature"><i class="fas fa-check"></i> Photographie</span>
          </div>
          <button class="pkg-btn"><i class="fas fa-calendar-check"></i> Voir le forfait</button>
        </div>
      </article>

    </div>
  </div>
</section>

<!-- ══════════════ SHOWCASE COMPACT ══════════════ -->
<section class="section alt">
  <div class="container">
    <div class="sec-header">
      <div>
        <div class="sec-label"><i class="fas fa-eye"></i> Vue d'ensemble</div>
        <h2 class="sec-title">Tous vos forfaits en un coup d'œil</h2>
      </div>
      <a href="#" class="sec-link">Voir tout <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="showcase-grid">

      <div class="showcase-item">
        <span class="showcase-badge quebec"><i class="fas fa-leaf"></i> Québec</span>
        <div class="showcase-title">Escapade Montréal &amp; Québec</div>
        <div class="showcase-desc">Séjour de 5 jours dans les plus belles villes du Québec. Visites guidées...</div>
        <div class="showcase-footer">
          <div class="showcase-price">$1 899 <small>/pers.</small></div>
          <a href="#" class="showcase-details"><i class="fas fa-eye"></i> Voir détails</a>
        </div>
      </div>

      <div class="showcase-item">
        <span class="showcase-badge quebec"><i class="fas fa-leaf"></i> Québec</span>
        <div class="showcase-title">Aventure Gaspésie</div>
        <div class="showcase-desc">Parc national Forillon, observation des baleines, randonnée et Rocher Percé...</div>
        <div class="showcase-footer">
          <div class="showcase-price">$2 199 <small>/pers.</small></div>
          <a href="#" class="showcase-details"><i class="fas fa-eye"></i> Voir détails</a>
        </div>
      </div>

      <div class="showcase-item">
        <span class="showcase-badge quebec"><i class="fas fa-leaf"></i> Québec</span>
        <div class="showcase-title">Ski &amp; Spa Charlevoix</div>
        <div class="showcase-desc">Forfait ski dans les Laurentides avec hébergement luxueux et spa nordique...</div>
        <div class="showcase-footer">
          <div class="showcase-price">$2 499 <small>/pers.</small></div>
          <a href="#" class="showcase-details"><i class="fas fa-eye"></i> Voir détails</a>
        </div>
      </div>

      <div class="showcase-item">
        <span class="showcase-badge europe"><i class="fas fa-globe-europe"></i> Europe</span>
        <div class="showcase-title">Romantique Paris</div>
        <div class="showcase-desc">Week-end romantique avec croisière sur la Seine et dîner gastronomique...</div>
        <div class="showcase-footer">
          <div class="showcase-price">$2 899 <small>/pers.</small></div>
          <a href="#" class="showcase-details"><i class="fas fa-eye"></i> Voir détails</a>
        </div>
      </div>

      <div class="showcase-item">
        <span class="showcase-badge europe"><i class="fas fa-globe-europe"></i> Europe</span>
        <div class="showcase-title">Route des Vins Toscane</div>
        <div class="showcase-desc">Circuit œnologique dans les plus beaux domaines viticoles toscans...</div>
        <div class="showcase-footer">
          <div class="showcase-price">$3 299 <small>/pers.</small></div>
          <a href="#" class="showcase-details"><i class="fas fa-eye"></i> Voir détails</a>
        </div>
      </div>

      <div class="showcase-item">
        <span class="showcase-badge europe"><i class="fas fa-globe-europe"></i> Europe</span>
        <div class="showcase-title">Aurores Boréales Islande</div>
        <div class="showcase-desc">Chasse aux aurores boréales, bains géothermiques et paysages lunaires...</div>
        <div class="showcase-footer">
          <div class="showcase-price">$3 999 <small>/pers.</small></div>
          <a href="#" class="showcase-details"><i class="fas fa-eye"></i> Voir détails</a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════ CREATION SECTION ══════════════ -->
<section class="section">
  <div class="container">
    <div class="sec-header">
      <div>
        <div class="sec-label"><i class="fas fa-magic"></i> Création personnalisée</div>
        <h2 class="sec-title">Créez votre forfait sur mesure</h2>
      </div>
    </div>

    <div class="creation-wrap">
      <!-- Left: slider + info -->
      <div>
        <div class="creation-slider" id="creationSlider">
          <div class="creation-slide active">
            <img src="https://images.pexels.com/photos/2325446/pexels-photo-2325446.jpeg?auto=compress&cs=tinysrgb&w=700&h=430&dpr=1" alt="Destinations">
          </div>
          <div class="creation-slide">
            <img src="https://images.pexels.com/photos/3155666/pexels-photo-3155666.jpeg?auto=compress&cs=tinysrgb&w=700&h=430&dpr=1" alt="Voyages">
          </div>
          <div class="creation-slide">
            <img src="https://images.pexels.com/photos/1371360/pexels-photo-1371360.jpeg?auto=compress&cs=tinysrgb&w=700&h=430&dpr=1" alt="Aventures">
          </div>
          <div class="slide-dots">
            <button class="slide-dot active" data-slide="0" aria-label="Slide 1"></button>
            <button class="slide-dot" data-slide="1" aria-label="Slide 2"></button>
            <button class="slide-dot" data-slide="2" aria-label="Slide 3"></button>
          </div>
        </div>

        <div class="creation-info-text">
          <h3>Composez le voyage de vos rêves</h3>
          <p>Sélectionnez vos destinations, activités et hébergements préférés. Notre équipe conciergerie s'occupe de tout pour vous offrir une expérience inoubliable.</p>
          <ul class="features-list">
            <li><i class="fas fa-check-circle"></i> Choix illimité de destinations</li>
            <li><i class="fas fa-check-circle"></i> Activités sur mesure</li>
            <li><i class="fas fa-check-circle"></i> Hébergements premium 4 et 5 étoiles</li>
            <li><i class="fas fa-check-circle"></i> Devis instantané et gratuit</li>
            <li><i class="fas fa-check-circle"></i> Support personnalisé 24/7</li>
          </ul>
        </div>
      </div>

      <!-- Right: form -->
      <div class="creation-form-card">
        <h3>Nouveau forfait</h3>
        <form id="package-creation-form" onsubmit="handleFormSubmit(event)">
          <div class="form-group">
            <label for="pkg-title">Titre du forfait</label>
            <input type="text" id="pkg-title" placeholder="Ex : Escapade à Montréal">
          </div>
          <div class="form-grid">
            <div class="form-group">
              <label for="pkg-cat">Catégorie</label>
              <select id="pkg-cat">
                <option value="">Sélectionnez</option>
                <option value="quebec">Québec</option>
                <option value="europe">Europe</option>
                <option value="amerique">Amérique du Nord</option>
                <option value="asie">Asie</option>
              </select>
            </div>
            <div class="form-group">
              <label for="pkg-type">Type</label>
              <select id="pkg-type">
                <option value="">Sélectionnez</option>
                <option value="escapade">Escapade</option>
                <option value="voyage">Voyage</option>
                <option value="luxe">Luxe & VIP</option>
                <option value="promo">Promotion</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="pkg-dest">Destination</label>
            <input type="text" id="pkg-dest" placeholder="Ville, Pays">
          </div>
          <div class="form-grid">
            <div class="form-group">
              <label for="pkg-price-input">Prix (par pers.)</label>
              <input type="number" id="pkg-price-input" placeholder="1 899">
            </div>
            <div class="form-group">
              <label for="pkg-duration">Durée (jours)</label>
              <input type="number" id="pkg-duration" placeholder="5">
            </div>
          </div>
          <div class="form-group">
            <label for="pkg-desc">Description</label>
            <textarea id="pkg-desc" placeholder="Décrivez votre forfait en quelques mots..."></textarea>
          </div>
          <button type="submit" class="btn-create">
            <i class="fas fa-magic"></i> Créer le forfait
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════ PILLARS ══════════════ -->
<section class="section alt">
  <div class="container">
    <div class="sec-header">
      <div>
        <div class="sec-label"><i class="fas fa-shield-alt"></i> Pourquoi GoExploria</div>
        <h2 class="sec-title">L'excellence au service de votre voyage</h2>
      </div>
    </div>
    <div style="border: 1.5px solid var(--border); border-radius: 18px; overflow: hidden;">
      <div class="pillars-grid">
        <div class="pillar">
          <div class="pillar-icon"><i class="fas fa-star"></i></div>
          <div class="pillar-title">Sélection d'experts</div>
          <div class="pillar-desc">Chaque forfait est conçu et validé par nos experts locaux. Qualité, authenticité et valeur garanties à chaque réservation.</div>
        </div>
        <div class="pillar">
          <div class="pillar-icon"><i class="fas fa-ticket-alt"></i></div>
          <div class="pillar-title">Accès prioritaire VIP</div>
          <div class="pillar-desc">Profitez d'un accès exclusif aux meilleures expériences, en avant-première. Nos partenariats vous ouvrent des portes uniques.</div>
        </div>
        <div class="pillar">
          <div class="pillar-icon"><i class="fas fa-concierge-bell"></i></div>
          <div class="pillar-title">Conciergerie 24/7</div>
          <div class="pillar-desc">De la réservation à l'hébergement, notre équipe prend en charge chaque détail pour que vous profitiez pleinement.</div>
        </div>
        <div class="pillar">
          <div class="pillar-icon"><i class="fas fa-shield-alt"></i></div>
          <div class="pillar-title">Garantie remboursement</div>
          <div class="pillar-desc">Annulation flexible jusqu'à 48h avant le départ. Votre tranquillité d'esprit est notre priorité absolue.</div>
        </div>
        <div class="pillar">
          <div class="pillar-icon"><i class="fas fa-hand-holding-usd"></i></div>
          <div class="pillar-title">Meilleur prix garanti</div>
          <div class="pillar-desc">Nous nous alignons sur tout prix inférieur trouvé ailleurs. La promesse GoExploria : la meilleure offre, toujours.</div>
        </div>
        <div class="pillar">
          <div class="pillar-icon"><i class="fas fa-map-marked-alt"></i></div>
          <div class="pillar-title">Expériences locales</div>
          <div class="pillar-desc">Des guides locaux passionnés vous font découvrir l'authentique, loin des sentiers battus et des circuits touristiques classiques.</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════ TESTIMONIALS ══════════════ -->
<section class="section">
  <div class="container">
    <div class="sec-header">
      <div>
        <div class="sec-label"><i class="fas fa-comment-dots"></i> Témoignages</div>
        <h2 class="sec-title">Ils ont vécu l'expérience GoExploria</h2>
      </div>
    </div>
    <div class="testimonials-grid">

      <div class="testimonial-card">
        <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
        <p class="testimonial-text">Une expérience absolument inoubliable ! Le forfait Gaspésie était parfaitement organisé, les hébergements magnifiques et le guide exceptionnel. Je recommande GoExploria à 100%.</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">ML</div>
          <div>
            <div class="testimonial-name">Marie-Laure Dupont</div>
            <div class="testimonial-trip">Aventure Gaspésie · Juin 2025</div>
          </div>
        </div>
      </div>

      <div class="testimonial-card">
        <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
        <p class="testimonial-text">Le forfait Paris romantique a dépassé toutes nos attentes. Chaque détail était soigné, du restaurant gastronomique au bateau sur la Seine. Un voyage de rêve pour nos 10 ans de mariage.</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">PT</div>
          <div>
            <div class="testimonial-name">Pierre &amp; Thérèse Gagnon</div>
            <div class="testimonial-trip">Romantique Paris · Mai 2025</div>
          </div>
        </div>
      </div>

      <div class="testimonial-card">
        <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
        <p class="testimonial-text">Les aurores boréales en Islande, c'est magique. GoExploria a tout prévu : le lodge isolé, le photographe professionnel, les bains géothermiques. Une aventure qui change la vie !</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">JF</div>
          <div>
            <div class="testimonial-name">Jean-François Morin</div>
            <div class="testimonial-trip">Aurores Boréales Islande · Fév. 2025</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════ FOOTER CTA ══════════════ -->
<div class="footer-cta">
  <div class="container">
    <div class="footer-cta-eyebrow">Prêt à partir ?</div>
    <h2 class="footer-cta-title">Votre aventure commence<br><em>ici avec GoExploria</em></h2>
    <p class="footer-cta-sub">Des forfaits exclusifs, des expériences sur mesure et une équipe dédiée pour rendre chaque voyage inoubliable. Réservez dès aujourd'hui.</p>
    <div class="footer-cta-btns">
      <button class="btn-primary" style="font-size:15px;padding:15px 34px;">
        <i class="fas fa-suitcase-rolling"></i> Explorer tous les forfaits
      </button>
      <button class="btn-ghost" style="font-size:15px;padding:15px 30px;">
        <i class="fas fa-phone-alt"></i> Parler à un conseiller
      </button>
    </div>
  </div>
</div>

<!-- ══════════════ FOOTER ══════════════ -->
<footer class="footer">
  <div class="footer-inner">
    <div class="footer-brand">
      <img src="logo.png" alt="GoExploria" onerror="this.style.display='none'">
      <span class="footer-brand-name">GoExploria</span>
    </div>
    <span class="footer-copy">© 2025 GoExploria. Tous droits réservés.</span>
    <ul class="footer-links">
      <li><a href="#">Confidentialité</a></li>
      <li><a href="#">Conditions</a></li>
      <li><a href="#">Contact</a></li>
      <li><a href="#">Partenaires</a></li>
    </ul>
  </div>
</footer>

<script>
  // Hero BG zoom
  window.addEventListener('load', () => {
    const bg = document.getElementById('heroBg');
    if (bg) bg.classList.add('loaded');
  });

  // Filter buttons
  document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const f = btn.dataset.filter;
      document.querySelectorAll('.package-card').forEach(card => {
        card.style.display = (f === 'all' || card.dataset.filter === f) ? '' : 'none';
      });
    });
  });

  // Creation slider
  (function () {
    const slider = document.getElementById('creationSlider');
    if (!slider) return;
    const slides = slider.querySelectorAll('.creation-slide');
    const dots   = slider.querySelectorAll('.slide-dot');
    let cur = 0;

    function goTo(i) {
      slides[cur].classList.remove('active');
      dots[cur].classList.remove('active');
      cur = (i + slides.length) % slides.length;
      slides[cur].classList.add('active');
      dots[cur].classList.add('active');
    }

    dots.forEach(dot => {
      dot.addEventListener('click', () => goTo(parseInt(dot.dataset.slide)));
    });
    setInterval(() => goTo(cur + 1), 3500);
  })();

  // Form submit
  function handleFormSubmit(e) {
    e.preventDefault();
    const title = document.getElementById('pkg-title').value || 'Nouveau forfait';
    alert('✓ Forfait "' + title + '" créé avec succès ! Notre équipe vous contactera sous 24h.');
    e.target.reset();
  }
</script>
</body>
</html>