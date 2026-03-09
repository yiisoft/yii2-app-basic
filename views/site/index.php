<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'My Yii Application';
?>
<div class="site-index d-flex flex-column justify-content-center h-100">

    <div class="p-5 mb-5 text-center bg-body-tertiary rounded-3">
        <h1 class="display-4 fw-bold">Congratulations!</h1>

        <p class="lead col-lg-8 mx-auto">You have successfully created your Yii-powered application.</p>

        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <?= Html::a('Get started with Yii', 'https://www.yiiframework.com', ['class' => 'btn btn-lg btn-success']) ?>
        </div>
    </div>

    <div class="body-content">

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h2 class="h5"><?= Yii::t('app', 'Definitive Guide') ?></h2>

                        <p><?= Yii::t('app', 'Learn Yii step by step: MVC structure, ActiveRecord, migrations, form validation, authentication, RBAC, REST APIs, caching, and testing. Everything you need is covered in one place, from basics to advanced topics.') ?></p>

                        <ul class="list-unstyled small">
                            <li><?= Html::a(Yii::t('app', 'Definitive Guide'), 'https://www.yiiframework.com/doc/guide/2.0/en', ['target' => '_blank', 'rel' => 'noopener']) ?></li>
                            <li><?= Html::a(Yii::t('app', 'API Reference'), 'https://www.yiiframework.com/doc/api/2.0', ['target' => '_blank', 'rel' => 'noopener']) ?></li>
                            <li><?= Html::a(Yii::t('app', 'Getting Started'), 'https://www.yiiframework.com/doc/guide/2.0/en/start-installation', ['target' => '_blank', 'rel' => 'noopener']) ?></li>
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <?= Html::a('Yii Documentation &raquo;', 'https://www.yiiframework.com/doc/', ['class' => 'btn btn-outline-secondary']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h2 class="h5"><?= Yii::t('app', 'Community Forum') ?></h2>

                        <p><?= Yii::t('app', 'The Yii Forum is where thousands of developers share solutions, discuss best practices, and help each other. Before opening a GitHub issue, chances are someone already solved your problem there.') ?></p>

                        <ul class="list-unstyled small">
                            <li><?= Html::a(Yii::t('app', 'Forum'), 'https://forum.yiiframework.com/', ['target' => '_blank', 'rel' => 'noopener']) ?></li>
                            <li><?= Html::a(Yii::t('app', 'GitHub'), 'https://github.com/yiisoft/yii2', ['target' => '_blank', 'rel' => 'noopener']) ?></li>
                            <li><?= Html::a(Yii::t('app', 'Telegram'), 'https://t.me/yii_framework_in_english', ['target' => '_blank', 'rel' => 'noopener']) ?></li>
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <?= Html::a('Yii Forum &raquo;', 'https://www.yiiframework.com/forum/', ['class' => 'btn btn-outline-secondary']) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h2 class="h5"><?= Yii::t('app', 'Official Extensions') ?></h2>

                        <p><?= Yii::t('app', 'Supercharge your app with battle-tested packages maintained by the core team.') ?></p>

                        <ul class="list-unstyled small">
                            <li><?= Html::a('yii2-debug', 'https://www.yiiframework.com/extension/yiisoft/yii2-debug', ['target' => '_blank', 'rel' => 'noopener']) ?></li>
                            <li><?= Html::a('yii2-gii', 'https://www.yiiframework.com/extension/yiisoft/yii2-gii', ['target' => '_blank', 'rel' => 'noopener']) ?></li>
                            <li><?= Html::a('yii2-queue', 'https://www.yiiframework.com/extension/yiisoft/yii2-queue', ['target' => '_blank', 'rel' => 'noopener']) ?></li>
                            <li><?= Html::a('yii2-redis', 'https://www.yiiframework.com/extension/yiisoft/yii2-redis', ['target' => '_blank', 'rel' => 'noopener']) ?></li>
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <?= Html::a('Yii Extensions &raquo;', 'https://www.yiiframework.com/extensions/', ['class' => 'btn btn-outline-secondary']) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
