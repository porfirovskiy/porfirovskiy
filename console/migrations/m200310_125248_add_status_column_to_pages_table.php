<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%pages}}`.
 */
class m200310_125248_add_status_column_to_pages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%pages}}', 'status', 'ENUM("public", "private") NOT NULL DEFAULT "public" AFTER `content`');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%images}}', 'status');
    }
}
