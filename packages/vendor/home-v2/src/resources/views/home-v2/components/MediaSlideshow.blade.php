{{-- ================================================================
     MediaSlideshow — Multi-carte Gallery Carousel réutilisable
     Paramètres :
       $slideshowId : string — identifiant unique (ex: 'destMedia', 'eventsMedia')
       $slides      : array  — tableau de groupes de slides :
                        main : ['src','video','title','desc','badge']
                               video = YouTube ID ou URL mp4
                        grid : array de 4 items identiques à main
     ================================================================ --}}
@php
    $slideshowId  = $slideshowId ?? ('mss' . substr(md5(uniqid()), 0, 6));
    $slides       = $slides ?? [];
    $total        = count($slides);
    $trackId      = $slideshowId . 'Track';
    $dotsId       = $slideshowId . 'Dots';
    $prevId       = $slideshowId . 'Prev';
    $nextId       = $slideshowId . 'Next';
    $modalId      = $slideshowId . 'Modal';
    $modalTitleId = $slideshowId . 'ModalTitle';
    $closeModalId = $slideshowId . 'CloseModal';
    $videoContId  = $slideshowId . 'VideoCont';
@endphp

{{-- ===== GALLERY MULTI-CARTE ===== --}}
<div class="mss-gallery-wrapper">

    <div class="mss-gallery-container">
        <div class="mss-gallery-track" id="{{ $trackId }}">

            @foreach($slides as $i => $group)
            @php
                $main = $group['main'] ?? [];
                $grid = array_slice($group['grid'] ?? [], 0, 4);
            @endphp
            <div class="mss-gallery-slide">

                {{-- Grande carte gauche --}}
                <div class="mss-gallery-col mss-gallery-col--half mss-gallery-main mss-gallery-item"
                     data-video="{{ $main['video'] ?? '' }}"
                     data-title="{{ $main['title'] ?? '' }}">
                    @if($main['badge'] ?? null)
                        <div class="mss-gallery-badge mss-gallery-badge--{{ $main['badge'] }}">{{ $main['badge'] }}</div>
                    @endif
                    <img src="{{ $main['src'] ?? '' }}" alt="{{ $main['title'] ?? '' }}" loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                    <div class="mss-gallery-overlay">
                        <div class="mss-gallery-title">{{ $main['title'] ?? '' }}</div>
                        <div class="mss-gallery-desc">{{ $main['desc'] ?? '' }}</div>
                    </div>
                    <div class="mss-gallery-play"><i class="fas fa-play"></i></div>
                </div>

                {{-- Grille 2×2 droite --}}
                <div class="mss-gallery-col mss-gallery-col--half mss-gallery-grid">
                    @foreach($grid as $item)
                    <div class="mss-gallery-tile mss-gallery-item"
                         data-video="{{ $item['video'] ?? '' }}"
                         data-title="{{ $item['title'] ?? '' }}">
                        @if($item['badge'] ?? null)
                            <div class="mss-gallery-badge mss-gallery-badge--{{ $item['badge'] }}">{{ $item['badge'] }}</div>
                        @endif
                        <img src="{{ $item['src'] ?? '' }}" alt="{{ $item['title'] ?? '' }}" loading="lazy">
                        <div class="mss-gallery-overlay">
                            <div class="mss-gallery-title">{{ $item['title'] ?? '' }}</div>
                            <div class="mss-gallery-desc">{{ $item['desc'] ?? '' }}</div>
                        </div>
                        <div class="mss-gallery-play"><i class="fas fa-play"></i></div>
                    </div>
                    @endforeach
                </div>

            </div>
            @endforeach

        </div>
    </div>

    {{-- Navigation : ◀  ● ● ○  ▶ --}}
    <div class="mss-gallery-nav">
        <button class="mss-gallery-nav-btn" id="{{ $prevId }}" aria-label="Précédent">
            <i class="fas fa-chevron-left"></i>
        </button>
        <div class="mss-gallery-dots" id="{{ $dotsId }}">
            @foreach($slides as $i => $group)
                <div class="mss-gallery-dot {{ $i === 0 ? 'mss-gallery-dot--active' : '' }}"
                     data-idx="{{ $i }}"></div>
            @endforeach
        </div>
        <button class="mss-gallery-nav-btn" id="{{ $nextId }}" aria-label="Suivant">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

