/**
 * Search V2 - Autocomplete avec données mock
 * Gestion de la recherche de destinations avec résultats en temps réel
 */

class SearchV2 {
    constructor() {
        this.searchInput = document.getElementById('searchInput');
        this.searchContainer = document.getElementById('searchContainer');
        this.searchResults = document.getElementById('searchResults');
        this.searchResultsList = document.getElementById('searchResultsList');
        this.clearBtn = document.getElementById('searchClearBtn');
        
        this.currentIndex = -1;
        this.searchTimeout = null;
        
        // Données mock de destinations
        this.destinations = [
            {
                id: 1,
                name: 'Québec',
                description: 'Vieux-Québec, Château Frontenac, Histoire',
                category: 'Ville',
                image: 'https://images.unsplash.com/photo-1519451241324-20b4ea2c4220?w=400&h=400&fit=crop'
            },
            {
                id: 2,
                name: 'Montréal',
                description: 'Métropole culturelle, Vieux-Port, Mont-Royal',
                category: 'Ville',
                image: 'https://images.unsplash.com/photo-1519112232436-9923c6ba3d26?w=400&h=400&fit=crop'
            },
            {
                id: 3,
                name: 'Chutes du Niagara',
                description: 'Merveille naturelle, Croisière, Observation',
                category: 'Nature',
                image: 'https://images.unsplash.com/photo-1489447068241-b3490214e879?w=400&h=400&fit=crop'
            },
            {
                id: 4,
                name: 'Parc National de Banff',
                description: 'Rocheuses, Lacs turquoise, Randonnée',
                category: 'Nature',
                image: 'https://images.unsplash.com/photo-1503614472-8c93d56e92ce?w=400&h=400&fit=crop'
            },
            {
                id: 5,
                name: 'Toronto',
                description: 'CN Tower, Quartiers multiculturels, Musées',
                category: 'Ville',
                image: 'https://images.unsplash.com/photo-1517935706615-2717063c2225?w=400&h=400&fit=crop'
            },
            {
                id: 6,
                name: 'Vancouver',
                description: 'Océan Pacifique, Montagnes, Stanley Park',
                category: 'Ville',
                image: 'https://images.unsplash.com/photo-1559511260-66a654ae982a?w=400&h=400&fit=crop'
            },
            {
                id: 7,
                name: 'Charlevoix',
                description: 'Paysages pittoresques, Art, Gastronomie',
                category: 'Région',
                image: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=400&fit=crop'
            },
            {
                id: 8,
                name: 'Gaspésie',
                description: 'Rocher Percé, Mer, Parc Forillon',
                category: 'Région',
                image: 'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=400&h=400&fit=crop'
            },
            {
                id: 9,
                name: 'Ottawa',
                description: 'Capitale, Parlement, Musées nationaux',
                category: 'Ville',
                image: 'https://images.unsplash.com/photo-1560932831-e8e0e8b9a3f8?w=400&h=400&fit=crop'
            },
            {
                id: 10,
                name: 'Laurentides',
                description: 'Ski, Lacs, Villégiature',
                category: 'Région',
                image: 'https://images.unsplash.com/photo-1551582045-6ec9c11d8697?w=400&h=400&fit=crop'
            },
            {
                id: 11,
                name: 'Mont-Tremblant',
                description: 'Station de ski, Village piétonnier, Golf',
                category: 'Station',
                image: 'https://images.unsplash.com/photo-1605540436563-5bca919ae766?w=400&h=400&fit=crop'
            },
            {
                id: 12,
                name: 'Îles de la Madeleine',
                description: 'Plages, Falaises rouges, Fruits de mer',
                category: 'Île',
                image: 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400&h=400&fit=crop'
            },
            {
                id: 13,
                name: 'Tadoussac',
                description: 'Observation des baleines, Fjord, Kayak',
                category: 'Nature',
                image: 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400&h=400&fit=crop'
            },
            {
                id: 14,
                name: 'Saguenay',
                description: 'Fjord du Saguenay, Croisières, Nature',
                category: 'Région',
                image: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=400&fit=crop'
            },
            {
                id: 15,
                name: 'Whistler',
                description: 'Ski de classe mondiale, VTT, Village alpin',
                category: 'Station',
                image: 'https://images.unsplash.com/photo-1551524164-687a55dd1126?w=400&h=400&fit=crop'
            }
        ];
        
        this.init();
    }
    
    init() {
        if (!this.searchInput) return;
        
        // Événements de recherche
        this.searchInput.addEventListener('input', (e) => {
            this.handleSearch(e.target.value);
        });
        
        this.searchInput.addEventListener('focus', () => {
            this.searchContainer.classList.add('active');
            if (this.searchInput.value.trim()) {
                this.showResults();
            }
        });
        
        // Bouton clear
        if (this.clearBtn) {
            this.clearBtn.addEventListener('click', () => {
                this.clearSearch();
            });
        }
        
        // Navigation au clavier
        this.searchInput.addEventListener('keydown', (e) => {
            this.handleKeyboard(e);
        });
        
        // Fermer au clic extérieur
        document.addEventListener('click', (e) => {
            if (!this.searchContainer.contains(e.target) && !this.searchResults.contains(e.target)) {
                this.hideResults();
                this.searchContainer.classList.remove('active');
            }
        });
    }
    
    handleSearch(query) {
        // Afficher/cacher le bouton clear
        if (this.clearBtn) {
            if (query.trim()) {
                this.clearBtn.classList.add('visible');
            } else {
                this.clearBtn.classList.remove('visible');
            }
        }
        
        // Debounce pour éviter trop de recherches
        clearTimeout(this.searchTimeout);
        
        if (!query.trim()) {
            this.hideResults();
            return;
        }
        
        this.searchTimeout = setTimeout(() => {
            this.performSearch(query);
        }, 300);
    }
    
