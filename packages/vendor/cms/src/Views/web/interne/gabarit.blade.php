{{--
  ═══════════════════════════════════════════════════════════════════════════
  GABARIT INTERNE — l'enveloppe, et rien d'autre.

  Le site lui-même est le fichier
      packages/vendor/cms/resources/gabarit-interne/code.html
  et sa feuille
      public/vendor/cms/gabarit-interne/code.css

  Cette vue ne fait que trois choses : poser un document HTML valide, mettre
  les feuilles dans le `<head>`, et déposer le gabarit DÉJÀ REMPLI par la
  chaîne d'hydratation (WebThemeController::hydraterContenuTemplate).

  ⚠ `{!! !!}` et non `{{ }}` : le contenu est du HTML de gabarit, pas du texte
  d'utilisateur. Il vient d'un fichier du dépôt, relu à chaque rendu ; les
  valeurs insérées dedans — nom, adresse, titres de produits — ont été
  échappées par les hydrateurs, chacun à sa place.

  ⚠ Le document DOIT contenir `</body>` : c'est là que buildResponse() greffe
  le panier, la fiche produit, les outils de boutique, l'infolettre, le
  formulaire de demande d'un bien, le pont du formulaire de contact et le pont
  d'embarquement. Sans cette balise, tout cela disparaît sans un message.
  ═══════════════════════════════════════════════════════════════════════════
--}}
@php
    use Vendor\Cms\Support\GabaritInterne;

    $gxiDecoupe = GabaritInterne::decouper($contenu ?? '');
    $gxiTitre = trim((string) (get_site_name($etablissement->id) ?: $etablissement->name));
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() ?: 'fr' }}">
<head>
<meta charset="utf-8">
{{-- `viewport-fit=cover` : les téléphones à encoche rognent sinon les bandes
     pleine largeur du gabarit. --}}
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>{{ $gxiTitre }}</title>
{!! $gxiDecoupe['liens'] !!}
<link rel="stylesheet" href="{{ GabaritInterne::feuille() }}" data-gx-gabarit-interne>
</head>
<body>
{!! $gxiDecoupe['corps'] !!}

{{-- Les biens de l'onglet Immobilier (`window.GX_IMMO`) : c'est d'eux que le
     script du gabarit remplit ses grilles `data-im-grid`, et c'est la même
     liste que lisent ensuite le formulaire de demande, le calendrier de
     disponibilités et le média de la fiche, greffés par buildResponse().

     ⚠ `gxForcerImmo` : le partial cherche d'ordinaire l'enveloppe du gabarit
     dans `$cmsPageSections`. Ici il n'y a AUCUNE copie à fouiller — c'est tout
     le principe — alors on le lui dit. Sans cela il ne publie rien, et les
     grilles de biens restent sur leur démonstration sans un mot d'erreur. --}}
@include('cms::web.fallback.partials.gx-immo-data', ['gxForcerImmo' => true])
</body>
</html>
