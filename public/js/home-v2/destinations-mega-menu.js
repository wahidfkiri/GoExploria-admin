/**
 * Gestion du Mega Menu Destinations
 * Affiche les destinations hiérarchiques (Continents > Pays > Provinces > Régions > Villes)
 */

class DestinationsMegaMenu {
    constructor() {
        console.log('🔧 Initialisation DestinationsMegaMenu...');
        
        this.megaMenu = document.getElementById('destinationsMegaMenu');
        this.loader = document.getElementById('destinationsLoader');
        this.grid = document.getElementById('destinationsGrid');
        this.empty = document.getElementById('destinationsEmpty');
        this.breadcrumb = document.getElementById('destinationsBreadcrumb');
        this.trigger = null;
        this.service = window.megaMenuService;
        this.isOpen = false;
        this.hideTimeout = null;
        this.currentBreadcrumb = [];
        
        console.log('📍 Mega Menu trouvé:', !!this.megaMenu);
        console.log('📍 Service API trouvé:', !!this.service);
        
        this.init();
    }
    
    init() {
        if (!this.megaMenu) {
            console.error('❌ Mega Menu DOM element non trouvé (#destinationsMegaMenu)');
            return;
        }
        
        if (!this.service) {
            console.error('❌ MegaMenuService non disponible (window.megaMenuService)');
            return;
        }
        
        // Trouver le trigger (élément DESTINATIONS)
        this.trigger = document.querySelector('.search-bar-v2-destinations');
        
        console.log('📍 Trigger trouvé:', !!this.trigger);
        
        if (this.trigger) {
            // Événements sur le trigger
            this.trigger.addEventListener('mouseenter', () => {
                this.show();
            });
            this.trigger.addEventListener('mouseleave', () => this.scheduleHide());
            
            // Événements sur le mega menu
            this.megaMenu.addEventListener('mouseenter', () => this.cancelHide());
            this.megaMenu.addEventListener('mouseleave', () => this.scheduleHide());
        } else {
            console.error('Trigger non trouvé (.search-bar-v2-destinations)');
        }
    }
    
    async show() {
        console.log('📂 Affichage du mega menu...');
        this.cancelHide();
        
        if (this.isOpen) {
            console.log('ℹ️ Mega menu déjà ouvert');
            return;
        }
        this.isOpen = true;
        
        // Afficher le mega menu instantanément
        console.log('👁️ Affichage du mega menu DOM');
        this.megaMenu.style.display = 'block';
        this.megaMenu.classList.add('active');
        console.log('✅ Classe "active" ajoutée');
        
        // Charger les données si pas encore chargées
        if (this.grid.children.length === 0) {
            console.log('📥 Chargement des destinations...');
            await this.loadDestinations();
        } else {
            console.log('ℹ️ Destinations déjà chargées');
        }
    }
    
    scheduleHide() {
        this.hideTimeout = setTimeout(() => this.hide(), 300);
    }
    
    cancelHide() {
        if (this.hideTimeout) {
            clearTimeout(this.hideTimeout);
            this.hideTimeout = null;
        }
    }
    
    hide() {
        this.isOpen = false;
        this.megaMenu.classList.remove('active');
        if (!this.isOpen) {
            this.megaMenu.style.display = 'none';
        }
    }
    
    async loadDestinations() {
        this.showLoader();
        
        try {
            // Charger les continents
            const continents = await this.service.getContinents();
            
            if (continents.length === 0) {
                this.showEmpty();
                return;
            }
            
            // Générer le contenu
            await this.renderContinents(continents);
            
            this.showGrid();
            
            // Sélectionner "Amérique du Nord" par défaut
            const ameriqueDuNord = continents.find(c => c.name.toLowerCase().includes('amérique du nord') || c.name.toLowerCase().includes('north america'));
            if (ameriqueDuNord) {
                // Simuler un hover sur Amérique du Nord
                const continentItems = this.grid.querySelectorAll('.destinations-mega-continent-item');
                continentItems.forEach(item => {
                    if (item.dataset.continentId == ameriqueDuNord.id) {
                        item.classList.add('active');
                        this.updateBreadcrumb([ameriqueDuNord]);
                        this.loadContinentDetails(ameriqueDuNord);
                    }
                });
            }
        } catch (error) {
            console.error('Erreur lors du chargement des destinations:', error);
            this.showEmpty();
        }
    }
    
