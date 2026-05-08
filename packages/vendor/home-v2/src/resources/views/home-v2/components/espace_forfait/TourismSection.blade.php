@php
    $tr = static function (string $text): string {
        $locale = app()->getLocale();
        if ($locale === 'fr') {
            return $text;
        }

        static $maps = [];
        if (! array_key_exists($locale, $maps)) {
            $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
            $maps[$locale] = is_file($path) ? (require $path) : [];
        }

        return $maps[$locale][$text] ?? $text;
    };
@endphp

<section class="tourism-section" id="tourisme-business">

    {{-- EN-TÊTE STANDARD --}}
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="{{ $tr('GoExploria') }}">
                    <div class="logo-wrapper"><img src="{{ asset('logo.png') }}" alt="{{ $tr('GoExploria') }}"></div>
                    <span class="resto-accord-btn-label">{{ $tr('GoExploria') }}</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-external-link-alt"></i> {{ $tr('Visiter') }}</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('EXPLOREZ L\'INATTENDU / ACTIVITÉS PLEIN AIR') }}</h1>
                <p class="resto-header-subtitle">{{ $tr('Des aventures immersives à chaque saison — Nature, hiver, découverte') }}</p></div>
           
            <div class="resto-header-logo-right">
                <a href="{{ url('espace-forfait/tourisme') }}" title="Espace forfaits Go exploria Business" target="_blank" rel="noopener noreferrer">
                    <img class="bt-next-level-image" src="{{ asset('images/Next-level.png') }}" alt="{{ $tr('Next Level') }}" loading="lazy">
                </a>
            </div>
        </div>
        <div class="resto-header-destinations-bar">
            <div class="resto-dest-row">
    <div class="resto-dest-icon-box">
        <img src="{{ asset('REDI.png') }}" alt="Destinations">
        <span>Destinations</span>
    </div>

    <div class="resto-dest-breadcrumb vp-dest-breadcrumb">
        <select id="vp-continent-select" class="vp-dest-select" aria-label="Continent">
            <option value="amerique-nord">Amérique du Nord</option>
            <option value="europe">Europe</option>
            <option value="afrique">Afrique</option>
            <option value="asie">Asie</option>
            <option value="amerique-sud">Amérique du Sud</option>
            <option value="oceanie">Océanie</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-country-select" class="vp-dest-select" aria-label="Pays">
            <option value="canada">Canada</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-province-select" class="vp-dest-select" aria-label="Province">
            <option value="quebec">Québec</option>
            <option value="ontario">Ontario</option>
            <option value="alberta">Alberta</option>
            <option value="colombie-britannique">Colombie-Britannique</option>
            <option value="nouvelle-ecosse">Nouvelle-Écosse</option>
        </select>
        <span class="resto-dest-sep">/</span>
        <select id="vp-region-select" class="vp-dest-select" aria-label="Région">
            <option value="region-de-quebec">Région de Québec</option>
            <option value="montreal-metro">Montréal Métro</option>
            <option value="mauricie">Mauricie</option>
            <option value="gaspesie">Gaspésie</option>
            <option value="saguenay">Saguenay</option>
        </select>
    </div>
