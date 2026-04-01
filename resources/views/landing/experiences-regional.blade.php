@extends('landing.layout')

@section('title', 'Expériences Régional - Go Exploria Business')
@section('description', 'Explorez les trésors cachés de votre région')

@section('content')
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-map-signs"></i>
        </div>
        <h1>Expériences Régional</h1>
        <p>Découvrez les trésors cachés près de chez vous</p>
        <a href="#regions" class="btn btn-cta">
            <i class="fas fa-location-arrow me-2"></i>Explorer Ma Région
        </a>
    </div>
</section>

<section class="landing-section" style="background: var(--light-bg);" id="regions">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Régions du Québec</h2>
            <p class="section-subtitle">Chaque région a ses particularités et ses attraits</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tree"></i>
                    </div>
                    <h3>Laurentides</h3>
                    <p>Ski, spa et villégiature à moins d'une heure de Montréal.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-fish"></i>
                    </div>
                    <h3>Gaspésie</h3>
                    <p>Rocher Percé, fruits de mer et paysages maritimes époustouflants.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-wine-glass-alt"></i>
                    </div>
                    <h3>Cantons-de-l'Est</h3>
                    <p>Vignobles, gastronomie et villages pittoresques.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-ship"></i>
                    </div>
                    <h3>Charlevoix</h3>
                    <p>Paysages à couper le souffle et cuisine régionale raffinée.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tractor"></i>
                    </div>
                    <h3>Montérégie</h3>
                    <p>Agrotourisme, vergers et produits du terroir.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-snowflake"></i>
                    </div>
                    <h3>Saguenay-Lac-Saint-Jean</h3>
                    <p>Fjord majestueux et traditions québécoises authentiques.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Explorez Votre Région</h2>
        <p>Des découvertes à deux pas de chez vous</p>
        <a href="{{url('/')}}" class="btn btn-cta">
            <i class="fas fa-route me-2"></i>Trouver des Activités
        </a>
    </div>
</section>
@endsection
