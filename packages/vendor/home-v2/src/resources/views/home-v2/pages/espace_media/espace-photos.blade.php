<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Go Exploria Business | Espace Photos & Galeries Premium</title>
    <!-- Google Fonts & Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lightbox (moderne et pro) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #04060a;
            color: #ffffff;
            scroll-behavior: smooth;
        }

        /* Custom scrollbar ultra moderne */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0f1117;
        }
        ::-webkit-scrollbar-thumb {
            background: #2c2f3f;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #4b3b8c;
        }

        /* Glassmorphism Nav */
        .glass-nav {
            background: rgba(2, 5, 12, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }
        
        .btn-outline-light {
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: transparent;
            transition: 0.25s ease;
        }
        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
        }

        .btn-gradient {
            background: linear-gradient(105deg, #3a36e8, #a855f7);
            border: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-gradient:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(59, 55, 255, 0.4);
        }

        /* Hero avec gradient profond */
        .hero-bg {
            background: radial-gradient(ellipse at 30% 40%, #0d111f, #02050c 80%);
            position: relative;
            overflow: hidden;
        }
        .hero-bg::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 80% 20%, rgba(168, 85, 247, 0.08), transparent 60%);
            pointer-events: none;
        }

        /* Titres Section */
        .section-tag {
            color: #a855f7;
            letter-spacing: 2px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
        }
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(125deg, #ffffff, #cdc9ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -0.02em;
        }

        /* ========== STYLE PINTEREST (MASONRY) ========== */
        .pinterest-masonry {
            column-count: 3;
            column-gap: 1.5rem;
        }
        .pinterest-masonry .masonry-item {
            break-inside: avoid;
            margin-bottom: 1.5rem;
            border-radius: 28px;
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            background: #0b0e16;
        }
        .pinterest-masonry .masonry-item img {
            width: 100%;
            display: block;
            transition: transform 0.45s ease, filter 0.3s;
            cursor: pointer;
        }
        .pinterest-masonry .masonry-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.6);
        }
        .pinterest-masonry .masonry-item:hover img {
            transform: scale(1.02);
            filter: brightness(1.05);
        }

        /* ========== STYLE INSTAGRAM (grille carrée + hover stories) ========== */
        .instagram-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        .insta-card-pro {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            background: #0a0d14;
            aspect-ratio: 1 / 1;
            cursor: pointer;
            transition: 0.25s;
        }
        .insta-card-pro img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.4s;
        }
        .insta-card-pro .insta-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.85), transparent);
            padding: 1.2rem;
            opacity: 0;
            transition: 0.25s;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            color: white;
            font-weight: 500;
        }
        .insta-card-pro:hover .insta-overlay {
            opacity: 1;
        }
        .insta-card-pro:hover img {
            transform: scale(1.08);
        }

        /* ========== STYLE GOOGLE PHOTOS (cartes arrondies, ombre, clean) ========== */
        .google-row {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
        }
        .google-card-pro {
            flex: 1 1 280px;
            background: #0f121c;
            border-radius: 32px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 15px 30px -12px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.03);
        }
        .google-card-pro img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            transition: 0.35s;
        }
        .google-card-pro:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 35px -14px rgba(0, 0, 0, 0.6);
            border-color: rgba(168, 85, 247, 0.2);
        }
        .google-card-pro:hover img {
            transform: scale(1.03);
        }
        .google-card-pro .info-card {
            padding: 1.2rem;
        }
        .info-card h6 {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .info-card small {
            color: #9ca3af;
            font-size: 0.8rem;
        }

        /* Section alternée */
        .section-alt {
            background: linear-gradient(180deg, #04060a 0%, #080c17 100%);
        }

        /* Footer Dark mode extrême */
        .footer-dark {
            background: #010101;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        @media (max-width: 768px) {
            .pinterest-masonry {
                column-count: 2;
            }
            .section-title {
                font-size: 1.8rem;
            }
        }
        @media (max-width: 480px) {
            .pinterest-masonry {
                column-count: 1;
            }
        }

        .lightbox-overlay {
            background: rgba(0, 0, 0, 0.94);
        }
        .text-white-70 {
            color: rgba(255, 255, 255, 0.7);
        }
        hr {
            opacity: 0.2;
        }
    </style>
</head>
<body>

<!-- Navigation moderne transparente -->
<nav class="glass-nav fixed-top w-100 py-3" style="position: sticky; top: 0; z-index: 1000;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-camera-retro fs-4" style="color: #a855f7"></i>
                <span class="fw-bold fs-4" style="letter-spacing: -0.5px;">GoExploria<span style="color: #a855f7;">Business</span></span>
            </div>
            <div class="d-none d-md-flex gap-4">
                <a href="#accueil" class="text-decoration-none text-white-50 hover-text">Accueil</a>
                <a href="#pinterest-style" class="text-decoration-none text-white-50 hover-text">Pinterest</a>
                <a href="#instagram-style" class="text-decoration-none text-white-50 hover-text">Instagram</a>
                <a href="#google-style" class="text-decoration-none text-white-50 hover-text">Google</a>
                <a href="#services" class="text-decoration-none text-white-50 hover-text">Services</a>
            </div>
            <button class="btn btn-outline-light rounded-pill px-4 py-2 small fw-semibold">Devis pro <i class="fas fa-arrow-right ms-1"></i></button>
        </div>
    </div>
</nav>

<!-- Hero Section (background changé, header amélioré) -->
<section id="accueil" class="hero-bg pt-5 pb-5">
    <div class="container pt-5 pb-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="badge bg-white bg-opacity-10 rounded-pill px-3 py-2 mb-3"><i class="fas fa-images me-1"></i> Galeries Premium · 3 styles uniques</div>
                <h1 class="display-4 fw-bold mb-3">L'élégance visuelle<br> pour <span style="background: linear-gradient(145deg, #fff, #c084fc); -webkit-background-clip:text; background-clip:text; color:transparent;">votre business</span></h1>
                <p class="lead text-white-70 mb-4">Go Exploria Business vous offre un espace photo nouvelle génération. Découvrez trois ambiances distinctes : l'inspiration Pinterest, l'engagement Instagram et l'organisation Google Photos. Parfait pour les professionnels de l’image.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <button class="btn btn-gradient rounded-pill px-4 py-3 fw-semibold">Explorer les galeries <i class="fas fa-arrow-right ms-2"></i></button>
                    <button class="btn btn-outline-light rounded-pill px-4 py-3">Voir les packs pro</button>
                </div>
                <div class="mt-4 d-flex gap-3 text-white-50 small">
                    <span><i class="fas fa-check-circle" style="color:#a855f7"></i> Formats variés</span>
                    <span><i class="fas fa-check-circle" style="color:#a855f7"></i> 4K & responsive</span>
                    <span><i class="fas fa-check-circle" style="color:#a855f7"></i> Lightbox intégrée</span>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="position-relative">
                    <img src="https://picsum.photos/id/106/650/500" alt="hero preview" class="img-fluid rounded-4 shadow-xxl" style="border-radius: 2rem; border: 1px solid rgba(255,255,255,0.1);">
                    <div class="position-absolute bottom-0 start-0 bg-dark bg-opacity-70 rounded-3 px-3 py-1 m-3 backdrop-blur-sm">
                        <i class="fas fa-crown"></i> Création pro
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 1 : STYLE PINTEREST (MASONRY) -->
<section id="pinterest-style" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag"><i class="fab fa-pinterest me-1"></i> Agencement créatif</span>
            <h2 class="section-title mt-2">Style Pinterest · Flux organique</h2>
            <p class="text-white-50 mx-auto mt-3" style="max-width: 650px;">Une mosaïque dynamique qui met en valeur chaque format, du vertical au panoramique. Idéal pour les moodboards et portfolios inspirants.</p>
        </div>
        <div class="pinterest-masonry">
            <!-- multiples images avec différents ratios -->
            <div class="masonry-item"><a href="https://picsum.photos/id/101/600/850" data-lightbox="pinterest-set" data-title="Portrait Urban - Format vertical"><img src="https://picsum.photos/id/101/600/850" alt="vertical 1"></a></div>
            <div class="masonry-item"><a href="https://picsum.photos/id/104/900/650" data-lightbox="pinterest-set" data-title="Paysage naturel - Large"><img src="https://picsum.photos/id/104/900/650" alt="landscape wide"></a></div>
            <div class="masonry-item"><a href="https://picsum.photos/id/169/700/950" data-lightbox="pinterest-set" data-title="Mode & élégance"><img src="https://picsum.photos/id/169/700/950" alt="mode"></a></div>
            <div class="masonry-item"><a href="https://picsum.photos/id/155/1100/750" data-lightbox="pinterest-set" data-title="Panorama Business"><img src="https://picsum.photos/id/155/1100/750" alt="panorama"></a></div>
            <div class="masonry-item"><a href="https://picsum.photos/id/22/800/1100" data-lightbox="pinterest-set" data-title="Studio créatif"><img src="https://picsum.photos/id/22/800/1100" alt="portrait haut"></a></div>
            <div class="masonry-item"><a href="https://picsum.photos/id/96/1200/800" data-lightbox="pinterest-set" data-title="Voyage d'affaires"><img src="https://picsum.photos/id/96/1200/800" alt="business trip"></a></div>
            <div class="masonry-item"><a href="https://picsum.photos/id/30/850/1000" data-lightbox="pinterest-set" data-title="Café & inspiration"><img src="https://picsum.photos/id/30/850/1000" alt="coffee"></a></div>
            <div class="masonry-item"><a href="https://picsum.photos/id/42/1000/700" data-lightbox="pinterest-set" data-title="Architecture moderne"><img src="https://picsum.photos/id/42/1000/700" alt="architecture"></a></div>
        </div>
        <div class="text-center mt-4"><span class="badge bg-dark text-white-50 px-3 py-2"><i class="fab fa-pinterest"></i> Effet masonry fluide</span></div>
    </div>
</section>

<!-- SECTION 2 : STYLE INSTAGRAM (carrés + engagement) -->
<section id="instagram-style" class="py-5 section-alt">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag"><i class="fab fa-instagram me-1"></i> Feed visuel immersif</span>
            <h2 class="section-title mt-2">Style Instagram · Carrés & Stories</h2>
            <p class="text-white-50 mx-auto mt-3" style="max-width: 650px;">Design épuré type galerie sociale, avec overlay dynamique. Parfait pour montrer l'engagement et des collections percutantes.</p>
        </div>
        <div class="instagram-grid">
            <div class="insta-card-pro"><a href="https://picsum.photos/id/20/900/900" data-lightbox="insta-set"><img src="https://picsum.photos/id/20/900/900" alt="square1"><div class="insta-overlay"><i class="fas fa-heart"></i><span> 2.8k</span><i class="fas fa-comment ms-2"></i><span> 124</span></div></a></div>
            <div class="insta-card-pro"><a href="https://picsum.photos/id/26/900/900" data-lightbox="insta-set"><img src="https://picsum.photos/id/26/900/900" alt="square2"><div class="insta-overlay"><i class="fas fa-heart"></i><span> 1.9k</span><i class="fas fa-comment ms-2"></i><span> 87</span></div></a></div>
            <div class="insta-card-pro"><a href="https://picsum.photos/id/36/900/900" data-lightbox="insta-set"><img src="https://picsum.photos/id/36/900/900" alt="square3"><div class="insta-overlay"><i class="fas fa-heart"></i><span> 4.2k</span><i class="fas fa-comment ms-2"></i><span> 215</span></div></a></div>
            <div class="insta-card-pro"><a href="https://picsum.photos/id/50/900/900" data-lightbox="insta-set"><img src="https://picsum.photos/id/50/900/900" alt="square4"><div class="insta-overlay"><i class="fas fa-heart"></i><span> 1.5k</span><i class="fas fa-comment ms-2"></i><span> 63</span></div></a></div>
            <div class="insta-card-pro"><a href="https://picsum.photos/id/64/900/900" data-lightbox="insta-set"><img src="https://picsum.photos/id/64/900/900" alt="square5"><div class="insta-overlay"><i class="fas fa-heart"></i><span> 3.0k</span><i class="fas fa-comment ms-2"></i><span> 142</span></div></a></div>
            <div class="insta-card-pro"><a href="https://picsum.photos/id/76/900/900" data-lightbox="insta-set"><img src="https://picsum.photos/id/76/900/900" alt="square6"><div class="insta-overlay"><i class="fas fa-heart"></i><span> 990</span><i class="fas fa-comment ms-2"></i><span> 28</span></div></a></div>
        </div>
        <div class="text-center mt-4"><span class="badge bg-dark text-white-50 px-3 py-2"><i class="fab fa-instagram"></i> Expérience sociale améliorée</span></div>
    </div>
</section>

<!-- SECTION 3 : STYLE GOOGLE PHOTOS (cartes organisées) -->
<section id="google-style" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag"><i class="fab fa-google me-1"></i> Organisation intelligente</span>
            <h2 class="section-title mt-2">Style Google Photos · Clean & Moderne</h2>
            <p class="text-white-50 mx-auto mt-3" style="max-width: 650px;">Cartes élégantes, informations contextuelles, design épuré. Idéal pour les portfolios professionnels et les archives d'agence.</p>
        </div>
        <div class="google-row">
            <div class="google-card-pro"><a href="https://picsum.photos/id/13/800/600" data-lightbox="google-set"><img src="https://picsum.photos/id/13/800/600" alt="montagne"><div class="info-card"><h6>Expédition Alpes</h6><small>Shooting pro · Juin 2025</small></div></a></div>
            <div class="google-card-pro"><a href="https://picsum.photos/id/91/800/600" data-lightbox="google-set"><img src="https://picsum.photos/id/91/800/600" alt="district"><div class="info-card"><h6>Business District</h6><small>Go Exploria Studio</small></div></a></div>
            <div class="google-card-pro"><a href="https://picsum.photos/id/66/800/1000" data-lightbox="google-set"><img src="https://picsum.photos/id/66/800/1000" alt="vertical pro"><div class="info-card"><h6>Portrait Corporate</h6><small>Campagne 2025</small></div></a></div>
            <div class="google-card-pro"><a href="https://picsum.photos/id/29/900/650" data-lightbox="google-set"><img src="https://picsum.photos/id/29/900/650" alt="vignoble"><div class="info-card"><h6>Vignobles & Évasion</h6><small>Édition prestige</small></div></a></div>
        </div>
        <div class="text-center mt-4"><span class="badge bg-dark text-white-50 px-3 py-2"><i class="fas-fa-google"></i> Organisation par projet</span></div>
    </div>
</section>

<!-- Section Services professionnels -->
<section id="services" class="py-5 section-alt">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-md-6">
                <span class="section-tag mb-2 d-block">Pour les pros</span>
                <h2 class="display-6 fw-semibold">Solutions photo <span style="color:#c084fc">Business</span> sur mesure</h2>
                <p class="text-white-70 mt-3">Gérez vos shootings corporate, reportages événementiels, e-commerce ou portfolios créatifs. Avec Go Exploria Business, bénéficiez de trois designs premium dans une seule interface.</p>
                <ul class="list-unstyled mt-3">
                    <li class="mb-2"><i class="fas fa-check-circle" style="color:#a855f7"></i> Galleries séparées: Pinterest, Instagram, Google</li>
                    <li class="mb-2"><i class="fas fa-check-circle" style="color:#a855f7"></i> Téléchargement HD & options watermark</li>
                    <li class="mb-2"><i class="fas fa-check-circle" style="color:#a855f7"></i> Espace client privé & collaboration d'équipe</li>
                </ul>
                <button class="btn btn-gradient rounded-pill px-5 py-3 mt-2">Demander une démo <i class="fas fa-chalkboard-user ms-2"></i></button>
            </div>
            <div class="col-md-6">
                <div class="bg-white bg-opacity-5 rounded-4 p-4 border border-white border-opacity-5">
                    <img src="https://picsum.photos/id/1/600/400" class="img-fluid rounded-3" alt="demo pro">
                    <div class="d-flex justify-content-between mt-3 text-white-50 small">
                        <span><i class="far fa-image"></i> Jusqu'à 8K</span>
                        <span><i class="fas fa-chart-simple"></i> Analytics intégré</span>
                        <span><i class="fas fa-cloud-arrow-up"></i> Cloud pro</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer Dark Mode (très sombre) -->
<footer class="footer-dark pt-5 pb-4">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-5">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="fas fa-camera-retro fs-3" style="color:#c084fc"></i>
                    <span class="fw-bold fs-3">GoExploria<span style="color:#c084fc;">Business</span></span>
                </div>
                <p class="text-white-50 small">L'excellence photographique pour les entreprises. Des galeries distinctes qui inspirent et convertissent.</p>
                <div class="d-flex gap-3 mt-3">
                    <i class="fab fa-instagram fs-5 cursor-pointer" style="cursor:pointer; color:#aaa"></i>
                    <i class="fab fa-pinterest fs-5 cursor-pointer" style="cursor:pointer; color:#aaa"></i>
                    <i class="fab fa-google fs-5 cursor-pointer" style="cursor:pointer; color:#aaa"></i>
                </div>
            </div>
            <div class="col-lg-3">
                <h6 class="fw-semibold mb-3">Galeries</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="#pinterest-style" class="text-white-50 text-decoration-none">Pinterest Masonry</a></li>
                    <li class="mb-2"><a href="#instagram-style" class="text-white-50 text-decoration-none">Instagram Grid</a></li>
                    <li class="mb-2"><a href="#google-style" class="text-white-50 text-decoration-none">Google Photos Cards</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h6 class="fw-semibold mb-3">Contact professionnel</h6>
                <p class="small text-white-50"><i class="fas fa-envelope me-2"></i> hello@goexploria.business</p>
                <p class="small text-white-50"><i class="fas fa-phone-alt me-2"></i> +33 (0)1 70 88 99 00</p>
                <div class="mt-2">
                    <input type="email" class="form-control bg-dark border-secondary text-white" placeholder="Votre email pro">
                    <button class="btn btn-sm btn-outline-light mt-2 w-100">S'abonner <i class="fas fa-paper-plane ms-1"></i></button>
                </div>
            </div>
        </div>
        <hr class="mt-5 opacity-25">
        <div class="text-center text-white-50 small pt-3">© 2025 Go Exploria Business — Créativité & technologies pour l'image d'entreprise.</div>
    </div>
</footer>

<!-- scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script>
    // Configuration lightbox moderne fullscreen
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': "Image %1 de %2",
        'fadeDuration': 280,
        'imageFadeDuration': 300,
        'overlayOpacity': 0.92
    });

    // Smooth scroll pour ancres
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if(href === "#" || href === "") return;
            const target = document.querySelector(href);
            if(target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>
<!-- Bootstrap CSS pour les utilitaires de grille rapide -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .hover-text:hover { color: white !important; }
    .backdrop-blur-sm { backdrop-filter: blur(4px); }
    .shadow-xxl { box-shadow: 0 20px 35px -15px black; }
    .cursor-pointer { cursor: pointer; }
    section { scroll-margin-top: 85px; }
    .btn-outline-light, .btn-gradient { font-weight: 500; }
    .pinterest-masonry .masonry-item img, .insta-card-pro img, .google-card-pro img {
        pointer-events: auto;
    }
    body { overflow-x: hidden; }
</style>
</body>
</html>