{{-- ═══════════════════════════════════════════════════════════════════════
     Demande de réservation depuis la fiche d'un bien.

     POURQUOI CE BLOC EXISTE

     Le template immobilier porte déjà un formulaire dans sa fiche de bien,
     mais il ne l'envoie nulle part : son script se contente d'ajouter la
     classe `is-sent`, qui masque les champs et affiche « votre demande a bien
     été envoyée ». Le visiteur croit être passé, l'agence ne reçoit rien.

     POURQUOI ICI ET NON DANS LE TEMPLATE

     Modifier le gabarit ne toucherait que les sites INSTALLÉS ENSUITE : une
     page déjà en ligne en est une copie figée. Ce bloc est injecté au rendu,
     comme le tiroir panier et la modale produit — il atteint donc aussi les
     sites existants, sans réinstallation.

     CE QU'IL FAIT

     1. Complète le formulaire avec les champs d'un séjour — arrivée, départ,
        adultes, enfants — s'ils n'y sont pas déjà.
     2. Retient le bien affiché, pour que l'agence sache de quoi on parle.
     3. Envoie réellement la demande, puis laisse le template afficher son
        message de succès. En cas d'échec, il le dit au lieu de mentir.

     Rien n'est touché sur une page sans fiche de bien.
     ═══════════════════════════════════════════════════════════════════════ --}}
<style>
    .gxir-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .gxir-grid .gxir-field { margin: 0; }
    .gxir-field { margin-bottom: 10px; }
    .gxir-field label {
        display: block; margin-bottom: 4px;
        font-size: 12px; font-weight: 700; letter-spacing: .02em; opacity: .75;
    }
    /* On reprend la mise en forme des champs du template plutôt que d'en
       imposer une : la fiche doit rester d'un seul tenant. */
    .gxir-field input {
        width: 100%; padding: 11px 13px; border-radius: 10px;
        border: 1px solid rgba(128, 128, 128, .35);
        background: rgba(255, 255, 255, .04); color: inherit;
        font: inherit; line-height: 1.3;
    }
    .gxir-field input:focus { outline: 2px solid rgba(128, 128, 128, .45); outline-offset: 1px; }
    .gxir-error {
        display: none; margin-top: 10px; padding: 10px 12px; border-radius: 10px;
        background: rgba(220, 38, 38, .12); color: #dc2626;
        font-size: 13px; font-weight: 600;
    }
    .gxir-error.is-visible { display: block; }
</style>

