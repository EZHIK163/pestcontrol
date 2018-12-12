<?php

use yii\db\Migration;

/**
 * Class m180225_105304_add_customers
 */
class m180225_105304_add_customers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'customers',
            [
                'id'            => 'pk',
                'name'          => 'string',
                'id_user_owner' => 'integer',
                'created_at'    => 'integer',
                'created_by'    => 'integer',
                'updated_at'    => 'integer',
                'updated_by'    => 'integer'
            ]
        );

        $this->addForeignKey(
            'customer_created_by',
            'customers',
            'created_by',
            'users',
            'id'
        );

        $this->addForeignKey(
            'customer_updated_by',
            'customers',
            'updated_by',
            'users',
            'id'
        );

        $this->addForeignKey(
            'customer_id_user_owner',
            'customers',
            'id_user_owner',
            'users',
            'id'
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('customers');
        $this->dropForeignKey('customer_updated_by', 'customers');
        $this->dropForeignKey('customer_created_by', 'customers');
        return true;
    }


    // Use up()/down() to run migration code without a transaction.
//    public function up()
//    {
//
//    }
//
//    public function down()
//    {
//
//    }
}
