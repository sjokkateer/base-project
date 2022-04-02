<?php

declare(strict_types=1);

namespace App\Core\Services;

use App\Core\Helpers\ConfigFiles;
use App\Core\SocialMedia;
use RuntimeException;

use function file_exists;
use function file_get_contents;
use function is_array;
use function sprintf;

class AboutService
{
    /** @return array<SocialMedia> */
    public function getSocials(): array
    {
        $socials = [];

        if (file_exists(ConfigFiles::getSocialsFile())) {
            $socials = include ConfigFiles::getSocialsFile();
        }

        if (!is_array($socials)) {
            throw new RuntimeException(
                sprintf(
                    "'%s' must return an array of SocialMedia objects",
                    ConfigFiles::getSocialsFile()
                )
            );
        }

        return $socials;
    }

    public function getIntro(): string
    {
        if (!file_exists(ConfigFiles::getIntroFile())) {
            return '';
        }

        $content = file_get_contents(ConfigFiles::getIntroFile());

        if ($content === false) {
            throw new RuntimeException(
                sprintf(
                    'Could not obtain the content for %s',
                    ConfigFiles::getIntroFile()
                )
            );
        }

        return $content;
    }

    public static function hasAbout(): bool
    {
        return file_exists(ConfigFiles::getSocialsFile())
            || file_exists(ConfigFiles::getIntroFile());
    }
}
