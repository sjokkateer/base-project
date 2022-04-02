<?php

declare(strict_types=1);

namespace App\Core\Views;

use function extract;
use function ob_get_clean;
use function ob_start;

use const DIRECTORY_SEPARATOR;

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
        extract($data);

        ob_start();
        include __DIR__ . self::TEMPLATE_FOLDER . DIRECTORY_SEPARATOR . $this->template . '.html.php';
        $content = ob_get_clean();

        ob_start();
        include __DIR__ . self::TEMPLATE_FOLDER . DIRECTORY_SEPARATOR . 'layouts/base.html.php';
        return ob_get_clean();
    }
}
