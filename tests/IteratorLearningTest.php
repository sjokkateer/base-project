<?php

declare(strict_types=1);

namespace Learning;

use FilesystemIterator;
use FilterIterator;
use PHPUnit\Framework\TestCase;

use function array_map;
use function array_walk;
use function iterator_to_array;

final class IteratorLearningTest extends TestCase
{
    public function testName(): void
    {
        // Arrange
        $iterator = new class (new FilesystemIterator(__DIR__ . '/blogs')) extends FilterIterator
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
