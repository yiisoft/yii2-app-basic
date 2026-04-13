<?php

declare(strict_types=1);

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;

/**
 * @var yii\web\View $this view component instance.
 *
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */
$items = [
    [
        'label' => 'Home',
        'url' => ['/site/index'],
    ],
    [
        'label' => 'About',
        'url' => ['/site/about'],
    ],
    [
        'label' => 'Contact',
        'url' => ['/site/contact'],
    ],
    [
        'label' => 'Users',
        'url' => ['/user/index'],
        'visible' => Yii::$app->user->can('viewUsers'),
    ],
    [
        'label' => 'Signup',
        'url' => ['/user/signup'],
        'visible' => Yii::$app->user->isGuest,
    ],
    [
        'label' => 'Login',
        'url' => ['/user/login'],
        'visible' => Yii::$app->user->isGuest,
    ],
    [
        'label' => 'Logout (' . (Yii::$app->user->identity?->username ?? '') . ')',
        'url' => ['/user/logout'],
        'linkOptions' => [
            'data-method' => 'post',
            'class' => 'nav-link logout',
        ],
        'visible' => !Yii::$app->user->isGuest,
    ],
];

?>
<header id="header">
    <?php NavBar::begin(
        [
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top'],
        ],
    ) ?>
    <?= Nav::widget(
        [
            'options' => ['class' => 'navbar-nav me-auto'],
            'items' => $items,
        ],
    ) ?>
    <?= Html::button(
        '&#127769;',
        [
            'id' => 'theme-toggle',
            'class' => 'btn btn-link nav-link fs-5',
            'aria-label' => 'Switch to dark mode',
        ],
    ) ?>
    <?php NavBar::end() ?>
</header>
