<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grande Serenite - Chalet a louer | GoExploria</title>
    <meta name="description" content="Chalet a louer premium au Quebec: galerie immersive, equipements complets, disponibilites, tarifs detailles et reservation rapide.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/welcome/styles.css') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; background: #f4f6fb; color: #101828; }
        .chalet-page-header {
            background: linear-gradient(120deg, #0a1628, #1a2942);
            color: #fff;
            border-bottom: 1px solid rgba(255, 255, 255, .12);
        }
        .chalet-page-header-inner {
            max-width: 1240px;
            margin: 0 auto;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }
        .chalet-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #fff;
        }
        .chalet-brand img { height: 64px; width: auto; }
        .chalet-brand span { font-size: 11px; opacity: .85; display: block; }
        .chalet-brand b { font-size: 14px; }
        .chalet-nav { display: flex; gap: 10px; flex-wrap: wrap; }
        .chalet-nav a {
            text-decoration: none;
            color: rgba(255,255,255,.92);
            font-size: 12px;
            font-weight: 600;
            padding: 8px 12px;
            border: 1px solid rgba(255,255,255,.15);
            border-radius: 999px;
        }
        .chalet-nav a.active {
            background: rgba(212,175,55,.2);
            border-color: rgba(212,175,55,.45);
            color: #f4d36c;
        }
        .detail-wrap { max-width: 1240px; margin: 0 auto; padding: 32px 20px 72px; }
        .crumbs { font-size: 12px; color: #667085; margin-bottom: 14px; }
        .crumbs a { color: #344054; text-decoration: none; }
        .hero {
            border-radius: 22px;
            overflow: hidden;
            background: linear-gradient(120deg, #0b1a34, #1d335e);
            color: #fff;
            box-shadow: 0 18px 50px rgba(16, 24, 40, .22);
            margin-bottom: 26px;
        }
        .hero-grid { display: grid; grid-template-columns: 1.1fr .9fr; gap: 0; }
        .hero-main { position: relative; min-height: 430px; }
        .hero-main img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(7, 16, 33, .85), rgba(7, 16, 33, .25));
            display: flex; align-items: end; padding: 24px;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 14px; border-radius: 999px;
            background: rgba(212, 175, 55, .16); border: 1px solid rgba(212, 175, 55, .45);
            color: #f4d36c; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
        }
        .hero-title { font-size: clamp(1.5rem, 2.2vw, 2.2rem); font-weight: 900; line-height: 1.2; margin: 12px 0 6px; }
        .hero-sub { font-size: 13px; color: rgba(255,255,255,.82); max-width: 620px; line-height: 1.6; }
        .hero-side { padding: 26px; display: flex; flex-direction: column; gap: 18px; justify-content: center; }
        .price-box { background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.18); border-radius: 14px; padding: 18px; }
        .price-main { font-size: 1.7rem; font-weight: 900; color: #f4d36c; line-height: 1; }
        .price-note { margin-top: 8px; font-size: 12px; color: rgba(255,255,255,.78); }
        .stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .stat { background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.15); border-radius: 12px; padding: 12px 13px; font-size: 12px; }
        .stat b { display: block; color: #fff; margin-top: 3px; font-size: 13px; }
        .hero-actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn { border: 0; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border-radius: 10px; padding: 11px 16px; font-size: 12px; font-weight: 700; cursor: pointer; }
        .btn-primary { background: linear-gradient(135deg, #d4af37, #f3d76f); color: #1f2937; }
        .btn-dark { background: rgba(255,255,255,.14); color: #fff; border: 1px solid rgba(255,255,255,.2); }

        .gallery { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 12px; margin-bottom: 28px; }
        .gallery-item { border-radius: 14px; overflow: hidden; min-height: 130px; position: relative; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .gallery-item.main { grid-row: span 2; min-height: 280px; }

        .content-grid { display: grid; grid-template-columns: 1.7fr .9fr; gap: 24px; align-items: start; }
        .card { background: #fff; border-radius: 16px; padding: 22px; box-shadow: 0 8px 24px rgba(16,24,40,.07); margin-bottom: 18px; }
        .card h2 { font-size: 1.02rem; font-weight: 800; margin-bottom: 10px; color: #0f172a; }
        .card p { font-size: 13px; color: #475467; line-height: 1.75; }
        .feature-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 12px; }
        .feature { border: 1px solid #eaecf0; border-radius: 12px; padding: 11px; font-size: 12px; color: #344054; background: #fcfdff; }
        .feature i { color: #d4af37; margin-right: 7px; }
        .list { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px 20px; margin-top: 10px; }
        .list li { list-style: none; font-size: 12px; color: #344054; }
        .list li i { color: #12b76a; margin-right: 8px; }

        .table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        .table th, .table td { text-align: left; font-size: 12px; padding: 10px 8px; border-bottom: 1px solid #eaecf0; }
        .table th { color: #667085; font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: .4px; }
        .tag { display: inline-flex; align-items: center; border-radius: 999px; padding: 4px 9px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; }
        .tag-green { background: #ecfdf3; color: #027a48; }
        .tag-amber { background: #fffaeb; color: #b54708; }

        .sticky { position: sticky; top: 14px; }
        .owner { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
        .owner img { width: 56px; height: 56px; border-radius: 50%; object-fit: cover; }
        .owner h3 { font-size: 14px; font-weight: 800; }
        .owner p { font-size: 12px; color: #667085; }
        .mini { font-size: 11px; color: #667085; margin-top: 4px; }
        .contact-form .f { margin-bottom: 10px; }
        .contact-form input, .contact-form textarea, .contact-form select {
            width: 100%; border: 1px solid #d0d5dd; border-radius: 10px; padding: 10px 12px; font-family: inherit; font-size: 12px;
        }
        .contact-form textarea { min-height: 96px; resize: vertical; }
        .contact-form button { width: 100%; }

        .review { border-top: 1px solid #eaecf0; padding-top: 12px; margin-top: 12px; }
        .review:first-child { border-top: 0; padding-top: 0; margin-top: 0; }
        .review-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
        .review-name { font-size: 13px; font-weight: 700; color: #101828; }
        .stars { color: #fdb022; font-size: 12px; letter-spacing: 1px; }
        .review p { font-size: 12px; color: #475467; line-height: 1.6; }
        .chalet-page-footer {
            margin-top: 14px;
            background: #0f172a;
            color: rgba(255,255,255,.85);
        }
        .chalet-page-footer-inner {
            max-width: 1240px;
            margin: 0 auto;
            padding: 28px 20px;
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            gap: 18px;
        }
        .chalet-page-footer h4 {
            font-size: 12px;
            letter-spacing: .8px;
            text-transform: uppercase;
            color: #f4d36c;
            margin-bottom: 10px;
        }
        .chalet-page-footer p, .chalet-page-footer a {
            font-size: 12px;
            color: rgba(255,255,255,.82);
            text-decoration: none;
            line-height: 1.7;
        }
        .chalet-page-footer a:hover { color: #fff; }
        .chalet-footer-bottom {
            border-top: 1px solid rgba(255,255,255,.12);
            text-align: center;
            padding: 12px 20px 16px;
            font-size: 11px;
            color: rgba(255,255,255,.7);
        }

        @media (max-width: 1040px) {
            .hero-grid, .content-grid { grid-template-columns: 1fr; }
            .gallery { grid-template-columns: 1fr 1fr; }
            .gallery-item.main { grid-column: span 2; }
            .chalet-page-footer-inner { grid-template-columns: 1fr; }
        }
        @media (max-width: 720px) {
            .feature-grid, .list { grid-template-columns: 1fr; }
            .gallery { grid-template-columns: 1fr; }
            .gallery-item.main { grid-column: auto; }
            .chalet-page-header-inner { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <header class="chalet-page-header">
        <div class="chalet-page-header-inner">
            <a href="{{ route('home-v2') }}" class="chalet-brand">
                <img src="{{ asset('logo.png') }}" alt="GoExploria">
                <div>
                    <span>Collection premium</span>
                    <b>CHALETS A LOUER</b>
                </div>
            </a>
            <nav class="chalet-nav" aria-label="Navigation page chalet">
                <a href="#contact-proprio" class="active">Contactez Nous</a>
            </nav>
        </div>
    </header>

    <main class="detail-wrap">
        <div class="crumbs">
            <a href="{{ route('home-v2') }}">Accueil</a> / <a href="#">Chalets a louer</a> / <span>Grande Serenite</span>
        </div>

        <section class="hero">
            <div class="hero-grid">
                <div class="hero-main">
                    <img src="https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=1600&auto=format&fit=crop&q=80" alt="Chalet Grande Serenite">
                    <div class="hero-overlay">
                        <div>
                            <span class="hero-badge"><i class="fas fa-mountain"></i> Chalet a louer - Chertsey, Quebec</span>
                            <h1 class="hero-title">Grande Serenite - Experience premium bord de lac</h1>
                            <p class="hero-sub">Grand chalet en bois rond entierement renove, ideal pour familles, retraites privees et sejours de groupe jusqu'a 16 personnes.</p>
                        </div>
                    </div>
                </div>
                <aside class="hero-side">
                    <div class="price-box">
                        <div class="price-main">595$ - 650$ / nuit</div>
                        <div class="price-note">1290$ - 1490$ / fin de semaine • 3490$ - 4190$ / semaine</div>
                    </div>
                    <div class="stats">
                        <div class="stat"><i class="fas fa-users"></i> Capacite <b>16 personnes</b></div>
                        <div class="stat"><i class="fas fa-bed"></i> Chambres <b>7 chambres</b></div>
                        <div class="stat"><i class="fas fa-bath"></i> Salles de bain <b>3 + 1 salle d'eau</b></div>
                        <div class="stat"><i class="fas fa-water"></i> Emplacement <b>Bord de lac prive</b></div>
                    </div>
                    <div class="hero-actions">
                        <a href="#contact-proprio" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Contacter le proprio</a>
                        <a href="https://www.youtube.com/watch?v=_1KUM8QweOc" target="_blank" rel="noopener noreferrer" class="btn btn-dark"><i class="fab fa-youtube"></i> Voir la video</a>
                    </div>
                </aside>
            </div>
        </section>

        <section class="gallery">
            <div class="gallery-item main"><img src="https://images.unsplash.com/photo-1470246973918-29a93221c455?w=1400&auto=format&fit=crop&q=80" alt="Vue facade"></div>
            <div class="gallery-item"><img src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=900&auto=format&fit=crop&q=80" alt="Facade principale"></div>
            <div class="gallery-item"><img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=900&auto=format&fit=crop&q=80" alt="Salon"></div>
            <div class="gallery-item"><img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=900&auto=format&fit=crop&q=80" alt="Chambre"></div>
            <div class="gallery-item"><img src="https://images.unsplash.com/photo-1484154218962-a197022b5858?w=900&auto=format&fit=crop&q=80" alt="Cuisine"></div>
        </section>

        <section class="content-grid">
            <div>
                <article class="card">
                    <h2>Description generale</h2>
                    <p>
                        Ce chalet a louer a Chertsey combine cachet rustique, confort moderne et environnement naturel exceptionnel.
                        Situe sur un vaste terrain boise avec acces direct au lac, il offre deux grands salons, une salle de lecture,
                        une cuisine equipee et de grands balcons panoramiques. La configuration est parfaite pour les reunions familiales,
                        les groupes d'amis et les retraites corporatives.
                    </p>
                    <div class="feature-grid">
                        <div class="feature"><i class="fas fa-wifi"></i> Internet haute vitesse</div>
                        <div class="feature"><i class="fas fa-fire"></i> 2 foyers interieurs</div>
                        <div class="feature"><i class="fas fa-paw"></i> Animaux permis (restrictions)</div>
                        <div class="feature"><i class="fas fa-ban-smoking"></i> Non-fumeur</div>
                        <div class="feature"><i class="fas fa-skiing"></i> Ski a moins de 15 km</div>
                        <div class="feature"><i class="fas fa-ship"></i> Quai + embarcations</div>
                    </div>
                </article>

                <article class="card">
                    <h2>Commodites et equipements</h2>
                    <ul class="list">
                        <li><i class="fas fa-check-circle"></i> 6 lits simples, 4 lits Queen, 1 divan-lit</li>
                        <li><i class="fas fa-check-circle"></i> Cuisine complete + lave-vaisselle</li>
                        <li><i class="fas fa-check-circle"></i> Laveuse / secheuse et literie incluse</li>
                        <li><i class="fas fa-check-circle"></i> BBQ, canot, kayak, pedalos, vestes</li>
                        <li><i class="fas fa-check-circle"></i> Foyer exterieur et veranda</li>
                        <li><i class="fas fa-check-circle"></i> Stationnement de groupe</li>
                    </ul>
                </article>

                <article class="card">
                    <h2>Disponibilite (exemple)</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Statut</th>
                                <th>Duree min.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>15 mai 2026 - 18 juin 2026</td>
                                <td><span class="tag tag-green">Disponible</span></td>
                                <td>2 nuits</td>
                            </tr>
                            <tr>
                                <td>19 juin 2026 - 24 juin 2026</td>
                                <td><span class="tag tag-amber">Tres demande</span></td>
                                <td>4 nuits</td>
                            </tr>
                            <tr>
                                <td>5 juil. 2026 - 4 sept. 2026</td>
                                <td><span class="tag tag-amber">Haute saison</span></td>
                                <td>6 nuits</td>
                            </tr>
                        </tbody>
                    </table>
                </article>

                <article class="card">
                    <h2>Tarification detaillee</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tarif</th>
                                <th>Nuit</th>
                                <th>Fin sem.</th>
                                <th>Semaine</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tarif de base (12 pers.)</td>
                                <td>595$</td>
                                <td>1290$</td>
                                <td>3490$</td>
                            </tr>
                            <tr>
                                <td>Printemps / debut ete</td>
                                <td>645$</td>
                                <td>1490$</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Saison estivale</td>
                                <td>-</td>
                                <td>-</td>
                                <td>3990$ - 4190$</td>
                            </tr>
                        </tbody>
                    </table>
                    <p style="margin-top:10px;">
                        Prix en dollar canadien. Depot securite: 900$. Depot reservation: 50% a la reservation.
                        Taxes: 14.975% + taxe hebergement 3.5%. Menage: 180$.
                    </p>
                </article>

                <article class="card">
                    <h2>Evaluations clients (4.8/5)</h2>
                    <div class="review">
                        <div class="review-head">
                            <div class="review-name">Dennis</div>
                            <div class="stars">★★★★★</div>
                        </div>
                        <p>Propriete magnifique, beaucoup d'espace et excellent acces au bord de l'eau. Ideal pour les familles.</p>
                    </div>
                    <div class="review">
                        <div class="review-head">
                            <div class="review-name">Andre</div>
                            <div class="stars">★★★★☆</div>
                        </div>
                        <p>Chalet parfait pour un grand rassemblement. Ambiance chaleureuse et tres bonne organisation des pieces.</p>
                    </div>
                    <div class="review">
                        <div class="review-head">
                            <div class="review-name">Eric</div>
                            <div class="stars">★★★★★</div>
                        </div>
                        <p>Emplacement top, equipements complets et excellent rapport qualite-prix. On reviendra.</p>
                    </div>
                </article>
            </div>

            <aside class="sticky">
                <article class="card">
                    <div class="owner">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=250&auto=format&fit=crop&q=80" alt="Proprietaire">
                        <div>
                            <h3>Radama</h3>
                            <p>Membre depuis 2014</p>
                            <div class="mini">Taux de reponse: 100%</div>
                        </div>
                    </div>
                    <p class="mini"><i class="fas fa-language"></i> Langue: Francais</p>
                </article>

                <article class="card" id="contact-proprio">
                    <h2>Contacter le proprietaire</h2>
                    <form class="contact-form">
                        <div class="f"><input type="text" placeholder="Prenom"></div>
                        <div class="f"><input type="text" placeholder="Nom"></div>
                        <div class="f"><input type="email" placeholder="Courriel"></div>
                        <div class="f"><input type="tel" placeholder="Telephone"></div>
                        <div class="f"><select><option>Adultes</option><option>2</option><option>4</option><option>8</option><option>12+</option></select></div>
                        <div class="f"><textarea placeholder="Message"></textarea></div>
                        <button type="button" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Envoyer la demande</button>
                    </form>
                </article>
            </aside>
        </section>
    </main>

    <footer class="chalet-page-footer">
        <div class="chalet-page-footer-inner">
            <div>
                <h4>A propos du chalet</h4>
                <p>Grande Serenite est un chalet de groupe a Chertsey, concu pour les sejours famille, entre amis et retraites corporatives en toute tranquillite.</p>
            </div>
            <div>
                <h4>Infos location</h4>
                <p>Capacite: 16 personnes</p>
                <p>7 chambres • 3 salles de bain</p>
                <p>Arrivee: 17:00 • Depart: 11:00</p>
            </div>
            <div>
                <h4>Liens utiles</h4>
                <p><a href="#contact-proprio">Contacter le proprietaire</a></p>
                <p><a href="https://www.google.com/maps/search/?api=1&query=46.1502890837421,-73.80780458450319" target="_blank" rel="noopener noreferrer">Voir la localisation</a></p>
                <p><a href="{{ route('home-v2') }}">Retour a l'accueil</a></p>
            </div>
        </div>
        <div class="chalet-footer-bottom">GoExploria - Page detail chalet a louer</div>
    </footer>
</body>
</html>