</div>

{{-- ===== MODAL VIDÉO ===== --}}
<div class="mss-gallery-modal" id="{{ $modalId }}">
    <div class="mss-gallery-modal-content">
        <div class="mss-gallery-modal-header">
            <h3 class="mss-gallery-modal-title" id="{{ $modalTitleId }}">Vidéo</h3>
            <button class="mss-gallery-modal-close" id="{{ $closeModalId }}">&times;</button>
        </div>
        <div class="mss-gallery-video-container" id="{{ $videoContId }}"></div>
    </div>
</div>

{{-- ===== SCRIPT IIFE (isolé par instance) ===== --}}
<script>
(function () {
    'use strict';

    var SLIDE_DURATION = 8000;
    var TRANS_DURATION = 1500;

    var track      = document.getElementById('{{ $trackId }}');
    var dotsWrap   = document.getElementById('{{ $dotsId }}');
    var modal      = document.getElementById('{{ $modalId }}');
    var videoEl    = document.getElementById('{{ $videoContId }}');
    var modalTitle = document.getElementById('{{ $modalTitleId }}');
    var closeBtn   = document.getElementById('{{ $closeModalId }}');
    if (!track) return;

    var total       = {{ $total }};
    var current     = 0;
    var isAnimating = false;
    var autoTimer   = null;
    var dots        = dotsWrap ? Array.from(dotsWrap.querySelectorAll('.mss-gallery-dot')) : [];

    /* ---- Navigation ---- */
    function goTo(n) {
        if (isAnimating || total <= 1) return;
        isAnimating = true;
        current = ((n % total) + total) % total;
        track.style.transition = 'transform ' + TRANS_DURATION + 'ms cubic-bezier(0.25, 0.46, 0.45, 0.94)';
        track.style.transform  = 'translateX(-' + (current * 100) + '%)';
        dots.forEach(function (d, i) {
            d.classList.toggle('mss-gallery-dot--active', i === current);
        });
        setTimeout(function () { isAnimating = false; }, TRANS_DURATION);
    }

    /* ---- Auto-play ---- */
    function startAuto() {
        clearInterval(autoTimer);
        autoTimer = setInterval(function () { goTo(current + 1); }, SLIDE_DURATION);
    }

    function stopAuto() {
        clearInterval(autoTimer);
        autoTimer = null;
    }

    document.getElementById('{{ $prevId }}').addEventListener('click', function () {
        stopAuto(); goTo(current - 1); startAuto();
    });
    document.getElementById('{{ $nextId }}').addEventListener('click', function () {
        stopAuto(); goTo(current + 1); startAuto();
    });

    dots.forEach(function (dot, i) {
        dot.addEventListener('click', function () { stopAuto(); goTo(i); startAuto(); });
    });

    /* ---- Modal vidéo ---- */
    function openModal(videoSrc, title) {
        if (!modal || !videoSrc) return;
        if (modalTitle) modalTitle.textContent = title || '';
        if (videoSrc.indexOf('http') === 0) {
            videoEl.innerHTML = '<video src="' + videoSrc + '" controls autoplay style="width:100%;display:block;max-height:520px;background:#000;"></video>';
        } else {
            videoEl.innerHTML = '<div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;background:#000;"><iframe src="https://www.youtube.com/embed/' + videoSrc + '?autoplay=1&rel=0" style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;" allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe></div>';
        }
        modal.classList.add('mss-gallery-modal--active');
        document.body.style.overflow = 'hidden';
        stopAuto();
    }

    function closeModal() {
        if (!modal) return;
        modal.classList.remove('mss-gallery-modal--active');
        if (videoEl) videoEl.innerHTML = '';
        document.body.style.overflow = '';
        startAuto();
    }

    track.querySelectorAll('.mss-gallery-item').forEach(function (item) {
        item.addEventListener('click', function () {
            openModal(this.dataset.video, this.dataset.title);
        });
        var playBtn = item.querySelector('.mss-gallery-play');
        if (playBtn) {
            playBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                openModal(item.dataset.video, item.dataset.title);
            });
        }
    });

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (modal)    modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal && modal.classList.contains('mss-gallery-modal--active')) closeModal();
    });

    /* ---- Init ---- */
    startAuto();
})();
</script>
