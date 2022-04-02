<?php

namespace App\Core\Adapters;

use Parsedown;

class ParsedownAdapter implements Markdown
{
    public function __construct(
        private Parsedown $parser
    ) {
    }

    public function convertToHtml(string $markDown): string
    {
        return $this->parser->text($markDown);
    }
}
