<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Models\Blog;
use FilesystemIterator;
use FilterIterator;
use Iterator;
use RuntimeException;
use SplFileInfo;

use function file_exists;
use function mkdir;
use function rtrim;
use function sprintf;
use function str_repeat;
use function str_replace;
use function strtolower;

use const DIRECTORY_SEPARATOR;

class FileSystemBlogRepository implements BlogRepository
{
    private const BLOG_DIR = 'blogs';

    private bool $cached;
    /** @var array<Blog> */
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
            if ($slug === $blog->slug) {
                return $blog;
            }
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

        /** @var SplFileInfo $blogFile */
        foreach ($blogFileIterator as $blogFile) {
            $blog = new Blog();

            $fileName = $blogFile->getFilename();
            $preparedFileName = str_replace('  ', ' ', $fileName);

            $blog->title = rtrim($preparedFileName, '.md');
            $blog->file = $blogFile->getRealPath();
            $blog->slug = strtolower(str_replace(' ', '-', $blog->title));

            $this->blogs[] = $blog;
        }

        $this->cached = true;
    }

    private function getBlogFiles(): Iterator
    {
        $this->ensureBlogDirExists();

        return new class (new FilesystemIterator(self::getBlogDir())) extends FilterIterator
        {
            public function accept(): bool
            {
                /** @var SplFileInfo */
                $current = $this->current();
                return $current->getExtension() === 'md';
            }
        };
    }

    private static function getBlogDir(): string
    {
        return __DIR__ . str_repeat(DIRECTORY_SEPARATOR . '..', 2) . DIRECTORY_SEPARATOR . self::BLOG_DIR;
    }

    private function ensureBlogDirExists(): void
    {
        if (
            !file_exists(self::getBlogDir())
            && !mkdir(self::getBlogDir())
        ) {
            throw new RuntimeException(
                sprintf(
                    "Could not create the dir for blogs '%s'",
                    self::getBlogDir()
                )
            );
        }
    }
}
