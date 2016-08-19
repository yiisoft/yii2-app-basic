<?php

/**
 * Database connection credentials for tests on a local installation.
 */
return [
    'class' => 'yii\db\Connection',
    // test database! Important not to run tests on production or development databases
    'dsn' => 'mysql:host=localhost;dbname=yii2_basic_tests',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
