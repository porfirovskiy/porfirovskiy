<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%images}}`.
 */
class m191029_203433_create_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        
        // Проверка на дубликаты по хешу!!!!!
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'translit_name' => $this->string()->notNull(),
            'origin_name' => $this->string()->notNull(),
            'path' => $this->string()->notNull(),
            'hash' => $this->string(40)->notNull(),
            'source' => $this->string()->null(),
            'width' => $this->smallInteger()->notNull(),
            'hight' => $this->smallInteger()->notNull(),
            'size' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created' => $this->dateTime()->notNull()
        ], $tableOptions);
        
        $this->addForeignKey(
            'fkImagesUserId',
            'images',
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
        $this->dropTable('{{%images}}');
    }
}
