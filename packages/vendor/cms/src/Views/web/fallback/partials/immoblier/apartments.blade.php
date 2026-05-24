<section class="pc-section pc-apartments" id="logements">
    <div class="pc-container">
        <div class="pc-section-header pc-reveal">
            <span class="pc-eyebrow">Disponibilités</span>
            <h2 class="pc-title">Logements et produits <em>en vedette</em></h2>
            <p class="pc-desc">Les produits réels de l’établissement sont affichés en priorité. Les cartes de démonstration apparaissent seulement si aucun produit à vendre n’est disponible.</p>
        </div>
        <div class="pc-apartment-grid">
            @foreach($apartmentCards as $card)
                <article class="pc-apartment-card pc-reveal">
                    <div class="pc-apartment-img">
                        <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}">
                        <span class="pc-apartment-tag">{{ $card['tag'] }}</span>
                    </div>
                    <div class="pc-apartment-body">
                        <h3>{{ $card['title'] }}</h3>
                        <div class="pc-price">{{ $card['price'] }}</div>
                        <p>{{ $card['desc'] }}</p>
                        <div class="pc-apartment-meta">
                            <span>{{ $card['surface'] }}</span>
                            <span>{{ $card['rooms'] }}</span>
                            <span>{{ $card['floor'] }}</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
