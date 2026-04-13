<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\functional;

use app\tests\support\Fixtures\UserFixture;
use app\tests\support\FunctionalTester;
use yii\helpers\Url;

/**
 * Functional tests for {@see \app\controllers\UserController::actionLogin()} login form.
 */
final class LoginFormCest
{
    public function _before(FunctionalTester $I): void
    {
        $I->amOnPage(Url::toRoute('/user/login'));
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
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
        ];
    }

    public function checkEmpty(FunctionalTester $I): void
    {
        $I->submitForm(
            '#login-form',
            [],
        );
        $I->see('Username cannot be blank.', '.invalid-feedback');
        $I->see('Password cannot be blank.', '.invalid-feedback');
    }

    public function checkInactiveAccount(FunctionalTester $I): void
    {
        $I->submitForm(
            '#login-form',
            [
                'LoginForm[username]' => 'test.test',
                'LoginForm[password]' => 'Test1234',
            ],
        );
        $I->see('Incorrect username or password.', '.invalid-feedback');
    }

    public function checkValidLogin(FunctionalTester $I): void
    {
        $I->submitForm(
            '#login-form',
            [
                'LoginForm[username]' => 'erau',
                'LoginForm[password]' => 'password_0',
            ],
        );
        $I->seeLink('Logout (erau)');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }

    public function checkWrongPassword(FunctionalTester $I): void
    {
        $I->submitForm(
            '#login-form',
            [
                'LoginForm[username]' => 'erau',
                'LoginForm[password]' => 'wrong',
            ],
        );
        $I->see('Incorrect username or password.', '.invalid-feedback');
    }
}
