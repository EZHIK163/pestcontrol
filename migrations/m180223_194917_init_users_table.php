<?php

use yii\db\Migration;

/**
 * Class m180223_194917_init_users_table
 */
class m180223_194917_init_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180223_194917_init_users_table cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('users',
            [
                'id'        => 'pk',
                'username'  => 'string UNIQUE',
                'password'  => 'string',
                'auth_key'  => 'string UNIQUE'
            ]
        );
    }

    public function down()
    {
        $this->dropTable('users');

        return false;
    }

}
