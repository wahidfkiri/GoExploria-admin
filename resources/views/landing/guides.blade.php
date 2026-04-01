@extends('landing.layout')

@section('title', 'Guides Touristiques - Go Exploria Business')
@section('description', 'Découvrez nos guides experts locaux')

@section('content')
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-user-tie"></i>
        </div>
        <h1>Guides Touristiques</h1>
        <p>Des experts passionnés pour enrichir votre expérience</p>
        <a href="#guides" class="btn btn-cta">
            <i class="fas fa-users me-2"></i>Réserver un Guide
        </a>
    </div>
</section>

<section class="landing-section" style="background: var(--light-bg);" id="guides">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Nos Services de Guidage</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-walking"></i>
                    </div>
                    <h3>Visites Guidées</h3>
                    <p>Tours à pied dans les quartiers historiques avec guides certifiés.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hiking"></i>
                    </div>
                    <h3>Randonnées Nature</h3>
                    <p>Guides naturalistes pour découvrir la faune et la flore.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3>Tours Gastronomiques</h3>
                    <p>Découvrez les saveurs locales avec nos guides culinaires.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Réservez Votre Guide</h2>
        <p>Une expérience enrichissante avec nos experts</p>
        <a href="{{url('/')}}" class="btn btn-cta">
            <i class="fas fa-calendar-alt me-2"></i>Réserver
        </a>
    </div>
</section>
@endsection
