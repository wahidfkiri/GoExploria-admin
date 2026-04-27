<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} - {{ __('home-v2.pages.category_suffix') }}</title>
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
        .page-wrap     { margin: 120px auto 60px; max-width: 1100px; padding: 0 32px; }
        .breadcrumb    { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #999; margin-bottom: 24px; }
        .breadcrumb a  { color: var(--accent-gold); text-decoration: none; }
        .page-title    { font-size: 2rem; font-weight: 800; color: var(--navy-dark); margin-bottom: 6px; }
        .page-desc     { color: #666; margin-bottom: 36px; max-width: 600px; line-height: 1.6; }
        .acts-grid     { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px; }
        .act-card      {
            background: #fff; border: 1px solid #e8e8e8; border-radius: 12px;
            padding: 20px; text-decoration: none; color: inherit;
            display: flex; flex-direction: column; gap: 8px;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .act-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,0.1); transform: translateY(-2px); }
        .act-card-icon  {
            width: 40px; height: 40px; background: rgba(212,175,55,0.1);
            border-radius: 10px; display: flex; align-items: center;
            justify-content: center; color: var(--accent-gold); font-size: 16px; margin-bottom: 4px;
        }
        .act-card-name  { font-size: 14px; font-weight: 700; color: var(--navy-dark); }
        .act-card-desc  { font-size: 12px; color: #888; line-height: 1.5; }
        .act-card-arrow { margin-top: auto; color: var(--accent-gold); font-size: 11px; font-weight: 700; }
        .empty-msg      { color: #999; font-style: italic; padding: 40px 0; }
        .section-count  { font-size: 13px; color: #999; margin-bottom: 20px; }
    </style>
</head>
<body>
    @include('home-v2.components.VerticalMenu')
    @include('home-v2.components.Header')

    <div class="page-wrap">
        <div class="breadcrumb">
            <a href="{{ url('/') }}"><i class="fas fa-home"></i></a>
            <span>/</span>
            <a href="{{ route('categories.index') }}">Catégories</a>
            <span>/</span>
            <span>{{ $category->name }}</span>
        </div>

        <h1 class="page-title">{{ $category->name }}</h1>
        @if($category->description)
            <p class="page-desc">{{ $category->description }}</p>
        @endif
        <p class="section-count">{{ $activities->count() }} activité(s) disponible(s)</p>

        @if($activities->isEmpty())
            <p class="empty-msg">Aucune activité disponible dans cette catégorie pour l'instant.</p>
        @else
            <div class="acts-grid">
                @foreach($activities as $act)
                    <a href="{{ route('activity.show', $act->slug ?? $act->id) }}" class="act-card">
                        <div class="act-card-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="act-card-name">{{ $act->name }}</div>
                        @if($act->description)
                            <div class="act-card-desc">{{ \Illuminate\Support\Str::limit($act->description, 80) }}</div>
                        @endif
                        <div class="act-card-arrow">
                            Découvrir <i class="fas fa-arrow-right" style="font-size:9px"></i>
                        </div>
                    </a>
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


