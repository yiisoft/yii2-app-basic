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
 * Functional tests for {@see \app\controllers\UserController::actionResendVerificationEmail()}.
 */
final class ResendVerificationEmailCest
{
    private string $formId = '#resend-verification-email-form';

    public function _before(FunctionalTester $I): void
    {
        $I->amOnPage(Url::toRoute('/user/resend-verification-email'));
    }

    /**
     * @return array{user: array{class: string, dataFile: string}}
     */
    public function _fixtures(): array
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                // @phpstan-ignore-next-line
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ];
    }

    public function checkAlreadyVerifiedEmail(FunctionalTester $I): void
    {
        $I->submitForm(
            $this->formId,
            ['ResendVerificationEmailForm[email]' => 'test2.test@example.com'],
        );
        $I->see('There is no user with this email address.', '.invalid-feedback');
    }

    public function checkEmptyField(FunctionalTester $I): void
    {
        $I->submitForm(
            $this->formId,
            ['ResendVerificationEmailForm[email]' => ''],
        );
        $I->see('Email cannot be blank.', '.invalid-feedback');
    }

    public function checkPage(FunctionalTester $I): void
    {
        $I->see('Resend verification email', 'h1');
        $I->see('Enter your email to receive a new verification link');
    }

    public function checkResendWithExpiredTokenGeneratesNewToken(FunctionalTester $I): void
    {
        $user = User::findOne(['username' => 'test.test']);

        Assert::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'test.test' exists.",
        );

        // set an expired verification token.
        $user->verification_token = 'expiredtoken_1000000000';

        Assert::assertTrue(
            $user->save(false),
            "Failed asserting that the 'expired' verification 'token' was persisted.",
        );

        verify(User::isVerificationTokenValid($user->verification_token))
            ->false('Failed asserting that the token is expired before resend.');

        $I->submitForm(
            $this->formId,
            ['ResendVerificationEmailForm[email]' => 'test.test@example.com'],
        );
        $I->canSeeEmailIsSent();
        $I->see('Check your email for further instructions.');

        $user->refresh();

        verify(User::isVerificationTokenValid($user->verification_token))
            ->true('Failed asserting that a fresh verification token was generated after resend.');
        verify($user->verification_token)
            ->notEquals(
                'expiredtoken_1000000000',
                'Failed asserting that the expired token was replaced.',
            );
    }

    public function checkSendFailsWhenMailerErrors(FunctionalTester $I): void
    {
        $user = User::findOne(['username' => 'test.test']);

        Assert::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'test.test' exists.",
        );

        $originalToken = $user->verification_token;

        // force mailer `send()` to fail via `EVENT_BEFORE_SEND`.
        $handler = static function (MailEvent $event): void {
            $event->isValid = false;
        };

        Yii::$app->mailer->on(BaseMailer::EVENT_BEFORE_SEND, $handler);

        try {
            $I->submitForm(
                $this->formId,
                ['ResendVerificationEmailForm[email]' => 'test.test@example.com'],
            );
            $I->see('Sorry, we are unable to resend verification email for the provided email address.');

            $user->refresh();

            verify($user->verification_token)
                ->equals(
                    $originalToken,
                    'Failed asserting that resend failure leaves the existing verification token untouched.',
                );
        } finally {
            Yii::$app->mailer->off(BaseMailer::EVENT_BEFORE_SEND, $handler);
        }
    }

    public function checkSendSuccessfully(FunctionalTester $I): void
    {
        $I->submitForm(
            $this->formId,
            ['ResendVerificationEmailForm[email]' => 'test.test@example.com'],
        );
        $I->canSeeEmailIsSent();
        $I->seeRecord(
            User::class,
            [
                'email' => 'test.test@example.com',
                'username' => 'test.test',
                'status' => User::STATUS_INACTIVE,
            ],
        );
        $I->see('Check your email for further instructions.');
    }

    public function checkWrongEmail(FunctionalTester $I): void
    {
        $I->submitForm(
            $this->formId,
            ['ResendVerificationEmailForm[email]' => 'wrong@email.com'],
        );
        $I->see('There is no user with this email address.', '.invalid-feedback');
    }

    public function checkWrongEmailFormat(FunctionalTester $I): void
    {
        $I->submitForm(
            $this->formId,
            ['ResendVerificationEmailForm[email]' => 'abcd.com'],
        );
        $I->see('Email is not a valid email address.', '.invalid-feedback');
    }
}
