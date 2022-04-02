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
    /** @test */
    public function testName(): void
    {
        // Arrange
        $iterator = new class (new FilesystemIterator(__DIR__ . '/blogs')) extends FilterIterator
        {
            public function accept(): bool
            {
                return $this->current()->getExtension() === 'md';
            }
        };

        // Act
        $asArray = iterator_to_array($iterator, false);
        $actual = array_map(static fn ($file) => $file->getFileName(), $asArray);

        $expected = [
            'some blog.md',
            'some blog 2.md',
            'some blog 3.md',
        ];

        // Assert
        array_walk($actual, fn ($actualFileName) => $this->assertContains($actualFileName, $expected));
    }
}
