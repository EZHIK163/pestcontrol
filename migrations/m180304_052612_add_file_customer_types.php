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
        $file_customer_type = new \app\models\customer\FileCustomerType();
        $file_customer_type->description = 'Рекомендации';
        $file_customer_type->code = 'recommendations';
        $file_customer_type->save();

        $file_customer_type = new \app\models\customer\FileCustomerType();
        $file_customer_type->description = 'Схемы контрольных точек';
        $file_customer_type->code = 'scheme_point_control';
        $file_customer_type->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $file_customer_type = \app\models\customer\FileCustomerType::findOne(['code' => 'recommendations']);
        $file_customer_type->delete();

        $file_customer_type = \app\models\customer\FileCustomerType::findOne(['code'    => 'scheme_control_points']);
        $file_customer_type->delete();

        return false;
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
