<?php

declare(strict_types=1);

namespace App\Core\Controllers;

use App\Core\Adapters\Markdown;
use App\Core\BlogRepository;
use App\Core\Exceptions\BlogNotFoundException;
use App\Core\Factories\HtmlResponseFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use function compact;
use function view;

class BlogController
{
    public function __construct(
        private BlogRepository $blogRepo,
        private Markdown $md,
        private HtmlResponseFactory $responseFactory,
    ) {
    }

    /** @param array<string> $args */
    public function show(RequestInterface $request, array $args): ResponseInterface
    {
        $slug = $args['slug'];
        $blog = $this->blogRepo->get($slug);

        if ($blog === null) {
            throw new BlogNotFoundException($slug);
        }

        $blog->content = $this->md->convertToHtml($blog->content());

        return $this
            ->responseFactory
            ->create(view('blog', compact('blog')));
    }
}
