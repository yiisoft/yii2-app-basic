<?php

/**
 * Configuration adjustments for 'dev' environment of web application.
 */
return [
    'bootstrap' => [
        'gii',
        'debug',
    ],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
        ],
        'debug' => [
            'class' => 'yii\debug\Module',
        ],
    ],
];
