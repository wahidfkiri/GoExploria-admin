<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GO EXPLORIA BUSINESS - Dashboard Admin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-light: #eef2ff;
            --secondary-color: #6c757d;
            --accent-color: #06d6a0;
            --accent-light: #e6fcf5;
            --warning-color: #ffd166;
            --danger-color: #ef476f;
            --sidebar-dark: #0f172a;
            --sidebar-light: #1e293b;
            --light-bg: #f8fafc;
            --white: #ffffff;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --sidebar-width: 280px;
            --header-height: 70px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: #334155;
            overflow-x: hidden;
        }
        
        /* HEADER STYLES */
        .dashboard-header {
            background-color: var(--white);
            border-bottom: 1px solid #e2e8f0;
            padding: 0 30px;
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            z-index: 100;
            height: var(--header-height);
            display: flex;
            align-items: center;
            box-shadow: var(--card-shadow);
            transition: left 0.3s ease;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        
        .header-left h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        
        .header-left p {
            font-size: 0.875rem;
            color: #64748b;
            margin: 0;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        /* Search bar */
        .search-container {
            position: relative;
            width: 300px;
        }
        
        .search-input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: #f8fafc;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background-color: var(--white);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        
        /* Header actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .notification-btn {
            position: relative;
            background: none;
            border: none;
            color: #64748b;
            font-size: 1.2rem;
            cursor: pointer;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 8px;
            transition: background-color 0.2s;
        }
        
        .user-profile:hover {
            background-color: #f1f5f9;
        }
        
        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .user-info h5 {
            font-size: 0.95rem;
            font-weight: 600;
            margin: 0;
            color: #1e293b;
        }
        
        .user-info p {
            font-size: 0.8rem;
            color: #64748b;
            margin: 0;
        }
        
        /* SIDEBAR STYLES - DARK MODE */
        .dashboard-sidebar {
            background-color: var(--sidebar-dark);
            width: var(--sidebar-width);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 101;
            padding: 25px 0;
            overflow-y: auto;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-logo {
            padding: 0 25px 30px;
            border-bottom: 1px solid #334155;
            margin-bottom: 25px;
        }
        
        .logo-main {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo-sub {
            font-size: 0.85rem;
            color: #94a3b8;
            font-weight: 400;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .menu-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #94a3b8;
            padding: 0 25px 10px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        .menu-item {
            padding: 12px 25px;
            display: flex;
            align-items: center;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
            margin: 2px 0;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: var(--sidebar-light);
            color: var(--white);
            border-left: 4px solid var(--primary-color);
        }
        
        .menu-icon {
            width: 24px;
            margin-right: 12px;
            font-size: 1.1rem;
            text-align: center;
        }
        
        .menu-text {
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .menu-badge {
            margin-left: auto;
            background-color: var(--primary-color);
            color: white;
            border-radius: 20px;
            padding: 3px 8px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        
        /* MAIN CONTENT STYLES */
        .dashboard-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 30px;
            transition: margin-left 0.3s ease;
            min-height: calc(100vh - var(--header-height));
        }
        
        .welcome-card {
            background: linear-gradient(135deg, var(--primary-color), #3a56e4);
            border-radius: 16px;
            color: white;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: var(--card-shadow);
        }
        
        .welcome-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .welcome-text {
            font-size: 1rem;
            opacity: 0.9;
            max-width: 600px;
            margin-bottom: 20px;
        }
        
        /* STATS CARDS */
        .stats-card {
            background-color: var(--white);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            box-shadow: var(--card-shadow);
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .stats-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        
        .stats-icon-container {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .stats-more {
            color: #94a3b8;
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
        }
        
        .stats-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: #1e293b;
        }
        
        .stats-label {
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 10px;
        }
        
        .stats-change {
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .positive {
            color: #06d6a0;
        }
        
        .negative {
            color: #ef476f;
        }
        
        /* ACTIVITY SECTION */
        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .activity-card {
            background-color: var(--white);
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            height: 100%;
            box-shadow: var(--card-shadow);
        }
        
        .activity-list {
            margin-top: 5px;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.1rem;
            color: white;
        }
        
        .activity-info {
            flex-grow: 1;
        }
        
        .activity-title {
            font-weight: 600;
            margin-bottom: 3px;
            color: #1e293b;
        }
        
        .activity-desc {
            color: #64748b;
            font-size: 0.85rem;
        }
        
        .activity-time {
            color: #94a3b8;
            font-size: 0.8rem;
            white-space: nowrap;
        }
        
        /* PROJECTS SECTION */
        .project-card {
            background-color: var(--white);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e2e8f0;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .project-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        }
        
        .project-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }
        
        .project-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 5px;
        }
        
        .project-status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-active {
            background-color: rgba(6, 214, 160, 0.1);
            color: #06d6a0;
        }
        
        .status-pending {
            background-color: rgba(255, 209, 102, 0.1);
            color: #e6a100;
        }
        
        .status-completed {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }
        
        .project-desc {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .project-progress {
            margin-top: 10px;
        }
        
        .progress-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.85rem;
        }
        
        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background-color: #e2e8f0;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 4px;
        }
        
        /* QUICK ACTIONS */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }
        
        .action-btn {
            background-color: var(--white);
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: var(--card-shadow);
        }
        
        .action-btn:hover {
            transform: translateY(-3px);
            border-color: var(--primary-color);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .action-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 12px;
            color: white;
        }
        
        .action-text {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.95rem;
        }
        
        /* FOOTER */
        .dashboard-footer {
            margin-top: 40px;
            text-align: center;
            color: #64748b;
            font-size: 0.85rem;
            padding: 20px;
            border-top: 1px solid #e2e8f0;
        }
        
        /* RESPONSIVE STYLES */
        @media (max-width: 1200px) {
            :root {
                --sidebar-width: 250px;
            }
            
            .search-container {
                width: 250px;
            }
        }
        
        @media (max-width: 992px) {
            .dashboard-sidebar {
                transform: translateX(-100%);
                z-index: 102;
            }
            
            .dashboard-sidebar.active {
                transform: translateX(0);
            }
            
            .dashboard-header {
                left: 0;
            }
            
            .dashboard-content {
                margin-left: 0;
            }
            
            .sidebar-toggle {
                display: block !important;
                background: none;
                border: none;
                color: #64748b;
                font-size: 1.5rem;
                margin-right: 15px;
            }
            
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 101;
                display: none;
            }
            
            .overlay.active {
                display: block;
            }
            
            .search-container {
                width: 200px;
            }
        }
        
        @media (max-width: 768px) {
            .dashboard-content {
                padding: 20px;
            }
            
            .header-left h1 {
                font-size: 1.3rem;
            }
            
            .search-container {
                display: none;
            }
            
            .welcome-card {
                padding: 20px;
            }
            
            .welcome-title {
                font-size: 1.5rem;
            }
            
            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .header-actions .user-info {
                display: none;
            }
        }
        
        @media (max-width: 576px) {
            .dashboard-header {
                padding: 0 15px;
            }
            
            .quick-actions {
                grid-template-columns: 1fr;
            }
            
            .stats-value {
                font-size: 1.7rem;
            }
        }
        
        /* Dark scrollbar for sidebar */
        .dashboard-sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .dashboard-sidebar::-webkit-scrollbar-track {
            background: #1e293b;
        }
        
        .dashboard-sidebar::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 3px;
        }
        
        .dashboard-sidebar::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
        
        /* Light scrollbar for main content */
        body::-webkit-scrollbar {
            width: 8px;
        }
        
        body::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        body::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body>
    <!-- OVERLAY FOR MOBILE -->
    <div class="overlay" id="overlay"></div>
    
    <x-side-bar />
    
   <x-header />
    
    <!-- MAIN CONTENT -->
    <main class="dashboard-content">
        <!-- Welcome Section -->
        <div class="welcome-card">
            <h2 class="welcome-title">Bonjour, {{auth()->user()->name}} 👋</h2>
            <p class="welcome-text">
                Gérez votre plateforme GO EXPLORIA, créez des sites web modernes, et suivez les performances de vos clients. 
                Vous avez 3 nouveaux messages et 12 tâches en attente aujourd'hui.
            </p>
            <button class="btn btn-light">
                <i class="fas fa-rocket me-2"></i>Commencer maintenant
            </button>
        </div>
        
        <!-- Stats Row -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-header">
                        <div class="stats-icon-container" style="background-color: rgba(67, 97, 238, 0.1); color: var(--primary-color);">
                            <i class="fas fa-globe"></i>
                        </div>
                        <button class="stats-more"><i class="fas fa-ellipsis-h"></i></button>
                    </div>
                    <div class="stats-value">142</div>
                    <div class="stats-label">Sites web actifs</div>
                    <div class="stats-change positive">
                        <i class="fas fa-arrow-up"></i> 8.5% ce mois
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-header">
                        <div class="stats-icon-container" style="background-color: rgba(6, 214, 160, 0.1); color: var(--accent-color);">
                            <i class="fas fa-eye"></i>
                        </div>
                        <button class="stats-more"><i class="fas fa-ellipsis-h"></i></button>
                    </div>
                    <div class="stats-value">24.5K</div>
                    <div class="stats-label">Visites aujourd'hui</div>
                    <div class="stats-change positive">
                        <i class="fas fa-arrow-up"></i> 12.3% depuis hier
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-header">
                        <div class="stats-icon-container" style="background-color: rgba(255, 209, 102, 0.1); color: #e6a100;">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <button class="stats-more"><i class="fas fa-ellipsis-h"></i></button>
                    </div>
                    <div class="stats-value">€4,258</div>
                    <div class="stats-label">Revenus aujourd'hui</div>
                    <div class="stats-change positive">
                        <i class="fas fa-arrow-up"></i> 5.7% cette semaine
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-header">
                        <div class="stats-icon-container" style="background-color: rgba(239, 71, 111, 0.1); color: var(--danger-color);">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <button class="stats-more"><i class="fas fa-ellipsis-h"></i></button>
                    </div>
                    <div class="stats-value">48</div>
                    <div class="stats-label">Nouveaux utilisateurs</div>
                    <div class="stats-change negative">
                        <i class="fas fa-arrow-down"></i> 2.1% cette semaine
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Activity & Projects Row -->
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="activity-card">
                    <h5 class="section-title">
                        <i class="fas fa-history"></i>
                        Activité récente
                    </h5>
                    
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon" style="background-color: var(--primary-color);">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="activity-info">
                                <div class="activity-title">Nouveau site web créé</div>
                                <div class="activity-desc">"Voyage Québec" par Martin Tremblay</div>
                            </div>
                            <div class="activity-time">Il y a 15 min</div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon" style="background-color: var(--accent-color);">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="activity-info">
                                <div class="activity-title">Paiement reçu</div>
                                <div class="activity-desc">Forfait Business - Sophie Gagnon</div>
                            </div>
                            <div class="activity-time">Il y a 2 heures</div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon" style="background-color: #e6a100;">
                                <i class="fas fa-upload"></i>
                            </div>
                            <div class="activity-info">
                                <div class="activity-title">Médias téléchargés</div>
                                <div class="activity-desc">50 photos ajoutées à la galerie Montréal</div>
                            </div>
                            <div class="activity-time">Il y a 5 heures</div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon" style="background-color: #8b5cf6;">
                                <i class="fas fa-comment"></i>
                            </div>
                            <div class="activity-info">
                                <div class="activity-title">Nouveau commentaire</div>
                                <div class="activity-desc">Sur l'article "Les meilleurs restaurants"</div>
                            </div>
                            <div class="activity-time">Il y a 1 jour</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="activity-card">
                    <h5 class="section-title">
                        <i class="fas fa-tasks"></i>
                        Projets en cours
                    </h5>
                    
                    <div class="project-card">
                        <div class="project-header">
                            <div>
                                <div class="project-title">Site web - Voyage Québec</div>
                                <div class="project-desc">Création d'un site touristique moderne</div>
                            </div>
                            <span class="project-status status-active">En cours</span>
                        </div>
                        <div class="project-progress">
                            <div class="progress-info">
                                <span>Progression</span>
                                <span>75%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 75%; background-color: var(--accent-color);"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="project-card">
                        <div class="project-header">
                            <div>
                                <div class="project-title">Intégration vidéo</div>
                                <div class="project-desc">Ajout de carrousels sur page d'accueil</div>
                            </div>
                            <span class="project-status status-pending">En attente</span>
                        </div>
                        <div class="project-progress">
                            <div class="progress-info">
                                <span>Progression</span>
                                <span>30%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 30%; background-color: #e6a100;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="project-card">
                        <div class="project-header">
                            <div>
                                <div class="project-title">Migration de données</div>
                                <div class="project-desc">Transfert des utilisateurs vers nouvelle plateforme</div>
                            </div>
                            <span class="project-status status-completed">Terminé</span>
                        </div>
                        <div class="project-progress">
                            <div class="progress-info">
                                <span>Progression</span>
                                <span>100%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 100%; background-color: var(--primary-color);"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="activity-card">
                    <h5 class="section-title">
                        <i class="fas fa-bolt"></i>
                        Actions rapides
                    </h5>
                    
                    <div class="quick-actions">
                        <div class="action-btn">
                            <div class="action-icon" style="background-color: var(--primary-color);">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="action-text">Créer un site</div>
                        </div>
                        
                        <div class="action-btn">
                            <div class="action-icon" style="background-color: var(--accent-color);">
                                <i class="fas fa-upload"></i>
                            </div>
                            <div class="action-text">Upload média</div>
                        </div>
                        
                        <div class="action-btn">
                            <div class="action-icon" style="background-color: #8b5cf6;">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="action-text">Voir les stats</div>
                        </div>
                        
                        <div class="action-btn">
                            <div class="action-icon" style="background-color: #e6a100;">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="action-text">Paramètres</div>
                        </div>
                        
                        <div class="action-btn">
                            <div class="action-icon" style="background-color: #ef476f;">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="action-text">Gérer utilisateurs</div>
                        </div>
                        
                        <div class="action-btn">
                            <div class="action-icon" style="background-color: #06b6d4;">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <div class="action-text">Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="dashboard-footer">
            <div class="row">
                <div class="col-md-6 text-md-start text-center">
                    <p>GO EXPLORIA BUSINESS &copy; 2023 - Plateforme de création de sites web</p>
                </div>
                <div class="col-md-6 text-md-end text-center">
                    <p>Version 3.1.0 | Dernière mise à jour: 15/12/2023</p>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle sidebar on mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('dashboardSidebar');
        const overlay = document.getElementById('overlay');
        
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            
            // Toggle icon
            const icon = this.querySelector('i');
            if (icon.classList.contains('fa-bars')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
        
        // Close sidebar when clicking overlay
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            this.classList.remove('active');
            const icon = sidebarToggle.querySelector('i');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        });
        
        // Add active class to clicked menu item
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all items
                document.querySelectorAll('.menu-item').forEach(i => {
                    i.classList.remove('active');
                });
                
                // Add active class to clicked item
                this.classList.add('active');
                
                // Close sidebar on mobile after selection
                if (window.innerWidth <= 992) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    
                    const icon = sidebarToggle.querySelector('i');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
        });
        
        // Simulate real-time stats update
        setInterval(() => {
            const visitsElement = document.querySelectorAll('.stats-value')[1];
            const currentVisits = parseInt(visitsElement.textContent.replace('K', '')) * 1000;
            const randomIncrement = Math.floor(Math.random() * 100) + 1;
            const newVisits = (currentVisits + randomIncrement);
            visitsElement.textContent = (newVisits / 1000).toFixed(1) + 'K';
        }, 15000);
        
        // Notification badge update
        let notificationCount = 3;
        const notificationBtn = document.querySelector('.notification-btn');
        
        notificationBtn.addEventListener('click', function() {
            const badge = this.querySelector('.notification-badge');
            if (notificationCount > 0) {
                notificationCount = 0;
                badge.style.display = 'none';
                
                // Show a toast message
                alert('Toutes les notifications ont été marquées comme lues');
            }
        });
        
        // Dark mode toggle functionality
        const darkModeToggle = document.getElementById('darkModeToggle');
        
        darkModeToggle.addEventListener('change', function() {
            if (this.checked) {
                // Switch to dark mode for entire interface
                document.body.style.backgroundColor = '#0f172a';
                document.body.style.color = '#cbd5e1';
                document.querySelector('.dashboard-content').style.backgroundColor = '#0f172a';
                
                // Update cards
                document.querySelectorAll('.stats-card, .activity-card, .project-card, .action-btn').forEach(card => {
                    card.style.backgroundColor = '#1e293b';
                    card.style.borderColor = '#334155';
                    card.style.color = '#cbd5e1';
                });
                
                // Update welcome card
                document.querySelector('.welcome-card').style.background = 'linear-gradient(135deg, #1e293b, #334155)';
                
                // Update text colors
                document.querySelectorAll('.stats-value, .activity-title, .project-title, .action-text').forEach(text => {
                    text.style.color = '#f1f5f9';
                });
            } else {
                // Switch back to light mode
                document.body.style.backgroundColor = '';
                document.body.style.color = '';
                document.querySelector('.dashboard-content').style.backgroundColor = '';
                
                // Update cards
                document.querySelectorAll('.stats-card, .activity-card, .project-card, .action-btn').forEach(card => {
                    card.style.backgroundColor = '';
                    card.style.borderColor = '';
                    card.style.color = '';
                });
                
                // Update welcome card
                document.querySelector('.welcome-card').style.background = '';
                
                // Update text colors
                document.querySelectorAll('.stats-value, .activity-title, .project-title, .action-text').forEach(text => {
                    text.style.color = '';
                });
            }
        });
    </script>
</body>
</html>