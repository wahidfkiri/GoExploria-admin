# API Catégories & Menus - Documentation

## 📋 Vue d'ensemble

L'API Catégories & Menus fournit un accès en **lecture seule** à toutes les catégories (restaurants, hôtels, etc.) et menus hiérarchiques de la plateforme.

**Base URL:** `/api/v1`

**Rate Limiting:** 120 requêtes par minute

**Format de réponse:** JSON

---

## 🏷️ API Catégories

### Types de Catégories

#### Récupérer tous les types de catégories
```http
GET /api/v1/categories/types
```

**Paramètres de requête:**
- `with_categories` (boolean, optionnel) - Inclure les catégories associées

**Exemple de réponse:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Restaurants",
      "slug": "restaurants",
      "is_active": true
    },
    {
      "id": 2,
      "name": "Hôtels",
      "slug": "hotels",
      "is_active": true
    }
  ],
  "count": 2
}
```

#### Récupérer un type de catégorie spécifique
```http
GET /api/v1/categories/types/{id_ou_slug}
```

**Exemples:**
- `/api/v1/categories/types/1`
- `/api/v1/categories/types/restaurants`

---

### Catégories

#### Récupérer toutes les catégories
```http
GET /api/v1/categories
```

**Paramètres de requête:**
- `type_id` (integer, optionnel) - Filtrer par type de catégorie
- `with_relations` (boolean, optionnel) - Inclure les relations (type, activités)

**Exemples:**
- `/api/v1/categories` - Toutes les catégories
- `/api/v1/categories?type_id=1` - Catégories d'un type spécifique
- `/api/v1/categories?with_relations=true` - Avec relations

#### Récupérer une catégorie spécifique
```http
GET /api/v1/categories/{id_ou_slug}
```

**Exemples:**
- `/api/v1/categories/1`
- `/api/v1/categories/restaurant-gastronomique`

#### Rechercher des catégories
```http
GET /api/v1/categories/search?query={terme}&type_id={type_id}
```

**Paramètres de requête:**
- `query` (string, **requis**, min: 2 caractères) - Terme de recherche
- `type_id` (integer, optionnel) - Filtrer par type

**Exemple:**
```http
GET /api/v1/categories/search?query=italien&type_id=1
```

#### Récupérer les catégories par type (slug)
```http
GET /api/v1/categories/by-type/{typeSlug}
```

**Exemple:**
```http
GET /api/v1/categories/by-type/restaurants
```

#### Récupérer les catégories populaires
```http
GET /api/v1/categories/popular?limit={limit}
```

**Paramètres de requête:**
- `limit` (integer, optionnel, défaut: 10) - Nombre de catégories à retourner

**Exemple:**
```http
GET /api/v1/categories/popular?limit=5
```

#### Récupérer les catégories groupées par type
```http
GET /api/v1/categories/grouped
```

**Réponse:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Restaurants",
      "slug": "restaurants",
      "categories": [
        {
          "id": 1,
          "name": "Italien",
          "slug": "italien"
        },
        {
          "id": 2,
          "name": "Français",
          "slug": "francais"
        }
      ]
    }
  ],
  "count": 1
}
```

#### Récupérer les statistiques des catégories
```http
GET /api/v1/categories/stats
```

---

## 🍔 API Menus

### Menus Racines et Arborescence

#### Récupérer tous les menus racines
```http
GET /api/v1/menus/roots
```

**Paramètres de requête:**
- `with_children` (boolean, optionnel) - Inclure les sous-menus

**Exemple:**
```http
GET /api/v1/menus/roots?with_children=true
```

#### Récupérer l'arborescence complète
```http
GET /api/v1/menus/tree
```

**Paramètres de requête:**
- `menu_type` (string, optionnel) - Filtrer par type de menu

