@extends('theme::layout')

@section('title', get_site_name() . ' - FraÃ®cheur et diversitÃ© Ã  Saint-Ambroise')
@section('description', 'Ã‰picerie multi-services Ã  Saint-Ambroise. Boucherie, charcuterie, traiteur, mÃ©choui, chasse et pÃªche. Service personnalisÃ© depuis plus de 20 ans.')

@section('content')
<!-- SECTION VALEURS / CARDS -->
<section class="values-section">
    <div class="container">
        <div class="cards-grid">
            <div class="card-icon">
                <i class="fas fa-apple-alt"></i>
                <h3>Fruits & lÃ©gumes</h3>
                <p>Grand choix de produits frais, locaux et de saison.</p>
            </div>
            <div class="card-icon">
                <i class="fas fa-drumstick-bite"></i>
                <h3>Boucherie & charcuterie</h3>
                <p>Creton, pepperoni, saucisses BBQ, viandes de qualitÃ©.</p>
            </div>
            <div class="card-icon">
                <i class="fas fa-fish"></i>
                <h3>Chasse & pÃªche</h3>
                <p>Ã‰quipements, permis, conseils d'experts avec Maryeve Pepin.</p>
            </div>
        </div>
    </div>
</section>

<!-- DÃ‰PARTEMENTS -->
<section id="departements" class="departments-section">
    <div class="container">
        <h2 class="section-title">Nos dÃ©partements</h2>
        <p class="section-sub">Une Ã©picerie complÃ¨te pour tous vos besoins</p>
        <div class="departments-grid">
            <div class="dept-item"><i class="fas fa-carrot"></i> Fruits & lÃ©gumes</div>
            <div class="dept-item"><i class="fas fa-cheese"></i> Fromagerie</div>
            <div class="dept-item"><i class="fas fa-wine-bottle"></i> Vins & spiritueux</div>
            <div class="dept-item"><i class="fas fa-utensils"></i> Mets prÃ©parÃ©s</div>
            <div class="dept-item"><i class="fas fa-gun"></i> Chasse & pÃªche</div>
            <div class="dept-item"><i class="fas fa-sandwich"></i> Sandwiches & collations</div>
            <div class="dept-item"><i class="fas fa-coffee"></i> Coin pause-cafÃ©</div>
            <div class="dept-item"><i class="fas fa-ticket-alt"></i> Loto-QuÃ©bec</div>
        </div>
    </div>
</section>

<!-- BOUCHERIE + CHARCUTERIE -->
<section id="boucherie" class="butchery-section">
    <div class="container split-section">
        <div class="split-image">
            <img src="https://images.pexels.com/photos/6754143/pexels-photo-6754143.jpeg?auto=compress&cs=tinysrgb&w=800" alt="Boucherie MarchÃ© Alqui">
        </div>
        <div>
            <h2 class="section-title" style="text-align: left;">Boucherie & Charcuterie artisanale</h2>
            <p>Depuis 20 ans, nous fabriquons nos <strong>creton, pepperoni, 6 Ã  8 variÃ©tÃ©s de saucisses pour le BBQ</strong>. Mets cuisinÃ©s frais, diversifiÃ©s et prÃªts Ã  emporter Ã  l'heure du lunch.</p>
            <ul class="services-list">
                <li><i class="fas fa-check-circle"></i> Charcuterie maison</li>
                <li><i class="fas fa-check-circle"></i> Viandes fraÃ®ches et maturÃ©es</li>
                <li><i class="fas fa-check-circle"></i> Service de dÃ©bitage d'orignaux</li>
                <li><i class="fas fa-check-circle"></i> AffÃ»tage de couteaux et lames de patins</li>
            </ul>
        </div>
    </div>
</section>

<!-- TRAITEUR & MÃ‰CHOUI -->
<section id="traiteur" class="catering-section">
    <div class="container split-section">
        <div>
            <h2 class="section-title" style="text-align: left;">Service de traiteur & MÃ©choui</h2>
            <p>Nous offrons un service de traiteur ainsi qu'un service de buffet chaud ou froid pour le secteur du Saguenay Lac-St-Jean.</p>
            <p><strong>ðŸ“ Location de poÃªle Ã  mÃ©choui disponible</strong> pour vos Ã©vÃ©nements et rÃ©unions familiales.</p>
            <a href="#contact" class="btn-primary" style="display: inline-block; margin-top: 20px;">RÃ©server un service</a>
        </div>
        <div class="split-image">
            <img src="https://images.pexels.com/photos/2881048/pexels-photo-2881048.jpeg?auto=compress&cs=tinysrgb&w=800" alt="MÃ©choui MarchÃ© Alqui">
        </div>
    </div>
