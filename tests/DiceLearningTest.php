<?php

declare(strict_types=1);

namespace Learning;

use App\Core\Adapters\MarkdownInterface;
use PHPUnit\Framework\TestCase;

final class DiceLearningTest extends TestCase
{
    public function testSharedKeySetExpectedReturnedAdaptersToBeTheSameObjectInstance(): void
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
