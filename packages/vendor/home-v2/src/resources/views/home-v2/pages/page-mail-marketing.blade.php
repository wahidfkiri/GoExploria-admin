@extends('home-v2.layouts.app')

@section('title', 'Mail Marketing Pro — Campagnes qui convertissent')
@section('meta_description', 'Créez des campagnes email qui convertissent. Segmentation intelligente, automation, analytics temps réel. Tourisme, e-commerce et B2B.')

@section('breadcrumb')
<span class="current">Mail Marketing</span>
@endsection

@section('page-styles')
/* ===================== MAIL PAGE ===================== */
#mail-page { background: #fffdf9; }

/* HERO */
.mail-hero { background: #f5f0e8; border-bottom: 3px solid #1a1a1a; padding: 80px 40px 0; }
.mail-hero-inner { max-width: 1300px; margin: 0 auto; }
.mail-hero-tag {
  display: inline-flex; align-items: center; gap: 8px;
  font-size: 11px; font-weight: 700; text-transform: uppercase;
  letter-spacing: 2px; color: #e8761a; margin-bottom: 20px;
  background: rgba(232,118,26,0.1); padding: 6px 16px; border-radius: 999px;
}
.mail-hero-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; padding-bottom: 0; }
.mail-hero-h {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(72px, 9vw, 120px); color: #1a1a1a; line-height: 0.88;
  margin-bottom: 24px; letter-spacing: 1px;
}
.mail-hero-h em { color: #e8761a; font-style: normal; }
.mail-hero-sub { font-size: 17px; color: #555; line-height: 1.8; margin-bottom: 36px; max-width: 480px; }
.mail-hero-btns { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 40px; }
.mail-hero-proof {
  display: flex; align-items: center; gap: 16px; font-size: 13px; color: #888;
}
.mail-hero-proof-avatars { display: flex; }
.mail-hero-proof-avatars img { width: 32px; height: 32px; border-radius: 50%; border: 2px solid #f5f0e8; margin-right: -8px; object-fit: cover; }
.mail-metrics-panel {
  background: #1a1a1a; border-radius: 20px 20px 0 0; padding: 36px;
  color: #fff; align-self: start;
}
.mail-metrics-panel h3 { color: #fff; font-size: 14px; font-weight: 700; margin-bottom: 28px; text-transform: uppercase; letter-spacing: 0.8px; }
.mail-metric-row {
  display: flex; justify-content: space-between; align-items: center;
  padding: 14px 0; border-bottom: 1px solid rgba(255,255,255,0.07);
}
.mail-metric-row:last-child { border-bottom: none; }
.mail-metric-label { font-size: 13px; color: rgba(255,255,255,0.55); width: 120px; flex-shrink: 0; }
.mail-metric-bar-wrap {
  flex: 1; margin: 0 16px; height: 5px;
  background: rgba(255,255,255,0.08); border-radius: 999px; overflow: hidden;
}
.mail-metric-bar { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #e8761a, #f5a623); transition: width 1s ease; }
.mail-metric-bar.red { background: linear-gradient(90deg, #ef4444, #f87171); }
.mail-metric-value { font-weight: 700; font-size: 15px; color: #fff; min-width: 48px; text-align: right; }

/* STATS BAND */
.mail-stats-band { background: #1a1a1a; padding: 0 40px; }
.mail-stats-band-inner { max-width: 1300px; margin: 0 auto; display: grid; grid-template-columns: repeat(5, 1fr); }
.mail-stat-cell { padding: 32px 20px; text-align: center; border-right: 1px solid rgba(255,255,255,0.07); }
.mail-stat-cell:last-child { border-right: none; }
.mail-stat-cell strong { display: block; font-family: 'Bebas Neue', sans-serif; font-size: 52px; color: #e8761a; line-height: 1; }
.mail-stat-cell span { font-size: 11px; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.8px; margin-top: 4px; display: block; }

/* CAMPAIGN TYPES */
.mail-campaigns-section { padding: 80px 40px; max-width: 1300px; margin: 0 auto; }
.mail-campaigns-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; margin-top: 56px; }
.mail-campaign-card { border: 1.5px solid #e5e7eb; border-radius: 24px; overflow: hidden; background: #fff; transition: all 0.3s; }
.mail-campaign-card:hover { transform: translateY(-4px); box-shadow: 0 20px 50px rgba(0,0,0,0.08); border-color: #e8761a; }
.mail-campaign-img { height: 240px; overflow: hidden; position: relative; }
.mail-campaign-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
.mail-campaign-card:hover .mail-campaign-img img { transform: scale(1.05); }
.mail-campaign-tag-overlay { position: absolute; top: 16px; left: 16px; }
.mail-campaign-body { padding: 32px; }
.mail-campaign-type {
  display: inline-flex; align-items: center; gap: 6px; font-size: 11px;
  font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;
  color: #e8761a; margin-bottom: 14px;
}
.mail-campaign-body h3 { font-family: 'Playfair Display', serif; font-size: 22px; line-height: 1.3; color: #1a1a1a; margin-bottom: 12px; }
.mail-campaign-body p { font-size: 14px; color: #666; line-height: 1.7; margin-bottom: 20px; }
.mail-features-list { list-style: none; display: flex; flex-direction: column; gap: 10px; margin-bottom: 24px; }
.mail-features-list li { font-size: 13px; color: #555; display: flex; align-items: flex-start; gap: 8px; line-height: 1.5; }
.mail-features-list li i { color: #10b981; font-size: 13px; margin-top: 1px; flex-shrink: 0; }
.mail-kpi-row { display: flex; gap: 8px; flex-wrap: wrap; padding-top: 20px; border-top: 1px solid #f0f0f0; }
.mail-kpi-chip { background: #fef3ea; color: #e8761a; font-size: 12px; font-weight: 700; padding: 6px 12px; border-radius: 8px; }

/* HOW IT WORKS */
.mail-how { background: #fff; padding: 80px 40px; border-top: 1px solid #f0f0f0; }
.mail-how-inner { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
.mail-how-visual { position: relative; }
.mail-email-preview {
  background: #fff; border: 1px solid #e5e7eb; border-radius: 16px;
  overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.1);
}
.mail-email-header { background: #f8f8f8; padding: 16px 20px; border-bottom: 1px solid #e5e7eb; }
.mail-email-from { font-size: 12px; color: #888; }
.mail-email-from strong { color: #1a1a1a; }
.mail-email-subject { font-size: 14px; font-weight: 700; color: #1a1a1a; margin-top: 4px; }
.mail-email-body-preview { padding: 0; }
.mail-email-banner { height: 160px; overflow: hidden; }
.mail-email-banner img { width: 100%; height: 100%; object-fit: cover; }
.mail-email-content { padding: 24px; }
.mail-email-content h4 { font-family: 'Playfair Display', serif; font-size: 20px; color: #1a1a1a; margin-bottom: 10px; }
.mail-email-content p { font-size: 13px; color: #666; line-height: 1.7; margin-bottom: 16px; }
.mail-email-cta { display: inline-block; background: #e8761a; color: #fff; padding: 12px 28px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none; }
.mail-email-footer { background: #f8f8f8; padding: 12px 24px; border-top: 1px solid #f0f0f0; font-size: 10px; color: #bbb; display: flex; justify-content: space-between; }
.mail-how-steps { display: flex; flex-direction: column; gap: 32px; }
.mail-how-step { display: flex; gap: 20px; align-items: flex-start; }
.mail-how-step-num {
  width: 48px; height: 48px; border-radius: 12px; flex-shrink: 0;
  background: linear-gradient(135deg, #fef3ea, #fde4c5);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Bebas Neue', sans-serif; font-size: 24px; color: #e8761a;
}
.mail-how-step h4 { font-size: 16px; font-weight: 700; color: #1a1a1a; margin-bottom: 6px; }
.mail-how-step p { font-size: 14px; color: #666; line-height: 1.6; }

/* AUTOMATION */
.mail-automation { background: #f5f0e8; padding: 80px 40px; }
.mail-automation-inner { max-width: 1200px; margin: 0 auto; }
.mail-automation-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-top: 56px; }
.mail-automation-card {
  background: #fff; border-radius: 20px; padding: 32px;
  border: 1.5px solid #e5e7eb; transition: all 0.3s;
}
.mail-automation-card:hover { border-color: #e8761a; transform: translateY(-3px); box-shadow: 0 16px 40px rgba(232,118,26,0.1); }
.mail-automation-icon {
  width: 52px; height: 52px; border-radius: 14px;
  background: linear-gradient(135deg, #fef3ea, #fde4c5);
  display: flex; align-items: center; justify-content: center;
  font-size: 22px; color: #e8761a; margin-bottom: 20px;
}
.mail-automation-card h4 { font-size: 16px; font-weight: 700; color: #1a1a1a; margin-bottom: 10px; }
.mail-automation-card p { font-size: 13px; color: #666; line-height: 1.6; }
.mail-automation-badge {
  margin-top: 16px; display: inline-block;
  font-size: 11px; font-weight: 700; text-transform: uppercase;
  letter-spacing: 0.8px; color: #10b981; background: rgba(16,185,129,0.1);
  padding: 4px 10px; border-radius: 6px;
}

/* TEMPLATES */
.mail-templates { padding: 80px 40px; max-width: 1300px; margin: 0 auto; }
.mail-templates-scroll { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-top: 56px; }
.mail-template-card { border-radius: 16px; overflow: hidden; border: 1.5px solid #e5e7eb; background: #fff; cursor: pointer; transition: all 0.3s; }
.mail-template-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); border-color: #e8761a; }
.mail-template-thumb { height: 200px; overflow: hidden; }
.mail-template-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s; }
.mail-template-card:hover .mail-template-thumb img { transform: scale(1.05); }
.mail-template-info { padding: 20px; }
.mail-template-info h4 { font-size: 14px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px; }
.mail-template-info span { font-size: 11px; color: #888; }
.mail-template-stat { display: flex; gap: 8px; margin-top: 12px; }
.mail-template-stat span { font-size: 11px; font-weight: 700; color: #e8761a; background: #fef3ea; padding: 3px 8px; border-radius: 6px; }

/* CTA */
.mail-cta { background: linear-gradient(135deg, #e8761a 0%, #c04f10 100%); padding: 80px 40px; text-align: center; }
.mail-cta h2 { font-family: 'Bebas Neue', sans-serif; font-size: clamp(52px,7vw,90px); color: #fff; line-height: 0.95; margin-bottom: 16px; letter-spacing: 1px; }
.mail-cta p { font-size: 18px; color: rgba(255,255,255,0.85); line-height: 1.7; max-width: 560px; margin: 0 auto 36px; }

@media(max-width:1100px){
  .mail-hero-grid { grid-template-columns: 1fr; gap: 40px; }
  .mail-campaigns-grid { grid-template-columns: 1fr; }
  .mail-how-inner { grid-template-columns: 1fr; }
  .mail-automation-grid { grid-template-columns: repeat(2, 1fr); }
  .mail-templates-scroll { grid-template-columns: repeat(2, 1fr); }
  .mail-stats-band-inner { grid-template-columns: repeat(3, 1fr); }
}
@media(max-width:768px){
  .mail-hero { padding: 60px 20px 0; }
  .mail-automation-grid { grid-template-columns: 1fr; }
  .mail-templates-scroll { grid-template-columns: 1fr; }
  .mail-stats-band-inner { grid-template-columns: repeat(2, 1fr); }
}
@endsection

@section('content')
<section id="mail-page">

  <!-- HERO -->
  <div class="mail-hero">
    <div class="mail-hero-inner">
      <div class="mail-hero-tag"><i class="fas fa-paper-plane"></i> Mail Marketing Studio</div>
      <div class="mail-hero-grid">
        <div>
          <h1 class="mail-hero-h">MAIL<br><em>MARK</em><br>ETING</h1>
          <p class="mail-hero-sub">Concevez des campagnes email qui convertissent vraiment. Segmentation intelligente, design responsive, automation avancée et analytics en temps réel pour maximiser votre ROI.</p>
          <div class="mail-hero-btns">
            <a href="#" class="btn-orange"><i class="fas fa-rocket"></i> Créer une campagne</a>
            <a href="#" class="btn-outline"><i class="fas fa-chart-bar"></i> Voir les analytics</a>
          </div>
          <div class="mail-hero-proof">
            <div class="mail-hero-proof-avatars">
              <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&h=80&fit=crop" alt="">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&h=80&fit=crop" alt="">
              <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?w=80&h=80&fit=crop" alt="">
              <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&h=80&fit=crop" alt="">
            </div>
            <span>+800 entreprises font confiance à GoExploria Mail</span>
          </div>
        </div>
        <div class="mail-metrics-panel">
          <h3><i class="fas fa-chart-line" style="color:#e8761a;margin-right:8px"></i> Performance en temps réel</h3>
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
            <span class="mail-metric-label">Désabo.</span>
            <div class="mail-metric-bar-wrap"><div class="mail-metric-bar red" style="width:0.4%"></div></div>
            <span class="mail-metric-value" style="color:#ef4444">0.4%</span>
          </div>
          <div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,0.08);display:flex;justify-content:space-between;font-size:12px;color:rgba(255,255,255,0.4)">
            <span>Mise à jour il y a 2 min.</span>
            <span style="color:#34d399"><i class="fas fa-circle" style="font-size:8px"></i> En direct</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- STATS BAND -->
  <div class="mail-stats-band">
    <div class="mail-stats-band-inner">
      <div class="mail-stat-cell"><strong>2.4M</strong><span>Emails envoyés</span></div>
      <div class="mail-stat-cell"><strong>42.7%</strong><span>Taux ouverture</span></div>
      <div class="mail-stat-cell"><strong>98.2%</strong><span>Délivrabilité</span></div>
      <div class="mail-stat-cell"><strong>6.9%</strong><span>Conversion</span></div>
      <div class="mail-stat-cell"><strong>800+</strong><span>Clients actifs</span></div>
    </div>
  </div>

  <!-- CAMPAIGN TYPES -->
  <div class="mail-campaigns-section">
    <div class="section-label">Types de campagnes</div>
    <h2 class="section-title-serif">Nos 3 spécialités email</h2>
    <p class="section-desc">Chaque secteur a ses codes. Nos templates et stratégies sont conçus spécifiquement pour vos audiences.</p>
    <div class="mail-campaigns-grid">
      <div class="mail-campaign-card">
        <div class="mail-campaign-img">
          <img src="https://images.unsplash.com/photo-1607082349566-187342175e2f?w=600&h=400&fit=crop" alt="E-commerce">
          <div class="mail-campaign-tag-overlay"><span style="background:#e8761a;color:#fff;font-size:10px;font-weight:700;padding:5px 12px;border-radius:999px;text-transform:uppercase;letter-spacing:0.8px"><i class="fas fa-cart-shopping"></i> E-commerce</span></div>
        </div>
        <div class="mail-campaign-body">
          <div class="mail-campaign-type"><i class="fas fa-cart-shopping"></i> E-commerce</div>
          <h3>Email Marketing E-commerce</h3>
          <p>Relance panier abandonné, recommandations produit personnalisées et séquence post-achat pour augmenter la valeur vie client et maximiser le revenu.</p>
          <ul class="mail-features-list">
            <li><i class="fas fa-check-circle"></i> Workflow relance 3 emails automatisés</li>
            <li><i class="fas fa-check-circle"></i> Codes promo dynamiques personnalisés</li>
            <li><i class="fas fa-check-circle"></i> Recommandations IA sur historique d'achat</li>
            <li><i class="fas fa-check-circle"></i> Tests A/B multivariés objet + contenu</li>
            <li><i class="fas fa-check-circle"></i> Segmentation par comportement d'achat</li>
          </ul>
          <div class="mail-kpi-row">
            <span class="mail-kpi-chip">+18.6% Conversion</span>
            <span class="mail-kpi-chip">+31% Panier moyen</span>
          </div>
        </div>
      </div>
      <div class="mail-campaign-card">
        <div class="mail-campaign-img">
          <img src="https://images.unsplash.com/photo-1552581234-26160f608093?w=600&h=400&fit=crop" alt="B2B">
          <div class="mail-campaign-tag-overlay"><span style="background:#2563eb;color:#fff;font-size:10px;font-weight:700;padding:5px 12px;border-radius:999px;text-transform:uppercase;letter-spacing:0.8px"><i class="fas fa-briefcase"></i> B2B</span></div>
        </div>
        <div class="mail-campaign-body">
          <div class="mail-campaign-type" style="color:#2563eb"><i class="fas fa-briefcase"></i> Business B2B</div>
          <h3>Email Marketing Business</h3>
          <p>Nurturing B2B pour qualifier vos leads : séquences webinar, études de cas impactantes et prise de rendez-vous commerciale pour accélérer votre cycle de vente.</p>
          <ul class="mail-features-list">
            <li><i class="fas fa-check-circle"></i> Lead scoring automatique et priorisation</li>
            <li><i class="fas fa-check-circle"></i> CTA rendez-vous intégré au CRM</li>
            <li><i class="fas fa-check-circle"></i> Séquences onboarding et nurturing avancé</li>
            <li><i class="fas fa-check-circle"></i> Reporting ROI détaillé par segment</li>
            <li><i class="fas fa-check-circle"></i> Personnalisation dynamique par industrie</li>
          </ul>
          <div class="mail-kpi-row">
            <span class="mail-kpi-chip" style="background:#eff6ff;color:#2563eb">+27% SQL générées</span>
            <span class="mail-kpi-chip" style="background:#eff6ff;color:#2563eb">-40% Cycle vente</span>
          </div>
        </div>
      </div>
      <div class="mail-campaign-card">
        <div class="mail-campaign-img">
          <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=600&h=400&fit=crop" alt="Tourisme">
          <div class="mail-campaign-tag-overlay"><span style="background:#10b981;color:#fff;font-size:10px;font-weight:700;padding:5px 12px;border-radius:999px;text-transform:uppercase;letter-spacing:0.8px"><i class="fas fa-plane-departure"></i> Tourisme</span></div>
        </div>
        <div class="mail-campaign-body">
          <div class="mail-campaign-type" style="color:#10b981"><i class="fas fa-plane-departure"></i> Tourisme</div>
          <h3>Email Marketing Tourisme</h3>
          <p>Campagnes inspiration destination, alertes forfaits last minute et guides saisonniers pour stimuler les réservations et fidéliser votre communauté.</p>
          <ul class="mail-features-list">
            <li><i class="fas fa-check-circle"></i> Segmentation par destination et type de voyage</li>
            <li><i class="fas fa-check-circle"></i> Alertes "dernières places" temps réel</li>
            <li><i class="fas fa-check-circle"></i> Contenus inspirants avec photos premium</li>
            <li><i class="fas fa-check-circle"></i> Programmes de fidélité et rewards auto.</li>
            <li><i class="fas fa-check-circle"></i> Calendrier saisonnier automatisé</li>
          </ul>
          <div class="mail-kpi-row">
            <span class="mail-kpi-chip" style="background:rgba(16,185,129,0.1);color:#10b981">+21.3% Réservations</span>
            <span class="mail-kpi-chip" style="background:rgba(16,185,129,0.1);color:#10b981">42.7% Ouverture</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- HOW IT WORKS -->
  <div class="mail-how">
    <div class="mail-how-inner">
      <div>
        <div class="section-label">Comment ça marche</div>
        <h2 class="section-title-serif">De la stratégie à l'envoi<br>en 5 étapes claires</h2>
        <p class="section-desc" style="margin-bottom:40px">Notre processus éprouvé garantit des campagnes performantes, livrées à temps, avec des résultats mesurables.</p>
        <div class="mail-how-steps">
          <div class="mail-how-step">
            <div class="mail-how-step-num">1</div>
            <div><h4>Stratégie &amp; segmentation</h4><p>Analyse de votre audience, définition des segments, des objectifs et du calendrier éditorial mensuel personnalisé.</p></div>
          </div>
          <div class="mail-how-step">
            <div class="mail-how-step-num">2</div>
            <div><h4>Création du contenu</h4><p>Rédaction des textes, design responsive, personnalisation dynamique par segment et intégration des éléments visuels.</p></div>
          </div>
          <div class="mail-how-step">
            <div class="mail-how-step-num">3</div>
            <div><h4>Tests A/B &amp; validation</h4><p>Test des objets, des CTA, des visuels et des horaires d'envoi pour identifier les combinaisons les plus performantes.</p></div>
          </div>
          <div class="mail-how-step">
            <div class="mail-how-step-num">4</div>
            <div><h4>Envoi &amp; automation</h4><p>Déclencheurs comportementaux, séquences automatisées et envoi optimisé selon les créneaux horaires de votre audience.</p></div>
          </div>
          <div class="mail-how-step">
            <div class="mail-how-step-num">5</div>
            <div><h4>Analytics &amp; optimisation</h4><p>Suivi des KPIs en temps réel, rapports détaillés et ajustements continus pour maximiser votre ROI.</p></div>
          </div>
        </div>
      </div>
      <div class="mail-how-visual">
        <div class="mail-email-preview">
          <div class="mail-email-header">
            <div class="mail-email-from"><strong>GoExploria</strong> &lt;hello@goexploria.com&gt;</div>
            <div class="mail-email-from" style="margin-top:2px">À : Julie Tremblay &lt;julie@email.com&gt;</div>
            <div class="mail-email-subject">🍁 Charlevoix vous attend — Offre spéciale famille !</div>
          </div>
          <div class="mail-email-body-preview">
            <div class="mail-email-banner"><img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=700&h=300&fit=crop" alt="Charlevoix"></div>
            <div class="mail-email-content">
              <p style="font-size:12px;color:#888;margin-bottom:8px">Bonjour Julie,</p>
              <h4>Votre escapade en Charlevoix<br>à prix exclusif</h4>
              <p>Nous avons sélectionné 3 chalets parfaits pour votre famille. Disponibles fin juin, vue sur le fleuve, pleine nature. Profitez de -15% avec le code <strong style="color:#e8761a">FAMILLE15</strong>.</p>
              <a href="#" class="mail-email-cta">Voir les offres disponibles →</a>
            </div>
            <div class="mail-email-footer">
              <span>© 2026 GoExploria · Montréal, Québec</span>
              <span><a href="#" style="color:#bbb">Se désabonner</a></span>
            </div>
          </div>
        </div>
        <!-- Stats overlay -->
        <div style="background:#fff;border:1.5px solid #f0f0f0;border-radius:16px;padding:20px;margin-top:16px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px">
          <div style="text-align:center"><div style="font-family:'Bebas Neue',sans-serif;font-size:36px;color:#e8761a;line-height:1">68%</div><div style="font-size:11px;color:#888">Ouverture</div></div>
          <div style="text-align:center"><div style="font-family:'Bebas Neue',sans-serif;font-size:36px;color:#2563eb;line-height:1">24%</div><div style="font-size:11px;color:#888">Clics</div></div>
          <div style="text-align:center"><div style="font-family:'Bebas Neue',sans-serif;font-size:36px;color:#10b981;line-height:1">9.3%</div><div style="font-size:11px;color:#888">Conversion</div></div>
        </div>
      </div>
    </div>
  </div>

  <!-- AUTOMATION -->
  <div class="mail-automation">
    <div class="mail-automation-inner">
      <div class="section-label">Automation &amp; IA</div>
      <h2 class="section-title-serif">Des séquences qui travaillent<br>pendant que vous dormez</h2>
      <p class="section-desc">Configurez une fois, récoltez en continu. Nos flows d'automation couvrent tout le cycle de vie client.</p>
      <div class="mail-automation-grid">
        <div class="mail-automation-card">
          <div class="mail-automation-icon"><i class="fas fa-shopping-cart"></i></div>
          <h4>Panier abandonné</h4>
          <p>Séquence de 3 emails sur 48h pour récupérer les clients indécis avec une offre personnalisée et une urgence créée.</p>
          <span class="mail-automation-badge">+23% Récup.</span>
        </div>
        <div class="mail-automation-card">
          <div class="mail-automation-icon"><i class="fas fa-user-plus"></i></div>
          <h4>Bienvenue &amp; onboarding</h4>
          <p>Séquence de 5 emails pour accueillir les nouveaux inscrits, présenter votre offre et créer un lien dès le départ.</p>
          <span class="mail-automation-badge">68% Open rate</span>
        </div>
        <div class="mail-automation-card">
          <div class="mail-automation-icon"><i class="fas fa-birthday-cake"></i></div>
          <h4>Anniversaires &amp; dates clés</h4>
          <p>Emails automatiques pour anniversaires, anniversaires d'abonnement et dates importantes avec offres exclusives.</p>
          <span class="mail-automation-badge">+41% Fidélité</span>
        </div>
        <div class="mail-automation-card">
          <div class="mail-automation-icon"><i class="fas fa-redo"></i></div>
          <h4>Réactivation clients</h4>
          <p>Séquence win-back pour réengager les clients inactifs depuis 90 jours avec des offres coup de cœur irrésistibles.</p>
          <span class="mail-automation-badge">18% Réactivation</span>
        </div>
      </div>
    </div>
  </div>

  <!-- TEMPLATES -->
  <div class="mail-templates">
    <div class="section-label">Bibliothèque de templates</div>
    <h2 class="section-title-serif">100+ templates<br>prêts à personnaliser</h2>
    <p class="section-desc">Designs responsives testés sur tous les clients email. Personnalisez en minutes, publiez en secondes.</p>
    <div class="mail-templates-scroll">
      <div class="mail-template-card">
        <div class="mail-template-thumb"><img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=400&h=280&fit=crop" alt="Beach template"></div>
        <div class="mail-template-info">
          <h4>Summer Escape</h4>
          <span>Tourisme · Destinations plage</span>
          <div class="mail-template-stat"><span>54% Ouverture</span><span>Prêt à l'emploi</span></div>
        </div>
      </div>
      <div class="mail-template-card">
        <div class="mail-template-thumb"><img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=400&h=280&fit=crop" alt="B2B template"></div>
        <div class="mail-template-info">
          <h4>Business Nexus</h4>
          <span>B2B · Corporate</span>
          <div class="mail-template-stat"><span>38% Ouverture</span><span>CRM intégré</span></div>
        </div>
      </div>
      <div class="mail-template-card">
        <div class="mail-template-thumb"><img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=400&h=280&fit=crop" alt="Food template"></div>
        <div class="mail-template-info">
          <h4>Gourmet Edition</h4>
          <span>Gastronomie · Restaurants</span>
          <div class="mail-template-stat"><span>61% Ouverture</span><span>Réservation auto</span></div>
        </div>
      </div>
      <div class="mail-template-card">
        <div class="mail-template-thumb"><img src="https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=280&fit=crop" alt="Winter template"></div>
        <div class="mail-template-info">
          <h4>Winter Adventure</h4>
          <span>Tourisme · Sports hiver</span>
          <div class="mail-template-stat"><span>48% Ouverture</span><span>Prêt à l'emploi</span></div>
        </div>
      </div>
    </div>
  </div>

  <!-- CTA -->
  <div class="mail-cta">
    <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.7)">Commencez maintenant</div>
    <h2>LANCEZ VOTRE<br>PREMIÈRE CAMPAGNE</h2>
    <p>Rejoignez 800+ entreprises qui font confiance à GoExploria Mail pour convertir leurs abonnés en clients fidèles.</p>
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
      <a href="#" style="background:#fff;color:#e8761a;padding:16px 40px;border-radius:10px;font-weight:700;font-size:16px;text-decoration:none;display:inline-flex;align-items:center;gap:10px"><i class="fas fa-rocket"></i> Essai gratuit 30 jours</a>
      <a href="#" class="btn-outline-white" style="font-size:16px;padding:16px 40px"><i class="fas fa-play"></i> Voir une démo</a>
    </div>
    <p style="margin-top:20px;font-size:13px;color:rgba(255,255,255,0.6)">Aucune carte bancaire · Templates inclus · Support dédié</p>
  </div>

</section>
@endsection