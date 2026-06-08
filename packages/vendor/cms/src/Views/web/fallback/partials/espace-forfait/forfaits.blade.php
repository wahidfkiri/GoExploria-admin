<section id="forfaits">
  <div class="container">
    <div class="forfaits-header"><div class="section-eyebrow">Produits</div><h2 class="section-title" style="color:white">Nos Produits <span class="italic">disponible</span></h2><p class="section-sub" style="color:rgba(255,255,255,.6)">{{ $cmsLandingProducts->isNotEmpty() ? 'Produits et forfaits réels configurés dans le CMS pour cet établissement.' : 'Des circuits soigneusement conçus pour tous les niveaux, incluant hébergement et accompagnement.' }}</p></div>
    <div class="forfaits-grid">
      @foreach($forfaitCards as $index => $item)
        @php $productLink = $devisLink . (str_contains($devisLink, '?') ? '&' : '?') . http_build_query(['etablissement_id' => $etablissement->id, 'product_id' => $item['product_id'] ?? null]); @endphp
        <article class="forfait-card {{ !empty($item['featured']) ? 'featured' : '' }}">
          <div class="forfait-img"><img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">@if(!empty($item['featured']))<div class="forfait-badge">★ Coup de cœur</div>@endif</div>
          <div class="forfait-body"><div class="forfait-tag">{{ $item['tag'] }}</div><div class="forfait-title">{{ $item['title'] }}</div><div class="forfait-meta"><div class="meta-item"><span class="meta-icon">📍</span> {{ $item['distance'] }}</div><div class="meta-item"><span class="meta-icon">⛷️</span> {{ $item['level'] }}</div><div class="meta-item"><span class="meta-icon">👥</span> {{ $item['people'] }}</div></div><div class="forfait-price"><span class="from">À partir de</span><span class="amount">{{ $item['price'] }}</span><span class="currency">{{ $item['unit'] }}</span></div>@if(!empty($item['description']))<p style="color:rgba(255,255,255,.62);font-size:13px;line-height:1.55;margin-top:10px">{{ $item['description'] }}</p>@endif
            @if(!empty($item['product_id']))
              <button
                type="button"
                class="forfait-btn"
                data-cms-cart-add
                data-product-id="{{ $item['product_id'] }}"
                data-product-name="{{ $item['title'] }}"
                data-product-price="{{ $item['raw_price'] ?? 0 }}"
                data-product-image="{{ $item['image'] ?? '' }}"
                data-product-url="{{ $productLink }}"
                data-etablissement-id="{{ $item['etablissement_id'] ?? $etablissement->id }}"
                data-etablissement-name="{{ $siteName }}"
              >Commander ce forfait →</button>
            @else
              <a href="{{ $productLink }}" target="_blank" rel="noopener" class="forfait-btn">Réserver ce forfait →</a>
            @endif
          </div>
        </article>
      @endforeach
    </div>
    <div class="forfaits-cta"><a href="#contact" class="btn btn-primary" style="padding:16px 36px;font-size:16px">Voir tous les forfaits →</a></div>
  </div>
</section>
