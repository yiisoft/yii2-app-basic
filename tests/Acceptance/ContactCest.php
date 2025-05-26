<?php

declare(strict_types=1);

use yii\helpers\Url;

final class ContactCest
{
    public function _before(\AcceptanceTester $I): void
    {
        $I->amOnPage(Url::toRoute('/site/contact'));
    }

    public function contactPageWorks(AcceptanceTester $I): void
    {
        $I->wantTo('ensure that contact page works');
        $I->see('Contact', 'h1');
    }

    public function contactFormCanBeSubmitted(AcceptanceTester $I): void
    {
        $I->amGoingTo('submit contact form with correct data');
        $I->fillField('#contactform-name', 'tester');
        $I->fillField('#contactform-email', 'tester@example.com');
        $I->fillField('#contactform-subject', 'test subject');
        $I->fillField('#contactform-body', 'test content');
        $I->fillField('#contactform-verifycode', 'testme');

        $I->click('contact-button');

        $I->expectTo('see message about successful sending');
        $I->dontSeeElement('#contact-form');
        $I->see('Thank you for contacting us. We will respond to you as soon as possible.');
    }
}
