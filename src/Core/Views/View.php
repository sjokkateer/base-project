<?php

namespace App\Core\Views;

class View
{
    private const TEMPLATE_FOLDER = '/../../../templates';

    public function __construct(
        protected string $template,
    ) {
    }

    /** @param array<string, mixed> $data */
    public function render(array $data = []): string
    {
        $templateFolder = self::TEMPLATE_FOLDER;

        extract($data);

        ob_start();
        include __DIR__ . "$templateFolder/$this->template.html.php";
        $content = ob_get_clean();

        ob_start();
        include __DIR__ . "$templateFolder/layouts/base.html.php";
        return ob_get_clean();
    }
}
