# API Map Points - Documentation

## 📋 Vue d'ensemble

L'API Map Points fournit un accès en **lecture seule** à tous les points de carte avec leurs images, vidéos et détails.

**Base URL:** `/api/v1/map-points`

**Rate Limiting:** 120 requêtes par minute

**Format de réponse:** JSON

---

## 📍 Endpoints disponibles

### 1. Liste des points

#### Récupérer tous les points
```http
GET /api/v1/map-points
```

**Paramètres de requête:**
- `category` (string, optionnel) - Filtrer par catégorie
- `featured` (boolean, optionnel) - Seulement les points en vedette
- `ville` (string, optionnel) - Filtrer par ville
- `with_relations` (boolean, optionnel) - Inclure images, vidéos, détails
- `sw_lat`, `sw_lng`, `ne_lat`, `ne_lng` (numeric, optionnel) - Zone géographique

**Exemples:**
- `/api/v1/map-points` - Tous les points
- `/api/v1/map-points?category=restaurant` - Points d'une catégorie
- `/api/v1/map-points?featured=true` - Points en vedette
- `/api/v1/map-points?ville=Montreal&with_relations=true` - Points d'une ville avec relations

**Exemple de réponse:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Restaurant Le Gourmet",
      "description": "Cuisine française raffinée",
      "category": "restaurant",
      "latitude": "45.5017",
      "longitude": "-73.5673",
      "ville": "Montreal",
      "is_featured": true,
      "views": 1250
    }
  ],
  "count": 1
}
```

---

### 2. Point spécifique

#### Récupérer un point par ID
```http
GET /api/v1/map-points/{id}
```

**Paramètres de requête:**
- `with_relations` (boolean, optionnel, défaut: true) - Inclure toutes les relations

**Exemple:**
```http
GET /api/v1/map-points/1?with_relations=true
```

**Réponse:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Restaurant Le Gourmet",
    "description": "Cuisine française raffinée",
    "category": "restaurant",
    "main_image": "images/restaurant.jpg",
    "latitude": "45.5017",
    "longitude": "-73.5673",
    "adresse": "123 Rue Saint-Denis",
    "ville": "Montreal",
    "code_postal": "H2X 3K8",
    "is_featured": true,
    "views": 1250,
    "images": [...],
    "videos": [...],
    "details": {...}
  }
}
```

---

### 3. Images d'un point

#### Récupérer toutes les images
```http
GET /api/v1/map-points/{id}/images
```

**Réponse:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "map_point_id": 1,
      "image": "images/restaurant-1.jpg",
      "thumbnail": "images/thumbs/restaurant-1.jpg",
      "caption": "Salle principale",
      "is_main": true,
      "sort_order": 1,
      "url": "http://example.com/storage/images/restaurant-1.jpg",
      "thumb_url": "http://example.com/storage/images/thumbs/restaurant-1.jpg"
    }
  ],
  "count": 1,
  "map_point_id": 1
}
```

---

### 4. Vidéos d'un point

#### Récupérer toutes les vidéos
```http
GET /api/v1/map-points/{id}/videos
```

**Réponse:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "map_point_id": 1,
      "title": "Visite du restaurant",
      "youtube_url": "https://youtube.com/watch?v=abc123",
      "youtube_id": "abc123",
      "sort_order": 1,
      "thumbnail": "https://img.youtube.com/vi/abc123/hqdefault.jpg",
      "embed_url": "https://www.youtube.com/embed/abc123"
    }
  ],
  "count": 1,
  "map_point_id": 1
}
```

---

### 5. Détails d'un point

#### Récupérer les détails complets
```http
GET /api/v1/map-points/{id}/details
```

