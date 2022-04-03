<?php

declare(strict_types=1);

namespace App\Core\Controllers;

use App\Core\Adapters\Markdown;
use App\Core\Factories\HtmlResponseFactory;
use App\Core\Services\AboutService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function compact;
use function view;

class AboutController
{
    public function __construct(
        private Markdown $md,
        private AboutService $service,
        private HtmlResponseFactory $responseFactory,
    ) {
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $intro = $this->md->convertToHtml($this->service->getIntro());
        $socials = $this->service->getSocials();

        return $this
            ->responseFactory
            ->create(view('about/index', compact('intro', 'socials')));
    }
}
