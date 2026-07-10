@extends('welcome-home.layouts.app')

@section('title', 'Business & Tourisme — Solutions Web Professionnelles')


@section('page-styles')
<style>
/* HERO */
.bt-hero{background:#0d1b35;min-height:620px;position:relative;overflow:hidden;display:flex;align-items:center}
.bt-hero-bg{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1600&h=800&fit=crop')center/cover;opacity:0.1}
.bt-hero-geo{position:absolute;right:0;top:0;bottom:0;width:42%;clip-path:polygon(18% 0,100% 0,100% 100%,0% 100%);background:linear-gradient(135deg,#e8761a,#f5a623)}
.bt-hero-content{position:relative;z-index:2;padding:100px 80px;max-width:700px}
.bt-hero-eyebrow{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#e8761a;margin-bottom:20px;display:flex;align-items:center;gap:10px}
.bt-hero-eyebrow::before{content:'';width:32px;height:2px;background:#e8761a}
.bt-hero-title{font-family:'Bebas Neue',sans-serif;font-size:clamp(64px,8vw,104px);color:#000000;line-height:0.92;margin-bottom:28px;letter-spacing:1px}
.bt-hero-title em{color:#e8761a;font-style:normal}
.bt-hero-desc{font-size:16px;color:rgba(0, 0, 0, 0.72);line-height:1.85;margin-bottom:44px;max-width:520px}

/* INTRO */
.bt-intro{background:#fff;padding:80px 40px}
.bt-intro-inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.bt-intro-img{border-radius:20px;overflow:hidden;height:460px;position:relative}
.bt-intro-img img{width:100%;height:100%;object-fit:cover}
.bt-intro-img-stat{position:absolute;bottom:24px;right:24px;background:rgba(255,255,255,0.95);border-radius:14px;padding:18px 22px;box-shadow:0 8px 32px rgba(0,0,0,0.12)}
.bt-intro-img-stat strong{display:block;font-family:'Bebas Neue',sans-serif;font-size:42px;color:#e8761a;line-height:1}
.bt-intro-img-stat span{font-size:12px;color:#888}
.bt-points{display:flex;flex-direction:column;gap:20px;margin-top:32px}
.bt-point{display:flex;gap:16px;align-items:flex-start}
.bt-point-icon{width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#fef3ea,#fde4c5);display:flex;align-items:center;justify-content:center;color:#e8761a;font-size:18px;flex-shrink:0}
.bt-point h4{font-size:15px;font-weight:700;color:#1a1a1a;margin-bottom:4px}
.bt-point p{font-size:13px;color:#666;line-height:1.65}

/* DUAL SERVICES */
.bt-services{background:#f8f9fb;padding:80px 40px}
.bt-services-inner{max-width:1280px;margin:0 auto}
.bt-dual-grid{display:grid;grid-template-columns:1fr 1fr;gap:32px;margin-top:48px}
.bt-service-card{border-radius:24px;overflow:hidden;border:1px solid #eee;background:#fff;transition:transform 0.3s,box-shadow 0.3s}
.bt-service-card:hover{transform:translateY(-6px);box-shadow:0 24px 60px rgba(0,0,0,0.1)}
.bt-service-card-header{padding:36px 40px;background:#f8f9fb;border-bottom:1px solid #eee;display:flex;align-items:center;gap:20px}
.bt-card-icon{width:64px;height:64px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:26px;flex-shrink:0}
.bt-card-icon.orange{background:linear-gradient(135deg,#fef3ea,#fde4c5);color:#e8761a}
.bt-card-icon.blue{background:linear-gradient(135deg,#eff6ff,#dbeafe);color:#2563eb}
.bt-service-card-title{font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:700;color:#1a1a1a}
.bt-service-card-sub{font-size:13px;color:#888;margin-top:4px}
.bt-service-card-body{padding:40px}
.bt-service-img{width:100%;height:230px;object-fit:cover;border-radius:14px;margin-bottom:28px}
.bt-feature-list{list-style:none;display:flex;flex-direction:column;gap:12px;margin-bottom:28px}
.bt-feature-list li{display:flex;align-items:flex-start;gap:12px;font-size:14px;color:#444;line-height:1.6}
.bt-feature-list li i{color:#10b981;font-size:16px;flex-shrink:0;margin-top:2px}

/* STATS */
.bt-stats{background:#0d1b35;padding:0;margin:0}
.bt-stats-grid{max-width:1280px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr)}
.bt-stat-box{padding:50px 30px;text-align:center;border-right:1px solid rgba(255,255,255,0.08)}
.bt-stat-box:last-child{border-right:none}
.bt-stat-box strong{display:block;font-family:'Bebas Neue',sans-serif;font-size:60px;color:#e8761a;line-height:1}
.bt-stat-box span{font-size:13px;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:0.8px;margin-top:6px;display:block}

/* PROCESS */
.bt-process{background:#fff;padding:80px 40px}
.bt-process-inner{max-width:1200px;margin:0 auto}
.bt-process-steps{display:grid;grid-template-columns:repeat(4,1fr);gap:0;margin-top:56px;position:relative}
.bt-process-steps::before{content:'';position:absolute;top:32px;left:10%;right:10%;height:2px;background:linear-gradient(90deg,#e8761a,#f5a623)}
.bt-step{text-align:center;padding:0 20px}
.bt-step-num{width:64px;height:64px;border-radius:50%;background:#e8761a;color:#fff;font-family:'Bebas Neue',sans-serif;font-size:28px;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;position:relative;z-index:1;border:4px solid #fff;box-shadow:0 4px 20px rgba(232,118,26,0.3)}
.bt-step h4{font-size:16px;font-weight:700;color:#1a1a1a;margin-bottom:10px}
.bt-step p{font-size:13px;color:#666;line-height:1.65}

/* PACKAGES */
.bt-packages{background:#faf7f2;padding:80px 40px}
.bt-packages-grid{max-width:1200px;margin:48px auto 0;display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.bt-package-card{background:#fff;border-radius:20px;padding:36px;border:1.5px solid #f0ebe2;transition:all 0.3s;position:relative;overflow:hidden}
.bt-package-card:hover{border-color:#e8761a;transform:translateY(-4px);box-shadow:0 20px 50px rgba(232,118,26,0.12)}
.bt-package-card.featured{border-color:#e8761a;background:linear-gradient(135deg,#fffbf7,#fff)}
.bt-package-badge{position:absolute;top:0;right:0;background:#e8761a;color:#fff;font-size:11px;font-weight:700;padding:6px 16px;border-radius:0 20px 0 12px;text-transform:uppercase;letter-spacing:0.5px}
.bt-package-icon{width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,#fef3ea,#fde4c5);color:#e8761a;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:20px}
.bt-package-name{font-family:'Space Grotesk',sans-serif;font-size:20px;font-weight:700;color:#1a1a1a;margin-bottom:8px}
.bt-package-price{font-family:'Bebas Neue',sans-serif;font-size:48px;color:#e8761a;line-height:1;margin-bottom:4px}
.bt-package-price span{font-size:16px;font-weight:400;color:#888;font-family:'DM Sans',sans-serif}
.bt-package-desc{font-size:13px;color:#666;line-height:1.65;margin-bottom:24px;border-top:1px solid #f0ebe2;padding-top:20px}
.bt-package-features{list-style:none;display:flex;flex-direction:column;gap:10px;margin-bottom:28px}
.bt-package-features li{font-size:13px;color:#444;display:flex;gap:8px;align-items:flex-start}
.bt-package-features li i{color:#10b981;font-size:14px;flex-shrink:0;margin-top:2px}

@media(max-width:1000px){
  .bt-dual-grid,.bt-intro-inner{grid-template-columns:1fr}
  .bt-stats-grid{grid-template-columns:repeat(2,1fr)}
  .bt-process-steps{grid-template-columns:repeat(2,1fr)}
  .bt-process-steps::before{display:none}
  .bt-packages-grid{grid-template-columns:1fr}
}
</style>
@endsection

@section('content')

<!-- HERO -->
<div class="bt-hero">
  <div class="bt-hero-bg"></div>
  <div class="bt-hero-geo"></div>
  <div class="bt-hero-content">
    <div class="bt-hero-eyebrow">Solutions Business & Tourisme Québec</div>
    <h1 class="bt-hero-title">NEXT<br><em>LEVEL</em><br>BUSINESS</h1>
    <p class="bt-hero-desc">Stratégies sur mesure pour propulser votre entreprise sur les marchés internationaux. Nous combinons expertise commerciale et expériences touristiques exclusives pour les professionnels les plus exigeants.</p>
    <div style="display:flex;gap:16px;flex-wrap:wrap">
      <a href="#" class="btn-orange"><i class="fas fa-rocket"></i> Découvrir nos solutions</a>
      <a href="#" class="btn-outline-white"><i class="fas fa-play"></i> Voir la démo</a>
    </div>
  </div>
</div>

<!-- STATS -->
<div class="bt-stats">
  <div class="bt-stats-grid">
    <div class="bt-stat-box"><strong>250+</strong><span>Projets réalisés</span></div>
    <div class="bt-stat-box"><strong>40</strong><span>Pays couverts</span></div>
    <div class="bt-stat-box"><strong>98%</strong><span>Satisfaction client</span></div>
    <div class="bt-stat-box"><strong>15+</strong><span>Années d'expérience</span></div>
  </div>
</div>

<!-- INTRO -->
<div class="bt-intro">
  <div class="bt-intro-inner">
    <div class="bt-intro-img">
      <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=700&h=600&fit=crop" alt="Équipe GoExploria Business">
      <div class="bt-intro-img-stat">
        <strong>+32%</strong>
        <span>Croissance moyenne clients</span>
      </div>
    </div>
    <div>
      <div class="section-label">Notre approche</div>
      <h2 class="section-title-serif">Une expertise au service de votre croissance internationale</h2>
      <p style="font-size:16px;color:#555;line-height:1.85;margin-bottom:8px">GoExploria accompagne les entreprises et les acteurs du tourisme dans leur transformation digitale et leur expansion internationale depuis plus de 15 ans.</p>
      <div class="bt-points">
        <div class="bt-point">
          <div class="bt-point-icon"><i class="fas fa-chart-line"></i></div>
          <div><h4>Croissance mesurée</h4><p>Chaque stratégie est pilotée par la donnée, avec des KPIs clairs et un reporting hebdomadaire transparent.</p></div>
        </div>
        <div class="bt-point">
          <div class="bt-point-icon"><i class="fas fa-globe"></i></div>
          <div><h4>Portée internationale</h4><p>Un réseau de 40 pays et des partenaires locaux qualifiés pour ouvrir votre marché à l'international.</p></div>
        </div>
        <div class="bt-point">
          <div class="bt-point-icon"><i class="fas fa-handshake"></i></div>
          <div><h4>Accompagnement humain</h4><p>Un chef de projet dédié, disponible, qui comprend votre secteur et vos objectifs spécifiques.</p></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- DUAL SERVICES -->
<div class="bt-services">
  <div class="bt-services-inner">
    <div class="section-label">Deux expertises complémentaires</div>
    <h2 class="section-title-serif">Nos solutions phares</h2>
    <div class="bt-dual-grid">
      <!-- Business -->
      <div class="bt-service-card">
        <div class="bt-service-card-header">
          <div class="bt-card-icon orange"><i class="fas fa-briefcase"></i></div>
          <div>
            <div class="bt-service-card-title">Solutions Web Business</div>
            <div class="bt-service-card-sub">Expertise commerciale internationale</div>
          </div>
        </div>
        <div class="bt-service-card-body">
          <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=700&h=400&fit=crop" alt="Business" class="bt-service-img">
          <p style="font-size:14px;color:#555;line-height:1.85;margin-bottom:24px">Nous accompagnons les entreprises dans leur développement international avec des stratégies éprouvées, des outils digitaux innovants et un réseau de partenaires dans 40 pays.</p>
          <ul class="bt-feature-list">
            <li><i class="fas fa-check-circle"></i> Consultation stratégique et analyse de marché approfondie</li>
            <li><i class="fas fa-check-circle"></i> Développement de partenariats internationaux qualifiés</li>
            <li><i class="fas fa-check-circle"></i> Optimisation des processus opérationnels et workflows</li>
            <li><i class="fas fa-check-circle"></i> Solutions digitales : CRM, automatisation, IA intégrée</li>
            <li><i class="fas fa-check-circle"></i> Formation et coaching des équipes commerciales</li>
            <li><i class="fas fa-check-circle"></i> Tableaux de bord et reporting en temps réel</li>
          </ul>
          <a href="#" class="btn-orange">Découvrir <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
      <!-- Tourisme -->
      <div class="bt-service-card">
        <div class="bt-service-card-header">
          <div class="bt-card-icon blue"><i class="fas fa-plane"></i></div>
          <div>
            <div class="bt-service-card-title">Solutions Web Tourisme</div>
            <div class="bt-service-card-sub">Expériences exclusives pour professionnels</div>
          </div>
        </div>
        <div class="bt-service-card-body">
          <img src="https://images.unsplash.com/photo-1503220317375-aaad61436b1b?w=700&h=400&fit=crop" alt="Tourisme" class="bt-service-img">
          <p style="font-size:14px;color:#555;line-height:1.85;margin-bottom:24px">Voyages d'affaires sur mesure, retraites d'entreprise en destinations exclusives et circuits découverte pour renforcer la cohésion de vos équipes et fidéliser vos partenaires.</p>
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
  </div>
</div>

<!-- PROCESS -->
<div class="bt-process">
  <div class="bt-process-inner">
    <div class="section-label">Notre méthode</div>
    <h2 class="section-title-serif">Comment nous travaillons</h2>
    <p class="section-desc">Un processus rodé en 4 étapes pour garantir des résultats mesurables et durables pour votre entreprise.</p>
    <div class="bt-process-steps">
      <div class="bt-step">
        <div class="bt-step-num">01</div>
        <h4>Audit & Diagnostic</h4>
        <p>Analyse approfondie de votre situation actuelle, vos marchés cibles et vos concurrents pour identifier les opportunités prioritaires.</p>
      </div>
      <div class="bt-step">
        <div class="bt-step-num">02</div>
        <h4>Stratégie sur mesure</h4>
        <p>Élaboration d'un plan d'action personnalisé avec objectifs SMART, budget optimisé et calendrier réaliste.</p>
      </div>
      <div class="bt-step">
        <div class="bt-step-num">03</div>
        <h4>Exécution & Pilotage</h4>
        <p>Déploiement des actions avec notre équipe dédiée, suivi en temps réel et ajustements continus selon les résultats.</p>
      </div>
      <div class="bt-step">
        <div class="bt-step-num">04</div>
        <h4>Mesure & Optimisation</h4>
        <p>Reporting mensuel complet, analyse des KPIs et recommandations pour maximiser le ROI sur le long terme.</p>
      </div>
    </div>
  </div>
</div>

<!-- PACKAGES -->
<div class="bt-packages" style="display:none;">
  <div style="max-width:1200px;margin:0 auto">
    <div class="section-label">Nos offres</div>
    <h2 class="section-title-serif">Choisissez votre plan</h2>
  </div>
  <div class="bt-packages-grid">
    <div class="bt-package-card">
      <div class="bt-package-icon"><i class="fas fa-seedling"></i></div>
      <div class="bt-package-name">Starter</div>
      <div class="bt-package-price">997 <span>CAD/mois</span></div>
      <p class="bt-package-desc">Idéal pour les PME et startups qui veulent établir leur présence digitale et obtenir leurs premiers résultats.</p>
      <ul class="bt-package-features">
        <li><i class="fas fa-check-circle"></i> Site web professionnel responsive</li>
        <li><i class="fas fa-check-circle"></i> SEO local + Google My Business</li>
        <li><i class="fas fa-check-circle"></i> 2 réseaux sociaux gérés</li>
        <li><i class="fas fa-check-circle"></i> 1 campagne mail/mois</li>
        <li><i class="fas fa-check-circle"></i> Rapport mensuel</li>
      </ul>
      <a href="#" class="btn-outline" style="width:100%;justify-content:center">Démarrer</a>
    </div>
    <div class="bt-package-card featured">
      <span class="bt-package-badge">Plus populaire</span>
      <div class="bt-package-icon"><i class="fas fa-rocket"></i></div>
      <div class="bt-package-name">Business Pro</div>
      <div class="bt-package-price">2 497 <span>CAD/mois</span></div>
      <p class="bt-package-desc">La solution complète pour les entreprises ambitieuses qui veulent dominer leur marché local et s'ouvrir à l'international.</p>
      <ul class="bt-package-features">
        <li><i class="fas fa-check-circle"></i> Tout Starter, plus :</li>
        <li><i class="fas fa-check-circle"></i> 5 réseaux sociaux + TikTok</li>
        <li><i class="fas fa-check-circle"></i> Campagnes Ads (Meta + Google)</li>
        <li><i class="fas fa-check-circle"></i> Mail automation avancé</li>
        <li><i class="fas fa-check-circle"></i> Chat unifié multiplateforme</li>
        <li><i class="fas fa-check-circle"></i> Account manager dédié</li>
      </ul>
      <a href="#" class="btn-orange" style="width:100%;justify-content:center">Choisir ce plan</a>
    </div>
    <div class="bt-package-card">
      <div class="bt-package-icon"><i class="fas fa-crown"></i></div>
      <div class="bt-package-name">Enterprise</div>
      <div class="bt-package-price">Sur devis</div>
      <p class="bt-package-desc">Solution sur mesure pour les grandes entreprises et chaînes hôtelières avec des besoins complexes et multi-marchés.</p>
      <ul class="bt-package-features">
        <li><i class="fas fa-check-circle"></i> Tout Business Pro, plus :</li>
        <li><i class="fas fa-check-circle"></i> Stratégie internationale complète</li>
        <li><i class="fas fa-check-circle"></i> Multilingue jusqu'à 25 langues</li>
        <li><i class="fas fa-check-circle"></i> Équipe dédiée on-site/remote</li>
        <li><i class="fas fa-check-circle"></i> Intégration CRM & ERP</li>
        <li><i class="fas fa-check-circle"></i> SLA 99.9% garanti</li>
      </ul>
      <a href="#" class="btn-outline" style="width:100%;justify-content:center">Nous contacter</a>
    </div>
  </div>
</div>

<!-- CTA -->
<div class="cta-band">
  <h2>Prêt à propulser votre business au prochain niveau ?</h2>
  <p>Réservez une consultation stratégique gratuite de 45 minutes avec l'un de nos experts. Sans engagement, sans pression.</p>
  <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
    <a href="#" class="btn-orange" style="background:#fff;color:#e8761a"><i class="fas fa-calendar-check"></i> Consultation gratuite</a>
    <a href="#" class="btn-outline-white"><i class="fas fa-phone"></i> Nous appeler</a>
  </div>
</div>

@endsection