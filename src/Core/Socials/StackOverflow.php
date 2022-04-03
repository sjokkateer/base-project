<?php

declare(strict_types=1);

namespace App\Core\Socials;

class StackOverflow extends SocialMedia
{
    public function __construct(string $url)
    {
        parent::__construct($url, 'fa-stack-overflow', 'Stack Overflow');
    }
}
