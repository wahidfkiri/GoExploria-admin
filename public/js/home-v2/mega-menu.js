/**
 * Mega Menu V2 Controller
 * Gère l'ouverture/fermeture du mega menu au hover de "Nos Services"
 */

class MegaMenuV2 {
    constructor() {
        this.menuItem = document.getElementById('servicesMenuItem');
        this.megaMenu = document.querySelector('.mega-menu-v2');
        this.isMobile = window.innerWidth <= 768;
        this.hoverTimeout = null;
        this.isOpen = false;
        
        this.init();
    }
    
    init() {
        if (!this.menuItem || !this.megaMenu) return;
        
        // Détection responsive
        window.addEventListener('resize', () => {
            this.isMobile = window.innerWidth <= 768;
        });
        
        if (this.isMobile) {
            this.initMobile();
        } else {
            this.initDesktop();
        }
        
        // Fermer au clic sur un lien du mega menu
        const megaLinks = this.megaMenu.querySelectorAll('.mega-menu-v2-link');
        megaLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                this.closeMegaMenu();
                
                // Scroll smooth vers la section
                const href = link.getAttribute('href');
                if (href && href.startsWith('#')) {
                    e.preventDefault();
                    const targetId = href.substring(1);
                    const targetElement = document.getElementById(targetId);
                    
                    if (targetElement) {
                        const headerHeight = document.querySelector('.header-v2')?.offsetHeight || 0;
                        const targetPosition = targetElement.offsetTop - headerHeight - 20;
                        
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    }
    
    initDesktop() {
        // Ouvrir au hover
        this.menuItem.addEventListener('mouseenter', () => {
            clearTimeout(this.hoverTimeout);
            this.openMegaMenu();
        });
        
        // Fermer avec un délai au mouseleave
        this.menuItem.addEventListener('mouseleave', () => {
            this.hoverTimeout = setTimeout(() => {
                this.closeMegaMenu();
            }, 300);
        });
        
        // Garder ouvert si on survole le mega menu
        this.megaMenu.addEventListener('mouseenter', () => {
            clearTimeout(this.hoverTimeout);
        });
        
        // Fermer quand on quitte le mega menu
        this.megaMenu.addEventListener('mouseleave', () => {
            this.hoverTimeout = setTimeout(() => {
                this.closeMegaMenu();
            }, 300);
        });
        
        // Fermer au clic en dehors (sur l'overlay)
        this.megaMenu.addEventListener('click', (e) => {
            if (e.target === this.megaMenu) {
                this.closeMegaMenu();
            }
        });
    }
    
    initMobile() {
        // Sur mobile, ouvrir au clic
        const serviceLink = this.menuItem.querySelector('a');
        
        if (serviceLink) {
            serviceLink.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleMegaMenu();
            });
        }
        
        // Créer l'overlay pour mobile
        let overlay = document.querySelector('.mega-menu-v2-overlay-mobile');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'mega-menu-v2-overlay-mobile';
            document.body.appendChild(overlay);
        }
        
        // Fermer au clic sur l'overlay
        overlay.addEventListener('click', () => {
            this.closeMegaMenu();
        });
        
        // Fermer au clic sur le bouton X (::before)
        this.megaMenu.addEventListener('click', (e) => {
            const rect = this.megaMenu.getBoundingClientRect();
            const closeButtonArea = {
                top: 20,
                right: 20,
                width: 40,
                height: 40
            };
            
            const clickX = e.clientX - rect.left;
            const clickY = e.clientY - rect.top;
            
            if (
                clickX >= rect.width - closeButtonArea.right - closeButtonArea.width &&
                clickX <= rect.width - closeButtonArea.right &&
                clickY >= closeButtonArea.top &&
                clickY <= closeButtonArea.top + closeButtonArea.height
            ) {
                this.closeMegaMenu();
            }
        });
    }
    
    openMegaMenu() {
        this.isOpen = true;
        this.megaMenu.classList.add('active');
        this.menuItem.classList.add('active');
        
        if (this.isMobile) {
            document.body.style.overflow = 'hidden';
            const overlay = document.querySelector('.mega-menu-v2-overlay-mobile');
            if (overlay) overlay.classList.add('active');
        }
    }
    
    closeMegaMenu() {
        this.isOpen = false;
        this.megaMenu.classList.remove('active');
        this.menuItem.classList.remove('active');
        
        if (this.isMobile) {
            document.body.style.overflow = '';
            const overlay = document.querySelector('.mega-menu-v2-overlay-mobile');
            if (overlay) overlay.classList.remove('active');
        }
    }
    
    toggleMegaMenu() {
        if (this.isOpen) {
            this.closeMegaMenu();
        } else {
            this.openMegaMenu();
        }
    }
}

// Initialiser le mega menu quand le DOM est prêt
document.addEventListener('DOMContentLoaded', () => {
    new MegaMenuV2();
});
