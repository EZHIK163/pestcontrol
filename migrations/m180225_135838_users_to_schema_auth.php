<?php

use yii\db\Migration;

/**
 * Class m180225_135838_users_to_schema_auth
 */
class m180225_135838_users_to_schema_auth extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "ALTER TABLE public.users SET SCHEMA auth";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180225_135838_users_to_schema_auth cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180225_135838_users_to_schema_auth cannot be reverted.\n";

        return false;
    }
    */
}
