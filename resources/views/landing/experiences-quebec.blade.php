@extends('landing.layout')

@section('title', 'Expériences Québec - Go Exploria Business')
@section('description', 'Découvrez les meilleures activités et expériences au Québec')

@section('content')
<!-- Hero Section -->
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-map-marked-alt"></i>
        </div>
        <h1>Expériences Québec</h1>
        <p>Découvrez les meilleures activités et expériences au cœur du Québec</p>
        <a href="#experiences" class="btn btn-cta">
            <i class="fas fa-compass me-2"></i>Explorer maintenant
        </a>
    </div>
</section>

<!-- Features Section -->
<section class="landing-section" style="background: var(--light-bg);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Nos Expériences Populaires</h2>
            <p class="section-subtitle">Des activités inoubliables pour tous les goûts</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-skiing"></i>
                    </div>
                    <h3>Sports d'Hiver</h3>
                    <p>Profitez des meilleures stations de ski du Québec. Ski alpin, planche à neige, raquette et bien plus encore.</p>
                    <ul class="list-unstyled mt-3">
                        <li><i class="fas fa-check text-success me-2"></i>Mont-Tremblant</li>
                        <li><i class="fas fa-check text-success me-2"></i>Le Massif</li>
                        <li><i class="fas fa-check text-success me-2"></i>Mont-Sainte-Anne</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <h3>Patrimoine & Culture</h3>
                    <p>Explorez l'histoire riche du Québec à travers ses sites patrimoniaux et musées fascinants.</p>
                    <ul class="list-unstyled mt-3">
                        <li><i class="fas fa-check text-success me-2"></i>Vieux-Québec</li>
                        <li><i class="fas fa-check text-success me-2"></i>Vieux-Montréal</li>
                        <li><i class="fas fa-check text-success me-2"></i>Musée de la Civilisation</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hiking"></i>
                    </div>
                    <h3>Nature & Aventure</h3>
                    <p>Randonnées, kayak, observation de la faune dans les plus beaux parcs naturels du Québec.</p>
                    <ul class="list-unstyled mt-3">
                        <li><i class="fas fa-check text-success me-2"></i>Parc de la Gaspésie</li>
                        <li><i class="fas fa-check text-success me-2"></i>Fjord du Saguenay</li>
                        <li><i class="fas fa-check text-success me-2"></i>Parc du Mont-Orford</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="landing-section" id="experiences">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Galerie d'Expériences</h2>
            <p class="section-subtitle">Laissez-vous inspirer par ces moments magiques</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1517935706615-2717063c2225?w=600&h=400&fit=crop" alt="Château Frontenac">
                    <div class="gallery-overlay">
                        <h4>Château Frontenac</h4>
                        <p>L'icône de Québec</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&h=400&fit=crop" alt="Montagnes">
                    <div class="gallery-overlay">
                        <h4>Laurentides</h4>
                        <p>Paysages à couper le souffle</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?w=600&h=400&fit=crop" alt="Hiver">
                    <div class="gallery-overlay">
                        <h4>Carnaval de Québec</h4>
                        <p>Festivités hivernales</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1503614472-8c93d56e92ce?w=600&h=400&fit=crop" alt="Nature">
                    <div class="gallery-overlay">
                        <h4>Parc National</h4>
                        <p>Randonnées exceptionnelles</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=600&h=400&fit=crop" alt="Ville">
                    <div class="gallery-overlay">
                        <h4>Vieux-Montréal</h4>
                        <p>Charme historique</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1596394516093-9baa8e6c2b5e?w=600&h=400&fit=crop" alt="Lac">
                    <div class="gallery-overlay">
                        <h4>Lacs & Rivières</h4>
                        <p>Activités nautiques</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Prêt à Vivre l'Aventure Québécoise ?</h2>
        <p>Réservez dès maintenant votre expérience inoubliable au Québec</p>
        <a href="{{url('/')}}" class="btn btn-cta">
            <i class="fas fa-calendar-check me-2"></i>Réserver Maintenant
        </a>
    </div>
</section>
@endsection
