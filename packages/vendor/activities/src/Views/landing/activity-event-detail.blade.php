{{-- resources/views/landing/activity-event-detail.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $event->title }} - {{ $activity->name }}</title>
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
            max-width: 900px;
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

        .event-header {
            margin-bottom: 30px;
        }
        .event-header h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: clamp(28px, 3.5vw, 42px);
            color: white;
            margin-bottom: 16px;
        }
        .event-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 30px;
        }
        .event-meta .item {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .event-meta .item i {
            color: #FF6B35;
            font-size: 18px;
            width: 24px;
        }
        .event-meta .item .label {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .event-meta .item .value {
            font-weight: 500;
            color: white;
        }

        .event-image {
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        .event-image img {
            width: 100%;
            height: auto;
            max-height: 450px;
            object-fit: cover;
        }

        .event-content {
            font-size: 16px;
            line-height: 1.8;
            color: rgba(255,255,255,0.85);
        }
        .event-content h2 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 24px;
            color: white;
            margin: 24px 0 12px;
        }
        .event-content p {
            margin-bottom: 16px;
        }

        .register-btn {
            display: inline-block;
            background: #FF6B35;
            color: white;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.3s;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }
        .register-btn:hover {
            background: #FF8C5A;
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(255,107,53,0.4);
        }

        /* ===== RELATED ===== */
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
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .related-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 20px;
            text-decoration: none;
            display: block;
            transition: all 0.3s;
        }
        .related-card:hover {
            border-color: #FF6B35;
            transform: translateY(-4px);
        }
        .related-card .date {
            font-size: 12px;
            color: #FF6B35;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .related-card h4 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 15px;
            color: white;
            margin-bottom: 4px;
        }
        .related-card .location {
            font-size: 13px;
            color: rgba(255,255,255,0.4);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ===== EMPTY ===== */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: rgba(255,255,255,0.4);
        }
        .empty-state i {
            font-size: 48px;
            color: rgba(255,255,255,0.05);
            margin-bottom: 16px;
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
            .event-meta { grid-template-columns: 1fr; }
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

    <!-- Event Header -->
    <div class="event-header">
        <h1>{{ $event->title }}</h1>

        <div class="event-meta">
            @if($event->event_start_date)
            <div class="item">
                <i class="fas fa-calendar"></i>
                <div>
                    <div class="label">Date</div>
                    <div class="value">{{ $event->event_start_date->format('d F Y') }}</div>
                </div>
            </div>
            @endif

            @if($event->event_location)
            <div class="item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <div class="label">Lieu</div>
                    <div class="value">{{ $event->event_location }}</div>
                </div>
            </div>
            @endif

            @if($event->event_capacity)
            <div class="item">
                <i class="fas fa-users"></i>
                <div>
                    <div class="label">Capacité</div>
                    <div class="value">{{ $event->event_capacity }} personnes</div>
                </div>
            </div>
            @endif

            <div class="item">
                <i class="fas fa-ticket-alt"></i>
                <div>
                    <div class="label">Tarif</div>
                    <div class="value">
                        @if($event->event_is_free)
                            <span style="color:#10b981;font-weight:600;">Gratuit</span>
                        @else
                            {{ number_format($event->event_price ?? 0, 0, ',', ' ') }} €
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Image -->
    @if($event->image_url)
    <div class="event-image">
        <img src="{{ $event->image_url }}" alt="{{ $event->title }}">
    </div>
    @endif

    <!-- Event Content -->
    <div class="event-content">
        {!! $event->content !!}

        <a href="#" class="register-btn">
            <i class="fas fa-check-circle"></i> Je m'inscris à cet événement
        </a>
    </div>

    <!-- Related Events -->
    @if($relatedEvents->count() > 0)
    <div class="related-section">
        <h3 class="related-title">Événements similaires</h3>
        <div class="related-grid">
            @foreach($relatedEvents as $related)
            <a href="{{ route('landing.activity.event.show', [$activity->slug, $related->id]) }}" class="related-card">
                <div class="date">{{ $related->event_start_date ? $related->event_start_date->format('d F') : 'Date' }}</div>
                <h4>{{ $related->title }}</h4>
                @if($related->event_location)
                <div class="location"><i class="fas fa-map-marker-alt"></i> {{ $related->event_location }}</div>
                @endif
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


{{-- Popup publicitaire rotatif (Ads Manager) : même zone bas-droite que
     l'accueil et les pages destination. --}}
@include('components.ads-popup', ['adContext' => 'activities'])

</body>
</html>