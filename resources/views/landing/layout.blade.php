<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Go Exploria Business')</title>
    <meta name="description" content="@yield('description', 'Go Exploria Business - Votre partenaire voyage')">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1a3a5f;
            --secondary-color: #2c5282;
            --accent-color: #fbbf24;
            --dark-color: #1f2937;
            --light-bg: #f8f9fa;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            color: #333;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }
        
        /* Hero Section */
        .landing-hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }
        
        .landing-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        
        .landing-hero-content {
            position: relative;
            z-index: 2;
        }
        
        .landing-hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            animation: fadeInUp 0.8s ease;
        }
        
        .landing-hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.95;
            animation: fadeInUp 1s ease;
        }
        
        .hero-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            animation: bounceIn 1s ease;
        }
        
        /* Content Sections */
        .landing-section {
            padding: 80px 0;
        }
        
        .section-title {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: var(--accent-color);
        }
        
        .section-subtitle {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 50px;
        }
        
        /* Feature Cards */
        .feature-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid #e9ecef;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin-bottom: 20px;
        }
        
        .feature-card h3 {
            font-size: 1.4rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .feature-card p {
            color: #666;
            line-height: 1.7;
        }
        
        /* Image Gallery */
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 30px;
            cursor: pointer;
        }
        
        .gallery-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        
        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            padding: 20px;
            color: white;
        }
        
        .gallery-overlay h4 {
            margin: 0;
            font-size: 1.2rem;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        
        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        
        .cta-section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.95;
        }
        
        .btn-cta {
            background: var(--accent-color);
            color: var(--dark-color);
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .btn-cta:hover {
            background: #fcd34d;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(251, 191, 36, 0.4);
        }
        
        /* Back Button */
        .back-to-home {
            position: fixed;
            top: 20px;
            left: 20px;
            background: white;
            color: var(--primary-color);
            padding: 12px 25px;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1000;
            font-weight: 600;
        }
        
        .back-to-home:hover {
            background: var(--primary-color);
            color: white;
            transform: translateX(-5px);
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .landing-hero {
                padding: 60px 0 50px;
            }
            
            .landing-hero h1 {
                font-size: 2rem;
            }
            
            .landing-hero p {
                font-size: 1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .landing-section {
                padding: 50px 0;
            }
            
            .back-to-home {
                top: 10px;
                left: 10px;
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Back to Home Button -->
    <a href="{{url('/')}}" class="back-to-home">
        <i class="fas fa-arrow-left me-2"></i>Retour à l'accueil
    </a>

    @yield('content')
    
    <!-- Footer -->
    <footer style="background: var(--dark-color); color: white; padding: 40px 0; text-align: center;">
        <div class="container">
            <p class="mb-2">&copy; 2026 Go Exploria Business. Tous droits réservés.</p>
            <p class="mb-0">
                <a href="tel:4185257748" style="color: var(--accent-color); text-decoration: none; margin: 0 15px;">
                    <i class="fas fa-phone me-1"></i>(418) 525-7748
                </a>
                <a href="mailto:infogoexploria@gmail.com" style="color: var(--accent-color); text-decoration: none; margin: 0 15px;">
                    <i class="fas fa-envelope me-1"></i>infogoexploria@gmail.com
                </a>
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>
