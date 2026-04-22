<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $plan->name }} — GoExploria | Excellence digitale</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #ffffff;
      color: #0a0a1a;
      scroll-behavior: smooth;
    }

    .container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 32px;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
    }
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }
    ::-webkit-scrollbar-thumb {
      background: linear-gradient(135deg, #4f46e5, #ec4899);
      border-radius: 4px;
    }

    /* Navigation Premium */
    .nav-premium {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(0,0,0,0.05);
      z-index: 1000;
      padding: 16px 0;
      transition: all 0.3s ease;
    }

    .nav-premium.scrolled {
      padding: 12px 0;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    /* Hero Section Premium */
    .hero-premium {
      min-height: 100vh;
      display: flex;
      align-items: center;
      position: relative;
      overflow: hidden;
      background: linear-gradient(135deg, #fefce8 0%, #fef3c7 50%, #fce7f3 100%);
      padding-top: 80px;
    }

    .hero-premium .orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(60px);
      opacity: 0.4;
      pointer-events: none;
    }

    .orb-1 {
      top: -100px;
      right: -100px;
      width: 400px;
      height: 400px;
      background: #4f46e5;
    }

    .orb-2 {
      bottom: -100px;
      left: -100px;
      width: 350px;
      height: 350px;
      background: #ec4899;
    }

    .orb-3 {
      top: 50%;
      left: 30%;
      width: 200px;
      height: 200px;
      background: #f59e0b;
    }

    .hero-badge-premium {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255,255,255,0.8);
      backdrop-filter: blur(10px);
      padding: 8px 20px;
      border-radius: 100px;
      font-size: 0.85rem;
      font-weight: 600;
      color: #4f46e5;
      margin-bottom: 28px;
      border: 1px solid rgba(79,70,229,0.2);
    }

    .hero-title-premium {
      font-size: 4.5rem;
      font-weight: 800;
      line-height: 1.1;
      letter-spacing: -0.03em;
      margin-bottom: 24px;
    }

    .gradient-premium {
      background: linear-gradient(135deg, #4f46e5 0%, #ec4899 50%, #f59e0b 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .hero-desc-premium {
      font-size: 1.2rem;
      color: #4b5563;
      line-height: 1.6;
      max-width: 500px;
      margin-bottom: 32px;
    }

    .btn-premium-primary {
      background: #0a0a1a;
      color: white;
      padding: 16px 36px;
      border-radius: 100px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 1rem;
    }

    .btn-premium-primary:hover {
      background: #4f46e5;
      transform: translateY(-2px);
      box-shadow: 0 20px 30px -10px rgba(79,70,229,0.4);
    }

    .btn-premium-secondary {
      background: transparent;
      color: #0a0a1a;
      padding: 16px 36px;
      border-radius: 100px;
      font-weight: 600;
      border: 2px solid #e5e7eb;
      cursor: pointer;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-premium-secondary:hover {
      border-color: #4f46e5;
      color: #4f46e5;
    }

    /* Trust Badges */
    .trust-badges {
      display: flex;
      gap: 32px;
      margin-top: 48px;
      flex-wrap: wrap;
    }

    .trust-item {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .trust-item .icon {
      width: 40px;
      height: 40px;
      background: white;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    /* Section Header Premium */
    .section-header-premium {
      text-align: center;
      max-width: 700px;
      margin: 0 auto 64px;
    }

    .section-tag-premium {
      display: inline-block;
      background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
      padding: 6px 16px;
      border-radius: 100px;
      font-size: 0.75rem;
      font-weight: 600;
      color: white;
      margin-bottom: 20px;
    }

    .section-title-premium {
      font-size: 2.8rem;
      font-weight: 700;
      letter-spacing: -0.02em;
      margin-bottom: 20px;
    }

    /* Service Cards Premium */
    .service-card-premium {
      background: white;
      border-radius: 32px;
      padding: 48px;
      margin-bottom: 40px;
      transition: all 0.4s ease;
      border: 1px solid rgba(0,0,0,0.05);
    }

    .service-card-premium:hover {
      transform: translateY(-8px);
      box-shadow: 0 40px 60px -20px rgba(0,0,0,0.15);
    }

    .service-card-premium.alt {
      background: linear-gradient(135deg, #faf5ff 0%, #fefce8 100%);
    }

    .service-card-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 48px;
      align-items: center;
    }

    .service-card-grid.reverse {
      direction: rtl;
    }

    .service-card-grid.reverse > * {
      direction: ltr;
    }

    .service-icon-premium {
      width: 70px;
      height: 70px;
      background: linear-gradient(135deg, #4f46e5, #ec4899);
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 24px;
    }

    .service-icon-premium i {
      font-size: 32px;
      color: white;
    }

    .service-title-premium {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 16px;
    }

    .service-desc-premium {
      color: #6b7280;
      line-height: 1.7;
      margin-bottom: 24px;
    }

    .features-grid-premium {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin: 24px 0;
    }

    .feature-chip {
      background: #f3f4f6;
      padding: 8px 16px;
      border-radius: 100px;
      font-size: 0.85rem;
      font-weight: 500;
      color: #374151;
    }

    .stats-row {
      display: flex;
      gap: 32px;
      margin: 24px 0;
    }

    .stat-premium {
      text-align: left;
    }

    .stat-premium .value {
      font-size: 1.8rem;
      font-weight: 800;
      background: linear-gradient(135deg, #4f46e5, #ec4899);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .stat-premium .label {
      font-size: 0.8rem;
      color: #9ca3af;
    }

    .service-media-premium {
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 25px 40px -20px rgba(0,0,0,0.2);
    }

    .service-media-premium img {
      width: 100%;
      height: 380px;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .service-media-premium:hover img {
      transform: scale(1.05);
    }

    /* Pricing Section */
    .pricing-premium {
      background: linear-gradient(135deg, #0a0a1a 0%, #1a1a2e 100%);
      border-radius: 48px;
      padding: 64px;
      text-align: center;
      margin: 60px 0;
    }

    .pricing-badge {
      background: rgba(255,255,255,0.1);
      display: inline-block;
      padding: 6px 16px;
      border-radius: 100px;
      font-size: 0.8rem;
      color: #f59e0b;
      margin-bottom: 24px;
    }

    .pricing-premium .amount {
      font-size: 4rem;
      font-weight: 800;
      color: white;
      margin: 20px 0;
    }

    .pricing-premium .features-list {
      display: flex;
      justify-content: center;
      gap: 32px;
      flex-wrap: wrap;
      margin: 32px 0;
      color: #9ca3af;
    }

    /* Stats Grid Premium */
    .stats-premium-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 32px;
      background: #faf5ff;
      border-radius: 48px;
      padding: 48px;
      text-align: center;
      margin: 60px 0;
    }

    .stat-premium-card .number {
      font-size: 2.5rem;
      font-weight: 800;
      background: linear-gradient(135deg, #4f46e5, #ec4899);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    /* CTA Premium */
    .cta-premium {
      background: linear-gradient(135deg, #4f46e5, #ec4899);
      border-radius: 48px;
      padding: 64px;
      text-align: center;
      color: white;
      margin: 60px 0;
    }

    .btn-cta-premium {
      background: white;
      color: #4f46e5;
      padding: 16px 40px;
      border-radius: 100px;
      font-weight: 700;
      border: none;
      cursor: pointer;
      margin-top: 24px;
      transition: all 0.3s ease;
    }

    .btn-cta-premium:hover {
      transform: translateY(-2px);
      box-shadow: 0 20px 30px -10px rgba(0,0,0,0.2);
    }

    /* Testimonials */
    .testimonial-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 32px;
      margin: 48px 0;
    }

    .testimonial-card {
      background: white;
      border-radius: 24px;
      padding: 32px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.05);
      border: 1px solid rgba(0,0,0,0.05);
    }

    /* Contact Section Premium */
    .contact-premium {
      background: #faf5ff;
      border-radius: 48px;
      padding: 48px;
      margin: 60px 0;
    }

    .contact-premium-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 48px;
    }

    /* Floating Action */
    .fab-premium {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: linear-gradient(135deg, #4f46e5, #ec4899);
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 10px 25px rgba(79,70,229,0.4);
      transition: all 0.3s ease;
      z-index: 100;
      border: none;
    }

    .fab-premium:hover {
      transform: scale(1.1);
    }

    /* Footer Premium */
    .footer-premium {
      background: #0a0a1a;
      color: #9ca3af;
      padding: 60px 0 30px;
      margin-top: 60px;
    }

    @media (max-width: 968px) {
      .hero-title-premium { font-size: 3rem; }
      .service-card-grid { grid-template-columns: 1fr; gap: 32px; }
      .service-card-grid.reverse { direction: ltr; }
      .stats-premium-grid { grid-template-columns: 1fr 1fr; }
      .testimonial-grid { grid-template-columns: 1fr; }
      .contact-premium-grid { grid-template-columns: 1fr; }
      .section-title-premium { font-size: 2rem; }
    }
  </style>
</head>
<body>

  <!-- Navigation Premium -->
  <nav class="nav-premium" id="nav">
    <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
      <div class="nav-logo">
        <img src="{{asset('logo.png')}}" style="height: 42px; width: auto;"/>
      </div>
      <div style="display: flex; gap: 40px; align-items: center;">
        <a href="#services" style="text-decoration: none; color: #0a0a1a; font-weight: 500;">Services</a>
        <a href="#pricing" style="text-decoration: none; color: #0a0a1a; font-weight: 500;">Tarifs</a>
        <a href="#testimonials" style="text-decoration: none; color: #0a0a1a; font-weight: 500;">Clients</a>
        <a href="#contact" style="text-decoration: none; color: #0a0a1a; font-weight: 500;">Contact</a>
        <button class="btn-premium-primary" style="padding: 10px 24px;" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">
          <i class="fas fa-rocket"></i> Devis gratuit
        </button>
      </div>
    </div>
  </nav>

  <!-- Hero Section Premium -->
  <section class="hero-premium">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="container">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center;">
        <div>
          <div class="hero-badge-premium">
            <i class="fas fa-crown"></i>
            Plan Premium — {{ $plan->name }}
          </div>
          <h1 class="hero-title-premium">
            Transformez votre<br>
            <span class="gradient-premium">présence digitale</span>
          </h1>
          <p class="hero-desc-premium">
            {{ $plan->description ?? 'La solution tout-en-un qui propulse votre entreprise vers l\'excellence digitale.' }}
          </p>
          <div style="display: flex; gap: 16px; flex-wrap: wrap;">
            <button class="btn-premium-primary" onclick="document.getElementById('services').scrollIntoView({behavior: 'smooth'})">
              <i class="fas fa-arrow-right"></i> Découvrir
            </button>
            <button class="btn-premium-secondary" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">
              <i class="fas fa-play"></i> Voir démo
            </button>
          </div>
          <div class="trust-badges">
            <div class="trust-item">
              <div class="icon"><i class="fas fa-chart-line" style="color: #4f46e5;"></i></div>
              <div><strong>+237%</strong><br><span style="font-size: 0.8rem;">de visibilité</span></div>
            </div>
            <div class="trust-item">
              <div class="icon"><i class="fas fa-star" style="color: #f59e0b;"></i></div>
              <div><strong>4.9★</strong><br><span style="font-size: 0.8rem;">satisfaction</span></div>
            </div>
            <div class="trust-item">
              <div class="icon"><i class="fas fa-users" style="color: #10b981;"></i></div>
              <div><strong>3000+</strong><br><span style="font-size: 0.8rem;">clients actifs</span></div>
            </div>
          </div>
        </div>
        <div>
          <div style="background: rgba(255,255,255,0.8); backdrop-filter: blur(20px); border-radius: 32px; padding: 32px; border: 1px solid rgba(255,255,255,0.5);">
            <div style="display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
              <span style="background: #e0e7ff; padding: 8px 16px; border-radius: 100px; font-size: 0.8rem;"><i class="fas fa-check-circle" style="color: #10b981;"></i> Support 24/7</span>
              <span style="background: #e0e7ff; padding: 8px 16px; border-radius: 100px; font-size: 0.8rem;"><i class="fas fa-check-circle" style="color: #10b981;"></i> Analytics avancés</span>
              <span style="background: #e0e7ff; padding: 8px 16px; border-radius: 100px; font-size: 0.8rem;"><i class="fas fa-check-circle" style="color: #10b981;"></i> Mises à jour</span>
            </div>
            <div style="background: white; border-radius: 24px; padding: 24px;">
              <h4 style="margin-bottom: 16px;">Votre plan {{ $plan->name }} inclus :</h4>
              <div style="display: flex; flex-direction: column; gap: 14px;">
                @foreach($plan->plugins->take(4) as $plugin)
                  <div><i class="fas fa-check-circle" style="color: #10b981; margin-right: 12px;"></i> {{ $plugin->name }}</div>
                @endforeach
                <div><i class="fas fa-plus-circle" style="color: #4f46e5; margin-right: 12px;"></i> +{{ $plan->plugins->count() - 4 }} autres services</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services" style="padding: 80px 0;">
    <div class="container">
      <div class="section-header-premium">
        <span class="section-tag-premium">Nos services premium</span>
        <h2 class="section-title-premium">Une <span class="gradient-premium">expérience complète</span><br>pour votre succès</h2>
        <p style="color: #6b7280;">Des solutions intégrées qui font la différence</p>
      </div>
    </div>

    @forelse($plan->plugins as $index => $plugin)
      @php
        $isEven = $loop->iteration % 2 == 0;
        
        if(stripos($plugin->name, 'vidéo') !== false) {
          $pluginData = [
            'icon' => 'fa-map-marker-alt',
            'title' => 'Vidéo sur la carte',
            'desc' => 'Diffusez vos vidéos promotionnelles directement sur Google Maps et Apple Maps. Notre technologie brevetée de géolocalisation précise transforme chaque recherche en opportunité de conversion.',
            'features' => ['Géolocalisation précise à 5m', 'Rayon personnalisable 100m-5km', 'Lecture automatique au survol', 'Statistiques en temps réel'],
            'stats' => [['value' => '+237%', 'label' => 'visibilité locale'], ['value' => '+156%', 'label' => 'taux de conversion']],
            'images' => [
              'https://images.unsplash.com/photo-1579869847514-7c1a19d2d2ad?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1524661135-423995f22d0f?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?w=800&h=500&fit=crop'
            ]
          ];
        }
        elseif(stripos($plugin->name, 'site') !== false) {
          $pluginData = [
            'icon' => 'fa-laptop-code',
            'title' => 'Création site web',
            'desc' => 'Un site web professionnel, moderne et ultra-rapide livré en 48h. Design unique, responsive et CMS intuitif pour une gestion simplifiée.',
            'features' => ['Design unique sans template', 'Responsive mobile-first', 'CMS drag & drop', 'Livraison 48h garantie'],
            'stats' => [['value' => '48h', 'label' => 'livraison express'], ['value' => '100%', 'label' => 'clients satisfaits']],
            'images' => [
              'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1547658719-da2b51169166?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=500&fit=crop'
            ]
          ];
        }
        elseif(stripos($plugin->name, 'seo') !== false) {
          $pluginData = [
            'icon' => 'fa-chart-line',
            'title' => 'SEO & Visibilité Google',
            'desc' => 'Atteignez la première page de Google grâce à notre stratégie SEO complète. Audit technique, mots-clés stratégiques et netlinking de qualité.',
            'features' => ['Audit technique complet', 'Mots-clés à forte intention', 'Netlinking de qualité', 'Rapports mensuels détaillés'],
            'stats' => [['value' => 'Top 10', 'label' => 'mots-clés visés'], ['value' => '30 jours', 'label' => 'premiers résultats']],
            'images' => [
              'https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1562577309-4932fdd64cd1?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=500&fit=crop'
            ]
          ];
        }
        elseif(stripos($plugin->name, 'mail') !== false) {
          $pluginData = [
            'icon' => 'fa-envelope-open-text',
            'title' => 'Mail Marketing',
            'desc' => 'Campagnes email marketing intelligentes et automatisées. Segmentation avancée, A/B testing et analytics détaillés pour maximiser vos conversions.',
            'features' => ['Campagnes automatisées', 'Segmentation avancée', 'A/B testing', 'Analytics détaillés'],
            'stats' => [['value' => '42%', 'label' => 'taux ouverture'], ['value' => '18%', 'label' => 'taux clic']],
            'images' => [
              'https://images.unsplash.com/photo-1512626120412-faf41adb4874?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1557838923-2985c318be48?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1555421689-491a97ff2040?w=800&h=500&fit=crop'
            ]
          ];
        }
        else {
          $pluginData = [
            'icon' => 'fa-puzzle-piece',
            'title' => $plugin->name,
            'desc' => $plugin->description ?? 'Découvrez cette fonctionnalité premium incluse dans votre plan pour booster votre productivité.',
            'features' => ['Fonctionnalité premium', 'Support prioritaire', 'Mises à jour incluses'],
            'stats' => [['value' => 'Inclus', 'label' => 'dans le plan'], ['value' => '24/7', 'label' => 'support']],
            'images' => [
              'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800&h=500&fit=crop'
            ]
          ];
        }
      @endphp

      <div class="container">
        <div class="service-card-premium {{ $isEven ? 'alt' : '' }}">
          <div class="service-card-grid {{ $isEven ? 'reverse' : '' }}">
            <div>
              <div class="service-icon-premium">
                <i class="fas {{ $pluginData['icon'] }}"></i>
              </div>
              <h3 class="service-title-premium">{{ $pluginData['title'] }}</h3>
              <p class="service-desc-premium">{{ $pluginData['desc'] }}</p>
              <div class="features-grid-premium">
                @foreach($pluginData['features'] as $feature)
                  <span class="feature-chip">{{ $feature }}</span>
                @endforeach
              </div>
              <div class="stats-row">
                @foreach($pluginData['stats'] as $stat)
                  <div class="stat-premium">
                    <div class="value">{{ $stat['value'] }}</div>
                    <div class="label">{{ $stat['label'] }}</div>
                  </div>
                @endforeach
              </div>
              <button class="btn-premium-primary" style="margin-top: 16px;" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">
                Je veux ce service <i class="fas fa-arrow-right"></i>
              </button>
            </div>
            <div class="service-media-premium">
              <div class="swiper service-swiper-premium">
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
      </div>
    @empty
      <div class="container" style="text-align: center; padding: 60px;">Aucun service disponible.</div>
    @endforelse
  </section>

  <!-- Facturation Section -->
  <div class="container">
    <div class="service-card-premium alt">
      <div class="service-card-grid">
        <div>
          <div class="service-icon-premium"><i class="fas fa-file-invoice-dollar"></i></div>
          <h3 class="service-title-premium">Gestion facturation</h3>
          <p class="service-desc-premium">Centralisez votre gestion financière. Créez des devis et factures personnalisables, programmez des relances automatiques, et suivez vos paiements en temps réel avec intégration Stripe et PayPal.</p>
          <div class="features-grid-premium">
            <span class="feature-chip">Devis personnalisés</span>
            <span class="feature-chip">Relances automatiques</span>
            <span class="feature-chip">Stripe/PayPal</span>
            <span class="feature-chip">Export comptable</span>
          </div>
          <div class="stats-row">
            <div class="stat-premium"><div class="value">-72h</div><div class="label">délai réduit</div></div>
            <div class="stat-premium"><div class="value">100%</div><div class="label">automatisé</div></div>
          </div>
          <button class="btn-premium-primary" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">Je veux ce service <i class="fas fa-arrow-right"></i></button>
        </div>
        <div class="service-media-premium">
          <div class="swiper service-swiper-premium">
            <div class="swiper-wrapper">
              <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=800&h=500&fit=crop" alt="Facturation"></div>
              <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1554774853-719586f82d77?w=800&h=500&fit=crop" alt="Paiement"></div>
              <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=800&h=500&fit=crop" alt="Dashboard"></div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Marketplace Section -->
  <div class="container">
    <div class="service-card-premium">
      <div class="service-card-grid reverse">
        <div>
          <div class="service-icon-premium"><i class="fas fa-store"></i></div>
          <h3 class="service-title-premium">Marketplace intégrée</h3>
          <p class="service-desc-premium">Développez votre chiffre d'affaires sur notre marketplace avec 50k+ visiteurs mensuels. Gestion centralisée des stocks, commandes unifiées et commission personnalisable.</p>
          <div class="features-grid-premium">
            <span class="feature-chip">Multi-vendeurs</span>
            <span class="feature-chip">Commission 0-20%</span>
            <span class="feature-chip">Stocks temps réel</span>
            <span class="feature-chip">Support logistique</span>
          </div>
          <div class="stats-row">
            <div class="stat-premium"><div class="value">+156%</div><div class="label">ventes générées</div></div>
            <div class="stat-premium"><div class="value">50k+</div><div class="label">visiteurs/mois</div></div>
          </div>
          <button class="btn-premium-primary" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">Je veux ce service <i class="fas fa-arrow-right"></i></button>
        </div>
        <div class="service-media-premium">
          <div class="swiper service-swiper-premium">
            <div class="swiper-wrapper">
              <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=800&h=500&fit=crop" alt="Marketplace"></div>
              <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&h=500&fit=crop" alt="Vente"></div>
              <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=800&h=500&fit=crop" alt="Gestion"></div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pricing Section -->
  <div class="container" id="pricing">
    <div class="pricing-premium">
      <div class="pricing-badge"><i class="fas fa-gem"></i> Plan recommandé</div>
      <h2 style="color: white; font-size: 2rem;">{{ $plan->name }}</h2>
      <div class="amount">{{ $plan->formatted_price }}<span style="font-size: 1.2rem;">/{{ $plan->billing_cycle ?? 'mois' }}</span></div>
      <div class="features-list">
        <span><i class="fas fa-check-circle"></i> Support prioritaire 24/7</span>
        <span><i class="fas fa-check-circle"></i> Analytics avancés</span>
        <span><i class="fas fa-check-circle"></i> Mises à jour incluses</span>
        <span><i class="fas fa-check-circle"></i> Sans engagement</span>
      </div>
      <button class="btn-cta-premium" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">Commencer maintenant</button>
    </div>
  </div>

  <!-- Stats Grid -->
  <div class="container">
    <div class="stats-premium-grid">
      <div class="stat-premium-card"><div class="number">3000+</div><div>Clients actifs</div></div>
      <div class="stat-premium-card"><div class="number">4.9★</div><div>Satisfaction client</div></div>
      <div class="stat-premium-card"><div class="number">98%</div><div>Taux de rétention</div></div>
      <div class="stat-premium-card"><div class="number">24/7</div><div>Support disponible</div></div>
    </div>
  </div>

  <!-- Testimonials -->
  <div class="container" id="testimonials">
    <div class="section-header-premium">
      <span class="section-tag-premium">Témoignages</span>
      <h2 class="section-title-premium">Ce que nos <span class="gradient-premium">clients disent</span></h2>
    </div>
    <div class="testimonial-grid">
      <div class="testimonial-card">
        <i class="fas fa-quote-left" style="color: #4f46e5; font-size: 2rem; opacity: 0.3;"></i>
        <p style="margin: 16px 0; line-height: 1.6;">"GoExploria a transformé notre présence en ligne. Résultats visibles en moins d'un mois!"</p>
        <div><strong>Sophie Martin</strong><br><span style="font-size: 0.8rem; color: #9ca3af;">Le Petit Bistro</span></div>
      </div>
      <div class="testimonial-card">
        <i class="fas fa-quote-left" style="color: #4f46e5; font-size: 2rem; opacity: 0.3;"></i>
        <p style="margin: 16px 0; line-height: 1.6;">"La marketplace nous a ouvert de nouveaux marchés. +156% de ventes en 3 mois!"</p>
        <div><strong>Thomas Dubois</strong><br><span style="font-size: 0.8rem; color: #9ca3af;">La Maison du Café</span></div>
      </div>
      <div class="testimonial-card">
        <i class="fas fa-quote-left" style="color: #4f46e5; font-size: 2rem; opacity: 0.3;"></i>
        <p style="margin: 16px 0; line-height: 1.6;">"Support réactif et solutions innovantes. Je recommande vivement!"</p>
        <div><strong>Julie Lambert</strong><br><span style="font-size: 0.8rem; color: #9ca3af;">Immobilier Premium</span></div>
      </div>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="container">
    <div class="cta-premium">
      <i class="fas fa-chart-line" style="font-size: 3rem; margin-bottom: 16px;"></i>
      <h2 style="font-size: 2rem;">Prêt à booster votre activité ?</h2>
      <p>Rejoignez plus de 3000 entreprises qui nous font confiance</p>
      <button class="btn-cta-premium" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">
        <i class="fas fa-calendar-check"></i> Demander une démo
      </button>
    </div>
  </div>

  <!-- Contact Section -->
  <div class="container" id="contact">
    <div class="contact-premium">
      <div class="contact-premium-grid">
        <div>
          <div class="section-tag-premium" style="display: inline-block;">Contactez-nous</div>
          <h2 style="font-size: 2rem; margin: 20px 0;">Parlons de <span class="gradient-premium">votre projet</span></h2>
          <p style="color: #6b7280; margin-bottom: 32px;">Notre équipe vous répond sous 24h.</p>
          <div style="display: flex; flex-direction: column; gap: 24px;">
            <div style="display: flex; align-items: center; gap: 16px;">
              <div style="width: 48px; height: 48px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-envelope" style="color: #4f46e5;"></i></div>
              <div><strong>Email</strong><br>hello@goexploria.com</div>
            </div>
            <div style="display: flex; align-items: center; gap: 16px;">
              <div style="width: 48px; height: 48px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-phone" style="color: #4f46e5;"></i></div>
              <div><strong>Téléphone</strong><br>+1 (514) 555-9210</div>
            </div>
            <div style="display: flex; align-items: center; gap: 16px;">
              <div style="width: 48px; height: 48px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-map-marker-alt" style="color: #4f46e5;"></i></div>
              <div><strong>Adresse</strong><br>123 rue Saint-Denis, Montréal, QC</div>
            </div>
          </div>
        </div>
        <div>
          <form style="display: flex; flex-direction: column; gap: 16px;">
            <input type="text" placeholder="Votre nom" style="padding: 14px 18px; border: 1px solid #e5e7eb; border-radius: 16px; font-family: inherit;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
              <input type="email" placeholder="Email" style="padding: 14px 18px; border: 1px solid #e5e7eb; border-radius: 16px; font-family: inherit;">
              <input type="tel" placeholder="Téléphone" style="padding: 14px 18px; border: 1px solid #e5e7eb; border-radius: 16px; font-family: inherit;">
            </div>
            <select style="padding: 14px 18px; border: 1px solid #e5e7eb; border-radius: 16px; font-family: inherit;">
              <option>Service souhaité</option>
              @foreach($plan->plugins as $plugin)
                <option>{{ $plugin->name }}</option>
              @endforeach
              <option>Gestion facturation</option>
              <option>Marketplace</option>
            </select>
            <textarea rows="4" placeholder="Décrivez votre projet..." style="padding: 14px 18px; border: 1px solid #e5e7eb; border-radius: 16px; font-family: inherit; resize: vertical;"></textarea>
            <button class="btn-premium-primary" style="width: 100%; justify-content: center;">Envoyer <i class="fas fa-paper-plane"></i></button>
            <p style="text-align: center; font-size: 0.8rem; color: #9ca3af;">Sans engagement · Démo gratuite · Réponse sous 24h</p>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Floating Action Button -->
  <button class="fab-premium" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">
    <i class="fas fa-comment-dots" style="color: white; font-size: 24px;"></i>
  </button>

  <!-- Footer -->
  <footer class="footer-premium">
    <div class="container">
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 48px;">
        <div>
          <div style="font-size: 1.5rem; font-weight: 700; margin-bottom: 16px;">Go<span style="color: #4f46e5;">Exploria</span></div>
          <p style="color: #6b7280;">La plateforme tout-en-un pour les professionnels.</p>
        </div>
        <div>
          <h4 style="color: white; margin-bottom: 16px;">Services</h4>
          @foreach($plan->plugins->take(4) as $plugin)
            <a href="#" style="display: block; margin-bottom: 8px; color: #9ca3af; text-decoration: none;">{{ $plugin->name }}</a>
          @endforeach
        </div>
        <div>
          <h4 style="color: white; margin-bottom: 16px;">Ressources</h4>
          <a href="#" style="display: block; margin-bottom: 8px; color: #9ca3af; text-decoration: none;">Blog</a>
          <a href="#" style="display: block; margin-bottom: 8px; color: #9ca3af; text-decoration: none;">Documentation</a>
          <a href="#" style="display: block; margin-bottom: 8px; color: #9ca3af; text-decoration: none;">API</a>
        </div>
        <div>
          <h4 style="color: white; margin-bottom: 16px;">Légal</h4>
          <a href="#" style="display: block; margin-bottom: 8px; color: #9ca3af; text-decoration: none;">CGU</a>
          <a href="#" style="display: block; margin-bottom: 8px; color: #9ca3af; text-decoration: none;">Confidentialité</a>
          <a href="#" style="display: block; margin-bottom: 8px; color: #9ca3af; text-decoration: none;">Mentions légales</a>
        </div>
      </div>
      <div style="text-align: center; padding-top: 48px; margin-top: 48px; border-top: 1px solid #1f2937;">
        <p>© 2026 GoExploria — Tous droits réservés</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    // Nav scroll effect
    window.addEventListener('scroll', function() {
      const nav = document.getElementById('nav');
      if (window.scrollY > 50) {
        nav.classList.add('scrolled');
      } else {
        nav.classList.remove('scrolled');
      }
    });

    // Initialize Swipers
    document.querySelectorAll('.service-swiper-premium').forEach(swiperEl => {
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