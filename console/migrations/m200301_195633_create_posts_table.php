<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts}}`.
 */
class m200301_195633_create_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pages}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
            'created' => $this->dateTime()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pages}}');
    }
}
