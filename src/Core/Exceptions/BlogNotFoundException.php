<?php

namespace App\Core\Exceptions;

class BlogNotFoundException extends \Exception
{
    public function __construct(private string $slug)
    {
        parent::__construct("No blog matching '$slug' found");
    }

    public function slug(): string
    {
        return $this->slug;
    }
}
