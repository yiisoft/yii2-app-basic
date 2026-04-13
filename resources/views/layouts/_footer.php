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
?>
<footer id="footer" class="mt-auto py-3 bg-body-tertiary">
    <div class="container">
        <div class="row text-body-secondary">
            <div class="col-md-6 text-center text-md-start">
                &copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a
                    href="https://www.yiiframework.com/"
                    rel="external"
                    aria-label="<?= Html::encode(Yii::t('yii', 'Powered by {yii}', ['yii' => 'Yii Framework'])) ?>"
                    class="text-body-secondary text-decoration-none"
                >
                    <?= Html::encode(Yii::t(
                        'yii',
                        'Powered by {yii}',
                        ['yii' => ''],
                    )) ?>
                    <?= Html::img(
                        '@web/images/yii3_full_for_light.svg',
                        [
                            'alt' => '',
                            'aria-hidden' => 'true',
                            'class' => 'align-text-bottom footer-logo-light',
                            'height' => '28',
                        ],
                    ) ?>
                    <?= Html::img(
                        '@web/images/yii3_full_for_dark.svg',
                        [
                            'alt' => '',
                            'aria-hidden' => 'true',
                            'class' => 'align-text-bottom footer-logo-dark',
                            'height' => '28',
                        ],
                    ) ?>
                </a>
            </div>
        </div>
    </div>
</footer>
