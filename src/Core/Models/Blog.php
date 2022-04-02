<?php

namespace App\Core\Models;

class Blog
{
    public string $title = 'N/a';
    public string $file = 'does_not_exist';
    public string $content = 'N/a';
    public string $createdAt = '0000-00-00 00:00:00';

    public function content(): string
    {
        return file_get_contents($this->file);
    }
}
