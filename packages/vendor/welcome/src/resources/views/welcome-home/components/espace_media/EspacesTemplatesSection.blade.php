@php
    $tr = static function (string $text): string {
        $locale = app()->getLocale();
        if ($locale === 'fr') return $text;
        static $maps = [];
        if (!array_key_exists($locale, $maps)) {
            $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
            $maps[$locale] = is_file($path) ? (require $path) : [];
        }
        return $maps[$locale][$text] ?? $text;
    };

    $templateCards = [
        ['title' => 'Template Tourisme Premium', 'category' => 'tourisme', 'label' => 'Tourisme', 'image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1200&h=700&fit=crop', 'desc' => 'Destinations, activites, reservations et experiences immersives.'],
        ['title' => 'Template Business Corporate', 'category' => 'business', 'label' => 'Business', 'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=1200&h=700&fit=crop', 'desc' => 'Presentation entreprise, services B2B, formulaires leads et KPI.'],
        ['title' => 'Template E-commerce Moderne', 'category' => 'ecommerce', 'label' => 'E-commerce', 'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200&h=700&fit=crop', 'desc' => 'Catalogue, fiches produits, promotions et tunnel de conversion optimise.'],
        ['title' => 'Template Portfolio Creatif', 'category' => 'portfolio', 'label' => 'Portfolio', 'image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=1200&h=700&fit=crop', 'desc' => 'Galeries medias, animations fluides et storytelling visuel haut de gamme.'],
        ['title' => 'Template Medias & Blog', 'category' => 'media', 'label' => 'Media', 'image' => 'https://images.unsplash.com/photo-1495020689067-958852a7765e?w=1200&h=700&fit=crop', 'desc' => 'Editorial, actualites, chaines video, newsletters et monetisation.'],
        ['title' => 'Template Institutionnel', 'category' => 'institutionnel', 'label' => 'Institutionnel', 'image' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=1200&h=700&fit=crop', 'desc' => 'Communication officielle, services citoyens et sections multilingues.'],
    ];
@endphp

<section id="espace-templates" class="etm-section">
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="Templates">
                    <div class="logo-wrapper">
                        <i class="fas fa-layer-group" style="font-size:24px;color:#e8761a"></i>
                    </div>
                    <span class="resto-accord-btn-label">Templates Hub</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-sparkles"></i> New</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('ESPACES TEMPLATES') }}</h1>
                <p class="resto-header-subtitle">{{ $tr('Bibliotheque de templates professionnels avec filtres categories et apercus visuels.') }}</p>
            </div>
            <div class="resto-header-logo-right">
                <a href="{{ url('templates') }}" title="{{ $tr('En savoir plus') }}" target="_blank" rel="noopener noreferrer">
                    <img class="bt-next-level-image" src="{{ asset('images/Next-level.png') }}" alt="{{ $tr('Next Level') }}" loading="lazy">
                </a>
            </div>
        </div>

        @include('welcome-home.components.SectionNavbarEspaceMedia')

        <div class="resto-header-destinations-bar">
            <div class="resto-actions-row">
                <div class="resto-header-ctas">
                    <div class="etm-filters" id="etmFilters">
                        <button class="etm-filter-btn active" type="button" data-filter="all"><i class="fas fa-th-large"></i> {{ $tr('Tous') }}</button>
                        <button class="etm-filter-btn" type="button" data-filter="tourisme"><i class="fas fa-map-marked-alt"></i> {{ $tr('Tourisme') }}</button>
                        <button class="etm-filter-btn" type="button" data-filter="business"><i class="fas fa-briefcase"></i> {{ $tr('Business') }}</button>
                        <button class="etm-filter-btn" type="button" data-filter="ecommerce"><i class="fas fa-shopping-cart"></i> {{ $tr('E-commerce') }}</button>
                        <button class="etm-filter-btn" type="button" data-filter="portfolio"><i class="fas fa-images"></i> {{ $tr('Portfolio') }}</button>
                        <button class="etm-filter-btn" type="button" data-filter="media"><i class="fas fa-newspaper"></i> {{ $tr('Media') }}</button>
                        <button class="etm-filter-btn" type="button" data-filter="institutionnel"><i class="fas fa-university"></i> {{ $tr('Institutionnel') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="resto-header-shimmer"></div>
    </div>

    <div class="etm-container">
        <div class="etm-grid" id="etmGrid">
            @foreach ($templateCards as $card)
                <article class="etm-card" data-category="{{ $card['category'] }}">
                    <div class="etm-card-media">
                        <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" loading="lazy">
                        <span class="etm-badge">{{ $card['label'] }}</span>
                    </div>
                    <div class="etm-card-content">
                        <h3>{{ $tr($card['title']) }}</h3>
                        <p>{{ $tr($card['desc']) }}</p>
                        <a href="{{ url('templates') }}" target="_blank" rel="noopener noreferrer" class="etm-card-link">
                            <i class="fas fa-eye"></i> {{ $tr('Voir template') }}
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="etm-empty" id="etmEmpty">
            <i class="fas fa-folder-open"></i>
            <p>{{ $tr('Aucun template dans cette categorie.') }}</p>
        </div>
    </div>
</section>

<style>
.etm-section{background:linear-gradient(180deg,#f8fbff 0%,#ffffff 100%);padding:26px 0 70px}
.etm-container{max-width:100%;padding:0 40px}
.etm-filters{display:flex;align-items:center;flex-wrap:wrap;gap:8px}
.etm-filter-btn{
    border:1px solid #dce6f5;background:#fff;color:#2b3d5b;border-radius:999px;padding:9px 14px;
    font:700 12px/1 'Montserrat',sans-serif;display:inline-flex;align-items:center;gap:6px;cursor:pointer;
    transition:all .2s ease
}
.etm-filter-btn:hover{border-color:#e8761a;color:#e8761a;transform:translateY(-1px)}
.etm-filter-btn.active{background:#e8761a;border-color:#e8761a;color:#fff;box-shadow:0 8px 18px rgba(232,118,26,.28)}

.etm-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px;margin-top:24px}
.etm-card{
    background:#fff;border:1px solid #e6edf8;border-radius:18px;overflow:hidden;
    box-shadow:0 8px 26px rgba(12,38,82,.08);transition:transform .22s ease, box-shadow .22s ease
}
.etm-card:hover{transform:translateY(-4px);box-shadow:0 16px 34px rgba(12,38,82,.14)}
.etm-card-media{position:relative;aspect-ratio:16/9;overflow:hidden}
.etm-card-media img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .35s ease}
.etm-card:hover .etm-card-media img{transform:scale(1.04)}
.etm-badge{
    position:absolute;left:12px;top:12px;background:rgba(15,40,76,.88);color:#fff;border:1px solid rgba(255,255,255,.35);
    border-radius:999px;padding:5px 10px;font:700 10px/1 'Montserrat',sans-serif;letter-spacing:.4px;text-transform:uppercase
}
.etm-card-content{padding:16px}
.etm-card-content h3{margin:0 0 8px;font:800 18px/1.3 'Montserrat',sans-serif;color:#102647}
.etm-card-content p{margin:0 0 12px;font:500 14px/1.6 'Montserrat',sans-serif;color:#55657f}
.etm-card-link{
    display:inline-flex;align-items:center;gap:6px;text-decoration:none;border-radius:10px;
    background:#f2f6ff;border:1px solid #d9e4f6;color:#123f8d;padding:8px 12px;font:700 12px/1 'Montserrat',sans-serif
}
.etm-card-link:hover{background:#123f8d;color:#fff;border-color:#123f8d}

.etm-empty{display:none;align-items:center;justify-content:center;flex-direction:column;gap:8px;color:#7f8ba2;padding:36px 10px}
.etm-empty i{font-size:28px;color:#b4bfd2}

@media (max-width:1100px){.etm-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media (max-width:768px){
    .etm-container{padding:0 16px}
    .etm-grid{grid-template-columns:1fr}
}
</style>

<script>
(function(){
    var section = document.getElementById('espace-templates');
    if (!section) return;

    var buttons = section.querySelectorAll('.etm-filter-btn');
    var cards = section.querySelectorAll('.etm-card');
    var empty = section.querySelector('#etmEmpty');

    function applyFilter(filter){
        var visible = 0;
        cards.forEach(function(card){
            var cat = card.getAttribute('data-category') || '';
            var show = (filter === 'all' || cat === filter);
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        empty.style.display = visible ? 'none' : 'flex';
    }

    buttons.forEach(function(btn){
        btn.addEventListener('click', function(){
            buttons.forEach(function(b){ b.classList.remove('active'); });
            btn.classList.add('active');
            applyFilter(btn.getAttribute('data-filter') || 'all');
        });
    });

    applyFilter('all');
})();
</script>
