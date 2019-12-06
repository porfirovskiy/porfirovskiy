<?php

use yii\db\Migration;

/**
 * Class m191206_195304_AddTranslitTitleToTag
 */
class m191206_195304_AddTranslitTitleToTag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('{{%tags}}', 'translit_title', $this->string(50)->after('title'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tags}}', 'translit_title');
    }
}
