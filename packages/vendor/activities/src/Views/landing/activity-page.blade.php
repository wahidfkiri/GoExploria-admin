{{-- Site d'une activité : sa PAGE (contenu de type « page »), composée dans
     l'éditeur VvvebJS côté administration.

     La page apporte son propre pied de page, mais plus son en-tête : celui du
     gabarit est retiré du contenu et remplacé par l'en-tête de la plateforme,
     le même que sur `/`. C'est le seul moyen d'avoir UNE barre de navigation
     et pas deux — les deux sont en `position: fixed` en haut de page.

     Ses feuilles de style et ses images sont servies depuis
     /templates/plexify, présent dans public/ des deux projets. Le contenu
     porte lui-même ses <link> : rien à déclarer ici, et l'éditeur affiche
     exactement ce que voit le visiteur. --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $page->meta_title ?: ($page->title ?: $activity->name) }}</title>
    <meta name="description" content="{{ $page->meta_description ?: Str::limit(strip_tags((string) $activity->description), 160) }}">

    <meta property="og:title" content="{{ $page->meta_title ?: ($page->title ?: $activity->name) }}">
    <meta property="og:description" content="{{ $page->meta_description ?: Str::limit(strip_tags((string) $activity->description), 160) }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @if($activity->image_url)
        <meta property="og:image" content="{{ $activity->image_url }}">
    @endif

    <style>
        html { scroll-behavior: smooth; }
        body { margin: 0; }
    </style>
</head>
<body>

{{-- EN-TÊTE DE LA PLATEFORME — celui de la page d'accueil, à l'identique.
     Il REMPLACE celui du gabarit, que LandingPageController::retirerEnteteGabarit
     retire du contenu enregistré : les deux sont `position: fixed` en haut de
     page et se seraient superposés. Transparent au repos, il se pose sur le
     visuel d'ouverture exactement comme le faisait l'en-tête du gabarit
     (`header-transparent`) : rien à décaler. --}}
@include('welcome-home.partials.platform-header')

{{-- `$contenu` = le contenu enregistré, sa section d'attente `data-gx-map`
     déjà remplacée par la vraie carte et son en-tête de gabarit retiré
     (LandingPageController). --}}
{!! $contenu ?? $page->content !!}

{{-- Popups publicitaires : même dispositif que la page d'activité classique. --}}
@include('components.ads-popup', ['adContext' => 'activities'])

</body>
</html>
