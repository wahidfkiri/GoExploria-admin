@extends('theme::layout')

@section('title', get_site_name() . ' - Fraîcheur et diversité à Saint-Ambroise')
@section('description', 'Épicerie multi-services à Saint-Ambroise. Boucherie, charcuterie, traiteur, méchoui, chasse et pêche. Service personnalisé depuis plus de 20 ans.')

@section('content')
<!-- SECTION VALEURS / CARDS -->
<section class="values-section">
    <div class="container">
        <div class="cards-grid">
            <div class="card-icon">
                <i class="fas fa-apple-alt"></i>
                <h3>Fruits & légumes</h3>
                <p>Grand choix de produits frais, locaux et de saison.</p>
            </div>
            <div class="card-icon">
                <i class="fas fa-drumstick-bite"></i>
                <h3>Boucherie & charcuterie</h3>
                <p>Creton, pepperoni, saucisses BBQ, viandes de qualité.</p>
            </div>
            <div class="card-icon">
                <i class="fas fa-fish"></i>
                <h3>Chasse & pêche</h3>
                <p>Équipements, permis, conseils d'experts avec Maryeve Pepin.</p>
            </div>
        </div>
    </div>
</section>

<!-- DÉPARTEMENTS -->
<section id="departements" class="departments-section">
    <div class="container">
        <h2 class="section-title">Nos départements</h2>
        <p class="section-sub">Une épicerie complète pour tous vos besoins</p>
        <div class="departments-grid">
            <div class="dept-item"><i class="fas fa-carrot"></i> Fruits & légumes</div>
            <div class="dept-item"><i class="fas fa-cheese"></i> Fromagerie</div>
            <div class="dept-item"><i class="fas fa-wine-bottle"></i> Vins & spiritueux</div>
            <div class="dept-item"><i class="fas fa-utensils"></i> Mets préparés</div>
            <div class="dept-item"><i class="fas fa-gun"></i> Chasse & pêche</div>
            <div class="dept-item"><i class="fas fa-sandwich"></i> Sandwiches & collations</div>
            <div class="dept-item"><i class="fas fa-coffee"></i> Coin pause-café</div>
            <div class="dept-item"><i class="fas fa-ticket-alt"></i> Loto-Québec</div>
        </div>
    </div>
</section>

<!-- BOUCHERIE + CHARCUTERIE -->
<section id="boucherie" class="butchery-section">
    <div class="container split-section">
        <div class="split-image">
            <img src="https://images.pexels.com/photos/6754143/pexels-photo-6754143.jpeg?auto=compress&cs=tinysrgb&w=800" alt="Boucherie Marché Alqui">
        </div>
        <div>
            <h2 class="section-title" style="text-align: left;">Boucherie & Charcuterie artisanale</h2>
            <p>Depuis 20 ans, nous fabriquons nos <strong>creton, pepperoni, 6 à 8 variétés de saucisses pour le BBQ</strong>. Mets cuisinés frais, diversifiés et prêts à emporter à l'heure du lunch.</p>
            <ul class="services-list">
                <li><i class="fas fa-check-circle"></i> Charcuterie maison</li>
                <li><i class="fas fa-check-circle"></i> Viandes fraîches et maturées</li>
                <li><i class="fas fa-check-circle"></i> Service de débitage d'orignaux</li>
                <li><i class="fas fa-check-circle"></i> Affûtage de couteaux et lames de patins</li>
            </ul>
        </div>
    </div>
</section>

<!-- TRAITEUR & MÉCHOUI -->
<section id="traiteur" class="catering-section">
    <div class="container split-section">
        <div>
            <h2 class="section-title" style="text-align: left;">Service de traiteur & Méchoui</h2>
            <p>Nous offrons un service de traiteur ainsi qu'un service de buffet chaud ou froid pour le secteur du Saguenay Lac-St-Jean.</p>
            <p><strong>📍 Location de poêle à méchoui disponible</strong> pour vos événements et réunions familiales.</p>
            <a href="#contact" class="btn-primary" style="display: inline-block; margin-top: 20px;">Réserver un service</a>
        </div>
        <div class="split-image">
            <img src="https://images.pexels.com/photos/2881048/pexels-photo-2881048.jpeg?auto=compress&cs=tinysrgb&w=800" alt="Méchoui Marché Alqui">
        </div>
    </div>
</section>

