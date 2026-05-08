<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Événements Vedette au Québec — GoExploria</title>
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
    --dark:    #12181F;
    --mid:     #2C3540;
    --text:    #1A1F26;
    --muted:   #6B7785;
    --border:  #E4E8ED;
    --bg:      #F7F8FA;
    --white:   #FFFFFF;
    --hero-h:  620px;
  }

  html { scroll-behavior: smooth; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--white);
    color: var(--text);
    overflow-x: hidden;
  }

  img { display: block; max-width: 100%; }
  a { text-decoration: none; color: inherit; }

  /* ──────────────────────────────────────────────
     TOP NAV
  ────────────────────────────────────────────── */
  .nav {
    position: sticky;
    top: 0;
    z-index: 100;
    background: rgba(255,255,255,0.97);
    border-bottom: 1px solid var(--border);
    backdrop-filter: blur(8px);
  }

  .nav-inner {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
  }

  .nav-logo { display: flex; align-items: center; gap: 10px; }
  .nav-logo img { height: 36px; object-fit: contain; }
  .nav-logo-text {
    font-family: 'Playfair Display', serif;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--orange);
  }
  .nav-logo-text span { color: var(--teal); }

  .nav-links {
    display: flex;
    align-items: center;
    gap: 1.8rem;
    list-style: none;
  }
  .nav-links a {
    font-size: 14px;
    font-weight: 500;
    color: var(--mid);
    transition: color .2s;
  }
  .nav-links a:hover { color: var(--orange); }

  .nav-cta {
    background: var(--orange);
    color: #fff;
    border: none;
    padding: 9px 20px;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: background .2s;
  }
  .nav-cta:hover { background: #CF5D18; }

  /* ──────────────────────────────────────────────
     HERO — full-width cinematic
  ────────────────────────────────────────────── */
  .hero {
    position: relative;
    width: 100%;
    height: var(--hero-h);
    overflow: hidden;
  }

  .hero-bg {
    position: absolute;
    inset: 0;
    background-image: url('https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=1800&h=700&fit=crop');
    background-size: cover;
    background-position: center 40%;
    transform: scale(1.04);
    transition: transform 8s ease-out;
  }
  .hero-bg.loaded { transform: scale(1); }

  .hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
      105deg,
      rgba(12,18,26,.82) 0%,
      rgba(12,18,26,.55) 55%,
      rgba(12,18,26,.15) 100%
    );
  }

  .hero-content {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 4rem;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(232,107,36,.18);
    border: 1px solid rgba(232,107,36,.5);
    border-radius: 20px;
    padding: 5px 16px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #FFB380;
    margin-bottom: 1.2rem;
    width: fit-content;
  }

  .hero-eyebrow::before {
    content: '';
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--orange2);
    animation: blink 2s infinite;
  }
  @keyframes blink { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(1.6)} }

  .hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.6rem, 5vw, 4.2rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.06;
    letter-spacing: -.02em;
    margin-bottom: 1.2rem;
    max-width: 720px;
  }
  .hero-title em { font-style: normal; color: var(--orange2); }

  .hero-sub {
    font-size: 1.05rem;
    color: rgba(255,255,255,.75);
    line-height: 1.75;
    max-width: 560px;
    font-weight: 300;
    margin-bottom: 2.2rem;
  }

  .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }

  .btn-primary {
    background: var(--orange);
    color: #fff;
    border: none;
    padding: 14px 30px;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: background .2s, transform .15s;
    display: inline-flex; align-items: center; gap: 8px;
  }
  .btn-primary:hover { background: #CF5D18; transform: translateY(-1px); }

  .btn-ghost {
    background: rgba(255,255,255,.12);
    color: #fff;
    border: 1.5px solid rgba(255,255,255,.35);
    padding: 14px 28px;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: background .2s;
    backdrop-filter: blur(4px);
    display: inline-flex; align-items: center; gap: 8px;
  }
  .btn-ghost:hover { background: rgba(255,255,255,.2); }

  /* HERO STATS STRIP */
  .hero-stats {
    position: absolute;
    bottom: 0;
    left: 0; right: 0;
    background: rgba(12,18,26,.7);
    backdrop-filter: blur(12px);
    border-top: 1px solid rgba(255,255,255,.08);
    z-index: 2;
  }

  .hero-stats-inner {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 4rem;
    display: flex;
    align-items: stretch;
  }

  .hero-stat {
    flex: 1;
    padding: 1.3rem 0;
    text-align: center;
    border-right: 1px solid rgba(255,255,255,.08);
  }
  .hero-stat:last-child { border-right: none; }

  .hero-stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 700;
    color: var(--orange2);
    line-height: 1;
  }
  .hero-stat-label {
    font-size: 11px;
    color: rgba(255,255,255,.55);
    letter-spacing: .05em;
    text-transform: uppercase;
    margin-top: 4px;
  }

  /* ──────────────────────────────────────────────
     DESTINATION BAR
  ────────────────────────────────────────────── */
  .dest-bar {
    background: var(--white);
    border-bottom: 1px solid var(--border);
    padding: 0;
  }

  .dest-bar-inner {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    align-items: center;
    gap: 0;
    height: 56px;
  }

  .dest-icon {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: var(--orange);
    padding-right: 1.5rem;
    border-right: 1px solid var(--border);
    white-space: nowrap;
    flex-shrink: 0;
  }
  .dest-icon img { height: 28px; }

  .dest-selects {
    display: flex;
    align-items: center;
    gap: 4px;
    padding-left: 1.5rem;
    flex-wrap: wrap;
  }

  .dest-sep { font-size: 14px; color: #BBC4CF; padding: 0 4px; }

  .dest-select {
    border: none;
    background: transparent;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 500;
    color: var(--text);
    cursor: pointer;
    padding: 4px 20px 4px 6px;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='7'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23BBC4CF' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 4px center;
    transition: color .2s;
  }
  .dest-select:focus { outline: none; color: var(--orange); }

  /* ──────────────────────────────────────────────
     FILTER BAR
  ────────────────────────────────────────────── */
  .filter-bar {
    background: var(--bg);
    border-bottom: 1px solid var(--border);
    padding: 0;
  }

  .filter-bar-inner {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    align-items: center;
    gap: 6px;
    height: 54px;
    overflow-x: auto;
    scrollbar-width: none;
  }
  .filter-bar-inner::-webkit-scrollbar { display: none; }

  .filter-btn {
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 18px;
    border-radius: 22px;
    border: 1.5px solid var(--border);
    background: var(--white);
    color: var(--muted);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all .2s;
    white-space: nowrap;
  }
  .filter-btn:hover, .filter-btn.active {
    background: var(--orange);
    border-color: var(--orange);
    color: #fff;
  }
  .filter-btn i { font-size: 13px; }

  /* ──────────────────────────────────────────────
     SECTIONS COMMON
  ────────────────────────────────────────────── */
  .section {
    width: 100%;
    padding: 4rem 0;
  }
  .section.alt { background: var(--bg); }
  .section.dark-section {
    background: var(--dark);
    color: #fff;
  }

  .container {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
  }

  .sec-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 2.2rem;
    gap: 1rem;
    flex-wrap: wrap;
  }

  .sec-label {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--orange);
    margin-bottom: 6px;
    display: flex; align-items: center; gap: 6px;
  }
  .sec-label::before {
    content: '';
    width: 18px; height: 2px;
    background: var(--orange);
    border-radius: 2px;
  }

  .sec-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.7rem, 3vw, 2.4rem);
    font-weight: 700;
    line-height: 1.15;
    color: var(--text);
  }
  .dark-section .sec-title { color: #fff; }

  .sec-link {
    font-size: 13px;
    font-weight: 600;
    color: var(--orange);
    display: flex; align-items: center; gap: 5px;
    white-space: nowrap;
    transition: gap .2s;
  }
  .sec-link:hover { gap: 9px; }

  /* ──────────────────────────────────────────────
     FEATURED CARD (large)
  ────────────────────────────────────────────── */
  .featured-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 1.5rem;
    align-items: stretch;
  }

  .feat-card {
    position: relative;
    border-radius: 18px;
    overflow: hidden;
    cursor: pointer;
  }
  .feat-card img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .55s ease;
  }
  .feat-card:hover img { transform: scale(1.05); }

  .feat-card-main { min-height: 460px; }

  .feat-card-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(12,18,26,.92) 0%, rgba(12,18,26,.1) 60%, transparent 100%);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 2rem;
  }

  .feat-badge {
    display: inline-block;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 12px;
    margin-bottom: .7rem;
    width: fit-content;
  }
  .badge-orange { background: var(--orange); color: #fff; }
  .badge-teal   { background: var(--teal); color: #fff; }
  .badge-gold   { background: var(--gold); color: #fff; }

  .feat-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.2rem, 2vw, 1.7rem);
    font-weight: 700;
    color: #fff;
    margin-bottom: .5rem;
    line-height: 1.2;
  }

  .feat-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    font-size: 12px;
    color: rgba(255,255,255,.7);
    align-items: center;
  }
  .feat-meta i { color: var(--orange2); margin-right: 3px; }

  /* right column small cards */
  .feat-col-right {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
  }

  .feat-card-sm { min-height: 210px; }

  /* ──────────────────────────────────────────────
     CALENDAR STRIP
  ────────────────────────────────────────────── */
  .calendar-strip {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding-bottom: 4px;
    scrollbar-width: none;
  }
  .calendar-strip::-webkit-scrollbar { display: none; }

  .month-card {
    flex-shrink: 0;
    min-width: 110px;
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: 14px;
    padding: 1.1rem 1rem;
    text-align: center;
    cursor: pointer;
    transition: all .2s;
  }
  .month-card:hover, .month-card.active {
    border-color: var(--orange);
    background: #FFF5EF;
  }
  .month-card.active .month-num { color: var(--orange); }

  .month-name {
    font-size: 12px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-bottom: 4px;
  }
  .month-num {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 700;
    color: var(--teal);
    line-height: 1;
  }
  .month-label {
    font-size: 10px;
    color: var(--muted);
    margin-top: 3px;
  }

  /* ──────────────────────────────────────────────
     CARDS GRID (regular events)
  ────────────────────────────────────────────── */
  .cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
  }

  .ev-card {
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    transition: box-shadow .25s, transform .25s, border-color .25s;
  }
  .ev-card:hover {
    box-shadow: 0 12px 40px rgba(0,0,0,.1);
    transform: translateY(-4px);
    border-color: rgba(232,107,36,.3);
  }

  .ev-card-img-wrap { position: relative; overflow: hidden; }
  .ev-card-img {
    width: 100%;
    aspect-ratio: 4/3;
    object-fit: cover;
    display: block;
    transition: transform .5s ease;
  }
  .ev-card:hover .ev-card-img { transform: scale(1.06); }

  .ev-card-date-badge {
    position: absolute;
    top: 12px; left: 12px;
    background: rgba(12,18,26,.75);
    backdrop-filter: blur(6px);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .06em;
    padding: 5px 10px;
    border-radius: 8px;
    text-transform: uppercase;
  }

  .ev-card-body { padding: 1.1rem; }

  .ev-card-cat {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--teal);
    margin-bottom: 5px;
  }

  .ev-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 6px;
    line-height: 1.3;
  }

  .ev-card-desc {
    font-size: 13px;
    color: var(--muted);
    line-height: 1.6;
    margin-bottom: 10px;
  }

  .ev-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid var(--border);
    padding-top: 10px;
    margin-top: 4px;
  }
  .ev-card-loc {
    font-size: 12px;
    color: var(--muted);
    display: flex; align-items: center; gap: 4px;
  }
  .ev-card-loc i { color: var(--orange); font-size: 11px; }

  .ev-card-tag {
    font-size: 10px;
    padding: 3px 10px;
    border-radius: 10px;
    background: rgba(27,122,140,.1);
    color: var(--teal);
    border: 1px solid rgba(27,122,140,.2);
    font-weight: 600;
  }

  /* ──────────────────────────────────────────────
     REGIONS SECTION
  ────────────────────────────────────────────── */
  .regions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 14px;
  }

  .region-card {
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: 14px;
    padding: 1.4rem 1.2rem;
    cursor: pointer;
    transition: all .22s;
    position: relative;
    overflow: hidden;
  }
  .region-card::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 4px;
    background: var(--orange);
    transform: scaleY(0);
    transform-origin: bottom;
    transition: transform .25s;
    border-radius: 4px 0 0 4px;
  }
  .region-card:hover { border-color: rgba(232,107,36,.3); box-shadow: 0 8px 28px rgba(0,0,0,.07); }
  .region-card:hover::before { transform: scaleY(1); }

  .region-icon { font-size: 2rem; margin-bottom: 8px; }
  .region-name { font-size: 15px; font-weight: 600; color: var(--text); margin-bottom: 4px; }
  .region-count { font-size: 12px; color: var(--orange); font-weight: 700; margin-bottom: 8px; }

  .region-tags { display: flex; gap: 5px; flex-wrap: wrap; }
  .region-tag {
    font-size: 9px;
    padding: 2px 8px;
    border-radius: 8px;
    background: var(--bg);
    color: var(--muted);
    font-weight: 500;
    border: 1px solid var(--border);
  }

  /* ──────────────────────────────────────────────
     CATEGORY BLOCKS
  ────────────────────────────────────────────── */
  .cat-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px;
  }

  .cat-block {
    border-radius: 14px;
    overflow: hidden;
    cursor: pointer;
    position: relative;
    aspect-ratio: 3/4;
    transition: transform .3s;
  }
  .cat-block:hover { transform: scale(1.02); }
  .cat-block img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .5s;
  }
  .cat-block:hover img { transform: scale(1.08); }

  .cat-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(12,18,26,.85) 0%, transparent 55%);
    display: flex; flex-direction: column; justify-content: flex-end;
    padding: 1.2rem 1rem;
  }

  .cat-icon {
    width: 40px; height: 40px;
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(4px);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    color: #fff;
    margin-bottom: 8px;
    border: 1px solid rgba(255,255,255,.2);
  }
  .cat-name {
    font-family: 'Playfair Display', serif;
    font-size: .95rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 3px;
  }
  .cat-count { font-size: 11px; color: rgba(255,255,255,.65); }

  /* ──────────────────────────────────────────────
     PROMO BANNER
  ────────────────────────────────────────────── */
  .promo-banner {
    background: linear-gradient(135deg, #1B3A4B 0%, #0F5068 50%, #1B4A3A 100%);
    border-radius: 20px;
    padding: 3.5rem 3rem;
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: center;
    gap: 2rem;
    position: relative;
    overflow: hidden;
  }
  .promo-banner::before {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: rgba(232,107,36,.12);
    right: -80px; top: -120px;
    pointer-events: none;
  }
  .promo-banner::after {
    content: '';
    position: absolute;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(20,168,196,.1);
    left: 40%; bottom: -60px;
    pointer-events: none;
  }

  .promo-tag {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 10px; font-weight: 700; letter-spacing: .1em;
    text-transform: uppercase; color: var(--orange2);
    margin-bottom: .7rem;
  }
  .promo-tag::before {
    content: ''; width: 16px; height: 2px;
    background: var(--orange2); border-radius: 2px;
  }

  .promo-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.5rem, 2.5vw, 2.2rem);
    font-weight: 700;
    color: #fff;
    line-height: 1.18;
    margin-bottom: .8rem;
  }

  .promo-desc {
    font-size: 14px;
    color: rgba(255,255,255,.65);
    line-height: 1.75;
    max-width: 520px;
  }

  .promo-actions { display: flex; gap: 10px; flex-direction: column; align-items: flex-end; }

  .btn-promo-primary {
    background: var(--orange);
    color: #fff;
    border: none;
    padding: 14px 28px;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: background .2s, transform .15s;
  }
  .btn-promo-primary:hover { background: #CF5D18; transform: translateY(-1px); }

  .btn-promo-ghost {
    background: rgba(255,255,255,.1);
    color: rgba(255,255,255,.8);
    border: 1px solid rgba(255,255,255,.2);
    padding: 11px 22px;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    cursor: pointer;
    white-space: nowrap;
    transition: background .2s;
    text-align: center;
  }
  .btn-promo-ghost:hover { background: rgba(255,255,255,.18); }

  /* ──────────────────────────────────────────────
     EVENT LIST ROWS
  ────────────────────────────────────────────── */
  .event-list { display: flex; flex-direction: column; gap: 12px; }

  .ev-row {
    display: grid;
    grid-template-columns: 90px 1fr auto;
    align-items: center;
    gap: 16px;
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: 14px;
    padding: 1rem 1.2rem;
    cursor: pointer;
    transition: all .22s;
  }
  .ev-row:hover {
    border-color: rgba(232,107,36,.35);
    box-shadow: 0 6px 24px rgba(0,0,0,.07);
  }

  .ev-row-img {
    width: 90px; height: 80px;
    border-radius: 10px;
    object-fit: cover;
    flex-shrink: 0;
  }

  .ev-row-title {
    font-size: 15px; font-weight: 600;
    color: var(--text);
    margin-bottom: 4px;
  }

  .ev-row-meta {
    display: flex; gap: 14px; flex-wrap: wrap;
    font-size: 12px; color: var(--muted);
  }
  .ev-row-meta i { color: var(--orange); margin-right: 3px; font-size: 11px; }

  .ev-row-badge {
    font-size: 10px; font-weight: 700;
    padding: 5px 12px; border-radius: 10px;
    white-space: nowrap; flex-shrink: 0;
  }
  .badge-hot  { background: #FFF0E8; color: var(--orange); border: 1px solid rgba(232,107,36,.3); }
  .badge-top  { background: #FDF6E3; color: #9B7A1A; border: 1px solid rgba(201,168,76,.35); }
  .badge-new  { background: #E8F6FA; color: var(--teal); border: 1px solid rgba(27,122,140,.3); }

  /* ──────────────────────────────────────────────
     TESTIMONIAL / EDITORIAL BAND
  ────────────────────────────────────────────── */
  .editorial-band {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0;
    border: 1.5px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
  }

  .ed-block {
    padding: 2.4rem 2rem;
    border-right: 1px solid var(--border);
  }
  .ed-block:last-child { border-right: none; }

  .ed-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    background: var(--bg);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    color: var(--orange);
    margin-bottom: 1.1rem;
    border: 1px solid var(--border);
  }

  .ed-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem; font-weight: 700;
    color: var(--text);
    margin-bottom: .5rem;
  }
  .ed-desc {
    font-size: 13.5px; color: var(--muted);
    line-height: 1.7;
  }

  /* ──────────────────────────────────────────────
     MEDIA / GALLERY ROW
  ────────────────────────────────────────────── */
  .gallery-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
  }

  .gallery-item {
    border-radius: 14px;
    overflow: hidden;
    aspect-ratio: 1/1.1;
    position: relative;
    cursor: pointer;
  }
  .gallery-item img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .5s;
  }
  .gallery-item:hover img { transform: scale(1.08); }

  .gallery-label {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: linear-gradient(to top, rgba(12,18,26,.8) 0%, transparent 100%);
    padding: 1.2rem .9rem .8rem;
    color: #fff;
    font-size: 13px; font-weight: 600;
  }
  .gallery-label small { display: block; font-size: 10px; color: rgba(255,255,255,.6); font-weight: 400; margin-top: 2px; }

  /* ──────────────────────────────────────────────
     FOOTER CTA BAND
  ────────────────────────────────────────────── */
  .footer-cta {
    background: var(--dark);
    padding: 5rem 0;
    text-align: center;
    color: #fff;
  }

  .footer-cta-eyebrow {
    font-size: 11px; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase;
    color: var(--orange2); margin-bottom: 1rem;
  }

  .footer-cta-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4vw, 3.2rem);
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: 1.2rem;
  }
  .footer-cta-title em { font-style: italic; color: var(--orange2); }

  .footer-cta-sub {
    font-size: 15px; color: rgba(255,255,255,.6);
    line-height: 1.75; max-width: 540px;
    margin: 0 auto 2.5rem;
  }

  .footer-cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

  /* FOOTER */
  .footer {
    background: #0A0F14;
    padding: 3rem 0 2rem;
    color: rgba(255,255,255,.5);
    border-top: 1px solid rgba(255,255,255,.06);
  }

  .footer-inner {
    width: 100%; max-width: 1400px;
    margin: 0 auto; padding: 0 2rem;
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap;
    gap: 1rem;
  }

  .footer-brand {
    display: flex; align-items: center; gap: 10px;
  }
  .footer-brand img { height: 28px; filter: brightness(1.5); }
  .footer-brand-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem; font-weight: 700;
    color: rgba(255,255,255,.8);
  }

  .footer-copy { font-size: 12px; }

  .footer-links {
    display: flex; gap: 20px; list-style: none;
  }
  .footer-links a { font-size: 12px; color: rgba(255,255,255,.45); transition: color .2s; }
  .footer-links a:hover { color: var(--orange2); }

  /* ──────────────────────────────────────────────
     RESPONSIVE
  ────────────────────────────────────────────── */
  @media (max-width: 1100px) {
    .cat-grid { grid-template-columns: repeat(3, 1fr); }
    .featured-grid { grid-template-columns: 1fr; }
    .feat-card-main { min-height: 380px; }
    .feat-col-right { flex-direction: row; }
    .feat-card-sm { flex: 1; min-height: 200px; }
    .editorial-band { grid-template-columns: 1fr; }
    .ed-block { border-right: none; border-bottom: 1px solid var(--border); }
    .ed-block:last-child { border-bottom: none; }
  }

  @media (max-width: 768px) {
    :root { --hero-h: 500px; }
    .hero-content { padding: 0 1.5rem; }
    .hero-stats-inner { padding: 0 1.5rem; flex-wrap: wrap; }
    .hero-stat { min-width: 50%; border-right: none; border-bottom: 1px solid rgba(255,255,255,.08); }
    .nav-links { display: none; }
    .cat-grid { grid-template-columns: repeat(2, 1fr); }
    .gallery-row { grid-template-columns: repeat(2, 1fr); }
    .feat-col-right { flex-direction: column; }
    .regions-grid { grid-template-columns: repeat(2, 1fr); }
    .ev-row { grid-template-columns: 70px 1fr; }
    .ev-row .ev-row-badge { display: none; }
    .promo-banner { grid-template-columns: 1fr; }
    .promo-actions { align-items: flex-start; }
    .container { padding: 0 1rem; }
    .hero-stats-inner { padding: 0 1rem; }
  }
