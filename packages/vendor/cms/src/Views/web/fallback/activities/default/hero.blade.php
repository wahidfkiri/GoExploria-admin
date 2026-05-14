@php
    $siteName = get_site_name($etablissement->id ?? null);
    $devisLink = $devisUrl ?? route('devis');

    $heroSlides = collect($sliders ?? [])
        ->sortBy('order')
        ->map(function ($slide) {
            $type = strtolower((string) ($slide->type ?? 'image')) === 'video' ? 'video' : 'image';
            $image = $slide->image_url ?? $slide->image_path ?? $slide->thumbnail_url ?? $slide->thumbnail_path ?? null;
            $video = $slide->video_embed_url ?? $slide->video_url ?? null;
            $mediaUrl = $type === 'video' ? $video : $image;
            return [
                'title' => $slide->name ?? null,
                'description' => $slide->description ?? null,
                'type' => $type,
                'video_type' => $slide->video_type ?? null,
                'media_url' => $mediaUrl,
                'image' => $image,
                'button_text' => $slide->button_text ?? null,
                'button_url' => $slide->button_url ?? null,
            ];
        })
        ->filter(fn ($row) => !empty($row['media_url']))
        ->values();

    if ($heroSlides->isEmpty()) {
        $heroSlides = collect([
            ['title' => $siteName, 'description' => null, 'type' => 'image', 'video_type' => null, 'media_url' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/IMG-01.jpg', 'image' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/IMG-01.jpg', 'button_text' => null, 'button_url' => null],
            ['title' => $siteName, 'description' => null, 'type' => 'image', 'video_type' => null, 'media_url' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/IMG-15.jpg', 'image' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/IMG-15.jpg', 'button_text' => null, 'button_url' => null],
            ['title' => $siteName, 'description' => null, 'type' => 'image', 'video_type' => null, 'media_url' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/IMG-11.jpg', 'image' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/IMG-11.jpg', 'button_text' => null, 'button_url' => null],
            ['title' => $siteName, 'description' => null, 'type' => 'image', 'video_type' => null, 'media_url' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/IMG-08.jpg', 'image' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/IMG-08.jpg', 'button_text' => null, 'button_url' => null],
            ['title' => $siteName, 'description' => null, 'type' => 'image', 'video_type' => null, 'media_url' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/IMG-17.jpg', 'image' => 'https://moulinascielanaudiere.com/wp-content/uploads/2025/05/IMG-17.jpg', 'button_text' => null, 'button_url' => null],
        ]);
    }

    $firstSlide = $heroSlides->first();
    $firstTitle = trim((string) ($firstSlide['title'] ?? ''));
    $firstSubtitle = trim((string) ($firstSlide['description'] ?? ''));
    $firstButtonText = trim((string) ($firstSlide['button_text'] ?? ''));
    $firstButtonUrl = trim((string) ($firstSlide['button_url'] ?? ''));
@endphp

<section class="default-landing-hero" id="section-hero">
    <div class="dlh-slides" id="dlhSlides">
        @foreach($heroSlides as $index => $slide)
            <div
                class="dlh-slide {{ $index === 0 ? 'active' : '' }}"
                data-slide="{{ $index }}"
                data-type="{{ $slide['type'] }}"
                data-title="{{ e((string) ($slide['title'] ?? '')) }}"
                data-subtitle="{{ e((string) ($slide['description'] ?? '')) }}"
                data-button-text="{{ e((string) ($slide['button_text'] ?? '')) }}"
                data-button-url="{{ e((string) ($slide['button_url'] ?? '')) }}"
            >
                @if($slide['type'] === 'video')
                    @if(in_array($slide['video_type'], ['youtube', 'vimeo', 'iframe'], true))
                        <iframe
                            class="dlh-media dlh-iframe"
                            src="{{ $slide['media_url'] }}{{ str_contains((string) $slide['media_url'], '?') ? '&' : '?' }}autoplay=1&mute=1&loop=1&controls=0&playsinline=1&rel=0&modestbranding=1"
                            frameborder="0"
                            allow="autoplay; encrypted-media"
                            allowfullscreen
                        ></iframe>
                    @else
                        <video class="dlh-media dlh-video" muted loop playsinline preload="metadata">
                            <source src="{{ $slide['media_url'] }}" type="video/mp4">
                        </video>
                    @endif
                @else
                    <div class="dlh-media dlh-image" style="background-image:url('{{ $slide['media_url'] }}')"></div>
                @endif
                <div class="dlh-overlay"></div>
            </div>
        @endforeach
    </div>

    <div class="dlh-content">
        <div class="dlh-badge">Sciage Mobile Professionnel · Lanaudière</div>
        <h1 id="dlhTitle">{!! $firstTitle !== '' ? nl2br(e($firstTitle)) : 'Votre Bois,<br><em>Notre Expertise</em>' !!}</h1>
        <p class="dlh-sub" id="dlhSubtitle">
            {{ $firstSubtitle !== '' ? $firstSubtitle : 'Moulin à scie hydraulique informatisé pour transformer votre bois brut en matériaux de qualité supérieure. Précision. Fiabilité. Satisfaction garantie.' }}
        </p>
        <div class="dlh-buttons">
            <a
                href="{{ $firstButtonUrl !== '' ? $firstButtonUrl : $devisLink }}"
                class="dlh-btn-primary"
                target="_blank"
                rel="noopener noreferrer"
                id="dlhPrimaryCta"
            >
                {{ $firstButtonText !== '' ? $firstButtonText : 'Soumission Gratuite' }}
            </a>
            <a href="#section-gallery" class="dlh-btn-outline">Voir les Réalisations</a>
        </div>
    </div>

    <div class="dlh-dots" id="dlhDots">
        @foreach($heroSlides as $index => $slide)
            <button class="dlh-dot {{ $index === 0 ? 'active' : '' }}" type="button" data-slide="{{ $index }}" aria-label="Slide {{ $index + 1 }}"></button>
        @endforeach
    </div>
</section>

<div class="dlh-stats-bar">
    <div class="dlh-stat-item">
        <div class="dlh-stat-num">38″</div>
        <div class="dlh-stat-label">Diamètre max. de billots</div>
    </div>
    <div class="dlh-stat-item">
        <div class="dlh-stat-num">20′</div>
        <div class="dlh-stat-label">Longueur max. de coupe</div>
    </div>
    <div class="dlh-stat-item">
        <div class="dlh-stat-num">7/7</div>
        <div class="dlh-stat-label">Jours de service</div>
    </div>
    <div class="dlh-stat-item">
        <div class="dlh-stat-num">3</div>
        <div class="dlh-stat-label">Régions desservies</div>
    </div>
</div>

<style>
    .default-landing-hero {
        position: relative;
        height: 100vh;
        min-height: 600px;
        overflow: hidden;
        border-radius: 16px 16px 0 0;
    }

    .dlh-slides {
        position: absolute;
        inset: 0;
    }

    .dlh-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 1.2s ease;
    }

    .dlh-slide.active { opacity: 1; }

    .dlh-media {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        display: block;
    }

    .dlh-image {
        background-size: cover;
        background-position: center;
    }

    .dlh-video {
        object-fit: cover;
    }

    .dlh-iframe {
        border: 0;
    }

    .dlh-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(26,58,30,.75) 0%, rgba(10,20,12,.5) 60%, rgba(0,0,0,.3) 100%);
    }

    .dlh-content {
        position: relative;
        z-index: 2;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        padding: 0 8%;
        padding-top: 72px;
    }

    .dlh-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(212,168,83,.2);
        border: 1px solid rgba(212,168,83,.5);
        color: #f0c97f;
        padding: 6px 16px;
        border-radius: 40px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        margin-bottom: 24px;
    }

    .dlh-badge::before { content: '🌲'; font-size: 14px; }

    .dlh-content h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(3rem, 7vw, 6rem);
        font-weight: 900;
        color: #fff;
        line-height: 1.05;
        max-width: 700px;
        margin-bottom: 16px;
    }

    .dlh-content h1 em { color: #f0c97f; font-style: italic; }

    .dlh-sub {
        font-size: clamp(1rem, 2vw, 1.25rem);
        color: rgba(255,255,255,.82);
        max-width: 620px;
        margin-bottom: 40px;
        font-weight: 300;
        line-height: 1.6;
    }

    .dlh-buttons {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .dlh-btn-primary {
        background: #d4a853;
        color: #3d2b1a;
        padding: 16px 36px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 15px;
        letter-spacing: .04em;
        border: 2px solid #d4a853;
    }

    .dlh-btn-outline {
        background: transparent;
        color: #fff;
        padding: 14px 34px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 15px;
        border: 2px solid rgba(255,255,255,.6);
    }

    .dlh-btn-primary:hover { background: #f0c97f; border-color: #f0c97f; }
    .dlh-btn-outline:hover { border-color: #fff; background: rgba(255,255,255,.1); }

    .dlh-dots {
        position: absolute;
        bottom: 32px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 3;
    }

    .dlh-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255,255,255,.4);
        cursor: pointer;
        border: none;
    }

    .dlh-dot.active {
        background: #d4a853;
        width: 24px;
        border-radius: 4px;
    }

    .dlh-stats-bar {
        background: #1a3a1e;
        padding: 28px 5%;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        border-bottom: 3px solid #d4a853;
    }

    .dlh-stat-item {
        text-align: center;
        padding: 0 20px;
        border-right: 1px solid rgba(255,255,255,.15);
    }

    .dlh-stat-item:last-child { border-right: none; }

    .dlh-stat-num {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 700;
        color: #f0c97f;
    }

    .dlh-stat-label {
        font-size: 13px;
        color: rgba(255,255,255,.7);
        font-weight: 400;
        margin-top: 4px;
    }

    @media (max-width: 768px) {
        .default-landing-hero { min-height: 520px; border-radius: 12px 12px 0 0; }
        .dlh-content { padding: 0 5%; padding-top: 72px; }
        .dlh-stats-bar { grid-template-columns: repeat(2, 1fr); }
        .dlh-stat-item {
            border-right: none;
            border-bottom: 1px solid rgba(255,255,255,.15);
            padding: 16px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slides = Array.from(document.querySelectorAll('#dlhSlides .dlh-slide'));
        const dots = Array.from(document.querySelectorAll('#dlhDots .dlh-dot'));
        if (!slides.length) return;

        const titleEl = document.getElementById('dlhTitle');
        const subtitleEl = document.getElementById('dlhSubtitle');
        const primaryCta = document.getElementById('dlhPrimaryCta');

        let current = 0;
        let timer = null;

        function updateContent(index) {
            const slide = slides[index];
            if (!slide) return;
            const title = (slide.dataset.title || '').trim();
            const subtitle = (slide.dataset.subtitle || '').trim();
            const buttonText = (slide.dataset.buttonText || '').trim();
            const buttonUrl = (slide.dataset.buttonUrl || '').trim();

            if (titleEl) {
                titleEl.innerHTML = title !== '' ? title.replace(/\n/g, '<br>') : 'Votre Bois,<br><em>Notre Expertise</em>';
            }
            if (subtitleEl) {
                subtitleEl.textContent = subtitle !== ''
                    ? subtitle
                    : 'Moulin à scie hydraulique informatisé pour transformer votre bois brut en matériaux de qualité supérieure. Précision. Fiabilité. Satisfaction garantie.';
            }
            if (primaryCta) {
                primaryCta.textContent = buttonText !== '' ? buttonText : 'Soumission Gratuite';
                primaryCta.setAttribute('href', buttonUrl !== '' ? buttonUrl : '{{ $devisLink }}');
            }
        }

        function syncVideos() {
            slides.forEach(function (slide, index) {
                const video = slide.querySelector('video');
                if (!video) return;
                if (index === current) {
                    video.currentTime = 0;
                    video.play().catch(function () {});
                } else {
                    video.pause();
                }
            });
        }

        function goTo(index) {
            slides[current].classList.remove('active');
            if (dots[current]) dots[current].classList.remove('active');
            current = (index + slides.length) % slides.length;
            slides[current].classList.add('active');
            if (dots[current]) dots[current].classList.add('active');
            updateContent(current);
            syncVideos();
        }

        function start() {
            if (slides.length <= 1) return;
            timer = setInterval(function () {
                goTo(current + 1);
            }, 5000);
        }

        dots.forEach(function (dot, index) {
            dot.addEventListener('click', function () {
                if (timer) clearInterval(timer);
                goTo(index);
                start();
            });
        });

        updateContent(0);
        syncVideos();
        start();
    });
</script>
