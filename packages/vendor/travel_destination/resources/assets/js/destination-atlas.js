/* ==========================================================================
   GO EXPLORIA — DESTINATION TEMPLATE — destination.js
   Vanilla JS only. No external dependencies.
   ========================================================================== */
(function () {
  "use strict";

  document.addEventListener("DOMContentLoaded", init);

  function init() {
    initTheme();
    initHeader();
    initMobileNav();
    initReveal();
    initCounters();
    initGalleryLightbox();
    initSliders();
    initVideoModal();
    initFaqAccordion();
    initNewsletterForm();
    initSmoothAnchors();
  }

  /* ------------------------------------------------------------------
     THEME TOGGLE (light / dark) — persists via localStorage
  ------------------------------------------------------------------ */
  function initTheme() {
    var root = document.documentElement;
    var toggles = document.querySelectorAll("[data-theme-toggle]");
    var stored = null;
    try { stored = localStorage.getItem("ge-theme"); } catch (e) {}

    var prefersDark = window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches;
    var initialTheme = stored || (prefersDark ? "dark" : "light");
    root.setAttribute("data-theme", initialTheme);

    toggles.forEach(function (btn) {
      btn.addEventListener("click", function () {
        var current = root.getAttribute("data-theme") === "dark" ? "light" : "dark";
        root.setAttribute("data-theme", current);
        try { localStorage.setItem("ge-theme", current); } catch (e) {}
      });
    });
  }

  /* ------------------------------------------------------------------
     STICKY HEADER
  ------------------------------------------------------------------ */
  function initHeader() {
    var header = document.querySelector(".site-header");
    if (!header) return;
    function onScroll() {
      if (window.scrollY > 40) {
        header.classList.add("is-scrolled");
      } else {
        header.classList.remove("is-scrolled");
      }
    }
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
  }

  /* ------------------------------------------------------------------
     MOBILE MENU
  ------------------------------------------------------------------ */
  function initMobileNav() {
    var burger = document.querySelector(".hamburger");
    var nav = document.querySelector(".mobile-nav");
    if (!burger || !nav) return;

    function close() {
      burger.classList.remove("is-active");
      nav.classList.remove("is-open");
      document.body.style.overflow = "";
    }
    function toggle() {
      var open = nav.classList.toggle("is-open");
      burger.classList.toggle("is-active", open);
      document.body.style.overflow = open ? "hidden" : "";
    }
    burger.addEventListener("click", toggle);
    nav.querySelectorAll("a").forEach(function (a) {
      a.addEventListener("click", close);
    });
  }

  /* ------------------------------------------------------------------
     SCROLL REVEAL (IntersectionObserver)
  ------------------------------------------------------------------ */
  function initReveal() {
    var items = document.querySelectorAll(".reveal");
    if (!items.length) return;

    if (!("IntersectionObserver" in window)) {
      items.forEach(function (el) { el.classList.add("is-visible"); });
      return;
    }

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15, rootMargin: "0px 0px -60px 0px" }
    );

    items.forEach(function (el) {
      var parent = el.closest(".reveal-stagger");
      if (parent) {
        var idx = Array.prototype.indexOf.call(parent.children, el);
        el.style.setProperty("--i", idx);
      }
      observer.observe(el);
    });
  }

  /* ------------------------------------------------------------------
     ANIMATED COUNTERS (statistics section)
  ------------------------------------------------------------------ */
  function initCounters() {
    var counters = document.querySelectorAll("[data-counter]");
    if (!counters.length) return;

    if (!("IntersectionObserver" in window)) {
      counters.forEach(runCounter);
      return;
    }

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            runCounter(entry.target);
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.4 }
    );
    counters.forEach(function (el) { observer.observe(el); });

    function runCounter(el) {
      var target = parseFloat(el.getAttribute("data-counter"));
      var suffix = el.getAttribute("data-suffix") || "";
      var duration = 1600;
      var start = null;

      function step(ts) {
        if (!start) start = ts;
        var progress = Math.min((ts - start) / duration, 1);
        var eased = 1 - Math.pow(1 - progress, 3);
        var value = Math.floor(eased * target);
        el.textContent = value + suffix;
        if (progress < 1) {
          requestAnimationFrame(step);
        } else {
          el.textContent = target + suffix;
        }
      }
      requestAnimationFrame(step);
    }
  }

  /* ------------------------------------------------------------------
     GALLERY LIGHTBOX (grid + masonry share one lightbox)
  ------------------------------------------------------------------ */
  function initGalleryLightbox() {
    var triggers = document.querySelectorAll("[data-lightbox-src]");
    var lightbox = document.querySelector(".lightbox");
    if (!triggers.length || !lightbox) return;

    var imgEl = lightbox.querySelector("img");
    var counterEl = lightbox.querySelector(".lightbox-counter");
    var closeBtn = lightbox.querySelector(".lightbox-close");
    var prevBtn = lightbox.querySelector(".lightbox-prev");
    var nextBtn = lightbox.querySelector(".lightbox-next");

    var items = Array.prototype.map.call(triggers, function (t) {
      return { src: t.getAttribute("data-lightbox-src"), alt: t.getAttribute("data-lightbox-alt") || "" };
    });
    var current = 0;

    function open(index) {
      current = index;
      render();
      lightbox.classList.add("is-open");
      document.body.style.overflow = "hidden";
    }
    function close() {
      lightbox.classList.remove("is-open");
      document.body.style.overflow = "";
    }
    function render() {
      imgEl.src = items[current].src;
      imgEl.alt = items[current].alt;
      counterEl.textContent = (current + 1) + " / " + items.length;
    }
    function prev() { current = (current - 1 + items.length) % items.length; render(); }
    function next() { current = (current + 1) % items.length; render(); }

    triggers.forEach(function (t, i) {
      t.addEventListener("click", function () { open(i); });
    });
    closeBtn.addEventListener("click", close);
    prevBtn.addEventListener("click", prev);
    nextBtn.addEventListener("click", next);
    lightbox.addEventListener("click", function (e) {
      if (e.target === lightbox) close();
    });
    document.addEventListener("keydown", function (e) {
      if (!lightbox.classList.contains("is-open")) return;
      if (e.key === "Escape") close();
      if (e.key === "ArrowLeft") prev();
      if (e.key === "ArrowRight") next();
    });
  }

  /* ------------------------------------------------------------------
     SLIDERS (activities featured / testimonials / events) — no lib
  ------------------------------------------------------------------ */
  function initSliders() {
    var sliders = document.querySelectorAll("[data-slider]");
    sliders.forEach(function (root) {
      var viewport = root.querySelector(".slider-viewport");
      var track = root.querySelector(".slider-track");
      var prevBtn = root.querySelector(".slider-prev");
      var nextBtn = root.querySelector(".slider-next");
      if (!viewport || !track) return;

      function slideAmount() {
        var first = track.children[0];
        if (!first) return 320;
        var style = window.getComputedStyle(track);
        var gap = parseFloat(style.gap || 22);
        return first.getBoundingClientRect().width + gap;
      }

      var position = 0;
      function maxScroll() {
        return Math.max(0, track.scrollWidth - viewport.clientWidth);
      }
      function update() {
        position = Math.min(Math.max(position, 0), maxScroll());
        track.style.transform = "translateX(" + (-position) + "px)";
      }
      if (nextBtn) nextBtn.addEventListener("click", function () {
        position += slideAmount();
        update();
      });
      if (prevBtn) prevBtn.addEventListener("click", function () {
        position -= slideAmount();
        update();
      });
      window.addEventListener("resize", update);

      // Touch / drag support
      var isDown = false, startX = 0, startPos = 0;
      viewport.addEventListener("pointerdown", function (e) {
        isDown = true; startX = e.clientX; startPos = position;
        track.style.transition = "none";
      });
      window.addEventListener("pointermove", function (e) {
        if (!isDown) return;
        position = startPos - (e.clientX - startX);
        track.style.transform = "translateX(" + (-position) + "px)";
      });
      window.addEventListener("pointerup", function () {
        if (!isDown) return;
        isDown = false;
        track.style.transition = "";
        update();
      });
    });
  }

  /* ------------------------------------------------------------------
     VIDEO MODAL (YouTube / Vimeo / local file — configured via data attrs)
  ------------------------------------------------------------------ */
  function initVideoModal() {
    var playBtns = document.querySelectorAll("[data-video-play]");
    var modal = document.querySelector(".video-modal");
    if (!playBtns.length || !modal) return;

    var inner = modal.querySelector(".modal-inner");
    var closeBtn = modal.querySelector(".video-modal-close");

    playBtns.forEach(function (btn) {
      btn.addEventListener("click", function () {
        var type = btn.getAttribute("data-video-type") || "youtube";
        var src = btn.getAttribute("data-video-src");
        var el;
        if (type === "local") {
          el = document.createElement("video");
          el.src = src;
          el.controls = true;
          el.autoplay = true;
        } else {
          el = document.createElement("iframe");
          el.src = src + (src.indexOf("?") > -1 ? "&" : "?") + "autoplay=1";
          el.allow = "autoplay; fullscreen; picture-in-picture";
          el.allowFullscreen = true;
          el.frameBorder = "0";
        }
        inner.innerHTML = "";
        inner.appendChild(el);
        modal.classList.add("is-open");
        document.body.style.overflow = "hidden";
      });
    });

    function close() {
      modal.classList.remove("is-open");
      inner.innerHTML = "";
      document.body.style.overflow = "";
    }
    closeBtn.addEventListener("click", close);
    modal.addEventListener("click", function (e) { if (e.target === modal) close(); });
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && modal.classList.contains("is-open")) close();
    });
  }

  /* ------------------------------------------------------------------
     FAQ ACCORDION
  ------------------------------------------------------------------ */
  function initFaqAccordion() {
    var items = document.querySelectorAll(".faq-item");
    items.forEach(function (item) {
      var q = item.querySelector(".faq-q");
      var a = item.querySelector(".faq-a");
      if (!q || !a) return;
      q.addEventListener("click", function () {
        var isOpen = item.classList.contains("is-open");
        items.forEach(function (other) {
          other.classList.remove("is-open");
          other.querySelector(".faq-a").style.maxHeight = null;
        });
        if (!isOpen) {
          item.classList.add("is-open");
          a.style.maxHeight = a.scrollHeight + "px";
        }
      });
    });
  }

  /* ------------------------------------------------------------------
     NEWSLETTER FORM (front-end only — swap action for real endpoint)
  ------------------------------------------------------------------ */
  function initNewsletterForm() {
    var form = document.querySelector("[data-newsletter-form]");
    if (!form) return;
    var note = form.querySelector(".newsletter-note");
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      if (note) {
        note.textContent = "Merci ! Vous recevrez bientôt nos meilleures adresses.";
        note.classList.add("is-visible");
      }
      form.reset();
    });
  }

  /* ------------------------------------------------------------------
     SMOOTH SCROLL FOR ANCHOR LINKS
  ------------------------------------------------------------------ */
  function initSmoothAnchors() {
    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
      link.addEventListener("click", function (e) {
        var id = link.getAttribute("href");
        if (id.length < 2) return;
        var target = document.querySelector(id);
        if (!target) return;
        e.preventDefault();
        var headerOffset = 90;
        var top = target.getBoundingClientRect().top + window.pageYOffset - headerOffset;
        window.scrollTo({ top: top, behavior: "smooth" });
      });
    });
  }
})();


