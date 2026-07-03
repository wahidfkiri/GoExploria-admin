<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$app->register(\Vendor\HomeV2\HomeV2ServiceProvider::class);

try {
    $html = view('cms::web.fallback.activities.restaurant.vertical-menu')->render();
    
    $escaped = htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
    
    // Check for data-section
    preg_match_all('/data-section="([^"]+)"/', $html, $matches);
    if (!empty($matches[1])) {
        echo "data-section attributes found: " . implode(', ', $matches[1]) . "\n";
    } else {
        echo "NO data-section attributes found!\n";
    }
    
    // Check for vmenu class
    preg_match_all('/vertical-menu-v2-section-item/', $html, $cm);
    echo "vertical-menu-v2-section-item count: " . count($cm[0]) . "\n";
    
    // Check if sectionsMenuData is present
    if (strpos($html, 'sectionsMenuData') !== false) {
        echo "sectionsMenuData IS present\n";
    } else {
        echo "sectionsMenuData is MISSING!\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
