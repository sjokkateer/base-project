<?php

namespace App\Core\Adapters;

interface Markdown
{
    public function convertToHtml(string $markdown): string;
}
