<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\support\Fixtures;

use app\models\User;
use yii\test\ActiveFixture;

/**
 * Provides user fixture data for authentication tests.
 */
final class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
}
