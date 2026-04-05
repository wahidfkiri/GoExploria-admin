// resources/js/services/MapApiService.js

class MapApiService {
    constructor() {
        this.baseUrl = '/api/map';
        this.cache = new Map();
        this.cacheTimeout = 5 * 60 * 1000; // 5 minutes
    }

    /**
     * Récupère tous les points avec filtres
     */
    async getPoints(filters = {}) {
        const cacheKey = `points_${JSON.stringify(filters)}`;
        const cached = this.getFromCache(cacheKey);
        if (cached) return cached;

        try {
            const params = new URLSearchParams();
            Object.keys(filters).forEach(key => {
                if (filters[key] && filters[key] !== 'all') {
                    params.append(key, filters[key]);
                }
            });

            const response = await axios.get(`${this.baseUrl}/points?${params.toString()}`);
            
            if (response.data.success) {
                this.setToCache(cacheKey, response.data);
                return response.data;
            }
            throw new Error(response.data.message || 'Erreur lors du chargement');
        } catch (error) {
            console.error('Erreur API getPoints:', error);
            throw error;
        }
    }

    /**
     * Récupère un point spécifique
     */
    async getPoint(id) {
        const cacheKey = `point_${id}`;
        const cached = this.getFromCache(cacheKey);
        if (cached) return cached;

        try {
            const response = await axios.get(`${this.baseUrl}/points/${id}`);
            
            if (response.data.success) {
                this.setToCache(cacheKey, response.data);
                return response.data;
            }
            throw new Error(response.data.message || 'Point non trouvé');
        } catch (error) {
            console.error(`Erreur API getPoint ${id}:`, error);
            throw error;
        }
    }

    /**
     * Récupère les points par catégorie
     */
    async getPointsByCategory(category, page = 1, perPage = 20) {
        const cacheKey = `category_${category}_${page}`;
        const cached = this.getFromCache(cacheKey);
        if (cached) return cached;

        try {
            const response = await axios.get(`${this.baseUrl}/points/category/${category}`, {
                params: { page, per_page: perPage }
            });
            
            if (response.data.success) {
                this.setToCache(cacheKey, response.data);
                return response.data;
            }
            throw new Error(response.data.message || 'Erreur lors du chargement');
        } catch (error) {
            console.error(`Erreur API getPointsByCategory ${category}:`, error);
            throw error;
        }
    }

    /**
     * Récupère les points à proximité
     */
    async getNearbyPoints(lat, lng, radius = 10) {
        try {
            const response = await axios.get(`${this.baseUrl}/points/nearby`, {
                params: { lat, lng, radius }
            });
            
            if (response.data.success) {
                return response.data;
            }
            throw new Error(response.data.message || 'Erreur lors de la recherche');
        } catch (error) {
            console.error('Erreur API getNearbyPoints:', error);
            throw error;
        }
    }

    /**
     * Récupère les points en vedette
     */
    async getFeaturedPoints() {
        const cacheKey = 'featured_points';
        const cached = this.getFromCache(cacheKey);
        if (cached) return cached;

        try {
            const response = await axios.get(`${this.baseUrl}/featured`);
            
            if (response.data.success) {
                this.setToCache(cacheKey, response.data);
                return response.data;
            }
            throw new Error(response.data.message || 'Erreur lors du chargement');
        } catch (error) {
            console.error('Erreur API getFeaturedPoints:', error);
            throw error;
        }
    }

    /**
     * Récupère les statistiques
     */
    async getStats() {
        const cacheKey = 'stats';
        const cached = this.getFromCache(cacheKey);
        if (cached) return cached;

        try {
            const response = await axios.get(`${this.baseUrl}/stats`);
            
            if (response.data.success) {
                this.setToCache(cacheKey, response.data);
                return response.data;
            }
            throw new Error(response.data.message || 'Erreur lors du chargement');
        } catch (error) {
            console.error('Erreur API getStats:', error);
            throw error;
        }
    }

    // Gestion du cache
    getFromCache(key) {
        const cached = this.cache.get(key);
        if (cached && Date.now() - cached.timestamp < this.cacheTimeout) {
            return cached.data;
        }
        return null;
    }

    setToCache(key, data) {
        this.cache.set(key, {
            data: data,
            timestamp: Date.now()
        });
    }

    clearCache() {
        this.cache.clear();
    }
}

export default new MapApiService();