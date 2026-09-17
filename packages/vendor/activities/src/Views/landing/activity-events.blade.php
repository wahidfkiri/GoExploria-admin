{{-- Liste des événements d'une activité : /activity/{slug}/evenements --}}
@extends('activities::landing.layouts.listing')

@section('title', 'Événements - ' . $activity->name)
@section('heading', 'Événements')
@section('subheading', 'Les rendez-vous à venir autour de ' . $activity->name)

@section('content')
    @if($events->isEmpty())
        <div class="empty">
            <i class="fas fa-calendar-days"></i>
            Aucun événement programmé pour le moment.
        </div>
    @else
        <div class="cards">
            @foreach($events as $event)
                <a class="card" href="{{ route('landing.activity.event.show', [$activity->slug, $event->id]) }}">
                    <div class="card-cover">
                        @if($event->image_url)
                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" loading="lazy">
                        @else
                            <i class="fas fa-calendar-days"></i>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($event->event_is_free)
                            <span class="tag">Gratuit</span>
                        @elseif($event->event_price)
                            <span class="tag">{{ number_format((float) $event->event_price, 2, ',', ' ') }} $</span>
                        @endif
                        <h2 class="card-title">{{ $event->title }}</h2>
                        @if($event->content)
                            <p class="card-text">{{ Str::limit(strip_tags((string) $event->content), 110) }}</p>
                        @endif
                        <div class="card-meta">
                            @if($event->event_start_date)
                                <span><i class="fas fa-clock"></i>{{ $event->event_start_date->format('d/m/Y à H:i') }}</span>
                            @endif
                            @if($event->event_location)
                                <span><i class="fas fa-location-dot"></i>{{ $event->event_location }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="pager">{{ $events->links() }}</div>
    @endif
@endsection
