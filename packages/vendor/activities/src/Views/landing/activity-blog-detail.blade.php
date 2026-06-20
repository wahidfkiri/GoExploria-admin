{{-- resources/views/landing/activity-blog-detail.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $blog->title }} - {{ $activity->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0A1628;
            color: #FFFFFF;
            min-height: 100vh;
        }
        .container {
            max-width: 860px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #FF6B35;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 30px;
            transition: gap 0.2s;
        }
        .back-link:hover { gap: 14px; }

        .blog-header {
            margin-bottom: 30px;
        }
        .blog-category {
            display: inline-block;
            background: #FF6B35;
            color: white;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 4px 14px;
            border-radius: 50px;
            margin-bottom: 12px;
        }
        .blog-header h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: clamp(28px, 3.5vw, 42px);
            color: white;
            margin-bottom: 12px;
        }
        .blog-meta {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 14px;
            color: rgba(255,255,255,0.4);
            flex-wrap: wrap;
        }
        .blog-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .blog-meta i { color: #FF6B35; }

        .blog-image {
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        .blog-image img {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
        }

        .blog-content {
            font-size: 16px;
            line-height: 1.8;
            color: rgba(255,255,255,0.85);
        }
        .blog-content h2 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 24px;
            color: white;
            margin: 24px 0 12px;
        }
        .blog-content h3 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 20px;
            color: white;
            margin: 20px 0 10px;
        }
        .blog-content p {
            margin-bottom: 16px;
        }
        .blog-content ul, .blog-content ol {
            margin: 16px 0 16px 24px;
        }
        .blog-content li {
            margin-bottom: 8px;
        }
        .blog-content blockquote {
            border-left: 4px solid #FF6B35;
            padding: 16px 24px;
            margin: 24px 0;
            background: rgba(255,255,255,0.04);
            border-radius: 0 8px 8px 0;
            font-style: italic;
        }

        .share-section {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }
        .share-label {
            font-size: 14px;
            font-weight: 600;
            color: rgba(255,255,255,0.4);
            margin-bottom: 12px;
        }
        .share-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .share-btn {
            width: 44px; height: 44px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 16px;
            transition: all 0.3s;
        }
        .share-btn:hover { transform: translateY(-3px); }
        .share-btn.facebook { background: #1877F2; }
        .share-btn.twitter { background: #000000; }
        .share-btn.linkedin { background: #0A66C2; }
        .share-btn.whatsapp { background: #25D366; }
        .share-btn.email { background: #6B7A99; }

        .related-section {
            margin-top: 60px;
            padding-top: 40px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }
        .related-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 22px;
            margin-bottom: 24px;
        }
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
        }
        .related-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            overflow: hidden;
            text-decoration: none;
            display: block;
            transition: all 0.3s;
        }
        .related-card:hover {
            border-color: #FF6B35;
            transform: translateY(-4px);
        }
        .related-card-img {
            height: 140px;
            background-size: cover;
            background-position: center;
        }
        .related-card-body { padding: 16px; }
        .related-card-body h4 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 14px;
            color: white;
            line-height: 1.4;
        }
        .related-card-body .meta {
            font-size: 12px;
            color: rgba(255,255,255,0.3);
            margin-top: 6px;
        }

        .footer {
            padding: 40px 0 20px;
            margin-top: 60px;
            border-top: 1px solid rgba(255,255,255,0.06);
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }
        .footer p {
            color: rgba(255,255,255,0.3);
            font-size: 13px;
        }
        .footer .socials {
            display: flex;
            gap: 12px;
        }
        .footer .socials a {
            color: rgba(255,255,255,0.3);
            font-size: 18px;
            transition: color 0.2s;
        }
        .footer .socials a:hover { color: #FF6B35; }

        @media (max-width: 768px) {
            .related-grid { grid-template-columns: 1fr; }
            .footer { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Back Link -->
    <a href="{{ route('landing.activity.show', $activity->slug) }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Retour à l'activité
    </a>

    <!-- Blog Header -->
    <div class="blog-header">
        @if($blog->blog_category)
        <span class="blog-category">{{ $blog->blog_category }}</span>
        @endif
        <h1>{{ $blog->title }}</h1>
        <div class="blog-meta">
            @if($blog->blog_author)
            <span><i class="fas fa-user"></i> {{ $blog->blog_author }}</span>
            @endif
            <span><i class="fas fa-calendar"></i> {{ $blog->published_at ? $blog->published_at->format('d F Y') : $blog->created_at->format('d F Y') }}</span>
            @if($blog->views)
            <span><i class="fas fa-eye"></i> {{ number_format($blog->views) }} vues</span>
            @endif
        </div>
    </div>

    <!-- Blog Image -->
    @if($blog->image_url)
    <div class="blog-image">
        <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}">
    </div>
    @endif

    <!-- Blog Content -->
    <div class="blog-content">
        {!! $blog->content !!}
    </div>

    <!-- Share -->
    <div class="share-section">
        <div class="share-label">Partager cet article</div>
        <div class="share-buttons">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share-btn facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="share-btn twitter"><i class="fab fa-twitter"></i></a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="share-btn linkedin"><i class="fab fa-linkedin-in"></i></a>
            <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' - ' . url()->current()) }}" target="_blank" class="share-btn whatsapp"><i class="fab fa-whatsapp"></i></a>
            <a href="mailto:?subject={{ urlencode($blog->title) }}&body={{ urlencode('Découvrez cet article : ' . url()->current()) }}" class="share-btn email"><i class="fas fa-envelope"></i></a>
        </div>
    </div>

    <!-- Related Blogs -->
    @if($relatedBlogs->count() > 0)
    <div class="related-section">
        <h3 class="related-title">Articles similaires</h3>
        <div class="related-grid">
            @foreach($relatedBlogs as $related)
            <a href="{{ route('landing.activity.blog.show', [$activity->slug, $related->id]) }}" class="related-card">
                <div class="related-card-img" style="background-image:url('{{ $related->image_url ?? 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=400&q=80' }}')"></div>
                <div class="related-card-body">
                    <h4>{{ $related->title }}</h4>
                    <div class="meta">{{ $related->published_at ? $related->published_at->format('d/m/Y') : $related->created_at->format('d/m/Y') }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 ActiveZone. Tous droits réservés.</p>
        <div class="socials">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
</div>

</body>
</html>