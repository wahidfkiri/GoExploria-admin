# API Destinations - Documentation

## 📋 Vue d'ensemble

L'API Destinations fournit un accès en **lecture seule** à toutes les données géographiques de la plateforme (continents, pays, provinces, régions, villes, secteurs).

**Base URL:** `/api/v1/destinations`

**Rate Limiting:** 120 requêtes par minute

**Format de réponse:** JSON

---

## 🌍 Endpoints disponibles

### 1. Continents

#### Récupérer tous les continents
```http
GET /api/v1/destinations/continents
```

**Paramètres de requête:**
- `with_relations` (boolean, optionnel) - Inclure les pays associés

**Exemple de réponse:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Amérique du Nord",
      "code": "NA",
      "population": 579000000,
      "area": 24709000.00,
      "countries_count": 23,
      "is_active": true
    }
  ],
  "count": 7
}
```

#### Récupérer un continent spécifique
```http
GET /api/v1/destinations/continents/{id_ou_code}
```

**Exemples:**
- `/api/v1/destinations/continents/1`
- `/api/v1/destinations/continents/NA`

---

### 2. Pays (Countries)

#### Récupérer tous les pays
```http
GET /api/v1/destinations/countries
```

**Paramètres de requête:**
- `continent_id` (integer, optionnel) - Filtrer par continent
- `with_relations` (boolean, optionnel) - Inclure les relations

**Exemples:**
- `/api/v1/destinations/countries` - Tous les pays
- `/api/v1/destinations/countries?continent_id=1` - Pays d'un continent
- `/api/v1/destinations/countries?with_relations=true` - Avec provinces

#### Récupérer un pays spécifique
```http
GET /api/v1/destinations/countries/{id_code_ou_iso2}
```

**Exemples:**
- `/api/v1/destinations/countries/1`
- `/api/v1/destinations/countries/CA`
- `/api/v1/destinations/countries/US`

---

### 3. Provinces

#### Récupérer toutes les provinces
```http
GET /api/v1/destinations/provinces
```

**Paramètres de requête:**
- `country_id` (integer, optionnel) - Filtrer par pays
- `with_relations` (boolean, optionnel) - Inclure les relations

**Exemples:**
- `/api/v1/destinations/provinces?country_id=1` - Provinces du Canada

#### Récupérer une province spécifique
```http
GET /api/v1/destinations/provinces/{id_ou_code}
```

**Exemples:**
- `/api/v1/destinations/provinces/QC`
- `/api/v1/destinations/provinces/ON`

---

### 4. Régions

#### Récupérer toutes les régions
```http
GET /api/v1/destinations/regions
```

**Paramètres de requête:**
- `province_id` (integer, optionnel) - Filtrer par province
- `with_relations` (boolean, optionnel) - Inclure les villes

**Exemples:**
- `/api/v1/destinations/regions?province_id=1` - Régions du Québec

#### Récupérer une région spécifique
```http
GET /api/v1/destinations/regions/{id_ou_code}
```

---

### 5. Villes

#### Récupérer toutes les villes
```http
GET /api/v1/destinations/villes
```

**Paramètres de requête:**
- `region_id` (integer, optionnel) - Filtrer par région
- `with_relations` (boolean, optionnel) - Inclure toutes les relations

**Exemples:**
- `/api/v1/destinations/villes?region_id=6` - Villes de Montréal

#### Récupérer une ville spécifique
```http
GET /api/v1/destinations/villes/{id_ou_code}
```

---

### 6. Secteurs

#### Récupérer tous les secteurs
```http
GET /api/v1/destinations/secteurs
```

**Paramètres de requête:**
- `region_id` (integer, optionnel) - Filtrer par région
- `with_relations` (boolean, optionnel) - Inclure les villes

#### Récupérer un secteur spécifique
```http
GET /api/v1/destinations/secteurs/{id_ou_code}
```

---

### 7. Recherche

#### Rechercher des destinations
```http
GET /api/v1/destinations/search?query={terme}&type={type}
```

**Paramètres de requête:**
- `query` (string, **requis**, min: 2 caractères) - Terme de recherche
- `type` (string, optionnel) - Type de destination: `continent`, `country`, `province`, `region`, `ville`, `secteur`

**Exemple:**
```http
GET /api/v1/destinations/search?query=Montreal&type=ville
```

**Réponse:**
```json
{
  "success": true,
  "data": {
    "villes": [
      {
        "id": 1,
        "name": "Montréal",
        "population": 1762949,
        "latitude": "45.5017",
        "longitude": "-73.5673"
      }
    ]
  },
  "query": "Montreal"
}
```

---

### 8. Hiérarchie

#### Récupérer la hiérarchie complète d'une destination
```http
GET /api/v1/destinations/hierarchy/{type}/{id_ou_code}
```

**Types valides:** `ville`, `secteur`, `region`, `province`, `country`

**Exemple:**
```http
GET /api/v1/destinations/hierarchy/ville/1
```

**Réponse:**
```json
{
  "success": true,
  "data": {
    "ville": { "id": 1, "name": "Montréal" },
    "secteur": { "id": 5, "name": "Ville-Marie" },
    "region": { "id": 6, "name": "Montréal" },
    "province": { "id": 1, "name": "Québec", "code": "QC" },
    "country": { "id": 1, "name": "Canada", "code": "CA" },
    "continent": { "id": 1, "name": "Amérique du Nord", "code": "NA" }
  }
}
```

---

## 🔧 Utilisation dans le code

### Via le Helper (recommandé)

```php
// Dans un contrôleur ou une vue Blade
use App\Helpers\DestinationHelper;