<!-- CHASSE & PÊCHE + DÉPANNEUR -->
<section class="hunting-section">
    <div class="container split-section">
        <div class="split-image">
            <img src="https://images.pexels.com/photos/7661321/pexels-photo-7661321.jpeg?auto=compress&cs=tinysrgb&w=800" alt="Chasse et pêche">
        </div>
        <div>
            <h2 class="section-title" style="text-align: left;">Chasse, Pêche & Plein-air</h2>
            <p>Pour vos divertissements, vous trouverez chez nous l'équipement sportif de chasse, de pêche et de plein-air. <strong>Vente de permis de chasse et pêche</strong>.</p>
            <p>✨ <strong>Maryeve Pepin</strong>, experte en produits de chasse, est là pour vous conseiller.</p>
            <p>📍 Services additionnels : détaillant Loto-Québec, feux d'artifice, cartes d'appel.</p>
        </div>
    </div>
</section>

<!-- GALERIE PHOTOS (SWIPER) -->
<section id="galerie" class="gallery-section">
    <div class="container">
        <h2 class="section-title">Galerie</h2>
        <p class="section-sub">Découvrez notre épicerie, notre boucherie et nos services</p>
        <div class="swiper gallerySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="https://images.pexels.com/photos/264636/pexels-photo-264636.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Marché Alqui"></div>
                <div class="swiper-slide"><img src="https://images.pexels.com/photos/699953/pexels-photo-699953.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Boucherie"></div>
                <div class="swiper-slide"><img src="https://images.pexels.com/photos/6754143/pexels-photo-6754143.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Charcuterie"></div>
                <div class="swiper-slide"><img src="https://images.pexels.com/photos/2881048/pexels-photo-2881048.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Méchoui"></div>
                <div class="swiper-slide"><img src="https://images.pexels.com/photos/7661321/pexels-photo-7661321.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Chasse"></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<!-- AVIS CLIENTS -->
<section class="testimonials-section">
    <div class="container">
        <h2 class="section-title">Ce qu'ils disent de nous</h2>
        <div class="swiper testimonialSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide testimonial-card">
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p>“Excellent service, produits frais et variés. La boucherie est exceptionnelle !”</p>
                    <strong>- Jean B.</strong>
                </div>
                <div class="swiper-slide testimonial-card">
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p>“Le service de méchoui est top. Location de poêle très pratique.”</p>
                    <strong>- Marie-Claude L.</strong>
                </div>
                <div class="swiper-slide testimonial-card">
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p>“Maryeve est très compétente pour tout ce qui touche la chasse. Bravo !”</p>
                    <strong>- Richard T.</strong>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<!-- CONTACT -->
<section id="contact" class="contact-section">
    <div class="container">
        <div class="contact-info">
            <div class="contact-grid">
                <div>
                    <h3><i class="fas fa-store"></i> Marché Alqui</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Au cœur de Saint-Ambroise, Saguenay-Lac-St-Jean</p>
                    <p><i class="fas fa-phone-alt"></i> <strong>(418) 672-4792</strong></p>
                    <p><i class="fab fa-whatsapp"></i> WhatsApp : (418) 672-4792</p>
                    <p><i class="fas fa-envelope"></i> maestroalqui@gmail.com</p>
                    <p><i class="fas fa-clock"></i> Ouverture: tous les jours (consultez nos horaires)</p>
                    <a href="https://wa.me/14186724792" target="_blank" class="btn-primary btn-whatsapp">💬 Nous écrire sur WhatsApp</a>
                </div>
                <div>
                    <h3><i class="fas fa-truck"></i> Services sur place</h3>
                    <ul class="services-list">
                        <li><i class="fas fa-check"></i> Débitage d'orignaux</li>
                        <li><i class="fas fa-check"></i> Affûtage de couteaux et patins</li>
                        <li><i class="fas fa-check"></i> Vente de permis chasse/pêche</li>
                        <li><i class="fas fa-check"></i> Location poêle à méchoui</li>
                        <li><i class="fas fa-check"></i> Traiteur sur mesure</li>
                        <li><i class="fas fa-check"></i> Loto-Québec</li>
                    </ul>
                </div>
            </div>
            <iframe src="https://maps.google.com/maps?q=Saint-Ambroise%20QC&t=&z=12&ie=UTF8&iwloc=&output=embed" width="100%" height="220" style="border:0; margin-top: 32px; border-radius: 28px;" allowfullscreen></iframe>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Galerie Swiper
        const gallerySwiper = new Swiper('.gallerySwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: { el: '.swiper-pagination', clickable: true },
            breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
        });
        
        // Témoignages Swiper
        const testimonialSwiper = new Swiper('.testimonialSwiper', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 24,
            pagination: { el: '.swiper-pagination', clickable: true },
            breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
        });
    });
</script>
@endpush