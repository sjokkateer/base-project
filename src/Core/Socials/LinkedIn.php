<?php

declare(strict_types=1);

namespace App\Core\Socials;

class LinkedIn extends SocialMedia
{
    public function __construct(string $url)
    {
        parent::__construct($url, 'fa-linkedin-in', 'LinkedIn');
    }
}
