<?php

use App\Core\Adapters\MarkdownInterface;
use PHPUnit\Framework\TestCase;

final class DiceLearningTest extends TestCase
{
    /** @test */
    public function shared_key_set_expected_returned_adapters_to_be_the_same_object_instance(): void
    {
        // Arrange
        $container = include_once __DIR__ . '/../config/container.php';

        // Act
        $md = $container->get(MarkdownInterface::class);
        $md2 = $container->get(MarkdownInterface::class);

        // Assert
        $this->assertSame($md, $md2);
    }
}
