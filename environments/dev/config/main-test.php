<?php
return [
    'aliases' => [
        '@tests' => '@app/tests',
    ],
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=yii2_basic_tests',
        ],
    ],
];
