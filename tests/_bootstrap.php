<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

defined('YII_DEBUG') || define('YII_DEBUG', true);
defined('YII_ENV') || define('YII_ENV', 'test');

require dirname(__DIR__) . '/vendor/autoload.php';

// run migrations on the test database.
$app = new yii\console\Application(
    [
        'id' => 'app-jquery-test-migrate',
        'basePath' => dirname(__DIR__),
        'aliases' => ['@app/migrations' => dirname(__DIR__) . '/src/migrations'],
        'components' => ['db' => require dirname(__DIR__) . '/config/test_db.php'],
        'controllerMap' => [
            'migrate' => [
                'class' => yii\console\controllers\MigrateController::class,
                'migrationNamespaces' => ['app\\migrations'],
                'migrationPath' => null,
                'interactive' => false,
                'compact' => true,
            ],
        ],
        'params' => require dirname(__DIR__) . '/config/params.php',
    ],
);

$app->runAction('migrate/up');

$app = null;

// @phpstan-ignore assign.propertyType
Yii::$app = null;