/* ==========================================================================
   COMPLÉMENTS GO EXPLORIA
   (ajoutés par scripts/build_destination_template.py, ne pas éditer ici)
   ========================================================================== */
(function () {
  "use strict";

  /* La page de destination porte l'essentiel du contenu : on la révèle tout de
     suite plutôt que de la laisser dépendre de l'IntersectionObserver.
     Le template pose .reveal{opacity:0} et compte sur un script pour ajouter
     .is-visible — si ce script ne s'exécutait pas, la page occuperait sa
     hauteur sans rien peindre. Compromis assumé : ce bloc n'a pas l'animation
     d'apparition des sections standard, mais il ne peut jamais rester blanc. */
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".builder-page-section .reveal").forEach(function (el) {
      el.classList.add("is-visible");
    });
  });
})();

/* --------------------------------------------------------------------------
   HÉROS EN DIAPORAMA (section data-gx-destination-hero composée dans l'éditeur)
   La vidéo ouvre le diaporama ; chaque média reste affiché data-gx-hero-duree
   ms (5 s par défaut) avant de passer au suivant, en boucle. Les flèches et
   les points changent de média et relancent le compte.
   Sans script, la première diapositive reste affichée (classe is-active).
   -------------------------------------------------------------------------- */
(function () {
  "use strict";

  function demarrerHero(hero) {
    var slides = Array.prototype.slice.call(hero.querySelectorAll(".hero-slide"));
    if (!slides.length) { return; }

    var duree = parseInt(hero.getAttribute("data-gx-hero-duree"), 10) || 5000;
    var immobile = window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    var courant = 0;
    var minuteur = null;
    var DUREE_LECTEUR = 15000;
    // Une seule diapositive : ni flèches, ni points, ni minuterie — mais sa
    // vidéo doit tout de même démarrer.
    var seule = slides.length < 2;

    var points = document.createElement("div");
    points.className = "hero-dots";
    slides.forEach(function (slide, i) {
      var point = document.createElement("button");
      point.type = "button";
      point.className = "hero-dot";
      point.setAttribute("aria-label", "Diapositive " + (i + 1));
      point.addEventListener("click", function () { afficher(i); });
      points.appendChild(point);
    });
    if (!seule) { hero.appendChild(points); }

    function fleche(sens, libelle, trace) {
      var bouton = document.createElement("button");
      bouton.type = "button";
      bouton.className = "hero-nav hero-nav--" + sens;
      bouton.setAttribute("aria-label", libelle);
      bouton.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="' + trace + '"/></svg>';
      bouton.addEventListener("click", function () { afficher(courant + (sens === "prev" ? -1 : 1)); });
      if (!seule) { hero.appendChild(bouton); }
    }
    fleche("prev", "Média précédent", "M15 18l-6-6 6-6");
    fleche("next", "Média suivant", "M9 18l6-6-6-6");

    function lecteur(slide) { return slide.querySelector("video"); }

    /* Lecteurs YouTube / Vimeo : leur adresse enregistrée ne démarre pas seule
       (sinon ils tourneraient aussi dans l'éditeur). On ajoute autoplay=1 à la
       diapositive affichée — ce qui la relance du début, comme les .mp4 — et on
       le retire des autres, ce qui recharge le lecteur et donc l'arrête. */
    function sansLecture(src) {
      return src.replace(/([?&])autoplay=1(&|$)/, function (m, avant, apres) {
        return apres ? avant : "";
      });
    }

    function piloterIframes(actif) {
      slides.forEach(function (slide, i) {
        var cadre = slide.querySelector("iframe");
        if (!cadre) { return; }
        var src = cadre.getAttribute("src") || "";
        var base = sansLecture(src);
        var voulu = i === actif ? base + (base.indexOf("?") === -1 ? "?" : "&") + "autoplay=1" : base;
        if (voulu !== src) { cadre.setAttribute("src", voulu); }
      });
    }

    function programmer(delai) {
      clearTimeout(minuteur);
      if (!immobile && !seule) {
        minuteur = setTimeout(function () { afficher(courant + 1); }, delai);
      }
    }

    function afficher(index) {
      var precedent = lecteur(slides[courant]);
      courant = (index + slides.length) % slides.length;
      if (precedent && !slides[courant].contains(precedent)) { precedent.pause(); }

      slides.forEach(function (slide, i) { slide.classList.toggle("is-active", i === courant); });
      Array.prototype.forEach.call(points.children, function (point, i) {
        point.classList.toggle("is-active", i === courant);
      });

      /* Une vidéo reprend du début à chaque passage. Muette : sans cela le
         navigateur refuse la lecture automatique. */
      var video = lecteur(slides[courant]);
      if (video) {
        video.muted = true;
        try { video.currentTime = 0; } catch (e) {}
        var lecture = video.play();
        if (lecture && lecture.catch) { lecture.catch(function () {}); }
      }
      piloterIframes(courant);

      /* Même durée pour tous les médias, sauf un lecteur YouTube / Vimeo : il
         lui faut deux ou trois secondes pour se charger, 5 s n'en montreraient
         presque rien. Il reste donc au moins DUREE_LECTEUR ms. Un clic
         relance le compte. */
      programmer(slides[courant].querySelector("iframe") ? Math.max(duree, DUREE_LECTEUR) : duree);
    }

    afficher(0);
  }

  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("[data-gx-destination-hero]").forEach(demarrerHero);
  });
})();

