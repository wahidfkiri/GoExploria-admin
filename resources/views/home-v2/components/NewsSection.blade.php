
{{-- Dernières Nouvelles Component --}}
<section class="news-v2-section design-bosse-section" id="news-section">
    <div class="design-bosse-container">
        
        {{-- BLOC DESIGN BOSSE --}}
        <div class="design-bosse-block news-section-block">
            <h1 class="design-bosse-title">Dernières Nouvelles</h1>
            
            <div class="design-bosse-controls" style="justify-content: center; text-align: center; margin-bottom: 40px;">
                <p style="font-size: 16px; color: #666; font-weight: 500; max-width: 800px; margin: 0 auto;">
                    Les articles les plus récents par région
                </p>
            </div>

            {{-- 1. Grille des Articles Récents --}}
            <div class="news-articles-grid">
                
                {{-- Article Afrique --}}
                <div class="news-article-card">
                    <div class="news-article-image">
                        <img src="https://images.unsplash.com/photo-1523841589119-91307b22292f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Afrique">
                        <span class="news-region-badge">AFRIQUE</span>
                    </div>
                    <div class="news-article-body">
                        <span class="news-category">Économie • Afrique</span>
                        <h3>Croissance record des économies d'Afrique de l'Ouest</h3>
                        <p>La CEDEAO annonce une croissance économique de 6.2% pour le dernier trimestre, dépassant toutes les prévisions.</p>
                        <div class="news-article-footer">
                            <span class="news-time">Il y a 3 heures</span>
                            <a href="#" class="news-read-btn">Lire <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

                {{-- Article Europe --}}
                <div class="news-article-card">
                    <div class="news-article-image">
                        <img src="https://images.unsplash.com/photo-1526628953301-3e589a6a8b74?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Europe">
                        <span class="news-region-badge">EUROPE</span>
                    </div>
                    <div class="news-article-body">
                        <span class="news-category">Politique • Europe</span>
                        <h3>Nouvelle politique migratoire de l'Union Européenne</h3>
                        <p>Les membres de l'UE trouvent un accord sur une approche commune pour la gestion des frontières et l'accueil des réfugiés.</p>
                        <div class="news-article-footer">
                            <span class="news-time">Il y a 6 heures</span>
                            <a href="#" class="news-read-btn">Lire <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

                {{-- Article Asie --}}
                <div class="news-article-card">
                    <div class="news-article-image">
                        <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Asie">
                        <span class="news-region-badge">ASIE</span>
                    </div>
                    <div class="news-article-body">
                        <span class="news-category">Innovation • Asie</span>
                        <h3>Le Japon lance son plus grand satellite d'observation</h3>
                        <p>Une avancée majeure pour la surveillance climatique et la prévention des catastrophes naturelles en Asie-Pacifique.</p>
                        <div class="news-article-footer">
                            <span class="news-time">Il y a 8 heures</span>
                            <a href="#" class="news-read-btn">Lire <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- 2. Zone d'Exploration par Région --}}
            <div class="news-explore-divider">
                <h2 class="design-bosse-label" style="font-size: 22px; color: #1a3a8f; margin-bottom: 10px;">Explorez les actualités spécifiques</h2>
                <p style="font-size: 14px; color: #888;">Explorez les actualités spécifiques à chaque région du monde</p>
            </div>

            <div class="news-region-grid">
                
                {{-- Afrique --}}
                <div class="region-explore-card africa">
                    <h4>Afrique</h4>
                    <span class="region-count"><i class="far fa-newspaper"></i> 245 nouvelles aujourd'hui</span>
                    <button class="region-explore-btn">Explorer</button>
                </div>

                {{-- Europe --}}
                <div class="region-explore-card europe">
                    <h4>Europe</h4>
                    <span class="region-count"><i class="far fa-newspaper"></i> 189 nouvelles aujourd'hui</span>
                    <button class="region-explore-btn">Explorer</button>
                </div>

                {{-- Asie --}}
                <div class="region-explore-card asia">
                    <h4>Asie</h4>
                    <span class="region-count"><i class="far fa-newspaper"></i> 312 nouvelles aujourd'hui</span>
                    <button class="region-explore-btn">Explorer</button>
                </div>

                {{-- Amériques --}}
                <div class="region-explore-card americas">
                    <h4>Amériques</h4>
                    <span class="region-count"><i class="far fa-newspaper"></i> 278 nouvelles aujourd'hui</span>
                    <button class="region-explore-btn">Explorer</button>
                </div>

            </div>

        </div>
    </div>
</section>

<style>
@media (max-width: 991px) {
    .desktop-only { display: none !important; }
}
</style>
