@extends('landing.layout')

@section('title', 'Transport Maritime - Go Exploria Business')
@section('description', 'Croisières et traversiers pour vos voyages maritimes')

@section('content')
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-ship"></i>
        </div>
        <h1>Transport Maritime</h1>
        <p>Croisières et traversiers pour des voyages inoubliables</p>
        <a href="#services" class="btn btn-cta">
            <i class="fas fa-anchor me-2"></i>Explorer les Croisières
        </a>
    </div>
</section>

<section class="landing-section" style="background: var(--light-bg);" id="services">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Services Maritimes</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-ship"></i>
                    </div>
                    <h3>Croisières Fleuve Saint-Laurent</h3>
                    <p>Découvrez le Québec depuis le fleuve avec nos croisières d'observation.</p>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-ferry"></i>
                    </div>
                    <h3>Traversiers</h3>
                    <p>Liaisons régulières entre les deux rives et vers les îles.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Embarquez pour l'Aventure</h2>
        <p>Des expériences maritimes uniques vous attendent</p>
        <a href="{{url('/')}}" class="btn btn-cta">
            <i class="fas fa-ship me-2"></i>Réserver une Croisière
        </a>
    </div>
</section>
@endsection
