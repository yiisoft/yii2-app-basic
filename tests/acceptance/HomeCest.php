<?php

class HomeCest
{
    public function ensureThatHomePageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('index.php?r=site%2Findex');        
        $I->see('My Company');
        
        $I->seeLink('About');
        $I->click('About');
        
        $I->see('This is the About page.');
    }
}