    async renderContinents(continents) {
        // Créer le container à 2 colonnes
        const container = document.createElement('div');
        container.className = 'destinations-mega-two-columns';
        
        // Colonne gauche: Liste des continents
        const leftColumn = document.createElement('div');
        leftColumn.className = 'destinations-mega-left-column';
        
        const continentsList = document.createElement('div');
        continentsList.className = 'destinations-mega-continents-list';
        
        continents.forEach((continent) => {
            const item = this.createContinentItem(continent);
            continentsList.appendChild(item);
        });
        
        leftColumn.appendChild(continentsList);
        
        // Colonne droite: Contenu dynamique
        const rightColumn = document.createElement('div');
        rightColumn.className = 'destinations-mega-right-column';
        rightColumn.innerHTML = '<div class="destinations-mega-placeholder">Survolez un continent pour voir les destinations</div>';
        
        container.appendChild(leftColumn);
        container.appendChild(rightColumn);
        
        this.grid.innerHTML = '';
        this.grid.appendChild(container);
    }
    
    createContinentItem(continent) {
        const item = document.createElement('div');
        item.className = 'destinations-mega-continent-item';
        item.dataset.continentId = continent.id;
        item.dataset.loaded = 'false';
        item.textContent = continent.name;
        
        // Événement hover pour charger et afficher les pays
        item.addEventListener('mouseenter', async () => {
            // Retirer la sélection des autres continents
            const siblings = item.parentElement.querySelectorAll('.destinations-mega-continent-item');
            siblings.forEach(sibling => sibling.classList.remove('active'));
            item.classList.add('active');
            
            // Mettre à jour le fil d'Ariane
            this.updateBreadcrumb([continent]);
            
            // Charger et afficher les pays dans la colonne droite
            await this.loadContinentDetails(continent);
        });
        
        return item;
    }
    
    async loadContinentDetails(continent) {
        const rightColumn = this.grid.querySelector('.destinations-mega-right-column');
        
        // Afficher un loader
        rightColumn.innerHTML = '<div class="destinations-mega-loader-text">Chargement...</div>';
        
        try {
            // Charger les pays du continent
            const countries = await this.service.getCountriesByContinent(continent.id);
            
            if (countries.length === 0) {
                rightColumn.innerHTML = '<div class="destinations-mega-empty-text">Aucun pays disponible</div>';
                return;
            }
            
            // Créer le contenu de la colonne droite
            const content = document.createElement('div');
            content.className = 'destinations-mega-right-content';
            
            // Titre
            const title = document.createElement('h3');
            title.className = 'destinations-mega-right-title';
            title.textContent = continent.name;
            content.appendChild(title);
            
            // Liste des pays
            const countriesList = document.createElement('div');
            countriesList.className = 'destinations-mega-countries-grid';
            
            // Charger tous les pays avec leurs provinces directement
            for (const country of countries) {
                const countryItem = await this.createCountryItemWithChildren(country, continent);
                countriesList.appendChild(countryItem);
            }
            
            content.appendChild(countriesList);
            rightColumn.innerHTML = '';
            rightColumn.appendChild(content);
            
        } catch (error) {
            console.error(`Erreur chargement pays pour ${continent.name}:`, error);
            rightColumn.innerHTML = '<div class="destinations-mega-error-text">Erreur de chargement</div>';
        }
    }
    
