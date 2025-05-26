<?php

declare(strict_types=1);

use yii\helpers\Url;

final class AboutCest
{
    public function ensureThatAboutWorks(AcceptanceTester $I): void
    {
        $I->amOnPage(Url::toRoute('/site/about'));
        $I->see('About', 'h1');
    }
}
