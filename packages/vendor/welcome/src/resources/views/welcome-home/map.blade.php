<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('home-v2.home.meta_description') }}">
    <title>{{ __('home-v2.home.meta_title') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/welcome/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/vertical-menu-videos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/vertical-destinations-mega.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/destinations-mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/videos-dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/interactive-map.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/viewing-carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/viewing-carousel-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/video-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/slideshows.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/video-player.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/footer.css') }}">

    <style>
       :root {
    --bg-primary:     #f0f6ff;
    --bg-secondary:   #e8f0fe;
    --bg-tertiary:    #dce8fd;
    --bg-card:        #ffffff;
    --border:         #c5d8f8;
    --border-hover:   #1a73e8;
    --text-primary:   #0d1b2e;
    --text-secondary: #2c4a6e;
    --text-muted:     #6b8cb8;
    --accent:         #1a73e8;
    --accent-light:   #e8f0fe;
    --accent-grad:    linear-gradient(135deg, #1a73e8, #0d47a1);
    --shadow-sm:      0 2px 8px rgba(26,115,232,0.08);
    --shadow-md:      0 8px 30px rgba(26,115,232,0.12);
    --shadow-lg:      0 20px 60px rgba(26,115,232,0.15);
    --shadow-accent:  0 8px 30px rgba(26,115,232,0.25);
}

/* ============================================
   HERO
============================================ */
.map-hero {
    position: relative;
    min-height: 100vh;
    background: linear-gradient(160deg, #e8f0fe 0%, #f0f6ff 40%, #dce8fd 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.map-hero-bg {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 15% 50%, rgba(26,115,232,0.1) 0%, transparent 55%),
        radial-gradient(ellipse at 85% 20%, rgba(13,71,161,0.08) 0%, transparent 50%),
        radial-gradient(ellipse at 60% 90%, rgba(66,133,244,0.07) 0%, transparent 50%);
}

.map-hero-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(26,115,232,0.06) 1px, transparent 1px),
        linear-gradient(90deg, rgba(26,115,232,0.06) 1px, transparent 1px);
    background-size: 60px 60px;
}

.map-hero-dots {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
}

.map-hero-dot {
    position: absolute;
    border-radius: 50%;
    opacity: 0.6;
    animation: floatDot 6s ease-in-out infinite;
}

.map-hero-dot:nth-child(1) {
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(26,115,232,0.12), transparent);
    top: -100px; right: 10%;
    animation-delay: 0s;
}
.map-hero-dot:nth-child(2) {
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(13,71,161,0.1), transparent);
    bottom: 10%; left: 5%;
    animation-delay: 2s;
}
.map-hero-dot:nth-child(3) {
    width: 150px; height: 150px;
    background: radial-gradient(circle, rgba(66,133,244,0.1), transparent);
    top: 30%; right: 30%;
    animation-delay: 4s;
}

@keyframes floatDot {
    0%, 100% { transform: translateY(0) scale(1); }
    50%       { transform: translateY(-20px) scale(1.05); }
}

.map-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 900px;
    padding: 0 2rem;
}

.map-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--accent-light);
    border: 1px solid rgba(26,115,232,0.3);
    color: var(--accent);
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
}

.map-hero-title {
    font-family: 'Montserrat', sans-serif;
    font-size: clamp(2.5rem, 6vw, 5rem);
    font-weight: 900;
    color: var(--text-primary);
    line-height: 1.1;
    margin-bottom: 1.5rem;
    letter-spacing: -2px;
}