    async createCountryItemWithChildren(country, continent) {
        const item = document.createElement('div');
        item.className = 'destinations-mega-country-item';
        item.dataset.countryId = country.id;
        
        const link = document.createElement('a');
        link.href = this.service.getDestinationUrl({...country, type: 'country'});
        link.className = 'destinations-mega-country-link';
        
        const imageUrl = country.image_url || country.image || this.getDefaultImage('country');
        const img = document.createElement('img');
        img.src = imageUrl;
        img.alt = country.name;
        img.className = 'destinations-mega-country-img';
        img.addEventListener('error', () => { img.src = this.getDefaultImage('country'); });
        
        const nameSpan = document.createElement('span');
        nameSpan.textContent = country.name;
        
        link.appendChild(img);
        link.appendChild(nameSpan);
        
        // Mettre à jour le fil d'Ariane au hover sur le pays
        link.addEventListener('mouseenter', () => {
            this.updateBreadcrumb([continent, country]);
        });
        
        link.addEventListener('mouseleave', () => {
            this.updateBreadcrumb([continent]);
        });
        
        item.appendChild(link);
        
        // Charger directement les provinces/villes
        try {
            const provinces = await this.service.getProvincesByCountry(country.id);
            
            if (provinces.length > 0) {
                const provincesList = document.createElement('div');
                provincesList.className = 'destinations-mega-provinces-list';
                
                provinces.forEach(province => {
                    const provinceItem = this.createProvinceItem(province, country, continent);
                    provincesList.appendChild(provinceItem);
                });
                
                item.appendChild(provincesList);
            }
        } catch (error) {
            console.error(`Erreur chargement provinces pour ${country.name}:`, error);
        }
        
        return item;
    }
    
    
    createProvinceItem(province, country, continent) {
        const item = document.createElement('div');
        item.className = 'destinations-mega-province-item';
        
        const link = document.createElement('a');
        link.href = this.service.getDestinationUrl({...province, type: 'province'});
        link.className = 'destinations-mega-province-link';
        link.textContent = province.name;
        
        // Mettre à jour le fil d'Ariane au hover sur la province/ville
        link.addEventListener('mouseenter', () => {
            this.updateBreadcrumb([continent, country, province]);
        });
        
        link.addEventListener('mouseleave', () => {
            this.updateBreadcrumb([continent, country]);
        });
        
        item.appendChild(link);
        return item;
    }
    
    
    
    getChildType(parentType) {
        const hierarchy = {
            'continent': 'country',
            'country': 'province',
            'province': 'region',
            'region': 'ville',
            'ville': 'secteur',
            'secteur': null
        };
        return hierarchy[parentType] || null;
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
        return defaults[type] || defaults.country;
    }
    
    getTypeName(type) {
        const names = {
            continent: 'Continent',
            country: 'Pays',
            province: 'Province',
            region: 'Région',
            ville: 'Ville',
            secteur: 'Secteur'
        };
        return names[type] || type;
    }
    
    getIconForType(type) {
        const icons = {
            continent: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>',
            country: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>',
            ville: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>'
        };
        return icons[type] || icons.ville;
    }
    
    showLoader() {
        this.loader.style.display = 'flex';
        this.grid.style.display = 'none';
        this.empty.style.display = 'none';
    }
    
    showGrid() {
        this.loader.style.display = 'none';
        this.grid.style.display = 'block';
        this.empty.style.display = 'none';
    }
    
    showEmpty() {
        this.loader.style.display = 'none';
        this.grid.style.display = 'none';
        this.empty.style.display = 'flex';
    }
    
    updateBreadcrumb(path) {
        if (!this.breadcrumb) return;
        
        this.currentBreadcrumb = path;
        
        if (path.length === 0) {
            this.breadcrumb.innerHTML = '<span class="search-bar-v2-destinations-link">Survolez pour explorer</span>';
            return;
        }
        
        const breadcrumbHTML = path.map((item, index) => {
            const isLast = index === path.length - 1;
            const separator = isLast ? '' : ' › ';
            return `<span class="search-bar-v2-destinations-link${isLast ? ' active' : ''}">${item.name}</span>${separator}`;
        }).join('');
        
        this.breadcrumb.innerHTML = breadcrumbHTML;
    }
    
    resetBreadcrumb() {
        if (!this.breadcrumb) return;
        this.breadcrumb.innerHTML = '<span class="search-bar-v2-destinations-link">Survolez pour explorer</span>';
    }
}

// Initialiser au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    console.log('🚀 DOMContentLoaded - Initialisation DestinationsMegaMenu');
    console.log('📍 window.megaMenuService disponible:', !!window.megaMenuService);
    
    // Attendre que le service soit chargé
    if (window.megaMenuService) {
        console.log('✅ Création de l\'instance DestinationsMegaMenu');
        window.destinationsMegaMenu = new DestinationsMegaMenu();
    } else {
        console.error('❌ MegaMenuService non disponible - Vérifier que mega-menu-service.js est chargé avant');
    }
});
