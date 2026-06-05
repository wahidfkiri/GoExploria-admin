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

    $mssTr = isset($tr) && is_callable($tr)
        ? $tr
        : static function (string $text): string {
            $locale = app()->getLocale();
            if ($locale === 'fr') {
                return $text;
            }

            static $maps = [];
            if (! array_key_exists($locale, $maps)) {
                $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
                $maps[$locale] = is_file($path) ? (require $path) : [];
            }

            return $maps[$locale][$text] ?? $text;
        };
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
        <button class="mss-gallery-nav-btn" id="{{ $prevId }}" aria-label="{{ $mssTr('Précédent') }}">
            <i class="fas fa-chevron-left"></i>
        </button>
        <div class="mss-gallery-dots" id="{{ $dotsId }}">
            @foreach($slides as $i => $group)
                <div class="mss-gallery-dot {{ $i === 0 ? 'mss-gallery-dot--active' : '' }}"
                     data-idx="{{ $i }}"></div>
            @endforeach
        </div>
        <button class="mss-gallery-nav-btn" id="{{ $nextId }}" aria-label="{{ $mssTr('Suivant') }}">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

</div>

{{-- ===== MODAL VIDÉO ===== --}}
<div class="mss-gallery-modal" id="{{ $modalId }}">
    <div class="mss-gallery-modal-content">
        <div class="mss-gallery-modal-header">
            <h3 class="mss-gallery-modal-title" id="{{ $modalTitleId }}">{{ $mssTr('Vidéo') }}</h3>
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
    var position    = total > 1 ? 1 : 0;
    var isAnimating = false;
    var autoTimer   = null;
    var dots        = dotsWrap ? Array.from(dotsWrap.querySelectorAll('.mss-gallery-dot')) : [];

    if (total > 1) {
        var originalSlides = Array.from(track.children);
        var firstClone = originalSlides[0].cloneNode(true);
        var lastClone = originalSlides[originalSlides.length - 1].cloneNode(true);
        firstClone.dataset.mssClone = 'first';
        lastClone.dataset.mssClone = 'last';
        track.appendChild(firstClone);
        track.insertBefore(lastClone, originalSlides[0]);
        track.style.transition = 'none';
        track.style.transform = 'translateX(-100%)';
    }

    function updateDots() {
        dots.forEach(function (d, i) {
            d.classList.toggle('mss-gallery-dot--active', i === current);
        });
    }

    function settleLoopPosition() {
        if (position === 0) {
            position = total;
            track.style.transition = 'none';
            track.style.transform = 'translateX(-' + (position * 100) + '%)';
            if (track) track.offsetWidth;
        } else if (position === total + 1) {
            position = 1;
            track.style.transition = 'none';
            track.style.transform = 'translateX(-' + (position * 100) + '%)';
            if (track) track.offsetWidth;
        }
        isAnimating = false;
    }

    function moveToPosition(nextPosition, nextCurrent) {
        if (isAnimating || total <= 1) return;
        isAnimating = true;
        position = nextPosition;
        current = nextCurrent;
        track.style.transition = 'transform ' + TRANS_DURATION + 'ms cubic-bezier(0.25, 0.46, 0.45, 0.94)';
        track.style.transform = 'translateX(-' + (position * 100) + '%)';
        updateDots();
        setTimeout(settleLoopPosition, TRANS_DURATION + 30);
    }

    /* ---- Navigation ---- */
    function goTo(n) {
        if (isAnimating || total <= 1) return;
        var nextCurrent = ((n % total) + total) % total;
        var nextPosition = nextCurrent + 1;

        if (current === total - 1 && nextCurrent === 0 && n > current) {
            nextPosition = total + 1;
        } else if (current === 0 && nextCurrent === total - 1 && n < current) {
            nextPosition = 0;
        }

        moveToPosition(nextPosition, nextCurrent);
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
    var ytFrameId = '{{ $slideshowId }}YtFrame';
    var ytErrId   = '{{ $slideshowId }}YtErr';
    var unavailableLabel = @json($mssTr('Vidéo non disponible'));
    var unavailableHint = @json($mssTr('Vidéo introuvable ou non autorisée en intégration'));

    var ytMsgHandler = function (e) {
        if (!e.data) return;
        try {
            var msg = JSON.parse(e.data);
            if (msg.event === 'onError') {
                var errDiv = document.getElementById(ytErrId);
                var frame  = document.getElementById(ytFrameId);
                if (errDiv) { errDiv.style.display = 'flex'; }
                if (frame)  { frame.style.display  = 'none'; }
            }
        } catch (_) {}
    };

    function openModal(videoSrc, title) {
        if (!modal || !videoSrc) return;
        if (modalTitle) modalTitle.textContent = title || '';
        if (videoSrc.indexOf('http') === 0) {
            videoEl.innerHTML = '<video src="' + videoSrc + '" controls autoplay style="width:100%;display:block;max-height:520px;background:#000;"></video>';
        } else {
            var origin = window.location.origin;
            videoEl.innerHTML =
                '<div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;background:#000;">' +
                '<iframe id="' + ytFrameId + '"' +
                ' src="https://www.youtube.com/embed/' + videoSrc + '?autoplay=1&rel=0&enablejsapi=1&origin=' + origin + '"' +
                ' style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;"' +
                ' allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe>' +
                '<div id="' + ytErrId + '" style="display:none;position:absolute;inset:0;background:#0a1628;flex-direction:column;align-items:center;justify-content:center;gap:14px;">' +
                '<i class="fas fa-video-slash" style="font-size:3rem;color:#f26522;"></i>' +
                '<p style="color:#fff;font-family:Montserrat,sans-serif;font-weight:700;margin:0;">' + unavailableLabel + '</p>' +
                '<p style="color:rgba(255,255,255,0.6);font-family:Montserrat,sans-serif;font-size:0.8rem;margin:0;">' + unavailableHint + '</p>' +
                '</div></div>';
            window.addEventListener('message', ytMsgHandler);
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
        window.removeEventListener('message', ytMsgHandler);
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
