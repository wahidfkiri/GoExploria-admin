@extends('landing.layout')

@section('title', 'Locations Saisonnières - Go Exploria Business')
@section('description', 'Chalets, appartements et maisons de vacances')

@section('content')
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-key"></i>
        </div>
        <h1>Locations Saisonnières</h1>
        <p>Chalets, condos et maisons pour vos vacances en famille ou entre amis</p>
        <a href="#locations" class="btn btn-cta">
            <i class="fas fa-search me-2"></i>Trouver une Location
        </a>
    </div>
</section>

<section class="landing-section" style="background: var(--light-bg);" id="locations">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Types de Locations</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3>Chalets</h3>
                    <p>Chalets tout équipés au bord de l'eau ou en montagne.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Condos</h3>
                    <p>Appartements modernes avec toutes les commodités.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-campground"></i>
                    </div>
                    <h3>Chalets de Luxe</h3>
                    <p>Propriétés haut de gamme avec spa, sauna et vue panoramique.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Trouvez Votre Location Idéale</h2>
        <p>Des milliers de propriétés disponibles</p>
        <a href="{{url('/')}}" class="btn btn-cta">
            <i class="fas fa-home me-2"></i>Rechercher
        </a>
    </div>
</section>
@endsection
