<?php

use MSpirkov\Yii2\Rector\Rules\AddPropertyTagsRector;
use MSpirkov\Yii2\Rector\Rules\RemoveRedundantPropertyTagsRector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/assets',
        __DIR__ . '/commands',
        __DIR__ . '/controllers',
        __DIR__ . '/models',
        __DIR__ . '/widgets',
        __DIR__ . '/tests',
    ])
    ->withRules([
        AddPropertyTagsRector::class,
        RemoveRedundantPropertyTagsRector::class,
    ]);
