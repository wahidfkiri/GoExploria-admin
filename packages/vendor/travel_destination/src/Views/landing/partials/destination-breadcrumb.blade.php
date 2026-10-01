{{-- ==========================================================================
     FIL D'ARIANE DE LA BANNIÈRE — agrandi, avec un menu déroulant par niveau.

     Chaque maillon de destination ouvre la liste de ses FRÈRES : les autres
     continents, les autres pays du continent affiché, les autres provinces du
     pays, etc. (voir TravelDestinationController@buildBreadcrumbLevels).
     Le niveau affiché est marqué d'une coche et n'est pas cliquable.

     Variables : $breadcrumb (Accueil / Destinations), $filArianeNiveaux.
     Rendu à deux endroits : la bannière composée dans l'éditeur visuel (où il
     remplace l'emplacement data-gx-destination-breadcrumb) et la bannière du
     gabarit. D'où les styles et le script en @once.
     ========================================================================== --}}
@php
    $gxFilFixes = collect($breadcrumb ?? [])->take(2);   // Accueil, Destinations
    $gxFilNiveaux = collect($filArianeNiveaux ?? []);
@endphp

@if($gxFilNiveaux->isNotEmpty() || $gxFilFixes->count() > 1)
<nav class="gxfil" aria-label="Fil d’Ariane">
    @foreach($gxFilFixes as $gxCrumb)
        @if(! empty($gxCrumb['url']))
            <a class="gxfil__lien" href="{{ $gxCrumb['url'] }}">{{ $gxCrumb['label'] }}</a>
        @else
            <span class="gxfil__lien">{{ $gxCrumb['label'] }}</span>
        @endif
        <span class="gxfil__sep" aria-hidden="true">/</span>
    @endforeach

    @foreach($gxFilNiveaux as $gxNiveau)
        @if(! $loop->first)<span class="gxfil__sep" aria-hidden="true">/</span>@endif

        <span class="gxfil__niveau {{ $gxNiveau['suivant'] ? 'gxfil__niveau--suivant' : '' }}">
            @if($gxNiveau['courant'])
                <span class="gxfil__lien gxfil__lien--courant" aria-current="page">{{ $gxNiveau['label'] }}</span>
            @elseif($gxNiveau['suivant'])
                {{-- Niveau inférieur : un libellé de rubrique, pas une destination.
                     Verrouillé tant qu'aucun choix n'est possible à ce niveau. --}}
                <span class="gxfil__lien gxfil__lien--suivant {{ $gxNiveau['verrouille'] ? 'is-verrouille' : '' }}"
                      @if($gxNiveau['verrouille']) title="Choisissez d’abord le niveau précédent" aria-disabled="true" @endif>
                    {{ $gxNiveau['label'] }}
                </span>
            @else
                <a class="gxfil__lien" href="{{ $gxNiveau['url'] }}">{{ $gxNiveau['label'] }}</a>
            @endif

            @if(count($gxNiveau['options']) > ($gxNiveau['suivant'] ? 0 : 1))
                <button type="button" class="gxfil__bouton" aria-expanded="false" aria-haspopup="listbox"
                        aria-label="Changer de {{ $gxNiveau['type'] === 'city' ? 'ville' : $gxNiveau['type'] }}">
                    <i class="fas fa-chevron-down" aria-hidden="true"></i>
                </button>
                <div class="gxfil__liste" role="listbox" hidden>
                    @foreach($gxNiveau['options'] as $gxOption)
                        <a class="gxfil__option {{ $gxOption['actuel'] ? 'is-actuel' : '' }}"
                           href="{{ $gxOption['url'] }}" role="option"
                           aria-selected="{{ $gxOption['actuel'] ? 'true' : 'false' }}">
                            {{ $gxOption['label'] }}
                            @if($gxOption['actuel'])<i class="fas fa-check" aria-hidden="true"></i>@endif
                        </a>
                    @endforeach
                    @if($gxNiveau['tronque'])
                        <span class="gxfil__note">Liste partielle — ouvrez le niveau parent pour tout voir.</span>
                    @endif
                </div>
            @endif
        </span>
    @endforeach
