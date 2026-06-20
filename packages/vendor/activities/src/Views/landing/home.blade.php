{{-- resources/views/landing/home.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>ActiveZone - Toutes les activités</title>
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .header {
            text-align: center;
            padding: 60px 0 40px;
        }
        .header h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 48px;
            background: linear-gradient(135deg, #FF6B35, #FFB800);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .header p {
            color: rgba(255,255,255,0.6);
            font-size: 18px;
            margin-top: 12px;
        }
        .activities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }
        .activity-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s;
            text-decoration: none;
            display: block;
        }
        .activity-card:hover {
            transform: translateY(-8px);
            border-color: #FF6B35;
            box-shadow: 0 12px 40px rgba(255,107,53,0.2);
        }
        .activity-card-img {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .activity-card-img .badge {
            position: absolute;
            top: 16px; right: 16px;
            background: #FF6B35;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .activity-card-body {
            padding: 24px;
        }
        .activity-card-body h3 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 8px;
            color: #FFFFFF;
        }
        .activity-card-body p {
            color: rgba(255,255,255,0.6);
            font-size: 14px;
            line-height: 1.6;
        }
        .activity-card-body .link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
            color: #FF6B35;
            font-weight: 600;
            font-size: 14px;
            transition: gap 0.3s;
        }
        .activity-card-body .link:hover { gap: 14px; }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            grid-column: 1 / -1;
        }
        .empty-state i {
            font-size: 64px;
            color: rgba(255,255,255,0.1);
            margin-bottom: 16px;
        }
        .empty-state h3 {
            font-family: 'Montserrat', sans-serif;
            font-size: 24px;
            margin-bottom: 8px;
        }
        .empty-state p { color: rgba(255,255,255,0.5); }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏔️ ActiveZone</h1>
            <p>Découvrez toutes nos activités outdoor</p>
        </div>

        <div class="activities-grid">
            @forelse($activities as $activity)
            <a href="{{ route('landing.activity.show', $activity->slug) }}" class="activity-card">
                <div class="activity-card-img" style="background-image:url('{{ $activity->image ? asset('storage/' . $activity->image) : 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=600&q=80' }}')">
                    <span class="badge">{{ $activity->categoryRelation->name ?? 'Activité' }}</span>
                </div>
                <div class="activity-card-body">
                    <h3>{{ $activity->name }}</h3>
                    <p>{{ Str::limit($activity->description ?? 'Découvrez cette activité unique', 80) }}</p>
                    <span class="link">Voir l'activité <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            @empty
            <div class="empty-state">
                <i class="fas fa-mountain"></i>
                <h3>Aucune activité disponible</h3>
                <p>Revenez bientôt pour découvrir nos activités.</p>
            </div>
            @endforelse
        </div>
    </div>
</body>
</html>