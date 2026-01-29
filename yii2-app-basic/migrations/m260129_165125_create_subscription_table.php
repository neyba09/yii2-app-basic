<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscription}}`.
 */
class m260129_165125_create_subscription_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('subscription', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'guest_phone' => $this->string(20)->notNull(),
            'created_at' => $this->integer(),
        ]);

        $this->addForeignKey('fk_subscription_author', 'subscription', 'author_id', 'author', 'id', 'CASCADE');
        $this->createIndex('idx_subscription_author_phone', 'subscription', ['author_id', 'guest_phone'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_subscription_author_phone', '{{%subscription}}');
        $this->dropForeignKey('fk_subscription_author', '{{%subscription}}');
        $this->dropTable('{{%subscription}}');
    }
}
