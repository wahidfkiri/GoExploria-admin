{{--
    Pont des formulaires de gabarit vers la messagerie de l'établissement.

    Tout formulaire de gabarit marqué `data-gx-contact="<nom_du_formulaire>"`
    est transmis à PublicPageController::sendContact, qui crée un
    ContactMessage — visible dans l'onglet « Messages contact » de l'espace
    entreprise.

    ⚠ POURQUOI CE BLOC EST INJECTÉ DANS LE DOCUMENT DU GABARIT
      · Le site d'établissement est rendu dans une <iframe>. Le gestionnaire
        partagé landing-contact-ajax vit dans le shell PARENT : son écouteur ne
        voit aucun formulaire du gabarit.
      · Un gabarit est du HTML stocké en base : il ne peut écrire ni @csrf ni
        route(). L'URL et le jeton sont donc calculés ICI, au rendu.
      · La vue du site ne porte pas de <meta name="csrf-token"> : le jeton est
        embarqué, la balise n'est consultée qu'en premier recours (même choix
        que gx-immo-request, pour la même raison).

    Contrat côté gabarit :
      data-gx-contact="nom"          nom du formulaire (form_name)
      data-gx-contact-sujet="…"      sujet, avec des {champ} remplacés par
                                     la valeur saisie
      data-gx-libelle="…"            libellé d'un champ dans le récapitulatif
      [data-gx-contact-statut]       zone de message (créée si absente)

    Les champs propres au formulaire (départ, dates, passagers…) partent tels
    quels — le contrôleur les range dans `metadata` — ET sont recopiés,
    lisibles, dans le corps du message : la fiche de l'espace entreprise
    affiche le message, pas les métadonnées.

    data-gx-contact-config         (facultatif) le formulaire suit la
                                   « Configuration du formulaire de contact »
                                   de l'établissement : champs activés ajoutés
                                   s'ils manquent (téléphone, entreprise,
                                   consentement…), obligatoires marqués comme
                                   tels, champs désactivés retirés. Sans cela,
                                   un champ rendu obligatoire par le commerçant
                                   et absent du gabarit faisait refuser TOUS les
                                   envois (validation serveur).
--}}
@php
    $gxContactChamps = [];
    try {
        foreach ((\Vendor\Cms\Support\ContactFormConfig::for($etablissement ?? null)['fields'] ?? []) as $cle => $champ) {
            $gxContactChamps[] = [
                'nom'         => $cle,
                'type'        => $champ['type'] ?? 'text',
                'libelle'     => (string) ($champ['label'] ?? $cle),
                'actif'       => (bool) ($champ['enabled'] ?? false),
                'requis'      => (bool) ($champ['required'] ?? false),
                'placeholder' => (string) ($champ['placeholder'] ?? ''),
            ];
        }
    } catch (\Throwable $e) {
        $gxContactChamps = [];   // configuration illisible : le formulaire reste celui du gabarit
    }
@endphp
<style>
    [data-gx-contact] .gx-contact-case { display: flex; align-items: flex-start; gap: 9px; font-size: .9rem; cursor: pointer; }
    [data-gx-contact] .gx-contact-case input { width: auto; margin-top: 3px; }
    [data-gx-contact] [data-gx-contact-statut] {
        display: none; margin-top: 4px; padding: 12px 16px; border-radius: 12px;
        font: 600 .9rem/1.45 system-ui, -apple-system, "Segoe UI", sans-serif;
    }
    [data-gx-contact] [data-gx-contact-statut].est-succes {
        display: block; background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;
    }
    [data-gx-contact] [data-gx-contact-statut].est-erreur {
        display: block; background: #fef2f2; color: #991b1b; border: 1px solid #fecaca;
    }
    [data-gx-contact] [aria-invalid="true"] {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, .15) !important;
    }
</style>

