@once
@php
    // Panier isolé par établissement : on fige l'ID ici pour que la clé
    // localStorage soit scindée par site. Sans établissement (ex. page globale)
    // on retombe sur la clé historique pour compatibilité.
    $cartEtablissementId = isset($etablissement) && $etablissement ? ($etablissement->id ?? null) : null;
    $cartEtablissementId = $cartEtablissementId ? (string) $cartEtablissementId : null;
    $cartEtablissementName = isset($etablissement) && $etablissement ? ($etablissement->name ?? null) : null;
    // URL checkout : préfère la route scindée /company/{id}/achat si dispo
    $cmsCartCheckoutUrl = null;
    if ($cartEtablissementId) {
        if (\Illuminate\Support\Facades\Route::has('cms.company.checkout')) {
            try {
                $cmsCartCheckoutUrl = route('cms.company.checkout', ['etablissementId' => $cartEtablissementId]);
            } catch (\Throwable $e) {
                $cmsCartCheckoutUrl = null;
            }
        }
        if (!$cmsCartCheckoutUrl) {
            $base = \Illuminate\Support\Facades\Route::has('cms.checkout') ? route('cms.checkout') : url('/achat');
            $cmsCartCheckoutUrl = $base . (str_contains($base, '?') ? '&' : '?') . 'etablissement=' . $cartEtablissementId;
        }
    } else {
        $cmsCartCheckoutUrl = \Illuminate\Support\Facades\Route::has('cms.checkout') ? route('cms.checkout') : url('/achat');
    }
@endphp

