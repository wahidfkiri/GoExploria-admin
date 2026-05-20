<section id="avis">
  <div class="container">
    <div class="section-eyebrow">Avis clients</div>
    <h2 class="section-title">Ils ont vécu <span class="italic">l’expérience</span></h2>
    <p class="section-sub">Une section sociale conçue comme dans le design original pour rassurer avant la réservation.</p>

    <div class="reviews-grid">
      @foreach($reviewCards as $review)
        @php
          $rating = max(0, min(5, (int) round((float) ($review['rating'] ?? 5))));
          $stars = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
          $ratingLabel = number_format(max(0, min(5, (float) ($review['rating'] ?? 5))), 1);
        @endphp

        <article class="review-card">
          <div class="stars">{{ $stars }}</div>
          <p class="review-text">“{{ $review['text'] ?? 'Expérience exceptionnelle.' }}”</p>
          <div class="review-author">{{ $review['author'] ?? 'Client satisfait' }}</div>
          <div class="review-source">{{ $review['source'] ?? 'Google' }} · {{ $ratingLabel }}/5</div>
        </article>
      @endforeach
    </div>
  </div>
</section>
