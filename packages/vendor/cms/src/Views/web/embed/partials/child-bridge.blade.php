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

    /* ⚠ NE JAMAIS MESURER SUR documentElement — C'EST UN CLIQUET

       Le parent donne à l'iframe la hauteur que nous annonçons ; cette
       hauteur DEVIENT notre fenêtre. Or `documentElement.scrollHeight` ne
       descend jamais sous la fenêtre : il vaut donc toujours au moins la
       dernière valeur annoncée. Un `Math.max` qui l'inclut ne peut plus
       jamais redescendre — la moindre inflation accidentelle est définitive.

       Constaté en production : contenu réel 10 288 px, hauteur annoncée
       30 706 px, soit 20 418 px de blanc sous le pied de page, et rien pour
       s'en défaire à part recharger. On ne mesure donc plus que le CORPS,
       dont la hauteur suit le contenu. */
    function currentHeight() {
        var b = document.body;
        if (!b) { return 0; }

        var boite = b.getBoundingClientRect();
        var bas = boite.bottom + (window.pageYOffset || 0);
        var style = window.getComputedStyle(b);
        bas += parseFloat(style.marginBottom) || 0;

        return Math.ceil(Math.max(b.scrollHeight, b.offsetHeight, bas));
    }

    /* Hauteur gelée pendant qu'un calque est ancré.

       Un calque recalé sur la bande visible est en `position:absolute` à
       plusieurs milliers de pixels du haut : il entre alors dans le débord
       du document et rallonge la page d'autant. Pire, la page rallongée
       agrandit l'iframe, donc la bande visible, donc le décalage du calque —
       l'emballement est immédiat.

       Le contenu ne bouge pas pendant qu'une modale est ouverte (le
       défilement du corps est verrouillé) : on annonce donc la hauteur
       mesurée AVANT l'ancrage, jusqu'à la fermeture. */
    var hauteurGelee = null;

    function postHeight(force) {
        var h = hauteurGelee !== null ? hauteurGelee : currentHeight();
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
        s.bottom = 'auto';

        /* `offset` compte depuis le haut du DOCUMENT, mais `top` s'exprime
           dans le repère du parent POSITIONNÉ. L'enveloppe du template
           (.immo-tpl, .calibre-tpl…) est en position:relative, et celle qui
           porte le contenu commence sous la région d'en-tête. Sans cette
           correction la modale se pose la hauteur de l'en-tête trop bas —
           c'est-à-dire hors de l'écran.

           offsetParent n'est lisible qu'une fois la position passée en
           absolute : un élément fixed n'en a pas. */
        var origine = 0;
        var parent = modaleCourante.offsetParent;
        if (parent && parent !== document.body && parent !== document.documentElement) {
            origine = parent.getBoundingClientRect().top + (window.pageYOffset || 0);
        }

        // Volontairement non borné à 0 : si la bande visible est au-dessus de
        // l'enveloppe, un `top` négatif est la bonne réponse.
        s.top = Math.round(offset - origine) + 'px';
        s.height = Math.max(160, hauteur) + 'px';
    }

    function demanderBandeVisible() {
        try {
            window.parent.postMessage({ channel: CHANNEL, type: 'request-viewport' }, parentOrigin);
        } catch (err) { /* silencieux */ }
    }

    /* Bande visible LUE DIRECTEMENT dans le parent.
       `parentOrigin` vaut l'origine de l'enfant : si le parent est servi
       depuis une autre origine, le postMessage part dans le vide et la
       reponse « viewport » n'arrive jamais. La modale resterait alors en
       position:fixed, c'est-a-dire centree sur TOUT le document de l'iframe,
       donc hors de l'ecran. Cette lecture directe ne demande rien a personne ;
       elle echoue proprement si le parent est d'une autre origine. */
    function bandeVisibleDirecte() {
        try {
            var cadre = window.frameElement;
            if (!cadre) { return null; }

            var boite = cadre.getBoundingClientRect();
            var hauteurEcran = window.parent.innerHeight
                || (window.parent.document.documentElement || {}).clientHeight
                || 0;

            if (!hauteurEcran) { return null; }

            var debut = Math.max(0, -boite.top);
            var fin = Math.min(boite.height, hauteurEcran - boite.top);

            return { offset: debut, height: Math.max(160, fin - debut) };
        } catch (err) {
            return null;                    // parent d'une autre origine
        }
    }

    function recalerDirectement() {
        var bande = bandeVisibleDirecte();
        if (bande) { ancrerModale(bande.offset, bande.height); }
    }

    /* Suivi du defilement du parent.
       Un ecouteur `scroll` pose sur `window.parent` depuis l'iframe ne se
       declenche pas de facon fiable d'un contexte a l'autre. Tant qu'une
       modale est ouverte, on recalcule donc a chaque trame : c'est quelques
       lectures de geometrie, et cela ne depend ni d'un evenement ni d'une
       reponse du parent. La boucle s'arrete a la fermeture. */
    var minuteur = null;
    var derniereBande = '';

    function boucler() {
        if (!modaleCourante) { suivreParent(false); return; }

        var bande = bandeVisibleDirecte();
        if (!bande) { return; }

        // On n'ecrit que si la bande a bouge : sinon on toucherait au style
        // dix fois par seconde pour rien.
        var signature = bande.offset + 'x' + bande.height;
        if (signature === derniereBande) { return; }

        derniereBande = signature;
        ancrerModale(bande.offset, bande.height);
    }

    /* Minuteur et non requestAnimationFrame : rAF est suspendu des que le
       document ne produit plus d'images (onglet en arriere-plan, panneau
       masque, iframe non composee), et la modale resterait alors figee la ou
       le visiteur l'a ouverte. Un intervalle court ne depend de rien de tout
       cela, et ne tourne que pendant l'ouverture. */
    function suivreParent(actif) {
        if (actif) {
            derniereBande = '';
            if (minuteur === null) { minuteur = window.setInterval(boucler, 100); }
            return;
        }

        if (minuteur !== null) { window.clearInterval(minuteur); minuteur = null; }
    }

    window.addEventListener('gx:overlay-open', function (e) {
        var el = e.detail && e.detail.element;
        if (!el) return;
        modaleCourante = el;
        // AVANT tout ancrage : une fois le calque en position absolue, la
        // mesure inclurait sa hauteur ajoutée au décalage de la bande.
        if (hauteurGelee === null) { hauteurGelee = currentHeight(); }
        // On garde l'écriture d'origine pour la rendre telle quelle à la
        // fermeture : le template doit retrouver sa feuille de style intacte.
        stylesInitiaux = el.getAttribute('style');
        // D'abord la lecture directe — immediate et sans aller-retour — puis
        // la demande au parent, qui affinera s'il repond.
        recalerDirectement();
        suivreParent(true);
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
        suivreParent(false);
        // Le calque a repris sa place : on remesure, et on corrige au parent
        // même si rien n'a changé — c'est le seul moment où la page peut
        // RAPETISSER.
        hauteurGelee = null;
        postHeight(true);
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
