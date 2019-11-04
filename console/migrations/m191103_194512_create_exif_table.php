<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%exif}}`.
 */
class m191103_194512_create_exif_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%exif}}', [
            'id' => $this->primaryKey(),
            'image_id' => $this->integer()->notNull(),
        ]);
        
        $this->addForeignKey(
            'fkCommentsImageId',
            'exif',
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
        $this->dropTable('{{%exif}}');
    }
}
