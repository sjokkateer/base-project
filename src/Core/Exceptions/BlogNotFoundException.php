<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

use Exception;

use function sprintf;

class BlogNotFoundException extends Exception
{
    public function __construct(private string $slug)
    {
        parent::__construct(sprintf("No blog matching '%s' found", $slug));
    }

    public function slug(): string
    {
        return $this->slug;
    }
}
