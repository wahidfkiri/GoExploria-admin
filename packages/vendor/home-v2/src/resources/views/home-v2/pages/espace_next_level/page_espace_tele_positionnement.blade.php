{{-- ============================================================
     PAGE DÉTAIL — ESPACES TÉLÉ-POSITIONNEMENT
     Géolocalisation avancée · Cartes interactives · Suivi GPS · Zones de chalandise
     ============================================================ --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Télé-positionnement - Géolocalisation avancée | GoExploria Next Level</title>
    <meta name="description" content="Solution professionnelle de géolocalisation temps réel. Suivez vos actifs, définissez des zones de sécurité, analysez vos flux et optimisez vos tournées.">
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Bebas+Neue&family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DM Sans', sans-serif;
            background: #fff;
            color: #1a1a1a;
            line-height: 1.5;
        }
        
        /* ============================================
           PAGE DÉTAIL GÉOLOCALISATION — STYLES COMPLETS
           ============================================ */
        
        .nl-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }
        
        .nl-gradient-text {
            background: linear-gradient(135deg, #e8761a, #f59e0b);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .nl-section-header {
            margin-bottom: 48px;
        }
        
        .nl-section-header.text-center {
            text-align: center;
        }
        
        .nl-section-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            color: #1a1a1a;
            margin-bottom: 16px;
            line-height: 1.2;
        }
        
        .nl-section-header p {
            font-size: 16px;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .nl-section-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #e8761a;
            background: #fef3ea;
            padding: 6px 16px;
            border-radius: 999px;
            margin-bottom: 20px;
        }
        
        /* Navigation */
        .nl-nav {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nl-nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            max-width: 1280px;
            margin: 0 auto;
        }
        .nl-nav-logo {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nl-nav-logo img {
            height: 35px;
        }
        .nl-nav-logo span {
            font-weight: 800;
            font-size: 18px;
            color: #1a1a1a;
        }
        .nl-nav-links {
            display: flex;
            gap: 32px;
            align-items: center;
        }
        .nl-nav-links a {
            text-decoration: none;
            color: #555;
            font-weight: 500;
            font-size: 14px;
        }
        .nl-nav-links a:hover {
            color: #e8761a;
        }
        .nl-nav-cta {
            background: #e8761a;
            color: #fff !important;
            padding: 8px 20px;
            border-radius: 8px;
        }
        
        /* Hero Section */
        .nl-hero {
            background: linear-gradient(135deg, #0a1628 0%, #1a2a4a 100%);
            padding: 80px 0 60px;
            position: relative;
            overflow: hidden;
        }
        
        .nl-hero::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -20%;
            width: 70%;
            height: 160%;
            background: radial-gradient(circle, rgba(232,118,26,0.12) 0%, transparent 70%);
            pointer-events: none;
        }
        
        .nl-hero .nl-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        .nl-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(52,211,153,0.15);
            border: 1px solid rgba(52,211,153,0.3);
            color: #34d399;
            border-radius: 999px;
            padding: 6px 16px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }
        
        .nl-badge-dot {
            width: 7px;
            height: 7px;
            background: #34d399;
            border-radius: 50%;
            animation: nlPulse 2s infinite;
        }
        
        @keyframes nlPulse {
            0%,100%{opacity:1;transform:scale(1)}
            50%{opacity:0.4;transform:scale(1.4)}
        }
        
        .nl-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(42px, 5vw, 64px);
            color: #fff;
            line-height: 1.1;
            margin-bottom: 24px;
        }
        
        .nl-hero-description {
            font-size: 16px;
            color: rgba(255,255,255,0.7);
            line-height: 1.8;
            margin-bottom: 32px;
            max-width: 500px;
        }
        
        .nl-hero-ctas {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }
        
        .btn-lg {
            padding: 16px 32px;
            font-size: 15px;
        }
        
        .nl-btn-primary {
            background: #e8761a;
            color: #fff;
            padding: 14px 28px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }
        
        .nl-btn-primary:hover {
            background: #c45e0e;
            transform: translateY(-2px);
            color: #fff;
        }
        
        .nl-btn-outline {
            border: 2px solid rgba(255,255,255,0.3);
            color: #fff;
            background: transparent;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            padding: 14px 28px;
        }
        
        .nl-btn-outline:hover {
            border-color: #e8761a;
            background: rgba(232,118,26,0.15);
            color: #fff;
        }
        
        .nl-hero-stats {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }
        
        .nl-stat {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.05);
            padding: 10px 18px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .nl-stat i {
            font-size: 24px;
            color: #e8761a;
        }
        
        .nl-stat strong {
            display: block;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 22px;
            color: #fff;
            line-height: 1;
        }
        
        .nl-stat span {
            font-size: 10px;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Map Mock */
        .nl-map-mock {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        
        .nl-map-header {
            background: rgba(255,255,255,0.08);
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            font-size: 12px;
            color: rgba(255,255,255,0.8);
        }
        
        .nl-map-live {
            font-size: 10px;
            color: #34d399;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .nl-map-live i { font-size: 6px; }
        
        .nl-map-container {
            position: relative;
            height: 320px;
            background: linear-gradient(135deg, #1a3a5c, #0a1a2e);
            overflow: hidden;
        }
        
        .nl-map-bg {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 30% 40%, rgba(232,118,26,0.1) 0%, transparent 50%),
                              repeating-linear-gradient(90deg, rgba(255,255,255,0.02) 0px, rgba(255,255,255,0.02) 1px, transparent 1px, transparent 40px),
                              repeating-linear-gradient(0deg, rgba(255,255,255,0.02) 0px, rgba(255,255,255,0.02) 1px, transparent 1px, transparent 40px);
        }
        
        .nl-map-marker {
            position: absolute;
            cursor: pointer;
            z-index: 10;
        }
        
        .nl-map-marker i {
            font-size: 24px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }
        
        .nl-marker-1 i { color: #e8761a; }
        .nl-marker-2 i { color: #f59e0b; }
        .nl-marker-3 i { color: #10b981; }
        .nl-marker-4 i { color: #3b82f6; }
        .nl-marker-5 i { color: #8b5cf6; }
        
        .nl-map-zone {
            position: absolute;
            border: 2px dashed #10b981;
            border-radius: 50%;
            background: rgba(16,185,129,0.1);
        }
        
        .nl-map-zone-label {
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 8px;
            color: #10b981;
            background: rgba(16,185,129,0.2);
            padding: 2px 6px;
            border-radius: 10px;
            white-space: nowrap;
        }
        
        .nl-map-route {
            position: absolute;
            height: 2px;
            background: linear-gradient(90deg, transparent, #e8761a, #f59e0b, transparent);
        }
        
        .nl-map-footer {
            background: rgba(255,255,255,0.05);
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: rgba(255,255,255,0.4);
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .nl-map-legend {
            display: flex;
            gap: 16px;
        }
        
        .nl-map-legend span {
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .nl-floating-card {
            position: absolute;
            bottom: 30px;
            left: -20px;
            background: #fff;
            border-radius: 12px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .nl-floating-card i {
            font-size: 20px;
            color: #f59e0b;
        }
        
        .nl-floating-card strong {
            display: block;
            font-size: 11px;
            color: #1a1a1a;
        }
        
        .nl-floating-card span {
            font-size: 10px;
            color: #666;
        }
        
        /* Features Section */
        .nl-features {
            padding: 80px 0;
            background: #fff;
        }
        
        .nl-features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        
        .nl-feature-card {
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 20px;
            padding: 32px;
            transition: all 0.3s;
        }
        
        .nl-feature-card:hover {
            transform: translateY(-4px);
            border-color: #e8761a;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }
        
        .nl-feature-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 18px;
        }
        
        .nl-feature-card h3 {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 10px;
        }
        
        .nl-feature-card p {
            font-size: 13px;
            color: #666;
            line-height: 1.7;
            margin-bottom: 16px;
        }
        
        .nl-feature-tag {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 4px 10px;
            border-radius: 6px;
        }
        
        /* Benefits Section */
        .nl-benefits {
            padding: 80px 0;
            background: #f8faff;
        }
        
        .nl-benefits-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-top: 40px;
        }
        
        .nl-benefit-card {
            text-align: center;
            padding: 32px 24px;
            background: #fff;
            border-radius: 20px;
            transition: all 0.3s;
        }
        
        .nl-benefit-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.08);
        }
        
        .nl-benefit-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #e8761a20, #f59e0b20);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 32px;
            color: #e8761a;
        }
        
        .nl-benefit-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .nl-benefit-card p {
            font-size: 13px;
            color: #666;
            line-height: 1.6;
        }
        
        /* Use Cases */
        .nl-usecases {
            padding: 80px 0;
            background: #fff;
        }
        
        .nl-usecases-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-top: 40px;
        }
        
        .nl-usecase-card {
            background: #f8faff;
            border-radius: 20px;
            padding: 32px;
            text-align: center;
            transition: all 0.3s;
            border: 1px solid #e5e7eb;
        }
        
        .nl-usecase-card:hover {
            transform: translateY(-4px);
            border-color: #e8761a;
            background: #fff;
        }
        
        .nl-usecase-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #e8761a20, #f59e0b20);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 28px;
            color: #e8761a;
        }
        
        .nl-usecase-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .nl-usecase-card p {
            font-size: 13px;
            color: #666;
        }
        
        /* Technologies */
        .nl-tech {
            padding: 80px 0;
            background: #f8faff;
        }
        
        .nl-tech-wrapper {
            background: #fff;
            border-radius: 28px;
            padding: 56px;
            border: 1px solid #e5e7eb;
        }
        
        .nl-tech-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-top: 40px;
        }
        
        .nl-tech-item {
            text-align: center;
            padding: 24px;
            background: #f8faff;
            border-radius: 16px;
            transition: all 0.3s;
        }
        
        .nl-tech-item:hover {
            transform: translateY(-4px);
            background: #fff;
            box-shadow: 0 8px 16px rgba(0,0,0,0.08);
        }
        
        .nl-tech-item i {
            font-size: 36px;
            color: #e8761a;
            margin-bottom: 12px;
        }
        
        .nl-tech-item h4 {
            font-size: 14px;
            margin-bottom: 6px;
        }
        
        .nl-tech-item span {
            font-size: 11px;
            color: #888;
        }
        
        /* Pricing */
        .nl-pricing {
            padding: 80px 0;
            background: #fff;
        }
        
        .nl-pricing-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 32px;
        }
        
        .nl-pricing-card {
            background: #fff;
            border-radius: 24px;
            padding: 32px;
            position: relative;
            transition: all 0.3s;
            border: 2px solid #e5e7eb;
        }
        
        .nl-pricing-popular {
            border-color: #e8761a;
            background: linear-gradient(160deg, #fffbf7, #fff);
            transform: scale(1.02);
            box-shadow: 0 20px 40px rgba(232,118,26,0.1);
        }
        
        .nl-pricing-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: #e8761a;
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            padding: 4px 16px;
            border-radius: 999px;
            letter-spacing: 1px;
        }
        
        .nl-pricing-name {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 700;
            color: #888;
            margin-bottom: 16px;
            text-align: center;
        }
        
        .nl-pricing-price {
            text-align: center;
            margin-bottom: 24px;
        }
        
        .nl-price-amount {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 48px;
            color: #1a1a1a;
        }
        
        .nl-price-period {
            font-size: 14px;
            color: #888;
        }
        
        .nl-pricing-features {
            list-style: none;
            margin-bottom: 28px;
        }
        
        .nl-pricing-features li {
            font-size: 13px;
            color: #555;
            padding: 8px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .nl-pricing-features li i {
            color: #10b981;
            font-size: 13px;
        }
        
        .nl-pricing-cta {
            display: block;
            text-align: center;
            padding: 14px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .nl-price-cta-light {
            background: #f0f4ff;
            color: #1e3a5f;
            border: 2px solid #e5e7eb;
        }
        
        .nl-price-cta-light:hover {
            background: #1e3a5f;
            color: #fff;
        }
        
        .nl-price-cta-orange {
            background: #e8761a;
            color: #fff;
        }
        
        .nl-price-cta-orange:hover {
            background: #c45e0e;
            transform: translateY(-2px);
        }
        
        .nl-pricing-note {
            text-align: center;
            font-size: 12px;
            color: #888;
        }
        
        /* FAQ */
        .nl-faq {
            padding: 80px 0;
            background: #f8faff;
        }
        
        .nl-faq-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 40px;
        }
        
        .nl-faq-item {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 20px 24px;
            transition: all 0.2s;
        }
        
        .nl-faq-item:hover {
            border-color: #e8761a;
        }
        
        .nl-faq-question {
            font-weight: 700;
            font-size: 15px;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        
        .nl-faq-question i {
            color: #e8761a;
            font-size: 14px;
        }
        
        .nl-faq-answer {
            font-size: 13px;
            color: #666;
            line-height: 1.7;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #f0f0f0;
            display: none;
        }
        
        .nl-faq-answer.active {
            display: block;
        }
        
        /* Demo Form */
        .nl-demo-form {
            padding: 80px 0;
            background: #fff;
        }
        
        .nl-form-wrapper {
            background: linear-gradient(135deg, #f8faff, #fff);
            border: 1px solid #e5e7eb;
            border-radius: 28px;
            padding: 56px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        .nl-form-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #10b981;
            background: rgba(16,185,129,0.1);
            padding: 6px 14px;
            border-radius: 999px;
            margin-bottom: 16px;
        }
        
        .nl-form-left h2 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            margin-bottom: 14px;
        }
        
        .nl-form-left h2 em {
            font-style: italic;
            color: #e8761a;
        }
        
        .nl-form-left p {
            font-size: 15px;
            color: #666;
            line-height: 1.8;
            margin-bottom: 24px;
        }
        
        .nl-form-benefits {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .nl-form-benefits li {
            font-size: 14px;
            color: #444;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .nl-form-benefits li i {
            color: #10b981;
        }
        
        .nl-form-group {
            margin-bottom: 16px;
        }
        
        .nl-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        
        .nl-form-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 6px;
        }
        
        .nl-form-group input,
        .nl-form-group select {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
            transition: border-color 0.2s;
        }
        
        .nl-form-group input:focus,
        .nl-form-group select:focus {
            outline: none;
            border-color: #e8761a;
        }
        
        .nl-btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #e8761a, #c04f10);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            margin-top: 8px;
        }
        
        .nl-btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(232,118,26,0.35);
        }
        
        .nl-form-note {
            font-size: 11px;
            color: #9ca3af;
            text-align: center;
            margin-top: 12px;
        }
        
        /* CTA Final */
        .nl-cta {
            padding: 80px 0;
            background: linear-gradient(135deg, #fef3ea, #fff3e6);
        }
        
        .nl-cta-content {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .nl-cta-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 40px;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .nl-cta-content p {
            font-size: 16px;
            color: #666;
            margin-bottom: 32px;
        }
        
        .nl-cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }
        
        .btn-xl {
            padding: 16px 36px;
            font-size: 16px;
        }
        
        .nl-cta-note {
            font-size: 13px;
            color: #888;
        }
        
        /* Footer */
        .nl-footer {
            background: #0a1628;
            padding: 40px 0;
            text-align: center;
            color: rgba(255,255,255,0.5);
            font-size: 13px;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .nl-features-grid { grid-template-columns: repeat(2, 1fr); }
            .nl-benefits-grid { grid-template-columns: repeat(2, 1fr); }
            .nl-usecases-grid { grid-template-columns: repeat(2, 1fr); }
            .nl-tech-grid { grid-template-columns: repeat(2, 1fr); }
            .nl-pricing-grid { grid-template-columns: repeat(2, 1fr); }
            .nl-faq-grid { grid-template-columns: 1fr; }
        }
        
        @media (max-width: 1000px) {
            .nl-hero .nl-container { grid-template-columns: 1fr; }
            .nl-form-wrapper { grid-template-columns: 1fr; gap: 32px; }
            .nl-nav-links { display: none; }
        }
        
        @media (max-width: 768px) {
            .nl-container { padding: 0 20px; }
            .nl-features-grid { grid-template-columns: 1fr; }
            .nl-benefits-grid { grid-template-columns: 1fr; }
            .nl-usecases-grid { grid-template-columns: 1fr; }
            .nl-tech-grid { grid-template-columns: 1fr; }
            .nl-pricing-grid { grid-template-columns: 1fr; }
            .nl-pricing-popular { transform: scale(1); }
            .nl-form-wrapper { padding: 32px 24px; }
            .nl-form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

{{-- Navigation --}}
<nav class="nl-nav">
    <div class="nl-nav-container">
        <div class="nl-nav-logo">
         <img src="{{ asset('logo.png') }}" alt="Next Level" style="height: 75px;">
        </div>
        <div class="nl-nav-links">
            <a href="#features">Fonctionnalités</a>
            <a href="#usecases">Cas d'usage</a>
            <a href="#faq">FAQ</a>
            <a href="{{ route('devis') }}" class="nl-nav-cta">Demander un devis</a>
        </div>
    </div>
</nav>

{{-- HERO SECTION --}}
<section class="nl-hero">
    <div class="nl-container">
        <div class="nl-hero-content">
            <div class="nl-hero-badge">
                <span class="nl-badge-dot"></span>
                Précision GPS · Mise à jour 1s
            </div>
            <h1>
                Géolocalisez vos actifs<br>
                <span class="nl-gradient-text">en temps réel, où qu'ils soient</span>
            </h1>
            <p class="nl-hero-description">
                Notre plateforme de télé-positionnement vous offre une vision complète de vos actifs mobiles. Suivez vos collaborateurs, véhicules ou équipements sur une carte interactive, définissez des zones de sécurité et analysez vos flux de déplacement.
            </p>
            <div class="nl-hero-ctas">
                <a href="{{ route('devis') }}" class="nl-btn-primary btn-lg">
                    <i class="fas fa-map"></i> Demander un devis
                </a>
            </div>
            <div class="nl-hero-stats">
                <div class="nl-stat"><i class="fas fa-map-marked-alt"></i><div><strong>1M+</strong><span>Positions/jour</span></div></div>
                <div class="nl-stat"><i class="fas fa-satellite"></i><div><strong>&lt;1s</strong><span>Latence</span></div></div>
                <div class="nl-stat"><i class="fas fa-draw-polygon"></i><div><strong>Illimité</strong><span>Zones</span></div></div>
                <div class="nl-stat"><i class="fas fa-shield-alt"></i><div><strong>GDPR</strong><span>Conforme</span></div></div>
            </div>
        </div>
        <div class="nl-hero-visual">
            <div class="nl-map-mock">
                <div class="nl-map-header">
                    <i class="fas fa-map-pin"></i> Live Tracking — 12 actifs connectés
                    <span class="nl-map-live"><i class="fas fa-circle"></i> En direct</span>
                </div>
                <div class="nl-map-container">
                    <div class="nl-map-bg"></div>
                    <div class="nl-map-marker nl-marker-1" style="top:25%;left:20%">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="nl-map-marker nl-marker-2" style="top:50%;left:45%">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="nl-map-marker nl-marker-3" style="top:70%;left:60%">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="nl-map-marker nl-marker-4" style="top:35%;left:75%">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="nl-map-marker nl-marker-5" style="top:80%;left:30%">
                        <i class="fas fa-hard-hat"></i>
                    </div>
                    <div class="nl-map-zone" style="top:40%;left:30%;width:100px;height:100px">
                        <div class="nl-map-zone-label">Zone sécurisée</div>
                    </div>
                    <div class="nl-map-route" style="bottom:30%;left:20%;width:60%;transform:rotate(-10deg)"></div>
                </div>
                <div class="nl-map-footer">
                    <div class="nl-map-legend">
                        <span><i class="fas fa-map-marker-alt" style="color:#e8761a"></i> Actifs mobiles</span>
                        <span><i class="fas fa-store" style="color:#3b82f6"></i> Points d'intérêt</span>
                        <span><i class="fas fa-draw-polygon" style="color:#10b981"></i> Zones définies</span>
                    </div>
                    <div class="nl-map-update">Dernière mise à jour : il y a 2s <i class="fas fa-sync-alt fa-spin"></i></div>
                </div>
            </div>
            <div class="nl-floating-card">
                <i class="fas fa-bell"></i>
                <div>
                    <strong>Entrée en zone sécurisée</strong>
                    <span>Véhicule #12 est arrivé • 14:32</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FEATURES SECTION --}}
<section class="nl-features" id="features">
    <div class="nl-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-cogs"></i> Fonctionnalités avancées</span>
            <h2>Une solution complète de<br><span class="nl-gradient-text">télé-positionnement</span></h2>
            <p>Gérez, surveillez et optimisez tous vos actifs géolocalisés depuis une interface unique.</p>
        </div>
        <div class="nl-features-grid">
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#e8761a20;color:#e8761a"><i class="fas fa-map-marker-alt"></i></div>
                <h3>Géolocalisation Temps Réel</h3>
                <p>Suivez vos collaborateurs, flottes ou actifs en temps réel sur une carte interactive. Historique des positions et alertes de zone.</p>
                <div class="nl-feature-tag" style="background:#e8761a15;color:#e8761a">Live tracking</div>
            </div>
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#3b82f620;color:#3b82f6"><i class="fas fa-draw-polygon"></i></div>
                <h3>Zones de Chalandise</h3>
                <p>Définissez et visualisez vos zones d'influence. Analyse de couverture, isochrones et géomarketing avancé.</p>
                <div class="nl-feature-tag" style="background:#3b82f615;color:#3b82f6">Geomarketing</div>
            </div>
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#10b98120;color:#10b981"><i class="fas fa-chart-pie"></i></div>
                <h3>Analyse de Flux</h3>
                <p>Cartographie des déplacements, points de passage fréquents, heatmaps et optimisation des tournées.</p>
                <div class="nl-feature-tag" style="background:#10b98115;color:#10b981">Heatmap</div>
            </div>
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#8b5cf620;color:#8b5cf6"><i class="fas fa-bell"></i></div>
                <h3>Alertes Géospatiales</h3>
                <p>Notifications automatiques à l'entrée/sortie de zones prédéfinies. Idéal pour la sécurité et la logistique.</p>
                <div class="nl-feature-tag" style="background:#8b5cf615;color:#8b5cf6">Geofencing</div>
            </div>
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#f59e0b20;color:#f59e0b"><i class="fas fa-route"></i></div>
                <h3>Optimisation d'Itinéraires</h3>
                <p>Calcul automatique des trajets optimaux multi-points. Réduction des temps de trajet et de la consommation.</p>
                <div class="nl-feature-tag" style="background:#f59e0b15;color:#f59e0b">Routing</div>
            </div>
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#ef444420;color:#ef4444"><i class="fas fa-chart-line"></i></div>
                <h3>Statistiques & Reporting</h3>
                <p>Tableaux de bord personnalisés : distances parcourues, temps d'arrêt, performances par zone.</p>
                <div class="nl-feature-tag" style="background:#ef444415;color:#ef4444">Analytics</div>
            </div>
        </div>
    </div>
</section>

{{-- BENEFITS SECTION --}}
<section class="nl-benefits">
    <div class="nl-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-chart-line"></i> Bénéfices clés</span>
            <h2>Pourquoi choisir<br><span class="nl-gradient-text">notre solution ?</span></h2>
            <p>Des avantages concrets pour votre organisation.</p>
        </div>
        <div class="nl-benefits-grid">
            <div class="nl-benefit-card">
                <div class="nl-benefit-icon"><i class="fas fa-clock"></i></div>
                <h3>Gain de temps</h3>
                <p>Réduction de 30% des temps de déplacement grâce à l'optimisation des tournées.</p>
            </div>
            <div class="nl-benefit-card">
                <div class="nl-benefit-icon"><i class="fas fa-euro-sign"></i></div>
                <h3>Réduction des coûts</h3>
                <p>Jusqu'à 25% d'économies sur les coûts de carburant et d'entretien.</p>
            </div>
            <div class="nl-benefit-card">
                <div class="nl-benefit-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Sécurité renforcée</h3>
                <p>Alertes instantanées et géofencing pour protéger vos équipes et vos biens.</p>
            </div>
            <div class="nl-benefit-card">
                <div class="nl-benefit-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Productivité accrue</h3>
                <p>Suivi en temps réel et analyse des performances pour optimiser vos équipes.</p>
            </div>
        </div>
    </div>
</section>

{{-- USE CASES --}}
<section class="nl-usecases" id="usecases">
    <div class="nl-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-briefcase"></i> Cas d'usage</span>
            <h2>Adapté à tous les secteurs<br><span class="nl-gradient-text">d'activité</span></h2>
            <p>Des solutions sur mesure pour chaque métier.</p>
        </div>
        <div class="nl-usecases-grid">
            <div class="nl-usecase-card">
                <div class="nl-usecase-icon"><i class="fas fa-truck"></i></div>
                <h3>Logistique & Transport</h3>
                <p>Suivez votre flotte en temps réel, optimisez les tournées et réduisez les délais de livraison.</p>
            </div>
            <div class="nl-usecase-card">
                <div class="nl-usecase-icon"><i class="fas fa-store"></i></div>
                <h3>Commerces & Retail</h3>
                <p>Analysez votre zone de chalandise et identifiez les meilleurs emplacements.</p>
            </div>
            <div class="nl-usecase-card">
                <div class="nl-usecase-icon"><i class="fas fa-hard-hat"></i></div>
                <h3>Chantiers & Construction</h3>
                <p>Gérez vos équipes sur le terrain et sécurisez les zones sensibles.</p>
            </div>
            <div class="nl-usecase-card">
                <div class="nl-usecase-icon"><i class="fas fa-hand-holding-heart"></i></div>
                <h3>Services à la personne</h3>
                <p>Optimisez les tournées d'intervention et améliorez la réactivité.</p>
            </div>
            <div class="nl-usecase-card">
                <div class="nl-usecase-icon"><i class="fas fa-taxi"></i></div>
                <h3>Mobilité & VTC</h3>
                <p>Suivez vos véhicules en direct, gérez les courses et réduisez les temps d'attente.</p>
            </div>
            <div class="nl-usecase-card">
                <div class="nl-usecase-icon"><i class="fas fa-building"></i></div>
                <h3>Immobilier</h3>
                <p>Cartographiez vos biens et prospects, optimisez les visites terrain.</p>
            </div>
        </div>
    </div>
</section>

{{-- TECHNOLOGIES --}}
<section class="nl-tech">
    <div class="nl-container">
        <div class="nl-tech-wrapper">
            <div class="nl-section-header text-center">
                <span class="nl-section-tag"><i class="fas fa-microchip"></i> Technologies supportées</span>
                <h2>Multi-technologies,<br><span class="nl-gradient-text">multi-appareils</span></h2>
                <p>Notre solution s'adapte à tous vos équipements.</p>
            </div>
            <div class="nl-tech-grid">
                <div class="nl-tech-item">
                    <i class="fas fa-mobile-alt"></i>
                    <h4>iOS / Android</h4>
                    <span>Applications natives</span>
                </div>
                <div class="nl-tech-item">
                    <i class="fas fa-truck-moving"></i>
                    <h4>Traceurs embarqués</h4>
                    <span>Plug & play</span>
                </div>
                <div class="nl-tech-item">
                    <i class="fas fa-microchip"></i>
                    <h4>Balises GPS</h4>
                    <span>Autonomie 30 jours</span>
                </div>
                <div class="nl-tech-item">
                    <i class="fas fa-code"></i>
                    <h4>API REST</h4>
                    <span>Intégration sur mesure</span>
                </div>
                <div class="nl-tech-item">
                    <i class="fas fa-bluetooth"></i>
                    <h4>BLE / Beacon</h4>
                    <span>Intérieur précis</span>
                </div>
                <div class="nl-tech-item">
                    <i class="fas fa-wifi"></i>
                    <h4>Wi-Fi positioning</h4>
                    <span>Zones urbaines</span>
                </div>
                <div class="nl-tech-item">
                    <i class="fas fa-satellite"></i>
                    <h4>GPS / GNSS</h4>
                    <span>Précision 1m</span>
                </div>
                <div class="nl-tech-item">
                    <i class="fas fa-chart-line"></i>
                    <h4>SDK personnalisé</h4>
                    <span>Sur devis</span>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- DEMO FORM --}}
<section class="nl-demo-form" id="demo-form">
    <div class="nl-container">
        <div class="nl-form-wrapper">
            <div class="nl-form-left">
                <div class="nl-form-badge">
                    <i class="fas fa-calendar-alt"></i> Démo personnalisée
                </div>
                <h2>Testez notre solution<br><em>gratuitement pendant 14 jours</em></h2>
                <p>Accédez à une plateforme de démonstration complète. Créez vos zones, suivez des actifs simulés et découvrez toutes les fonctionnalités.</p>
                <ul class="nl-form-benefits">
                    <li><i class="fas fa-check-circle"></i> Installation en 5 minutes</li>
                    <li><i class="fas fa-check-circle"></i> 5 actifs inclus</li>
                    <li><i class="fas fa-check-circle"></i> Support prioritaire</li>
                    <li><i class="fas fa-check-circle"></i> Sans carte bancaire</li>
                </ul>
            </div>
            <div class="nl-form-right">
                <form id="nlGeoDemoForm">
                    <div class="nl-form-group">
                        <label>Nom de l'entreprise</label>
                        <input type="text" placeholder="Ex: Ma Société" required>
                    </div>
                    <div class="nl-form-row">
                        <div class="nl-form-group">
                            <label>Votre nom</label>
                            <input type="text" placeholder="Jean Dupont" required>
                        </div>
                        <div class="nl-form-group">
                            <label>Email professionnel</label>
                            <input type="email" placeholder="contact@entreprise.com" required>
                        </div>
                    </div>
                    <div class="nl-form-group">
                        <label>Nombre d'actifs à géolocaliser</label>
                        <select required>
                            <option value="">Sélectionnez</option>
                            <option>1-5 actifs</option>
                            <option>6-20 actifs</option>
                            <option>21-50 actifs</option>
                            <option>51-100 actifs</option>
                            <option>100+ actifs</option>
                        </select>
                    </div>
                    <button type="submit" class="nl-btn-submit">
                        <i class="fas fa-rocket"></i> Démarrer ma démo gratuite
                    </button>
                    <p class="nl-form-note">Démo immédiate · Aucun engagement · Support inclus</p>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="nl-faq" id="faq">
    <div class="nl-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-question-circle"></i> Questions fréquentes</span>
            <h2>Tout ce que vous <span class="nl-gradient-text">devez savoir</span></h2>
        </div>
        <div class="nl-faq-grid">
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Comment fonctionne la géolocalisation en temps réel ?
                </div>
                <div class="nl-faq-answer">
                    Notre solution utilise un mix de technologies (GPS, GSM, WiFi) pour garantir une précision optimale. Les positions sont transmises toutes les secondes via une connexion sécurisée et s'affichent instantanément sur votre tableau de bord.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Quelle est la précision de la localisation ?
                </div>
                <div class="nl-faq-answer">
                    En extérieur avec GPS, la précision est de 1 à 3 mètres. En intérieur ou zones denses, nous utilisons le WiFi et la triangulation GSM avec une précision de 10 à 30 mètres. Les traceurs professionnels offrent une précision sub-métrique.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Les données sont-elles sécurisées ?
                </div>
                <div class="nl-faq-answer">
                    Absolument. Toutes les données sont chiffrées de bout en bout (TLS 1.3). Nous sommes conformes RGPD et nous ne revendons aucune donnée. Vous restez propriétaire de vos informations.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Puis-je intégrer votre solution dans mon application existante ?
                </div>
                <div class="nl-faq-answer">
                    Oui ! Notre API REST complète vous permet d'intégrer toutes nos fonctionnalités dans vos propres applications. Documentation interactive, SDK, webhooks et support technique dédié.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Quels appareils sont compatibles ?
                </div>
                <div class="nl-faq-answer">
                    Tous ! Smartphones iOS/Android, traceurs GPS dédiés, balises Bluetooth, équipements embarqués. Nous fournissons une application mobile gratuite ou vous pouvez utiliser vos propres appareils.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Proposez-vous une assistance pour l'installation ?
                </div>
                <div class="nl-faq-answer">
                    Bien sûr. Un technicien dédié vous accompagne lors de l'installation initiale. Nous proposons également une formation pour vos administrateurs et utilisateurs.
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA FINAL --}}
<section class="nl-cta">
    <div class="nl-container">
        <div class="nl-cta-content">
            <i class="fas fa-map-marked-alt" style="font-size: 48px; color: #e8761a; margin-bottom: 20px;"></i>
            <h2>Prêt à optimiser vos déplacements ?</h2>
            <p>Rejoignez les centaines d'entreprises qui utilisent notre solution de télé-positionnement au quotidien.</p>
            <div class="nl-cta-buttons">
                <a href="#demo-form" class="nl-btn-primary btn-xl">
                    <i class="fas fa-rocket"></i> Démarrer ma démo gratuite
                </a>
                <a href="#" class="nl-btn-outline btn-xl">
                    <i class="fas fa-headset"></i> Parler à un expert
                </a>
            </div>
            <p class="nl-cta-note">
                <i class="fas fa-check-circle"></i> Essai 14 jours · Sans engagement · Installation accompagnée
            </p>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="nl-footer">
    <div class="nl-container">
        <p>© 2026 GoExploria Next Level. Tous droits réservés.</p>
    </div>
</footer>

<script>
    // Accordéon FAQ
    document.querySelectorAll('.nl-faq-question').forEach(question => {
        question.addEventListener('click', () => {
            const answer = question.nextElementSibling;
            answer.classList.toggle('active');
            
            const icon = question.querySelector('i');
            if (answer.classList.contains('active')) {
                icon.classList.remove('fa-plus-circle');
                icon.classList.add('fa-minus-circle');
            } else {
                icon.classList.remove('fa-minus-circle');
                icon.classList.add('fa-plus-circle');
            }
        });
    });

    // Formulaire démo
    document.getElementById('nlGeoDemoForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Merci ! Votre demande de démo a été enregistrée. Un expert vous contacte sous 24h pour activer votre accès.');
        this.reset();
    });
</script>

</body>
</html>