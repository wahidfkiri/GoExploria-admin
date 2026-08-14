{{-- ═══════════════════════════════════════════════════════════════════════
     Pont iframe → parent (côté ENFANT = site de l'établissement).
     Injecté uniquement quand le template est rendu en mode « embed » à
     l'intérieur du shell GoExploria Business.

     Rôle :
       1. Mesurer la hauteur réelle du contenu et l'envoyer au parent
          (postMessage) → le parent adapte la hauteur de l'iframe.
          Aucune hauteur fixe : ResizeObserver + fallback events.
       2. Neutraliser tout scroll interne parasite (le scroll est géré par
          la page parente, hauteur = contenu).

     Sécurité : on ne poste QUE la hauteur, rien du contexte interne.
     targetOrigin = origine du parent (même origine ici) ; on lit
     window.location.origin car parent et enfant partagent l'origine.
     ═══════════════════════════════════════════════════════════════════════ --}}
<script>
(function () {
    // Ne rien faire si on n'est pas réellement dans une iframe.
    if (window.self === window.top) return;

    var CHANNEL = 'gx-embed';
    var parentOrigin = window.location.origin; // same-origin par conception
    var lastHeight = 0;

    function currentHeight() {
        var d = document.documentElement;
        var b = document.body;
        return Math.max(
            b ? b.scrollHeight : 0,
            b ? b.offsetHeight : 0,
            d ? d.scrollHeight : 0,
            d ? d.offsetHeight : 0
        );
    }

    function postHeight(force) {
        var h = currentHeight();
        if (!force && Math.abs(h - lastHeight) < 2) return; // anti-bruit
        lastHeight = h;
        try {
            window.parent.postMessage({ channel: CHANNEL, type: 'height', height: h }, parentOrigin);
        } catch (e) { /* silencieux */ }
    }

    // 1) ResizeObserver = source principale (contenu dynamique, images, menus…)
    if (typeof ResizeObserver !== 'undefined') {
        try {
            var ro = new ResizeObserver(function () { postHeight(false); });
            ro.observe(document.documentElement);
            if (document.body) ro.observe(document.body);
        } catch (e) { /* ignore */ }
    }

    // 2) Filets de sécurité : événements qui changent la hauteur.
    ['load', 'resize', 'orientationchange', 'transitionend', 'animationend'].forEach(function (evt) {
        window.addEventListener(evt, function () { postHeight(true); }, { passive: true });
    });
    document.addEventListener('DOMContentLoaded', function () { postHeight(true); });

    // 3) Chaque image qui finit de charger peut agrandir la page.
    function watchImages() {
        var imgs = document.images || [];
        for (var i = 0; i < imgs.length; i++) {
            if (!imgs[i].complete) {
                imgs[i].addEventListener('load', function () { postHeight(true); }, { passive: true });
                imgs[i].addEventListener('error', function () { postHeight(true); }, { passive: true });
            }
        }
    }

    /* Ouvre le menu mobile du template, sur demande du parent.

       POURQUOI : l'en-tête de l'établissement est en position:fixed, mais
       l'iframe n'a pas de défilement propre — sa hauteur suit le contenu et
       c'est la page parente qui défile. Un position:fixed s'y cale donc sur
       la boîte de l'iframe : l'en-tête reste en haut du document et sort de
       l'écran dès qu'on défile. Mesuré : le burger passe à −1 397 px après
       1 500 px de défilement, et le menu devient inatteignable.

       Aucune règle CSS écrite ICI ne peut corriger cela — seul un élément du
       document PARENT peut se caler sur l'écran. Le parent affiche donc un
       bouton flottant, et nous ouvrons le menu du template à sa demande.

       On cherche le déclencheur parmi les noms préfixés des templates maison
       puis les noms génériques. À défaut, on se contente de remonter en haut :
       l'en-tête y est, l'utilisateur reprend la main. */
    function ouvrirMenuMobile() {
        var candidats = [
            '.calibre-burger', '.ae-burger', '[class$="-burger"]', '[class*="-burger "]',
            '.navbar-toggler', '.menu-toggle', '.hamburger', '.burger', '.nav-toggle', '.menu-btn'
        ];
        var declencheur = null;

        for (var i = 0; i < candidats.length && !declencheur; i++) {
            try {
                var el = document.querySelector(candidats[i]);
                // Uniquement s'il est réellement affiché : sous 1025 px les
                // templates masquent leur navigation de bureau et montrent le
                // burger — c'est celui-là qu'on veut.
                if (el && el.getClientRects().length) { declencheur = el; }
            } catch (err) { /* sélecteur non supporté : on passe */ }
        }

        // Remonter en haut dans TOUS les cas : le panneau s'ouvre sous
        // l'en-tête, qui se trouve en haut du document.
        try {
            window.parent.postMessage({ channel: CHANNEL, type: 'scroll-top' }, parentOrigin);
        } catch (err) { /* silencieux */ }

        if (!declencheur) { return; }
        // Laisser le défilement du parent se faire avant d'ouvrir, sinon le
        // panneau s'ouvre hors de vue.
        setTimeout(function () { try { declencheur.click(); } catch (err) {} }, 320);
    }

    /* ── 4) Modales du template ────────────────────────────────────────────
       L'iframe est haute comme son contenu et n'a pas de défilement propre :
       sa « fenêtre » couvre donc TOUT le document. Une modale en
       position:fixed s'y centre au milieu de la page, pas de l'écran — le
       visiteur qui a défilé ne voit rien s'ouvrir.

       Le template signale ses ouvertures par un événement (gx:overlay-open).
       On demande alors au parent quelle bande de l'iframe est visible, et on
       y recale la modale en position absolue. Le template, lui, ignore tout
       de l'embarquement. */
    var modaleCourante = null;
    var stylesInitiaux = null;

    function ancrerModale(offset, hauteur) {
        if (!modaleCourante) return;
        var s = modaleCourante.style;
        s.position = 'absolute';
        s.top = Math.max(0, offset) + 'px';
        s.bottom = 'auto';
        s.height = Math.max(160, hauteur) + 'px';
    }

    function demanderBandeVisible() {
        try {
            window.parent.postMessage({ channel: CHANNEL, type: 'request-viewport' }, parentOrigin);
        } catch (err) { /* silencieux */ }
    }

    window.addEventListener('gx:overlay-open', function (e) {
        var el = e.detail && e.detail.element;
        if (!el) return;
        modaleCourante = el;
        // On garde l'écriture d'origine pour la rendre telle quelle à la
        // fermeture : le template doit retrouver sa feuille de style intacte.
        stylesInitiaux = el.getAttribute('style');
        demanderBandeVisible();
        try {
            window.parent.postMessage({ channel: CHANNEL, type: 'overlay-open' }, parentOrigin);
        } catch (err) { /* silencieux */ }
    });

    window.addEventListener('gx:overlay-close', function () {
        if (modaleCourante) {
            if (stylesInitiaux === null) { modaleCourante.removeAttribute('style'); }
            else { modaleCourante.setAttribute('style', stylesInitiaux); }
        }
        modaleCourante = null;
        stylesInitiaux = null;
        try {
            window.parent.postMessage({ channel: CHANNEL, type: 'overlay-close' }, parentOrigin);
        } catch (err) { /* silencieux */ }
    });

    // 5) Messages du parent : recalcul de hauteur, menu, bande visible.
    window.addEventListener('message', function (e) {
        if (e.origin !== parentOrigin) return;
        var data = e.data || {};
        if (data.channel !== CHANNEL) return;
        if (data.type === 'request-height') postHeight(true);
        if (data.type === 'open-menu') ouvrirMenuMobile();
        if (data.type === 'viewport') ancrerModale(data.offset, data.height);
    });

    // Démarrage + pouls régulier léger pour les contenus qui grandissent
    // sans déclencher d'observer (widgets tiers, polices web…).
    function boot() {
        watchImages();
        postHeight(true);
        var ticks = 0;
        var iv = setInterval(function () {
            postHeight(false);
            if (++ticks >= 20) clearInterval(iv); // ~10 s puis on s'appuie sur RO
        }, 500);
    }

    if (document.readyState === 'complete' || document.readyState === 'interactive') boot();
    else document.addEventListener('DOMContentLoaded', boot);
    window.addEventListener('load', function () { watchImages(); postHeight(true); });
})();
</script>
