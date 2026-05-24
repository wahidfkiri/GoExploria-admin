<section class="pc-section pc-gallery" id="galerie">
    <div class="pc-container">
        <div class="pc-section-header pc-reveal">
            <span class="pc-eyebrow">Galerie</span>
            <h2 class="pc-title">Découvrez les <em>espaces</em></h2>
            <p class="pc-desc">La galerie utilise les médias CMS de l’établissement. Si la médiathèque est vide, le design conserve une galerie immobilière de fallback.</p>
        </div>
        <div class="pc-gallery-grid">
            @foreach($gallery->take(8) as $item)
                <button class="pc-gallery-item pc-reveal" type="button" data-pc-img="{{ $item['url'] ?? $item['thumbnail'] }}">
                    <img src="{{ $item['thumbnail'] }}" alt="{{ $item['name'] }}">
                    <span>{{ $item['name'] }}</span>
                </button>
            @endforeach
        </div>
    </div>
    <div class="pc-lightbox" id="pcLightbox">
        <button class="pc-lightbox-close" type="button" id="pcLightboxClose" aria-label="Fermer">×</button>
        <img id="pcLightboxImg" src="" alt="Aperçu galerie">
    </div>
</section>
