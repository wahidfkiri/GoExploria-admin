@extends('landing.layout')

@section('title', 'Promotions & Offres Spéciales - Go Exploria Business')
@section('description', 'Découvrez nos meilleures offres et promotions pour vos voyages')

@section('content')
<!-- Hero Section -->
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-tags"></i>
        </div>
        <h1>Promotions & Offres Spéciales</h1>
        <p>Profitez de nos meilleures offres pour voyager à prix réduit</p>
        <a href="#offres" class="btn btn-cta">
            <i class="fas fa-gift me-2"></i>Voir les Offres
        </a>
    </div>
</section>

<!-- Promotions Section -->
<section class="landing-section" style="background: var(--light-bg);" id="offres">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Offres du Moment</h2>
            <p class="section-subtitle">Ne manquez pas ces opportunités exceptionnelles</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-percent"></i>
                    </div>
                    <h3>-30% sur les Forfaits Ski</h3>
                    <p>Profitez de 30% de réduction sur tous nos forfaits ski dans les Laurentides jusqu'au 31 mars.</p>
                    <div class="mt-3">
                        <span class="badge bg-danger">Offre Limitée</span>
                        <p class="mt-2 mb-0"><strong>Code:</strong> SKI30</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hotel"></i>
                    </div>
                    <h3>2 Nuits = 3 Nuits</h3>
                    <p>Réservez 2 nuits dans nos hôtels partenaires et obtenez la 3ème nuit gratuitement.</p>
                    <div class="mt-3">
                        <span class="badge bg-success">Populaire</span>
                        <p class="mt-2 mb-0"><strong>Code:</strong> NUIT3</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-plane"></i>
                    </div>
                    <h3>Vol + Hôtel -25%</h3>
                    <p>Économisez 25% en réservant votre vol et votre hébergement ensemble.</p>
                    <div class="mt-3">
                        <span class="badge bg-primary">Nouveau</span>
                        <p class="mt-2 mb-0"><strong>Code:</strong> COMBO25</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Forfait Famille</h3>
                    <p>Jusqu'à 40% de réduction pour les familles de 4 personnes et plus sur nos circuits.</p>
                    <div class="mt-3">
                        <span class="badge bg-warning text-dark">Famille</span>
                        <p class="mt-2 mb-0"><strong>Code:</strong> FAM40</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3>Réservation Anticipée</h3>
                    <p>Réservez 60 jours à l'avance et économisez jusqu'à 20% sur votre séjour.</p>
                    <div class="mt-3">
                        <span class="badge bg-info">Planifiez</span>
                        <p class="mt-2 mb-0"><strong>Code:</strong> EARLY20</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Escapade Romantique</h3>
                    <p>Forfait spécial couple avec champagne et spa inclus. -35% ce mois-ci.</p>
                    <div class="mt-3">
                        <span class="badge bg-danger">Saint-Valentin</span>
                        <p class="mt-2 mb-0"><strong>Code:</strong> LOVE35</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Prêt à Profiter de Nos Offres ?</h2>
        <p>Réservez maintenant et économisez sur votre prochain voyage</p>
        <a href="{{url('/')}}" class="btn btn-cta">
            <i class="fas fa-shopping-cart me-2"></i>Réserver avec Promo
        </a>
    </div>
</section>
@endsection
