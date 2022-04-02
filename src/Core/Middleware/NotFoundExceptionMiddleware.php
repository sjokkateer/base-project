<?php

namespace App\Core\Middleware;

use Laminas\Diactoros\Response\HtmlResponse;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NotFoundExceptionMiddleware implements MiddlewareInterface
{
    public function __construct(private NotFoundException $e)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $data = [
            'error' => $this->e,
            'request' => $request,
        ];

        return new HtmlResponse(view('exceptions/not-found', $data));
    }
}
