{{-- ============================================================
     PAGE DÉTAIL — ESPACES PERFORMANCES SEO INTERNATIONAL
     Audit · Optimisation · Suivi de positionnement · Conquête internationale
     ============================================================ --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEO International - Audit & Optimisation | GoExploria Next Level</title>
    <meta name="description" content="Audit SEO complet, optimisation internationale, suivi de positionnement multicanal. Dominez les moteurs de recherche et conquérez de nouveaux marchés.">
    
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
           PAGE DÉTAIL SEO — STYLES COMPLETS
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
            background: rgba(255,255,255,0.05);
            padding: 10px 18px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 12px;
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
        
        /* Dashboard Mock */
        .nl-dashboard-mock {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            position: relative;
        }
        
        .nl-dash-header {
            background: rgba(255,255,255,0.08);
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        
        .nl-dash-header-left {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255,255,255,0.8);
        }
        
        .nl-live-badge {
            font-size: 10px;
            color: #34d399;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .nl-dash-score {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        
        .nl-score-ring {
            position: relative;
            width: 80px;
            height: 80px;
        }
        
        .nl-score-value {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Bebas Neue', sans-serif;
            font-size: 28px;
            color: #e8761a;
        }
        
        .nl-score-info strong {
            display: block;
            font-size: 14px;
            color: #fff;
            margin-bottom: 4px;
        }
        
        .nl-score-info span {
            font-size: 11px;
            color: rgba(255,255,255,0.5);
        }
        
        .nl-dash-metrics {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        .nl-dash-metric-item {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
        }
        
        .nl-metric-label {
            font-size: 11px;
            color: rgba(255,255,255,0.6);
            width: 120px;
        }
        
        .nl-metric-value {
            font-size: 13px;
            font-weight: 700;
            width: 60px;
        }
        
        .nl-metric-value.up { color: #10b981; }
        
        .nl-progress-bar {
            flex: 1;
            height: 5px;
            background: rgba(255,255,255,0.1);
            border-radius: 999px;
            overflow: hidden;
        }
        
        .nl-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #e8761a, #f59e0b);
            border-radius: 999px;
        }
        
        .nl-dash-footer {
            background: rgba(255,255,255,0.05);
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: rgba(255,255,255,0.4);
        }
        
        .nl-ai-badge {
            position: absolute;
            top: 20px;
            right: -10px;
            background: #8b5cf6;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            gap: 6px;
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
        
        /* Process Section */
        .nl-process {
            padding: 80px 0;
            background: #f8faff;
        }
        
        .nl-process-steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-top: 40px;
        }
        
        .nl-step-card {
            text-align: center;
        }
        
        .nl-step-number {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #e8761a, #f59e0b);
            color: #fff;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            margin: 0 auto 20px;
        }
        
        .nl-step-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .nl-step-card p {
            font-size: 13px;
            color: #666;
            line-height: 1.6;
        }
        
        /* International Markets */
        .nl-international {
            padding: 80px 0;
            background: #fff;
        }
        
        .nl-international-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 40px;
        }
        
        .nl-market-card {
            background: #f8faff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.2s;
        }
        
        .nl-market-card:hover {
            background: #fff;
            border-color: #e8761a;
            transform: translateX(4px);
        }
        
        .nl-market-flag {
            font-size: 28px;
        }
        
        .nl-market-info strong {
            display: block;
            font-size: 14px;
            color: #1a1a1a;
        }
        
        .nl-market-info span {
            font-size: 11px;
            color: #888;
        }
        
        .nl-market-volume {
            margin-left: auto;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 20px;
            color: #e8761a;
        }
        
        .nl-market-more {
            text-align: center;
            padding: 16px;
            color: #e8761a;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        /* Tools Section */
        .nl-tools {
            padding: 80px 0;
            background: #f8faff;
        }
        
        .nl-tools-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px;
            margin-top: 40px;
        }
        
        .nl-tool-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 50px;
            padding: 10px 20px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
        }
        
        .nl-tool-card:hover {
            border-color: #e8761a;
            transform: translateY(-2px);
        }
        
        .nl-tool-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        
        .nl-tool-card span {
            font-size: 13px;
            font-weight: 500;
            color: #1a1a1a;
        }
        
        /* Audit Form */
        .nl-audit-form-section {
            padding: 80px 0;
            background: #fff;
        }
        
        .nl-audit-wrapper {
            background: linear-gradient(135deg, #fff, #f8faff);
            border: 1px solid #e5e7eb;
            border-radius: 28px;
            padding: 56px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        .nl-audit-badge {
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
        
        .nl-audit-left h2 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            color: #1a1a1a;
            margin-bottom: 14px;
        }
        
        .nl-audit-left h2 em {
            font-style: italic;
            color: #e8761a;
        }
        
        .nl-audit-left p {
            font-size: 15px;
            color: #666;
            line-height: 1.8;
            margin-bottom: 24px;
        }
        
        .nl-audit-benefits {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .nl-audit-benefits li {
            font-size: 14px;
            color: #444;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .nl-audit-benefits li i {
            color: #10b981;
            font-size: 14px;
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
        .nl-form-group select,
        .nl-form-group textarea {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
            transition: border-color 0.2s;
            font-family: inherit;
        }
        
        .nl-form-group input:focus,
        .nl-form-group select:focus,
        .nl-form-group textarea:focus {
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
        
        /* Case Studies */
        .nl-cases {
            padding: 80px 0;
            background: #f8faff;
        }
        
        .nl-cases-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-top: 40px;
        }
        
        .nl-case-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .nl-case-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .nl-case-header {
            background: linear-gradient(135deg, #0f2240, #1e3a5f);
            padding: 20px;
            color: #fff;
        }
        
        .nl-case-header .nl-case-icon {
            font-size: 32px;
            margin-bottom: 12px;
        }
        
        .nl-case-header h3 {
            font-size: 18px;
            margin-bottom: 8px;
        }
        
        .nl-case-header p {
            font-size: 12px;
            opacity: 0.8;
        }
        
        .nl-case-stats {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .nl-case-stat {
            text-align: center;
        }
        
        .nl-case-stat strong {
            display: block;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 24px;
            color: #e8761a;
        }
        
        .nl-case-stat span {
            font-size: 10px;
            color: #888;
        }
        
        .nl-case-footer {
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .nl-case-footer span {
            font-size: 12px;
            color: #e8761a;
            font-weight: 600;
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
            .nl-process-steps { grid-template-columns: repeat(2, 1fr); }
            .nl-pricing-grid { grid-template-columns: repeat(2, 1fr); }
            .nl-faq-grid { grid-template-columns: 1fr; }
            .nl-cases-grid { grid-template-columns: repeat(2, 1fr); }
        }
        
        @media (max-width: 1000px) {
            .nl-hero .nl-container { grid-template-columns: 1fr; }
            .nl-audit-wrapper { grid-template-columns: 1fr; }
            .nl-nav-links { display: none; }
        }
        
        @media (max-width: 768px) {
            .nl-container { padding: 0 20px; }
            .nl-features-grid { grid-template-columns: 1fr; }
            .nl-process-steps { grid-template-columns: 1fr; }
            .nl-international-grid { grid-template-columns: 1fr; }
            .nl-pricing-grid { grid-template-columns: 1fr; }
            .nl-cases-grid { grid-template-columns: 1fr; }
            .nl-pricing-popular { transform: scale(1); }
            .nl-audit-wrapper { padding: 32px 24px; }
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
            <a href="#process">Notre méthode</a>
            <a href="#international">International</a>
            <a href="#faq">FAQ</a>
            <a href="{{ route('devis') }}" class="nl-nav-cta">Audit gratuit</a>
        </div>
    </div>
</nav>

{{-- HERO SECTION --}}
<section class="nl-hero">
    <div class="nl-container">
        <div class="nl-hero-content">
            <div class="nl-hero-badge">
                <span class="nl-badge-dot"></span>
                Audit SEO offert — Diagnostic sous 48h
            </div>
            <h1>
                Dominez les moteurs<br>
                <span class="nl-gradient-text">de recherche internationaux</span>
            </h1>
            <p class="nl-hero-description">
                Notre équipe d'experts certifiés réalise un audit complet de votre site et déploie une stratégie SEO sur mesure pour conquérir de nouveaux marchés. Augmentez votre visibilité, votre trafic et vos conversions.
            </p>
            <div class="nl-hero-ctas">
                <a href="{{ route('devis') }}" class="nl-btn-primary btn-lg">
                    <i class="fas fa-chart-simple"></i> Demander un audit gratuit
                </a>
                <!-- <a href="#features" class="nl-btn-outline btn-lg">
                    <i class="fas fa-eye"></i> Découvrir nos solutions
                </a> -->
            </div>
            <div class="nl-hero-stats">
                <div class="nl-stat">
                    <i class="fas fa-chart-simple"></i>
                    <div>
                        <strong>2 500+</strong>
                        <span>Sites audités</span>
                    </div>
                </div>
                <div class="nl-stat">
                    <i class="fas fa-key"></i>
                    <div>
                        <strong>1.2M+</strong>
                        <span>Mots-clés suivis</span>
                    </div>
                </div>
                <div class="nl-stat">
                    <i class="fas fa-map-marked-alt"></i>
                    <div>
                        <strong>85+</strong>
                        <span>Pays couverts</span>
                    </div>
                </div>
                <div class="nl-stat">
                    <i class="fas fa-rocket"></i>
                    <div>
                        <strong>+127%</strong>
                        <span>Croissance moyenne</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="nl-hero-visual">
            <div class="nl-dashboard-mock">
                <div class="nl-dash-header">
                    <div class="nl-dash-header-left">
                        <i class="fas fa-chart-line"></i> SEO Dashboard — GoExploria
                    </div>
                    <div class="nl-dash-header-right">
                        <span class="nl-live-badge"><i class="fas fa-circle"></i> Live</span>
                    </div>
                </div>
                <div class="nl-dash-score">
                    <div class="nl-score-ring">
                        <svg viewBox="0 0 100 100" width="80" height="80">
                            <circle cx="50" cy="50" r="45" fill="none" stroke="#1e3a5f" stroke-width="8"/>
                            <circle cx="50" cy="50" r="45" fill="none" stroke="#e8761a" stroke-width="8" 
                                    stroke-dasharray="283" stroke-dashoffset="57" transform="rotate(-90 50 50)"/>
                        </svg>
                        <span class="nl-score-value">84</span>
                    </div>
                    <div class="nl-score-info">
                        <strong>Score SEO global</strong>
                        <span>Excellent — Top 10% des sites</span>
                    </div>
                </div>
                <div class="nl-dash-metrics">
                    <div class="nl-dash-metric-item">
                        <span class="nl-metric-label">Trafic organique</span>
                        <span class="nl-metric-value up">+42%</span>
                        <div class="nl-progress-bar"><div class="nl-progress-fill" style="width:72%"></div></div>
                    </div>
                    <div class="nl-dash-metric-item">
                        <span class="nl-metric-label">Mots-clés Top 10</span>
                        <span class="nl-metric-value up">+156</span>
                        <div class="nl-progress-bar"><div class="nl-progress-fill" style="width:64%"></div></div>
                    </div>
                    <div class="nl-dash-metric-item">
                        <span class="nl-metric-label">Backlinks</span>
                        <span class="nl-metric-value up">+2.4k</span>
                        <div class="nl-progress-bar"><div class="nl-progress-fill" style="width:58%"></div></div>
                    </div>
                    <div class="nl-dash-metric-item">
                        <span class="nl-metric-label">Taux de conversion</span>
                        <span class="nl-metric-value up">+18%</span>
                        <div class="nl-progress-bar"><div class="nl-progress-fill" style="width:51%"></div></div>
                    </div>
                </div>
                <div class="nl-dash-footer">
                    <span><i class="fab fa-google"></i> Dernier crawl : il y a 2h</span>
                    <span><i class="fas fa-chart-line"></i> Position moyenne : #4.2</span>
                </div>
            </div>
            <div class="nl-ai-badge">
                <i class="fas fa-microchip"></i> Analyse IA intégrée
            </div>
        </div>
    </div>
</section>

{{-- FEATURES SECTION --}}
<section class="nl-features" id="features">
    <div class="nl-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-cogs"></i> Nos solutions SEO</span>
            <h2>Une stratégie complète<br><span class="nl-gradient-text">pour chaque objectif</span></h2>
            <p>De l'audit technique à la conquête internationale, nous couvrons tous les aspects du SEO moderne.</p>
        </div>
        <div class="nl-features-grid">
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#e8761a20;color:#e8761a"><i class="fas fa-chart-line"></i></div>
                <h3>Audit SEO Complet</h3>
                <p>Analyse approfondie de votre site : structure technique, maillage interne, contenu, backlinks et concurrents.</p>
                <div class="nl-feature-tag" style="background:#e8761a15;color:#e8761a">Diagnostic 360°</div>
            </div>
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#3b82f620;color:#3b82f6"><i class="fas fa-globe"></i></div>
                <h3>SEO International</h3>
                <p>Optimisation multilingue, balises hreflang, sous-domaines par pays et stratégies de géolocalisation.</p>
                <div class="nl-feature-tag" style="background:#3b82f615;color:#3b82f6">hreflang + ccTLD</div>
            </div>
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#10b98120;color:#10b981"><i class="fas fa-search"></i></div>
                <h3>Recherche de Mots-clés</h3>
                <p>Identification des meilleures opportunités sémantiques par marché, volume de recherche et intention d'achat.</p>
                <div class="nl-feature-tag" style="background:#10b98115;color:#10b981">Longue traîne</div>
            </div>
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#8b5cf620;color:#8b5cf6"><i class="fas fa-tachometer-alt"></i></div>
                <h3>Suivi de Positionnement</h3>
                <p>Tableau de bord temps réel avec alertes, historique des positions et analyse de la concurrence.</p>
                <div class="nl-feature-tag" style="background:#8b5cf615;color:#8b5cf6">Monitoring 24/7</div>
            </div>
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#f59e0b20;color:#f59e0b"><i class="fas fa-link"></i></div>
                <h3>Netlinking Stratégique</h3>
                <p>Campagnes de backlinks qualitatifs, désaveu des liens toxiques et audit de profil de liens entrants.</p>
                <div class="nl-feature-tag" style="background:#f59e0b15;color:#f59e0b">Authority building</div>
            </div>
            <div class="nl-feature-card">
                <div class="nl-feature-icon" style="background:#ef444420;color:#ef4444"><i class="fas fa-mobile-alt"></i></div>
                <h3>Core Web Vitals</h3>
                <p>Optimisation des performances techniques : LCP, FID, CLS. Score Google PageSpeed au top.</p>
                <div class="nl-feature-tag" style="background:#ef444415;color:#ef4444">Performance</div>
            </div>
        </div>
    </div>
</section>

{{-- PROCESS SECTION --}}
<section class="nl-process" id="process">
    <div class="nl-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-chart-line"></i> Notre méthode</span>
            <h2>Une approche <span class="nl-gradient-text">en 4 étapes</span></h2>
            <p>De l'audit à la mise en œuvre, nous vous accompagnons à chaque phase.</p>
        </div>
        <div class="nl-process-steps">
            <div class="nl-step-card">
                <div class="nl-step-number">1</div>
                <h3>Audit & Diagnostic</h3>
                <p>Analyse complète de votre site, de vos concurrents et de votre marché.</p>
            </div>
            <div class="nl-step-card">
                <div class="nl-step-number">2</div>
                <h3>Stratégie sur mesure</h3>
                <p>Définition des objectifs, sélection des mots-clés et plan d'action.</p>
            </div>
            <div class="nl-step-card">
                <div class="nl-step-number">3</div>
                <h3>Optimisation & Déploiement</h3>
                <p>Mise en œuvre technique, rédaction de contenu et netlinking.</p>
            </div>
            <div class="nl-step-card">
                <div class="nl-step-number">4</div>
                <h3>Suivi & Reporting</h3>
                <p>Tableau de bord personnalisé, alertes et rapports mensuels.</p>
            </div>
        </div>
    </div>
</section>

{{-- INTERNATIONAL MARKETS --}}
<section class="nl-international" id="international">
    <div class="nl-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-globe-americas"></i> Couverture mondiale</span>
            <h2>Positionnez-vous sur<br><span class="nl-gradient-text">les marchés internationaux</span></h2>
            <p>Notre technologie suit votre performance sur plus de 85 pays et 120 moteurs de recherche différents.</p>
        </div>
        <div class="nl-international-grid">
            <div class="nl-market-card">
                <div class="nl-market-flag">🇫🇷</div>
                <div class="nl-market-info">
                    <strong>France</strong>
                    <span>Google.fr</span>
                </div>
                <div class="nl-market-volume">8.2M</div>
            </div>
            <div class="nl-market-card">
                <div class="nl-market-flag">🇨🇦</div>
                <div class="nl-market-info">
                    <strong>Canada (QC)</strong>
                    <span>Google.ca</span>
                </div>
                <div class="nl-market-volume">3.1M</div>
            </div>
            <div class="nl-market-card">
                <div class="nl-market-flag">🇪🇸</div>
                <div class="nl-market-info">
                    <strong>Espagne</strong>
                    <span>Google.es</span>
                </div>
                <div class="nl-market-volume">4.5M</div>
            </div>
            <div class="nl-market-card">
                <div class="nl-market-flag">🇩🇪</div>
                <div class="nl-market-info">
                    <strong>Allemagne</strong>
                    <span>Google.de</span>
                </div>
                <div class="nl-market-volume">6.8M</div>
            </div>
            <div class="nl-market-card">
                <div class="nl-market-flag">🇬🇧</div>
                <div class="nl-market-info">
                    <strong>Royaume-Uni</strong>
                    <span>Google.co.uk</span>
                </div>
                <div class="nl-market-volume">7.2M</div>
            </div>
            <div class="nl-market-card">
                <div class="nl-market-flag">🇺🇸</div>
                <div class="nl-market-info">
                    <strong>États-Unis</strong>
                    <span>Google.com</span>
                </div>
                <div class="nl-market-volume">22.5M</div>
            </div>
            <div class="nl-market-more">
                <i class="fas fa-plus-circle"></i> +79 autres pays
            </div>
        </div>
    </div>
</section>

{{-- TOOLS INTEGRATION --}}
<section class="nl-tools">
    <div class="nl-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-tools"></i> Intégrations natives</span>
            <h2>Connecté à vos<br><span class="nl-gradient-text">outils SEO préférés</span></h2>
            <p>Synchronisez vos données et centralisez votre stratégie SEO.</p>
        </div>
        <div class="nl-tools-grid">
            <div class="nl-tool-card">
                <div class="nl-tool-icon" style="background:#4285f420;color:#4285f4"><i class="fab fa-google"></i></div>
                <span>Google Search Console</span>
            </div>
            <div class="nl-tool-card">
                <div class="nl-tool-icon" style="background:#ff642d20;color:#ff642d"><i class="fas fa-chart-line"></i></div>
                <span>SEMrush</span>
            </div>
            <div class="nl-tool-card">
                <div class="nl-tool-icon" style="background:#6c5ce720;color:#6c5ce7"><i class="fas fa-chart-network"></i></div>
                <span>Ahrefs</span>
            </div>
            <div class="nl-tool-card">
                <div class="nl-tool-icon" style="background:#10b98120;color:#10b981"><i class="fas fa-frog"></i></div>
                <span>Screaming Frog</span>
            </div>
            <div class="nl-tool-card">
                <div class="nl-tool-icon" style="background:#34a85320;color:#34a853"><i class="fab fa-google"></i></div>
                <span>Google Analytics</span>
            </div>
            <div class="nl-tool-card">
                <div class="nl-tool-icon" style="background:#1e3a5f20;color:#1e3a5f"><i class="fas fa-crown"></i></div>
                <span>Majestic</span>
            </div>
            <div class="nl-tool-card">
                <div class="nl-tool-icon" style="background:#e8761a20;color:#e8761a"><i class="fas fa-code"></i></div>
                <span>API ouverte — Webhooks</span>
            </div>
        </div>
    </div>
</section>

{{-- AUDIT FORM --}}
<section class="nl-audit-form-section" id="audit-form">
    <div class="nl-container">
        <div class="nl-audit-wrapper">
            <div class="nl-audit-left">
                <div class="nl-audit-badge">
                    <i class="fas fa-gift"></i> 100% gratuit — sans engagement
                </div>
                <h2>Recevez votre audit SEO<br><em>personnalisé sous 48h</em></h2>
                <p>Analyse technique, étude des mots-clés, benchmark concurrentiel, recommandations prioritaires. Un expert SEO vous remet un rapport complet et stratégique.</p>
                <ul class="nl-audit-benefits">
                    <li><i class="fas fa-check-circle"></i> Score SEO technique global</li>
                    <li><i class="fas fa-check-circle"></i> Top 20 mots-clés à fort potentiel</li>
                    <li><i class="fas fa-check-circle"></i> Analyse des 3 concurrents directs</li>
                    <li><i class="fas fa-check-circle"></i> Plan d'action prioritaire sur 90 jours</li>
                    <li><i class="fas fa-check-circle"></i> Estimation du ROI potentiel</li>
                </ul>
            </div>
            <div class="nl-audit-right">
                <form class="nl-audit-form" id="nlAuditForm">
                    <div class="nl-form-group">
                        <label>URL de votre site web</label>
                        <input type="url" placeholder="https://www.votresite.com" required>
                    </div>
                    <div class="nl-form-row">
                        <div class="nl-form-group">
                            <label>Votre email professionnel</label>
                            <input type="email" placeholder="contact@entreprise.com" required>
                        </div>
                        <div class="nl-form-group">
                            <label>Votre nom</label>
                            <input type="text" placeholder="Jean Dupont" required>
                        </div>
                    </div>
                    <div class="nl-form-group">
                        <label>Marchés cibles</label>
                        <select required>
                            <option value="">Sélectionnez vos marchés</option>
                            <option>France 🇫🇷</option>
                            <option>Canada (Québec) 🇨🇦</option>
                            <option>Belgique 🇧🇪</option>
                            <option>Suisse 🇨🇭</option>
                            <option>International 🌍</option>
                        </select>
                    </div>
                    <div class="nl-form-group">
                        <label>Message (optionnel)</label>
                        <textarea rows="3" placeholder="Décrivez vos objectifs ou contraintes spécifiques..."></textarea>
                    </div>
                    <button type="submit" class="nl-btn-submit">
                        <i class="fas fa-chart-line"></i> Recevoir mon audit gratuit
                    </button>
                    <p class="nl-form-note">
                        Réponse garantie sous 48h · Aucun spam · Confidentialité assurée
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- CASE STUDIES --}}
<section class="nl-cases">
    <div class="nl-container">
        <div class="nl-section-header text-center">
            <span class="nl-section-tag"><i class="fas fa-medal"></i> Ils nous font confiance</span>
            <h2>Des résultats <span class="nl-gradient-text">concrets et mesurables</span></h2>
            <p>Découvrez comment nous avons transformé la visibilité de nos clients.</p>
        </div>
        <div class="nl-cases-grid">
            <div class="nl-case-card">
                <div class="nl-case-header">
                    <div class="nl-case-icon"><i class="fas fa-hotel"></i></div>
                    <h3>Groupe Hôtelier International</h3>
                    <p>+245% de trafic organique en 6 mois</p>
                </div>
                <div class="nl-case-stats">
                    <div class="nl-case-stat"><strong>+245%</strong><span>Trafic</span></div>
                    <div class="nl-case-stat"><strong>Top 3</strong><span>Mots-clés</span></div>
                    <div class="nl-case-stat"><strong>+180%</strong><span>Réservations</span></div>
                </div>
                <div class="nl-case-footer">
                    <span><i class="fas fa-globe"></i> 12 pays couverts</span>
                    <span>Lire l'étude →</span>
                </div>
            </div>
            <div class="nl-case-card">
                <div class="nl-case-header">
                    <div class="nl-case-icon"><i class="fas fa-store"></i></div>
                    <h3>E-commerce Mode</h3>
                    <p>+127% de chiffre d'affaires SEO</p>
                </div>
                <div class="nl-case-stats">
                    <div class="nl-case-stat"><strong>+127%</strong><span>CA SEO</span></div>
                    <div class="nl-case-stat"><strong>+2.4k</strong><span>Mots-clés</span></div>
                    <div class="nl-case-stat"><strong>#1</strong><span>Position moyenne</span></div>
                </div>
                <div class="nl-case-footer">
                    <span><i class="fas fa-chart-line"></i> ROI x4.2</span>
                    <span>Lire l'étude →</span>
                </div>
            </div>
            <div class="nl-case-card">
                <div class="nl-case-header">
                    <div class="nl-case-icon"><i class="fas fa-chalkboard-user"></i></div>
                    <h3>Agence Touristique</h3>
                    <p>+89% de leads qualifiés</p>
                </div>
                <div class="nl-case-stats">
                    <div class="nl-case-stat"><strong>+89%</strong><span>Leads</span></div>
                    <div class="nl-case-stat"><strong>Top 5</strong><span>Destinations</span></div>
                    <div class="nl-case-stat"><strong>-42%</strong><span>CPA</span></div>
                </div>
                <div class="nl-case-footer">
                    <span><i class="fas fa-map-marked-alt"></i> 8 pays ciblés</span>
                    <span>Lire l'étude →</span>
                </div>
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
                    Combien de temps pour voir les premiers résultats SEO ?
                </div>
                <div class="nl-faq-answer">
                    Les premiers signes d'amélioration apparaissent généralement entre 4 et 8 semaines. Pour des résultats significatifs sur des mots-clés concurrentiels, comptez 4 à 6 mois. Nous fournissons des rapports mensuels détaillant chaque progression.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Qu'est-ce qui est inclus dans l'audit SEO gratuit ?
                </div>
                <div class="nl-faq-answer">
                    L'audit gratuit comprend : analyse technique (200+ critères), étude des 20 mots-clés les plus pertinents, benchmark de 3 concurrents, et un plan d'action prioritaire sur 90 jours. Tout cela dans un rapport PDF détaillé.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Comment gérez-vous le SEO international ?
                </div>
                <div class="nl-faq-answer">
                    Nous mettons en place une stratégie complète : balises hreflang, URLs localisées (ccTLD ou sous-répertoires), contenu traduit et adapté culturellement, et suivi des positions par pays/moteur de recherche.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Proposez-vous un suivi des positions en temps réel ?
                </div>
                <div class="nl-faq-answer">
                    Oui ! Notre tableau de bord vous permet de suivre vos positions quotidiennement sur l'ensemble de vos mots-clés, avec alertes personnalisables et historique des évolutions.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Que se passe-t-il après l'audit gratuit ?
                </div>
                <div class="nl-faq-answer">
                    Un expert SEO vous présente les résultats en visio-conférence. Il n'y a aucune obligation de souscrire à nos services. Nous restons à votre disposition pour toute question.
                </div>
            </div>
            <div class="nl-faq-item">
                <div class="nl-faq-question">
                    <i class="fas fa-plus-circle"></i>
                    Travaillez-vous avec tous les CMS ?
                </div>
                <div class="nl-faq-answer">
                    Absolument ! Nous sommes experts sur tous les CMS : WordPress, Shopify, PrestaShop, Magento, Drupal, Webflow, Wix, ou sites sur mesure. Nos recommandations sont adaptées à votre technologie.
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA FINAL --}}
<section class="nl-cta">
    <div class="nl-container">
        <div class="nl-cta-content">
            <h2>Prêt à dominer les résultats de recherche ?</h2>
            <p>Des centaines de sites nous confient leur stratégie SEO. Obtenez un diagnostic complet et reprenez l'avantage sur vos concurrents.</p>
            <div class="nl-cta-buttons">
                <a href="#audit-form" class="nl-btn-primary btn-xl">
                    <i class="fas fa-chart-simple"></i> Lancer mon audit gratuit
                </a>
                <a href="#cases" class="nl-btn-outline btn-xl">
                    <i class="fas fa-file-alt"></i> Voir nos cas clients
                </a>
            </div>
            <p class="nl-cta-note">
                <i class="fas fa-check-circle"></i> Audit gratuit sans engagement · Rapport sous 48h · Aucun spam
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

    // Formulaire audit
    document.getElementById('nlAuditForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Merci ! Votre demande d\'audit SEO a été envoyée. Un expert vous contactera sous 48h.');
        this.reset();
    });
</script>

</body>
</html>