<?php
/**
 * Application configuration for acceptance tests
 */
return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../../config/web-general.php'),
    require(__DIR__ . '/../../../config/web-' . YII_ENV . '.php'),
    require(__DIR__ . '/config.php'),
    require(__DIR__ . '/../../../config/web-local.php'),
    [

    ]
);
