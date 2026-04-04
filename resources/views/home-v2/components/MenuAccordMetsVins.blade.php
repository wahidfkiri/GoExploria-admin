{{-- Accords Mets & Vins Section V4 - High Performance Business Layout --}}
<section class="mets-vins-v4-section" id="menu-accord-section">
    <div class="mets-vins-v4-container">
        
        <div class="mets-vins-v4-main-content">
            
            <!-- --- Colonne GAUCHE : Text + Video Slider + Image Slider --- -->
            <div class="mets-vins-v4-left-col">
                <div class="mets-vins-v4-header-text">
                    <span class="mets-vins-v4-badge">Expérience Sensorielle</span>
                    <h1 class="mets-vins-v4-title">Accord Parfait <span>Mets & Vins</span></h1>
                    <p class="mets-vins-v4-desc">Une symphonie de saveurs où chaque plat raconte une histoire, sublimée par une sélection viticole d'exception. L'expertise GoExploria au service de vos papilles.</p>
                </div>

                <!-- Slider Vidéo (YouTube) -->
                <div class="mets-vins-v4-slider-box" id="mvVideoSliderV4">
                    @php 
                        $ytVideos = [
                            'https://www.youtube.com/embed/xPPLbEFbCAo?autoplay=1&mute=1&controls=0&loop=1&playlist=xPPLbEFbCAo',
                        ]; 
                    @endphp
                    @foreach($ytVideos as $i => $url)
                        <iframe src="{{ $url }}" 
                                frameborder="0" 
                                allow="autoplay; encrypted-media" 
                                style="width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; opacity: {{ $i === 0 ? '1' : '0' }}; z-index: {{ $i === 0 ? '2' : '1' }}; pointer-events: none;" 
                                class="mv-v4-video-item"></iframe>
                    @endforeach
                    <div style="position: absolute; bottom: 15px; left: 20px; z-index: 10; font-size: 11px; font-weight: 800; text-transform: uppercase; color: #d4af37; background: rgba(0,0,0,0.7); padding: 4px 12px; border-radius: 4px; backdrop-filter: blur(4px);">Inspiration Gastronomique</div>
                </div>

                <!-- Slider Images (DYNAMIQUE) -->
                <div class="mets-vins-v4-slider-box" id="mvImageSliderV4">
                    @php 
                        $sliderImgs = [
                            'magret-canard.jpg',
                            'accord-m-v.jpg',
                            'cave.jpg',
                            'restaurant-fruits-de-mer-accord-vin.jpg',
                            'Conseils-pour-debuter-cave-a-vin.jpg',
                            'cave-de-degustation-des-vins.png'
                        ]; 
                    @endphp
                    @foreach($sliderImgs as $i => $img)
                        <img src="{{ asset('home2/aventure-accords-met-vin/' . $img) }}" 
                             style="opacity: {{ $i === 0 ? '1' : '0' }}; z-index: {{ $i === 0 ? '2' : '1' }}; position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transition: opacity 1s ease-in-out;" 
                             class="mv-v4-img-item" alt="Galerie {{ $i }}">
                    @endforeach
                    <div style="position: absolute; bottom: 15px; left: 20px; z-index: 10; font-size: 11px; font-weight: 800; text-transform: uppercase; color: #ffffff; background: rgba(0,0,0,0.7); padding: 4px 12px; border-radius: 4px; backdrop-filter: blur(4px);">Galerie Gastronomique</div>
                </div>
            </div>

            <!-- --- Colonne DROITE : 6 Cartes de Produits (2 par ligne) --- -->
            <div class="mets-vins-v4-right-grid">
                @php
                    $v4Products = [
                        ['title' => 'SCHNITZEL PREMIUM', 'price' => '£11.00', 'img' => 'magret-canard.jpg', 'desc' => 'Finesse et croustillant. Une pièce de viande sélectionnée.'],
                        ['title' => 'RIESLING GREY SLATE', 'price' => '£44.00', 'img' => 'accord_mets_vin.jpg', 'desc' => 'L\'élégance du schiste gris. Un vin blanc sec et noble.'],
                        ['title' => 'MAGRET DE CANARD', 'price' => '£28.00', 'img' => 'magret-canard.jpg', 'desc' => 'Cuisiné rosé, servi avec son jus réduit aux baies.'],
                        ['title' => 'CRUS D\'EXCEPTION', 'price' => 'Sur Devis', 'img' => 'cave.jpg', 'desc' => 'Accédez à notre sélection de vins de garde rares.'],
                        ['title' => 'PLATEAU DÉGUSTATION', 'price' => '£35.00', 'img' => 'accord-m-v.jpg', 'desc' => 'Une sélection de mets variés pour un voyage gustatif.'],
                        ['title' => 'CONSEILS CAVE', 'price' => 'Gratuit', 'img' => 'Conseils-pour-debuter-cave-a-vin.jpg', 'desc' => 'Laissez-vous guider par nos experts sommeliers.']
                    ];
                @endphp
                @foreach($v4Products as $p)
                <article class="mets-vins-v4-card">
                    <div class="card-thumb">
                        <img src="{{ asset('home2/aventure-accords-met-vin/' . $p['img']) }}" alt="{{ $p['title'] }}">
                    </div>
                    <h3 class="card-title">{{ $p['title'] }}</h3>
                    <p class="card-info">{{ $p['desc'] }}</p>
                    <div class="card-price">{{ $p['price'] }}</div>
                </article>
                @endforeach
            </div>
        </div>

        <!-- --- FOOTER : Product Carousel Slider --- -->
        <div class="mets-vins-v4-footer">
            <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 30px; text-align: center;">Découvrez nos Tables Partenaires</h3>
            <div class="footer-carousel-track" id="mvFooterCarouselV4">
                @php
                    $v4FooterProds = [
                        ['name' => 'Le Saint-Amour', 'price' => 'Gastronomique', 'img' => 'restaurant-fruits-de-mer-accord-vin.jpg'],
                        ['name' => 'Joe Beef', 'price' => 'Bistro Convivial', 'img' => 'accord-m-v.jpg'],
                        ['name' => 'Toqué!', 'price' => 'Haute Cuisine', 'img' => 'cave-de-degustation-des-vins.png'],
                        ['name' => 'Aux Anciens Canadiens', 'price' => 'Traditionnel', 'img' => 'accord_mets_vin.jpg'],
                        ['name' => 'Le Mousse', 'price' => 'Cuisine Moderne', 'img' => 'accord-m-v.jpg'],
                        ['name' => 'Resto Graffiti', 'price' => 'Signature', 'img' => 'magret-canard.jpg']
                    ];
                @endphp
                @foreach($v4FooterProds as $f)
                <div class="footer-card">
                    <img src="{{ asset('home2/aventure-accords-met-vin/' . $f['img']) }}" alt="{{ $f['name'] }}">
                    <div>
                        <h4>{{ $f['name'] }}</h4>
                        <p>{{ $f['price'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

<script>
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            // Slider Automatique Vidéo (YouTube iframes)
            const videoIframes = document.querySelectorAll('.mv-v4-video-item');
            let vIdx = 0;
            if(videoIframes.length > 0) {
                setInterval(() => {
                    videoIframes[vIdx].style.opacity = '0';
                    videoIframes[vIdx].style.zIndex = '1';
                    vIdx = (vIdx + 1) % videoIframes.length;
                    videoIframes[vIdx].style.opacity = '1';
                    videoIframes[vIdx].style.zIndex = '2';
                }, 6000); // 6 secondes par vidéo YouTube
            }

            // Slider Automatique Images (FIXED LOGIC)
            const imgItems = document.querySelectorAll('.mv-v4-img-item');
            let iIdx = 0;
            if(imgItems.length > 1) { // On ne lance l'intervalle que s'il y a plus d'une image
                setInterval(() => {
                    imgItems[iIdx].style.opacity = '0';
                    imgItems[iIdx].style.zIndex = '1';
                    iIdx = (iIdx + 1) % imgItems.length;
                    imgItems[iIdx].style.opacity = '1';
                    imgItems[iIdx].style.zIndex = '2';
                }, 4000); // 4 secondes par image
            }

            // Animation Smooth pour le Carousel Footer
            const track = document.getElementById('mvFooterCarouselV4');
            if(track) {
                let isDown = false;
                let startX;
                let scrollLeft;

                track.addEventListener('mousedown', (e) => {
                    isDown = true;
                    startX = e.pageX - track.offsetLeft;
                    scrollLeft = track.scrollLeft;
                });
                track.addEventListener('mouseleave', () => { isDown = false; });
                track.addEventListener('mouseup', () => { isDown = false; });
                track.addEventListener('mousemove', (e) => {
                    if(!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - track.offsetLeft;
                    const walk = (x - startX) * 2;
                    track.scrollLeft = scrollLeft - walk;
                });
            }
        });
    })();
</script>
