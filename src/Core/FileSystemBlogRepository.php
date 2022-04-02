<?php

namespace App\Core;

use App\Core\Models\Blog;
use Iterator;

class FileSystemBlogRepository implements BlogRepositoryInterface
{
    private const BLOG_DIR = 'blogs';

    private bool $cached;
    private array $blogs;

    public function __construct()
    {
        $this->cached = false;
        $this->blogs = [];
    }

    public function get(string $slug): ?Blog
    {
        if ($this->cached === false) {
            $this->prepareBlogs();
        }

        foreach ($this->blogs as $blog) {
            if ($slug == $blog->slug) return $blog;
        }

        return null;
    }

    public function all(): array
    {
        if ($this->cached === false) {
            $this->prepareBlogs();
        }

        return $this->blogs;
    }

    private function prepareBlogs(): void
    {
        $blogFileIterator = $this->getBlogFiles();

        foreach ($blogFileIterator as $blogFile) {
            $blog = new Blog;

            $fileName = $blogFile->getFileName();
            $preparedFileName = preg_replace('/\s\s+/', ' ', $fileName);

            $blog->title = rtrim($preparedFileName, '.md');
            $blog->file = $blogFile->getRealPath();
            $blog->slug = strtolower(preg_replace('/\s/', '-', $blog->title));

            $this->blogs[] = $blog;
        }

        $this->cached = true;
    }

    private function getBlogFiles(): Iterator
    {
        $this->ensureBlogDirExists();

        return new class(new \FilesystemIterator(static::getBlogDir())) extends \FilterIterator
        {
            public function accept(): bool
            {
                return $this->current()->getExtension() == 'md';
            }
        };
    }

    private static function getBlogDir(): string
    {
        return __DIR__ . str_repeat(DIRECTORY_SEPARATOR . '..', 2) . DIRECTORY_SEPARATOR . static::BLOG_DIR;
    }

    private function ensureBlogDirExists(): void
    {
        if (
            !file_exists(static::getBlogDir())
            && !mkdir(static::getBlogDir())
        ) {
            throw new \RuntimeException(
                sprintf(
                    "Could not create the dir for blogs '%s'",
                    static::getBlogDir()
                )
            );
        }
    }
}
