@php ob_start(); @endphp
@php
    use Illuminate\Support\Facades\DB;

    $videoAds = DB::table('ads')
        ->where('status', 'active')
        ->whereNotNull('video_url')
        ->where('video_url', '!=', '')
        ->where(function ($q) {
            $q->whereNull('start_date')->orWhere('start_date', '<=', now()->toDateString());
        })
        ->where(function ($q) {
            $q->whereNull('end_date')->orWhere('end_date', '>=', now()->toDateString());
        })
        ->where(function ($q) {
            $q->whereNull('budget_total')
              ->orWhereRaw('budget_total > COALESCE(budget_spent, 0)');
        })
        ->orderBy('priority')
        ->orderByDesc('id')
        ->get();

    $isYouTubeUrl = function ($url) {
        return preg_match('/(?:youtube\.com|youtu\.be)/i', $url) === 1;
    };

    $embedYouTubeUrl = function ($url) {
        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m);
        return $m[1] ?? null;
    };

    // Services publiés (gérés dans l'admin /services) — affichés en tête du panneau Info.
    $infoServices = collect();
    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('services')) {
            $infoServices = \App\Models\Service::active()->ordered()->get();
        }
    } catch (\Throwable $e) {
        $infoServices = collect();
    }

    $svcIconClass = static function ($icon) {
        $icon = trim((string) $icon);
        if ($icon === '') { return 'fas fa-concierge-bell'; }
        return \Illuminate\Support\Str::contains($icon, 'fa-') ? $icon : 'fas fa-' . $icon;
    };
@endphp

