{{--
    Confirmation d'achat.

    Une seule référence de panier peut avoir produit PLUSIEURS commandes — une
    par établissement — quand le panier mélangeait des produits de commerçants
    différents. La page les liste donc toutes, chacune avec son numéro : c'est
    ce numéro que le client devra citer, pas la référence du panier.
--}}
@php
    $devise = static fn ($v) => number_format((float) $v, 2, ',', ' ') . ' $';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande confirmée | GoExploria</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root{--ink:#0b1220;--muted:#64748b;--line:#e6e9f0;--gold:#f5c542;--bg:#f4f6fb;--ok:#047857;--radius:18px}
        *{box-sizing:border-box}
        body{margin:0;background:var(--bg);color:var(--ink);font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif;line-height:1.6}
        a{color:inherit;text-decoration:none}
        .wrap{max-width:820px;margin:44px auto;padding:0 24px}
        .card{background:#fff;border:1px solid var(--line);border-radius:var(--radius);box-shadow:0 18px 48px rgba(15,23,42,.07);padding:30px;margin-bottom:20px}
        .hero{text-align:center}
        .hero-ico{width:78px;height:78px;margin:0 auto 18px;border-radius:50%;display:grid;place-items:center;background:#ecfdf5;color:var(--ok);font-size:34px}
        .hero h1{margin:0 0 10px;font-size:clamp(26px,4vw,38px);line-height:1.1}
        .hero p{color:var(--muted);margin:0}
        .ref{display:inline-block;margin-top:16px;background:#f8fafc;border:1px dashed var(--line);border-radius:12px;padding:10px 18px;font-weight:900;letter-spacing:.04em}
        .order-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;border-bottom:1px solid var(--line);padding-bottom:14px;margin-bottom:16px}
        .order-num{font-weight:900;font-size:18px}
        .order-shop{color:var(--muted);font-size:14px}
        .badge{border-radius:999px;padding:6px 14px;font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.05em}
        .badge.paid{background:#ecfdf5;color:var(--ok)}
        .badge.pending{background:#fffbeb;color:#b45309}
        .line{display:grid;grid-template-columns:1fr auto;gap:14px;padding:11px 0;border-bottom:1px solid #f1f5f9}
        .line:last-of-type{border-bottom:0}
        .line-name{font-weight:700}
        .line-meta{color:var(--muted);font-size:13px}
        .line-total{font-weight:900;white-space:nowrap}
        .totals{display:grid;gap:8px;margin-top:16px;padding-top:16px;border-top:2px solid var(--line)}
        .totals div{display:flex;justify-content:space-between;gap:16px}
        .totals .grand{font-size:20px;font-weight:900}
        .totals .muted{color:var(--muted);font-size:14px}
        .actions{display:flex;flex-wrap:wrap;gap:12px;justify-content:center;margin-top:8px}
        .btn{border-radius:14px;padding:14px 24px;font-weight:900;border:1px solid var(--line);background:#fff}
        .btn.main{background:var(--gold);border-color:var(--gold);color:#111827}
        .next{display:grid;gap:10px;color:var(--muted);font-size:15px}
        .next li{margin-left:18px}
        @media print{.actions{display:none}}
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card hero">
            <div class="hero-ico"><i class="fa-solid fa-check"></i></div>
            <h1>Merci, votre commande est confirmée</h1>
            <p>Un récapitulatif vient d'être transmis
                @if ($commandes->count() > 1)
                    aux {{ $commandes->count() }} commerçants concernés.
                @else
                    au commerçant.
                @endif
            </p>
            <div class="ref">Référence : {{ $reference }}</div>
        </div>

        @foreach ($commandes as $commande)
            <div class="card">
                <div class="order-head">
                    <div>
                        <div class="order-num">Commande {{ $commande->order_number }}</div>
                        <div class="order-shop">{{ optional($commande->etablissement)->name ?: 'Établissement' }}</div>
                    </div>
                    @if ($commande->payment_status === 'paid')
                        <span class="badge paid">Payée</span>
                    @else
                        <span class="badge pending">Paiement à la livraison</span>
                    @endif
                </div>

                @foreach ($commande->items as $ligne)
                    <div class="line">
                        <div>
                            <div class="line-name">{{ $ligne->product_name }}</div>
                            <div class="line-meta">
                                {{ $ligne->quantity }} × {{ $devise($ligne->unit_price_ttc) }}
                                @if ($ligne->product_reference)
                                    · réf. {{ $ligne->product_reference }}
                                @endif
                            </div>
                        </div>
                        <div class="line-total">{{ $devise($ligne->line_total) }}</div>
                    </div>
                @endforeach

                <div class="totals">
                    @if ((float) $commande->tax_total > 0)
                        <div class="muted"><span>Sous-total hors taxes</span><span>{{ $devise($commande->subtotal_ht) }}</span></div>
                        <div class="muted"><span>Taxes</span><span>{{ $devise($commande->tax_total) }}</span></div>
                    @endif
                    <div class="grand"><span>Total</span><span>{{ $devise($commande->total) }}</span></div>
                </div>
            </div>
        @endforeach

        @if ($commandes->count() > 1)
            <div class="card">
                <div class="totals">
                    <div class="grand"><span>Total du panier</span><span>{{ $devise($total) }}</span></div>
                </div>
            </div>
        @endif

        <div class="card">
            <h2 style="margin:0 0 12px;font-size:18px">Et maintenant ?</h2>
            <ul class="next">
                <li>Le commerçant prépare votre commande et vous recontacte pour le retrait ou la livraison.</li>
                <li>Conservez {{ $commandes->count() > 1 ? 'les numéros de commande' : 'le numéro de commande' }} : c'est
                    {{ $commandes->count() > 1 ? 'eux' : 'lui' }} qui {{ $commandes->count() > 1 ? 'permettent' : 'permet' }}
                    de retrouver votre dossier.</li>
                @if ($commandes->contains(fn ($c) => $c->payment_status !== 'paid'))
                    <li>Le règlement se fera à la remise de la commande.</li>
                @endif
            </ul>
        </div>

        <div class="actions">
            <a class="btn main" href="{{ $boutiqueUrl }}">Retour à la boutique</a>
            <button class="btn" type="button" onclick="window.print()">Imprimer le reçu</button>
        </div>
    </div>

    {{-- Le panier a été transformé en commande : on le vide, sinon un retour en
         arrière le montrerait encore plein et inviterait à commander deux fois. --}}
    <script>
        try { localStorage.removeItem('cms_landing_cart_v1'); } catch (e) {}
    </script>
</body>
</html>