</nav>

@once
<style>
    /* Agrandi : l'ancien fil était en 11 px, à peine lisible sur la photo. */
    .gxfil {
        display: flex; flex-wrap: wrap; align-items: center; gap: 4px 6px;
        margin: 0 0 18px; font-size: 15px; font-weight: 600; line-height: 1.5;
        font-family: inherit;
    }
    /* Épinglé en HAUT de la bannière, sous l'en-tête fixe. Sans cela, il
       suivait le titre : la bannière aligne son contenu en bas
       (align-items: flex-end), et le fil se retrouvait au milieu de l'image.
       Le calage horizontal sur le titre est fait par le script. */
    .gxfil--epingle {
        position: absolute;
        top: calc(var(--gx-entete-plateforme, 96px) + 18px);
        z-index: 6; margin: 0;
    }
    .gxfil__sep { opacity: .45; font-weight: 400; }
    .gxfil__lien {
        color: inherit; text-decoration: none; opacity: .82;
        padding: 3px 2px; border-radius: 6px; transition: opacity .18s ease, color .18s ease;
    }
    a.gxfil__lien:hover { opacity: 1; text-decoration: underline; }

    /* Niveau affiché : pastille dorée, pour le repérer d'un coup d'œil. */
    .gxfil__lien--courant {
        opacity: 1; font-weight: 800;
        padding: 4px 12px; border-radius: 999px;
        background: var(--gxfil-actif, #d4af37); color: var(--gxfil-actif-texte, #0a1628);
        box-shadow: 0 4px 14px rgba(212, 175, 55, .35);
    }

    /* Niveaux inférieurs : un libellé de rubrique (Province, Région…), en
       retrait, qui n'est pas une destination déjà choisie. */
    .gxfil__lien--suivant { opacity: .62; font-weight: 600; font-style: italic; }
    .gxfil__lien--suivant.is-verrouille { opacity: .38; cursor: not-allowed; }
    .gxfil__niveau--suivant .gxfil__bouton { background: rgba(255, 255, 255, .1); }

    .gxfil__niveau { position: relative; display: inline-flex; align-items: center; gap: 2px; }
    .gxfil__bouton {
        display: inline-grid; place-items: center; width: 24px; height: 24px;
        padding: 0; border: 0; border-radius: 50%;
        background: rgba(255, 255, 255, .14); color: inherit; cursor: pointer;
        font-size: 10px; opacity: .8; transition: background .18s ease, transform .18s ease;
    }
    .gxfil__bouton:hover, .gxfil__bouton[aria-expanded="true"] { background: rgba(255, 255, 255, .28); opacity: 1; }
    .gxfil__bouton[aria-expanded="true"] i { transform: rotate(180deg); }
    .gxfil__bouton i { transition: transform .2s ease; }

    /* Menu transparent, texte blanc : il se fond dans la bannière.
       Le fond n'est pas VIDE mais très légèrement teinté et flouté — sur une
       photo claire, du blanc sur du transparent pur serait illisible. */
    .gxfil__liste {
        position: absolute; top: calc(100% + 8px); left: 0; z-index: 60;
        min-width: 230px; max-width: min(360px, 80vw); max-height: 320px; overflow-y: auto;
        padding: 6px; border-radius: 12px;
        background: rgba(10, 22, 40, .42);
        -webkit-backdrop-filter: blur(14px) saturate(140%);
        backdrop-filter: blur(14px) saturate(140%);
        border: 1px solid rgba(255, 255, 255, .22);
        box-shadow: 0 18px 46px rgba(2, 6, 23, .34);
        font-size: 14px; font-weight: 500; text-align: left; color: #fff;
    }
    .gxfil__option {
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
        padding: 8px 10px; border-radius: 8px;
        color: #fff; text-decoration: none; opacity: 1;
        text-shadow: 0 1px 3px rgba(0, 0, 0, .45);
    }
    .gxfil__option:hover { background: rgba(255, 255, 255, .16); color: #fff; }
    .gxfil__option.is-actuel {
        background: var(--gxfil-actif, #d4af37); color: var(--gxfil-actif-texte, #0a1628);
        font-weight: 700; text-shadow: none;
    }
    .gxfil__option i { font-size: 11px; }
    .gxfil__note { display: block; padding: 8px 10px; font-size: 12px; color: rgba(255, 255, 255, .72); }

    @media (max-width: 640px) {
        .gxfil { font-size: 13px; gap: 3px 5px; margin-bottom: 14px; }
        .gxfil__liste { min-width: 190px; max-height: 260px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .gxfil__bouton, .gxfil__bouton i { transition: none; }
    }
</style>

<script>
(function () {
    /* Remonte le fil en haut de la bannière : il est rendu dans `.hero-inner`,
       bloc aligné en BAS de la section. On le déplace donc au niveau de la
       section elle-même (déjà `position: relative`) et on l'aligne sur la
       colonne du titre, largeur d'écran comprise. */
    function epingler() {
        var fil = document.querySelector('.gxfil');
        if (!fil || fil.classList.contains('gxfil--epingle')) { return; }

        var banniere = fil.closest('section');
        var colonne = fil.parentElement;
        if (!banniere || !colonne || colonne === banniere) { return; }

        banniere.insertBefore(fil, banniere.firstChild);
        fil.classList.add('gxfil--epingle');

        /* Le calage reprend AUSSI le padding de la colonne : celle-ci occupe
           toute la largeur de la bannière, et c'est son padding qui met le
           titre en retrait. Sans lui, le fil se collait au bord gauche. */
        var caler = function () {
            var b = banniere.getBoundingClientRect();
            var c = colonne.getBoundingClientRect();
            var style = window.getComputedStyle(colonne);
            var gauche = (c.left - b.left) + (parseFloat(style.paddingLeft) || 0);
            var droite = (b.right - c.right) + (parseFloat(style.paddingRight) || 0);
            fil.style.left = Math.max(0, Math.round(gauche)) + 'px';
            fil.style.right = Math.max(0, Math.round(droite)) + 'px';
        };

        caler();
        window.addEventListener('resize', caler, { passive: true });
        // L'en-tête change de hauteur au défilement : la position suit.
        window.addEventListener('scroll', caler, { passive: true });
    }

    function init() {
        epingler();

        var boutons = document.querySelectorAll('.gxfil__bouton');
        if (!boutons.length) { return; }

        function fermerTout(sauf) {
            document.querySelectorAll('.gxfil__bouton[aria-expanded="true"]').forEach(function (b) {
                if (b === sauf) { return; }
                b.setAttribute('aria-expanded', 'false');
                var l = b.parentElement.querySelector('.gxfil__liste');
                if (l) { l.hidden = true; }
            });
        }

        boutons.forEach(function (bouton) {
            var liste = bouton.parentElement.querySelector('.gxfil__liste');
            if (!liste) { return; }

            bouton.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var ouvert = bouton.getAttribute('aria-expanded') === 'true';
                fermerTout(bouton);
                bouton.setAttribute('aria-expanded', ouvert ? 'false' : 'true');
                liste.hidden = ouvert;
                if (!ouvert) {
                    // La liste peut sortir de l'écran à droite : on la recadre.
                    liste.style.left = '0';
                    var boite = liste.getBoundingClientRect();
                    if (boite.right > window.innerWidth - 12) {
                        liste.style.left = Math.min(0, window.innerWidth - 12 - boite.right) + 'px';
                    }
                    var actuel = liste.querySelector('.is-actuel');
                    if (actuel) { liste.scrollTop = Math.max(0, actuel.offsetTop - 60); }
                }
            });
        });

        document.addEventListener('click', function (e) {
            if (!e.target.closest('.gxfil__niveau')) { fermerTout(null); }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { fermerTout(null); }
        });
    }

    if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', init); }
    else { init(); }
})();
</script>
@endonce
@endif
