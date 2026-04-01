@extends('landing.layout')

@section('title', 'Destinations Populaires - Go Exploria Business')
@section('description', 'Découvrez nos destinations les plus populaires au Québec et au Canada')

@section('content')
<!-- Hero Section -->
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-globe-americas"></i>
        </div>
        <h1>Destinations Populaires</h1>
        <p>Explorez les plus belles destinations du Québec et du Canada</p>
        <a href="#destinations" class="btn btn-cta">
            <i class="fas fa-map-marked-alt me-2"></i>Découvrir
        </a>
    </div>
</section>

<!-- Destinations Section -->
<section class="landing-section" id="destinations">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Top Destinations</h2>
            <p class="section-subtitle">Les lieux incontournables à visiter</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1517935706615-2717063c2225?w=800&h=500&fit=crop" alt="Québec City">
                    <div class="gallery-overlay">
                        <h4>Ville de Québec</h4>
                        <p>Patrimoine mondial de l'UNESCO • Château Frontenac • Vieux-Québec</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=800&h=500&fit=crop" alt="Montréal">
                    <div class="gallery-overlay">
                        <h4>Montréal</h4>
                        <p>Métropole culturelle • Festivals • Gastronomie</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&h=400&fit=crop" alt="Charlevoix">
                    <div class="gallery-overlay">
                        <h4>Charlevoix</h4>
                        <p>Paysages époustouflants</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1503614472-8c93d56e92ce?w=600&h=400&fit=crop" alt="Gaspésie">
                    <div class="gallery-overlay">
                        <h4>Gaspésie</h4>
                        <p>Rocher Percé • Nature sauvage</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?w=600&h=400&fit=crop" alt="Laurentides">
                    <div class="gallery-overlay">
                        <h4>Laurentides</h4>
                        <p>Ski • Spa • Villégiature</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="landing-section" style="background: var(--light-bg);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Pourquoi Choisir Nos Destinations ?</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-3">
                <div class="feature-card text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Sécurité Garantie</h3>
                    <p>Destinations sûres et vérifiées</p>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="feature-card text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3>Qualité Premium</h3>
                    <p>Hébergements et services 4-5 étoiles</p>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="feature-card text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Support 24/7</h3>
                    <p>Assistance disponible en tout temps</p>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="feature-card text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <h3>Meilleur Prix</h3>
                    <p>Garantie du prix le plus bas</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Choisissez Votre Prochaine Destination</h2>
        <p>Des centaines de destinations vous attendent</p>
        <a href="{{url('/')}}" class="btn btn-cta">
            <i class="fas fa-suitcase me-2"></i>Planifier Mon Voyage
        </a>
    </div>
</section>
@endsection
