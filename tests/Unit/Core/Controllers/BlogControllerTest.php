<?php

declare(strict_types=1);

namespace App\Core\Controllers;

use App\Core\Adapters\Markdown;
use App\Core\Exceptions\BlogNotFoundException;
use App\Core\Factories\HtmlResponseFactory;
use App\Core\Models\Blog;
use App\Core\Repositories\BlogRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

final class BlogControllerTest extends TestCase
{
    private const ANY_SLUG_VALUE = 'some-slug';
    private const SUCCESS = 200;

    /** @var BlogRepository&MockObject */
    private BlogRepository $repo;

    /** @var Markdown&MockObject */
    private Markdown $md;

    /** @var HtmlResponseFactory&MockObject */
    private HtmlResponseFactory $responseFactory;
    private RequestInterface $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repo = static::createMock(BlogRepository::class);
        $this->md = static::createMock(Markdown::class);
        $this->responseFactory = static::createMock(HtmlResponseFactory::class);
        $this->request = static::createMock(RequestInterface::class);
    }

    public function testShowGivenArgsWithoutSlugKeyExpectedRuntimeExceptionThrown(): void
    {
        static::expectException(RuntimeException::class);

        $controller = new BlogController(
            $this->repo,
            $this->md,
            $this->responseFactory
        );

        $args = [];

        $controller->show($this->request, $args);
    }

    public function testShowGivenNonExistingSlugExpectedBlogNotFoundExceptionThrown(): void
    {
        static::expectException(BlogNotFoundException::class);

        $controller = new BlogController(
            $this->repo,
            $this->md,
            $this->responseFactory
        );

        $args = [BlogController::SLUG_KEY => self::ANY_SLUG_VALUE];

        $controller->show($this->request, $args);
    }

    public function testShowGivenExistingSlugExpectedSuccessResponseReturned(): void
    {
        $someContent = 'some content';
        /** @var MockObject */
        $blog = static::createMock(Blog::class);
        $blog
            ->expects(static::once())
            ->method('content')
            ->willReturn($someContent);

        $this->repo
            ->expects(static::once())
            ->method('get')
            ->with(self::ANY_SLUG_VALUE)
            ->willReturn($blog);

        $someHtml = 'some html';
        $this->md
            ->expects(static::once())
            ->method('convertToHtml')
            ->with($someContent)
            ->willReturn($someHtml);

        /** @var MockObject */
        $someResponse = static::createMock(ResponseInterface::class);
        $someResponse
            ->method('getStatusCode')
            ->willReturn(self::SUCCESS);

        $this->responseFactory
            ->expects(static::once())
            ->method('create')
            ->willReturn($someResponse);

        $controller = new BlogController(
            $this->repo,
            $this->md,
            $this->responseFactory
        );

        $args = [BlogController::SLUG_KEY => self::ANY_SLUG_VALUE];
        $response = $controller->show($this->request, $args);

        $actualStatusCode = $response->getStatusCode();

        static::assertEquals(self::SUCCESS, $actualStatusCode);
    }
}
