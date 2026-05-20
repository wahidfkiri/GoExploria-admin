<section id="reserver">
  <div class="reserver-container">
    <div class="reserver-header">
      <div class="section-eyebrow" style="text-align:center">Réservation en ligne</div>
      <h2 class="section-title" style="text-align:center">Trouvez votre <span class="italic">forfait idéal</span></h2>
      <p class="section-sub" style="text-align:center;margin:14px auto 0">Filtrez par type de forfait, dates et salle disponible, puis réservez en quelques clics.</p>
    </div>
    <div class="booking-box">
      <div class="booking-filters">
        <div class="filter-group" id="filterForfait" onclick="toggleDropdown('dropForfait')">
          <div class="filter-label">Type de forfait</div>
          <div class="filter-value placeholder" id="valForfait"><span class="filter-icon">🏔️</span> Choisir un forfait</div>
          <div class="filter-dropdown" id="dropForfait">
            <div class="forfait-option" onclick="selectForfait('Motoneige',event)"><div class="forfait-option-icon">🏍️</div><div><div class="forfait-option-name">Motoneige</div><div class="forfait-option-desc">BRP 600 Touring & 900 Renegade</div></div></div>
            <div class="forfait-option" onclick="selectForfait('Quad & VTT',event)"><div class="forfait-option-icon">🚙</div><div><div class="forfait-option-name">Quad & VTT</div><div class="forfait-option-desc">Sentiers estivaux et aventure nature</div></div></div>
            <div class="forfait-option" onclick="selectForfait('Côte-à-côte (SSV)',event)"><div class="forfait-option-icon">🛻</div><div><div class="forfait-option-name">Côte-à-côte (SSV)</div><div class="forfait-option-desc">Expérience duo dans les sentiers</div></div></div>
            <div class="forfait-option" onclick="selectForfait('Forfait guidé',event)"><div class="forfait-option-icon">🧭</div><div><div class="forfait-option-name">Forfait guidé</div><div class="forfait-option-desc">La Gourmande, Le Douillet, Monts-Valin</div></div></div>
            <div class="forfait-option" onclick="selectForfait('Tout terrain',event)"><div class="forfait-option-icon">🌲</div><div><div class="forfait-option-name">Tout terrain</div><div class="forfait-option-desc">Multi-véhicules · offre complète</div></div></div>
          </div>
        </div>
        <div class="filter-group" id="filterDateArrive" onclick="toggleDropdown('dropDateArrive')">
          <div class="filter-label">Date d’arrivée</div>
          <div class="filter-value placeholder" id="valDateArrive"><span class="filter-icon">📅</span> Choisir une date</div>
          <div class="filter-dropdown wide" id="dropDateArrive" onclick="event.stopPropagation()"><div class="cal-dual"><div id="calArrive"></div><div id="calDepart"></div></div><div style="margin-top:12px;font-size:12px;color:var(--mid-gray);text-align:center" id="calRangeLabel">Sélectionnez votre date d’arrivée</div></div>
        </div>
        <div class="filter-group" id="filterDateDepart"><div class="filter-label">Date de départ</div><div class="filter-value placeholder" id="valDateDepart"><span class="filter-icon">📅</span> Choisir une date</div></div>
        <div class="filter-group" id="filterSalle" onclick="toggleDropdown('dropSalle')">
          <div class="filter-label">Salle & Véhicule</div><div class="filter-value placeholder" id="valSalle"><span class="filter-icon">🏠</span> Choisir</div>
          <div class="filter-dropdown wide" id="dropSalle" onclick="event.stopPropagation()">
            <div style="font-size:12px;font-weight:800;color:var(--mid-gray);letter-spacing:.08em;text-transform:uppercase;margin-bottom:10px">Salle de départ</div>
            <div class="salle-grid">
              <div class="salle-option" onclick="selectSalle('Salle La Malbaie',this)"><div class="salle-option-icon">🏔️</div><div class="salle-option-name">La Malbaie</div><div class="salle-option-spots">Siège principal</div></div>
              <div class="salle-option" onclick="selectSalle('Salle Baie-Saint-Paul',this)"><div class="salle-option-icon">🌲</div><div class="salle-option-name">Baie-Saint-Paul</div><div class="salle-option-spots">Point de départ Nord</div></div>
              <div class="salle-option" onclick="selectSalle('Salle Charlevoix Est',this)"><div class="salle-option-icon">⛰️</div><div class="salle-option-name">Charlevoix Est</div><div class="salle-option-spots">Accès avancé</div></div>
              <div class="salle-option" onclick="selectSalle('Livraison au chalet',this)"><div class="salle-option-icon">🚚</div><div class="salle-option-name">Livraison au chalet</div><div class="salle-option-spots">Option personnalisée</div></div>
            </div>
          </div>
        </div>
        <div class="filter-group" id="filterPersonnes" onclick="toggleDropdown('dropPersonnes')">
          <div class="filter-label">Personnes</div><div class="filter-value placeholder" id="valPersonnes"><span class="filter-icon">👥</span> Combien ?</div>
          <div class="filter-dropdown" id="dropPersonnes" onclick="event.stopPropagation()">
            <div style="font-size:13px;font-weight:800;color:var(--navy);margin-bottom:12px">Nombre de participants</div>
            <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border)"><div><div style="font-size:14px;font-weight:700;color:var(--navy)">Adultes</div><div style="font-size:12px;color:var(--mid-gray)">18 ans et plus</div></div><div style="display:flex;align-items:center;gap:12px"><button onclick="changeCount('adults',-1)" type="button">−</button><span id="countAdults" style="font-size:16px;font-weight:800;color:var(--navy);min-width:20px;text-align:center">1</span><button onclick="changeCount('adults',1)" type="button">+</button></div></div>
            <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0"><div><div style="font-size:14px;font-weight:700;color:var(--navy)">Enfants</div><div style="font-size:12px;color:var(--mid-gray)">Moins de 18 ans</div></div><div style="display:flex;align-items:center;gap:12px"><button onclick="changeCount('children',-1)" type="button">−</button><span id="countChildren" style="font-size:16px;font-weight:800;color:var(--navy);min-width:20px;text-align:center">0</span><button onclick="changeCount('children',1)" type="button">+</button></div></div>
            <button onclick="confirmPersonnes()" type="button" style="width:100%;padding:10px;margin-top:8px;background:var(--navy);color:white;border:none;border-radius:10px;font-size:13px;font-weight:800;cursor:pointer;font-family:'DM Sans',sans-serif">Confirmer</button>
          </div>
        </div>
        <button class="booking-search-btn" onclick="searchForfaits()" type="button">🔍 Rechercher</button>
      </div>
      <div class="booking-results" id="bookingResults" style="display:none"><div class="results-label" id="resultsLabel">Forfaits disponibles</div><div class="result-cards" id="resultCards"></div></div>
      <div id="bookingDefault" style="padding:32px;text-align:center;color:var(--mid-gray)"><div style="font-size:40px;margin-bottom:12px">🏔️</div><div style="font-size:15px;font-weight:800;color:var(--navy);margin-bottom:6px">Prêt à vivre l’aventure ?</div><div style="font-size:14px">Sélectionnez vos critères et trouvez le forfait parfait pour vous.</div></div>
    </div>
  </div>
</section>
