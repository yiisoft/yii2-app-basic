<?php

class AboutCest
{
    public function ensureThatAboutWorks(AcceptanceTester $I)
    {
        //$I->amOnPage(['site/about']);
        $I->amOnPage('index.php?r=site%2Fabout');
        $I->see('About', 'h1');
    }
}
