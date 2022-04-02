<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Models\Blog;

interface BlogRepository
{
    public function get(string $slug): ?Blog;

    /**
     * @return array<Blog>
     */
    public function all(): array;
}
