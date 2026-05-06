@php
    $tr = static function (string $text): string {
        $locale = app()->getLocale();
        if ($locale === 'fr') return $text;
        static $maps = [];
        if (!array_key_exists($locale, $maps)) {
            $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
            $maps[$locale] = is_file($path) ? (require $path) : [];
        }
        return $maps[$locale][$text] ?? $text;
    };
@endphp

<section class="blog-space-section" id="espace-blog">
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="https://wowtheme7.com/tf/kiante/home.html" class="resto-accord-btn" title="Inspiration Kiante" target="_blank" rel="noopener noreferrer">
                    <div class="logo-wrapper">
                        <img src="https://images.unsplash.com/photo-1495020689067-958852a7765e?w=200&h=200&fit=crop" alt="Magazine style">
                    </div>
                    <span class="resto-accord-btn-label">Blog Magazine</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-external-link-alt"></i> Inspiration</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('ESPACE BLOG EDITORIAL') }}</h1>
                <p class="resto-header-subtitle">{{ $tr('Layout inspire du top-news-area: hero story, colonne breaking news et cartes categories modernes.') }}</p>
                <div class="resto-header-tabs">
                    <button class="resto-tab-btn active" data-blog-filter="all">{{ $tr('Tous') }}</button>
                    <button class="resto-tab-btn" data-blog-filter="business">Business</button>
                    <button class="resto-tab-btn" data-blog-filter="travel">Travel</button>
                    <button class="resto-tab-btn" data-blog-filter="tech">Tech</button>
                </div>
            </div>
            <div class="resto-header-logo-right">
                <a href="#" class="resto-accord-btn" title="Publication Rapide">
                    <div class="logo-wrapper">
                        <img src="https://images.unsplash.com/photo-1455390582262-044cdead277a?w=200&h=200&fit=crop" alt="Writing desk">
                    </div>
                    <span class="resto-accord-btn-label">Publication</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-rss"></i> Daily</span>
                </a>
            </div>
        </div>
        <div class="resto-header-destinations-bar">
            <div class="resto-dest-row">
                <div class="resto-dest-icon-box">
                    <img src="{{ asset('REDI.png') }}" alt="{{ $tr('Destinations') }}">
                    <span>{{ $tr('Destinations') }}</span>
                </div>
                <div class="resto-dest-breadcrumb">
                    <a href="#" class="resto-dest-link active">{{ $tr('Toutes destinations') }}</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">{{ $tr('Amérique du Nord') }}</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">{{ $tr('Canada') }}</a>
                    <span class="resto-dest-sep">/</span>
                    <a href="#" class="resto-dest-link">{{ $tr('Québec') }}</a>
                </div>
            </div>
        </div>
        <div class="resto-header-shimmer"></div>
    </div>

    <div class="blog-space-container">
        <div class="blog-top-news-area">
            <article class="blog-featured-story" data-blog-type="business">
                <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?w=1400&h=700&fit=crop" alt="Story principale business">
                <div class="blog-featured-overlay">
                    <span class="blog-chip">Business</span>
                    <div class="blog-post-meta">
                        <span><i class="fas fa-user-edit"></i> Stiven Jackson</span>
                        <span><i class="fas fa-calendar-alt"></i> Mar 16, 2026</span>
                        <span><i class="fas fa-tags"></i> Growth, Marketing</span>
                    </div>
                    <h3>Small businesses expect strong revenue growth in 2026</h3>
                    <p>Analyse des tendances de croissance, marketing d'influence et digital acceleration.</p>
                    <div class="blog-share-row">
                        <span class="blog-share-label"><i class="fas fa-share-alt"></i> Partager</span>
                        <div class="blog-social-icons">
                            <a href="#" aria-label="Partager sur Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" aria-label="Partager sur X"><i class="fab fa-x-twitter"></i></a>
                            <a href="#" aria-label="Partager sur LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" aria-label="Partager sur Instagram"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </article>

            <aside class="blog-breaking-column">
                <h4>Breaking News</h4>
                <article class="blog-mini-post" data-blog-type="business">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=300&h=180&fit=crop" alt="Marketing">
                    <div>
                        <span>Marketing</span>
                        <small><i class="fas fa-user"></i> Kiante Desk</small>
                        <small><i class="fas fa-calendar"></i> Mar 16, 2026</small>
                        <p>B2B CMOs increase media spend and influencer strategies</p>
                    </div>
                </article>
                <article class="blog-mini-post" data-blog-type="tech">
                    <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?w=300&h=180&fit=crop" alt="Tech">
                    <div>
                        <span>Tech</span>
                        <small><i class="fas fa-user"></i> Editorial Team</small>
                        <small><i class="fas fa-calendar"></i> Mar 15, 2026</small>
                        <p>AI copilots transform newsroom workflows and publishing speed</p>
                    </div>
                </article>
                <article class="blog-mini-post" data-blog-type="travel">
                    <img src="https://images.unsplash.com/photo-1527631746610-bca00a040d60?w=300&h=180&fit=crop" alt="Travel">
                    <div>
                        <span>Travel</span>
                        <small><i class="fas fa-user"></i> Sarah Miller</small>
                        <small><i class="fas fa-calendar"></i> Mar 14, 2026</small>
                        <p>Workation demand grows for remote teams across destinations</p>
                    </div>
                </article>
            </aside>
        </div>

        <div class="blog-top-news-categories">
            <span>Business</span>
            <span>Marketing</span>
            <span>Technology</span>
            <span>Travel</span>
            <span>Politics</span>
            <span>Features</span>
        </div>

        <div class="blog-posts-grid" id="blogPostsGrid">
            <article class="blog-post-card" data-blog-type="travel">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=640&h=360&fit=crop" alt="Travel news">
                <div class="blog-post-body">
                    <span>Travel</span>
                    <h4>Remote travel trends and flexible work escapes</h4>
                    <div class="blog-card-meta">
                        <span><i class="fas fa-user"></i> Nora Adams</span>
                        <span><i class="fas fa-calendar-alt"></i> Mar 14, 2026</span>
                    </div>
                    <div class="blog-card-tags">
                        <a href="#">#workation</a>
                        <a href="#">#travel</a>
                    </div>
                    <div class="blog-card-share">
                        <span><i class="fas fa-share-alt"></i> Partager</span>
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="X"><i class="fab fa-x-twitter"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </article>
            <article class="blog-post-card" data-blog-type="tech">
                <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=640&h=360&fit=crop" alt="Tech news">
                <div class="blog-post-body">
                    <span>Tech</span>
                    <h4>AI copilots reshape content teams and publishing speed</h4>
                    <div class="blog-card-meta">
                        <span><i class="fas fa-user"></i> Omar Reed</span>
                        <span><i class="fas fa-calendar-alt"></i> Mar 13, 2026</span>
                    </div>
                    <div class="blog-card-tags">
                        <a href="#">#ai</a>
                        <a href="#">#media</a>
                    </div>
                    <div class="blog-card-share">
                        <span><i class="fas fa-share-alt"></i> Partager</span>
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="X"><i class="fab fa-x-twitter"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </article>
            <article class="blog-post-card" data-blog-type="business">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=640&h=360&fit=crop" alt="Business growth">
                <div class="blog-post-body">
                    <span>Business</span>
                    <h4>International breweries attract new young entrepreneurs</h4>
                    <div class="blog-card-meta">
                        <span><i class="fas fa-user"></i> Emma Scott</span>
                        <span><i class="fas fa-calendar-alt"></i> Mar 12, 2026</span>
                    </div>
                    <div class="blog-card-tags">
                        <a href="#">#business</a>
                        <a href="#">#startup</a>
                    </div>
                    <div class="blog-card-share">
                        <span><i class="fas fa-share-alt"></i> Partager</span>
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="X"><i class="fab fa-x-twitter"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>
