{{--
    Modale de détail produit pour les grilles de template.

    Les données viennent des attributs `data-gx-*` posés sur chaque carte par
    TemplateProducts : aucune requête réseau au clic, et la modale reste
    fonctionnelle sur une page servie depuis le cache.

    Le clic est capté au niveau du document (délégation) : les cartes sont
    créées au rendu serveur, mais ce partial est injecté avant </body>, donc
    après elles — et surtout, la délégation survit à toute réécriture du DOM.
--}}
@once
<style>
    .gxpm-backdrop{position:fixed;inset:0;z-index:100000;background:rgba(15,23,42,.55);backdrop-filter:blur(3px);opacity:0;pointer-events:none;transition:opacity .22s ease}
    .gxpm-backdrop.is-open{opacity:1;pointer-events:auto}
    .gxpm-shell{position:fixed;inset:0;z-index:100001;display:flex;align-items:center;justify-content:center;padding:24px;opacity:0;pointer-events:none;transition:opacity .22s ease}
    .gxpm-shell.is-open{opacity:1;pointer-events:auto}
    .gxpm{width:min(940px,100%);max-height:88vh;overflow:auto;background:#fff;color:#0b1220;border-radius:22px;box-shadow:0 40px 90px rgba(2,6,23,.4);transform:translateY(16px) scale(.98);transition:transform .26s cubic-bezier(.34,1.2,.4,1);font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif;line-height:1.6}
    .gxpm-shell.is-open .gxpm{transform:none}
    .gxpm-close{position:absolute;top:18px;right:18px;width:40px;height:40px;border-radius:50%;border:0;background:rgba(255,255,255,.94);box-shadow:0 6px 18px rgba(2,6,23,.18);font-size:22px;line-height:1;cursor:pointer;z-index:2}
    .gxpm-grid{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:0}
    .gxpm-media{background:#f1f5f9;position:relative}
    .gxpm-main{width:100%;height:100%;min-height:320px;max-height:60vh;object-fit:cover;display:block}
    .gxpm-thumbs{display:flex;gap:8px;padding:10px;overflow-x:auto;background:#fff}
    .gxpm-thumbs button{flex:0 0 auto;width:62px;height:62px;padding:0;border:2px solid transparent;border-radius:10px;overflow:hidden;background:none;cursor:pointer}
    .gxpm-thumbs button.is-active{border-color:#f5c542}
    .gxpm-thumbs img{width:100%;height:100%;object-fit:cover;display:block}
    .gxpm-body{padding:30px 30px 26px;display:flex;flex-direction:column}
    .gxpm-cat{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.09em;color:#047857;margin-bottom:6px}
    .gxpm-name{font-size:26px;font-weight:800;line-height:1.15;margin:0 0 10px}
    .gxpm-price{font-size:30px;font-weight:900;margin:6px 0 2px}
    .gxpm-price small{font-size:14px;font-weight:600;color:#64748b}
    .gxpm-stock{font-size:13px;color:#64748b;margin-bottom:14px}
    .gxpm-desc{color:#334155;font-size:15px;margin:0 0 18px}
    .gxpm-meta{font-size:13px;color:#64748b;border-top:1px solid #e6e9f0;padding-top:12px;margin-bottom:16px}
    .gxpm-actions{display:flex;flex-wrap:wrap;gap:12px;align-items:center;margin-top:auto}
    .gxpm-qty{display:inline-flex;align-items:center;border:1px solid #e6e9f0;border-radius:999px;background:#fbfcfe}
    .gxpm-qty button{width:40px;height:44px;border:0;background:none;font-size:18px;cursor:pointer}
    .gxpm-qty input{width:48px;height:44px;border:0;background:none;text-align:center;font:inherit;font-weight:900;-moz-appearance:textfield}
    .gxpm-qty input::-webkit-outer-spin-button,.gxpm-qty input::-webkit-inner-spin-button{-webkit-appearance:none;margin:0}
    .gxpm-add{flex:1 1 200px;border:0;border-radius:14px;background:#f5c542;color:#111827;font-weight:900;font-size:15px;padding:15px 20px;cursor:pointer}
    .gxpm-add[disabled]{background:#e2e8f0;color:#94a3b8;cursor:not-allowed}
    .gxpm-link{display:inline-block;margin-top:12px;font-size:13px;font-weight:700;color:#047857;text-decoration:underline}
    @media(max-width:780px){.gxpm-grid{grid-template-columns:1fr}.gxpm-main{max-height:38vh}.gxpm-body{padding:22px}}
</style>

<div class="gxpm-backdrop" data-gxpm-close></div>
<div class="gxpm-shell" data-gxpm-shell role="dialog" aria-modal="true" aria-label="Détail du produit">
    <div class="gxpm" style="position:relative">
        <button type="button" class="gxpm-close" data-gxpm-close aria-label="Fermer">&times;</button>
        <div class="gxpm-grid">
            <div class="gxpm-media">
                <img class="gxpm-main" data-gxpm-image src="" alt="">
                <div class="gxpm-thumbs" data-gxpm-thumbs></div>
            </div>
            <div class="gxpm-body">
                <div class="gxpm-cat" data-gxpm-cat></div>
                <h2 class="gxpm-name" data-gxpm-name></h2>
                <div class="gxpm-price" data-gxpm-price></div>
                <div class="gxpm-stock" data-gxpm-stock></div>
                <p class="gxpm-desc" data-gxpm-desc></p>
                <div class="gxpm-meta" data-gxpm-meta></div>
                <div class="gxpm-actions">
                    <div class="gxpm-qty">
                        <button type="button" data-gxpm-minus aria-label="Diminuer">&minus;</button>
                        <input type="number" value="1" min="1" max="99" data-gxpm-qty aria-label="Quantité">
                        <button type="button" data-gxpm-plus aria-label="Augmenter">+</button>
                    </div>
                    <button type="button" class="gxpm-add" data-gxpm-add data-cms-cart-add>
                        Ajouter au panier
                    </button>
                </div>
                <a class="gxpm-link" data-gxpm-link href="#">Voir la fiche complète</a>
            </div>
        </div>
    </div>
</div>

<script>
(() => {
    const shell = document.querySelector('[data-gxpm-shell]');
    const backdrop = document.querySelector('.gxpm-backdrop');
    if (!shell) return;

    const $ = (sel) => shell.querySelector(sel);
    const image = $('[data-gxpm-image]');
    const thumbs = $('[data-gxpm-thumbs]');
    const boutonAjout = $('[data-gxpm-add]');
    const champQte = $('[data-gxpm-qty]');

    /* Le site est affiché DANS UNE IFRAME sans défilement propre, dont la
       hauteur suit celle du contenu : `position:fixed` s'ancre alors au
       document entier, et la modale se centrait au milieu de toute la page —
       soit très loin sous la bande réellement visible.

       Le pont parent-enfant (cf. embed/partials/child-bridge) sait replacer
       une modale sur la bande visible ; il suffit de l'en informer. Hors
       iframe, personne n'écoute et le `position:fixed` d'origine s'applique. */
    const signaler = (nom) => {
        try {
            window.dispatchEvent(new CustomEvent(nom, { detail: { element: shell } }));
        } catch (e) { /* navigateur sans CustomEvent : la modale reste utilisable */ }
    };

    const ouvrir = () => {
        shell.classList.add('is-open');
        backdrop.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        signaler('gx:overlay-open');
    };
    const fermer = () => {
        shell.classList.remove('is-open');
        backdrop.classList.remove('is-open');
        document.body.style.overflow = '';
        signaler('gx:overlay-close');
    };

    const remplir = (carte) => {
        const d = carte.dataset;

        $('[data-gxpm-name]').textContent = d.gxName || '';
        $('[data-gxpm-price]').textContent = d.gxPrice || '';
        $('[data-gxpm-stock]').textContent = d.gxStock || '';
        $('[data-gxpm-desc]').textContent = d.gxDescription || '';
        $('[data-gxpm-cat]').textContent = d.gxCategory || '';
        $('[data-gxpm-cat]').style.display = d.gxCategory ? '' : 'none';
        $('[data-gxpm-link]').href = d.gxUrl || '#';

        const details = [];
        if (d.gxReference) details.push('Référence : ' + d.gxReference);
        if (d.gxUnit) details.push('Vendu par ' + d.gxUnit);
        $('[data-gxpm-meta]').textContent = details.join(' · ');
        $('[data-gxpm-meta]').style.display = details.length ? '' : 'none';

        // Galerie : celle du produit si elle existe, sinon l'image de la carte.
        let galerie = [];
        try { galerie = JSON.parse(d.gxGallery || '[]'); } catch (e) { galerie = []; }
        if (!galerie.length) {
            const img = carte.querySelector('img');
            if (img && img.src) galerie = [img.src];
        }

        image.src = galerie[0] || '';
        image.alt = d.gxName || '';
        thumbs.innerHTML = galerie.length > 1
            ? galerie.map((url, i) => `<button type="button" class="${i === 0 ? 'is-active' : ''}" data-url="${url}">
                   <img src="${url}" alt=""></button>`).join('')
            : '';

        // Le bouton d'ajout reprend le contrat du tiroir panier. Sans prix
        // exploitable, il n'y a rien à mettre au panier : on invite à ouvrir
        // la fiche plutôt que d'ajouter une ligne à 0 $.
        champQte.value = 1;
        if (d.gxPriceRaw) {
            boutonAjout.disabled = false;
            boutonAjout.textContent = 'Ajouter au panier';
            boutonAjout.setAttribute('data-cms-cart-add', '');
            boutonAjout.dataset.productId = carte.dataset.gxProductId || '';
            boutonAjout.dataset.productName = d.gxName || '';
            boutonAjout.dataset.productPrice = d.gxPriceRaw;
            boutonAjout.dataset.productImage = galerie[0] || '';
            boutonAjout.dataset.productUrl = d.gxUrl || '';
            boutonAjout.dataset.productQuantity = '1';
            const source = carte.querySelector('[data-etablissement-id]');
            if (source) {
                boutonAjout.dataset.etablissementId = source.dataset.etablissementId || '';
                boutonAjout.dataset.etablissementName = source.dataset.etablissementName || '';
            }
        } else {
            boutonAjout.disabled = true;
            boutonAjout.textContent = 'Sur demande';
            boutonAjout.removeAttribute('data-cms-cart-add');
        }
    };

    document.addEventListener('click', (event) => {
        if (event.target.closest('[data-gxpm-close]') || event.target === backdrop) { fermer(); return; }
        if (event.target.closest('[data-gxpm-shell] .gxpm')) {
            const vignette = event.target.closest('[data-gxpm-thumbs] button');
            if (vignette) {
                image.src = vignette.dataset.url;
                thumbs.querySelectorAll('button').forEach((b) => b.classList.remove('is-active'));
                vignette.classList.add('is-active');
            }
            // Ajout au panier : le tiroir écoute déjà au niveau du document,
            // on referme simplement pour qu'il apparaisse.
            if (event.target.closest('[data-gxpm-add]:not([disabled])')) setTimeout(fermer, 60);
            return;
        }

        const carte = event.target.closest('[data-gx-modal]');
        if (!carte) return;

        // Le bouton « ajouter au panier » de la carte garde son rôle : on
        // n'ouvre pas la modale par-dessus l'ajout.
        if (event.target.closest('[data-cms-cart-add]')) return;

        event.preventDefault();
        remplir(carte);
        ouvrir();
    });

    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') fermer(); });

    const borner = (v) => Math.max(1, Math.min(99, Number(v) || 1));
    const reporter = () => { champQte.value = borner(champQte.value); boutonAjout.dataset.productQuantity = String(champQte.value); };
    champQte.addEventListener('input', reporter);
    $('[data-gxpm-minus]').addEventListener('click', () => { champQte.value = borner(Number(champQte.value) - 1); reporter(); });
    $('[data-gxpm-plus]').addEventListener('click', () => { champQte.value = borner(Number(champQte.value) + 1); reporter(); });
})();
</script>
@endonce
