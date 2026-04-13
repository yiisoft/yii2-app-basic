<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\controllers;

use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResendVerificationEmailForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\UserSearch;
use app\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\mail\MailerInterface;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

/**
 * Handles user-related actions: login, logout, signup, password recovery, email verification, and user listing.
 */
final class UserController extends Controller
{
    public function __construct($id, $module, private readonly MailerInterface $mailer, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    /**
     * Displays user list with GridView.
     */
    public function actionIndex(): string
    {
        $searchModel = new UserSearch();

        /** @var array<string, mixed> $queryParams */
        $queryParams = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($queryParams);

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ],
        );
    }

    /**
     * Login action.
     */
    public function actionLogin(): Response|string
    {
        $model = new LoginForm();

        /** @var array<string, mixed> $post */
        $post = $this->request->post();

        if ($model->load($post) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logout action.
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Requests password reset.
     */
    public function actionRequestPasswordReset(): Response|string
    {
        $model = new PasswordResetRequestForm();

        /** @var array<string, mixed> $post */
        $post = $this->request->post();
        $params = Yii::$app->params;

        if ($model->load($post) && $model->validate()) {
            $sent = $model->sendEmail(
                $this->mailer,
                $params['supportEmail'],
                Yii::$app->name,
            );

            if ($sent) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash(
                'error',
                'Sorry, we are unable to reset password for the provided email address.',
            );
        }

        return $this->render('requestPasswordResetToken', ['model' => $model]);
    }

    /**
     * Resends verification email.
     */
    public function actionResendVerificationEmail(): Response|string
    {
        $model = new ResendVerificationEmailForm();

        /** @var array<string, mixed> $post */
        $post = $this->request->post();
        $params = Yii::$app->params;

        if ($model->load($post) && $model->validate()) {
            $sent = $model->sendEmail(
                $this->mailer,
                $params['supportEmail'],
                Yii::$app->name,
            );

            if ($sent) {
                Yii::$app->session->setFlash(
                    'success',
                    'Check your email for further instructions.',
                );

                return $this->goHome();
            }

            Yii::$app->session->setFlash(
                'error',
                'Sorry, we are unable to resend verification email for the provided email address.',
            );
        }

        return $this->render('resendVerificationEmail', ['model' => $model]);
    }

    /**
     * Resets password.
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword(string $token): Response|string
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        /** @var array<string, mixed> $post */
        $post = $this->request->post();

        if ($model->load($post) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash(
                'success',
                'New password saved.',
            );

            return $this->goHome();
        }

        return $this->render('resetPassword', ['model' => $model]);
    }

    /**
     * Signs user up.
     */
    public function actionSignup(): Response|string
    {
        $model = new SignupForm();

        /** @var array<string, mixed> $post */
        $post = $this->request->post();
        $params = Yii::$app->params;

        $signed = $model->load($post) && $model->signup(
            $this->mailer,
            $params['supportEmail'],
            Yii::$app->name,
        ) === true;

        if ($signed) {
            Yii::$app->session->setFlash(
                'success',
                'Thank you for registration. Please check your inbox for verification email.',
            );

            return $this->goHome();
        }

        return $this->render('signup', ['model' => $model]);
    }

    /**
     * Verifies email address.
     *
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail(string $token): Response
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->verifyEmail() !== null) {
            Yii::$app->session->setFlash(
                'success',
                'Your email has been confirmed!',
            );

            return $this->goHome();
        }

        Yii::$app->session->setFlash(
            'error',
            'Sorry, we are unable to verify your account with provided token.',
        );

        return $this->goHome();
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'index',
                    'login',
                    'logout',
                    'request-password-reset',
                    'resend-verification-email',
                    'reset-password',
                    'signup',
                    'verify-email',
                ],
                'rules' => [
                    [
                        'actions' => [
                            'login',
                            'request-password-reset',
                            'resend-verification-email',
                            'reset-password',
                            'signup',
                            'verify-email',
                        ],
                        'allow' => true,
                        'roles' => [
                            '?',
                        ],
                    ],
                    [
                        'actions' => [
                            'index',
                        ],
                        'allow' => true,
                        'roles' => [
                            'admin',
                        ],
                    ],
                    [
                        'actions' => [
                            'logout',
                        ],
                        'allow' => true,
                        'roles' => [
                            '@',
                        ],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => [
                        'get',
                    ],
                    'logout' => [
                        'post',
                    ],
                ],
            ],
        ];
    }
}
