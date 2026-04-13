<?php

declare(strict_types=1);

namespace app\tests\unit\models;

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

use app\models\User;
use app\tests\support\Fixtures\UserFixture;
use app\tests\support\UnitTester;
use Yii;
use yii\base\NotSupportedException;

use function strlen;

/**
 * Unit tests for {@see \app\models\User} ActiveRecord identity model.
 */
final class UserTest extends \Codeception\Test\Unit
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

    public function testFindUserById(): void
    {
        $user = User::findIdentity(1);

        verify($user)
            ->notEmpty(
                "Failed asserting that active user with ID '1' exists.",
            );
        verify($user?->username)
            ->equals(
                'admin',
                "Failed asserting that user with ID '1' has username 'admin'.",
            );
        verify(User::findIdentity(999))
            ->empty(
                "Failed asserting that user with non-existing ID '999' returns 'null'.",
            );
    }

    public function testFindUserByPasswordResetToken(): void
    {
        $user = User::findByUsername('okirlin');

        self::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'okirlin' exists.",
        );
        self::assertNotNull(
            $user->password_reset_token,
            "Failed asserting that fixture user 'okirlin' has a password reset token.",
        );

        $token = $user->password_reset_token;

        $foundUser = User::findByPasswordResetToken($token);

        verify($foundUser)
            ->notEmpty(
                "Failed asserting that user is found by a valid 'password reset token'.",
            );
        verify($foundUser?->username)
            ->equals(
                'okirlin',
                "Failed asserting that password reset token resolves to user 'okirlin'.",
            );
        verify(User::findByPasswordResetToken('notexistingtoken_1391882543'))
            ->empty(
                "Failed asserting that an invalid 'password reset token' returns 'null'.",
            );
    }

    public function testFindUserByUsername(): void
    {
        verify(User::findByUsername('okirlin'))
            ->notEmpty(
                "Failed asserting that active user 'okirlin' is found by username.",
            );
        verify(User::findByUsername('not-existing'))
            ->empty(
                "Failed asserting that non-existing username returns 'null'.",
            );
    }

    public function testFindUserByVerificationToken(): void
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

        $foundUser = User::findByVerificationToken($user->verification_token);

        verify($foundUser)
            ->notEmpty(
                'Failed asserting that inactive user is found by verification token.',
            );
        verify($foundUser?->username)
            ->equals(
                'test.test',
                "Failed asserting that verification token resolves to user 'test.test'.",
            );
        verify(User::findByVerificationToken('non_existing_token'))
            ->empty(
                "Failed asserting that a non-existing verification token returns 'null'.",
            );
    }

    public function testGenerateAuthKey(): void
    {
        $user = new User();

        $user->generateAuthKey();

        verify($user->auth_key)
            ->notEmpty(
                'Failed asserting that auth key is generated.',
            );
        verify(strlen($user->auth_key))
            ->equals(
                32,
                "Failed asserting that auth key length is '32' characters.",
            );
    }

    public function testGenerateEmailVerificationToken(): void
    {
        $user = new User();

        $user->generateEmailVerificationToken();

        verify($user->verification_token)
            ->notEmpty(
                'Failed asserting that email verification token is generated.',
            );
        verify(User::isVerificationTokenValid($user->verification_token))
            ->true(
                'Failed asserting that newly generated verification token is valid.',
            );
    }

    public function testGeneratePasswordResetToken(): void
    {
        $user = new User();

        $user->generatePasswordResetToken();

        verify($user->password_reset_token)
            ->notEmpty(
                'Failed asserting that password reset token is generated.',
            );
        verify(User::isPasswordResetTokenValid($user->password_reset_token))
            ->true(
                "Failed asserting that newly generated 'password reset token' is valid.",
            );
    }

    public function testIsPasswordResetTokenValidWithExpiredToken(): void
    {
        $expiredToken = 'somevalidvalue_' . (time() - Yii::$app->params['user.passwordResetTokenExpire'] - 1);

        verify(User::isPasswordResetTokenValid($expiredToken))
            ->false(
                'Failed asserting that an expired password reset token is invalid.',
            );
    }

    public function testIsPasswordResetTokenValidWithMalformedTimestamp(): void
    {
        verify(User::isPasswordResetTokenValid('token_123abc'))
            ->false(
                'Failed asserting that token with non-digit timestamp suffix is invalid.',
            );
        verify(User::isPasswordResetTokenValid('token_'))
            ->false(
                'Failed asserting that token with empty timestamp suffix is invalid.',
            );
    }

    public function testIsPasswordResetTokenValidWithNullToken(): void
    {
        verify(User::isPasswordResetTokenValid(null))
            ->false(
                "Failed asserting that 'null' token is invalid.",
            );
        verify(User::isPasswordResetTokenValid(''))
            ->false(
                "Failed asserting that empty 'token' is invalid.",
            );
    }

    public function testIsPasswordResetTokenValidWithoutUnderscore(): void
    {
        verify(User::isPasswordResetTokenValid('tokenWithoutUnderscore'))
            ->false(
                'Failed asserting that token without underscore separator is invalid.',
            );
    }

    public function testIsVerificationTokenValidWithExpiredToken(): void
    {
        $expiredToken = 'somevalidvalue_' . (time() - Yii::$app->params['user.emailVerificationTokenExpire'] - 1);

        verify(User::isVerificationTokenValid($expiredToken))
            ->false(
                'Failed asserting that expired verification token is invalid.',
            );
    }

    public function testIsVerificationTokenValidWithMalformedTimestamp(): void
    {
        verify(User::isVerificationTokenValid('token_123abc'))
            ->false(
                'Failed asserting that verification token with non-digit timestamp suffix is invalid.',
            );
        verify(User::isVerificationTokenValid('token_'))
            ->false(
                'Failed asserting that verification token with empty timestamp suffix is invalid.',
            );
    }

    public function testIsVerificationTokenValidWithNullToken(): void
    {
        verify(User::isVerificationTokenValid(null))
            ->false(
                "Failed asserting that 'null' verification token is invalid.",
            );
        verify(User::isVerificationTokenValid(''))
            ->false(
                'Failed asserting that empty verification token is invalid.',
            );
    }

    public function testIsVerificationTokenValidWithoutUnderscore(): void
    {
        verify(User::isVerificationTokenValid('tokenWithoutUnderscore'))
            ->false(
                'Failed asserting that verification token without underscore separator is invalid.',
            );
    }

    public function testRemovePasswordResetToken(): void
    {
        $user = User::findByUsername('okirlin');

        self::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'okirlin' exists.",
        );

        $user->removePasswordResetToken();

        verify($user->password_reset_token)
            ->empty(
                'Failed asserting that password reset token is removed.',
            );
    }

    public function testSetPassword(): void
    {
        $user = new User();

        $user->setPassword('new_password');

        verify($user->password_hash)
            ->notEmpty(
                "Failed asserting that password hash is generated after 'setPassword()'.",
            );
        verify($user->validatePassword('new_password'))
            ->true(
                'Failed asserting that the newly set password validates correctly.',
            );
    }

    public function testThrowNotSupportedExceptionWhenFindIdentityByAccessToken(): void
    {
        $this->tester?->expectThrowable(
            NotSupportedException::class,
            static function (): void {
                User::findIdentityByAccessToken('any-token');
            },
        );
    }

    public function testValidateAuthKey(): void
    {
        $user = User::findByUsername('okirlin');

        self::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'okirlin' exists.",
        );

        verify($user->validateAuthKey($user->auth_key))
            ->true(
                'Failed asserting that correct auth key validates successfully.',
            );
        verify($user->validateAuthKey('wrong-auth-key'))
            ->false(
                'Failed asserting that wrong auth key does not validate.',
            );
    }

    public function testValidatePassword(): void
    {
        $user = User::findByUsername('okirlin');

        self::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'okirlin' exists.",
        );

        verify($user->validatePassword('password_0'))
            ->true(
                'Failed asserting that the correct password validates successfully.',
            );
        verify($user->validatePassword('wrong_password'))
            ->false(
                'Failed asserting that a wrong password does not validate.',
            );
    }
}
