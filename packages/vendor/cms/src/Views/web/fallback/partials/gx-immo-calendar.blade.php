{{-- ═══════════════════════════════════════════════════════════════════════
     Calendrier de réservation de la fiche d'un bien.

     CE QU'IL REMPLACE

     Deux champs `<input type="date">`, où le visiteur pouvait demander des
     nuits déjà prises — il ne l'apprenait qu'après avoir envoyé sa demande.
     Ici, les nuits occupées sont grisées et non cliquables.

     LA RÈGLE DES NUITS

     Une période va de l'arrivée au départ EXCLU : un séjour du 4 au 7 occupe
     les nuits du 4, du 5 et du 6. Le 7 reste sélectionnable comme arrivée,
     puisque l'occupant précédent part ce matin-là. Sans cette règle on perdrait
     une nuit louable à chaque réservation.

     PAS DE BIBLIOTHÈQUE

     Un sélecteur de dates pèse plus lourd que ce calendrier, impose ses
     styles, et le gabarit tient à son autonomie. Deux mois affichés, navigation
     avant/arrière, sélection en deux clics.

     CE QU'IL NE FAIT PAS

     Il n'autorise rien : le serveur revérifie le chevauchement à
     l'enregistrement. Le calendrier vit chez le visiteur, il ne décide pas.
     ═══════════════════════════════════════════════════════════════════════ --}}