</style>
</head>
<body>

<!-- ═══════════════════ NAV ═══════════════════ -->
<nav class="nav">
  <div class="nav-inner">
    <div class="nav-logo">
      <img src="logo.png" alt="GoExploria" onerror="this.style.display='none'" style="height: 60px;">
     
    </div>
    <ul class="nav-links">
      <li><a href="#">Destinations</a></li>
      <li><a href="#">Événements</a></li>
      <li><a href="#">Expériences</a></li>
      <li><a href="#">Gastronomie</a></li>
      <li><a href="#">Plein air</a></li>
    </ul>
    <a href="{{route('devis')}}" class="nav-cta">Demander un devis→</a>
  </div>
</nav>

<!-- ═══════════════════ HERO ═══════════════════ -->
<section class="hero">
  <div class="hero-bg" id="heroBg"></div>
  <div class="hero-overlay"></div>

  <div class="hero-content">
    <div class="hero-eyebrow">Sélection exclusive 2026</div>
    <h1 class="hero-title">
      Événements vedette<br>
      au <em>Québec</em>
    </h1>
    <p class="hero-sub">
      Festivals légendaires, immersions culturelles, aventures en plein air et gastronomie d'exception — GoExploria vous guide vers les expériences qui font battre le cœur de la Belle Province.
    </p>
    <div class="hero-actions">
      <a href="{{route('devis')}}" class="btn-primary">
        <i class="fas fa-compass"></i> Découvrir les événements
      </a>
      <!-- <button class="btn-ghost">
        <i class="fas fa-play-circle"></i> Voir la vidéo
      </button> -->
    </div>
  </div>

  <div class="hero-stats">
    <div class="hero-stats-inner">
      <div class="hero-stat">
        <div class="hero-stat-num">200+</div>
        <div class="hero-stat-label">Événements sélectionnés</div>
      </div>
      <div class="hero-stat">
        <div class="hero-stat-num">17</div>
        <div class="hero-stat-label">Régions du Québec</div>
      </div>
      <div class="hero-stat">
        <div class="hero-stat-num">5</div>
        <div class="hero-stat-label">Catégories exclusives</div>
      </div>
      <div class="hero-stat">
        <div class="hero-stat-num">50k+</div>
        <div class="hero-stat-label">Explorateurs actifs</div>
      </div>
      <div class="hero-stat">
        <div class="hero-stat-num">12</div>
        <div class="hero-stat-label">Mois d'expériences</div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════ DESTINATION BAR ═══════════════════ -->