**Exemple de réponse:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Accueil",
      "slug": "accueil",
      "type": "custom",
      "order": 1,
      "active_children": [
        {
          "id": 2,
          "title": "À propos",
          "slug": "a-propos",
          "parent_id": 1,
          "order": 1
        }
      ]
    }
  ],
  "count": 1
}
```

#### Construire un menu HTML
```http
GET /api/v1/menus/html?max_depth={depth}
```

**Paramètres de requête:**
- `max_depth` (integer, optionnel, défaut: 2, max: 5) - Profondeur maximale

**Réponse:**
```json
{
  "success": true,
  "html": "<ul class=\"menu-level-0\">...</ul>",
  "max_depth": 2
}
```

---

### Menu Spécifique

#### Récupérer un menu
```http
GET /api/v1/menus/{id_ou_slug}
```

**Paramètres de requête:**
- `with_children` (boolean, optionnel) - Inclure les sous-menus
- `with_relations` (boolean, optionnel) - Inclure les relations (catégorie, activité, parent)

**Exemples:**
- `/api/v1/menus/1`
- `/api/v1/menus/accueil?with_children=true`

#### Récupérer le fil d'Ariane (breadcrumb)
```http
GET /api/v1/menus/{id_ou_slug}/breadcrumb
```

**Exemple de réponse:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Accueil",
      "url": "/",
      "slug": "accueil"
    },
    {
      "id": 2,
      "title": "À propos",
      "url": "/a-propos",
      "slug": "a-propos"
    }
  ]
}
```

#### Récupérer les sous-menus
```http
GET /api/v1/menus/{parentId}/children
```

**Paramètres de requête:**
- `recursive` (boolean, optionnel) - Inclure tous les niveaux de sous-menus

---

### Filtres et Recherche

#### Rechercher des menus
```http
GET /api/v1/menus/search?query={terme}
```

**Paramètres de requête:**
- `query` (string, **requis**, min: 2 caractères) - Terme de recherche

#### Récupérer les menus par type
```http
GET /api/v1/menus/by-type/{type}
```

**Types valides:** `custom`, `category`, `activity`

**Paramètres de requête:**
- `with_children` (boolean, optionnel) - Inclure les sous-menus

**Exemple:**
```http
GET /api/v1/menus/by-type/category?with_children=true
```

#### Récupérer les menus par catégorie
```http
GET /api/v1/menus/by-category/{categoryId}
```

#### Récupérer les menus par activité
```http
GET /api/v1/menus/by-activity/{activityId}
```

#### Récupérer les menus avec pages
```http
GET /api/v1/menus/with-pages
```

#### Récupérer les statistiques des menus
```http
GET /api/v1/menus/stats
```

---

## 🔧 Utilisation dans le code

### Via les fonctions globales (recommandé)

#### **Catégories:**

```php
// Récupérer tous les types de catégories
$types = categories_types();
$typesWithCategories = categories_types(true);

// Récupérer un type spécifique
$restaurantType = categories_type('restaurants', true);

// Récupérer toutes les catégories
$allCategories = categories_all();
$restaurantCategories = categories_all(1); // Par type_id

// Récupérer une catégorie
$category = categories_get('italien', true);

// Rechercher
$results = categories_search('pizza', 1);

// Catégories par type
$restaurants = categories_by_type('restaurants');

// Catégories populaires
$popular = categories_popular(5);

// Catégories groupées
$grouped = categories_grouped();
```

#### **Menus:**

```php
// Récupérer les menus racines
$rootMenus = menus_roots();
$rootMenusWithChildren = menus_roots(true);

// Arborescence complète
$tree = menus_tree();
$headerTree = menus_tree('header');

// Récupérer un menu
$menu = menus_get('accueil', true, true);

// Menus par type
$customMenus = menus_by_type('custom', true);

// Sous-menus
$children = menus_children(1);
$childrenRecursive = menus_children(1, true);

// Breadcrumb
$breadcrumb = menus_breadcrumb(5);

// Construire HTML
$html = menus_build_html($rootMenus, 3);

// Menus avec pages
$menusWithPages = menus_with_pages();
```

---

### Dans les vues Blade

#### **Afficher les types de catégories:**

```blade
<select name="category_type">
    @foreach(categories_types() as $type)
        <option value="{{ $type->id }}">{{ $type->name }}</option>
    @endforeach
</select>
```

#### **Afficher les catégories groupées:**

```blade
@foreach(categories_grouped() as $type)
    <h3>{{ $type->name }}</h3>
    <ul>
        @foreach($type->categories as $category)
            <li>
                <a href="/categories/{{ $category->slug }}">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endforeach
```

