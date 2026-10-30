{{-- Widget météo de la page de destination (Open-Meteo).

     Données lues dans destination_meteo par Support\MeteoDestination (le site
     n'appelle jamais l'API). Même balisage que l'aperçu de l'admin (onglet
     Météo de l'espace destination, widgetMeteo() dans espace/partials/scripts)
     et même feuille : css/meteo-destination.css. Modifier l'un, répercuter
     l'autre.

     Attend : $meteo (tableau de MeteoDestination::pour) et $entity. --}}
@php
    $gxmD = $meteo['donnees'];
    $gxmU = $meteo['unite'];
    $gxmF = $gxmU === 'fahrenheit';
    $gxmT = fn ($v) => \Vendor\TravelDestination\Support\MeteoDestination::temperature($v, $gxmU);
    $gxmA = $gxmD['actuel'] ?? [];
    $gxmJours = array_slice($gxmD['jours'] ?? [], 0, $meteo['jours']);
    $gxmAujourdhui = $gxmJours[0] ?? [];
@endphp
<section class="gx-meteo" id="meteo" aria-labelledby="gx-meteo-titre">
  <div class="gx-meteo__inner">
    <div class="gx-meteo__tete">
      <div>
        <span class="gx-meteo__eyebrow"><i class="fa-solid fa-cloud-sun" aria-hidden="true"></i> Météo</span>
        <h2 class="gx-meteo__titre" id="gx-meteo-titre">Météo à {{ $entity->name }}</h2>
      </div>
      <p class="gx-meteo__maj">Mise à jour {{ $meteo['rafraichi_le']->locale('fr')->diffForHumans() }}</p>
    </div>

    <div class="gx-meteo__grille">
      <div class="gx-meteo__actuel">
        <div class="gx-meteo__actuel-haut">
          <i class="fa-solid {{ $gxmA['icone'] ?? 'fa-cloud' }} gx-meteo__actuel-icone" aria-hidden="true"></i>
          <div>
            <div class="gx-meteo__temp">{{ $gxmT($gxmA['temperature'] ?? null) }}</div>
            <div class="gx-meteo__libelle">{{ $gxmA['libelle'] ?? '' }}</div>
            @if(isset($gxmA['ressenti']))
              <div class="gx-meteo__ressenti">Ressenti {{ $gxmT($gxmA['ressenti']) }}</div>
            @endif
          </div>
        </div>
        <ul class="gx-meteo__details">
          @if(isset($gxmA['vent']))
            <li><i class="fa-solid fa-wind"></i> {{ (int) round($gxmF ? $gxmA['vent'] / 1.609 : $gxmA['vent']) }} {{ $gxmF ? 'mph' : 'km/h' }}</li>
          @endif
          @if(isset($gxmA['humidite']))
            <li><i class="fa-solid fa-droplet"></i> {{ $gxmA['humidite'] }} %</li>
          @endif
          @if(! empty($gxmAujourdhui['lever']))
            <li><i class="fa-solid fa-sun"></i> {{ $gxmAujourdhui['lever'] }}</li>
          @endif
          @if(! empty($gxmAujourdhui['coucher']))
            <li><i class="fa-solid fa-moon"></i> {{ $gxmAujourdhui['coucher'] }}</li>
          @endif
        </ul>
      </div>

      <ol class="gx-meteo__jours">
        @foreach($gxmJours as $i => $jour)
          @php $gxmDate = \Illuminate\Support\Carbon::parse($jour['date'])->locale('fr'); @endphp
          <li class="gx-meteo__jour{{ $i === 0 ? ' is-aujourdhui' : '' }}">
            <span class="gx-meteo__jour-nom">{{ $i === 0 ? "Aujourd'hui" : $gxmDate->isoFormat('dddd') }}</span>
            <span class="gx-meteo__jour-date">{{ $gxmDate->isoFormat('D MMM') }}</span>
            <i class="fa-solid {{ $jour['icone'] ?? 'fa-cloud' }} gx-meteo__jour-icone" aria-hidden="true"></i>
            <span class="gx-meteo__jour-libelle">{{ $jour['libelle'] ?? '' }}</span>
            <span class="gx-meteo__jour-temp">{{ $gxmT($jour['max'] ?? null) }}<span>{{ $gxmT($jour['min'] ?? null) }}</span></span>
            @if(isset($jour['pluie']))
              <span class="gx-meteo__jour-pluie"><i class="fa-solid fa-droplet"></i> {{ $jour['pluie'] }} %</span>
            @endif
          </li>
        @endforeach
      </ol>
    </div>

    {{-- Mention exigée par la licence CC BY 4.0 des données. --}}
    <p class="gx-meteo__source">Données météo : <a href="https://open-meteo.com/" target="_blank" rel="noopener">Open-Meteo.com</a> (CC BY 4.0)</p>
  </div>
</section>