<div class="dest-bar">
  <div class="dest-bar-inner">
    <div class="dest-icon">
      <i class="fas fa-map-marker-alt"></i>
      Destinations
    </div>
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
        <option>Mauricie</option>
        <option>Gaspésie</option>
        <option>Saguenay</option>
        <option>Laurentides</option>
        <option>Cantons-de-l'Est</option>
      </select>
    </div>
  </div>
</div>

<!-- ═══════════════════ FILTER BAR ═══════════════════ -->
<div class="filter-bar">
  <div class="filter-bar-inner">
    <button class="filter-btn active" data-f="all">
      <i class="fas fa-th-large"></i> Tous les événements
    </button>
    <button class="filter-btn" data-f="culture">
      <i class="fas fa-palette"></i> Culture & Arts
    </button>
    <button class="filter-btn" data-f="gastro">
      <i class="fas fa-utensils"></i> Gastronomie
    </button>
    <button class="filter-btn" data-f="nature">
      <i class="fas fa-leaf"></i> Nature & Plein air
    </button>
    <button class="filter-btn" data-f="aventure">
      <i class="fas fa-mountain"></i> Aventure & Sports
    </button>
    <button class="filter-btn" data-f="hiver">
      <i class="fas fa-snowflake"></i> Hiver
    </button>
    <button class="filter-btn" data-f="musique">
      <i class="fas fa-music"></i> Musique & Festivals
    </button>
  </div>
