@php
    use Illuminate\Support\Str;

    $siteName = $etablissement->nom ?? $etablissement->name ?? 'Go Exploria Business';
    $title = $post->display_title ?: $post->title;
    $description = trim((string) ($post->seo_description ?: $post->excerpt ?: Str::limit(strip_tags((string) $post->content), 160)));
    $publishedDate = optional($post->published_at ?: $post->created_at)->translatedFormat('j M Y');
    $tags = collect($post->tags ?? [])->filter(fn ($tag) => is_string($tag) && trim($tag) !== '')->values();
    $content = trim((string) $post->content);
    $contentHasHtml = Str::contains($content, ['<p', '<div', '<h', '<ul', '<ol', '<figure', '<blockquote', '<img', '<iframe', '<video']);
    $canonicalUrl = trim((string) $post->canonical_url) ?: url()->current();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | {{ $siteName }}</title>
    @if($description !== '')
        <meta name="description" content="{{ $description }}">
    @endif
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $title }}">
    @if($description !== '')
        <meta property="og:description" content="{{ $description }}">
    @endif
    @if($featuredImageUrl)
        <meta property="og:image" content="{{ $featuredImageUrl }}">
    @endif
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu-videos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-destinations-mega.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/categories-mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/videos-dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/restaurant-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root{--cms-blog-bg:#f5f3ed;--cms-blog-card:#fff;--cms-blog-text:#111827;--cms-blog-muted:#667085;--cms-blog-line:rgba(17,24,39,.1);--cms-blog-accent:#d6a832;--cms-blog-dark:#071527;--cms-blog-shadow:0 24px 70px rgba(15,23,42,.12)}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:var(--cms-blog-bg);color:var(--cms-blog-text);font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;overflow-x:hidden}a{color:inherit;text-decoration:none}img,video,iframe{max-width:100%}
        .vertical-menu-v2:not(.active){left:-420px;visibility:hidden}.vertical-menu-v2.active{visibility:visible}.vertical-menu-v2-overlay:not(.active){visibility:hidden}
        .cms-blog-shell{width:min(1120px,calc(100% - 34px));margin:0 auto;padding:42px 0 82px}
        .cms-blog-detail-hero{background:linear-gradient(135deg,#061226,#14243b);color:#fff;padding:clamp(110px,14vw,180px) 0 58px;position:relative;overflow:hidden}
        .cms-blog-detail-hero::after{content:"";position:absolute;inset:auto -10% -45% 40%;height:55%;background:radial-gradient(circle,rgba(214,168,50,.26),transparent 66%);pointer-events:none}
        .cms-blog-hero-inner{width:min(1120px,calc(100% - 34px));margin:auto;position:relative;z-index:1}
        .cms-blog-back{display:inline-flex;align-items:center;gap:10px;color:rgba(255,255,255,.82);font-weight:800;margin-bottom:28px}
        .cms-blog-back:hover{color:#fff}.cms-blog-meta{display:flex;align-items:center;gap:12px;flex-wrap:wrap;color:rgba(255,255,255,.72);font-size:13px;margin-bottom:18px}
        .cms-blog-tag{display:inline-flex;border:1px solid rgba(255,255,255,.22);border-radius:999px;padding:7px 12px;color:#ffe6a0;background:rgba(255,255,255,.08);font-weight:800}
        .cms-blog-title{font-size:clamp(34px,6vw,72px);line-height:1.02;letter-spacing:0;margin:0;max-width:900px}
        .cms-blog-desc{font-size:clamp(16px,2vw,20px);line-height:1.75;color:rgba(255,255,255,.76);max-width:780px;margin:22px 0 0}
        .cms-blog-card-main{background:var(--cms-blog-card);border:1px solid var(--cms-blog-line);border-radius:24px;box-shadow:var(--cms-blog-shadow);overflow:hidden}
        .cms-blog-cover{height:clamp(260px,42vw,520px);background:#d9dce4}.cms-blog-cover img{width:100%;height:100%;object-fit:cover;display:block}
        .cms-blog-content{padding:clamp(26px,5vw,58px);font-size:18px;line-height:1.85;color:#273244;overflow-wrap:anywhere}
        .cms-blog-content :where(h1,h2,h3,h4,h5,h6){color:var(--cms-blog-text);line-height:1.16;margin:34px 0 14px;overflow-wrap:anywhere}.cms-blog-content :where(p,ul,ol,blockquote,figure){margin:0 0 22px}.cms-blog-content a{color:#0b63ce;text-decoration:underline;text-underline-offset:3px}.cms-blog-content blockquote{border-left:4px solid var(--cms-blog-accent);padding:12px 0 12px 20px;background:#fff8e5}.cms-blog-content :where(img,video,iframe){border-radius:16px}.cms-blog-content iframe{width:100%;aspect-ratio:16/9;height:auto}.cms-blog-content table{display:block;width:100%;overflow-x:auto;border-collapse:collapse}
        .cms-blog-related{margin-top:42px}.cms-blog-related h2{font-size:clamp(28px,4vw,44px);margin:0 0 20px}.cms-blog-related-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px}.cms-blog-related-card{background:#fff;border:1px solid var(--cms-blog-line);border-radius:18px;overflow:hidden;box-shadow:0 14px 38px rgba(15,23,42,.08);transition:transform .25s ease}.cms-blog-related-card:hover{transform:translateY(-4px)}.cms-blog-related-img{height:170px;background:#d9dce4}.cms-blog-related-img img{width:100%;height:100%;object-fit:cover}.cms-blog-related-body{padding:18px}.cms-blog-related-date{font-size:12px;color:var(--cms-blog-muted);margin-bottom:8px}.cms-blog-related-title{font-size:18px;font-weight:900;line-height:1.25;margin:0 0 10px}.cms-blog-related-more{display:inline-flex;align-items:center;gap:8px;color:#a87900;font-weight:900}
        @media(max-width:820px){.cms-blog-related-grid{grid-template-columns:1fr}.cms-blog-detail-hero{padding:112px 0 40px}.cms-blog-title{font-size:clamp(30px,9vw,44px);line-height:1.08}.cms-blog-desc{font-size:15px}.cms-blog-shell{width:min(100% - 22px,1120px);padding:24px 0 56px}.cms-blog-card-main{border-radius:18px}.cms-blog-cover{height:240px}.cms-blog-content{font-size:16px;padding:22px}.cms-blog-meta{gap:8px;font-size:12px}.cms-blog-tag{padding:6px 10px}.cms-blog-related-card{border-radius:16px}.cms-blog-related-img{height:190px}}
        @media(max-width:520px){.cms-blog-detail-hero{padding-top:102px}.cms-blog-hero-inner{width:calc(100% - 22px)}.cms-blog-back{margin-bottom:20px}.cms-blog-title{font-size:31px}.cms-blog-cover{height:210px}.cms-blog-content{font-size:15px;line-height:1.75}.cms-blog-content :where(h1,h2,h3){font-size:1.35em}.cms-blog-related h2{font-size:28px}}
    </style>
</head>
<body>
    @include('cms::web.fallback.activities.default.vertical-menu')
    @include('home-v2.components.Header')
    @include('cms::web.fallback.partials.landing-cms-header')

    <header class="cms-blog-detail-hero">
        <div class="cms-blog-hero-inner">
            <a class="cms-blog-back" href="{{ $backUrl }}"><i class="fa-solid fa-arrow-left"></i> Retour au blog</a>
            <div class="cms-blog-meta">
                @foreach($tags->take(3) as $tag)
                    <span class="cms-blog-tag">{{ $tag }}</span>
                @endforeach
                @if($publishedDate)
                    <span>{{ $publishedDate }}</span>
                @endif
                <span>{{ $post->reading_time }} min de lecture</span>
            </div>
            <h1 class="cms-blog-title">{{ $title }}</h1>
            @if($description !== '')
                <p class="cms-blog-desc">{{ $description }}</p>
            @endif
        </div>
    </header>

    <main class="cms-blog-shell">
        <article class="cms-blog-card-main">
            @if($featuredImageUrl)
                <div class="cms-blog-cover">
                    <img src="{{ $featuredImageUrl }}" alt="{{ $title }}">
                </div>
            @endif
            <div class="cms-blog-content">
                @if($content !== '')
                    @if($contentHasHtml)
                        {!! $content !!}
                    @else
                        {!! nl2br(e($content)) !!}
                    @endif
                @else
                    <p>{{ $description }}</p>
                @endif
            </div>
        </article>

        @if($relatedPosts->isNotEmpty())
            <section class="cms-blog-related" aria-labelledby="cms-related-title">
                <h2 id="cms-related-title">Articles similaires</h2>
                <div class="cms-blog-related-grid">
                    @foreach($relatedPosts as $related)
                        <a class="cms-blog-related-card" href="{{ data_get($related, 'url') }}" target="_blank" rel="noopener noreferrer">
                            <div class="cms-blog-related-img">
                                @if(data_get($related, 'image'))
                                    <img src="{{ data_get($related, 'image') }}" alt="{{ data_get($related, 'title') }}">
                                @endif
                            </div>
                            <div class="cms-blog-related-body">
                                <div class="cms-blog-related-date">{{ data_get($related, 'date') ?: 'Blog' }}</div>
                                <h3 class="cms-blog-related-title">{{ data_get($related, 'title') }}</h3>
                                @if(data_get($related, 'excerpt'))
                                    <p>{{ data_get($related, 'excerpt') }}</p>
                                @endif
                                <span class="cms-blog-related-more">Lire la suite <i class="fa-solid fa-arrow-right"></i></span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </main>

    @include('cms::web.fallback.partials.landing-cms-footer')
    @include('home-v2.components.Footer')
    <script src="{{ asset('js/home-v2/navigation.js') }}"></script>
    <script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu-service.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/vertical-destinations-mega.js') }}"></script>
    <script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/destinations-mega-menu.js') }}"></script>
    <script src="{{ asset('js/home-v2/destinations-search.js') }}"></script>
    <script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
    <script src="{{ asset('js/home-v2/videos-dropdown.js') }}"></script>
</body>
</html>
