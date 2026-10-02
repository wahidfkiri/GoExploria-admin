/* Gabarit « Boussole » des pages de catégorie : filtres et défilement doux.
   Généré par scripts/build_category_template.py — ne pas éditer ici.

   Contrainte (docs/TEMPLATES-CMS.md §5) : ce script n'écrit RIEN dans le
   contenu enregistré. Il ne tourne d'ailleurs pas dans l'éditeur — y masquer
   des cartes enregistrerait l'état du filtre, et le client ne verrait plus
   les cartes cachées.

   Il est LIÉ et non en ligne : la sauvegarde de l'éditeur récolte les
   <script> du contenu, un fichier externe n'est jamais récolté. */
(function () {
  var racine = document.documentElement;

  if (!document.querySelector('.catpage-tpl')) { return; }
  if (racine.dataset.catInit === '1') { return; }
  racine.dataset.catInit = '1';

  /* L'éditeur se reconnaît à la variable --gx-editor que pose sa feuille
     (public/vendor/activitie/vvveb-canvas.css). */
  var edition = (getComputedStyle(racine).getPropertyValue('--gx-editor') || '').trim() === '1';
  if (edition) { return; }

  /* ── Filtres des établissements ─────────────────────────────────────
     Les boutons et les catégories des cartes viennent de la base : le site
     les réécrit au rendu (TemplateEtablissements). Ce script ne fait que
     comparer data-plx-filtre à data-categorie. Chaque groupe de filtres ne
     pilote QUE la grille de sa propre section. */
  Array.prototype.forEach.call(
    document.querySelectorAll('.catpage-tpl [data-gx-etablissements-filtres]'),
    function (filtres) {
      var section = filtres.closest('section') || document;
      var grille = section.querySelector('[data-gx-etablissements]');
      if (!grille) { return; }

      filtres.addEventListener('click', function (e) {
        var bouton = e.target && e.target.closest ? e.target.closest('[data-plx-filtre]') : null;
        if (!bouton) { return; }
        e.preventDefault();

        var voulu = bouton.getAttribute('data-plx-filtre') || '*';

        Array.prototype.forEach.call(filtres.querySelectorAll('[data-plx-filtre]'), function (b) {
          b.classList.toggle('is-active', b === bouton);
        });

        Array.prototype.forEach.call(grille.children, function (carte) {
          var cles = (carte.getAttribute('data-categorie') || '').split(/\s+/);
          carte.style.display = (voulu === '*' || cles.indexOf(voulu) !== -1) ? '' : 'none';
        });
      });
    }
  );

  /* ── Défilement doux + fermeture du menu mobile ─────────────────────
     Le menu s'ouvre par :target (#cat-menu dans l'URL) : cliquer une ancre
     doit donc remplacer ce fragment, ce que fait la navigation native. On
     n'ajoute ici que le défilement doux, et seulement si le visiteur ne
     demande pas l'inverse. */
  if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) { return; }

  document.addEventListener('click', function (e) {
    var lien = e.target && e.target.closest ? e.target.closest('.catpage-tpl a[href^="#cat-"]') : null;
    if (!lien) { return; }

    var id = lien.getAttribute('href').slice(1);
    if (id === 'cat-menu' || id === '') { return; }

    var cible = document.getElementById(id);
    if (!cible) { return; }

    e.preventDefault();
    cible.scrollIntoView({ behavior: 'smooth', block: 'start' });

    /* Le fragment est remis à vide pour refermer le menu mobile, sans
       empiler d'entrée dans l'historique. */
    if (window.history && window.history.replaceState) {
      window.history.replaceState(null, '', window.location.pathname + window.location.search);
    }
  });
})();
