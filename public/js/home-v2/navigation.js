/**
 * Navigation Controller
 * Gère le menu mobile et les interactions de navigation
 */

class Navigation {
    constructor() {
        this.menuToggle = document.querySelector('.menu-toggle');
        this.navMenu = document.querySelector('.nav-center');
        this.header = document.querySelector('.header-v2');
        this.scrollBtn = document.querySelector('.hero-scroll-btn');
        this.mobileSearchTrigger = document.getElementById('mobileSearchTrigger');
        this.isMenuOpen = false;
        this.isSearchOpen = false;
        this.lastScrollY = window.scrollY;
        
        this.init();
    }
    
    init() {
        // Toggle recherche mobile
        if (this.mobileSearchTrigger) {
            this.mobileSearchTrigger.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleMobileSearch();
            });
        }
        
        // Smooth scroll pour les liens d'ancrage
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(anchor.getAttribute('href'));
                if (target) {
                    this.smoothScrollTo(target);
                    if (this.isMenuOpen) {
                        this.toggleMenu();
                    }
                }
            });
        });
        
        // Bouton de scroll
        if (this.scrollBtn) {
            this.scrollBtn.addEventListener('click', () => {
                window.scrollTo({
                    top: window.innerHeight,
                    behavior: 'smooth'
                });
            });
        }
        
        // Header au scroll
        window.addEventListener('scroll', () => this.handleScroll());
        
        // Fermer le menu en cliquant à l'extérieur
        document.addEventListener('click', (e) => {
            const navCenter = document.querySelector('.nav-center');
            if (this.isMenuOpen && 
                navCenter &&
                !navCenter.contains(e.target) && 
                !this.menuToggle.contains(e.target)) {
                this.toggleMenu();
            }
        });
        
        // Fermer le menu au clic sur un lien
        if (this.navMenu) {
            const menuLinks = this.navMenu.querySelectorAll('a');
            menuLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (this.isMenuOpen) {
                        this.toggleMenu();
                    }
                });
            });
        }
    }
    
    toggleMenu() {
        this.isMenuOpen = !this.isMenuOpen;
        const navCenter = document.querySelector('.nav-center');
        
        if (this.isMenuOpen) {
            if (navCenter) navCenter.classList.add('active');
            if (this.menuToggle) this.menuToggle.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Fermer la recherche si le menu s'ouvre
            if (this.isSearchOpen) this.toggleMobileSearch();
        } else {
            if (navCenter) navCenter.classList.remove('active');
            if (this.menuToggle) this.menuToggle.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    toggleMobileSearch() {
        this.isSearchOpen = !this.isSearchOpen;
        const searchBar = document.querySelector('.hero-v2 .search-bar-v2');
        
        if (this.isSearchOpen) {
            if (searchBar) searchBar.classList.add('active');
            if (this.mobileSearchTrigger) this.mobileSearchTrigger.classList.add('active');
            
            // Fermer le menu si la recherche s'ouvre
            if (this.isMenuOpen) this.toggleMenu();
        } else {
            if (searchBar) searchBar.classList.remove('active');
            if (this.mobileSearchTrigger) this.mobileSearchTrigger.classList.remove('active');
        }
    }
    
    handleScroll() {
        const currentScrollY = window.scrollY;
        
        // Ajouter une classe au header quand on scroll (dès 10px)
        if (currentScrollY > 10) {
            this.header.classList.add('scrolled');
        } else {
            this.header.classList.remove('scrolled');
        }
        
        // Cacher/afficher le header selon la direction du scroll
        if (currentScrollY > this.lastScrollY && currentScrollY > 300) {
            this.header.style.transform = 'translateY(-100%)';
        } else {
            this.header.style.transform = 'translateY(0)';
        }
        
        this.lastScrollY = currentScrollY;
    }
    
    smoothScrollTo(target) {
        const targetPosition = target.getBoundingClientRect().top + window.scrollY;
        const startPosition = window.scrollY;
        const distance = targetPosition - startPosition;
        const duration = 1000;
        let start = null;
        
        const animation = (currentTime) => {
            if (start === null) start = currentTime;
            const timeElapsed = currentTime - start;
            const run = this.easeInOutCubic(timeElapsed, startPosition, distance, duration);
            window.scrollTo(0, run);
            if (timeElapsed < duration) requestAnimationFrame(animation);
        };
        
        requestAnimationFrame(animation);
    }
    
    easeInOutCubic(t, b, c, d) {
        t /= d / 2;
        if (t < 1) return c / 2 * t * t * t + b;
        t -= 2;
        return c / 2 * (t * t * t + 2) + b;
    }
}

// Initialiser la navigation quand le DOM est prêt
document.addEventListener('DOMContentLoaded', () => {
    new Navigation();
});
