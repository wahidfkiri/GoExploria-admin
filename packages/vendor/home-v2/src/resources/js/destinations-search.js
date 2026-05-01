/**
 * Gestion de la recherche de destinations dans la barre de recherche Hero
 */

class DestinationsSearch {
    constructor() {
        this.searchInput = document.getElementById('searchBarInput');
        this.searchResults = document.getElementById('searchBarResults');
        this.clearBtn = document.getElementById('searchBarClearBtn');
        this.service = window.megaMenuService;
        this.searchTimeout = null;
        this.minQueryLength = 2;
        
        this.init();
    }
    
    init() {
        if (!this.searchInput || !this.service) return;
        
        // Événements sur l'input
        this.searchInput.addEventListener('input', (e) => this.handleInput(e));
        this.searchInput.addEventListener('focus', () => this.handleFocus());
        this.searchInput.addEventListener('blur', () => this.handleBlur());
        
        // Événement sur le bouton clear
        if (this.clearBtn) {
            this.clearBtn.addEventListener('click', () => this.clearSearch());
        }
        
        // Fermer les résultats en cliquant ailleurs
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-bar-v2-search')) {
                this.hideResults();
            }
        });
    }
    
    handleInput(e) {
        const query = e.target.value.trim();
        
        // Afficher/masquer le bouton clear
        if (this.clearBtn) {
            this.clearBtn.style.display = query ? 'flex' : 'none';
        }
        
        // Annuler la recherche précédente
        if (this.searchTimeout) {
            clearTimeout(this.searchTimeout);
        }
        
        // Si la requête est trop courte, masquer les résultats
        if (query.length < this.minQueryLength) {
            this.hideResults();
            return;
        }
        
        // Lancer la recherche après un délai
        this.searchTimeout = setTimeout(() => {
            this.performSearch(query);
        }, 300);
    }
    
    handleFocus() {
        const query = this.searchInput.value.trim();
        if (query.length >= this.minQueryLength) {
            this.showResults();
        }
    }
    
    handleBlur() {
        // Délai pour permettre le clic sur un résultat
        setTimeout(() => {
            if (!this.searchResults.matches(':hover')) {
                this.hideResults();
            }
        }, 200);
    }
    
    async performSearch(query) {
        this.showLoader();
        
        try {
            const results = await this.service.searchDestinations(query);
            
            if (results.length > 0) {
                this.renderResults(results);
            } else {
                this.showNoResults(query);
            }
        } catch (error) {
            console.error('Erreur lors de la recherche:', error);
            this.showError();
        }
    }
    
    renderResults(results) {
        if (!this.searchResults) return;
        
        // Grouper les résultats par type
        const grouped = this.groupByType(results);
        
        let html = '<div class="search-bar-v2-results-header"><h4 class="search-bar-v2-results-title">Résultats de la recherche</h4></div>';
        html += '<div class="search-bar-v2-results-content">';
        
        // Afficher chaque groupe
        for (const [type, items] of Object.entries(grouped)) {
            if (items.length === 0) continue;
            
            html += `<div class="search-bar-v2-results-group">`;
            html += `<div class="search-bar-v2-results-group-title">${this.getTypeLabel(type)}</div>`;
            
            items.forEach(item => {
                const url = this.service.getDestinationUrl(item);
                const icon = this.getIconForType(item.type);
                const imageUrl = item.image_url || item.image || this.getDefaultImage(item.type);
                
                html += `
                    <a href="${url}" class="search-bar-v2-result-item">
                        <div class="search-bar-v2-result-image">
                            <img src="${imageUrl}" alt="${item.name}" onerror="this.src='${this.getDefaultImage(item.type)}'">
                        </div>
                        <div class="search-bar-v2-result-content">
                            <div class="search-bar-v2-result-name">${item.name}</div>
                            <div class="search-bar-v2-result-type">${this.getTypeLabel(item.type)}</div>
                            ${item.description ? `<div class="search-bar-v2-result-description">${this.truncate(item.description, 100)}</div>` : ''}
                        </div>
                        <div class="search-bar-v2-result-arrow">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                `;
            });
            
            html += `</div>`;
        }
        
        html += '</div>';
        
        this.searchResults.innerHTML = html;
        this.showResults();
    }
    
    groupByType(results) {
        const grouped = {
            continent: [],
            country: [],
            province: [],
            region: [],
            ville: [],
            secteur: []
        };
        
        results.forEach(item => {
            const type = item.type || 'ville';
            if (grouped[type]) {
                grouped[type].push(item);
            }
        });
        
        return grouped;
    }
    
    getTypeLabel(type) {
        const labels = {
            continent: 'Continents',
            country: 'Pays',
            province: 'Provinces',
            region: 'Régions',
            ville: 'Villes',
            secteur: 'Secteurs'
        };
        return labels[type] || type;
    }
    
    getIconForType(type) {
        const icons = {
            continent: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>',
            country: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>',
            province: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>',
            region: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon></svg>',
            ville: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>',
            secteur: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"></rect></svg>'
        };
        return icons[type] || icons.ville;
    }
    
    showLoader() {
        if (!this.searchResults) return;
        
        this.searchResults.innerHTML = `
            <div class="search-bar-v2-results-loader">
                <div class="spinner"></div>
                <p>Recherche en cours...</p>
            </div>
        `;
        this.showResults();
    }
    
    showNoResults(query) {
        if (!this.searchResults) return;
        
        this.searchResults.innerHTML = `
            <div class="search-bar-v2-results-empty">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                <p>Aucun résultat pour "${this.escapeHtml(query)}"</p>
                <small>Essayez avec d'autres mots-clés</small>
            </div>
        `;
        this.showResults();
    }
    
    showError() {
        if (!this.searchResults) return;
        
        this.searchResults.innerHTML = `
            <div class="search-bar-v2-results-error">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <p>Une erreur s'est produite</p>
                <small>Veuillez réessayer plus tard</small>
            </div>
        `;
        this.showResults();
    }
    
    showResults() {
        if (this.searchResults) {
            this.searchResults.classList.add('active');
        }
    }
    
    hideResults() {
        if (this.searchResults) {
            this.searchResults.classList.remove('active');
        }
    }
    
    clearSearch() {
        this.searchInput.value = '';
        this.searchInput.focus();
        this.hideResults();
        if (this.clearBtn) {
            this.clearBtn.style.display = 'none';
        }
    }
    
    truncate(text, length) {
        if (text.length <= length) return text;
        return text.substring(0, length) + '...';
    }
    
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    getDefaultImage(type) {
        const defaults = {
            continent: 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=400',
            country: 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=400',
            province: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400',
            region: 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=400',
            ville: 'https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?w=400',
            secteur: 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=400'
        };
        
        return defaults[type] || defaults.ville;
    }
}

// Initialiser au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    if (window.__GOEXPLORIA_USE_NEW_SEARCH_BAR) {
        return;
    }
    if (window.megaMenuService) {
        new DestinationsSearch();
    } else {
        console.error('MegaMenuService non disponible pour la recherche');
    }
});
