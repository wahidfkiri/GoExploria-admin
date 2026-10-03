/* BOUSSOLE — script partagé des gabarits « rubriques » (page de catégorie,
   page d'activité) : filtres des établissements et défilement doux.

   Source unique : scripts/fragments/boussole.js, publié dans public/ des DEUX
   projets par les générateurs — ne pas éditer les copies.

   Contrainte (docs/TEMPLATES-CMS.md §5) : ce script n'écrit RIEN dans le
   contenu enregistré. Il ne tourne d'ailleurs pas dans l'éditeur — y masquer
   des cartes enregistrerait l'état du filtre, et le client ne verrait plus
   les cartes cachées.

   Il est LIÉ et non en ligne : la sauvegarde de l'éditeur récolte les
   <script> du contenu, un fichier externe n'est jamais récolté. */
(function () {
  var racine = document.documentElement;

  if (!document.querySelector('.boussole-tpl')) { return; }
  if (racine.dataset.catInit === '1') { return; }
  racine.dataset.catInit = '1';

  /* L'éditeur se reconnaît à la variable --gx-editor que pose sa feuille
     (public/vendor/activitie/vvveb-canvas.css). */
  var edition = (getComputedStyle(racine).getPropertyValue('--gx-editor') || '').trim() === '1';
  if (edition) { return; }

  /* ── Diaporama du bandeau ───────────────────────────────────────────
     Tout se joue en CSS : cette classe, posée sur <html>, autorise
     l'animation des fonds. On ne touche JAMAIS aux diapositives
     elles-mêmes — leur classe partirait dans le contenu enregistré à la
     sauvegarde suivante, et le visiteur verrait figé l'état où l'éditeur
     s'est arrêté (docs/TEMPLATES-CMS.md §5).

     Le visiteur qui demande moins d'animation garde la première
     diapositive, celle qui porte la vidéo. */
  if (!(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches)) {
    racine.classList.add('bsl-anime');
  }

  /* ── Filtres des établissements ─────────────────────────────────────
     Les boutons et les catégories des cartes viennent de la base : le site
     les réécrit au rendu (TemplateEtablissements). Ce script ne fait que
     comparer data-plx-filtre à data-categorie. Chaque groupe de filtres ne
     pilote QUE la grille de sa propre section. */
  Array.prototype.forEach.call(
    document.querySelectorAll('.boussole-tpl [data-gx-etablissements-filtres]'),
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
     Le menu s'ouvre par :target (#bsl-menu dans l'URL) : cliquer une ancre
     doit donc remplacer ce fragment, ce que fait la navigation native. On
     n'ajoute ici que le défilement doux, et seulement si le visiteur ne
     demande pas l'inverse. */
  if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) { return; }

  document.addEventListener('click', function (e) {
    var lien = e.target && e.target.closest ? e.target.closest('.boussole-tpl a[href^="#cat-"]') : null;
    if (!lien) { return; }

    var id = lien.getAttribute('href').slice(1);
    if (id === 'bsl-menu' || id === '') { return; }

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
