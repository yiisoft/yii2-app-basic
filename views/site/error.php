<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger" role="alert">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p class="text-body-secondary">
        The above error occurred while the Web server was processing your request.
    </p>
    <p class="text-body-secondary">
        Please contact us if you think this is a server error. Thank you.
    </p>

    <?= Html::a('Go to Homepage', Yii::$app->homeUrl, ['class' => 'btn btn-outline-primary']) ?>

</div>
