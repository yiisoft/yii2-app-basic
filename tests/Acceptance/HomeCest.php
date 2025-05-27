<?php

declare(strict_types=1);

use yii\helpers\Url;

final class HomeCest
{
    public function ensureThatHomePageWorks(AcceptanceTester $I): void
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see('My Company');

        $I->seeLink('About');
        $I->click('About');

        $I->expectTo('see About page');
        $I->see('This is the About page.');
    }
}
