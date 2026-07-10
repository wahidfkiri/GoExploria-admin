@extends('welcome-home.layouts.app')

@section('title', 'Galerie Photos — Destinations du monde')
@section('meta_description', 'Explorez notre galerie photo immersive : destinations internationales, nature sauvage, culture et gastronomie à travers 5 continents.')

@section('breadcrumb')
<span class="current">Galerie Photos</span>
@endsection

@section('page-styles')
/* ===================== GALLERY PAGE ===================== */
#gallery-page { background: #fafafa; }

/* HERO */
.gallery-hero {
  background: #fff; padding: 80px 40px 60px;
  border-bottom: 1px solid #f0f0f0;
}
.gallery-hero-inner { max-width: 1300px; margin: 0 auto; display: grid; grid-template-columns: 1fr auto; align-items: center; gap: 40px; }
.gallery-hero-label {
  font-size: 11px; font-weight: 700; text-transform: uppercase;
  letter-spacing: 2px; color: #e8761a;
  display: flex; align-items: center; gap: 8px; margin-bottom: 16px;
}
.gallery-hero-label::before { content: ''; width: 24px; height: 2px; background: #e8761a; }
.gallery-hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(44px, 5.5vw, 72px); color: #1a1a1a; line-height: 1.05; margin-bottom: 16px; }
.gallery-hero p { font-size: 16px; color: #666; line-height: 1.8; max-width: 540px; }
.gallery-hero-right { text-align: right; }
.gallery-hero-num { font-family: 'Bebas Neue', sans-serif; font-size: 96px; color: #1a1a1a; line-height: 1; display: block; }
.gallery-hero-num-label { font-size: 13px; color: #999; text-transform: uppercase; letter-spacing: 1px; display: block; }
.gallery-hero-continents { display: flex; gap: 8px; justify-content: flex-end; margin-top: 12px; flex-wrap: wrap; }
.gallery-continent-tag { font-size: 11px; font-weight: 700; color: #888; background: #f5f5f5; padding: 4px 12px; border-radius: 999px; }

/* FILTER BAR */
.gallery-filter-bar {
  background: #fff; padding: 16px 40px;
  border-bottom: 1px solid #f0f0f0;
  display: flex; gap: 10px; flex-wrap: wrap;
  position: sticky; top: 64px; z-index: 10;
  box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}
.gallery-filter-btn {
  border: 1.5px solid #e5e7eb; background: #fff;
  border-radius: 999px; font-size: 12px; font-weight: 700;
  color: #666; padding: 8px 18px; cursor: pointer;
  display: flex; align-items: center; gap: 6px;
  transition: all 0.2s;
}
.gallery-filter-btn:hover, .gallery-filter-btn.active {
  background: #e8761a; border-color: #e8761a; color: #fff;
}
.gallery-filter-count { background: rgba(0,0,0,0.1); border-radius: 999px; padding: 1px 7px; font-size: 10px; }
.gallery-filter-btn.active .gallery-filter-count { background: rgba(255,255,255,0.25); }
.gallery-view-toggles { margin-left: auto; display: flex; gap: 6px; }
.gallery-view-btn { width: 34px; height: 34px; border: 1.5px solid #e5e7eb; background: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 14px; color: #888; transition: all 0.2s; }
.gallery-view-btn.active { background: #1a1a1a; border-color: #1a1a1a; color: #fff; }

/* FEATURED STRIP */
.gallery-featured { padding: 40px 40px 0; max-width: 1400px; margin: 0 auto; }
.gallery-featured-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: #e8761a; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
.gallery-featured-label::before { content: ''; width: 20px; height: 2px; background: #e8761a; }
.gallery-featured-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; grid-template-rows: 360px; gap: 12px; }
.gallery-featured-main { grid-row: span 2; border-radius: 20px; overflow: hidden; position: relative; cursor: pointer; }
.gallery-featured-main img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s; }
.gallery-featured-main:hover img { transform: scale(1.04); }
.gallery-featured-side { border-radius: 16px; overflow: hidden; position: relative; cursor: pointer; }
.gallery-featured-side img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
.gallery-featured-side:hover img { transform: scale(1.05); }
.gallery-photo-info {
  position: absolute; inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.75), transparent 55%);
  padding: 20px; display: flex; flex-direction: column; justify-content: flex-end;
  opacity: 0; transition: opacity 0.3s;
}
.gallery-featured-main .gallery-photo-info { opacity: 1; background: linear-gradient(to top, rgba(0,0,0,0.65), transparent 50%); }
.gallery-featured-side:hover .gallery-photo-info { opacity: 1; }
.gallery-photo-info h4 { color: #fff; font-family: 'Playfair Display', serif; font-size: 18px; margin-bottom: 4px; }
.gallery-photo-info .gallery-photo-location { color: rgba(255,255,255,0.75); font-size: 12px; display: flex; align-items: center; gap: 4px; }
.gallery-photo-info .gallery-photo-category { position: absolute; top: 14px; left: 14px; background: #e8761a; color: #fff; font-size: 10px; font-weight: 700; padding: 4px 10px; border-radius: 999px; text-transform: uppercase; }
.gallery-save-btn {
  position: absolute; top: 14px; right: 14px;
  background: rgba(0,0,0,0.5); color: #fff; border: none;
  border-radius: 8px; padding: 6px 12px; font-size: 11px; font-weight: 700;
  cursor: pointer; opacity: 0; transition: all 0.2s; backdrop-filter: blur(4px);
  display: flex; align-items: center; gap: 4px;
}
.gallery-featured-main:hover .gallery-save-btn,
.gallery-featured-side:hover .gallery-save-btn { opacity: 1; }

/* MASONRY */
.gallery-masonry-wrap { padding: 32px 40px 60px; max-width: 1400px; margin: 0 auto; }
.gallery-section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; }
.gallery-section-header h3 { font-family: 'Playfair Display', serif; font-size: 24px; color: #1a1a1a; }
.gallery-section-header a { font-size: 13px; font-weight: 700; color: #e8761a; text-decoration: none; display: flex; align-items: center; gap: 6px; }
.gallery-masonry { column-count: 5; column-gap: 14px; }
.gallery-item { break-inside: avoid; margin-bottom: 14px; border-radius: 16px; overflow: hidden; cursor: pointer; position: relative; transition: transform 0.3s; }
.gallery-item:hover { transform: scale(1.02); z-index: 2; }
.gallery-item img { width: 100%; display: block; }
.gallery-item-overlay {
  position: absolute; inset: 0; background: rgba(0,0,0,0);
  transition: background 0.3s; padding: 14px;
  display: flex; flex-direction: column; justify-content: flex-end;
}
.gallery-item:hover .gallery-item-overlay { background: rgba(0,0,0,0.5); }
.gallery-item-info { opacity: 0; transform: translateY(8px); transition: all 0.3s; }
.gallery-item:hover .gallery-item-info { opacity: 1; transform: translateY(0); }
.gallery-item-info h4 { color: #fff; font-size: 14px; font-weight: 700; margin-bottom: 3px; }
.gallery-item-info span { color: rgba(255,255,255,0.75); font-size: 11px; }
.gallery-item-save {
  position: absolute; top: 10px; right: 10px;
  background: rgba(0,0,0,0.5); color: #fff; border: none;
  border-radius: 6px; padding: 5px 10px; font-size: 10px; font-weight: 700;
  cursor: pointer; opacity: 0; transition: opacity 0.2s;
}
.gallery-item:hover .gallery-item-save { opacity: 1; }
.gallery-item-num { position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.5); color: #fff; font-size: 10px; font-weight: 700; padding: 4px 8px; border-radius: 6px; }

/* CATEGORIES */
.gallery-categories { background: #fff; padding: 60px 40px; border-top: 1px solid #f0f0f0; }
.gallery-categories-inner { max-width: 1300px; margin: 0 auto; }
.gallery-categories-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 16px; margin-top: 40px; }
.gallery-cat-card { border-radius: 16px; overflow: hidden; position: relative; aspect-ratio: 2/3; cursor: pointer; transition: transform 0.3s; }
.gallery-cat-card:hover { transform: translateY(-4px); }
.gallery-cat-card img { width: 100%; height: 100%; object-fit: cover; }
.gallery-cat-card-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.1)); padding: 16px; display: flex; flex-direction: column; justify-content: flex-end; }
.gallery-cat-card-name { color: #fff; font-size: 14px; font-weight: 700; margin-bottom: 2px; }
.gallery-cat-card-count { color: rgba(255,255,255,0.7); font-size: 11px; }

/* LIGHTBOX HINT */
.gallery-lightbox-hint {
  text-align: center; padding: 40px 40px 60px;
  font-size: 14px; color: #888;
}
.gallery-lightbox-hint i { color: #e8761a; margin-right: 6px; }

/* LOAD MORE */
.gallery-load-more { text-align: center; padding: 0 40px 80px; }

@media(max-width:1200px){ .gallery-masonry { column-count: 4; } .gallery-categories-grid { grid-template-columns: repeat(3, 1fr); } }
@media(max-width:900px){ .gallery-masonry { column-count: 3; } .gallery-featured-grid { grid-template-columns: 1fr 1fr; grid-template-rows: auto; } .gallery-hero-inner { grid-template-columns: 1fr; } }
@media(max-width:620px){ .gallery-masonry { column-count: 2; } .gallery-categories-grid { grid-template-columns: repeat(2, 1fr); } .gallery-filter-bar { padding: 12px 20px; } }
@endsection

@section('content')
<section id="gallery-page">

  <!-- HERO -->
  <div class="gallery-hero">
    <div class="gallery-hero-inner">
      <div>
        <div class="gallery-hero-label">Collection GoExploria</div>
        <h1>Galerie Photos<br><em style="color:#e8761a;font-style:italic">du Monde</em></h1>
        <p>Destinations internationales, aventures extraordinaires, cultures du monde. Chaque photo raconte une histoire authentique. Explorez, enregistrez, inspirez-vous.</p>
      </div>
      <div class="gallery-hero-right">
        <span class="gallery-hero-num">480</span>
        <span class="gallery-hero-num-label">Photos · 5 continents</span>
        <div class="gallery-hero-continents">
          <span class="gallery-continent-tag">🌎 Amériques</span>
          <span class="gallery-continent-tag">🌍 Europe</span>
          <span class="gallery-continent-tag">🌏 Asie</span>
          <span class="gallery-continent-tag">🌍 Afrique</span>
          <span class="gallery-continent-tag">🌊 Océanie</span>
        </div>
      </div>
    </div>
  </div>

  <!-- FILTER BAR -->
  <div class="gallery-filter-bar">
    <button class="gallery-filter-btn active"><i class="fas fa-th-large"></i> Toutes <span class="gallery-filter-count">480</span></button>
    <button class="gallery-filter-btn"><i class="fas fa-leaf"></i> Nature <span class="gallery-filter-count">142</span></button>
    <button class="gallery-filter-btn"><i class="fas fa-landmark"></i> Culture <span class="gallery-filter-count">98</span></button>
    <button class="gallery-filter-btn"><i class="fas fa-utensils"></i> Gastronomie <span class="gallery-filter-count">64</span></button>
    <button class="gallery-filter-btn"><i class="fas fa-mountain"></i> Aventure <span class="gallery-filter-count">87</span></button>
    <button class="gallery-filter-btn"><i class="fas fa-city"></i> Urbain <span class="gallery-filter-count">71</span></button>
    <button class="gallery-filter-btn"><i class="fas fa-water"></i> Plage <span class="gallery-filter-count">18</span></button>
    <div class="gallery-view-toggles">
      <button class="gallery-view-btn active" title="Mosaïque"><i class="fas fa-th"></i></button>
      <button class="gallery-view-btn" title="Grille"><i class="fas fa-th-large"></i></button>
      <button class="gallery-view-btn" title="Liste"><i class="fas fa-list"></i></button>
    </div>
  </div>

  <!-- FEATURED -->
  <div class="gallery-featured">
    <div class="gallery-featured-label">À la une cette semaine</div>
    <div class="gallery-featured-grid">
      <div class="gallery-featured-main">
        <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=900&h=700&fit=crop" alt="Aurores nordiques">
        <button class="gallery-save-btn"><i class="fas fa-heart"></i> Sauvegarder</button>
        <div class="gallery-photo-info">
          <span class="gallery-photo-category">Nature</span>
          <h4>Aurores Boréales — Yukon</h4>
          <div class="gallery-photo-location"><i class="fas fa-map-marker-alt"></i> Canada · Yukon</div>
        </div>
      </div>
      <div class="gallery-featured-side">
        <img src="https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?w=600&h=340&fit=crop" alt="Venise">
        <button class="gallery-save-btn"><i class="fas fa-heart"></i> Sauvegarder</button>
        <div class="gallery-photo-info">
          <span class="gallery-photo-category">Culture</span>
          <h4>Canaux de Venise</h4>
          <div class="gallery-photo-location"><i class="fas fa-map-marker-alt"></i> Italie</div>
        </div>
      </div>
      <div class="gallery-featured-side">
        <img src="https://images.unsplash.com/photo-1548013146-72479768bada?w=600&h=340&fit=crop" alt="Kyoto">
        <button class="gallery-save-btn"><i class="fas fa-heart"></i> Sauvegarder</button>
        <div class="gallery-photo-info">
          <span class="gallery-photo-category">Culture</span>
          <h4>Temple de Kyoto</h4>
          <div class="gallery-photo-location"><i class="fas fa-map-marker-alt"></i> Japon</div>
        </div>
      </div>
    </div>
  </div>

  <!-- MASONRY GRID -->
  <div class="gallery-masonry-wrap">
    <div class="gallery-section-header">
      <h3>Toutes les photos</h3>
      <a href="#">Voir les collections <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="gallery-masonry">
      <div class="gallery-item">
        <span class="gallery-item-num">01</span>
        <img src="https://images.unsplash.com/photo-1472396961693-142e6e269027?w=500&h=580&fit=crop" alt="Safari">
        <div class="gallery-item-overlay">
          <button class="gallery-item-save"><i class="fas fa-heart"></i></button>
          <div class="gallery-item-info"><h4>Safari Doré</h4><span><i class="fas fa-map-marker-alt"></i> Kenya, Afrique</span></div>
        </div>
      </div>
      <div class="gallery-item">
        <span class="gallery-item-num">02</span>
        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=500&h=700&fit=crop" alt="Pacifique">
        <div class="gallery-item-overlay">
          <button class="gallery-item-save"><i class="fas fa-heart"></i></button>
          <div class="gallery-item-info"><h4>Côte du Pacifique</h4><span><i class="fas fa-map-marker-alt"></i> Australie</span></div>
        </div>
      </div>
      <div class="gallery-item">
        <span class="gallery-item-num">03</span>
        <img src="https://images.unsplash.com/photo-1516483638261-f4dbaf036963?w=500&h=620&fit=crop" alt="Montréal">
        <div class="gallery-item-overlay">
          <button class="gallery-item-save"><i class="fas fa-heart"></i></button>
          <div class="gallery-item-info"><h4>Ruelles de Montréal</h4><span><i class="fas fa-map-marker-alt"></i> Québec, Canada</span></div>
        </div>
      </div>
      <div class="gallery-item">
        <span class="gallery-item-num">04</span>
        <img src="https://images.unsplash.com/photo-1541544741938-0af808871cc0?w=500&h=500&fit=crop" alt="Gastronomie">
        <div class="gallery-item-overlay">
          <button class="gallery-item-save"><i class="fas fa-heart"></i></button>
          <div class="gallery-item-info"><h4>Saveurs Boréales</h4><span><i class="fas fa-utensils"></i> Canada</span></div>
        </div>
      </div>
      <div class="gallery-item">
        <span class="gallery-item-num">05</span>
        <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=500&h=680&fit=crop" alt="Paris">
        <div class="gallery-item-overlay">
          <button class="gallery-item-save"><i class="fas fa-heart"></i></button>
          <div class="gallery-item-info"><h4>Paris — Lever du Jour</h4><span><i class="fas fa-map-marker-alt"></i> France</span></div>
        </div>
      </div>
      <div class="gallery-item">
        <span class="gallery-item-num">06</span>
        <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=500&h=640&fit=crop" alt="Alpes">
        <div class="gallery-item-overlay">
          <button class="gallery-item-save"><i class="fas fa-heart"></i></button>
          <div class="gallery-item-info"><h4>Alpes Suisses</h4><span><i class="fas fa-mountain"></i> Suisse</span></div>
        </div>
      </div>
      <div class="gallery-item">
        <span class="gallery-item-num">07</span>
        <img src="https://images.unsplash.com/photo-1489515217757-5fd1be406fef?w=500&h=600&fit=crop" alt="Marrakech">
        <div class="gallery-item-overlay">
          <button class="gallery-item-save"><i class="fas fa-heart"></i></button>
          <div class="gallery-item-info"><h4>Marrakech Colorée</h4><span><i class="fas fa-map-marker-alt"></i> Maroc</span></div>
        </div>
      </div>
      <div class="gallery-item">
        <span class="gallery-item-num">08</span>
        <img src="https://images.unsplash.com/photo-1526772662000-3f88f10405ff?w=500&h=700&fit=crop" alt="Andes">
        <div class="gallery-item-overlay">
          <button class="gallery-item-save"><i class="fas fa-heart"></i></button>
          <div class="gallery-item-info"><h4>Route des Andes</h4><span><i class="fas fa-map-marker-alt"></i> Chili</span></div>
        </div>
      </div>
      <div class="gallery-item">
        <span class="gallery-item-num">09</span>
        <img src="https://images.unsplash.com/photo-1528164344705-47542687000d?w=500&h=560&fit=crop" alt="Tokyo">
        <div class="gallery-item-overlay">
          <button class="gallery-item-save"><i class="fas fa-heart"></i></button>
          <div class="gallery-item-info"><h4>Nuit de Tokyo</h4><span><i class="fas fa-map-marker-alt"></i> Japon</span></div>
        </div>
      </div>
      <div class="gallery-item">
        <span class="gallery-item-num">10</span>
        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=620&fit=crop" alt="Charlevoix">
        <div class="gallery-item-overlay">
          <button class="gallery-item-save"><i class="fas fa-heart"></i></button>
          <div class="gallery-item-info"><h4>Charlevoix — Automne</h4><span><i class="fas fa-map-marker-alt"></i> Québec, Canada</span></div>
        </div>
      </div>
      <div class="gallery-item">
        <span class="gallery-item-num">11</span>
        <img src="https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=500&h=580&fit=crop" alt="Gaspésie">
        <div class="gallery-item-overlay">
          <button class="gallery-item-save"><i class="fas fa-heart"></i></button>
          <div class="gallery-item-info"><h4>Gaspésie Sauvage</h4><span><i class="fas fa-water"></i> Québec, Canada</span></div>
        </div>
      </div>
      <div class="gallery-item">
        <span class="gallery-item-num">12</span>
        <img src="https://images.unsplash.com/photo-1517935706615-2717063c2225?w=500&h=640&fit=crop" alt="Montréal Night">
        <div class="gallery-item-overlay">
          <button class="gallery-item-save"><i class="fas fa-heart"></i></button>
          <div class="gallery-item-info"><h4>Montréal by Night</h4><span><i class="fas fa-city"></i> Québec, Canada</span></div>
        </div>
      </div>
      <div class="gallery-item">
        <span class="gallery-item-num">13</span>
        <img src="https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=500&h=700&fit=crop" alt="Mont Tremblant">
        <div class="gallery-item-overlay">
          <button class="gallery-item-save"><i class="fas fa-heart"></i></button>
          <div class="gallery-item-info"><h4>Mont-Tremblant Ski</h4><span><i class="fas fa-person-skiing"></i> Laurentides</span></div>
        </div>
      </div>
      <div class="gallery-item">
        <span class="gallery-item-num">14</span>
        <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=500&h=500&fit=crop" alt="Gastronomie">
        <div class="gallery-item-overlay">
          <button class="gallery-item-save"><i class="fas fa-heart"></i></button>
          <div class="gallery-item-info"><h4>Gastronomie Étoilée</h4><span><i class="fas fa-utensils"></i> Montréal</span></div>
        </div>
      </div>
      <div class="gallery-item">
        <span class="gallery-item-num">15</span>
        <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=500&h=620&fit=crop" alt="Îles Madeleine">
        <div class="gallery-item-overlay">
          <button class="gallery-item-save"><i class="fas fa-heart"></i></button>
          <div class="gallery-item-info"><h4>Îles de la Madeleine</h4><span><i class="fas fa-water"></i> Québec, Canada</span></div>
        </div>
      </div>
    </div>
  </div>

  <!-- CATEGORIES -->
  <div class="gallery-categories">
    <div class="gallery-categories-inner">
      <div class="section-label">Parcourir par thème</div>
      <h2 class="section-title-serif">Collections thématiques</h2>
      <p class="section-desc">Explorez nos albums organisés par univers, pour vous inspirer selon votre humeur et votre destination.</p>
      <div class="gallery-categories-grid">
        <div class="gallery-cat-card">
          <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=300&h=450&fit=crop" alt="Nature">
          <div class="gallery-cat-card-overlay">
            <div class="gallery-cat-card-name"><i class="fas fa-leaf"></i> Nature</div>
            <div class="gallery-cat-card-count">142 photos</div>
          </div>
        </div>
        <div class="gallery-cat-card">
          <img src="https://images.unsplash.com/photo-1548013146-72479768bada?w=300&h=450&fit=crop" alt="Culture">
          <div class="gallery-cat-card-overlay">
            <div class="gallery-cat-card-name"><i class="fas fa-landmark"></i> Culture</div>
            <div class="gallery-cat-card-count">98 photos</div>
          </div>
        </div>
        <div class="gallery-cat-card">
          <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=300&h=450&fit=crop" alt="Gastronomie">
          <div class="gallery-cat-card-overlay">
            <div class="gallery-cat-card-name"><i class="fas fa-utensils"></i> Gastronomie</div>
            <div class="gallery-cat-card-count">64 photos</div>
          </div>
        </div>
        <div class="gallery-cat-card">
          <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=300&h=450&fit=crop" alt="Aventure">
          <div class="gallery-cat-card-overlay">
            <div class="gallery-cat-card-name"><i class="fas fa-mountain"></i> Aventure</div>
            <div class="gallery-cat-card-count">87 photos</div>
          </div>
        </div>
        <div class="gallery-cat-card">
          <img src="https://images.unsplash.com/photo-1517935706615-2717063c2225?w=300&h=450&fit=crop" alt="Urbain">
          <div class="gallery-cat-card-overlay">
            <div class="gallery-cat-card-name"><i class="fas fa-city"></i> Urbain</div>
            <div class="gallery-cat-card-count">71 photos</div>
          </div>
        </div>
        <div class="gallery-cat-card">
          <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=300&h=450&fit=crop" alt="Plage">
          <div class="gallery-cat-card-overlay">
            <div class="gallery-cat-card-name"><i class="fas fa-water"></i> Plage</div>
            <div class="gallery-cat-card-count">18 photos</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- LOAD MORE -->
  <div class="gallery-load-more">
    <p style="color:#888;font-size:14px;margin-bottom:20px">Affichage de 15 photos sur 480 au total</p>
    <a href="#" class="btn-orange" style="font-size:15px;padding:14px 40px"><i class="fas fa-images"></i> Charger 20 photos de plus</a>
  </div>

  <div class="gallery-lightbox-hint">
    <i class="fas fa-expand"></i> Cliquez sur une photo pour l'agrandir · <i class="fas fa-heart" style="color:#e8761a;margin:0 4px"></i> Sauvegardez vos favoris
  </div>

</section>
@endsection

@section('scripts')
<script>
// Filter buttons
document.querySelectorAll('.gallery-filter-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.gallery-filter-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
  });
});
// View toggles
document.querySelectorAll('.gallery-view-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.gallery-view-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
  });
});
// Save buttons feedback
document.querySelectorAll('.gallery-save-btn, .gallery-item-save').forEach(btn => {
  btn.addEventListener('click', function(e) {
    e.stopPropagation();
    this.style.background = '#e8761a';
    this.innerHTML = '<i class="fas fa-heart"></i> Sauvegardé !';
    setTimeout(() => {
      this.style.background = '';
      this.innerHTML = '<i class="fas fa-heart"></i>';
    }, 2000);
  });
});
</script>
@endsection