.map-hero-title span {
    background: var(--accent-grad);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.map-hero-subtitle {
    font-size: 1.15rem;
    color: var(--text-secondary);
    font-weight: 400;
    margin-bottom: 3rem;
    line-height: 1.8;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.map-hero-cta {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.map-hero-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 36px;
    border-radius: 50px;
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: 0.88rem;
    letter-spacing: 1px;
    text-decoration: none;
    text-transform: uppercase;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
}

.map-hero-btn.primary {
    background: var(--accent-grad);
    color: white;
    box-shadow: var(--shadow-accent);
}

.map-hero-btn.primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(26,115,232,0.35);
}

.map-hero-btn.secondary {
    background: white;
    color: var(--text-primary);
    border: 2px solid var(--border);
    box-shadow: var(--shadow-sm);
}

.map-hero-btn.secondary:hover {
    border-color: var(--accent);
    color: var(--accent);
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}

.map-hero-scroll {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    color: var(--text-muted);
    font-size: 0.65rem;
    letter-spacing: 3px;
    text-transform: uppercase;
}

.map-hero-scroll-line {
    width: 1px;
    height: 50px;
    background: linear-gradient(to bottom, var(--accent), transparent);
    animation: scrollLine 2s ease-in-out infinite;
}

@keyframes scrollLine {
    0%, 100% { opacity: 0.4; }
    50%       { opacity: 1; }
}

/* ============================================
   STATS
============================================ */
.map-stats {
    background: var(--bg-card);
    padding: 5rem 2rem;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
}

.map-stats-grid {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
}

.map-stat-item {
    text-align: center;
    padding: 2.5rem 2rem;
    border: 1px solid var(--border);
    border-radius: 20px;
    background: var(--bg-primary);
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
}

.map-stat-item:hover {
    border-color: rgba(26,115,232,0.4);
    box-shadow: var(--shadow-accent);
    transform: translateY(-5px);
    background: white;
}

.map-stat-number {
    font-family: 'Montserrat', sans-serif;
    font-size: 2.8rem;
    font-weight: 900;
    background: var(--accent-grad);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.map-stat-label {
    color: var(--text-muted);
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
}

/* ============================================
   SHARED SECTION STYLES
============================================ */
.map-section-header {
    text-align: center;
    max-width: 680px;
    margin: 0 auto 5rem;
}

.map-section-tag {
    display: inline-block;
    color: var(--accent);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-bottom: 1rem;
    background: var(--accent-light);
    padding: 5px 14px;
    border-radius: 50px;
    border: 1px solid rgba(26,115,232,0.2);
}

.map-section-title {
    font-family: 'Montserrat', sans-serif;
    font-size: clamp(1.8rem, 3.5vw, 2.8rem);
    font-weight: 900;
    color: var(--text-primary);
    line-height: 1.2;
    margin-bottom: 1rem;
    letter-spacing: -1px;
}

.map-section-desc {
    color: var(--text-secondary);
    font-size: 1rem;
    line-height: 1.8;
}

/* ============================================
   FEATURES
============================================ */
.map-features {
    background: var(--bg-secondary);
    padding: 8rem 2rem;
}

.map-features-grid {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}

.map-feature-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 2.5rem;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.map-feature-card::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--accent-grad);
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.map-feature-card:hover::after { transform: scaleX(1); }

.map-feature-card:hover {
    border-color: rgba(26,115,232,0.3);
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
}

.map-feature-icon {
    width: 60px;
    height: 60px;
    background: var(--accent-light);
    border: 1px solid rgba(26,115,232,0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    margin-bottom: 1.5rem;
}

.map-feature-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
}

.map-feature-desc {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.7;
}

/* ============================================
   HOW IT WORKS
============================================ */
.map-how {
    background: var(--bg-primary);
    padding: 8rem 2rem;
}

.map-how-steps {
    max-width: 1000px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
    position: relative;
}

.map-how-steps::before {
    content: '';
    position: absolute;
    top: 40px;
    left: 12%;
    right: 12%;
    height: 2px;
    background: linear-gradient(90deg, #1a73e8, #0d47a1, #1a73e8);
    z-index: 0;
    opacity: 0.25;
}

.map-how-step {
    text-align: center;
    padding: 0 1rem;
    position: relative;
    z-index: 1;
}

.map-how-step-num {
    width: 80px;
    height: 80px;
    background: var(--accent-grad);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Montserrat', sans-serif;
    font-size: 1.4rem;
    font-weight: 900;
    color: white;
    margin: 0 auto 1.5rem;
    box-shadow: var(--shadow-accent);
}

.map-how-step-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.map-how-step-desc {
    color: var(--text-muted);
    font-size: 0.85rem;
    line-height: 1.6;
}

/* ============================================
   MARKER TYPES SHOWCASE
============================================ */
.map-markers {
    background: var(--bg-secondary);
    padding: 8rem 2rem;
}

.map-markers-showcase {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 5rem;
    align-items: center;
}

.map-markers-visual {
    position: relative;
    height: 500px;
    background: linear-gradient(135deg, #dce8fd, #e8f0fe);
    border-radius: 28px;
    overflow: hidden;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-lg);
}

.map-markers-visual-bg {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(26,115,232,0.06) 1px, transparent 1px),
        linear-gradient(90deg, rgba(26,115,232,0.06) 1px, transparent 1px);
    background-size: 40px 40px;
}

.map-markers-pin {
    position: absolute;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    animation: markerFloat 3s ease-in-out infinite;
}

.map-markers-pin:nth-child(2) { top: 20%; left: 25%; animation-delay: 0s; }
.map-markers-pin:nth-child(3) { top: 45%; left: 55%; animation-delay: 0.5s; }
.map-markers-pin:nth-child(4) { top: 65%; left: 28%; animation-delay: 1s; }
.map-markers-pin:nth-child(5) { top: 28%; left: 68%; animation-delay: 1.5s; }
.map-markers-pin:nth-child(6) { top: 70%; left: 65%; animation-delay: 2s; }

@keyframes markerFloat {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-10px); }
}

