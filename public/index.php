<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\App;
use App\Core\ApplicationStrategy;
use League\Route\Router;

$container = include_once __DIR__ . '/../config/container.php';

/** @var League\Route\Strategy\ApplicationStrategy */
$strategy = (new ApplicationStrategy)->setContainer($container);

/** @var League\Route\Router */
$router   = (new Router)->setStrategy($strategy);

require_once __DIR__ . '/../routes/web.php';

(new App($router))->run();
