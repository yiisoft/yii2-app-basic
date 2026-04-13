<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

// note: make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('You are not allowed to access this file.');
}

defined('YII_DEBUG') || define('YII_DEBUG', true);
defined('YII_ENV') || define('YII_ENV', 'test');

require __DIR__ . '/../vendor/autoload.php';

$c3 = dirname(__DIR__) . '/c3.php';

if (file_exists($c3)) {
    require_once $c3;
}

$config = require __DIR__ . '/../config/test.php';

(new yii\web\Application($config))->run();
