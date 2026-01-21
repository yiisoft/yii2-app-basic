<?php

declare(strict_types=1);

use app\tests\Support\AcceptanceTester;
use yii\helpers\Url;

final class HomeCest
{
    public function ensureThatHomePageWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see('My Company');

        $I->seeLink('About');
        $I->click('About');

        # $I->wait(2); // wait for page to be opened --- use in webdriver ---

        $I->see('This is the About page.');
    }
}
