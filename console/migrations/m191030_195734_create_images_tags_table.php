<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%images_tags}}`.
 */
class m191030_195734_create_images_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%images_tags}}', [
            'id' => $this->primaryKey(),
            'image_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull()
        ]);
        
        $this->addForeignKey(
            'fkImageId',
            'images_tags',
            'image_id',
            'images',
            'id',
            'CASCADE',
            'CASCADE'
        );
        
        $this->addForeignKey(
            'fkTagId',
            'images_tags',
            'tag_id',
            'tags',
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
        $this->dropTable('{{%images_tags}}');
    }
}
