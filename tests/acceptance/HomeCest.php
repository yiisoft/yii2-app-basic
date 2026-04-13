<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\acceptance;

use app\tests\support\AcceptanceTester;
use Yii;
use yii\helpers\Url;

/**
 * Acceptance tests for the home page and extension grid.
 */
final class HomeCest
{
    public function ensureThatExtensionGridIsRendered(AcceptanceTester $I): void
    {
        $I->amOnPage(Url::toRoute('/site/index'));

        $I->seeElement('.extension-card');
        $I->see('yii2-debug');
        $I->seeLink('Learn more »');
    }

    public function ensureThatHomePageWorks(AcceptanceTester $I): void
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see(Yii::$app->name);

        $I->seeLink('About');
        $I->click('About');

        $I->see('This is the About page.');
    }
}
