<section class="tourism-section" id="tourisme-business">

    {{-- EN-TÊTE STANDARD --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="GoExploria">
                    <div class="logo-wrapper"><img src="{{ asset('logo.png') }}" alt="GoExploria"></div>
                    <span class="resto-accord-btn-label">GoExploria</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-external-link-alt"></i> Visiter</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">EXPLOREZ L'INATTENDU / ACTIVITÉS PLEIN AIR</h1>
                <p class="resto-header-subtitle">Des aventures immersives à chaque saison — Nature, hiver, découverte</p>
                <div class="resto-header-tabs">
                    <button class="resto-tab-btn active"><i class="fas fa-hiking"></i>ESPACE ENTREPRISES</button>
                    <button class="resto-tab-btn"><i class="fas fa-calendar-alt"></i>ESPACE DESTINATIONS</button>
                    <button class="resto-tab-btn"><i class="fas fa-snowflake"></i>ESPACE ACTIVITES</button>
                </div>
            </div>
            <div class="resto-header-logo-right">
                <a href="#" class="resto-accord-btn" title="Écotourisme">
                    <div class="logo-wrapper tourism-eco-icon"><i class="fas fa-leaf"></i></div>
                    <span class="resto-accord-btn-label">Écotourisme</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-external-link-alt"></i> Découvrir</span>
                </a>
            </div>
        </div>
        <div class="resto-header-destinations-bar">
            <div class="resto-dest-row">
                <div class="resto-dest-icon-box">
                    <img src="{{ asset('REDI.png') }}" alt="Destinations">
                    <span>Destinations</span>
                </div>
                <div class="resto-dest-breadcrumb">
                    <a href="#" class="resto-dest-link active">Toutes destinations</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">Europe</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">Ontario</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">Mauricie</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">Île d'Orléans</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">Vieux-Québec</a>
                </div>
            </div>
            <div class="resto-actions-row">
                <div class="resto-header-ctas">
                    <a href="#" class="resto-cta-btn primary"><i class="fas fa-calendar-check"></i> Réservez</a>
                    <a href="#" class="resto-cta-btn secondary">En savoir <span class="cta-plus">+</span></a>
                </div>
            </div>
        </div>
        <div class="resto-header-shimmer"></div>
    </div>

    <div class="tourism-container">

      <!-- PARTIE 1 : IDÉES AVENTURES -->
      <div>
        <div class="section-header">
          <div class="section-header-left">
            <h3><i class="fas fa-hiking" style="color:#00CC99; margin-right:10px;"></i> Idées aventures</h3>
            <p>Pour les âmes libres et les explorateurs modernes</p>
          </div>
          <span class="experience-counter"><i class="fas fa-compass"></i> 12 expériences</span>
        </div>

        <div class="aventures-grid">
          <!-- Aventure 1 -->
          <div class="aventure-card">
            <div class="aventure-icon"><i class="fas fa-fire-alt"></i></div>
            <h4 class="aventure-title">Réveil des volcans</h4>
            <p class="aventure-desc">
              Ascension du Pico de Fogo au lever du soleil. Traversée de champs de lave noire et baignade dans des sources chaudes naturelles.
            </p>
            <div class="aventure-meta">
              <span class="meta-tag"><i class="far fa-clock"></i> 6 jours</span>
              <span class="meta-tag"><i class="fas fa-chart-line"></i> Difficile</span>
              <span class="meta-tag"><i class="fas fa-map-marker-alt"></i> Cap-Vert</span>
            </div>
          </div>
          <!-- Aventure 2 -->
          <div class="aventure-card">
            <div class="aventure-icon"><i class="fas fa-water"></i></div>
            <h4 class="aventure-title">Mangroves secrètes</h4>
            <p class="aventure-desc">
              Expédition en kayak à travers les canaux cachés de la mangrove. Observation des singes hurleurs et dauphins roses de l'Amazone.
            </p>
            <div class="aventure-meta">
              <span class="meta-tag"><i class="far fa-clock"></i> 4 jours</span>
              <span class="meta-tag"><i class="fas fa-chart-line"></i> Modéré</span>
              <span class="meta-tag"><i class="fas fa-map-marker-alt"></i> Brésil</span>
            </div>
          </div>
          <!-- Aventure 3 -->
          <div class="aventure-card">
            <div class="aventure-icon"><i class="fas fa-route"></i></div>
            <h4 class="aventure-title">Caravane berbère</h4>
            <p class="aventure-desc">
              Traversée du désert du Sahara à dos de dromadaire. Nuits à la belle étoile et rencontres avec les nomades du désert.
            </p>
            <div class="aventure-meta">
              <span class="meta-tag"><i class="far fa-clock"></i> 8 jours</span>
              <span class="meta-tag"><i class="fas fa-chart-line"></i> Facile</span>
              <span class="meta-tag"><i class="fas fa-map-marker-alt"></i> Maroc</span>
            </div>
          </div>
        </div>
      </div>

      <!-- PARTIE 2 : ACTIVITÉS 4 SAISONS -->
      <div>
        <div class="section-header">
          <div class="section-header-left">
            <h3><i class="fas fa-calendar-alt" style="color:#00CC99; margin-right:10px;"></i> Activités 4 saisons</h3>
            <p>Chaque moment de l'année a son aventure</p>
          </div>
        </div>

        <div class="saisons-carousel">
          <div class="saison-card">
            <span class="saison-emoji"><i class="fas fa-seedling"></i></span>
            <div class="saison-name">Printemps</div>
            <div class="saison-activite"><i class="fas fa-hiking"></i> Randonnée florale</div>
            <div class="saison-activite"><i class="fas fa-binoculars"></i> Observation nature</div>
            <div class="saison-activite"><i class="fas fa-bicycle"></i> Vélo en vallée</div>
            <span class="saison-temp">12°C - 20°C</span>
          </div>
          <div class="saison-card">
            <span class="saison-emoji"><i class="fas fa-sun"></i></span>
            <div class="saison-name">Été</div>
            <div class="saison-activite"><i class="fas fa-swimmer"></i> Plongée corail</div>
            <div class="saison-activite"><i class="fas fa-parachute-box"></i> Parapente</div>
            <div class="saison-activite"><i class="fas fa-mountain"></i> Via ferrata</div>
            <span class="saison-temp">25°C - 35°C</span>
          </div>
          <div class="saison-card">
            <span class="saison-emoji"><i class="fas fa-leaf"></i></span>
            <div class="saison-name">Automne</div>
            <div class="saison-activite"><i class="fas fa-seedling"></i> Cueillette</div>
            <div class="saison-activite"><i class="fas fa-fish"></i> Pêche en rivière</div>
            <div class="saison-activite"><i class="fas fa-camera"></i> Safari photo</div>
            <span class="saison-temp">8°C - 16°C</span>
          </div>
          <div class="saison-card">
            <span class="saison-emoji"><i class="fas fa-snowflake"></i></span>
            <div class="saison-name">Hiver</div>
            <div class="saison-activite"><i class="fas fa-skiing"></i> Ski hors-piste</div>
            <div class="saison-activite"><i class="fas fa-dog"></i> Traîneau chiens</div>
            <div class="saison-activite"><i class="fas fa-mountain"></i> Raquettes</div>
            <span class="saison-temp">-10°C - 2°C</span>
          </div>
        </div>
      </div>

      <!-- PARTIE 3 : ACTIVITÉS HIVERNALES -->
      <div class="hiver-section">
        <div class="hiver-header">
          <div class="hiver-icon"><i class="fas fa-snowflake" style="color:#3399FF;"></i></div>
          <div>
            <h3 class="hiver-title">Activités hivernales</h3>
            <p class="hiver-sub">L'hiver, un terrain de jeu magique • 8 expériences glacées</p>
          </div>
        </div>

        <div class="hiver-grid">
          <!-- Activité 1 -->
          <div class="hiver-activity-card">
            <span class="activity-icon-big"><i class="fas fa-sleigh"></i></span>
            <h4 class="activity-name">Traîneau à chiens</h4>
            <p class="activity-desc">
              Conduisez votre propre attelage à travers les forêts enneigées de Laponie. Nuit en chalet et aurores boréales.
            </p>
            <div class="activity-difficulte">
              <span>Difficulté</span>
              <span class="difficulty-stars">★★☆☆☆</span>
            </div>
            <div class="snow-decoration"><i class="fas fa-clock"></i> 5 jours • Dès 890€</div>
          </div>
          <!-- Activité 2 -->
          <div class="hiver-activity-card">
            <span class="activity-icon-big"><i class="fas fa-icicles"></i></span>
            <h4 class="activity-name">Plongée sous glace</h4>
            <p class="activity-desc">
              Expérience unique au Québec : plongez sous la surface gelée, visibilité cristalline et paysages féériques.
            </p>
            <div class="activity-difficulte">
              <span>Difficulté</span>
              <span class="difficulty-stars">★★★★☆</span>
            </div>
            <div class="snow-decoration"><i class="fas fa-clock"></i> 2 jours • Encadré</div>
          </div>
          <!-- Activité 3 -->
          <div class="hiver-activity-card">
            <span class="activity-icon-big"><i class="fas fa-skiing"></i></span>
            <h4 class="activity-name">Ski extrême</h4>
            <p class="activity-desc">
              Descentes hors-piste dans les Alpes suisses, neige poudreuse, guides de haute montagne et fonds secrets.
            </p>
            <div class="activity-difficulte">
              <span>Difficulté</span>
              <span class="difficulty-stars">★★★★★</span>
            </div>
            <div class="snow-decoration"><i class="fas fa-clock"></i> 4 jours • Niveau confirmé</div>
          </div>
          <!-- Activité 4 -->
          <div class="hiver-activity-card">
            <span class="activity-icon-big"><i class="fas fa-campground"></i></span>
            <h4 class="activity-name">Nuit sur glacier</h4>
            <p class="activity-desc">
              Bivouac en igloo ou tente d'expédition sur le glacier du Jostedal. Immersion totale dans le silence blanc.
            </p>
            <div class="activity-difficulte">
              <span>Difficulté</span>
              <span class="difficulty-stars">★★★☆☆</span>
            </div>
            <div class="snow-decoration"><i class="fas fa-clock"></i> 2 jours • Norvège</div>
          </div>
          <!-- Activité 5 -->
          <div class="hiver-activity-card">
            <span class="activity-icon-big"><i class="fas fa-star"></i></span>
            <h4 class="activity-name">Aurores boréales</h4>
            <p class="activity-desc">
              Expédition en Islande pour traquer les aurores boréales, bain géothermique et nuit en refuge isolé.
            </p>
            <div class="activity-difficulte">
              <span>Difficulté</span>
              <span class="difficulty-stars">★☆☆☆☆</span>
            </div>
            <div class="snow-decoration"><i class="fas fa-clock"></i> 6 jours • Photo</div>
          </div>
          <!-- Activité 6 -->
          <div class="hiver-activity-card">
            <span class="activity-icon-big"><i class="fas fa-hiking"></i></span>
            <h4 class="activity-name">Raquettes nocturnes</h4>
            <p class="activity-desc">
              Randonnée en raquettes à la lumière des lampes frontales, dégustation de fondue savoyarde dans un refuge d'altitude.
            </p>
            <div class="activity-difficulte">
              <span>Difficulté</span>
              <span class="difficulty-stars">★★☆☆☆</span>
            </div>
            <div class="snow-decoration"><i class="fas fa-clock"></i> 1 jour • France</div>
          </div>
        </div>

        <div style="display: flex; justify-content: center;">
          <a href="#" class="btn-hiver-cta">
            <i class="fas fa-snowflake"></i> Réserver une aventure hivernale
          </a>
        </div>
      </div>

      <!-- FOOTER STATS -->
      <!-- <div class="stats-footer">
        <div class="stats-left">
          <div class="stat-tag"><i class="fas fa-map-marked-alt"></i> <span>52</span> aventures proposées</div>
          <div class="stat-tag"><i class="fas fa-snowflake"></i> <span>18</span> activités hiver</div>
          <div class="stat-tag"><i class="fas fa-seedling"></i> Voyage responsable</div>
        </div>
        <div style="display: flex; gap: 15px;">
           <i class="fab fa-instagram" style="font-size: 1.5rem; color: #00CC99;"></i>
           <i class="fab fa-facebook" style="font-size: 1.5rem; color: #0066CC;"></i>
        </div>
      </div> -->
    </div>
</section>
