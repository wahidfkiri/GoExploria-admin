{{-- Section Hero (statique + slider DB si disponible) --}}
@if(is_slider_enabled($etablissement->id))
    @if(has_slider($etablissement->id))
        {!! get_slider_html($etablissement->id) !!}
    @elseif(($heroSlides ?? collect())->isNotEmpty())
        @php($hero = $heroSlides->first())
        @php($heroEmbed = !empty($hero['embed']) ? $hero['embed'] . (str_contains((string) $hero['embed'], '?') ? '&' : '?') . 'autoplay=1&mute=1&muted=1&playsinline=1' : null)
        <section class="lp-hero" id="top">
            <div class="lp-hero-media">
                @if(!empty($heroEmbed))
                    <iframe src="{{ $heroEmbed }}" title="{{ $hero['title'] ?: $siteName }}" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                @elseif(($hero['type'] ?? 'image') === 'video' && !empty($hero['url']))
                    <video src="{{ $hero['url'] }}" poster="{{ $hero['poster'] }}" autoplay muted loop playsinline></video>
                @else
                    <img src="{{ $hero['url'] ?: $hero['poster'] }}" alt="{{ $hero['title'] ?: $siteName }}">
                @endif
            </div>
            <div class="container lp-hero-inner">
                <div>
                    <div class="lp-kicker">{{ $siteName }}</div>
                    <h1 class="lp-h1">{!! e($hero['title'] ?: $siteName) !!}</h1>
                    @if(!empty($hero['subtitle']) || $siteDescription !== '')
                        <p class="lp-desc">{{ $hero['subtitle'] ?: $siteDescription }}</p>
                    @endif
                    <div class="lp-hero-buttons">
                        @if(!empty($hero['button_text']) && !empty($hero['button_url']))
                            <a class="lp-btn gold" href="{{ $hero['button_url'] }}">{{ $hero['button_text'] }} <i class="fa-solid fa-arrow-right"></i></a>
                        @endif
                        <a class="lp-btn" href="#contact">Nous contacter</a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endif
