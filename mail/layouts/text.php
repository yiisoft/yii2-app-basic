<?php

/** 
 * @var yii\web\View $this view component instance
 * @var yii\mail\BaseMessage $message the message being composed
 * @var string $content main view render result
 */

$this->beginPage();
$this->beginBody();
echo $content;
$this->endBody();
$this->endPage();
