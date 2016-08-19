<?php
use yii\helpers\Url as Url;

class HomeCest
{
    public function ensureThatHomePageWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));        
        $I->see('My Company');
        
        $I->seeLink('About');
        $I->click('About');
        
        $I->see('This is the About page.');
    }
}
