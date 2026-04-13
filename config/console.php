<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

use yii\caching\FileCache;
use yii\console\controllers\MigrateController;
use yii\console\controllers\ServeController;
use yii\log\FileTarget;
use yii\rbac\PhpManager;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'app-jquery-console',
    'aliases' => [
        '@app/migrations' => dirname(__DIR__) . '/src/migrations',
        '@bower' => '@vendor/bower-asset',
        '@npm' => dirname(__DIR__) . '/node_modules',
        '@tests' => dirname(__DIR__) . '/tests',
    ],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'authManager' => [
            'class' => PhpManager::class,
        ],
        'cache' => [
            'class' => FileCache::class,
        ],
        'db' => $db,
        'log' => [
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => MigrateController::class,
            'migrationNamespaces' => [
                'app\\migrations',
            ],
            'migrationPath' => null,
        ],
        'serve' => [
            'class' => ServeController::class,
            'docroot' => '@app/public',
        ],
    ],
    'controllerNamespace' => 'app\\commands',
    'params' => $params,
];

return $config;
