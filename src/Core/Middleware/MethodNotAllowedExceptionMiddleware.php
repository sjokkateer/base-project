<?php

declare(strict_types=1);

namespace App\Core\Middleware;

use Laminas\Diactoros\Response\HtmlResponse;
use League\Route\Http\Exception\MethodNotAllowedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function view;

class MethodNotAllowedExceptionMiddleware implements MiddlewareInterface
{
    public function __construct(private MethodNotAllowedException $e)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $data = [
            'error' => $this->e,
            'request' => $request,
        ];

        return new HtmlResponse(view('exceptions/method-not-allowed', $data));
    }
}
