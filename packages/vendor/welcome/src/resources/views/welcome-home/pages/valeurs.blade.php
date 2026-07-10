<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Valeurs et expertises de Go Exploria Business">
    <title>Valeurs et nos expertises | Go Exploria Business</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/welcome/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/vertical-destinations-mega.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/footer.css') }}">

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
    @include('welcome-home.components.VerticalMenu')
    @include('welcome-home.components.Header')

    <main class="values-page">
        <div class="values-wrap">
            <section class="values-hero">
                <div class="values-hero-content">
                    <span class="values-badge"><i class="fas fa-gem"></i> Go Exploria Business</span>
                    <h1 class="values-title">Valeurs et nos <span>expertises</span></h1>
                    <p class="values-intro">
                        Le d&eacute;veloppement web est notre passion depuis plusieurs ann&eacute;es. Notre objectif est de vous faire b&eacute;n&eacute;ficier de notre expertise avec une &eacute;quipe dynamique et d&eacute;di&eacute;e au projet Go Exploria Business. Nous ne suivons pas les tendances, nous les cr&eacute;ons pour votre satisfaction.
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
                    La base de notre philosophie : la technologie au service de l&rsquo;humain, et pas l&rsquo;inverse. Nous voulons informer avec le plus de pr&eacute;cisions possible, en toute transparence, et rendre les informations accessibles &agrave; tous.
                </p>

                <div class="values-grid">
                    <article class="values-card">
                        <i class="fas fa-globe"></i>
                        <p>Rendre nos solutions web accessibles pour l&rsquo;ensemble du monde : vos ambitions seront les n&ocirc;tres.</p>
                    </article>
                    <article class="values-card">
                        <i class="fas fa-handshake"></i>
                        <p>Partager notre succ&egrave;s avec nos Partenaires Affili&eacute;s : prenez votre place avec nous.</p>
                    </article>
                    <article class="values-card">
                        <i class="fas fa-lightbulb"></i>
                        <p>Offrir les meilleures solutions web et proposer nos plans &agrave; des tarifs accessibles.</p>
                    </article>
                    <article class="values-card">
                        <i class="fas fa-network-wired"></i>
                        <p>&Eacute;voluer avec vous et rendre le monde plus proche gr&acirc;ce &agrave; des outils connect&eacute;s et efficaces.</p>
                    </article>
                </div>

                <div class="values-signature">
                    <p class="values-signature-quote">
                        Merci &agrave; tous de rendre ce projet &agrave; la hauteur de nos ambitions mutuelles.
                    </p>
                    <p class="values-signature-name">Jean b et l&rsquo;&eacute;quipe de passionn&eacute;s</p>
                    <p class="values-signature-role">Id&eacute;ateur</p>
                </div>
            </section>
        </div>
    </main>

    @include('welcome-home.components.Footer')
    <script src="{{ asset('js/welcome/menu-api-service.js') }}"></script>
    <script src="{{ asset('js/welcome/vertical-menu-dynamic.js') }}"></script>
    <script src="{{ asset('js/welcome/vertical-menu.js') }}"></script>
    <script src="{{ asset('js/welcome/navigation.js') }}"></script>
</body>
</html>