</div>

<!-- ═══════════════════ FEATURED ═══════════════════ -->
<section class="section">
  <div class="container">
    <div class="sec-header">
      <div>
        <div class="sec-label"><i class="fas fa-star" style="color:var(--orange)"></i> Événement à l'honneur</div>
        <h2 class="sec-title">Les incontournables de la saison</h2>
      </div>
      <a href="#" class="sec-link">Voir tout <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="featured-grid">
      <!-- Main large card -->
      <div class="feat-card feat-card-main">
        <img src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=1000&h=700&fit=crop" alt="Festival d'été de Québec">
        <div class="feat-card-overlay">
          <span class="feat-badge badge-orange">★ Sélection GoExploria</span>
          <div class="feat-title">Festival d'été de Québec</div>
          <div class="feat-meta">
            <span><i class="fas fa-calendar-alt"></i>15 – 24 Juin 2026</span>
            <span><i class="fas fa-map-marker-alt"></i>Vieux-Québec</span>
            <span><i class="fas fa-users"></i>1 000 000+ visiteurs</span>
            <span><i class="fas fa-music"></i>Culture & Musique</span>
          </div>
        </div>
      </div>

      <!-- Right column -->
      <div class="feat-col-right">
        <div class="feat-card feat-card-sm">
          <img src="https://images.unsplash.com/photo-1502134249126-9f3755a50d78?w=600&h=350&fit=crop" alt="Carnaval de Québec">
          <div class="feat-card-overlay">
            <span class="feat-badge badge-teal">Hiver</span>
            <div class="feat-title">Carnaval de Québec</div>
            <div class="feat-meta">
              <span><i class="fas fa-calendar-alt"></i>28 Fév – 10 Mar</span>
              <span><i class="fas fa-map-marker-alt"></i>Québec</span>
            </div>
          </div>
        </div>
        <div class="feat-card feat-card-sm">
          <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=600&h=350&fit=crop" alt="Osheaga">
          <div class="feat-card-overlay">
            <span class="feat-badge badge-gold">Musique</span>
            <div class="feat-title">Osheaga — Montréal</div>
            <div class="feat-meta">
              <span><i class="fas fa-calendar-alt"></i>Août 2026</span>
              <span><i class="fas fa-map-marker-alt"></i>Île Sainte-Hélène</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════ CATEGORIES ═══════════════════ -->
