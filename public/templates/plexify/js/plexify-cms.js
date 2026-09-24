/* Menu, carrousels et héros de la page par défaut des activités.
   Généré par scripts/build_activity_default_page.py — ne pas éditer ici.

   Contrainte (docs/TEMPLATES-CMS.md §5) : ce script n'écrit RIEN dans le
   contenu enregistré — il tourne aussi dans l'éditeur. L'état d'ouverture du
   menu et la vidéo affichée vivent sur <html>, le défilement des pistes vit
   dans le scroll : rien de cela n'est un attribut du document sauvegardé. */
(function () {
  var racine = document.documentElement;
  if (!document.querySelector('.actpage-tpl')) return;
  if (racine.dataset.plxInit === '1') return;
  racine.dataset.plxInit = '1';

  /* Menu mobile : la classe d'ouverture est posée sur <html>, hors contenu. */
  var burger = document.querySelector('.actpage-tpl .xmenu-toggler');
  var voile = document.querySelector('.actpage-tpl .menu-close');
  var menu = document.querySelector('.actpage-tpl .header-nav');

  function basculer(ouvrir) {
    racine.classList.toggle('plx-menu-ouvert', ouvrir);
    if (burger) burger.setAttribute('aria-expanded', ouvrir ? 'true' : 'false');
  }

  if (burger) {
    burger.addEventListener('click', function (e) {
      e.preventDefault();
      basculer(!racine.classList.contains('plx-menu-ouvert'));
    });
  }
  if (voile) voile.addEventListener('click', function () { basculer(false); });
  if (menu) {
    menu.addEventListener('click', function (e) {
      if (e.target.closest('a')) basculer(false);
    });
  }

  /* Pistes à ancrage : les flèches amènent la carte voisine.

     On vise la POSITION EXACTE d'une carte, et on l'affecte à scrollLeft.
     Deux raisons : scrollBy() d'une largeur approchée tombe entre deux points
     d'ancrage, et surtout `behavior: 'smooth'` est ANNULÉ par le navigateur
     sur un conteneur en scroll-snap mandatory quand la cible n'est pas
     exactement un point d'ancrage — mesuré : la piste ne bougeait pas d'un
     pixel. L'animation vient donc du CSS (scroll-behavior sur .swiper), que
     l'affectation directe respecte. */
  Array.prototype.forEach.call(
    document.querySelectorAll('.actpage-tpl [data-plx-nav]'),
    function (groupe) {
      var piste = document.querySelector('.actpage-tpl .' + groupe.getAttribute('data-plx-nav'));
      if (!piste) return;

      Array.prototype.forEach.call(groupe.querySelectorAll('[data-plx-sens]'), function (bouton) {
        bouton.addEventListener('click', function () {
          var cartes = piste.querySelectorAll('.swiper-slide');
          if (!cartes.length) return;

          var base = cartes[0].offsetLeft;
          var courant = 0;
          var ecart = Infinity;

          for (var i = 0; i < cartes.length; i++) {
            var d = Math.abs((cartes[i].offsetLeft - base) - piste.scrollLeft);
            if (d < ecart) { ecart = d; courant = i; }
          }

          var sens = parseInt(bouton.getAttribute('data-plx-sens'), 10);
          var cible = Math.max(0, Math.min(cartes.length - 1, courant + sens));
          piste.scrollLeft = cartes[cible].offsetLeft - base;
        });
      });
    }
  );

  /* Héros : diaporama de vidéos.

     L'éditeur se reconnaît à la variable --gx-editor que pose sa feuille.
     Là, les flèches changent seulement la vidéo affichée — pas de minuterie,
     pas de lecture automatique, pas de points : tout cela écrirait dans le
     contenu enregistré, ou lancerait un lecteur sous le curseur. */
  var edition = (getComputedStyle(racine).getPropertyValue('--gx-editor') || '').trim() === '1';
  if (edition) racine.classList.add('plx-edition');

  var heros = document.querySelector('.actpage-tpl .plx-diapos');
  if (heros) {
    var banniere = heros.parentNode;
    var duree = parseInt(heros.getAttribute('data-plx-duree'), 10) || 5000;
    var DUREE_LECTEUR = 15000;
    var immobile = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var courant = 0;
    var minuteur = null;
    var points = null;

    var diapos = function () {
      return Array.prototype.filter.call(heros.children, function (n) {
        return n.classList.contains('plx-diapo');
      });
    };

    /* Un lecteur YouTube démarre quand on ajoute autoplay=1 à son adresse ;
       le retirer recharge le lecteur, donc l'arrête. */
    var sansLecture = function (src) {
      return src.replace(/([?&])autoplay=1(&|$)/, function (m, avant, apres) {
        return apres ? avant : '';
      });
    };

    var piloter = function (liste) {
      liste.forEach(function (diapo, i) {
        var video = diapo.querySelector('video');
        if (video) {
          if (i === courant) {
            video.muted = true;
            try { video.currentTime = 0; } catch (e) {}
            var lecture = video.play();
            if (lecture && lecture.catch) lecture.catch(function () {});
          } else {
            video.pause();
          }
        }

        var cadre = diapo.querySelector('iframe');
        if (cadre) {
          var src = cadre.getAttribute('src') || '';
          var base = sansLecture(src);
          var voulu = i === courant ? base + (base.indexOf('?') === -1 ? '?' : '&') + 'autoplay=1' : base;
          if (voulu !== src) cadre.setAttribute('src', voulu);
        }
      });
    };

    var afficher = function (index) {
      var liste = diapos();
      if (!liste.length) return;

      courant = ((index % liste.length) + liste.length) % liste.length;
      racine.setAttribute('data-plx-heros-vue', String(courant + 1));

      if (edition) return;

      if (points) {
        Array.prototype.forEach.call(points.children, function (point, i) {
          point.classList.toggle('is-active', i === courant);
        });
      }
      piloter(liste);

      clearTimeout(minuteur);
      if (!immobile && liste.length > 1) {
        var delai = liste[courant].querySelector('iframe') ? Math.max(duree, DUREE_LECTEUR) : duree;
        minuteur = setTimeout(function () { afficher(courant + 1); }, delai);
      }
    };

    Array.prototype.forEach.call(
      banniere.querySelectorAll('[data-plx-heros]'),
      function (fleche) {
        fleche.addEventListener('click', function (e) {
          e.preventDefault();
          afficher(courant + (parseInt(fleche.getAttribute('data-plx-heros'), 10) || 1));
        });
      }
    );

    if (!edition) {
      var liste = diapos();
      if (liste.length > 1) {
        points = document.createElement('div');
        points.className = 'plx-points';
        liste.forEach(function (d, i) {
          var point = document.createElement('button');
          point.type = 'button';
          point.className = 'plx-point';
          point.setAttribute('aria-label', 'Vidéo ' + (i + 1));
          point.addEventListener('click', function () { afficher(i); });
          points.appendChild(point);
        });
        banniere.appendChild(points);
      }
      afficher(0);
    }
  }

  /* Filtres de la section « Établissements à proximité ».

     Les boutons et les catégories des cartes viennent de la base (le site les
     réécrit au rendu) : ce script ne fait que comparer data-plx-filtre à
     data-categorie. Il ne tourne PAS dans l'éditeur — masquer des cartes y
     écrirait l'état du filtre dans le contenu enregistré (§5), et le client
     ne verrait plus les cartes cachées. */
  if (!edition) {
    Array.prototype.forEach.call(
      document.querySelectorAll('.actpage-tpl [data-gx-etablissements-filtres]'),
      function (filtres) {
        var section = filtres.closest('section') || document;
        var grille = section.querySelector('[data-gx-etablissements]');
        if (!grille) return;

        filtres.addEventListener('click', function (e) {
          var bouton = e.target && e.target.closest ? e.target.closest('[data-plx-filtre]') : null;
          if (!bouton) return;
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
  }

  /* Ménage des contenus enregistrés par une version antérieure du gabarit. */
  Array.prototype.forEach.call(
    document.querySelectorAll('.actpage-tpl [data-swiper-slide-index], .actpage-tpl .swiper-slide-duplicate'),
    function (noeud) { if (noeud.parentNode) noeud.parentNode.removeChild(noeud); }
  );
})();
