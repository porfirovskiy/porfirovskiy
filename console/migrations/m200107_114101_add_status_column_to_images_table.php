<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%images}}`.
 */
class m200107_114101_add_status_column_to_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%images}}', 'status', 'ENUM("public", "private") NOT NULL DEFAULT "public" AFTER `user_id`');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%images}}', 'status');
    }
}
