<section id="services">
  <div class="container">
    <div class="section-eyebrow">Nos services</div>
    <h2 class="section-title">Location <span class="italic">& Aventure</span></h2>
    <p class="section-sub">Découvrez nos véhicules haut de gamme disponibles à la journée, demi-journée ou plusieurs jours, avec ou sans guide.</p>
    <div class="services-grid">
      @foreach($serviceCards as $service)
        <article class="service-card">
          <div class="service-img"><img src="{{ $service['image'] }}" alt="{{ $service['title'] }}"><div class="service-img-overlay"></div><div class="service-img-badge">{{ $service['badge'] }}</div></div>
          <div class="service-body"><div class="service-title">{{ $service['title'] }}</div><div class="service-desc">{{ $service['desc'] }}</div><div class="service-price"><span class="price-from">À partir de</span><span class="price-amount">{{ $service['price'] }}</span><span class="price-unit">{{ $service['unit'] }}</span></div><a href="#contact" class="service-link">Réserver maintenant →</a></div>
        </article>
      @endforeach
    </div>
  </div>
</section>
