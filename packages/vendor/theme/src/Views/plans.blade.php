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

  <!-- Navigation -->
  <nav class="nav">
    <div class="container nav-container">
      <div class="nav-logo" style="font-size: 1.3rem; font-weight: 800;">Go<span style="color: #4f46e5;">Exploria</span></div>
      <div class="nav-links">
        <a href="#" class="nav-link">Accueil</a>
        <a href="#solution" class="nav-link">Solution</a>
        <a href="#services" class="nav-link">Services</a>
        <a href="#contact" class="nav-link">Contact</a>
        <button class="btn-primary" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">Devis gratuit</button>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container hero-content">
      <div>
        <span class="hero-badge">🚀 La solution tout-en-un</span>
        <h1 class="hero-title">Transformez votre <span class="gradient-text">présence en ligne</span> avec notre plan premium</h1>
        <p class="hero-desc">Vidéos géolocalisées, site web, SEO, marketing automation — tout ce dont vous avez besoin pour booster votre business.</p>
        <button class="btn-primary" style="padding: 14px 32px;" onclick="document.getElementById('solution').scrollIntoView({behavior: 'smooth'})">Découvrir la solution →</button>
        <div class="hero-stats">
          <div class="hero-stat"><div class="value">+237%</div><div class="label">de visibilité</div></div>
          <div class="hero-stat"><div class="value">4.9★</div><div class="label">satisfaction</div></div>
          <div class="hero-stat"><div class="value">3k+</div><div class="label">clients actifs</div></div>
        </div>
      </div>
      <div>
        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=500&fit=crop" style="width: 100%; border-radius: 32px; box-shadow: 0 25px 40px -20px rgba(0,0,0,0.2);" alt="Dashboard">
      </div>
    </div>
  </section>

  <!-- SECTION SOLUTION HORIZONTALE -->
  <section class="solution-section" id="solution">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">📦 Notre solution</span>
        <h2 class="section-title">Tout votre <span class="gradient-text">digital</span> en une seule plateforme</h2>
        <p class="section-subtitle">Découvrez notre plan {{ $plan->name }} et toutes les applications incluses</p>
      </div>

      <div class="scroll-container">
        <button class="scroll-arrow left" id="scrollLeft">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button class="scroll-arrow right" id="scrollRight">
          <i class="fas fa-chevron-right"></i>
        </button>

        <div class="scroll-wrapper" id="scrollWrapper">
          
          <!-- Carte du Plan -->
          <div class="plan-card">
            <div class="plan-icon">
              <i class="fas fa-crown"></i>
            </div>
            <div class="plan-name">{{ $plan->name }}</div>
            <div class="plan-price">{{ $plan->formatted_price }}<span>/{{ $plan->billing_cycle ?? 'mois' }}</span></div>
            <div class="plan-feature"><i class="fas fa-check-circle"></i> Support prioritaire 24/7</div>
            <div class="plan-feature"><i class="fas fa-check-circle"></i> Analytics avancés</div>
            <div class="plan-feature"><i class="fas fa-check-circle"></i> Mises à jour incluses</div>
            <div class="plan-feature"><i class="fas fa-check-circle"></i> Sans engagement</div>
            @if($plan->is_popular)
              <div class="plan-badge">⭐ Plan le plus populaire</div>
            @endif
          </div>

          <!-- Apps intégrées - dynamiques depuis les plugins -->
          @foreach($plan->plugins as $plugin)
            @php
              $icons = [
                'vidéo' => 'fa-map-marker-alt',
                'site' => 'fa-laptop-code',
                'seo' => 'fa-chart-line',
                'mail' => 'fa-envelope-open-text',
                'chat' => 'fa-comments',
                'facture' => 'fa-file-invoice-dollar',
                'marketplace' => 'fa-store',
              ];
              $icon = 'fa-puzzle-piece';
              foreach($icons as $key => $ic) {
                if(stripos($plugin->name, $key) !== false) { $icon = $ic; break; }
              }
            @endphp
            <div class="app-card">
              <div class="app-icon">
                <i class="fas {{ $icon }}"></i>
              </div>
              <div class="app-name">{{ $plugin->name }}</div>
              <div class="app-desc">{{ Str::limit($plugin->description ?? 'Application premium incluse', 60) }}</div>
            </div>
          @endforeach

          <!-- Apps supplémentaires statiques -->
          <div class="app-card">
            <div class="app-icon"><i class="fas fa-file-invoice-dollar"></i></div>
            <div class="app-name">Gestion facturation</div>
            <div class="app-desc">Devis, factures, paiements Stripe/PayPal</div>
          </div>

          <div class="app-card">
            <div class="app-icon"><i class="fas fa-store"></i></div>
            <div class="app-name">Marketplace</div>
            <div class="app-desc">Vendez sur notre marketplace 50k+ visiteurs</div>
          </div>

          <div class="app-card">
            <div class="app-icon"><i class="fas fa-robot"></i></div>
            <div class="app-name">Assistant IA</div>
            <div class="app-desc">Chatbot intelligent 24/7</div>
          </div>

          <div class="app-card">
            <div class="app-icon"><i class="fas fa-chart-simple"></i></div>
            <div class="app-name">Analytics Pro</div>
            <div class="app-desc">Tableaux de bord en temps réel</div>
          </div>
        </div>
      </div>

      <!-- Indicateur de défilement -->
      <div style="text-align: center; margin-top: 24px;">
        <span style="display: inline-block; width: 8px; height: 8px; background: #4f46e5; border-radius: 50%; margin: 0 4px;"></span>
        <span style="display: inline-block; width: 8px; height: 8px; background: #cbd5e1; border-radius: 50%; margin: 0 4px;"></span>
        <span style="display: inline-block; width: 8px; height: 8px; background: #cbd5e1; border-radius: 50%; margin: 0 4px;"></span>
        <p style="font-size: 0.7rem; color: #94a3b8; margin-top: 12px;">← Faites défiler pour voir toutes les apps →</p>
      </div>
    </div>
  </section>

  <!-- Services Section rapide -->
  <section id="services" style="padding: 60px 0; background: #f8fafc;">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">⚡ Services inclus</span>
        <h2 class="section-title">Des <span class="gradient-text">solutions modulaires</span> pour tous vos besoins</h2>
        <p class="section-subtitle">Chaque service est conçu pour répondre précisément à vos objectifs digitaux</p>
      </div>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px;">
        @foreach($plan->plugins->take(6) as $plugin)
          <div style="background: white; border-radius: 20px; padding: 24px; border: 1px solid #e2e8f0;">
            <div style="width: 48px; height: 48px; background: #e0e7ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
              <i class="fas fa-puzzle-piece" style="color: #4f46e5;"></i>
            </div>
            <h3 style="margin-bottom: 8px;">{{ $plugin->name }}</h3>
            <p style="color: #64748b; font-size: 0.85rem; line-height: 1.5;">{{ $plugin->description ?? 'Service premium inclus dans votre plan' }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta-section">
    <div class="container">
      <h2>Prêt à transformer votre activité ?</h2>
      <p>Rejoignez plus de 3000 entreprises qui nous font confiance</p>
      <button class="btn-cta" onclick="document.getElementById('contact').scrollIntoView({behavior: 'smooth'})">
        <i class="fas fa-calendar-check"></i> Demander une démo gratuite
      </button>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" style="padding: 60px 0;">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">📞 Contactez-nous</span>
        <h2 class="section-title">Parlons de <span class="gradient-text">votre projet</span></h2>
        <p class="section-subtitle">Notre équipe vous répond sous 24h</p>
      </div>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px; background: #f8fafc; border-radius: 32px; padding: 48px;">
        <div>
          <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
            <div style="width: 48px; height: 48px; background: #e0e7ff; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-envelope" style="color: #4f46e5;"></i></div>
            <div><strong>Email</strong><br>hello@goexploria.com</div>
          </div>
          <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
            <div style="width: 48px; height: 48px; background: #e0e7ff; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-phone" style="color: #4f46e5;"></i></div>
            <div><strong>Téléphone</strong><br>+1 (514) 555-9210</div>
          </div>
          <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; background: #e0e7ff; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-map-marker-alt" style="color: #4f46e5;"></i></div>
            <div><strong>Adresse</strong><br>123 rue Saint-Denis, Montréal, QC</div>
          </div>
        </div>
        <div>
          <form style="display: flex; flex-direction: column; gap: 16px;">
            <input type="text" placeholder="Votre nom" style="padding: 14px 18px; border: 1px solid #e2e8f0; border-radius: 16px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
              <input type="email" placeholder="Email" style="padding: 14px 18px; border: 1px solid #e2e8f0; border-radius: 16px;">
              <input type="tel" placeholder="Téléphone" style="padding: 14px 18px; border: 1px solid #e2e8f0; border-radius: 16px;">
            </div>
            <select style="padding: 14px 18px; border: 1px solid #e2e8f0; border-radius: 16px;">
              <option>Service souhaité</option>
              @foreach($plan->plugins as $plugin)
                <option>{{ $plugin->name }}</option>
              @endforeach
            </select>
            <textarea rows="4" placeholder="Décrivez votre projet..." style="padding: 14px 18px; border: 1px solid #e2e8f0; border-radius: 16px;"></textarea>
            <button class="btn-primary" style="width: 100%;">Envoyer le message</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div>
          <div class="footer-logo">Go<span style="color: #4f46e5;">Exploria</span></div>
          <p style="margin-top: 16px; color: #64748b;">La plateforme tout-en-un pour les professionnels</p>
        </div>
        <div class="footer-links">
          <h4>Services</h4>
          @foreach($plan->plugins->take(5) as $plugin)
            <a href="#">{{ $plugin->name }}</a>
          @endforeach
        </div>
        <div class="footer-links">
          <h4>Ressources</h4>
          <a href="#">Blog</a>
          <a href="#">Documentation</a>
          <a href="#">API</a>
        </div>
        <div class="footer-links">
          <h4>Légal</h4>
          <a href="#">CGU</a>
          <a href="#">Confidentialité</a>
          <a href="#">Mentions légales</a>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© 2026 GoExploria — Tous droits réservés</p>
      </div>
    </div>
  </footer>

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