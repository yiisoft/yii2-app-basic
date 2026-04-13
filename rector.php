<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\Class_\TypedPropertyFromCreateMockAssignRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->importNames();
    $rectorConfig->paths(
        [
            __DIR__ . '/src',
            __DIR__ . '/tests',
        ],
    );
    $rectorConfig->parallel();
    $rectorConfig->sets(
        [
            SetList::PHP_83,
            LevelSetList::UP_TO_PHP_83,
            SetList::TYPE_DECLARATION,
        ],
    );
    $rectorConfig->skip(
        [
            TypedPropertyFromCreateMockAssignRector::class,
        ],
    );
    $rectorConfig->rules(
        [
            SimplifyEmptyArrayCheckRector::class,
        ],
    );
};
