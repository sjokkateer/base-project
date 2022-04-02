<?php

declare(strict_types=1);

namespace App\Core\Adapters;

use Dice\Dice;
use Exception;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

use function sprintf;

class DiceAdapter implements ContainerInterface
{
    public function __construct(private Dice $container)
    {
        $this->container = $this->containerFromRequiredRules();
    }

    private function containerFromRequiredRules(): Dice
    {
        $rules = [
            '*' => [
                'substitutions' => [
                    ContainerInterface::class => $this,
                ],
            ],
        ];

        return $this->container->addRules($rules);
    }

    public function get(string $id): mixed
    {
        if (!$this->has($id)) {
            throw new class ($id) extends Exception implements NotFoundExceptionInterface
            {
                public function __construct(string $id)
                {
                    parent::__construct(
                        sprintf(
                            "Could not resolve dependency with id '%s' from the container",
                            $id
                        )
                    );
                }
            };
        }

        return $this->container->create($id);
    }

    public function has(string $id): bool
    {
        try {
            $this->container->create($id);
        } catch (ReflectionException $e) {
            return false;
        }

        return true;
    }
}
