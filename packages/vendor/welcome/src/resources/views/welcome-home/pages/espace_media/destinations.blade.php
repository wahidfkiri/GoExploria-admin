@extends('welcome-home.layouts.app')

@section('title', 'Destinations Vedettes — Québec, Canada & Amérique du Nord')
@section('meta_description', 'Découvrez les plus belles destinations du Québec, du Canada et d\'Amérique du Nord. Charlevoix, Gaspésie, Montréal, Mont-Tremblant et bien plus.')

@section('breadcrumb')
<span class="current">Destinations Vedettes</span>
@endsection

@section('page-styles')
<style>
/* CINEMATIC HERO */
.dest-hero{height:90vh;min-height:600px;position:relative;overflow:hidden;display:flex;align-items:flex-end}
.dest-hero-bg{position:absolute;inset:0}
.dest-hero-bg img{width:100%;height:100%;object-fit:cover}
.dest-hero-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(8,12,22,0.95) 0%,rgba(8,12,22,0.25) 60%,transparent 100%)}
.dest-hero-content{position:relative;z-index:2;padding:64px 80px;width:100%;display:flex;align-items:flex-end;justify-content:space-between;gap:40px}
.dest-breadcrumb{display:flex;align-items:center;gap:8px;font-size:12px;color:rgba(255,255,255,0.55);margin-bottom:14px}
.dest-breadcrumb .sep{color:rgba(255,255,255,0.3)}
.dest-hero-title{font-family:'Playfair Display',serif;font-size:clamp(52px,6.5vw,88px);color:#fff;line-height:1.02;margin-bottom:18px}
.dest-hero-desc{font-size:16px;color:rgba(255,255,255,0.78);line-height:1.75;max-width:540px;margin-bottom:32px}
.dest-tag-cloud{display:flex;flex-wrap:wrap;gap:8px}
.dest-tag{background:rgba(255,255,255,0.13);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.2);color:#fff;font-size:12px;font-weight:600;padding:6px 14px;border-radius:999px;transition:background 0.2s}
.dest-tag:hover{background:rgba(232,118,26,0.4);border-color:#e8761a}
.dest-weather-card{background:rgba(255,255,255,0.1);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.18);border-radius:20px;padding:28px;color:#fff;min-width:260px}
.dest-weather-temp{font-family:'Bebas Neue',sans-serif;font-size:68px;line-height:1}
.dest-weather-label{font-size:13px;color:rgba(255,255,255,0.65);margin-top:4px}
.dest-weather-row{display:flex;justify-content:space-between;margin-top:20px;padding-top:20px;border-top:1px solid rgba(255,255,255,0.14)}
.dest-weather-row span{font-size:12px;color:rgba(255,255,255,0.65);text-align:center}
.dest-weather-row strong{display:block;font-size:16px;color:#fff}

/* FILTERS + CARDS */
.dest-cards-section{background:#f9f7f4;padding:80px 40px}
.dest-cards-inner{max-width:1300px;margin:0 auto}
.dest-filters{display:flex;gap:10px;margin-bottom:40px;flex-wrap:wrap;align-items:center}
.dest-filter-btn{border:1.5px solid #e5e7eb;background:#fff;border-radius:999px;font-size:13px;font-weight:600;color:#666;padding:8px 20px;cursor:pointer;transition:all 0.2s;display:flex;align-items:center;gap:6px}
.dest-filter-btn:hover,.dest-filter-btn.active{border-color:#e8761a;color:#e8761a;background:#fef3ea}
.dest-count{margin-left:auto;font-size:13px;color:#888}

.dest-grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:24px}
.dest-grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.dest-card{border-radius:20px;overflow:hidden;position:relative;cursor:pointer;transition:transform 0.3s}
.dest-card:hover{transform:scale(1.025);z-index:2}
.dest-card img{width:100%;display:block}
.dest-card.portrait img{aspect-ratio:3/4;object-fit:cover}
.dest-card.landscape img{aspect-ratio:4/3;object-fit:cover}
.dest-card-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.82),transparent 55%);padding:22px;display:flex;flex-direction:column;justify-content:flex-end}
.dest-card h3{color:#fff;font-size:20px;font-weight:700;font-family:'Playfair Display',serif;margin-bottom:4px}
.dest-card p{color:rgba(255,255,255,0.78);font-size:12px}
.dest-card .rating{color:#f59e0b;font-size:13px;margin-top:6px}
.dest-badge{position:absolute;top:14px;left:14px;background:#e8761a;color:#fff;font-size:10px;font-weight:700;padding:4px 10px;border-radius:999px;text-transform:uppercase;letter-spacing:0.8px}
.dest-badge.new{background:#10b981}
.dest-badge.hot{background:#ef4444}
.dest-badge.trend{background:#8b5cf6}

/* FEATURED DEST */
.dest-featured{background:#fff;padding:80px 40px}
.dest-featured-inner{max-width:1300px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center}
.dest-featured-img-wrap{position:relative;border-radius:24px;overflow:hidden;height:520px}
.dest-featured-img-wrap img{width:100%;height:100%;object-fit:cover}
.dest-featured-stat-badge{position:absolute;top:24px;right:24px;background:rgba(255,255,255,0.95);border-radius:14px;padding:16px 20px;box-shadow:0 8px 28px rgba(0,0,0,0.12)}
.dest-featured-stat-badge strong{display:block;font-size:26px;font-weight:700;color:#e8761a}
.dest-featured-stat-badge span{font-size:11px;color:#888}
.dest-highlights{display:flex;flex-direction:column;gap:16px;margin-top:32px}
.dest-highlight{display:flex;gap:16px;align-items:flex-start;background:#f9f7f4;border-radius:14px;padding:18px 20px}
.dest-highlight-icon{width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#fef3ea,#fde4c5);color:#e8761a;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
.dest-highlight h4{font-size:14px;font-weight:700;color:#1a1a1a;margin-bottom:3px}
.dest-highlight p{font-size:12px;color:#666;line-height:1.55}

/* EXPERIENCES */
.dest-experiences{background:#faf7f2;padding:80px 40px}
.dest-exp-grid{max-width:1300px;margin:48px auto 0;display:grid;grid-template-columns:repeat(3,1fr);gap:28px}
.dest-exp-card{background:#fff;border-radius:20px;overflow:hidden;border:1px solid #f0ebe2;transition:transform 0.3s,box-shadow 0.3s}
.dest-exp-card:hover{transform:translateY(-6px);box-shadow:0 20px 48px rgba(0,0,0,0.08)}
.dest-exp-img{height:220px;overflow:hidden}
.dest-exp-img img{width:100%;height:100%;object-fit:cover;transition:transform 0.5s}
.dest-exp-card:hover .dest-exp-img img{transform:scale(1.06)}
.dest-exp-body{padding:28px}
.dest-exp-type{display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:#e8761a;margin-bottom:10px}
.dest-exp-body h3{font-family:'Playfair Display',serif;font-size:20px;color:#1a1a1a;margin-bottom:10px;line-height:1.3}
.dest-exp-body p{font-size:13px;color:#666;line-height:1.7;margin-bottom:16px}
.dest-exp-footer{display:flex;justify-content:space-between;align-items:center;padding-top:16px;border-top:1px solid #f0f0f0}
.dest-exp-price{font-family:'Space Grotesk',sans-serif;font-size:20px;font-weight:700;color:#e8761a}
.dest-exp-price span{font-size:12px;font-weight:400;color:#888}
.dest-exp-rating{color:#f59e0b;font-size:12px}

/* INTERACTIVE MAP CTA */
.dest-map-cta{background:#1a1a1a;padding:80px 40px;position:relative;overflow:hidden}
.dest-map-cta::before{content:'';position:absolute;right:-100px;top:-100px;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(232,118,26,0.1),transparent 70%)}
.dest-map-inner{max-width:1000px;margin:0 auto;text-align:center;position:relative}
.dest-map-inner h2{font-family:'Playfair Display',serif;font-size:clamp(32px,4vw,52px);color:#fff;margin-bottom:16px}
.dest-map-inner p{font-size:17px;color:rgba(255,255,255,0.65);line-height:1.75;max-width:580px;margin:0 auto 36px}
.dest-map-stats{display:flex;justify-content:center;gap:60px;margin-bottom:40px}
.dest-map-stat strong{display:block;font-family:'Bebas Neue',sans-serif;font-size:48px;color:#e8761a}
.dest-map-stat span{font-size:12px;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:0.8px}

@media(max-width:1000px){
  .dest-hero-content{flex-direction:column;padding:40px 24px}
  .dest-weather-card{min-width:auto;width:100%}
  .dest-grid-4{grid-template-columns:repeat(2,1fr)}
  .dest-grid-3{grid-template-columns:1fr 1fr}
  .dest-featured-inner{grid-template-columns:1fr}
  .dest-exp-grid{grid-template-columns:1fr}
  .dest-map-stats{gap:30px}
}
</style>
@endsection

@section('content')

<!-- CINEMATIC HERO -->
<div class="dest-hero">
  <div class="dest-hero-bg">
    <img src="https://images.unsplash.com/photo-1519112232436-9923c6ba3d26?w=1800&h=1000&fit=crop" alt="Vieux-Québec">
  </div>
  <div class="dest-hero-overlay"></div>
  <div class="dest-hero-content">
    <div>
      <div class="dest-breadcrumb">Amérique du Nord <span class="sep">/</span> Canada <span class="sep">/</span> Québec</div>
      <h1 class="dest-hero-title">Destinations<br><em style="font-style:italic;color:#e8761a">Vedettes</em></h1>
      <p class="dest-hero-desc">Découvrez les joyaux incontournables du Québec, du Canada et de l'Amérique du Nord sublimés par l'expertise GoExploria. Des expériences uniques, des paysages époustouflants, des cultures riches.</p>
      <div class="dest-tag-cloud">
        <span class="dest-tag">Patrimoine UNESCO</span>
        <span class="dest-tag">Nature sauvage</span>
        <span class="dest-tag">Gastronomie locale</span>
        <span class="dest-tag">Aventure plein air</span>
        <span class="dest-tag">Culture vivante</span>
        <span class="dest-tag">Ski de classe mondiale</span>
      </div>
    </div>
    <div class="dest-weather-card">
      <div style="font-size:12px;color:rgba(255,255,255,0.55);margin-bottom:8px"><i class="fas fa-map-marker-alt" style="color:#e8761a"></i> Québec · Maintenant</div>
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

<!-- CARDS SECTION -->
<div class="dest-cards-section">
  <div class="dest-cards-inner">
    <div class="dest-filters">
      <button class="dest-filter-btn active"><i class="fas fa-th-large"></i> Toutes</button>
      <button class="dest-filter-btn"><i class="fas fa-landmark"></i> Patrimoine</button>
      <button class="dest-filter-btn"><i class="fas fa-city"></i> Urbain</button>
      <button class="dest-filter-btn"><i class="fas fa-mountain"></i> Nature</button>
      <button class="dest-filter-btn"><i class="fas fa-person-skiing"></i> Plein air</button>
      <button class="dest-filter-btn"><i class="fas fa-utensils"></i> Gastronomie</button>
      <span class="dest-count">7 destinations</span>
    </div>
    <h2 class="section-title-serif" style="margin-bottom:32px">7 destinations à découvrir</h2>
    <div class="dest-grid-4">
      <div class="dest-card portrait">
        <img src="https://images.unsplash.com/photo-1519112232436-9923c6ba3d26?w=400&h=600&fit=crop" alt="Vieux-Québec">
        <div class="dest-card-overlay"><h3>Vieux-Québec</h3><p><i class="fas fa-map-marker-alt"></i> Québec, Canada</p><div class="rating">★★★★★ Patrimoine UNESCO</div></div>
        <span class="dest-badge hot">HOT</span>
      </div>
      <div class="dest-card portrait">
        <img src="https://images.unsplash.com/photo-1517935706615-2717063c2225?w=400&h=600&fit=crop" alt="Montréal">
        <div class="dest-card-overlay"><h3>Montréal</h3><p><i class="fas fa-map-marker-alt"></i> Québec, Canada</p><div class="rating">★★★★★ Cosmopolite</div></div>
        <span class="dest-badge">TOP</span>
      </div>
      <div class="dest-card portrait">
        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=600&fit=crop" alt="Charlevoix">
        <div class="dest-card-overlay"><h3>Charlevoix</h3><p><i class="fas fa-map-marker-alt"></i> Québec, Canada</p><div class="rating">★★★★★ Nature & Art</div></div>
      </div>
      <div class="dest-card portrait">
        <img src="https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=400&h=600&fit=crop" alt="Gaspésie">
        <div class="dest-card-overlay"><h3>Gaspésie</h3><p><i class="fas fa-map-marker-alt"></i> Québec, Canada</p><div class="rating">★★★★☆ Sauvage & Côtier</div></div>
        <span class="dest-badge new">NEW</span>
      </div>
    </div>
    <div class="dest-grid-3">
      <div class="dest-card landscape">
        <img src="https://images.unsplash.com/photo-1551582045-6ec9c11d8697?w=600&h=400&fit=crop" alt="Laurentides">
        <div class="dest-card-overlay"><h3>Laurentides</h3><p><i class="fas fa-map-marker-alt"></i> Québec, Canada</p><div class="rating">★★★★★ Ski & Randonnée</div></div>
      </div>
      <div class="dest-card landscape">
        <img src="https://images.unsplash.com/photo-1605540436563-5bca919ae766?w=600&h=400&fit=crop" alt="Mont-Tremblant">
        <div class="dest-card-overlay"><h3>Mont-Tremblant</h3><p><i class="fas fa-map-marker-alt"></i> Laurentides, Canada</p><div class="rating">★★★★★ Ski mondial</div></div>
        <span class="dest-badge trend">TRENDING</span>
      </div>
      <div class="dest-card landscape">
        <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=600&h=400&fit=crop" alt="Îles Madeleine">
        <div class="dest-card-overlay"><h3>Îles de la Madeleine</h3><p><i class="fas fa-map-marker-alt"></i> Québec, Canada</p><div class="rating">★★★★★ Archipel unique</div></div>
      </div>
    </div>
  </div>
</div>

<!-- FEATURED DESTINATION -->
<div class="dest-featured">
  <div class="dest-featured-inner">
    <div class="dest-featured-img-wrap">
      <img src="https://images.unsplash.com/photo-1519112232436-9923c6ba3d26?w=800&h=700&fit=crop" alt="Vieux-Québec">
      <div class="dest-featured-stat-badge">
        <strong>★ 4.9</strong>
        <span>Note voyageurs</span>
      </div>
    </div>
    <div>
      <div class="section-label">Destination vedette du mois</div>
      <h2 class="section-title-serif">Vieux-Québec — Patrimoine de l'humanité</h2>
      <p style="font-size:16px;color:#555;line-height:1.85;margin-bottom:8px">Seule ville fortifiée en Amérique du Nord au nord du Mexique, le Vieux-Québec est un joyau historique inscrit au patrimoine mondial de l'UNESCO. Ses ruelles pavées, ses fortifications et son architecture franco-britannique en font une destination unique au monde.</p>
      <div class="dest-highlights">
        <div class="dest-highlight">
          <div class="dest-highlight-icon"><i class="fas fa-landmark"></i></div>
          <div><h4>Château Frontenac</h4><p>L'hôtel le plus photographié au monde, dominant majestueusement le Cap Diamant depuis 1893.</p></div>
        </div>
        <div class="dest-highlight">
          <div class="dest-highlight-icon"><i class="fas fa-snowflake"></i></div>
          <div><h4>Carnaval de Québec</h4><p>Le plus grand carnaval d'hiver au monde, avec défilés, sculptures de glace et activités en plein air.</p></div>
        </div>
        <div class="dest-highlight">
          <div class="dest-highlight-icon"><i class="fas fa-utensils"></i></div>
          <div><h4>Gastronomie du terroir</h4><p>Restaurants réputés, cidres de glace, foie gras québécois et toques étoilées dans un cadre unique.</p></div>
        </div>
      </div>
      <div style="margin-top:28px;display:flex;gap:12px;flex-wrap:wrap">
        <a href="#" class="btn-orange"><i class="fas fa-map-marked-alt"></i> Explorer Québec</a>
        <a href="#" class="btn-outline"><i class="fas fa-calendar"></i> Planifier un séjour</a>
      </div>
    </div>
  </div>
</div>

<!-- EXPERIENCES -->
<div class="dest-experiences">
  <div style="max-width:1300px;margin:0 auto">
    <div class="section-label">Expériences uniques</div>
    <h2 class="section-title-serif">Vivre le Québec autrement</h2>
    <p class="section-desc">Des expériences soigneusement sélectionnées pour vivre le Québec de façon authentique et inoubliable.</p>
  </div>
  <div class="dest-exp-grid">
    <div class="dest-exp-card">
      <div class="dest-exp-img"><img src="https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=640&h=360&fit=crop" alt="Ski"></div>
      <div class="dest-exp-body">
        <div class="dest-exp-type"><i class="fas fa-person-skiing"></i> Plein air · Hiver</div>
        <h3>Ski alpin à Mont-Tremblant</h3>
        <p>94 pistes pour tous niveaux sur le plus grand domaine skiable de l'Est canadien. Ambiance village de montagne incomparable et services haut de gamme.</p>
        <div class="dest-exp-footer">
          <div class="dest-exp-price">89 <span>CAD/jour</span></div>
          <div class="dest-exp-rating">★★★★★ (1 284 avis)</div>
        </div>
      </div>
    </div>
    <div class="dest-exp-card">
      <div class="dest-exp-img"><img src="https://images.unsplash.com/photo-1536935338788-846bb9981813?w=640&h=360&fit=crop" alt="Baleines"></div>
      <div class="dest-exp-body">
        <div class="dest-exp-type"><i class="fas fa-water"></i> Nature · Été</div>
        <h3>Observation des baleines à Tadoussac</h3>
        <p>Le Saint-Laurent accueille 13 espèces de baleines. Une croisière depuis Tadoussac vous approche à quelques mètres des plus grands mammifères marins au monde.</p>
        <div class="dest-exp-footer">
          <div class="dest-exp-price">65 <span>CAD/pers.</span></div>
          <div class="dest-exp-rating">★★★★★ (876 avis)</div>
        </div>
      </div>
    </div>
    <div class="dest-exp-card">
      <div class="dest-exp-img"><img src="https://images.unsplash.com/photo-1547592180-85f173990554?w=640&h=360&fit=crop" alt="Gastronomie"></div>
      <div class="dest-exp-body">
        <div class="dest-exp-type"><i class="fas fa-utensils"></i> Gastronomie · 4 saisons</div>
        <h3>Route des saveurs de Charlevoix</h3>
        <p>Vignobles, fromageries, microbrasseries et tables d'hôte le long du fleuve Saint-Laurent. Une région gastronomique d'exception reconnue mondialement.</p>
        <div class="dest-exp-footer">
          <div class="dest-exp-price">120 <span>CAD/pers.</span></div>
          <div class="dest-exp-rating">★★★★★ (642 avis)</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MAP CTA -->
<div class="dest-map-cta">
  <div class="dest-map-inner">
    <div class="section-label" style="justify-content:center">Explorer nos destinations</div>
    <h2>Votre prochaine aventure vous attend</h2>
    <p>Parcourez notre carte interactive de plus de 47 destinations curatées à travers le Québec, le Canada et l'Amérique du Nord.</p>
    <div class="dest-map-stats">
      <div class="dest-map-stat"><strong>47</strong><span>Destinations</span></div>
      <div class="dest-map-stat"><strong>12</strong><span>Régions</span></div>
      <div class="dest-map-stat"><strong>200+</strong><span>Expériences</span></div>
    </div>
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
      <a href="#" class="btn-orange"><i class="fas fa-map"></i> Voir la carte interactive</a>
      <a href="#" class="btn-outline-white"><i class="fas fa-suitcase"></i> Planifier mon voyage</a>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
document.querySelectorAll('.dest-filter-btn').forEach(btn => {
  btn.addEventListener('click', function(){
    document.querySelectorAll('.dest-filter-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
  });
});
</script>
@endsection