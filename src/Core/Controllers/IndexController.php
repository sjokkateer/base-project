<?php

declare(strict_types=1);

namespace App\Core\Controllers;

use App\Core\Factories\HtmlResponseFactory;
use App\Core\Repositories\BlogRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function compact;
use function view;

class IndexController
{
    public function __construct(
        private BlogRepository $blogRepo,
        private HtmlResponseFactory $responseFactory,
    ) {
    }

    public function show(ServerRequestInterface $request): ResponseInterface
    {
        $blogs = $this->blogRepo->all();

        return $this
            ->responseFactory
            ->create(view('home', compact('blogs')));
    }
}
