{{-- Video Carousel Background Component --}}
<div class="video-carousel-background">
    <div class="video-carousel-container">
        <div class="video-slide active" data-slide="0">
            <video class="video-background" autoplay muted loop playsinline>
                <source src="{{ asset('home2/videos/hero-video-1.mp4.mp4') }}" type="video/mp4">
            </video>
        </div>
        
        <div class="video-slide" data-slide="1">
            <video class="video-background" muted loop playsinline>
                <source src="{{ asset('home2/videos/hero-video-2.mp4.mp4') }}" type="video/mp4">
            </video>
        </div>
        
        <div class="video-slide" data-slide="2">
            <video class="video-background" muted loop playsinline>
                <source src="{{ asset('home2/videos/hero-video-3.mp4.mp4') }}" type="video/mp4">
            </video>
        </div>
    </div>
    
    <div class="carousel-controls">
        <button class="carousel-dot" data-slide="0" aria-label="Video 1"></button>
        <button class="carousel-dot" data-slide="1" aria-label="Video 2"></button>
        <button class="carousel-dot" data-slide="2" aria-label="Video 3"></button>
    </div>
</div>
