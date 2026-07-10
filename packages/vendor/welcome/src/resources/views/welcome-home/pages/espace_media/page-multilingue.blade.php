@extends('welcome-home.layouts.app')

@section('title', 'Multi Langue — Site web international multilingue')
@section('meta_description', 'Offrez une expérience multilingue à vos clients internationaux. Choisissez parmi 25 langues, SEO Google CDN inclus. Votre entreprise sans frontières commence ici.')

@section('breadcrumb')
<span class="current">Multi Langue</span>
@endsection

@section('page-styles')

/* =========================================================
   9. MULTILINGUE — International enterprise clean
   ========================================================= */
#multilingue-page{background:#f4f6f9}
.multi-hero{background:#fff;padding:80px 40px;border-bottom:2px solid #e8e2d9}
.multi-hero-inner{max-width:1200px;margin:0 auto;text-align:center}
.multi-hero-sub{font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#e8761a;margin-bottom:16px}
.multi-hero h1{font-family:'Outfit',sans-serif;font-size:clamp(40px,5vw,64px);font-weight:900;color:#1a1a1a;margin-bottom:20px}
.multi-hero p{font-size:17px;color:#666;line-height:1.8;max-width:600px;margin:0 auto 40px}
.multi-globe{display:inline-flex;align-items:center;gap:8px;font-size:14px;font-weight:600;color:#fff;background:#1a1a1a;padding:12px 24px;border-radius:999px}
.multi-hero-flags{display:flex;justify-content:center;gap:16px;margin-top:48px;flex-wrap:wrap}
.multi-flag-item{width:72px;height:72px;border-radius:50%;overflow:hidden;border:3px solid #fff;box-shadow:0 4px 16px rgba(0,0,0,0.12);transition:transform 0.2s}
.multi-flag-item:hover{transform:scale(1.1)}
.multi-flag-item img{width:100%;height:100%;object-fit:cover}

.multi-grid-section{padding:80px 40px;max-width:1300px;margin:0 auto}
.multi-grid-title{font-family:'Outfit',sans-serif;font-size:32px;font-weight:800;margin-bottom:48px;color:#1a1a1a}
.multi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:24px;margin-bottom:48px}
.multi-lang-card{background:#fff;border-radius:20px;border:2px solid #e5e7eb;padding:36px;text-align:center;position:relative;transition:all 0.3s}
.multi-lang-card:hover{border-color:#e8761a;transform:translateY(-4px);box-shadow:0 20px 40px rgba(232,118,26,0.12)}
.multi-lang-card.selected{border-color:#e8761a}
.multi-badge{position:absolute;top:-14px;left:50%;transform:translateX(-50%);font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;padding:4px 14px;border-radius:999px;white-space:nowrap}
.multi-badge.principale{background:#e8761a;color:#fff}
.multi-badge.populaire{background:#3b82f6;color:#fff}
.multi-badge.nouveau{background:#10b981;color:#fff}
.multi-badge.prochaine{background:#8b5cf6;color:#fff}
.multi-flag-circle{width:80px;height:80px;border-radius:50%;overflow:hidden;margin:16px auto 20px;border:3px solid #f0f0f0;box-shadow:0 4px 16px rgba(0,0,0,0.1)}
.multi-flag-circle img{width:100%;height:100%;object-fit:cover}
.multi-lang-name{font-size:18px;font-weight:700;color:#1a1a1a;margin-bottom:8px}
.multi-lang-desc{font-size:12px;color:#888;line-height:1.6;margin-bottom:20px}
.multi-select-btn{width:100%;padding:10px;border-radius:10px;border:1.5px solid #e5e7eb;background:#fff;font-size:13px;font-weight:700;cursor:pointer;transition:all 0.2s;display:flex;align-items:center;justify-content:center;gap:6px}
.multi-select-btn:hover{border-color:#e8761a;color:#e8761a}
.multi-select-btn.active{background:#e8761a;border-color:#e8761a;color:#fff}

.multi-seo-box{background:linear-gradient(135deg,#1e3a5f,#0f2240);border-radius:20px;padding:48px;margin-bottom:64px;display:grid;grid-template-columns:1fr auto;align-items:center;gap:40px}
.multi-seo-box h3{font-size:24px;font-weight:700;color:#fff;margin-bottom:10px;font-family:'Outfit',sans-serif}
.multi-seo-box p{font-size:14px;color:rgba(255,255,255,0.75);line-height:1.7}
.multi-seo-btn{background:#e8761a;color:#fff;padding:14px 32px;border-radius:10px;font-weight:700;font-size:14px;text-decoration:none;white-space:nowrap;display:inline-block}

@endsection

@section('content')
<!-- =====================================================
     9. MULTILINGUE
     ===================================================== -->
<section id="multilingue-page" class="section-page" style="padding:0;background:#f4f6f9">
  <div class="multi-hero">
    <div class="multi-hero-inner">
      <div class="multi-hero-sub"><i class="fas fa-globe-americas"></i> Espace Entreprise International</div>
      <h1 class="multi-hero" style="font-family:'Outfit',sans-serif;font-size:clamp(40px,5vw,64px);font-weight:900;color:#1a1a1a;margin-bottom:20px">Votre Entreprise<br>Sans Frontières</h1>
      <p style="font-size:17px;color:#666;line-height:1.8;max-width:600px;margin:0 auto 32px">Choisissez votre langue préférée afin de pénétrer les marchés internationaux et offrir une expérience d'achat exclusive à vos clients du monde entier. SEO Google CDN inclus.</p>
      <span class="multi-globe"><i class="fas fa-globe"></i> 25 langues disponibles · SEO Google CDN</span>
      <div class="multi-hero-flags">
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/fr.png" alt="France"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/gb.png" alt="UK"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/es.png" alt="Espagne"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/de.png" alt="Allemagne"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/cn.png" alt="Chine"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/in.png" alt="Inde"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/pt.png" alt="Portugal"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/sa.png" alt="Arabie"></div>
        <div class="multi-flag-item"><img src="https://flagcdn.com/w160/jp.png" alt="Japon"></div>
      </div>
    </div>
  </div>

  <div class="multi-grid-section">
    <h2 class="multi-grid-title">Choisissez votre langue principale</h2>
    <div class="multi-grid">
      <div class="multi-lang-card selected">
        <span class="multi-badge principale">PRINCIPALE</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/fr.png" alt="Français"></div>
        <div class="multi-lang-name">Français</div>
        <p class="multi-lang-desc">Langue originale. Contenu complet et support client en français 24h/7j.</p>
        <button class="multi-select-btn active"><i class="fas fa-check"></i> Sélectionné</button>
      </div>
      <div class="multi-lang-card">
        <span class="multi-badge populaire">POPULAIRE</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/gb.png" alt="Anglais"></div>
        <div class="multi-lang-name">English</div>
        <p class="multi-lang-desc">International version. Full content and 24/7 customer support available.</p>
        <button class="multi-select-btn"><i class="fas fa-globe"></i> Select</button>
      </div>
      <div class="multi-lang-card">
        <span class="multi-badge nouveau">NOUVEAU</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/es.png" alt="Espagnol"></div>
        <div class="multi-lang-name">Español</div>
        <p class="multi-lang-desc">Versión internacional completa con soporte al cliente en español.</p>
        <button class="multi-select-btn"><i class="fas fa-globe"></i> Seleccionar</button>
      </div>
      <div class="multi-lang-card">
        <span class="multi-badge prochaine">PROCHAINE</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/de.png" alt="Allemand"></div>
        <div class="multi-lang-name">Deutsch</div>
        <p class="multi-lang-desc">Internationale Version. Vollständiger Inhalt und Kundensupport.</p>
        <button class="multi-select-btn"><i class="fas fa-globe"></i> Auswählen</button>
      </div>
    </div>

    <!-- SEO box -->
    <div class="multi-seo-box">
      <div>
        <h3>🌐 SEO Google / CDN inclus avec chaque langue</h3>
        <p>Votre espace entreprise multilingue inclut un référencement Google optimisé pour chaque marché, un CDN mondial pour des temps de chargement ultra-rapides, et 4 à 25 langues disponibles selon votre plan. Atteignez vos clients partout dans le monde avec la même qualité d'expérience.</p>
      </div>
      <a href="#" class="multi-seo-btn">Voir les plans <i class="fas fa-arrow-right"></i></a>
    </div>

    <!-- Row 2 langues -->
    <h2 class="multi-grid-title">Langues stratégiques supplémentaires</h2>
    <div class="multi-grid">
      <div class="multi-lang-card">
        <span class="multi-badge principale">STRATÉGIQUE</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/cn.png" alt="Chinois"></div>
        <div class="multi-lang-name">中文</div>
        <p class="multi-lang-desc">Langue stratégique pour le marché asiatique de 1.4 milliard de consommateurs.</p>
        <button class="multi-select-btn"><i class="fas fa-globe"></i> 选择</button>
      </div>
      <div class="multi-lang-card">
        <span class="multi-badge populaire">POPULAIRE</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/in.png" alt="Hindi"></div>
        <div class="multi-lang-name">हिंदी</div>
        <p class="multi-lang-desc">Accédez au marché indien, deuxième économie mondiale émergente.</p>
        <button class="multi-select-btn"><i class="fas fa-globe"></i> चुनें</button>
      </div>
      <div class="multi-lang-card">
        <span class="multi-badge nouveau">NOUVEAU</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/pt.png" alt="Portugais"></div>
        <div class="multi-lang-name">Português</div>
        <p class="multi-lang-desc">Couvrez le Brésil, Portugal et toute la Lusophonie avec un seul contenu.</p>
        <button class="multi-select-btn"><i class="fas fa-globe"></i> Selecionar</button>
      </div>
      <div class="multi-lang-card">
        <span class="multi-badge prochaine">PROCHAINE</span>
        <div class="multi-flag-circle"><img src="https://flagcdn.com/w160/sa.png" alt="Arabe"></div>
        <div class="multi-lang-name">العربية</div>
        <p class="multi-lang-desc">Pénétrez les marchés du Golfe et du monde arabe avec une interface RTL parfaite.</p>
        <button class="multi-select-btn"><i class="fas fa-globe"></i> اختر</button>
      </div>
    </div>
  </div>
</section>


@endsection

@section('scripts')
<script>
// Animated counter for hero stats
function animateCounter(el, target, suffix) {
  let current = 0;
  const increment = target / 60;
  const timer = setInterval(() => {
    current += increment;
    if (current >= target) {
      current = target;
      clearInterval(timer);
    }
    el.textContent = Math.floor(current) + suffix;
  }, 16);
}
</script>
@endsection