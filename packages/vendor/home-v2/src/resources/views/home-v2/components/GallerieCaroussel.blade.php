@php
ob_start();
$gicPhotos = [
    ['img' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=900&h=1200&fit=crop', 'title' => 'Aurores Nordiques', 'destination' => 'amerique-nord', 'destination_label' => 'Canada', 'cat' => 'nature', 'cat_label' => 'Nature', 'ratio' => '3 / 4', 'tags' => ['#international', '#canada', '#winter', '#nordic']],
    ['img' => 'https://images.unsplash.com/photo-1516483638261-f4dbaf036963?w=900&h=1200&fit=crop', 'title' => 'Ruelles de Montréal', 'destination' => 'amerique-nord', 'destination_label' => 'Québec', 'cat' => 'urbain', 'cat_label' => 'Urbain', 'ratio' => '4 / 5', 'tags' => ['#international', '#montreal', '#city', '#streetlife']],
    ['img' => 'https://images.unsplash.com/photo-1541544741938-0af808871cc0?w=900&h=1200&fit=crop', 'title' => 'Saveurs Boréales', 'destination' => 'amerique-nord', 'destination_label' => 'Canada', 'cat' => 'gastronomie', 'cat_label' => 'Gastronomie', 'ratio' => '1 / 1', 'tags' => ['#international', '#food', '#terroir', '#gourmet']],
    ['img' => 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?w=900&h=1200&fit=crop', 'title' => 'Canaux de Venise', 'destination' => 'europe', 'destination_label' => 'Italie', 'cat' => 'culture', 'cat_label' => 'Culture', 'ratio' => '3 / 4', 'tags' => ['#international', '#europe', '#heritage', '#italy']],
    ['img' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=900&h=1200&fit=crop', 'title' => 'Paris au Lever du Jour', 'destination' => 'europe', 'destination_label' => 'France', 'cat' => 'urbain', 'cat_label' => 'Urbain', 'ratio' => '4 / 5', 'tags' => ['#international', '#paris', '#architecture', '#cityscape']],
    ['img' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=900&h=1200&fit=crop', 'title' => 'Alpes Sauvages', 'destination' => 'europe', 'destination_label' => 'Suisse', 'cat' => 'aventure', 'cat_label' => 'Aventure', 'ratio' => '5 / 6', 'tags' => ['#international', '#alps', '#hiking', '#adventure']],
    ['img' => 'https://images.unsplash.com/photo-1548013146-72479768bada?w=900&h=1200&fit=crop', 'title' => 'Temple de Kyoto', 'destination' => 'asie', 'destination_label' => 'Japon', 'cat' => 'culture', 'cat_label' => 'Culture', 'ratio' => '3 / 4', 'tags' => ['#international', '#japan', '#temple', '#tradition']],
    ['img' => 'https://images.unsplash.com/photo-1528164344705-47542687000d?w=900&h=1200&fit=crop', 'title' => 'Nuit de Tokyo', 'destination' => 'asie', 'destination_label' => 'Japon', 'cat' => 'urbain', 'cat_label' => 'Urbain', 'ratio' => '1 / 1', 'tags' => ['#international', '#tokyo', '#neon', '#night']],
    ['img' => 'https://images.unsplash.com/photo-1472396961693-142e6e269027?w=900&h=1200&fit=crop', 'title' => 'Safari Doré', 'destination' => 'afrique', 'destination_label' => 'Kenya', 'cat' => 'nature', 'cat_label' => 'Nature', 'ratio' => '4 / 5', 'tags' => ['#international', '#africa', '#wildlife', '#safari']],
    ['img' => 'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?w=900&h=1200&fit=crop', 'title' => 'Marrakech Colorée', 'destination' => 'afrique', 'destination_label' => 'Maroc', 'cat' => 'culture', 'cat_label' => 'Culture', 'ratio' => '3 / 4', 'tags' => ['#international', '#morocco', '#souks', '#colors']],
    ['img' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=900&h=1200&fit=crop', 'title' => 'Océan Pacifique', 'destination' => 'oceanie', 'destination_label' => 'Australie', 'cat' => 'nature', 'cat_label' => 'Nature', 'ratio' => '16 / 10', 'tags' => ['#international', '#ocean', '#summer', '#australia']],
    ['img' => 'https://images.unsplash.com/photo-1526772662000-3f88f10405ff?w=900&h=1200&fit=crop', 'title' => 'Route des Andes', 'destination' => 'amerique-sud', 'destination_label' => 'Chili', 'cat' => 'aventure', 'cat_label' => 'Aventure', 'ratio' => '5 / 6', 'tags' => ['#international', '#andes', '#roadtrip', '#travel']],
];
@endphp

<section id="photos" class="gic-section">
    <div class="gic-container">
        <div class="resto-header-block">
            <div class="resto-header-main">
                <div class="resto-header-logo-left">
                    <a href="#" class="resto-accord-btn" title="GoExploria">
                        <div class="logo-wrapper"><img src="{{ asset('logo.png') }}" alt="GoExploria"></div>
                        <span class="resto-accord-btn-label">GoExploria</span>
                        <span class="resto-accord-btn-cta"><i class="fas fa-external-link-alt"></i> Visiter</span>
                    </a>
                </div>

                <div class="resto-header-center">
                    <h1 class="resto-header-title">ESPACES PHOTOS</h1>
                    <p class="resto-header-subtitle">Destinations et choix des catégories · Photos avec tags international · Création des catégories de galeries.</p>
                    <div class="resto-header-tabs" role="tablist">
                        <button class="resto-tab-btn active" type="button"><i class="fas fa-images"></i> Toutes les options</button>
                        <button class="resto-tab-btn" type="button"><i class="fas fa-globe"></i> International</button>
                        <button class="resto-tab-btn" type="button"><i class="fas fa-hashtag"></i> Tags tendances</button>
                        <button class="resto-tab-btn" type="button"><i class="fas fa-layer-group"></i> Catégories galeries</button>
                    </div>
                </div>

                <div class="resto-header-logo-right">
                    <a href="#" class="resto-accord-btn" title="Espaces Photos">
                        <div class="logo-wrapper"><img src="{{ asset('GO-EXPLORIA-MY-TUBE.png') }}" alt="Espaces Photos"></div>
                        <span class="resto-accord-btn-label">Espaces Photos</span>
                        <span class="resto-accord-btn-cta"><i class="fas fa-camera"></i> Explorer</span>
                    </a>
                </div>
            </div>

            <div class="resto-header-destinations-bar">
                <div class="resto-dest-row">
                    <div class="resto-dest-icon-box">
                        <img src="{{ asset('REDI.png') }}" alt="Destinations">
                        <span>Destinations</span>
                    </div>
                    <div class="resto-dest-breadcrumb gic-destinations">
                        <button class="resto-dest-link gic-dest-btn gic-dest-btn--xl active" type="button" data-dest="all">Monde</button>
                        <span class="resto-dest-sep">/</span>
                        <button class="resto-dest-link gic-dest-btn gic-dest-btn--md" type="button" data-dest="amerique-nord">Amérique du Nord</button>
                        <span class="resto-dest-sep">/</span>
                        <button class="resto-dest-link gic-dest-btn gic-dest-btn--sm" type="button" data-dest="europe">Europe</button>
                        <span class="resto-dest-sep">/</span>
                        <button class="resto-dest-link gic-dest-btn gic-dest-btn--pill" type="button" data-dest="asie">Asie</button>
                        <span class="resto-dest-sep">/</span>
                        <button class="resto-dest-link gic-dest-btn gic-dest-btn--md" type="button" data-dest="afrique">Afrique</button>
                        <span class="resto-dest-sep">/</span>
                        <button class="resto-dest-link gic-dest-btn gic-dest-btn--sm" type="button" data-dest="oceanie">Océanie</button>
                    </div>
                </div>
                <div class="resto-actions-row">
                    <div class="resto-header-ctas">
                        <div class="gic-categories">
                            <button class="gic-filter-btn gic-filter-btn--wide active" type="button" data-cat="all"><i class="fas fa-th-large"></i> Toutes catégories</button>
                            <button class="gic-filter-btn gic-filter-btn--chip" type="button" data-cat="nature"><i class="fas fa-leaf"></i> Nature</button>
                            <button class="gic-filter-btn gic-filter-btn--tall" type="button" data-cat="culture"><i class="fas fa-landmark"></i> Culture</button>
                            <button class="gic-filter-btn gic-filter-btn--pill" type="button" data-cat="gastronomie"><i class="fas fa-utensils"></i> Gastronomie</button>
                            <button class="gic-filter-btn gic-filter-btn--soft" type="button" data-cat="aventure"><i class="fas fa-mountain"></i> Aventure</button>
                            <button class="gic-filter-btn gic-filter-btn--chip" type="button" data-cat="urbain"><i class="fas fa-city"></i> Urbain</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="resto-header-shimmer"></div>
        </div>

        <div class="gic-layout" id="gicMasonry">
            @foreach(array_chunk($gicPhotos, 5) as $photoRow)
                <div class="gic-row">
                    @foreach($photoRow as $photo)
                        <article class="gic-card gic-card--h" style="--gic-ratio: 16 / 10;" data-dest="{{ $photo['destination'] }}" data-cat="{{ $photo['cat'] }}" data-tags="{{ implode(' ', $photo['tags']) }}">
                            <div class="gic-media-wrap">
                                <img src="{{ $photo['img'] }}" alt="{{ $photo['title'] }}" loading="lazy">
                                <button type="button" class="gic-save-btn"><i class="fas fa-thumbtack"></i> Enregistrer</button>
                                <button type="button" class="gic-more-btn" aria-label="Plus"><i class="fas fa-ellipsis-h"></i></button>
                                <div class="gic-overlay">
                                    <span class="gic-pill">{{ $photo['cat_label'] }}</span>
                                    <h3>{{ $photo['title'] }}</h3>
                                    <p><i class="fas fa-map-marker-alt"></i> {{ $photo['destination_label'] }}</p>
                                </div>
                            </div>
                            <div class="gic-tags">
                                @foreach($photo['tags'] as $tag)
                                    <button type="button" class="gic-tag" data-tag="{{ strtolower($tag) }}">{{ $tag }}</button>
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="gic-empty" id="gicEmpty">
            <i class="fas fa-images"></i>
            <p>Aucune photo pour ce filtre.</p>
        </div>
    </div>
</section>

<style>
.gic-section{background:radial-gradient(1200px 500px at 20% -10%,#fff0e8 0%,transparent 70%),radial-gradient(900px 500px at 100% 0,#edf5ff 0%,transparent 72%),#f8fafc;padding:34px 0 78px;}
.gic-container{max-width:100%;padding:0 40px;}
.gic-destinations .resto-dest-link{background:none;border:none;padding:0;cursor:pointer;}
.gic-destinations{display:flex;align-items:center;flex-wrap:wrap;gap:8px;}

.gic-dest-btn{
  font-family:Montserrat,sans-serif;
  font-weight:800;
  letter-spacing:.25px;
  border-radius:999px;
  border:1px solid #dbe3ef;
  color:#27364d;
  background:#fff;
  transition:all .2s ease;
}
.gic-dest-btn--xl{padding:10px 18px;font-size:13px;}
.gic-dest-btn--md{padding:8px 14px;font-size:12px;}
.gic-dest-btn--sm{padding:6px 11px;font-size:11px;}
.gic-dest-btn--pill{padding:12px 16px;font-size:12px;border-radius:14px;}
.gic-dest-btn:hover{border-color:#f26522;color:#f26522;transform:translateY(-1px);}
.gic-dest-btn.active{background:linear-gradient(135deg,#f26522,#d4af37);border-color:transparent;color:#fff;box-shadow:0 8px 18px rgba(242,101,34,.3);}

.gic-categories{display:flex;align-items:center;flex-wrap:wrap;gap:8px;}
.gic-filter-btn{
  border:1px solid #dbe3ef;
  color:#32455f;
  background:#fff;
  border-radius:999px;
  font-family:Montserrat,sans-serif;
  font-weight:700;
  cursor:pointer;
  transition:all .22s ease;
  display:inline-flex;
  align-items:center;
  gap:6px;
}
.gic-filter-btn--wide{padding:11px 20px;font-size:13px;}
.gic-filter-btn--chip{padding:7px 12px;font-size:11px;}
.gic-filter-btn--tall{padding:13px 14px;font-size:12px;border-radius:14px;}
.gic-filter-btn--pill{padding:10px 18px;font-size:12px;border-radius:26px;}
.gic-filter-btn--soft{padding:9px 15px;font-size:12px;background:#f6f9ff;}
.gic-filter-btn:hover{border-color:#e60023;color:#e60023;transform:translateY(-1px);}
.gic-filter-btn.active{background:#e60023;border-color:#e60023;color:#fff;box-shadow:0 10px 20px rgba(230,0,35,.25);}

.gic-layout{display:flex;flex-direction:column;gap:16px;padding-top:20px;}
.gic-row{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:16px;align-items:start;}
.gic-card{
  break-inside:avoid;
  display:block;
  margin:0;
  background:#fff;
  border-radius:18px;
  overflow:hidden;
  box-shadow:0 8px 24px rgba(11,20,39,.08);
  transition:transform .25s ease, box-shadow .25s ease;
  border:1px solid rgba(17,24,39,.05);
}
.gic-card:hover{transform:translateY(-5px);box-shadow:0 16px 36px rgba(11,20,39,.16);}
.gic-card--h{grid-column:span 1;}

.gic-media-wrap{
  position:relative;
  overflow:hidden;
  aspect-ratio:var(--gic-ratio,4/5);
  background:#e6ecf5;
}
.gic-media-wrap img{
  width:100%;
  height:100%;
  object-fit:cover;
  display:block;
  transition:transform .35s ease;
}
.gic-card:hover .gic-media-wrap img{transform:scale(1.04);}

.gic-save-btn,.gic-more-btn{
  position:absolute;
  z-index:3;
  border:none;
  cursor:pointer;
  transition:transform .2s ease,opacity .2s ease;
  opacity:0;
}
.gic-save-btn{
  top:10px;right:10px;
  background:#e60023;color:#fff;
  border-radius:999px;
  padding:8px 12px;
  font-size:11px;font-weight:700;
  letter-spacing:.2px;
}
.gic-more-btn{
  bottom:10px;right:10px;
  width:32px;height:32px;border-radius:50%;
  background:#fff;color:#1f2937;font-size:13px;
}
.gic-card:hover .gic-save-btn,.gic-card:hover .gic-more-btn{opacity:1;}
.gic-save-btn:hover,.gic-more-btn:hover{transform:scale(1.06);}

.gic-overlay{
  position:absolute;
  left:0;right:0;bottom:0;
  padding:48px 12px 10px;
  background:linear-gradient(180deg,rgba(0,0,0,0) 10%,rgba(0,0,0,.72) 100%);
  color:#fff;
}
.gic-pill{
  display:inline-block;
  margin-bottom:6px;
  background:rgba(255,255,255,.2);
  backdrop-filter:blur(4px);
  border:1px solid rgba(255,255,255,.4);
  color:#fff;
  font-size:10px;
  font-weight:700;
  padding:4px 10px;
  border-radius:999px;
  text-transform:uppercase;
  letter-spacing:.4px;
}
.gic-overlay h3{
  margin:0 0 4px;
  font-size:14px;
  line-height:1.25;
  font-weight:800;
  text-shadow:0 2px 14px rgba(0,0,0,.35);
}
.gic-overlay p{
  margin:0;
  font-size:11px;
  display:flex;
  align-items:center;
  gap:5px;
  opacity:.92;
}

.gic-tags{
  display:flex;
  flex-wrap:wrap;
  gap:6px;
  padding:10px 10px 12px;
}
.gic-tag{
  border:1px solid #e8edf5;
  background:#f6f8fc;
  color:#44536b;
  font-size:10px;
  font-weight:700;
  padding:5px 9px;
  border-radius:999px;
  cursor:pointer;
  letter-spacing:.2px;
}
.gic-tag:hover{border-color:#e60023;color:#e60023;background:#fff;}
.gic-tag.is-active{border-color:#e60023;background:#ffe8ee;color:#e60023;}

.gic-empty{display:none;align-items:center;justify-content:center;flex-direction:column;color:#8b95a7;padding:52px 12px;gap:10px;}
.gic-empty i{font-size:34px;color:#c3ccda;}

@@media (max-width:1200px){
  .gic-row{grid-template-columns:repeat(3,minmax(0,1fr));}
}
@@media (max-width:900px){
  .gic-container{padding:0 16px;}
  .gic-row{grid-template-columns:repeat(2,minmax(0,1fr));}
  .gic-card--h{grid-column:span 1;}
}
@@media (max-width:620px){
  .gic-row{grid-template-columns:1fr;}
  .gic-card--h{grid-column:span 1;}
}
</style>

<script>
(function(){
  var section=document.getElementById('gallerie-caroussel');
  if(!section) return;
  var cards=Array.prototype.slice.call(section.querySelectorAll('.gic-card'));
  var destBtns=section.querySelectorAll('.gic-destinations .resto-dest-link');
  var catBtns=section.querySelectorAll('.gic-categories .gic-filter-btn');
  var empty=section.querySelector('#gicEmpty');
  var activeDest='all';
  var activeCat='all';
  var activeTag='';

  function applyFilters(){
    var visible=0;
    cards.forEach(function(card){
      var d=card.getAttribute('data-dest')||'';
      var c=card.getAttribute('data-cat')||'';
      var tags=(card.getAttribute('data-tags')||'').toLowerCase();
      var show=(activeDest==='all'||d===activeDest) && (activeCat==='all'||c===activeCat) && (!activeTag || tags.indexOf(activeTag)!==-1);
      card.style.display=show?'block':'none';
      if(show) visible++;
    });
    empty.style.display=visible?'none':'flex';
  }

  destBtns.forEach(function(btn){
    btn.addEventListener('click',function(){
      destBtns.forEach(function(b){b.classList.remove('active');});
      btn.classList.add('active');
      activeDest=btn.getAttribute('data-dest')||'all';
      applyFilters();
    });
  });

  catBtns.forEach(function(btn){
    btn.addEventListener('click',function(){
      catBtns.forEach(function(b){b.classList.remove('active');});
      btn.classList.add('active');
      activeCat=btn.getAttribute('data-cat')||'all';
      applyFilters();
    });
  });

  section.addEventListener('click',function(e){
    var tagBtn=e.target.closest('.gic-tag');
    if(!tagBtn) return;
    var val=(tagBtn.getAttribute('data-tag')||'').toLowerCase();
    if(activeTag===val){
      activeTag='';
      section.querySelectorAll('.gic-tag').forEach(function(t){t.classList.remove('is-active');});
    } else {
      activeTag=val;
      section.querySelectorAll('.gic-tag').forEach(function(t){t.classList.remove('is-active');});
      tagBtn.classList.add('is-active');
    }
    applyFilters();
  });

  applyFilters();
})();
</script>

@php
$__componentHtml = ob_get_clean();
echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
