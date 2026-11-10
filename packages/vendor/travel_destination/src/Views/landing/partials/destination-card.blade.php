{{-- ==========================================================================
     FICHE D'UNE DESTINATION — index `/destination`

     Visuel, niveau, nom, et lien direct vers la page de la destination.

     Variables : $destination (modèle), $type (type d'URL : continent, country,
     province, region, secteur, city, arrondissement, quartier), $libelle
     (libellé du niveau), $visuel et $lien (fermetures de la vue parente).
     ========================================================================== --}}
@php
    $gxImage = $visuel($destination);
    $gxNom = (string) ($destination->name ?? '');
    $gxInitiale = mb_strtoupper(mb_substr(trim($gxNom), 0, 1)) ?: '•';

    /* Sous-titre : le parent quand la relation est déjà chargée ou facile à
       lire, sinon le libellé du niveau suffit. On ne déclenche PAS de requête
       par fiche — une page en affiche vingt-quatre. */
    $gxParent = null;
    foreach (['secteur', 'region', 'province', 'country', 'continent', 'ville'] as $gxRelation) {
        if ($destination->relationLoaded($gxRelation) && $destination->{$gxRelation}) {
            $gxParent = $destination->{$gxRelation}->name;
            break;
        }
    }
@endphp

<a class="gxdx-fiche" href="{{ $lien($type, $destination) }}">
  <span class="gxdx-fiche__media">
    @if($gxImage)
      <img src="{{ $gxImage }}" alt="{{ $gxNom }}" loading="lazy" decoding="async">
    @else
      <span class="gxdx-fiche__initiale" aria-hidden="true">{{ $gxInitiale }}</span>
    @endif
    <span class="gxdx-fiche__badge">{{ $libelle }}</span>
  </span>

  <span class="gxdx-fiche__corps">
    <span class="gxdx-fiche__nom">{{ $gxNom }}</span>
    <span class="gxdx-fiche__meta">{{ $gxParent ?: $libelle }}</span>
    <span class="gxdx-fiche__lire">Explorer <i class="fas fa-arrow-right" aria-hidden="true"></i></span>
  </span>
</a>
