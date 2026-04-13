<?php

declare(strict_types=1);

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\tests\unit\migrations;

use app\migrations\M260330000000CreateUserTable;
use Yii;

/**
 * Unit tests for {@see \app\migrations\M260330000000CreateUserTable} migration.
 */
final class CreateUserTableTest extends \Codeception\Test\Unit
{
    public function testSafeDownDropsUserTable(): void
    {
        $db = Yii::$app->db;

        $schema = $db->schema;

        // table exists before migration down.
        $schema->refresh();

        verify($schema->getTableSchema('{{%user}}'))
            ->notNull(
                "Failed asserting that 'user' table exists before 'safeDown'.",
            );

        $migration = new M260330000000CreateUserTable(['db' => $db]);

        $migration->down();
        $schema->refresh();

        verify($schema->getTableSchema('{{%user}}'))
            ->null(
                "Failed asserting that 'user' table is dropped after 'safeDown'.",
            );

        // recreate the table for subsequent tests.
        $migration->up();
        $schema->refresh();

        verify($schema->getTableSchema('{{%user}}'))
            ->notNull(
                "Failed asserting that 'user' table is recreated after 'safeUp'.",
            );
    }

    public function testSafeUpCreatesUserTable(): void
    {
        $db = Yii::$app->db;

        $schema = $db->schema;

        $schema->refresh();

        $tableSchema = $schema->getTableSchema('{{%user}}');

        self::assertNotNull(
            $tableSchema,
            "Failed asserting that 'user' table exists after 'safeUp'.",
        );

        $columns = $tableSchema->columns;
        $expectedColumns = [
            'id',
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email',
            'status',
            'created_at',
            'updated_at',
            'verification_token',
        ];

        foreach ($expectedColumns as $column) {
            self::assertArrayHasKey(
                $column,
                $columns,
                "Failed asserting that '$column' column exists.",
            );
        }

        // verify primary key.
        self::assertSame(
            ['id'],
            $tableSchema->primaryKey,
            "Failed asserting that 'primary key' is 'id'.",
        );
        // verify NOT NULL constraints.
        self::assertFalse(
            $columns['username']->allowNull ?? true,
            "Failed asserting that 'username' is 'NOT NULL'.",
        );
        self::assertFalse(
            $columns['auth_key']->allowNull ?? true,
            "Failed asserting that 'auth_key' is 'NOT NULL'.",
        );
        self::assertFalse(
            $columns['password_hash']->allowNull ?? true,
            "Failed asserting that 'password_hash' is 'NOT NULL'.",
        );
        self::assertFalse(
            $columns['email']->allowNull ?? true,
            "Failed asserting that 'email' is 'NOT NULL'.",
        );
        self::assertFalse(
            $columns['status']->allowNull ?? true,
            "Failed asserting that 'status' is 'NOT NULL'.",
        );
        self::assertFalse(
            $columns['created_at']->allowNull ?? true,
            "Failed asserting that 'created_at' is 'NOT NULL'.",
        );
        self::assertFalse(
            $columns['updated_at']->allowNull ?? true,
            "Failed asserting that 'updated_at' is 'NOT NULL'.",
        );
        // verify nullable token columns.
        self::assertTrue(
            $columns['password_reset_token']->allowNull ?? false,
            "Failed asserting that 'password_reset_token' is 'nullable'.",
        );
        self::assertTrue(
            $columns['verification_token']->allowNull ?? false,
            "Failed asserting that 'verification_token' is 'nullable'.",
        );
        // verify status defaults to inactive (`9`).
        self::assertEquals(
            9,
            $columns['status']->defaultValue ?? null,
            "Failed asserting that 'status' defaults to '9' ('inactive').",
        );
    }
}