<section class="section alt">
  <div class="container">
    <div class="sec-header">
      <div>
        <div class="sec-label"><i class="fas fa-th"></i> Explorer par catégorie</div>
        <h2 class="sec-title">Cinq univers, mille expériences</h2>
      </div>
    </div>
    <div class="cat-grid">
      <div class="cat-block">
        <img src="https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400&h=600&fit=crop" alt="Culture">
        <div class="cat-overlay">
          <div class="cat-icon"><i class="fas fa-palette"></i></div>
          <div class="cat-name">Culture & Arts</div>
          <div class="cat-count">64 événements</div>
        </div>
      </div>
      <div class="cat-block">
        <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=400&h=600&fit=crop" alt="Gastronomie">
        <div class="cat-overlay">
          <div class="cat-icon"><i class="fas fa-utensils"></i></div>
          <div class="cat-name">Gastronomie</div>
          <div class="cat-count">38 événements</div>
        </div>
      </div>
      <div class="cat-block">
        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=600&fit=crop" alt="Nature">
        <div class="cat-overlay">
          <div class="cat-icon"><i class="fas fa-leaf"></i></div>
          <div class="cat-name">Nature & Plein air</div>
          <div class="cat-count">42 événements</div>
        </div>
      </div>
      <div class="cat-block">
        <img src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=400&h=600&fit=crop" alt="Aventure">
        <div class="cat-overlay">
          <div class="cat-icon"><i class="fas fa-mountain"></i></div>
          <div class="cat-name">Aventure & Sports</div>
          <div class="cat-count">29 événements</div>
        </div>
      </div>
      <div class="cat-block">
        <img src="https://images.unsplash.com/photo-1502134249126-9f3755a50d78?w=400&h=600&fit=crop" alt="Hiver">
        <div class="cat-overlay">
          <div class="cat-icon"><i class="fas fa-snowflake"></i></div>
          <div class="cat-name">Hiver & Neige</div>
          <div class="cat-count">31 événements</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════ CALENDAR ═══════════════════ -->
<section class="section">
  <div class="container">
    <div class="sec-header">
      <div>
        <div class="sec-label"><i class="fas fa-calendar-alt"></i> Agenda annuel</div>
        <h2 class="sec-title">Événements toute l'année</h2>
      </div>
    </div>
    <div class="calendar-strip">
      <div class="month-card"><div class="month-name">Jan</div><div class="month-num">8</div><div class="month-label">événements</div></div>
      <div class="month-card"><div class="month-name">Fév</div><div class="month-num">14</div><div class="month-label">événements</div></div>
      <div class="month-card"><div class="month-name">Mar</div><div class="month-num">11</div><div class="month-label">événements</div></div>
      <div class="month-card"><div class="month-name">Avr</div><div class="month-num">9</div><div class="month-label">événements</div></div>
      <div class="month-card"><div class="month-name">Mai</div><div class="month-num">17</div><div class="month-label">événements</div></div>
      <div class="month-card active"><div class="month-name">Juin</div><div class="month-num">22</div><div class="month-label">événements</div></div>
      <div class="month-card"><div class="month-name">Juil</div><div class="month-num">28</div><div class="month-label">événements</div></div>
      <div class="month-card"><div class="month-name">Août</div><div class="month-num">25</div><div class="month-label">événements</div></div>
      <div class="month-card"><div class="month-name">Sep</div><div class="month-num">19</div><div class="month-label">événements</div></div>
      <div class="month-card"><div class="month-name">Oct</div><div class="month-num">16</div><div class="month-label">événements</div></div>
      <div class="month-card"><div class="month-name">Nov</div><div class="month-num">10</div><div class="month-label">événements</div></div>
      <div class="month-card"><div class="month-name">Déc</div><div class="month-num">13</div><div class="month-label">événements</div></div>
    </div>
  </div>
