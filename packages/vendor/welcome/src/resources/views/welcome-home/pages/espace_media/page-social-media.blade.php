@extends('welcome-home.layouts.app')

@section('title', 'Réseaux Sociaux 360° — Stratégie & Community Management')
@section('meta_description', 'Gestion complète de vos réseaux sociaux : Instagram, TikTok, LinkedIn, Facebook. Création de contenu, community management, social ads et analytics.')

@section('breadcrumb')
<span class="current">Social Media</span>
@endsection

@section('page-styles')
/* ===================== SOCIAL PAGE ===================== */
#social-page { background: #fff; }

/* HERO */
.social-hero {
  background: linear-gradient(135deg, #ff6b35 0%, #f7931e 40%, #ffd23f 100%);
  padding: 100px 40px 120px;
  clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
  position: relative; overflow: hidden;
}
.social-hero::before {
  content: ''; position: absolute; inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.social-hero-inner { max-width: 1200px; margin: 0 auto; text-align: center; position: relative; z-index: 1; }
.social-hero-tag {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,0.25); backdrop-filter: blur(10px);
  border: 1px solid rgba(255,255,255,0.4); color: #fff;
  font-size: 12px; font-weight: 700; text-transform: uppercase;
  letter-spacing: 1px; padding: 8px 20px; border-radius: 999px; margin-bottom: 28px;
}
.social-hero h1 {
  font-family: 'Outfit', sans-serif;
  font-size: clamp(52px, 7vw, 88px); font-weight: 900;
  color: #fff; line-height: 0.95; margin-bottom: 24px;
  text-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
.social-hero p {
  font-size: 18px; color: rgba(255,255,255,0.9);
  line-height: 1.7; max-width: 600px; margin: 0 auto 40px;
}
.social-platform-pills { display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; margin-bottom: 48px; }
.social-pill {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,0.2); backdrop-filter: blur(8px);
  border: 1px solid rgba(255,255,255,0.4); color: #fff;
  font-size: 13px; font-weight: 700; padding: 10px 20px;
  border-radius: 999px; transition: all 0.2s; cursor: pointer;
}
.social-pill:hover { background: rgba(255,255,255,0.35); transform: translateY(-2px); }
.social-hero-stats { display: flex; justify-content: center; gap: 48px; flex-wrap: wrap; }
.social-hero-stat strong { display: block; font-family: 'Bebas Neue', sans-serif; font-size: 52px; color: #fff; line-height: 1; }
.social-hero-stat span { font-size: 12px; color: rgba(255,255,255,0.8); text-transform: uppercase; letter-spacing: 0.8px; }

/* PLATFORMS GRID */
.social-platforms-section { padding: 80px 40px 60px; max-width: 1300px; margin: 0 auto; }
.social-platforms-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-top: 56px; }
.social-platform-card {
  border-radius: 20px; padding: 28px; position: relative;
  overflow: hidden; cursor: pointer; transition: transform 0.3s;
}
.social-platform-card:hover { transform: translateY(-6px); }
.social-platform-card::after {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
  pointer-events: none;
}
.sp-insta { background: linear-gradient(135deg, #833ab4, #fd1d1d, #fcb045); }
.sp-fb { background: linear-gradient(135deg, #1877f2, #0d5bc1); }
.sp-tt { background: linear-gradient(135deg, #010101, #333); }
.sp-li { background: linear-gradient(135deg, #0077b5, #005182); }
.sp-yt { background: linear-gradient(135deg, #ff0000, #cc0000); }
.sp-pin { background: linear-gradient(135deg, #bd081c, #900614); }
.sp-tw { background: linear-gradient(135deg, #0f141e, #1c2a3f); }
.sp-sn { background: linear-gradient(135deg, #fffc00, #ffd60a); }
.social-platform-icon { font-size: 40px; color: #fff; margin-bottom: 14px; display: block; }
.sp-sn .social-platform-icon { color: #333; }
.social-platform-name { font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 4px; }
.sp-sn .social-platform-name { color: #333; }
.social-platform-followers { font-size: 12px; color: rgba(255,255,255,0.75); margin-bottom: 14px; }
.sp-sn .social-platform-followers { color: rgba(0,0,0,0.5); }
.social-platform-metric {
  display: inline-block; background: rgba(255,255,255,0.2);
  border-radius: 8px; padding: 6px 12px; font-size: 12px;
  font-weight: 700; color: #fff;
}
.sp-sn .social-platform-metric { color: #333; background: rgba(0,0,0,0.12); }
.social-platform-trend {
  position: absolute; top: 16px; right: 16px;
  background: rgba(255,255,255,0.2); border-radius: 8px;
  padding: 4px 10px; font-size: 11px; font-weight: 700; color: #fff;
}
.sp-sn .social-platform-trend { color: #333; background: rgba(0,0,0,0.12); }

/* SERVICES */
.social-services { background: #f8f8f8; padding: 80px 40px; }
.social-services-inner { max-width: 1200px; margin: 0 auto; }
.social-services-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-top: 56px; }
.social-service-item {
  background: #fff; border-radius: 24px; padding: 40px;
  border: 1.5px solid #e5e7eb;
  display: grid; grid-template-columns: auto 1fr; gap: 24px; align-items: start;
  transition: all 0.3s;
}
.social-service-item:hover { box-shadow: 0 20px 50px rgba(0,0,0,0.08); transform: translateY(-2px); border-color: #ff6b35; }
.social-service-icon {
  width: 60px; height: 60px; border-radius: 16px; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  font-size: 24px; color: #fff;
  background: linear-gradient(135deg, #ff6b35, #f7931e);
}
.social-service-item h4 { font-family: 'Outfit', sans-serif; font-size: 19px; font-weight: 700; color: #1a1a1a; margin-bottom: 10px; }
.social-service-item p { font-size: 14px; color: #666; line-height: 1.7; margin-bottom: 16px; }
.social-service-tags { display: flex; flex-wrap: wrap; gap: 6px; }
.social-service-tag { font-size: 11px; font-weight: 700; color: #ff6b35; background: #fff5f0; padding: 4px 10px; border-radius: 6px; }

/* PROCESS */
.social-process { padding: 80px 40px; max-width: 1200px; margin: 0 auto; }
.social-process-timeline { display: grid; grid-template-columns: repeat(5, 1fr); gap: 0; margin-top: 56px; position: relative; }
.social-process-timeline::before {
  content: ''; position: absolute; top: 28px; left: 10%; right: 10%;
  height: 2px; background: linear-gradient(90deg, #ff6b35, #ffd23f);
  z-index: 0;
}
.social-process-step { text-align: center; padding: 0 12px; position: relative; z-index: 1; }
.social-step-circle {
  width: 56px; height: 56px; border-radius: 50%;
  background: linear-gradient(135deg, #ff6b35, #f7931e);
  color: #fff; font-size: 20px;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 16px;
  box-shadow: 0 0 0 5px #fff, 0 0 0 7px #f0ece4;
}
.social-process-step h4 { font-size: 13px; font-weight: 700; color: #1a1a1a; margin-bottom: 6px; }
.social-process-step p { font-size: 11px; color: #888; line-height: 1.5; }

/* CASE STUDIES */
.social-cases { background: #1a1a1a; padding: 80px 40px; }
.social-cases-inner { max-width: 1200px; margin: 0 auto; }
.social-cases-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 56px; }
.social-case-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; overflow: hidden; transition: all 0.3s; }
.social-case-card:hover { border-color: rgba(255,107,53,0.5); transform: translateY(-4px); }
.social-case-img { height: 200px; overflow: hidden; position: relative; }
.social-case-img img { width: 100%; height: 100%; object-fit: cover; }
.social-case-platform {
  position: absolute; top: 12px; right: 12px;
  background: rgba(0,0,0,0.6); color: #fff; font-size: 10px; font-weight: 700;
  padding: 4px 10px; border-radius: 999px;
}
.social-case-body { padding: 28px; }
.social-case-body h4 { font-size: 17px; font-weight: 700; color: #fff; margin-bottom: 8px; }
.social-case-body p { font-size: 13px; color: rgba(255,255,255,0.6); line-height: 1.6; margin-bottom: 20px; }
.social-case-kpis { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
.social-case-kpi { text-align: center; background: rgba(255,255,255,0.04); border-radius: 10px; padding: 12px 8px; }
.social-case-kpi strong { display: block; font-family: 'Bebas Neue', sans-serif; font-size: 28px; color: #ff6b35; line-height: 1; }
.social-case-kpi span { font-size: 10px; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.5px; }

/* CONTENT CALENDAR */
.social-calendar { padding: 80px 40px; max-width: 1200px; margin: 0 auto; }
.social-calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px; margin-top: 48px; }
.social-cal-day { background: #f8f8f8; border-radius: 12px; padding: 12px; min-height: 100px; }
.social-cal-day-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #888; margin-bottom: 10px; }
.social-cal-post { border-radius: 8px; padding: 6px 8px; font-size: 10px; font-weight: 600; color: #fff; margin-bottom: 6px; display: flex; align-items: center; gap: 4px; }
.social-cal-post.insta { background: linear-gradient(135deg, #833ab4, #fcb045); }
.social-cal-post.fb { background: #1877f2; }
.social-cal-post.tt { background: #010101; }
.social-cal-post.li { background: #0077b5; }
.social-cal-post.yt { background: #ff0000; }
.social-cal-day.today { background: #fff5f0; border: 2px solid #ff6b35; }

/* CTA */
.social-cta { background: linear-gradient(135deg, #ff6b35 0%, #f7931e 50%, #ffd23f 100%); padding: 80px 40px; text-align: center; }
.social-cta h2 { font-family: 'Outfit', sans-serif; font-size: clamp(40px, 5vw, 64px); font-weight: 900; color: #fff; margin-bottom: 16px; }
.social-cta p { font-size: 18px; color: rgba(255,255,255,0.9); line-height: 1.7; max-width: 560px; margin: 0 auto 36px; }

@media(max-width:1100px){
  .social-platforms-grid { grid-template-columns: repeat(2, 1fr); }
  .social-services-grid { grid-template-columns: 1fr; }
  .social-process-timeline { grid-template-columns: repeat(3, 1fr); gap: 32px; }
  .social-process-timeline::before { display: none; }
  .social-cases-grid { grid-template-columns: 1fr 1fr; }
  .social-calendar-grid { grid-template-columns: repeat(4, 1fr); }
}
@media(max-width:768px){
  .social-hero { clip-path: none; padding: 80px 20px 60px; }
  .social-platforms-grid { grid-template-columns: repeat(2, 1fr); }
  .social-process-timeline { grid-template-columns: 1fr 1fr; }
  .social-cases-grid { grid-template-columns: 1fr; }
  .social-calendar-grid { grid-template-columns: repeat(3, 1fr); }
}
@endsection

@section('content')
<section id="social-page">

  <!-- HERO -->
  <div class="social-hero">
    <div class="social-hero-inner">
      <div class="social-hero-tag"><i class="fas fa-chart-line"></i> Agence Social Media GoExploria</div>
      <h1>Réseaux Sociaux<br>360°</h1>
      <p>De la stratégie éditoriale au reporting mensuel, nous pilotons votre présence digitale sur tous les réseaux performants. Contenus, community management, campagnes &amp; croissance.</p>
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
      <div class="social-hero-stats">
        <div class="social-hero-stat"><strong>8</strong><span>Plateformes gérées</span></div>
        <div class="social-hero-stat"><strong>756K</strong><span>Abonnés total</span></div>
        <div class="social-hero-stat"><strong>8.1M</strong><span>Vues par mois</span></div>
        <div class="social-hero-stat"><strong>5.4%</strong><span>Engagement moyen</span></div>
      </div>
    </div>
  </div>

  <!-- PLATFORMS GRID -->
  <div class="social-platforms-section">
    <div class="section-label">Nos plateformes gérées</div>
    <h2 class="section-title-sans" style="font-family:'Outfit',sans-serif;font-weight:800">Performance par plateforme</h2>
    <p class="section-desc">Chaque réseau social a ses codes, son audience et ses formats. Nous maîtrisons chacun d'eux.</p>
    <div class="social-platforms-grid">
      <div class="social-platform-card sp-insta">
        <span class="social-platform-trend">+12%</span>
        <span class="social-platform-icon"><i class="fab fa-instagram"></i></span>
        <div class="social-platform-name">Instagram</div>
        <div class="social-platform-followers">128K abonnés · Reels &amp; Stories</div>
        <span class="social-platform-metric">4.8% Engagement</span>
      </div>
      <div class="social-platform-card sp-tt">
        <span class="social-platform-trend">+31%</span>
        <span class="social-platform-icon"><i class="fab fa-tiktok"></i></span>
        <div class="social-platform-name">TikTok</div>
        <div class="social-platform-followers">245K abonnés · Vidéos virales</div>
        <span class="social-platform-metric">8.1M vues/mois</span>
      </div>
      <div class="social-platform-card sp-fb">
        <span class="social-platform-trend">+8%</span>
        <span class="social-platform-icon"><i class="fab fa-facebook-f"></i></span>
        <div class="social-platform-name">Facebook</div>
        <div class="social-platform-followers">89K fans · Groupes &amp; Events</div>
        <span class="social-platform-metric">3.2% Reach organique</span>
      </div>
      <div class="social-platform-card sp-li">
        <span class="social-platform-trend">+18%</span>
        <span class="social-platform-icon"><i class="fab fa-linkedin-in"></i></span>
        <div class="social-platform-name">LinkedIn</div>
        <div class="social-platform-followers">42K abonnés · Articles &amp; Posts</div>
        <span class="social-platform-metric">6.4% B2B reach</span>
      </div>
      <div class="social-platform-card sp-yt">
        <span class="social-platform-trend">+22%</span>
        <span class="social-platform-icon"><i class="fab fa-youtube"></i></span>
        <div class="social-platform-name">YouTube</div>
        <div class="social-platform-followers">67K abonnés · Docs &amp; Guides</div>
        <span class="social-platform-metric">3.2M vues totales</span>
      </div>
      <div class="social-platform-card sp-pin">
        <span class="social-platform-trend">+9%</span>
        <span class="social-platform-icon"><i class="fab fa-pinterest-p"></i></span>
        <div class="social-platform-name">Pinterest</div>
        <div class="social-platform-followers">156K followers · Inspiration</div>
        <span class="social-platform-metric">1.8M impressions</span>
      </div>
      <div class="social-platform-card sp-tw">
        <span class="social-platform-trend">+5%</span>
        <span class="social-platform-icon"><i class="fab fa-twitter"></i></span>
        <div class="social-platform-name">X / Twitter</div>
        <div class="social-platform-followers">31K abonnés · Veille &amp; Actualité</div>
        <span class="social-platform-metric">2.1% Engagement</span>
      </div>
      <div class="social-platform-card sp-sn">
        <span class="social-platform-trend" style="color:#333;background:rgba(0,0,0,0.12)">+14%</span>
        <span class="social-platform-icon"><i class="fab fa-snapchat-ghost"></i></span>
        <div class="social-platform-name">Snapchat</div>
        <div class="social-platform-followers">18K abonnés · Stories éphémères</div>
        <span class="social-platform-metric">72% Vue complète</span>
      </div>
    </div>
  </div>

  <!-- SERVICES -->
  <div class="social-services">
    <div class="social-services-inner">
      <div class="section-label">Nos services</div>
      <h2 class="section-title-sans" style="font-family:'Outfit',sans-serif;font-weight:800">Les 4 piliers de notre approche</h2>
      <p class="section-desc">Une stratégie intégrée pensée pour la croissance à long terme, pas juste pour les vanity metrics.</p>
      <div class="social-services-grid">
        <div class="social-service-item">
          <div class="social-service-icon"><i class="fas fa-pen-nib"></i></div>
          <div>
            <h4>Stratégie &amp; création de contenu</h4>
            <p>Calendrier éditorial mensuel, storytelling de marque percutant, scripts reels viraux, hooks performants et planification multi-plateformes optimisée par l'IA. Chaque contenu est pensé pour votre cible et vos objectifs.</p>
            <div class="social-service-tags">
              <span class="social-service-tag">Calendrier éditorial</span>
              <span class="social-service-tag">Reels &amp; TikToks</span>
              <span class="social-service-tag">Copywriting</span>
              <span class="social-service-tag">Design graphique</span>
            </div>
          </div>
        </div>
        <div class="social-service-item">
          <div class="social-service-icon"><i class="fas fa-comments"></i></div>
          <div>
            <h4>Community management actif</h4>
            <p>Réponses aux commentaires et messages privés, gestion de réputation en temps réel, animation de communauté engagée et protocole de modération pour protéger votre image de marque 7j/7.</p>
            <div class="social-service-tags">
              <span class="social-service-tag">Réponses &lt;2h</span>
              <span class="social-service-tag">Modération</span>
              <span class="social-service-tag">E-réputation</span>
              <span class="social-service-tag">Animation</span>
            </div>
          </div>
        </div>
        <div class="social-service-item">
          <div class="social-service-icon"><i class="fas fa-bullhorn"></i></div>
          <div>
            <h4>Campagnes &amp; Social Ads</h4>
            <p>Création et gestion de campagnes Meta, LinkedIn Ads et TikTok Ads avec ciblage intelligent, tests A/B multivariés, retargeting avancé et optimisation continue du budget pour maximiser votre ROAS.</p>
            <div class="social-service-tags">
              <span class="social-service-tag">Meta Ads</span>
              <span class="social-service-tag">TikTok Ads</span>
              <span class="social-service-tag">LinkedIn Ads</span>
              <span class="social-service-tag">Retargeting</span>
            </div>
          </div>
        </div>
        <div class="social-service-item">
          <div class="social-service-icon"><i class="fas fa-chart-pie"></i></div>
          <div>
            <h4>Analytics &amp; performance continue</h4>
            <p>KPIs hebdomadaires détaillés, dashboards dynamiques en temps réel, recommandations d'optimisation basées sur les données, suivi de conversion et rapports mensuels complets avec insights actionnables.</p>
            <div class="social-service-tags">
              <span class="social-service-tag">Dashboard live</span>
              <span class="social-service-tag">Rapport mensuel</span>
              <span class="social-service-tag">Insights IA</span>
              <span class="social-service-tag">ROI tracking</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- PROCESS -->
  <div class="social-process">
    <div style="text-align:center;max-width:600px;margin:0 auto">
      <div class="section-label" style="justify-content:center">Notre processus</div>
      <h2 class="section-title-sans" style="font-family:'Outfit',sans-serif;font-weight:800;text-align:center">5 étapes vers la croissance</h2>
      <p class="section-desc" style="margin:0 auto;text-align:center">Un processus éprouvé, transparent et orienté résultats pour chaque client.</p>
    </div>
    <div class="social-process-timeline">
      <div class="social-process-step">
        <div class="social-step-circle"><i class="fas fa-search"></i></div>
        <h4>Audit &amp; diagnostic</h4>
        <p>Analyse complète de votre présence actuelle, de vos concurrents et de votre audience.</p>
      </div>
      <div class="social-process-step">
        <div class="social-step-circle"><i class="fas fa-lightbulb"></i></div>
        <h4>Stratégie sur mesure</h4>
        <p>Définition des objectifs, KPIs, tone of voice et calendrier éditorial personnalisé.</p>
      </div>
      <div class="social-process-step">
        <div class="social-step-circle"><i class="fas fa-magic"></i></div>
        <h4>Production &amp; contenu</h4>
        <p>Création de contenus visuels, vidéos, textes et assets pour chaque plateforme.</p>
      </div>
      <div class="social-process-step">
        <div class="social-step-circle"><i class="fas fa-rocket"></i></div>
        <h4>Publication &amp; gestion</h4>
        <p>Planification optimisée, publication automatisée et community management quotidien.</p>
      </div>
      <div class="social-process-step">
        <div class="social-step-circle"><i class="fas fa-chart-bar"></i></div>
        <h4>Analytics &amp; optimisation</h4>
        <p>Reporting mensuel complet et ajustements continus basés sur les performances réelles.</p>
      </div>
    </div>
  </div>

  <!-- CASE STUDIES -->
  <div class="social-cases">
    <div class="social-cases-inner">
      <div class="section-label" style="color:rgba(255,107,53,0.8)">Résultats clients</div>
      <h2 class="section-title-serif" style="color:#fff">Cas client — Résultats concrets</h2>
      <p class="section-desc" style="color:rgba(255,255,255,0.65)">Des chiffres réels, des stratégies personnalisées, des résultats mesurables.</p>
      <div class="social-cases-grid">
        <div class="social-case-card">
          <div class="social-case-img">
            <img src="https://images.unsplash.com/photo-1519112232436-9923c6ba3d26?w=600&h=300&fit=crop" alt="Tourisme Québec">
            <span class="social-case-platform"><i class="fab fa-instagram"></i> Instagram + TikTok</span>
          </div>
          <div class="social-case-body">
            <h4>Hôtel Fairmont — Québec</h4>
            <p>Campagne saisonnière hiver-été avec contenus immersifs et influenceurs locaux. Résultat en 6 mois :</p>
            <div class="social-case-kpis">
              <div class="social-case-kpi"><strong>+284%</strong><span>Abonnés</span></div>
              <div class="social-case-kpi"><strong>9.2%</strong><span>Engagement</span></div>
              <div class="social-case-kpi"><strong>+41%</strong><span>Réservations</span></div>
            </div>
          </div>
        </div>
        <div class="social-case-card">
          <div class="social-case-img">
            <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&h=300&fit=crop" alt="Restaurant">
            <span class="social-case-platform"><i class="fab fa-tiktok"></i> TikTok + Reels</span>
          </div>
          <div class="social-case-body">
            <h4>Groupe Panino — Montréal</h4>
            <p>Stratégie vidéo axée sur les coulisses, recettes en live et challenges. Explosion organique sur TikTok :</p>
            <div class="social-case-kpis">
              <div class="social-case-kpi"><strong>2.4M</strong><span>Vues mois</span></div>
              <div class="social-case-kpi"><strong>+67%</strong><span>Couverts/sem.</span></div>
              <div class="social-case-kpi"><strong>12.1%</strong><span>Engagement</span></div>
            </div>
          </div>
        </div>
        <div class="social-case-card">
          <div class="social-case-img">
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=600&h=300&fit=crop" alt="B2B">
            <span class="social-case-platform"><i class="fab fa-linkedin-in"></i> LinkedIn</span>
          </div>
          <div class="social-case-body">
            <h4>InnovateTech — Québec</h4>
            <p>Positionnement thought leadership sur LinkedIn avec articles, sondages et webinaires. Résultats B2B :</p>
            <div class="social-case-kpis">
              <div class="social-case-kpi"><strong>+312%</strong><span>Impressions</span></div>
              <div class="social-case-kpi"><strong>+89%</strong><span>Leads entrants</span></div>
              <div class="social-case-kpi"><strong>6.4%</strong><span>CTR moyen</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- CONTENT CALENDAR PREVIEW -->
  <div class="social-calendar">
    <div class="section-label">Planification</div>
    <h2 class="section-title-sans" style="font-family:'Outfit',sans-serif;font-weight:800">Votre calendrier éditorial<br>de la semaine</h2>
    <p class="section-desc">Exemple de semaine type pour un client tourisme — contenu planifié sur 5 plateformes.</p>
    <div class="social-calendar-grid">
      <div class="social-cal-day">
        <div class="social-cal-day-label">Lundi</div>
        <div class="social-cal-post insta"><i class="fab fa-instagram"></i> Reel destination</div>
        <div class="social-cal-post li"><i class="fab fa-linkedin-in"></i> Article B2B</div>
      </div>
      <div class="social-cal-day">
        <div class="social-cal-day-label">Mardi</div>
        <div class="social-cal-post tt"><i class="fab fa-tiktok"></i> Vidéo coulisses</div>
        <div class="social-cal-post fb"><i class="fab fa-facebook-f"></i> Promotion offre</div>
      </div>
      <div class="social-cal-day today">
        <div class="social-cal-day-label">Mercredi · Aujourd'hui</div>
        <div class="social-cal-post insta"><i class="fab fa-instagram"></i> Story interactive</div>
        <div class="social-cal-post yt"><i class="fab fa-youtube"></i> Shorts vidéo</div>
        <div class="social-cal-post tt"><i class="fab fa-tiktok"></i> Trend hashtag</div>
      </div>
      <div class="social-cal-day">
        <div class="social-cal-day-label">Jeudi</div>
        <div class="social-cal-post fb"><i class="fab fa-facebook-f"></i> Live questions</div>
        <div class="social-cal-post li"><i class="fab fa-linkedin-in"></i> Sondage</div>
      </div>
      <div class="social-cal-day">
        <div class="social-cal-day-label">Vendredi</div>
        <div class="social-cal-post insta"><i class="fab fa-instagram"></i> Carousel tips</div>
        <div class="social-cal-post tt"><i class="fab fa-tiktok"></i> Weekend vibes</div>
      </div>
      <div class="social-cal-day">
        <div class="social-cal-day-label">Samedi</div>
        <div class="social-cal-post yt"><i class="fab fa-youtube"></i> Documentaire</div>
        <div class="social-cal-post fb"><i class="fab fa-facebook-f"></i> UGC reposts</div>
      </div>
      <div class="social-cal-day">
        <div class="social-cal-day-label">Dimanche</div>
        <div class="social-cal-post insta"><i class="fab fa-instagram"></i> Inspiration</div>
      </div>
    </div>
  </div>

  <!-- CTA -->
  <div class="social-cta">
    <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.8)">Prêt à dominer vos réseaux ?</div>
    <h2>Développez<br>votre audience</h2>
    <p>Rejoignez 200+ marques qui ont confié leurs réseaux sociaux à GoExploria et explosé leur croissance digitale.</p>
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
      <a href="#" style="background:#fff;color:#ff6b35;padding:16px 40px;border-radius:10px;font-weight:700;font-size:16px;text-decoration:none;display:inline-flex;align-items:center;gap:10px;font-family:'Outfit',sans-serif"><i class="fas fa-rocket"></i> Audit gratuit de vos réseaux</a>
      <a href="#" class="btn-outline-white" style="font-size:16px;padding:16px 40px;font-family:'Outfit',sans-serif"><i class="fas fa-calendar"></i> Planifier un appel</a>
    </div>
    <p style="margin-top:20px;font-size:13px;color:rgba(255,255,255,0.7)">Audit complet offert · Réponse sous 24h · Sans engagement</p>
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