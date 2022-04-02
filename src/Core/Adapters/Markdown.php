<?php

declare(strict_types=1);

namespace App\Core\Adapters;

interface Markdown
{
    public function convertToHtml(string $markdown): string;
}
