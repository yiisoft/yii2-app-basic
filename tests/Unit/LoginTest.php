<?php

declare(strict_types=1);

namespace app\tests\Unit;

use app\controllers\SiteController;
use app\models\User;
use Yii;
use yii\console\Application;
use yii\web\View;

use function dirname;

final class LoginTest extends \Codeception\Test\Unit
{
    public function testRenderLoginWrongUsername(): void
    {
        $controller = new SiteController('site', Yii::$app);

        Yii::$app->controller = $controller;

        $view = new View(['context' => $controller]);

        Yii::$app->user->login(new User());

        $controller->actionLogin();

        self::assertStringNotContainsString(
            '<button type="submit" class="nav-link btn btn-link logout">Logout (admin)</button>',
            $view->render('//layouts/main.php', ['content' => 'Hello World°']),
            'Failed asserting that the logout link is rendered for a logged-in user.',
        );
    }
}
