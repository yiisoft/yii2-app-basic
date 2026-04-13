<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\functional;

use app\models\User;
use app\tests\support\Fixtures\UserFixture;
use app\tests\support\FunctionalTester;
use PHPUnit\Framework\Assert;
use Yii;
use yii\helpers\Url;
use yii\mail\BaseMailer;
use yii\mail\MailEvent;

/**
 * Functional tests for {@see \app\controllers\UserController::actionRequestPasswordReset()} and
 * {@see \app\controllers\UserController::actionResetPassword()}.
 */
final class PasswordResetCest
{
    /**
     * @return array{user: array{class: string, dataFile: string}}
     */
    public function _fixtures(): array
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                // @phpstan-ignore binaryOp.invalid
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ];
    }

    public function requestResetFailsWhenMailerErrors(FunctionalTester $I): void
    {
        // force mailer `send()` to fail via `EVENT_BEFORE_SEND`.
        $handler = static function (MailEvent $event): void {
            $event->isValid = false;
        };

        Yii::$app->mailer->on(BaseMailer::EVENT_BEFORE_SEND, $handler);

        try {
            $I->amOnPage(Url::toRoute('/user/request-password-reset'));
            $I->submitForm(
                '#request-password-reset-form',
                ['PasswordResetRequestForm[email]' => 'okirlin@example.com'],
            );
            $I->see('Sorry, we are unable to reset password for the provided email address.');
        } finally {
            Yii::$app->mailer->off(BaseMailer::EVENT_BEFORE_SEND, $handler);
        }
    }

    public function requestResetSuccessfully(FunctionalTester $I): void
    {
        $I->amOnPage(Url::toRoute('/user/request-password-reset'));
        $I->submitForm(
            '#request-password-reset-form',
            ['PasswordResetRequestForm[email]' => 'okirlin@example.com'],
        );
        $I->seeEmailIsSent();
        $I->see('Check your email for further instructions.');
    }

    public function requestResetWithEmptyEmail(FunctionalTester $I): void
    {
        $I->amOnPage(Url::toRoute('/user/request-password-reset'));
        $I->see('Reset your password', 'h1');
        $I->submitForm(
            '#request-password-reset-form',
            [],
        );
        $I->see('Email cannot be blank.', '.invalid-feedback');
    }

    public function requestResetWithWrongEmail(FunctionalTester $I): void
    {
        $I->amOnPage(Url::toRoute('/user/request-password-reset'));
        $I->submitForm(
            '#request-password-reset-form',
            ['PasswordResetRequestForm[email]' => 'nonexistent@example.com'],
        );
        $I->see('There is no user with this email address.', '.invalid-feedback');
    }

    public function resetPasswordWithInvalidToken(FunctionalTester $I): void
    {
        $I->amOnPage(Url::toRoute(['/user/reset-password', 'token' => 'invalid_token_123']));
        $I->canSee('Wrong password reset token.');
    }

    public function resetPasswordWithValidToken(FunctionalTester $I): void
    {
        $user = User::findByUsername('okirlin');

        Assert::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'okirlin' exists.",
        );
        Assert::assertNotNull(
            $user->password_reset_token,
            "Failed asserting that fixture user 'okirlin' has a 'password reset token'.",
        );

        $token = $user->password_reset_token;

        $I->amOnPage(Url::toRoute(['/user/reset-password', 'token' => $token]));
        $I->see('Set your new password', 'h1');
        $I->submitForm(
            '#reset-password-form',
            ['ResetPasswordForm[password]' => 'newpassword123'],
        );
        $I->see('New password saved.');
    }
}
