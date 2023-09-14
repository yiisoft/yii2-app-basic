<?php

use yii\di\Instance;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'enableAutoLogin' => true,
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'GET api/news' => 'news/get-list',
                'POST api/news' => 'news/create',
                'PUT api/news/<id:\d+>' => 'news/update',
                'DELETE api/news/<id:\d+>' => 'news/delete',
                'OPTIONS api/news/<id:\d+>' => 'news/options',
                'OPTIONS api/news' => 'news/options',
            ],
        ],
    ],
    'as beforeRequest' => [
        'class' => \yii\filters\Cors::class,
        'cors' => [
            'Origin' => ['*'],
            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
            'Access-Control-Allow-Headers' => ['*'],
        ],
    ],
    'params' => $params,
    'container' => [
        'definitions' => [
            app\services\NewsService\NewsModerator::class => [
                '__construct()' => [
                    [
                        Instance::of(app\services\NewsService\Moderations\RemoveObsceneWordsModeration::class),
                        Instance::of(app\services\NewsService\Moderations\ReplaceUrlToTagModeration::class),
                        Instance::of(app\services\NewsService\Moderations\RemoveImgTagsModeration::class)
                    ]
                ]
            ]
        ],
        'singletons' => [
            // Конфигурация для единожды создающихся объектов
        ]
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
