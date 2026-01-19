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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}"> 
   
</head>
<body>
    <!-- OVERLAY FOR MOBILE -->
    <div class="overlay" id="overlay"></div>
     <!-- HEADER -->
    <x-header />
    
  <!-- SIDEBAR -->
    <x-side-bar />
    
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
    
    // Vérifier si sidebarToggle existe avant d'ajouter l'événement
    if (sidebarToggle) {
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
    }
    
    // Close sidebar when clicking overlay
    if (overlay) {
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            this.classList.remove('active');
            
            // Réinitialiser l'icône du toggle si il existe
            if (sidebarToggle) {
                const icon = sidebarToggle.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        });
    }
    
    // Gestion des sous-menus - CORRIGÉ
    document.querySelectorAll('.has-submenu > .menu-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const submenuItem = this.closest('.has-submenu');
            const wasActive = submenuItem.classList.contains('active');
            
            // Fermer tous les autres sous-menus
            document.querySelectorAll('.has-submenu').forEach(item => {
                item.classList.remove('active');
            });
            
            // Si le sous-menu n'était pas actif, l'ouvrir
            if (!wasActive) {
                submenuItem.classList.add('active');
            }
        });
    });
    
    // Gestion des clics sur les éléments de menu réguliers (non sous-menu)
    document.querySelectorAll('.menu-item:not(.has-submenu) > a, .menu-item:not(.has-submenu)').forEach(item => {
        item.addEventListener('click', function(e) {
            // Pour les liens de menu réguliers, on laisse le lien fonctionner normalement
            // mais on met à jour la classe active
            e.stopPropagation();
            
            // Si c'est un lien de déconnexion, on ne fait rien
            if (this.closest('a') && this.closest('a').getAttribute('href') === '{{ route("logout") }}') {
                return;
            }
            
            // Si c'est un lien normal, on met à jour l'état actif
            if (this.closest('a') && !this.closest('a').hasAttribute('href') || 
                this.closest('a') && this.closest('a').getAttribute('href') === '#') {
                e.preventDefault();
                
                // Supprimer la classe active de tous les éléments de menu
                document.querySelectorAll('.menu-item').forEach(menuItem => {
                    menuItem.classList.remove('active');
                });
                
                // Ajouter la classe active à l'élément parent
                const parentItem = this.closest('.menu-item');
                if (parentItem) {
                    parentItem.classList.add('active');
                }
                
                // Fermer la sidebar sur mobile
                if (window.innerWidth <= 992) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    
                    // Réinitialiser l'icône du toggle si il existe
                    if (sidebarToggle) {
                        const icon = sidebarToggle.querySelector('i');
                        if (icon) {
                            icon.classList.remove('fa-times');
                            icon.classList.add('fa-bars');
                        }
                    }
                }
            }
        });
    });
    
    // Fermer les sous-menus quand on clique en dehors
    document.addEventListener('click', function(e) {
        // Si on ne clique pas sur un élément de menu ou sous-menu
        if (!e.target.closest('.has-submenu') && !e.target.closest('.menu-item')) {
            document.querySelectorAll('.has-submenu').forEach(item => {
                item.classList.remove('active');
            });
        }
    });
    
    // Simulate real-time stats update
    setInterval(() => {
        const visitsElement = document.querySelectorAll('.stats-value')[1];
        if (visitsElement) {
            const currentVisits = parseInt(visitsElement.textContent.replace('K', '')) * 1000;
            const randomIncrement = Math.floor(Math.random() * 100) + 1;
            const newVisits = (currentVisits + randomIncrement);
            visitsElement.textContent = (newVisits / 1000).toFixed(1) + 'K';
        }
    }, 15000);
    
    // Notification badge update
    let notificationCount = 3;
    const notificationBtn = document.querySelector('.notification-btn');
    
    if (notificationBtn) {
        notificationBtn.addEventListener('click', function() {
            const badge = this.querySelector('.notification-badge');
            if (notificationCount > 0 && badge) {
                notificationCount = 0;
                badge.style.display = 'none';
                
                // Show a toast message
                alert('Toutes les notifications ont été marquées comme lues');
            }
        });
    }
    
    // Dark mode toggle functionality
    const darkModeToggle = document.getElementById('darkModeToggle');
    
    if (darkModeToggle) {
        darkModeToggle.addEventListener('change', function() {
            if (this.checked) {
                // Switch to dark mode for entire interface
                document.body.style.backgroundColor = '#0f172a';
                document.body.style.color = '#cbd5e1';
                const dashboardContent = document.querySelector('.dashboard-content');
                if (dashboardContent) {
                    dashboardContent.style.backgroundColor = '#0f172a';
                }
                
                // Update cards
                document.querySelectorAll('.stats-card, .activity-card, .project-card, .action-btn').forEach(card => {
                    card.style.backgroundColor = '#1e293b';
                    card.style.borderColor = '#334155';
                    card.style.color = '#cbd5e1';
                });
                
                // Update welcome card
                const welcomeCard = document.querySelector('.welcome-card');
                if (welcomeCard) {
                    welcomeCard.style.background = 'linear-gradient(135deg, #1e293b, #334155)';
                }
                
                // Update text colors
                document.querySelectorAll('.stats-value, .activity-title, .project-title, .action-text').forEach(text => {
                    text.style.color = '#f1f5f9';
                });
            } else {
                // Switch back to light mode
                document.body.style.backgroundColor = '';
                document.body.style.color = '';
                const dashboardContent = document.querySelector('.dashboard-content');
                if (dashboardContent) {
                    dashboardContent.style.backgroundColor = '';
                }
                
                // Update cards
                document.querySelectorAll('.stats-card, .activity-card, .project-card, .action-btn').forEach(card => {
                    card.style.backgroundColor = '';
                    card.style.borderColor = '';
                    card.style.color = '';
                });
                
                // Update welcome card
                const welcomeCard = document.querySelector('.welcome-card');
                if (welcomeCard) {
                    welcomeCard.style.background = '';
                }
                
                // Update text colors
                document.querySelectorAll('.stats-value, .activity-title, .project-title, .action-text').forEach(text => {
                    text.style.color = '';
                });
            }
        });
    }
    
    // Fonction pour fermer la sidebar sur mobile
    const closeSidebarOnMobile = () => {
        if (window.innerWidth <= 992) {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            
            if (sidebarToggle) {
                const icon = sidebarToggle.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        }
    };
    
    // Fermer la sidebar quand on clique sur un lien dans un sous-menu
    document.querySelectorAll('.submenu-item').forEach(item => {
        item.addEventListener('click', function(e) {
            // Ne pas empêcher le comportement par défaut des liens
            // Fermer juste la sidebar sur mobile
            if (window.innerWidth <= 992) {
                closeSidebarOnMobile();
            }
            
            // Marquer cet élément comme actif
            document.querySelectorAll('.submenu-item').forEach(subItem => {
                subItem.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
</script>

</body>
</html>