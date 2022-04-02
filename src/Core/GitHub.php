<?php

declare(strict_types=1);

namespace App\Core;

class GitHub extends SocialMedia
{
    public function __construct(string $url)
    {
        parent::__construct($url, 'fa-github', 'GitHub');
    }
}
