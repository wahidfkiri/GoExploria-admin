<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GoExploria — Pages Détail Composants</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600&family=Space+Grotesk:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Bebas+Neue&family=Outfit:wght@300;400;500;700;900&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;background:#f5f3ef;color:#1a1a1a}

/* NAV */
.site-nav{position:fixed;top:0;left:0;right:0;z-index:999;background:rgba(255,255,255,0.95);backdrop-filter:blur(12px);border-bottom:1px solid #e8e2d9;padding:0 40px}
.nav-inner{display:flex;align-items:center;justify-content:space-between;height:64px;max-width:1400px;margin:0 auto}
.nav-logo{display:flex;align-items:center;gap:10px}
.nav-logo-mark{width:36px;height:36px;background:linear-gradient(135deg,#e8761a,#c04f10);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:14px;font-family:'Bebas Neue',sans-serif;letter-spacing:1px}
.nav-logo-text{font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:15px;color:#1a1a1a;letter-spacing:-0.3px}
.nav-links{display:flex;gap:6px;list-style:none}
.nav-links a{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;color:#666;text-decoration:none;padding:6px 12px;border-radius:6px;transition:all 0.2s;white-space:nowrap}
.nav-links a:hover{color:#e8761a;background:#fef3ea}

/* HERO GLOBAL */
.page-hero{padding:140px 40px 80px;text-align:center;max-width:900px;margin:0 auto}
.page-hero-tag{display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#e8761a;background:#fef3ea;padding:6px 16px;border-radius:999px;margin-bottom:24px}
.page-hero h1{font-family:'Playfair Display',serif;font-size:clamp(42px,6vw,80px);line-height:1.05;color:#1a1a1a;margin-bottom:20px}
.page-hero p{font-size:18px;color:#666;line-height:1.7;max-width:650px;margin:0 auto}

/* SECTION WRAPPER */
.section-page{padding:80px 0;border-top:1px solid #e8e2d9}
.container{max-width:1300px;margin:0 auto;padding:0 40px}
.container-wide{max-width:1500px;margin:0 auto;padding:0 40px}

/* =========================================================
   1. AVIS CLIENTS — Magazine editorial warm cream
   ========================================================= */
#avis-clients-page{background:#faf7f2}
.avis-hero-strip{background:#1a1a1a;color:#fff;padding:100px 40px;position:relative;overflow:hidden}
.avis-hero-strip::before{content:'';position:absolute;right:-100px;top:-100px;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(232,118,26,0.15),transparent 70%)}
.avis-hero-inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.avis-hero-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#e8761a;margin-bottom:16px}
.avis-hero-title{font-family:'Playfair Display',serif;font-size:clamp(36px,4vw,56px);line-height:1.1;margin-bottom:24px}
.avis-hero-desc{font-size:16px;color:rgba(255,255,255,0.7);line-height:1.8;margin-bottom:36px}
.avis-score-big{display:flex;align-items:flex-end;gap:20px}
.avis-score-num{font-family:'Bebas Neue',sans-serif;font-size:96px;color:#e8761a;line-height:1}
.avis-score-stars{display:flex;flex-direction:column;gap:4px;padding-bottom:12px}
.avis-score-stars span{color:#e8761a;font-size:22px;letter-spacing:2px}
.avis-score-stars small{color:rgba(255,255,255,0.6);font-size:13px}
.avis-hero-img{border-radius:20px;overflow:hidden;height:380px}
.avis-hero-img img{width:100%;height:100%;object-fit:cover}

.avis-stats-bar{background:#e8761a;padding:28px 40px}
.avis-stats-bar-inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:0}
.avis-stat-item{text-align:center;padding:0 24px;border-right:1px solid rgba(255,255,255,0.3)}
.avis-stat-item:last-child{border-right:none}
.avis-stat-item strong{display:block;font-family:'Bebas Neue',sans-serif;font-size:44px;color:#fff;line-height:1}
.avis-stat-item span{font-size:12px;color:rgba(255,255,255,0.85);text-transform:uppercase;letter-spacing:0.8px;font-weight:600}

.avis-main{padding:80px 40px}
.avis-main-inner{max-width:1200px;margin:0 auto}
.avis-section-title{font-family:'Playfair Display',serif;font-size:32px;color:#1a1a1a;margin-bottom:48px;position:relative;padding-bottom:16px}
.avis-section-title::after{content:'';position:absolute;bottom:0;left:0;width:60px;height:3px;background:#e8761a}

.avis-grid-featured{display:grid;grid-template-columns:1.6fr 1fr 1fr;gap:24px;margin-bottom:48px}
.avis-card-featured{background:#fff;border-radius:20px;padding:36px;border:1px solid #f0ebe2;position:relative;overflow:hidden}
.avis-card-featured::before{content:'"';position:absolute;top:-10px;right:20px;font-family:'Playfair Display',serif;font-size:140px;color:#f0ebe2;line-height:1}
.avis-card-featured .stars{color:#f59e0b;font-size:18px;letter-spacing:2px;margin-bottom:20px}
.avis-card-featured .quote{font-family:'Libre Baskerville',serif;font-size:17px;line-height:1.7;color:#2a2a2a;margin-bottom:24px;position:relative;z-index:1}
.avis-card-featured .author{display:flex;align-items:center;gap:12px}
.avis-card-featured .author img{width:48px;height:48px;border-radius:50%;object-fit:cover}
.avis-card-featured .author-name{font-weight:600;font-size:14px;color:#1a1a1a}
.avis-card-featured .author-role{font-size:12px;color:#999}
.avis-card-secondary{background:#fff;border-radius:20px;padding:28px;border:1px solid #f0ebe2}

.avis-platform-row{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.avis-platform-card{background:#fff;border-radius:16px;padding:28px;border:1px solid #f0ebe2;display:flex;flex-direction:column;gap:16px}
.avis-platform-badge{display:inline-flex;align-items:center;gap:8px;background:#f8f8f8;border-radius:8px;padding:8px 14px;width:fit-content}
.g-badge{font-size:20px;font-weight:900;background:linear-gradient(135deg,#4285f4,#ea4335,#fbbc05,#34a853);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.avis-platform-score{font-size:40px;font-weight:700;color:#1a1a1a;font-family:'Space Grotesk',sans-serif}
.avis-platform-score span{font-size:16px;color:#888;font-weight:400}

/* =========================================================
   2. BUSINESS & TOURISM — Bold geometric navy + orange
   ========================================================= */
#business-tourism-page{background:#fff}
.bt-hero{background:#0d1b35;min-height:600px;position:relative;overflow:hidden;display:flex;align-items:center}
.bt-hero-bg{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1600&h=800&fit=crop')center/cover;opacity:0.12}
.bt-hero-geometric{position:absolute;right:0;top:0;bottom:0;width:45%;clip-path:polygon(15% 0,100% 0,100% 100%,0% 100%);background:linear-gradient(135deg,#e8761a,#f5a623);opacity:0.9}
.bt-hero-content{position:relative;z-index:2;padding:80px;max-width:680px}
.bt-hero-eyebrow{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#e8761a;margin-bottom:20px;display:flex;align-items:center;gap:8px}
.bt-hero-eyebrow::before{content:'';width:32px;height:2px;background:#e8761a}
.bt-hero-title{font-family:'Bebas Neue',sans-serif;font-size:clamp(60px,7vw,96px);color:#fff;line-height:0.95;margin-bottom:24px;letter-spacing:1px}
.bt-hero-title em{color:#e8761a;font-style:normal}
.bt-hero-desc{font-size:16px;color:rgba(255,255,255,0.75);line-height:1.8;margin-bottom:40px;max-width:500px}
.bt-cta-group{display:flex;gap:16px;flex-wrap:wrap}
.btn-primary-orange{background:#e8761a;color:#fff;padding:14px 32px;border-radius:8px;font-weight:700;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all 0.2s}
.btn-primary-orange:hover{background:#c45e0e;transform:translateY(-2px)}
.btn-outline-white{border:2px solid rgba(255,255,255,0.4);color:#fff;padding:14px 32px;border-radius:8px;font-weight:700;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all 0.2s}
.btn-outline-white:hover{border-color:#fff;background:rgba(255,255,255,0.1)}

.bt-dual{padding:80px 40px;max-width:1300px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:40px}
.bt-card-detail{border-radius:24px;overflow:hidden;border:1px solid #eee}
.bt-card-detail-header{padding:40px;background:#f8f9fb;border-bottom:1px solid #eee;display:flex;align-items:center;gap:20px}
.bt-card-icon{width:64px;height:64px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:28px;flex-shrink:0}
.bt-card-icon.orange{background:linear-gradient(135deg,#fef3ea,#fde4c5);color:#e8761a}
.bt-card-icon.blue{background:linear-gradient(135deg,#eff6ff,#dbeafe);color:#2563eb}
.bt-card-detail-title{font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:700;color:#1a1a1a}
.bt-card-detail-sub{font-size:13px;color:#888;margin-top:4px}
.bt-card-detail-body{padding:36px}
.bt-feature-list{list-style:none;display:flex;flex-direction:column;gap:14px;margin-bottom:28px}
.bt-feature-list li{display:flex;align-items:flex-start;gap:12px;font-size:14px;color:#444}
.bt-feature-list li i{color:#10b981;font-size:16px;flex-shrink:0;margin-top:1px}
.bt-card-img{width:100%;height:220px;object-fit:cover;border-radius:12px;margin-bottom:24px}
.bt-stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:0;background:#0d1b35;border-radius:20px;overflow:hidden;margin:0 40px 80px;max-width:1300px;margin-left:auto;margin-right:auto}
.bt-stat-box{padding:36px 24px;text-align:center;border-right:1px solid rgba(255,255,255,0.1)}
.bt-stat-box:last-child{border-right:none}
.bt-stat-box strong{display:block;font-family:'Bebas Neue',sans-serif;font-size:52px;color:#e8761a;line-height:1}
.bt-stat-box span{font-size:12px;color:rgba(255,255,255,0.7);text-transform:uppercase;letter-spacing:0.8px;margin-top:4px;display:block}

/* =========================================================
   3. DESTINATIONS VEDETTES — Immersive travel editorial
   ========================================================= */
#destinations-page{background:#f9f7f4}
.dest-cinematic{height:85vh;min-height:560px;position:relative;overflow:hidden;display:flex;align-items:flex-end}
.dest-cinematic-bg{position:absolute;inset:0}
.dest-cinematic-bg img{width:100%;height:100%;object-fit:cover}
.dest-cinematic-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(10,15,25,0.92) 0%,rgba(10,15,25,0.2) 60%,transparent 100%)}
.dest-cinematic-content{position:relative;z-index:2;padding:60px 80px;width:100%;display:flex;align-items:flex-end;justify-content:space-between;gap:40px}
.dest-cinematic-left{}
.dest-breadcrumb{display:flex;align-items:center;gap:8px;font-size:12px;color:rgba(255,255,255,0.6);margin-bottom:16px}
.dest-breadcrumb span{color:rgba(255,255,255,0.4)}
.dest-cinematic-title{font-family:'Playfair Display',serif;font-size:clamp(48px,6vw,80px);color:#fff;line-height:1.05;margin-bottom:16px}
.dest-cinematic-desc{font-size:16px;color:rgba(255,255,255,0.8);line-height:1.7;max-width:520px;margin-bottom:32px}
.dest-tag-cloud{display:flex;flex-wrap:wrap;gap:8px}
.dest-tag{background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.2);color:#fff;font-size:12px;font-weight:600;padding:6px 14px;border-radius:999px}
.dest-cinematic-right{min-width:280px}
.dest-weather-card{background:rgba(255,255,255,0.12);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.2);border-radius:20px;padding:28px;color:#fff}
.dest-weather-temp{font-family:'Bebas Neue',sans-serif;font-size:64px;line-height:1}
.dest-weather-label{font-size:13px;color:rgba(255,255,255,0.7);margin-top:4px}
.dest-weather-row{display:flex;justify-content:space-between;margin-top:20px;padding-top:20px;border-top:1px solid rgba(255,255,255,0.15)}
.dest-weather-row span{font-size:12px;color:rgba(255,255,255,0.7);text-align:center}
.dest-weather-row strong{display:block;font-size:16px;color:#fff}

.dest-cards-section{padding:70px 40px;max-width:1300px;margin:0 auto}
.dest-cards-section-title{font-family:'Playfair Display',serif;font-size:36px;margin-bottom:40px}
.dest-cards-scroll{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.dest-dest-card{border-radius:20px;overflow:hidden;position:relative;aspect-ratio:3/4;cursor:pointer;transition:transform 0.3s}
.dest-dest-card:hover{transform:scale(1.02)}
.dest-dest-card img{width:100%;height:100%;object-fit:cover}
.dest-dest-card-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.8),transparent 55%);padding:24px;display:flex;flex-direction:column;justify-content:flex-end}
.dest-dest-card h3{color:#fff;font-size:20px;font-weight:700;font-family:'Playfair Display',serif;margin-bottom:4px}
.dest-dest-card p{color:rgba(255,255,255,0.8);font-size:12px}
.dest-dest-card .dest-rating{color:#f59e0b;font-size:13px;margin-top:8px}
.dest-badge-pill{position:absolute;top:16px;left:16px;background:#e8761a;color:#fff;font-size:10px;font-weight:700;padding:4px 10px;border-radius:999px;text-transform:uppercase;letter-spacing:0.8px}

.dest-filters-row{display:flex;gap:10px;margin-bottom:32px;flex-wrap:wrap}
.dest-filter-btn{background:#fff;border:1.5px solid #e5e7eb;border-radius:999px;font-size:13px;font-weight:600;color:#666;padding:8px 20px;cursor:pointer;transition:all 0.2s}
.dest-filter-btn:hover,.dest-filter-btn.active{border-color:#e8761a;color:#e8761a;background:#fef3ea}

/* =========================================================
   4. ESPACE BLOG — Modern editorial magazine
   ========================================================= */
#blog-page{background:#fff}
.blog-masthead{background:#f0ece4;padding:80px 40px 0;position:relative;overflow:hidden}
.blog-masthead-inner{max-width:1300px;margin:0 auto}
.blog-masthead-header{display:grid;grid-template-columns:1fr auto;align-items:end;gap:40px;padding-bottom:40px;border-bottom:2px solid #1a1a1a;margin-bottom:48px}
.blog-masthead-meta{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#999;margin-bottom:12px}
.blog-masthead-title{font-family:'Playfair Display',serif;font-size:clamp(52px,6vw,80px);line-height:0.95;color:#1a1a1a}
.blog-masthead-title em{font-style:italic;color:#e8761a}
.blog-date-box{text-align:right}
.blog-date-num{font-family:'Bebas Neue',sans-serif;font-size:80px;color:#1a1a1a;line-height:1}
.blog-date-label{font-size:12px;color:#999;text-transform:uppercase;letter-spacing:1px}

.blog-hero-grid{display:grid;grid-template-columns:2fr 1fr;gap:2px;margin-bottom:2px}
.blog-hero-feature{position:relative;height:520px;overflow:hidden;cursor:pointer}
.blog-hero-feature img{width:100%;height:100%;object-fit:cover;transition:transform 0.6s}
.blog-hero-feature:hover img{transform:scale(1.04)}
.blog-hero-feature-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.85),transparent 50%);padding:40px}
.blog-hero-feature-overlay{display:flex;flex-direction:column;justify-content:flex-end}
.blog-category-tag{display:inline-block;background:#e8761a;color:#fff;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;padding:4px 12px;border-radius:3px;margin-bottom:12px;width:fit-content}
.blog-hero-feature h2{font-family:'Playfair Display',serif;font-size:32px;color:#fff;line-height:1.2;margin-bottom:12px}
.blog-hero-feature p{font-size:14px;color:rgba(255,255,255,0.8)}
.blog-hero-side{display:flex;flex-direction:column;gap:2px}
.blog-mini-card{position:relative;height:259px;overflow:hidden;cursor:pointer}
.blog-mini-card img{width:100%;height:100%;object-fit:cover;transition:transform 0.4s}
.blog-mini-card:hover img{transform:scale(1.06)}
.blog-mini-card-content{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.8),transparent 50%);padding:20px;display:flex;flex-direction:column;justify-content:flex-end}
.blog-mini-card-content h4{font-family:'Playfair Display',serif;font-size:18px;color:#fff;margin-bottom:6px;line-height:1.3}
.blog-mini-card-content span{font-size:11px;color:rgba(255,255,255,0.7)}

.blog-articles-grid{max-width:1300px;margin:60px auto;padding:0 40px}
.blog-articles-row{display:grid;grid-template-columns:repeat(3,1fr);gap:32px}
.blog-article-card{border-bottom:1px solid #e5e7eb;padding-bottom:32px}
.blog-article-img{height:220px;border-radius:12px;overflow:hidden;margin-bottom:20px}
.blog-article-img img{width:100%;height:100%;object-fit:cover}
.blog-article-meta{display:flex;align-items:center;gap:12px;margin-bottom:12px}
.blog-article-meta .cat{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#e8761a}
.blog-article-meta .date{font-size:11px;color:#999}
.blog-article-card h3{font-family:'Playfair Display',serif;font-size:20px;line-height:1.3;color:#1a1a1a;margin-bottom:10px}
.blog-article-card p{font-size:13px;color:#666;line-height:1.7}
.blog-article-card .read-more{display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:700;color:#e8761a;text-decoration:none;margin-top:14px;text-transform:uppercase;letter-spacing:0.5px}

/* =========================================================
   5. ESPACE CHAT — Tech-forward clean SaaS
   ========================================================= */
#chat-page{background:#f8faff}
.chat-hero{background:linear-gradient(135deg,#1e3a5f 0%,#0f2240 100%);padding:100px 40px;position:relative;overflow:hidden}
.chat-hero-circles{position:absolute;right:-80px;top:-80px}
.chat-hero-circles .c1{width:400px;height:400px;border-radius:50%;border:1px solid rgba(255,255,255,0.06);position:absolute;top:-100px;right:-100px}
.chat-hero-circles .c2{width:280px;height:280px;border-radius:50%;border:1px solid rgba(255,255,255,0.06);position:absolute;top:-40px;right:-40px}
.chat-hero-inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.chat-hero-label{display:inline-flex;align-items:center;gap:6px;background:rgba(52,211,153,0.15);color:#34d399;border:1px solid rgba(52,211,153,0.3);border-radius:999px;padding:6px 16px;font-size:12px;font-weight:700;margin-bottom:24px}
.chat-hero-label::before{content:'';width:8px;height:8px;border-radius:50%;background:#34d399;animation:pulse 2s infinite}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:0.4}}
.chat-hero-title{font-family:'Space Grotesk',sans-serif;font-size:clamp(36px,4vw,56px);color:#fff;font-weight:700;line-height:1.1;margin-bottom:20px}
.chat-hero-desc{font-size:16px;color:rgba(255,255,255,0.7);line-height:1.8;margin-bottom:36px}
.chat-kpi-mini{display:flex;gap:24px}
.chat-kpi-mini-item{text-align:center}
.chat-kpi-mini-item strong{display:block;font-size:28px;font-weight:700;color:#fff;font-family:'Space Grotesk',sans-serif}
.chat-kpi-mini-item span{font-size:11px;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:0.8px}
.chat-mockup{background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.12);border-radius:20px;overflow:hidden}
.chat-mockup-topbar{background:rgba(255,255,255,0.06);padding:12px 20px;display:flex;align-items:center;gap:8px;border-bottom:1px solid rgba(255,255,255,0.08)}
.chat-mockup-dots{display:flex;gap:6px}
.chat-mockup-dots span{width:10px;height:10px;border-radius:50%}
.chat-mockup-dots .d1{background:#ff5f57}
.chat-mockup-dots .d2{background:#febc2e}
.chat-mockup-dots .d3{background:#28c840}
.chat-mockup-body{padding:20px;display:flex;flex-direction:column;gap:16px;min-height:300px}
.chat-bubble{display:flex;gap:10px;align-items:flex-start}
.chat-bubble.right{flex-direction:row-reverse}
.chat-bubble-avatar{width:32px;height:32px;border-radius:50%;overflow:hidden;flex-shrink:0}
.chat-bubble-avatar img{width:100%;height:100%;object-fit:cover}
.chat-bubble-msg{background:rgba(255,255,255,0.1);border-radius:12px;padding:12px 16px;font-size:13px;color:rgba(255,255,255,0.9);max-width:220px;line-height:1.5}
.chat-bubble.right .chat-bubble-msg{background:#e8761a;color:#fff}
.chat-platform-row{display:flex;gap:8px;flex-wrap:wrap;padding:12px 20px;border-top:1px solid rgba(255,255,255,0.08)}
.chat-platform-tag{background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);color:rgba(255,255,255,0.8);font-size:11px;font-weight:600;padding:4px 12px;border-radius:6px}

.chat-features{padding:80px 40px;max-width:1200px;margin:0 auto}
.chat-features-title{font-family:'Space Grotesk',sans-serif;font-size:36px;font-weight:700;margin-bottom:48px;color:#1a1a1a}
.chat-features-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.chat-feature-card{background:#fff;border-radius:16px;padding:32px;border:1px solid #e5e7eb;transition:all 0.3s}
.chat-feature-card:hover{border-color:#1e3a5f;transform:translateY(-4px);box-shadow:0 20px 40px rgba(30,58,95,0.1)}
.chat-feature-icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:20px;background:#eff6ff;color:#1e3a5f}
.chat-feature-card h4{font-size:16px;font-weight:700;color:#1a1a1a;margin-bottom:10px}
.chat-feature-card p{font-size:13px;color:#666;line-height:1.7}
.chat-metrics-section{background:#1e3a5f;border-radius:24px;margin:0 40px 80px;max-width:1200px;margin-left:auto;margin-right:auto;padding:60px;display:grid;grid-template-columns:repeat(3,1fr);gap:0}
.chat-metric-box{padding:20px 40px;text-align:center;border-right:1px solid rgba(255,255,255,0.1)}
.chat-metric-box:last-child{border-right:none}
.chat-metric-box strong{display:block;font-family:'Space Grotesk',sans-serif;font-size:48px;color:#34d399;font-weight:700}
.chat-metric-box span{color:rgba(255,255,255,0.7);font-size:13px;margin-top:6px;display:block}

/* =========================================================
   6. MAIL MARKETING — Warm productivity / Notion-ish
   ========================================================= */
#mail-page{background:#fffdf9}
.mail-hero{background:#f5f0e8;border-bottom:2px solid #1a1a1a;padding:80px 40px}
.mail-hero-inner{max-width:1200px;margin:0 auto}
.mail-hero-tag{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#e8761a;margin-bottom:16px}
.mail-hero-row{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.mail-hero-h{font-family:'Bebas Neue',sans-serif;font-size:clamp(64px,8vw,110px);color:#1a1a1a;line-height:0.9;margin-bottom:24px}
.mail-hero-sub{font-size:18px;color:#555;line-height:1.7;margin-bottom:40px;max-width:460px}
.mail-metrics-panel{background:#1a1a1a;border-radius:20px;padding:40px;color:#fff}
.mail-metric-row{display:flex;justify-content:space-between;align-items:center;padding:16px 0;border-bottom:1px solid rgba(255,255,255,0.08)}
.mail-metric-row:last-child{border-bottom:none}
.mail-metric-label{font-size:13px;color:rgba(255,255,255,0.6)}
.mail-metric-bar-wrap{flex:1;margin:0 20px;height:6px;background:rgba(255,255,255,0.1);border-radius:999px;overflow:hidden}
.mail-metric-bar{height:100%;border-radius:999px;background:linear-gradient(90deg,#e8761a,#f5a623)}
.mail-metric-value{font-weight:700;font-size:16px;color:#fff;min-width:50px;text-align:right}

.mail-campaigns{padding:80px 40px;max-width:1300px;margin:0 auto}
.mail-campaigns-title{font-family:'Playfair Display',serif;font-size:36px;margin-bottom:48px}
.mail-campaigns-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px}
.mail-campaign{border:1.5px solid #e5e7eb;border-radius:20px;overflow:hidden;background:#fff}
.mail-campaign-img{height:240px;overflow:hidden}
.mail-campaign-img img{width:100%;height:100%;object-fit:cover;transition:transform 0.4s}
.mail-campaign:hover .mail-campaign-img img{transform:scale(1.05)}
.mail-campaign-body{padding:32px}
.mail-campaign-type{display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:#e8761a;margin-bottom:12px}
.mail-campaign-body h3{font-size:20px;font-weight:700;color:#1a1a1a;margin-bottom:10px}
.mail-campaign-body p{font-size:13px;color:#666;line-height:1.7;margin-bottom:20px}
.mail-features-ul{list-style:none;display:flex;flex-direction:column;gap:8px}
.mail-features-ul li{font-size:13px;color:#555;display:flex;align-items:center;gap:8px}
.mail-features-ul li i{color:#10b981;font-size:14px}
.mail-kpi-highlight{display:flex;gap:8px;margin-top:20px;padding-top:20px;border-top:1px solid #f0f0f0}
.mail-kpi-chip{background:#fef3ea;color:#e8761a;font-size:12px;font-weight:700;padding:6px 12px;border-radius:8px}

/* =========================================================
   7. SOCIAL MEDIA — Gradient-accent colorful platform
   ========================================================= */
#social-page{background:#fff}
.social-top{background:linear-gradient(135deg,#ff6b35 0%,#f7931e 30%,#ffd23f 100%);padding:100px 40px;clip-path:polygon(0 0,100% 0,100% 88%,0 100%)}
.social-top-inner{max-width:1200px;margin:0 auto;text-align:center}
.social-top h1{font-family:'Outfit',sans-serif;font-size:clamp(48px,6vw,80px);font-weight:900;color:#fff;line-height:1;margin-bottom:20px}
.social-top p{font-size:18px;color:rgba(255,255,255,0.9);line-height:1.7;max-width:600px;margin:0 auto 40px}
.social-platform-pills{display:flex;flex-wrap:wrap;justify-content:center;gap:12px}
.social-pill{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.2);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.4);color:#fff;font-size:14px;font-weight:700;padding:10px 20px;border-radius:999px;transition:all 0.2s}
.social-pill:hover{background:rgba(255,255,255,0.35)}

.social-platforms-grid{padding:80px 40px;max-width:1200px;margin:0 auto}
.social-platforms-title{font-family:'Outfit',sans-serif;font-size:36px;font-weight:800;margin-bottom:48px;color:#1a1a1a}
.social-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.social-platform-card{border-radius:20px;padding:32px;position:relative;overflow:hidden;cursor:pointer;transition:transform 0.3s}
.social-platform-card:hover{transform:translateY(-6px)}
.social-platform-card.insta{background:linear-gradient(135deg,#833ab4,#fd1d1d,#fcb045)}
.social-platform-card.fb{background:linear-gradient(135deg,#1877f2,#0d5bc1)}
.social-platform-card.tt{background:linear-gradient(135deg,#010101,#333)}
.social-platform-card.li{background:linear-gradient(135deg,#0077b5,#005182)}
.social-platform-card.yt{background:linear-gradient(135deg,#ff0000,#cc0000)}
.social-platform-card.pin{background:linear-gradient(135deg,#bd081c,#900614)}
.social-platform-card.tw{background:linear-gradient(135deg,#0f141e,#1c2a3f)}
.social-platform-card.sn{background:linear-gradient(135deg,#fffc00,#ffd60a)}
.social-platform-icon{font-size:36px;color:#fff;margin-bottom:16px}
.social-platform-card.sn .social-platform-icon{color:#333}
.social-platform-name{font-size:18px;font-weight:700;color:#fff;margin-bottom:6px}
.social-platform-card.sn .social-platform-name{color:#333}
.social-platform-followers{font-size:12px;color:rgba(255,255,255,0.8);margin-bottom:16px}
.social-platform-card.sn .social-platform-followers{color:rgba(0,0,0,0.6)}
.social-platform-metric{background:rgba(255,255,255,0.15);border-radius:8px;padding:8px 12px;font-size:12px;font-weight:700;color:#fff;display:inline-block}
.social-platform-card.sn .social-platform-metric{color:#333}

.social-services{background:#f8f8f8;padding:80px 40px}
.social-services-inner{max-width:1200px;margin:0 auto}
.social-services-title{font-family:'Outfit',sans-serif;font-size:36px;font-weight:800;margin-bottom:48px;color:#1a1a1a}
.social-services-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:24px}
.social-service-item{background:#fff;border-radius:20px;padding:40px;border:1px solid #eee;display:grid;grid-template-columns:auto 1fr;gap:24px;align-items:start;transition:all 0.3s}
.social-service-item:hover{box-shadow:0 20px 50px rgba(0,0,0,0.08);transform:translateY(-2px)}
.social-service-icon-box{width:56px;height:56px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;color:#fff;background:linear-gradient(135deg,#ff6b35,#f7931e);flex-shrink:0}
.social-service-item h4{font-size:18px;font-weight:700;color:#1a1a1a;margin-bottom:10px;font-family:'Outfit',sans-serif}
.social-service-item p{font-size:14px;color:#666;line-height:1.7}

/* =========================================================
   8. GALLERIE CAROUSSEL — Pinterest-inspired light gallery
   ========================================================= */
#gallerie-page{background:#fafafa}
.gallery-hero{background:#fff;padding:80px 40px 60px;border-bottom:1px solid #f0f0f0}
.gallery-hero-inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr auto;align-items:center;gap:40px}
.gallery-hero-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#e8761a;display:flex;align-items:center;gap:8px;margin-bottom:16px}
.gallery-hero-label::before{content:'';width:24px;height:2px;background:#e8761a}
.gallery-hero h1{font-family:'Playfair Display',serif;font-size:clamp(40px,5vw,64px);color:#1a1a1a;line-height:1.1;margin-bottom:16px}
.gallery-hero p{font-size:16px;color:#666;line-height:1.7;max-width:520px}
.gallery-hero-count{text-align:right}
.gallery-hero-count strong{font-family:'Bebas Neue',sans-serif;font-size:80px;color:#1a1a1a;line-height:1}
.gallery-hero-count span{display:block;font-size:12px;color:#999;text-transform:uppercase;letter-spacing:1px}

.gallery-filter-bar{background:#fff;padding:20px 40px;border-bottom:1px solid #f0f0f0;display:flex;gap:10px;flex-wrap:wrap;position:sticky;top:64px;z-index:10}
.gallery-filter-btn{border:1.5px solid #e5e7eb;background:#fff;border-radius:999px;font-size:12px;font-weight:700;color:#666;padding:8px 18px;cursor:pointer;display:flex;align-items:center;gap:6px;transition:all 0.2s}
.gallery-filter-btn:hover,.gallery-filter-btn.active{background:#e8761a;border-color:#e8761a;color:#fff}

.gallery-masonry{padding:40px;max-width:1400px;margin:0 auto;column-count:5;column-gap:16px}
.gallery-item{break-inside:avoid;margin-bottom:16px;border-radius:16px;overflow:hidden;cursor:pointer;position:relative;transition:transform 0.3s}
.gallery-item:hover{transform:scale(1.02);z-index:2}
.gallery-item img{width:100%;display:block}
.gallery-item-overlay{position:absolute;inset:0;background:rgba(0,0,0,0);transition:background 0.3s;padding:16px;display:flex;flex-direction:column;justify-content:flex-end}
.gallery-item:hover .gallery-item-overlay{background:rgba(0,0,0,0.5)}
.gallery-item-info{opacity:0;transform:translateY(10px);transition:all 0.3s}
.gallery-item:hover .gallery-item-info{opacity:1;transform:translateY(0)}
.gallery-item-info h4{color:#fff;font-size:15px;font-weight:700;margin-bottom:4px}
.gallery-item-info span{color:rgba(255,255,255,0.8);font-size:11px}
.gallery-save-btn{position:absolute;top:12px;right:12px;background:#e60023;color:#fff;border:none;border-radius:8px;padding:6px 12px;font-size:11px;font-weight:700;cursor:pointer;opacity:0;transition:opacity 0.2s}
.gallery-item:hover .gallery-save-btn{opacity:1}

@media(max-width:1200px){.gallery-masonry{column-count:4}}
@media(max-width:900px){.gallery-masonry{column-count:3}}
@media(max-width:620px){.gallery-masonry{column-count:2}}

/* =========================================================
   9. MULTILINGUE — International enterprise clean
   ========================================================= */
#multilingue-page{background:#f4f6f9}
.multi-hero{background:#fff;padding:80px 40px;border-bottom:2px solid #e8e2d9}
.multi-hero-inner{max-width:1200px;margin:0 auto;text-align:center}
.multi-hero-sub{font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#e8761a;margin-bottom:16px}
.multi-hero h1{font-family:'Outfit',sans-serif;font-size:clamp(40px,5vw,64px);font-weight:900;color:#1a1a1a;margin-bottom:20px}
.multi-hero p{font-size:17px;color:#666;line-height:1.8;max-width:600px;margin:0 auto 40px}
.multi-globe{display:inline-flex;align-items:center;gap:8px;font-size:14px;font-weight:600;color:#fff;background:#1a1a1a;padding:12px 24px;border-radius:999px}
.multi-hero-flags{display:flex;justify-content:center;gap:16px;margin-top:48px;flex-wrap:wrap}
.multi-flag-item{width:72px;height:72px;border-radius:50%;overflow:hidden;border:3px solid #fff;box-shadow:0 4px 16px rgba(0,0,0,0.12);transition:transform 0.2s}
.multi-flag-item:hover{transform:scale(1.1)}
.multi-flag-item img{width:100%;height:100%;object-fit:cover}

.multi-grid-section{padding:80px 40px;max-width:1300px;margin:0 auto}
.multi-grid-title{font-family:'Outfit',sans-serif;font-size:32px;font-weight:800;margin-bottom:48px;color:#1a1a1a}
.multi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:24px;margin-bottom:48px}
.multi-lang-card{background:#fff;border-radius:20px;border:2px solid #e5e7eb;padding:36px;text-align:center;position:relative;transition:all 0.3s}
.multi-lang-card:hover{border-color:#e8761a;transform:translateY(-4px);box-shadow:0 20px 40px rgba(232,118,26,0.12)}
.multi-lang-card.selected{border-color:#e8761a}
.multi-badge{position:absolute;top:-14px;left:50%;transform:translateX(-50%);font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;padding:4px 14px;border-radius:999px;white-space:nowrap}
.multi-badge.principale{background:#e8761a;color:#fff}
.multi-badge.populaire{background:#3b82f6;color:#fff}
.multi-badge.nouveau{background:#10b981;color:#fff}
.multi-badge.prochaine{background:#8b5cf6;color:#fff}
.multi-flag-circle{width:80px;height:80px;border-radius:50%;overflow:hidden;margin:16px auto 20px;border:3px solid #f0f0f0;box-shadow:0 4px 16px rgba(0,0,0,0.1)}
.multi-flag-circle img{width:100%;height:100%;object-fit:cover}
.multi-lang-name{font-size:18px;font-weight:700;color:#1a1a1a;margin-bottom:8px}
.multi-lang-desc{font-size:12px;color:#888;line-height:1.6;margin-bottom:20px}
.multi-select-btn{width:100%;padding:10px;border-radius:10px;border:1.5px solid #e5e7eb;background:#fff;font-size:13px;font-weight:700;cursor:pointer;transition:all 0.2s;display:flex;align-items:center;justify-content:center;gap:6px}
.multi-select-btn:hover{border-color:#e8761a;color:#e8761a}
.multi-select-btn.active{background:#e8761a;border-color:#e8761a;color:#fff}

.multi-seo-box{background:linear-gradient(135deg,#1e3a5f,#0f2240);border-radius:20px;padding:48px;margin-bottom:64px;display:grid;grid-template-columns:1fr auto;align-items:center;gap:40px}
.multi-seo-box h3{font-size:24px;font-weight:700;color:#fff;margin-bottom:10px;font-family:'Outfit',sans-serif}
.multi-seo-box p{font-size:14px;color:rgba(255,255,255,0.75);line-height:1.7}
.multi-seo-btn{background:#e8761a;color:#fff;padding:14px 32px;border-radius:10px;font-weight:700;font-size:14px;text-decoration:none;white-space:nowrap;display:inline-block}

/* =========================================================
   10. TIKTOK CAROUSEL — Gen-Z vibrant dark card grid
   ========================================================= */
#tiktok-page{background:#000}
.ttk-detail-hero{background:linear-gradient(180deg,#0d0d0d 0%,#1a1a1a 100%);padding:100px 40px;position:relative;overflow:hidden}
.ttk-detail-hero::after{content:'';position:absolute;top:-200px;left:50%;transform:translateX(-50%);width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(37,244,238,0.05),transparent 70%)}
.ttk-hero-inner{max-width:1200px;margin:0 auto;text-align:center}
.ttk-hero-logo{font-size:48px;margin-bottom:20px}
.ttk-hero-title{font-family:'Outfit',sans-serif;font-size:clamp(48px,6vw,80px);font-weight:900;background:linear-gradient(135deg,#25f4ee,#fe2c55,#fff);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:20px}
.ttk-hero-desc{font-size:17px;color:rgba(255,255,255,0.6);line-height:1.8;max-width:600px;margin:0 auto 40px}
.ttk-hero-stats{display:flex;justify-content:center;gap:60px}
.ttk-hero-stat strong{display:block;font-family:'Bebas Neue',sans-serif;font-size:52px;color:#25f4ee}
.ttk-hero-stat span{font-size:12px;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:0.8px}

.ttk-videos-section{padding:60px 40px;max-width:1400px;margin:0 auto}
.ttk-section-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#25f4ee;margin-bottom:12px}
.ttk-section-title{font-family:'Outfit',sans-serif;font-size:32px;font-weight:800;color:#fff;margin-bottom:36px}
.ttk-video-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:12px}
.ttk-video-card{border-radius:16px;overflow:hidden;position:relative;aspect-ratio:9/16;cursor:pointer;transition:transform 0.3s}
.ttk-video-card:hover{transform:scale(1.03);z-index:2}
.ttk-video-card img{width:100%;height:100%;object-fit:cover}
.ttk-video-card-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.9),transparent 50%);padding:16px;display:flex;flex-direction:column;justify-content:flex-end}
.ttk-video-card-views{font-size:12px;color:rgba(255,255,255,0.9);font-weight:700;display:flex;align-items:center;gap:4px;margin-bottom:6px}
.ttk-video-card-caption{font-size:11px;color:rgba(255,255,255,0.7);line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.ttk-play-overlay{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:44px;height:44px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity 0.2s}
.ttk-video-card:hover .ttk-play-overlay{opacity:1}
.ttk-play-overlay i{color:#fff;font-size:16px;margin-left:3px}

@media(max-width:1200px){.ttk-video-grid{grid-template-columns:repeat(4,1fr)}}
@media(max-width:700px){.ttk-video-grid{grid-template-columns:repeat(2,1fr)}}

/* =========================================================
   11. VIDEO PLAYER — Cinematic broadcast-quality
   ========================================================= */
#video-page{background:#0a0e1a}
.vp-detail-hero{background:#0a0e1a;padding:100px 40px 60px}
.vp-detail-inner{max-width:1300px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.vp-hero-eyebrow{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#e8761a;margin-bottom:20px;display:flex;align-items:center;gap:10px}
.vp-hero-eyebrow::before{content:'';width:40px;height:2px;background:#e8761a}
.vp-hero-title{font-family:'Playfair Display',serif;font-size:clamp(40px,4vw,60px);color:#fff;line-height:1.1;margin-bottom:20px}
.vp-hero-title em{font-style:italic;color:#e8761a}
.vp-hero-desc{font-size:16px;color:rgba(255,255,255,0.65);line-height:1.8;margin-bottom:40px}
.vp-channel-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.vp-stat{background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:24px;text-align:center}
.vp-stat strong{display:block;font-family:'Bebas Neue',sans-serif;font-size:40px;color:#e8761a;line-height:1}
.vp-stat span{font-size:11px;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:0.8px;margin-top:4px;display:block}
.vp-player-preview{border-radius:20px;overflow:hidden;border:1px solid rgba(255,255,255,0.08);aspect-ratio:16/9;background:#111;position:relative}
.vp-player-preview img{width:100%;height:100%;object-fit:cover;opacity:0.8}
.vp-player-play{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:72px;height:72px;background:rgba(232,118,26,0.9);border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.2s}
.vp-player-play:hover{background:#e8761a;transform:translate(-50%,-50%) scale(1.1)}
.vp-player-play i{color:#fff;font-size:24px;margin-left:4px}
.vp-player-bar{position:absolute;bottom:0;left:0;right:0;background:linear-gradient(to top,rgba(0,0,0,0.8),transparent);padding:20px;display:flex;flex-direction:column;gap:8px}
.vp-progress{height:4px;background:rgba(255,255,255,0.2);border-radius:999px}
.vp-progress-fill{height:100%;width:35%;background:#e8761a;border-radius:999px}
.vp-controls-row{display:flex;justify-content:space-between;align-items:center}
.vp-controls-row span{color:rgba(255,255,255,0.7);font-size:12px}
.vp-controls-icons{display:flex;gap:16px;color:rgba(255,255,255,0.8);font-size:16px}

.vp-playlist-section{background:#0f1525;padding:60px 40px}
.vp-playlist-inner{max-width:1300px;margin:0 auto}
.vp-playlist-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:32px}
.vp-playlist-title{font-family:'Playfair Display',serif;font-size:28px;color:#fff}
.vp-playlist-count{font-size:13px;color:rgba(255,255,255,0.5)}
.vp-playlist-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:16px}
.vp-playlist-card{border-radius:12px;overflow:hidden;cursor:pointer;position:relative;transition:transform 0.2s}
.vp-playlist-card:hover{transform:translateY(-4px)}
.vp-playlist-card img{width:100%;aspect-ratio:16/9;object-fit:cover}
.vp-playlist-info{padding:12px;background:#1a2340}
.vp-playlist-info h5{font-size:13px;font-weight:600;color:#fff;margin-bottom:4px;line-height:1.3}
.vp-playlist-info span{font-size:11px;color:rgba(255,255,255,0.5)}
.vp-playlist-badge{position:absolute;top:8px;left:8px;background:rgba(0,0,0,0.7);color:#fff;font-size:10px;font-weight:700;padding:3px 8px;border-radius:5px}

/* RESPONSIVE */
@media(max-width:1100px){
  .avis-hero-inner,.mail-hero-row,.chat-hero-inner,.vp-detail-inner,.bt-hero-content{max-width:100%}
  .avis-grid-featured{grid-template-columns:1fr}
  .bt-dual{grid-template-columns:1fr}
  .dest-cards-scroll{grid-template-columns:repeat(2,1fr)}
  .chat-features-grid{grid-template-columns:repeat(2,1fr)}
  .mail-campaigns-grid{grid-template-columns:1fr 1fr}
  .social-grid{grid-template-columns:repeat(3,1fr)}
  .multi-grid{grid-template-columns:repeat(2,1fr)}
  .vp-playlist-grid{grid-template-columns:repeat(3,1fr)}
  .ttk-video-grid{grid-template-columns:repeat(3,1fr)}
}
@media(max-width:768px){
  .site-nav{padding:0 20px}
  .nav-links{display:none}
  .container,.container-wide{padding:0 20px}
  .avis-stats-bar-inner,.bt-stats-row,.chat-metrics-section{grid-template-columns:repeat(2,1fr)}
  .avis-hero-inner{grid-template-columns:1fr}
  .avis-platform-row{grid-template-columns:1fr}
  .dest-cinematic-content{flex-direction:column;padding:40px 24px}
  .dest-cinematic-right{min-width:auto;width:100%}
  .dest-cards-scroll{grid-template-columns:1fr}
  .blog-hero-grid{grid-template-columns:1fr}
  .blog-articles-row{grid-template-columns:1fr}
  .chat-features-grid{grid-template-columns:1fr}
  .mail-campaigns-grid{grid-template-columns:1fr}
  .social-grid{grid-template-columns:repeat(2,1fr)}
  .social-services-grid{grid-template-columns:1fr}
  .multi-grid{grid-template-columns:1fr 1fr}
  .vp-detail-inner{grid-template-columns:1fr}
  .vp-playlist-grid{grid-template-columns:repeat(2,1fr)}
  .ttk-video-grid{grid-template-columns:repeat(2,1fr)}
  .ttk-hero-stats{gap:30px}
  .bt-dual{padding:40px 20px}
}
</style>
</head>
<body>

<!-- NAV -->
<nav class="site-nav">
  <div class="nav-inner">
    <div class="nav-logo">
      <div class="nav-logo-mark">GO</div>
      <div class="nav-logo-text">GoExploria Business</div>
    </div>
    <ul class="nav-links">
      <li><a href="#avis-clients-page">Avis Clients</a></li>
      <li><a href="#business-tourism-page">Business</a></li>
      <li><a href="#destinations-page">Destinations</a></li>
      <li><a href="#blog-page">Blog</a></li>
      <li><a href="#chat-page">Chat</a></li>
      <li><a href="#mail-page">Mail</a></li>
      <li><a href="#social-page">Social</a></li>
      <li><a href="#gallerie-page">Galerie</a></li>
      <li><a href="#multilingue-page">Multilingue</a></li>
      <li><a href="#tiktok-page">TikTok</a></li>
      <li><a href="#video-page">Vidéos</a></li>
    </ul>
  </div>
</nav>

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="page-hero-tag"><i class="fas fa-globe"></i> GoExploria Business Platform</div>
  <h1>Pages Détail<br><em style="font-style:italic;color:#e8761a">Composants</em></h1>
  <p>Onze sections premium, onze univers graphiques distincts. Chaque composant raconté dans sa propre identité visuelle.</p>
</div>

<!-- =====================================================
     1. AVIS CLIENTS
     ===================================================== -->
<section id="avis-clients-page" class="section-page" style="background:#faf7f2;padding:0">
  <!-- Hero Strip -->
  <div class="avis-hero-strip">
    <div class="avis-hero-inner">
      <div>
        <div class="avis-hero-label"><i class="fas fa-comment-dots"></i> Espace Avis Clients</div>
        <h2 class="avis-hero-title">La confiance<br>en chiffres<br><em style="font-style:italic;color:#e8761a">réels</em></h2>
        <p class="avis-hero-desc">Plus de 4 800 témoignages authentiques de voyageurs, familles et entreprises partenaires du monde entier. Notre plateforme de confiance repose sur la transparence totale.</p>
        <div class="avis-score-big">
          <span class="avis-score-num">4.9</span>
          <div class="avis-score-stars">
            <span>★★★★★</span>
            <small>Note globale sur 5.0</small>
            <small>4 823 avis vérifiés</small>
          </div>
        </div>
      </div>
      <div class="avis-hero-img">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=700&h=500&fit=crop" alt="Équipe GoExploria">
      </div>
    </div>
  </div>

  <!-- Stats bar -->
  <div class="avis-stats-bar">
    <div class="avis-stats-bar-inner">
      <div class="avis-stat-item"><strong>4 823</strong><span>Avis vérifiés</span></div>
      <div class="avis-stat-item"><strong>98%</strong><span>Recommandations</span></div>
      <div class="avis-stat-item"><strong>12</strong><span>Pays représentés</span></div>
      <div class="avis-stat-item"><strong>6 ans</strong><span>Présence active</span></div>
    </div>
  </div>

  <!-- Main avis -->
  <div class="avis-main">
    <div class="avis-main-inner">
      <h2 class="avis-section-title">Témoignages de voyageurs</h2>
      <div class="avis-grid-featured">
        <!-- Featured -->
        <div class="avis-card-featured">
          <div class="stars">★★★★★</div>
          <p class="quote">"Une expérience qui a transformé notre façon de voyager. GoExploria nous a proposé un séjour sur-mesure en Charlevoix que nous n'aurions jamais trouvé seuls. L'équipe est réactive, attentionnée, et les suggestions sont toujours justes. On revient chaque année !"</p>
          <div class="author">
            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=120&h=120&fit=crop" alt="Julie Tremblay">
            <div>
              <div class="author-name">Julie Tremblay</div>
              <div class="author-role">Voyageuse — Québec, Canada</div>
            </div>
          </div>
        </div>
        <!-- Card 2 -->
        <div class="avis-card-secondary">
          <div class="stars" style="color:#f59e0b;font-size:16px;margin-bottom:14px">★★★★★</div>
          <p style="font-size:14px;line-height:1.7;color:#333;margin-bottom:20px;">"La visibilité de notre entreprise a triplé en 6 mois. L'équipe GoExploria comprend les enjeux business et adapte sa stratégie en temps réel. Un partenaire inestimable."</p>
          <div class="author" style="display:flex;align-items:center;gap:10px">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120&h=120&fit=crop" alt="Marc Bouchard" style="width:44px;height:44px;border-radius:50%;object-fit:cover">
            <div>
              <div style="font-weight:700;font-size:13px;color:#1a1a1a">Marc Bouchard</div>
              <div style="font-size:11px;color:#888">Entrepreneur — Montréal</div>
            </div>
          </div>
        </div>
        <!-- Card 3 -->
        <div class="avis-card-secondary">
          <div class="stars" style="color:#f59e0b;font-size:16px;margin-bottom:14px">★★★★☆</div>
          <p style="font-size:14px;line-height:1.7;color:#333;margin-bottom:20px;">"Interface magnifique, contenu riche et inspirant. La section photos m'a aidée à choisir ma destination de vacances en quelques minutes. Je recommande vivement cette plateforme."</p>
          <div class="author" style="display:flex;align-items:center;gap:10px">
            <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?w=120&h=120&fit=crop" alt="Sophie Gagnon" style="width:44px;height:44px;border-radius:50%;object-fit:cover">
            <div>
              <div style="font-weight:700;font-size:13px;color:#1a1a1a">Sophie Gagnon</div>
              <div style="font-size:11px;color:#888">Créatrice — Saguenay</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Google reviews -->
      <h2 class="avis-section-title" style="margin-top:60px">Avis Google Workspace</h2>
      <div class="avis-platform-row">
        <div class="avis-platform-card">
          <div class="avis-platform-badge"><span class="g-badge" style="font-size:22px;font-weight:900;background:linear-gradient(135deg,#4285f4,#ea4335,#fbbc05,#34a853);-webkit-background-clip:text;-webkit-text-fill-color:transparent">G</span> <span style="font-size:12px;color:#888">Google Workspace</span></div>
          <div class="avis-platform-score">4.9 <span>/ 5</span></div>
          <div style="color:#f59e0b;font-size:16px;letter-spacing:2px;margin-bottom:10px">★★★★★</div>
          <p style="font-size:14px;color:#444;line-height:1.7">"Excellent suivi client, collaboration fluide et organisation des projets très efficace. Notre équipe utilise GoExploria quotidiennement pour coordonner nos activités touristiques."</p>
          <div style="display:flex;justify-content:space-between;margin-top:14px;font-size:12px;color:#999">
            <span>Goexploria Business — Montréal</span><span>Il y a 2 jours</span>
          </div>
        </div>
        <div class="avis-platform-card">
          <div class="avis-platform-badge"><span class="g-badge" style="font-size:22px;font-weight:900;background:linear-gradient(135deg,#4285f4,#ea4335,#fbbc05,#34a853);-webkit-background-clip:text;-webkit-text-fill-color:transparent">G</span> <span style="font-size:12px;color:#888">Google Workspace</span></div>
          <div class="avis-platform-score">5.0 <span>/ 5</span></div>
          <div style="color:#f59e0b;font-size:16px;letter-spacing:2px;margin-bottom:10px">★★★★★</div>
          <p style="font-size:14px;color:#444;line-height:1.7">"Le tableau de suivi partagé et les retours en temps réel nous ont transformé la gestion de nos campagnes. Outil indispensable pour notre agence de voyages d'affaires."</p>
          <div style="display:flex;justify-content:space-between;margin-top:14px;font-size:12px;color:#999">
            <span>Atelier Nomade — Québec</span><span>Il y a 1 semaine</span>
          </div>
        </div>
        <div class="avis-platform-card">
          <div class="avis-platform-badge"><span class="g-badge" style="font-size:22px;font-weight:900;background:linear-gradient(135deg,#4285f4,#ea4335,#fbbc05,#34a853);-webkit-background-clip:text;-webkit-text-fill-color:transparent">G</span> <span style="font-size:12px;color:#888">Google Workspace</span></div>
          <div class="avis-platform-score">4.8 <span>/ 5</span></div>
          <div style="color:#f59e0b;font-size:16px;letter-spacing:2px;margin-bottom:10px">★★★★☆</div>
          <p style="font-size:14px;color:#444;line-height:1.7">"Communication claire, livraison rapide, et une vraie valeur ajoutée sur notre visibilité digitale. Studio Horizon a augmenté son chiffre d'affaires de 32% en un an."</p>
          <div style="display:flex;justify-content:space-between;margin-top:14px;font-size:12px;color:#999">
            <span>Studio Horizon — Lyon</span><span>Il y a 3 semaines</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- =====================================================
     2. BUSINESS & TOURISM
     ===================================================== -->
<section id="business-tourism-page" class="section-page" style="padding:0;background:#fff">
  <div class="bt-hero">
    <div class="bt-hero-bg"></div>
    <div class="bt-hero-geometric"></div>
    <div class="bt-hero-content">
      <div class="bt-hero-eyebrow">Solutions Business & Tourisme</div>
      <h1 class="bt-hero-title">NEXT<br><em>LEVEL</em><br>BUSINESS</h1>
      <p class="bt-hero-desc">Stratégies sur mesure pour propulser votre entreprise sur les marchés internationaux. Nous combinons expertise commerciale et expériences touristiques exclusives pour les professionnels les plus exigeants.</p>
      <div class="bt-cta-group">
        <a href="#" class="btn-primary-orange"><i class="fas fa-rocket"></i> Découvrir nos solutions</a>
        <a href="#" class="btn-outline-white"><i class="fas fa-play"></i> Voir la démo</a>
      </div>
    </div>
  </div>

  <!-- Dual cards -->
  <div class="bt-dual">
    <div class="bt-card-detail">
      <div class="bt-card-detail-header">
        <div class="bt-card-icon orange"><i class="fas fa-briefcase"></i></div>
        <div>
          <div class="bt-card-detail-title">Solutions Web Business</div>
          <div class="bt-card-detail-sub">Expertise commerciale internationale</div>
        </div>
      </div>
      <div class="bt-card-detail-body">
        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=700&h=400&fit=crop" alt="Business" class="bt-card-img">
        <p style="font-size:14px;color:#555;line-height:1.8;margin-bottom:24px">Nous accompagnons les entreprises dans leur développement international avec des stratégies éprouvées, des outils digitaux innovants et un réseau de partenaires dans 40 pays.</p>
        <ul class="bt-feature-list">
          <li><i class="fas fa-check-circle"></i> Consultation stratégique et analyse de marché approfondie</li>
          <li><i class="fas fa-check-circle"></i> Développement de partenariats internationaux qualifiés</li>
          <li><i class="fas fa-check-circle"></i> Optimisation des processus opérationnels et workflows</li>
          <li><i class="fas fa-check-circle"></i> Solutions digitales innovantes (CRM, automatisation, IA)</li>
          <li><i class="fas fa-check-circle"></i> Formation et coaching des équipes commerciales</li>
          <li><i class="fas fa-check-circle"></i> Tableaux de bord et reporting en temps réel</li>
        </ul>
        <a href="#" class="btn-primary-orange" style="display:inline-flex">Découvrir <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
    <div class="bt-card-detail">
      <div class="bt-card-detail-header">
        <div class="bt-card-icon blue"><i class="fas fa-plane"></i></div>
        <div>
          <div class="bt-card-detail-title">Solutions Web Tourisme</div>
          <div class="bt-card-detail-sub">Expériences exclusives pour professionnels</div>
        </div>
      </div>
      <div class="bt-card-detail-body">
        <img src="https://images.unsplash.com/photo-1503220317375-aaad61436b1b?w=700&h=400&fit=crop" alt="Tourisme" class="bt-card-img">
        <p style="font-size:14px;color:#555;line-height:1.8;margin-bottom:24px">Voyages d'affaires sur mesure, retraites d'entreprise en destinations exclusives et circuits découverte pour renforcer la cohésion de vos équipes et fidéliser vos partenaires.</p>
        <ul class="bt-feature-list">
          <li><i class="fas fa-check-circle"></i> Voyages d'affaires clé-en-main personnalisés</li>
          <li><i class="fas fa-check-circle"></i> Retraites d'entreprise en destinations exclusives mondiales</li>
          <li><i class="fas fa-check-circle"></i> Team-building aventure, culturel et gastronomique</li>
          <li><i class="fas fa-check-circle"></i> Circuits découverte pour partenaires et clients VIP</li>
          <li><i class="fas fa-check-circle"></i> Coordination logistique complète et assistance 24h/7j</li>
          <li><i class="fas fa-check-circle"></i> Expériences locales authentiques hors des sentiers battus</li>
        </ul>
        <a href="#" style="background:#2563eb;color:#fff;padding:14px 28px;border-radius:8px;font-weight:700;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;gap:8px">Explorer <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
  </div>

  <!-- Stats -->
  <div class="bt-stats-row" style="margin:0 40px 80px;border-radius:20px;overflow:hidden">
    <div class="bt-stat-box"><strong>250+</strong><span>Projets réalisés</span></div>
    <div class="bt-stat-box"><strong>40</strong><span>Pays couverts</span></div>
    <div class="bt-stat-box"><strong>98%</strong><span>Satisfaction client</span></div>
    <div class="bt-stat-box"><strong>15+</strong><span>Années d'expérience</span></div>
  </div>
</section>

<!-- =====================================================
     3. DESTINATIONS VEDETTES
     ===================================================== -->
<section id="destinations-page" class="section-page" style="padding:0;background:#f9f7f4">
  <!-- Cinematic hero -->
  <div class="dest-cinematic">
    <div class="dest-cinematic-bg">
      <img src="https://images.unsplash.com/photo-1519112232436-9923c6ba3d26?w=1800&h=1000&fit=crop" alt="Québec">
    </div>
    <div class="dest-cinematic-overlay"></div>
    <div class="dest-cinematic-content">
      <div class="dest-cinematic-left">
        <div class="dest-breadcrumb">Amérique du Nord <span>/</span> Canada <span>/</span> Québec</div>
        <h1 class="dest-cinematic-title">Destinations<br><em style="font-style:italic;color:#e8761a">Vedettes</em></h1>
        <p class="dest-cinematic-desc">Découvrez les joyaux incontournables du Québec, du Canada et de l'Amérique du Nord sublimés par l'expertise GoExploria. Des expériences uniques, des paysages époustouflants, des cultures riches.</p>
        <div class="dest-tag-cloud">
          <span class="dest-tag">Patrimoine UNESCO</span>
          <span class="dest-tag">Nature sauvage</span>
          <span class="dest-tag">Gastronomie locale</span>
          <span class="dest-tag">Aventure plein air</span>
          <span class="dest-tag">Culture vivante</span>
        </div>
      </div>
      <div class="dest-cinematic-right">
        <div class="dest-weather-card">
          <div style="font-size:12px;color:rgba(255,255,255,0.6);margin-bottom:8px">Québec · Maintenant</div>
          <div class="dest-weather-temp">-8°</div>
          <div class="dest-weather-label">❄️ Hiver magnifique</div>
          <div class="dest-weather-row">
            <div><span>Lun</span><strong>-6°</strong></div>
            <div><span>Mar</span><strong>-3°</strong></div>
            <div><span>Mer</span><strong>1°</strong></div>
            <div><span>Jeu</span><strong>-5°</strong></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Destination cards -->
  <div class="dest-cards-section">
    <div class="dest-filters-row">
      <button class="dest-filter-btn active"><i class="fas fa-th-large"></i> Toutes</button>
      <button class="dest-filter-btn"><i class="fas fa-landmark"></i> Patrimoine</button>
      <button class="dest-filter-btn"><i class="fas fa-city"></i> Urbain</button>
      <button class="dest-filter-btn"><i class="fas fa-mountain"></i> Nature</button>
      <button class="dest-filter-btn"><i class="fas fa-person-skiing"></i> Plein air</button>
    </div>
    <h2 class="dest-cards-section-title" style="font-family:'Playfair Display',serif">7 destinations à découvrir</h2>
    <div class="dest-cards-scroll">
      <div class="dest-dest-card">
        <img src="https://images.unsplash.com/photo-1519112232436-9923c6ba3d26?w=400&h=600&fit=crop" alt="Vieux-Québec">
        <div class="dest-dest-card-overlay">
          <h3>Vieux-Québec</h3>
          <p><i class="fas fa-map-marker-alt"></i> Québec, Canada</p>
          <div class="dest-rating">★★★★★ Patrimoine UNESCO</div>
        </div>
        <span class="dest-badge-pill">HOT</span>
      </div>
      <div class="dest-dest-card">
        <img src="https://images.unsplash.com/photo-1517935706615-2717063c2225?w=400&h=600&fit=crop" alt="Montréal">
        <div class="dest-dest-card-overlay">
          <h3>Montréal</h3>
          <p><i class="fas fa-map-marker-alt"></i> Québec, Canada</p>
          <div class="dest-rating">★★★★★ Cosmopolite</div>
        </div>
        <span class="dest-badge-pill">TOP</span>
      </div>
      <div class="dest-dest-card">
        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=600&fit=crop" alt="Charlevoix">
        <div class="dest-dest-card-overlay">
          <h3>Charlevoix</h3>
          <p><i class="fas fa-map-marker-alt"></i> Québec, Canada</p>
          <div class="dest-rating">★★★★★ Nature & Art</div>
        </div>
      </div>
      <div class="dest-dest-card">
        <img src="https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=400&h=600&fit=crop" alt="Gaspésie">
        <div class="dest-dest-card-overlay">
          <h3>Gaspésie</h3>
          <p><i class="fas fa-map-marker-alt"></i> Québec, Canada</p>
          <div class="dest-rating">★★★★☆ Sauvage & Côtier</div>
        </div>
        <span class="dest-badge-pill">NEW</span>
      </div>
    </div>
    <!-- Row 2 -->
    <div class="dest-cards-scroll" style="margin-top:20px;grid-template-columns:repeat(3,1fr)">
      <div class="dest-dest-card" style="aspect-ratio:4/3">
        <img src="https://images.unsplash.com/photo-1551582045-6ec9c11d8697?w=600&h=400&fit=crop" alt="Laurentides">
        <div class="dest-dest-card-overlay">
          <h3>Laurentides</h3>
          <p><i class="fas fa-map-marker-alt"></i> Québec, Canada</p>
          <div class="dest-rating">★★★★★ Ski & Randonnée</div>
        </div>
      </div>
      <div class="dest-dest-card" style="aspect-ratio:4/3">
        <img src="https://images.unsplash.com/photo-1605540436563-5bca919ae766?w=600&h=400&fit=crop" alt="Mont-Tremblant">
        <div class="dest-dest-card-overlay">
          <h3>Mont-Tremblant</h3>
          <p><i class="fas fa-map-marker-alt"></i> Laurentides, Canada</p>
          <div class="dest-rating">★★★★★ Ski mondial</div>
        </div>
        <span class="dest-badge-pill">TRENDING</span>
      </div>
      <div class="dest-dest-card" style="aspect-ratio:4/3">
        <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=600&h=400&fit=crop" alt="Îles Madeleine">
        <div class="dest-dest-card-overlay">
          <h3>Îles de la Madeleine</h3>
          <p><i class="fas fa-map-marker-alt"></i> Québec, Canada</p>
          <div class="dest-rating">★★★★★ Archipel unique</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- =====================================================
     4. ESPACE BLOG EDITORIAL
     ===================================================== -->
<section id="blog-page" class="section-page" style="padding:0;background:#fff">
  <div class="blog-masthead">
    <div class="blog-masthead-inner">
      <div class="blog-masthead-header">
        <div>
          <div class="blog-masthead-meta">GoExploria · Espace Blog Éditorial</div>
          <h1 class="blog-masthead-title">Le<br><em>Magazine</em><br>du Voyage</h1>
        </div>
        <div class="blog-date-box">
          <div class="blog-date-num">07</div>
          <div class="blog-date-label">Mai 2026</div>
        </div>
      </div>
    </div>
    <!-- Hero images -->
    <div class="blog-hero-grid">
      <div class="blog-hero-feature">
        <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?w=1200&h=700&fit=crop" alt="Feature story">
        <div class="blog-hero-feature-overlay">
          <span class="blog-category-tag">Business</span>
          <h2>Les PME canadiennes tablent sur une croissance record en 2026</h2>
          <p>Analyse des tendances, marketing d'influence et accélération digitale pour les entrepreneurs du Québec</p>
          <div style="display:flex;align-items:center;gap:12px;margin-top:16px;font-size:12px;color:rgba(255,255,255,0.7)">
            <span><i class="fas fa-user"></i> Stiven Jackson</span>
            <span><i class="fas fa-calendar"></i> 16 Mars 2026</span>
            <span><i class="fas fa-clock"></i> 8 min de lecture</span>
          </div>
        </div>
      </div>
      <div class="blog-hero-side">
        <div class="blog-mini-card">
          <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=400&fit=crop" alt="Marketing">
          <div class="blog-mini-card-content">
            <span class="blog-category-tag" style="font-size:9px;padding:3px 8px">Marketing</span>
            <h4>Les CMO B2B augmentent drastiquement leurs dépenses médias</h4>
            <span style="font-size:11px;color:rgba(255,255,255,0.6)">16 Mars 2026</span>
          </div>
        </div>
        <div class="blog-mini-card">
          <img src="https://images.unsplash.com/photo-1527631746610-bca00a040d60?w=600&h=400&fit=crop" alt="Travel">
          <div class="blog-mini-card-content">
            <span class="blog-category-tag" style="background:#2563eb;font-size:9px;padding:3px 8px">Travel</span>
            <h4>La demande de workation explose pour les équipes nomades</h4>
            <span style="font-size:11px;color:rgba(255,255,255,0.6)">14 Mars 2026</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Articles grid -->
  <div class="blog-articles-grid">
    <div class="blog-articles-row">
      <div class="blog-article-card">
        <div class="blog-article-img">
          <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=640&h=360&fit=crop" alt="Travel">
        </div>
        <div class="blog-article-meta">
          <span class="cat">Travel</span>
          <span style="color:#e5e7eb">·</span>
          <span class="date">14 Mars 2026</span>
        </div>
        <h3>Tendances voyages à distance et escapades travail-vie</h3>
        <p>Les professionnels recherchent des destinations offrant haut débit, espaces de coworking et expériences locales authentiques pour mêler productivité et découverte.</p>
        <a href="#" class="read-more">Lire l'article <i class="fas fa-arrow-right"></i></a>
      </div>
      <div class="blog-article-card">
        <div class="blog-article-img">
          <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=640&h=360&fit=crop" alt="Tech">
        </div>
        <div class="blog-article-meta">
          <span class="cat">Tech</span>
          <span style="color:#e5e7eb">·</span>
          <span class="date">13 Mars 2026</span>
        </div>
        <h3>L'IA copilote transforme les salles de rédaction et la vitesse d'édition</h3>
        <p>Comment les outils d'intelligence artificielle révolutionnent la production de contenu dans les médias, permettant aux équipes de publier cinq fois plus vite.</p>
        <a href="#" class="read-more">Lire l'article <i class="fas fa-arrow-right"></i></a>
      </div>
      <div class="blog-article-card">
        <div class="blog-article-img">
          <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=640&h=360&fit=crop" alt="Business">
        </div>
        <div class="blog-article-meta">
          <span class="cat">Business</span>
          <span style="color:#e5e7eb">·</span>
          <span class="date">12 Mars 2026</span>
        </div>
        <h3>Les nouvelles brasseries artisanales attirent une génération d'entrepreneurs</h3>
        <p>Phénomène mondial, la bière artisanale devient un vecteur d'entrepreneuriat local, de tourisme et de développement économique dans les régions rurales.</p>
        <a href="#" class="read-more">Lire l'article <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
    <!-- Row 2 -->
    <div class="blog-articles-row" style="margin-top:32px">
      <div class="blog-article-card">
        <div class="blog-article-img">
          <img src="https://images.unsplash.com/photo-1539635278303-d4002c07eae3?w=640&h=360&fit=crop" alt="Adventure">
        </div>
        <div class="blog-article-meta">
          <span class="cat" style="color:#10b981">Aventure</span>
          <span style="color:#e5e7eb">·</span>
          <span class="date">11 Mars 2026</span>
        </div>
        <h3>Randonnée hivernale en Gaspésie : le guide ultime 2026</h3>
        <p>Préparez votre aventure dans l'une des plus belles péninsules sauvages d'Amérique du Nord avec nos conseils d'experts locaux et itinéraires exclusifs.</p>
        <a href="#" class="read-more">Lire l'article <i class="fas fa-arrow-right"></i></a>
      </div>
      <div class="blog-article-card">
        <div class="blog-article-img">
          <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=640&h=360&fit=crop" alt="Gastronomie">
        </div>
        <div class="blog-article-meta">
          <span class="cat" style="color:#f59e0b">Gastronomie</span>
          <span style="color:#e5e7eb">·</span>
          <span class="date">10 Mars 2026</span>
        </div>
        <h3>Top 10 des restaurants gastronomiques à Montréal cette saison</h3>
        <p>Notre sélection des adresses incontournables de la scène culinaire montréalaise, des table d'exception aux bistros tendance qui font vibrer la ville.</p>
        <a href="#" class="read-more">Lire l'article <i class="fas fa-arrow-right"></i></a>
      </div>
      <div class="blog-article-card">
        <div class="blog-article-img">
          <img src="https://images.unsplash.com/photo-1475503572774-15a45e5d60b9?w=640&h=360&fit=crop" alt="Culture">
        </div>
        <div class="blog-article-meta">
          <span class="cat" style="color:#8b5cf6">Culture</span>
          <span style="color:#e5e7eb">·</span>
          <span class="date">8 Mars 2026</span>
        </div>
        <h3>Le printemps cultural québécois : festivals et événements à ne pas manquer</h3>
        <p>De Québec à Montréal, la saison culturelle 2026 promet une programmation exceptionnelle : musique, arts visuels, théâtre et célébrations locales authentiques.</p>
        <a href="#" class="read-more">Lire l'article <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- =====================================================
     5. ESPACE CHAT
     ===================================================== -->
<section id="chat-page" class="section-page" style="padding:0;background:#f8faff">
  <div class="chat-hero">
    <div class="chat-hero-circles">
      <div class="c1"></div>
      <div class="c2"></div>
    </div>
    <div class="chat-hero-inner">
      <div>
        <div class="chat-hero-label">⬤ Système actif — 326 conversations en cours</div>
        <h1 class="chat-hero-title">Votre inbox<br>client unifiée<br>et intelligente</h1>
        <p class="chat-hero-desc">Centralisez toutes vos conversations — WhatsApp, Messenger, Instagram, site web — dans une interface unique ultra-rapide. Ne perdez plus jamais un lead.</p>
        <div class="chat-kpi-mini">
          <div class="chat-kpi-mini-item"><strong>1m 48s</strong><span>Réponse moy.</span></div>
          <div class="chat-kpi-mini-item"><strong>96%</strong><span>Satisfaction</span></div>
          <div class="chat-kpi-mini-item"><strong>4 canaux</strong><span>Unifiés</span></div>
        </div>
      </div>
      <!-- Chat mockup -->
      <div class="chat-mockup">
        <div class="chat-mockup-topbar">
          <div class="chat-mockup-dots"><span class="d1"></span><span class="d2"></span><span class="d3"></span></div>
          <div style="margin-left:12px;font-size:12px;color:rgba(255,255,255,0.5)">GoExploria Chat — Inbox</div>
        </div>
        <div class="chat-mockup-body">
          <div class="chat-bubble">
            <div class="chat-bubble-avatar"><img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&h=80&fit=crop" alt="user"></div>
            <div class="chat-bubble-msg">Bonjour ! Je cherche un hébergement à Charlevoix pour 4 personnes fin juin 🙏</div>
          </div>
          <div class="chat-bubble right">
            <div class="chat-bubble-avatar"><img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=80&h=80&fit=crop" alt="agent"></div>
            <div class="chat-bubble-msg">Bonjour Julie ! Nous avons plusieurs magnifiques chalets disponibles. Voici 3 options adaptées à votre famille 🏡</div>
          </div>
          <div class="chat-bubble">
            <div class="chat-bubble-avatar"><img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&h=80&fit=crop" alt="user"></div>
            <div class="chat-bubble-msg">Super ! C'est quoi les tarifs pour l'option 2 ?</div>
          </div>
          <div class="chat-bubble right">
            <div class="chat-bubble-avatar"><img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=80&h=80&fit=crop" alt="agent"></div>
            <div class="chat-bubble-msg">Le Chalet Les Pins : 280$/nuit · Vue sur le fleuve · Disponible du 20 au 28 juin ✨</div>
          </div>
        </div>
        <div class="chat-platform-row">
          <span class="chat-platform-tag"><i class="fab fa-whatsapp"></i> WhatsApp</span>
          <span class="chat-platform-tag"><i class="fab fa-instagram"></i> Instagram</span>
          <span class="chat-platform-tag"><i class="fab fa-facebook-messenger"></i> Messenger</span>
          <span class="chat-platform-tag"><i class="fas fa-globe"></i> Site Web</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Metrics -->
  <div class="chat-metrics-section" style="margin:60px 40px;max-width:1200px;margin-left:auto;margin-right:auto;border-radius:24px;padding:50px">
    <div class="chat-metric-box"><strong>1m 48s</strong><span>Temps moyen de réponse</span></div>
    <div class="chat-metric-box"><strong>326</strong><span>Conversations aujourd'hui</span></div>
    <div class="chat-metric-box"><strong>96%</strong><span>Taux de satisfaction client</span></div>
  </div>

  <!-- Features -->
  <div class="chat-features">
    <h2 class="chat-features-title">Tout ce dont votre équipe a besoin</h2>
    <div class="chat-features-grid">
      <div class="chat-feature-card">
        <div class="chat-feature-icon"><i class="fas fa-inbox"></i></div>
        <h4>Inbox omnicanale unifiée</h4>
        <p>WhatsApp, Instagram, Messenger, site web — toutes vos conversations dans un seul espace organisé et collaboratif pour votre équipe entière.</p>
      </div>
      <div class="chat-feature-card">
        <div class="chat-feature-icon"><i class="fas fa-bolt"></i></div>
        <h4>Réponses IA assistée</h4>
        <p>Notre IA suggère des réponses contextuelles en temps réel, réduisant le temps de traitement de 60% tout en maintenant une touche personnelle.</p>
      </div>
      <div class="chat-feature-card">
        <div class="chat-feature-icon"><i class="fas fa-user-shield"></i></div>
        <h4>Priorisation VIP & SLA</h4>
        <p>Identifiez automatiquement vos clients VIP, gérez les SLA et assurez-vous que les messages urgents sont traités en priorité absolue.</p>
      </div>
      <div class="chat-feature-card">
        <div class="chat-feature-icon"><i class="fas fa-chart-line"></i></div>
        <h4>Analytics & conversion</h4>
        <p>Tableaux de bord en temps réel, suivi des KPIs conversation, taux de conversion et rapports de satisfaction exportables en PDF.</p>
      </div>
    </div>
  </div>
</section>

<!-- =====================================================
     6. MAIL MARKETING
     ===================================================== -->
<section id="mail-page" class="section-page" style="padding:0;background:#fffdf9">
  <div class="mail-hero">
    <div class="mail-hero-inner">
      <div class="mail-hero-tag"><i class="fas fa-paper-plane"></i> Mail Marketing Studio</div>
      <div class="mail-hero-row">
        <div>
          <h1 class="mail-hero-h">MAIL<br>MARKETING<br>PRO</h1>
          <p class="mail-hero-sub">Concevez des campagnes qui convertissent vraiment : segmentation intelligente, design responsive, automation avancée et analytics en temps réel pour maximiser votre ROI.</p>
          <div style="display:flex;gap:12px;flex-wrap:wrap">
            <a href="#" class="btn-primary-orange"><i class="fas fa-rocket"></i> Créer une campagne</a>
            <a href="#" style="border:2px solid #1a1a1a;color:#1a1a1a;padding:14px 28px;border-radius:8px;font-weight:700;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;gap:8px"><i class="fas fa-chart-bar"></i> Voir les analytics</a>
          </div>
        </div>
        <div class="mail-metrics-panel">
          <h3 style="color:#fff;font-size:16px;margin-bottom:24px;font-weight:700">Performance en temps réel</h3>
          <div class="mail-metric-row">
            <span class="mail-metric-label">Taux d'ouverture</span>
            <div class="mail-metric-bar-wrap"><div class="mail-metric-bar" style="width:42.7%"></div></div>
            <span class="mail-metric-value">42.7%</span>
          </div>
          <div class="mail-metric-row">
            <span class="mail-metric-label">Taux de clic</span>
            <div class="mail-metric-bar-wrap"><div class="mail-metric-bar" style="width:12.4%"></div></div>
            <span class="mail-metric-value">12.4%</span>
          </div>
          <div class="mail-metric-row">
            <span class="mail-metric-label">Conversion</span>
            <div class="mail-metric-bar-wrap"><div class="mail-metric-bar" style="width:6.9%"></div></div>
            <span class="mail-metric-value">6.9%</span>
          </div>
          <div class="mail-metric-row">
            <span class="mail-metric-label">Délivrabilité</span>
            <div class="mail-metric-bar-wrap"><div class="mail-metric-bar" style="width:98.2%"></div></div>
            <span class="mail-metric-value">98.2%</span>
          </div>
          <div class="mail-metric-row">
            <span class="mail-metric-label">Désabonnements</span>
            <div class="mail-metric-bar-wrap"><div class="mail-metric-bar" style="width:0.4%;background:#ef4444"></div></div>
            <span class="mail-metric-value" style="color:#ef4444">0.4%</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Campaign types -->
  <div class="mail-campaigns">
    <h2 class="mail-campaigns-title">Nos 3 types de campagnes</h2>
    <div class="mail-campaigns-grid">
      <div class="mail-campaign">
        <div class="mail-campaign-img">
          <img src="https://images.unsplash.com/photo-1607082349566-187342175e2f?w=600&h=400&fit=crop" alt="E-commerce">
        </div>
        <div class="mail-campaign-body">
          <div class="mail-campaign-type"><i class="fas fa-cart-shopping"></i> E-commerce</div>
          <h3>Email Marketing E-commerce</h3>
          <p>Relance panier abandonné, recommandations produit personnalisées et séquence post-achat pour augmenter drastiquement la valeur vie client et maximiser le revenu par visiteur.</p>
          <ul class="mail-features-ul">
            <li><i class="fas fa-check-circle"></i> Workflow de relance en 3 emails automatisés</li>
            <li><i class="fas fa-check-circle"></i> Offres code promo dynamique et personnalisé</li>
            <li><i class="fas fa-check-circle"></i> Recommandations IA basées sur l'historique</li>
            <li><i class="fas fa-check-circle"></i> Tests A/B multivarié sur objet et contenu</li>
          </ul>
          <div class="mail-kpi-highlight">
            <span class="mail-kpi-chip">+18.6% Conversion</span>
            <span class="mail-kpi-chip">+31% Panier moyen</span>
          </div>
        </div>
      </div>
      <div class="mail-campaign">
        <div class="mail-campaign-img">
          <img src="https://images.unsplash.com/photo-1552581234-26160f608093?w=600&h=400&fit=crop" alt="Business B2B">
        </div>
        <div class="mail-campaign-body">
          <div class="mail-campaign-type"><i class="fas fa-briefcase"></i> Business B2B</div>
          <h3>Email Marketing Business</h3>
          <p>Nurturing B2B pour qualifier vos leads : séquences webinar, études de cas impactantes et prise de rendez-vous commerciale pour accélérer votre cycle de vente.</p>
          <ul class="mail-features-ul">
            <li><i class="fas fa-check-circle"></i> Score leads automatique et priorisation intelligente</li>
            <li><i class="fas fa-check-circle"></i> CTA prise de rendez-vous intégré au CRM</li>
            <li><i class="fas fa-check-circle"></i> Séquences d'onboarding et nurturing avancé</li>
            <li><i class="fas fa-check-circle"></i> Reporting ROI détaillé par segment</li>
          </ul>
          <div class="mail-kpi-highlight">
            <span class="mail-kpi-chip">+27% SQL générées</span>
            <span class="mail-kpi-chip">-40% Cycle vente</span>
          </div>
        </div>
      </div>
      <div class="mail-campaign">
        <div class="mail-campaign-img">
          <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=600&h=400&fit=crop" alt="Tourisme">
        </div>
        <div class="mail-campaign-body">
          <div class="mail-campaign-type"><i class="fas fa-plane-departure"></i> Tourisme</div>
          <h3>Email Marketing Tourisme</h3>
          <p>Campagnes inspiration destination, alertes forfaits last minute et guides saisonniers pour stimuler les réservations et fidéliser votre communauté de voyageurs.</p>
          <ul class="mail-features-ul">
            <li><i class="fas fa-check-circle"></i> Segmentation par destination et type de voyage</li>
            <li><i class="fas fa-check-circle"></i> Alertes "dernières places" en temps réel</li>
            <li><i class="fas fa-check-circle"></i> Contenus inspirants avec photos premium</li>
            <li><i class="fas fa-check-circle"></i> Programmes de fidélité et rewards automatisés</li>
          </ul>
          <div class="mail-kpi-highlight">
            <span class="mail-kpi-chip">+21.3% Réservations</span>
            <span class="mail-kpi-chip">42.7% Ouverture</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- =====================================================
     7. SOCIAL MEDIA
     ===================================================== -->
<section id="social-page" class="section-page" style="padding:0;background:#fff">
  <div class="social-top">
    <div class="social-top-inner">
      <h1>Réseaux Sociaux<br>360°</h1>
      <p>De la stratégie éditoriale au reporting mensuel, nous pilotons votre présence digitale sur tous les réseaux performants. Contenus, community management, campagnes & croissance.</p>
      <div class="social-platform-pills">
        <div class="social-pill"><i class="fab fa-instagram"></i> Instagram</div>
        <div class="social-pill"><i class="fab fa-facebook"></i> Facebook</div>
        <div class="social-pill"><i class="fab fa-tiktok"></i> TikTok</div>
        <div class="social-pill"><i class="fab fa-linkedin"></i> LinkedIn</div>
        <div class="social-pill"><i class="fab fa-youtube"></i> YouTube</div>
        <div class="social-pill"><i class="fab fa-pinterest"></i> Pinterest</div>
        <div class="social-pill"><i class="fab fa-twitter"></i> X / Twitter</div>
        <div class="social-pill"><i class="fab fa-snapchat"></i> Snapchat</div>
      </div>
    </div>
  </div>

  <div class="social-platforms-grid">
    <h2 class="social-platforms-title">Nos plateformes gérées</h2>
    <div class="social-grid">
      <div class="social-platform-card insta">
        <div class="social-platform-icon"><i class="fab fa-instagram"></i></div>
        <div class="social-platform-name">Instagram</div>
        <div class="social-platform-followers">128K abonnés · +12% ce mois</div>
        <span class="social-platform-metric">4.8% Engagement</span>
      </div>
      <div class="social-platform-card fb">
        <div class="social-platform-icon"><i class="fab fa-facebook-f"></i></div>
        <div class="social-platform-name">Facebook</div>
        <div class="social-platform-followers">89K fans · +8% ce mois</div>
        <span class="social-platform-metric">3.2% Reach organique</span>
      </div>
      <div class="social-platform-card tt">
        <div class="social-platform-icon"><i class="fab fa-tiktok"></i></div>
        <div class="social-platform-name">TikTok</div>
        <div class="social-platform-followers">245K abonnés · +31% ce mois</div>
        <span class="social-platform-metric">8.1M vues/mois</span>
      </div>
      <div class="social-platform-card li">
        <div class="social-platform-icon"><i class="fab fa-linkedin-in"></i></div>
        <div class="social-platform-name">LinkedIn</div>
        <div class="social-platform-followers">42K abonnés · +18% ce mois</div>
        <span class="social-platform-metric">6.4% B2B reach</span>
      </div>
      <div class="social-platform-card yt">
        <div class="social-platform-icon"><i class="fab fa-youtube"></i></div>
        <div class="social-platform-name">YouTube</div>
        <div class="social-platform-followers">67K abonnés · +22% ce mois</div>
        <span class="social-platform-metric">3.2M vues totales</span>
      </div>
      <div class="social-platform-card pin">
        <div class="social-platform-icon"><i class="fab fa-pinterest-p"></i></div>
        <div class="social-platform-name">Pinterest</div>
        <div class="social-platform-followers">156K followers · +9% ce mois</div>
        <span class="social-platform-metric">1.8M impressions</span>
      </div>
      <div class="social-platform-card tw">
        <div class="social-platform-icon"><i class="fab fa-twitter"></i></div>
        <div class="social-platform-name">X / Twitter</div>
        <div class="social-platform-followers">31K abonnés · +5% ce mois</div>
        <span class="social-platform-metric">2.1% Engagement</span>
      </div>
      <div class="social-platform-card sn">
        <div class="social-platform-icon"><i class="fab fa-snapchat-ghost"></i></div>
        <div class="social-platform-name">Snapchat</div>
        <div class="social-platform-followers">18K abonnés · +14% ce mois</div>
        <span class="social-platform-metric">72% Vue complète</span>
      </div>
    </div>
  </div>

  <div class="social-services">
    <div class="social-services-inner">
      <h2 class="social-services-title">Nos 4 piliers du Social Media</h2>
      <div class="social-services-grid">
        <div class="social-service-item">
          <div class="social-service-icon-box"><i class="fas fa-pen-nib"></i></div>
          <div>
            <h4>Stratégie & création de contenu</h4>
            <p>Calendrier éditorial mensuel, storytelling de marque percutant, scripts reels viraux, hooks performants et planification multi-plateformes optimisée par l'IA. Chaque contenu est pensé pour votre cible.</p>
          </div>
        </div>
        <div class="social-service-item">
          <div class="social-service-icon-box"><i class="fas fa-comments"></i></div>
          <div>
            <h4>Community management actif</h4>
            <p>Réponses aux commentaires et messages privés, gestion de réputation en temps réel, animation de communauté engagée et protocole de modération pour protéger votre image de marque.</p>
          </div>
        </div>
        <div class="social-service-item">
          <div class="social-service-icon-box"><i class="fas fa-bullhorn"></i></div>
          <div>
            <h4>Campagnes & social ads</h4>
            <p>Création et gestion de campagnes Meta, LinkedIn Ads et TikTok Ads avec ciblage intelligent par persona, tests A/B multivariés, retargeting avancé et optimisation continue du budget.</p>
          </div>
        </div>
        <div class="social-service-item">
          <div class="social-service-icon-box"><i class="fas fa-chart-pie"></i></div>
          <div>
            <h4>Analytics & performance continue</h4>
            <p>KPIs hebdomadaires détaillés, dashboards dynamiques en temps réel, recommandations d'optimisation basées sur les données, suivi de conversion et rapports mensuels complets avec insights actionnables.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- =====================================================
     8. GALERIE PHOTOS
     ===================================================== -->
<section id="gallerie-page" class="section-page" style="padding:0;background:#fafafa">
  <div class="gallery-hero">
    <div class="gallery-hero-inner">
      <div>
        <div class="gallery-hero-label">Collection GoExploria</div>
        <h1 class="gallery-hero h1" style="font-family:'Playfair Display',serif;font-size:clamp(40px,5vw,64px);color:#1a1a1a;line-height:1.1;margin-bottom:16px">Espaces<br>Photos</h1>
        <p style="font-size:16px;color:#666;line-height:1.7;max-width:520px">Destinations internationales, aventures extraordinaires, cultures du monde. Chaque photo raconte une histoire. Explorez, enregistrez, inspirez-vous.</p>
      </div>
      <div class="gallery-hero-count">
        <strong>12</strong>
        <span>Photos · 5 continents</span>
      </div>
    </div>
  </div>

  <div class="gallery-filter-bar">
    <button class="gallery-filter-btn active"><i class="fas fa-th-large"></i> Toutes catégories</button>
    <button class="gallery-filter-btn"><i class="fas fa-leaf"></i> Nature</button>
    <button class="gallery-filter-btn"><i class="fas fa-landmark"></i> Culture</button>
    <button class="gallery-filter-btn"><i class="fas fa-utensils"></i> Gastronomie</button>
    <button class="gallery-filter-btn"><i class="fas fa-mountain"></i> Aventure</button>
    <button class="gallery-filter-btn"><i class="fas fa-city"></i> Urbain</button>
  </div>

  <div class="gallery-masonry">
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=500&h=700&fit=crop" alt="Aurores Nordiques">
      <div class="gallery-item-overlay">
        <button class="gallery-save-btn"><i class="fas fa-thumbtack"></i> Enregistrer</button>
        <div class="gallery-item-info"><h4>Aurores Nordiques</h4><span><i class="fas fa-map-marker-alt"></i> Canada</span></div>
      </div>
    </div>
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?w=500&h=620&fit=crop" alt="Venise">
      <div class="gallery-item-overlay">
        <button class="gallery-save-btn"><i class="fas fa-thumbtack"></i> Enregistrer</button>
        <div class="gallery-item-info"><h4>Canaux de Venise</h4><span><i class="fas fa-map-marker-alt"></i> Italie</span></div>
      </div>
    </div>
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1548013146-72479768bada?w=500&h=640&fit=crop" alt="Kyoto">
      <div class="gallery-item-overlay">
        <button class="gallery-save-btn"><i class="fas fa-thumbtack"></i> Enregistrer</button>
        <div class="gallery-item-info"><h4>Temple de Kyoto</h4><span><i class="fas fa-map-marker-alt"></i> Japon</span></div>
      </div>
    </div>
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1472396961693-142e6e269027?w=500&h=580&fit=crop" alt="Safari">
      <div class="gallery-item-overlay">
        <button class="gallery-save-btn"><i class="fas fa-thumbtack"></i> Enregistrer</button>
        <div class="gallery-item-info"><h4>Safari Doré</h4><span><i class="fas fa-map-marker-alt"></i> Kenya</span></div>
      </div>
    </div>
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=500&h=700&fit=crop" alt="Pacifique">
      <div class="gallery-item-overlay">
        <button class="gallery-save-btn"><i class="fas fa-thumbtack"></i> Enregistrer</button>
        <div class="gallery-item-info"><h4>Océan Pacifique</h4><span><i class="fas fa-map-marker-alt"></i> Australie</span></div>
      </div>
    </div>
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1516483638261-f4dbaf036963?w=500&h=620&fit=crop" alt="Montréal">
      <div class="gallery-item-overlay">
        <button class="gallery-save-btn"><i class="fas fa-thumbtack"></i> Enregistrer</button>
        <div class="gallery-item-info"><h4>Ruelles de Montréal</h4><span><i class="fas fa-map-marker-alt"></i> Québec</span></div>
      </div>
    </div>
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1541544741938-0af808871cc0?w=500&h=500&fit=crop" alt="Gastronomie">
      <div class="gallery-item-overlay">
        <button class="gallery-save-btn"><i class="fas fa-thumbtack"></i> Enregistrer</button>
        <div class="gallery-item-info"><h4>Saveurs Boréales</h4><span><i class="fas fa-map-marker-alt"></i> Canada</span></div>
      </div>
    </div>
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=500&h=680&fit=crop" alt="Paris">
      <div class="gallery-item-overlay">
        <button class="gallery-save-btn"><i class="fas fa-thumbtack"></i> Enregistrer</button>
        <div class="gallery-item-info"><h4>Paris au Lever du Jour</h4><span><i class="fas fa-map-marker-alt"></i> France</span></div>
      </div>
    </div>
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=500&h=640&fit=crop" alt="Alpes">
      <div class="gallery-item-overlay">
        <button class="gallery-save-btn"><i class="fas fa-thumbtack"></i> Enregistrer</button>
        <div class="gallery-item-info"><h4>Alpes Sauvages</h4><span><i class="fas fa-map-marker-alt"></i> Suisse</span></div>
      </div>
    </div>
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1489515217757-5fd1be406fef?w=500&h=600&fit=crop" alt="Marrakech">
      <div class="gallery-item-overlay">
        <button class="gallery-save-btn"><i class="fas fa-thumbtack"></i> Enregistrer</button>
        <div class="gallery-item-info"><h4>Marrakech Colorée</h4><span><i class="fas fa-map-marker-alt"></i> Maroc</span></div>
      </div>
    </div>
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1526772662000-3f88f10405ff?w=500&h=700&fit=crop" alt="Andes">
      <div class="gallery-item-overlay">
        <button class="gallery-save-btn"><i class="fas fa-thumbtack"></i> Enregistrer</button>
        <div class="gallery-item-info"><h4>Route des Andes</h4><span><i class="fas fa-map-marker-alt"></i> Chili</span></div>
      </div>
    </div>
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1528164344705-47542687000d?w=500&h=560&fit=crop" alt="Tokyo">
      <div class="gallery-item-overlay">
        <button class="gallery-save-btn"><i class="fas fa-thumbtack"></i> Enregistrer</button>
        <div class="gallery-item-info"><h4>Nuit de Tokyo</h4><span><i class="fas fa-map-marker-alt"></i> Japon</span></div>
      </div>
    </div>
  </div>
</section>

<!-- =====================================================
     9. MULTILINGUE
     ===================================================== -->
<section id="multilingue-page" class="section-page" style="padding:0;background:#f4f6f9">
  <div class="multi-hero">
    <div class="multi-hero-inner">
      <div class="multi-hero-sub"><i class="fas fa-globe-americas"></i> Espace Entreprise International</div>
      <h1 class="multi-hero" style="font-family:'Outfit',sans-serif;font-size:clamp(40px,5vw,64px);font-weight:900;color:#1a1a1a;margin-bottom:20px">Votre Entreprise<br>Sans Frontières</h1>
      <p style="font-size:17px;color:#666;line-height:1.8;max-width:600px;margin:0 auto 32px">Choisissez votre langue préférée afin de pénétrer les marchés internationaux et offrir une expérience d'achat exclusive à vos clients du monde entier. SEO Google CDN inclus.</p>
      <span class="multi-globe"><i class="fas fa-globe"></i> 25 langues disponibles · SEO Google CDN</span>
      <div class="multi-hero-flags">
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/fr.png" alt="France"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/gb.png" alt="UK"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/es.png" alt="Espagne"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/de.png" alt="Allemagne"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/cn.png" alt="Chine"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/in.png" alt="Inde"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/pt.png" alt="Portugal"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/sa.png" alt="Arabie"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/jp.png" alt="Japon"></div>
      </div>
    </div>
  </div>

  <div class="multi-grid-section">
    <h2 class="multi-grid-title">Choisissez votre langue principale</h2>
    <div class="multi-grid">
      <div class="multi-lang-card selected">
        <span class="multi-badge principale">PRINCIPALE</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/fr.png" alt="Français"></div>
        <div class="multi-lang-name">Français</div>
        <p class="multi-lang-desc">Langue originale. Contenu complet et support client en français 24h/7j.</p>
        <button class="multi-select-btn active"><i class="fas fa-check"></i> Sélectionné</button>
      </div>
      <div class="multi-lang-card">
        <span class="multi-badge populaire">POPULAIRE</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/gb.png" alt="Anglais"></div>
        <div class="multi-lang-name">English</div>
        <p class="multi-lang-desc">International version. Full content and 24/7 customer support available.</p>
        <button class="multi-select-btn"><i class="fas fa-globe"></i> Select</button>
      </div>
      <div class="multi-lang-card">
        <span class="multi-badge nouveau">NOUVEAU</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/es.png" alt="Espagnol"></div>
        <div class="multi-lang-name">Español</div>
        <p class="multi-lang-desc">Versión internacional completa con soporte al cliente en español.</p>
        <button class="multi-select-btn"><i class="fas fa-globe"></i> Seleccionar</button>
      </div>
      <div class="multi-lang-card">
        <span class="multi-badge prochaine">PROCHAINE</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/de.png" alt="Allemand"></div>
        <div class="multi-lang-name">Deutsch</div>
        <p class="multi-lang-desc">Internationale Version. Vollständiger Inhalt und Kundensupport.</p>
        <button class="multi-select-btn"><i class="fas fa-globe"></i> Auswählen</button>
      </div>
    </div>

    <!-- SEO box -->
    <div class="multi-seo-box">
      <div>
        <h3>🌐 SEO Google / CDN inclus avec chaque langue</h3>
        <p>Votre espace entreprise multilingue inclut un référencement Google optimisé pour chaque marché, un CDN mondial pour des temps de chargement ultra-rapides, et 4 à 25 langues disponibles selon votre plan. Atteignez vos clients partout dans le monde avec la même qualité d'expérience.</p>
      </div>
      <a href="#" class="multi-seo-btn">Voir les plans <i class="fas fa-arrow-right"></i></a>
    </div>

    <!-- Row 2 langues -->
    <h2 class="multi-grid-title">Langues stratégiques supplémentaires</h2>
    <div class="multi-grid">
      <div class="multi-lang-card">
        <span class="multi-badge principale">STRATÉGIQUE</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/cn.png" alt="Chinois"></div>
        <div class="multi-lang-name">中文</div>
        <p class="multi-lang-desc">Langue stratégique pour le marché asiatique de 1.4 milliard de consommateurs.</p>
        <button class="multi-select-btn"><i class="fas fa-globe"></i> 选择</button>
      </div>
      <div class="multi-lang-card">
        <span class="multi-badge populaire">POPULAIRE</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/in.png" alt="Hindi"></div>
        <div class="multi-lang-name">हिंदी</div>
        <p class="multi-lang-desc">Accédez au marché indien, deuxième économie mondiale émergente.</p>
        <button class="multi-select-btn"><i class="fas fa-globe"></i> चुनें</button>
      </div>
      <div class="multi-lang-card">
        <span class="multi-badge nouveau">NOUVEAU</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/pt.png" alt="Portugais"></div>
        <div class="multi-lang-name">Português</div>
        <p class="multi-lang-desc">Couvrez le Brésil, Portugal et toute la Lusophonie avec un seul contenu.</p>
        <button class="multi-select-btn"><i class="fas fa-globe"></i> Selecionar</button>
      </div>
      <div class="multi-lang-card">
        <span class="multi-badge prochaine">PROCHAINE</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/sa.png" alt="Arabe"></div>
        <div class="multi-lang-name">العربية</div>
        <p class="multi-lang-desc">Pénétrez les marchés du Golfe et du monde arabe avec une interface RTL parfaite.</p>
        <button class="multi-select-btn"><i class="fas fa-globe"></i> اختر</button>
      </div>
    </div>
  </div>
</section>

<!-- =====================================================
     10. TIKTOK CAROUSEL
     ===================================================== -->
<section id="tiktok-page" class="section-page" style="padding:0;background:#000">
  <div class="ttk-detail-hero">
    <div class="ttk-hero-inner">
      <div class="ttk-hero-logo"><i class="fab fa-tiktok" style="background:linear-gradient(135deg,#25f4ee,#fe2c55);-webkit-background-clip:text;-webkit-text-fill-color:transparent"></i></div>
      <h1 class="ttk-hero-title">Chaîne Vidéos<br>GoExploria</h1>
      <p class="ttk-hero-desc">Découvertes, aventures, gastronomie et culture — explorez le Québec en format court sur notre chaîne TikTok officielle avec plus de 245 000 abonnés engagés.</p>
      <div class="ttk-hero-stats">
        <div class="ttk-hero-stat"><strong>245K</strong><span>Abonnés</span></div>
        <div class="ttk-hero-stat"><strong>8.1M</strong><span>Vues/mois</span></div>
        <div class="ttk-hero-stat"><strong>23M+</strong><span>Total vues</span></div>
        <div class="ttk-hero-stat"><strong>8.1%</strong><span>Engagement</span></div>
      </div>
    </div>
  </div>

  <div class="ttk-videos-section">
    <div class="ttk-section-label">Contenus récents</div>
    <h2 class="ttk-section-title">Nos dernières vidéos virales</h2>
    <div class="ttk-video-grid">
      <div class="ttk-video-card">
        <img src="https://images.unsplash.com/photo-1467810563316-b5476525c0f9?w=300&h=533&fit=crop" alt="">
        <div class="ttk-video-card-overlay">
          <div class="ttk-video-card-views"><i class="fas fa-play"></i> 253.4K</div>
          <div class="ttk-video-card-caption">Gala Saint-Sylvestre 2026 — La soirée de rêve à Montréal 🎉🥂</div>
        </div>
        <div class="ttk-play-overlay"><i class="fas fa-play"></i></div>
      </div>
      <div class="ttk-video-card">
        <img src="https://images.unsplash.com/photo-1536935338788-846bb9981813?w=300&h=533&fit=crop" alt="">
        <div class="ttk-video-card-overlay">
          <div class="ttk-video-card-views"><i class="fas fa-play"></i> 5.5M</div>
          <div class="ttk-video-card-caption">Baleines à Tadoussac 🐋 Un moment magique au Saguenay</div>
        </div>
        <div class="ttk-play-overlay"><i class="fas fa-play"></i></div>
      </div>
      <div class="ttk-video-card">
        <img src="https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=300&h=533&fit=crop" alt="">
        <div class="ttk-video-card-overlay">
          <div class="ttk-video-card-views"><i class="fas fa-play"></i> 147.1K</div>
          <div class="ttk-video-card-caption">Mont-Tremblant en hiver ⛷️ Les pistes comme jamais vues</div>
        </div>
        <div class="ttk-play-overlay"><i class="fas fa-play"></i></div>
      </div>
      <div class="ttk-video-card">
        <img src="https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=300&h=533&fit=crop" alt="">
        <div class="ttk-video-card-overlay">
          <div class="ttk-video-card-views"><i class="fas fa-play"></i> 19M</div>
          <div class="ttk-video-card-caption">Festival de Jazz Montréal 🎷 L'ambiance électrisante</div>
        </div>
        <div class="ttk-play-overlay"><i class="fas fa-play"></i></div>
      </div>
      <div class="ttk-video-card">
        <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=300&h=533&fit=crop" alt="">
        <div class="ttk-video-card-overlay">
          <div class="ttk-video-card-views"><i class="fas fa-play"></i> 11.8M</div>
          <div class="ttk-video-card-caption">Top 10 restaurants Montréal 2026 🍽️ Notre sélection secrète</div>
        </div>
        <div class="ttk-play-overlay"><i class="fas fa-play"></i></div>
      </div>
      <div class="ttk-video-card">
        <img src="https://images.unsplash.com/photo-1559329007-40df8a9345d8?w=300&h=533&fit=crop" alt="">
        <div class="ttk-video-card-overlay">
          <div class="ttk-video-card-views"><i class="fas fa-play"></i> 101.7K</div>
          <div class="ttk-video-card-caption">Vieux-Québec en 4K 🏰 Balade dans le quartier UNESCO</div>
        </div>
        <div class="ttk-play-overlay"><i class="fas fa-play"></i></div>
      </div>
      <div class="ttk-video-card">
        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=300&h=533&fit=crop" alt="">
        <div class="ttk-video-card-overlay">
          <div class="ttk-video-card-views"><i class="fas fa-play"></i> 23.2M</div>
          <div class="ttk-video-card-caption">Cabane à sucre authentique 🍁 La vraie expérience québécoise</div>
        </div>
        <div class="ttk-play-overlay"><i class="fas fa-play"></i></div>
      </div>
      <div class="ttk-video-card">
        <img src="https://images.unsplash.com/photo-1547592180-85f173990554?w=300&h=533&fit=crop" alt="">
        <div class="ttk-video-card-overlay">
          <div class="ttk-video-card-views"><i class="fas fa-play"></i> 33.4M</div>
          <div class="ttk-video-card-caption">Road Trip Charlevoix de Québec à Baie-Saint-Paul 🚗</div>
        </div>
        <div class="ttk-play-overlay"><i class="fas fa-play"></i></div>
      </div>
      <div class="ttk-video-card">
        <img src="https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?w=300&h=533&fit=crop" alt="">
        <div class="ttk-video-card-overlay">
          <div class="ttk-video-card-views"><i class="fas fa-play"></i> 19M</div>
          <div class="ttk-video-card-caption">Les Îles-de-la-Madeleine — Paradis sauvage 🌊</div>
        </div>
        <div class="ttk-play-overlay"><i class="fas fa-play"></i></div>
      </div>
      <div class="ttk-video-card">
        <img src="https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=300&h=533&fit=crop" alt="">
        <div class="ttk-video-card-overlay">
          <div class="ttk-video-card-views"><i class="fas fa-play"></i> 151.6K</div>
          <div class="ttk-video-card-caption">Accord Mets & Vins masterclass avec notre sommelier 🍷</div>
        </div>
        <div class="ttk-play-overlay"><i class="fas fa-play"></i></div>
      </div>
      <div class="ttk-video-card">
        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=300&h=533&fit=crop" alt="">
        <div class="ttk-video-card-overlay">
          <div class="ttk-video-card-views"><i class="fas fa-play"></i> 134.2K</div>
          <div class="ttk-video-card-caption">Tire d'érable en direct — La recette de grand-mère 🍁</div>
        </div>
        <div class="ttk-play-overlay"><i class="fas fa-play"></i></div>
      </div>
      <div class="ttk-video-card">
        <img src="https://images.unsplash.com/photo-1544025162-d76694265947?w=300&h=533&fit=crop" alt="">
        <div class="ttk-video-card-overlay">
          <div class="ttk-video-card-views"><i class="fas fa-play"></i> 148.3K</div>
          <div class="ttk-video-card-caption">GoExploria Radio 🎙️ Nouveaux épisodes chaque semaine</div>
        </div>
        <div class="ttk-play-overlay"><i class="fas fa-play"></i></div>
      </div>
    </div>
  </div>
</section>

<!-- =====================================================
     11. VIDEO PLAYER - MA CHAINE VIDEO
     ===================================================== -->
<section id="video-page" class="section-page" style="padding:0;background:#0a0e1a">
  <div class="vp-detail-hero">
    <div class="vp-detail-inner">
      <div>
        <div class="vp-hero-eyebrow">Ma Chaîne Vidéo GoExploria</div>
        <h1 class="vp-hero-title">Films, <em>documentaires</em><br>& aventures<br>en images</h1>
        <p class="vp-hero-desc">Explorez le Québec et le monde entier en images haute définition avec la chaîne vidéo officielle GoExploria. Films documentaires, expériences plein air, gastronomie et culture en 30 vidéos exclusives.</p>
        <div class="vp-channel-stats">
          <div class="vp-stat"><strong>30</strong><span>Vidéos HD</span></div>
          <div class="vp-stat"><strong>6</strong><span>Continents</span></div>
          <div class="vp-stat"><strong>5</strong><span>Catégories</span></div>
        </div>
      </div>
      <div class="vp-player-preview">
        <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=900&h=500&fit=crop" alt="Player preview">
        <div class="vp-player-play"><i class="fas fa-play"></i></div>
        <div class="vp-player-bar">
          <div class="vp-progress"><div class="vp-progress-fill"></div></div>
          <div class="vp-controls-row">
            <span>Canada — Panorama Signature · 0:05</span>
            <div class="vp-controls-icons"><i class="fas fa-volume-up"></i><i class="fas fa-expand"></i></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Playlist -->
  <div class="vp-playlist-section">
    <div class="vp-playlist-inner">
      <div class="vp-playlist-header">
        <h2 class="vp-playlist-title">Playlist — Amérique du Nord · Canada</h2>
        <span class="vp-playlist-count">5 / 30 vidéos</span>
      </div>
      <div class="vp-playlist-grid">
        <div class="vp-playlist-card">
          <img src="https://img.youtube.com/vi/VhPCb_gSu-4/hqdefault.jpg" alt="Video 1">
          <span class="vp-playlist-badge">▶ 0:05</span>
          <div class="vp-playlist-info">
            <h5>Canada — Panorama Signature</h5>
            <span>Destination · Québec</span>
          </div>
        </div>
        <div class="vp-playlist-card">
          <img src="https://img.youtube.com/vi/uyrBtsvmzqM/hqdefault.jpg" alt="Video 2">
          <span class="vp-playlist-badge">▶ 0:10</span>
          <div class="vp-playlist-info">
            <h5>Canada — Expériences Plein Air</h5>
            <span>Activité · Ontario</span>
          </div>
        </div>
        <div class="vp-playlist-card">
          <img src="https://img.youtube.com/vi/Scxs7L0vhZ4/hqdefault.jpg" alt="Video 3">
          <span class="vp-playlist-badge">▶ 0:15</span>
          <div class="vp-playlist-info">
            <h5>Canada — Saveurs & Gastronomie</h5>
            <span>Gastronomie · Alberta</span>
          </div>
        </div>
        <div class="vp-playlist-card">
          <img src="https://img.youtube.com/vi/ysz5S6PUM-U/hqdefault.jpg" alt="Video 4">
          <span class="vp-playlist-badge">▶ 0:20</span>
          <div class="vp-playlist-info">
            <h5>Canada — Patrimoine & Culture</h5>
            <span>Culture · C.-Britannique</span>
          </div>
        </div>
        <div class="vp-playlist-card">
          <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=400&h=225&fit=crop" alt="Video 5">
          <span class="vp-playlist-badge">▶ 0:30</span>
          <div class="vp-playlist-info">
            <h5>Canada — Aventure Nature</h5>
            <span>Aventure · Nouvelle-Écosse</span>
          </div>
        </div>
      </div>

      <!-- Category buttons -->
      <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:40px;padding-top:40px;border-top:1px solid rgba(255,255,255,0.08)">
        <button style="background:#e8761a;color:#fff;border:none;border-radius:999px;padding:10px 20px;font-size:13px;font-weight:700;cursor:pointer"><i class="fas fa-th-large"></i> Toutes catégories</button>
        <button style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.7);border:1px solid rgba(255,255,255,0.12);border-radius:999px;padding:10px 20px;font-size:13px;font-weight:700;cursor:pointer"><i class="fas fa-map-marked-alt"></i> Destination</button>
        <button style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.7);border:1px solid rgba(255,255,255,0.12);border-radius:999px;padding:10px 20px;font-size:13px;font-weight:700;cursor:pointer"><i class="fas fa-person-hiking"></i> Activité</button>
        <button style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.7);border:1px solid rgba(255,255,255,0.12);border-radius:999px;padding:10px 20px;font-size:13px;font-weight:700;cursor:pointer"><i class="fas fa-utensils"></i> Gastronomie</button>
        <button style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.7);border:1px solid rgba(255,255,255,0.12);border-radius:999px;padding:10px 20px;font-size:13px;font-weight:700;cursor:pointer"><i class="fas fa-landmark"></i> Culture</button>
        <button style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.7);border:1px solid rgba(255,255,255,0.12);border-radius:999px;padding:10px 20px;font-size:13px;font-weight:700;cursor:pointer"><i class="fas fa-mountain"></i> Aventure</button>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer style="background:#1a1a1a;padding:60px 40px;border-top:1px solid #333">
  <div style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:60px;align-items:start">
    <div>
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px">
        <div style="width:40px;height:40px;background:linear-gradient(135deg,#e8761a,#c04f10);border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:14px;color:#fff;font-family:'Bebas Neue',sans-serif;letter-spacing:1px">GO</div>
        <span style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:16px;color:#fff">GoExploria Business</span>
      </div>
      <p style="font-size:14px;color:rgba(255,255,255,0.55);line-height:1.8;max-width:300px">La plateforme tout-en-un pour développer votre business touristique et rayonner à l'international. 15+ années d'expertise, 40 pays couverts.</p>
    </div>
    <div>
      <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,0.4);margin-bottom:16px">Solutions</h4>
      <ul style="list-style:none;display:flex;flex-direction:column;gap:8px">
        <li><a href="#" style="font-size:14px;color:rgba(255,255,255,0.7);text-decoration:none">Business Web</a></li>
        <li><a href="#" style="font-size:14px;color:rgba(255,255,255,0.7);text-decoration:none">Tourisme</a></li>
        <li><a href="#" style="font-size:14px;color:rgba(255,255,255,0.7);text-decoration:none">Mail Marketing</a></li>
        <li><a href="#" style="font-size:14px;color:rgba(255,255,255,0.7);text-decoration:none">Social Media</a></li>
      </ul>
    </div>
    <div>
      <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,0.4);margin-bottom:16px">Contenu</h4>
      <ul style="list-style:none;display:flex;flex-direction:column;gap:8px">
        <li><a href="#" style="font-size:14px;color:rgba(255,255,255,0.7);text-decoration:none">Destinations</a></li>
        <li><a href="#" style="font-size:14px;color:rgba(255,255,255,0.7);text-decoration:none">Blog Éditorial</a></li>
        <li><a href="#" style="font-size:14px;color:rgba(255,255,255,0.7);text-decoration:none">Galerie Photos</a></li>
        <li><a href="#" style="font-size:14px;color:rgba(255,255,255,0.7);text-decoration:none">Chaîne Vidéos</a></li>
      </ul>
    </div>
    <div>
      <h4 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,0.4);margin-bottom:16px">Contact</h4>
      <ul style="list-style:none;display:flex;flex-direction:column;gap:8px">
        <li><a href="#" style="font-size:14px;color:rgba(255,255,255,0.7);text-decoration:none"><i class="fas fa-envelope" style="margin-right:6px;color:#e8761a"></i>info@goexploria.com</a></li>
        <li><a href="#" style="font-size:14px;color:rgba(255,255,255,0.7);text-decoration:none"><i class="fas fa-globe" style="margin-right:6px;color:#e8761a"></i>goexploria.com</a></li>
        <li><a href="#" style="font-size:14px;color:rgba(255,255,255,0.7);text-decoration:none"><i class="fab fa-tiktok" style="margin-right:6px;color:#e8761a"></i>@goexploria.official</a></li>
        <li><a href="#" style="font-size:14px;color:rgba(255,255,255,0.7);text-decoration:none"><i class="fab fa-instagram" style="margin-right:6px;color:#e8761a"></i>@goexploria</a></li>
      </ul>
    </div>
  </div>
  <div style="max-width:1200px;margin:40px auto 0;padding-top:32px;border-top:1px solid rgba(255,255,255,0.08);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px">
    <span style="font-size:12px;color:rgba(255,255,255,0.35)">© 2026 GoExploria Business. Tous droits réservés.</span>
    <span style="font-size:12px;color:rgba(255,255,255,0.35)">Québec · Canada · International</span>
  </div>
</footer>

<script>
// Filter buttons interaction
document.querySelectorAll('.dest-filter-btn, .gallery-filter-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    const group = this.closest('.dest-filters-row, .gallery-filter-bar');
    group.querySelectorAll('button').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
  });
});

// Multi lang card select
document.querySelectorAll('.multi-select-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    const card = this.closest('.multi-lang-card');
    const grid = card.closest('.multi-grid');
    grid.querySelectorAll('.multi-select-btn').forEach(b => {
      b.classList.remove('active');
      b.innerHTML = b.innerHTML.replace('fa-check', 'fa-globe').replace('Sélectionné', 'Sélectionner');
    });
    grid.querySelectorAll('.multi-lang-card').forEach(c => c.classList.remove('selected'));
    this.classList.add('active');
    card.classList.add('selected');
  });
});
</script>
</body>
</html>