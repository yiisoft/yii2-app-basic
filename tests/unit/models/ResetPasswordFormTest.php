<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\unit\models;

use app\models\ResetPasswordForm;
use app\models\User;
use app\tests\support\Fixtures\UserFixture;
use app\tests\support\UnitTester;
use ReflectionProperty;
use yii\base\InvalidArgumentException;

/**
 * Unit tests for {@see \app\models\ResetPasswordForm} model.
 */
final class ResetPasswordFormTest extends \Codeception\Test\Unit
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
                // @phpstan-ignore binaryOp.invalid
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ];
    }

    public function testResetCorrectToken(): void
    {
        $user = User::findByUsername('okirlin');

        self::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'okirlin' exists.",
        );
        self::assertNotNull(
            $user->password_reset_token,
            "Failed asserting that fixture user 'okirlin' has a 'password reset token'.",
        );

        $token = $user->password_reset_token;

        $form = new ResetPasswordForm($token);

        $form->password = 'new_password_123';

        verify($form->resetPassword())
            ->notEmpty(
                'Failed asserting that password reset succeeds with a valid token and password.',
            );

        $user->refresh();

        verify($user->password_reset_token)
            ->null(
                'Failed asserting that password reset token is cleared after reset.',
            );
        verify($user->validatePassword('new_password_123'))
            ->true(
                'Failed asserting that the new password validates after reset.',
            );
    }

    public function testResetPasswordReturnsFalseWhenUserIsNull(): void
    {
        $user = User::findByUsername('okirlin');

        self::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'okirlin' exists.",
        );
        self::assertNotNull(
            $user->password_reset_token,
            "Failed asserting that fixture user 'okirlin' has a 'password reset token'.",
        );

        $token = $user->password_reset_token;

        $form = new ResetPasswordForm($token);

        $reflection = new ReflectionProperty($form, 'user');

        $reflection->setValue($form, null);

        verify($form->resetPassword())
            ->false(
                "Failed asserting that resetPassword returns 'false' when user is 'null'.",
            );
    }

    public function testThrowInvalidArgumentExceptionWhenTokenIsEmptyOrInvalid(): void
    {
        $this->tester?->expectThrowable(
            InvalidArgumentException::class,
            static function (): void {
                new ResetPasswordForm('');
            },
        );
        $this->tester?->expectThrowable(
            InvalidArgumentException::class,
            static function (): void {
                new ResetPasswordForm('notexistingtoken_1391882543');
            },
        );
    }
}
