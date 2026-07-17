{{-- ═══════════════════════════════════════════════════════════════════════
     Section « Blog » de la landing commerce-alimentaire.
     Affiche les derniers articles publiés si le blog est activé pour
     l'établissement. Utilise les classes .food-* définies dans
     landing-commerce-alimentaire.blade.php.
     Nécessite : $etablissement, $foodBlogPosts, $siteName.
     ═══════════════════════════════════════════════════════════════════════ --}}
@if(is_blog_enabled($etablissement->id) && $foodBlogPosts->isNotEmpty())
    @php
        $foodBlogSectionTitle = function_exists('get_blog_section_title')
            ? get_blog_section_title($etablissement->id)
            : 'Actualités et conseils gourmands';
        $foodBlogSectionTitle = trim((string) $foodBlogSectionTitle) !== '' ? $foodBlogSectionTitle : 'Actualités et conseils gourmands';
    @endphp
    <section class="food-section food-section-pad" id="blogs">
        <span class="food-kicker">Blog</span>
        <h2 class="food-title">{{ $foodBlogSectionTitle }}</h2>
        <p class="food-copy">Articles publiés par {{ $siteName }}.</p>
        <div class="food-blog-grid">
            @foreach($foodBlogPosts as $post)
                @php
                    $blogUrl = data_get($post, 'url') ?: '#';
                    $isExternalBlogUrl = \Illuminate\Support\Str::startsWith($blogUrl, ['http://', 'https://', '//']);
                    $blogTargetAttrs = $isExternalBlogUrl ? ' target="_blank" rel="noopener noreferrer"' : '';
                    $blogImage = data_get($post, 'image');
                    $blogExcerpt = \Illuminate\Support\Str::limit(strip_tags((string) (data_get($post, 'excerpt') ?: data_get($post, 'content'))), 140);
                @endphp
                <a class="food-blog-card" href="{{ $blogUrl }}"{!! $blogTargetAttrs !!}>
                    @if($blogImage)
                        <img src="{{ $blogImage }}" alt="{{ data_get($post, 'title') }}">
                    @endif
                    <div class="food-blog-body">
                        <div class="food-blog-meta">
                            <span>{{ data_get($post, 'tag') ?: 'Blog' }}</span>
                            @if(data_get($post, 'date'))
                                <span>•</span>
                                <span>{{ data_get($post, 'date') }}</span>
                            @endif
                        </div>
                        <h3>{{ data_get($post, 'title') }}</h3>
                        @if($blogExcerpt)
                            <p>{{ $blogExcerpt }}</p>
                        @endif
                        <span class="food-blog-read">Lire l'article <i class="fa-solid fa-arrow-right"></i></span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endif
