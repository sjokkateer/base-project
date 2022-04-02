<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\App;
use App\Core\ApplicationStrategy;
use App\Core\Helpers\ConfigFiles;
use League\Route\Router;

$container = include_once ConfigFiles::getContainerFile();

/** @var League\Route\Strategy\ApplicationStrategy */
$strategy = (new ApplicationStrategy())->setContainer($container);

/** @var League\Route\Router */
$router = (new Router())->setStrategy($strategy);

require_once __DIR__ . '/../routes/web.php';

(new App($router))->run();
