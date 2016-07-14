<?php
$params = require(__DIR__ . '/params.php');
$dbParams = require(__DIR__ . '/db.php');

// test database! Important not to run tests on production or development databases
$dbParams['dsn'] = 'mysql:host=localhost;dbname=yii2_basic_tests';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),    
    'language' => 'en-US',
    'components' => [
        'db' => $dbParams,
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'request' => [
            // it's not recommended to run functional tests with CSRF validation enabled
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],        
    ],
    'params' => $params,
];
