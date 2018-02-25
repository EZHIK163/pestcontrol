<?php

use yii\db\Migration;

/**
 * Class m180225_135735_set_schema_auth
 */
class m180225_135735_set_schema_auth extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "CREATE SCHEMA auth";
        $this->execute($sql);

        $sql = "ALTER TABLE public.auth_assignment SET SCHEMA auth";
        $this->execute($sql);

        $sql = "ALTER TABLE public.auth_item SET SCHEMA auth";
        $this->execute($sql);

        $sql = "ALTER TABLE public.auth_item_child SET SCHEMA auth";
        $this->execute($sql);

        $sql = "ALTER TABLE public.auth_rule SET SCHEMA auth";
        $this->execute($sql);

        $sql = "ALTER TABLE auth.auth_assignment RENAME TO assignment";
        $this->execute($sql);

        $sql = "ALTER TABLE auth.auth_item RENAME TO item";
        $this->execute($sql);

        $sql = "ALTER TABLE auth.auth_item_child RENAME TO item_child";
        $this->execute($sql);

        $sql = "ALTER TABLE auth.auth_rule RENAME TO rule";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180225_135735_set_schema_auth cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180225_135735_set_schema_auth cannot be reverted.\n";

        return false;
    }
    */
}
