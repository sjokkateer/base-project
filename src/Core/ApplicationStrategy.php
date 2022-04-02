<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Middleware\ExceptionMiddleware;
use App\Core\Middleware\MethodNotAllowedExceptionMiddleware;
use App\Core\Middleware\NotFoundExceptionMiddleware;
use Closure;
use League\Route\ContainerAwareInterface;
use League\Route\ContainerAwareTrait;
use League\Route\Http\Exception\MethodNotAllowedException;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Route;
use League\Route\Strategy\AbstractStrategy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use ReflectionFunction;
use ReflectionNamedType;
use RuntimeException;

use function array_slice;

class ApplicationStrategy extends AbstractStrategy implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function getMethodNotAllowedDecorator(MethodNotAllowedException $exception): MiddlewareInterface
    {
        return new MethodNotAllowedExceptionMiddleware($exception);
    }

    public function getNotFoundDecorator(NotFoundException $exception): MiddlewareInterface
    {
        return new NotFoundExceptionMiddleware($exception);
    }

    /** Extends the original application strategy by providing auto wiring to method/function parameters */
    public function invokeRouteCallable(Route $route, ServerRequestInterface $request): ResponseInterface
    {
        $controller = $route->getCallable($this->getContainer());

        if (!$controller instanceof Closure) {
            $controller = Closure::fromCallable($controller);
        }

        $reflection = new ReflectionFunction($controller);
        $parameters = $reflection->getParameters();

        $additionalArgs = [];

        if ($this->getContainer() === null) {
            throw new RuntimeException('Trying to auto wire parameters without having set a container instance!');
        }

        foreach (array_slice($parameters, 2) as $additonalParameter) {
            $type = $additonalParameter->getType();

            if ($type instanceof ReflectionNamedType) {
                $additionalArgs[] = $this->getContainer()->get($type->getName());
            }
        }

        $response = $controller($request, $route->getVars(), ...$additionalArgs);

        return $this->decorateResponse($response);
    }

    public function getThrowableHandler(): MiddlewareInterface
    {
        return new ExceptionMiddleware();
    }
}
