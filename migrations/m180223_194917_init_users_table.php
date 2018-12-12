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
        $this->createTable(
            'users',
            [
                'id'        => 'pk',
                'is_active' => 'boolean DEFAULT true',
                'username'  => 'string UNIQUE',
                'password'  => 'string',
                'auth_key'  => 'string UNIQUE',
                'created_at'                => 'integer',
                'created_by'                => 'integer',
                'updated_at'                => 'integer',
                'updated_by'                => 'integer'
            ]
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');

        return true;
    }


    // Use up()/down() to run migration code without a transaction.
//    public function up()
//    {
//
//
//    }
//
//    public function down()
//    {
//        $this->dropTable('users');
//
//        return false;
//    }
}
