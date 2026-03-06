<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
$htmlIcon = <<<HTML
<span class="input-group-text">%s</span>
<div class="form-floating flex-grow-1">{input}{label}</div>{error}{hint}
HTML;
?>
<div class="site-login py-5">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <p class="text-center text-body-secondary mb-4">Please fill out the following fields to login:</p>

            <div class="card border-0 bg-body p-4">

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username', [
                    'options' => ['class' => 'input-group has-validation mb-3'],
                    'template' => sprintf($htmlIcon, '&#128100;'),
                    'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Username', 'autofocus' => true],
                ])->textInput() ?>

                <?= $form->field($model, 'password', [
                    'options' => ['class' => 'input-group has-validation mb-3'],
                    'template' => sprintf($htmlIcon, '&#128274;'),
                    'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Password'],
                ])->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="mb-3">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary px-4', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                <div class="text-body-secondary mt-3">
                    You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
                    To modify the username/password, please check out the code <code>app\models\User::$users</code>.
                </div>

            </div>

        </div>
    </div>
</div>
