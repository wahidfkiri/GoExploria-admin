<style>
.pc-page {
    --pc-cream: #FAF7F2;
    --pc-white: #FFFFFF;
    --pc-charcoal: #1A1A1A;
    --pc-slate: #3D3D3D;
    --pc-muted: #7A7670;
    --pc-border: #E8E3DC;
    --pc-accent: #8B6F4E;
    --pc-accent-light: #C4A882;
    --pc-accent-pale: #F2EAE0;
    --pc-green: #4A6741;
    --pc-green-pale: #EBF0EA;
    --pc-shadow-sm: 0 2px 12px rgba(0,0,0,0.06);
    --pc-shadow-md: 0 8px 40px rgba(0,0,0,0.10);
    --pc-shadow-lg: 0 20px 80px rgba(0,0,0,0.14);
    --pc-radius: 4px;
    --pc-radius-lg: 12px;
    --pc-font-display: 'Cormorant Garamond', Georgia, serif;
    --pc-font-body: 'DM Sans', sans-serif;
    background: var(--pc-cream);
    color: var(--pc-charcoal);
    font-family: var(--pc-font-body);
    overflow-x: hidden;
    padding-top: 92px;
}
.pc-page *, .pc-page *::before, .pc-page *::after { box-sizing: border-box; }
.pc-page a { color: inherit; }
.pc-container { width: min(1180px, calc(100% - 48px)); margin: 0 auto; }
.pc-section { padding: 96px 0; }
.pc-section-header { text-align: center; max-width: 760px; margin: 0 auto 54px; }
.pc-eyebrow { display: inline-flex; align-items: center; gap: 10px; color: var(--pc-accent); font-size: .76rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; margin-bottom: 16px; }
.pc-eyebrow::before, .pc-eyebrow::after { content: ''; width: 34px; height: 1px; background: var(--pc-accent-light); }
.pc-title { font-family: var(--pc-font-display); font-size: clamp(2.2rem, 5vw, 4.4rem); font-weight: 300; line-height: 1.06; margin: 0; color: var(--pc-charcoal); }
.pc-title em { color: var(--pc-accent); font-style: italic; }
.pc-desc { color: var(--pc-muted); font-size: 1.03rem; line-height: 1.8; margin: 18px auto 0; max-width: 620px; }
.pc-btn { display: inline-flex; align-items: center; gap: 10px; padding: 14px 26px; border-radius: var(--pc-radius); text-decoration: none; font-weight: 700; font-size: .82rem; letter-spacing: .1em; text-transform: uppercase; border: 1px solid transparent; transition: .28s ease; }
.pc-btn-dark { background: var(--pc-charcoal); color: var(--pc-cream); }
.pc-btn-dark:hover { background: var(--pc-accent); color: #fff; transform: translateY(-2px); }
.pc-btn-light { background: #62523f; color: #fff; border-color: #62523f; }
.pc-btn-light:hover { background: var(--pc-accent); border-color: var(--pc-accent); color: #fff; transform: translateY(-2px); }
.pc-btn-outline { border-color: rgba(255,255,255,.55); color: #fff; }
.pc-btn-outline:hover { background: #fff; color: var(--pc-charcoal); }
.pc-reveal { opacity: 0; transform: translateY(28px); transition: opacity .7s ease, transform .7s ease; }
.pc-reveal.pc-visible { opacity: 1; transform: translateY(0); }

.pc-nav { position: sticky; top: 0; z-index: 600; display: flex; align-items: center; justify-content: space-between; min-height: 72px; padding: 0 48px; background: rgba(255,255,255,.94); backdrop-filter: blur(16px); border-bottom: 1px solid var(--pc-border); box-shadow: var(--pc-shadow-sm); }
.pc-nav-logo { display: flex; align-items: center; gap: 14px; text-decoration: none; min-width: 220px; }
.pc-logo-img { width: min(210px, 42vw); max-height: 54px; object-fit: contain; object-position: left center; }
.pc-logo-mark { width: 46px; height: 46px; border-radius: 50%; background: var(--pc-accent-pale); color: var(--pc-accent); display: inline-flex; align-items: center; justify-content: center; font-family: var(--pc-font-display); font-size: 1.25rem; font-weight: 700; border: 1px solid var(--pc-border); }
.pc-logo-text { display: grid; line-height: 1.1; }
.pc-logo-name { font-family: var(--pc-font-display); font-size: 1.3rem; font-weight: 600; color: var(--pc-charcoal); }
.pc-logo-sub { color: var(--pc-accent); font-size: .68rem; text-transform: uppercase; letter-spacing: .18em; font-weight: 700; }
.pc-nav-links { display: flex; gap: 30px; list-style: none; align-items: center; margin: 0; padding: 0; }
.pc-nav-links a { color: var(--pc-slate); text-decoration: none; font-size: .8rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; position: relative; }
.pc-nav-links a::after { content: ''; position: absolute; left: 0; right: 0; bottom: -4px; height: 1px; background: var(--pc-accent); transform: scaleX(0); transition: .25s ease; }
.pc-nav-links a:hover { color: var(--pc-accent); }
.pc-nav-links a:hover::after { transform: scaleX(1); }
.pc-nav-cta { background: var(--pc-charcoal); color: var(--pc-cream) !important; padding: 11px 20px; border-radius: var(--pc-radius); }
.pc-nav-cta::after { display: none; }
.pc-hamburger { display: none; flex-direction: column; gap: 5px; background: none; border: 0; cursor: pointer; padding: 8px; }
.pc-hamburger span { display: block; width: 24px; height: 2px; background: var(--pc-charcoal); }
.pc-mobile-menu { display: none; position: fixed; top: 72px; left: 0; right: 0; z-index: 590; background: white; padding: 22px 32px; flex-direction: column; gap: 14px; box-shadow: var(--pc-shadow-md); }
.pc-mobile-menu.pc-open { display: flex; }
.pc-mobile-menu a { text-decoration: none; color: var(--pc-slate); text-transform: uppercase; letter-spacing: .08em; font-weight: 700; padding: 10px 0; border-bottom: 1px solid var(--pc-border); }

.pc-hero { height: 100vh; min-height: 690px; position: relative; overflow: hidden; }
.pc-hero .swiper, .pc-hero .swiper-wrapper, .pc-hero .swiper-slide { height: 100%; }
.pc-slide-media, .pc-slide-video, .pc-slide-iframe { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; border: 0; transform: scale(1.05); transition: transform 8s ease; }
.pc-hero .swiper-slide-active .pc-slide-media, .pc-hero .swiper-slide-active .pc-slide-video { transform: scale(1); }
.pc-slide-iframe { pointer-events: none; }
.pc-slide-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,.12), rgba(0,0,0,.42) 60%, rgba(0,0,0,.72)); }
.pc-slide-content { position: absolute; left: clamp(28px, 6vw, 80px); bottom: clamp(92px, 16vh, 140px); max-width: 720px; color: white; z-index: 2; }
.pc-slide-tag { display: inline-flex; background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.35); backdrop-filter: blur(8px); border-radius: 999px; padding: 7px 16px; font-size: .72rem; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; margin-bottom: 22px; }
.pc-slide-title { font-family: var(--pc-font-display); font-size: clamp(2.7rem, 7vw, 5.4rem); font-weight: 300; line-height: 1.05; margin: 0 0 18px; text-shadow: 0 2px 22px rgba(0,0,0,.35); }
.pc-slide-title em { color: var(--pc-accent-light); font-style: italic; }
.pc-slide-sub { max-width: 540px; color: rgba(255,255,255,.88); font-weight: 300; line-height: 1.75; margin-bottom: 30px; }
.pc-hero .swiper-pagination { bottom: 48px !important; left: clamp(28px, 6vw, 80px) !important; right: auto !important; width: auto !important; }
.pc-hero .swiper-pagination-bullet { width: 28px; height: 3px; border-radius: 2px; background: rgba(255,255,255,.45); opacity: 1; }
.pc-hero .swiper-pagination-bullet-active { width: 54px; background: white; }
.pc-hero-nav { position: absolute; right: clamp(28px, 6vw, 80px); bottom: 40px; z-index: 4; display: flex; gap: 10px; }
.pc-hero-btn { width: 46px; height: 46px; border-radius: 50%; border: 1px solid rgba(255,255,255,.38); background: rgba(255,255,255,.14); color: white; display: grid; place-items: center; cursor: pointer; backdrop-filter: blur(8px); transition: .25s ease; }
.pc-hero-btn:hover { background: white; color: var(--pc-charcoal); }
.pc-scroll { position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 4; display: flex; flex-direction: column; align-items: center; gap: 8px; color: white; font-size: .7rem; letter-spacing: .15em; text-transform: uppercase; opacity: .78; }
.pc-scroll span { width: 1px; height: 40px; background: rgba(255,255,255,.7); animation: pcPulse 2s infinite; }
@keyframes pcPulse { 0%,100% { transform: scaleY(1); opacity: .45; } 50% { transform: scaleY(.55); opacity: 1; } }

.pc-stats { background: var(--pc-charcoal); display: grid; grid-template-columns: repeat(4, 1fr); }
.pc-stat { padding: 32px 24px; border-right: 1px solid rgba(255,255,255,.08); text-align: center; }
.pc-stat:last-child { border-right: 0; }
.pc-stat-number { font-family: var(--pc-font-display); font-size: clamp(2.1rem, 4vw, 3rem); font-weight: 300; color: var(--pc-accent-light); line-height: 1; }
.pc-stat-label { color: rgba(255,255,255,.56); font-size: .76rem; letter-spacing: .1em; text-transform: uppercase; margin-top: 8px; }

.pc-about { background: white; }
.pc-about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 72px; align-items: center; }
.pc-image-stack { position: relative; min-height: 520px; }
.pc-image-main { position: absolute; top: 0; right: 0; width: 78%; height: 78%; object-fit: cover; border-radius: var(--pc-radius-lg); box-shadow: var(--pc-shadow-lg); }
.pc-image-side { position: absolute; left: 0; bottom: 0; width: 54%; height: 44%; object-fit: cover; border-radius: var(--pc-radius-lg); border: 8px solid white; box-shadow: var(--pc-shadow-md); }
.pc-floating-card { position: absolute; right: 8%; bottom: 8%; background: var(--pc-charcoal); color: white; padding: 24px 28px; border-radius: var(--pc-radius-lg); box-shadow: var(--pc-shadow-lg); max-width: 220px; }
.pc-floating-card strong { display: block; color: var(--pc-accent-light); font-family: var(--pc-font-display); font-size: 2.2rem; font-weight: 300; }
.pc-feature-list { display: grid; gap: 14px; margin-top: 30px; }
.pc-feature { display: flex; gap: 14px; padding: 16px; background: var(--pc-cream); border: 1px solid var(--pc-border); border-radius: var(--pc-radius-lg); }
.pc-feature i { color: var(--pc-accent); font-size: 1.2rem; margin-top: 3px; }
.pc-feature h3 { margin: 0 0 4px; font-size: 1rem; }
.pc-feature p { margin: 0; color: var(--pc-muted); line-height: 1.65; }

