<?php

declare(strict_types=1);

use App\Core\Adapters\DiceAdapter;
use App\Core\Adapters\Markdown;
use App\Core\Adapters\ParsedownAdapter;
use App\Core\Factories\HtmlResponseFactory;
use App\Core\Factories\LaminasHtmlResponseFactory;
use App\Core\Repositories\BlogRepository;
use App\Core\Repositories\FileSystemBlogRepository;
use Dice\Dice;

$rules = [
    Markdown::class => [
        'shared' => true,
        'instanceOf' => ParsedownAdapter::class,
    ],
    BlogRepository::class => [
        'shared' => true,
        'instanceOf' => FileSystemBlogRepository::class,
    ],
    HtmlResponseFactory::class => [
        'shared' => true,
        'instanceOf' => LaminasHtmlResponseFactory::class,
    ],
];

$dice = (new Dice())->addRules($rules);
return new DiceAdapter($dice);
