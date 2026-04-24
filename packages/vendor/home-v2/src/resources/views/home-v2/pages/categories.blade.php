<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégories — GO EXPLORIA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css">
    <style>
        .page-wrap { margin: 120px auto 60px; max-width: 1200px; padding: 0 32px; }
        .page-title { font-size: 2rem; font-weight: 800; color: var(--navy-dark); margin-bottom: 8px; }
        .page-sub   { color: #666; margin-bottom: 40px; font-size: 1rem; }
        .cats-grid  { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; }
        .cat-card   {
            background: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 14px;
            padding: 24px;
            transition: box-shadow 0.2s, transform 0.2s;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .cat-card:hover { box-shadow: 0 8px 32px rgba(0,0,0,0.1); transform: translateY(-3px); }
        .cat-card-title { font-size: 1.1rem; font-weight: 700; color: var(--navy-dark); margin-bottom: 10px; display: flex; align-items: center; gap: 10px; }
        .cat-card-icon  { width: 36px; height: 36px; background: rgba(212,175,55,0.12); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--accent-gold); flex-shrink: 0; }
        .act-list       { list-style: none; padding: 0; margin: 0; display: flex; flex-wrap: wrap; gap: 6px; }
        .act-pill       {
            display: inline-flex; align-items: center; gap: 5px;
            background: #f4f4f8; border-radius: 20px; padding: 4px 12px;
            font-size: 12px; font-weight: 500; color: #555;
            text-decoration: none; transition: background 0.15s, color 0.15s;
        }
        .act-pill:hover { background: rgba(212,175,55,0.15); color: var(--accent-gold); }
        .act-pill-dot   { width: 4px; height: 4px; border-radius: 50%; background: var(--accent-gold); opacity: 0.6; }
        .cat-count      { font-size: 11px; color: #999; margin-bottom: 12px; }
    </style>
</head>
<body>
    @include('home-v2.components.VerticalMenu')
    @include('home-v2.components.Header')

    <div class="page-wrap">
        <h1 class="page-title"><i class="fas fa-th-large" style="color:var(--accent-gold);margin-right:10px"></i>Toutes les catégories</h1>
        <p class="page-sub">Explorez toutes nos catégories et leurs activités</p>

        @if($categories->isEmpty())
            <p style="color:#999;font-style:italic">Aucune catégorie disponible pour l'instant.</p>
        @else
            <div class="cats-grid">
                @foreach($categories as $cat)
                    <div class="cat-card">
                        <div class="cat-card-title">
                            <div class="cat-card-icon"><i class="fas fa-layer-group"></i></div>
                            <a href="{{ route('category.show', $cat->slug ?? $cat->id) }}" style="text-decoration:none;color:inherit;">
                                {{ $cat->name }}
                            </a>
                        </div>
                        <div class="cat-count">{{ $cat->activities->count() }} activité(s)</div>
                        <ul class="act-list">
                            @foreach($cat->activities->take(8) as $act)
                                <li>
                                    <a href="{{ route('activity.show', $act->slug ?? $act->id) }}" class="act-pill">
                                        <span class="act-pill-dot"></span>
                                        {{ $act->name }}
                                    </a>
                                </li>
                            @endforeach
                            @if($cat->activities->count() > 8)
                                <li>
                                    <a href="{{ route('category.show', $cat->slug ?? $cat->id) }}" class="act-pill" style="color:var(--accent-gold)">
                                        +{{ $cat->activities->count() - 8 }} autres
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @include('home-v2.components.Footer')
    <script src="{{ asset('js/home-v2/navigation.js') }}"></script>
    <script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
</body>
</html>
