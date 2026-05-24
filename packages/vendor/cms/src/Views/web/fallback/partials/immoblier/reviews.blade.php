<section class="pc-section pc-reviews" id="avis">
    <div class="pc-container">
        <div class="pc-section-header pc-reveal">
            <span class="pc-eyebrow">Avis clients</span>
            <h2 class="pc-title">Ils parlent de leur <em>expérience</em></h2>
        </div>
        <div class="swiper pc-reviews-swiper pc-reveal">
            <div class="swiper-wrapper">
                @foreach($reviewCards as $review)
                    <div class="swiper-slide">
                        <article class="pc-review-card">
                            <div class="pc-stars">@for($i = 1; $i <= 5; $i++){{ $i <= round($review['rating']) ? '★' : '☆' }}@endfor</div>
                            <p class="pc-review-text">“{{ $review['text'] }}”</p>
                            <div class="pc-review-author">
                                <div class="pc-review-avatar">{{ mb_substr($review['author'], 0, 1, 'UTF-8') }}</div>
                                <div><div class="pc-review-name">{{ $review['author'] }}</div><div class="pc-review-source">{{ $review['source'] }}</div></div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