**Réponse:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "map_point_id": 1,
    "long_description": "Description détaillée...",
    "phone": "+1 514-123-4567",
    "email": "contact@restaurant.com",
    "website": "https://restaurant.com",
    "horaires": {
      "lundi": "11h-22h",
      "mardi": "11h-22h"
    },
    "services": ["Terrasse", "Wifi", "Parking"],
    "tarifs": {"entree": "15-25$", "plat": "25-45$"},
    "rating": 4.5,
    "reviews_count": 128,
    "facebook": "https://facebook.com/restaurant",
    "instagram": "https://instagram.com/restaurant",
    "social_networks": {
      "facebook": {
        "label": "Facebook",
        "url": "https://facebook.com/restaurant",
        "icon": "fab fa-facebook"
      }
    }
  },
  "map_point_id": 1
}
```

---

### 6. Filtres géographiques

#### Points dans une zone (bounds)
```http
GET /api/v1/map-points/bounds?sw_lat=45.5&sw_lng=-73.6&ne_lat=45.6&ne_lng=-73.5
```

**Paramètres requis:**
- `sw_lat` (numeric) - Latitude sud-ouest
- `sw_lng` (numeric) - Longitude sud-ouest
- `ne_lat` (numeric) - Latitude nord-est
- `ne_lng` (numeric) - Longitude nord-est
- `category` (string, optionnel) - Filtrer par catégorie

#### Points à proximité
```http
GET /api/v1/map-points/nearby?latitude=45.5017&longitude=-73.5673&radius=5&limit=10
```

**Paramètres:**
- `latitude` (numeric, **requis**) - Latitude du centre
- `longitude` (numeric, **requis**) - Longitude du centre
- `radius` (numeric, optionnel, défaut: 5) - Rayon en km (max: 100)
- `limit` (integer, optionnel, défaut: 10) - Nombre de résultats (max: 50)

---

### 7. Filtres par catégorie et ville

#### Points par catégorie
```http
GET /api/v1/map-points/category/{category}
```

**Exemple:**
```http
GET /api/v1/map-points/category/restaurant?with_relations=true
```

#### Points par ville
```http
GET /api/v1/map-points/ville/{ville}
```

**Exemple:**
```http
GET /api/v1/map-points/ville/Montreal
```

#### Catégories disponibles
```http
GET /api/v1/map-points/categories
```

**Réponse:**
```json
{
  "success": true,
  "data": ["restaurant", "hotel", "attraction", "museum"],
  "count": 4
}
```

---

### 8. Recherche

#### Rechercher des points
```http
GET /api/v1/map-points/search?query={terme}&category={category}
```

**Paramètres:**
- `query` (string, **requis**, min: 2 caractères) - Terme de recherche
- `category` (string, optionnel) - Filtrer par catégorie

**Exemple:**
```http
GET /api/v1/map-points/search?query=italien&category=restaurant
```

---

### 9. Points en vedette

#### Récupérer les points en vedette
```http
GET /api/v1/map-points/featured?limit=10
```

**Paramètres:**
- `limit` (integer, optionnel, défaut: 10) - Nombre de points
- `with_relations` (boolean, optionnel) - Inclure les relations

---

### 10. Statistiques

#### Récupérer les statistiques
```http
GET /api/v1/map-points/stats
```

**Réponse:**
```json
{
  "success": true,
  "data": {
    "total_points": 1250,
    "featured_points": 45,
    "points_with_images": 980,
    "points_with_videos": 320,
    "points_with_details": 1100,
    "total_images": 4500,
    "total_videos": 850,
    "categories": ["restaurant", "hotel", "attraction"],
    "most_viewed": {...}
  }
}
```

---

### 11. Incrémenter les vues

#### Incrémenter le compteur de vues
```http
POST /api/v1/map-points/{id}/view
```

**Réponse:**
```json
{
  "success": true,
  "message": "Vue incrémentée"
}
```

---

## 🔧 Utilisation dans le code

### Via les fonctions globales

```php
// Récupérer tous les points
$points = map_points_all();
$pointsWithRelations = map_points_all([], true);

// Filtrer par catégorie
$restaurants = map_points_by_category('restaurant', true);

// Récupérer un point spécifique
$point = map_points_get(1, true);

// Points en vedette
$featured = map_points_featured(5, true);

// Images d'un point
$images = map_points_images(1);

// Vidéos d'un point
$videos = map_points_videos(1);

// Détails d'un point
$details = map_points_details(1);

// Recherche
$results = map_points_search('italien', 'restaurant');

// Points par ville
$montrealPoints = map_points_by_ville('Montreal');

// Points dans une zone
$bounds = map_points_in_bounds(
    ['lat' => 45.5, 'lng' => -73.6],
    ['lat' => 45.6, 'lng' => -73.5],
    'restaurant'
);

// Points à proximité
$nearby = map_points_nearby(45.5017, -73.5673, 5, 10);