{{-- Info Mega Menu Component Compact --}}
<div class="header-mega-menu info-mega-menu-v2 compact-menu" id="infoMegaMenuV2">

    {{-- Ticker Section --}}
    <!-- <div class="mega-menu-ticker">
        <div class="ticker-item">
            <i class="fas fa-chart-line" style="color: #ffd700;"></i>
            <span style="color: #ffd700;">TSX: 21,450.12 <span style="color: #4cd137;">+1.2%</span></span>
        </div>
        <div class="ticker-item">
            <i class="fas fa-sun" style="color: #ffd700;"></i>
            <span>QC: -5°C</span>
        </div>
        <div class="ticker-item">
            <i class="fas fa-gas-pump" style="color: #fff;"></i>
            <span>Essence: 1.62$</span>
        </div>
    </div> -->

    {{-- Nos Services (depuis l'admin /services) --}}
    @if($infoServices->isNotEmpty())
    <div class="vmenu-services-block">
        <div class="vmenu-services-head">
            <h4><i class="fas fa-concierge-bell"></i> Nos Services</h4>
        </div>
        <div class="vmenu-services-grid">
            @foreach($infoServices as $svc)
            <a href="{{ route('service.landing', $svc->slug) }}" class="vmenu-service-card" style="--svc-color: {{ $svc->color ?: '#10b981' }};">
                <span class="vmenu-service-media">
                    @if($svc->image_url)
                        <img src="{{ $svc->image_url }}" alt="{{ $svc->name }}" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                        <span class="vmenu-service-ic" style="display:none;"><i class="{{ $svcIconClass($svc->icon) }}"></i></span>
                    @else
                        <span class="vmenu-service-ic"><i class="{{ $svcIconClass($svc->icon) }}"></i></span>
                    @endif
                </span>
                <span class="vmenu-service-body">
                    <b>{{ $svc->name }}</b>
                    @if($svc->description)
                        <span>{{ \Illuminate\Support\Str::limit(strip_tags($svc->description), 68) }}</span>
                    @endif
                </span>
                <i class="fas fa-arrow-right vmenu-service-arrow"></i>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <div class="mega-menu-main-content">
        {{-- Compact Media Slider --}}
        <div class="mega-menu-carousel-clean">
            <div class="carousel-media-viewport" id="exclusiveMediaViewport">
                {{-- Slide 1: Video --}}
                <div class="carousel-item-simple ">
                    <div class="media-container-v2">
                        <iframe src="https://www.youtube.com/embed/hdxKTW1ER5w" title="Video Québec"
                            class="slide-media-direct"></iframe>
                        <button class="expand-media-btn" onclick="openDedicatedVideo('hdxKTW1ER5w', 'Québec Travel')">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>

                {{-- Slide 2: Image --}}
                <div class="carousel-item-simple">
                    <div class="media-container-v2">
                        <img src="https://picsum.photos/800/1200?random=61" class="slide-media-direct">
                        <button class="expand-media-btn"
                            onclick="openDedicatedImage('https://picsum.photos/800/1200?random=61', 'Paysage Québec')">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>

                {{-- Ads videos depuis la table ads --}}
                @foreach($videoAds as $ad)
                @php
                    $ytId = $embedYouTubeUrl($ad->video_url);
                    $adOnclick = $ytId
                        ? "openDedicatedVideo('$ytId', '" . e($ad->titre) . "')"
                        : "openDedicatedImage('" . e($ad->video_url) . "', '" . e($ad->titre) . "')";
                @endphp
                <div class="carousel-item-simple{{ $loop->first ? ' active' : '' }}">
                    <div class="media-container-v2 ad-container">
                        @if($ad->destination_url)
                        <a href="{{ $ad->destination_url }}" target="{{ $ad->open_new_tab ? '_blank' : '_self' }}"
                            class="ad-title-link" title="{{ $ad->titre }}">
                            <span class="ad-title">{{ $ad->titre }}</span>
                        </a>
                        @else
                        <span class="ad-title">{{ $ad->titre }}</span>
                        @endif
                        @if($ytId)
                            <iframe src="https://www.youtube.com/embed/{{ $ytId }}?autoplay=0&mute=0&controls=1"
                                title="{{ $ad->titre }}" class="slide-media-direct"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        @else
                            <video class="slide-media-direct" controls preload="metadata" playsinline>
                                <source src="{{ $ad->video_url }}">
                            </video>
                        @endif
                        @if($ad->destination_url)
                        <a href="{{ $ad->destination_url }}" target="{{ $ad->open_new_tab ? '_blank' : '_self' }}"
                            class="expand-media-btn" title="{{ $ad->titre }}">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        @else
                        <button class="expand-media-btn" onclick="{{ $adOnclick }}">
                            <i class="fas fa-expand"></i>
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach

                {{-- Navigation --}}
                <button class="mega-nav-btn prev" id="mediaPrev"><i class="fas fa-chevron-left"></i></button>
                <button class="mega-nav-btn next" id="mediaNext"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="mega-menu-footer-btns">
        <a href="{{url('/landing/experiences-quebec')}}" class="footer-btn btn-quebec"><span>EXPÉRIENCES
                QUÉBEC</span></a>
        <a href="{{url('/landing/experiences-canada')}}" class="footer-btn btn-canada"><span>EXPÉRIENCES
                CANADA</span></a>
        <a href="{{url('/landing/experiences-monde')}}" class="footer-btn btn-monde"><span>EXPÉRIENCES MONDE</span></a>
    </div>

    <style>
        /* ── Bloc « Nos Services » (panneau Info du menu vertical) ── */
        .vmenu-services-block { margin: 0 0 16px; padding: 14px 16px; background: linear-gradient(135deg,#f0fbf5,#ffffff); border:1px solid #e6efe9; border-radius:16px; }
        .vmenu-services-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; }
        .vmenu-services-head h4 { margin:0; font-size:0.95rem; font-weight:800; color:#0b2b25; display:flex; align-items:center; gap:8px; }
        .vmenu-services-head h4 i { color:#10b981; }
        .vmenu-services-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:10px; max-height:320px; overflow-y:auto; padding-right:4px; }
        .vmenu-service-card { display:flex; align-items:center; gap:12px; padding:10px; background:#fff; border:1px solid #eef2f0; border-radius:12px; text-decoration:none; transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease; position:relative; overflow:hidden; }
        .vmenu-service-card:hover { transform:translateY(-2px); border-color:var(--svc-color,#10b981); box-shadow:0 12px 24px rgba(6,60,45,.10); }
        .vmenu-service-media { flex:0 0 46px; width:46px; height:46px; border-radius:11px; overflow:hidden; background:color-mix(in srgb,var(--svc-color,#10b981) 14%,#fff); display:flex; align-items:center; justify-content:center; }
        .vmenu-service-media img { width:100%; height:100%; object-fit:cover; display:block; }
        .vmenu-service-ic { width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:var(--svc-color,#10b981); font-size:1.15rem; }
        .vmenu-service-body { flex:1; min-width:0; }
        .vmenu-service-body b { display:block; font-size:0.9rem; font-weight:700; color:#0f2b24; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .vmenu-service-body span { display:block; font-size:0.76rem; color:#64796f; line-height:1.35; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }
        .vmenu-service-arrow { flex:0 0 auto; color:#cbd5cd; font-size:0.8rem; transition:transform .18s ease, color .18s ease; }
        .vmenu-service-card:hover .vmenu-service-arrow { color:var(--svc-color,#10b981); transform:translateX(3px); }
        @media (max-width:640px){ .vmenu-services-grid { grid-template-columns:1fr; max-height:260px; } }

        .ad-title-link { text-decoration: none; display: block; }
        .ad-title {
            display: block;
            text-align: center;
            padding: 6px 10px;
            font-size: 13px;
            font-weight: 700;
            color: #0f1f3a;
            background: rgba(255,255,255,0.9);
            border-bottom: 1px solid #dde7f6;
        }
        .ad-title-link:hover .ad-title { color: #4f46e5; }
    </style>

    {{-- System-Specific Scripts --}}

    <script>
        (function () {
            window.openDedicatedVideo = function (videoId, title) {
                if (window.VideoModalInstance) {
                    window.VideoModalInstance.open({ id: videoId, title: title, category: 'VIDÉO' });
                }
            };

            window.openDedicatedImage = function (src, title) {
                let lb = document.getElementById('megaImageLightbox');
                if (!lb) {
                    lb = document.createElement('div'); lb.id = 'megaImageLightbox';
                    lb.style = "display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.95);z-index:9999999;flex-direction:column;justify-content:center;align-items:center;";
                    lb.innerHTML = `<button onclick="this.parentElement.style.display='none'" style="position:fixed;top:20px;right:20px;color:white;font-size:40px;background:none;border:none;">&times;</button><img id="lb-img" style="max-width:90%;max-height:85%;object-fit:contain;border:5px solid white;border-radius:10px;"><h3 id="lb-title" style="color:white;margin-top:20px;"></h3>`;
                    document.body.appendChild(lb);
                }
                document.getElementById('lb-img').src = src;
                document.getElementById('lb-title').textContent = title;
                lb.style.display = 'flex';
            };

            document.addEventListener('DOMContentLoaded', function () {
                const viewport = document.getElementById('exclusiveMediaViewport');
                if (!viewport) return;
                const slides = viewport.querySelectorAll('.carousel-item-simple');
                let current = 0;
                function update(n) { slides.forEach(s => s.classList.remove('active')); current = (n + slides.length) % slides.length; slides[current].classList.add('active'); }
                document.getElementById('mediaPrev').onclick = (e) => { e.stopPropagation(); update(current - 1); };
                document.getElementById('mediaNext').onclick = (e) => { e.stopPropagation(); update(current + 1); };
            });
        })();
    </script>
</div>

@php
    $__componentHtml = ob_get_clean();
    echo \App\Support\HomeV2HtmlTranslator::translate($__componentHtml, app()->getLocale());
@endphp