<script>
(function () {
    'use strict';

    if (window.__gxImmoRequest) { return; }
    window.__gxImmoRequest = true;

    var URL_ENVOI = @json(route('cms.company.immobilier.demande', ['etablissementId' => $etablissement->id ?? 0]));

    function jeton() {
        var m = document.querySelector('meta[name="csrf-token"]');
        return m ? m.getAttribute('content') : '';
    }

    /* Le formulaire de la fiche, et lui seul : le template en porte un second
       pour la newsletter, qui ne doit pas partir vers ce point d'entrée. */
    function formulaireFiche() {
        var fiche = document.querySelector('[data-im-detail]');
        return fiche ? fiche.querySelector('form[data-demo-form]') : null;
    }

    function champ(nom, libelle, type, attributs) {
        var bloc = document.createElement('div');
        bloc.className = 'gxir-field';

        var etiquette = document.createElement('label');
        etiquette.textContent = libelle;
        etiquette.setAttribute('for', 'gxir-' + nom);

        var saisie = document.createElement('input');
        saisie.type = type;
        saisie.id = 'gxir-' + nom;
        saisie.name = nom;
        saisie.setAttribute('data-gxir-champ', nom);
        Object.keys(attributs || {}).forEach(function (cle) {
            saisie.setAttribute(cle, attributs[cle]);
        });

        bloc.appendChild(etiquette);
        bloc.appendChild(saisie);

        return bloc;
    }

    /* Champs du séjour, insérés avant le message pour suivre l'ordre naturel :
       qui je suis, quand je viens, combien nous sommes, ce que je demande. */
    function completer(form) {
        if (form.querySelector('[data-gxir-champ]')) { return; }

        var zone = form.querySelector('[data-form-fields]') || form;
        var message = zone.querySelector('textarea');
        var avant = message ? (message.closest('.im-field') || message) : null;

        var aujourdHui = new Date().toISOString().slice(0, 10);

        var dates = document.createElement('div');
        dates.className = 'gxir-grid';
        dates.appendChild(champ('arrival_date', 'Date d’arrivée', 'date', { min: aujourdHui }));
        dates.appendChild(champ('departure_date', 'Date de départ', 'date', { min: aujourdHui }));

        var voyageurs = document.createElement('div');
        voyageurs.className = 'gxir-grid';
        voyageurs.appendChild(champ('adults', 'Nb. adulte(s)', 'number', { min: 0, max: 99, value: 2 }));
        voyageurs.appendChild(champ('children', 'Nb. enfant(s)', 'number', { min: 0, max: 99, value: 0 }));

        if (avant) {
            zone.insertBefore(dates, avant);
            zone.insertBefore(voyageurs, avant);
        } else {
            zone.appendChild(dates);
            zone.appendChild(voyageurs);
        }

        // Le départ ne peut pas précéder l'arrivée : on le contraint dès la
        // saisie, plutôt que de laisser le serveur refuser après coup.
        var arrivee = form.querySelector('[data-gxir-champ="arrival_date"]');
        var depart = form.querySelector('[data-gxir-champ="departure_date"]');
        if (arrivee && depart) {
            arrivee.addEventListener('change', function () {
                depart.min = arrivee.value || aujourdHui;
                if (depart.value && depart.value < depart.min) { depart.value = depart.min; }
            });
        }

        var erreur = document.createElement('div');
        erreur.className = 'gxir-error';
        erreur.setAttribute('data-gxir-erreur', '');
        zone.appendChild(erreur);
    }

    function valeur(form, nom) {
        var el = form.querySelector('[data-gxir-champ="' + nom + '"]');
        return el && el.value !== '' ? el.value : null;
    }

    /* Identité du bien affiché : le template pose son id sur la fiche quand il
       l'ouvre. On accepte aussi le préfixe « p » de GX_IMMO. */
    function bienAffiche() {
        var fiche = document.querySelector('[data-im-detail]');
        if (!fiche) { return null; }

        var brut = fiche.getAttribute('data-im-detail-id')
            || fiche.getAttribute('data-property-id')
            || (window.__gxImmoBienCourant || null);

        if (!brut) { return null; }

        var chiffres = String(brut).replace(/^p/, '');

        return /^\d+$/.test(chiffres) ? chiffres : null;
    }

    function envoyer(form) {
        var erreur = form.querySelector('[data-gxir-erreur]');
        var champs = form.querySelectorAll('input, textarea');
        var identite = { name: '', email: '', phone: '', message: '' };

        // Le gabarit ne nomme pas ses champs : on les reconnaît par leur type.
        champs.forEach(function (el) {
            if (el.hasAttribute('data-gxir-champ')) { return; }
            if (el.tagName === 'TEXTAREA') { identite.message = el.value; return; }
            if (el.type === 'email') { identite.email = el.value; return; }
            if (el.type === 'tel') { identite.phone = el.value; return; }
            if (el.type === 'text' && !identite.name) { identite.name = el.value; }
        });

        var corps = new FormData();
        corps.append('name', identite.name);
        corps.append('email', identite.email);
        corps.append('phone', identite.phone);
        corps.append('message', identite.message);

        ['arrival_date', 'departure_date', 'adults', 'children'].forEach(function (nom) {
            var v = valeur(form, nom);
            if (v !== null) { corps.append(nom, v); }
        });

        var bien = bienAffiche();
        if (bien) { corps.append('property_id', bien); }

        return fetch(URL_ENVOI, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': jeton(), 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: corps
        }).then(function (r) {
            return r.json().catch(function () { return { success: false }; });
        }).then(function (data) {
            if (!data || data.success !== true) { throw new Error(data && data.message); }
            if (erreur) { erreur.classList.remove('is-visible'); }
        }).catch(function (e) {
            // On retire le succès affiché par le script du gabarit : mieux vaut
            // dire que l'envoi a échoué que laisser croire à une demande reçue.
            form.classList.remove('is-sent');
            if (erreur) {
                erreur.textContent = (e && e.message)
                    || 'Votre demande n’a pas pu être envoyée. Réessayez ou appelez-nous.';
                erreur.classList.add('is-visible');
            }
        });
    }

    function brancher() {
        var form = formulaireFiche();
        if (!form || form.__gxirBranche) { return; }

        completer(form);
        form.__gxirBranche = true;

        // Le gabarit garde son propre écouteur : il continue d'afficher son
        // message de succès. Le nôtre s'ajoute et fait l'envoi réel.
        form.addEventListener('submit', function () {
            if (form.checkValidity && !form.checkValidity()) { return; }
            envoyer(form);
        });
    }

    /* La fiche est présente dès le chargement, mais son formulaire peut être
       reconstruit par le gabarit : on rebranche à l'ouverture. */
    function surveiller() {
        brancher();

        var fiche = document.querySelector('[data-im-detail]');
        if (!fiche || typeof MutationObserver === 'undefined') { return; }

        new MutationObserver(function () { brancher(); })
            .observe(fiche, { attributes: true, attributeFilter: ['aria-hidden', 'class', 'data-im-detail-id'] });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', surveiller);
    } else {
        surveiller();
    }
})();
</script>
