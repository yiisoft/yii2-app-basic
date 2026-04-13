<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\unit\models;

use app\models\SignupForm;
use app\models\User;
use app\tests\support\Fixtures\UserFixture;
use app\tests\support\UnitTester;
use RuntimeException;
use Yii;
use yii\base\Event;
use yii\base\ModelEvent;
use yii\db\BaseActiveRecord;
use yii\mail\BaseMailer;
use yii\mail\MailEvent;
use yii\mail\MessageInterface;

/**
 * Unit tests for {@see \app\models\SignupForm} model.
 */
final class SignupFormTest extends \Codeception\Test\Unit
{
    protected UnitTester|null $tester = null;

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

    public function testCorrectSignup(): void
    {
        $model = new SignupForm(
            [
                'username' => 'some_username',
                'email' => 'some_email@example.com',
                'password' => 'some_password',
            ],
        );

        $user = $model->signup(Yii::$app->mailer, Yii::$app->params['supportEmail'], Yii::$app->name);

        verify($user)
            ->notEmpty(
                'Failed asserting that signup returns a truthy value on success.',
            );

        $user = $this->tester?->grabRecord(
            User::class,
            [
                'username' => 'some_username',
                'email' => 'some_email@example.com',
                'status' => User::STATUS_INACTIVE,
            ],
        );

        self::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that 'signup' persisted an 'inactive' user.",
        );
        self::assertNotNull(
            $user->verification_token,
            'Failed asserting that the persisted user has a verification token.',
        );
        self::assertNotEmpty(
            $user->verification_token,
            "Failed asserting that the persisted user verification 'token' is not empty.",
        );

        $this->tester?->seeEmailIsSent();

        /** @var MessageInterface|null $mail */
        $mail = $this->tester?->grabLastSentEmail();

        verify($mail)
            ->instanceOf(
                MessageInterface::class,
                'Failed asserting that a verification email was sent.',
            );
        verify($mail?->getTo())
            ->arrayHasKey(
                'some_email@example.com',
                'Failed asserting that email is sent to the registered address.',
            );
        verify($mail?->getFrom())
            ->arrayHasKey(
                Yii::$app->params['supportEmail'],
                'Failed asserting that email is sent from the support address.',
            );
        verify($mail?->getSubject())
            ->equals(
                'Account registration at ' . Yii::$app->name,
                'Failed asserting that email subject matches the registration template.',
            );
        /** @var \yii\symfonymailer\Message $mail */
        verify($mail->getSymfonyEmail()->getTextBody())
            ->stringContainsString(
                $user->verification_token,
                'Failed asserting that email body contains the verification token.',
            );
    }

    public function testNotCorrectSignup(): void
    {
        $model = new SignupForm(
            [
                'username' => 'troy.becker',
                'email' => 'troy.becker@example.com',
                'password' => 'some_password',
            ],
        );

        verify($model->signup(Yii::$app->mailer, Yii::$app->params['supportEmail'], Yii::$app->name))
            ->empty(
                'Failed asserting that signup fails with duplicate username and email.',
            );
        verify($model->getErrors('username'))
            ->notEmpty(
                'Failed asserting that a username validation error is present.',
            );
        verify($model->getErrors('email'))
            ->notEmpty(
                'Failed asserting that an email validation error is present.',
            );
        verify($model->getFirstError('username'))
            ->equals(
                'This username has already been taken.',
                'Failed asserting that the username uniqueness error message is correct.',
            );
        verify($model->getFirstError('email'))
            ->equals(
                'This email address has already been taken.',
                'Failed asserting that the email uniqueness error message is correct.',
            );
    }

    public function testSignupReturnsFalseWhenSaveFails(): void
    {
        $handler = static function (ModelEvent $event): void {
            $event->isValid = false;
        };

        Event::on(User::class, BaseActiveRecord::EVENT_BEFORE_INSERT, $handler);

        $model = new SignupForm(
            [
                'username' => 'save_fail_user',
                'email' => 'save_fail@example.com',
                'password' => 'some_password',
            ],
        );

        try {
            verify($model->signup(Yii::$app->mailer, Yii::$app->params['supportEmail'], Yii::$app->name))
                ->false(
                    "Failed asserting that signup returns 'false' when user save fails.",
                );
        } finally {
            Event::off(User::class, BaseActiveRecord::EVENT_BEFORE_INSERT, $handler);
        }

        verify(User::findOne(['username' => 'save_fail_user']))
            ->null(
                'Failed asserting that user was not persisted after rollback.',
            );
    }

    public function testSignupReturnsFalseWhenSendEmailFails(): void
    {
        $handler = static function (MailEvent $event): void {
            $event->isValid = false;
        };

        Yii::$app->mailer->on(BaseMailer::EVENT_BEFORE_SEND, $handler);

        $model = new SignupForm(
            [
                'username' => 'email_fail_user',
                'email' => 'email_fail@example.com',
                'password' => 'some_password',
            ],
        );

        try {
            verify($model->signup(Yii::$app->mailer, Yii::$app->params['supportEmail'], Yii::$app->name))
                ->false(
                    "Failed asserting that signup returns 'false' when email sending fails.",
                );
        } finally {
            Yii::$app->mailer->off(BaseMailer::EVENT_BEFORE_SEND, $handler);
        }

        verify(User::findOne(['username' => 'email_fail_user']))
            ->null(
                'Failed asserting that user was rolled back after email failure.',
            );
    }

    public function testThrowRuntimeExceptionWhenMailerFailsDuringSignup(): void
    {
        $handler = static function (): void {
            throw new RuntimeException('Mailer transport failure');
        };

        Yii::$app->mailer->on(BaseMailer::EVENT_BEFORE_SEND, $handler);

        $model = new SignupForm(
            [
                'username' => 'exception_user',
                'email' => 'exception@example.com',
                'password' => 'some_password',
            ],
        );

        try {
            verify($model->signup(Yii::$app->mailer, Yii::$app->params['supportEmail'], Yii::$app->name))
                ->false(
                    "Failed asserting that signup returns 'false' when mailer throws exception.",
                );
        } finally {
            Yii::$app->mailer->off(BaseMailer::EVENT_BEFORE_SEND, $handler);
        }

        verify(User::findOne(['username' => 'exception_user']))
            ->null(
                'Failed asserting that user was rolled back after mailer exception.',
            );
    }
}
