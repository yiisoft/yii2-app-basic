<?php

declare(strict_types=1);

use yii\helpers\Html;

/**
 * @var yii\web\View $this view component instance.
 *
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */
$this->title = 'My Yii Application';
$this->params['meta_description'] = 'A high-performance PHP framework best for developing web applications. Fast, secure, and professional.';

$extensions = [
    [
        'icon' => '&#128270;',
        'name' => 'yii2-debug',
        'description' => 'Debug toolbar and debugger for Yii2. Inspect logs, database queries, request data, and application performance in real time.',
        'url' => 'https://www.yiiframework.com/extension/yiisoft/yii2-debug',
    ],
    [
        'icon' => '&#9881;',
        'name' => 'yii2-gii',
        'description' => 'Automatic code generator for models, controllers, CRUD, forms, and modules. Boost your productivity with scaffolding.',
        'url' => 'https://www.yiiframework.com/extension/yiisoft/yii2-gii',
    ],
    [
        'icon' => '&#128203;',
        'name' => 'yii2-queue',
        'description' => 'Asynchronous job queue with support for DB, Redis, AMQP, Beanstalk, and SQS drivers. Run background tasks with ease.',
        'url' => 'https://www.yiiframework.com/extension/yiisoft/yii2-queue',
    ],
    [
        'icon' => '&#9889;',
        'name' => 'yii2-redis',
        'description' => 'Redis integration providing cache, session, and ActiveRecord support. Leverage in-memory storage for blazing-fast data access.',
        'url' => 'https://www.yiiframework.com/extension/yiisoft/yii2-redis',
    ],
    [
        'icon' => '&#128269;',
        'name' => 'yii2-elasticsearch',
        'description' => 'Elasticsearch integration with ActiveRecord and query builder. Add powerful full-text search capabilities to your application.',
        'url' => 'https://www.yiiframework.com/extension/yiisoft/yii2-elasticsearch',
    ],
    [
        'icon' => '&#9993;',
        'name' => 'yii2-symfonymailer',
        'description' => 'Email sending integration powered by Symfony Mailer. Compose and deliver rich HTML emails with attachments and templates.',
        'url' => 'https://github.com/yiisoft/yii2-symfonymailer',
    ],
];
?>
<div class="site-index">

    <!-- Hero banner with Yii gradient -->
    <div class="hero-banner text-white rounded-4 p-5 mb-4 position-relative overflow-hidden">
        <?= Html::img(
            Yii::getAlias('@web/images/yii3_full_white_for_dark.svg'),
            [
                'alt' => '',
                'class' => 'd-none d-lg-block position-absolute hero-logo',
            ],
        ) ?>
        <div class="position-relative">
            <h1 class="display-5 fw-bold mb-3">Build with Yii Framework</h1>
            <p class="lead opacity-75 mb-4 hero-lead">
                A high-performance PHP framework best for developing web applications.
                Fast, secure, and professional.
            </p>
            <div class="d-flex gap-2 flex-wrap">
                <?= Html::a(
                    'Get Started',
                    'https://www.yiiframework.com/doc/guide/2.0/en/start-installation',
                    [
                        'class' => 'btn btn-light btn-lg fw-semibold px-4',
                        'rel' => 'noopener noreferrer',
                        'target' => '_blank',
                    ],
                ) ?>
                <?= Html::a(
                    'API Reference',
                    'https://www.yiiframework.com/doc/api/2.0',
                    [
                        'class' => 'btn btn-outline-light btn-lg px-4',
                        'rel' => 'noopener noreferrer',
                        'target' => '_blank',
                    ],
                ) ?>
            </div>
        </div>
    </div>

    <!-- Extensions grid -->
    <div class="row g-3">
        <?php foreach ($extensions as $ext): ?>
            <div class="col-md-6 col-lg-4">
                <?= $this->render('_extension-card', $ext) ?>
            </div>
        <?php endforeach; ?>
    </div>

</div>