.pc-apartments { background: var(--pc-cream); }
.pc-apartment-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
.pc-apartment-card { background: white; border: 1px solid var(--pc-border); border-radius: var(--pc-radius-lg); overflow: hidden; box-shadow: var(--pc-shadow-sm); transition: .3s ease; }
.pc-apartment-card:hover { transform: translateY(-8px); box-shadow: var(--pc-shadow-lg); }
.pc-apartment-img { position: relative; height: 260px; overflow: hidden; }
.pc-apartment-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .55s ease; }
.pc-apartment-card:hover .pc-apartment-img img { transform: scale(1.07); }
.pc-apartment-tag { position: absolute; top: 16px; left: 16px; background: white; color: var(--pc-accent); border-radius: 999px; padding: 7px 14px; font-size: .72rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; box-shadow: var(--pc-shadow-sm); }
.pc-apartment-body { padding: 26px; }
.pc-apartment-body h3 { font-family: var(--pc-font-display); font-size: 1.75rem; font-weight: 400; margin: 0 0 8px; }
.pc-price { color: var(--pc-accent); font-weight: 800; margin-bottom: 16px; }
.pc-apartment-body p { color: var(--pc-muted); line-height: 1.7; margin: 0 0 18px; }
.pc-apartment-meta { display: grid; grid-template-columns: repeat(3,1fr); gap: 8px; border-top: 1px solid var(--pc-border); padding-top: 18px; }
.pc-apartment-meta span { color: var(--pc-muted); font-size: .82rem; }