</section>

<!-- CHASSE & PÃŠCHE + DÃ‰PANNEUR -->
<section class="hunting-section">
    <div class="container split-section">
        <div class="split-image">
            <img src="https://images.pexels.com/photos/7661321/pexels-photo-7661321.jpeg?auto=compress&cs=tinysrgb&w=800" alt="Chasse et pÃªche">
        </div>
        <div>
            <h2 class="section-title" style="text-align: left;">Chasse, PÃªche & Plein-air</h2>
            <p>Pour vos divertissements, vous trouverez chez nous l'Ã©quipement sportif de chasse, de pÃªche et de plein-air. <strong>Vente de permis de chasse et pÃªche</strong>.</p>
            <p>âœ¨ <strong>Maryeve Pepin</strong>, experte en produits de chasse, est lÃ  pour vous conseiller.</p>
            <p>ðŸ“ Services additionnels : dÃ©taillant Loto-QuÃ©bec, feux d'artifice, cartes d'appel.</p>
        </div>
    </div>
</section>

<!-- GALERIE PHOTOS (SWIPER) -->
<section id="galerie" class="gallery-section">
    <div class="container">
        <h2 class="section-title">Galerie</h2>
        <p class="section-sub">DÃ©couvrez notre Ã©picerie, notre boucherie et nos services</p>
        <div class="swiper gallerySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="https://images.pexels.com/photos/264636/pexels-photo-264636.jpeg?auto=compress&cs=tinysrgb&w=600" alt="MarchÃ© Alqui"></div>
                <div class="swiper-slide"><img src="https://images.pexels.com/photos/699953/pexels-photo-699953.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Boucherie"></div>
                <div class="swiper-slide"><img src="https://images.pexels.com/photos/6754143/pexels-photo-6754143.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Charcuterie"></div>
                <div class="swiper-slide"><img src="https://images.pexels.com/photos/2881048/pexels-photo-2881048.jpeg?auto=compress&cs=tinysrgb&w=600" alt="MÃ©choui"></div>
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
                    <p>â€œExcellent service, produits frais et variÃ©s. La boucherie est exceptionnelle !â€</p>
                    <strong>- Jean B.</strong>
                </div>
                <div class="swiper-slide testimonial-card">
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p>â€œLe service de mÃ©choui est top. Location de poÃªle trÃ¨s pratique.â€</p>
                    <strong>- Marie-Claude L.</strong>
                </div>
                <div class="swiper-slide testimonial-card">
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p>â€œMaryeve est trÃ¨s compÃ©tente pour tout ce qui touche la chasse. Bravo !â€</p>
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
                    <h3><i class="fas fa-store"></i> MarchÃ© Alqui</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Au cÅ“ur de Saint-Ambroise, Saguenay-Lac-St-Jean</p>
                    <p><i class="fas fa-phone-alt"></i> <strong>(418) 672-4792</strong></p>
                    <p><i class="fab fa-whatsapp"></i> WhatsApp : (418) 672-4792</p>
                    <p><i class="fas fa-envelope"></i> maestroalqui@gmail.com</p>
                    <p><i class="fas fa-clock"></i> Ouverture: tous les jours (consultez nos horaires)</p>
                    <a href="https://wa.me/14186724792" target="_blank" class="btn-primary btn-whatsapp">ðŸ’¬ Nous Ã©crire sur WhatsApp</a>
                </div>
                <div>
                    <h3><i class="fas fa-truck"></i> Services sur place</h3>
                    <ul class="services-list">
                        <li><i class="fas fa-check"></i> DÃ©bitage d'orignaux</li>
                        <li><i class="fas fa-check"></i> AffÃ»tage de couteaux et patins</li>
                        <li><i class="fas fa-check"></i> Vente de permis chasse/pÃªche</li>
                        <li><i class="fas fa-check"></i> Location poÃªle Ã  mÃ©choui</li>
                        <li><i class="fas fa-check"></i> Traiteur sur mesure</li>
                        <li><i class="fas fa-check"></i> Loto-QuÃ©bec</li>
                    </ul>
                </div>
            </div>
            <iframe src="https://maps.google.com/maps?q=Saint-Ambroise%20QC&t=&z=12&ie=UTF8&iwloc=&output=embed" width="100%" height="220" style="border:0; margin-top: 32px; border-radius: 28px;" allowfullscreen></iframe>
        </div>
    </div>
</section>
@endsection


