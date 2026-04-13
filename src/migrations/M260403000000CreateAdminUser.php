<?php

declare(strict_types=1);

namespace app\migrations;

use app\models\User;
use yii\db\Migration;

/**
 * Seeds the default administrator user.
 */
final class M260403000000CreateAdminUser extends Migration
{
    public function safeDown(): bool
    {
        $this->delete('{{%user}}', ['username' => \Yii::$app->params['admin.username']]);

        return true;
    }

    public function safeUp(): bool
    {
        $time = time();

        $this->insert(
            '{{%user}}',
            [
                'username' => \Yii::$app->params['admin.username'],
                'auth_key' => \Yii::$app->security->generateRandomString(),
                'password_hash' => \Yii::$app->security->generatePasswordHash(
                    \Yii::$app->params['admin.password'],
                ),
                'email' => \Yii::$app->params['admin.email'],
                'status' => User::STATUS_ACTIVE,
                'created_at' => $time,
                'updated_at' => $time,
            ],
        );

        return true;
    }
}
