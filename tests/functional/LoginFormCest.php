<?php
class LoginFormCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnPage(['site/login']);
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('Login', 'h1');

    }

    // demonstrates `amLoggedAs` method
    public function internalLoginById(\FunctionalTester $I)
    {
        $I->amLoggedAs(100);
        $I->amOnPage('/');
        $I->see('Logout (admin)');
    }

    // demonstrates `amLoggedAs` method
    public function internalLoginBy(\FunctionalTester $I)
    {
        $I->amLoggedAs(\app\models\User::findByUsername('admin'));
        $I->amOnPage('/');
        $I->see('Logout (admin)');
    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function loginWithWringCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'admin',
            'LoginForm[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Incorrect username or password.');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'admin',
            'LoginForm[password]' => 'admin',
        ]);
        $I->see('Logout (admin)');
        $I->dontSeeElement('form#login-form');              
    }
}