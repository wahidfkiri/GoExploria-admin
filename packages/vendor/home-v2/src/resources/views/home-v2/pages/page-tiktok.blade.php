@extends('home-v2.layouts.app')

@section('title', 'TikTok — Stratégie & Community Management')
@section('meta_description', 'Gestion complète de votre compte TikTok : création de contenu, community management, social ads et analytics.')

@section('breadcrumb')
<span class="current">TikTok</span>
@endsection

@section('page-styles')

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
@endsection

@section('content')
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
@endsection

@section('scripts')
<script>
// Animated counter for hero stats
function animateCounter(el, target, suffix) {
  let current = 0;
  const increment = target / 60;
  const timer = setInterval(() => {
    current += increment;
    if (current >= target) {
      current = target;
      clearInterval(timer);
    }
    el.textContent = Math.floor(current) + suffix;
  }, 16);
}
</script>
@endsection