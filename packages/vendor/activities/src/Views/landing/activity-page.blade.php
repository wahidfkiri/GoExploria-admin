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

    /* ── FOND TRANSPARENT ────────────────────────────────────────────────
       Demande du 2026-09-16 : la barre du gabarit (`.main-bar-wraper`) est
       transparente — les vidéos du bandeau passent dessous, comme le prévoit
       le gabarit (`header-transparent`). Elle était noire jusque-là, alignée
       sur la barre de la plateforme. `!important` : le thème lui donne un
       fond dans certains états (barre collante). Le menu garde le style du
       thème (sur grand écran, sa pastille sombre ; en dessous, le tiroir
       blanc du menu mobile). */
    .site-header,
    .site-header .main-bar-wraper,
    .site-header .main-bar {
        background: transparent !important;
        box-shadow: none !important;
    }

    /* Les liens du gabarit sortent en blanc sur le bandeau, sauf l'élément
       courant, qui porte une pastille blanche à texte sombre : on ne touche
       donc qu'au survol. */
    .site-header .header-nav > ul > li:not(.active) > a:hover {
        color: #C8F31D !important;
    }
</style>
<script>
    (function () {
        var mesurer = function () {
            var entete = document.querySelector('.gx-platform-header .header-v2');
            if (!entete) return;

            // On ne peut PAS se fier à la hauteur de `.header-v2` : en mobile
            // sa barre interne sort du flux et l'élément retombe à 0 px —
            // mesuré à 375 px de large. Les deux en-têtes se retrouvaient
            // alors l'un sur l'autre.
            //
            // L'en-tête étant `position: fixed; top: 0`, le bas de sa boîte
            // vaut sa hauteur visible : on prend le plus bas des deux, celui
            // de l'élément et celui de sa barre.
            var barre = entete.querySelector('.header-nav');
            var bas = entete.getBoundingClientRect().bottom;
            if (barre) {
                bas = Math.max(bas, barre.getBoundingClientRect().bottom);
            }

            // Avant la mise en page, tout vaut 0 : on garde la valeur de repli
            // du CSS plutôt que de coller les deux barres.
            if (bas > 0) {
                document.documentElement.style.setProperty(
                    '--gx-entete-plateforme', Math.round(bas) + 'px'
                );
            }
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