    performSearch(query) {
        const normalizedQuery = query.toLowerCase().trim();
        
        // Filtrer les destinations
        const results = this.destinations.filter(dest => {
            return dest.name.toLowerCase().includes(normalizedQuery) ||
                   dest.description.toLowerCase().includes(normalizedQuery) ||
                   dest.category.toLowerCase().includes(normalizedQuery);
        });
        
        this.displayResults(results, query);
    }
    
    displayResults(results, query) {
        this.searchResultsList.innerHTML = '';
        
        if (results.length === 0) {
            this.showNoResults(query);
            this.showResults();
            return;
        }
        
        // Limiter à 21 résultats
        const maxResults = 21;
        const displayedResults = results.slice(0, maxResults);
        const hasMore = results.length > maxResults;
        
        displayedResults.forEach((dest, index) => {
            const li = document.createElement('li');
            li.className = 'search-v2-result-item';
            li.dataset.index = index;
            
            li.innerHTML = `
                <img src="${dest.image}" alt="${dest.name}" class="search-v2-result-image">
                <div class="search-v2-result-info">
                    <h5 class="search-v2-result-name">${this.highlightMatch(dest.name, query)}</h5>
                </div>
               
            `;
            
            // Événement de clic
            li.addEventListener('click', () => {
                this.selectDestination(dest);
            });
            
            // Événement de hover
            li.addEventListener('mouseenter', () => {
                this.highlightItem(index);
            });
            
            this.searchResultsList.appendChild(li);
        });
        
        // Ajouter le bouton "Voir tous" si plus de 21 résultats
        if (hasMore) {
            this.addViewAllButton(results.length, query);
        }
        
        this.showResults();
        this.currentIndex = -1;
    }
    
    addViewAllButton(totalResults, query) {
        // Supprimer l'ancien bouton s'il existe
        const existingBtn = this.searchResults.querySelector('.search-v2-view-all');
        if (existingBtn) {
            existingBtn.remove();
        }
        
        const viewAllDiv = document.createElement('div');
        viewAllDiv.className = 'search-v2-view-all';
        
        viewAllDiv.innerHTML = `
            <button class="search-v2-view-all-btn" type="button">
                Voir tous les ${totalResults} résultats
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>
        `;
        
        const btn = viewAllDiv.querySelector('.search-v2-view-all-btn');
        btn.addEventListener('click', () => {
            console.log(`Afficher tous les ${totalResults} résultats pour: ${query}`);
            // Vous pouvez rediriger vers une page de résultats complète
            // window.location.href = `/search?q=${encodeURIComponent(query)}`;
        });
        
        this.searchResults.appendChild(viewAllDiv);
    }
    
    showNoResults(query) {
        this.searchResultsList.innerHTML = `
            <div class="search-v2-no-results">
                <svg class="search-v2-no-results-icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                <p class="search-v2-no-results-text">Aucun résultat pour "${query}"</p>
                <p class="search-v2-no-results-suggestion">Essayez avec d'autres mots-clés</p>
            </div>
        `;
    }
    
    highlightMatch(text, query) {
        const regex = new RegExp(`(${query})`, 'gi');
        return text.replace(regex, '<strong>$1</strong>');
    }
    
    showResults() {
        this.searchResults.classList.add('visible');
    }
    
    hideResults() {
        this.searchResults.classList.remove('visible');
        this.currentIndex = -1;
    }
    
    clearSearch() {
        this.searchInput.value = '';
        this.clearBtn.classList.remove('visible');
        this.hideResults();
        this.searchInput.focus();
    }
    
    selectDestination(dest) {
        console.log('Destination sélectionnée:', dest);
        this.searchInput.value = dest.name;
        this.hideResults();
        
        // Scroll vers la section correspondante si elle existe
        const section = document.getElementById(dest.name.toLowerCase().replace(/\s+/g, '-'));
        if (section) {
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        
        // Vous pouvez ajouter ici une redirection ou une action personnalisée
        // window.location.href = `/destination/${dest.id}`;
    }
    
    handleKeyboard(e) {
        const items = this.searchResultsList.querySelectorAll('.search-v2-result-item');
        
        if (!items.length) return;
        
        switch(e.key) {
            case 'ArrowDown':
                e.preventDefault();
                this.currentIndex = Math.min(this.currentIndex + 1, items.length - 1);
                this.highlightItem(this.currentIndex);
                this.scrollToItem(this.currentIndex);
                break;
                
            case 'ArrowUp':
                e.preventDefault();
                this.currentIndex = Math.max(this.currentIndex - 1, 0);
                this.highlightItem(this.currentIndex);
                this.scrollToItem(this.currentIndex);
                break;
                
            case 'Enter':
                e.preventDefault();
                if (this.currentIndex >= 0 && items[this.currentIndex]) {
                    items[this.currentIndex].click();
                }
                break;
                
            case 'Escape':
                this.hideResults();
                this.searchContainer.classList.remove('active');
                break;
        }
    }
    
    highlightItem(index) {
        const items = this.searchResultsList.querySelectorAll('.search-v2-result-item');
        items.forEach((item, i) => {
            if (i === index) {
                item.classList.add('highlighted');
            } else {
                item.classList.remove('highlighted');
            }
        });
        this.currentIndex = index;
    }
    
    scrollToItem(index) {
        const items = this.searchResultsList.querySelectorAll('.search-v2-result-item');
        if (items[index]) {
            items[index].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
}

// Initialiser la recherche au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    new SearchV2();
});
