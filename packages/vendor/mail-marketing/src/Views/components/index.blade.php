<link rel="stylesheet" href="{{ asset('vendor/mail-marketing/css/style.css') }}">

<section class="mm">
<div class="mm-inner">

<!-- HEADER -->
<div class="mm-header">
  <div>
    <div class="mm-eyebrow"><span class="mm-eyebrow-dot"></span>Email Marketing Platform</div>
    <h1 class="mm-title">Transformez chaque email<br>en <em>opportunité réelle</em></h1>
    <p class="mm-sub">Créez, automatisez et analysez vos campagnes. Atteignez vos clients au bon moment avec le bon message — dans chaque secteur.</p>
  </div>
  <div class="mm-actions">
    <a href="#" class="btn-dark"><i class="fas fa-plus" style="font-size:12px"></i>En savor plus</a>
  </div>
</div>

<!-- STATS -->
<div class="mm-stats">
  <div class="mm-stat"><div class="mm-stat-n">98<sup>%</sup></div><div class="mm-stat-l">Délivrabilité garantie</div></div>
  <div class="mm-stat"><div class="mm-stat-n">4.2<sup>×</sup></div><div class="mm-stat-l">ROI moyen par campagne</div></div>
  <div class="mm-stat"><div class="mm-stat-n">12<sup>k+</sup></div><div class="mm-stat-l">Campagnes envoyées</div></div>
  <div class="mm-stat"><div class="mm-stat-n">38<sup>%</sup></div><div class="mm-stat-l">Taux d'ouverture moyen</div></div>
</div>

<!-- FILTER BAR -->
<div class="mm-filter-bar">
  <span class="mm-filter-label">Secteur :</span>
  <button class="mm-tab active" data-filter="all">Tous les secteurs <span class="mm-count" id="cnt-all">8</span></button>
  <button class="mm-tab" data-filter="retail">Retail & E-commerce <span class="mm-count">2</span></button>
  <button class="mm-tab" data-filter="immo">Immobilier <span class="mm-count">1</span></button>
  <button class="mm-tab" data-filter="travel">Tourisme & Voyages <span class="mm-count">1</span></button>
  <button class="mm-tab" data-filter="event">Événementiel <span class="mm-count">1</span></button>
  <button class="mm-tab" data-filter="b2b">B2B & Corporate <span class="mm-count">1</span></button>
  <button class="mm-tab" data-filter="auto">Automation IA <span class="mm-count">1</span></button>
  <button class="mm-tab" data-filter="info">Newsletters <span class="mm-count">1</span></button>
</div>

