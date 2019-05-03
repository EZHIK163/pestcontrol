<?php

use yii\db\Migration;

/**
 * Class m180509_070815_create_contact_customer
 */
class m180509_070815_create_contact_customer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('customer_contact', [
            'id'            => 'pk',
            'is_active'     => 'boolean DEFAULT true',
            'id_customer'   => 'integer',
            'name'          => 'string',
            'email'         => 'string',
            'phone'         => 'string',
            'created_at'    => 'integer',
            'created_by'    => 'integer',
            'updated_at'    => 'integer',
            'updated_by'    => 'integer'
        ]);

        $this->addForeignKey(
            'customer_contact_id_file_customer',
            'customer_contact',
            'id_customer',
            'customers',
            'id'
        );

        $this->addForeignKey(
            'customer_contact_created_by',
            'customer_contact',
            'created_by',
            'auth.users',
            'id'
        );

        $this->addForeignKey(
            'customer_contact_updated_by',
            'customer_contact',
            'updated_by',
            'auth.users',
            'id'
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('customer_contact');

        $this->dropForeignKey('customer_contact_id_file_customer', 'customer_contact');

        $this->dropForeignKey('customer_contact_created_by', 'customer_contact');

        $this->dropForeignKey('customer_contact_updated_by', 'customer_contact');

        return true;
    }
}