</section>

<!-- ═══════════════════ CARDS GRID ═══════════════════ -->
<section class="section alt">
  <div class="container">
    <div class="sec-header">
      <div>
        <div class="sec-label"><i class="fas fa-fire"></i> Cette saison</div>
        <h2 class="sec-title">Événements phares du moment</h2>
      </div>
      <a href="#" class="sec-link">Tous les événements <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="cards-grid">

      <article class="ev-card" data-category="culture">
        <div class="ev-card-img-wrap">
          <img class="ev-card-img" src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&h=450&fit=crop" alt="Festival d'été">
          <div class="ev-card-date-badge">15–24 Juin</div>
        </div>
        <div class="ev-card-body">
          <div class="ev-card-cat">Culture & Musique</div>
          <h3 class="ev-card-title">Festival d'été de Québec</h3>
          <p class="ev-card-desc">Le plus grand festival extérieur en Amérique du Nord, avec des artistes internationaux sur 10 scènes.</p>
          <div class="ev-card-footer">
            <span class="ev-card-loc"><i class="fas fa-map-marker-alt"></i> Québec</span>
            <span class="ev-card-tag">Scènes extérieures</span>
          </div>
        </div>
      </article>

      <article class="ev-card" data-category="gastro">
        <div class="ev-card-img-wrap">
          <img class="ev-card-img" src="https://images.unsplash.com/photo-1555244162-803834f70033?w=600&h=450&fit=crop" alt="Carnaval">
          <div class="ev-card-date-badge">28 Fév–10 Mar</div>
        </div>
        <div class="ev-card-body">
          <div class="ev-card-cat">Hiver · Traditions</div>
          <h3 class="ev-card-title">Carnaval de Québec</h3>
          <p class="ev-card-desc">Le plus grand carnaval d'hiver au monde avec Bonhomme Carnaval comme ambassadeur festif.</p>
          <div class="ev-card-footer">
            <span class="ev-card-loc"><i class="fas fa-map-marker-alt"></i> Québec</span>
            <span class="ev-card-tag">Hiver</span>
          </div>
        </div>
      </article>

      <article class="ev-card" data-category="culture">
        <div class="ev-card-img-wrap">
          <img class="ev-card-img" src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=600&h=450&fit=crop" alt="Festival de montgolfières">
          <div class="ev-card-date-badge">Septembre</div>
        </div>
        <div class="ev-card-body">
          <div class="ev-card-cat">Aventure · Spectacle</div>
          <h3 class="ev-card-title">Festival de montgolfières</h3>
          <p class="ev-card-desc">Le plus grand rassemblement de montgolfières au Canada à Saint-Jean-sur-Richelieu.</p>
          <div class="ev-card-footer">
            <span class="ev-card-loc"><i class="fas fa-map-marker-alt"></i> St-Jean-sur-Richelieu</span>
            <span class="ev-card-tag">Aventure</span>
          </div>
        </div>
      </article>

      <article class="ev-card" data-category="nature">
        <div class="ev-card-img-wrap">
          <img class="ev-card-img" src="https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=600&h=450&fit=crop" alt="Festival des baleines">
          <div class="ev-card-date-badge">Juin 2026</div>
        </div>
        <div class="ev-card-body">
          <div class="ev-card-cat">Nature · Faune marine</div>
          <h3 class="ev-card-title">Festival des baleines</h3>
          <p class="ev-card-desc">Observation des baleines et célébration de la faune marine du Saint-Laurent à Tadoussac.</p>
          <div class="ev-card-footer">
            <span class="ev-card-loc"><i class="fas fa-map-marker-alt"></i> Tadoussac</span>
            <span class="ev-card-tag">Nature & Faune</span>
          </div>
        </div>
      </article>

      <article class="ev-card" data-category="gastro">
        <div class="ev-card-img-wrap">
          <img class="ev-card-img" src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&h=450&fit=crop" alt="Festival gastronomique">
          <div class="ev-card-date-badge">Mai 2026</div>
        </div>
        <div class="ev-card-body">
          <div class="ev-card-cat">Gastronomie · Chefs</div>
          <h3 class="ev-card-title">Festival gastronomique</h3>
          <p class="ev-card-desc">Découvrez la richesse culinaire du Québec avec des chefs renommés et des producteurs locaux.</p>
          <div class="ev-card-footer">
            <span class="ev-card-loc"><i class="fas fa-map-marker-alt"></i> Montréal</span>
            <span class="ev-card-tag">Gastronomie</span>
          </div>
        </div>
      </article>

      <article class="ev-card" data-category="nature">
        <div class="ev-card-img-wrap">
          <img class="ev-card-img" src="https://images.unsplash.com/photo-1507608616759-54f48f0af0ee?w=600&h=450&fit=crop" alt="Festival des couleurs">
          <div class="ev-card-date-badge">Octobre</div>
        </div>
        <div class="ev-card-body">
          <div class="ev-card-cat">Nature · Automne</div>
          <h3 class="ev-card-title">Festival des couleurs</h3>
          <p class="ev-card-desc">Célébration de l'automne et des magnifiques paysages colorés des Cantons-de-l'Est.</p>
          <div class="ev-card-footer">
            <span class="ev-card-loc"><i class="fas fa-map-marker-alt"></i> Cantons-de-l'Est</span>
            <span class="ev-card-tag">Nature & Culture</span>
          </div>
        </div>
      </article>

      <article class="ev-card" data-category="culture">
        <div class="ev-card-img-wrap">
          <img class="ev-card-img" src="https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=600&h=450&fit=crop" alt="Juste pour rire">
          <div class="ev-card-date-badge">Juillet 2026</div>
        </div>
        <div class="ev-card-body">
          <div class="ev-card-cat">Humour · Spectacle</div>
          <h3 class="ev-card-title">Festival Juste pour Rire</h3>
          <p class="ev-card-desc">Le plus grand festival d'humour au monde avec des centaines de spectacles et animations de rue.</p>
          <div class="ev-card-footer">
            <span class="ev-card-loc"><i class="fas fa-map-marker-alt"></i> Montréal</span>
            <span class="ev-card-tag">Humour</span>
          </div>
        </div>
      </article>

      <article class="ev-card" data-category="aventure">
        <div class="ev-card-img-wrap">
          <img class="ev-card-img" src="https://images.unsplash.com/photo-1487958449943-2429e8be8625?w=600&h=450&fit=crop" alt="Cirque du Soleil">
          <div class="ev-card-date-badge">Toute l'année</div>
        </div>
        <div class="ev-card-body">
          <div class="ev-card-cat">Spectacle · Arts du cirque</div>
          <h3 class="ev-card-title">Cirque du Soleil</h3>
          <p class="ev-card-desc">Magie, acrobaties et créativité débordante dans une nouvelle création mondiale exclusive.</p>
          <div class="ev-card-footer">
            <span class="ev-card-loc"><i class="fas fa-map-marker-alt"></i> Montréal</span>
            <span class="ev-card-tag">Spectacle</span>
          </div>
        </div>
      </article>

    </div>
  </div>
