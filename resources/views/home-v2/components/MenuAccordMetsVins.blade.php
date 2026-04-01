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
                <div class="menu-accord-resto">RESTO GRFFFITI</div>
            </div>
        </div>

        {{-- Grille principale --}}
        <div class="menu-accord-grid">
            {{-- Grande image restaurant gauche --}}
            <div class="menu-accord-item menu-accord-restaurant-large">
                <img src="{{ asset('images/9093d02c-620a-4939-a877-2f9bbc03f2ca-1280x854.jpg') }}" alt="Restaurant Interior" class="menu-accord-image">
            </div>

            {{-- Colonne droite avec 4 images en grille 2x2 --}}
            <div class="menu-accord-column-right">
                <div class="menu-accord-item menu-accord-drink">
                    <img src="{{ asset('images/half-veggie-scaled.jpg') }}" alt="Beverage" class="menu-accord-image">
                </div>
                <div class="menu-accord-item menu-accord-cooking">
                    <img src="{{ asset('images/poutine classique.jpg') }}" alt="Cooking" class="menu-accord-image">
                </div>
                <div class="menu-accord-item menu-accord-chef">
                    <img src="{{ asset('images/Beef-Burgers-067.jpg') }}" alt="Chef" class="menu-accord-image">
                </div>
                <div class="menu-accord-item menu-accord-dessert">
                    <img src="{{ asset('images/chez-jim-pizza.png') }}" alt="Dessert" class="menu-accord-image">
                </div>
            </div>
        </div>

        {{-- Section Plats et Boissons --}}
        <div class="menu-accord-details">
            {{-- Plat : Schnitzel --}}
            <div class="menu-accord-dish">
                <div class="menu-accord-dish-image">
                    <img src="{{ asset('images/Beef-Burgers-067.jpg') }}" alt="Schnitzel" class="menu-accord-image">
                </div>
                <div class="menu-accord-dish-content">
                    <h3 class="menu-accord-dish-name">SCHNITZEL</h3>
                    <p class="menu-accord-dish-description">
                        Ein dünnes, geklopftes Fleischkotelett, typischerweise Kalb, Schwein oder Huhn, das paniert und in der Pfanne gebraten wird, bis es goldbraun und knusprig ist
                    </p>
                    <p class="menu-accord-dish-description-en">
                        Thin, pounded cutlet of meat, typically veal, pork, or chicken, that is breaded and pan-fried until golden and crispy
                    </p>
                    <div class="menu-accord-price">£11.00</div>
                </div>
            </div>

            {{-- Boisson : Riesling Grey Slate --}}
            <div class="menu-accord-beverage">
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
                    <div class="menu-accord-price">£44.00</div>
                </div>
                <div class="menu-accord-beverage-image">
                    <img src="{{ asset('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTPxj8qeWmZqaiio3JOzD4UrDIyuwDDETRwjw&s') }}" alt="Riesling Grey Slate" class="menu-accord-wine-bottle">
                </div>
            </div>
        </div>

        {{-- Section bouteilles de vin en bas --}}
        <div class="menu-accord-wine-bottles" style="background-image: url('{{ asset('images/trek-the-sahara-desert-adobe-stock-3761.jpg') }}');">
            <div class="menu-accord-wine-bottles-overlay"></div>
            <div class="menu-accord-wine-bottles-content">
                @for($i = 1; $i <= 8; $i++)
                    <div class="menu-accord-wine-bottle-item">
                        <img src="{{ asset('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSAtkD8ozUJB_KDmf0f9zJ-lK0m08QVc02dcTAl6mSyfpx65h54O1xsXpLlTnxE0qr4Cp0fyhnTgM6dYsaE9U1kuKiZuYXQ4TGLx40ftv0&s=10') }}" alt="Wine Bottle {{ $i }}" class="menu-accord-bottle-image">
                    </div>
                @endfor
            </div>
        </div>
    </div>
</section>
