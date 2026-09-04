{{-- Site d'une activité : sa PAGE (contenu de type « page »), composée dans
     l'éditeur VvvebJS côté administration.

     La page est rendue SEULE, sans le chrome de la plateforme : elle apporte
     son propre en-tête et son propre pied de page. C'est la même décision que
     pour les pages CMS d'établissement — un en-tête de repli par-dessus celui
     du gabarit donnait deux menus superposés.

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

{!! $page->content !!}

{{-- Popups publicitaires : même dispositif que la page d'activité classique. --}}
@include('components.ads-popup', ['adContext' => 'activities'])

</body>
</html>
