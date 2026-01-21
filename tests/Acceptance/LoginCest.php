<?php

declare(strict_types=1);

use app\tests\Support\AcceptanceTester;
use yii\helpers\Url;

final class LoginCest
{
    public function ensureThatLoginWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/login'));
        $I->see('Login', 'h1');

        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->fillField('input[name="LoginForm[password]"]', 'admin');
        $I->click('login-button');

        # $I->wait(2); // wait for button to be clicked --- use in webdriver ---

        $I->expectTo('see user info');
        $I->see('Logout');
    }
}
