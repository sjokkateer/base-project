<?php

declare(strict_types=1);

namespace App\Core\Controllers;

use App\Core\Adapters\Markdown;
use App\Core\SocialMedia;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

use function compact;
use function file_exists;
use function file_get_contents;
use function is_array;
use function sprintf;
use function str_repeat;
use function view;

use const DIRECTORY_SEPARATOR;

class AboutController
{
    protected const CONFIG_DIR = 'config';
    protected const SOCIALS_FILE = 'socials.php';
    protected const INTRO_FILE = 'intro.md';

    public function __construct(
        private Markdown $md,
    ) {
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $intro = $this->getIntro();
        $socials = $this->getSocials();

        return new HtmlResponse(view('about/index', compact('intro', 'socials')));
    }

    /** @return array<SocialMedia> */
    private function getSocials(): array
    {
        $socials = [];

        if (file_exists(self::getSocialsFile())) {
            $socials = include self::getSocialsFile();
        }

        if (!is_array($socials)) {
            throw new RuntimeException(
                sprintf(
                    "'%s' must return an array of SocialMedia objects",
                    self::getSocialsFile()
                )
            );
        }

        return $socials;
    }

    private static function getSocialsFile(): string
    {
        return self::getConfigDir() . DIRECTORY_SEPARATOR . static::SOCIALS_FILE;
    }

    private static function getConfigDir(): string
    {
        return __DIR__ . str_repeat(DIRECTORY_SEPARATOR . '..', 3) . DIRECTORY_SEPARATOR . static::CONFIG_DIR;
    }

    private function getIntro(): string
    {
        $intro = '';

        if (file_exists(self::getIntroFile())) {
            $content = file_get_contents(self::getIntroFile());

            if ($content === false) {
                throw new RuntimeException(
                    sprintf(
                        'Could not obtain the content for %s',
                        self::getIntroFile()
                    )
                );
            }

            $intro = $this->md->convertToHtml($content);
        }

        return $intro;
    }

    private static function getIntroFile(): string
    {
        return self::getConfigDir() . DIRECTORY_SEPARATOR . static::INTRO_FILE;
    }

    public static function hasAbout(): bool
    {
        return file_exists(self::getSocialsFile())
            || file_exists(self::getIntroFile());
    }
}