// Récupérer tous les continents
$continents = DestinationHelper::continents();

// Récupérer un pays par code
$canada = DestinationHelper::country('CA', true); // avec relations

// Rechercher des villes
$results = DestinationHelper::search('Montreal', 'ville');

// Obtenir la hiérarchie
$hierarchy = DestinationHelper::hierarchy('ville', 1);

// Formater un nom complet
$fullName = DestinationHelper::formatFullName($ville, 'ville');
// Résultat: "Montréal, QC, Canada"

// Générer un breadcrumb
$breadcrumb = DestinationHelper::breadcrumb($ville, 'ville');
```

### Via les fonctions globales

```php
// Dans n'importe quel fichier PHP ou Blade
$continents = destinations_continents();
$canada = destinations_country('CA');
$villes = destinations_villes(6); // Villes de la région 6
$hierarchy = destinations_hierarchy('ville', 1);
$breadcrumb = destinations_breadcrumb($ville, 'ville');
```

### Dans les vues Blade

```blade
{{-- Liste des continents --}}
@foreach(destinations_continents() as $continent)
    <div>{{ $continent->name }}</div>
@endforeach

{{-- Afficher un pays --}}
@php
    $canada = destinations_country('CA', true);
@endphp
<h1>{{ $canada->name }}</h1>
<p>Population: {{ number_format($canada->population) }}</p>

{{-- Breadcrumb --}}
@php
    $breadcrumb = destinations_breadcrumb($ville, 'ville');
@endphp
<nav>
    @foreach($breadcrumb as $item)
        <a href="/destinations/{{ $item['type'] }}/{{ $item['id'] }}">
            {{ $item['name'] }}
        </a>
        @if(!$loop->last) > @endif
    @endforeach
</nav>
```

### Via JavaScript (fetch API)

```javascript
// Récupérer tous les pays
fetch('/api/v1/destinations/countries')
    .then(response => response.json())
    .then(data => {
        console.log(data.data); // Liste des pays
    });

// Rechercher des villes
fetch('/api/v1/destinations/search?query=Montreal&type=ville')
    .then(response => response.json())
    .then(data => {
        console.log(data.data.villes);
    });

// Récupérer la hiérarchie
fetch('/api/v1/destinations/hierarchy/ville/1')
    .then(response => response.json())
    .then(data => {
        console.log(data.data); // Hiérarchie complète
    });
```

---

## 🚀 Exemples d'utilisation

### Créer un sélecteur de pays en cascade

```blade
<select id="continent" onchange="loadCountries(this.value)">
    <option value="">Sélectionner un continent</option>
    @foreach(destinations_continents() as $continent)
        <option value="{{ $continent->id }}">{{ $continent->name }}</option>
    @endforeach
</select>

<select id="country">
    <option value="">Sélectionner un pays</option>
</select>

<script>
function loadCountries(continentId) {
    fetch(`/api/v1/destinations/countries?continent_id=${continentId}`)
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById('country');
            select.innerHTML = '<option value="">Sélectionner un pays</option>';
            data.data.forEach(country => {
                select.innerHTML += `<option value="${country.id}">${country.name}</option>`;
            });
        });
}
</script>
```

### Afficher une carte avec marqueurs

```blade
@php
    $villes = destinations_villes(6, true); // Villes de Montréal avec relations
@endphp

<div id="map"></div>

<script>
const villes = @json($villes);
const markers = villes.filter(v => v.latitude && v.longitude).map(ville => ({
    lat: parseFloat(ville.latitude),
    lng: parseFloat(ville.longitude),
    title: ville.name,
    population: ville.population
}));

// Initialiser la carte avec les marqueurs
initMap(markers);
</script>
```

---

## ⚡ Performance et Cache

- **Mise en cache automatique:** Toutes les données sont mises en cache pendant 24 heures
- **Optimisation des requêtes:** Utilisation de `with_relations=true` uniquement si nécessaire
- **Rate limiting:** 120 requêtes/minute pour éviter les abus

---

## 🔒 Sécurité

- ✅ **Lecture seule:** Aucune modification possible via l'API
- ✅ **Validation des entrées:** Tous les paramètres sont validés
- ✅ **Throttling:** Protection contre les abus
- ✅ **Données actives uniquement:** Seules les destinations `is_active=true` sont retournées

---

## 📞 Support

Pour toute question ou problème, contactez l'équipe de développement.
