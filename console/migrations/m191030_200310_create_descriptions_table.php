<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%descriptions}}`.
 */
class m191030_200310_create_descriptions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%descriptions}}', [
            'id' => $this->primaryKey(),
            'title' => $this->text()->notNull(),
            'image_id' => $this->integer()->notNull()
        ]);
        
        $this->addForeignKey(
            'fkDescriptionsImageId',
            'descriptions',
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
        $this->dropTable('{{%descriptions}}');
    }
}
