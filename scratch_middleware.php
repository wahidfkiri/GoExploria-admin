<?php
define('LARAVEL_START', microtime(true));
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
// In Laravel 11, the kernel is created inside Application. Let's get the middleware list.
$router = $app->make('router');
$route = $router->getRoutes()->getByAction('App\Http\Controllers\DevisController@show');
if ($route) {
    echo "DEVIS GET ROUTE MIDDLEWARES:\n";
    print_r($route->gatherMiddleware());
} else {
    echo "Route not found by action. Let's try matching path:\n";
    $route = $router->getRoutes()->match(Illuminate\Http\Request::create('/devis', 'GET'));
    if ($route) {
        echo "DEVIS GET ROUTE MIDDLEWARES (by path):\n";
        print_r($route->gatherMiddleware());
    } else {
        echo "Route not found by path '/devis'.\n";
    }
}
