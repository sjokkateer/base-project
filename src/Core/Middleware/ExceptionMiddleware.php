<?php

namespace App\Core\Middleware;

use App\Core\Exceptions\BlogNotFoundException;
use Exception;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ExceptionMiddleware implements MiddlewareInterface
{
    private const EXCEPTION_HANDLERS = [
        BlogNotFoundException::class => 'blogs/not-found',
    ];

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Exception $e) {
            $template = self::EXCEPTION_HANDLERS[$e::class] ?? 'exceptions/default';

            $data = [
                'error' => $e,
                'request' => $request,
            ];

            return new HtmlResponse(view($template, $data));
        }
    }
}
