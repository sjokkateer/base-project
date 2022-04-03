<?php

declare(strict_types=1);

namespace Learning;

use FilesystemIterator;
use FilterIterator;
use PHPUnit\Framework\TestCase;

use function array_map;
use function array_walk;
use function iterator_to_array;

use const DIRECTORY_SEPARATOR;

final class IteratorLearningTest extends TestCase
{
    private const BLOGS_DIR = 'blogs';

    public function testName(): void
    {
        // Arrange
        $blogs = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . self::BLOGS_DIR;

        $iterator = new class (new FilesystemIterator($blogs)) extends FilterIterator
        {
            public function accept(): bool
            {
                /** @phpstan-ignore-next-line */
                return $this->current()->getExtension() === 'md';
            }
        };

        // Act
        $asArray = iterator_to_array($iterator, false);
        /** @phpstan-ignore-next-line */
        $actual = array_map(static fn ($file) => $file->getFilename(), $asArray);

        $expected = [
            'some blog.md',
            'some blog 2.md',
            'some blog 3.md',
        ];

        // Assert
        array_walk($actual, static fn ($actualFileName) => static::assertContains($actualFileName, $expected));
    }
}
