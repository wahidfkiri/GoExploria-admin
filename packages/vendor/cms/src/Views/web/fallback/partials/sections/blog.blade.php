{{-- Section Blog (DB : articles publiés) --}}
@if(is_blog_enabled($etablissement->id) && ($blogCards ?? collect())->isNotEmpty())
    @php
        $blogSectionTitle = function_exists('get_blog_section_title') ? get_blog_section_title($etablissement->id) : 'Actualités';
        $blogSectionTitle = trim((string) $blogSectionTitle) !== '' ? $blogSectionTitle : 'Actualités';
    @endphp
    <section class="lp-section" id="blog">
        <div class="container">
            <div class="lp-head">
                <div>
                    <div class="lp-kicker">Actualités</div>
                    <h2 class="lp-title">{{ $blogSectionTitle }}</h2>
                </div>
            </div>
            <div class="lp-blog-grid">
                @foreach($blogCards as $post)
                    @php
                        $blogUrl = data_get($post, 'url') ?: '#blog';
                        $isExternalBlogUrl = !\Illuminate\Support\Str::startsWith($blogUrl, '#');
                        $blogTargetAttrs = $isExternalBlogUrl ? ' target="_blank" rel="noopener noreferrer"' : '';
                        $blogTitle = data_get($post, 'title');
                        $blogImage = data_get($post, 'image');
                        $blogExcerpt = data_get($post, 'excerpt');
                    @endphp
                    <a class="lp-blog" href="{{ $blogUrl }}"{!! $blogTargetAttrs !!}>
                        <div class="lp-blog-img">
                            @if($blogImage)<img src="{{ $blogImage }}" alt="{{ $blogTitle }}">@endif
                        </div>
                        <div class="lp-blog-body">
                            <div class="lp-date">{{ data_get($post, 'date') ?: 'Blog' }}</div>
                            <h3>{{ $blogTitle }}</h3>
                            @if($blogExcerpt)<p>{{ \Illuminate\Support\Str::limit(strip_tags((string) $blogExcerpt), 130) }}</p>@endif
                            <span class="lp-blog-more">Lire la suite <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif
