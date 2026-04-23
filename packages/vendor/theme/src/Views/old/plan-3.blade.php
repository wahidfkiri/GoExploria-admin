<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GoExploria — Solution digitale tout-en-un</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #ffffff;
      color: #1e293b;
    }

    .container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 32px;
    }

    /* Navigation */
    .nav {
      position: sticky;
      top: 0;
      background: rgba(255,255,255,0.98);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid #e2e8f0;
      z-index: 1000;
      padding: 16px 0;
    }

    .nav-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .nav-links {
      display: flex;
      gap: 32px;
      align-items: center;
    }

    .nav-link {
      text-decoration: none;
      color: #475569;
      font-weight: 500;
      transition: color 0.2s;
    }

    .nav-link:hover {
      color: #4f46e5;
    }

    .btn-primary {
      background: linear-gradient(135deg, #4f46e5, #7c3aed);
      color: white;
      padding: 10px 24px;
      border-radius: 100px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: all 0.2s;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px -5px rgba(79,70,229,0.3);
    }

    /* Hero Section */
    .hero {
      background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
      padding: 80px 0;
    }

    .hero-content {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 48px;
      align-items: center;
    }

    .hero-badge {
      display: inline-block;
      background: #e0e7ff;
      padding: 6px 14px;
      border-radius: 100px;
      font-size: 0.8rem;
      font-weight: 600;
      color: #4f46e5;
      margin-bottom: 24px;
    }

    .hero-title {
      font-size: 3rem;
      font-weight: 800;
      line-height: 1.2;
      margin-bottom: 20px;
    }

    .gradient-text {
      background: linear-gradient(135deg, #4f46e5, #ec4899);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .hero-desc {
      color: #64748b;
      line-height: 1.6;
      margin-bottom: 32px;
    }

    .hero-stats {
      display: flex;
      gap: 32px;
      margin-top: 40px;
    }

    .hero-stat .value {
      font-size: 1.5rem;
      font-weight: 800;
      color: #1e293b;
    }

    .hero-stat .label {
      font-size: 0.8rem;
      color: #64748b;
    }

    /* Section Solution Horizontale */
    .solution-section {
      padding: 60px 0;
      background: #ffffff;
    }

    .section-header {
      text-align: center;
      margin-bottom: 48px;
    }

    .section-tag {
      display: inline-block;
      background: #e0e7ff;
      padding: 4px 12px;
      border-radius: 100px;
      font-size: 0.7rem;
      font-weight: 600;
      color: #4f46e5;
      margin-bottom: 16px;
    }

    .section-title {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 12px;
    }

    .section-subtitle {
      color: #64748b;
    }

    /* Scroll horizontal */
    .scroll-container {
      position: relative;
    }

    .scroll-wrapper {
      display: flex;
      overflow-x: auto;
      scroll-behavior: smooth;
      gap: 24px;
      padding: 16px 8px 24px 8px;
      scrollbar-width: thin;
    }

    .scroll-wrapper::-webkit-scrollbar {
      height: 6px;
    }

    .scroll-wrapper::-webkit-scrollbar-track {
      background: #e2e8f0;
      border-radius: 10px;
    }

    .scroll-wrapper::-webkit-scrollbar-thumb {
      background: #4f46e5;
      border-radius: 10px;
    }

    .scroll-arrow {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 44px;
      height: 44px;
      background: white;
      border: 1px solid #e2e8f0;
      border-radius: 50%;
      color: #4f46e5;
      cursor: pointer;
      z-index: 10;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .scroll-arrow:hover {
      background: #4f46e5;
      color: white;
      border-color: #4f46e5;
    }

    .scroll-arrow.left {
      left: -20px;
    }

    .scroll-arrow.right {
      right: -20px;
    }

    /* Carte Plan */
    .plan-card {
      min-width: 300px;
      background: linear-gradient(135deg, #1e293b, #0f172a);
      border-radius: 24px;
      padding: 24px;
      flex-shrink: 0;
      position: relative;
      overflow: hidden;
    }

    .plan-card::before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 100px;
      height: 100px;
      background: radial-gradient(circle, rgba(79,70,229,0.2) 0%, transparent 70%);
      pointer-events: none;
    }

    .plan-icon {
      width: 56px;
      height: 56px;
      background: linear-gradient(135deg, #4f46e5, #7c3aed);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
    }

    .plan-icon i {
      font-size: 28px;
      color: white;
    }

    .plan-name {
      color: white;
      font-size: 1.3rem;
      font-weight: 700;
      margin-bottom: 8px;
    }

    .plan-price {
      font-size: 1.8rem;
      font-weight: 800;
      color: #fbbf24;
      margin: 16px 0;
    }

    .plan-price span {
      font-size: 0.9rem;
      color: #94a3b8;
      font-weight: 400;
    }

    .plan-feature {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 12px 0;
      color: #cbd5e1;
      font-size: 0.85rem;
    }

    .plan-feature i {
      color: #22c55e;
      font-size: 14px;
    }

    .plan-badge {
      display: inline-block;
      background: rgba(251,191,36,0.2);
      padding: 4px 12px;
      border-radius: 100px;
      font-size: 0.7rem;
      color: #fbbf24;
      margin-top: 12px;
    }

    /* Carte App */
    .app-card {
      min-width: 220px;
      background: white;
      border-radius: 20px;
      padding: 20px;
      flex-shrink: 0;
      border: 1px solid #e2e8f0;
      transition: all 0.3s ease;
      text-align: center;
    }

    .app-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 20px 30px -10px rgba(0,0,0,0.1);
      border-color: #4f46e5;
    }

    .app-icon {
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, #e0e7ff, #ede9fe);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 16px;
    }

    .app-icon i {
      font-size: 28px;
      color: #4f46e5;
    }

    .app-name {
      font-weight: 700;
      margin-bottom: 8px;
    }

    .app-desc {
      font-size: 0.75rem;
      color: #94a3b8;
    }

    /* CTA Section */
    .cta-section {
      background: linear-gradient(135deg, #0f172a, #1e293b);
      padding: 60px 0;
      text-align: center;
    }

    .cta-section h2 {
      color: white;
      font-size: 2rem;
      margin-bottom: 16px;
    }

    .cta-section p {
      color: #94a3b8;
      margin-bottom: 32px;
    }

    .btn-cta {
      background: linear-gradient(135deg, #fbbf24, #f59e0b);
      color: #0f172a;
      padding: 14px 32px;
      border-radius: 100px;
      font-weight: 700;
      border: none;
      cursor: pointer;
    }

    /* Footer */
    .footer {
      background: #f8fafc;
      padding: 48px 0 24px;
      border-top: 1px solid #e2e8f0;
    }

    .footer-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 48px;
      margin-bottom: 48px;
    }

    .footer-logo {
      font-size: 1.3rem;
      font-weight: 800;
    }

    .footer-links h4 {
      margin-bottom: 16px;
      font-size: 1rem;
    }

    .footer-links a {
      display: block;
      color: #64748b;
      text-decoration: none;
      margin-bottom: 8px;
      font-size: 0.85rem;
    }

    .footer-bottom {
      text-align: center;
      padding-top: 24px;
      border-top: 1px solid #e2e8f0;
      font-size: 0.8rem;
      color: #94a3b8;
    }

    @media (max-width: 768px) {
      .hero-content { grid-template-columns: 1fr; text-align: center; }
      .hero-stats { justify-content: center; }
      .scroll-arrow { display: none; }
      .scroll-wrapper { padding: 16px 16px 24px; }
      .section-title { font-size: 1.5rem; }
    }
  </style>
</head>
<body>



 <!-- SECTION : SOLUTION COMPLÈTE AVEC TEXTE LONG ET CARTES DESIGN -->
<section class="solution-section" id="solution" style="padding: 80px 0; background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);">
  <div class="container">
    
    <!-- En-tête section -->
    <div class="section-header" style="text-align: center; max-width: 800px; margin: 0 auto 48px;">
      <span class="section-tag" style="background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; padding: 6px 16px; border-radius: 100px; font-size: 0.75rem; font-weight: 600;">
        🚀 SOLUTION INTÉGRÉE
      </span>
      <h2 class="section-title" style="font-size: 2.5rem; font-weight: 800; margin-top: 20px;">
        Tout votre <span class="gradient-text">digital</span> en une seule plateforme
      </h2>
      <p class="section-subtitle" style="color: #64748b; margin-top: 16px;">
        Découvrez notre plan <strong>{{ $plan->name }}</strong> et toutes les applications incluses
      </p>
    </div>

    <!-- TEXTE LONG - Présentation détaillée -->
    <div style="max-width: 900px; margin: 0 auto 60px auto; text-align: center;">
      <div style="background: #f1f5f9; border-radius: 24px; padding: 32px; border-left: 4px solid #4f46e5;">
        <i class="fas fa-quote-left" style="color: #4f46e5; font-size: 2rem; opacity: 0.5; margin-bottom: 16px; display: block;"></i>
        <p style="color: #334155; line-height: 1.8; font-size: 1.05rem;">
          Avec <strong>{{ $plan->name }}</strong>, nous avons repensé la manière dont les entreprises abordent leur transformation digitale. 
          Fini les solutions éparpillées et les outils qui ne communiquent pas entre eux. Notre plateforme tout-en-un centralise 
          l'ensemble de vos besoins : <strong>marketing, communication, gestion financière et visibilité en ligne</strong>. 
          Que vous soyez une TPE, une PME ou une grande entreprise, notre solution s'adapte à votre croissance et évolue avec vous. 
          Bénéficiez d'une <strong>interface unifiée</strong>, d'un <strong>support prioritaire 24/7</strong> et d'<strong>analytics avancés</strong> 
          pour piloter votre activité en toute sérénité. Rejoignez les <strong>3000+ entreprises</strong> qui nous font déjà confiance 
          et découvrez la différence d'une solution véritablement intégrée.
        </p>
        <div style="display: flex; justify-content: center; gap: 24px; margin-top: 24px; flex-wrap: wrap;">
          <div style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-check-circle" style="color: #22c55e;"></i><span style="font-size: 0.85rem;">Interface unifiée</span></div>
          <div style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-check-circle" style="color: #22c55e;"></i><span style="font-size: 0.85rem;">Support prioritaire</span></div>
          <div style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-check-circle" style="color: #22c55e;"></i><span style="font-size: 0.85rem;">Analytics avancés</span></div>
          <div style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-check-circle" style="color: #22c55e;"></i><span style="font-size: 0.85rem;">Évolutif</span></div>
        </div>
      </div>
    </div>

    <!-- Scroll horizontal avec cartes apps design -->
    <div class="scroll-container" style="position: relative;">
      
      <!-- Flèches navigation -->
      <button class="scroll-arrow left" id="scrollLeft" style="position: absolute; left: -20px; top: 50%; transform: translateY(-50%); width: 44px; height: 44px; background: white; border: 1px solid #e2e8f0; border-radius: 50%; color: #4f46e5; cursor: pointer; z-index: 10; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <i class="fas fa-chevron-left"></i>
      </button>
      <button class="scroll-arrow right" id="scrollRight" style="position: absolute; right: -20px; top: 50%; transform: translateY(-50%); width: 44px; height: 44px; background: white; border: 1px solid #e2e8f0; border-radius: 50%; color: #4f46e5; cursor: pointer; z-index: 10; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <i class="fas fa-chevron-right"></i>
      </button>

      <div class="scroll-wrapper" id="scrollWrapper" style="display: flex; overflow-x: auto; scroll-behavior: smooth; gap: 24px; padding: 16px 8px 32px 8px; scrollbar-width: thin;">
        
        <!-- CARTE PLAN PRINCIPAL -->
        <div style="min-width: 320px; background: linear-gradient(135deg, #1e293b, #0f172a); border-radius: 28px; padding: 28px; flex-shrink: 0; position: relative; overflow: hidden; box-shadow: 0 20px 35px -10px rgba(0,0,0,0.2);">
          <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: radial-gradient(circle, rgba(79,70,229,0.3) 0%, transparent 70%); border-radius: 50%;"></div>
          <div class="plan-icon" style="width: 60px; height: 60px; background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <i class="fas fa-crown" style="font-size: 28px; color: white;"></i>
          </div>
          <div class="plan-name" style="color: white; font-size: 1.4rem; font-weight: 700;">{{ $plan->name }}</div>
          <div class="plan-price" style="font-size: 2rem; font-weight: 800; color: #fbbf24; margin: 16px 0;">{{ $plan->formatted_price }}<span style="font-size: 0.9rem; color: #94a3b8;">/{{ $plan->billing_cycle ?? 'mois' }}</span></div>
          <div style="margin: 16px 0;">
            <div style="display: flex; align-items: center; gap: 10px; margin: 10px 0; color: #cbd5e1;"><i class="fas fa-check-circle" style="color: #22c55e;"></i> Support prioritaire 24/7</div>
            <div style="display: flex; align-items: center; gap: 10px; margin: 10px 0; color: #cbd5e1;"><i class="fas fa-check-circle" style="color: #22c55e;"></i> Analytics avancés</div>
            <div style="display: flex; align-items: center; gap: 10px; margin: 10px 0; color: #cbd5e1;"><i class="fas fa-check-circle" style="color: #22c55e;"></i> Mises à jour incluses</div>
          </div>
          @if($plan->is_popular)
            <div style="display: inline-block; background: rgba(251,191,36,0.2); padding: 4px 12px; border-radius: 100px; font-size: 0.7rem; color: #fbbf24;">⭐ Plan le plus populaire</div>
          @endif
          <button class="btn-primary" style="width: 100%; margin-top: 20px; background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #0f172a;" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">Choisir ce plan →</button>
        </div>

        <!-- CARTES APPLICATIONS - Style moderne -->
        @foreach($plan->plugins as $plugin)
          @php
            $icons = [
              'vidéo' => ['icon' => 'fa-map-marker-alt', 'color' => '#10b981', 'bg' => '#d1fae5'],
              'site' => ['icon' => 'fa-laptop-code', 'color' => '#3b82f6', 'bg' => '#dbeafe'],
              'seo' => ['icon' => 'fa-chart-line', 'color' => '#f59e0b', 'bg' => '#fed7aa'],
              'mail' => ['icon' => 'fa-envelope-open-text', 'color' => '#ec4899', 'bg' => '#fce7f3'],
              'chat' => ['icon' => 'fa-comments', 'color' => '#8b5cf6', 'bg' => '#ede9fe'],
              'facture' => ['icon' => 'fa-file-invoice-dollar', 'color' => '#ef4444', 'bg' => '#fee2e2'],
              'marketplace' => ['icon' => 'fa-store', 'color' => '#06b6d4', 'bg' => '#cffafe'],
            ];
            $iconData = ['icon' => 'fa-puzzle-piece', 'color' => '#4f46e5', 'bg' => '#e0e7ff'];
            foreach($icons as $key => $ic) {
              if(stripos($plugin->name, $key) !== false) { $iconData = $ic; break; }
            }
          @endphp
          <div class="app-card-modern" style="min-width: 280px; background: white; border-radius: 24px; padding: 24px; flex-shrink: 0; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); transition: all 0.3s ease; border: 1px solid #f1f5f9;">
            <div class="app-icon-modern" style="width: 56px; height: 56px; background: {{ $iconData['bg'] }}; border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
              <i class="fas {{ $iconData['icon'] }}" style="font-size: 24px; color: {{ $iconData['color'] }};"></i>
            </div>
            <h3 class="app-name" style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">{{ $plugin->name }}</h3>
            <p class="app-desc" style="color: #64748b; font-size: 0.85rem; line-height: 1.5; margin-bottom: 16px;">{{ $plugin->description ?? 'Application premium incluse dans votre plan pour booster votre productivité.' }}</p>
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 0.7rem; color: #22c55e;"><i class="fas fa-check-circle"></i> Inclus</span>
              <span style="font-size: 0.7rem; color: #94a3b8;"><i class="fas fa-infinity"></i> Illimité</span>
            </div>
          </div>
        @endforeach

        <!-- CARTES SUPPLEMENTAIRES -->
        <div class="app-card-modern" style="min-width: 280px; background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 24px; padding: 24px; flex-shrink: 0; color: white;">
          <div class="app-icon-modern" style="width: 56px; height: 56px; background: rgba(255,255,255,0.2); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <i class="fas fa-file-invoice-dollar" style="font-size: 24px; color: white;"></i>
          </div>
          <h3 class="app-name" style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">Gestion facturation</h3>
          <p class="app-desc" style="color: rgba(255,255,255,0.8); font-size: 0.85rem; line-height: 1.5; margin-bottom: 16px;">Devis, factures, relances automatiques et intégration Stripe/PayPal.</p>
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 0.7rem; color: #fbbf24;"><i class="fas fa-gem"></i> Premium</span>
            <span style="font-size: 0.7rem;"><i class="fas fa-arrow-right"></i></span>
          </div>
        </div>

        <div class="app-card-modern" style="min-width: 280px; background: white; border-radius: 24px; padding: 24px; flex-shrink: 0; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
          <div class="app-icon-modern" style="width: 56px; height: 56px; background: #cffafe; border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <i class="fas fa-store" style="font-size: 24px; color: #06b6d4;"></i>
          </div>
          <h3 class="app-name" style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">Marketplace intégrée</h3>
          <p class="app-desc" style="color: #64748b; font-size: 0.85rem; line-height: 1.5; margin-bottom: 16px;">Vendez sur notre marketplace avec 50k+ visiteurs mensuels. Commission personnalisable.</p>
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 0.7rem; color: #22c55e;"><i class="fas fa-check-circle"></i> Inclus</span>
            <span style="font-size: 0.7rem; color: #94a3b8;">0-20% commission</span>
          </div>
        </div>

        <div class="app-card-modern" style="min-width: 280px; background: white; border-radius: 24px; padding: 24px; flex-shrink: 0; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
          <div class="app-icon-modern" style="width: 56px; height: 56px; background: #fce7f3; border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <i class="fas fa-robot" style="font-size: 24px; color: #ec4899;"></i>
          </div>
          <h3 class="app-name" style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">Assistant IA</h3>
          <p class="app-desc" style="color: #64748b; font-size: 0.85rem; line-height: 1.5; margin-bottom: 16px;">Chatbot intelligent disponible 24/7 pour répondre à vos clients automatiquement.</p>
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 0.7rem; color: #22c55e;"><i class="fas fa-check-circle"></i> Inclus</span>
            <span style="font-size: 0.7rem; color: #94a3b8;">24/7</span>
          </div>
        </div>

        <div class="app-card-modern" style="min-width: 280px; background: white; border-radius: 24px; padding: 24px; flex-shrink: 0; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
          <div class="app-icon-modern" style="width: 56px; height: 56px; background: #fed7aa; border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <i class="fas fa-chart-simple" style="font-size: 24px; color: #f59e0b;"></i>
          </div>
          <h3 class="app-name" style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">Analytics Pro</h3>
          <p class="app-desc" style="color: #64748b; font-size: 0.85rem; line-height: 1.5; margin-bottom: 16px;">Tableaux de bord en temps réel, rapports personnalisables et KPIs avancés.</p>
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 0.7rem; color: #22c55e;"><i class="fas fa-check-circle"></i> Inclus</span>
            <span style="font-size: 0.7rem; color: #94a3b8;">Temps réel</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Indicateur de défilement -->
    <div style="text-align: center; margin-top: 32px;">
      <div style="display: flex; justify-content: center; gap: 8px; margin-bottom: 12px;">
        <span style="display: inline-block; width: 30px; height: 3px; background: #4f46e5; border-radius: 2px;"></span>
        <span style="display: inline-block; width: 30px; height: 3px; background: #cbd5e1; border-radius: 2px;"></span>
        <span style="display: inline-block; width: 30px; height: 3px; background: #cbd5e1; border-radius: 2px;"></span>
      </div>
      <p style="font-size: 0.75rem; color: #94a3b8;">
        <i class="fas fa-arrows-left-right"></i> Faites défiler pour découvrir toutes les applications incluses
      </p>
    </div>

    <!-- Bouton CTA supplémentaire -->
    <div style="text-align: center; margin-top: 40px;">
      <button class="btn-primary" style="padding: 14px 32px; font-size: 1rem;" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">
        <i class="fas fa-rocket"></i> Découvrir toutes les fonctionnalités
      </button>
    </div>
  </div>
</section>

<style>
  .app-card-modern {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .app-card-modern:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 30px -10px rgba(0,0,0,0.15);
  }
  .scroll-arrow:hover {
    background: #4f46e5;
    color: white;
    border-color: #4f46e5;
  }
  @media (max-width: 768px) {
    .scroll-arrow { display: none; }
    .scroll-wrapper { padding: 16px 16px 32px; }
    .section-title { font-size: 1.8rem !important; }
  }
</style>

<script>
  // Scroll horizontal
  const wrapper = document.getElementById('scrollWrapper');
  const leftBtn = document.getElementById('scrollLeft');
  const rightBtn = document.getElementById('scrollRight');

  if (wrapper && leftBtn && rightBtn) {
    leftBtn.addEventListener('click', () => {
      wrapper.scrollBy({ left: -300, behavior: 'smooth' });
    });
    rightBtn.addEventListener('click', () => {
      wrapper.scrollBy({ left: 300, behavior: 'smooth' });
    });
  }
</script>


 

  <script>
    // Scroll horizontal
    const wrapper = document.getElementById('scrollWrapper');
    const leftBtn = document.getElementById('scrollLeft');
    const rightBtn = document.getElementById('scrollRight');

    if (wrapper && leftBtn && rightBtn) {
      leftBtn.addEventListener('click', () => {
        wrapper.scrollBy({ left: -280, behavior: 'smooth' });
      });
      rightBtn.addEventListener('click', () => {
        wrapper.scrollBy({ left: 280, behavior: 'smooth' });
      });
    }

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href !== '#') {
          e.preventDefault();
          const target = document.querySelector(href);
          if (target) target.scrollIntoView({ behavior: 'smooth' });
        }
      });
    });
  </script>
</body>
</html>