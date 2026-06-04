<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Finaliser ma commande | GoExploria</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root{--ink:#101827;--muted:#64748b;--line:#e5e7eb;--gold:#f5c542;--bg:#f6f7fb}
        *{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--ink);font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif}
        a{color:inherit}.checkout-top{background:#0b1220;color:#fff;padding:22px 28px}.checkout-top-inner{max-width:1180px;margin:auto;display:flex;align-items:center;justify-content:space-between;gap:18px}
        .checkout-logo{font-weight:950;font-size:22px;text-decoration:none}.checkout-logo span{color:var(--gold)}.checkout-wrap{max-width:1180px;margin:34px auto;padding:0 24px}
        .checkout-head{margin-bottom:24px}.checkout-kicker{font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#d19213;font-weight:950}.checkout-title{font-size:clamp(32px,5vw,54px);line-height:1;margin:8px 0 10px}.checkout-sub{color:var(--muted);max-width:720px;line-height:1.7}
        .checkout-grid{display:grid;grid-template-columns:minmax(0,1fr) 420px;gap:22px;align-items:start}.checkout-card{background:#fff;border:1px solid var(--line);border-radius:18px;box-shadow:0 18px 48px rgba(15,23,42,.08);padding:24px}
        .cart-list{display:grid;gap:12px}.cart-row{display:grid;grid-template-columns:78px 1fr auto;gap:14px;align-items:center;border:1px solid var(--line);border-radius:14px;padding:12px}.cart-row img{width:78px;height:78px;object-fit:cover;border-radius:12px;background:#eef2f7}.cart-name{font-weight:950}.cart-meta{font-size:13px;color:var(--muted);margin-top:4px}.cart-price{text-align:right;font-weight:950}.cart-empty{padding:34px;text-align:center;color:var(--muted);border:1px dashed #cbd5e1;border-radius:16px;background:#f8fafc}
        .summary-row{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:10px 0;border-bottom:1px solid var(--line)}.summary-total{font-size:24px;font-weight:950;border-bottom:0}.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}.field{display:grid;gap:7px}.field.full{grid-column:1/-1}.field label{font-size:12px;text-transform:uppercase;letter-spacing:.08em;color:var(--muted);font-weight:900}.field input,.field textarea{width:100%;border:1px solid var(--line);border-radius:12px;padding:13px 14px;font:inherit}.field textarea{min-height:120px;resize:vertical}.consent{display:flex;gap:10px;color:var(--muted);font-size:14px;line-height:1.55}.checkout-btn{width:100%;border:0;border-radius:14px;background:var(--gold);color:#111827;padding:15px 18px;font-weight:950;cursor:pointer;margin-top:16px}.checkout-btn[disabled]{opacity:.65;cursor:wait}.notice{display:none;margin-top:14px;border-radius:12px;padding:13px 14px;font-weight:800}.notice.ok{display:block;background:#ecfdf5;color:#047857}.notice.err{display:block;background:#fef2f2;color:#b91c1c}
        @media(max-width:900px){.checkout-grid{grid-template-columns:1fr}.form-grid{grid-template-columns:1fr}.cart-row{grid-template-columns:64px 1fr}.cart-price{grid-column:2;text-align:left}.checkout-top-inner{display:block}}
    </style>
</head>
<body>
    <header class="checkout-top">
        <div class="checkout-top-inner">
            <a class="checkout-logo" href="{{ url('/') }}">GoExploria<span>.</span></a>
            <span>Commande multi-etablissements</span>
        </div>
    </header>

    <main class="checkout-wrap">
        <div class="checkout-head">
            <div class="checkout-kicker">Achat produits</div>
            <h1 class="checkout-title">Finaliser ma commande</h1>
            <p class="checkout-sub">Votre panier peut contenir des produits de plusieurs etablissements. Chaque etablissement recevra sa partie de la commande.</p>
        </div>

        <div class="checkout-grid">
            <section class="checkout-card">
                <h2>Vos informations</h2>
                <form id="cmsCheckoutForm" method="POST" action="{{ $checkoutSubmitUrl }}">
                    @csrf
                    <input type="hidden" name="cart_payload" id="cartPayload">
                    <div class="form-grid">
                        <div class="field"><label>Prenom *</label><input type="text" name="first_name" required></div>
                        <div class="field"><label>Nom</label><input type="text" name="last_name"></div>
                        <div class="field"><label>Email *</label><input type="email" name="email" required></div>
                        <div class="field"><label>Telephone</label><input type="tel" name="phone"></div>
                        <div class="field full"><label>Entreprise</label><input type="text" name="company"></div>
                        <div class="field full"><label>Message</label><textarea name="message" placeholder="Precision de livraison, date souhaitee, commentaire..."></textarea></div>
                        <label class="field full consent"><input type="checkbox" name="consent" value="1" required> <span>J'accepte d'etre contacte concernant cette commande.</span></label>
                    </div>
                    <button class="checkout-btn" type="submit" id="checkoutSubmit">Envoyer ma commande</button>
                    <div class="notice" id="checkoutNotice"></div>
                </form>
            </section>

            <aside class="checkout-card">
                <h2>Resume panier</h2>
                <div class="cart-list" id="checkoutCartList"></div>
                <div style="margin-top:18px">
                    <div class="summary-row"><span>Articles</span><strong id="checkoutQty">0</strong></div>
                    <div class="summary-row summary-total"><span>Total</span><strong id="checkoutTotal">0,00 $</strong></div>
                </div>
            </aside>
        </div>
    </main>

    <script>
    (() => {
        const key = 'cms_landing_cart_v1';
        const form = document.getElementById('cmsCheckoutForm');
        const payload = document.getElementById('cartPayload');
        const list = document.getElementById('checkoutCartList');
        const qty = document.getElementById('checkoutQty');
        const total = document.getElementById('checkoutTotal');
        const notice = document.getElementById('checkoutNotice');
        const submit = document.getElementById('checkoutSubmit');
        const money = value => `${Number(value || 0).toLocaleString('fr-CA', {minimumFractionDigits: 2, maximumFractionDigits: 2})} $`;
        const esc = value => String(value || '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char]));
        const read = () => {
            try {
                const parsed = JSON.parse(localStorage.getItem(key) || '{"items":[]}');
                return {items: Array.isArray(parsed.items) ? parsed.items : []};
            } catch (e) {
                return {items: []};
            }
        };
        const render = () => {
            const cart = read();
            const totalQty = cart.items.reduce((sum, item) => sum + Number(item.quantity || 0), 0);
            const totalPrice = cart.items.reduce((sum, item) => sum + Number(item.price || 0) * Number(item.quantity || 0), 0);
            payload.value = JSON.stringify(cart);
            qty.textContent = totalQty;
            total.textContent = money(totalPrice);
            if (!cart.items.length) {
                list.innerHTML = '<div class="cart-empty">Votre panier est vide. Revenez sur une landing page pour ajouter des produits.</div>';
                return;
            }
            list.innerHTML = cart.items.map(item => `
                <article class="cart-row">
                    <img src="${esc(item.image || 'https://images.pexels.com/photos/3184465/pexels-photo-3184465.jpeg?auto=compress&cs=tinysrgb&w=300')}" alt="">
                    <div>
                        <div class="cart-name">${esc(item.name)}</div>
                        <div class="cart-meta">${esc(item.etablissement_name || 'Etablissement')} · Quantite ${Number(item.quantity || 1)}</div>
                    </div>
                    <div class="cart-price">${money(Number(item.price || 0) * Number(item.quantity || 1))}</div>
                </article>
            `).join('');
        };
        const showNotice = (type, text) => {
            notice.className = `notice ${type}`;
            notice.textContent = text;
        };
        form.addEventListener('submit', async event => {
            event.preventDefault();
            const cart = read();
            if (!cart.items.length) {
                showNotice('err', 'Votre panier est vide.');
                return;
            }
            payload.value = JSON.stringify(cart);
            submit.disabled = true;
            submit.textContent = 'Envoi en cours...';
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: new FormData(form),
                });
                const data = await response.json();
                if (!response.ok || !data.success) {
                    showNotice('err', data.message || 'Merci de verifier les informations.');
                    return;
                }
                localStorage.removeItem(key);
                render();
                showNotice('ok', `Commande envoyee. Reference: ${data.reference}`);
                form.reset();
            } catch (e) {
                showNotice('err', 'Impossible d envoyer la commande pour le moment.');
            } finally {
                submit.disabled = false;
                submit.textContent = 'Envoyer ma commande';
            }
        });
        render();
    })();
    </script>
</body>
</html>
