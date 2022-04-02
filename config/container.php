<?php

declare(strict_types=1);

use App\Core\Adapters\DiceAdapter;
use App\Core\Adapters\Markdown;
use App\Core\Adapters\ParsedownAdapter;
use App\Core\BlogRepository;
use App\Core\FileSystemBlogRepository;
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
];

$dice = (new Dice())->addRules($rules);
return new DiceAdapter($dice);
