{{-- ============================================================
     PAGE DÉTAIL — ESPACES FORMULAIRES (Version autonome)
     Contact · Réservation · Inscription · Devis · Sondages · Billeterie
     ============================================================ --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaires Next Level - Créez vos formulaires professionnels</title>
    <meta name="description" content="Créez des formulaires de contact, réservation, inscription et devis sans code. Constructeur drag & drop, anti-spam, paiements intégrés.">
    
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
           PAGE DÉTAIL FORMULAIRES — STYLES COMPLETS
           ============================================ */
        
        /* Reset & Base */
        .nl-detail-container {
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
        
        /* Navigation Rapide */
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
            height: 40px;
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
        .nl-detail-hero {
            background: linear-gradient(135deg, #0a1628 0%, #1a2a4a 100%);
            padding: 80px 0 60px;
            position: relative;
            overflow: hidden;
        }
        
        .nl-detail-hero::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -20%;
            width: 70%;
            height: 160%;
            background: radial-gradient(circle, rgba(232,118,26,0.12) 0%, transparent 70%);
            pointer-events: none;
        }
        
        .nl-detail-container {
            position: relative;
            z-index: 2;
        }
        
        .nl-detail-hero .nl-detail-container {
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
        
        .nl-detail-hero h1 {
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
        
        .nl-hero-trust {
            display: flex;
            gap: 32px;
            flex-wrap: wrap;
        }
        
        .nl-trust-stars, .nl-trust-users {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: rgba(255,255,255,0.6);
        }
        
        .nl-trust-stars i {
            color: #f59e0b;
            font-size: 14px;
        }
        
        /* Hero Visual */
        .nl-builder-preview-3d {
            position: relative;
        }
        
        .nl-preview-window {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 30px 50px -20px rgba(0,0,0,0.5);
        }
        
        .nl-window-bar {
            background: #f1f3f5;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .nl-window-dots {
            display: flex;
            gap: 6px;
        }
        
        .nl-window-dots span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #ff5f57;
        }
        
        .nl-window-dots span:nth-child(2) { background: #febc2e; }
        .nl-window-dots span:nth-child(3) { background: #28c840; }
        
        .nl-window-title {
            font-size: 11px;
            color: #666;
        }
        
        .nl-window-body {
            padding: 24px;
        }
        
        .nl-form-preview {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        .nl-form-group-preview label {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .nl-input-preview {
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 13px;
            background: #fff;
            color: #1a1a1a;
        }
        
        .nl-form-row-preview {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        
        .nl-textarea-preview {
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 14px;
            min-height: 60px;
            background: #fff;
        }
        
        .nl-submit-preview {
            background: #e8761a;
            color: #fff;
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            font-weight: 700;
            font-size: 13px;
        }
        
        .nl-floating-metrics {
            position: absolute;
            bottom: -20px;
            right: -20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .nl-metric {
            background: #fff;
            border-radius: 999px;
            padding: 8px 16px;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            color: #1a1a1a;
        }
        
        .nl-metric i { color: #e8761a; }
        
        /* Types Grid */
        .nl-detail-types {
            padding: 80px 0;
            background: #fff;
        }
        
        .nl-types-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }
        
        .nl-type-card {
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 20px;
            padding: 28px;
            transition: all 0.3s;
            text-align: center;
        }
        
        .nl-type-card:hover {
            transform: translateY(-5px);
            border-color: #e8761a;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }
        
        .nl-type-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 16px;
        }
        
        .nl-type-card h3 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #1a1a1a;
        }
        
        .nl-type-card p {
            font-size: 12px;
            color: #888;
            margin-bottom: 16px;
        }
        
        .nl-type-link {
            font-size: 12px;
            font-weight: 600;
            color: #e8761a;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: gap 0.2s;
        }
        
        .nl-type-link:hover { gap: 10px; }
        
        /* Builder Section */
        .nl-detail-builder {
            padding: 80px 0;
            background: #f8faff;
        }
        
        .nl-builder-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        .nl-builder-features-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin: 32px 0;
        }
        
        .nl-bf-item {
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }
        
        .nl-bf-item i {
            font-size: 20px;
            color: #e8761a;
            flex-shrink: 0;
        }
        
        .nl-bf-item strong {
            display: block;
            font-size: 14px;
            color: #1a1a1a;
            margin-bottom: 4px;
        }
        
        .nl-bf-item span {
            font-size: 13px;
            color: #666;
        }
        
        .mt-4 { margin-top: 24px; }
        
        .nl-builder-mockup {
            background: #fff;
            border-radius: 24px;
            padding: 20px;
            display: flex;
            gap: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
        }
        
        .nl-mockup-sidebar {
            width: 130px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .nl-mockup-field {
            background: #f8faff;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 11px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #374151;
        }
        
        .nl-mockup-canvas {
            flex: 1;
            background: #f8faff;
            border-radius: 16px;
            padding: 16px;
            border: 2px dashed #e5e7eb;
            min-height: 300px;
        }
        
        .nl-mockup-drag-item {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 12px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .drag-handle {
            color: #aaa;
            cursor: grab;
        }
        
        .nl-mockup-submit {
            background: #e8761a;
            color: #fff;
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            font-weight: 700;
            font-size: 12px;
            margin-top: 12px;
        }
        
        /* Fields Grid */
        .nl-detail-fields {
            padding: 80px 0;
            background: #fff;
        }
        
        .nl-fields-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }
        
        .nl-field-card {
            background: #f8faff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
        }
        
        .nl-field-card:hover {
            border-color: #e8761a;
            background: #fff;
        }
        
        .nl-field-icon {
            width: 40px;
            height: 40px;
            background: #fff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #e8761a;
        }
        
        .nl-field-info h4 {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 2px;
        }
        
        .nl-field-info span {
            font-size: 10px;
            color: #888;
        }
        
        /* Features Detail */
        .nl-detail-features {
            padding: 80px 0;
            background: #f8faff;
        }
        
        .nl-features-detail-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        
        .nl-feature-detail-card {
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 20px;
            padding: 32px;
            transition: all 0.3s;
        }
        
        .nl-feature-detail-card:hover {
            transform: translateY(-4px);
            border-color: #e8761a;
        }
        
        .nl-fd-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 20px;
        }
        
        .nl-feature-detail-card h3 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .nl-feature-detail-card p {
            font-size: 13px;
            color: #666;
            line-height: 1.7;
        }
        
        /* Integrations */
        .nl-detail-integrations {
            padding: 80px 0;
            background: #fff;
        }
        
        .nl-integrations-wrapper {
            background: linear-gradient(135deg, #0f2240, #1e3a5f);
            border-radius: 28px;
            padding: 56px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }
        
        .nl-integrations-content .nl-section-tag {
            background: rgba(255,255,255,0.1);
            color: #e8761a;
        }
        
        .nl-integrations-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            color: #fff;
            margin-bottom: 16px;
        }
        
        .nl-integrations-content p {
            font-size: 15px;
            color: rgba(255,255,255,0.7);
            margin-bottom: 24px;
        }
        
        .nl-integrations-logos {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }
        
        .nl-integration-logo {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50px;
            padding: 6px 14px;
            font-size: 12px;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .nl-integrations-more {
            font-size: 13px;
            color: #e8761a;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .nl-diagram {
            background: rgba(255,255,255,0.05);
            border-radius: 20px;
            padding: 24px;
            text-align: center;
        }
        
        .nl-diagram-center {
            background: #e8761a;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #fff;
        }
        
        .nl-diagram-center i { font-size: 28px; margin-bottom: 4px; }
        .nl-diagram-center span { font-size: 10px; font-weight: 700; }
        
        .nl-diagram-arrow {
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #e8761a, transparent);
            margin: 20px 0;
        }
        
        .nl-diagram-items {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
        }
        
        .nl-diagram-item {
            background: #334155;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 12px;
            color: #fff;
        }
        
        /* Pricing */
        .nl-detail-pricing {
            padding: 80px 0;
            background: #f8faff;
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
        
        .nl-price-free {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 48px;
            color: #1a1a1a;
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
        
        /* Demo Section */
        .nl-detail-demo {
            padding: 80px 0;
            background: #fff;
        }
        
        .nl-demo-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        .nl-demo-steps {
            list-style: none;
            margin: 24px 0 32px;
        }
        
        .nl-demo-steps li {
            padding: 8px 0;
            font-size: 14px;
            color: #444;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .nl-demo-steps li i {
            color: #10b981;
        }
        
        .nl-video-placeholder {
            background: linear-gradient(135deg, #1a2a4a, #0a1628);
            border-radius: 24px;
            aspect-ratio: 16/9;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
        }
        
        .nl-play-icon {
            width: 70px;
            height: 70px;
            background: #e8761a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: #fff;
            z-index: 2;
        }
        
        .nl-video-overlay {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            color: rgba(255,255,255,0.5);
            font-size: 12px;
        }
        
        /* FAQ */
        .nl-detail-faq {
            padding: 80px 0;
            background: #f8faff;
        }
        
        .nl-faq-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
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
        
        /* Final CTA */
        .nl-detail-cta {
            padding: 80px 0;
            background: linear-gradient(135deg, #fef3ea, #fff3e6);
        }
        
        .nl-final-cta {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .nl-final-cta h2 {
            font-family: 'Playfair Display', serif;
            font-size: 40px;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        .nl-final-cta p {
            font-size: 16px;
            color: #666;
            margin-bottom: 32px;
        }
        
        .nl-final-buttons {
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
        
        .nl-final-note {
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
            .nl-types-grid { grid-template-columns: repeat(3, 1fr); }
            .nl-fields-grid { grid-template-columns: repeat(3, 1fr); }
            .nl-features-detail-grid { grid-template-columns: repeat(2, 1fr); }
            .nl-pricing-grid { grid-template-columns: repeat(2, 1fr); }
            .nl-faq-grid { grid-template-columns: 1fr; }
        }
        
        @media (max-width: 1000px) {
            .nl-detail-hero .nl-detail-container { grid-template-columns: 1fr; }
            .nl-builder-grid { grid-template-columns: 1fr; }
            .nl-integrations-wrapper { grid-template-columns: 1fr; }
            .nl-demo-wrapper { grid-template-columns: 1fr; }
            .nl-types-grid { grid-template-columns: repeat(2, 1fr); }
            .nl-fields-grid { grid-template-columns: repeat(2, 1fr); }
            .nl-nav-links { display: none; }
        }
        
        @media (max-width: 768px) {
            .nl-detail-container { padding: 0 20px; }
            .nl-types-grid { grid-template-columns: 1fr; }
            .nl-fields-grid { grid-template-columns: 1fr; }
            .nl-features-detail-grid { grid-template-columns: 1fr; }
            .nl-pricing-grid { grid-template-columns: 1fr; }
            .nl-pricing-popular { transform: scale(1); }
            .nl-integrations-wrapper { padding: 32px 24px; }
            .nl-builder-mockup { flex-direction: column; }
            .nl-mockup-sidebar { width: 100%; flex-direction: row; flex-wrap: wrap; }
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
            <a href="#formulaires">Formulaires</a>
            <a href="#fonctionnalites">Fonctionnalités</a>
            <a href="#faq">FAQ</a>
            <a href="{{ route('devis') }}" class="nl-nav-cta">Demander un devis</a>
        </div>
    </div>
</nav>

@php
    $tr = function($text) { return $text; }; // Fonction placeholder, à adapter
@endphp

{{-- ============================================ --}}
{{-- CONTENU PRINCIPAL DE LA PAGE --}}
{{-- ============================================ --}}

{{-- HERO SECTION --}}
<section class="nl-detail-hero">
    <div class="nl-detail-container">
        <div class="nl-detail-hero-content">
            <div class="nl-hero-badge">
                <span class="nl-badge-dot"></span>
                Constructeur n°1 des professionnels
            </div>
            <h1>
                Créez des formulaires<br>
                <span class="nl-gradient-text">qui convertissent</span>
            </h1>
            <p class="nl-hero-description">
                Contact, réservation, inscription, devis, sondage, billetterie... Notre constructeur drag & drop vous permet de créer n'importe quel formulaire en quelques minutes. Sans code, sans complexité.
            </p>
            <div class="nl-hero-ctas">
                <a href="{{ route('devis') }}" class="nl-btn-primary btn-lg">
                    <i class="fas fa-plus-circle"></i> Créer mon formulaire gratuitement
                </a>
            </div>
            <div class="nl-hero-trust">
                <div class="nl-trust-stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <span>4.9/5 sur 2 500+ avis</span>
                </div>
                <div class="nl-trust-users">
                    <i class="fas fa-users"></i>
                    <span>+15 000 professionnels nous font confiance</span>
                </div>
            </div>
        </div>
        <div class="nl-detail-hero-visual">
            <div class="nl-builder-preview-3d">
                <div class="nl-preview-window">
                    <div class="nl-window-bar">
                        <div class="nl-window-dots">
                            <span></span><span></span><span></span>
                        </div>
                        <div class="nl-window-title">Formulaire de réservation — GoExploria</div>
                    </div>
                    <div class="nl-window-body">
                        <div class="nl-form-preview">
                            <div class="nl-form-group-preview">
                                <label><i class="fas fa-user"></i> Nom complet</label>
                                <div class="nl-input-preview">Jean Dupont</div>
                            </div>
                            <div class="nl-form-row-preview">
                                <div class="nl-form-group-preview">
                                    <label><i class="fas fa-calendar"></i> Arrivée</label>
                                    <div class="nl-input-preview">15/05/2026</div>
                                </div>
                                <div class="nl-form-group-preview">
                                    <label><i class="fas fa-calendar"></i> Départ</label>
                                    <div class="nl-input-preview">22/05/2026</div>
                                </div>
                            </div>
                            <div class="nl-form-group-preview">
                                <label><i class="fas fa-users"></i> Nombre de personnes</label>
                                <div class="nl-input-preview">2 adultes, 1 enfant</div>
                            </div>
                            <div class="nl-form-group-preview">
                                <label><i class="fas fa-comment"></i> Message</label>
                                <div class="nl-textarea-preview"></div>
                            </div>
                            <div class="nl-submit-preview">
                                <span>Envoyer la demande</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nl-floating-metrics">
                    <div class="nl-metric"><i class="fas fa-chart-line"></i> +42% de conversions</div>
                    <div class="nl-metric"><i class="fas fa-bolt"></i> Création en 2 min</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TYPES DE FORMULAIRES --}}
<section class="nl-detail-types" id="formulaires">
    <div class="nl-detail-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-th-large"></i> Pour tous vos besoins</span>
            <h2>8 types de formulaires<br><span class="nl-gradient-text">prêts à l'emploi</span></h2>
            <p>Des templates professionnels pour chaque usage, personnalisables en quelques clics.</p>
        </div>
        <div class="nl-types-grid">
            <div class="nl-type-card">
                <div class="nl-type-icon" style="background:#e8761a20;color:#e8761a"><i class="fas fa-envelope"></i></div>
                <h3>Contact</h3>
                <p>Captez vos prospects</p>
                <a href="#" class="nl-type-link">Voir le modèle <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="nl-type-card">
                <div class="nl-type-icon" style="background:#3b82f620;color:#3b82f6"><i class="fas fa-calendar-check"></i></div>
                <h3>Réservation</h3>
                <p>Système de booking</p>
                <a href="#" class="nl-type-link">Voir le modèle <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="nl-type-card">
                <div class="nl-type-icon" style="background:#10b98120;color:#10b981"><i class="fas fa-user-plus"></i></div>
                <h3>Inscription</h3>
                <p>Base de données clients</p>
                <a href="#" class="nl-type-link">Voir le modèle <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="nl-type-card">
                <div class="nl-type-icon" style="background:#8b5cf620;color:#8b5cf6"><i class="fas fa-file-invoice"></i></div>
                <h3>Devis</h3>
                <p>Demandes automatiques</p>
                <a href="#" class="nl-type-link">Voir le modèle <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="nl-type-card">
                <div class="nl-type-icon" style="background:#f59e0b20;color:#f59e0b"><i class="fas fa-chart-simple"></i></div>
                <h3>Sondage</h3>
                <p>Collecte d'avis</p>
                <a href="#" class="nl-type-link">Voir le modèle <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="nl-type-card">
                <div class="nl-type-icon" style="background:#ef444420;color:#ef4444"><i class="fas fa-ticket"></i></div>
                <h3>Billeterie</h3>
                <p>Vente d'événements</p>
                <a href="#" class="nl-type-link">Voir le modèle <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="nl-type-card">
                <div class="nl-type-icon" style="background:#06b6d420;color:#06b6d4"><i class="fas fa-phone-alt"></i></div>
                <h3>Rappel</h3>
                <p>Demande de rappel</p>
                <a href="#" class="nl-type-link">Voir le modèle <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="nl-type-card">
                <div class="nl-type-icon" style="background:#ec489a20;color:#ec489a"><i class="fas fa-building"></i></div>
                <h3>Recrutement</h3>
                <p>Candidatures</p>
                <a href="#" class="nl-type-link">Voir le modèle <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

{{-- CONSTRUCTEUR VISUEL --}}
<section class="nl-detail-builder" id="fonctionnalites">
    <div class="nl-detail-container">
        <div class="nl-builder-grid">
            <div class="nl-builder-content">
                <span class="nl-section-tag"><i class="fas fa-wand-magic-sparkles"></i> Constructeur visuel</span>
                <h2>Glissez, déposez,<br><span class="nl-gradient-text">publiez</span></h2>
                <p>Notre interface intuitive vous permet de créer des formulaires professionnels sans aucune compétence technique.</p>
                <div class="nl-builder-features-list">
                    <div class="nl-bf-item">
                        <i class="fas fa-arrows-up-down-left-right"></i>
                        <div>
                            <strong>Drag & drop intuitif</strong>
                            <span>Ajoutez, déplacez et organisez vos champs en un clin d'œil.</span>
                        </div>
                    </div>
                    <div class="nl-bf-item">
                        <i class="fas fa-mobile-alt"></i>
                        <div>
                            <strong>100% responsive</strong>
                            <span>Vos formulaires s'affichent parfaitement sur tous les écrans.</span>
                        </div>
                    </div>
                    <div class="nl-bf-item">
                        <i class="fas fa-palette"></i>
                        <div>
                            <strong>Design personnalisable</strong>
                            <span>Couleurs, polices, bordures : adaptez le style à votre marque.</span>
                        </div>
                    </div>
                    <div class="nl-bf-item">
                        <i class="fas fa-eye"></i>
                        <div>
                            <strong>Aperçu en temps réel</strong>
                            <span>Visualisez les modifications instantanément.</span>
                        </div>
                    </div>
                </div>
                <a href="#" class="nl-btn-primary mt-4">
                    <i class="fas fa-rocket"></i> Essayer le constructeur gratuitement
                </a>
            </div>
            <div class="nl-builder-visual">
                <div class="nl-builder-mockup">
                    <div class="nl-mockup-sidebar">
                        <div class="nl-mockup-field"><i class="fas fa-font"></i> Texte court</div>
                        <div class="nl-mockup-field"><i class="fas fa-envelope"></i> Email</div>
                        <div class="nl-mockup-field"><i class="fas fa-phone"></i> Téléphone</div>
                        <div class="nl-mockup-field"><i class="fas fa-calendar"></i> Date</div>
                        <div class="nl-mockup-field"><i class="fas fa-check-square"></i> Checkbox</div>
                        <div class="nl-mockup-field"><i class="fas fa-list"></i> Sélecteur</div>
                    </div>
                    <div class="nl-mockup-canvas">
                        <div class="nl-mockup-drag-item">Nom complet <span class="drag-handle"><i class="fas fa-grip-vertical"></i></span></div>
                        <div class="nl-mockup-drag-item">Email <span class="drag-handle"><i class="fas fa-grip-vertical"></i></span></div>
                        <div class="nl-mockup-drag-item">Téléphone <span class="drag-handle"><i class="fas fa-grip-vertical"></i></span></div>
                        <div class="nl-mockup-drag-item">Message <span class="drag-handle"><i class="fas fa-grip-vertical"></i></span></div>
                        <div class="nl-mockup-submit">Envoyer</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CHAMPS DISPONIBLES --}}
<section class="nl-detail-fields">
    <div class="nl-detail-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-cubes"></i> +30 types de champs</span>
            <h2>Tous les champs<br><span class="nl-gradient-text">dont vous avez besoin</span></h2>
            <p>Des champs standards aux plus avancés : construisez exactement le formulaire dont vous avez besoin.</p>
        </div>
        <div class="nl-fields-grid">
            <div class="nl-field-card"><div class="nl-field-icon"><i class="fas fa-font"></i></div><div class="nl-field-info"><h4>Texte court</h4><span>Nom, Prénom</span></div></div>
            <div class="nl-field-card"><div class="nl-field-icon"><i class="fas fa-paragraph"></i></div><div class="nl-field-info"><h4>Texte long</h4><span>Message, Commentaire</span></div></div>
            <div class="nl-field-card"><div class="nl-field-icon"><i class="fas fa-envelope"></i></div><div class="nl-field-info"><h4>Email</h4><span>Adresse email</span></div></div>
            <div class="nl-field-card"><div class="nl-field-icon"><i class="fas fa-phone"></i></div><div class="nl-field-info"><h4>Téléphone</h4><span>+33 6 12 34 56 78</span></div></div>
            <div class="nl-field-card"><div class="nl-field-icon"><i class="fas fa-calendar"></i></div><div class="nl-field-info"><h4>Date</h4><span>jj/mm/aaaa</span></div></div>
            <div class="nl-field-card"><div class="nl-field-icon"><i class="far fa-clock"></i></div><div class="nl-field-info"><h4>Heure</h4><span>--:--</span></div></div>
            <div class="nl-field-card"><div class="nl-field-icon"><i class="fas fa-check-square"></i></div><div class="nl-field-info"><h4>Case à cocher</h4><span>Accepter les CGU</span></div></div>
            <div class="nl-field-card"><div class="nl-field-icon"><i class="fas fa-dot-circle"></i></div><div class="nl-field-info"><h4>Bouton radio</h4><span>Choix unique</span></div></div>
            <div class="nl-field-card"><div class="nl-field-icon"><i class="fas fa-list"></i></div><div class="nl-field-info"><h4>Liste déroulante</h4><span>Sélectionnez une option</span></div></div>
            <div class="nl-field-card"><div class="nl-field-icon"><i class="fas fa-sliders-h"></i></div><div class="nl-field-info"><h4>Curseur</h4><span>Note de 0 à 10</span></div></div>
            <div class="nl-field-card"><div class="nl-field-icon"><i class="fas fa-star"></i></div><div class="nl-field-info"><h4>Évaluation</h4><span>⭐ 1 à 5 étoiles</span></div></div>
            <div class="nl-field-card"><div class="nl-field-icon"><i class="fas fa-file-upload"></i></div><div class="nl-field-info"><h4>Fichier</h4><span>CV, photo, document</span></div></div>
            <div class="nl-field-card"><div class="nl-field-icon"><i class="fas fa-credit-card"></i></div><div class="nl-field-info"><h4>Paiement</h4><span>Carte bancaire</span></div></div>
            <div class="nl-field-card"><div class="nl-field-icon"><i class="fas fa-signature"></i></div><div class="nl-field-info"><h4>Signature</h4><span>Signature électronique</span></div></div>
            <div class="nl-field-card"><div class="nl-field-icon"><i class="fas fa-location-dot"></i></div><div class="nl-field-info"><h4>Adresse</h4><span>Autocomplétion Google</span></div></div>
            <div class="nl-field-card"><div class="nl-field-icon"><i class="fas fa-hashtag"></i></div><div class="nl-field-info"><h4>Numérique</h4><span>Quantité, âge</span></div></div>
        </div>
    </div>
</section>

{{-- FONCTIONNALITÉS AVANCÉES --}}
<section class="nl-detail-features">
    <div class="nl-detail-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-crown"></i> Fonctionnalités avancées</span>
            <h2>Plus qu'un simple<br><span class="nl-gradient-text">formulaire</span></h2>
            <p>Des outils puissants pour automatiser et optimiser votre workflow.</p>
        </div>
        <div class="nl-features-detail-grid">
            <div class="nl-feature-detail-card">
                <div class="nl-fd-icon" style="background:#e8761a20;color:#e8761a"><i class="fas fa-code-branch"></i></div>
                <h3>Conditions logiques</h3>
                <p>Affichez ou masquez des champs dynamiquement en fonction des réponses précédentes. Des formulaires intelligents et personnalisés.</p>
            </div>
            <div class="nl-feature-detail-card">
                <div class="nl-fd-icon" style="background:#3b82f620;color:#3b82f6"><i class="fas fa-envelope-open-text"></i></div>
                <h3>Notifications automatiques</h3>
                <p>Envoyez des emails de confirmation, notifications admin, pièces jointes et templates personnalisés.</p>
            </div>
            <div class="nl-feature-detail-card">
                <div class="nl-fd-icon" style="background:#10b98120;color:#10b981"><i class="fas fa-shield-alt"></i></div>
                <h3>Anti-spam intégré</h3>
                <p>Protection reCAPTCHA v3, honeypot, filtrage automatique et blacklist IP. Zéro spam garanti.</p>
            </div>
            <div class="nl-feature-detail-card">
                <div class="nl-fd-icon" style="background:#8b5cf620;color:#8b5cf6"><i class="fas fa-credit-card"></i></div>
                <h3>Paiements intégrés</h3>
                <p>Acceptez Stripe, PayPal, virements. Réservations payantes, acomptes ou paiement en plusieurs fois.</p>
            </div>
            <div class="nl-feature-detail-card">
                <div class="nl-fd-icon" style="background:#f59e0b20;color:#f59e0b"><i class="fas fa-database"></i></div>
                <h3>Stockage & Export</h3>
                <p>Toutes vos soumissions sauvegardées, recherche avancée, export CSV/Excel, connexion directe à Google Sheets.</p>
            </div>
            <div class="nl-feature-detail-card">
                <div class="nl-fd-icon" style="background:#ef444420;color:#ef4444"><i class="fas fa-chart-line"></i></div>
                <h3>Analytics intégré</h3>
                <p>Tableau de bord des conversions, taux d'abandon, heatmaps et rapports personnalisés.</p>
            </div>
        </div>
    </div>
</section>

{{-- INTÉGRATIONS --}}
<section class="nl-detail-integrations">
    <div class="nl-detail-container">
        <div class="nl-integrations-wrapper">
            <div class="nl-integrations-content">
                <span class="nl-section-tag"><i class="fas fa-share-alt"></i> Connectez votre écosystème</span>
                <h2>Vos formulaires<br><span class="nl-gradient-text">connectés à vos outils</span></h2>
                <p>Automatisez vos process : les soumissions sont envoyées automatiquement vers vos applications favorites.</p>
                <div class="nl-integrations-logos">
                    <div class="nl-integration-logo"><i class="fab fa-mailchimp"></i> Mailchimp</div>
                    <div class="nl-integration-logo"><i class="fab fa-salesforce"></i> Salesforce</div>
                    <div class="nl-integration-logo"><i class="fab fa-hubspot"></i> HubSpot</div>
                    <div class="nl-integration-logo"><i class="fab fa-slack"></i> Slack</div>
                    <div class="nl-integration-logo"><i class="fas fa-bolt"></i> Zapier</div>
                    <div class="nl-integration-logo"><i class="fab fa-google"></i> Google Sheets</div>
                    <div class="nl-integration-logo"><i class="fab fa-microsoft"></i> Microsoft 365</div>
                    <div class="nl-integration-logo"><i class="fab fa-wordpress"></i> WordPress</div>
                </div>
                <div class="nl-integrations-more">
                    <i class="fas fa-plus-circle"></i> +50 autres intégrations natives
                </div>
            </div>
            <div class="nl-integrations-diagram">
                <div class="nl-diagram">
                    <div class="nl-diagram-center">
                        <i class="fas fa-wpforms"></i>
                        <span>Formulaire</span>
                    </div>
                    <div class="nl-diagram-arrow"></div>
                    <div class="nl-diagram-items">
                        <div class="nl-diagram-item">CRM</div>
                        <div class="nl-diagram-item">Email marketing</div>
                        <div class="nl-diagram-item">Google Sheets</div>
                        <div class="nl-diagram-item">Slack</div>
                        <div class="nl-diagram-item">API / Webhook</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- DÉMO --}}
<section class="nl-detail-demo" id="demo">
    <div class="nl-detail-container">
        <div class="nl-demo-wrapper">
            <div class="nl-demo-text">
                <span class="nl-section-tag"><i class="fas fa-play-circle"></i> Démonstration</span>
                <h2>Voyez par vous-même<br><span class="nl-gradient-text">en 2 minutes</span></h2>
                <p>Créez votre premier formulaire de A à Z, publiez-le et recevez vos premières soumissions.</p>
                <ul class="nl-demo-steps">
                    <li><i class="fas fa-check-circle"></i> Interface intuitive drag & drop</li>
                    <li><i class="fas fa-check-circle"></i> Personnalisation complète</li>
                    <li><i class="fas fa-check-circle"></i> <strong>Gratuit, sans carte bancaire</strong></li>
                </ul>
                <a href="#" class="nl-btn-primary">
                    <i class="fas fa-rocket"></i> Commencer gratuitement
                </a>
            </div>
            <div class="nl-demo-video">
                <div class="nl-video-placeholder">
                    <div class="nl-play-icon">
                        <i class="fas fa-play"></i>
                    </div>
                    <div class="nl-video-overlay">
                        <span>Cliquez pour voir la démo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="nl-detail-faq" id="faq">
    <div class="nl-detail-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-question-circle"></i> Questions fréquentes</span>
            <h2>Tout ce que vous<br><span class="nl-gradient-text">devez savoir</span></h2>
        </div>
        <div class="nl-faq-grid">
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Puis-je intégrer les formulaires sur mon site existant ?
                </div>
                <div class="nl-faq-answer">
                    Oui ! Vous pouvez intégrer vos formulaires via un simple code embed (iframe ou JavaScript) sur n'importe quel site : WordPress, Shopify, Wix, Webflow, ou même un site sur mesure.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Est-ce que je peux recevoir les notifications par email ?
                </div>
                <div class="nl-faq-answer">
                    Absolument. Vous pouvez configurer des notifications email pour chaque soumission, avec des destinataires multiples, pièces jointes et templates personnalisés.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Les formulaires sont-ils sécurisés ?
                </div>
                <div class="nl-faq-answer">
                    Oui, tous nos formulaires sont hébergés sur des serveurs sécurisés avec certificat SSL, protection anti-spam, validation des données et conformité RGPD.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Puis-je accepter des paiements en ligne ?
                </div>
                <div class="nl-faq-answer">
                    Oui, les paiements Stripe et PayPal sont intégrés. Parfait pour les réservations, inscriptions payantes, dons ou ventes de billets.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Existe-t-il une version d'essai gratuite ?
                </div>
                <div class="nl-faq-answer">
                    Oui ! Le plan gratuit est disponible à vie avec 3 formulaires actifs. Pour les besoins plus avancés, vous pouvez tester le plan Pro 14 jours sans engagement.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Puis-je exporter mes données ?
                </div>
                <div class="nl-faq-answer">
                    Bien sûr. Exportez toutes vos soumissions en CSV ou Excel, ou synchronisez-les automatiquement avec Google Sheets, Airtable ou votre CRM.
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA FINAL --}}
<section class="nl-detail-cta">
    <div class="nl-detail-container">
        <div class="nl-final-cta">
            <h2>Prêt à créer votre premier formulaire ?</h2>
            <p>Rejoignez plus de 15 000 professionnels qui utilisent nos formulaires chaque jour.</p>
            <div class="nl-final-buttons">
                <a href="#" class="nl-btn-primary btn-xl">
                    <i class="fas fa-wpforms"></i> Créer mon formulaire gratuitement
                </a>
                <a href="#" class="nl-btn-outline btn-xl">
                    <i class="fas fa-headset"></i> Parler à un expert
                </a>
            </div>
            <p class="nl-final-note">
                <i class="fas fa-check-circle"></i> Sans carte bancaire · Installation en 2 minutes · Support 24/7
            </p>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="nl-footer">
    <div class="nl-detail-container">
        <p>© 2026 GoExploria Next Level. Tous droits réservés.</p>
    </div>
</footer>

<script>
    // Accordéon FAQ
    document.querySelectorAll('.nl-faq-question').forEach(question => {
        question.addEventListener('click', () => {
            const answer = question.nextElementSibling;
            answer.classList.toggle('active');
            
            // Changer l'icône
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
</script>

</body>
</html>