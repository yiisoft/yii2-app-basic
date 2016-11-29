<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// require composer and Yii autoloaders
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

// configure dependency injection container
require(__DIR__ . '/../config/di.php');

// configure and create application
$config = require(__DIR__ . '/../config/web.php');
(new yii\web\Application($config))->run();