</div>
            <div class="resto-actions-row">
                <div class="resto-header-ctas">
                    <a href="#" class="resto-cta-btn primary"><i class="fas fa-calendar-check"></i> {{ $tr('Réservez') }}</a>
                    <a href="#" class="resto-cta-btn secondary">{{ $tr('En savoir') }} <span class="cta-plus">+</span></a>
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
            <h3><i class="fas fa-hiking" style="color:#00CC99; margin-right:10px;"></i> {{ $tr('Idées aventures') }}</h3>
            <p>{{ $tr('Pour les âmes libres et les explorateurs modernes') }}</p>
          </div>
          <span class="experience-counter"><i class="fas fa-compass"></i> {{ $tr('12 expériences') }}</span>
        </div>

        <div class="aventures-grid">
          <!-- Aventure 1 -->
          <div class="aventure-card">
            <div class="aventure-icon"><i class="fas fa-fire-alt"></i></div>
            <h4 class="aventure-title">{{ $tr('Réveil des volcans') }}</h4>
            <p class="aventure-desc">
              {{ $tr('Ascension du Pico de Fogo au lever du soleil. Traversée de champs de lave noire et baignade dans des sources chaudes naturelles.') }}
            </p>
            <div class="aventure-meta">
              <span class="meta-tag"><i class="far fa-clock"></i> {{ $tr('6 jours') }}</span>
              <span class="meta-tag"><i class="fas fa-chart-line"></i> {{ $tr('Difficile') }}</span>
              <span class="meta-tag"><i class="fas fa-map-marker-alt"></i> {{ $tr('Cap-Vert') }}</span>
            </div>
          </div>
          <!-- Aventure 2 -->
          <div class="aventure-card">
            <div class="aventure-icon"><i class="fas fa-water"></i></div>
            <h4 class="aventure-title">{{ $tr('Mangroves secrètes') }}</h4>
            <p class="aventure-desc">
              {{ $tr('Expédition en kayak à travers les canaux cachés de la mangrove. Observation des singes hurleurs et dauphins roses de l\'Amazone.') }}
            </p>
            <div class="aventure-meta">
              <span class="meta-tag"><i class="far fa-clock"></i> {{ $tr('4 jours') }}</span>
              <span class="meta-tag"><i class="fas fa-chart-line"></i> {{ $tr('Modéré') }}</span>
              <span class="meta-tag"><i class="fas fa-map-marker-alt"></i> {{ $tr('Brésil') }}</span>
            </div>
          </div>
          <!-- Aventure 3 -->
          <div class="aventure-card">
            <div class="aventure-icon"><i class="fas fa-route"></i></div>
            <h4 class="aventure-title">{{ $tr('Caravane berbère') }}</h4>
            <p class="aventure-desc">
              {{ $tr('Traversée du désert du Sahara à dos de dromadaire. Nuits à la belle étoile et rencontres avec les nomades du désert.') }}
            </p>
            <div class="aventure-meta">
              <span class="meta-tag"><i class="far fa-clock"></i> {{ $tr('8 jours') }}</span>
              <span class="meta-tag"><i class="fas fa-chart-line"></i> {{ $tr('Facile') }}</span>
              <span class="meta-tag"><i class="fas fa-map-marker-alt"></i> {{ $tr('Maroc') }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- PARTIE 2 : ACTIVITÉS 4 SAISONS -->
      <div>
        <div class="section-header">
          <div class="section-header-left">
            <h3><i class="fas fa-calendar-alt" style="color:#00CC99; margin-right:10px;"></i> {{ $tr('Activités 4 saisons') }}</h3>
            <p>{{ $tr('Chaque moment de l\'année a son aventure') }}</p>
          </div>
        </div>

        <div class="saisons-carousel">
          <div class="saison-card">
            <span class="saison-emoji"><i class="fas fa-seedling"></i></span>
            <div class="saison-name">{{ $tr('Printemps') }}</div>
            <div class="saison-activite"><i class="fas fa-hiking"></i> {{ $tr('Randonnée florale') }}</div>
            <div class="saison-activite"><i class="fas fa-binoculars"></i> {{ $tr('Observation nature') }}</div>
            <div class="saison-activite"><i class="fas fa-bicycle"></i> {{ $tr('Vélo en vallée') }}</div>
            <span class="saison-temp">{{ $tr('12°C - 20°C') }}</span>
          </div>
          <div class="saison-card">
            <span class="saison-emoji"><i class="fas fa-sun"></i></span>
            <div class="saison-name">{{ $tr('Été') }}</div>
            <div class="saison-activite"><i class="fas fa-swimmer"></i> {{ $tr('Plongée corail') }}</div>
            <div class="saison-activite"><i class="fas fa-parachute-box"></i> {{ $tr('Parapente') }}</div>
            <div class="saison-activite"><i class="fas fa-mountain"></i> {{ $tr('Via ferrata') }}</div>
            <span class="saison-temp">{{ $tr('25°C - 35°C') }}</span>
          </div>
          <div class="saison-card">
            <span class="saison-emoji"><i class="fas fa-leaf"></i></span>
            <div class="saison-name">{{ $tr('Automne') }}</div>
            <div class="saison-activite"><i class="fas fa-seedling"></i> {{ $tr('Cueillette') }}</div>
            <div class="saison-activite"><i class="fas fa-fish"></i> {{ $tr('Pêche en rivière') }}</div>
            <div class="saison-activite"><i class="fas fa-camera"></i> {{ $tr('Safari photo') }}</div>
            <span class="saison-temp">{{ $tr('8°C - 16°C') }}</span>
          </div>
          <div class="saison-card">
            <span class="saison-emoji"><i class="fas fa-snowflake"></i></span>
            <div class="saison-name">{{ $tr('Hiver') }}</div>
            <div class="saison-activite"><i class="fas fa-skiing"></i> {{ $tr('Ski hors-piste') }}</div>
            <div class="saison-activite"><i class="fas fa-dog"></i> {{ $tr('Traîneau chiens') }}</div>
            <div class="saison-activite"><i class="fas fa-mountain"></i> {{ $tr('Raquettes') }}</div>
            <span class="saison-temp">{{ $tr('-10°C - 2°C') }}</span>
          </div>
        </div>
      </div>

      <!-- PARTIE 3 : ACTIVITÉS HIVERNALES -->
      <div class="hiver-section">
        <div class="hiver-header">
          <div class="hiver-icon"><i class="fas fa-snowflake" style="color:#3399FF;"></i></div>
          <div>
            <h3 class="hiver-title">{{ $tr('Activités hivernales') }}</h3>
            <p class="hiver-sub">{{ $tr('L\'hiver, un terrain de jeu magique • 8 expériences glacées') }}</p>
          </div>
        </div>

        <div class="hiver-grid">
          <!-- Activité 1 -->
          <div class="hiver-activity-card">
            <span class="activity-icon-big"><i class="fas fa-sleigh"></i></span>
            <h4 class="activity-name">{{ $tr('Traîneau à chiens') }}</h4>
            <p class="activity-desc">
              {{ $tr('Conduisez votre propre attelage à travers les forêts enneigées de Laponie. Nuit en chalet et aurores boréales.') }}
            </p>
            <div class="activity-difficulte">
              <span>{{ $tr('Difficulté') }}</span>
              <span class="difficulty-stars">&#9733;&#9733;&#9734;&#9734;&#9734;</span>
            </div>
            <div class="snow-decoration"><i class="fas fa-clock"></i> {{ $tr('5 jours • Dès 890 €') }}</div>
          </div>
          <!-- Activité 2 -->
          <div class="hiver-activity-card">
            <span class="activity-icon-big"><i class="fas fa-icicles"></i></span>
            <h4 class="activity-name">{{ $tr('Plongée sous glace') }}</h4>
            <p class="activity-desc">
              {{ $tr('Expérience unique au Québec : plongez sous la surface gelée, visibilité cristalline et paysages féériques.') }}
            </p>
            <div class="activity-difficulte">
              <span>{{ $tr('Difficulté') }}</span>
              <span class="difficulty-stars">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
            </div>
            <div class="snow-decoration"><i class="fas fa-clock"></i> {{ $tr('2 jours • Encadré') }}</div>
          </div>
          <!-- Activité 3 -->
          <div class="hiver-activity-card">
            <span class="activity-icon-big"><i class="fas fa-skiing"></i></span>
            <h4 class="activity-name">{{ $tr('Ski extrême') }}</h4>
            <p class="activity-desc">
              {{ $tr('Descentes hors-piste dans les Alpes suisses, neige poudreuse, guides de haute montagne et fonds secrets.') }}
            </p>
            <div class="activity-difficulte">
              <span>{{ $tr('Difficulté') }}</span>
              <span class="difficulty-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
            </div>
            <div class="snow-decoration"><i class="fas fa-clock"></i> {{ $tr('4 jours • Niveau confirmé') }}</div>
          </div>
          <!-- Activité 4 -->
          <div class="hiver-activity-card">
            <span class="activity-icon-big"><i class="fas fa-campground"></i></span>
            <h4 class="activity-name">{{ $tr('Nuit sur glacier') }}</h4>
            <p class="activity-desc">
              {{ $tr('Bivouac en igloo ou tente d\'expédition sur le glacier du Jostedal. Immersion totale dans le silence blanc.') }}
            </p>
            <div class="activity-difficulte">
              <span>{{ $tr('Difficulté') }}</span>
              <span class="difficulty-stars">&#9733;&#9733;&#9733;&#9734;&#9734;</span>
            </div>
            <div class="snow-decoration"><i class="fas fa-clock"></i> {{ $tr('2 jours • Norvège') }}</div>
          </div>
          <!-- Activité 5 -->
          <div class="hiver-activity-card">
            <span class="activity-icon-big"><i class="fas fa-star"></i></span>
            <h4 class="activity-name">{{ $tr('Aurores boréales') }}</h4>
            <p class="activity-desc">
              {{ $tr('Expédition en Islande pour traquer les aurores boréales, bain géothermique et nuit en refuge isolé.') }}
            </p>
            <div class="activity-difficulte">
              <span>{{ $tr('Difficulté') }}</span>
              <span class="difficulty-stars">&#9733;&#9734;&#9734;&#9734;&#9734;</span>
            </div>
            <div class="snow-decoration"><i class="fas fa-clock"></i> {{ $tr('6 jours • Photo') }}</div>
          </div>
          <!-- Activité 6 -->
          <div class="hiver-activity-card">
            <span class="activity-icon-big"><i class="fas fa-hiking"></i></span>
            <h4 class="activity-name">{{ $tr('Raquettes nocturnes') }}</h4>
            <p class="activity-desc">
              {{ $tr('Randonnée en raquettes à la lumière des lampes frontales, dégustation de fondue savoyarde dans un refuge d\'altitude.') }}
            </p>
            <div class="activity-difficulte">
              <span>{{ $tr('Difficulté') }}</span>
              <span class="difficulty-stars">&#9733;&#9733;&#9734;&#9734;&#9734;</span>
            </div>
            <div class="snow-decoration"><i class="fas fa-clock"></i> {{ $tr('1 jour • France') }}</div>
          </div>
        </div>

        <div style="display: flex; justify-content: center;">
          <a href="#" class="btn-hiver-cta">
            <i class="fas fa-snowflake"></i> {{ $tr('Réserver une aventure hivernale') }}
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
