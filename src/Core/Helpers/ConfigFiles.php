<?php

declare(strict_types=1);

namespace App\Core\Helpers;

use function str_repeat;

use const DIRECTORY_SEPARATOR;

class ConfigFiles
{
    private const CONFIG_DIR = 'config';
    private const SOCIALS_FILE = 'socials.php';
    private const INTRO_FILE = 'intro.md';
    private const CONTAINER_FILE = 'container.php';

    public static function getSocialsFile(): string
    {
        return self::getConfigDir() . DIRECTORY_SEPARATOR . self::SOCIALS_FILE;
    }

    private static function getConfigDir(): string
    {
        return __DIR__ . str_repeat(DIRECTORY_SEPARATOR . '..', 3) . DIRECTORY_SEPARATOR . self::CONFIG_DIR;
    }

    public static function getIntroFile(): string
    {
        return self::getConfigDir() . DIRECTORY_SEPARATOR . self::INTRO_FILE;
    }

    public static function getContainerFile(): string
    {
        return self::getConfigDir() . DIRECTORY_SEPARATOR . self::CONTAINER_FILE;
    }
}
