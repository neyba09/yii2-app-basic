<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m260129_164845_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'year' => $this->integer(),
            'description' => $this->text(),
            'isbn' => $this->string(),
            'cover_photo' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book}}');
    }
}
