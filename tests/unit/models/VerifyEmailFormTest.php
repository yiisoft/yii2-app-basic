<?php

declare(strict_types=1);

namespace app\tests\unit\models;

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

use app\models\User;
use app\models\VerifyEmailForm;
use app\tests\support\Fixtures\UserFixture;
use app\tests\support\UnitTester;
use ReflectionProperty;
use yii\base\InvalidArgumentException;

/**
 * Unit tests for {@see \app\models\VerifyEmailForm} model.
 */
final class VerifyEmailFormTest extends \Codeception\Test\Unit
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

    public function testThrowInvalidArgumentExceptionWhenTokenBelongsToActiveUser(): void
    {
        $user = User::findOne(['username' => 'test2.test']);

        verify($user)
            ->notEmpty(
                "Failed asserting that fixture user 'test2.test' exists.",
            );
        verify($user->verification_token ?? null)
            ->notEmpty(
                "Failed asserting that fixture user 'test2.test' has a verification token.",
            );

        /** @var string $token */
        $token = $user->verification_token ?? '';

        $this->tester?->expectThrowable(
            InvalidArgumentException::class,
            static function () use ($token): void {
                new VerifyEmailForm($token);
            },
        );
    }

    public function testThrowInvalidArgumentExceptionWhenTokenIsEmptyOrInvalid(): void
    {
        $this->tester?->expectThrowable(
            InvalidArgumentException::class,
            static function (): void {
                new VerifyEmailForm('');
            },
        );
        $this->tester?->expectThrowable(
            InvalidArgumentException::class,
            static function (): void {
                new VerifyEmailForm('notexistingtoken_1391882543');
            },
        );
    }

    public function testVerifyCorrectToken(): void
    {
        $user = User::findOne(['username' => 'test.test']);

        self::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'test.test' exists.",
        );
        self::assertNotNull(
            $user->verification_token,
            "Failed asserting that fixture user 'test.test' has a verification token.",
        );

        $model = new VerifyEmailForm($user->verification_token);

        $user = $model->verifyEmail();

        verify($user)
            ->instanceOf(
                User::class,
                "Failed asserting that 'verifyEmail()' returns a User instance.",
            );

        $user?->refresh();

        verify($user?->username)
            ->equals(
                'test.test',
                "Failed asserting that verified user has username 'test.test'.",
            );
        verify($user?->email)
            ->equals(
                'test.test@example.com',
                "Failed asserting that verified user has email 'test.test@example.com'.",
            );
        verify($user?->status)
            ->equals(
                User::STATUS_ACTIVE,
                'Failed asserting that verified user status is ACTIVE.',
            );
        verify($user?->verification_token)
            ->null(
                'Failed asserting that verification token is cleared after verification.',
            );
        verify($user?->validatePassword('Test1234'))
            ->true(
                "Failed asserting that verified 'user password' still validates correctly.",
            );
    }

    public function testVerifyEmailReturnsNullWhenUserIsNull(): void
    {
        $user = User::findOne(['username' => 'test.test']);

        self::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'test.test' exists.",
        );
        self::assertNotNull(
            $user->verification_token,
            "Failed asserting that fixture user 'test.test' has a verification token.",
        );

        $form = new VerifyEmailForm($user->verification_token);
        $reflection = new ReflectionProperty($form, 'user');

        $reflection->setValue($form, null);

        verify($form->verifyEmail())
            ->null(
                "Failed asserting that verifyEmail returns 'null' when user is 'null'.",
            );
    }
}
