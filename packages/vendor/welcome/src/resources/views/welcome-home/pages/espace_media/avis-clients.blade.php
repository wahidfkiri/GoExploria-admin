@extends('welcome-home.layouts.app')

@section('title', 'Avis Clients — 4 823 Témoignages Vérifiés')


@section('page-styles')
<style>
/* HERO */
.avis-hero{background:#1a1a1a;padding:90px 40px;position:relative;overflow:hidden}
.avis-hero::before{content:'';position:absolute;right:-120px;top:-120px;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(232,118,26,0.13),transparent 70%)}
.avis-hero::after{content:'';position:absolute;left:-60px;bottom:-60px;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(232,118,26,0.07),transparent 70%)}
.avis-hero-inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center;position:relative;z-index:1}
.avis-hero-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#e8761a;margin-bottom:16px}
.avis-hero-title{font-family:'Playfair Display',serif;font-size:clamp(36px,4vw,60px);line-height:1.08;color:#000000;margin-bottom:24px}
.avis-hero-desc{font-size:16px;color:rgba(6, 6, 6, 0.65);line-height:1.85;margin-bottom:36px}
.avis-score-big{display:flex;align-items:flex-end;gap:20px}
.avis-score-num{font-family:'Bebas Neue',sans-serif;font-size:100px;color:#e8761a;line-height:1}
.avis-score-stars{display:flex;flex-direction:column;gap:6px;padding-bottom:14px}
.avis-score-stars .stars{color:#e8761a;font-size:22px;letter-spacing:2px}
.avis-score-stars small{color:rgba(255,255,255,0.55);font-size:13px}
.avis-hero-img{border-radius:20px;overflow:hidden;height:420px;position:relative}
.avis-hero-img img{width:100%;height:100%;object-fit:cover}
.avis-hero-img-badge{position:absolute;bottom:24px;left:24px;background:rgba(255,255,255,0.12);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.2);border-radius:12px;padding:14px 20px;color:#fff}
.avis-hero-img-badge strong{display:block;font-size:22px;font-weight:700}
.avis-hero-img-badge span{font-size:12px;color:rgba(255,255,255,0.7)}

/* STATS BAR */
.avis-stats-bar{background:#e8761a;padding:28px 40px}
.avis-stats-bar-inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(5,1fr)}
.avis-stat-item{text-align:center;padding:0 20px;border-right:1px solid rgba(255,255,255,0.25)}
.avis-stat-item:last-child{border-right:none}
.avis-stat-item strong{display:block;font-family:'Bebas Neue',sans-serif;font-size:42px;color:#fff;line-height:1}
.avis-stat-item span{font-size:11px;color:rgba(255,255,255,0.85);text-transform:uppercase;letter-spacing:0.8px;font-weight:600}

/* MAIN */
.avis-main{background:#faf7f2;padding:80px 40px}
.avis-section-header{max-width:1200px;margin:0 auto 48px;display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:20px}
.avis-section-title{font-family:'Playfair Display',serif;font-size:36px;color:#1a1a1a;position:relative;padding-bottom:16px}
.avis-section-title::after{content:'';position:absolute;bottom:0;left:0;width:56px;height:3px;background:#e8761a}
.avis-filter-row{display:flex;gap:8px;flex-wrap:wrap}
.avis-filter-btn{border:1.5px solid #e5e7eb;background:#fff;border-radius:999px;font-size:12px;font-weight:700;color:#666;padding:7px 16px;cursor:pointer;transition:all 0.2s}
.avis-filter-btn:hover,.avis-filter-btn.active{border-color:#e8761a;color:#e8761a;background:#fef3ea}

/* FEATURED GRID */
.avis-grid{max-width:1200px;margin:0 auto 60px;display:grid;grid-template-columns:1.7fr 1fr 1fr;gap:24px}
.avis-card{background:#fff;border-radius:20px;padding:36px;border:1px solid #f0ebe2;position:relative;overflow:hidden;transition:transform 0.3s,box-shadow 0.3s}
.avis-card:hover{transform:translateY(-4px);box-shadow:0 20px 48px rgba(0,0,0,0.08)}
.avis-card.featured::before{content:'"';position:absolute;top:-16px;right:16px;font-family:'Playfair Display',serif;font-size:160px;color:#f5ede2;line-height:1}
.avis-card .stars{color:#f59e0b;font-size:16px;letter-spacing:2px;margin-bottom:18px}
.avis-card .quote{font-family:'Libre Baskerville',serif;font-size:16px;line-height:1.75;color:#2a2a2a;margin-bottom:24px;position:relative;z-index:1}
.avis-card.sm .quote{font-size:14px}
.avis-card .author{display:flex;align-items:center;gap:12px}
.avis-card .author img{width:46px;height:46px;border-radius:50%;object-fit:cover;border:2px solid #f0ebe2}
.avis-card .author-name{font-weight:700;font-size:14px;color:#1a1a1a}
.avis-card .author-role{font-size:12px;color:#888}
.avis-card .badge{display:inline-block;background:#fef3ea;color:#e8761a;font-size:10px;font-weight:700;padding:3px 10px;border-radius:999px;margin-bottom:14px;text-transform:uppercase;letter-spacing:0.5px}

/* VIDEO TESTIMONIALS */
.avis-video-section{background:#fff;padding:80px 40px}
.avis-video-grid{max-width:1200px;margin:40px auto 0;display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.avis-video-card{border-radius:16px;overflow:hidden;position:relative;aspect-ratio:16/9;cursor:pointer}
.avis-video-card img{width:100%;height:100%;object-fit:cover}
.avis-video-card-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.75),rgba(0,0,0,0.15));display:flex;flex-direction:column;justify-content:flex-end;padding:20px}
.avis-video-play{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:52px;height:52px;background:rgba(232,118,26,0.9);border-radius:50%;display:flex;align-items:center;justify-content:center;transition:all 0.2s}
.avis-video-card:hover .avis-video-play{background:#e8761a;transform:translate(-50%,-50%) scale(1.1)}
.avis-video-play i{color:#fff;font-size:18px;margin-left:3px}
.avis-video-card h4{color:#fff;font-size:15px;font-weight:700;margin-bottom:4px}
.avis-video-card span{color:rgba(255,255,255,0.75);font-size:12px}

/* PLATFORM REVIEWS */
.avis-platform-section{background:#faf7f2;padding:80px 40px}
.avis-platform-grid{max-width:1200px;margin:40px auto 0;display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.avis-platform-card{background:#fff;border-radius:20px;padding:32px;border:1px solid #f0ebe2;display:flex;flex-direction:column;gap:18px;transition:transform 0.3s}
.avis-platform-card:hover{transform:translateY(-4px);box-shadow:0 16px 40px rgba(0,0,0,0.07)}
.avis-platform-badge{display:inline-flex;align-items:center;gap:8px;background:#f8f8f8;border-radius:8px;padding:8px 14px;width:fit-content}
.avis-platform-score{font-size:44px;font-weight:700;color:#1a1a1a;font-family:'Space Grotesk',sans-serif;line-height:1}
.avis-platform-score span{font-size:16px;color:#888;font-weight:400}
.avis-platform-stars{color:#f59e0b;font-size:18px;letter-spacing:2px}
.avis-platform-meta{font-size:12px;color:#999;border-top:1px solid #f5f0e8;padding-top:14px}
.g-badge{font-size:22px;font-weight:900;background:linear-gradient(135deg,#4285f4,#ea4335,#fbbc05,#34a853);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}

/* TRUST BADGES */
.avis-trust{background:#1a1a1a;padding:60px 40px}
.avis-trust-inner{max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:40px;flex-wrap:wrap}
.avis-trust-badge{display:flex;align-items:center;gap:16px}
.avis-trust-badge .icon{width:56px;height:56px;border-radius:14px;background:rgba(232,118,26,0.15);display:flex;align-items:center;justify-content:center;font-size:24px;color:#e8761a}
.avis-trust-badge .txt strong{display:block;font-size:18px;color:#fff;font-weight:700}
.avis-trust-badge .txt span{font-size:12px;color:rgba(255,255,255,0.5)}

/* INDUSTRIES */
.avis-industries{background:#fff;padding:80px 40px}
.avis-industries-grid{max-width:1200px;margin:40px auto 0;display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.avis-industry-card{border-radius:16px;border:1.5px solid #f0ebe2;padding:28px;transition:all 0.3s;cursor:pointer}
.avis-industry-card:hover{border-color:#e8761a;background:#fef3ea;transform:translateY(-3px)}
.avis-industry-icon{font-size:32px;margin-bottom:14px}
.avis-industry-card h4{font-size:16px;font-weight:700;color:#1a1a1a;margin-bottom:6px}
.avis-industry-card p{font-size:13px;color:#666;line-height:1.6}
.avis-industry-count{display:inline-block;background:#fef3ea;color:#e8761a;font-size:11px;font-weight:700;padding:3px 10px;border-radius:999px;margin-top:12px}

@media(max-width:900px){
  .avis-hero-inner{grid-template-columns:1fr}
  .avis-hero-img{display:none}
  .avis-grid{grid-template-columns:1fr}
  .avis-video-grid,.avis-platform-grid{grid-template-columns:1fr 1fr}
  .avis-industries-grid{grid-template-columns:repeat(2,1fr)}
  .avis-stats-bar-inner{grid-template-columns:repeat(3,1fr)}
}
</style>
@endsection

@section('content')

<!-- HERO -->
<div class="avis-hero">
  <div class="avis-hero-inner">
    <div>
      <div class="avis-hero-label"><i class="fas fa-comment-dots"></i> Espace Avis Clients — GoExploria</div>
      <h1 class="avis-hero-title">La confiance<br>en chiffres<br><em style="font-style:italic;color:#e8761a">réels</em></h1>
      <p class="avis-hero-desc">Plus de 4 823 témoignages authentiques de voyageurs, familles et entreprises partenaires du monde entier. Notre plateforme de confiance repose sur la transparence totale et la vérification systématique.</p>
      <div class="avis-score-big">
        <span class="avis-score-num">4.9</span>
        <div class="avis-score-stars">
          <span class="stars">★★★★★</span>
          <small>Note globale sur 5.0</small>
          <small>4 823 avis vérifiés · 12 plateformes</small>
        </div>
      </div>
    </div>
    <div class="avis-hero-img">
      <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=700&h=500&fit=crop" alt="Équipe GoExploria">
      <div class="avis-hero-img-badge">
        <strong>98%</strong>
        <span>Taux de recommandation</span>
      </div>
    </div>
  </div>
</div>

<!-- STATS BAR -->
<div class="avis-stats-bar">
  <div class="avis-stats-bar-inner">
    <div class="avis-stat-item"><strong>4 823</strong><span>Avis vérifiés</span></div>
    <div class="avis-stat-item"><strong>98%</strong><span>Recommandations</span></div>
    <div class="avis-stat-item"><strong>12</strong><span>Pays représentés</span></div>
    <div class="avis-stat-item"><strong>6 ans</strong><span>Présence active</span></div>
    <div class="avis-stat-item"><strong>4.9</strong><span>Note Google</span></div>
  </div>
</div>

<!-- AVIS PRINCIPAUX -->
<div class="avis-main">
  <div class="avis-section-header">
    <h2 class="avis-section-title">Témoignages de voyageurs</h2>
    <div class="avis-filter-row">
      <button class="avis-filter-btn active">Tous</button>
      <button class="avis-filter-btn">Voyage</button>
      <button class="avis-filter-btn">Business</button>
      <button class="avis-filter-btn">Famille</button>
      <button class="avis-filter-btn">5 étoiles</button>
    </div>
  </div>
  <div class="avis-grid">
    <div class="avis-card featured">
      <span class="badge">Voyage Premium</span>
      <div class="stars">★★★★★</div>
      <p class="quote">"Une expérience qui a transformé notre façon de voyager. GoExploria nous a proposé un séjour sur-mesure en Charlevoix que nous n'aurions jamais trouvé seuls. L'équipe est réactive, attentionnée, et les suggestions sont toujours justes. On revient chaque année — c'est devenu un rituel familial incontournable !"</p>
      <div class="author">
        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=120&h=120&fit=crop" alt="Julie Tremblay">
        <div>
          <div class="author-name">Julie Tremblay</div>
          <div class="author-role">Voyageuse · Québec, Canada</div>
        </div>
      </div>
    </div>
    <div class="avis-card sm">
      <span class="badge">Partenaire Business</span>
      <div class="stars">★★★★★</div>
      <p class="quote">"La visibilité de notre entreprise a triplé en 6 mois. L'équipe GoExploria comprend les enjeux business et adapte sa stratégie en temps réel. Un partenaire inestimable pour notre croissance internationale."</p>
      <div class="author">
        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120&h=120&fit=crop" alt="Marc Bouchard">
        <div>
          <div class="author-name">Marc Bouchard</div>
          <div class="author-role">Entrepreneur · Montréal</div>
        </div>
      </div>
    </div>
    <div class="avis-card sm">
      <span class="badge">Famille</span>
      <div class="stars">★★★★☆</div>
      <p class="quote">"Interface magnifique, contenu riche et inspirant. La section photos m'a aidée à choisir ma destination en quelques minutes. Je recommande vivement cette plateforme à toutes les familles voyageuses."</p>
      <div class="author">
        <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?w=120&h=120&fit=crop" alt="Sophie Gagnon">
        <div>
          <div class="author-name">Sophie Gagnon</div>
          <div class="author-role">Créatrice · Saguenay</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Row 2 -->
  <div style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:24px">
    <div class="avis-card sm">
      <div class="stars">★★★★★</div>
      <p class="quote">"Notre agence de voyages d'aventure a multiplié ses réservations par 3 grâce aux outils digitaux GoExploria. Le ROI est exceptionnel dès les premiers mois d'utilisation."</p>
      <div class="author">
        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=120&h=120&fit=crop" alt="Thomas Lévesque">
        <div>
          <div class="author-name">Thomas Lévesque</div>
          <div class="author-role">Agence Aventure · Laurentides</div>
        </div>
      </div>
    </div>
    <div class="avis-card sm">
      <div class="stars">★★★★★</div>
      <p class="quote">"Le support client est vraiment exceptionnel. Toujours disponibles, réactifs et compétents. On sent qu'il y a de vraies personnes derrière la plateforme, pas seulement des robots."</p>
      <div class="author">
        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=120&h=120&fit=crop" alt="Éliane Fortier">
        <div>
          <div class="author-name">Éliane Fortier</div>
          <div class="author-role">Hôtelière · Gaspésie</div>
        </div>
      </div>
    </div>
    <div class="avis-card sm">
      <div class="stars">★★★★★</div>
      <p class="quote">"Grâce à la stratégie Social Media de GoExploria, notre restaurant gastronomique a vu ses réservations augmenter de 47% en moins d'un an. Une collaboration précieuse et humaine."</p>
      <div class="author">
        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=120&h=120&fit=crop" alt="Félix Arsenault">
        <div>
          <div class="author-name">Félix Arsenault</div>
          <div class="author-role">Chef restaurateur · Québec</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- VIDEO TESTIMONIALS -->
<div class="avis-video-section">
  <div style="max-width:1200px;margin:0 auto">
    <div class="section-label">Témoignages vidéo</div>
    <h2 class="section-title-serif">Ils racontent leur expérience</h2>
    <p class="section-desc">Des voyageurs, entrepreneurs et familles partagent leur vécu avec GoExploria en toute authenticité.</p>
  </div>
  <div class="avis-video-grid">
    <div class="avis-video-card">
      <img src="https://images.unsplash.com/photo-1527631746610-bca00a040d60?w=640&h=360&fit=crop" alt="">
      <div class="avis-video-card-overlay">
        <h4>"GoExploria a transformé notre agence"</h4>
        <span>Isabelle & Pierre · Voyage en famille · 3:24</span>
      </div>
      <div class="avis-video-play"><i class="fas fa-play"></i></div>
    </div>
    <div class="avis-video-card">
      <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?w=640&h=360&fit=crop" alt="">
      <div class="avis-video-card-overlay">
        <h4>"Notre ROI a dépassé toutes nos attentes"</h4>
        <span>Marc Bouchard · Entrepreneur · 2:48</span>
      </div>
      <div class="avis-video-play"><i class="fas fa-play"></i></div>
    </div>
    <div class="avis-video-card">
      <img src="https://images.unsplash.com/photo-1539635278303-d4002c07eae3?w=640&h=360&fit=crop" alt="">
      <div class="avis-video-card-overlay">
        <h4>"La plateforme idéale pour les aventuriers"</h4>
        <span>Thomas L. · Agence Aventure · 4:12</span>
      </div>
      <div class="avis-video-play"><i class="fas fa-play"></i></div>
    </div>
  </div>
</div>

<!-- PLATFORM REVIEWS -->
<div class="avis-platform-section">
  <div style="max-width:1200px;margin:0 auto">
    <div class="section-label">Avis plateformes</div>
    <h2 class="section-title-serif">Notre réputation sur toutes les plateformes</h2>
  </div>
  <div class="avis-platform-grid">
    <div class="avis-platform-card">
      <div class="avis-platform-badge"><span class="g-badge">G</span><span style="font-size:12px;color:#888">Google</span></div>
      <div class="avis-platform-score">4.9 <span>/ 5</span></div>
      <div class="avis-platform-stars">★★★★★</div>
      <p style="font-size:14px;color:#444;line-height:1.7">"Excellent suivi client, collaboration fluide. Notre équipe utilise GoExploria quotidiennement pour coordonner nos activités touristiques avec une efficacité remarquable."</p>
      <div class="avis-platform-meta"><span>Goexploria Business — Montréal</span> · <span>Il y a 2 jours</span> · <strong>1 842 avis Google</strong></div>
    </div>
    <div class="avis-platform-card">
      <div class="avis-platform-badge"><i class="fab fa-facebook-f" style="color:#1877f2;font-size:18px"></i><span style="font-size:12px;color:#888">Facebook</span></div>
      <div class="avis-platform-score">5.0 <span>/ 5</span></div>
      <div class="avis-platform-stars">★★★★★</div>
      <p style="font-size:14px;color:#444;line-height:1.7">"Le tableau de suivi partagé et les retours en temps réel ont transformé la gestion de nos campagnes. Outil indispensable pour notre agence de voyages d'affaires."</p>
      <div class="avis-platform-meta"><span>Atelier Nomade — Québec</span> · <span>Il y a 1 semaine</span> · <strong>927 avis Facebook</strong></div>
    </div>
    <div class="avis-platform-card">
      <div class="avis-platform-badge"><i class="fab fa-tripadvisor" style="color:#34e0a1;font-size:18px"></i><span style="font-size:12px;color:#888">TripAdvisor</span></div>
      <div class="avis-platform-score">4.8 <span>/ 5</span></div>
      <div class="avis-platform-stars">★★★★☆</div>
      <p style="font-size:14px;color:#444;line-height:1.7">"Communication claire, livraison rapide, et une vraie valeur ajoutée sur notre visibilité digitale. Studio Horizon a augmenté son chiffre d'affaires de 32% en un an."</p>
      <div class="avis-platform-meta"><span>Studio Horizon — Lyon</span> · <span>Il y a 3 semaines</span> · <strong>612 avis TripAdvisor</strong></div>
    </div>
  </div>
</div>

<!-- TRUST BADGES -->
<div class="avis-trust">
  <div class="avis-trust-inner">
    <div class="avis-trust-badge">
      <div class="icon"><i class="fas fa-shield-alt"></i></div>
      <div class="txt"><strong>Avis 100% vérifiés</strong><span>Clients authentifiés par email + achat</span></div>
    </div>
    <div class="avis-trust-badge">
      <div class="icon"><i class="fas fa-lock"></i></div>
      <div class="txt"><strong>Zéro faux avis</strong><span>Politique stricte d'authenticité</span></div>
    </div>
    <div class="avis-trust-badge">
      <div class="icon"><i class="fas fa-globe"></i></div>
      <div class="txt"><strong>12 pays représentés</strong><span>Communauté internationale active</span></div>
    </div>
    <div class="avis-trust-badge">
      <div class="icon"><i class="fas fa-sync-alt"></i></div>
      <div class="txt"><strong>Mis à jour en temps réel</strong><span>Nouveaux avis chaque jour</span></div>
    </div>
  </div>
</div>

<!-- INDUSTRIES -->
<div class="avis-industries">
  <div style="max-width:1200px;margin:0 auto">
    <div class="section-label">Par secteur</div>
    <h2 class="section-title-serif">Qui nous fait confiance</h2>
    <p class="section-desc">Des professionnels de tous secteurs liés au tourisme et au business international partagent leur expérience GoExploria.</p>
  </div>
  <div class="avis-industries-grid">
    <div class="avis-industry-card">
      <div class="avis-industry-icon">🏨</div>
      <h4>Hôtellerie & Hébergement</h4>
      <p>Chalets, hôtels, auberges et gîtes qui optimisent leur présence digitale et leurs réservations.</p>
      <span class="avis-industry-count">1 240 avis</span>
    </div>
    <div class="avis-industry-card">
      <div class="avis-industry-icon">✈️</div>
      <h4>Agences de voyages</h4>
      <p>Agences réceptives, DMC et tour-opérateurs qui gèrent leur visibilité et pipeline commercial.</p>
      <span class="avis-industry-count">876 avis</span>
    </div>
    <div class="avis-industry-card">
      <div class="avis-industry-icon">🍽️</div>
      <h4>Gastronomie & Restauration</h4>
      <p>Chefs, restaurants gastronomiques et food trucks qui développent leur audience locale et touristique.</p>
      <span class="avis-industry-count">654 avis</span>
    </div>
    <div class="avis-industry-card">
      <div class="avis-industry-icon">🏄</div>
      <h4>Activités & Aventure</h4>
      <p>Prestataires d'activités outdoor, sports d'hiver et expériences culturelles uniques.</p>
      <span class="avis-industry-count">543 avis</span>
    </div>
  </div>
</div>

<!-- CTA -->
<div class="cta-band">
  <h2>Rejoignez 4 823 professionnels qui nous font confiance</h2>
  <p>Démarrez votre essai gratuit de 14 jours et découvrez comment GoExploria peut transformer votre présence digitale et multiplier vos réservations.</p>
  <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
    <a href="#" class="btn-orange" style="background:#fff;color:#e8761a"><i class="fas fa-rocket"></i> Essai gratuit 14 jours</a>
    <a href="#" class="btn-outline-white"><i class="fas fa-calendar"></i> Prendre rendez-vous</a>
  </div>
</div>

@endsection

@section('scripts')
<script>
document.querySelectorAll('.avis-filter-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.avis-filter-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
  });
});
</script>
@endsection