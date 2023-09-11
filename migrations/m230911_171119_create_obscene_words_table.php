<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%obscene_words}}`.
 */
class m230911_171119_create_obscene_words_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%obscene_words}}', [
            'id' => $this->primaryKey(),
            'word' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%obscene_words}}');
    }
}
