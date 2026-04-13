<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Echoes the first argument that you have entered.
 *
 * Provided as an example for learning how to create console commands.
 */
final class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     *
     * @param string $message The message to be echoed.
     *
     * @return int Exit code
     */
    public function actionIndex(string $message = 'hello world'): int
    {
        echo "{$message}\n";

        return ExitCode::OK;
    }
}
