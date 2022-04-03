<?php

declare(strict_types=1);

namespace App\Core\Factories;

use Psr\Http\Message\ResponseInterface;

interface HtmlResponseFactory
{
    public function create(string $html): ResponseInterface;
}
