<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $plan->name }} — GoExploria | Solution digitale tout-en-un</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{asset('vendor/theme/css/styles.css')}}">
  <style>
    /* Styles modernes et professionnels */
    :root {
      --primary: #4f46e5;
      --primary-light: #6366f1;
      --primary-dark: #4338ca;
      --secondary: #f59e0b;
      --success: #10b981;
      --gray-50: #f9fafb;
      --gray-100: #f3f4f6;
      --gray-200: #e5e7eb;
      --gray-600: #4b5563;
      --gray-700: #374151;
      --gray-800: #1f2937;
      --gray-900: #111827;
    }

    /* Hero Light & Fresh */
    .hero-light {
      min-height: 85vh;
      display: flex;
      align-items: center;
      background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #fef3c7 100%);
      position: relative;
      overflow: hidden;
    }
    .hero-light::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('https://images.unsplash.com/photo-1557683316-973673baf926?w=1920&h=1080&fit=crop');
      background-size: cover;
      background-position: center;
      opacity: 0.05;
      pointer-events: none;
    }
    .hero-light .container {
      position: relative;
      z-index: 2;
    }
    .hero-badge {
      background: white;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-size: 0.8rem;
      font-weight: 600;
      color: var(--primary);
      display: inline-block;
      margin-bottom: 1.5rem;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .hero-light h1 {
      font-size: 3.5rem;
      font-weight: 800;
      line-height: 1.2;
      color: var(--gray-900);
      margin-bottom: 1.5rem;
    }
    .gradient-text {
      background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .hero-subtitle {
      font-size: 1.2rem;
      color: var(--gray-600);
      margin-bottom: 2rem;
      max-width: 500px;
    }
    .btn-hero-primary {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white;
      padding: 1rem 2rem;
      border-radius: 50px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    .btn-hero-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 20px 30px -10px rgba(79,70,229,0.3);
    }
    .btn-hero-secondary {
      background: white;
      color: var(--primary);
      padding: 1rem 2rem;
      border-radius: 50px;
      font-weight: 600;
      border: 2px solid var(--primary);
      cursor: pointer;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    .btn-hero-secondary:hover {
      background: var(--primary);
      color: white;
    }
    .hero-stats {
      display: flex;
      gap: 2rem;
      margin-top: 3rem;
      flex-wrap: wrap;
    }
    .hero-stat-card {
      background: white;
      padding: 1rem 1.5rem;
      border-radius: 16px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .hero-stat-card .stat-value {
      font-size: 1.8rem;
      font-weight: 800;
      color: var(--primary);
      display: block;
    }
    .hero-stat-card .stat-label {
      font-size: 0.85rem;
      color: var(--gray-600);
    }

    /* Features Grid */
    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      margin-top: 2rem;
    }
    .feature-card {
      background: white;
      padding: 1.5rem;
      border-radius: 20px;
      text-align: center;
      transition: all 0.3s ease;
      border: 1px solid var(--gray-200);
    }
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 30px -10px rgba(0,0,0,0.1);
    }
    .feature-icon {
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
    }
    .feature-icon i {
      font-size: 1.5rem;
      color: white;
    }

    /* Service Blocks */
    .service-block {
      padding: 80px 0;
      border-bottom: 1px solid var(--gray-200);
    }
    .service-block.alt {
      background: var(--gray-50);
    }
    .service-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4rem;
      align-items: center;
    }
    .service-grid.reverse {
      direction: rtl;
    }
    .service-grid.reverse > * {
      direction: ltr;
    }
    .service-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: white;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-size: 0.8rem;
      font-weight: 600;
      color: var(--primary);
      margin-bottom: 1.5rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .service-title {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: var(--gray-900);
    }
    .service-description {
      color: var(--gray-600);
      line-height: 1.7;
      margin-bottom: 1.5rem;
    }
    .service-features-list {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
      margin: 1.5rem 0;
    }
    .service-feature-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.5rem;
      background: white;
      border-radius: 12px;
      transition: all 0.3s ease;
    }
    .service-feature-item:hover {
      transform: translateX(5px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .service-feature-item i {
      color: var(--success);
      font-size: 1.1rem;
    }
    .service-stats-group {
      display: flex;
      gap: 1rem;
      margin: 1.5rem 0;
      flex-wrap: wrap;
    }
    .service-stat-card {
      flex: 1;
      text-align: center;
      padding: 1rem;
      background: white;
      border-radius: 16px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .service-stat-card .stat-number {
      font-size: 1.5rem;
      font-weight: 800;
      color: var(--primary);
    }
    .service-stat-card .stat-text {
      font-size: 0.8rem;
      color: var(--gray-600);
    }
    .btn-service {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white;
      padding: 0.8rem 1.8rem;
      border-radius: 50px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    .btn-service:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px -5px rgba(79,70,229,0.4);
    }
    .service-media {
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 25px 40px -12px rgba(0,0,0,0.2);
    }
    .service-swiper-custom {
      border-radius: 24px;
    }
    .service-swiper-custom img {
      width: 100%;
      height: 400px;
      object-fit: cover;
    }

    /* Section Title */
    .section-title-custom {
      text-align: center;
      margin-bottom: 3rem;
    }
    .section-tag-custom {
      display: inline-block;
      background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-size: 0.8rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }
    .section-title-custom h2 {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--gray-900);
    }

    /* CTA Section */
    .cta-section {
      background: linear-gradient(135deg, var(--gray-900) 0%, var(--gray-800) 100%);
      padding: 80px 0;
      text-align: center;
    }
    .btn-cta {
      background: linear-gradient(135deg, var(--secondary) 0%, #d97706 100%);
      color: white;
      padding: 1rem 2.5rem;
      border-radius: 50px;
      font-weight: 700;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .btn-cta:hover {
      transform: translateY(-2px);
      box-shadow: 0 20px 30px -10px rgba(0,0,0,0.3);
    }

    /* Floating Button */
    .floating-btn {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: linear-gradient(135deg, var(--secondary) 0%, #d97706 100%);
      padding: 1rem 1.5rem;
      border-radius: 50px;
      color: white;
      font-weight: 700;
      cursor: pointer;
      z-index: 100;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      display: flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
      border: none;
    }
    .floating-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    @media (max-width: 768px) {
      .hero-light h1 { font-size: 2rem; }
      .service-grid { grid-template-columns: 1fr; gap: 2rem; }
      .service-grid.reverse { direction: ltr; }
      .service-swiper-custom img { height: 250px; }
      .section-title-custom h2 { font-size: 1.8rem; }
    }
  </style>
</head>
<body>

  <!-- Navigation -->
  <nav class="nav" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); box-shadow: 0 1px 3px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000;">
    <div class="nav-container">
      <div class="nav-logo">
        <img src="{{asset('logo.png')}}" style="width:150px;"/>
      </div>
      <div class="nav-links">
        <a href="#services" class="nav-link">Services</a>
        <a href="#facturation" class="nav-link">Facturation</a>
        <a href="#marketplace" class="nav-link">Marketplace</a>
        <a href="#showcase" class="nav-link">Réalisations</a>
        <a href="#contact" class="nav-link">Contact</a>
        <button class="btn-primary" style="padding: 0.5rem 1.25rem; margin-left: 1rem;" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">Devis gratuit</button>
      </div>
    </div>
  </nav>

  <!-- Hero Section Light & Fresh -->
  <section class="hero-light">
    <div class="container">
      <div class="hero-badge">
        <i class="fas fa-crown"></i> Plan Premium
      </div>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center;">
        <div>
          <h1>Transformez votre <span class="gradient-text">présence en ligne</span><br>avec <span class="gradient-text">{{ $plan->name }}</span></h1>
          <p class="hero-subtitle">{{ $plan->description ?? 'La solution digitale tout-en-un qui propulse votre entreprise vers de nouveaux sommets.' }}</p>
          <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <button class="btn-hero-primary" onclick="document.getElementById('services').scrollIntoView({behavior: 'smooth'})">
              <i class="fas fa-rocket"></i> Découvrir les services
            </button>
            <button class="btn-hero-secondary" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">
              <i class="fas fa-headset"></i> Demander un devis
            </button>
          </div>
          <div class="hero-stats">
            <div class="hero-stat-card">
              <span class="stat-value">{{ $plan->formatted_price }}</span>
              <span class="stat-label">/{{ $plan->billing_cycle ?? 'mois' }}</span>
            </div>
            @if($plan->is_popular)
            <div class="hero-stat-card">
              <span class="stat-value"><i class="fas fa-star" style="color: #f59e0b;"></i> Populaire</span>
              <span class="stat-label">Recommandé</span>
            </div>
            @endif
            <div class="hero-stat-card">
              <span class="stat-value">{{ $plan->plugins->count() }}</span>
              <span class="stat-label">Services inclus</span>
            </div>
          </div>
        </div>
        <div>
          <div style="background: white; border-radius: 32px; padding: 2rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);">
            <div style="text-align: center;">
              <i class="fas fa-chart-line" style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem;"></i>
              <h3 style="margin-bottom: 1rem;">Ce que vous gagnez</h3>
              <div class="features-grid" style="grid-template-columns: 1fr; gap: 0.75rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;"><i class="fas fa-check-circle" style="color: var(--success);"></i> +237% de visibilité locale</div>
                <div style="display: flex; align-items: center; gap: 0.75rem;"><i class="fas fa-check-circle" style="color: var(--success);"></i> Support prioritaire 24/7</div>
                <div style="display: flex; align-items: center; gap: 0.75rem;"><i class="fas fa-check-circle" style="color: var(--success);"></i> Analytics en temps réel</div>
                <div style="display: flex; align-items: center; gap: 0.75rem;"><i class="fas fa-check-circle" style="color: var(--success);"></i> Sans engagement</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES SECTION - Plugins dynamiques -->
  <section class="section" id="services" style="padding: 0;">
    @forelse($plan->plugins as $index => $plugin)
      @php
        $isEven = $loop->iteration % 2 == 0;
        
        if(stripos($plugin->name, 'vidéo') !== false || stripos($plugin->name, 'carte') !== false) {
          $pluginData = [
            'icon' => 'fa-map-marker-alt',
            'badge' => '📍 Géomarketing vidéo',
            'title' => 'Vidéo sur la carte',
            'description' => 'Diffusez vos vidéos promotionnelles directement sur Google Maps et Apple Maps. Notre technologie brevetée de géolocalisation précise permet d\'associer votre contenu vidéo à un emplacement stratégique.',
            'features' => [
              'Géolocalisation précise à 5 mètres près',
              'Rayon d\'action personnalisable de 100m à 5km',
              'Lecture automatique au survol (sans son)',
              'Statistiques détaillées : vues, clics, durée',
              'Compatible Google Maps, Apple Maps, Waze'
            ],
            'stats' => [['value' => '+237%', 'label' => 'visibilité locale'], ['value' => '+156%', 'label' => 'conversion']],
            'images' => [
              'https://images.unsplash.com/photo-1579869847514-7c1a19d2d2ad?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1524661135-423995f22d0f?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?w=800&h=500&fit=crop'
            ]
          ];
        }
        elseif(stripos($plugin->name, 'site') !== false || stripos($plugin->name, 'web') !== false) {
          $pluginData = [
            'icon' => 'fa-laptop-code',
            'badge' => '🌐 Création sur mesure',
            'title' => 'Création site web',
            'description' => 'Obtenez un site web professionnel, moderne et ultra-rapide, livré en seulement 48 heures. Design responsive, animations fluides et expérience utilisateur optimisée.',
            'features' => [
              'Design unique et personnalisé sans template',
              'Responsive mobile-first (100% adapté)',
              'CMS intuitif avec interface drag & drop',
              'Livraison garantie en 48 heures',
              'Boutique e-commerce disponible sur demande'
            ],
            'stats' => [['value' => '48h', 'label' => 'livraison'], ['value' => '100%', 'label' => 'satisfaction']],
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
            'badge' => '📈 Référencement naturel',
            'title' => 'SEO & Visibilité Google',
            'description' => 'Atteignez la première page de Google grâce à notre stratégie SEO complète et personnalisée. Audit technique, mots-clés pertinents et netlinking de qualité.',
            'features' => [
              'Audit technique complet',
              'Recherche de mots-clés à forte intention d\'achat',
              'Stratégie de netlinking avec sites de qualité',
              'Rapports mensuels avec recommandations',
              'Optimisation Google My Business'
            ],
            'stats' => [['value' => 'Top 10', 'label' => 'mots-clés'], ['value' => '30 jours', 'label' => 'résultats']],
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
            'badge' => '✉️ Marketing automation',
            'title' => 'Mail Marketing',
            'description' => 'Boostez vos ventes avec des campagnes email marketing intelligentes et entièrement automatisées. Segmentation avancée et A/B testing.',
            'features' => [
              'Campagnes automatisées (drip marketing)',
              'Segmentation avancée par comportement',
              'A/B testing sur objets et contenus',
              'Taux d\'ouverture moyen supérieur à 42%',
              'Analytics détaillés et heatmaps'
            ],
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
            'badge' => '🔌 ' . $plugin->name,
            'title' => $plugin->name,
            'description' => $plugin->description ?? 'Découvrez cette fonctionnalité puissante incluse dans votre plan.',
            'features' => ['Fonctionnalité premium incluse', 'Support technique prioritaire', 'Mises à jour régulières'],
            'stats' => [['value' => 'Inclus', 'label' => 'dans le plan'], ['value' => '24/7', 'label' => 'support']],
            'images' => [
              'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=500&fit=crop',
              'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800&h=500&fit=crop'
            ]
          ];
        }
      @endphp

      <div class="service-block {{ $isEven ? 'alt' : '' }}">
        <div class="container">
          <div class="service-grid {{ $isEven ? 'reverse' : '' }}">
            <div>
              <div class="service-badge">
                <i class="fas {{ $pluginData['icon'] }}"></i>
                {{ $pluginData['badge'] }}
              </div>
              <h3 class="service-title">{{ $pluginData['title'] }}</h3>
              <p class="service-description">{{ $pluginData['description'] }}</p>
              <div class="service-features-list">
                @foreach($pluginData['features'] as $feature)
                  <div class="service-feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ $feature }}</span>
                  </div>
                @endforeach
              </div>
              <div class="service-stats-group">
                @foreach($pluginData['stats'] as $stat)
                  <div class="service-stat-card">
                    <div class="stat-number">{{ $stat['value'] }}</div>
                    <div class="stat-text">{{ $stat['label'] }}</div>
                  </div>
                @endforeach
              </div>
              <button class="btn-service" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">
                <i class="fas fa-arrow-right"></i> Je veux ce service
              </button>
            </div>
            <div class="service-media">
              <div class="swiper service-swiper-custom">
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
      <div class="container" style="text-align: center; padding: 80px 0;">
        <p>Aucun service disponible pour ce plan.</p>
      </div>
    @endforelse
  </section>

  <!-- SECTION FACTURATION - Statique -->
  <section class="service-block alt" id="facturation">
    <div class="container">
      <div class="service-grid reverse">
        <div>
          <div class="service-badge">
            <i class="fas fa-file-invoice-dollar"></i>
            💳 Finance simplifiée
          </div>
          <h3 class="service-title">Gestion facturation</h3>
          <p class="service-description">Centralisez l'ensemble de votre gestion financière sur une seule plateforme intuitive. Créez des devis et factures personnalisables en quelques clics, programmez des relances automatiques par email, et suivez vos paiements en temps réel. L'intégration native avec Stripe et PayPal vous permet d'encaisser vos clients directement en ligne.</p>
          <div class="service-features-list">
            <div class="service-feature-item"><i class="fas fa-check-circle"></i> Devis et factures personnalisables avec votre logo</div>
            <div class="service-feature-item"><i class="fas fa-check-circle"></i> Relances automatiques par email (échéances)</div>
            <div class="service-feature-item"><i class="fas fa-check-circle"></i> Intégration Stripe, PayPal et virement SEPA</div>
            <div class="service-feature-item"><i class="fas fa-check-circle"></i> Export comptable (CSV, Excel, PDF, EBP)</div>
            <div class="service-feature-item"><i class="fas fa-check-circle"></i> Tableau de bord financier en temps réel</div>
          </div>
          <div class="service-stats-group">
            <div class="service-stat-card"><div class="stat-number">-72h</div><div class="stat-text">délai de paiement réduit</div></div>
            <div class="service-stat-card"><div class="stat-number">100%</div><div class="stat-text">process automatisé</div></div>
          </div>
          <button class="btn-service" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})"><i class="fas fa-arrow-right"></i> Je veux ce service</button>
        </div>
        <div class="service-media">
          <div class="swiper service-swiper-custom">
            <div class="swiper-wrapper">
              <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=800&h=500&fit=crop" alt="Facturation en ligne"></div>
              <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1554774853-719586f82d77?w=800&h=500&fit=crop" alt="Paiement en ligne"></div>
              <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=800&h=500&fit=crop" alt="Dashboard financier"></div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SECTION MARKETPLACE - Statique -->
  <section class="service-block" id="marketplace">
    <div class="container">
      <div class="service-grid">
        <div>
          <div class="service-badge">
            <i class="fas fa-store"></i>
            🛒 Vendez partout
          </div>
          <h3 class="service-title">Marketplace intégrée</h3>
          <p class="service-description">Développez votre chiffre d'affaires en vendant vos produits et services sur notre marketplace intégrée. Bénéficiez d'une visibilité accrue auprès de nos 50 000 visiteurs mensuels. La gestion des stocks, des commandes et des livraisons est entièrement unifiée, et vous définissez librement vos commissions.</p>
          <div class="service-features-list">
            <div class="service-feature-item"><i class="fas fa-check-circle"></i> Multi-vendeurs avec commission personnalisable</div>
            <div class="service-feature-item"><i class="fas fa-check-circle"></i> Gestion centralisée des stocks en temps réel</div>
            <div class="service-feature-item"><i class="fas fa-check-circle"></i> Commandes et livraisons unifiées</div>
            <div class="service-feature-item"><i class="fas fa-check-circle"></i> Commission personnalisable de 0 à 20%</div>
            <div class="service-feature-item"><i class="fas fa-check-circle"></i> Support logistique et service client inclus</div>
          </div>
          <div class="service-stats-group">
            <div class="service-stat-card"><div class="stat-number">+156%</div><div class="stat-text">de ventes générées</div></div>
            <div class="service-stat-card"><div class="stat-number">50k+</div><div class="stat-text">visiteurs par mois</div></div>
          </div>
          <button class="btn-service" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})"><i class="fas fa-arrow-right"></i> Je veux ce service</button>
        </div>
        <div class="service-media">
          <div class="swiper service-swiper-custom">
            <div class="swiper-wrapper">
              <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=800&h=500&fit=crop" alt="Marketplace"></div>
              <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&h=500&fit=crop" alt="Vente en ligne"></div>
              <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=800&h=500&fit=crop" alt="Gestion des stocks"></div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <div class="cta-section">
    <div class="container">
      <h2 style="color: white; margin-bottom: 1rem;">Prêt à transformer votre activité ?</h2>
      <p style="color: #9ca3af; margin-bottom: 2rem;">Rejoignez plus de 3000 entreprises qui nous font confiance</p>
      <button class="btn-cta" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">
        <i class="fas fa-calendar-check"></i> Demander une démo gratuite
      </button>
    </div>
  </div>

  <!-- Showcase Section -->
  <section class="section" id="showcase" style="background: var(--gray-50);">
    <div class="container">
      <div class="section-title-custom">
        <span class="section-tag-custom">Ils nous font confiance</span>
        <h2>+3000 <span class="gradient-text">clients satisfaits</span></h2>
        <p style="color: var(--gray-600);">Découvrez comment nos clients ont transformé leur présence digitale.</p>
      </div>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
        <div style="border-radius: 24px; overflow: hidden; position: relative;">
          <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=600&h=400&fit=crop" style="width:100%; height:300px; object-fit:cover;">
          <div style="position: absolute; inset:0; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); display: flex; align-items: flex-end; padding: 2rem;">
            <div style="color: white;">
              <h4>Le Petit Bistro</h4>
              <p>+156% de réservations en ligne</p>
              <span style="background: var(--success); padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.75rem;">Vidéo sur carte</span>
            </div>
          </div>
        </div>
        <div style="border-radius: 24px; overflow: hidden; position: relative;">
          <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600&h=400&fit=crop" style="width:100%; height:300px; object-fit:cover;">
          <div style="position: absolute; inset:0; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); display: flex; align-items: flex-end; padding: 2rem;">
            <div style="color: white;">
              <h4>La Maison du Café</h4>
              <p>+89% de clients en boutique</p>
              <span style="background: var(--success); padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.75rem;">SEO + Site web</span>
            </div>
          </div>
        </div>
        <div style="border-radius: 24px; overflow: hidden; position: relative;">
          <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=600&h=400&fit=crop" style="width:100%; height:300px; object-fit:cover;">
          <div style="position: absolute; inset:0; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); display: flex; align-items: flex-end; padding: 2rem;">
            <div style="color: white;">
              <h4>Immobilier Premium</h4>
              <p>+234 leads qualifiés/mois</p>
              <span style="background: var(--success); padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.75rem;">Pack complet</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section class="section" id="contact" style="background: white;">
    <div class="container">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; background: var(--gray-50); border-radius: 32px; padding: 3rem;">
        <div>
          <span class="section-tag-custom">Parlons de votre projet</span>
          <h2 style="font-size: 2rem; margin: 1rem 0;">Contactez notre <span class="gradient-text">équipe expert</span></h2>
          <p>Notre équipe vous répond sous 24h et vous propose une démo personnalisée gratuite.</p>
          <div style="margin-top: 2rem;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
              <div style="background: #e0e7ff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-envelope" style="color: var(--primary);"></i></div>
              <div><strong>Email</strong><br>hello@goexploria.com</div>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
              <div style="background: #e0e7ff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-phone" style="color: var(--primary);"></i></div>
              <div><strong>Téléphone</strong><br>+1 (514) 555-9210</div>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem;">
              <div style="background: #e0e7ff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-map-marker-alt" style="color: var(--primary);"></i></div>
              <div><strong>Adresse</strong><br>123 rue Saint-Denis, Montréal, QC</div>
            </div>
          </div>
        </div>
        <div>
          <form action="{{ url('contact.send') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Votre nom" style="width:100%; padding: 1rem; border-radius: 12px; border: 1px solid var(--gray-200); margin-bottom: 1rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
              <input type="email" name="email" placeholder="Email professionnel" style="padding: 1rem; border-radius: 12px; border: 1px solid var(--gray-200);">
              <input type="tel" name="phone" placeholder="Téléphone" style="padding: 1rem; border-radius: 12px; border: 1px solid var(--gray-200);">
            </div>
            <select name="service" style="width:100%; padding: 1rem; border-radius: 12px; border: 1px solid var(--gray-200); margin-bottom: 1rem;">
              <option value="">Service souhaité</option>
              @foreach($plan->plugins as $plugin)
                <option>{{ $plugin->name }}</option>
              @endforeach
              <option>Gestion facturation</option>
              <option>Marketplace intégrée</option>
            </select>
            <textarea name="message" rows="4" placeholder="Décrivez votre projet..." style="width:100%; padding: 1rem; border-radius: 12px; border: 1px solid var(--gray-200); margin-bottom: 1rem;"></textarea>
            <button type="submit" class="btn-service" style="width:100%; justify-content: center;"><i class="fas fa-paper-plane"></i> Envoyer le message</button>
            <p style="text-align: center; margin-top: 1rem; font-size: 0.8rem; color: var(--gray-600);">Sans engagement · Démo gratuite · Réponse sous 24h</p>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Floating Button -->
  <button class="floating-btn" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">
    <i class="fas fa-comment-dots"></i>
    <span>Devis gratuit</span>
  </button>

  <!-- Footer -->
  <footer style="background: var(--gray-900); color: #9ca3af; padding: 60px 0 30px;">
    <div class="container">
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 3rem;">
        <div>
          <div style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Go<span style="color: var(--secondary);">Exploria</span></div>
          <p>La plateforme tout-en-un pour les professionnels.</p>
          <div style="display: flex; gap: 1rem; margin-top: 1rem;">
            <a href="#" style="color: #9ca3af;"><i class="fab fa-linkedin"></i></a>
            <a href="#" style="color: #9ca3af;"><i class="fab fa-facebook"></i></a>
            <a href="#" style="color: #9ca3af;"><i class="fab fa-twitter"></i></a>
          </div>
        </div>
        <div>
          <h4 style="color: white; margin-bottom: 1rem;">Services</h4>
          @foreach($plan->plugins->take(5) as $plugin)
            <a href="#" style="display: block; margin-bottom: 0.5rem; color: #9ca3af; text-decoration: none;">{{ $plugin->name }}</a>
          @endforeach
          <a href="#" style="display: block; margin-bottom: 0.5rem; color: #9ca3af; text-decoration: none;">Gestion facturation</a>
          <a href="#" style="display: block; margin-bottom: 0.5rem; color: #9ca3af; text-decoration: none;">Marketplace</a>
        </div>
        <div>
          <h4 style="color: white; margin-bottom: 1rem;">Ressources</h4>
          <a href="#" style="display: block; margin-bottom: 0.5rem; color: #9ca3af; text-decoration: none;">Blog</a>
          <a href="#" style="display: block; margin-bottom: 0.5rem; color: #9ca3af; text-decoration: none;">Documentation</a>
          <a href="#" style="display: block; margin-bottom: 0.5rem; color: #9ca3af; text-decoration: none;">API</a>
          <a href="#" style="display: block; margin-bottom: 0.5rem; color: #9ca3af; text-decoration: none;">Support</a>
        </div>
        <div>
          <h4 style="color: white; margin-bottom: 1rem;">Légal</h4>
          <a href="#" style="display: block; margin-bottom: 0.5rem; color: #9ca3af; text-decoration: none;">CGU</a>
          <a href="#" style="display: block; margin-bottom: 0.5rem; color: #9ca3af; text-decoration: none;">Confidentialité</a>
          <a href="#" style="display: block; margin-bottom: 0.5rem; color: #9ca3af; text-decoration: none;">Mentions légales</a>
          <a href="#" style="display: block; margin-bottom: 0.5rem; color: #9ca3af; text-decoration: none;">RGPD</a>
        </div>
      </div>
      <div style="text-align: center; padding-top: 3rem; margin-top: 3rem; border-top: 1px solid #1e293b;">
        <p>© 2026 GoExploria — Tous droits réservés</p>
        <div style="display: flex; justify-content: center; gap: 1rem; margin-top: 1rem;">
          <span>🔒 Paiement sécurisé</span>
          <span>🇫🇷 Hébergé en France</span>
          <span>✅ RGPD conforme</span>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    document.querySelectorAll('.service-swiper-custom').forEach(swiperEl => {
      const slides = swiperEl.querySelectorAll('.swiper-slide');
      const slidesCount = slides.length;
      new Swiper(swiperEl, {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: slidesCount >= 2,
        autoplay: slidesCount >= 2 ? { delay: 4000, disableOnInteraction: false } : false,
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }
      });
    });

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