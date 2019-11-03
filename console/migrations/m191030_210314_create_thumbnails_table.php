<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%thumbnails}}`.
 */
class m191030_210314_create_thumbnails_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%thumbnails}}', [
            'id' => $this->primaryKey(),
            'path' => $this->string()->notNull(),
            'type' => 'ENUM("small", "medium", "big")',
            'width' => $this->smallInteger()->notNull(),
            'hight' => $this->smallInteger()->notNull(),
            'size' => $this->integer()->notNull(),
            'image_id' => $this->integer()->notNull()
        ]);
        
    $this->addForeignKey(
            'fkThumbnailsImageId',
            'thumbnails',
            'image_id',
            'images',
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
        $this->dropTable('{{%thumbnails}}');
    }
}
