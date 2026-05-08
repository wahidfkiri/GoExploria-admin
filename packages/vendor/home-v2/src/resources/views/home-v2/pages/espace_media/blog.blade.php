@extends('home-v2.layouts.app')

@section('title', 'Blog Éditorial — Le Magazine du Voyage GoExploria')


@section('page-styles')
<style>
/* MASTHEAD */
.blog-masthead{background:#f0ece4;padding:80px 40px 0;overflow:hidden}
.blog-masthead-inner{max-width:1300px;margin:0 auto}
.blog-masthead-top{display:grid;grid-template-columns:1fr auto;align-items:end;gap:40px;padding-bottom:40px;border-bottom:2px solid #1a1a1a;margin-bottom:48px}
.blog-masthead-meta{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#999;margin-bottom:12px}
.blog-title{font-family:'Playfair Display',serif;font-size:clamp(52px,7vw,84px);line-height:0.93;color:#1a1a1a}
.blog-title em{font-style:italic;color:#e8761a}
.blog-date-box{text-align:right}
.blog-date-num{font-family:'Bebas Neue',sans-serif;font-size:88px;color:#1a1a1a;line-height:1}
.blog-date-label{font-size:12px;color:#999;text-transform:uppercase;letter-spacing:1px}

/* HERO GRID */
.blog-hero-grid{display:grid;grid-template-columns:2fr 1fr;gap:3px;margin-bottom:3px}
.blog-feature{position:relative;height:540px;overflow:hidden;cursor:pointer}
.blog-feature img{width:100%;height:100%;object-fit:cover;transition:transform 0.6s}
.blog-feature:hover img{transform:scale(1.04)}
.blog-feature-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.88),transparent 55%);padding:40px;display:flex;flex-direction:column;justify-content:flex-end}
.cat-tag{display:inline-block;background:#e8761a;color:#fff;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;padding:4px 12px;border-radius:3px;margin-bottom:12px;width:fit-content}
.blog-feature h2{font-family:'Playfair Display',serif;font-size:32px;color:#fff;line-height:1.2;margin-bottom:12px}
.blog-feature p{font-size:14px;color:rgba(255,255,255,0.8)}
.blog-side{display:flex;flex-direction:column;gap:3px}
.blog-mini{position:relative;height:269px;overflow:hidden;cursor:pointer}
.blog-mini img{width:100%;height:100%;object-fit:cover;transition:transform 0.4s}
.blog-mini:hover img{transform:scale(1.06)}
.blog-mini-content{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.82),transparent 55%);padding:20px;display:flex;flex-direction:column;justify-content:flex-end}
.blog-mini-content h4{font-family:'Playfair Display',serif;font-size:18px;color:#fff;margin-bottom:6px;line-height:1.3}
.blog-mini-content span{font-size:11px;color:rgba(255,255,255,0.65)}

/* CATEGORIES NAV */
.blog-cats{background:#fff;padding:24px 40px;border-bottom:1px solid #e5e7eb;position:sticky;top:64px;z-index:10}
.blog-cats-inner{max-width:1300px;margin:0 auto;display:flex;gap:8px;flex-wrap:wrap;align-items:center}
.blog-cat-btn{border:1.5px solid #e5e7eb;background:#fff;border-radius:999px;font-size:12px;font-weight:700;color:#666;padding:7px 16px;cursor:pointer;transition:all 0.2s;display:flex;align-items:center;gap:6px}
.blog-cat-btn:hover,.blog-cat-btn.active{border-color:#e8761a;color:#e8761a;background:#fef3ea}
.blog-cat-btn .count{background:#f0ebe2;color:#888;font-size:10px;padding:1px 7px;border-radius:999px;font-weight:700}
.blog-cat-btn.active .count{background:#fde4c5;color:#e8761a}

/* ARTICLES */
.blog-articles{background:#fff;padding:64px 40px}
.blog-articles-inner{max-width:1300px;margin:0 auto}
.blog-grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:36px;margin-bottom:36px}
.blog-article-card{border-bottom:1px solid #f0f0f0;padding-bottom:28px;cursor:pointer;transition:transform 0.2s}
.blog-article-card:hover{transform:translateY(-3px)}
.blog-article-card:hover .blog-article-img img{transform:scale(1.04)}
.blog-article-img{height:220px;border-radius:14px;overflow:hidden;margin-bottom:18px}
.blog-article-img img{width:100%;height:100%;object-fit:cover;transition:transform 0.5s}
.blog-article-meta{display:flex;align-items:center;gap:10px;margin-bottom:10px;flex-wrap:wrap}
.blog-article-cat{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#e8761a}
.blog-article-date{font-size:11px;color:#999}
.blog-article-card h3{font-family:'Playfair Display',serif;font-size:19px;line-height:1.3;color:#1a1a1a;margin-bottom:10px}
.blog-article-card p{font-size:13px;color:#666;line-height:1.7;margin-bottom:10px}
.blog-read-more{display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:700;color:#e8761a;text-decoration:none;text-transform:uppercase;letter-spacing:0.5px}
.blog-author-mini{display:flex;align-items:center;gap:8px;margin-top:14px;padding-top:14px;border-top:1px solid #f5f5f5}
.blog-author-mini img{width:28px;height:28px;border-radius:50%;object-fit:cover}
.blog-author-mini span{font-size:11px;color:#888}
.blog-author-mini strong{font-size:12px;color:#1a1a1a;font-weight:600}

/* NEWSLETTER */
.blog-newsletter{background:linear-gradient(135deg,#1a1a1a,#2d2d2d);padding:80px 40px}
.blog-newsletter-inner{max-width:760px;margin:0 auto;text-align:center}
.blog-newsletter-inner h2{font-family:'Playfair Display',serif;font-size:36px;color:#fff;margin-bottom:14px}
.blog-newsletter-inner p{font-size:16px;color:rgba(255,255,255,0.65);line-height:1.75;margin-bottom:36px}
.blog-newsletter-form{display:flex;gap:12px;max-width:480px;margin:0 auto}
.blog-newsletter-form input{flex:1;padding:14px 20px;border-radius:8px;border:none;font-size:14px;outline:none;font-family:'DM Sans',sans-serif}
.blog-newsletter-form button{background:#e8761a;color:#fff;border:none;padding:14px 24px;border-radius:8px;font-weight:700;font-size:14px;cursor:pointer;white-space:nowrap;transition:background 0.2s}
.blog-newsletter-form button:hover{background:#c45e0e}
.blog-newsletter-trust{font-size:12px;color:rgba(255,255,255,0.4);margin-top:14px}

/* TRENDING + POPULAR TAGS */
.blog-sidebar-section{background:#faf7f2;padding:64px 40px}
.blog-sidebar-inner{max-width:1300px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:60px}
.blog-trending-list{display:flex;flex-direction:column;gap:20px;margin-top:32px}
.blog-trending-item{display:grid;grid-template-columns:auto 1fr;gap:16px;align-items:center}
.blog-trending-num{font-family:'Bebas Neue',sans-serif;font-size:48px;color:#f0ebe2;line-height:1;min-width:44px}
.blog-trending-item h4{font-size:15px;font-weight:700;color:#1a1a1a;margin-bottom:4px;line-height:1.3;cursor:pointer;transition:color 0.2s}
.blog-trending-item h4:hover{color:#e8761a}
.blog-trending-item span{font-size:12px;color:#888}
.blog-tag-cloud{display:flex;flex-wrap:wrap;gap:10px;margin-top:32px}
.blog-tag{background:#fff;border:1.5px solid #e5e7eb;border-radius:999px;font-size:12px;font-weight:600;color:#555;padding:6px 16px;cursor:pointer;transition:all 0.2s}
.blog-tag:hover{border-color:#e8761a;color:#e8761a;background:#fef3ea}

@media(max-width:1000px){
  .blog-hero-grid{grid-template-columns:1fr}
  .blog-side{flex-direction:row}
  .blog-mini{flex:1}
  .blog-grid-3{grid-template-columns:1fr 1fr}
  .blog-sidebar-inner{grid-template-columns:1fr}
  .blog-newsletter-form{flex-direction:column}
}
@media(max-width:700px){
  .blog-grid-3{grid-template-columns:1fr}
  .blog-cats{padding:16px 20px}
  .blog-masthead-top{grid-template-columns:1fr}
}
</style>
@endsection

@section('content')

<!-- MASTHEAD -->
<div class="blog-masthead">
  <div class="blog-masthead-inner">
    <div class="blog-masthead-top">
      <div>
        <div class="blog-masthead-meta">GoExploria · Espace Blog Éditorial</div>
        <h1 class="blog-title">Le<br><em>Magazine</em><br>du Voyage</h1>
      </div>
      <div class="blog-date-box">
        <div class="blog-date-num">07</div>
        <div class="blog-date-label">Mai 2026</div>
      </div>
    </div>
  </div>
  <div class="blog-hero-grid">
    <div class="blog-feature">
      <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?w=1200&h=700&fit=crop" alt="Feature">
      <div class="blog-feature-overlay">
        <span class="cat-tag">Business</span>
        <h2>Les PME canadiennes tablent sur une croissance record en 2026</h2>
        <p>Analyse des tendances, marketing d'influence et accélération digitale pour les entrepreneurs du Québec</p>
        <div style="display:flex;align-items:center;gap:12px;margin-top:16px;font-size:12px;color:rgba(255,255,255,0.7)">
          <span><i class="fas fa-user"></i> Stiven Jackson</span>
          <span><i class="fas fa-calendar"></i> 16 Mars 2026</span>
          <span><i class="fas fa-clock"></i> 8 min</span>
        </div>
      </div>
    </div>
    <div class="blog-side">
      <div class="blog-mini">
        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=400&fit=crop" alt="">
        <div class="blog-mini-content">
          <span class="cat-tag" style="font-size:9px;padding:3px 8px">Marketing</span>
          <h4>Les CMO B2B augmentent drastiquement leurs dépenses médias</h4>
          <span>16 Mars 2026</span>
        </div>
      </div>
      <div class="blog-mini">
        <img src="https://images.unsplash.com/photo-1527631746610-bca00a040d60?w=600&h=400&fit=crop" alt="">
        <div class="blog-mini-content">
          <span class="cat-tag" style="background:#2563eb;font-size:9px;padding:3px 8px">Travel</span>
          <h4>La demande de workation explose pour les équipes nomades</h4>
          <span>14 Mars 2026</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CATS NAV -->
<div class="blog-cats">
  <div class="blog-cats-inner">
    <button class="blog-cat-btn active">Tous <span class="count">42</span></button>
    <button class="blog-cat-btn"><i class="fas fa-briefcase"></i> Business <span class="count">12</span></button>
    <button class="blog-cat-btn"><i class="fas fa-plane"></i> Travel <span class="count">9</span></button>
    <button class="blog-cat-btn"><i class="fas fa-laptop"></i> Tech <span class="count">7</span></button>
    <button class="blog-cat-btn"><i class="fas fa-utensils"></i> Gastronomie <span class="count">6</span></button>
    <button class="blog-cat-btn"><i class="fas fa-mountain"></i> Aventure <span class="count">5</span></button>
    <button class="blog-cat-btn"><i class="fas fa-paint-brush"></i> Culture <span class="count">3</span></button>
  </div>
</div>

<!-- ARTICLES -->
<div class="blog-articles">
  <div class="blog-articles-inner">
    <div class="section-label">À la une</div>
    <div class="blog-grid-3">
      @php
      $articles = [
        ['img'=>'photo-1507525428034-b723cf961d3e','cat'=>'Travel','cat_color'=>'#e8761a','date'=>'14 Mars 2026','read'=>'6 min','title'=>'Tendances voyages à distance et escapades travail-vie','desc'=>'Les professionnels recherchent des destinations offrant haut débit, espaces de coworking et expériences locales authentiques.','author_img'=>'photo-1472099645785-5658abf4ff4e','author'=>'Jean-Michel Roy'],
        ['img'=>'photo-1519389950473-47ba0277781c','cat'=>'Tech','cat_color'=>'#2563eb','date'=>'13 Mars 2026','read'=>'5 min','title'=>'L\'IA copilote transforme les salles de rédaction et la vitesse d\'édition','desc'=>'Comment les outils d\'intelligence artificielle révolutionnent la production de contenu dans les médias, permettant de publier cinq fois plus vite.','author_img'=>'photo-1560250097-0b93528c311a','author'=>'Stiven Jackson'],
        ['img'=>'photo-1552664730-d307ca884978','cat'=>'Business','cat_color'=>'#e8761a','date'=>'12 Mars 2026','read'=>'7 min','title'=>'Les nouvelles brasseries artisanales attirent une génération d\'entrepreneurs','desc'=>'Phénomène mondial, la bière artisanale devient un vecteur d\'entrepreneuriat local, de tourisme et de développement économique.','author_img'=>'photo-1494790108377-be9c29b29330','author'=>'Marie-Claude B.'],
        ['img'=>'photo-1539635278303-d4002c07eae3','cat'=>'Aventure','cat_color'=>'#10b981','date'=>'11 Mars 2026','read'=>'9 min','title'=>'Randonnée hivernale en Gaspésie : le guide ultime 2026','desc'=>'Préparez votre aventure dans l\'une des plus belles péninsules sauvages d\'Amérique du Nord avec nos conseils d\'experts locaux.','author_img'=>'photo-1531123897727-8f129e1688ce','author'=>'Élise Tanguay'],
        ['img'=>'photo-1414235077428-338989a2e8c0','cat'=>'Gastronomie','cat_color'=>'#f59e0b','date'=>'10 Mars 2026','read'=>'4 min','title'=>'Top 10 des restaurants gastronomiques à Montréal cette saison','desc'=>'Notre sélection des adresses incontournables de la scène culinaire montréalaise, des tables d\'exception aux bistros tendance.','author_img'=>'photo-1507003211169-0a1dd7228f2d','author'=>'Félix Arsenault'],
        ['img'=>'photo-1475503572774-15a45e5d60b9','cat'=>'Culture','cat_color'=>'#8b5cf6','date'=>'8 Mars 2026','read'=>'5 min','title'=>'Le printemps cultural québécois : festivals et événements à ne pas manquer','desc'=>'De Québec à Montréal, la saison culturelle 2026 promet une programmation exceptionnelle : musique, arts visuels et célébrations locales.','author_img'=>'photo-1580489944761-15a19d654956','author'=>'Aurélie Morin'],
      ];
      @endphp
      @foreach($articles as $a)
      <div class="blog-article-card">
        <div class="blog-article-img">
          <img src="https://images.unsplash.com/{{ $a['img'] }}?w=640&h=360&fit=crop" alt="{{ $a['title'] }}">
        </div>
        <div class="blog-article-meta">
          <span class="blog-article-cat" style="color:{{ $a['cat_color'] }}">{{ $a['cat'] }}</span>
          <span style="color:#e5e7eb">·</span>
          <span class="blog-article-date">{{ $a['date'] }}</span>
          <span style="color:#e5e7eb">·</span>
          <span class="blog-article-date"><i class="fas fa-clock"></i> {{ $a['read'] }}</span>
        </div>
        <h3>{{ $a['title'] }}</h3>
        <p>{{ $a['desc'] }}</p>
        <a href="#" class="blog-read-more">Lire l'article <i class="fas fa-arrow-right"></i></a>
        <div class="blog-author-mini">
          <img src="https://images.unsplash.com/{{ $a['author_img'] }}?w=80&h=80&fit=crop" alt="{{ $a['author'] }}">
          <div><strong>{{ $a['author'] }}</strong><br><span>Rédacteur GoExploria</span></div>
        </div>
      </div>
      @endforeach
    </div>
    <div style="text-align:center;margin-top:20px">
      <a href="#" class="btn-outline"><i class="fas fa-newspaper"></i> Charger plus d'articles</a>
    </div>
  </div>
</div>

<!-- TRENDING + TAGS -->
<div class="blog-sidebar-section">
  <div class="blog-sidebar-inner">
    <div>
      <div class="section-label">Articles populaires</div>
      <h2 class="section-title-serif">Tendances du moment</h2>
      <div class="blog-trending-list">
        <div class="blog-trending-item">
          <span class="blog-trending-num">01</span>
          <div><h4>Comment tripler vos réservations avec le marketing digital en 2026</h4><span><i class="fas fa-eye"></i> 12 840 vues · Business</span></div>
        </div>
        <div class="blog-trending-item">
          <span class="blog-trending-num">02</span>
          <div><h4>Les 15 meilleures destinations ski au Québec cette saison</h4><span><i class="fas fa-eye"></i> 9 260 vues · Travel</span></div>
        </div>
        <div class="blog-trending-item">
          <span class="blog-trending-num">03</span>
          <div><h4>TikTok pour les hôteliers : guide pratique débutant 2026</h4><span><i class="fas fa-eye"></i> 7 400 vues · Tech</span></div>
        </div>
        <div class="blog-trending-item">
          <span class="blog-trending-num">04</span>
          <div><h4>Gastronomie montréalaise : 20 tables incontournables</h4><span><i class="fas fa-eye"></i> 6 180 vues · Gastronomie</span></div>
        </div>
      </div>
    </div>
    <div>
      <div class="section-label">Thématiques</div>
      <h2 class="section-title-serif">Explorer par sujet</h2>
      <div class="blog-tag-cloud">
        <span class="blog-tag">Québec</span>
        <span class="blog-tag">Ski hivernal</span>
        <span class="blog-tag">Marketing digital</span>
        <span class="blog-tag">TikTok</span>
        <span class="blog-tag">Gastronomie</span>
        <span class="blog-tag">Startups</span>
        <span class="blog-tag">Instagram</span>
        <span class="blog-tag">Workation</span>
        <span class="blog-tag">Aventure</span>
        <span class="blog-tag">Charlevoix</span>
        <span class="blog-tag">Hôtellerie</span>
        <span class="blog-tag">SEO local</span>
        <span class="blog-tag">Road trip</span>
        <span class="blog-tag">Business B2B</span>
        <span class="blog-tag">Événements</span>
        <span class="blog-tag">Intelligence artificielle</span>
      </div>
    </div>
  </div>
</div>

<!-- NEWSLETTER -->
<div class="blog-newsletter">
  <div class="blog-newsletter-inner">
    <div class="section-label" style="justify-content:center">Restez informé</div>
    <h2>La newsletter des professionnels du voyage</h2>
    <p>Recevez chaque semaine les meilleures analyses, tendances et conseils business pour le secteur touristique québécois et international.</p>
    <div class="blog-newsletter-form">
      <input type="email" placeholder="Votre adresse email professionnelle">
      <button><i class="fas fa-paper-plane"></i> S'abonner</button>
    </div>
    <p class="blog-newsletter-trust"><i class="fas fa-lock"></i> 4 200+ abonnés · Zéro spam · Désabonnement en 1 clic</p>
  </div>
</div>

@endsection

@section('scripts')
<script>
document.querySelectorAll('.blog-cat-btn').forEach(btn => {
  btn.addEventListener('click', function(){
    document.querySelectorAll('.blog-cat-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
  });
});
</script>
@endsection