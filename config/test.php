<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

use app\models\User;
use app\tests\support\MailerBootstrap;
use yii\jquery\Bootstrap;
use yii\rbac\PhpManager;
use yii\symfonymailer\Mailer;
use yii\symfonymailer\Message;

$params = require __DIR__ . '/params.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'app-jquery-tests',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => dirname(__DIR__) . '/node_modules',
    ],
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        Bootstrap::class,
        MailerBootstrap::class,
    ],
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../public/assets',
        ],
        'authManager' => [
            'class' => PhpManager::class,
        ],
        'db' => require __DIR__ . '/test_db.php',
        'mailer' => [
            'class' => Mailer::class,
            'messageClass' => Message::class,
            'useFileTransport' => true,
            'viewPath' => '@app/resources/mail',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'user' => [
            'identityClass' => User::class,
            'loginUrl' => [
                'user/login',
            ],
        ],
    ],
    'controllerNamespace' => 'app\\controllers',
    'language' => 'en-US',
    'params' => $params,
    'viewPath' => dirname(__DIR__) . '/resources/views',
];
