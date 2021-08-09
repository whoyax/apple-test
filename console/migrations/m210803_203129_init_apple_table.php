<?php

use yii\db\Migration;

/**
 * Class m210803_203129_init_apple_table
 */
class m210803_203129_init_apple_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('apple',
            [
               'id' => $this->primaryKey(),
               'color' => $this->string(50)->notNull(),
               'created_at' => $this->timestamp()->notNull(),
               'fallen_at' => $this->timestamp()->defaultValue(null),
               'state' => $this->tinyInteger()->defaultValue(1),
               'health' => $this->tinyInteger()->defaultValue(100)
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('apple');

        return false;
    }
}
