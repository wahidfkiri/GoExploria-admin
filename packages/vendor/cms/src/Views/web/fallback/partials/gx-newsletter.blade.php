@php
    /*
     * Pont des formulaires d'infolettre des gabarits (`data-gx-newsletter`).
     * Injecté au rendu par WebThemeController::injectNewsletter(), comme
     * gx-contact-form : un gabarit stocké en base ne peut écrire ni route()
     * ni @csrf, et landing.blade.php ne pose pas de meta csrf-token.
     *
     *   form[data-gx-newsletter]      champ `email` obligatoire
     *   [data-gx-newsletter-statut]   message du serveur (dans le formulaire
     *                                 ou dans sa section)
     */
    $gxnUrl = url('/company/' . ($etablissement->id ?? '') . '/infolettre');
@endphp
<script data-gx-newsletter-pont>
(function () {
    'use strict';
    if (window.__gxNewsletter) { return; }
    window.__gxNewsletter = true;

    var URL_ENVOI = @json($gxnUrl);
    var JETON = @json(csrf_token());

    var jeton = function () {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return (meta && meta.getAttribute('content')) || JETON;
    };
    var statut = function (form) {
        return form.querySelector('[data-gx-newsletter-statut]')
            || (form.closest('section') || document).querySelector('[data-gx-newsletter-statut]');
    };
    var afficher = function (form, texte, ok) {
        var el = statut(form);
        if (!el) { return; }
        el.textContent = texte;
        el.setAttribute('data-etat', ok ? 'ok' : 'erreur');
    };

    // Capture : passe avant l'écouteur du gabarit, et appelle TOUJOURS
    // preventDefault — sinon la page naviguerait en GET avec l'adresse du
    // visiteur dans l'URL.
    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (!form || !form.matches || !form.matches('form[data-gx-newsletter]')) { return; }
        e.preventDefault();

        if (form.dataset.gxnEnvoi === '1') { return; }
        var champ = form.querySelector('input[name="email"], input[type="email"]');
        var email = champ ? champ.value.trim() : '';
        if (email === '') { afficher(form, 'Indiquez votre adresse courriel.', false); return; }

        var bouton = form.querySelector('[type="submit"]');
        form.dataset.gxnEnvoi = '1';
        if (bouton) { bouton.disabled = true; }

        var corps = new FormData();
        corps.append('email', email);
        corps.append('_token', jeton());

        fetch(URL_ENVOI, {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': jeton(), 'X-Requested-With': 'XMLHttpRequest' },
            body: corps,
            credentials: 'same-origin'
        })
            .then(function (r) { return r.json().then(function (d) { return { ok: r.ok && d.ok !== false, d: d }; }); })
            .then(function (res) {
                // Seuls les messages du serveur sont montrés au visiteur.
                afficher(form, res.d.message || (res.ok ? 'Merci !' : 'Inscription impossible.'), res.ok);
                if (res.ok && champ) { champ.value = ''; }
            })
            .catch(function () { afficher(form, 'Inscription momentanément impossible. Réessayez plus tard.', false); })
            .then(function () {
                form.dataset.gxnEnvoi = '';
                if (bouton) { bouton.disabled = false; }
            });
    }, true);
})();
</script>
