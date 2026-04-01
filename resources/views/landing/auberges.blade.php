@extends('landing.layout')

@section('title', 'Auberges - Go Exploria Business')
@section('description', 'Séjournez dans nos auberges chaleureuses')

@section('content')
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-home"></i>
        </div>
        <h1>Auberges & Gîtes</h1>
        <p>L'hospitalité québécoise dans une ambiance chaleureuse et authentique</p>
        <a href="#auberges" class="btn btn-cta">
            <i class="fas fa-bed me-2"></i>Trouver une Auberge
        </a>
    </div>
</section>

<section class="landing-section" style="background: var(--light-bg);" id="auberges">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Nos Auberges</h2>
            <p class="section-subtitle">Charme, confort et accueil personnalisé</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-coffee"></i>
                    </div>
                    <h3>Petit-Déjeuner Inclus</h3>
                    <p>Savourez un petit-déjeuner maison avec produits locaux chaque matin.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Ambiance Familiale</h3>
                    <p>Rencontrez d'autres voyageurs et partagez vos expériences.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3>Conseils Locaux</h3>
                    <p>Profitez des recommandations de vos hôtes pour découvrir la région.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Vivez l'Expérience Auberge</h2>
        <p>Un séjour authentique et convivial</p>
        <a href="{{url('/')}}" class="btn btn-cta">
            <i class="fas fa-calendar-check me-2"></i>Réserver
        </a>
    </div>
</section>
@endsection
