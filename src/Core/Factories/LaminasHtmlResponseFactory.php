<?php

declare(strict_types=1);

namespace App\Core\Factories;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;

class LaminasHtmlResponseFactory implements HtmlResponseFactory
{
    public function create(string $html): ResponseInterface
    {
        return new HtmlResponse($html);
    }
}
