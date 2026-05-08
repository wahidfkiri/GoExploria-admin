<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'GoExploria Business') — GoExploria</title>
<meta name="description" content="@yield('meta_description', 'GoExploria Business Platform — Solutions digitales pour le tourisme et les entreprises internationales.')">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600&family=Space+Grotesk:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Bebas+Neue&family=Outfit:wght@300;400;500;700;900&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;background:#f5f3ef;color:#1a1a1a}

/* NAV */
.site-nav{position:fixed;top:0;left:0;right:0;z-index:999;background:rgba(255,255,255,0.95);backdrop-filter:blur(12px);border-bottom:1px solid #e8e2d9;padding:0 40px}
.nav-inner{display:flex;align-items:center;justify-content:space-between;height:64px;max-width:1400px;margin:0 auto}
.nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.nav-logo-mark{width:36px;height:36px;background:linear-gradient(135deg,#e8761a,#c04f10);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:14px;font-family:'Bebas Neue',sans-serif;letter-spacing:1px}
.nav-logo-text{font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:15px;color:#1a1a1a;letter-spacing:-0.3px}
.nav-links{display:flex;gap:4px;list-style:none}
.nav-links a{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;color:#666;text-decoration:none;padding:6px 10px;border-radius:6px;transition:all 0.2s;white-space:nowrap}
.nav-links a:hover,.nav-links a.active{color:#e8761a;background:#fef3ea}
.nav-mobile-menu{display:none;cursor:pointer;font-size:22px;color:#1a1a1a}

/* BREADCRUMB */
.breadcrumb-bar{background:#fff;border-bottom:1px solid #e8e2d9;padding:12px 40px;margin-top:64px}
.breadcrumb-bar-inner{max-width:1400px;margin:0 auto;display:flex;align-items:center;gap:8px;font-size:12px;color:#888}
.breadcrumb-bar a{color:#888;text-decoration:none;transition:color 0.2s}
.breadcrumb-bar a:hover{color:#e8761a}
.breadcrumb-bar .sep{color:#ccc}
.breadcrumb-bar .current{color:#1a1a1a;font-weight:600}

/* BUTTONS */
.btn-orange{background:#e8761a;color:#fff;padding:14px 32px;border-radius:8px;font-weight:700;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all 0.2s;border:none;cursor:pointer}
.btn-orange:hover{background:#c45e0e;transform:translateY(-2px)}
.btn-outline{border:2px solid #1a1a1a;color:#1a1a1a;padding:14px 32px;border-radius:8px;font-weight:700;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all 0.2s;background:transparent;cursor:pointer}
.btn-outline:hover{background:#1a1a1a;color:#fff}
.btn-outline-white{border:2px solid rgba(255,255,255,0.4);color:#fff;padding:14px 32px;border-radius:8px;font-weight:700;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all 0.2s}
.btn-outline-white:hover{border-color:#fff;background:rgba(255,255,255,0.1)}

/* FOOTER */
.site-footer{background:#1a1a1a;padding:70px 40px 40px}
.footer-inner{max-width:1300px;margin:0 auto}
.footer-top{display:grid;grid-template-columns:2.5fr 1fr 1fr 1fr 1fr;gap:60px;margin-bottom:48px}
.footer-brand p{font-size:14px;color:rgba(255,255,255,0.5);line-height:1.8;margin-top:16px;max-width:280px}
.footer-col h4{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;color:rgba(255,255,255,0.35);margin-bottom:18px}
.footer-col ul{list-style:none;display:flex;flex-direction:column;gap:10px}
.footer-col ul li a{font-size:14px;color:rgba(255,255,255,0.65);text-decoration:none;transition:color 0.2s}
.footer-col ul li a:hover{color:#e8761a}
.footer-bottom{border-top:1px solid rgba(255,255,255,0.08);padding-top:28px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px}
.footer-bottom span{font-size:12px;color:rgba(255,255,255,0.3)}
.footer-socials{display:flex;gap:12px}
.footer-socials a{width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,0.06);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.5);font-size:15px;text-decoration:none;transition:all 0.2s}
.footer-socials a:hover{background:#e8761a;color:#fff}

/* SECTION TITLES */
.section-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#e8761a;margin-bottom:12px;display:flex;align-items:center;gap:8px}
.section-label::before{content:'';width:24px;height:2px;background:#e8761a}
.section-title-serif{font-family:'Playfair Display',serif;font-size:clamp(28px,3.5vw,44px);color:#1a1a1a;line-height:1.15;margin-bottom:16px}
.section-title-sans{font-family:'Space Grotesk',sans-serif;font-size:clamp(26px,3vw,40px);font-weight:700;color:#1a1a1a;line-height:1.15;margin-bottom:16px}
.section-desc{font-size:16px;color:#666;line-height:1.8;max-width:620px}

/* CTA BAND */
.cta-band{background:linear-gradient(135deg,#e8761a,#c04f10);padding:80px 40px;text-align:center}
.cta-band h2{font-family:'Playfair Display',serif;font-size:clamp(32px,4vw,52px);color:#fff;margin-bottom:16px}
.cta-band p{font-size:17px;color:rgba(255,255,255,0.85);line-height:1.7;max-width:600px;margin:0 auto 36px}

@media(max-width:1100px){.footer-top{grid-template-columns:1fr 1fr;gap:40px}}
@media(max-width:768px){
  .site-nav{padding:0 20px}
  .nav-links{display:none}
  .nav-mobile-menu{display:block}
  .breadcrumb-bar{padding:12px 20px}
  .footer-top{grid-template-columns:1fr 1fr;gap:32px}
}
@yield('page-styles')
</style>
@yield('extra-head')
</head>
<body>

<!-- NAV -->
<nav class="site-nav">
  <div class="nav-inner">
    <a href="{{ url('/') }}" class="nav-logo">
      <img src="{{ asset('logo.png') }}" alt="GoExploria Logo" style="width:150px;">
    </a>
    <ul class="nav-links">
      <li><a href="/avis-clients" class="{{ request()->is('avis-clients*') ? 'active' : '' }}">Avis Clients</a></li>
      <li><a href="/business-tourisme" class="{{ request()->is('business-tourisme*') ? 'active' : '' }}">Business</a></li>
      <li><a href="/page-destinations" class="{{ request()->is('page-destinations*') ? 'active' : '' }}">Destinations</a></li>
      <li><a href="/page-blog" class="{{ request()->is('page-blog*') ? 'active' : '' }}">Blog</a></li>
      <li><a href="/page-chat" class="{{ request()->is('page-chat*') ? 'active' : '' }}">Chat</a></li>
      <li><a href="/page-mail-marketing" class="{{ request()->is('page-mail-marketing*') ? 'active' : '' }}">Mail</a></li>
      <li><a href="/page-social-media" class="{{ request()->is('page-social-media*') ? 'active' : '' }}">Social</a></li>
      <li><a href="/page-galerie" class="{{ request()->is('page-galerie*') ? 'active' : '' }}">Galerie</a></li>
      <li><a href="/page-multilingue" class="{{ request()->is('page-multilingue*') ? 'active' : '' }}">Multilingue</a></li>
      <li><a href="/page-tiktok" class="{{ request()->is('page-tiktok*') ? 'active' : '' }}">TikTok</a></li>
      <li><a href="/page-videos" class="{{ request()->is('page-videos*') ? 'active' : '' }}">Vidéos</a></li>
      <li><a href="/page-medias" class="{{ request()->is('page-medias*') ? 'active' : '' }}">Chaines Médias</a></li>
    </ul>
    <div class="nav-mobile-menu"><i class="fas fa-bars"></i></div>
  </div>
</nav>

<!-- BREADCRUMB -->
@hasSection('breadcrumb')
<div class="breadcrumb-bar">
  <div class="breadcrumb-bar-inner">
    <a href="/">Accueil</a>
    <span class="sep">/</span>
    @yield('breadcrumb')
  </div>
</div>
@else
<div style="height:64px"></div>
@endif

<!-- MAIN CONTENT -->
@yield('content')

<!-- FOOTER -->
<footer class="site-footer">
  <div class="footer-inner">
    <div class="footer-top">
      <div class="footer-brand">
        <div style="display:flex;align-items:center;gap:10px">
          <div style="width:42px;height:42px;background:linear-gradient(135deg,#e8761a,#c04f10);border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:15px;color:#fff;font-family:'Bebas Neue',sans-serif">GO</div>
          <span style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:17px;color:#fff">GoExploria Business</span>
        </div>
        <p>La plateforme tout-en-un pour développer votre business touristique et rayonner à l'international. 15+ années d'expertise, 40 pays couverts.</p>
        <div class="footer-socials" style="margin-top:24px">
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-tiktok"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Solutions</h4>
        <ul>
          <li><a href="/business-tourisme">Business Web</a></li>
          <li><a href="/business-tourisme">Tourisme</a></li>
          <li><a href="/mail-marketing">Mail Marketing</a></li>
          <li><a href="/social-media">Social Media</a></li>
          <li><a href="/chat">Chat Unifié</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Contenu</h4>
        <ul>
          <li><a href="/destinations">Destinations</a></li>
          <li><a href="/blog">Blog Éditorial</a></li>
          <li><a href="/galerie">Galerie Photos</a></li>
          <li><a href="/tiktok">TikTok</a></li>
          <li><a href="/videos">Chaîne Vidéos</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Entreprise</h4>
        <ul>
          <li><a href="/avis-clients">Avis Clients</a></li>
          <li><a href="/multilingue">Multilingue</a></li>
          <li><a href="#">À propos</a></li>
          <li><a href="#">Carrières</a></li>
          <li><a href="#">Partenaires</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Contact</h4>
        <ul>
          <li><a href="mailto:info@goexploria.com"><i class="fas fa-envelope" style="color:#e8761a;margin-right:6px"></i>info@goexploria.com</a></li>
          <li><a href="#"><i class="fas fa-globe" style="color:#e8761a;margin-right:6px"></i>goexploria.com</a></li>
          <li><a href="#"><i class="fab fa-tiktok" style="color:#e8761a;margin-right:6px"></i>@goexploria.official</a></li>
          <li><a href="#"><i class="fab fa-instagram" style="color:#e8761a;margin-right:6px"></i>@goexploria</a></li>
          <li><a href="#"><i class="fab fa-whatsapp" style="color:#e8761a;margin-right:6px"></i>WhatsApp Pro</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© 2026 GoExploria Business. Tous droits réservés.</span>
      <span>Québec · Canada · International — 40 pays couverts</span>
    </div>
  </div>
</footer>

@yield('scripts')
</body>
</html>