.pc-gallery { background: var(--pc-charcoal); color: white; }
.pc-gallery .pc-title { color: white; }
.pc-gallery .pc-desc { color: rgba(255,255,255,.65); }
.pc-gallery-grid { display: grid; grid-template-columns: repeat(4, 1fr); grid-auto-rows: 210px; gap: 10px; }
.pc-gallery-item { position: relative; border: 0; padding: 0; overflow: hidden; border-radius: var(--pc-radius-lg); background: transparent; cursor: pointer; }
.pc-gallery-item:nth-child(1), .pc-gallery-item:nth-child(6) { grid-column: span 2; grid-row: span 2; }
.pc-gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .55s ease; }
.pc-gallery-item:hover img { transform: scale(1.08); }
.pc-gallery-item span { position: absolute; left: 16px; right: 16px; bottom: 16px; color: white; font-weight: 700; text-shadow: 0 2px 14px rgba(0,0,0,.45); opacity: 0; transform: translateY(8px); transition: .25s ease; }
.pc-gallery-item::after { content: ''; position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,.58), transparent 60%); opacity: 0; transition: .25s ease; }
.pc-gallery-item:hover::after, .pc-gallery-item:hover span { opacity: 1; transform: translateY(0); }
.pc-lightbox { position: fixed; inset: 0; background: rgba(0,0,0,.92); z-index: 5000; display: none; align-items: center; justify-content: center; padding: 32px; }
.pc-lightbox.pc-open { display: flex; }
.pc-lightbox img { max-width: 92vw; max-height: 86vh; border-radius: var(--pc-radius-lg); object-fit: contain; }
.pc-lightbox-close { position: absolute; top: 22px; right: 22px; width: 48px; height: 48px; border-radius: 50%; border: 1px solid rgba(255,255,255,.22); background: rgba(255,255,255,.1); color: white; font-size: 1.5rem; cursor: pointer; }

