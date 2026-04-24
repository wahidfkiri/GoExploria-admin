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

    <div class="mega-menu-main-content">
        {{-- 5 Columns Grid with FontAwesome Icons ONLY --}}
        <div class="mega-menu-columns-container">
            {{-- Column 1 --}}
            <div class="mega-menu-column">
                <a href="{{url('/landing/accessibilite')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-wheelchair"></i></div>
                    <span class="mega-menu-label">Accessibilité</span>
                </a>
                <a href="{{url('/landing/ambulance')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-ambulance"></i></div>
                    <span class="mega-menu-label">Ambulance 911</span>
                </a>
                <a href="{{url('/landing/defibrillateur')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-heartbeat"></i></div>
                    <span class="mega-menu-label">Défibrillateur</span>
                </a>
                <a href="{{url('/landing/indigo')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-parking"></i></div>
                    <span class="mega-menu-label">Indigo</span>
                </a>
            </div>

            {{-- Column 2 --}}
            <div class="mega-menu-column">
                <a href="{{url('/landing/fabrique-quebec')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-industry"></i></div>
                    <span class="mega-menu-label">Fabriqué Québec</span>
                </a>
                <a href="{{url('/landing/info-tourisme')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-info-circle"></i></div>
                    <span class="mega-menu-label">Info Tourisme</span>
                </a>
                <a href="{{url('/landing/transport')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-bus"></i></div>
                    <span class="mega-menu-label">Transport</span>
                </a>
                <a href="{{url('/landing/experiences')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-star"></i></div>
                    <span class="mega-menu-label">Expériences</span>
                </a>
            </div>

            {{-- Column 3 --}}
            <div class="mega-menu-column">
                <a href="{{url('/landing/garage')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-tools"></i></div>
                    <span class="mega-menu-label">Garage</span>
                </a>
                <a href="{{url('/landing/indice-uv')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-sun"></i></div>
                    <span class="mega-menu-label">Indice UV</span>
                </a>
                <a href="{{url('/landing/indice')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-list-ol"></i></div>
                    <span class="mega-menu-label">Indices</span>
                </a>
                <a href="{{url('/landing/parcs')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-tree"></i></div>
                    <span class="mega-menu-label">Parcs Canada</span>
                </a>
            </div>

            {{-- Column 4 --}}
            <div class="mega-menu-column">
                <a href="{{url('/landing/chasse')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-crosshairs"></i></div>
                    <span class="mega-menu-label">Chasse</span>
                </a>
                <a href="{{url('/landing/croisieres')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-ship"></i></div>
                    <span class="mega-menu-label">Croisières</span>
                </a>
                <a href="{{url('/landing/billets-avion')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-plane"></i></div>
                    <span class="mega-menu-label">Billets Avion</span>
                </a>
                <a href="{{url('/landing/evenements')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-calendar-alt"></i></div>
                    <span class="mega-menu-label">Événements</span>
                </a>
            </div>

            {{-- Column 5 --}}
            <div class="mega-menu-column">
                <a href="{{url('/landing/culture')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-theater-masks"></i></div>
                    <span class="mega-menu-label">Culture</span>
                </a>
                <a href="{{url('/landing/ferry')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-anchor"></i></div>
                    <span class="mega-menu-label">Ferry</span>
                </a>
                <a href="{{url('/landing/nouvelles')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-rss"></i></div>
                    <span class="mega-menu-label">Nouvelles</span>
                </a>
                <a href="{{url('/landing/canada-quebec')}}" class="mega-menu-item">
                    <div class="mega-menu-icon-wrapper"><i class="fas fa-map"></i></div>
                    <span class="mega-menu-label">Canada Québec</span>
                </a>
            </div>
        </div>

        {{-- Compact Media Slider --}}
        <div class="mega-menu-carousel-clean">
            <div class="carousel-media-viewport" id="exclusiveMediaViewport">
                {{-- Slide 1: Video --}}
                <div class="carousel-item-simple active">
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