<!-- CARD GRID -->
<div class="mm-grid" id="cardGrid">

  <!-- ══ CARD 1 – Automation IA (wide, dark) ══ -->
  <div class="mcard mcard-wide th-dark" data-cat="auto">
    <div class="mc-vis">
      <div class="mc-vis-tag" style="color:rgba(255,255,255,.85)"><i class="fas fa-bolt" style="color:#f5a623;font-size:10px"></i>AUTOMATION IA</div>
      <!-- Rich SVG: email flow + AI brain -->
      <svg viewBox="0 0 760 220" xmlns="http://www.w3.org/2000/svg" width="760" height="220" preserveAspectRatio="xMidYMid slice">
        <!-- BG dots grid -->
        <defs>
          <pattern id="grid" width="28" height="28" patternUnits="userSpaceOnUse"><circle cx="1" cy="1" r="1" fill="rgba(255,255,255,.07)"/></pattern>
          <linearGradient id="gline" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#f5a623"/><stop offset="100%" stop-color="#2d5cc2"/></linearGradient>
          <linearGradient id="gbrain" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#2d5cc2" stop-opacity=".9"/><stop offset="100%" stop-color="#7c4dff" stop-opacity=".9"/></linearGradient>
        </defs>
        <rect width="760" height="220" fill="url(#grid)"/>
        <!-- Left: trigger node -->
        <rect x="30" y="80" width="110" height="56" rx="14" fill="rgba(255,255,255,.08)" stroke="rgba(255,255,255,.18)" stroke-width="1"/>
        <rect x="30" y="80" width="4" height="56" rx="2" fill="url(#gline)"/>
        <text x="52" y="108" fill="rgba(255,255,255,.5)" font-size="9" font-family="sans-serif" letter-spacing="1">TRIGGER</text>
        <text x="52" y="122" fill="white" font-size="11" font-family="sans-serif" font-weight="700">Inscription</text>
        <!-- Arrow 1 -->
        <path d="M140 108 L180 108" stroke="url(#gline)" stroke-width="1.5" stroke-dasharray="4,3"/>
        <polygon points="180,104 188,108 180,112" fill="#f5a623"/>
        <!-- Email node 1 -->
        <rect x="188" y="76" width="130" height="64" rx="14" fill="rgba(255,255,255,.1)" stroke="rgba(255,255,255,.18)" stroke-width="1"/>
        <circle cx="208" cy="108" r="12" fill="#f5a623" opacity=".9"/>
        <text x="208" y="113" fill="white" font-size="10" font-family="sans-serif" text-anchor="middle" font-weight="700">E1</text>
        <text x="228" y="100" fill="rgba(255,255,255,.5)" font-size="9" font-family="sans-serif">J+0 · Bienvenue</text>
        <text x="228" y="115" fill="white" font-size="11" font-family="sans-serif" font-weight="600">Taux ouv.</text>
        <text x="228" y="128" fill="#f5a623" font-size="13" font-family="sans-serif" font-weight="800">61%</text>
        <!-- Arrow 2 -->
        <path d="M318 108 L358 108" stroke="url(#gline)" stroke-width="1.5" stroke-dasharray="4,3"/>
        <polygon points="358,104 366,108 358,112" fill="#f5a623"/>
        <!-- AI Brain center node -->
        <rect x="366" y="60" width="100" height="100" rx="20" fill="url(#gbrain)" stroke="rgba(255,255,255,.22)" stroke-width="1.5"/>
        <text x="416" y="98" fill="white" font-size="26" text-anchor="middle" font-family="sans-serif">🧠</text>
        <text x="416" y="116" fill="rgba(255,255,255,.7)" font-size="9" font-family="sans-serif" text-anchor="middle" font-weight="700" letter-spacing="1">IA DECIDE</text>
        <text x="416" y="130" fill="white" font-size="10" font-family="sans-serif" text-anchor="middle" font-weight="600">Personnalise</text>
        <!-- Arrow 3 -->
        <path d="M466 108 L506 108" stroke="url(#gline)" stroke-width="1.5" stroke-dasharray="4,3"/>
        <polygon points="506,104 514,108 506,112" fill="#2d5cc2"/>
        <!-- Split nodes -->
        <path d="M514 108 L540 78" stroke="rgba(255,255,255,.25)" stroke-width="1.2" stroke-dasharray="3,3"/>
        <path d="M514 108 L540 138" stroke="rgba(255,255,255,.25)" stroke-width="1.2" stroke-dasharray="3,3"/>
        <!-- Node A -->
        <rect x="540" y="56" width="110" height="44" rx="12" fill="rgba(245,166,35,.18)" stroke="rgba(245,166,35,.4)" stroke-width="1"/>
        <text x="556" y="76" fill="rgba(255,255,255,.5)" font-size="9" font-family="sans-serif">Engagé →</text>
        <text x="556" y="90" fill="white" font-size="11" font-family="sans-serif" font-weight="700">Offre Upsell</text>
        <!-- Node B -->
        <rect x="540" y="118" width="110" height="44" rx="12" fill="rgba(45,92,194,.25)" stroke="rgba(45,92,194,.5)" stroke-width="1"/>
        <text x="556" y="138" fill="rgba(255,255,255,.5)" font-size="9" font-family="sans-serif">Inactif →</text>
        <text x="556" y="152" fill="white" font-size="11" font-family="sans-serif" font-weight="700">Réactivation</text>
        <!-- Conversion -->
        <path d="M650 78 L690 108" stroke="rgba(255,255,255,.2)" stroke-width="1.2" stroke-dasharray="3,3"/>
        <path d="M650 140 L690 108" stroke="rgba(255,255,255,.2)" stroke-width="1.2" stroke-dasharray="3,3"/>
        <rect x="690" y="87" width="60" height="42" rx="21" fill="#f5a623"/>
        <text x="720" y="112" fill="white" font-size="11" font-family="sans-serif" text-anchor="middle" font-weight="800">+47%</text>
        <!-- Labels bottom -->
        <text x="416" y="190" fill="rgba(255,255,255,.3)" font-size="10" font-family="sans-serif" text-anchor="middle">Séquence automatisée · Déclenchée par comportement · Optimisation en temps réel</text>
      </svg>
    </div>
    <div class="mc-body">
      <div class="mc-badge"><i class="fas fa-bolt" style="font-size:9px;color:#f5a623"></i>Automation IA</div>
      <div class="mc-title" style="color:#fff">Séquences email 100% automatisées</div>
      <p class="mc-desc">Configurez une fois, convertissez indéfiniment. Notre moteur IA analyse chaque comportement et personnalise en temps réel le contenu, le timing et la fréquence de chaque envoi.</p>
      <div class="mc-pills">
        <span class="mc-pill"><i class="fas fa-brain" style="font-size:10px;color:#7c4dff"></i>Optimisation IA</span>
        <span class="mc-pill"><i class="fas fa-clock" style="font-size:10px;color:#f5a623"></i>Timing intelligent</span>
        <span class="mc-pill"><i class="fas fa-code-branch" style="font-size:10px;color:#2d5cc2"></i>Segmentation auto</span>
        <span class="mc-pill"><i class="fas fa-chart-line" style="font-size:10px;color:#2fb34a"></i>A/B test continu</span>
      </div>
      <div class="mc-footer">
        <div class="mc-kpi">
          <div class="mc-kpi-ring">47</div>
          <div class="mc-kpi-info"><span class="mc-kpi-val">+47% conversions</span><span class="mc-kpi-key">vs campagnes manuelles</span></div>
        </div>
        <a href="#" class="mc-link">Voir l'automation <i class="fas fa-arrow-right" style="font-size:11px"></i></a>
      </div>
    </div>
  </div>

  <!-- ══ CARD 2 – Retail Panier abandonné ══ -->
  <div class="mcard th-g" data-cat="retail">
    <div class="mc-vis">
      <div class="mc-vis-tag" style="color:var(--g600)"><i class="fas fa-shopping-cart" style="font-size:9px;color:var(--g400)"></i>E-COMMERCE</div>
      <svg viewBox="0 0 380 220" xmlns="http://www.w3.org/2000/svg" width="380" height="220" preserveAspectRatio="xMidYMid slice">
        <defs><linearGradient id="gg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#edfaf0"/><stop offset="100%" stop-color="#b2e8bc"/></linearGradient></defs>
        <!-- Phone mockup -->
        <rect x="110" y="10" width="160" height="200" rx="22" fill="white" opacity=".95"/>
        <rect x="110" y="10" width="160" height="200" rx="22" stroke="rgba(47,179,74,.2)" stroke-width="1.5" fill="none"/>
        <!-- Status bar -->
        <rect x="110" y="10" width="160" height="38" rx="22" fill="var(--g400)" opacity=".9"/>
        <rect x="110" y="38" width="160" height="10" fill="var(--g400)" opacity=".9"/>
        <text x="190" y="32" fill="white" font-size="10" font-weight="700" font-family="sans-serif" text-anchor="middle" letter-spacing=".5">PANIER ABANDONNÉ</text>
        <!-- Product row -->
        <rect x="124" y="60" width="48" height="48" rx="10" fill="#edfaf0"/>
        <text x="148" y="90" font-size="26" text-anchor="middle" font-family="sans-serif">👟</text>
        <text x="183" y="76" fill="var(--ink)" font-size="11" font-weight="700" font-family="sans-serif">Nike Air Max</text>
        <text x="183" y="90" fill="var(--ink3)" font-size="10" font-family="sans-serif">Taille 42 · Blanc</text>
        <text x="183" y="104" fill="var(--g600)" font-size="13" font-weight="800" font-family="sans-serif">89,00 €</text>
        <!-- Timer -->
        <rect x="120" y="120" width="140" height="24" rx="12" fill="#fff3cd" stroke="#ffc107" stroke-width="1"/>
        <text x="190" y="136" fill="#856404" font-size="10" font-family="sans-serif" text-anchor="middle" font-weight="600">⏱ Expire dans 2h 14min</text>
        <!-- Coupon -->
        <rect x="120" y="152" width="140" height="20" rx="10" fill="#edfaf0" stroke="var(--g400)" stroke-width="1" stroke-dasharray="4,3"/>
        <text x="190" y="166" fill="var(--g600)" font-size="10" font-family="sans-serif" text-anchor="middle" font-weight="700">🎁 CODE: REVIENS10</text>
        <!-- CTA -->
        <rect x="124" y="182" width="132" height="20" rx="10" fill="var(--g400)"/>
        <text x="190" y="196" fill="white" font-size="10" font-family="sans-serif" text-anchor="middle" font-weight="700">Finaliser mon achat →</text>
        <!-- Floating badge -->
        <rect x="218" y="50" width="68" height="28" rx="14" fill="var(--g400)"/>
        <text x="252" y="68" fill="white" font-size="12" font-family="sans-serif" text-anchor="middle" font-weight="800">-10%</text>
        <!-- Stars decoration -->
        <text x="50" y="90" font-size="18" font-family="sans-serif" opacity=".4">✦</text>
        <text x="310" y="60" font-size="12" font-family="sans-serif" opacity=".3">✦</text>
        <text x="320" y="160" font-size="16" font-family="sans-serif" opacity=".25">✦</text>
      </svg>
    </div>
    <div class="mc-body">
      <div class="mc-badge"><i class="fas fa-shopping-cart" style="font-size:9px"></i>E-commerce</div>
      <div class="mc-title">Récupération de paniers abandonnés</div>
      <p class="mc-desc">Relancez automatiquement vos visiteurs avec des offres personnalisées, coupon de réduction et urgence intégrée pour maximiser vos ventes.</p>
      <div class="mc-pills">
        <span class="mc-pill">🎁 Coupon auto</span>
        <span class="mc-pill">⏱ Countdown timer</span>
        <span class="mc-pill">📱 Mobile-first</span>
      </div>
      <div class="mc-footer">
        <div class="mc-kpi">
          <div class="mc-kpi-ring">23</div>
          <div class="mc-kpi-info"><span class="mc-kpi-val">23% récupération</span><span class="mc-kpi-key">Taux de conversion</span></div>
        </div>
        <a href="#" class="mc-link">Explorer <i class="fas fa-arrow-right" style="font-size:11px"></i></a>
      </div>
    </div>
  </div>

  <!-- ══ CARD 3 – Newsletter Produits ══ -->
  <div class="mcard th-o" data-cat="info">
    <div class="mc-vis">
      <div class="mc-vis-tag" style="color:var(--o600)"><i class="fas fa-newspaper" style="font-size:9px;color:var(--o400)"></i>NEWSLETTER</div>
      <svg viewBox="0 0 380 220" xmlns="http://www.w3.org/2000/svg" width="380" height="220" preserveAspectRatio="xMidYMid slice">
        <!-- Email client mockup landscape -->
        <rect x="30" y="15" width="320" height="190" rx="16" fill="white" opacity=".92"/>
        <rect x="30" y="15" width="320" height="190" rx="16" stroke="rgba(245,166,35,.2)" stroke-width="1.5" fill="none"/>
        <!-- Header band -->
        <rect x="30" y="15" width="320" height="44" rx="16" fill="#08091a"/>
        <rect x="30" y="45" width="320" height="14" fill="#08091a"/>
        <!-- Logo + date -->
        <circle cx="55" cy="37" r="10" fill="var(--o400)"/>
        <text x="55" y="42" fill="white" font-size="11" text-anchor="middle" font-family="sans-serif" font-weight="800">G</text>
        <text x="74" y="34" fill="white" font-size="11" font-family="sans-serif" font-weight="700">EXPLORIA</text>
        <text x="74" y="46" fill="rgba(255,255,255,.45)" font-size="9" font-family="sans-serif">Newsletter · Novembre 2025</text>
        <!-- Hero text area -->
        <text x="46" y="84" fill="var(--ink)" font-size="13" font-family="sans-serif" font-weight="800">Les tendances du mois 🔥</text>
        <!-- 3 product mini-cards in a row -->
        <rect x="40" y="95" width="85" height="80" rx="10" fill="#fff8ed"/>
        <text x="82" y="130" font-size="28" text-anchor="middle" font-family="sans-serif">🎧</text>
        <text x="82" y="147" fill="var(--ink2)" font-size="9" text-anchor="middle" font-family="sans-serif" font-weight="600">Casque Pro</text>
        <text x="82" y="159" fill="var(--o600)" font-size="10" text-anchor="middle" font-family="sans-serif" font-weight="800">129 €</text>
        <rect x="135" y="95" width="85" height="80" rx="10" fill="#fff8ed"/>
        <text x="177" y="130" font-size="28" text-anchor="middle" font-family="sans-serif">📸</text>
        <text x="177" y="147" fill="var(--ink2)" font-size="9" text-anchor="middle" font-family="sans-serif" font-weight="600">Appareil</text>
        <text x="177" y="159" fill="var(--o600)" font-size="10" text-anchor="middle" font-family="sans-serif" font-weight="800">449 €</text>
        <rect x="230" y="95" width="85" height="80" rx="10" fill="#fff3cd"/>
        <rect x="252" y="98" width="40" height="14" rx="7" fill="var(--o400)"/>
        <text x="272" y="109" fill="white" font-size="8" text-anchor="middle" font-family="sans-serif" font-weight="800">-20%</text>
        <text x="272" y="130" font-size="28" text-anchor="middle" font-family="sans-serif">⌚</text>
        <text x="272" y="147" fill="var(--ink2)" font-size="9" text-anchor="middle" font-family="sans-serif" font-weight="600">Montre</text>
        <text x="272" y="159" fill="var(--o600)" font-size="10" text-anchor="middle" font-family="sans-serif" font-weight="800">199 €</text>
        <!-- CTA bottom -->
        <rect x="125" y="185" width="130" height="16" rx="8" fill="var(--o400)"/>
        <text x="190" y="197" fill="white" font-size="9" font-family="sans-serif" text-anchor="middle" font-weight="700">Voir toutes les offres</text>
        <!-- Open rate bubble -->
        <rect x="280" y="18" width="58" height="28" rx="14" fill="rgba(245,166,35,.15)" stroke="var(--o200)" stroke-width="1"/>
        <text x="309" y="36" fill="var(--o600)" font-size="12" text-anchor="middle" font-family="sans-serif" font-weight="800">42%</text>
      </svg>
    </div>
    <div class="mc-body">
      <div class="mc-badge"><i class="fas fa-tags" style="font-size:9px"></i>Newsletter</div>
      <div class="mc-title">Emails Produits & Newsletters</div>
      <p class="mc-desc">Promotions exclusives, nouveautés produits et newsletters thématiques pour fidéliser et inspirer votre audience à chaque envoi.</p>
      <div class="mc-pills">
        <span class="mc-pill">🎨 Templates éditoriaux</span>
        <span class="mc-pill">📊 Analytics détaillés</span>
      </div>
      <div class="mc-footer">
        <div class="mc-kpi">
          <div class="mc-kpi-ring">42</div>
          <div class="mc-kpi-info"><span class="mc-kpi-val">42% ouverture</span><span class="mc-kpi-key">Taux moyen constaté</span></div>
        </div>
        <a href="#" class="mc-link">Explorer <i class="fas fa-arrow-right" style="font-size:11px"></i></a>
      </div>
    </div>
  </div>

  <!-- ══ CARD 4 – Immobilier ══ -->
  <div class="mcard th-b" data-cat="immo">
    <div class="mc-vis">
      <div class="mc-vis-tag" style="color:var(--b600)"><i class="fas fa-building" style="font-size:9px;color:var(--b400)"></i>IMMOBILIER</div>
      <svg viewBox="0 0 380 220" xmlns="http://www.w3.org/2000/svg" width="380" height="220" preserveAspectRatio="xMidYMid slice">
        <defs><linearGradient id="skygrad" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" stop-color="#e8f0fe"/><stop offset="100%" stop-color="#c9d5fb"/></linearGradient></defs>
        <!-- Email frame -->
        <rect x="25" y="12" width="330" height="196" rx="16" fill="white" opacity=".92"/>
        <rect x="25" y="12" width="330" height="196" rx="16" stroke="rgba(45,92,194,.18)" stroke-width="1.5" fill="none"/>
        <!-- Top header dark -->
        <rect x="25" y="12" width="330" height="46" rx="16" fill="var(--b600)"/>
        <rect x="25" y="44" width="330" height="14" fill="var(--b600)"/>
        <text x="50" y="34" fill="white" font-size="12" font-family="sans-serif" font-weight="800">IMMO CONSEIL</text>
        <text x="50" y="48" fill="rgba(255,255,255,.5)" font-size="9" font-family="sans-serif">Alerte · Nouveau bien disponible</text>
        <rect x="298" y="22" width="46" height="18" rx="9" fill="rgba(255,255,255,.15)"/>
        <text x="321" y="34" fill="white" font-size="9" text-anchor="middle" font-family="sans-serif" font-weight="700">URGENT</text>
        <!-- Property image area -->
        <rect x="35" y="68" width="150" height="106" rx="12" fill="url(#skygrad)"/>
        <!-- Building illustration -->
        <rect x="55" y="110" width="30" height="50" rx="3" fill="var(--b400)" opacity=".5"/>
        <rect x="90" y="95" width="35" height="65" rx="3" fill="var(--b600)" opacity=".7"/>
        <rect x="130" y="105" width="28" height="55" rx="3" fill="var(--b400)" opacity=".6"/>
        <!-- Windows -->
        <rect x="60" y="115" width="8" height="8" rx="2" fill="white" opacity=".7"/>
        <rect x="72" y="115" width="8" height="8" rx="2" fill="white" opacity=".7"/>
        <rect x="60" y="127" width="8" height="8" rx="2" fill="var(--o400)" opacity=".8"/>
        <rect x="72" y="127" width="8" height="8" rx="2" fill="white" opacity=".7"/>
        <rect x="96" y="102" width="9" height="9" rx="2" fill="white" opacity=".7"/>
        <rect x="109" y="102" width="9" height="9" rx="2" fill="white" opacity=".4"/>
        <rect x="96" y="116" width="9" height="9" rx="2" fill="white" opacity=".6"/>
        <rect x="109" y="116" width="9" height="9" rx="2" fill="var(--o400)" opacity=".8"/>
        <!-- Ground -->
        <rect x="35" y="162" width="150" height="12" rx="0" fill="var(--b200)" opacity=".5"/>
        <!-- Price tag -->
        <rect x="38" y="70" width="72" height="22" rx="11" fill="var(--b600)"/>
        <text x="74" y="85" fill="white" font-size="11" text-anchor="middle" font-family="sans-serif" font-weight="800">350 000 €</text>
        <!-- Details panel right -->
        <text x="200" y="86" fill="var(--ink)" font-size="13" font-family="sans-serif" font-weight="800">Appartement T4</text>
        <text x="200" y="100" fill="var(--ink3)" font-size="10" font-family="sans-serif">Paris 11e · 92 m²</text>
        <!-- Tags row -->
        <rect x="200" y="110" width="40" height="16" rx="8" fill="var(--b50)"/>
        <text x="220" y="122" fill="var(--b600)" font-size="9" text-anchor="middle" font-family="sans-serif" font-weight="700">4 pièces</text>
        <rect x="246" y="110" width="44" height="16" rx="8" fill="var(--b50)"/>
        <text x="268" y="122" fill="var(--b600)" font-size="9" text-anchor="middle" font-family="sans-serif" font-weight="700">Terrasse</text>
        <rect x="296" y="110" width="44" height="16" rx="8" fill="var(--b50)"/>
        <text x="318" y="122" fill="var(--b600)" font-size="9" text-anchor="middle" font-family="sans-serif" font-weight="700">Parking</text>
        <!-- Info lines -->
        <rect x="200" y="135" width="140" height="5" rx="3" fill="var(--light-gray)" opacity=".5"/>
        <rect x="200" y="145" width="100" height="5" rx="3" fill="var(--light-gray)" opacity=".35"/>
        <!-- Mini map -->
        <rect x="200" y="158" width="60" height="36" rx="8" fill="#edf0ff"/>
        <circle cx="230" cy="176" r="10" fill="var(--b200)" stroke="var(--b400)" stroke-width="1.5"/>
        <circle cx="230" cy="176" r="4" fill="var(--b600)"/>
        <!-- CTAs -->
        <rect x="270" y="158" width="68" height="16" rx="8" fill="var(--b600)"/>
        <text x="304" y="169" fill="white" font-size="9" text-anchor="middle" font-family="sans-serif" font-weight="700">Voir bien →</text>
        <rect x="270" y="178" width="68" height="16" rx="8" fill="var(--b50)" stroke="var(--b200)" stroke-width="1"/>
        <text x="304" y="189" fill="var(--b600)" font-size="9" text-anchor="middle" font-family="sans-serif" font-weight="700">Visite virtuelle</text>
      </svg>
    </div>
    <div class="mc-body">
      <div class="mc-badge"><i class="fas fa-building" style="font-size:9px"></i>Immobilier</div>
      <div class="mc-title">Alertes & Annonces Immobilières</div>
      <p class="mc-desc">Alertes prix personnalisées, fiches biens détaillées avec carte interactive, visites virtuelles et comparatifs de marché pour vos prospects.</p>
      <div class="mc-pills">
        <span class="mc-pill">🗺️ Carte interactive</span>
        <span class="mc-pill">🎥 Visite virtuelle</span>
        <span class="mc-pill">📈 Tendances prix</span>
      </div>
      <div class="mc-footer">
        <div class="mc-kpi">
          <div class="mc-kpi-ring">18</div>
          <div class="mc-kpi-info"><span class="mc-kpi-val">18% conversion</span><span class="mc-kpi-key">Prises de contact</span></div>
        </div>
        <a href="#" class="mc-link">Explorer <i class="fas fa-arrow-right" style="font-size:11px"></i></a>
      </div>
    </div>
  </div>

  <!-- ══ CARD 5 – Voyages ══ -->
  <div class="mcard th-t" data-cat="travel">
    <div class="mc-vis">
      <div class="mc-vis-tag" style="color:var(--t600)"><i class="fas fa-plane-departure" style="font-size:9px;color:var(--t400)"></i>TOURISME</div>
      <svg viewBox="0 0 380 220" xmlns="http://www.w3.org/2000/svg" width="380" height="220" preserveAspectRatio="xMidYMid slice">
        <defs>
          <linearGradient id="sky2" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" stop-color="#b3e5fc"/><stop offset="100%" stop-color="#e5f8f4"/></linearGradient>
          <clipPath id="cp1"><rect x="25" y="12" width="330" height="196" rx="16"/></clipPath>
        </defs>
        <!-- Card frame -->
        <rect x="25" y="12" width="330" height="196" rx="16" fill="white" opacity=".9"/>
        <rect x="25" y="12" width="330" height="196" rx="16" stroke="rgba(0,184,156,.2)" stroke-width="1.5" fill="none"/>
        <!-- Sky hero zone -->
        <rect x="25" y="12" width="330" height="120" rx="16" fill="url(#sky2)" clip-path="url(#cp1)"/>
        <rect x="25" y="112" width="330" height="20" fill="url(#sky2)" clip-path="url(#cp1)"/>
        <!-- Clouds -->
        <ellipse cx="80" cy="45" rx="35" ry="16" fill="white" opacity=".7"/>
        <ellipse cx="100" cy="40" rx="25" ry="14" fill="white" opacity=".6"/>
        <ellipse cx="280" cy="55" rx="28" ry="12" fill="white" opacity=".6"/>
        <ellipse cx="300" cy="50" rx="20" ry="10" fill="white" opacity=".55"/>
        <!-- Plane path dashed -->
        <path d="M60 100 Q190 40 320 70" stroke="rgba(0,184,156,.4)" stroke-width="1.5" stroke-dasharray="6,4" fill="none"/>
        <!-- Plane -->
        <text x="195" y="58" font-size="26" text-anchor="middle" font-family="sans-serif" transform="rotate(-20,195,58)">✈️</text>
        <!-- City markers -->
        <circle cx="70" cy="100" r="6" fill="var(--t400)"/><circle cx="70" cy="100" r="3" fill="white"/>
        <text x="70" y="116" fill="var(--ink2)" font-size="9" text-anchor="middle" font-family="sans-serif" font-weight="700">Paris</text>
        <circle cx="316" cy="72" r="6" fill="var(--o400)"/><circle cx="316" cy="72" r="3" fill="white"/>
        <text x="316" y="88" fill="var(--ink2)" font-size="9" text-anchor="middle" font-family="sans-serif" font-weight="700">Bali</text>
        <!-- Header title -->
        <rect x="25" y="12" width="330" height="34" rx="16" fill="var(--t600)" opacity=".85"/>
        <rect x="25" y="36" width="330" height="10" fill="var(--t600)" opacity=".85"/>
        <text x="55" y="31" fill="white" font-size="11" font-family="sans-serif" font-weight="800" letter-spacing=".5">OFFRE LAST MINUTE 🌴</text>
        <!-- Bottom info row -->
        <rect x="35" y="138" width="145" height="60" rx="10" fill="#e5f8f4"/>
        <text x="107" y="156" fill="var(--t600)" font-size="10" text-anchor="middle" font-family="sans-serif" font-weight="700">Paris → Bali</text>
        <text x="107" y="170" fill="var(--ink3)" font-size="9" text-anchor="middle" font-family="sans-serif">Aller-retour · 10 nuits</text>
        <text x="107" y="186" fill="var(--t600)" font-size="16" text-anchor="middle" font-family="sans-serif" font-weight="800">899 €</text>
        <!-- Discount badge -->
        <rect x="152" y="140" width="40" height="20" rx="10" fill="var(--r400)"/>
        <text x="172" y="154" fill="white" font-size="11" text-anchor="middle" font-family="sans-serif" font-weight="800">-42%</text>
        <!-- Amenities -->
        <rect x="190" y="138" width="155" height="60" rx="10" fill="#f0fffe"/>
        <text x="268" y="154" fill="var(--ink2)" font-size="9" text-anchor="middle" font-family="sans-serif" font-weight="700">Inclus dans l'offre :</text>
        <text x="200" y="166" fill="var(--ink3)" font-size="9" font-family="sans-serif">✓ Vol direct</text>
        <text x="200" y="177" fill="var(--ink3)" font-size="9" font-family="sans-serif">✓ Hôtel 4★ all inclusive</text>
        <text x="200" y="188" fill="var(--ink3)" font-size="9" font-family="sans-serif">✓ Transferts offerts</text>
        <!-- CTA -->
        <rect x="80" y="206" width="220" height="0" rx="0" fill="none"/>
      </svg>
    </div>
    <div class="mc-body">
      <div class="mc-badge"><i class="fas fa-plane" style="font-size:9px"></i>Tourisme</div>
      <div class="mc-title">Emails Voyages & Offres Last Minute</div>
      <p class="mc-desc">Offres personnalisées selon les destinations favorites, itinéraires sur mesure, alertes prix et inspirations saisonnières avec visuel immersif.</p>
      <div class="mc-pills">
        <span class="mc-pill">🌍 Destinations ciblées</span>
        <span class="mc-pill">🔔 Alertes prix</span>
        <span class="mc-pill">🗓️ Calendrier dispo</span>
      </div>
      <div class="mc-footer">
        <div class="mc-kpi">
          <div class="mc-kpi-ring">35</div>
          <div class="mc-kpi-info"><span class="mc-kpi-val">35% engagement</span><span class="mc-kpi-key">Clics sur offres</span></div>
        </div>
        <a href="#" class="mc-link">Explorer <i class="fas fa-arrow-right" style="font-size:11px"></i></a>
      </div>
    </div>
  </div>

  <!-- ══ CARD 6 – Événementiel ══ -->
  <div class="mcard th-r" data-cat="event">
    <div class="mc-vis">
      <div class="mc-vis-tag" style="color:var(--r600)"><i class="fas fa-calendar-star" style="font-size:9px;color:var(--r400)"></i>ÉVÉNEMENTIEL</div>
      <svg viewBox="0 0 380 220" xmlns="http://www.w3.org/2000/svg" width="380" height="220" preserveAspectRatio="xMidYMid slice">
        <defs><linearGradient id="rgrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#feeef4"/><stop offset="100%" stop-color="#fac6db"/></linearGradient></defs>
        <!-- Invitation card styled -->
        <rect x="55" y="10" width="270" height="200" rx="18" fill="white" opacity=".95"/>
        <rect x="55" y="10" width="270" height="200" rx="18" stroke="rgba(232,65,122,.2)" stroke-width="1.5" fill="none"/>
        <!-- Gold/rose top bar -->
        <rect x="55" y="10" width="270" height="50" rx="18" fill="var(--r400)" opacity=".9"/>
        <rect x="55" y="46" width="270" height="14" fill="var(--r400)" opacity=".9"/>
        <!-- Confetti deco on header -->
        <circle cx="80" cy="28" r="4" fill="var(--o400)" opacity=".8"/>
        <circle cx="300" cy="22" r="3" fill="white" opacity=".6"/>
        <circle cx="315" cy="36" r="5" fill="var(--o200)" opacity=".7"/>
        <rect x="88" y="16" width="6" height="6" rx="1" fill="white" opacity=".5" transform="rotate(20,88,16)"/>
        <rect x="275" y="30" width="5" height="5" rx="1" fill="var(--o300)" opacity=".6" transform="rotate(35,275,30)"/>
        <text x="190" y="32" fill="white" font-size="11" font-family="sans-serif" text-anchor="middle" font-weight="800" letter-spacing="1.5">✉ VOUS ÊTES INVITÉ</text>
        <text x="190" y="48" fill="rgba(255,255,255,.7)" font-size="9" font-family="sans-serif" text-anchor="middle">Événement exclusif · Accès limité</text>
        <!-- Calendar widget -->
        <rect x="80" y="72" width="72" height="72" rx="14" fill="#feeef4" stroke="var(--r200)" stroke-width="1"/>
        <rect x="80" y="72" width="72" height="22" rx="14" fill="var(--r400)" stroke="none"/>
        <rect x="80" y="84" width="72" height="10" fill="var(--r400)"/>
        <text x="116" y="88" fill="white" font-size="9" text-anchor="middle" font-family="sans-serif" font-weight="700">JUIN 2025</text>
        <text x="116" y="124" fill="var(--r400)" font-size="30" text-anchor="middle" font-family="sans-serif" font-weight="800">28</text>
        <!-- Location + time -->
        <text x="168" y="84" fill="var(--ink2)" font-size="11" font-family="sans-serif" font-weight="700">Gala Annuel 2025</text>
        <text x="168" y="98" fill="var(--ink3)" font-size="9" font-family="sans-serif">📍 Hôtel Le Meurice, Paris</text>
        <text x="168" y="111" fill="var(--ink3)" font-size="9" font-family="sans-serif">🕖 19h00 · Cocktail dînatoire</text>
        <!-- Divider -->
        <line x1="72" y1="152" x2="308" y2="152" stroke="var(--r100)" stroke-width="1" stroke-dasharray="6,4"/>
        <!-- RSVP badges -->
        <rect x="72" y="160" width="72" height="20" rx="10" fill="var(--r400)"/>
        <text x="108" y="174" fill="white" font-size="10" text-anchor="middle" font-family="sans-serif" font-weight="700">Je confirme ✓</text>
        <rect x="152" y="160" width="72" height="20" rx="10" fill="#feeef4" stroke="var(--r200)" stroke-width="1"/>
        <text x="188" y="174" fill="var(--r400)" font-size="10" text-anchor="middle" font-family="sans-serif" font-weight="700">Je décline</text>
        <!-- QR code mini -->
        <rect x="240" y="158" width="32" height="32" rx="6" fill="var(--ink)" opacity=".07"/>
        <text x="256" y="178" font-size="18" text-anchor="middle" font-family="sans-serif" opacity=".25">▦</text>
        <!-- Floating badges -->
        <rect x="64" y="14" width="0" height="0" fill="none"/>
        <text x="20" y="70" font-size="22" font-family="sans-serif" opacity=".2">✦</text>
        <text x="340" y="160" font-size="16" font-family="sans-serif" opacity=".2">✦</text>
        <text x="340" y="50" font-size="12" font-family="sans-serif" opacity=".18">✦</text>
      </svg>
    </div>
    <div class="mc-body">
      <div class="mc-badge"><i class="fas fa-calendar-alt" style="font-size:9px"></i>Événementiel</div>
      <div class="mc-title">Invitations & Gestion d'Événements</div>
      <p class="mc-desc">Invitations élégantes, rappels automatiques, gestion RSVP intégrée, QR code d'accès et feedback post-événement pour maximiser votre impact.</p>
      <div class="mc-pills">
        <span class="mc-pill">🎫 RSVP en ligne</span>
        <span class="mc-pill">📲 QR code accès</span>
        <span class="mc-pill">⚡ Rappels auto</span>
      </div>
      <div class="mc-footer">
        <div class="mc-kpi">
          <div class="mc-kpi-ring">28</div>
          <div class="mc-kpi-info"><span class="mc-kpi-val">28% participation</span><span class="mc-kpi-key">Taux RSVP confirmé</span></div>
        </div>
        <a href="#" class="mc-link">Explorer <i class="fas fa-arrow-right" style="font-size:11px"></i></a>
      </div>
    </div>
  </div>

  <!-- ══ CARD 7 – B2B Corporate (wide) ══ -->
  <div class="mcard mcard-wide th-p" data-cat="b2b">
    <div class="mc-vis" style="height:260px">
      <div class="mc-vis-tag" style="color:var(--p600)"><i class="fas fa-briefcase" style="font-size:9px;color:var(--p400)"></i>B2B & CORPORATE</div>
      <svg viewBox="0 0 760 260" xmlns="http://www.w3.org/2000/svg" width="760" height="260" preserveAspectRatio="xMidYMid slice">
        <defs>
          <linearGradient id="pgrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#f2eeff"/><stop offset="100%" stop-color="#d0c1f8"/></linearGradient>
          <linearGradient id="pbar" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" stop-color="#7c4dff"/><stop offset="100%" stop-color="#4a20cc"/></linearGradient>
        </defs>
        <!-- Left: Rapport email mockup -->
        <rect x="25" y="15" width="320" height="230" rx="16" fill="white" opacity=".92"/>
        <rect x="25" y="15" width="320" height="230" rx="16" stroke="rgba(124,77,255,.18)" stroke-width="1.5" fill="none"/>
        <!-- Header -->
        <rect x="25" y="15" width="320" height="42" rx="16" fill="#08091a"/>
        <rect x="25" y="45" width="320" height="12" fill="#08091a"/>
        <circle cx="47" cy="36" r="9" fill="var(--p400)"/>
        <text x="47" y="41" fill="white" font-size="9" text-anchor="middle" font-family="sans-serif" font-weight="700">G</text>
        <text x="65" y="33" fill="white" font-size="11" font-family="sans-serif" font-weight="700">RAPPORT Q4 2024</text>
        <text x="65" y="46" fill="rgba(255,255,255,.4)" font-size="8.5" font-family="sans-serif">Analyse de performance · Confidentiel</text>
        <!-- KPI row -->
        <rect x="35" y="68" width="68" height="44" rx="10" fill="var(--p50)"/>
        <text x="69" y="87" fill="var(--p400)" font-size="16" text-anchor="middle" font-family="sans-serif" font-weight="800">+31%</text>
        <text x="69" y="100" fill="var(--ink3)" font-size="8" text-anchor="middle" font-family="sans-serif">ROI Campagnes</text>
        <rect x="113" y="68" width="68" height="44" rx="10" fill="var(--g50)"/>
        <text x="147" y="87" fill="var(--g600)" font-size="16" text-anchor="middle" font-family="sans-serif" font-weight="800">128</text>
        <text x="147" y="100" fill="var(--ink3)" font-size="8" text-anchor="middle" font-family="sans-serif">Leads qualifiés</text>
        <rect x="191" y="68" width="68" height="44" rx="10" fill="var(--o50)"/>
        <text x="225" y="87" fill="var(--o600)" font-size="16" text-anchor="middle" font-family="sans-serif" font-weight="800">4.7★</text>
        <text x="225" y="100" fill="var(--ink3)" font-size="8" text-anchor="middle" font-family="sans-serif">Satisfaction</text>
        <rect x="269" y="68" width="65" height="44" rx="10" fill="var(--b50)"/>
        <text x="301" y="87" fill="var(--b600)" font-size="14" text-anchor="middle" font-family="sans-serif" font-weight="800">41%↑</text>
        <text x="301" y="100" fill="var(--ink3)" font-size="8" text-anchor="middle" font-family="sans-serif">Engagement</text>
        <!-- Bar chart -->
        <text x="35" y="130" fill="var(--ink2)" font-size="10" font-family="sans-serif" font-weight="700">Performance mensuelle</text>
        <!-- Chart bars -->
        <rect x="42" y="175" width="24" height="30" rx="5" fill="var(--p200)"/>
        <rect x="74" y="158" width="24" height="47" rx="5" fill="var(--p300)" opacity=".7"/>
        <rect x="106" y="145" width="24" height="60" rx="5" fill="var(--p400)"/>
        <rect x="138" y="138" width="24" height="67" rx="5" fill="var(--p400)" opacity=".9"/>
        <rect x="170" y="148" width="24" height="57" rx="5" fill="var(--p400)" opacity=".75"/>
        <rect x="202" y="133" width="24" height="72" rx="5" fill="url(#pbar)"/>
        <rect x="234" y="140" width="24" height="65" rx="5" fill="url(#pbar)" opacity=".85"/>
        <rect x="266" y="128" width="24" height="77" rx="5" fill="url(#pbar)"/>
        <rect x="298" y="135" width="24" height="70" rx="5" fill="url(#pbar)" opacity=".9"/>
        <!-- Baseline -->
        <rect x="35" y="205" width="300" height="1" rx="1" fill="var(--p100)" opacity=".8"/>
        <!-- Month labels -->
        <text x="54" y="216" fill="var(--ink3)" font-size="8" text-anchor="middle" font-family="sans-serif">Avr</text>
        <text x="86" y="216" fill="var(--ink3)" font-size="8" text-anchor="middle" font-family="sans-serif">Mai</text>
        <text x="118" y="216" fill="var(--ink3)" font-size="8" text-anchor="middle" font-family="sans-serif">Jun</text>
        <text x="150" y="216" fill="var(--ink3)" font-size="8" text-anchor="middle" font-family="sans-serif">Jul</text>
        <text x="182" y="216" fill="var(--ink3)" font-size="8" text-anchor="middle" font-family="sans-serif">Aoû</text>
        <text x="214" y="216" fill="var(--ink3)" font-size="8" text-anchor="middle" font-family="sans-serif">Sep</text>
        <text x="246" y="216" fill="var(--ink3)" font-size="8" text-anchor="middle" font-family="sans-serif">Oct</text>
        <text x="278" y="216" fill="var(--ink3)" font-size="8" text-anchor="middle" font-family="sans-serif">Nov</text>
        <text x="310" y="216" fill="var(--ink3)" font-size="8" text-anchor="middle" font-family="sans-serif">Dec</text>
        <!-- Trend line -->
        <polyline points="54,195 86,178 118,163 150,155 182,165 214,148 246,155 278,142 310,150" stroke="var(--o400)" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" opacity=".8"/>
        <circle cx="278" cy="142" r="4" fill="var(--o400)"/>
        <circle cx="310" cy="150" r="4" fill="var(--o400)"/>
        <!-- Annotation -->
        <rect x="245" y="128" width="56" height="14" rx="7" fill="var(--o400)" opacity=".15"/>
        <text x="273" y="139" fill="var(--o600)" font-size="8.5" text-anchor="middle" font-family="sans-serif" font-weight="700">Meilleur mois</text>

        <!-- Right panel: LinkedIn-style email preview -->
        <rect x="370" y="15" width="370" height="230" rx="16" fill="white" opacity=".88"/>
        <rect x="370" y="15" width="370" height="230" rx="16" stroke="rgba(124,77,255,.15)" stroke-width="1.5" fill="none"/>
        <!-- Profile header -->
        <circle cx="400" cy="50" r="22" fill="var(--p50)" stroke="var(--p200)" stroke-width="1.5"/>
        <text x="400" y="56" fill="var(--p600)" font-size="16" text-anchor="middle" font-family="sans-serif" font-weight="800">ML</text>
        <text x="432" y="40" fill="var(--ink)" font-size="12" font-family="sans-serif" font-weight="700">Marie Laurent</text>
        <text x="432" y="53" fill="var(--ink3)" font-size="10" font-family="sans-serif">DG · Acme Corp</text>
        <text x="432" y="66" fill="var(--ink3)" font-size="9" font-family="sans-serif">📅 Ouvert le 14/11 · 09:14</text>
        <!-- Content preview -->
        <rect x="383" y="80" width="344" height="1" fill="var(--p100)" opacity=".6"/>
        <text x="383" y="100" fill="var(--ink)" font-size="11.5" font-family="sans-serif" font-weight="700">Rapport d'analyse : Vos performances Q4</text>
        <rect x="383" y="108" width="310" height="6" rx="3" fill="var(--p50)"/>
        <rect x="383" y="119" width="260" height="6" rx="3" fill="var(--p50)"/>
        <rect x="383" y="130" width="290" height="6" rx="3" fill="var(--p50)"/>
        <!-- Featured insight box -->
        <rect x="383" y="148" width="344" height="50" rx="10" fill="var(--p50)" stroke="var(--p200)" stroke-width="1"/>
        <rect x="383" y="148" width="4" height="50" rx="2" fill="var(--p400)"/>
        <text x="397" y="166" fill="var(--p600)" font-size="10" font-family="sans-serif" font-weight="700">💡 Insight clé du trimestre</text>
        <text x="397" y="180" fill="var(--ink3)" font-size="9.5" font-family="sans-serif">Vos emails B2B ont généré 128 leads qualifiés,</text>
        <text x="397" y="192" fill="var(--ink3)" font-size="9.5" font-family="sans-serif">soit +31% vs T3 2024.</text>
        <!-- CTA row -->
        <rect x="383" y="208" width="140" height="22" rx="11" fill="url(#pbar)"/>
        <text x="453" y="223" fill="white" font-size="10" text-anchor="middle" font-family="sans-serif" font-weight="700">Voir rapport complet</text>
        <rect x="533" y="208" width="110" height="22" rx="11" fill="var(--p50)" stroke="var(--p200)" stroke-width="1"/>
        <text x="588" y="223" fill="var(--p600)" font-size="10" text-anchor="middle" font-family="sans-serif" font-weight="700">Partager l'équipe</text>
      </svg>
    </div>
    <div class="mc-body">
      <div class="mc-badge"><i class="fas fa-briefcase" style="font-size:9px"></i>B2B & Corporate</div>
      <div class="mc-title">Emails B2B, Rapports & Lead Nurturing</div>
      <p class="mc-desc">Newsletters corporate, rapports analytiques personnalisés, études de cas interactives, webinaires et séquences de nurturing longues durée pour décideurs et équipes commerciales.</p>
      <div class="mc-pills">
        <span class="mc-pill">📊 Rapports auto</span>
        <span class="mc-pill">🤝 Lead nurturing</span>
        <span class="mc-pill">🎙️ Webinaire intégré</span>
        <span class="mc-pill">🔐 Contenu premium</span>
      </div>
      <div class="mc-footer">
        <div class="mc-kpi">
          <div class="mc-kpi-ring">31</div>
          <div class="mc-kpi-info"><span class="mc-kpi-val">31% taux de clic</span><span class="mc-kpi-key">Audience décideurs</span></div>
        </div>
        <a href="#" class="mc-link">Explorer <i class="fas fa-arrow-right" style="font-size:11px"></i></a>
      </div>
    </div>
  </div>

  <!-- ══ CARD 8 – Retail Ventes Flash ══ -->
  <div class="mcard th-g" data-cat="retail">
    <div class="mc-vis">
      <div class="mc-vis-tag" style="color:var(--g600)"><i class="fas fa-bolt" style="font-size:9px;color:var(--g400)"></i>VENTE FLASH</div>
      <svg viewBox="0 0 380 220" xmlns="http://www.w3.org/2000/svg" width="380" height="220" preserveAspectRatio="xMidYMid slice">
        <defs><linearGradient id="flash" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#edfaf0"/><stop offset="100%" stop-color="#b2e8bc"/></linearGradient></defs>
        <!-- Dark promo email look -->
        <rect x="30" y="10" width="320" height="200" rx="16" fill="#08091a" opacity=".96"/>
        <rect x="30" y="10" width="320" height="200" rx="16" stroke="rgba(47,179,74,.3)" stroke-width="1.5" fill="none"/>
        <!-- Header -->
        <rect x="30" y="10" width="320" height="48" rx="16" fill="var(--g400)"/>
        <rect x="30" y="44" width="320" height="14" fill="var(--g400)"/>
        <text x="190" y="28" fill="white" font-size="14" font-family="sans-serif" font-weight="800" text-anchor="middle" letter-spacing="1">⚡ VENTE FLASH</text>
        <text x="190" y="46" fill="rgba(255,255,255,.7)" font-size="10" font-family="sans-serif" text-anchor="middle">Offres disponibles uniquement aujourd'hui</text>
        <!-- Countdown display -->
        <rect x="70" y="68" width="55" height="46" rx="10" fill="rgba(255,255,255,.07)" stroke="rgba(47,179,74,.3)" stroke-width="1"/>
        <text x="97" y="92" fill="white" font-size="20" text-anchor="middle" font-family="sans-serif" font-weight="800">04</text>
        <text x="97" y="106" fill="var(--g400)" font-size="8" text-anchor="middle" font-family="sans-serif">HEURES</text>
        <text x="136" y="95" fill="var(--g400)" font-size="18" font-family="sans-serif" font-weight="800" text-anchor="middle">:</text>
        <rect x="148" y="68" width="55" height="46" rx="10" fill="rgba(255,255,255,.07)" stroke="rgba(47,179,74,.3)" stroke-width="1"/>
        <text x="175" y="92" fill="white" font-size="20" text-anchor="middle" font-family="sans-serif" font-weight="800">27</text>
        <text x="175" y="106" fill="var(--g400)" font-size="8" text-anchor="middle" font-family="sans-serif">MINUTES</text>
        <text x="214" y="95" fill="var(--g400)" font-size="18" font-family="sans-serif" font-weight="800" text-anchor="middle">:</text>
        <rect x="226" y="68" width="55" height="46" rx="10" fill="rgba(255,255,255,.07)" stroke="rgba(47,179,74,.3)" stroke-width="1"/>
        <text x="253" y="92" fill="white" font-size="20" text-anchor="middle" font-family="sans-serif" font-weight="800">43</text>
        <text x="253" y="106" fill="var(--g400)" font-size="8" text-anchor="middle" font-family="sans-serif">SECONDES</text>
        <!-- Products row -->
        <rect x="40" y="124" width="85" height="58" rx="10" fill="rgba(255,255,255,.05)" stroke="rgba(47,179,74,.2)" stroke-width="1"/>
        <text x="82" y="148" font-size="22" text-anchor="middle" font-family="sans-serif">👗</text>
        <text x="82" y="162" fill="rgba(255,255,255,.8)" font-size="10" text-anchor="middle" font-family="sans-serif" font-weight="600">Robe</text>
        <text x="82" y="174" fill="var(--g400)" font-size="11" text-anchor="middle" font-family="sans-serif" font-weight="800">49 €</text>
        <rect x="138" y="124" width="85" height="58" rx="10" fill="rgba(255,255,255,.05)" stroke="rgba(47,179,74,.2)" stroke-width="1"/>
        <text x="180" y="148" font-size="22" text-anchor="middle" font-family="sans-serif">👜</text>
        <text x="180" y="162" fill="rgba(255,255,255,.8)" font-size="10" text-anchor="middle" font-family="sans-serif" font-weight="600">Sac</text>
        <text x="180" y="174" fill="var(--g400)" font-size="11" text-anchor="middle" font-family="sans-serif" font-weight="800">89 €</text>
        <rect x="236" y="124" width="85" height="58" rx="10" fill="rgba(255,255,255,.08)" stroke="rgba(47,179,74,.35)" stroke-width="1.5"/>
        <text x="278" y="144" font-size="22" text-anchor="middle" font-family="sans-serif">⌚</text>
        <text x="278" y="158" fill="rgba(255,255,255,.8)" font-size="10" text-anchor="middle" font-family="sans-serif" font-weight="600">Montre</text>
        <rect x="250" y="162" width="56" height="14" rx="7" fill="var(--g400)"/>
        <text x="278" y="173" fill="white" font-size="9" text-anchor="middle" font-family="sans-serif" font-weight="700">129 € → 79 €</text>
        <!-- Sold out progress -->
        <text x="40" y="194" fill="rgba(255,255,255,.4)" font-size="9" font-family="sans-serif">Stock restant :</text>
        <rect x="116" y="187" width="130" height="6" rx="3" fill="rgba(255,255,255,.1)"/>
        <rect x="116" y="187" width="38" height="6" rx="3" fill="var(--r400)"/>
        <text x="252" y="195" fill="var(--r400)" font-size="9" font-family="sans-serif" font-weight="700">29%</text>
      </svg>
    </div>
    <div class="mc-body">
      <div class="mc-badge"><i class="fas fa-fire" style="font-size:9px"></i>E-commerce</div>
      <div class="mc-title">Ventes Flash & Promotions Urgentes</div>
      <p class="mc-desc">Emails sombres et percutants avec countdown en temps réel, barre de stock restant et offres à durée limitée pour créer l'urgence d'achat.</p>
      <div class="mc-pills">
        <span class="mc-pill">⏱ Countdown live</span>
        <span class="mc-pill">📉 Barre de stock</span>
        <span class="mc-pill">🌑 Dark email design</span>
      </div>
      <div class="mc-footer">
        <div class="mc-kpi">
          <div class="mc-kpi-ring">41</div>
          <div class="mc-kpi-info"><span class="mc-kpi-val">41% clics</span><span class="mc-kpi-key">Taux urgence activée</span></div>
        </div>
        <a href="#" class="mc-link">Explorer <i class="fas fa-arrow-right" style="font-size:11px"></i></a>
      </div>
    </div>
  </div>

  <!-- Empty state -->
  <div class="mm-empty" id="emptyState">
    <i class="fas fa-inbox"></i>
    <p>Aucun template disponible pour ce filtre.</p>
  </div>

