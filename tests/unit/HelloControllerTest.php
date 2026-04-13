<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\unit;

use app\commands\HelloController;
use Codeception\Test\Unit;
use yii\base\InvalidRouteException;
use yii\console\Application;
use yii\console\Exception;
use yii\console\ExitCode;

use function ob_get_clean;
use function ob_start;

/**
 * Unit tests for {@see HelloController} output behavior.
 */
final class HelloControllerTest extends Unit
{
    /**
     * @throws Exception if an unexpected error occurs during execution.
     * @throws InvalidRouteException if the action route is invalid.
     */
    public function testIndexActionOutputsCustomMessage(): void
    {
        $application = new Application(['id' => 'test', 'basePath' => dirname(__DIR__, 2)]);
        $helloController = new HelloController('hello', $application);

        ob_start();
        $exitCode = $helloController->runAction('index', ['custom message']);
        $result = ob_get_clean();

        self::assertSame("custom message\n", $result);
        self::assertSame(ExitCode::OK, $exitCode);
    }

    /**
     * @throws Exception if an unexpected error occurs during execution.
     * @throws InvalidRouteException if the action route is invalid.
     */
    public function testIndexActionOutputsDefaultMessage(): void
    {
        $application = new Application(['id' => 'test', 'basePath' => dirname(__DIR__, 2)]);
        $helloController = new HelloController('hello', $application);

        ob_start();
        $exitCode = $helloController->runAction('index');
        $result = ob_get_clean();

        self::assertSame("hello world\n", $result);
        self::assertSame(ExitCode::OK, $exitCode);
    }
}