<script data-gx-contact-pont>
(function () {
    'use strict';

    if (window.__gxContactPont) { return; }
    window.__gxContactPont = true;

    var URL_ENVOI = @json(route('cms.company.contact.send', ['etablissementId' => $etablissement->id ?? 0]));
    var JETON = @json(csrf_token());
    var CHAMPS = @json($gxContactChamps);

    /* ── Formulaire piloté par la configuration (data-gx-contact-config) ──
       Ne touche QUE le document publié : ce pont n'est jamais injecté dans
       l'éditeur, le gabarit enregistré reste tel quel. */
    function adapterConfiguration(form) {
        if (!CHAMPS.length || form.dataset.gxContactAdapte === '1') { return; }
        form.dataset.gxContactAdapte = '1';

        var modele = form.querySelector('input[type="text"], input[type="email"]');
        var ancre = form.querySelector('[data-gx-contact-statut]') || form.querySelector('[type="submit"]');
        var indispensables = ['email', 'message'];   // toujours exigés par le serveur

        function creer(c) {
            var el;
            if (c.type === 'checkbox') {
                var etiquette = document.createElement('label');
                etiquette.className = 'gx-contact-case';
                el = document.createElement('input');
                el.type = 'checkbox';
                el.value = '1';
                el.name = c.nom;
                etiquette.appendChild(el);
                etiquette.appendChild(document.createTextNode(' ' + c.libelle));
                return { noeud: etiquette, champ: el };
            }
            el = document.createElement(c.type === 'textarea' ? 'textarea' : 'input');
            if (el.tagName === 'INPUT') { el.type = ['email', 'tel', 'number', 'date'].indexOf(c.type) !== -1 ? c.type : 'text'; }
            if (modele && modele.className) { el.className = modele.className; }
            el.name = c.nom;
            return { noeud: el, champ: el };
        }

        CHAMPS.forEach(function (c, rang) {
            var existant = form.elements[c.nom];

            // Désactivé par le commerçant : retiré du formulaire publié.
            if (!c.actif) {
                if (existant && existant.tagName && indispensables.indexOf(c.nom) === -1) {
                    var etiq = existant.closest('label');
                    (etiq && form.contains(etiq) ? etiq : existant).remove();
                }
                return;
            }

            var el = existant && existant.tagName ? existant : null;
            if (!el) {
                var cree = creer(c);
                el = cree.champ;
                // Rangé dans l'ordre de la configuration : avant le premier
                // champ configuré qui le suit et déjà présent.
                var suivant = null;
                for (var i = rang + 1; i < CHAMPS.length && !suivant; i++) {
                    var s = form.elements[CHAMPS[i].nom];
                    if (s && s.tagName) {
                        suivant = s.closest('.mkt-form-ligne, .hz-form-ligne, .mx-form-ligne, label') || s;
                        if (!form.contains(suivant)) { suivant = s; }
                    }
                }
                var avant = suivant || ancre;
                if (avant && avant.parentNode) { avant.parentNode.insertBefore(cree.noeud, avant); }
                else { form.appendChild(cree.noeud); }
            }

            if (el.type !== 'checkbox') {
                el.setAttribute('placeholder', (c.placeholder || c.libelle) + (c.requis ? ' *' : ''));
                el.setAttribute('aria-label', c.libelle);
            }
            el.required = c.requis || indispensables.indexOf(c.nom) !== -1;
        });
    }

    Array.prototype.forEach.call(document.querySelectorAll('form[data-gx-contact][data-gx-contact-config]'), adapterConfiguration);

    function jeton() {
        var m = document.querySelector('meta[name="csrf-token"]');
        var duMeta = m ? (m.getAttribute('content') || '') : '';

        return duMeta || JETON;
    }

    /* Champs que storeContactMessage lit lui-même : ils ne vont pas dans le
       récapitulatif, qui ne reprend que les champs propres au formulaire. */
    var RESERVES = ['_token', 'first_name', 'last_name', 'name', 'email', 'phone', 'company',
                    'preferred_contact_method', 'subject', 'service', 'message', 'consent',
                    'newsletter_opt_in', 'form_name'];

    function texteDe(el) {
        return el ? String(el.textContent || '').replace(/\s+/g, ' ').trim() : '';
    }

    function libelle(form, el) {
        var explicite = el.getAttribute('data-gx-libelle');
        if (explicite) { return explicite; }
        if (el.id) {
            var pour = form.querySelector('label[for="' + el.id + '"]');
            if (pour) { return texteDe(pour); }
        }
        return el.name;
    }

    function valeurLisible(el) {
        if (el.type === 'radio' || el.type === 'checkbox') {
            return texteDe(el.closest('label')) || el.value;
        }
        if (el.tagName === 'SELECT' && el.selectedIndex > -1) {
            return texteDe(el.options[el.selectedIndex]);
        }
        if (el.type === 'date' && /^\d{4}-\d{2}-\d{2}$/.test(el.value)) {
            var p = el.value.split('-');
            return p[2] + '/' + p[1] + '/' + p[0];
        }
        return String(el.value || '').trim();
    }

    function recapitulatif(form) {
        var lignes = [];

        Array.prototype.forEach.call(form.elements, function (el) {
            if (!el.name || el.disabled || RESERVES.indexOf(el.name) > -1) { return; }
            if (el.type === 'submit' || el.type === 'button' || el.type === 'file') { return; }
            if ((el.type === 'radio' || el.type === 'checkbox') && !el.checked) { return; }

            var v = valeurLisible(el);
            if (!v) { return; }
            // Une quantité nulle n'apprend rien : « Bébés : 0 » n'a pas sa place.
            if (el.type === 'number' && Number(v) === 0) { return; }

            lignes.push(libelle(form, el) + ' : ' + v);
        });

        return lignes;
    }

    function sujet(form) {
        var modele = form.getAttribute('data-gx-contact-sujet');
        if (!modele) { return ''; }

        return modele
            .replace(/\{([a-z0-9_]+)\}/gi, function (_, nom) {
                var el = form.elements[nom];
                return el && !el.disabled ? valeurLisible(el) : '';
            })
            // Un champ vide laisse une flèche ou un tiret orphelin : on nettoie.
            .replace(/\s*(→|—|-)\s*$/, '')
            .replace(/^\s*(→|—|-)\s*/, '')
            .replace(/\s{2,}/g, ' ')
            .trim()
            .slice(0, 190);
    }

    function statut(form, genre, texte) {
        var zone = form.querySelector('[data-gx-contact-statut]');
        if (!zone) {
            zone = document.createElement('div');
            zone.setAttribute('data-gx-contact-statut', '');
            zone.setAttribute('role', 'status');
            zone.setAttribute('aria-live', 'polite');
            form.appendChild(zone);
        }
        zone.className = genre ? 'est-' + genre : '';
        zone.textContent = texte || '';
    }

    function effacerErreurs(form) {
        Array.prototype.forEach.call(form.querySelectorAll('[aria-invalid="true"]'), function (el) {
            el.removeAttribute('aria-invalid');
        });
    }

    function marquerErreurs(form, erreurs) {
        Object.keys(erreurs || {}).forEach(function (nom) {
            var el = form.elements[nom];
            if (el && el.setAttribute) { el.setAttribute('aria-invalid', 'true'); }
        });
    }

    function premiereErreur(erreurs) {
        var cles = Object.keys(erreurs || {});
        if (!cles.length) { return ''; }
        var liste = erreurs[cles[0]];
        return Array.isArray(liste) ? String(liste[0] || '') : String(liste || '');
    }

    function envoyer(form) {
        var bouton = form.querySelector('[type="submit"]');
        var texteBouton = bouton ? bouton.innerHTML : '';
        var donnees = new FormData(form);

        var libre = String(donnees.get('message') || '').trim();
        var lignes = recapitulatif(form);
        var corps = libre;
        if (lignes.length) {
            corps = (libre ? libre + '\n\n' : '') + '— Détail de la demande —\n' + lignes.join('\n');
        }
        donnees.set('message', corps || 'Demande envoyée depuis le site.');

        var s = sujet(form);
        if (s && !String(donnees.get('subject') || '').trim()) { donnees.set('subject', s); }

        donnees.set('form_name', form.getAttribute('data-gx-contact') || 'formulaire_gabarit');
        donnees.set('_token', jeton());

        effacerErreurs(form);
        statut(form, '', '');
        if (bouton) {
            bouton.disabled = true;
            bouton.setAttribute('aria-busy', 'true');
            bouton.innerHTML = form.getAttribute('data-loading-text') || 'Envoi en cours…';
        }

        return fetch(URL_ENVOI, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': jeton(), 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: donnees
        }).then(function (r) {
            return r.json().catch(function () { return {}; }).then(function (charge) {
                return { ok: r.ok, code: r.status, charge: charge || {} };
            });
        }).then(function (res) {
            if (res.ok && res.charge.success === true) {
                form.reset();
                statut(form, 'succes', res.charge.message || 'Votre demande a bien été envoyée.');
                form.dispatchEvent(new CustomEvent('gx-contact:envoye', { bubbles: true, detail: { id: res.charge.id } }));
                return;
            }
            // 419 : le jeton a expiré (page ouverte trop longtemps). Le message
            // du serveur, « CSRF token mismatch », n'est pas pour le visiteur.
            if (res.code === 419) {
                statut(form, 'erreur', 'La page a expiré. Rechargez-la, puis renvoyez votre demande.');
                return;
            }
            marquerErreurs(form, res.charge.errors);
            statut(form, 'erreur', premiereErreur(res.charge.errors) || res.charge.message
                || 'Votre demande n’a pas pu être envoyée. Réessayez ou appelez-nous.');
        }).catch(function () {
            // Panne réseau : « Failed to fetch » ne s'adresse pas au visiteur.
            statut(form, 'erreur', 'Votre demande n’a pas pu être envoyée. Réessayez ou appelez-nous.');
        }).then(function () {
            if (bouton) {
                bouton.disabled = false;
                bouton.removeAttribute('aria-busy');
                bouton.innerHTML = texteBouton;
            }
        });
    }

    /* Écoute en PHASE DE CAPTURE sur le document : le pont passe avant tout
       écouteur du gabarit, et un formulaire ajouté ou déplacé après le
       chargement est pris sans rebranchement. */
    document.addEventListener('submit', function (e) {
        var form = e.target && e.target.closest ? e.target.closest('form[data-gx-contact]') : null;
        if (!form) { return; }

        // TOUJOURS : sans cela le navigateur enverrait le formulaire lui-même,
        // la page changerait et la demande serait perdue.
        e.preventDefault();

        if (form.checkValidity && !form.checkValidity()) {
            if (form.reportValidity) { form.reportValidity(); }
            return;
        }
        envoyer(form);
    }, true);
})();
</script>
