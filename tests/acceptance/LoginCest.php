<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\acceptance;

use app\tests\support\AcceptanceTester;
use app\tests\support\Fixtures\UserFixture;
use yii\helpers\Url;

/**
 * Acceptance tests for the login page.
 */
final class LoginCest
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
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
        ];
    }

    public function ensureThatLoginWorks(AcceptanceTester $I): void
    {
        $I->amOnPage(Url::toRoute('/user/login'));
        $I->see('Login', 'h1');

        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('input[name="LoginForm[username]"]', 'erau');
        $I->fillField('input[name="LoginForm[password]"]', 'password_0');
        $I->click('button[name="login-button"]');

        $I->expectTo('see user info');
        $I->see('Logout');
    }
}
