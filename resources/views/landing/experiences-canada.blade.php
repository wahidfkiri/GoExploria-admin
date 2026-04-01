@extends('landing.layout')

@section('title', 'Expériences Canada - Go Exploria Business')
@section('description', 'Voyages et découvertes à travers le Canada')

@section('content')
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-flag"></i>
        </div>
        <h1>Expériences Canada</h1>
        <p>Explorez la diversité et la beauté du Canada d'un océan à l'autre</p>
        <a href="#experiences" class="btn btn-cta">
            <i class="fas fa-compass me-2"></i>Découvrir le Canada
        </a>
    </div>
</section>

<section class="landing-section" style="background: var(--light-bg);" id="experiences">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Régions à Explorer</h2>
            <p class="section-subtitle">Du Pacifique à l'Atlantique, découvrez toutes les provinces</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mountain"></i>
                    </div>
                    <h3>Rocheuses Canadiennes</h3>
                    <p>Banff, Jasper et les paysages spectaculaires de l'Alberta et de la Colombie-Britannique.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-water"></i>
                    </div>
                    <h3>Côte Atlantique</h3>
                    <p>Provinces maritimes, homards frais et villages de pêcheurs pittoresques.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-city"></i>
                    </div>
                    <h3>Grandes Villes</h3>
                    <p>Toronto, Vancouver, Calgary - l'urbanité canadienne à son meilleur.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="landing-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1503614472-8c93d56e92ce?w=800&h=500&fit=crop" alt="Rocheuses">
                    <div class="gallery-overlay">
                        <h4>Parc National Banff</h4>
                        <p>Montagnes majestueuses et lacs turquoise</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=500&fit=crop" alt="Nature">
                    <div class="gallery-overlay">
                        <h4>Yukon & Territoires</h4>
                        <p>Aurores boréales et nature sauvage</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Découvrez le Canada</h2>
        <p>Des expériences uniques dans chaque province</p>
        <a href="{{url('/')}}" class="btn btn-cta">
            <i class="fas fa-suitcase me-2"></i>Planifier Mon Voyage
        </a>
    </div>
</section>
@endsection
