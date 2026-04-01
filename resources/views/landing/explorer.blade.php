@extends('landing.layout')

@section('title', 'Explorer - Go Exploria Business')
@section('description', 'Explorez de nouvelles destinations et activités')

@section('content')
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-search"></i>
        </div>
        <h1>Explorer & Découvrir</h1>
        <p>Trouvez votre prochaine aventure parmi des centaines d'activités</p>
        <a href="#categories" class="btn btn-cta">
            <i class="fas fa-binoculars me-2"></i>Commencer l'Exploration
        </a>
    </div>
</section>

<section class="landing-section" style="background: var(--light-bg);" id="categories">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Catégories d'Exploration</h2>
            <p class="section-subtitle">Choisissez votre type d'aventure</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mountain"></i>
                    </div>
                    <h3>Aventure & Nature</h3>
                    <p>Randonnées, camping, escalade et sports extrêmes dans les plus beaux sites naturels.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3>Gastronomie</h3>
                    <p>Circuits gastronomiques, restaurants étoilés et découverte des saveurs locales.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h3>Art & Culture</h3>
                    <p>Musées, galeries d'art, festivals et événements culturels tout au long de l'année.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-spa"></i>
                    </div>
                    <h3>Détente & Bien-être</h3>
                    <p>Spas, centres de bien-être et retraites pour se ressourcer en toute tranquillité.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-child"></i>
                    </div>
                    <h3>Famille</h3>
                    <p>Activités adaptées aux familles, parcs d'attractions et expériences éducatives.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-camera"></i>
                    </div>
                    <h3>Photographie</h3>
                    <p>Les meilleurs spots photo et circuits pour capturer des moments inoubliables.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Prêt à Explorer ?</h2>
        <p>Des milliers d'expériences vous attendent</p>
        <a href="{{url('/')}}" class="btn btn-cta">
            <i class="fas fa-rocket me-2"></i>Démarrer l'Aventure
        </a>
    </div>
</section>
@endsection
