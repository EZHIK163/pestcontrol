<?php

use yii\db\Migration;

/**
 * Class m181210_060600_fix_foreign_key
 */
class m181210_060600_fix_foreign_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('customer_contact_id_file_customer', 'customer_contact');
        $this->addForeignKey(
            'customer_contact_id_customer',
            'customer_contact',
            'id_customer',
            'customers',
            'id'
        );

        $this->addForeignKey(
            'file_customer_id_customer',
            'file_customer',
            'id_customer',
            'customers',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('customer_contact_id_customer', 'customer_contact');
        $this->addForeignKey(
            'customer_contact_id_file_customer',
            'customer_contact',
            'id_customer',
            'customers',
            'id'
        );

        $this->dropForeignKey('file_customer_id_customer', 'file_customer');

        return true;
    }
}
