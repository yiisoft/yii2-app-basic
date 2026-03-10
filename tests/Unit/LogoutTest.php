<?php

declare(strict_types=1);

namespace app\tests\Unit;

use app\controllers\SiteController;
use app\models\User;
use Yii;
use yii\web\IdentityInterface;
use yii\web\View;

final class LogoutTest extends \Codeception\Test\Unit
{
    public function testRenderLogoutLinkWhenUserIsLoggedIn(): void
    {
        $user = User::findIdentity('100');

        $controller = new SiteController('site', Yii::$app, Yii::$app->mailer);

        Yii::$app->controller = $controller;

        $view = new View(['context' => $controller]);

        self::assertNotNull(
            $user,
            "Failed asserting that the user identity with ID '100' exists.",
        );
        self::assertInstanceOf(
            IdentityInterface::class,
            $user,
            "Failed asserting that the identity is an instance of 'Identity' class.",
        );

        Yii::$app->user->login($user);

        self::assertStringContainsString(
            '<a class="logout nav-link" href="/index-test.php?r=site%2Flogout" data-method="post">Logout (admin)</a>',
            $view->render('//layouts/main.php', ['content' => 'Hello World°']),
            'Failed asserting that the logout link is rendered for a logged-in user.',
        );

        $controller->actionLogout();

        self::assertStringNotContainsString(
            '<a class="logout nav-link" href="/index-test.php?r=site%2Flogout" data-method="post">Logout (admin)</a>',
            $view->render('//layouts/main.php', ['content' => 'Hello World°']),
            'Failed asserting that the logout link is rendered for a logged-in user.',
        );
    }
}