<style>
    .gxcal { margin-bottom: 12px; }
    .gxcal__tete {
        display: flex; align-items: center; justify-content: space-between;
        gap: 8px; margin-bottom: 10px;
    }
    .gxcal__nav {
        width: 32px; height: 32px; flex: 0 0 auto; border-radius: 8px;
        border: 1px solid rgba(128, 128, 128, .35); background: transparent;
        color: inherit; font-size: 16px; line-height: 1; cursor: pointer;
    }
    .gxcal__nav:disabled { opacity: .3; cursor: default; }
    .gxcal__mois { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    @media (max-width: 620px) { .gxcal__mois { grid-template-columns: 1fr; } }
    .gxcal__titre {
        text-align: center; font-weight: 800; font-size: 13.5px;
        margin-bottom: 8px; text-transform: capitalize;
    }
    .gxcal__grille { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
    .gxcal__jour-nom {
        text-align: center; font-size: 10.5px; font-weight: 700;
        opacity: .55; padding-bottom: 4px; text-transform: uppercase;
    }
    .gxcal__jour {
        aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
        border: 0; background: transparent; color: inherit;
        font: inherit; font-size: 13px; border-radius: 8px; cursor: pointer;
    }
    .gxcal__jour:hover:not(:disabled) { background: rgba(128, 128, 128, .18); }
    .gxcal__jour:disabled { opacity: .28; cursor: not-allowed; }
    /* Nuit déjà prise : barrée, pour que ce ne soit pas confondu avec une
       date simplement passée. */
    .gxcal__jour.est-occupe { text-decoration: line-through; opacity: .35; }
    .gxcal__jour.est-debut, .gxcal__jour.est-fin {
        background: #1F3A5C; color: #fff; font-weight: 800;
    }
    .gxcal__jour.est-entre { background: rgba(31, 58, 92, .16); }
    .gxcal__vide { aspect-ratio: 1; }
    .gxcal__resume {
        display: flex; align-items: center; justify-content: space-between;
        gap: 10px; margin-top: 10px; padding: 9px 12px; border-radius: 10px;
        background: rgba(128, 128, 128, .12); font-size: 13px;
    }
    .gxcal__resume b { font-weight: 800; }
    .gxcal__effacer {
        border: 0; background: transparent; color: inherit; opacity: .7;
        font: inherit; font-size: 12px; text-decoration: underline; cursor: pointer;
    }
    .gxcal__legende { margin-top: 8px; font-size: 11.5px; opacity: .65; }
    /* Le total : c'est le chiffre que le visiteur cherche, il doit se voir. */
    .gxcal__total {
        display: flex; align-items: baseline; justify-content: space-between;
        gap: 10px; margin-top: 8px; padding: 11px 13px; border-radius: 10px;
        background: rgba(31, 58, 92, .1); font-size: 13px;
    }
    .gxcal__total b { font-size: 19px; font-weight: 900; }
    .gxcal__contrainte {
        margin-top: 8px; padding: 9px 12px; border-radius: 10px;
        background: rgba(217, 119, 6, .13); color: #b45309;
        font-size: 12.5px; font-weight: 600;
    }
</style>

<script>
(function () {
    'use strict';

    if (window.__gxImmoCalendrier) { return; }
    window.__gxImmoCalendrier = true;

    {{-- Sur UNE ligne : la directive @json ne survit pas a un argument
         reparti sur plusieurs lignes, elle coupe a la premiere. --}}
    @php $gxcalUrl = route('cms.company.immobilier.disponibilites', ['etablissementId' => $etablissement->id ?? 0, 'propertyId' => '__BIEN__']); @endphp
    var URL_DISPO = @json($gxcalUrl);

    var JOURS = ['L', 'M', 'M', 'J', 'V', 'S', 'D'];
    var cache = {};          // periodes par bien, pour ne pas re-demander

    function iso(d) {
        return d.getFullYear() + '-'
            + String(d.getMonth() + 1).padStart(2, '0') + '-'
            + String(d.getDate()).padStart(2, '0');
    }

    function jour(texte) {
        var p = String(texte).split('-');
        return new Date(+p[0], +p[1] - 1, +p[2]);
    }

    function ajouter(d, n) {
        var r = new Date(d.getTime());
        r.setDate(r.getDate() + n);
        return r;
    }

    /* Ensemble des NUITS prises. Une période du 4 au 7 pose le 4, le 5 et le
       6 : le 7 reste libre pour une nouvelle arrivée. */
    function nuitsOccupees(periodes) {
        var prises = {};

        (periodes || []).forEach(function (p) {
            var d = jour(p.start);
            var fin = jour(p.end);
            var garde = 0;

            while (d < fin && garde++ < 800) {
                prises[iso(d)] = true;
                d = ajouter(d, 1);
            }
        });

        return prises;
    }

    function Calendrier(zone, surChangement) {
        this.zone = zone;
        this.surChangement = surChangement;
        this.mois = new Date();
        this.mois.setDate(1);
        this.prises = {};
        this.debut = null;
        this.fin = null;
        // Règles du bien : durée acceptée et tarif à la nuit. Nulles tant que
        // l'agence ne les a pas renseignées.
        this.regles = { minNights: null, maxNights: null, nightly: null, currency: 'USD' };
    }

    Calendrier.prototype.definirPeriodes = function (periodes, regles) {
        this.prises = nuitsOccupees(periodes);
        if (regles) {
            this.regles = {
                minNights: regles.minNights || null,
                maxNights: regles.maxNights || null,
                nightly:   regles.nightly   || null,
                currency:  regles.currency  || 'USD'
            };
        }
        this.dessiner();
    };

    var SYMBOLES = { USD: '$', CAD: '$', EUR: '€', GBP: '£', MAD: 'MAD', TND: 'TND' };

    function montant(valeur, devise) {
        var arrondi = Math.round(valeur * 100) / 100;

        return arrondi.toLocaleString('fr-CA', { minimumFractionDigits: 0, maximumFractionDigits: 2 })
            + ' ' + (SYMBOLES[devise] || devise || '');
    }

    Calendrier.prototype.nuits = function () {
        if (!this.debut || !this.fin) { return 0; }

        return Math.round((jour(this.fin) - jour(this.debut)) / 86400000);
    };

    /* Ce qui empêche d'envoyer la demande, en toutes lettres. Renvoie null
       quand la durée convient — ou qu'aucune borne n'est posée. */
    Calendrier.prototype.contrainte = function () {
        var n = this.nuits();
        if (!n) { return null; }

        if (this.regles.minNights && n < this.regles.minNights) {
            return 'Séjour de ' + this.regles.minNights + ' nuits minimum sur ce bien.';
        }
        if (this.regles.maxNights && n > this.regles.maxNights) {
            return 'Séjour de ' + this.regles.maxNights + ' nuits au maximum sur ce bien.';
        }

        return null;
    };

    Calendrier.prototype.effacer = function () {
        this.debut = null;
        this.fin = null;
        this.dessiner();
        this.surChangement(null, null);
    };

    /* Une plage est valable si aucune nuit prise ne s'y trouve. Sans ce
       contrôle, on pourrait sélectionner « par-dessus » une réservation en
       cliquant de part et d'autre. */
    Calendrier.prototype.plageLibre = function (debut, fin) {
        var d = jour(debut);
        var f = jour(fin);
        var garde = 0;

        while (d < f && garde++ < 800) {
            if (this.prises[iso(d)]) { return false; }
            d = ajouter(d, 1);
        }

        return true;
    };

    Calendrier.prototype.choisir = function (date) {
        // Premier clic, ou reprise après une plage complète.
        if (!this.debut || this.fin) {
            this.debut = date;
            this.fin = null;
        } else if (date <= this.debut) {
            // Cliquer avant l'arrivée déplace l'arrivée : plus naturel que de
            // refuser le clic.
            this.debut = date;
        } else if (this.plageLibre(this.debut, date)) {
            this.fin = date;
        } else {
            // La plage traverse une réservation : on repart de ce clic.
            this.debut = date;
            this.fin = null;
        }

        this.dessiner();
        this.surChangement(this.debut, this.fin);
    };

    Calendrier.prototype.dessinerMois = function (base) {
        var annee = base.getFullYear();
        var mois = base.getMonth();
        var premier = new Date(annee, mois, 1);
        var nbJours = new Date(annee, mois + 1, 0).getDate();

        // Lundi en tête : getDay() donne 0 pour dimanche.
        var decalage = (premier.getDay() + 6) % 7;

        var html = '<div><div class="gxcal__titre">'
            + premier.toLocaleDateString('fr-CA', { month: 'long', year: 'numeric' })
            + '</div><div class="gxcal__grille">';

        JOURS.forEach(function (j) { html += '<div class="gxcal__jour-nom">' + j + '</div>'; });
        for (var v = 0; v < decalage; v++) { html += '<div class="gxcal__vide"></div>'; }

        var aujourdHui = iso(new Date());

        for (var n = 1; n <= nbJours; n++) {
            var d = iso(new Date(annee, mois, n));
            var passe = d < aujourdHui;
            var occupe = !!this.prises[d];
            var classes = ['gxcal__jour'];

            if (occupe) { classes.push('est-occupe'); }
            if (this.debut === d) { classes.push('est-debut'); }
            if (this.fin === d) { classes.push('est-fin'); }
            if (this.debut && this.fin && d > this.debut && d < this.fin) { classes.push('est-entre'); }

            html += '<button type="button" class="' + classes.join(' ') + '"'
                 + ' data-gxcal-jour="' + d + '"'
                 + (passe || occupe ? ' disabled' : '')
                 + ' aria-label="' + d + (occupe ? ' — déjà réservé' : '') + '">' + n + '</button>';
        }

        return html + '</div></div>';
    };

    Calendrier.prototype.dessiner = function () {
        var suivant = new Date(this.mois.getFullYear(), this.mois.getMonth() + 1, 1);
        var debutMois = new Date();
        debutMois.setDate(1);

        var html = '<div class="gxcal__tete">'
            + '<button type="button" class="gxcal__nav" data-gxcal-prec aria-label="Mois précédent"'
            + (this.mois <= debutMois ? ' disabled' : '') + '>‹</button>'
            + '<span style="font-size:12.5px;opacity:.7">Choisissez vos nuits</span>'
            + '<button type="button" class="gxcal__nav" data-gxcal-suiv aria-label="Mois suivant">›</button>'
            + '</div><div class="gxcal__mois">'
            + this.dessinerMois(this.mois)
            + this.dessinerMois(suivant)
            + '</div>';

        if (this.debut) {
            var nuits = this.nuits();
            html += '<div class="gxcal__resume"><span>'
                 + (this.fin
                    ? '<b>' + nuits + ' nuit' + (nuits > 1 ? 's' : '') + '</b> — du '
                      + this.debut + ' au ' + this.fin
                    : 'Arrivée le <b>' + this.debut + '</b> — choisissez la date de départ')
                 + '</span><button type="button" class="gxcal__effacer" data-gxcal-effacer>Effacer</button></div>';

            // Total : montant à la nuit × nuits retenues. Rien n'est affiché
            // sans tarif renseigné — mieux vaut pas de total qu'un faux.
            if (nuits && this.regles.nightly) {
                html += '<div class="gxcal__total"><span>'
                     + montant(this.regles.nightly, this.regles.currency) + ' × ' + nuits
                     + ' nuit' + (nuits > 1 ? 's' : '')
                     + '</span><b>' + montant(this.regles.nightly * nuits, this.regles.currency) + '</b></div>';
            }

            var souci = this.contrainte();
            if (souci) {
                html += '<div class="gxcal__contrainte">' + souci + '</div>';
            }
        }

        var bornes = [];
        if (this.regles.minNights) { bornes.push(this.regles.minNights + ' nuits minimum'); }
        if (this.regles.maxNights) { bornes.push(this.regles.maxNights + ' nuits maximum'); }
        if (this.regles.nightly) {
            bornes.push(montant(this.regles.nightly, this.regles.currency) + ' la nuit');
        }

        html += '<p class="gxcal__legende">'
             + (bornes.length ? '<b>' + bornes.join(' · ') + '</b><br>' : '')
             + 'Les nuits barrées sont déjà réservées. '
             + 'Le jour du départ reste disponible pour une nouvelle arrivée.</p>';

        this.zone.innerHTML = html;
    };

    Calendrier.prototype.brancher = function () {
        var self = this;

        this.zone.addEventListener('click', function (e) {
            var j = e.target.closest('[data-gxcal-jour]');
            if (j && !j.disabled) { self.choisir(j.getAttribute('data-gxcal-jour')); return; }

            if (e.target.closest('[data-gxcal-prec]')) {
                self.mois = new Date(self.mois.getFullYear(), self.mois.getMonth() - 1, 1);
                self.dessiner();
                return;
            }
            if (e.target.closest('[data-gxcal-suiv]')) {
                self.mois = new Date(self.mois.getFullYear(), self.mois.getMonth() + 1, 1);
                self.dessiner();
                return;
            }
            if (e.target.closest('[data-gxcal-effacer]')) { self.effacer(); }
        });
    };

    /* Le formulaire est posé par gx-immo-request : on attend qu'il existe. */
    /* Le bloc de demande vit normalement dans la fiche du gabarit, mais la
       modale de la carte l'EMPRUNTE le temps de son affichage. On le cherche
       donc d'abord à sa place habituelle, puis partout ailleurs. */
    function formulaire() {
        return document.querySelector('[data-im-detail] [data-gxir-section] form')
            || document.querySelector('[data-gxir-section] form')
            || null;
    }

    /* ------------------------------------------------------------------
       QUEL BIEN LA FICHE MONTRE-T-ELLE ?

       Le gabarit ouvre sa fiche avec `ouvrirFiche(id)` mais n'inscrit cet id
       NULLE PART : ni sur le panneau, ni dans une variable. Nos trois greffes
       (calendrier, formulaire de demande, média) le cherchaient pourtant sur
       le panneau — elles ne le trouvaient jamais, et le calendrier ne
       demandait donc aucune période : AUCUN jour n'était grisé.

       On récupère l'identité à la source. Le gabarit n'ouvre une fiche que
       depuis un élément `[data-im-open]`, qui porte l'id exact remis à
       `ouvrirFiche` : c'est la référence. La carte englobante (`data-id`)
       sert de repli. En phase de capture, on note l'id AVANT que le gabarit
       n'ouvre la fiche, et on le recopie sur le panneau — ce qui réveille
       aussi les observateurs des deux autres greffes (formulaire, média).
    ------------------------------------------------------------------ */
    if (!window.__gxImmoIdentiteBranchee) {
        window.__gxImmoIdentiteBranchee = true;

        document.addEventListener('click', function (ev) {
            var cible = ev.target;
            if (!cible || !cible.closest) { return; }

            // Le bouton favori vit dans la carte sans ouvrir la fiche.
            if (cible.closest('.im-fav')) { return; }

            var declencheur = cible.closest('[data-im-open]');
            var carte = cible.closest('[data-im-card]');

            var id = (declencheur && declencheur.getAttribute('data-im-open'))
                || (carte && carte.getAttribute('data-id'));

            if (!id) { return; }

            window.__gxImmoBienCourant = id;

            var panneau = document.querySelector('[data-im-detail]');
            if (panneau) { panneau.setAttribute('data-im-detail-id', id); }
        }, true);
    }

    function bienAffiche() {
        var f = document.querySelector('[data-im-detail]');
        if (!f) { return null; }

        var brut = f.getAttribute('data-im-detail-id')
            || f.getAttribute('data-property-id')
            // Même repli que le formulaire de demande : il lui manquait ici.
            || (window.__gxImmoBienCourant || null);

        if (!brut) { return null; }

        var n = String(brut).replace(/^p/, '');

        return /^\d+$/.test(n) ? n : null;
    }

    function chargerPeriodes(bien) {
        if (cache[bien]) { return Promise.resolve(cache[bien]); }

        return fetch(URL_DISPO.replace('__BIEN__', bien), {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        }).then(function (r) { return r.json(); })
          .then(function (d) {
              cache[bien] = { periodes: (d && d.periods) || [], regles: (d && d.rules) || null };
              return cache[bien];
          })
          // Sans réponse : aucun jour grisé, aucune règle. Le serveur
          // revérifiera de toute façon.
          .catch(function () { return { periodes: [], regles: null }; });
    }

    var calendrier = null;

    function installer() {
        var form = formulaire();
        if (!form) { return; }

        var arrivee = form.querySelector('[data-gxir-champ="arrival_date"]');
        var depart = form.querySelector('[data-gxir-champ="departure_date"]');
        if (!arrivee || !depart) { return; }

        if (!calendrier) {
            var zone = document.createElement('div');
            zone.className = 'gxcal';
            zone.setAttribute('data-gxcal', '');

            // Le calendrier remplace les deux champs de date, qui deviennent
            // le support de la valeur envoyée — masqués, mais toujours là :
            // c'est eux que lit gx-immo-request.
            var bloc = arrivee.closest('.gxir-grid') || arrivee.closest('.gxir-field');
            if (bloc && bloc.parentNode) {
                bloc.parentNode.insertBefore(zone, bloc);
                bloc.style.display = 'none';
            } else {
                form.insertBefore(zone, form.firstChild);
            }

            calendrier = new Calendrier(zone, function (debut, fin) {
                arrivee.value = debut || '';
                depart.value = fin || '';
            });

            /* Une durée hors bornes est bloquée ICI, avant l'envoi : le
               serveur la refuserait de toute façon, autant l'éviter au
               visiteur. On se place en capture pour passer avant l'écouteur
               du formulaire, qui lui déclenche l'envoi. */
            form.addEventListener('submit', function (e) {
                var souci = calendrier.contrainte();
                if (souci) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    calendrier.dessiner();
                    zone.scrollIntoView({ block: 'nearest' });
                }
            }, true);
            calendrier.brancher();
            calendrier.dessiner();
        }

        var bien = bienAffiche();
        if (!bien || calendrier.bienCourant === bien) { return; }

        calendrier.bienCourant = bien;
        calendrier.effacer();
        chargerPeriodes(bien).then(function (reponse) {
            // Le visiteur a pu changer de bien entre-temps.
            if (calendrier.bienCourant === bien) {
                calendrier.definirPeriodes(reponse.periodes, reponse.regles);
            }
        });
    }

    function surveiller() {
        installer();

        var f = document.querySelector('[data-im-detail]');
        if (!f || typeof MutationObserver === 'undefined') { return; }

        new MutationObserver(function () { installer(); })
            .observe(f, { attributes: true, childList: true, subtree: true,
                          attributeFilter: ['aria-hidden', 'class', 'data-im-detail-id'] });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', surveiller);
    } else {
        surveiller();
    }
})();
</script>
