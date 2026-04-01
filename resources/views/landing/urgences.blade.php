@extends('landing.layout')

@section('title', 'Assistance Urgence - Go Exploria Business')
@section('description', 'Support et assistance 24/7 pour vos urgences en voyage')

@section('content')
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-ambulance"></i>
        </div>
        <h1>Assistance Urgence 24/7</h1>
        <p>Une équipe disponible en tout temps pour vous aider</p>
        <a href="#services" class="btn btn-cta">
            <i class="fas fa-phone me-2"></i>Nous Contacter
        </a>
    </div>
</section>

<section class="landing-section" style="background: var(--light-bg);" id="services">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Services d'Urgence</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-phone-volume"></i>
                    </div>
                    <h3>Ligne d'Urgence</h3>
                    <p>Disponible 24h/24, 7j/7</p>
                    <h4 class="text-primary mt-3">1-800-URGENCE</h4>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <h3>Assistance Médicale</h3>
                    <p>Coordination avec les services médicaux locaux</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-plane"></i>
                    </div>
                    <h3>Rapatriement</h3>
                    <p>Organisation du retour en cas d'urgence</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Nous Sommes Là Pour Vous</h2>
        <p>Une assistance rapide et efficace en toutes circonstances</p>
        <a href="tel:18005257748" class="btn btn-cta">
            <i class="fas fa-phone-alt me-2"></i>Appeler Maintenant
        </a>
    </div>
</section>
@endsection
