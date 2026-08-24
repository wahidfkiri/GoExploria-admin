{{-- ═══════════════════════════════════════════════════════════════════════
     Demande de réservation depuis la fiche d'un bien.

     TROIS DÉFAUTS DU GABARIT, CORRIGÉS ICI

     1. Le formulaire n'envoyait rien. Le script du template ajoutait la classe
        `is-sent`, qui masque les champs et affiche « votre demande a bien été
        envoyée ». Le visiteur croyait être passé, l'agence ne recevait rien.

     2. Il vivait DANS la section « votre interlocuteur », que le gabarit
        masque en bloc quand le bien n'a pas de négociateur
        (`blocAgent.hidden = !agent`). Sur un bien sans négociateur — le cas le
        plus courant au départ — il n'y avait donc aucun formulaire. On le sort
        dans sa propre section, toujours visible.

     3. Il lui manquait les dates de séjour et le nombre de voyageurs.

     POURQUOI ICI ET NON DANS LE GABARIT

     Modifier le gabarit ne toucherait que les sites installés ENSUITE : une
     page en ligne en est une copie figée. Ce bloc est injecté au rendu, comme
     le tiroir panier et la modale produit — il atteint donc aussi les sites
     existants, sans réinstallation.

     Rien n'est touché sur une page sans fiche de bien.
     ═══════════════════════════════════════════════════════════════════════ --}}
<style>
    /* ══════════════════════════════════════════════════════════════════════
       LE MECANISME `is-sent` VOYAGE AVEC LE BLOC

       C'est CETTE greffe qui cree `[data-form-fields]` et `[data-form-success]`
       et qui pose `is-sent` a l'envoi. Les regles d'affichage lui appartiennent
       donc aussi. Elles vivaient jusqu'ici dans la feuille de chaque gabarit
       hote (`.immo-tpl`, `.resid-tpl`) — et un hote finit toujours par les
       oublier : deplace dans la modale de la carte, le bloc perdait son
       masquage et affichait « Votre demande a bien ete envoyee » AVANT tout
       envoi, tandis que les champs restaient visibles. Le bouton semblait
       alors ne rien faire, puisque rien ne changeait a l'ecran.

       Portees par le marqueur de la section, ces regles suivent le bloc
       partout ou on le deplace. Un gabarit peut toujours les surcharger.
       ══════════════════════════════════════════════════════════════════════ */
    /* ══════════════════════════════════════════════════════════════════════
       LA VISIONNEUSE DOIT RESTER DANS LA BANDE VISIBLE

       En `position:fixed`, un calque s'ancre au DOCUMENT quand le site est
       rendu dans une iframe sans defilement propre : mesure sur la fiche
       9642, la visionneuse couvrait les 10 289 px de l'iframe et l'image
       tombait a 1 993 px sous le haut de l'ecran — invisible.

       En `absolute`, elle epouse la boite de la fiche, que le pont a deja
       recalee sur la bande visible. Verifie en situation : image a 94→627 px,
       centree, navigation intacte.

       ⚠ Pourquoi ici plutot que dans le gabarit : une page INSTALLEE porte
       trois copies de la feuille du gabarit (regions d'en-tete et de pied +
       contenu), qui se mettent a jour separement. Sur 9642 la copie du pied,
       rendue en dernier, imposait encore `fixed`. Cette feuille-ci est
       injectee avant </body>, donc APRES toutes les regions : elle tranche,
       et corrige les sites deja installes sans avoir a les reinstaller.

       On ne touche QUE la position — le centrage, la largeur et le style de
       la fiche restent le choix de chaque gabarit (NadiImmo garde son tiroir).
       ══════════════════════════════════════════════════════════════════════ */
    [data-im-detail] .im-lightbox { position: absolute; }

    [data-gxir-section] [data-form-success] { display: none; }
    [data-gxir-section] .is-sent [data-form-fields] { display: none; }
    [data-gxir-section] .is-sent [data-form-success] { display: block; }

    .gxir-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .gxir-grid .gxir-field { margin: 0; }
    .gxir-field { margin-bottom: 10px; }
    .gxir-field label {
        display: block; margin-bottom: 4px;
        font-size: 12px; font-weight: 700; letter-spacing: .02em; opacity: .75;
    }
    /* On reprend la mise en forme des champs du gabarit plutôt que d'en
       imposer une : la fiche doit rester d'un seul tenant. */
    .gxir-field input, .gxir-field textarea {
        width: 100%; padding: 11px 13px; border-radius: 10px;
        border: 1px solid rgba(128, 128, 128, .35);
        background: rgba(255, 255, 255, .04); color: inherit;
        font: inherit; line-height: 1.3;
    }
    .gxir-field input:focus, .gxir-field textarea:focus {
        outline: 2px solid rgba(128, 128, 128, .45); outline-offset: 1px;
    }
    /* Compagnie et contact ne se saisissent pas : ils rappellent à qui l'on
       écrit. Grisés pour que ce soit lisible d'un coup d'œil. */
    .gxir-field input[readonly] { opacity: .65; cursor: default; }
    .gxir-error {
        display: none; margin-top: 10px; padding: 10px 12px; border-radius: 10px;
        background: rgba(220, 38, 38, .12); color: #dc2626;
        font-size: 13px; font-weight: 600;
    }
    .gxir-error.is-visible { display: block; }
    .gxir-note { margin-top: 10px; font-size: 12px; opacity: .7; }
