/**
 * Events Vedette V2 - Gestion des filtres et interactions
 * Système de filtrage des événements par catégorie
 */

class EventsVedetteV2 {
    constructor() {
        this.grid = document.getElementById('eventsVedetteGrid');
        this.filterButtons = document.querySelectorAll('.events-vedette-v2-filter-btn');
        this.cards = document.querySelectorAll('.events-vedette-v2-card');
        this.moreBtn = document.querySelector('.events-vedette-v2-more-btn');
        
        this.currentFilter = 'all';
        
        this.init();
    }
    
    init() {
        if (!this.grid) return;
        
        this.attachFilterEvents();
        this.attachMoreButtonEvent();
        this.attachCardEvents();
    }
    
    attachFilterEvents() {
        this.filterButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const filter = e.currentTarget.getAttribute('data-filter');
                this.applyFilter(filter);
                this.updateActiveButton(e.currentTarget);
            });
        });
    }
    
    applyFilter(filter) {
        this.currentFilter = filter;
        
        this.cards.forEach(card => {
            const category = card.getAttribute('data-category');
            
            if (filter === 'all' || category === filter) {
                card.classList.remove('events-vedette-v2-hidden');
                setTimeout(() => {
                    card.style.animation = 'events-vedette-v2-card-appear 0.5s ease';
                }, 10);
            } else {
                card.classList.add('events-vedette-v2-hidden');
            }
        });
        
        this.updateGridAnimation();
    }
    
    updateActiveButton(activeButton) {
        this.filterButtons.forEach(btn => {
            btn.classList.remove('active');
        });
        activeButton.classList.add('active');
    }
    
    updateGridAnimation() {
        this.grid.style.animation = 'none';
        setTimeout(() => {
            this.grid.style.animation = 'events-vedette-v2-fade-in 0.6s ease';
        }, 10);
    }
    
    attachMoreButtonEvent() {
        if (this.moreBtn) {
            this.moreBtn.addEventListener('click', () => {
                console.log('En savoir plus sur les événements vedette');
                alert('Redirection vers la page complète des événements vedette...');
            });
        }
    }
    
    attachCardEvents() {
        this.cards.forEach(card => {
            card.addEventListener('click', (e) => {
                const title = card.querySelector('.events-vedette-v2-card-title').textContent;
                console.log('Événement sélectionné:', title);
            });
            
            card.addEventListener('mouseenter', () => {
                card.style.zIndex = '10';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.zIndex = '1';
            });
        });
    }
    
    getVisibleCardsCount() {
        return Array.from(this.cards).filter(card => 
            !card.classList.contains('events-vedette-v2-hidden')
        ).length;
    }
    
    resetFilters() {
        this.applyFilter('all');
        this.filterButtons.forEach(btn => {
            if (btn.getAttribute('data-filter') === 'all') {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const eventsVedette = new EventsVedetteV2();
    window.eventsVedetteV2Instance = eventsVedette;
});
