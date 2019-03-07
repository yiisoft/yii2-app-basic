<?php

/**
 * Application configuration shared by all test types
 */
$config_test = [
    'id' => 'basic-tests',
    'language' => 'en-US',
    'components' => [
        'mailer' => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'user' => [
            'identityClass' => 'app\models\User',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
];

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../config/main.php',
    require __DIR__ . '/../config/main-local.php',
    require __DIR__ . '/../config/main-test.php',
    $config_test
);
