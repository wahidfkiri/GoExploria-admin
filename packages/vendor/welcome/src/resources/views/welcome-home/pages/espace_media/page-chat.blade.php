@extends('welcome-home.layouts.app')

@section('title', 'Espace Chat — Inbox Unifiée')
@section('meta_description', 'Centralisez WhatsApp, Messenger, Instagram et votre site web dans une inbox intelligente. Répondez plus vite, convertissez plus.')

@section('breadcrumb')
<span class="current">Espace Chat</span>
@endsection

@section('page-styles')
/* ===================== CHAT PAGE ===================== */
#chat-page { background: #f8faff; }

/* HERO */
.chat-hero {
  background: linear-gradient(135deg, #1e3a5f 0%, #0f2240 100%);
  padding: 80px 40px 100px;
  position: relative;
  overflow: hidden;
}
.chat-hero-bg-circles {
  position: absolute; inset: 0; pointer-events: none;
}
.chat-hero-bg-circles span {
  position: absolute; border-radius: 50%;
  border: 1px solid rgba(255,255,255,0.06);
}
.chat-hero-bg-circles span:nth-child(1) { width:600px;height:600px;top:-200px;right:-100px; }
.chat-hero-bg-circles span:nth-child(2) { width:400px;height:400px;top:-80px;right:60px; }
.chat-hero-bg-circles span:nth-child(3) { width:200px;height:200px;top:40px;right:200px; }
.chat-hero-inner {
  max-width: 1200px; margin: 0 auto;
  display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center;
}
.chat-hero-live-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(52,211,153,0.15); color: #34d399;
  border: 1px solid rgba(52,211,153,0.3); border-radius: 999px;
  padding: 6px 16px; font-size: 12px; font-weight: 700; margin-bottom: 24px;
}
.chat-hero-live-dot {
  width: 8px; height: 8px; border-radius: 50%; background: #34d399;
  animation: livePulse 2s infinite;
}
@keyframes livePulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.4;transform:scale(0.8)} }
.chat-hero-title {
  font-family: 'Space Grotesk', sans-serif;
  font-size: clamp(38px, 4vw, 58px);
  color: #fff; font-weight: 700; line-height: 1.1; margin-bottom: 20px;
}
.chat-hero-desc {
  font-size: 16px; color: rgba(255,255,255,0.7);
  line-height: 1.8; margin-bottom: 36px; max-width: 480px;
}
.chat-kpis-row { display: flex; gap: 32px; margin-bottom: 36px; }
.chat-kpi-item strong {
  display: block; font-size: 32px; font-weight: 700;
  color: #fff; font-family: 'Space Grotesk', sans-serif; line-height: 1;
}
.chat-kpi-item span {
  font-size: 11px; color: rgba(255,255,255,0.5);
  text-transform: uppercase; letter-spacing: 0.8px; margin-top: 4px; display: block;
}
.chat-kpi-item strong em { color: #34d399; font-style: normal; }
.chat-hero-btns { display: flex; gap: 14px; flex-wrap: wrap; }

/* MOCKUP */
.chat-mockup-wrap {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 20px; overflow: hidden;
  box-shadow: 0 40px 80px rgba(0,0,0,0.4);
}
.chat-mockup-topbar {
  background: rgba(255,255,255,0.07);
  padding: 12px 20px; border-bottom: 1px solid rgba(255,255,255,0.08);
  display: flex; align-items: center; gap: 10px;
}
.chat-mockup-dots { display: flex; gap: 6px; }
.chat-mockup-dots span { width: 10px; height: 10px; border-radius: 50%; }
.chat-mockup-dots .d1 { background: #ff5f57; }
.chat-mockup-dots .d2 { background: #febc2e; }
.chat-mockup-dots .d3 { background: #28c840; }
.chat-mockup-title { font-size: 12px; color: rgba(255,255,255,0.4); margin-left: 8px; }
.chat-mockup-layout { display: grid; grid-template-columns: 200px 1fr; min-height: 420px; }
.chat-sidebar {
  background: rgba(255,255,255,0.03);
  border-right: 1px solid rgba(255,255,255,0.06);
  padding: 12px 0;
}
.chat-sidebar-item {
  padding: 10px 14px; display: flex; gap: 10px; align-items: center;
  cursor: pointer; transition: background 0.2s;
}
.chat-sidebar-item:hover, .chat-sidebar-item.active { background: rgba(255,255,255,0.06); }
.chat-sidebar-item.active { border-left: 2px solid #e8761a; }
.chat-avatar { width: 32px; height: 32px; border-radius: 50%; overflow: hidden; flex-shrink: 0; }
.chat-avatar img { width: 100%; height: 100%; object-fit: cover; }
.chat-sidebar-name { font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.8); }
.chat-sidebar-preview { font-size: 10px; color: rgba(255,255,255,0.4); margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 120px; }
.chat-sidebar-meta { margin-left: auto; text-align: right; }
.chat-sidebar-time { font-size: 9px; color: rgba(255,255,255,0.3); display: block; }
.chat-sidebar-unread { width: 16px; height: 16px; background: #e8761a; border-radius: 50%; font-size: 9px; font-weight: 700; color: #fff; display: flex; align-items: center; justify-content: center; margin-top: 4px; margin-left: auto; }
.chat-main-area { display: flex; flex-direction: column; }
.chat-main-header {
  padding: 12px 16px;
  border-bottom: 1px solid rgba(255,255,255,0.06);
  display: flex; align-items: center; gap: 12px;
}
.chat-main-header .platform-tag {
  font-size: 10px; font-weight: 700; padding: 3px 8px;
  border-radius: 4px; background: rgba(37,211,102,0.15); color: #25d366;
}
.chat-msgs { flex: 1; padding: 16px; display: flex; flex-direction: column; gap: 12px; }
.chat-msg { display: flex; gap: 8px; align-items: flex-end; }
.chat-msg.right { flex-direction: row-reverse; }
.chat-msg-bubble {
  background: rgba(255,255,255,0.08);
  border-radius: 12px; padding: 10px 14px;
  font-size: 12px; color: rgba(255,255,255,0.85);
  max-width: 200px; line-height: 1.5;
}
.chat-msg.right .chat-msg-bubble { background: #e8761a; color: #fff; }
.chat-msg-time { font-size: 9px; color: rgba(255,255,255,0.3); margin-bottom: 4px; }
.chat-input-area {
  padding: 12px 16px; border-top: 1px solid rgba(255,255,255,0.06);
  display: flex; gap: 8px; align-items: center;
}
.chat-input-box {
  flex: 1; background: rgba(255,255,255,0.07);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 999px; padding: 8px 16px;
  font-size: 12px; color: rgba(255,255,255,0.5);
}
.chat-send-btn {
  width: 32px; height: 32px; background: #e8761a;
  border-radius: 50%; display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 13px;
}
.chat-platforms-bar {
  padding: 10px 16px; border-top: 1px solid rgba(255,255,255,0.06);
  display: flex; gap: 8px;
}
.chat-channel-tag {
  display: flex; align-items: center; gap: 5px;
  font-size: 10px; font-weight: 700; padding: 4px 10px;
  border-radius: 6px; background: rgba(255,255,255,0.07);
  border: 1px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.7);
}

/* METRICS STRIP */
.chat-metrics-strip {
  background: #e8761a; padding: 0 40px;
}
.chat-metrics-strip-inner {
  max-width: 1200px; margin: 0 auto;
  display: grid; grid-template-columns: repeat(4, 1fr);
}
.chat-metric-cell {
  padding: 28px 24px; text-align: center;
  border-right: 1px solid rgba(255,255,255,0.25);
}
.chat-metric-cell:last-child { border-right: none; }
.chat-metric-cell strong {
  display: block; font-family: 'Bebas Neue', sans-serif;
  font-size: 48px; color: #fff; line-height: 1;
}
.chat-metric-cell span {
  font-size: 12px; color: rgba(255,255,255,0.85);
  text-transform: uppercase; letter-spacing: 0.8px;
}

/* FEATURES GRID */
.chat-features-section { padding: 80px 40px; max-width: 1200px; margin: 0 auto; }
.chat-features-header { margin-bottom: 56px; }
.chat-features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.chat-feature-card {
  background: #fff; border-radius: 20px; padding: 36px;
  border: 1.5px solid #e5e7eb;
  transition: all 0.3s; position: relative; overflow: hidden;
}
.chat-feature-card::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0;
  height: 3px; background: linear-gradient(90deg, #1e3a5f, #e8761a);
  transform: scaleX(0); transform-origin: left; transition: transform 0.3s;
}
.chat-feature-card:hover::before { transform: scaleX(1); }
.chat-feature-card:hover { border-color: #1e3a5f; transform: translateY(-4px); box-shadow: 0 20px 50px rgba(30,58,95,0.1); }
.chat-feature-icon {
  width: 52px; height: 52px; border-radius: 14px;
  background: linear-gradient(135deg, #eff6ff, #dbeafe);
  display: flex; align-items: center; justify-content: center;
  font-size: 22px; color: #1e3a5f; margin-bottom: 22px;
}
.chat-feature-card h4 {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 17px; font-weight: 700; color: #1a1a1a; margin-bottom: 12px;
}
.chat-feature-card p { font-size: 14px; color: #666; line-height: 1.7; }
.chat-feature-tag {
  display: inline-block; margin-top: 16px; font-size: 11px; font-weight: 700;
  text-transform: uppercase; letter-spacing: 0.8px;
  color: #e8761a; background: #fef3ea; padding: 4px 12px; border-radius: 999px;
}

/* HOW IT WORKS */
.chat-how { background: #fff; padding: 80px 40px; }
.chat-how-inner { max-width: 1100px; margin: 0 auto; }
.chat-steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0; margin-top: 56px; position: relative; }
.chat-steps::before {
  content: ''; position: absolute; top: 32px; left: 12%; right: 12%;
  height: 2px; background: linear-gradient(90deg, #e8761a, #1e3a5f);
  z-index: 0;
}
.chat-step { text-align: center; padding: 0 20px; position: relative; z-index: 1; }
.chat-step-num {
  width: 64px; height: 64px; border-radius: 50%;
  background: linear-gradient(135deg, #1e3a5f, #2d5a8e);
  color: #fff; font-family: 'Bebas Neue', sans-serif;
  font-size: 28px; display: flex; align-items: center; justify-content: center;
  margin: 0 auto 20px;
  box-shadow: 0 0 0 6px #fff, 0 0 0 8px #e8e2d9;
}
.chat-step h4 { font-size: 15px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px; }
.chat-step p { font-size: 13px; color: #666; line-height: 1.6; }

/* PRICING */
.chat-pricing { background: #f8faff; padding: 80px 40px; }
.chat-pricing-inner { max-width: 1100px; margin: 0 auto; }
.chat-pricing-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 56px; }
.chat-plan {
  background: #fff; border-radius: 24px; padding: 40px;
  border: 2px solid #e5e7eb; position: relative; transition: all 0.3s;
}
.chat-plan:hover { border-color: #1e3a5f; transform: translateY(-4px); box-shadow: 0 20px 50px rgba(30,58,95,0.1); }
.chat-plan.featured {
  background: linear-gradient(135deg, #1e3a5f, #0f2240);
  border-color: #1e3a5f;
}
.chat-plan-badge {
  position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
  background: #e8761a; color: #fff; font-size: 11px; font-weight: 700;
  text-transform: uppercase; letter-spacing: 0.8px; padding: 5px 16px; border-radius: 999px;
  white-space: nowrap;
}
.chat-plan-name {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 14px; font-weight: 700; text-transform: uppercase;
  letter-spacing: 1px; margin-bottom: 16px;
}
.chat-plan.featured .chat-plan-name { color: rgba(255,255,255,0.7); }
.chat-plan-name:not(.featured .chat-plan-name) { color: #888; }
.chat-plan-price {
  font-family: 'Bebas Neue', sans-serif; font-size: 64px; line-height: 1;
  color: #1a1a1a; margin-bottom: 4px;
}
.chat-plan.featured .chat-plan-price { color: #fff; }
.chat-plan-price span { font-size: 20px; vertical-align: super; font-family: 'DM Sans', sans-serif; font-weight: 700; }
.chat-plan-period { font-size: 13px; color: #999; margin-bottom: 24px; }
.chat-plan.featured .chat-plan-period { color: rgba(255,255,255,0.5); }
.chat-plan-divider { height: 1px; background: #f0f0f0; margin: 24px 0; }
.chat-plan.featured .chat-plan-divider { background: rgba(255,255,255,0.12); }
.chat-plan-features { list-style: none; display: flex; flex-direction: column; gap: 12px; margin-bottom: 32px; }
.chat-plan-features li { display: flex; align-items: center; gap: 10px; font-size: 14px; }
.chat-plan-features li i { color: #34d399; font-size: 14px; flex-shrink: 0; }
.chat-plan-features li.disabled { opacity: 0.4; }
.chat-plan-features li.disabled i { color: #ccc; }
.chat-plan:not(.featured) .chat-plan-features li { color: #444; }
.chat-plan.featured .chat-plan-features li { color: rgba(255,255,255,0.85); }
.chat-plan-cta {
  display: block; text-align: center; padding: 14px;
  border-radius: 10px; font-weight: 700; font-size: 14px;
  text-decoration: none; transition: all 0.2s;
}
.chat-plan:not(.featured) .chat-plan-cta {
  background: #f0f4ff; color: #1e3a5f; border: 2px solid #e5e7eb;
}
.chat-plan:not(.featured) .chat-plan-cta:hover {
  background: #1e3a5f; color: #fff; border-color: #1e3a5f;
}
.chat-plan.featured .chat-plan-cta {
  background: #e8761a; color: #fff;
}
.chat-plan.featured .chat-plan-cta:hover { background: #c45e0e; }

/* INTEGRATIONS */
.chat-integrations { padding: 80px 40px; max-width: 1200px; margin: 0 auto; }
.chat-integrations-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-top: 56px; }
.chat-integration-card {
  background: #fff; border-radius: 16px; padding: 28px;
  border: 1.5px solid #e5e7eb; text-align: center;
  transition: all 0.3s; cursor: pointer;
}
.chat-integration-card:hover { border-color: #e8761a; transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,0,0,0.07); }
.chat-integration-icon { font-size: 36px; margin-bottom: 12px; }
.chat-integration-name { font-size: 14px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px; }
.chat-integration-desc { font-size: 12px; color: #888; }

/* CTA BAND */
.chat-cta { background: linear-gradient(135deg, #1e3a5f, #0f2240); padding: 80px 40px; text-align: center; }
.chat-cta h2 { font-family: 'Playfair Display', serif; font-size: clamp(32px,4vw,52px); color: #fff; margin-bottom: 16px; }
.chat-cta p { font-size: 17px; color: rgba(255,255,255,0.75); line-height: 1.7; max-width: 560px; margin: 0 auto 36px; }

@media(max-width:1100px){
  .chat-hero-inner { grid-template-columns: 1fr; }
  .chat-features-grid { grid-template-columns: repeat(2, 1fr); }
  .chat-steps { grid-template-columns: repeat(2, 1fr); gap: 40px; }
  .chat-steps::before { display: none; }
  .chat-pricing-grid { grid-template-columns: 1fr; }
  .chat-integrations-grid { grid-template-columns: repeat(2, 1fr); }
  .chat-metrics-strip-inner { grid-template-columns: repeat(2, 1fr); }
}
@media(max-width:768px){
  .chat-hero { padding: 60px 20px 80px; }
  .chat-features-grid { grid-template-columns: 1fr; }
  .chat-steps { grid-template-columns: 1fr; }
  .chat-integrations-grid { grid-template-columns: repeat(2, 1fr); }
}
@endsection

@section('content')
<section id="chat-page">

  <!-- HERO -->
  <div class="chat-hero">
    <div class="chat-hero-bg-circles">
      <span></span><span></span><span></span>
    </div>
    <div class="chat-hero-inner">
      <div>
        <div class="chat-hero-live-badge">
          <span class="chat-hero-live-dot"></span>
          Système actif — 326 conversations en cours
        </div>
        <h1 class="chat-hero-title">Votre inbox client<br>unifiée &amp;<br>intelligente</h1>
        <p class="chat-hero-desc">Centralisez toutes vos conversations — WhatsApp, Messenger, Instagram, site web — dans une interface unique ultra-rapide. Ne perdez plus jamais un lead.</p>
        <div class="chat-kpis-row">
          <div class="chat-kpi-item"><strong><em>1m 48s</em></strong><span>Réponse moy.</span></div>
          <div class="chat-kpi-item"><strong>96%</strong><span>Satisfaction</span></div>
          <div class="chat-kpi-item"><strong>4</strong><span>Canaux unifiés</span></div>
          <div class="chat-kpi-item"><strong>326</strong><span>Conv. aujourd'hui</span></div>
        </div>
        <div class="chat-hero-btns">
          <a href="#" class="btn-orange"><i class="fas fa-rocket"></i> Essayer gratuitement</a>
          <a href="#" class="btn-outline-white"><i class="fas fa-play"></i> Voir la démo</a>
        </div>
      </div>
      <!-- MOCKUP -->
      <div class="chat-mockup-wrap">
        <div class="chat-mockup-topbar">
          <div class="chat-mockup-dots"><span class="d1"></span><span class="d2"></span><span class="d3"></span></div>
          <span class="chat-mockup-title">GoExploria Inbox — 326 actives</span>
          <div style="margin-left:auto;display:flex;gap:8px">
            <div style="width:20px;height:20px;border-radius:4px;background:rgba(255,255,255,0.07);display:flex;align-items:center;justify-content:center;font-size:9px;color:rgba(255,255,255,0.3)"><i class="fas fa-search"></i></div>
            <div style="width:20px;height:20px;border-radius:4px;background:rgba(255,255,255,0.07);display:flex;align-items:center;justify-content:center;font-size:9px;color:rgba(255,255,255,0.3)"><i class="fas fa-cog"></i></div>
          </div>
        </div>
        <div class="chat-mockup-layout">
          <!-- Sidebar -->
          <div class="chat-sidebar">
            <div style="padding:8px 14px;margin-bottom:6px">
              <div style="background:rgba(255,255,255,0.07);border-radius:8px;padding:6px 10px;font-size:10px;color:rgba(255,255,255,0.3);display:flex;align-items:center;gap:6px"><i class="fas fa-search"></i> Rechercher...</div>
            </div>
            <div style="padding:4px 14px;margin-bottom:4px"><span style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,0.3)">Non lus (3)</span></div>
            <div class="chat-sidebar-item active">
              <div class="chat-avatar"><img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&h=80&fit=crop" alt="Julie"></div>
              <div style="flex:1;min-width:0">
                <div class="chat-sidebar-name">Julie T.</div>
                <div class="chat-sidebar-preview">Charlevoix fin juin 4 pers.</div>
              </div>
              <div class="chat-sidebar-meta">
                <span class="chat-sidebar-time">14:23</span>
                <div class="chat-sidebar-unread">2</div>
              </div>
            </div>
            <div class="chat-sidebar-item">
              <div class="chat-avatar"><img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&h=80&fit=crop" alt="Marc"></div>
              <div style="flex:1;min-width:0">
                <div class="chat-sidebar-name">Marc B.</div>
                <div class="chat-sidebar-preview">Merci pour l'offre !</div>
              </div>
              <div class="chat-sidebar-meta">
                <span class="chat-sidebar-time">13:51</span>
              </div>
            </div>
            <div class="chat-sidebar-item">
              <div class="chat-avatar"><img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?w=80&h=80&fit=crop" alt="Sophie"></div>
              <div style="flex:1;min-width:0">
                <div class="chat-sidebar-name">Sophie G.</div>
                <div class="chat-sidebar-preview">Très bien ! À bientôt</div>
              </div>
              <div class="chat-sidebar-meta">
                <span class="chat-sidebar-time">12:08</span>
                <div class="chat-sidebar-unread">1</div>
              </div>
            </div>
            <div style="padding:4px 14px;margin:8px 0 4px"><span style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,0.3)">Récents</span></div>
            <div class="chat-sidebar-item">
              <div class="chat-avatar"><img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&h=80&fit=crop" alt="Paul"></div>
              <div style="flex:1;min-width:0">
                <div class="chat-sidebar-name">Paul M.</div>
                <div class="chat-sidebar-preview">Disponible en août ?</div>
              </div>
              <div class="chat-sidebar-meta"><span class="chat-sidebar-time">Hier</span></div>
            </div>
          </div>
          <!-- Main chat -->
          <div class="chat-main-area">
            <div class="chat-main-header">
              <div class="chat-avatar"><img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&h=80&fit=crop" alt="Julie"></div>
              <div>
                <div style="font-size:13px;font-weight:700;color:#fff">Julie Tremblay</div>
                <div style="font-size:10px;color:rgba(255,255,255,0.4)">En ligne maintenant</div>
              </div>
              <span class="platform-tag" style="margin-left:8px"><i class="fab fa-whatsapp"></i> WhatsApp</span>
              <div style="margin-left:auto;display:flex;gap:10px;color:rgba(255,255,255,0.4);font-size:14px">
                <i class="fas fa-phone"></i><i class="fas fa-video"></i><i class="fas fa-ellipsis-v"></i>
              </div>
            </div>
            <div class="chat-msgs">
              <div class="chat-msg">
                <div class="chat-avatar"><img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&h=80&fit=crop" alt="Julie"></div>
                <div><div class="chat-msg-time">14:20</div><div class="chat-msg-bubble">Bonjour ! Je cherche un hébergement à Charlevoix pour 4 personnes fin juin 🙏</div></div>
              </div>
              <div class="chat-msg right">
                <div class="chat-avatar"><img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=80&h=80&fit=crop" alt="agent"></div>
                <div><div class="chat-msg-time" style="text-align:right">14:21</div><div class="chat-msg-bubble">Bonjour Julie ! Nous avons 3 magnifiques chalets disponibles 🏡 Voici nos options :</div></div>
              </div>
              <div class="chat-msg">
                <div class="chat-avatar"><img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&h=80&fit=crop" alt="Julie"></div>
                <div><div class="chat-msg-time">14:22</div><div class="chat-msg-bubble">Super ! C'est quoi les tarifs pour l'option 2 ?</div></div>
              </div>
              <div class="chat-msg right">
                <div class="chat-avatar"><img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=80&h=80&fit=crop" alt="agent"></div>
                <div><div class="chat-msg-time" style="text-align:right">14:23</div><div class="chat-msg-bubble">Chalet Les Pins : 280$/nuit · Vue fleuve · Dispo 20-28 juin ✨</div></div>
              </div>
            </div>
            <div class="chat-input-area">
              <div class="chat-input-box">Répondre à Julie…</div>
              <div style="display:flex;gap:6px;color:rgba(255,255,255,0.3);font-size:14px">
                <i class="fas fa-paperclip"></i><i class="fas fa-smile"></i>
              </div>
              <div class="chat-send-btn"><i class="fas fa-paper-plane"></i></div>
            </div>
            <div class="chat-platforms-bar">
              <span class="chat-channel-tag" style="color:#25d366"><i class="fab fa-whatsapp"></i> WhatsApp</span>
              <span class="chat-channel-tag" style="color:#e1306c"><i class="fab fa-instagram"></i> Instagram</span>
              <span class="chat-channel-tag" style="color:#0084ff"><i class="fab fa-facebook-messenger"></i> Messenger</span>
              <span class="chat-channel-tag"><i class="fas fa-globe"></i> Site Web</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- METRICS STRIP -->
  <div class="chat-metrics-strip">
    <div class="chat-metrics-strip-inner">
      <div class="chat-metric-cell"><strong>1m48</strong><span>Temps de réponse moyen</span></div>
      <div class="chat-metric-cell"><strong>326</strong><span>Conversations aujourd'hui</span></div>
      <div class="chat-metric-cell"><strong>96%</strong><span>Satisfaction client</span></div>
      <div class="chat-metric-cell"><strong>4</strong><span>Canaux unifiés</span></div>
    </div>
  </div>

  <!-- FEATURES -->
  <div class="chat-features-section">
    <div class="chat-features-header">
      <div class="section-label">Fonctionnalités</div>
      <h2 class="section-title-sans">Tout ce dont votre équipe a besoin</h2>
      <p class="section-desc">Une plateforme pensée pour les équipes commerciales et support qui veulent performer sans complexité.</p>
    </div>
    <div class="chat-features-grid">
      <div class="chat-feature-card">
        <div class="chat-feature-icon"><i class="fas fa-inbox"></i></div>
        <h4>Inbox omnicanale unifiée</h4>
        <p>WhatsApp, Instagram, Messenger, site web — toutes vos conversations dans un seul espace organisé. Fini les onglets multiples et les messages oubliés.</p>
        <span class="chat-feature-tag">Multi-canaux</span>
      </div>
      <div class="chat-feature-card">
        <div class="chat-feature-icon"><i class="fas fa-bolt"></i></div>
        <h4>Réponses IA assistée</h4>
        <p>Notre IA suggère des réponses contextuelles en temps réel, réduisant le temps de traitement de 60% tout en maintenant une touche personnelle et professionnelle.</p>
        <span class="chat-feature-tag">Intelligence IA</span>
      </div>
      <div class="chat-feature-card">
        <div class="chat-feature-icon"><i class="fas fa-users"></i></div>
        <h4>Collaboration d'équipe</h4>
        <p>Assignez des conversations, ajoutez des notes internes, @mentionnez vos collègues et collaborez en temps réel sans que le client ne le voie.</p>
        <span class="chat-feature-tag">Travail d'équipe</span>
      </div>
      <div class="chat-feature-card">
        <div class="chat-feature-icon"><i class="fas fa-user-shield"></i></div>
        <h4>Priorisation VIP &amp; SLA</h4>
        <p>Identifiez automatiquement vos clients VIP, gérez les SLA et assurez-vous que les messages urgents sont traités en priorité absolue avec des alertes.</p>
        <span class="chat-feature-tag">Priorités</span>
      </div>
      <div class="chat-feature-card">
        <div class="chat-feature-icon"><i class="fas fa-robot"></i></div>
        <h4>Chatbot &amp; automation</h4>
        <p>Configurez des flows automatisés pour les questions fréquentes, la prise de rendez-vous et la qualification de leads. Disponible 24h/7j même sans agent.</p>
        <span class="chat-feature-tag">Automation</span>
      </div>
      <div class="chat-feature-card">
        <div class="chat-feature-icon"><i class="fas fa-chart-line"></i></div>
        <h4>Analytics &amp; conversion</h4>
        <p>Tableaux de bord en temps réel, suivi des KPIs conversation, taux de conversion et rapports de satisfaction exportables en PDF mensuel.</p>
        <span class="chat-feature-tag">Reporting</span>
      </div>
    </div>
  </div>

  <!-- HOW IT WORKS -->
  <div class="chat-how">
    <div class="chat-how-inner">
      <div style="text-align:center;max-width:600px;margin:0 auto">
        <div class="section-label" style="justify-content:center">Comment ça marche</div>
        <h2 class="section-title-sans" style="text-align:center">Opérationnel en 4 étapes</h2>
        <p class="section-desc" style="margin:0 auto;text-align:center">De la connexion de vos canaux à votre première réponse unifiée, tout se passe en moins de 30 minutes.</p>
      </div>
      <div class="chat-steps">
        <div class="chat-step">
          <div class="chat-step-num">1</div>
          <h4>Connexion des canaux</h4>
          <p>Connectez WhatsApp Business, Instagram, Messenger et votre site en quelques clics sans développement.</p>
        </div>
        <div class="chat-step">
          <div class="chat-step-num">2</div>
          <h4>Configuration de l'équipe</h4>
          <p>Invitez vos agents, définissez les rôles, les horaires et les règles d'assignation automatique.</p>
        </div>
        <div class="chat-step">
          <div class="chat-step-num">3</div>
          <h4>Personnalisation IA</h4>
          <p>Entraînez l'IA avec votre FAQ, vos réponses types et vos offres pour des suggestions ultra-pertinentes.</p>
        </div>
        <div class="chat-step">
          <div class="chat-step-num">4</div>
          <h4>Répondez &amp; convertissez</h4>
          <p>Votre inbox est opérationnelle. Répondez plus vite, convertissez plus de leads, analysez vos résultats.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- INTEGRATIONS -->
  <div class="chat-integrations">
    <div class="section-label">Intégrations</div>
    <h2 class="section-title-sans">Connectez vos outils préférés</h2>
    <p class="section-desc">GoExploria Chat s'intègre nativement avec les outils que vous utilisez déjà au quotidien.</p>
    <div class="chat-integrations-grid">
      <div class="chat-integration-card">
        <div class="chat-integration-icon" style="color:#25d366"><i class="fab fa-whatsapp"></i></div>
        <div class="chat-integration-name">WhatsApp Business</div>
        <div class="chat-integration-desc">API officielle · Multi-agents</div>
      </div>
      <div class="chat-integration-card">
        <div class="chat-integration-icon" style="color:#e1306c"><i class="fab fa-instagram"></i></div>
        <div class="chat-integration-name">Instagram DM</div>
        <div class="chat-integration-desc">Direct Messages · Stories</div>
      </div>
      <div class="chat-integration-card">
        <div class="chat-integration-icon" style="color:#0084ff"><i class="fab fa-facebook-messenger"></i></div>
        <div class="chat-integration-name">Facebook Messenger</div>
        <div class="chat-integration-desc">Pages professionnelles</div>
      </div>
      <div class="chat-integration-card">
        <div class="chat-integration-icon" style="color:#e8761a"><i class="fas fa-globe"></i></div>
        <div class="chat-integration-name">Chat Site Web</div>
        <div class="chat-integration-desc">Widget personnalisable</div>
      </div>
      <div class="chat-integration-card">
        <div class="chat-integration-icon" style="color:#4285f4"><i class="fab fa-google"></i></div>
        <div class="chat-integration-name">Google Business</div>
        <div class="chat-integration-desc">Messages Google Maps</div>
      </div>
      <div class="chat-integration-card">
        <div class="chat-integration-icon" style="color:#1a1a1a"><i class="fas fa-envelope"></i></div>
        <div class="chat-integration-name">Email</div>
        <div class="chat-integration-desc">Gmail, Outlook, SMTP</div>
      </div>
      <div class="chat-integration-card">
        <div class="chat-integration-icon" style="color:#3b82f6"><i class="fas fa-database"></i></div>
        <div class="chat-integration-name">CRM</div>
        <div class="chat-integration-desc">HubSpot, Salesforce, Zoho</div>
      </div>
      <div class="chat-integration-card">
        <div class="chat-integration-icon" style="color:#10b981"><i class="fas fa-calendar-check"></i></div>
        <div class="chat-integration-name">Calendrier</div>
        <div class="chat-integration-desc">Google Cal, Calendly</div>
      </div>
    </div>
  </div>

  <!-- PRICING -->
  <div class="chat-pricing" style="display:none;">
    <div class="chat-pricing-inner">
      <div style="text-align:center;max-width:600px;margin:0 auto">
        <div class="section-label" style="justify-content:center">Tarification</div>
        <h2 class="section-title-sans" style="text-align:center">Choisissez votre plan</h2>
        <p class="section-desc" style="margin:0 auto;text-align:center">Sans engagement, sans frais cachés. Passez à l'échelle quand vous le souhaitez.</p>
      </div>
      <div class="chat-pricing-grid">
        <div class="chat-plan">
          <div class="chat-plan-name" style="color:#888">Starter</div>
          <div class="chat-plan-price"><span>$</span>49</div>
          <div class="chat-plan-period">/ mois · facturation mensuelle</div>
          <div class="chat-plan-divider"></div>
          <ul class="chat-plan-features">
            <li><i class="fas fa-check-circle"></i> 2 agents inclus</li>
            <li><i class="fas fa-check-circle"></i> 3 canaux (WhatsApp, FB, Web)</li>
            <li><i class="fas fa-check-circle"></i> 500 conversations/mois</li>
            <li><i class="fas fa-check-circle"></i> Rapports basiques</li>
            <li class="disabled"><i class="fas fa-times-circle"></i> IA assistée</li>
            <li class="disabled"><i class="fas fa-times-circle"></i> Chatbot avancé</li>
          </ul>
          <a href="#" class="chat-plan-cta">Commencer</a>
        </div>
        <div class="chat-plan featured">
          <span class="chat-plan-badge">⭐ Plus populaire</span>
          <div class="chat-plan-name">Pro</div>
          <div class="chat-plan-price"><span>$</span>149</div>
          <div class="chat-plan-period">/ mois · facturation mensuelle</div>
          <div class="chat-plan-divider"></div>
          <ul class="chat-plan-features">
            <li><i class="fas fa-check-circle"></i> 10 agents inclus</li>
            <li><i class="fas fa-check-circle"></i> Tous les canaux (4+)</li>
            <li><i class="fas fa-check-circle"></i> Conversations illimitées</li>
            <li><i class="fas fa-check-circle"></i> IA assistée complète</li>
            <li><i class="fas fa-check-circle"></i> Chatbot &amp; automation</li>
            <li><i class="fas fa-check-circle"></i> Analytics avancés</li>
          </ul>
          <a href="#" class="chat-plan-cta">Démarrer en Pro</a>
        </div>
        <div class="chat-plan">
          <div class="chat-plan-name" style="color:#888">Enterprise</div>
          <div class="chat-plan-price"><span style="font-size:20px;vertical-align:top;font-family:'DM Sans',sans-serif;font-weight:700">Sur</span></div>
          <div class="chat-plan-period">Devis personnalisé · SLA garanti</div>
          <div class="chat-plan-divider"></div>
          <ul class="chat-plan-features">
            <li><i class="fas fa-check-circle"></i> Agents illimités</li>
            <li><i class="fas fa-check-circle"></i> Canaux personnalisés</li>
            <li><i class="fas fa-check-circle"></i> SLA 99.9% uptime garanti</li>
            <li><i class="fas fa-check-circle"></i> Intégration CRM sur mesure</li>
            <li><i class="fas fa-check-circle"></i> Formation &amp; onboarding dédié</li>
            <li><i class="fas fa-check-circle"></i> Support prioritaire 24h/7j</li>
          </ul>
          <a href="#" class="chat-plan-cta">Nous contacter</a>
        </div>
      </div>
    </div>
  </div>

  <!-- CTA -->
  <div class="chat-cta">
    <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6)"><span style="background:rgba(255,255,255,0.2)"></span> Passez à l'action</div>
    <h2>Prêt à ne plus manquer<br>aucun client ?</h2>
    <p>Rejoignez plus de 800 entreprises qui utilisent GoExploria Chat pour répondre plus vite et convertir plus de leads chaque jour.</p>
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
      <a href="#" class="btn-orange" style="font-size:16px;padding:16px 40px"><i class="fas fa-rocket"></i> Essai gratuit 14 jours</a>
      <a href="#" class="btn-outline-white" style="font-size:16px;padding:16px 40px"><i class="fas fa-calendar-check"></i> Planifier une démo</a>
    </div>
    <p style="margin-top:20px;font-size:13px;color:rgba(255,255,255,0.4)">Aucune carte bancaire requise · Annulation à tout moment</p>
  </div>

</section>
@endsection

@section('scripts')
<script>
// Live counter animation
document.querySelectorAll('.chat-hero-live-badge').forEach(badge => {
  setInterval(() => {
    const count = 320 + Math.floor(Math.random() * 20);
    badge.textContent = '';
    const dot = document.createElement('span');
    dot.className = 'chat-hero-live-dot';
    badge.appendChild(dot);
    badge.append(` Système actif — ${count} conversations en cours`);
  }, 5000);
});
</script>
@endsection