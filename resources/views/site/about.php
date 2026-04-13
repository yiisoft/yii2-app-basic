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
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = 'Learn more about this Yii2-powered application.';
?>
<div class="site-about d-flex align-items-center justify-content-center text-center">
    <div class="site-about-content mx-auto">
        <h1 class="display-6 fw-semibold mb-3">This is the About page.</h1>

        <?php if (YII_DEBUG): ?>
            <p class="text-body-secondary mb-4">
                You may modify the following file to customize its content:
                <code class="d-block mt-2"><?= Html::encode(__FILE__) ?></code>
            </p>
        <?php endif; ?>

        <?= Html::a(
            'Go to Homepage',
            Yii::$app->homeUrl,
            ['class' => 'btn btn-outline-primary btn-lg'],
        ) ?>
    </div>
</div>
