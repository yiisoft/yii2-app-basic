<?php
require_once(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

$_SERVER['SCRIPT_FILENAME'] = codecept_root_dir() . '/web/index.php';
$_SERVER['SCRIPT_NAME'] = 'http://localhost:8080/index-test.php';

\Codeception\Specify\Config::setDeepClone(false);