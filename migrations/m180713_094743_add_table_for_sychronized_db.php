<?php

use yii\db\Migration;

/**
 * Class m180713_094743_add_table_for_sychronized_db
 */
class m180713_094743_add_table_for_sychronized_db extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('synchronize_history', [
            'id'                => 'pk',
            'is_active'         => 'boolean DEFAULT true',
            'count_sync_row'    => 'integer',
            'created_at'        => 'integer',
            'created_by'        => 'integer',
            'updated_at'        => 'integer',
            'updated_by'        => 'integer'
        ]);

        //MSMR Делаем запись с времени последней миграции
        $sync = new \app\models\service\SynchronizeRecord();

        $sync->count_sync_row = 0;

        $sync->save();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('synchronize_history');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180713_094743_add_table_for_sychronized_db cannot be reverted.\n";

        return false;
    }
    */
}
