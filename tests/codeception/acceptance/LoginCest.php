<?php

class LoginCest
{
    public function ensureThatLoginWorks(AcceptanceTester $I)
    {
        //$I->amOnPage(['site/login']);
        $I->amOnPage('index.php?r=site%2Flogin');
        $I->see('Login', 'h1');

        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->fillField('input[name="LoginForm[password]"]', 'admin');
        $I->click('login-button');

        $I->expectTo('see user info');
        $I->see('Logout (admin)');
    }
}
