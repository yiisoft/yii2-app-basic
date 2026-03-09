<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
$htmlIcon = <<<HTML
<span class="input-group-text">%s</span>
<div class="form-floating flex-grow-1">{input}{label}</div>{error}{hint}
HTML;
?>
<div class="site-contact py-5">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Thank you for contacting us. We will respond to you as soon as possible.
        </div>

        <p>
            Note that if you turn on the Yii debugger, you should be able
            to view the mail message on the mail panel of the debugger.
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Because the application is in development mode, the email is not sent but saved as
                a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                application component to be false to enable email sending.
            <?php endif; ?>
        </p>

    <?php else: ?>

        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">

                <p class="text-center text-body-secondary mb-4">
                    If you have business inquiries or other questions, please fill out the following form to contact us.
                    Thank you.
                </p>

                <div class="card border-0 bg-body p-4">

                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name', [
                        'options' => ['class' => 'input-group has-validation mb-3'],
                        'template' => sprintf($htmlIcon, '&#128100;'),
                        'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Name', 'autofocus' => true],
                    ])->textInput() ?>

                    <?= $form->field($model, 'email', [
                        'options' => ['class' => 'input-group has-validation mb-3'],
                        'template' => sprintf($htmlIcon, '&#9993;'),
                        'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Email'],
                    ]) ?>

                    <?= $form->field($model, 'subject', [
                        'options' => ['class' => 'input-group has-validation mb-3'],
                        'template' => sprintf($htmlIcon, '&#128172;'),
                        'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Subject'],
                    ]) ?>

                    <?= $form->field($model, 'body', [
                        'options' => ['class' => 'form-floating mb-4'],
                        'template' => '{input}{label}{error}{hint}',
                        'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Body'],
                    ])->textarea() ?>

                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <?= $form->field($model, 'verifyCode', [
                            'enableLabel' => false,
                            'options' => ['class' => ''],
                        ])->widget(Captcha::class, [
                            'template' => '<div class="d-flex align-items-center gap-2">{image}{input}</div>',
                        ]) ?>

                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary px-4 ms-auto', 'name' => 'contact-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>

    <?php endif; ?>
</div>
