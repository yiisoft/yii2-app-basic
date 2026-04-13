<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\unit;

use app\controllers\SiteController;
use app\controllers\UserController;
use app\tests\support\Fixtures\UserFixture;
use Yii;
use yii\web\View;

/**
 * Unit tests for {@see \app\controllers\UserController} login action and {@see \app\controllers\SiteController} about
 * action.
 */
final class LoginTest extends \Codeception\Test\Unit
{
    /**
     * @return array{user: array{class: string, dataFile: string}}
     */
    public function _fixtures(): array
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                // @phpstan-ignore binaryOp.invalid
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ];
    }

    public function testActionAboutRendersPage(): void
    {
        $controller = new SiteController(
            'site',
            Yii::$app,
            Yii::$app->mailer,
        );

        Yii::$app->controller = $controller;

        $output = $controller->actionAbout();

        self::assertStringContainsString(
            'About',
            $output,
            'Failed asserting that about page renders content with "About" text.',
        );
    }

    public function testRenderLoginForGuest(): void
    {
        $controller = new UserController(
            'user',
            Yii::$app,
            Yii::$app->mailer,
        );

        $view = new View(['context' => $controller]);

        Yii::$app->user->logout();

        $output = $view->render('//layouts/main.php', ['content' => 'Hello World']);

        self::assertStringContainsString(
            'Login',
            $output,
            'Failed asserting that the login link is rendered for guests.',
        );
        self::assertStringNotContainsString(
            'Logout (',
            $output,
            'Failed asserting that the logout link is not rendered for guests.',
        );
    }
}