.map-markers-pin-icon {
    width: 48px;
    height: 48px;
    border-radius: 50% 50% 50% 0;
    transform: rotate(-45deg);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

.map-markers-pin-icon span { transform: rotate(45deg); font-size: 1.3rem; }

.map-markers-pin-icon.restaurant { background: linear-gradient(135deg, #ff6b6b, #ee5a24); }
.map-markers-pin-icon.museum     { background: linear-gradient(135deg, #a29bfe, #6c5ce7); }
.map-markers-pin-icon.hotel      { background: linear-gradient(135deg, #55efc4, #00b894); }
.map-markers-pin-icon.activity   { background: linear-gradient(135deg, #fdcb6e, #e17055); }
.map-markers-pin-icon.service    { background: linear-gradient(135deg, #74b9ff, #0984e3); }

.map-markers-pin-label {
    background: white;
    color: var(--text-primary);
    font-size: 0.7rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    white-space: nowrap;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border);
}

.map-markers-pulse {
    position: absolute;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    border: 2px solid rgba(26,115,232,0.35);
    animation: pulse 2s ease-out infinite;
}

@keyframes pulse {
    0%   { transform: scale(1); opacity: 1; }
    100% { transform: scale(2.8); opacity: 0; }
}

.map-markers-list {
    list-style: none;
    padding: 0;
    margin: 2rem 0;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.map-markers-list li {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.map-markers-list li:hover {
    border-color: rgba(26,115,232,0.4);
    box-shadow: var(--shadow-accent);
    transform: translateX(5px);
}

.map-markers-list-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.map-markers-list-text strong {
    display: block;
    color: var(--text-primary);
    font-size: 0.9rem;
    font-weight: 700;
    margin-bottom: 2px;
}

.map-markers-list-text span {
    color: var(--text-muted);
    font-size: 0.8rem;
}

/* ============================================
   PRICING
============================================ */
.map-pricing {
    background: var(--bg-primary);
    padding: 8rem 2rem;
}

.map-pricing-grid {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    align-items: start;
}

.map-pricing-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 2.5rem;
    transition: all 0.4s ease;
    position: relative;
    box-shadow: var(--shadow-sm);
}

.map-pricing-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-5px);
}

.map-pricing-card.featured {
    background: linear-gradient(160deg, #e8f0fe, #dce8fd);
    border-color: rgba(26,115,232,0.4);
    transform: scale(1.04);
    box-shadow: var(--shadow-accent);
}

.map-pricing-card.featured:hover {
    transform: scale(1.04) translateY(-5px);
}

.map-pricing-badge {
    position: absolute;
    top: -14px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--accent-grad);
    color: white;
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    padding: 6px 20px;
    border-radius: 50px;
    white-space: nowrap;
    box-shadow: var(--shadow-accent);
}

.map-pricing-name {
    font-family: 'Montserrat', sans-serif;
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--text-muted);
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 1rem;
}

.map-pricing-price {
    font-family: 'Montserrat', sans-serif;
    font-size: 3.2rem;
    font-weight: 900;
    color: var(--text-primary);
    line-height: 1;
    margin-bottom: 0.25rem;
}

.map-pricing-price sup {
    font-size: 1.2rem;
    font-weight: 600;
    vertical-align: top;
    margin-top: 0.6rem;
    color: var(--text-secondary);
}

.map-pricing-period {
    color: var(--text-muted);
    font-size: 0.82rem;
    margin-bottom: 2rem;
}

.map-pricing-divider {
    height: 1px;
    background: var(--border);
    margin-bottom: 2rem;
}

.map-pricing-features {
    list-style: none;
    padding: 0;
    margin: 0 0 2rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.map-pricing-features li {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--text-secondary);
    font-size: 0.88rem;
}

.map-pricing-features li i {
    color: var(--accent);
    font-size: 0.8rem;
    flex-shrink: 0;
}

.map-pricing-features li.disabled {
    color: var(--text-muted);
}

.map-pricing-features li.disabled i {
    color: var(--border);
}

.map-pricing-btn {
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: 0.85rem;
    letter-spacing: 1px;
    text-transform: uppercase;
    cursor: pointer;
    border: none;
    transition: all 0.3s ease;
}

.map-pricing-btn.outline {
    background: transparent;
    border: 2px solid var(--border);
    color: var(--text-primary);
}

.map-pricing-btn.outline:hover {
    border-color: var(--accent);
    color: var(--accent);
    background: var(--accent-light);
}

.map-pricing-btn.filled {
    background: var(--accent-grad);
    color: white;
    box-shadow: var(--shadow-accent);
}

.map-pricing-btn.filled:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(26,115,232,0.35);
}

/* ============================================
   CTA
============================================ */
.map-cta {
    background: linear-gradient(160deg, #e8f0fe 0%, #f0f6ff 50%, #dce8fd 100%);
    padding: 8rem 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    border-top: 1px solid var(--border);
}

.map-cta::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 700px;
    height: 700px;
    background: radial-gradient(circle, rgba(26,115,232,0.08) 0%, transparent 70%);
    pointer-events: none;
}

.map-cta-content {
    position: relative;
    z-index: 1;
    max-width: 700px;
    margin: 0 auto;
}

.map-cta-title {
    font-family: 'Montserrat', sans-serif;
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 900;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    letter-spacing: -1px;
    line-height: 1.2;
}

.map-cta-title span {
    background: var(--accent-grad);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.map-cta-desc {
    color: var(--text-secondary);
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 3rem;
}

/* ============================================
   RESPONSIVE
============================================ */
@media (max-width: 1024px) {
    .map-stats-grid       { grid-template-columns: repeat(2, 1fr); }
    .map-features-grid    { grid-template-columns: repeat(2, 1fr); }
    .map-markers-showcase { grid-template-columns: 1fr; }
    .map-markers-visual   { height: 350px; }
    .map-pricing-grid     { grid-template-columns: 1fr; max-width: 420px; }
    .map-pricing-card.featured { transform: scale(1); }
    .map-pricing-card.featured:hover { transform: translateY(-5px); }
}

@media (max-width: 768px) {
    .map-how-steps         { grid-template-columns: repeat(2, 1fr); gap: 2rem; }
    .map-how-steps::before { display: none; }
    .map-features-grid     { grid-template-columns: 1fr; }
    .map-stats-grid        { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 480px) {
    .map-stats-grid  { grid-template-columns: 1fr 1fr; gap: 1rem; }
    .map-hero-cta    { flex-direction: column; align-items: center; }
    .map-hero-btn    { width: 100%; justify-content: center; }
}
    </style>
</head>
<body>
    @include('welcome-home.components.VerticalMenu')
    @include('welcome-home.components.Header1')

    <main class="main-content">

        {{-- HERO --}}
        <section class="map-hero" style="margin-top: 163px;">
            <div class="map-hero-bg"></div>
            <div class="map-hero-grid"></div>
            <div class="map-hero-dots">
                <div class="map-hero-dot"></div>
                <div class="map-hero-dot"></div>
                <div class="map-hero-dot"></div>
            </div>
            <div class="map-hero-content">
                <div class="map-hero-badge">
                    <i class="fas fa-map-marker-alt"></i>
                    GÉO VIDÉOS MAKER
                </div>
                <h1 class="map-hero-title">
                    Marquez votre<br>
                    <span>territoire</span> sur la carte
                </h1>
                <p class="map-hero-subtitle">
                    Créez des marqueurs géolocalisés enrichis de vidéos YouTube, 
                    photos et informations pour promouvoir vos lieux d'intérêt au Québec.
                </p>
                <div class="map-hero-cta">
                    <a href="#carte-interactive" class="map-hero-btn primary">
                        <i class="fas fa-map"></i>
                        Explorer la carte
                    </a>
                    <a href="#comment-ca-marche" class="map-hero-btn secondary">
                        <i class="fas fa-play-circle"></i>
                        Comment ça marche
                    </a>
                </div>
            </div>
            <div class="map-hero-scroll">
                <span>Défiler</span>
                <div class="map-hero-scroll-line"></div>
            </div>
        </section>

        {{-- STATS --}}
        <section class="map-stats">
            <div class="map-stats-grid">
                <div class="map-stat-item">
                    <div class="map-stat-number">2 400+</div>
                    <div class="map-stat-label">Marqueurs actifs</div>
                </div>
                <div class="map-stat-item">
                    <div class="map-stat-number">180+</div>
                    <div class="map-stat-label">Villes couvertes</div>
                </div>
                <div class="map-stat-item">
                    <div class="map-stat-number">95K+</div>
                    <div class="map-stat-label">Vues mensuelles</div>
                </div>
                <div class="map-stat-item">
                    <div class="map-stat-number">4.9★</div>
                    <div class="map-stat-label">Satisfaction client</div>
                </div>
            </div>
        </section>

        {{-- FEATURES --}}
        <section class="map-features">
            <div class="map-section-header">
                <span class="map-section-tag">Fonctionnalités</span>
                <h2 class="map-section-title">Tout ce dont vous avez besoin pour briller sur la carte</h2>
                <p class="map-section-desc">Une plateforme complète pour gérer votre présence géolocalisée avec des contenus multimédias riches.</p>
            </div>
            <div class="map-features-grid">
                <div class="map-feature-card">
                    <div class="map-feature-icon">🎯</div>
                    <h3 class="map-feature-title">Marqueurs personnalisés</h3>
                    <p class="map-feature-desc">Créez des marqueurs uniques par catégorie avec votre identité visuelle et vos couleurs de marque.</p>
                </div>
                <div class="map-feature-card">
                    <div class="map-feature-icon">🎬</div>
                    <h3 class="map-feature-title">Intégration YouTube</h3>
                    <p class="map-feature-desc">Associez vos vidéos YouTube directement à vos marqueurs. Les visiteurs visionnent sans quitter la carte.</p>
                </div>
                <div class="map-feature-card">
                    <div class="map-feature-icon">🔍</div>
                    <h3 class="map-feature-title">Filtres intelligents</h3>
                    <p class="map-feature-desc">Filtrez par ville, catégorie ou zone géographique. Vos clients trouvent exactement ce qu'ils cherchent.</p>
                </div>
                <div class="map-feature-card">
                    <div class="map-feature-icon">📱</div>
                    <h3 class="map-feature-title">100% Responsive</h3>
                    <p class="map-feature-desc">Expérience parfaite sur mobile, tablette et desktop. Vos marqueurs accessibles partout, tout le temps.</p>
                </div>
                <div class="map-feature-card">
                    <div class="map-feature-icon">📊</div>
                    <h3 class="map-feature-title">Analytics en temps réel</h3>
                    <p class="map-feature-desc">Suivez les vues, clics et interactions sur vos marqueurs. Mesurez votre impact géographique.</p>
                </div>
                <div class="map-feature-card">
                    <div class="map-feature-icon">🌐</div>
                    <h3 class="map-feature-title">Réseaux sociaux</h3>
                    <p class="map-feature-desc">Connectez Facebook, Instagram, TikTok, LinkedIn à chaque marqueur. Une vitrine digitale complète.</p>
                </div>
            </div>
        </section>

        {{-- HOW IT WORKS --}}
        <section class="map-how" id="comment-ca-marche">
            <div class="map-section-header">
                <span class="map-section-tag">Processus</span>
                <h2 class="map-section-title">Soyez sur la carte en 4 étapes</h2>
                <p class="map-section-desc">Simple, rapide et efficace. Votre marqueur est en ligne en moins de 10 minutes.</p>
            </div>
            <div class="map-how-steps">
                <div class="map-how-step">
                    <div class="map-how-step-num">01</div>
                    <h3 class="map-how-step-title">Créez votre compte</h3>
                    <p class="map-how-step-desc">Inscrivez-vous gratuitement et accédez à votre tableau de bord.</p>
                </div>
                <div class="map-how-step">
                    <div class="map-how-step-num">02</div>
                    <h3 class="map-how-step-title">Ajoutez votre lieu</h3>
                    <p class="map-how-step-desc">Renseignez l'adresse, la catégorie et les coordonnées GPS.</p>
                </div>
                <div class="map-how-step">
                    <div class="map-how-step-num">03</div>
                    <h3 class="map-how-step-title">Enrichissez le contenu</h3>
                    <p class="map-how-step-desc">Ajoutez vidéos YouTube, photos, réseaux sociaux et contacts.</p>
                </div>
                <div class="map-how-step">
                    <div class="map-how-step-num">04</div>
                    <h3 class="map-how-step-title">Publiez & partagez</h3>
                    <p class="map-how-step-desc">Votre marqueur est visible sur la carte et partageable instantanément.</p>
                </div>
            </div>
        </section>

        {{-- MARKER TYPES --}}
        <section class="map-markers">
            <div class="map-markers-showcase">
                <div class="map-markers-visual">
                    <div class="map-markers-visual-bg"></div>
                    <div class="map-markers-pulse" style="top:43%;left:53%;"></div>
                    <div class="map-markers-pin">
                        <div class="map-markers-pin-icon restaurant"><span>🍽️</span></div>
                        <div class="map-markers-pin-label">Restaurant</div>
                    </div>
                    <div class="map-markers-pin">
                        <div class="map-markers-pin-icon museum"><span>🏛️</span></div>
                        <div class="map-markers-pin-label">Musée</div>
                    </div>
                    <div class="map-markers-pin">
                        <div class="map-markers-pin-icon hotel"><span>🏨</span></div>
                        <div class="map-markers-pin-label">Hôtel</div>
                    </div>
                    <div class="map-markers-pin">
                        <div class="map-markers-pin-icon activity"><span>🎯</span></div>
                        <div class="map-markers-pin-label">Activité</div>
                    </div>
                    <div class="map-markers-pin">
                        <div class="map-markers-pin-icon service"><span>🔧</span></div>
                        <div class="map-markers-pin-label">Service</div>
                    </div>
                </div>
                <div>
                    <span class="map-section-tag">Types de marqueurs</span>
                    <h2 class="map-section-title" style="text-align:left;margin-bottom:0.5rem;">Un marqueur pour chaque établissement</h2>
                    <p class="map-section-desc" style="text-align:left;margin-bottom:0;">Chaque catégorie a son identité visuelle unique pour une navigation intuitive sur la carte.</p>
                    <ul class="map-markers-list">
                        <li>
                            <div class="map-markers-list-icon" style="background:rgba(255,107,107,0.12);">🍽️</div>
                            <div class="map-markers-list-text">
                                <strong>Restaurants & Cafés</strong>
                                <span>Menu, horaires, réservation en ligne</span>
                            </div>
                        </li>
                        <li>
                            <div class="map-markers-list-icon" style="background:rgba(162,155,254,0.12);">🏛️</div>
                            <div class="map-markers-list-text">
                                <strong>Musées & Culture</strong>
                                <span>Expositions, événements, billetterie</span>
                            </div>
                        </li>
                        <li>
                            <div class="map-markers-list-icon" style="background:rgba(85,239,196,0.12);">🏨</div>
                            <div class="map-markers-list-text">
                                <strong>Hôtels & Hébergements</strong>
                                <span>Disponibilités, tarifs, galerie photos</span>
                            </div>
                        </li>
                        <li>
                            <div class="map-markers-list-icon" style="background:rgba(253,203,110,0.12);">🎯</div>
                            <div class="map-markers-list-text">
                                <strong>Activités & Aventures</strong>
                                <span>Expériences, réservations, vidéos</span>
                            </div>
                        </li>
                        <li>
                            <div class="map-markers-list-icon" style="background:rgba(116,185,255,0.12);">🚨</div>
                            <div class="map-markers-list-text">
                                <strong>Urgences & Services</strong>
                                <span>Hôpitaux, pharmacies, pompiers</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- CARTE INTERACTIVE --}}
        @include('welcome-home.components.InteractiveMap')

        {{-- PRICING --}}
        <section class="map-pricing">
            <div class="map-section-header">
                <span class="map-section-tag">Tarifs</span>
                <h2 class="map-section-title">Choisissez votre formule</h2>
                <p class="map-section-desc">Des offres adaptées à chaque besoin, de l'entrepreneur solo à la grande entreprise.</p>
            </div>
            <div class="map-pricing-grid">
                <div class="map-pricing-card">
                    <div class="map-pricing-name">Starter</div>
                    <div class="map-pricing-price"><sup>$</sup>0</div>
                    <div class="map-pricing-period">Gratuit pour toujours</div>
                    <div class="map-pricing-divider"></div>
                    <ul class="map-pricing-features">
                        <li><i class="fas fa-check"></i> 1 marqueur actif</li>
                        <li><i class="fas fa-check"></i> 1 vidéo YouTube</li>
                        <li><i class="fas fa-check"></i> Informations de base</li>
                        <li class="disabled"><i class="fas fa-times"></i> Analytics avancés</li>
                        <li class="disabled"><i class="fas fa-times"></i> Réseaux sociaux</li>
                        <li class="disabled"><i class="fas fa-times"></i> Support prioritaire</li>
                    </ul>
                    <button class="map-pricing-btn outline">Commencer gratuitement</button>
                </div>
                <div class="map-pricing-card featured">
                    <div class="map-pricing-badge">Le plus populaire</div>
                    <div class="map-pricing-name">Business</div>
                    <div class="map-pricing-price"><sup>$</sup>29</div>
                    <div class="map-pricing-period">par mois · facturation annuelle</div>
                    <div class="map-pricing-divider"></div>
                    <ul class="map-pricing-features">
                        <li><i class="fas fa-check"></i> 10 marqueurs actifs</li>
                        <li><i class="fas fa-check"></i> Vidéos illimitées</li>
                        <li><i class="fas fa-check"></i> Analytics complets</li>
                        <li><i class="fas fa-check"></i> Tous les réseaux sociaux</li>
                        <li><i class="fas fa-check"></i> Photos & galerie</li>
                        <li><i class="fas fa-check"></i> Support prioritaire</li>
                    </ul>
                    <button class="map-pricing-btn filled">Démarrer l'essai gratuit</button>
                </div>
                <div class="map-pricing-card">
                    <div class="map-pricing-name">Enterprise</div>
                    <div class="map-pricing-price"><sup>$</sup>99</div>
                    <div class="map-pricing-period">par mois · facturation annuelle</div>
                    <div class="map-pricing-divider"></div>
                    <ul class="map-pricing-features">
                        <li><i class="fas fa-check"></i> Marqueurs illimités</li>
                        <li><i class="fas fa-check"></i> Vidéos illimitées</li>
                        <li><i class="fas fa-check"></i> API dédiée</li>
                        <li><i class="fas fa-check"></i> White label</li>
                        <li><i class="fas fa-check"></i> Intégration sur mesure</li>
                        <li><i class="fas fa-check"></i> Account manager dédié</li>
                    </ul>
                    <button class="map-pricing-btn outline">Contacter les ventes</button>
                </div>
            </div>
        </section>

        {{-- CTA FINAL --}}
        <section class="map-cta">
            <div class="map-cta-content">
                <h2 class="map-cta-title">Prêt à marquer votre <span>territoire</span> ?</h2>
                <p class="map-cta-desc">Rejoignez des centaines d'entreprises québécoises qui utilisent déjà GO EXPLORIA pour se faire découvrir sur la carte.</p>
                <div class="map-hero-cta">
                    <a href="#" class="map-hero-btn primary">
                        <i class="fas fa-rocket"></i>
                        Créer mon marqueur gratuit
                    </a>
                    <a href="#" class="map-hero-btn secondary">
                        <i class="fas fa-phone"></i>
                        Parler à un expert
                    </a>
                </div>
            </div>
        </section>

    </main>

    @include('components.VideoModal')
    @include('welcome-home.components.Footer')

    <script src="{{ asset('js/welcome/carousel.js') }}"></script>
    <script src="{{ asset('js/welcome/navigation.js') }}"></script>
    <script src="{{ asset('js/welcome/menu-api-service.js') }}"></script>
    <script src="{{ asset('js/welcome/mega-menu-service.js') }}"></script>
    <script src="{{ asset('js/welcome/vertical-menu-dynamic.js') }}"></script>
    <script src="{{ asset('js/welcome/vertical-destinations-mega.js') }}"></script>
    <script src="{{ asset('js/welcome/mega-menu.js') }}"></script>
    <script src="{{ asset('js/welcome/destinations-mega-menu.js') }}"></script>
    <script src="{{ asset('js/welcome/destinations-search.js') }}"></script>
    <script src="{{ asset('js/welcome/search-bar.js') }}"></script>
    <script src="{{ asset('js/welcome/map-api-service.js') }}"></script>
    <script src="{{ asset('js/welcome/interactive-map-dynamic.js') }}"></script>
</body>
</html>

