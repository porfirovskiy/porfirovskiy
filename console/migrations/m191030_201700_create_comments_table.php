<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m191030_201700_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'comment' => $this->text()->notNull(),
            'image_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->null(),
            'created' => $this->dateTime()->notNull()
        ]);
        
        $this->addForeignKey(
            'fkCommentsImageId',
            'comments',
            'image_id',
            'images',
            'id',
            'CASCADE',
            'CASCADE'
        );
        
        $this->addForeignKey(
            'fkCommentsUserId',
            'comments',
            'user_id',
            'user',
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
        $this->dropTable('{{%comments}}');
    }
}
