/**
 * Service API pour la carte interactive
 * Gère les appels à l'API backend pour récupérer les points map
 */

class MapAPIService {
    constructor() {
        this.baseURL = '/api/v1/map-points';
        this.cache = new Map();
        this.cacheDuration = 5 * 60 * 1000; // 5 minutes
    }

    /**
     * Récupérer tous les points map
     */
    async getAllPoints(filters = {}) {
        const cacheKey = 'all_points_' + JSON.stringify(filters);
        
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const params = new URLSearchParams();
            
            if (filters.category) {
                params.append('category', filters.category);
            }
            
            if (filters.ville) {
                params.append('ville', filters.ville);
            }
            
            if (filters.featured) {
                params.append('featured', 'true');
            }
            
            // Toujours récupérer avec les relations (images, vidéos, détails)
            params.append('with_relations', 'true');
            
            const url = `${this.baseURL}?${params.toString()}`;
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            } else {
                throw new Error(result.message || 'Erreur lors de la récupération des points');
            }
        } catch (error) {
            console.error('Erreur API getAllPoints:', error);
            return [];
        }
    }

    /**
     * Récupérer les points dans une zone géographique (bounds)
     */
    async getPointsInBounds(bounds, category = null) {
        try {
            const params = new URLSearchParams({
                sw_lat: bounds.south,
                sw_lng: bounds.west,
                ne_lat: bounds.north,
                ne_lng: bounds.east
            });
            
            if (category) {
                params.append('category', category);
            }
            
            const url = `${this.baseURL}/bounds?${params.toString()}`;
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            return result.success ? result.data : [];
        } catch (error) {
            console.error('Erreur API getPointsInBounds:', error);
            return [];
        }
    }

    /**
     * Récupérer un point spécifique avec toutes ses données
     */
    async getPoint(id) {
        const cacheKey = `point_${id}`;
        
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const url = `${this.baseURL}/${id}?with_relations=true`;
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            } else {
                throw new Error(result.message || 'Point non trouvé');
            }
        } catch (error) {
            console.error('Erreur API getPoint:', error);
            return null;
        }
    }

    /**
     * Récupérer les points en vedette
     */
    async getFeaturedPoints(limit = 10) {
        const cacheKey = `featured_${limit}`;
        
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const url = `${this.baseURL}/featured?limit=${limit}&with_relations=true`;
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            }
            
            return [];
        } catch (error) {
            console.error('Erreur API getFeaturedPoints:', error);
            return [];
        }
    }

    /**
     * Récupérer les points par catégorie
     */
    async getPointsByCategory(category) {
        const cacheKey = `category_${category}`;
        
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const url = `${this.baseURL}/category/${category}?with_relations=true`;
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            }
            
            return [];
        } catch (error) {
            console.error('Erreur API getPointsByCategory:', error);
            return [];
        }
    }

    /**
     * Récupérer les points par ville
     */
    async getPointsByVille(ville) {
        try {
            const url = `${this.baseURL}/ville/${ville}?with_relations=true`;
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            return result.success ? result.data : [];
        } catch (error) {
            console.error('Erreur API getPointsByVille:', error);
            return [];
        }
    }

    /**
     * Récupérer les catégories disponibles
     */
    async getCategories() {
        const cacheKey = 'categories';
        
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const url = `${this.baseURL}/categories`;
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            }
            
            return [];
        } catch (error) {
            console.error('Erreur API getCategories:', error);
            return [];
        }
    }

    /**
     * Récupérer les villes disponibles (liste unique depuis les points)
     */
    async getVilles() {
        const cacheKey = 'villes';
        
        if (this.isCacheValid(cacheKey)) {
            return this.cache.get(cacheKey).data;
        }

        try {
            const url = `${this.baseURL}/villes`;
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            
            if (result.success) {
                this.setCache(cacheKey, result.data);
                return result.data;
            }
            
            return [];
        } catch (error) {
            console.error('Erreur API getVilles:', error);
            return [];
        }
    }

    /**
     * Rechercher des points
     */
    async searchPoints(query, category = null) {
        try {
            const params = new URLSearchParams({ query });
            
            if (category) {
                params.append('category', category);
            }
            
            const url = `${this.baseURL}/search?${params.toString()}`;
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            return result.success ? result.data : [];
        } catch (error) {
            console.error('Erreur API searchPoints:', error);
            return [];
        }
    }

    /**
     * Récupérer les points à proximité d'une coordonnée
     */
    async getNearbyPoints(latitude, longitude, radius = 5, limit = 10) {
        try {
            const params = new URLSearchParams({
                latitude,
                longitude,
                radius,
                limit
            });
            
            const url = `${this.baseURL}/nearby?${params.toString()}`;
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            return result.success ? result.data : [];
        } catch (error) {
            console.error('Erreur API getNearbyPoints:', error);
            return [];
        }
    }

    /**
     * Incrémenter les vues d'un point
     */
    async incrementView(id) {
        try {
            const url = `${this.baseURL}/${id}/view`;
            const response = await fetch(url, { method: 'POST' });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            return result.success;
        } catch (error) {
            console.error('Erreur API incrementView:', error);
            return false;
        }
    }

    /**
     * Vérifier si le cache est valide
     */
    isCacheValid(key) {
        if (!this.cache.has(key)) {
            return false;
        }
        
        const cached = this.cache.get(key);
        const now = Date.now();
        
        return (now - cached.timestamp) < this.cacheDuration;
    }

    /**
     * Mettre en cache des données
     */
    setCache(key, data) {
        this.cache.set(key, {
            data,
            timestamp: Date.now()
        });
    }

    /**
     * Vider le cache
     */
    clearCache() {
        this.cache.clear();
    }

    /**
     * Formater un point pour l'affichage sur la carte
     */
    formatPointForMap(point) {
        // Fonction helper pour formater l'URL de l'image
        const formatImageUrl = (url) => {
            if (!url) return null;
            // Si l'URL commence par http/https, la retourner telle quelle
            if (url.startsWith('http://') || url.startsWith('https://')) {
                return url;
            }
            // Si l'URL commence par /storage, la retourner telle quelle
            if (url.startsWith('/storage/')) {
                return url;
            }
            // Sinon, ajouter /storage/ au début
            return '/storage/' + url.replace(/^\/+/, '');
        };

        // Récupérer l'image principale
        let mainImage = null;
        if (point.images?.length > 0) {
            const mainImg = point.images.find(img => img.is_main) || point.images[0];
            mainImage = formatImageUrl(mainImg.url || mainImg.path);
        } else if (point.main_image) {
            mainImage = formatImageUrl(point.main_image);
        }

        // Récupérer la thumbnail vidéo
        let videoThumbnail = null;
        if (point.videos?.length > 0 && point.videos[0].youtube_id) {
            videoThumbnail = `https://img.youtube.com/vi/${point.videos[0].youtube_id}/mqdefault.jpg`;
        }

        return {
            id: point.id,
            name: point.title,
            category: point.category || 'other',
            ville: point.ville,
            lat: parseFloat(point.latitude),
            lng: parseFloat(point.longitude),
            description: point.description,
            address: point.adresse || '',
            phone: point.details?.phone || '',
            email: point.details?.email || '',
            website: point.details?.website || '',
            
            // Images
            mainImage: mainImage,
            images: point.images || [],
            
            // Vidéos
            videos: point.videos || [],
            mainVideo: point.videos?.[0]?.youtube_id || null,
            videoThumbnail: videoThumbnail,
            
            // Détails
            details: point.details || null,
            socialNetworks: {
                facebook: point.details?.facebook || null,
                instagram: point.details?.instagram || null,
                twitter: point.details?.twitter || null,
                linkedin: point.details?.linkedin || null,
                youtube: point.details?.youtube || null,
                tiktok: point.details?.tiktok || null,
                pinterest: point.details?.pinterest || null,
                snapchat: point.details?.snapchat || null,
                whatsapp: point.details?.whatsapp || null
            },
            
            // Métadonnées
            isFeatured: point.is_featured || false,
            views: point.views || 0
        };
    }
}

// Exporter une instance unique (singleton)
window.mapAPIService = new MapAPIService();
