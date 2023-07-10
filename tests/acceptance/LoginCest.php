<?php

declare(strict_types=1);

use yii\helpers\Url;

final class LoginCest
{
    public function ensureThatLoginWorks(AcceptanceTester $I): void
    {
        $I->amOnPage(Url::toRoute('/site/login'));
        $I->see('Login', 'h1');

        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->fillField('input[name="LoginForm[password]"]', 'admin');
        $I->click('login-button');

        $I->expectTo('see user info');
        $I->see('Logout');

        $I->amGoingTo('try to login with the user is logged in');
        $I->amOnPage(Url::toRoute('/site/login'));
        $I->dontSee('Login', 'h1');

        $I->amGoingTo('logout');
        $I->click('Logout');

        $I->expectTo('see home page');
        $I->see('Congratulations!');
    }
}
