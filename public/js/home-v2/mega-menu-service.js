/**
 * Service pour gérer le méga menu des destinations.
 * Charge les données depuis l'API et privilégie les URLs hiérarchiques.
 */
class MegaMenuService {
    constructor() {
        this.baseURL = '/api/v1/destinations';
        this.cache = new Map();
        this.cacheDuration = 10 * 60 * 1000;
    }

    isCacheValid(key) {
        if (!this.cache.has(key)) return false;
        const cached = this.cache.get(key);
        return (Date.now() - cached.timestamp) < this.cacheDuration;
    }

    setCache(key, data) {
        this.cache.set(key, { data, timestamp: Date.now() });
    }

    async fetchList(cacheKey, url, type) {
        if (this.isCacheValid(cacheKey)) return this.cache.get(cacheKey).data;

        try {
            const response = await fetch(url, { headers: { Accept: 'application/json' } });
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            const result = await response.json();
            if (result.success) {
                const data = Array.isArray(result.data)
                    ? result.data.map((item) => this.normalizeDestination(item, type))
                    : [];
                this.setCache(cacheKey, data);
                return data;
            }
        } catch (error) {
            console.error('Erreur lors du chargement des destinations:', error);
        }

        return [];
    }

    getContinents() {
        return this.fetchList('continents', `${this.baseURL}/continents`, 'continent');
    }

    getCountriesByContinent(continentId) {
        return this.fetchList(`countries_${continentId}`, `${this.baseURL}/continents/${continentId}/countries`, 'country');
    }

    getProvincesByCountry(countryId) {
        return this.fetchList(`provinces_${countryId}`, `${this.baseURL}/countries/${countryId}/provinces`, 'province');
    }

    getRegionsByProvince(provinceId) {
        return this.fetchList(`regions_${provinceId}`, `${this.baseURL}/provinces/${provinceId}/regions`, 'region');
    }

    getVillesByRegion(regionId) {
        return this.fetchList(`villes_${regionId}`, `${this.baseURL}/regions/${regionId}/villes`, 'ville');
    }

    getSecteursByVille(villeId) {
        return this.fetchList(`secteurs_${villeId}`, `${this.baseURL}/villes/${villeId}/secteurs`, 'secteur');
    }

    async searchDestinations(query) {
        if (!query || query.length < 2) return [];

        try {
            const response = await fetch(`${this.baseURL}/search?query=${encodeURIComponent(query)}`, {
                headers: { Accept: 'application/json' }
            });
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            const result = await response.json();
            if (!result.success) return [];

            const grouped = result.data || {};
            const map = {
                continents: 'continent',
                countries: 'country',
                provinces: 'province',
                regions: 'region',
                villes: 'ville',
                secteurs: 'secteur',
                etablissements: 'etablissement'
            };

            const flat = [];
            Object.entries(map).forEach(([groupKey, type]) => {
                const items = Array.isArray(grouped[groupKey]) ? grouped[groupKey] : [];
                items.forEach((item) => flat.push(this.normalizeDestination(item, type)));
            });

            return flat;
        } catch (error) {
            console.error('Erreur lors de la recherche:', error);
            return [];
        }
    }

    normalizeDestination(item, type) {
        const normalized = { ...item, type: item.type || type };
        normalized.slug = normalized.slug || this.slugify(normalized.name || normalized.code || '');
        normalized.url = this.getDestinationUrl(normalized);
        return normalized;
    }

    getDestinationUrl(destination) {
        if (!destination) return '#';
        if (destination.url) return destination.url;
        if (destination.path) return '/' + String(destination.path).replace(/^\/+/, '');

        const type = destination.type || 'continent';
        const slug = destination.slug || this.slugify(destination.name || destination.code || '');

        if (type === 'etablissement') {
            return `/company/${destination.id}/${slug || ('etablissement-' + destination.id)}`;
        }

        const legacy = {
            continent: 'continent',
            country: 'pays',
            province: 'province',
            region: 'region',
            ville: 'ville',
            secteur: 'secteur'
        };

        return `/destinations/${legacy[type] || type}/${slug}`;
    }

    slugify(value) {
        return String(value || '')
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    clearCache() {
        this.cache.clear();
    }
}

window.megaMenuService = new MegaMenuService();
