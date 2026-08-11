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

    // 4) Le parent peut demander un recalcul (ex. après resize de la fenêtre).
    window.addEventListener('message', function (e) {
        if (e.origin !== parentOrigin) return;
        var data = e.data || {};
        if (data.channel === CHANNEL && data.type === 'request-height') postHeight(true);
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
