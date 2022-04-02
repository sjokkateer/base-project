<?php

use PHPUnit\Framework\TestCase;

// Prefix: AbstractClassName
final class IteratorLearningTest extends TestCase
{
    /** @test */
    public function testName(): void
    {
        // Arrange
        $iterator = new class(new FilesystemIterator(__DIR__ . '/blogs')) extends FilterIterator
        {
            public function accept()
            {
                return $this->current()->getExtension() == 'md';
            }
        };

        // Act
        $asArray = iterator_to_array($iterator, false);
        $actual = array_map(fn ($file) => $file->getFileName(), $asArray);

        $expected = [
            'some blog.md',
            'some blog 2.md',
            'some blog 3.md',
        ];

        // Assert
        array_walk($actual, fn ($actualFileName) => $this->assertContains($actualFileName, $expected));
    }
}
