<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lac Azur Signature - Chalet a louer | GoExploria</title>
    <meta name="description" content="Chalet Lac Azur Signature: page detail complete avec galerie, equipements, disponibilite, tarifs et contact proprietaire.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f1f5f9; color: #0f172a; }
        .header { background: linear-gradient(120deg, #0c4a6e, #0e7490); color: #fff; border-bottom: 1px solid rgba(255,255,255,.14); }
        .header-inner { max-width: 1220px; margin: 0 auto; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; gap: 12px; }
        .brand { display: inline-flex; align-items: center; gap: 10px; color: #fff; text-decoration: none; }
        .brand img { height: 58px; width: auto; }
        .brand span { display: block; font-size: 11px; opacity: .9; }
        .brand b { font-size: 14px; }
        .nav a { text-decoration: none; color: #ecfeff; font-size: 12px; font-weight: 700; margin-left: 8px; padding: 8px 12px; border-radius: 999px; border: 1px solid rgba(255,255,255,.2); }
        .nav a.active { background: rgba(255,255,255,.18); }
        .wrap { max-width: 1220px; margin: 0 auto; padding: 28px 18px 60px; }
        .crumbs { font-size: 12px; color: #64748b; margin-bottom: 12px; }
        .crumbs a { color: #334155; text-decoration: none; }
        .hero { background: #0f172a; color: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 18px 46px rgba(15,23,42,.25); margin-bottom: 22px; }
        .hero-grid { display: grid; grid-template-columns: 1.1fr .9fr; }
        .hero-main { position: relative; min-height: 420px; }
        .hero-main img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(2,6,23,.9), rgba(2,6,23,.2)); display: flex; align-items: end; padding: 22px; }
        .badge { display: inline-flex; gap: 8px; align-items: center; padding: 7px 12px; border-radius: 999px; border: 1px solid rgba(56,189,248,.6); background: rgba(14,116,144,.35); font-size: 11px; font-weight: 800; }
        .title { margin-top: 10px; font-size: clamp(1.45rem, 2.1vw, 2.1rem); font-weight: 800; }
        .sub { margin-top: 8px; font-size: 13px; line-height: 1.7; color: rgba(255,255,255,.85); max-width: 620px; }
        .hero-side { padding: 24px; display: flex; flex-direction: column; gap: 14px; justify-content: center; }
        .price { background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.18); border-radius: 14px; padding: 16px; }
        .price-main { font-size: 1.6rem; font-weight: 900; color: #67e8f9; }
        .price-note { font-size: 12px; margin-top: 6px; color: rgba(255,255,255,.76); }
        .stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 9px; }
        .stat { background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.14); border-radius: 10px; padding: 10px; font-size: 12px; }
        .stat b { display: block; margin-top: 4px; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn { text-decoration: none; display: inline-flex; align-items: center; gap: 8px; border-radius: 9px; padding: 10px 13px; font-size: 12px; font-weight: 800; }
        .btn-main { background: #06b6d4; color: #06202a; }
        .btn-sub { border: 1px solid rgba(255,255,255,.2); color: #fff; background: rgba(255,255,255,.08); }
        .gallery { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 10px; margin-bottom: 22px; }
        .g { border-radius: 12px; overflow: hidden; min-height: 128px; }
        .g img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .g.main { grid-row: span 2; min-height: 270px; }
        .content { display: grid; grid-template-columns: 1.7fr .9fr; gap: 18px; }
        .card { background: #fff; border-radius: 14px; padding: 18px; box-shadow: 0 8px 24px rgba(15,23,42,.08); margin-bottom: 14px; }
        .card h2 { font-size: 1rem; margin-bottom: 9px; }
        .card p { font-size: 13px; color: #475569; line-height: 1.75; }
        .feature-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 9px; margin-top: 10px; }
        .feature { border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px; font-size: 12px; color: #334155; }
        .feature i { color: #0891b2; margin-right: 6px; }
        .list { list-style: none; display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px 16px; }
        .list li { font-size: 12px; color: #334155; }
        .list i { color: #16a34a; margin-right: 7px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { text-align: left; padding: 9px 7px; border-bottom: 1px solid #e2e8f0; font-size: 12px; }
        .table th { text-transform: uppercase; letter-spacing: .4px; font-size: 10px; color: #64748b; }
        .tag { border-radius: 999px; padding: 3px 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
        .tag-green { background: #ecfdf5; color: #047857; }
        .tag-amber { background: #fffbeb; color: #b45309; }
        .sticky { position: sticky; top: 12px; }
        .owner { display: flex; gap: 10px; align-items: center; margin-bottom: 10px; }
        .owner img { width: 54px; height: 54px; border-radius: 50%; object-fit: cover; }
        .owner h3 { font-size: 14px; }
        .owner p, .mini { font-size: 11px; color: #64748b; }
        .contact .f { margin-bottom: 9px; }
        .contact input, .contact textarea { width: 100%; border: 1px solid #cbd5e1; border-radius: 9px; padding: 10px 11px; font-family: inherit; font-size: 12px; }
        .contact textarea { min-height: 90px; resize: vertical; }
        .contact button { width: 100%; border: 0; cursor: pointer; }
        .footer { background: #0f172a; color: rgba(255,255,255,.82); margin-top: 16px; }
        .footer-inner { max-width: 1220px; margin: 0 auto; padding: 24px 18px; display: grid; grid-template-columns: 1.4fr 1fr 1fr; gap: 14px; }
        .footer h4 { color: #67e8f9; font-size: 12px; margin-bottom: 8px; text-transform: uppercase; }
        .footer p, .footer a { font-size: 12px; color: rgba(255,255,255,.82); text-decoration: none; line-height: 1.7; }
        .copy { border-top: 1px solid rgba(255,255,255,.13); text-align: center; font-size: 11px; padding: 11px 18px 14px; color: rgba(255,255,255,.68); }
        @media (max-width: 1020px) { .hero-grid, .content, .footer-inner { grid-template-columns: 1fr; } .gallery { grid-template-columns: 1fr 1fr; } .g.main { grid-column: span 2; } }
        @media (max-width: 720px) { .feature-grid, .list, .gallery { grid-template-columns: 1fr; } .g.main { grid-column: auto; } .header-inner { flex-direction: column; align-items: flex-start; } }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-inner">
            <a href="{{ route('home-v2') }}" class="brand">
                <img src="{{ asset('logo.png') }}" alt="GoExploria">
                <div><span>Collection prestige</span><b>Lac Azur Signature</b></div>
            </a>
            <nav class="nav">
                <a href="#contact-proprio" class="active">Contact</a>
                <a href="{{ route('pages.chalet-rental-detail') }}">Grande Serenite</a>
            </nav>
        </div>
    </header>

    <main class="wrap">
        <div class="crumbs"><a href="{{ route('home-v2') }}">Accueil</a> / <a href="#">Chalets a louer</a> / <span>Lac Azur Signature</span></div>

        <section class="hero">
            <div class="hero-grid">
                <div class="hero-main">
                    <img src="https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=1600&auto=format&fit=crop&q=80" alt="Lac Azur Signature">
                    <div class="overlay">
                        <div>
                            <span class="badge"><i class="fas fa-water"></i> Bord de lac - Estrie, Quebec</span>
                            <h1 class="title">Lac Azur Signature - Chalet architectural</h1>
                            <p class="sub">Un design contemporain vitrine avec grandes baies, spa exterieur, salon panoramique et ambiance premium pour sejours familles et groupes.</p>
                        </div>
                    </div>
                </div>
                <aside class="hero-side">
                    <div class="price">
                        <div class="price-main">720$ - 790$ / nuit</div>
                        <div class="price-note">1590$ - 1890$ / fin de semaine • 4390$ / semaine</div>
                    </div>
                    <div class="stats">
                        <div class="stat"><i class="fas fa-users"></i><b>12 personnes</b></div>
                        <div class="stat"><i class="fas fa-bed"></i><b>5 chambres</b></div>
                        <div class="stat"><i class="fas fa-bath"></i><b>3 salles de bain</b></div>
                        <div class="stat"><i class="fas fa-spa"></i><b>Spa 4 saisons</b></div>
                    </div>
                    <div class="actions">
                        <a href="#contact-proprio" class="btn btn-main"><i class="fas fa-paper-plane"></i> Contacter</a>
                        <a href="#" class="btn btn-sub"><i class="fas fa-video"></i> Visite video</a>
                    </div>
                </aside>
            </div>
        </section>

        <section class="gallery">
            <div class="g main"><img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=1400&auto=format&fit=crop&q=80" alt="Salon panoramique"></div>
            <div class="g"><img src="https://images.unsplash.com/photo-1484154218962-a197022b5858?w=900&auto=format&fit=crop&q=80" alt="Cuisine moderne"></div>
            <div class="g"><img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=900&auto=format&fit=crop&q=80" alt="Suite"></div>
            <div class="g"><img src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=900&auto=format&fit=crop&q=80" alt="Facade"></div>
            <div class="g"><img src="https://images.unsplash.com/photo-1470246973918-29a93221c455?w=900&auto=format&fit=crop&q=80" alt="Vue lac"></div>
        </section>

        <section class="content">
            <div>
                <article class="card">
                    <h2>Description generale</h2>
                    <p>Ce chalet combine confort hotelier, design scandinave et immersion nature. Le rez-de-chaussee offre un espace ouvert avec foyer central, cuisine chef et salle a manger conviviale.</p>
                    <div class="feature-grid">
                        <div class="feature"><i class="fas fa-wifi"></i> Fibre haute vitesse</div>
                        <div class="feature"><i class="fas fa-fire"></i> Foyer design</div>
                        <div class="feature"><i class="fas fa-snowflake"></i> Climatisation</div>
                        <div class="feature"><i class="fas fa-tree"></i> Terrain boise</div>
                        <div class="feature"><i class="fas fa-ship"></i> Quai prive</div>
                        <div class="feature"><i class="fas fa-ban-smoking"></i> Non-fumeur</div>
                    </div>
                </article>
                <article class="card">
                    <h2>Commodites et equipements</h2>
                    <ul class="list">
                        <li><i class="fas fa-check-circle"></i>4 lits Queen + 4 lits simples</li>
                        <li><i class="fas fa-check-circle"></i>Cuisine complete et cave a vin</li>
                        <li><i class="fas fa-check-circle"></i>Spa exterieur et terrasse chauffe</li>
                        <li><i class="fas fa-check-circle"></i>Kayaks et paddle boards inclus</li>
                        <li><i class="fas fa-check-circle"></i>Machine espresso pro</li>
                        <li><i class="fas fa-check-circle"></i>Stationnement 6 vehicules</li>
                    </ul>
                </article>
                <article class="card">
                    <h2>Disponibilite</h2>
                    <table class="table">
                        <thead><tr><th>Periode</th><th>Statut</th><th>Duree min.</th></tr></thead>
                        <tbody>
                            <tr><td>10 mai 2026 - 27 mai 2026</td><td><span class="tag tag-green">Disponible</span></td><td>2 nuits</td></tr>
                            <tr><td>1 juin 2026 - 20 juin 2026</td><td><span class="tag tag-amber">Tres demande</span></td><td>3 nuits</td></tr>
                            <tr><td>1 juil. 2026 - 5 sept. 2026</td><td><span class="tag tag-amber">Haute saison</span></td><td>7 nuits</td></tr>
                        </tbody>
                    </table>
                </article>
            </div>
            <aside class="sticky">
                <article class="card">
                    <div class="owner">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=250&auto=format&fit=crop&q=80" alt="Proprietaire">
                        <div>
                            <h3>Marie-Claire</h3>
                            <p>Membre depuis 2016</p>
                            <div class="mini">Taux de reponse: 100%</div>
                        </div>
                    </div>
                    <p class="mini"><i class="fas fa-language"></i> Langues: Francais, Anglais</p>
                </article>
                <article class="card" id="contact-proprio">
                    <h2>Contacter le proprietaire</h2>
                    <form class="contact">
                        <div class="f"><input type="text" placeholder="Prenom"></div>
                        <div class="f"><input type="text" placeholder="Nom"></div>
                        <div class="f"><input type="email" placeholder="Courriel"></div>
                        <div class="f"><input type="tel" placeholder="Telephone"></div>
                        <div class="f"><textarea placeholder="Message"></textarea></div>
                        <button type="button" class="btn btn-main"><i class="fas fa-paper-plane"></i> Envoyer la demande</button>
                    </form>
                </article>
            </aside>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-inner">
            <div>
                <h4>A propos</h4>
                <p>Lac Azur Signature est un chalet premium pense pour les sejours haut de gamme en toute saison.</p>
            </div>
            <div>
                <h4>Infos location</h4>
                <p>Capacite: 12 personnes</p>
                <p>5 chambres • 3 salles de bain</p>
                <p>Arrivee: 17:00 • Depart: 11:00</p>
            </div>
            <div>
                <h4>Liens utiles</h4>
                <p><a href="#contact-proprio">Contacter le proprietaire</a></p>
                <p><a href="{{ route('home-v2') }}">Retour accueil</a></p>
                <p><a href="{{ route('pages.chalet-rental-detail') }}">Voir Grande Serenite</a></p>
            </div>
        </div>
        <div class="copy">GoExploria - Page detail chalet Lac Azur Signature</div>
    </footer>
</body>
</html>