.pc-amenities { background: white; }
.pc-amenities-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 22px; }
.pc-amenity { padding: 32px; border: 1px solid var(--pc-border); border-radius: var(--pc-radius-lg); background: var(--pc-cream); transition: .3s ease; }
.pc-amenity:hover { transform: translateY(-6px); box-shadow: var(--pc-shadow-md); background: white; }
.pc-amenity-icon { width: 54px; height: 54px; border-radius: 50%; background: var(--pc-accent-pale); color: var(--pc-accent); display: grid; place-items: center; font-size: 1.2rem; margin-bottom: 22px; }
.pc-amenity h3 { margin: 0 0 8px; font-family: var(--pc-font-display); font-size: 1.55rem; font-weight: 400; }
.pc-amenity p { margin: 0; color: var(--pc-muted); line-height: 1.7; }

.pc-reviews { background: var(--pc-green-pale); overflow: hidden; }
.pc-review-card { background: white; padding: 34px; border-radius: var(--pc-radius-lg); border: 1px solid var(--pc-border); box-shadow: var(--pc-shadow-sm); min-height: 280px; }
.pc-stars { color: var(--pc-accent); letter-spacing: 3px; margin-bottom: 18px; }
.pc-review-text { color: var(--pc-slate); line-height: 1.8; font-family: var(--pc-font-display); font-size: 1.35rem; font-style: italic; }
.pc-review-author { display: flex; align-items: center; gap: 12px; margin-top: 24px; }
.pc-review-avatar { width: 44px; height: 44px; border-radius: 50%; background: var(--pc-charcoal); color: white; display: grid; place-items: center; font-weight: 800; }
.pc-review-name { font-weight: 800; }
.pc-review-source { color: var(--pc-muted); font-size: .82rem; }

