<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\functional;

use app\models\User;
use app\tests\support\Fixtures\UserFixture;
use app\tests\support\FunctionalTester;
use PHPUnit\Framework\Assert;
use yii\base\Event;
use yii\base\ModelEvent;
use yii\db\BaseActiveRecord;
use yii\helpers\Url;

/**
 * Functional tests for {@see \app\controllers\UserController::actionVerifyEmail()} email verification.
 */
final class VerifyEmailCest
{
    /**
     * @return array{user: array{class: string, dataFile: string}}
     */
    public function _fixtures(): array
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                // @phpstan-ignore-next-line
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ];
    }

    public function checkAlreadyActivatedToken(FunctionalTester $I): void
    {
        $user = User::findOne(['username' => 'test2.test']);

        Assert::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'test2.test' exists.",
        );

        $I->amOnPage(Url::toRoute(['/user/verify-email', 'token' => $user->verification_token]));
        $I->canSee('Wrong verify email token.');
    }

    public function checkEmptyToken(FunctionalTester $I): void
    {
        $I->amOnPage(Url::toRoute(['/user/verify-email', 'token' => '']));
        $I->canSee('Verify email token cannot be blank.');
    }

    public function checkInvalidToken(FunctionalTester $I): void
    {
        $I->amOnPage(Url::toRoute(['/user/verify-email', 'token' => 'wrong_token']));
        $I->canSee('Wrong verify email token.');
    }

    public function checkNoToken(FunctionalTester $I): void
    {
        $I->amOnPage(Url::toRoute('/user/verify-email'));
        $I->canSee('Missing required parameters: token');
    }

    public function checkSuccessVerification(FunctionalTester $I): void
    {
        $user = User::findOne(['username' => 'test.test']);

        Assert::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'test.test' exists.",
        );

        $I->amOnPage(Url::toRoute(['/user/verify-email', 'token' => $user->verification_token]));
        $I->canSee('Your email has been confirmed!');
        $I->seeRecord(
            User::class,
            [
                'username' => 'test.test',
                'email' => 'test.test@example.com',
                'status' => User::STATUS_ACTIVE,
            ],
        );
    }

    public function checkVerificationFailsWhenSaveErrors(FunctionalTester $I): void
    {
        $user = User::findOne(['username' => 'test.test']);

        Assert::assertInstanceOf(
            User::class,
            $user,
            "Failed asserting that fixture user 'test.test' exists.",
        );

        // force `save()` to fail via `EVENT_BEFORE_UPDATE` at the class level.
        $handler = static function (ModelEvent $event): void {
            $event->isValid = false;
        };

        Event::on(User::class, BaseActiveRecord::EVENT_BEFORE_UPDATE, $handler);

        try {
            $I->amOnPage(Url::toRoute(['/user/verify-email', 'token' => $user->verification_token]));
            $I->canSee('Sorry, we are unable to verify your account with provided token.');
        } finally {
            Event::off(User::class, BaseActiveRecord::EVENT_BEFORE_UPDATE, $handler);
        }
    }
}
