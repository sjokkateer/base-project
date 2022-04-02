<?php

use App\Core\Adapters\DiceAdapter;
use App\Core\Adapters\MarkdownInterface;
use App\Core\Adapters\ParsedownAdapter;
use App\Core\BlogRepositoryInterface;
use App\Core\FileSystemBlogRepository;
use Dice\Dice;

$rules = [
    MarkdownInterface::class => [
        'shared' => true,
        'instanceOf' => ParsedownAdapter::class
    ],
    BlogRepositoryInterface::class => [
        'shared' => true,
        'instanceOf' => FileSystemBlogRepository::class
    ],
];

$dice = (new Dice)->addRules($rules);
return new DiceAdapter($dice);
