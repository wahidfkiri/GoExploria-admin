$v = view('cms::web.fallback.activities.restaurant.vertical-menu');
$rendered = $v->render();
preg_match_all('/data-section="([^"]+)"/', $rendered, $m);
echo 'data-section: ' . implode(', ', $m[1]) . PHP_EOL;

preg_match_all('/vertical-menu-v2-section-item/', $rendered, $cm);
echo 'vmenu-section-item count: ' . count($cm[0]) . PHP_EOL;

if (strpos($rendered, 'sectionsMenuData') !== false) {
    echo 'sectionsMenuData: PRESENT' . PHP_EOL;
} else {
    echo 'sectionsMenuData: MISSING' . PHP_EOL;
}
