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
<?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

<div class="site-contact-success d-flex align-items-center justify-content-center text-center">
    <div class="site-contact-success-content mx-auto">
        <h1 class="display-6 fw-semibold mb-3">Message sent</h1>

        <p class="text-body-secondary mb-4">
            Thank you for contacting us. We will respond to you as soon as possible.
        </p>

        <?php if (YII_DEBUG && Yii::$app->mailer->useFileTransport): ?>
            <p class="text-body-tertiary small mb-4">
                Development mode: email saved under
                <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>
            </p>
        <?php endif; ?>

        <?= Html::a(
            'Send another message',
            ['contact'],
            ['class' => 'btn btn-outline-primary btn-lg'],
        ) ?>
    </div>
</div>

<?php else: ?>

<div class="site-contact py-5">

        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">

                <p class="text-center text-body-secondary mb-4">
                    If you have business inquiries or other questions, please fill out the following form to contact us.
                    Thank you.
                </p>

                <div class="card border-0 bg-body p-4">

                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name', [
                        'inputOptions' => [
                            'class' => 'form-control',
                            'placeholder' => 'Name',
                            'autofocus' => true,
                        ],
                        'options' => ['class' => 'input-group has-validation mb-3'],
                        'template' => sprintf($htmlIcon, '&#128100;'),
                    ]) ?>

                    <?= $form->field($model, 'email', [
                        'inputOptions' => [
                            'class' => 'form-control',
                            'placeholder' => 'Email',
                        ],
                        'options' => ['class' => 'input-group has-validation mb-3'],
                        'template' => sprintf($htmlIcon, '&#9993;'),
                    ]) ?>

                    <?= $form->field($model, 'subject', [
                        'inputOptions' => [
                            'class' => 'form-control',
                            'placeholder' => 'Subject',
                        ],
                        'options' => ['class' => 'input-group has-validation mb-3'],
                        'template' => sprintf($htmlIcon, '&#128172;'),
                    ]) ?>

                    <?= $form->field($model, 'body', [
                        'inputOptions' => [
                            'class' => 'form-control',
                            'placeholder' => 'Body',
                        ],
                        'options' => ['class' => 'form-floating mb-4'],
                        'template' => '{input}{label}{error}{hint}',
                    ])->textarea() ?>

                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <?= $form->field($model, 'verifyCode', [
                            'enableLabel' => false,
                            'options' => ['class' => ''],
                        ])->widget(Captcha::class, [
                            'template' => '<div class="d-flex align-items-center gap-2">{image}{input}</div>',
                        ]) ?>

                        <?= Html::submitButton(
                            'Submit',
                            [
                                'class' => 'btn btn-primary px-4 ms-auto',
                                'name' => 'contact-button',
                            ],
                        ) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
</div>

<?php endif; ?>
