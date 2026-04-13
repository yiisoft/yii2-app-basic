<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\unit\models;

use app\models\LoginForm;
use app\tests\support\Fixtures\UserFixture;
use Yii;

/**
 * Unit tests for {@see \app\models\LoginForm} model.
 */
final class LoginFormTest extends \Codeception\Test\Unit
{
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

    public function testLoginCorrect(): void
    {
        $model = new LoginForm(
            [
                'username' => 'okirlin',
                'password' => 'password_0',
            ],
        );

        verify($model->login())
            ->true(
                'Failed asserting that login succeeds with correct credentials.',
            );
        verify(Yii::$app->user->isGuest)
            ->false(
                "Failed asserting that 'user' is no longer a guest after login.",
            );
        verify($model->errors)
            ->arrayHasNotKey(
                'password',
                "Failed asserting that 'password' error does not exist after successful login.",
            );
    }

    public function testLoginDeletedAccount(): void
    {
        $model = new LoginForm(
            [
                'username' => 'troy.becker',
                'password' => 'password_0',
            ],
        );

        verify($model->login())
            ->false(
                'Failed asserting that login fails for a deleted account.',
            );
        verify(Yii::$app->user->isGuest)
            ->true(
                "Failed asserting that 'user' remains a 'guest' after deleted account login attempt.",
            );
    }

    public function testLoginInactiveAccount(): void
    {
        $model = new LoginForm(
            [
                'username' => 'test.test',
                'password' => 'Test1234',
            ],
        );

        verify($model->login())
            ->false(
                'Failed asserting that login fails for an inactive account.',
            );
        verify(Yii::$app->user->isGuest)
            ->true(
                "Failed asserting that 'user' remains a 'guest' after inactive account login attempt.",
            );
    }

    public function testLoginNoUser(): void
    {
        $model = new LoginForm(
            [
                'username' => 'not_existing_username',
                'password' => 'not_existing_password',
            ],
        );

        verify($model->login())
            ->false(
                'Failed asserting that login fails with non-existing username.',
            );
        verify(Yii::$app->user->isGuest)
            ->true(
                "Failed asserting that 'user' remains a 'guest' after failed login.",
            );
    }

    public function testLoginReturnsFalseWhenUserIsNull(): void
    {
        $model = $this->make(
            LoginForm::class,
            [
                'validate' => true,
                'getUser' => null,
            ],
        );

        verify($model->login())
            ->false(
                "Failed asserting that login returns 'false' when user is 'null' after validation.",
            );
    }

    public function testLoginWrongPassword(): void
    {
        $model = new LoginForm(
            [
                'username' => 'okirlin',
                'password' => 'wrong_password',
            ],
        );

        verify($model->login())
            ->false(
                'Failed asserting that login fails with wrong password.',
            );
        verify(Yii::$app->user->isGuest)
            ->true(
                "Failed asserting that 'user' remains a 'guest' after wrong password.",
            );
        verify($model->errors)
            ->arrayHasKey(
                'password',
                "Failed asserting that a 'password' validation error is present.",
            );
    }

    protected function _after(): void
    {
        Yii::$app->user->logout();
    }
}
