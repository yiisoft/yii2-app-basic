<?php

declare(strict_types=1);

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;
use yii\widgets\MaskedInput;

/**
 * @var yii\bootstrap5\ActiveForm $form active form instance.
 * @var app\models\ContactForm $model contact form model instance.
 * @var yii\web\View $this view component instance.
 *
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */
$this->title = 'Contact us';
$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = 'Get in touch with us. Send us a message using the contact form.';
$htmlIcon = <<<HTML
{label}<div class="input-group"><span class="input-group-text" aria-hidden="true">%s</span>{input}</div>{error}{hint}
HTML;
$labelOptions = ['class' => 'form-label fw-semibold small'];
?>
<?php if (Yii::$app->session->getFlash('success') !== null): ?>

<div class="site-contact-success d-flex align-items-center justify-content-center py-2">
    <div class="card border-0 overflow-hidden login-split-card">
        <div class="row g-0">

            <!-- Brand panel -->
            <div class="col-md-5 d-none d-md-flex login-brand-panel text-white">
                <div class="d-flex flex-column justify-content-between p-4 p-lg-5 w-100">
                    <div>
                        <?= Html::img(
                            Yii::getAlias('@web/images/yii3_full_white_for_dark.svg'),
                            [
                                'alt' => 'Yii Framework',
                                'class' => 'mb-4',
                                'height' => 40,
                            ],
                        ) ?>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-3 login-brand-title">
                            Message<br>received.
                        </h2>
                        <p class="opacity-75 mb-0 login-brand-text">
                            Thanks for reaching out. We will reply as soon as we can.
                        </p>
                    </div>
                    <div class="mt-4">
                        <span class="brand-meta">YII2</span>
                        <span class="brand-meta-dot">&middot;</span>
                        <span class="brand-meta">JQUERY</span>
                        <span class="brand-meta-dot">&middot;</span>
                        <span class="brand-meta">BOOTSTRAP5</span>
                    </div>
                </div>
            </div>

            <!-- Confirmation panel -->
            <div class="col-md-7">
                <div class="p-4 p-lg-5 d-flex flex-column justify-content-center h-100">
                    <div class="contact-success-eyebrow mb-3">
                        <span>Message sent</span>
                    </div>

                    <h1 class="h2 fw-bold mb-2">Thanks, we got it.</h1>
                    <p class="text-body-secondary mb-4">We will reply as soon as we can.</p>

                    <p class="text-body-secondary small mb-4">
                        Your message has been delivered to the team. Want to send another note?
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
                        ['class' => 'btn login-btn text-white w-100 py-2'],
                    ) ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php else: ?>

<div class="site-contact d-flex align-items-center justify-content-center py-2">
    <div class="card border-0 overflow-hidden login-split-card login-split-card-wide">
        <div class="row g-0">

            <!-- Brand panel -->
            <div class="col-md-4 d-none d-md-flex login-brand-panel text-white">
                <div class="d-flex flex-column justify-content-between p-4 p-lg-5 w-100">
                    <div>
                        <?= Html::img(
                            Yii::getAlias('@web/images/yii3_full_white_for_dark.svg'),
                            [
                                'alt' => 'Yii Framework',
                                'class' => 'mb-4',
                                'height' => 40,
                            ],
                        ) ?>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-3 login-brand-title">
                            Get In<br>Touch
                        </h2>
                        <p class="opacity-75 mb-0 login-brand-text">
                            Have a question or business inquiry? We would love to hear from you.
                        </p>
                    </div>
                    <div class="mt-4">
                        <span class="brand-meta">YII2</span>
                        <span class="brand-meta-dot">&middot;</span>
                        <span class="brand-meta">JQUERY</span>
                        <span class="brand-meta-dot">&middot;</span>
                        <span class="brand-meta">BOOTSTRAP5</span>
                    </div>
                </div>
            </div>

            <!-- Form panel -->
            <div class="col-md-8">
                <div class="p-4 p-lg-5">
                    <div class="text-center mb-4">
                        <h1 class="h3 fw-bold mb-1"><?= Html::encode($this->title) ?></h1>
                        <p class="text-body-secondary small">Fill out the form below and we will get back to you</p>
                    </div>

                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <div class="row">
                        <div class="col-sm-6 mb-2">
                            <?= $form->field($model, 'name', [
                                'options' => ['class' => 'mb-0'],
                                'template' => sprintf($htmlIcon, '&#128100;'),
                                'inputOptions' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'Name',
                                    'autofocus' => true,
                                ],
                            ])->label('Your Name', $labelOptions) ?>
                        </div>

                        <div class="col-sm-6 mb-2">
                            <?= $form->field($model, 'email', [
                                'options' => ['class' => 'mb-0'],
                                'template' => sprintf($htmlIcon, '&#9993;'),
                                'inputOptions' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'email@example.com',
                                ],
                            ])->label('Your Email', $labelOptions) ?>
                        </div>
                    </div>

                    <div class="mb-2">
                        <?= $form->field($model, 'phone', [
                            'options' => ['class' => 'mb-0'],
                            'template' => sprintf($htmlIcon, '&#128222;'),
                            'inputOptions' => [
                                'class' => 'form-control',
                            ],
                        ])->widget(MaskedInput::class, [
                            'mask' => '(999) 999-9999',
                        ])->label('Phone', $labelOptions) ?>
                    </div>

                    <div class="mb-2">
                        <?= $form->field($model, 'subject', [
                            'options' => ['class' => 'mb-0'],
                            'template' => sprintf($htmlIcon, '&#128172;'),
                            'inputOptions' => [
                                'class' => 'form-control',
                                'placeholder' => 'Subject',
                            ],
                        ])->label('Subject', $labelOptions) ?>
                    </div>

                    <div class="mb-2">
                        <?= $form->field($model, 'body', [
                            'options' => ['class' => 'mb-0'],
                            'template' => '{label}{input}{error}{hint}',
                            'inputOptions' => [
                                'class' => 'form-control',
                                'placeholder' => 'Your message...',
                            ],
                        ])->textarea()->label('Message', $labelOptions) ?>
                    </div>

                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <?= $form->field($model, 'verifyCode', [
                            'enableLabel' => false,
                            'options' => ['class' => ''],
                            'inputOptions' => ['aria-label' => 'Verification code'],
                        ])->widget(Captcha::class, [
                            'template' => '<div class="d-flex align-items-center gap-2">{image}{input}</div>',
                        ]) ?>

                        <?= Html::submitButton(
                            'Submit',
                            [
                                'class' => 'btn login-btn text-white px-3 ms-auto',
                                'name' => 'contact-button',
                            ],
                        ) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>

        </div>
    </div>
</div>

<?php endif; ?>
