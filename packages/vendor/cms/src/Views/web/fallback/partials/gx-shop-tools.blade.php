@php
    /*
     * Outils de boutique des gabarits CMS — recherche, favoris, badge du
     * panier et liens vers la boutique. Injecté au rendu par
     * WebThemeController::injectShopTools() quand la page porte l'un des
     * repères ci-dessous ; un gabarit ne peut écrire ni route() ni l'identifiant
     * de l'établissement, c'est donc ce bloc qui les apporte.
     *
     *   data-gx-shop-link        lien → boutique (valeur facultative ajoutée
     *                            à l'adresse, ex. "?tri=nouveautes")
     *   data-gx-search           formulaire → /produits?q=, avec suggestions
     *                            en direct (nom, description, référence)
     *   data-gx-wish             bouton favori, dans une carte hydratée
     *                            (data-gx-product-id posé par TemplateProducts)
     *   data-gx-wish-count       compteur des favoris (masqué à 0)
     *   data-gx-wish-open        ouvre le panneau des favoris
     *   data-gx-cart-count       compteur du panier (masqué à 0) ; sa présence
     *                            masque le bouton flottant du panier, doublon
     *                            d'un panier déjà placé dans l'en-tête
     *
     * Les favoris ne gardent que des IDENTIFIANTS dans le navigateur (achat
     * sans compte, comme le panier) ; les fiches sont relues en base à chaque
     * ouverture du panneau par /produits/lot. Clé découpée par établissement,
     * comme celle du panier.
     */
    $gxsId = (string) ($etablissement->id ?? '');
    $gxsConfig = [
        'id'        => $gxsId,
        'nom'       => (string) ($etablissement->name ?? ''),
        'boutique'  => url('/company/' . $gxsId . '/produits'),
        'suggest'   => url('/company/' . $gxsId . '/produits/suggestions'),
        'lot'       => url('/company/' . $gxsId . '/produits/lot'),
        'cleFavoris' => 'gx_wishlist_v1_' . $gxsId,
        'clePanier' => 'cms_landing_cart_v1_' . $gxsId,
    ];
