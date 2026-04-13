<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\functional;

use app\tests\support\FunctionalTester;
use yii\helpers\Url;

/**
 * Functional tests for {@see \app\controllers\SiteController::actionContact()} contact form.
 */
final class ContactFormCest
{
    public function _before(FunctionalTester $I): void
    {
        $I->amOnPage(Url::toRoute('/site/contact'));
    }

    public function openContactPage(FunctionalTester $I): void
    {
        $I->see('Contact', 'h1');
    }

    public function submitEmptyForm(FunctionalTester $I): void
    {
        $I->submitForm(
            '#contact-form',
            [],
        );
        $I->expectTo('see validations errors');
        $I->see('Contact', 'h1');
        $I->see('Name cannot be blank');
        $I->see('Email cannot be blank');
        $I->see('Phone cannot be blank');
        $I->see('Subject cannot be blank');
        $I->see('Body cannot be blank');
        $I->see('The verification code is incorrect');
    }

    public function submitFormSuccessfully(FunctionalTester $I): void
    {
        $I->submitForm(
            '#contact-form',
            [
                'ContactForm[name]' => 'tester',
                'ContactForm[email]' => 'tester@example.com',
                'ContactForm[phone]' => '(555) 123-4567',
                'ContactForm[subject]' => 'test subject',
                'ContactForm[body]' => 'test content',
                'ContactForm[verifyCode]' => 'testme',
            ],
        );
        $I->seeEmailIsSent();
        $I->dontSeeElement('#contact-form');
        $I->see('Thank you for contacting us. We will respond to you as soon as possible.');
    }

    public function submitFormWithIncorrectEmail(FunctionalTester $I): void
    {
        $I->submitForm(
            '#contact-form',
            [
                'ContactForm[name]' => 'tester',
                'ContactForm[email]' => 'tester.email',
                'ContactForm[phone]' => '(555) 123-4567',
                'ContactForm[subject]' => 'test subject',
                'ContactForm[body]' => 'test content',
                'ContactForm[verifyCode]' => 'testme',
            ],
        );
        $I->expectTo('see that email address is wrong');
        $I->dontSee('Name cannot be blank.', '.invalid-feedback');
        $I->see('Email is not a valid email address.');
        $I->dontSee('Subject cannot be blank.', '.invalid-feedback');
        $I->dontSee('Body cannot be blank.', '.invalid-feedback');
        $I->dontSee('The verification code is incorrect.', '.invalid-feedback');
    }
}
