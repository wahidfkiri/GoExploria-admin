<?php
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['REQUEST_URI'] = '/travel-destination/country/canada/map-points';
$_SERVER['REQUEST_METHOD'] = 'GET';

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$req = Illuminate\Http\Request::create('/travel-destination/country/canada/map-points', 'GET');
$res = $app->handle($req);
$data = json_decode($res->getContent(), true);

echo 'API points: ' . count($data['data'] ?? []) . "\n";
foreach ($data['data'] as $p) {
    echo "  {$p['title']} cat={$p['category']} lat={$p['latitude']} lng={$p['longitude']}\n";
    // Check if lat is 0 or null
    if (!is_numeric($p['latitude']) || $p['latitude'] === 0.0) {
        echo "  ** BAD LAT! **\n";
    }
    if (!is_numeric($p['longitude']) || $p['longitude'] === 0.0) {
        echo "  ** BAD LNG! **\n";
    }
}
