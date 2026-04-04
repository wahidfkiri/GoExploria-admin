{{-- Events Vedette Component - Événements vedette au Québec --}}
<section class="events-vedette-v2-section">
    <div class="events-vedette-v2-container">
        {{-- BLOC DESIGN BOSSE --}}
        <div class="design-bosse-block">
            <h2 class="design-bosse-title">ÉVÉNEMENTS VEDETTE AU QUÉBEC</h2>
            
            <div class="design-bosse-controls">
                <div class="events-vedette-v2-filters">
                    <span class="design-bosse-label">
                        <span class="bosse-picto">📍</span> Régions Canadiennes :
                    </span>
                    <button class="events-vedette-v2-filter-btn active" data-filter="all">Tout le Québec</button>
                    <button class="events-vedette-v2-filter-btn" data-filter="montreal">Montréal</button>
                    <button class="events-vedette-v2-filter-btn" data-filter="quebec">Québec</button>
                    <button class="events-vedette-v2-filter-btn" data-filter="nature">Gaspésie</button>
                    <button class="events-vedette-v2-filter-btn" data-filter="culture">Saguenay</button>
                </div>

                <a href="#" class="design-bosse-more-btn">
                    En savoir plus <span class="events-vedette-v2-plus-icon">+</span>
                </a>
            </div>
        </div>

        {{-- Scroll horizontal des événements --}}
        <div class="events-vedette-v2-scroll-wrapper">
            <div class="events-vedette-v2-scroll-container" id="eventsVedetteGrid">
            {{-- Event Card 1 --}}
            <article class="events-vedette-v2-card" data-category="culture">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=600&h=400&fit=crop" alt="Festival d'été de Québec">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">15-24 JUIN</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Festival d'été de Québec</h3>
                    <p class="events-vedette-v2-card-description">
                        Le plus grand festival extérieur en Amérique du Nord, avec des artistes internationaux.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Québec</span>
                        <span class="events-vedette-v2-card-tag">Scènes extérieures</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 2 --}}
            <article class="events-vedette-v2-card" data-category="gastronomie">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1555244162-803834f70033?w=600&h=400&fit=crop" alt="Carnaval de Québec">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">28 FÉV - 10 MAR</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Carnaval de Québec</h3>
                    <p class="events-vedette-v2-card-description">
                        Le plus grand carnaval d'hiver au monde avec Bonhomme Carnaval comme ambassadeur.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Québec</span>
                        <span class="events-vedette-v2-card-tag">Activités hivernales</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 3 --}}
            <article class="events-vedette-v2-card" data-category="culture">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&h=400&fit=crop" alt="Osheaga">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">AOÛT 2024</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Osheaga</h3>
                    <p class="events-vedette-v2-card-description">
                        Festival de musique et arts contemporains sur l'île Sainte-Hélène à Montréal.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Montréal</span>
                        <span class="events-vedette-v2-card-tag">Musique & Arts</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 4 --}}
            <article class="events-vedette-v2-card" data-category="nature">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=600&h=400&fit=crop" alt="Festival des couleurs">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">OCT 2024</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Festival des couleurs</h3>
                    <p class="events-vedette-v2-card-description">
                        Célébration de l'automne et des magnifiques paysages colorés des Cantons-de-l'Est.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Cantons-de-l'Est</span>
                        <span class="events-vedette-v2-card-tag">Nature & Culture</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 5 --}}
            <article class="events-vedette-v2-card" data-category="aventures">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=600&h=400&fit=crop" alt="Festival de montgolfières">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">SEPT 2024</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Festival de montgolfières</h3>
                    <p class="events-vedette-v2-card-description">
                        Le plus grand rassemblement de montgolfières au Canada à Saint-Jean-sur-Richelieu.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Saint-Jean-sur-Richelieu</span>
                        <span class="events-vedette-v2-card-tag">Aventures</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 6 --}}
            <article class="events-vedette-v2-card" data-category="culture">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=600&h=400&fit=crop" alt="Festival Juste pour rire">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">JUIL 2024</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Festival Juste pour rire</h3>
                    <p class="events-vedette-v2-card-description">
                        Le plus grand festival d'humour au monde avec des spectacles et animations.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Montréal</span>
                        <span class="events-vedette-v2-card-tag">Humour & Spectacles</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 7 --}}
            <article class="events-vedette-v2-card" data-category="gastronomie">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&h=400&fit=crop" alt="Festival gastronomique">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">MAI 2024</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Festival gastronomique</h3>
                    <p class="events-vedette-v2-card-description">
                        Découvrez la richesse culinaire du Québec avec des chefs renommés.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Montréal</span>
                        <span class="events-vedette-v2-card-tag">Gastronomie</span>
                    </div>
                </div>
            </article>

            {{-- Event Card 8 --}}
            <article class="events-vedette-v2-card" data-category="nature">
                <div class="events-vedette-v2-card-image">
                    <img src="https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=600&h=400&fit=crop" alt="Festival des baleines">
                    <div class="events-vedette-v2-card-date">
                        <span class="events-vedette-v2-date-text">JUIN 2024</span>
                    </div>
                </div>
                <div class="events-vedette-v2-card-content">
                    <h3 class="events-vedette-v2-card-title">Festival des baleines</h3>
                    <p class="events-vedette-v2-card-description">
                        Observation des baleines et célébration de la faune marine du Saint-Laurent.
                    </p>
                    <div class="events-vedette-v2-card-footer">
                        <span class="events-vedette-v2-card-location">Tadoussac</span>
                        <span class="events-vedette-v2-card-tag">Nature & Faune</span>
                    </div>
                </div>
            </article>
            </div>
        </div>
    </div>
</section>
