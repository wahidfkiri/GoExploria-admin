@extends('landing.layout')

@section('title', 'Hôtels - Go Exploria Business')
@section('description', 'Réservez votre hébergement en hôtel aux meilleurs prix')

@section('content')
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-hotel"></i>
        </div>
        <h1>Hôtels & Hébergements</h1>
        <p>Trouvez l'hôtel parfait pour votre séjour parmi des milliers d'options</p>
        <a href="#hotels" class="btn btn-cta">
            <i class="fas fa-bed me-2"></i>Réserver un Hôtel
        </a>
    </div>
</section>

<section class="landing-section" style="background: var(--light-bg);" id="hotels">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Types d'Hébergement</h2>
            <p class="section-subtitle">Du budget au luxe, trouvez l'hébergement qui vous convient</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3>Hôtels 5 Étoiles</h3>
                    <p>Luxe et raffinement dans les plus beaux établissements du Québec.</p>
                    <ul class="list-unstyled mt-3">
                        <li><i class="fas fa-check text-success me-2"></i>Spa & Wellness</li>
                        <li><i class="fas fa-check text-success me-2"></i>Restaurants gastronomiques</li>
                        <li><i class="fas fa-check text-success me-2"></i>Service de conciergerie</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Hôtels Boutique</h3>
                    <p>Charme et authenticité dans des hôtels de caractère uniques.</p>
                    <ul class="list-unstyled mt-3">
                        <li><i class="fas fa-check text-success me-2"></i>Design unique</li>
                        <li><i class="fas fa-check text-success me-2"></i>Service personnalisé</li>
                        <li><i class="fas fa-check text-success me-2"></i>Ambiance locale</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <h3>Hôtels Économiques</h3>
                    <p>Confort et qualité à prix abordable pour tous les budgets.</p>
                    <ul class="list-unstyled mt-3">
                        <li><i class="fas fa-check text-success me-2"></i>Petit-déjeuner inclus</li>
                        <li><i class="fas fa-check text-success me-2"></i>WiFi gratuit</li>
                        <li><i class="fas fa-check text-success me-2"></i>Stationnement</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="landing-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Hôtels Recommandés</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&h=500&fit=crop" alt="Hôtel Luxe">
                    <div class="gallery-overlay">
                        <h4>Fairmont Le Château Frontenac</h4>
                        <p>5 étoiles • Vieux-Québec • À partir de 299$/nuit</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&h=500&fit=crop" alt="Hôtel Boutique">
                    <div class="gallery-overlay">
                        <h4>Hôtel Le Germain</h4>
                        <p>4 étoiles • Montréal • À partir de 189$/nuit</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Trouvez Votre Hôtel Idéal</h2>
        <p>Des milliers d'hôtels vérifiés et notés par nos clients</p>
        <a href="{{url('/')}}" class="btn btn-cta">
            <i class="fas fa-search me-2"></i>Rechercher un Hôtel
        </a>
    </div>
</section>
@endsection
