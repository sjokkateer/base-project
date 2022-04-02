<?php

namespace App\Core;

use App\Core\Models\Blog;

interface BlogRepositoryInterface
{
    public function get(string $slug): ?Blog;

    /**
     * @return array<Blog>
     */
    public function all(): array;
}
