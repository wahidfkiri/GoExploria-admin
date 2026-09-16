{{-- ==========================================================================
     MÉGA-MENU « ACTIVITÉS » — pleine largeur, sous l'en-tête de la plateforme
     ==========================================================================
     Déclencheur : le lien « ACTIVITÉS » que le Header (welcome-home) n'affiche
     QUE si la page passe `gxHeaderActivitesMenu` à platform-header — les
     autres pages qui partagent ce header ne changent pas.

     Ce fichier ne porte que l'ENVELOPPE (panneau, styles, script). Le contenu
     — toutes les activités actives, près d'un millier — est chargé à la
     première ouverture depuis la route travel-destination.activities-menu
     (vue activities-mega-menu-content) : la page n'embarque pas des centaines
     de Ko que la plupart des visiteurs n'ouvrent jamais. Il est pré-chargé
     dès le survol du lien.

     Desktop : ouverture au survol (avec délai) ou au clic, panneau collé sous
     l'en-tête (hauteur mesurée par index.blade.php : --gx-entete-plateforme).
     Mobile (≤ 992 px) : le lien est dans le tiroir du menu ; le panneau
     s'ouvre en plein écran, avec un bouton de fermeture.
     ========================================================================== --}}
<div class="td-actmega" id="tdActMega" role="dialog" aria-modal="false" aria-label="Activités" aria-hidden="true">
  <div class="td-actmega__inner">
    <div class="td-actmega__top">
      <p class="td-actmega__kicker"><i class="fas fa-person-hiking" aria-hidden="true"></i> Activités GoExploria</p>
      <button type="button" class="td-actmega__close" data-td-actmega-close aria-label="Fermer le menu des activités">
        <i class="fas fa-xmark" aria-hidden="true"></i>
      </button>
    </div>
    <div class="td-actmega__body" data-td-actmega-body data-src="{{ route('travel-destination.activities-menu') }}" aria-live="polite">
      <p class="td-actmega__status"><span class="td-actmega__spinner" aria-hidden="true"></span> Chargement des activités…</p>
    </div>
  </div>
</div>

