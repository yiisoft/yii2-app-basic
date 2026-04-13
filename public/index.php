<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

// comment out the following two lines when deployed to production
defined('YII_DEBUG') || define('YII_DEBUG', true);
defined('YII_ENV') || define('YII_ENV', 'dev');

// check mandatory requirements before bootstrapping the framework (dev only)
if (YII_ENV === 'dev') {
    $result = require __DIR__ . '/../requirements.php';

    if ($result['summary']['errors'] > 0) {
        require __DIR__ . '/../resources/views/site/requirements-standalone.php';
        exit(1);
    }
}

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
