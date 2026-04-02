{{-- Menu Accord Mets Vins Component --}}
<section class="menu-accord-section">
    <div class="menu-accord-container">
        {{-- Header avec image de fond --}}
        <div class="menu-accord-header" style="background-image: url('{{ asset('images/trek-the-sahara-desert-adobe-stock-3761.jpg') }}');">
            <div class="menu-accord-header-overlay"></div>
            <div class="menu-accord-header-content">
                <h2 class="menu-accord-subtitle">ACCORD METS VINS</h2>
                <h1 class="menu-accord-title">
                    <span class="menu-accord-title-delicious">Delicious</span>
                    <span class="menu-accord-title-menu">Menu</span>
                </h1>
                <div class="menu-accord-badge">
                    <span class="menu-accord-badge-text">TASTY & FRESH</span>
                </div>
                <div class="menu-accord-resto">RESTO GRIFFITI</div>
            </div>
        </div>

        {{-- Grille principale : 2 grandes images 50/50 --}}
        <div class="menu-accord-grid">
            <div class="menu-accord-item" style="position: relative; overflow: hidden; height: 100%; min-height: 400px;">
                <div id="videoCarouselCustom" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%;">
                    @php
                        $videos = [
                            'hero-video-1.mp4.mp4',
                            'hero-video-2.mp4.mp4',
                            'hero-video-3.mp4.mp4',
                            'hero-video-4.mp4',
                            'hero-video-5.mp4'
                        ];
                    @endphp
                    @foreach($videos as $index => $vid)
                        <video class="video-slide-item" src="{{ asset('home2/videos/' . $vid) }}" 
                               style="position: absolute; top:0; left:0; width:100%; height:100%; object-fit: cover; opacity: {{ $index === 0 ? '1' : '0' }}; transition: opacity 0.8s ease-in-out; pointer-events: none;"
                               muted playsinline {{ $index === 0 ? 'autoplay' : '' }}></video>
                    @endforeach
                    <div class="menu-accord-video-overlay" style="z-index: 10; pointer-events: none;">video</div>
                    
                    <button id="video-prev-btn" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; padding: 10px 15px; cursor: pointer; z-index: 20; border-radius: 4px; font-size: 18px;">&#10094;</button>
                    <button id="video-next-btn" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; padding: 10px 15px; cursor: pointer; z-index: 20; border-radius: 4px; font-size: 18px;">&#10095;</button>
                </div>

                <!-- Script d'initialisation pour le slider Vidéo -->
                <script>
                    (function() {
                        const carouselContainer = document.getElementById('videoCarouselCustom');
                        if (carouselContainer) {
                            const videos = carouselContainer.querySelectorAll('.video-slide-item');
                            const prev = document.getElementById('video-prev-btn');
                            const next = document.getElementById('video-next-btn');
                            let currentIndex = 0;

                            function showSlide(index) {
                                if (!videos || videos.length === 0) return;
                                
                                // Éteindre la vidéo en cours
                                videos[currentIndex].style.opacity = '0';
                                videos[currentIndex].pause();
                                videos[currentIndex].currentTime = 0;
                                
                                currentIndex = (index + videos.length) % videos.length;
                                
                                // Allumer la nouvelle vidéo
                                videos[currentIndex].style.opacity = '1';
                                let playPromise = videos[currentIndex].play();
                                if (playPromise !== undefined) {
                                    playPromise.catch(_ => {});
                                }
                            }

                            function nextSlide() { showSlide(currentIndex + 1); }
                            function prevSlide() { showSlide(currentIndex - 1); }

                            if (next) next.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); nextSlide(); });
                            if (prev) prev.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); prevSlide(); });

                            // Passage automatique à la suivante dès que la vidéo se termine (beaucoup plus naturel qu'un timer fixe)
                            videos.forEach(video => {
                                video.addEventListener('ended', nextSlide);
                            });
                        }
                    })();
                </script>
            </div>
            <div class="menu-accord-item">
                <img src="{{ asset('images/half-veggie-scaled.jpg') }}" alt="Meat and Wine" class="menu-accord-image">
            </div>
        </div>

        {{-- Section 4 blocs : Image | Schnitzel | Getränke | Image --}}
        <div class="menu-accord-details">
            <div class="menu-accord-dish" style="grid-template-columns: 1fr 1fr;">
                <div class="menu-accord-dish-image" style="position: relative; overflow: hidden; height: 100%; min-height: 250px;">
                    <div id="burgerCarouselCustom" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;">
                        @php
                            $carouselImages = [
                                'Capture d’écran 2026-03-31 175818.png',
                                'Conseils-pour-debuter-cave-a-vin.jpg',
                                'accord-m-v.jpg',
                                'accord_mets_vin.jpg',
                                'aoc-cahors-rouge-domaine-de-lantenet-sans-sulfites-2016-biologique.jpg',
                                'cave-de-degustation-des-vins.png',
                                'cave.jpg',
                                'clos-la-coutale-aoc-cahors-2021.jpg',
                                'magret-canard.jpg',
                                'restaurant-fruits-de-mer-accord-vin.jpg'
                            ];
                        @endphp
                        @foreach($carouselImages as $index => $img)
                            <div class="custom-slide-item" style="position: absolute; top:0; left:0; width:100%; height:100%; opacity: {{ $index === 0 ? '1' : '0' }}; transition: opacity 0.8s ease-in-out; pointer-events: {{ $index === 0 ? 'auto' : 'none' }};">
                                <img src="{{ asset('home2/aventure-accords-met-vin/' . $img) }}" style="object-fit: cover; width: 100%; height: 100%;" alt="Carousel Image {{ $index }}">
                            </div>
                        @endforeach
                        
                        <button id="custom-prev-btn" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; padding: 10px 15px; cursor: pointer; z-index: 20; border-radius: 4px; font-size: 18px;">&#10094;</button>
                        <button id="custom-next-btn" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; padding: 10px 15px; cursor: pointer; z-index: 20; border-radius: 4px; font-size: 18px;">&#10095;</button>
                    </div>
                </div>

                <!-- Initialisation script for Custom Slider -->
                <script>
                    (function() {
                        const carouselContainer = document.getElementById('burgerCarouselCustom');
                        if (carouselContainer) {
                            const items = carouselContainer.querySelectorAll('.custom-slide-item');
                            const prev = document.getElementById('custom-prev-btn');
                            const next = document.getElementById('custom-next-btn');
                            let currentIndex = 0;
                            let intervalId;

                            function showSlide(index) {
                                if (!items || items.length === 0) return;
                                items[currentIndex].style.opacity = '0';
                                items[currentIndex].style.pointerEvents = 'none';
                                
                                currentIndex = (index + items.length) % items.length;
                                
                                items[currentIndex].style.opacity = '1';
                                items[currentIndex].style.pointerEvents = 'auto';
                            }

                            function nextSlide() { showSlide(currentIndex + 1); }
                            function prevSlide() { showSlide(currentIndex - 1); }

                            if (next) next.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); nextSlide(); clearInterval(intervalId); startAuto(); });
                            if (prev) prev.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); prevSlide(); clearInterval(intervalId); startAuto(); });

                            function startAuto() {
                                intervalId = setInterval(nextSlide, 3500);
                            }
                            startAuto();
                        }
                    })();
                </script>

                <div class="menu-accord-dish-content">
                    <h3 class="menu-accord-dish-name">SCHNITZEL</h3>
                    <p class="menu-accord-dish-description">
                        Ein dünnes, geklopftes Fleischkotelett, typischerweise Kalb, Schwein oder Huhn, das paniert und in der Pfanne gebraten wird, bis es goldbraun und knusprig ist
                    </p>
                    <p class="menu-accord-dish-description-en">
                        Thin, pounded cutlet of meat, typically veal, pork, or chicken, that is breaded and pan-fried until golden and crispy
                    </p>
                    <div><span class="menu-accord-price">£11.00</span></div>
                </div>
            </div>

            <div class="menu-accord-beverage" style="grid-template-columns: 1fr 1fr;">
                <div class="menu-accord-beverage-content">
                    <h3 class="menu-accord-beverage-category">
                        <span class="menu-accord-beverage-icon">🍷</span>
                        GETRÄNKE
                        <span class="menu-accord-beverage-subtitle">(BEVERAGE)</span>
                    </h3>
                    <div class="menu-accord-beverage-divider"></div>
                    <h4 class="menu-accord-beverage-name">RIESLING GREY SLATE</h4>
                    <p class="menu-accord-beverage-description">
                        Ein köstlicher, vollmundiger Wein mit leuchtenden und klaren Früchten
                    </p>
                    <p class="menu-accord-beverage-description-en">
                        It is seasoned with a blend of spices, including herbs like marjoram and spices like peppercorn vinegar
                    </p>
                    <div><span class="menu-accord-price">£44.00</span></div>
                </div>
                <div class="menu-accord-beverage-image" style="position: relative; overflow: hidden; height: 100%; min-height: 250px;">
                    <div id="pizzaCarouselCustom" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;">
                        {{-- On réutilise la même variable $carouselImages initialisée plus haut --}}
                        @foreach($carouselImages as $index => $img)
                            <div class="pizza-slide-item" style="position: absolute; top:0; left:0; width:100%; height:100%; opacity: {{ $index === 0 ? '1' : '0' }}; transition: opacity 0.8s ease-in-out; pointer-events: {{ $index === 0 ? 'auto' : 'none' }};">
                                <img src="{{ asset('home2/aventure-accords-met-vin/' . $img) }}" style="object-fit: cover; width: 100%; height: 100%;" alt="Carousel Image {{ $index }}">
                            </div>
                        @endforeach
                        
                        <button id="pizza-prev-btn" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; padding: 10px 15px; cursor: pointer; z-index: 20; border-radius: 4px; font-size: 18px;">&#10094;</button>
                        <button id="pizza-next-btn" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; padding: 10px 15px; cursor: pointer; z-index: 20; border-radius: 4px; font-size: 18px;">&#10095;</button>
                    </div>
                </div>

                <!-- Script d'initialisation pour le deuxième slider -->
                <script>
                    (function() {
                        const carouselContainer = document.getElementById('pizzaCarouselCustom');
                        if (carouselContainer) {
                            const items = carouselContainer.querySelectorAll('.pizza-slide-item');
                            const prev = document.getElementById('pizza-prev-btn');
                            const next = document.getElementById('pizza-next-btn');
                            let currentIndex = 0;
                            let intervalId;

                            function showSlide(index) {
                                if (!items || items.length === 0) return;
                                items[currentIndex].style.opacity = '0';
                                items[currentIndex].style.pointerEvents = 'none';
                                
                                currentIndex = (index + items.length) % items.length;
                                
                                items[currentIndex].style.opacity = '1';
                                items[currentIndex].style.pointerEvents = 'auto';
                            }

                            function nextSlide() { showSlide(currentIndex + 1); }
                            function prevSlide() { showSlide(currentIndex - 1); }

                            if (next) next.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); nextSlide(); clearInterval(intervalId); startAuto(); });
                            if (prev) prev.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); prevSlide(); clearInterval(intervalId); startAuto(); });

                            function startAuto() {
                                intervalId = setInterval(nextSlide, 3500);
                            }
                            // Retardateur de 1 seconde pour désynchroniser les animations des deux sliders
                            setTimeout(startAuto, 1000);
                        }
                    })();
                </script>
            </div>
        </div>

        {{-- Section Restaurants Carousel (5 items visibles) --}}
        <div class="menu-accord-resto-cards-container">
            @php
                $restaurants = [
                    ['name' => 'Le Saint-Amour', 'type' => 'GASTRONOMIQUE', 'desc' => 'Cuisine française raffinée dans un cadre romantique avec jardin intérieur.', 'city' => 'Québec', 'stars' => 5],
                    ['name' => 'Joe Beef', 'type' => 'BISTRO', 'desc' => 'Bistro montréalais emblématique, cuisine du marché et ambiance conviviale.', 'city' => 'Montréal', 'stars' => 4],
                    ['name' => 'Toqué!', 'type' => 'FINE DINING', 'desc' => 'Restaurant gastronomique de renommée internationale, produits du Québec.', 'city' => 'Montréal', 'stars' => 5],
                    ['name' => 'Aux Anciens Canadiens', 'type' => 'TRADITIONNEL', 'desc' => 'Cuisine traditionnelle québécoise dans une maison historique de 1675.', 'city' => 'Québec', 'stars' => 4],
                    ['name' => 'Le Mousse', 'type' => 'MODERNE', 'desc' => 'Cuisine créative et innovante, menu dégustation avec accords mets et vins.', 'city' => 'Montréal', 'stars' => 5],
                ];
            @endphp
            @foreach($restaurants as $resto)
            <div class="menu-accord-resto-card">
                <div class="menu-accord-resto-card-image-wrap">
                    <img src="{{ asset('images/9093d02c-620a-4939-a877-2f9bbc03f2ca-1280x854.jpg') }}" alt="Resto" class="menu-accord-resto-card-img">
                    <span class="menu-accord-resto-card-badge">{{ $resto['type'] }}</span>
                </div>
                <div class="menu-accord-resto-card-body">
                    <h4 class="menu-accord-resto-card-title">{{ $resto['name'] }}</h4>
                    <p class="menu-accord-resto-card-desc">{{ $resto['desc'] }}</p>
                    <div class="menu-accord-resto-card-footer">
                        <span class="menu-accord-resto-card-city">📍 {{ $resto['city'] }}</span>
                        <span class="menu-accord-resto-card-stars">
                            @for($i=0; $i<$resto['stars']; $i++) ⭐ @endfor
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Section Cellar & Salmon (50/50) --}}
        <div class="menu-accord-cellar-salmon-row">
            <div class="menu-accord-cellar-item" style="background-image: url('{{ asset('images/trek-the-sahara-desert-adobe-stock-3761.jpg') }}');">
                <!-- Using placeholder for cellar, you can replace with real image -->
                <img src="{{ asset('images/trek-the-sahara-desert-adobe-stock-3761.jpg') }}" alt="Wine Cellar" class="menu-accord-cellar-img" style="filter: brightness(0.6);">
            </div>
            <div class="menu-accord-salmon-item">
                <img src="{{ asset('images/half-veggie-scaled.jpg') }}" alt="Salmon Dish" class="menu-accord-salmon-bg">
                <div class="menu-accord-salmon-overlay-content">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTPxj8qeWmZqaiio3JOzD4UrDIyuwDDETRwjw&s" alt="Wine Bottle" class="menu-accord-salmon-wine">
                    <div class="menu-accord-bistro-logo-stamp">
                        <div>BISTRO</div>
                        <div class="menu-accord-bistro-st-malo">ST-MALO</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 4 Dark Cards (Schnitzel/Getranke/Schnitzel/Getranke) --}}
        <div class="menu-accord-dark-cards-row">
            @for($j=0; $j<2; $j++)
            <div class="menu-accord-dish-content" style="border-right: 1px solid #333; background: #1a1a1a;">
                <h3 class="menu-accord-dish-name">SCHNITZEL</h3>
                <p class="menu-accord-dish-description">
                    Ein dünnes, geklopftes Fleischkotelett, typischerweise Kalb, Schwein oder Huhn, das paniert...
                </p>
                <p class="menu-accord-dish-description-en">
                    Thin, pounded cutlet of meat, typically veal, pork, or chicken, that is breaded...
                </p>
                <div><span class="menu-accord-price">£11.00</span></div>
            </div>
            <div class="menu-accord-beverage-content" style="border-right: 1px solid #333; background: #1a1a1a;">
                <h3 class="menu-accord-beverage-category">
                    <span class="menu-accord-beverage-icon">🍷</span> GETRÄNKE
                </h3>
                <div class="menu-accord-beverage-divider"></div>
                <h4 class="menu-accord-beverage-name">RIESLING GREY SLATE</h4>
                <p class="menu-accord-beverage-description">
                    Ein köstlicher, vollmundiger Wein mit leuchtenden und klaren Früchten
                </p>
                <div><span class="menu-accord-price">£44.00</span></div>
            </div>
            @endfor
        </div>

    </div>
</section>
