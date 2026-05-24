<section class="pc-section pc-amenities" id="services">
    <div class="pc-container">
        <div class="pc-section-header pc-reveal">
            <span class="pc-eyebrow">Services inclus</span>
            <h2 class="pc-title">Tout pour simplifier <em>la vie au quotidien</em></h2>
            <p class="pc-desc">Une section claire pour mettre en avant les commodités, avantages et éléments rassurants de l’établissement.</p>
        </div>
        <div class="pc-amenities-grid">
            @foreach($amenities as $index => $amenity)
                <article class="pc-amenity pc-reveal">
                    <div class="pc-amenity-icon"><i class="fa-solid {{ ['fa-square-parking','fa-soap','fa-map-location-dot','fa-sun','fa-headset','fa-seedling'][$index % 6] }}"></i></div>
                    <h3>{{ $amenity['title'] }}</h3>
                    <p>{{ $amenity['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
