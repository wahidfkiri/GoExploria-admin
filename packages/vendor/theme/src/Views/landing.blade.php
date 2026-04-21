<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GoExploria — Solution digitale tout-en-un</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link rel="stylesheet" href="{{asset('vendor/theme/css/styles.css')}}">
</head>
<body>

  <!-- Navigation -->
  <nav class="nav">
    <div class="nav-container">
      <div class="nav-logo">
        <img src="{{asset('logo.png')}}" style="width:150px;"/>
      </div>
      <div class="nav-links">
        <a href="#services" class="nav-link">Services</a>
        <a href="#video-map" class="nav-link">Vidéo & Carte</a>
        <a href="#showcase" class="nav-link">Réalisations</a>
        <a href="#contact" class="nav-link">Contact</a>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="hero" id="hero">
    <div class="hero-slides" id="heroSlides">
      <div class="hero-slide">
        <div class="slide-bg">
          <img src="https://img.freepik.com/vecteurs-libre/fond-lignes-fluides-abstraites-2803_1048-7818.jpg" alt="Hero">
          <div class="slide-overlay"></div>
        </div>
        <div class="slide-content">
          <!-- <div class="slide-badge">✨ Solution digitale tout-en-un</div> -->
          <h1>Transformez votre <span class="gradient-text">présence en ligne</span><br>avec notre <span class="gradient-text">plan premium</span></h1>
          <p>Vidéos géolocalisées, site web, SEO, marketing automation — tout ce dont vous avez besoin pour booster votre business.</p>
          <div class="hero-actions">
            <button class="btn-primary btn-lg">Explorer les services →</button>
            <!-- <button class="btn-ghost btn-lg">Voir la démo</button> -->
          </div>
          <div class="hero-stats">
            <div class="hero-stat"><span>+237%</span> de visibilité</div>
            <div class="hero-stat"><span>4.9★</span> satisfaction client</div>
            <div class="hero-stat"><span>3k+</span> clients actifs</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES SECTION with detailed blocks -->
  <section class="section" id="services">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Nos services</span>
        <h2 class="section-title">Des <span class="gradient-text">solutions modulaires</span> pour tous vos besoins</h2>
        <p class="section-subtitle">Chaque service est conçu pour répondre précisément à vos objectifs digitaux.</p>
      </div>
    </div>

    <!-- SERVICE 1 : Vidéo sur la carte -->
    <div class="service-detail-block">
      <div class="container">
        <div class="service-detail-grid">
          <div class="service-detail-text">
            <div class="service-badge">📍 Géomarketing vidéo</div>
            <h3 class="service-detail-name">Vidéo sur la carte</h3>
            <p class="service-detail-description">Diffusez vos vidéos promotionnelles directement sur Google Maps et Apple Maps. Notre technologie brevetée de géolocalisation précise permet d'associer votre contenu vidéo à un emplacement stratégique. Quand un client recherche un commerce comme le vôtre à proximité, votre vidéo apparaît automatiquement, transformant les visiteurs en clients.</p>
            <div class="service-features">
              <div class="service-feature">Géolocalisation précise à 5 mètres près</div>
              <div class="service-feature">Rayon d'action personnalisable de 100m à 5km</div>
              <div class="service-feature">Lecture automatique au survol (sans son)</div>
              <div class="service-feature">Statistiques détaillées : vues, clics, durée</div>
              <div class="service-feature">Compatible Google Maps, Apple Maps, Waze</div>
            </div>
            <div class="service-stats">
              <div class="service-stat">
                <span class="stat-value">+237%</span>
                <span class="stat-label">de visibilité locale</span>
              </div>
              <div class="service-stat">
                <span class="stat-value">+156%</span>
                <span class="stat-label">de conversion</span>
              </div>
            </div>
            <button class="btn-primary">Découvrir ce service →</button>
          </div>
          <div class="service-detail-media">
            <div class="swiper service-swiper">
              <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1579869847514-7c1a19d2d2ad?w=800&h=500&fit=crop" alt="Carte Google Maps avec vidéo"></div>
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1524661135-423995f22d0f?w=800&h=500&fit=crop" alt="Géolocalisation précise"></div>
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?w=800&h=500&fit=crop" alt="Lecture vidéo sur mobile"></div>
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1569336415962-a4bd9f69cd83?w=800&h=500&fit=crop" alt="Analytics tableau de bord"></div>
              </div>
              <div class="swiper-pagination"></div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- SERVICE 2 : Création site web -->
    <div class="service-detail-block alt">
      <div class="container">
        <div class="service-detail-grid reverse">
          <div class="service-detail-text">
            <div class="service-badge">🌐 Création sur mesure</div>
            <h3 class="service-detail-name">Création site web</h3>
            <p class="service-detail-description">Obtenez un site web professionnel, moderne et ultra-rapide, livré en seulement 48 heures. Notre équipe de designers crée une interface unique qui reflète parfaitement votre identité de marque. Design responsive, animations fluides et expérience utilisateur optimisée pour maximiser vos conversions.</p>
            <div class="service-features">
              <div class="service-feature">Design unique et personnalisé sans template</div>
              <div class="service-feature">Responsive mobile-first (100% adapté)</div>
              <div class="service-feature">CMS intuitif avec interface drag & drop</div>
              <div class="service-feature">Livraison garantie en 48 heures</div>
              <div class="service-feature">Boutique e-commerce disponible sur demande</div>
            </div>
            <div class="service-stats">
              <div class="service-stat">
                <span class="stat-value">48h</span>
                <span class="stat-label">livraison express</span>
              </div>
              <div class="service-stat">
                <span class="stat-value">100%</span>
                <span class="stat-label">clients satisfaits</span>
              </div>
            </div>
            <button class="btn-primary">Découvrir ce service →</button>
          </div>
          <div class="service-detail-media">
            <div class="swiper service-swiper">
              <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800&h=500&fit=crop" alt="Site web moderne"></div>
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1547658719-da2b51169166?w=800&h=500&fit=crop" alt="Design responsive mobile"></div>
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=500&fit=crop" alt="Interface CMS"></div>
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1556075798-4825dfaaf498?w=800&h=500&fit=crop" alt="Dashboard administration"></div>
              </div>
              <div class="swiper-pagination"></div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- SERVICE 3 : SEO & Visibilité -->
    <div class="service-detail-block">
      <div class="container">
        <div class="service-detail-grid">
          <div class="service-detail-text">
            <div class="service-badge">📈 Référencement naturel</div>
            <h3 class="service-detail-name">SEO & Visibilité Google</h3>
            <p class="service-detail-description">Atteignez la première page de Google grâce à notre stratégie SEO complète et personnalisée. Nous réalisons un audit technique approfondi de votre site, identifions les mots-clés les plus pertinents pour votre activité, et mettons en place une stratégie de netlinking de qualité. Suivez vos positions en temps réel grâce à nos rapports mensuels détaillés.</p>
            <div class="service-features">
              <div class="service-feature">Audit technique complet (vitesse, maillage, balises)</div>
              <div class="service-feature">Recherche de mots-clés à forte intention d'achat</div>
              <div class="service-feature">Stratégie de netlinking avec sites de qualité</div>
              <div class="service-feature">Rapports mensuels avec recommandations</div>
              <div class="service-feature">Optimisation Google My Business (Local SEO)</div>
            </div>
            <div class="service-stats">
              <div class="service-stat">
                <span class="stat-value">Top 10</span>
                <span class="stat-label">mots-clés visés</span>
              </div>
              <div class="service-stat">
                <span class="stat-value">30 jours</span>
                <span class="stat-label">premiers résultats</span>
              </div>
            </div>
            <button class="btn-primary">Découvrir ce service →</button>
          </div>
          <div class="service-detail-media">
            <div class="swiper service-swiper">
              <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?w=800&h=500&fit=crop" alt="Analyse SEO"></div>
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1562577309-4932fdd64cd1?w=800&h=500&fit=crop" alt="Recherche mots-clés"></div>
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=500&fit=crop" alt="Positionnement Google"></div>
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=500&fit=crop" alt="Tableau de bord SEO"></div>
              </div>
              <div class="swiper-pagination"></div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- SERVICE 4 : Mail Marketing -->
    <div class="service-detail-block alt">
      <div class="container">
        <div class="service-detail-grid reverse">
          <div class="service-detail-text">
            <div class="service-badge">✉️ Marketing automation</div>
            <h3 class="service-detail-name">Mail Marketing</h3>
            <p class="service-detail-description">Boostez vos ventes avec des campagnes email marketing intelligentes et entièrement automatisées. Notre plateforme vous permet de segmenter votre audience selon son comportement, de tester différentes versions (A/B testing) et d'optimiser vos taux d'ouverture et de conversion. Des rapports détaillés vous aident à affiner votre stratégie.</p>
            <div class="service-features">
              <div class="service-feature">Campagnes automatisées (drip marketing et scénarios)</div>
              <div class="service-feature">Segmentation avancée par comportement d'achat</div>
              <div class="service-feature">A/B testing sur objets, contenus et horaires</div>
              <div class="service-feature">Taux d'ouverture moyen supérieur à 42%</div>
              <div class="service-feature">Analytics détaillés et heatmaps des clics</div>
            </div>
            <div class="service-stats">
              <div class="service-stat">
                <span class="stat-value">42%</span>
                <span class="stat-label">taux d'ouverture</span>
              </div>
              <div class="service-stat">
                <span class="stat-value">18%</span>
                <span class="stat-label">taux de clic</span>
              </div>
            </div>
            <button class="btn-primary">Découvrir ce service →</button>
          </div>
          <div class="service-detail-media">
            <div class="swiper service-swiper">
              <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1512626120412-faf41adb4874?w=800&h=500&fit=crop" alt="Email marketing"></div>
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1557838923-2985c318be48?w=800&h=500&fit=crop" alt="Campagne email"></div>
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1555421689-491a97ff2040?w=800&h=500&fit=crop" alt="Analytics email"></div>
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800&h=500&fit=crop" alt="Dashboard marketing"></div>
              </div>
              <div class="swiper-pagination"></div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- SERVICE 5 : Gestion facturation -->
    <div class="service-detail-block">
      <div class="container">
        <div class="service-detail-grid">
          <div class="service-detail-text">
            <div class="service-badge">💳 Finance simplifiée</div>
            <h3 class="service-detail-name">Gestion facturation</h3>
            <p class="service-detail-description">Centralisez l'ensemble de votre gestion financière sur une seule plateforme intuitive. Créez des devis et factures personnalisables en quelques clics, programmez des relances automatiques par email, et suivez vos paiements en temps réel. L'intégration native avec Stripe et PayPal vous permet d'encaisser vos clients directement en ligne.</p>
            <div class="service-features">
              <div class="service-feature">Devis et factures personnalisables avec votre logo</div>
              <div class="service-feature">Relances automatiques par email (échéances)</div>
              <div class="service-feature">Intégration Stripe, PayPal et virement SEPA</div>
              <div class="service-feature">Export comptable (CSV, Excel, PDF, EBP)</div>
              <div class="service-feature">Tableau de bord financier en temps réel</div>
            </div>
            <div class="service-stats">
              <div class="service-stat">
                <span class="stat-value">-72h</span>
                <span class="stat-label">délai de paiement réduit</span>
              </div>
              <div class="service-stat">
                <span class="stat-value">100%</span>
                <span class="stat-label">process automatisé</span>
              </div>
            </div>
            <button class="btn-primary">Découvrir ce service →</button>
          </div>
          <div class="service-detail-media">
            <div class="swiper service-swiper">
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
    </div>

    <!-- SERVICE 6 : Chat en ligne -->
    <div class="service-detail-block alt">
      <div class="container">
        <div class="service-detail-grid reverse">
          <div class="service-detail-text">
            <div class="service-badge">💬 Support intelligent</div>
            <h3 class="service-detail-name">Chat en ligne</h3>
            <p class="service-detail-description">Offrez une expérience client exceptionnelle avec notre widget de chat intelligent. Notre assistant IA répond automatiquement aux questions fréquentes 24h/24 et 7j/7, avec la possibilité de transférer la conversation à un agent humain quand nécessaire. Un historique complet des conversations vous permet de suivre la satisfaction client.</p>
            <div class="service-features">
              <div class="service-feature">Assistant IA pour réponses automatiques 24/7</div>
              <div class="service-feature">Transfert fluide vers un agent humain</div>
              <div class="service-feature">Disponible sur site web, mobile et WhatsApp</div>
              <div class="service-feature">Historique complet des conversations</div>
              <div class="service-feature">Personnalisation des couleurs et messages</div>
            </div>
            <div class="service-stats">
              <div class="service-stat">
                <span class="stat-value">-50%</span>
                <span class="stat-label">temps de réponse</span>
              </div>
              <div class="service-stat">
                <span class="stat-value">24/7</span>
                <span class="stat-label">disponibilité</span>
              </div>
            </div>
            <button class="btn-primary">Découvrir ce service →</button>
          </div>
          <div class="service-detail-media">
            <div class="swiper service-swiper">
              <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1587560699334-cc4ff634909a?w=800&h=500&fit=crop" alt="Chat en ligne"></div>
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1531746790731-6c087fecd65a?w=800&h=500&fit=crop" alt="Assistant IA"></div>
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=500&fit=crop" alt="Support client"></div>
              </div>
              <div class="swiper-pagination"></div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- SERVICE 7 : Marketplace -->
    <div class="service-detail-block">
      <div class="container">
        <div class="service-detail-grid">
          <div class="service-detail-text">
            <div class="service-badge">🛒 Vendez partout</div>
            <h3 class="service-detail-name">Marketplace intégrée</h3>
            <p class="service-detail-description">Développez votre chiffre d'affaires en vendant vos produits et services sur notre marketplace intégrée. Bénéficiez d'une visibilité accrue auprès de nos 50 000 visiteurs mensuels. La gestion des stocks, des commandes et des livraisons est entièrement unifiée, et vous définissez librement vos commissions.</p>
            <div class="service-features">
              <div class="service-feature">Multi-vendeurs avec commission personnalisable</div>
              <div class="service-feature">Gestion centralisée des stocks en temps réel</div>
              <div class="service-feature">Commandes et livraisons unifiées</div>
              <div class="service-feature">Commission personnalisable de 0 à 20%</div>
              <div class="service-feature">Support logistique et service client inclus</div>
            </div>
            <div class="service-stats">
              <div class="service-stat">
                <span class="stat-value">+156%</span>
                <span class="stat-label">de ventes générées</span>
              </div>
              <div class="service-stat">
                <span class="stat-value">50k+</span>
                <span class="stat-label">visiteurs par mois</span>
              </div>
            </div>
            <button class="btn-primary">Découvrir ce service →</button>
          </div>
          <div class="service-detail-media">
            <div class="swiper service-swiper">
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
    </div>
  </section>

  <!-- Video Map Showcase -->
  <section class="section section-alt" id="video-map">
    <div class="container">
      <div class="video-showcase-grid">
        <div class="video-showcase-content">
          <span class="section-tag">Démonstration interactive</span>
          <h2 class="section-title">Votre vidéo <span class="gradient-text">prend vie</span> sur la carte</h2>
          <p>Notre technologie brevetée permet d'associer n'importe quelle vidéo à un emplacement géographique précis. Vos clients la découvrent au moment où ils sont le plus réceptifs.</p>
          <div class="video-features">
            <div class="video-feature">
              <div class="vf-icon">🎯</div>
              <div class="vf-text">
                <strong>Géolocalisation précise</strong>
                <span>Rayon personnalisable de 100m à 5km</span>
              </div>
            </div>
            <div class="video-feature">
              <div class="vf-icon">📊</div>
              <div class="vf-text">
                <strong>Analytics en temps réel</strong>
                <span>Vues, clics, durée de visionnage</span>
              </div>
            </div>
          </div>
          <button class="btn-primary">Voir la démo vidéo →</button>
        </div>
        <div class="video-showcase-media">
          <div class="video-wrapper">
            <video id="demoVideo" poster="https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&h=500&fit=crop">
              <source src="https://storage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4" type="video/mp4">
            </video>
            <button class="video-play-btn" id="videoPlayBtn">
              <svg viewBox="0 0 24 24" fill="white" width="32" height="32"><polygon points="5 3 19 12 5 21 5 3" fill="white"/></svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Showcase -->
  <section class="section" id="showcase">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Portfolio</span>
        <h2 class="section-title">Ils nous font <span class="gradient-text">confiance</span></h2>
        <p class="section-subtitle">Découvrez comment nos clients ont transformé leur présence digitale.</p>
      </div>
      <div class="showcase-grid">
        <div class="showcase-item">
          <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=600&h=400&fit=crop" alt="Restaurant">
          <div class="showcase-overlay">
            <div class="showcase-info">
              <h4>Le Petit Bistro</h4>
              <p>+156% de réservations en ligne</p>
              <span class="showcase-tag">Vidéo sur carte</span>
            </div>
          </div>
        </div>
        <div class="showcase-item">
          <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600&h=400&fit=crop" alt="Café">
          <div class="showcase-overlay">
            <div class="showcase-info">
              <h4>La Maison du Café</h4>
              <p>+89% de clients en boutique</p>
              <span class="showcase-tag">SEO + Site web</span>
            </div>
          </div>
        </div>
        <div class="showcase-item">
          <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=600&h=400&fit=crop" alt="Immobilier">
          <div class="showcase-overlay">
            <div class="showcase-info">
              <h4>Immobilier Premium</h4>
              <p>+234 leads qualifiés/mois</p>
              <span class="showcase-tag">Pack complet</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section class="section section-alt" id="contact">
    <div class="container">
      <div class="contact-wrapper">
        <div class="contact-info">
          <span class="section-tag">Contactez-nous</span>
          <h2 class="section-title">Parlons de <span class="gradient-text">votre projet</span></h2>
          <p>Notre équipe vous répond sous 24h et vous propose une démo personnalisée gratuite.</p>
          <div class="contact-details">
            <div class="contact-item">
              <div class="contact-icon">📧</div>
              <div>hello@goexploria.com</div>
            </div>
            <div class="contact-item">
              <div class="contact-icon">📞</div>
              <div>+1 (514) 555-9210</div>
            </div>
            <div class="contact-item">
              <div class="contact-icon">📍</div>
              <div>123 rue Saint-Denis, Montréal, QC</div>
            </div>
          </div>
        </div>
        <div class="contact-form">
          <div class="form-group">
            <input type="text" placeholder="Votre nom" class="form-input">
          </div>
          <div class="form-row">
            <div class="form-group">
              <input type="email" placeholder="Email professionnel" class="form-input">
            </div>
            <div class="form-group">
              <input type="tel" placeholder="Téléphone" class="form-input">
            </div>
          </div>
          <div class="form-group">
            <select class="form-select">
              <option value="">Service souhaité</option>
              <option>Vidéo sur carte</option>
              <option>Création site web</option>
              <option>SEO & visibilité</option>
              <option>Mail marketing</option>
              <option>Gestion facturation</option>
              <option>Chat en ligne</option>
              <option>Marketplace</option>
            </select>
          </div>
          <div class="form-group">
            <textarea rows="4" placeholder="Décrivez votre projet..." class="form-textarea"></textarea>
          </div>
          <button class="btn-primary btn-block">Envoyer le message</button>
          <p class="form-note">Sans engagement · Démo gratuite · Réponse sous 24h</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <div class="footer-logo">Go<span class="accent">Exploria</span></div>
          <p>La plateforme tout-en-un pour les professionnels qui veulent grandir en ligne.</p>
          <div class="footer-socials">
            <a href="#" class="social-link">in</a>
            <a href="#" class="social-link">fb</a>
            <a href="#" class="social-link">tw</a>
          </div>
        </div>
        <div class="footer-links">
          <h4>Services</h4>
          <a href="#">Vidéo sur carte</a>
          <a href="#">Création site web</a>
          <a href="#">SEO & visibilité</a>
          <a href="#">Mail marketing</a>
          <a href="#">Marketplace</a>
        </div>
        <div class="footer-links">
          <h4>Ressources</h4>
          <a href="#">Blog</a>
          <a href="#">Documentation</a>
          <a href="#">API</a>
          <a href="#">Support</a>
        </div>
        <div class="footer-links">
          <h4>Légal</h4>
          <a href="#">CGU</a>
          <a href="#">Confidentialité</a>
          <a href="#">Mentions légales</a>
          <a href="#">RGPD</a>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© 2026 GoExploria — Tous droits réservés</p>
        <div class="footer-badges">
          <span>🔒 Paiement sécurisé</span>
          <span>🇫🇷 Hébergé en France</span>
          <span>✅ RGPD conforme</span>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    // Initialize all Swipers
    document.querySelectorAll('.service-swiper').forEach(swiperEl => {
      new Swiper(swiperEl, {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        autoplay: { delay: 4000, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }
      });
    });

    // Theme toggle
    const html = document.documentElement;
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    document.getElementById('themeBtn')?.addEventListener('click', () => {
      const current = html.getAttribute('data-theme');
      const next = current === 'dark' ? 'light' : 'dark';
      html.setAttribute('data-theme', next);
      localStorage.setItem('theme', next);
    });

    // Video play button
    const videoPlayBtn = document.getElementById('videoPlayBtn');
    const demoVideo = document.getElementById('demoVideo');
    if (videoPlayBtn && demoVideo) {
      videoPlayBtn.addEventListener('click', () => {
        if (demoVideo.paused) {
          demoVideo.play();
          videoPlayBtn.style.opacity = '0';
        } else {
          demoVideo.pause();
          videoPlayBtn.style.opacity = '1';
        }
      });
      demoVideo.addEventListener('pause', () => { videoPlayBtn.style.opacity = '1'; });
      demoVideo.addEventListener('play', () => { videoPlayBtn.style.opacity = '0'; });
    }
  </script>
</body>
</html>