// Catégories disponibles
$categories = map_points_categories();
```

---

### Dans les vues Blade

```blade
{{-- Afficher les points en vedette --}}
@foreach(map_points_featured(5, true) as $point)
    <div class="point-card">
        <h3>{{ $point->title }}</h3>
        <p>{{ $point->description }}</p>
        
        @if($point->images->isNotEmpty())
            <img src="{{ $point->images->first()->url }}" alt="{{ $point->title }}">
        @endif
        
        @if($point->videos->isNotEmpty())
            <iframe src="{{ $point->videos->first()->embed_url }}"></iframe>
        @endif
    </div>
@endforeach

{{-- Afficher les détails d'un point --}}
@php
    $point = map_points_get(1, true);
    $details = $point->details;
@endphp

@if($details)
    <div class="point-details">
        <h2>{{ $point->title }}</h2>
        <p>{{ $details->long_description }}</p>
        
        <div class="contact">
            <p>📞 {{ $details->phone }}</p>
            <p>📧 {{ $details->email }}</p>
            <p>🌐 <a href="{{ $details->website }}">{{ $details->website }}</a></p>
        </div>
        
        <div class="social">
            @foreach($details->social_networks as $network)
                <a href="{{ $network['url'] }}" target="_blank">
                    <i class="{{ $network['icon'] }}"></i> {{ $network['label'] }}
                </a>
            @endforeach
        </div>
        
        <div class="gallery">
            @foreach(map_points_images($point->id) as $image)
                <img src="{{ $image->url }}" alt="{{ $image->caption }}">
            @endforeach
        </div>
    </div>
@endif
```

---

### Via JavaScript

```javascript
// Récupérer tous les points
fetch('/api/v1/map-points')
    .then(res => res.json())
    .then(data => {
        console.log(data.data); // Liste des points
    });

// Récupérer un point avec toutes ses relations
fetch('/api/v1/map-points/1?with_relations=true')
    .then(res => res.json())
    .then(data => {
        const point = data.data;
        console.log(point.images, point.videos, point.details);
    });

// Points dans une zone (pour une carte interactive)
const bounds = {
    sw_lat: 45.5,
    sw_lng: -73.6,
    ne_lat: 45.6,
    ne_lng: -73.5
};

fetch(`/api/v1/map-points/bounds?sw_lat=${bounds.sw_lat}&sw_lng=${bounds.sw_lng}&ne_lat=${bounds.ne_lat}&ne_lng=${bounds.ne_lng}`)
    .then(res => res.json())
    .then(data => {
        data.data.forEach(point => {
            addMarkerToMap(point.latitude, point.longitude, point.title);
        });
    });

// Points à proximité
fetch('/api/v1/map-points/nearby?latitude=45.5017&longitude=-73.5673&radius=5')
    .then(res => res.json())
    .then(data => {
        console.log(`${data.count} points trouvés dans un rayon de ${data.radius_km} km`);
    });

// Incrémenter les vues
fetch('/api/v1/map-points/1/view', { method: 'POST' })
    .then(res => res.json())
    .then(data => console.log(data.message));
```

---

## 🗺️ Exemple: Carte interactive

```javascript
// Initialiser une carte Leaflet avec les points
let map = L.map('map').setView([45.5017, -73.5673], 13);

// Charger les points dans la zone visible
map.on('moveend', function() {
    const bounds = map.getBounds();
    const sw = bounds.getSouthWest();
    const ne = bounds.getNorthEast();
    
    fetch(`/api/v1/map-points/bounds?sw_lat=${sw.lat}&sw_lng=${sw.lng}&ne_lat=${ne.lat}&ne_lng=${ne.lng}`)
        .then(res => res.json())
        .then(data => {
            data.data.forEach(point => {
                L.marker([point.latitude, point.longitude])
                    .bindPopup(`
                        <h3>${point.title}</h3>
                        <p>${point.description}</p>
                        <a href="/points/${point.id}">Voir détails</a>
                    `)
                    .addTo(map);
            });
        });
});
```

---

## ⚡ Performance et Cache

- **Mise en cache:** 1 heure (les points changent plus souvent que les destinations)
- **Optimisation:** Utiliser `with_relations=true` uniquement si nécessaire
- **Rate limiting:** 120 requêtes/minute

---

## 🔒 Sécurité

- ✅ **Lecture seule** - Pas de création/modification
- ✅ **Validation stricte** - Tous les paramètres validés
- ✅ **Throttling** - Protection contre les abus
- ✅ **Données actives uniquement** - Filtre `is_active=true`

---

## 📞 Support

Pour toute question, contactez l'équipe de développement.
