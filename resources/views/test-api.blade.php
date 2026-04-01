<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test API - GoExploria</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; }
        h1 { color: #2c3e50; margin-bottom: 30px; text-align: center; }
        .section { background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .section h2 { color: #3498db; margin-bottom: 15px; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .test-group { margin-bottom: 20px; }
        .test-group h3 { color: #555; margin-bottom: 10px; font-size: 18px; }
        .result { background: #ecf0f1; padding: 15px; border-radius: 5px; margin-top: 10px; max-height: 400px; overflow-y: auto; }
        .result pre { white-space: pre-wrap; word-wrap: break-word; font-size: 12px; }
        .btn { background: #3498db; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 10px; margin-bottom: 10px; }
        .btn:hover { background: #2980b9; }
        .btn-success { background: #27ae60; }
        .btn-success:hover { background: #229954; }
        .btn-warning { background: #f39c12; }
        .btn-warning:hover { background: #e67e22; }
        .btn-danger { background: #e74c3c; }
        .btn-danger:hover { background: #c0392b; }
        .status { display: inline-block; padding: 5px 10px; border-radius: 3px; font-size: 12px; margin-left: 10px; }
        .status.success { background: #27ae60; color: white; }
        .status.error { background: #e74c3c; color: white; }
        .status.loading { background: #f39c12; color: white; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; }
        .helper-test { background: #fff3cd; padding: 15px; border-radius: 5px; border-left: 4px solid #ffc107; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Test des APIs GoExploria</h1>

        <!-- DESTINATIONS -->
        <div class="section">
            <h2>🌍 API Destinations</h2>
            <div class="grid">
                <div class="test-group">
                    <h3>Continents</h3>
                    <button class="btn" onclick="testAPI('/api/v1/destinations/continents', 'continents-result')">Tester</button>
                    <div id="continents-result" class="result" style="display:none;"></div>
                </div>
                <div class="test-group">
                    <h3>Pays</h3>
                    <button class="btn" onclick="testAPI('/api/v1/destinations/countries', 'countries-result')">Tous les pays</button>
                    <button class="btn btn-success" onclick="testAPI('/api/v1/destinations/countries?continent_id=1', 'countries-result')">Par continent</button>
                    <div id="countries-result" class="result" style="display:none;"></div>
                </div>
                <div class="test-group">
                    <h3>Recherche</h3>
                    <button class="btn btn-warning" onclick="testAPI('/api/v1/destinations/search?query=Montreal', 'dest-search-result')">Rechercher "Montreal"</button>
                    <div id="dest-search-result" class="result" style="display:none;"></div>
                </div>
            </div>
        </div>

        <!-- CATÉGORIES -->
        <div class="section">
            <h2>🏷️ API Catégories</h2>
            <div class="grid">
                <div class="test-group">
                    <h3>Types de catégories</h3>
                    <button class="btn" onclick="testAPI('/api/v1/categories/types', 'cat-types-result')">Tester</button>
                    <div id="cat-types-result" class="result" style="display:none;"></div>
                </div>
                <div class="test-group">
                    <h3>Catégories</h3>
                    <button class="btn" onclick="testAPI('/api/v1/categories', 'categories-result')">Toutes</button>
                    <button class="btn btn-success" onclick="testAPI('/api/v1/categories/grouped', 'categories-result')">Groupées</button>
                    <div id="categories-result" class="result" style="display:none;"></div>
                </div>
                <div class="test-group">
                    <h3>Recherche</h3>
                    <button class="btn btn-warning" onclick="testAPI('/api/v1/categories/search?query=restaurant', 'cat-search-result')">Rechercher "restaurant"</button>
                    <div id="cat-search-result" class="result" style="display:none;"></div>
                </div>
            </div>
        </div>

        <!-- MENUS -->
        <div class="section">
            <h2>🍔 API Menus</h2>
            <div class="grid">
                <div class="test-group">
                    <h3>Menus racines</h3>
                    <button class="btn" onclick="testAPI('/api/v1/menus/roots', 'menus-roots-result')">Sans enfants</button>
                    <button class="btn btn-success" onclick="testAPI('/api/v1/menus/roots?with_children=true', 'menus-roots-result')">Avec enfants</button>
                    <div id="menus-roots-result" class="result" style="display:none;"></div>
                </div>
                <div class="test-group">
                    <h3>Arborescence</h3>
                    <button class="btn" onclick="testAPI('/api/v1/menus/tree', 'menus-tree-result')">Arbre complet</button>
                    <div id="menus-tree-result" class="result" style="display:none;"></div>
                </div>
                <div class="test-group">
                    <h3>Statistiques</h3>
                    <button class="btn btn-warning" onclick="testAPI('/api/v1/menus/stats', 'menus-stats-result')">Stats</button>
                    <div id="menus-stats-result" class="result" style="display:none;"></div>
                </div>
            </div>
        </div>

        <!-- MAP POINTS -->
        <div class="section">
            <h2>📍 API Map Points</h2>
            <div class="grid">
                <div class="test-group">
                    <h3>Points de carte</h3>
                    <button class="btn" onclick="testAPI('/api/v1/map-points', 'map-points-result')">Tous</button>
                    <button class="btn btn-success" onclick="testAPI('/api/v1/map-points/featured', 'map-points-result')">En vedette</button>
                    <div id="map-points-result" class="result" style="display:none;"></div>
                </div>
                <div class="test-group">
                    <h3>Catégories</h3>
                    <button class="btn" onclick="testAPI('/api/v1/map-points/categories', 'map-categories-result')">Liste catégories</button>
                    <div id="map-categories-result" class="result" style="display:none;"></div>
                </div>
                <div class="test-group">
                    <h3>Statistiques</h3>
                    <button class="btn btn-warning" onclick="testAPI('/api/v1/map-points/stats', 'map-stats-result')">Stats</button>
                    <div id="map-stats-result" class="result" style="display:none;"></div>
                </div>
            </div>
        </div>

        <!-- HELPERS TEST -->
        <div class="section">
            <h2>🔧 Test des Helpers PHP</h2>
            <div class="helper-test">
                <h3>Helpers disponibles:</h3>
                <ul style="margin-top: 10px; line-height: 1.8;">
                    <li><strong>Destinations:</strong> {{ count(get_defined_functions()['user']) > 0 ? '✅' : '❌' }} destinations_continents(), destinations_countries(), etc.</li>
                    <li><strong>Catégories:</strong> {{ count(get_defined_functions()['user']) > 0 ? '✅' : '❌' }} categories_types(), categories_all(), etc.</li>
                    <li><strong>Menus:</strong> {{ count(get_defined_functions()['user']) > 0 ? '✅' : '❌' }} menus_roots(), menus_tree(), etc.</li>
                    <li><strong>Map Points:</strong> {{ count(get_defined_functions()['user']) > 0 ? '✅' : '❌' }} map_points_all(), map_points_featured(), etc.</li>
                </ul>
                
                @php
                    // Test des helpers
                    $helperTests = [
                        'destinations_continents' => function_exists('destinations_continents'),
                        'categories_types' => function_exists('categories_types'),
                        'menus_roots' => function_exists('menus_roots'),
                        'map_points_all' => function_exists('map_points_all'),
                    ];
                @endphp
                
                <div style="margin-top: 15px; padding: 10px; background: white; border-radius: 5px;">
                    <h4>Vérification des fonctions:</h4>
                    <ul style="margin-top: 10px;">
                        @foreach($helperTests as $name => $exists)
                            <li>
                                <code>{{ $name }}()</code>: 
                                <span class="status {{ $exists ? 'success' : 'error' }}">
                                    {{ $exists ? '✅ Disponible' : '❌ Non trouvée' }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function testAPI(url, resultId) {
            const resultDiv = document.getElementById(resultId);
            resultDiv.style.display = 'block';
            resultDiv.innerHTML = '<span class="status loading">⏳ Chargement...</span>';
            
            try {
                const response = await fetch(url);
                const data = await response.json();
                
                if (response.ok) {
                    resultDiv.innerHTML = `
                        <span class="status success">✅ Succès (${response.status})</span>
                        <p><strong>URL:</strong> ${url}</p>
                        <p><strong>Résultats:</strong> ${data.count || 'N/A'} éléments</p>
                        <pre>${JSON.stringify(data, null, 2)}</pre>
                    `;
                } else {
                    resultDiv.innerHTML = `
                        <span class="status error">❌ Erreur (${response.status})</span>
                        <p><strong>URL:</strong> ${url}</p>
                        <pre>${JSON.stringify(data, null, 2)}</pre>
                    `;
                }
            } catch (error) {
                resultDiv.innerHTML = `
                    <span class="status error">❌ Erreur réseau</span>
                    <p><strong>URL:</strong> ${url}</p>
                    <p><strong>Message:</strong> ${error.message}</p>
                `;
            }
        }
    </script>
</body>
</html>
