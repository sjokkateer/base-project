<?php

use App\Core\Views\View;

if (!function_exists('view')) {
    /** @param array<string, mixed> $data */
    function view(string $template, array $data = []): string
    {
        return (new View($template))->render($data);
    }
}
