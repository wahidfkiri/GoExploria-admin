<section class="pc-section pc-social" id="reseaux">
    <div class="pc-container">
        <div class="pc-section-header pc-reveal">
            <span class="pc-eyebrow">Réseaux et inspirations</span>
            <h2 class="pc-title">Suivez les nouveautés <em>en images</em></h2>
            <p class="pc-desc">Un bloc inspiré du design sélectionné pour valoriser photos, actualités, disponibilités et publications sociales.</p>
        </div>
        <div class="pc-social-tabs pc-reveal">
            <button class="pc-social-tab pc-active" type="button" data-tab="instagram"><i class="fa-brands fa-instagram"></i> Instagram</button>
            <button class="pc-social-tab" type="button" data-tab="facebook"><i class="fa-brands fa-facebook"></i> Facebook</button>
            <button class="pc-social-tab" type="button" data-tab="pinterest"><i class="fa-brands fa-pinterest"></i> Pinterest</button>
        </div>
        <div class="pc-social-grid pc-reveal">
            @foreach($gallery->slice(0, 8) as $item)
                <a class="pc-social-card" href="{{ $instagramUrl !== '#' ? $instagramUrl : ($facebookUrl !== '#' ? $facebookUrl : '#') }}" target="_blank" rel="noopener">
                    <img src="{{ $item['thumbnail'] }}" alt="{{ $item['name'] }}">
                    <span class="pc-social-overlay"><i class="fa-brands fa-instagram"></i></span>
                </a>
            @endforeach
        </div>
    </div>
</section>
