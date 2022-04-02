<?php

declare(strict_types=1);

namespace App\Core\Middleware;

use App\Core\Exceptions\BlogNotFoundException;
use Exception;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function array_key_exists;
use function view;

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
            $template = 'exceptions/default';

            if (array_key_exists($e::class, self::EXCEPTION_HANDLERS)) {
                $template = self::EXCEPTION_HANDLERS[$e::class];
            }

            $data = [
                'error' => $e,
                'request' => $request,
            ];

            return new HtmlResponse(view($template, $data));
        }
    }
}
