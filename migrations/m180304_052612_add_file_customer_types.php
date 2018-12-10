<?php

use yii\db\Migration;

/**
 * Class m180304_052612_add_file_customer_types
 */
class m180304_052612_add_file_customer_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $file_customer_type = new \app\entities\FileCustomerType();
        $file_customer_type->description = 'Рекомендации';
        $file_customer_type->code = 'recommendations';
        $file_customer_type->save();

        $file_customer_type = new \app\entities\FileCustomerType();
        $file_customer_type->description = 'Схемы контрольных точек';
        $file_customer_type->code = 'scheme_point_control';
        $file_customer_type->save();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $file_customer_type = \app\entities\FileCustomerType::findOne(['code' => 'recommendations']);
        $file_customer_type->delete();

        $file_customer_type = \app\entities\FileCustomerType::findOne(['code'    => 'scheme_point_control']);
        $file_customer_type->delete();

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180304_052612_add_file_customer_types cannot be reverted.\n";

        return false;
    }
    */
}
