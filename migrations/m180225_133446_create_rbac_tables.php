<?php

use yii\db\Migration;

/**
 * Class m180225_133446_create_rbac_tables
 */
class m180225_133446_create_rbac_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "CREATE SCHEMA auth";
        $this->execute($sql);

        //./yii migrate --migrationPath=@yii/rbac/migrations
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }


//    // Use up()/down() to run migration code without a transaction.
//    public function up()
//    {
//
//    }
//
//    public function down()
//    {
//        echo "m180225_133446_create_rbac_tables cannot be reverted.\n";
//
//        return false;
//    }
}
