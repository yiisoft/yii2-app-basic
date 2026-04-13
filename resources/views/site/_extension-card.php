<?php

declare(strict_types=1);

use yii\helpers\Html;

/**
 * @var string $description extension description.
 * @var string $icon extension icon (HTML).
 * @var string $name extension name.
 * @var string $url extension URL.
 * @var yii\web\View $this view component instance.
 *
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */
?>
<div class="card h-100 border-0 shadow-sm rounded-3 extension-card">
    <div class="card-body">
        <div class="d-flex align-items-center mb-3">
            <span class="extension-icon" aria-hidden="true"><?= $icon ?></span>
            <h3 class="h6 fw-bold mb-0 ms-2"><?= Html::encode($name) ?></h3>
        </div>
        <p class="text-body-secondary small mb-0">
            <?= Html::encode($description) ?>
        </p>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0">
        <?= Html::a(
            'Learn more &raquo;',
            $url,
            [
                'aria-label' => sprintf('Learn more about %s', $name),
                'class' => 'btn btn-sm btn-outline-secondary',
                'rel' => 'noopener noreferrer',
                'target' => '_blank',
            ],
        ) ?>
    </div>
</div>
