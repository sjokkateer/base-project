<?php

declare(strict_types=1);

namespace App\Core;

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Router;

class App
{
    public function __construct(private Router $router)
    {
    }

    public function run(): void
    {
        $request = ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );

        $response = $this->router->dispatch($request);

        (new SapiEmitter())->emit($response);
    }
}
