<?php

use yii\db\Migration;

/**
 * Class m190213_190924_add_field_is_delete_to_file_customer
 */
class m190213_190924_add_field_is_delete_to_file_customer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('public.file_customer', 'is_enable', $this->boolean()->notNull()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('public.file_customer', 'is_enable');

        return true;
    }
}
