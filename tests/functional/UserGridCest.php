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
 * Functional tests for {@see \app\controllers\UserController::actionIndex()} GridView page.
 */
final class UserGridCest
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

    public function checkAdminCanAccessGrid(FunctionalTester $I): void
    {
        $this->loginAsAdmin($I);

        $I->amOnPage(Url::toRoute('/user/index'));
        $I->see('Users', 'h1');
        $I->seeElement('table');
        $I->see('USERNAME');
        $I->see('EMAIL');
        $I->see('STATUS');
        $I->see('JOINED');
    }

    public function checkAdminCanLogout(FunctionalTester $I): void
    {
        $this->loginAsAdmin($I);

        $I->sendAjaxPostRequest(Url::toRoute('/user/logout'));
        $I->amOnPage(Url::toRoute('/'));
        $I->seeLink('Login');
        $I->dontSeeLink('Logout');
    }

    public function checkAdminGridViewDisplaysUserData(FunctionalTester $I): void
    {
        $this->loginAsAdmin($I);

        $I->amOnPage(Url::toRoute('/user/index'));
        $I->see('admin');
        $I->see('admin@example.com');
        $I->see('Active');
    }

    public function checkAdminGridViewFilterByUsername(FunctionalTester $I): void
    {
        $this->loginAsAdmin($I);

        $I->amOnPage(Url::toRoute(['/user/index', 'UserSearch[username]' => 'admin']));
        $I->see('admin');
        $I->dontSee('troy.becker');
    }

    public function checkAdminGridViewFilterWithInvalidData(FunctionalTester $I): void
    {
        $this->loginAsAdmin($I);

        $I->amOnPage(Url::toRoute(['/user/index', 'UserSearch[id]' => 'invalid']));
        $I->see('No results found.', '.empty');
    }

    public function checkGuestRedirectsToLogin(FunctionalTester $I): void
    {
        $I->amOnPage(Url::toRoute('/user/index'));
        $I->seeInCurrentUrl('user%2Flogin');
    }

    public function checkNonAdminCannotAccessGrid(FunctionalTester $I): void
    {
        $I->amOnPage(Url::toRoute('/user/login'));
        $I->submitForm(
            '#login-form',
            [
                'LoginForm[username]' => 'okirlin',
                'LoginForm[password]' => 'password_0',
            ],
        );

        $I->amOnPage(Url::toRoute('/user/index'));
        $I->seeResponseCodeIs(403);
    }

    private function loginAsAdmin(FunctionalTester $I): void
    {
        $I->amOnPage(Url::toRoute('/user/login'));
        $I->submitForm(
            '#login-form',
            [
                'LoginForm[username]' => 'admin',
                'LoginForm[password]' => 'password_0',
            ],
        );
    }
}
