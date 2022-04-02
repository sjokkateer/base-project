<?php

declare(strict_types=1);

namespace App\Core\Models;

use RuntimeException;

use function file_get_contents;
use function sprintf;

class Blog
{
    public string $title = 'N/a';
    public string $file = 'does_not_exist';
    public string $content = 'N/a';
    public string $slug = 'N/a';
    public string $createdAt = '0000-00-00 00:00:00';

    public function content(): string
    {
        $content = file_get_contents($this->file);

        if ($content === false) {
            throw new RuntimeException(
                sprintf('Could not get the content for file %s', $this->file)
            );
        }

        return $content;
    }
}
