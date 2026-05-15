/**
 * Search Bar V2
 * - Source: API destinations
 * - Rules:
 *   1) keep only active destinations
 *   2) show image only for continent/country
 */
(function () {
    window.__GOEXPLORIA_USE_NEW_SEARCH_BAR = true;
})();

class SearchBarV2 {
    constructor() {
        this.searchInput = document.getElementById('searchBarInput');
        this.searchBarResults = document.getElementById('searchBarResults');
        this.searchBarResultsList = document.getElementById('searchBarResultsList');
        this.clearBtn = document.getElementById('searchBarClearBtn');

        this.currentIndex = -1;
        this.searchTimeout = null;
        this.minQueryLength = 2;
        this.endpoint = '/api/v1/destinations/search';

        this.typeOrder = ['continent', 'country', 'province', 'region', 'ville', 'etablissement', 'secteur'];
        this.typeLabel = {
            continent: 'Continent',
            country: 'Pays',
            province: 'Province',
            region: 'Region',
            ville: 'Ville',
            etablissement: 'Etablissement',
            secteur: 'Secteur'
        };

        this.init();
    }

    init() {
        if (!this.searchInput || !this.searchBarResults || !this.searchBarResultsList) return;

        this.searchInput.addEventListener('input', (e) => this.handleSearch(e.target.value));
        this.searchInput.addEventListener('focus', () => {
            if (this.searchInput.value.trim().length >= this.minQueryLength) this.showResults();
        });

        if (this.clearBtn) {
            this.clearBtn.addEventListener('click', () => this.clearSearch());
        }

        this.searchInput.addEventListener('keydown', (e) => this.handleKeyboard(e));

        document.addEventListener('click', (e) => {
            var searchBar = document.querySelector('.search-bar-v2-search');
            if (searchBar && !searchBar.contains(e.target)) this.hideResults();
        });
    }

    handleSearch(query) {
        var trimmed = (query || '').trim();

        if (this.clearBtn) {
            this.clearBtn.classList.toggle('visible', !!trimmed);
        }

        clearTimeout(this.searchTimeout);

        if (trimmed.length < this.minQueryLength) {
            this.hideResults();
            this.searchBarResultsList.innerHTML = '';
            return;
        }

        this.searchTimeout = setTimeout(() => this.performSearch(trimmed), 300);
    }

    async performSearch(query) {
        try {
            var url = this.endpoint + '?query=' + encodeURIComponent(query);
            var response = await fetch(url, { headers: { Accept: 'application/json' } });
            if (!response.ok) throw new Error('HTTP ' + response.status);
            var payload = await response.json();
            var flattened = this.flattenApiResults(payload && payload.data ? payload.data : {});
            this.displayResults(flattened, query);
        } catch (error) {
            this.showNoResults(query);
        }
    }

    flattenApiResults(data) {
        var mapping = {
            continents: 'continent',
            countries: 'country',
            provinces: 'province',
            regions: 'region',
            villes: 'ville',
            etablissements: 'etablissement',
            secteurs: 'secteur'
        };

        var results = [];

        Object.keys(mapping).forEach((groupKey) => {
            var type = mapping[groupKey];
            var items = Array.isArray(data[groupKey]) ? data[groupKey] : [];

            items.forEach((item) => {
                // Explicit safety: only active destinations
                if (item.is_active !== true) return;

                var showImage = (type === 'continent' || type === 'country');
                var computedName = item.name || '';
                if (type === 'etablissement' && item.lname) {
                    computedName = (computedName + ' ' + item.lname).trim();
                }

                var computedDescription = item.description || '';
                if (type === 'etablissement') {
                    computedDescription = item.ville || item.adresse || '';
                }

                results.push({
                    id: item.id,
                    type: type,
                    name: computedName,
                    slug: item.slug || '',
                    description: computedDescription,
                    showImage: showImage,
                    image: showImage ? this.normalizeImageUrl(item.image) : null
                });
            });
        });

        return results;
    }

