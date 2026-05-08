{{-- ============================================================
     PAGE DÉTAIL — ESPACES API (Version autonome)
     API REST · Webhooks temps réel · Intégrations · Automatisation
     ============================================================ --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Next Level - Connectez votre écosystème | GoExploria</title>
    <meta name="description" content="API RESTful complète, webhooks temps réel, intégrations natives. Connectez vos outils, automatisez vos flux et boostez votre productivité.">
    
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
           PAGE DÉTAIL API — STYLES COMPLETS
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
            gap: 32px;
            flex-wrap: wrap;
        }
        
        .nl-stat {
            text-align: left;
        }
        
        .nl-stat strong {
            display: block;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 38px;
            color: #e8761a;
            line-height: 1;
        }
        
        .nl-stat span {
            font-size: 11px;
            color: rgba(255,255,255,0.55);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-top: 4px;
            display: block;
        }
        
        /* Code Window */
        .nl-code-window {
            background: #0d1117;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
        }
        
        .nl-code-header {
            background: #161b22;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid #30363d;
        }
        
        .nl-code-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
        .nl-code-dot.red { background: #ff5f57; }
        .nl-code-dot.yellow { background: #febc2e; }
        .nl-code-dot.green { background: #28c840; }
        
        .nl-code-title {
            margin-left: 8px;
            font-size: 11px;
            color: #8b949e;
            font-family: monospace;
        }
        
        .nl-code-body {
            padding: 20px;
            overflow-x: auto;
        }
        
        .nl-code-body pre {
            margin: 0;
            font-family: 'Fira Code', 'Courier New', monospace;
            font-size: 11px;
            line-height: 1.6;
            color: #e6edf3;
        }
        
        .nl-floating-badge {
            position: absolute;
            bottom: -15px;
            right: -15px;
            background: #e8761a;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 8px 16px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 8px 20px rgba(232,118,26,0.4);
        }
        
        .nl-hero-visual {
            position: relative;
        }
        
        /* Features Grid */
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
            margin-bottom: 20px;
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
        
        /* Integrations */
        .nl-integrations {
            padding: 80px 0;
            background: #f8faff;
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
        
        /* Webhooks Demo */
        .nl-webhooks {
            padding: 80px 0;
            background: #fff;
        }
        
        .nl-webhooks-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        .nl-webhook-config {
            background: #f8faff;
            border: 1.5px solid #e5e7eb;
            border-radius: 20px;
            padding: 32px;
        }
        
        .nl-config-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 16px;
            margin-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .nl-config-title {
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .nl-config-status {
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 6px;
            color: #10b981;
        }
        
        .nl-config-field {
            margin-bottom: 20px;
        }
        
        .nl-config-field label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #888;
            margin-bottom: 6px;
        }
        
        .nl-config-input {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 13px;
            color: #1a1a1a;
            font-family: monospace;
        }
        
        .nl-config-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .nl-config-tag {
            background: #eff6ff;
            color: #3b82f6;
            font-size: 11px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
        }
        
        .nl-config-actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }
        
        .nl-config-btn {
            background: #f1f3f5;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #555;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: default;
        }
        
        .nl-features-list {
            list-style: none;
            margin: 24px 0;
        }
        
        .nl-features-list li {
            padding: 10px 0;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .nl-features-list li i {
            color: #10b981;
        }
        
        /* API Endpoints */
        .nl-endpoints {
            padding: 80px 0;
            background: #f8faff;
        }
        
        .nl-endpoints-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .nl-endpoint-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 20px 24px;
            transition: all 0.2s;
        }
        
        .nl-endpoint-card:hover {
            border-color: #e8761a;
        }
        
        .nl-endpoint-method {
            display: inline-block;
            font-size: 10px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            margin-bottom: 12px;
        }
        
        .method-get { background: #10b98120; color: #10b981; }
        .method-post { background: #3b82f620; color: #3b82f6; }
        .method-put { background: #f59e0b20; color: #f59e0b; }
        .method-delete { background: #ef444420; color: #ef4444; }
        
        .nl-endpoint-url {
            font-family: monospace;
            font-size: 14px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .nl-endpoint-desc {
            font-size: 12px;
            color: #666;
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
            .nl-pricing-grid { grid-template-columns: repeat(2, 1fr); }
            .nl-faq-grid { grid-template-columns: 1fr; }
        }
        
        @media (max-width: 1000px) {
            .nl-hero .nl-container { grid-template-columns: 1fr; }
            .nl-integrations-wrapper { grid-template-columns: 1fr; }
            .nl-webhooks-grid { grid-template-columns: 1fr; }
            .nl-endpoints-grid { grid-template-columns: 1fr; }
            .nl-nav-links { display: none; }
        }
        
        @media (max-width: 768px) {
            .nl-container { padding: 0 20px; }
            .nl-features-grid { grid-template-columns: 1fr; }
            .nl-pricing-grid { grid-template-columns: 1fr; }
            .nl-pricing-popular { transform: scale(1); }
            .nl-integrations-wrapper { padding: 32px 24px; }
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
            <a href="#integrations">Intégrations</a>
            <a href="#endpoints">Endpoints</a>
            <a href="#faq">FAQ</a>
            <a href="{{route('devis')}}" class="nl-nav-cta">Demander un devis</a>
        </div>
    </div>
</nav>

{{-- HERO SECTION --}}
<section class="nl-hero">
    <div class="nl-container">
        <div class="nl-hero-content">
            <div class="nl-hero-badge">
                <span class="nl-badge-dot"></span>
                API disponible immédiatement
            </div>
            <h1>
                Une API pensée pour<br>
                <span class="nl-gradient-text">les scale-ups et agences</span>
            </h1>
            <p class="nl-hero-description">
                Connectez vos applications, automatisez vos processus métier et créez des workflows sur mesure. Plus de 200 endpoints documentés, un taux de disponibilité 99,9% et une équipe dédiée à votre succès technique.
            </p>
            <div class="nl-hero-ctas">
                <a href="{{ route('devis') }}" class="nl-btn-primary btn-lg">
                    <i class="fas fa-key"></i> Obtenir mes clés API
                </a>
                <!-- <a href="#" class="nl-btn-outline btn-lg">
                    <i class="fas fa-book"></i> Lire la documentation
                </a> -->
            </div>
            <div class="nl-hero-stats">
                <div class="nl-stat"><strong>200+</strong><span>Endpoints</span></div>
                <div class="nl-stat"><strong>99.9%</strong><span>Uptime SLA</span></div>
                <div class="nl-stat"><strong>&lt;50ms</strong><span>Latence moyenne</span></div>
                <div class="nl-stat"><strong>24/7</strong><span>Support technique</span></div>
            </div>
        </div>
        <div class="nl-hero-visual">
            <div class="nl-code-window">
                <div class="nl-code-header">
                    <span class="nl-code-dot red"></span>
                    <span class="nl-code-dot yellow"></span>
                    <span class="nl-code-dot green"></span>
                    <span class="nl-code-title">POST /webhooks/reservations</span>
                </div>
                <div class="nl-code-body">
                    <pre><code>{
  <span style="color:#f59e0b">"event"</span>: <span style="color:#10b981">"reservation.created"</span>,
  <span style="color:#f59e0b">"timestamp"</span>: <span style="color:#10b981">"2024-01-15T10:30:00Z"</span>,
  <span style="color:#f59e0b">"data"</span>: {
    <span style="color:#f59e0b">"reservation_id"</span>: <span style="color:#10b981">"R-2024-001234"</span>,
    <span style="color:#f59e0b">"customer"</span>: {
      <span style="color:#f59e0b">"name"</span>: <span style="color:#10b981">"Jean Dupont"</span>,
      <span style="color:#f59e0b">"email"</span>: <span style="color:#10b981">"jean@email.com"</span>
    },
    <span style="color:#f59e0b">"amount"</span>: <span style="color:#f59e0b">599.00</span>,
    <span style="color:#f59e0b">"currency"</span>: <span style="color:#10b981">"EUR"</span>
  },
  <span style="color:#f59e0b">"signature"</span>: <span style="color:#10b981">"sha256=abc123def456..."</span>
}</code></pre>
                </div>
            </div>
            <div class="nl-floating-badge">
                <i class="fas fa-bolt"></i> Webhooks en &lt; 100ms
            </div>
        </div>
    </div>
</section>

{{-- FEATURES SECTION --}}
<section class="nl-features" id="features">
    <div class="nl-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-cogs"></i> Fonctionnalités API</span>
            <h2>Une infrastructure <span class="nl-gradient-text">robuste et scalable</span></h2>
            <p>Conçue pour les professionnels qui exigent performance, sécurité et fiabilité.</p>
        </div>
        <div class="nl-features-grid">
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#e8761a20;color:#e8761a"><i class="fas fa-plug"></i></div>
                <h3>API RESTful Complète</h3>
                <p>Accédez à l'intégralité de vos données via une API REST documentée, sécurisée et prête à l'emploi. Authentification OAuth2 et clés API.</p>
                <div class="nl-feature-tag" style="background:#e8761a15;color:#e8761a">Documentée</div>
            </div>
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#3b82f620;color:#3b82f6"><i class="fas fa-code-branch"></i></div>
                <h3>Webhooks Temps Réel</h3>
                <p>Recevez des notifications instantanées sur vos endpoints dès qu'un événement se produit : réservation, paiement, mise à jour produit.</p>
                <div class="nl-feature-tag" style="background:#3b82f615;color:#3b82f6">Temps réel</div>
            </div>
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#10b98120;color:#10b981"><i class="fas fa-chart-network"></i></div>
                <h3>Webhooks Sortants</h3>
                <p>Envoyez automatiquement vos données vers CRM, ERP, outils marketing ou solutions tierces sans aucune intervention manuelle.</p>
                <div class="nl-feature-tag" style="background:#10b98115;color:#10b981">Automatisation</div>
            </div>
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#8b5cf620;color:#8b5cf6"><i class="fas fa-shield-alt"></i></div>
                <h3>Sécurité & Conformité</h3>
                <p>Chiffrement TLS 1.3, validation des signatures HMAC, logs d'audit complets et conformité RGPD pour une intégration sereine.</p>
                <div class="nl-feature-tag" style="background:#8b5cf615;color:#8b5cf6">RGPD compliant</div>
            </div>
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#f59e0b20;color:#f59e0b"><i class="fas fa-database"></i></div>
                <h3>Webhooks Entrants</h3>
                <p>Recevez des données depuis vos applications tierces directement dans votre espace Next Level. Synchronisation bidirectionnelle fluide.</p>
                <div class="nl-feature-tag" style="background:#f59e0b15;color:#f59e0b">Sync intégrée</div>
            </div>
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#ef444420;color:#ef4444"><i class="fas fa-chart-line"></i></div>
                <h3>Tableau de Bord API</h3>
                <p>Console dédiée pour suivre vos appels, logs détaillés, métriques de performance et simulateur de requêtes.</p>
                <div class="nl-feature-tag" style="background:#ef444415;color:#ef4444">Monitoring</div>
            </div>
        </div>
    </div>
</section>

{{-- INTEGRATIONS SECTION --}}
<section class="nl-integrations" id="integrations">
    <div class="nl-container">
        <div class="nl-integrations-wrapper">
            <div class="nl-integrations-content">
                <span class="nl-section-tag"><i class="fas fa-share-alt"></i> Connecteurs natifs</span>
                <h2>Intégrez vos outils<br><span class="nl-gradient-text">préférés en quelques clics</span></h2>
                <p>Notre plateforme propose des connecteurs prêts à l'emploi avec les solutions les plus populaires. Pas de code requis pour les intégrations standards.</p>
                <div class="nl-integrations-logos">
                    <div class="nl-integration-logo"><i class="fab fa-salesforce"></i> Salesforce</div>
                    <div class="nl-integration-logo"><i class="fab fa-hubspot"></i> HubSpot</div>
                    <div class="nl-integration-logo"><i class="fab fa-slack"></i> Slack</div>
                    <div class="nl-integration-logo"><i class="fas fa-bolt"></i> Zapier</div>
                    <div class="nl-integration-logo"><i class="fas fa-cogs"></i> Make</div>
                    <div class="nl-integration-logo"><i class="fab fa-shopify"></i> Shopify</div>
                    <div class="nl-integration-logo"><i class="fab fa-mailchimp"></i> Mailchimp</div>
                    <div class="nl-integration-logo"><i class="fab fa-google"></i> Google</div>
                </div>
                <div class="nl-integrations-more">
                    <i class="fas fa-plus-circle"></i> +50 autres intégrations natives
                </div>
            </div>
            <div class="nl-integrations-diagram">
                <div class="nl-diagram">
                    <div class="nl-diagram-center">
                        <i class="fas fa-code"></i>
                        <span>API Next Level</span>
                    </div>
                    <div class="nl-diagram-arrow"></div>
                    <div class="nl-diagram-items">
                        <div class="nl-diagram-item">CRM</div>
                        <div class="nl-diagram-item">Email marketing</div>
                        <div class="nl-diagram-item">ERP</div>
                        <div class="nl-diagram-item">Slack</div>
                        <div class="nl-diagram-item">Webhook</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- WEBHOOKS DEMO --}}
<section class="nl-webhooks">
    <div class="nl-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-code-branch"></i> Configuration simplifiée</span>
            <h2>Créez vos webhooks<br><span class="nl-gradient-text">en moins de 2 minutes</span></h2>
            <p>Notre interface intuitive vous permet de configurer des webhooks entrants et sortants sans écrire une ligne de code.</p>
        </div>
        <div class="nl-webhooks-grid">
            <div class="nl-webhook-config">
                <div class="nl-config-header">
                    <span class="nl-config-title"><i class="fas fa-sliders-h"></i> Configuration webhook</span>
                    <span class="nl-config-status"><i class="fas fa-circle"></i> Actif</span>
                </div>
                <div class="nl-config-field">
                    <label>Endpoint URL</label>
                    <div class="nl-config-input">https://monapp.com/webhooks/goexploria</div>
                </div>
                <div class="nl-config-field">
                    <label>Événements déclencheurs</label>
                    <div class="nl-config-tags">
                        <span class="nl-config-tag">reservation.created</span>
                        <span class="nl-config-tag">reservation.updated</span>
                        <span class="nl-config-tag">payment.succeeded</span>
                    </div>
                </div>
                <div class="nl-config-field">
                    <label>Signature HMAC</label>
                    <div class="nl-config-input" style="font-family:monospace">whsec_••••••••••••••••••••••</div>
                </div>
                <div class="nl-config-actions">
                    <span class="nl-config-btn"><i class="fas fa-save"></i> Sauvegarder</span>
                    <span class="nl-config-btn"><i class="fas fa-vial"></i> Tester</span>
                    <span class="nl-config-btn"><i class="fas fa-history"></i> Logs</span>
                </div>
            </div>
            <div>
                <h3 style="font-size: 22px; margin-bottom: 16px;">Pourquoi utiliser nos webhooks ?</h3>
                <ul class="nl-features-list">
                    <li><i class="fas fa-check-circle"></i> Réactivité immédiate aux événements</li>
                    <li><i class="fas fa-check-circle"></i> Réduction de la charge serveur</li>
                    <li><i class="fas fa-check-circle"></i> Synchronisation temps réel</li>
                    <li><i class="fas fa-check-circle"></i> Sécurité renforcée (signature HMAC)</li>
                    <li><i class="fas fa-check-circle"></i> Logs détaillés et rejeu automatique</li>
                    <li><i class="fas fa-check-circle"></i> Scalabilité horizontale</li>
                </ul>
                <a href="#" class="nl-btn-primary" style="margin-top: 24px; display: inline-flex;">
                    <i class="fas fa-plus-circle"></i> Créer mon premier webhook
                </a>
            </div>
        </div>
    </div>
</section>

{{-- API ENDPOINTS --}}
<section class="nl-endpoints" id="endpoints">
    <div class="nl-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-code"></i> Endpoints principaux</span>
            <h2>Une API <span class="nl-gradient-text">complète et documentée</span></h2>
            <p>Accédez à toutes les ressources de votre plateforme via notre API RESTful.</p>
        </div>
        <div class="nl-endpoints-grid">
            <div class="nl-endpoint-card">
                <span class="nl-endpoint-method method-get">GET</span>
                <div class="nl-endpoint-url">/api/v1/reservations</div>
                <div class="nl-endpoint-desc">Liste toutes les réservations avec pagination et filtres</div>
            </div>
            <div class="nl-endpoint-card">
                <span class="nl-endpoint-method method-post">POST</span>
                <div class="nl-endpoint-url">/api/v1/reservations</div>
                <div class="nl-endpoint-desc">Crée une nouvelle réservation</div>
            </div>
            <div class="nl-endpoint-card">
                <span class="nl-endpoint-method method-get">GET</span>
                <div class="nl-endpoint-url">/api/v1/reservations/{id}</div>
                <div class="nl-endpoint-desc">Récupère les détails d'une réservation spécifique</div>
            </div>
            <div class="nl-endpoint-card">
                <span class="nl-endpoint-method method-put">PUT</span>
                <div class="nl-endpoint-url">/api/v1/reservations/{id}</div>
                <div class="nl-endpoint-desc">Met à jour une réservation existante</div>
            </div>
            <div class="nl-endpoint-card">
                <span class="nl-endpoint-method method-delete">DELETE</span>
                <div class="nl-endpoint-url">/api/v1/reservations/{id}</div>
                <div class="nl-endpoint-desc">Supprime une réservation</div>
            </div>
            <div class="nl-endpoint-card">
                <span class="nl-endpoint-method method-post">POST</span>
                <div class="nl-endpoint-url">/api/v1/webhooks</div>
                <div class="nl-endpoint-desc">Configure un nouveau webhook</div>
            </div>
        </div>
        <div class="nl-section-header text-center" style="margin-top: 40px;">
            <a href="#" class="nl-btn-outline" style="border-color: #e8761a; color: #e8761a;">
                <i class="fas fa-book"></i> Voir la documentation complète
            </a>
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
                    Comment obtenir mes clés API ?
                </div>
                <div class="nl-faq-answer">
                    Une fois votre compte créé, rendez-vous dans la section "API" de votre tableau de bord. Vous pourrez générer vos clés API (public et secret) en un clic.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Quelle est la limite de taux (rate limiting) ?
                </div>
                <div class="nl-faq-answer">
                    Les limites varient selon votre plan. Le plan gratuit permet 100 requêtes/minute, Pro 500/minute, Business 2000/minute. Des alertes vous préviennent avant d'atteindre les limites.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Comment sécuriser mes webhooks ?
                </div>
                <div class="nl-faq-answer">
                    Nous générons une signature HMAC unique pour chaque webhook. Vous pouvez vérifier cette signature dans votre endpoint pour garantir que la requête provient bien de nos serveurs.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Puis-je tester l'API sans souscrire ?
                </div>
                <div class="nl-faq-answer">
                    Oui ! Notre console API interactive vous permet de tester tous les endpoints gratuitement, sans création de compte. Essayez-la directement sur notre documentation.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Que se passe-t-il si un webhook échoue ?
                </div>
                <div class="nl-faq-answer">
                    Notre système réessaie automatiquement jusqu'à 5 fois avec backoff exponentiel. Vous recevez des alertes par email et pouvez visualiser les échecs dans les logs.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    L'API est-elle compatible avec mon langage ?
                </div>
                <div class="nl-faq-answer">
                    Absolument ! Notre API REST fonctionne avec tous les langages : JavaScript, Python, PHP, Ruby, Java, C#, Go, etc. Nous fournissons des SDK officiels pour les plus populaires.
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA FINAL --}}
<section class="nl-cta">
    <div class="nl-container">
        <div class="nl-cta-content">
            <h2>Prêt à connecter votre écosystème ?</h2>
            <p>Obtenez vos clés API dès aujourd'hui et commencez à automatiser vos flux. Support technique dédié pour vous accompagner dans votre intégration.</p>
            <div class="nl-cta-buttons">
                <a href="#" class="nl-btn-primary btn-xl">
                    <i class="fas fa-key"></i> Obtenir mes clés API
                </a>
                <a href="#" class="nl-btn-outline btn-xl">
                    <i class="fas fa-headset"></i> Contacter le support API
                </a>
            </div>
            <p class="nl-cta-note">
                <i class="fas fa-check-circle"></i> Sans engagement · Premier mois offert · Support technique inclus
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
</script>

</body>
</html>