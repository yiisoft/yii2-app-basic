<?php

declare(strict_types=1);

namespace app\migrations;

use yii\db\Migration;

/**
 * Creates the `user` table for database-backed authentication.
 */
final class M260330000000CreateUserTable extends Migration
{
    public function safeDown(): void
    {
        $this->dropTable('{{%user}}');
    }

    public function safeUp(): void
    {
        $this->createTable(
            '{{%user}}',
            [
                'id' => $this->primaryKey(),
                'username' => $this->string()->notNull()->unique(),
                'auth_key' => $this->string(32)->notNull(),
                'password_hash' => $this->string()->notNull(),
                'password_reset_token' => $this->string()->unique(),
                'email' => $this->string()->notNull()->unique(),
                'status' => $this->smallInteger()->notNull()->defaultValue(9),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
                'verification_token' => $this->string()->unique()->defaultValue(null),
            ],
        );
    }
}
