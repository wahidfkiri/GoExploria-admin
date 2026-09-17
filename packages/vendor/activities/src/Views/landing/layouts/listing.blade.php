{{--
    Gabarit partagé des pages « liste » d'une activité (blogs, événements,
    témoignages). Il reprend l'habillage sombre des pages de détail voisines
    (activity-blog-detail, activity-event-detail) pour que la navigation reste
    cohérente : même fond, même orange, même lien de retour.

    Sections attendues : title, heading, subheading, content.
--}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', $activity->name)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #0A1628; color: #fff; min-height: 100vh; }
        a { color: inherit; }
        .container { max-width: 1140px; margin: 0 auto; padding: 40px 20px 72px; }

        .back-link {
            display: inline-flex; align-items: center; gap: 8px; color: #FF6B35;
            text-decoration: none; font-weight: 600; font-size: .95rem; margin-bottom: 28px;
        }
        .back-link:hover { text-decoration: underline; }

        .page-head { margin-bottom: 34px; }
        .page-head h1 { font-family: 'Montserrat', sans-serif; font-size: clamp(1.9rem, 4vw, 2.7rem); font-weight: 900; }
        .page-head p { color: #9FB3C8; margin-top: 8px; }

        .cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; }

        .card {
            background: #12233C; border: 1px solid #1E3453; border-radius: 16px; overflow: hidden;
            display: flex; flex-direction: column; text-decoration: none; color: inherit;
            transition: transform .2s ease, border-color .2s ease;
        }
        .card:hover { transform: translateY(-4px); border-color: #FF6B35; }
        .card-cover { height: 176px; background: #0E1C30; display: grid; place-items: center; overflow: hidden; }
        .card-cover img { width: 100%; height: 100%; object-fit: cover; }
        .card-cover i { font-size: 2.2rem; color: #2C4A6E; }
        .card-body { padding: 18px; display: flex; flex-direction: column; gap: 10px; flex: 1; }
        .card-title { font-family: 'Montserrat', sans-serif; font-size: 1.08rem; font-weight: 700; line-height: 1.35; }
        .card-text { color: #9FB3C8; font-size: .9rem; }
        .card-meta { display: flex; flex-wrap: wrap; gap: 8px 14px; color: #7C93AC; font-size: .82rem; margin-top: auto; }
        .card-meta span { display: inline-flex; align-items: center; gap: 6px; }
        .tag {
            display: inline-block; align-self: flex-start; padding: 3px 10px; border-radius: 999px;
            background: rgba(255, 107, 53, .15); color: #FF8C5A; font-size: .74rem; font-weight: 600;
        }

        .empty { text-align: center; padding: 64px 16px; color: #7C93AC; }
        .empty i { font-size: 2.6rem; display: block; margin-bottom: 14px; opacity: .55; }

        .pager { margin-top: 34px; }
        .pager nav { display: flex; justify-content: center; }
        .pager svg { width: 16px; height: 16px; }
        .pager a, .pager span {
            display: inline-block; padding: 7px 13px; margin: 0 3px; border-radius: 8px;
            background: #12233C; color: #C7D6E6; text-decoration: none; font-size: .88rem;
        }
        .pager a:hover { background: #1B3352; }
        .pager [aria-current="page"] span { background: #FF6B35; color: #fff; }
    </style>
    @yield('styles')
</head>
<body>
    <div class="container">
        <a href="{{ route('landing.activity.show', $activity->slug) }}" class="back-link">
            <i class="fas fa-arrow-left"></i>Retour à {{ $activity->name }}
        </a>

        <header class="page-head">
            <h1>@yield('heading')</h1>
            <p>@yield('subheading')</p>
        </header>

        @yield('content')
    </div>
</body>
</html>
