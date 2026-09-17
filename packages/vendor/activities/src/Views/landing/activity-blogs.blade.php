{{-- Liste des articles d'une activité : /activity/{slug}/blog --}}
@extends('activities::landing.layouts.listing')

@section('title', 'Blog - ' . $activity->name)
@section('heading', 'Blog')
@section('subheading', 'Les articles publiés autour de ' . $activity->name)

@section('content')
    @if($blogs->isEmpty())
        <div class="empty">
            <i class="fas fa-newspaper"></i>
            Aucun article pour le moment.
        </div>
    @else
        <div class="cards">
            @foreach($blogs as $blog)
                <a class="card" href="{{ route('landing.activity.blog.show', [$activity->slug, $blog->id]) }}">
                    <div class="card-cover">
                        @if($blog->image_url)
                            <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" loading="lazy">
                        @else
                            <i class="fas fa-newspaper"></i>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($blog->blog_category)
                            <span class="tag">{{ $blog->blog_category }}</span>
                        @endif
                        <h2 class="card-title">{{ $blog->title }}</h2>
                        @php
                            $extrait = $blog->blog_excerpt ?: strip_tags((string) $blog->content);
                        @endphp
                        @if($extrait !== '')
                            <p class="card-text">{{ Str::limit($extrait, 120) }}</p>
                        @endif
                        <div class="card-meta">
                            @if($blog->blog_author)
                                <span><i class="fas fa-user"></i>{{ $blog->blog_author }}</span>
                            @endif
                            <span><i class="fas fa-calendar"></i>{{ ($blog->published_at ?: $blog->created_at)?->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="pager">{{ $blogs->links() }}</div>
    @endif
@endsection
