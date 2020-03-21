<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page_comments}}`.
 */
class m200321_195056_create_page_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page_comments}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'comment' => $this->text()->notNull(),
            'page_id' => $this->integer()->notNull(),
            'created' => $this->dateTime()->notNull()
        ]);

        $this->addForeignKey(
            'fkCommentsPageId',
            'page_comments',
            'page_id',
            'pages',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page_comments}}');
    }
}
