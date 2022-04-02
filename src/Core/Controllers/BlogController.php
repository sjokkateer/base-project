<?php

declare(strict_types=1);

namespace App\Core\Controllers;

use App\Core\Adapters\Markdown;
use App\Core\BlogRepository;
use App\Core\Exceptions\BlogNotFoundException;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use function compact;
use function view;

class BlogController
{
    public function __construct(
        private BlogRepository $blogRepo,
        private Markdown $md,
    ) {
    }

    public function show(RequestInterface $request, array $args): ResponseInterface
    {
        $slug = $args['slug'];

        if (!$blog = $this->blogRepo->get($slug)) {
            throw new BlogNotFoundException($slug);
        }

        $blog->content = $this->md->convertToHtml($blog->content());

        return new HtmlResponse(view('blog', compact('blog')));
    }
}
