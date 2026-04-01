/**
 * Menu Vertical V2 Controller - Version Dynamique
 * Charge les menus depuis l'API et gère l'affichage avec sous-menus
 */

class VerticalMenuDynamic {
    constructor() {
        this.menu = document.getElementById('verticalMenuV2');
        this.overlay = document.getElementById('verticalMenuOverlay');
        this.openBtn = document.getElementById('openVerticalMenu');
        this.closeBtn = document.getElementById('closeVerticalMenu');
        this.menuList = document.getElementById('verticalMenuList');
        this.service = window.menuApiService;
        this.isOpen = false;
        this.menus = [];
        
        this.init();
    }
    
    async init() {
        if (!this.menu || !this.overlay || !this.openBtn || !this.menuList) {
            console.error('Éléments du menu vertical non trouvés');
            return;
        }
        
        if (!this.service) {
            console.error('MenuApiService non disponible');
            return;
        }
        
        // Charger les menus depuis l'API
        await this.loadMenus();
        
        // Initialiser les événements
        this.initEvents();
    }
    
    async loadMenus() {
        try {
            // Charger les menus racines avec leurs enfants
            this.menus = await this.service.getRootMenus(true);
            
            console.log('📋 Menus chargés depuis l\'API:', this.menus);
            console.log('📊 Nombre de menus:', this.menus.length);
            
            if (this.menus.length > 0) {
                console.log('🔍 Structure du premier menu:', this.menus[0]);
                console.log('🔑 Propriétés disponibles:', Object.keys(this.menus[0]));
            }
            
            if (this.menus.length === 0) {
                console.warn('⚠️ Aucun menu trouvé');
                this.showEmptyState();
                return;
            }
            
            // Générer le HTML des menus
            this.renderMenus();
            
        } catch (error) {
            console.error('❌ Erreur lors du chargement des menus:', error);
            this.showErrorState();
        }
    }
    
    renderMenus() {
        if (!this.menuList) return;
        
        // Supprimer uniquement le loader
        const loader = this.menuList.querySelector('.vertical-menu-v2-loading');
        if (loader) {
            loader.remove();
        }
        
        // Générer le HTML des menus dynamiques
        const menusHTML = this.menus.map(menu => this.createMenuItem(menu)).join('');
        
        // Trouver le premier élément mobile-only
        const firstMobileItem = this.menuList.querySelector('.vertical-menu-v2-mobile-only');
        
        if (firstMobileItem) {
            // Insérer les menus dynamiques AVANT les items mobile
            firstMobileItem.insertAdjacentHTML('beforebegin', menusHTML);
        } else {
            // Si pas d'items mobile, ajouter à la fin
            this.menuList.insertAdjacentHTML('beforeend', menusHTML);
        }
        
        // Réinitialiser les événements après le rendu
        this.initMenuEvents();
    }
    
    createMenuItem(menu) {
        const hasChildren = menu.active_children && menu.active_children.length > 0;
        const url = this.service.getMenuUrl(menu);
        // Utiliser une icône par défaut si icon est null
        const iconPath = menu.icon || 'header_info/info.png';
        
        if (hasChildren) {
            // Menu avec sous-menus (accordéon)
            return `
                <li class="vertical-menu-v2-item vertical-menu-v2-accordion">
                    <a href="#" class="vertical-menu-v2-link vertical-menu-v2-accordion-trigger">
                        <span>${menu.title}</span>
                        <svg class="vertical-menu-v2-accordion-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <ul class="vertical-menu-v2-submenu">
                        ${menu.active_children.map(child => this.createSubMenuItem(child)).join('')}
                    </ul>
                </li>
            `;
        } else {
            // Menu simple sans sous-menus
            return `
                <li class="vertical-menu-v2-item">
                    <a href="${url}" class="vertical-menu-v2-link">
                        <span>${menu.title}</span>
                    </a>
                </li>
            `;
        }
    }
    