</div><!-- /mm-grid -->

<!-- PROCESS STRIP -->
<div class="mm-process">
  <div class="mm-step">
    <div class="mm-step-n">Étape 01</div>
    <div class="mm-step-ico" style="background:#fff8ed">🎯</div>
    <div class="mm-step-t">Définissez votre audience</div>
    <p class="mm-step-d">Segmentez selon le comportement, le secteur et l'historique d'engagement.</p>
    <div class="mm-step-arr">›</div>
  </div>
  <div class="mm-step">
    <div class="mm-step-n">Étape 02</div>
    <div class="mm-step-ico" style="background:#edf0ff">✏️</div>
    <div class="mm-step-t">Créez votre campagne</div>
    <p class="mm-step-d">Templates professionnels ou design sur mesure via notre éditeur drag & drop.</p>
    <div class="mm-step-arr">›</div>
  </div>
  <div class="mm-step">
    <div class="mm-step-n">Étape 03</div>
    <div class="mm-step-ico" style="background:#e5f8f4">🤖</div>
    <div class="mm-step-t">Automatisez l'envoi</div>
    <p class="mm-step-d">Déclenchez selon les actions. L'IA optimise le timing en continu.</p>
    <div class="mm-step-arr">›</div>
  </div>
  <div class="mm-step">
    <div class="mm-step-n">Étape 04</div>
    <div class="mm-step-ico" style="background:#edfaf0">📊</div>
    <div class="mm-step-t">Analysez & optimisez</div>
    <p class="mm-step-d">Dashboard temps réel, A/B test automatique et recommandations IA.</p>
  </div>
