<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Finaliser ma commande | GoExploria</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root{--ink:#0b1220;--muted:#64748b;--line:#e6e9f0;--gold:#f5c542;--brand:#111827;--bg:#f4f6fb;--ok:#047857;--radius:18px}
        *{box-sizing:border-box}
        body{margin:0;background:var(--bg);color:var(--ink);font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;line-height:1.6}
        a{color:inherit;text-decoration:none}
        /* ===== Header global ===== */
        .gx-header{position:sticky;top:0;z-index:50;background:rgba(11,18,32,.98);backdrop-filter:blur(8px);color:#fff}
        .gx-header-in{max-width:1180px;margin:auto;display:flex;align-items:center;justify-content:space-between;gap:18px;padding:16px 24px}
        .gx-logo{display:flex;align-items:center;gap:10px;font-weight:900;font-size:22px;color:#fff}
        .gx-logo i{color:var(--gold)}.gx-logo span{color:var(--gold)}
        .gx-nav{display:flex;align-items:center;gap:26px}
        .gx-nav a{color:#cbd5e1;font-weight:600;font-size:15px;transition:.2s}.gx-nav a:hover{color:#fff}
        .gx-cart{position:relative;display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);color:#fff;padding:9px 16px;border-radius:999px;font-weight:800;cursor:pointer}
        .gx-cart i{color:var(--gold)}
        .gx-cart-count{min-width:22px;height:22px;border-radius:999px;background:var(--gold);color:#111827;display:inline-grid;place-items:center;font-size:12px;font-weight:900}
        @media(max-width:760px){.gx-nav{display:none}}
        /* ===== Layout ===== */
        .checkout-wrap{max-width:1180px;margin:34px auto;padding:0 24px}
        .checkout-head{margin-bottom:24px}
        .checkout-kicker{font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#d19213;font-weight:900}
        .checkout-title{font-size:clamp(30px,5vw,50px);line-height:1.05;margin:8px 0 10px}
        .checkout-sub{color:var(--muted);max-width:720px}
        .checkout-grid{display:grid;grid-template-columns:minmax(0,1fr) 430px;gap:22px;align-items:start}
        .checkout-card{background:#fff;border:1px solid var(--line);border-radius:var(--radius);box-shadow:0 18px 48px rgba(15,23,42,.07);padding:26px}
        .checkout-card h2{margin:0 0 18px;font-size:20px}
        /* ===== Form ===== */
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .field{display:grid;gap:7px}.field.full{grid-column:1/-1}
        .field label{font-size:12px;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);font-weight:800}
        .field input,.field textarea{width:100%;border:1px solid var(--line);border-radius:12px;padding:13px 14px;font:inherit;background:#fbfcfe}
        .field input:focus,.field textarea:focus{outline:none;border-color:var(--gold);box-shadow:0 0 0 3px rgba(245,197,66,.25)}
        .field textarea{min-height:110px;resize:vertical}
        .consent{display:flex;gap:10px;color:var(--muted);font-size:14px;align-items:flex-start}
        /* ===== Paiement ===== */
        .pay-methods{display:grid;gap:12px;margin-top:6px}
        .pay-opt{display:flex;align-items:center;gap:14px;border:1.5px solid var(--line);border-radius:14px;padding:15px 16px;cursor:pointer;transition:.2s;background:#fbfcfe}
        .pay-opt:hover{border-color:#cbd5e1}
        .pay-opt.is-active{border-color:var(--gold);background:#fffdf5;box-shadow:0 0 0 3px rgba(245,197,66,.18)}
        .pay-opt input{accent-color:var(--gold);width:18px;height:18px}
        .pay-opt-ico{width:44px;height:44px;border-radius:12px;display:grid;place-items:center;font-size:20px;background:#eef2f7;color:#111827}
        .pay-opt-ico.paypal{background:#003087;color:#fff}
        .pay-opt-txt strong{display:block}.pay-opt-txt small{color:var(--muted)}
        #paypal-buttons{margin-top:16px;min-height:46px}
        .checkout-btn{width:100%;border:0;border-radius:14px;background:var(--gold);color:#111827;padding:16px 18px;font-weight:900;font-size:16px;cursor:pointer;margin-top:18px}
        .checkout-btn[disabled]{opacity:.65;cursor:wait}
        .notice{display:none;margin-top:14px;border-radius:12px;padding:13px 14px;font-weight:800}
        .notice.ok{display:block;background:#ecfdf5;color:var(--ok)}
        .notice.err{display:block;background:#fef2f2;color:#b91c1c}
        /* ===== Résumé ===== */
        .cart-list{display:grid;gap:12px}
        .cart-row{display:grid;grid-template-columns:74px 1fr auto;gap:14px;align-items:center;border:1px solid var(--line);border-radius:14px;padding:12px}
        .cart-row img{width:74px;height:74px;object-fit:cover;border-radius:12px;background:#eef2f7}
        .cart-name{font-weight:800}.cart-meta{font-size:13px;color:var(--muted);margin-top:4px}.cart-price{text-align:right;font-weight:900}
        .cart-empty{padding:34px;text-align:center;color:var(--muted);border:1px dashed #cbd5e1;border-radius:16px;background:#f8fafc}
        .summary-row{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:10px 0;border-bottom:1px solid var(--line)}
        .summary-total{font-size:24px;font-weight:900;border-bottom:0}
        .trust{display:flex;gap:16px;flex-wrap:wrap;margin-top:16px;color:var(--muted);font-size:13px}
        .trust span{display:inline-flex;align-items:center;gap:7px}.trust i{color:var(--ok)}
        @media(max-width:920px){.checkout-grid{grid-template-columns:1fr}.form-grid{grid-template-columns:1fr}.cart-row{grid-template-columns:64px 1fr}.cart-price{grid-column:2;text-align:left}}
    </style>
</head>
<body>
    <header class="gx-header">
        <div class="gx-header-in">
            <a class="gx-logo" href="{{ url('/') }}"><i class="fas fa-compass"></i> GoExploria<span>.</span></a>
            <nav class="gx-nav">
                <a href="{{ url('/') }}">Accueil</a>
                <a href="{{ url('/') }}"><i class="fas fa-store"></i> Boutiques</a>
                <a href="{{ url('/') }}#etablissements">Établissements</a>
            </nav>
            <button class="gx-cart" type="button" onclick="document.getElementById('checkoutCartCard').scrollIntoView({behavior:'smooth'})" aria-label="Panier">
                <i class="fas fa-cart-shopping"></i>
                <span>Panier</span>
                <span class="gx-cart-count" id="gxCartCount">0</span>
            </button>
        </div>
    </header>

    <main class="checkout-wrap">
        <div class="checkout-head">
            <div class="checkout-kicker">Achat produits</div>
            <h1 class="checkout-title">Finaliser ma commande</h1>
            <p class="checkout-sub">Votre panier peut contenir des produits de plusieurs établissements. Chaque établissement recevra sa partie de la commande.</p>
        </div>

        <div class="checkout-grid">
            <section class="checkout-card">
                <h2>Vos informations</h2>
                <form id="cmsCheckoutForm" method="POST" action="{{ $checkoutSubmitUrl }}">
                    @csrf
                    <input type="hidden" name="cart_payload" id="cartPayload">
                    <input type="hidden" name="payment_method" id="paymentMethod" value="cod">
                    <input type="hidden" name="payment_reference" id="paymentReference" value="">
                    <div class="form-grid">
                        <div class="field"><label>Prénom *</label><input type="text" name="first_name" required></div>
                        <div class="field"><label>Nom</label><input type="text" name="last_name"></div>
                        <div class="field"><label>Email *</label><input type="email" name="email" required></div>
                        <div class="field"><label>Téléphone</label><input type="tel" name="phone"></div>
                        <div class="field full"><label>Adresse / Entreprise</label><input type="text" name="company" placeholder="Adresse de livraison ou entreprise"></div>
                        <div class="field full"><label>Message</label><textarea name="message" placeholder="Précision de livraison, date souhaitée, commentaire..."></textarea></div>
                        <label class="field full consent"><input type="checkbox" name="consent" value="1" required> <span>J'accepte d'être contacté concernant cette commande.</span></label>
                    </div>

                    <h2 style="margin-top:26px">Mode de paiement</h2>
                    <div class="pay-methods">
                        <label class="pay-opt is-active" data-pay-opt="cod">
                            <input type="radio" name="pay_choice" value="cod" checked>
                            <span class="pay-opt-ico"><i class="fas fa-truck"></i></span>
                            <span class="pay-opt-txt"><strong>Paiement à la livraison</strong><small>Payez en espèces ou par carte à la réception.</small></span>
                        </label>
                        @if(!empty($paypal['enabled']))
                        <label class="pay-opt" data-pay-opt="paypal">
                            <input type="radio" name="pay_choice" value="paypal">
                            <span class="pay-opt-ico paypal"><i class="fab fa-paypal"></i></span>
                            <span class="pay-opt-txt"><strong>PayPal</strong><small>Paiement sécurisé par carte ou compte PayPal.</small></span>
                        </label>
                        @endif
                    </div>

                    <button class="checkout-btn" type="submit" id="checkoutSubmit">
                        <i class="fas fa-truck"></i> Confirmer la commande (paiement à la livraison)
                    </button>
                    <div id="paypal-buttons" style="display:none"></div>
                    <div class="notice" id="checkoutNotice"></div>
                </form>
            </section>

            <aside class="checkout-card" id="checkoutCartCard">
                <h2>Résumé du panier</h2>
                <div class="cart-list" id="checkoutCartList"></div>
                <div style="margin-top:18px">
                    <div class="summary-row"><span>Articles</span><strong id="checkoutQty">0</strong></div>
                    <div class="summary-row summary-total"><span>Total</span><strong id="checkoutTotal">0,00 $</strong></div>
                </div>
                <div class="trust">
                    <span><i class="fas fa-lock"></i> Paiement sécurisé</span>
                    <span><i class="fas fa-rotate-left"></i> Support dédié</span>
                    <span><i class="fas fa-store"></i> Multi-établissements</span>
                </div>
            </aside>
        </div>
    </main>

    @php
        $paypalCfg = $paypal ?? ['enabled' => false];
    @endphp
    <script>
    (() => {
        const key = 'cms_landing_cart_v1';
        const paypalCfg = @json($paypalCfg);
        const form = document.getElementById('cmsCheckoutForm');
        const payload = document.getElementById('cartPayload');
        const methodInput = document.getElementById('paymentMethod');
        const refInput = document.getElementById('paymentReference');
        const list = document.getElementById('checkoutCartList');
        const qty = document.getElementById('checkoutQty');
        const total = document.getElementById('checkoutTotal');
        const gxCount = document.getElementById('gxCartCount');
        const notice = document.getElementById('checkoutNotice');
        const submit = document.getElementById('checkoutSubmit');
        const paypalWrap = document.getElementById('paypal-buttons');

        const money = v => `${Number(v || 0).toLocaleString('fr-CA', {minimumFractionDigits: 2, maximumFractionDigits: 2})} $`;
        const esc = v => String(v || '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]));
        const read = () => {
            try {
                const parsed = JSON.parse(localStorage.getItem(key) || '{"items":[]}');
                return {items: Array.isArray(parsed.items) ? parsed.items : []};
            } catch (e) { return {items: []}; }
        };
        const cartTotal = cart => cart.items.reduce((s, it) => s + Number(it.price || 0) * Number(it.quantity || 0), 0);
        const render = () => {
            const cart = read();
            const totalQty = cart.items.reduce((s, it) => s + Number(it.quantity || 0), 0);
            payload.value = JSON.stringify(cart);
            qty.textContent = totalQty;
            if (gxCount) gxCount.textContent = totalQty;
            total.textContent = money(cartTotal(cart));
            if (!cart.items.length) {
                list.innerHTML = '<div class="cart-empty">Votre panier est vide. Revenez sur un site établissement pour ajouter des produits.</div>';
                return;
            }
            list.innerHTML = cart.items.map(it => `
                <article class="cart-row">
                    <img src="${esc(it.image || 'https://images.pexels.com/photos/3184465/pexels-photo-3184465.jpeg?auto=compress&cs=tinysrgb&w=300')}" alt="">
                    <div>
                        <div class="cart-name">${esc(it.name)}</div>
                        <div class="cart-meta">${esc(it.etablissement_name || 'Établissement')} · Quantité ${Number(it.quantity || 1)}</div>
                    </div>
                    <div class="cart-price">${money(Number(it.price || 0) * Number(it.quantity || 1))}</div>
                </article>
            `).join('');
        };
        const showNotice = (type, text) => { notice.className = `notice ${type}`; notice.textContent = text; };

        // Envoi de la commande vers le serveur (COD ou après capture PayPal)
        const submitOrder = async (method, reference) => {
            const cart = read();
            if (!cart.items.length) { showNotice('err', 'Votre panier est vide.'); return false; }
            payload.value = JSON.stringify(cart);
            methodInput.value = method;
            refInput.value = reference || '';
            submit.disabled = true;
            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'},
                    body: new FormData(form),
                });
                const data = await res.json();
                if (!res.ok || !data.success) { showNotice('err', data.message || 'Merci de vérifier les informations.'); return false; }
                localStorage.removeItem(key);
                render();
                showNotice('ok', `Commande confirmée ✓ Référence : ${data.reference}`);
                form.reset();
                return true;
            } catch (e) {
                showNotice('err', "Impossible d'envoyer la commande pour le moment.");
                return false;
            } finally {
                submit.disabled = false;
            }
        };

        // Soumission classique = paiement à la livraison
        form.addEventListener('submit', event => {
            event.preventDefault();
            submitOrder('cod', '');
        });

        // ===== Sélecteur de mode de paiement =====
        const opts = document.querySelectorAll('[data-pay-opt]');
        const setMethod = choice => {
            opts.forEach(o => o.classList.toggle('is-active', o.dataset.payOpt === choice));
            const isPaypal = choice === 'paypal';
            submit.style.display = isPaypal ? 'none' : '';
            paypalWrap.style.display = isPaypal ? 'block' : 'none';
            if (isPaypal) renderPayPal();
        };
        document.querySelectorAll('input[name="pay_choice"]').forEach(r => {
            r.addEventListener('change', () => setMethod(r.value));
        });

        // ===== PayPal (chargé uniquement si activé + configuré) =====
        let paypalRendered = false, paypalLoading = false;
        const loadPayPalSdk = () => new Promise((resolve, reject) => {
            if (window.paypal) return resolve();
            const s = document.createElement('script');
            const cur = encodeURIComponent(paypalCfg.currency || 'CAD');
            s.src = `https://www.paypal.com/sdk/js?client-id=${encodeURIComponent(paypalCfg.client_id)}&currency=${cur}&intent=capture`;
            s.onload = resolve; s.onerror = reject;
            document.head.appendChild(s);
        });
        const renderPayPal = async () => {
            if (!paypalCfg.enabled || paypalRendered || paypalLoading) return;
            paypalLoading = true;
            try {
                await loadPayPalSdk();
                paypal.Buttons({
                    style: {layout: 'vertical', color: 'gold', shape: 'pill', label: 'paypal'},
                    onClick: (data, actions) => {
                        // Valider le formulaire et le panier avant d'ouvrir PayPal
                        if (!read().items.length) { showNotice('err', 'Votre panier est vide.'); return actions.reject(); }
                        if (!form.reportValidity()) return actions.reject();
                        return actions.resolve();
                    },
                    createOrder: (data, actions) => actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: cartTotal(read()).toFixed(2),
                                currency_code: paypalCfg.currency || 'CAD'
                            }
                        }]
                    }),
                    onApprove: (data, actions) => actions.order.capture().then(details => {
                        const ref = (details && details.id) ? details.id : (data.orderID || 'PAYPAL');
                        return submitOrder('paypal', ref);
                    }),
                    onError: () => showNotice('err', 'Le paiement PayPal a échoué. Réessayez ou choisissez le paiement à la livraison.')
                }).render('#paypal-buttons');
                paypalRendered = true;
            } catch (e) {
                showNotice('err', 'PayPal indisponible pour le moment.');
            } finally {
                paypalLoading = false;
            }
        };

        window.addEventListener('storage', e => { if (e.key === key) render(); });
        render();
    })();
    </script>
</body>
</html>
