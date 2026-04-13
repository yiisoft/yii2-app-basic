<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

use app\models\User;
use yii\caching\FileCache;
use yii\log\FileTarget;
use yii\symfonymailer\Mailer;
use yii\web\Application;
use yii\web\AssetManager;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\View;

$params = require dirname(__DIR__, 2) . '/config/params.php';

return [
    'phpstan' => [
        'application_type' => Application::class,
    ],
    'id' => 'app-jquery-phpstan',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => dirname(__DIR__, 2) . '/node_modules',
    ],
    'basePath' => dirname(__DIR__, 2),
    'controllerNamespace' => 'app\\controllers',
    'components' => [
        'assetManager' => [
            'class' => AssetManager::class,
        ],
        'cache' => [
            'class' => FileCache::class,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => [
                        'error',
                        'warning',
                    ],
                ],
            ],
        ],
        'mailer' => [
            'class' => Mailer::class,
            'useFileTransport' => true,
        ],
        'request' => [
            'class' => Request::class,
        ],
        'urlManager' => [
            'class' => UrlManager::class,
        ],
        'user' => [
            'identityClass' => User::class,
        ],
        'view' => [
            'class' => View::class,
        ],
    ],
    'params' => $params,
    'viewPath' => dirname(__DIR__, 2) . '/resources/views',
];
