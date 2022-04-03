<?php

declare(strict_types=1);

namespace App\Core\Socials;

abstract class SocialMedia
{
    public function __construct(
        private string $url,
        private string $icon,
        private string $displayText
    ) {
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getDisplayText(): string
    {
        return $this->displayText;
    }
}
