{{-- Liens de destination → nouvel onglet.

     Sur la fiche d'une activité, les liens vers les destinations viennent tous
     des éléments PARTAGÉS de la plateforme (menus de l'en-tête, grille du menu
     vertical, barre verticale de widgets). On ne touche donc pas à ces
     composants — ils servent aussi l'accueil et les pages destination, où le
     visiteur VEUT naviguer — mais on marque leurs liens ici, sur cette page
     seulement : le visiteur garde la fiche de l'activité sous les yeux.

     Plusieurs de ces menus sont chargés à la demande (fetch au premier clic) :
     un seul passage au chargement ne suffirait pas, d'où l'observateur. --}}
<script>
    (function () {
        'use strict';

        var SELECTEUR = 'a[href*="/travel-destination/"]';

        // Jamais de nouvel onglet pour un lien sortant : un href absolu doit
        // pointer sur ce même hôte.
        var interne = function (href) {
            if (!/^https?:\/\//i.test(href)) return true;
            try { return new URL(href, location.href).host === location.host; }
            catch (e) { return false; }
        };

        var marquerLien = function (a) {
            if (a.target === '_blank') return;
            var href = a.getAttribute('href') || '';
            if (href.indexOf('/travel-destination/') === -1 || !interne(href)) return;

            a.target = '_blank';
            var rel = (a.getAttribute('rel') || '').split(/\s+/).filter(Boolean);
            if (rel.indexOf('noopener') === -1) rel.push('noopener');
            a.setAttribute('rel', rel.join(' '));
        };

        var marquer = function (racine) {
            if (!racine || racine.nodeType !== 1) return;
            if (racine.matches && racine.matches(SELECTEUR)) marquerLien(racine);
            if (!racine.querySelectorAll) return;
            var liens = racine.querySelectorAll(SELECTEUR);
            for (var i = 0; i < liens.length; i++) marquerLien(liens[i]);
        };

        var lancer = function () {
            marquer(document.body);

            if (!window.MutationObserver) return;
            // On ne reparcourt que ce qui vient d'être ajouté : le document
            // entier à chaque mutation coûterait cher (carrousels, cartes).
            new MutationObserver(function (lots) {
                for (var i = 0; i < lots.length; i++) {
                    var ajouts = lots[i].addedNodes;
                    for (var j = 0; j < ajouts.length; j++) marquer(ajouts[j]);
                }
            }).observe(document.body, { childList: true, subtree: true });
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', lancer);
        } else {
            lancer();
        }
    })();
</script>
