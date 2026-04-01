@extends('landing.layout')

@section('title', 'Certifications & Garanties - Go Exploria Business')
@section('description', 'Nos certifications et garanties qualité pour votre tranquillité d\'esprit')

@section('content')
<section class="landing-hero">
    <div class="container landing-hero-content text-center">
        <div class="hero-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1>Certifications & Garanties</h1>
        <p>Voyagez en toute confiance avec nos certifications reconnues</p>
        <a href="#certifications" class="btn btn-cta">
            <i class="fas fa-award me-2"></i>Voir nos Certifications
        </a>
    </div>
</section>

<section class="landing-section" style="background: var(--light-bg);" id="certifications">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Nos Certifications</h2>
            <p class="section-subtitle">Des standards de qualité reconnus internationalement</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3>ISO 9001:2015</h3>
                    <p>Certification qualité pour la gestion de nos services touristiques.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Sécurité Validée</h3>
                    <p>Tous nos partenaires sont vérifiés et certifiés pour votre sécurité.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Tourisme Durable</h3>
                    <p>Engagement écologique et pratiques responsables certifiées.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3>5 Étoiles Service</h3>
                    <p>Excellence reconnue par nos clients avec une note moyenne de 4.8/5.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Paiement Sécurisé</h3>
                    <p>Transactions protégées par cryptage SSL et certification PCI DSS.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>Garantie Satisfaction</h3>
                    <p>Remboursement intégral si vous n'êtes pas satisfait sous 30 jours.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="landing-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Nos Garanties</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6">
                <div class="feature-card">
                    <h3><i class="fas fa-undo text-primary me-2"></i>Annulation Flexible</h3>
                    <p>Annulez ou modifiez votre réservation jusqu'à 48h avant le départ sans frais.</p>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="feature-card">
                    <h3><i class="fas fa-dollar-sign text-success me-2"></i>Meilleur Prix Garanti</h3>
                    <p>Si vous trouvez moins cher ailleurs, nous remboursons la différence + 10%.</p>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="feature-card">
                    <h3><i class="fas fa-headset text-info me-2"></i>Support 24/7</h3>
                    <p>Une équipe disponible jour et nuit pour répondre à toutes vos questions.</p>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="feature-card">
                    <h3><i class="fas fa-check-double text-warning me-2"></i>Qualité Vérifiée</h3>
                    <p>Tous nos services sont inspectés et notés par nos experts qualité.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Voyagez en Toute Confiance</h2>
        <p>Nos certifications sont votre garantie de qualité</p>
        <a href="{{url('/')}}" class="btn btn-cta">
            <i class="fas fa-thumbs-up me-2"></i>Réserver en Confiance
        </a>
    </div>
</section>
@endsection