</style>

<script>
(function () {
    'use strict';

    if (window.__gxImmoRequest) { return; }
    window.__gxImmoRequest = true;

    var URL_ENVOI = @json(route('cms.company.immobilier.demande', ['etablissementId' => $etablissement->id ?? 0]));
    var COMPAGNIE = @json($etablissement->name ?? '');

    /* Jeton CSRF pose ICI, a la generation de la page.
       La vue du site (landing.blade.php) ne porte PAS de balise
       <meta name="csrf-token"> — contrairement a la boutique ou au paiement.
       Se reposer sur elle renvoyait une chaine vide, et Laravel refusait
       l'envoi avec « CSRF token mismatch ». La balise reste consultee en
       premier au cas ou une autre vue en pose une plus fraiche. */
    var JETON = @json(csrf_token());

    function jeton() {
        var m = document.querySelector('meta[name="csrf-token"]');
        var duMeta = m ? (m.getAttribute('content') || '') : '';

        return duMeta || JETON;
    }

    /* Panneau d'accueil du formulaire. La modale de la carte peut l'avoir
       emprunté : dans ce cas c'est elle qui le porte, et c'est là qu'il faut
       le retrouver — sinon un second formulaire serait créé dans la fiche. */
    function fiche() {
        var emprunte = document.querySelector('[data-gxir-section]');
        if (emprunte && !emprunte.closest('[data-im-detail]')) {
            return emprunte.parentElement;
        }
        return document.querySelector('[data-im-detail]');
    }

    function champ(nom, libelle, type, attributs) {
        var bloc = document.createElement('div');
        bloc.className = 'gxir-field';

        var etiquette = document.createElement('label');
        etiquette.textContent = libelle;
        etiquette.setAttribute('for', 'gxir-' + nom);

        var saisie = document.createElement(type === 'textarea' ? 'textarea' : 'input');
        if (type !== 'textarea') { saisie.type = type; }
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

    /**
     * Le formulaire, sorti de la section « votre interlocuteur ».
     *
     * Le gabarit masque cette section quand le bien n'a pas de négociateur, et
     * le formulaire disparaissait avec elle. On le déplace dans sa propre
     * section — en le déplaçant plutôt qu'en le recréant, il garde la mise en
     * forme du gabarit et son message de succès.
     *
     * Si le gabarit n'en porte aucun (page plus ancienne, ou formulaire
     * supprimé dans l'éditeur), on le construit.
     */
    function formulaire() {
        var racine = fiche();
        if (!racine) { return null; }

        var deja = racine.querySelector('[data-gxir-section] form');
        if (deja) { return deja; }

        var corps = racine.querySelector('.im-detail-body') || racine;

        var section = document.createElement('div');
        section.className = 'im-detail-section';
        section.setAttribute('data-gxir-section', '');

        var titre = document.createElement('h4');
        titre.textContent = 'Contacter le propriétaire';
        section.appendChild(titre);

        var form = racine.querySelector('form[data-demo-form]');

        if (!form) {
            form = document.createElement('form');
            form.className = 'im-contact-form';
            form.setAttribute('data-demo-form', '');

            var champs = document.createElement('div');
            champs.setAttribute('data-form-fields', '');
            champs.appendChild(champ('name', 'Nom complet', 'text', { required: 'required', maxlength: 190 }));
            champs.appendChild(champ('email', 'Courriel', 'email', { required: 'required', maxlength: 190 }));
            champs.appendChild(champ('phone', 'Téléphone', 'tel', { required: 'required', maxlength: 40 }));
            champs.appendChild(champ('message', 'Message', 'textarea', { rows: 3, maxlength: 2000 }));

            var envoi = document.createElement('button');
            envoi.type = 'submit';
            envoi.className = 'im-btn im-btn--primary im-btn--block';
            envoi.textContent = 'Contacter le propriétaire';
            champs.appendChild(envoi);

            var succes = document.createElement('div');
            succes.setAttribute('data-form-success', '');
            succes.textContent = 'Le message a bien été envoyé !';

            form.appendChild(champs);
            form.appendChild(succes);

        }

        section.appendChild(form);
        corps.appendChild(section);

        return form;
    }

    /* Champs ajoutés, dans l'ordre de lecture : à qui j'écris, qui je suis,
       quand je viens, combien nous sommes, ce que je demande. */
    function completer(form) {
        var zone = form.querySelector('[data-form-fields]') || form;

        if (!form.querySelector('[data-gxir-champ="company"]')) {
            var entete = document.createElement('div');
            entete.className = 'gxir-grid';
            entete.appendChild(champ('company', 'Compagnie', 'text', { readonly: 'readonly' }));
            entete.appendChild(champ('contact', 'Contact', 'text', { readonly: 'readonly' }));
            zone.insertBefore(entete, zone.firstChild);
        }

        if (!form.querySelector('[data-gxir-champ="arrival_date"]')) {
            var message = zone.querySelector('textarea');
            var avant = message ? (message.closest('.im-field') || message.closest('.gxir-field') || message) : null;
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

            // Le départ ne peut pas précéder l'arrivée : contraint dès la
            // saisie, plutôt que refusé par le serveur après coup.
            var arrivee = form.querySelector('[data-gxir-champ="arrival_date"]');
            var depart = form.querySelector('[data-gxir-champ="departure_date"]');
            if (arrivee && depart) {
                arrivee.addEventListener('change', function () {
                    depart.min = arrivee.value || aujourdHui;
                    if (depart.value && depart.value < depart.min) { depart.value = depart.min; }
                });
            }
        }

        if (!form.querySelector('[data-gxir-erreur]')) {
            var erreur = document.createElement('div');
            erreur.className = 'gxir-error';
            erreur.setAttribute('data-gxir-erreur', '');
            zone.appendChild(erreur);

            var note = document.createElement('p');
            note.className = 'gxir-note';
            note.textContent = 'En envoyant ce formulaire, vous acceptez d’être contacté au sujet de ce bien.';
            zone.appendChild(note);
        }
    }

    /* Compagnie et contact se remplissent à chaque ouverture : le négociateur
       change d'un bien à l'autre. */
    function rappelerDestinataire(form) {
        var racine = fiche();
        var compagnie = form.querySelector('[data-gxir-champ="company"]');
        var contact = form.querySelector('[data-gxir-champ="contact"]');

        if (compagnie) { compagnie.value = COMPAGNIE; }

        if (contact) {
            var nom = racine ? racine.querySelector('[data-im-d-agent-name]') : null;
            var bloc = racine ? racine.querySelector('[data-im-d-agent]') : null;
            var visible = bloc && !bloc.hidden;

            contact.value = (visible && nom && nom.textContent.trim()) ? nom.textContent.trim() : COMPAGNIE;
        }
    }

    function valeur(form, nom) {
        var el = form.querySelector('[data-gxir-champ="' + nom + '"]');
        return el && el.value !== '' ? el.value : null;
    }

    /* Identité du bien affiché : le gabarit pose son id sur la fiche quand il
       l'ouvre. On accepte aussi le préfixe « p » de GX_IMMO. */
    function bienAffiche() {
        var racine = fiche();
        if (!racine) { return null; }

        var brut = racine.getAttribute('data-im-detail-id')
            || racine.getAttribute('data-property-id')
            || (window.__gxImmoBienCourant || null);

        if (!brut) { return null; }

        var chiffres = String(brut).replace(/^p/, '');

        return /^\d+$/.test(chiffres) ? chiffres : null;
    }

    function identite(form) {
        var valeurs = { name: '', email: '', phone: '', message: '' };

        // Le formulaire du gabarit ne nomme pas ses champs : on les reconnaît
        // par leur type. Le nôtre les nomme, et passe par le même chemin.
        form.querySelectorAll('input, textarea').forEach(function (el) {
            var nomme = el.getAttribute('data-gxir-champ');
            if (nomme === 'company' || nomme === 'contact') { return; }
            if (nomme && valeurs[nomme] !== undefined) { valeurs[nomme] = el.value; return; }
            if (nomme) { return; }

            if (el.tagName === 'TEXTAREA') { valeurs.message = el.value; return; }
            if (el.type === 'email') { valeurs.email = el.value; return; }
            if (el.type === 'tel') { valeurs.phone = el.value; return; }
            if (el.type === 'text' && !valeurs.name) { valeurs.name = el.value; }
        });

        return valeurs;
    }

    function envoyer(form) {
        var erreur = form.querySelector('[data-gxir-erreur]');
        var champs = identite(form);

        var corps = new FormData();
        corps.append('_token', jeton());
        corps.append('name', champs.name);
        corps.append('email', champs.email);
        corps.append('phone', champs.phone);
        corps.append('message', champs.message);

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
            if (!data || data.success !== true) {
                // Marqué comme venant du serveur : lui seul écrit des messages
                // destinés au visiteur. Une panne réseau produit « Failed to
                // fetch », qu'il n'a pas à lire.
                var refus = new Error((data && data.message) || '');
                refus.duServeur = true;
                throw refus;
            }
            if (erreur) { erreur.classList.remove('is-visible'); }
            form.classList.add('is-sent');
        }).catch(function (e) {
            // On retire le succès affiché par le gabarit : mieux vaut annoncer
            // l'échec que laisser croire à une demande reçue.
            form.classList.remove('is-sent');
            if (erreur) {
                erreur.textContent = (e && e.duServeur && e.message)
                    ? e.message
                    : 'Votre demande n’a pas pu être envoyée. Réessayez ou appelez-nous.';
                erreur.classList.add('is-visible');
            }
        });
    }

    function brancher() {
        var form = formulaire();
        if (!form) { return; }

        completer(form);
        rappelerDestinataire(form);

        if (form.__gxirBranche) { return; }
        form.__gxirBranche = true;

        form.addEventListener('submit', function (e) {
            // TOUJOURS, sans compter sur le gabarit. Son script appelle bien
            // preventDefault, mais s'il est absent — page éditée, script
            // retiré, formulaire déplacé hors de sa portée — le navigateur
            // enverrait le formulaire en GET : la page changerait, les
            // coordonnées du visiteur finiraient dans l'URL, et la demande
            // serait perdue. Vérifié : c'est exactement ce qui se produisait.
            e.preventDefault();
            if (form.checkValidity && !form.checkValidity()) {
                if (form.reportValidity) { form.reportValidity(); }
                return;
            }
            envoyer(form);
        });
    }

    /* La fiche est là dès le chargement, mais son contenu change à chaque
       ouverture : on rebranche et on rafraîchit le destinataire. */
    function surveiller() {
        brancher();

        var racine = fiche();
        if (!racine || typeof MutationObserver === 'undefined') { return; }

        new MutationObserver(function () { brancher(); })
            .observe(racine, { attributes: true, attributeFilter: ['aria-hidden', 'class', 'data-im-detail-id'] });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', surveiller);
    } else {
        surveiller();
    }
})();
</script>
