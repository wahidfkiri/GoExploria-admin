@extends('landing.layout')

@section('title', 'Transport Aérien - Go Exploria Business')
@section('description', 'Réservez vos vols et billets d\'avion aux meilleurs prix')

@section('content')
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-plane"></i>
        </div>
        <h1>Transport Aérien</h1>
        <p>Réservez vos vols aux meilleurs prix avec nos partenaires aériens</p>
        <a href="#services" class="btn btn-cta">
            <i class="fas fa-ticket-alt me-2"></i>Réserver un Vol
        </a>
    </div>
</section>

<section class="landing-section" style="background: var(--light-bg);" id="services">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Nos Services Aériens</h2>
            <p class="section-subtitle">Des solutions de transport adaptées à tous vos besoins</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-plane-departure"></i>
                    </div>
                    <h3>Vols Réguliers</h3>
                    <p>Accès à des milliers de vols quotidiens vers toutes les destinations au Canada et internationales.</p>
                    <ul class="list-unstyled mt-3">
                        <li><i class="fas fa-check text-success me-2"></i>Air Canada</li>
                        <li><i class="fas fa-check text-success me-2"></i>WestJet</li>
                        <li><i class="fas fa-check text-success me-2"></i>Air Transat</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <h3>Classe Affaires</h3>
                    <p>Voyagez confortablement en classe affaires avec accès aux salons VIP et services premium.</p>
                    <ul class="list-unstyled mt-3">
                        <li><i class="fas fa-check text-success me-2"></i>Sièges inclinables</li>
                        <li><i class="fas fa-check text-success me-2"></i>Repas gastronomiques</li>
                        <li><i class="fas fa-check text-success me-2"></i>Salons VIP</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Vols de Groupe</h3>
                    <p>Tarifs spéciaux pour les groupes de 10 personnes et plus avec services personnalisés.</p>
                    <ul class="list-unstyled mt-3">
                        <li><i class="fas fa-check text-success me-2"></i>Tarifs réduits</li>
                        <li><i class="fas fa-check text-success me-2"></i>Coordination simplifiée</li>
                        <li><i class="fas fa-check text-success me-2"></i>Assistance dédiée</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="landing-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Destinations Populaires</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-3">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1517935706615-2717063c2225?w=400&h=300&fit=crop" alt="Québec">
                    <div class="gallery-overlay">
                        <h4>Québec</h4>
                        <p>À partir de 149$</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=400&h=300&fit=crop" alt="Montréal">
                    <div class="gallery-overlay">
                        <h4>Montréal</h4>
                        <p>À partir de 129$</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1503614472-8c93d56e92ce?w=400&h=300&fit=crop" alt="Vancouver">
                    <div class="gallery-overlay">
                        <h4>Vancouver</h4>
                        <p>À partir de 399$</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop" alt="Calgary">
                    <div class="gallery-overlay">
                        <h4>Calgary</h4>
                        <p>À partir de 349$</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Réservez Votre Vol Aujourd'hui</h2>
        <p>Les meilleurs tarifs aériens vous attendent</p>
        <a href="{{url('/')}}" class="btn btn-cta">
            <i class="fas fa-plane me-2"></i>Rechercher un Vol
        </a>
    </div>
</section>
@endsection
