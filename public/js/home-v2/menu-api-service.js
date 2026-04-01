/**
 * Service pour gérer l'API des menus
 * Charge les menus depuis l'API avec mise en cache
 */

class MenuApiService {
    constructor() {
        this.baseURL = '/api/v1/menus';
        this.cache = new Map();
        this.cacheDuration = 10 * 60 * 1000; // 10 minutes
    }

    /**
     * Vérifier si le cache est valide
     */
    isCacheValid(key) {
        if (!this.cache.has(key)) return false;
        const cached = this.cache.get(key);
        return (Date.now() - cached.timestamp) < this.cacheDuration;
    }

    /**
     * Mettre en cache
     */
    setCache(key, data) {
        this.cache.set(key, {
            data: data,
            timestamp: Date.now()
        });
    }

    /**
     * Récupérer tous les menus racines avec leurs enfants
     */
    async getRootMenus(withChildren = true) {
        const cacheKey = `roots_${withChildren}`;
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const url = `${this.baseURL}/roots?with_children=${withChildren ? '1' : '0'}`;
            const response = await fetch(url);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const result = await response.json();
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            }
            return [];
        } catch (error) {
            console.error('Erreur lors du chargement des menus racines:', error);
            return [];
        }
    }

    /**
     * Récupérer l'arborescence complète des menus
     */
    async getMenuTree(menuType = null) {
        const cacheKey = `tree_${menuType || 'all'}`;
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const url = menuType 
                ? `${this.baseURL}/tree?menu_type=${encodeURIComponent(menuType)}`
                : `${this.baseURL}/tree`;
            const response = await fetch(url);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const result = await response.json();
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            }
            return [];
        } catch (error) {
            console.error('Erreur lors du chargement de l\'arborescence des menus:', error);
            return [];
        }
    }

    /**
     * Récupérer les menus par type
     */
    async getMenusByType(type) {
        const cacheKey = `by_type_${type}`;
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const response = await fetch(`${this.baseURL}/by-type/${encodeURIComponent(type)}`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const result = await response.json();
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            }
            return [];
        } catch (error) {
            console.error('Erreur lors du chargement des menus par type:', error);
            return [];
        }
    }

    /**
     * Récupérer un menu spécifique
     */
    async getMenu(identifier, withChildren = true) {
        const cacheKey = `menu_${identifier}_${withChildren}`;
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const response = await fetch(`${this.baseURL}/${identifier}?with_children=${withChildren ? '1' : '0'}`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const result = await response.json();
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            }
            return null;
        } catch (error) {
            console.error('Erreur lors du chargement du menu:', error);
            return null;
        }
    }

    /**
     * Récupérer les enfants d'un menu
     */
    async getChildren(parentId) {
        const cacheKey = `children_${parentId}`;
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const response = await fetch(`${this.baseURL}/${parentId}/children`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const result = await response.json();
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            }
            return [];
        } catch (error) {
            console.error('Erreur lors du chargement des sous-menus:', error);
            return [];
        }
    }

    /**
     * Générer l'URL d'un menu
     */
    getMenuUrl(menu) {
        // Si l'URL existe et n'est pas null
        if (menu.url && menu.url !== 'null') {
            return menu.url;
        }
        
        // Si le menu a une route
        if (menu.route) {
            return menu.route;
        }
        
        // Sinon utiliser le slug comme ancre
        if (menu.slug) {
            return `#${menu.slug}`;
        }
        
        return '#';
    }

    /**
     * Vider le cache
     */
    clearCache() {
        this.cache.clear();
    }
}

// Exporter une instance unique (singleton)
window.menuApiService = new MenuApiService();