#### **Afficher un menu de navigation:**

```blade
@php
    $menus = menus_roots(true);
@endphp

<nav>
    <ul>
        @foreach($menus as $menu)
            <li>
                <a href="{{ $menu->final_url }}">
                    @if($menu->icon)
                        <i class="{{ $menu->icon }}"></i>
                    @endif
                    {{ $menu->final_title }}
                </a>
                
                @if($menu->activeChildren->isNotEmpty())
                    <ul>
                        @foreach($menu->activeChildren as $child)
                            <li>
                                <a href="{{ $child->final_url }}">
                                    {{ $child->final_title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
```

#### **Afficher un breadcrumb:**

```blade
@php
    $breadcrumb = menus_breadcrumb($currentMenuId);
@endphp

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach($breadcrumb as $item)
            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                @if($loop->last)
                    {{ $item['title'] }}
                @else
                    <a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
```

---

### Via JavaScript (fetch API)

#### **Récupérer les catégories:**

```javascript
// Récupérer toutes les catégories
fetch('/api/v1/categories')
    .then(res => res.json())
    .then(data => {
        console.log(data.data); // Liste des catégories
    });

// Rechercher des catégories
fetch('/api/v1/categories/search?query=pizza')
    .then(res => res.json())
    .then(data => {
        console.log(data.data);
    });

// Catégories groupées
fetch('/api/v1/categories/grouped')
    .then(res => res.json())
    .then(data => {
        data.data.forEach(type => {
            console.log(type.name, type.categories);
        });
    });
```

#### **Récupérer les menus:**

```javascript
// Arborescence complète
fetch('/api/v1/menus/tree')
    .then(res => res.json())
    .then(data => {
        buildMenu(data.data);
    });

// Menu HTML prêt à l'emploi
fetch('/api/v1/menus/html?max_depth=3')
    .then(res => res.json())
    .then(data => {
        document.getElementById('nav').innerHTML = data.html;
    });

// Breadcrumb
fetch('/api/v1/menus/5/breadcrumb')
    .then(res => res.json())
    .then(data => {
        buildBreadcrumb(data.data);
    });
```

---

## 🚀 Exemples d'utilisation

### Créer un sélecteur de catégories en cascade

```blade
<select id="categoryType" onchange="loadCategories(this.value)">
    <option value="">Sélectionner un type</option>
    @foreach(categories_types() as $type)
        <option value="{{ $type->id }}">{{ $type->name }}</option>
    @endforeach
</select>

<select id="category">
    <option value="">Sélectionner une catégorie</option>
</select>

<script>
function loadCategories(typeId) {
    fetch(`/api/v1/categories?type_id=${typeId}`)
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById('category');
            select.innerHTML = '<option value="">Sélectionner une catégorie</option>';
            data.data.forEach(cat => {
                select.innerHTML += `<option value="${cat.id}">${cat.name}</option>`;
            });
        });
}
</script>
```

### Afficher un mega menu dynamique

```blade
@php
    $menuTree = menus_tree('header');
@endphp

<div class="mega-menu">
    @foreach($menuTree as $menu)
        <div class="menu-item">
            <a href="{{ $menu->final_url }}">{{ $menu->final_title }}</a>
            
            @if($menu->activeChildren->isNotEmpty())
                <div class="submenu">
                    @foreach($menu->activeChildren as $child)
                        <a href="{{ $child->final_url }}">
                            {{ $child->final_title }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>
```

---

## ⚡ Performance et Cache

- **Mise en cache automatique:** Toutes les données sont mises en cache pendant 24 heures
- **Optimisation des requêtes:** Utilisation de `with_relations` uniquement si nécessaire
- **Rate limiting:** 120 requêtes/minute

---

## 🔒 Sécurité

- ✅ **Lecture seule:** Aucune modification possible via l'API
- ✅ **Validation des entrées:** Tous les paramètres sont validés
- ✅ **Throttling:** Protection contre les abus
- ✅ **Données actives uniquement:** Seules les données `is_active=true` sont retournées

---

## 📞 Support

Pour toute question ou problème, contactez l'équipe de développement.
