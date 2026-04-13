<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte &mdash; GoExploria</title>
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

        /* ── Dashboard Layout ──────────────────────────────── */
        .dashboard{display:grid;grid-template-columns:260px 1fr;gap:28px;max-width:1200px;margin:150px auto 0;padding:40px 32px 60px}

        /* ── Sidebar ──────────────────────────────────────── */
        .sidebar{display:flex;flex-direction:column;gap:8px}
        .sidebar-card{background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.05)}
        .sidebar-item{display:flex;align-items:center;gap:12px;padding:13px 18px;font-size:13px;font-weight:600;color:#374151;text-decoration:none;border-left:3px solid transparent;transition:all .18s;cursor:pointer}
        .sidebar-item:hover,.sidebar-item.active{background:#f8f9fb;border-left-color:#d4af37;color:#0a1628}
        .sidebar-item.active{font-weight:800}
        .sidebar-item i{width:18px;text-align:center;font-size:14px;color:#9ba3af}
        .sidebar-item.active i,.sidebar-item:hover i{color:#d4af37}
        .sidebar-item .badge{margin-left:auto;background:#e63946;color:#fff;border-radius:10px;padding:2px 7px;font-size:10px;font-weight:800}
        .sidebar-sep{padding:10px 18px 4px;font-size:10px;font-weight:800;color:#9ba3af;letter-spacing:1.5px;text-transform:uppercase}
        .sidebar-logout{color:#e63946 !important}
        .sidebar-logout i{color:#e63946 !important}

        /* ── Main Content ──────────────────────────────────── */
        .main{display:flex;flex-direction:column;gap:24px}

        /* Quick Stats */
        .stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
        .stat-card{background:#fff;border-radius:14px;padding:22px 20px;box-shadow:0 2px 12px rgba(0,0,0,.05);display:flex;align-items:center;gap:16px;border-left:4px solid transparent}
        .sc-1{border-color:#4361ee}.sc-2{border-color:#2dc653}.sc-3{border-color:#d4af37}.sc-4{border-color:#e63946}
        .stat-icon{width:46px;height:46px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
        .sc-1 .stat-icon{background:rgba(67,97,238,.1);color:#4361ee}
        .sc-2 .stat-icon{background:rgba(45,198,83,.1);color:#2dc653}
        .sc-3 .stat-icon{background:rgba(212,175,55,.1);color:#c9980a}
        .sc-4 .stat-icon{background:rgba(230,57,70,.1);color:#e63946}
        .stat-data .num{font-size:1.4rem;font-weight:900;color:#0a1628}
        .stat-data .lbl{font-size:11px;color:#9ba3af;font-weight:600;letter-spacing:.3px}

        /* Section cards */
        .content-card{background:#fff;border-radius:14px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,.05)}
        .card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
        .card-title{font-size:14px;font-weight:800;color:#0a1628;display:flex;align-items:center;gap:8px}
        .card-title i{color:#d4af37}
        .card-action{font-size:12px;font-weight:700;color:#4361ee;text-decoration:none;display:flex;align-items:center;gap:4px}
        .card-action:hover{text-decoration:underline}

        /* Bookings table */
        .bookings-table{width:100%;border-collapse:collapse}
        .bookings-table thead tr{border-bottom:2px solid #f3f4f6}
        .bookings-table th{font-size:10.5px;font-weight:800;color:#9ba3af;letter-spacing:1px;text-transform:uppercase;padding:0 0 10px;text-align:left}
        .bookings-table td{padding:14px 0;border-bottom:1px solid #f3f4f6;font-size:13px;vertical-align:middle}
        .bookings-table tr:last-child td{border-bottom:none}
        .booking-dest{display:flex;align-items:center;gap:12px}
        .booking-img{width:44px;height:44px;border-radius:10px;object-fit:cover}
        .booking-name{font-weight:700;color:#0a1628;font-size:13px}
        .booking-date{font-size:11px;color:#9ba3af;margin-top:2px}
        .status-pill{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:12px;font-size:11px;font-weight:700}
        .s-confirmed{background:rgba(45,198,83,.1);color:#2dc653}
        .s-pending{background:rgba(212,175,55,.1);color:#c9980a}
        .s-completed{background:rgba(67,97,238,.1);color:#4361ee}
        .s-cancelled{background:rgba(230,57,70,.1);color:#e63946}
        .booking-amount{font-weight:800;color:#0a1628;font-size:14px}
        .btn-view{padding:6px 14px;border:1.5px solid #e5e7eb;border-radius:7px;font-size:11px;font-weight:700;color:#374151;text-decoration:none;transition:all .2s}
        .btn-view:hover{border-color:#0a1628;color:#0a1628}

        /* Favorites mini grid */
        .fav-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
        .fav-mini{border-radius:12px;overflow:hidden;position:relative;aspect-ratio:4/3}
        .fav-mini img{width:100%;height:100%;object-fit:cover;transition:transform .3s}
        .fav-mini:hover img{transform:scale(1.05)}
        .fav-mini-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(10,22,40,.8),transparent);display:flex;align-items:flex-end;padding:10px}
        .fav-mini-name{font-size:12px;font-weight:700;color:#fff}
        .fav-mini-heart{position:absolute;top:8px;right:8px;color:#e63946;font-size:16px}

        /* Profile form */
        .profile-form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .form-group{display:flex;flex-direction:column;gap:5px;margin-bottom:14px}
        .form-group label{font-size:11px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.5px}
        .form-group input,.form-group select{padding:10px 13px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:'Montserrat',sans-serif;font-size:13px;color:#0a1628;outline:none;transition:all .2s}
        .form-group input:focus{border-color:#d4af37;box-shadow:0 0 0 3px rgba(212,175,55,.1)}
        .btn-save{padding:11px 28px;background:linear-gradient(135deg,#0a1628,#1a2942);color:#fff;border:none;border-radius:9px;font-family:'Montserrat',sans-serif;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;cursor:pointer;transition:all .2s}
        .btn-save:hover{transform:translateY(-1px);box-shadow:0 5px 20px rgba(10,22,40,.25)}

        @media(max-width:1100px){.stats-row{grid-template-columns:repeat(2,1fr)}}
        @media(max-width:900px){.dashboard{grid-template-columns:1fr}.sidebar{flex-direction:row;flex-wrap:wrap;gap:4px}.sidebar-card{flex:1;min-width:120px}.profile-stats{display:none}}
        @media(max-width:600px){.dashboard{padding:24px 16px}.fav-grid{grid-template-columns:repeat(2,1fr)}.profile-form-grid{grid-template-columns:1fr}.stats-row{grid-template-columns:repeat(2,1fr)}}
    </style>
</head>
<body>

@include('home-v2.components.VerticalMenu')
@include('home-v2.components.Header')

{{-- ── Dashboard ────────────────────────────────────────────────── --}}
<div class="dashboard">

    {{-- Sidebar --}}
    <aside>
        <div class="sidebar-card sidebar">
            <a href="#" class="sidebar-item active"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a>
            <a href="#" class="sidebar-item"><i class="fas fa-calendar-check"></i> Mes r&eacute;servations <span class="badge">2</span></a>
            <a href="{{ url('/favoris') }}" class="sidebar-item"><i class="fas fa-heart"></i> Mes favoris</a>
            <a href="{{ url('/panier') }}" class="sidebar-item"><i class="fas fa-shopping-cart"></i> Mon panier</a>
            <a href="{{ url('/devis') }}" class="sidebar-item"><i class="fas fa-file-invoice"></i> Mes devis</a>
            <a href="#" class="sidebar-item"><i class="fas fa-comments"></i> Messages <span class="badge">3</span></a>
            <div class="sidebar-sep">Param&egrave;tres</div>
            <a href="#" class="sidebar-item"><i class="fas fa-user-edit"></i> Mon profil</a>
            <a href="#" class="sidebar-item"><i class="fas fa-lock"></i> S&eacute;curit&eacute;</a>
            <a href="#" class="sidebar-item"><i class="fas fa-bell"></i> Notifications</a>
            <a href="#" class="sidebar-item sidebar-logout"><i class="fas fa-sign-out-alt"></i> D&eacute;connexion</a>
        </div>
    </aside>

    {{-- Main --}}
    <main class="main">

        {{-- Quick Stats --}}
        <div class="stats-row">
            <div class="stat-card sc-1">
                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-data"><div class="num">14</div><div class="lbl">Voyages r&eacute;alis&eacute;s</div></div>
            </div>
            <div class="stat-card sc-2">
                <div class="stat-icon"><i class="fas fa-star"></i></div>
                <div class="stat-data"><div class="num">2&nbsp;840 pts</div><div class="lbl">Points fid&eacute;lit&eacute;</div></div>
            </div>
            <div class="stat-card sc-3">
                <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
                <div class="stat-data"><div class="num">18 740 $</div><div class="lbl">Total d&eacute;pens&eacute;</div></div>
            </div>
            <div class="stat-card sc-4">
                <div class="stat-icon"><i class="fas fa-heart"></i></div>
                <div class="stat-data"><div class="num">38</div><div class="lbl">Destinations sauv&eacute;es</div></div>
            </div>
        </div>

        {{-- Reservations --}}
        <div class="content-card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-suitcase-rolling"></i> Mes r&eacute;servations r&eacute;centes</div>
                <a href="#" class="card-action">Voir tout <i class="fas fa-arrow-right"></i></a>
            </div>
            <table class="bookings-table">
                <thead>
                    <tr>
                        <th>Destination</th>
                        <th>Dates</th>
                        <th>Statut</th>
                        <th>Montant</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="booking-dest">
                                <img class="booking-img" src="https://images.unsplash.com/photo-1548013146-72479768bada?w=100&q=80" alt="Qu&eacute;bec">
                                <div><div class="booking-name">Forfait Qu&eacute;bec City &amp; Charlevoix</div><div class="booking-date">R&eacute;f. GE-2024-0841</div></div>
                            </div>
                        </td>
                        <td style="font-size:12px;color:#374151">15 &mdash; 22 juin 2025</td>
                        <td><span class="status-pill s-confirmed"><i class="fas fa-circle" style="font-size:7px"></i> Confirm&eacute;</span></td>
                        <td class="booking-amount">3 240 $</td>
                        <td><a href="#" class="btn-view">D&eacute;tails</a></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="booking-dest">
                                <img class="booking-img" src="https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w=100&q=80" alt="Gasp&eacute;sie">
                                <div><div class="booking-name">Circuit Gasp&eacute;sie 10 jours</div><div class="booking-date">R&eacute;f. GE-2024-0719</div></div>
                            </div>
                        </td>
                        <td style="font-size:12px;color:#374151">1 &mdash; 10 ao&ucirc;t 2025</td>
                        <td><span class="status-pill s-pending"><i class="fas fa-circle" style="font-size:7px"></i> En attente</span></td>
                        <td class="booking-amount">4 895 $</td>
                        <td><a href="#" class="btn-view">D&eacute;tails</a></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="booking-dest">
                                <img class="booking-img" src="https://images.unsplash.com/photo-1511497584788-876760111969?w=100&q=80" alt="Laurentides">
                                <div><div class="booking-name">Week-end Laurentides &mdash; Spa &amp; Nature</div><div class="booking-date">R&eacute;f. GE-2023-1204</div></div>
                            </div>
                        </td>
                        <td style="font-size:12px;color:#374151">10 &mdash; 12 mars 2024</td>
                        <td><span class="status-pill s-completed"><i class="fas fa-circle" style="font-size:7px"></i> Termin&eacute;</span></td>
                        <td class="booking-amount">1 180 $</td>
                        <td><a href="#" class="btn-view">D&eacute;tails</a></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="booking-dest">
                                <img class="booking-img" src="https://images.unsplash.com/photo-1509316785289-025f5b846b35?w=100&q=80" alt="Montr&eacute;al">
                                <div><div class="booking-name">S&eacute;jour Montr&eacute;al Festival Jazz</div><div class="booking-date">R&eacute;f. GE-2023-0633</div></div>
                            </div>
                        </td>
                        <td style="font-size:12px;color:#374151">28 juin &mdash; 3 juil. 2023</td>
                        <td><span class="status-pill s-completed"><i class="fas fa-circle" style="font-size:7px"></i> Termin&eacute;</span></td>
                        <td class="booking-amount">890 $</td>
                        <td><a href="#" class="btn-view">D&eacute;tails</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Favorites mini --}}
        <div class="content-card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-heart"></i> Destinations sauvegard&eacute;es</div>
                <a href="{{ url('/favoris') }}" class="card-action">Voir tout <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="fav-grid">
                <div class="fav-mini">
                    <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=300&q=80" alt="Montr&eacute;al">
                    <div class="fav-mini-overlay"><span class="fav-mini-name">Montr&eacute;al, QC</span></div>
                    <i class="fas fa-heart fav-mini-heart"></i>
                </div>
                <div class="fav-mini">
                    <img src="https://images.unsplash.com/photo-1519003722824-194d4455a60c?w=300&q=80" alt="Qu&eacute;bec">
                    <div class="fav-mini-overlay"><span class="fav-mini-name">Vieux-Qu&eacute;bec</span></div>
                    <i class="fas fa-heart fav-mini-heart"></i>
                </div>
                <div class="fav-mini">
                    <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=300&q=80" alt="Gasp&eacute;sie">
                    <div class="fav-mini-overlay"><span class="fav-mini-name">Gasp&eacute;sie</span></div>
                    <i class="fas fa-heart fav-mini-heart"></i>
                </div>
            </div>
        </div>

        {{-- Profile Form --}}
        <div class="content-card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-user-edit"></i> Informations personnelles</div>
            </div>
            <div class="profile-form-grid">
                <div class="form-group"><label>Pr&eacute;nom</label><input type="text" value="Jean-Fran&ccedil;ois"></div>
                <div class="form-group"><label>Nom</label><input type="text" value="Tremblay"></div>
                <div class="form-group"><label>Courriel</label><input type="email" value="jf.tremblay@exemple.com"></div>
                <div class="form-group"><label>T&eacute;l&eacute;phone</label><input type="tel" value="+1 (514) 800-9001"></div>
                <div class="form-group"><label>Date de naissance</label><input type="date" value="1985-04-12"></div>
                <div class="form-group"><label>Pays</label>
                    <select><option selected>Canada</option><option>France</option><option>&Eacute;tats-Unis</option></select>
                </div>
            </div>
            <button class="btn-save"><i class="fas fa-save"></i>&nbsp; Enregistrer les modifications</button>
        </div>

    </main>
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