.pc-social { background: white; }
.pc-social-tabs { display: flex; justify-content: center; gap: 10px; margin-bottom: 34px; flex-wrap: wrap; }
.pc-social-tab { border: 1px solid var(--pc-border); background: white; border-radius: 999px; padding: 10px 18px; cursor: pointer; font-weight: 800; color: var(--pc-slate); }
.pc-social-tab.pc-active { background: var(--pc-charcoal); color: white; border-color: var(--pc-charcoal); }
.pc-social-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
.pc-social-card { position: relative; overflow: hidden; border-radius: var(--pc-radius-lg); aspect-ratio: 1; background: var(--pc-accent-pale); }
.pc-social-card img { width: 100%; height: 100%; object-fit: cover; transition: .45s ease; }
.pc-social-card:hover img { transform: scale(1.08); }
.pc-social-overlay { position: absolute; inset: 0; display: grid; place-items: center; background: rgba(0,0,0,.42); color: white; opacity: 0; transition: .25s ease; font-size: 1.7rem; }
.pc-social-card:hover .pc-social-overlay { opacity: 1; }

.pc-contact { background: var(--pc-cream); }
.pc-contact-grid { display: grid; grid-template-columns: 1.05fr .95fr; gap: 56px; align-items: start; }
.pc-form { background: white; padding: 38px; border-radius: var(--pc-radius-lg); border: 1px solid var(--pc-border); box-shadow: var(--pc-shadow-md); }
.pc-form-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 16px; }
.pc-field { margin-bottom: 16px; }
.pc-field label { display: block; font-size: .75rem; text-transform: uppercase; letter-spacing: .12em; font-weight: 800; color: var(--pc-accent); margin-bottom: 8px; }
.pc-field input, .pc-field select, .pc-field textarea { width: 100%; border: 1px solid var(--pc-border); background: var(--pc-cream); border-radius: var(--pc-radius); padding: 14px 16px; font: inherit; color: var(--pc-charcoal); outline: 0; }
.pc-field input:focus, .pc-field select:focus, .pc-field textarea:focus { border-color: var(--pc-accent); box-shadow: 0 0 0 3px rgba(139,111,78,.12); background: white; }
.pc-field textarea { min-height: 130px; resize: vertical; }
.pc-contact-info { display: grid; gap: 16px; }
.pc-info-card { display: flex; gap: 16px; align-items: flex-start; background: white; border: 1px solid var(--pc-border); border-radius: var(--pc-radius-lg); padding: 22px; }
.pc-info-card i { color: var(--pc-accent); font-size: 1.25rem; margin-top: 3px; }
.pc-info-card h3 { margin: 0 0 5px; font-size: 1rem; }
.pc-info-card p, .pc-info-card a { margin: 0; color: var(--pc-muted); text-decoration: none; line-height: 1.6; }
.pc-info-card a:hover { color: var(--pc-accent); }

