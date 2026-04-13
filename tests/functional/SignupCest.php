<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\functional;

use app\models\User;
use app\tests\support\FunctionalTester;
use yii\helpers\Url;

/**
 * Functional tests for {@see \app\controllers\UserController::actionSignup()} signup form.
 */
final class SignupCest
{
    private string $formId = '#form-signup';

    public function _before(FunctionalTester $I): void
    {
        $I->amOnPage(Url::toRoute('/user/signup'));
    }

    public function signupSuccessfully(FunctionalTester $I): void
    {
        $I->submitForm(
            $this->formId,
            [
                'SignupForm[username]' => 'tester',
                'SignupForm[email]' => 'tester.email@example.com',
                'SignupForm[password]' => 'tester_password',
            ],
        );

        $I->seeRecord(
            User::class,
            [
                'username' => 'tester',
                'email' => 'tester.email@example.com',
                'status' => User::STATUS_INACTIVE,
            ],
        );

        $I->seeEmailIsSent();
        $I->see('Thank you for registration. Please check your inbox for verification email.');
    }

    public function signupWithEmptyFields(FunctionalTester $I): void
    {
        $I->see('Create a new account', 'h1');
        $I->see('Fill out the fields below to get started');
        $I->submitForm(
            $this->formId,
            [],
        );
        $I->see('Username cannot be blank.', '.invalid-feedback');
        $I->see('Email cannot be blank.', '.invalid-feedback');
        $I->see('Password cannot be blank.', '.invalid-feedback');
    }

    public function signupWithWrongEmail(FunctionalTester $I): void
    {
        $I->submitForm(
            $this->formId,
            [
                'SignupForm[username]' => 'tester',
                'SignupForm[email]' => 'ttttt',
                'SignupForm[password]' => 'tester_password',
            ],
        );
        $I->dontSee('Username cannot be blank.', '.invalid-feedback');
        $I->dontSee('Password cannot be blank.', '.invalid-feedback');
        $I->see('Email is not a valid email address.', '.invalid-feedback');
    }
}
