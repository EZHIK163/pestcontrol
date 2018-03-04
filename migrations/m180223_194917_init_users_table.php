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


        $this->addForeignKey('users_created_by', 'auth.users',
            'created_by', 'auth.users', 'id');

        $this->addForeignKey('users_updated_by', 'auth.users',
            'updated_by', 'auth.users', 'id');
    }

    public function down()
    {
        $this->dropTable('users');

        return false;
    }

}
