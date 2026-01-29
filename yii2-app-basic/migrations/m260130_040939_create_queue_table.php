<?php

use yii\db\Migration;

/**
 * Class m260130_040939_create_queue_table
 */
class m260130_040939_create_queue_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%queue}}', [
            'id' => $this->primaryKey(),
            'channel' => $this->string()->notNull(),
            'job' => $this->binary()->notNull(),
            'ttr' => $this->integer()->notNull(),
            'delay' => $this->integer()->notNull()->defaultValue(0),
            'priority' => $this->integer()->notNull()->defaultValue(1024),
            'pushed_at' => $this->integer()->notNull(),
            'done_at' => $this->integer()->null(),
        ]);
        $this->createIndex('idx-queue-channel', '{{%queue}}', 'channel');
        $this->createIndex('idx-queue-done_at', '{{%queue}}', 'done_at');
    }

    public function safeDown()
    {
        $this->dropTable('{{%queue}}');
    }
}
