<?php
// Simple test - just read the blade file and check for patterns
$file = 'D:\My Project\GoExploria\GoExploria\packages\vendor\cms\src\Views\web\fallback\activities\restaurant\vertical-menu.blade.php';
$content = file_get_contents($file);

echo "=== Checking data-section attributes ===\n";
preg_match_all('/data-section="([^"]+)"/', $content, $matches);
echo "Found " . count($matches[1]) . " data-section attributes:\n";
foreach ($matches[1] as $i => $v) {
    echo "  " . ($i+1) . ". '" . $v . "'\n";
}

echo "\n=== Checking vertical-menu-v2-section-item class ===\n";
preg_match_all('/vertical-menu-v2-section-item/', $content, $cm);
echo "Found " . count($cm[0]) . " occurrences\n";

echo "\n=== Checking VerticalSectionsMegaMenu include ===\n";
if (strpos($content, 'VerticalSectionsMegaMenu') !== false) {
    echo "FOUND ✓\n";
} else {
    echo "NOT FOUND ✗\n";
}

echo "\n=== Checking sectionsMenuData !==\n";
if (strpos($content, "sectionsMenuData") !== false) {
    echo "FOUND ✓\n";
    // Extract sectionsMenuData to check keys
    preg_match("/sectionsMenuData\s*=\s*\{(.*?)\};/s", $content, $smd);
    if (isset($smd[1])) {
        preg_match_all("/'([^']+)'\s*:/", $smd[1], $keys);
        echo "Keys in sectionsMenuData:\n";
        foreach ($keys[1] as $k) {
            echo "  - '" . $k . "'\n";
        }
    }
} else {
    echo "NOT FOUND ✗\n";
}
