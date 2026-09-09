{{-- Site d'une activité : sa PAGE (contenu de type « page »), composée dans
     l'éditeur VvvebJS côté administration.

     La page garde l'en-tête ET le pied de page de son gabarit ; l'en-tête de
     la plateforme (le même que sur `/`) vient se poser AU-DESSUS. Les deux
     barres cohabitent : celle de la plateforme en haut, celle du gabarit
     juste en dessous (voir la règle de calage plus bas).

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

{{-- EN-TÊTE DE LA PLATEFORME — celui de la page d'accueil, à l'identique,
     posé AU-DESSUS de celui du gabarit (les deux restent visibles). --}}
@include('welcome-home.partials.platform-header')

{{-- ── CALAGE DES DEUX BARRES ──────────────────────────────────────────
     Les deux en-têtes se placent en haut de page : celui de la plateforme en
     `position: fixed`, celui du gabarit en `absolute` (et en `fixed` dès que
     le gabarit le rend collant au défilement). Sans rien faire, ils se
     recouvrent — et le gabarit, en z-index 999 contre 10060, disparaît sous
     l'autre.

     La barre du gabarit descend donc de la hauteur de celle de la plateforme.
     Cette hauteur n'est pas constante (elle change avec la largeur d'écran et
     avec le passage à l'état « défilé ») : on la mesure et on la publie dans
     une variable CSS, plutôt que d'inscrire un nombre qui serait faux la
     moitié du temps.

     `!important` : les gabarits posent `top: 0` sur leur en-tête, souvent
     eux-mêmes en `!important` pour leur état collant. --}}
<style>
    .site-header { top: var(--gx-entete-plateforme, 96px) !important; }
</style>
<script>
    (function () {
        var mesurer = function () {
            var entete = document.querySelector('.gx-platform-header .header-v2');
            if (!entete) return;
            document.documentElement.style.setProperty(
                '--gx-entete-plateforme', entete.offsetHeight + 'px'
            );
        };

        mesurer();
        document.addEventListener('DOMContentLoaded', mesurer);
        window.addEventListener('load', mesurer);
        window.addEventListener('resize', mesurer, { passive: true });
        // L'en-tête change de hauteur en passant à l'état « défilé ».
        window.addEventListener('scroll', mesurer, { passive: true });
    })();
</script>

{{-- `$contenu` = le contenu enregistré, sa section d'attente `data-gx-map`
     déjà remplacée par la vraie carte (LandingPageController). --}}
{!! $contenu ?? $page->content !!}

{{-- Popups publicitaires : même dispositif que la page d'activité classique. --}}
@include('components.ads-popup', ['adContext' => 'activities'])

</body>
</html>
