{{-- ══════════════════════════════════════════════════════════════════════
     BARRE DE RECHERCHE DE L'EN-TÊTE

     La même zone que dans la bannière de l'accueil — bloc DESTINATIONS,
     champ de recherche, bloc ACTIVITÉS — posée en seconde ligne de l'en-tête
     de la plateforme, pour les pages qui n'ont pas la bannière de l'accueil
     (destinations, activités, catégories, sites d'établissement).

     Rendue DANS `<header class="header-v2">` : l'en-tête est fixe et sa
     hauteur est mesurée par les pages hôtes (page d'activité, barre de
     widgets, fil d'Ariane) à partir de sa boîte. En seconde ligne à
     l'intérieur, la barre entre dans cette mesure — posée en dessous en
     `fixed`, elle aurait recouvert l'en-tête du gabarit hôte.

     Mêmes classes et mêmes identifiants que la barre de la bannière : c'est
     `js/welcome/search-bar.js` (SearchBarV2) qui s'y accroche et
     `css/welcome/search-bar.css` qui habille le champ et la liste de
     résultats. Ce fichier n'ajoute que la mise en forme « seconde ligne » et
     le relais vers les panneaux de la barre de widgets.

     ⚠ Jamais sur l'accueil : la bannière y porte déjà ces identifiants.
     L'inclusion est conditionnée par $gxHeaderSearchBar, et le script retire
     la barre s'il trouve malgré tout un second champ. --}}
@once

{{-- Styles AVANT le balisage : le navigateur peint au fil de sa lecture. --}}
<style>
    /* La barre occupe la seconde ligne de l'en-tête, sous la navigation. */
    .gxhsearch { padding: 0 16px 10px; }

    /* Le fond sombre pleine largeur de search-bar.css ferait une deuxième
       bande sous l'en-tête : ici la barre est une pastille posée dessus. */
    .gxhsearch .search-bar-v2 {
        background: transparent; border: 0; padding: 0; z-index: auto;
    }
    .gxhsearch .search-bar-v2-container {
        max-width: 1040px; margin: 0 auto; gap: 14px; padding: 6px 10px;
        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 999px;
        -webkit-backdrop-filter: blur(10px); backdrop-filter: blur(10px);
    }

    /* Blocs latéraux : visuel au-dessus, libellé en dessous. */
    .gxhsearch .gxhsearch__bloc {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 2px; flex: 0 0 auto; min-width: 150px; padding: 4px 14px;
        border: 0; border-radius: 999px; background: transparent; cursor: pointer;
        color: #fff; font: inherit; transition: background .2s ease;
    }
    .gxhsearch .gxhsearch__bloc:hover { background: rgba(255, 255, 255, .10); }
    .gxhsearch .gxhsearch__bloc:focus-visible { outline: 2px solid var(--accent-gold, #d4af37); outline-offset: 2px; }
    .gxhsearch .search-bar-v2-globe-icon { width: 30px; height: 30px; }
    .gxhsearch .search-bar-v2-destinations-title { font-size: 11px; letter-spacing: 1.4px; }
    .gxhsearch .gxhsearch__logo { height: 20px; width: auto; display: block; }
    .gxhsearch .gxhsearch__legende {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 11px; font-weight: 800; letter-spacing: 1.4px; text-transform: uppercase;
    }
    .gxhsearch .gxhsearch__legende i { font-size: 9px; }

    /* Champ : la pastille blanche de search-bar.css, en plus compact. */
    .gxhsearch .search-bar-v2-search { max-width: none; }
    .gxhsearch .search-bar-v2-input-wrapper { padding: 7px 16px; box-shadow: none; }
    .gxhsearch .search-bar-v2-input { font-size: 13.5px; }
    .gxhsearch .search-bar-v2-search-icon { width: 18px; height: 18px; }

    /* Sous 860 px l'en-tête est déjà serré : on garde le champ seul. */
    @media (max-width: 860px) {
        .gxhsearch { padding: 0 12px 8px; }
        .gxhsearch .gxhsearch__bloc { display: none; }
        .gxhsearch .search-bar-v2-container { gap: 0; padding: 4px 6px; }
    }
</style>

<div class="gxhsearch" data-gx-header-search>
    <div class="search-bar-v2">
        <div class="search-bar-v2-container">
            {{-- DESTINATIONS : ouvre le panneau « destinations » de la barre de
                 widgets, dont le contenu est chargé à la demande. --}}
            <button type="button" class="gxhsearch__bloc"
                    data-gxhsearch-relais="destinations" aria-haspopup="dialog"
                    aria-label="Ouvrir les destinations">
                <img src="{{ asset('REDI.png') }}" alt="" class="search-bar-v2-globe-icon" width="30" height="30" decoding="async">
                <span class="search-bar-v2-destinations-title">Destinations</span>
            </button>

            <div class="search-bar-v2-search">
                <div class="search-bar-v2-input-wrapper">
                    <svg class="search-bar-v2-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    <input type="text" class="search-bar-v2-input" id="searchBarInput"
                           placeholder="Explorez le monde…"
                           aria-label="Rechercher une destination, une activité, une catégorie" autocomplete="off">
                    <button class="search-bar-v2-clear-btn" id="searchBarClearBtn" type="button" aria-label="Effacer">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="search-bar-v2-results" id="searchBarResults">
                    <div class="search-bar-v2-results-header">
                        <h4 class="search-bar-v2-results-title">Résultats de la recherche</h4>
                    </div>
                    <ul class="search-bar-v2-results-list" id="searchBarResultsList"></ul>
                </div>
            </div>

            {{-- ACTIVITÉS : même relais, vers le panneau « activités ». --}}
            <button type="button" class="gxhsearch__bloc"
                    data-gxhsearch-relais="activites" aria-haspopup="dialog"
                    aria-label="Ouvrir les activités">
                <img src="{{ asset('Plan-and-go.png') }}" alt="Plan and Go" class="gxhsearch__logo" width="199" height="65" decoding="async">
                <span class="gxhsearch__legende">
                    Activités <i class="fas fa-chevron-down" aria-hidden="true"></i>
                </span>
            </button>
        </div>
    </div>
</div>

<script>
(function () {
    function init() {
        var barre = document.querySelector('[data-gx-header-search]');
        if (! barre) { return; }

        /* Garde-fou : si la page porte DÉJÀ un champ #searchBarInput (la
           bannière de l'accueil), deux éléments partageraient l'identifiant et
           SearchBarV2 ne piloterait que le premier. La barre de l'en-tête
           s'efface alors — c'est la copie, pas l'original. */
        if (document.querySelectorAll('#searchBarInput').length > 1) {
            barre.remove();
            return;
        }

        /* Les deux blocs latéraux rouvrent les panneaux de la barre de widgets
           plutôt que d'embarquer leurs propres méga-menus : ceux-ci pèsent
           plusieurs centaines de Ko de HTML, alors que les panneaux de la
           barre chargent leur contenu au premier clic. */
        barre.querySelectorAll('[data-gxhsearch-relais]').forEach(function (bouton) {
            bouton.addEventListener('click', function (e) {
                e.preventDefault();
                var nom = bouton.getAttribute('data-gxhsearch-relais');
                var cible = document.querySelector('.gxrail [data-gxrail-open="' + nom + '"]');
                if (cible) { cible.click(); }
            });
        });
    }

    if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', init); }
    else { init(); }
})();
</script>
@endonce