</div>

<!-- MARQUEE -->
<div class="mm-mq-wrap">
  <p class="mm-mq-label">Ils optimisent leurs campagnes avec Go Exploria</p>
  <div class="mm-mq-track">
    <div class="mm-logo-pill"><i class="fas fa-store"></i>Retail Plus</div>
    <div class="mm-logo-pill"><i class="fas fa-home"></i>Immo Conseil</div>
    <div class="mm-logo-pill"><i class="fas fa-globe"></i>World Travel</div>
    <div class="mm-logo-pill"><i class="fas fa-champagne-glasses"></i>Event Factory</div>
    <div class="mm-logo-pill"><i class="fas fa-box"></i>Shop Express</div>
    <div class="mm-logo-pill"><i class="fas fa-handshake"></i>B2B Connect</div>
    <div class="mm-logo-pill"><i class="fas fa-plane"></i>Air Voyages</div>
    <div class="mm-logo-pill"><i class="fas fa-hotel"></i>Séjours Pro</div>
    <div class="mm-logo-pill"><i class="fas fa-chart-line"></i>GrowthLabs</div>
    <div class="mm-logo-pill"><i class="fas fa-building"></i>Bâti Invest</div>
    <div class="mm-logo-pill"><i class="fas fa-store"></i>Retail Plus</div>
    <div class="mm-logo-pill"><i class="fas fa-home"></i>Immo Conseil</div>
    <div class="mm-logo-pill"><i class="fas fa-globe"></i>World Travel</div>
    <div class="mm-logo-pill"><i class="fas fa-champagne-glasses"></i>Event Factory</div>
    <div class="mm-logo-pill"><i class="fas fa-box"></i>Shop Express</div>
    <div class="mm-logo-pill"><i class="fas fa-handshake"></i>B2B Connect</div>
    <div class="mm-logo-pill"><i class="fas fa-plane"></i>Air Voyages</div>
    <div class="mm-logo-pill"><i class="fas fa-hotel"></i>Séjours Pro</div>
    <div class="mm-logo-pill"><i class="fas fa-chart-line"></i>GrowthLabs</div>
    <div class="mm-logo-pill"><i class="fas fa-building"></i>Bâti Invest</div>
  </div>
</div>

<!-- BOTTOM CTA -->
<div class="mm-cta">
  <div class="mm-cta-text">
    <h3>Prêt à booster vos campagnes email ?</h3>
    <p>Rejoignez plus de 1 200 entreprises qui utilisent Go Exploria pour transformer leur communication email en moteur de croissance réel.</p>
  </div>
  <div class="mm-cta-btns">
    <a href="#" class="btn-white"><i class="fas fa-rocket" style="font-size:12px"></i>Démarrer gratuitement</a>
    <a href="#" class="btn-ghost-w"><i class="fas fa-phone" style="font-size:12px"></i>Parler à un expert</a>
  </div>
</div>

</div><!-- /mm-inner -->
</section>
<script src="{{ asset('vendor/mail-marketing/js/main.js') }}"></script>