{{--
    Habillage commun à la boutique et à la fiche produit.

    Repris de la charte du tunnel d'achat (checkout.blade.php) pour que le
    parcours produit → panier → paiement → confirmation reste d'un seul tenant.
--}}
@once
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
    :root{--ink:#0b1220;--muted:#64748b;--line:#e6e9f0;--gold:#f5c542;--bg:#f4f6fb;--ok:#047857;--radius:18px}
    *{box-sizing:border-box}
    body{margin:0;background:var(--bg);color:var(--ink);font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif;line-height:1.6}
    a{color:inherit;text-decoration:none}
    img{max-width:100%;display:block}
    .shop-wrap{max-width:1180px;margin:34px auto 70px;padding:0 24px}
    .shop-crumb{font-size:14px;color:var(--muted);margin-bottom:14px}
    .shop-crumb a:hover{color:var(--ink)}
    .shop-head{margin-bottom:26px}
    .shop-kicker{font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#d19213;font-weight:900}
    .shop-title{font-size:clamp(28px,5vw,46px);line-height:1.06;margin:8px 0 10px}
    .shop-sub{color:var(--muted);max-width:720px}

    /* ===== Recherche ===== */
    .shop-search{display:flex;flex-wrap:wrap;gap:10px;align-items:center;margin-bottom:18px}
    .shop-search-field{position:relative;flex:1 1 320px}
    .shop-search-field i{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:14px;pointer-events:none}
    .shop-search-field input{width:100%;border:1px solid var(--line);border-radius:999px;background:#fff;padding:13px 18px 13px 42px;font:inherit;font-size:15px}
    .shop-search-field input:focus{outline:none;border-color:var(--gold);box-shadow:0 0 0 3px rgba(245,197,66,.25)}
    .shop-search-field input::-webkit-search-cancel-button{cursor:pointer}
    .shop-search-btn{border:0;border-radius:999px;background:var(--ink);color:#fff;font-weight:800;font-size:14px;padding:13px 24px;cursor:pointer}
    .shop-search-btn:hover{filter:brightness(1.15)}
    .shop-search-clear{font-size:14px;font-weight:700;color:var(--muted);text-decoration:underline}

    /* ===== Filtres par rayon ===== */
    .shop-filters{display:flex;flex-wrap:wrap;gap:9px;margin-bottom:24px}
    .shop-filter{display:inline-flex;align-items:center;gap:7px;background:#fff;border:1px solid var(--line);border-radius:999px;padding:9px 16px;font-size:14px;font-weight:700;transition:.18s}
    .shop-filter:hover{border-color:#cbd5e1}
    .shop-filter.is-active{background:var(--ink);border-color:var(--ink);color:#fff}
    .shop-filter span{font-size:11px;font-weight:800;background:#eef2f7;color:#475569;border-radius:999px;padding:2px 7px}
    .shop-filter.is-active span{background:rgba(255,255,255,.22);color:#fff}

    /* ===== Grille produits ===== */
    .shop-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:22px}
    .shop-card{display:flex;flex-direction:column;background:#fff;border:1px solid var(--line);border-radius:var(--radius);overflow:hidden;box-shadow:0 14px 35px rgba(15,23,42,.06);transition:transform .22s ease,box-shadow .22s ease}
    .shop-card:hover{transform:translateY(-5px);box-shadow:0 24px 55px rgba(15,23,42,.12)}
    .shop-card-media{position:relative;aspect-ratio:4/3;overflow:hidden;background:#eef2f7}
    .shop-card-media img{width:100%;height:100%;object-fit:cover;transition:transform .5s ease}
    .shop-card:hover .shop-card-media img{transform:scale(1.06)}
    .shop-card-tag{position:absolute;top:12px;left:12px;background:var(--gold);color:#111827;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.05em;padding:5px 11px;border-radius:999px;pointer-events:none}
    .shop-card-body{display:flex;flex-direction:column;gap:6px;padding:18px;flex:1}
    .shop-card-cat{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:var(--ok)}
    .shop-card-name{font-size:17px;font-weight:800;margin:0}
    .shop-card-desc{font-size:14px;color:var(--muted);margin:0}
    .shop-card-foot{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-top:auto;padding-top:14px}
    .shop-price{font-size:20px;font-weight:900}
    .shop-price small{font-size:12px;color:var(--muted);font-weight:600}
    .shop-add{border:0;border-radius:12px;background:var(--gold);color:#111827;font-weight:900;padding:11px 16px;cursor:pointer;font-size:14px}
    .shop-add:hover{filter:brightness(.96)}
    .shop-add[disabled]{background:#e2e8f0;color:var(--muted);cursor:not-allowed}
    .shop-quote{font-size:13px;font-weight:800;color:var(--ok)}
    .shop-empty{background:#fff;border:1px dashed var(--line);border-radius:var(--radius);padding:56px 24px;text-align:center;color:var(--muted)}

    /* ===== Fiche produit ===== */
    .product-grid{display:grid;grid-template-columns:minmax(0,1.05fr) minmax(0,.95fr);gap:36px;align-items:start}
    .product-media{background:#fff;border:1px solid var(--line);border-radius:24px;overflow:hidden;box-shadow:0 18px 48px rgba(15,23,42,.07)}
    .product-media img{width:100%;aspect-ratio:4/3;object-fit:cover}
    .product-thumbs{display:grid;grid-template-columns:repeat(auto-fill,minmax(84px,1fr));gap:10px;margin-top:12px}
    .product-thumbs button{padding:0;border:2px solid transparent;border-radius:12px;overflow:hidden;background:none;cursor:pointer}
    .product-thumbs button.is-active{border-color:var(--gold)}
    .product-thumbs img{aspect-ratio:1;object-fit:cover}
    .product-panel{background:#fff;border:1px solid var(--line);border-radius:24px;box-shadow:0 18px 48px rgba(15,23,42,.07);padding:28px}
    .product-name{font-size:clamp(24px,3.4vw,34px);line-height:1.12;margin:6px 0 12px}
    .product-price{font-size:32px;font-weight:900;margin:14px 0 4px}
    .product-price small{font-size:14px;color:var(--muted);font-weight:600}
    .product-tax{font-size:13px;color:var(--muted)}
    .product-desc{color:#334155;margin:18px 0}
    .product-meta{display:grid;gap:8px;margin:18px 0;padding:16px;background:#f8fafc;border:1px solid var(--line);border-radius:14px;font-size:14px}
    .product-meta div{display:flex;justify-content:space-between;gap:16px}
    .product-meta span:first-child{color:var(--muted)}
    .product-buy{display:flex;flex-wrap:wrap;gap:12px;align-items:center;margin-top:20px}
    .qty{display:inline-flex;align-items:center;border:1px solid var(--line);border-radius:999px;overflow:hidden;background:#fbfcfe}
    .qty button{width:42px;height:46px;border:0;background:transparent;font-size:18px;cursor:pointer;color:var(--ink)}
    .qty input{width:52px;height:46px;border:0;text-align:center;font:inherit;font-weight:900;background:transparent;-moz-appearance:textfield}
    .qty input::-webkit-outer-spin-button,.qty input::-webkit-inner-spin-button{-webkit-appearance:none;margin:0}
    .product-buy .shop-add{flex:1 1 200px;padding:15px 22px;font-size:16px;border-radius:14px}
    .product-note{margin-top:14px;font-size:13px;color:var(--muted)}
    .product-section-title{font-size:20px;font-weight:900;margin:44px 0 18px}
    @media(max-width:860px){.product-grid{grid-template-columns:1fr;gap:24px}}
</style>
@endonce
