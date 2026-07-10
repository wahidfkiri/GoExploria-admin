<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eclipse Forestier - Maison chalet | GoExploria</title>
    <meta name="description" content="Maison chalet Eclipse Forestier: page moderne complete avec sections detail, galerie, atouts, tarification et contact.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Manrope', sans-serif; background: #020617; color: #e2e8f0; }
        .header { background: linear-gradient(125deg, #111827, #1f2937); border-bottom: 1px solid rgba(148,163,184,.24); }
        .header-inner { max-width: 1220px; margin: 0 auto; padding: 14px 18px; display: flex; justify-content: space-between; align-items: center; }
        .brand { color: #f8fafc; text-decoration: none; display: inline-flex; gap: 10px; align-items: center; }
        .brand img { height: 54px; width: auto; }
        .brand span { display: block; font-size: 11px; color: #94a3b8; }
        .brand b { font-size: 14px; }
        .nav a { text-decoration: none; color: #e2e8f0; font-size: 12px; font-weight: 700; margin-left: 7px; padding: 8px 11px; border-radius: 999px; border: 1px solid rgba(148,163,184,.26); }
        .nav a.active { background: rgba(34,197,94,.16); border-color: rgba(34,197,94,.4); color: #86efac; }
        .wrap { max-width: 1220px; margin: 0 auto; padding: 28px 18px 58px; }
        .crumbs { margin-bottom: 12px; color: #94a3b8; font-size: 12px; }
        .crumbs a { color: #cbd5e1; text-decoration: none; }
        .hero { border-radius: 18px; overflow: hidden; border: 1px solid rgba(148,163,184,.2); background: #0f172a; margin-bottom: 20px; }
        .hero-grid { display: grid; grid-template-columns: 1.05fr .95fr; }
        .hero-main { position: relative; min-height: 420px; }
        .hero-main img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(2,6,23,.95), rgba(2,6,23,.25)); display: flex; align-items: end; padding: 20px; }
        .badge { display: inline-flex; align-items: center; gap: 7px; border-radius: 999px; padding: 7px 11px; font-size: 11px; font-weight: 800; background: rgba(34,197,94,.16); border: 1px solid rgba(34,197,94,.38); color: #86efac; }
        .title { margin-top: 10px; font-size: clamp(1.45rem, 2vw, 2.05rem); line-height: 1.2; }
        .sub { margin-top: 8px; max-width: 620px; font-size: 13px; line-height: 1.7; color: #cbd5e1; }
        .hero-side { padding: 22px; display: flex; flex-direction: column; justify-content: center; gap: 13px; }
        .price { background: rgba(30,41,59,.7); border: 1px solid rgba(148,163,184,.23); border-radius: 12px; padding: 14px; }
        .price-main { color: #86efac; font-size: 1.55rem; font-weight: 900; }
        .price-note { font-size: 12px; color: #94a3b8; margin-top: 6px; }
        .stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; }
        .stat { background: rgba(15,23,42,.6); border: 1px solid rgba(148,163,184,.2); border-radius: 10px; font-size: 12px; padding: 10px; }
        .stat b { display: block; margin-top: 4px; color: #f8fafc; }
        .actions { display: flex; flex-wrap: wrap; gap: 8px; }
        .btn { border-radius: 9px; padding: 10px 13px; text-decoration: none; font-size: 12px; font-weight: 800; display: inline-flex; align-items: center; gap: 8px; }
        .btn-main { background: #22c55e; color: #052e16; }
        .btn-sub { border: 1px solid rgba(148,163,184,.3); color: #f8fafc; background: rgba(148,163,184,.08); }
        .gallery { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 10px; margin-bottom: 20px; }
        .g { border-radius: 12px; overflow: hidden; min-height: 126px; }
        .g img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .g.main { grid-row: span 2; min-height: 265px; }
        .content { display: grid; grid-template-columns: 1.7fr .9fr; gap: 16px; }
        .card { background: #0f172a; border: 1px solid rgba(148,163,184,.2); border-radius: 13px; padding: 16px; margin-bottom: 12px; }
        .card h2 { font-size: 1rem; margin-bottom: 8px; color: #f8fafc; }
        .card p { font-size: 13px; line-height: 1.75; color: #cbd5e1; }
        .feature-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-top: 10px; }
        .feature { border-radius: 10px; border: 1px solid rgba(148,163,184,.24); padding: 10px; font-size: 12px; color: #cbd5e1; background: rgba(15,23,42,.65); }
        .feature i { color: #86efac; margin-right: 6px; }
        .list { list-style: none; display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px 16px; }
        .list li { font-size: 12px; color: #cbd5e1; }
        .list i { color: #22c55e; margin-right: 7px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { text-align: left; padding: 8px 7px; border-bottom: 1px solid rgba(148,163,184,.18); font-size: 12px; color: #cbd5e1; }
        .table th { font-size: 10px; text-transform: uppercase; letter-spacing: .4px; color: #94a3b8; }
        .tag { border-radius: 999px; font-size: 10px; padding: 3px 8px; font-weight: 700; text-transform: uppercase; }
        .tag-green { background: rgba(34,197,94,.16); color: #86efac; }
        .tag-amber { background: rgba(245,158,11,.16); color: #fcd34d; }
        .sticky { position: sticky; top: 12px; }
        .owner { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .owner img { width: 52px; height: 52px; border-radius: 50%; object-fit: cover; }
        .owner h3 { font-size: 14px; color: #f8fafc; }
        .owner p, .mini { font-size: 11px; color: #94a3b8; }
        .contact .f { margin-bottom: 8px; }
        .contact input, .contact textarea { width: 100%; border: 1px solid rgba(148,163,184,.28); background: #020617; color: #e2e8f0; border-radius: 9px; padding: 10px; font-family: inherit; font-size: 12px; }
        .contact textarea { min-height: 88px; resize: vertical; }
        .contact button { width: 100%; border: 0; cursor: pointer; }
        .footer { background: #111827; color: #cbd5e1; border-top: 1px solid rgba(148,163,184,.18); margin-top: 16px; }
        .footer-inner { max-width: 1220px; margin: 0 auto; padding: 22px 18px; display: grid; grid-template-columns: 1.4fr 1fr 1fr; gap: 14px; }
        .footer h4 { font-size: 12px; color: #86efac; text-transform: uppercase; margin-bottom: 8px; }
        .footer p, .footer a { font-size: 12px; color: #cbd5e1; text-decoration: none; line-height: 1.7; }
        .copy { border-top: 1px solid rgba(148,163,184,.2); text-align: center; font-size: 11px; padding: 10px 18px 13px; color: #94a3b8; }
        @media (max-width: 1020px) { .hero-grid, .content, .footer-inner { grid-template-columns: 1fr; } .gallery { grid-template-columns: 1fr 1fr; } .g.main { grid-column: span 2; } }
        @media (max-width: 720px) { .feature-grid, .list, .gallery { grid-template-columns: 1fr; } .g.main { grid-column: auto; } .header-inner { flex-direction: column; align-items: flex-start; gap: 10px; } }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-inner">
            <a href="{{ route('home-v2') }}" class="brand">
                <img src="{{ asset('logo.png') }}" alt="GoExploria">
                <div><span>Collection investissement</span><b>Eclipse Forestier</b></div>
            </a>
            <nav class="nav">
                <a href="#contact-proprio" class="active">Contact</a>
                <a href="{{ route('pages.projet-touristique-boreal') }}">Projet Boreal</a>
            </nav>
        </div>
    </header>

    <main class="wrap">
        <div class="crumbs"><a href="{{ route('home-v2') }}">Accueil</a> / <a href="#">Maisons chalets</a> / <span>Eclipse Forestier</span></div>

        <section class="hero">
            <div class="hero-grid">
                <div class="hero-main">
                    <img src="https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=1600&auto=format&fit=crop&q=80" alt="Eclipse Forestier">
                    <div class="overlay">
                        <div>
                            <span class="badge"><i class="fas fa-tree"></i> Laurentides - Quebec</span>
                            <h1 class="title">Eclipse Forestier - Maison chalet premium</h1>
                            <p class="sub">Propriete contemporaine avec fenestration pleine hauteur, suite parentale et fort potentiel pour location courte duree.</p>
                        </div>
                    </div>
                </div>
                <aside class="hero-side">
                    <div class="price">
                        <div class="price-main">510 000 CAD</div>
                        <div class="price-note">Rendement locatif cible: 8.5% - 10.2%</div>
                    </div>
                    <div class="stats">
                        <div class="stat"><i class="fas fa-ruler-combined"></i><b>175 m2</b></div>
                        <div class="stat"><i class="fas fa-bed"></i><b>4 chambres</b></div>
                        <div class="stat"><i class="fas fa-car"></i><b>Garage double</b></div>
                        <div class="stat"><i class="fas fa-mountain"></i><b>Vue montagne</b></div>
                    </div>
                    <div class="actions">
                        <a href="#contact-proprio" class="btn btn-main"><i class="fas fa-file-signature"></i> Recevoir dossier</a>
                        <a href="#" class="btn btn-sub"><i class="fas fa-chart-line"></i> Projection ROI</a>
                    </div>
                </aside>
            </div>
        </section>

        <section class="gallery">
            <div class="g main"><img src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=1400&auto=format&fit=crop&q=80" alt="Facade principale"></div>
            <div class="g"><img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=900&auto=format&fit=crop&q=80" alt="Salon"></div>
            <div class="g"><img src="https://images.unsplash.com/photo-1484154218962-a197022b5858?w=900&auto=format&fit=crop&q=80" alt="Cuisine"></div>
            <div class="g"><img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=900&auto=format&fit=crop&q=80" alt="Chambre"></div>
            <div class="g"><img src="https://images.unsplash.com/photo-1493666438817-866a91353ca9?w=900&auto=format&fit=crop&q=80" alt="Bureau"></div>
        </section>

        <section class="content">
            <div>
                <article class="card">
                    <h2>Description generale</h2>
                    <p>Eclipse Forestier se distingue par son architecture epuree et ses volumes lumineux. La maison est prete a habiter ou exploiter en location premium avec une configuration ideale pour familles.</p>
                    <div class="feature-grid">
                        <div class="feature"><i class="fas fa-wifi"></i> Fibre optique</div>
                        <div class="feature"><i class="fas fa-fire"></i> Foyer central</div>
                        <div class="feature"><i class="fas fa-home"></i> Domotique</div>
                        <div class="feature"><i class="fas fa-shield-alt"></i> Securite integree</div>
                        <div class="feature"><i class="fas fa-solar-panel"></i> Pre-equipe solaire</div>
                        <div class="feature"><i class="fas fa-snowflake"></i> Thermopompe</div>
                    </div>
                </article>
                <article class="card">
                    <h2>Equipements et points forts</h2>
                    <ul class="list">
                        <li><i class="fas fa-check-circle"></i>Suite parentale avec dressing</li>
                        <li><i class="fas fa-check-circle"></i>Cuisine haut de gamme et ilot</li>
                        <li><i class="fas fa-check-circle"></i>Salle cinema au sous-sol</li>
                        <li><i class="fas fa-check-circle"></i>Grandes terrasses bois</li>
                        <li><i class="fas fa-check-circle"></i>Espace feu exterieur</li>
                        <li><i class="fas fa-check-circle"></i>Terrain paysage prive</li>
                    </ul>
                </article>
                <article class="card">
                    <h2>Plan financier simplifie</h2>
                    <table class="table">
                        <thead><tr><th>Element</th><th>Valeur</th><th>Notes</th></tr></thead>
                        <tbody>
                            <tr><td>Prix de vente</td><td>510 000$</td><td><span class="tag tag-green">Actif</span></td></tr>
                            <tr><td>Revenu annuel cible</td><td>72 000$</td><td><span class="tag tag-amber">Projection</span></td></tr>
                            <tr><td>Taux occupation cible</td><td>64%</td><td><span class="tag tag-green">Stable</span></td></tr>
                        </tbody>
                    </table>
                </article>
            </div>
            <aside class="sticky">
                <article class="card">
                    <div class="owner">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=250&auto=format&fit=crop&q=80" alt="Conseiller">
                        <div>
                            <h3>Samuel Roy</h3>
                            <p>Conseiller investissement</p>
                            <div class="mini">Reponse moyenne: 2h</div>
                        </div>
                    </div>
                    <p class="mini"><i class="fas fa-language"></i> Langues: Francais, Anglais</p>
                </article>
                <article class="card" id="contact-proprio">
                    <h2>Demande d'information</h2>
                    <form class="contact">
                        <div class="f"><input type="text" placeholder="Prenom"></div>
                        <div class="f"><input type="text" placeholder="Nom"></div>
                        <div class="f"><input type="email" placeholder="Courriel"></div>
                        <div class="f"><input type="tel" placeholder="Telephone"></div>
                        <div class="f"><textarea placeholder="Votre projet ou question"></textarea></div>
                        <button type="button" class="btn btn-main"><i class="fas fa-paper-plane"></i> Envoyer</button>
                    </form>
                </article>
            </aside>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-inner">
            <div>
                <h4>A propos</h4>
                <p>Eclipse Forestier est une maison chalet prete pour usage prive et exploitation locative premium.</p>
            </div>
            <div>
                <h4>Infos cle</h4>
                <p>Surface: 175 m2</p>
                <p>4 chambres • Garage double</p>
                <p>Dossier financier disponible</p>
            </div>
            <div>
                <h4>Liens utiles</h4>
                <p><a href="#contact-proprio">Contacter le conseiller</a></p>
                <p><a href="{{ route('home-v2') }}">Retour accueil</a></p>
                <p><a href="{{ route('pages.projet-touristique-boreal') }}">Voir projet Boreal</a></p>
            </div>
        </div>
        <div class="copy">GoExploria - Page detail maison chalet Eclipse Forestier</div>
    </footer>
</body>
</html>
