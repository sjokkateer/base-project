<?php

declare(strict_types=1);

use App\Core\Controllers\AboutController;
use App\Core\Controllers\BlogController;
use App\Core\Controllers\IndexController;

$router->get('/', [IndexController::class, 'show']);
$router->get('/blogs/{slug}', [BlogController::class, 'show']);

if (AboutController::hasAbout()) {
    $router->get('/about', AboutController::class);
}
