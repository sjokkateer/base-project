<?php

declare(strict_types=1);

namespace App\Core\Models;

use function file_get_contents;

class Blog
{
    public string $title = 'N/a';
    public string $file = 'does_not_exist';
    public string $content = 'N/a';
    public string $slug = 'N/a';
    public string $createdAt = '0000-00-00 00:00:00';

    public function content(): string
    {
        return file_get_contents($this->file);
    }
}
