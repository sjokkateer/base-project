<?php

declare(strict_types=1);

namespace Learning;

use App\Core\Adapters\Markdown;
use App\Core\Helpers\ConfigFiles;
use PHPUnit\Framework\TestCase;

final class DiceLearningTest extends TestCase
{
    public function testSharedKeySetExpectedReturnedAdaptersToBeTheSameObjectInstance(): void
    {
        // Arrange
        $container = include ConfigFiles::getContainerFile();

        // Act
        $md = $container->get(Markdown::class);
        $md2 = $container->get(Markdown::class);

        // Assert
        static::assertSame($md, $md2);
    }
}