</section>

<!-- ═══════════════════ PROMO ═══════════════════ -->
<section class="section">
  <div class="container">
    <div class="promo-banner">
      <div>
        <div class="promo-tag">Offre exclusive GoExploria</div>
        <h2 class="promo-title">Vivez l'expérience<br>que vous méritez vraiment</h2>
        <p class="promo-desc">
          Accédez à des billets prioritaires, des loges VIP et des expériences sur mesure que vous ne trouverez nulle part ailleurs. Nos experts conciergerie sélectionnent, réservent et vous accompagnent jusqu'au cœur de l'action.
        </p>
      </div>
      <div class="promo-actions">
        <button class="btn-promo-primary">
          <i class="fas fa-crown"></i> &nbsp;Découvrir Nos Plans
        </button>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════ REGIONS ═══════════════════ -->
<section class="section alt">
  <div class="container">
    <div class="sec-header">
      <div>
        <div class="sec-label"><i class="fas fa-map-marked-alt"></i> Explorer par région</div>
        <h2 class="sec-title">Le Québec région par région</h2>
      </div>
      <a href="#" class="sec-link">Toutes les régions <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="regions-grid">
      <div class="region-card">
        <div class="region-icon">🏙️</div>
        <div class="region-name">Montréal Métro</div>
        <div class="region-count">48 événements</div>
        <div class="region-tags">
          <span class="region-tag">Culture</span>
          <span class="region-tag">Gastronomie</span>
          <span class="region-tag">Musique</span>
          <span class="region-tag">Arts</span>
        </div>
      </div>
      <div class="region-card">
        <div class="region-icon">🏰</div>
        <div class="region-name">Région de Québec</div>
        <div class="region-count">35 événements</div>
        <div class="region-tags">
          <span class="region-tag">Histoire</span>
          <span class="region-tag">Hiver</span>
          <span class="region-tag">Patrimoine</span>
        </div>
      </div>
      <div class="region-card">
        <div class="region-icon">🌊</div>
        <div class="region-name">Gaspésie</div>
        <div class="region-count">19 événements</div>
        <div class="region-tags">
          <span class="region-tag">Nature</span>
          <span class="region-tag">Mer</span>
          <span class="region-tag">Faune</span>
        </div>
      </div>
      <div class="region-card">
        <div class="region-icon">🏔️</div>
        <div class="region-name">Laurentides</div>
        <div class="region-count">24 événements</div>
        <div class="region-tags">
          <span class="region-tag">Ski</span>
          <span class="region-tag">Plein air</span>
          <span class="region-tag">Automne</span>
        </div>
      </div>
      <div class="region-card">
        <div class="region-icon">🍁</div>
        <div class="region-name">Cantons-de-l'Est</div>
        <div class="region-count">21 événements</div>
        <div class="region-tags">
          <span class="region-tag">Couleurs</span>
          <span class="region-tag">Vignobles</span>
          <span class="region-tag">Gastronomie</span>
        </div>
      </div>
      <div class="region-card">
        <div class="region-icon">🦌</div>
        <div class="region-name">Saguenay–Lac-St-Jean</div>
        <div class="region-count">16 événements</div>
        <div class="region-tags">
          <span class="region-tag">Aventure</span>
          <span class="region-tag">Culture</span>
          <span class="region-tag">Plein air</span>
        </div>
      </div>
      <div class="region-card">
        <div class="region-icon">🚢</div>
        <div class="region-name">Charlevoix</div>
        <div class="region-count">12 événements</div>
        <div class="region-tags">
          <span class="region-tag">Arts</span>
          <span class="region-tag">Gastronomie</span>
        </div>
      </div>
      <div class="region-card">
        <div class="region-icon">🌾</div>
        <div class="region-name">Mauricie</div>
        <div class="region-count">14 événements</div>
        <div class="region-tags">
          <span class="region-tag">Nature</span>
          <span class="region-tag">Canot</span>
          <span class="region-tag">Festivals</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════ TRENDING LIST ═══════════════════ -->
