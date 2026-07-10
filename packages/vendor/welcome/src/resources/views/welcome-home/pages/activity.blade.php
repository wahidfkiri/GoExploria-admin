<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $activity->name }} - {{ __('welcome-home.pages.activity_suffix') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/welcome/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/footer.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css">
    <style>
        .page-wrap      { margin: 120px auto 60px; max-width: 900px; padding: 0 32px; }
        .breadcrumb     { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #999; margin-bottom: 24px; flex-wrap: wrap; }
        .breadcrumb a   { color: var(--accent-gold); text-decoration: none; }
        .act-hero       {
            display: flex; gap: 32px; align-items: flex-start;
            background: #fff; border: 1px solid #e8e8e8; border-radius: 16px;
            padding: 32px; margin-bottom: 32px;
        }
        .act-hero-img   { width: 200px; height: 200px; border-radius: 12px; object-fit: cover; flex-shrink: 0; background: #f0f0f0; }
        .act-hero-img-placeholder {
            width: 200px; height: 200px; border-radius: 12px; flex-shrink: 0;
            background: rgba(212,175,55,0.1); display: flex; align-items: center;
            justify-content: center; color: var(--accent-gold); font-size: 3rem;
        }
        .act-hero-body  { flex: 1; min-width: 0; }
        .act-badge      {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(212,175,55,0.12); color: var(--accent-gold);
            border-radius: 20px; padding: 4px 12px; font-size: 11px;
            font-weight: 700; letter-spacing: 0.5px; margin-bottom: 12px;
        }
        .act-title      { font-size: 1.8rem; font-weight: 800; color: var(--navy-dark); margin-bottom: 12px; line-height: 1.2; }
        .act-desc       { color: #555; line-height: 1.7; margin-bottom: 16px; }
        .act-tags       { display: flex; flex-wrap: wrap; gap: 6px; }
        .act-tag        {
            background: #f4f4f8; border-radius: 20px; padding: 4px 12px;
            font-size: 11px; font-weight: 600; color: #666;
        }
        .act-meta       {
            display: flex; gap: 16px; flex-wrap: wrap;
            background: #f8f9fa; border-radius: 10px; padding: 16px; margin-top: 16px;
        }
        .act-meta-item  { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #555; }
        .act-meta-icon  { color: var(--accent-gold); }
        .back-btn       {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--navy-dark); color: #fff; border-radius: 8px;
            padding: 10px 20px; text-decoration: none; font-size: 13px;
            font-weight: 600; transition: background 0.2s;
        }
        .back-btn:hover { background: var(--navy-primary); }
        @media (max-width: 600px) {
            .act-hero { flex-direction: column; }
            .act-hero-img, .act-hero-img-placeholder { width: 100%; height: 180px; }
        }
    </style>
</head>
<body>
    @include('welcome-home.components.VerticalMenu')
    @include('welcome-home.components.Header')

    <div class="page-wrap">
        <div class="breadcrumb">
            <a href="{{ url('/') }}"><i class="fas fa-home"></i></a>
            <span>/</span>
            <a href="{{ route('categories.index') }}">Catégories</a>
            @if($category)
                <span>/</span>
                <a href="{{ route('category.show', $category->slug ?? $category->id) }}">{{ $category->name }}</a>
            @endif
            <span>/</span>
            <span>{{ $activity->name }}</span>
        </div>

        <div class="act-hero">
            {{-- Image ou placeholder --}}
            @if($activity->image)
                <img src="{{ $activity->image_url }}" alt="{{ $activity->name }}" class="act-hero-img">
            @else
                <div class="act-hero-img-placeholder">
                    <i class="fas fa-mountain"></i>
                </div>
            @endif

            <div class="act-hero-body">
                @if($category)
                    <div class="act-badge">
                        <i class="fas fa-layer-group"></i>
                        {{ $category->name }}
                    </div>
                @endif
                <h1 class="act-title">{{ $activity->name }}</h1>

                @if($activity->description)
                    <p class="act-desc">{{ $activity->description }}</p>
                @endif

                @if($activity->tags_array && count($activity->tags_array))
                    <div class="act-tags">
                        @foreach($activity->tags_array as $tag)
                            <span class="act-tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="act-meta">
                    <div class="act-meta-item">
                        <i class="fas fa-check-circle act-meta-icon"></i>
                        <span>{{ $activity->is_active ? 'Disponible' : 'Indisponible' }}</span>
                    </div>
                    @if($category)
                        <div class="act-meta-item">
                            <i class="fas fa-tag act-meta-icon"></i>
                            <span>{{ $category->name }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if($category)
            <a href="{{ route('category.show', $category->slug ?? $category->id) }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Retour à {{ $category->name }}
            </a>
        @endif
    </div>

    @include('welcome-home.components.Footer')
    <script src="{{ asset('js/welcome/navigation.js') }}"></script>
    <script src="{{ asset('js/welcome/menu-api-service.js') }}"></script>
    <script src="{{ asset('js/welcome/vertical-menu.js') }}"></script>
    <script src="{{ asset('js/welcome/mega-menu.js') }}"></script>
</body>
</html>