<style>
    .cms-cart-fab{position:fixed;right:24px;bottom:96px;z-index:9998;display:flex;align-items:center;gap:10px;border:0;border-radius:999px;background:#111827;color:#fff;padding:12px 16px;box-shadow:0 18px 44px rgba(15,23,42,.28);font-weight:900;cursor:pointer}
    .cms-cart-fab i{color:#f5c542}.cms-cart-count{min-width:24px;height:24px;border-radius:999px;background:#f5c542;color:#111827;display:inline-grid;place-items:center;font-size:12px}
    .cms-cart-backdrop{position:fixed;inset:0;background:rgba(15,23,42,.42);z-index:99998;opacity:0;pointer-events:none;transition:opacity .22s ease}
    .cms-cart-backdrop.is-open{opacity:1;pointer-events:auto}
    .cms-cart-drawer{position:fixed;top:0;right:0;bottom:0;z-index:99999;width:min(440px,100vw);background:#fff;color:#111827;box-shadow:-28px 0 80px rgba(15,23,42,.24);transform:translateX(105%);transition:transform .28s ease;display:flex;flex-direction:column}
    .cms-cart-drawer.is-open{transform:translateX(0)}
    .cms-cart-head{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:22px;border-bottom:1px solid #e5e7eb}
    .cms-cart-head h3{margin:0;font-size:22px;line-height:1.1}.cms-cart-close{width:40px;height:40px;border-radius:50%;border:1px solid #e5e7eb;background:#fff;cursor:pointer}
    .cms-cart-body{flex:1;overflow:auto;padding:18px 22px}.cms-cart-empty{padding:36px 18px;text-align:center;color:#64748b;background:#f8fafc;border-radius:18px}
    .cms-cart-item{display:grid;grid-template-columns:74px 1fr;gap:14px;padding:14px 0;border-bottom:1px solid #edf2f7}
    .cms-cart-item img{width:74px;height:74px;object-fit:cover;border-radius:12px;background:#f1f5f9}.cms-cart-item-title{font-weight:900;margin-bottom:4px}.cms-cart-item-meta{font-size:12px;color:#64748b}
    .cms-cart-item-actions{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:10px}.cms-cart-qty{display:inline-flex;align-items:center;border:1px solid #e5e7eb;border-radius:999px;overflow:hidden}
    .cms-cart-qty button{width:30px;height:30px;border:0;background:#f8fafc;cursor:pointer}.cms-cart-qty span{min-width:34px;text-align:center;font-weight:900}
    .cms-cart-remove{border:0;background:transparent;color:#dc2626;font-weight:800;cursor:pointer}.cms-cart-price{font-weight:900;color:#111827}
    .cms-cart-foot{padding:18px 22px 22px;border-top:1px solid #e5e7eb;background:#fff}.cms-cart-total{display:flex;align-items:center;justify-content:space-between;font-size:18px;font-weight:950;margin-bottom:14px}
    .cms-cart-checkout,.cms-cart-continue{width:100%;border:0;border-radius:14px;padding:14px 16px;font-weight:950;cursor:pointer}.cms-cart-checkout{background:#f5c542;color:#111827}.cms-cart-continue{margin-top:10px;background:#f8fafc;color:#111827}
    .cms-cart-toast{position:fixed;right:24px;bottom:166px;z-index:100000;background:#111827;color:#fff;padding:12px 16px;border-radius:12px;box-shadow:0 14px 32px rgba(15,23,42,.28);opacity:0;transform:translateY(12px);pointer-events:none;transition:opacity .2s ease,transform .2s ease;font-weight:800}
    .cms-cart-toast.is-visible{opacity:1;transform:translateY(0)}
    @media(max-width:640px){.cms-cart-fab{right:14px;bottom:82px;padding:11px 13px}.cms-cart-label{display:none}.cms-cart-toast{left:14px;right:14px;bottom:146px}}
</style>

<button class="cms-cart-fab" type="button" data-cms-cart-open aria-label="Ouvrir le panier">
    <i class="fas fa-cart-shopping"></i>
    <span class="cms-cart-label">Panier</span>
    <span class="cms-cart-count" data-cms-cart-count>0</span>
</button>
<div class="cms-cart-backdrop" data-cms-cart-close></div>
<aside class="cms-cart-drawer" aria-hidden="true" data-cms-cart-drawer>
    <div class="cms-cart-head">
        <div>
            <h3>Votre panier</h3>
            <div class="cms-cart-item-meta">
                @if(!empty($cartEtablissementName))
                    {{ $cartEtablissementName }} · Uniquement ses produits
                @else
                    Produits de cet établissement uniquement
                @endif
            </div>
        </div>
        <button class="cms-cart-close" type="button" data-cms-cart-close aria-label="Fermer"><i class="fas fa-xmark"></i></button>
    </div>
    <div class="cms-cart-body" data-cms-cart-items></div>
    <div class="cms-cart-foot">
        <div class="cms-cart-total"><span>Total</span><strong data-cms-cart-total>0,00 $</strong></div>
        <button class="cms-cart-checkout" type="button" data-cms-cart-checkout>Finaliser l'achat</button>
        <button class="cms-cart-continue" type="button" data-cms-cart-close>Continuer mes achats</button>
    </div>
</aside>
<div class="cms-cart-toast" data-cms-cart-toast>Produit ajoute au panier</div>

<script>
(() => {
    const baseKey = 'cms_landing_cart_v1';
    const legacyKey = baseKey;
    const injectedEtablissementId = @json($cartEtablissementId);
    const injectedEtablissementName = @json($cartEtablissementName);
    const checkoutUrl = @json($cmsCartCheckoutUrl);
    const drawer = document.querySelector('[data-cms-cart-drawer]');
    const backdrop = document.querySelector('.cms-cart-backdrop');
    const itemsNode = document.querySelector('[data-cms-cart-items]');
    const countNodes = document.querySelectorAll('[data-cms-cart-count]');
    const totalNode = document.querySelector('[data-cms-cart-total]');
    const toast = document.querySelector('[data-cms-cart-toast]');

    const detectEtablissementId = () => {
        if (injectedEtablissementId) return String(injectedEtablissementId);
        try {
            const m = window.location.pathname.match(/\/company\/(\d+)/);
            if (m) return m[1];
            const frame = document.getElementById('gxEmbedFrame');
            if (frame && frame.src) {
                const fm = frame.src.match(/\/company\/(\d+)/);
                if (fm) return fm[1];
            }
            // data attribut posé sur le body ou le drawer par le parent
            const bodyId = document.body?.dataset?.etablissementId;
            if (bodyId) return String(bodyId);
        } catch (e) {}
        return null;
    };
    const currentEtablissementId = detectEtablissementId();
    const key = currentEtablissementId ? `${baseKey}_${currentEtablissementId}` : baseKey;

    const money = value => `${Number(value || 0).toLocaleString('fr-CA', {minimumFractionDigits: 2, maximumFractionDigits: 2})} $`;
    const esc = value => String(value || '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char]));
    const read = () => {
        try {
            const raw = localStorage.getItem(key);
            if (raw) {
                const parsed = JSON.parse(raw);
                return {items: Array.isArray(parsed.items) ? parsed.items : []};
            }
            // Migration douce depuis l'ancienne clé globale : si la nouvelle clé
            // est vide mais l'ancienne contient des produits de cet établissement,
            // on les importe. Évite que les paniers existants disparaissent au
            // déploiement.
            if (key !== legacyKey && currentEtablissementId) {
                try {
                    const legacyRaw = localStorage.getItem(legacyKey);
                    if (legacyRaw) {
                        const legacyParsed = JSON.parse(legacyRaw);
                        const legacyItems = Array.isArray(legacyParsed.items) ? legacyParsed.items : [];
                        const filtered = legacyItems.filter(it => String(it.etablissement_id || it.etablissementId || '') === String(currentEtablissementId));
                        if (filtered.length) {
                            const migrated = {items: filtered};
                            try { localStorage.setItem(key, JSON.stringify(migrated)); } catch (e) {}
                            return migrated;
                        }
                    }
                } catch (e) {}
            }
            return {items: []};
        } catch (e) {
            return {items: []};
        }
    };
    const write = cart => {
        // Écrit toujours dans la clé isolée. Pour la compatibilité inter-doc
        // (parent iframe + enfant), on nettoie l'ancienne clé globale des items
        // qui viennent d'être déplacés, sans la vider brutalement.
        localStorage.setItem(key, JSON.stringify({items: cart.items || []}));
        if (key !== legacyKey && currentEtablissementId) {
            try {
                const legacyRaw = localStorage.getItem(legacyKey);
                if (legacyRaw) {
                    const legacyParsed = JSON.parse(legacyRaw);
                    const legacyItems = Array.isArray(legacyParsed.items) ? legacyParsed.items : [];
                    const remaining = legacyItems.filter(it => String(it.etablissement_id || it.etablissementId || '') !== String(currentEtablissementId));
                    if (remaining.length !== legacyItems.length) {
                        if (remaining.length) localStorage.setItem(legacyKey, JSON.stringify({items: remaining}));
                        else localStorage.removeItem(legacyKey);
                    }
                }
            } catch (e) {}
        }
        window.dispatchEvent(new CustomEvent('cms-cart-updated', {detail: cart}));
    };
    const open = () => {
        drawer?.classList.add('is-open');
        backdrop?.classList.add('is-open');
        drawer?.setAttribute('aria-hidden', 'false');
    };
    const close = () => {
        drawer?.classList.remove('is-open');
        backdrop?.classList.remove('is-open');
        drawer?.setAttribute('aria-hidden', 'true');
    };
    const showToast = text => {
        if (!toast) return;
        toast.textContent = text;
        toast.classList.add('is-visible');
        setTimeout(() => toast.classList.remove('is-visible'), 1800);
    };
    const normalizeItem = data => ({
        id: String(data.productId || data.id || ''),
        etablissement_id: String(data.etablissementId || currentEtablissementId || ''),
        etablissement_name: data.etablissementName || injectedEtablissementName || '',
        name: data.productName || data.name || 'Produit',
        price: Number(data.productPrice || data.price || 0),
        image: data.productImage || data.image || '',
        url: data.productUrl || data.url || window.location.href,
        // La fiche produit a un sélecteur de quantité et pose
        // data-product-quantity. Les boutons qui ne le portent pas (grilles de
        // template, cartes de boutique) ajoutent une unité, comme avant.
        quantity: Math.max(1, Math.min(99, Number(data.productQuantity || 1)))
    });
    const render = () => {
        const cart = read();
        const totalQty = cart.items.reduce((sum, item) => sum + Number(item.quantity || 0), 0);
        const total = cart.items.reduce((sum, item) => sum + (Number(item.price || 0) * Number(item.quantity || 0)), 0);
        countNodes.forEach(node => node.textContent = totalQty);
        if (totalNode) totalNode.textContent = money(total);
        if (!itemsNode) return;
        if (!cart.items.length) {
            itemsNode.innerHTML = '<div class="cms-cart-empty">Votre panier est vide.</div>';
            return;
        }
        itemsNode.innerHTML = cart.items.map(item => `
            <article class="cms-cart-item" data-cart-id="${item.id}">
                <img src="${esc(item.image || 'https://images.pexels.com/photos/3184465/pexels-photo-3184465.jpeg?auto=compress&cs=tinysrgb&w=300')}" alt="">
                <div>
                    <div class="cms-cart-item-title">${esc(item.name)}</div>
                    <div class="cms-cart-item-meta">${esc(item.etablissement_name || 'Etablissement')} · ${money(item.price)}</div>
                    <div class="cms-cart-item-actions">
                        <div class="cms-cart-qty">
                            <button type="button" data-cms-cart-minus="${item.id}">-</button>
                            <span>${item.quantity}</span>
                            <button type="button" data-cms-cart-plus="${item.id}">+</button>
                        </div>
                        <button class="cms-cart-remove" type="button" data-cms-cart-remove="${item.id}">Retirer</button>
                    </div>
                </div>
            </article>
        `).join('');
    };
    const add = raw => {
        const item = normalizeItem(raw);
        if (!item.id) return;
        const cart = read();
        const found = cart.items.find(row => String(row.id) === item.id);
        if (found) {
            // On ajoute la quantité demandée, pas systématiquement 1 : sinon
            // « 6 » choisi sur la fiche produit n'en ajouterait qu'un de plus
            // quand l'article est déjà au panier.
            found.quantity = Math.min(99, Number(found.quantity || 1) + item.quantity);
        } else {
            cart.items.push(item);
        }
        write(cart);
        render();
        open();
        showToast('Produit ajoute au panier');
    };
    const changeQty = (id, delta) => {
        const cart = read();
        cart.items = cart.items.map(item => String(item.id) === String(id) ? {...item, quantity: Math.max(1, Number(item.quantity || 1) + delta)} : item);
        write(cart);
        render();
    };
    const remove = id => {
        const cart = read();
        cart.items = cart.items.filter(item => String(item.id) !== String(id));
        write(cart);
        render();
    };

    document.addEventListener('click', event => {
        const addBtn = event.target.closest('[data-cms-cart-add]');
        if (addBtn) {
            event.preventDefault();
            add(addBtn.dataset);
            return;
        }
        if (event.target.closest('[data-cms-cart-open]')) open();
        if (event.target.closest('[data-cms-cart-close]')) close();
        const plus = event.target.closest('[data-cms-cart-plus]');
        if (plus) changeQty(plus.dataset.cmsCartPlus, 1);
        const minus = event.target.closest('[data-cms-cart-minus]');
        if (minus) changeQty(minus.dataset.cmsCartMinus, -1);
        const del = event.target.closest('[data-cms-cart-remove]');
        if (del) remove(del.dataset.cmsCartRemove);
        if (event.target.closest('[data-cms-cart-checkout]')) {
            if (!read().items.length) {
                showToast('Votre panier est vide');
                return;
            }
            try {
                const url = new URL(checkoutUrl, window.location.origin);
                if (currentEtablissementId) url.searchParams.set('etablissement', currentEtablissementId);
                window.location.href = url.toString();
            } catch (e) {
                window.location.href = checkoutUrl + (currentEtablissementId ? (checkoutUrl.includes('?') ? '&' : '?') + 'etablissement=' + encodeURIComponent(currentEtablissementId) : '');
            }
        }
    });
    window.addEventListener('storage', event => {
        if (event.key === key || event.key === legacyKey) render();
    });
    // Écoute aussi l'événement custom pour synchro intra-page (iframe parent/enfant)
    window.addEventListener('cms-cart-updated', render);
    render();
})();
</script>
@endonce
