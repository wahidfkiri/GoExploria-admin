/**
 * Mega Menu Destinations pour le Menu Vertical
 * Gère l'affichage des destinations avec hiérarchie complète
 */

class VerticalDestinationsMegaMenu {
    constructor() {
        this.megaMenu = document.getElementById('verticalDestinationsMega');
        this.trigger = document.querySelector('.vertical-menu-v2-destinations-trigger');
        this.closeBtn = document.getElementById('closeVerticalDestinationsMega');
        this.loader = document.getElementById('vDestinationsLoader');
        this.grid = document.getElementById('vDestinationsGrid');
        this.empty = document.getElementById('vDestinationsEmpty');
        this.service = window.megaMenuService; // Utiliser le service existant
        this.isOpen = false;
        this.isLoaded = false;
        this.hideTimeout = null;
        
        this.init();
    }
    
    init() {
        if (!this.megaMenu || !this.trigger) {
            console.error('Éléments du mega menu destinations non trouvés');
            return;
        }
        
        if (!this.service) {
            console.error('MegaMenuService non disponible');
            return;
        }
        
        // Événements sur le trigger
        this.trigger.addEventListener('mouseenter', () => {
            this.cancelHide();
            this.show();
        });
        
        this.trigger.addEventListener('mouseleave', () => {
            this.scheduleHide();
        });
        
        // Événements sur le mega menu
        this.megaMenu.addEventListener('mouseenter', () => {
            this.cancelHide();
        });
        
        this.megaMenu.addEventListener('mouseleave', () => {
            this.scheduleHide();
        });
        
        // Bouton de fermeture
        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', () => {
                this.hide();
            });
        }
    }
    
    async show() {
        this.cancelHide();
        
        if (this.isOpen) return;
        
        this.isOpen = true;
        this.megaMenu.classList.add('active');
        
        // Charger les destinations si pas encore chargées
        if (!this.isLoaded) {
            await this.loadDestinations();
        }
    }
    
    hide() {
        this.isOpen = false;
        this.megaMenu.classList.remove('active');
    }
    
    scheduleHide() {
        this.hideTimeout = setTimeout(() => {
            this.hide();
        }, 300);
    }
    
    cancelHide() {
        if (this.hideTimeout) {
            clearTimeout(this.hideTimeout);
            this.hideTimeout = null;
        }
    }
    
    async loadDestinations() {
        this.showLoader();
        
        try {
            // Charger UNIQUEMENT les continents (pas les pays)
            const continents = await this.service.getContinents();
            
            if (continents.length === 0) {
                this.showEmpty();
                return;
            }
            
            // Générer le HTML des continents SANS charger les pays
            this.renderContinents(continents);
            
            this.isLoaded = true;
            this.showGrid();
            
        } catch (error) {
            console.error('Erreur lors du chargement des destinations:', error);
            this.showEmpty();
        }
    }
    
    renderContinents(continents) {
        // Générer le HTML des continents SANS les pays (lazy loading)
        const html = continents.map(continent => 
            this.createContinentSection(continent, null)
        );
        
        this.grid.innerHTML = html.join('');
        
        // Ajouter les événements d'expansion avec lazy loading
        this.initSectionEvents();
    }
    
    createContinentSection(continent, countries) {
        const imageUrl = continent.image_url || continent.image || 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=400';
        
        // Si countries est null, c'est du lazy loading
        const isLazyLoad = countries === null;
        const countryCount = isLazyLoad ? '...' : countries.length;
        
        return `
            <div class="vmenu-dest-section" data-destination-id="${continent.id}" data-type="continent" data-loaded="${!isLazyLoad}">
                <div class="vmenu-dest-section-header">
                    <img src="${imageUrl}" alt="${continent.name}" class="vmenu-dest-section-image" onerror="this.src='https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=400'">
                    <div class="vmenu-dest-section-info">
                        <h4 class="vmenu-dest-section-name">
                            ${continent.name}
                        </h4>
                        <p class="vmenu-dest-section-count">
                            ${isLazyLoad ? 'Cliquez pour explorer' : `${countryCount} pays`}
                        </p>
                    </div>
                    <svg class="vmenu-dest-section-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
                <div class="vmenu-dest-section-content">
                    <div class="vmenu-dest-section-list">
                        ${isLazyLoad ? '<div class="vmenu-dest-section-loader"><div class="vmenu-destinations-spinner"></div></div>' : countries.map(country => this.createDestinationSection(country, 'country', null)).join('')}
                    </div>
                </div>
            </div>
        `;
    }
    
    createDestinationSection(destination, type, children) {
        const imageUrl = destination.image_url || destination.image || this.getDefaultImage(type);
        const url = this.service.getDestinationUrl({...destination, type});
        const typeName = this.getTypeName(type);
        const isLazyLoad = children === null;
        const childCount = isLazyLoad ? '...' : (children ? children.length : 0);
        const hasChildren = isLazyLoad || (children && children.length > 0);
        const childType = this.getChildType(type);
        const childTypeName = childType ? this.getTypeName(childType) + 's' : '';
        
        // Si pas d'enfants possibles, afficher comme item simple
        if (!hasChildren && !isLazyLoad) {
            return `
                <a href="${url}" class="vmenu-dest-item" data-destination-id="${destination.id}" data-type="${type}">
                    <img src="${imageUrl}" alt="${destination.name}" class="vmenu-dest-item-image" onerror="this.src='${this.getDefaultImage(type)}'">
                    <div class="vmenu-dest-item-info">
                        <h5 class="vmenu-dest-item-name">${destination.name}</h5>
                        <p class="vmenu-dest-item-type">${typeName}</p>
                    </div>
                </a>
            `;
        }
        
        // Sinon, afficher comme section expandable
        return `
            <div class="vmenu-dest-section vmenu-dest-subsection" data-destination-id="${destination.id}" data-type="${type}" data-loaded="${!isLazyLoad}">
                <div class="vmenu-dest-section-header">
                    <img src="${imageUrl}" alt="${destination.name}" class="vmenu-dest-section-image" onerror="this.src='${this.getDefaultImage(type)}'">
                    <div class="vmenu-dest-section-info">
                        <h4 class="vmenu-dest-section-name">
                            <a href="${url}" class="vmenu-dest-name-link">${destination.name}</a>
                        </h4>
                        <p class="vmenu-dest-section-count">
                            ${isLazyLoad ? 'Cliquez pour explorer' : (childCount > 0 ? `${childCount} ${childTypeName}` : typeName)}
                        </p>
                    </div>
                    ${hasChildren ? `<svg class="vmenu-dest-section-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>` : ''}
                </div>
                ${hasChildren ? `<div class="vmenu-dest-section-content">
                    <div class="vmenu-dest-section-list">
                        ${isLazyLoad ? '<div class="vmenu-dest-section-loader"><div class="vmenu-destinations-spinner"></div></div>' : children.map(child => this.createDestinationSection(child, childType, null)).join('')}
                    </div>
                </div>` : ''}
            </div>
        `;
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
    
    initSectionEvents() {
        const sections = this.grid.querySelectorAll('.vmenu-dest-section-header');
        
        sections.forEach(header => {
            header.addEventListener('click', async (e) => {
                // Ne pas empêcher la navigation si on clique sur le lien du nom
                if (e.target.closest('.vmenu-dest-name-link')) {
                    return;
                }
                
                e.preventDefault();
                const section = header.closest('.vmenu-dest-section');
                const destinationId = section.dataset.destinationId;
                const type = section.dataset.type;
                const isLoaded = section.dataset.loaded === 'true';
                
                // Si pas encore chargé, charger les enfants (LAZY LOADING)
                if (!isLoaded) {
                    await this.loadChildrenForDestination(section, destinationId, type);
                }
                
                // Toggle l'expansion
                section.classList.toggle('expanded');
            });
        });
    }
    
    async loadChildrenForDestination(section, destinationId, type) {
        try {
            let children = [];
            const childType = this.getChildType(type);
            
            if (!childType) {
                section.dataset.loaded = 'true';
                return;
            }
            
            // Charger les enfants selon le type de destination
            switch(type) {
                case 'continent':
                    children = await this.service.getCountriesByContinent(destinationId);
                    break;
                case 'country':
                    children = await this.service.getProvincesByCountry(destinationId);
                    break;
                case 'province':
                    children = await this.service.getRegionsByProvince(destinationId);
                    break;
                case 'region':
                    children = await this.service.getVillesByRegion(destinationId);
                    break;
                case 'ville':
                    // Pour les villes, on pourrait charger les secteurs si l'API le supporte
                    // Pour l'instant, on considère que les villes n'ont pas d'enfants
                    children = [];
                    break;
                default:
                    children = [];
            }
            
            // Mettre à jour le contenu
            const listContainer = section.querySelector('.vmenu-dest-section-list');
            const countElement = section.querySelector('.vmenu-dest-section-count');
            const childTypeName = this.getTypeName(childType) + 's';
            
            if (children.length > 0) {
                listContainer.innerHTML = children.map(child => 
                    this.createDestinationSection(child, childType, null)
                ).join('');
                countElement.textContent = `${children.length} ${childTypeName}`;
                
                // Réinitialiser les événements pour les nouvelles sections
                this.initSectionEvents();
            } else {
                listContainer.innerHTML = `<p style="padding: 20px; text-align: center; color: #6c757d;">Aucun ${childTypeName.toLowerCase()} disponible</p>`;
                countElement.textContent = `0 ${childTypeName}`;
            }
            
            // Marquer comme chargé
            section.dataset.loaded = 'true';
            
        } catch (error) {
            console.error(`Erreur chargement enfants pour ${type} ${destinationId}:`, error);
            const listContainer = section.querySelector('.vmenu-dest-section-list');
            listContainer.innerHTML = '<p style="padding: 20px; text-align: center; color: #dc3545;">Erreur de chargement</p>';
        }
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
}

// Initialiser quand le DOM est prêt
document.addEventListener('DOMContentLoaded', () => {
    if (window.megaMenuService) {
        window.verticalDestinationsMegaMenu = new VerticalDestinationsMegaMenu();
    } else {
        console.error('MegaMenuService non disponible pour le mega menu destinations vertical');
    }
});
