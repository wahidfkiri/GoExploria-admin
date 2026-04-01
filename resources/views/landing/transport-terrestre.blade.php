@extends('landing.layout')

@section('title', 'Transport Terrestre - Go Exploria Business')
@section('description', 'Bus, train et location de véhicules pour vos déplacements')

@section('content')
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-bus"></i>
        </div>
        <h1>Transport Terrestre</h1>
        <p>Solutions de transport flexibles pour tous vos déplacements</p>
        <a href="#services" class="btn btn-cta">
            <i class="fas fa-car me-2"></i>Réserver Maintenant
        </a>
    </div>
</section>

<section class="landing-section" style="background: var(--light-bg);" id="services">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Nos Services</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3>Location de Voitures</h3>
                    <p>Large choix de véhicules pour tous les budgets et besoins.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-train"></i>
                    </div>
                    <h3>Train VIA Rail</h3>
                    <p>Voyagez confortablement à travers le Canada en train.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bus-alt"></i>
                    </div>
                    <h3>Autobus Interurbains</h3>
                    <p>Liaisons régulières entre toutes les villes du Québec.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Réservez Votre Transport</h2>
        <p>Des solutions adaptées à tous vos besoins de déplacement</p>
        <a href="{{url('/')}}" class="btn btn-cta">
            <i class="fas fa-ticket-alt me-2"></i>Réserver
        </a>
    </div>
</section>
@endsection
