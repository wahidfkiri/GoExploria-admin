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
        <div class="pc-social-grid pc-reveal" id="pcSocialGrid"
             data-instagram='@json($instagramGallery->take(8)->values(), JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG)'
             data-facebook='@json($facebookGallery->take(8)->values(), JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG)'
             data-pinterest='@json($pinterestGallery->take(8)->values(), JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG)'
             data-instagram-url="{{ $instagramUrl ?? '' }}"
             data-facebook-url="{{ $facebookUrl ?? '' }}"
             data-pinterest-url="{{ $pinterestUrl ?? '' }}">
        </div>
    </div>
</section>
