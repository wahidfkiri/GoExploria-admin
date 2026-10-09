{{-- En-tête de la carte (logo, titre, accroche), commun aux deux habillages
     world-map (Plexify) et world-map-boussole.

     $carteEntete vient de CarteMonde::entete() : réglé dans l'onglet
     « Géo Maps Vidéos » de l'espace activité / catégorie (admin). Absent, ou
     sans réglage : le texte d'origine du gabarit. Les couleurs ne sont posées
     que si l'admin les a personnalisées — sinon celles du gabarit.

     Paramètres : $classeTitre, $idTitre, $classeChapeau. --}}
@php
    $entete = ($carteEntete ?? null) ?: [];
    $entete += [
        'titre' => 'La carte des points d’intérêt',
        'accroche' => null,
        'couleur_titre' => null,
        'couleur_accroche' => null,
        'logo' => null,
        'logo_position' => 'center',
        'logo_taille' => 96,
        'monde' => true,
    ];
    $nbPoints = $mapPoints->count();
@endphp

@if ($entete['logo'])
  <div class="gx-carte-logo" style="text-align: {{ $entete['logo_position'] }}; margin-bottom: 12px;">
    <img src="{{ $entete['logo'] }}" alt=""
         style="height: {{ (int) $entete['logo_taille'] }}px; width: auto; max-width: 100%; object-fit: contain;">
  </div>
@endif

<h2 class="{{ $classeTitre }}" id="{{ $idTitre }}"@if ($entete['couleur_titre']) style="color: {{ $entete['couleur_titre'] }};"@endif>{{ $entete['titre'] }}</h2>

<p class="{{ $classeChapeau }}"@if ($entete['couleur_accroche']) style="color: {{ $entete['couleur_accroche'] }};"@endif>
  @if ($entete['accroche'])
    {{ $entete['accroche'] }}
  @else
    {{ $nbPoints }} {{ $nbPoints > 1 ? 'lieux référencés' : 'lieu référencé' }}{{ $entete['monde'] ? ' dans le monde' : '' }}.
    Cliquez sur un marqueur pour ouvrir sa fiche : photos,
    vidéo, horaires et coordonnées.
  @endif
</p>
