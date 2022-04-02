<?php

declare(strict_types=1);

namespace App\Core\Controllers;

use App\Core\BlogRepositoryInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function compact;
use function view;

class IndexController
{
    public function __construct(
        private BlogRepositoryInterface $blogRepo,
    ) {
    }

    public function show(ServerRequestInterface $request): ResponseInterface
    {
        $blogs = $this->blogRepo->all();

        return new HtmlResponse(view('home', compact('blogs')));
    }
}
