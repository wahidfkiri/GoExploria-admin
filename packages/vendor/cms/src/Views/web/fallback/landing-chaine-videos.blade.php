@php
    $siteName = trim((string) (get_site_name($etablissement->id) ?: ($etablissement->name ?? 'Chaine videos')));
    $siteDescription = trim((string) (
        $etablissement->getSetting('site_description', null, 'general')
        ?: get_site_description($etablissement->id)
        ?: ($etablissement->description ?? '')
    ));
    $videos = collect($videoChannelVideos ?? [])->values();
    $featuredVideo = $videos->first();
    $channels = $videos
        ->groupBy(fn ($video) => data_get($video, 'channel') ?: 'Videos')
        ->map(fn ($items, $name) => ['name' => $name, 'count' => $items->count()])
        ->values();
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteName }} - Chaine videos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
    <style>
        .vh-video-channel-page{--cream:#FAF8F4;--warm-white:#fff;--ink:#0F0E0C;--ink-soft:#3A3832;--ink-muted:#8A8880;--amber:#E8A020;--amber-light:#FDF3E0;--amber-dark:#B87A10;--border:rgba(15,14,12,.08);--border-md:rgba(15,14,12,.14);--shadow-sm:0 1px 3px rgba(15,14,12,.06),0 1px 2px rgba(15,14,12,.04);--shadow-md:0 4px 16px rgba(15,14,12,.08),0 2px 6px rgba(15,14,12,.05);--shadow-lg:0 12px 40px rgba(15,14,12,.12),0 4px 12px rgba(15,14,12,.06);--r-lg:20px;--r-xl:28px;--font-display:'Syne',sans-serif;--font-body:'DM Sans',sans-serif;margin:0;font-family:var(--font-body);background:radial-gradient(circle at top left,rgba(232,160,32,.18),transparent 34%),var(--cream);color:var(--ink);min-height:100vh;overflow-x:hidden;-webkit-font-smoothing:antialiased}
        .vh-video-channel-page *{box-sizing:border-box}
        .vh-video-channel-page .vh-page{padding-top:96px}
        .vh-video-channel-page .vh-page a{color:inherit;text-decoration:none}
        .vh-video-channel-page .vh-page img,.vh-video-channel-page .vh-page video,.vh-video-channel-page .vh-page iframe,.vh-video-channel-page .modal-video-frame iframe,.vh-video-channel-page .modal-video-frame video{max-width:100%}
        .vh-video-channel-page .vh-container{max-width:1200px;margin:0 auto;padding:0 40px}
        .vh-video-channel-page .hero{padding:80px 40px 60px;display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;max-width:1200px;margin:0 auto}
        .vh-video-channel-page .hero-label{display:inline-flex;align-items:center;gap:6px;background:var(--amber-light);color:var(--amber-dark);border:1px solid rgba(232,160,32,.3);border-radius:50px;padding:4px 12px 4px 6px;font-size:12px;font-weight:500;margin-bottom:20px}
        .vh-video-channel-page .hero-label span{width:6px;height:6px;border-radius:50%;background:var(--amber);display:block}
        .vh-video-channel-page .hero h1{font-family:var(--font-display);font-size:clamp(38px,4.5vw,58px);font-weight:800;line-height:1.05;letter-spacing:0;color:var(--ink);margin:0 0 20px}
        .vh-video-channel-page .hero h1 em{font-style:normal;color:var(--amber)}
        .vh-video-channel-page .hero p{font-size:16px;line-height:1.7;color:var(--ink-soft);max-width:460px;margin:0 0 34px}
        .vh-video-channel-page .hero-actions{display:flex;align-items:center;gap:14px;flex-wrap:wrap}
        .vh-video-channel-page .vh-btn-primary,.vh-video-channel-page .vh-btn-ghost{border-radius:50px;padding:13px 24px;font-size:15px;font-weight:500;font-family:var(--font-body);cursor:pointer;transition:.2s;border:1px solid transparent}
        .vh-video-channel-page .vh-btn-primary{background:var(--ink);color:#fff;box-shadow:0 4px 14px rgba(15,14,12,.25)}
        .vh-video-channel-page .vh-btn-primary:hover{background:#2A2920;transform:translateY(-2px)}
        .vh-video-channel-page .vh-btn-ghost{background:transparent;color:var(--ink-soft);border-color:var(--border-md)}
        .vh-video-channel-page .vh-btn-ghost:hover{background:var(--warm-white)}
        .vh-video-channel-page .hero-stats{display:flex;gap:28px;margin-top:40px;padding-top:32px;border-top:1px solid var(--border)}
        .vh-video-channel-page .stat{display:flex;flex-direction:column;gap:2px}
        .vh-video-channel-page .stat-num{font-family:var(--font-display);font-size:24px;font-weight:700;color:var(--ink)}
        .vh-video-channel-page .stat-label{font-size:12px;color:var(--ink-muted)}
        .vh-video-channel-page .hero-visual{position:relative;display:flex;justify-content:center;align-items:center}
        .vh-video-channel-page .hero-card-stack{position:relative;width:100%;max-width:420px}
        .vh-video-channel-page .hero-card-bg,.vh-video-channel-page .hero-card-mid{position:absolute;background:var(--warm-white);border:1px solid var(--border);border-radius:var(--r-xl);box-shadow:var(--shadow-sm)}
        .vh-video-channel-page .hero-card-bg{width:88%;height:88%;top:6%;right:-4%;transform:rotate(3deg)}
        .vh-video-channel-page .hero-card-mid{width:92%;height:92%;top:3%;left:-3%;transform:rotate(-2deg)}
        .vh-video-channel-page .hero-card-main{position:relative;z-index:3;background:var(--warm-white);border:1px solid var(--border-md);border-radius:var(--r-xl);overflow:hidden;box-shadow:var(--shadow-lg)}
        .vh-video-channel-page .hero-video-thumb{width:100%;aspect-ratio:16/9;background:linear-gradient(135deg,#1A1814 0%,#2C2920 50%,#1A1814 100%);position:relative;overflow:hidden;display:grid;place-items:center}
        .vh-video-channel-page .hero-video-thumb img,.vh-video-channel-page .hero-video-thumb video{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
        .vh-video-channel-page .hero-video-thumb:after{content:"";position:absolute;inset:0;background:rgba(15,14,12,.22)}
        .vh-video-channel-page .play-btn-hero{position:relative;z-index:1;width:56px;height:56px;border-radius:50%;background:rgba(255,255,255,.18);backdrop-filter:blur(8px);border:1.5px solid rgba(255,255,255,.3);display:grid;place-items:center;color:#fff}
        .vh-video-channel-page .hero-card-info{padding:16px 18px 18px}
        .vh-video-channel-page .hero-card-info h3{font-family:var(--font-display);font-size:15px;font-weight:700;color:var(--ink);margin:0 0 6px}
        .vh-video-channel-page .hero-card-meta{display:flex;align-items:center;gap:10px}
        .vh-video-channel-page .channel-avatar{width:22px;height:22px;border-radius:50%;background:var(--amber);display:grid;place-items:center;font-size:10px;font-weight:700;color:var(--warm-white);font-family:var(--font-display);flex:0 0 auto}
        .vh-video-channel-page .meta-text{font-size:12px;color:var(--ink-muted)}
        .vh-video-channel-page .floating-badge{position:absolute;z-index:10;background:var(--warm-white);border:1px solid var(--border-md);border-radius:12px;padding:8px 12px;box-shadow:var(--shadow-md);display:flex;align-items:center;gap:8px}
        .vh-video-channel-page .floating-badge.top-right{top:-16px;right:-20px}
        .vh-video-channel-page .floating-badge.bottom-left{bottom:20px;left:-24px}
        .vh-video-channel-page .badge-icon{width:28px;height:28px;border-radius:8px;display:grid;place-items:center;font-size:14px}
        .vh-video-channel-page .badge-text{font-size:12px}
        .vh-video-channel-page .badge-text strong{display:block;font-weight:600;color:var(--ink);font-size:13px}
        .vh-video-channel-page .badge-text span{color:var(--ink-muted)}
        .vh-video-channel-page .search-section{padding:12px 0 34px}
        .vh-video-channel-page .search-panel{background:var(--warm-white);border:1px solid var(--border-md);border-radius:var(--r-xl);box-shadow:var(--shadow-md);padding:18px;display:grid;gap:12px;position:relative}
        .vh-video-channel-page .search-line{display:grid;grid-template-columns:1fr auto;gap:12px;align-items:center}
        .vh-video-channel-page .search-box{display:flex;align-items:center;gap:10px;background:var(--cream);border:1px solid var(--border-md);border-radius:999px;padding:12px 16px;min-width:0}
        .vh-video-channel-page .search-box:focus-within{border-color:var(--amber);box-shadow:0 0 0 3px rgba(232,160,32,.18)}
        .vh-video-channel-page .search-box i{color:var(--ink-muted);flex:0 0 auto}
        .vh-video-channel-page .search-box input{width:100%;min-width:0;border:0;background:transparent;outline:0;font:inherit;color:var(--ink)}
        .vh-video-channel-page .search-suggestions{position:absolute;top:78px;left:18px;right:18px;z-index:20;background:#fff;border:1px solid var(--border-md);border-radius:18px;box-shadow:var(--shadow-lg);padding:8px;display:none}
        .vh-video-channel-page .search-suggestions.is-open{display:grid}
        .vh-video-channel-page .suggestion{border:0;background:transparent;text-align:left;border-radius:12px;padding:10px 12px;font:inherit;cursor:pointer;color:var(--ink-soft)}
        .vh-video-channel-page .suggestion:hover{background:var(--amber-light);color:var(--ink)}
        .vh-video-channel-page .section-head{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:24px}
        .vh-video-channel-page .section-head h2{font-family:var(--font-display);font-size:22px;font-weight:700;color:var(--ink);margin:0}
        .vh-video-channel-page .section-head p{font-size:13px;color:var(--ink-muted);margin:4px 0 0}
        .vh-video-channel-page .channels-section{padding:28px 0 24px}
        .vh-video-channel-page .channels-row{display:flex;gap:12px;overflow-x:auto;padding-bottom:8px;scrollbar-width:none}
        .vh-video-channel-page .channels-row::-webkit-scrollbar{display:none}
        .vh-video-channel-page .channel-pill{display:flex;align-items:center;gap:10px;background:var(--warm-white);border:1.5px solid var(--border);border-radius:50px;padding:8px 16px 8px 8px;cursor:pointer;flex-shrink:0;transition:.2s;color:inherit}
        .vh-video-channel-page .channel-pill:hover{border-color:var(--border-md);box-shadow:var(--shadow-sm);transform:translateY(-1px)}
        .vh-video-channel-page .channel-pill.active{border-color:var(--ink);background:var(--ink);color:#fff}
        .vh-video-channel-page .channel-pill-avatar{width:32px;height:32px;border-radius:50%;display:grid;place-items:center;font-size:13px;font-weight:700;flex-shrink:0;font-family:var(--font-display)}
        .vh-video-channel-page .channel-pill-info .name{font-size:13px;font-weight:500;display:block;line-height:1.2}
        .vh-video-channel-page .channel-pill-info .count{font-size:11px;color:var(--ink-muted);display:block}
        .vh-video-channel-page .channel-pill.active .count{color:rgba(255,255,255,.6)}
        .vh-video-channel-page .videos-section{padding:12px 0 56px}
        .vh-video-channel-page .video-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px}
        .vh-video-channel-page .video-card{background:var(--warm-white);border:1px solid var(--border);border-radius:var(--r-lg);overflow:hidden;cursor:pointer;transition:.25s;position:relative}
        .vh-video-channel-page .video-card:hover{box-shadow:var(--shadow-md);transform:translateY(-3px)}
        .vh-video-channel-page .video-thumb-wrap{position:relative;aspect-ratio:16/9;overflow:hidden;background:#E8E4DC}
        .vh-video-channel-page .video-thumb-wrap img,.vh-video-channel-page .video-thumb-wrap video{width:100%;height:100%;object-fit:cover}
        .vh-video-channel-page .video-thumb-placeholder{width:100%;height:100%;background:linear-gradient(135deg,#2A2720 0%,#3C3830 60%,#1E1C18 100%);display:grid;place-items:center;color:#fff;font-size:34px}
        .vh-video-channel-page .play-overlay{position:absolute;inset:0;background:rgba(15,14,12,.35);display:grid;place-items:center;opacity:0;transition:.25s}
        .vh-video-channel-page .video-card:hover .play-overlay{opacity:1}
        .vh-video-channel-page .play-circle{width:48px;height:48px;border-radius:50%;background:rgba(255,255,255,.92);display:grid;place-items:center;color:var(--ink);box-shadow:0 4px 16px rgba(0,0,0,.3)}
        .vh-video-channel-page .thumb-bar{position:absolute;bottom:0;left:0;right:0;height:3px;background:var(--amber);transform:scaleX(0);transform-origin:left;transition:.3s}
        .vh-video-channel-page .video-card:hover .thumb-bar{transform:scaleX(1)}
        .vh-video-channel-page .video-source-badge{position:absolute;top:8px;left:8px;border-radius:6px;padding:3px 8px;font-size:10px;font-weight:700;letter-spacing:.03em;backdrop-filter:blur(8px);color:#fff}
        .vh-video-channel-page .badge-youtube{background:rgba(255,0,0,.85)}
        .vh-video-channel-page .badge-vimeo{background:rgba(26,183,234,.85)}
        .vh-video-channel-page .badge-dailymotion{background:rgba(0,88,255,.85)}
        .vh-video-channel-page .badge-local{background:rgba(15,14,12,.75)}
        .vh-video-channel-page .video-origin-badge{position:absolute;bottom:8px;right:8px;max-width:calc(100% - 16px);background:rgba(15,14,12,.75);color:#fff;border-radius:4px;padding:2px 6px;font-size:11px;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .vh-video-channel-page .video-info{padding:14px 16px 16px}
        .vh-video-channel-page .video-info h3{font-family:var(--font-display);font-size:14px;font-weight:700;color:var(--ink);line-height:1.35;margin:0 0 8px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .vh-video-channel-page .video-meta{display:flex;align-items:center;gap:8px;min-width:0}
        .vh-video-channel-page .ch-avatar{width:22px;height:22px;border-radius:50%;display:grid;place-items:center;font-size:9px;font-weight:700;flex-shrink:0;font-family:var(--font-display)}
        .vh-video-channel-page .ch-name,.vh-video-channel-page .views{min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .vh-video-channel-page .ch-name{font-size:12px;color:var(--ink-soft);font-weight:500}
        .vh-video-channel-page .sep,.vh-video-channel-page .views{font-size:11px;color:var(--ink-muted)}
        .vh-video-channel-page .empty-state{text-align:center;padding:80px 20px;background:rgba(255,255,255,.6);border:1px dashed var(--border-md);border-radius:var(--r-xl)}
        .vh-video-channel-page .modal-overlay{position:fixed;inset:0;z-index:2000;background:rgba(15,14,12,.7);backdrop-filter:blur(12px);display:flex;align-items:center;justify-content:center;padding:24px;opacity:0;pointer-events:none;transition:.25s}
        .vh-video-channel-page .modal-overlay.open{opacity:1;pointer-events:auto}
        .vh-video-channel-page .modal-box{background:var(--warm-white);border-radius:var(--r-xl);overflow:hidden;width:100%;max-width:880px;box-shadow:0 24px 80px rgba(15,14,12,.35);transform:scale(.94) translateY(20px);transition:.3s}
        .vh-video-channel-page .modal-overlay.open .modal-box{transform:scale(1) translateY(0)}
        .vh-video-channel-page .modal-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border)}
        .vh-video-channel-page .modal-title{font-family:var(--font-display);font-size:16px;font-weight:700;color:var(--ink)}
        .vh-video-channel-page .modal-close{width:34px;height:34px;border-radius:50%;background:var(--cream);border:1px solid var(--border);display:grid;place-items:center;cursor:pointer}
        .vh-video-channel-page .modal-video-frame{width:100%;aspect-ratio:16/9;background:#0F0E0C}
        .vh-video-channel-page .modal-video-frame iframe,.vh-video-channel-page .modal-video-frame video{width:100%;height:100%;border:0}
        .vh-video-channel-page .modal-footer{padding:16px 20px}
        .vh-video-channel-page .modal-footer h4{font-family:var(--font-display);font-size:15px;font-weight:700;color:var(--ink);margin:0 0 4px}
        .vh-video-channel-page .modal-footer p{font-size:13px;color:var(--ink-muted);margin:0}
        .vh-video-channel-page .vh-footer{border-top:1px solid var(--border);padding:32px 40px;display:flex;align-items:center;justify-content:space-between;max-width:1200px;margin:0 auto;color:var(--ink-muted);font-size:13px}
        @media(max-width:900px){.vh-video-channel-page .vh-page{padding-top:82px}.vh-video-channel-page .vh-container{padding:0 20px}.vh-video-channel-page .hero{grid-template-columns:1fr;gap:40px;padding:48px 20px 40px}.vh-video-channel-page .hero-visual{order:-1}.vh-video-channel-page .search-line{grid-template-columns:1fr}.vh-video-channel-page .search-suggestions{top:132px}.vh-video-channel-page .vh-footer{padding:24px 20px;flex-direction:column;gap:12px;text-align:center}}
        @media(max-width:600px){.vh-video-channel-page .vh-container{padding:0 16px}.vh-video-channel-page .video-grid{grid-template-columns:1fr}.vh-video-channel-page .hero{padding:36px 16px 34px}.vh-video-channel-page .hero h1{font-size:34px}.vh-video-channel-page .hero-stats{gap:18px;flex-wrap:wrap}.vh-video-channel-page .floating-badge{display:none}.vh-video-channel-page .search-panel{padding:14px;border-radius:20px}.vh-video-channel-page .search-suggestions{left:14px;right:14px}.vh-video-channel-page .vh-btn-primary,.vh-video-channel-page .vh-btn-ghost{width:100%;justify-content:center}.vh-video-channel-page .section-head{display:block}.vh-video-channel-page .modal-overlay{padding:14px}}
    </style>
</head>
<body class="vh-video-channel-page">
    @include('home-v2.components.Header')

    <main class="vh-page">
        <section class="hero">
            <div class="hero-text">
                <div class="hero-label"><span></span>{{ $siteName }}</div>
                <h1>Votre chaine<br><em>videos</em><br>centralisee</h1>
                @if($siteDescription)
                    <p>{{ $siteDescription }}</p>
                @else
                    <p>Retrouvez automatiquement les videos publiees dans les sliders, les sliders CMS et les medias videos de cet etablissement.</p>
                @endif
                <div class="hero-actions">
                    <button class="vh-btn-primary" type="button" data-scroll-videos>Voir les videos</button>
                    <button class="vh-btn-ghost" type="button" data-focus-search>Rechercher</button>
                </div>
                <div class="hero-stats">
                    <div class="stat"><span class="stat-num" id="statVideos">{{ $videos->count() }}</span><span class="stat-label">Videos</span></div>
                    <div class="stat"><span class="stat-num" id="statChannels">{{ $channels->count() }}</span><span class="stat-label">Chaines</span></div>
                    <div class="stat"><span class="stat-num">3</span><span class="stat-label">Sources</span></div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-card-stack">
                    <div class="hero-card-bg"></div>
                    <div class="hero-card-mid"></div>
                    <button class="hero-card-main" type="button" data-featured-video style="border:0;text-align:left;padding:0;cursor:pointer">
                        <div class="hero-video-thumb">
                            @if($featuredVideo && data_get($featuredVideo, 'thumbnail'))
                                <img src="{{ data_get($featuredVideo, 'thumbnail') }}" alt="{{ data_get($featuredVideo, 'title') }}">
                            @elseif($featuredVideo && !data_get($featuredVideo, 'is_iframe'))
                                <video src="{{ data_get($featuredVideo, 'play_url') }}" muted playsinline></video>
                            @endif
                            <div class="play-btn-hero"><i class="fa-solid fa-play"></i></div>
                        </div>
                        <div class="hero-card-info">
                            <h3>{{ data_get($featuredVideo, 'title') ?: 'Aucune video publiee' }}</h3>
                            <div class="hero-card-meta">
                                <div class="channel-avatar">{{ mb_substr((string) (data_get($featuredVideo, 'channel') ?: 'VD'), 0, 2, 'UTF-8') }}</div>
                                <span class="meta-text">{{ data_get($featuredVideo, 'channel') ?: 'Chaine videos' }} @if($featuredVideo) - {{ data_get($featuredVideo, 'source_label') }} @endif</span>
                            </div>
                        </div>
                    </button>
                    <div class="floating-badge top-right"><div class="badge-icon" style="background:#FDEAEC"><i class="fa-solid fa-film"></i></div><div class="badge-text"><strong>{{ $videos->count() }} videos</strong><span>Disponibles</span></div></div>
                    <div class="floating-badge bottom-left"><div class="badge-icon" style="background:#E0F5F0"><i class="fa-solid fa-layer-group"></i></div><div class="badge-text"><strong>{{ $channels->count() }} chaines</strong><span>Categories</span></div></div>
                </div>
            </div>
        </section>

        <section class="search-section" id="videoSearch">
            <div class="vh-container">
                <div class="search-panel">
                    <div class="search-line">
                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="search" id="videoSearchInput" autocomplete="off" placeholder="Chercher une video, une chaine, une source...">
                        </div>
                        <button class="vh-btn-primary" type="button" id="videoSearchButton">Rechercher</button>
                    </div>
                    <div class="search-suggestions" id="videoSuggestions"></div>
                </div>
            </div>
        </section>

        <div id="videosAnchor"></div>
        <section class="channels-section">
            <div class="vh-container">
                <div class="section-head">
                    <div><h2>Chaines</h2><p>Filtrer par categorie ou source</p></div>
                </div>
                <div class="channels-row" id="channelsRow"></div>
            </div>
        </section>

        <section class="videos-section">
            <div class="vh-container">
                <div class="section-head">
                    <div><h2 id="gridTitle">Toutes les videos</h2><p id="gridMeta">{{ $videos->count() }} video(s)</p></div>
                </div>
                <div class="video-grid" id="videoGrid"></div>
                <div id="emptyState" class="empty-state" style="display:none">
                    <div style="font-size:48px;margin-bottom:16px"><i class="fa-solid fa-video-slash"></i></div>
                    <h3 style="font-family:var(--font-display);font-size:20px;color:var(--ink);margin:0 0 8px">Aucune video trouvee</h3>
                    <p style="color:var(--ink-muted);font-size:14px;margin:0">Ajoutez des videos dans les sliders, les sliders CMS ou cms_media.</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="vh-footer">
        <span>&copy; {{ date('Y') }} {{ $siteName }}</span>
        <span style="color:var(--amber)"><i class="fa-solid fa-star"></i></span>
    </footer>

    <div class="modal-overlay" id="playerModal" role="dialog" aria-modal="true" aria-labelledby="modalVideoTitle">
        <div class="modal-box">
            <div class="modal-header">
                <span class="modal-title" id="modalVideoTitle">Lecture</span>
                <button class="modal-close" type="button" id="modalClose" aria-label="Fermer"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-video-frame" id="modalFrame"></div>
            <div class="modal-footer">
                <h4 id="modalVideoName"></h4>
                <p id="modalVideoCh"></p>
            </div>
        </div>
    </div>

    <script>
        const initialVideos = @json($videos);
        const searchUrl = @json(route('cms.company.videos.search', ['etablissementId' => $etablissement->id]));
        let videos = Array.isArray(initialVideos) ? initialVideos : [];
        let activeFilter = 'all';
        let searchQuery = '';
        let debounceTimer = null;

        const channelColors = ['#E8A020','#0D9B80','#E03040','#2060D8','#9B4DCA','#0DA86E','#E05020','#2090B8'];

        function esc(value) {
            const div = document.createElement('div');
            div.textContent = value || '';
            return div.innerHTML;
        }

        function channelColor(name) {
            let hash = 0;
            String(name || '').split('').forEach(c => hash = (hash * 31 + c.charCodeAt(0)) % channelColors.length);
            return channelColors[Math.abs(hash) % channelColors.length];
        }

        function initials(name) {
            return String(name || 'VD').trim().slice(0, 2).toUpperCase();
        }

        function sourceClass(source) {
            return 'badge-' + (source || 'local');
        }

        function getChannels() {
            const map = {};
            videos.forEach(video => {
                const name = video.channel || 'Videos';
                map[name] = (map[name] || 0) + 1;
            });
            return map;
        }

        function renderChannels() {
            const row = document.getElementById('channelsRow');
            const channels = getChannels();
            let html = `
                <button class="channel-pill ${activeFilter === 'all' ? 'active' : ''}" type="button" data-channel="all">
                    <div class="channel-pill-avatar" style="background:${activeFilter === 'all' ? 'rgba(255,255,255,.2)' : '#F1EFE8'};color:${activeFilter === 'all' ? '#fff' : '#3A3832'}"><i class="fa-solid fa-film"></i></div>
                    <div class="channel-pill-info"><span class="name">Toutes</span><span class="count">${videos.length} videos</span></div>
                </button>`;

            Object.entries(channels).forEach(([name, count]) => {
                const active = activeFilter === name;
                const color = channelColor(name);
                html += `
                    <button class="channel-pill ${active ? 'active' : ''}" type="button" data-channel="${esc(name)}">
                        <div class="channel-pill-avatar" style="background:${active ? 'rgba(255,255,255,.2)' : color + '22'};color:${active ? '#fff' : color}">${esc(initials(name))}</div>
                        <div class="channel-pill-info"><span class="name">${esc(name)}</span><span class="count">${count} video${count > 1 ? 's' : ''}</span></div>
                    </button>`;
            });
            row.innerHTML = html;
            row.querySelectorAll('[data-channel]').forEach(button => {
                button.addEventListener('click', () => {
                    activeFilter = button.dataset.channel || 'all';
                    runSearch(document.getElementById('videoSearchInput').value);
                });
            });
        }

        function filteredVideos() {
            const q = searchQuery.trim().toLowerCase();
            return videos.filter(video => {
                const channelOk = activeFilter === 'all' || video.channel === activeFilter;
                const text = [video.title, video.description, video.channel, video.source_label, video.origin_label].join(' ').toLowerCase();
                return channelOk && (!q || text.includes(q));
            });
        }

        function renderGrid() {
            const grid = document.getElementById('videoGrid');
            const empty = document.getElementById('emptyState');
            const title = document.getElementById('gridTitle');
            const meta = document.getElementById('gridMeta');
            const list = filteredVideos();
            title.textContent = activeFilter === 'all' ? 'Toutes les videos' : activeFilter;
            meta.textContent = `${list.length} video(s)`;

            if (!list.length) {
                grid.style.display = 'none';
                empty.style.display = 'block';
                return;
            }

            grid.style.display = 'grid';
            empty.style.display = 'none';
            grid.innerHTML = list.map((video, index) => {
                const color = channelColor(video.channel);
                const thumb = video.thumbnail ? `<img src="${esc(video.thumbnail)}" alt="${esc(video.title)}">` : `<div class="video-thumb-placeholder"><i class="fa-solid fa-play"></i></div>`;
                return `
                    <article class="video-card" tabindex="0" role="button" data-video-index="${index}" aria-label="Lire ${esc(video.title)}">
                        <div class="video-thumb-wrap">
                            ${thumb}
                            <div class="play-overlay"><div class="play-circle"><i class="fa-solid fa-play"></i></div></div>
                            <span class="video-source-badge ${sourceClass(video.source)}">${esc(video.source_label || 'Video')}</span>
                            <span class="video-origin-badge">${esc(video.origin_label || '')}</span>
                            <div class="thumb-bar"></div>
                        </div>
                        <div class="video-info">
                            <h3>${esc(video.title)}</h3>
                            <div class="video-meta">
                                <div class="ch-avatar" style="background:${color}22;color:${color}">${esc(initials(video.channel))}</div>
                                <span class="ch-name">${esc(video.channel)}</span>
                                <span class="sep">-</span>
                                <span class="views">${esc(video.source_label)}</span>
                            </div>
                        </div>
                    </article>`;
            }).join('');

            grid.querySelectorAll('.video-card').forEach(card => {
                card.addEventListener('click', () => openPlayer(list[Number(card.dataset.videoIndex)]));
                card.addEventListener('keydown', event => {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        card.click();
                    }
                });
            });
        }

        function modalSrc(url) {
            if (!url) return '';
            return url + (url.includes('?') ? '&' : '?') + 'autoplay=1';
        }

        function openPlayer(video) {
            if (!video) return;
            document.getElementById('modalVideoTitle').textContent = video.title || 'Lecture';
            document.getElementById('modalVideoName').textContent = video.title || '';
            document.getElementById('modalVideoCh').textContent = [video.channel, video.source_label, video.origin_label].filter(Boolean).join(' - ');
            document.getElementById('modalFrame').innerHTML = video.is_iframe
                ? `<iframe src="${esc(modalSrc(video.play_url))}" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen title="${esc(video.title)}"></iframe>`
                : `<video src="${esc(video.play_url)}" controls autoplay playsinline></video>`;
            document.getElementById('playerModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('playerModal').classList.remove('open');
            document.getElementById('modalFrame').innerHTML = '';
            document.body.style.overflow = '';
        }

        function setSuggestions(items) {
            const box = document.getElementById('videoSuggestions');
            if (!items || !items.length) {
                box.classList.remove('is-open');
                box.innerHTML = '';
                return;
            }
            box.innerHTML = items.map(item => `<button type="button" class="suggestion">${esc(item)}</button>`).join('');
            box.classList.add('is-open');
            box.querySelectorAll('.suggestion').forEach(button => {
                button.addEventListener('click', () => {
                    const input = document.getElementById('videoSearchInput');
                    input.value = button.textContent;
                    box.classList.remove('is-open');
                    runSearch(button.textContent);
                });
            });
        }

        async function runSearch(value) {
            searchQuery = value || '';
            const url = new URL(searchUrl, window.location.origin);
            if (searchQuery) url.searchParams.set('q', searchQuery);
            if (activeFilter !== 'all') url.searchParams.set('channel', activeFilter);

            try {
                const response = await fetch(url.toString(), { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
                if (!response.ok) throw new Error('search failed');
                const payload = await response.json();
                videos = Array.isArray(payload.videos) ? payload.videos : [];
                setSuggestions(payload.suggestions || []);
                renderChannels();
                renderGrid();
            } catch (error) {
                renderGrid();
            }
        }

        document.getElementById('videoSearchInput').addEventListener('input', event => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => runSearch(event.target.value), 240);
        });
        document.getElementById('videoSearchButton').addEventListener('click', () => runSearch(document.getElementById('videoSearchInput').value));
        document.getElementById('modalClose').addEventListener('click', closeModal);
        document.getElementById('playerModal').addEventListener('click', event => { if (event.target.id === 'playerModal') closeModal(); });
        document.addEventListener('keydown', event => { if (event.key === 'Escape') closeModal(); });
        document.querySelector('[data-scroll-videos]')?.addEventListener('click', () => document.getElementById('videosAnchor').scrollIntoView({ behavior: 'smooth' }));
        document.querySelector('[data-focus-search]')?.addEventListener('click', () => document.getElementById('videoSearchInput').focus());
        document.querySelector('[data-featured-video]')?.addEventListener('click', () => openPlayer(videos[0]));

        renderChannels();
        renderGrid();
    </script>
</body>
</html>
