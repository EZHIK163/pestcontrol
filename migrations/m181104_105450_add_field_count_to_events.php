<?php

use yii\db\Migration;

/**
 * Class m181104_105450_add_field_count_to_events
 */
class m181104_105450_add_field_count_to_events extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "ALTER TABLE public.events ADD COLUMN count integer default 0";

        $this->db->createCommand($sql)->query();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181104_105450_add_field_count_to_events cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181104_105450_add_field_count_to_events cannot be reverted.\n";

        return false;
    }
    */
}