    normalizeImageUrl(raw) {
        if (!raw) return null;
        var value = String(raw).trim();
        if (!value) return null;
        if (/^(https?:)?\/\//i.test(value)) return value;
        if (value.startsWith('/')) return value;
        return '/' + value.replace(/^\/+/, '');
    }

    displayResults(results, query) {
        this.searchBarResultsList.innerHTML = '';

        if (!results.length) {
            this.showNoResults(query);
            this.showResults();
            return;
        }

        var maxResults = 21;
        var displayed = results.slice(0, maxResults);

        displayed.forEach((dest, index) => {
            var li = document.createElement('li');
            li.className = 'search-bar-v2-result-item';
            li.dataset.index = String(index);

            var mediaHtml = '';
            if (dest.showImage && dest.image) {
                mediaHtml = '<div class="search-bar-v2-result-image"><img src="' + this.escapeHtml(dest.image) + '" alt="' + this.escapeHtml(dest.name) + '"></div>';
            } else {
                mediaHtml = '<div class="search-bar-v2-result-image search-bar-v2-result-image--icon"><i class="' + this.getIconClass(dest.type) + '"></i></div>';
            }

            li.innerHTML =
                mediaHtml +
                '<div class="search-bar-v2-result-content">' +
                    '<h5 class="search-bar-v2-result-name">' + this.highlightMatch(this.escapeHtml(dest.name), query) + '</h5>' +
                    '<div class="search-bar-v2-result-type">' + (this.typeLabel[dest.type] || dest.type) + '</div>' +
                '</div>' +
                '<span class="search-bar-v2-result-badge">' + (this.typeLabel[dest.type] || dest.type) + '</span>';

            li.addEventListener('click', () => this.selectDestination(dest));
            li.addEventListener('mouseenter', () => this.highlightItem(index));
            this.searchBarResultsList.appendChild(li);
        });

        this.currentIndex = -1;
        this.showResults();
    }

    showNoResults(query) {
        this.searchBarResultsList.innerHTML =
            '<div class="search-bar-v2-no-results">' +
                '<svg class="search-bar-v2-no-results-icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' +
                    '<circle cx="11" cy="11" r="8"></circle>' +
                    '<path d="m21 21-4.35-4.35"></path>' +
                '</svg>' +
                '<p class="search-bar-v2-no-results-text">Aucun resultat pour "' + this.escapeHtml(query) + '"</p>' +
                '<p class="search-bar-v2-no-results-suggestion">Essayez avec d autres mots-cles</p>' +
            '</div>';
    }

    getIconClass(type) {
        switch (type) {
            case 'continent': return 'fas fa-earth-americas';
            case 'country': return 'fas fa-flag';
            case 'province': return 'fas fa-map';
            case 'region': return 'fas fa-mountain';
            case 'ville': return 'fas fa-city';
            case 'etablissement': return 'fas fa-store';
            case 'secteur': return 'fas fa-location-dot';
            default: return 'fas fa-location-dot';
        }
    }

    getDestinationUrl(dest) {
        var slug = dest.slug || this.slugify(dest.name || '');
        switch (dest.type) {
            case 'continent': return '/destinations/continent/' + slug;
            case 'country': return '/destinations/pays/' + slug;
            case 'province': return '/destinations/province/' + slug;
            case 'region': return '/destinations/region/' + slug;
            case 'ville': return '/destinations/ville/' + slug;
            case 'etablissement': return '/company/' + dest.id + '/' + (slug || ('etablissement-' + dest.id));
            case 'secteur': return '/destinations/secteur/' + slug;
            default: return '#';
        }
    }

    slugify(value) {
        return String(value || '')
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    selectDestination(dest) {
        this.searchInput.value = dest.name || '';
        this.hideResults();

        var url = this.getDestinationUrl(dest);
        if (url && url !== '#') window.location.href = url;
    }

    highlightMatch(text, query) {
        var escapedQuery = this.escapeRegExp(query);
        var regex = new RegExp('(' + escapedQuery + ')', 'gi');
        return text.replace(regex, '<strong>$1</strong>');
    }

    escapeRegExp(value) {
        return String(value).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    escapeHtml(text) {
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    showResults() {
        this.searchBarResults.classList.add('visible');
    }

    hideResults() {
        this.searchBarResults.classList.remove('visible');
        this.currentIndex = -1;
    }

    clearSearch() {
        this.searchInput.value = '';
        if (this.clearBtn) this.clearBtn.classList.remove('visible');
        this.hideResults();
        this.searchInput.focus();
    }

    handleKeyboard(e) {
        var items = this.searchBarResultsList.querySelectorAll('.search-bar-v2-result-item');
        if (!items.length) return;

        switch (e.key) {
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
                if (this.currentIndex >= 0 && items[this.currentIndex]) items[this.currentIndex].click();
                break;
            case 'Escape':
                this.hideResults();
                break;
        }
    }

    highlightItem(index) {
        var items = this.searchBarResultsList.querySelectorAll('.search-bar-v2-result-item');
        items.forEach((item, i) => {
            item.classList.toggle('highlighted', i === index);
        });
        this.currentIndex = index;
    }

    scrollToItem(index) {
        var items = this.searchBarResultsList.querySelectorAll('.search-bar-v2-result-item');
        if (items[index]) items[index].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    new SearchBarV2();
});
