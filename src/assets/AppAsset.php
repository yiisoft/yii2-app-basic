<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\bootstrap5\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\View;
use yii\web\YiiAsset;

/**
 * Registers application CSS and JS assets with Bootstrap 5 and jQuery dependencies.
 */
final class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $depends = [
        BootstrapAsset::class,
        YiiAsset::class,
    ];
    public $js = [
        'js/color-mode.js',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}
