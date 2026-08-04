<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Approche clients 2026-2027 de Go Exploria Business">
    <title>INFO GO | Go Exploria Business</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-destinations-mega.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(180deg, #f5f8ff 0%, #ffffff 42%);
            color: #0a1628;
        }

        .values-page {
            padding: 146px 0 70px;
        }

        .values-wrap {
            width: min(1240px, calc(100% - 34px));
            margin: 0 auto;
        }

        .values-hero {
            display: grid;
            grid-template-columns: 1.2fr .8fr;
            gap: 28px;
            align-items: stretch;
            margin-bottom: 30px;
        }

        .values-hero-content {
            background: linear-gradient(135deg, #0b1d3b 0%, #172e52 62%, #1f3b67 100%);
            border-radius: 20px;
            padding: 34px 36px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 44px rgba(13, 33, 66, 0.24);
        }

        .values-hero-content::before {
            content: '';
            position: absolute;
            top: -72px;
            right: -40px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 208, 102, 0.24) 0%, rgba(255, 208, 102, 0) 68%);
        }

        .values-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 14px;
            border-radius: 999px;
            border: 1px solid rgba(255, 216, 126, 0.35);
            background: rgba(255, 216, 126, 0.14);
            color: #ffd876;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .values-title {
            margin: 0 0 14px;
            font-size: clamp(30px, 4vw, 46px);
            line-height: 1.06;
            color: #fff;
            font-weight: 900;
        }

        .values-title span {
            color: #ffd876;
        }

        .values-intro {
            margin: 0;
            font-size: 16px;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.87);
            max-width: 760px;
        }

        .values-hero-logo-wrap {
            margin-top: 68px;
            display: flex;
            justify-content: center;
        }

        .values-hero-logo-box {
            width: min(340px, 86%);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(4px);
            padding: 14px 18px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .values-hero-logo {
            width: min(220px, 100%);
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 6px 16px rgba(0, 0, 0, 0.35));
        }

        .values-hero-media {
            display: grid;
            grid-template-rows: 1fr 1fr;
            gap: 16px;
        }

        .values-photo {
            position: relative;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 14px 30px rgba(17, 31, 53, 0.17);
            min-height: 160px;
        }

        .values-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .values-photo::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(8, 20, 40, 0.08) 0%, rgba(8, 20, 40, 0.34) 100%);
        }

        .values-body {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #e6eefb;
            box-shadow: 0 14px 34px rgba(12, 38, 82, 0.09);
            padding: 34px;
        }

        .values-lead {
            margin: 0 0 26px;
            color: #203352;
            font-size: 17px;
            line-height: 1.85;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .values-card {
            background: linear-gradient(180deg, #fbfdff 0%, #f5f9ff 100%);
            border: 1px solid #e4ecfa;
            border-radius: 14px;
            padding: 16px 16px 16px 14px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .values-card i {
            width: 34px;
            min-width: 34px;
            height: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #d4af37 0%, #f3cd6f 100%);
            color: #102647;
            font-size: 13px;
            margin-top: 1px;
        }

        .values-card p {
            margin: 0;
            color: #1c3152;
            line-height: 1.65;
            font-size: 15px;
            font-weight: 500;
        }

        /* Cartes à titre : le contenu est groupé pour ne pas s'étaler
           en colonnes à côté de l'icône. */
        .values-card-body { display: flex; flex-direction: column; gap: 8px; }

        .values-card-body h2 {
            margin: 0;
            font-size: 17px;
            font-weight: 700;
            color: #102647;
            line-height: 1.35;
        }

        /* Encart « Next Level » */
        .values-nextlevel {
            background: linear-gradient(135deg, #102647 0%, #1b3a67 100%);
            border-radius: 16px;
            padding: 26px;
            color: #e8eefb;
            margin-bottom: 22px;
        }

        .values-nextlevel .values-badge {
            background: rgba(212, 175, 55, .18);
            color: #f3cd6f;
            border-color: rgba(212, 175, 55, .35);
            margin-bottom: 14px;
        }

        .values-nextlevel-title {
            margin: 0 0 12px;
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            line-height: 1.3;
        }

        .values-nextlevel p {
            margin: 0 0 12px;
            line-height: 1.7;
            font-size: 15px;
        }

        .values-nextlevel p:last-child { margin-bottom: 0; }

        .values-signature {
            background: linear-gradient(135deg, #0f284c 0%, #17345e 100%);
            border-radius: 16px;
            padding: 24px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .values-signature::before {
            content: '';
            position: absolute;
            right: -38px;
            bottom: -38px;
            width: 132px;
            height: 132px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 216, 126, 0.34) 0%, rgba(255, 216, 126, 0) 72%);
        }

        .values-signature-quote {
            margin: 0 0 14px;
            font-size: 18px;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.95);
            font-weight: 500;
        }

        .values-signature-name {
            margin: 0;
            color: #ffd876;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: .4px;
        }

        .values-signature-role {
            margin: 4px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 14px;
            font-weight: 500;
        }

        @media (max-width: 980px) {
            .values-hero {
                grid-template-columns: 1fr;
            }

            .values-hero-media {
                grid-template-columns: 1fr 1fr;
                grid-template-rows: 1fr;
            }

            .values-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .values-page {
                padding: 126px 0 56px;
            }

            .values-wrap {
                width: min(1240px, calc(100% - 20px));
            }

            .values-hero-content,
            .values-body {
                padding: 22px 18px;
            }

            .values-hero-media {
                grid-template-columns: 1fr;
            }

            .values-title {
                font-size: clamp(28px, 8vw, 36px);
            }

            .values-intro,
            .values-lead {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    @include('home-v2.components.VerticalMenu')
    @include('home-v2.components.Header')

    {{-- Contenu repris dans l'éditeur visuel de l'administration : il remplace
         le corps d'origine, l'en-tête et le pied de page restant gérés ici. --}}
    @if(isset($sitePage) && $sitePage && $sitePage->usesBuilder())
    <main class="values-page">
        {!! $sitePage->renderedContent() !!}
    </main>
    @else
    <main class="values-page">
        <div class="values-wrap">
            <section class="values-hero">
                <div class="values-hero-content">
                    <span class="values-badge"><i class="fas fa-gem"></i> Approche clients 2026-2027</span>
                    <h1 class="values-title">C&rsquo;est quoi <span>Go Exploria Business</span></h1>
                    <p class="values-intro">
                        Plateforme d&rsquo;information touristique et d&rsquo;affaire qui s&rsquo;adresse au grand public et aux entreprises, r&eacute;gionale, nationale et internationale, qui a pour but de regrouper les lieux g&eacute;ographiques du monde entier.
                    </p>
                    <div class="values-hero-logo-wrap">
                        <div class="values-hero-logo-box">
                            <img src="{{ asset('logo.png') }}" alt="GoExploria Business" class="values-hero-logo">
                        </div>
                    </div>
                </div>
                <div class="values-hero-media">
                    <div class="values-photo">
                        <img src="{{ asset('images/info-business.png') }}" alt="Expertise business">
                    </div>
                    <div class="values-photo">
                        <img src="{{ asset('images/info-tourism.png') }}" alt="Expertise tourisme">
                    </div>
                </div>
            </section>

            <section class="values-body">
                <p class="values-lead">
                    Ax&eacute; sur la qualit&eacute; des informations : r&eacute;f&eacute;rences clients de qualit&eacute;, forfaits, promotions et les modules de gestion marketing, s&rsquo;adressant aux entreprises et les Partenaires Affili&eacute;s.
                </p>

                <div class="values-grid">
                    <article class="values-card">
                        <i class="fas fa-chart-line"></i>
                        <div class="values-card-body">
                            <h2>Un mod&egrave;le &eacute;conomique solide</h2>
                            <p>Avec un mod&egrave;le &eacute;conomique solide d&eacute;j&agrave; rentable et test&eacute; depuis 2012.</p>
                            <p>C&rsquo;est un puissant levier &eacute;conomique et d&rsquo;acquisition, ax&eacute; sur la rentabilit&eacute; et des retours sur les investissements marketing et la qualit&eacute; des informations disponibles.</p>
                        </div>
                    </article>
                    <article class="values-card">
                        <i class="fas fa-handshake"></i>
                        <div class="values-card-body">
                            <h2>Mise en valeur des Partenaires Affili&eacute;s</h2>
                            <p>Grace &agrave; l&rsquo;implication de nos Partenaires Affili&eacute;s et Certifi&eacute;s r&eacute;gionaux, nationaux et internationaux, vous aurez toutes les raisons de faire parties de nos solutions d&eacute;di&eacute;s et personnalis&eacute;s.</p>
                        </div>
                    </article>
                </div>

                <div class="values-nextlevel">
                    <span class="values-badge"><i class="fas fa-bolt"></i> Go Exploria Next Level</span>
                    <h2 class="values-nextlevel-title">Des outils marketing web exclusifs</h2>
                    <p>Avec une strat&eacute;gie num&eacute;rique performante, (+ de 250&nbsp;000&nbsp;$ / marketing / an).</p>
                    <p>
                        Grace une solution compl&egrave;te de plans d&rsquo;affichage, de positionnements web r&eacute;gionale,
                        nationale et international, des modules gestions efficaces, votre &eacute;quipe d&eacute;di&eacute;e de
                        Partenaires Affili&eacute;s qui sont pr&eacute;sent pour vous, c&rsquo;est un gage de succ&egrave;s.
                    </p>
                </div>

                <div class="values-signature">
                    <p class="values-signature-quote">
                        Choisissez l&rsquo;efficacit&eacute; nos plans m&eacute;dias.
                    </p>
                </div>
            </section>
        </div>
    </main>
    @endif

    @include('home-v2.components.Footer')
    <script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/navigation.js') }}"></script>
</body>
</html>