.pc-map-cta { position: relative; min-height: 520px; background: var(--pc-charcoal); color: white; overflow: hidden; }
.pc-map-wrap { position: absolute; inset: 0; opacity: .72; }
#pcMap { width: 100%; height: 100%; min-height: 520px; filter: grayscale(.2) contrast(1.05); }
.pc-map-panel { position: relative; z-index: 2; min-height: 520px; }
.pc-map-panel .pc-container { min-height: 520px; display: flex; align-items: center; }
.pc-map-card { max-width: 460px; background: rgba(26,26,26,.88); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,.16); border-radius: var(--pc-radius-lg); padding: 42px; box-shadow: var(--pc-shadow-lg); }
.pc-map-card .pc-title { color: white; font-size: clamp(2rem, 4vw, 3.2rem); }
.pc-map-card .pc-desc { color: rgba(255,255,255,.72); margin-bottom: 24px; }

.pc-footer { background: var(--pc-charcoal); color: rgba(255,255,255,.72); padding: 72px 0 28px; }
.pc-footer-grid { display: grid; grid-template-columns: 1.6fr 1fr 1fr 1.2fr; gap: 42px; margin-bottom: 46px; }
.pc-footer h3, .pc-footer h4 { color: white; margin: 0 0 18px; }
.pc-footer h3 { font-family: var(--pc-font-display); font-size: 1.7rem; font-weight: 400; }
.pc-footer h4 { font-size: .82rem; text-transform: uppercase; letter-spacing: .14em; }
.pc-footer p { line-height: 1.75; }
.pc-footer ul { list-style: none; padding: 0; margin: 0; display: grid; gap: 10px; }
.pc-footer a { color: rgba(255,255,255,.72); text-decoration: none; }
.pc-footer a:hover { color: var(--pc-accent-light); }
.pc-footer-bottom { border-top: 1px solid rgba(255,255,255,.1); padding-top: 22px; display: flex; justify-content: space-between; gap: 16px; flex-wrap: wrap; color: rgba(255,255,255,.45); font-size: .9rem; }

@media (max-width: 1180px) {
    .pc-nav { padding: 0 24px; }
    .pc-nav-links { gap: 18px; }
    .pc-apartment-grid, .pc-amenities-grid { grid-template-columns: repeat(2,1fr); }
    .pc-footer-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 860px) {
    .pc-page { padding-top: 74px; }
    .pc-nav-links { display: none; }
    .pc-hamburger { display: flex; }
    .pc-nav-logo { min-width: auto; }
    .pc-logo-sub { display: none; }
    .pc-hero { min-height: 620px; }
    .pc-slide-content { right: 28px; }
    .pc-hero-nav, .pc-scroll { display: none; }
    .pc-stats { grid-template-columns: repeat(2,1fr); }
    .pc-about-grid, .pc-contact-grid { grid-template-columns: 1fr; gap: 42px; }
    .pc-image-stack { min-height: 360px; }
    .pc-gallery-grid { grid-template-columns: repeat(2,1fr); grid-auto-rows: 180px; }
    .pc-gallery-item:nth-child(1), .pc-gallery-item:nth-child(6) { grid-column: span 1; grid-row: span 1; }
    .pc-social-grid { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 560px) {
    .pc-container { width: min(100% - 28px, 1180px); }
    .pc-section { padding: 68px 0; }
    .pc-nav { min-height: 68px; padding: 0 14px; }
    .pc-logo-img { max-width: 170px; }
    .pc-logo-name { font-size: 1.08rem; }
    .pc-slide-title { font-size: 2.65rem; }
    .pc-slide-sub { font-size: .95rem; }
    .pc-stats, .pc-apartment-grid, .pc-amenities-grid, .pc-social-grid, .pc-form-grid, .pc-footer-grid { grid-template-columns: 1fr; }
    .pc-stat { border-right: 0; border-bottom: 1px solid rgba(255,255,255,.08); }
    .pc-form { padding: 24px; }
    .pc-map-card { padding: 28px; }
}
</style>
