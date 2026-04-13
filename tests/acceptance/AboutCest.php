<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\acceptance;

use app\tests\support\AcceptanceTester;
use yii\helpers\Url;

/**
 * Acceptance tests for the about page.
 */
final class AboutCest
{
    public function ensureThatAboutWorks(AcceptanceTester $I): void
    {
        $I->amOnPage(Url::toRoute('/site/about'));
        $I->see('About', 'h1');
    }
}
