{{-- Témoignages d'une activité : /activity/{slug}/temoignages --}}
@extends('activities::landing.layouts.listing')

@section('title', 'Témoignages - ' . $activity->name)
@section('heading', 'Témoignages')
@section('subheading', 'Ce que disent les visiteurs de ' . $activity->name)

@section('styles')
<style>
    .quote { padding: 22px; }
    .quote .mark { color: #FF6B35; font-size: 1.6rem; }
    .quote p { color: #C7D6E6; font-size: .95rem; line-height: 1.6; margin: 10px 0 16px; }
    .who { display: flex; align-items: center; gap: 12px; }
    .who img { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; }
    .who .initials {
        width: 42px; height: 42px; border-radius: 50%; display: grid; place-items: center;
        background: rgba(255, 107, 53, .18); color: #FF8C5A; font-weight: 700;
    }
    .who strong { display: block; font-size: .95rem; }
    .who small { color: #7C93AC; }
    .stars { color: #FFC24B; font-size: .85rem; letter-spacing: 1px; }
</style>
@endsection

@section('content')
    @if($testimonials->isEmpty())
        <div class="empty">
            <i class="fas fa-comment-dots"></i>
            Aucun témoignage pour le moment.
        </div>
    @else
        <div class="cards">
            @foreach($testimonials as $testimonial)
                @php
                    $nom = $testimonial->testimonial_name ?: $testimonial->title;
                    $note = (int) ($testimonial->testimonial_rating ?? 0);
                @endphp
                <article class="card">
                    <div class="card-body quote">
                        <div class="mark"><i class="fas fa-quote-left"></i></div>
                        <p>{{ strip_tags((string) $testimonial->content) }}</p>

                        @if($note > 0)
                            <div class="stars" aria-label="{{ $note }} sur 5">
                                {{ str_repeat('★', min($note, 5)) }}{{ str_repeat('☆', max(0, 5 - $note)) }}
                            </div>
                        @endif

                        <div class="who">
                            @if($testimonial->image_url)
                                <img src="{{ $testimonial->image_url }}" alt="{{ $nom }}" loading="lazy">
                            @else
                                <span class="initials">{{ Str::upper(Str::substr($nom, 0, 1)) }}</span>
                            @endif
                            <span>
                                <strong>{{ $nom }}</strong>
                                @if($testimonial->testimonial_role)
                                    <small>{{ $testimonial->testimonial_role }}</small>
                                @endif
                            </span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
@endsection
