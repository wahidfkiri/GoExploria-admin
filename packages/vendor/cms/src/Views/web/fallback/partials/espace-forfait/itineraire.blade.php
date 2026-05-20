<section id="itineraire">
  <div class="container">
    <div class="section-eyebrow">Itinéraire Alpha</div><h2 class="section-title">Votre voyage <span class="italic">jour par jour</span></h2><p class="section-sub">Un programme orchestré pour vivre l’expérience comme un local, entre culture, gastronomie et paysages.</p>
    <div class="itinerary-tabs"><button class="tab-btn active" onclick="showTab('rome', event)">🇮🇹 Rome & Barcelone</button><button class="tab-btn" onclick="showTab('paris', event)">🇫🇷 Paris & Amsterdam</button><button class="tab-btn" onclick="showTab('grece', event)">🇬🇷 Grèce & Italie</button><button class="tab-btn" onclick="showTab('portugal', event)">🇵🇹 Portugal & Espagne</button></div>
    <div class="itinerary-content">
      @foreach(['rome' => 'Rome, Italie 🏛️|Barcelone, Espagne 🌊|Retour Montréal 🏠', 'paris' => 'Paris, France 🗼|Amsterdam, Pays-Bas 🌷|Retour Montréal 🏠', 'grece' => 'Athènes & Mykonos 🏛️|Rome, Italie 🍝|Retour Montréal 🏠', 'portugal' => 'Lisbonne & Sintra 🌊|Séville, Espagne 💃|Retour Montréal 🏠'] as $key => $cities)
        @php $cityList = explode('|', $cities); @endphp
        <div class="itinerary-panel {{ $loop->first ? 'active' : '' }}" id="tab-{{ $key }}"><div class="timeline"><div class="timeline-item"><div class="tl-day">Jour 1 · Lundi</div><div class="tl-city">Départ Montréal (YUL) ✈</div><div class="tl-desc">Vol de nuit, accueil et transfert vers la première étape du parcours.</div><div class="tl-highlights"><span class="tl-tag">Vol inclus</span><span class="tl-tag">Assistance</span></div></div>@foreach($cityList as $i => $city)<div class="timeline-item"><div class="tl-day">{{ $i + 2 }}e étape</div><div class="tl-city">{{ $city }}</div><div class="tl-desc">Découverte, activités, hébergement et temps libre pour profiter des lieux clés du forfait.</div><div class="tl-highlights"><span class="tl-tag">Hôtel inclus</span><span class="tl-tag">Culture</span><span class="tl-tag">Gastronomie</span></div></div>@endforeach</div></div>
      @endforeach
    </div>
    <div style="margin-top:36px;text-align:center"><a href="https://www.transat.com/fr-CA/forfaits-multi-villes/alpha-7-nuits/itineraire" target="_blank" class="btn btn-outline" style="padding:14px 28px">Voir l’itinéraire complet →</a></div>
  </div>
</section>
