<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\unit\migrations;

use app\migrations\M260403000000CreateAdminUser;
use app\models\User;
use Yii;

/**
 * Unit tests for {@see M260403000000CreateAdminUser} migration.
 */
final class CreateAdminUserTest extends \Codeception\Test\Unit
{
    public function testSafeDownDeletesAdminUser(): void
    {
        $db = Yii::$app->db;
        $migration = new M260403000000CreateAdminUser(['db' => $db]);

        $migration->up();

        $admin = User::find()->where(['username' => 'admin'])->one();

        verify($admin)
            ->notNull(
                "Failed asserting that 'admin' user exists after 'safeUp'.",
            );

        $migration->down();

        $admin = User::find()->where(['username' => 'admin'])->one();

        verify($admin)
            ->null(
                "Failed asserting that 'admin' user is deleted after 'safeDown'.",
            );
    }

    public function testSafeUpCreatesAdminUser(): void
    {
        $db = Yii::$app->db;

        // clean up if admin already exists from fixtures.
        $db->createCommand()->delete('{{%user}}', ['username' => 'admin'])->execute();

        $migration = new M260403000000CreateAdminUser(['db' => $db]);

        $migration->up();

        $admin = User::find()->where(['username' => 'admin'])->one();

        self::assertInstanceOf(
            User::class,
            $admin,
            "Failed asserting that fixture user 'admin' exists.",
        );

        verify($admin)
            ->notNull(
                "Failed asserting that 'admin' user exists after 'safeUp'.",
            );
        verify($admin->username)
            ->equals(
                'admin',
                "Failed asserting that 'username' is 'admin'.",
            );
        verify($admin->email)
            ->equals(
                'admin@example.com',
                "Failed asserting that 'email' is 'admin@example.com'.",
            );
        verify($admin->status)
            ->equals(
                User::STATUS_ACTIVE,
                "Failed asserting that 'status' is 'active'.",
            );
        verify(Yii::$app->security->validatePassword('admin', $admin->password_hash))
            ->true(
                "Failed asserting that 'admin' password is 'admin'.",
            );

        // clean up for other tests.
        $migration->down();
    }
}
