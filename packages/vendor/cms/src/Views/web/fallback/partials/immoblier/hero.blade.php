<section class="pc-hero" id="accueil">
    <div class="swiper pc-hero-swiper">
        <div class="swiper-wrapper">
            @foreach($heroSlides as $slide)
                <div class="swiper-slide">
                    @if(!empty($slide['embed']))
                        <iframe class="pc-slide-iframe" src="{{ $slide['embed'] }}" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                    @elseif(($slide['type'] ?? 'image') === 'video')
                        <video class="pc-slide-video" src="{{ $slide['url'] }}" autoplay muted loop playsinline></video>
                    @else
                        <img class="pc-slide-media" src="{{ $slide['url'] }}" alt="{{ $slide['title'] }}">
                    @endif
                    <div class="pc-slide-overlay"></div>
                    <div class="pc-slide-content">
                        <h1 class="pc-slide-title">{{ $slide['title'] }} <em>{{ $slogan }}</em></h1>
                        <p class="pc-slide-sub">{{ $slide['subtitle'] }}</p>
                        @if((!empty($slide['button_text']) && !empty($slide['button_url'])) || (!empty($heroSecondaryCtaText) && !empty($heroSecondaryCtaUrl)))
                            <div style="display:flex;gap:12px;flex-wrap:wrap">
                                @if(!empty($slide['button_text']) && !empty($slide['button_url']))
                                    <a class="pc-btn pc-btn-light" href="{{ $slide['button_url'] }}">{{ $slide['button_text'] }} <i class="fa-solid fa-arrow-right"></i></a>
                                @endif
                                @if(!empty($heroSecondaryCtaText) && !empty($heroSecondaryCtaUrl))
                                    <a class="pc-btn pc-btn-outline" href="{{ $heroSecondaryCtaUrl }}">{{ $heroSecondaryCtaText }}</a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="pc-hero-nav">
            <button class="pc-hero-btn pc-hero-prev" type="button" aria-label="Précédent"><i class="fa-solid fa-arrow-left"></i></button>
            <button class="pc-hero-btn pc-hero-next" type="button" aria-label="Suivant"><i class="fa-solid fa-arrow-right"></i></button>
        </div>
        <div class="pc-scroll">Défiler<span></span></div>
    </div>
</section>