/* Filtres de la section « Établissements à proximité ».

   Les boutons et les catégories des cartes viennent de la base : le site les
   réécrit au rendu (TemplateEtablissements). Ce script ne fait que comparer
   data-gx-filtre à data-categorie.

   ⚠ Il vit dans l'asset du SITE, pas dans le gabarit : dans l'éditeur, masquer
   des cartes écrirait l'état du filtre dans le contenu enregistré, et le
   client ne verrait plus les cartes cachées. */
(function () {
  "use strict";

  document.addEventListener('DOMContentLoaded', function () {
    var groupes = document.querySelectorAll('[data-gx-etablissements-filtres]');

    Array.prototype.forEach.call(groupes, function (filtres) {
      var section = filtres.closest('section') || document;
      var grille = section.querySelector('[data-gx-etablissements]');
      if (!grille) { return; }

      filtres.addEventListener('click', function (e) {
        var bouton = e.target && e.target.closest ? e.target.closest('[data-gx-filtre]') : null;
        if (!bouton) { return; }
        e.preventDefault();

        var voulu = bouton.getAttribute('data-gx-filtre') || '*';

        Array.prototype.forEach.call(filtres.querySelectorAll('[data-gx-filtre]'), function (b) {
          b.classList.toggle('is-active', b === bouton);
        });

        Array.prototype.forEach.call(grille.children, function (carte) {
          // Découpe sur l'espace simple — c'est ainsi que le site écrit
          // `data-categorie`. Une expression régulière obligerait à échapper
          // l'antislash dans ce fichier Python, pour rien.
          var cles = (carte.getAttribute('data-categorie') || '').split(' ');
          carte.style.display = (voulu === '*' || cles.indexOf(voulu) !== -1) ? '' : 'none';
        });
      });
    });
  });
})();
