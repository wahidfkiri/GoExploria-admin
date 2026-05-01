/**
 * Service pour gérer le mega menu des destinations
 * Charge les données depuis l'API Destinations
 */

class MegaMenuService {
    constructor() {
        this.baseURL = '/api/v1/destinations';
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
     * Récupérer tous les continents
     */
    async getContinents() {
        const cacheKey = 'continents';
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const response = await fetch(`${this.baseURL}/continents`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const result = await response.json();
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            }
            return [];
        } catch (error) {
            console.error('Erreur lors du chargement des continents:', error);
            return [];
        }
    }

    /**
     * Récupérer les pays d'un continent
     */
    async getCountriesByContinent(continentId) {
        const cacheKey = `countries_${continentId}`;
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const response = await fetch(`${this.baseURL}/continents/${continentId}/countries`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const result = await response.json();
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            }
            return [];
        } catch (error) {
            console.error('Erreur lors du chargement des pays:', error);
            return [];
        }
    }

    /**
     * Récupérer les provinces d'un pays
     */
    async getProvincesByCountry(countryId) {
        const cacheKey = `provinces_${countryId}`;
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const response = await fetch(`${this.baseURL}/countries/${countryId}/provinces`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const result = await response.json();
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            }
            return [];
        } catch (error) {
            console.error('Erreur lors du chargement des provinces:', error);
            return [];
        }
    }

    /**
     * Récupérer les régions d'une province
     */
    async getRegionsByProvince(provinceId) {
        const cacheKey = `regions_${provinceId}`;
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const response = await fetch(`${this.baseURL}/provinces/${provinceId}/regions`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const result = await response.json();
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            }
            return [];
        } catch (error) {
            console.error('Erreur lors du chargement des régions:', error);
            return [];
        }
    }

    /**
     * Récupérer les villes d'une région
     */
    async getVillesByRegion(regionId) {
        const cacheKey = `villes_${regionId}`;
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const response = await fetch(`${this.baseURL}/regions/${regionId}/villes`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const result = await response.json();
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            }
            return [];
        } catch (error) {
            console.error('Erreur lors du chargement des villes:', error);
            return [];
        }
    }

    /**
     * Rechercher des destinations
     */
    async searchDestinations(query) {
        if (!query || query.length < 2) return [];

        try {
            const response = await fetch(`${this.baseURL}/search?query=${encodeURIComponent(query)}`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const result = await response.json();
            if (result.success) {
                const grouped = result.data || {};
                const map = {
                    continents: 'continent',
                    countries: 'country',
                    provinces: 'province',
                    regions: 'region',
                    villes: 'ville',
                    secteurs: 'secteur'
                };

                const flat = [];
                Object.entries(map).forEach(([groupKey, type]) => {
                    const items = Array.isArray(grouped[groupKey]) ? grouped[groupKey] : [];
                    items.forEach((item) => flat.push({ ...item, type }));
                });

                return flat;
            }
            return [];
        } catch (error) {
            console.error('Erreur lors de la recherche:', error);
            return [];
        }
    }

    /**
     * Générer l'URL d'une destination
     */
    getDestinationUrl(destination) {
        const type = destination.type || 'continent';
        const slug = destination.slug || destination.name.toLowerCase().replace(/\s+/g, '-');
        
        switch(type) {
            case 'continent':
                return `/destinations/continent/${slug}`;
            case 'country':
                return `/destinations/pays/${slug}`;
            case 'province':
                return `/destinations/province/${slug}`;
            case 'region':
                return `/destinations/region/${slug}`;
            case 'ville':
                return `/destinations/ville/${slug}`;
            case 'secteur':
                return `/destinations/secteur/${slug}`;
            default:
                return `/destinations/${slug}`;
        }
    }

    /**
     * Vider le cache
     */
    clearCache() {
        this.cache.clear();
    }
}

// Exporter une instance unique (singleton)
window.megaMenuService = new MegaMenuService();
