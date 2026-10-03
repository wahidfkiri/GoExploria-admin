{{-- Site d'une CATÉGORIE d'activités : sa PAGE (contenu de type « page »),
     composée dans l'éditeur VvvebJS côté administration.

     Jumelle de activities::landing.activity-page, dont elle reprend le
     dispositif à l'identique : la page garde l'en-tête ET le pied de page de
     son gabarit ; l'en-tête de la plateforme (le même que sur `/`) vient se
     poser AU-DESSUS, et les deux barres cohabitent (voir la règle de calage
     plus bas).

     Ses feuilles de style et ses images sont servies depuis
     /templates/plexify, présent dans public/ des deux projets. Le contenu
     porte lui-même ses <link> : rien à déclarer ici, et l'éditeur affiche
     exactement ce que voit le visiteur. --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $gxTitre = $page->meta_title ?: ($page->title ?: $category->name);
        $gxDescription = $page->meta_description
            ?: \Illuminate\Support\Str::limit(strip_tags((string) $category->description), 160);
    @endphp

    <title>{{ $gxTitre }}</title>
    <meta name="description" content="{{ $gxDescription }}">

    <meta property="og:title" content="{{ $gxTitre }}">
    <meta property="og:description" content="{{ $gxDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @if($category->icon_url)
        <meta property="og:image" content="{{ $category->icon_url }}">
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
    /* ── Gabarit « Boussole » (celui livré aux catégories) ───────────────
       Son en-tête est `position: sticky` et vaut z-index 40 : posé sous
       l'en-tête FIXE de la plateforme (z-index 10060), il disparaîtrait
       dessous en haut de page. Il descend donc de la même hauteur mesurée,
       et le contenu lui laisse la place.

       `!important` : la feuille du gabarit vit dans le contenu enregistré,
       donc APRÈS celle-ci dans le document. */
    .boussole-tpl { padding-top: var(--gx-entete-plateforme, 96px); }
    .boussole-tpl .bsl-entete { top: var(--gx-entete-plateforme, 96px) !important; }

    /* ── Gabarits bâtis sur Plexify ──────────────────────────────────────
       Les pages créées avant « Boussole » portent l'en-tête du thème
       Plexify (`.site-header`) : la règle historique est conservée pour
       elles. Une page ne porte jamais les deux. */
    .site-header { top: var(--gx-entete-plateforme, 96px) !important; }

    /* Barre du gabarit transparente : les vidéos du bandeau passent dessous,
       comme le prévoit le gabarit (`header-transparent`). `!important` : le
       thème lui donne un fond dans certains états (barre collante). Le menu
       garde le style du thème. */
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
            // sa barre interne sort du flux et l'élément retombe à 0 px. Les
            // deux en-têtes se retrouveraient alors l'un sur l'autre.
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

{{-- `$contenu` = le contenu enregistré, déjà hydraté par le contrôleur :
     carte mondiale, activités de la catégorie, établissements à proximité. --}}
{!! $contenu ?? $page->content !!}

{{-- Popups publicitaires : même dispositif que les pages d'activité. --}}
@include('components.ads-popup', ['adContext' => 'activities'])

</body>
</html>
