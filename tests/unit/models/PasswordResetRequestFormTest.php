<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\unit\models;

use app\models\PasswordResetRequestForm;
use app\models\User;
use app\tests\support\Fixtures\UserFixture;
use app\tests\support\UnitTester;
use Yii;
use yii\base\Event;
use yii\base\ModelEvent;
use yii\db\BaseActiveRecord;
use yii\mail\MessageInterface;

/**
 * Unit tests for {@see \app\models\PasswordResetRequestForm} model.
 */
final class PasswordResetRequestFormTest extends \Codeception\Test\Unit
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

    public function testNotSendEmailsToInactiveUser(): void
    {
        $model = new PasswordResetRequestForm();

        $model->email = 'troy.becker@example.com';

        verify($model->sendEmail(Yii::$app->mailer, Yii::$app->params['supportEmail'], Yii::$app->name))
            ->false(
                "Failed asserting that sendEmail returns 'false' for an inactive user.",
            );
    }

    public function testSendEmailRegeneratesExpiredToken(): void
    {
        $user = User::findByUsername('okirlin');

        self::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'okirlin' exists.",
        );

        // Set an expired token (timestamp far in the past).
        $user->password_reset_token = 'expiredtoken_1000000000';

        self::assertTrue(
            $user->save(false),
            "Failed asserting that the 'expired token' was persisted.",
        );

        $model = new PasswordResetRequestForm();

        $model->email = $user->email;

        verify($model->sendEmail(Yii::$app->mailer, Yii::$app->params['supportEmail'], Yii::$app->name))
            ->notEmpty(
                'Failed asserting that email is sent after regenerating expired token.',
            );

        $user->refresh();

        verify($user->password_reset_token)
            ->notEquals(
                'expiredtoken_1000000000',
                'Failed asserting that the expired token was replaced with a new one.',
            );
    }

    public function testSendEmailReturnsFalseWhenSaveFails(): void
    {
        $user = User::findByUsername('okirlin');

        self::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'okirlin' exists.",
        );

        // set an expired token so `generatePasswordResetToken()` + `save()` path is triggered.
        $user->password_reset_token = 'expiredtoken_1000000000';

        self::assertTrue(
            $user->save(false),
            'Failed asserting that the expired token was persisted.',
        );

        // force `save()` to fail via `EVENT_BEFORE_SAVE` at the class level.
        $handler = static function (ModelEvent $event): void {
            $event->isValid = false;
        };

        Event::on(User::class, BaseActiveRecord::EVENT_BEFORE_UPDATE, $handler);

        $model = new PasswordResetRequestForm();

        $model->email = $user->email;

        try {
            verify($model->sendEmail(Yii::$app->mailer, Yii::$app->params['supportEmail'], Yii::$app->name))
                ->false(
                    "Failed asserting that sendEmail returns 'false' when user save fails.",
                );
        } finally {
            Event::off(User::class, BaseActiveRecord::EVENT_BEFORE_UPDATE, $handler);
        }
    }

    public function testSendEmailSuccessfully(): void
    {
        $user = User::findByUsername('okirlin');

        self::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'okirlin' exists.",
        );

        $model = new PasswordResetRequestForm();

        $model->email = $user->email;

        verify($model->sendEmail(Yii::$app->mailer, Yii::$app->params['supportEmail'], Yii::$app->name))
            ->notEmpty(
                "Failed asserting that 'password reset' email is sent successfully.",
            );

        $user->refresh();

        verify($user->password_reset_token)
            ->notEmpty(
                "Failed asserting that user has a 'password reset token' after sending.",
            );

        /** @var MessageInterface|null $emailMessage */
        $emailMessage = $this->tester?->grabLastSentEmail();

        verify($emailMessage)
            ->instanceOf(
                MessageInterface::class,
                'Failed asserting that a reset email was captured.',
            );
        verify($emailMessage?->getTo())
            ->arrayHasKey(
                $model->email,
                'Failed asserting that email is sent to the requested address.',
            );
        verify($emailMessage?->getFrom())
            ->arrayHasKey(
                Yii::$app->params['supportEmail'],
                'Failed asserting that email is sent from the support address.',
            );
    }

    public function testSendMessageWithWrongEmailAddress(): void
    {
        $model = new PasswordResetRequestForm();

        $model->email = 'not-existing-email@example.com';

        verify($model->sendEmail(Yii::$app->mailer, Yii::$app->params['supportEmail'], Yii::$app->name))
            ->false(
                "Failed asserting that sendEmail returns 'false' for a non-existing email address.",
            );
    }
}
