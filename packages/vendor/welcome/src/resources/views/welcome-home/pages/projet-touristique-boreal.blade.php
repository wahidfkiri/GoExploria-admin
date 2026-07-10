<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halte Boreale - Projet touristique | GoExploria</title>
    <meta name="description" content="Projet touristique Halte Boreale: interface moderne complete avec toutes sections, vision business, KPI, roadmap et contact.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Sora', sans-serif; background: #fff7ed; color: #431407; }
        .header { background: linear-gradient(120deg, #9a3412, #c2410c); color: #fff; border-bottom: 1px solid rgba(255,255,255,.2); }
        .header-inner { max-width: 1220px; margin: 0 auto; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; }
        .brand { text-decoration: none; color: #fff; display: inline-flex; align-items: center; gap: 10px; }
        .brand img { height: 54px; width: auto; }
        .brand span { display: block; font-size: 11px; opacity: .86; }
        .brand b { font-size: 14px; }
        .nav a { text-decoration: none; color: #ffedd5; font-size: 12px; font-weight: 700; margin-left: 8px; border: 1px solid rgba(255,255,255,.25); padding: 8px 11px; border-radius: 999px; }
        .nav a.active { background: rgba(255,255,255,.18); }
        .wrap { max-width: 1220px; margin: 0 auto; padding: 28px 18px 58px; }
        .crumbs { margin-bottom: 12px; font-size: 12px; color: #9a3412; }
        .crumbs a { color: #7c2d12; text-decoration: none; }
        .hero { border-radius: 18px; overflow: hidden; background: #7c2d12; color: #fff; box-shadow: 0 16px 42px rgba(124,45,18,.3); margin-bottom: 20px; }
        .hero-grid { display: grid; grid-template-columns: 1.08fr .92fr; }
        .hero-main { position: relative; min-height: 420px; }
        .hero-main img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(67,20,7,.95), rgba(67,20,7,.2)); display: flex; align-items: end; padding: 20px; }
        .badge { display: inline-flex; align-items: center; gap: 7px; padding: 7px 11px; border-radius: 999px; background: rgba(251,146,60,.22); border: 1px solid rgba(251,146,60,.6); font-size: 11px; font-weight: 800; color: #ffedd5; }
        .title { margin-top: 10px; font-size: clamp(1.4rem, 2vw, 2rem); line-height: 1.2; }
        .sub { margin-top: 8px; font-size: 13px; line-height: 1.75; color: rgba(255,237,213,.9); max-width: 620px; }
        .hero-side { padding: 22px; display: flex; flex-direction: column; gap: 13px; justify-content: center; }
        .price { background: rgba(255,255,255,.09); border: 1px solid rgba(255,255,255,.2); border-radius: 12px; padding: 14px; }
        .price-main { font-size: 1.55rem; font-weight: 900; color: #fdba74; }
        .price-note { font-size: 12px; margin-top: 6px; color: rgba(255,237,213,.82); }
        .stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; }
        .stat { border-radius: 10px; padding: 10px; background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.16); font-size: 12px; }
        .stat b { display: block; margin-top: 4px; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn { display: inline-flex; align-items: center; gap: 8px; border-radius: 9px; padding: 10px 13px; text-decoration: none; font-size: 12px; font-weight: 800; }
        .btn-main { background: #fb923c; color: #431407; }
        .btn-sub { border: 1px solid rgba(255,255,255,.22); color: #fff; background: rgba(255,255,255,.08); }
        .gallery { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 10px; margin-bottom: 20px; }
        .g { border-radius: 12px; overflow: hidden; min-height: 128px; }
        .g img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .g.main { grid-row: span 2; min-height: 265px; }
        .content { display: grid; grid-template-columns: 1.7fr .9fr; gap: 16px; }
        .card { background: #fff; border-radius: 13px; border: 1px solid #fed7aa; box-shadow: 0 8px 22px rgba(154,52,18,.08); padding: 16px; margin-bottom: 12px; }
        .card h2 { font-size: 1rem; margin-bottom: 8px; color: #9a3412; }
        .card p { font-size: 13px; line-height: 1.75; color: #7c2d12; }
        .feature-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-top: 10px; }
        .feature { border: 1px solid #fed7aa; border-radius: 10px; padding: 10px; font-size: 12px; color: #7c2d12; background: #fff7ed; }
        .feature i { color: #ea580c; margin-right: 6px; }
        .list { list-style: none; display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px 16px; }
        .list li { font-size: 12px; color: #7c2d12; }
        .list i { color: #ea580c; margin-right: 7px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { text-align: left; padding: 8px 7px; border-bottom: 1px solid #fed7aa; font-size: 12px; color: #7c2d12; }
        .table th { font-size: 10px; color: #9a3412; text-transform: uppercase; letter-spacing: .4px; }
        .tag { border-radius: 999px; padding: 3px 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
        .tag-green { background: #ecfdf5; color: #047857; }
        .tag-amber { background: #fffbeb; color: #b45309; }
        .sticky { position: sticky; top: 12px; }
        .owner { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .owner img { width: 52px; height: 52px; border-radius: 50%; object-fit: cover; }
        .owner h3 { font-size: 14px; }
        .owner p, .mini { font-size: 11px; color: #9a3412; }
        .contact .f { margin-bottom: 8px; }
        .contact input, .contact textarea { width: 100%; border: 1px solid #fdba74; border-radius: 9px; padding: 10px; font-family: inherit; font-size: 12px; color: #7c2d12; background: #fff; }
        .contact textarea { min-height: 90px; resize: vertical; }
        .contact button { width: 100%; border: 0; cursor: pointer; }
        .footer { background: #7c2d12; color: #ffedd5; margin-top: 16px; }
        .footer-inner { max-width: 1220px; margin: 0 auto; padding: 22px 18px; display: grid; grid-template-columns: 1.4fr 1fr 1fr; gap: 14px; }
        .footer h4 { font-size: 12px; color: #fdba74; text-transform: uppercase; margin-bottom: 8px; }
        .footer p, .footer a { font-size: 12px; color: #ffedd5; text-decoration: none; line-height: 1.7; }
        .copy { border-top: 1px solid rgba(255,237,213,.2); text-align: center; font-size: 11px; padding: 10px 18px 13px; color: rgba(255,237,213,.78); }
        @media (max-width: 1020px) { .hero-grid, .content, .footer-inner { grid-template-columns: 1fr; } .gallery { grid-template-columns: 1fr 1fr; } .g.main { grid-column: span 2; } }
        @media (max-width: 720px) { .feature-grid, .list, .gallery { grid-template-columns: 1fr; } .g.main { grid-column: auto; } .header-inner { flex-direction: column; align-items: flex-start; gap: 10px; } }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-inner">
            <a href="{{ route('home-v2') }}" class="brand">
                <img src="{{ asset('logo.png') }}" alt="GoExploria">
                <div><span>Collection developpement</span><b>Halte Boreale</b></div>
            </a>
            <nav class="nav">
                <a href="#contact-proprio" class="active">Contact projet</a>
                <a href="{{ route('pages.maison-forestiere-eclipse') }}">Eclipse Forestier</a>
            </nav>
        </div>
    </header>

    <main class="wrap">
        <div class="crumbs"><a href="{{ route('home-v2') }}">Accueil</a> / <a href="#">Projets touristiques</a> / <span>Halte Boreale</span></div>

        <section class="hero">
            <div class="hero-grid">
                <div class="hero-main">
                    <img src="https://images.unsplash.com/photo-1487958449943-2429e8be8625?w=1600&auto=format&fit=crop&q=80" alt="Halte Boreale">
                    <div class="overlay">
                        <div>
                            <span class="badge"><i class="fas fa-building"></i> Projet touristique - Mont-Tremblant</span>
                            <h1 class="title">Halte Boreale - Developpement hospitality nature</h1>
                            <p class="sub">Un concept immobilier touristique combine hebergements premium, experiences plein air et services smart hospitality pour une clientele 4 saisons.</p>
                        </div>
                    </div>
                </div>
                <aside class="hero-side">
                    <div class="price">
                        <div class="price-main">1 250 000 CAD</div>
                        <div class="price-note">Projet cible: 8 unites + espace central experience</div>
                    </div>
                    <div class="stats">
                        <div class="stat"><i class="fas fa-building"></i><b>8 unites</b></div>
                        <div class="stat"><i class="fas fa-chart-line"></i><b>ROI 11-14%</b></div>
                        <div class="stat"><i class="fas fa-mountain"></i><b>Site strategique</b></div>
                        <div class="stat"><i class="fas fa-calendar"></i><b>Lancement 2027</b></div>
                    </div>
                    <div class="actions">
                        <a href="#contact-proprio" class="btn btn-main"><i class="fas fa-rocket"></i> Etude complete</a>
                        <a href="#" class="btn btn-sub"><i class="fas fa-file-pdf"></i> Pitch deck</a>
                    </div>
                </aside>
            </div>
        </section>

        <section class="gallery">
            <div class="g main"><img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=1400&auto=format&fit=crop&q=80" alt="Unite premium"></div>
            <div class="g"><img src="https://images.unsplash.com/photo-1470246973918-29a93221c455?w=900&auto=format&fit=crop&q=80" alt="Site nature"></div>
            <div class="g"><img src="https://images.unsplash.com/photo-1493666438817-866a91353ca9?w=900&auto=format&fit=crop&q=80" alt="Espace coworking"></div>
            <div class="g"><img src="https://images.unsplash.com/photo-1484154218962-a197022b5858?w=900&auto=format&fit=crop&q=80" alt="Restauration"></div>
            <div class="g"><img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=900&auto=format&fit=crop&q=80" alt="Lodge ambiance"></div>
        </section>

        <section class="content">
            <div>
                <article class="card">
                    <h2>Vision et positionnement</h2>
                    <p>Halte Boreale vise une clientele loisirs premium et teletravail longue fin de semaine. Le projet integre hebergement, experiences locales et operation digitale optimisee.</p>
                    <div class="feature-grid">
                        <div class="feature"><i class="fas fa-network-wired"></i> Gestion centralisee PMS</div>
                        <div class="feature"><i class="fas fa-leaf"></i> Construction eco-responsable</div>
                        <div class="feature"><i class="fas fa-concierge-bell"></i> Services conciergerie</div>
                        <div class="feature"><i class="fas fa-map"></i> Parcours experiences locales</div>
                        <div class="feature"><i class="fas fa-mobile-alt"></i> Check-in autonome</div>
                        <div class="feature"><i class="fas fa-globe"></i> Distribution internationale</div>
                    </div>
                </article>
                <article class="card">
                    <h2>Roadmap developpement</h2>
                    <ul class="list">
                        <li><i class="fas fa-check-circle"></i>Acquisition fonciere et montage legal</li>
                        <li><i class="fas fa-check-circle"></i>Conception architecturale et permis</li>
                        <li><i class="fas fa-check-circle"></i>Construction modulaire rapide</li>
                        <li><i class="fas fa-check-circle"></i>Pre-commercialisation multicanal</li>
                        <li><i class="fas fa-check-circle"></i>Ouverture progressive par phase</li>
                        <li><i class="fas fa-check-circle"></i>Optimisation revenus 12 mois</li>
                    </ul>
                </article>
                <article class="card">
                    <h2>Tableau de pilotage</h2>
                    <table class="table">
                        <thead><tr><th>Indicateur</th><th>Valeur cible</th><th>Etat</th></tr></thead>
                        <tbody>
                            <tr><td>ADR moyen</td><td>325$</td><td><span class="tag tag-amber">En cours</span></td></tr>
                            <tr><td>Taux occupation</td><td>67%</td><td><span class="tag tag-green">Atteignable</span></td></tr>
                            <tr><td>RevPAR annuel</td><td>218$</td><td><span class="tag tag-amber">Projection</span></td></tr>
                        </tbody>
                    </table>
                </article>
            </div>
            <aside class="sticky">
                <article class="card">
                    <div class="owner">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=250&auto=format&fit=crop&q=80" alt="Directeur projet">
                        <div>
                            <h3>Alexandre B.</h3>
                            <p>Directeur developpement</p>
                            <div class="mini">Disponibilite: Lun-Ven</div>
                        </div>
                    </div>
                    <p class="mini"><i class="fas fa-language"></i> Langues: Francais, Anglais</p>
                </article>
                <article class="card" id="contact-proprio">
                    <h2>Contacter l'equipe projet</h2>
                    <form class="contact">
                        <div class="f"><input type="text" placeholder="Prenom"></div>
                        <div class="f"><input type="text" placeholder="Nom"></div>
                        <div class="f"><input type="email" placeholder="Courriel"></div>
                        <div class="f"><input type="tel" placeholder="Telephone"></div>
                        <div class="f"><textarea placeholder="Votre message"></textarea></div>
                        <button type="button" class="btn btn-main"><i class="fas fa-paper-plane"></i> Envoyer demande</button>
                    </form>
                </article>
            </aside>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-inner">
            <div>
                <h4>A propos du projet</h4>
                <p>Halte Boreale est un projet touristique 4 saisons oriente performance et experience client premium.</p>
            </div>
            <div>
                <h4>Infos investisseurs</h4>
                <p>Ticket cible: 1.25M CAD</p>
                <p>8 unites + hub services</p>
                <p>ROI cible 11% a 14%</p>
            </div>
            <div>
                <h4>Liens utiles</h4>
                <p><a href="#contact-proprio">Contacter l'equipe</a></p>
                <p><a href="{{ route('home-v2') }}">Retour accueil</a></p>
                <p><a href="{{ route('pages.maison-forestiere-eclipse') }}">Voir Eclipse Forestier</a></p>
            </div>
        </div>
        <div class="copy">GoExploria - Page detail projet touristique Halte Boreale</div>
    </footer>
</body>
</html>
