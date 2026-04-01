@extends('landing.layout')

@section('title', 'Assurances Voyage - Go Exploria Business')
@section('description', 'Voyagez en toute sécurité avec nos assurances voyage')

@section('content')
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-shield-alt"></i>
        </div>
        <h1>Assurances Voyage</h1>
        <p>Protégez-vous et voyagez l'esprit tranquille</p>
        <a href="#assurances" class="btn btn-cta">
            <i class="fas fa-umbrella me-2"></i>Obtenir une Soumission
        </a>
    </div>
</section>

<section class="landing-section" style="background: var(--light-bg);" id="assurances">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Nos Protections</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3>Assurance Médicale</h3>
                    <p>Couverture médicale complète en cas d'urgence pendant votre voyage.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-undo"></i>
                    </div>
                    <h3>Annulation</h3>
                    <p>Remboursement en cas d'annulation pour raison valable.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-suitcase"></i>
                    </div>
                    <h3>Bagages</h3>
                    <p>Protection contre la perte, le vol ou les dommages de vos bagages.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Protégez Votre Voyage</h2>
        <p>Une assurance adaptée à vos besoins</p>
        <a href="{{url('/')}}" class="btn btn-cta">
            <i class="fas fa-file-contract me-2"></i>Demander une Soumission
        </a>
    </div>
</section>
@endsection
