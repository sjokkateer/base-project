<?php

namespace App\Core\Adapters;

interface MarkdownInterface
{
    public function convertToHtml(string $markdown): string;
}
