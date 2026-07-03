<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

try {
    echo "=== Test 1: CMS restaurant vertical-menu ===\n";
    $html = view('cms::web.fallback.activities.restaurant.vertical-menu')->render();
    preg_match_all('/data-section="([^"]+)"/', $html, $matches);
    echo "data-section values: " . implode(', ', $matches[1]) . "\n\n";
    
    // Check if VerticalSectionsMegaMenu is included
    if (strpos($html, 'verticalSectionsMega') !== false) {
        echo "✓ verticalSectionsMega FOUND in rendered output\n";
    } else {
        echo "✗ verticalSectionsMega NOT FOUND in rendered output\n";
    }
    
    if (strpos($html, 'sectionsMenuData') !== false) {
        echo "✓ sectionsMenuData FOUND in rendered output\n";
    } else {
        echo "✗ sectionsMenuData NOT FOUND in rendered output\n";
    }
    
    if (strpos($html, "data-section=\"next-level\"") !== false) {
        echo "✓ data-section=\"next-level\" FOUND\n";
    } else {
        echo "✗ data-section=\"next-level\" NOT FOUND\n";
    }
    
    if (strpos($html, "data-section=\"voyages-forfaits\"") !== false) {
        echo "✓ data-section=\"voyages-forfaits\" FOUND\n";
    } else {
        echo "✗ data-section=\"voyages-forfaits\" NOT FOUND\n";
    }
    
    // Check vertical-menu-v2-section-item class
    preg_match_all('/class="[^"]*vertical-menu-v2-section-item[^"]*"/', $html, $classMatches);
    echo "\nvertical-menu-v2-section-item count: " . count($classMatches[0]) . "\n";
    
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
