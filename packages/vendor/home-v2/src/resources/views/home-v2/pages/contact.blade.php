<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous &mdash; GoExploria</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-destinations-mega.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Montserrat',sans-serif;background:#f4f6f9;color:#0a1628;overflow-x:hidden}

        /* ── Page Banner ──────────────────────────────── */
        .page-banner{background:linear-gradient(135deg,#0a1628 0%,#1a2942 100%);padding:48px 40px;position:relative;overflow:hidden}
        .page-banner::before{content:'';position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1486325212027-8081e485255e?w=1400&q=80') center/cover;opacity:.1}
        .page-banner-inner{position:relative;z-index:1;max-width:1200px;margin:0 auto}
        .page-banner-badge{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;background:rgba(212,175,55,.15);border:1px solid rgba(212,175,55,.3);border-radius:20px;font-size:11px;font-weight:700;color:#d4af37;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:14px}
        .page-banner-title{font-size:clamp(1.6rem,3.5vw,2.4rem);font-weight:900;color:#fff;line-height:1.15;margin-bottom:8px}
        .page-banner-title span{color:#d4af37}
        .page-banner-sub{font-size:14px;color:rgba(255,255,255,.6);line-height:1.6;max-width:580px}

        /* ── Layout ──────────────────────────────────── */
        .page-wrap{max-width:1200px;margin-top:150px;margin-left:auto;margin-right:auto;padding:40px 32px 60px}
        .section-label{font-size:11px;font-weight:800;color:#d4af37;letter-spacing:2.5px;text-transform:uppercase;margin-bottom:10px}
        .section-title{font-size:1.8rem;font-weight:900;color:#0a1628;margin-bottom:8px}
        .section-sub{font-size:14px;color:#6b7280;line-height:1.6}

        /* ── Info Cards ──────────────────────────────── */
        .info-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-bottom:64px}
        .info-card{background:#fff;border-radius:16px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,.06);border-top:4px solid transparent;transition:all .25s;display:flex;flex-direction:column;align-items:flex-start;gap:14px}
        .info-card:hover{transform:translateY(-4px);box-shadow:0 8px 32px rgba(0,0,0,.1)}
        .info-card.card-addr{border-color:#4361ee}
        .info-card.card-phone{border-color:#2dc653}
        .info-card.card-email{border-color:#d4af37}
        .info-icon{width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px}
        .card-addr .info-icon{background:rgba(67,97,238,.1);color:#4361ee}
        .card-phone .info-icon{background:rgba(45,198,83,.1);color:#2dc653}
        .card-email .info-icon{background:rgba(212,175,55,.12);color:#c9980a}
        .info-card h3{font-size:14px;font-weight:800;color:#0a1628;letter-spacing:.5px}
        .info-card p{font-size:13px;color:#6b7280;line-height:1.7}
        .info-card a{color:#4361ee;text-decoration:none;font-weight:600;font-size:13px}
        .info-card a:hover{text-decoration:underline}
        .info-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700}
        .badge-open{background:rgba(45,198,83,.1);color:#2dc653}

        /* ── Contact Form + Map ──────────────────────── */
        .contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:40px;margin-bottom:64px}
        .form-card{background:#fff;border-radius:16px;padding:40px;box-shadow:0 2px 16px rgba(0,0,0,.06)}
        .form-card h2{font-size:1.4rem;font-weight:900;color:#0a1628;margin-bottom:6px}
        .form-card .sub{font-size:13px;color:#9ba3af;margin-bottom:28px}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .form-group{margin-bottom:18px;display:flex;flex-direction:column;gap:6px}
        .form-group label{font-size:11.5px;font-weight:700;color:#374151;letter-spacing:.5px;text-transform:uppercase}
        .form-group input,.form-group select,.form-group textarea{width:100%;padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:'Montserrat',sans-serif;font-size:13px;color:#0a1628;outline:none;transition:border-color .2s,box-shadow .2s;background:#fff}
        .form-group input:focus,.form-group select:focus,.form-group textarea:focus{border-color:#d4af37;box-shadow:0 0 0 3px rgba(212,175,55,.12)}
        .form-group textarea{resize:vertical;min-height:120px}
        .btn-submit{width:100%;padding:14px;background:linear-gradient(135deg,#0a1628,#1a2942);color:#fff;border:none;border-radius:10px;font-family:'Montserrat',sans-serif;font-size:13px;font-weight:700;letter-spacing:1px;text-transform:uppercase;cursor:pointer;transition:all .25s;display:flex;align-items:center;justify-content:center;gap:10px}
        .btn-submit:hover{background:linear-gradient(135deg,#1a2942,#2a3a52);transform:translateY(-1px);box-shadow:0 8px 24px rgba(10,22,40,.3)}
        .btn-submit i{font-size:14px;color:#d4af37}

        /* ── Map Placeholder ─────────────────────────── */
        .map-card{background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,.06);display:flex;flex-direction:column}
        .map-img{flex:1;min-height:300px;background:linear-gradient(135deg,#e8ecf4,#d1d9ea);position:relative;display:flex;align-items:center;justify-content:center;overflow:hidden}
        .map-img img{width:100%;height:100%;object-fit:cover;opacity:.8}
        .map-pin{position:absolute;width:56px;height:56px;background:#0a1628;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 4px 20px rgba(0,0,0,.3);display:flex;align-items:center;justify-content:center}
        .map-pin i{transform:rotate(45deg);color:#d4af37;font-size:22px}
        .map-info{padding:24px 28px}
        .map-address{font-size:14px;font-weight:700;color:#0a1628;margin-bottom:4px}
        .map-city{font-size:13px;color:#6b7280}
        .map-actions{display:flex;gap:10px;margin-top:16px}
        .map-btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;transition:all .2s}
        .map-btn-primary{background:#0a1628;color:#fff}
        .map-btn-primary:hover{background:#1a2942}
        .map-btn-secondary{border:1.5px solid #e5e7eb;color:#374151}
        .map-btn-secondary:hover{border-color:#0a1628;color:#0a1628}

        /* ── Hours Table ─────────────────────────────── */
        .hours-section{margin-bottom:64px}
        .hours-grid{display:grid;grid-template-columns:1fr 1fr;gap:32px;margin-top:32px}
        .hours-card{background:#fff;border-radius:16px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,.06)}
        .hours-card h3{font-size:14px;font-weight:800;color:#0a1628;margin-bottom:20px;display:flex;align-items:center;gap:8px}
        .hours-card h3 i{color:#d4af37}
        .hours-row{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #f3f4f6;font-size:13px}
        .hours-row:last-child{border-bottom:none}
        .hours-day{font-weight:600;color:#374151}
        .hours-time{font-weight:700;color:#0a1628}
        .hours-closed{color:#e63946;font-weight:700}
        .hours-today{background:rgba(212,175,55,.07);border-radius:8px;padding:10px 14px;margin:-2px -14px}

        /* ── Social ──────────────────────────────────── */
        .social-section{text-align:center;padding:48px 0;border-top:1px solid #e9ecef}
        .social-title{font-size:1rem;font-weight:700;color:#0a1628;margin-bottom:20px}
        .social-links{display:flex;justify-content:center;gap:14px}
        .social-btn{width:46px;height:46px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;text-decoration:none;transition:all .2s}
        .social-btn:hover{transform:translateY(-3px)}
        .sb-fb{background:#1877f2;color:#fff}.sb-ig{background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);color:#fff}
        .sb-yt{background:#ff0000;color:#fff}.sb-li{background:#0077b5;color:#fff}.sb-tt{background:#000;color:#fff}

        @media(max-width:900px){.info-grid{grid-template-columns:1fr;}.contact-grid{grid-template-columns:1fr}.hours-grid{grid-template-columns:1fr}.form-row{grid-template-columns:1fr}}
        @media(max-width:600px){.page-wrap{padding:40px 20px}.page-banner{padding:32px 20px}}
    </style>
</head>
<body>

@include('home-v2.components.VerticalMenu')
@include('home-v2.components.Header')


{{-- ── Info Cards ────────────────────────────────────────────── --}}
<div class="page-wrap">
    <div class="info-grid">
        <div class="info-card card-addr">
            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
            <h3>Notre Bureau</h3>
            <p>1500, rue University, Suite 1200<br>Montr&eacute;al, Qu&eacute;bec, H3A 3S7<br>Canada</p>
            <a href="https://maps.google.com" target="_blank"><i class="fas fa-external-link-alt"></i> Voir sur Google Maps</a>
        </div>
        <div class="info-card card-phone">
            <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
            <h3>T&eacute;l&eacute;phone &amp; Fax</h3>
            <p>
                <strong>Sans frais :</strong> 1-800-EXPLORIA<br>
                <strong>Local :</strong> <a href="tel:+15148001234">+1 (514) 800-1234</a><br>
                <strong>Fax :</strong> +1 (514) 800-1235
            </p>
            <span class="info-badge badge-open"><i class="fas fa-circle" style="font-size:8px"></i> Disponible maintenant</span>
        </div>
        <div class="info-card card-email">
            <div class="info-icon"><i class="fas fa-envelope"></i></div>
            <h3>Courriel &amp; R&eacute;seaux</h3>
            <p>
                <strong>G&eacute;n&eacute;ral :</strong> <a href="mailto:info@goexploria.com">info@goexploria.com</a><br>
                <strong>Support :</strong> <a href="mailto:support@goexploria.com">support@goexploria.com</a><br>
                <strong>Partenariats :</strong> <a href="mailto:partners@goexploria.com">partners@goexploria.com</a>
            </p>
        </div>
    </div>

    {{-- ── Contact Form + Map ──────────────────────────────────── --}}
    <div style="margin-bottom:20px">
        <div class="section-label">Formulaire de contact</div>
        <h2 class="section-title">Envoyez-nous un message</h2>
        <p class="section-sub">R&eacute;ponse garantie sous 24&nbsp;heures ouvrables.</p>
    </div>
    <div class="contact-grid">
        <div class="form-card">
            <h2>Votre demande</h2>
            <p class="sub">Tous les champs marqu&eacute;s * sont obligatoires.</p>
            <form>
                <div class="form-row">
                    <div class="form-group">
                        <label>Pr&eacute;nom *</label>
                        <input type="text" placeholder="Jean">
                    </div>
                    <div class="form-group">
                        <label>Nom *</label>
                        <input type="text" placeholder="Tremblay">
                    </div>
                </div>
                <div class="form-group">
                    <label>Adresse courriel *</label>
                    <input type="email" placeholder="jean.tremblay@exemple.com">
                </div>
                <div class="form-group">
                    <label>T&eacute;l&eacute;phone</label>
                    <input type="tel" placeholder="+1 (514) 000-0000">
                </div>
                <div class="form-group">
                    <label>Sujet *</label>
                    <select>
                        <option value="">-- S&eacute;lectionner un sujet --</option>
                        <option>Demande d&apos;information g&eacute;n&eacute;rale</option>
                        <option>R&eacute;servation de forfait</option>
                        <option>Demande de devis</option>
                        <option>Partenariat commercial</option>
                        <option>Probl&egrave;me technique</option>
                        <option>Autre</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Votre message *</label>
                    <textarea placeholder="D&eacute;crivez votre demande en d&eacute;tail..."></textarea>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Envoyer le message
                </button>
            </form>
        </div>

        <div class="map-card">
            <div class="map-img">
                <img src="https://images.unsplash.com/photo-1519003722824-194d4455a60c?w=800&q=80" alt="Montr&eacute;al">
                <div class="map-pin"><i class="fas fa-map-marker-alt"></i></div>
            </div>
            <div class="map-info">
                <p class="map-address">1500, rue University, Suite 1200</p>
                <p class="map-city">Montr&eacute;al, Qu&eacute;bec &mdash; H3A 3S7, Canada</p>
                <div class="map-actions">
                    <a href="https://maps.google.com" target="_blank" class="map-btn map-btn-primary">
                        <i class="fas fa-directions"></i> Itin&eacute;raire
                    </a>
                    <a href="tel:+15148001234" class="map-btn map-btn-secondary">
                        <i class="fas fa-phone"></i> Appeler
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Horaires ─────────────────────────────────────────────── --}}
    <div class="hours-section">
        <div class="section-label">Disponibilit&eacute;</div>
        <h2 class="section-title">Horaires d&apos;ouverture</h2>
        <div class="hours-grid">
            <div class="hours-card">
                <h3><i class="fas fa-building"></i> Bureau principal &mdash; Montr&eacute;al</h3>
                <div class="hours-row hours-today">
                    <span class="hours-day">Lundi &mdash; Vendredi</span>
                    <span class="hours-time">8 h 30 &mdash; 18 h 00</span>
                </div>
                <div class="hours-row">
                    <span class="hours-day">Samedi</span>
                    <span class="hours-time">10 h 00 &mdash; 15 h 00</span>
                </div>
                <div class="hours-row">
                    <span class="hours-day">Dimanche</span>
                    <span class="hours-closed">Ferm&eacute;</span>
                </div>
                <div class="hours-row">
                    <span class="hours-day">Jours f&eacute;ri&eacute;s</span>
                    <span class="hours-closed">Ferm&eacute;</span>
                </div>
            </div>
            <div class="hours-card">
                <h3><i class="fas fa-headset"></i> Support en ligne</h3>
                <div class="hours-row hours-today">
                    <span class="hours-day">Lundi &mdash; Vendredi</span>
                    <span class="hours-time">7 h 00 &mdash; 21 h 00</span>
                </div>
                <div class="hours-row">
                    <span class="hours-day">Samedi &mdash; Dimanche</span>
                    <span class="hours-time">9 h 00 &mdash; 17 h 00</span>
                </div>
                <div class="hours-row">
                    <span class="hours-day">Chat en direct</span>
                    <span class="hours-time">24 h / 7 j</span>
                </div>
                <div class="hours-row">
                    <span class="hours-day">Urgences voyage</span>
                    <span class="hours-time" style="color:#2dc653">24 h / 7 j</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── R&eacute;seaux sociaux ─────────────────────────────────────────── --}}
    <div class="social-section">
        <p class="social-title">Suivez-nous sur les r&eacute;seaux sociaux</p>
        <div class="social-links">
            <a href="#" class="social-btn sb-fb"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-btn sb-ig"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-btn sb-yt"><i class="fab fa-youtube"></i></a>
            <a href="#" class="social-btn sb-li"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" class="social-btn sb-tt"><i class="fab fa-tiktok"></i></a>
        </div>
    </div>
</div>

@include('home-v2.components.Footer')

<script src="{{ asset('js/home-v2/navigation.js') }}"></script>
<script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
<script src="{{ asset('js/home-v2/mega-menu-service.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-destinations-mega.js') }}"></script>
<script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/destinations-mega-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
</body>
</html>
