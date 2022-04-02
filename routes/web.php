<?php

declare(strict_types=1);

use App\Core\Controllers\AboutController;
use App\Core\Controllers\BlogController;
use App\Core\Controllers\IndexController;
use App\Core\Services\AboutService;

$router->get('/', [IndexController::class, 'show']);
$router->get('/blogs/{slug}', [BlogController::class, 'show']);

if (AboutService::hasAbout()) {
    $router->get('/about', AboutController::class);
}