<section class="section">
  <div class="container">
    <div class="sec-header">
      <div>
        <div class="sec-label"><i class="fas fa-fire"></i> Tendances du moment</div>
        <h2 class="sec-title">Les événements qui font sensation</h2>
      </div>
    </div>
    <div class="event-list">
      <div class="ev-row">
        <img class="ev-row-img" src="https://images.unsplash.com/photo-1530549387789-4c1017266635?w=200&h=160&fit=crop" alt="Grand Prix">
        <div class="ev-row-info">
          <div class="ev-row-title">Grand Prix du Canada — Formule 1</div>
          <div class="ev-row-meta">
            <span><i class="fas fa-calendar-alt"></i>8–11 Juin 2026</span>
            <span><i class="fas fa-map-marker-alt"></i>Circuit Gilles-Villeneuve, Montréal</span>
            <span><i class="fas fa-tag"></i>Sports &amp; Compétition</span>
          </div>
        </div>
        <span class="ev-row-badge badge-top">Top GoExploria</span>
      </div>
      <div class="ev-row">
        <img class="ev-row-img" src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=200&h=160&fit=crop" alt="Montgolfières">
        <div class="ev-row-info">
          <div class="ev-row-title">Festival de montgolfières de Saint-Jean-sur-Richelieu</div>
          <div class="ev-row-meta">
            <span><i class="fas fa-calendar-alt"></i>Septembre 2026</span>
            <span><i class="fas fa-map-marker-alt"></i>Saint-Jean-sur-Richelieu</span>
            <span><i class="fas fa-tag"></i>Aventure</span>
          </div>
        </div>
        <span class="ev-row-badge badge-hot">Populaire</span>
      </div>
      <div class="ev-row">
        <img class="ev-row-img" src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=200&h=160&fit=crop" alt="Francofolies">
        <div class="ev-row-info">
          <div class="ev-row-title">Les Francofolies de Montréal</div>
          <div class="ev-row-meta">
            <span><i class="fas fa-calendar-alt"></i>Juin 2026</span>
            <span><i class="fas fa-map-marker-alt"></i>Montréal</span>
            <span><i class="fas fa-tag"></i>Musique francophone</span>
          </div>
        </div>
        <span class="ev-row-badge badge-new">Nouveau</span>
      </div>
      <div class="ev-row">
        <img class="ev-row-img" src="https://images.unsplash.com/photo-1487958449943-2429e8be8625?w=200&h=160&fit=crop" alt="Cirque">
        <div class="ev-row-info">
          <div class="ev-row-title">Cirque du Soleil — Nouvelle création mondiale</div>
          <div class="ev-row-meta">
            <span><i class="fas fa-calendar-alt"></i>Toute l'année</span>
            <span><i class="fas fa-map-marker-alt"></i>Montréal &amp; tournée</span>
            <span><i class="fas fa-tag"></i>Arts du cirque</span>
          </div>
        </div>
        <span class="ev-row-badge badge-top">Top GoExploria</span>
      </div>
      <div class="ev-row">
        <img class="ev-row-img" src="https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=200&h=160&fit=crop" alt="Jazz">
        <div class="ev-row-info">
          <div class="ev-row-title">Festival International de Jazz de Montréal</div>
          <div class="ev-row-meta">
            <span><i class="fas fa-calendar-alt"></i>Juillet 2026</span>
            <span><i class="fas fa-map-marker-alt"></i>Quartier des Spectacles, Montréal</span>
            <span><i class="fas fa-tag"></i>Musique &amp; Jazz</span>
          </div>
        </div>
        <span class="ev-row-badge badge-hot">Populaire</span>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════ EDITORIAL PILLARS ═══════════════════ -->
<section class="section alt">
  <div class="container">
    <div class="sec-header">
      <div>
        <div class="sec-label"><i class="fas fa-shield-alt"></i> Pourquoi GoExploria</div>
        <h2 class="sec-title">L'excellence au service de votre aventure</h2>
      </div>
    </div>
    <div class="editorial-band">
      <div class="ed-block">
        <div class="ed-icon"><i class="fas fa-star"></i></div>
        <div class="ed-title">Sélection d'experts</div>
        <div class="ed-desc">Chaque événement est rigoureusement sélectionné par notre équipe de connaisseurs locaux. Nous ne listons que le meilleur du meilleur — qualité, authenticité et impact garantis.</div>
      </div>
      <div class="ed-block">
        <div class="ed-icon"><i class="fas fa-ticket-alt"></i></div>
        <div class="ed-title">Accès prioritaire &amp; VIP</div>
        <div class="ed-desc">Bénéficiez d'un accès exclusif aux coulisses, loges VIP et préventes en avant-première. Nos partenariats stratégiques vous ouvrent des portes inaccessibles au grand public.</div>
      </div>
      <div class="ed-block">
        <div class="ed-icon"><i class="fas fa-concierge-bell"></i></div>
        <div class="ed-title">Conciergerie dédiée</div>
        <div class="ed-desc">De la réservation à l'hébergement en passant par le transport, notre équipe conciergerie prend en charge chaque détail pour que vous profitiez pleinement de l'expérience.</div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════ GALLERY ═══════════════════ -->
<section class="section">
  <div class="container">
    <div class="sec-header">
      <div>
        <div class="sec-label"><i class="fas fa-images"></i> Galerie GoExploria</div>
        <h2 class="sec-title">Des instants qui vous attendent</h2>
      </div>
      <a href="#" class="sec-link">Voir la galerie <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="gallery-row">
      <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=500&h=600&fit=crop" alt="Festival">
        <div class="gallery-label">Osheaga 2026<small>Île Sainte-Hélène · Montréal</small></div>
      </div>
      <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=600&fit=crop" alt="Laurentides">
        <div class="gallery-label">Laurentides<small>Plein air · Nature sauvage</small></div>
      </div>
      <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=500&h=600&fit=crop" alt="Montréal">
        <div class="gallery-label">Montréal by night<small>Quartier des Spectacles</small></div>
      </div>
      <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1502134249126-9f3755a50d78?w=500&h=600&fit=crop" alt="Carnaval">
        <div class="gallery-label">Carnaval de Québec<small>Magie hivernale · Vieux-Québec</small></div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════ FOOTER CTA ═══════════════════ -->
<div class="footer-cta">
  <div class="container">
    <div class="footer-cta-eyebrow">Prêt à explorer ?</div>
    <h2 class="footer-cta-title">
      Vivez le Québec<br><em>comme jamais auparavant</em>
    </h2>
    <p class="footer-cta-sub">
      200 événements triés sur le volet, 17 régions, des experts passionnés. GoExploria transforme chaque sortie en souvenir inoubliable.
    </p>
    <div class="footer-cta-btns">
      <button class="btn-primary" style="font-size:15px; padding:15px 34px;">
        <i class="fas fa-compass"></i> Explorer tous les événements
      </button>
      <button class="btn-ghost" style="font-size:15px; padding:15px 30px;">
        <i class="fas fa-envelope"></i> Recevoir la newsletter
      </button>
    </div>
  </div>
</div>

<!-- ═══════════════════ FOOTER ═══════════════════ -->
<footer class="footer">
  <div class="footer-inner">
    <div class="footer-brand">
      <img src="logo.png" alt="GoExploria" onerror="this.style.display='none'" style="height:60px;">
    </div>
    <span class="footer-copy">© 2026 GoExploria Business. Tous droits réservés.</span>
    <ul class="footer-links">
      <li><a href="#">Confidentialité</a></li>
      <li><a href="#">Conditions</a></li>
      <li><a href="#">Contact</a></li>
      <li><a href="#">Partenaires</a></li>
    </ul>
  </div>
</footer>

<script>
  // Filter buttons
  document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const f = btn.dataset.f;
      document.querySelectorAll('.ev-card').forEach(card => {
        if (f === 'all' || card.dataset.category === f) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });

  // Calendar strip
  document.querySelectorAll('.month-card').forEach(card => {
    card.addEventListener('click', function () {
      document.querySelectorAll('.month-card').forEach(c => c.classList.remove('active'));
      this.classList.add('active');
    });
  });

  // Hero BG zoom on load
  window.addEventListener('load', () => {
    const bg = document.getElementById('heroBg');
    if (bg) bg.classList.add('loaded');
  });
</script>
</body>
</html>