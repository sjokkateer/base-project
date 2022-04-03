<?php

declare(strict_types=1);

namespace App\Core\Controllers;

use App\Core\Adapters\Markdown;
use App\Core\BlogRepository;
use App\Core\Exceptions\BlogNotFoundException;
use App\Core\Factories\HtmlResponseFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

use function array_key_exists;
use function compact;
use function sprintf;
use function view;

class BlogController
{
    public const SLUG_KEY = 'slug';

    public function __construct(
        private BlogRepository $blogRepo,
        private Markdown $md,
        private HtmlResponseFactory $responseFactory,
    ) {
    }

    /** @param array<string> $args */
    public function show(RequestInterface $request, array $args): ResponseInterface
    {
        $this->ensureSlugKeyExists($args);

        $slug = $args[self::SLUG_KEY];
        $blog = $this->blogRepo->get($slug);

        if ($blog === null) {
            throw new BlogNotFoundException($slug);
        }

        $blog->content = $this->md->convertToHtml($blog->content());

        return $this
            ->responseFactory
            ->create(view('blog', compact('blog')));
    }

    /** @param array<string> $args */
    private function ensureSlugKeyExists(array $args): void
    {
        if (!array_key_exists(self::SLUG_KEY, $args)) {
            throw new RuntimeException(
                sprintf(
                    "\$args contained no slug key '%s', please review your route definition",
                    self::SLUG_KEY
                )
            );
        }
    }
}