<style>
  /* ── Lien du header ─────────────────────────────────────────────────── */
  .gx-platform-header .nav-menu-v2-activites > a { gap: 6px; }
  .gx-platform-header .nav-menu-v2-activites > a i { font-size: 9px; transition: transform .2s ease; }
  .gx-platform-header .nav-menu-v2-activites > a[aria-expanded="true"] { color: var(--accent-gold) !important; }
  .gx-platform-header .nav-menu-v2-activites > a[aria-expanded="true"] i { transform: rotate(180deg); }

  /* Place dans la barre : le lien ajoute ≈ 110 px, qui faisaient déborder
     l'en-tête entre 993 et 1440 px (mesuré : +109 px à 1280). Sur ces
     largeurs, et sur les pages destination seulement, on resserre le menu et
     « Chaîne vidéos » / « Activer Mon Compte » passent en icône seule. */
  @media (min-width: 993px) and (max-width: 1440px) {
    .gx-platform-header .header-v2 .nav-menu { gap: 16px !important; }
    .gx-platform-header .nav-video-channel-link span { display: none; }
  }
  @media (min-width: 993px) and (max-width: 1200px) {
    .gx-platform-header .header-v2 .nav-menu { gap: 12px !important; }
    .gx-platform-header .header-v2 .nav-account-icon { font-size: 0 !important; gap: 0 !important; }
    .gx-platform-header .header-v2 .nav-account-icon i { font-size: 18px; }
  }

  /* ── Panneau ────────────────────────────────────────────────────────── */
  .td-actmega {
    --ta-ink: #0f172a; --ta-muted: #64748b; --ta-line: #e5e7eb;
    --ta-soft: #f6f7f9; --ta-gold: #d4af37; --ta-gold-ink: #8a6d10;
    position: fixed; left: 0; right: 0;
    top: var(--gx-entete-plateforme, 96px);
    z-index: 10150;
    max-height: calc(100vh - var(--gx-entete-plateforme, 96px));
    overflow: hidden;
    display: flex;
    background: #fff;
    color: var(--ta-ink);
    border-top: 3px solid var(--ta-gold);
    box-shadow: 0 24px 60px rgba(2, 6, 23, .28);
    font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    opacity: 0; visibility: hidden; transform: translateY(-8px);
    transition: opacity .2s ease, transform .2s ease, visibility .2s;
  }
  .td-actmega.is-open { opacity: 1; visibility: visible; transform: none; }
  .td-actmega__inner {
    width: min(1320px, 100%); margin: 0 auto;
    padding: 18px clamp(16px, 3vw, 36px) 22px;
    display: flex; flex-direction: column; min-height: 0;
  }
  .td-actmega__top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
  .td-actmega__kicker {
    margin: 0; display: inline-flex; align-items: center; gap: 8px;
    font-size: 11px; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; color: var(--ta-gold-ink);
  }
  .td-actmega__close {
    width: 36px; height: 36px; border-radius: 50%; border: 1px solid var(--ta-line);
    background: #fff; color: var(--ta-ink); cursor: pointer; display: grid; place-items: center; font-size: 16px;
  }
  .td-actmega__close:hover { background: var(--ta-soft); }
  .td-actmega__body { display: flex; gap: 28px; min-height: 0; flex: 1 1 auto; }

  .td-actmega__status, .td-actmega__empty {
    margin: 0; padding: 28px 0; width: 100%; text-align: center;
    font-size: 14px; color: var(--ta-muted);
    display: flex; align-items: center; justify-content: center; gap: 10px;
  }
  .td-actmega__status a { color: var(--ta-gold-ink); font-weight: 700; }
  .td-actmega__spinner {
    width: 18px; height: 18px; border-radius: 50%;
    border: 2px solid var(--ta-line); border-top-color: var(--ta-gold);
    animation: tdActSpin .8s linear infinite;
  }
  @keyframes tdActSpin { to { transform: rotate(360deg); } }

  .td-actmega__tabs {
    flex: 0 0 250px; display: flex; flex-direction: column; gap: 2px;
    padding-right: 18px; border-right: 1px solid var(--ta-line);
    overflow-y: auto; max-height: calc(100vh - var(--gx-entete-plateforme, 96px) - 90px);
  }
  .td-actmega__tab {
    display: flex; align-items: center; justify-content: space-between; gap: 10px;
    width: 100%; padding: 10px 12px; border: 0; border-radius: 10px;
    background: transparent; color: var(--ta-ink); cursor: pointer;
    font-family: inherit; font-size: 13.5px; font-weight: 600; line-height: 1.3; text-align: left;
  }
  .td-actmega__tab span { min-width: 0; }
  .td-actmega__tab em {
    flex: 0 0 auto; font-style: normal; font-size: 11px; font-weight: 700;
    padding: 2px 8px; border-radius: 999px; background: var(--ta-soft); color: var(--ta-muted);
  }
  .td-actmega__tab:hover { background: var(--ta-soft); }
  .td-actmega__tab.is-active { background: #0a1628; color: #fff; }
  .td-actmega__tab.is-active em { background: var(--ta-gold); color: #0a1628; }

  .td-actmega__panes {
    flex: 1 1 auto; min-width: 0; overflow-y: auto;
    max-height: calc(100vh - var(--gx-entete-plateforme, 96px) - 90px);
    padding-right: 4px;
  }
  .td-actmega__pane[hidden] { display: none; }
  .td-actmega__head { display: flex; align-items: baseline; justify-content: space-between; gap: 16px; }
  .td-actmega__title { margin: 2px 0 14px; font-size: 20px; font-weight: 800; color: var(--ta-ink); }
  .td-actmega__title small { font-size: 12px; font-weight: 600; color: var(--ta-muted); margin-left: 6px; }
  .td-actmega__more { font-size: 13px; font-weight: 700; color: var(--ta-gold-ink); text-decoration: none; white-space: nowrap; }
  .td-actmega__more:hover { text-decoration: underline; }

  /* Index A→Z */
  .td-actmega__az { columns: 4 210px; column-gap: 32px; }
  .td-actmega__letter { break-inside: avoid; margin: 0 0 16px; }
  .td-actmega__letter h4 {
    margin: 0 0 6px; padding-bottom: 4px; border-bottom: 2px solid var(--ta-gold);
    font-size: 15px; font-weight: 800; color: var(--ta-gold-ink); line-height: 1.2;
  }
  .td-actmega__letter ul { list-style: none; margin: 0; padding: 0; }
  .td-actmega__letter li { margin: 0; }
  .td-actmega__letter a {
    display: block; padding: 3px 0; font-size: 13px; font-weight: 500; line-height: 1.35;
    color: var(--ta-ink); text-decoration: none;
  }
  .td-actmega__letter a:hover { color: var(--ta-gold-ink); text-decoration: underline; }

  /* Vignettes */
  .td-actmega__grid { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: 18px 16px; }
  .td-actmega__card { display: block; min-width: 0; color: var(--ta-ink); text-decoration: none; }
  .td-actmega__media {
    display: block; position: relative; aspect-ratio: 4 / 3; border-radius: 12px; overflow: hidden; background: var(--ta-soft);
  }
  .td-actmega__media img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .35s ease; }
  .td-actmega__card:hover .td-actmega__media img { transform: scale(1.05); }
  .td-actmega__ph { position: absolute; inset: 0; display: grid; place-items: center; color: #b7bec8; font-size: 26px; }
  .td-actmega__name {
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    margin-top: 8px; font-size: 13.5px; font-weight: 600; line-height: 1.3;
  }
  .td-actmega__card:hover .td-actmega__name { color: var(--ta-gold-ink); }

  @media (max-width: 1280px) { .td-actmega__grid { grid-template-columns: repeat(5, minmax(0, 1fr)); } }
  @media (max-width: 1100px) { .td-actmega__grid { grid-template-columns: repeat(4, minmax(0, 1fr)); } }

  /* Mobile : plein écran, catégories en ruban défilant */
  @media (max-width: 992px) {
    .td-actmega { top: 0; max-height: none; height: 100vh; height: 100dvh; z-index: 10400; border-top: 0; }
    .td-actmega__inner { padding: 14px 14px 0; }
    .td-actmega__body { flex-direction: column; gap: 12px; }
    .td-actmega__tabs {
      flex: 0 0 auto; flex-direction: row; gap: 6px; overflow-x: auto; overflow-y: hidden;
      max-height: none; padding: 0 0 10px; border-right: 0; border-bottom: 1px solid var(--ta-line);
      -webkit-overflow-scrolling: touch;
    }
    .td-actmega__tab { width: auto; flex: 0 0 auto; white-space: nowrap; padding: 8px 12px; background: var(--ta-soft); }
    .td-actmega__panes { max-height: none; flex: 1 1 auto; padding-bottom: 24px; }
    .td-actmega__grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px 12px; }
    .td-actmega__az { columns: 2 150px; column-gap: 20px; }
    .td-actmega__title { font-size: 17px; }
  }
  @media (max-width: 560px) { .td-actmega__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
  @media (min-width: 993px) { .td-actmega__close { display: none; } }
  @media (prefers-reduced-motion: reduce) {
    .td-actmega, .td-actmega__media img { transition: none; }
    .td-actmega__spinner { animation: none; }
  }
</style>

<script>
(function () {
  function init() {
    var panel = document.getElementById('tdActMega');
    var trigger = document.getElementById('gxHeaderActivitesTrigger');
    if (!panel || !trigger || trigger.dataset.tdBound === '1') return;
    trigger.dataset.tdBound = '1';

    var item = trigger.closest('li') || trigger;
    var body = panel.querySelector('[data-td-actmega-body]');
    var desktop = window.matchMedia('(min-width: 993px) and (hover: hover)');
    var hoverTimer = null;
    var chargement = null;   // promesse du contenu (une seule requête)

    function isOpen() { return panel.classList.contains('is-open'); }

    /* Contenu chargé une fois ; en cas d'échec, on propose de réessayer. */
    function charger() {
      if (chargement) return chargement;
      chargement = fetch(body.getAttribute('data-src'), { headers: { 'Accept': 'text/html' }, credentials: 'same-origin' })
        .then(function (r) {
          if (!r.ok) throw new Error('HTTP ' + r.status);
          return r.text();
        })
        .then(function (html) {
          body.innerHTML = html;
          brancherOnglets();
        })
        .catch(function () {
          chargement = null;   // un prochain survol / clic retentera
          body.innerHTML = '<p class="td-actmega__status">Impossible de charger les activités. '
            + '<a href="#" data-td-actmega-retry>Réessayer</a></p>';
        });
      return chargement;
    }

    body.addEventListener('click', function (e) {
      if (!e.target.closest('[data-td-actmega-retry]')) return;
      e.preventDefault();
      body.innerHTML = '<p class="td-actmega__status"><span class="td-actmega__spinner" aria-hidden="true"></span> Chargement des activités…</p>';
      charger();
    });

    function open() {
      if (isOpen()) return;
      // Un seul méga-menu à la fois (coordination du site).
      if (typeof window.goCloseOtherMega === 'function') window.goCloseOtherMega(panel);
      charger();
      panel.classList.add('is-open');
      panel.setAttribute('aria-hidden', 'false');
      trigger.setAttribute('aria-expanded', 'true');
      if (!desktop.matches) document.documentElement.style.overflow = 'hidden';
    }

    function close() {
      if (!isOpen()) return;
      panel.classList.remove('is-open');
      panel.setAttribute('aria-hidden', 'true');
      trigger.setAttribute('aria-expanded', 'false');
      document.documentElement.style.overflow = '';
    }

    window.goMegaClosers = window.goMegaClosers || [];
    window.goMegaClosers.push(function (except) { if (except !== panel) close(); });

    // Capture sur le <li> : navigation.js écoute TOUS les a[href^="#"] et
    // ferait défiler vers #activites (repli sans JS) en fermant le tiroir
    // mobile. Arrêté ici, le clic n'atteint jamais le lien.
    item.addEventListener('click', function (e) {
      if (!trigger.contains(e.target)) return;
      e.preventDefault();
      e.stopPropagation();
      isOpen() ? close() : open();
    }, true);

    // Survol (desktop) : pré-chargement immédiat, ouverture avec délai pour
    // ne pas ouvrir en traversant le menu.
    function hoverIn() {
      if (!desktop.matches) return;
      charger();
      clearTimeout(hoverTimer);
      hoverTimer = setTimeout(open, 120);
    }
    function hoverOut() {
      if (!desktop.matches) return;
      clearTimeout(hoverTimer);
      hoverTimer = setTimeout(close, 220);
    }
    [item, panel].forEach(function (el) {
      el.addEventListener('mouseenter', hoverIn);
      el.addEventListener('mouseleave', hoverOut);
    });
    trigger.addEventListener('focus', charger);

    panel.querySelectorAll('[data-td-actmega-close]').forEach(function (b) {
      b.addEventListener('click', close);
    });

    document.addEventListener('click', function (e) {
      if (isOpen() && !panel.contains(e.target) && !item.contains(e.target)) close();
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') close();
    });

    // Onglets (contenu inséré après chargement) : clic partout, survol en desktop.
    function brancherOnglets() {
      var tabs = panel.querySelectorAll('.td-actmega__tab');
      var panes = panel.querySelector('.td-actmega__panes');
      tabs.forEach(function (tab) {
        function select() {
          var pane = document.getElementById(tab.getAttribute('data-td-pane'));
          if (!pane || tab.classList.contains('is-active')) return;
          tabs.forEach(function (t) { t.classList.remove('is-active'); t.setAttribute('aria-selected', 'false'); });
          panel.querySelectorAll('.td-actmega__pane').forEach(function (p) { p.hidden = true; });
          tab.classList.add('is-active');
          tab.setAttribute('aria-selected', 'true');
          pane.hidden = false;
          if (panes) panes.scrollTop = 0;
        }
        tab.addEventListener('click', select);
        tab.addEventListener('mouseenter', function () { if (desktop.matches) select(); });
      });
    }
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
</script>