    createSubMenuItem(submenu) {
        const url = this.service.getMenuUrl(submenu);
        
        return `
            <li class="vertical-menu-v2-subitem">
                <a href="${url}" class="vertical-menu-v2-sublink">
                    <span>${submenu.title}</span>
                </a>
            </li>
        `;
    }
    
    getAssetUrl(path) {
        // Si le chemin commence par http, le retourner tel quel
        if (path && (path.startsWith('http://') || path.startsWith('https://'))) {
            return path;
        }
        
        // Utiliser asset() pour les fichiers locaux
        return path ? `/storage/${path}` : '/header_info/info.png';
    }
    
    showEmptyState() {
        if (!this.menuList) return;
        
        this.menuList.innerHTML = `
            <li class="vertical-menu-v2-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <p>Aucun menu disponible</p>
            </li>
        `;
    }
    
    showErrorState() {
        if (!this.menuList) return;
        
        this.menuList.innerHTML = `
            <li class="vertical-menu-v2-error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
                <p>Erreur de chargement des menus</p>
            </li>
        `;
    }
    
    initEvents() {
        // Ouvrir le menu
        this.openBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            this.openMenu();
        });
        
        // Fermer le menu
        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', () => {
                this.closeMenu();
            });
        }
        
        // Fermer en cliquant sur l'overlay
        this.overlay.addEventListener('click', () => {
            this.closeMenu();
        });
        
        // Fermer avec la touche Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.closeMenu();
            }
        });
        
        // Empêcher le scroll du body quand le menu est ouvert
        this.menu.addEventListener('touchmove', (e) => {
            e.stopPropagation();
        }, { passive: false });
    }
    
    initMenuEvents() {
        // Gestion de l'accordéon
        const accordionTriggers = this.menuList.querySelectorAll('.vertical-menu-v2-accordion-trigger');
        
        accordionTriggers.forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                const parentItem = trigger.closest('.vertical-menu-v2-accordion');
                const isActive = parentItem.classList.contains('active');
                
                // Fermer tous les autres accordéons
                this.menuList.querySelectorAll('.vertical-menu-v2-accordion').forEach(item => {
                    if (item !== parentItem) {
                        item.classList.remove('active');
                    }
                });
                
                // Toggle l'accordéon actuel
                parentItem.classList.toggle('active');
            });
        });
        
        // Fermer le menu au clic sur un lien simple
        const simpleLinks = this.menuList.querySelectorAll('.vertical-menu-v2-link:not(.vertical-menu-v2-accordion-trigger)');
        simpleLinks.forEach(link => {
            link.addEventListener('click', () => {
                this.closeMenu();
            });
        });
        
        // Fermer le menu au clic sur un sous-lien
        const subLinks = this.menuList.querySelectorAll('.vertical-menu-v2-sublink');
        subLinks.forEach(link => {
            link.addEventListener('click', () => {
                this.closeMenu();
            });
        });
    }
    
    openMenu() {
        this.isOpen = true;
        this.menu.classList.add('active');
        this.overlay.classList.add('active');
        this.openBtn.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Afficher les items instantanément sans animation
        const items = this.menuList.querySelectorAll('.vertical-menu-v2-item');
        items.forEach((item) => {
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        });
    }
    
    closeMenu() {
        this.isOpen = false;
        this.menu.classList.remove('active');
        this.overlay.classList.remove('active');
        this.openBtn.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    toggleMenu() {
        if (this.isOpen) {
            this.closeMenu();
        } else {
            this.openMenu();
        }
    }
    
    // Méthode pour recharger les menus
    async reload() {
        this.service.clearCache();
        await this.loadMenus();
    }
}

// Initialiser le menu vertical quand le DOM est prêt
document.addEventListener('DOMContentLoaded', () => {
    if (window.menuApiService) {
        window.verticalMenuDynamic = new VerticalMenuDynamic();
    } else {
        console.error('MenuApiService non disponible - Vérifier que menu-api-service.js est chargé avant');
    }
});
