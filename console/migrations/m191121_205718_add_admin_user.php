<?php

use yii\db\Migration;

/**
 * Class m191121_205718_add_admin_user
 */
class m191121_205718_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('user', [
            'username' => 'admin',
            'auth_key' => 'i92wh4jp8m7KinJlzHIZiyxmprpGdwQC',
            'password_hash' => '$2y$13$mnvwFfLvW.swBLjXN5INYOnFSn7tnFWdIoAp3urHrc/0lfPETzEtq',
            'email' => 'img2user@gmail.com',
            'status' => 10,
            'created_at' => 0,
            'updated_at' => 0
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('user', ['email' => 'img2user@gmail.com']);
    }
}
