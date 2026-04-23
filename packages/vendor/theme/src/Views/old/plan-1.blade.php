<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $plan->name }} — GoExploria | Solution digitale tout-en-un</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{asset('vendor/theme/css/styles.css')}}">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Inter', sans-serif;
      background: #ffffff;
      color: #1a1a2e;
    }
    
    .container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 32px;
    }
    
    /* Navigation */
    .nav-glass {
      position: sticky;
      top: 0;
      background: rgba(255,255,255,0.98);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(0,0,0,0.05);
      z-index: 1000;
      padding: 16px 0;
    }
    
    /* Hero Section - Style Minimaliste */
    .hero-minimal {
      padding: 120px 0 80px;
      background: #ffffff;
      position: relative;
      overflow: hidden;
    }
    
    .hero-minimal .accent-shape {
      position: absolute;
      top: -50%;
      right: -20%;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(99,102,241,0.08) 0%, rgba(99,102,241,0) 70%);
      border-radius: 50%;
      pointer-events: none;
    }
    
    .hero-minimal .accent-shape-2 {
      position: absolute;
      bottom: -30%;
      left: -10%;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(236,72,153,0.06) 0%, rgba(236,72,153,0) 70%);
      border-radius: 50%;
      pointer-events: none;
    }
    
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #f1f5f9;
      padding: 6px 14px;
      border-radius: 100px;
      font-size: 0.8rem;
      font-weight: 500;
      color: #4f46e5;
      margin-bottom: 28px;
    }
    
    .hero-title {
      font-size: 4rem;
      font-weight: 800;
      line-height: 1.1;
      letter-spacing: -0.02em;
      background: linear-gradient(135deg, #1a1a2e 0%, #4f46e5 50%, #ec4899 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 24px;
    }
    
    .hero-desc {
      font-size: 1.2rem;
      color: #64748b;
      line-height: 1.6;
      max-width: 500px;
      margin-bottom: 32px;
    }
    
    .btn-group {
      display: flex;
      gap: 16px;
      flex-wrap: wrap;
      margin-bottom: 48px;
    }
    
    .btn-primary {
      background: #1a1a2e;
      color: white;
      padding: 14px 32px;
      border-radius: 12px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
      background: #4f46e5;
      transform: translateY(-2px);
    }
    
    .btn-outline {
      background: transparent;
      color: #1a1a2e;
      padding: 14px 32px;
      border-radius: 12px;
      font-weight: 600;
      border: 1.5px solid #e2e8f0;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    
    .btn-outline:hover {
      border-color: #4f46e5;
      color: #4f46e5;
    }
    
    .hero-stats-grid {
      display: flex;
      gap: 40px;
    }
    
    .hero-stat-item .stat-number {
      font-size: 2rem;
      font-weight: 800;
      color: #1a1a2e;
    }
    
    .hero-stat-item .stat-label {
      font-size: 0.85rem;
      color: #94a3b8;
    }
    
    /* Section Header */
    .section-header-modern {
      text-align: center;
      max-width: 700px;
      margin: 0 auto 64px;
    }
    
    .section-tag {
      display: inline-block;
      background: #f1f5f9;
      padding: 6px 14px;
      border-radius: 100px;
      font-size: 0.8rem;
      font-weight: 500;
      color: #4f46e5;
      margin-bottom: 16px;
    }
    
    .section-title {
      font-size: 2.5rem;
      font-weight: 700;
      letter-spacing: -0.02em;
      color: #1a1a2e;
      margin-bottom: 16px;
    }
    
    .section-subtitle {
      color: #64748b;
      font-size: 1.1rem;
    }
    
    /* Service Cards - Style Horizontal Split */
    .service-split {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 64px;
      align-items: center;
      padding: 80px 0;
      border-bottom: 1px solid #f1f5f9;
    }
    
    .service-split.alt {
      direction: rtl;
    }
    
    .service-split.alt > * {
      direction: ltr;
    }
    
    .service-icon-large {
      width: 64px;
      height: 64px;
      background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 24px;
    }
    
    .service-icon-large i {
      font-size: 28px;
      color: white;
    }
    
    .service-split h3 {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 16px;
      color: #1a1a2e;
    }
    
    .service-split p {
      color: #64748b;
      line-height: 1.6;
      margin-bottom: 24px;
    }
    
    .feature-pills {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin: 24px 0;
    }
    
    .feature-pill {
      background: #f8fafc;
      padding: 8px 16px;
      border-radius: 100px;
      font-size: 0.85rem;
      color: #1e293b;
    }
    
    .stat-bubbles {
      display: flex;
      gap: 24px;
      margin: 24px 0;
    }
    
    .stat-bubble {
      text-align: center;
    }
    
    .stat-bubble .bubble-value {
      font-size: 1.5rem;
      font-weight: 800;
      color: #4f46e5;
    }
    
    .stat-bubble .bubble-label {
      font-size: 0.75rem;
      color: #94a3b8;
    }
    
    .service-media-split {
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 25px 40px -20px rgba(0,0,0,0.2);
    }
    
    .service-media-split img {
      width: 100%;
      height: 400px;
      object-fit: cover;
    }
    
    /* Pricing Card */
    .pricing-card {
      background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
      border-radius: 32px;
      padding: 48px;
      text-align: center;
      color: white;
      margin: 40px 0;
    }
    
    .pricing-card h3 {
      font-size: 2rem;
      margin-bottom: 16px;
    }
    
    .pricing-amount {
      font-size: 3.5rem;
      font-weight: 800;
      margin: 24px 0;
    }
    
    .pricing-features {
      display: flex;
      justify-content: center;
      gap: 32px;
      flex-wrap: wrap;
      margin: 32px 0;
    }
    
    /* Stats Grid */
    .stats-grid-modern {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 32px;
      background: #f8fafc;
      border-radius: 48px;
      padding: 48px;
      margin: 60px 0;
      text-align: center;
    }
    
    .stat-card-modern .stat-number {
      font-size: 2.5rem;
      font-weight: 800;
      color: #4f46e5;
    }
    
    /* CTA Banner */
    .cta-banner {
      background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
      border-radius: 48px;
      padding: 64px;
      text-align: center;
      color: white;
      margin: 60px 0;
    }
    
    .cta-banner h2 {
      font-size: 2.2rem;
      margin-bottom: 16px;
    }
    
    .btn-white {
      background: white;
      color: #4f46e5;
      padding: 14px 32px;
      border-radius: 12px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      margin-top: 24px;
      transition: transform 0.2s ease;
    }
    
    .btn-white:hover {
      transform: translateY(-2px);
    }
    
    /* Contact Section */
    .contact-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 48px;
      background: #f8fafc;
      border-radius: 48px;
      padding: 48px;
      margin: 60px 0;
    }
    
    .contact-info-item {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 24px;
    }
    
    .contact-icon-circle {
      width: 48px;
      height: 48px;
      background: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .form-modern input,
    .form-modern select,
    .form-modern textarea {
      width: 100%;
      padding: 14px 18px;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      font-family: 'Inter', sans-serif;
      transition: all 0.2s ease;
    }
    
    .form-modern input:focus,
    .form-modern select:focus,
    .form-modern textarea:focus {
      outline: none;
      border-color: #4f46e5;
      box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
    }
    
    /* Floating Button */
    .floating-chat {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: linear-gradient(135deg, #4f46e5, #ec4899);
      width: 56px;
      height: 56px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 10px 25px rgba(79,70,229,0.3);
      transition: transform 0.2s ease;
      z-index: 100;
      border: none;
    }
    
    .floating-chat:hover {
      transform: scale(1.1);
    }
    
    .floating-chat i {
      font-size: 24px;
      color: white;
    }
    
    /* Footer */
    .footer-modern {
      background: #f8fafc;
      padding: 60px 0 30px;
      margin-top: 60px;
    }
    
    @media (max-width: 768px) {
      .hero-title { font-size: 2.5rem; }
      .service-split { grid-template-columns: 1fr; gap: 32px; }
      .service-split.alt { direction: ltr; }
      .stats-grid-modern { grid-template-columns: 1fr 1fr; }
      .contact-grid { grid-template-columns: 1fr; }
      .hero-stats-grid { flex-wrap: wrap; gap: 20px; }
      .section-title { font-size: 1.8rem; }
      .pricing-card { padding: 32px; }
      .cta-banner { padding: 40px; }
    }
  </style>
</head>
<body>

  <!-- Navigation -->
  <nav class="nav-glass">
    <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
      <div class="nav-logo">
        <img src="{{asset('logo.png')}}" style="height: 40px; width: auto;"/>
      </div>
      <div class="nav-links" style="display: flex; gap: 32px; align-items: center;">
        <a href="#services" style="text-decoration: none; color: #1a1a2e; font-weight: 500;">Services</a>
        <a href="#features" style="text-decoration: none; color: #1a1a2e; font-weight: 500;">Fonctionnalités</a>
        <a href="#showcase" style="text-decoration: none; color: #1a1a2e; font-weight: 500;">Clients</a>
        <a href="#contact" style="text-decoration: none; color: #1a1a2e; font-weight: 500;">Contact</a>
        <button class="btn-primary" style="padding: 10px 24px;" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">Devis gratuit</button>
      </div>
    </div>
  </nav>

  <!-- Hero Section Minimaliste -->
  <section class="hero-minimal">
    <div class="accent-shape"></div>
    <div class="accent-shape-2"></div>
    <div class="container">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center;">
        <div>
          <div class="hero-badge">
            <i class="fas fa-crown" style="font-size: 12px;"></i>
            Plan Premium
          </div>
          <h1 class="hero-title">{{ $plan->name }}</h1>
          <p class="hero-desc">{{ $plan->description ?? 'La solution digitale tout-en-un qui propulse votre entreprise vers de nouveaux sommets.' }}</p>
          <div class="btn-group">
            <button class="btn-primary" onclick="document.getElementById('services').scrollIntoView({behavior: 'smooth'})">
              <i class="fas fa-rocket"></i> Démarrer
            </button>
            <button class="btn-outline" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">
              <i class="fas fa-headset"></i> Contact commercial
            </button>
          </div>
          <div class="hero-stats-grid">
            <div class="hero-stat-item">
              <div class="stat-number">{{ $plan->formatted_price }}</div>
              <div class="stat-label">/{{ $plan->billing_cycle ?? 'mois' }}</div>
            </div>
            <div class="hero-stat-item">
              <div class="stat-number">{{ $plan->plugins->count() }}+</div>
              <div class="stat-label">Services inclus</div>
            </div>
            <div class="hero-stat-item">
              <div class="stat-number">24/7</div>
              <div class="stat-label">Support prioritaire</div>
            </div>
          </div>
        </div>
        <div>
          <div style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 32px; padding: 32px;">
            <div style="display: flex; gap: 16px; margin-bottom: 24px; flex-wrap: wrap;">
              <span style="background: #e0e7ff; padding: 8px 16px; border-radius: 100px; font-size: 0.8rem;"><i class="fas fa-chart-line"></i> +237% visibilité</span>
              <span style="background: #e0e7ff; padding: 8px 16px; border-radius: 100px; font-size: 0.8rem;"><i class="fas fa-star"></i> 4.9★ satisfaction</span>
              <span style="background: #e0e7ff; padding: 8px 16px; border-radius: 100px; font-size: 0.8rem;"><i class="fas fa-users"></i> 3000+ clients</span>
            </div>
            <div style="background: white; border-radius: 24px; padding: 24px;">
              <h4 style="margin-bottom: 16px;">Ce que vous obtenez :</h4>
              <div style="display: flex; flex-direction: column; gap: 12px;">
                <div><i class="fas fa-check-circle" style="color: #10b981; margin-right: 12px;"></i> Accès à tous les services</div>
                <div><i class="fas fa-check-circle" style="color: #10b981; margin-right: 12px;"></i> Support prioritaire 24/7</div>
                <div><i class="fas fa-check-circle" style="color: #10b981; margin-right: 12px;"></i> Analytics avancés en temps réel</div>
                <div><i class="fas fa-check-circle" style="color: #10b981; margin-right: 12px;"></i> Mises à jour gratuites</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section - Style Split -->
  <section id="services" style="padding: 60px 0;">
    <div class="container">
      <div class="section-header-modern">
        <span class="section-tag">Nos services premium</span>
        <h2 class="section-title">Tout ce dont vous avez besoin<br>en <span style="color: #4f46e5;">un seul endroit</span></h2>
        <p class="section-subtitle">Des solutions intégrées pour booster votre activité</p>
      </div>
    </div>

    @forelse($plan->plugins as $index => $plugin)
      @php
        $isEven = $loop->iteration % 2 == 0;
        
        if(stripos($plugin->name, 'vidéo') !== false) {
          $pluginData = [
            'icon' => 'fa-map-marker-alt',
            'title' => 'Vidéo sur la carte',
            'desc' => 'Diffusez vos vidéos promotionnelles directement sur Google Maps et Apple Maps. Géolocalisation précise et analytics en temps réel.',
            'features' => ['Géolocalisation 5m', 'Rayon personnalisable', 'Stats en temps réel'],
            'stats' => [['value' => '+237%', 'label' => 'visibilité'], ['value' => '+156%', 'label' => 'conversion']],
            'images' => [
              'https://images.unsplash.com/photo-1579869847514-7c1a19d2d2ad?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1524661135-423995f22d0f?w=800&h=500&fit=crop'
            ]
          ];
        }
        elseif(stripos($plugin->name, 'site') !== false) {
          $pluginData = [
            'icon' => 'fa-laptop-code',
            'title' => 'Création site web',
            'desc' => 'Site web professionnel livré en 48h. Design unique, responsive et CMS intuitif.',
            'features' => ['Design unique', 'Responsive', 'CMS drag & drop', 'Livraison 48h'],
            'stats' => [['value' => '48h', 'label' => 'livraison'], ['value' => '100%', 'label' => 'satisfaction']],
            'images' => [
              'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1547658719-da2b51169166?w=800&h=500&fit=crop'
            ]
          ];
        }
        elseif(stripos($plugin->name, 'seo') !== false) {
          $pluginData = [
            'icon' => 'fa-chart-line',
            'title' => 'SEO & Visibilité',
            'desc' => 'Atteignez la première page de Google avec notre stratégie SEO complète.',
            'features' => ['Audit technique', 'Mots-clés stratégiques', 'Netlinking', 'Rapports mensuels'],
            'stats' => [['value' => 'Top 10', 'label' => 'mots-clés'], ['value' => '30j', 'label' => 'résultats']],
            'images' => [
              'https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1562577309-4932fdd64cd1?w=800&h=500&fit=crop'
            ]
          ];
        }
        else {
          $pluginData = [
            'icon' => 'fa-puzzle-piece',
            'title' => $plugin->name,
            'desc' => $plugin->description ?? 'Fonctionnalité premium incluse dans votre plan.',
            'features' => ['Inclus dans le plan', 'Support prioritaire', 'Mises à jour'],
            'stats' => [['value' => 'Inclus', 'label' => 'dans le plan'], ['value' => '24/7', 'label' => 'support']],
            'images' => [
              'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800&h=500&fit=crop'
            ]
          ];
        }
      @endphp

      <div class="container">
        <div class="service-split {{ $isEven ? 'alt' : '' }}">
          <div>
            <div class="service-icon-large">
              <i class="fas {{ $pluginData['icon'] }}"></i>
            </div>
            <h3>{{ $pluginData['title'] }}</h3>
            <p>{{ $pluginData['desc'] }}</p>
            <div class="feature-pills">
              @foreach($pluginData['features'] as $feature)
                <span class="feature-pill">{{ $feature }}</span>
              @endforeach
            </div>
            <div class="stat-bubbles">
              @foreach($pluginData['stats'] as $stat)
                <div class="stat-bubble">
                  <div class="bubble-value">{{ $stat['value'] }}</div>
                  <div class="bubble-label">{{ $stat['label'] }}</div>
                </div>
              @endforeach
            </div>
            <button class="btn-primary" style="margin-top: 16px;" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">
              Je veux ce service <i class="fas fa-arrow-right"></i>
            </button>
          </div>
          <div class="service-media-split">
            <div class="swiper service-swiper-split">
              <div class="swiper-wrapper">
                @foreach($pluginData['images'] as $image)
                  <div class="swiper-slide">
                    <img src="{{ $image }}" alt="{{ $pluginData['title'] }}">
                  </div>
                @endforeach
              </div>
              <div class="swiper-pagination"></div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="container" style="text-align: center; padding: 60px;">Aucun service disponible.</div>
    @endforelse
  </section>

  <!-- Section Facturation -->
  <div class="container">
    <div class="service-split alt">
      <div>
        <div class="service-icon-large">
          <i class="fas fa-file-invoice-dollar"></i>
        </div>
        <h3>Gestion facturation</h3>
        <p>Centralisez votre gestion financière. Devis, factures, relances automatiques et intégration Stripe/PayPal.</p>
        <div class="feature-pills">
          <span class="feature-pill">Devis personnalisés</span>
          <span class="feature-pill">Relances auto</span>
          <span class="feature-pill">Stripe/PayPal</span>
          <span class="feature-pill">Export comptable</span>
        </div>
        <div class="stat-bubbles">
          <div class="stat-bubble"><div class="bubble-value">-72h</div><div class="bubble-label">paiement réduit</div></div>
          <div class="stat-bubble"><div class="bubble-value">100%</div><div class="bubble-label">automatisé</div></div>
        </div>
        <button class="btn-primary" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">Je veux ce service <i class="fas fa-arrow-right"></i></button>
      </div>
      <div class="service-media-split">
        <div class="swiper service-swiper-split">
          <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=800&h=500&fit=crop" alt="Facturation"></div>
            <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1554774853-719586f82d77?w=800&h=500&fit=crop" alt="Paiement"></div>
          </div>
          <div class="swiper-pagination"></div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Section Marketplace -->
  <div class="container">
    <div class="service-split">
      <div>
        <div class="service-icon-large">
          <i class="fas fa-store"></i>
        </div>
        <h3>Marketplace intégrée</h3>
        <p>Vendez sur notre marketplace avec 50k+ visiteurs/mois. Gestion centralisée des stocks et commandes.</p>
        <div class="feature-pills">
          <span class="feature-pill">Multi-vendeurs</span>
          <span class="feature-pill">Commission 0-20%</span>
          <span class="feature-pill">Stocks temps réel</span>
          <span class="feature-pill">Support logistique</span>
        </div>
        <div class="stat-bubbles">
          <div class="stat-bubble"><div class="bubble-value">+156%</div><div class="bubble-label">ventes générées</div></div>
          <div class="stat-bubble"><div class="bubble-value">50k+</div><div class="bubble-label">visiteurs/mois</div></div>
        </div>
        <button class="btn-primary" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">Je veux ce service <i class="fas fa-arrow-right"></i></button>
      </div>
      <div class="service-media-split">
        <div class="swiper service-swiper-split">
          <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=800&h=500&fit=crop" alt="Marketplace"></div>
            <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&h=500&fit=crop" alt="Vente"></div>
          </div>
          <div class="swiper-pagination"></div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pricing Card -->
  <div class="container">
    <div class="pricing-card">
      <h3>Plan {{ $plan->name }}</h3>
      <p>La solution complète pour votre entreprise</p>
      <div class="pricing-amount">{{ $plan->formatted_price }}<span style="font-size: 1rem;">/{{ $plan->billing_cycle ?? 'mois' }}</span></div>
      <div class="pricing-features">
        <span><i class="fas fa-check-circle"></i> Support 24/7</span>
        <span><i class="fas fa-check-circle"></i> Analytics avancés</span>
        <span><i class="fas fa-check-circle"></i> Mises à jour incluses</span>
      </div>
      <button class="btn-white" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">Souscrire maintenant</button>
    </div>
  </div>

  <!-- Stats Grid -->
  <div class="container">
    <div class="stats-grid-modern">
      <div class="stat-card-modern"><div class="stat-number">3000+</div><div>Clients actifs</div></div>
      <div class="stat-card-modern"><div class="stat-number">4.9★</div><div>Satisfaction client</div></div>
      <div class="stat-card-modern"><div class="stat-number">98%</div><div>Taux de rétention</div></div>
      <div class="stat-card-modern"><div class="stat-number">24/7</div><div>Support disponible</div></div>
    </div>
  </div>

  <!-- CTA Banner -->
  <div class="container">
    <div class="cta-banner">
      <h2>Prêt à transformer votre activité ?</h2>
      <p>Rejoignez plus de 3000 entreprises qui nous font confiance</p>
      <button class="btn-white" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">
        <i class="fas fa-calendar-check"></i> Demander une démo gratuite
      </button>
    </div>
  </div>

  <!-- Showcase Section -->
  <section id="showcase" style="padding: 60px 0;">
    <div class="container">
      <div class="section-header-modern">
        <span class="section-tag">Ils nous font confiance</span>
        <h2 class="section-title">+3000 <span style="color: #4f46e5;">clients satisfaits</span></h2>
      </div>
      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px;">
        <div style="border-radius: 24px; overflow: hidden; position: relative;">
          <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=600&h=400&fit=crop" style="width:100%; height:280px; object-fit:cover;">
          <div style="position: absolute; inset:0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); display: flex; align-items: flex-end; padding: 24px;">
            <div style="color: white;"><h4>Le Petit Bistro</h4><p>+156% de réservations</p></div>
          </div>
        </div>
        <div style="border-radius: 24px; overflow: hidden; position: relative;">
          <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600&h=400&fit=crop" style="width:100%; height:280px; object-fit:cover;">
          <div style="position: absolute; inset:0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); display: flex; align-items: flex-end; padding: 24px;">
            <div style="color: white;"><h4>La Maison du Café</h4><p>+89% de clients</p></div>
          </div>
        </div>
        <div style="border-radius: 24px; overflow: hidden; position: relative;">
          <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=600&h=400&fit=crop" style="width:100%; height:280px; object-fit:cover;">
          <div style="position: absolute; inset:0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); display: flex; align-items: flex-end; padding: 24px;">
            <div style="color: white;"><h4>Immobilier Premium</h4><p>+234 leads/mois</p></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact">
    <div class="container">
      <div class="contact-grid">
        <div>
          <span class="section-tag" style="margin-bottom: 16px;">Contactez-nous</span>
          <h2 style="font-size: 2rem; margin-bottom: 16px;">Parlons de <span style="color: #4f46e5;">votre projet</span></h2>
          <p style="color: #64748b; margin-bottom: 32px;">Notre équipe vous répond sous 24h.</p>
          <div class="contact-info-item">
            <div class="contact-icon-circle"><i class="fas fa-envelope" style="color: #4f46e5;"></i></div>
            <div><strong>Email</strong><br>hello@goexploria.com</div>
          </div>
          <div class="contact-info-item">
            <div class="contact-icon-circle"><i class="fas fa-phone" style="color: #4f46e5;"></i></div>
            <div><strong>Téléphone</strong><br>+1 (514) 555-9210</div>
          </div>
          <div class="contact-info-item">
            <div class="contact-icon-circle"><i class="fas fa-map-marker-alt" style="color: #4f46e5;"></i></div>
            <div><strong>Adresse</strong><br>123 rue Saint-Denis, Montréal, QC</div>
          </div>
        </div>
        <div>
          <form class="form-modern" style="display: flex; flex-direction: column; gap: 16px;">
            <input type="text" placeholder="Votre nom">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
              <input type="email" placeholder="Email">
              <input type="tel" placeholder="Téléphone">
            </div>
            <select>
              <option>Service souhaité</option>
              @foreach($plan->plugins as $plugin)
                <option>{{ $plugin->name }}</option>
              @endforeach
              <option>Gestion facturation</option>
              <option>Marketplace</option>
            </select>
            <textarea rows="4" placeholder="Décrivez votre projet..."></textarea>
            <button class="btn-primary" style="width: 100%;">Envoyer le message <i class="fas fa-paper-plane"></i></button>
            <p style="text-align: center; font-size: 0.8rem; color: #94a3b8;">Sans engagement · Démo gratuite · Réponse sous 24h</p>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Floating Chat Button -->
  <button class="floating-chat" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">
    <i class="fas fa-comment-dots"></i>
  </button>

  <!-- Footer -->
  <footer class="footer-modern">
    <div class="container">
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 48px;">
        <div>
          <div style="font-size: 1.5rem; font-weight: 700; margin-bottom: 16px;">Go<span style="color: #4f46e5;">Exploria</span></div>
          <p style="color: #64748b;">La plateforme tout-en-un pour les professionnels.</p>
        </div>
        <div>
          <h4 style="margin-bottom: 16px;">Services</h4>
          @foreach($plan->plugins->take(4) as $plugin)
            <a href="#" style="display: block; margin-bottom: 8px; color: #64748b; text-decoration: none;">{{ $plugin->name }}</a>
          @endforeach
        </div>
        <div>
          <h4 style="margin-bottom: 16px;">Ressources</h4>
          <a href="#" style="display: block; margin-bottom: 8px; color: #64748b; text-decoration: none;">Blog</a>
          <a href="#" style="display: block; margin-bottom: 8px; color: #64748b; text-decoration: none;">Documentation</a>
          <a href="#" style="display: block; margin-bottom: 8px; color: #64748b; text-decoration: none;">Support</a>
        </div>
        <div>
          <h4 style="margin-bottom: 16px;">Légal</h4>
          <a href="#" style="display: block; margin-bottom: 8px; color: #64748b; text-decoration: none;">CGU</a>
          <a href="#" style="display: block; margin-bottom: 8px; color: #64748b; text-decoration: none;">Confidentialité</a>
          <a href="#" style="display: block; margin-bottom: 8px; color: #64748b; text-decoration: none;">Mentions légales</a>
        </div>
      </div>
      <div style="text-align: center; padding-top: 48px; margin-top: 48px; border-top: 1px solid #e2e8f0;">
        <p style="color: #94a3b8;">© 2026 GoExploria — Tous droits réservés</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    document.querySelectorAll('.service-swiper-split').forEach(swiperEl => {
      const slides = swiperEl.querySelectorAll('.swiper-slide');
      new Swiper(swiperEl, {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: slides.length >= 2,
        autoplay: slides.length >= 2 ? { delay: 4000, disableOnInteraction: false } : false,
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }
      });
    });
  </script>
</body>
</html> 