@endphp
<style data-gx-shop-tools>
.gxs-host{position:relative}
.gxs-suggest{position:absolute;left:0;right:0;top:calc(100% + 8px);z-index:9990;background:#fff;color:#17150f;border-radius:16px;box-shadow:0 24px 60px -18px rgba(23,21,15,.35),0 0 0 1px rgba(23,21,15,.08);overflow:hidden;font:14px/1.4 Inter,"Segoe UI",system-ui,sans-serif;text-align:left;min-width:280px}
.gxs-suggest[hidden]{display:none}
.gxs-suggest-rayons{display:flex;flex-wrap:wrap;gap:6px;padding:12px 14px 4px}
.gxs-suggest-rayons a{font-size:12px;font-weight:600;padding:5px 10px;border-radius:999px;background:#f3efe6;color:#17150f;text-decoration:none}
.gxs-suggest-item{display:grid;grid-template-columns:48px 1fr auto;gap:12px;align-items:center;padding:9px 14px;color:inherit;text-decoration:none}
.gxs-suggest-item:hover,.gxs-suggest-item.is-actif{background:#f6f3ec}
.gxs-suggest-item img,.gxs-suggest-item .gxs-ph{width:48px;height:48px;border-radius:10px;object-fit:cover;background:#efeae0;display:block}
.gxs-suggest-item strong{display:block;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.gxs-suggest-item small{color:#7e7669;font-size:12px}
.gxs-suggest-item em{font-style:normal;font-weight:700;white-space:nowrap}
.gxs-suggest-vide{padding:16px 14px;color:#7e7669}
.gxs-suggest-tout{display:block;padding:12px 14px;border-top:1px solid rgba(23,21,15,.08);font-weight:600;color:#1f4d3d;text-decoration:none}
.gxs-suggest-tout:hover,.gxs-suggest-tout.is-actif{background:#f6f3ec}

.gxs-wish{position:fixed;inset:0;z-index:99990;pointer-events:none;font:14px/1.45 Inter,"Segoe UI",system-ui,sans-serif;color:#17150f}
.gxs-wish.is-open{pointer-events:auto}
.gxs-wish-fond{position:absolute;inset:0;background:rgba(15,13,9,.45);opacity:0;transition:opacity .25s ease}
.gxs-wish.is-open .gxs-wish-fond{opacity:1}
.gxs-wish-panneau{position:absolute;top:0;right:0;bottom:0;width:min(420px,100%);background:#fff;display:flex;flex-direction:column;transform:translateX(105%);transition:transform .3s ease;box-shadow:-24px 0 70px rgba(15,13,9,.22)}
.gxs-wish.is-open .gxs-wish-panneau{transform:none}
.gxs-wish-tete{display:flex;align-items:center;justify-content:space-between;padding:20px 22px;border-bottom:1px solid #eee7da}
.gxs-wish-tete h3{margin:0;font:600 22px/1.1 Fraunces,Georgia,serif}
.gxs-wish-fermer{width:38px;height:38px;border-radius:50%;border:1px solid #e5ded0;background:#fff;cursor:pointer;font-size:20px;line-height:1}
.gxs-wish-corps{flex:1;overflow:auto;padding:8px 22px}
.gxs-wish-ligne{display:grid;grid-template-columns:76px 1fr;gap:14px;padding:14px 0;border-bottom:1px solid #f1ece2}
.gxs-wish-ligne img,.gxs-wish-ligne .gxs-ph{width:76px;height:76px;border-radius:12px;object-fit:cover;background:#efeae0;display:block}
.gxs-wish-ligne a.gxs-nom{font-weight:600;color:inherit;text-decoration:none;display:block}
.gxs-wish-ligne small{color:#7e7669}
.gxs-wish-actions{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-top:8px}
.gxs-wish-actions button{border:0;cursor:pointer;font:inherit}
.gxs-btn-panier{background:#17150f;color:#f6f3ec;border-radius:999px;padding:8px 14px;font-weight:600 !important;font-size:13px !important}
.gxs-btn-panier:hover{background:#1f4d3d}
.gxs-btn-panier[disabled]{background:#cfc8bb;cursor:not-allowed}
.gxs-btn-retirer{background:none;color:#b42318;font-weight:600 !important;font-size:13px !important}
.gxs-wish-vide{text-align:center;color:#7e7669;padding:48px 12px}
.gxs-wish-pied{padding:16px 22px 22px;border-top:1px solid #eee7da}
.gxs-wish-pied a{display:block;text-align:center;border-radius:14px;padding:13px;background:#f6f3ec;color:#17150f;font-weight:600;text-decoration:none}
</style>
<div class="gxs-wish" data-gx-wish-shell aria-hidden="true">
    <div class="gxs-wish-fond" data-gx-wish-close></div>
    <aside class="gxs-wish-panneau" role="dialog" aria-label="Mes favoris">
        <div class="gxs-wish-tete">
            <h3>Mes favoris</h3>
            <button type="button" class="gxs-wish-fermer" data-gx-wish-close aria-label="Fermer">&times;</button>
        </div>
        <div class="gxs-wish-corps" data-gx-wish-items></div>
        <div class="gxs-wish-pied"><a href="{{ $gxsConfig['boutique'] }}">Voir toute la boutique</a></div>
    </aside>
</div>
<script data-gx-shop-tools>
(function () {
    'use strict';
    if (window.__gxShopTools) { return; }
    window.__gxShopTools = true;

    var CFG = @json($gxsConfig);
    var $$ = function (sel, racine) { return Array.prototype.slice.call((racine || document).querySelectorAll(sel)); };
    var esc = function (v) {
        return String(v == null ? '' : v).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[c];
        });
    };
    var lire = function (cle, repli) {
        try { var v = JSON.parse(localStorage.getItem(cle) || 'null'); return v == null ? repli : v; }
        catch (e) { return repli; }
    };
    var ecrire = function (cle, valeur) { try { localStorage.setItem(cle, JSON.stringify(valeur)); } catch (e) {} };
    var poserCompteur = function (el, n) {
        el.textContent = String(n);
        if (n > 0) { el.removeAttribute('hidden'); } else { el.setAttribute('hidden', ''); }
    };

    /* ══════════ LIENS VERS LA BOUTIQUE ══════════ */
    $$('[data-gx-shop-link]').forEach(function (a) {
        a.setAttribute('href', CFG.boutique + (a.getAttribute('data-gx-shop-link') || ''));
    });

    /* ══════════ COMPTEUR DU PANIER ══════════
       Clé EXACTE de cet établissement : additionner toutes les clés du
       panier mélangerait les paniers de plusieurs sites du même domaine. */
    var compteursPanier = $$('[data-gx-cart-count]');
    var majPanier = function () {
        var panier = lire(CFG.clePanier, { items: [] });
        var n = (panier.items || []).reduce(function (s, l) { return s + (parseInt(l.quantity, 10) || 0); }, 0);
        compteursPanier.forEach(function (el) { poserCompteur(el, n); });
    };
    if (compteursPanier.length) {
        var styleFab = document.createElement('style');
        styleFab.textContent = '.cms-cart-fab{display:none !important}';
        document.head.appendChild(styleFab);
        majPanier();
        window.addEventListener('cms-cart-updated', majPanier);
        window.addEventListener('storage', function (e) { if (e.key === CFG.clePanier) { majPanier(); } });
    }

    /* ══════════ FAVORIS ══════════ */
    var favoris = function () {
        var l = lire(CFG.cleFavoris, []);
        return Array.isArray(l) ? l.map(String) : [];
    };
    var idCarte = function (bouton) {
        var carte = bouton.closest('[data-gx-product-id]');
        return carte ? String(carte.getAttribute('data-gx-product-id')) : '';
    };
    var marquer = function () {
        var liste = favoris();
        $$('[data-gx-wish]').forEach(function (b) {
            var id = idCarte(b);
            var actif = id !== '' && liste.indexOf(id) !== -1;
            b.classList.toggle('gx-wish-on', actif);
            b.setAttribute('aria-pressed', actif ? 'true' : 'false');
            b.setAttribute('aria-label', actif ? 'Retirer des favoris' : 'Ajouter aux favoris');
        });
        $$('[data-gx-wish-count]').forEach(function (el) { poserCompteur(el, liste.length); });
    };
    var basculer = function (id) {
        var liste = favoris();
        var rang = liste.indexOf(id);
        if (rang === -1) { liste.push(id); } else { liste.splice(rang, 1); }
        ecrire(CFG.cleFavoris, liste);
        marquer();
        return rang === -1;
    };

    var shell = document.querySelector('[data-gx-wish-shell]');
    var corps = document.querySelector('[data-gx-wish-items]');
    var signaler = function (nom) {
        try { window.dispatchEvent(new CustomEvent(nom, { detail: { element: shell } })); } catch (e) {}
    };
    var ligne = function (p) {
        var visuel = p.image ? '<img src="' + esc(p.image) + '" alt="">' : '<span class="gxs-ph"></span>';
        var bouton = (p.epuise || p.price === null)
            ? '<button type="button" class="gxs-btn-panier" disabled>' + (p.epuise ? 'Épuisé' : 'Sur demande') + '</button>'
            : '<button type="button" class="gxs-btn-panier" data-cms-cart-add data-gxs-vers-panier'
                + ' data-product-id="' + esc(p.id) + '" data-product-name="' + esc(p.name) + '"'
                + ' data-product-price="' + esc(p.price) + '" data-product-image="' + esc(p.image || '') + '"'
                + ' data-product-url="' + esc(p.url) + '" data-etablissement-id="' + esc(CFG.id) + '"'
                + ' data-etablissement-name="' + esc(CFG.nom) + '">Ajouter au panier</button>';
        return '<article class="gxs-wish-ligne">'
            + '<a href="' + esc(p.url) + '">' + visuel + '</a>'
            + '<div><a class="gxs-nom" href="' + esc(p.url) + '">' + esc(p.name) + '</a>'
            + '<small>' + esc(p.category || '') + (p.category ? ' · ' : '') + esc(p.price_label) + '</small>'
            + '<div class="gxs-wish-actions">' + bouton
            + '<button type="button" class="gxs-btn-retirer" data-gxs-retirer="' + esc(p.id) + '">Retirer</button></div></div>'
            + '</article>';
    };
    var remplirPanneau = function () {
        var ids = favoris();
        if (!ids.length) {
            corps.innerHTML = '<div class="gxs-wish-vide">Aucun favori pour l\'instant.<br>Touchez le cœur d\'un produit pour le retrouver ici.</div>';
            return;
        }
        corps.innerHTML = '<div class="gxs-wish-vide">Chargement…</div>';
        fetch(CFG.lot + '?ids=' + encodeURIComponent(ids.join(',')), { headers: { 'Accept': 'application/json' } })
            .then(function (r) { if (!r.ok) { throw new Error(r.status); } return r.json(); })
            .then(function (data) {
                var produits = data.produits || [];
                // Oubli des produits retirés de la vente : la base fait foi.
                var vivants = produits.map(function (p) { return String(p.id); });
                if (vivants.length !== ids.length) {
                    ecrire(CFG.cleFavoris, ids.filter(function (id) { return vivants.indexOf(id) !== -1; }));
                    marquer();
                }
                corps.innerHTML = produits.length
                    ? produits.map(ligne).join('')
                    : '<div class="gxs-wish-vide">Vos favoris ne sont plus disponibles.</div>';
            })
            .catch(function () {
                corps.innerHTML = '<div class="gxs-wish-vide">Impossible de charger vos favoris pour le moment.</div>';
            });
    };
    var ouvrirFavoris = function () {
        if (!shell) { return; }
        remplirPanneau();
        shell.classList.add('is-open');
        shell.setAttribute('aria-hidden', 'false');
        signaler('gx:overlay-open');
    };
    var fermerFavoris = function () {
        if (!shell || !shell.classList.contains('is-open')) { return; }
        shell.classList.remove('is-open');
        shell.setAttribute('aria-hidden', 'true');
        signaler('gx:overlay-close');
    };

    document.addEventListener('click', function (e) {
        var cible = e.target;
        if (!cible.closest) { return; }

        var coeur = cible.closest('[data-gx-wish]');
        if (coeur) {
            e.preventDefault();
            e.stopPropagation();          // la carte ouvre la modale produit au clic
            var id = idCarte(coeur);
            if (id === '') {              // carte de démonstration : retour visuel seul
                coeur.classList.toggle('gx-wish-on');
                return;
            }
            basculer(id);
            return;
        }
        if (cible.closest('[data-gx-wish-open]')) { e.preventDefault(); ouvrirFavoris(); return; }
        if (cible.closest('[data-gx-wish-close]')) { fermerFavoris(); return; }

        var retirer = cible.closest('[data-gxs-retirer]');
        if (retirer) { basculer(String(retirer.getAttribute('data-gxs-retirer'))); remplirPanneau(); return; }

        // Le tiroir du panier traite l'ajout (data-cms-cart-add) et s'ouvre ;
        // on referme le panneau pour ne pas empiler deux calques.
        if (cible.closest('[data-gxs-vers-panier]')) { fermerFavoris(); }
    }, true);

    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { fermerFavoris(); } });
    window.addEventListener('storage', function (e) { if (e.key === CFG.cleFavoris) { marquer(); } });
    marquer();

    /* ══════════ RECHERCHE ══════════
       Le formulaire part vers la boutique (/produits?q=) ; pendant la frappe,
       les suggestions viennent de la base. Sans script le formulaire garde
       son comportement, et l'envoi reste une vraie navigation. */
    $$('form[data-gx-search]').forEach(function (form) {
        var champ = form.querySelector('input[type="search"], input[name="q"], input[type="text"]');
        if (!champ) { return; }

        form.setAttribute('action', CFG.boutique);
        form.setAttribute('method', 'get');
        champ.setAttribute('name', 'q');
        champ.setAttribute('autocomplete', 'off');
        form.classList.add('gxs-host');

        var boite = document.createElement('div');
        boite.className = 'gxs-suggest';
        boite.setAttribute('role', 'listbox');
        boite.hidden = true;
        form.appendChild(boite);

        var minuterie = null, requete = null, dernier = '';

        var fermer = function () { boite.hidden = true; };
        var options = function () { return $$('.gxs-suggest-item, .gxs-suggest-tout', boite); };
        var surligner = function (pas) {
            var liste = options();
            if (!liste.length) { return; }
            var i = liste.findIndex(function (o) { return o.classList.contains('is-actif'); });
            liste.forEach(function (o) { o.classList.remove('is-actif'); });
            i = (i + pas + liste.length) % liste.length;
            liste[i].classList.add('is-actif');
            liste[i].scrollIntoView({ block: 'nearest' });
        };

        var afficher = function (data, q) {
            var html = '';
            if ((data.rayons || []).length) {
                html += '<div class="gxs-suggest-rayons">' + data.rayons.map(function (r) {
                    return '<a href="' + esc(r.url) + '">Rayon ' + esc(r.name) + '</a>';
                }).join('') + '</div>';
            }
            if ((data.produits || []).length) {
                html += data.produits.map(function (p) {
                    return '<a class="gxs-suggest-item" role="option" href="' + esc(p.url) + '">'
                        + (p.image ? '<img src="' + esc(p.image) + '" alt="">' : '<span class="gxs-ph"></span>')
                        + '<span><strong>' + esc(p.name) + '</strong><small>' + esc(p.category || '') + '</small></span>'
                        + '<em>' + esc(p.price_label) + '</em></a>';
                }).join('');
                html += '<a class="gxs-suggest-tout" href="' + esc(data.url) + '">Voir les '
                    + data.total + ' résultat' + (data.total > 1 ? 's' : '') + ' pour « ' + esc(q) + ' » →</a>';
            } else {
                html += '<div class="gxs-suggest-vide">Aucun produit ne correspond à « ' + esc(q) + ' ».</div>';
            }
            boite.innerHTML = html;
            boite.hidden = false;
        };

        champ.addEventListener('input', function () {
            var q = champ.value.trim();
            clearTimeout(minuterie);
            if (q.length < 2) { fermer(); dernier = ''; return; }
            minuterie = setTimeout(function () {
                if (q === dernier) { boite.hidden = false; return; }
                dernier = q;
                if (requete && requete.abort) { requete.abort(); }
                requete = typeof AbortController === 'function' ? new AbortController() : null;
                fetch(CFG.suggest + '?q=' + encodeURIComponent(q), {
                    headers: { 'Accept': 'application/json' },
                    signal: requete ? requete.signal : undefined
                })
                    .then(function (r) { if (!r.ok) { throw new Error(r.status); } return r.json(); })
                    .then(function (data) { if (champ.value.trim() === q) { afficher(data, q); } })
                    .catch(function () { /* requête annulée ou réseau : on garde l'envoi classique */ });
            }, 220);
        });

        champ.addEventListener('keydown', function (e) {
            if (boite.hidden) { return; }
            if (e.key === 'ArrowDown') { e.preventDefault(); surligner(1); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); surligner(-1); }
            else if (e.key === 'Escape') { fermer(); }
            else if (e.key === 'Enter') {
                var actif = boite.querySelector('.is-actif');
                if (actif) { e.preventDefault(); window.location.href = actif.href; }
            }
        });
        champ.addEventListener('focus', function () { if (boite.innerHTML && champ.value.trim().length >= 2) { boite.hidden = false; } });
        document.addEventListener('click', function (e) { if (!form.contains(e.target)) { fermer(); } });

        form.addEventListener('submit', function (e) {
            // Recherche vide : rien à chercher, on ouvre la boutique entière.
            if (champ.value.trim() === '') { e.preventDefault(); window.location.href = CFG.boutique; }
        });
    });
})();
</script>
